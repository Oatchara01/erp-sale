<?php
include "dbconnect.php";
include ('head.php');


  $ref_id = $_GET['ref_id'];
  $sale_code = $_GET['sale_code'];
  $name =  $_SESSION['name'];
  $surname =	$_SESSION['surname'];
  $add_by = "$name $surname";
  $add_date = date('Y-m-d H:i:s');


$sql = "SELECT * FROM hos__consig where ref_id = '".$ref_id."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$customer = $_POST["customer"];
$code =  $_SESSION['code'];

/*if($code=='S31' or $code=='S32'){
$save="Update  hos__consig set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',status_doc='Pending review'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
}else{*/
$save="Update  hos__consig set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
//}

 if($qsave){
	 
	
//พี่เปิ้ล

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

$sToken = "gCe7s6XlzcHFCtuVNBF2D2g6xbZZS7PrmPz5vpQBc6G";
$sMessage = "
มีการขออนุมัติเอกสารใบยืมฝากขาย
เลขที่อ้างอิง : $ref_id
ลูกค้า : $customer
เปิดโดย : $add_by
รบกวนทำการตรวจสอบข้อมูล และทำการอนุมัติ
ตามลิงค์ด้านล่างได้เลยคะ
https://sol.allwellcenter.com/status_approvebrsc.php		
			 
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
curl_close( $chOne ); */  	 
	 
	 
	 
echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_brcshos_edit.php?ref_id=$ref_id';";
echo "</script>";
	 
	 
	 
 }else{
   echo "Cannot";
  }
	

	
?>
