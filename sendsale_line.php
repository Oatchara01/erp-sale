<?php
include "dbconnect.php";
include ("head.php");

$ref_id = $_GET['ref_id'];
$sale_code = $_GET['sale_code'];
$bill_name = $_GET['bill_name'];
$po_no = $_GET['po_no'];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');


$save="Update  hos__po set send_sale ='1',send_saledate='".$add_date."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 




 
if($sale_code=="S11"){
  

	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "fWdllxszRbpTfw7gxvv0N9GVRm7ZnbiKhlrg8ScaFpR";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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


 //พี่เนิส

	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "hT8U59GmiU06zUJSJwLAughYFI3112ZrzSty91xDbpK";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com

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



  } else if($sale_code=="S12"){


	 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "cmNiYlJEMGNOdyPQewX1LTOA4lDlwUsXIlI9WakpvIb";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com

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


 //พี่เนิส

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "hT8U59GmiU06zUJSJwLAughYFI3112ZrzSty91xDbpK";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com

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



  } else if($sale_code=="S13"){

	  //พี่เนิส

	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "hT8U59GmiU06zUJSJwLAughYFI3112ZrzSty91xDbpK";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com

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
	
	



  } else if($sale_code=="S14"){
	
	
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "vQoDaiOtmMTtAMU9Q2bC4u7KgF7m2dwkhmRD5HUKlnJ";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com

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
	
	

	  //พี่โอ๋

	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "p16R8tOVlleGCqTIceydJLCqF6Ns18i2m2TVQUzvKl1";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com

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


  } else if($sale_code=="S15"){



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "asl7XUfUesdcSFFtS23yuq1n9CkfuGSueIleOnDzPSp";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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


//พี่โอ๋

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "p16R8tOVlleGCqTIceydJLCqF6Ns18i2m2TVQUzvKl1";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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






  } else if($sale_code=="S16"){


	 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "70yE6N8XYK8xuF8EwskuHwFMVa1dXcDEmTxGpmpfUPo";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
	

//พี่โอ๋

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "p16R8tOVlleGCqTIceydJLCqF6Ns18i2m2TVQUzvKl1";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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




  }else if($sale_code=="SM1"){


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "saPCQwz8ISJiY2VYKFzINNJ90hEH42Z6nMSirvvwMWd";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
	



  } else if($sale_code=="S17"){

 //พี่เนิส

	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "hT8U59GmiU06zUJSJwLAughYFI3112ZrzSty91xDbpK";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com

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
	

  } else if($sale_code=="S21"){

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "AX57z0j8utkiFxxOwf3gL6xA6DkXBgneGleFPzi6mjN";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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

	
//พี่โอ๋

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "p16R8tOVlleGCqTIceydJLCqF6Ns18i2m2TVQUzvKl1";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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


  } else if($sale_code=="S22"){


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "zhUYMj6T7KxCq5nxk0ux0TXPlCmX0cOVRqpyzBhfALf";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
	


//พี่โอ๋

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "p16R8tOVlleGCqTIceydJLCqF6Ns18i2m2TVQUzvKl1";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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


  } else if($sale_code=="S23"){

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "hT8U59GmiU06zUJSJwLAughYFI3112ZrzSty91xDbpK";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
	
	


  } else if($sale_code=="S24"){
	

	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "435dAimggl0DSi3LMY0uAgS2eRgmQgkfKaEkWVDcmQU";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
	 

 //พี่เนิส

	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "hT8U59GmiU06zUJSJwLAughYFI3112ZrzSty91xDbpK";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com

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
	



  } else if($sale_code=="S31"){

 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "OVrUWyfqDOoZWmduWwSetb7HlwDSlXq5WuGkkVVj33N";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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


//พี่หม่อม

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "Gy2FZ5xYM44SimFmXM3cqFYAfGwS7XpXf3iHnfqdNZt";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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



  }else if($sale_code=="MM1"){

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "Gy2FZ5xYM44SimFmXM3cqFYAfGwS7XpXf3iHnfqdNZt";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
	

	
}else if($sale_code=="MM2"){

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "saPCQwz8ISJiY2VYKFzINNJ90hEH42Z6nMSirvvwMWd";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
	

	
  }else if($sale_code=="EN1" or $sale_code=="EN2"  or $sale_code=="EN3"  or $sale_code=="EN4"  or $sale_code=="EN5"  or $sale_code=="EN6"  or $sale_code=="EN7"  or $sale_code=="EN8"  or $sale_code=="EN9"  or $sale_code=="EN10"  or $sale_code=="EN11"  or $sale_code=="EN12" or $sale_code=="SUP_EN"){

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "kFpgOIy5zbTStNoZVO9vnEeBtzaQnHMDobgPThhgod0";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
	


	
	
	
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "j5EcxboiYLfq8ZC9IEkNAa4qCKuMz9ymVjwI15d63CE";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
	
	
	
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "gNBOjcNmbUk7kE4S2YQsihgFIp7PaoUVKPy2y3Hyv0Z";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
	


  }else if($sale_code=="SOL1"){
	
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "OVrUWyfqDOoZWmduWwSetb7HlwDSlXq5WuGkkVVj33N";

$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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

	
	
	}else if($sale_code=="SOL2"){
	

	
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "OVrUWyfqDOoZWmduWwSetb7HlwDSlXq5WuGkkVVj33N";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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

	
	
	}else if($sale_code=="SOL99"){
	

	
	
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "pmoR9UicOtwJAQdupInbEzYDkrnhCTwzghYQBhWGG0i";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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

	

	}else if($sale_code=="SOL3"){
	

	
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "OVrUWyfqDOoZWmduWwSetb7HlwDSlXq5WuGkkVVj33N";
$sMessage = "
มีรายการใบ PO เลขที่  : $po_no
ลูกค้า : $bill_name
เขตการขาย : $sale_code
บันทึก PO โดย : $add_by
รบกวนตรวจสอบรายละเอียดเพื่อเปิดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
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
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_poadmin_edit.php?ref_id=$ref_id';";
echo "</script>";
	
	}else{
   echo "Cannot";
  }

	

	
?>
