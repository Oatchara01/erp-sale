<?php

/**
 * ตัวบันทึกใบ PO — ทุกเส้นทางผ่าน includes/po_repo.php (prepared statement + transaction)
 *
 *   po_action = draft | submit | create_so | update  → จาก register_poawl.php (fetch) ตอบกลับ JSON เสมอ
 *   po_action = return (Sale ส่งกลับ) | cancel (Admin ยกเลิก) → ต้องมี reason, ลง tb_document_status_log
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
	if (!in_array($poAction, array('draft', 'submit', 'create_so', 'update', 'return', 'cancel'), true)) {
		$respond(array('success' => false, 'message' => 'ไม่รู้จักคำสั่งบันทึก'), 400);
	}
	// ฝั่ง Sale เปิดใบ PO แบบอ่านอย่างเดียว — ทำได้แค่ส่งกลับ
	if (po_is_sale_side_user($_SESSION) && $poAction !== 'return') {
		$respond(array('success' => false, 'message' => 'คุณไม่มีสิทธิ์แก้ไขใบ PO'), 403);
	}

	include __DIR__ . '/dbconnect.php';

	/* ส่งกลับ / ยกเลิก — ไม่ใช้ข้อมูลฟอร์ม อ่านแค่ ref_id + เหตุผล จึงไม่ผ่าน validation ของการบันทึก */
	if ($poAction === 'return' || $poAction === 'cancel') {
		$refId = po_post_value($_POST, 'ref_id');
		$reason = isset($_POST['reason']) && !is_array($_POST['reason']) ? (string)$_POST['reason'] : '';
		try {
			if ($refId === '') {
				throw new PoValidationException('ไม่พบเลขที่เอกสาร');
			}
			if ($poAction === 'return') {
				po_return_document($conn, $refId, $reason, $_SESSION);
				$message = 'ส่งกลับใบ PO ให้ Admin เรียบร้อยแล้ว';
				$redirect = 'status_po_sale.php?returned=' . rawurlencode($refId);
			} else {
				po_cancel_document($conn, $refId, $reason, $_SESSION);
				$message = 'ยกเลิกใบ PO เรียบร้อยแล้ว';
				$redirect = 'register_poawl.php?ref_id=' . rawurlencode($refId) . '&cancelled=1';
			}
			$respond(array('success' => true, 'ref_id' => $refId, 'message' => $message, 'redirect' => $redirect));
		} catch (PoValidationException $e) {
			$respond(array('success' => false, 'message' => $e->getMessage()), 422);
		} catch (Throwable $e) {
			error_log('[register_posave1 ' . $poAction . '] ' . $e->getMessage());
			$respond(array('success' => false, 'message' => 'ไม่สามารถบันทึกได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ'), 500);
		}
	}

	try {
		$result = po_persist($conn, $poAction, $_POST, $_FILES, $_SESSION);
		$refId = $result['ref_id'];

		if ($poAction === 'draft') {
			$message = 'บันทึกร่างเรียบร้อยแล้ว';
			$redirect = 'register_poawl.php?ref_id=' . rawurlencode($refId) . '&saved=1';
		} else if ($poAction === 'submit') {
			$message = 'ส่งใบ PO ให้ Sale เรียบร้อยแล้ว';
			$redirect = 'register_poawl.php?ref_id=' . rawurlencode($refId) . '&submitted=1';
		} else if ($poAction === 'update') {
			$message = 'อัปเดตใบ PO เรียบร้อยแล้ว';
			$redirect = 'register_poawl.php?ref_id=' . rawurlencode($refId) . '&updated=1';
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
