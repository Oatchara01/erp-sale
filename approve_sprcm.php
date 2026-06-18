<?php
include('head.php'); 
include "dbconnect.php";


 $ref_id = $_GET['ref_id'];
 $name = $_SESSION["name"];
 $today= date('Y-m-d');
$add_date = date('Y-m-d H:i:s');




$save="Update  hos__spr set cm_name='".$name."',cm_date='".$today."',status_doc='Approve',send_stock='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);

$save17="Update  hos__subspr set status_spr='Approve'  where ref_idd = '".$ref_id."' ";
$qsave17=mysqli_query($conn,$save17);


 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้วค่ะ');window.location='status_appspr_cm.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>