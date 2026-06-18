<?php
include "dbconnect.php";
include ("head.php");

date_default_timezone_set("Asia/Bangkok");


  $ref_id=$_GET['ref_id'];
  $approve_name=$_SESSION['name'];
  $sale_code=$_SESSION['code'];
 $sale_date= date('Y-m-d');




$strSQL25="Update  hos__change set status_doc = 'Rejected',approve='".$approve_name."',approve_code = '".$sale_code."',approve_date = '".$sale_date."'  where ref_id='".$ref_id."'";

$objQuery25 = mysqli_query($conn,$strSQL25);





 if($objQuery25){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_supchangeapp.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

//ทำหน้า connect Database CS
	
?>