<?php
include ("head.php");

date_default_timezone_set("Asia/Bangkok");


$ref_id_br = $_GET['ref_id_br'];
$adm_ckk = $_GET["adm_ckk"];
$approve_name=$_GET['approve_name'];
$sale_code=$_GET['sale_code'];
$que_ckk=$_GET['que_ckk'];
$customer=$_GET['customer'];
$sale_date= date('Y-m-d');
$approve_time = date("H:i:s");
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname"; 


$strSQL1 = "SELECT * FROM hos__br WHERE ref_id_br = '".$ref_id_br."'";
$objQuery1= mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);

$objective = $objResult1["objective"];
$code =  $_SESSION['code'];

/*if($code=='S55'){
	
$strSQL25="Update  hos__br set status_doc = 'Request',examine_name='".$add_by."',examine_date = '".$add_date."',send_sup ='1'  where ref_id_br='".$ref_id_br."'";

$objQuery25 = mysqli_query($conn,$strSQL25);*/

if($objective=='7'){
	
$strSQL25="Update  hos__br set status_doc = 'Request',approve='".$approve_name."',approve_code = '".$sale_code."',approve_date = '".$sale_date."',send_dm ='1',approve_time = '".$approve_time."'  where ref_id_br='".$ref_id_br."'";
$objQuery25 = mysqli_query($conn,$strSQL25);

}else{
	
$strSQL25="Update  hos__br set status_doc = 'Approve',approve='".$approve_name."',approve_code = '".$sale_code."',approve_date = '".$sale_date."',send_admin ='1',approve_time = '".$approve_time."'  where ref_id_br='".$ref_id_br."'";
$objQuery25 = mysqli_query($conn,$strSQL25);

}



 if($objQuery25){
	 
	 

	 
	 
if($adm_ckk=='1'){	 
echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_approveadm.php';";
echo "</script>";
}else{	
echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_approvebrsup.php';";
echo "</script>";
}	 
	 
  } else {
   echo "Cannot";
  }

//ทำหน้า connect Database CS
	
?>