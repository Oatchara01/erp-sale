<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$sale_name = "$name $surname";
$date_sumsale = date('Y-m-d');
$time_sumsale = date('H:i:s');

$id_story = $_POST["id_story"];
$summary_sale = $_POST["summary_sale"];
$remark_sale = $_POST["remark_sale"];
$type_login =  $_SESSION['type_login'];

$save="UPDATE tb_register_story SET sale_name='".$sale_name."',summary_sale='".$summary_sale."',date_sumsale='".$date_sumsale."',time_sumsale='".$time_sumsale."',remark_sale = '".$remark_sale."' where id_story = '".$id_story."'";

$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
	 if($type_login =='Sup_Sale'){
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_storykangsup.php'";
	 }else if($type_login =='Admin'){
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_storyadmkang.php'";		 
	 }else{
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_storykangsale.php'";		 
	 }
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>