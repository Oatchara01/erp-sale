<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];
$date_story = date('Y-m-d');
$time_story = date("H:i:s");
$pending_pre = $_POST["pending_pre"];	
$pending = $_POST["pending"];	
$dfff = "$pending $pending_pre";

$save="UPDATE tb_register_eng SET pending='".$dfff."' where ref_id = '".$ref_id."'";
$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_engclose.php?ref_id=$ref_id'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>