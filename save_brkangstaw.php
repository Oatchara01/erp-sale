<?php


include("dbconnect.php");
include ("error_page.php"); 
include("head.php");



date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

	
$id = $_POST["id"];
$have_ckk = $_POST["have_ckk"];
$des_sale = $_POST["des_sale"];
$sale_code = $_POST["sale_code"];
$customer_name = $_POST["customer_name"];
$product_id = $_POST["product_id"];
$count = $_POST["count"];
$sn_number = $_POST["sn_number"];
$iv_no = $_POST["iv_no"];
$stock_date = $_POST["stock_date"];
$sale_area = $_POST["sale_area"];
$status_doc = "Request";
	//echo $sale_area;
	//exit();
$iv_date = $_POST["iv_date"];
$add_date = date('Y-m-d H:i:s');
$employee_code =  $_SESSION["emid"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

$month =	date("m");
$yearto = date("Y")+543;
$yearsave = date("Y");
$today_save = "$yearsave-$month";

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM st__checkbr";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}


foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$have_ckk_new=$have_ckk[$key];
		$des_sale_new=$des_sale[$key];
		$sale_code_new=$sale_code[$key];
		$customer_name_new=$customer_name[$key];
		$product_id_new=$product_id[$key];
		$count_new=$count[$key];
		$sn_number_new=$sn_number[$key];
		$iv_no_new=$iv_no[$key];
		$stock_date_new=$stock_date[$key];
		$iv_date_new=$iv_date[$key];
		
	  


$strSQL = "insert into st__checkbr
(ref_id,product_code,have_ckk,des_sale,sale_code,customer_name,count,sn_number,iv_no,stock_date,iv_date,add_by,add_date,create_date,status_doc,employee_code,aw_ckk)
values ('".$nextId."','".$product_id_new."','".$have_ckk_new."','".$des_sale_new."','".$sale_code_new."','".$customer_name_new."','".$count_new."','".$sn_number_new."','".$iv_no_new."','".$stock_date_new."','".$iv_date_new."','".$add_by."','".$add_date."','".$today_save."','".$status_doc."','".$employee_code."','1')";
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
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='report_brkangbyareashow.php?ref_id=$nextId';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}

