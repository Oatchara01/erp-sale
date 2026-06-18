<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["product_id"]);

$strSQL = "SELECT * FROM tb_product WHERE product_id = '".$strProduct."' ";

//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
echo $objResult["express_code"]."|".$objResult["express_name"];

}

?>
