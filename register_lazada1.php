<?php
include("dbconnect.php");
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
$doc_no = $_POST["doc_no"];
$doc_release_date = $_POST["doc_release_date"];
//echo $doc_release_date;
//exit();
$job_id = $_POST["job_id"];
$billing_name = $_POST["billing_name"];
$billing_address = $_POST["billing_address"];
$billing_tel = $_POST["billing_tel"];
$full_bill = $_POST["full_bill"];
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
$delivery_company = $_POST["delivery_company"];
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


$order_id = $_POST["order_id"];
//echo $order_id;
//exit();

$order_name = $_POST["order_name"];
$clear_book_ckk = $_POST["clear_book_ckk"];
$barcode=$_POST["barcode"];
$status_doc = $_POST["status_doc"];

$clear_book_ckk = $_POST["clear_book_ckk"];
$clear_brn_no_ckk = $_POST["clear_brn_no_ckk"];
$clear_brnp_no_ckk = $_POST["clear_brnp_no_ckk"];
$sn_ckk = $_POST["sn_ckk"];
$bq_ckk = $_POST["bq_ckk"];
$ot_ckk = $_POST["ot_ckk"];
$deposit_no = $_POST["deposit_no"];

//move_uploaded_file($_FILES['upload1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload1']['name']));
//move_uploaded_file($_FILES['upload2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload2']['name']));
///move_uploaded_file($_FILES['upload3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload3']['name']));
//move_uploaded_file($_FILES['upload4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload4']['name']));
///move_uploaded_file($_FILES['upload5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['upload5']['name']));

/*$upload1 = $_POST["upload1"];
$upload2 = $_POST["upload2"];
$upload3 = $_POST["upload3"];
$upload4 = $_POST["upload4"];
$upload5 = $_POST["upload5"];*/


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


//echo $upload1;
//exit();

$save=" Update  so__main set
ref_id='$ref_id',register_date='$register_date',register_time='$register_time',sale_channel='$sale_channel',select_type_doc='$select_type_doc',delivery='$delivery',payment='$payment',sale_remark='$sale_remark',employee_name='$employee_name',doc_no='$doc_no',doc_release_date='$doc_release_date',job_id='$job_id',billing_name='$billing_name',billing_address='$billing_address',billing_tel='$billing_tel',full_bill='$full_bill',transfer='$transfer',account_approve='$account_approve',transfer_date='$transfer_date',amount='$amount',delivery_name='$delivery_name',address1='$address1',address2='$address2',province='$province',postcode='$postcode',tel='$tel',prefer_name='$prefer_name',po_no='$po_no',delivery_contract='$delivery_contract',clear_book_no='$clear_book_no',clear_brn_no='$clear_brn_no',clear_brnp_no='$clear_brnp_no',sn='$sn',bq='$bq',ot='$ot',install_place='$install_place',type_type='$type_type',type_type_detail='$type_type_detail',delivery_date='$delivery_date',delivery_time='$delivery_time',delivery_company='$delivery_company',big_car='$big_car',call_before='$call_before',maps='$maps',assign_date_time='$assign_date_time',delivery_type='$delivery_type',delivery_place='$delivery_place',delivery_contact='$delivery_contact',returns='$returns',return_date='$return_date',return_time='$return_time',return_address='$return_address',return_contact='$return_contact',admin_complete='$admin_complete',order_id='$order_id',order_name='$order_name',clear_book_ckk='$clear_book_ckk',status_doc='$status_doc',upload1='".$upload1."',upload2='".$upload2."',upload3='".$upload3."',upload4='".$upload4."',upload5='".$upload5."',lazada_id ='0',clear_brn_no_ckk='$clear_brn_no_ckk',clear_brnp_no_ckk='$clear_brnp_no_ckk',sn_ckk='$sn_ckk',bq_ckk='$bq_ckk',ot_ckk='$ot_ckk',deposit_no ='$deposit_no',upload_map='$upload_map'  where  main_id ='$main_id'";
//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);





$product_code1 = $_POST["product_code1"];
$product_name1 = $_POST["product_name1"];
$unit_name1 = $_POST["unit_name1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$stock_remark1 = $_POST["stock_remark1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$discount_unit1 = $_POST["discount_unit1"];



$product_code2 = $_POST["product_code2"];
$product_name2 = $_POST["product_name2"];
$unit_name2 = $_POST["unit_name2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$stock_remark2 = $_POST["stock_remark2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];


$product_code3 = $_POST["product_code3"];
$product_name3 = $_POST["product_name3"];
$unit_name3 = $_POST["unit_name3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$stock_remark3 = $_POST["stock_remark3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];


$product_code4 = $_POST["product_code4"];
$product_name4 = $_POST["product_name4"];
$unit_name4 = $_POST["unit_name4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$stock_remark4 = $_POST["stock_remark4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];




$product_code5 = $_POST["product_code5"];
$product_name5 = $_POST["product_name5"];
$unit_name5 = $_POST["unit_name5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$stock_remark5 = $_POST["stock_remark5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_POST["discount_unit5"];


$product_code6 = $_POST["product_code6"];
$product_name6 = $_POST["product_name6"];
$unit_name6 = $_POST["unit_name6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$stock_remark6 = $_POST["stock_remark6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];


$product_code7 = $_POST["product_code7"];
$product_name7 = $_POST["product_name7"];
$unit_name7 = $_POST["unit_name7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$stock_remark7 = $_POST["stock_remark7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];


$product_code8 = $_POST["product_code8"];
$product_name8 = $_POST["product_name8"];
$unit_name8 = $_POST["unit_name8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$stock_remark8 = $_POST["stock_remark8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];



$product_code9 = $_POST["product_code9"];
$product_name9 = $_POST["product_name9"];
$unit_name9 = $_POST["unit_name9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$stock_remark9 = $_POST["stock_remark9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];


$product_code10 = $_POST["product_code10"];
$product_name10 = $_POST["product_name10"];
$unit_name10 = $_POST["unit_name10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$stock_remark10 = $_POST["stock_remark10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];







if($product_code1 !==''){

$strSQL1 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('".$ref_id."','".$product_code1."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$unit_name1."','".$product_name1."','".$sale_remarkk1."','".$stock_remark1."','".$discount_unit1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);


}

if($product_code2 !==''){

$strSQL2 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('".$ref_id."','".$product_code2."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$unit_name2."','".$product_name2."','".$sale_remarkk2."','".$stock_remark2."','".$discount_unit2."')";
$objQuery2 = mysqli_query($conn,$strSQL2);

}
if($product_code3 !==''){

$strSQL3 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('".$ref_id."','".$product_code3."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$unit_name3."','".$product_name3."','".$sale_remarkk3."','".$stock_remark3."','".$discount_unit3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
}

if($product_code4 !==''){

$strSQL4 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('".$ref_id."','".$product_code4."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$unit_name4."','".$product_name4."','".$sale_remarkk4."','".$stock_remark4."','".$discount_unit4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);

}

if($product_code5 !==''){

$strSQL5 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('".$ref_id."','".$product_code5."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$unit_name5."','".$product_name5."','".$sale_remarkk5."','".$stock_remark5."','".$discount_unit5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);
}
if($product_code6 !==''){

$strSQL6 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('".$ref_id."','".$product_code6."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$unit_name6."','".$product_name6."','".$sale_remarkk6."','".$stock_remark6."','".$discount_unit6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
}

if($product_code7 !==''){

$strSQL7 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('".$ref_id."','".$product_code7."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$unit_name7."','".$product_name7."','".$sale_remarkk7."','".$stock_remark7."','".$discount_unit7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);
}

if($product_code8 !==''){

$strSQL8 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('".$ref_id."','".$product_code8."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$unit_name8."','".$product_name8."','".$sale_remarkk8."','".$stock_remark8."','".$discount_unit8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);

}
if($product_code9 !==''){

$strSQL9 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('".$ref_id."','".$product_code9."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$unit_name9."','".$product_name9."','".$sale_remarkk9."','".$stock_remark9."','".$discount_unit9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);

}

if($product_code10 !==''){

$strSQL10 = "insert into so__submain
(ref_idd,product_code,sale_count,price_per_unit,sum_amount,unit_name,product_name,sale_remark,stock_remark,discount_unit)
values ('".$ref_id."','".$product_code10."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$unit_name10."','".$product_name10."','".$sale_remarkk10."','".$stock_remark10."','".$discount_unit10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);

}



 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_lazada.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}

	
?>