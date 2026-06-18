<?php
include "dbconnect.php";
include ('head.php');


  $ref_id = $_GET['ref_id'];
  $sale_code = $_GET['sale_code'];
  $name =  $_SESSION['name'];
  $surname =	$_SESSION['surname'];
  $add_by = "$name $surname";
  $add_date = date('Y-m-d H:i:s');
  $approve_date = date('Y-m-d');
  $approve_time = date('H:i:s');


 $save="Update  st__main_new set status_doc='Rejected',cm_name='".$add_by."',cm_date='".$add_date."'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($new,$save);


$strSQL = "SELECT *  FROM st__main_new WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($new,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$edit_remark = $objResult["edit_remark"];
$iv_no  = $objResult["iv_no"];
	
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "SiNB5SbYAHeSYl0M9ME4nBG5sQnPTSZespxzsikXwAz";
$sMessage = "
มีข้อมูลการปรับปรุงรายการตัดสต็อก ได้รับการ Rejected
เลขที่เอกสาร : $iv_no
รายละเอียดการแก้ไข : $edit_remark
Rejected โดย : $add_by

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



 

 if($qsave){
	 
echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_apprefst.php';";
echo "</script>";	 
	 
 }else{
   echo "Cannot";
  }
	

	
?>
