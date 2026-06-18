<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$company = $_POST["company"];
$br_date = $_POST["br_date"];
$iv_no = $_POST["iv_no"];
$customer_name = $_POST["customer_name"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');




$save="insert into tb_register_br
(company,br_date,iv_no,customer_name,add_by,add_date) values ('".$company."','".$br_date."','".$iv_no."','".$customer_name."','".$add_by."','".$add_date."')";

$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_recevebr.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>