<?php
session_start();

include"dbconnect.php"; 
$sale_code = $_SESSION['code'];
//echo $sale_code;
$strProduct = trim($_POST["product_code"]);

$strSQL = "SELECT * FROM tb_product WHERE access_code = '".$strProduct."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
	
	
	
if($sale_code=='S31' or $sale_code=='(SOL99)' or $sale_code=='SOL3' or $sale_code=='(SOL2)' or $sale_code=='(SOL1)' or $sale_code=='SOL4' or $sale_code=='SOL5' or $sale_code=='SOL3'){
$war_hc= $objResult["war_hc"];	
$unit_hc = $objResult["unit_hc"];
$vvv = 	"$war_hc $unit_hc";
}else{
$war_hc= $objResult["war_hos"];	
$unit_hc = $objResult["unit_hos"];
$vvv = 	"$war_hc $unit_hc";
}
	
echo $objResult["product_ID"]."|".$objResult["sol_name"]."|".$objResult["unit_name"]."|".$objResult["sol_price"]."|".'0'."|".$vvv."|".$objResult["product_type"];

}

?>


