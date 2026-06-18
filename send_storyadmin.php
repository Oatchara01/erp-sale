<?php
include "dbconnect.php";
include "head.php";


  $id_story = $_GET['id_story'];
  $sale_code = $_GET['sale_code'];
  $customer_name = $_GET['customer_name'];
  $name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
//echo  $sale_code;
//exit();

$save="Update  tb_register_story set send_admin ='1'  where id_story = '".$id_story."' ";
$qsave=mysqli_query($conn,$save);
 




 
 if($qsave){  

	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "1B99f7Q2x3upAqGpl8ASgCufsAd4U32URULp8W8yNTJ";
$sMessage = "มีรายการรับเรื่องจากลูกค้า
ลูกค้า : $customer_name 
ส่งโดย : $add_by
วันที่ส่ง : $add_date
รบกวนตรวจสอบความถูกต้อง ใส่เขตการขาย และกดส่ง Sale ด้วยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com";

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

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_story_edit.php?id_story=$id_story';";
echo "</script>";


  

	

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_story_edit.php?id_story=$id_story';";
echo "</script>";
	
	}else{
   echo "Cannot";
  }

	

	
?>
