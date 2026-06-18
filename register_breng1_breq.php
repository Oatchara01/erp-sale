<?php 
include("dbconnect.php");
include ("error_page.php");

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id_stock = $_POST["ref_id_stock"];
$company = $_POST["company"];
$date_br = $_POST["date_br"];
$po_no = $_POST["po_no"];
$customer = $_POST["customer"];
$customer_id = $_POST["customer_id"];
$address = $_POST["address"];
$sale_comment = $_POST["sale_comment"];
$sn_ckk = $_POST["sn_ckk"];
$sn = $_POST["sn"];
$cm_no = $_POST["cm_no"];
$objective = $_POST["objective"];
$objective_des1 = $_POST["objective_des1"];
$objective_des2 = $_POST["objective_des2"];
$objective_des4 = $_POST["objective_des4"];
$objective_des5 = $_POST["objective_des5"];
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
$iv_no = "";
$que_ckk = $_POST["que_ckk"];
$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
$sale_code = $_SESSION['code'];
$name =  $_SESSION['name'];
$em_id =  $_SESSION['emid'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id_br) AS MAXID FROM in__br ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -5);
$maxId3 = substr($rs['MAXID'],-9);
$maxId1 = substr($maxId3,0,-5);
$so = "BQ";
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
$so = "BQ";
$ref_id_br ="$so$nextId";	
	
if ($_FILES['slip1']['size'] == 0) {
$slip1 = "";
}else if ($_FILES['slip1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip1']['size'] != 0) {
$temp1 = explode(".", $_FILES["slip1"]["name"]);
$slip1 = "slip1" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["slip1"]["tmp_name"], "upload/" . $slip1);
}	
	
if ($_FILES['slip2']['size'] == 0) {
$slip2 = "";
}else if ($_FILES['slip2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip2']['size'] != 0) {
$temp2 = explode(".", $_FILES["slip2"]["name"]);
$slip2 = "slip2" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["slip2"]["tmp_name"], "upload/" . $slip2);
}	
	
if ($_FILES['slip3']['size'] == 0) {
$slip3 = "";
}else if ($_FILES['slip3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip3']['size'] != 0) {
$temp3 = explode(".", $_FILES["slip3"]["name"]);
$slip3 = "slip3" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["slip3"]["tmp_name"], "upload/" . $slip3);
}	
	
if ($_FILES['slip4']['size'] == 0) {
$slip4 = "";
}else if ($_FILES['slip4']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip4']['size'] != 0) {
$temp4 = explode(".", $_FILES["slip4"]["name"]);
$slip4 = "slip4" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["slip4"]["tmp_name"], "upload/" . $slip4);
}	
	
if ($_FILES['slip5']['size'] == 0) {
$slip5 = "";
}else if ($_FILES['slip5']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip5']['size'] != 0) {
$temp5 = explode(".", $_FILES["slip5"]["name"]);
$slip5 = "slip5" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp5);
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
$type_breng = $_POST["type_breng"]; 

$save="insert into in__br(company,ref_id_br,ref_id_stock,po_no,date_br,customer,customer_id,address,sale_comment,sale,sale_code,sn_ckk,sn,objective,objective_des1,objective_des2,objective_des4,objective_des5,returns,returns_date,returns_time,returns_name,returns_address,returns_contact,status_doc,delivery_name,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,date_send_key,sale_date,add_date,add_by,return_date_bet,slip1,slip2,slip3,slip4,slip5,iv_no,que_ckk,cm_no,type_breng)
values('".$company."','".$ref_id_br."','".$ref_id_stock."','".$po_no."','".$date_br."','".$customer."','".$customer_id."','".$address."','".$sale_comment."','".$sale."','".$sale_code."','".$sn_ckk."','".$sn."','".$objective."','".$objective_des1."','".$objective_des2."','".$objective_des4."','".$objective_des5."','".$returns."','".$returns_date."','".$returns_time."','".$returns_name."','".$returns_address."','".$returns_contact."','".$status_doc."','".$delivery_name."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$date_send_key."','".$sale_date."','".$add_date."','".$add_by."','".$return_date_bet."','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','".$iv_no."','".$que_ckk."','".$cm_no."','".$type_breng."')";
$qsave=mysqli_query($conn,$save);
// echo $save.'<br>';

$save56="insert into tb_other_bill(ref_id,head_1,ref_1,ref_2,ref_3,ref_4,ref_5,ref_6,ref_7,ref_8,ref_9,ref_10,ref_11,ref_des)
values('".$ref_id_br."','".$head_1."','".$ref_1."','".$ref_2."','".$ref_3."','".$ref_4."','".$ref_5."','".$ref_6."','".$ref_7."','".$ref_8."','".$ref_9."','".$ref_10."','".$ref_11."','".$ref_des."')";
$qsave56=mysqli_query($conn,$save56);
// echo $save56.'<br>';

$check_in = $_POST["check_in"]; // checkbox
$key_id = $_POST["key"]; // key
$product_code = $_POST["product_codet"]; // รหัสสินค้า	
$product_id = $_POST["product_id"]; // ID สินค้า
$product_name = $_POST["product_name"]; // ชื่อสินค้า
$unit_name = $_POST["unit_name"]; // หนว่ย
$sale_count = $_POST["sale_count"]; // จำนวนที่ต้องการยืม
$product_price = $_POST["product_price"]; // ราคาต่อหน่วย
$sum_amount = $_POST["sum_amount"]; // ยอดรวม
$sum_amountt = str_replace(',', '', $sum_amount);
$br_period = $_POST["br_period"]; // รับประกัน
$warranty = $_POST["warranty"]; // ระยะเวลายืม	
$sale_remarkk = $_POST["sale_remarkk"]; // หมายเหตุ

foreach ($key_id as $key => $value) {
$check_in_new = $check_in[$key];
$key_id_new = $key_id[$key];
$product_code_new = $product_code[$key];
$product_id_new = $product_id[$key];
$product_name_new = $product_name[$key];
$unit_name_new = $unit_name[$key];
$sale_count_new = $sale_count[$key];
$product_price_new = $product_price[$key];
$sum_amountt_new = $sum_amountt[$key];
$br_period_new = $br_period[$key];
$warranty_new = $warranty[$key];
$sale_remarkk_new = $sale_remarkk[$key];
$ref_id_stock_new = $ref_id_stock[$key];

// echo $check_in_new;
//  echo $check_in_new.'<br>';
//  echo $product_id_new.'<br>';

	if($product_id_new != '' AND $check_in_new == '1' and $sale_count_new > 0){
		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code_new."' ";
		$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);


		if ($check_in_new == 1) {
			$strSQL1 = "insert into in__subbr(ref_idd_br,po_no,product_id,product_code,count,amount,price,sale_remark,br_periodd,warranty)
			values ('".$ref_id_br."','".$po_no."','".$product_id_new."','".$product_id_new."','".$sale_count_new."','".$product_price_new."','".$sum_amountt_new."','".$sale_remarkk_new."','".$br_period_new."','".$warranty_new."')";
			$objQuery1 = mysqli_query($conn,$strSQL1);	
			// echo $strSQL1.'<br>';
		}

		$sql = "SELECT have_sn FROM tb_product where product_ID ='".$product_id_new."' ";
		$qry = mysqli_query($conn,$sql);
		$rs = mysqli_fetch_assoc($qry);
	
		if($rs["have_sn"] == '1'){
			$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id_new."' ";
			$objQuery91 = mysqli_query($conn,$strSQL91);
			// echo $strSQL91.'<br>';
			
		}

	}

}
// exit;
// ------------------------

	$start_date =$_POST["start_date"];
	$between_date =$_POST["between_date"];
	$start_time=$_POST["start_time"];
	$end_time=$_POST["end_time"];
	$status=$_POST["status"];
	
 if ($_POST["start_date"]!=''){
		$start_date = date('Y-m-d');
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
	
if($company=='3') {
	$type_company='ออลล์เวล ไลฟ์ บจก.';
} else if ($company=='4') {
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
//$product_name =$_POST["product_name"];	
	
$product_name = "ส่ง $product_name1 $sale_remarkk1  $sale_count1 $unit_name1 $product_name2 $sale_remarkk2 $sale_count2 $unit_name2 $product_name3 $sale_remarkk3 $sale_count3 $unit_name3 $product_name4 $sale_remarkk4 $sale_count4 $unit_name4  $product_name5 $sale_remarkk5 $sale_count5 $unit_name5  $product_name6 $sale_remarkk6 $sale_count6 $unit_name6 $product_name7 $sale_remarkk7 $sale_count7 $unit_name7 $product_name8 $sale_remarkk8 $sale_count8 $unit_name8 $product_name9 $sale_remarkk9 $sale_count9 $unit_name9 $product_name10 $sale_remarkk10 $sale_count10 $unit_name10 $address_name";
	
$product_sn=$_POST["product_sn"];
$unit_credit=$_POST["unit_credit"];
$price=$_POST["unit_cash"];
$employee_name=$_POST["employee_name"];
$employee_tel=$_POST["employee_tel"];
$add_by=$_POST["add_by"];
$description=$_POST["sale_comment"];
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
values('".$ref_id_br."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$province_name."')";
$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());
// echo $strSQL66.'<br>';
// echo $save.'<br>';
// echo $save56.'<br>';
// echo $strSQL1.'<br>';
// exit;
	
	echo "<script language=\"JavaScript\">";
	// echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_breng_brgq.php';";
	echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_breng_edit_breq.php?ref_id_br=$ref_id_br';";
	echo "</script>";

}