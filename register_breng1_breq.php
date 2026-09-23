<?php
/**
 * Submit ใบยืมตรวจเช็คสินค้า (BREQ) จาก register_breng_brgq.php
 * ใบใหม่ → จองเลข BQ แล้วบันทึกเป็น Request / ใบ Draft เดิม → เปลี่ยนเป็น Request (เลขเดิม)
 * ตัวบันทึกจริงอยู่ที่ includes/breq_repo.php (breq_persist)
 */
// ตัวเดิมไม่ได้ session_start() จึงบันทึก sale / sale_code / add_by เป็นค่าว่างมาตลอด
session_start();
include("dbconnect.php");
include ("error_page.php");
require_once __DIR__ . '/includes/breq_repo.php';

date_default_timezone_set("Asia/Bangkok");

function breq_submit_alert_back($message)
{
	$json = json_encode($message, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
	echo "<script>alert(" . $json . ");history.back();</script>";
	exit;
}

if (($_POST["submit"] ?? '') !== "submit") {
	breq_submit_alert_back('รูปแบบคำขอไม่ถูกต้อง');
}

// dbconnect.php เปิด $new (allwell_stock_test) ไว้ให้ — ใช้คำนวณคงเหลือของ PO
$stockConn = (isset($new) && $new instanceof mysqli) ? $new : $conn;

try {
	$result = breq_persist($conn, $stockConn, $_POST, 'submit', $_SESSION);
} catch (BreqValidationException $e) {
	breq_submit_alert_back($e->getMessage());
} catch (Throwable $e) {
	error_log('[register_breng1_breq] ' . $e->getMessage());
	breq_submit_alert_back('ไม่สามารถบันทึกเอกสารได้ กรุณาลองใหม่อีกครั้ง หากยังไม่ได้กรุณาแจ้งผู้ดูแลระบบ');
}

$target = 'register_breng_brgq.php?ref_id_br=' . rawurlencode($result['ref_id']) . '&saved=submit';
echo "<script>window.location=" . json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) . ";</script>";
