<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_doc = $_POST["type_doc"];
$bill_name = $_POST["bill_name"];
$bill_address = $_POST["bill_address"];
$bill_tel = $_POST["bill_tel"];
$full_bill = $_POST["full_bill"];
$bill_id = $_POST["bill_id"];
$date_so = $_POST["date_so"];
$suggest = $_POST["suggest"];
$payment = $_POST["payment"];
$sale_comment = $_POST["sale_comment"];
$po_no = $_POST["po_no"];
$delivery_contract = $_POST["delivery_contract"];
$book_clear = $_POST["book_clear"];
$book_no = $_POST["book_no"];
$brn_clear = $_POST["brn_clear"];
$brn_no = $_POST["brn_no"];
$brnp_clear = $_POST["brnp_clear"];
$brnp_no = $_POST["brnp_no"];
$sn_ckk = $_POST["sn_ckk"];
$sn_no = $_POST["sn_no"];
$install_place = $_POST["address_send"];
$with_pr = $_POST["with_pr"];
$type_type = $_POST["type_type"];
$type_detail = $_POST["type_detail"];
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$delivery_time = "$start_time $end_time";
$delivery_address = $_POST["address_name"];
$delivery_contact = $_POST["customer_name"];
$delivery_tel = $_POST["customer_tel"];
$tax_id = $_POST["tax_id"];	

$date_send_key  = $_POST["between_date"];
$have_order = $_POST["have_order"];
$date_tranfer = $_POST["date_tranfer"];
	

$comment_cs = $_POST["comment_cs"];	
$comment_en = $_POST["comment_en"];	
$comment_st = $_POST["comment_st"];	
$comment_ad = $_POST["comment_ad"];	

	

$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
$sale_code = $_SESSION['code'];
$name =  $_SESSION['name'];
$em_id =  $_SESSION['emid'];


$pr_no  = $_POST["pr_no"];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$payment_des  = $_POST["payment_des"];
$iv_no = "IV";


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
	
	
$head_1 = $_POST["head_1"];	
$ref_1 = $_POST["ref_1"];	
$ref_2 = $_POST["ref_2"];	
$ref_3 = $_POST["ref_3"];	
$ref_4 = $_POST["ref_4"];	
$ref_5 = $_POST["ref_5"];	
$ref_6 = $_POST["ref_6"];	
$ref_7 = $_POST["ref_7"];	
$ref_8 = $_POST["ref_8"];	
$ref_9 = $_POST["ref_9"];	
$ref_10 = $_POST["ref_10"];	
$ref_11 = $_POST["ref_11"];	
$ref_des = $_POST["ref_des"];	
	

	
	move_uploaded_file($_FILES['slip1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip1']['name']));
	move_uploaded_file($_FILES['slip2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip2']['name']));
	move_uploaded_file($_FILES['slip3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip3']['name']));
	move_uploaded_file($_FILES['slip4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip4']['name']));
	move_uploaded_file($_FILES['slip5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip5']['name']));

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__so";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SO";

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

$so = "SO";
$ref_id ="$so$nextId";
$ref_id_jong = $_POST["ref_id_jong"];
	
	

$save="insert into hos__so
(ref_id,type_doc,bill_name,bill_address,full_bill,date_so,suggest,payment,sale_comment,po_no,delivery_contract,book_clear,book_no,brn_clear,brn_no,brnp_clear,brnp_no,sn_ckk,sn_no,install_place,with_pr,type_type,type_detail,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,sale_date,sale,sale_code,pr_no,add_date,add_by,status_doc,bill_tel,payment_des,slip1,slip2,slip3,slip4,slip5,date_send_key,have_order,iv_no,tax_id,bill_id,date_tranfer)
values
('".$ref_id."','".$type_doc."','".$bill_name."','".$bill_address."','".$full_bill."','".$date_so."','".$suggest."','".$payment."','".$sale_comment."','".$po_no."','".$delivery_contract."','".$book_clear."','".$book_no."','".$brn_clear."','".$brn_no."','".$brnp_clear."','".$brnp_no."','".$sn_ckk."','".$sn_no."','".$install_place."','".$with_pr."','".$type_type."','".$type_detail."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$sale_date."','".$sale."','".$sale_code."','".$pr_no."','".$add_date."','".$add_by."','Request','".$bill_tel."','".$payment_des."','".$_FILES['slip1']['name']."','".$_FILES['slip2']['name']."','".$_FILES['slip3']['name']."','".$_FILES['slip4']['name']."','".$_FILES['slip5']['name']."','".$date_send_key."','".$have_order."','".$iv_no."','".$tax_id."','".$bill_id."','".$date_tranfer."')";


$qsave=mysqli_query($conn,$save);


$save56="insert into tb_other_bill
(ref_id,head_1,ref_1,ref_2,ref_3,ref_4,ref_5,ref_6,ref_7,ref_8,ref_9,ref_10,ref_des,ref_11)
values
('".$ref_id."','".$head_1."','".$ref_1."','".$ref_2."','".$ref_3."','".$ref_4."','".$ref_5."','".$ref_6."','".$ref_7."','".$ref_8."','".$ref_9."','".$ref_10."','".$ref_des."','".$ref_11."')";
$qsave56=mysqli_query($conn,$save56);	

$save57="insert into tb_comment_so (ref_id,comment_cs,comment_en,comment_st,comment_ad) values ('".$ref_id."','".$comment_cs."','".$comment_en."','".$comment_st."','".$comment_ad."')";
$qsave57=mysqli_query($conn,$save57);	
	

foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);

		//$sum_amount1=$sum_amount[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
		$cal_new=$cal[$key];
        $product_id_new =$product_id[$key];
        $discount_unit1 =$discount_unit[$key];
		$discount_unit_new=str_replace(',','', $discount_unit1);
		$sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;
		 //echo $sum_amount_new;


$strSQL = "INSERT INTO   hos__subso (ref_idd,count,countref,price_ref,price,amount,sale_remark,warranty,pm,cal,product_id,product_code,discount,jong_ckk,jong_no ) values ('$ref_id','$sale_count_new','$sale_count_new','$product_price_new','$product_price_new','$sum_amount_new','$sale_remarkk_new','$warranty_new','$pm_new','$cal_new','$product_id_new','$product_id_new','$discount_unit_new','1','".$book_no."')     ";

$objQuery = mysqli_query($conn,$strSQL);
}
	


	

$strSQL29 = "SELECT SUM(amount) AS unit_cash FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
$rs = mysqli_fetch_assoc($objQuery29);
		
$amount = $rs["unit_cash"];



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
		$unit_credit=$amount;
	}else{
		$credit='0';
		$unit_credit=$_POST["unit_credit"];
	}
	
	if ($_POST['want_bus']!=''){
	$want_bus=$_POST['want_bus'];
	}else{
		$want_bus='0';
	}
	if ($_POST['call_back']!=''){
		 $call_employee=$_POST['call_back'];
	}else{
		$call_employee='0';
	}
	
	if ($_POST['cash']!=''){
		 $chash=$_POST['cash'];
		$price=$amount;
	}else{
		$chash='0';
		$price=$_POST["unit_cash"];
	}
	
	if ($_POST['check_paper']!=''){
	 $check_peper=$_POST['check_paper'];
		$unit_check1=$amount;
	}else{
		$check_peper='0';
		$unit_check1=$_POST["unit_check"];
	}
	
	if ($_POST['bill']!=''){
		 $bill=$_POST['bill'];
		$unit_bill1=$amount;
	}else{
		$bill='0';
		$unit_bill1=$_POST["unit_bill"];
	}
	
	if ($_POST['tran']!=''){
		 $tran=$_POST["tran"];
		$unit_tran=$amount;
	}else{
		$tran='0';
		$unit_tran=$_POST["unit_tran"];
	}
	
	


	
		if ($_POST['dep']!=''){
		  $dep=$_POST["dep"];
	}else{
		$dep='0';
	}

	
 $department=$_POST["department_name"];
	$type_customer=$_POST["customer_typename"];
	
	if($type_doc=='3'){
 $type_company='ออลล์เวล ไลฟ์ บจก.';
	}else if($type_doc=='4'){
	$type_company='โนเบิล เมด บจก.';	
	}
  $province_name=$_POST["province_name"];
 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
	 $address_1=$_POST["address_1"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	$mk_research = $_POST["mk_research"];
 $on_time = $_POST["on_time"];	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
$product_sn=$_POST["product_sn"];
	if($brnp_no !=''){
  $product_name="เคลียร์ยืม เลขที่ $brnp_no $product_name1  $sale_count1 $unit_name1 $product_name2  $sale_count2 $unit_name2 $product_name3  $sale_count3 $unit_name3 $product_name4  $sale_count4 $unit_name4  $product_name5  $sale_count5 $unit_name5  $product_name6  $sale_count6 $unit_name6 $product_name7  $sale_count7 $unit_name7";
	}else{
 "ส่ง $product_name1  $sale_count1 $unit_name1 $product_name2  $sale_count2 $unit_name2 $product_name3  $sale_count3 $unit_name3 $product_name4  $sale_count4 $unit_name4  $product_name5  $sale_count5 $unit_name5  $product_name6  $sale_count6 $unit_name6 $product_name7  $sale_count7 $unit_name7";	
	}

 $employee_name=$_POST["employee_name"];
 $employee_tel=$_POST["employee_tel"];
 $add_by=$_POST["add_by"];
 $description=$_POST["description"];
 $havemap=$_POST['have_map'];
	$department_show = $_POST["department_show"];

$dept =$_POST["dept"];
$status_comment =$_POST["status_comment"];


$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,mk_research,province_name) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','โรงพยาบาล','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$mk_research."','".$province_name."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());


$save99 = "Update  hos__jongproduct set close_jong ='1',cancel_ckk ='1',remark='ขาย' where ref_id = '".$ref_id_jong."' ";
$qsave99 = mysqli_query($conn,$save99);

$strSQL1 = "Update  hos__subjongpro set  close_ckk ='1' where ref_idd = '".$ref_id_jong."'";
$objQuery1 = mysqli_query($conn,$strSQL1);

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_salehos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


