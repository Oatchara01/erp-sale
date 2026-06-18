<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["product_codet"]);

$strSQL = "SELECT * FROM tb_product WHERE sol_code = '".$strProduct."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
echo $objResult["product_ID"]."|".$objResult["access_name"]."|".$objResult["unit_name"]."|".$objResult["sol_price"]."|".'0';

}

?>


