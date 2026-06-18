 
<?php
include('head.php'); 
 include "dbconnect.php";
 include "dbconnect_cs.php";
date_default_timezone_set("Asia/Bangkok");

$sale_neat = $_POST["sale_neat"];
$grade = $_POST["grade"];
$sale_data = $_POST["sale_data"];
$sale_3 = $_POST["sale_3"];
$product_corect = $_POST["product_corect"];
$product_link = $_POST["product_link"];
$product_good = $_POST["product_good"];
$product_3 = $_POST["product_3"];
$running_id = $_POST["running_id"];
$suggest_1  = $_POST["suggest_1"];
$ref_id = $_POST["ref_id"];
$type_login = $_SESSION['type_login'];
$suggest  = $_POST["suggest"];
$customer_name = $_POST["customer_name"];
$date_research = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');
$iv_number = $_POST["iv_number"];	
$product_name  = $_POST["product_name"];	
$sale_code	= $_POST["sale_code"];	
$customer_tel= $_POST["customer_tel"];	
$date_sale = $_POST["date_sale"];	
$team_send = $_POST["team_send"];	
$no_research = $_POST["no_research"];
$iv_date =  $_POST["iv_date"];
$type_customer ='ลูกค้าทั่วไป';	
	

	
$strSQL89 =   "insert into  tb_research (running_id,product_good,product_link,suggest_1,product_corect,add_by1,sale_neat,sale_data,sale_3,suggest,customer_name,date_research,iv_number,product_name,sale_code,customer_tel,add_date1,red_id,date_sale,type_customer,team_send,grade,no_research,iv_date,product_3) 
values ('".$running_id."','".$product_good."','".$product_link."','".$suggest_1."','".$product_corect."','".$add_by."','".$sale_neat."','".$sale_data."','".$sale_3."','".$suggest."','".$customer_name."','".$date_research."','".$iv_number."','".$product_name."','".$sale_code."','".$customer_tel."','".$add_date."','".$ref_id."','".$date_sale."','".$type_customer."','".$team_send."','".$grade."','".$no_research."','".$iv_date."','".$product_3."') ";
	
 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());	
	

 	
if($objQuery89){
 
	  echo "<script language=\"JavaScript\">";
	echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_commentd_r.php?red_id=$ref_id';";
	echo "</script>";
  
  } else {
   echo "Cannot";
  }

?>

