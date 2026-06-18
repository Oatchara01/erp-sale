<?php
include "dbconnect.php";

$allwell_ckk  = $_GET['allwell_ckk'];
  $ref_id = $_GET['ref_id'];
  
$save="Update  hos__receive set send_stock ='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 
 

 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='rister_clearbrpn_stedit.php?ref_id=$ref_id'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
?>