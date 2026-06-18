
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$main_id = $_POST["main_id"];
$ref_id = $_POST["ref_id"];
$register_date = $_POST["register_date"];
$register_time = $_POST["register_time"];
$sale_channel = $_POST["sale_channel"];
$select_type_doc = $_POST["select_type_doc"];
$billing_name = $_POST["billing_name"];
$billing_address = $_POST["billing_address"];
$billing_tel = $_POST["billing_tel"];
$bill_vat = $_POST["bill_vat"];

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
$payment = $_POST["h_payment"];
$other_payment = $_POST["other_payment"];
$delivery = $_POST["h_delivery"];
$big_car = $_POST["big_car"];
$delivery_date = $_POST["delivery_date"];
$delivery_time = $_POST["delivery_time"];
$call_before = $_POST["call_before"];
$assign_date_time = $_POST["assign_date_time"];
$maps = $_POST["maps"];
$employee_name = $_POST["employee_name"];
$approve_name = $_POST["approve_name"];
$discount = $_POST["discount"];
$sale_complete = $_POST["sale_complete"];
$sale_remark = $_POST["sale_remark"];
$sn = $_POST["sn"];
$bq = $_POST["bq"];
$ot = $_POST["ot"];
$delivery_company = $_POST["delivery_company"];
$delivery_sale = $_POST["delivery_sale"];
$delivery_engineer = $_POST["delivery_engineer"];
$delivery_customer = $_POST["delivery_customer"];
$returns = $_POST["returns"];
$return_date = $_POST["return_date"];
$return_time = $_POST["return_time"];
$return_address = $_POST["return_address"];
$return_contact = $_POST["return_contact"];
$prefer_name = $_POST["prefer_name"];
$po_no = $_POST["po_no"];
$delivery_contract = $_POST["delivery_contract"];
$with_pr = $_POST["with_pr"];
$clear_book_no = $_POST["clear_book_no"];
$clear_brn_no = $_POST["clear_brn_no"];
$clear_brnp_no = $_POST["clear_brnp_no"];
$type_type = $_POST["type_type"];
$type_type_detail = $_POST["type_type_detail"];
$install_place = $_POST["install_place"];
$account_approve = $_POST["account_approve"];
$amount = $_POST["amount"];
$transfer_date = $_POST["transfer_date"];
$order_id = $_POST["order_id"];
$order_name = $_POST["order_name"];
$order_delivery_date = $_POST["order_delivery_date"];
$order_refer_code = $_POST["order_refer_code"];
$clear_book_ckk = $_POST["clear_book_ckk"];
$clear_brn_no_ckk = $_POST["clear_brn_no_ckk"];
$clear_brnp_no_ckk = $_POST["clear_brnp_no_ckk"];
$sn_ckk = $_POST["sn_ckk"];
$bq_ckk = $_POST["bq_ckk"];
$ot_ckk = $_POST["ot_ckk"];
$transfer = $_POST["transfer"];


$review_date_call = $_POST["review_date_call"];
$review_call_des = $_POST["review_call_des"];
$review_date = $_POST["review_date"];
$promotion_date = $_POST["promotion_date"];
$review_description = $_POST["review_description"];




	
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





$save="Update  so__main set ref_id='$ref_id',register_date='$register_date',register_time='$register_time',sale_channel='$sale_channel',select_type_doc='$select_type_doc',billing_name='$billing_name',billing_address='$billing_address',billing_tel='$billing_tel',full_bill='$full_bill',customer_name='$customer_name',address1='$address1',address2='$address2',province='$province',postcode='$postcode',tel='$tel',delivery_place='$delivery_place',delivery_contact='$delivery_contact',withdraw_objective='$withdraw_objective',payment='$payment',other_payment='$other_payment',delivery='$delivery',big_car='$big_car',delivery_date='$delivery_date',delivery_time='$delivery_time',call_before='$call_before',assign_date_time='$assign_date_time',maps='$maps',employee_name='$employee_name',approve_name='$approve_name',discount='$discount',sale_complete='$sale_complete',sale_remark='$sale_remark',sn='$sn',bq='$bq',ot='$ot',delivery_company='$delivery_company',delivery_sale='$delivery_sale',delivery_engineer='$delivery_engineer',delivery_customer='$delivery_customer',returns='$returns',return_date='$return_date',return_time='$return_time',return_address='$return_address',return_contact='$return_contact',prefer_name='$prefer_name',po_no='$po_no',delivery_contract='$delivery_contract',with_pr='$with_pr',clear_book_no='$clear_book_no',clear_brn_no='$clear_brn_no',clear_brnp_no='$clear_brnp_no',type_type='$type_type',type_type_detail='$type_type_detail',install_place='$install_place',account_approve='$account_approve',amount='$amount',transfer_date='$transfer_date',order_id='$order_id',order_name='$order_name',order_delivery_date='$order_delivery_date',order_refer_code='$order_refer_code',clear_book_ckk='$clear_book_ckk',upload1='".$upload1."',upload2='".$upload2."',upload3='".$upload3."',upload4='".$upload4."',upload5='".$upload5."',clear_brn_no_ckk='$clear_brn_no_ckk',clear_brnp_no_ckk='$clear_brnp_no_ckk',sn_ckk='$sn_ckk',bq_ckk='$bq_ckk',ot_ckk='$ot_ckk',upload_map='$upload_map',transfer='$transfer',review_date_call='$review_date_call',review_call_des='$review_call_des',review_date='$review_date',pomotion_date='$promotion_date',review_description='$review_description'  where main_id='$main_id'";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);


$id = $_POST["id"];
$product_code = $_POST["product_code"];
$product_name = $_POST["product_name"];
$unit_name = $_POST["unit_name"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$warranty  = $_POST["warranty"];
$cal  = $_POST["cal"];
$pm  = $_POST["pm"];


  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$product_code_new=$product_code[$key];
		$product_name_new=$product_name[$key];
		$unit_name_new=$unit_name[$key];
		$sale_count_new=$sale_count[$key];
		$product_price_new=$product_price[$key];
		$sum_amount1=$sum_amount[$key];
		$sum_amount_new=str_replace(',','', $sum_amount1);
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$cal_new=$cal[$key];
		$pm_new=$pm[$key];

       
$strSQL = "Update    so__submain set ref_idd='$ref_id',product_code='$product_code_new',product_name='$product_name_new',unit_name='$unit_name_new',sale_count='$sale_count_new',price_per_unit='$product_price_new',sum_amount='$sum_amount_new',sale_remark='$sale_remarkk_new',pm='$pm_new',warranty='$warranty_new',cal='$cal_new' Where id= '$id_new' ";

//echo $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL);



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



/*if (!$qsave) {
	echo "Error to save data".mysqli_error();
}
else {
	echo "Save Successfully";
}
}
*/
?>

<p align="center"><a href="main_office.php"><span class="style18">กลับสู่หน้าหลัก</span></a></p>

</center>
</body>
</html>



