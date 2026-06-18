<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
$del_date  = $_POST["del_date"];
$ref_no = $_POST["ref_no"];
$ref_no1 = $_POST["ref_no1"];
$iv_no = $_POST["iv_no"];
$pro_name = $_POST["pro_name"];
$type_del = $_POST["type_del"];
$ker_bath = $_POST["ker_bath"];
$company = $_POST["company"];
$id  = $_POST["id"];

$save="Update  tb_deloth set
del_date='".$del_date."',ref_no='".$ref_no."',ref_no1='".$ref_no1."',iv_no='".$iv_no."',pro_name='".$pro_name."',type_del='".$type_del."',ker_bath='".$ker_bath."',company='".$company."' where id='".$id."'";

$qsave=mysqli_query($conn,$save);
	


 if($qsave){
   echo "<script language=\"JavaScript\">";
	 
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_sumdelall.php'";		 
	
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>