
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
include ("error_page.php"); 
include ("head.php");
	
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {



$register_date = date("Y/m/d");
$register_time = date("H:i:s");
$select_type_doc = $_POST["select_type_doc"];

$customer_name = $_POST["customer_name"];
$address1 = $_POST["address1"];
$delivery_place = $_POST["delivery_place"];
	
$delivery_contact = $_POST["delivery_contact"];
$delivery = $_POST["delivery"];	
$employee_name = $_POST["employee_name"];
$sale_channel = $_POST["sale_channel"];
$delivery_date = $_POST["delivery_date"];
$delivery_time = $_POST["delivery_time"];
$sn = $_POST["sn"];
$bq = $_POST["bq"];
$ot = $_POST["ot"];
$delivery_type = $_POST["delivery_type"];
$returns = $_POST["returns"];
$return_date = $_POST["return_date"];
$return_time = $_POST["return_time"];
$return_address = $_POST["return_address"];
$return_contact = $_POST["return_contact"];
$delivery_contract = $_POST["delivery_contract"];
$clear_book_no = $_POST["clear_book_no"];
$clear_brn_no = $_POST["clear_brn_no"];
$clear_brnp_no = $_POST["clear_brnp_no"];

$clear_brn_no_ckk = $_POST["clear_brn_no_ckk"];
$clear_brnp_no_ckk = $_POST["clear_brnp_no_ckk"];
$sn_ckk = $_POST["sn_ckk"];
$bq_ckk = $_POST["bq_ckk"];
$ot_ckk = $_POST["ot_ckk"];
$sale_remark = $_POST["sale_remark"];
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$add_by = "$name $surname";


$big_car  = $_POST["big_car"];
$call_before = $_POST["call_before"];
$assign_date_time = $_POST["assign_date_time"];
$maps = $_POST["maps"];
$objective  = $_POST["objective"];
$objective_des  = $_POST["objective_des"];
$clear_book_ckk = $_POST["clear_book_ckk"];
$send_cs = $_POST["send_cs"];
$send_stock = $_POST["send_stock"];
	if($select_type_doc=='1'){
	$doc_no = "BRNP";	
	}else{
	$doc_no = "BRNP";		
	}
	
$em_id =  $_SESSION['emid'];

	move_uploaded_file($_FILES['upload_map']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload_map']['name']));

$qfirst = "select * from so__main ORDER BY main_id DESC LIMIT 1";
			$first = mysqli_query($conn,$qfirst);
			$ffirst = mysqli_fetch_array($first);
	
$main_id = $ffirst['main_id']+1;
$ref_id = $ffirst['main_id']+1;
	


$save="insert into so__main
(ref_id,delivery,register_date,register_time,select_type_doc,customer_name,address1,delivery_place,delivery_contact,big_car,delivery_date,delivery_time,call_before,assign_date_time,maps,employee_name,sale_remark,sn,bq,ot,delivery_type,returns,return_date,return_time,return_address,return_contact,delivery_contract,clear_book_no,clear_brn_no,clear_brnp_no,clear_book_ckk,clear_brn_no_ckk,clear_brnp_no_ckk,sn_ckk,bq_ckk,ot_ckk,upload_map,objective,objective_des,send_cs,approve_complete,allwell_ckk,send_stock,allwell_br,doc_no,billing_name,sale_channel,add_by,add_date )
values
('".$main_id."','".$delivery."','".$register_date."','".$register_time."','".$select_type_doc."','".$customer_name."','".$address1."','".$delivery_place."','".$delivery_contact."','".$big_car."','".$delivery_date."','".$delivery_time."','".$call_before."','".$assign_date_time."','".$maps."','".$employee_name."','".$sale_remark."','".$sn."','".$bq."','".$ot."','".$delivery_type."','".$returns."','".$return_date."','".$return_time."','".$return_address."','".$return_contact."','".$delivery_contract."','".$clear_book_no."','".$clear_brn_no."','".$clear_brnp_no."','".$clear_book_ckk."','".$clear_brn_no_ckk."','".$clear_brnp_no_ckk."','".$sn_ckk."','".$bq_ckk."','".$ot_ckk."','".$_FILES['upload_map']['name']."','".$objective."','".$objective_des."','".$send_cs."','Request','1','1','1','".$doc_no."','".$customer_name."','".$sale_channel."','".$add_by."','".$add_date."')";


$qsave=mysqli_query($conn,$save);

if($qsave){	


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
$mk_research  = $_POST["mk_research"];

$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,customer_contact,mk_research,add_code) 

values('".$main_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$mk_research."','".$em_id."')";


//echo $strSQL66."<br>";
//exit();
$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());


 $strSQL99 =  "insert into tb_transaction (ref_id,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$main_id."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";


//echo $strSQL1;
//exit();
 $objQuery99 = mysqli_query($conn,$strSQL99) or die(mysqli_error());






$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$discount_unit1 = $_POST["discount_unit1"];
$warranty1  = $_POST["warranty1"];
$cal1 = $_POST["cal1"];
$pm1 = $_POST["pm1"];




$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];
$warranty2  = $_POST["warranty2"];
$cal2 = $_POST["cal2"];
$pm2 = $_POST["pm2"];


$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];
$warranty3  = $_POST["warranty3"];
$cal3 = $_POST["cal3"];
$pm3 = $_POST["pm3"];


$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];
$warranty4  = $_POST["warranty4"];
$cal4 = $_POST["cal4"];
$pm4 = $_POST["pm4"];




$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_POST["discount_unit5"];
$warranty5  = $_POST["warranty5"];
$cal5 = $_POST["cal5"];
$pm5 = $_POST["pm5"];


$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];
$warranty6  = $_POST["warranty6"];
$cal6 = $_POST["cal6"];
$pm6 = $_POST["pm6"];


$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];
$warranty7  = $_POST["warranty7"];
$cal7 = $_POST["cal7"];
$pm7 = $_POST["pm7"];


$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];
$warranty8  = $_POST["warranty8"];
$cal8 = $_POST["cal8"];
$pm8 = $_POST["pm8"];





if($product_id1 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id1."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 =$sale_count1*$objResult31["unit1"];
$unit2 =$sale_count1*$objResult31["unit2"];
$unit3 =$sale_count1*$objResult31["unit3"];
$unit4 =$sale_count1*$objResult31["unit4"];
$unit5 =$sale_count1*$objResult31["unit5"];
$unit6 =$sale_count1*$objResult31["unit6"];
$unit7 =$sale_count1*$objResult31["unit7"];
$unit8 =$sale_count1*$objResult31["unit8"];
$unit9 =$sale_count1*$objResult31["unit9"];
$unit10 =$sale_count1*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$id_product1."','".$id_product1."','".$clear_br1."','".$sn1."','1','".$employee_name."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product2."','".$id_product2."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product3."','".$id_product3."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product4."','".$id_product4."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product5."','".$id_product5."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product6."','".$id_product6."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product7."','".$id_product7."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product8."','".$id_product8."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product9."','".$id_product9."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product10."','".$id_product10."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{	
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."','".$clear_br1."','".$sn1."','1','".$employee_name."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
}


if($product_id2 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id2."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count2*$objResult31["unit1"];
$unit2 = $sale_count2*$objResult31["unit2"];
$unit3 = $sale_count2*$objResult31["unit3"];
$unit4 = $sale_count2*$objResult31["unit4"];
$unit5 = $sale_count2*$objResult31["unit5"];
$unit6 = $sale_count2*$objResult31["unit6"];
$unit7 = $sale_count2*$objResult31["unit7"];
$unit8 = $sale_count2*$objResult31["unit8"];
$unit9 = $sale_count2*$objResult31["unit9"];
$unit10 =$sale_count2*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$id_product1."','".$id_product1."','".$clear_br2."','".$sn2."','1','".$employee_name."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product2."','".$id_product2."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product3."','".$id_product3."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product4."','".$id_product4."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product5."','".$id_product5."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product6."','".$id_product6."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product7."','".$id_product7."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product8."','".$id_product8."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product9."','".$id_product9."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product10."','".$id_product10."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
	
	
$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_id2."','".$product_id2."','".$clear_br2."','".$sn2."','1','".$employee_name."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
}


if($product_id3 !==''  ){

	
$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id3."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count3*$objResult31["unit1"];
$unit2 = $sale_count3*$objResult31["unit2"];
$unit3 = $sale_count3*$objResult31["unit3"];
$unit4 = $sale_count3*$objResult31["unit4"];
$unit5 = $sale_count3*$objResult31["unit5"];
$unit6 = $sale_count3*$objResult31["unit6"];
$unit7 = $sale_count3*$objResult31["unit7"];
$unit8 = $sale_count3*$objResult31["unit8"];
$unit9 = $sale_count3*$objResult31["unit9"];
$unit10 =$sale_count3*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$id_product1."','".$id_product1."','".$clear_br3."','".$sn3."','1','".$employee_name."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product2."','".$id_product2."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product3."','".$id_product3."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product4."','".$id_product4."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product5."','".$id_product5."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product6."','".$id_product6."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product7."','".$id_product7."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product8."','".$id_product8."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product9."','".$id_product9."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product10."','".$id_product10."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
		
	
$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_id3."','".$product_id3."','".$clear_br3."','".$sn3."','1','".$employee_name."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
	
}	
}


if($product_id4 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id4."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count4*$objResult31["unit1"];
$unit2 = $sale_count4*$objResult31["unit2"];
$unit3 = $sale_count4*$objResult31["unit3"];
$unit4 = $sale_count4*$objResult31["unit4"];
$unit5 = $sale_count4*$objResult31["unit5"];
$unit6 = $sale_count4*$objResult31["unit6"];
$unit7 = $sale_count4*$objResult31["unit7"];
$unit8 = $sale_count4*$objResult31["unit8"];
$unit9 = $sale_count4*$objResult31["unit9"];
$unit10 =$sale_count4*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$id_product1."','".$id_product1."','".$clear_br4."','".$sn4."','1','".$employee_name."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product2."','".$id_product2."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product3."','".$id_product3."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product4."','".$id_product4."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product5."','".$id_product5."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product6."','".$id_product6."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product7."','".$id_product7."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product8."','".$id_product8."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product9."','".$id_product9."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product10."','".$id_product10."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
			
	
$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_id4."','".$product_id4."','".$clear_br4."','".$sn4."','1','".$employee_name."')";

$objQuery4 = mysqli_query($conn,$strSQL4);
}	
}


if($product_id5 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id5."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count5*$objResult31["unit1"];
$unit2 = $sale_count5*$objResult31["unit2"];
$unit3 = $sale_count5*$objResult31["unit3"];
$unit4 = $sale_count5*$objResult31["unit4"];
$unit5 = $sale_count5*$objResult31["unit5"];
$unit6 = $sale_count5*$objResult31["unit6"];
$unit7 = $sale_count5*$objResult31["unit7"];
$unit8 = $sale_count5*$objResult31["unit8"];
$unit9 = $sale_count5*$objResult31["unit9"];
$unit10 =$sale_count5*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$id_product1."','".$id_product1."','".$clear_br5."','".$sn5."','1','".$employee_name."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product2."','".$id_product2."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product3."','".$id_product3."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product4."','".$id_product4."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product5."','".$id_product5."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product6."','".$id_product6."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product7."','".$id_product7."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product8."','".$id_product8."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product9."','".$id_product9."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product10."','".$id_product10."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
				
	
$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_id5."','".$product_id5."','".$clear_br5."','".$sn5."','1','".$employee_name."')";

$objQuery5 = mysqli_query($conn,$strSQL5);
}	
}


if($product_id6 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id6."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count6*$objResult31["unit1"];
$unit2 = $sale_count6*$objResult31["unit2"];
$unit3 = $sale_count6*$objResult31["unit3"];
$unit4 = $sale_count6*$objResult31["unit4"];
$unit5 = $sale_count6*$objResult31["unit5"];
$unit6 = $sale_count6*$objResult31["unit6"];
$unit7 = $sale_count6*$objResult31["unit7"];
$unit8 = $sale_count6*$objResult31["unit8"];
$unit9 = $sale_count6*$objResult31["unit9"];
$unit10 =$sale_count6*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$id_product1."','".$id_product1."','".$clear_br6."','".$sn6."','1','".$employee_name."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product2."','".$id_product2."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product3."','".$id_product3."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product4."','".$id_product4."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product5."','".$id_product5."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product6."','".$id_product6."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product7."','".$id_product7."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product8."','".$id_product8."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product9."','".$id_product9."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product10."','".$id_product10."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
					
	
$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_id6."','".$product_id6."','".$clear_br6."','".$sn6."','1','".$employee_name."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
}
}


if($product_id7 !==''  ){


$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id7."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count7*$objResult31["unit1"];
$unit2 = $sale_count7*$objResult31["unit2"];
$unit3 = $sale_count7*$objResult31["unit3"];
$unit4 = $sale_count7*$objResult31["unit4"];
$unit5 = $sale_count7*$objResult31["unit5"];
$unit6 = $sale_count7*$objResult31["unit6"];
$unit7 = $sale_count7*$objResult31["unit7"];
$unit8 = $sale_count7*$objResult31["unit8"];
$unit9 = $sale_count7*$objResult31["unit9"];
$unit10 =$sale_count7*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$id_product1."','".$id_product1."','".$clear_br7."','".$sn7."','1','".$employee_name."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product2."','".$id_product2."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product3."','".$id_product3."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product4."','".$id_product4."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product5."','".$id_product5."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product6."','".$id_product6."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product7."','".$id_product7."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product8."','".$id_product8."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product9."','".$id_product9."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product10."','".$id_product10."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
					
	

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_id7."','".$product_id7."','".$clear_br7."','".$sn7."','1','".$employee_name."')";

$objQuery7 = mysqli_query($conn,$strSQL7);
	
}
}


if($product_id8 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id8."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count8*$objResult31["unit1"];
$unit2 = $sale_count8*$objResult31["unit2"];
$unit3 = $sale_count8*$objResult31["unit3"];
$unit4 = $sale_count8*$objResult31["unit4"];
$unit5 = $sale_count8*$objResult31["unit5"];
$unit6 = $sale_count8*$objResult31["unit6"];
$unit7 = $sale_count8*$objResult31["unit7"];
$unit8 = $sale_count8*$objResult31["unit8"];
$unit9 = $sale_count8*$objResult31["unit9"];
$unit10 =$sale_count8*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$id_product1."','".$id_product1."','".$clear_br8."','".$sn8."','1','".$employee_name."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product2."','".$id_product2."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product3."','".$id_product3."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product4."','".$id_product4."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product5."','".$id_product5."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product6."','".$id_product6."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product7."','".$id_product7."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product8."','".$id_product8."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product9."','".$id_product9."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,type_br,sale_area)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product10."','".$id_product10."','1','".$employee_name."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
						
$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,type_br,sale_area)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_id8."','".$product_id8."','".$clear_br8."','".$sn8."','1','".$employee_name."')";

$objQuery8 = mysqli_query($conn,$strSQL8);
}	
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

//echo $strSQL89;

 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());


 
 $strSQL90 =  "insert into tb_transaction (running,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$nextId."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";


//echo $strSQL90;
//exit();
$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  so__main set job_id='".$nextId."',send_cs='2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	

	
	}

}

	 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_allwell_bredit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
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

?>

<p align="center"><a href="main_allwell.php"><span class="style18">กลับสู่หน้าหลัก</span></a></p>

</center>
</body>
</html>



