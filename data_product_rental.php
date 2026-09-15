<?php
include "dbconnect.php";

header('Content-Type: application/json; charset=utf-8');

$product_code = isset($_POST['product_code']) ? trim($_POST['product_code']) : '';
$product_code_escaped = mysqli_real_escape_string($conn, $product_code);

$type_company = isset($_POST['type_company']) ? trim($_POST['type_company']) : '';
if ($type_company !== 'NBM') {
	$type_company = 'AWL';
}
$type_company_escaped = mysqli_real_escape_string($conn, $type_company);

$sql = "SELECT * FROM tb_product
	WHERE access_code = '$product_code_escaped'
	AND group1 = '8001'
	AND type_company = '$type_company_escaped'
	AND close_pro = '0'
	LIMIT 1";
$result = mysqli_query($conn, $sql);
$product = $result ? mysqli_fetch_assoc($result) : null;

if (!$product) {
	echo json_encode(array('found' => false));
	exit;
}

$warranty = $product['war_hc'] . ' ' . $product['unit_hc'];

echo json_encode(array(
	'found' => true,
	'product_ID' => $product['product_ID'],
	'sol_name' => $product['sol_name'],
	'unit_name' => $product['unit_name'],
	'sol_price' => $product['sol_price'],
	'discount' => '0',
	'remark_hc' => $product['remark_hc'],
	'product_type' => $product['product_type'],
	'war_hc' => $product['war_hc'],
	'unit_hc' => $product['unit_hc'],
	'vvv' => $warranty,
	'store' => $product['store'],
	'store_remark' => $product['store_remark']
), JSON_UNESCAPED_UNICODE);
?>
