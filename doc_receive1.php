<?php
include "dbconnect.php";

date_default_timezone_set("Asia/Bangkok");
 $add_date = date('Y-m-d H:i:s');
$id_em=$_POST["id_em"];
$id_br=$_POST["id_br"];
$iv_no=$_POST["iv_no"];

$strSQL1 = "SELECT * FROM tb_user where em_id='".$id_em."'";
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);

$add_name= $objResult1['name'];

 
 
$strSQL = "UPDATE tb_register_br SET ";
	$strSQL .=" doc_receive = '".$id_em."'";
	$strSQL .=", date_receive = '$add_date'";
	$strSQL .=", doc_receive1 = '$add_name'";
	$strSQL .="WHERE id_br = '".$id_br."'";
	

 $objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_recevebr.php?Keyword=$iv_no';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	

	
	
?>