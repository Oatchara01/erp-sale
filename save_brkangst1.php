<?php


include("dbconnect.php");
include ("error_page.php"); 
include("head.php");



date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

	
	

$id = $_POST["id"];
$have_ckk = $_POST["have_ckk"];
$des_sale = $_POST["des_sale"];
$ref_id = $_POST["ref_id"];


$month =	date("m");
$yearto = date("Y")+543;
$yearsave = date("Y");
$today_save = "$yearsave-$month";


foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$have_ckk_new=$have_ckk[$key];
		$des_sale_new=$des_sale[$key];
		

$strSQL = "UPDATE st__checkbr SET have_ckk='".$have_ckk_new."',des_sale='".$des_sale_new."'  where id ='".$id_new."'";
$objQuery = mysqli_query($conn,$strSQL);	

}


/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
//$sToken = "tOHxEbD7gJACXMisdGBMAzQ9g7oYLlIaA6Mfhjbon9Z"; //Line ERP Stock
$sToken	="CMXUBCXx0tXyGUKwsShIQ4j66thdHOm6iD3MsQlmmIU";
$sMessage = "มีการตรวจเช็ครายการใบยืมประจำเดือน $month-$yearto
เขตการขาย : $sale_area
ตรวจเช็คโดย : $add_by
รบกวนทางคลังสินค้าตรวจสอบได้ทางลิงค์ด้านล่างค่ะ
https://stock.allwellcenter.com/

ทดสอบจ้าา
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
*/


 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='report_brkangbyareashow.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}

