<?php
include "dbconnect.php";

  $billing_name = $_GET['billing_name'];
  $ref_id = $_GET['ref_id'];
   $save="Update  so__main set status_vat ='Approve'  where ref_id = '".$ref_id."' ";

$qsave=mysqli_query($conn,$save);
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "eURbpkews3haw5MK8gl27m1pC32FRcQfxmjCPyvL9eC";
$sMessage = "หมายเลขอ้างอิง $ref_id คุณ $billing_name ได้ทำการอนุมัติบิลเรียบร้อยแล้วค่ะ";
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

  

 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_supadmvat.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
?>