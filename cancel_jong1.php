<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$cancel_ckk = $_POST["cancel_ckk"];
$remark = $_POST["remark"];
$ref_id = $_POST["ref_id"];
	

$save="UPDATE  hos__jongproduct SET remark = '".$remark."',cancel_ckk = '".$cancel_ckk."',close_jong = '".$cancel_ckk."'  where ref_id = '".$ref_id."'";
$qsave=mysqli_query($conn,$save);

$strSQL1 = "Update  hos__subjongpro set  close_ckk ='1' where ref_idd = '".$ref_id."'";
$objQuery1 = mysqli_query($conn,$strSQL1);

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_salejong_clear.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

	}


