<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["bill_id"]);

$strSQL = "SELECT * FROM tb_customer WHERE customer_id = '".$strProduct."' ";

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
	
$strSQL1 = "SELECT type_name FROM tb_typecustomer WHERE type_id = '".$objResult["type_customer"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);		
	
	
	$del_address =$objResult["cus_address"];
	$del_ampher = $objResult["cus_ampher"];
	$del_province =$objResult["cus_province"];
	$del_postcode=$objResult["cus_postcode"];
	$delivery ="$del_address $del_ampher $del_province $del_postcode";
	
echo $objResult["customer_name"]."|".$objResult["cus_tel"]."|". $delivery."|".$objResult1["type_name"];

}

?>


