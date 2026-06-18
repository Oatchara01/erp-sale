<?php
include "dbconnect.php";
include ('head.php');


  $ref_id_br = $_GET['ref_id_br'];
  $sale_code = $_GET['sale_code'];
  $name =  $_SESSION['name'];
  $surname =	$_SESSION['surname'];
  $add_by = "$name $surname";
  $add_date = date('Y-m-d H:i:s');


	$save="UPDATE in__br SET send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."'  WHERE ref_id_br = '".$ref_id_br."' ";
	$qsave=mysqli_query($conn,$save);
 
 if($qsave){
	 
echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_breng_edit_breq.php?ref_id_br=$ref_id_br';";
echo "</script>";	 
	 
} else {
echo "Cannot";
}
	

	
?>
