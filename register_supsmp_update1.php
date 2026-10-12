<?php

/**
 * Update ใบเบิกสินค้าเพื่อสนับสนุนการขาย (SMP) สถานะ Request จาก register_supsmp.php
 * validate เต็ม คงสถานะ/ข้อมูลส่งอนุมัติเดิม แล้ว redirect (PRG) กลับ register_supsmp.php
 */

session_start();
date_default_timezone_set('Asia/Bangkok');

function smp_submit_fail($message, $back = true)
{
	header('Content-Type: text/html; charset=utf-8');
	echo '<!doctype html><meta charset="utf-8"><script>alert(' . json_encode($message, JSON_UNESCAPED_UNICODE) . ');'
		. ($back ? 'history.back();' : "window.location='register_supsmp.php';") . '</script>';
	exit();
}

if (empty($_SESSION['UserID'])) {
	smp_submit_fail('เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่', false);
}
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	smp_submit_fail('รูปแบบคำขอไม่ถูกต้อง', false);
}

include __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/includes/smp_repo.php';

try {
	$result = smp_persist_from_post($conn, 'update', $_SESSION);

	// toggle "ส่งข้อมูลลงระบบ CS" — หลังบันทึกสำเร็จ เหมือน Update ของ SO; ส่งไม่ผ่านไม่ทำให้เอกสารที่บันทึกแล้วเสีย
	$csResult = cs_job_send_requested($_POST) ? smp_cs_send($conn, $result['ref_id'], $_SESSION) : null;
	if ($csResult !== null) {
		// ผลการส่งแสดงใน popup บันทึกผ่าน session flash (แทน &updated=1 ไม่งั้นขึ้น popup ซ้อนสองอัน)
		$_SESSION['smp_flash'] = smp_cs_flash($csResult);
		header('Location: register_supsmp.php?ref_idsmp=' . rawurlencode($result['ref_id']));
		exit();
	}
	header('Location: register_supsmp.php?ref_idsmp=' . rawurlencode($result['ref_id']) . '&updated=1');
	exit();
} catch (SmpValidationException $e) {
	smp_submit_fail($e->getMessage());
} catch (Throwable $e) {
	error_log('[register_supsmp_update1] ' . $e->getMessage());
	smp_submit_fail('ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ');
}
