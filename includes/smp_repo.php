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
 * รหัสเดียวกับ register_suphos.php / js/delivery-transport.js (3/4 กำหนดตัวเลือก transport_company)
 * ใบเก่าที่บันทึกด้วยรหัสชุดเดิม (1 Sale รับเอง, 2 บริษัทจัดส่ง, 3 ช่างรับเอง, 4 ลูกค้ารับเอง) ไม่ถูก map — ต้องเลือกใหม่
 * ทุกหน้าที่แสดง/รับ delivery_type ของ SMP ต้องดึงรายการจากที่นี่ที่เดียว
 */
function smp_delivery_type_options()
{
	return array('3' => 'พนักงานรับ/ลูกค้ารับ', '5' => 'บริษัทจัดส่ง(AllWell)', '4' => 'บริษัทขนส่งภายนอก');
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
		'employee_name'     => (string)($session['name'] ?? ''),
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
			if (!in_array((string)$existing['status_sup'], array('Request', 'Returned'), true)) {
				throw new SmpValidationException('เอกสารนี้ไม่ได้อยู่ในสถานะ Request/Returned แล้ว ไม่สามารถแก้ไขจากหน้านี้ได้');
			}
		} elseif ((string)$existing['status_sup'] !== 'Draft' && ($isDraft || (string)$existing['status_sup'] !== 'Returned')) {
			throw new SmpValidationException('เอกสารนี้ถูกส่งแล้ว ไม่สามารถแก้ไขจากหน้านี้ได้ กรุณาแก้ไขที่หน้าแก้ไขเอกสาร');
		}
		if (!smp_user_can_edit_document($existing, $session)) {
			throw new SmpValidationException('คุณไม่มีสิทธิ์แก้ไขเอกสารนี้ในสถานะปัจจุบัน (Draft/Returned แก้ไขได้เฉพาะเจ้าของเอกสาร, Request แก้ไขได้เฉพาะผู้อนุมัติของด่านปัจจุบัน)');
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
			$allowedLocked = $isUpdate ? array('Request', 'Returned') : ($isDraft ? array('Draft') : array('Draft', 'Returned'));
			if (!$lockFound || !in_array((string)$lockedStatus, $allowedLocked, true)) {
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
			'delivery_type' => smp_post('delivery_type', ''),
			'delivery_date' => smp_valid_date($startDate) ? $startDate : '0000-00-00',
			'date_send_key' => smp_post('between_date'),
			'brnp_ckk'      => smp_flag('brnp_ckk'),
			'brnp_no'       => smp_post('brnp_no'),
			'order_id'      => $orderId,
			'ref_idsale'    => $refIdSale,
			'crm_ckk'       => $crm['crm_ckk'],
			'crm_ref'       => $crm['crm_ref'],
			'date_ker'     => smp_valid_date($shippingDate) ? $shippingDate : '0000-00-00',
			'ker_bath'      => (string)(float)str_replace(',', '', smp_post('shipping_cost', '0')),
			'ref_no'        => smp_post('shipping_ref1'),
			'ref_no1'       => smp_post('shipping_ref2'),
			'allwell_ckk'   => in_array($sessionName, array('รุจิรา', 'ลักษณาวรรณ'), true) ? '1' : '0',
			'up_img1'       => $uploadPlan['names'][1],
			'up_img2'       => $uploadPlan['names'][2],
			'up_img3'       => $uploadPlan['names'][3],
		);
		/* ช่วงเวลาจัดส่ง (sql/delivery_time_range.sql) — ใส่เฉพาะค่าที่รู้จักและเมื่อคอลัมน์มีจริง:
		   smp_db_insert/update ไม่ข้ามคอลัมน์ที่ไม่มี (จะ rollback ทั้ง save) และค่าว่างต้องไม่ล้างค่าที่บันทึกไว้ */
		$timeRange = smp_post('time_range');
		if (in_array($timeRange, array('morning', 'afternoon', 'allday', 'specific'), true)) {
			$timeRangeCheck = mysqli_query($conn, "SHOW COLUMNS FROM hos__smp LIKE 'time_range'");
			if ($timeRangeCheck && mysqli_num_rows($timeRangeCheck) > 0) {
				$header['time_range'] = $timeRange;
			}
		}
		if ($isUpdate) {
			/* คงสถานะ Request/ข้อมูลส่งอนุมัติ/ผู้ขอเดิม — ไม่เขียนทับ */
			unset($header['sale_name'], $header['sale_date'], $header['allwell_ckk']);
		} elseif ($isDraft) {
			$header += array('status_sup' => 'Draft', 'send_sup' => '0', 'sup_name' => '', 'sup_date' => '0000-00-00');
		} else {
			$header += array('status_sup' => 'Request', 'send_sup' => '1', 'sup_name' => $sessionName, 'sup_date' => $today);
			if ($existing !== null && (string)$existing['status_sup'] === 'Returned') {
				/* ส่งใหม่หลังถูกส่งกลับ — เคลียร์ flag ชั้นถัดไปให้เข้าคิวอนุมัติใหม่ตั้งแต่ต้น */
				$header += array('send_dm' => '0', 'send_stock' => '0', 'send_admin' => '0');
			}
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
			unset($registerData['add_by'], $registerData['add_date'], $registerData['add_code'], $registerData['employee_name'], $transactionData['add_by'], $transactionData['add_date']);
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

/* ===================================================================
 * Workflow อนุมัติด่าน sup ในหน้าฟอร์ม (register_supsmp.php)
 *
 * พอร์ตจาก register_engspr.php / spr_run_document_action() — ส่งกลับ / ไม่อนุมัติ / ยกเลิก /
 * อนุมัติ ผ่าน endpoint เดียว (register_supsmp_action1.php) ใน transaction เดียว
 * ตรวจสิทธิ์ฝั่ง server ทุก action (การซ่อนปุ่มในหน้าเป็นแค่ UX)
 *
 * ขอบเขต: ด่าน sup เท่านั้น (คิว status_sample_approve.php) — ด่าน DM/stock ยังใช้หน้าเดิม
 * ต้นทางของ logic อนุมัติ: sample_approve.php และ sample_approve1.php (หน้าเก่า ไม่ถูกแก้)
 * =================================================================== */

/** ชื่อผู้ใช้ที่ใช้ sample_approve1.php (สิทธิ์ตามชื่อ — supsmp_approve.php:77) */
function smp_amount_route_user_names()
{
	return array('รุจิรา', 'ลักษณาวรรณ');
}

/** sale_code ของใบที่ผู้ใช้ข้างบนใช้ sample_approve1.php (supsmp_approve.php:78) */
function smp_amount_route_sale_codes()
{
	return array('SOL1', 'SOL2', 'SOL99', 'SOL3', 'SOL4', 'SOL5', 'SOL91', 'SOL92', 'SOL93', 'SOL94', 'MK');
}

/**
 * ขอบเขตคิวอนุมัติ sup ของผู้ใช้ — Sup ทุกคนเห็น/อนุมัติได้ทุกเขตการขาย (ยกเลิกการแบ่งเขตตาม code เดิมแล้ว)
 * ใช้ทั้งหน้าคิวและ guard ของ action เพื่อให้ "เห็นในคิว = ทำได้" ตรงกันเสมอ
 * @return array ['type' => 'in'|'like'|'all', 'values' => array, 'status' => 'Request'|'Pending review']
 */
function smp_sup_queue_scope(array $session)
{
	$code = (string)($session['code'] ?? '');
	return array('type' => 'all', 'values' => array(), 'status' => ($code === 'SS5') ? 'Pending review' : 'Request');
}

/** ส่วน SQL ต่อท้าย WHERE ของคิว (constants ล้วน ไม่มีค่าจากผู้ใช้) — ' AND sale_code IN (...)' หรือ '' */
function smp_sup_queue_sql_filter(array $scope)
{
	if ($scope['type'] === 'in') {
		return " AND sale_code IN ('" . implode("','", $scope['values']) . "')";
	}
	if ($scope['type'] === 'like') {
		return " AND sale_code LIKE '%" . $scope['values'][0] . "%'";
	}
	return '';
}

/** sale_code ของใบอยู่ในขอบเขตคิวหรือไม่ (เทียบแบบไม่สนตัวพิมพ์เหมือน collation ของ MySQL) */
function smp_doc_in_sup_scope(array $doc, array $scope)
{
	$saleCode = strtolower(trim((string)($doc['sale_code'] ?? '')));
	if ($scope['type'] === 'in') {
		foreach ($scope['values'] as $value) {
			if (strtolower($value) === $saleCode) {
				return true;
			}
		}
		return false;
	}
	if ($scope['type'] === 'like') {
		return strpos($saleCode, strtolower($scope['values'][0])) !== false;
	}
	return true;
}

/**
 * ใบอยู่ด่าน sup — ตรงกับเงื่อนไขคิว: Request + send_sup=1 และยังไม่ส่งด่านถัดไป
 * ('Pending review' ของ SS5 ไม่อยู่ในขอบเขต — ไม่มีโค้ดใดเขียนสถานะนี้ให้ SMP จึงยังใช้หน้าเดิม)
 */
function smp_is_awaiting_sup(array $doc)
{
	return (string)($doc['status_sup'] ?? '') === 'Request'
		&& (string)($doc['send_sup'] ?? '') === '1'
		&& (string)($doc['send_dm'] ?? '') === '0'
		&& (string)($doc['send_stock'] ?? '') === '0'
		&& (string)($doc['send_admin'] ?? '') === '0';
}

/**
 * role ที่เข้าคิว sup ได้ — อนุมานจากเมนูที่ลิงก์ไป status_sample_approve.php (โค้ดเดิมไม่เคยเช็คสิทธิ์):
 * menu_suphos.php:57 → Sup_Sale, menu_supallwell.php:61 → Sup_AllWell, menu_it.php:80 → It เฉพาะ ชลชินี/อัจฉรา
 */
function smp_user_has_sup_role(array $session)
{
	$type = (string)($session['type_login'] ?? '');
	if ($type === 'Sup_en' || $type === 'owner') {
		return true;
	}
	return $type === 'It' && in_array((string)($session['name'] ?? ''), array('ชลชินี', 'อัจฉรา'), true);
}

function smp_user_can_act_on_sup_stage(array $doc, array $session)
{
	if (!smp_is_awaiting_sup($doc) || !smp_user_has_sup_role($session)) {
		return false;
	}
	$scope = smp_sup_queue_scope($session);
	return $scope['status'] === (string)$doc['status_sup'] && smp_doc_in_sup_scope($doc, $scope);
}

/**
 * ใบอยู่ด่าน DM — ตรงกับคิว status_smpapprove.php (Request + send_dm='1') และยังไม่ส่งคลัง/แอดมิน
 * (send_dm='1' กับ send_dm='0' ของด่าน sup ไม่ทับกัน)
 */
function smp_is_awaiting_dm(array $doc)
{
	return (string)($doc['status_sup'] ?? '') === 'Request'
		&& (string)($doc['send_dm'] ?? '') === '1'
		&& (string)($doc['send_stock'] ?? '') === '0'
		&& (string)($doc['send_admin'] ?? '') === '0';
}

/** ผู้ใช้ที่เข้าคิว DM ได้ — role It/owner และต้องมีชื่ออยู่ในรายชื่อที่กำหนด */
function smp_dm_role_names()
{
	return array('ชลชินี', 'อัจฉรา', 'สมบัติ');
}

function smp_user_has_dm_role(array $session)
{
	return in_array((string)($session['type_login'] ?? ''), array('It', 'owner'), true)
		&& in_array((string)($session['name'] ?? ''), smp_dm_role_names(), true);
}

/** ด่านอนุมัติปัจจุบันของใบ: 'sup' | 'dm' | null (ไม่ได้อยู่ในคิวอนุมัติ) */
function smp_stage_of(array $doc)
{
	if (smp_is_awaiting_sup($doc)) {
		return 'sup';
	}
	if (smp_is_awaiting_dm($doc)) {
		return 'dm';
	}
	return null;
}

/** ผู้ใช้ทำ action (อนุมัติ/ส่งกลับ/ไม่อนุมัติ/ยกเลิก) กับใบที่อยู่ในด่านปัจจุบันได้หรือไม่ */
function smp_user_can_act_on_stage(array $doc, array $session)
{
	$stage = smp_stage_of($doc);
	if ($stage === 'sup') {
		return smp_user_can_act_on_sup_stage($doc, $session);
	}
	if ($stage === 'dm') {
		return smp_user_has_dm_role($session);
	}
	return false;
}

/** ใบที่จบแล้ว (เปิดดูอย่างเดียว) */
function smp_is_terminal_status($status)
{
	return in_array((string)$status, array('Approve', 'Rejected'), true);
}

/** เจ้าของใบ — เทียบ add_by (ชื่อ-นามสกุล) เหมือนตัวกรอง Draft ของ status_samplesup.php */
function smp_user_owns_document(array $doc, array $session)
{
	$owner = trim((string)($doc['add_by'] ?? ''));
	$me = trim((string)($session['name'] ?? '') . ' ' . (string)($session['surname'] ?? ''));
	return $owner !== '' && $me !== '' && $owner === $me;
}

/**
 * ยกเลิกได้เมื่อ: ใบอยู่ในด่านอนุมัติ (sup/DM) → ผู้อนุมัติที่ทำ action ด่านนั้นได้ /
 * ใบ Draft หรือ Returned → เจ้าของใบ หรือผู้ที่มี role ผู้อนุมัติ (sup/DM)
 */
function smp_user_can_cancel(array $doc, array $session)
{
	$status = (string)($doc['status_sup'] ?? '');
	if ($status === 'Draft' || $status === 'Returned') {
		return smp_user_owns_document($doc, $session) || smp_user_has_sup_role($session) || smp_user_has_dm_role($session);
	}
	return smp_user_can_act_on_stage($doc, $session);
}

/**
 * ผู้ใช้แก้ไข/บันทึกใบนี้ได้หรือไม่ (Save Draft / Update / Submit):
 * Draft, Returned → เจ้าของใบเท่านั้น; Request → ผู้อนุมัติของด่านปัจจุบันเท่านั้น; อื่น ๆ (จบแล้ว) → ไม่มีใครแก้ได้
 */
function smp_user_can_edit_document(array $doc, array $session)
{
	$status = (string)($doc['status_sup'] ?? '');
	if ($status === 'Draft' || $status === 'Returned') {
		return smp_user_owns_document($doc, $session);
	}
	if ($status === 'Request') {
		return smp_user_can_act_on_stage($doc, $session);
	}
	return false;
}

function smp_actor_name(array $session)
{
	return trim((string)($session['name'] ?? '') . ' ' . (string)($session['surname'] ?? ''));
}

function smp_table_exists($conn, $table)
{
	$query = @mysqli_query($conn, "SHOW TABLES LIKE '" . mysqli_real_escape_string($conn, $table) . "'");
	return (bool)($query && mysqli_num_rows($query) > 0);
}

/** เขียนประวัติลง tb_document_status_log — เรียกภายใน transaction เดียวกับการเปลี่ยนสถานะ */
function smp_log_status($conn, $refId, $statusLabel, $reason, array $session)
{
	$stmt = mysqli_prepare($conn, 'INSERT INTO tb_document_status_log (ref_id, status_doc, reason, user_id, user_name) VALUES (?,?,?,?,?)');
	if (!$stmt) {
		throw new RuntimeException(mysqli_error($conn));
	}
	$userId = (string)($session['UserID'] ?? '');
	$userName = smp_actor_name($session);
	mysqli_stmt_bind_param($stmt, 'sssss', $refId, $statusLabel, $reason, $userId, $userName);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

/** รัน UPDATE ที่ไม่บังคับว่าต้องมีแถวถูกแก้ (เช่น ตั้ง clear_ckk / status_smp ของรายการ) */
function smp_exec_write($conn, $sql, $types, array $params)
{
	$stmt = mysqli_prepare($conn, $sql);
	if (!$stmt) {
		throw new RuntimeException(mysqli_error($conn));
	}
	mysqli_stmt_bind_param($stmt, $types, ...$params);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

/** UPDATE สถานะแบบมีเงื่อนไขสถานะเดิม — ไม่มีแถวถูกแก้ = มีคนเปลี่ยนสถานะไปก่อนแล้ว */
function smp_exec_status_update($conn, $sql, $types, array $values)
{
	$stmt = mysqli_prepare($conn, $sql);
	if (!$stmt) {
		throw new RuntimeException(mysqli_error($conn));
	}
	mysqli_stmt_bind_param($stmt, $types, ...$values);
	mysqli_stmt_execute($stmt);
	$affected = mysqli_stmt_affected_rows($stmt);
	mysqli_stmt_close($stmt);
	if ($affected < 1) {
		throw new SmpValidationException('เอกสารถูกเปลี่ยนสถานะไปแล้ว กรุณาโหลดหน้าใหม่');
	}
}

/** ค่าคอลัมน์แรกของแถวแรก (ไม่พบ/NULL = $default) */
function smp_query_value($conn, $sql, $types, array $params, $default = null)
{
	$stmt = mysqli_prepare($conn, $sql);
	if (!$stmt) {
		throw new RuntimeException(mysqli_error($conn));
	}
	if ($types !== '') {
		mysqli_stmt_bind_param($stmt, $types, ...$params);
	}
	mysqli_stmt_execute($stmt);
	$row = mysqli_fetch_row(mysqli_stmt_get_result($stmt));
	mysqli_stmt_close($stmt);
	return ($row && $row[0] !== null) ? $row[0] : $default;
}

/**
 * เส้นทางอนุมัติ:
 *   'default' = sample_approve.php  (แถวแรก sale_count >= 100 หรือมีสินค้า 'สินค้าขาย' → ส่งต่อ DM)
 *   'amount'  = sample_approve1.php (ยอด sum_amount รวม >= 501 → ส่งต่อ DM) — เฉพาะผู้ใช้/เขตตาม supsmp_approve.php:77-90
 */
function smp_approve_variant(array $doc, array $session)
{
	if (in_array((string)($session['name'] ?? ''), smp_amount_route_user_names(), true)
		&& in_array((string)($doc['sale_code'] ?? ''), smp_amount_route_sale_codes(), true)) {
		return 'amount';
	}
	return 'default';
}

/** true = ต้องส่งต่อด่าน DM, false = อนุมัติจบที่ด่าน sup */
function smp_should_forward_to_dm($conn, $refId, $variant, array $items)
{
	if ($variant === 'amount') {
		$total = 0.0;
		foreach ($items as $item) {
			$total += (float)$item['sum_amount'];
		}
		return $total >= 501;
	}

	/* พฤติกรรมเดิมของ sample_approve.php: เช็ค sale_count เฉพาะ "แถวแรก" ของรายการ (ไม่ใช่ทุกแถว) — คงไว้ตามเดิม */
	if (count($items) > 0 && (float)$items[0]['sale_count'] >= 100) {
		return true;
	}
	$goodsCount = smp_query_value($conn, "SELECT COUNT(*) FROM hos__subsmp s LEFT JOIN tb_product p ON s.product_ID = p.product_id
		WHERE s.reff_idsmp = ? AND p.product_type = 'สินค้าขาย'", 's', array($refId), 0);
	return (int)$goodsCount > 0;
}

/**
 * ตรวจยอดใบยืมที่เคลียร์ (เฉพาะรายการที่มี br_no) — พอร์ตจาก sample_approve*.php
 * ต่างจากของเดิม: ทำใน transaction (ยอดไม่พอ = throw แล้ว rollback ทั้งหมด รวมการตั้ง clear_ckk ของรายการก่อนหน้า)
 * และอ่านรายการจาก DB ไม่ใช่ POST
 * $useBreg = false สำหรับ sample_approve1.php (ไม่นับ hos__breg / hos__subbreg1)
 */
function smp_check_loan_clearance($conn, array $items, $useBreg)
{
	foreach ($items as $item) {
		$brNo = trim((string)$item['br_no']);
		if ($brNo === '') {
			continue;
		}
		$productId = (string)$item['product_id'];
		$qty = (float)$item['sale_count'];

		$brRef = (string)smp_query_value($conn, "SELECT ref_id_br FROM hos__br WHERE iv_no = ? AND status_doc = 'Approve' LIMIT 1", 's', array($brNo), '');
		$brTotal = (float)smp_query_value($conn, 'SELECT SUM(`count`) FROM hos__subbr WHERE ref_idd_br = ? AND product_id = ?', 'ss', array($brRef, $productId), 0);

		$soRef = (string)smp_query_value($conn, "SELECT ref_id FROM so__main WHERE doc_no = ? AND cancel_ckk = '0' LIMIT 1", 's', array($brNo), '');
		$soTotal = (float)smp_query_value($conn, 'SELECT SUM(sale_count) FROM so__submain WHERE ref_idd = ? AND product_id = ?', 'ss', array($soRef, $productId), 0);

		$bregRef = '';
		$bregTotal = 0.0;
		if ($useBreg) {
			$bregRef = (string)smp_query_value($conn, "SELECT ref_id FROM hos__breg WHERE iv_no = ? AND status_doc = 'Approve' LIMIT 1", 's', array($brNo), '');
			$bregTotal = (float)smp_query_value($conn, 'SELECT SUM(count1) FROM hos__subbreg1 WHERE ref_id1 = ? AND product_id1 = ?', 'ss', array($bregRef, $productId), 0);
		}

		$sprUsed = (float)smp_query_value($conn, "SELECT SUM(sale_count) FROM hos__subspr WHERE product_id = ? AND clear_br = '1' AND clear_ivno = ? AND status_spr = 'Approve'", 'ss', array($productId, $brNo), 0);
		$recvRef = (string)smp_query_value($conn, 'SELECT ref_id FROM hos__receive WHERE iv_no = ? LIMIT 1', 's', array($brNo), '');
		$recvUsed = (float)smp_query_value($conn, 'SELECT SUM(`count`) FROM hos__subreceive WHERE ref_idd = ? AND product_id = ?', 'ss', array($recvRef, $productId), 0);
		$smpUsed = (float)smp_query_value($conn, "SELECT SUM(sale_count) FROM hos__subsmp WHERE product_id = ? AND clear_br = '1' AND br_no = ? AND status_smp = 'Approve'", 'ss', array($productId, $brNo), 0);

		/* พฤติกรรมเดิม: ตัวแปร $count13 ของหน้าเก่าอ่านจากผล SPR ($rs3) ไม่ใช่ผล SO ($rs13) ทำให้ยอด SPR ถูกหักสองครั้ง
		   (ยอด hos__subso ที่ query ไว้ไม่เคยถูกใช้) — คงการคำนวณนี้ไว้ตามเดิม ไม่แก้เงียบ ๆ */
		$remaining = ($brTotal + $soTotal + $bregTotal) - ($sprUsed + $recvUsed + $smpUsed + $sprUsed + $qty);

		if ($remaining < -0.00001) {
			throw new SmpValidationException('สินค้าในใบยืมเลขที่ ' . $brNo . ' (รหัสสินค้า ' . $productId . ') มีไม่พอในการเคลียร์ยืมครั้งนี้');
		}
		if (abs($remaining) < 0.00001) {
			smp_exec_write($conn, "UPDATE hos__subbr SET clear_ckk = '1' WHERE ref_idd_br = ? AND product_id = ?", 'ss', array($brRef, $productId));
			smp_exec_write($conn, "UPDATE so__submain SET clear_ckk = '1' WHERE ref_idd = ? AND product_id = ?", 'ss', array($soRef, $productId));
			if ($useBreg) {
				smp_exec_write($conn, "UPDATE hos__subbreg1 SET clear_ckk = '1' WHERE ref_id1 = ? AND product_id1 = ?", 'ss', array($bregRef, $productId));
			}
		}
	}
}

/**
 * ส่งข้อมูลจัดส่งของใบที่อนุมัติจบไป DB ของ CS (allwell_cs) — พอร์ตจาก sample_approve*.php
 * เรียกหลัง commit (คนละ connection กับ $conn จึงอยู่ใน transaction เดียวกันไม่ได้)
 * อ่านจากแถว tb_register_data ของใบนี้ ไม่ใช่ POST; คงการ map ที่อยู่เดิม
 * @return string '' เมื่อสำเร็จ/ไม่เข้าเงื่อนไข, ข้อความเตือนเมื่อส่งไม่สำเร็จ
 */
function smp_export_to_cs($conn, array $doc, $variant)
{
	/* กลุ่มยกเว้นต่างกันตามหน้าเดิม: sample_approve.php มีวงเล็บ ('(SOL99)') ส่วน sample_approve1.php ไม่มี — คงไว้ตามเดิม */
	$excluded = ($variant === 'amount')
		? array('SOL99', 'EN', 'SOL1', 'SOL2', 'SOL3')
		: array('(SOL99)', 'EN', '(SOL1)', '(SOL2)', 'SOL3');
	/* ส่งเฉพาะบริษัทจัดส่ง: '5' = AllWell (รหัสปัจจุบัน), '2' = บริษัทจัดส่ง (รหัสเดิมของใบเก่าที่ยังค้างอนุมัติ) */
	if (in_array((string)$doc['sale_code'], $excluded, true) || !in_array((string)$doc['delivery_type'], array('5', '2'), true)) {
		return '';
	}
	/* เหมือน dm_approve.php: ไม่ส่งซ้ำถ้าเคยส่งไป CS แล้ว */
	if (trim((string)($doc['cs_no'] ?? '')) !== '' || (string)($doc['send_cs'] ?? '') === '2') {
		return '';
	}

	$refId = (string)$doc['ref_idsmp'];
	try {
		$reg = smp_load_row($conn, 'tb_register_data', 'ref_id', $refId);
		if ($reg === null) {
			throw new RuntimeException('ไม่พบข้อมูลจัดส่ง (tb_register_data) ของ ' . $refId);
		}

		include __DIR__ . '/../dbconnect_cs.php';
		if (!isset($com1) || !$com1) {
			throw new RuntimeException('เชื่อมต่อฐานข้อมูล CS ไม่ได้');
		}
		@mysqli_query($com1, "SET SESSION sql_mode = ''");

		$yearMonth = substr(date('Y') + 543, -2) . date('m');
		$maxRunning = (string)smp_query_value($com1, 'SELECT MAX(running) FROM tb_register_data', '', array(), '');
		$lastSeq = substr($maxRunning, -4);
		$lastMonth = substr($maxRunning, 0, -4);
		$nextId = ($lastMonth == $yearMonth)
			? $yearMonth . substr('00000' . ((int)$lastSeq + 1), -4)
			: $yearMonth . '0001';

		$pick = function ($column, $default = '') use ($reg) {
			$value = (string)($reg[$column] ?? '');
			return $value !== '' ? $value : $default;
		};
		smp_db_insert($com1, 'tb_register_data', array(
			'running'          => $nextId,
			'start_date'       => $pick('start_date', '0000-00-00'),
			'between_date'     => $pick('between_date'),
			'start_time'       => $pick('start_time'),
			'end_time'         => $pick('end_time'),
			'status'           => $pick('status'),
			'fix_date'         => $pick('fix_date', '0'),
			'no_price'         => $pick('no_price', '0'),
			'call_customer'    => $pick('call_customer', '0'),
			'credit'           => $pick('credit', '0'),
			'call_employee'    => $pick('call_employee', '0'),
			'cash'             => $pick('cash', '0'),
			'check_peper'      => $pick('check_peper', '0'),
			'bill'             => $pick('bill', '0'),
			'department'       => $pick('department'),
			'type_customer'    => $pick('type_customer'),
			'type_company'     => $pick('type_company'),
			'customer_name'    => $pick('customer_name'),
			'customer_tel'     => $pick('customer_tel'),
			'address_name'     => $pick('address_1') . ' ' . $pick('province_name'),
			'address_send'     => $pick('address_name') . ' ' . $pick('address_send'),
			'want_bus'         => $pick('want_bus', '0'),
			'amphur_name'      => $pick('amphur_name'),
			'province_name'    => $pick('province_name'),
			'product_name'     => $pick('product_name'),
			'product_sn'       => $pick('product_sn') . ' เลขที่อ้างอิง : ' . $refId,
			'unit_credit'      => $pick('unit_credit'),
			'price'            => $pick('price'),
			'employee_name'    => $pick('employee_name'),
			'employee_tel'     => $pick('employee_tel'),
			'add_by'           => $pick('add_by'),
			'description'      => $pick('description'),
			'have_map'         => $pick('have_map'),
			'add_date'         => date('Y-m-d H:i:s'),
			'unit_bill'        => $pick('unit_bill'),
			'unit_check'       => $pick('unit_check'),
			'unit_tran'        => $pick('unit_tran'),
			'tran'             => $pick('tran', '0'),
			'check_detail'     => $pick('check_detail', '0'),
			'number'           => '',
			'status_comment'   => $pick('status_comment'),
			'dep'              => $pick('dep', '0'),
			'dept'             => $pick('dept'),
			'department_show'  => $pick('department_show'),
			'address_bus'      => $pick('province_name'),
			'customer_contact' => $pick('customer_contact'),
			'on_time'          => $pick('on_time', '0'),
			'add_code'         => $pick('add_code'),
			'ref_id'           => $refId,
		));
		smp_db_insert($com1, 'tb_transaction', array('running' => $nextId));

		$csFields = array('send_cs' => '2');
		if ($variant === 'amount') {
			$csFields['cs_no'] = $nextId; /* sample_approve1.php เท่านั้นที่บันทึก cs_no */
		}
		smp_db_update($conn, 'hos__smp', $csFields, 'ref_idsmp', $refId);
		return '';
	} catch (Throwable $e) {
		error_log('[smp_export_to_cs] ' . $refId . ': ' . $e->getMessage());
		return 'อนุมัติเอกสารแล้ว แต่ส่งข้อมูลจัดส่งไประบบ CS ไม่สำเร็จ กรุณาแจ้งผู้ดูแลระบบ (เลขที่ ' . $refId . ')';
	}
}

/**
 * ทำ action ของแถบอนุมัติ: approve | return | reject | cancel
 * @return array ['ref_id', 'action', 'outcome', 'warning']
 * @throws SmpValidationException ข้อผิดพลาดที่แสดงให้ผู้ใช้เห็นได้
 */
function smp_run_document_action($conn, $refId, $action, $reason, array $session)
{
	@mysqli_query($conn, "SET SESSION sql_mode = REPLACE(REPLACE(@@SESSION.sql_mode, 'STRICT_TRANS_TABLES', ''), 'STRICT_ALL_TABLES', '')");

	$refId = trim((string)$refId);
	$reason = trim((string)$reason);
	if ($refId === '') {
		throw new SmpValidationException('ไม่พบเลขที่เอกสาร');
	}
	if (!in_array($action, array('approve', 'return', 'reject', 'cancel'), true)) {
		throw new SmpValidationException('คำสั่งไม่ถูกต้อง');
	}
	if ($action !== 'approve' && $reason === '') {
		throw new SmpValidationException('กรุณาระบุเหตุผล');
	}
	if (!smp_table_exists($conn, 'tb_document_status_log')) {
		throw new SmpValidationException('ไม่พบตารางบันทึกประวัติเอกสาร (tb_document_status_log) กรุณาแจ้งผู้ดูแลระบบ');
	}

	$actor = (string)($session['name'] ?? '');
	$today = date('Y-m-d');
	$now = date('Y-m-d H:i:s');
	$outcome = '';
	$csVariant = null;
	$doc = null;

	mysqli_begin_transaction($conn);
	try {
		$stmt = mysqli_prepare($conn, 'SELECT * FROM hos__smp WHERE ref_idsmp = ? LIMIT 1 FOR UPDATE');
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$doc = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt)) ?: null;
		mysqli_stmt_close($stmt);
		if ($doc === null) {
			throw new SmpValidationException('ไม่พบเอกสารเลขที่ ' . $refId);
		}
		$currentStatus = (string)$doc['status_sup'];

		if ($action === 'cancel') {
			if (!in_array($currentStatus, array('Draft', 'Returned', 'Request'), true)) {
				throw new SmpValidationException('เอกสารเลขที่ ' . $refId . ' ปิดแล้ว ไม่สามารถยกเลิกได้');
			}
			if (!smp_user_can_cancel($doc, $session)) {
				throw new SmpValidationException('คุณไม่มีสิทธิ์ยกเลิกเอกสารนี้');
			}
			/* ไม่เพิ่มสถานะ Cancelled — หน้าอื่นอ่าน status_sup เป็น Rejected/Approve อยู่หลายที่; แยกจาก Reject ด้วย log 'Cancelled' */
			smp_exec_status_update($conn,
				"UPDATE hos__smp SET status_sup = 'Rejected', sup_date = ?, sup_name = ? WHERE ref_idsmp = ? AND status_sup = ?",
				'ssss', array($today, $actor, $refId, $currentStatus));
			smp_log_status($conn, $refId, 'Cancelled', $reason, $session);
			$outcome = 'cancelled';
		} else {
			$stage = smp_stage_of($doc);
			if ($stage === null) {
				throw new SmpValidationException('เอกสารไม่ได้อยู่ในสถานะรออนุมัติแล้ว กรุณาโหลดหน้าใหม่');
			}
			if (!smp_user_can_act_on_stage($doc, $session)) {
				throw new SmpValidationException('คุณไม่มีสิทธิ์ดำเนินการกับเอกสารนี้');
			}
			$awaitingWhere = ($stage === 'sup')
				? "ref_idsmp = ? AND status_sup = 'Request' AND send_sup = '1' AND send_dm = '0' AND send_stock = '0' AND send_admin = '0'"
				: "ref_idsmp = ? AND status_sup = 'Request' AND send_dm = '1' AND send_stock = '0' AND send_admin = '0'";

			if ($action === 'return') {
				/* ส่งกลับหาผู้ยื่นเสมอ ไม่ว่าจากด่านไหน — ล้าง flag ทุกด่านเพื่อให้ใบหลุดจากทุกคิว แล้ว Submit ใหม่วิ่งครบทุกด่านตามปกติ */
				smp_exec_status_update($conn,
					"UPDATE hos__smp SET status_sup = 'Returned', send_sup = '0', send_dm = '0', send_stock = '0', send_admin = '0' WHERE " . $awaitingWhere,
					's', array($refId));
				smp_log_status($conn, $refId, 'Returned', $reason, $session);
				$outcome = 'returned';
			} elseif ($action === 'reject') {
				/* เขียนคอลัมน์ comment/name/date ของด่านไว้ด้วย เพื่อให้หน้า/รายงานเดิมที่อ่านคอลัมน์เหล่านี้ยังทำงานได้ (ประวัติเต็มอยู่ใน log) */
				if ($stage === 'sup') {
					smp_exec_status_update($conn,
						"UPDATE hos__smp SET status_sup = 'Rejected', comment_sup = ?, sup_date = ?, sup_name = ? WHERE " . $awaitingWhere,
						'ssss', array($reason, $today, $actor, $refId));
				} else {
					smp_exec_status_update($conn,
						"UPDATE hos__smp SET status_sup = 'Rejected', comment_dm = ?, dm_date = ?, dm_name = ? WHERE " . $awaitingWhere,
						'ssss', array($reason, $today, $actor, $refId));
				}
				smp_log_status($conn, $refId, 'Rejected', $reason, $session);
				$outcome = 'rejected';
			} elseif ($stage === 'dm') {
				/* ด่าน DM อนุมัติจบเสมอ (ไม่มีเช็คยอดใบยืมซ้ำ — เช็คไปแล้วตอน sup อนุมัติ) เหมือน dm_approve.php */
				smp_exec_status_update($conn,
					"UPDATE hos__smp SET status_sup = 'Approve', send_stock = '1', send_admin = '1', dm_date = ?, dm_name = ?, dm_adddate = ? WHERE " . $awaitingWhere,
					'ssss', array($today, $actor, $now, $refId));
				smp_exec_write($conn, "UPDATE hos__subsmp SET status_smp = 'Approve' WHERE reff_idsmp = ?", 's', array($refId));
				smp_log_status($conn, $refId, 'DM Approved', '', $session);
				$outcome = 'approved';
				$csVariant = 'default';
			} else {
				$items = smp_load_items($conn, $refId);
				$variant = smp_approve_variant($doc, $session);
				smp_check_loan_clearance($conn, $items, $variant === 'default');

				if (smp_should_forward_to_dm($conn, $refId, $variant, $items)) {
					smp_exec_status_update($conn,
						"UPDATE hos__smp SET send_dm = '1', sup_date = ?, sup_name = ?, sup_adddate = ? WHERE " . $awaitingWhere,
						'ssss', array($today, $actor, $now, $refId));
					smp_log_status($conn, $refId, 'Sup Forwarded to DM', '', $session);
					$outcome = 'forwarded';
				} else {
					smp_exec_status_update($conn,
						"UPDATE hos__smp SET status_sup = 'Approve', send_stock = '1', send_admin = '1', sup_date = ?, sup_name = ?, sup_adddate = ? WHERE " . $awaitingWhere,
						'ssss', array($today, $actor, $now, $refId));
					smp_exec_write($conn, "UPDATE hos__subsmp SET status_smp = 'Approve' WHERE reff_idsmp = ?", 's', array($refId));
					smp_log_status($conn, $refId, 'Sup Approved', '', $session);
					$outcome = 'approved';
					$csVariant = $variant;
				}
			}
		}

		mysqli_commit($conn);
	} catch (Throwable $e) {
		mysqli_rollback($conn);
		throw $e;
	}

	$warning = '';
	if ($csVariant !== null) {
		$warning = smp_export_to_cs($conn, $doc, $csVariant);
	}
	return array('ref_id' => $refId, 'action' => $action, 'outcome' => $outcome, 'warning' => $warning);
}
