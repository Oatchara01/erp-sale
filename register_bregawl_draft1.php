<?php

/**
 * Save Draft ของใบขอเบิกอะไหล่จากสินค้าขาย (BREG)
 * ปลายทาง AJAX ของปุ่ม "Save Draft" / "Update ร่าง" ใน register_bregawl.php
 *
 * - ร่างใบใหม่  → จองเลข RG จริงทันที (แสดงในรายการ status_engbreg.php ได้เลย)
 * - ร่างใบเดิม  → UPDATE ทับ เลขไม่เปลี่ยน
 * - ไม่บังคับกรอกครบ ยกเว้นส่วนของช่างที่ถ้าเริ่มกรอกแล้วต้องครบชุด
 * - ไม่ส่งอนุมัติและไม่แจ้งเตือน Line ทุกกรณี (send_sup / send_dm ยังเป็น 0)
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
require_once __DIR__ . '/includes/breg_repo.php';

try {
	$result = breg_persist_from_post($conn, 'draft', $_SESSION);

	echo json_encode(array(
		'success' => true,
		'ref_id'  => $result['ref_id'],
		'created' => $result['created'],
		'message' => 'บันทึกร่างเรียบร้อยแล้ว',
	), JSON_UNESCAPED_UNICODE);
} catch (BregValidationException $e) {
	// ข้อความที่เขียนไว้ให้ผู้ใช้อ่านโดยตรง
	echo json_encode(array('success' => false, 'message' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
	// error ระดับฐานข้อมูล/ระบบ — ลง log ไว้ ไม่ส่งรายละเอียดโครงสร้างตารางกลับหน้าเว็บ
	error_log('[register_bregawl_draft1] ' . $e->getMessage());
	echo json_encode(array(
		'success' => false,
		'message' => 'ไม่สามารถบันทึกร่างได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ',
	), JSON_UNESCAPED_UNICODE);
}
