<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$smp_date = $_POST["smp_date"];
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
$send_sup= '1';
$sup_name = $_SESSION['name'];
$sup_date = date('Y-m-d');
$comment_sup  = $_POST["comment_sup"];
$type_company  = $_POST["type_company"];
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
$delivery_type = $_POST["delivery_type"];


$save="insert into hos__smp
(ref_idsmp,smp_date,address_name,customer_name,comment_sale,status_sup,sale_date,sale_name,sale_code,add_by,add_date,send_sup,sup_name,sup_date,comment_sup,type_company,send_admin,create_adm,delivery_type)
values
('".$ref_idsmp."','".$smp_date."','".$address_name."','".$customer_name."','".$comment_sale."','".$status_sup."','".$sale_date."','".$sale_name."','".$sale_code."','".$add_by."','".$add_date."','".$send_sup."','".$sup_name."','".$sup_date."','".$comment_sup."','".$type_company."','1','1','".$delivery_type."')";


$qsave=mysqli_query($conn,$save);

$id = $_POST["subsmp_id"];
$product_id = $_POST["product_id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$product_code = $_POST["product_code"];

 foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
        $product_id_new =$product_id[$key];
		$product_code_new =$product_code[$key];

		$sum_amount_new = $product_price_new *$sale_count_new;

if($product_code_new  !=''){

$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount)
values ('".$ref_idsmp."','".$product_id_new."','".$product_id_new."','".$sale_count_new."','".$sale_count_new."','".$product_price_new."','".$sum_amount_new."')";

$objQuery1 = mysqli_query($conn,$strSQL1);


	}
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

}


if($product_id7 !==''  ){

$strSQL7 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount)
values ('".$ref_idsmp."','".$product_id7."','".$product_id7."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$sum_amount7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);

}


if($product_id8 !==''  ){

$strSQL8 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount)
values ('".$ref_idsmp."','".$product_id8."','".$product_id8."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$sum_amount8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);

}


if($product_id9 !==''  ){

$strSQL9 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount)
values ('".$ref_idsmp."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$sum_amount9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);

}


if($product_id10 !==''  ){

$strSQL10 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount)
values ('".$ref_idsmp."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$sum_amount10."')";

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
	
 
 $customer_name1=$_POST["customer_name1"];
 $customer_tel=$_POST["customer_tel"];
 $address_name1=$_POST["address_name1"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
 $on_time = $_POST["on_time"];	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $strSQL1 = "SELECT * FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp='".$ref_idsmp."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$output1 = "";
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$output1 .=  "" .$objResult1["sol_name"]. "  " .$objResult1["sale_count"]. "  " .$objResult1["unit_name"]. "  "; 
	
}
	
 $product_name= $output1;
 $product_sn = $ref_idsmp;
	
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

values('".$ref_idsmp."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_name1."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());
}











	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminsmp1_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


