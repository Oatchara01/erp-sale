<?php

/**
 * ปุ่ม Update แบบจำกัดของใบยืมฝากขาย BRCS (register_supbrcshos.php) — ใช้กับเอกสารที่ Approve แล้ว
 * ผู้ใช้ Admin ติ๊ก toggle "ส่งข้อมูลลงระบบ CS" แล้วกด Update: ทำอย่างเดียวคือส่งใบงานจากข้อมูลที่บันทึกไว้ในฐาน
 * ไม่บันทึกค่าฟอร์ม ไม่เปลี่ยนสถานะ (เหมือนปุ่ม Update แบบจำกัดของ SO/SMP)
 *
 * ไม่แสดงหน้าใดเอง: ทำเสร็จแล้ว redirect กลับหน้าเอกสารพร้อมผลใน query (cs_sync / cs_sync_msg)
 * ที่ register_supbrcshos.php แสดงเป็น SweetAlert
 */

session_start();

if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	header('Location: index.php');
	exit();
}

date_default_timezone_set('Asia/Bangkok');
include __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/includes/brcs_cs_send.php';

$csRefId = isset($_POST['ref_id']) && !is_array($_POST['ref_id']) ? trim((string)$_POST['ref_id']) : '';
$csBackUrl = $csRefId !== '' ? 'register_supbrcshos.php?ref_id=' . rawurlencode($csRefId) : 'status_adminbrsc.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST' || !cs_job_send_requested($_POST)) {
	header('Location: ' . $csBackUrl);
	exit();
}

$csSendResult = brcs_cs_send($conn, $csRefId, $_SESSION);
if ($csSendResult === null) {
	$csSendResult = cs_job_result(false, 'ส่งข้อมูลลงระบบ CS ไม่ได้ เอกสารนี้ส่งไปแล้ว อยู่ในสถานะที่ส่งไม่ได้ หรือคุณไม่มีสิทธิ์ส่ง กรุณาโหลดหน้าใหม่');
}

header('Location: ' . $csBackUrl . '&saved=1' . cs_job_redirect_query($csSendResult));
exit();
