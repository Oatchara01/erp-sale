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

//$main_id = $_POST["main_id"];
//$ref_id = $_POST["ref_id"];
$register_date = date("Y/m/d");
$register_time = date("H:i:s");
$sale_channel = $_POST["sale_channel"];
$select_type_doc = $_POST["select_type_doc"];
$billing_name = $_POST["billing_name"];
$billing_address = $_POST["billing_address"];
$billing_tel = $_POST["billing_tel"];
$bill_vat = $_POST["bill_vat"];

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
$delivery = $_POST["delivery"];
$employee_name = $_POST["employee_name"];

$other_payment = $_POST["other_payment"];
$big_car = $_POST["big_car"];
$delivery_date = $_POST["delivery_date"];
$delivery_time = $_POST["delivery_time"];
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
$delivery_type = $_POST["delivery_type"];
$returns = $_POST["returns"];
$return_date = $_POST["return_date"];
$return_time = $_POST["return_time"];
$return_address = $_POST["return_address"];
$return_contact = $_POST["return_contact"];
$prefer_name = $_POST["prefer_name"];
$po_no = $_POST["po_no"];
$delivery_contract = $_POST["delivery_contract"];
$with_pr = $_POST["with_pr"];
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

$clear_brn_no_ckk = $_POST["clear_brn_no_ckk"];
$clear_brnp_no_ckk = $_POST["clear_brnp_no_ckk"];
$sn_ckk = $_POST["sn_ckk"];
$bq_ckk = $_POST["bq_ckk"];
$ot_ckk = $_POST["ot_ckk"];
$transfer = $_POST["transfer"];

$review_date_call = $_POST["review_date_call"];
$review_call_des = $_POST["review_call_des"];
$review_date = $_POST["review_date"];
$promotion_date = $_POST["promotion_date"];
$review_description = $_POST["review_description"];
$warranty_h = $_POST["warranty_h"];



$pr_no  = $_POST["pr_no"];
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$em_id = $_SESSION["emid"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$send_cs =  $_POST["send_cs"];
//echo $_FILES['upload1']['name'];
//exit();
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


$save="insert into so__main
(ref_id,register_date,register_time,sale_channel,select_type_doc,billing_name,billing_address,billing_tel,full_bill,customer_name,address1,address2,province,postcode,tel,delivery_place,delivery_contact,withdraw_objective,payment,other_payment,delivery,big_car,delivery_date,delivery_time,call_before,assign_date_time,maps,employee_name,approve_name,discount,sale_complete,sale_remark,sn,bq,ot,delivery_type,returns,return_date,return_time,return_address,return_contact,prefer_name,po_no,delivery_contract,clear_book_no,clear_brn_no,clear_brnp_no,type_type,type_type_detail,install_place,account_approve,amount,transfer_date,order_id,order_name,order_delivery_date,order_refer_code,bill_vat,clear_book_ckk,upload1,upload2,upload3,upload4,upload5,status_doc,clear_brn_no_ckk,clear_brnp_no_ckk,sn_ckk,bq_ckk,ot_ckk,upload_map,transfer,review_date_call,review_call_des,review_date,pomotion_date,review_description,pr_no,add_by,send_cs,allwell_ckk)
values
('$ref_id','$register_date','$register_time','$sale_channel','$select_type_doc','$billing_name','$billing_address','$billing_tel','$full_bill','$billing_name','$address1','$address2','$province','$postcode','$tel','$delivery_place','$billing_name','$withdraw_objective','$payment','$other_payment','$delivery','$big_car','$delivery_date','$delivery_time','$call_before','$assign_date_time','$maps','$employee_name','$approve_name','$discount','$sale_complete','$sale_remark','$sn','$bq','$ot','$delivery_type','$returns','$return_date','$return_time','$return_address','$return_contact','$prefer_name','$po_no','$delivery_contract','$clear_book_no','$clear_brn_no','$clear_brnp_no','$type_type','$type_type_detail','$install_place','$account_approve','$amount','$transfer_date','$order_id','$order_name','$order_delivery_date','$order_refer_code','$bill_vat','$clear_book_ckk','".$_FILES['upload1']['name']."','".$_FILES['upload2']['name']."','".$_FILES['upload3']['name']."','".$_FILES['upload4']['name']."','".$_FILES['upload5']['name']."','1','$clear_brn_no_ckk','$clear_brnp_no_ckk','$sn_ckk','$bq_ckk','$ot_ckk','".$_FILES['upload_map']['name']."','$transfer','$review_date_call','$review_call_des','$review_date','$promotion_date','$review_description','$pr_no','".$add_by."','".$send_cs."','1')";


//echo $save;
	//exit();

$qsave=mysqli_query($conn,$save);



$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$warranty =$_POST["warranty"];
 $pm=$_POST["pm"];
 $cal=$_POST["cal"];
 $product_id = $_POST["product_id"];
 $discount_unit = $_POST["discount_unit"];
 $sn_number  = $_POST["sn_number"];
 $product_id  = $_POST["product_id"];

  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$product_id_new=$product_id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
		$cal_new=$cal[$key];
		$sn_number_new =$sn_number[$key];
        $product_id_new =$product_id[$key];
        $discount_unit1 =$discount_unit[$key];
	   $discount_unit_new=str_replace(',','', $discount_unit1);
       $sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;

if($product_id_new!=''){
	
$strSQL = "insert into so__submain
(ref_idd,sale_count,price_per_unit,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,sn_number,clear_br,clear_ivno)
values ('".$ref_id."','".$sale_count_new."','".$product_price_new."','".$sum_amount_new."','".$sale_remarkk_new."','".$discount_unit_new."','".$warranty_new."','".$cal_new."','".$pm_new."','".$product_id_new."','".$product_id_new."','".$sn_number_new."','1','".$clear_brnp_no."')";

$objQuery = mysqli_query($conn,$strSQL);

	

	
	
$strSQL1 = "SELECT sum(sale_count) as count FROM  (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no = '".$clear_brnp_no."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sql3 = "SELECT sum(sale_count) as count3   FROM  so__submain  where clear_ivno = '".$clear_brnp_no."' and clear_br='1' and product_id='".$product_id_new."'";

$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);


$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd) where iv_no = '".$clear_brnp_no."'  and product_id='".$product_id_new."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());

$rs4 = mysqli_fetch_assoc($qry4);

$count3 =  $rs3["count3"];
$count4 =  $rs4["count4"]; 
$count5 = $count3 + $count4;

$count2 = $objResult1["count"] - $count5;


	
	if($count2 == '0'){
$strSQL15 = "Update   so__submain set clear_ckk='1'   Where id= '$id_new' ";
$objQuery15 = mysqli_query($conn,$strSQL15);

	}
		

}

}


$strSQL1 = "SELECT sum(sale_count) as count FROM  (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no = '".$clear_brnp_no."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sql3 = "SELECT sum(sale_count) as count3   FROM  so__submain  where clear_ivno = '".$clear_brnp_no."' and clear_br='1'";

$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);


$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd) where iv_no = '".$clear_brnp_no."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());

$rs4 = mysqli_fetch_assoc($qry4);

$count3 =  $rs3["count3"];
$count4 =  $rs4["count4"]; 
$count5 = $count3 + $count4;

$count2 = $objResult1["count"] - $count5;


	
	if($count2 == '0'){
		
$save1="Update   so__main set  close_br = '1'   where doc_no ='".$clear_brnp_no."'";
$qsave1=mysqli_query($conn,$save1);

	}




/*$product_id1 = $_POST["product_id1"];
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



if($product_id1 !==''  ){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,price_per_unit,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."')";
//echo $strSQL1;
//exit();

$objQuery1 = mysqli_query($conn,$strSQL1);

}


if($product_id2 !==''  ){

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,price_per_unit,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_id2."','".$product_id2."')";
//echo $strSQL1;
//exit();

$objQuery2 = mysqli_query($conn,$strSQL2);

}


if($product_id3 !==''  ){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,price_per_unit,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_id3."','".$product_id3."')";
//echo $strSQL1;
//exit();

$objQuery3 = mysqli_query($conn,$strSQL3);

}


if($product_id4 !==''  ){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,price_per_unit,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_id4."','".$product_id4."')";
//echo $strSQL1;
//exit();

$objQuery4 = mysqli_query($conn,$strSQL4);

}


if($product_id5 !==''  ){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,price_per_unit,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_id5."','".$product_id5."')";
//echo $strSQL1;
//exit();

$objQuery5 = mysqli_query($conn,$strSQL5);

}*/






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

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$mk_research."','".$em_id."')";


//echo $strSQL66."<br>";
//exit();
$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());


 $strSQL99 =  "insert into tb_transaction (ref_id,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$ref_id."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";


//echo $strSQL1;
//exit();
 $objQuery99 = mysqli_query($conn,$strSQL99) or die(mysqli_error());






$unit_name1 = $_POST["unit_name1"];
$unit_name2 = $_POST["unit_name2"];
$unit_name3 = $_POST["unit_name3"];
$unit_name4 = $_POST["unit_name4"];
$unit_name5 = $_POST["unit_name5"];
$unit_name6 = $_POST["unit_name6"];
$unit_name7 = $_POST["unit_name7"];
$unit_name8 = $_POST["unit_name8"];
$unit_name9 = $_POST["unit_name9"];
$unit_name10 = $_POST["unit_name10"];
$unit_name11 = $_POST["unit_name11"];
$unit_name12 = $_POST["unit_name12"];
$unit_name13 = $_POST["unit_name13"];
$unit_name14 = $_POST["unit_name14"];
$unit_name15 = $_POST["unit_name15"];

//Request

if ($unit_name1=='เตียง' or $unit_name2=='เตียง' or $unit_name3=='เตียง' or $unit_name4=='เตียง' or $unit_name5=='เตียง' or $unit_name6=='เตียง' or $unit_name7=='เตียง' or $unit_name8=='เตียง' or $unit_name9=='เตียง' or $unit_name10=='เตียง' or $unit_name11=='เตียง' or $unit_name12=='เตียง' or $unit_name13=='เตียง' or $unit_name14=='เตียง' or $unit_name15=='เตียง' or $product_id1 =='3199'  or $product_id2 =='3199' or $product_id3 =='3199' or $product_id4 =='3199' or $product_id5 =='3199' or $product_id6 =='3199' or $product_id7 =='3199' or $product_id8 =='3199' or $product_id9 =='3199' or $product_id10 =='3199' or $product_id11 =='3199' or $product_id12 =='3199' or $product_id13 =='3199' or $product_id14 =='3199' or $product_id15 =='3199'){

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




?>

<p align="center"><a href="main_allwell.php"><span class="style18">กลับสู่หน้าหลัก</span></a></p>

</center>
</body>
</html>



