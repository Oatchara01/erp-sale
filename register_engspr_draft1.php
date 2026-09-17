<?php

/**
 * Save Draft / Update ของใบเบิกเครื่องและอะไหล่ (SPR)
 * ปลายทาง AJAX ของปุ่ม "Save Draft" / "Update" ใน register_engspr.php
 *
 * - ใบใหม่      → จองเลข SPR จริงทันที (แสดงในรายการ status_spr.php ได้เลย)
 * - ใบเดิม Draft → UPDATE ทับ เลขไม่เปลี่ยน สถานะยังเป็น Draft
 * - ใบเดิมไม่ใช่ Draft (Request/Rejected) → "Update": บันทึกข้อมูลฟอร์มทับ ไม่แตะ
 *   status_doc/send_sup เลย (spr_persist_from_post() จัดการ branch นี้ให้)
 * - validate เต็มรูปแบบเหมือน Submit เสมอ (ข้อกำหนดข้อ 11 ของ handoff)
 * - ไม่ส่งเข้าคิวอนุมัติและไม่แตะใบงานบริการต้นทางทุกกรณี (เฉพาะ Submit เท่านั้นที่ทำ)
 *
 * ตอบกลับเป็น JSON เสมอ — ไม่ echo HTML ปนออกไป
 */

require_once __DIR__ . '/error_page.php';

session_start();

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	echo json_encode(array('success' => false, 'message' => 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่'), JSON_UNESCAPED_UNICODE);
	exit();
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	echo json_encode(array('success' => false, 'message' => 'รูปแบบคำขอไม่ถูกต้อง'), JSON_UNESCAPED_UNICODE);
	exit();
}

include __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/includes/spr_repo.php';

try {
	$result = spr_persist_from_post($conn, 'draft', $_SESSION);

	echo json_encode(array(
		'success' => true,
		'ref_id'  => $result['ref_id'],
		'created' => $result['created'],
		'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
	), JSON_UNESCAPED_UNICODE);
} catch (SprValidationException $e) {
	// ข้อความที่เขียนไว้ให้ผู้ใช้อ่านโดยตรง
	echo json_encode(array('success' => false, 'message' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
	// error ระดับฐานข้อมูล/ระบบ — ลง log ไว้ ไม่ส่งรายละเอียดโครงสร้างตารางกลับหน้าเว็บ
	error_log('[register_engspr_draft1] ' . $e->getMessage());
	echo json_encode(array(
		'success' => false,
		'message' => 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ',
	), JSON_UNESCAPED_UNICODE);
}
