<?php

/**
 * ปลายทาง AJAX ของแถบปุ่มใน register_breng_brgq.php (ใบยืมตรวจเช็คสินค้า BREQ)
 *   action=draft    → Save Draft / Update ของเอกสาร Draft (ไม่บังคับมีรายการ)
 *   action=update   → Update เอกสาร Returned / Request (ตรวจครบเหมือน Submit, ไม่เปลี่ยนสถานะ)
 *                     ผู้แก้ได้ตาม breq_user_can_edit_document: เจ้าของ (ใบในมือเจ้าของ) / Sup (ใบในคิว Sup)
 * การส่ง Sup อนุมัติรวมอยู่ใน Submit แล้ว (register_breng1_breq.php)
 * อนุมัติ / ส่งกลับ / ไม่อนุมัติ / ยกเลิก อยู่ที่ register_breng_action_breq.php
 * ตอบกลับเป็น JSON เสมอ
 */

require_once __DIR__ . '/error_page.php';

session_start();

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

function breq_save_respond(array $payload)
{
	echo json_encode($payload, JSON_UNESCAPED_UNICODE);
	exit();
}

if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	breq_save_respond(array('success' => false, 'message' => 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่'));
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	breq_save_respond(array('success' => false, 'message' => 'รูปแบบคำขอไม่ถูกต้อง'));
}

include __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/includes/breq_repo.php';

$stockConn = (isset($new) && $new instanceof mysqli) ? $new : $conn;
$action = (string)($_POST['action'] ?? '');

try {
	if ($action !== 'draft' && $action !== 'update') {
		breq_save_respond(array('success' => false, 'message' => 'รูปแบบคำขอไม่ถูกต้อง'));
	}

	$result = breq_persist($conn, $stockConn, $_POST, $action, $_SESSION);
	breq_save_respond(array(
		'success' => true,
		'ref_id'  => $result['ref_id'],
		'created' => $result['created'],
		'message' => $action === 'draft' ? 'บันทึกร่างเรียบร้อยแล้ว' : 'บันทึกการแก้ไขเรียบร้อยแล้ว',
	));
} catch (BreqValidationException $e) {
	breq_save_respond(array('success' => false, 'message' => $e->getMessage()));
} catch (Throwable $e) {
	error_log('[register_breng_save_breq] ' . $e->getMessage());
	breq_save_respond(array(
		'success' => false,
		'message' => 'ไม่สามารถบันทึกได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ',
	));
}
