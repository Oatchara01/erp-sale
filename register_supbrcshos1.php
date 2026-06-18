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
$objective = $_POST["objective"];
$objective_des = $_POST["objective_des"];
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
//$ckk_war = $_POST["ckk_war"];
$iv_no = "";
$que_ckk = $_POST["que_ckk"];
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
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__consig ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = substr($rs['MAXID'], -5);
$maxId3 = substr($rs['MAXID'],-9);

$maxId1 = substr($maxId3,0,-5);

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


$so = "BS";
$ref_id ="$so$nextId";	
	
	
if ($_FILES['slip1']['size'] == 0) {
$slip1 = "";
}else if ($_FILES['slip1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip1']['size'] != 0) {
$temp1 = explode(".", $_FILES["slip1"]["name"]);
$slip1 = "slip1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["slip1"]["tmp_name"], "brsc/" . $slip1);
}	

	
	
if ($_FILES['slip2']['size'] == 0) {
$slip2 = "";
}else if ($_FILES['slip2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip2']['size'] != 0) {
$temp2 = explode(".", $_FILES["slip2"]["name"]);
$slip2 = "slip2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["slip2"]["tmp_name"], "brsc/" . $slip2);
}	
	
	
if ($_FILES['slip3']['size'] == 0) {
$slip3 = "";
}else if ($_FILES['slip3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip3']['size'] != 0) {
$temp3 = explode(".", $_FILES["slip3"]["name"]);
$slip3 = "slip3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["slip3"]["tmp_name"], "brsc/" . $slip3);
}	
	
	
if ($_FILES['slip4']['size'] == 0) {
$slip4 = "";
}else if ($_FILES['slip4']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip4']['size'] != 0) {
$temp4 = explode(".", $_FILES["slip4"]["name"]);
$slip4 = "slip4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["slip4"]["tmp_name"], "brsc/" . $slip4);
}	
	
	
	
if ($_FILES['slip5']['size'] == 0) {
$slip5 = "";
}else if ($_FILES['slip5']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip5']['size'] != 0) {
$temp5 = explode(".", $_FILES["slip5"]["name"]);
$slip5 = "slip5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["slip5"]["tmp_name"], "brsc/" . $slip5);
}	
			
if($_SESSION['name']=='บรรจบพร' or $_SESSION['name']=='สุภัสสร' or $_SESSION['name']=='พิมลพร' or $_SESSION['name']=='ขนิษฐา' or $_SESSION['name']=='พิมพ์ชนก'){
$adm_ckk = '1';		
}else{
$adm_ckk = '0';	
}
	
	



$save="insert into hos__consig
(company,ref_id,date_save,customer,customer_id,address,sale_comment,objective,objective_des,status_doc,delivery_name,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,date_send_key,sale_date,sale,sale_code,add_date,add_by,slip1,slip2,slip3,slip4,slip5,iv_no,que_ckk,send_sup,send_supname,send_supdate)
values
('".$company."','".$ref_id."','".$date_br."','".$customer."','".$customer_id."','".$address."','".$sale_comment."','".$objective."','".$objective_des."','".$status_doc."','".$delivery_name."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$date_send_key."','".$sale_date."','".$sale."','".$sale_code."','".$add_date."','".$add_by."','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','".$iv_no."','".$que_ckk."','1','".$add_by."','".$add_date."')";


$qsave=mysqli_query($conn,$save);

	

	
$product_id1 = $_POST["product_id1"];
$product_name1 = $_POST["product_name1"];
$unit_name1 = $_POST["unit_name1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$discount_unit1 = $_POST["discount_unit1"];
$warranty1  = $_POST["warranty1"];
$cal1 = $_POST["cal1"];
$pm1 = $_POST["pm1"];


$product_name2 = $_POST["product_name2"];
$unit_name2 = $_POST["unit_name2"];
$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];
$warranty2  = $_POST["warranty2"];
$cal2 = $_POST["cal2"];
$pm2 = $_POST["pm2"];


$product_name3 = $_POST["product_name3"];
$unit_name3 = $_POST["unit_name3"];
$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];
$warranty3  = $_POST["warranty3"];
$cal3 = $_POST["cal3"];
$pm3 = $_POST["pm3"];


$product_name4 = $_POST["product_name4"];
$unit_name4 = $_POST["unit_name4"];
$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];
$warranty4  = $_POST["warranty4"];
$cal4 = $_POST["cal4"];
$pm4 = $_POST["pm4"];


$product_name5 = $_POST["product_name5"];
$unit_name5 = $_POST["unit_name5"];
$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_POST["discount_unit5"];
$warranty5  = $_POST["warranty5"];
$cal5 = $_POST["cal5"];
$pm5 = $_POST["pm5"];



$product_name6 = $_POST["product_name6"];
$unit_name6 = $_POST["unit_name6"];
$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];
$warranty6  = $_POST["warranty6"];
$cal6 = $_POST["cal6"];
$pm6 = $_POST["pm6"];


$product_name7 = $_POST["product_name7"];
$unit_name7 = $_POST["unit_name7"];
$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];
$warranty7  = $_POST["warranty7"];
$cal7 = $_POST["cal7"];
$pm7 = $_POST["pm7"];


$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];
$warranty8  = $_POST["warranty8"];
$cal8 = $_POST["cal8"];
$pm8 = $_POST["pm8"];


$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];
$warranty9  = $_POST["warranty9"];
$cal9 = $_POST["cal9"];
$pm9 = $_POST["pm9"];


$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];
$warranty10  = $_POST["warranty10"];
$cal10 = $_POST["cal10"];
$pm10 = $_POST["pm10"];




if($product_id1!=''){

$strSQL1 = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,sale_remark,add_by,add_date)
values ('".$ref_id."','".$product_id1."','".$product_id1."','".$sale_count1."','".$product_price1."','".$discount_unit1."','".$sum_amount1."','".$warranty1."','".$cal1."','".$pm1."','".$sale_remarkk1."','".$add_by."','".$add_date."')";

$objQuery1 = mysqli_query($conn,$strSQL1);


}


if($product_id2!=''){

$strSQL2 = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,sale_remark,add_by,add_date)
values ('".$ref_id."','".$product_id2."','".$product_id2."','".$sale_count2."','".$product_price2."','".$discount_unit2."','".$sum_amount2."','".$warranty2."','".$cal2."','".$pm2."','".$sale_remarkk2."','".$add_by."','".$add_date."')";

$objQuery2 = mysqli_query($conn,$strSQL2);


}

if($product_id3!=''){

$strSQL3 = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,sale_remark,add_by,add_date)
values ('".$ref_id."','".$product_id3."','".$product_id3."','".$sale_count3."','".$product_price3."','".$discount_unit3."','".$sum_amount3."','".$warranty3."','".$cal3."','".$pm3."','".$sale_remarkk3."','".$add_by."','".$add_date."')";

$objQuery3 = mysqli_query($conn,$strSQL3);


}

if($product_id4!=''){

$strSQL4 = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,sale_remark,add_by,add_date)
values ('".$ref_id."','".$product_id4."','".$product_id4."','".$sale_count4."','".$product_price4."','".$discount_unit4."','".$sum_amount4."','".$warranty4."','".$cal4."','".$pm4."','".$sale_remarkk4."','".$add_by."','".$add_date."')";

$objQuery4 = mysqli_query($conn,$strSQL4);


}

if($product_id5!=''){

$strSQL5 = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,sale_remark,add_by,add_date)
values ('".$ref_id."','".$product_id5."','".$product_id5."','".$sale_count5."','".$product_price5."','".$discount_unit5."','".$sum_amount5."','".$warranty5."','".$cal5."','".$pm5."','".$sale_remarkk5."','".$add_by."','".$add_date."')";

$objQuery5 = mysqli_query($conn,$strSQL5);


}

if($product_id6!=''){

$strSQL6 = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,sale_remark,add_by,add_date)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$product_price6."','".$discount_unit6."','".$sum_amount6."','".$warranty6."','".$cal6."','".$pm6."','".$sale_remarkk6."','".$add_by."','".$add_date."')";

$objQuery6 = mysqli_query($conn,$strSQL6);


}

if($product_id7!=''){

$strSQL7 = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,sale_remark,add_by,add_date)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$product_price7."','".$discount_unit7."','".$sum_amount7."','".$warranty7."','".$cal7."','".$pm7."','".$sale_remarkk7."','".$add_by."','".$add_date."')";

$objQuery7 = mysqli_query($conn,$strSQL7);


}

if($product_id8!=''){

$strSQL8 = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,sale_remark,add_by,add_date)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$product_price8."','".$discount_unit8."','".$sum_amount8."','".$warranty8."','".$cal8."','".$pm8."','".$sale_remarkk8."','".$add_by."','".$add_date."')";

$objQuery8 = mysqli_query($conn,$strSQL8);


}

if($product_id9!=''){

$strSQL9 = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,sale_remark,add_by,add_date)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$product_price9."','".$discount_unit9."','".$sum_amount9."','".$warranty9."','".$cal9."','".$pm9."','".$sale_remarkk9."','".$add_by."','".$add_date."')";

$objQuery9 = mysqli_query($conn,$strSQL9);


}

if($product_id10!=''){

$strSQL10 = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,sale_remark,add_by,add_date)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$product_price10."','".$discount_unit10."','".$sum_amount10."','".$warranty10."','".$cal10."','".$pm10."','".$sale_remarkk10."','".$add_by."','".$add_date."')";

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
	
if($company=='1'){
 $type_company='ออลล์เวล ไลฟ์ บจก.';
	}else if($company=='2'){
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

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','".$add_date."','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$province_name."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());










	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supbrcshos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


