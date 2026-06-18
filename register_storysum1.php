<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$admin_name = "$name $surname";
$date_sumadm = date('Y-m-d');
$time_sumadm = date('H:i:s');

$id_story = $_POST["id_story"];
$summary_adm = $_POST["summary_adm"];
$remark_adm = 	$_POST["remark_adm"];
	

$save="UPDATE tb_register_story SET admin_name='".$admin_name."',summary_adm='".$summary_adm."',date_sumadm='".$date_sumadm."',time_sumadm='".$time_sumadm."',remark_adm='".$remark_adm."'  where id_story = '".$id_story."'";

$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_storykang.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>