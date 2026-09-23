<?php

/**
 * ชั้นบันทึกข้อมูลของใบยืมตรวจเช็คสินค้า (BREQ — in__br.type_breng = 2)
 *
 * ใช้ร่วมกันโดย
 *   - register_breng1_breq.php      (Submit → status_doc = 'Request')
 *   - register_breng_save_breq.php  (Save Draft / Update / ส่ง Sup — ตอบ JSON)
 *   - register_breng_brgq.php       (โหลดเอกสารกลับมาแสดง/แก้ไข)
 *
 * แทนตัวบันทึกเดิมใน register_breng1_breq.php ที่ต่อ SQL เป็น string และออกเลข BQ
 * โดยไม่มี lock — แนวเดียวกับ includes/breg_repo.php (ยืม helper lock/column ของไฟล์นั้น)
 *
 * เจ้าของเอกสาร = in__br.sale_code ตรงกับ $_SESSION['code']
 * เอกสารเก่าที่ sale_code ว่าง (สร้างก่อนมีหน้านี้) ไม่มีเจ้าของให้เทียบ จึงแก้ได้ทุกคน
 * เหมือนหน้า register_breng_edit_breq.php เดิม
 */

require_once __DIR__ . '/breg_repo.php';

if (!class_exists('BreqValidationException')) {
	/** ข้อผิดพลาดที่ส่งข้อความกลับให้ผู้ใช้อ่านได้ตรง ๆ (ต่างจาก RuntimeException ที่พก error ของ MySQL) */
	class BreqValidationException extends RuntimeException
	{
	}
}

if (!function_exists('breq_post_value')) {
	function breq_post_value(array $post, $key, $default = '')
	{
		if (!isset($post[$key]) || is_array($post[$key])) {
			return $default;
		}
		return trim((string)$post[$key]);
	}
}

if (!function_exists('breq_post_array_value')) {
	function breq_post_array_value(array $post, $key, $index)
	{
		if (!isset($post[$key]) || !is_array($post[$key]) || !isset($post[$key][$index]) || is_array($post[$key][$index])) {
			return '';
		}
		return trim((string)$post[$key][$index]);
	}
}

if (!function_exists('breq_session_add_by')) {
	function breq_session_add_by(array $session)
	{
		return trim(($session['name'] ?? '') . ' ' . ($session['surname'] ?? ''));
	}
}

if (!function_exists('breq_can_edit_owner')) {
	function breq_can_edit_owner(array $doc, array $session)
	{
		$docCode = trim((string)($doc['sale_code'] ?? ''));
		return $docCode === '' || $docCode === trim((string)($session['code'] ?? ''));
	}
}

if (!function_exists('breq_fetch_one')) {
	function breq_fetch_one($conn, $sql, $types = '', array $params = array())
	{
		$stmt = mysqli_prepare($conn, $sql);
		if ($types !== '') {
			mysqli_stmt_bind_param($stmt, $types, ...$params);
		}
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
		return $row ?: null;
	}
}

if (!function_exists('breq_execute')) {
	function breq_execute($conn, $sql, $types = '', array $params = array())
	{
		$stmt = mysqli_prepare($conn, $sql);
		if ($types !== '') {
			mysqli_stmt_bind_param($stmt, $types, ...$params);
		}
		mysqli_stmt_execute($stmt);
		$affected = mysqli_stmt_affected_rows($stmt);
		mysqli_stmt_close($stmt);
		return $affected;
	}
}

if (!function_exists('breq_insert_row')) {
	/** INSERT จาก array คอลัมน์ => ค่า (ผูกทุกค่าเป็น string ให้ MySQL แปลงชนิดเอง แบบเดียวกับ SQL เดิม) */
	function breq_insert_row($conn, $table, array $row)
	{
		$columns = array_keys($row);
		$sql = 'INSERT INTO `' . $table . '` (`' . implode('`,`', $columns) . '`) VALUES ('
			. implode(',', array_fill(0, count($columns), '?')) . ')';
		$values = array_map('strval', array_values($row));
		return breq_execute($conn, $sql, str_repeat('s', count($values)), $values);
	}
}

/* ===================== เลขที่เอกสาร ===================== */

if (!function_exists('breq_next_ref_id')) {
	/**
	 * เลข BQ ถัดไป — ใช้ตัวนับร่วมกับเลข BR ใน in__br แบบเดิม (ปีเดือน 4 หลัก + ลำดับ 5 หลัก)
	 * แต่หาเลขล่าสุดจาก 9 หลักท้ายแทน MAX(ref_id_br) แบบ string ของโค้ดเดิม
	 * ซึ่งได้เลข BR มาเสมอเมื่อมีเอกสาร BR อยู่ ('BR' > 'BQ') ทำให้ออกเลข BQ ซ้ำได้
	 */
	function breq_next_ref_id($conn)
	{
		$yearMonth = breg_year_month();
		$row = breq_fetch_one(
			$conn,
			"SELECT MAX(CAST(RIGHT(ref_id_br, 5) AS UNSIGNED)) AS max_run
			 FROM in__br
			 WHERE LEFT(RIGHT(ref_id_br, 9), 4) = ? AND RIGHT(ref_id_br, 5) REGEXP '^[0-9]{5}$'",
			's',
			array($yearMonth)
		);
		$running = ($row && $row['max_run'] !== null) ? (int)$row['max_run'] : 0;
		return 'BQ' . $yearMonth . substr('00000' . ($running + 1), -5);
	}
}

if (!function_exists('breq_ref_id_taken')) {
	function breq_ref_id_taken($conn, $refId)
	{
		return breq_fetch_one($conn, "SELECT 1 AS hit FROM in__br WHERE ref_id_br = ? LIMIT 1", 's', array($refId)) !== null;
	}
}

if (!function_exists('breq_reserve_ref_id')) {
	/**
	 * จองเลข BQ พร้อม INSERT หัวเอกสาร ภายใต้ GET_LOCK ต่อเดือน
	 * in__br ไม่มี unique key บน ref_id_br จึงเช็คซ้ำเองก่อน INSERT ทุกครั้ง
	 * (หน้า createnew เดิมยังออกเลขจากตัวนับเดียวกันโดยไม่ lock — ความเสี่ยงที่เหลืออยู่)
	 */
	function breq_reserve_ref_id($conn, array $header)
	{
		$yearMonth = breg_year_month();
		$lockName = 'breq_ref_id_' . $yearMonth;
		$gotLock = breg_acquire_named_lock($conn, $lockName, 10);

		try {
			$refId = breq_next_ref_id($conn);
			for ($attempt = 0; $attempt < 10; $attempt++) {
				if (!breq_ref_id_taken($conn, $refId)) {
					$header['ref_id_br'] = $refId;
					breq_insert_row($conn, 'in__br', $header);
					return $refId;
				}
				$refId = 'BQ' . $yearMonth . substr('00000' . ((int)substr($refId, -5) + 1), -5);
			}
		} finally {
			if ($gotLock) {
				breg_release_named_lock($conn, $lockName);
			}
		}

		throw new RuntimeException('ไม่สามารถออกเลขที่เอกสาร BQ ได้');
	}
}

/* ===================== คงเหลือของ PO ===================== */

if (!function_exists('breq_po_stock_row')) {
	/** แถวรับเข้าของ PO+สินค้า+lot ฝั่ง stock — เงื่อนไขเดียวกับ ajax_breq_po_items.php */
	function breq_po_stock_row($stockConn, $poNo, $productId, $lotNo)
	{
		return breq_fetch_one(
			$stockConn,
			"SELECT sm.sale_count, sm.product_codesame, sm.product_price
			 FROM in__main im
			 INNER JOIN in__sbmain sm ON sm.ref_idd = im.ref_id
			 WHERE im.iv_no LIKE '%IO%' AND sm.ckk_check = '0'
			   AND im.po_no = ? AND sm.product_id = ? AND sm.lot_no = ?
			 LIMIT 1",
			'sss',
			array($poNo, $productId, $lotNo)
		);
	}
}

if (!function_exists('breq_po_remaining')) {
	/**
	 * คงเหลือให้ยืม = ยอดรับเข้าของ lot − ยอดยืมของ PO+สินค้าในเอกสารอื่น (รวม Draft — Draft จองของไว้)
	 * ตัดแถวของ $excludeRefId เพื่อให้เอกสารที่กำลังแก้ไม่หักตัวเอง
	 * คืน null ถ้าไม่พบแถวรับเข้า
	 */
	function breq_po_remaining($conn, $stockConn, $poNo, $productId, $lotNo, $excludeRefId)
	{
		$stockRow = breq_po_stock_row($stockConn, $poNo, $productId, $lotNo);
		if ($stockRow === null) {
			return null;
		}
		$sumRow = breq_fetch_one(
			$conn,
			"SELECT SUM(count) AS sum_count FROM in__subbr WHERE po_no = ? AND product_id = ? AND ref_idd_br <> ?",
			'sss',
			array($poNo, $productId, (string)$excludeRefId)
		);
		$borrowed = ($sumRow && $sumRow['sum_count'] !== null) ? (float)$sumRow['sum_count'] : 0.0;
		return (float)$stockRow['sale_count'] - $borrowed;
	}
}

/* ===================== อ่านเอกสาร ===================== */

if (!function_exists('breq_load_document')) {
	/**
	 * หัวเอกสาร + รายการสินค้าในรูปที่ js/breq-item-table.js (breqHydrateRows) ใช้ได้ทันที
	 * คืน null ถ้าไม่พบ
	 */
	function breq_load_document($conn, $stockConn, $refId)
	{
		$header = breq_fetch_one($conn, "SELECT * FROM in__br WHERE ref_id_br = ? LIMIT 1", 's', array($refId));
		if ($header === null) {
			return null;
		}

		$hasNameOther = breg_column_exists($conn, 'in__subbr', 'product_nameother');
		$stmt = mysqli_prepare(
			$conn,
			"SELECT s.*, p.sol_name, p.access_code, p.war_hc
			 FROM in__subbr s
			 LEFT JOIN tb_product p ON p.product_ID = s.product_id
			 WHERE s.ref_idd_br = ? AND s.product_id <> ''
			 ORDER BY s.id ASC"
		);
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$items = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$poNo = (string)$row['po_no'];
			$productId = (string)$row['product_id'];
			$lotNo = (string)$row['lot'];
			$stockRow = breq_po_stock_row($stockConn, $poNo, $productId, $lotNo);
			$remaining = breq_po_remaining($conn, $stockConn, $poNo, $productId, $lotNo, $refId);

			$items[] = array(
				'product_id'        => $productId,
				'product_codesame'  => $stockRow ? (string)$stockRow['product_codesame'] : '',
				'access_code'       => (string)($row['access_code'] ?? ''),
				'product_name'      => (string)($row['sol_name'] ?? ''),
				// in__subbr เก็บราคาต่อหน่วยไว้ใน amount และยอดรวมไว้ใน price (สลับกันตั้งแต่ SQL เดิม)
				'product_price'     => (float)$row['amount'],
				'remaining'         => $remaining === null ? (float)$row['count'] : $remaining,
				'war_hc'            => (string)$row['warranty'],
				'lot_no'            => $lotNo,
				'product_nameother' => $hasNameOther ? (string)($row['product_nameother'] ?? '') : '',
				'count'             => (float)$row['count'],
				'br_period'         => (string)$row['br_periodd'] === '0' ? '' : (string)$row['br_periodd'],
				'sale_remark'       => (string)$row['sale_remark'],
			);
		}
		mysqli_stmt_close($stmt);

		return array('header' => $header, 'items' => $items);
	}
}

/* ===================== ตรวจข้อมูล ===================== */

if (!function_exists('breq_items_from_post')) {
	/** แถวรายการจาก POST (ชื่อฟิลด์ตาม js/breq-item-table.js) — ข้ามแถวที่ไม่มี product_id */
	function breq_items_from_post(array $post)
	{
		$keys = (isset($post['key']) && is_array($post['key'])) ? array_keys($post['key']) : array();
		$items = array();
		foreach ($keys as $index) {
			$productId = breq_post_array_value($post, 'product_id', $index);
			if ($productId === '' || breq_post_array_value($post, 'check_in', $index) !== '1') {
				continue;
			}
			$count = (float)breq_post_array_value($post, 'sale_count', $index);
			$price = (float)str_replace(',', '', breq_post_array_value($post, 'product_price', $index));
			$items[] = array(
				'product_id'        => $productId,
				'product_name'      => breq_post_array_value($post, 'product_name', $index),
				'count'             => $count,
				'price'             => $price,
				'sum_amount'        => $price * $count,
				'br_period'         => (int)breq_post_array_value($post, 'br_period', $index),
				'warranty'          => breq_post_array_value($post, 'warranty', $index),
				'sale_remark'       => breq_post_array_value($post, 'sale_remarkk', $index),
				'lot'               => breq_post_array_value($post, 'lot', $index),
				'product_nameother' => breq_post_array_value($post, 'product_nameother', $index),
			);
		}
		return $items;
	}
}

if (!function_exists('breq_po_belongs_to_company')) {
	function breq_po_belongs_to_company($conn, $poNo, $company)
	{
		return breq_fetch_one(
			$conn,
			"SELECT 1 AS hit FROM allwell_inter.po__main WHERE po_no = ? AND company = ? LIMIT 1",
			'ss',
			array($poNo, $company)
		) !== null;
	}
}

if (!function_exists('breq_validate')) {
	/**
	 * draft: ต้องมีบริษัท และถ้าเลือก PO แล้วต้องเป็นของบริษัทนั้น (ไม่บังคับมีรายการ)
	 * submit / update: ต้องมี PO + รายการ ≥ 1 + จำนวนยืมแต่ละแถว 1..คงเหลือ
	 */
	function breq_validate($conn, $stockConn, $mode, $company, $poNo, array $items, $refId)
	{
		if (!in_array($company, array('1', '2'), true)) {
			throw new BreqValidationException('กรุณาเลือกบริษัท');
		}

		$isFull = ($mode !== 'draft');
		if ($poNo === '') {
			if ($isFull || count($items) > 0) {
				throw new BreqValidationException('กรุณาเลือกเอกสาร PO');
			}
			return;
		}
		if (!breq_po_belongs_to_company($conn, $poNo, $company)) {
			throw new BreqValidationException('เอกสาร PO ' . $poNo . ' ไม่ใช่ของบริษัทที่เลือก กรุณาตรวจสอบอีกครั้ง');
		}
		if (!$isFull) {
			return;
		}
		if (count($items) === 0) {
			throw new BreqValidationException('กรุณาเลือกสินค้าจากเอกสาร PO อย่างน้อย 1 รายการ');
		}

		foreach ($items as $item) {
			$label = $item['product_name'] !== '' ? $item['product_name'] : $item['product_id'];
			if ($item['count'] <= 0) {
				throw new BreqValidationException('กรุณาระบุจำนวนยืมของ "' . $label . '" ให้มากกว่า 0');
			}
			$remaining = breq_po_remaining($conn, $stockConn, $poNo, $item['product_id'], $item['lot'], $refId);
			if ($remaining === null) {
				throw new BreqValidationException('ไม่พบ "' . $label . '" ในเอกสาร PO ' . $poNo);
			}
			if ($item['count'] > $remaining) {
				throw new BreqValidationException('จำนวนยืมของ "' . $label . '" เกินคงเหลือให้ยืม (คงเหลือ ' . rtrim(rtrim(number_format($remaining, 2, '.', ''), '0'), '.') . ')');
			}
		}
	}
}

/* ===================== บันทึก ===================== */

if (!function_exists('breq_replace_items')) {
	function breq_replace_items($conn, $refId, $poNo, array $items)
	{
		breq_execute($conn, "DELETE FROM in__subbr WHERE ref_idd_br = ?", 's', array($refId));

		$hasNameOther = breg_column_exists($conn, 'in__subbr', 'product_nameother');
		foreach ($items as $item) {
			$row = array(
				'ref_idd_br'   => $refId,
				'po_no'        => $poNo,
				'product_id'   => $item['product_id'],
				'product_code' => $item['product_id'],
				'count'        => $item['count'],
				// คงการสลับ amount/price ของ SQL เดิม — รายงานที่มีอยู่อ่านแบบนี้
				'amount'       => $item['price'],
				'price'        => $item['sum_amount'],
				'sale_remark'  => $item['sale_remark'],
				'br_periodd'   => $item['br_period'],
				'warranty'     => $item['warranty'],
				'lot'          => $item['lot'],
			);
			if ($hasNameOther) {
				$row['product_nameother'] = $item['product_nameother'];
			}
			breq_insert_row($conn, 'in__subbr', $row);
		}
	}
}

if (!function_exists('breq_mark_sn_products')) {
	/** สินค้าที่มี SN ถูกยืม → tb_product.sale_ckk = '0' (พฤติกรรมเดิมของ register_breng1_breq.php) */
	function breq_mark_sn_products($conn, array $items)
	{
		foreach ($items as $item) {
			breq_execute($conn, "UPDATE tb_product SET sale_ckk = '0' WHERE product_ID = ? AND have_sn = '1'", 's', array($item['product_id']));
		}
	}
}

if (!function_exists('breq_insert_submit_side_tables')) {
	/**
	 * tb_other_bill + tb_register_data ตอน Submit ครั้งแรก — ค่าตามโค้ดเดิม
	 * (ฟิลด์ส่วนใหญ่มาจาก hidden ค่าว่างของ compatibility layer ในหน้าฟอร์ม)
	 */
	function breq_insert_submit_side_tables($conn, $refId, array $post, $company, $addBy, $emId, $addDate)
	{
		$v = function ($key) use ($post) {
			return breq_post_value($post, $key);
		};
		$flag = function ($key) use ($post) {
			$value = breq_post_value($post, $key);
			return $value !== '' ? $value : '0';
		};

		$otherBill = array('ref_id' => $refId, 'head_1' => $v('head_1'));
		for ($i = 1; $i <= 11; $i++) {
			$otherBill['ref_' . $i] = $v('ref_' . $i);
		}
		$otherBill['ref_des'] = $v('ref_des');
		breq_insert_row($conn, 'tb_other_bill', $otherBill);

		$typeCompany = $company === '1' ? 'ออลล์เวล ไลฟ์ บจก.' : ($company === '2' ? 'โนเบิล เมด บจก.' : '');
		breq_insert_row($conn, 'tb_register_data', array(
			'ref_id'           => $refId,
			'start_date'       => $v('start_date') !== '' ? date('Y-m-d') : '0000-00-00',
			'between_date'     => $v('between_date'),
			'start_time'       => $v('start_time'),
			'end_time'         => $v('end_time'),
			'status'           => $v('status'),
			'fix_date'         => $flag('fix_datetime'),
			'no_price'         => $flag('no_money'),
			'call_customer'    => $flag('call_customer'),
			'credit'           => $flag('credit_card'),
			'call_employee'    => $flag('call_back'),
			'cash'             => $flag('cash'),
			'check_peper'      => $flag('check_paper'),
			'bill'             => $flag('bill'),
			'department'       => $v('department_name'),
			'type_customer'    => $v('customer_typename'),
			'type_company'     => $typeCompany,
			'customer_name'    => $v('customer_name'),
			'customer_tel'     => $v('customer_tel'),
			'address_name'     => $v('address_name'),
			'address_send'     => $v('address_send'),
			'want_bus'         => $flag('want_bus'),
			'product_name'     => trim('ส่ง ' . $v('address_name')),
			'product_sn'       => $v('product_sn'),
			'unit_credit'      => $v('unit_credit'),
			'price'            => $v('unit_cash'),
			'employee_name'    => $v('employee_name'),
			'employee_tel'     => $v('employee_tel'),
			'add_by'           => $addBy,
			'description'      => $v('sale_comment'),
			'have_map'         => $v('have_map'),
			'add_date'         => $addDate,
			'unit_bill'        => $v('unit_bill'),
			'unit_check'       => $v('unit_check'),
			'unit_tran'        => $v('unit_tran'),
			'tran'             => $flag('tran'),
			'check_detail'     => $flag('more'),
			'dep'              => $flag('dep'),
			'dept'             => $v('dept'),
			'department_show'  => $v('department_show'),
			'customer_contact' => $v('customer_contact'),
			'status_comment'   => $v('status_comment'),
			'on_time'          => $v('on_time'),
			'address_1'        => $v('address_1'),
			'add_code'         => $emId,
			'province_name'    => $v('province_name'),
		));
	}
}

if (!function_exists('breq_lock_document')) {
	/** ต้องเรียกภายในทรานแซกชัน — ล็อกแถวหัวเอกสารและตรวจสิทธิ์เจ้าของ */
	function breq_lock_document($conn, $refId, array $session)
	{
		$doc = breq_fetch_one($conn, "SELECT * FROM in__br WHERE ref_id_br = ? LIMIT 1 FOR UPDATE", 's', array($refId));
		if ($doc === null) {
			throw new BreqValidationException('ไม่พบเอกสาร ' . $refId);
		}
		if (!breq_can_edit_owner($doc, $session)) {
			throw new BreqValidationException('เอกสาร ' . $refId . ' เป็นของผู้ใช้อื่น ไม่สามารถแก้ไขได้');
		}
		return $doc;
	}
}

if (!function_exists('breq_persist')) {
	/**
	 * @param string $mode draft | submit | update
	 *   draft  : สร้างใหม่หรือบันทึกทับ Draft เดิม (status_doc = 'Draft')
	 *   submit : สร้างใหม่หรือ Draft → Request + ส่ง Sup อนุมัติ (send_sup = 1) + side effect เดิม (sale_ckk, tb_other_bill, tb_register_data)
	 *   update : แก้เอกสาร Request โดยไม่เปลี่ยนสถานะ (ต้องครบเหมือน submit) — Draft ใช้ mode draft
	 * @return array{ref_id: string, created: bool}
	 */
	function breq_persist($conn, $stockConn, array $post, $mode, array $session)
	{
		if (!in_array($mode, array('draft', 'submit', 'update'), true)) {
			throw new InvalidArgumentException('mode ไม่ถูกต้อง');
		}

		$refId = breq_post_value($post, 'ref_id_br');
		$company = breq_post_value($post, 'company');
		$poNo = breq_post_value($post, 'po_no');
		$items = breq_items_from_post($post);

		if ($mode === 'update' && $refId === '') {
			throw new BreqValidationException('ไม่พบเลขที่เอกสารที่จะแก้ไข');
		}

		breq_validate($conn, $stockConn, $mode, $company, $poNo, $items, $refId);

		$ivDate = breq_post_value($post, 'admin_doc_date');
		$headerFields = array(
			'company'      => $company,
			'ref_id_stock' => breq_post_value($post, 'ref_id_stock'),
			'po_no'        => $poNo,
			'customer_id'  => (int)breq_post_value($post, 'customer_id'),
			'address'      => breq_post_value($post, 'address'),
			'sale_comment' => breq_post_value($post, 'sale_comment'),
			'iv_no'        => breq_post_value($post, 'admin_doc_no'),
			'iv_date'      => $ivDate !== '' ? $ivDate : '0000-00-00',
		);

		$addBy = breq_session_add_by($session);
		$addDate = date('Y-m-d H:i:s');
		$created = false;

		// Submit = ส่งให้ Sup อนุมัติในตัว (รวมขั้น "ส่ง Sup อนุมัติ" เดิมเข้ามา) — ค่าเดียวกับ sendmail_approvebr_breq.php
		$sendSupFields = $mode === 'submit'
			? array('send_sup' => '1', 'send_supname' => $addBy, 'send_supdate' => $addDate)
			: array('send_sup' => '0');

		if ($refId === '') {
			$refId = breq_reserve_ref_id($conn, array_merge($headerFields, $sendSupFields, array(
				'type_breng' => '2',
				'date_br'    => date('Y-m-d'),
				'customer'   => $addBy,
				'sale'       => (string)($session['name'] ?? ''),
				'sale_code'  => (string)($session['code'] ?? ''),
				'sale_date'  => date('Y-m-d'),
				'status_doc' => $mode === 'draft' ? 'Draft' : 'Request',
				'add_date'   => $addDate,
				'add_by'     => $addBy,
			)));
			$created = true;
		}

		mysqli_begin_transaction($conn);
		try {
			if (!$created) {
				$doc = breq_lock_document($conn, $refId, $session);
				$previousStatus = (string)$doc['status_doc'];
				$allowedStatus = ($mode === 'update') ? 'Request' : 'Draft';
				if ($previousStatus !== $allowedStatus) {
					throw new BreqValidationException('เอกสาร ' . $refId . ' อยู่ในสถานะ ' . $previousStatus . ' แล้ว ไม่สามารถบันทึกได้');
				}

				$set = $headerFields;
				if ($mode === 'submit') {
					$set['status_doc'] = 'Request';
					$set = array_merge($set, $sendSupFields);
				}
				$assignments = array();
				foreach (array_keys($set) as $column) {
					$assignments[] = '`' . $column . '` = ?';
				}
				$values = array_map('strval', array_values($set));
				$values[] = $refId;
				breq_execute(
					$conn,
					'UPDATE in__br SET ' . implode(', ', $assignments) . ' WHERE ref_id_br = ?',
					str_repeat('s', count($values)),
					$values
				);
			}

			breq_replace_items($conn, $refId, $poNo, $items);

			// Draft ยังไม่ถือว่ายืมจริง — ผลข้างเคียงกับตารางอื่นเกิดเมื่อเอกสารเป็น Request แล้ว
			if ($mode !== 'draft') {
				breq_mark_sn_products($conn, $items);
			}
			if ($mode === 'submit') {
				breq_insert_submit_side_tables($conn, $refId, $post, $company, $addBy, (string)($session['emid'] ?? ''), $addDate);
			}

			mysqli_commit($conn);
		} catch (Throwable $e) {
			mysqli_rollback($conn);
			if ($created) {
				// หัวเอกสารถูก commit ไปแล้วตอนจองเลข — ลบทิ้งไม่ให้เหลือหัวเปล่า
				try {
					breq_execute($conn, "DELETE FROM in__br WHERE ref_id_br = ?", 's', array($refId));
				} catch (Throwable $cleanupError) {
					error_log('[breq_persist] cleanup ' . $refId . ': ' . $cleanupError->getMessage());
				}
			}
			throw $e;
		}

		return array('ref_id' => $refId, 'created' => $created);
	}
}
