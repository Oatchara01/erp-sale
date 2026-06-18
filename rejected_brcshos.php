<?php
include ('head.php');


  $ref_id = $_GET['ref_id'];
  $sale_code = $_GET['sale_code'];
  $name =  $_SESSION['name'];
  $surname =	$_SESSION['surname'];
  $add_by = "$name $surname";
  $add_date = date('Y-m-d H:i:s');
  $approve_date = date('Y-m-d');
  $approve_time = date('H:i:s');


  $save="Update  hos__consig set status_doc='Rejected',approve='".$add_by."',approve_date='".$approve_date."',approve_time='".$approve_time."'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($conn,$save);
 

 if($qsave){
	 
echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_approvebrsc.php';";
echo "</script>";	 
	 
 }else{
   echo "Cannot";
  }
	

	
?>
