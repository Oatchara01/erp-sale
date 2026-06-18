<?php
include "dbconnect.php";


$ref_id = $_GET['ref_id'];

 $save="Update  no__complete set status_doc ='Approve'  where ref_id = '".$ref_id."' ";

$qsave=mysqli_query($conn,$save);
 
 
 if($qsave){
 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_noadapprove.php?ref_id=$ref_id';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
