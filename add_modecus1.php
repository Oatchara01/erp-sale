<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$mode_name = $_GET["mode_name"];


$save="insert into tb_mode_customer (mode_name) values ('".$mode_name."')";
$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_modecus.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>