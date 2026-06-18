<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$customer_name  = $_POST["customer_name"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$date_story = date('Y-m-d');
$time_story = date("H:i:s");
$contact_name = $_POST["contact_name"];
$address_name = $_POST["address_name"];
$description = $_POST["description"];
$tel_number = $_POST["tel_number"];
$fax = $_POST["fax"];
$email = $_POST["email"];
$sale_code = $_POST["sale_code"];
$receive_name = $_POST["receive_name"];
$remark_adm = $_POST["remark_adm"];
$id_story = $_POST["id_story"];


$save="UPDATE tb_register_story SET
customer_name='".$customer_name."',date_story='".$date_story."',time_story='".$time_story."',contact_name='".$contact_name."',address_name='".$address_name."',description='".$description."',tel_number='".$tel_number."',fax='".$fax."',email='".$email."',sale_code='".$sale_code."',receive_name='".$receive_name."',remark_adm='".$remark_adm."' where id_story = '".$id_story."'";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_story_edit.php?id_story=$id_story'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>