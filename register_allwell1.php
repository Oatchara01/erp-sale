<?php include ("head.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<style type="text/css">
<!--
.style8 {color: #6633FF; font-weight: bold; }
.style9 {
	color: #FF0000;
	font-weight: bold;
	font-size: 24px;
}

.style10 {
	color: #006600;
	font-weight: bold;
	font-size: 24px;
}
-->
</style>
</head>
<body>
<center></br></br>

<?php
include("dbconnect.php");
include("dbconnect_acc.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
	
$register_date = date("Y-m-d");
$register_time = date("H:i:s");
$sale_channel = $_POST["sale_channel"];

$ref_rentel	= $_POST["ref_rentel"];

/*if($sale_channel=='3'){
	
$delivery ='1';	
$employee_name ='SOL3';	
$delivery_date = date("Y-m-d");
$delivery_time ='ก่อน 15.00 น.';	
$delivery_type ='4';
	
}else{*/
	
$delivery = $_POST["delivery"];
$employee_name = $_POST["employee_name"];	
$delivery_date = $_POST["delivery_date"];
$delivery_time = $_POST["delivery_time"];	
$delivery_type = $_POST["delivery_type"];	
$que_ckk = $_POST["que_ckk"];	
//}
	
$select_type_doc = $_POST["select_type_doc"];
$billing_name = $_POST["billing_name"];
$billing_address = $_POST["billing_address"];
$billing_tel = $_POST["billing_tel"];
$bill_vat = '1';
$run_id = $_POST["run_id"];
$run_et = $_POST["run_et"];
$full_bill = $_POST["full_bill"];
$customer_name = $_POST["customer_name"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$province = $_POST["province"];
$postcode = $_POST["postcode"];
$tel = $_POST["tel"];
$delivery_place = $_POST["delivery_place"];
$delivery_contact = $_POST["delivery_contact"];
$withdraw_objective = $_POST["withdraw_objective"];
$payment = $_POST["payment"];
$bus_inter = $_POST["bus_inter"];
$email = $_POST["email"];	
$order_id = $_POST["order_id"];

	
$doc_time1 = $_POST["doc_time"];
if($doc_release_date !=''){	
$doc_time = date('H:i:s');	
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$admin_name = "$name $surname";
	
}else{
$admin_name = $_POST["admin_name"];	
$doc_time = $_POST["doc_time"];	
}

	
$other_payment = $_POST["other_payment"];
$big_car = $_POST["big_car"];

$call_before = $_POST["call_before"];
$assign_date_time = $_POST["assign_date_time"];
$maps = $_POST["maps"];
$approve_name = $_POST["approve_name"];
$discount = $_POST["discount"];
$sale_complete = $_POST["sale_complete"];
$sale_remark = $_POST["sale_remark"];
$sn = $_POST["sn"];
$bq = $_POST["bq"];
$ot = $_POST["ot"];
$delivery_company = $_POST["delivery_company"];
$et_ckk = $_POST["et_ckk"];
$returns = $_POST["returns"];
$return_date = $_POST["return_date"];
$return_time = $_POST["return_time"];
$return_address = $_POST["return_address"];
$return_contact = $_POST["return_contact"];
$prefer_name = $_POST["prefer_name"];
$po_no = $_POST["po_no"];
$delivery_contract = $_POST["delivery_contract"];
$clear_book_no = $_POST["clear_book_no"];
$clear_brn_no = $_POST["clear_brn_no"];
$clear_brnp_no = $_POST["clear_brnp_no"];
$type_type = $_POST["type_type"];
$type_type_detail = $_POST["type_type_detail"];
$install_place = $_POST["install_place"];
$account_approve = $_POST["account_approve"];
$amount = $_POST["amount"];
$transfer_date = $_POST["transfer_date"];
$order_name = $_POST["order_name"];
$order_delivery_date = $_POST["order_delivery_date"];
$order_refer_code = $_POST["order_refer_code"];
$clear_book_ckk = $_POST["clear_book_ckk"];
$tax_id = $_POST["tax_id"];
$clear_brn_no_ckk = $_POST["clear_brn_no_ckk"];
$clear_brnp_no_ckk = $_POST["clear_brnp_no_ckk"];
$sn_ckk = $_POST["sn_ckk"];
$bq_ckk = $_POST["bq_ckk"];
$ot_ckk = $_POST["ot_ckk"];
$transfer = $_POST["transfer"];
$buy_ckk = $_POST["buy_ckk"];
	
$ref_12 = $_POST["ref_12"];		
$ref_13 = $_POST["ref_13"];		
	

$ex_add = $_POST["ex_add"];
$ex_aumper = $_POST["ex_aumper"];
$ex_provin = $_POST["ex_provin"];
$ex_post = $_POST["ex_post"];	
$pre_name 	 = $_POST["pre_name"];	
$review_date_call = $_POST["review_date_call"];
$review_call_des = $_POST["review_call_des"];
$review_date = $_POST["review_date"];
$promotion_date = $_POST["promotion_date"];
$review_description = $_POST["review_description"];
$warranty_h = $_POST["warranty_h"];
$pr_no  = $_POST["pr_no"];
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$em_id =  $_SESSION['emid'];
$send_cs =  $_POST["send_cs"];
	if($_POST["bill_id"] !=''){
$bill_id =  $_POST["bill_id"];
	}else if($_POST["tel_1"] !=''){
$bill_id = $_POST["tel_1"];
	}else{
$customer_no1 = $_POST["customer_no1"];		
	}
$customer_no =  $_POST["customer_no"];
$tel_mem =  $_POST["tel_mem"];	
$have_order =  $_POST["have_order"];
$delivery_contact =  $_POST["delivery_contact"];
$slip_no =  $_POST["slip_no"];
	

if($run_et=='1'){
	
if($email==''){	
echo "<script language=\"JavaScript\">";
echo "alert('ของ Bill E-tax รบกวนใส่ E-mail ด้วยนะคะ');";
echo "window.history.go(-1);</script>";
exit();	

}
if($tax_id==''){	
echo "<script language=\"JavaScript\">";
echo "alert('ของ Bill E-tax รบกวนใส่เลขผู้เสียภาษีด้วยนะคะ');";
echo "window.history.go(-1);</script>";
exit();	

}	
}
	
	
	
/*if($payment =='37' and $_FILES['upload1']['name']==''){

echo "<script language=\"JavaScript\">";
echo "alert('กรุณแนบสลิปการรูดการ์ดหน้าโชว์รูมด้วยนะคะ');";
echo "window.history.go(-1);</script>";
exit();

}	*/
	

	

//extra address
$ex1customer_name =  $_POST["ex1customer_name"];
$ex1address1 = $_POST["ex1address1"];
$ex1address2 = $_POST["ex1address2"];
$ex1province = $_POST["ex1province"];
$ex1postcode = $_POST["ex1postcode"];
$ex1tel = $_POST["ex1tel"];

$ex2customer_name =  $_POST["ex2customer_name"];
$ex2address1 = $_POST["ex2address1"];
$ex2address2 = $_POST["ex2address2"];
$ex2province = $_POST["ex2province"];
$ex2postcode = $_POST["ex2postcode"];
$ex2tel = $_POST["ex2tel"];

$ex3customer_name =  $_POST["ex3customer_name"];
$ex3address1 = $_POST["ex3address1"];
$ex3address2 = $_POST["ex3address2"];
$ex3province = $_POST["ex3province"];
$ex3postcode = $_POST["ex3postcode"];
$ex3tel = $_POST["ex3tel"];

$ex4customer_name =  $_POST["ex4customer_name"];
$ex4address1 = $_POST["ex4address1"];
$ex4address2 = $_POST["ex4address2"];
$ex4province = $_POST["ex4province"];
$ex4postcode = $_POST["ex4postcode"];
$ex4tel = $_POST["ex4tel"];

$ex5customer_name =  $_POST["ex5customer_name"];
$ex5address1 = $_POST["ex5address1"];
$ex5address2 = $_POST["ex5address2"];
$ex5province = $_POST["ex5province"];
$ex5postcode = $_POST["ex5postcode"];
$ex5tel = $_POST["ex5tel"];

$ex6customer_name =  $_POST["ex6customer_name"];
$ex6address1 = $_POST["ex6address1"];
$ex6address2 = $_POST["ex6address2"];
$ex6province = $_POST["ex6province"];
$ex6postcode = $_POST["ex6postcode"];
$ex6tel = $_POST["ex6tel"];

$ex7customer_name =  $_POST["ex7customer_name"];
$ex7address1 = $_POST["ex7address1"];
$ex7address2 = $_POST["ex7address2"];
$ex7province = $_POST["ex7province"];
$ex7postcode = $_POST["ex7postcode"];
$ex7tel = $_POST["ex7tel"];

$ex8customer_name =  $_POST["ex8customer_name"];
$ex8address1 = $_POST["ex8address1"];
$ex8address2 = $_POST["ex8address2"];
$ex8province = $_POST["ex8province"];
$ex8postcode = $_POST["ex8postcode"];
$ex8tel = $_POST["ex8tel"];

$ex9customer_name =  $_POST["ex9customer_name"];
$ex9address1 = $_POST["ex9address1"];
$ex9address2 = $_POST["ex9address2"];
$ex9province = $_POST["ex9province"];
$ex9postcode = $_POST["ex9postcode"];
$ex9tel = $_POST["ex9tel"];
	
$comment_cs = $_POST["comment_cs"];	
$comment_en = $_POST["comment_en"];	
$comment_st = $_POST["comment_st"];	
$comment_ad = $_POST["comment_ad"];	
	
	

//end extra address	
	
$qfirst = "select * from so__main ORDER BY main_id DESC LIMIT 1";
$first = mysqli_query($conn,$qfirst);
$Num_Rows88 = mysqli_num_rows($first);
$ffirst = mysqli_fetch_array($first);
	
$ref_id = $ffirst['main_id']+1;
	
$sql9 = "SELECT slip_no FROM so__main where slip_no ='".$slip_no."' ";
$qry9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$Num_Rows88 = mysqli_num_rows($qry9);
$rs9 = mysqli_fetch_assoc($qry9);

	
/*if($slip_no !='' and  $select_type_doc=='3' and $Num_Rows88 > 0 ){

echo "<script language=\"JavaScript\">";
echo "alert('ได้มีการบันทึกเลขที่อ้างอิงสลิปการโอนเงินนี้ไปแล้วค่ะ');window.location='register_allwell.php';";
echo "</script>";
exit();

}	
	
if($Num_Rows88 > 0 and  $select_type_doc=='4'){

echo "<script language=\"JavaScript\">";
echo "alert('ได้มีการบันทึกเลขที่อ้างอิงสลิปการโอนเงินนี้ไปแล้วค่ะ');window.location='register_allwellnb.php';";
echo "</script>";
exit();

}		*/
	
	
//IE	
	

	
if($run_id=='1'){
if($select_type_doc =='3'){
	
$doc_release_date = date('Y-m-d');	
	
$date = explode('-' ,$doc_release_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_ptl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	
		
$save5="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."')";
$qsave5=mysqli_query($conn,$save5);
		
		
	}else if($select_type_doc =='4'){
	
$doc_release_date = date('Y-m-d');		
		
$date = explode('-' ,$doc_release_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";
$so1 = "/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_doc_nbm (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."')";
$qsave=mysqli_query($conn,$save);
		
	}
}else if($run_et=='1'){
	if($select_type_doc =='3'){
		
$doc_release_date = date('Y-m-d');			
	
$date = explode('-' , $doc_release_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_awl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	
		
$save5="insert into tb_et_awl (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."')";
$qsave5=mysqli_query($conn,$save5);
		
		
	}else if($select_type_doc =='4'){
		
$doc_release_date = date('Y-m-d');			
		
$date = explode('-' ,$doc_release_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";
$so1 = "-";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_et_nbm (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."')";
$qsave=mysqli_query($conn,$save);
	}
		
}else if($_POST["doc_no"] !=''){
	$doc_no = $_POST["doc_no"];
	$doc_release_date = $_POST["doc_release_date"]; 
	}else{
	$doc_no = "IV";
	$doc_release_date = $_POST["doc_release_date"]; 
	}
	
	

if($select_type_doc =='3'){
$save19="UPDATE tb_doc_ptl SET ref_so ='".$ref_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}else if($select_type_doc =='4'){
	
$save19="UPDATE tb_doc_nbm SET ref_so ='".$ref_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
}
	
	

/*if($select_type_doc =='3'){
$save19="UPDATE tb_et_awl SET ref_so ='".$ref_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}else if($select_type_doc =='4'){
	
$save19="UPDATE tb_et_nbm SET ref_so ='".$ref_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
}*/
	

	
if ($_FILES['upload1']['size'] != 0) {
$temp1 = explode(".", $_FILES["upload1"]["name"]);
$slip1 = "upload1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["upload1"]["tmp_name"], "upload/" . $slip1);
}	

if ($_FILES['upload2']['size'] != 0) {
$temp2 = explode(".", $_FILES["upload2"]["name"]);
$slip2 = "upload2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["upload2"]["tmp_name"], "upload/" . $slip2);
}	
	
if ($_FILES['upload3']['size'] != 0) {
$temp3 = explode(".", $_FILES["upload3"]["name"]);
$slip3 = "upload3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["upload3"]["tmp_name"], "upload/" . $slip3);
}	

if ($_FILES['upload4']['size'] != 0) {
$temp4 = explode(".", $_FILES["upload4"]["name"]);
$slip4 = "upload4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["upload4"]["tmp_name"], "upload/" . $slip4);
}	

if ($_FILES['upload5']['size'] != 0) {
$temp5 = explode(".", $_FILES["upload5"]["name"]);
$slip5 = "upload5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["upload5"]["tmp_name"], "upload/" . $slip5);
}	

if ($_FILES['upload_map']['size'] != 0) {
$tempmap = explode(".", $_FILES["upload_map"]["name"]);
$slipmap = "upload_map" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($tempmap);
move_uploaded_file($_FILES["upload_map"]["tmp_name"], "upload/" . $slipmap);
}	
	
	
	/*move_uploaded_file($_FILES['upload1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload1']['name']));
	move_uploaded_file($_FILES['upload2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload2']['name']));
	move_uploaded_file($_FILES['upload3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload3']['name']));
	move_uploaded_file($_FILES['upload4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload4']['name']));
	move_uploaded_file($_FILES['upload5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload5']['name']));
	move_uploaded_file($_FILES['upload_map']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload_map']['name']));*/	
	
	

			

	
if($sale_channel=='3' or $sale_channel =='4' or $sale_channel =='41'){	
$allwell_ckk ='1';
}else{
$allwell_ckk ='0';	
}
	
	

$save="insert into so__main
(ref_id,send_stock,register_date,register_time,sale_channel,select_type_doc,billing_name,billing_address,billing_tel,customer_name,address1,address2,province,postcode,tel,delivery_place,delivery_contact,withdraw_objective,payment,other_payment,delivery,big_car,delivery_date,delivery_time,call_before,assign_date_time,maps,employee_name,approve_name,discount,sale_complete,sale_remark,sn,bq,ot,delivery_type,returns,return_date,return_time,return_address,return_contact,prefer_name,po_no,delivery_contract,clear_book_no,clear_brn_no,clear_brnp_no,type_type,type_type_detail,install_place,account_approve,amount,transfer_date,order_id,order_name,order_delivery_date,order_refer_code,bill_vat,clear_book_ckk,upload1,upload2,upload3,upload4,upload5,status_doc,clear_brn_no_ckk,clear_brnp_no_ckk,sn_ckk,bq_ckk,ot_ckk,upload_map,transfer,review_date_call,review_call_des,review_date,pomotion_date,review_description,pr_no,add_by,send_cs,allwell_ckk,tax_id,bill_id,doc_release_date,doc_no,buy_ckk,customer_no,tel_mem,have_order,ex_add,ex_aumper,ex_provin,ex_post,pre_name,slip_no,admin_name,doc_time,que_ckk,email,et_ckk)
values
('$ref_id','1','$register_date','$register_time','$sale_channel','$select_type_doc','$billing_name','$billing_address','$billing_tel','$customer_name','$address1','$address2','$province','$postcode','$tel','$delivery_place','$delivery_contact','$withdraw_objective','$payment','$other_payment','$delivery','$big_car','$delivery_date','$delivery_time','$call_before','$assign_date_time','$maps','$employee_name','$approve_name','$discount','$sale_complete','$sale_remark','$sn','$bq','$ot','$delivery_type','$returns','$return_date','$return_time','$return_address','$return_contact','$prefer_name','$po_no','$delivery_contract','$clear_book_no','$clear_brn_no','$clear_brnp_no','$type_type','$type_type_detail','$install_place','$account_approve','$amount','$transfer_date','$order_id','$order_name','$order_delivery_date','$order_refer_code','$bill_vat','$clear_book_ckk','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','1','$clear_brn_no_ckk','$clear_brnp_no_ckk','$sn_ckk','$bq_ckk','$ot_ckk','".$slipmap."','$transfer','$review_date_call','$review_call_des','$review_date','$promotion_date','$review_description','$pr_no','".$add_by."','".$send_cs."','".$allwell_ckk."','".$tax_id."','".$bill_id."','".$doc_release_date."','".$doc_no."','".$buy_ckk."','".$customer_no."','".$tel_mem."','".$have_order."','".$ex_add."','".$ex_aumper."','".$ex_provin."','".$ex_post."','".$pre_name."','".$slip_no."','".$admin_name."','".$doc_time."','".$que_ckk."','".$email."','".$et_ckk."')";
	
$qsave=mysqli_query($conn,$save);
	
	
$save56="insert into tb_other_bill (ref_id,ref_12,ref_13) values ('".$ref_id."','".$ref_12."','".$ref_13."')";
$qsave56=mysqli_query($conn,$save56);		

$save57="insert into tb_comment_so (ref_id,comment_cs,comment_en,comment_st,comment_ad) values ('".$ref_id."','".$comment_cs."','".$comment_en."','".$comment_st."','".$comment_ad."')";
$qsave57=mysqli_query($conn,$save57);		
	
	
if($qsave){
	
//save extra address
if($ex1customer_name!='') //check if customer1 name is not null, then save in sql
{
$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','1','".$ex1customer_name."','".$ex1address1."','".$ex1address2."','".$ex1province."','".$ex1postcode."','".$ex1tel."')";
$e1save=mysqli_query($conn,$ex1save);
}
if($ex2customer_name!='') //check if customer2 name is not null, then save in sql
{
$ex2save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','2','".$ex2customer_name."','".$ex2address1."','".$ex2address2."','".$ex2province."','".$ex2postcode."','".$ex2tel."')";
$e2save=mysqli_query($conn,$ex2save);
}
if($ex3customer_name!='') //check if customer3 name is not null, then save in sql
{
$ex3save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','3','".$ex3customer_name."','".$ex3address1."','".$ex3address2."','".$ex3province."','".$ex3postcode."','".$ex3tel."')";
$e3save=mysqli_query($conn,$ex3save);
}
if($ex4customer_name!='') //check if customer4 name is not null, then save in sql
{
$ex4save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','4','".$ex4customer_name."','".$ex4address1."','".$ex4address2."','".$ex4province."','".$ex4postcode."','".$ex4tel."')";
$e4save=mysqli_query($conn,$ex4save);
}
if($ex5customer_name!='') //check if customer5 name is not null, then save in sql
{
$ex5save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','5','".$ex5customer_name."','".$ex5address1."','".$ex5address2."','".$ex5province."','".$ex5postcode."','".$ex5tel."')";
$e5save=mysqli_query($conn,$ex5save);
}
if($ex6customer_name!='') //check if customer6 name is not null, then save in sql
{	
$ex6save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','6','".$ex6customer_name."','".$ex6address1."','".$ex6address2."','".$ex6province."','".$ex6postcode."','".$ex6tel."')";
$e6save=mysqli_query($conn,$ex6save);
}
if($ex7customer_name!='') //check if customer7 name is not null, then save in sql
{
$ex7save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','7','".$ex7customer_name."','".$ex7address1."','".$ex7address2."','".$ex7province."','".$ex7postcode."','".$ex7tel."')";
$e7save=mysqli_query($conn,$ex7save);
}
if($ex8customer_name!='') //check if customer8 name is not null, then save in sql
{
$ex8save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','8','".$ex8customer_name."','".$ex8address1."','".$ex8address2."','".$ex8province."','".$ex8postcode."','".$ex8tel."')";
$e8save=mysqli_query($conn,$ex8save);
}
if($ex9customer_name!='') //check if customer9 name is not null, then save in sql
{
$ex9save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','9','".$ex9customer_name."','".$ex9address1."','".$ex9address2."','".$ex9province."','".$ex9postcode."','".$ex9tel."')";
$e9save=mysqli_query($conn,$ex9save);
}
//end save extra address	
	
	
$product_name1 = $_POST["product_name1"];	
$product_name2 = $_POST["product_name2"];	
$product_name3 = $_POST["product_name3"];	
$product_name4 = $_POST["product_name4"];	
$product_name5 = $_POST["product_name5"];	
$product_name6 = $_POST["product_name6"];	
$product_name7 = $_POST["product_name7"];	
$product_name8 = $_POST["product_name8"];	
$product_name9 = $_POST["product_name9"];	
$product_name10 = $_POST["product_name10"];	
	
	

 $between_date =$_POST["date_requir"];
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
if($select_type_doc=='3'){
$type_company ='ออลล์เวล ไลฟ์ บจก.';	
}else if($select_type_doc=='4'){
$type_company ='โนเบิล เมด บจก.';	
}
 $customer_name1=$_POST["customer_name1"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
	
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


$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);

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
	$more=$_POST["more"];	
	}else{
		$more='0';
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
if($sale_channel=='4'){
$mk_research  = '1';
	}else{
$mk_research  = $_POST["mk_research"];		
	}
	
	
	

$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,customer_contact,mk_research,add_code,bus_inter) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$mk_research."','".$em_id."','".$bus_inter."')";

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());


 $strSQL99 =  "insert into tb_transaction (ref_id,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$ref_id."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";


 $objQuery99 = mysqli_query($conn,$strSQL99) or die(mysqli_error());

$type = $_POST["type"];	
	
$strSQLrt = "SELECT *   FROM hos__rental where ref_id ='".$ref_rentel."' ";
$objQueryrt = mysqli_query($conn,$strSQLrt) or die(mysqli_error());
$objResultrt = mysqli_fetch_assoc($objQueryrt);
	
	

if($ref_rentel!='' and $type=='IV'){
$strSQL26="Update  hos__rental set ref_iv='".$ref_id."'  where ref_id='".$ref_rentel."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
}else if($ref_rentel!='' and $type=='AI'){
$strSQL26="Update  hos__rental set ref_ai='".$ref_id."'  where ref_id='".$ref_rentel."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
}else if($ref_rentel!=''){
	
$strSQLrt = "SELECT date_runiv  FROM hos__rental_runiv where ref_id ='".$ref_rentel."' ref_idren='".$ref_rentel."' and ref_idiv=''";
$objQueryrt = mysqli_query($conn,$strSQLrt) or die(mysqli_error());
$objResultrt = mysqli_fetch_assoc($objQueryrt);

$date_runiv = date('Y-m-d', strtotime($objResultrt["date_runiv"] . ' +30 days'));
	
$strSQL26="Update  hos__rental_runiv set ref_idiv='".$ref_id."',date_opiv='".$add_date."',add_by='".$add_by."',ckk_open='1'  where ref_idren='".$ref_rentel."' and ref_idiv=''";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
$save="insert into hos__rental_runiv
(ref_idren,date_runiv,sale_area) values ('".$ref_rentel."','".$date_runiv."','".$objResultrt["sale_area"]."')";
$qsave=mysqli_query($conn,$save);

	
	
	
}


	
	if($_SESSION["name"]=='ชลชินี'){
	
$strSQL25="Update  so__main set approve_complete='Approve'  where ref_id='".$ref_id."'";
//echo $strSQL25;
$objQuery25 = mysqli_query($conn,$strSQL25);
		
	}
		
if($send_cs =='1'){
		
	
include("dbconnect_cs.php");
	


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

$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,add_code,ref_id) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$em_id."','".$ref_id."')";

$objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());


 
 $strSQL90 =  "insert into tb_transaction (running,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$nextId."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";


$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  so__main set job_id='".$nextId."',send_cs='2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	

	
	}





	
$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remark1 = $_POST["sale_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$discount_unit1 = $_POST["discount_unit1"];
$warranty1  = $_POST["warranty1"];
$cal1 = $_POST["cal1"];
$pm1 = $_POST["pm1"];
$clear_br1 = $_POST["clear_br1"];
$sn1 = $_POST["sn1"];
$clear_ivno1 = $_POST["clear_ivno1"];
$jong_ckk1 = $_POST["jong_ckk1"];
$jong_no1 = $_POST["jong_no1"];


	
if($clear_ivno1 !=''){
	
	if($sn1 !=''){
$strSQL2 = "SELECT sn_number FROM  so__submain  WHERE clear_ivno ='".$clear_ivno1."' and product_id = '".$product_id1."' and sn_number = '".$product_sn1."' and clear_br = '1'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

	
$strSQL31 = "SELECT ref_id FROM hos__receive  WHERE iv_no = '".$clear_ivno1."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$objResult31 = mysqli_fetch_array($objQuery31);

	
$strSQL3 = "SELECT sn FROM   hos__subreceive  WHERE ref_idd = '".$objResult31["ref_id"]."' and product_id = '".$product_id1."' and sn = '".$sn1."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);


$strSQL12 = "SELECT sn FROM  hos__subso  WHERE clear_ivno ='".$clear_ivno1."' and product_id = '".$product_id1."' and sn = '".$sn1."' and clear_br = '1'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rows12 = mysqli_num_rows($objQuery12);		
		
		
if($Num_Rows2 > 0 or $Num_Rows12 > 0 ){
echo "<script language=\"JavaScript\">";
echo "alert('สินค้าหมายเลขเครื่อง$sn1มีการเคลียร์ยืมไปเรียบร้อยแล้วค่ะ');window.location='register_allwell_edit.php?ref_id=$ref_id';";
echo "</script>";
}else if ($Num_Rows3 > 0){
	
echo "<script language=\"JavaScript\">";
echo "alert('สินค้าหมายเลขเครื่อง$sn1มีการคืนสินค้าไปเรียบร้อยแล้วค่ะ');window.location='register_allwell_edit.php?ref_id=$ref_id';";
echo "</script>";
	
}else{
		
if($product_id1 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id1."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 =$sale_count1*$objResult31["unit1"];
$unit2 =$sale_count1*$objResult31["unit2"];
$unit3 =$sale_count1*$objResult31["unit3"];
$unit4 =$sale_count1*$objResult31["unit4"];
$unit5 =$sale_count1*$objResult31["unit5"];
$unit6 =$sale_count1*$objResult31["unit6"];
$unit7 =$sale_count1*$objResult31["unit7"];
$unit8 =$sale_count1*$objResult31["unit8"];
$unit9 =$sale_count1*$objResult31["unit9"];
$unit10 =$sale_count1*$objResult31["unit10"];
$name_bomsol =$objResult31["name_bomsol"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;	
	
$sale_remarkk1 = "$sale_remark1 $name_bomsol";
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$id_product1."','".$id_product1."','".$clear_br1."','".$sn1."','".$have_order."','".$clear_ivno1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{	
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."','".$clear_br1."','".$sn1."','".$have_order."','".$clear_ivno1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
}


		
}	
	}else{


$sql1 = "SELECT ref_id   FROM   so__main   where  doc_no = '".$clear_ivno1."' and cancel_ckk = '0'";

$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$sql2 = "SELECT sum(sale_count) as sale_count   FROM   so__submain   where  ref_idd = '".$rs1["ref_id"]."' and product_id = '".$product_id1."'";

$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);



$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$product_id1."' and clear_br = '1' and clear_ivno ='".$clear_ivno1."'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$product_id1."' and clear_br = '1' and clear_ivno ='".$clear_ivno1."'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_assoc($qry13);
	

$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where  iv_no = '".$clear_ivno1."' and product_id = '".$product_id1."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);

$sql2 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '".$product_id1."' and clear_br = '1' and br_no ='".$clear_ivno1."'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs2["count3"];
	
$count2 = $rs2["sale_count"] - ($count3+$count4+$count5+$count13);
		
if($count2=='0'){

$save="Update  so__submain set  clear_ckk = '1'    where ref_idd = '".$rs1["ref_id"]."' and product_id = '".$product_id1."'";
$qsave=mysqli_query($conn,$save);

}
		
		

if($count2 < 0){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบยืมนี้มีไม่พอในหารเคลียร์ยืมครั้งนี้ค่ะ');window.location='register_allwell_edit.php?ref_id=$ref_id';";
echo "</script>";


}else{

if($product_id1 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id1."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 =$sale_count1*$objResult31["unit1"];
$unit2 =$sale_count1*$objResult31["unit2"];
$unit3 =$sale_count1*$objResult31["unit3"];
$unit4 =$sale_count1*$objResult31["unit4"];
$unit5 =$sale_count1*$objResult31["unit5"];
$unit6 =$sale_count1*$objResult31["unit6"];
$unit7 =$sale_count1*$objResult31["unit7"];
$unit8 =$sale_count1*$objResult31["unit8"];
$unit9 =$sale_count1*$objResult31["unit9"];
$unit10 =$sale_count1*$objResult31["unit10"];
$name_bomsol =$objResult31["name_bomsol"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;		
$sale_remarkk1 = "$sale_remark1 $name_bomsol";
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$id_product1."','".$id_product1."','".$clear_br1."','".$sn1."','".$have_order."','".$clear_ivno1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{	
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."','".$clear_br1."','".$sn1."','".$have_order."','".$clear_ivno1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
}

}
	}
	
}else if($jong_no1 !=''){	
	
	

$strSQL = "SELECT * FROM hos__jongproduct WHERE iv_no = '".$jong_no1."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT * FROM hos__subjongpro  WHERE ref_idd = '".$objResult["ref_id"]."' and product_id ='".$product_id1."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult1['product_id']."' and jong_ckk = '1' and jong_no ='".$objResult["iv_no"]."'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult1['product_id']."' and jong_ckk = '1' and jong_no ='".$objResult["iv_no"]."'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_assoc($qry13);
	

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
	
$count2 = $objResult1["count"] - ($count3+$count13);

if($count2=='0'){

$strSQL1 = "Update  hos__subjongpro set  close_ckk ='1' where  ref_idd = '".$objResult["ref_id"]."' and product_id ='".$product_id1."'";
$objQuery1 = mysqli_query($conn,$strSQL1);


}

		
		

if($count2 < 0){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบจองนี้มีไม่พอในหารเคลียร์จองครั้งนี้ค่ะ');window.location='register_allwell_edit.php?ref_id=$ref_id';";
echo "</script>";


}else{

if($product_id1 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id1."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 =$sale_count1*$objResult31["unit1"];
$unit2 =$sale_count1*$objResult31["unit2"];
$unit3 =$sale_count1*$objResult31["unit3"];
$unit4 =$sale_count1*$objResult31["unit4"];
$unit5 =$sale_count1*$objResult31["unit5"];
$unit6 =$sale_count1*$objResult31["unit6"];
$unit7 =$sale_count1*$objResult31["unit7"];
$unit8 =$sale_count1*$objResult31["unit8"];
$unit9 =$sale_count1*$objResult31["unit9"];
$unit10 =$sale_count1*$objResult31["unit10"];
$name_bomsol =$objResult31["name_bomsol"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;		
$sale_remarkk1 = "$sale_remark1 $name_bomsol";
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$id_product1."','".$id_product1."','".$clear_br1."','".$sn1."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{	
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."','".$clear_br1."','".$sn1."','".$have_order."','".$clear_ivno1."','".$jong_no1."','".$jong_ckk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
}

}
	
	
	
}else{
if($product_id1 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id1."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 =$sale_count1*$objResult31["unit1"];
$unit2 =$sale_count1*$objResult31["unit2"];
$unit3 =$sale_count1*$objResult31["unit3"];
$unit4 =$sale_count1*$objResult31["unit4"];
$unit5 =$sale_count1*$objResult31["unit5"];
$unit6 =$sale_count1*$objResult31["unit6"];
$unit7 =$sale_count1*$objResult31["unit7"];
$unit8 =$sale_count1*$objResult31["unit8"];
$unit9 =$sale_count1*$objResult31["unit9"];
$unit10 =$sale_count1*$objResult31["unit10"];
$name_bomsol =$objResult31["name_bomsol"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;	
$sale_remarkk1 = "$sale_remark1 $name_bomsol";
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$id_product1."','".$id_product1."','".$clear_br1."','".$sn1."','".$have_order."','".$clear_ivno1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{	
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."','".$clear_br1."','".$sn1."','".$have_order."','".$clear_ivno1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
}
	
}
	


$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remark2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];
$warranty2  = $_POST["warranty2"];
$cal2 = $_POST["cal2"];
$pm2 = $_POST["pm2"];
$clear_br2 = $_POST["clear_br2"];
$sn2 = $_POST["sn2"];
$clear_ivno2 = $_POST["clear_ivno2"];	
$jong_no2 = $_POST["jong_no2"];	
$jong_ckk2 = $_POST["jong_ckk2"];	
	

$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remark3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];
$warranty3  = $_POST["warranty3"];
$cal3 = $_POST["cal3"];
$pm3 = $_POST["pm3"];
$clear_br3 = $_POST["clear_br3"];
$sn3 = $_POST["sn3"];
$clear_ivno3 = $_POST["clear_ivno3"];
$jong_no3 = $_POST["jong_no3"];	
$jong_ckk3 = $_POST["jong_ckk3"];	
	

$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remark4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];
$warranty4  = $_POST["warranty4"];
$cal4 = $_POST["cal4"];
$pm4 = $_POST["pm4"];
$clear_br4 = $_POST["clear_br4"];
$sn4 = $_POST["sn4"];
$clear_ivno4 = $_POST["clear_ivno4"];
$jong_no4 = $_POST["jong_no4"];	
$jong_ckk4 = $_POST["jong_ckk4"];	

$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remark5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_POST["discount_unit5"];
$warranty5  = $_POST["warranty5"];
$cal5 = $_POST["cal5"];
$pm5 = $_POST["pm5"];
$clear_br5 = $_POST["clear_br5"];
$sn5= $_POST["sn5"];
$clear_ivno5 = $_POST["clear_ivno5"];	
$jong_no5 = $_POST["jong_no5"];	
$jong_ckk5 = $_POST["jong_ckk5"];	
	

$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remark6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];
$warranty6  = $_POST["warranty6"];
$cal6 = $_POST["cal6"];
$pm6 = $_POST["pm6"];
$clear_br6 = $_POST["clear_br6"];
$sn6 = $_POST["sn6"];	
$clear_ivno6 = $_POST["clear_ivno6"];	
$jong_no6 = $_POST["jong_no6"];	
$jong_ckk6 = $_POST["jong_ckk6"];	
	

$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remark7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];
$warranty7  = $_POST["warranty7"];
$cal7 = $_POST["cal7"];
$pm7 = $_POST["pm7"];
$clear_br7 = $_POST["clear_br7"];
$sn7 = $_POST["sn7"];	
$clear_ivno7 = $_POST["clear_ivno7"];	
$jong_no7 = $_POST["jong_no7"];	
$jong_ckk7 = $_POST["jong_ckk7"];	

	
$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remark8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];
$warranty8  = $_POST["warranty8"];
$cal8 = $_POST["cal8"];
$pm8 = $_POST["pm8"];
$clear_br8 = $_POST["clear_br8"];
$sn8 = $_POST["sn8"];	
$clear_ivno8 = $_POST["clear_ivno8"];
$jong_no8 = $_POST["jong_no8"];	
$jong_ckk8 = $_POST["jong_ckk8"];	
	

$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remark9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];
$warranty9  = $_POST["warranty9"];
$cal9 = $_POST["cal9"];
$pm9 = $_POST["pm9"];
$clear_br9 = $_POST["clear_br9"];
$sn9 = $_POST["sn9"];	
$clear_ivno9 = $_POST["clear_ivno9"];	
$jong_no9 = $_POST["jong_no9"];	
$jong_ckk9 = $_POST["jong_ckk9"];	
	

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remark10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];
$warranty10  = $_POST["warranty10"];
$cal10 = $_POST["cal10"];
$pm10 = $_POST["pm10"];
$clear_br10 = $_POST["clear_br10"];
$sn10 = $_POST["sn10"];	
$clear_ivno10 = $_POST["clear_ivno10"];
$jong_no10 = $_POST["jong_no10"];	
$jong_ckk10 = $_POST["jong_ckk10"];	
	
	

$product_id11 = $_POST["product_id11"];
$sale_count11 = $_POST["sale_count11"];
$product_price11 = $_POST["product_price11"];
$sale_remarkk11 = $_POST["sale_remarkk11"];
$sum_amountt11 = $_POST["sum_amount11"];
$sum_amount11= str_replace(',','', $sum_amountt11);
$discount_unit11 = $_POST["discount_unit11"];
$warranty11  = $_POST["warranty11"];
$cal11 = $_POST["cal11"];
$pm11 = $_POST["pm11"];
$clear_br11 = $_POST["clear_br11"];
$sn11 = $_POST["sn11"];	
$clear_ivno11 = $_POST["clear_ivno11"];	
$jong_no11 = $_POST["jong_no11"];	
$jong_ckk11 = $_POST["jong_ckk11"];	
	

$product_id12 = $_POST["product_id12"];
$sale_count12 = $_POST["sale_count12"];
$product_price12 = $_POST["product_price12"];
$sale_remarkk12 = $_POST["sale_remarkk12"];
$sum_amountt12 = $_POST["sum_amount12"];
$sum_amount12= str_replace(',','', $sum_amountt12);
$discount_unit12 = $_POST["discount_unit12"];
$warranty12  = $_POST["warranty12"];
$cal12 = $_POST["cal12"];
$pm12 = $_POST["pm12"];
$clear_br12 = $_POST["clear_br12"];
$sn12 = $_POST["sn12"];	
$clear_ivno12 = $_POST["clear_ivno12"];	
$jong_no12 = $_POST["jong_no12"];	
$jong_ckk12 = $_POST["jong_ckk12"];	
	

$product_id13 = $_POST["product_id13"];
$sale_count13 = $_POST["sale_count13"];
$product_price13 = $_POST["product_price13"];
$sale_remarkk13 = $_POST["sale_remarkk13"];
$sum_amountt13 = $_POST["sum_amount13"];
$sum_amount13= str_replace(',','', $sum_amountt13);
$discount_unit13 = $_POST["discount_unit13"];
$warranty13  = $_POST["warranty13"];
$cal13 = $_POST["cal13"];
$pm13 = $_POST["pm13"];
$clear_br13 = $_POST["clear_br13"];
$sn13 = $_POST["sn13"];	
$clear_ivno13 = $_POST["clear_ivno13"];	
$jong_no13 = $_POST["jong_no13"];	
$jong_ckk13 = $_POST["jong_ckk13"];	
	

$product_id14 = $_POST["product_id14"];
$sale_count14 = $_POST["sale_count14"];
$product_price14 = $_POST["product_price14"];
$sale_remarkk14 = $_POST["sale_remarkk14"];
$sum_amountt14 = $_POST["sum_amount14"];
$sum_amount14= str_replace(',','', $sum_amountt14);
$discount_unit14 = $_POST["discount_unit14"];
$warranty14  = $_POST["warranty14"];
$cal14 = $_POST["cal14"];
$pm14 = $_POST["pm14"];
$clear_br14 = $_POST["clear_br14"];
$sn14 = $_POST["sn14"];	
$clear_ivno14 = $_POST["clear_ivno14"];	
$jong_no14 = $_POST["jong_no14"];	
$jong_ckk14 = $_POST["jong_ckk14"];	
	

$product_id15 = $_POST["product_id15"];
$sale_count15 = $_POST["sale_count15"];
$product_price15 = $_POST["product_price15"];
$sale_remarkk15 = $_POST["sale_remarkk15"];
$sum_amountt15 = $_POST["sum_amount15"];
$sum_amount15= str_replace(',','', $sum_amountt15);
$discount_unit15 = $_POST["discount_unit15"];
$warranty15  = $_POST["warranty15"];
$cal15 = $_POST["cal15"];
$pm15 = $_POST["pm15"];
$clear_br15 = $_POST["clear_br15"];
$sn15 = $_POST["sn15"];
$clear_ivno15 = $_POST["clear_ivno15"];
$jong_no15 = $_POST["jong_no15"];	
$jong_ckk15 = $_POST["jong_ckk15"];	





if($product_id2 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id2."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count2*$objResult31["unit1"];
$unit2 = $sale_count2*$objResult31["unit2"];
$unit3 = $sale_count2*$objResult31["unit3"];
$unit4 = $sale_count2*$objResult31["unit4"];
$unit5 = $sale_count2*$objResult31["unit5"];
$unit6 = $sale_count2*$objResult31["unit6"];
$unit7 = $sale_count2*$objResult31["unit7"];
$unit8 = $sale_count2*$objResult31["unit8"];
$unit9 = $sale_count2*$objResult31["unit9"];
$unit10 =$sale_count2*$objResult31["unit10"];
$name_bomsol =$objResult31["name_bomsol"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;		
$sale_remarkk2 = "$sale_remark2 $name_bomsol";
	

if($Num_Rows31 > 0){


if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$id_product1."','".$id_product1."','".$clear_br2."','".$sn2."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
	
	
$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_id2."','".$product_id2."','".$clear_br2."','".$sn2."','".$have_order."','".$clear_ivno2."','".$jong_no2."','".$jong_ckk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
}


if($product_id3 !==''  ){

	
$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id3."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count3*$objResult31["unit1"];
$unit2 = $sale_count3*$objResult31["unit2"];
$unit3 = $sale_count3*$objResult31["unit3"];
$unit4 = $sale_count3*$objResult31["unit4"];
$unit5 = $sale_count3*$objResult31["unit5"];
$unit6 = $sale_count3*$objResult31["unit6"];
$unit7 = $sale_count3*$objResult31["unit7"];
$unit8 = $sale_count3*$objResult31["unit8"];
$unit9 = $sale_count3*$objResult31["unit9"];
$unit10 =$sale_count3*$objResult31["unit10"];
$name_bomsol =$objResult31["name_bomsol"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;	
$sale_remarkk3 = "$sale_remark3 $name_bomsol";
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$id_product1."','".$id_product1."','".$clear_br3."','".$sn3."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
		
	
$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_id3."','".$product_id3."','".$clear_br3."','".$sn3."','".$have_order."','".$clear_ivno3."','".$jong_no3."','".$jong_ckk3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
	
}	
}

if($product_id4 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id4."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count4*$objResult31["unit1"];
$unit2 = $sale_count4*$objResult31["unit2"];
$unit3 = $sale_count4*$objResult31["unit3"];
$unit4 = $sale_count4*$objResult31["unit4"];
$unit5 = $sale_count4*$objResult31["unit5"];
$unit6 = $sale_count4*$objResult31["unit6"];
$unit7 = $sale_count4*$objResult31["unit7"];
$unit8 = $sale_count4*$objResult31["unit8"];
$unit9 = $sale_count4*$objResult31["unit9"];
$unit10 =$sale_count4*$objResult31["unit10"];
$name_bomsol =$objResult31["name_bomsol"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;	
$sale_remarkk4 = "$sale_remark4 $name_bomsol";
	

if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$id_product1."','".$id_product1."','".$clear_br4."','".$sn4."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
			
	
$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_id4."','".$product_id4."','".$clear_br4."','".$sn4."','".$have_order."','".$clear_ivno4."','".$jong_no4."','".$jong_ckk4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);
}	
}


if($product_id5 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id5."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count5*$objResult31["unit1"];
$unit2 = $sale_count5*$objResult31["unit2"];
$unit3 = $sale_count5*$objResult31["unit3"];
$unit4 = $sale_count5*$objResult31["unit4"];
$unit5 = $sale_count5*$objResult31["unit5"];
$unit6 = $sale_count5*$objResult31["unit6"];
$unit7 = $sale_count5*$objResult31["unit7"];
$unit8 = $sale_count5*$objResult31["unit8"];
$unit9 = $sale_count5*$objResult31["unit9"];
$unit10 =$sale_count5*$objResult31["unit10"];
$name_bomsol =$objResult31["name_bomsol"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;		
$sale_remarkk5 = "$sale_remark5 $name_bomsol";	
	

if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$id_product1."','".$id_product1."','".$clear_br5."','".$sn5."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
				
	
$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_id5."','".$product_id5."','".$clear_br5."','".$sn5."','".$have_order."','".$clear_ivno5."','".$jong_no5."','".$jong_ckk5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);
}	
}


if($product_id6 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id6."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count6*$objResult31["unit1"];
$unit2 = $sale_count6*$objResult31["unit2"];
$unit3 = $sale_count6*$objResult31["unit3"];
$unit4 = $sale_count6*$objResult31["unit4"];
$unit5 = $sale_count6*$objResult31["unit5"];
$unit6 = $sale_count6*$objResult31["unit6"];
$unit7 = $sale_count6*$objResult31["unit7"];
$unit8 = $sale_count6*$objResult31["unit8"];
$unit9 = $sale_count6*$objResult31["unit9"];
$unit10 =$sale_count6*$objResult31["unit10"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;	
$name_bomsol =$objResult31["name_bomsol"];
$sale_remarkk6 = "$sale_remark6 $name_bomsol";
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$id_product1."','".$id_product1."','".$clear_br6."','".$sn6."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
					
	
$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_id6."','".$product_id6."','".$clear_br6."','".$sn6."','".$have_order."','".$clear_ivno6."','".$jong_no6."','".$jong_ckk6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
}
}


if($product_id7 !==''  ){


$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id7."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count7*$objResult31["unit1"];
$unit2 = $sale_count7*$objResult31["unit2"];
$unit3 = $sale_count7*$objResult31["unit3"];
$unit4 = $sale_count7*$objResult31["unit4"];
$unit5 = $sale_count7*$objResult31["unit5"];
$unit6 = $sale_count7*$objResult31["unit6"];
$unit7 = $sale_count7*$objResult31["unit7"];
$unit8 = $sale_count7*$objResult31["unit8"];
$unit9 = $sale_count7*$objResult31["unit9"];
$unit10 =$sale_count7*$objResult31["unit10"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;	
$name_bomsol =$objResult31["name_bomsol"];
$sale_remarkk7 = "$sale_remark7 $name_bomsol";
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$id_product1."','".$id_product1."','".$clear_br7."','".$sn7."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
					
	

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_id7."','".$product_id7."','".$clear_br7."','".$sn7."','".$have_order."','".$clear_ivno7."','".$jong_no7."','".$jong_ckk7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);
	
}
}


if($product_id8 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id8."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count8*$objResult31["unit1"];
$unit2 = $sale_count8*$objResult31["unit2"];
$unit3 = $sale_count8*$objResult31["unit3"];
$unit4 = $sale_count8*$objResult31["unit4"];
$unit5 = $sale_count8*$objResult31["unit5"];
$unit6 = $sale_count8*$objResult31["unit6"];
$unit7 = $sale_count8*$objResult31["unit7"];
$unit8 = $sale_count8*$objResult31["unit8"];
$unit9 = $sale_count8*$objResult31["unit9"];
$unit10 =$sale_count8*$objResult31["unit10"];
$price =$objResult31["price"];
$sum_amount = $unit1*$price;	
$name_bomsol =$objResult31["name_bomsol"];
$sale_remarkk8 = "$sale_remark8 $name_bomsol";
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$id_product1."','".$id_product1."','".$clear_br8."','".$sn8."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
						
$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_id8."','".$product_id8."','".$clear_br8."','".$sn8."','".$have_order."','".$clear_ivno8."','".$jong_no8."','".$jong_ckk8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);
}	
}


if($product_id9 !==''  ){


$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id9."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count9*$objResult31["unit1"];
$unit2 = $sale_count9*$objResult31["unit2"];
$unit3 = $sale_count9*$objResult31["unit3"];
$unit4 = $sale_count9*$objResult31["unit4"];
$unit5 = $sale_count9*$objResult31["unit5"];
$unit6 = $sale_count9*$objResult31["unit6"];
$unit7 = $sale_count9*$objResult31["unit7"];
$unit8 = $sale_count9*$objResult31["unit8"];
$unit9 = $sale_count9*$objResult31["unit9"];
$unit10 =$sale_count9*$objResult31["unit10"];
$price =$objResult31["price"];	
$sum_amount = $unit1*$price;	
$name_bomsol =$objResult31["name_bomsol"];
$sale_remarkk9 = "$sale_remark9 $name_bomsol";
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$id_product1."','".$id_product1."','".$clear_br9."','".$sn9."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
						
	
$strSQL9 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$product_id9."','".$product_id9."','".$clear_br9."','".$sn9."','".$have_order."','".$clear_ivno9."','".$jong_no9."','".$jong_ckk9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);
	
}
}


if($product_id10 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id10."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count10*$objResult31["unit1"];
$unit2 = $sale_count10*$objResult31["unit2"];
$unit3 = $sale_count10*$objResult31["unit3"];
$unit4 = $sale_count10*$objResult31["unit4"];
$unit5 = $sale_count10*$objResult31["unit5"];
$unit6 = $sale_count10*$objResult31["unit6"];
$unit7 = $sale_count10*$objResult31["unit7"];
$unit8 = $sale_count10*$objResult31["unit8"];
$unit9 = $sale_count10*$objResult31["unit9"];
$unit10 =$sale_count10*$objResult31["unit10"];
$name_bomsol =$objResult31["name_bomsol"];
$price =$objResult31["price"];	
$sum_amount = $unit1*$price;		
$sale_remarkk10 = "$sale_remark10 $name_bomsol";	
	


if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$id_product1."','".$id_product1."','".$clear_br10."','".$sn10."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
							

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$product_id10."','".$product_id10."','".$clear_br10."','".$sn10."','".$have_order."','".$clear_ivno10."','".$jong_no10."','".$jong_ckk10."')";

	$objQuery10 = mysqli_query($conn,$strSQL10);
	
}
}


////////////

if($product_id11 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id11."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count11*$objResult31["unit1"];
$unit2 = $sale_count11*$objResult31["unit2"];
$unit3 = $sale_count11*$objResult31["unit3"];
$unit4 = $sale_count11*$objResult31["unit4"];
$unit5 = $sale_count11*$objResult31["unit5"];
$unit6 = $sale_count11*$objResult31["unit6"];
$unit7 = $sale_count11*$objResult31["unit7"];
$unit8 = $sale_count11*$objResult31["unit8"];
$unit9 = $sale_count11*$objResult31["unit9"];
$unit10 =$sale_count11*$objResult31["unit10"];
$price =$objResult31["price"];	
$sum_amount = $unit1*$price;
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk11."','".$discount_unit11."','".$warranty11."','".$cal11."','".$pm11."','".$id_product1."','".$id_product1."','".$clear_br11."','".$sn11."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk11."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk11."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk11."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk11."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk11."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk11."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk11."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk11."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk11."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
							
	

$strSQL11 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count11."','".$sale_count11."','".$product_price11."','".$product_price11."','".$sum_amount11."','".$sale_remarkk11."','".$discount_unit11."','".$warranty11."','".$cal11."','".$pm11."','".$product_id11."','".$product_id11."','".$clear_br11."','".$sn11."','".$have_order."','".$clear_ivno11."','".$jong_no11."','".$jong_ckk11."')";

	$objQuery11 = mysqli_query($conn,$strSQL11);
	
}
}

if($product_id12 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id12."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count12*$objResult31["unit1"];
$unit2 = $sale_count12*$objResult31["unit2"];
$unit3 = $sale_count12*$objResult31["unit3"];
$unit4 = $sale_count12*$objResult31["unit4"];
$unit5 = $sale_count12*$objResult31["unit5"];
$unit6 = $sale_count12*$objResult31["unit6"];
$unit7 = $sale_count12*$objResult31["unit7"];
$unit8 = $sale_count12*$objResult31["unit8"];
$unit9 = $sale_count12*$objResult31["unit9"];
$unit10 =$sale_count12*$objResult31["unit10"];
	
$price =$objResult31["price"];
$sum_amount = $unit1*$price;	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk12."','".$discount_unit12."','".$warranty12."','".$cal12."','".$pm12."','".$id_product1."','".$id_product1."','".$clear_br12."','".$sn12."','".$have_order."','".$clear_ivno12."','".$jong_no12."','".$jong_ckk12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk12."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno12."','".$jong_no12."','".$jong_ckk12."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk12."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno12."','".$jong_no12."','".$jong_ckk12."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk12."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno12."','".$jong_no12."','".$jong_ckk12."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk12."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno12."','".$jong_no12."','".$jong_ckk12."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk12."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno12."','".$jong_no12."','".$jong_ckk12."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk12."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno12."','".$jong_no12."','".$jong_ckk12."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk12."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno12."','".$jong_no12."','".$jong_ckk12."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk12."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk12."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno12."','".$jong_no12."','".$jong_ckk12."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
							

$strSQL12 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count12."','".$sale_count12."','".$product_price12."','".$product_price12."','".$sum_amount12."','".$sale_remarkk12."','".$discount_unit12."','".$warranty12."','".$cal12."','".$pm12."','".$product_id12."','".$product_id12."','".$clear_br12."','".$sn12."','".$clear_ivno12."','".$jong_no12."','".$jong_ckk12."')";

$objQuery12 = mysqli_query($conn,$strSQL12);

	
}
}

if($product_id13 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id13."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count13*$objResult31["unit1"];
$unit2 = $sale_count13*$objResult31["unit2"];
$unit3 = $sale_count13*$objResult31["unit3"];
$unit4 = $sale_count13*$objResult31["unit4"];
$unit5 = $sale_count13*$objResult31["unit5"];
$unit6 = $sale_count13*$objResult31["unit6"];
$unit7 = $sale_count13*$objResult31["unit7"];
$unit8 = $sale_count13*$objResult31["unit8"];
$unit9 = $sale_count13*$objResult31["unit9"];
$unit10 =$sale_count13*$objResult31["unit10"];

$price =$objResult31["price"];	
$sum_amount = $unit1*$price;	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk13."','".$discount_unit13."','".$warranty13."','".$cal13."','".$pm13."','".$id_product1."','".$id_product1."','".$clear_br13."','".$sn13."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk13."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk13."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk13."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk13."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk13."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk13."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk13."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk13."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk13."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
							

$strSQL13 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count13."','".$sale_count13."','".$product_price13."','".$product_price13."','".$sum_amount13."','".$sale_remarkk13."','".$discount_unit13."','".$warranty13."','".$cal13."','".$pm13."','".$product_id13."','".$product_id13."','".$clear_br13."','".$sn13."','".$have_order."','".$clear_ivno13."','".$jong_no13."','".$jong_ckk13."')";

$objQuery13 = mysqli_query($conn,$strSQL13);
	
}
}

if($product_id14 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id14."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count14*$objResult31["unit1"];
$unit2 = $sale_count14*$objResult31["unit2"];
$unit3 = $sale_count14*$objResult31["unit3"];
$unit4 = $sale_count14*$objResult31["unit4"];
$unit5 = $sale_count14*$objResult31["unit5"];
$unit6 = $sale_count14*$objResult31["unit6"];
$unit7 = $sale_count14*$objResult31["unit7"];
$unit8 = $sale_count14*$objResult31["unit8"];
$unit9 = $sale_count14*$objResult31["unit9"];
$unit10 =$sale_count14*$objResult31["unit10"];
$price =$objResult31["price"];	
$sum_amount = $unit1*$price;	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk14."','".$discount_unit14."','".$warranty14."','".$cal14."','".$pm14."','".$id_product1."','".$id_product1."','".$clear_br14."','".$sn14."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk14."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk14."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk14."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk14."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk14."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk14."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk14."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk14."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk14."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
							
	

$strSQL14 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count14."','".$sale_count14."','".$product_price14."','".$product_price14."','".$sum_amount14."','".$sale_remarkk14."','".$discount_unit14."','".$warranty14."','".$cal14."','".$pm14."','".$product_id14."','".$product_id14."','".$clear_br14."','".$sn14."','".$have_order."','".$clear_ivno14."','".$jong_no14."','".$jong_ckk14."')";

$objQuery14 = mysqli_query($conn,$strSQL14);
	
}	
}

if($product_id15 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id15."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count15*$objResult31["unit1"];
$unit2 = $sale_count15*$objResult31["unit2"];
$unit3 = $sale_count15*$objResult31["unit3"];
$unit4 = $sale_count15*$objResult31["unit4"];
$unit5 = $sale_count15*$objResult31["unit5"];
$unit6 = $sale_count15*$objResult31["unit6"];
$unit7 = $sale_count15*$objResult31["unit7"];
$unit8 = $sale_count15*$objResult31["unit8"];
$unit9 = $sale_count15*$objResult31["unit9"];
$unit10 =$sale_count15*$objResult31["unit10"];
$price =$objResult31["price"];	
$sum_amount = $unit1*$price;	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk15."','".$discount_unit15."','".$warranty15."','".$cal15."','".$pm15."','".$id_product1."','".$id_product1."','".$clear_br15."','".$sn15."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk15."','0.00','".$id_product2."','".$id_product2."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk15."','0.00','".$id_product3."','".$id_product3."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk15."','0.00','".$id_product4."','".$id_product4."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk15."','0.00','".$id_product5."','".$id_product5."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk15."','0.00','".$id_product6."','".$id_product6."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk15."','0.00','".$id_product7."','".$id_product7."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk15."','0.00','".$id_product8."','".$id_product8."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk15."','0.00','".$id_product9."','".$id_product9."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk15."','0.00','".$id_product10."','".$id_product10."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
							
		
	
$strSQL15 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk,clear_ivno,jong_no,jong_ckk)
values ('".$ref_id."','".$sale_count15."','".$sale_count15."','".$product_price15."','".$product_price15."','".$sum_amount15."','".$sale_remarkk15."','".$discount_unit15."','".$warranty15."','".$cal15."','".$pm15."','".$product_id15."','".$product_id15."','".$clear_br15."','".$sn15."','".$have_order."','".$clear_ivno15."','".$jong_no15."','".$jong_ckk15."')";

$objQuery15 = mysqli_query($conn,$strSQL15);
	
}
}




$save123 = " Update  so__submain set doc_release_date = '".$doc_release_date."',cus_no=$customer_no  where  ref_idd ='".$ref_id."'";
$qsave123 = mysqli_query($conn,$save123);	

}

	 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_allwell_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }	
	
if($qsave)
	{
	//บันทึกเรียบร้อย
	
	/*print " <img src='img/small_compleate.gif' />Save Successfully <br />";	*/
print " <img src='img/small_compleate.gif' /><span class='style10'>ref_id: </span><font color='0000ff'>".$ref_id." </font><span class='style10'>Save Successfully</span><br />";
	}
else
	{
    //บันทึกไม่ได
	
	print "<img src='img/false.png' /><span class='style9'> Error to save data </span><br />";

	}
	
}




?>

<p align="center"><a href="main_allwell.php"><span class="style18">กลับสู่หน้าหลัก</span></a></p>

</center>
</body>
</html>



