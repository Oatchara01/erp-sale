<?php

/**
 * ชั้นบันทึกข้อมูลของใบเบิกเครื่องและอะไหล่ (SPR)
 *
 * ใช้ร่วมกันโดย
 *   - register_engspr1.php โหมด v2 (spr_mode=v2)  → Submit (status_doc = 'Request' + ส่งเข้า routing อนุมัติทันที)
 *   - register_engspr_draft1.php                  → Save Draft / Update
 *
 * เขียนด้วย prepared statement + transaction ทั้งหมด ต่างจากตัวบันทึกเดิม
 * (register_engspr1.php / register_engspr_edit1.php path เดิม) ที่ต่อ string ตรง ๆ,
 * ไม่ตรวจผลของ query รายการย่อยเลย, และจำกัดตายตัวที่ 10 แถวสินค้า — path เดิมยังอยู่
 * ครบด้านล่างของ register_engspr1.php เพื่อเป็น fallback ที่ไม่มีอะไรมาเรียกแล้ว
 *
 * คอลัมน์ sort_order / per_return_no / damage_detail / warehouse_action / warehouse_note
 * (sql/spr_dynamic_rows.sql) เป็น optional ทั้งหมด — ทุกจุดที่แตะผ่าน spr_column_exists()
 * จึงรันได้ทั้งก่อนและหลัง migration
 *
 * ต่างจาก includes/breg_repo.php ตรงที่:
 *   - เอกสารเดียวมี AWL/NBM ในตัว (type_company) ไม่ใช่หน้าแยกกัน
 *   - รายการสินค้ามีกลุ่มเดียว (hos__subspr) ไม่ใช่สองกลุ่มแบบ BREG
 *   - Save Draft ต้อง validate เท่ากับ Submit (ข้อกำหนดเฉพาะงานนี้ — breg_validate_engineer_section
 *     แบบ "Draft ผ่านง่ายกว่า" ไม่ใช่ pattern ที่ใช้ที่นี่)
 *   - Rejected ไม่ใช่สถานะปิด (terminal) — แก้ไข/ส่งใหม่ได้ ต่างจาก BREG ที่ Rejected ปิดแล้ว
 *   - ไม่มีแถบอนุมัติ Sup/DM ในหน้านี้ — การอนุมัติยังอยู่ที่ register_engspr_app.php เดิม
 *     (นอก scope งานนี้) หน้านี้ทำแค่ "Submit เข้าคิว" ตามกติกาเดิมของ
 *     send_sprsup_approve.php / send_spr_approve.php
 */

if (!class_exists('SprValidationException')) {
	/**
	 * ข้อผิดพลาดที่ "แสดงให้ผู้ใช้เห็นได้" — ผิดกติกาการกรอก หรือเอกสารเปลี่ยนสถานะไปแล้ว
	 * ต่างจาก RuntimeException ทั่วไปในไฟล์นี้ซึ่งพก error ของ MySQL มาด้วย
	 * และต้องไม่ถูกส่งกลับไปหน้าเว็บตรง ๆ (ลง error_log แล้วตอบข้อความกลาง ๆ แทน)
	 */
	class SprValidationException extends RuntimeException
	{
	}
}

if (!function_exists('spr_relax_sql_mode')) {
	/**
	 * ตาราง hos__spr / hos__subspr เป็น NOT NULL แทบทุกคอลัมน์และไม่มี DEFAULT
	 * (ดู SHOW COLUMNS) ค่าที่ผู้ใช้ยังไม่กรอก — โดยเฉพาะ Draft — จึงต้องพึ่ง
	 * การ implicit default ของ MySQL แบบ non-strict เหมือนที่ includes/breg_repo.php ทำ
	 */
	function spr_relax_sql_mode($conn)
	{
		@mysqli_query($conn, "SET SESSION sql_mode = REPLACE(REPLACE(@@SESSION.sql_mode, 'STRICT_TRANS_TABLES', ''), 'STRICT_ALL_TABLES', '')");
	}
}

if (!function_exists('spr_column_exists')) {
	function spr_column_exists($conn, $table, $column)
	{
		static $cache = array();
		$key = spl_object_id($conn) . '|' . $table . '.' . $column;
		if (array_key_exists($key, $cache)) {
			return $cache[$key];
		}

		$safeTable = str_replace('`', '', $table);
		$sql = "SHOW COLUMNS FROM `" . $safeTable . "` LIKE '" . mysqli_real_escape_string($conn, $column) . "'";
		try {
			$query = @mysqli_query($conn, $sql);
			$cache[$key] = ($query && mysqli_num_rows($query) > 0);
		} catch (Throwable $e) {
			$cache[$key] = false;
		}
		return $cache[$key];
	}
}

if (!function_exists('spr_table_exists')) {
	function spr_table_exists($conn, $table)
	{
		static $cache = array();
		$key = spl_object_id($conn) . '|' . $table;
		if (array_key_exists($key, $cache)) {
			return $cache[$key];
		}
		$query = @mysqli_query($conn, "SHOW TABLES LIKE '" . mysqli_real_escape_string($conn, $table) . "'");
		$cache[$key] = ($query && mysqli_num_rows($query) > 0);
		return $cache[$key];
	}
}

if (!function_exists('spr_year_month')) {
	function spr_year_month()
	{
		// รูปแบบเดิมของทั้งระบบ: 2 หลักท้ายของปี พ.ศ. + เดือน 2 หลัก
		return substr((string)(date("Y") + 543), -2) . date("m");
	}
}

if (!function_exists('spr_year_buddhist_2digit')) {
	function spr_year_buddhist_2digit()
	{
		return substr((string)(date("Y") + 543), -2);
	}
}

if (!function_exists('spr_next_running_number')) {
	function spr_next_running_number($conn, $yearMonth)
	{
		// เลข ref_id เป็น sequence เดียวรวมทั้ง AWL/NBM (ตรงกับพฤติกรรมเดิม —
		// register_engspr1.php ไม่กรอง type_company ตอนหา MAX(ref_id))
		$prefix = 'SPR' . $yearMonth;
		$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__spr WHERE ref_id LIKE '"
			. mysqli_real_escape_string($conn, $prefix) . "%'";
		$query = mysqli_query($conn, $sql);
		$row = $query ? mysqli_fetch_assoc($query) : null;
		$maxRefId = ($row && isset($row['MAXID'])) ? (string)$row['MAXID'] : '';

		$running = ($maxRefId === '') ? 0 : (int)substr($maxRefId, -4);
		return substr('00000' . ($running + 1), -4);
	}
}

if (!function_exists('spr_next_spr_number')) {
	/**
	 * เลข "spr" (running number ต่อบริษัทต่อปี ที่ใช้ประกอบ spr_no) — เรียกภายใน
	 * ทรานแซกชัน/advisory lock เดียวกับ spr_reserve_ref_id() เท่านั้น
	 */
	function spr_next_spr_number($conn, $typeCompany, $yearBuddhist2)
	{
		$sql = "SELECT MAX(spr) AS spr FROM hos__spr WHERE type_company = ? AND year = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, 'is', $typeCompany, $yearBuddhist2);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
		return ((int)($row['spr'] ?? 0)) + 1;
	}
}

if (!function_exists('spr_peek_next_ref_id')) {
	/**
	 * เลข SPR ถัดไป "โดยประมาณ" สำหรับแสดงบนหัวฟอร์มก่อนบันทึก
	 * เลขจริงจะถูกจองตอนกด Save Draft / Submit ผ่าน spr_reserve_ref_id()
	 */
	function spr_peek_next_ref_id($conn)
	{
		$yearMonth = spr_year_month();
		return 'SPR' . $yearMonth . spr_next_running_number($conn, $yearMonth);
	}
}

if (!function_exists('spr_acquire_named_lock')) {
	function spr_acquire_named_lock($conn, $lockName, $timeoutSeconds)
	{
		try {
			$sql = "SELECT GET_LOCK('" . mysqli_real_escape_string($conn, $lockName) . "', " . (int)$timeoutSeconds . ") AS ok";
			$query = @mysqli_query($conn, $sql);
			$row = $query ? mysqli_fetch_assoc($query) : null;
			return $row && (string)$row['ok'] === '1';
		} catch (Throwable $e) {
			return false;
		}
	}
}

if (!function_exists('spr_release_named_lock')) {
	function spr_release_named_lock($conn, $lockName)
	{
		try {
			@mysqli_query($conn, "SELECT RELEASE_LOCK('" . mysqli_real_escape_string($conn, $lockName) . "')");
		} catch (Throwable $e) {
			// ปล่อยผ่าน — ล็อกจะหลุดเองเมื่อ connection ปิด
		}
	}
}

if (!function_exists('spr_header_insert_columns')) {
	/**
	 * รายชื่อคอลัมน์ + ค่าตั้งต้นของ hos__spr ที่ INSERT ทุกครั้ง (คอลัมน์ optional
	 * จาก migration จะถูกกรองออกอัตโนมัติถ้าฐานยังไม่ได้รัน sql/spr_dynamic_rows.sql)
	 * คืนเป็น [คอลัมน์ => ค่า] เรียงตามลำดับที่จะ bind
	 */
	function spr_header_insert_row($conn, $refId, array $header)
	{
		$row = array(
			'ref_id'        => $refId,
			'spr'           => $header['spr'],
			'spr_no'        => $header['spr_no'],
			'spr_date'      => $header['spr_date'],
			'wo_no'         => $header['wo_no'],
			'equipment'     => $header['equipment'],
			'engineer'      => $header['engineer'],
			'date_exp'      => $header['date_exp'],
			'clear_brn'     => $header['clear_brn'],
			'sn_num'        => $header['sn_num'],
			'sn_ckk'        => $header['sn_ckk'],
			'date_imstall'  => $header['date_imstall'],
			'per_no'        => $header['per_no'],
			'clear_brnp'    => $header['clear_brnp'],
			'brn_no'        => $header['brn_no'],
			'brnp_no'       => $header['brnp_no'],
			'clear_epe'     => $header['clear_epe'],
			'epe_no'        => $header['epe_no'],
			'pro_ckk'       => $header['pro_ckk'],
			'pro_des'       => $header['pro_des'],
			'address'       => $header['address'],
			'customer'      => $header['customer'],
			'type_company'  => $header['type_company'],
			'status_doc'    => $header['status_doc'],
			'engineer_date' => $header['engineer_date'],
			'sale_code'     => $header['sale_code'],
			'add_by'        => $header['add_by'],
			'em_code'       => $header['em_code'],
			'add_date'      => $header['add_date'],
			'date_receive'  => $header['date_receive'],
			'year'          => $header['year'],
			'send_sup'      => $header['send_sup'],
			'send_supname'  => $header['send_supname'],
			'send_supdate'  => $header['send_supdate'],
		);

		foreach (array('per_return_no', 'damage_detail', 'note', 'warehouse_action', 'warehouse_note') as $optionalCol) {
			if (spr_column_exists($conn, 'hos__spr', $optionalCol)) {
				$row[$optionalCol] = $header[$optionalCol] ?? '';
			}
		}

		return $row;
	}
}

if (!function_exists('spr_insert_header')) {
	function spr_insert_header($conn, $refId, array $header)
	{
		$row = spr_header_insert_row($conn, $refId, $header);
		$columns = array_keys($row);
		$placeholders = implode(',', array_fill(0, count($columns), '?'));
		$sql = "INSERT INTO hos__spr (" . implode(',', $columns) . ") VALUES (" . $placeholders . ")";

		$stmt = mysqli_prepare($conn, $sql);
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}

		$ok = mysqli_stmt_execute($stmt, array_values($row));
		$error = mysqli_stmt_error($stmt);
		mysqli_stmt_close($stmt);
		if (!$ok) {
			throw new RuntimeException($error);
		}
	}
}

if (!function_exists('spr_reserve_ref_id')) {
	/**
	 * จองเลข SPR พร้อม INSERT หัวเอกสาร (ดู breg_reserve_ref_id() สำหรับที่มาของ
	 * แนวทาง 2 ชั้น: GET_LOCK() advisory lock + unique key เป็นด่านสุดท้าย)
	 *
	 * $header ต้องยังไม่มี spr/spr_no — ฟังก์ชันนี้คำนวณให้ภายใน lock/transaction
	 * เดียวกัน (spr เป็น running number แยกต่อ type_company+year จึงต้องคำนวณสด
	 * ทุกครั้งที่ลองใหม่ ไม่ใช่ค่าคงที่แบบ ref_id)
	 *
	 * @return string ref_id ที่จองได้ (throw RuntimeException ถ้าจองไม่สำเร็จ)
	 */
	function spr_reserve_ref_id($conn, array $header)
	{
		$yearMonth = spr_year_month();
		$prefix = 'SPR' . $yearMonth;
		$lockName = 'spr_ref_id_' . $yearMonth;
		$lastError = '';

		$gotLock = spr_acquire_named_lock($conn, $lockName, 10);

		try {
			for ($attempt = 0; $attempt < 10; $attempt++) {
				mysqli_begin_transaction($conn);
				try {
					$running = (int)substr(spr_next_running_number($conn, $yearMonth), -4);
					$refId = $prefix . substr('00000' . ($running + $attempt), -4);

					$sprNumber = spr_next_spr_number($conn, (int)$header['type_company'], $header['year']);
					$sprPrefix = ((int)$header['type_company'] === 2) ? 'SPRNB' : 'SPR';
					$header['spr'] = $sprNumber;
					$header['spr_no'] = $sprPrefix . $sprNumber . '/' . $header['year'];

					spr_insert_header($conn, $refId, $header);
					mysqli_commit($conn);
					return $refId;
				} catch (Exception $e) {
					mysqli_rollback($conn);
					$lastError = $e->getMessage();
					$errno = mysqli_errno($conn);
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
				spr_release_named_lock($conn, $lockName);
			}
		}

		throw new RuntimeException('ไม่สามารถออกเลขที่เอกสารได้ กรุณาลองใหม่อีกครั้ง (' . $lastError . ')');
	}
}

if (!function_exists('spr_update_header')) {
	/**
	 * แก้ไขข้อมูลฟอร์มของเอกสาร (ทุกสถานะที่ไม่ terminal) — ไม่แตะ spr/spr_no/ref_id/
	 * add_by/add_date/engineer_date/em_code (immutable audit fields) และไม่แตะ
	 * ฟิลด์ที่เป็นของ approval/stock workflow (sup_name, cm_name, stock_*, app_ckk ฯลฯ)
	 * ซึ่งถูกจัดการโดยหน้าอื่น (register_engspr_app.php ฯลฯ) นอก scope งานนี้
	 *
	 * @param string|null $nextStatusDoc null = ไม่แตะ status_doc/send_sup* เลย (โหมด "Update")
	 */
	function spr_update_header($conn, $refId, array $header, $nextStatusDoc = null)
	{
		$columns = array(
			'spr_date', 'wo_no', 'equipment', 'engineer', 'date_exp', 'clear_brn', 'sn_num', 'sn_ckk',
			'date_imstall', 'per_no', 'clear_brnp', 'brn_no', 'brnp_no', 'clear_epe', 'epe_no',
			'pro_ckk', 'pro_des', 'address', 'customer', 'type_company', 'date_receive',
		);
		foreach (array('per_return_no', 'damage_detail', 'note', 'warehouse_action', 'warehouse_note') as $optionalCol) {
			if (spr_column_exists($conn, 'hos__spr', $optionalCol)) {
				$columns[] = $optionalCol;
			}
		}

		$values = array();
		foreach ($columns as $col) {
			$values[] = $header[$col] ?? '';
		}

		$setSql = implode(' = ?, ', $columns) . ' = ?';

		if ($nextStatusDoc !== null) {
			$setSql .= ', status_doc = ?, send_sup = ?, send_supname = ?, send_supdate = ?';
			$values[] = $nextStatusDoc;
			$values[] = $header['send_sup'];
			$values[] = $header['send_supname'];
			$values[] = $header['send_supdate'];
		}

		$values[] = $refId;

		$sql = "UPDATE hos__spr SET " . $setSql . " WHERE ref_id = ?";
		$stmt = mysqli_prepare($conn, $sql);
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}

		$ok = mysqli_stmt_execute($stmt, $values);
		$error = mysqli_stmt_error($stmt);
		mysqli_stmt_close($stmt);
		if (!$ok) {
			throw new RuntimeException($error);
		}
	}
}

if (!function_exists('spr_terminal_statuses')) {
	/**
	 * ต่างจาก BREG: Rejected ไม่ใช่สถานะปิดของ SPR (ข้อกำหนดข้อ 10 ของ handoff) —
	 * แก้ไข/ส่งใหม่ได้จนกว่าจะ Approve หรือถูกยกเลิก
	 */
	function spr_terminal_statuses()
	{
		return array('Approve', 'ยกเลิก');
	}
}

if (!function_exists('spr_is_terminal_status')) {
	function spr_is_terminal_status($statusDoc)
	{
		return in_array($statusDoc, spr_terminal_statuses(), true);
	}
}

if (!function_exists('spr_lock_document')) {
	/**
	 * ล็อกแถวเอกสารไว้ก่อนแก้ไข/เปลี่ยนสถานะ ต้องเรียกภายในทรานแซกชัน
	 * คืน null เมื่อไม่พบเอกสาร
	 */
	function spr_lock_document($conn, $refId)
	{
		$stmt = mysqli_prepare($conn, "SELECT * FROM hos__spr WHERE ref_id = ? LIMIT 1 FOR UPDATE");
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

if (!function_exists('spr_load_document')) {
	function spr_load_document($conn, $refId)
	{
		$stmt = mysqli_prepare($conn, "SELECT * FROM hos__spr WHERE ref_id = ? LIMIT 1");
		if (!$stmt) {
			return null;
		}
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
		return $row ?: null;
	}
}

if (!function_exists('spr_load_items')) {
	/**
	 * รายการสินค้าของเอกสาร พร้อมชื่อ/หน่วยจาก tb_product เรียงตาม sort_order เมื่อมี
	 * คอลัมน์ ไม่งั้นกลับไปเรียงตาม id เหมือนเดิม
	 */
	function spr_load_items($conn, $refId)
	{
		$orderBy = spr_column_exists($conn, 'hos__subspr', 'sort_order')
			? "sub.sort_order ASC, sub.id ASC"
			: "sub.id ASC";
		$warrantySelect = spr_column_exists($conn, 'hos__subspr', 'warranty_year')
			? "sub.warranty_year"
			: "'' AS warranty_year";

		$sql = "SELECT sub.id, sub.product_id, sub.sale_count, sub.unit_price, sub.sum_amount,
					sub.sale_remark, sub.sn, sub.clear_br, sub.clear_ivno, " . $warrantySelect . ",
					p.access_code, p.sol_name, p.unit_name
				FROM hos__subspr sub
				LEFT JOIN tb_product p ON p.product_ID = sub.product_id
				WHERE sub.ref_idd = ?
				ORDER BY " . $orderBy;

		$stmt = mysqli_prepare($conn, $sql);
		if (!$stmt) {
			return array();
		}
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$rows = array();
		if ($result) {
			while ($row = mysqli_fetch_assoc($result)) {
				$rows[] = $row;
			}
		}
		mysqli_stmt_close($stmt);
		return $rows;
	}
}

if (!function_exists('spr_collect_items_from_post')) {
	/**
	 * อ่านรายการแบบ dynamic array จาก items[n][field] (n = ตัวนับฝั่ง client ไม่ต้อง
	 * เรียงต่อเนื่อง) — ลำดับที่ foreach เจอ = ลำดับฟิลด์ใน request body = ลำดับ <tr>
	 * ใน DOM ตอน submit (การลากจัดเรียงย้าย <tr> จริง) จึงใช้เป็น sort_order ได้ตรง ๆ
	 * แถวที่ไม่มี product_id หรือ product_id <= 0 จะถูกข้าม
	 */
	function spr_collect_items_from_post()
	{
		$items = isset($_POST['items']) && is_array($_POST['items']) ? $_POST['items'] : array();

		$rows = array();
		foreach ($items as $raw) {
			if (!is_array($raw)) {
				continue;
			}
			$productId = isset($raw['product_id']) ? (int)trim((string)$raw['product_id']) : 0;
			if ($productId <= 0) {
				continue;
			}

			$count = isset($raw['sale_count']) ? str_replace(',', '', trim((string)$raw['sale_count'])) : '0';
			$count = is_numeric($count) ? (float)$count : 0.0;

			$price = isset($raw['unit_price']) ? str_replace(',', '', trim((string)$raw['unit_price'])) : '0';
			$price = is_numeric($price) ? (float)$price : 0.0;

			$rows[] = array(
				'product_id'  => $productId,
				'sale_count'  => $count,
				'unit_price'  => $price,
				// คำนวณยอดรวมใหม่ฝั่ง server เสมอ — ไม่เชื่อ sum_amount ที่ client ส่งมา
				'sum_amount'  => round($count * $price, 2),
				'warranty_year' => isset($raw['warranty_year']) ? trim((string)$raw['warranty_year']) : '',
				'sale_remark' => isset($raw['sale_remark']) ? trim((string)$raw['sale_remark']) : '',
				'sn'          => isset($raw['sn']) ? trim((string)$raw['sn']) : '',
				'clear_br'    => (isset($raw['clear_br']) && (string)$raw['clear_br'] === '1') ? '1' : '0',
				'clear_ivno'  => isset($raw['clear_ivno']) ? trim((string)$raw['clear_ivno']) : '',
			);
		}

		return $rows;
	}
}

if (!function_exists('spr_replace_items')) {
	/**
	 * ลบรายการเดิมของเอกสารแล้วเขียนชุดใหม่ทั้งหมด — ต้องเรียกภายในทรานแซกชันที่
	 * ผู้เรียกเปิดไว้ เพื่อให้ล้มเหลวแล้ว rollback ได้ทั้งก้อน
	 * คืนรายการ product_id ที่เพิ่งเขียน (ให้ spr_apply_app_ckk_flag ใช้ต่อ)
	 */
	function spr_replace_items($conn, $refId, array $rows)
	{
		$hasSortOrder = spr_column_exists($conn, 'hos__subspr', 'sort_order');
		$hasWarrantyYear = spr_column_exists($conn, 'hos__subspr', 'warranty_year');

		$deleteStmt = mysqli_prepare($conn, "DELETE FROM hos__subspr WHERE ref_idd = ?");
		if (!$deleteStmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		mysqli_stmt_bind_param($deleteStmt, 's', $refId);
		$deleteOk = mysqli_stmt_execute($deleteStmt);
		$deleteError = mysqli_stmt_error($deleteStmt);
		mysqli_stmt_close($deleteStmt);
		if (!$deleteOk) {
			throw new RuntimeException($deleteError);
		}

		if (count($rows) === 0) {
			return array();
		}

		$insertColumns = array('ref_idd', 'product_id', 'product_code', 'sale_count', 'unit_price', 'sum_amount', 'sale_remark', 'sn', 'clear_br', 'clear_ivno');
		if ($hasWarrantyYear) {
			$insertColumns[] = 'warranty_year';
		}
		if ($hasSortOrder) {
			$insertColumns[] = 'sort_order';
		}
		$insertSql = "INSERT INTO hos__subspr (" . implode(',', $insertColumns) . ") VALUES (" . implode(',', array_fill(0, count($insertColumns), '?')) . ")";

		$insertStmt = mysqli_prepare($conn, $insertSql);
		if (!$insertStmt) {
			throw new RuntimeException(mysqli_error($conn));
		}

		$productIds = array();
		$sortOrder = 0;
		foreach ($rows as $row) {
			$sortOrder++;
			$productId = (int)$row['product_id'];
			$productIds[] = $productId;

			$params = array($refId, $productId, $productId, $row['sale_count'], $row['unit_price'], $row['sum_amount'], $row['sale_remark'], $row['sn'], $row['clear_br'], $row['clear_ivno']);
			if ($hasWarrantyYear) {
				$params[] = $row['warranty_year'];
			}
			if ($hasSortOrder) {
				$params[] = $sortOrder;
			}

			if (!mysqli_stmt_execute($insertStmt, $params)) {
				$error = mysqli_stmt_error($insertStmt);
				mysqli_stmt_close($insertStmt);
				throw new RuntimeException($error);
			}
		}

		mysqli_stmt_close($insertStmt);
		return $productIds;
	}
}

if (!function_exists('spr_apply_app_ckk_flag')) {
	/**
	 * มิเรอร์พฤติกรรมเดิม (ทุก handler เก่าของ SPR ทำแบบนี้ทีละแถว): ถ้ามีสินค้าตัวใด
	 * ในเอกสารที่ tb_product.app_spr = '1' ให้ตั้ง hos__spr.app_ckk = '1'
	 */
	function spr_apply_app_ckk_flag($conn, $refId, array $productIds)
	{
		if (count($productIds) === 0) {
			return;
		}
		$placeholders = implode(',', array_fill(0, count($productIds), '?'));
		$types = str_repeat('i', count($productIds));

		$stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS c FROM tb_product WHERE product_ID IN (" . $placeholders . ") AND app_spr = '1'");
		if (!$stmt) {
			return;
		}
		mysqli_stmt_bind_param($stmt, $types, ...$productIds);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);

		if ($row && (int)$row['c'] > 0) {
			$update = mysqli_prepare($conn, "UPDATE hos__spr SET app_ckk = '1' WHERE ref_id = ?");
			mysqli_stmt_bind_param($update, 's', $refId);
			mysqli_stmt_execute($update);
			mysqli_stmt_close($update);
		}
	}
}

if (!function_exists('spr_header_from_post')) {
	/**
	 * แปลง $_POST ของฟอร์มใหม่เป็นค่าที่พร้อมเขียนลง hos__spr
	 * คอลัมน์วันที่เป็น NOT NULL ไม่รับ NULL จึงใช้ '0000-00-00' / '0000-00-00 00:00:00'
	 * แทนค่าว่าง ให้ตรงกับที่หน้าเดิม (register_engspr_edit.php) เช็คอยู่แล้ว
	 */
	function spr_header_from_post(array $session)
	{
		$post = function ($key, $default = '') {
			if (!isset($_POST[$key]) || is_array($_POST[$key])) {
				return $default;
			}
			return trim((string)$_POST[$key]);
		};

		$now = new DateTimeImmutable('now', new DateTimeZone('Asia/Bangkok'));

		$typeCompany = $post('type_company', '1');
		if (!in_array($typeCompany, array('1', '2'), true)) {
			throw new SprValidationException('กรุณาเลือกบริษัท AWL หรือ NBM');
		}

		$dateReceive = $post('date_receive');
		$dateReceive = ($dateReceive === '') ? '0000-00-00' : $dateReceive;

		$name = isset($session['name']) ? $session['name'] : '';
		$surname = isset($session['surname']) ? $session['surname'] : '';

		return array(
			'type_company'     => (int)$typeCompany,
			'wo_no'            => $post('wo_no'),
			'spr_date'         => $post('spr_date') !== '' ? $post('spr_date') : $now->format('Y-m-d'),
			'customer'         => $post('customer'),
			'address'          => $post('address'),
			'equipment'        => $post('equipment'),
			'sn_ckk'           => ($post('sn_ckk') === '1') ? '1' : '0',
			'sn_num'           => $post('sn_num'),
			'engineer'         => $post('engineer') !== '' ? $post('engineer') : trim($name . ' ' . $surname),
			'date_exp'         => $post('date_exp') !== '' ? $post('date_exp') : '0000-00-00',
			'per_no'           => $post('per_no'),
			'per_return_no'    => $post('per_return_no'),
			'clear_brn'        => ($post('clear_brn') === '1') ? '1' : '0',
			'brn_no'           => $post('brn_no'),
			'clear_brnp'       => ($post('clear_brnp') === '1') ? '1' : '0',
			'brnp_no'          => $post('brnp_no'),
			'clear_epe'        => ($post('clear_epe') === '1') ? '1' : '0',
			'epe_no'           => $post('epe_no'),
			'pro_ckk'          => $post('pro_ckk'),
			'pro_des'          => $post('pro_des'),
			'damage_detail'    => $post('damage_detail'),
			'note'             => $post('note'),
			'date_imstall'     => $post('date_imstall') !== '' ? $post('date_imstall') : '0000-00-00',
			'date_receive'     => $dateReceive,
			'warehouse_action' => $post('warehouse_action'),
			'warehouse_note'   => $post('warehouse_note'),
			'sale_code'        => $post('sale_code') !== '' ? $post('sale_code') : (isset($session['code']) ? $session['code'] : ''),
			'status_doc'       => 'Draft',
			'engineer_date'    => $now->format('Y-m-d'),
			'add_by'           => trim($name . ' ' . $surname),
			'em_code'          => isset($session['emid']) ? $session['emid'] : '',
			'add_date'         => $now->format('Y-m-d H:i:s'),
			'year'             => spr_year_buddhist_2digit(),
			// ค่าตั้งต้น — spr_persist_from_post() จะ override เป็นค่าจริงเฉพาะตอน submit
			'send_sup'         => '0',
			'send_supname'     => '',
			'send_supdate'     => '0000-00-00 00:00:00',
		);
	}
}

if (!function_exists('spr_validate')) {
	/**
	 * กติกาการกรอก — ใช้ทั้ง Save Draft และ Submit เหมือนกันทุกจุด (ข้อกำหนดข้อ 11
	 * ของ handoff: "Save Draft ต้อง validate เท่ากับ Submit" แม้ pattern หน้าอื่นในระบบ
	 * จะยอม Draft ที่กรอกไม่ครบ) ต้องตรงกับที่ JS เช็คฝั่งหน้าเว็บ — บังคับซ้ำที่ฝั่ง
	 * server เพราะการซ่อนปุ่มอย่างเดียวกันคนยิง POST ตรงไม่ได้
	 *
	 * @return string[] รายการข้อความผิดพลาด (ว่าง = ผ่าน)
	 */
	function spr_validate(array $header, array $items)
	{
		$errors = array();

		if ($header['wo_no'] === '') {
			$errors[] = 'กรุณากรอกเลขที่ใบงานบริการ (W/O No.)';
		}
		if ($header['customer'] === '') {
			$errors[] = 'กรุณากรอกชื่อลูกค้า';
		}
		if ($header['address'] === '') {
			$errors[] = 'กรุณากรอกที่อยู่';
		}
		if ($header['equipment'] === '') {
			$errors[] = 'กรุณากรอก Equipment';
		}
		if ($header['engineer'] === '') {
			$errors[] = 'กรุณากรอกชื่อ Engineer';
		}
		if ($header['sn_num'] === '') {
			$errors[] = 'กรุณากรอก S/N';
		}
		if ($header['date_imstall'] === '0000-00-00') {
			$errors[] = 'กรุณาระบุวันที่ติดตั้ง';
		}
		if ($header['date_exp'] === '0000-00-00') {
			$errors[] = 'กรุณาระบุวันที่หมดประกัน';
		}
		if (in_array($header['pro_ckk'], array('2', '3'), true) && $header['pro_des'] === '' && $header['damage_detail'] === '') {
			$errors[] = 'กรุณากรอกรายละเอียดอะไหล่คืน';
		}
		if (count($items) === 0) {
			$errors[] = 'กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ';
		}
		foreach ($items as $row) {
			if ((float)$row['sale_count'] <= 0) {
				$errors[] = 'จำนวนของทุกรายการต้องมากกว่า 0';
				break;
			}
			if ($row['warranty_year'] === '' || !is_numeric($row['warranty_year']) || (float)$row['warranty_year'] < 0) {
				$errors[] = 'กรุณาระบุจำนวนปีรับประกันของทุกรายการเป็นตัวเลข';
				break;
			}
		}

		return $errors;
	}
}

if (!function_exists('spr_compute_submit_routing')) {
	/**
	 * routing ตอน Submit — เทียบเท่า send_sprsup_approve.php / send_spr_approve.php
	 * เดิม แต่พับมารันในทรานแซกชันเดียวกับการบันทึกฟอร์ม (ข้อกำหนดข้อ 5: ไม่ใช้ flow
	 * สองจังหวะเดิมที่ต้องกดปุ่ม "ส่งใบเบิกให้ Sup อนุมัติ" แยกอีกที)
	 *
	 * เรียก "หลัง" spr_replace_items() เพราะกติกาของ SUP_EN (auto-approve กลุ่มสินค้า
	 * พิเศษ) ต้องรู้รายการสินค้าที่เพิ่งบันทึกก่อน — ผู้เรียกต้องอยู่ในทรานแซกชันเดียวกัน
	 */
	function spr_apply_submit_routing($conn, $refId, array $productIds, array $session)
	{
		$name = trim((string)($session['name'] ?? '') . ' ' . (string)($session['surname'] ?? ''));
		$now = date('Y-m-d H:i:s');
		$code = isset($session['code']) ? $session['code'] : '';

		if ($code !== 'SUP_EN') {
			// ผู้ใช้ทั่วไป — เทียบเท่า send_sprsup_approve.php เดิม (stamp ส่งให้ Sup อนุมัติ)
			$stmt = mysqli_prepare($conn, "UPDATE hos__spr SET send_sup='1', send_supname=?, send_supdate=? WHERE ref_id=?");
			mysqli_stmt_bind_param($stmt, 'sss', $name, $now, $refId);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			return;
		}

		// SUP_EN — เทียบเท่า send_spr_approve.php เดิม
		// เดิมเช็คแค่แถวแรกของ hos__subspr (bug เมื่อมีหลายรายการ) — ที่นี่เช็คว่า
		// "ทุกรายการ" อยู่ในกลุ่มพิเศษหรือไม่ แทนการสุ่มเช็คแถวแรกแถวเดียว
		$specialGroups = array(
			'ALPHABED', 'ที่นอนลม', 'SUCTION', 'เครื่องดูดเสมหะ', 'อะไหล่ Alphabed',
			'Hartmann', 'Flowmeter', 'Smartsign', 'Thermometer', 'เครื่องวัดอุณหภูมิ',
		);

		$allSpecial = count($productIds) > 0;
		if ($allSpecial) {
			$placeholders = implode(',', array_fill(0, count($productIds), '?'));
			$types = str_repeat('i', count($productIds));
			$stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS c FROM tb_product WHERE product_ID IN (" . $placeholders . ") AND group1 NOT IN ('" . implode("','", array_map(function ($g) use ($conn) {
				return mysqli_real_escape_string($conn, $g);
			}, $specialGroups)) . "')");
			mysqli_stmt_bind_param($stmt, $types, ...$productIds);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$row = $result ? mysqli_fetch_assoc($result) : null;
			mysqli_stmt_close($stmt);
			$allSpecial = $row && (int)$row['c'] === 0;
		}

		if ($allSpecial) {
			$stmt = mysqli_prepare($conn, "UPDATE hos__spr SET status_doc='Approve', send_sup='1', send_supname=?, send_supdate=?, sup_name=?, sup_date=?, send_cm='1', cm_name=?, cm_date=?, send_stock='1' WHERE ref_id=?");
			mysqli_stmt_bind_param($stmt, 'sssssss', $name, $now, $name, $now, $name, $now, $refId);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);

			$updateItems = mysqli_prepare($conn, "UPDATE hos__subspr SET status_spr='Approve' WHERE ref_idd = ?");
			mysqli_stmt_bind_param($updateItems, 's', $refId);
			mysqli_stmt_execute($updateItems);
			mysqli_stmt_close($updateItems);
		} else {
			$stmt = mysqli_prepare($conn, "UPDATE hos__spr SET send_sup='1', send_supname=?, send_supdate=?, sup_name=?, sup_date=?, send_cm='1' WHERE ref_id=?");
			mysqli_stmt_bind_param($stmt, 'sssss', $name, $now, $name, $now, $refId);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
}

if (!function_exists('spr_persist_from_post')) {
	/**
	 * เส้นทางบันทึกเดียวของฟอร์มใหม่ ใช้ทั้ง Save Draft และ Submit
	 *
	 *   - ยังไม่มี ref_id       → จองเลข SPR ใหม่ + INSERT หัวเอกสาร แล้วเขียนรายการในทรานแซกชันถัดมา
	 *   - มี ref_id + ไม่ terminal → UPDATE ทับใบเดิม เลขไม่เปลี่ยน (โหมด draft = "Update"
	 *     ถ้าสถานะไม่ใช่ Draft, mode submit = ส่งเข้าคิวอนุมัติใหม่ได้ไม่ว่าสถานะปัจจุบัน
	 *     จะเป็นอะไร ตราบใดที่ไม่ terminal — รวมถึง Rejected ซึ่งไม่ใช่ terminal ของ SPR)
	 *   - มี ref_id + terminal   → ปฏิเสธเสมอ
	 *
	 * @param string $mode 'draft' หรือ 'submit'
	 * @return array{ref_id:string,created:bool}
	 */
	function spr_persist_from_post($conn, $mode, array $session)
	{
		spr_relax_sql_mode($conn);

		$refId = isset($_POST['ref_id']) && !is_array($_POST['ref_id']) ? trim((string)$_POST['ref_id']) : '';

		$header = spr_header_from_post($session);
		$items = spr_collect_items_from_post();

		// Save Draft ต้อง validate เท่ากับ Submit เสมอ (ข้อกำหนดข้อ 11)
		$errors = spr_validate($header, $items);
		if (count($errors) > 0) {
			throw new SprValidationException(implode("\n", $errors));
		}

		if ($mode === 'submit') {
			$header['status_doc'] = 'Request';
		} else {
			$header['status_doc'] = 'Draft';
		}

		if ($refId !== '') {
			mysqli_begin_transaction($conn);
			try {
				$original = spr_lock_document($conn, $refId);
				if ($original === null) {
					throw new SprValidationException('ไม่พบเอกสารเลขที่ ' . $refId);
				}
				if (spr_is_terminal_status($original['status_doc'])) {
					throw new SprValidationException('เอกสารเลขที่ ' . $refId . ' ปิดแล้ว ไม่สามารถแก้ไขได้');
				}

				// mode 'draft' บนเอกสารที่ไม่ใช่ Draft (Request/Rejected ระหว่างทาง) = "Update"
				// ไม่แตะ status_doc/send_sup เลย ต่างจาก mode 'submit' ที่ตั้งใจเปลี่ยนสถานะเสมอ
				$nextStatus = ($mode === 'submit') ? 'Request' : (($original['status_doc'] === 'Draft') ? 'Draft' : null);

				spr_update_header($conn, $refId, $header, $nextStatus);
				$productIds = spr_replace_items($conn, $refId, $items);
				spr_apply_app_ckk_flag($conn, $refId, $productIds);

				if ($mode === 'submit') {
					spr_apply_submit_routing($conn, $refId, $productIds, $session);
				}

				mysqli_commit($conn);
			} catch (Exception $e) {
				mysqli_rollback($conn);
				throw $e;
			}

			spr_log_status($conn, $refId, ($mode === 'submit') ? 'Submitted' : 'Updated', '', $session);
			return array('ref_id' => $refId, 'created' => false);
		}

		$newRefId = spr_reserve_ref_id($conn, $header);

		mysqli_begin_transaction($conn);
		try {
			$productIds = spr_replace_items($conn, $newRefId, $items);
			spr_apply_app_ckk_flag($conn, $newRefId, $productIds);

			if ($mode === 'submit') {
				spr_update_header($conn, $newRefId, $header, 'Request');
				spr_apply_submit_routing($conn, $newRefId, $productIds, $session);
			}

			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			// หัวเอกสาร commit ไปแล้วตอนจองเลข — เก็บกวาดเองเพื่อไม่ให้เหลือใบเปล่า
			// (ลบด้วย ref_id ที่เพิ่งจองเองในคำขอนี้เท่านั้น ปลอดภัยไม่ว่า mode จะเป็นอะไร
			// เพราะ $newRefId มาจาก spr_reserve_ref_id() ที่เพิ่งสร้างขึ้นในคำขอนี้เท่านั้น)
			$cleanup = mysqli_prepare($conn, "DELETE FROM hos__spr WHERE ref_id = ?");
			if ($cleanup) {
				mysqli_stmt_bind_param($cleanup, 's', $newRefId);
				mysqli_stmt_execute($cleanup);
				mysqli_stmt_close($cleanup);
			}
			throw $e;
		}

		spr_log_status($conn, $newRefId, ($mode === 'submit') ? 'Submitted' : 'Created', '', $session);
		return array('ref_id' => $newRefId, 'created' => true);
	}
}

if (!function_exists('spr_stamp_service_order')) {
	/**
	 * มิเรอร์พฤติกรรมเดิมของ register_engspr1.php: ตอนเอกสารเข้าสถานะ Request
	 * (Submit) ให้ตั้ง spar_ckk='1' และบันทึก spr_no กลับไปที่ใบงานบริการต้นทาง
	 * (tb_service_order / tb_service_orderim บนฐาน service ของบริษัทที่เลือก)
	 * เดิม side effect นี้อยู่นอกทรานแซกชันของ $conn อยู่แล้ว (คนละ connection) —
	 * เรียก "หลัง" commit ของ spr_persist_from_post() เป็น best-effort เหมือนเดิม
	 * ไม่มี WO ตรงกันก็แค่ affected 0 แถว ไม่ error
	 */
	function spr_stamp_service_order($service, $servicenb, $typeCompany, $woNo, $sprNo)
	{
		$woNo = trim((string)$woNo);
		if ($woNo === '') {
			return;
		}
		$targetConn = ((int)$typeCompany === 2) ? $servicenb : $service;
		if (!$targetConn) {
			return;
		}

		$table = (strtoupper(substr($woNo, 0, 2)) === 'IM') ? 'tb_service_orderim' : 'tb_service_order';
		$stmt = mysqli_prepare($targetConn, "UPDATE " . $table . " SET spar_ckk = '1', spr_no = ? WHERE service_order_no = ?");
		if (!$stmt) {
			return;
		}
		mysqli_stmt_bind_param($stmt, 'ss', $sprNo, $woNo);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

if (!function_exists('spr_log_status')) {
	/**
	 * บันทึกประวัติ action ของเอกสาร (tb_document_status_log) — ตารางเดียวกับที่
	 * includes/breg_repo.php ใช้ ไม่มีผลต่อ consumer เดิมของตารางนี้เพราะ label ที่ใช้
	 * ที่นี่ทั้งหมดเป็นของใหม่
	 */
	function spr_log_status($conn, $refId, $statusLabel, $reason, array $session)
	{
		if (!spr_table_exists($conn, 'tb_document_status_log')) {
			return;
		}
		$stmt = mysqli_prepare($conn, "INSERT INTO tb_document_status_log (ref_id, status_doc, reason, user_id, user_name) VALUES (?,?,?,?,?)");
		if (!$stmt) {
			return;
		}
		$userId = (string)($session['UserID'] ?? '');
		$userName = trim(($session['name'] ?? '') . ' ' . ($session['surname'] ?? ''));
		mysqli_stmt_bind_param($stmt, 'sssss', $refId, $statusLabel, $reason, $userId, $userName);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

/* ===================================================================
 * Workflow อนุมัติในหน้าฟอร์ม (register_engspr.php)
 *
 * ย้ายการอนุมัติจากหน้าเก่า (register_engspr_app.php / register_cmspr_app.php +
 * approve_sprsup.php / approve_sprcm.php / rejected_spr*.php) มาไว้ในหน้าฟอร์มเดียว
 * พร้อมเพิ่ม "ส่งกลับ" และ "ยกเลิกเอกสาร" ซึ่ง SPR ไม่เคยมีมาก่อน
 *
 * ต่างจากของเดิมตรงที่ตรวจสิทธิ์ฝั่ง server จริง — หน้าเก่าไม่มีการตรวจเลย
 * (approve_sprcm.php UPDATE ตาม ref_id จาก $_GET ตรง ๆ) การซ่อนปุ่มในหน้าฟอร์ม
 * เป็นแค่ UX ไม่ใช่ authorization
 * =================================================================== */

if (!function_exists('spr_stage_of')) {
	/**
	 * ด่านอนุมัติปัจจุบันของเอกสาร คำนวณจากแถวล้วน ๆ ให้ตรงกับเงื่อนไขคิวของหน้าเดิม
	 *   - 'sup' → status_approvespr.php: send_sup='1' AND sup_name='' AND Request
	 *   - 'cm'  → status_appspr_cm.php:  send_cm='1'  AND cm_name=''  AND Request
	 * สองด่านไม่ทับกันเพราะตอน Sup อนุมัติจะเขียน sup_name พร้อมตั้ง send_cm='1'
	 */
	function spr_stage_of(array $doc)
	{
		if ((string)$doc['status_doc'] !== 'Request') {
			return null;
		}
		if ((string)$doc['send_sup'] === '1' && trim((string)$doc['sup_name']) === '') {
			return 'sup';
		}
		if ((string)$doc['send_cm'] === '1' && trim((string)$doc['cm_name']) === '') {
			return 'cm';
		}
		return null;
	}
}

if (!function_exists('spr_stage_roles')) {
	/**
	 * บทบาทที่อนุมัติได้ในแต่ละด่าน — อนุมานจากเมนูที่ลิงก์ไปหน้าคิวเดิม เพราะโค้ดเดิม
	 * ไม่เคยเขียนเงื่อนไขสิทธิ์ไว้ที่ไหนเลย:
	 *   - ด่าน Sup: menu_suphos.php:61       → type_login = 'Sup_Sale'
	 *   - ด่าน CM : menu_suphos.php:65 (Sup_Sale) + menu_it.php:83 (It)
	 */
	function spr_stage_roles($stage)
	{
		$map = array(
			'sup' => array('Sup_Sale'),
			'cm'  => array('Sup_Sale', 'It'),
		);
		return isset($map[$stage]) ? $map[$stage] : array();
	}
}

if (!function_exists('spr_user_can_act_on_stage')) {
	function spr_user_can_act_on_stage($stage, array $session)
	{
		if ($stage === null) {
			return false;
		}
		return in_array((string)($session['type_login'] ?? ''), spr_stage_roles($stage), true);
	}
}

if (!function_exists('spr_user_owns_document')) {
	/**
	 * เจ้าของเอกสาร — เทียบด้วย em_code (รหัสพนักงาน) ซึ่งเป็น immutable audit field
	 * ไม่ใช้ชื่อ (add_by/engineer) เพราะชื่อซ้ำกันได้และแก้ได้จากฟอร์ม
	 * ใบเก่าที่ em_code ว่าง (สร้างจากหน้า legacy) จะถือว่าไม่มีเจ้าของที่ระบุได้
	 */
	function spr_user_owns_document(array $doc, array $session)
	{
		$docOwner = trim((string)($doc['em_code'] ?? ''));
		$sessionOwner = trim((string)($session['emid'] ?? ''));
		return $docOwner !== '' && $sessionOwner !== '' && $docOwner === $sessionOwner;
	}
}

if (!function_exists('spr_user_can_cancel')) {
	/**
	 * ยกเลิกเอกสารได้เมื่อ:
	 *   - เอกสารอยู่ในคิวอนุมัติ → ผู้อนุมัติของด่านนั้น
	 *   - เอกสารไม่อยู่ในคิว (Draft/Returned/Rejected) → เจ้าของใบ หรือผู้อนุมัติด่านใดก็ได้
	 * ผู้เรียกต้องเช็ค terminal มาก่อนแล้ว
	 */
	function spr_user_can_cancel(array $doc, $stage, array $session)
	{
		if ($stage !== null) {
			return spr_user_can_act_on_stage($stage, $session);
		}
		if (spr_user_owns_document($doc, $session)) {
			return true;
		}
		$approverRoles = array_unique(array_merge(spr_stage_roles('sup'), spr_stage_roles('cm')));
		return in_array((string)($session['type_login'] ?? ''), $approverRoles, true);
	}
}

if (!function_exists('spr_actor_name')) {
	function spr_actor_name(array $session)
	{
		return trim((string)($session['name'] ?? '') . ' ' . (string)($session['surname'] ?? ''));
	}
}

if (!function_exists('spr_qualifies_fast_approve')) {
	/**
	 * มิเรอร์เงื่อนไขของ approve_sprsup.php — ใบที่ app_ckk='1' หรือสินค้าอยู่ในกลุ่มพิเศษ
	 * จะ Approve จบที่ด่าน Sup เลย ไม่ต้องส่งต่อด่าน CM
	 *
	 * ของเดิมเช็คแค่ "แถวแรก" ของ hos__subspr (bug เมื่อมีหลายรายการ) ที่นี่เช็คว่าทุก
	 * รายการอยู่ในกลุ่มพิเศษ — กติกาชุดเดียวกับ spr_apply_submit_routing()
	 *
	 * หมายเหตุ: เงื่อนไข app_ckk='1' ดูขัดกับ status_appspr_cm.php:21 ที่ตั้งคิวของผู้บริหาร
	 * ไว้รอใบ app_ckk='1' โดยเฉพาะ (ใบพวกนั้นถูก Approve ไปก่อนแล้วจึงไม่มีทางเข้าคิว)
	 * เป็นพฤติกรรมเดิมที่คงไว้โดยตั้งใจ ไม่ใช่ขอบเขตของงานนี้
	 */
	function spr_qualifies_fast_approve($conn, $refId, array $doc)
	{
		if ((string)($doc['app_ckk'] ?? '') === '1') {
			return true;
		}

		$productIds = array();
		$stmt = mysqli_prepare($conn, "SELECT product_id FROM hos__subspr WHERE ref_idd = ?");
		if (!$stmt) {
			return false;
		}
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if ($result) {
			while ($row = mysqli_fetch_assoc($result)) {
				$productId = (int)$row['product_id'];
				if ($productId > 0) {
					$productIds[] = $productId;
				}
			}
		}
		mysqli_stmt_close($stmt);

		if (count($productIds) === 0) {
			return false;
		}

		$specialGroups = array(
			'ALPHABED', 'ที่นอนลม', 'SUCTION', 'เครื่องดูดเสมหะ', 'อะไหล่ Alphabed',
			'Hartmann', 'Flowmeter', 'Smartsign', 'Thermometer', 'เครื่องวัดอุณหภูมิ',
		);
		$placeholders = implode(',', array_fill(0, count($productIds), '?'));
		$types = str_repeat('i', count($productIds));
		$escapedGroups = implode("','", array_map(function ($g) use ($conn) {
			return mysqli_real_escape_string($conn, $g);
		}, $specialGroups));

		$stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS c FROM tb_product WHERE product_ID IN (" . $placeholders . ") AND group1 NOT IN ('" . $escapedGroups . "')");
		if (!$stmt) {
			return false;
		}
		mysqli_stmt_bind_param($stmt, $types, ...$productIds);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);

		return $row && (int)$row['c'] === 0;
	}
}

if (!function_exists('spr_mark_items_approved')) {
	function spr_mark_items_approved($conn, $refId)
	{
		$stmt = mysqli_prepare($conn, "UPDATE hos__subspr SET status_spr='Approve' WHERE ref_idd = ?");
		if (!$stmt) {
			return;
		}
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

if (!function_exists('spr_exec_status_update')) {
	/** UPDATE ที่ต้องมีผลจริงอย่างน้อย 1 แถว — ไม่โดนแปลว่ามีคนเปลี่ยนสถานะแซงไปแล้ว */
	function spr_exec_status_update($conn, $sql, $types, array $values)
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
			throw new SprValidationException('เอกสารถูกเปลี่ยนสถานะไปแล้ว กรุณาโหลดหน้าใหม่');
		}
	}
}

if (!function_exists('spr_apply_approve')) {
	/**
	 * อนุมัติ — มิเรอร์ approve_sprsup.php / approve_sprcm.php เดิมทุกฟิลด์
	 * @return string status_doc ใหม่
	 */
	function spr_apply_approve($conn, $refId, $stage, $actorName, array $doc)
	{
		if ($stage === 'cm') {
			spr_exec_status_update(
				$conn,
				"UPDATE hos__spr SET status_doc='Approve', cm_name=?, cm_date=NOW(), send_stock='1' WHERE ref_id=? AND status_doc='Request' AND send_cm='1'",
				'ss',
				array($actorName, $refId)
			);
			spr_mark_items_approved($conn, $refId);
			return 'Approve';
		}

		if (spr_qualifies_fast_approve($conn, $refId, $doc)) {
			spr_exec_status_update(
				$conn,
				"UPDATE hos__spr SET status_doc='Approve', sup_name=?, sup_date=NOW(), sup_adddate=NOW(), send_cm='1', cm_name=?, cm_date=NOW(), send_stock='1' WHERE ref_id=? AND status_doc='Request' AND send_sup='1'",
				'sss',
				array($actorName, $actorName, $refId)
			);
			spr_mark_items_approved($conn, $refId);
			return 'Approve';
		}

		spr_exec_status_update(
			$conn,
			"UPDATE hos__spr SET sup_name=?, sup_date=NOW(), sup_adddate=NOW(), send_cm='1' WHERE ref_id=? AND status_doc='Request' AND send_sup='1'",
			'ss',
			array($actorName, $refId)
		);
		return 'Request';
	}
}

if (!function_exists('spr_run_document_action')) {
	/**
	 * ทางเข้าเดียวของ approve / return / reject / cancel
	 *
	 * ตรวจตามลำดับ: มีเอกสาร → ไม่ terminal → อยู่ด่านที่ทำได้ → ผู้ใช้มีสิทธิ์ในด่านนั้น
	 * ทุก UPDATE มี WHERE กันสถานะซ้อนอีกชั้นและเช็ค affected_rows
	 *
	 * @param string $action 'approve' | 'return' | 'reject' | 'cancel'
	 * @return array{ref_id:string,status_doc:string}
	 */
	function spr_run_document_action($conn, $refId, $action, $reason, array $session)
	{
		spr_relax_sql_mode($conn);

		$refId = trim((string)$refId);
		$reason = trim((string)$reason);
		if ($refId === '') {
			throw new SprValidationException('ไม่พบเลขที่เอกสาร');
		}
		if (!in_array($action, array('approve', 'return', 'reject', 'cancel'), true)) {
			throw new SprValidationException('คำสั่งไม่ถูกต้อง');
		}
		if ($action !== 'approve' && $reason === '') {
			throw new SprValidationException('กรุณาระบุเหตุผล');
		}

		$actorName = spr_actor_name($session);
		$logLabel = '';
		$newStatus = '';

		mysqli_begin_transaction($conn);
		try {
			$doc = spr_lock_document($conn, $refId);
			if ($doc === null) {
				throw new SprValidationException('ไม่พบเอกสารเลขที่ ' . $refId);
			}
			if (spr_is_terminal_status($doc['status_doc'])) {
				throw new SprValidationException('เอกสารเลขที่ ' . $refId . ' ปิดแล้ว ไม่สามารถดำเนินการได้');
			}

			$stage = spr_stage_of($doc);

			if ($action === 'cancel') {
				// ยกเลิกได้ทุกใบที่ยังไม่ปิด ไม่ใช่เฉพาะใบที่อยู่ในคิว — ไม่งั้นใบ Draft/Returned/
				// Rejected จะค้างในระบบตลอดไปเพราะไม่มีด่านให้ใครกด
				if (!spr_user_can_cancel($doc, $stage, $session)) {
					throw new SprValidationException('คุณไม่มีสิทธิ์ยกเลิกเอกสารนี้');
				}
				spr_exec_status_update(
					$conn,
					"UPDATE hos__spr SET status_doc='ยกเลิก' WHERE ref_id=? AND status_doc=?",
					'ss',
					array($refId, (string)$doc['status_doc'])
				);
				$newStatus = 'ยกเลิก';
				$logLabel = 'Cancelled';

				mysqli_commit($conn);
				spr_log_status($conn, $refId, $logLabel, $reason, $session);
				return array('ref_id' => $refId, 'status_doc' => $newStatus);
			}

			// approve/return/reject ต้องอยู่ในด่านอนุมัติและผู้ใช้ต้องมีสิทธิ์ในด่านนั้น
			if ($stage === null) {
				throw new SprValidationException('เอกสารไม่ได้อยู่ในสถานะรออนุมัติแล้ว กรุณาโหลดหน้าใหม่');
			}
			if (!spr_user_can_act_on_stage($stage, $session)) {
				throw new SprValidationException('คุณไม่มีสิทธิ์ดำเนินการกับเอกสารนี้');
			}

			if ($action === 'return') {
				// ส่งกลับหาช่างเสมอ ไม่ว่าจะส่งกลับจากด่านไหน — ล้าง flag ทั้งสองด่านเพื่อให้ใบ
				// หลุดจากทุกคิว แล้ว Submit ใหม่วิ่งครบทั้งสองด่านตามปกติ
				spr_exec_status_update(
					$conn,
					"UPDATE hos__spr SET status_doc='Returned', send_sup='0', send_cm='0', sup_name='', cm_name='' WHERE ref_id=? AND status_doc='Request'",
					's',
					array($refId)
				);
				$newStatus = 'Returned';
				$logLabel = ($stage === 'sup') ? 'Sup Returned' : 'CM Returned';
			} elseif ($action === 'reject') {
				// reject_remark เขียนไว้ด้วยเพื่อให้หน้า/รายงานเดิมที่อ่านคอลัมน์นี้ยังทำงานได้
				// (ประวัติฉบับเต็มอยู่ใน tb_document_status_log)
				$nameColumn = ($stage === 'sup') ? 'sup_name' : 'cm_name';
				$dateColumn = ($stage === 'sup') ? 'sup_date' : 'cm_date';
				spr_exec_status_update(
					$conn,
					"UPDATE hos__spr SET status_doc='Rejected', reject_remark=?, " . $nameColumn . "=?, " . $dateColumn . "=NOW() WHERE ref_id=? AND status_doc='Request'",
					'sss',
					array($reason, $actorName, $refId)
				);
				$newStatus = 'Rejected';
				$logLabel = ($stage === 'sup') ? 'Sup Rejected' : 'CM Rejected';
			} else {
				$newStatus = spr_apply_approve($conn, $refId, $stage, $actorName, $doc);
				$logLabel = ($stage === 'sup') ? 'Sup Approved' : 'CM Approved';
			}

			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			throw $e;
		}

		spr_log_status($conn, $refId, $logLabel, $reason, $session);
		return array('ref_id' => $refId, 'status_doc' => $newStatus);
	}
}

if (!function_exists('spr_document_return_status_label')) {
	function spr_document_return_status_label($statusDoc)
	{
		$map = array(
			'Sup Returned' => 'ส่งกลับ',
			'CM Returned'  => 'ส่งกลับ',
			'Returned'     => 'ส่งกลับ',
			'ส่งกลับ'         => 'ส่งกลับ',
			'Sup Rejected' => 'ไม่อนุมัติ',
			'CM Rejected'  => 'ไม่อนุมัติ',
			'Rejected'     => 'ไม่อนุมัติ',
			'Cancelled'    => 'ยกเลิกเอกสาร',
			'ยกเลิก'          => 'ยกเลิกเอกสาร',
		);
		return isset($map[$statusDoc]) ? $map[$statusDoc] : $statusDoc;
	}
}

if (!function_exists('spr_document_return_status_class')) {
	function spr_document_return_status_class($statusDoc)
	{
		$map = array(
			'Sup Returned' => 'is-returned',
			'CM Returned'  => 'is-returned',
			'Returned'     => 'is-returned',
			'ส่งกลับ'         => 'is-returned',
			'Sup Rejected' => 'is-rejected',
			'CM Rejected'  => 'is-rejected',
			'Rejected'     => 'is-rejected',
			'Cancelled'    => 'is-cancelled',
			'ยกเลิก'          => 'is-cancelled',
		);
		return isset($map[$statusDoc]) ? $map[$statusDoc] : 'is-cancelled';
	}
}

if (!function_exists('spr_document_return_reason_title')) {
	function spr_document_return_reason_title($statusDoc)
	{
		$map = array(
			'Sup Returned' => 'เหตุผลในการส่งกลับ',
			'CM Returned'  => 'เหตุผลในการส่งกลับ',
			'Returned'     => 'เหตุผลในการส่งกลับ',
			'ส่งกลับ'         => 'เหตุผลในการส่งกลับ',
			'Sup Rejected' => 'เหตุผลที่ไม่อนุมัติ',
			'CM Rejected'  => 'เหตุผลที่ไม่อนุมัติ',
			'Rejected'     => 'เหตุผลที่ไม่อนุมัติ',
			'Cancelled'    => 'เหตุผลในการยกเลิก',
			'ยกเลิก'          => 'เหตุผลในการยกเลิก',
		);
		return isset($map[$statusDoc]) ? $map[$statusDoc] : '';
	}
}

if (!function_exists('spr_format_document_log_datetime')) {
	function spr_format_document_log_datetime($createdAt)
	{
		$createdAt = trim((string)$createdAt);
		if ($createdAt === '') {
			return '';
		}
		$timestamp = strtotime($createdAt);
		if ($timestamp === false) {
			return '';
		}
		return date('d-m-Y H:i', $timestamp);
	}
}

if (!function_exists('spr_load_status_log')) {
	/**
	 * ประวัติส่งกลับ/ไม่อนุมัติ/ยกเลิก — กรองเฉพาะ label ที่ spr_run_document_action()
	 * เขียนตอน return/reject/cancel ไม่รวม 'Submitted'/'Updated'/'*Approved'
	 * ซึ่งไม่ใช่เหตุการณ์ "ส่งกลับเอกสาร"
	 */
	function spr_load_status_log($conn, $refId)
	{
		$rows = array();
		$refId = trim((string)$refId);
		if ($refId === '' || !spr_table_exists($conn, 'tb_document_status_log')) {
			return $rows;
		}
		$statusList = "'Sup Returned','CM Returned','Returned','ส่งกลับ','Sup Rejected','CM Rejected','Rejected','Cancelled','ยกเลิก'";
		$stmt = mysqli_prepare($conn, "SELECT status_doc, reason, user_name, created_at FROM tb_document_status_log WHERE ref_id = ? AND status_doc IN (" . $statusList . ") ORDER BY created_at DESC, id DESC");
		if (!$stmt) {
			return $rows;
		}
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if ($result) {
			while ($row = mysqli_fetch_assoc($result)) {
				$rows[] = $row;
			}
		}
		mysqli_stmt_close($stmt);
		return $rows;
	}
}
