<?php


include"dbconnect.php";
include_once __DIR__ . '/includes/address_tumbon.php';

$strProduct = trim($_POST["rental_id"]);

$strSQL = "SELECT * FROM tb_customer WHERE customer_id = ? ";

$stmt = mysqli_prepare($conn, $strSQL);
mysqli_stmt_bind_param($stmt, "s", $strProduct);
mysqli_stmt_execute($stmt);
$objQuery = mysqli_stmt_get_result($stmt);
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
	// ตำบล: บิล/จัดส่งรวม (index 8, 14) ใช้แถวหลักใน billing/shipping; ที่อยู่ผู้เช่า (index 16) ต่อ rental_addtum ท้าย เพราะใบเช่าไม่มีช่องตำบล
	$objResult["bill_address"] = address_append_tumbon($objResult["bill_address"], address_primary_tumbon($conn, $objResult["customer_id"], 'billing'));
	$objResult["del_address"] = address_append_tumbon($objResult["del_address"], address_primary_tumbon($conn, $objResult["customer_id"], 'shipping'));
	$objResult["rental_address"] = address_append_tumbon($objResult["rental_address"], isset($objResult["rental_addtum"]) ? $objResult["rental_addtum"] : '');

echo $objResult["customer_id"]."|".$objResult["bill_name"]."|".$objResult["bill_tel"]."|".$objResult["rental_emer"]."|".$objResult["rental_emertel"]."|".$objResult["bill_postcode"]." ".$objResult["bill_ampher"]." ".$objResult["billl_province"]." ".$objResult["rental_postcode"]."|".$objResult["install_address"]."|".$objResult["bill_name"]."|".$objResult["bill_address"]." ".$objResult["bill_ampher"]." ".$objResult["billl_province"]." ".$objResult["bill_postcode"]."|".$objResult["bill_tel"]."|".$objResult["tax_id"]."|".$objResult["delivery_name"]."|".$objResult["del_tel"]."|".$objResult["patient_name"]."|".$objResult["del_address"]." ".$objResult["del_ampher"]." ".$objResult["del_province"]." ".$objResult["del_postcode"]."|".trim($objResult["del_province"])."|".$objResult["rental_address"]."|".$objResult["rental_ampher"]."|".$objResult["rental_province"]."|".$objResult["rental_postcode"];


	
}

?>


