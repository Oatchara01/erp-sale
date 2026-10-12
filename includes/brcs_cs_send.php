<?php

/**
 * ส่งใบยืมฝากขาย BRCS (hos__consig) ลงสมุดลงงานของระบบ CS — ใช้กับ toggle "ส่งข้อมูลลงระบบ CS" ใน register_supbrcshos.php
 *
 * ขั้นตอนส่ง (ต่อฐาน CS, lock, ออกเลข, เขียนใบงาน, ทำเครื่องหมายยกเลิก) อยู่ในแกนกลาง includes/cs_job_send.php
 * ไฟล์นี้เหลือเฉพาะส่วนของ BRCS: ตาราง/คอลัมน์, สิทธิ์, และวิธีประกอบช่องใบงานจาก BRCS
 *
 * ค่า hos__consig.send_cs: 0 = ยังไม่ส่ง, 2 = ส่งแล้ว (ล็อก) เลขที่ลงงานเก็บใน job_no (คอลัมน์เดิมของตาราง
 * ไม่ใช่ job_no1 ที่หน้า Redesign เคยเขียน) ส่งงาน "ส่ง" 1 ใบเสมอ ไม่ออกงานรับคืน
 */

require_once __DIR__ . '/cs_job_send.php';

if (!function_exists('brcs_cs_spec')) {
	function brcs_cs_spec()
	{
		return array(
			'table'          => 'hos__consig',
			'ref_column'     => 'ref_id',
			'job_column'     => 'job_no',
			// สิทธิ์เห็น/กด toggle คงตามที่หน้า BRCS ใช้อยู่เดิม (it, admin เท่านั้น ไม่มี sol)
			'roles'          => array('it', 'admin'),
			'blocked_status' => array('', 'Draft', 'Returned', 'ยกเลิก', 'Rejected', 'Cancelled'),
			'log_tag'        => 'brcs_cs_send',
			'compose'        => 'brcs_cs_compose_job_fields',
			'job_overrides'  => 'brcs_cs_job_overrides',
		);
	}
}

if (!function_exists('brcs_cs_compose_job_fields')) {
	/**
	 * ช่องใบงานสำรองเมื่อแถวข้อมูลจัดส่งของ BRCS ว่าง (หน้า BRCS บันทึกช่องพวกนี้ลง tb_register_data ครบอยู่แล้ว
	 * ยกเว้นรายการสินค้าที่ว่างได้ถ้าแถวสินค้าไม่มีชื่อ)
	 */
	function brcs_cs_compose_job_fields($conn, $refId, array $doc, array $session)
	{
		$lines = array();
		$itemQuery = cs_job_query($conn, "SELECT s.count, s.sale_remark, p.sol_name, p.unit_name FROM hos__subconsig s
			LEFT JOIN tb_product p ON s.product_id = p.product_ID
			WHERE s.ref_idd = '" . mysqli_real_escape_string($conn, $refId) . "' ORDER BY s.id");
		while ($item = mysqli_fetch_assoc($itemQuery)) {
			$name = trim((string)($item['sol_name'] ?? ''));
			if ($name === '') {
				continue;
			}
			$count = rtrim(rtrim(number_format((float)$item['count'], 2, '.', ''), '0'), '.');
			$lines[] = trim(preg_replace('/\s+/u', ' ', $name . ' ' . trim((string)($item['sale_remark'] ?? '')) . ' ' . $count . ' ' . trim((string)($item['unit_name'] ?? ''))));
		}

		return array_merge(array(
			'status'       => 'ส่ง',
			'product_name' => $lines ? 'ส่ง ' . implode("\r\n", $lines) : '',
			'type_company' => ((string)($doc['company'] ?? '') === '2') ? 'โนเบิล เมด บจก.' : 'ออลล์เวล ไลฟ์ บจก.',
		), cs_job_compose_sale_fields($conn, $doc['sale_code'] ?? '', $doc['sale'] ?? '', $session));
	}
}

if (!function_exists('brcs_cs_job_overrides')) {
	/** งานของ BRCS เป็น "ส่ง" เสมอ และเลขอ้างอิงของใบงานคือเลขที่เอกสาร BRSC… (ฟอร์มไม่ได้ส่ง product_sn มาเก็บในแถวข้อมูลจัดส่ง) */
	function brcs_cs_job_overrides(array $doc, array $reg)
	{
		$overrides = array('status' => 'ส่ง');
		$docNo = trim((string)($doc['iv_no'] ?? ''));
		if ($docNo !== '') {
			$overrides['product_sn'] = $docNo;
		}
		return $overrides;
	}
}

if (!function_exists('brcs_cs_load_document')) {
	function brcs_cs_load_document($conn, $refId)
	{
		$refId = trim((string)$refId);
		if ($refId === '') {
			return null;
		}
		$query = mysqli_query($conn, "SELECT * FROM hos__consig WHERE ref_id = '" . mysqli_real_escape_string($conn, $refId) . "' LIMIT 1");
		$doc = $query ? mysqli_fetch_assoc($query) : null;
		return $doc ?: null;
	}
}

if (!function_exists('brcs_cs_user_can_send')) {
	/**
	 * ผู้ใช้ส่งใบนี้ลง CS ได้ตอนนี้หรือไม่ — ใช้ตรวจที่ server
	 * ยังไม่ Approve: it / admin, Approve แล้ว: Admin เท่านั้น (ผ่านปุ่ม Update แบบจำกัด), สถานะอื่นและใบที่ส่งแล้ว: ไม่ได้
	 */
	function brcs_cs_user_can_send(array $doc, array $session)
	{
		$spec = brcs_cs_spec();
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

if (!function_exists('brcs_cs_can_tick')) {
	/**
	 * toggle ในฟอร์มกดติ๊กได้หรือไม่ ($doc = null คือเอกสารใหม่ที่ยังไม่บันทึก)
	 * ต่างจาก brcs_cs_user_can_send(): Draft / Returned ติ๊กได้ เพราะส่งจริงตอน Submit (Save Draft แกนกลางข้ามให้เอง)
	 */
	function brcs_cs_can_tick($doc, array $session)
	{
		$spec = brcs_cs_spec();
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

if (!function_exists('brcs_cs_send')) {
	/**
	 * @return array|null null = ไม่มีอะไรต้องทำ (ไม่มีสิทธิ์ / ส่งไปแล้ว / สถานะเอกสารไม่ให้ส่ง),
	 *                    array = ผลการส่ง ['success', 'message', 'job_no']
	 */
	function brcs_cs_send($conn, $refId, array $session)
	{
		$doc = brcs_cs_load_document($conn, $refId);
		if ($doc === null || !brcs_cs_user_can_send($doc, $session)) {
			return null;
		}
		return cs_job_send_document($conn, $doc['ref_id'], $session, brcs_cs_spec());
	}
}

if (!function_exists('brcs_cs_mark_cancelled')) {
	/**
	 * BRCS ที่ส่ง CS แล้วถูกยกเลิก/ไม่อนุมัติ: ทำเครื่องหมายบนใบงาน ไม่ลบใบงาน
	 *
	 * @return array|null null = ไม่เคยส่ง CS หรือทำเครื่องหมายสำเร็จ, array = ข้อความเตือนเมื่อทำไม่สำเร็จ
	 */
	function brcs_cs_mark_cancelled($conn, $refId, $statusDoc, $reason)
	{
		return cs_job_mark_cancelled($conn, $refId, brcs_cs_spec(), $statusDoc, $reason);
	}
}
