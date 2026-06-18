<?php
include "dbconnect.php";


  $ref_id = $_GET['ref_id'];
 

$save="Update  hos__change set send_sup ='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Sup เรียบร้อยแล้วค่ะ');window.location='status_salechange.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>