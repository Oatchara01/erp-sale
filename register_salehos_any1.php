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
$que_ckk = $_POST["que_ckk"];
$delivery_contract = $_POST["delivery_contract"];
$book_clear = $_POST["book_clear"];
$book_no = $_POST["book_no"];
$brn_clear = $_POST["brn_clear"];
$brn_no = $_POST["brn_no"];
$brnp_clear = $_POST["brnp_clear"];
$mode_cus = $_POST["mode_name"];

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
$cm_no = $_POST["cm_no"];	
$date_send_key  = $_POST["between_date"];
$have_order = $_POST["have_order"];
$date_tranfer = $_POST["date_tranfer"];
$pre_name = $_POST["pre_name"];
$plan_ckk = $_POST["plan_ckk"];
	
$comment_cs = $_POST["comment_cs"];	
$comment_en = $_POST["comment_en"];	
$comment_st = $_POST["comment_st"];	
$comment_ad = $_POST["comment_ad"];	

	

$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
if($_SESSION['code']=='MK'){
$sale_code = "SM1";	
}else{
$sale_code = $_SESSION['code'];
}
$name =  $_SESSION['name'];
$em_id =  $_SESSION['emid'];


$pr_no  = $_POST["pr_no"];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$payment_des  = $_POST["payment_des"];
$iv_no = "IV";
	
	//move_uploaded_file($_FILES['slip1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip1']['name']));
	//move_uploaded_file($_FILES['slip2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip2']['name']));
	//move_uploaded_file($_FILES['slip3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip3']['name']));
	//move_uploaded_file($_FILES['slip4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip4']['name']));
	//move_uploaded_file($_FILES['slip5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip5']['name']));
	

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
	
	
	
if ($_FILES['slip1']['size'] == 0) {
$slip1 = "";
}else if ($_FILES['slip1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip1']['size'] != 0) {
$temp1 = explode(".", $_FILES["slip1"]["name"]);
$slip1 = "slip1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["slip1"]["tmp_name"], "upload/" . $slip1);
}	

	
	
if ($_FILES['slip2']['size'] == 0) {
$slip2 = "";
}else if ($_FILES['slip2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip2']['size'] != 0) {
$temp2 = explode(".", $_FILES["slip2"]["name"]);
$slip2 = "slip2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["slip2"]["tmp_name"], "upload/" . $slip2);
}	
	
	
if ($_FILES['slip3']['size'] == 0) {
$slip3 = "";
}else if ($_FILES['slip3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip3']['size'] != 0) {
$temp3 = explode(".", $_FILES["slip3"]["name"]);
$slip3 = "slip3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["slip3"]["tmp_name"], "upload/" . $slip3);
}	
	
	
if ($_FILES['slip4']['size'] == 0) {
$slip4 = "";
}else if ($_FILES['slip4']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip4']['size'] != 0) {
$temp4 = explode(".", $_FILES["slip4"]["name"]);
$slip4 = "slip4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["slip4"]["tmp_name"], "upload/" . $slip4);
}	
	
	
	
if ($_FILES['slip5']['size'] == 0) {
$slip5 = "";
}else if ($_FILES['slip5']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip5']['size'] != 0) {
$temp5 = explode(".", $_FILES["slip5"]["name"]);
$slip5 = "slip5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["slip5"]["tmp_name"], "upload/" . $slip5);
}	
		
	
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
	
$ic_ckk = $_POST["ic_ckk"];	



$save="insert into hos__so
(ref_id,type_doc,bill_name,bill_address,full_bill,date_so,suggest,payment,sale_comment,po_no,delivery_contract,book_clear,book_no,brn_clear,brn_no,brnp_clear,brnp_no,sn_ckk,sn_no,install_place,with_pr,type_type,type_detail,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,sale_date,sale,sale_code,pr_no,add_date,add_by,status_doc,bill_tel,payment_des,slip1,slip2,slip3,slip4,slip5,date_send_key,have_order,iv_no,tax_id,bill_id,date_tranfer,cm_no,pre_name,que_ckk,mode_cus,plan_ckk,ic_ckk)
values
('".$ref_id."','".$type_doc."','".$bill_name."','".$bill_address."','".$full_bill."','".$date_so."','".$suggest."','".$payment."','".$sale_comment."','".$po_no."','".$delivery_contract."','".$book_clear."','".$book_no."','".$brn_clear."','".$brn_no."','".$brnp_clear."','".$brnp_no."','".$sn_ckk."','".$sn_no."','".$install_place."','".$with_pr."','".$type_type."','".$type_detail."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$sale_date."','".$sale."','".$sale_code."','".$pr_no."','".$add_date."','".$add_by."','Request','".$bill_tel."','".$payment_des."','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','".$date_send_key."','".$have_order."','".$iv_no."','".$tax_id."','".$bill_id."','".$date_tranfer."','".$cm_no."','".$pre_name."','".$que_ckk."','".$mode_cus."','".$plan_ckk."','".$ic_ckk."')";

$qsave=mysqli_query($conn,$save);
	
$save57="insert into tb_comment_so (ref_id,comment_cs,comment_en,comment_st,comment_ad) values ('".$ref_id."','".$comment_cs."','".$comment_en."','".$comment_st."','".$comment_ad."')";
$qsave57=mysqli_query($conn,$save57);		
	
	
if($book_no !=''){
	
$strSQL = "SELECT ref_id FROM hos__jongproduct WHERE iv_no = '".$book_no."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
$remark_jong ="เปิดใบสั่งขายเลขที่อ้างอิง $ref_id";
	
$save2="UPDATE  hos__jongproduct SET close_jong='1',remark='".$remark_jong."'  where ref_id = '".$objResult["ref_id"]."'";
$qsave2=mysqli_query($conn,$save2);	
	
$save3="UPDATE hos__subjongpro SET close_ckk='1'  where ref_idd = '".$objResult["ref_id"]."'";
$qsave3=mysqli_query($conn,$save3);		

}
	
	
	
if($cm_no !=''){
if($type_doc=='3'){
$save19="UPDATE tb_service_order SET ref_so ='".$ref_id."' where service_order_no = '".$cm_no."'";
$qsave19=mysqli_query($service,$save19);	
}else if($type_doc=='4'){
$save19="UPDATE tb_service_order SET ref_so ='".$ref_id."' where service_order_no = '".$cm_no."'";
$qsave19=mysqli_query($servicenb,$save19);	
}
}
	
	
	
$save56="insert into tb_other_bill
(ref_id,head_1,ref_1,ref_2,ref_3,ref_4,ref_5,ref_6,ref_7,ref_8,ref_9,ref_10,ref_des,ref_11)
values
('".$ref_id."','".$head_1."','".$ref_1."','".$ref_2."','".$ref_3."','".$ref_4."','".$ref_5."','".$ref_6."','".$ref_7."','".$ref_8."','".$ref_9."','".$ref_10."','".$ref_des."','".$ref_11."')";
$qsave56=mysqli_query($conn,$save56);	
	
	
if($po_no !=''){	
$sql1 = "SELECT ref_id FROM hos__po where po_no ='".$po_no."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);	
	
	if($rs1["ref_id"]!=""){
		
$save="Update  hos__po set  open_so='1',open_sodate='".$add_date."',ref_so = '".$ref_id."',name_open='".$add_by."'    where  ref_id = '".$rs1["ref_id"]."'";
$qsave=mysqli_query($conn,$save);
	
		
	}
}

$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$warranty =$_POST["warranty"];
 $pm=$_POST["pm"];
 $cal=$_POST["cal"];
$sn = $_POST["sn"];
 $product_id = $_POST["product_id"];
 $discount_unit = $_POST["discount_unit"];
$clear_br = $_POST["clear_br"];
$clear_ivno = $_POST["clear_ivno"];

	
foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
		$clear_ivno_new = $clear_ivno[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
		$cal_new=$cal[$key];
	 	$sn_new=$sn[$key];
	   	$clear_br_new = $clear_br[$key];
        $product_id_new =$product_id[$key];
        $discount_unit1 =$discount_unit[$key];
		$discount_unit_new=str_replace(',','', $discount_unit1);
		$sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;
		 



$strSQL = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,clear_br,clear_ivno,sn)
values ('".$ref_id."','".$sale_count_new."','".$sale_count_new."','".$product_price_new."','".$product_price_new."','".$sum_amount_new."','".$sale_remarkk_new."','".$discount_unit_new."','".$warranty_new."','".$cal_new."','".$pm_new."','".$product_id_new."','".$product_id_new."','".$clear_br_new."','".$clear_ivno_new."','".$sn_new."')";

$objQuery = mysqli_query($conn,$strSQL);





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
$product_sn=$_POST["product_sn"];
$product_name=$_POST["product"];
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


$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,mk_research,province_name) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','โรงพยาบาล','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$mk_research."','".$province_name."')";

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());


$strSQL99 =  "insert into tb_transaction (ref_id,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$ref_id."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";

$objQuery99 = mysqli_query($conn,$strSQL99) or die(mysqli_error());


$customer_name1 = $_POST["customer_name1"];
$customer_tel1 = $_POST["customer_tel1"];
$address_name1 = $_POST["address_name1"];
	
$customer_name2 = $_POST["customer_name2"];
$customer_tel2 = $_POST["customer_tel2"];
$address_name2 = $_POST["address_name2"];

$customer_name3 = $_POST["customer_name3"];
$customer_tel3 = $_POST["customer_tel3"];
$address_name3 = $_POST["address_name3"];

$customer_name4 = $_POST["customer_name4"];
$customer_tel4 = $_POST["customer_tel4"];
$address_name4 = $_POST["address_name4"];
	
$customer_name5 = $_POST["customer_name5"];
$customer_tel5 = $_POST["customer_tel5"];
$address_name5 = $_POST["address_name5"];

$customer_name6 = $_POST["customer_name6"];
$customer_tel6 = $_POST["customer_tel6"];
$address_name6 = $_POST["address_name6"];

$customer_name7 = $_POST["customer_name7"];
$customer_tel7 = $_POST["customer_tel7"];
$address_name7 = $_POST["address_name7"];

$customer_name8 = $_POST["customer_name8"];
$customer_tel8 = $_POST["customer_tel8"];
$address_name8 = $_POST["address_name8"];

$customer_name9 = $_POST["customer_name9"];
$customer_tel9 = $_POST["customer_tel9"];
$address_name9 = $_POST["address_name9"];
	

if($customer_name1!=''){

$strSQL15 =  "insert into tb_delivery_print (ref_id,customer_name1,customer_tel1,address_name1,customer_name2,customer_tel2,address_name2,customer_name3,customer_tel3,address_name3,customer_name4,customer_tel4,address_name4,customer_name5,customer_tel5,address_name5,customer_name6,customer_tel6,address_name6,customer_name7,customer_tel7,address_name7,customer_name8,customer_tel8,address_name8,customer_name9,customer_tel9,address_name9) 

values('".$ref_id."','".$customer_name1."','".$customer_tel1."','".$address_name1."','".$customer_name2."','".$customer_tel2."','".$address_name2."','".$customer_name3."','".$customer_tel3."','".$address_name3."','".$customer_name4."','".$customer_tel4."','".$address_name4."','".$customer_name5."','".$customer_tel5."','".$address_name5."','".$customer_name6."','".$customer_tel6."','".$address_name6."','".$customer_name7."','".$customer_tel7."','".$address_name7."','".$customer_name8."','".$customer_tel8."','".$address_name8."','".$customer_name9."','".$customer_tel9."','".$address_name9."')";

$objQuery15 = mysqli_query($conn,$strSQL15) or die(mysqli_error());

}

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_salehos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


