<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {



$emy_receive = $_POST["customer_signature_name"];
$type_company = $_POST["type_company"];
$num_bus = $_POST["num_bus"];
$emy_tel = $_POST["emy_tel"];
if($type_company=='1'){
$company44 ="31";
}else if($type_company=='2'){
$company44 ="42";
}

$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$today = date('Y-m-d');

$save="insert into st__kerry
(date_kerry,type_company,type_group,emy_receive,num_bus,emy_tel,add_date,add_by)
values
('".$today."','".$type_company."','1','".$emy_receive."','".$num_bus."','".$emy_tel."','".$add_date."','".$add_by."')";

$qsave=mysqli_query($conn,$save);


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='report_kerrysol.php?start_date=$today&company=$company44';";
echo "</script>";
  } else {
   echo "Cannot";
  }
}
	


