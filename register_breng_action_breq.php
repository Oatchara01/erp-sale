<?php

/**
 * ปลายทาง AJAX ของแถบอนุมัติใน register_breng_brgq.php (ใบยืมตรวจเช็คสินค้า BREQ)
 *   action=approve     → Sup อนุมัติ (บันทึกค่าฟอร์มล่าสุดก่อนในทรานแซกชันเดียวกัน)
 *   action=return      → Sup ส่งกลับให้เจ้าของแก้ (ต้องมีเหตุผล)
 *   action=reject      → Sup ไม่อนุมัติ (ต้องมีเหตุผล)
 *   action=cancel      → เจ้าของ/Sup ยกเลิกเอกสาร (ต้องมีเหตุผล)
 *   action=admin_save  → Admin บันทึกเลขที่/วันที่เอกสารของใบที่อนุมัติแล้ว
 *
 * แทน breng_approve_breq.php / brhos_rejected_breq.php (รับ GET, ไม่ตรวจสิทธิ์/สถานะ) — ไฟล์เดิมไม่ถูกแก้
 * สิทธิ์และสถานะตรวจที่ includes/breq_repo.php ทุกครั้ง ตอบกลับเป็น JSON เสมอ
 */

require_once __DIR__ . '/error_page.php';

session_start();

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

function breq_action_respond(array $payload)
{
	echo json_encode($payload, JSON_UNESCAPED_UNICODE);
	exit();
}

if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	breq_action_respond(array('success' => false, 'message' => 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่'));
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	breq_action_respond(array('success' => false, 'message' => 'รูปแบบคำขอไม่ถูกต้อง'));
}

include __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/includes/breq_repo.php';

$stockConn = (isset($new) && $new instanceof mysqli) ? $new : $conn;
$action = breq_post_value($_POST, 'breq_action');
$refId = breq_post_value($_POST, 'ref_id_br');
$reason = breq_post_value($_POST, 'breq_reason');

$doneMessages = array(
	'approved'    => 'อนุมัติเอกสารเรียบร้อยแล้ว',
	'returned'    => 'ส่งกลับเอกสารเรียบร้อยแล้ว',
	'rejected'    => 'ไม่อนุมัติเอกสารเรียบร้อยแล้ว',
	'cancelled'   => 'ยกเลิกเอกสารเรียบร้อยแล้ว',
	'admin_saved' => 'บันทึกเลขที่เอกสารเรียบร้อยแล้ว',
);

try {
	$result = $action === 'admin_save'
		? breq_admin_save_doc_no($conn, $refId, $_POST, $_SESSION)
		: breq_run_document_action($conn, $stockConn, $refId, $action, $reason, $_POST, $_SESSION);
	breq_action_respond(array(
		'success' => true,
		'ref_id'  => $result['ref_id'],
		'outcome' => $result['outcome'],
		'message' => $doneMessages[$result['outcome']],
	));
} catch (BreqValidationException $e) {
	breq_action_respond(array('success' => false, 'message' => $e->getMessage()));
} catch (Throwable $e) {
	error_log('[register_breng_action_breq] ' . $e->getMessage());
	breq_action_respond(array(
		'success' => false,
		'message' => 'ไม่สามารถดำเนินการได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ',
	));
}
