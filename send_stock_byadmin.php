<?php
include "dbconnect.php";
date_default_timezone_set("Asia/Bangkok");



  $ref_idsmp = $_GET['ref_idsmp'];
  $sup_date = date('Y-m-d');

 $save="Update  hos__smp set send_stock = '1'  where ref_idsmp = '".$ref_idsmp."' ";

$qsave=mysqli_query($conn,$save);
 
 
if($qsave) {

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminsmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
