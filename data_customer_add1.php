<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["id_customer_run"]);

$strSQL = "SELECT * FROM tb_customer WHERE customer_id = '".$strProduct."' ";

//echo $strSQL;
//exit();
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
echo $objResult["customer_code"]."|".$objResult["customer_name"]."|".$objResult["type_customer"]."|".$objResult["credit"]."|".$objResult["bill_name"];

}

?>
