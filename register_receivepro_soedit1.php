<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include("dbconnect_acc.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_doc = $_POST["type_doc"];
$bill_name = $_POST["bill_name"];
$bill_address = $_POST["bill_address"];
$type_company = $_POST["type_company"];
$show_name = $_POST["show_name"];
	
	
if ($type_company=='1'){
		$com ="ออลล์เวล ไลฟ์ บจก.";
	}else if ($type_company=='2'){
	$com="โนเบิล เมด บจก.";	
	}	
	
$iv_date = $_POST["iv_date"];
$iv_noref = $_POST["iv_noref"];
$ref_iddoc = $_POST["ref_iddoc"];
$address = $_POST["address"];
$sale_code = $_POST["sale_code"];
$customer = $_POST["customer"];
$send_receive = $_POST["send_receive"];
$delivery_date = $_POST["delivery_date"];

$add_date = date('Y-m-d H:i:s');
$name =	$_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$rp_no = $_POST["rp_no"];
$cancel_ckk = $_POST["cancel_ckk"];
$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$sale_remarkk = $_POST["sale_remarkk"];
$product_id = $_POST["product_id"];
$proname = $_POST["proname"];
$ckk_name = $_POST["ckk_name"];
$amount = $_POST["amount"];



$save="Update hos__proreceive SET customer='".$customer."',address='".$address."',bill_name='".$bill_name."',bill_address='".$bill_address."',cancel_ckk='".$cancel_ckk."',show_name = '".$show_name."' where rp_no ='".$rp_no."'";


$qsave=mysqli_query($conn,$save);

	if($send_receive=='1'){
		
		$strSQL292="insert into   tb_register_data (IV_number,date_inv,company,customer_name,ref_id,description,employee_name,add_date,type_1) values ('".$rp_no."','".$delivery_date."','".$com."','".$customer."','".$ref_iddoc."','".$iv_noref."','".$add_by."','".$add_date."','RP')";

$objQuery292 = mysqli_query($code,$strSQL292);	
			

$strSQL262="Update  hos__proreceive set send_receive ='2'  where rp_no ='".$rp_no."'";
$objQuery262 = mysqli_query($conn,$strSQL262);		
		
		
	}
	
	

foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$sale_count_new =$sale_count[$key];
 		$proname_new =$proname[$key];
		$ckk_name_new =$ckk_name[$key];
		$amount_new =$amount[$key];
	
$strSQL = "Update hos__subproreceive SET  sale_remark='".$sale_remarkk_new."',amount='".$amount_new."',count='".$sale_count_new."',ckk_name='".$ckk_name_new."',proname='".$proname_new."'  where id = '".$id_new."'";
	
$objQuery = mysqli_query($conn,$strSQL);

}

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_receivepro_soedit.php?rp_no=$rp_no';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}