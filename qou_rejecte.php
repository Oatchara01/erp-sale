<?php include ("head.php"); ?>
<?php
include "dbconnect.php";

$name = $_SESSION["name"];
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
  $ref_id = $_GET['ref_id'];

$save="Update  qou__main set status_doc='Rejected',sup_name='".$add_by."',sup_date='".$add_date."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 	
		


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_appqou.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

?>