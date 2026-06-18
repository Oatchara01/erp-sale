<?php
include "dbconnect.php";
include "head.php";


  $ref_id = $_GET['ref_id'];
  $sale_code = $_SESSION['code'];
  $name =  $_SESSION['name'];
  $surname =	$_SESSION['surname'];
  $add_by = "$name $surname";
  $add_date = date('Y-m-d H:i:s');
  $doc_date = date('Y-m-d');




 $save="Update  hos__rental set status_doc='Rejected',sup_name='".$add_by."',sup_date='".$add_date."'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($conn,$save);




if($qsave){
 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_apprental.php';";
echo "</script>";

  }else{
   echo "Cannot";
  }
  
	

	
?>
