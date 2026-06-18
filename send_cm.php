<?php
include "dbconnect.php";


  $ref_id = $_GET['ref_id'];
   $save="Update  so__main set send_cm ='1'  where ref_id = '".$ref_id."' ";

$qsave=mysqli_query($conn,$save);
 
 

 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_supvat.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
?>