<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["customer"]);

$strSQL = "SELECT * FROM tb_customer WHERE bill_name = '".$strProduct."' ";

//echo $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
	echo $objResult["bill_address"]."|".$objResult["bill_tel"];

}
?>
