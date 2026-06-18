<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];
$description = $_POST["description"];


$save="UPDATE hos__po SET description='".$description."'   Where ref_id ='".$ref_id."'";
$qsave=mysqli_query($conn,$save);
	
	

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='edit_po.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}