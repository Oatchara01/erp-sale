<?php

/**
 * ตัวบันทึกใบ PO — ทุกเส้นทางผ่าน includes/po_repo.php (prepared statement + transaction)
 *
 *   po_action = draft | submit | create_so  → จาก register_poawl.php (fetch) ตอบกลับ JSON เสมอ
 *   ไม่มี po_action                         → ฟอร์มเดิม register_ponbm.php (submit ปกติ) ตอบ alert + redirect แบบเดิม
 *
 * po_action ถูกส่งมาทั้งใน query string และ body — ถ้าไฟล์ใหญ่เกิน post_max_size PHP จะทิ้ง $_POST ทั้งก้อน
 * ต้องยังรู้ว่าเป็นคำขอแบบใหม่เพื่อตอบ JSON ไม่ใช่หลุดไปเส้นทาง legacy
 */

require_once __DIR__ . '/includes/po_repo.php';

date_default_timezone_set("Asia/Bangkok");

$poAction = isset($_POST['po_action']) && !is_array($_POST['po_action'])
	? trim((string)$_POST['po_action'])
	: (isset($_GET['po_action']) && !is_array($_GET['po_action']) ? trim((string)$_GET['po_action']) : '');

if ($poAction !== '') {
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
	if (count($_POST) === 0 && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
		$respond(array('success' => false, 'message' => 'ข้อมูลหรือไฟล์แนบมีขนาดใหญ่เกินกำหนด (ไฟล์ละไม่เกิน 1 MB)'), 413);
	}
	if (!in_array($poAction, array('draft', 'submit', 'create_so'), true)) {
		$respond(array('success' => false, 'message' => 'ไม่รู้จักคำสั่งบันทึก'), 400);
	}

	include __DIR__ . '/dbconnect.php';

	try {
		$result = po_persist($conn, $poAction, $_POST, $_FILES, $_SESSION);
		$refId = $result['ref_id'];

		if ($poAction === 'draft') {
			$message = 'บันทึกร่างเรียบร้อยแล้ว';
			$redirect = 'register_poawl.php?ref_id=' . rawurlencode($refId) . '&saved=1';
		} else if ($poAction === 'submit') {
			$message = 'ส่งใบ PO ให้ Sale เรียบร้อยแล้ว';
			$redirect = 'status_adminpo.php?submitted=' . rawurlencode($refId);
		} else {
			$message = 'บันทึกใบ PO แล้ว กำลังเปิดหน้าออกใบสั่งขาย';
			$redirect = 'register_suphos.php?ref_id=' . rawurlencode($refId);
		}

		$respond(array(
			'success'    => true,
			'ref_id'     => $refId,
			'created'    => $result['created'],
			'status_doc' => $result['status_doc'],
			'message'    => $message,
			'redirect'   => $redirect,
		));
	} catch (PoValidationException $e) {
		$respond(array('success' => false, 'message' => $e->getMessage()), 422);
	} catch (Throwable $e) {
		// error ระดับฐานข้อมูล/ระบบ — ลง log ไม่ส่งโครงสร้างตารางกลับหน้าเว็บ
		error_log('[register_posave1] ' . $e->getMessage());
		$respond(array('success' => false, 'message' => 'ไม่สามารถบันทึกใบ PO ได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ'), 500);
	}
}

/* ===================== เส้นทาง legacy (register_ponbm.php) ===================== */
include("head.php");

$poLegacyAlert = function ($message, $location) {
	echo "<script language=\"JavaScript\">";
	echo "alert(" . json_encode($message, JSON_UNESCAPED_UNICODE) . ");window.location=" . json_encode($location) . ";";
	echo "</script>";
	exit();
};

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	$poLegacyAlert('รูปแบบคำขอไม่ถูกต้อง', 'main_admin_po.php');
}

try {
	$result = po_persist($conn, 'legacy', $_POST, $_FILES, $_SESSION);
	$poLegacyAlert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว', 'register_poadmin_edit.php?ref_id=' . rawurlencode($result['ref_id']));
} catch (PoValidationException $e) {
	echo "<script language=\"JavaScript\">alert(" . json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE) . ");history.back();</script>";
	exit();
} catch (Throwable $e) {
	error_log('[register_posave1 legacy] ' . $e->getMessage());
	echo "<script language=\"JavaScript\">alert('ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง');history.back();</script>";
	exit();
}
