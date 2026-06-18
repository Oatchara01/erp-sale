<?php


include("dbconnect.php");
include ("error_page.php"); 
include("head.php");



date_default_timezone_set("Asia/Bangkok");

	
	

$ref_id = $_GET["ref_id"];
$sale_code = $_GET['sale_code'];
$add_by = $_GET['add_by'];
$month =	date("m");
$yearto = date("Y")+543;
$yearsave = date("Y");
$today_save = "$yearsave-$month";

	

$strSQL = "UPDATE st__checkbr SET send_stock='1',status_doc ='Approve'  where ref_id ='".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL);	



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "tOHxEbD7gJACXMisdGBMAzQ9g7oYLlIaA6Mfhjbon9Z"; //Line ERP Stock
//$sToken	="CMXUBCXx0tXyGUKwsShIQ4j66thdHOm6iD3MsQlmmIU";
$sMessage = "มีการตรวจเช็ครายการใบยืมประจำเดือน $month-$yearto
เขตการขาย : $sale_code
ตรวจเช็คโดย : $add_by
รบกวนทางคลังสินค้าตรวจสอบได้ทางลิงค์ด้านล่างค่ะ
https://stock.allwellcenter.com/
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



 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_appckkst.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	

