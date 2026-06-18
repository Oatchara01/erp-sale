<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["rental_id"]);

$strSQL = "SELECT * FROM tb_customer WHERE customer_id = '".$strProduct."' ";

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
	
echo $objResult["customer_id"]."|".$objResult["bill_name"]."|".$objResult["bill_tel"]."|".$objResult["rental_emer"]."|".$objResult["rental_emertel"]."|".$objResult["bill_postcode"]." ".$objResult["bill_ampher"]." ".$objResult["billl_province"]." ".$objResult["rental_postcode"]."|".$objResult["install_address"]."|".$objResult["bill_name"]."|".$objResult["bill_address"]." ".$objResult["bill_ampher"]." ".$objResult["billl_province"]." ".$objResult["bill_postcode"]."|".$objResult["bill_tel"]."|".$objResult["tax_id"]."|".$objResult["delivery_name"]."|".$objResult["del_tel"]."|".$objResult["patient_name"]."|".$objResult["del_address"]." ".$objResult["del_ampher"]." ".$objResult["del_province"]." ".$objResult["del_postcode"]."|".trim($objResult["del_province"]);


	
}

?>


