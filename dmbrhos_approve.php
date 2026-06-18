<?php
include ("head.php");

date_default_timezone_set("Asia/Bangkok");


$ref_id_br = $_GET['ref_id_br'];
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname"; 


	
$strSQL25="Update  hos__br set status_doc = 'Approve',dm_name='".$add_by."',dm_date = '".$add_date."',send_admin ='1'  where ref_id_br='".$ref_id_br."'";
$objQuery25 = mysqli_query($conn,$strSQL25);





 if($objQuery25){
	 
echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_appbrbooth.php';";
echo "</script>";
 
	 
  } else {
   echo "Cannot";
  }

//ทำหน้า connect Database CS
	
?>