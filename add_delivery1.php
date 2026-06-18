<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$delivery_name = $_GET["delivery_name"];
$drop_place  = $_GET["drop_place"];
$employee_send = $_GET["employee_send"];
$time_delivery = $_GET["time_delivery"];
$remark = $_GET["remark"];
$packing_remark = $_GET["packing_remark"];




$save="insert into tb_delivery
(delivery_name,employee_send,drop_place,time_delivery,remark,packing_remark)
values
('".$delivery_name."','".$employee_send."','".$drop_place."','".$time_delivery."','".$remark."','".$packing_remark."')";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_delivery.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>