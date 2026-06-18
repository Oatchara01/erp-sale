<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$product_ID = $_POST["product_ID"];

$strSQL6 = "SELECT access_code,sol_name,war_hc,unit_hc,remark_hc,war_hos,unit_hos,remark_hos FROM tb_product WHERE product_ID='".$product_ID."'";
$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);


$war_hc_old  = $objResult6["war_hc"];
$unit_hc_old  = $objResult6["unit_hc"];
$remark_hc_old = $objResult6["remark_hc"];
$war_hos_old = $objResult6["war_hos"];
$unit_hos_old = $objResult6["unit_hos"];
$remark_hos_old = $objResult6["remark_hos"];
$sol_name = $objResult6["sol_name"];
$access_code = $objResult6["access_code"];

$war_hc  = $_POST["war_hc"];
$unit_hc  = $_POST["unit_hc"];
$remark_hc = $_POST["remark_hc"];
$war_hos = $_POST["war_hos"];
$unit_hos = $_POST["unit_hos"];
$remark_hos = $_POST["remark_hos"];


$surname =	$_SESSION['surname'];
$name =	$_SESSION['name'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');




/*$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_warr_proedit";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "ED";

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

$ref_id ="$so$nextId";*/




$save="Update  tb_product set war_hc='".$war_hc."',unit_hc='".$unit_hc."',remark_hc='".$remark_hc."',war_hos='".$war_hos."',unit_hos='".$unit_hos."',remark_hos='".$remark_hos."' where  product_ID ='".$product_ID."'";
$qsave=mysqli_query($conn,$save);
	
	
	
$save2="Update  tb_product set war_hc='".$war_hc."',unit_hc='".$unit_hc."',remark_hc='".$remark_hc."',war_hos='".$war_hos."',unit_hos='".$unit_hos."',remark_hos='".$remark_hos."' where  product_ID ='".$product_ID."'";
$qsave2=mysqli_query($new,$save2);	
	



/*$save3="insert into tb_warr_proedit
(ref_id,product_ID,war_hc,unit_hc,remark_hc,war_hos,unit_hos,remark_hos,war_hc_old,unit_hc_old,remark_hc_old,war_hos_old,unit_hos_old,remark_hos_old,add_by,add_date)
values
('".$ref_id."','".$product_ID."','".$war_hc."','".$unit_hc."','".$remark_hc."','".$war_hos."','".$unit_hos."','".$remark_hos."','".$war_hc_old."','".$unit_hc_old."','".$remark_hc_old."','".$war_hos_old."','".$unit_hos_old."','".$remark_hos_old."','".$add_by."','".$add_date."')";

$qsave3=mysqli_query($conn,$save3);*/
	







 if($qsave){



/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "OvxDLRfgZk22KXZzTQBcwKO61S62vgOX2rplI8Wfezx";
$sMessage = "
มีการแก้ไขการรับประกันสินค้า
รหัสสินค้า : $access_code
ชื่อสินค้า : $sol_name
แก้ไขโดย : $add_by
รบกวนแผนกที่เกี่ยวข้องดำเนินการรับทราบ และปรับปรุงในส่วนที่เกี่ยวข้องด้วยนะคะ
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
curl_close( $chOne ); */





   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_warproduct.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>