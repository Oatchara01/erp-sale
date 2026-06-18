<?php
include "dbconnect.php";
include "head.php";

  $ref_credit = $_GET['ref_credit'];
  $sale_code = $_GET['sale_code'];
$name = $_SESSION['name'];
$code =  $_SESSION['code'];

if($code=='SS5'){

$save="Update  tb_credit_note set send_sup ='1',status_doc='Request'  where ref_credit = '".$ref_credit."' ";
$qsave=mysqli_query($conn,$save);
	
}else{
	
 $save="Update  tb_credit_note set send_dm ='1'  where ref_credit = '".$ref_credit."' ";
$qsave=mysqli_query($conn,$save);
}

 
if($qsave) {

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credit_supedit.php?ref_credit=$ref_credit';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
