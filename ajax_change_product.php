<?php

/**
 * ค้นสินค้าสำหรับช่องค้นหาของ partials/product_table_change.php (register_supchange.php) — ตอบ JSON
 *   GET q       = คำค้น (รหัส / ชื่อไทย / ชื่ออังกฤษ)
 *   GET company = AWL | NBM
 *   GET dept    = eng | sale (แผนกวิศวกรรมใช้ engineer_ckk, นอกนั้นใช้ sale_ckk)
 * เงื่อนไขเดียวกับ data_product_hos_ptc.php / data_product_eng_ptc.php:
 * close_pro = 0 และตัดกลุ่ม 8001/8002 (ไม่ตัดสินค้าเดโม)
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

const CHANGE_PRODUCT_SEARCH_LIMIT = 50;

$keyword = isset($_GET['q']) && !is_array($_GET['q']) ? trim((string)$_GET['q']) : '';
$company = isset($_GET['company']) && $_GET['company'] === 'NBM' ? 'NBM' : 'AWL';
$deptColumn = (isset($_GET['dept']) && $_GET['dept'] === 'eng') ? 'engineer_ckk' : 'sale_ckk';

try {
	$rows = array();
	if ($keyword !== '') {
		$stmt = mysqli_prepare($conn, "SELECT product_ID, access_code, sol_name, access_name
			FROM tb_product
			WHERE $deptColumn = '1' AND close_pro = '0' AND type_company = ? AND group1 NOT IN (8001, 8002)
				AND (LOCATE(?, access_code) > 0 OR LOCATE(?, sol_name) > 0 OR LOCATE(?, access_name) > 0)
			ORDER BY (LOCATE(?, access_code) = 1) DESC, access_code ASC
			LIMIT " . (CHANGE_PRODUCT_SEARCH_LIMIT + 1));
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
		'items'    => array_slice($rows, 0, CHANGE_PRODUCT_SEARCH_LIMIT),
		'has_more' => count($rows) > CHANGE_PRODUCT_SEARCH_LIMIT,
	), JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
	error_log('[ajax_change_product] ' . $e->getMessage());
	http_response_code(500);
	echo json_encode(array('success' => false, 'message' => 'ไม่สามารถค้นหาสินค้าได้ กรุณาลองใหม่อีกครั้ง'), JSON_UNESCAPED_UNICODE);
}
