<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["product_code"]);

$strSQL = "SELECT * FROM tb_product WHERE access_code = '".$strProduct."' ";
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
$war_hc= $objResult["war_hc"];	
$unit_hc = $objResult["unit_hc"];
$vvv = 	"$war_hc $unit_hc";	
	
echo $objResult["product_ID"]."|".$objResult["sol_name"]."|".$objResult["unit_name"]."|".$objResult["sol_price"]."|".'0'."|".$vvv;

}

?>


