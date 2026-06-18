<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
$date_ker  = $_POST["date_ker"];
$order_refer_code = $_POST["order_refer_code"];
$order_refer_code1 = $_POST["order_refer_code1"];
$ker_bath = $_POST["ker_bath"];
$delivery = $_POST["delivery"];
$ref_id  = $_POST["ref_idsmp"];
$end_date  = $_POST["end_date"];
$start_date  = $_POST["start_date"];
$address_1 = $_POST["address_1"];


$save="Update  hos__smp set
date_ker='".$date_ker."',ref_no='".$order_refer_code."',ref_no1='".$order_refer_code1."',ker_bath='".$ker_bath."' where ref_idsmp='".$ref_id."'";

$qsave=mysqli_query($conn,$save);
	
	
$save1="Update  tb_register_data  set  address_1 ='".$address_1 ."' where ref_id='".$ref_id."'";

$qsave1=mysqli_query($conn,$save1);	


 if($qsave){
   echo "<script language=\"JavaScript\">";
	 
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_sumdelall.php?start_date=$start_date&end_date=$end_date'";		 
	
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>