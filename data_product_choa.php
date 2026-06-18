<?php
session_start();

include"dbconnect.php"; 
$sale_code = $_SESSION['code'];
$strProduct = trim($_POST["product_code"]);

$strSQL = "SELECT * FROM tb_product WHERE access_code = '".$strProduct."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
	
echo $objResult["product_ID"]."|".$objResult["sol_name"]."|".$objResult["unit_name"]."|".$objResult["sol_price"]."|".$objResult["war_hc"];

}

?>


