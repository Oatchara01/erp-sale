<?php

/**
 * ส่งใบสั่งเช่า (hos__rental) ลงสมุดลงงานของระบบ CS — ใช้กับ toggle "ส่งข้อมูลลงระบบ CS" ใน register_suprental.php
 *
 * ขั้นตอนส่ง (ต่อฐาน CS, lock, ออกเลข, เขียนใบงาน, ทำเครื่องหมายยกเลิก) อยู่ในแกนกลาง includes/cs_job_send.php
 * ไฟล์นี้เหลือเฉพาะส่วนของใบเช่า: ตาราง/คอลัมน์, สิทธิ์, และวิธีประกอบช่องใบงานจากใบเช่า
 *
 * ค่า hos__rental.send_cs: 0 = ยังไม่ส่ง, 2 = ส่งแล้ว (ล็อก) เลขที่ลงงานเก็บใน job_no
 * ส่งงาน "ส่ง" 1 ใบเสมอ งานรับคืน (job_idreturn) ออกโดยหน้าปิดเช่า ไม่เกี่ยวกับ toggle นี้
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

if (!function_exists('rental_cs_compose_job_fields')) {
	/** ช่องใบงานสำรองเมื่อแถวข้อมูลจัดส่งของใบเช่าว่าง (หน้าใบเช่าบันทึกช่องพวกนี้ลง tb_register_data ครบอยู่แล้ว) */
	function rental_cs_compose_job_fields($conn, $refId, array $doc, array $session)
	{
		$productName = trim((string)($doc['des_productunit'] ?? ''));
		return array_merge(array(
			'status'       => 'ส่ง',
			'product_name' => $productName !== '' ? 'ส่ง ' . $productName : '',
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
		$overrides = array();
		// หน้าใบเช่าเก็บชื่อสินค้าในใบงานเป็น "ส่ง <ชื่อสินค้าเช่า>" (create ของเดิมบันทึกได้แค่ "ส่ง " เปล่า) ใช้ค่าจากเอกสารเสมอ
		$productName = trim((string)($doc['des_productunit'] ?? ''));
		if ($productName !== '') {
			$overrides['product_name'] = 'ส่ง ' . $productName;
		}
		return $overrides + array(
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
