<?php
include "dbconnect.php";
include "head.php";

  $id = $_GET['id'];
$customer_name = $_GET['customer_name'];
$add_date = date('Y-m-d H:i:s');
$ref_id = $_GET["ref_id"];
$name=$_SESSION['name'];
$surname=$_SESSION['surname'];
$add_by="$name $surname";


$save="Update  tb_register_eng set send_eng ='1',datesend_eng='".$add_date."'  where id = '".$id."' ";
$qsave=mysqli_query($conn,$save);
 
 if($qsave){

	 
//เต้ไลน์ส่วนตัว	 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "kKG38LfcaOL9STN7kRLyWpbTcAbl6dfQ76EoP2AsAFu";
$sMessage = "
มีรายการรับเรื่องจากลูกค้าของช่าง 
เลขที่อ้างอิง : $ref_id
ลูกค้า : $customer_name 
แจ้งโดย : $add_by
กรุณาคลิ๊กลิงค์เพื่อตรวจสอบ sol.allwellcenter.com
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
	

//กลุ่มคุยงานช่างอื่นๆ	 
	 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "6H9BEhrMSvNA7hnOVv5VxTt00H3hXyeKC3ilVjjuihn";
$sMessage = "
มีรายการรับเรื่องจากลูกค้าของช่าง 
เลขที่อ้างอิง : $ref_id
ลูกค้า : $customer_name 
แจ้งโดย : $add_by
กรุณาคลิ๊กลิงค์เพื่อตรวจสอบ sol.allwellcenter.com";
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
		 
 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "kFpgOIy5zbTStNoZVO9vnEeBtzaQnHMDobgPThhgod0";
$sMessage = "
มีรายการรับเรื่องจากลูกค้าของช่าง 
เลขที่อ้างอิง : $ref_id
ลูกค้า : $customer_name 
แจ้งโดย : $add_by
กรุณาคลิ๊กลิงค์เพื่อตรวจสอบ sol.allwellcenter.com";
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
	

	//พี่เสก
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "Su0LjZSbkRNQ2VAMuOGCvFFnRYtLbzXEACHioaXvu9r";
$sMessage = "มีรายการรับเรื่องจากลูกค้าของช่าง 
เลขที่อ้างอิง : $ref_id
ลูกค้า : $customer_name 
แจ้งโดย : $add_by
กรุณาคลิ๊กลิงค์เพื่อตรวจสอบ sol.allwellcenter.com";
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
	
	
	
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "j5EcxboiYLfq8ZC9IEkNAa4qCKuMz9ymVjwI15d63CE";
$sMessage = "มีรายการรับเรื่องจากลูกค้าของช่าง 
เลขที่อ้างอิง : $ref_id
ลูกค้า : $customer_name 
แจ้งโดย : $add_by
กรุณาคลิ๊กลิงค์เพื่อตรวจสอบ sol.allwellcenter.com";
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
	
	
	
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "gNBOjcNmbUk7kE4S2YQsihgFIp7PaoUVKPy2y3Hyv0Z";
$sMessage = "มีรายการรับเรื่องจากลูกค้าของช่าง 
เลขที่อ้างอิง : $ref_id
ลูกค้า : $customer_name 
แจ้งโดย : $add_by
กรุณาคลิ๊กลิงค์เพื่อตรวจสอบ sol.allwellcenter.com";
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
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_cusopen.php';";
echo "</script>";

	
	}else{
   echo "Cannot";
  }

	

	
?>
