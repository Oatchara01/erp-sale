<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$em_id = $_GET["em_id"];
$user_id = $_GET["user_id"];
$pass = $_GET["pass"];
$name = $_GET["name"];
$surname = $_GET["surname"];
$position = $_GET["position"];
$mail_intra = $_GET["mail_intra"];
$ext = $_GET["ext"];
$type_login = $_GET["type_login"];
$employee_tel = $_GET["employee_tel"];
$department = $_GET["department"];
$code = $_GET["code"];


$save="insert into tb_user
(em_id,user_id,pass,name,surname,position,mail_intra,ext,type_login,employee_tel,department,code)
values
('".$em_id."','".$user_id."','".$pass."','".$name."','".$surname."','".$position."','".$mail_intra."','".$ext."','".$type_login."','".$employee_tel."','".$department."','".$code."')";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_user.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>