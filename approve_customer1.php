<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
	
$id = $_POST["id"];
$customer_code = $_POST["customer_code"];
$preface_name = $_POST["preface_name"];
$customer_name1 = $_POST["customer_name"];
$customer_name ="$preface_name$customer_name1";	
$type_customer = $_POST["type_customer"];
$vip_ckk = $_POST["vip_ckk"];	
$cus_address = $_POST["cus_address"];
$cus_ampher = $_POST["cus_ampher"];
$cus_province = $_POST["cus_province"];
$cus_postcode = $_POST["cus_postcode"];
$cus_tel = $_POST["cus_tel"];
$cus_tel1 = substr($cus_tel, -9);	
$cus_fax = $_POST["cus_fax"];
$credit_ckk = $_POST["credit_ckk"];
	
$bill_name = $_POST["bill_name"];
$bill_address = $_POST["bill_address"];
$bill_ampher = $_POST["bill_ampher"];
$billl_province = $_POST["billl_province"];
$bill_postcode = $_POST["bill_postcode"];
$bill_tel = $_POST["bill_tel"];	
	
$tax_id = $_POST["tax_id"];
$eng_ckk = $_POST["eng_ckk"];	

$delivery_name = $_POST["delivery_name"];
$del_address = $_POST["del_address"];
$del_ampher = $_POST["del_ampher"];
$del_province = $_POST["del_province"];
$del_postcode = $_POST["del_postcode"];
$del_tel = $_POST["del_tel"];
$contact_name = $_POST["contact_name"];	
$sale_code = $_POST["sale_code"];
$add_date = date('Y-m-d H:i:s');
$email_cus = $_POST["email_cus"];	


$sql2 = "SELECT cus_tel FROM tb_customer where cus_tel LIKE '%".$cus_tel1."%'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$fetch2 = mysqli_fetch_array($query2);

if($fetch2["cus_tel"] !=''){
	
echo "<script language=\"JavaScript\">";
echo "alert('เบอร์โทรนี้ $cus_tel มีข้อมูลลูกค้าอยู่แล้วนะคะ');window.location='status_customerapp.php';";
echo "</script>";
exit();

	
}else{

$strSQL28="Update  tb_customer_pre set status_cus='Approve',app_dt='".$add_date."'  where id ='".$id."'";
$objQuery28 = mysqli_query($conn,$strSQL28);

	
$qfirst = "select * from tb_customer ORDER BY customer_id DESC LIMIT 1";
$first = mysqli_query($conn,$qfirst);
$Num_Rows88 = mysqli_num_rows($first);
$ffirst = mysqli_fetch_array($first);
	
$customer_id = $ffirst['customer_id']+1;	
	


$save="insert into tb_customer
(customer_code,customer_name,type_customer,preface_name,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,cus_fax,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,sale_code,online,email_cus,vip_ckk,credit_ckk)
values
('".$customer_code."','".$customer_name."','".$type_customer."','".$preface_name."','".$cus_address."','".$cus_ampher."','".$cus_province."','".$cus_postcode."','".$cus_tel."','".$cus_fax."','".$bill_name."','".$bill_address."','".$bill_ampher."','".$billl_province."','".$bill_postcode."','".$bill_tel."','".$tax_id."','".$delivery_name."','".$del_address."','".$del_ampher."','".$del_province."','".$del_postcode."','".$del_tel."','".$contact_name."','".$sale_code."','1','".$email_cus."','".$vip_ckk."','".$credit_ckk."')";

$qsave=mysqli_query($conn,$save);
	
$sql = "INSERT INTO tb_selected_sales (sale_code, id_customer, customer_name) VALUES ('$sale_code', '$customer_id', '$bill_name')";
$qsave2 = mysqli_query($conn, $sql);	
	
}



 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_customerapp.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>