<?php

include("head.php");


$add_date = date('Y-m-d H:i:s');
$approve_code = $_SESSION['code'];
$approve_name =  $_SESSION['name'];


$sale_date= date('Y-m-d');
$approve_time = date("H:i:s");

  $order_ckk=$_GET['order_ckk'];
  $canncel_ckk=$_GET["canncel_ckk"];		
  $ref_id=$_GET['ref_id'];
  
  foreach($ref_id as $key =>$value)
	{

$order_ckk_new = $order_ckk[$key];
$canncel_ckk_new = $canncel_ckk[$key];
$ref_id_new = $ref_id[$key];

$ref_id_cut = substr($ref_id_new,0,2);	  
	  
	  
	
if($order_ckk_new=='1'){

if($ref_id_cut=='SO'){
	
$strSQL="Update  hos__so set status_doc = 'Approve',cm_name='".$approve_name."',cm_date = '".$add_date."',send_admin='1'  where ref_id='".$ref_id_new."'";
	
$objQuery = mysqli_query($conn,$strSQL);


$strSQL28="Update  hos__subso set status_so = 'Approve' where ref_idd='".$ref_id_new."'";
$objQuery28 = mysqli_query($conn,$strSQL28);
	
}else{	
$strSQL =  "Update so__main set  approve_complete='Approve',approve_date='".$add_date."',approve_name='".$approve_name."' where ref_id='".$ref_id_new."'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
	
}
	

}
	

if($canncel_ckk_new=='1'){
	
if($ref_id_cut=='SO'){	
	
$strSQL="Update  hos__so set status_doc = 'ยกเลิก',cm_name='".$approve_name."',cm_date = '".$add_date."',send_admin='1'  where ref_id='".$ref_id_new."'";
$objQuery = mysqli_query($conn,$strSQL);

$strSQL28="Update  hos__subso set status_so = 'ยกเลิก' where ref_idd='".$ref_id_new."'";
$objQuery28 = mysqli_query($conn,$strSQL28);
	
}else{	
	
$strSQL =  "Update so__main set  cancel_ckk='1',approve_date='".$add_date."',approve_name='".$approve_name."' where ref_id='".$ref_id_new."'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
	
}
	

	

}
	  
	  
  }	  
	  
//exit();	  

 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_adminprice.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
	mysql_close();
?>