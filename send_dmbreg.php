<?php
include "dbconnect.php";
include "head.php";

$ref_id = $_GET['ref_id'];
$customer_name = $_GET['customer_name'];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = $_GET['add_by'];
$sup_name = "$name $surname";
 

$save="Update  hos__breg set send_sup ='1',status_doc='Request',sup_name='".$sup_name."',sup_date='".$add_date."',send_dm='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 

//พี่โจ้
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

$sToken = "I9fEDAgfYAuSbsHACVyUDUPbAJhVMB9LY554hBZiNWH";
$sMessage = "มีใบขอเบิกอะไหล่จากสินค้าขาย (BREG)
			เลขที่อ้างอิง : $ref_id 
			ลูกค้า : $customer_name
			เปิดโดย : $add_by
			อนุมัติโดย : $name $surname
			รบกวนทำการตรวจสอบข้อมูล และทำการอนุมัติ
			ตามลิงค์ด้านล่างได้เลยคะ
			https://sol.allwellcenter.com/status_dmbreg_app.php		
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
//echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne );  	


//พี่เปิ้ล
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

$sToken = "gCe7s6XlzcHFCtuVNBF2D2g6xbZZS7PrmPz5vpQBc6G";
$sMessage = "มีใบขอเบิกอะไหล่จากสินค้าขา (BREG)
			เลขที่อ้างอิง : $ref_id 
			ลูกค้า : $customer_name
			เปิดโดย : $add_by
			อนุมัติโดย : $name $surname
			รบกวนทำการตรวจสอบข้อมูล และทำการอนุมัติ
			ตามลิงค์ด้านล่างได้เลยคะ
			https://sol.allwellcenter.com/status_dmbreg_app.php			
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
//echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne );  	

 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ผู้บริหารเรียบร้อยแล้วค่ะ');window.location='register_breg_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>