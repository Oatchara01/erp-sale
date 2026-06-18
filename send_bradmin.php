<?php
include "dbconnect.php";
include "head.php";

$ref_id_br = $_GET['ref_id_br'];
$sale_code = $_GET['sale_code'];
$approve_time = date("H:i:s");
$approve_date = date("Y-m-d");
//echo  $sale_code;
//exit();


$strSQL1 = "SELECT * FROM hos__br WHERE ref_id_br = '".$ref_id_br."'";
$objQuery1= mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);

$objective = $objResult1["objective"];

$code =  $_SESSION['code'];

/*if($code=='SS5'){

 $save="Update  hos__br set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',status_doc='Request'  where ref_id_br = '".$ref_id_br."' ";
 $qsave=mysqli_query($conn,$save);*/


if($objective=='7'){
	
$save="Update  hos__br set send_dm ='1',approve_time='".$approve_time."',approve_date='".$approve_date."',status_doc='Request'  where ref_id_br = '".$ref_id_br."' ";
$qsave=mysqli_query($conn,$save);
		
}else{
	
$save="Update  hos__br set send_admin ='1',approve_time='".$approve_time."',approve_date='".$approve_date."',status_doc='Approve'  where ref_id_br = '".$ref_id_br."' ";
$qsave=mysqli_query($conn,$save);
	
}
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
	 if($_SESSION["department"]=='วิศวกรรม'){
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supbreng_edit.php?ref_id_br=$ref_id_br';";		 
	 }else{
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supbrhos_edit.php?ref_id_br=$ref_id_br';";
	 }
echo "</script>";
  } else {
   echo "Cannot";
  }
	
	

	
?>
