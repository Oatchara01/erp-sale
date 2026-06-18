<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$mode_name = $_POST["mode_name"];
$id_mode = $_POST["id_mode"];


$save="UPDATE tb_mode_customer SET mode_name='".$mode_name."' WHERE id_mode ='".$id_mode."'";
$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_modecus.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>