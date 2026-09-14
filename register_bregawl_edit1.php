<?php

/**
 * Handler สำหรับเอกสาร BREG AWL ที่มีอยู่แล้ว (ref_id ไม่ว่าง) — คู่กับ register_breg1.php
 * (โหมด v2) ที่ใช้สร้างเอกสารใหม่เท่านั้น
 *
 * รับ 3 กลุ่ม action จากแถบปุ่มของ register_bregawl.php:
 *   1) Submit ปกติ/submit ซ้ำหลัง Sup ส่งกลับ — full validation ผ่าน breg_persist_from_post('submit')
 *   2) อนุมัติ/ส่งกลับ/ไม่อนุมัติ (approve_action)  — เฉพาะ Sup_Sale/AllWell ที่ stage ตรงกับ role
 *   3) ยกเลิกเอกสาร (cancel_doc=1) — ทุกบทบาทที่เปิดเอกสารได้ ต้องระบุเหตุผล
 *
 * role + สถานะปัจจุบันของเอกสารถูกตรวจที่ฝั่ง server เสมอ (ใน includes/breg_repo.php)
 * ไม่เชื่อ hidden field จากฟอร์มเปล่า ๆ — ปุ่มที่ซ่อนไว้ไม่ใช่ authorization
 */

session_start();
if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	header('Location: index.php');
	exit();
}

date_default_timezone_set("Asia/Bangkok");
include __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/includes/breg_repo.php';

if (!function_exists('breg_edit1_fail')) {
function breg_edit1_fail($message, $refId = '')
{
	$target = $refId !== '' ? 'register_bregawl.php?ref_id=' . urlencode($refId) : 'register_bregawl.php';
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
			title: 'ไม่สำเร็จ',
			text: <?php echo json_encode($message, JSON_UNESCAPED_UNICODE); ?>,
			icon: 'error',
			confirmButtonColor: '#612989',
			confirmButtonText: 'กลับไปหน้าเอกสาร'
		}).then(function () {
			window.location.href = <?php echo json_encode($target); ?>;
		});
	</script>
</body>
</html>
<?php
	exit();
}
}

$refId = isset($_POST['ref_id']) && !is_array($_POST['ref_id']) ? trim((string)$_POST['ref_id']) : '';
if ($refId === '') {
	breg_edit1_fail('ไม่พบเลขที่อ้างอิงเอกสาร');
}

$approveAction = isset($_POST['approve_action']) && !is_array($_POST['approve_action']) ? trim((string)$_POST['approve_action']) : '';
$isCancelDoc = (isset($_POST['cancel_doc']) && $_POST['cancel_doc'] === '1');
$reason = isset($_POST['breg_approve_reason']) && !is_array($_POST['breg_approve_reason']) ? trim((string)$_POST['breg_approve_reason']) : '';
$userType = $_SESSION['type_login'] ?? '';
$actorName = trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? ''));

try {
	// ยกเลิกเอกสาร — ทุกบทบาทที่เปิดเอกสารได้ทำได้ ตราบใดที่ยังไม่ terminal
	if ($isCancelDoc) {
		if ($reason === '') {
			throw new BregValidationException('กรุณาระบุเหตุผลในการยกเลิก');
		}
		breg_cancel_document($conn, $refId);
		breg_log_status($conn, $refId, 'Cancelled', $reason, $_SESSION);
		breg_notify_stage_change($conn, $refId, 'cancelled', $_SESSION);
		header('Location: register_bregawl.php?ref_id=' . urlencode($refId) . '&saved=1');
		exit();
	}

	// ส่งกลับ / ไม่อนุมัติ — ข้าม field validation แต่บังคับเหตุผล และต้อง role+stage ตรงกัน
	if ($approveAction === 'return' || $approveAction === 'reject') {
		if ($reason === '') {
			throw new BregValidationException('กรุณาระบุเหตุผล');
		}

		$doc = breg_load_document($conn, $refId);
		if ($doc === null) {
			throw new BregValidationException('ไม่พบเอกสารเลขที่ ' . $refId);
		}

		$isSupStage = ($doc['status_doc'] === 'Request' && (string)$doc['send_sup'] === '1' && (string)$doc['send_dm'] === '0');
		$isDmStage = ($doc['status_doc'] === 'Request' && (string)$doc['send_sup'] === '1' && (string)$doc['send_dm'] === '1');

		if ($isSupStage && $userType === 'Sup_Sale') {
			if ($approveAction === 'return') {
				breg_sup_return($conn, $refId);
				breg_log_status($conn, $refId, 'Sup Returned', $reason, $_SESSION);
				breg_notify_stage_change($conn, $refId, 'sup_returned', $_SESSION);
			} else {
				breg_sup_reject($conn, $refId, $actorName);
				breg_log_status($conn, $refId, 'Sup Rejected', $reason, $_SESSION);
				breg_notify_stage_change($conn, $refId, 'sup_rejected', $_SESSION);
			}
		} elseif ($isDmStage && $userType === 'AllWell') {
			if ($approveAction === 'return') {
				breg_dm_return($conn, $refId);
				breg_log_status($conn, $refId, 'DM Returned', $reason, $_SESSION);
				breg_notify_stage_change($conn, $refId, 'dm_returned', $_SESSION);
			} else {
				breg_dm_reject($conn, $refId, $actorName);
				breg_log_status($conn, $refId, 'DM Rejected', $reason, $_SESSION);
				breg_notify_stage_change($conn, $refId, 'dm_rejected', $_SESSION);
			}
		} else {
			throw new BregValidationException('คุณไม่มีสิทธิ์ทำรายการนี้ หรือเอกสารถูกเปลี่ยนสถานะไปแล้ว กรุณาโหลดหน้าใหม่');
		}

		header('Location: register_bregawl.php?ref_id=' . urlencode($refId) . '&saved=1');
		exit();
	}

	// อนุมัติ — ต้องบันทึกฟอร์มปัจจุบันผ่าน full validation ก่อนเปลี่ยนสถานะ
	if ($approveAction === 'approve') {
		$stage = null;
		if ($userType === 'Sup_Sale') {
			$stage = 'sup';
		} elseif ($userType === 'AllWell') {
			$stage = 'dm';
		}
		if ($stage === null) {
			throw new BregValidationException('คุณไม่มีสิทธิ์อนุมัติเอกสารนี้');
		}

		breg_approve_stage($conn, $refId, $stage, $_SESSION);
		breg_notify_stage_change($conn, $refId, ($stage === 'sup' ? 'sup_approved' : 'dm_approved'), $_SESSION);
		header('Location: register_bregawl.php?ref_id=' . urlencode($refId) . '&saved=1');
		exit();
	}

	// Submit ปกติ (สร้างใหม่ไม่ผ่านไฟล์นี้) — ใช้ submit ซ้ำหลังถูก Sup ส่งกลับได้ด้วย
	if (isset($_POST['submit']) && $_POST['submit'] === 'submit') {
		$result = breg_persist_from_post($conn, 'submit', $_SESSION);
		breg_notify_stage_change($conn, $result['ref_id'], 'submitted', $_SESSION);
		header('Location: register_bregawl.php?ref_id=' . urlencode($result['ref_id']) . '&saved=1');
		exit();
	}

	throw new BregValidationException('คำขอไม่ถูกต้อง');
} catch (BregValidationException $e) {
	breg_edit1_fail($e->getMessage(), $refId);
} catch (Throwable $e) {
	error_log('[register_bregawl_edit1] ' . $e->getMessage());
	breg_edit1_fail('ไม่สามารถบันทึกเอกสารได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ', $refId);
}
