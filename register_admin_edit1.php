<?php
include("dbconnect.php");
include("dbconnect_cs.php");
include("dbconnect_acc.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
	$admin_complete = $_POST["admin_complete"];
	$main_id = $_POST["main_id"];
	$ref_id = $_POST["ref_id"];
	$register_date = $_POST["register_date"];
	$register_time = $_POST["register_time"];
	$sale_channel = $_POST["sale_channel"];
	$select_type_doc = $_POST["select_type_doc"];
	$delivery = $_POST["h_delivery"];
	$payment = $_POST["h_payment"];
	$sale_remark = $_POST["sale_remark"];
	$employee_name = $_POST["employee_name"];
	$buy_ckk = $_POST["buy_ckk"];
	$count_box = $_POST["count_box"];
	$doc_release_date = $_POST["doc_release_date"];
	$doc_time1 = $_POST["doc_time"];
	$ckkwar_pro = $_POST["ckkwar_pro"];	
	$ckk_showwar  = $_POST["ckk_showwar"];	
	$no_line = $_POST["no_line"];	
	
if($doc_release_date !='' and $doc_time1=='00:00:00'){	
	$doc_time = date('H:i:s');	
	$name =  $_SESSION['name'];
	$surname =	$_SESSION['surname'];
	$admin_name = "$name $surname";
} else {
	$admin_name = $_POST["admin_name"];	
	$doc_time = $_POST["doc_time"];	
}
$cash_ckk = $_POST["cash_ckk"];
$job_id = $_POST["job_id"];
$billing_name = $_POST["billing_name"];
$billing_address = $_POST["billing_address"];
$billing_tel = $_POST["billing_tel"];
$bill_vat = $_POST["bill_vat"];
$bill_id = $_POST["bill_id"];
$tax_id = $_POST["tax_id"];
$que_ckk = $_POST["que_ckk"];
$cancel_des = $_POST["cancel_des"];
$transfer = $_POST["transfer"];
$account_approve = $_POST["account_approve"];
$transfer_date = $_POST["transfer_date"];
$amount = $_POST["amount"];
$delivery_name = $_POST["delivery_name"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$province = $_POST["province"];
$postcode = $_POST["postcode"];
$tel = $_POST["tel"];
$pre_name = $_POST["pre_name"];
$prefer_name = $_POST["prefer_name"];
$po_no = $_POST["po_no"];
$delivery_contract = $_POST["delivery_contract"];
$clear_book_no = $_POST["clear_book_no"];
$clear_brn_no = $_POST["clear_brn_no"];
$clear_brnp_no = $_POST["clear_brnp_no"];
$sn = $_POST["sn"];
$bq = $_POST["bq"];
$ot = $_POST["ot"];
$install_place = $_POST["install_place"];
$type_type = $_POST["type_type"];
$type_type_detail = $_POST["type_type_detail"];
$delivery_date = $_POST["delivery_date"];
$delivery_time = $_POST["delivery_time"];
$big_car = $_POST["big_car"];
$call_before = $_POST["call_before"];
$maps = $_POST["maps"];
$assign_date_time = $_POST["assign_date_time"];
$delivery_type = $_POST["delivery_type"];
$delivery_place = $_POST["delivery_place"];
$delivery_contact = $_POST["delivery_contact"];
$returns = $_POST["returns"];
$return_date = $_POST["return_date"];
$return_time = $_POST["return_time"];
$return_address = $_POST["return_address"];
$return_contact = $_POST["return_contact"];
$customer_name = $_POST["customer_name"];
$order_id = $_POST["order_id"];
$iv_date = $_POST["iv_date"];
$cancel_ckk  = $_POST["cancel_ckk"];
$order_name = $_POST["order_name"];
$clear_book_ckk = $_POST["clear_book_ckk"];
$barcode=$_POST["barcode"];
$status_doc = $_POST["status_doc"];
$ckkdate_vat = $_POST["ckkdate_vat"];
$clear_brn_no_ckk = $_POST["clear_brn_no_ckk"];
$clear_brnp_no_ckk = $_POST["clear_brnp_no_ckk"];
$sn_ckk = $_POST["sn_ckk"];
$bq_ckk = $_POST["bq_ckk"];
$ot_ckk = $_POST["ot_ckk"];
$have_order = $_POST["have_order"];
$deposit_no = $_POST["deposit_no"];
$iv_no = $_POST["iv_no"];
$objective = $_POST["objective"];
$objective_des = $_POST["objective_des"];
$sr_no = $_POST["sr_no"];
$send_stock  = $_POST["send_stock"];
$send_brdoc = $_POST["send_brdoc"];
$date_ker = $_POST["date_ker"];
$ker_bath = $_POST["ker_bath"];
$run_id = $_POST["run_id"];
$bill_send = $_POST["bill_send"];
$order_refer_code = $_POST["order_refer_code"];
$order_refer_code1 = $_POST["order_refer_code1"];
$email = $_POST["email"];
$desnew_bill = $_POST["desnew_bill"];	
$et_ckk = $_POST["et_ckk"];
$ref_12 = $_POST["ref_12"];	
$ref_13 = $_POST["ref_13"];
	
$comment_cs = $_POST["comment_cs"];	
$comment_en = $_POST["comment_en"];	
$comment_st = $_POST["comment_st"];	
$comment_ad = $_POST["comment_ad"];	

	
	
	
$ex_add = $_POST["ex_add"];	
$ex_aumper = $_POST["ex_aumper"];	
$ex_provin = $_POST["ex_provin"];	
$ex_post = $_POST["ex_post"];	
$bus_inter = $_POST["bus_inter"];
$run_et = $_POST["run_et"];
$new_bill = $_POST["new_bill"];
$date_oldbill = $_POST["date_oldbill"];
	
if($run_et=='1' and $email==''){	
echo "<script language=\"JavaScript\">";
echo "alert('กรุณากรอกข้อมูลอีเมลล์ให้เรียบร้อยก่อนรันเลขที่่เอกสารค่ะ!!!!!!!!! ขอบคุณค่ะ');window.location='register_admin_edit.php?ref_id=$ref_id';";
echo "</script>";	
exit();	
}	
	
if($run_et=='1' and $tax_id==''){	
echo "<script language=\"JavaScript\">";
echo "alert('กรุณากรอกข้อมูลเลขผู้เสียภาษีให้เรียบร้อยก่อนรันเลขที่่เอกสารค่ะ!!!!!!!!! ขอบคุณค่ะ');window.location='register_admin_edit.php?ref_id=$ref_id';";
echo "</script>";	
exit();	
}	
	
$doc = substr($_POST["doc_no"],0,2);	
	
if($doc=='ET' and $email==''){	
echo "<script language=\"JavaScript\">";
echo "alert('กรุณากรอกข้อมูลอีเมลล์ให้เรียบร้อยค่ะ!!!!!!!!! ขอบคุณค่ะ');window.location='register_admin_edit.php?ref_id=$ref_id';";
echo "</script>";	
exit();	
}	
	
if($doc=='ET' and $tax_id==''){	
echo "<script language=\"JavaScript\">";
echo "alert('กรุณากรอกข้อมูลเลขผู้เสียภาษีให้เรียบร้อยค่ะ!!!!!!!!! ขอบคุณค่ะ');window.location='register_admin_edit.php?ref_id=$ref_id';";
echo "</script>";	
exit();	
}	
	
	
	
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
$line_stock = $_POST["line_stock"];
	
$run_brnp = $_POST["run_brnp"];	
	
//end post extra address

$date_edit = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$em_id =	$_SESSION['emid'];	
	
$send_erpst = $_POST["send_erpst"];
	
if($send_erpst =='1' and $line_stock==''){

echo "<script language=\"JavaScript\">";
echo "alert('กรุณาใส่หมายเหตุการแก้ไขด้วยนะคะ!!!!!!!!! ขอบคุณค่ะ');window.location='register_admin_edit.php?ref_id=$ref_id';";
echo "</script>";
exit();

}
	
	
if($cancel_ckk =='1' and $cancel_des==''){

echo "<script language=\"JavaScript\">";
echo "alert('กรุณาใส่หมายเหตุการยกเลิกด้วยนะคะ ขอบคุณค่ะ');window.location='register_admin_edit.php?ref_id=$ref_id';";
echo "</script>";
exit();

}
		
	
	
if($_FILES['upload1']['name']!=''){
 move_uploaded_file($_FILES['upload1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload1']['name']));
 $upload1=$_FILES['upload1']['name'];
}else{
 $upload1 = $_POST["upload1"];

}

if($_FILES['upload2']['name']!=''){
 move_uploaded_file($_FILES['upload2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload2']['name']));
 $upload2=$_FILES['upload2']['name'];
}else{
 $upload2 = $_POST["upload2"];

}

if($_FILES['upload3']['name']!=''){
 move_uploaded_file($_FILES['upload3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload3']['name']));
 $upload3=$_FILES['upload3']['name'];
}else{
 $upload3 = $_POST["upload3"];

}

if($_FILES['upload4']['name']!=''){
 move_uploaded_file($_FILES['upload4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload4']['name']));
 $upload4=$_FILES['upload4']['name'];
}else{
 $upload4 = $_POST["upload4"];

}

if($_FILES['upload5']['name']!=''){
 move_uploaded_file($_FILES['upload5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload5']['name']));
 $upload5=$_FILES['upload5']['name'];
}else{
 $upload5 = $_POST["upload5"];

}

if($_FILES['upload_map']['name']!=''){
 move_uploaded_file($_FILES['upload_map']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload_map']['name']));
 $upload_map=$_FILES['upload_map']['name'];
}else{
 $upload_map = $_POST["upload_map"];

}



if($run_id=='1'){
	if($select_type_doc =='3'){
	
$date = explode('-' , $_POST["doc_release_date"] );
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

$save5="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$_POST["doc_release_date"]."')";
$qsave5=mysqli_query($conn,$save5);
		
		
	}else if($select_type_doc =='4'){
		
$date = explode('-' , $_POST["doc_release_date"] );
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

$save="insert into tb_doc_nbm (doc_no,year_no,mount_no,run_no,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$_POST["doc_release_date"]."')";
$qsave=mysqli_query($conn,$save);
		
	}else if($select_type_doc =='1'){
		
$sql1 = "SELECT doc_no FROM tb_solptl where sale_channel = '".$sale_channel."' and date_sol = '".$doc_release_date."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);	
$num = $rs1["doc_no"];
	
if($Num_Rows>0){
	
	   echo "<script language=\"JavaScript\">";
echo "alert('วันนี้มีการเพิ่ม $num ช่องทางการขายนี้ของวันนี้แล้วค่ะ');window.location='add_solptl.php'";
echo "</script>";

}else{
$date = explode('-' , $_POST["doc_release_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
$yearMonth = $year1.$mont;
$sql = "SELECT MAX(doc_no) AS MAXID FROM tb_solptl";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so = "SOL";

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

$doc_no = $so.$nextId;
	

$save="insert into tb_solptl (doc_no,date_sol,sale_channel) values ('".$doc_no."','".$doc_release_date."','".$sale_channel ."')";
$qsave=mysqli_query($conn,$save);
}
		
	}else if($select_type_doc =='2'){
		
$sql1 = "SELECT doc_no FROM tb_solnbm where sale_channel = '".$sale_channel."' and date_sol = '".$doc_release_date."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);	

	
if($Num_Rows>0){
$doc_no = $rs1["doc_no"];	
}else{
$date = explode('-' , $_POST["doc_release_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
$yearMonth = $year1.$mont;
$sql = "SELECT MAX(doc_no) AS MAXID FROM tb_solnbm";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so = "SOL/";

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

$doc_no = $so.$nextId;
	

$save="insert into tb_solnbm (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$doc_release_date."','".$sale_channel ."')";
$qsave=mysqli_query($conn,$save);
		
	}
}
}else if($run_et=='1'){
	if($select_type_doc =='3'){
	
$date = explode('-' , $_POST["doc_release_date"] );
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
		
$date = explode('-' , $_POST["doc_release_date"] );
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
	
}else if($run_brnp=='1'){	
	
if($select_type_doc =='1'){
	
$date = explode('-' , $_POST["doc_release_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);	
	

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BRNP' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BRNP";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BRNP','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($select_type_doc =='2'){

$date = explode('-' , $_POST["doc_release_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);	
	
$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BRN.P' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BRN.P";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BRN.P','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);


	}	
	
	
	
}else{
$doc_no = $_POST["doc_no"];
}
	

	
if($select_type_doc =='3'){
$save19="UPDATE tb_doc_ptl SET ref_so ='".$ref_id."',iv_date='".$doc_release_date."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}else if($select_type_doc =='4'){
	
$save19="UPDATE tb_doc_nbm SET ref_so ='".$ref_id."',iv_date='".$doc_release_date."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
}
	
	
if($select_type_doc =='3'){
$save19="UPDATE tb_et_awl SET ref_so ='".$ref_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}else if($select_type_doc =='4'){
	
$save19="UPDATE tb_et_nbm SET ref_so ='".$ref_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
}
	
	
	
$docoo = substr($doc_no,0,2);	
	
if($docoo=='ET'){	
	
$strSQL701 = "UPDATE so__main SET import_etax='2' where ref_id ='".$ref_id."' ";
$objQuery701 = mysqli_query($conn,$strSQL701);	
		
}	
	
//update address
$save=" Update  so__main set
ref_id='$ref_id',register_date='$register_date',register_time='$register_time',sale_channel='$sale_channel',select_type_doc='$select_type_doc',delivery='$delivery',payment='$payment',sale_remark='$sale_remark',employee_name='$employee_name',doc_no='$doc_no',doc_release_date='$doc_release_date',job_id='$job_id',billing_name='$billing_name',billing_address='$billing_address',billing_tel='$billing_tel',tax_id='$tax_id',bill_vat = '$bill_vat',transfer='$transfer',account_approve='$account_approve',transfer_date='$transfer_date',amount='$amount',delivery_name='$delivery_name',address1='$address1',address2='$address2',province='$province',postcode='$postcode',tel='$tel',prefer_name='$prefer_name',po_no='$po_no',delivery_contract='$delivery_contract',clear_book_no='$clear_book_no',clear_brn_no='$clear_brn_no',clear_brnp_no='$clear_brnp_no',sn='$sn',bq='$bq',ot='$ot',install_place='$install_place',type_type='$type_type',type_type_detail='$type_type_detail',delivery_date='$delivery_date',delivery_time='$delivery_time',big_car='$big_car',call_before='$call_before',maps='$maps',assign_date_time='$assign_date_time',delivery_type='$delivery_type',delivery_place='$delivery_place',delivery_contact='$delivery_contact',returns='$returns',return_date='$return_date',return_time='$return_time',return_address='$return_address',return_contact='$return_contact',admin_complete='$admin_complete',order_id='$order_id',order_name='$order_name',clear_book_ckk='$clear_book_ckk',status_doc='$status_doc',upload1='".$upload1."',upload2='".$upload2."',upload3='".$upload3."',upload4='".$upload4."',upload5='".$upload5."',customer_name='$customer_name',clear_brn_no_ckk='$clear_brn_no_ckk',clear_brnp_no_ckk='$clear_brnp_no_ckk',sn_ckk='$sn_ckk',bq_ckk='$bq_ckk',ot_ckk='$ot_ckk',deposit_no='$deposit_no',upload_map='$upload_map',iv_no ='$iv_no',objective='$objective',sr_no='".$sr_no."',iv_date = '".$iv_date."',cancel_ckk ='".$cancel_ckk."',send_stock = '".$send_stock."',bill_id = '".$bill_id."',cash_ckk='".$cash_ckk."',bill_send = '".$bill_send."',buy_ckk='".$buy_ckk."',ckkdate_vat='".$ckkdate_vat."',objective ='".$objective."',objective_des='".$objective_des."',have_order = '".$have_order."',order_refer_code='".$order_refer_code."',cancel_des='".$cancel_des."',date_ker='".$date_ker."',ker_bath='".$ker_bath."',order_refer_code1='".$order_refer_code1."',ex_post='".$ex_post."',ex_provin='".$ex_provin."',ex_aumper='".$ex_aumper."',ex_add='".$ex_add."',pre_name='".$pre_name."',que_ckk='".$que_ckk."',doc_time='".$doc_time."',admin_name='".$admin_name."',count_box='".$count_box."',ckkwar_pro='".$ckkwar_pro."',ckk_showwar='".$ckk_showwar."',date_oldbill='".$date_oldbill."',new_bill='".$new_bill."',email='".$email."',desnew_bill='".$desnew_bill."',et_ckk='".$et_ckk."'  where  main_id ='$main_id'";

$qsave=mysqli_query($conn,$save);
	
	
$strSQLco = "SELECT ref_id FROM tb_comment_so WHERE ref_id = '".$ref_id."' ";
$objQueryco = mysqli_query($conn,$strSQLco) or die(mysqli_error());
$objResultco = mysqli_fetch_array($objQueryco);
	
if($objResultco["ref_id"]!=''){	
	
$save57="Update tb_comment_so  SET comment_cs='".$comment_cs."',comment_en='".$comment_en."',comment_st='".$comment_st."',comment_ad='".$comment_ad."'	 where  ref_id ='".$ref_id."'";
$qsave57=mysqli_query($conn,$save57);
	
}else{

$save57="insert into tb_comment_so (ref_id,comment_cs,comment_en,comment_st,comment_ad) values ('".$ref_id."','".$comment_cs."','".$comment_en."','".$comment_st."','".$comment_ad."')";
$qsave57=mysqli_query($conn,$save57);		
}
	


$sql23 = "SELECT * FROM tb_other_bill where ref_id = '".$ref_id."'";
$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_assoc($qry23);
	
if($rs23["ref_id"]!=''){	
$save56="Update tb_other_bill SET ref_12='".$ref_12."',ref_13='".$ref_13."' where  ref_id ='".$ref_id."'";
$qsave56=mysqli_query($conn,$save56);
}else{
$save56="insert into tb_other_bill (ref_id,ref_12,ref_13) values ('".$ref_id."','".$ref_12."','".$ref_13."')";
$qsave56=mysqli_query($conn,$save56);		
}	
		
	
	
if($sale_channel=='3' or $sale_channel=='4'){	
if($job_id!=''){
$save8="Update  tb_register_data set product_sn='".$doc_no."'  where running='".$job_id."'";
$qsave8=mysqli_query($com1,$save8);		
	
}
}
	
	
$id_ref = $_POST["id_ref"];	
$customer_nameb = $_POST["customer_nameb"];
$customer_telb = $_POST["customer_telb"];
$address_nameb = $_POST["address_nameb"];

if($id_ref !='' and $customer_nameb !=''){	
	
$save8="Update  tb_delivery_bill set customer_nameb='".$customer_nameb."',customer_telb='".$customer_telb."',address_nameb='".$address_nameb."'  where ref_id='".$ref_id."'";
$qsave8=mysqli_query($conn,$save8);	
}else if($customer_nameb !=''){

	
$save8 = "insert into tb_delivery_bill
(ref_id,customer_nameb,customer_telb,address_nameb) values ('".$ref_id."','".$customer_nameb."','".$customer_telb."','".$address_nameb."')";
$qsave8=mysqli_query($conn,$save8);	
	
}	
	
	
	
	

if($cancel_ckk=='1'){
		
		
$save55="Update  so__submain set status_sol='ยกเลิก'  where ref_idd='".$ref_id."'";
$qsave55=mysqli_query($conn,$save55);
	
$strSQLde = "DELETE FROM tb__buyecomercs1 WHERE ref_id = '".$ref_id."'";
$objQueryde = mysqli_query($conn,$strSQLde);	
	
	}

	
$save77 = " Update  tb__buyecomercs1 set doc_no = '".$doc_no."', doc_date = '".$doc_release_date."'  where  ref_id ='".$ref_id."'";
$qsave77 = mysqli_query($conn,$save77);	
	

$save77 = " Update  hos__proreceive set iv_noref = '$doc_no'  where  ref_iddoc ='".$ref_id."'";
$qsave77 = mysqli_query($conn,$save77);	

//ที่อยู่เพิ่มเติม 1
$strSQL16 = "SELECT *  FROM so__extraaddress WHERE ref_id='".$ref_id."' AND extra='1' ";
$qry16 = mysqli_query($conn,$strSQL16);
$Num_Rows16 = mysqli_num_rows($qry16);
//echo $strSQL16;
if ($Num_Rows16 > 0) // if have data
{	//echo "Record exists";
	$ex1save = "Update so__extraaddress set extra='1',customer_name='".$ex1customer_name."',address1='".$ex1address1."',address2='".$ex1address2."',province='".$ex1province."',postcode='".$ex1postcode."',tel='".$ex1tel."' where  ref_id ='".$ref_id."' and extra='1'";

	$e1save=mysqli_query($conn,$ex1save);
}
else //if no data, create new 
{	//echo "Record not exists";
	if($ex1address1 !='') //check if address is not null, create data in database
	{
	$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','1','".$ex1customer_name."','".$ex1address1."','".$ex1address2."','".$ex1province."','".$ex1postcode."','".$ex1tel."')";
	$e1save=mysqli_query($conn,$ex1save);
	}
	//echo "Record1 not exists and no address";
}

//ที่อยู่เพิ่มเติม 2
$strSQL17 = "SELECT * FROM so__extraaddress WHERE ref_id='".$ref_id."' AND extra='2' ";
$qry17 = mysqli_query($conn,$strSQL17);
$Num_Rows17 = mysqli_num_rows($qry17);
if ($Num_Rows17 > 0) // if have data
{
	$ex1save = "Update so__extraaddress set ref_id='$ref_id',extra='2',customer_name='$ex2customer_name',address1='$ex2address1',address2='$ex2address2',province='$ex2province',postcode='$ex2postcode',tel='$ex2tel' where  ref_id ='$ref_id' and extra='2'";
	$e1save=mysqli_query($conn,$ex1save);
}
else //if no data, create new 
{
	if($ex2address1 !='') //check if address is not null, create data in database
	{
	$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','2','".$ex2customer_name."','".$ex2address1."','".$ex2address2."','".$ex2province."','".$ex2postcode."','".$ex2tel."')";
	$e1save=mysqli_query($conn,$ex1save);
	}
	//echo "Record2 not exists and no address";
}

//ที่อยู่เพิ่มเติม 3
$strSQL18 = "SELECT * FROM so__extraaddress WHERE ref_id='".$ref_id."' AND extra='3' ";
$qry18 = mysqli_query($conn,$strSQL18);
$Num_Rows18 = mysqli_num_rows($qry18);
if ($Num_Rows18 > 0) // if have data
{
	$ex1save = "Update so__extraaddress set ref_id='$ref_id',extra='3',customer_name='$ex3customer_name',address1='$ex3address1',address2='$ex3address2',province='$ex3province',postcode='$ex3postcode',tel='$ex3tel' where  ref_id ='$ref_id' and extra='3'";
	$e1save=mysqli_query($conn,$ex1save);
}
else //if no data, create new 
{
	if($ex3address1 !='') //check if address is not null, create data in database
	{
	$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','3','".$ex3customer_name."','".$ex3address1."','".$ex3address2."','".$ex3province."','".$ex3postcode."','".$ex3tel."')";
	$e1save=mysqli_query($conn,$ex1save);
	}
	//echo "Record3 not exists and no address";
}
//ที่อยู่เพิ่มเติม 4
$strSQL19 = "SELECT * FROM so__extraaddress WHERE ref_id='".$ref_id."' AND extra='4' ";
$qry19 = mysqli_query($conn,$strSQL19);
$Num_Rows19 = mysqli_num_rows($qry19);
if ($Num_Rows19 > 0) // if have data
{
	$ex1save = "Update so__extraaddress set ref_id='$ref_id',extra='4',customer_name='$ex4customer_name',address1='$ex4address1',address2='$ex4address2',province='$ex4province',postcode='$ex4postcode',tel='$ex4tel' where  ref_id ='$ref_id' and extra='4'";
	$e1save=mysqli_query($conn,$ex1save);
}
else //if no data, create new 
{
	if($ex4address1 !='') //check if address is not null, create data in database
	{
	$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','4','".$ex4customer_name."','".$ex4address1."','".$ex4address2."','".$ex4province."','".$ex4postcode."','".$ex4tel."')";
	$e1save=mysqli_query($conn,$ex1save);
	}
	//echo "Record4 not exists and no address";
}
//ที่อยู่เพิ่มเติม 5
$strSQL20 = "SELECT * FROM so__extraaddress WHERE ref_id='".$ref_id."' AND extra='5' ";
$qry20 = mysqli_query($conn,$strSQL20);
$Num_Rows20 = mysqli_num_rows($qry20);
if ($Num_Rows20 > 0) // if have data
{
	$ex1save = "Update so__extraaddress set ref_id='$ref_id',extra='5',customer_name='$ex5customer_name',address1='$ex5address1',address2='$ex5address2',province='$ex5province',postcode='$ex5postcode',tel='$ex5tel' where  ref_id ='$ref_id' and extra='5'";
	$e1save=mysqli_query($conn,$ex1save);
}
else //if no data, create new 
{
	if($ex5address1 !='') //check if address is not null, create data in database
	{
	$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','5','".$ex5customer_name."','".$ex5address1."','".$ex5address2."','".$ex5province."','".$ex5postcode."','".$ex5tel."')";
	$e1save=mysqli_query($conn,$ex1save);
	}
	//echo "Record5 not exists and no address";
}
//ที่อยู่เพิ่มเติม 6
$strSQL22 = "SELECT * FROM so__extraaddress WHERE ref_id='".$ref_id."' AND extra='6' ";
$qry22 = mysqli_query($conn,$strSQL22);
$Num_Rows22 = mysqli_num_rows($qry22);
if ($Num_Rows22 > 0) // if have data
{
	$ex1save = "Update so__extraaddress set ref_id='$ref_id',extra='6',customer_name='$ex6customer_name',address1='$ex6address1',address2='$ex6address2',province='$ex6province',postcode='$ex6postcode',tel='$ex6tel' where  ref_id ='$ref_id' and extra='6'";
	$e1save=mysqli_query($conn,$ex1save);
}
else //if no data, create new 
{
	if($ex6address1 !='') //check if address is not null, create data in database
	{
	$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','6','".$ex6customer_name."','".$ex6address1."','".$ex6address2."','".$ex6province."','".$ex6postcode."','".$ex6tel."')";
	$e1save=mysqli_query($conn,$ex1save);
	}
	//echo "Record6 not exists and no address";
}
//ที่อยู่เพิ่มเติม 7
$strSQL23 = "SELECT * FROM so__extraaddress WHERE ref_id='".$ref_id."' AND extra='7' ";
$qry23 = mysqli_query($conn,$strSQL23);
$Num_Rows23 = mysqli_num_rows($qry23);
if ($Num_Rows23 > 0) // if have data
{
	$ex1save = "Update so__extraaddress set ref_id='$ref_id',extra='7',customer_name='$ex7customer_name',address1='$ex7address1',address2='$ex7address2',province='$ex7province',postcode='$ex7postcode',tel='$ex7tel' where  ref_id ='$ref_id' and extra='7'";
	$e1save=mysqli_query($conn,$ex1save);
}
else //if no data, create new 
{
	if($ex7address1 !='') //check if address is not null, create data in database
	{
	$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','7','".$ex7customer_name."','".$ex7address1."','".$ex7address2."','".$ex7province."','".$ex7postcode."','".$ex7tel."')";
	$e1save=mysqli_query($conn,$ex1save);
	}
	//echo "Record7 not exists and no address";
}
//ที่อยู่เพิ่มเติม 8
$strSQL24 = "SELECT * FROM so__extraaddress WHERE ref_id='".$ref_id."' AND extra='8' ";
$qry24 = mysqli_query($conn,$strSQL24);
$Num_Rows24 = mysqli_num_rows($qry24);
if ($Num_Rows24 > 0) // if have data
{
	$ex1save = "Update so__extraaddress set ref_id='$ref_id',extra='8',customer_name='$ex8customer_name',address1='$ex8address1',address2='$ex8address2',province='$ex8province',postcode='$ex8postcode',tel='$ex8tel' where  ref_id ='$ref_id' and extra='8'";
	$e1save=mysqli_query($conn,$ex1save);
}
else //if no data, create new 
{
	if($ex8address1 !='') //check if address is not null, create data in database
	{
	$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','8','".$ex8customer_name."','".$ex8address1."','".$ex8address2."','".$ex8province."','".$ex8postcode."','".$ex8tel."')";
	$e1save=mysqli_query($conn,$ex1save);
	}
	//echo "Record8 not exists and no address";
}
//ที่อยู่เพิ่มเติม 9
$strSQL25 = "SELECT * FROM so__extraaddress WHERE ref_id='".$ref_id."' AND extra='9' ";
$qry25 = mysqli_query($conn,$strSQL25);
$Num_Rows25 = mysqli_num_rows($qry25);
if ($Num_Rows25 > 0) // if have data
{
	$ex1save = "Update so__extraaddress set ref_id='$ref_id',extra='9',customer_name='$ex9customer_name',address1='$ex9address1',address2='$ex9address2',province='$ex9province',postcode='$ex9postcode',tel='$ex9tel' where  ref_id ='$ref_id' and extra='9'";
	$e1save=mysqli_query($conn,$ex1save);
}
else //if no data, create new 
{
	if($ex9address1 !='') //check if address is not null, create data in database
	{
	$ex1save = "insert into so__extraaddress (ref_id,extra,customer_name,address1,address2,province,postcode,tel) values ('".$ref_id."','9','".$ex9customer_name."','".$ex9address1."','".$ex9address2."','".$ex9province."','".$ex9postcode."','".$ex9tel."')";
	$e1save=mysqli_query($conn,$ex1save);
	}
	//echo "Record9 not exists and no address";
}
//end save ที่อยู่เพิ่มเติม
//if($select_type_doc=='1' or $select_type_doc =='2'){
if ($iv_no != '') {

    $strSQL = "SELECT ref_id, order_id FROM st__main WHERE order_id = '".$order_id."' and ref_idsale = '".$ref_id."'";
	$objQuery = mysqli_query($new, $strSQL);

    if (!$objQuery) {
        die("Query Error: " . mysqli_error($conn));
    }

    $objResult = mysqli_fetch_array($objQuery);

    if ($objResult) {

        $sqlUpdateMain = "UPDATE st__main 
                          SET iv_no1 = '$iv_no'  
                          WHERE order_id = '".$order_id."' and ref_idsale = '".$ref_id."'";
        $qUpdateMain = mysqli_query($new, $sqlUpdateMain);

        if (!$qUpdateMain) {
            die("Update st__main Error: " . mysqli_error($conn));
        }

        $sqlUpdateSbmain = "UPDATE st__sbmain 
                            SET stock_remark = '$iv_no', type_doc = '1'  
                            WHERE ref_idd = '".$objResult["ref_id"]."'";
        $qUpdateSbmain = mysqli_query($new, $sqlUpdateSbmain);

        if (!$qUpdateSbmain) {
            die("Update st__sbmain Error: " . mysqli_error($conn));
        }
    }

} else {

    $strSQL = "SELECT ref_id, ref_idsale FROM st__main WHERE ref_idsale = '".$ref_id."'";
    $objQuery = mysqli_query($new, $strSQL);

    if (!$objQuery) {
        die("Query Error: " . mysqli_error($conn));
    }

    $objResult = mysqli_fetch_array($objQuery);

    if ($objResult) {

        $sqlUpdateMain = "UPDATE st__main 
                          SET iv_no = '$doc_no'  
                          WHERE ref_id = '".$objResult["ref_id"]."'";
        $qUpdateMain = mysqli_query($new, $sqlUpdateMain);

        if (!$qUpdateMain) {
            die("Update st__main Error: " . mysqli_error($conn));
        }

        if ($select_type_doc == '1' || $select_type_doc == '2') {
            $type_doc = '3';
        } else {
            $type_doc = '1';
        }

        $sqlUpdateSbmain = "UPDATE st__sbmain 
                            SET type_doc = '$type_doc'  
                            WHERE ref_idd = '".$objResult["ref_id"]."'";
        $qUpdateSbmain = mysqli_query($new, $sqlUpdateSbmain);

        if (!$qUpdateSbmain) {
            die("Update st__sbmain Error: " . mysqli_error($conn));
        }
    }
}
//}
	
/*if($iv_no ==''){
$strSQL89="Update  st__main set iv_no1 = '".$doc_no."'  where ref_idsale='".$ref_id."'";
$objQuery89 = mysqli_query($conn,$strSQL89);	
}*/
	
if($send_brdoc =='1'){	
	
	
	$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');

$save9="insert into tb_register_br
(company,br_date,iv_no,customer_name,add_by,add_date,ref_id) values ('".$select_type_doc."','".$doc_release_date."','".$doc_no."','".$customer_name."','".$add_by."','".$add_date."','".$ref_id."')";

$qsave9=mysqli_query($conn,$save9);

$save3="Update   so__main set send_brdoc = '2' where ref_id ='".$ref_id."'";
$qsave3=mysqli_query($conn,$save3);
	
}


$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$sale_countref = $_POST["sale_countref"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$warranty =$_POST["warranty"];
 $pm=$_POST["pm"];
 $cal=$_POST["cal"];
 $product_id = $_POST["product_id"];
 $discount_unit = $_POST["discount_unit"];
$product_priceref = $_POST["product_priceref"];
$clear_ivno  = $_POST["clear_ivno"];
$clear_ivno1  = $_POST["clear_ivno1"];	
$clear_br  = $_POST["clear_br"];	
$code_dis = $_POST["code_dis"];
$sn_number = $_POST["sn_number"];
$delete_ckk = $_POST["delete_ckk"];	
$jong_ckk = 	$_POST["jong_ckk"];	
$jong_no = 	$_POST["jong_no"];	
	
$strSQL31 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_id."' ";
$objQuery31 = mysqli_query($com1,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
	
if($Num_Rows31 > 0){
	
$strSQL = "Update   tb_register_data set iv_date='".$doc_release_date."'  Where ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($com1,$strSQL);	
	
}


$strSQL21 = "SELECT * FROM so__submain WHERE ref_idd = '".$ref_id."' ";

$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
		$cal_new=$cal[$key];
	   $product_priceref_new = $product_priceref[$key];
        $product_id_new =$product_id[$key];
       $sale_countref_new = $sale_countref[$key];
	  $clear_ivno_new = $clear_ivno[$key];
	  $clear_ivno1_new = $clear_ivno1[$key];
	  $clear_br_new = $clear_br[$key];
	  $code_dis_new = $code_dis[$key];
	  $sn_number_new = $sn_number[$key];
	  $delete_ckk_new = $delete_ckk[$key];
	  $jong_ckk_new = 	$jong_ckk[$key];
		$jong_no_new = 	$jong_no[$key];

if($sale_channel=='1' or $sale_channel=='20' or $sale_channel=='12'){
	$sum_amount1 = $sum_amount[$key];
	$sum_amount_new = str_replace(',','', $sum_amount1);
	$sale_count_new = $sale_count[$key];
	$discount_unit1 = $discount_unit[$key];
	$discount_unit_new = str_replace(',','', $discount_unit1);
	$product_price_new = ($sum_amount_new / $sale_count_new)+$discount_unit_new;
}else{
	$sale_count_new = $sale_count[$key];
	 $discount_unit1 = $discount_unit[$key];
	$discount_unit_new = str_replace(',','', $discount_unit1);
	$product_price1 = $product_price[$key];
	$product_price_new = str_replace(',','', $product_price1);
	$sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;
}
	  
	  


$strSQL = "Update   so__submain set ref_idd='$ref_id',sale_count='$sale_count_new',price_per_unit='$product_price_new',sum_amount='$sum_amount_new',sale_remark='$sale_remarkk_new',warranty='$warranty_new',pm='$pm_new',cal='$cal_new',product_id='$product_id_new',product_code ='$product_id_new',discount_unit ='$discount_unit_new',order_ckk='".$have_order."',clear_ivno ='".$clear_ivno_new."',clear_ivno1 ='".$clear_ivno1_new."',clear_br ='".$clear_br_new."',code_dis ='".$code_dis_new."',sn_number='".$sn_number_new."',jong_no='".$jong_no_new."',jong_ckk='".$jong_ckk_new."'  Where id= '$id_new' ";

$objQuery = mysqli_query($conn,$strSQL);
	  
if($delete_ckk_new=='1'){

$strSQL5 = "DELETE FROM so__submain WHERE id = '".$id_new."'";
$objQuery5 = mysqli_query($conn,$strSQL5);
	
}
	  
  
if($sn_number_new !=''){


$sn_number =  $sn_number_new;
$str_arr = explode("\n",$sn_number);
$i = 1;
foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$sn =  trim($product_sn);
	
if($_POST["delivery_date"]!=''){	
$register_date = $_POST["delivery_date"];
}else{
$register_date = $_POST["date_disburse"];	
}

if($_POST["tel"]!=""){
	$tel = $_POST["tel"];
	}else{
$tel = $_POST["billing_tel"];	
}

if($_POST["customer_name"]!=""){
$customer = $_POST["customer_name"];
}else if ($_POST["delivery_contact"]){
$customer = $_POST["delivery_contact"];
}else{
$customer = $_POST["billing_name"];
}

if($_POST["delivery_place"]!=""){
	$address = $_POST["delivery_place"];
	}else if($_POST["address1"]!=""){
	$address1 = $_POST["address1"];
    $address2 = $_POST["address2"];	
    $address = "$address1 $address2";
		
	}else if($_POST["billing_address"]!=""){
	 $address = $_POST["billing_address"];		
			
	}
    $province = $_POST["province"];	 
    $postcode = $_POST["postcode"];
	$cus_id  = '22522';

	
$strSQL2 = "SELECT sol_name,war_hc,unit_hc,remark_hc FROM tb_product WHERE product_ID = '".$product_id_new."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
$objResult2 = mysqli_fetch_array($objQuery2);
$sol_name = $objResult2["sol_name"];	
if($objResult2["unit_hc"]=='ปี'){	
$unit_hc = "year";
}else{
$unit_hc = "month";	
}
$war_hc =	$objResult2["war_hc"];
$warrannty = "$war_hc$unit_hc";
	
$datedate = date ("Y-m-d", strtotime($warrannty, strtotime($register_date)));	

	
$sql4="select product_sn from tb_products_in_stock where product_sn='".$sn."' ";
$result4 = mysqli_query($service,$sql4) or die(mysqli_error());
$num4=mysqli_num_rows($result4); 
	
$sql41="select product_sn from tb_products_in_stock where product_sn='".$sn."' ";
$result41 = mysqli_query($servicenb,$sql41) or die(mysqli_error());
$num41=mysqli_num_rows($result41); 
	
if($num4 > 0){
	
$sql3="select install_cus_name from tb_installation_data where product_sn='".$sn."' ";
$result = mysqli_query($service,$sql3) or die(mysqli_error());
$num=mysqli_num_rows($result);
$objResult3 = mysqli_fetch_array($result);
	
if($num > 0 and $objResult3["install_cus_name"] !='') {
	
$MSG.="ขออภัยค่ะ รายการ  '".$sn."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'";	
	
$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$sn."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
}else if($num > 0 and $objResult3["install_cus_name"] ==''){
$MSG.="ขออภัยค่ะ รายการ  '".$sn."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ";	
$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$sn."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
$strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warrannty."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',more_warranty='".$objResult2["remark_hc"]."',warranty='".$objResult2["unit_hc"]."',ref_id = '".$ref_id."',register_id ='".$_POST["bill_id"]."'  where product_sn='".$sn."'";
		
$objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());

}elseif($num == '0'){

 $strSQL9 = "INSERT INTO tb_installation_data (iv_no,install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,more_warranty,warranty,cus_id,register_id,ref_id) VALUES ('".$doc_no."','".$sn."','".$customer."','".$address."','".$tel."','".$sn."','".$register_date."','".$register_date."','".$warrannty."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$objResult2["remark_hc"]."','".$objResult2["unit_hc"]."','22522','".$_POST["bill_id"]."','".$ref_id."')";
 $objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());	
 
	
if($pm_new > 0) {
$alltimepmyear1=($pm_new * $objResult2["unit_hc"]);
$dayduration=365/$pm_new;
	for($i=0;$i<$alltimepmyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$pmdate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  
		
     $sql2_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$sn."','".$j."','".$pmdate."','PM','".$add_by."','".$add_date."') ";
    $objQuery6 = mysqli_query($service,$sql2_up)or die(mysqli_error());
}
}


if($cal_new > 0) {
$alltimecalyear1=$cal_new * $objResult2["unit_hc"];
$dayduration=365/$cal_new;
	for($i=0;$i<$alltimecalyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$caldate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  

$sql3_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$sn."','".$j."','".$caldate."','CAL','".$add_by."','".$add_date."') ";
$objQuery7 = mysqli_query($service,$sql3_up)or die(mysqli_error());
	}
}
		
	
}
$sql1_up="update tb_products_in_stock set buy_status='1', mac_address='".$mac."' where product_sn='".$sn."' ";
$objQuery5 = mysqli_query($service,$sql1_up)or die(mysqli_error());	



}else if($num41 > 0){	
	
$sql3="select install_cus_name from tb_installation_data where product_sn='".$sn."' ";
$result = mysqli_query($servicenb,$sql3) or die(mysqli_error());
$num=mysqli_num_rows($result);
$objResult3 = mysqli_fetch_array($result);
	
if($num > 0 and $objResult3["install_cus_name"] !='') {
	
$MSG.="ขออภัยค่ะ รายการ  '".$sn."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'";	
	
$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$sn."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
}else if($num > 0 and $objResult3["install_cus_name"] ==''){
$MSG.="ขออภัยค่ะ รายการ  '".$sn."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ";	
$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$sn."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
$strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warrannty."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',more_warranty='".$objResult2["remark_hc"]."',warranty='".$objResult2["unit_hc"]."',ref_id = '".$ref_id."',register_id ='".$objResult["bill_id"]."'  where product_sn='".$sn."'";
		
$objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());

}elseif($num == '0'){

 $strSQL9 = "INSERT INTO tb_installation_data (iv_no,install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,more_warranty,warranty,cus_id,register_id,ref_id) VALUES ('".$doc_no."','".$sn."','".$customer."','".$address."','".$tel."','".$sn."','".$register_date."','".$register_date."','".$warrannty."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$objResult2["remark_hc"]."','".$objResult2["unit_hc"]."','22522','".$objResult["bill_id"]."','".$ref_id."')";
 $objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());	
 
	
if($pm_new > 0) {
$alltimepmyear1=($pm_new * $objResult2["unit_hc"]);
$dayduration=365/$pm_new;
	for($i=0;$i<$alltimepmyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$pmdate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  
		
     $sql2_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$sn."','".$j."','".$pmdate."','PM','".$add_by."','".$add_date."') ";
    $objQuery6 = mysqli_query($servicenb,$sql2_up)or die(mysqli_error());
}
}


if($cal_new > 0) {
$alltimecalyear1=$cal_new * $objResult2["unit_hc"];
$dayduration=365/$cal_new;
	for($i=0;$i<$alltimecalyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$caldate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  

$sql3_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$sn."','".$j."','".$caldate."','CAL','".$add_by."','".$add_date."') ";
$objQuery7 = mysqli_query($servicenb,$sql3_up)or die(mysqli_error());
	}
}
		
	
}
$sql1_up="update tb_products_in_stock set buy_status='1', mac_address='".$mac."' where product_sn='".$sn."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());	



}	
	
	
	
}
}
	
	  
	  
}
	
}



$strSQLl = "SELECT send_erpst,stock_print  FROM so__main  WHERE ref_id = '".$ref_id."' ";
$objQueryl = mysqli_query($conn,$strSQLl) or die(mysqli_error());
$objResultl = mysqli_fetch_array($objQueryl);

$stock_print = $objResultl["stock_print"];
$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = str_replace(',','',$_POST["product_price1"]);
$sale_remarkk1 = $_POST["sale_remarkk1"];
$discount_unit1 = str_replace(',','',$_POST["discount_unit1"]);
$sum_amount1= ($product_price1-$discount_unit1)*$sale_count1;
$warranty1  = $_POST["warranty1"];
$cal1 = $_POST["cal1"];
$pm1 = $_POST["pm1"];




$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = str_replace(',','',$_POST["product_price2"]);
$sale_remarkk2 = $_POST["sale_remarkk2"];
$discount_unit2 = str_replace(',','',$_POST["discount_unit2"]);
$sum_amount2= ($product_price2-$discount_unit2)*$sale_count2;
$warranty2  = $_POST["warranty2"];
$cal2 = $_POST["cal2"];
$pm2 = $_POST["pm2"];


$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$discount_unit3 = $_POST["discount_unit3"];
$sum_amount3= ($product_price3-$discount_unit3)*$sale_count3;
$warranty3  = $_POST["warranty3"];
$cal3 = $_POST["cal3"];
$pm3 = $_POST["pm3"];


$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$discount_unit4 = $_POST["discount_unit4"];
$sum_amount4= ($product_price4-$discount_unit4)*$sale_count4;
$warranty4  = $_POST["warranty4"];
$cal4 = $_POST["cal4"];
$pm4 = $_POST["pm4"];




$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$discount_unit5 = $_POST["discount_unit5"];
$sum_amount5=  ($product_price5-$discount_unit5)*$sale_count5;
$warranty5  = $_POST["warranty5"];
$cal5 = $_POST["cal5"];
$pm5 = $_POST["pm5"];


$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$discount_unit6 = $_POST["discount_unit6"];
$sum_amount6 =  ($product_price6-$discount_unit6)*$sale_count6;
$warranty6  = $_POST["warranty6"];
$cal6 = $_POST["cal6"];
$pm6 = $_POST["pm6"];


$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$discount_unit7 = $_POST["discount_unit7"];
$sum_amount7 =  ($product_price7-$discount_unit7)*$sale_count7;
$warranty7  = $_POST["warranty7"];
$cal7 = $_POST["cal7"];
$pm7 = $_POST["pm7"];


$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$discount_unit8 = $_POST["discount_unit8"];
$sum_amount8 =  ($product_price8-$discount_unit8)*$sale_count8;
$warranty8  = $_POST["warranty8"];
$cal8 = $_POST["cal8"];
$pm8 = $_POST["pm8"];



$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$discount_unit9 = $_POST["discount_unit9"];
$sum_amount9 =  ($product_price9-$discount_unit9)*$sale_count9;
$warranty9  = $_POST["warranty9"];
$cal9 = $_POST["cal9"];
$pm9 = $_POST["pm9"];


$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$discount_unit10 = $_POST["discount_unit10"];
$sum_amount10 =  ($product_price10-$discount_unit10)*$sale_count10;
$warranty10  = $_POST["warranty10"];
$cal10 = $_POST["cal10"];
$pm10 = $_POST["pm10"];









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

$price =$objResult31["price"];	
$sum_amount = $unit1*$price;		
	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$id_product1."','".$id_product1."','".$clear_br1."','".$sn1."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product2."','".$id_product2."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product3."','".$id_product3."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product4."','".$id_product4."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product5."','".$id_product5."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product6."','".$id_product6."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product7."','".$id_product7."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product8."','".$id_product8."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk1."','0.00','".$id_product10."','".$id_product10."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{	
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."','".$clear_br1."','".$sn1."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
}


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
	
$price =$objResult31["price"];	
$sum_amount = $unit1*$price;		
	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$id_product1."','".$id_product1."','".$clear_br2."','".$sn2."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product2."','".$id_product2."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product3."','".$id_product3."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product4."','".$id_product4."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product5."','".$id_product5."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product6."','".$id_product6."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product7."','".$id_product7."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product8."','".$id_product8."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk2."','0.00','".$id_product10."','".$id_product10."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
	
	
$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_id2."','".$product_id2."','".$clear_br2."','".$sn2."','".$have_order."')";

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
	
$price =$objResult31["price"];	
$sum_amount = $unit1*$price;		
	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$id_product1."','".$id_product1."','".$clear_br3."','".$sn3."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product2."','".$id_product2."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product3."','".$id_product3."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product4."','".$id_product4."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product5."','".$id_product5."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product6."','".$id_product6."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product7."','".$id_product7."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product8."','".$id_product8."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk3."','0.00','".$id_product10."','".$id_product10."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
		
	
$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_id3."','".$product_id3."','".$clear_br3."','".$sn3."','".$have_order."')";

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
	
$price =$objResult31["price"];	
$sum_amount = $unit1*$price;		
	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$id_product1."','".$id_product1."','".$clear_br4."','".$sn4."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product2."','".$id_product2."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product3."','".$id_product3."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product4."','".$id_product4."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product5."','".$id_product5."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product6."','".$id_product6."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product7."','".$id_product7."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product8."','".$id_product8."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk4."','0.00','".$id_product10."','".$id_product10."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
			
	
$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_id4."','".$product_id4."','".$clear_br4."','".$sn4."','".$have_order."')";

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
	
$price =$objResult31["price"];	
$sum_amount = $unit1*$price;		
	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$id_product1."','".$id_product1."','".$clear_br5."','".$sn5."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product2."','".$id_product2."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product3."','".$id_product3."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product4."','".$id_product4."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product5."','".$id_product5."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product6."','".$id_product6."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product7."','".$id_product7."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product8."','".$id_product8."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk5."','0.00','".$id_product10."','".$id_product10."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
				
	
$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_id5."','".$product_id5."','".$clear_br5."','".$sn5."','".$have_order."')";

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
	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$id_product1."','".$id_product1."','".$clear_br6."','".$sn6."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product2."','".$id_product2."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product3."','".$id_product3."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product4."','".$id_product4."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product5."','".$id_product5."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product6."','".$id_product6."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product7."','".$id_product7."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product8."','".$id_product8."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','".$id_product10."','".$id_product10."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
					
	
$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_id6."','".$product_id6."','".$clear_br6."','".$sn6."','".$have_order."')";

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
	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$id_product1."','".$id_product1."','".$clear_br7."','".$sn7."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product2."','".$id_product2."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product3."','".$id_product3."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product4."','".$id_product4."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product5."','".$id_product5."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product6."','".$id_product6."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product7."','".$id_product7."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product8."','".$id_product8."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','".$id_product10."','".$id_product10."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
					
	

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_id7."','".$product_id7."','".$clear_br7."','".$sn7."','".$have_order."')";

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
	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$id_product1."','".$id_product1."','".$clear_br8."','".$sn8."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product2."','".$id_product2."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product3."','".$id_product3."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product4."','".$id_product4."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product5."','".$id_product5."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product6."','".$id_product6."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product7."','".$id_product7."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product8."','".$id_product8."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','".$id_product10."','".$id_product10."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
						
$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_id8."','".$product_id8."','".$clear_br8."','".$sn8."','".$have_order."')";

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
	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$id_product1."','".$id_product1."','".$clear_br9."','".$sn9."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product2."','".$id_product2."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product3."','".$id_product3."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product4."','".$id_product4."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product5."','".$id_product5."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product6."','".$id_product6."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product7."','".$id_product7."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product8."','".$id_product8."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','".$id_product10."','".$id_product10."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
						
	
$strSQL9 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$product_id9."','".$product_id9."','".$clear_br9."','".$sn9."','".$have_order."')";

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
	
$price =$objResult31["price"];	
$sum_amount = $unit1*$price;		
	
	
if($Num_Rows31 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$id_product1."','".$id_product1."','".$clear_br10."','".$sn10."','".$have_order."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product2."','".$id_product2."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	

if($id_product3 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product3."','".$id_product3."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
if($id_product4 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product4."','".$id_product4."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product5 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product5."','".$id_product5."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product6 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product6."','".$id_product6."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product7."','".$id_product7."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		

if($id_product8 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product8."','".$id_product8."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}
	
if($id_product9 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product9."','".$id_product9."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,product_id,product_code,order_ckk)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','".$id_product10."','".$id_product10."','".$have_order."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
}		
	
}else{		
							

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,clear_br,sn_number,order_ckk)
values ('".$ref_id."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$product_id10."','".$product_id10."','".$clear_br10."','".$sn10."','".$have_order."')";

	$objQuery10 = mysqli_query($conn,$strSQL10);
	
}

}


	
	

	
	$doc_noo = substr($doc_no,0,3);
	
	if($doc_noo=="IV2"){
		$com ="บิลเงินสด";
	}else if ($_POST["select_type_doc"]=='3'){
		$com ="ออลล์เวล ไลฟ์ บจก.";
	}else if ($_POST["select_type_doc"]=='4'){
	$com="โนเบิล เมด บจก.";	
	}
	
	$cash = $_POST["h_payment"];
	if($cash=='36' or $cash=='38' or $cash=='39' or $cash=='40' or $cash=='40' or $cash=='42'){
	$credit_int = '1';	
	}else{
	$credit_int = '0';		
	}
	
	$doc_no1 = substr($doc_no,0,2);
	
	if($bus_inter=='1'){
	$des = "ขนส่งอินเตอร์";	
	}else{
	$des = "";	
	}
	
	//echo $summary;
		/*if($_POST["sale_channel"]=='1' or $_POST["sale_channel"]=='20' or $_POST["sale_channel"]=='12' or $_POST["h_payment"]=='7' or $_POST["h_payment"]=='8' or $_POST["h_payment"]=='29' or  $_POST["h_payment"]=='30'){
	}else {	}*/
	
	if($delivery_date !=''){
$date_inv=$delivery_date;	
}else if($doc_release_date!=''){
$date_inv=	$doc_release_date;
}else{
$date_inv=	$register_date;	
}
	
	if($account_approve=='1'){
		
$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

/*if($sale_channel=='33' or $sale_channel=='22'){		
$amount_1 = "0.00";
}else{*/
$amount_1 = $objResult15["amount_1"];
//}
		
$strSQL28 = "SELECT *   FROM tb_register_data  WHERE ref_id = '".$ref_id."' and IV_number NOT LIKE '%RP%'";
$objQuery28 = mysqli_query($code,$strSQL28) or die(mysqli_error());
$objResult28 = mysqli_fetch_array($objQuery28);
$Num_Rows28 = mysqli_num_rows($objQuery28);
		

if($iv_no!=''){	
		
$strSQL27="Update  tb_register_data set clear_iv = '".$iv_no."',ckk_br = '1'  where id_off ='".$objResult28["id_off"]."'";
$objQuery27 = mysqli_query($code,$strSQL27);	
	
}
		
			
	
		if($objResult28["summary_cash"]=='สมบูรณ์'){
		}else{
		if($Num_Rows28 > 0){
			if($cancel_ckk=='1'){
	//$strSQL27=" DELETE FROM  tb_register_data   where ref_id ='".$ref_id."'";
	//$objQuery27 = mysqli_query($code,$strSQL27);			
				
			}else{
				



$strSQL27="Update  tb_register_data set date_inv = '".$date_inv."',company = '".$com."',customer_name = '".$billing_name."',date_tranfer = '".$transfer_date."',unit_cash = '".$amount_1."',cash='".$cash."',credit='".$credit."',date_employee_receive='".$add_date."',doc_send='".$em_id."',date_send='".$add_date."',doc_send1='".$name."',inv_return='".$em_id."',date_inv_return='".$add_date."',inv_return1='".$name."',IV_number='".$doc_no."',description='".$des."',bill_id='".$bill_id."'  where id_off ='".$objResult28["id_off"]."'";
$objQuery27 = mysqli_query($code,$strSQL27);	
			}	
		}else{
			
$strSQL29="insert into   tb_register_data ( IV_number,date_inv,company,customer_name,date_tranfer,unit_cash,
cash,employee_name,ref_id,credit,bill_id,sale_channel,date_employee_receive,doc_send,date_send,doc_send1,inv_return,date_inv_return) values ('".$doc_no."','".$date_inv."','".$com."','".$billing_name."','".$transfer_date."','".$amount_1."','".$cash."','".$add_by."','".$ref_id."','".$credit_int."','".$bill_id."','".$sale_channel."','".$add_date."','".$em_id."','".$add_date."','".$name."','".$em_id."','".$add_date."')";
$objQuery29 = mysqli_query($code,$strSQL29);				
			
		}
			
		
		}
		}
	
	
//exit();	

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
	if ($_POST['credit']!=''){
		 $credit=$_POST['credit'];
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
 $customer_name1=$_POST["customer_name1"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
$status_comment = $_POST["status_comment"];	
	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product_name=$_POST["product"];
 $product_sn=$doc_no;
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
$dept = $_POST["dept"];

$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);
$send_cs = $_POST["send_cs"];


$department_show = $_POST["department_show"];


$sql = "SELECT *   FROM st__signature where ref_id = '".$ref_id."'";
$qry = mysqli_query($new,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
if($rs["cs_name"]==''){		
	
	
$strSQL66 =  "Update tb_register_data set start_date='$start_date',between_date='$between_date',start_time='$start_time',end_time='$end_time',status='".$status."',fix_date='".$fix_date."',no_price='".$no_price."',call_customer='".$call_customer."',credit='".$credit."',call_employee='".$call_employee."',cash='".$chash."',check_peper='".$check_peper."',bill='".$bill."',department='".$department."',type_customer='".$type_customer."',type_company='".$type_company."',customer_name='".$customer_name1."',customer_tel='".$customer_tel."',address_name='".$address_name."',address_send='".$address_send."',want_bus='".$want_bus."',amphur_name='".$amphur_name."',province_name='".$province_name."',product_name='".$product_name."',product_sn='".$product_sn."',unit_credit='".$unit_credit."',price='".$price."',employee_name='".$employee_name."',employee_tel='".$employee_tel."',add_by='".$add_by."',description='".$description."',have_map='".$havemap."',add_date='$add_date',unit_bill='".$unit_bill."',unit_check='".$unit_check."',unit_tran='".$unit_tran."',tran='".$tran."',number='".$number."',status_comment='".$status_comment."',dep='".$dep."',dept='".$dept."',department_show='".$department_show."',customer_contact='".$customer_contact."',mk_research='".$mk_research."',bus_inter='".$bus_inter."'  where ref_id='".$ref_id."'";

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());
	
	
if($job_id!=''){
	
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";	
	
$strSQLn =  "Update tb_register_data set start_date='$start_date',between_date='$between_date',start_time='$start_time',end_time='$end_time',status='".$status."',fix_date='".$fix_date."',no_price='".$no_price."',call_customer='".$call_customer."',credit='".$credit."',call_employee='".$call_employee."',cash='".$chash."',check_peper='".$check_peper."',bill='".$bill."',department='".$department."',type_customer='".$type_customer."',type_company='".$type_company."',customer_name='".$customer_name1."',customer_tel='".$customer_tel."',address_name='".$address_name."',address_send='".$address_send."',want_bus='".$want_bus."',amphur_name='".$amphur_name."',province_name='".$province_name."',product_name='".$product_name."',product_sn='".$product_sn."',unit_credit='".$unit_credit."',price='".$price."',employee_name='".$employee_name."',employee_tel='".$employee_tel."',description='".$description."',have_map='".$havemap."',add_by='$add_by',add_date='$add_date',unit_bill='".$unit_bill."',unit_check='".$unit_check."',unit_tran='".$unit_tran."',tran='".$tran."',number='".$number."',status_comment='".$status_comment."',dep='".$dep."',dept='".$dept."',department_show='".$department_show."',customer_contact='".$customer_contact."',mk_research='".$mk_research."'  where running='".$job_id."'";
$objQueryn = mysqli_query($com1,$strSQLn) or die(mysqli_error());	
	
	
}
}
 

		
		
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


 
 $strSQL90 =  "insert into tb_transaction (running) 

values('".$nextId."')";

$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  so__main set job_id='".$nextId."',send_cs ='2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
	}
	

	

$save123 = " Update  so__submain set doc_release_date = '".$doc_release_date."'  where  ref_idd ='".$ref_id."'";
$qsave123 = mysqli_query($conn,$save123);	
	

	
 if($qsave){
	 	 
echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_admin_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
