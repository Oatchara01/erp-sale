<?php
session_start();

include "dbconnect.php";

/* Detail lookup เฉพาะตอนเลือกสินค้าใน partials/product_table_change.php
   บังคับ filter เดียวกับ autocomplete (data_product_hos_ptc.php / data_product_eng_ptc.php):
   close_pro='0', group1 NOT IN (8001,8002) และสิทธิ์ตามแผนก (sale_ckk/engineer_ckk) */
$isEngDept = (($_SESSION["department"] ?? '') === 'วิศวกรรม');
$deptField = $isEngDept ? 'engineer_ckk' : 'sale_ckk';

$strProduct = trim($_POST["product_code"] ?? '');
$type_company = (isset($_POST['type_company']) && $_POST['type_company'] === 'NBM') ? 'NBM' : 'AWL';
$strProduct_escaped = mysqli_real_escape_string($conn, $strProduct);

header('Content-Type: application/json; charset=utf-8');

if ($strProduct === '') {
	echo json_encode(['found' => false]);
	exit;
}

$strSQL = "SELECT * FROM tb_product
	WHERE access_code = '$strProduct_escaped'
		AND type_company = '$type_company'
		AND close_pro = '0'
		AND group1 NOT IN (8002,8001)
		AND $deptField = '1'";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
$objResult = mysqli_fetch_array($objQuery);

if (!$objResult) {
	echo json_encode(['found' => false]);
	exit;
}

$war_hc = $objResult["war_hc"];
$unit_hc = $objResult["unit_hc"];
$vvv = "$war_hc $unit_hc";

echo json_encode([
	'found'        => true,
	'product_ID'   => $objResult["product_ID"],
	'sol_name'     => $objResult["sol_name"],
	'unit_name'    => $objResult["unit_name"],
	'sol_price'    => $objResult["sol_price"],
	'discount'     => '0',
	'remark_hc'    => $objResult["remark_hc"],
	'product_type' => $objResult["product_type"],
	'war_hc'       => $war_hc,
	'unit_hc'      => $unit_hc,
	'vvv'          => $vvv,
	'store'        => $objResult["store"],
	'store_remark' => $objResult["store_remark"]
], JSON_UNESCAPED_UNICODE);
