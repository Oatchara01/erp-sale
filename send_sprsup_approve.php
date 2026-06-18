<?php
include "head.php";

$ref_id = $_GET['ref_id'];
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname"; 

 $save="Update  hos__spr set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Sup เรียบร้อยแล้วค่ะ');window.location='register_engspr_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>