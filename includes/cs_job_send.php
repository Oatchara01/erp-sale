<?php

/**
 * แกนกลางส่งใบงานลงสมุดลงงานของระบบ CS — ใช้ร่วมกันทุกเอกสารที่มี toggle "ส่งข้อมูลลงระบบ CS"
 * (SO เรียกผ่านตัวห่อใน includes/so_cs_send.php, SMP ใช้เฉพาะตัวออกเลข + lock ใน smp_export_to_cs())
 *
 * สมุดลงงานอยู่คนละฐานกับเอกสารขาย: ใบงานต้องเขียนผ่าน $com1 (dbconnect_cs.php) ไม่ใช่ $conn
 * tb_register_data ในฐานของ $conn เก็บแค่ข้อมูลจัดส่งของเอกสาร (ผูกด้วย ref_id) ฝ่าย CS ไม่เห็นแถวพวกนั้น
 *
 * อ่านข้อมูลจากแถวที่บันทึกแล้วในฐาน ไม่อ่านจาก POST จึงเรียกได้ทั้งจากการบันทึกปกติและปุ่ม Update แบบจำกัด
 *
 * ค่า send_cs ของเอกสาร: 0 = ยังไม่ส่ง, 2 = ส่งแล้ว (ล็อก) — ค่า 1 ไม่ถูกเก็บลงฐานอีกแล้ว
 *
 * $spec ที่แต่ละเอกสารต้องบอกเอง:
 *   table, ref_column     ตารางหลักและคอลัมน์ ref ของเอกสาร
 *   job_column            คอลัมน์เก็บเลขที่ลงงาน
 *   send_column           คอลัมน์สถานะส่ง (ไม่ระบุ = send_cs)
 *   roles                 type_login (ตัวพิมพ์เล็ก) ที่ส่งได้
 *   status_column         คอลัมน์สถานะเอกสาร (ไม่ระบุ = status_doc)
 *   blocked_status        สถานะเอกสารที่ไม่ให้ส่ง
 *   log_tag               คำนำหน้าใน error_log
 *   compose               callable($conn, $refId, array $doc, array $session): array ช่องใบงานที่ประกอบจากเอกสาร
 *   sale_code_column, iv_date_column   (ไม่ระบุ = sale_code, iv_date)
 *   job_overrides         callable(array $doc, array $reg): array คอลัมน์ใบงานที่ต้องใช้ค่านี้เสมอ แม้แถวข้อมูลจัดส่งมีค่าอยู่
 *   extra_jobs            callable(array $doc, array $reg): array ใบงานเพิ่มในการส่งครั้งเดียวกัน
 *                         แต่ละตัว = ['column' => คอลัมน์เก็บเลขในตารางหลัก, 'overrides' => [คอลัมน์ใบงาน => ค่า]]
 */

if (!function_exists('cs_job_role_allowed')) {
	function cs_job_role_allowed(array $session, array $roles)
	{
		return in_array(strtolower(trim((string)($session['type_login'] ?? ''))), $roles, true);
	}
}

if (!function_exists('cs_job_send_requested')) {
	function cs_job_send_requested(array $post)
	{
		return (($post['send_cs'] ?? '') === '1');
	}
}

if (!function_exists('cs_job_result')) {
	function cs_job_result($success, $message, $jobNo = '')
	{
		return array('success' => (bool)$success, 'message' => (string)$message, 'job_no' => (string)$jobNo);
	}
}

if (!function_exists('cs_job_json_fields')) {
	// คีย์เสริมใน JSON ของเส้นทาง Save Draft/Update ให้ JS ส่งต่อไปแสดงใน popup หลัง redirect
	function cs_job_json_fields($result)
	{
		if ($result === null) {
			return array();
		}
		return array('cs_sync' => $result['success'] ? '1' : '0', 'cs_sync_msg' => $result['message']);
	}
}

if (!function_exists('cs_job_redirect_query')) {
	function cs_job_redirect_query($result)
	{
		if ($result === null) {
			return '';
		}
		return '&cs_sync=' . ($result['success'] ? '1' : '0') . '&cs_sync_msg=' . rawurlencode($result['message']);
	}
}

if (!function_exists('cs_job_connect')) {
	function cs_job_connect()
	{
		// dbconnect_cs.php บางเครื่อง echo ข้อความตอนต่อไม่ได้ ซึ่งจะทำให้ JSON ของ Save Draft พัง จึงกลืน output ไว้
		ob_start();
		try {
			include __DIR__ . '/../dbconnect_cs.php';
		} finally {
			ob_end_clean();
		}
		if (!isset($com1) || !$com1) {
			throw new RuntimeException('เชื่อมต่อฐานข้อมูล CS ไม่ได้');
		}
		// ตารางฝั่ง CS มีคอลัมน์ NOT NULL ไม่มีค่า default หลายสิบคอลัมน์ที่ใบงานใหม่ไม่ได้กรอก
		mysqli_query($com1, "SET SESSION sql_mode = ''");
		return $com1;
	}
}

if (!function_exists('cs_job_query')) {
	function cs_job_query($link, $sql)
	{
		$result = mysqli_query($link, $sql);
		if ($result === false) {
			throw new RuntimeException(mysqli_error($link));
		}
		return $result;
	}
}

if (!function_exists('cs_job_insert')) {
	function cs_job_insert($link, $table, array $row)
	{
		$columns = array();
		$values = array();
		foreach ($row as $column => $value) {
			$columns[] = '`' . $column . '`';
			$values[] = "'" . mysqli_real_escape_string($link, (string)($value ?? '')) . "'";
		}
		cs_job_query($link, "INSERT INTO `" . $table . "` (" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ")");
	}
}

if (!function_exists('cs_job_year_month')) {
	// คำนำหน้าเลขที่ลงงาน: ปี พ.ศ. 2 หลัก + เดือน 2 หลัก ของวันที่ปัจจุบัน
	function cs_job_year_month()
	{
		return substr((string)((int)date('Y') + 543), -2) . date('m');
	}
}

if (!function_exists('cs_job_acquire_lock')) {
	/**
	 * ทุกเอกสารต้องถือ lock ชื่อเดียวกันขณะออกเลข ไม่งั้นสองเอกสารจะได้เลขที่ลงงานซ้ำกัน
	 * @return string ชื่อ lock สำหรับส่งให้ cs_job_release_lock()
	 */
	function cs_job_acquire_lock($com1, $yearMonth)
	{
		$lockName = 'so_cs_jobrun_' . $yearMonth;
		$lockRow = mysqli_fetch_assoc(cs_job_query($com1, "SELECT GET_LOCK('" . $lockName . "', 5) AS got_lock"));
		if ((int)($lockRow['got_lock'] ?? 0) !== 1) {
			throw new RuntimeException('ระบบกำลังออกเลขที่ลงงานให้ผู้ใช้รายอื่น');
		}
		return $lockName;
	}
}

if (!function_exists('cs_job_release_lock')) {
	function cs_job_release_lock($com1, $lockName)
	{
		if ($com1 && $lockName !== '') {
			@mysqli_query($com1, "SELECT RELEASE_LOCK('" . $lockName . "')");
		}
	}
}

if (!function_exists('cs_job_next_no')) {
	/**
	 * เลขที่ลงงานถัดไป: ปี พ.ศ. 2 หลัก + เดือน 2 หลัก + running 4 หลัก จากตัวนับของฐาน CS
	 * ต้องเรียกขณะถือ lock ของเดือนนั้นอยู่ (หน้า legacy ที่ยังออกเลขเองไม่ได้ใช้ lock นี้)
	 */
	function cs_job_next_no($com1, $yearMonth)
	{
		$query = cs_job_query($com1, "SELECT MAX(CAST(SUBSTRING(running, 5, 4) AS UNSIGNED)) AS max_run FROM tb_register_data
			WHERE running REGEXP '^[0-9]{8}$' AND LEFT(running, 4) = '" . mysqli_real_escape_string($com1, $yearMonth) . "'");
		$row = mysqli_fetch_assoc($query);
		$runNo = (int)($row['max_run'] ?? 0) + 1;
		if ($runNo > 9999) {
			throw new RuntimeException('เลขที่ลงงานของเดือนนี้เต็มแล้ว (เกิน 9999)');
		}
		return $yearMonth . substr('0000' . $runNo, -4);
	}
}

if (!function_exists('cs_job_compose_sale_fields')) {
	/**
	 * ช่องพนักงานขาย/แผนก/ผู้ส่งของใบงาน ประกอบจากรหัสขายและชื่อพนักงานขายของเอกสาร
	 * รหัสขายตรงกับ tb_user.code — รหัสเดียวอาจมีหลายคน จึงให้คนที่ชื่อตรงกับชื่อพนักงานขายของเอกสารมาก่อน
	 *
	 * @return array คีย์: employee_name, employee_tel, add_code, department, department_show, add_by
	 */
	function cs_job_compose_sale_fields($conn, $saleCode, $saleName, array $session)
	{
		$saleUser = array();
		$saleCode = trim((string)$saleCode);
		$saleName = trim((string)$saleName);
		if ($saleCode !== '' || $saleName !== '') {
			$userQuery = cs_job_query($conn, "SELECT em_id, name, employee_tel, department FROM tb_user
				WHERE (code = '" . mysqli_real_escape_string($conn, $saleCode) . "' AND code <> '') OR (name = '" . mysqli_real_escape_string($conn, $saleName) . "' AND name <> '')
				ORDER BY (code = '" . mysqli_real_escape_string($conn, $saleCode) . "' AND name = '" . mysqli_real_escape_string($conn, $saleName) . "') DESC,
					(code = '" . mysqli_real_escape_string($conn, $saleCode) . "') DESC, id LIMIT 1");
			$saleUser = mysqli_fetch_assoc($userQuery) ?: array();
		}
		$departmentShow = trim((string)($saleUser['department'] ?? ''));
		$departmentMap = array('ฝ่ายขาย' => 'Sale', 'ฝ่ายวิศวกรรม' => 'วิศวกรรม');

		return array(
			'employee_name'   => (string)($saleUser['name'] ?? $saleName),
			'employee_tel'    => (string)($saleUser['employee_tel'] ?? ''),
			'add_code'        => (string)($saleUser['em_id'] ?? ''),
			'department'      => $departmentMap[$departmentShow] ?? '',
			'department_show' => $departmentShow,
			'add_by'          => trim((string)($session['name'] ?? '') . ' ' . (string)($session['surname'] ?? '')),
		);
	}
}

if (!function_exists('cs_job_insert_job')) {
	/**
	 * เขียนใบงาน 1 ใบลงฐาน CS ทั้ง tb_register_data และ tb_transaction
	 * การ map ที่อยู่คงตาม register_adminhos_edit1.php เดิม: address_name = ที่อยู่ + จังหวัด, address_send = ชื่อสถานที่ + รายละเอียด
	 *
	 * @param callable $pick      function($column, $default = ''): string ค่าจากแถวข้อมูลจัดส่ง ว่างจึงใช้ค่าที่ประกอบจากเอกสาร
	 * @param array    $tx        แถว tb_transaction ของเอกสารในฐานขาย
	 * @param array    $overrides คอลัมน์ของ tb_register_data ที่ใบงานนี้ใช้ค่าต่างจาก $pick
	 */
	function cs_job_insert_job($com1, $jobNo, $refId, callable $pick, array $tx, $saleCode, $ivDate, $now, array $overrides = array())
	{
		$ivDate = (string)$ivDate;
		cs_job_insert($com1, 'tb_register_data', array_merge(array(
			'running'          => $jobNo,
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
			'address_name'     => trim($pick('address_1') . ' ' . $pick('province_name')),
			'address_send'     => trim($pick('address_name') . ' ' . $pick('address_send')),
			'want_bus'         => $pick('want_bus', '0'),
			'amphur_name'      => $pick('amphur_name'),
			'province_name'    => $pick('province_name'),
			'product_name'     => $pick('product_name'),
			'product_sn'       => $pick('product_sn'),
			'unit_credit'      => $pick('unit_credit'),
			'price'            => $pick('price'),
			'employee_name'    => $pick('employee_name'),
			'employee_tel'     => $pick('employee_tel'),
			'add_by'           => $pick('add_by'),
			'description'      => $pick('description'),
			'have_map'         => $pick('have_map', '0'),
			'add_date'         => $now,
			'unit_bill'        => $pick('unit_bill'),
			'unit_check'       => $pick('unit_check'),
			'unit_tran'        => $pick('unit_tran'),
			'tran'             => $pick('tran', '0'),
			'check_detail'     => $pick('check_detail', '0'),
			'number'           => $pick('number'),
			'status_comment'   => $pick('status_comment'),
			'dep'              => $pick('dep', '0'),
			'dept'             => $pick('dept'),
			'department_show'  => $pick('department_show'),
			'address_bus'      => $pick('province_name'),
			'customer_contact' => $pick('customer_contact'),
			'on_time'          => $pick('on_time', '0'),
			'add_code'         => $pick('add_code'),
			'mk_research'      => $pick('mk_research', '0'),
			'sale_code'        => (string)$saleCode,
			'bus_inter'        => $pick('bus_inter', '0'),
			'ref_id'           => $refId,
			'iv_date'          => ($ivDate !== '' ? $ivDate : '0000-00-00'),
		), $overrides));

		$txRow = array('running' => $jobNo);
		$txColumns = array(
			'runway', 'road', 'soy', 'soy_long', 'soy_big', 'car_load', 'car_park', 'car_road', 'no_car_road', 'car_home',
			'door_long', 'slope', 'bundai', 'unit_bundai', 'door_big', 'door_longer', 'type_door', 'home_type', 'install',
			'bundai_install', 'bundai_big', 'lip', 'lip_big', 'lip_long', 'lip_weight', 'want_employee', 'employee_unit',
			'ferniger_name', 'ferniger_address', 'want_ex', 'want_credit', 'want_prem', 'add_by', 'room_bigger', 'room_longer',
			'bundai_hug', 'bank', 'description', 'type_bundai', 'head_bad', 'height_ltd', 'up', 'no_up',
		);
		foreach ($txColumns as $txColumn) {
			$txRow[$txColumn] = (string)($tx[$txColumn] ?? '');
		}
		$txRow['add_date'] = $now;
		cs_job_insert($com1, 'tb_transaction', $txRow);
	}
}

if (!function_exists('cs_job_send_document')) {
	/**
	 * @return array|null null = ไม่มีอะไรต้องทำ (ไม่มีสิทธิ์ / ส่งไปแล้ว / สถานะเอกสารไม่ให้ส่ง),
	 *                    array = ผลการส่ง ['success', 'message', 'job_no']
	 */
	function cs_job_send_document($conn, $refId, array $session, array $spec)
	{
		$refId = trim((string)$refId);
		if ($refId === '' || !cs_job_role_allowed($session, $spec['roles'])) {
			return null;
		}

		$table = $spec['table'];
		$jobColumn = $spec['job_column'];
		$sendColumn = $spec['send_column'] ?? 'send_cs';
		$whereDoc = "`" . $spec['ref_column'] . "` = '" . mysqli_real_escape_string($conn, $refId) . "'";
		$safeRefId = mysqli_real_escape_string($conn, $refId);
		$lockName = '';
		$com1 = null;
		try {
			$doc = mysqli_fetch_assoc(cs_job_query($conn, "SELECT * FROM `" . $table . "` WHERE " . $whereDoc . " LIMIT 1"));
			if (!$doc || (string)$doc[$sendColumn] === '2') {
				return null;
			}
			// Draft ยังไม่ถือว่าส่งงาน ส่วนเอกสารที่ยกเลิก/ไม่อนุมัติแล้วไม่ต้องมีใบงาน
			if (in_array((string)$doc[$spec['status_column'] ?? 'status_doc'], $spec['blocked_status'], true)) {
				return null;
			}

			$regQuery = cs_job_query($conn, "SELECT * FROM tb_register_data WHERE ref_id = '" . $safeRefId . "' ORDER BY (running = '') DESC, ID DESC LIMIT 1");
			$reg = mysqli_fetch_assoc($regQuery);
			if (!$reg) {
				throw new RuntimeException('ไม่พบข้อมูลจัดส่ง (tb_register_data) ของ ' . $refId);
			}
			$txQuery = cs_job_query($conn, "SELECT * FROM tb_transaction WHERE ref_id = '" . $safeRefId . "' ORDER BY (running = '') DESC, id DESC LIMIT 1");
			$tx = mysqli_fetch_assoc($txQuery) ?: array();

			$com1 = cs_job_connect();
			$csRefId = mysqli_real_escape_string($com1, $refId);

			// เลขที่ค้างอยู่ใช้ต่อได้เฉพาะเมื่อใบงานเลขนั้นในฐาน CS เป็นของเอกสารใบนี้จริง
			// (เลขที่ไอคอน Run เดิมออกจากตัวนับผิดฐาน อาจตรงกับใบงานของเอกสารอื่น)
			$oldJobNo = trim((string)($doc[$jobColumn] ?? ''));
			if ($oldJobNo !== '') {
				$ownQuery = cs_job_query($com1, "SELECT ID FROM tb_register_data WHERE running = '" . mysqli_real_escape_string($com1, $oldJobNo) . "' AND ref_id = '" . $csRefId . "' LIMIT 1");
				if (mysqli_fetch_assoc($ownQuery)) {
					cs_job_query($conn, "UPDATE `" . $table . "` SET `" . $sendColumn . "` = '2' WHERE " . $whereDoc);
					return cs_job_result(true, 'เอกสารนี้มีใบงานในระบบ CS อยู่แล้ว เลขที่ลงงาน ' . $oldJobNo, $oldJobNo);
				}
			}

			$yearMonth = cs_job_year_month();
			$lockName = cs_job_acquire_lock($com1, $yearMonth);

			$jobNo = cs_job_next_no($com1, $yearMonth);
			$now = date('Y-m-d H:i:s');
			// ค่าที่บันทึกไว้ในแถวข้อมูลจัดส่งมาก่อน (เอกสารจากหน้าเดิมกรอกครบอยู่แล้ว) ว่างจึงใช้ค่าที่ประกอบจากเอกสาร
			$composed = call_user_func($spec['compose'], $conn, $refId, $doc, $session);
			$pick = function ($column, $default = '') use ($reg, $composed) {
				$value = (string)($reg[$column] ?? '');
				if (trim($value) !== '') {
					return $value;
				}
				return (($composed[$column] ?? '') !== '') ? $composed[$column] : $default;
			};
			$saleCode = (string)($doc[$spec['sale_code_column'] ?? 'sale_code'] ?? '');
			$ivDate = (string)($doc[$spec['iv_date_column'] ?? 'iv_date'] ?? '');

			$jobOverrides = isset($spec['job_overrides']) ? call_user_func($spec['job_overrides'], $doc, $reg) : array();
			cs_job_insert_job($com1, $jobNo, $refId, $pick, $tx, $saleCode, $ivDate, $now, $jobOverrides);
			$docUpdate = array($jobColumn => $jobNo);

			// ใบงานเพิ่มของการส่งครั้งเดียวกัน (เช่นงานรับคืน) ออกเลขต่อกันขณะยังถือ lock เดิม
			$extraJobs = isset($spec['extra_jobs']) ? call_user_func($spec['extra_jobs'], $doc, $reg) : array();
			foreach ($extraJobs as $extraJob) {
				$extraJobNo = cs_job_next_no($com1, $yearMonth);
				cs_job_insert_job($com1, $extraJobNo, $refId, $pick, $tx, $saleCode, $ivDate, $now, $extraJob['overrides'] ?? array());
				$docUpdate[$extraJob['column']] = $extraJobNo;
			}

			$setParts = array();
			foreach ($docUpdate as $column => $value) {
				$setParts[] = "`" . $column . "` = '" . mysqli_real_escape_string($conn, $value) . "'";
			}
			$setParts[] = "`" . $sendColumn . "` = '2'";
			cs_job_query($conn, "UPDATE `" . $table . "` SET " . implode(', ', $setParts) . " WHERE " . $whereDoc);

			return cs_job_result(true, 'ส่งข้อมูลลงระบบ CS แล้ว เลขที่ลงงาน ' . $jobNo, $jobNo);
		} catch (Throwable $e) {
			error_log('[' . $spec['log_tag'] . '] ' . $refId . ': ' . $e->getMessage());
			return cs_job_result(false, 'บันทึกเอกสารแล้ว แต่ส่งข้อมูลลงระบบ CS ไม่สำเร็จ กรุณาลองบันทึกอีกครั้งหรือแจ้งผู้ดูแลระบบ');
		} finally {
			cs_job_release_lock($com1, $lockName);
		}
	}
}

if (!function_exists('cs_job_mark_cancelled')) {
	/**
	 * เอกสารที่ส่ง CS แล้วถูกยกเลิก: ทำเครื่องหมายยกเลิกบนใบงานทุกใบของเอกสาร ไม่ลบใบงาน
	 * พอร์ตจาก register_adminhos_edit1.php:2643
	 *
	 * @return array|null null = ไม่เคยส่ง CS หรือทำเครื่องหมายสำเร็จ, array = ข้อความเตือนเมื่อทำไม่สำเร็จ
	 */
	function cs_job_mark_cancelled($conn, $refId, array $spec, $statusDoc, $reason)
	{
		$refId = trim((string)$refId);
		// ใบงานที่ CS สร้างเองมี ref_id ว่าง ถ้าปล่อย ref_id ว่างลงไปถึง UPDATE จะยกเลิกใบงานพวกนั้นทั้งหมด
		if ($refId === '') {
			return null;
		}

		$sendColumn = $spec['send_column'] ?? 'send_cs';
		try {
			$doc = mysqli_fetch_assoc(cs_job_query($conn, "SELECT `" . $sendColumn . "` FROM `" . $spec['table'] . "` WHERE `" . $spec['ref_column'] . "` = '" . mysqli_real_escape_string($conn, $refId) . "' LIMIT 1"));
			if (!$doc || (string)$doc[$sendColumn] !== '2') {
				return null;
			}

			$com1 = cs_job_connect();
			cs_job_query($com1, "UPDATE tb_register_data SET summary_sup = '" . mysqli_real_escape_string($com1, (string)$statusDoc)
				. "', description_sup = '" . mysqli_real_escape_string($com1, (string)$reason)
				. "', status_comment = '" . mysqli_real_escape_string($com1, (string)$statusDoc)
				. "', employee_send = '', employee_code = '', bus_number = '', code_bus = '' WHERE ref_id = '" . mysqli_real_escape_string($com1, $refId) . "'");
			return null;
		} catch (Throwable $e) {
			error_log('[' . $spec['log_tag'] . '] ' . $refId . ': ' . $e->getMessage());
			return cs_job_result(false, 'ยกเลิกเอกสารแล้ว แต่ทำเครื่องหมายยกเลิกบนใบงานในระบบ CS ไม่สำเร็จ กรุณาแจ้งฝ่าย CS');
		}
	}
}
