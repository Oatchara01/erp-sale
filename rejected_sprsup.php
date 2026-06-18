<?php
include('head.php'); 
include "dbconnect.php";


 $ref_id = $_GET['ref_id'];
 $name = $_SESSION["name"];
 $today= date('Y-m-d');
 $add_date = date('Y-m-d H:i:s');


 $save="Update  hos__spr set send_sup ='1',sup_name='".$name."',sup_date='".$today."',sup_adddate='".$add_date."',status_doc='Rejected'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);

 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้วค่ะ');window.location='status_approvespr.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>