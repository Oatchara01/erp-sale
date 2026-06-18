<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["customer_id"]);

$strSQL = "SELECT * FROM tb_customer WHERE customer_id = '".$strProduct."' ";

//echo $strSQL;
//exit();
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
echo $objResult["preface_name"]." ".$objResult["customer_name"]."|".$objResult["cus_address"]." ".$objResult["cus_ampher"]." ".$objResult["cus_province"]." ".$objResult["cus_postcode"]."|".$objResult["cus_tel"]."|".$objResult["mode_name"];

}

?>
