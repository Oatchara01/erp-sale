<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["rental_id"]);

$strSQL = "SELECT * FROM tb_customer WHERE customer_id = ? ";

$stmt = mysqli_prepare($conn, $strSQL);
mysqli_stmt_bind_param($stmt, "s", $strProduct);
mysqli_stmt_execute($stmt);
$objQuery = mysqli_stmt_get_result($stmt);
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
	
echo $objResult["customer_id"]."|".$objResult["bill_name"]."|".$objResult["bill_tel"]."|".$objResult["rental_emer"]."|".$objResult["rental_emertel"]."|".$objResult["bill_postcode"]." ".$objResult["bill_ampher"]." ".$objResult["billl_province"]." ".$objResult["rental_postcode"]."|".$objResult["install_address"]."|".$objResult["bill_name"]."|".$objResult["bill_address"]." ".$objResult["bill_ampher"]." ".$objResult["billl_province"]." ".$objResult["bill_postcode"]."|".$objResult["bill_tel"]."|".$objResult["tax_id"]."|".$objResult["delivery_name"]."|".$objResult["del_tel"]."|".$objResult["patient_name"]."|".$objResult["del_address"]." ".$objResult["del_ampher"]." ".$objResult["del_province"]." ".$objResult["del_postcode"]."|".trim($objResult["del_province"])."|".$objResult["rental_address"]."|".$objResult["rental_ampher"]."|".$objResult["rental_province"]."|".$objResult["rental_postcode"];


	
}

?>


