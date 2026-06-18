<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$customer_no = $_POST["customer_no"];
$last_name = $_POST["last_name"];
$first_name = $_POST["first_name"];
$customer_name = $_POST["customer_name"];
$type_customer = $_POST["type_customer"];
$cus_addno = $_POST["cus_addno"];
$cus_addtum = $_POST["cus_addtum"];
$cus_address ="$cus_addno $cus_addtum";
$cus_ampher = $_POST["cus_ampher"];
$cus_province = $_POST["cus_province"];
$cus_postcode = $_POST["cus_postcode"];
$cus_tel = $_POST["cus_tel"];
$sale_code = $_POST["sale_code"];
$customer_id = $_POST["customer_id"];
$brithday = $_POST["brithday"];
$status = $_POST["status"];
$occupation = $_POST["occupation"];
//$salary = $_POST["salary"];
$email_cus = $_POST["email_cus"];
$product_fer1 = $_POST["product_fer1"];
$product_fer2 = $_POST["product_fer2"];
$product_fer3 = $_POST["product_fer3"];
$product_fer4 = $_POST["product_fer4"];
$well_allwell = $_POST["well_allwell"];
$best_service1 = $_POST["best_service1"];
$best_service2 = $_POST["best_service2"];
$best_service3 = $_POST["best_service3"];
$best_service4 = $_POST["best_service4"];
$description = $_POST["description"];
$status_cus = $_POST["status_cus"];
$date = explode('-' ,$brithday);
$newDate = $date[2].'-'.$date[1].'-'.$date[0];
$mounth = $date[1];
	
//,salary= '".$salary."'

	$save=" Update  tb_customer set 
customer_no='".$customer_no."',customer_name='".$customer_name."',type_customer='".$type_customer."',first_name='".$first_name."',cus_address='".$cus_address."',cus_ampher='".$cus_ampher."',cus_province='".$cus_province."',cus_postcode='".$cus_postcode."',cus_tel='".$cus_tel."',last_name='".$last_name."',sale_code= '".$sale_code."',brithday= '".$brithday."',status= '".$status."',occupation= '".$occupation."',email_cus= '".$email_cus."',product_fer1= '".$product_fer1."',product_fer2= '".$product_fer2."',product_fer3= '".$product_fer3."',well_allwell= '".$well_allwell."',best_service1= '".$best_service1."',best_service2= '".$best_service2."',best_service3= '".$best_service3."',best_service4= '".$best_service4."',description= '".$description."',status_cus= '".$status_cus."',product_fer4 = '".$product_fer4."',month='".$mounth."',cus_addno='".$cus_addno."',cus_addtum='".$cus_addtum."'    where customer_id='".$customer_id."'";




$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_customer_rgister.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>