<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include("dbconnect.php");
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

$_POST['is_draft'] = '1';
$_POST['submit'] = 'submit';

$refCredit = trim((string)($_POST['ref_credit'] ?? ''));
$formMode = $_POST['form_mode'] ?? '';

try {
	// ปุ่ม Save Draft (โหมดสร้าง) — register_credinot1.php แยก insert/update ผ่าน form_mode อยู่แล้ว
	// insert + is_draft=1 จะบันทึกเป็น status_doc='Draft', send_sup='0' (ยังไม่เข้าคิว Sup)
	if ($formMode !== 'edit') {
		include("register_credinot1.php");
		exit();
	}

	if ($refCredit === '') {
		echo json_encode(['success' => false, 'message' => 'ไม่พบเลขที่เอกสารใบลดหนี้']);
		exit();
	}

	$safeRefCredit = mysqli_real_escape_string($conn, $refCredit);
	$lockQuery = mysqli_query($conn, "SELECT status_doc, send_admin FROM tb_credit_note WHERE ref_credit = '" . $safeRefCredit . "' LIMIT 1");
	$lockRow = $lockQuery ? mysqli_fetch_assoc($lockQuery) : null;

	if (!$lockRow) {
		echo json_encode(['success' => false, 'message' => 'ไม่พบเอกสารใบลดหนี้นี้']);
		exit();
	}

	$lockStatusDoc = $lockRow['status_doc'] ?? '';
	$lockWasEverApproved = (($lockRow['send_admin'] ?? '0') === '1');
	// เงื่อนไข lock เดียวกับ $creditItemsLocked ใน register_credinot.php / $isLockedDoc ใน register_credinot1.php
	$isLocked = ($lockStatusDoc === 'Approve') || ($lockStatusDoc === 'ยกเลิก' && $lockWasEverApproved);

	if ($isLocked) {
		echo json_encode([
			'success' => false,
			'message' => 'เอกสารนี้ถูกอนุมัติหรือยกเลิกแล้ว ไม่สามารถอัปเดตได้'
		]);
		exit();
	}

	include("register_credinot1.php");
	exit();
} catch (Throwable $e) {
	echo json_encode(['success' => false, 'message' => 'Exception: ' . $e->getMessage()]);
	exit();
}
