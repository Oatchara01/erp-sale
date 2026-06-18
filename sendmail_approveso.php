<?php
include "dbconnect.php";
include "head.php";

$ref_id = $_GET['ref_id'];
$have_product = $_GET["have_product"];
$sale_code = $_GET['sale_code'];
$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
//echo  $sale_code;
//exit();
$code =  $_SESSION['code'];

/*if($code=='S31' or $code=='S32'){
$save="Update  hos__so set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',send_admin='0',status_doc='Pending review'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);	
}else{*/	
$save="Update  hos__so set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',send_admin='0',status_doc='Request'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
//}


if($have_product !=''){
$save="Update  hos__so set have_product ='2' where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
}



 if($qsave){
 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_salehos_edit.php?ref_id=$ref_id';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
