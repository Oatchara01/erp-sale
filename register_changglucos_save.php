<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$smp_date = $_POST["smp_date"];
$date = explode('-' , $_POST["smp_date"] );
$xdate = $date[0].'-'.$date[1];

$strSQL1 = "SELECT close_mount FROM  tb_closedoc WHERE close_mount = '".$xdate."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
if($Num_Rows1 > 0){
	
echo "<script language=\"JavaScript\">";
echo "alert('ไม่สามารถบันทึกข้อมูลใบเบิกในเดือนนี้ได้เนื่องจากได้ทำการปิดเอกสารเรียบร้อยแล้วค่ะ');window.location='register_salesmp.php';";
echo "</script>";
	
}else{
		
	
$address_name = $_POST["address_name"];
$customer_name = $_POST["customer_name"];
$comment_sale = $_POST["comment_sale"];
$status_sup = "Request";
$sale_date= date('Y-m-d');
$sale_name =  $_SESSION['name'];
$sale_code = $_POST['sale_code'];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$send_sup= '0';
$sup_name = $_SESSION['name'];
$sup_date = date('Y-m-d');
$comment_sup  = $_POST["comment_sup"];
$type_company   = $_POST["type_company"];
$delivery_type = $_POST["delivery_type"];
$delivery_date =$_POST["start_date"];
$date_send_key =$_POST["between_date"];	
$ref_idsale = $_POST["ref_idsale"];
$bill_id = $_POST["bill_id"];
$order_no = $_POST["order_no"];
$id = $_POST["id_pp"];	
$ref_idnew = $_POST["ref_idnew"];	
	
$go = substr($ref_idsale,0,2);	
	
if($sale_code=='SOL1' or $sale_code=='SOL2' or $sale_code=='SOL3' or $sale_code=='SOL4' or $sale_code=='SOL5' or $sale_code=='SOL6' or $sale_code=='SOL91' or $sale_code=='SOL92' or $sale_code=='SOL93' or $sale_code=='SOL94'){	
$allwell_ckk = '1';	
}else{
$allwell_ckk = '0';		
}
	
	
if ($_FILES['img_upsn']['size'] == 0) {
$img_upsn = "";
}else if ($_FILES['img_upsn']['size'] != 0) {
$temp1 = explode(".", $_FILES["img_upsn"]["name"]);
$slip1 = "img_upsn" . "_" . $ref_idsmp . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["img_upsn"]["tmp_name"], "smp_up/" . $slip1);
}	
	
	
	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_idsmp) AS MAXID FROM hos__smp";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "RSMP";

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


$ref_idsmp = "$so$nextId";


$save="insert into hos__smp
(ref_idsmp,smp_date,address_name,customer_name,comment_sale,status_sup,sale_date,sale_name,sale_code,add_by,add_date,send_sup,delivery_type,type_company,send_admin,create_adm,delivery_date,date_send_key,img_upsn,allwell_ckk,ref_idsale,bill_id,order_no,chang_ckk,ref_idnew)
values
('".$ref_idsmp."','".$smp_date."','".$address_name."','".$customer_name."','".$comment_sale."','".$status_sup."','".$sale_date."','".$sale_name."','".$sale_code."','".$add_by."','".$add_date."','".$send_sup."','".$delivery_type."','".$type_company."','0','0','".$delivery_date."','".$date_send_key."','".$slip1."','".$allwell_ckk."','".$ref_idsale."','".$bill_id."','".$order_no."','1','".$ref_idnew."')";

$qsave=mysqli_query($conn,$save);

if($id!=''){

$save56="Update tb__glucos SET chang_ckk='1',smp_ref='".$ref_idsmp."' where  id ='".$id."'";
$qsave56=mysqli_query($conn,$save56);
	
}


$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$sale_remark1 = $_POST["sale_remark1"];
$waranty1 = $_POST["waranty1"];
$sn_old1 = $_POST["sn_old1"];



$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark,sn_old)
values ('".$ref_idsmp."','".$product_id1."','".$product_id1."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$sale_remark1."','".$sn_old1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);






$start_date =$_POST["start_date"];
 $between_date =$_POST["between_date"];
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
	
 
 $customer_name1=$_POST["customer_name1"];
 $customer_tel=$_POST["customer_tel"];
 $address_name1=$_POST["address_name1"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
 $on_time = $_POST["on_time"];	
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
$department_show = $_POST["department_show"];
$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);
$dept =$_POST["dept"];
$status_comment =$_POST["status_comment"];
$type_company = $_POST["customer_typename"];
$address_1 = $_POST["address_1"];	


if($delivery_type=='2'){
	
$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1) 

values('".$ref_idsmp."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_name1."','".$address_send."','".$want_bus."','".$product_name."','".$ref_idsmp."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."')";

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());
	
}




	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_chang426_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
  } else {
   echo "Cannot";
  }
}
	}


