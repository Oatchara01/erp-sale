<?php

/**
 * ค้นสินค้าเช่าสำหรับช่องค้นหาของ product_rentalawl.php (register_suprental / allwellrental / salerental) — ตอบ JSON
 *   GET q       = คำค้น (รหัส / ชื่อไทย / ชื่ออังกฤษ)
 *   GET company = AWL | NBM
 * เงื่อนไขเดียวกับ data_pro_rental.php: เฉพาะสินค้ากลุ่มเช่า (group1 = 8001) และ close_pro = 0
 */

session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	http_response_code(401);
	echo json_encode(array('success' => false, 'message' => 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่'), JSON_UNESCAPED_UNICODE);
	exit();
}

include __DIR__ . '/dbconnect.php';

const RENTAL_PRODUCT_SEARCH_LIMIT = 50;

$keyword = isset($_GET['q']) && !is_array($_GET['q']) ? trim((string)$_GET['q']) : '';
$company = isset($_GET['company']) && $_GET['company'] === 'NBM' ? 'NBM' : 'AWL';

try {
	$rows = array();
	if ($keyword !== '') {
		$stmt = mysqli_prepare($conn, "SELECT product_ID, access_code, sol_name, access_name
			FROM tb_product
			WHERE group1 = '8001' AND close_pro = '0' AND type_company = ?
				AND (LOCATE(?, access_code) > 0 OR LOCATE(?, sol_name) > 0 OR LOCATE(?, access_name) > 0)
			ORDER BY (LOCATE(?, access_code) = 1) DESC, sol_name ASC
			LIMIT " . (RENTAL_PRODUCT_SEARCH_LIMIT + 1));
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		mysqli_stmt_bind_param($stmt, 'sssss', $company, $keyword, $keyword, $keyword, $keyword);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		while ($result && ($row = mysqli_fetch_assoc($result))) {
			$rows[] = array(
				'product_id'  => (string)$row['product_ID'],
				'access_code' => (string)$row['access_code'],
				'sol_name'    => (string)$row['sol_name'],
				'access_name' => (string)$row['access_name'],
			);
		}
		mysqli_stmt_close($stmt);
	}
	echo json_encode(array(
		'success'  => true,
		'items'    => array_slice($rows, 0, RENTAL_PRODUCT_SEARCH_LIMIT),
		'has_more' => count($rows) > RENTAL_PRODUCT_SEARCH_LIMIT,
	), JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
	error_log('[ajax_rental_product] ' . $e->getMessage());
	http_response_code(500);
	echo json_encode(array('success' => false, 'message' => 'ไม่สามารถค้นหาสินค้าได้ กรุณาลองใหม่อีกครั้ง'), JSON_UNESCAPED_UNICODE);
}
