<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$payment_name = $_GET["payment_name"];
$bank_name = $_GET["bank_name"];
$book_number = $_GET["book_number"];
$branch_bank = $_GET["branch_bank"];
$book_type = $_GET["book_type"];
$book_name = $_GET["book_name"];
$description_payment = $_GET["description_payment"];




$save="insert into tb_payment
(payment_name,bank_name,book_number,branch_bank,book_type,book_name,description_payment)
values
('".$payment_name."','".$bank_name."','".$book_number."','".$branch_bank."','".$book_type."','".$book_name."','".$description_payment."')";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_payment.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>