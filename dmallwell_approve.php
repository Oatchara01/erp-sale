<?php
 include('head.php'); 


if($_GET['ref_id']!=''){
$ref_id=$_GET['ref_id'];
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname"; 

	
$strSQL25="Update  so__main set approve_complete='Approve',dm_name='".$add_by."',dm_date = '".$add_date."'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);


$strSQL27="Update  so__submain set status_sol='Approve'  where ref_idd = '".$ref_id."'";
$objQuery27 = mysqli_query($conn,$strSQL27);	
	
	
}


	 
 if($objQuery25){
	 
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_appbrbooth.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

//ทำหน้า connect Database CS
	
?>