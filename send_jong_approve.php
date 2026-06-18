<?php
include ("head.php");
include "dbconnect.php";

$ref_id = $_GET['ref_id'];
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname"; 
$code =  $_SESSION['code'];

/*if($code=='S31' or $code=='S32'){
$save="Update  hos__jongproduct set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."' ,status_doc='Pending review' where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
}else{*/
$save="Update  hos__jongproduct set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
//}
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Sup เรียบร้อยแล้วค่ะ');window.location='register_salebook_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>