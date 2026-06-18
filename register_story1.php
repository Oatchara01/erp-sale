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



$save="insert into tb_register_story
(customer_name,add_by,add_date,date_story,time_story,contact_name,address_name,description,tel_number,fax,email,sale_code,receive_name,remark_adm) values ('".$customer_name."','".$add_by."','".$add_date."','".$date_story."','".$time_story."','".$contact_name."','".$address_name."','".$description."','".$tel_number."','".$fax."','".$email."','".$sale_code."','".$receive_name."','".$remark_adm."')";

$qsave=mysqli_query($conn,$save);
	
$sql1 = "select * from tb_register_story order by id_story desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
$id_story =$fetch1["id_story"];

 if($qsave){
   echo "<script language=\"JavaScript\">";
	 if($type_login =='Admin'){
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_storykang.php'";
	 }else{
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_story_edit.php?id_story=$id_story'";		 
	 }
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>