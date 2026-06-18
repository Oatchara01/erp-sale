<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];
$des_con  = $_POST["des_con"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');


$save="insert into hos__rental_contact (ref_id,des_con,add_date,add_by) values ('".$ref_id."','".$des_con."','".$add_date."','".$add_by."')";
$qsave=mysqli_query($conn,$save);







 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_kangiv.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>