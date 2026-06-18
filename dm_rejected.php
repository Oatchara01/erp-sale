<?php
include('head.php');

date_default_timezone_set("Asia/Bangkok");

  $ref_idsmp = $_POST['ref_idsmp'];
  $comment_dm = $_POST['comment_dm'];
  $dm_date = date('Y-m-d');
  $dm_name = $_SESSION['name'];

 $save="Update  hos__smp set status_sup ='Rejected',comment_dm='".$comment_dm."',dm_date='".$dm_date."',dm_name = 'สมบัติ'  where ref_idsmp = '".$ref_idsmp."' ";

$qsave=mysqli_query($conn,$save);
 
 
if($qsave) {

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_smpapprove.php';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
