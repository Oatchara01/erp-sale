<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$ref_id =  $_POST["ref_id"];
$pro_come = $_POST["pro_come"];	
$pro_comedate = $_POST["pro_comedate"];	
$brdoc_eng = $_POST["brdoc_eng"];	
$name_eng = $_POST["name_eng"];	
$date_brdoc = $_POST["date_brdoc"];	
	


$save="UPDATE hos__breg SET brdoc_eng='".$brdoc_eng."',name_eng='".$add_by."',date_brdoc='".$add_date."',pro_come='".$pro_come."',pro_comedate='".$pro_comedate."' where ref_id ='".$ref_id."'";
$qsave=mysqli_query($conn,$save);

	
if($save){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_engbregkang.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


