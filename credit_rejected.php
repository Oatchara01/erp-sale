<?php
include "head.php";
include "dbconnect.php";


  $ref_credit = $_GET['ref_credit'];
  $sale_code = $_GET['sale_code'];
 $name = $_SESSION['name'];
 $add_date = date('Y-m-d');


$save="Update  tb_credit_note set status_doc ='Rejected',approve_name='".$name."',approve_date='".$add_date."'  where ref_credit = '".$ref_credit."' ";

$qsave=mysqli_query($conn,$save);
 
 
if($qsave) {

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_credit_approve.php';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
