<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$company = $_POST["company"];
$date_change = $_POST["date_change"];
$customer = $_POST["customer"];
$customer_id = $_POST["customer_id"];
$address = $_POST["address"];
$sale_comment = $_POST["sale_comment"];
$sn_ckk = $_POST["sn_ckk"];
$sn = $_POST["sn"];
$objective = $_POST["objective"];
$objective_des = $_POST["objective_des"];
$return_date_bet  = $_POST["return_date_bet"];
$returns = $_POST["returns"];
$returns_date = $_POST["returns_date"];
$returns_time = $_POST["returns_time"];
$returns_name = $_POST["returns_name"];
$returns_address = $_POST["returns_address"];
$returns_contact = $_POST["returns_contact"];
$status_doc = "Request";
$delivery_name = $_POST["address_name"];
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$delivery_time = "$start_time $end_time";
$delivery_address = $_POST["address_send"];
$delivery_contact = $_POST["customer_name"];
$delivery_tel = $_POST["customer_tel"];
$date_send_key  = $_POST["between_date"];

$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
$sale_code = $_POST["sale_code"];
$name =  $_SESSION['name'];
$em_id =  $_SESSION['emid'];
//echo $sale_code;
	//exit();

$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

	move_uploaded_file($_FILES['slip1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip1']['name']));
	move_uploaded_file($_FILES['slip2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip2']['name']));
	move_uploaded_file($_FILES['slip3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip3']['name']));
	move_uploaded_file($_FILES['slip4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip4']['name']));
	move_uploaded_file($_FILES['slip5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip5']['name']));

	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql1 = "SELECT MAX(ref_id) AS MAXID FROM hos__change ";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$maxId = substr($rs1['MAXID'], -3);
$maxId3 = substr($rs1['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);

$so = "CH";

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


$ref_id ="$so$nextId";






$save="insert into hos__change
(company,ref_id,date_change,customer,customer_id,address,sale_comment,sn_ckk,sn,objective,objective_des,returns,returns_date,returns_time,returns_name,returns_address,returns_contact,status_doc,delivery_name,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,date_send_key,sale_date,sale,sale_code,add_date,add_by,return_date_bet,slip1,slip2,slip3,slip4,slip5,allwell_ckk)
values
('".$company."','".$ref_id."','".$date_change."','".$customer."','".$customer_id."','".$address."','".$sale_comment."','".$sn_ckk."','".$sn."','".$objective."','".$objective_des."','".$returns."','".$returns_date."','".$returns_time."','".$returns_name."','".$returns_address."','".$returns_contact."','".$status_doc."','".$delivery_name."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$date_send_key."','".$sale_date."','".$sale."','".$sale_code."','".$add_date."','".$add_by."','".$return_date_bet."','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','1')";


$qsave=mysqli_query($conn,$save);

$product_id1 = $_POST["product_id1"];
$count_stock1 = $_POST["count_stock1"];
$count_sale1 = $_POST["count_sale1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);




$product_id2 = $_POST["product_id2"];
$count_stock2 = $_POST["count_stock2"];
$count_sale2 = $_POST["count_sale2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);


$product_id3 = $_POST["product_id3"];
$count_stock3 = $_POST["count_stock3"];
$count_sale3 = $_POST["count_sale3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);


$product_id4 = $_POST["product_id4"];
$count_stock4 = $_POST["count_stock4"];
$count_sale4 = $_POST["count_sale4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);




$product_id5 = $_POST["product_id5"];
$count_stock5 = $_POST["count_stock5"];
$count_sale5 = $_POST["count_sale5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);


$product_id6 = $_POST["product_id6"];
$count_stock6 = $_POST["count_stock6"];
$count_sale6 = $_POST["count_sale6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);









if($product_id1 !==''  ){

$strSQL1 = "insert into hos__subchange
(ref_idd,count_stock,count_sale,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id."','".$count_stock1."','".$count_sale1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$product_id1."','".$product_id1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
	
}


if($product_id2 !==''  ){

$strSQL2 ="insert into hos__subchange
(ref_idd,count_stock,count_sale,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id."','".$count_stock2."','".$count_sale2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$product_id2."','".$product_id2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}


if($product_id3 !==''  ){

$strSQL3 = "insert into hos__subchange
(ref_idd,count_stock,count_sale,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id."','".$count_stock3."','".$count_sale3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$product_id3."','".$product_id3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);

	
}


if($product_id4 !==''  ){

$strSQL4 = "insert into hos__subchange
(ref_idd,count_stock,count_sale,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id."','".$count_stock4."','".$count_sale4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$product_id4."','".$product_id4."')";
$objQuery4 = mysqli_query($conn,$strSQL4);

	
}


if($product_id5 !==''  ){

$strSQL5 = "insert into hos__subchange
(ref_idd,count_stock,count_sale,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id."','".$count_stock5."','".$count_sale5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$product_id5."','".$product_id5."')";
$objQuery5 = mysqli_query($conn,$strSQL5);
	
	

}


if($product_id6 !==''  ){

$strSQL6 = "insert into hos__subchange
(ref_idd,count_stock,count_sale,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id."','".$count_stock6."','".$count_sale6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$product_id6."','".$product_id6."')";
$objQuery6 = mysqli_query($conn,$strSQL6);
	
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
	
if($company=='3'){
 $type_company='ฟาร์ ทริลเลี่ยน บจก.';
	}else if($company=='4'){
	$type_company='โนเบิล เมด บจก.';	
	}
	

 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
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

$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,province_name)

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$province_name."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());










	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_allwelltran_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


