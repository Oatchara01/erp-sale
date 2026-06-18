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
$end_promis = $_POST["end_promis"];
$des_sale = $_POST["des_sale"];
$bill_vat = $_POST["bill_vat"];	
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
$unit = "month";	
$wdff = "$count_m $unit";	
$end_promis = date("Y-m-d", strtotime($wdff, strtotime($start_promis)));	
$delivery_date = $_POST["start_date"];
$delivery_key = $_POST["between_date"];	
$delivery_type = $_POST["delivery_type"];	

$sale_code = $_POST['sale_code'];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
$ref_id = $_POST["ref_id"];
	

$bank_name = $_POST["bank_name"];
$accbank_name = $_POST["accbank_name"];	
$bank_no = $_POST["bank_no"];	
	
if ($_FILES['bank_img']['size'] != 0) {
$temp = explode(".", $_FILES["bank_img"]["name"]);
$bank_img = "bank_img" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp);
move_uploaded_file($_FILES["bank_img"]["tmp_name"], "credit_no/" . $bank_img);
}else{
$bank_img = $_POST["bank_img"];		
}




$save="UPDATE hos__rental SET rental_name='".$rental_name."',connect_name='".$connect_name."',start_promis='".$start_promis."',install_date='".$install_date."',rental_address='".$rental_address."',rental_id='".$rental_id."',rental_tel='".$rental_tel."',connect_tel='".$connect_tel."',end_promis='".$end_promis."',des_sale='".$des_sale."',install_address='".$install_address."',bill_name='".$bill_name."',bill_tel='".$bill_tel."',bill_address='".$bill_address."',tax_no='".$tax_no."',payment='".$payment."',patient_name='".$patient_name."',emergency_name='".$emergency_name."',emergency_tel='".$emergency_tel."',count_m='".$count_m."',bill_vat='".$bill_vat."',delivery_type='".$delivery_type."',delivery_date='".$delivery_date."',delivery_key='".$delivery_key."',bank_img='".$bank_img."',bank_name='".$bank_name."',accbank_name='".$accbank_name."',bank_no='".$bank_no."'  where ref_id='".$ref_id."' ";

$qsave=mysqli_query($conn,$save);

$save1 = "UPDATE hos__rental_runiv SET date_runiv = '".$start_promis."') where ref_idren = '".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);		
	

$id = $_POST["id_sub"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$product_id = $_POST["product_id"];
$sn_number = $_POST["sn_number"];	
$warranty = $_POST["warranty"];

$strSQL21 = "SELECT * FROM hos__subrental WHERE ref_idd = '".$ref_id."' ";

$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
	$sale_remarkk_new=$sale_remarkk[$key];
	$sn_number_new = $sn_number[$key];
	$sale_count_new = $sale_count[$key];
	$product_price1 = $product_price[$key];
	$warranty_new = $warranty[$key];
	$product_price_new = str_replace(',','', $product_price1);
	$sum_amount_new = $product_price_new*$sale_count_new;	  


$strSQL = "Update   hos__subrental set count='".$sale_count_new."',price='".$product_price_new."',amount='".$sum_amount_new."',remark_sale='".$sale_remarkk_new."',sn_number='".$sn_number_new."',warranty='".$warranty_new."'  Where id_sub = '$id_new' ";

$objQuery = mysqli_query($conn,$strSQL);
	  
	  
	  
}
	
}




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

	
$warranty6 = $_POST["warranty6"];
$warranty7 = $_POST["warranty7"];
$warranty8 = $_POST["warranty8"];
$warranty9 = $_POST["warranty9"];
$warranty10 = $_POST["warranty10"];
			


if($product_id6 !=''){

$strSQL6 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$sn_number6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$warranty6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id6."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id6."' ";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}

if($product_id7 !=''){

$strSQL7 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$sn_number7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$warranty7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id7."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id7."' ";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}

if($product_id8 !=''){

$strSQL8 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$sn_number8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$warranty8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id8."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id8."' ";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}

if($product_id9 !=''){

$strSQL9 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sn_number9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$warranty9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id9."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id9."' ";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}

if($product_id10 !=''){

$strSQL10 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sn_number10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$warranty10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id10."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id10."' ";
$objQuery92 = mysqli_query($new,$strSQL92);	
	
}
 $start_date =$_POST["start_date"];
 $between_date =$_POST["between_date"];
 $start_time=$_POST["start_time"];
 $end_time=$_POST["end_time"];
 $status=$_POST["status"];
	
 	
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
	$address_1=$_POST["address_1"];
$customer_contact =$_POST["customer_contact"];
$on_time = $_POST["on_time"];
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product=$_POST["product"];
$product_name = "$product $product_name6 $sale_count6 $unit_name6 $product_name7 $sale_count7 $unit_name7 $product_name8 $sale_count8 $unit_name8 $product_name9 $sale_count9 $unit_name9 $product_name10 $sale_count10 $unit_name10";
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
$mk_research =$_POST["mk_research"];
	
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

	
$strSQL66 =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$address_name."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',address_1= '".$address_1."',mk_research='".$mk_research."',province_name='".$province_name."'  where ref_id = '".$ref_id."'";

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());

	
$strSQL33 =  "Update tb_transaction set runway='".$runway."',road='".$road."',soy='".$soy."',soy_long='".$soy_long."',soy_big='".$soy_big."',car_load='".$car_load."',car_park='".$car_park."',car_road='".$car_road."',no_car_road='".$no_car_road."',car_home='".$car_home."',door_long='".$door_long."',slope='".$slope."',bundai='".$bundai."',unit_bundai='".$unit_bundai."',door_big='".$door_big."',door_longer='".$door_longer."',type_door='".$type_door."',home_type='".$home_type."',install='".$install."',bundai_install='".$bundai_install."',bundai_big='".$bundai_big."',lip='".$lip."',lip_big='".$lip_big."',lip_long='".$lip_long."',lip_weight='".$lip_weight."',want_employee='".$want_employee."',employee_unit='".$employee_unit."',ferniger_name='".$ferniger_name."',ferniger_address='".$ferniger_address."',want_ex='".$want_ex."',want_credit='".$want_credit."',want_prem='".$want_prem."',add_date='$add_date',add_by='".$add_by."',room_bigger='".$room_bigger."',room_longer='".$room_longer."',bundai_hug='".$bundai_hug."',bank='".$bank."',description='".$description_ja."',type_bundai='".$type_bundai."',head_bad='".$head_bad."',height_ltd='".$height_ltd."',up='".$up."',no_up='".$no_up."'   where ref_id = '".$ref_id."' ";

$objQuery33 = mysqli_query($conn,$strSQL33) or die(mysqli_error());
	
$send_cs = $_POST["send_cs"];
	
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
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suprental_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


