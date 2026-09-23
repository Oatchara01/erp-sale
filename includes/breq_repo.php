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
	 * ไม่นับใบ Rejected (ไม่อนุมัติ/ยกเลิก) — คืนยอดให้ยืมทันทีที่ใบถูกปิด (ต้องตรงกับ ajax_breq_po_items.php)
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
			"SELECT SUM(s.count) AS sum_count
			 FROM in__subbr s
			 INNER JOIN in__br b ON b.ref_id_br = s.ref_idd_br
			 WHERE s.po_no = ? AND s.product_id = ? AND s.ref_idd_br <> ? AND b.status_doc <> 'Rejected'",
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
	function breq_insert_submit_side_tables($conn, $refId, array $post, $company, $addBy, $emId, $addDate, $withOtherBill = true, $withRegister = true)
	{
		$v = function ($key) use ($post) {
			return breq_post_value($post, $key);
		};
		$flag = function ($key) use ($post) {
			$value = breq_post_value($post, $key);
			return $value !== '' ? $value : '0';
		};

		if ($withOtherBill) {
			$otherBill = array('ref_id' => $refId, 'head_1' => $v('head_1'));
			for ($i = 1; $i <= 11; $i++) {
				$otherBill['ref_' . $i] = $v('ref_' . $i);
			}
			$otherBill['ref_des'] = $v('ref_des');
			breq_insert_row($conn, 'tb_other_bill', $otherBill);
		}
		if (!$withRegister) {
			return;
		}

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

if (!function_exists('breq_insert_submit_side_tables_once')) {
	/** Submit ซ้ำ (หลังถูกส่งกลับ / ใบเก่าที่ยังไม่ส่ง Sup) ไม่ insert tb_other_bill / tb_register_data ซ้ำ — มีแถวแล้วข้าม */
	function breq_insert_submit_side_tables_once($conn, $refId, array $post, $company, $addBy, $emId, $addDate)
	{
		$hasOtherBill = breq_fetch_one($conn, "SELECT 1 AS hit FROM tb_other_bill WHERE ref_id = ? LIMIT 1", 's', array($refId)) !== null;
		$hasRegister = breq_fetch_one($conn, "SELECT 1 AS hit FROM tb_register_data WHERE ref_id = ? LIMIT 1", 's', array($refId)) !== null;
		breq_insert_submit_side_tables($conn, $refId, $post, $company, $addBy, $emId, $addDate, !$hasOtherBill, !$hasRegister);
	}
}

/* ===================== สิทธิ์ / สถานะ =====================
 * ตรวจฝั่ง server ทุกครั้ง (การซ่อน/แสดงปุ่มในหน้าเป็นแค่ UX) — ใช้ชุดเดียวกันทั้งหน้าใบ หน้าคิว และ endpoint
 *
 *   Draft                     → เจ้าของแก้ได้  / Submit, Save Draft, ยกเลิก
 *   Returned                  → เจ้าของแก้ได้  / Submit ใหม่, Update, ยกเลิก
 *   Request + send_sup <> 1   → เจ้าของแก้ได้  / ส่ง Sup (Submit), Update, ยกเลิก  (ใบเก่าจาก flow ที่ต้องกดส่ง Sup แยก)
 *   Request + send_sup = 1    → Sup แก้ได้     / อนุมัติ, ส่งกลับ, ไม่อนุมัติ, ยกเลิก
 *   Approve                   → Admin แก้ได้เฉพาะเลขที่/วันที่เอกสาร (แท็บ Admin)
 *   Rejected                  → ดูอย่างเดียว
 */

if (!function_exists('breq_sup_approver_names')) {
	/** ผู้อนุมัติ BREQ (ด่าน Sup) — ตามชื่อเหมือนเมนูเดิม menu_suphos.php ที่แสดง "อนุมัติใบยืม BREQ" */
	function breq_sup_approver_names()
	{
		return array('บรรเทิง');
	}
}

if (!function_exists('breq_user_is_sup')) {
	function breq_user_is_sup(array $session)
	{
		return in_array(trim((string)($session['name'] ?? '')), breq_sup_approver_names(), true);
	}
}

if (!function_exists('breq_user_is_admin')) {
	function breq_user_is_admin(array $session)
	{
		return (string)($session['type_login'] ?? '') === 'Admin';
	}
}

if (!function_exists('breq_is_awaiting_sup')) {
	/** ใบอยู่ในคิว Sup — เงื่อนไขเดียวกับ status_approvebrsup_breq.php */
	function breq_is_awaiting_sup(array $doc)
	{
		return (string)($doc['status_doc'] ?? '') === 'Request' && (string)($doc['send_sup'] ?? '') === '1';
	}
}

if (!function_exists('breq_is_owner_stage')) {
	/** ใบอยู่ในมือเจ้าของ (ยังไม่ส่ง Sup / ถูกส่งกลับ) */
	function breq_is_owner_stage(array $doc)
	{
		$status = (string)($doc['status_doc'] ?? '');
		return $status === 'Draft' || $status === 'Returned' || ($status === 'Request' && !breq_is_awaiting_sup($doc));
	}
}

if (!function_exists('breq_user_can_edit_document')) {
	/** แก้ค่าในฟอร์มได้หรือไม่ (Save Draft / Update / Submit / ค่าที่ส่งมากับอนุมัติ) */
	function breq_user_can_edit_document(array $doc, array $session)
	{
		if (breq_is_owner_stage($doc)) {
			return breq_can_edit_owner($doc, $session);
		}
		if (breq_is_awaiting_sup($doc)) {
			return breq_user_is_sup($session);
		}
		return false;
	}
}

if (!function_exists('breq_user_can_act_as_sup')) {
	/** อนุมัติ / ส่งกลับ / ไม่อนุมัติ */
	function breq_user_can_act_as_sup(array $doc, array $session)
	{
		return breq_is_awaiting_sup($doc) && breq_user_is_sup($session);
	}
}

if (!function_exists('breq_user_can_cancel')) {
	/** ยกเลิกเอกสาร: ใบในมือเจ้าของ → เจ้าของหรือ Sup / ใบในคิว Sup → Sup */
	function breq_user_can_cancel(array $doc, array $session)
	{
		if (breq_is_owner_stage($doc)) {
			return breq_can_edit_owner($doc, $session) || breq_user_is_sup($session);
		}
		return breq_user_can_act_as_sup($doc, $session);
	}
}

if (!function_exists('breq_user_can_admin_edit')) {
	/** Admin เติม/แก้เลขที่และวันที่เอกสารของใบที่อนุมัติแล้ว (Sup ไม่ออกเลขให้ตอนอนุมัติ) */
	function breq_user_can_admin_edit(array $doc, array $session)
	{
		return (string)($doc['status_doc'] ?? '') === 'Approve' && breq_user_is_admin($session);
	}
}

if (!function_exists('breq_lock_document')) {
	/** ต้องเรียกภายในทรานแซกชัน — ล็อกแถวหัวเอกสาร (สิทธิ์ตรวจแยกตาม action) */
	function breq_lock_document($conn, $refId)
	{
		$doc = breq_fetch_one($conn, "SELECT * FROM in__br WHERE ref_id_br = ? LIMIT 1 FOR UPDATE", 's', array($refId));
		if ($doc === null) {
			throw new BreqValidationException('ไม่พบเอกสาร ' . $refId);
		}
		return $doc;
	}
}

if (!function_exists('breq_header_fields_from_post')) {
	/** คอลัมน์หัวเอกสารที่ฟอร์มแก้ได้ */
	function breq_header_fields_from_post(array $post)
	{
		$ivDate = breq_post_value($post, 'admin_doc_date');
		return array(
			'company'      => breq_post_value($post, 'company'),
			'ref_id_stock' => breq_post_value($post, 'ref_id_stock'),
			'po_no'        => breq_post_value($post, 'po_no'),
			'customer_id'  => (int)breq_post_value($post, 'customer_id'),
			'address'      => breq_post_value($post, 'address'),
			'sale_comment' => breq_post_value($post, 'sale_comment'),
			'iv_no'        => breq_post_value($post, 'admin_doc_no'),
			'iv_date'      => $ivDate !== '' ? $ivDate : '0000-00-00',
		);
	}
}

if (!function_exists('breq_update_header')) {
	/**
	 * UPDATE in__br ตาม array คอลัมน์ => ค่า
	 * $statusGuard (SQL คงที่ ไม่มีค่าจากผู้ใช้) ใส่เมื่อเปลี่ยนสถานะ — ไม่มีแถวถูกแก้ = มีคนเปลี่ยนสถานะไปก่อนแล้ว
	 */
	function breq_update_header($conn, $refId, array $set, $statusGuard = '')
	{
		$assignments = array();
		foreach (array_keys($set) as $column) {
			$assignments[] = '`' . $column . '` = ?';
		}
		$values = array_map('strval', array_values($set));
		$values[] = $refId;
		$affected = breq_execute(
			$conn,
			'UPDATE in__br SET ' . implode(', ', $assignments) . ' WHERE ref_id_br = ?' . ($statusGuard !== '' ? ' AND ' . $statusGuard : ''),
			str_repeat('s', count($values)),
			$values
		);
		if ($statusGuard !== '' && $affected < 1) {
			throw new BreqValidationException('เอกสารถูกเปลี่ยนสถานะไปแล้ว กรุณาโหลดหน้าใหม่');
		}
	}
}

if (!function_exists('breq_log_status')) {
	/** ประวัติลง tb_document_status_log — เรียกในทรานแซกชันเดียวกับการเปลี่ยนสถานะ */
	function breq_log_status($conn, $refId, $statusLabel, $reason, array $session)
	{
		breq_insert_row($conn, 'tb_document_status_log', array(
			'ref_id'    => $refId,
			'status_doc' => $statusLabel,
			'reason'    => $reason,
			'user_id'   => (string)($session['UserID'] ?? ''),
			'user_name' => breq_session_add_by($session),
		));
	}
}

if (!function_exists('breq_persist')) {
	/**
	 * @param string $mode draft | submit | update
	 *   draft  : สร้างใหม่หรือบันทึกทับ Draft เดิม (status_doc = 'Draft')
	 *   submit : สร้างใหม่ / Draft / Returned / Request ที่ยังไม่ส่ง Sup → Request + ส่ง Sup อนุมัติ (send_sup = 1)
	 *            + side effect เดิม (sale_ckk, tb_other_bill, tb_register_data — ไม่ insert ซ้ำถ้ามีแล้ว)
	 *   update : แก้ Returned / Request โดยไม่เปลี่ยนสถานะ (ต้องครบเหมือน submit) — Draft ใช้ mode draft
	 * สิทธิ์ตาม breq_user_can_edit_document (เจ้าของ = ใบในมือเจ้าของ, Sup = ใบในคิว Sup)
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

		$headerFields = breq_header_fields_from_post($post);

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
				$doc = breq_lock_document($conn, $refId);
				$previousStatus = (string)$doc['status_doc'];
				if ($mode === 'draft') {
					$statusOk = ($previousStatus === 'Draft');
				} elseif ($mode === 'submit') {
					$statusOk = breq_is_owner_stage($doc);
				} else {
					$statusOk = ($previousStatus === 'Returned' || $previousStatus === 'Request');
				}
				if (!$statusOk) {
					throw new BreqValidationException('เอกสาร ' . $refId . ' อยู่ในสถานะ ' . $previousStatus . ' แล้ว ไม่สามารถบันทึกได้ กรุณาโหลดหน้าใหม่');
				}
				if (!breq_user_can_edit_document($doc, $session)) {
					throw new BreqValidationException('คุณไม่มีสิทธิ์แก้ไขเอกสาร ' . $refId . ' ในสถานะปัจจุบัน');
				}

				$set = $headerFields;
				if ($mode === 'submit') {
					$set['status_doc'] = 'Request';
					$set = array_merge($set, $sendSupFields);
				}
				breq_update_header($conn, $refId, $set);
			}

			breq_replace_items($conn, $refId, $poNo, $items);

			// Draft ยังไม่ถือว่ายืมจริง — ผลข้างเคียงกับตารางอื่นเกิดเมื่อเอกสารเป็น Request แล้ว
			if ($mode !== 'draft') {
				breq_mark_sn_products($conn, $items);
			}
			if ($mode === 'submit') {
				breq_insert_submit_side_tables_once($conn, $refId, $post, $company, $addBy, (string)($session['emid'] ?? ''), $addDate);
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

/* ===================== ขั้นอนุมัติ (แทน breng_approve_breq.php / brhos_rejected_breq.php ที่รับ GET) ===================== */

if (!function_exists('breq_run_document_action')) {
	/**
	 * @param string $action approve | return | reject | cancel
	 *   approve : Sup — บันทึกค่าฟอร์มล่าสุด (ตรวจครบเหมือน submit) แล้ว status_doc = 'Approve', send_admin = 1
	 *             ไม่ออกเลขที่เอกสาร (iv_no) ให้ — Sup กด Run ในแท็บ Admin เอง หรือ Admin เติมภายหลัง
	 *   return  : Sup — status_doc = 'Returned', send_sup = 0 ให้เจ้าของแก้แล้ว Submit ใหม่
	 *   reject  : Sup — status_doc = 'Rejected'
	 *   cancel  : เจ้าของ (ใบในมือเจ้าของ) หรือ Sup — status_doc = 'Rejected' แยกจาก reject ด้วย log 'Cancelled'
	 * return/reject/cancel ต้องมีเหตุผล (log + in__br.remark_cancel) และไม่บันทึกค่าฟอร์ม
	 * reject/cancel รีเซ็ต tb_register_data.start_date เหมือน brhos_rejected_breq.php — ไม่คืน tb_product.sale_ckk (ตามของเดิม)
	 * @return array{ref_id: string, outcome: string}
	 */
	function breq_run_document_action($conn, $stockConn, $refId, $action, $reason, array $post, array $session)
	{
		$refId = trim((string)$refId);
		$reason = trim((string)$reason);
		if ($refId === '') {
			throw new BreqValidationException('ไม่พบเลขที่เอกสาร');
		}
		if (!in_array($action, array('approve', 'return', 'reject', 'cancel'), true)) {
			throw new BreqValidationException('คำสั่งไม่ถูกต้อง');
		}
		if ($action !== 'approve' && $reason === '') {
			throw new BreqValidationException('กรุณาระบุเหตุผล');
		}

		$actorName = (string)($session['name'] ?? '');
		$actorCode = (string)($session['code'] ?? '');
		$today = date('Y-m-d');
		$outcomes = array('approve' => 'approved', 'return' => 'returned', 'reject' => 'rejected', 'cancel' => 'cancelled');

		mysqli_begin_transaction($conn);
		try {
			$doc = breq_lock_document($conn, $refId);

			if ($action === 'cancel') {
				if (!breq_is_owner_stage($doc) && !breq_is_awaiting_sup($doc)) {
					throw new BreqValidationException('เอกสาร ' . $refId . ' อยู่ในสถานะ ' . $doc['status_doc'] . ' แล้ว ไม่สามารถยกเลิกได้');
				}
				if (!breq_user_can_cancel($doc, $session)) {
					throw new BreqValidationException('คุณไม่มีสิทธิ์ยกเลิกเอกสารนี้');
				}
			} else {
				if (!breq_is_awaiting_sup($doc)) {
					throw new BreqValidationException('เอกสารไม่ได้อยู่ในสถานะรออนุมัติแล้ว กรุณาโหลดหน้าใหม่');
				}
				if (!breq_user_is_sup($session)) {
					throw new BreqValidationException('คุณไม่มีสิทธิ์อนุมัติเอกสารนี้');
				}
			}

			$awaitingGuard = "status_doc = 'Request' AND send_sup = '1'";
			if ($action === 'approve') {
				$company = breq_post_value($post, 'company');
				$poNo = breq_post_value($post, 'po_no');
				$items = breq_items_from_post($post);
				breq_validate($conn, $stockConn, 'submit', $company, $poNo, $items, $refId);

				breq_update_header($conn, $refId, array_merge(breq_header_fields_from_post($post), array(
					'status_doc'   => 'Approve',
					'approve'      => $actorName,
					'approve_code' => $actorCode,
					'approve_date' => $today,
					'approve_time' => date('H:i:s'),
					'send_admin'   => '1',
				)), $awaitingGuard);
				breq_replace_items($conn, $refId, $poNo, $items);
				breq_mark_sn_products($conn, $items);
				breq_log_status($conn, $refId, 'Sup Approved', '', $session);
			} elseif ($action === 'return') {
				breq_update_header($conn, $refId, array(
					'status_doc'    => 'Returned',
					'send_sup'      => '0',
					'remark_cancel' => $reason,
				), $awaitingGuard);
				breq_log_status($conn, $refId, 'Returned', $reason, $session);
			} else {
				$set = array('status_doc' => 'Rejected', 'remark_cancel' => $reason);
				if ($action === 'reject') {
					$set['approve'] = $actorName;
					$set['approve_code'] = $actorCode;
					$set['approve_date'] = $today;
				}
				breq_update_header($conn, $refId, $set, $action === 'reject' ? $awaitingGuard : "status_doc IN ('Draft', 'Returned', 'Request')");
				breq_execute($conn, "UPDATE tb_register_data SET start_date = '0000-00-00' WHERE ref_id = ?", 's', array($refId));
				breq_log_status($conn, $refId, $action === 'reject' ? 'Rejected' : 'Cancelled', $reason, $session);
			}

			mysqli_commit($conn);
		} catch (Throwable $e) {
			mysqli_rollback($conn);
			throw $e;
		}

		return array('ref_id' => $refId, 'outcome' => $outcomes[$action]);
	}
}

if (!function_exists('breq_admin_save_doc_no')) {
	/** Admin บันทึกเลขที่/วันที่เอกสารของใบที่อนุมัติแล้ว (แก้ซ้ำได้) — เขียน admin / admin_code / admin_date แบบหน้าอนุมัติเดิม */
	function breq_admin_save_doc_no($conn, $refId, array $post, array $session)
	{
		$refId = trim((string)$refId);
		$docNo = breq_post_value($post, 'admin_doc_no');
		$docDate = breq_post_value($post, 'admin_doc_date');
		if ($refId === '') {
			throw new BreqValidationException('ไม่พบเลขที่เอกสาร');
		}
		if ($docNo === '') {
			throw new BreqValidationException('กรุณาระบุเลขที่เอกสาร หรือกด Run เอกสาร');
		}
		if ($docDate !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $docDate)) {
			throw new BreqValidationException('วันที่ออกเอกสารไม่ถูกต้อง');
		}

		mysqli_begin_transaction($conn);
		try {
			$doc = breq_lock_document($conn, $refId);
			if (!breq_user_can_admin_edit($doc, $session)) {
				throw new BreqValidationException('คุณไม่มีสิทธิ์แก้ไขเลขที่เอกสารของใบนี้');
			}
			breq_update_header($conn, $refId, array(
				'iv_no'      => $docNo,
				'iv_date'    => $docDate !== '' ? $docDate : date('Y-m-d'),
				'iv_time'    => date('H:i:s'),
				'admin'      => (string)($session['name'] ?? ''),
				'admin_code' => (string)($session['code'] ?? ''),
				'admin_date' => date('Y-m-d H:i:s'),
			));
			breq_log_status($conn, $refId, 'Admin Doc No', $docNo, $session);
			mysqli_commit($conn);
		} catch (Throwable $e) {
			mysqli_rollback($conn);
			throw $e;
		}

		return array('ref_id' => $refId, 'outcome' => 'admin_saved');
	}
}
