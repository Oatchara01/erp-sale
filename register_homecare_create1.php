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
include("dbconnect_acc.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$register_date = date("Y-m-d");
$register_time = date("H:i:s");
$sale_channel = $_POST["sale_channel"];
$ref_rentel	= $_POST["ref_rentel"];

$delivery = $_POST["delivery"];
$employee_name = $_POST["employee_name"];	
$delivery_date = $_POST["delivery_date"];
$delivery_time = $_POST["delivery_time"];	
$delivery_type = $_POST["delivery_type"];	
$que_ckk = $_POST["que_ckk"];	

	
$select_type_doc = $_POST["select_type_doc"];
$billing_name = $_POST["billing_name"];
$billing_address = $_POST["billing_address"];
$billing_tel = $_POST["billing_tel"];
$bill_vat = '1';
$run_id = $_POST["run_id"];
$run_et = $_POST["run_et"];
$full_bill = $_POST["full_bill"];
$customer_name = $_POST["customer_name"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$province = $_POST["province"];
$postcode = $_POST["postcode"];
$tel = $_POST["tel"];
$delivery_place = $_POST["delivery_place"];
$delivery_contact = $_POST["delivery_contact"];
$withdraw_objective = $_POST["withdraw_objective"];
$payment = $_POST["payment"];
$bus_inter = $_POST["bus_inter"];
$email = $_POST["email"];	

$doc_release_date = $_POST["doc_release_date"]; 
	
$doc_time1 = $_POST["doc_time"];
if($doc_release_date !=''){	
$doc_time = date('H:i:s');	
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$admin_name = "$name $surname";
	
}else{
$admin_name = $_POST["admin_name"];	
$doc_time = $_POST["doc_time"];	
}
	
	
$other_payment = $_POST["other_payment"];
$big_car = $_POST["big_car"];

$call_before = $_POST["call_before"];
$assign_date_time = $_POST["assign_date_time"];
$maps = $_POST["maps"];
$approve_name = $_POST["approve_name"];
$discount = $_POST["discount"];
$sale_complete = $_POST["sale_complete"];
$sale_remark = $_POST["sale_remark"];
$sn = $_POST["sn"];
$bq = $_POST["bq"];
$ot = $_POST["ot"];
$delivery_company = $_POST["delivery_company"];
$et_ckk = $_POST["et_ckk"];
$returns = $_POST["returns"];
$return_date = $_POST["return_date"];
$return_time = $_POST["return_time"];
$return_address = $_POST["return_address"];
$return_contact = $_POST["return_contact"];
$prefer_name = $_POST["prefer_name"];
$po_no = $_POST["po_no"];
$delivery_contract = $_POST["delivery_contract"];
$clear_book_no = $_POST["clear_book_no"];
$clear_brn_no = $_POST["clear_brn_no"];
$clear_brnp_no = $_POST["clear_brnp_no"];
$type_type = $_POST["type_type"];
$type_type_detail = $_POST["type_type_detail"];
$install_place = $_POST["install_place"];
$account_approve = $_POST["account_approve"];
$amount = $_POST["amount"];
$transfer_date = $_POST["transfer_date"];
$order_id = $_POST["order_no"];
$order_name = $_POST["order_name"];
$order_delivery_date = $_POST["order_delivery_date"];
$order_refer_code = $_POST["order_refer_code"];
$clear_book_ckk = $_POST["clear_book_ckk"];
$tax_id = $_POST["tax_id"];
$clear_brn_no_ckk = $_POST["clear_brn_no_ckk"];
$clear_brnp_no_ckk = $_POST["clear_brnp_no_ckk"];
$sn_ckk = $_POST["sn_ckk"];
$bq_ckk = $_POST["bq_ckk"];
$ot_ckk = $_POST["ot_ckk"];
$transfer = $_POST["transfer"];
$buy_ckk = $_POST["buy_ckk"];
	
$ref_12 = $_POST["ref_12"];		
$ref_13 = $_POST["ref_13"];		
	

$ex_add = $_POST["ex_add"];
$ex_aumper = $_POST["ex_aumper"];
$ex_provin = $_POST["ex_provin"];
$ex_post = $_POST["ex_post"];	
$pre_name 	 = $_POST["pre_name"];	
$review_date_call = $_POST["review_date_call"];
$review_call_des = $_POST["review_call_des"];
$review_date = $_POST["review_date"];
$promotion_date = $_POST["promotion_date"];
$review_description = $_POST["review_description"];
$warranty_h = $_POST["warranty_h"];
$pr_no  = $_POST["pr_no"];
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$em_id =  $_SESSION['emid'];
$send_cs =  $_POST["send_cs"];
	if($_POST["bill_id"] !=''){
$bill_id =  $_POST["bill_id"];
	}else if($_POST["tel_1"] !=''){
$bill_id = $_POST["tel_1"];
	}else{
$customer_no1 = $_POST["customer_no1"];		
	}
$customer_no =  $_POST["customer_no"];
$tel_mem =  $_POST["tel_mem"];	
$have_order =  $_POST["have_order"];
$delivery_contact =  $_POST["delivery_contact"];
$slip_no =  $_POST["slip_no"];
	

	
	
if($payment =='37' and $_FILES['upload1']['name']==''){

echo "<script language=\"JavaScript\">";
echo "alert('กรุณแนบสลิปการรูดการ์ดหน้าโชว์รูมด้วยนะคะ');";
echo "window.history.go(-1);</script>";
exit();

}	
	

	

//extra address
$ex1customer_name =  $_POST["ex1customer_name"];
$ex1address1 = $_POST["ex1address1"];
$ex1address2 = $_POST["ex1address2"];
$ex1province = $_POST["ex1province"];
$ex1postcode = $_POST["ex1postcode"];
$ex1tel = $_POST["ex1tel"];

$ex2customer_name =  $_POST["ex2customer_name"];
$ex2address1 = $_POST["ex2address1"];
$ex2address2 = $_POST["ex2address2"];
$ex2province = $_POST["ex2province"];
$ex2postcode = $_POST["ex2postcode"];
$ex2tel = $_POST["ex2tel"];

$ex3customer_name =  $_POST["ex3customer_name"];
$ex3address1 = $_POST["ex3address1"];
$ex3address2 = $_POST["ex3address2"];
$ex3province = $_POST["ex3province"];
$ex3postcode = $_POST["ex3postcode"];
$ex3tel = $_POST["ex3tel"];

$ex4customer_name =  $_POST["ex4customer_name"];
$ex4address1 = $_POST["ex4address1"];
$ex4address2 = $_POST["ex4address2"];
$ex4province = $_POST["ex4province"];
$ex4postcode = $_POST["ex4postcode"];
$ex4tel = $_POST["ex4tel"];

$ex5customer_name =  $_POST["ex5customer_name"];
$ex5address1 = $_POST["ex5address1"];
$ex5address2 = $_POST["ex5address2"];
$ex5province = $_POST["ex5province"];
$ex5postcode = $_POST["ex5postcode"];
$ex5tel = $_POST["ex5tel"];

$ex6customer_name =  $_POST["ex6customer_name"];
$ex6address1 = $_POST["ex6address1"];
$ex6address2 = $_POST["ex6address2"];
$ex6province = $_POST["ex6province"];
$ex6postcode = $_POST["ex6postcode"];
$ex6tel = $_POST["ex6tel"];

$ex7customer_name =  $_POST["ex7customer_name"];
$ex7address1 = $_POST["ex7address1"];
$ex7address2 = $_POST["ex7address2"];
$ex7province = $_POST["ex7province"];
$ex7postcode = $_POST["ex7postcode"];
$ex7tel = $_POST["ex7tel"];

$ex8customer_name =  $_POST["ex8customer_name"];
$ex8address1 = $_POST["ex8address1"];
$ex8address2 = $_POST["ex8address2"];
$ex8province = $_POST["ex8province"];
$ex8postcode = $_POST["ex8postcode"];
$ex8tel = $_POST["ex8tel"];

$ex9customer_name =  $_POST["ex9customer_name"];
$ex9address1 = $_POST["ex9address1"];
$ex9address2 = $_POST["ex9address2"];
$ex9province = $_POST["ex9province"];
$ex9postcode = $_POST["ex9postcode"];
$ex9tel = $_POST["ex9tel"];

//end extra address	
	
$qfirst = "select * from so__main ORDER BY main_id DESC LIMIT 1";
$first = mysqli_query($conn,$qfirst);
$Num_Rows88 = mysqli_num_rows($first);
$ffirst = mysqli_fetch_array($first);
	
$ref_id = $ffirst['main_id']+1;
	
$sql9 = "SELECT slip_no FROM so__main where slip_no ='".$slip_no."' ";
$qry9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$Num_Rows88 = mysqli_num_rows($qry9);
$rs9 = mysqli_fetch_assoc($qry9);


	
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
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	
		
$save5="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."')";
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
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_doc_nbm (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."')";
$qsave=mysqli_query($conn,$save);
		
	}

}else if($_POST["doc_no"] !=''){
	$doc_no = $_POST["doc_no"];
	}else{
	$doc_no = "IV";
	}
	
	

if($select_type_doc =='3'){
$save19="UPDATE tb_doc_ptl SET ref_so ='".$ref_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}else if($select_type_doc =='4'){
	
$save19="UPDATE tb_doc_nbm SET ref_so ='".$ref_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
}
	
	

	
if ($_FILES['upload1']['size'] != 0) {
$temp1 = explode(".", $_FILES["upload1"]["name"]);
$slip1 = "upload1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["upload1"]["tmp_name"], "upload/" . $slip1);
}	

if ($_FILES['upload2']['size'] != 0) {
$temp2 = explode(".", $_FILES["upload1"]["name"]);
$slip2 = "upload2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["upload2"]["tmp_name"], "upload/" . $slip2);
}	
	
if ($_FILES['upload3']['size'] != 0) {
$temp3 = explode(".", $_FILES["upload3"]["name"]);
$slip3 = "upload3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["upload3"]["tmp_name"], "upload/" . $slip3);
}	

if ($_FILES['upload4']['size'] != 0) {
$temp4 = explode(".", $_FILES["upload4"]["name"]);
$slip4 = "upload4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["upload4"]["tmp_name"], "upload/" . $slip4);
}	

if ($_FILES['upload5']['size'] != 0) {
$temp5 = explode(".", $_FILES["upload5"]["name"]);
$slip5 = "upload5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["upload5"]["tmp_name"], "upload/" . $slip5);
}	

if ($_FILES['upload_map']['size'] != 0) {
$tempmap = explode(".", $_FILES["upload_map"]["name"]);
$slipmap = "upload_map" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($tempmap);
move_uploaded_file($_FILES["upload_map"]["tmp_name"], "upload/" . $slipmap);
}	
	
	

$save="insert into so__main
(ref_id,send_stock,register_date,register_time,sale_channel,select_type_doc,billing_name,billing_address,billing_tel,customer_name,address1,address2,province,postcode,tel,delivery_place,delivery_contact,withdraw_objective,payment,other_payment,delivery,big_car,delivery_date,delivery_time,call_before,assign_date_time,maps,employee_name,approve_name,discount,sale_complete,sale_remark,sn,bq,ot,delivery_type,returns,return_date,return_time,return_address,return_contact,prefer_name,po_no,delivery_contract,clear_book_no,clear_brn_no,clear_brnp_no,type_type,type_type_detail,install_place,account_approve,amount,transfer_date,order_id,order_name,order_delivery_date,order_refer_code,bill_vat,clear_book_ckk,upload1,upload2,upload3,upload4,upload5,status_doc,clear_brn_no_ckk,clear_brnp_no_ckk,sn_ckk,bq_ckk,ot_ckk,upload_map,transfer,review_date_call,review_call_des,review_date,pomotion_date,review_description,pr_no,add_by,send_cs,allwell_ckk,tax_id,bill_id,doc_release_date,doc_no,buy_ckk,customer_no,tel_mem,have_order,ex_add,ex_aumper,ex_provin,ex_post,pre_name,slip_no,admin_name,doc_time,que_ckk,email,et_ckk)
values
('$ref_id','1','$register_date','$register_time','$sale_channel','$select_type_doc','$billing_name','$billing_address','$billing_tel','$customer_name','$address1','$address2','$province','$postcode','$tel','$delivery_place','$delivery_contact','$withdraw_objective','$payment','$other_payment','$delivery','$big_car','$delivery_date','$delivery_time','$call_before','$assign_date_time','$maps','$employee_name','$approve_name','$discount','$sale_complete','$sale_remark','$sn','$bq','$ot','$delivery_type','$returns','$return_date','$return_time','$return_address','$return_contact','$prefer_name','$po_no','$delivery_contract','$clear_book_no','$clear_brn_no','$clear_brnp_no','$type_type','$type_type_detail','$install_place','$account_approve','$amount','$transfer_date','$order_id','$order_name','$order_delivery_date','$order_refer_code','$bill_vat','$clear_book_ckk','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','1','$clear_brn_no_ckk','$clear_brnp_no_ckk','$sn_ckk','$bq_ckk','$ot_ckk','".$slipmap."','$transfer','$review_date_call','$review_call_des','$review_date','$promotion_date','$review_description','$pr_no','".$add_by."','".$send_cs."','1','".$tax_id."','".$bill_id."','".$doc_release_date."','".$doc_no."','".$buy_ckk."','".$customer_no."','".$tel_mem."','".$have_order."','".$ex_add."','".$ex_aumper."','".$ex_provin."','".$ex_post."','".$pre_name."','".$slip_no."','".$admin_name."','".$doc_time."','".$que_ckk."','".$email."','".$et_ckk."')";
	
$qsave=mysqli_query($conn,$save);
	
	
$save56="insert into tb_other_bill (ref_id,ref_12,ref_13) values ('".$ref_id."','".$ref_12."','".$ref_13."')";
$qsave56=mysqli_query($conn,$save56);		
	
	
if($qsave){
	
//save extra address
if($ex1customer_name!='') //check if customer1 name is not null, then save in sql
{
$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','1','".$ex1customer_name."','".$ex1address1."','".$ex1address2."','".$ex1province."','".$ex1postcode."','".$ex1tel."')";
$e1save=mysqli_query($conn,$ex1save);
}
if($ex2customer_name!='') //check if customer2 name is not null, then save in sql
{
$ex2save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','2','".$ex2customer_name."','".$ex2address1."','".$ex2address2."','".$ex2province."','".$ex2postcode."','".$ex2tel."')";
$e2save=mysqli_query($conn,$ex2save);
}
if($ex3customer_name!='') //check if customer3 name is not null, then save in sql
{
$ex3save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','3','".$ex3customer_name."','".$ex3address1."','".$ex3address2."','".$ex3province."','".$ex3postcode."','".$ex3tel."')";
$e3save=mysqli_query($conn,$ex3save);
}
if($ex4customer_name!='') //check if customer4 name is not null, then save in sql
{
$ex4save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','4','".$ex4customer_name."','".$ex4address1."','".$ex4address2."','".$ex4province."','".$ex4postcode."','".$ex4tel."')";
$e4save=mysqli_query($conn,$ex4save);
}
if($ex5customer_name!='') //check if customer5 name is not null, then save in sql
{
$ex5save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','5','".$ex5customer_name."','".$ex5address1."','".$ex5address2."','".$ex5province."','".$ex5postcode."','".$ex5tel."')";
$e5save=mysqli_query($conn,$ex5save);
}
if($ex6customer_name!='') //check if customer6 name is not null, then save in sql
{	
$ex6save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','6','".$ex6customer_name."','".$ex6address1."','".$ex6address2."','".$ex6province."','".$ex6postcode."','".$ex6tel."')";
$e6save=mysqli_query($conn,$ex6save);
}
if($ex7customer_name!='') //check if customer7 name is not null, then save in sql
{
$ex7save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','7','".$ex7customer_name."','".$ex7address1."','".$ex7address2."','".$ex7province."','".$ex7postcode."','".$ex7tel."')";
$e7save=mysqli_query($conn,$ex7save);
}
if($ex8customer_name!='') //check if customer8 name is not null, then save in sql
{
$ex8save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','8','".$ex8customer_name."','".$ex8address1."','".$ex8address2."','".$ex8province."','".$ex8postcode."','".$ex8tel."')";
$e8save=mysqli_query($conn,$ex8save);
}
if($ex9customer_name!='') //check if customer9 name is not null, then save in sql
{
$ex9save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','9','".$ex9customer_name."','".$ex9address1."','".$ex9address2."','".$ex9province."','".$ex9postcode."','".$ex9tel."')";
$e9save=mysqli_query($conn,$ex9save);
}
//end save extra address	

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
if($select_type_doc=='3'){
$type_company ='ออลล์เวล ไลฟ์ บจก.';	
}else if($select_type_doc=='4'){
$type_company ='โนเบิล เมด บจก.';	
}
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

if ($_POST['runway']!=''){
		$runway=$_POST["runway"];
	}else{
		$runway='0';
	}

if ($_POST['road']!=''){
		$road=$_POST["road"];
	}else{
		$road='0';
	}

if ($_POST['soy']!=''){
	$soy=$_POST["soy"];
	}else{
		$soy='0';
	}
	
	if ($_POST['car_load']!=''){
	$car_load=$_POST["car_load"];
	}else{
		$car_load='0';
	}

if ($_POST['no_car_road']!=''){
	$no_car_road=$_POST["no_car_road"];
	}else{
		$no_car_road='0';
	}
	
	if ($_POST['car_road']!=''){
	$car_road=$_POST["car_road"];
	}else{
		$car_road='0';
	}
if ($_POST['car_home']!=''){
	$car_home=$_POST["car_home"];
	}else{
		$car_home='0';
	}

	if ($_POST['slope']!=''){
	$slope=$_POST["slope"];	
	}else{
		$slope='0';
	}

	
	if ($_POST['bundai']!=''){
	$bundai=$_POST["bundai"];
	}else{
		$bundai='0';
	}

	if ($_POST['bundai_install']!=''){
	$bundai_install=$_POST["bundai_install"];
	}else{
		$bundai_install='0';
	}

	if ($_POST['lip']!=''){
	$lip=$_POST["lip"];
	}else{
		$lip='0';
	}

	
	if ($_POST['want_employee']!=''){
	$want_employee=$_POST["want_employee"];	
	}else{
		$want_employee='0';
	}

	if ($_POST['want_ex']!=''){
	$want_ex=$_POST["want_ex"];	
	}else{
		$want_ex='0';
	}

	
	if ($_POST['want_credit']!=''){
	$want_credit=$_POST["want_credit"];
	}else{
		$want_credit='0';
	}
if ($_POST['want_prem']!=''){
	$want_prem=$_POST["want_prem"];	
	}else{
		$want_prem='0';
	}
	
	if ($_POST['head_bad']!=''){
	$head_bad=$_POST["head_bad"];	
	}else{
		$head_bad='0';
	}

	
	if ($_POST['height_ltd']!=''){
	$height_ltd=$_POST["height_ltd"];	
	}else{
		$height_ltd='0';
	}
if ($_POST['up']!=''){
	$up=$_POST["up"];	
	}else{
		$up='0';
	}
if ($_POST['no_up']!=''){
	$no_up=$_POST["no_up"];	
	}else{
		$no_up='0';
	}

if ($_POST['more']!=''){
	$more=$_POST["more"];	
	}else{
		$more='0';
	}
	
	
	
$type_bundai=$_POST["type_bundai"];	
	
	
	
$soy_long = $_POST["soy_long"];
$soy_big = $_POST["soy_big"];
$car_park = $_POST["car_park"];
$door_long = $_POST["door_long"];
$unit_bundai = $_POST["unit_bundai"];
$door_big = $_POST["door_bigger"];
$door_longer = $_POST["door_longer"];
$type_door = $_POST["type_door"];
$home_type = $_POST["home_type"];
$install = $_POST["install"];
$bundai_big = $_POST["bundai_big"];
$lip_big = $_POST["lip_big"];
$lip_long = $_POST["lip_long"];
$lip_weight = $_POST["lip_weight"];
$employee_unit = $_POST["employee_unit"];
$ferniger_name = $_POST["ferniger_name"];
$ferniger_address = $_POST["ferniger_address"];
$number = $_POST["number"];
$status_comment=$_POST["status_comment"];

$dept = $_POST["dept"];
$room_bigger = $_POST["room_bigger"];
$room_longer = $_POST["room_longer"];
$bundai_hug = $_POST["bundai_hug"];
$bank = $_POST["bank"];

$department_show = $_POST["department_show"];
$description_ja = $_POST["description_ja"];
if($sale_channel=='4'){
$mk_research  = '1';
	}else{
$mk_research  = $_POST["mk_research"];		
	}

$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,customer_contact,mk_research,add_code,bus_inter) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$mk_research."','".$em_id."','".$bus_inter."')";

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());


 $strSQL99 =  "insert into tb_transaction (ref_id,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$ref_id."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";


 $objQuery99 = mysqli_query($conn,$strSQL99) or die(mysqli_error());


if($ref_rentel!='' and $doc_no=='IV'){
$strSQL26="Update  hos__rental set ref_iv='".$ref_id."'  where ref_id='".$ref_rentel."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
}else if($ref_rentel!='' and $doc_no=='IV'){
$strSQL26="Update  hos__rental set ref_ai='".$ref_id."'  where ref_id='".$ref_rentel."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
}


	
	if($_SESSION["name"]=='ชลชินี'){
	
$strSQL25="Update  so__main set approve_complete='Approve'  where ref_id='".$ref_id."'";
//echo $strSQL25;
$objQuery25 = mysqli_query($conn,$strSQL25);
		
	}
		
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

$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,add_code,ref_id) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$em_id."','".$ref_id."')";

$objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());


 
 $strSQL90 =  "insert into tb_transaction (running,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$nextId."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";


$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  so__main set job_id='".$nextId."',send_cs='2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	

	
	}




$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$warranty =$_POST["warranty"];
$pm=$_POST["pm"];
$cal=$_POST["cal"];
$product_id = $_POST["product_id"];
$jong_ckk = $_POST["jong_ckk"];
$discount_unit = $_POST["discount_unit"];
$sn = $_POST["sn"];

foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
		$sn_new  = $sn[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
		$cal_new=$cal[$key];
	    $clear_br_new=$jong_ckk[$key];
        $product_id_new =$product_id[$key];
        $discount_unit1 =$discount_unit[$key];
		$discount_unit_new=str_replace(',','', $discount_unit1);
		$sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;
		 

	if($clear_br_new=='1'){



$strSQL = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,jong_ckk,jong_no)
values ('".$ref_id."','".$sale_count_new."','".$sale_count_new."','".$product_price_new."','".$product_price_new."','".$sum_amount_new."','".$sale_remarkk_new."','".$discount_unit_new."','".$warranty_new."','".$cal_new."','".$pm_new."','".$product_id_new."','".$product_id_new."','1','".$clear_book_no."')";

$objQuery = mysqli_query($conn,$strSQL);

$strSQL = "SELECT * FROM hos__jongproduct WHERE iv_no = '".$clear_book_no."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT * FROM hos__subjongpro  WHERE ref_idd = '".$objResult["ref_id"]."' and product_id ='".$product_id_new."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult1['product_id']."' and jong_ckk = '1' and jong_no ='".$objResult["iv_no"]."' and status_sol ='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult1['product_id']."' and jong_ckk = '1' and jong_no ='".$objResult["iv_no"]."' and status_so ='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_assoc($qry13);
	

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
	
$count2 = $objResult1["count"] - ($count3+$count13);

if($count2=='0'){

$strSQL1 = "Update  hos__subjongpro set  close_ckk ='1' where  ref_idd = '".$objResult["ref_id"]."' and product_id ='".$product_id_new."'";
$objQuery1 = mysqli_query($conn,$strSQL1);


}


}
	}
	






	

	 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_allwell_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }	
	
	
}
}



?>

