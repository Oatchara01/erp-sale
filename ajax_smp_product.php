<?php

/**
 * ค้นสินค้าสำหรับช่องค้นหาของ register_supsmp.php — ตอบ JSON
 *   GET q       = คำค้น (รหัส / ชื่อไทย / ชื่ออังกฤษ)
 *   GET company = AWL | NBM
 */

require_once __DIR__ . '/includes/smp_repo.php';

session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	http_response_code(401);
	echo json_encode(array('success' => false, 'message' => 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่'), JSON_UNESCAPED_UNICODE);
	exit();
}

include __DIR__ . '/dbconnect.php';

$keyword = isset($_GET['q']) && !is_array($_GET['q']) ? (string)$_GET['q'] : '';
$company = isset($_GET['company']) && $_GET['company'] === 'NBM' ? 'NBM' : 'AWL';

try {
	$rows = smp_search_products($conn, $keyword, $company);
	echo json_encode(array(
		'success'  => true,
		'items'    => array_slice($rows, 0, SMP_PRODUCT_SEARCH_LIMIT),
		'has_more' => count($rows) > SMP_PRODUCT_SEARCH_LIMIT,
	), JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
	error_log('[ajax_smp_product] ' . $e->getMessage());
	http_response_code(500);
	echo json_encode(array('success' => false, 'message' => 'ไม่สามารถค้นหาสินค้าได้ กรุณาลองใหม่อีกครั้ง'), JSON_UNESCAPED_UNICODE);
}
