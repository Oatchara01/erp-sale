
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
$delivery = $_POST["h_delivery"];
$employee_name = $_POST["employee_name"];

$other_payment = $_POST["other_payment"];
$big_car = $_POST["big_car"];
$delivery_date = $_POST["delivery_date"];
$delivery_time = $_POST["delivery_time"];
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
$order_id = $_POST["order_no"];
$order_name = $_POST["order_name"];
$order_delivery_date = $_POST["order_delivery_date"];
$order_refer_code = $_POST["order_refer_code"];
$clear_book_ckk = $_POST["clear_book_ckk"];
$customer_name = $_POST["customer_name"];

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






//echo $_FILES['upload1']['name'];
//exit();
	move_uploaded_file($_FILES['upload1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload1']['name']));
	move_uploaded_file($_FILES['upload2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload2']['name']));
	move_uploaded_file($_FILES['upload3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload3']['name']));
	move_uploaded_file($_FILES['upload4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload4']['name']));
	move_uploaded_file($_FILES['upload5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload5']['name']));
	move_uploaded_file($_FILES['upload_map']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload_map']['name']));




$save="insert into so__main
(main_id,ref_id,register_date,register_time,sale_channel,select_type_doc,billing_name,billing_address,billing_tel,full_bill,customer_name,address1,address2,province,postcode,tel,delivery_place,delivery_contact,withdraw_objective,payment,other_payment,delivery,big_car,delivery_date,delivery_time,call_before,assign_date_time,maps,employee_name,approve_name,discount,sale_complete,sale_remark,sn,bq,ot,delivery_company,delivery_sale,delivery_engineer,delivery_customer,returns,return_date,return_time,return_address,return_contact,prefer_name,po_no,delivery_contract,with_pr,clear_book_no,clear_brn_no,clear_brnp_no,type_type,type_type_detail,install_place,account_approve,amount,transfer_date,order_id,order_name,order_delivery_date,order_refer_code,bill_vat,clear_book_ckk,upload1,upload2,upload3,upload4,upload5,status_doc,clear_brn_no_ckk,clear_brnp_no_ckk,sn_ckk,bq_ckk,ot_ckk,upload_map,transfer,review_date_call,review_call_des,review_date,pomotion_date,review_description)
values
('$main_id','$ref_id','$register_date','$register_time','$sale_channel','$select_type_doc','$billing_name','$billing_address','$billing_tel','$full_bill','$customer_name','$address1','$address2','$province','$postcode','$tel','$delivery_place','$delivery_contact','$withdraw_objective','$payment','$other_payment','$delivery','$big_car','$delivery_date','$delivery_time','$call_before','$assign_date_time','$maps','$employee_name','$approve_name','$discount','$sale_complete','$sale_remark','$sn','$bq','$ot','$delivery_company','$delivery_sale','$delivery_engineer','$delivery_customer','$returns','$return_date','$return_time','$return_address','$return_contact','$prefer_name','$po_no','$delivery_contract','$with_pr','$clear_book_no','$clear_brn_no','$clear_brnp_no','$type_type','$type_type_detail','$install_place','$account_approve','$amount','$transfer_date','$order_id','$order_name','$order_delivery_date','$order_refer_code','$bill_vat','$clear_book_ckk','".$_FILES['upload1']['name']."','".$_FILES['upload2']['name']."','".$_FILES['upload3']['name']."','".$_FILES['upload4']['name']."','".$_FILES['upload5']['name']."','1','$clear_brn_no_ckk','$clear_brnp_no_ckk','$sn_ckk','$bq_ckk','$ot_ckk','".$_FILES['upload_map']['name']."','$transfer','$review_date_call','$review_call_des','$review_date','$promotion_date','$review_description')";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);


/*$hdnLine = $_POST["hdnLine"];
echo  $hdnLine;

for ($i = 1; $i<= (int)$hdnLine; $i++){
if(isset($_POST["product_code$i"]))
{
$strSQL = "insert into so__submain
(ref_idd,product_code,product_code_same,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('$ref_id',
'".$_POST["product_code$i"]."',
'',
'".$_POST["sale_count$i"]."',
'".$_POST["product_price$i"]."',
'".$_POST["sum_amount$i"]."',
'".$_POST["unit_name$i"]."',
'".$_POST["product_name$i"]."',
'".$_POST["sale_remarkk$i"]."',
'".$_POST["stock_remark$i"]."',
'".$_POST["discount_unit$i"]."')";

//echo $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL);



}*/





$product_code1 = $_POST["product_code1"];
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




$product_code2 = $_POST["product_code2"];
$product_name2 = $_POST["product_name2"];
$unit_name2 = $_POST["unit_name2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];
$warranty2  = $_POST["warranty2"];
$cal2 = $_POST["cal2"];
$pm2 = $_POST["pm2"];


$product_code3 = $_POST["product_code3"];
$product_name3 = $_POST["product_name3"];
$unit_name3 = $_POST["unit_name3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];
$warranty3  = $_POST["warranty3"];
$cal3 = $_POST["cal3"];
$pm3 = $_POST["pm3"];


$product_code4 = $_POST["product_code4"];
$product_name4 = $_POST["product_name4"];
$unit_name4 = $_POST["unit_name4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];
$warranty4  = $_POST["warranty4"];
$cal4 = $_POST["cal4"];
$pm4 = $_POST["pm4"];




$product_code5 = $_POST["product_code5"];
$product_name5 = $_POST["product_name5"];
$unit_name5 = $_POST["unit_name5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_POST["discount_unit5"];
$warranty5  = $_POST["warranty5"];
$cal5 = $_POST["cal5"];
$pm5 = $_POST["pm5"];


$product_code6 = $_POST["product_code6"];
$product_name6 = $_POST["product_name6"];
$unit_name6 = $_POST["unit_name6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];
$warranty6  = $_POST["warranty6"];
$cal6 = $_POST["cal6"];
$pm6 = $_POST["pm6"];


$product_code7 = $_POST["product_code7"];
$product_name7 = $_POST["product_name7"];
$unit_name7 = $_POST["unit_name7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];
$warranty7  = $_POST["warranty7"];
$cal7 = $_POST["cal7"];
$pm7 = $_POST["pm7"];


$product_code8 = $_POST["product_code8"];
$product_name8 = $_POST["product_name8"];
$unit_name8 = $_POST["unit_name8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];
$warranty8  = $_POST["warranty8"];
$cal8 = $_POST["cal8"];
$pm8 = $_POST["pm8"];



$product_code9 = $_POST["product_code9"];
$product_name9 = $_POST["product_name9"];
$unit_name9 = $_POST["unit_name9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];
$warranty9  = $_POST["warranty9"];
$cal9 = $_POST["cal9"];
$pm9 = $_POST["pm9"];


$product_code10 = $_POST["product_code10"];
$product_name10 = $_POST["product_name10"];
$unit_name10 = $_POST["unit_name10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];
$warranty10  = $_POST["warranty10"];
$cal10 = $_POST["cal10"];
$pm10 = $_POST["pm10"];



if($product_code1 !==''){

$strSQL1 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code1."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$unit_name1."','".$product_name1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);


}

if($product_code2 !==''){

$strSQL2 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code2."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$unit_name2."','".$product_name2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."')";
$objQuery2 = mysqli_query($conn,$strSQL2);

}
if($product_code3 !==''){

$strSQL3 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code3."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$unit_name3."','".$product_name3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
}

if($product_code4 !==''){

$strSQL4 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code4."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$unit_name4."','".$product_name4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);

}

if($product_code5 !==''){

$strSQL5 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code5."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$unit_name5."','".$product_name5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);
}
if($product_code6 !==''){

$strSQL6 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code6."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$unit_name6."','".$product_name6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
}

if($product_code7 !==''){

$strSQL7 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code7."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$unit_name7."','".$product_name7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);
}

if($product_code8 !==''){

$strSQL8 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code8."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$unit_name8."','".$product_name8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);

}
if($product_code9 !==''){

$strSQL9 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code9."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$unit_name9."','".$product_name9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);

}

if($product_code10 !==''){

$strSQL10 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,discount_unit,warranty,cal,pm)
values ('".$ref_id."','".$product_code10."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$unit_name10."','".$product_name10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);

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



