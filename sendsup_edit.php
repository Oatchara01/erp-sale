<?php
include "dbconnect.php";


 $ref_id = $_GET['ref_id'];
$select_type_doc = $_GET["select_type_doc"];
 if($_GET['bill_vat']=='1'){
 $status_vat = "Approve";	
	 $send_supadm ='1';
 }else{
$status_vat = "";		 
 }
$send_supdate = date('Y-m-d H:i:s');


 $strSQL25="Update  so__main set approve_complete='Request',status_vat='".$status_vat."',send_supadm ='".$send_supadm."',send_supdate='".$send_supdate."'  where ref_id='".$ref_id."'";

$objQuery25 = mysqli_query($conn,$strSQL25);
 
 
 if($objQuery25){
if($select_type_doc=='1' or $select_type_doc=='2'){	
	
echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Sup เรียบร้อยแล้วค่ะ');window.location='register_allwell_bredit.php?ref_id=$ref_id';";
echo "</script>";
	
}else{
	 
echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Sup เรียบร้อยแล้วค่ะ');window.location='register_allwell_edit.php?ref_id=$ref_id';";
echo "</script>";
	
}
  } else {
   echo "Cannot";
  }
  ?>