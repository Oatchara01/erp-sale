<?php

include ("head.php");
date_default_timezone_set("Asia/Bangkok");

include("dbconnect.php");
if ($_GET["submit"] = "submit") {
$ref_id = $_GET["ref_id"];
	
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');

$strSQL1 = "Update so__main SET cancel_ckk = '1' where ref_id = '".$ref_id."'";
$objQuery1 = mysqli_query($conn,$strSQL1);
	

	


if($objQuery1){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_cancel_ecom.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

	
}
?>