<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_idsmp = $_POST['ref_idsmp'];
$ref_no =$_POST["ref_no"];	
$ref_no1 =$_POST["ref_no1"];	
$date_ker =$_POST["date_ker"];	
$ker_bath =$_POST["ker_bath"];	

$save="Update  hos__smp set ker_bath ='".$ker_bath."',date_ker='".$date_ker."',ref_no1='".$ref_no1."',ref_no = '".$ref_no."'  where ref_idsmp = '".$ref_idsmp."'";


$qsave=mysqli_query($conn,$save);


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminsmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


