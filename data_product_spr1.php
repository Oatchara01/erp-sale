<?php

/**
 * ค้นหาสินค้าตามรหัส สำหรับตารางรายการสินค้าแบบ dynamic ของ register_engspr.php
 * มิเรอร์ data_product_hos1.php (ที่ register_bregawl.php ใช้) แต่ไม่ตัดกลุ่มสินค้า
 * ใด ๆ ออก (group1 NOT IN (...) ของ BREG เป็นกติกาเฉพาะของ BREG ไม่ใช่ของ SPR)
 */

session_start();

include "dbconnect.php";

$strProduct = isset($_POST['product_code']) ? trim((string)$_POST['product_code']) : '';
$typeCompany = (isset($_POST['type_company']) && $_POST['type_company'] === 'NBM') ? 'NBM' : 'AWL';

header('Content-Type: application/json; charset=utf-8');

if ($strProduct === '') {
	echo json_encode(array('found' => false), JSON_UNESCAPED_UNICODE);
	exit();
}

$stmt = mysqli_prepare($conn, "SELECT product_ID, access_code, sol_name, unit_name, sol_price FROM tb_product WHERE access_code = ? AND type_company = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'ss', $strProduct, $typeCompany);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = $result ? mysqli_fetch_assoc($result) : null;
mysqli_stmt_close($stmt);

if (!$row) {
	echo json_encode(array('found' => false), JSON_UNESCAPED_UNICODE);
	exit();
}

echo json_encode(array(
	'found'       => true,
	'product_ID'  => $row['product_ID'],
	'access_code' => $row['access_code'],
	'sol_name'    => $row['sol_name'],
	'unit_name'   => $row['unit_name'],
	'sol_price'   => $row['sol_price'],
), JSON_UNESCAPED_UNICODE);
