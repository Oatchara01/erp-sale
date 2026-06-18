<?php
include "head.php";

$ref_idsmp = $_GET['ref_idsmp'];
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname"; 
$code =  $_SESSION['code'];


if($code=='SMD'){
$save="Update  hos__smp set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',send_dm ='1',sup_name='".$add_by."',sup_adddate='".$add_date."',sup_date='".$add_date."'  where ref_idsmp = '".$ref_idsmp."' ";
$qsave=mysqli_query($conn,$save);
	
}else{
$save="Update  hos__smp set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."'  where ref_idsmp = '".$ref_idsmp."' ";
$qsave=mysqli_query($conn,$save);
}
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Sup เรียบร้อยแล้วค่ะ');window.location='register_salesmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>