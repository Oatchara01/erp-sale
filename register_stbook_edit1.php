<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$iv_no = $_POST["iv_no"];
$register_ckk = $_POST["register_ckk"];
$cancel_ckk = $_POST["cancel_ckk"];

$remark = $_POST["remark"];

$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$stock_date = date('Y-m-d');
	
	
	


$ref_id = $_POST["ref_id"];


$save="UPDATE  hos__jongproduct SET remark = '".$remark."',iv_no='".$iv_no."',register_ckk='".$register_ckk."',cancel_ckk='".$cancel_ckk."',stock_date='".$stock_date."',stock_name='".$add_by."'  where ref_id = '".$ref_id."'";


$qsave=mysqli_query($conn,$save);






	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_stjong.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

	}


