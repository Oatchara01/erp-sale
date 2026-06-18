<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];
$dept_en = $_POST["dept_en"];
$dept_st = $_POST["dept_st"];
$dept_cs = $_POST["dept_cs"];
$dept_sale = $_POST["dept_sale"];
$per = $_POST["per"];
$per_no = $_POST["per_no"];
$smp = $_POST["smp"];
$smp_no = $_POST["smp_no"];
$spr = $_POST["spr"];
$spr_no = $_POST["spr_no"];
$chang = $_POST["chang"];
$chang_no = $_POST["chang_no"];
$par = $_POST["par"];
$par_no = $_POST["par_no"];
$car = $_POST["car"];
$car_no = $_POST["car_no"];
$description = $_POST["description"];
$dept_adm = $_POST["dept_adm"];

$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$em_no =  $_SESSION['emid'];
$add_date = date('Y-m-d H:i:s');




$save="UPDATE  no__complete SET dept_en='".$dept_en."',dept_st='".$dept_st."',dept_cs='".$dept_cs."',dept_sale='".$dept_sale."',per='".$per."',per_no='".$per_no."',smp='".$smp."',smp_no='".$smp_no."',spr='".$spr."',spr_no='".$spr_no."',chang='".$chang."',chang_no='".$chang_no."',par='".$par."',par_no='".$par_no."',car='".$car."',car_no='".$car_no."',description='".$description."',sup_name='".$add_by."',sup_date='".$add_date."',dept_adm='".$dept_adm."'    where ref_id='".$ref_id."'";


$qsave=mysqli_query($conn,$save);
	

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_noadapprove.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


