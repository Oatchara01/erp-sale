<?php

/**
 * ส่งใบสั่งขาย (hos__so) ลงสมุดลงงานของระบบ CS — ใช้กับ toggle "ส่งข้อมูลลงระบบ CS" ใน register_suphos.php
 *
 * ขั้นตอนส่ง (ต่อฐาน CS, lock, ออกเลข, เขียนใบงาน, ทำเครื่องหมายยกเลิก) อยู่ในแกนกลาง includes/cs_job_send.php
 * ไฟล์นี้เหลือเฉพาะส่วนของ SO: ตาราง/คอลัมน์, สิทธิ์, และวิธีประกอบช่องใบงานจาก SO
 * ฟังก์ชัน so_cs_* คง signature เดิมไว้ เพราะ register_suphos1.php / _edit1.php / _draft1.php เรียกอยู่
 *
 * ค่า hos__so.send_cs: 0 = ยังไม่ส่ง, 2 = ส่งแล้ว (ล็อก) — ค่า 1 ไม่ถูกเก็บลงฐานอีกแล้ว
 */

require_once __DIR__ . '/cs_job_send.php';

if (!function_exists('so_cs_role_can_send')) {
	function so_cs_role_can_send(array $session)
	{
		return cs_job_role_allowed($session, array('admin', 'it', 'owner'));
	}
}

if (!function_exists('so_cs_send_requested')) {
	function so_cs_send_requested(array $post)
	{
		return cs_job_send_requested($post);
	}
}

if (!function_exists('so_cs_result')) {
	function so_cs_result($success, $message, $jobNo = '')
	{
		return cs_job_result($success, $message, $jobNo);
	}
}

if (!function_exists('so_cs_json_fields')) {
	function so_cs_json_fields($result)
	{
		return cs_job_json_fields($result);
	}
}

if (!function_exists('so_cs_redirect_query')) {
	function so_cs_redirect_query($result)
	{
		return cs_job_redirect_query($result);
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
		$itemQuery = cs_job_query($conn, "SELECT s.count, s.sale_remark, p.sol_name, p.unit_name FROM hos__subso s
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

		$ivNo = trim((string)($so['iv_no'] ?? ''));

		return array_merge(array(
			'status'       => 'ส่ง',
			'product_name' => $lines ? 'ส่ง ' . implode("\r\n", $lines) : '',
			// iv_no ที่ยังไม่ได้ Run เลขจะมีแค่ตัวอักษรนำหน้า (เช่น "IV") ไม่นับเป็นเลขอ้างอิง
			'product_sn'   => preg_match('/\d/', $ivNo) ? $ivNo : '',
			'type_company' => ((string)($so['type_doc'] ?? '') === '4') ? 'โนเบิล เมด บจก.' : 'ออลล์เวล ไลฟ์ บจก.',
		), cs_job_compose_sale_fields($conn, $so['sale_code'] ?? '', $so['sale'] ?? '', $session));
	}
}

if (!function_exists('so_cs_spec')) {
	function so_cs_spec()
	{
		return array(
			'table'          => 'hos__so',
			'ref_column'     => 'ref_id',
			'job_column'     => 'job_no',
			'roles'          => array('admin', 'it', 'owner'),
			'blocked_status' => array('', 'Draft', 'ยกเลิก', 'Rejected', 'Cancelled'),
			'log_tag'        => 'so_cs_send',
			'compose'        => 'so_cs_compose_job_fields',
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
		return cs_job_send_document($conn, $refId, $session, so_cs_spec());
	}
}

if (!function_exists('so_cs_mark_cancelled')) {
	/**
	 * SO ที่ส่ง CS แล้วถูกยกเลิก: ทำเครื่องหมายยกเลิกบนใบงาน ไม่ลบใบงาน
	 *
	 * @return array|null null = ไม่เคยส่ง CS หรือทำเครื่องหมายสำเร็จ, array = ข้อความเตือนเมื่อทำไม่สำเร็จ
	 */
	function so_cs_mark_cancelled($conn, $refId, $statusDoc, $reason)
	{
		return cs_job_mark_cancelled($conn, $refId, so_cs_spec(), $statusDoc, $reason);
	}
}
