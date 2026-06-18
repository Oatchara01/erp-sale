
<?php
include("dbconnect.php");
include ("error_page.php"); 
include("dbconnect_cs.php");
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
	
$order_refer_code = $_POST["order_refer_code"];
$order_refer_code1 = $_POST["order_refer_code1"];
$date_ker = $_POST["date_ker"];
$ker_bath = $_POST["ker_bath"];
	

$iv_date = $_POST["iv_date"];
	
$iv_time1 = $_POST["iv_time"];
if($iv_date !='' and $iv_time1=='00:00:00'){	
$iv_time = date('H:i:s');	
}else{
$iv_time = $_POST["iv_time"];	
}	
	
	
$send_cs = $_POST["send_cs"];
$send_brdoc = $_POST["send_brdoc"];
$add_by1 = $_POST["add_by1"];
$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
$sale_code = $_POST["sale_code"];
$name =  $_SESSION['name'];
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
$delete_ckk = $_POST["delete_ckk"];	

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

$run_id = $_POST["run_id"];	
	
$date = explode('-' , $iv_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
	

if($run_id=='1'){	

if($company =='1'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='EXC' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "EXC";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$iv_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('EXC','".$iv_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($company =='2'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='EXCN' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "EXCN";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$iv_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('EXCN','".$iv_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);


	}
	
	
}else{	
$iv_no = $_POST["iv_no"];	
}


$save="Update   hos__change set company='".$company."',date_change='".$date_change."',customer='".$customer."',customer_id='".$customer_id."',address='".$address."',sale_comment='".$sale_comment."',sn_ckk='".$sn_ckk."',sn='".$sn."',objective='".$objective."',objective_des='".$objective_des."',returns='".$returns."',returns_date='".$returns_date."',returns_time='".$returns_time."',returns_name='".$returns_name."',returns_address='".$returns_address."',returns_contact='".$returns_contact."',delivery_name='".$delivery_name."',delivery_type='".$delivery_type."',delivery_date='".$delivery_date."',delivery_time='".$delivery_time."',delivery_address='".$delivery_address."',delivery_contact='".$delivery_contact."',delivery_tel='".$delivery_tel."',sale_code = '".$sale_code."' ,date_send_key = '".$date_send_key."',return_date_bet='".$return_date_bet."',slip1 = '".$slip1."',slip2 = '".$slip2."',slip3 = '".$slip3."',slip4 = '".$slip4."',slip5 = '".$slip5."',iv_no = '".$iv_no."',iv_date = '".$iv_date."',iv_time='".$iv_time."',add_by ='".$add_by1."',ker_bath='".$ker_bath."',date_ker='".$date_ker."',order_refer_code1='".$order_refer_code1."',order_refer_code='".$order_refer_code."'   where ref_id ='".$ref_id."'";
$qsave=mysqli_query($conn,$save);
	
$status_doc = $_POST["status_doc"];
	
	if($status_doc !=''){
$save="Update   hos__change set  status_doc='".$status_doc."'  where ref_id ='".$ref_id."'";
$qsave=mysqli_query($conn,$save);	
		
		
	}
	


if($send_brdoc =='1'){	
	
	
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');

$save9="insert into tb_register_br
(company,br_date,iv_no,customer_name,add_by,add_date) values ('".$company."','".$iv_date."','".$iv_no."','".$customer."','".$add_by."','".$add_date."')";

$qsave9=mysqli_query($conn,$save9);

$save3="Update   hos__br set send_brdoc = '2' where ref_id ='".$ref_id."'";
$qsave3=mysqli_query($conn,$save3);
	
}


  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
		$sale_remarkk_new=$sale_remarkk[$key];
        $product_id_new =$product_id[$key];
		$count_stock_new=$count_stock[$key];
		$count_sale_new=$count_sale[$key];
	   $delete_ckk_new = $delete_ckk[$key];
	  if($count_sale_new !='0'){
		$sum_amount_new = $product_price_new *$count_sale_new;
	  }else{
		$sum_amount_new = $product_price_new *$count_stock_new;  
	  }


$strSQL = "Update   hos__subchange set count_sale='$count_sale_new',count_stock='$count_stock_new',price='$product_price_new',amount='$sum_amount_new',sale_remark='$sale_remarkk_new',product_id='$product_id_new',product_code ='$product_id_new'   Where id= '$id_new' ";
$objQuery = mysqli_query($conn,$strSQL);
	  
if($delete_ckk_new=='1'){

$strSQL5 = "DELETE FROM hos__subchange WHERE id = '".$id_new."'";
$objQuery5 = mysqli_query($conn,$strSQL5);
	
}	  
	  
	  
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
}else{
$type_company="อื่นๆ";
}
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
 $description1=$_POST["description"];
	
$description = "$description1 $sale_comment";
	
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
$job_no = $_POST["job_no"];	
	
	
$sql = "SELECT *   FROM st__signature where ref_id = '".$ref_id."'";
$qry = mysqli_query($new,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
if($rs["cs_name"]==''){		
	

$strSQL66 =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$address_name."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',address_1 = '".$address_1."',province_name='".$province_name."',bus_inter='".$bus_inter."'  where ref_id = '".$ref_id."'";
$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());
	
if($job_no!=''){
		
$strSQLn =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$address_1."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',province_name='".$province_name."'  where running = '".$job_no."'";
$objQueryn = mysqli_query($com1,$strSQLn) or die(mysqli_error());	
	
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

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_1."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$on_time."','".$h_employee_name."','".$ref_id."','1')";

//echo $strSQL89;
//exit();

 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());


 
 $strSQL90 =  "insert into tb_transaction (running) 

values('".$nextId."')";

$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  hos__change set job_no ='".$nextId."',send_cs ='2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
}

$strSQL89="Update  st__main set iv_no = '".$iv_no."',iv_no1 = '".$iv_no."'  where ref_idsale='".$ref_id."'";
$objQuery89 = mysqli_query($new,$strSQL89);

 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminchange_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}

