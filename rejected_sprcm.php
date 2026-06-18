<?php
include('head.php'); 
include "dbconnect.php";


 $ref_id = $_POST['ref_id'];
$reject_remark = $_POST["reject_remark"];
 $name = $_SESSION["name"];
 $today= date('Y-m-d');
$add_date = date('Y-m-d H:i:s');




$save="Update  hos__spr set cm_name='".$name."',cm_date='".$today."',status_doc='Rejected',send_stock='1',reject_remark='".$reject_remark."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "fegIDIJydjtHD4hnlPm1D4zMkAMQ0GQdbOHZlcwwY7y";
$sMessage = "มีรายการเอกสาร SPR ได้รับการ Rejected
เลขที่อ้างอิง : $ref_id
รายละเอียด : $reject_remark
Rejected โดย : $name
วันที่ : $today

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


//exit();
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้วค่ะ');window.location='status_appspr_cm.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>