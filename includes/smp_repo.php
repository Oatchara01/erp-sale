<?php

/**
 * Persistence / preview helpers ของใบเบิกสินค้าเพื่อสนับสนุนการขาย (SMP)
 * ใช้ร่วมกันโดย register_supsmp1.php (Submit), register_supsmp_draft1.php (Save Draft)
 * และ report_sample.php (Preview ก่อนบันทึก)
 *
 * - Draft = hos__smp.status_sup = 'Draft' (send_sup = 0) เลข RSMP ถูกจองจริงตั้งแต่ Save Draft ครั้งแรก
 * - Submit = status_sup = 'Request' (send_sup = 1) เหมือน flow เดิมของ register_supsmp1.php
 * - ทุกการเขียนอยู่ใน DB transaction เดียว (hos__smp / hos__subsmp / tb_register_data / tb_transaction)
 */

class SmpValidationException extends Exception
{
}

function smp_post($key, $default = '')
{
	if (!isset($_POST[$key]) || is_array($_POST[$key])) {
		return $default;
	}
	return trim((string)$_POST[$key]);
}

function smp_esc($conn, $value)
{
	return mysqli_real_escape_string($conn, (string)$value);
}

function smp_flag($key)
{
	return smp_post($key) === '1' ? '1' : '0';
}

/**
 * ตัวเลือก "วิธีการจัดส่ง" ของ SMP — key = ค่าที่เก็บใน hos__smp.delivery_type, ลำดับ = ลำดับที่แสดง
 * 1/2 คงความหมายเดิม (หน้า edit/approve เดิมอ่านค่านี้) ส่วน 3/4 เพิ่มใหม่ — ต่างจาก Change Order ที่ 2 = ช่างรับเอง, 4 = บริษัทจัดส่ง
 * ทุกหน้าที่แสดง/รับ delivery_type ของ SMP ต้องดึงรายการจากที่นี่ที่เดียว
 */
function smp_delivery_type_options()
{
	return array('1' => 'Sale รับเอง', '3' => 'ช่างรับเอง', '4' => 'ลูกค้ารับเอง', '2' => 'บริษัทจัดส่ง');
}

/** บริษัทของใบ SMP: '2' = NBM, นอกนั้น '1' = AWL (กันค่าแปลกจาก browser) */
function smp_company_from_post()
{
	return smp_post('type_company') === '2' ? '2' : '1';
}

function smp_valid_date($value)
{
	return (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$value) && checkdate((int)substr($value, 5, 2), (int)substr($value, 8, 2), (int)substr($value, 0, 4));
}

/** เลข RSMP ถัดไป (ปีพ.ศ. 2 หลัก + เดือน + running 4 หลัก) — logic เดียวกับหน้าเดิม */
function smp_next_ref_id($conn, $forUpdate = false)
{
	$yearMonth = substr(date('Y') + 543, -2) . date('m');
	$query = mysqli_query($conn, 'SELECT MAX(ref_idsmp) AS MAXID FROM hos__smp' . ($forUpdate ? ' FOR UPDATE' : ''));
	$row = $query ? mysqli_fetch_assoc($query) : array();
	$maxRef = (string)($row['MAXID'] ?? '');
	$maxRunning = (int)substr($maxRef, -4);
	$maxMonth = substr(substr($maxRef, -8), 0, -4);
	$running = ($maxMonth === $yearMonth) ? $maxRunning + 1 : 1;
	return 'RSMP' . $yearMonth . substr('0000' . $running, -4);
}

function smp_load_document($conn, $refId)
{
	$stmt = mysqli_prepare($conn, 'SELECT * FROM hos__smp WHERE ref_idsmp = ? LIMIT 1');
	mysqli_stmt_bind_param($stmt, 's', $refId);
	mysqli_stmt_execute($stmt);
	$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
	mysqli_stmt_close($stmt);
	return $row ?: null;
}

/**
 * หาใบสั่งขาย (so__main) จาก ref_id — ใช้ทั้งตอนเปิดหน้าสร้างด้วย ?ref_id= และตอนบันทึก
 * คืน array('ref_idsale' => ..., 'order_id' => ...) หรือ null ถ้าไม่พบ; order_id มาจากฐานข้อมูลเสมอ ไม่เชื่อค่าจาก browser
 */
function smp_lookup_sale_order($conn, $refIdSale)
{
	$refIdSale = trim((string)$refIdSale);
	if ($refIdSale === '' || !ctype_digit($refIdSale)) {
		return null;
	}
	$stmt = mysqli_prepare($conn, 'SELECT ref_id, order_id FROM so__main WHERE ref_id = ? LIMIT 1');
	mysqli_stmt_bind_param($stmt, 's', $refIdSale);
	mysqli_stmt_execute($stmt);
	$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
	mysqli_stmt_close($stmt);
	if (!$row) {
		return null;
	}
	return array('ref_idsale' => (string)$row['ref_id'], 'order_id' => trim((string)$row['order_id']));
}

/** ค่า CRM ที่ normalize แล้ว: เปิด CRM = เก็บเลขอ้างอิง, ปิด = ล้างค่าเพื่อกันค่าค้าง */
function smp_crm_from_post()
{
	$on = smp_flag('crm_ckk') === '1';
	return array('crm_ckk' => $on ? '1' : '0', 'crm_ref' => $on ? smp_post('crm_ref') : '');
}

function smp_load_row($conn, $table, $refColumn, $refId)
{
	$stmt = mysqli_prepare($conn, "SELECT * FROM {$table} WHERE {$refColumn} = ? ORDER BY 1 DESC LIMIT 1");
	mysqli_stmt_bind_param($stmt, 's', $refId);
	mysqli_stmt_execute($stmt);
	$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
	mysqli_stmt_close($stmt);
	return $row ?: null;
}

function smp_load_items($conn, $refId)
{
	$stmt = mysqli_prepare($conn, 'SELECT s.*, p.access_code, p.sol_name, p.unit_name FROM hos__subsmp s
		LEFT JOIN tb_product p ON p.product_ID = s.product_id WHERE s.reff_idsmp = ? ORDER BY s.subsmp_id ASC');
	mysqli_stmt_bind_param($stmt, 's', $refId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$rows = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	mysqli_stmt_close($stmt);
	return $rows;
}

/**
 * products[n][...] จากฟอร์ม → รายการที่ผ่านการ normalize (ข้ามแถวที่ไม่มีสินค้า)
 * ไม่จำกัดจำนวนแถว — ลำดับตามลำดับ <tr> ใน DOM
 */
function smp_collect_products_from_post()
{
	$raw = isset($_POST['products']) && is_array($_POST['products']) ? $_POST['products'] : array();
	$products = array();
	foreach ($raw as $row) {
		if (!is_array($row)) {
			continue;
		}
		$field = function ($key) use ($row) {
			return isset($row[$key]) && !is_array($row[$key]) ? trim((string)$row[$key]) : '';
		};
		$productId = $field('product_id');
		if ($productId === '' || !ctype_digit($productId)) {
			continue;
		}
		$count = (float)str_replace(',', '', $field('sale_count'));
		$price = (float)str_replace(',', '', $field('unit_price'));
		$brNo = $field('br_no');
		$products[] = array(
			'product_id'   => $productId,
			'access_code'  => $field('product_code'),
			'product_name' => $field('product_name'),
			'unit_name'    => $field('unit_name'),
			'sale_count'   => $count,
			'unit_price'   => $price,
			'sum_amount'   => round($count * $price, 2),
			'sale_remark'  => $field('sale_remark'),
			'waranty'      => $field('waranty'),
			'sn'           => $field('sn'),
			'br_no'        => $brNo,
			'clear_br'     => ($brNo !== '' || $field('clear_br') === '1') ? '1' : '0',
		);
	}
	return $products;
}

/**
 * แตกสินค้าที่เป็นชุด (tb_probom_online) เป็นรายการย่อยเหมือนเดิม — รายการแรกของชุดได้ราคา/ยอดรวม
 * ที่เหลือ 0.00 ผลลัพธ์นี้คือแถวที่จะลง hos__subsmp และแสดงในใบพิมพ์
 */
function smp_expand_products($conn, array $products)
{
	$rows = array();
	foreach ($products as $product) {
		$bomStmt = mysqli_prepare($conn, 'SELECT * FROM tb_probom_online WHERE id_bompro = ? LIMIT 1');
		mysqli_stmt_bind_param($bomStmt, 's', $product['product_id']);
		mysqli_stmt_execute($bomStmt);
		$bom = mysqli_fetch_assoc(mysqli_stmt_get_result($bomStmt));
		mysqli_stmt_close($bomStmt);

		$base = array(
			'sale_remark' => $product['sale_remark'],
			'waranty'     => $product['waranty'],
			'clear_br'    => $product['clear_br'],
			'br_no'       => $product['br_no'],
		);

		if (!$bom) {
			$rows[] = $base + array(
				'product_id' => $product['product_id'],
				'sale_count' => $product['sale_count'],
				'unit_price' => $product['unit_price'],
				'sum_amount' => $product['sum_amount'],
				'sn'         => $product['sn'],
			);
			continue;
		}

		$first = true;
		for ($i = 1; $i <= 10; $i++) {
			$componentId = trim((string)($bom['id_product' . $i] ?? ''));
			if ($componentId === '') {
				continue;
			}
			$rows[] = $base + array(
				'product_id' => $componentId,
				'sale_count' => $product['sale_count'] * (float)($bom['unit' . $i] ?? 0),
				'unit_price' => $first ? $product['unit_price'] : 0,
				'sum_amount' => $first ? $product['sum_amount'] : 0,
				/* SN เป็นของเครื่องจริง ลงเฉพาะรายการแรกของชุดเหมือน unit_price — ถ้าคัดลอกลงทุกชิ้นส่วน
				   โค้ดกระทบยอดเคลียร์ยืมจะนับ SN เดียวกันซ้ำหลายรอบ */
				'sn'         => $first ? $product['sn'] : '',
			);
			$first = false;
		}
	}
	return $rows;
}

function smp_validate_submit(array $products)
{
	$required = array(
		array('sale_code', 'กรุณาเลือกแผนก/เขตการขาย'),
		array('smp_date', 'กรุณาระบุวันที่เอกสาร'),
		array('customer_name', 'กรุณาใส่ชื่อลูกค้า'),
		array('cus_tel', 'กรุณาใส่เบอร์โทรศัพท์ลูกค้า'),
		array('address_name', 'กรุณาใส่ที่อยู่ลูกค้า'),
		array('cus_province', 'กรุณาเลือกจังหวัดลูกค้า'),
		array('cus_ampher', 'กรุณาใส่เขต/อำเภอลูกค้า'),
		array('cus_postcode', 'กรุณาใส่รหัสไปรษณีย์ลูกค้า'),
		array('start_time', 'กรุณาใส่เวลาส่ง'),
		array('customer_name1', 'กรุณาใส่ชื่อผู้ติดต่อ'),
		array('customer_tel', 'กรุณาใส่เบอร์โทรลูกค้า'),
		array('address_1', 'กรุณาใส่สถานที่ส่งสินค้า'),
		array('address_name1', 'กรุณาใส่ที่อยู่ในการส่งสินค้า'),
		array('address_send', 'กรุณาใส่สถานที่ติดตั้งเครื่อง'),
		array('province_name', 'กรุณาเลือกจังหวัดที่ต้องการจัดส่ง'),
	);
	foreach ($required as $rule) {
		if (smp_post($rule[0]) === '') {
			throw new SmpValidationException($rule[1]);
		}
	}
	if (!smp_valid_date(smp_post('smp_date'))) {
		throw new SmpValidationException('วันที่เอกสารไม่ถูกต้อง');
	}
	if (!preg_match('/^\d{5}$/', smp_post('cus_postcode'))) {
		throw new SmpValidationException('รหัสไปรษณีย์ต้องเป็นตัวเลข 5 หลัก');
	}
	if (smp_crm_from_post()['crm_ckk'] === '1' && smp_post('crm_ref') === '') {
		throw new SmpValidationException('กรุณาระบุเลขที่อ้างอิง (CRM) เมื่อเลือกแลกสินค้า CRM');
	}
	if (count($products) === 0) {
		throw new SmpValidationException('กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ');
	}
	foreach ($products as $index => $product) {
		$label = 'รายการที่ ' . ($index + 1);
		if ($product['sale_count'] <= 0) {
			throw new SmpValidationException($label . ': กรุณาระบุจำนวนสินค้า');
		}
		if ($product['waranty'] === '' || !preg_match('/^\d+$/', $product['waranty'])) {
			throw new SmpValidationException($label . ': กรุณาระบุจำนวนปีรับประกันเป็นตัวเลข (กดปุ่มแก้ไขที่แถวสินค้า)');
		}
	}
}

/**
 * ตรวจไฟล์แนบ (สูงสุด 3 ช่อง JPG/PNG/PDF ≤ 1MB ตรวจ MIME จริง + นามสกุล) ยังไม่ย้ายไฟล์ —
 * คืนแผนให้ smp_persist_from_post() ย้ายหลัง INSERT/UPDATE สำเร็จแล้วเท่านั้น
 */
function smp_plan_uploads($existing)
{
	$allowed = array(
		'jpg'  => array('image/jpeg'),
		'jpeg' => array('image/jpeg'),
		'png'  => array('image/png'),
		'pdf'  => array('application/pdf'),
	);
	$maxBytes = 1048576;

	foreach ($_FILES as $key => $file) {
		if (!preg_match('/^up_img[1-3]$/', $key)) {
			$hasFile = is_array($file['error'] ?? null)
				? count(array_filter($file['error'], function ($e) { return $e !== UPLOAD_ERR_NO_FILE; })) > 0
				: (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE);
			if ($hasFile) {
				throw new SmpValidationException('แนบไฟล์ได้สูงสุด 3 ไฟล์');
			}
		}
	}

	$plan = array('names' => array(), 'moves' => array(), 'delete' => array());
	$finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;

	for ($i = 1; $i <= 3; $i++) {
		$key = 'up_img' . $i;
		$old = $existing ? trim((string)$existing[$key]) : '';
		$file = $_FILES[$key] ?? null;
		$hasUpload = $file && !is_array($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE;

		if ($hasUpload) {
			$label = 'ไฟล์แนบช่องที่ ' . $i;
			if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
				throw new SmpValidationException($label . ': ขนาดไฟล์เกิน 1MB');
			}
			if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
				throw new SmpValidationException($label . ': อัปโหลดไม่สำเร็จ กรุณาลองใหม่');
			}
			if ($file['size'] > $maxBytes) {
				throw new SmpValidationException($label . ': ขนาดไฟล์เกิน 1MB');
			}
			$extension = strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));
			if (!isset($allowed[$extension])) {
				throw new SmpValidationException($label . ': รองรับเฉพาะไฟล์ JPG, PNG หรือ PDF');
			}
			$mime = $finfo ? finfo_file($finfo, $file['tmp_name']) : '';
			if (!in_array($mime, $allowed[$extension], true)) {
				throw new SmpValidationException($label . ': เนื้อหาไฟล์ไม่ตรงกับนามสกุล (รองรับเฉพาะ JPG, PNG, PDF)');
			}
			$storedName = date('YmdHis') . '_' . $i . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
			$plan['names'][$i] = $storedName;
			$plan['moves'][] = array('tmp' => $file['tmp_name'], 'name' => $storedName);
			if ($old !== '') {
				$plan['delete'][] = $old;
			}
		} elseif ($existing && smp_post('remove_up_img' . $i) === '1') {
			$plan['names'][$i] = '';
			if ($old !== '') {
				$plan['delete'][] = $old;
			}
		} else {
			$plan['names'][$i] = $old;
		}
	}
	if ($finfo) {
		finfo_close($finfo);
	}
	return $plan;
}

function smp_upload_dir()
{
	return dirname(__DIR__) . '/smp_up/';
}

function smp_db_insert($conn, $table, array $data)
{
	$columns = array();
	$values = array();
	foreach ($data as $column => $value) {
		$columns[] = '`' . $column . '`';
		$values[] = "'" . smp_esc($conn, $value) . "'";
	}
	if (!mysqli_query($conn, "INSERT INTO {$table} (" . implode(',', $columns) . ') VALUES (' . implode(',', $values) . ')')) {
		throw new RuntimeException($table . ': ' . mysqli_error($conn));
	}
}

function smp_db_update($conn, $table, array $data, $whereColumn, $whereValue)
{
	$sets = array();
	foreach ($data as $column => $value) {
		$sets[] = '`' . $column . "` = '" . smp_esc($conn, $value) . "'";
	}
	$sql = "UPDATE {$table} SET " . implode(', ', $sets) . " WHERE `{$whereColumn}` = '" . smp_esc($conn, $whereValue) . "'";
	if (!mysqli_query($conn, $sql)) {
		throw new RuntimeException($table . ': ' . mysqli_error($conn));
	}
}

/** UPDATE ถ้ามีแถวของ ref นี้อยู่แล้ว ไม่งั้น INSERT — Save Draft ซ้ำบนเลขเดิมจึงไม่เกิดแถวซ้ำ */
function smp_db_upsert($conn, $table, $refColumn, $refId, array $data)
{
	$stmt = mysqli_prepare($conn, "SELECT 1 FROM {$table} WHERE {$refColumn} = ? LIMIT 1");
	mysqli_stmt_bind_param($stmt, 's', $refId);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$exists = mysqli_stmt_num_rows($stmt) > 0;
	mysqli_stmt_close($stmt);

	if ($exists) {
		smp_db_update($conn, $table, $data, $refColumn, $refId);
	} else {
		smp_db_insert($conn, $table, array($refColumn => $refId) + $data);
	}
}

/** ค่าจากฟอร์มที่ map ลง tb_register_data (ข้อมูลจัดส่ง/ผู้ติดต่อ/ที่อยู่) */
function smp_register_data_from_post($refId, $addDate, $productSummary, $session)
{
	$startDate = smp_post('start_date');
	return array(
		'start_date'        => smp_valid_date($startDate) ? $startDate : '0000-00-00',
		'between_date'      => smp_post('between_date'),
		'start_time'        => smp_post('start_time'),
		'end_time'          => smp_post('end_time'),
		'status'            => smp_post('status'),
		'fix_date'          => smp_flag('fix_datetime'),
		'no_price'          => smp_flag('no_money'),
		'call_customer'     => smp_flag('call_customer'),
		'credit'            => '0',
		'call_employee'     => smp_flag('call_back'),
		'cash'              => '0',
		'check_peper'       => '0',
		'bill'              => '0',
		'department'        => smp_post('department_name'),
		'type_customer'     => smp_post('customer_typename'),
		'type_company'      => smp_company_from_post(),
		'customer_name'     => smp_post('customer_name1'),
		'customer_tel'      => smp_post('customer_tel'),
		'address_name'      => smp_post('address_name1'),
		'address_send'      => smp_post('address_send'),
		'want_bus'          => smp_flag('want_bus'),
		'product_name'      => $productSummary,
		'product_sn'        => $refId,
		'employee_name'     => smp_post('employee_name'),
		'employee_tel'      => smp_post('employee_tel'),
		'add_by'            => smp_post('add_by'),
		'description'       => smp_post('comment_sale'),
		'have_map'          => '0',
		'add_date'          => $addDate,
		'tran'              => '0',
		'check_detail'      => '0',
		'dep'               => '0',
		'department_show'   => smp_post('department_show'),
		'status_comment'    => smp_post('status_comment'),
		'on_time'           => smp_flag('on_time'),
		'address_1'         => smp_post('address_1'),
		'add_code'          => (string)($session['emid'] ?? ''),
		'province_name'     => smp_post('province_name'),
		'location_link'     => smp_post('location_link'),
		'transport_company' => smp_post('transport_company'),
	);
}

/** ค่าจากแท็บ "รายละเอียดที่อยู่" → tb_transaction (mapping เดียวกับ register_suprental1.php) */
function smp_transaction_from_post($addDate)
{
	$join = function ($parts) {
		return trim(implode(' x ', array_filter($parts, function ($p) { return $p !== ''; })));
	};
	$entrance = smp_post('entrance_type', '1');
	return array(
		'car_home'        => smp_post('park_front', '1') === '1' ? '1' : '0',
		'car_park'        => smp_post('park_location'),
		'slope'           => $entrance === '1' ? '1' : '0',
		'bundai'          => $entrance === '2' ? '1' : '0',
		'unit_bundai'     => smp_post('stair_count'),
		'install'         => smp_post('install_floor'),
		'install_room'    => smp_post('room_type'),
		'room_bigger'     => smp_post('door_width'),
		'room_longer'     => smp_post('door_height'),
		'bundai_big'      => $join(array(smp_post('stair_width'), smp_post('stair_height'))),
		'lip_big'         => $join(array(smp_post('elev_door_width'), smp_post('elev_door_height'))),
		'lip_long'        => $join(array(smp_post('elev_width'), smp_post('elev_height'), smp_post('elev_depth'))),
		'lip_weight'      => smp_post('elev_capacity'),
		'want_employee'   => smp_post('move_furn') === '1' ? '1' : '0',
		'employee_unit'   => smp_post('move_furn_count'),
		'ferniger_name'   => smp_post('move_furn_detail'),
		'description'     => smp_post('addr_note'),
		'height_ltd'      => smp_flag('is_high_roof'),
		'add_date'        => $addDate,
		'add_by'          => smp_post('add_by'),
	);
}

/**
 * บันทึกเอกสารจากฟอร์ม
 * $mode = 'draft' (ไม่ validate ข้อมูล) | 'submit' (validate เต็ม, สถานะ Request)
 *         | 'update' (แก้เอกสารสถานะ Request เดิม: validate เต็ม คงสถานะ/ข้อมูลส่งอนุมัติ/ผู้ขอเดิม)
 * @return array ['ref_id' => ..., 'created' => bool]
 */
function smp_persist_from_post($conn, $mode, array $session)
{
	$isDraft = ($mode === 'draft');
	$isUpdate = ($mode === 'update');
	$products = smp_collect_products_from_post();

	$existing = null;
	$existingRef = smp_post('ref_idsmp');
	if ($existingRef !== '') {
		$existing = smp_load_document($conn, $existingRef);
		if ($existing === null) {
			throw new SmpValidationException('ไม่พบเอกสารเลขที่ ' . $existingRef);
		}
		if ($isUpdate) {
			if ((string)$existing['status_sup'] !== 'Request') {
				throw new SmpValidationException('เอกสารนี้ไม่ได้อยู่ในสถานะ Request แล้ว ไม่สามารถแก้ไขจากหน้านี้ได้');
			}
		} elseif ((string)$existing['status_sup'] !== 'Draft') {
			throw new SmpValidationException('เอกสารนี้ถูกส่งแล้ว ไม่สามารถแก้ไขจากหน้านี้ได้ กรุณาแก้ไขที่หน้าแก้ไขเอกสาร');
		}
	} elseif ($isUpdate) {
		throw new SmpValidationException('ไม่พบเลขที่เอกสารที่ต้องการแก้ไข');
	}

	if (!$isDraft) {
		smp_validate_submit($products);
	}

	$smpDate = smp_post('smp_date');
	if (!smp_valid_date($smpDate)) {
		$smpDate = date('Y-m-d');
	}

	$crm = smp_crm_from_post();
	if (mb_strlen($crm['crm_ref'], 'UTF-8') > 300) {
		throw new SmpValidationException('เลขที่อ้างอิง (CRM) ยาวเกิน 300 ตัวอักษร');
	}
	/* Draft ไม่ผ่าน smp_validate_submit — กันข้อความยาวเกินคอลัมน์ทำให้ INSERT ล้ม */
	foreach (array('cus_province' => array('จังหวัด', 150), 'cus_ampher' => array('เขต/อำเภอ', 150), 'cus_postcode' => array('รหัสไปรษณีย์', 10)) as $field => $rule) {
		if (mb_strlen(smp_post($field), 'UTF-8') > $rule[1]) {
			throw new SmpValidationException($rule[0] . 'ลูกค้ายาวเกิน ' . $rule[1] . ' ตัวอักษร');
		}
	}

	/* ใบสั่งขายอ้างอิง: Draft ที่เคยผูกใบสั่งขายแล้วใช้ค่าเดิมในฐานข้อมูล ไม่ให้ browser เปลี่ยน;
	   order_id มาจาก so__main เสมอ ไม่เชื่อ order_id ที่ POST มา */
	$refIdSale = ($existing !== null && trim((string)$existing['ref_idsale']) !== '') ? trim((string)$existing['ref_idsale']) : smp_post('ref_idsale');
	$orderId = '';
	if ($refIdSale !== '') {
		$saleOrder = smp_lookup_sale_order($conn, $refIdSale);
		if ($saleOrder === null) {
			throw new SmpValidationException('ไม่พบใบสั่งขายอ้างอิงเลขที่ ' . $refIdSale);
		}
		$refIdSale = $saleOrder['ref_idsale'];
		$orderId = $saleOrder['order_id'];
	}

	$closeStmt = mysqli_prepare($conn, 'SELECT 1 FROM tb_closedoc WHERE close_mount = ? LIMIT 1');
	$closeMonth = substr($smpDate, 0, 7);
	mysqli_stmt_bind_param($closeStmt, 's', $closeMonth);
	mysqli_stmt_execute($closeStmt);
	mysqli_stmt_store_result($closeStmt);
	$monthClosed = mysqli_stmt_num_rows($closeStmt) > 0;
	mysqli_stmt_close($closeStmt);
	if ($monthClosed) {
		throw new SmpValidationException('ไม่สามารถบันทึกข้อมูลใบเบิกในเดือนนี้ได้เนื่องจากได้ทำการปิดเอกสารเรียบร้อยแล้ว');
	}

	$uploadPlan = smp_plan_uploads($existing);
	$movedFiles = array();
	$sessionName = (string)($session['name'] ?? '');
	$now = date('Y-m-d H:i:s');
	$today = date('Y-m-d');

	mysqli_begin_transaction($conn);
	try {
		$created = ($existing === null);
		$refId = $created ? smp_next_ref_id($conn, true) : (string)$existing['ref_idsmp'];
		if (!$created) {
			/* ล็อกแถว + ตรวจสถานะซ้ำใน transaction — กันเอกสารที่เปลี่ยนสถานะระหว่างเปิดหน้า */
			$lockStmt = mysqli_prepare($conn, 'SELECT status_sup FROM hos__smp WHERE ref_idsmp = ? FOR UPDATE');
			mysqli_stmt_bind_param($lockStmt, 's', $refId);
			mysqli_stmt_execute($lockStmt);
			mysqli_stmt_bind_result($lockStmt, $lockedStatus);
			$lockFound = mysqli_stmt_fetch($lockStmt);
			mysqli_stmt_close($lockStmt);
			if (!$lockFound || (string)$lockedStatus !== ($isUpdate ? 'Request' : 'Draft')) {
				throw new SmpValidationException($isUpdate
					? 'เอกสารนี้ถูกเปลี่ยนสถานะแล้ว ไม่สามารถแก้ไขได้ กรุณาโหลดหน้าใหม่'
					: 'เอกสารนี้ถูกส่งแล้ว ไม่สามารถแก้ไขจากหน้านี้ได้ กรุณาแก้ไขที่หน้าแก้ไขเอกสาร');
			}
		}

		$startDate = smp_post('start_date');
		$shippingDate = smp_post('shipping_date');
		$header = array(
			'type_company'  => smp_company_from_post(),
			'smp_date'      => $smpDate,
			'bill_id'       => smp_post('customer_id'),
			'customer_name' => smp_post('customer_name'),
			'customer_tel'  => smp_post('cus_tel'),
			'address_name'  => smp_post('address_name'),
			'customer_province' => smp_post('cus_province'),
			'customer_ampher'   => smp_post('cus_ampher'),
			'customer_postcode' => smp_post('cus_postcode'),
			'comment_sale'  => smp_post('comment_sale'),
			'sale_name'     => $sessionName,
			'sale_code'     => smp_post('sale_code'),
			'sale_date'     => $today,
			'comment_sup'   => smp_post('comment_sup'),
			'delivery_type' => smp_post('delivery_type', '2'),
			'delivery_date' => smp_valid_date($startDate) ? $startDate : '0000-00-00',
			'date_send_key' => smp_post('between_date'),
			'brnp_ckk'      => smp_flag('brnp_ckk'),
			'brnp_no'       => smp_post('brnp_no'),
			'order_id'      => $orderId,
			'ref_idsale'    => $refIdSale,
			'crm_ckk'       => $crm['crm_ckk'],
			'crm_ref'       => $crm['crm_ref'],
			'have_order'    => smp_flag('have_order'),
			'date_ker'     => smp_valid_date($shippingDate) ? $shippingDate : '0000-00-00',
			'ker_bath'      => (string)(float)str_replace(',', '', smp_post('shipping_cost', '0')),
			'ref_no'        => smp_post('shipping_ref1'),
			'ref_no1'       => smp_post('shipping_ref2'),
			'allwell_ckk'   => in_array($sessionName, array('รุจิรา', 'ลักษณาวรรณ'), true) ? '1' : '0',
			'up_img1'       => $uploadPlan['names'][1],
			'up_img2'       => $uploadPlan['names'][2],
			'up_img3'       => $uploadPlan['names'][3],
		);
		if ($isUpdate) {
			/* คงสถานะ Request/ข้อมูลส่งอนุมัติ/ผู้ขอเดิม — ไม่เขียนทับ */
			unset($header['sale_name'], $header['sale_date'], $header['allwell_ckk']);
		} elseif ($isDraft) {
			$header += array('status_sup' => 'Draft', 'send_sup' => '0', 'sup_name' => '', 'sup_date' => '0000-00-00');
		} else {
			$header += array('status_sup' => 'Request', 'send_sup' => '1', 'sup_name' => $sessionName, 'sup_date' => $today);
		}

		if ($created) {
			smp_db_insert($conn, 'hos__smp', array(
				'ref_idsmp' => $refId,
				'add_by'    => smp_post('add_by'),
				'add_date'  => $now,
			) + $header);
		} else {
			smp_db_update($conn, 'hos__smp', $header, 'ref_idsmp', $refId);
		}

		$deleteStmt = mysqli_prepare($conn, 'DELETE FROM hos__subsmp WHERE reff_idsmp = ?');
		mysqli_stmt_bind_param($deleteStmt, 's', $refId);
		mysqli_stmt_execute($deleteStmt);
		mysqli_stmt_close($deleteStmt);

		foreach (smp_expand_products($conn, $products) as $row) {
			smp_db_insert($conn, 'hos__subsmp', array(
				'reff_idsmp'    => $refId,
				'product_id'    => $row['product_id'],
				'product_code'  => $row['product_id'],
				'sale_count'    => $row['sale_count'],
				'sale_countref' => $row['sale_count'],
				'unit_price'    => $row['unit_price'],
				'sum_amount'    => $row['sum_amount'],
				'sale_remark'   => $row['sale_remark'],
				'waranty'       => $row['waranty'] === '' ? '0' : $row['waranty'],
				'sn'            => $row['sn'],
				'clear_br'      => $row['clear_br'],
				'br_no'         => $row['br_no'],
			));
		}

		$summaryParts = array();
		foreach ($products as $product) {
			$summaryParts[] = trim($product['product_name'] . ' ' . (float)$product['sale_count'] . ' ' . $product['unit_name']);
		}
		$registerData = smp_register_data_from_post($refId, $now, implode(' ', $summaryParts), $session);
		$transactionData = smp_transaction_from_post($now);
		if ($isUpdate) {
			unset($registerData['add_by'], $registerData['add_date'], $registerData['add_code'], $transactionData['add_by'], $transactionData['add_date']);
		}
		smp_db_upsert($conn, 'tb_register_data', 'ref_id', $refId, $registerData);
		smp_db_upsert($conn, 'tb_transaction', 'ref_id', $refId, $transactionData);

		$dir = smp_upload_dir();
		foreach ($uploadPlan['moves'] as $move) {
			if (!move_uploaded_file($move['tmp'], $dir . $move['name'])) {
				throw new RuntimeException('ย้ายไฟล์แนบไม่สำเร็จ');
			}
			$movedFiles[] = $dir . $move['name'];
		}

		mysqli_commit($conn);
	} catch (Throwable $e) {
		mysqli_rollback($conn);
		foreach ($movedFiles as $path) {
			@unlink($path);
		}
		throw $e;
	}

	foreach ($uploadPlan['delete'] as $oldName) {
		$oldPath = smp_upload_dir() . basename($oldName);
		if (is_file($oldPath)) {
			@unlink($oldPath);
		}
	}

	return array('ref_id' => $refId, 'created' => $created);
}
