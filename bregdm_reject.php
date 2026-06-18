<?php
include "dbconnect.php";
include "head.php";


$ref_id = $_GET['ref_id'];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$sup_name = "$name $surname";


$save="Update  hos__breg set status_doc='Rejected',dm_name='".$sup_name."',dm_date='".$add_date."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ทำการ Rejected เอกสาร เรียบร้อยแล้วค่ะ');window.location='status_dmbreg_app.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>