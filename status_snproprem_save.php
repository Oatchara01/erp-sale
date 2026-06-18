<?php

include("dbconnect.php");
include("head.php");


$add_date = date('Y-m-d H:i:s');
$approve_code = $_SESSION['code'];
$approve_name =  $_SESSION['name'];
$sale_date= date('Y-m-d H:i:s');
$approve_time = date("H:i:s");

  $ckk_close=$_GET['ckk_close'];
  $id=$_GET['id'];
  
  foreach($id as $key =>$value)
	{

$ckk_close_new = $ckk_close[$key];
$id_new = $id[$key];

$ref_id_cut = substr($ref_id_new,0,2);	  
	  
	  
	
if($ckk_close_new=='1'){

	
$strSQL="Update  tb_snproprem set ckk_close='1',close_date = '".$sale_date."',close_by = '".$approve_name."'  where id='".$id_new."'";
	
$objQuery = mysqli_query($conn,$strSQL);


}	  
	  
//exit();	  

 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_snproprem.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
	mysql_close();
?>