<?php
// เปิด output buffering ตั้งแต่ก่อน include head.php (ซึ่งส่ง HTML ออกทันที)
// เพื่อให้เรียก header('Location: ...') ได้จริงตอนบันทึกสำเร็จ (true POST-Redirect-GET)
// กัน "Confirm Form Resubmission" เมื่อผู้ใช้กด reload ค้างอยู่ที่หน้า response ของ POST
// (pattern เดียวกับ register_supchange1.php)
ob_start();
include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php");

date_default_timezone_set("Asia/Bangkok");

if (!function_exists('rt_abort_with_alert')) {
	function rt_abort_with_alert($message)
	{
		if (ob_get_level() > 0) {
			ob_end_clean();
		}
		$safeMessage = str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", " ", " "), $message);
		echo "<script>alert('" . $safeMessage . "');history.back();</script>";
		exit();
	}
}

// เดิมเขียน $_POST["submit"] = "submit" (assignment) ทำให้เงื่อนไขเป็นจริงเสมอ
// (บั๊กเดียวกับที่เคยเจอและแก้ใน register_supchange1.php)
if (isset($_POST["submit"]) && $_POST["submit"] === "submit") {

// ตรวจฟิลด์บังคับฝั่ง server ให้ตรงกับ rtRequiredFields ใน register_suprental.php:fncSubmit()
// กันกรณี submit ตรงมาที่ไฟล์นี้โดยข้าม validation ฝั่ง JS
$rtRequiredFields = [
	'start_promis' => 'กรุณาระบุวันเริ่มสัญญา',
	'count_m' => 'กรุณาระบุระยะเวลาเช่า',
	'rental_name' => 'กรุณาใส่ชื่อผู้เช่า',
	'rental_tel' => 'กรุณาใส่เบอร์โทรศัพท์ผู้เช่า',
	'rental_addr_detail' => 'กรุณาใส่ที่อยู่ผู้เช่า',
	'rental_province' => 'กรุณาเลือกจังหวัดผู้เช่า',
	'rental_district' => 'กรุณาเลือกเขต/อำเภอผู้เช่า',
	'rental_zipcode' => 'กรุณาใส่รหัสไปรษณีย์ผู้เช่า',
	'customer_name' => 'กรุณาใส่ชื่อผู้ติดต่อ',
	'customer_tel' => 'กรุณาใส่เบอร์โทรศัพท์ผู้ติดต่อ',
	'province_name' => 'กรุณาเลือกจังหวัดที่ต้องการจัดส่ง',
	'address_send' => 'กรุณาใส่สถานที่ติดตั้งเครื่อง',
	'bank_name' => 'กรุณาเลือกวิธีชำระเงินคืน',
	'bank_no' => 'กรุณาใส่เบอร์โทรศัพท์/เลขที่บัญชี',
	'accbank_name' => 'กรุณาใส่ชื่อบัญชี',
];
foreach ($rtRequiredFields as $rtFieldName => $rtFieldMessage) {
	if (trim((string)($_POST[$rtFieldName] ?? '')) === '') {
		rt_abort_with_alert($rtFieldMessage);
	}
}

$send_cs = $_POST["send_cs"] ?? '';
$type_doc = $_POST["type_doc"];
$register_date = $_POST["register_date"];
$rental_name = mysqli_real_escape_string($conn, $_POST["rental_name"]);
// connect_name/connect_tel ไม่มี input แยกสำหรับ hos__rental ในฟอร์มใหม่ ใช้ผู้ติดต่อจัดส่ง
// (customer_name/customer_tel ในแท็บที่อยู่จัดส่ง) แทน ใกล้เคียงความหมายที่สุด
$connect_name = mysqli_real_escape_string($conn, $_POST["customer_name"] ?? '');
$start_promis = $_POST["start_promis"];
$install_date = $_POST["install_date"] ?? '';
$rental_address = mysqli_real_escape_string($conn, $_POST["rental_address"]);
$rental_id = $_POST["rental_id"];
$rental_tel = mysqli_real_escape_string($conn, $_POST["rental_tel"]);
$connect_tel = mysqli_real_escape_string($conn, $_POST["customer_tel"] ?? '');
$bill_vat = $_POST["bill_vat"] ?? '';
$des_sale = mysqli_real_escape_string($conn, $_POST["des_sale"]);
// install_address ไม่มี input แยก ใช้สถานที่ติดตั้งเครื่อง (address_send) ที่ความหมายตรงกัน
$install_address = mysqli_real_escape_string($conn, $_POST["address_send"] ?? '');
// bill_name/bill_tel/bill_address ไม่มีช่อง "ชื่อออกบิล" แยกในฟอร์มใหม่ ใช้ข้อมูลผู้เช่าแทน
$bill_name = $rental_name;
$bill_tel = $rental_tel;
$bill_address = $rental_address;
$tax_no = mysqli_real_escape_string($conn, $_POST["tax_no"] ?? '');
$payment = $_POST["payment"];
$patient_name = mysqli_real_escape_string($conn, $_POST["patient_name"] ?? '');
$emergency_name = mysqli_real_escape_string($conn, $_POST["emergency_name"] ?? '');
$emergency_tel = mysqli_real_escape_string($conn, $_POST["emergency_tel"] ?? '');
$count_m = $_POST["count_m"];	
$unit = "month";	
$wdff = "$count_m $unit";	
$end_promis = date("Y-m-d", strtotime($wdff, strtotime($start_promis)));
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$delivery_key = $_POST["between_date"];
$sale_code = $_POST['sale_code'];

$type_product_map = ['สินค้าเตียง' => 1, 'สินค้าที่นอน' => 2, 'สินค้าอื่นๆ' => 3];
$type_product = $type_product_map[$_POST['product_type_rental'] ?? ''] ?? 0;
$des_productunit = mysqli_real_escape_string($conn, $_POST['rental_item_name'] ?? '');
$have_order = isset($_POST['have_order']) ? 1 : 0;

$iv_no = mysqli_real_escape_string($conn, $_POST['rt_admin_doc_no'] ?? '');
$iv_date = !empty($_POST['rt_admin_doc_date']) ? $_POST['rt_admin_doc_date'] : '0000-00-00';
$job_no = mysqli_real_escape_string($conn, trim($_POST['rt_admin_work_no'] ?? ''));
$sr_no = mysqli_real_escape_string($conn, $_POST['rt_admin_sr_no'] ?? '');
$order_no = mysqli_real_escape_string($conn, $_POST['rt_admin_deposit_no'] ?? '');
$count_box = intval($_POST['rt_admin_box_count'] ?? 0);
$new_bill = intval($_POST['rt_admin_edit_count'] ?? 0);
$date_oldbill = !empty($_POST['rt_admin_doc_date_old']) ? $_POST['rt_admin_doc_date_old'] : '0000-00-00';
$desnew_bill = mysqli_real_escape_string($conn, $_POST['rt_admin_edit_reason'] ?? '');
$remark_cancel = mysqli_real_escape_string($conn, $_POST['rt_admin_cancel_reason'] ?? '');
$cancel_flag = intval($_POST['rt_admin_cancel_doc'] ?? 0);

$date_ker = !empty($_POST['shipping_date']) ? $_POST['shipping_date'] : '0000-00-00';
$order_refer_code = mysqli_real_escape_string($conn, $_POST['shipping_ref1'] ?? '');
$order_refer_code1 = mysqli_real_escape_string($conn, $_POST['shipping_ref2'] ?? '');
$ker_bath = floatval($_POST['shipping_cost'] ?? 0);

$rental_addr_detail = mysqli_real_escape_string($conn, $_POST['rental_addr_detail'] ?? '');
$rental_province = mysqli_real_escape_string($conn, $_POST['rental_province'] ?? '');
$rental_district = mysqli_real_escape_string($conn, $_POST['rental_district'] ?? '');
$rental_zipcode = mysqli_real_escape_string($conn, $_POST['rental_zipcode'] ?? '');
$rental_referrer = mysqli_real_escape_string($conn, $_POST['rental_referrer'] ?? '');
$rental_repeat_cus = isset($_POST['rental_repeat_cus']) ? 1 : 0;

$location_link = mysqli_real_escape_string($conn, $_POST['location_link'] ?? '');
$transport_company = mysqli_real_escape_string($conn, $_POST['transport_company'] ?? '');

//$end_promis = $_POST["end_promis"];
$sup_code = '';
if( $sale_code=='S23' or $sale_code=='S24' or $sale_code=='S17' or $sale_code=='S11' or $sale_code=='S12' or $sale_code=='S13'){
$sup_code = 'SS2';
  }else if ($sale_code=='S15' or $sale_code=='S22' or $sale_code=='S21' or $sale_code=='S51' or $sale_code=='S16' or $sale_code=='S14' ) {
$sup_code = 'SS1';
  }else if (  $sale_code=='SM1' or $sale_code=='MM2') {
$sup_code = 'SM1';
  }else if ($sale_code=='S31' or $sale_code=='MM1') {
$sup_code = 'SS3';
  }else if ($sale_code=='EN') {
$sup_code = 'SUP_EN';
  }else if ($sale_code=='CM') {
$sup_code = 'CM';

  }
	
	
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$em_id = mysqli_real_escape_string($conn, (string)($_SESSION['emid'] ?? ''));

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__rental";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'] ?? '', -4);
$maxId3 = substr($rs['MAXID'] ?? '', -8);

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

$bank_name = mysqli_real_escape_string($conn, $_POST["bank_name"]);
$accbank_name = mysqli_real_escape_string($conn, $_POST["accbank_name"]);
$bank_no = mysqli_real_escape_string($conn, $_POST["bank_no"]);

$bank_img_allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];
if ($_FILES['bank_img']['size'] == 0) {
$bank_img = "";
}else if ($_FILES['bank_img']['size'] > 1100000) {
rt_abort_with_alert('กรุณาแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');
}   else if ($_FILES['bank_img']['size'] != 0) {
$temp = explode(".", $_FILES["bank_img"]["name"]);
$bank_img_ext = strtolower(end($temp));
if (!in_array($bank_img_ext, $bank_img_allowed_ext, true)) {
	rt_abort_with_alert('ชนิดไฟล์ไม่ถูกต้อง กรุณาแนบไฟล์ .jpg .jpeg .png หรือ .pdf');
}
$bank_img = "bank_img" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . $bank_img_ext;
move_uploaded_file($_FILES["bank_img"]["tmp_name"], "credit_no/" . $bank_img);
}

$saveOk = true;
$saveError = '';
mysqli_begin_transaction($conn);
try {

$save="insert into hos__rental
(ref_id,type_doc,register_date,rental_name,connect_name,start_promis,install_date,rental_address,rental_id,rental_tel,connect_tel,end_promis,des_sale,sale_code,add_date,add_by,install_address,bill_name,bill_tel,bill_address,tax_no,payment,patient_name,emergency_name,emergency_tel,count_m,unit_m,bill_vat,delivery_type,delivery_date,delivery_key,bank_name,accbank_name,bank_no,bank_img,type_product,des_productunit,have_order,iv_no,iv_date,job_no,sr_no,order_no,new_bill,date_oldbill,desnew_bill,remark_cancel,cancel_flag,date_ker,order_refer_code,order_refer_code1,ker_bath,rental_addr_detail,rental_province,rental_district,rental_zipcode,rental_referrer,rental_repeat_cus)
values
('".$ref_id."','".$type_doc."','".$register_date."','".$rental_name."','".$connect_name."','".$start_promis."','".$install_date."','".$rental_address."','".$rental_id."','".$rental_tel."','".$connect_tel."','".$end_promis."','".$des_sale."','".$sale_code."','".$add_date."','".$add_by."','".$install_address."','".$bill_name."','".$bill_tel."','".$bill_address."','".$tax_no."','".$payment."','".$patient_name."','".$emergency_name."','".$emergency_tel."','".$count_m."','".$unit."','".$bill_vat."','".$delivery_type."','".$delivery_date."','".$delivery_key."','".$bank_name."','".$accbank_name."','".$bank_no."','".$bank_img."','".$type_product."','".$des_productunit."','".$have_order."','".$iv_no."','".$iv_date."','".$job_no."','".$sr_no."','".$order_no."','".$new_bill."','".$date_oldbill."','".$desnew_bill."','".$remark_cancel."','".$cancel_flag."','".$date_ker."','".$order_refer_code."','".$order_refer_code1."','".$ker_bath."','".$rental_addr_detail."','".$rental_province."','".$rental_district."','".$rental_zipcode."','".$rental_referrer."','".$rental_repeat_cus."')";

$qsave=mysqli_query($conn,$save);
	
	
$save1 = "insert into hos__rental_runiv (ref_idren,date_runiv,sale_area,area) values ('".$ref_id."','".$start_promis."','".$sale_code."','".$sup_code."')";
$qsave1=mysqli_query($conn,$save1);	
	

$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt1 = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt1);
$sn_number1 = $_POST["sn_number1"];
$delivery_cost1 = $_POST["delivery_cost1"];
$free_count1 = $_POST["free_count1"];
$display_name1 = $_POST["display_name1"];

$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$sn_number2 = $_POST["sn_number2"];
$delivery_cost2 = $_POST["delivery_cost2"];
$free_count2 = $_POST["free_count2"];
$display_name2 = $_POST["display_name2"];

$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$sn_number3 = $_POST["sn_number3"];
$delivery_cost3 = $_POST["delivery_cost3"];
$free_count3 = $_POST["free_count3"];
$display_name3 = $_POST["display_name3"];

$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$sn_number4 = $_POST["sn_number4"];
$delivery_cost4 = $_POST["delivery_cost4"];
$free_count4 = $_POST["free_count4"];
$display_name4 = $_POST["display_name4"];

$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$sn_number5 = $_POST["sn_number5"];
$delivery_cost5 = $_POST["delivery_cost5"];
$free_count5 = $_POST["free_count5"];
$display_name5 = $_POST["display_name5"];

$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$sn_number6 = $_POST["sn_number6"];
$delivery_cost6 = $_POST["delivery_cost6"];
$free_count6 = $_POST["free_count6"];
$display_name6 = $_POST["display_name6"];

$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$sn_number7 = $_POST["sn_number7"];
$delivery_cost7 = $_POST["delivery_cost7"];
$free_count7 = $_POST["free_count7"];
$display_name7 = $_POST["display_name7"];

$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$sn_number8 = $_POST["sn_number8"];
$delivery_cost8 = $_POST["delivery_cost8"];
$free_count8 = $_POST["free_count8"];
$display_name8 = $_POST["display_name8"];

$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$sn_number9 = $_POST["sn_number9"];
$delivery_cost9 = $_POST["delivery_cost9"];
$free_count9 = $_POST["free_count9"];
$display_name9 = $_POST["display_name9"];

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10 = str_replace(',','', $sum_amountt10);
$sn_number10 = $_POST["sn_number10"];
$delivery_cost10 = $_POST["delivery_cost10"];
$free_count10 = $_POST["free_count10"];
$display_name10 = $_POST["display_name10"];


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
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
values ('".$ref_id."','".$product_id1."','".$product_id1."','".$sale_count1."','".$sn_number1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$warranty1."','".$delivery_cost1."','".$free_count1."','".$display_name1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id1."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id1."' ";
$objQuery92 = mysqli_query($conn,$strSQL92);
	
	
}


if($product_id2 !=''){

$strSQL2 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
values ('".$ref_id."','".$product_id2."','".$product_id2."','".$sale_count2."','".$sn_number2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$warranty2."','".$delivery_cost2."','".$free_count2."','".$display_name2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id2."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id2."' ";
$objQuery92 = mysqli_query($conn,$strSQL92);
	
}

if($product_id3 !=''){

$strSQL3 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
values ('".$ref_id."','".$product_id3."','".$product_id3."','".$sale_count3."','".$sn_number3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$warranty3."','".$delivery_cost3."','".$free_count3."','".$display_name3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id3."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id3."' ";
$objQuery92 = mysqli_query($conn,$strSQL92);
}

if($product_id4 !=''){

$strSQL4 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
values ('".$ref_id."','".$product_id4."','".$product_id4."','".$sale_count4."','".$sn_number4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$warranty4."','".$delivery_cost4."','".$free_count4."','".$display_name4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id4."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id4."' ";
$objQuery92 = mysqli_query($conn,$strSQL92);
	
	
}

if($product_id5 !=''){

$strSQL5 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
values ('".$ref_id."','".$product_id5."','".$product_id5."','".$sale_count5."','".$sn_number5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$warranty5."','".$delivery_cost5."','".$free_count5."','".$display_name5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);	

	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id5."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id5."' ";
$objQuery92 = mysqli_query($conn,$strSQL92);
	
	
}

if($product_id6 !=''){

$strSQL6 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$sn_number6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$warranty6."','".$delivery_cost6."','".$free_count6."','".$display_name6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id6."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id6."' ";
$objQuery92 = mysqli_query($conn,$strSQL92);
	
}

if($product_id7 !=''){

$strSQL7 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$sn_number7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$warranty7."','".$delivery_cost7."','".$free_count7."','".$display_name7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id7."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id7."' ";
$objQuery92 = mysqli_query($conn,$strSQL92);
	
}

if($product_id8 !=''){

$strSQL8 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$sn_number8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$warranty8."','".$delivery_cost8."','".$free_count8."','".$display_name8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id8."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id8."' ";
$objQuery92 = mysqli_query($conn,$strSQL92);
	
}

if($product_id9 !=''){

$strSQL9 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sn_number9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$warranty9."','".$delivery_cost9."','".$free_count9."','".$display_name9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id9."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id9."' ";
$objQuery92 = mysqli_query($conn,$strSQL92);
	
}

if($product_id10 !=''){

$strSQL10 = "insert into hos__subrental
(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sn_number10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$warranty10."','".$delivery_cost10."','".$free_count10."','".$display_name10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);	
	
	
$strSQL91 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id10."' ";
$objQuery91 = mysqli_query($conn,$strSQL91);	
	
$strSQL92 = "UPDATE tb_product SET close_pro = '1' where product_ID ='".$product_id10."' ";
$objQuery92 = mysqli_query($conn,$strSQL92);
	
}

	
	
	
	
	
	
//รันเลขที่เอกสาร
$doc_date = $_POST["register_date"];	
$date = explode('-' , $doc_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
	
if($type_doc =='3'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_doc_rental where head_no='JN' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql);
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "JN";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_doc_rental (head_no,doc_no,year_no,month_no,run_iv,ref_id,doc_date) values ('JN','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."','".$doc_date."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($type_doc =='4'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_doc_rental where head_no='JN/' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql);
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "JN/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_doc_rental (head_no,doc_no,year_no,month_no,run_iv,ref_id,doc_date) values ('JN/','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."','".$doc_date."')";
$qsave5=mysqli_query($conn,$save5);


	}	
	
$promis_date = $start_promis;
$date = explode('-' , $start_promis );
$year = $date[0];
$mont = $date[1] ?? '';
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_promisno where month_no ='".$mont."' and year_no = '".$year1."'";
			
$qry = mysqli_query($conn,$sql);
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ธส.";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -3);
$nextId = $maxId2;


$promis_no = $so.$year1.$mont.$nextId;
$date_save = date('Y-m-d H:i:s');

$save5="insert into tb_promisno (promis_n,year_no,month_no,run_no,date_save,ref_id) values ('".$promis_no."','".$year1."','".$mont."','".$nextId."','".$date_save."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);	
	
	
	
$save="Update  hos__rental set iv_no='".$doc_no."',iv_date='".$doc_date."',promis_date='".$promis_date."',promis_no='".$promis_no."'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($conn,$save);	
		
	
	
	
	
	
	
	

 $start_date =$_POST["start_date"];

 $between_date =$_POST["between_date"];
 $start_time=$_POST["start_time"];
 $end_time=$_POST["end_time"];
 $status=$_POST["status"] ?? '';
	
 if (isset($_POST["start_date"]) && $_POST["start_date"]!=''){
		$start_date =$_POST["start_date"];
	}else{
		$start_date='0000-00-00';
	}
	
	if (isset($_POST['fix_datetime']) && $_POST['fix_datetime']!=''){
		$fix_date=$_POST['fix_datetime'];
	}else{
		$fix_date='0';
	}
	
	if (isset($_POST['no_money']) && $_POST['no_money']!=''){
        $no_price=$_POST['no_money'];
	}else{
		$no_price='0';
	}
	if (isset($_POST['call_customer']) && $_POST['call_customer']!=''){
		 $call_customer=$_POST['call_customer'];
	}else{
		$call_customer='0';
	}
	// credit_card/cash/check_paper/bill/tran/want_bus/dep/unit_* ไม่มี input ชื่อเหล่านี้ใน
	// register_suprental.php (ของเดิม copy มาจาก hos/cshos ที่มี payment breakdown UI ต่างกัน)
	// จึงคงค่า default ไว้ตรง ๆ แทนการเช็ค $_POST ที่ไม่มีทางเป็นจริง
	$credit = '0';
	$unit_credit = '';
	$want_bus = '0';
	$call_employee = '0';
	$chash = '0';
	$price = '';
	$check_peper = '0';
	$unit_check1 = '';
	$bill = '0';
	$unit_bill1 = '';
	$tran = '0';
	$unit_tran = '';
	$dep = '0';

	
 $department=mysqli_real_escape_string($conn, $_POST["department_name"] ?? '');
	$type_customer=mysqli_real_escape_string($conn, $_POST["customer_typename"] ?? '');

	if($type_doc=='3'){
 $type_company='ออลล์เวล ไลฟ์ บจก.';
	}else if($type_doc=='4'){
	$type_company='โนเบิล เมด บจก.';
	}


$province_name =mysqli_real_escape_string($conn, $_POST["province_name"]);
 $customer_name=mysqli_real_escape_string($conn, $_POST["customer_name"]);
 $customer_tel=mysqli_real_escape_string($conn, $_POST["customer_tel"]);
 $address_name=mysqli_real_escape_string($conn, $_POST["address_name"]);
	 $address_1=mysqli_real_escape_string($conn, $_POST["address_1"]);
 $address_send=mysqli_real_escape_string($conn, $_POST["address_send"]);

// ===== เพิ่มที่อยู่ลงฐานข้อมูลลูกค้า (tb_customer_shipping_address) เมื่อกดปุ่ม "เพิ่มลงฐานลูกค้า" =====
// พอร์ตจาก register_supbrcshos1.php:652-731 — rental ใช้ $rental_id เป็น customer id แทน $customer_id
// และไม่มี hidden field ของที่อยู่แบบแยกส่วน (shipping_address_raw/ampher/postcode) จึงใช้ address_name เสมอ
$save_to_customer_db = isset($_POST['save_to_customer_db']) && $_POST['save_to_customer_db'] === '1';
if ($save_to_customer_db && !empty($rental_id)) {
	$esc_customer_id = mysqli_real_escape_string($conn, $rental_id);
	$esc_shipping_name = mysqli_real_escape_string($conn, $customer_name);
	$esc_shipping_tel = mysqli_real_escape_string($conn, $customer_tel);
	$esc_shipping_province = mysqli_real_escape_string($conn, $province_name);
	$esc_shipping_address = mysqli_real_escape_string($conn, $address_name);
	$esc_shipping_ampher = '';
	$esc_shipping_postcode = '';
	$esc_install_location = mysqli_real_escape_string($conn, $address_send);
	$esc_location_link = mysqli_real_escape_string($conn, $_POST['location_link'] ?? '');
	$now = date('Y-m-d H:i:s');

	$col_check = mysqli_query($conn, "SHOW COLUMNS FROM tb_customer_shipping_address");
	$existing_cols = array();
	if ($col_check) {
		while ($col_row = mysqli_fetch_assoc($col_check)) {
			$existing_cols[] = strtolower($col_row['Field']);
		}
	}

	$sql_dup_check = "SELECT id FROM tb_customer_shipping_address
		WHERE customer_id = '$esc_customer_id'
			AND shipping_name = '$esc_shipping_name'
			AND shipping_address = '$esc_shipping_address'
			AND shipping_tel = '$esc_shipping_tel'
		LIMIT 1";
	$dup_result = mysqli_query($conn, $sql_dup_check);
	$dup_row = $dup_result ? mysqli_fetch_assoc($dup_result) : null;

	if (!$dup_row) {
		$next_index = 1;
		$idx_result = mysqli_query($conn, "SELECT COALESCE(MAX(shipping_index), 0) + 1 AS next_index
			FROM tb_customer_shipping_address WHERE customer_id = '$esc_customer_id'");
		if ($idx_result && ($idx_row = mysqli_fetch_assoc($idx_result))) {
			$next_index = (int)$idx_row['next_index'];
		}

		$insert_fields = array(
			'customer_id' => "'$esc_customer_id'",
			'shipping_index' => "'$next_index'",
			'shipping_preface_name' => "''",
			'shipping_name' => "'$esc_shipping_name'",
			'shipping_address' => "'$esc_shipping_address'",
			'shipping_ampher' => "'$esc_shipping_ampher'",
			'shipping_province' => "'$esc_shipping_province'",
			'shipping_postcode' => "'$esc_shipping_postcode'",
			'shipping_tel' => "'$esc_shipping_tel'",
			'created_at' => "'$now'",
			'updated_at' => "'$now'"
		);

		if (in_array('install_location', $existing_cols)) {
			$insert_fields['install_location'] = "'$esc_install_location'";
		}
		if (in_array('location_link', $existing_cols)) {
			$insert_fields['location_link'] = "'$esc_location_link'";
		}

		$insert_cols_str = implode(', ', array_keys($insert_fields));
		$insert_vals_str = implode(', ', array_values($insert_fields));

		mysqli_query($conn, "INSERT INTO tb_customer_shipping_address ($insert_cols_str) VALUES ($insert_vals_str)");
	}
}

$customer_contact = mysqli_real_escape_string($conn, $_POST["customer_contact"] ?? '');
$mk_research = mysqli_real_escape_string($conn, $_POST["mk_research"] ?? '');
$on_time = mysqli_real_escape_string($conn, $_POST["on_time"] ?? '');
$amphur_name = mysqli_real_escape_string($conn, $_POST["amphur_name"] ?? '');
// province_name ถูก escape ไว้แล้วด้านบน (บรรทัด ~620) — เดิมมีการอ่านซ้ำตรงนี้ทับด้วยค่าดิบ ตัดออก
$product_sn="เลขที่เอกสาร $doc_no เลขที่สัญญา $promis_no";
	
$product_name1 = $_POST["product_name1"];	
$product_name2 = $_POST["product_name2"];	
$product_name3 = $_POST["product_name3"];	
$product_name4 = $_POST["product_name4"];	
$product_name5 = $_POST["product_name5"];	
$product_name6 = $_POST["product_name6"];	
$product_name7 = $_POST["product_name7"];

$unit_name1 = $_POST["unit_name1"] ?? '';
$unit_name2 = $_POST["unit_name2"] ?? '';
$unit_name3 = $_POST["unit_name3"] ?? '';
$unit_name4 = $_POST["unit_name4"] ?? '';
$unit_name5 = $_POST["unit_name5"] ?? '';
$unit_name6 = $_POST["unit_name6"] ?? '';
$unit_name7 = $_POST["unit_name7"] ?? '';

 $product_name = "ส่ง $product_name1 $sale_remarkk1 $sale_count1 $unit_name1 $product_name2 $sale_remarkk2 $sale_count2 $unit_name2 $product_name3 $sale_remarkk3 $sale_count3 $unit_name3 $product_name4 $sale_remarkk4 $sale_count4 $unit_name4  $product_name5 $sale_remarkk5 $sale_count5 $unit_name5  $product_name6 $sale_remarkk6 $sale_count6 $unit_name6 $product_name7 $sale_remarkk7 $sale_count7 $unit_name7 $address_name";	


 $employee_name=mysqli_real_escape_string($conn, $_POST["employee_name"] ?? '');
 $employee_tel=mysqli_real_escape_string($conn, $_POST["employee_tel"] ?? '');
 $add_by=mysqli_real_escape_string($conn, $_POST["add_by"] ?? '');
 $description=mysqli_real_escape_string($conn, $_POST["sale_comment"] ?? '');
 $havemap=$_POST['have_map'] ?? '';
$department_show = mysqli_real_escape_string($conn, $_POST["department_show"] ?? '');

$dept =mysqli_real_escape_string($conn, $_POST["dept"] ?? '');
$status_comment =mysqli_real_escape_string($conn, $_POST["status_comment"]);

if (isset($_POST['more']) && $_POST['more']!=''){
		 $check_detail=$_POST["more"];
	}else{
		$check_detail='0';
	}

$number = mysqli_real_escape_string($conn, $_POST["number"] ?? '');

$park_front = $_POST['park_front'] ?? '1';
$car_home = ($park_front === '1') ? 1 : 0;
$car_park = mysqli_real_escape_string($conn, $_POST['park_location'] ?? '');
$is_high_roof = isset($_POST['is_high_roof']) ? 1 : 0;
$entrance_type = $_POST['entrance_type'] ?? '1';
$slope = ($entrance_type === '1') ? 1 : 0;
$bundai = ($entrance_type === '2') ? 1 : 0;
$unit_bundai = mysqli_real_escape_string($conn, $_POST['stair_count'] ?? '');
$install = mysqli_real_escape_string($conn, $_POST['install_floor'] ?? '');
$install_room = mysqli_real_escape_string($conn, $_POST['room_type'] ?? '');
$room_bigger = mysqli_real_escape_string($conn, $_POST['door_width'] ?? '');
$room_longer = mysqli_real_escape_string($conn, $_POST['door_height'] ?? '');
$bundai_big = trim(($_POST['stair_width'] ?? '') . ' x ' . ($_POST['stair_height'] ?? ''), ' x');
$lip_big = trim(($_POST['elev_door_width'] ?? '') . ' x ' . ($_POST['elev_door_height'] ?? ''), ' x');
$lip_long = trim(($_POST['elev_width'] ?? '') . ' x ' . ($_POST['elev_height'] ?? '') . ' x ' . ($_POST['elev_depth'] ?? ''), ' x');
$lip_weight = mysqli_real_escape_string($conn, $_POST['elev_capacity'] ?? '');
$want_employee = (($_POST['move_furn'] ?? '0') === '1') ? 1 : 0;
$employee_unit = mysqli_real_escape_string($conn, $_POST['move_furn_count'] ?? '');
$ferniger_name = mysqli_real_escape_string($conn, $_POST['move_furn_detail'] ?? '');
$addr_note = mysqli_real_escape_string($conn, $_POST['addr_note'] ?? '');
$height_ltd = $is_high_roof;
	
	
	
$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,mk_research,province_name,count_box,location_link,transport_company)

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','โรงพยาบาล','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill1."','".$unit_check1."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$mk_research."','".$province_name."','".$count_box."','".$location_link."','".$transport_company."')";

$objQuery66 = mysqli_query($conn,$strSQL66);
if (!$objQuery66) {
	$saveOk = false;
	$saveError = 'tb_register_data: ' . mysqli_error($conn);
}

$strSQL99 =  "insert into tb_transaction (ref_id,car_home,car_park,slope,bundai,unit_bundai,install,install_room,room_bigger,room_longer,bundai_big,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,description,height_ltd,add_date,add_by)

values('".$ref_id."','".$car_home."','".$car_park."','".$slope."','".$bundai."','".$unit_bundai."','".$install."','".$install_room."','".$room_bigger."','".$room_longer."','".$bundai_big."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$addr_note."','".$height_ltd."','$add_date','".$add_by."')";

$objQuery99 = mysqli_query($conn,$strSQL99);
if (!$objQuery99) {
	$saveOk = false;
	$saveError = 'tb_transaction: ' . mysqli_error($conn);
}

	
	

	

if($send_cs =='1'){

$yearMonth = substr(date("Y")+543, -2).date("m");

if ($job_no !== '') {
	// ผู้ใช้กดไอคอน "Run" เลขที่ลงงานไว้ก่อนแล้ว (ajax_run_job_no.php จองแถวเปล่าไว้ใน
	// tb_register_data ให้แล้วตอนกดปุ่ม) ใช้เลขเดิมนั้นต่อ ไม่สุ่มเลขใหม่ซ้อนกัน แล้ว UPDATE
	// แถวที่จองไว้ให้มีข้อมูลใบงานจริงครบแทนที่จะ INSERT ซ้ำอีกแถว
	$nextId = $job_no;

	$strSQL89 = "UPDATE tb_register_data SET
		start_date='".$start_date."', between_date='".$between_date."', start_time='".$start_time."',
		end_time='".$end_time."', status='".$status."', fix_date='".$fix_date."', no_price='".$no_price."',
		call_customer='".$call_customer."', credit='".$credit."', call_employee='".$call_employee."',
		cash='".$chash."', check_peper='".$check_peper."', bill='".$bill."', department='".$department."',
		type_customer='".$type_customer."', type_company='".$type_company."', customer_name='".$customer_name."',
		customer_tel='".$customer_tel."', address_name='".$address_name."', address_send='".$address_send."',
		want_bus='".$want_bus."', amphur_name='".$amphur_name."', province_name='".$province_name."',
		product_name='".$product_name."', product_sn='".$product_sn."', unit_credit='".$unit_credit."',
		price='".$price."', employee_name='".$employee_name."', employee_tel='".$employee_tel."',
		add_by='".$add_by."', description='".$description."', have_map='".$havemap."', add_date='".$add_date."',
		unit_bill='".$unit_bill1."', unit_check='".$unit_check1."', unit_tran='".$unit_tran."', tran='".$tran."',
		check_detail='".$check_detail."', number='".$number."', status_comment='".$status_comment."',
		dep='".$dep."', dept='".$dept."', department_show='".$department_show."', on_time='".$on_time."',
		address_1='".$address_1."', mk_research='".$mk_research."', customer_contact='".$customer_contact."',
		ref_id='".$ref_id."', count_box='".$count_box."', location_link='".$location_link."',
		transport_company='".$transport_company."'
		WHERE running = '".$nextId."'";

	$objQuery89 = mysqli_query($conn, $strSQL89);
	if (!$objQuery89) {
		$saveOk = false;
		$saveError = 'tb_register_data (UPDATE by job_no): ' . mysqli_error($conn);
	}
} else {
	$sql = "SELECT MAX(running) AS MAXID FROM tb_register_data";
	$qry = mysqli_query($conn,$sql);
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

	$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,on_time,address_1,add_code,mk_research,customer_contact,ref_id,count_box,location_link,transport_company)

	values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill1."','".$unit_check1."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$on_time."','".$address_1."','".$em_id."','".$mk_research."','".$customer_contact."','".$ref_id."','".$count_box."','".$location_link."','".$transport_company."')";

	$objQuery89 = mysqli_query($conn,$strSQL89);
	if (!$objQuery89) {
		$saveOk = false;
		$saveError = 'tb_register_data (send_cs insert): ' . mysqli_error($conn);
	}
}



 $strSQL90 =  "insert into tb_transaction (running,car_home,car_park,slope,bundai,unit_bundai,install,install_room,room_bigger,room_longer,bundai_big,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,description,height_ltd,add_date,add_by)

values('".$nextId."','".$car_home."','".$car_park."','".$slope."','".$bundai."','".$unit_bundai."','".$install."','".$install_room."','".$room_bigger."','".$room_longer."','".$bundai_big."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$addr_note."','".$height_ltd."','$add_date','".$add_by."')";

$objQuery90 = mysqli_query($conn,$strSQL90);
if (!$objQuery90) {
	$saveOk = false;
	$saveError = 'tb_transaction (send_cs insert): ' . mysqli_error($conn);
}

$strSQL26="Update hos__rental set job_no='".$nextId."',send_cs ='2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);

	}
	
	
	
	
	
$strSQL1 = "SELECT * FROM  (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";

$objQuery1 = mysqli_query($conn,$strSQL1);
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
	
	
$strSQL2 = "SELECT product_code,count  FROM hos__subrental where ref_idd = '".$ref_id."' and product_code ='".$objResult1["product_code"]."' and ckk_pro='0'";
$objQuery2 = mysqli_query($conn,$strSQL2);
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);	

if($Num_Rows2 > 0){
	
$strSQL3 = "SELECT * FROM  tb_product_checklist  WHERE ref_id = '".$ref_id."'";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3) ?: [];

$strSQLreb = "SELECT * FROM tb_product_rental where product_id ='".$objResult1["product_code"]."'";
$objQueryreb = mysqli_query($conn,$strSQLreb);
$Num_Rowsreb = mysqli_num_rows($objQueryreb);
$objResultreb = mysqli_fetch_array($objQueryreb) ?: [];
	

if(($objResult3["ref_id"] ?? '')!=''){ }else{
	
	
$save99="insert into tb_product_rentalref
(ref_idrt,product_id,sn_number,list_des1,list_des2,list_des3,list_des4,list_des5,list_des6,list_des7,list_des8,list_des9,list_des10,list_des11,list_des12,list_des13,list_des14,list_des15,list_des16)
values
('".$ref_id."','".$objResult1["product_code"]."','".($objResultreb["sn_number"] ?? '')."','".($objResultreb["list_des1"] ?? '')."','".($objResultreb["list_des2"] ?? '')."','".($objResultreb["list_des3"] ?? '')."','".($objResultreb["list_des4"] ?? '')."','".($objResultreb["list_des5"] ?? '')."','".($objResultreb["list_des6"] ?? '')."','".($objResultreb["list_des7"] ?? '')."','".($objResultreb["list_des8"] ?? '')."','".($objResultreb["list_des9"] ?? '')."','".($objResultreb["list_des10"] ?? '')."','".($objResultreb["list_des11"] ?? '')."','".($objResultreb["list_des12"] ?? '')."','".($objResultreb["list_des13"] ?? '')."','".($objResultreb["list_des14"] ?? '')."','".($objResultreb["list_des15"] ?? '')."','".($objResultreb["list_des16"] ?? '')."')";
$qsave99=mysqli_query($conn,$save99);
	
	
	

$product_id = $objResult1["product_code"]; 
$count = str_replace('.00','',$objResult2["count"]);
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

$strDate = date('Y-m-d');

$strYear = date("Y",strtotime($strDate))+543;
$strYear1 =substr( $strYear , 2 , 2 );

//for ($x = 0; $x <= $count; $x+=$count) {
	

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_pc) AS MAXID FROM tb_product_checklist where head_pc='DO'";
$qry = mysqli_query($conn,$sql);
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

$so = "DO";
$ref_pc ="$so$nextId";



$save99="insert into tb_product_checklist
(ref_pc,doc_no,year_no,ref_id,product_id,add_date,add_by,date_create,head_pc,sn)
values
('".$ref_pc."','".$ref_pc."','".$strYear1."','".$ref_id."','".$product_id."','".$add_date."','".$add_by."','".$strDate."','".$so."','".($objResultreb["sn_number"] ?? '')."')";
$qsave99=mysqli_query($conn,$save99);


$save1="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','ST','1')";
$qsave1=mysqli_query($conn,$save1);

$save2="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','EN','1')";
$qsave2=mysqli_query($conn,$save2);

$save3="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','CS','1')";
$qsave3=mysqli_query($conn,$save3);

$save4="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','CS','2')";
$qsave4=mysqli_query($conn,$save4);

$save5="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','EN','2')";
$qsave5=mysqli_query($conn,$save5);

$save6="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','ST','2')";
$qsave6=mysqli_query($conn,$save6);	
	
	
//}	
	
$strSQL = "Update   hos__subrental set ckk_pro='1'  Where ref_idd = '".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL);
	
	
}
}
}

	
	
	
	
	
	
	
	
	
	
} catch (mysqli_sql_exception $e) {
	$saveOk = false;
	$saveError = $e->getMessage();
}

if ($saveOk) {
	mysqli_commit($conn);
	if (ob_get_level() > 0) {
		ob_end_clean();
	}
	header('Location: register_suprental.php?ref_id=' . rawurlencode($ref_id) . '&saved=1');
	exit();
} else {
	mysqli_rollback($conn);
	rt_abort_with_alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $saveError);
}
	}


