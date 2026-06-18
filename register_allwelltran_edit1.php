
<?php
include("dbconnect.php");
include ("error_page.php"); 
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = trim($_POST["ref_id"]);
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
$returns_contact = $_POST["return_contact"];
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
$sale_code = $_POST["sale_code"];

$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
$name =  $_SESSION['name'];

//echo $sale_code;
//exit();

$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";



$id = $_POST["id"];
$count_stock = $_POST["count_stock"];
$count_sale = $_POST["count_sale"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$product_id = $_POST["product_id"];

if($_FILES['slip1']['name']!=''){
 move_uploaded_file($_FILES['slip1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip1']['name']));
 $slip1=$_FILES['slip1']['name'];
}else{
 $slip1 = $_POST["slip1"];

}

if($_FILES['slip2']['name']!=''){
 move_uploaded_file($_FILES['slip2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip2']['name']));
 $slip2=$_FILES['slip2']['name'];
}else{
 $slip2 = $_POST["slip2"];

}

if($_FILES['slip3']['name']!=''){
 move_uploaded_file($_FILES['slip3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip3']['name']));
 $slip3=$_FILES['slip3']['name'];
}else{
 $slip3 = $_POST["slip3"];

}

if($_FILES['slip4']['name']!=''){
 move_uploaded_file($_FILES['slip4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip4']['name']));
 $slip4 =$_FILES['slip4']['name'];
}else{
 $slip4 = $_POST["slip4"];

}

if($_FILES['slip5']['name']!=''){
 move_uploaded_file($_FILES['slip5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip5']['name']));
 $slip5=$_FILES['slip5']['name'];
}else{
 $slip5 = $_POST["slip5"];

}





$save="Update   hos__change set date_change='".$date_change."',customer='".$customer."',customer_id='".$customer_id."',address='".$address."',sale_comment='".$sale_comment."',sn_ckk='".$sn_ckk."',sn='".$sn."',objective='".$objective."',objective_des='".$objective_des."',returns='".$returns."',returns_date='".$returns_date."',returns_time='".$returns_time."',returns_name='".$returns_name."',returns_address='".$returns_address."',returns_contact='".$returns_contact."',status_doc='".$status_doc."',delivery_name='".$delivery_name."',delivery_type='".$delivery_type."',delivery_date='".$delivery_date."',delivery_time='".$delivery_time."',delivery_address='".$delivery_address."',delivery_contact='".$delivery_contact."',delivery_tel='".$delivery_tel."',date_send_key = '".$date_send_key."',return_date_bet='".$return_date_bet."',slip1 = '".$slip1."',slip2 = '".$slip2."',slip3 = '".$slip3."',slip4 = '".$slip4."',slip5 = '".$slip5."',sale_code = '".$sale_code."'  where ref_id ='".$ref_id."'";


$qsave=mysqli_query($conn,$save);



$strSQL21 = "SELECT * FROM hos__subchange WHERE ref_idd = '".$ref_id."' ";
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
		$sale_remarkk_new=$sale_remarkk[$key];
        $product_id_new =$product_id[$key];
		$count_stock_new=$count_stock[$key];
		$count_sale_new=$count_sale[$key];
		if($count_sale_new !='0.00'){
		$sum_amount_new = $product_price_new *$count_sale_new;
		}else{
		$sum_amount_new = $product_price_new *$count_stock_new;

		}


$strSQL = "Update   hos__subchange set count_sale='$count_sale_new',count_stock='$count_stock_new',price='$product_price_new',amount='$sum_amount_new',sale_remark='$sale_remarkk_new',product_id='$product_id_new',product_code ='$product_id_new'   Where id= '$id_new' ";

//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL);
}
	
}
//exit();

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
	
	

$strSQL66 =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$address_name."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',address_1 = '".$address_1."',province_name='".$province_name."'  where ref_id = '".$ref_id."'";



$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());







 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_allwelltran_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}

