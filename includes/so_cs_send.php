<?php

/**
 * ส่งใบสั่งขาย (hos__so) ลงสมุดลงงานของระบบ CS — ใช้กับ toggle "ส่งข้อมูลลงระบบ CS" ใน register_suphos.php
 *
 * สมุดลงงานอยู่คนละฐานกับใบสั่งขาย: ใบงานต้องเขียนผ่าน $com1 (dbconnect_cs.php) ไม่ใช่ $conn
 * tb_register_data ในฐานของ $conn เก็บแค่ข้อมูลจัดส่งของ SO (ผูกด้วย ref_id) ฝ่าย CS ไม่เห็นแถวพวกนั้น
 *
 * พอร์ตจาก register_adminhos_edit1.php (ก่อน commit 9d9350e) และใช้แนวเดียวกับ smp_export_to_cs():
 * อ่านข้อมูลจากแถวที่บันทึกแล้วในฐาน ไม่อ่านจาก POST จึงเรียกได้ทั้งจากการบันทึกปกติและปุ่ม Update แบบจำกัด
 *
 * ค่า hos__so.send_cs: 0 = ยังไม่ส่ง, 2 = ส่งแล้ว (ล็อก) — ค่า 1 ไม่ถูกเก็บลงฐานอีกแล้ว
 */

if (!function_exists('so_cs_role_can_send')) {
	function so_cs_role_can_send(array $session)
	{
		return in_array(strtolower((string)($session['type_login'] ?? '')), array('admin', 'it', 'owner'), true);
	}
}

if (!function_exists('so_cs_send_requested')) {
	function so_cs_send_requested(array $post)
	{
		return (($post['send_cs'] ?? '') === '1');
	}
}

if (!function_exists('so_cs_result')) {
	function so_cs_result($success, $message, $jobNo = '')
	{
		return array('success' => (bool)$success, 'message' => (string)$message, 'job_no' => (string)$jobNo);
	}
}

if (!function_exists('so_cs_json_fields')) {
	// คีย์เสริมใน JSON ของเส้นทาง Save Draft/Update ให้ JS ส่งต่อไปแสดงใน popup หลัง redirect
	function so_cs_json_fields($result)
	{
		if ($result === null) {
			return array();
		}
		return array('cs_sync' => $result['success'] ? '1' : '0', 'cs_sync_msg' => $result['message']);
	}
}

if (!function_exists('so_cs_redirect_query')) {
	function so_cs_redirect_query($result)
	{
		if ($result === null) {
			return '';
		}
		return '&cs_sync=' . ($result['success'] ? '1' : '0') . '&cs_sync_msg=' . rawurlencode($result['message']);
	}
}

if (!function_exists('so_cs_connect')) {
	function so_cs_connect()
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

if (!function_exists('so_cs_query')) {
	function so_cs_query($link, $sql)
	{
		$result = mysqli_query($link, $sql);
		if ($result === false) {
			throw new RuntimeException(mysqli_error($link));
		}
		return $result;
	}
}

if (!function_exists('so_cs_insert')) {
	function so_cs_insert($link, $table, array $row)
	{
		$columns = array();
		$values = array();
		foreach ($row as $column => $value) {
			$columns[] = '`' . $column . '`';
			$values[] = "'" . mysqli_real_escape_string($link, (string)($value ?? '')) . "'";
		}
		so_cs_query($link, "INSERT INTO `" . $table . "` (" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ")");
	}
}

if (!function_exists('so_cs_next_job_no')) {
	/**
	 * เลขที่ลงงานถัดไป: ปี พ.ศ. 2 หลัก + เดือน 2 หลัก + running 4 หลัก จากตัวนับของฐาน CS
	 * ต้องเรียกขณะถือ lock ของเดือนนั้นอยู่ (หน้า legacy ที่ยังออกเลขเองไม่ได้ใช้ lock นี้)
	 */
	function so_cs_next_job_no($com1, $yearMonth)
	{
		$query = so_cs_query($com1, "SELECT MAX(CAST(SUBSTRING(running, 5, 4) AS UNSIGNED)) AS max_run FROM tb_register_data
			WHERE running REGEXP '^[0-9]{8}$' AND LEFT(running, 4) = '" . mysqli_real_escape_string($com1, $yearMonth) . "'");
		$row = mysqli_fetch_assoc($query);
		$runNo = (int)($row['max_run'] ?? 0) + 1;
		if ($runNo > 9999) {
			throw new RuntimeException('เลขที่ลงงานของเดือนนี้เต็มแล้ว (เกิน 9999)');
		}
		return $yearMonth . substr('0000' . $runNo, -4);
	}
}

if (!function_exists('so_cs_compose_job_fields')) {
	/**
	 * ช่องใบงานที่หน้า SO ใหม่ไม่ได้ส่งมาเก็บใน tb_register_data แล้ว (หน้าเดิมมีช่องให้ Sale/Admin กรอก)
	 * ประกอบจากข้อมูลของ SO เองให้ได้หน้าตาแบบใบงานเดิม — ใช้เฉพาะช่องที่แถวข้อมูลจัดส่งว่างอยู่
	 *
	 * @return array คีย์ = คอลัมน์ของใบงาน: status, product_name, product_sn, type_company,
	 *               employee_name, employee_tel, add_code, department, department_show, add_by
	 */
	function so_cs_compose_job_fields($conn, $refId, array $so, array $session)
	{
		$safeRefId = mysqli_real_escape_string($conn, $refId);

		// รายการสินค้า: รูปแบบเดิมคือ "ส่ง <ชื่อ> <หมายเหตุ> <จำนวน> <หน่วย>" บรรทัดละรายการ (ไม่รวมแถวลูกของ BOM)
		$lines = array();
		$itemQuery = so_cs_query($conn, "SELECT s.count, s.sale_remark, p.sol_name, p.unit_name FROM hos__subso s
			LEFT JOIN tb_product p ON s.product_id = p.product_ID
			WHERE s.ref_idd = '" . $safeRefId . "' AND COALESCE(s.bom_ckk, '0') <> '1' ORDER BY s.sort_order, s.id");
		while ($item = mysqli_fetch_assoc($itemQuery)) {
			$name = trim((string)($item['sol_name'] ?? ''));
			if ($name === '') {
				continue;
			}
			$count = rtrim(rtrim(number_format((float)$item['count'], 2, '.', ''), '0'), '.');
			$lines[] = trim(preg_replace('/\s+/u', ' ', $name . ' ' . trim((string)($item['sale_remark'] ?? '')) . ' ' . $count . ' ' . trim((string)($item['unit_name'] ?? ''))));
		}

		// พนักงานขาย: รหัสขาย (hos__so.sale_code) ตรงกับ tb_user.code — รหัสเดียวอาจมีหลายคน จึงให้คนที่ชื่อตรงกับ hos__so.sale มาก่อน
		$saleUser = array();
		$saleCode = trim((string)($so['sale_code'] ?? ''));
		$saleName = trim((string)($so['sale'] ?? ''));
		if ($saleCode !== '' || $saleName !== '') {
			$userQuery = so_cs_query($conn, "SELECT em_id, name, employee_tel, department FROM tb_user
				WHERE (code = '" . mysqli_real_escape_string($conn, $saleCode) . "' AND code <> '') OR (name = '" . mysqli_real_escape_string($conn, $saleName) . "' AND name <> '')
				ORDER BY (code = '" . mysqli_real_escape_string($conn, $saleCode) . "' AND name = '" . mysqli_real_escape_string($conn, $saleName) . "') DESC,
					(code = '" . mysqli_real_escape_string($conn, $saleCode) . "') DESC, id LIMIT 1");
			$saleUser = mysqli_fetch_assoc($userQuery) ?: array();
		}
		$departmentShow = trim((string)($saleUser['department'] ?? ''));
		$departmentMap = array('ฝ่ายขาย' => 'Sale', 'ฝ่ายวิศวกรรม' => 'วิศวกรรม');

		$ivNo = trim((string)($so['iv_no'] ?? ''));

		return array(
			'status'          => 'ส่ง',
			'product_name'    => $lines ? 'ส่ง ' . implode("\r\n", $lines) : '',
			// iv_no ที่ยังไม่ได้ Run เลขจะมีแค่ตัวอักษรนำหน้า (เช่น "IV") ไม่นับเป็นเลขอ้างอิง
			'product_sn'      => preg_match('/\d/', $ivNo) ? $ivNo : '',
			'type_company'    => ((string)($so['type_doc'] ?? '') === '4') ? 'โนเบิล เมด บจก.' : 'ออลล์เวล ไลฟ์ บจก.',
			'employee_name'   => (string)($saleUser['name'] ?? $saleName),
			'employee_tel'    => (string)($saleUser['employee_tel'] ?? ''),
			'add_code'        => (string)($saleUser['em_id'] ?? ''),
			'department'      => $departmentMap[$departmentShow] ?? '',
			'department_show' => $departmentShow,
			'add_by'          => trim((string)($session['name'] ?? '') . ' ' . (string)($session['surname'] ?? '')),
		);
	}
}

if (!function_exists('so_cs_send_sales_order')) {
	/**
	 * @return array|null null = ไม่มีอะไรต้องทำ (ไม่มีสิทธิ์ / ส่งไปแล้ว / สถานะเอกสารไม่ให้ส่ง),
	 *                    array = ผลการส่ง ['success', 'message', 'job_no']
	 */
	function so_cs_send_sales_order($conn, $refId, array $session)
	{
		$refId = trim((string)$refId);
		if ($refId === '' || !so_cs_role_can_send($session)) {
			return null;
		}

		$safeRefId = mysqli_real_escape_string($conn, $refId);
		$lockName = '';
		$com1 = null;
		try {
			$so = mysqli_fetch_assoc(so_cs_query($conn, "SELECT send_cs, job_no, status_doc, sale, sale_code, type_doc, iv_no, iv_date FROM hos__so WHERE ref_id = '" . $safeRefId . "' LIMIT 1"));
			if (!$so || (string)$so['send_cs'] === '2') {
				return null;
			}
			// Draft ยังไม่ถือว่าส่งงาน ส่วนเอกสารที่ยกเลิก/ไม่อนุมัติแล้วไม่ต้องมีใบงาน
			if (in_array((string)$so['status_doc'], array('', 'Draft', 'ยกเลิก', 'Rejected', 'Cancelled'), true)) {
				return null;
			}

			$regQuery = so_cs_query($conn, "SELECT * FROM tb_register_data WHERE ref_id = '" . $safeRefId . "' ORDER BY (running = '') DESC, ID DESC LIMIT 1");
			$reg = mysqli_fetch_assoc($regQuery);
			if (!$reg) {
				throw new RuntimeException('ไม่พบข้อมูลจัดส่ง (tb_register_data) ของ ' . $refId);
			}
			$txQuery = so_cs_query($conn, "SELECT * FROM tb_transaction WHERE ref_id = '" . $safeRefId . "' ORDER BY (running = '') DESC, id DESC LIMIT 1");
			$tx = mysqli_fetch_assoc($txQuery) ?: array();

			$com1 = so_cs_connect();
			$csRefId = mysqli_real_escape_string($com1, $refId);

			// เลขที่ค้างอยู่ใช้ต่อได้เฉพาะเมื่อใบงานเลขนั้นในฐาน CS เป็นของ SO ใบนี้จริง
			// (เลขที่ไอคอน Run เดิมออกจากตัวนับผิดฐาน อาจตรงกับใบงานของเอกสารอื่น)
			$oldJobNo = trim((string)($so['job_no'] ?? ''));
			if ($oldJobNo !== '') {
				$ownQuery = so_cs_query($com1, "SELECT ID FROM tb_register_data WHERE running = '" . mysqli_real_escape_string($com1, $oldJobNo) . "' AND ref_id = '" . $csRefId . "' LIMIT 1");
				if (mysqli_fetch_assoc($ownQuery)) {
					so_cs_query($conn, "UPDATE hos__so SET send_cs = '2' WHERE ref_id = '" . $safeRefId . "'");
					return so_cs_result(true, 'เอกสารนี้มีใบงานในระบบ CS อยู่แล้ว เลขที่ลงงาน ' . $oldJobNo, $oldJobNo);
				}
			}

			$yearMonth = substr((string)((int)date('Y') + 543), -2) . date('m');
			$lockName = 'so_cs_jobrun_' . $yearMonth;
			$lockRow = mysqli_fetch_assoc(so_cs_query($com1, "SELECT GET_LOCK('" . $lockName . "', 5) AS got_lock"));
			if ((int)($lockRow['got_lock'] ?? 0) !== 1) {
				$lockName = '';
				throw new RuntimeException('ระบบกำลังออกเลขที่ลงงานให้ผู้ใช้รายอื่น');
			}

			$jobNo = so_cs_next_job_no($com1, $yearMonth);
			$now = date('Y-m-d H:i:s');
			// ค่าที่บันทึกไว้ในแถวข้อมูลจัดส่งมาก่อน (เอกสารจากหน้าเดิมกรอกครบอยู่แล้ว) ว่างจึงใช้ค่าที่ประกอบจาก SO
			$composed = so_cs_compose_job_fields($conn, $refId, $so, $session);
			$pick = function ($column, $default = '') use ($reg, $composed) {
				$value = (string)($reg[$column] ?? '');
				if (trim($value) !== '') {
					return $value;
				}
				return (($composed[$column] ?? '') !== '') ? $composed[$column] : $default;
			};
			$ivDate = (string)($so['iv_date'] ?? '');

			// การ map ที่อยู่คงตาม register_adminhos_edit1.php เดิม: address_name = ที่อยู่ + จังหวัด, address_send = ชื่อสถานที่ + รายละเอียด
			so_cs_insert($com1, 'tb_register_data', array(
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
				'sale_code'        => (string)($so['sale_code'] ?? ''),
				'bus_inter'        => $pick('bus_inter', '0'),
				'ref_id'           => $refId,
				'iv_date'          => ($ivDate !== '' ? $ivDate : '0000-00-00'),
			));

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
			so_cs_insert($com1, 'tb_transaction', $txRow);

			so_cs_query($conn, "UPDATE hos__so SET job_no = '" . mysqli_real_escape_string($conn, $jobNo) . "', send_cs = '2' WHERE ref_id = '" . $safeRefId . "'");

			return so_cs_result(true, 'ส่งข้อมูลลงระบบ CS แล้ว เลขที่ลงงาน ' . $jobNo, $jobNo);
		} catch (Throwable $e) {
			error_log('[so_cs_send_sales_order] ' . $refId . ': ' . $e->getMessage());
			return so_cs_result(false, 'บันทึกเอกสารแล้ว แต่ส่งข้อมูลลงระบบ CS ไม่สำเร็จ กรุณาลองบันทึกอีกครั้งหรือแจ้งผู้ดูแลระบบ');
		} finally {
			if ($com1 && $lockName !== '') {
				@mysqli_query($com1, "SELECT RELEASE_LOCK('" . $lockName . "')");
			}
		}
	}
}

if (!function_exists('so_cs_mark_cancelled')) {
	/**
	 * SO ที่ส่ง CS แล้วถูกยกเลิก: ทำเครื่องหมายยกเลิกบนใบงาน ไม่ลบใบงาน
	 * พอร์ตจาก register_adminhos_edit1.php:2643
	 *
	 * @return array|null null = ไม่เคยส่ง CS หรือทำเครื่องหมายสำเร็จ, array = ข้อความเตือนเมื่อทำไม่สำเร็จ
	 */
	function so_cs_mark_cancelled($conn, $refId, $statusDoc, $reason)
	{
		$refId = trim((string)$refId);
		// ใบงานที่ CS สร้างเองมี ref_id ว่าง ถ้าปล่อย ref_id ว่างลงไปถึง UPDATE จะยกเลิกใบงานพวกนั้นทั้งหมด
		if ($refId === '') {
			return null;
		}

		try {
			$so = mysqli_fetch_assoc(so_cs_query($conn, "SELECT send_cs FROM hos__so WHERE ref_id = '" . mysqli_real_escape_string($conn, $refId) . "' LIMIT 1"));
			if (!$so || (string)$so['send_cs'] !== '2') {
				return null;
			}

			$com1 = so_cs_connect();
			so_cs_query($com1, "UPDATE tb_register_data SET summary_sup = '" . mysqli_real_escape_string($com1, (string)$statusDoc)
				. "', description_sup = '" . mysqli_real_escape_string($com1, (string)$reason)
				. "', status_comment = '" . mysqli_real_escape_string($com1, (string)$statusDoc)
				. "', employee_send = '', employee_code = '', bus_number = '', code_bus = '' WHERE ref_id = '" . mysqli_real_escape_string($com1, $refId) . "'");
			return null;
		} catch (Throwable $e) {
			error_log('[so_cs_mark_cancelled] ' . $refId . ': ' . $e->getMessage());
			return so_cs_result(false, 'ยกเลิกเอกสารแล้ว แต่ทำเครื่องหมายยกเลิกบนใบงานในระบบ CS ไม่สำเร็จ กรุณาแจ้งฝ่าย CS');
		}
	}
}
