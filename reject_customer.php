<?php
include "dbconnect.php";
include "dbconnect_acc.php";
include('head.php'); 


$id = $_POST['id'];
$remark_c = $_POST['remark_c'];
$add_date = date('Y-m-d H:i:s');

$strSQL = "SELECT *  FROM tb_customer_pre WHERE id = '".$_GET["id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL28="Update  tb_customer_pre set status_cus='Rejected',app_dt='".$add_date."',remark_c='".$remark_c."'  where id ='".$id."'";
$objQuery28 = mysqli_query($conn,$strSQL28);

$eng_ckk = $objResult["eng_ckk"];
$customer_name = $objResult["customer_name"];
$cus_tel = $objResult["cus_tel"];
$add_by = $objResult["add_by"];

if($eng_ckk=='1'){

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "I58DQDNu3uL98AgqBCHOoHSxtJdYW7rgSiDoOJh1iXL";
$sMessage = "ข้อมูลลูกค้าถูกยกเลิกการเพิ่มในฐานข้อมูลค่ะ
ลูกค้า : $customer_name
เบอร์โทร : $cus_tel
หมายเหตุ : $remark_c
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
echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne ); 	
	
}else{
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "splHVf4D6589XzmoEzXCwDWzD6xbkellO8csGiWMrFX";
$sMessage = "ข้อมูลลูกค้าถูกยกเลิกการเพิ่มในฐานข้อมูลค่ะ
ลูกค้า : $customer_name
เบอร์โทร : $cus_tel
หมายเหตุ : $remark_c
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
echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne ); 

}
 
 if($objQuery28){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Admin เรียบร้อยแล้วค่ะ');window.location='status_customerapp.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>