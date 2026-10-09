<?php

/**
 * ค้นสินค้าสำหรับช่องค้นหาของ register_receivepro.php — ตอบ JSON
 *   GET q       = คำค้น (รหัส / ชื่อไทย / ชื่ออังกฤษ)
 *   GET company = hos__proreceive.type_company (1 = AWL, 2 = NBM)
 */

require_once __DIR__ . '/includes/receivepro_repo.php';

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
$company = isset($_GET['company']) && !is_array($_GET['company']) ? (string)$_GET['company'] : '1';

try {
	$rows = rp_search_products($conn, $keyword, $company);
	$hasMore = count($rows) > RP_PRODUCT_SEARCH_LIMIT;
	echo json_encode(array(
		'success'  => true,
		'items'    => array_slice($rows, 0, RP_PRODUCT_SEARCH_LIMIT),
		'has_more' => $hasMore,
	), JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
	error_log('[data_receivepro_product] ' . $e->getMessage());
	http_response_code(500);
	echo json_encode(array('success' => false, 'message' => 'ไม่สามารถค้นหาสินค้าได้ กรุณาลองใหม่อีกครั้ง'), JSON_UNESCAPED_UNICODE);
}
