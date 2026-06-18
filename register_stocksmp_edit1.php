<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$smp_no = $_POST["smp_no"];
$ref_idsmp = $_POST['ref_idsmp'];
$stock_date = date('Y-m-d');
$stock_name = $_SESSION['name'];
$delivery_type = $_POST['delivery_type'];
$send_cs = $_POST['send_cs'];
$product_code_same = $_POST["product_code_same"];
$id = $_POST["subsmp_id"];
$sn = $_POST["sn"];
$sum_amount1 = $_POST["sum_amount1"];
$unit_price = $_POST["unit_price"];
$product_id  = $_POST["product_id"];
$sale_count = $_POST["sale_count"];
$date_disburse = $_POST["date_disburse"];
$ref_no = $_POST["ref_no"];

$save="Update  hos__smp set smp_no = '".$smp_no."',send_admin = '1',stock_name='".$stock_name."',stock_date='".$stock_date."',delivery_type = '".$delivery_type."',date_disburse ='".$date_disburse."',ref_no='".$ref_no."'  where ref_idsmp = '".$ref_idsmp."'";


$qsave=mysqli_query($conn,$save);

	
  foreach($id as $key =>$value)
	{
		$id_new = $id[$key];
	  	$product_code_same_new=$product_code_same[$key];
        $sn_new = $sn[$key];
	  $sale_count_new = $sale_count[$key];
$product_id_new = $product_id[$key];
	  $unit_price_new  = $unit_price[$key];
	  $sum_amount_new = $sum_amount1[$key];
		  
		  
	  
	 $qfirst = "select * from hos__subsmp where reff_idsmp = '".$ref_idsmp."'";
			$first = mysqli_query($conn,$qfirst);
			$ffirst = mysqli_fetch_array($first); 
	  if($ffirst["sale_countref"]!=$sale_count_new){

$strSQL126 = "insert into hos__subsmp_ref
(reff_idsmp,product_id,product_code,sale_count,unit_price,sum_amount,edit_product)
values ('".$ref_idsmp."','".$product_id_new."','".$product_id_new."','".$sale_count_new."','".$unit_price_new."','".$sum_amount_new."','1')";

$objQuery126 = mysqli_query($conn,$strSQL126);
		  
		  
	  }
	  
$strSQL = "Update   hos__subsmp set  code_same='$product_code_same_new',sn = '".$sn_new."',sale_count = '".$sale_count_new."'  Where subsmp_id = '$id_new' ";
	  
	 
$objQuery = mysqli_query($conn,$strSQL);
	
}	
	
	
$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);



$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);




$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);




$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);



$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);






if($product_id6 !==''  ){

$strSQL6 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount)
values ('".$ref_idsmp."','".$product_id6."','".$product_id6."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$sum_amount6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
	
	
$strSQL16 = "insert into hos__subsmp_ref
(reff_idsmp,product_id,product_code,sale_count,unit_price,sum_amount,stock_ckk)
values ('".$ref_idsmp."','".$product_id6."','".$product_id6."','".$sale_count6."','".$product_price6."','".$sum_amount6."','1')";

$objQuery16 = mysqli_query($conn,$strSQL16);


}


if($product_id7 !==''  ){

$strSQL7 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount)
values ('".$ref_idsmp."','".$product_id7."','".$product_id7."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$sum_amount7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);
	
$strSQL17 = "insert into hos__subsmp_ref
(reff_idsmp,product_id,product_code,sale_count,unit_price,sum_amount,stock_ckk)
values ('".$ref_idsmp."','".$product_id7."','".$product_id7."','".$sale_count7."','".$product_price7."','".$sum_amount7."','1')";

$objQuery17 = mysqli_query($conn,$strSQL17);


}


if($product_id8 !==''  ){

$strSQL8 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount)
values ('".$ref_idsmp."','".$product_id8."','".$product_id8."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$sum_amount8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);
	
	
$strSQL18 = "insert into hos__subsmp_ref
(reff_idsmp,product_id,product_code,sale_count,unit_price,sum_amount,stock_ckk)
values ('".$ref_idsmp."','".$product_id8."','".$product_id8."','".$sale_count8."','".$product_price8."','".$sum_amount8."','1')";

$objQuery18 = mysqli_query($conn,$strSQL18);


}


if($product_id9 !==''  ){

$strSQL9 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount)
values ('".$ref_idsmp."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$sum_amount9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);
	
	
$strSQL19 = "insert into hos__subsmp_ref
(reff_idsmp,product_id,product_code,sale_count,unit_price,sum_amount,stock_ckk)
values ('".$ref_idsmp."','".$product_id9."','".$product_id9."','".$sale_count9."','".$product_price9."','".$sum_amount9."','1')";

$objQuery19 = mysqli_query($conn,$strSQL19);

}


if($product_id10 !==''  ){

$strSQL10 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount)
values ('".$ref_idsmp."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$sum_amount10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);
	
	
$strSQL110 = "insert into hos__subsmp_ref
(reff_idsmp,product_id,product_code,sale_count,unit_price,sum_amount,stock_ckk)
values ('".$ref_idsmp."','".$product_id10."','".$product_id10."','".$sale_count10."','".$product_price10."','".$sum_amount10."','1')";

$objQuery110 = mysqli_query($conn,$strSQL110);

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
$address_1 =$_POST["address_1"];
$add_code = $_POST["h_employee_name"];
	
	
	$strSQL22 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_idsmp."' ";

$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$Num_Rows22 = mysqli_num_rows($objQuery22);

	if($Num_Rows22 > 0){

$strSQL66 =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name1."',customer_tel ='".$customer_tel."',address_name ='".$address_name1."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',address_1 = '".$address_1."',add_code = '".$add_code."'  where ref_id = '".$ref_idsmp."'";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());

	}else{
		
$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code) 

values('".$ref_idsmp."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_name1."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$add_code."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());		
		
		
		
	}
		
include("dbconnect_cs.php");
	
if( $send_cs =='1'){
		
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

$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,on_time,add_code) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_1."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$on_time."','".$add_code."')";

$objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());

$strSQL90 =  "insert into tb_transaction (running) 

values('".$nextId."')";


//echo $strSQL90;
//exit();
$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  hos__smp set send_cs ='2'  where ref_idsmp='".$ref_idsmp."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
	}

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_stocksmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


