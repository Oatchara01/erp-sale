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
	// ปุ่ม Update ใช้ได้เฉพาะตอนแก้ไขเอกสารที่มีอยู่แล้วเท่านั้น (ไม่มี fallback ไป insert path
	// เหมือน register_suphos_draft1.php เพราะ register_credinot1.php รองรับทั้ง insert/update
	// อยู่แล้วผ่าน form_mode — ถ้าไม่มี ref_credit ให้ปฏิเสธไปเลย กันไม่ให้สร้างเอกสารใหม่โดยไม่ตั้งใจ)
	if ($formMode !== 'edit' || $refCredit === '') {
		echo json_encode([
			'success' => false,
			'message' => 'ปุ่ม Update ใช้ได้เฉพาะตอนแก้ไขเอกสารที่มีอยู่แล้วเท่านั้น'
		]);
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
