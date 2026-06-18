<?php
include "dbconnect.php";


  $ref_id = $_GET['ref_id'];
   $date_approve = date('Y-m-d');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

 

 $save="Update  hos__jongproduct set status_doc ='Rejected',date_approve='".$date_approve."',approve_name='".$add_by."',close_jong='1'  where ref_id = '".$ref_id."' ";

$qsave=mysqli_query($conn,$save);

 $save1="Update  hos__subjongpro set close_ckk='1'  where ref_idd = '".$ref_id."' ";

$qsave1=mysqli_query($conn,$save1);
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของคุณเรียบร้อยแล้วค่ะ');window.location='status_supjongapp.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>