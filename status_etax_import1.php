<?php

include ("head.php");
date_default_timezone_set("Asia/Bangkok");

include("dbconnect.php");
if ($_GET["submit"] = "submit") {
$ref_id  = $_GET["ref_id"];
$id  = $_GET["id"];

$add_date = date('Y-m-d H:i:s');

$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$emid =  $_SESSION['emid'];
$add_by = "$name $surname";
	

	
	
 foreach($id as $key =>$value)
	{
		$id_new = $id[$key];
		$ref_id_new = $ref_id[$key];
        
	 
$strSQL = "SELECT * FROM tb_customer_etax WHERE ref_id = '".$ref_id_new."'";
$objQuery = mysqli_query($conn,$strSQL) or die("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);


$order_id = $objResult["order_id"];
$tax_id = $objResult["tax_id"];
$head_name = $objResult["head_name"];
$last_name = $objResult["last_name"];
$address = $objResult["address"];
$sub_district = $objResult["sub_district"];
$district = $objResult["district"];
$province = $objResult["province"];
$postcode = $objResult["postcode"];
$tel_num = $objResult["tel_num"];
$mail_cus = $objResult["mail_cus"];
$customer_name = "$head_name $last_name";
$address_name = "$address $sub_district $district $province $postcode";
$ex_add = "$address $sub_district";

if($objResult["order_id"]!=''){
	
$strSQL1 = "SELECT * FROM so__main WHERE order_id = '".$objResult["order_id"]."'";
	// echo $strSQL1;
$objQuery1 = mysqli_query($conn,$strSQL1) or die("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);


if($Num_Rows1 > 0){

$strSQL70 = "UPDATE so__main SET billing_name='".$customer_name."',billing_address='".$address_name."',ex_add='".$ex_add."',ex_aumper='".$district."',ex_provin='".$province."',ex_post='".$postcode."',tax_id='".$tax_id."',email='".$mail_cus."',import_etax='1',billing_tel='".$tel_num."' where order_id = '".$objResult["order_id"]."' ";
//echo $strSQL70;	
$objQuery70 = mysqli_query($conn,$strSQL70);	

	
$strSQL71 = "UPDATE tb_customer_etax SET import_order='1',import_date='".$add_date."',import_by='".$add_by."' where ref_id ='".$ref_id_new."' ";
$objQuery71 = mysqli_query($conn,$strSQL71);	
	
}else{
$strSQL71 = "UPDATE tb_customer_etax SET import_order='2',import_date='".$add_date."',import_by='".$add_by."' where ref_id ='".$ref_id_new."' ";
$objQuery71 = mysqli_query($conn,$strSQL71);	


}
	
}
 }
	

//exit();



if($objQuery71){

echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_etaxcustomeryes.php';";
echo "</script>";

  } else {
   echo "Cannot";
  }

	
}
?>