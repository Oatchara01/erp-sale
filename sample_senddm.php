<?php
include "dbconnect.php";
 include('head.php'); 
date_default_timezone_set("Asia/Bangkok");



  $ref_idsmp = $_GET['ref_idsmp'];
  $sup_date = date('Y-m-d');
  $sup_name = $_SESSION['name'];
$code =  $_SESSION['code'];


if($code=='SS5'){
	
$save="Update  hos__smp set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."'  where ref_idsmp = '".$ref_idsmp."' ";
$qsave=mysqli_query($conn,$save);
	
}else{
	
$save="Update  hos__smp set send_dm = '1',sup_name='".$sup_name."',sup_date='".$sup_date."'  where ref_idsmp = '".$ref_idsmp."'";
$qsave=mysqli_query($conn,$save);
}

 
if($qsave) {

if($_SESSION['type_login']=='Sup_sale'){

 echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supsmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
	}else{
		
	echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_cmsmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";	
		
	}


  }else{
   echo "Cannot";
  }
	

	
?>
