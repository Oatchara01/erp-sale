<?php
include "dbconnect.php";
include "head.php";

$ref_id=$_GET['ref_id'];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$approve_name = "$name $surname";
$approve_date = date('Y-m-d H:i:s');

$strSQL25="Update  so__main set approve_complete='Rejected',approve_name='".$approve_name."',approve_date='".$approve_date."'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);


 if($objQuery25){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_approve_sol.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

	
?>