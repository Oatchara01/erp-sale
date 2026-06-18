<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 
include("dbconnect_cs.php");

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$company = $_POST["company"];
$date_save = $_POST["date_save"];
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
$send_brdoc  =  $_POST["send_brdoc"];	
//$ckk_war = $_POST["ckk_war"];
$iv_no = "";
$que_ckk = $_POST["que_ckk"];
$sale_date= date('Y-m-d');
$sale =  $_POST["sale"];
$sale_code = $_POST['sale_code'];
$em_id =  $_SESSION['emid'];
$iv_date = $_POST["iv_date"];
	
$iv_time1 = $_POST["iv_time"];
if($iv_date !='' and $iv_time1=='00:00:00'){	
$iv_time = date('H:i:s');	
}else{
$iv_time = $_POST["iv_time"];	
}	

$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";


$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
$ref_id =$_POST["ref_id"];	
$send_cs = $_POST["send_cs"];
$remark_cancel = $_POST["remark_cancel"];	
	
$order_refer_code = $_POST["order_refer_code"];	
$order_refer_code1 = $_POST["order_refer_code1"];	
$date_ker = $_POST["date_ker"];	
$ker_bath = $_POST["ker_bath"];	
	
 if ($_FILES['slip1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip1']['name']!=''){
$temp1 = explode(".", $_FILES["slip1"]["name"]);
$slip1 = "slip1" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["slip1"]["tmp_name"], "brsc/" . $slip1);
}else{
 $slip1 = $_POST["slip1"];

}

 if ($_FILES['slip2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip2']['name']!=''){
$temp2 = explode(".", $_FILES["slip2"]["name"]);
$slip2 = "slip2" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["slip2"]["tmp_name"], "brsc/" . $slip2);
}else{
 $slip2 = $_POST["slip2"];

}

 if ($_FILES['slip3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip3']['name']!=''){
$temp3 = explode(".", $_FILES["slip3"]["name"]);
$slip3 = "slip3" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["slip3"]["tmp_name"], "brsc/" . $slip3);
}else{
 $slip3 = $_POST["slip3"];

}

 if ($_FILES['slip4']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip4']['name']!=''){
$temp4 = explode(".", $_FILES["slip4"]["name"]);
$slip4 = "slip4" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["slip4"]["tmp_name"], "brsc/" . $slip4);
}else{
 $slip4 = $_POST["slip4"];

}

 if ($_FILES['slip5']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip5']['name']!=''){
$temp5 = explode(".", $_FILES["slip5"]["name"]);
$slip5 = "slip5" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["slip5"]["tmp_name"], "brsc/" . $slip5);
}else{
 $slip5 = $_POST["slip5"];

}


		
	
$run_id = $_POST["run_id"];
$date = explode('-' , $iv_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);


if($run_id=='1'){	

if($company =='1'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BRSC' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BRSC";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$iv_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BRSC','".$iv_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($company =='2'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BRSCN' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BRSCN";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$iv_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BRSCN','".$iv_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);


	}
	
	
}else{	
$iv_no = $_POST["iv_no"];	
}


$job_no = $_POST["job_no"];



$save="UPDATE hos__consig SET customer='".$customer."',customer_id='".$customer_id."',address='".$address."',sale_comment='".$sale_comment."',objective='".$objective."',objective_des='".$objective_des."',delivery_name='".$delivery_name."',delivery_type='".$delivery_type."',delivery_date='".$delivery_date."',delivery_time='".$delivery_time."',delivery_address='".$delivery_address."',delivery_contact='".$delivery_contact."',delivery_tel='".$delivery_tel."',date_send_key='".$date_send_key."',slip1='".$slip1."',slip2='".$slip2."',slip3='".$slip3."',slip4='".$slip4."',slip5='".$slip5."',que_ckk='".$que_ckk."',sale_code='".$sale_code."',iv_no = '".$iv_no."',iv_date = '".$iv_date."',iv_time='".$iv_time."',admin='".$add_by."',admin_date='".$add_date."',remark_cancel='".$remark_cancel."',ker_bath='".$ker_bath."',date_ker='".$date_ker."',order_refer_code1='".$order_refer_code1."',order_refer_code='".$order_refer_code."',sale ='".
$sale."'   where ref_id ='".$ref_id."'";

$qsave=mysqli_query($conn,$save);

if($send_brdoc =='1'){	
	
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');

$save9="insert into tb_register_br
(company,br_date,iv_no,customer_name,add_by,add_date,ref_id) values ('".$company."','".$iv_date."','".$iv_no."','".$customer."','".$add_by."','".$add_date."','".$ref_id."')";
$qsave9=mysqli_query($conn,$save9);


$save3="Update   hos__consig set send_brdoc = '2' where ref_id ='".$ref_id."'";
$qsave3=mysqli_query($conn,$save3);
	
}
	


$status_doc = $_POST["status_doc"];
	
	if($status_doc !=''){
$save="Update   hos__consig set  status_doc='".$status_doc."'  where ref_id ='".$ref_id."'";
$qsave=mysqli_query($conn,$save);	
		
		
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
$sn = $_POST["sn"];


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


$strSQL = "Update   hos__subconsig set count='".$sale_count_new."',price='".$product_price_new."',amount='".$sum_amount_new."',sale_remark='".$sale_remarkk_new."',warranty='".$warranty_new."',pm='".$pm_new."',cal='".$cal_new."',discount ='".$discount_unit_new."',sn='".$sn_new."'  Where id= '".$id_new."' ";
$objQuery = mysqli_query($conn,$strSQL);

	
	}


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
$bus_inter = $_POST["bus_inter"];
	
 $department=$_POST["department_name"];
 $type_customer=$_POST["customer_typename"];
if($company=='1'){	
 $type_company= "ออลล์เวล ไลฟ์ บจก.";
}else if($company=='2'){	
$type_company= "โนเบิล เมด บจก.";	
}
	
 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
$on_time =$_POST["on_time"];	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product=$_POST["product"];
 $product_name = "$product  $product_name6  $sale_count6 $unit_name6 $product_name7  $sale_count7 $unit_name7 $product_name8  $sale_count8 $unit_name8 $product_name9  $sale_count9 $unit_name9 $product_name10  $sale_count10 $unit_name10";
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
	

	
$sql = "SELECT *   FROM st__signature where ref_id = '".$ref_id."'";
$qry = mysqli_query($new,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
if($rs["cs_name"]==''){		

$strSQL66 =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$address_name."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',address_1 = '".$address_1."',province_name='".$province_name."',bus_inter='".$bus_inter."'  where ref_id = '".$ref_id."'";
$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());

if($job_no!=''){


$strSQL66 =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$address_1."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',province_name='".$province_name."'  where running = '".$job_no."'";
$objQuery66 = mysqli_query($com1,$strSQL66) or die(mysqli_error());
	
}
}

	
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

$sum_address = "$address_send $address_name";	

$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,on_time,add_code,ref_id,return_ckk) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_1."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$on_time."','".$h_employee_name."','".$ref_id."','0')";

//echo $strSQL89;
//exit();

 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());


 
 $strSQL90 =  "insert into tb_transaction (running) 

values('".$nextId."')";

$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  hos__consig set job_no ='".$nextId."',send_cs ='2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
}

$strSQL89="Update  st__main set iv_no = '".$iv_no."',iv_no1 = '".$iv_no."'  where ref_idsale='".$ref_id."'";
$objQuery89 = mysqli_query($conn,$strSQL89);




	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminbrcshos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


