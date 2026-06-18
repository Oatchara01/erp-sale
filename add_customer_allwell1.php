<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
	
function normalizeThaiName($text) {
    $text = trim($text);
    $text = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
    $text = preg_replace('/[\p{Z}\s]+/u', ' ', $text);
    return trim($text);
}

	
$qfirst = "select * from tb_customer ORDER BY customer_id DESC LIMIT 1";
$first = mysqli_query($conn,$qfirst);
$Num_Rows88 = mysqli_num_rows($first);
$ffirst = mysqli_fetch_array($first);
	
$customer_id = $ffirst['customer_id']+1;	
	
	
$customer_name = normalizeThaiName($_POST['customer_name']);
$customer_code = $_POST["customer_code"];
$preface_name = $_POST["preface_name"];
//$customer_name = $_POST["customer_name"];
//$customer_name ="$preface_name$customer_name1";	
$type_customer = $_POST["type_customer"];
//$credit_ckk = $_POST["credit_ckk"];
$cus_address = $_POST["cus_address"];
$cus_ampher = $_POST["cus_ampher"];
$cus_province = $_POST["cus_province"];
$cus_postcode = $_POST["cus_postcode"];
$cus_tel = $_POST["cus_tel"];
$cus_tel1 = substr($cus_tel, -9);	
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";	
	

$cus_fax = $_POST["cus_fax"];

$ckk_1 = $_POST["ckk_1"];	
	
	
if($ckk_1=='1'){	
$bill_name = "$customer_name";
$bill_address = $_POST["cus_address"];
$bill_ampher = $_POST["cus_ampher"];
$billl_province = $_POST["cus_province"];
$bill_postcode = $_POST["cus_postcode"];
$bill_tel = $_POST["cus_tel"];

}else{
	
$bill_name = $_POST["bill_name"];
$bill_address = $_POST["bill_address"];
$bill_ampher = $_POST["bill_ampher"];
$billl_province = $_POST["billl_province"];
$bill_postcode = $_POST["bill_postcode"];
$bill_tel = $_POST["bill_tel"];	
	
}

	
	
$tax_id = $_POST["tax_id"];
	
$ckk_2 = $_POST["ckk_2"];	
	
	
if($ckk_2=='1'){	
$delivery_name = "$preface_name$customer_name";
$del_address = $_POST["cus_address"];
$del_ampher = $_POST["cus_ampher"];
$del_province = $_POST["cus_province"];
$del_postcode = $_POST["cus_postcode"];
$del_tel = $_POST["cus_tel"];	
	
}else{
$delivery_name = $_POST["delivery_name"];
$del_address = $_POST["del_address"];
$del_ampher = $_POST["del_ampher"];
$del_province = $_POST["del_province"];
$del_postcode = $_POST["del_postcode"];
$del_tel = $_POST["del_tel"];
}
	

if($_POST["contact_name"] !='')	{
$contact_name = $_POST["contact_name"];	
	}else{
$contact_name ="$customer_name/$cus_tel";	
}
	

$sale_code = $_POST["sale_code"];
 if($_SESSION["department"]=='วิศวกรรม'){ 
	$eng_ckk = '1'; 
 }else{
	$eng_ckk = '0';  
 }
	
$email_cus = $_POST["email_cus"];
$vip_ckk = $_POST["vip_ckk"];

$sql2 = "SELECT cus_tel FROM tb_customer where cus_tel LIKE '%".$cus_tel1."%'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$fetch2 = mysqli_fetch_array($query2);
	
	

if($fetch2["cus_tel"]!=''){
	
echo "<script language=\"JavaScript\">";
echo "alert('เบอร์โทรนี้ $cus_tel มีข้อมูลลูกค้าอยู่แล้วนะคะ');window.location='status_customerallwell.php';";
echo "</script>";
exit();
	
if($tax_id!=''){	

	
$sql3 = "SELECT tax_id FROM tb_customer where cus_tel LIKE '%".$tax_id."%'";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$fetch3 = mysqli_fetch_array($query3);
	
if($fetch3["tax_id"]!=''){
	
echo "<script language=\"JavaScript\">";
echo "alert('เลขผู้เสียภาษีนี้ $tax_id มีข้อมูลลูกค้าอยู่แล้วนะคะ');window.location='status_customerallwell.php';";
echo "</script>";
exit();
	
}	
	
}else{
	
}

	
}else{


$save="insert into tb_customer
(customer_name,type_customer,preface_name,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,cus_fax,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,edit_name,edit_date,email_cus,vip_ckk)
values
('".$customer_name."','".$type_customer."','".$preface_name."','".$cus_address."','".$cus_ampher."','".$cus_province."','".$cus_postcode."','".$cus_tel."','".$cus_fax."','".$bill_name."','".$bill_address."','".$bill_ampher."','".$billl_province."','".$bill_postcode."','".$bill_tel."','".$tax_id."','".$delivery_name."','".$del_address."','".$del_ampher."','".$del_province."','".$del_postcode."','".$del_tel."','".$contact_name."','".$add_by."','".$add_date."','".$email_cus."','".$vip_ckk."')";


$qsave=mysqli_query($conn,$save);

}

if($sale_code!=''){

    $sql = "INSERT INTO tb_selected_sales (sale_code, id_customer, customer_name) VALUES ('$sale_code', '$customer_id', '$bill_name')";
    $qsave2 = mysqli_query($conn, $sql);
	
	
}


/*$sql1 = "select * from tb_customer_pre order by id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC);
$id = $fetch1["id"];*/



 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='edit_customer_allwell.php?customer_id=$customer_id'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>