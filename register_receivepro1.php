<?php

/**
 * ตัวบันทึกใบส่งสินค้า / ใบรับสินค้า — ทุกเส้นทางผ่าน includes/receivepro_repo.php ตอบกลับ JSON เสมอ
 *
 *   rp_action = draft | submit | update → จาก register_receivepro.php (fetch)
 *   rp_action = send_receive            → ส่งข้อมูลไปรับจ่าย (อ่านแค่ rp_no)
 *   rp_action = cancel                  → ยกเลิกเอกสาร (rp_no + reason) ลง tb_document_status_log
 */

require_once __DIR__ . '/includes/receivepro_repo.php';

date_default_timezone_set("Asia/Bangkok");
session_start();
header('Content-Type: application/json; charset=utf-8');

$respond = function ($payload, $statusCode = 200) {
	http_response_code($statusCode);
	echo json_encode($payload, JSON_UNESCAPED_UNICODE);
	exit();
};

if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	$respond(array('success' => false, 'message' => 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่'), 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	$respond(array('success' => false, 'message' => 'รูปแบบคำขอไม่ถูกต้อง'), 405);
}

$rpAction = rp_post_value($_POST, 'rp_action');
if (!in_array($rpAction, array('draft', 'submit', 'update', 'send_receive', 'cancel'), true)) {
	$respond(array('success' => false, 'message' => 'ไม่รู้จักคำสั่งบันทึก'), 400);
}

include __DIR__ . '/dbconnect.php';

$pageUrl = function ($rpNo, $flag) {
	return 'register_receivepro.php?rp_no=' . rawurlencode($rpNo) . '&' . $flag . '=1';
};

try {
	/* ส่งรับจ่าย / ยกเลิก — ไม่ใช้ข้อมูลฟอร์ม จึงไม่ผ่าน validation ของการบันทึก */
	if ($rpAction === 'send_receive' || $rpAction === 'cancel') {
		$rpNo = rp_post_value($_POST, 'rp_no');
		if ($rpNo === '') {
			throw new RpValidationException('ไม่พบเลขที่เอกสาร');
		}
		if ($rpAction === 'send_receive') {
			include __DIR__ . '/dbconnect_acc.php';
			rp_send_receive($conn, $code, $rpNo, $_SESSION);
			$respond(array('success' => true, 'rp_no' => $rpNo, 'message' => 'ส่งข้อมูลไปรับจ่ายเรียบร้อยแล้ว', 'redirect' => $pageUrl($rpNo, 'sent')));
		}
		$reason = isset($_POST['reason']) && !is_array($_POST['reason']) ? (string)$_POST['reason'] : '';
		rp_cancel_document($conn, $rpNo, $reason, $_SESSION);
		$respond(array('success' => true, 'rp_no' => $rpNo, 'message' => 'ยกเลิกเอกสารเรียบร้อยแล้ว', 'redirect' => $pageUrl($rpNo, 'cancelled')));
	}

	$result = rp_persist($conn, $rpAction, $_POST, $_SESSION);
	$messages = array(
		'draft'  => array('บันทึกร่างเรียบร้อยแล้ว', 'saved'),
		'submit' => array('Submit เอกสารเรียบร้อยแล้ว', 'submitted'),
		'update' => array('อัปเดตเอกสารเรียบร้อยแล้ว', 'updated'),
	);
	$respond(array(
		'success'    => true,
		'rp_no'      => $result['rp_no'],
		'created'    => $result['created'],
		'status_doc' => $result['status_doc'],
		'message'    => $messages[$rpAction][0],
		'redirect'   => $pageUrl($result['rp_no'], $messages[$rpAction][1]),
	));
} catch (RpValidationException $e) {
	$respond(array('success' => false, 'message' => $e->getMessage()), 422);
} catch (Throwable $e) {
	// error ระดับฐานข้อมูล/ระบบ — ลง log ไม่ส่งโครงสร้างตารางกลับหน้าเว็บ
	error_log('[register_receivepro1 ' . $rpAction . '] ' . $e->getMessage());
	$respond(array('success' => false, 'message' => 'ไม่สามารถบันทึกได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ'), 500);
}
