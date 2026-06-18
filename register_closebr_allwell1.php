
<?php
include("dbconnect.php");
include ("error_page.php"); 
include("head.php");

date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$ref_id = trim($_GET["ref_id"]);
$code =	$_SESSION["code"];

$save="Update  so__main set close_br ='1'  where ref_id='".$ref_id."'";
$qsave=mysqli_query($conn,$save);
	
$save1="Update  so__submain set clear_ckk ='1'  where ref_idd='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
	 
	 if($code=='Admin'){
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_clear_admin.php';";
	 }else {
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_brclear_allwell.php';";		 
		 
	 }
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


