<?php
include "dbconnect.php";
include('head.php');
date_default_timezone_set("Asia/Bangkok");

  $ref_idsmp = $_GET['ref_idsmp'];
  $comment_sup = $_GET['comment_sup'];
  $sup_date = date('Y-m-d');
  $sup_name = $_SESSION['name'];

 $save="Update  hos__smp set status_sup ='Rejected',sup_date='".$sup_date."',sup_name='".$sup_name."'  where ref_idsmp = '".$ref_idsmp."' ";


$qsave=mysqli_query($conn,$save);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "c6gZRntzPXqNfkL24XxFBJla6cGZx2642GYnMWM56Mi";
$sMessage = "ใบเบิกสินค้า (SMP) หมายเลขอ้างอิง $ref_idsmp ได้ทำารยกเลิกเอกสารค่ะ";
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

 
 
if($qsave) {

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_samplesup.php';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
