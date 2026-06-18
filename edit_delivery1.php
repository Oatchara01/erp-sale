<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$delivery_id = $_POST["delivery_id"];
$delivery_name = $_POST["delivery_name"];
$drop_place  = $_POST["drop_place"];
$employee_send = $_POST["employee_send"];
$time_delivery = $_POST["time_delivery"];
$remark = $_POST["remark"];
$packing_remark = $_POST["packing_remark"];




$save="Update  tb_delivery set  
delivery_name='".$delivery_name."',drop_place='".$drop_place."',employee_send='".$employee_send."',time_delivery='".$time_delivery."',remark='".$remark."',packing_remark='".$packing_remark."' where  delivery_id= '".$delivery_id."'
";


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