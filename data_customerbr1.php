<?php


include"dbconnect.php";
include_once __DIR__ . '/includes/address_tumbon.php';

$strProduct = trim($_POST["customer_id"]);

$strSQL = "SELECT * FROM tb_customer WHERE customer_id = '".$strProduct."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{

$strSQL1 = "SELECT type_name FROM tb_typecustomer WHERE type_id = '".$objResult["type_customer"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);

// ตำบล: ที่อยู่ลูกค้าใช้ cus_addtum, ที่อยู่จัดส่งรวม (index 11) ใช้แถวหลักใน tb_customer_shipping_address
$cus_street = address_append_tumbon($objResult["cus_address"], $objResult["cus_addtum"]);
$del_street = address_append_tumbon($objResult["del_address"], address_primary_tumbon($conn, $objResult["customer_id"], 'shipping'));
$delivery = $del_street." ".$objResult["del_ampher"]." จ.".$objResult["del_province"]." ".$objResult["del_postcode"];

echo $objResult["preface_name"]." ".$objResult["customer_name"]."|".$cus_street." ".$objResult["cus_ampher"]." ".$objResult["cus_province"]." ".$objResult["cus_postcode"]."|".$objResult1["type_name"]."|".$objResult["cus_tel"]."|".$objResult["vip_ckk"]."|".$objResult["del_address"]."|".$objResult["del_ampher"]."|".$objResult["del_province"]."|".$objResult["del_postcode"]."|".$objResult["contact_name"]."|".$objResult["del_tel"]."|".$delivery;

}

?>
