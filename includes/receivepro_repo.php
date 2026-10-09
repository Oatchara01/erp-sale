<?php

/**
 * ชั้นบันทึกข้อมูลของใบส่งสินค้า / ใบรับสินค้า (hos__proreceive / hos__subproreceive)
 *
 * ใช้ร่วมกันโดย
 *   - register_receivepro.php   (สร้างใหม่ / เปิดร่าง / แก้เอกสารที่ Submit แล้ว)
 *   - register_receivepro1.php  (rp_action = draft / submit / update / send_receive / cancel)
 *   - status_receivepro_adm.php (ป้ายสถานะ)
 *
 * prepared statement + transaction ทั้งหมด — ยืม helper กลางจาก includes/po_repo.php
 * (po_stmt_exec, named lock, po_column_exists, tb_document_status_log)
 * สถานะเอกสารอยู่ที่ hos__proreceive.status_doc (sql/receivepro_status_doc.sql)
 */

require_once __DIR__ . '/po_repo.php';

if (!defined('RP_STATUS_DRAFT')) {
	define('RP_STATUS_DRAFT', 'Draft');
	define('RP_STATUS_SUBMITTED', 'Submitted');
	define('RP_MAX_ITEMS', 100);
	define('RP_PRODUCT_SEARCH_LIMIT', 50);
}

if (!class_exists('RpValidationException')) {
	/**
	 * ข้อผิดพลาดที่ "แสดงให้ผู้ใช้เห็นได้" — กรอกไม่ครบ/ผิดรูปแบบ หรือเอกสารเปลี่ยนสถานะไปแล้ว
	 * RuntimeException อื่นในไฟล์นี้พก error ของ MySQL มา ห้ามส่งกลับหน้าเว็บตรง ๆ
	 */
	class RpValidationException extends RuntimeException
	{
	}
}

if (!function_exists('rp_has_status_column')) {
	/** ฐานที่ยังไม่ได้รัน sql/receivepro_status_doc.sql — หน้า form ต้องหยุดก่อนบันทึก */
	function rp_has_status_column($conn)
	{
		return po_column_exists($conn, 'hos__proreceive', 'status_doc')
			&& po_column_exists($conn, 'hos__proreceive', 'remark_cancel')
			&& po_column_exists($conn, 'hos__subproreceive', 'sort_no');
	}
}

if (!function_exists('rp_company_options')) {
	/** mapping เดิมของ hos__proreceive.type_company: 1 = AWL, 2 = NBM */
	function rp_company_options()
	{
		return array('1' => 'AWL', '2' => 'NBM');
	}
}

if (!function_exists('rp_type_company')) {
	/** type_company → tb_product.type_company */
	function rp_type_company($typeCompany)
	{
		return ((string)$typeCompany === '2') ? 'NBM' : 'AWL';
	}
}

if (!function_exists('rp_company_full_name')) {
	/** ชื่อบริษัทที่ส่งไปฝั่งรับจ่าย (tb_register_data.company) — ข้อความเดิมจาก register_receivepro_soedit1.php */
	function rp_company_full_name($typeCompany)
	{
		return ((string)$typeCompany === '2') ? 'โนเบิล เมด บจก.' : 'ออลล์เวล ไลฟ์ บจก.';
	}
}

if (!function_exists('rp_print_forms')) {
	/** แบบฟอร์มพิมพ์ทั้งหมด (ไฟล์ => ชื่อที่แสดงในเมนูพิมพ์) */
	function rp_print_forms()
	{
		return array(
			'form_scg.php'          => 'SCG',
			'form_scgexpress.php'   => 'SCG EXPERIENCE',
			'form_nexter.php'       => 'NEXTER',
			'form_nexterliving.php' => 'NEXTER LIVING',
			'form_normal.php'       => 'ลูกค้าทั่วไป / ลูกค้า ร.พ.',
			'form_nexx.php'         => 'NEXTER LIVING NEW',
			'rece_bauen.php'        => 'BAUEN BY SCG',
			'form_24shop.php'       => '24 SHOPPING',
		);
	}
}

if (!function_exists('rp_year_month')) {
	function rp_year_month()
	{
		// รูปแบบเดิม: 2 หลักท้ายของปี พ.ศ. + เดือน 2 หลัก → RP + yymm + ###
		return substr((string)(date('Y') + 543), -2) . date('m');
	}
}

if (!function_exists('rp_next_running_number')) {
	function rp_next_running_number($conn, $yearMonth)
	{
		$stmt = mysqli_prepare($conn, "SELECT MAX(CAST(SUBSTRING(rp_no, 7) AS UNSIGNED)) AS max_running FROM hos__proreceive WHERE rp_no LIKE ?");
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		$like = 'RP' . $yearMonth . '%';
		mysqli_stmt_bind_param($stmt, 's', $like);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
		return (int)($row['max_running'] ?? 0) + 1;
	}
}

if (!function_exists('rp_format_rp_no')) {
	function rp_format_rp_no($yearMonth, $running)
	{
		return 'RP' . $yearMonth . str_pad((string)(int)$running, 3, '0', STR_PAD_LEFT);
	}
}

if (!function_exists('rp_peek_next_rp_no')) {
	/** เลขถัดไป "โดยประมาณ" สำหรับหัวฟอร์ม — จองจริงตอน Save Draft / Submit ครั้งแรกเท่านั้น */
	function rp_peek_next_rp_no($conn)
	{
		$yearMonth = rp_year_month();
		return rp_format_rp_no($yearMonth, rp_next_running_number($conn, $yearMonth));
	}
}

if (!function_exists('rp_load_document')) {
	function rp_load_document($conn, $rpNo, $forUpdate = false)
	{
		$stmt = mysqli_prepare($conn, "SELECT * FROM hos__proreceive WHERE rp_no = ? LIMIT 1" . ($forUpdate ? " FOR UPDATE" : ""));
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		mysqli_stmt_bind_param($stmt, 's', $rpNo);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
		return $row ?: null;
	}
}

if (!function_exists('rp_document_status')) {
	/** แถวเดิมก่อน migration ไม่มีคอลัมน์ = เอกสารจริงทั้งหมด */
	function rp_document_status(array $row)
	{
		$status = isset($row['status_doc']) ? trim((string)$row['status_doc']) : '';
		return $status === '' ? RP_STATUS_SUBMITTED : $status;
	}
}

if (!function_exists('rp_is_draft')) {
	function rp_is_draft(array $row)
	{
		return rp_document_status($row) === RP_STATUS_DRAFT;
	}
}

if (!function_exists('rp_is_cancelled')) {
	function rp_is_cancelled(array $row)
	{
		return (string)($row['cancel_ckk'] ?? '0') === '1';
	}
}

if (!function_exists('rp_is_sent_receive')) {
	function rp_is_sent_receive(array $row)
	{
		return (string)($row['send_receive'] ?? '0') === '2';
	}
}

if (!function_exists('rp_mode')) {
	/** new = ใบใหม่ | draft = ร่าง | cancelled = ยกเลิกแล้ว (อ่านอย่างเดียว) | submitted = เอกสารจริง */
	function rp_mode($row)
	{
		if ($row === null) {
			return 'new';
		}
		if (rp_is_draft($row)) {
			return 'draft';
		}
		return rp_is_cancelled($row) ? 'cancelled' : 'submitted';
	}
}

if (!function_exists('rp_status_info')) {
	/**
	 * ป้ายสถานะของหน้ารายการ (status_receivepro_adm.php)
	 * @return array{key:string,label:string,color:string}
	 */
	function rp_status_info(array $row)
	{
		if (rp_is_draft($row)) {
			return array('key' => 'draft', 'label' => 'Draft', 'color' => '#FFA500');
		}
		if (rp_is_cancelled($row)) {
			return array('key' => 'cancelled', 'label' => 'ยกเลิก', 'color' => '#FF0000');
		}
		return array('key' => 'submitted', 'label' => '', 'color' => '');
	}
}

if (!function_exists('rp_trim_number')) {
	/** 2.00 → "2", 2.50 → "2.5" สำหรับเติมกลับลงช่องกรอก */
	function rp_trim_number($value)
	{
		$text = number_format((float)$value, 2, '.', '');
		$text = rtrim(rtrim($text, '0'), '.');
		return $text === '' ? '0' : $text;
	}
}

if (!function_exists('rp_iso_date_input')) {
	/** วันที่ว่างของ Draft ถูกเก็บเป็น 0000-00-00 — ช่อง type="date" ต้องได้ค่าว่าง */
	function rp_iso_date_input($value)
	{
		$value = substr(trim((string)$value), 0, 10);
		return rp_valid_iso_date($value) ? $value : '';
	}
}

if (!function_exists('rp_valid_iso_date')) {
	function rp_valid_iso_date($value)
	{
		if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', (string)$value, $m)) {
			return false;
		}
		return (int)$m[1] > 0 && checkdate((int)$m[2], (int)$m[3], (int)$m[1]);
	}
}

if (!function_exists('rp_load_items')) {
	function rp_load_items($conn, $rpNo)
	{
		$stmt = mysqli_prepare($conn, "SELECT s.id, s.product_id, s.`count` AS qty, s.amount, s.sale_remark, s.proname, s.ckk_name,
				p.access_code, p.sol_name
			FROM hos__subproreceive s
			LEFT JOIN tb_product p ON p.product_ID = s.product_id
			WHERE s.ref_rpno = ?
			ORDER BY s.sort_no ASC, s.id ASC");
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		mysqli_stmt_bind_param($stmt, 's', $rpNo);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$rows = array();
		while ($result && ($row = mysqli_fetch_assoc($result))) {
			$rows[] = $row;
		}
		mysqli_stmt_close($stmt);
		return $rows;
	}
}

if (!function_exists('rp_items_for_form')) {
	/**
	 * แถวสินค้าสำหรับ js/register-receivepro.js
	 * proname ส่งให้เฉพาะแถวที่ ckk_name = 1 — ชื่อที่เคยกรอกไว้แต่ไม่ได้ติ๊กใช้ (ข้อมูลเก่า) ต้องไม่ถูกเปิดใช้เองตอนบันทึกซ้ำ
	 */
	function rp_items_for_form(array $items)
	{
		$rows = array();
		foreach ($items as $item) {
			$rows[] = array(
				'id'          => (string)$item['id'],
				'product_id'  => (string)$item['product_id'],
				'access_code' => (string)($item['access_code'] ?? ''),
				'sol_name'    => (string)($item['sol_name'] ?? ''),
				'qty'         => rp_trim_number($item['qty']),
				'amount'      => number_format((float)$item['amount'], 2, '.', ''),
				'remark'      => (string)$item['sale_remark'],
				'proname'     => ((string)$item['ckk_name'] === '1') ? (string)$item['proname'] : '',
			);
		}
		return $rows;
	}
}

if (!function_exists('rp_post_value')) {
	function rp_post_value(array $post, $key, $default = '')
	{
		if (!isset($post[$key]) || is_array($post[$key])) {
			return $default;
		}
		return trim((string)$post[$key]);
	}
}

if (!function_exists('rp_parse_number')) {
	/** คืน null เมื่อไม่ใช่ตัวเลข — ช่องว่างถือเป็น $emptyValue */
	function rp_parse_number($raw, $emptyValue = 0.0)
	{
		$text = trim(str_replace(',', '', (string)$raw));
		if ($text === '') {
			return $emptyValue;
		}
		return preg_match('/^\d+(\.\d+)?$/', $text) ? (float)$text : null;
	}
}

if (!function_exists('rp_limit_text')) {
	function rp_limit_text($value, $max, $label)
	{
		if (mb_strlen($value, 'UTF-8') > $max) {
			throw new RpValidationException($label . ' ยาวเกิน ' . $max . ' ตัวอักษร');
		}
		return $value;
	}
}

if (!function_exists('rp_header_from_post')) {
	/** หัวเอกสารจากฟอร์ม — ตรวจรูปแบบเสมอ ส่วน "ต้องกรอก" ตรวจที่ rp_validate_required() */
	function rp_header_from_post(array $post)
	{
		$typeCompany = rp_post_value($post, 'type_company');
		if (!array_key_exists($typeCompany, rp_company_options())) {
			throw new RpValidationException('กรุณาเลือกบริษัท');
		}
		$showName = rp_post_value($post, 'show_name', '1');
		if ($showName !== '1' && $showName !== '2') {
			$showName = '1';
		}

		$dates = array();
		foreach (array('iv_date' => 'วันที่ออกเอกสาร', 'delivery_date' => 'วันที่ส่งของ') as $key => $label) {
			$value = rp_post_value($post, $key);
			if ($value !== '' && !rp_valid_iso_date($value)) {
				throw new RpValidationException($label . 'ไม่ถูกต้อง');
			}
			$dates[$key] = $value;
		}

		return array(
			'type_company'  => $typeCompany,
			'iv_noref'      => rp_limit_text(rp_post_value($post, 'iv_noref'), 50, 'เลขที่เอกสาร'),
			'iv_date'       => $dates['iv_date'],
			'delivery_date' => $dates['delivery_date'],
			'sale_code'     => rp_limit_text(rp_post_value($post, 'sale_code'), 50, 'แผนก/เขตการขาย'),
			'show_name'     => $showName,
			'customer'      => rp_limit_text(rp_post_value($post, 'customer'), 300, 'ชื่อลูกค้า'),
			'address'       => rp_limit_text(rp_post_value($post, 'address'), 300, 'ที่อยู่'),
			'bill_name'     => rp_limit_text(rp_post_value($post, 'bill_name'), 300, 'ชื่อออกบิล'),
			'bill_address'  => rp_limit_text(rp_post_value($post, 'bill_address'), 300, 'ที่อยู่ออกบิล'),
		);
	}
}

if (!function_exists('rp_collect_items_from_post')) {
	/**
	 * แถวสินค้าจากฟอร์ม (item_id[] / item_product_id[] / item_qty[] / item_amount[] / item_remark[] / item_proname[])
	 * ลำดับใน array = ลำดับที่ผู้ใช้ลากเรียง → sort_no
	 * $strict = เอกสารจริง (Submit / Update): จำนวนต้องมากกว่า 0
	 */
	function rp_collect_items_from_post(array $post, $strict)
	{
		$productIds = (isset($post['item_product_id']) && is_array($post['item_product_id'])) ? array_values($post['item_product_id']) : array();
		if (count($productIds) > RP_MAX_ITEMS) {
			throw new RpValidationException('รายการสินค้าเกิน ' . RP_MAX_ITEMS . ' รายการ');
		}
		$column = function ($key) use ($post) {
			return (isset($post[$key]) && is_array($post[$key])) ? array_values($post[$key]) : array();
		};
		$ids = $column('item_id');
		$qtys = $column('item_qty');
		$amounts = $column('item_amount');
		$remarks = $column('item_remark');
		$pronames = $column('item_proname');

		$rows = array();
		foreach ($productIds as $index => $rawProductId) {
			$productId = (int)$rawProductId;
			if ($productId <= 0) {
				continue;
			}
			$label = 'รายการที่ ' . (count($rows) + 1);
			$qty = rp_parse_number($qtys[$index] ?? '');
			$amount = rp_parse_number($amounts[$index] ?? '');
			if ($qty === null || ($strict && $qty <= 0)) {
				throw new RpValidationException($label . ': จำนวนต้องเป็นตัวเลขมากกว่า 0');
			}
			if ($amount === null) {
				throw new RpValidationException($label . ': ยอดรวมต้องเป็นตัวเลขตั้งแต่ 0 ขึ้นไป');
			}
			$proname = rp_limit_text(trim((string)($pronames[$index] ?? '')), 500, $label . ': ชื่อที่แสดงในใบส่งสินค้า');
			$rows[] = array(
				'id'         => (int)($ids[$index] ?? 0),
				'product_id' => $productId,
				'qty'        => $qty,
				'amount'     => $amount,
				'remark'     => rp_limit_text(trim((string)($remarks[$index] ?? '')), 300, $label . ': หมายเหตุสินค้า'),
				'proname'    => $proname,
				// ไม่มีช่องติ๊ก "เลือกโชว์ชื่อ" แล้ว — กรอกชื่อไว้ = ให้แบบฟอร์มพิมพ์ใช้ชื่อนั้น
				'ckk_name'   => ($proname !== '') ? 1 : 0,
			);
		}
		return $rows;
	}
}

if (!function_exists('rp_validate_required')) {
	/** ฟิลด์ดอกจันของเอกสารจริง — ต้องตรงกับดอกจันบน register_receivepro.php */
	function rp_validate_required(array $header)
	{
		$required = array(
			'customer'     => 'ชื่อลูกค้า',
			'bill_name'    => 'ชื่อออกบิล',
			'bill_address' => 'ที่อยู่ออกบิล',
		);
		foreach ($required as $key => $label) {
			if ($header[$key] === '') {
				throw new RpValidationException('กรุณากรอก' . $label);
			}
		}
	}
}

if (!function_exists('rp_assert_products_of_company')) {
	/** สินค้าทุกแถวต้องมีจริงและเป็นของบริษัทที่เลือก — กันสินค้าต่างบริษัทปนกันจากการแก้ค่าฝั่งหน้าเว็บ */
	function rp_assert_products_of_company($conn, array $items, $typeCompany)
	{
		$productIds = array_values(array_unique(array_map(function ($item) {
			return (int)$item['product_id'];
		}, $items)));
		if (count($productIds) === 0) {
			return;
		}
		$placeholders = implode(',', array_fill(0, count($productIds), '?'));
		$stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS found FROM tb_product WHERE type_company = ? AND product_ID IN ($placeholders)");
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		$params = array_merge(array(rp_type_company($typeCompany)), $productIds);
		mysqli_stmt_bind_param($stmt, 's' . str_repeat('i', count($productIds)), ...$params);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
		if ((int)($row['found'] ?? 0) !== count($productIds)) {
			throw new RpValidationException('มีรายการสินค้าที่ไม่ใช่ของบริษัทที่เลือก กรุณาลบแล้วเพิ่มรายการใหม่');
		}
	}
}

if (!function_exists('rp_insert_items')) {
	function rp_insert_items($conn, $rpNo, array $items)
	{
		foreach ($items as $index => $item) {
			// product_code เก็บ product_ID ซ้ำกับ product_id ตามตัวบันทึกเดิม
			po_stmt_exec(
				$conn,
				"INSERT INTO hos__subproreceive (ref_rpno, sort_no, product_code, product_id, `count`, amount, sale_remark, proname, ckk_name)
				 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
				'siiiddssi',
				array($rpNo, $index + 1, $item['product_id'], $item['product_id'], $item['qty'], $item['amount'], $item['remark'], $item['proname'], $item['ckk_name'])
			);
		}
	}
}

if (!function_exists('rp_actor_name')) {
	function rp_actor_name(array $session)
	{
		return trim((string)($session['name'] ?? '') . ' ' . (string)($session['surname'] ?? ''));
	}
}

if (!function_exists('rp_persist')) {
	/**
	 * บันทึกจาก register_receivepro.php
	 *   draft  = บันทึกร่าง (ใบใหม่ หรือร่างเดิม) ไม่บังคับกรอก
	 *   submit = ใบใหม่/ร่าง → เอกสารจริง บังคับดอกจัน + สินค้าอย่างน้อย 1 รายการ
	 *   update = เอกสารจริง: แก้ได้เฉพาะข้อมูลลูกค้า, การแสดงชื่อ และค่าของแถวเดิม (แก้ค่า/ลบ/เรียง — เพิ่มแถวไม่ได้)
	 * @return array{rp_no:string,created:bool,status_doc:string}
	 */
	function rp_persist($conn, $mode, array $post, array $session)
	{
		if (!in_array($mode, array('draft', 'submit', 'update'), true)) {
			throw new RpValidationException('ไม่รู้จักคำสั่งบันทึก');
		}
		if (!rp_has_status_column($conn)) {
			throw new RpValidationException('ฐานข้อมูลยังไม่รองรับสถานะเอกสาร กรุณาแจ้งผู้ดูแลระบบให้รัน sql/receivepro_status_doc.sql');
		}
		// คอลัมน์เป็น NOT NULL ไม่มี DEFAULT — Draft ที่วันที่ยังว่างต้องพึ่ง implicit default แบบ non-strict เหมือนตัวบันทึกเดิม
		po_relax_sql_mode($conn);

		$rpNo = rp_post_value($post, 'rp_no');
		$header = rp_header_from_post($post);
		$items = rp_collect_items_from_post($post, $mode !== 'draft');

		if ($mode !== 'draft') {
			rp_validate_required($header);
		}
		// Update ตรวจจำนวนแถวที่ rp_update_submitted_items() — เอกสารเก่าที่ไม่มีแถวสินค้าเลยยังต้องแก้ข้อมูลลูกค้าได้
		if ($mode === 'submit' && count($items) === 0) {
			throw new RpValidationException('กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ');
		}

		if ($rpNo === '') {
			if ($mode === 'update') {
				throw new RpValidationException('ไม่พบเลขที่เอกสาร');
			}
			return rp_persist_new($conn, $mode, $header, $items, $session);
		}
		return rp_persist_existing($conn, $mode, $rpNo, $header, $items);
	}
}

if (!function_exists('rp_persist_new')) {
	function rp_persist_new($conn, $mode, array $header, array $items, array $session)
	{
		$statusDoc = ($mode === 'submit') ? RP_STATUS_SUBMITTED : RP_STATUS_DRAFT;
		// rp_no ไม่มี unique key — กันเลขชนด้วย named lock ครอบช่วง "หาเลขถัดไป → INSERT → COMMIT"
		$lockName = 'rp_no_reserve';
		if (!po_acquire_named_lock($conn, $lockName, 10)) {
			throw new RpValidationException('ระบบกำลังออกเลขที่เอกสารให้ผู้ใช้อื่นอยู่ กรุณากดบันทึกอีกครั้ง');
		}
		mysqli_begin_transaction($conn);
		try {
			rp_assert_products_of_company($conn, $items, $header['type_company']);
			$yearMonth = rp_year_month();
			$rpNo = rp_format_rp_no($yearMonth, rp_next_running_number($conn, $yearMonth));
			po_stmt_exec(
				$conn,
				"INSERT INTO hos__proreceive
					(rp_no, status_doc, type_company, iv_date, iv_noref, customer, address, bill_name, bill_address,
					 ref_iddoc, add_date, add_by, type_doc, sale_code, type_customer, delivery_date, reforder_id, show_name)
				 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '', ?, ?, '', ?, '', ?, '', ?)",
				'ssissssssssssi',
				array(
					$rpNo, $statusDoc, (int)$header['type_company'], $header['iv_date'], $header['iv_noref'],
					$header['customer'], $header['address'], $header['bill_name'], $header['bill_address'],
					date('Y-m-d H:i:s'), rp_actor_name($session), $header['sale_code'], $header['delivery_date'], (int)$header['show_name'],
				)
			);
			rp_insert_items($conn, $rpNo, $items);
			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			po_release_named_lock($conn, $lockName);
			throw $e;
		}
		po_release_named_lock($conn, $lockName);
		return array('rp_no' => $rpNo, 'created' => true, 'status_doc' => $statusDoc);
	}
}

if (!function_exists('rp_persist_existing')) {
	function rp_persist_existing($conn, $mode, $rpNo, array $header, array $items)
	{
		mysqli_begin_transaction($conn);
		try {
			$document = rp_load_document($conn, $rpNo, true);
			if ($document === null) {
				throw new RpValidationException('ไม่พบเอกสารเลขที่ ' . $rpNo);
			}
			if (rp_is_cancelled($document)) {
				throw new RpValidationException('เอกสารเลขที่ ' . $rpNo . ' ถูกยกเลิกแล้ว จึงแก้ไขไม่ได้');
			}

			if (rp_is_draft($document)) {
				if ($mode === 'update') {
					throw new RpValidationException('เอกสารเลขที่ ' . $rpNo . ' ยังเป็น Draft อยู่ กรุณาโหลดหน้าใหม่');
				}
				$statusDoc = ($mode === 'submit') ? RP_STATUS_SUBMITTED : RP_STATUS_DRAFT;
				rp_assert_products_of_company($conn, $items, $header['type_company']);
				po_stmt_exec(
					$conn,
					"UPDATE hos__proreceive
					 SET status_doc = ?, type_company = ?, iv_date = ?, iv_noref = ?, customer = ?, address = ?,
						 bill_name = ?, bill_address = ?, sale_code = ?, delivery_date = ?, show_name = ?
					 WHERE rp_no = ?",
					'sissssssssis',
					array(
						$statusDoc, (int)$header['type_company'], $header['iv_date'], $header['iv_noref'],
						$header['customer'], $header['address'], $header['bill_name'], $header['bill_address'],
						$header['sale_code'], $header['delivery_date'], (int)$header['show_name'], $rpNo,
					)
				);
				po_stmt_exec($conn, "DELETE FROM hos__subproreceive WHERE ref_rpno = ?", 's', array($rpNo));
				rp_insert_items($conn, $rpNo, $items);
			} else {
				if ($mode !== 'update') {
					throw new RpValidationException('เอกสารเลขที่ ' . $rpNo . ' Submit ไปแล้ว กรุณาโหลดหน้าใหม่');
				}
				$statusDoc = RP_STATUS_SUBMITTED;
				// หัวเอกสาร (บริษัท/เลขที่/วันที่/เขตการขาย) ล็อกหลัง Submit — เท่ากับที่หน้าแก้ไขเดิมให้แก้
				po_stmt_exec(
					$conn,
					"UPDATE hos__proreceive SET customer = ?, address = ?, bill_name = ?, bill_address = ?, show_name = ? WHERE rp_no = ?",
					'ssssis',
					array($header['customer'], $header['address'], $header['bill_name'], $header['bill_address'], (int)$header['show_name'], $rpNo)
				);
				rp_update_submitted_items($conn, $rpNo, $items);
			}
			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			throw $e;
		}
		return array('rp_no' => $rpNo, 'created' => false, 'status_doc' => $statusDoc);
	}
}

if (!function_exists('rp_update_submitted_items')) {
	/** เอกสารจริง: อัปเดตค่า/ลำดับของแถวเดิม ลบแถวที่ผู้ใช้เอาออก — ไม่รับแถวใหม่และไม่เปลี่ยนสินค้าของแถว */
	function rp_update_submitted_items($conn, $rpNo, array $items)
	{
		$existingIds = array();
		foreach (rp_load_items($conn, $rpNo) as $row) {
			$existingIds[(int)$row['id']] = true;
		}
		if (count($existingIds) > 0 && count($items) === 0) {
			throw new RpValidationException('เอกสารที่ Submit แล้วต้องเหลือรายการสินค้าอย่างน้อย 1 รายการ');
		}

		$keptIds = array();
		foreach ($items as $index => $item) {
			if ($item['id'] <= 0 || !isset($existingIds[$item['id']]) || isset($keptIds[$item['id']])) {
				throw new RpValidationException('เอกสารที่ Submit แล้วเพิ่มรายการสินค้าไม่ได้ กรุณาโหลดหน้าใหม่');
			}
			$keptIds[$item['id']] = true;
			po_stmt_exec(
				$conn,
				"UPDATE hos__subproreceive SET sort_no = ?, `count` = ?, amount = ?, sale_remark = ?, proname = ?, ckk_name = ?
				 WHERE id = ? AND ref_rpno = ?",
				'iddssiis',
				array($index + 1, $item['qty'], $item['amount'], $item['remark'], $item['proname'], $item['ckk_name'], $item['id'], $rpNo)
			);
		}

		foreach (array_keys($existingIds) as $id) {
			if (!isset($keptIds[$id])) {
				po_stmt_exec($conn, "DELETE FROM hos__subproreceive WHERE id = ? AND ref_rpno = ?", 'is', array($id, $rpNo));
			}
		}
	}
}

if (!function_exists('rp_load_actionable')) {
	/** โหลดเอกสารจริง (ล็อกแถว) สำหรับปุ่มส่งรับจ่าย/ยกเลิก — ใช้ได้เฉพาะเอกสารที่ Submit แล้วและยังไม่ยกเลิก */
	function rp_load_actionable($conn, $rpNo, $actionLabel)
	{
		$document = rp_load_document($conn, $rpNo, true);
		if ($document === null) {
			throw new RpValidationException('ไม่พบเอกสารเลขที่ ' . $rpNo);
		}
		if (rp_is_draft($document)) {
			throw new RpValidationException('เอกสารเลขที่ ' . $rpNo . ' ยังเป็น Draft อยู่ จึง' . $actionLabel . 'ไม่ได้');
		}
		if (rp_is_cancelled($document)) {
			throw new RpValidationException('เอกสารเลขที่ ' . $rpNo . ' ถูกยกเลิกแล้ว จึง' . $actionLabel . 'ไม่ได้');
		}
		return $document;
	}
}

if (!function_exists('rp_send_receive')) {
	/**
	 * ส่งข้อมูลไปรับจ่าย: เพิ่มแถวใน tb_register_data (ฐาน invoice_receipt ผ่าน $accConn) แล้วตั้ง send_receive = 2
	 * ใช้ค่าที่บันทึกแล้วในฐานข้อมูล — ตรรกะเดียวกับ register_receivepro_soedit1.php เดิม
	 * สองฐานอยู่คนละ connection จึง INSERT ฝั่งรับจ่ายก่อน COMMIT ฝั่งเอกสาร: ถ้า INSERT ล้ม เอกสารยังไม่ถูกมาร์กว่าส่งแล้ว
	 */
	function rp_send_receive($conn, $accConn, $rpNo, array $session)
	{
		po_relax_sql_mode($accConn); // tb_register_data เป็น NOT NULL ไม่มี DEFAULT เกือบทุกคอลัมน์
		mysqli_begin_transaction($conn);
		try {
			$document = rp_load_actionable($conn, $rpNo, 'ส่งข้อมูลไปรับจ่าย');
			if (rp_is_sent_receive($document)) {
				throw new RpValidationException('เอกสารเลขที่ ' . $rpNo . ' ส่งข้อมูลไปรับจ่ายแล้ว');
			}
			po_stmt_exec($conn, "UPDATE hos__proreceive SET send_receive = 2 WHERE rp_no = ?", 's', array($rpNo));
			po_stmt_exec(
				$accConn,
				"INSERT INTO tb_register_data (IV_number, date_inv, company, customer_name, ref_id, description, employee_name, add_date, type_1)
				 VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'RP')",
				'ssssssss',
				array(
					$rpNo, (string)$document['delivery_date'], rp_company_full_name($document['type_company']), (string)$document['customer'],
					(string)$document['ref_iddoc'], (string)$document['iv_noref'], rp_actor_name($session), date('Y-m-d H:i:s'),
				)
			);
			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			throw $e;
		}
	}
}

if (!function_exists('rp_cancel_document')) {
	/** ยกเลิกถาวร: cancel_ckk 1 + remark_cancel + log — ไม่แตะแถวที่เคยส่งไปฝั่งรับจ่าย */
	function rp_cancel_document($conn, $rpNo, $reason, array $session)
	{
		$reason = trim((string)$reason);
		if ($reason === '') {
			throw new RpValidationException('กรุณาระบุเหตุผล');
		}
		$reason = mb_substr($reason, 0, 1000, 'UTF-8');

		mysqli_begin_transaction($conn);
		try {
			rp_load_actionable($conn, $rpNo, 'ยกเลิก');
			po_stmt_exec($conn, "UPDATE hos__proreceive SET cancel_ckk = 1, remark_cancel = ? WHERE rp_no = ?", 'ss', array($reason, $rpNo));
			po_insert_status_log($conn, $rpNo, 'Cancelled', $reason, $session);
			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			throw $e;
		}
	}
}

if (!function_exists('rp_search_products')) {
	/**
	 * ค้นสินค้าสำหรับช่องค้นหาเดียวของหน้าใบส่งสินค้า — รหัส / ชื่อไทย / ชื่ออังกฤษ
	 * เงื่อนไขชุดเดียวกับ data_pro_notdemo*.php ที่หน้าเดิมใช้ (ไม่ตัดกลุ่มสินค้า)
	 */
	function rp_search_products($conn, $keyword, $typeCompany)
	{
		$keyword = trim((string)$keyword);
		if ($keyword === '') {
			return array();
		}
		$stmt = mysqli_prepare($conn, "SELECT product_ID, access_code, sol_name, access_name
			FROM tb_product
			WHERE sale_ckk = '1' AND demo_ckk = '0' AND close_pro = '0' AND type_company = ?
				AND (LOCATE(?, access_code) > 0 OR LOCATE(?, sol_name) > 0 OR LOCATE(?, access_name) > 0)
			ORDER BY (LOCATE(?, access_code) = 1) DESC, access_code ASC
			LIMIT " . (RP_PRODUCT_SEARCH_LIMIT + 1));
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		$company = rp_type_company($typeCompany);
		mysqli_stmt_bind_param($stmt, 'sssss', $company, $keyword, $keyword, $keyword, $keyword);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$rows = array();
		while ($result && ($row = mysqli_fetch_assoc($result))) {
			$rows[] = array(
				'product_id'  => (string)$row['product_ID'],
				'access_code' => (string)$row['access_code'],
				'sol_name'    => (string)$row['sol_name'],
				'access_name' => (string)$row['access_name'],
			);
		}
		mysqli_stmt_close($stmt);
		return $rows;
	}
}
