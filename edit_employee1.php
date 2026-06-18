<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$employee_ID = $_POST["employee_ID"];
$employee_name = $_POST["employee_name"];
$department_id  = $_POST["department_id"];
$status = $_POST["status"];




$save="Update  tb_employee set  
 
employee_name='".$employee_name."',department_id='".$department_id."',status='".$status."' where employee_ID = '".$employee_ID."'

";


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