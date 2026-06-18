<?php
include "dbconnect.php";
include "head.php";

$ref_id = $_GET['ref_id'];
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');

$save="Update  st__expro SET status_doc ='Rejected',dm_name='".$name."',dm_date='".$add_date."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($new,$save);
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_appexpro.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
?>
