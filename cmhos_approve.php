<?php
include ("head.php");

date_default_timezone_set("Asia/Bangkok");


$ref_id=$_POST['ref_id'];
$approve_code = $_SESSION['code'];
$approve_name =  $_SESSION['name'];
$sale_date= date('Y-m-d');
$approve_time = date("H:i:s");
  $add_date = date('Y-m-d H:i:s');
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$add_by = "$name $surname";

$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$sn = $_POST["sn"];
$product_id = $_POST["product_id"];
$clear_br = $_POST["clear_br"];
$clear_ivno = $_POST["clear_ivno"];
$jong_ckk = $_POST["jong_ckk"];
$jong_no = $_POST["jong_no"];
$adm_ckk = $_POST["adm_ckk"];
$ic_ckk = $_POST["ic_ckk"];
//if($clear_ivno !=''){


	

	
$strSQL25="Update  hos__so set status_doc = 'Approve',cm_name='".$add_by."',send_admin='1',cm_date = '".$add_date."'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);


$strSQL28="Update  hos__subso set status_so = 'Approve' where ref_idd='".$ref_id."'";
$objQuery28 = mysqli_query($conn,$strSQL28);	
	


 if($objQuery25){
	
echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_approvecm.php';";
echo "</script>";
	 

  } else {
   echo "Cannot";
  }

//ทำหน้า connect Database CS
	
?>