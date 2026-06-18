<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$em_id = $_POST["em_id"];
$user_id = $_POST["user_id"];
$pass = $_POST["pass"];
$name = $_POST["name"];
$surname = $_POST["surname"];
$position = $_POST["position"];
$mail_intra = $_POST["mail_intra"];
$ext = $_POST["ext"];
$type_login = $_POST["type_login"];
$employee_tel = $_POST["employee_tel"];
$department = $_POST["department"];
$code = $_POST["code"];
$id = $_POST["id"];

$save="Update tb_user set
em_id='".$em_id."',user_id='".$user_id."',pass='".$pass."',name='".$name."',surname='".$surname."',position='".$position."',mail_intra='".$mail_intra."',ext='".$ext."',type_login='".$type_login."',employee_tel='".$employee_tel."',department='".$department."',code='".$code."' where id = '".$id."'

";


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