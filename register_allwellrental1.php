<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_doc = $_POST["type_doc"];
$register_date = $_POST["register_date"];
$rental_name = $_POST["rental_name"];
$connect_name = $_POST["connect_name"];
$start_promis = $_POST["start_promis"];
$install_date = $_POST["install_date"];
$rental_address = $_POST["rental_address"];
$rental_id = $_POST["rental_id"];
$rental_tel = $_POST["rental_tel"];
$connect_tel = $_POST["connect_tel"];
$bill_vat = $_POST["bill_vat"];
$des_sale = $_POST["des_sale"];
$install_address = $_POST["install_address"];	
$bill_name = $_POST["bill_name"];	
$bill_tel = $_POST["bill_tel"];	
$bill_address = $_POST["bill_address"];	
$tax_no = $_POST["tax_no"];	
$payment = $_POST["payment"];	
$patient_name = $_POST["patient_name"];	
$emergency_name = $_POST["emergency_name"];	
$emergency_tel = $_POST["emergency_tel"];
$count_m = $_POST["count_m"];	
$type_product = $_POST["type_product"];	
$unit = "month";	
$wdff = "$count_m $unit";	
$end_promis = date("Y-m-d", strtotime($wdff, strtotime($start_promis)));
$area = "SS3";
$delivery_date = $_POST["start_date"];
$delivery_key = $_POST["between_date"];	
$delivery_type = $_POST["delivery_type"];	
//$end_promis = $_POST["end_promis"];
	
$bank_name = $_POST["bank_name"];
$accbank_name = $_POST["accbank_name"];	
$bank_no = $_POST["bank_no"];	
	
if ($_FILES['bank_img']['size'] == 0) {
$bank_img = "";
}else if ($_FILES['bank_img']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['bank_img']['size'] != 0) {
$temp = explode(".", $_FILES["bank_img"]["name"]);
$bank_img = "bank_img" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp);
move_uploaded_file($_FILES["bank_img"]["tmp_name"], "credit_no/" . $bank_img);
}	
	
	
	
	
$sale_code = $_POST['sale_code'];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__rental";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);


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


$so = "RT";
$ref_id ="$so$nextId";	




$save="insert into hos__rental
(ref_id,type_doc,register_date,rental_name,connect_name,start_promis,install_date,rental_address,rental_id,rental_tel,connect_tel,end_promis,des_sale,sale_code,add_date,add_by,install_address,bill_name,bill_tel,bill_address,tax_no,payment,patient_name,emergency_name,emergency_tel,count_m,unit_m,bill_vat,ckk_allwell,area,delivery_type,delivery_date,delivery_key,bank_name,accbank_name,bank_no,bank_img,type_product)
values
('".$ref_id."','".$type_doc."','".$register_date."','".$rental_name."','".$connect_name."','".$start_promis."','".$install_date."','".$rental_address."','".$rental_id."','".$rental_tel."','".$connect_tel."','".$end_promis."','".$des_sale."','".$sale_code."','".$add_date."','".$add_by."','".$install_address."','".$bill_name."','".$bill_tel."','".$bill_address."','".$tax_no."','".$payment."','".$patient_name."','".$emergency_name."','".$emergency_tel."','".$count_m."','".$unit."','".$bill_vat."','1','".$area."','".$delivery_type."','".$delivery_date."','".$delivery_key."','".$bank_name."','".$accbank_name."','".$bank_no."','".$bank_img."','".$type_product."')";

$qsave=mysqli_query($conn,$save);

$save1 = "insert into hos__rental_runiv (ref_idren,date_runiv,sale_area,area) values ('".$ref_id."','".$end_promis."','".$sale_code."','".$area."')";
$qsave1=mysqli_query($conn,$save1);	

$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt1 = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt1);
$sn_number1 = $_POST["sn_number1"];
	
$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$sn_number2 = $_POST["sn_number2"];

$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$sn_number3 = $_POST["sn_number3"];

$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$sn_number4 = $_POST["sn_number4"];

$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$sn_number5 = $_POST["sn_number5"];

$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$sn_number6 = $_POST["sn_number6"];

$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$sn_number7 = $_POST["sn_number7"];

$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$sn_number8 = $_POST["sn_number8"];

$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$sn_number9 = $_POST["sn_number9"];

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10 = str_replace(',','', $sum_amountt10);
$sn_number10 = $_POST["sn_number10"];
	
$warranty1 = $_POST["warranty1"];	
$warranty2 = $_POST["warranty2"];	
$warranty3 = $_POST["warranty3"];	
$warranty4 = $_POST["warranty4"];	
$warranty5 = $_POST["warranty5"];	
$warranty6 = $_POST["warranty6"];	
$warranty7 = $_POST["warranty7"];	
$warranty8 = $_POST["warranty8"];	
$warranty9 = $_POST["warranty9"];	
$warranty10 = $_POST["warranty10"];	


if($product_id1 !=''){

$strSQL1 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id1."','".$product_id1."','".$sale_count1."','".$sn_number1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id1."'  and product_type !='อื่นๆ'";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id1."'   and product_type !='อื่นๆ'";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
	
}


if($product_id2 !=''){

$strSQL2 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id2."','".$product_id2."','".$sale_count2."','".$sn_number2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$warranty2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id2."'   and product_type !='อื่นๆ'";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id2."'   and product_type !='อื่นๆ'";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}

if($product_id3 !=''){

$strSQL3 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id3."','".$product_id3."','".$sale_count3."','".$sn_number3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$warranty3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id3."'  and product_type !='อื่นๆ'";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id3."'  and product_type !='อื่นๆ'";
$objQuery92 = mysqli_query($new,$strSQL92);	
}

if($product_id4 !=''){

$strSQL4 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id4."','".$product_id4."','".$sale_count4."','".$sn_number4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$warranty4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id4."'  and product_type !='อื่นๆ'";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id4."'  and product_type !='อื่นๆ'";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
	
}

if($product_id5 !=''){

$strSQL5 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id5."','".$product_id5."','".$sale_count5."','".$sn_number5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$warranty5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);	

	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id5."'  and product_type !='อื่นๆ'";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id5."'  and product_type !='อื่นๆ'";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
	
}

if($product_id6 !=''){

$strSQL6 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$sn_number6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$warranty6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id6."'  and product_type !='อื่นๆ'";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id6."' and product_type !='อื่นๆ' ";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}

if($product_id7 !=''){

$strSQL7 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$sn_number7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$warranty7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id7."'  and product_type !='อื่นๆ'";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id7."'  and product_type !='อื่นๆ'";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}

if($product_id8 !=''){

$strSQL8 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$sn_number8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$warranty8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id8."'  and product_type !='อื่นๆ'";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id8."'  and product_type !='อื่นๆ'";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}

if($product_id9 !=''){

$strSQL9 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sn_number9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$warranty9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id9."'  and product_type !='อื่นๆ'";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id9."'  and product_type !='อื่นๆ'";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}

if($product_id10 !=''){

$strSQL10 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sn_number10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$warranty10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id10."'  and product_type !='อื่นๆ'";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id10."'  and product_type !='อื่นๆ'";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}

	
//รันเลขที่เอกสาร
$doc_date = $_POST["register_date"];	
$date = explode('-' , $doc_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
	
if($type_doc =='3'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_doc_rental where head_no='JN' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "JN";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_doc_rental (head_no,doc_no,year_no,month_no,run_iv,ref_id,doc_date) values ('JN','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."','".$doc_date."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($type_doc =='4'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_doc_rental where head_no='JN/' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "JN/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_doc_rental (head_no,doc_no,year_no,month_no,run_iv,ref_id,doc_date) values ('JN/','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."','".$doc_date."')";
$qsave5=mysqli_query($conn,$save5);


	}	
	
$promis_date = $start_promis;	
$date = explode('-' , $start_promis );	
$year = $date[0];
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_promisno where month_no ='".$mont."' and year_no = '".$year1."'";
			
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "ธส.";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -3);
$nextId = $maxId2;


$promis_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_promisno (promis_n,year_no,month_no,run_no,date_save,ref_id) values ('".$promis_no."','".$year1."','".$mont."','".$nextId."','".$date_save."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);	
	
	
	
$save="Update  hos__rental set iv_no='".$doc_no."',iv_date='".$doc_date."',promis_date='".$promis_date."',promis_no='".$promis_no."'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($conn,$save);
	
	
	
	
	
//จัดส่ง	

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
 
	
$province_name =$_POST["province_name"];
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
$product_sn="เลขที่เอกสาร $doc_no เลขที่สัญญา $promis_no";
	
$product_name1 = $_POST["product_name1"];	
$product_name2 = $_POST["product_name2"];	
$product_name3 = $_POST["product_name3"];	
$product_name4 = $_POST["product_name4"];	
$product_name5 = $_POST["product_name5"];	
$product_name6 = $_POST["product_name6"];	
$product_name7 = $_POST["product_name7"];	
	
	
 $product_name = "ส่ง $product_name1 $sale_remarkk1 $sale_count1 $unit_name1 $product_name2 $sale_remarkk2 $sale_count2 $unit_name2 $product_name3 $sale_remarkk3 $sale_count3 $unit_name3 $product_name4 $sale_remarkk4 $sale_count4 $unit_name4  $product_name5 $sale_remarkk5 $sale_count5 $unit_name5  $product_name6 $sale_remarkk6 $sale_count6 $unit_name6 $product_name7 $sale_remarkk7 $sale_count7 $unit_name7 $address_name";	


 $employee_name=$_POST["employee_name"];
 $employee_tel=$_POST["employee_tel"];
 $add_by=$_POST["add_by"];
 $description=$_POST["sale_comment"];
 $havemap=$_POST['have_map'];
$department_show = $_POST["department_show"];
	
$dept =$_POST["dept"];
$status_comment =$_POST["status_comment"];
	
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
		 $check_detail=$_POST["more"];
	}else{
		$check_detail='0';
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
$send_cs = $_POST["send_cs"];	
	
	
$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,mk_research,province_name) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','ลูกค้าทั่วไป','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$mk_research."','".$province_name."')";

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());
	
$strSQL99 =  "insert into tb_transaction (ref_id,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$ref_id."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";

$objQuery99 = mysqli_query($conn,$strSQL99) or die(mysqli_error());
	
	
if($send_cs =='1'){
		
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

$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,ref_id,iv_date) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$ref_id."','".$doc_release_date."')";


 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());


 
 $strSQL90 =  "insert into tb_transaction (running,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$nextId."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";

$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update hos__rental set job_no='".$nextId."',send_cs ='2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
	}



 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_allwellrental_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


