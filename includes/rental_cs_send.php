<?php

/**
 * ส่งใบสั่งเช่า (hos__rental) ลงสมุดลงงานของระบบ CS — ใช้กับ toggle "ส่งข้อมูลลงระบบ CS" ใน register_suprental.php
 *
 * ขั้นตอนส่ง (ต่อฐาน CS, lock, ออกเลข, เขียนใบงาน, ทำเครื่องหมายยกเลิก) อยู่ในแกนกลาง includes/cs_job_send.php
 * ไฟล์นี้เหลือเฉพาะส่วนของใบเช่า: ตาราง/คอลัมน์, สิทธิ์, และวิธีประกอบช่องใบงานจากใบเช่า
 *
 * ค่า hos__rental.send_cs: 0 = ยังไม่ส่ง, 2 = ส่งแล้ว (ล็อก) เลขที่ลงงานเก็บใน job_no
 * ส่งงาน "ส่ง" 1 ใบเสมอ งานรับคืน (job_idreturn, send_callcs) ออกตอนปิดเช่าผ่าน rental_cs_send_return() ไม่เกี่ยวกับ toggle นี้
 */

require_once __DIR__ . '/cs_job_send.php';

if (!function_exists('rental_cs_spec')) {
	function rental_cs_spec()
	{
		return array(
			'table'          => 'hos__rental',
			'ref_column'     => 'ref_id',
			'job_column'     => 'job_no',
			// สิทธิ์เห็น/กด toggle คงตามที่หน้าใบเช่าใช้อยู่เดิม (ไม่ตัด sol เหมือน SO)
			'roles'          => array('it', 'admin', 'sol'),
			'blocked_status' => array('', 'Draft', 'ส่งกลับ', 'ยกเลิก', 'Rejected', 'Cancelled'),
			'log_tag'        => 'rental_cs_send',
			'compose'        => 'rental_cs_compose_job_fields',
			'job_overrides'  => 'rental_cs_job_overrides',
		);
	}
}

if (!function_exists('rental_cs_compose_product_name')) {
	/**
	 * ข้อความ "สินค้า/เอกสาร" ของใบงานที่ประกอบจากตารางรายการสินค้า (hos__subrental) แบบเดียวกับ SO:
	 * "ส่ง <ชื่อ> <หมายเหตุ> <จำนวน> <หน่วย>" บรรทัดละรายการ
	 * ตารางไม่มีแถว (เช่น Save Draft ก่อนเลือกสินค้า) ถอยไปใช้ "ส่ง <ทรัพย์ที่เช่า>" (hos__rental.des_productunit) ตามสูตรเดิม
	 * ว่างทั้งคู่ = '' (ไม่เก็บ "ส่ง " ล้วน)
	 */
	function rental_cs_compose_product_name($conn, array $doc)
	{
		$lines = array();
		$itemQuery = cs_job_query($conn, "SELECT s.count, s.remark_sale, p.sol_name, p.unit_name FROM hos__subrental s
			LEFT JOIN tb_product p ON s.product_id = p.product_ID
			WHERE s.ref_idd = '" . mysqli_real_escape_string($conn, (string)($doc['ref_id'] ?? '')) . "' ORDER BY s.id_sub");
		while ($item = mysqli_fetch_assoc($itemQuery)) {
			$name = trim((string)($item['sol_name'] ?? ''));
			if ($name === '') {
				continue;
			}
			$count = rtrim(rtrim(number_format((float)$item['count'], 2, '.', ''), '0'), '.');
			$lines[] = trim(preg_replace('/\s+/u', ' ', $name . ' ' . trim((string)($item['remark_sale'] ?? '')) . ' ' . $count . ' ' . trim((string)($item['unit_name'] ?? ''))));
		}
		if ($lines) {
			return 'ส่ง ' . implode("\r\n", $lines);
		}
		$productName = trim((string)($doc['des_productunit'] ?? ''));
		return $productName !== '' ? 'ส่ง ' . $productName : '';
	}
}

if (!function_exists('rental_product_note_display')) {
	/**
	 * ค่าในช่อง "สินค้า/เอกสาร" — ข้อความที่ระบบสร้างเองนับเป็นช่องว่าง เพื่อไม่ให้บัง placeholder
	 * และให้ตอนบันทึกประกอบใหม่จากตารางรายการสินค้าล่าสุด (แก้รายการแล้วข้อความไม่ค้างของเดิม):
	 * - "ส่ง" ล้วน และ "ส่ง <des_productunit>" (สูตรเดิมของ register_suprental_edit1.php)
	 * - "ส่ง <รายการ 1-7> <ที่อยู่จัดส่ง>" บรรทัดเดียวที่ลงท้ายด้วย tb_register_data.address_name (สูตรเดิมของ register_suprental1.php)
	 * - ข้อความที่ rental_cs_compose_product_name() สร้างจากรายการที่บันทึกไว้ตอนนี้
	 * ตรวจเฉพาะที่ตรงสูตร ค่าที่ผู้ใช้พิมพ์เองแสดงตามเดิม
	 */
	function rental_product_note_display($value, $conn, array $doc)
	{
		$value = trim(str_replace("\r\n", "\n", (string)$value));
		if ($value === '' || $value === 'ส่ง') {
			return '';
		}
		$flat = preg_replace('/\s+/u', ' ', $value);
		$desProduct = trim(preg_replace('/\s+/u', ' ', (string)($doc['des_productunit'] ?? '')));
		if ($desProduct !== '' && $flat === 'ส่ง ' . $desProduct) {
			return '';
		}

		$refId = (string)($doc['ref_id'] ?? '');
		$regQuery = cs_job_query($conn, "SELECT address_name FROM tb_register_data WHERE ref_id = '" . mysqli_real_escape_string($conn, $refId) . "' ORDER BY (running = '') DESC, ID DESC LIMIT 1");
		$reg = mysqli_fetch_assoc($regQuery);
		$address = trim(preg_replace('/\s+/u', ' ', (string)($reg['address_name'] ?? '')));
		if ($address !== '' && strpos($value, "\n") === false && strpos($value, 'ส่ง') === 0
			&& substr($flat, -strlen($address)) === $address) {
			return '';
		}

		$composed = str_replace("\r\n", "\n", rental_cs_compose_product_name($conn, $doc));
		return ($composed !== '' && $value === $composed) ? '' : $value;
	}
}

if (!function_exists('rental_cs_normalize_product_note')) {
	/**
	 * แถวข้อมูลจัดส่งที่เก็บข้อความอัตโนมัติ/ว่าง (เอกสารก่อนประกอบจากตารางสินค้า) เขียนข้อความจากตารางลงฐานขายก่อนส่ง CS
	 * ไม่งั้นแกนกลางยก "ส่ง " หรือสตริงสูตรเดิมไปใส่ใบงาน — ใช้กับปุ่ม Update แบบจำกัด (register_suprental_cs1.php)
	 * เส้นทางบันทึกฟอร์มเขียนค่านี้ผ่าน rental_save_product_note() มาก่อนแล้วจึงไม่มีอะไรเปลี่ยน
	 */
	function rental_cs_normalize_product_note($conn, array $doc)
	{
		try {
			$refId = (string)$doc['ref_id'];
			$regQuery = cs_job_query($conn, "SELECT product_name FROM tb_register_data WHERE ref_id = '" . mysqli_real_escape_string($conn, $refId) . "' ORDER BY (running = '') DESC, ID DESC LIMIT 1");
			$reg = mysqli_fetch_assoc($regQuery);
			if (!$reg || rental_product_note_display($reg['product_name'], $conn, $doc) !== '') {
				return;
			}
			$text = rental_cs_compose_product_name($conn, $doc);
			if ($text === (string)$reg['product_name']) {
				return;
			}
			$stmt = mysqli_prepare($conn, "UPDATE tb_register_data SET product_name = ? WHERE ref_id = ?");
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, 'ss', $text, $refId);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
		} catch (Throwable $e) {
			error_log('rental_cs_normalize_product_note ' . ($doc['ref_id'] ?? '') . ': ' . $e->getMessage());
		}
	}
}

if (!function_exists('rental_save_product_note')) {
	/**
	 * ช่อง "สินค้า/เอกสาร" (name="product") ของ register_suprental.php -> tb_register_data.product_name
	 * ว่างไว้ / ข้อความอัตโนมัติ = rental_cs_compose_product_name() (ตารางรายการสินค้า); ถ้าส่ง CS แล้ว (send_cs=2) อัปเดตใบงานงาน "ส่ง" (job_no) ในฐาน CS ด้วย
	 * เรียกหลังบันทึกแถวข้อมูลจัดส่ง และก่อน rental_cs_send() เพื่อให้ใบงานที่ส่งในรอบเดียวกันได้ค่านี้
	 * หน้าเก่าที่ post มา handler เดียวกันไม่มี flag product_note_form จึงไม่เข้าฟังก์ชันนี้
	 * อัปเดตฐาน CS ไม่สำเร็จไม่ทำให้การบันทึกใบเช่าเสีย แค่เขียน error_log
	 */
	function rental_save_product_note($conn, $refId, $postedText, $autoText = '')
	{
		$doc = rental_cs_load_document($conn, $refId);
		if ($doc === null) {
			return;
		}
		$refId = (string)$doc['ref_id'];

		// ช่องยังเป็นข้อความอัตโนมัติที่หน้าฟอร์มแสดงตอนโหลด (hidden product_note_auto) = ผู้ใช้ไม่ได้แก้ -> ประกอบใหม่
		if (cs_job_note_untouched($postedText, $autoText)) {
			$postedText = '';
		}

		try {
			$text = rental_product_note_display($postedText, $conn, $doc);
			if ($text === '') {
				$text = rental_cs_compose_product_name($conn, $doc);
			}
		} catch (Throwable $e) {
			// ประกอบข้อความไม่ได้: คงค่าที่ผู้ใช้ส่งมา ไม่ทำให้การบันทึกใบเช่าเสีย
			error_log('rental_save_product_note compose ' . $refId . ': ' . $e->getMessage());
			$text = trim((string)$postedText);
		}

		$stmt = mysqli_prepare($conn, "UPDATE tb_register_data SET product_name = ? WHERE ref_id = ?");
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, 'ss', $text, $refId);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}

		$jobNo = trim((string)($doc['job_no'] ?? ''));
		if ($jobNo === '' || (string)($doc['send_cs'] ?? '') !== '2') {
			return;
		}

		try {
			$com1 = cs_job_connect();
			$csStmt = mysqli_prepare($com1, "UPDATE tb_register_data SET product_name = ? WHERE running = ? AND ref_id = ?");
			if (!$csStmt) {
				throw new RuntimeException(mysqli_error($com1));
			}
			mysqli_stmt_bind_param($csStmt, 'sss', $text, $jobNo, $refId);
			mysqli_stmt_execute($csStmt);
			mysqli_stmt_close($csStmt);
		} catch (Throwable $e) {
			error_log('rental_save_product_note ' . $refId . ': ' . $e->getMessage());
		}
	}
}

if (!function_exists('rental_cs_compose_job_fields')) {
	/** ช่องใบงานสำรองเมื่อแถวข้อมูลจัดส่งของใบเช่าว่าง (หน้าใบเช่าบันทึกช่องพวกนี้ลง tb_register_data ครบอยู่แล้ว) */
	function rental_cs_compose_job_fields($conn, $refId, array $doc, array $session)
	{
		return array_merge(array(
			'status'       => 'ส่ง',
			'product_name' => rental_cs_compose_product_name($conn, $doc),
			'type_company' => ((string)($doc['type_doc'] ?? '') === '4') ? 'โนเบิล เมด บจก.' : 'ออลล์เวล ไลฟ์ บจก.',
		), cs_job_compose_sale_fields($conn, $doc['sale_code'] ?? '', '', $session));
	}
}

if (!function_exists('rental_cs_job_overrides')) {
	/**
	 * งานของใบเช่าเป็น "ส่ง" เสมอ และเลขอ้างอิงใช้รูปแบบเดิม "เลขที่เอกสาร JN… เลขที่สัญญา ธส.…"
	 * อ่านเลขจากเอกสารตอนส่ง เพราะแถวข้อมูลจัดส่งที่บันทึกซ้ำตอนแก้ไขเก็บแต่เลขที่เอกสาร ไม่มีเลขที่สัญญา
	 */
	function rental_cs_job_overrides(array $doc, array $reg)
	{
		$docNo = trim((string)($doc['iv_no'] ?? ''));
		$promisNo = trim((string)($doc['promis_no'] ?? ''));
		// product_name ไม่ override แล้ว: ใช้ค่าในแถวข้อมูลจัดส่ง (ช่อง "สินค้า/เอกสาร" ที่ rental_save_product_note() เขียนไว้)
		// ว่างจึงใช้ rental_cs_compose_product_name() ผ่าน compose
		return array(
			'status'     => 'ส่ง',
			'product_sn' => 'เลขที่เอกสาร ' . ($docNo !== '' ? $docNo : '-') . ' เลขที่สัญญา ' . ($promisNo !== '' ? $promisNo : '-'),
		);
	}
}

if (!function_exists('rental_cs_load_document')) {
	function rental_cs_load_document($conn, $refId)
	{
		$refId = trim((string)$refId);
		if ($refId === '') {
			return null;
		}
		$query = mysqli_query($conn, "SELECT * FROM hos__rental WHERE ref_id = '" . mysqli_real_escape_string($conn, $refId) . "' LIMIT 1");
		$doc = $query ? mysqli_fetch_assoc($query) : null;
		return $doc ?: null;
	}
}

if (!function_exists('rental_cs_user_can_send')) {
	/**
	 * ผู้ใช้ส่งใบนี้ลง CS ได้ตอนนี้หรือไม่ — ใช้ทั้งแสดง toggle/ปุ่มในหน้า และตรวจซ้ำที่ server
	 * ยังไม่ Approve: it / admin / sol, Approve แล้ว: Admin เท่านั้น (ผ่านปุ่ม Update แบบจำกัด), สถานะอื่นและใบที่ส่งแล้ว: ไม่ได้
	 */
	function rental_cs_user_can_send(array $doc, array $session)
	{
		$spec = rental_cs_spec();
		if ((string)($doc['send_cs'] ?? '') === '2' || !cs_job_role_allowed($session, $spec['roles'])) {
			return false;
		}
		$status = (string)($doc['status_doc'] ?? '');
		if ($status === 'Approve') {
			return cs_job_role_allowed($session, array('admin'));
		}
		return !in_array($status, $spec['blocked_status'], true);
	}
}

if (!function_exists('rental_cs_can_tick')) {
	/**
	 * toggle ในฟอร์มกดติ๊กได้หรือไม่ ($doc = null คือเอกสารใหม่ที่ยังไม่บันทึก)
	 * ต่างจาก rental_cs_user_can_send(): Draft / ส่งกลับ ติ๊กได้ เพราะส่งจริงตอน Submit (Save Draft แกนกลางข้ามให้เอง)
	 */
	function rental_cs_can_tick($doc, array $session)
	{
		$spec = rental_cs_spec();
		if (!cs_job_role_allowed($session, $spec['roles'])) {
			return false;
		}
		if ($doc === null) {
			return true;
		}
		if ((string)($doc['send_cs'] ?? '') === '2') {
			return false;
		}
		$status = (string)($doc['status_doc'] ?? '');
		if (in_array($status, array('ยกเลิก', 'Rejected', 'Cancelled'), true)) {
			return false;
		}
		return $status !== 'Approve' || cs_job_role_allowed($session, array('admin'));
	}
}

if (!function_exists('rental_cs_send')) {
	/**
	 * @return array|null null = ไม่มีอะไรต้องทำ (ไม่มีสิทธิ์ / ส่งไปแล้ว / สถานะเอกสารไม่ให้ส่ง),
	 *                    array = ผลการส่ง ['success', 'message', 'job_no']
	 */
	function rental_cs_send($conn, $refId, array $session)
	{
		$doc = rental_cs_load_document($conn, $refId);
		if ($doc === null || !rental_cs_user_can_send($doc, $session)) {
			return null;
		}
		rental_cs_normalize_product_note($conn, $doc);
		return cs_job_send_document($conn, $doc['ref_id'], $session, rental_cs_spec());
	}
}

if (!function_exists('rental_cs_mark_cancelled')) {
	/**
	 * ใบเช่าที่ส่ง CS แล้วถูกยกเลิก/ไม่อนุมัติ: ทำเครื่องหมายบนใบงาน ไม่ลบใบงาน
	 *
	 * @return array|null null = ไม่เคยส่ง CS หรือทำเครื่องหมายสำเร็จ, array = ข้อความเตือนเมื่อทำไม่สำเร็จ
	 */
	function rental_cs_mark_cancelled($conn, $refId, $statusDoc, $reason)
	{
		return cs_job_mark_cancelled($conn, $refId, rental_cs_spec(), $statusDoc, $reason);
	}
}

if (!function_exists('rental_cs_send_return')) {
	/**
	 * งาน "รับ" (รับคืนเครื่องเช่า) ตอนปิดเช่า — เรียกจาก close_rental1.php และ close_suprental1.php
	 * ออกเลขผ่าน lock/ตัวนับเดียวกับเอกสารอื่น เลขเก็บใน hos__rental.job_idreturn และตั้ง send_callcs = 2
	 *
	 * ต่างจาก rental_cs_send(): ช่องใบงานมาจากฟอร์มปิดเช่า ($fields) ไม่ใช่แถวข้อมูลจัดส่งในฐาน
	 * เพราะวันเวลา/ที่อยู่รับคืนกรอกตอนปิดเช่าและไม่ได้เก็บที่อื่น สิทธิ์คงตามหน้าปิดเช่า (ใครเปิดหน้าได้ก็ส่งได้)
	 *
	 * @param array $fields คอลัมน์ tb_register_data => ค่าจากฟอร์มปิดเช่า
	 * @return array|null null = ส่งงานรับคืนไปแล้ว ไม่ทำซ้ำ, array = ผลการส่ง ['success', 'message', 'job_no']
	 */
	function rental_cs_send_return($conn, $refId, array $session, array $fields)
	{
		$refId = trim((string)$refId);
		$lockName = '';
		$com1 = null;
		try {
			$doc = rental_cs_load_document($conn, $refId);
			if ($doc === null) {
				throw new RuntimeException('ไม่พบใบเช่า ' . $refId);
			}
			if (trim((string)($doc['job_idreturn'] ?? '')) !== '') {
				return null;
			}

			$com1 = cs_job_connect();
			$yearMonth = cs_job_year_month();
			$lockName = cs_job_acquire_lock($com1, $yearMonth);
			$jobNo = cs_job_next_no($com1, $yearMonth);

			$desProduct = trim((string)($doc['des_productunit'] ?? ''));
			$composed = array_merge(
				cs_job_compose_sale_fields($conn, $doc['sale_code'] ?? '', '', $session),
				array(
					'product_name' => $desProduct !== '' ? 'รับคืน ' . $desProduct : '',
					'type_company' => ((string)($doc['type_doc'] ?? '') === '4') ? 'โนเบิล เมด บจก.' : 'ออลล์เวล ไลฟ์ บจก.',
				)
			);
			$pick = function ($column, $default = '') use ($fields, $composed) {
				$value = (string)($fields[$column] ?? '');
				if (trim($value) !== '') {
					return $value;
				}
				return (($composed[$column] ?? '') !== '') ? $composed[$column] : $default;
			};
			$docNo = trim((string)($doc['iv_no'] ?? ''));
			$promisNo = trim((string)($doc['promis_no'] ?? ''));
			$overrides = array(
				'status'       => 'รับ',
				'return_ckk'   => '1',
				'product_sn'   => 'เลขที่เอกสาร ' . ($docNo !== '' ? $docNo : '-') . ' เลขที่สัญญา ' . ($promisNo !== '' ? $promisNo : '-'),
				// ที่อยู่คงตามที่หน้าปิดเช่าเดิมเขียนลงใบงาน (ค่าจากฟอร์มตรงๆ ไม่ใช้สูตรต่อจังหวัดของแกนกลาง)
				'address_name' => (string)($fields['address_name'] ?? ''),
				'address_send' => (string)($fields['address_send'] ?? ''),
			);
			cs_job_insert_job($com1, $jobNo, $refId, $pick, array(), $doc['sale_code'] ?? '', $doc['iv_date'] ?? '', date('Y-m-d H:i:s'), $overrides);

			cs_job_query($conn, "UPDATE hos__rental SET job_idreturn = '" . mysqli_real_escape_string($conn, $jobNo) . "', send_callcs = '2'
				WHERE ref_id = '" . mysqli_real_escape_string($conn, $refId) . "'");

			return cs_job_result(true, 'ส่งงานรับคืนลงระบบ CS แล้ว เลขที่ลงงาน ' . $jobNo, $jobNo);
		} catch (Throwable $e) {
			error_log('[rental_cs_send_return] ' . $refId . ': ' . $e->getMessage());
			return cs_job_result(false, 'ปิดการเช่าแล้ว แต่ส่งงานรับคืนลงระบบ CS ไม่สำเร็จ กรุณาแจ้งผู้ดูแลระบบ');
		} finally {
			cs_job_release_lock($com1, $lockName);
		}
	}
}

if (!function_exists('rental_cs_close_alert')) {
	/**
	 * หน้าผลการบันทึกปิดเช่า: SweetAlert2 แสดงเลขงานรับคืน/คำเตือน แล้วกลับหน้ารายการ
	 * หน้าปิดเช่า include head.php ไปแล้ว จึงพิมพ์ script ต่อท้ายได้เลย
	 */
	function rental_cs_close_alert($csResult, $backUrl)
	{
		$flags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE;
		$options = array(
			'icon'  => ($csResult === null || $csResult['success']) ? 'success' : 'warning',
			'title' => 'บันทึกข้อมูลของท่านเรียบร้อยแล้ว',
			'text'  => ($csResult === null) ? '' : $csResult['message'],
		);
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
		echo '<script>Swal.fire(' . json_encode($options, $flags) . ').then(function () { window.location = '
			. json_encode((string)$backUrl, $flags) . '; });</script>';
	}
}

if (!function_exists('rental_cs_flash')) {
	/** popup หลังบันทึกเมื่อมีผลการส่ง CS — หน้าตาเดียวกับ SO/SMP */
	function rental_cs_flash(array $csResult)
	{
		return array(
			'icon'  => $csResult['success'] ? 'success' : 'warning',
			'title' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
			'text'  => $csResult['message'],
		);
	}
}
