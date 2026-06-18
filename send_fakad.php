<?php
include "dbconnect.php";
include "dbconnect_acc.php";
include ("head.php");

 $ref_id = $_GET['ref_id'];
 $sale_code = $_GET['sale_code'];
 
$approve_time = date("H:i:s");
$approve_date = date("Y-m-d");
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";


$save="Update  hos__so set have_product ='2',status_doc='Approve',send_fakdt='".$add_date."',send_namefak='".$add_by."' where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);


if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suphosfak_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
	

	
?>
