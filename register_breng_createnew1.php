<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$company = $_POST["company"];
$date_br = $_POST["date_br"];
$customer = $_POST["customer"];
$customer_id = $_POST["customer_id"];
$address = $_POST["address"];
$sale_comment = $_POST["sale_comment"];
$sn_ckk = $_POST["sn_ckk"];
$sn = $_POST["sn"];
$objective = $_POST["objective"];
$objective_des1 = $_POST["objective_des1"];
$objective_des2 = $_POST["objective_des2"];
$objective_des4 = $_POST["objective_des4"];
$objective_des5 = $_POST["objective_des5"];
$return_date_bet = $_POST["return_date_bet"];
$returns = $_POST["returns"];
$returns_date = $_POST["returns_date"];
$returns_time = $_POST["returns_time"];
$returns_name = $_POST["returns_name"];
$returns_address = $_POST["returns_address"];
$returns_contact = $_POST["return_contact"];
$status_doc = "Request";
$delivery_name = $_POST["customer_name"];
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$delivery_time = "$start_time $end_time";
$delivery_address = $_POST["address_send"];
$delivery_contact = $_POST["customer_name"];
$delivery_tel = $_POST["customer_tel"];
$date_send_key  = $_POST["between_date"];
$iv_no = "BRNP";

$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
$sale_code = $_SESSION['code'];
$name =  $_SESSION['name'];
$em_id =  $_SESSION['emid'];
//echo $sale_code;
//exit();

$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";



$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$product_id = $_POST["product_id"];
$product_name = $_POST["product_name"];

	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id_br) AS MAXID FROM hos__br ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = substr($rs['MAXID'], -5);
$maxId3 = substr($rs['MAXID'],-9);

$maxId1 = substr($maxId3,0,-5);

$so = "BR";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -5);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "00001"; 
$nextId = $yearMonth.$maxId1;

}


$so = "BR";
$ref_id_br ="$so$nextId";

$type_breng = $_POST["type_breng"]; 






$save="insert into hos__br
(company,ref_id_br,date_br,customer,customer_id,address,sale_comment,sn_ckk,sn,objective,objective_des1,objective_des2,objective_des4,objective_des5,returns,returns_date,returns_time,returns_name,returns_address,returns_contact,status_doc,delivery_name,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,date_send_key,sale_date,sale,sale_code,add_date,add_by,return_date_bet,type_breng)
values
('".$company."','".$ref_id_br."','".$date_br."','".$customer."','".$customer_id."','".$address."','".$sale_comment."','".$sn_ckk."','".$sn."','".$objective."','".$objective_des1."','".$objective_des2."','".$objective_des4."','".$objective_des5."','".$returns."','".$returns_date."','".$returns_time."','".$returns_name."','".$returns_address."','".$returns_contact."','".$status_doc."','".$delivery_name."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$date_send_key."','".$sale_date."','".$sale."','".$sale_code."','".$add_date."','".$add_by."','".$return_date_bet."','".$type_breng."')";


$qsave=mysqli_query($conn,$save);


$save56="insert into tb_other_bill
(ref_id,head_1,ref_1,ref_2,ref_3,ref_4,ref_5,ref_6,ref_7,ref_8,ref_9,ref_10,ref_des)
values
('".$ref_id_br."','".$head_1."','".$ref_1."','".$ref_2."','".$ref_3."','".$ref_4."','".$ref_5."','".$ref_6."','".$ref_7."','".$ref_8."','".$ref_9."','".$ref_10."','".$ref_des."')";
$qsave56=mysqli_query($conn,$save56);
	

foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
		$sale_remarkk_new=$sale_remarkk[$key];
		$product_id_new =$product_id[$key];
		$product_name_new  =$product_name[$key];
		
		$sum_amount_new = $product_price_new *$sale_count_new;
		 //echo $sum_amount_new;

if($product_name_new !=""){ 
	
$strSQL = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count_new."','".$sale_count_new."','".$product_price_new."','".$sum_amount_new."','".$sale_remarkk_new."','".$product_id_new."','".$product_id_new."')";
//echo $strSQL1;
//exit();

$objQuery = mysqli_query($conn,$strSQL);
}

}







$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);


$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);


$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);



$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);


$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);








if($product_id6 !==''  ){

$strSQL6 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$product_id6."','".$product_id6."')";
//echo $strSQL1;
//exit();

$objQuery6 = mysqli_query($conn,$strSQL6);

}


if($product_id7 !==''  ){

$strSQL7 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$product_id7."','".$product_id7."')";
//echo $strSQL1;
//exit();

$objQuery7 = mysqli_query($conn,$strSQL7);

}


if($product_id8 !==''  ){

$strSQL8 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$product_id8."','".$product_id8."')";
//echo $strSQL1;
//exit();

$objQuery8 = mysqli_query($conn,$strSQL8);

}


if($product_id9 !==''  ){

$strSQL9 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$product_id9."','".$product_id9."')";
//echo $strSQL1;
//exit();

$objQuery9 = mysqli_query($conn,$strSQL9);

}


if($product_id10 !==''  ){

$strSQL10 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$product_id10."','".$product_id10."')";
//echo $strSQL1;
//exit();

$objQuery10 = mysqli_query($conn,$strSQL10);

}






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
 $type_company=$_POST["company_name"];
 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
$on_time =$_POST["on_time"];	
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
$address_1 = $_POST["address_1"];

$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,province_name) 

values('".$ref_id_br."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$province_name."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());










	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_brhos_edit.php?ref_id_br=$ref_id_br';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


