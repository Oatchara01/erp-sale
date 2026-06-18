<?php
include "dbconnect.php";
include('head.php');
date_default_timezone_set("Asia/Bangkok");

  $ref_idsmp = $_POST['ref_idsmp'];
  $comment_sup = $_POST['comment_sup'];
  $sup_date = date('Y-m-d');
  $sup_name = $_SESSION['name'];

 $save="Update  hos__smp set status_sup ='Rejected',comment_sup='".$comment_sup."',sup_date='".$sup_date."',sup_name='".$sup_name."'  where ref_idsmp = '".$ref_idsmp."' ";


$qsave=mysqli_query($conn,$save);
 
 
if($qsave) {

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_sample_approve.php';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
