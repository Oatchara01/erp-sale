<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["customer"]);

$strSQL = "SELECT * FROM tb_customer WHERE customer_name = '".$strProduct."' ";

//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
echo $objResult["cus_address"]." ".$objResult["cus_ampher"]." ".$objResult["cus_province"]." ".$objResult["cus_postcode"]."|".'0';
}
?>
