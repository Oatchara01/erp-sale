<?php
include "dbconnect.php";
include "head.php";


  $ref_id = $_GET['ref_id'];
  $sale_code = $_SESSION['code'];
  $rental_name = $_GET["rental_name"];
  $name =  $_SESSION['name'];
  $surname =	$_SESSION['surname'];
  $add_by = "$name $surname";
  $add_date = date('Y-m-d H:i:s');


$code =  $_SESSION['code'];

/*if($code=='S31' or $code=='S32'){
 $save="Update  hos__rental set send_sup ='1',status_doc='Pending review'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($conn,$save);
	
}else{	*/
 $save="Update  hos__rental set send_sup ='1',status_doc='Request'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($conn,$save);
//}
 


if($qsave){
 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_salerental_edit.php?ref_id=$ref_id';";
echo "</script>";

  }else{
   echo "Cannot";
  }
  
	

	
?>
