<?php
include "dbconnect.php";
include "head.php";

$ref_id = $_GET['ref_id'];
$allwell_ckk  = $_GET['allwell_ckk'];
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$code =  $_SESSION['code'];

/*if($code=='S31' or $code=='S32'){
$strSQL25="Update  hos__change set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',status_doc='Pending review'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);
	
}else{*/	
$strSQL25="Update  hos__change set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);
//}
 
 if($objQuery25){
	 if($allwell_ckk =='1'){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Sup เรียบร้อยแล้วค่ะ');window.location='register_allwelltran_edit.php?ref_id=$ref_id';";
echo "</script>";
	 }else{
	echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Sup เรียบร้อยแล้วค่ะ');window.location='register_saletran_edit.php?ref_id=$ref_id';";
echo "</script>";	 
	 }
  } else {
   echo "Cannot";
  }
  ?>