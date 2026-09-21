<?php

/**
 * Action แถบอนุมัติของใบเบิกสินค้าเพื่อสนับสนุนการขาย (SMP) — ด่าน sup และ DM
 * ปลายทางของปุ่ม อนุมัติ / ส่งกลับ / ไม่อนุมัติ / ยกเลิกเอกสาร ใน register_supsmp.php
 *
 * แทน register_supsmp_return1.php และเส้นทางเดิม (sample_approve*.php, sample_rejected*.php, dm_approve.php,
 * dm_rejected.php) ที่เขียน SQL ตรง ไม่มีทรานแซกชัน ไม่ตรวจสิทธิ์ผู้กด และไม่บังคับเหตุผล
 *
 * ไม่แสดงหน้าใดเอง: ทำเสร็จ/ล้มเหลวแล้ว redirect (PRG) กลับหน้าเอกสาร พร้อมข้อความผลใน session flash
 * ที่ register_supsmp.php แสดงเป็น SweetAlert (เหมือน register_engspr_action1.php)
 *
 * ไฟล์นี้ไม่บันทึกค่าฟอร์มใด ๆ — อ่านแค่ ref_idsmp/approve_action/smp_approve_reason/smp_cancel_doc
 * และตัดสินจากข้อมูลที่บันทึกไว้ใน DB (ผู้อนุมัติที่แก้ฟอร์มต้องกด Update ก่อน)
 */

session_start();

if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	header('Location: index.php');
	exit();
}

date_default_timezone_set('Asia/Bangkok');
include __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/includes/smp_repo.php';

$smpRefId = isset($_POST['ref_idsmp']) && !is_array($_POST['ref_idsmp']) ? trim((string)$_POST['ref_idsmp']) : '';
$smpCancelDoc = isset($_POST['smp_cancel_doc']) && (string)$_POST['smp_cancel_doc'] === '1';
$smpAction = $smpCancelDoc ? 'cancel' : (isset($_POST['approve_action']) && !is_array($_POST['approve_action']) ? trim((string)$_POST['approve_action']) : '');
$smpReason = isset($_POST['smp_approve_reason']) && !is_array($_POST['smp_approve_reason']) ? trim((string)$_POST['smp_approve_reason']) : '';

$smpDoneMessages = array(
	'approved'  => 'อนุมัติเอกสารเรียบร้อยแล้ว',
	'forwarded' => 'อนุมัติแล้ว และส่งต่อ DM เรียบร้อยแล้ว',
	'returned'  => 'ส่งกลับเอกสารเรียบร้อยแล้ว',
	'rejected'  => 'ไม่อนุมัติเอกสารเรียบร้อยแล้ว',
	'cancelled' => 'ยกเลิกเอกสารเรียบร้อยแล้ว',
);

try {
	if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
		throw new SmpValidationException('รูปแบบคำขอไม่ถูกต้อง');
	}
	$smpResult = smp_run_document_action($conn, $smpRefId, $smpAction, $smpReason, $_SESSION);

	$smpFlash = array(
		'icon'  => $smpResult['warning'] !== '' ? 'warning' : 'success',
		'title' => $smpDoneMessages[$smpResult['outcome']] ?? 'ดำเนินการเรียบร้อยแล้ว',
		'text'  => 'เลขที่อ้างอิง: ' . $smpResult['ref_id'] . ($smpResult['warning'] !== '' ? "\n" . $smpResult['warning'] : ''),
	);
} catch (SmpValidationException $e) {
	$smpFlash = array('icon' => 'error', 'title' => 'ดำเนินการไม่สำเร็จ', 'text' => $e->getMessage());
} catch (Throwable $e) {
	error_log('[register_supsmp_action1] ' . $e->getMessage());
	$smpFlash = array('icon' => 'error', 'title' => 'ดำเนินการไม่สำเร็จ', 'text' => 'ไม่สามารถดำเนินการได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ');
}

$_SESSION['smp_flash'] = $smpFlash;
header('Location: ' . ($smpRefId !== '' ? 'register_supsmp.php?ref_idsmp=' . rawurlencode($smpRefId) : 'status_samplesup.php'));
exit();
