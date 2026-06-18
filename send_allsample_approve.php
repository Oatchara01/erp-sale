<?php
include "dbconnect.php";


  $ref_idsmp = $_GET['ref_idsmp'];
 

 $save="Update  hos__smp set send_sup ='1'  where ref_idsmp = '".$ref_idsmp."' ";

$qsave=mysqli_query($conn,$save);
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Sup เรียบร้อยแล้วค่ะ');window.location='register_allwellsmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>