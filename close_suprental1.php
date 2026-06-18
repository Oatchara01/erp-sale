<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include("dbconnect_cs.php");

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
$promis_no = $_POST["promis_no"];
$promis_date = $_POST["promis_date"];
$count_m = $_POST["count_m"];	
$unit = "month";	
$wdff = "$count_m $unit";	
$end_promis = date("Y-m-d", strtotime($wdff, strtotime($start_promis)));	
	

$sale_code = $_POST['sale_code'];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

if($_POST["admin_name"]!=''){
$admin_name = $_POST["admin_name"];
}else{
$admin_name = "$name $surname";
}
$ref_id = $_POST["ref_id"];
	



$save="UPDATE hos__rental_runiv SET close_date='".$add_date."',close_name='".$add_by."',close_ckk='1'  where ref_id='".$ref_id."' ";
$qsave=mysqli_query($conn,$save);

if($type_doc=='3'){

$save1="UPDATE tb_installation_data SET close_install='1'  where ref_id='".$ref_id."' ";
$qsave1=mysqli_query($service,$save1);

	
$strSQL2 ="SELECT product_sn FROM tb_installation_data where ref_id='".$ref_id."' ";
$objQuery2 =mysqli_query($service,$strSQL2);
while($objResult1 = mysqli_fetch_array($objQuery1))
{
$save2="UPDATE tb_products_in_stock SET buy_status='0'  where product_sn ='".$objResult1["product_sn"]."' ";
$qsave2=mysqli_query($service,$save2);


}

}else if($type_doc=='4'){

$save1="UPDATE tb_installation_data SET close_install='1'  where ref_id='".$ref_id."' ";
$qsave1=mysqli_query($servicenb,$save1);

$strSQL2 ="SELECT product_sn FROM tb_installation_data where ref_id='".$ref_id."' ";
$objQuery2 =mysqli_query($servicenb,$strSQL2);
while($objResult1 = mysqli_fetch_array($objQuery1))
{
$save2="UPDATE tb_products_in_stock SET buy_status='0'  where product_sn ='".$objResult1["product_sn"]."' ";
$qsave2=mysqli_query($servicenb,$save2);


}


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
 $product_name = $_POST["product"];;
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
$send_cs = $_POST["send_cs"];

	
$strSQL66 =  "insert into tb_register_return (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,mk_research,province_name) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','โรงพยาบาล','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$mk_research."','".$province_name."')";

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());
	

	
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



 if($qsave){
	 if($_SESSION["type_login"]=='Admin'){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_adminrental_kang.php';";
echo "</script>";		 
	 }else{
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_kangivsup.php';";
echo "</script>";
	 }
  } else {
   echo "Cannot";
  }
	}


