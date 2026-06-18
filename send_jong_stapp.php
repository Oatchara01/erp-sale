<?php
include "dbconnect.php";
include ("head.php");

$ref_id = $_GET['ref_id'];
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname"; 
$code =  $_SESSION['code']; 

if($code=="SS5"){
	
$save="Update  hos__jongproduct set send_sup ='1',send_supdate='".$add_by."',sendsup_name='".$name."',status_doc='Request'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
}else{	
	
$save="Update  hos__jongproduct set send_stock ='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);

$save="Update  hos__subjongpro set status_sub ='Approve'  where ref_idd = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 
}	
	
	
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Stock เรียบร้อยแล้วค่ะ');window.location='register_supbook_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>