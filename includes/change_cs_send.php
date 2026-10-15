<?php

/**
 * ส่งใบแลกเปลี่ยนสินค้า (hos__change) ลงสมุดลงงานของระบบ CS — ใช้กับ toggle "ส่งข้อมูลลงระบบ CS" ใน register_supchange.php
 *
 * ขั้นตอนส่ง (ต่อฐาน CS, lock, ออกเลข, เขียนใบงาน, ทำเครื่องหมายยกเลิก) อยู่ในแกนกลาง includes/cs_job_send.php
 * ไฟล์นี้เหลือเฉพาะส่วนของใบแลกเปลี่ยน: ตาราง/คอลัมน์, สิทธิ์, วิธีประกอบช่องใบงาน และช่อง "สินค้า/เอกสาร"
 *
 * ค่า hos__change.send_cs: 0 = ยังไม่ส่ง, 2 = ส่งแล้ว (ล็อก) เลขที่ลงงานเก็บใน job_no
 * ส่งงาน "ส่ง" 1 ใบเสมอ (ไม่ออกงานรับแยก) แต่ตั้ง return_ckk = 1 ตามหน้าเดิม (register_adminchange_edit1.php)
 * เพื่อให้ฝ่าย CS ติดตามสินค้าที่ต้องรับกลับจากลูกค้าได้
 */

require_once __DIR__ . '/cs_job_send.php';

if (!function_exists('chg_cs_spec')) {
	function chg_cs_spec()
	{
		return array(
			'table'          => 'hos__change',
			'ref_column'     => 'ref_id',
			'job_column'     => 'job_no',
			// สิทธิ์เห็น/กด toggle คงตามที่หน้าใบแลกเปลี่ยนใช้อยู่เดิม (ไม่ตัด sol เหมือน SO)
			'roles'          => array('it', 'admin', 'sol'),
			// hos__change ใช้ 'ส่งกลับ' เป็นสถานะส่งกลับ (ไม่ใช่ Returned)
			'blocked_status' => array('', 'Draft', 'ส่งกลับ', 'Returned', 'ยกเลิก', 'Rejected', 'Cancelled'),
			'log_tag'        => 'chg_cs_send',
			'compose'        => 'chg_cs_compose_job_fields',
			'job_overrides'  => 'chg_cs_job_overrides',
		);
	}
}

if (!function_exists('chg_cs_format_count')) {
	function chg_cs_format_count($count)
	{
		return rtrim(rtrim(number_format((float)$count, 2, '.', ''), '0'), '.');
	}
}

if (!function_exists('chg_cs_compose_product_name')) {
	/**
	 * ข้อความ "สินค้า/เอกสาร" ของใบงานที่ประกอบจากรายการสินค้า (hos__subchange) แบบเดียวกับ SO:
	 * "ส่ง <ชื่อ> <หมายเหตุ> <จำนวนแลกออก> <หน่วย>" บรรทัดละรายการ
	 * ต่อด้วย "รับกลับ <ชื่อ> <หมายเหตุ> <จำนวนแลกเข้า> <หน่วย>" สำหรับสินค้าที่ต้องรับกลับจากลูกค้า
	 * (คำว่า "รับกลับ" ตามใบงาน EXC เดิมในฐาน CS)
	 */
	function chg_cs_compose_product_name($conn, $refId)
	{
		$sendLines = array();
		$returnLines = array();
		$itemQuery = cs_job_query($conn, "SELECT s.count_sale, s.count_stock, s.sale_remark, p.sol_name, p.unit_name FROM hos__subchange s
			LEFT JOIN tb_product p ON s.product_id = p.product_ID
			WHERE s.ref_idd = '" . mysqli_real_escape_string($conn, (string)$refId) . "' ORDER BY s.id");
		while ($item = mysqli_fetch_assoc($itemQuery)) {
			$name = trim((string)($item['sol_name'] ?? ''));
			if ($name === '') {
				continue;
			}
			$remark = trim((string)($item['sale_remark'] ?? ''));
			$unit = trim((string)($item['unit_name'] ?? ''));
			if ((float)$item['count_sale'] > 0) {
				$sendLines[] = trim(preg_replace('/\s+/u', ' ', $name . ' ' . $remark . ' ' . chg_cs_format_count($item['count_sale']) . ' ' . $unit));
			}
			if ((float)$item['count_stock'] > 0) {
				$returnLines[] = trim(preg_replace('/\s+/u', ' ', $name . ' ' . $remark . ' ' . chg_cs_format_count($item['count_stock']) . ' ' . $unit));
			}
		}

		$parts = array();
		if ($sendLines) {
			$parts[] = 'ส่ง ' . implode("\r\n", $sendLines);
		}
		if ($returnLines) {
			$parts[] = 'รับกลับ ' . implode("\r\n", $returnLines);
		}
		return implode("\r\n", $parts);
	}
}

if (!function_exists('chg_product_note_display')) {
	/**
	 * ค่าในช่อง "สินค้า/เอกสาร" — สตริงสรุปที่ handler สร้างเองตามสูตรเดิม ("ส่ง <รายการ> <ที่อยู่จัดส่ง>" บรรทัดเดียว)
	 * นับเป็นช่องว่าง เพราะหน้าใหม่ไม่ได้ส่งชื่อสินค้ามา สูตรนั้นจึงเหลือแค่ตัวเลขกับที่อยู่ (เช่น "ส่ง 0 5 <ที่อยู่>")
	 * ช่องว่างทำให้ตอนบันทึกประกอบข้อความจากรายการสินค้าแทน
	 */
	function chg_product_note_display($value, array $doc)
	{
		$value = trim((string)$value);
		$address = trim(preg_replace('/\s+/u', ' ', (string)($doc['delivery_name'] ?? '')));
		$isLegacySummary = $value === 'ส่ง'
			|| (strpos($value, 'ส่ง') === 0 && strpos($value, "\n") === false && $address !== ''
				&& substr($value, -strlen($address)) === $address);
		return $isLegacySummary ? '' : $value;
	}
}

if (!function_exists('chg_cs_compose_job_fields')) {
	/** ช่องใบงานสำรองเมื่อแถวข้อมูลจัดส่งของใบแลกเปลี่ยนว่าง (หน้าใบแลกเปลี่ยนบันทึกช่องพวกนี้ลง tb_register_data ครบอยู่แล้ว) */
	function chg_cs_compose_job_fields($conn, $refId, array $doc, array $session)
	{
		return array_merge(array(
			'status'       => 'ส่ง',
			'product_name' => chg_cs_compose_product_name($conn, $refId),
			'type_company' => ((string)($doc['company'] ?? '') === '2') ? 'โนเบิล เมด บจก.' : 'ออลล์เวล ไลฟ์ บจก.',
		), cs_job_compose_sale_fields($conn, $doc['sale_code'] ?? '', $doc['sale'] ?? '', $session));
	}
}

if (!function_exists('chg_cs_job_overrides')) {
	/**
	 * งานของใบแลกเปลี่ยนเป็น "ส่ง" เสมอ, return_ckk = 1 ตามหน้าเดิม
	 * และเลขอ้างอิงของใบงานคือเลขที่เอกสาร EXC… (ฟอร์มไม่ได้ส่ง product_sn มาเก็บในแถวข้อมูลจัดส่ง)
	 * product_name ไม่ override: ใช้ช่อง "สินค้า/เอกสาร" ที่ chg_save_product_note() เขียนไว้ ว่างจึงใช้ค่าที่ compose
	 */
	function chg_cs_job_overrides(array $doc, array $reg)
	{
		$overrides = array('status' => 'ส่ง', 'return_ckk' => '1');
		$docNo = trim((string)($doc['iv_no'] ?? ''));
		if ($docNo !== '') {
			$overrides['product_sn'] = $docNo;
		}
		return $overrides;
	}
}

if (!function_exists('chg_cs_load_document')) {
	function chg_cs_load_document($conn, $refId)
	{
		$refId = trim((string)$refId);
		if ($refId === '') {
			return null;
		}
		$query = mysqli_query($conn, "SELECT * FROM hos__change WHERE ref_id = '" . mysqli_real_escape_string($conn, $refId) . "' LIMIT 1");
		$doc = $query ? mysqli_fetch_assoc($query) : null;
		return $doc ?: null;
	}
}

if (!function_exists('chg_cs_user_can_send')) {
	/**
	 * ผู้ใช้ส่งใบนี้ลง CS ได้ตอนนี้หรือไม่ — ใช้ตรวจที่ server
	 * ยังไม่ Approve: it / admin / sol, Approve แล้ว: Admin เท่านั้น (ผ่านปุ่ม Update แบบจำกัด), สถานะอื่นและใบที่ส่งแล้ว: ไม่ได้
	 */
	function chg_cs_user_can_send(array $doc, array $session)
	{
		$spec = chg_cs_spec();
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

if (!function_exists('chg_cs_can_tick')) {
	/**
	 * toggle ในฟอร์มกดติ๊กได้หรือไม่ ($doc = null คือเอกสารใหม่ที่ยังไม่บันทึก)
	 * ต่างจาก chg_cs_user_can_send(): Draft / ส่งกลับ ติ๊กได้ เพราะส่งจริงตอน Submit (Save Draft แกนกลางข้ามให้เอง)
	 */
	function chg_cs_can_tick($doc, array $session)
	{
		$spec = chg_cs_spec();
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

if (!function_exists('chg_cs_send')) {
	/**
	 * @return array|null null = ไม่มีอะไรต้องทำ (ไม่มีสิทธิ์ / ส่งไปแล้ว / สถานะเอกสารไม่ให้ส่ง),
	 *                    array = ผลการส่ง ['success', 'message', 'job_no']
	 */
	function chg_cs_send($conn, $refId, array $session)
	{
		$doc = chg_cs_load_document($conn, $refId);
		if ($doc === null || !chg_cs_user_can_send($doc, $session)) {
			return null;
		}
		// แถวข้อมูลจัดส่งที่ยังเก็บสตริงสรุปตามสูตรเดิม (เอกสารเก่า / ปุ่ม Update แบบจำกัดที่ไม่ได้บันทึกช่องสินค้า/เอกสาร)
		// แปลงเป็นข้อความ "ส่ง ..." ก่อน ไม่งั้นแกนกลางจะยกสตริงนั้นไปใส่ใบงาน
		try {
			$regQuery = cs_job_query($conn, "SELECT product_name FROM tb_register_data WHERE ref_id = '" . mysqli_real_escape_string($conn, (string)$doc['ref_id']) . "' LIMIT 1");
			$reg = mysqli_fetch_assoc($regQuery);
			if ($reg && trim((string)$reg['product_name']) !== '' && chg_product_note_display($reg['product_name'], $doc) === '') {
				chg_save_product_note($conn, $doc['ref_id'], '');
			}
		} catch (Throwable $e) {
			error_log('chg_cs_send product note ' . $doc['ref_id'] . ': ' . $e->getMessage());
		}
		return cs_job_send_document($conn, $doc['ref_id'], $session, chg_cs_spec());
	}
}

if (!function_exists('chg_cs_mark_cancelled')) {
	/**
	 * ใบแลกเปลี่ยนที่ส่ง CS แล้วถูกยกเลิก/ไม่อนุมัติ: ทำเครื่องหมายบนใบงาน ไม่ลบใบงาน
	 *
	 * @return array|null null = ไม่เคยส่ง CS หรือทำเครื่องหมายสำเร็จ, array = ข้อความเตือนเมื่อทำไม่สำเร็จ
	 */
	function chg_cs_mark_cancelled($conn, $refId, $statusDoc, $reason)
	{
		return cs_job_mark_cancelled($conn, $refId, chg_cs_spec(), $statusDoc, $reason);
	}
}

if (!function_exists('chg_save_product_note')) {
	/**
	 * ช่อง "สินค้า/เอกสาร" (name="product") ของ register_supchange.php -> tb_register_data.product_name
	 * ว่างไว้ = chg_cs_compose_product_name(); ถ้าส่ง CS แล้ว (send_cs=2) อัปเดตใบงานในฐาน CS ด้วย
	 * เรียกหลังบันทึกแถวข้อมูลจัดส่ง (หลัง mysqli_commit) และก่อน chg_cs_send() เพื่อให้ใบงานที่ส่งในรอบเดียวกันได้ค่านี้
	 * หน้าเก่าที่ post มา handler เดียวกัน (register_supchangenb.php) ไม่มี flag product_note_form จึงไม่เข้าฟังก์ชันนี้
	 * อัปเดตฐาน CS ไม่สำเร็จไม่ทำให้การบันทึกเอกสารเสีย แค่เขียน error_log
	 */
	function chg_save_product_note($conn, $refId, $postedText, $autoText = '')
	{
		$doc = chg_cs_load_document($conn, $refId);
		if ($doc === null) {
			return;
		}
		$refId = (string)$doc['ref_id'];

		// ช่องยังเป็นข้อความอัตโนมัติที่หน้าฟอร์มแสดงตอนโหลด (hidden product_note_auto) = ผู้ใช้ไม่ได้แก้ -> ประกอบใหม่
		if (cs_job_note_untouched($postedText, $autoText)) {
			$postedText = '';
		}

		try {
			$text = chg_product_note_display($postedText, $doc);
			if ($text === '') {
				$text = chg_cs_compose_product_name($conn, $refId);
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

			$com1 = cs_job_connect();
			$csStmt = mysqli_prepare($com1, "UPDATE tb_register_data SET product_name = ? WHERE running = ? AND ref_id = ?");
			if (!$csStmt) {
				throw new RuntimeException(mysqli_error($com1));
			}
			mysqli_stmt_bind_param($csStmt, 'sss', $text, $jobNo, $refId);
			mysqli_stmt_execute($csStmt);
			mysqli_stmt_close($csStmt);
		} catch (Throwable $e) {
			error_log('chg_save_product_note ' . $refId . ': ' . $e->getMessage());
		}
	}
}
