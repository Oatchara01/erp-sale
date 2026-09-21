<?php

/**
 * Save Draft ของใบเบิกสินค้าเพื่อสนับสนุนการขาย (SMP) — ปลายทาง AJAX ของปุ่ม "Save Draft"
 * ไม่ validate ข้อมูล (บันทึกได้แม้ไม่ครบ) แต่ยังตรวจไฟล์แนบ/เดือนที่ปิดเอกสาร
 * ใบใหม่จองเลข RSMP จริงทันที ใบ Draft เดิมถูก UPDATE ทับด้วยเลขเดิม
 * ตอบกลับเป็น JSON เสมอ
 */

session_start();
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');

function smp_json($payload)
{
	echo json_encode($payload, JSON_UNESCAPED_UNICODE);
	exit();
}

if (empty($_SESSION['UserID'])) {
	smp_json(array('success' => false, 'message' => 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่'));
}
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	smp_json(array('success' => false, 'message' => 'รูปแบบคำขอไม่ถูกต้อง'));
}

include __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/includes/smp_repo.php';

try {
	$result = smp_persist_from_post($conn, 'draft', $_SESSION);
	smp_json(array(
		'success' => true,
		'ref_id'  => $result['ref_id'],
		'created' => $result['created'],
		'message' => 'บันทึกแบบร่างเรียบร้อยแล้ว',
	));
} catch (SmpValidationException $e) {
	smp_json(array('success' => false, 'message' => $e->getMessage()));
} catch (Throwable $e) {
	error_log('[register_supsmp_draft1] ' . $e->getMessage());
	smp_json(array('success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ'));
}
