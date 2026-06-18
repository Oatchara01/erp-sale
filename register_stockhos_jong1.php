<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = trim($_POST["ref_id"]);

$have_product =  $_POST['have_product'];
$des_product =  $_POST['des_product'];
$bill_name = $_POST["bill_name"];


$id = $_POST["id"];
$sn_number = $_POST["sn"];
$product_id = $_POST["product_id"];
$code_same  = $_POST["product_code_same"];
	
$save="Update  hos__so set have_product ='".$have_product."',des_product ='".$des_product."'  where ref_id='".$ref_id."'";

//echo $save;
$qsave=mysqli_query($conn,$save);



if($have_product=='1'){

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "KLadYmSxQFDtfywN5HqZHCipQ2cSX6aBd6JVtZf063h";
$sMessage = "หมายเลขอ้างอิง $ref_id คุณ $bill_name มีสินค้าครับ ";
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


	
	
	
$save1="Update  hos__so set have_product = '2'  where ref_id='".$ref_id."'";

//echo $save;
$qsave1=mysqli_query($conn,$save1);
	
}


//exit();


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_stockhos_Accept.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


