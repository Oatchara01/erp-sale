<?php
include "dbconnect.php";


  $ref_id = $_GET['ref_id'];


$strSQL25="Update  so__main set approve_complete='',status_vat='',send_supadm ='0'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);
 
 
 if($objQuery25){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลกลับให้เซลล์แก้ไข เรียบร้อยแล้วค่ะ');window.location='register_admin_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>