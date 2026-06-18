<?php include ("head.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<style type="text/css">
<!--
.style8 {color: #6633FF; font-weight: bold; }
.style9 {
	color: #FF0000;
	font-weight: bold;
	font-size: 24px;
}

.style10 {
	color: #006600;
	font-weight: bold;
	font-size: 24px;
}
-->
</style>
</head>
<body>
<center></br></br>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$register_date = date("Y/m/d");
$register_time = date("H:i:s");
$sale_channel = $_POST["sale_channel"];
$select_type_doc = $_POST["select_type_doc"];
$payment = $_POST["h_payment"];
$delivery = $_POST["h_delivery"];
$customer_name = $_POST["customer_name"];
$sale_remark = $_POST["sale_remark"];
$employee_name = $_POST["employee_name"];
$doc_release_date = $_POST["doc_release_date"];
$job_id = $_POST["job_id"];
$billing_name = $_POST["billing_name"];
$billing_address = $_POST["billing_address"];
$billing_tel = $_POST["billing_tel"];
$bill_vat = $_POST["bill_vat"];
$tax_id = $_POST["tax_id"];
$bill_id = $_POST["bill_id"];

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
$prefer_name = $_POST["prefer_name"];
$po_no = $_POST["po_no"];
$delivery_contract = $_POST["delivery_contract"];
$clear_book_no = $_POST["clear_book_no"];
$clear_brn_no = $_POST["clear_brn_no"];
$clear_brnp_no = $_POST["clear_brnp_no"];
$sn = $_POST["sn"];
$bq = $_POST["bq"];
$ot = $_POST["ot"];
$install_place = $_POST["install_place"];
$type_type = $_POST["type_type"];
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
$iv_no = $_POST["iv_no"];
$order_no = $_POST["order_no"];
$order_name = $_POST["order_name"];
$objective  = $_POST["objective"];
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname"; 

$clear_book_ckk = $_POST["clear_book_ckk"];
$status_doc = $_POST["status_doc"];

$clear_brn_no_ckk = $_POST["clear_brn_no_ckk"];
$clear_brnp_no_ckk = $_POST["clear_brnp_no_ckk"];
$sn_ckk = $_POST["sn_ckk"];
$bq_ckk = $_POST["bq_ckk"];
$ot_ckk = $_POST["ot_ckk"];
$deposit_no = $_POST["deposit_no"];
$order_refer_code = $_POST["order_refer_code"];
$run_id = $_POST["run_id"];	
if($sale_channel =='3'){
	$allwell_ckk = '1';
}else if($sale_channel =='4'){
		$allwell_ckk = '1';
}else{  
	$allwell_ckk = '0';	
}
	

	move_uploaded_file($_FILES['upload1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload1']['name']));
	move_uploaded_file($_FILES['upload2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload2']['name']));
	move_uploaded_file($_FILES['upload3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload3']['name']));
	move_uploaded_file($_FILES['upload4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload4']['name']));
	move_uploaded_file($_FILES['upload5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload5']['name']));
	move_uploaded_file($_FILES['upload_map']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload_map']['name']));

	
$qfirst = "select * from so__main ORDER BY main_id DESC LIMIT 1";
			$first = mysqli_query($conn,$qfirst);
			$ffirst = mysqli_fetch_array($first);
	
$ref_id = $ffirst['ref_id']+1;	
	
if($run_id=='1'){
	if($select_type_doc =='3'){
	
$date = explode('-' , $_POST["doc_release_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_ptl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	
		
$save5="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."')";
$qsave5=mysqli_query($conn,$save5);
		
		
	}else if($select_type_doc =='4'){
		
$date = explode('-' , $_POST["doc_release_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";
$so1 = "/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_doc_nbm (doc_no,year_no,mount_no,run_no) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."')";
$qsave=mysqli_query($conn,$save);
		
	}else if($select_type_doc =='1'){
		
$sql1 = "SELECT doc_no FROM tb_solptl where sale_channel = '".$sale_channel."' and date_sol = '".$doc_release_date."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);	
$num = $rs1["doc_no"];
	
if($Num_Rows>0){
	
	   echo "<script language=\"JavaScript\">";
echo "alert('วันนี้มีการเพิ่ม $num ช่องทางการขายนี้ของวันนี้แล้วค่ะ');window.location='add_solptl.php'";
echo "</script>";

}else{
$date = explode('-' , $_POST["doc_release_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
$yearMonth = $year1.$mont;
$sql = "SELECT MAX(doc_no) AS MAXID FROM tb_solptl";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so = "SOL";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "001"; 
$nextId = $yearMonth.$maxId1;

}

$doc_no = $so.$nextId;
	

$save="insert into tb_solptl (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$doc_release_date."','".$sale_channel ."')";
$qsave=mysqli_query($conn,$save);
}
		
	}else if($select_type_doc =='2'){
		
$sql1 = "SELECT doc_no FROM tb_solnbm where sale_channel = '".$sale_channel."' and date_sol = '".$doc_release_date."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);	

	
if($Num_Rows>0){
$doc_no = $rs1["doc_no"];	
}else{
$date = explode('-' , $_POST["doc_release_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
$yearMonth = $year1.$mont;
$sql = "SELECT MAX(doc_no) AS MAXID FROM tb_solnbm";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so = "SOL/";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "001"; 
$nextId = $yearMonth.$maxId1;

}

$doc_no = $so.$nextId;
	

$save="insert into tb_solnbm (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$doc_release_date."','".$sale_channel ."')";
$qsave=mysqli_query($conn,$save);
		
	}
}
}else{
$doc_no = $_POST["doc_no"];
}


$save="insert into so__main
(ref_id,register_date,register_time,sale_channel,select_type_doc,delivery,payment,sale_remark,employee_name,doc_no,doc_release_date,job_id,billing_name,billing_address,billing_tel,bill_vat,transfer,account_approve,transfer_date,amount,delivery_name,address1,address2,province,postcode,tel,prefer_name,po_no,delivery_contract,clear_book_no,clear_brn_no,clear_brnp_no,sn,bq,ot,install_place,type_type,type_type_detail,delivery_date,delivery_time,big_car,call_before,maps,assign_date_time,delivery_type,delivery_place,delivery_contact,returns,return_date,return_time,return_address,return_contact,order_name,order_id,add_date,add_by,clear_book_ckk,status_doc,upload1,upload2,upload3,upload4,upload5,customer_name,clear_brn_no_ckk,clear_brnp_no_ckk,sn_ckk,bq_ckk,ot_ckk,deposit_no,upload_map,iv_no,order_refer_code,objective,allwell_ckk,tax_id,bill_id)
values
('$ref_id','$register_date','$register_time','$sale_channel','$select_type_doc','$delivery','$payment','$sale_remark','$employee_name','$doc_no','$doc_release_date','$job_id','$billing_name','$billing_address','$billing_tel','$bill_vat','$transfer','$account_approve','$transfer_date','$amount','$delivery_name','$address1','$address2','$province','$postcode','$tel','$prefer_name','$po_no','$delivery_contract','$clear_book_no','$clear_brn_no','$clear_brnp_no','$sn','$bq','$ot','$install_place','$type_type','$type_type_detail','$delivery_date','$delivery_time','$big_car','$call_before','$maps','$assign_date_time','$delivery_type','$delivery_place','$delivery_contact','$returns','$return_date','$return_time','$return_address','$return_contact','$order_name','$order_no','$add_date','$add_by','$clear_book_ckk','$status_doc','".$_FILES['upload1']['name']."','".$_FILES['upload2']['name']."','".$_FILES['upload3']['name']."','".$_FILES['upload4']['name']."','".$_FILES['upload5']['name']."','$customer_name','$clear_brn_no_ckk','$clear_brnp_no_ckk','$sn_ckk','$bq_ckk','$ot_ckk','$deposit_no','".$_FILES['upload_map']['name']."','$iv_no','$order_refer_code','$objective','$allwell_ckk','$tax_id','".$bill_id."')";


$qsave=mysqli_query($conn,$save);




	
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
$department_show = $_POST["department_show"];



$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,customer_contact) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$customer_contact."')";


//echo $strSQL66."<br>";
//exit();
$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());


	

		
if($send_cs =='1'){
		
	
include("dbconnect_cs.php");
	


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

$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."')";

//echo $strSQL89;

 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());


 
 $strSQL90 =  "insert into tb_transaction (running) 

values('".$nextId."')";


//echo $strSQL90;
//exit();
$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  so__main set job_id='".$nextId."',send_cs = '2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
	}
	
	
$doc_noo = substr($doc_no,0,4);
	
	if($doc_noo=="IV20"){
		$com ="บิลเงินสด";
	}else if ($_POST["select_type_doc"]=='3'){
		$com ="ฟาร์ ทริลเลี่ยน บจก.";
	}else if ($_POST["select_type_doc"]=='4'){
	$com="โนเบิล เมด บจก.";	
	}
	
	if($_POST["sale_channel"]=='1' or $_POST["sale_channel"]=='20'){
		$cash='23';
		$credit ='0';
	}else if($_POST["sale_channel"]=='12'){
		$cash='24';
		$credit ='0';
	}else if($_POST["h_payment"]=='1'){
		$cash='1';
		$credit ='0';
	}else if($_POST["h_payment"]=='2'){
		$cash='2';
		$credit ='0';
	}else if($_POST["h_payment"]=='3'){
		$cash='3';
		$credit ='0';
	}else if($_POST["h_payment"]=='4'){
		$cash='4';
		$credit ='0';
	}else if($_POST["h_payment"]=='5'){
		$cash='5';
		$credit ='0';
	}else if($_POST["h_payment"]=='6'){
		$cash='6';
		$credit ='0';
	}else if($_POST["h_payment"]=='7' or $_POST["h_payment"]=='8' or $_POST["h_payment"]=='12'){
		$cash='25';
		$credit ='0';
	}else if($_POST["h_payment"]=='18'){
		$cash='8';
		$credit ='0';
	}else if($_POST["h_payment"]=='19'){
		$cash='9';
		$credit ='0';
	}else if($_POST["h_payment"]=='20'){
		$cash='10';
		$credit ='0';
	}else if($_POST["h_payment"]=='22'){
		$cash='12';
		$credit ='0';
	}else if($_POST["h_payment"]=='23'){
		$cash='13';
		$credit ='0';
	}else if($_POST["h_payment"]=='24'){
		$cash='14';
		$credit ='0';
	}else if($_POST["h_payment"]=='25'){
		$cash='15';
		$credit ='0';
	}else if($_POST["h_payment"]=='26'){
		$cash='16';
		$credit ='0';
	}else if($_POST["h_payment"]=='28'){
		$cash='21';
		$credit ='0';
	}else if($_POST["h_payment"]=='29' or $_POST["h_payment"]=='30'){
		$cash='0';
		$credit ='1';
	}
	
	$doc_no1 = substr($doc_no,0,2);
	
		
	if($doc_no1=="IE"){
	if($_POST["h_payment"]=='5' or $_POST["h_payment"]=='6'){
		$summary = '';
	$employee_receive = '';
	$employee_receive1 = '';
	}else{
	$summary = 'สมบูรณ์';	
		$employee_receive = '58131';
	$employee_receive1 = 'ประภาสิริ';
	}
	}else{
		$summary = '';
	$employee_receive = '';
	$employee_receive1 = '';	
	}
	
	//echo $summary;
	
	
	if($account_approve=='1'){
		
		$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	if($_POST["sale_channel"]=='1' or $_POST["sale_channel"]=='20' or $_POST["sale_channel"]=='12' or $_POST["h_payment"]=='7' or $_POST["h_payment"]=='8' or $_POST["h_payment"]=='29'  or $_POST["h_payment"]=='30'){
		$amount_1 = "0.00";
	}else {	
$amount_1 = $objResult15["amount_1"];
	}	

		
		
$strSQL29="insert into   tb_register_data ( IV_number,date_inv,company,customer_name,date_tranfer,unit_cash,
cash,employee_name,summary,summary_work,summary_cash,ref_id,employee_receive,employee_receive1,credit) values ('".$doc_no."','".$delivery_date."','".$com."','".$billing_name."','".$transfer_date."','".$amount_1."','".$cash."','พิมลพร','".$summary."','".$summary."','".$summary."','".$ref_id."','".$employee_receive."','".$employee_receive1."','".$credit."')";

$objQuery29 = mysqli_query($code,$strSQL29);	
	
		
		
	}




if ($unit_name1=='เตียง' or $unit_name2=='เตียง' or $unit_name3=='เตียง' or $unit_name4=='เตียง' or $unit_name5=='เตียง' or $unit_name6=='เตียง' or $unit_name7=='เตียง' or $unit_name8=='เตียง' or $unit_name9=='เตียง' or $unit_name10=='เตียง' or $product_id1 =='3199'  or $product_id2 =='3199' or $product_id3 =='3199' or $product_id4 =='3199' or $product_id5 =='3199' or $product_id6 =='3199' or $product_id7 =='3199' or $product_id8 =='3199' or $product_id9 =='3199' or $product_id10 =='3199'){

$strSQL25="Update  so__main set approve_complete='Request'  where ref_id='".$ref_id."'";
//echo $strSQL25;
$objQuery25 = mysqli_query($conn,$strSQL25);

}else{
	
$strSQL25="Update  so__main set approve_complete='Approve'  where ref_id='".$ref_id."'";
//echo $strSQL25;
$objQuery25 = mysqli_query($conn,$strSQL25);
	
}





	
if($qsave)
	{
	//บันทึกเรียบร้อย
	
	/*print " <img src='img/small_compleate.gif' />Save Successfully <br />";	*/
print " <img src='img/small_compleate.gif' /><span class='style10'>ref_id: </span><font color='0000ff'>".$ref_id." </font><span class='style10'>Save Successfully</span><br />";
	}
else
	{
    //บันทึกไม่ได
	
	print "<img src='img/false.png' /><span class='style9'> Error to save data </span><br />";

	}
	
}



/*if (!$qsave) {
	echo "Error to save data".mysqli_error();
}
else {
	echo "Save Successfully";
}
}
*/
?>

<p align="center"><a href="main_admin.php"><span class="style18">กลับสู่หน้าหลัก</span></a></p>

</center>
</body>
</html>



