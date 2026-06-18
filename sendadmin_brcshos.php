<?php
include "dbconnect.php";
include ('head.php');


  $ref_id = $_GET['ref_id'];
  $sale_code = $_GET['sale_code'];
  $name =  $_SESSION['name'];
  $surname =	$_SESSION['surname'];
  $add_by = "$name $surname";
  $add_date = date('Y-m-d H:i:s');
  $approve_date = date('Y-m-d');
  $approve_time = date('H:i:s');
  $code =  $_SESSION['code'];

$sql = "SELECT * FROM hos__consig where ref_id = '".$ref_id."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$customer = $_POST["customer"];

 /*$save="Update  hos__consig set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',send_admin='1',status_doc='Approve',approve='".$add_by."',approve_date='".$approve_date."',approve_time='".$approve_time."'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($conn,$save);*/


if($code=='SS5'){
	
$save="Update  hos__consig set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',status_doc='Request'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);	
	
}else{
	
$save="Update  hos__consig set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',send_cm='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);

}
 

 if($qsave){
	 	 
echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supbrcshos_edit.php?ref_id=$ref_id';";
echo "</script>";	 
	 
 }else{
   echo "Cannot";
  }
	

	
?>
