<?php include('head.php'); ?>

<?php
include "dbconnect.php";


$ref_id = $_GET['ref_id'];
$name = $_SESSION["name"];
$add_date = date('Y-m-d H:i:s');


 $save="Update  no__complete set send_sup ='1',sup_date ='".$add_date."',status_doc ='Request'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);

$strSQL2 = "SELECT type_doc FROM  no__complete where ref_id = '".$ref_id."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

if($objResult2["type_doc"]=='1' or $objResult2["type_doc"]=='4'){
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

$sToken = "pFQSBbyDoRBQvmB4jH8JscxNXSvfAjXuOv8etUnxdvq";
$sMessage = "คุณ : $name มีการตรวจสอบใบส่งสินค้าไม่สมบูรณ์
			เลขที่อ้างอิง : $ref_id
			รบกวนทำการตรวจสอบข้อมูล
			และอนุมัติการร้องขอ ตามลิงค์ด้านล่างได้เลยคะ
			https://stock.allwellcenter.com			
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
	
}else if($objResult2["type_doc"]=='2' or $objResult2["type_doc"]=='3'){
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
//$sToken = "Gy2FZ5xYM44SimFmXM3cqFYAfGwS7XpXf3iHnfqdNZt";

$sToken = "fJmp59xxSbEpSOhABeXKryHsUUutmEZH4vQPsNZyDWn";
$sMessage = "คุณ : $name มีการตรวจสอบใบส่งสินค้าไม่สมบูรณ์
			เลขที่อ้างอิง : $ref_id
			รบกวนทำการตรวจสอบข้อมูล
			และอนุมัติการร้องขอ ตามลิงค์ด้านล่างได้เลยคะ
			https://allwellcenter.com/no_complete			
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

 
 
 if($qsave){
 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_editor_ad.php?ref_id=$ref_id';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
