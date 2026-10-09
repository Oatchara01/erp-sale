<?php

/**
 * ตัวบันทึกใบคืนสินค้าแบบรวม — ทุกเส้นทางผ่าน includes/receive_repo.php ตอบกลับ JSON เสมอ
 *
 *   rc_action = draft | submit → จาก register_receive.php (fetch + FormData มีไฟล์แนบ)
 *   rc_action = cancel         → ยกเลิกฉบับร่าง (receive_ref)
 */

require_once __DIR__ . '/includes/receive_repo.php';

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
// post_max_size เต็ม PHP จะทิ้ง $_POST ทั้งหมด — บอกสาเหตุแทนที่จะตอบว่าไม่รู้จักคำสั่ง
if (empty($_POST) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
	$respond(array('success' => false, 'message' => 'ไฟล์แนบมีขนาดรวมใหญ่เกินกำหนด กรุณาลดขนาดไฟล์'), 413);
}

$rcAction = rc_post_value($_POST, 'rc_action');
if (!in_array($rcAction, array('draft', 'submit', 'cancel'), true)) {
	$respond(array('success' => false, 'message' => 'ไม่รู้จักคำสั่งบันทึก'), 400);
}

include __DIR__ . '/dbconnect.php';

try {
	if ($rcAction === 'cancel') {
		$receiveRef = rc_post_value($_POST, 'receive_ref');
		$receipt = $receiveRef !== '' ? rc_load_receipt($conn, $receiveRef) : null;
		rc_cancel($conn, $receiveRef, $_SESSION);
		$pages = ($receipt !== null) ? rc_source_pages((string)$receipt['source_type']) : null;
		$respond(array(
			'success'  => true,
			'message'  => 'ยกเลิกใบคืนสินค้าเรียบร้อยแล้ว',
			'redirect' => $pages !== null ? $pages['list'] : 'index.php',
		));
	}

	$result = rc_persist($conn, $rcAction, $_POST, $_FILES, $_SESSION);
	$flag = ($rcAction === 'submit') ? 'submitted' : 'saved';
	$respond(array(
		'success'     => true,
		'receive_ref' => $result['receive_ref'],
		'created'     => $result['created'],
		'send_stock'  => $result['send_stock'],
		'message'     => $rcAction === 'submit' ? 'ส่งใบคืนให้ Stock เรียบร้อยแล้ว' : 'บันทึกร่างเรียบร้อยแล้ว',
		'redirect'    => 'register_receive.php?receive_ref=' . rawurlencode($result['receive_ref']) . '&' . $flag . '=1',
	));
} catch (RcValidationException $e) {
	$respond(array('success' => false, 'message' => $e->getMessage()), 422);
} catch (Throwable $e) {
	// error ระดับฐานข้อมูล/ระบบ — ลง log ไม่ส่งโครงสร้างตารางกลับหน้าเว็บ
	error_log('[register_receive1 ' . $rcAction . '] ' . $e->getMessage());
	$respond(array('success' => false, 'message' => 'ไม่สามารถบันทึกได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ'), 500);
}
