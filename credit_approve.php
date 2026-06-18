<?php
include "dbconnect.php";
include "head.php";

  $ref_credit = $_GET['ref_credit'];
 $date_credit = $_GET['date_credit'];
  $sale_code = $_GET['sale_code'];
  $name = $_SESSION['name'];
 $add_date = date('Y-m-d');
$approve_datetime = date('Y-m-d H:i:s');

$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname"; 
$code =  $_SESSION['code'];

if($code=='SS5'){
	
$save="Update  tb_credit_note set send_sup ='1',examine_name='".$add_by."',examine_date='".$add_date."',status_doc='Request'  where ref_credit = '".$ref_credit."' ";
$qsave=mysqli_query($conn,$save);
	
}else{

$save="Update  tb_credit_note set send_dm ='1',approve_name='".$name."',approve_date='".$date_credit."',approve_datetime='".$approve_datetime."'  where ref_credit = '".$ref_credit."' ";
$qsave=mysqli_query($conn,$save);
 
}

            $fline=mysqli_fetch_array($line);
			$sToken = "gCe7s6XlzcHFCtuVNBF2D2g6xbZZS7PrmPz5vpQBc6G";
				
			$sMessage = "
			คุณ : $name มีการสร้างใบลดหนี้
			เลขที่อ้างอิง : $ref_credit
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
			if(curl_error($chOne)) {
				echo 'error:' . curl_error($chOne);
			}
			else {
				$result_ = json_decode($result, true);
				echo "status : ".$result_['status']; echo "message : ". $result_['message'];
				}
			curl_close( $chOne );  
	
 
if($qsave) {

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_credit_approve.php';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	
?>
