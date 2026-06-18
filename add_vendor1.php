<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$vendor_group_code  = $_GET["vendor_group_code"];
$vendor_group_name = $_GET["vendor_group_name"];
$vendor_code = $_GET["vendor_code"];
$prefix = $_GET["prefix"];
$vendor_name_th = $_GET["vendor_name_th"];
$vendor_code_old = $_GET["vendor_code_old"];
$currency = $_GET["currency"];
$account_payable_code = $_GET["account_payable_code"];
$account_payable_name = $_GET["account_payable_name"];
$condition_id = $_GET["condition_id"];
$pur_group_code = $_GET["pur_group_code"];
$pur_group_name = $_GET["pur_group_name"];
$tax_number = $_GET["tax_number"];
$telephone_number1 = $_GET["telephone_number1"];
$telephone_number2 = $_GET["telephone_number2"];
$mobile_number = $_GET["mobile_number"];
$fax = $_GET["fax"];
$email = $_GET["email"];
$website = $_GET["website"];
$contact_number = $_GET["contact_number"];
$contact_prefix = $_GET["contact_prefix"];
$contact_name = $_GET["contact_name"];
$contact_position = $_GET["contact_position"];
$description = $_GET["description"];
$contact_telephone1 = $_GET["contact_telephone1"];
$contact_telephone2 = $_GET["contact_telephone2"];
$contact_mobile = $_GET["contact_mobile"];
$contact_fax = $_GET["contact_fax"];
$contact_email = $_GET["contact_email"];
$buiding = $_GET["buiding"];
$house_number = $_GET["house_number"];
$village_no = $_GET["village_no"];
$alley = $_GET["alley"];
$road = $_GET["road"];
$district = $_GET["district"];
$area = $_GET["area"];
$province = $_GET["province"];
$post_code = $_GET["post_code"];
$country = $_GET["country"];
$tax_id = $_GET["tax_id"];




$save="insert into tb_vendor
(vendor_group_code,vendor_group_name,vendor_code,prefix,vendor_name_th,vendor_code_old,currency,account_payable_code,account_payable_name,condition_id,pur_group_code,pur_group_name,tax_number,telephone_number1,telephone_number2,mobile_number,fax,email,website,contact_number,contact_prefix,contact_name,contact_position,description,contact_telephone1,contact_mobile,contact_fax,contact_email,house_number,buiding,village_no,alley,road,district,area,province,post_code,country,tax_id,contact_telephone2)
values
('".$vendor_group_code."','".$vendor_group_name."','".$vendor_code."','".$prefix."','".$vendor_name_th."','".$vendor_code_old."','".$currency."','".$account_payable_code."','".$account_payable_name."','".$condition_id."','".$pur_group_code."','".$pur_group_name."','".$tax_number."','".$telephone_number1."','".$telephone_number2."','".$mobile_number."','".$fax."','".$email."','".$website."','".$contact_number."','".$contact_prefix."','".$contact_name."','".$contact_position."','".$description."','".$contact_telephone1."','".$contact_mobile."','".$contact_fax."','".$contact_email."','".$house_number."','".$buiding."','".$village_no."','".$alley."','".$road."','".$district."','".$area."','".$province."','".$post_code."','".$country."','".$tax_id."','".$contact_telephone2."')";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_vendor.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>