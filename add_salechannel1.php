<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$salechannel_nameshort = $_GET["salechannel_nameshort"];
$salechannel_name  = $_GET["salechannel_name"];
$address1 = $_GET["address1"];
$address2 = $_GET["address2"];
$province_id = $_GET["province_id"];
$zip_code = $_GET["zip_code"];
$description_chanel  = $_GET["description_chanel"];




$save="insert into tb_salechannel
(salechannel_nameshort,salechannel_name,address1,address2,province_id,zip_code,description_chanel)
values
('".$salechannel_nameshort."','".$salechannel_name."','".$address1."','".$address2."','".$province_id."','".$zip_code."','".$description_chanel."')";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_salechannel.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>