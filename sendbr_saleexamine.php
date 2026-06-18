<?php


include("dbconnect.php");
include ("error_page.php"); 
include("head.php");



date_default_timezone_set("Asia/Bangkok");

	
	

$ref_id = $_GET["ref_id"];
$sale_code = $_GET["sale_code"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$month =	date("m");
$yearto = date("Y")+543;
$yearsave = date("Y");
$today_save = "$yearsave-$month";
$add_date = date('Y-m-d H:i:s');

	

$strSQL = "UPDATE st__checkbr SET send_sup='1',send_supdate='".$add_date."'  where ref_id ='".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL);	


if($sale_code=='S15' or $sale_code=='S16' or $sale_code=='S21' or $sale_code=='S22'){
$line = "p16R8tOVlleGCqTIceydJLCqF6Ns18i2m2TVQUzvKl1";	//พี่โอ๋
}else if($sale_code=='S11' or $sale_code=='S12' or $sale_code=='S13' or $sale_code=='S14' or $sale_code=='S17' or $sale_code=='S23' or $sale_code=='S24'){
$line = "hT8U59GmiU06zUJSJwLAughYFI3112ZrzSty91xDbpK";	//พี่เนิส	
}else if($sale_code=='S31' or $sale_code=='MM1' or $sale_code=='SOL1' or $sale_code=='SOL2' or $sale_code=='SOL99' or $sale_code=='SOL3' or $sale_code=='SOL4' or $sale_code=='SOL0' or $sale_code=='SOL6' or $sale_code=='SOL5'){
$line = "Gy2FZ5xYM44SimFmXM3cqFYAfGwS7XpXf3iHnfqdNZt";		//พี่หม่อม
}else if($sale_code=='MM2'){
$line = "saPCQwz8ISJiY2VYKFzINNJ90hEH42Z6nMSirvvwMWd";		//พี่กิ๋ว
}else if($sale_code=='CM'){	
$line = "gCe7s6XlzcHFCtuVNBF2D2g6xbZZS7PrmPz5vpQBc6G";	//พี่เปิ้ล
}else if($sale_code=='SM1'){	
$line ="I9fEDAgfYAuSbsHACVyUDUPbAJhVMB9LY554hBZiNWH"; //พี่โจ้
}else if($sale_code=='EN1' or $sale_code=='EN2' or $sale_code=='EN3' or $sale_code=='EN4' or $sale_code=='EN5' or $sale_code=='EN6' or $sale_code=='EN7' or $sale_code=='EN8' or $sale_code=='EN9' or $sale_code=='EN10' or $sale_code=='EN11' or $sale_code=='EN12' or $sale_code=='EN13' or $sale_code=='EN14' or $sale_code=='SUP_EN'){

$line ="gNBOjcNmbUk7kE4S2YQsihgFIp7PaoUVKPy2y3Hyv0Z"; //พี่เดียว	
$line1 ="Sw9TBqZjWPu4YhVBfQa0AI20mrd7Srb8dgmtxMWylD7"; //พี่บรรเทิง
}






ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = $line; 
//$sToken	="CMXUBCXx0tXyGUKwsShIQ4j66thdHOm6iD3MsQlmmIU";
$sMessage = "รบกวนตรวจสอบรายการตรวจเช็คใบยืมประจำเดือน $month-$yearto
เขตการขาย : $sale_code
ตรวจเช็คโดย : $add_by
สามารถอนุมัติการตรวจเช็คสินค้าได้ทางลิงค์ด้านล่างค่ะ
https://sol.allwellcenter.com/
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



if($line1!=''){
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = $line1; 
//$sToken	="CMXUBCXx0tXyGUKwsShIQ4j66thdHOm6iD3MsQlmmIU";
$sMessage = "รบกวนตรวจสอบรายการตรวจเช็คใบยืมประจำเดือน $month-$yearto
เขตการขาย : $sale_code
ตรวจเช็คโดย : $add_by
สามารถอนุมัติการตรวจเช็คสินค้าได้ทางลิงค์ด้านล่างค่ะ
https://sol.allwellcenter.com/
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



 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='report_brkangbyareashow.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	

