<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];
$ref_pc = $_POST["ref_pc"];

$check1 = $_POST["check1"];
$check2 = $_POST["check2"];
$check3 = $_POST["check3"];
$check4 = $_POST["check4"];
$check5 = $_POST["check5"];
$check6 = $_POST["check6"];
$check7 = $_POST["check7"];
$check8 = $_POST["check8"];
$check9 = $_POST["check9"];
$check10 = $_POST["check10"];
$check11 = $_POST["check11"];
$check12 = $_POST["check12"];
$check13 = $_POST["check13"];
$check14 = $_POST["check14"];
$check15 = $_POST["check15"];
$check16 = $_POST["check16"];
$check17 = $_POST["check17"];
$check18 = $_POST["check18"];
$check19 = $_POST["check19"];
$check20 = $_POST["check20"];
$check21 = $_POST["check21"];
$check22 = $_POST["check22"];
$check23 = $_POST["check23"];
$check24 = $_POST["check24"];
$check25 = $_POST["check25"];
$check26 = $_POST["check26"];
$check27 = $_POST["check27"];
$check28 = $_POST["check28"];
$check29 = $_POST["check29"];


$des1 = $_POST["des1"];
$des2 = $_POST["des2"];
$des3 = $_POST["des3"];
$des4 = $_POST["des4"];
$des5 = $_POST["des5"];
$des6 = $_POST["des6"];
$des7 = $_POST["des7"];
$des8 = $_POST["des8"];
$des9 = $_POST["des9"];
$des10 = $_POST["des10"];
$des11 = $_POST["des11"];
$des12 = $_POST["des12"];
$des13 = $_POST["des13"];
$des14 = $_POST["des14"];
$des15 = $_POST["des15"];
$des16 = $_POST["des16"];
$des17 = $_POST["des17"];
$des18 = $_POST["des18"];
$des19 = $_POST["des19"];
$des20 = $_POST["des20"];
$des21 = $_POST["des21"];
$des22 = $_POST["des22"];
$des23 = $_POST["des23"];
$des24 = $_POST["des24"];
$des25 = $_POST["des25"];
$des26 = $_POST["des26"];
$des27 = $_POST["des27"];
$des28 = $_POST["des28"];
$des29 = $_POST["des29"];
	
$close_ckk = $_POST["close_ckk"];
$close_des = $_POST["close_des"];	

$emid =  $_SESSION["emid"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$today = date('Y-m-d');

$save=" UPDATE tb_product_checklis SET check1='".$check1."',check2='".$check2."',check3='".$check3."',check4='".$check4."',check5='".$check5."',check6='".$check6."',check7='".$check7."',check8='".$check8."',check9='".$check9."',check10='".$check10."',check11='".$check11."',check12='".$check12."',check13='".$check13."',check14='".$check14."',check15='".$check15."',check16='".$check16."',check17='".$check17."',check18='".$check18."',check19='".$check19."',check20='".$check20."',check21='".$check21."',check22='".$check22."',check23='".$check23."',check24='".$check24."',check25='".$check25."',check26='".$check26."',check27='".$check27."',check28='".$check28."',check29='".$check29."',des1 ='".$des1."',des2 ='".$des2."',des3 ='".$des3."',des4 ='".$des4."',des5 ='".$des5."',des6 ='".$des6."',des7 ='".$des7."',des8 ='".$des8."',des9 ='".$des9."',des10 ='".$des10."',des11 ='".$des11."',des12 ='".$des12."',des13='".$des13."',des14 ='".$des14."',des15 ='".$des15."',des16 ='".$des16."',des17 ='".$des17."',des18 ='".$des18."',des19 ='".$des19."',des20 ='".$des20."',des21 ='".$des21."',des22 ='".$des22."',des23 ='".$des23."',des24 ='".$des24."',des25 ='".$des25."',des26 ='".$des26."',des27 ='".$des27."',des28 ='".$des28."',des29 ='".$des29."',save_date='".$today."',add_date='".$add_date."',add_by='".$add_by."',emp_code='".$emid."',name_s='".$name."',close_ckk='".$close_ckk."',close_des='".$close_des."'   where  ref_pcc='".$ref_pc."' and go_back='2' and type_emp ='EN'";

$qsave=mysqli_query($conn,$save);


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_checklienbk.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
}
	


