<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$customer_code = $_POST["customer_code"];
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
$customer_id = $_POST["customer_id"];
$ckk_chnge = $_POST["ckk_chnge"];
$remark_edit = $_POST["remark_edit"];
$remark_cus = $_POST["remark_cus"];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";	
$email_cus = $_POST["email_cus"];	
$vip_ckk = $_POST["vip_ckk"];		


$save=" Update  tb_customer set 
customer_name='".$customer_name."',type_customer='".$type_customer."',preface_name='".$preface_name."',cus_address='".$cus_address."',cus_ampher='".$cus_ampher."',cus_province='".$cus_province."',cus_postcode='".$cus_postcode."',cus_tel='".$cus_tel."',cus_fax='".$cus_fax."',delivery_name='".$delivery_name."',del_address='".$del_address."',del_ampher='".$del_ampher."',del_province='".$del_province."',del_postcode='".$del_postcode."',del_tel='".$del_tel."',contact_name='".$contact_name."',sale_code= '".$sale_code."',bill_name='".$bill_name."',bill_address='".$bill_address."',bill_ampher='".$bill_ampher."',billl_province='".$billl_province."',bill_postcode='".$bill_postcode."',bill_tel='".$bill_tel."',tax_id='".$tax_id."',edit_date='".$add_date."',edit_name='".$add_by."',email_cus='".$email_cus."',vip_ckk='".$vip_ckk."'   where customer_id='".$customer_id."'";

$qsave=mysqli_query($conn,$save);

if($ckk_chnge=='1'){
	

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken	='3mN5wuBOGBEH7SOjDZWIpqRsr2BRUQYRb7RDj7yRnYl';
$sMessage = "มีการแก้ไขข้อมูลลูกค้า 
ID :  $customer_id
ชื่อลูกค้า : $customer_name
เบอร์โทร : $cus_tel
ส่วนที่แก้ไข : $remark_edit
แก้ไขโดย : $add_by
แก้ไขเวลา : $add_date
สามารถตรวจสอบได้ที่ https://sol.allwellcenter.com/
";
$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt( $chOne, CURLOPT_POST, 1);
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
if(curl_error($chOne))
{
//echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
//echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne ); 			


}






 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_customerallwell.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>