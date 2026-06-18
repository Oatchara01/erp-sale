<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$customer_name = $_POST["customer_name"];
$type_customer = $_POST["type_customer"];
$preface_name = $_POST["preface_name"];
$cus_address = $_POST["cus_address"];
$cus_ampher = $_POST["cus_ampher"];
$cus_province = $_POST["cus_province"];
$cus_postcode = $_POST["cus_postcode"];
$cus_tel = $_POST["cus_tel"];
$cus_fax = $_POST["cus_fax"];
$bill_name = $_POST["bill_name"];
$bill_address = $_POST["bill_address"];
$bill_ampher = $_POST["bill_ampher"];
$billl_province = $_POST["billl_province"];
$bill_postcode = $_POST["bill_postcode"];
$bill_tel = $_POST["bill_tel"];
$tax_id = $_POST["tax_id"];
$delivery_name = $_POST["delivery_name"];
$del_address = $_POST["del_address"];
$del_ampher = $_POST["del_ampher"];
$del_province = $_POST["del_province"];
$del_postcode = $_POST["del_postcode"];
$del_tel = $_POST["del_tel"];
$contact_name = $_POST["contact_name"];
$sale_code = $_POST["sale_code"];
$id = $_POST["id"];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";	
$email_cus = $_POST["email_cus"];	
$vip_ckk = $_POST["vip_ckk"];	
$credit_ckk = $_POST["credit_ckk"];	


$save=" Update  tb_customer_pre set 
customer_name='".$customer_name."',type_customer='".$type_customer."',preface_name='".$preface_name."',cus_address='".$cus_address."',cus_ampher='".$cus_ampher."',cus_province='".$cus_province."',cus_postcode='".$cus_postcode."',cus_tel='".$cus_tel."',cus_fax='".$cus_fax."',delivery_name='".$delivery_name."',del_address='".$del_address."',del_ampher='".$del_ampher."',del_province='".$del_province."',del_postcode='".$del_postcode."',del_tel='".$del_tel."',contact_name='".$contact_name."',sale_code= '".$sale_code."',bill_name='".$bill_name."',bill_address='".$bill_address."',bill_ampher='".$bill_ampher."',billl_province='".$billl_province."',bill_postcode='".$bill_postcode."',bill_tel='".$bill_tel."',tax_id='".$tax_id."',email_cus='".$email_cus."',vip_ckk='".$vip_ckk."',credit_ckk='".$credit_ckk."'   where id='".$id."'";

$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='edit_allwell_customer.php?id=$id'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>