
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
$register_date = date("Y/m/d");
$register_time = date("H:i:s");
$sale_channel = $_POST["sale_channel"];
$select_br_ptl = $_POST["select_br_ptl"];
$select_br_nbm = $_POST["select_br_nbm"];
$select_so_ptl = $_POST["select_so_ptl"];
$select_so_nbm = $_POST["select_so_nbm"];
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
$payment = $_POST["payment"];
$other_payment = $_POST["other_payment"];
$delivery = $_POST["delivery"];
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
$type_com = $_POST["type_com"];
$type_so = $_POST["type_so"];
$type_type = $_POST["type_type"];
$type_type_detail = $_POST["type_type_detail"];
$warranty = $_POST["warranty"];
$cal = $_POST["cal"];
$pm = $_POST["pm"];
$install_place = $_POST["install_place"];
$account_approve = $_POST["account_approve"];
$amount = $_POST["amount"];
$transfer_date = $_POST["transfer_date"];
$order_id = $_POST["order_id"];
$order_name = $_POST["order_name"];
$order_delivery_date = $_POST["order_delivery_date"];
$order_refer_code = $_POST["order_refer_code"];

	









$save="insert into so__main
(main_id,ref_id,register_date,register_time,sale_channel,select_br_ptl,select_br_nbm,select_so_ptl,select_so_nbm,billing_name,billing_address,billing_tel,full_bill,customer_name,address1,address2,province,postcode,tel,delivery_place,delivery_contact,withdraw_objective,payment,other_payment,delivery,big_car,delivery_date,delivery_time,call_before,assign_date_time,maps,employee_name,approve_name,discount,sale_complete,sale_remark,sn,bq,ot,delivery_company,delivery_sale,delivery_engineer,delivery_customer,returns,return_date,return_time,return_address,return_contact,prefer_name,po_no,delivery_contract,with_pr,clear_book_no,clear_brn_no,clear_brnp_no,type_com,type_so,type_type,type_type_detail,warranty,cal,pm,install_place,account_approve,amount,transfer_date,order_id,order_name,order_delivery_date,order_refer_code,bill_vat)
values
('$main_id','$ref_id','$register_date','$register_time','$sale_channel','$select_br_ptl','$select_br_nbm','$select_so_ptl','$select_so_nbm','$billing_name','$billing_address','$billing_tel','$full_bill','$customer_name','$address1','$address2','$province','$postcode','$tel','$delivery_place','$delivery_contact','$withdraw_objective','$payment','$other_payment','$delivery','$big_car','$delivery_date','$delivery_time','$call_before','$assign_date_time','$maps','$employee_name','$approve_name','$discount','$sale_complete','$sale_remark','$sn','$bq','$ot','$delivery_company','$delivery_sale','$delivery_engineer','$delivery_customer','$returns','$return_date','$return_time','$return_address','$return_contact','$prefer_name','$po_no','$delivery_contract','$with_pr','$clear_book_no','$clear_brn_no','$clear_brnp_no','$type_com','$type_so','$type_type','$type_type_detail','$warranty','$cal','$pm','$install_place','$account_approve','$amount','$transfer_date','$order_id','$order_name','$order_delivery_date','$order_refer_code','$bill_vat')";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);


$hdnLine = $_POST["hdnLine"];
//echo  $hdnLine;

for ($i = 1; $i<= (int)$hdnLine; $i++){
if(isset($_POST["product_code$i"]))
{
$strSQL = "insert into so__submain
(ref_id,product_code,product_name,unit_name,sale_count,price_per_unit,amount,sale_remark,stock_remark)
values ('$ref_id','".$_POST["product_code$i"]."','".$_POST["product_name$i"]."','".$_POST["unit_name$i"]."','".$_POST["sale_count$i"]."','".$_POST["product_price$i"]."','".$_POST["sum_amount$i"]."','".$_POST["sale_remarkk$i"]."','".$_POST["stock_remark$i"]."')";

//echo $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL);



}

	
if($qsave&&$objQuery)
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
</center>
</body>
</html>



