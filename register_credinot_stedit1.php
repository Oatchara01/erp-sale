<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$stock_complete = $_POST["stock_complete"];
$stock_name = $_POST["stock_name"];
$stock_date = $_POST["stock_date"];
$warraty_ckk = $_POST["warraty_ckk"];
$stock_des = $_POST["stock_des"];
$wait_product = $_POST["wait_product"];
$ref_credit = trim($_POST["ref_credit"]);
$receive_name = $_POST["receive_name"];
$date_receive = $_POST["date_receive"];
	
	
$save="Update tb_credit_note set stock_complete='".$stock_complete."',stock_date='".$stock_date."',warraty_ckk='".$warraty_ckk."',stock_name ='".$stock_name."',stock_des = '".$stock_des."',wait_product='".$wait_product."',receive_name='".$receive_name."',date_receive ='".$date_receive."'  where ref_credit = '".$ref_credit."'";

$qsave=mysqli_query($conn,$save);

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credinot_stedit.php?ref_credit=$ref_credit';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}