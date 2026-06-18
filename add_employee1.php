<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$employee_name = $_GET["employee_name"];
$department_id  = $_GET["department_id"];
$status = $_GET["status"];




$save="insert into tb_employee
(employee_name,department_id,status)
values
('".$employee_name."','".$department_id."','".$status."')";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_employee.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>