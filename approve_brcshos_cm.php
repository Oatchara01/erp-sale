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


 $save="Update  hos__consig set send_admin='1',status_doc='Approve',cm_name='".$add_by."',cm_date='".$add_date."'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($conn,$save);
 

 if($qsave){
	 
echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_approvecmbrsc.php';";
echo "</script>";	 
	 
 }else{
   echo "Cannot";
  }
	

	
?>
