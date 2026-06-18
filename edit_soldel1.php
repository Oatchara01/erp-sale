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
$ref_id  = $_POST["ref_id"];
$end_date  = $_POST["end_date"];
$start_date  = $_POST["start_date"];



$save="Update  so__main set
date_ker='".$date_ker."',order_refer_code='".$order_refer_code."',order_refer_code1='".$order_refer_code1."',delivery='".$delivery."',ker_bath='".$ker_bath."' where ref_id='".$ref_id."'";

$qsave=mysqli_query($conn,$save);
	


 if($qsave){
   echo "<script language=\"JavaScript\">";
	 
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_sumdelall.php?start_date=$start_date&end_date=$end_date'";		 
	
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>