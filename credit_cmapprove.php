<?php
include "dbconnect.php";
include("dbconnect_acc.php");
include "head.php";

$ref_credit = $_GET['ref_credit'];
$sale_code = $_GET['sale_code'];
$date_credit = $_GET['date_credit'];
$name = $_SESSION['name'];
$add_date = date('Y-m-d');
$dm_datetime = date('Y-m-d H:i:s');


 $save="Update  tb_credit_note set status_doc = 'Approve',dm_name='".$name."',dm_date='".$date_credit."',send_admin = '1',dm_datetime='".$dm_datetime."'  where ref_credit = '".$ref_credit."' ";
$qsave=mysqli_query($conn,$save);
 

$strSQL27=" DELETE FROM  tb_register_data   where ref_id ='".$ref_id."'";
$objQuery27 = mysqli_query($code,$strSQL27);			

	
 
if($qsave) {

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_credit_cmapprove.php';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	
?>
