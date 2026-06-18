<?php include ("head.php"); ?>
<?php
include "dbconnect.php";

$name = $_SESSION["name"];

  $ref_id = $_GET['ref_id'];
   $save="Update  qou__main set send_sup ='1',status_doc='Request'  where ref_id = '".$ref_id."' ";

$qsave=mysqli_query($conn,$save);
 
 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "Gy2FZ5xYM44SimFmXM3cqFYAfGwS7XpXf3iHnfqdNZt";

//$sToken = "CMXUBCXx0tXyGUKwsShIQ4j66thdHOm6iD3MsQlmmIU";
$sMessage = "คุณ : $name มีการสร้างใบเสนอราคา
			เลขที่อ้างอิง : $ref_id
			รบกวนทำการตรวจสอบข้อมูล
			และอนุมัติการร้องขอ ตามลิงค์ด้านล่างได้เลยคะ
			https://sol.allwellcenter.com			
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
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_qou_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }

?>