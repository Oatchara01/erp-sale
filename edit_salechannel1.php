<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$salechannel_nameshort = $_POST["salechannel_nameshort"];
$salechannel_name  = $_POST["salechannel_name"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$province_id = $_POST["province_id"];
$zip_code = $_POST["zip_code"];
$description_chanel  = $_POST["description_chanel"];
$salechannel_ID  = $_POST["salechannel_ID"];


$save="Update  tb_salechannel set  
salechannel_nameshort='".$salechannel_nameshort."',salechannel_name='".$salechannel_name."',address1='".$address1."',address2='".$address2."',province_id='".$province_id."',zip_code='".$zip_code."',description_chanel='".$description_chanel."' where salechannel_ID = '".$salechannel_ID."'
";


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