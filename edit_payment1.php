<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$payment_ID = $_GET["payment_ID"];
$payment_name = $_GET["payment_name"];
$bank_name = $_GET["bank_name"];
$book_number = $_GET["book_number"];
$branch_bank = $_GET["branch_bank"];
$book_type = $_GET["book_type"];
$book_name = $_GET["book_name"];
$description_payment = $_GET["description_payment"];




$save="Update tb_payment set
payment_name='".$payment_name."',bank_name='".$bank_name."',book_number='".$book_number."',branch_bank='".$branch_bank."',book_type='".$book_type."',book_name='".$book_name."',description_payment='".$description_payment."' where  payment_ID = '".$payment_ID."'
";


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