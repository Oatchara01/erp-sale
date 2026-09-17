<?php

/**
 * Action อนุมัติของใบเบิกเครื่องและอะไหล่ (SPR)
 * ปลายทางของปุ่ม อนุมัติ / ส่งกลับ / ไม่อนุมัติ / ยกเลิกเอกสาร ใน register_engspr.php
 *
 * แทนที่เส้นทางเดิม: approve_sprsup.php, approve_sprcm.php, rejected_sprsup.php,
 * rejected_sprcm.php ซึ่งเขียน SQL ตรง ไม่มีทรานแซกชัน และไม่ตรวจสิทธิ์ผู้กดเลย
 *
 * ต้องทำงานก่อน include("head.php") เพราะต้อง redirect ด้วย header()
 *
 * ส่งกลับ/ไม่อนุมัติ/ยกเลิก ข้าม validation ของฟอร์มได้ (บังคับกรอกเหตุผลแทน) —
 * ไฟล์นี้ไม่บันทึกค่าฟอร์มใด ๆ ทั้งสิ้น แตะเฉพาะสถานะเอกสาร ถ้าผู้อนุมัติแก้ข้อมูล
 * ฟอร์มด้วยต้องกด Update (register_engspr_draft1.php) แยกก่อน
 */

session_start();

if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	header('Location: index.php');
	exit();
}

date_default_timezone_set("Asia/Bangkok");
include __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/includes/spr_repo.php';

$sprRefId = isset($_POST['ref_id']) && !is_array($_POST['ref_id']) ? trim((string)$_POST['ref_id']) : '';
$sprCancelDoc = isset($_POST['cancel_doc']) && (string)$_POST['cancel_doc'] === '1';
$sprAction = $sprCancelDoc ? 'cancel' : (isset($_POST['approve_action']) ? trim((string)$_POST['approve_action']) : '');
$sprReason = isset($_POST['spr_approve_reason']) ? trim((string)$_POST['spr_approve_reason']) : '';

try {
	if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
		throw new SprValidationException('รูปแบบคำขอไม่ถูกต้อง');
	}

	spr_run_document_action($conn, $sprRefId, $sprAction, $sprReason, $_SESSION);

	header('Location: register_engspr.php?ref_id=' . urlencode($sprRefId) . '&saved=1');
	exit();
} catch (SprValidationException $e) {
	$sprErrorMessage = $e->getMessage();
} catch (Throwable $e) {
	error_log('[register_engspr_action1] ' . $e->getMessage());
	$sprErrorMessage = 'ไม่สามารถดำเนินการได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ';
}

// ล้มเหลว: rollback แล้วไม่มีอะไรถูกเขียน — แจ้งผู้ใช้แล้วพากลับไปหน้าเอกสาร
// ไม่ include head.php ที่นี่ เพราะ head.php เรียก session_start() ซ้ำกับด้านบน
$sprBackUrl = $sprRefId !== ''
	? 'register_engspr.php?ref_id=' . urlencode($sprRefId)
	: 'status_spr.php';
?>
<!DOCTYPE html>
<html lang="th">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SOL :: ITEAMDEV</title>
</head>
<body>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		Swal.fire({
			title: 'ดำเนินการไม่สำเร็จ',
			text: <?php echo json_encode($sprErrorMessage, JSON_UNESCAPED_UNICODE); ?>,
			icon: 'error',
			confirmButtonColor: '#612989',
			confirmButtonText: 'กลับไปที่เอกสาร'
		}).then(function() {
			window.location.href = <?php echo json_encode($sprBackUrl, JSON_UNESCAPED_UNICODE); ?>;
		});
	</script>
</body>
</html>
