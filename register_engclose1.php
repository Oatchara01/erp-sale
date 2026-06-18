<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];
$date_story = date('Y-m-d');
$time_story = date("H:i:s");
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$remark_adm = $_POST["remark_adm"];
$btn_sub = $_POST["btn_sub"];


$save="UPDATE tb_register_eng SET summary_adm='1',date_sumadm='".$date_story."',time_sumadm='".$time_story."',admin_name='".$add_by."',remark_adm='".$remark_adm."' where ref_id = '".$ref_id."'";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_engpend.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>