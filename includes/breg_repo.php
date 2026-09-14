<?php

/**
 * ชั้นบันทึกข้อมูลของใบขอเบิกอะไหล่จากสินค้าขาย (BREG)
 *
 * ใช้ร่วมกันโดย
 *   - register_bregawl_draft1.php  (Save Draft → status_doc = 'Draft')
 *   - register_breg1.php โหมด v2   (Submit → status_doc = 'Request', send flag ยังเป็น 0)
 *
 * เขียนด้วย prepared statement + transaction ทั้งหมด ต่างจากตัวบันทึกเดิม
 * (register_breg1.php path เดิม / register_breg_edit1.php) ที่ต่อ string ตรง ๆ
 * และไม่ตรวจผลของ query รายการย่อยเลย — path เดิมยังอยู่ครบเพื่อรองรับ
 * register_bregnbm.php และหน้าแก้ไขเดิมที่ยังยิงมาแบบ field ตายตัว 10 แถว
 *
 * คอลัมน์ sort_order (sql/breg_dynamic_rows.sql) เป็น optional — ทุกจุดที่แตะ
 * ผ่าน breg_column_exists() จึงรันได้ทั้งก่อนและหลัง migration
 */

if (!class_exists('BregValidationException')) {
	/**
	 * ข้อผิดพลาดที่ "แสดงให้ผู้ใช้เห็นได้" — ผิดกติกาการกรอก หรือเอกสารเปลี่ยนสถานะไปแล้ว
	 * ต่างจาก RuntimeException ทั่วไปในไฟล์นี้ซึ่งพก error ของ MySQL มาด้วย
	 * และต้องไม่ถูกส่งกลับไปหน้าเว็บตรง ๆ (ลง error_log แล้วตอบข้อความกลาง ๆ แทน)
	 */
	class BregValidationException extends RuntimeException
	{
	}
}

if (!function_exists('breg_relax_sql_mode')) {
	/**
	 * ตาราง hos__breg / hos__subbreg* เป็น NOT NULL ทุกคอลัมน์และไม่มี DEFAULT
	 * (ดู SHOW COLUMNS) ค่าที่ผู้ใช้ยังไม่กรอก — โดยเฉพาะ Draft — จึงต้องพึ่ง
	 * การ implicit default ของ MySQL แบบ non-strict เหมือนที่ register_suphos1.php
	 * และ register_supchange1.php ทำอยู่แล้ว
	 */
	function breg_relax_sql_mode($conn)
	{
		@mysqli_query($conn, "SET SESSION sql_mode = REPLACE(REPLACE(@@SESSION.sql_mode, 'STRICT_TRANS_TABLES', ''), 'STRICT_ALL_TABLES', '')");
	}
}

if (!function_exists('breg_column_exists')) {
	function breg_column_exists($conn, $table, $column)
	{
		static $cache = array();
		// key รวม connection ด้วย เพราะ schema ต่างกันได้ต่อฐาน (ฐานจริงกับฐานทดสอบ
		// อาจรัน migration ไม่เท่ากัน) — cache ที่ผูกกับชื่อคอลัมน์อย่างเดียวจะตอบผิดข้ามฐาน
		$key = spl_object_id($conn) . '|' . $table . '.' . $column;
		if (array_key_exists($key, $cache)) {
			return $cache[$key];
		}

		$safeTable = str_replace('`', '', $table);
		$sql = "SHOW COLUMNS FROM `" . $safeTable . "` LIKE '" . mysqli_real_escape_string($conn, $column) . "'";
		// mysqli อยู่ในโหมด exception ตั้งแต่ PHP 8.1 — ตารางหาย/สิทธิ์ไม่พอต้องแปลว่า
		// "ไม่มีคอลัมน์นี้" ไม่ใช่ทำให้ทั้งคำขอพัง
		try {
			$query = @mysqli_query($conn, $sql);
			$cache[$key] = ($query && mysqli_num_rows($query) > 0);
		} catch (Throwable $e) {
			$cache[$key] = false;
		}
		return $cache[$key];
	}
}

if (!function_exists('breg_year_month')) {
	function breg_year_month()
	{
		// รูปแบบเดิมของทั้งระบบ: 2 หลักท้ายของปี พ.ศ. + เดือน 2 หลัก
		return substr((string)(date("Y") + 543), -2) . date("m");
	}
}

if (!function_exists('breg_peek_next_ref_id')) {
	/**
	 * เลข RG ถัดไป "โดยประมาณ" สำหรับแสดงบนหัวฟอร์มก่อนบันทึก
	 * เลขจริงจะถูกจองตอนกด Save Draft / Submit ผ่าน breg_reserve_ref_id()
	 */
	function breg_peek_next_ref_id($conn)
	{
		$yearMonth = breg_year_month();
		return 'RG' . $yearMonth . breg_next_running_number($conn, $yearMonth);
	}
}

if (!function_exists('breg_next_running_number')) {
	function breg_next_running_number($conn, $yearMonth)
	{
		// จำกัดขอบเขตด้วย prefix เดือนปัจจุบัน เพื่อไม่ให้เอกสารเดือนอื่น
		// (หรือ ref_id รูปแบบแปลกปลอม) มามีผลกับเลขรันของเดือนนี้
		$prefix = 'RG' . $yearMonth;
		$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__breg WHERE ref_id LIKE '"
			. mysqli_real_escape_string($conn, $prefix) . "%'";
		$query = mysqli_query($conn, $sql);
		$row = $query ? mysqli_fetch_assoc($query) : null;
		$maxRefId = ($row && isset($row['MAXID'])) ? (string)$row['MAXID'] : '';

		$running = ($maxRefId === '') ? 0 : (int)substr($maxRefId, -4);
		return substr('00000' . ($running + 1), -4);
	}
}

if (!function_exists('breg_reserve_ref_id')) {
	/**
	 * จองเลข RG พร้อม INSERT หัวเอกสาร
	 *
	 * กันเลขชนสองชั้น:
	 *   1) GET_LOCK() — advisory lock ระดับเซิร์ฟเวอร์ ทำให้คำขอที่เข้ามาพร้อมกัน
	 *      เข้าคิวกันจริง ๆ โดยไม่ต้องพึ่ง row/gap lock ของ InnoDB
	 *      (เคยใช้ SELECT ... FOR UPDATE แต่ gap lock บน unique index ของ ref_id
	 *       ทำให้เกิด deadlock เมื่อหลาย request ยิงพร้อมกัน)
	 *   2) unique key uk_breg_ref_id (sql/breg_dynamic_rows.sql) — ด่านสุดท้าย
	 *      INSERT ที่ชนจะ error แล้ววนหาเลขถัดไป แทนที่จะเขียนทับเอกสารของคนอื่น
	 *      ยังกันได้แม้ฐานที่ยังไม่ได้รัน migration จะเหลือแค่ชั้นแรก
	 *
	 * ต้องเรียกตอนที่ยังไม่ได้เปิดทรานแซกชันอื่นค้างไว้
	 *
	 * @return string ref_id ที่จองได้ (throw RuntimeException ถ้าจองไม่สำเร็จ)
	 */
	function breg_reserve_ref_id($conn, array $header)
	{
		$yearMonth = breg_year_month();
		$prefix = 'RG' . $yearMonth;
		$lockName = 'breg_ref_id_' . $yearMonth;
		$lastError = '';

		$gotLock = breg_acquire_named_lock($conn, $lockName, 10);

		try {
			for ($attempt = 0; $attempt < 10; $attempt++) {
				mysqli_begin_transaction($conn);
				try {
					$running = (int)substr(breg_next_running_number($conn, $yearMonth), -4);
					$refId = $prefix . substr('00000' . ($running + $attempt), -4);

					breg_insert_header($conn, $refId, $header);
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
						usleep(50000 * ($attempt + 1)); // ถอยก่อนลองใหม่ ไม่ให้ชนซ้ำทันที
					}
				}
			}
		} finally {
			if ($gotLock) {
				breg_release_named_lock($conn, $lockName);
			}
		}

		throw new RuntimeException('ไม่สามารถออกเลขที่เอกสารได้ กรุณาลองใหม่อีกครั้ง (' . $lastError . ')');
	}
}

if (!function_exists('breg_acquire_named_lock')) {
	/**
	 * advisory lock ระดับเซิร์ฟเวอร์ (ผูกกับ connection ไม่ผูกกับทรานแซกชัน)
	 * ล้มเหลว = ไม่ถือว่า fatal — ยังมี unique key + retry เป็นด่านกันเลขซ้ำอยู่
	 */
	function breg_acquire_named_lock($conn, $lockName, $timeoutSeconds)
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

if (!function_exists('breg_release_named_lock')) {
	function breg_release_named_lock($conn, $lockName)
	{
		try {
			@mysqli_query($conn, "SELECT RELEASE_LOCK('" . mysqli_real_escape_string($conn, $lockName) . "')");
		} catch (Throwable $e) {
			// ปล่อยผ่าน — ล็อกจะหลุดเองเมื่อ connection ปิด
		}
	}
}

if (!function_exists('breg_insert_header')) {
	function breg_insert_header($conn, $refId, array $header)
	{
		$sql = "INSERT INTO hos__breg
			(ref_id, type_doc, register_date, add_by, add_date, bill_id, customer_name, description,
			 per_no, cm_no, sale_code, status_doc,
			 pro_come, pro_comedate, brdoc_eng, name_eng, date_brdoc,
			 send_sup, send_dm, send_supname, send_supdate)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

		$stmt = mysqli_prepare($conn, $sql);
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}

		mysqli_stmt_bind_param(
			$stmt,
			// s ref_id | i type_doc | s×10 register_date..status_doc | i pro_come | s pro_comedate
			// | i brdoc_eng | s name_eng | s date_brdoc | s send_sup | s send_dm | s send_supname | s send_supdate
			'sissssssssssisisssss',
			$refId,
			$header['type_doc'],
			$header['register_date'],
			$header['add_by'],
			$header['add_date'],
			$header['bill_id'],
			$header['customer_name'],
			$header['description'],
			$header['per_no'],
			$header['cm_no'],
			$header['sale_code'],
			$header['status_doc'],
			$header['pro_come'],
			$header['pro_comedate'],
			$header['brdoc_eng'],
			$header['name_eng'],
			$header['date_brdoc'],
			$header['send_sup'],
			$header['send_dm'],
			$header['send_supname'],
			$header['send_supdate']
		);

		$ok = mysqli_stmt_execute($stmt);
		$error = mysqli_stmt_error($stmt);
		mysqli_stmt_close($stmt);
		if (!$ok) {
			throw new RuntimeException($error);
		}
	}
}

if (!function_exists('breg_update_header')) {
	/**
	 * แก้ไขเฉพาะเอกสารที่ยังเป็น Draft เท่านั้น (WHERE status_doc = 'Draft')
	 * เอกสารที่ Submit/ส่งอนุมัติไปแล้วต้องแก้ผ่านหน้าแก้ไขเดิมเท่านั้น
	 *
	 * @return bool true = พบและอัปเดตแถว Draft, false = ไม่พบ (เอกสารเปลี่ยนสถานะไปแล้ว)
	 */
	function breg_update_header($conn, $refId, array $header, $nextStatusDoc)
	{
		$sql = "UPDATE hos__breg SET
				type_doc = ?, register_date = ?, bill_id = ?, customer_name = ?, description = ?,
				per_no = ?, cm_no = ?, sale_code = ?, status_doc = ?,
				pro_come = ?, pro_comedate = ?, brdoc_eng = ?, name_eng = ?, date_brdoc = ?,
				send_sup = ?, send_dm = ?, send_supname = ?, send_supdate = ?
			WHERE ref_id = ?";

		$stmt = mysqli_prepare($conn, $sql);
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}

		mysqli_stmt_bind_param(
			$stmt,
			// i type_doc | s×8 register_date..status_doc | i pro_come | s pro_comedate
			// | i brdoc_eng | s name_eng | s date_brdoc | s×4 send_sup..send_supdate | s ref_id (WHERE)
			'issssssssisissssss',
			$header['type_doc'],
			$header['register_date'],
			$header['bill_id'],
			$header['customer_name'],
			$header['description'],
			$header['per_no'],
			$header['cm_no'],
			$header['sale_code'],
			$nextStatusDoc,
			$header['pro_come'],
			$header['pro_comedate'],
			$header['brdoc_eng'],
			$header['name_eng'],
			$header['date_brdoc'],
			$header['send_sup'],
			$header['send_dm'],
			$header['send_supname'],
			$header['send_supdate'],
			$refId
		);

		$ok = mysqli_stmt_execute($stmt);
		$error = mysqli_stmt_error($stmt);
		mysqli_stmt_close($stmt);
		if (!$ok) {
			throw new RuntimeException($error);
		}
	}
}

if (!function_exists('breg_update_header_preserve_status')) {
	/**
	 * แก้ไขข้อมูลฟอร์มของเอกสารที่ยังไม่ปิด (ไม่ว่าจะอยู่สถานะไหน) โดยไม่แตะ
	 * status_doc/send_sup/send_dm เลย — ใช้กับปุ่ม "Update" ระหว่างรออนุมัติ
	 * ผู้เรียกต้อง lock แถวด้วย breg_lock_document() และเช็คว่าไม่ใช่ terminal มาก่อนแล้ว
	 */
	function breg_update_header_preserve_status($conn, $refId, array $header)
	{
		$sql = "UPDATE hos__breg SET
				type_doc = ?, register_date = ?, bill_id = ?, customer_name = ?, description = ?,
				per_no = ?, cm_no = ?, sale_code = ?,
				pro_come = ?, pro_comedate = ?, brdoc_eng = ?, name_eng = ?, date_brdoc = ?
			WHERE ref_id = ?";

		$stmt = mysqli_prepare($conn, $sql);
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}

		mysqli_stmt_bind_param(
			$stmt,
			'isssssssisisss',
			$header['type_doc'],
			$header['register_date'],
			$header['bill_id'],
			$header['customer_name'],
			$header['description'],
			$header['per_no'],
			$header['cm_no'],
			$header['sale_code'],
			$header['pro_come'],
			$header['pro_comedate'],
			$header['brdoc_eng'],
			$header['name_eng'],
			$header['date_brdoc'],
			$refId
		);

		$ok = mysqli_stmt_execute($stmt);
		$error = mysqli_stmt_error($stmt);
		mysqli_stmt_close($stmt);
		if (!$ok) {
			throw new RuntimeException($error);
		}
	}
}

if (!function_exists('breg_lock_draft')) {
	/**
	 * ล็อกแถวเอกสารไว้ก่อนแก้ไข และยืนยันว่ายังเป็น Draft อยู่จริง
	 * ต้องเรียกภายในทรานแซกชัน — ถ้าคืน null แปลว่าเอกสารไม่มีอยู่หรือเปลี่ยน
	 * สถานะไปแล้ว (มีคน Submit/ส่งอนุมัติแซง) ผู้เรียกต้องยกเลิกการบันทึก
	 */
	function breg_lock_draft($conn, $refId)
	{
		$stmt = mysqli_prepare($conn, "SELECT ref_id, status_doc, register_date, add_by, add_date FROM hos__breg WHERE ref_id = ? LIMIT 1 FOR UPDATE");
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);

		if (!$row || ($row['status_doc'] ?? '') !== 'Draft') {
			return null;
		}
		return $row;
	}
}

if (!function_exists('breg_terminal_statuses')) {
	function breg_terminal_statuses()
	{
		return array('Approve', 'Rejected', 'ยกเลิก');
	}
}

if (!function_exists('breg_is_terminal_status')) {
	function breg_is_terminal_status($statusDoc)
	{
		return in_array($statusDoc, breg_terminal_statuses(), true);
	}
}

if (!function_exists('breg_lock_document')) {
	/**
	 * ล็อกแถวเอกสารไว้ก่อนแก้ไข/เปลี่ยนสถานะ ไม่จำกัดว่าต้องเป็น Draft (ต่างจาก
	 * breg_lock_draft) — ผู้เรียกเป็นคนตัดสินเองว่าสถานะปัจจุบันเหมาะกับ action ที่จะทำหรือไม่
	 * ต้องเรียกภายในทรานแซกชัน คืน null เมื่อไม่พบเอกสาร
	 */
	function breg_lock_document($conn, $refId)
	{
		$stmt = mysqli_prepare($conn, "SELECT * FROM hos__breg WHERE ref_id = ? LIMIT 1 FOR UPDATE");
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

if (!function_exists('breg_row_exists_with_status')) {
	function breg_row_exists_with_status($conn, $refId, $statusDoc)
	{
		$stmt = mysqli_prepare($conn, "SELECT 1 FROM hos__breg WHERE ref_id = ? AND status_doc = ? LIMIT 1");
		if (!$stmt) {
			return false;
		}
		mysqli_stmt_bind_param($stmt, 'ss', $refId, $statusDoc);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$found = mysqli_stmt_num_rows($stmt) > 0;
		mysqli_stmt_close($stmt);
		return $found;
	}
}

if (!function_exists('breg_is_draft')) {
	function breg_is_draft($conn, $refId)
	{
		return breg_row_exists_with_status($conn, $refId, 'Draft');
	}
}

if (!function_exists('breg_load_document')) {
	function breg_load_document($conn, $refId)
	{
		$stmt = mysqli_prepare($conn, "SELECT * FROM hos__breg WHERE ref_id = ? LIMIT 1");
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

if (!function_exists('breg_load_items')) {
	/**
	 * รายการย่อยของเอกสาร พร้อมชื่อ/รหัส/หน่วยจาก tb_product
	 * เรียงตาม sort_order เมื่อมีคอลัมน์ ไม่งั้นกลับไปเรียงตาม id_sub เหมือนเดิม
	 *
	 * @param int $group 1 = รายการอะไหล่ที่ต้องการเบิก, 2 = เบิกอะไหล่จากสินค้า
	 */
	function breg_load_items($conn, $refId, $group)
	{
		if ((int)$group === 1) {
			$table = 'hos__subbreg1';
			$idCol = 'id_sub1';
			$refCol = 'ref_id1';
			$productCol = 'product_id1';
			$countCol = 'count1';
			$snCol = 'sn_number1';
			$remarkCol = 'remark_eng1';
			$typeCol = null;
		} else {
			$table = 'hos__subbreg2';
			$idCol = 'id_sub2';
			$refCol = 'ref_id2';
			$productCol = 'product_id2';
			$countCol = 'count2';
			$snCol = 'sn_number2';
			$remarkCol = 'remark_eng2';
			$typeCol = 'type_probd';
		}

		$orderBy = breg_column_exists($conn, $table, 'sort_order')
			? "sub.sort_order ASC, sub." . $idCol . " ASC"
			: "sub." . $idCol . " ASC";

		$sql = "SELECT sub." . $idCol . " AS id_sub,
					sub." . $productCol . " AS product_id,
					sub." . $countCol . " AS count_value,
					sub." . $snCol . " AS sn_number,
					sub." . $remarkCol . " AS remark_eng,
					" . ($typeCol ? "sub." . $typeCol . " AS type_probd," : "'' AS type_probd,") . "
					p.access_code, p.sol_name, p.unit_name, p.product_type
				FROM " . $table . " sub
				LEFT JOIN tb_product p ON p.product_ID = sub." . $productCol . "
				WHERE sub." . $refCol . " = ?
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

if (!function_exists('breg_collect_items_from_post')) {
	/**
	 * อ่านรายการแบบ dynamic array จากฟอร์มใหม่ (ไม่จำกัด 10 แถวเหมือนของเดิม)
	 * แถวที่ไม่มี product_id จะถูกข้าม เหมือนกติกาของตัวบันทึกเดิม
	 *
	 * @param string $prefix 'g1' หรือ 'g2'
	 */
	function breg_collect_items_from_post($prefix)
	{
		$ids = isset($_POST[$prefix . '_product_id']) && is_array($_POST[$prefix . '_product_id'])
			? $_POST[$prefix . '_product_id']
			: array();

		$read = function ($field, $index) use ($prefix) {
			$key = $prefix . '_' . $field;
			if (!isset($_POST[$key]) || !is_array($_POST[$key]) || !isset($_POST[$key][$index])) {
				return '';
			}
			return trim((string)$_POST[$key][$index]);
		};

		$rows = array();
		foreach ($ids as $index => $rawId) {
			$productId = (int)trim((string)$rawId);
			if ($productId <= 0) {
				continue;
			}

			$count = str_replace(',', '', $read('count', $index));
			$rows[] = array(
				'product_id' => $productId,
				'count'      => is_numeric($count) ? (string)(int)round((float)$count) : '0',
				'sn_number'  => $read('sn', $index),
				'remark_eng' => $read('remark', $index),
				'type_probd' => $read('type_probd', $index),
			);
		}

		return $rows;
	}
}

if (!function_exists('breg_replace_items')) {
	/**
	 * ลบรายการเดิมของเอกสารแล้วเขียนชุดใหม่ทั้งหมด — ต้องเรียกภายในทรานแซกชัน
	 * ที่ผู้เรียกเปิดไว้ เพื่อให้ล้มเหลวแล้ว rollback ได้ทั้งก้อน
	 */
	function breg_replace_items($conn, $refId, $group, array $rows)
	{
		$hasSortOrder1 = breg_column_exists($conn, 'hos__subbreg1', 'sort_order');
		$hasSortOrder2 = breg_column_exists($conn, 'hos__subbreg2', 'sort_order');

		if ((int)$group === 1) {
			$deleteSql = "DELETE FROM hos__subbreg1 WHERE ref_id1 = ?";
			$insertSql = $hasSortOrder1
				? "INSERT INTO hos__subbreg1 (ref_id1, product_id1, product_code1, count1, remark_eng1, sn_number1, sort_order) VALUES (?,?,?,?,?,?,?)"
				: "INSERT INTO hos__subbreg1 (ref_id1, product_id1, product_code1, count1, remark_eng1, sn_number1) VALUES (?,?,?,?,?,?)";
		} else {
			$deleteSql = "DELETE FROM hos__subbreg2 WHERE ref_id2 = ?";
			$insertSql = $hasSortOrder2
				? "INSERT INTO hos__subbreg2 (ref_id2, product_id2, product_code2, count2, remark_eng2, sn_number2, type_probd, sort_order) VALUES (?,?,?,?,?,?,?,?)"
				: "INSERT INTO hos__subbreg2 (ref_id2, product_id2, product_code2, count2, remark_eng2, sn_number2, type_probd) VALUES (?,?,?,?,?,?,?)";
		}

		$deleteStmt = mysqli_prepare($conn, $deleteSql);
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
			return;
		}

		$insertStmt = mysqli_prepare($conn, $insertSql);
		if (!$insertStmt) {
			throw new RuntimeException(mysqli_error($conn));
		}

		$sortOrder = 0;
		foreach ($rows as $row) {
			$sortOrder++;
			$productId = (int)$row['product_id'];

			if ((int)$group === 1) {
				if ($hasSortOrder1) {
					// s ref | i product_id | i product_code | s count | s remark | s sn | i sort_order
					mysqli_stmt_bind_param($insertStmt, 'siisssi', $refId, $productId, $productId, $row['count'], $row['remark_eng'], $row['sn_number'], $sortOrder);
				} else {
					mysqli_stmt_bind_param($insertStmt, 'siisss', $refId, $productId, $productId, $row['count'], $row['remark_eng'], $row['sn_number']);
				}
			} else {
				if ($hasSortOrder2) {
					mysqli_stmt_bind_param($insertStmt, 'siissssi', $refId, $productId, $productId, $row['count'], $row['remark_eng'], $row['sn_number'], $row['type_probd'], $sortOrder);
				} else {
					mysqli_stmt_bind_param($insertStmt, 'siissss', $refId, $productId, $productId, $row['count'], $row['remark_eng'], $row['sn_number'], $row['type_probd']);
				}
			}

			if (!mysqli_stmt_execute($insertStmt)) {
				$error = mysqli_stmt_error($insertStmt);
				mysqli_stmt_close($insertStmt);
				throw new RuntimeException($error);
			}
		}

		mysqli_stmt_close($insertStmt);
	}
}

if (!function_exists('breg_header_from_post')) {
	/**
	 * แปลง $_POST ของฟอร์มใหม่เป็นค่าที่พร้อมเขียนลง hos__breg
	 * คอลัมน์วันที่เป็น NOT NULL ไม่รับ NULL จึงใช้ '0000-00-00' / '0000-00-00 00:00:00'
	 * แทนค่าว่าง ให้ตรงกับที่ from_breg.php เช็คอยู่แล้ว
	 */
	function breg_header_from_post(array $session)
	{
		$post = function ($key, $default = '') {
			if (!isset($_POST[$key]) || is_array($_POST[$key])) {
				return $default;
			}
			return trim((string)$_POST[$key]);
		};

		$now = new DateTimeImmutable('now', new DateTimeZone('Asia/Bangkok'));
		$registerDate = $now->format('Y-m-d');
		$typeDoc = $post('type_doc', '1');
		if (!in_array($typeDoc, array('1', '2'), true)) {
			throw new BregValidationException('กรุณาเลือกบริษัท AWL หรือ NBM');
		}

		$proComeDate = $post('pro_comedate');
		$proComeDate = ($proComeDate === '') ? '0000-00-00' : $proComeDate;

		$dateBrdoc = $post('date_brdoc');
		$dateBrdoc = ($dateBrdoc === '') ? '0000-00-00 00:00:00' : ($dateBrdoc . ' 00:00:00');

		$name = isset($session['name']) ? $session['name'] : '';
		$surname = isset($session['surname']) ? $session['surname'] : '';

		return array(
			'type_doc'      => (int)$typeDoc,
			'register_date' => $registerDate,
			'add_by'        => trim($name . ' ' . $surname),
			'add_date'      => $now->format('Y-m-d H:i:s'),
			'bill_id'       => $post('bill_id'),
			'customer_name' => $post('customer_name'),
			'description'   => $post('description'),
			'per_no'        => $post('per_no'),
			'cm_no'         => $post('cm_no'),
			'sale_code'     => $post('sale_code') !== '' ? $post('sale_code') : (isset($session['code']) ? $session['code'] : ''),
			'status_doc'    => 'Draft',
			'pro_come'      => ($post('pro_come') === '1') ? 1 : 0,
			'pro_comedate'  => $proComeDate,
			'brdoc_eng'     => ($post('brdoc_eng') === '1') ? 1 : 0,
			'name_eng'      => $post('name_eng'),
			'date_brdoc'    => $dateBrdoc,
			// ค่าตั้งต้น — breg_persist_from_post() จะ override เป็น 1/สถานะจริงเฉพาะตอน submit
			'send_sup'      => '0',
			'send_dm'       => '0',
			'send_supname'  => '',
			'send_supdate'  => '0000-00-00 00:00:00',
		);
	}
}

if (!function_exists('breg_validate_for_submit')) {
	/**
	 * กติกาตอน Submit (Draft ไม่ต้องผ่านด่านนี้)
	 * ต้องตรงกับที่ JS เช็คฝั่งหน้าเว็บ — บังคับซ้ำที่ฝั่ง server เพราะการซ่อนปุ่ม
	 * อย่างเดียวกันคนยิง POST ตรงไม่ได้
	 *
	 * @return string[] รายการข้อความผิดพลาด (ว่าง = ผ่าน)
	 */
	function breg_validate_for_submit(array $header, array $items1, array $items2)
	{
		$errors = array();

		if ($header['cm_no'] === '') {
			$errors[] = 'กรุณากรอกเลขที่ใบงานบริการ';
		}
		if ($header['per_no'] === '') {
			$errors[] = 'กรุณากรอกเลขที่ PER';
		}
		if ($header['bill_id'] === '' || $header['customer_name'] === '') {
			$errors[] = 'กรุณาเลือกลูกค้า';
		}
		if ($header['description'] === '') {
			$errors[] = 'กรุณากรอกวัตถุประสงค์การเบิก';
		}
		if (count($items1) === 0 && count($items2) === 0) {
			$errors[] = 'กรุณาเพิ่มรายการอย่างน้อย 1 รายการ';
		}

		foreach (array_merge($items1, $items2) as $row) {
			if ((int)$row['count'] < 1) {
				$errors[] = 'จำนวนของทุกรายการต้องมากกว่า 0';
				break;
			}
		}

		$errors = array_merge($errors, breg_validate_engineer_section($header));

		return $errors;
	}
}

if (!function_exists('breg_validate_engineer_section')) {
	/**
	 * ส่วนของช่าง — กรอกได้ตั้งแต่สร้างใบ แต่ถ้ากรอกแล้วต้องครบชุด
	 * ใช้ทั้งตอน Submit และตอน Save Draft (Draft ที่กรอกช่างมาครึ่ง ๆ ก็ยังผิดกติกา
	 * เพราะเป็นข้อมูลที่ไปโผล่ในใบพิมพ์และคิวช่างต่อ)
	 */
	function breg_validate_engineer_section(array $header)
	{
		$errors = array();
		$hasComeDate = ($header['pro_comedate'] !== '' && strpos($header['pro_comedate'], '0000-00-00') !== 0);
		$hasBrdocDate = ($header['date_brdoc'] !== '' && strpos($header['date_brdoc'], '0000-00-00') !== 0);

		if ((int)$header['pro_come'] === 1 && !$hasComeDate) {
			$errors[] = 'เมื่อติ๊ก "รับเข้าอะไหล่" ต้องระบุวันที่รับเข้า';
		}

		if ((int)$header['brdoc_eng'] === 1) {
			if (!$hasBrdocDate) {
				$errors[] = 'เมื่อติ๊ก "ประกอบเรียบร้อย" ต้องระบุวันที่ประกอบ';
			}
			if ($header['name_eng'] === '') {
				$errors[] = 'เมื่อติ๊ก "ประกอบเรียบร้อย" ต้องเลือกช่างประกอบ';
			}
		}

		if ($hasComeDate && $hasBrdocDate) {
			$comeDate = substr($header['pro_comedate'], 0, 10);
			$brdocDate = substr($header['date_brdoc'], 0, 10);
			if (strtotime($brdocDate) < strtotime($comeDate)) {
				$errors[] = 'วันที่ประกอบต้องไม่ก่อนวันที่รับเข้าอะไหล่';
			}
		}

		return $errors;
	}
}

if (!function_exists('breg_persist_from_post')) {
	/**
	 * เส้นทางบันทึกเดียวของฟอร์มใหม่ ใช้ทั้ง Save Draft และ Submit
	 *
	 *   - ยังไม่มี ref_id  → จองเลข RG ใหม่ + INSERT หัวเอกสาร แล้วเขียนรายการในทรานแซกชันถัดมา
	 *   - มี ref_id + Draft → UPDATE ทับใบเดิม เลขไม่เปลี่ยน
	 *   - มี ref_id แต่ไม่ใช่ Draft → ปฏิเสธ (เอกสารถูก Submit/ส่งอนุมัติไปแล้ว)
	 *
	 * รายการทั้งสองกลุ่มถูกเขียนในทรานแซกชันเดียวกับหัวเอกสาร (กรณี update)
	 * หรือทรานแซกชันที่สอง (กรณี insert ใหม่ ซึ่งหัวเอกสาร commit ไปแล้วตอนจองเลข)
	 * — ถ้าเขียนรายการล้มเหลวหลังจองเลข ใบจะถูกลบทิ้งเพื่อไม่ให้เหลือหัวเอกสารเปล่า
	 *
	 * @param string $mode 'draft' หรือ 'submit'
	 * @return array{ref_id:string,created:bool}
	 */
	function breg_persist_from_post($conn, $mode, array $session)
	{
		breg_relax_sql_mode($conn);

		$refId = isset($_POST['ref_id']) && !is_array($_POST['ref_id']) ? trim((string)$_POST['ref_id']) : '';

		// mode 'draft' บนเอกสารที่ไม่ใช่ Draft (มา approve/return ระหว่างทางแล้ว) = "Update"
		// อัปเดตเฉพาะข้อมูลฟอร์ม ไม่แตะ status_doc/send_sup/send_dm เลย
		if ($mode === 'draft' && $refId !== '') {
			$existing = breg_load_document($conn, $refId);
			if ($existing !== null && $existing['status_doc'] !== 'Draft') {
				if (breg_is_terminal_status($existing['status_doc'])) {
					throw new BregValidationException('เอกสารเลขที่ ' . $refId . ' ปิดแล้ว ไม่สามารถแก้ไขได้');
				}
				return breg_persist_update($conn, $refId, $session);
			}
		}

		$header = breg_header_from_post($session);
		$items1 = breg_collect_items_from_post('g1');
		$items2 = breg_collect_items_from_post('g2');

		$errors = ($mode === 'submit')
			? breg_validate_for_submit($header, $items1, $items2)
			: breg_validate_engineer_section($header);

		if (count($errors) > 0) {
			throw new BregValidationException(implode("\n", $errors));
		}

		if ($mode === 'submit') {
			// Submit ต้องเข้าคิว Sup ทันทีในทรานแซกชันเดียว ไม่มีขั้นกดส่ง Sup แยกอีกต่อไป
			$header['status_doc'] = 'Request';
			$header['send_sup'] = '1';
			$header['send_dm'] = '0';
			$header['send_supname'] = $header['add_by'];
			$header['send_supdate'] = $header['add_date'];
		} else {
			$header['status_doc'] = 'Draft';
		}
		$nextStatus = $header['status_doc'];

		if ($refId !== '') {
			mysqli_begin_transaction($conn);
			try {
				$original = breg_lock_document($conn, $refId);
				if ($original === null) {
					throw new BregValidationException('ไม่พบเอกสารเลขที่ ' . $refId);
				}

				$originalStatus = $original['status_doc'];
				// เอกสารที่ Sup ส่งกลับ (Request/0/0) submit ใหม่ได้โดยไม่ต้องผ่าน Draft อีกรอบ
				$isSupReturned = ($originalStatus === 'Request' && (string)$original['send_sup'] === '0' && (string)$original['send_dm'] === '0');

				if ($mode === 'submit') {
					if ($originalStatus !== 'Draft' && !$isSupReturned) {
						throw new BregValidationException('เอกสารเลขที่ ' . $refId . ' ไม่ได้อยู่ในสถานะที่ Submit ได้แล้ว กรุณาโหลดหน้าใหม่');
					}
				} else if ($originalStatus !== 'Draft') {
					throw new BregValidationException('เอกสารเลขที่ ' . $refId . ' ไม่ได้อยู่ในสถานะ Draft แล้ว จึงบันทึกทับไม่ได้');
				}

				foreach (array('register_date', 'add_by', 'add_date') as $field) {
					$header[$field] = $original[$field];
				}
				breg_update_header($conn, $refId, $header, $nextStatus);
				breg_replace_items($conn, $refId, 1, $items1);
				breg_replace_items($conn, $refId, 2, $items2);
				mysqli_commit($conn);
			} catch (Exception $e) {
				mysqli_rollback($conn);
				throw $e;
			}

			if ($mode === 'submit') {
				breg_log_status($conn, $refId, 'Submitted', '', $session);
			}

			return array('ref_id' => $refId, 'created' => false);
		}

		$newRefId = breg_reserve_ref_id($conn, $header);

		mysqli_begin_transaction($conn);
		try {
			breg_replace_items($conn, $newRefId, 1, $items1);
			breg_replace_items($conn, $newRefId, 2, $items2);
			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			// หัวเอกสาร commit ไปแล้วตอนจองเลข — เก็บกวาดเองเพื่อไม่ให้เหลือใบเปล่า
			// (ลบด้วย ref_id ที่เพิ่งจองเองในคำขอนี้เท่านั้น ปลอดภัยไม่ว่า mode จะเป็น draft หรือ submit
			// เพราะ $newRefId มาจาก breg_reserve_ref_id() ที่เพิ่งสร้างขึ้นในคำขอนี้เท่านั้น)
			$cleanup = mysqli_prepare($conn, "DELETE FROM hos__breg WHERE ref_id = ?");
			if ($cleanup) {
				mysqli_stmt_bind_param($cleanup, 's', $newRefId);
				mysqli_stmt_execute($cleanup);
				mysqli_stmt_close($cleanup);
			}
			throw $e;
		}

		if ($mode === 'submit') {
			breg_log_status($conn, $newRefId, 'Submitted', '', $session);
		}

		return array('ref_id' => $newRefId, 'created' => true);
	}
}

if (!function_exists('breg_persist_update')) {
	/**
	 * "Update" ของเอกสารที่ไม่ใช่ Draft (กำลังรออนุมัติ หรือถูกส่งกลับ) — บันทึกเฉพาะ
	 * ข้อมูลฟอร์ม ไม่แตะ status_doc/send_sup/send_dm เลย ใช้ทั้งปุ่ม Update ปกติและปุ่ม
	 * Update บนแถบอนุมัติ (ก่อนกดอนุมัติ/ส่งกลับ/ไม่อนุมัติจริง)
	 */
	function breg_persist_update($conn, $refId, array $session)
	{
		breg_relax_sql_mode($conn);

		$header = breg_header_from_post($session);
		$items1 = breg_collect_items_from_post('g1');
		$items2 = breg_collect_items_from_post('g2');

		$errors = breg_validate_engineer_section($header);
		if (count($errors) > 0) {
			throw new BregValidationException(implode("\n", $errors));
		}

		mysqli_begin_transaction($conn);
		try {
			$existing = breg_lock_document($conn, $refId);
			if ($existing === null) {
				throw new BregValidationException('ไม่พบเอกสารเลขที่ ' . $refId);
			}
			if (breg_is_terminal_status($existing['status_doc'])) {
				throw new BregValidationException('เอกสารเลขที่ ' . $refId . ' ปิดแล้ว ไม่สามารถแก้ไขได้');
			}

			foreach (array('register_date', 'add_by', 'add_date') as $field) {
				$header[$field] = $existing[$field];
			}
			breg_update_header_preserve_status($conn, $refId, $header);
			breg_replace_items($conn, $refId, 1, $items1);
			breg_replace_items($conn, $refId, 2, $items2);
			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			throw $e;
		}

		breg_log_status($conn, $refId, 'Updated', '', $session);

		return array('ref_id' => $refId, 'created' => false);
	}
}

if (!function_exists('breg_approve_stage')) {
	/**
	 * ปุ่ม "อนุมัติ" ของ Sup/DM — ต้องบันทึกฟอร์มปัจจุบันผ่าน full validation ก่อน
	 * แล้วค่อยเปลี่ยนสถานะ ทั้งหมดในทรานแซกชันเดียว
	 *
	 * @param string $stage 'sup' หรือ 'dm'
	 */
	function breg_approve_stage($conn, $refId, $stage, array $session)
	{
		breg_relax_sql_mode($conn);

		$header = breg_header_from_post($session);
		$items1 = breg_collect_items_from_post('g1');
		$items2 = breg_collect_items_from_post('g2');

		$errors = breg_validate_for_submit($header, $items1, $items2);
		if (count($errors) > 0) {
			throw new BregValidationException(implode("\n", $errors));
		}

		mysqli_begin_transaction($conn);
		try {
			$doc = breg_lock_document($conn, $refId);
			if ($doc === null) {
				throw new BregValidationException('ไม่พบเอกสารเลขที่ ' . $refId);
			}
			if (breg_is_terminal_status($doc['status_doc'])) {
				throw new BregValidationException('เอกสารเลขที่ ' . $refId . ' ปิดแล้ว ไม่สามารถอนุมัติได้');
			}

			$isSupStage = ($doc['status_doc'] === 'Request' && (string)$doc['send_sup'] === '1' && (string)$doc['send_dm'] === '0');
			$isDmStage = ($doc['status_doc'] === 'Request' && (string)$doc['send_sup'] === '1' && (string)$doc['send_dm'] === '1');

			if ($stage === 'sup' && !$isSupStage) {
				throw new BregValidationException('เอกสารไม่ได้อยู่ในสถานะรอ Sup อนุมัติแล้ว กรุณาโหลดหน้าใหม่');
			}
			if ($stage === 'dm' && !$isDmStage) {
				throw new BregValidationException('เอกสารไม่ได้อยู่ในสถานะรอผู้บริหารอนุมัติแล้ว กรุณาโหลดหน้าใหม่');
			}

			foreach (array('register_date', 'add_by', 'add_date') as $field) {
				$header[$field] = $doc[$field];
			}
			breg_update_header_preserve_status($conn, $refId, $header);
			breg_replace_items($conn, $refId, 1, $items1);
			breg_replace_items($conn, $refId, 2, $items2);

			$actorName = trim(($session['name'] ?? '') . ' ' . ($session['surname'] ?? ''));
			if ($stage === 'sup') {
				breg_sup_approve($conn, $refId, $actorName);
			} else {
				breg_dm_approve($conn, $refId, $actorName);
			}

			mysqli_commit($conn);
		} catch (Exception $e) {
			mysqli_rollback($conn);
			throw $e;
		}

		breg_log_status($conn, $refId, ($stage === 'sup' ? 'Sup Approved' : 'DM Approved'), '', $session);
	}
}

if (!function_exists('breg_sup_approve')) {
	/**
	 * ผู้เรียกต้อง lock แถวด้วย breg_lock_document() และเช็ค stage มาก่อนแล้ว
	 * WHERE ในนี้เป็นด่านกันซ้อนอีกชั้น (defense in depth) ไม่ใช่จุดตรวจหลัก
	 */
	function breg_sup_approve($conn, $refId, $actorName)
	{
		$stmt = mysqli_prepare($conn, "UPDATE hos__breg SET send_dm='1', sup_name=?, sup_date=NOW() WHERE ref_id=? AND status_doc='Request' AND send_sup='1' AND send_dm='0'");
		mysqli_stmt_bind_param($stmt, 'ss', $actorName, $refId);
		mysqli_stmt_execute($stmt);
		$affected = mysqli_stmt_affected_rows($stmt);
		mysqli_stmt_close($stmt);
		if ($affected < 1) {
			throw new BregValidationException('เอกสารถูกเปลี่ยนสถานะไปแล้ว กรุณาโหลดหน้าใหม่');
		}
	}
}

if (!function_exists('breg_sup_return')) {
	function breg_sup_return($conn, $refId)
	{
		$stmt = mysqli_prepare($conn, "UPDATE hos__breg SET send_sup='0' WHERE ref_id=? AND status_doc='Request' AND send_sup='1' AND send_dm='0'");
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$affected = mysqli_stmt_affected_rows($stmt);
		mysqli_stmt_close($stmt);
		if ($affected < 1) {
			throw new BregValidationException('เอกสารถูกเปลี่ยนสถานะไปแล้ว กรุณาโหลดหน้าใหม่');
		}
	}
}

if (!function_exists('breg_sup_reject')) {
	function breg_sup_reject($conn, $refId, $actorName)
	{
		$stmt = mysqli_prepare($conn, "UPDATE hos__breg SET status_doc='Rejected', sup_name=?, sup_date=NOW() WHERE ref_id=? AND status_doc='Request' AND send_sup='1' AND send_dm='0'");
		mysqli_stmt_bind_param($stmt, 'ss', $actorName, $refId);
		mysqli_stmt_execute($stmt);
		$affected = mysqli_stmt_affected_rows($stmt);
		mysqli_stmt_close($stmt);
		if ($affected < 1) {
			throw new BregValidationException('เอกสารถูกเปลี่ยนสถานะไปแล้ว กรุณาโหลดหน้าใหม่');
		}
	}
}

if (!function_exists('breg_dm_approve')) {
	function breg_dm_approve($conn, $refId, $actorName)
	{
		$docNo = breg_generate_doc_no($conn, $refId);

		$stmt = mysqli_prepare($conn, "UPDATE hos__breg SET status_doc='Approve', dm_name=?, dm_date=NOW(), send_stock='1', iv_no=?, iv_date=NOW() WHERE ref_id=? AND status_doc='Request' AND send_sup='1' AND send_dm='1'");
		mysqli_stmt_bind_param($stmt, 'sss', $actorName, $docNo, $refId);
		mysqli_stmt_execute($stmt);
		$affected = mysqli_stmt_affected_rows($stmt);
		mysqli_stmt_close($stmt);
		if ($affected < 1) {
			throw new BregValidationException('เอกสารถูกเปลี่ยนสถานะไปแล้ว กรุณาโหลดหน้าใหม่');
		}
	}
}

if (!function_exists('breg_dm_return')) {
	function breg_dm_return($conn, $refId)
	{
		$stmt = mysqli_prepare($conn, "UPDATE hos__breg SET send_dm='0' WHERE ref_id=? AND status_doc='Request' AND send_sup='1' AND send_dm='1'");
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$affected = mysqli_stmt_affected_rows($stmt);
		mysqli_stmt_close($stmt);
		if ($affected < 1) {
			throw new BregValidationException('เอกสารถูกเปลี่ยนสถานะไปแล้ว กรุณาโหลดหน้าใหม่');
		}
	}
}

if (!function_exists('breg_dm_reject')) {
	function breg_dm_reject($conn, $refId, $actorName)
	{
		$stmt = mysqli_prepare($conn, "UPDATE hos__breg SET status_doc='Rejected', dm_name=?, dm_date=NOW() WHERE ref_id=? AND status_doc='Request' AND send_sup='1' AND send_dm='1'");
		mysqli_stmt_bind_param($stmt, 'ss', $actorName, $refId);
		mysqli_stmt_execute($stmt);
		$affected = mysqli_stmt_affected_rows($stmt);
		mysqli_stmt_close($stmt);
		if ($affected < 1) {
			throw new BregValidationException('เอกสารถูกเปลี่ยนสถานะไปแล้ว กรุณาโหลดหน้าใหม่');
		}
	}
}

if (!function_exists('breg_cancel_document')) {
	/**
	 * ทุกบทบาทที่เปิดเอกสารได้ยกเลิกได้ ตราบใดที่ยังไม่ปิด (terminal) — ไม่ต้อง lock
	 * ล่วงหน้าเพราะเป็น UPDATE เดี่ยวที่มี WHERE กันสถานะ terminal อยู่แล้วในตัว
	 */
	function breg_cancel_document($conn, $refId)
	{
		$terminal = "'" . implode("','", array_map(function ($s) use ($conn) {
			return mysqli_real_escape_string($conn, $s);
		}, breg_terminal_statuses())) . "'";

		$stmt = mysqli_prepare($conn, "UPDATE hos__breg SET status_doc='ยกเลิก' WHERE ref_id=? AND status_doc NOT IN ($terminal)");
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$affected = mysqli_stmt_affected_rows($stmt);
		mysqli_stmt_close($stmt);
		if ($affected < 1) {
			throw new BregValidationException('ไม่พบเอกสาร หรือเอกสารปิดไปแล้ว');
		}
	}
}

if (!function_exists('breg_generate_doc_no')) {
	/**
	 * ออกเลขที่เอกสาร (tb_docbreng) ตอน DM อนุมัติ — mirror ตรรกะเดิมจาก bregdm_app.php
	 * เฉพาะฝั่ง AWL (head_no='BREG') เท่านั้น เพราะหน้านี้จำกัด type_doc=1
	 * เรียกภายในทรานแซกชันของผู้เรียก (breg_approve_stage) จึงยังพึ่ง MAX()+1 แบบเดิมได้
	 * — ความเสี่ยงชนกันเท่าที่ของเดิมมีอยู่แล้ว ไม่ได้แย่ลง และไม่อยู่ในขอบเขตงานนี้
	 */
	function breg_generate_doc_no($conn, $refId)
	{
		$ivDate = date('Y-m-d');
		$dateParts = explode('-', $ivDate);
		$year1 = substr((string)((int)$dateParts[0] + 543), -2);
		$month = $dateParts[1];

		$stmt = mysqli_prepare($conn, "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng WHERE head_no='BREG' AND month_no=? AND year_no=?");
		mysqli_stmt_bind_param($stmt, 'ss', $month, $year1);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);

		$running = ((int)($row['MAXID'] ?? 0)) + 1;
		$runningPadded = substr('000' . $running, -3);
		$docNo = 'BREG' . $year1 . $month . $runningPadded;

		$insert = mysqli_prepare($conn, "INSERT INTO tb_docbreng (head_no, doc_no, year_no, month_no, run_iv, ref_id) VALUES ('BREG', ?, ?, ?, ?, ?)");
		mysqli_stmt_bind_param($insert, 'sssis', $docNo, $year1, $month, $running, $refId);
		mysqli_stmt_execute($insert);
		mysqli_stmt_close($insert);

		return $docNo;
	}
}

if (!function_exists('breg_table_exists')) {
	function breg_table_exists($conn, $table)
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

if (!function_exists('breg_redirect_if_awl_get_endpoint')) {
	/**
	 * ด่านกัน legacy GET endpoint (send_supbreg.php, send_dmbreg.php, bregsup_app.php,
	 * bregdm_app.php, bregsup_reject.php, bregdm_reject.php) mutate state ของเอกสาร AWL
	 * (type_doc=1) ที่ย้าย workflow ทั้งหมดไปหน้า register_bregawl.php แล้ว — กันลิงก์เก่า/
	 * บุ๊กมาร์กยิงซ้ำข้าม workflow ใหม่
	 *
	 * ต้องเรียกก่อน include head.php เสมอ (ก่อนมี HTML ใด ๆ ออกไป) ไม่งั้น header() จะใช้ไม่ได้
	 * — ฟังก์ชันนี้ exit() เองเมื่อ redirect จริง ผู้เรียกไม่ต้องเช็ค return value ก็ได้
	 */
	function breg_redirect_if_awl_get_endpoint($conn, $refId)
	{
		$stmt = mysqli_prepare($conn, "SELECT type_doc FROM hos__breg WHERE ref_id = ? LIMIT 1");
		if (!$stmt) {
			return;
		}
		mysqli_stmt_bind_param($stmt, 's', $refId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);

		if ($row && (string)$row['type_doc'] === '1') {
			header('Location: register_bregawl.php?ref_id=' . urlencode($refId));
			exit();
		}
	}
}

if (!function_exists('breg_notify_stage_change')) {
	/**
	 * Seam สำหรับแจ้งเตือน (LINE หรืออื่น ๆ) เมื่อเอกสารเปลี่ยน stage — เจตนาให้เป็น no-op
	 * ใน phase นี้ (ดู handoff ข้อ 10: "ไม่เรียก LINE Notify... ปล่อยเป็น no-op ใน phase นี้")
	 * เรียกได้หลัง commit ของทุก transition (submit/sup approve/dm approve/return/reject/cancel)
	 * โดยไม่ผูกกับ transaction ของการเปลี่ยนสถานะเอง — เพิ่ม implementation ทีหลังได้โดยไม่ต้อง
	 * แก้จุดเรียกใน breg_repo.php/register_bregawl_edit1.php เลย
	 *
	 * @param string $event เช่น 'submitted','sup_approved','sup_returned','sup_rejected',
	 *                       'dm_approved','dm_returned','dm_rejected','cancelled'
	 */
	function breg_notify_stage_change($conn, $refId, $event, array $session)
	{
		// no-op โดยตั้งใจ — ดู docblock ด้านบน
	}
}

if (!function_exists('breg_log_status')) {
	/**
	 * บันทึกประวัติ action ของเอกสาร (tb_document_status_log) — ใช้ label ที่แยกชั้น
	 * Sup/DM ไว้ในตัว (เช่น 'Sup Returned' vs 'DM Returned') เพราะ flags ของสถานะ
	 * pending ทั้งสองชั้นทับกันได้ (ดู breg state machine ใน handoff) log นี้จึงเป็นจุดเดียว
	 * ที่แยกบริบทของ stage ไว้ได้ครบ ไม่กระทบ consumer เดิมของตารางนี้เพราะ label ใหม่ทั้งหมด
	 */
	function breg_log_status($conn, $refId, $statusLabel, $reason, array $session)
	{
		if (!breg_table_exists($conn, 'tb_document_status_log')) {
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

if (!function_exists('breg_type_product_options')) {
	/**
	 * ประเภทสินค้าจากข้อมูลหลัก (tb_type_product) — ใช้เป็นตัวเลือกของ dropdown
	 * ในกลุ่ม "เบิกอะไหล่จากสินค้า" ตารางนี้อาจว่างในบางฐาน จึงต้องรองรับ empty state
	 */
	function breg_type_product_options($conn)
	{
		$options = array();
		try {
			$query = @mysqli_query($conn, "SELECT typeproduct_name FROM tb_type_product ORDER BY typeproduct_name ASC");
			if ($query) {
				while ($row = mysqli_fetch_assoc($query)) {
					$name = trim((string)$row['typeproduct_name']);
					if ($name !== '' && !in_array($name, $options, true)) {
						$options[] = $name;
					}
				}
			}
		} catch (Throwable $e) {
			// ตารางข้อมูลหลักหาย/อ่านไม่ได้ → ปล่อยเป็น empty state ไม่ทำให้หน้าฟอร์มพัง
			$options = array();
		}
		return $options;
	}
}
