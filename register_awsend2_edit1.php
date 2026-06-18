<?php
include("dbconnect.php");
include("dbconnect_cs.php");
include("dbconnect_acc.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
$admin_complete = $_POST["admin_complete"];
$main_id = $_POST["main_id"];
$ref_id = $_POST["ref_id"];
$register_date = $_POST["register_date"];
$register_time = $_POST["register_time"];
$sale_channel = $_POST["sale_channel"];
$select_type_doc = $_POST["select_type_doc"];
$delivery = $_POST["h_delivery"];
$payment = $_POST["h_payment"];
$sale_remark = $_POST["sale_remark"];
$employee_name = $_POST["employee_name"];
$buy_ckk = $_POST["buy_ckk"];
$doc_release_date = $_POST["doc_release_date"];
$cash_ckk = $_POST["cash_ckk"];
$job_id = $_POST["job_id"];
$billing_name = $_POST["billing_name"];
$billing_address = $_POST["billing_address"];
$billing_tel = $_POST["billing_tel"];
$bill_vat = $_POST["bill_vat"];
$bill_id = $_POST["bill_id"];
$tax_id = $_POST["tax_id"];
$transfer = $_POST["transfer"];
$account_approve = $_POST["account_approve"];
$transfer_date = $_POST["transfer_date"];
$amount = $_POST["amount"];
$delivery_name = $_POST["delivery_name"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$province = $_POST["province"];
$postcode = $_POST["postcode"];
$tel = $_POST["tel"];
$type_type_detail = $_POST["type_type_detail"];
$delivery_date = $_POST["delivery_date"];
$delivery_time = $_POST["delivery_time"];
$big_car = $_POST["big_car"];
$call_before = $_POST["call_before"];
$maps = $_POST["maps"];
$assign_date_time = $_POST["assign_date_time"];
$delivery_type = $_POST["delivery_type"];
$delivery_place = $_POST["delivery_place"];
$delivery_contact = $_POST["delivery_contact"];
$returns = $_POST["returns"];
$return_date = $_POST["return_date"];
$return_time = $_POST["return_time"];
$return_address = $_POST["return_address"];
$return_contact = $_POST["return_contact"];
$customer_name = $_POST["customer_name"];
$iv_date = $_POST["iv_date"];
$cancel_ckk  = $_POST["cancel_ckk"];
$order_name = $_POST["order_name"];
$status_doc = $_POST["status_doc"];
$ckkdate_vat = $_POST["ckkdate_vat"];
$iv_no = $_POST["iv_no"];
$objective = $_POST["objective"];
$objective_des = $_POST["objective_des"];
$sr_no = $_POST["sr_no"];
$date_edit = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	

	
	

 $between_date =$_POST["date_requir"];
 $start_time=$_POST["start_time"];
 $end_time=$_POST["end_time"];
 $status=$_POST["status"];
	
 if ($_POST["start_date"]!=''){
		$start_date =$_POST["start_date"];
	}else{
		$start_date='0000-00-00';
	}
	
	if ($_POST['fix_datetime']!=''){
		$fix_date=$_POST['fix_datetime'];
	}else{
		$fix_date='0';
	}
	
	if ($_POST['no_money']!=''){
        $no_price=$_POST['no_money'];
	}else{
		$no_price='0';
	}
	if ($_POST['call_customer']!=''){
		 $call_customer=$_POST['call_customer'];
	}else{
		$call_customer='0';
	}
	if ($_POST['credit_card']!=''){
		 $credit=$_POST['credit_card'];
	}else{
		$credit='0';
	}
	if ($_POST['call_back']!=''){
		 $call_employee=$_POST['call_back'];
	}else{
		$call_employee='0';
	}
	
	if ($_POST['cash']!=''){
		 $chash=$_POST['cash'];
	}else{
		$chash='0';
	}
	if ($_POST['check_paper']!=''){
	 $check_peper=$_POST['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($_POST['check_paper']!=''){
		$check_peper=$_POST['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($_POST['bill']!=''){
		 $bill=$_POST['bill'];
	}else{
		$bill='0';
	}
	if ($_POST['want_bus']!=''){
	$want_bus=$_POST['want_bus'];
	}else{
		$want_bus='0';
	}
	if ($_POST['tran']!=''){
		 $tran=$_POST["tran"];
	}else{
		$tran='0';
	}
	if ($_POST['more']!=''){
		 $check_detail=$_POST["more"];
	}else{
		$check_detail='0';
	}
	
		if ($_POST['dep']!=''){
		  $dep=$_POST["dep"];
	}else{
		$dep='0';
	}

	
 $department=$_POST["department_name"];
 $type_customer=$_POST["customer_typename"];
 $type_company=$_POST["company_name"];
 $customer_name1=$_POST["customer_name1"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product_name=$_POST["product"];
 $product_sn=$_POST["product_sn"];
 $unit_credit=$_POST["unit_credit"];
 $price=$_POST["unit_cash"];
 $employee_name=$_POST["employee_name"];
 $employee_tel=$_POST["employee_tel"];
 $add_by=$_POST["add_by"];
 $description=$_POST["description"];
 $havemap=$_POST['have_map'];
$unit_check=$_POST["unit_check"];
$unit_bill=$_POST["unit_bill"];
$unit_tran=$_POST["unit_tran"];


$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);
$send_cs2 = $_POST["send_cs2"];


$department_show = $_POST["department_show"];


	
	
	
	$strSQL66 =  "Update tb_register_data set start_date='$start_date',between_date='$between_date',start_time='$start_time',end_time='$end_time',status='".$status."',fix_date='".$fix_date."',no_price='".$no_price."',call_customer='".$call_customer."',credit='".$credit."',call_employee='".$call_employee."',cash='".$chash."',check_peper='".$check_peper."',bill='".$bill."',department='".$department."',type_customer='".$type_customer."',type_company='".$type_company."',customer_name='".$customer_name1."',customer_tel='".$customer_tel."',address_name='".$address_name."',address_send='".$address_send."',want_bus='".$want_bus."',amphur_name='".$amphur_name."',province_name='".$province_name."',product_name='".$product_name."',product_sn='".$product_sn."',unit_credit='".$unit_credit."',price='".$price."',employee_name='".$employee_name."',employee_tel='".$employee_tel."',add_by='".$add_by."',description='".$description."',have_map='".$havemap."',add_date='$add_date',unit_bill='".$unit_bill."',unit_check='".$unit_check."',unit_tran='".$unit_tran."',tran='".$tran."',check_detail='".$check_detail."',number='".$number."',status_comment='".$status_comment."',dep='".$dep."',dept='".$dept."',department_show='".$department_show."',customer_contact='".$customer_contact."',mk_research='".$mk_research."'  where ref_id='".$ref_id."'";


 $objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());

 
	
		
		
if($send_cs2 =='1'){
		
	

	


$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(running) AS MAXID FROM tb_register_data";
$qry = mysqli_query($com1,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId1 = substr($rs['MAXID'],0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;
}

$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,ref_id) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$ref_id."')";


 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());


 
 $strSQL90 =  "insert into tb_transaction (running) 

values('".$nextId."')";

$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  so__main set job_id2='".$nextId."',send_cs2 ='2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
	}
	
	


	

	
 if($objQuery66){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_awsend2_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
