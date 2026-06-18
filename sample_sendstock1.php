<?php
include "dbconnect.php";
 include('head.php'); 
date_default_timezone_set("Asia/Bangkok");

  $ref_idsmp = $_GET['ref_idsmp'];
  $sup_date = date('Y-m-d');
  $sup_name = $_SESSION['name'];

 $save="Update  hos__smp set status_sup ='Approve',send_stock = '1', send_admin = '1',sup_name='".$sup_name."',sup_date='".$sup_date."'  where ref_idsmp = '".$ref_idsmp."' ";

$qsave=mysqli_query($conn,$save);
 
 
if($qsave) {

 echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminsmp1_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
