<?php

/**
 * ชั้นบันทึกข้อมูลของใบ PO (hos__po / hos__subpo)
 *
 * ใช้ร่วมกันโดย
 *   - register_posave1.php  (po_action = draft / submit / create_so จาก register_poawl.php
 *                            และเส้นทาง legacy ของ register_ponbm.php ที่ยังส่งฟิลด์ตายตัวมา)
 *   - register_poawl.php    (โหลดร่างกลับมาแก้ + เลขที่คาดการณ์บนหัวฟอร์ม)
 *   - register_suphos.php / register_suphos1.php (ออกใบสั่งขายจาก PO)
 *
 * prepared statement + transaction ทั้งหมด ต่างจากตัวบันทึกเดิมที่ต่อ string ตรง ๆ
 * สถานะเอกสารอยู่ที่ hos__po.status_doc (sql/po_status_doc.sql)
 */

if (!defined('PO_STATUS_DRAFT')) {
	define('PO_STATUS_DRAFT', 'Draft');
	define('PO_STATUS_SUBMITTED', 'Submitted');
	define('PO_MAX_ITEMS', 30);
	define('PO_MAX_ATTACHMENTS', 5);
	define('PO_MAX_ATTACHMENT_BYTES', 1048576); // 1 MB
}

if (!class_exists('PoValidationException')) {
	/**
	 * ข้อผิดพลาดที่ "แสดงให้ผู้ใช้เห็นได้" — ผิดกติกาการกรอก/ไฟล์ หรือเอกสารเปลี่ยนสถานะไปแล้ว
	 * RuntimeException อื่นในไฟล์นี้พก error ของ MySQL มา ห้ามส่งกลับหน้าเว็บตรง ๆ
	 */
	class PoValidationException extends RuntimeException
	{
	}
}

if (!function_exists('po_relax_sql_mode')) {
	/**
	 * hos__po / hos__subpo เป็น NOT NULL ไม่มี DEFAULT แทบทุกคอลัมน์ — Draft ที่ยังกรอกไม่ครบ
	 * (เช่นวันที่ว่าง) ต้องพึ่ง implicit default แบบ non-strict เหมือนตัวบันทึกเดิม
	 */
	function po_relax_sql_mode($conn)
	{
		@mysqli_query($conn, "SET SESSION sql_mode = REPLACE(REPLACE(@@SESSION.sql_mode, 'STRICT_TRANS_TABLES', ''), 'STRICT_ALL_TABLES', '')");
	}
}

if (!function_exists('po_column_exists')) {
	function po_column_exists($conn, $table, $column)
	{
		static $cache = array();
		$key = spl_object_id($conn) . '|' . $table . '.' . $column;
		if (array_key_exists($key, $cache)) {
			return $cache[$key];
		}
		try {
			$query = @mysqli_query($conn, "SHOW COLUMNS FROM `" . str_replace('`', '', $table) . "` LIKE '" . mysqli_real_escape_string($conn, $column) . "'");
			$cache[$key] = ($query && mysqli_num_rows($query) > 0);
		} catch (Throwable $e) {
			$cache[$key] = false;
		}
		return $cache[$key];
	}
}

if (!function_exists('po_has_status_column')) {
	/**
	 * โค้ดฝั่ง SO/Sale ที่อ่าน hos__po ต้องรันได้แม้ฐานนั้นยังไม่ได้รัน migration
	 * จึงเช็คก่อนทุกครั้งที่จะใส่เงื่อนไข status_doc ลงใน query เดิม
	 */
	function po_has_status_column($conn)
	{
		return po_column_exists($conn, 'hos__po', 'status_doc');
	}
}

if (!function_exists('po_not_draft_sql')) {
	/**
	 * เงื่อนไข SQL "ไม่ใช่ Draft" สำหรับต่อท้าย WHERE ของ query เดิม
	 * คืนค่าว่างเมื่อฐานยังไม่มีคอลัมน์ (ทุกแถวคือใบจริงอยู่แล้ว)
	 */
	function po_not_draft_sql($conn, $alias = '')
	{
		if (!po_has_status_column($conn)) {
			return '';
		}
		$prefix = $alias !== '' ? $alias . '.' : '';
		return " AND " . $prefix . "status_doc <> '" . PO_STATUS_DRAFT . "'";
	}
}

if (!function_exists('po_company_options')) {
	/** mapping เดิมของ hos__po.type_doc: 3 = AWL, 4 = NBM */
	function po_company_options()
	{
		return array('3' => 'AWL', '4' => 'NBM');
	}
}

if (!function_exists('po_type_company')) {
	/** type_doc → tb_product.type_company */
	function po_type_company($typeDoc)
	{
		return ((string)$typeDoc === '4') ? 'NBM' : 'AWL';
	}
}

if (!function_exists('po_year_month')) {
	function po_year_month()
	{
		// รูปแบบเดิม: 2 หลักท้ายของปี พ.ศ. + เดือน 2 หลัก → PO + yymm + ####
		return substr((string)(date('Y') + 543), -2) . date('m');
	}
}

if (!function_exists('po_next_running_number')) {
	function po_next_running_number($conn, $yearMonth)
	{
		$stmt = mysqli_prepare($conn, "SELECT MAX(ref_id) AS max_id FROM hos__po WHERE ref_id LIKE ?");
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		$like = 'PO' . $yearMonth . '%';
		mysqli_stmt_bind_param($stmt, 's', $like);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);

		$maxRefId = ($row && isset($row['max_id'])) ? (string)$row['max_id'] : '';
		$running = ($maxRefId === '') ? 0 : (int)substr($maxRefId, -4);
		return $running + 1;
	}
}

if (!function_exists('po_format_ref_id')) {
	function po_format_ref_id($yearMonth, $running)
	{
		return 'PO' . $yearMonth . substr('0000' . (int)$running, -4);
	}
}

if (!function_exists('po_peek_next_ref_id')) {
	/** เลขถัดไป "โดยประมาณ" สำหรับหัวฟอร์ม — จองจริงตอน Save Draft / Submit ครั้งแรกเท่านั้น */
	function po_peek_next_ref_id($conn)
	{
		$yearMonth = po_year_month();
		return po_format_ref_id($yearMonth, po_next_running_number($conn, $yearMonth));
	}
}

if (!function_exists('po_acquire_named_lock')) {
	/** advisory lock ผูกกับ connection — ล้มเหลวไม่ถือว่า fatal เพราะยังมี unique key/ตรวจซ้ำเป็นด่านถัดไป */
	function po_acquire_named_lock($conn, $lockName, $timeoutSeconds)
	{
		try {
			$query = @mysqli_query($conn, "SELECT GET_LOCK('" . mysqli_real_escape_string($conn, $lockName) . "', " . (int)$timeoutSeconds . ") AS ok");
			$row = $query ? mysqli_fetch_assoc($query) : null;
			return $row && (string)$row['ok'] === '1';
		} catch (Throwable $e) {
			return false;
		}
	}
}

if (!function_exists('po_release_named_lock')) {
	function po_release_named_lock($conn, $lockName)
	{
		try {
			@mysqli_query($conn, "SELECT RELEASE_LOCK('" . mysqli_real_escape_string($conn, $lockName) . "')");
		} catch (Throwable $e) {
			// ล็อกหลุดเองเมื่อ connection ปิด
		}
	}
}

if (!function_exists('po_stmt_exec')) {
	/** execute + ปิด statement แล้ว throw พร้อม error ของ MySQL เมื่อไม่สำเร็จ */
	function po_stmt_exec($conn, $sql, $types, array $params)
	{
		$stmt = mysqli_prepare($conn, $sql);
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		if ($types !== '') {
			mysqli_stmt_bind_param($stmt, $types, ...$params);
		}
		$ok = mysqli_stmt_execute($stmt);
		$error = mysqli_stmt_error($stmt);
		$errno = mysqli_stmt_errno($stmt);
		$affected = mysqli_stmt_affected_rows($stmt);
		mysqli_stmt_close($stmt);
		if (!$ok) {
			throw new RuntimeException($error, $errno);
		}
		return $affected;
	}
}

if (!function_exists('po_load_document')) {
	function po_load_document($conn, $refId, $forUpdate = false)
	{
		$stmt = mysqli_prepare($conn, "SELECT * FROM hos__po WHERE ref_id = ? LIMIT 1" . ($forUpdate ? " FOR UPDATE" : ""));
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
		return $row ?: null;
	}
}

if (!function_exists('po_document_status')) {
	/** แถวเดิมก่อน migration ไม่มีคอลัมน์ = ใบจริงทั้งหมด */
	function po_document_status(array $row)
	{
		$status = isset($row['status_doc']) ? trim((string)$row['status_doc']) : '';
		return $status === '' ? PO_STATUS_SUBMITTED : $status;
	}
}

if (!function_exists('po_is_draft')) {
	function po_is_draft(array $row)
	{
		return po_document_status($row) === PO_STATUS_DRAFT;
	}
}

if (!function_exists('po_status_info')) {
	/**
	 * สถานะที่แสดงบนหน้า status — คำนวณจาก status_doc + flag เดิม ลำดับเดียวกับ status_adminpo.php เดิม
	 * @return array{key:string,label:string,color:string}
	 */
	function po_status_info(array $row)
	{
		if (po_is_draft($row)) {
			return array('key' => 'draft', 'label' => 'Draft', 'color' => '#FFA500');
		}
		if ((string)($row['cancel_ckk'] ?? '0') === '1') {
			return array('key' => 'cancelled', 'label' => 'ยกเลิก', 'color' => '#FF0000');
		}
		if ((string)($row['open_so'] ?? '0') === '1') {
			return array('key' => 'opened', 'label' => 'เปิดใบสั่งขายแล้ว', 'color' => '#00FF00');
		}
		if ((string)($row['send_sale'] ?? '0') === '1') {
			return array('key' => 'waiting_so', 'label' => 'รอ Sale เปิดใบสั่งขาย', 'color' => '#FFFF00');
		}
		return array('key' => 'waiting_send', 'label' => 'รอส่งข้อมูลให้ Sale', 'color' => '#FF0000');
	}
}

if (!function_exists('po_edit_block_reason')) {
	/** ใบจริงที่แก้ต่อไม่ได้ (ยกเลิก / ออกใบสั่งขายแล้ว) → ข้อความเหตุผล ; แก้ได้ → '' */
	function po_edit_block_reason(array $row)
	{
		$refId = (string)$row['ref_id'];
		if ((string)($row['cancel_ckk'] ?? '0') === '1') {
			return 'ใบ PO เลขที่ ' . $refId . ' ถูกยกเลิกแล้ว';
		}
		$so = trim((string)($row['ref_so'] ?? ''));
		if ((string)($row['open_so'] ?? '0') === '1' || $so !== '') {
			return 'ใบ PO เลขที่ ' . $refId . ' ออกใบสั่งขายไปแล้ว' . ($so !== '' ? ' (' . $so . ')' : '');
		}
		return '';
	}
}

if (!function_exists('po_load_items')) {
	/** รายการสินค้าตามลำดับที่บันทึก (id) พร้อมข้อมูลจาก tb_product */
	function po_load_items($conn, $refId)
	{
		$stmt = mysqli_prepare($conn, "SELECT sub.*, p.access_code, p.sol_name, p.unit_name, p.remark_hc, p.type_company
			FROM hos__subpo sub
			LEFT JOIN tb_product p ON p.product_ID = sub.product_id
			WHERE sub.ref_idd = ?
			ORDER BY sub.id ASC");
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		mysqli_stmt_bind_param($stmt, 's', $refId);
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

if (!function_exists('po_items_for_form')) {
	/**
	 * แปลงรายการที่บันทึกไว้เป็นรูปแบบเดียวกับ savedProductsForForm ของ register_suphos.php
	 * (productTableFillRows() ใน product_salehos.php อ่านคีย์ชุดนี้)
	 * hos__subpo.pm เก็บ "PM(ปี)" ของฟอร์ม PO ใหม่ → คีย์ pm_year ของตารางสินค้า
	 */
	function po_items_for_form(array $items)
	{
		$rows = array();
		foreach ($items as $item) {
			$rows[] = array(
				'product_id'    => (string)$item['product_id'],
				'product_code'  => (string)($item['access_code'] ?? ''),
				'product_name'  => (string)($item['sol_name'] ?? ''),
				'product_sn'    => '',
				'unit_name'     => (string)($item['unit_name'] ?? ''),
				'sale_count'    => po_trim_number($item['count']),
				'product_price' => (string)$item['price'],
				'discount_unit' => (string)$item['discount'],
				'sum_amount'    => (string)$item['amount'],
				'warranty'      => (string)$item['warranty'],
				'cal'           => (string)$item['cal'],
				'pm_year'       => (string)$item['pm'],
				'pm'            => '',
				'sale_remarkk'  => (string)$item['sale_remark'],
				'clear_br'      => '',
				'clear_ivno'    => '',
				'jong_ckk'      => '',
				'jong_no'       => '',
				'display_name'  => '',
				'subso_db_id'   => '',
				'remark_hc'     => (string)($item['remark_hc'] ?? ''),
			);
		}
		return $rows;
	}
}

if (!function_exists('po_trim_number')) {
	/** 2.00 → "2", 1.50 → "1.5" สำหรับช่องจำนวน */
	function po_trim_number($value)
	{
		$text = (string)$value;
		if (strpos($text, '.') !== false) {
			$text = rtrim(rtrim($text, '0'), '.');
		}
		return $text;
	}
}

if (!function_exists('po_post_value')) {
	function po_post_value(array $post, $key, $default = '')
	{
		if (!isset($post[$key]) || is_array($post[$key])) {
			return $default;
		}
		return trim((string)$post[$key]);
	}
}

if (!function_exists('po_parse_number')) {
	/** "1,234.50" → 1234.5 ; ว่าง → $emptyValue ; ไม่ใช่ตัวเลข → null */
	function po_parse_number($raw, $emptyValue = 0.0)
	{
		$raw = str_replace(array(',', ' '), '', trim((string)$raw));
		if ($raw === '') {
			return $emptyValue;
		}
		return is_numeric($raw) ? (float)$raw : null;
	}
}

if (!function_exists('po_valid_iso_date')) {
	function po_valid_iso_date($value)
	{
		if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', (string)$value, $m)) {
			return false;
		}
		return checkdate((int)$m[2], (int)$m[3], (int)$m[1]);
	}
}

if (!function_exists('po_header_from_post')) {
	/**
	 * $_POST → ค่าหัวเอกสาร (ยังไม่ validate ความครบ — ขึ้นกับ mode)
	 * type_doc ต้องเป็น 3/4 เสมอ แม้เป็น Draft เพราะใช้กรองสินค้า AWL/NBM
	 */
	function po_header_from_post(array $post, array $session)
	{
		$typeDoc = po_post_value($post, 'type_doc', '3');
		if (!array_key_exists($typeDoc, po_company_options())) {
			throw new PoValidationException('กรุณาเลือกบริษัท AWL หรือ NBM');
		}

		$datePo = po_post_value($post, 'date_po');
		if ($datePo !== '' && !po_valid_iso_date($datePo)) {
			throw new PoValidationException('รูปแบบวันที่ไม่ถูกต้อง');
		}

		$now = new DateTimeImmutable('now', new DateTimeZone('Asia/Bangkok'));
		$name = isset($session['name']) ? (string)$session['name'] : '';
		$surname = isset($session['surname']) ? (string)$session['surname'] : '';

		return array(
			'type_doc'    => (int)$typeDoc,
			'date_po'     => $datePo,
			'po_no'       => mb_substr(po_post_value($post, 'po_no'), 0, 100, 'UTF-8'),
			'sale_code'   => mb_substr(po_post_value($post, 'sale_code'), 0, 50, 'UTF-8'),
			'bill_id'     => mb_substr(po_post_value($post, 'bill_id'), 0, 50, 'UTF-8'),
			'bill_name'   => mb_substr(po_post_value($post, 'bill_name'), 0, 300, 'UTF-8'),
			'remark'      => po_post_value($post, 'remark'),
			'description' => po_post_value($post, 'description'),
			'add_by'      => trim($name . ' ' . $surname),
			'add_date'    => $now->format('Y-m-d H:i:s'),
		);
	}
}

if (!function_exists('po_collect_items_from_post')) {
	/**
	 * อ่านแถวสินค้าแบบ field ตายตัว product_id{n} … ของตารางสินค้า (สูงสุด 30 แถว)
	 * แถวที่ไม่มี product_id ถูกข้าม — ยอดรวมคำนวณใหม่ที่ server เสมอ ไม่เชื่อ sum_amount จากหน้าเว็บ
	 *
	 * @param string $pmField ฟิลด์ที่เก็บลง hos__subpo.pm: 'pm_year' (ฟอร์มใหม่ "PM(ปี)") หรือ 'pm' (ฟอร์ม legacy)
	 */
	function po_collect_items_from_post(array $post, $pmField = 'pm_year')
	{
		$rows = array();
		for ($i = 1; $i <= PO_MAX_ITEMS; $i++) {
			$productId = (int)po_post_value($post, 'product_id' . $i, '0');
			if ($productId <= 0) {
				continue;
			}
			$rows[] = array(
				'line'        => $i,
				'product_id'  => $productId,
				'count_raw'   => po_post_value($post, 'sale_count' . $i),
				'price_raw'   => po_post_value($post, 'product_price' . $i),
				'discount_raw' => po_post_value($post, 'discount_unit' . $i),
				'sale_remark' => po_post_value($post, 'sale_remarkk' . $i),
				'warranty'    => mb_substr(po_post_value($post, 'warranty' . $i), 0, 100, 'UTF-8'),
				'cal'         => mb_substr(po_post_value($post, 'cal' . $i), 0, 100, 'UTF-8'),
				'pm'          => mb_substr(po_post_value($post, $pmField . $i), 0, 100, 'UTF-8'),
			);
		}
		return $rows;
	}
}

if (!function_exists('po_normalize_items')) {
	/**
	 * แปลงตัวเลขของทุกแถว + คำนวณยอด
	 *   strict = true  (Submit)  → ตัวเลขผิด/จำนวน ≤ 0/ส่วนลดเกินราคา = error
	 *   strict = false (Draft)   → ค่าที่อ่านไม่ออกถือเป็น 0 ให้บันทึกร่างต่อได้
	 */
	function po_normalize_items(array $rows, $strict)
	{
		$errors = array();
		foreach ($rows as $index => $row) {
			$count = po_parse_number($row['count_raw'], $strict ? null : 0.0);
			$price = po_parse_number($row['price_raw'], $strict ? null : 0.0);
			$discount = po_parse_number($row['discount_raw'], 0.0);

			if ($strict) {
				$label = 'รายการที่ ' . ($index + 1);
				if ($count === null || $count <= 0) {
					$errors[] = $label . ': จำนวนต้องเป็นตัวเลขมากกว่า 0';
				}
				if ($price === null || $price < 0) {
					$errors[] = $label . ': ราคา/หน่วยต้องเป็นตัวเลขตั้งแต่ 0 ขึ้นไป';
				}
				if ($discount === null || $discount < 0) {
					$errors[] = $label . ': ส่วนลด/หน่วยต้องเป็นตัวเลขตั้งแต่ 0 ขึ้นไป';
				} else if ($price !== null && $discount > $price) {
					$errors[] = $label . ': ส่วนลด/หน่วยต้องไม่มากกว่าราคา/หน่วย';
				}
			}

			$count = ($count === null || $count < 0) ? 0.0 : $count;
			$price = ($price === null || $price < 0) ? 0.0 : $price;
			$discount = ($discount === null || $discount < 0) ? 0.0 : $discount;

			$rows[$index]['count'] = round($count, 2);
			$rows[$index]['price'] = round($price, 2);
			$rows[$index]['discount'] = round($discount, 2);
			$rows[$index]['amount'] = round(($count * $price) - ($discount * $count), 2);
		}

		if (count($errors) > 0) {
			throw new PoValidationException(implode("\n", $errors));
		}
		return $rows;
	}
}

if (!function_exists('po_attach_product_meta')) {
	/**
	 * ตรวจว่าสินค้าทุกแถวมีอยู่จริงและเป็นของบริษัทที่เลือก (กันสินค้า AWL/NBM ปนกันในใบเดียว
	 * แม้มีคนยิง POST ตรง) แล้วเติม access_code / sol_name / unit_name ไว้ใช้ต่อ
	 */
	function po_attach_product_meta($conn, array $rows, $typeDoc)
	{
		if (count($rows) === 0) {
			return $rows;
		}

		$ids = array_values(array_unique(array_map(function ($row) {
			return (int)$row['product_id'];
		}, $rows)));
		$placeholders = implode(',', array_fill(0, count($ids), '?'));
		$stmt = mysqli_prepare($conn, "SELECT product_ID, access_code, sol_name, unit_name, type_company, remark_hc FROM tb_product WHERE product_ID IN (" . $placeholders . ")");
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		mysqli_stmt_bind_param($stmt, str_repeat('i', count($ids)), ...$ids);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$products = array();
		while ($result && ($product = mysqli_fetch_assoc($result))) {
			$products[(int)$product['product_ID']] = $product;
		}
		mysqli_stmt_close($stmt);

		$company = po_type_company($typeDoc);
		$errors = array();
		foreach ($rows as $index => $row) {
			$product = $products[(int)$row['product_id']] ?? null;
			if ($product === null) {
				$errors[] = 'รายการที่ ' . ($index + 1) . ': ไม่พบสินค้าในระบบ';
				continue;
			}
			if (strtoupper(trim((string)$product['type_company'])) !== $company) {
				$errors[] = 'รายการที่ ' . ($index + 1) . ' (' . $product['access_code'] . ') ไม่ใช่สินค้าของบริษัท ' . $company;
				continue;
			}
			$rows[$index]['access_code'] = (string)$product['access_code'];
			$rows[$index]['sol_name'] = (string)$product['sol_name'];
			$rows[$index]['unit_name'] = (string)$product['unit_name'];
			$rows[$index]['remark_hc'] = (string)$product['remark_hc'];
		}

		if (count($errors) > 0) {
			throw new PoValidationException(implode("\n", $errors));
		}
		return $rows;
	}
}

if (!function_exists('po_validate_for_submit')) {
	/**
	 * กติกาตอน Submit / ออกใบสั่งขาย — ต้องตรงกับ poValidateForSubmit() ในหน้าเว็บ
	 * บังคับซ้ำฝั่ง server เพราะการซ่อนปุ่มกันคนยิง POST ตรงไม่ได้
	 * @return string[]
	 */
	function po_validate_for_submit(array $header, array $items)
	{
		$errors = array();
		if ($header['sale_code'] === '') {
			$errors[] = 'กรุณาเลือกแผนก/เขตการขาย';
		}
		if ($header['date_po'] === '') {
			$errors[] = 'กรุณาระบุวันที่';
		}
		if ($header['po_no'] === '') {
			$errors[] = 'กรุณากรอกเลขที่ PO';
		}
		if ($header['bill_id'] === '') {
			$errors[] = 'กรุณาเลือกลูกค้า';
		}
		if ($header['bill_name'] === '') {
			$errors[] = 'กรุณากรอกชื่อออกบิล';
		}
		if (count($items) === 0) {
			$errors[] = 'กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ';
		}
		return $errors;
	}
}

if (!function_exists('po_po_no_taken')) {
	/**
	 * เลขที่ PO ซ้ำกับใบจริงใบอื่นหรือไม่ (Draft ไม่นับ — ยังไม่ใช่เอกสารจริง)
	 * กติกาเดิมของ register_posave1.php นับทุกใบรวมใบที่ยกเลิกแล้ว จึงคงไว้แบบเดิม
	 */
	function po_po_no_taken($conn, $poNo, $excludeRefId)
	{
		$sql = "SELECT ref_id FROM hos__po WHERE po_no = ? AND ref_id <> ?" . po_not_draft_sql($conn) . " LIMIT 1";
		$stmt = mysqli_prepare($conn, $sql);
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		mysqli_stmt_bind_param($stmt, 'ss', $poNo, $excludeRefId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
		return $row ? (string)$row['ref_id'] : '';
	}
}

if (!function_exists('po_insert_header')) {
	function po_insert_header($conn, $refId, array $header)
	{
		// คอลัมน์ => [ชนิด bind, ค่า] — ทุกคอลัมน์เป็น NOT NULL ไม่มี DEFAULT จึงต้องใส่ครบ
		$values = array(
			'ref_id'        => array('s', $refId),
			'status_doc'    => array('s', $header['status_doc']),
			'type_doc'      => array('i', $header['type_doc']),
			'date_po'       => array('s', $header['date_po'] !== '' ? $header['date_po'] : '0000-00-00'),
			'po_no'         => array('s', $header['po_no']),
			'sale_code'     => array('s', $header['sale_code']),
			'bill_id'       => array('s', $header['bill_id']),
			'bill_name'     => array('s', $header['bill_name']),
			'remark'        => array('s', $header['remark']),
			'description'   => array('s', $header['description']),
			'img_po1'       => array('s', ''),
			'img_po2'       => array('s', ''),
			'img_po3'       => array('s', ''),
			'img_po4'       => array('s', ''),
			'img_po5'       => array('s', ''),
			'add_date'      => array('s', $header['add_date']),
			'add_by'        => array('s', $header['add_by']),
			'send_sale'     => array('i', $header['send_sale']),
			'send_saledate' => array('s', $header['send_saledate']),
			'open_so'       => array('i', 0),
			'open_sodate'   => array('s', '0000-00-00 00:00:00'),
			'ref_so'        => array('s', ''),
			'name_open'     => array('s', ''),
			'cancel_ckk'    => array('i', 0),
			'remark_cancel' => array('s', ''),
			'sale'          => array('s', ''),
		);

		po_stmt_exec(
			$conn,
			"INSERT INTO hos__po (" . implode(', ', array_keys($values)) . ") VALUES (" . implode(',', array_fill(0, count($values), '?')) . ")",
			implode('', array_column($values, 0)),
			array_column($values, 1)
		);
	}
}

if (!function_exists('po_update_header')) {
	/** ผู้เรียกต้อง lock แถวและยืนยันว่ายังเป็น Draft มาก่อนแล้ว (อยู่ในทรานแซกชันเดียวกัน) */
	function po_update_header($conn, $refId, array $header)
	{
		$datePo = $header['date_po'] !== '' ? $header['date_po'] : '0000-00-00';
		po_stmt_exec(
			$conn,
			"UPDATE hos__po SET
				status_doc = ?, type_doc = ?, date_po = ?, po_no = ?, sale_code = ?, bill_id = ?, bill_name = ?,
				remark = ?, description = ?, send_sale = ?, send_saledate = ?
			WHERE ref_id = ?",
			'sisssssssiss',
			array(
				$header['status_doc'], $header['type_doc'], $datePo, $header['po_no'], $header['sale_code'],
				$header['bill_id'], $header['bill_name'], $header['remark'], $header['description'],
				$header['send_sale'], $header['send_saledate'], $refId,
			)
		);
	}
}

if (!function_exists('po_update_attachment_columns')) {
	function po_update_attachment_columns($conn, $refId, array $columns)
	{
		if (count($columns) === 0) {
			return;
		}
		$sets = array();
		$params = array();
		foreach ($columns as $column => $value) {
			if (!preg_match('/^img_po[1-5]$/', $column)) {
				throw new RuntimeException('invalid attachment column');
			}
			$sets[] = $column . ' = ?';
			$params[] = (string)$value;
		}
		$params[] = $refId;
		po_stmt_exec($conn, "UPDATE hos__po SET " . implode(', ', $sets) . " WHERE ref_id = ?", str_repeat('s', count($params)), $params);
	}
}

if (!function_exists('po_replace_items')) {
	/** ลบรายการเดิมแล้วเขียนชุดใหม่ตามลำดับ (id ต่อเนื่อง = ลำดับที่ผู้ใช้จัด) — เรียกในทรานแซกชัน */
	function po_replace_items($conn, $refId, array $rows)
	{
		po_stmt_exec($conn, "DELETE FROM hos__subpo WHERE ref_idd = ?", 's', array($refId));

		foreach ($rows as $row) {
			$productId = (int)$row['product_id'];
			// product_code เก็บค่าเดียวกับ product_id ตามตัวบันทึกเดิม (คอลัมน์เป็น int ไม่ใช่รหัสสินค้า)
			po_stmt_exec(
				$conn,
				"INSERT INTO hos__subpo (ref_idd, product_id, product_code, count, price, amount, discount, sale_remark, warranty, cal, pm)
				VALUES (?,?,?,?,?,?,?,?,?,?,?)",
				'siiddddssss',
				array(
					$refId, $productId, $productId, $row['count'], $row['price'], $row['amount'], $row['discount'],
					$row['sale_remark'], $row['warranty'], $row['cal'], $row['pm'],
				)
			);
		}
	}
}

/* ===================================================================
 * ไฟล์แนบ — สูงสุด 5 ไฟล์ (img_po1..5) ไฟล์ละไม่เกิน 1MB เฉพาะ PDF/JPG/PNG
 * ชื่อไฟล์ที่เก็บจริงสร้างใหม่ทั้งหมด ไม่ใช้ชื่อจากเครื่องผู้ใช้ → ไม่ชน/ไม่มี path traversal
 * =================================================================== */

if (!function_exists('po_attachment_allowed_types')) {
	/** นามสกุล → MIME ที่ยอมรับ (ตรวจคู่กัน กันไฟล์ปลอมนามสกุล) */
	function po_attachment_allowed_types()
	{
		return array(
			'pdf'  => array('application/pdf'),
			'jpg'  => array('image/jpeg', 'image/pjpeg'),
			'jpeg' => array('image/jpeg', 'image/pjpeg'),
			'png'  => array('image/png'),
		);
	}
}

if (!function_exists('po_attachment_upload_dir')) {
	function po_attachment_upload_dir()
	{
		return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
	}
}

if (!function_exists('po_is_managed_attachment')) {
	/** ไฟล์ที่ตัวบันทึกนี้สร้างเอง — เฉพาะไฟล์กลุ่มนี้ที่ลบทิ้งได้เมื่อถูกแทนที่ (ไฟล์ legacy อาจใช้ชื่อซ้ำข้ามใบ) */
	function po_is_managed_attachment($fileName)
	{
		return (bool)preg_match('/^po_[A-Za-z0-9]+_[1-5]_[0-9a-f]{16}\.(pdf|jpe?g|png)$/', (string)$fileName);
	}
}

if (!function_exists('po_plan_attachments')) {
	/**
	 * ตรวจไฟล์ที่อัปโหลดมาทั้งหมดก่อนแตะฐานข้อมูล
	 *
	 * @param array    $files       $_FILES
	 * @param array    $post        $_POST (อ่าน img_po_remove{n} = '1' สำหรับลบไฟล์เดิม)
	 * @param callable $isUploaded  ตัวตรวจว่าเป็นไฟล์อัปโหลดจริง (ทดสอบแทนที่ได้)
	 * @return array{uploads:array<int,array{tmp:string,ext:string}>,remove:array<int,bool>}
	 */
	function po_plan_attachments(array $files, array $post, $isUploaded = 'is_uploaded_file')
	{
		$allowed = po_attachment_allowed_types();
		$uploads = array();
		$errors = array();
		$present = 0;

		foreach ($files as $field => $file) {
			if (!is_array($file) || !array_key_exists('error', $file)) {
				continue;
			}
			if (is_array($file['error'])) {
				throw new PoValidationException('รูปแบบไฟล์แนบไม่ถูกต้อง');
			}
			if ((int)$file['error'] === UPLOAD_ERR_NO_FILE) {
				continue;
			}
			$present++;
			if (!preg_match('/^img_po([1-5])$/', (string)$field, $m)) {
				throw new PoValidationException('แนบไฟล์ได้สูงสุด ' . PO_MAX_ATTACHMENTS . ' ไฟล์');
			}
			$slot = (int)$m[1];
			$label = 'ไฟล์ที่ ' . $slot;

			$error = (int)$file['error'];
			if ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE) {
				$errors[] = $label . ': ขนาดไฟล์ต้องไม่เกิน 1 MB';
				continue;
			}
			if ($error !== UPLOAD_ERR_OK) {
				$errors[] = $label . ': อัปโหลดไม่สำเร็จ กรุณาเลือกไฟล์ใหม่';
				continue;
			}

			$tmp = (string)$file['tmp_name'];
			if ($tmp === '' || !call_user_func($isUploaded, $tmp)) {
				$errors[] = $label . ': อัปโหลดไม่สำเร็จ กรุณาเลือกไฟล์ใหม่';
				continue;
			}

			$size = (int)@filesize($tmp);
			if ($size <= 0) {
				$errors[] = $label . ': ไฟล์ว่างเปล่า';
				continue;
			}
			if ($size > PO_MAX_ATTACHMENT_BYTES) {
				$errors[] = $label . ': ขนาดไฟล์ต้องไม่เกิน 1 MB';
				continue;
			}

			$originalName = basename(str_replace('\\', '/', (string)$file['name']));
			$ext = strtolower((string)pathinfo($originalName, PATHINFO_EXTENSION));
			if (!isset($allowed[$ext])) {
				$errors[] = $label . ': รองรับเฉพาะไฟล์ PDF, JPG, PNG';
				continue;
			}

			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$mime = (string)$finfo->file($tmp);
			if (!in_array($mime, $allowed[$ext], true)) {
				$errors[] = $label . ': เนื้อหาไฟล์ไม่ตรงกับนามสกุล .' . $ext;
				continue;
			}

			$uploads[$slot] = array('tmp' => $tmp, 'ext' => ($ext === 'jpeg' ? 'jpg' : $ext));
		}

		if ($present > PO_MAX_ATTACHMENTS) {
			throw new PoValidationException('แนบไฟล์ได้สูงสุด ' . PO_MAX_ATTACHMENTS . ' ไฟล์');
		}
		if (count($errors) > 0) {
			throw new PoValidationException(implode("\n", $errors));
		}

		$remove = array();
		for ($slot = 1; $slot <= PO_MAX_ATTACHMENTS; $slot++) {
			if (po_post_value($post, 'img_po_remove' . $slot) === '1' && !isset($uploads[$slot])) {
				$remove[$slot] = true;
			}
		}

		return array('uploads' => $uploads, 'remove' => $remove);
	}
}

if (!function_exists('po_store_attachments')) {
	/**
	 * ย้ายไฟล์ที่ผ่านการตรวจแล้วเข้า upload/ ด้วยชื่อใหม่ แล้วคืนค่าคอลัมน์ที่ต้องอัปเดต
	 * ผู้เรียกต้องลบ created ทิ้งเองถ้าทรานแซกชันล้มเหลว และลบ obsolete หลัง commit เท่านั้น
	 *
	 * @return array{columns:array<string,string>,created:string[],obsolete:string[]}
	 */
	function po_store_attachments($refId, array $existing, array $plan, $moveFile = 'move_uploaded_file')
	{
		$dir = po_attachment_upload_dir();
		$columns = array();
		$created = array();
		$obsolete = array();

		try {
			foreach ($plan['uploads'] as $slot => $upload) {
				$storedName = 'po_' . preg_replace('/[^A-Za-z0-9]/', '', $refId) . '_' . $slot . '_' . bin2hex(random_bytes(8)) . '.' . $upload['ext'];
				if (!call_user_func($moveFile, $upload['tmp'], $dir . $storedName)) {
					throw new RuntimeException('move attachment failed: slot ' . $slot);
				}
				$created[] = $dir . $storedName;
				$columns['img_po' . $slot] = $storedName;
			}
		} catch (Exception $e) {
			po_delete_files($created);
			throw $e;
		}

		for ($slot = 1; $slot <= PO_MAX_ATTACHMENTS; $slot++) {
			$previous = trim((string)($existing['img_po' . $slot] ?? ''));
			if (isset($plan['remove'][$slot])) {
				$columns['img_po' . $slot] = '';
			}
			if ($previous !== '' && isset($columns['img_po' . $slot]) && po_is_managed_attachment($previous)) {
				$obsolete[] = $dir . $previous;
			}
		}

		return array('columns' => $columns, 'created' => $created, 'obsolete' => $obsolete);
	}
}

if (!function_exists('po_delete_files')) {
	function po_delete_files(array $paths)
	{
		foreach ($paths as $path) {
			if (is_file($path)) {
				@unlink($path);
			}
		}
	}
}

/* ===================================================================
 * เส้นทางบันทึกเดียวของใบ PO
 * =================================================================== */

if (!function_exists('po_persist')) {
	/**
	 * mode
	 *   'draft'     → Save Draft: ไม่บังคับกรอกครบ, status Draft, send_sale 0, จองเลขตั้งแต่ครั้งแรก
	 *   'submit'    → Submit: validate ครบ, status Submitted, send_sale 1
	 *   'create_so' → เหมือน submit (หน้าเว็บ redirect ต่อไปออกใบสั่งขาย)
	 *   'update'    → แก้ใบที่ Submit แล้ว: validate ครบ, คง Submitted และสถานะส่ง Sale เดิม
	 *   'legacy'    → ฟอร์มเดิม register_ponbm.php: ใบจริงทันทีแต่ยังไม่ส่ง Sale (send_sale 0)
	 *                 ตามพฤติกรรมเดิม บังคับแค่เลขที่ PO + ห้ามซ้ำ
	 *
	 * มี ref_id → ล็อกแถวก่อนแก้ แล้วตรวจตาม po_persist_existing (Draft ↔ ใบจริงที่ยังแก้ได้)
	 * ไม่มี ref_id → จองเลขใหม่ (GET_LOCK + unique key) แล้วเขียนรายการ/ไฟล์ในทรานแซกชันถัดไป
	 *   ถ้าขั้นหลังล้มเหลว ลบหัวเอกสารที่เพิ่งจองและไฟล์ที่ย้ายแล้วทิ้ง ไม่ให้เหลือขยะ
	 *
	 * @param array $options  is_uploaded / move_file: แทนที่ฟังก์ชันไฟล์ได้ตอนทดสอบ
	 * @return array{ref_id:string,created:bool,status_doc:string}
	 */
	function po_persist($conn, $mode, array $post, array $files, array $session, array $options = array())
	{
		if (!in_array($mode, array('draft', 'submit', 'create_so', 'update', 'legacy'), true)) {
			throw new PoValidationException('ไม่รู้จักคำสั่งบันทึก');
		}
		if (!po_has_status_column($conn)) {
			throw new RuntimeException('hos__po.status_doc missing — run sql/po_status_doc.sql');
		}
		po_relax_sql_mode($conn);

		$isFinal = ($mode !== 'draft');
		$refId = ($mode === 'legacy') ? '' : po_post_value($post, 'ref_id');
		if ($mode === 'update' && $refId === '') {
			throw new PoValidationException('ไม่พบเลขที่เอกสารที่จะอัปเดต');
		}

		$header = po_header_from_post($post, $session);
		$items = po_collect_items_from_post($post, $mode === 'legacy' ? 'pm' : 'pm_year');
		$items = po_normalize_items($items, $isFinal && $mode !== 'legacy');
		$items = po_attach_product_meta($conn, $items, $header['type_doc']);
		$plan = po_plan_attachments($files, $post, $options['is_uploaded'] ?? 'is_uploaded_file');
		$moveFile = $options['move_file'] ?? 'move_uploaded_file';

		if ($mode === 'legacy') {
			if ($header['po_no'] === '') {
				throw new PoValidationException('กรุณากรอกเลขที่ PO');
			}
		} else if ($isFinal) {
			$errors = po_validate_for_submit($header, $items);
			if (count($errors) > 0) {
				throw new PoValidationException(implode("\n", $errors));
			}
		}

		$header['status_doc'] = $isFinal ? PO_STATUS_SUBMITTED : PO_STATUS_DRAFT;
		$header['send_sale'] = ($isFinal && $mode !== 'legacy') ? 1 : 0;
		$header['send_saledate'] = $header['send_sale'] === 1 ? $header['add_date'] : '0000-00-00 00:00:00';

		// เลขที่ PO ห้ามซ้ำ — ล็อกตามเลขตลอดช่วงตรวจ+บันทึก กันสองคำขอผ่านด่านตรวจพร้อมกัน
		$poNoLock = '';
		if ($isFinal) {
			$poNoLock = 'po_no_' . md5($header['po_no']);
			po_acquire_named_lock($conn, $poNoLock, 10);
		}

		try {
			if ($isFinal) {
				$takenBy = po_po_no_taken($conn, $header['po_no'], $refId);
				if ($takenBy !== '') {
					throw new PoValidationException('PO เลขที่ ' . $header['po_no'] . ' มีการบันทึกข้อมูลไปแล้ว (' . $takenBy . ')');
				}
			}

			if ($refId !== '') {
				return po_persist_existing($conn, $mode, $refId, $header, $items, $plan, $moveFile);
			}
			return po_persist_new($conn, $header, $items, $plan, $moveFile);
		} finally {
			if ($poNoLock !== '') {
				po_release_named_lock($conn, $poNoLock);
			}
		}
	}
}

if (!function_exists('po_persist_existing')) {
	/**
	 * Draft      → ใช้ draft / submit / create_so (ยังไม่มี update)
	 * ใบจริง     → ห้ามถอยกลับเป็น draft และต้องยังแก้ได้ (po_edit_block_reason) ณ ตอนที่ล็อกแถวแล้ว
	 *   update           → คงสถานะส่ง Sale เดิมทั้งหมด
	 *   submit/create_so → ใบที่ส่ง Sale แล้วคงเวลาส่งเดิม ; ใบเก่าที่ยังไม่ส่ง (send_sale 0) ส่งตอนนี้
	 */
	function po_persist_existing($conn, $mode, $refId, array $header, array $items, array $plan, $moveFile)
	{
		$stored = array('created' => array(), 'obsolete' => array());
		mysqli_begin_transaction($conn);
		try {
			$original = po_load_document($conn, $refId, true);
			if ($original === null) {
				throw new PoValidationException('ไม่พบเอกสารเลขที่ ' . $refId);
			}
			if (po_is_draft($original)) {
				if ($mode === 'update') {
					throw new PoValidationException('เอกสารเลขที่ ' . $refId . ' ยังเป็น Draft อยู่ กรุณาโหลดหน้าใหม่');
				}
			} else {
				if ($mode === 'draft') {
					throw new PoValidationException('เอกสารเลขที่ ' . $refId . ' ถูกส่งไปแล้ว ไม่สามารถบันทึกเป็นร่างได้ กรุณาโหลดหน้าใหม่');
				}
				$blockReason = po_edit_block_reason($original);
				if ($blockReason !== '') {
					throw new PoValidationException($blockReason . ' จึงแก้ไขไม่ได้');
				}
				$wasSent = ((string)$original['send_sale'] === '1');
				if ($mode === 'update') {
					$header['send_sale'] = $wasSent ? 1 : 0;
					$header['send_saledate'] = (string)$original['send_saledate'];
				} else if ($wasSent) {
					$header['send_saledate'] = (string)$original['send_saledate'];
				}
			}

			// ผู้สร้าง/เวลาสร้างเป็นของร่างครั้งแรกเสมอ
			$header['add_by'] = (string)$original['add_by'];
			$header['add_date'] = (string)$original['add_date'];

			po_update_header($conn, $refId, $header);
			po_replace_items($conn, $refId, $items);
			$stored = po_store_attachments($refId, $original, $plan, $moveFile);
			po_update_attachment_columns($conn, $refId, $stored['columns']);
			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			po_delete_files($stored['created']);
			throw $e;
		}

		po_delete_files($stored['obsolete']);
		return array('ref_id' => $refId, 'created' => false, 'status_doc' => $header['status_doc']);
	}
}

if (!function_exists('po_persist_new')) {
	function po_persist_new($conn, array $header, array $items, array $plan, $moveFile)
	{
		$refId = po_reserve_ref_id($conn, $header);

		$stored = array('created' => array());
		mysqli_begin_transaction($conn);
		try {
			po_replace_items($conn, $refId, $items);
			$stored = po_store_attachments($refId, array(), $plan, $moveFile);
			po_update_attachment_columns($conn, $refId, $stored['columns']);
			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			po_delete_files($stored['created']);
			// หัวเอกสาร commit ไปแล้วตอนจองเลข — ลบเฉพาะ ref_id ที่เพิ่งจองในคำขอนี้
			try {
				po_stmt_exec($conn, "DELETE FROM hos__subpo WHERE ref_idd = ?", 's', array($refId));
				po_stmt_exec($conn, "DELETE FROM hos__po WHERE ref_id = ?", 's', array($refId));
			} catch (Exception $cleanupError) {
				error_log('[po_repo] cleanup failed for ' . $refId . ': ' . $cleanupError->getMessage());
			}
			throw $e;
		}

		return array('ref_id' => $refId, 'created' => true, 'status_doc' => $header['status_doc']);
	}
}

if (!function_exists('po_reserve_ref_id')) {
	/**
	 * จองเลข PO พร้อม INSERT หัวเอกสาร — pattern เดียวกับ breg_reserve_ref_id()
	 *   1) GET_LOCK ต่อเดือน ให้คำขอพร้อมกันเข้าคิว
	 *   2) unique key uk_po_ref_id เป็นด่านสุดท้าย ชนแล้ววนหาเลขถัดไป
	 * ต้องเรียกตอนที่ยังไม่มีทรานแซกชันค้างอยู่
	 */
	function po_reserve_ref_id($conn, array $header)
	{
		$yearMonth = po_year_month();
		$lockName = 'po_ref_id_' . $yearMonth;
		$lastError = '';
		$gotLock = po_acquire_named_lock($conn, $lockName, 10);

		try {
			for ($attempt = 0; $attempt < 10; $attempt++) {
				mysqli_begin_transaction($conn);
				try {
					$refId = po_format_ref_id($yearMonth, po_next_running_number($conn, $yearMonth) + $attempt);
					po_insert_header($conn, $refId, $header);
					mysqli_commit($conn);
					return $refId;
				} catch (Exception $e) {
					mysqli_rollback($conn);
					$lastError = $e->getMessage();
					$errno = (int)$e->getCode() ?: mysqli_errno($conn);
					// 1062 เลขซ้ำ / 1213 deadlock / 1205 lock wait timeout — ลองใหม่ได้
					if (!in_array($errno, array(1062, 1213, 1205), true)) {
						throw new RuntimeException($lastError);
					}
					if ($errno !== 1062) {
						usleep(50000 * ($attempt + 1));
					}
				}
			}
		} finally {
			if ($gotLock) {
				po_release_named_lock($conn, $lockName);
			}
		}

		throw new RuntimeException('ไม่สามารถออกเลขที่เอกสารได้ (' . $lastError . ')');
	}
}

/* ===================================================================
 * ฝั่งออกใบสั่งขาย (register_suphos.php / register_suphos1.php)
 * =================================================================== */

if (!function_exists('po_load_for_sale_order')) {
	/**
	 * ใบ PO ที่เปิดใบสั่งขายได้: Submitted, ไม่ยกเลิก, ยังไม่เคยเปิด SO
	 * @return array{po:?array,error:string}
	 */
	function po_load_for_sale_order($conn, $refId)
	{
		$po = po_load_document($conn, $refId);
		if ($po === null) {
			return array('po' => null, 'error' => '');
		}
		if (po_is_draft($po)) {
			return array('po' => $po, 'error' => 'ใบ PO เลขที่ ' . $refId . ' ยังเป็น Draft อยู่ ต้อง Submit ก่อนจึงออกใบสั่งขายได้');
		}
		return array('po' => $po, 'error' => po_edit_block_reason($po));
	}
}

if (!function_exists('po_find_ref_by_po_no')) {
	/** ใช้แทน "SELECT ref_id FROM hos__po WHERE po_no = ..." เดิมของฝั่ง SO — ไม่นับ Draft */
	function po_find_ref_by_po_no($conn, $poNo)
	{
		$poNo = trim((string)$poNo);
		if ($poNo === '') {
			return '';
		}
		$stmt = mysqli_prepare($conn, "SELECT ref_id FROM hos__po WHERE po_no = ?" . po_not_draft_sql($conn) . " ORDER BY id ASC LIMIT 1");
		if (!$stmt) {
			return '';
		}
		mysqli_stmt_bind_param($stmt, 's', $poNo);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
		return $row ? (string)$row['ref_id'] : '';
	}
}

if (!function_exists('po_mark_sale_order_opened')) {
	/**
	 * ผูกเลข SO กลับไปที่ใบ PO — อัปเดตเฉพาะใบที่ยังไม่เคยเปิด SO เพื่อไม่เขียนทับ ref_so เดิม
	 * @return bool true = ผูกสำเร็จ
	 */
	function po_mark_sale_order_opened($conn, $poRefId, $soRefId, $actorName, $when)
	{
		$affected = po_stmt_exec(
			$conn,
			"UPDATE hos__po SET open_so = 1, open_sodate = ?, ref_so = ?, name_open = ?
			WHERE ref_id = ? AND open_so = 0 AND ref_so = '' AND cancel_ckk = 0" . po_not_draft_sql($conn),
			'ssss',
			array($when, $soRefId, $actorName, $poRefId)
		);
		return $affected > 0;
	}
}
