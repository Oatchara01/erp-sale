<?php
/**
 * ประวัติการคืนของเอกสารต้นทางหนึ่งใบ (ใบคืนเก่าและใหม่) — ให้ modal "ประวัติการคืน" ในหน้ารายการเอกสาร 8 หน้า
 * GET source_type (br | consig | breq | breg | smp | rental | change | spr) + source_ref
 * ผู้ใช้ที่เข้าสู่ระบบและเห็นเอกสารในหน้ารายการดูได้ ไม่ตรวจสิทธิ์เพิ่ม
 */

session_start();
header('Content-Type: application/json; charset=utf-8');

$respond = function ($payload, $statusCode = 200) {
	http_response_code($statusCode);
	echo json_encode($payload, JSON_UNESCAPED_UNICODE);
	exit;
};

if (empty($_SESSION['UserID'])) {
	$respond(array('success' => false, 'message' => 'กรุณาเข้าสู่ระบบ'), 401);
}

require_once __DIR__ . '/includes/receive_repo.php';
mysqli_report(MYSQLI_REPORT_OFF);
include __DIR__ . '/dbconnect.php';

if (empty($conn) || !($conn instanceof mysqli)) {
	error_log('ajax_receive_history.php: database connection failed');
	$respond(array('success' => false, 'message' => 'ไม่สามารถเชื่อมต่อฐานข้อมูลได้'), 500);
}

$type = isset($_GET['source_type']) && !is_array($_GET['source_type']) ? trim((string)$_GET['source_type']) : '';
$ref = isset($_GET['source_ref']) && !is_array($_GET['source_ref']) ? trim((string)$_GET['source_ref']) : '';
if (rc_source_config($type) === null || $ref === '') {
	$respond(array('success' => false, 'message' => 'ระบุเอกสารต้นทางไม่ถูกต้อง'), 400);
}

try {
	if (!rc_has_source_columns($conn)) {
		$respond(array('success' => false, 'message' => 'ฐานข้อมูลยังไม่รองรับใบคืนแบบรวม กรุณาแจ้งผู้ดูแลระบบให้รัน sql/receive_source.sql'), 500);
	}
	$source = rc_load_source($conn, $type, $ref);
	if ($source === null) {
		$respond(array('success' => false, 'message' => 'ไม่พบเอกสารต้นทาง'), 404);
	}
	$respond(array(
		'success' => true,
		'data'    => array(
			'doc_no' => $source['doc_no'] !== '' ? $source['doc_no'] : $source['ref'],
			'items'  => rc_history($conn, $source),
		),
	));
} catch (Throwable $e) {
	error_log('ajax_receive_history.php: ' . $e->getMessage());
	$respond(array('success' => false, 'message' => 'เกิดข้อผิดพลาดในการโหลดประวัติการคืน'), 500);
}
