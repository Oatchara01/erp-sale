<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$vendor_id = $_POST["vendor_id"];
$vendor_group_code  = $_POST["vendor_group_code"];
$vendor_group_name = $_POST["vendor_group_name"];
$vendor_code = $_POST["vendor_code"];
$prefix = $_POST["prefix"];
$vendor_name_th = $_POST["vendor_name_th"];
$vendor_code_old = $_POST["vendor_code_old"];
$currency = $_POST["currency"];
$account_payable_code = $_POST["account_payable_code"];
$account_payable_name = $_POST["account_payable_name"];
$condition_id = $_POST["condition_id"];
$pur_group_code = $_POST["pur_group_code"];
$pur_group_name = $_POST["pur_group_name"];
$tax_number = $_POST["tax_number"];
$telephone_number1 = $_POST["telephone_number1"];
$telephone_number2 = $_POST["telephone_number2"];
$mobile_number = $_POST["mobile_number"];
$fax = $_POST["fax"];
$email = $_POST["email"];
$website = $_POST["website"];
$contact_number = $_POST["contact_number"];
$contact_prefix = $_POST["contact_prefix"];
$contact_name = $_POST["contact_name"];
$contact_position = $_POST["contact_position"];
$description = $_POST["description"];
$contact_telephone1 = $_POST["contact_telephone1"];
$contact_telephone2 = $_POST["contact_telephone2"];
$contact_mobile = $_POST["contact_mobile"];
$contact_fax = $_POST["contact_fax"];
$contact_email = $_POST["contact_email"];
$buiding = $_POST["buiding"];
$house_number = $_POST["house_number"];
$village_no = $_POST["village_no"];
$alley = $_POST["alley"];
$road = $_POST["road"];
$district = $_POST["district"];
$area = $_POST["area"];
$province = $_POST["province"];
$post_code = $_POST["post_code"];
$country = $_POST["country"];
$tax_id = $_POST["tax_id"];




$save="Update  tb_vendor set 

vendor_group_code='".$vendor_group_code."',vendor_group_name='".$vendor_group_name."',vendor_code='".$vendor_code."',prefix='".$prefix."',vendor_name_th='".$vendor_name_th."',vendor_code_old='".$vendor_code_old."',currency='".$currency."',account_payable_code='".$account_payable_code."',account_payable_name='".$account_payable_name."',condition_id='".$condition_id."',pur_group_code='".$pur_group_code."',pur_group_name='".$pur_group_name."',tax_number='".$tax_number."',telephone_number1='".$telephone_number1."',telephone_number2='".$telephone_number2."',mobile_number='".$mobile_number."',fax='".$fax."',email='".$email."',website='".$website."',contact_number='".$contact_number."',contact_prefix='".$contact_prefix."',contact_name='".$contact_name."',contact_position='".$contact_position."',description='".$description."',contact_telephone1='".$contact_telephone1."',contact_mobile='".$contact_mobile."',contact_fax='".$contact_fax."',contact_email='".$contact_email."',house_number='".$house_number."',buiding='".$buiding."',village_no='".$village_no."',alley='".$alley."',road='".$road."',district='".$district."',area='".$area."',province='".$province."',post_code='".$post_code."',country='".$country."',tax_id='".$tax_id."',contact_telephone2='".$contact_telephone2."' where vendor_id = '".$vendor_id."' ";


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