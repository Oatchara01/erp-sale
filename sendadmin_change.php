<?php
include "dbconnect.php";
include ("head.php");

date_default_timezone_set("Asia/Bangkok");


  $ref_id = $_GET['ref_id'];
  $approve_name=$_SESSION['name'];
  $sale_code=$_GET['sale_code'];
 $sale_date= date('Y-m-d');
$approve_time = date("H:i:s");
$code =  $_SESSION['code'];
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";


$code =  $_SESSION['code'];

if($code=='SS5'){

$strSQL25="Update  hos__change set status_doc = 'Request',send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);


}else{
	
$strSQL25="Update  hos__change set status_doc = 'Approve',approve='".$approve_name."',approve_code = '".$sale_code."',approve_date = '".$sale_date."',send_admin ='1',approve_time = '".$approve_time."'  where ref_id='".$ref_id."'";

$objQuery25 = mysqli_query($conn,$strSQL25);

}



 if($objQuery25){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suptran_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }

	
?>