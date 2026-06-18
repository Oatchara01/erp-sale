<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];
$name_open = $_POST["name_open"];	
$ref_so =$_POST["ref_so"];
$cancel_ckk = $_POST["cancel_ckk"];
$remark_cancel = $_POST["remark_cancel"];	
$add_date = date('Y-m-d H:i:s');



$save="UPDATE hos__po SET  open_so='1',open_sodate='".$add_date."',name_open='".$name_open."',ref_so='".$ref_so."',cancel_ckk='".$cancel_ckk."',remark_cancel='".$remark_cancel."'  Where ref_id ='".$ref_id."'";

$qsave=mysqli_query($conn,$save);
	
	




	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_adminpo.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}