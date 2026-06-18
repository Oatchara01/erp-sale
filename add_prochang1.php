<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$prochange = $_GET["prochange"];


$save="insert into tb_prochange (prochange) values ('".$prochange."')";
$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_prochang.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>