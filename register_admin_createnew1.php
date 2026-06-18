
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
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
	
	
$qfirst = "select * from so__main ORDER BY main_id DESC LIMIT 1";
$first = mysqli_query($conn,$qfirst);
$Num_Rows88 = mysqli_num_rows($first);
$ffirst = mysqli_fetch_array($first);
	
$ref_id = $ffirst['main_id']+1;
$main_id = $ffirst['main_id']+1;

$register_date = date("Y/m/d");
$register_time = date("H:i:s");
$sale_channel = $_POST["sale_channel"];
$select_type_doc = $_POST["select_type_doc"];
$payment = $_POST["h_payment"];
$delivery = $_POST["h_delivery"];
$customer_name = $_POST["customer_name"];
$sale_remark = $_POST["sale_remark"];
$employee_name = $_POST["employee_name"];
$bill_vat = $_POST["bill_vat"];
$doc_release_date = $_POST["doc_release_date"];
$job_id = $_POST["job_id"];
$billing_name = $_POST["billing_name"];
$billing_address = $_POST["billing_address"];
$billing_tel = $_POST["billing_tel"];
$full_bill = $_POST["full_bill"];
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
$order_id = $_POST["order_id"];
$order_name = $_POST["order_name"];
$bill_id = $_POST["bill_id"];
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
$create_order = $_POST["create_order"];
$deposit_no = $_POST["deposit_no"];
$order_refer_code = $_POST["order_refer_code"];
	
$pre_name = $_POST["pre_name"];	
$ex_add = $_POST["ex_add"];	
$ex_aumper = $_POST["ex_aumper"];	
$ex_provin = $_POST["ex_provin"];	
$ex_post = $_POST["ex_post"];	
$email = $_POST["email"];	
$tax_id = $_POST["tax_id"];	
$run_et = $_POST["run_et"];	
	
	
	
$approve_complete ='Approve';
	
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

$save5="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$_POST["doc_release_date"]."')";
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

$save="insert into tb_doc_nbm (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$_POST["doc_release_date"]."')";
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
	

$save="insert into tb_solptl (doc_no,date_sol,sale_channel) values ('".$doc_no."','".$doc_release_date."','".$sale_channel ."')";
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
}else if($run_et=='1'){
	if($select_type_doc =='3'){
	
$date = explode('-' , $_POST["doc_release_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_awl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	
		
$save5="insert into tb_et_awl (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."')";
$qsave5=mysqli_query($conn,$save5);
		
		
	}else if($select_type_doc =='4'){
		
$date = explode('-' , $_POST["doc_release_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";
$so1 = "-";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_et_nbm (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."')";
$qsave=mysqli_query($conn,$save);
		
	}
	
}else{
$doc_no = $_POST["doc_no"];
}
	
if($select_type_doc =='3'){
$save19="UPDATE tb_doc_ptl SET ref_so ='".$ref_id."',iv_date='".$doc_release_date."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}else if($select_type_doc =='4'){
	
$save19="UPDATE tb_doc_nbm SET ref_so ='".$ref_id."',iv_date='".$doc_release_date."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
}	
	

$save="insert into so__main
(main_id,ref_id,register_date,register_time,sale_channel,select_type_doc,delivery,payment,sale_remark,employee_name,doc_no,doc_release_date,job_id,billing_name,billing_address,billing_tel,full_bill,transfer,account_approve,transfer_date,amount,delivery_name,address1,address2,province,postcode,tel,prefer_name,po_no,delivery_contract,clear_book_no,clear_brn_no,clear_brnp_no,sn,bq,ot,install_place,type_type,type_type_detail,delivery_date,delivery_time,big_car,call_before,maps,assign_date_time,delivery_type,delivery_place,delivery_contact,returns,return_date,return_time,return_address,return_contact,order_name,order_id,add_date,add_by,clear_book_ckk,status_doc,upload1,upload2,upload3,upload4,upload5,customer_name,clear_brn_no_ckk,clear_brnp_no_ckk,sn_ckk,bq_ckk,ot_ckk,deposit_no,upload_map,iv_no,order_refer_code,approve_complete,allwell_ckk,bill_id,bill_vat,create_order,pre_name,ex_add,ex_aumper,ex_provin,ex_post,email,tax_id)
values
('$main_id','$ref_id','$register_date','$register_time','$sale_channel','$select_type_doc','$delivery','$payment','$sale_remark','$employee_name','$doc_no','$doc_release_date','$job_id','$billing_name','$billing_address','$billing_tel','$full_bill','$transfer','$account_approve','$transfer_date','$amount','$delivery_name','$address1','$address2','$province','$postcode','$tel','$prefer_name','$po_no','$delivery_contract','$clear_book_no','$clear_brn_no','$clear_brnp_no','$sn','$bq','$ot','$install_place','$type_type','$type_type_detail','$delivery_date','$delivery_time','$big_car','$call_before','$maps','$assign_date_time','$delivery_type','$delivery_place','$delivery_contact','$returns','$return_date','$return_time','$return_address','$return_contact','$order_name','$order_id','$add_date','$add_by','$clear_book_ckk','$status_doc','".$_FILES['upload1']['name']."','".$_FILES['upload2']['name']."','".$_FILES['upload3']['name']."','".$_FILES['upload4']['name']."','".$_FILES['upload5']['name']."','$customer_name','$clear_brn_no_ckk','$clear_brnp_no_ckk','$sn_ckk','$bq_ckk','$ot_ckk','$deposit_no','".$_FILES['upload_map']['name']."','$iv_no','$order_refer_code','".$approve_complete."','".$allwell_ckk."','".$bill_id."','".$bill_vat."','".$create_order."','".$pre_name."','".$ex_add."','".$ex_aumper."','".$ex_provin."','".$ex_post."','".$email."','".$tax_id."')";

$qsave=mysqli_query($conn,$save);

$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$sale_countref = $_POST["sale_countref"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$warranty =$_POST["warranty"];
 $pm=$_POST["pm"];
 $cal=$_POST["cal"];
 $product_id = $_POST["product_id"];
 $discount_unit = $_POST["discount_unit"];
$product_priceref = $_POST["product_priceref"];

	
 foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
		$cal_new=$cal[$key];
	   $product_priceref_new = $product_priceref[$key];
        $product_id_new =$product_id[$key];
       $sale_countref_new = $sale_countref[$key];
	  $clear_ivno_new = $clear_ivno[$key];
	  $clear_ivno1_new = $clear_ivno1[$key];
	  $clear_br_new = $clear_br[$key];
if($sale_channel=='1' or $sale_channel=='20' or $sale_channel=='12'){
	$sum_amount1 = $sum_amount[$key];
	$sum_amount_new = str_replace(',','', $sum_amount1);
	$sale_count_new = $sale_count[$key];
	 $discount_unit_new = $discount_unit[$key];
	$product_price_new = ($sum_amount_new / $sale_count_new)+$discount_unit_new;
}else{
	$sale_count_new = $sale_count[$key];
	 $discount_unit1 = $discount_unit[$key];
	$discount_unit_new = str_replace(',','', $discount_unit1);
	$product_price1 = $product_price[$key];
	$product_price_new = str_replace(',','', $product_price1);
	$sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;
}
	  
	  
if($product_id_new!=''){

	 
$strSQL1 = "insert into so__submain
(ref_idd,product_code,product_id,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_id_new."','".$product_id_new."','".$sale_count_new."','".$sale_count_new."','".$product_price_new."','".$product_price_new."','".$sum_amount_new."','".$sale_remarkk_new."','".$discount_unit_new."','".$warranty_new."','".$cal_new."','".$pm_new."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	 
 }
	  
	  
	  
}	
	


/*$product_code1 = $_POST["product_code1"];
$product_codet1 = $_POST["product_codet1"];

$product_name1 = $_POST["product_name1"];
$unit_name1 = $_POST["unit_name1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$discount_unit1 = $_POST["discount_unit1"];
$warranty1  = $_POST["warranty1"];
$cal1 = $_POST["cal1"];
$pm1 = $_POST["pm1"];




$product_code2 = $_POST["product_code2"];
$product_codet2 = $_POST["product_codet2"];

$product_name2 = $_POST["product_name2"];
$unit_name2 = $_POST["unit_name2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];
$warranty2  = $_POST["warranty2"];
$cal2 = $_POST["cal2"];
$pm2 = $_POST["pm2"];


$product_code3 = $_POST["product_code3"];
$product_codet3 = $_POST["product_codet3"];

$product_name3 = $_POST["product_name3"];
$unit_name3 = $_POST["unit_name3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];
$warranty3  = $_POST["warranty3"];
$cal3 = $_POST["cal3"];
$pm3 = $_POST["pm3"];


$product_code4 = $_POST["product_code4"];
$product_codet4 = $_POST["product_codet4"];

$product_name4 = $_POST["product_name4"];
$unit_name4 = $_POST["unit_name4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];
$warranty4  = $_POST["warranty4"];
$cal4 = $_POST["cal4"];
$pm4 = $_POST["pm4"];




$product_code5 = $_POST["product_code5"];
$product_codet5 = $_POST["product_codet5"];

$product_name5 = $_POST["product_name5"];
$unit_name5 = $_POST["unit_name5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_POST["discount_unit5"];
$warranty5  = $_POST["warranty5"];
$cal5 = $_POST["cal5"];
$pm5 = $_POST["pm5"];


$product_code6 = $_POST["product_code6"];
$product_codet6 = $_POST["product_codet6"];

$product_name6 = $_POST["product_name6"];
$unit_name6 = $_POST["unit_name6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];
$warranty6  = $_POST["warranty6"];
$cal6 = $_POST["cal6"];
$pm6 = $_POST["pm6"];


$product_code7 = $_POST["product_code7"];
$product_codet7 = $_POST["product_codet7"];
$product_name7 = $_POST["product_name7"];
$unit_name7 = $_POST["unit_name7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];
$warranty7  = $_POST["warranty7"];
$cal7 = $_POST["cal7"];
$pm7 = $_POST["pm7"];


$product_code8 = $_POST["product_code8"];
$product_codet8 = $_POST["product_codet8"];

$product_name8 = $_POST["product_name8"];
$unit_name8 = $_POST["unit_name8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];
$warranty8  = $_POST["warranty8"];
$cal8 = $_POST["cal8"];
$pm8 = $_POST["pm8"];



$product_code9 = $_POST["product_code9"];
$product_codet9 = $_POST["product_codet9"];

$product_name9 = $_POST["product_name9"];
$unit_name9 = $_POST["unit_name9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];
$warranty9  = $_POST["warranty9"];
$cal9 = $_POST["cal9"];
$pm9 = $_POST["pm9"];


$product_code10 = $_POST["product_code10"];
$product_codet10 = $_POST["product_codet10"];

$product_name10 = $_POST["product_name10"];
$unit_name10 = $_POST["unit_name10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];
$warranty10  = $_POST["warranty10"];
$cal10 = $_POST["cal10"];
$pm10 = $_POST["pm10"];




if($product_code1 !==''  ){

$strSQL1 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code1."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$unit_name1."','".$product_name1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);

	

}else if($product_codet1 !==''  ){
	
$strSQL1 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_codet1."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$unit_name1."','".$product_name1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
	


	
}

if($product_code2 !==''){

$strSQL2 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code2."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$product_price2."','".$sum_amount2."','".$unit_name2."','".$product_name2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
	



}else if($product_codet2 !==''){


$strSQL2 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_codet2."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$product_price2."','".$sum_amount2."','".$unit_name2."','".$product_name2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."')";
$objQuery2 = mysqli_query($conn,$strSQL2);

	
	


}


if($product_code3 !==''){

$strSQL3 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code3."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$product_price3."','".$sum_amount3."','".$unit_name3."','".$product_name3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
	
	



}else if($product_codet3 !==''){

$strSQL3 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_codet3."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$product_price3."','".$sum_amount3."','".$unit_name3."','".$product_name3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);

	
	



}





if($product_code4 !==''){

$strSQL4 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code4."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$product_price4."','".$sum_amount4."','".$unit_name4."','".$product_name4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);
	
	



}else if($product_codet4 !==''){

$strSQL4 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_codet4."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$product_price4."','".$sum_amount4."','".$unit_name4."','".$product_name4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);
	
	


}

if($product_code5 !==''){

$strSQL5 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code5."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$product_price5."','".$sum_amount5."','".$unit_name5."','".$product_name5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);
	
	


}else if($product_codet5 !==''){

$strSQL5 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_codet5."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$product_price5."','".$sum_amount5."','".$unit_name5."','".$product_name5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);

	

}







if($product_code6 !==''){

$strSQL6 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code6."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$unit_name6."','".$product_name6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
	
	



}else if($product_codet6 !==''){

$strSQL6 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_codet6."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$unit_name6."','".$product_name6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);

	


}

if($product_code7 !==''){

$strSQL7 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code7."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$unit_name7."','".$product_name7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);
	
	
	



}else if($product_codet7 !==''){

$strSQL7 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_codet7."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$unit_name7."','".$product_name7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);

	


}

if($product_code8 !==''){

$strSQL8 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code8."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$unit_name8."','".$product_name8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);

	

}else if($product_codet8 !==''){

$strSQL8 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_codet8."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$unit_name8."','".$product_name8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);



}


if($product_code9 !==''){

$strSQL9 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code9."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$unit_name9."','".$product_name9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);
	

}else if($product_codet9 !==''){

$strSQL9 = "insert into so__submain
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_codet9."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$unit_name9."','".$product_name9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);

}

if($product_code10 !==''){

$strSQL10 = "insert into so__submain 
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code10."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$unit_name10."','".$product_name10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);
	

}else if($product_codet10 !==''){

$strSQL10 = "insert into so__submain 
(ref_idd,product_code,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_codet10."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$unit_name10."','".$product_name10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);

	
	

}

	
if ($unit_name1=='เตียง' or $unit_name2=='เตียง' or $unit_name3=='เตียง' or $unit_name4=='เตียง' or $unit_name5=='เตียง' or $unit_name6=='เตียง' or $unit_name7=='เตียง' or $unit_name8=='เตียง' or $unit_name9=='เตียง' or $unit_name10=='เตียง' or $product_id1 =='3199'  or $product_id2 =='3199' or $product_id3 =='3199' or $product_id4 =='3199' or $product_id5 =='3199' or $product_id6 =='3199' or $product_id7 =='3199' or $product_id8 =='3199' or $product_id9 =='3199' or $product_id10 =='3199'){

$strSQL25="Update  so__main set approve_complete='Request'  where ref_id='".$ref_id."'";
//echo $strSQL25;
$objQuery25 = mysqli_query($conn,$strSQL25);

}else{
	
}*/
$strSQL25="Update  so__main set approve_complete='Approve'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_admin_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
	

?>


</center>
</body>
</html>



