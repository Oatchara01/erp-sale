<?php
include "dbconnect.php";
 include ("head.php"); 


  $ref_id = $_GET['ref_id'];
 $date_approve = date('Y-m-d');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";


 $save="Update  hos__jongproduct set status_doc ='Approve',send_stock='1',date_approve='".$date_approve."',approve_name='".$add_by."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);

$save="Update  hos__subjongpro set status_sub ='Approve'  where ref_idd = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของคุณเรียบร้อยแล้วค่ะ');window.location='status_supjongapp.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>