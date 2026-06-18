<?php
include "dbconnect.php";
include ("head.php");

date_default_timezone_set("Asia/Bangkok");


  $ref_id_br=$_GET['ref_id_br'];
  $approve_name=$_GET['approve_name'];
  $sale_code=$_GET['sale_code'];
 $sale_date= date('Y-m-d');




$strSQL25="Update  in__br set status_doc = 'Rejected',approve='".$approve_name."',approve_code = '".$sale_code."',approve_date = '".$sale_date."'  where ref_id_br='".$ref_id_br."'";

$strSQL21="Update  tb_register_data  set start_date='0000-00-00'  where ref_id='".$ref_id_br."'";
$objQuery21 = mysqli_query($conn,$strSQL21);


$objQuery25 = mysqli_query($conn,$strSQL25);





 if($objQuery25){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_approvebrsup.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

//ทำหน้า connect Database CS
	
?>