<?php include('head.php'); ?>


<style type="text/css">
<!--
.style15 {
	font-size: 17px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
	
.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>

<body>
<?
include "dbconnect.php";
include "dbconnect_acc.php";
	
   	date_default_timezone_set("Asia/Bangkok");

$files_url = $_POST['linkurl']; ////'uploads/installdata_test2.csv';
$objCSV = fopen($files_url,'r');

$objArr = fgetcsv($objCSV, 1000, ",");

while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) { 

	
if($objArr[6]!=''){
	
$sql21 = "SELECT ref_id FROM so__main where order_id='".$objArr[6]."'";
$query21 = mysqli_query($conn,$sql21) or die(mysqli_error());
$Num_Rows21 = mysqli_num_rows($query21);
$fetch21 = mysqli_fetch_array($query21);


if($fetch21["ref_id"]!=''){

$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$objArr[12]."'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($query2);
$fetch2 = mysqli_fetch_array($query2);

$id_product1 = $fetch2["id_product1"];
$id_product2 = $fetch2["id_product2"];
$id_product3 = $fetch2["id_product3"];
$id_product4 = $fetch2["id_product4"];
$id_product5 = $fetch2["id_product5"];
$id_product6 = $fetch2["id_product6"];
$id_product7 = $fetch2["id_product7"];
$id_product8 = $fetch2["id_product8"];
$id_product9 = $fetch2["id_product9"];
$id_product10 = $fetch2["id_product10"];
	
	

$unit1 = $fetch2["unit1"]*$objArr[15];
$unit2 = $fetch2["unit2"]*$objArr[15];
$unit3 = $fetch2["unit3"]*$objArr[15];
$unit4 = $fetch2["unit4"]*$objArr[15];
$unit5 = $fetch2["unit5"]*$objArr[15];
$unit6 = $fetch2["unit6"]*$objArr[15];
$unit7 = $fetch2["unit7"]*$objArr[15];
$unit8 = $fetch2["unit8"]*$objArr[15];
$unit7 = $fetch2["unit7"]*$objArr[15];
$unit8 = $fetch2["unit8"]*$objArr[15];
$unit9 = $fetch2["unit9"]*$objArr[15];
$unit10 = $fetch2["unit10"]*$objArr[15];

	
$waranty1 = $fetch2["waranty1"];
$waranty2 = $fetch2["waranty2"];
$waranty3 = $fetch2["waranty3"];
$waranty4 = $fetch2["waranty4"];
$waranty5 = $fetch2["waranty5"];
$waranty6 = $fetch2["waranty6"];
$waranty7 = $fetch2["waranty7"];
$waranty8 = $fetch2["waranty8"];
$waranty9 = $fetch2["waranty9"];
$waranty10 = $fetch2["waranty10"];
	
$price_per_unit = $objArr[13]/$unit1;	
$sum_amount = $objArr[13];
	
$price_lazada = $fetch2["percen_price"];


if($sum_amount < $price_lazada){
	
$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$fetch21["ref_id"]."'";
$qsave19=mysqli_query($conn,$save19);	
	
}	
	
if($Num_Rows2 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit1."','".$unit1."','".$price_per_unit."','".$price_per_unit."','".$sum_amount."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','Approve')";

$objQuery1 = mysqli_query($conn,$strSQL1);

}


if($id_product2 !=''){

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit2."','".$unit2."','0.00','0.00','0.00','0.00','".$id_product2."','".$id_product2."','".$waranty2."','Approve')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
}


if($id_product3 !=''){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit3."','".$unit3."','0.00','0.00','0.00','0.00','".$id_product3."','".$id_product3."','".$waranty3."','Approve')";

	$objQuery3 = mysqli_query($conn,$strSQL3);

	
}

if($id_product4 !=''){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit4."','".$unit4."','0.00','0.00','0.00','0.00','".$id_product4."','".$id_product4."','".$waranty4."','Approve')";

	$objQuery4 = mysqli_query($conn,$strSQL4);
}
	
if($id_product5 !=''){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit5."','".$unit5."','0.00','0.00','0.00','0.00','".$id_product5."','".$id_product5."','".$waranty5."','Approve')";
	$objQuery5 = mysqli_query($conn,$strSQL5);
}	

	
if($id_product6 !=''){

$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit6."','".$unit6."','0.00','0.00','0.00','0.00','".$id_product6."','".$id_product6."','".$waranty6."','Approve')";
	$objQuery6 = mysqli_query($conn,$strSQL6);
}	
		
if($id_product7 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit7."','".$unit7."','0.00','0.00','0.00','0.00','".$id_product7."','".$id_product7."','".$waranty7."','Approve')";
	$objQuery7 = mysqli_query($conn,$strSQL7);
}	

if($id_product8 !=''){

$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit8."','".$unit8."','0.00','0.00','0.00','0.00','".$id_product8."','".$id_product8."','".$waranty8."','Approve')";
	$objQuery8 = mysqli_query($conn,$strSQL8);
}		
	
if($id_product9 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit9."','".$unit9."','0.00','0.00','0.00','0.00','".$id_product9."','".$id_product9."','".$waranty9."','Approve')";
	$objQuery9 = mysqli_query($conn,$strSQL9);
}		

if($id_product10 !=''){

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit10."','".$unit10."','0.00','0.00','0.00','0.00','".$id_product10."','".$id_product10."','".$waranty10."','Approve')";
	$objQuery10 = mysqli_query($conn,$strSQL10);
}	
	
	
	
	
$sku = $objArr[11];	
	
	
}




}else{
	


$sql1 = "SELECT MAX(main_id) AS main_id FROM so__main";
$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());
//$fetch1 = mysqli_fetch_assoc($query1);
while($fetch1 = mysqli_fetch_array($query1)){

$ref_id = $fetch1['ref_id']+1;
$main_id =$fetch1['main_id']+1;
$doc_release_date= date('Y-m-d'); //$objArr[2];
$register_date = date('Y-m-d');
$register_time = date('H:i:s');
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$approve_complete = "Approve";
	
	

	

$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$objArr[12]."'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($query2);
$fetch2 = mysqli_fetch_array($query2);

$id_product1 = $fetch2["id_product1"];

$id_product2 = $fetch2["id_product2"];
$id_product3 = $fetch2["id_product3"];
$id_product4 = $fetch2["id_product4"];
$id_product5 = $fetch2["id_product5"];
$id_product6 = $fetch2["id_product6"];
$id_product7 = $fetch2["id_product7"];
$id_product8 = $fetch2["id_product8"];
$id_product9 = $fetch2["id_product9"];
$id_product10 = $fetch2["id_product10"];
	
	

$unit1 = $fetch2["unit1"]*$objArr[15];
$unit2 = $fetch2["unit2"]*$objArr[15];
$unit3 = $fetch2["unit3"]*$objArr[15];
$unit4 = $fetch2["unit4"]*$objArr[15];
$unit5 = $fetch2["unit5"]*$objArr[15];
$unit6 = $fetch2["unit6"]*$objArr[15];
$unit7 = $fetch2["unit7"]*$objArr[15];
$unit8 = $fetch2["unit8"]*$objArr[15];
$unit7 = $fetch2["unit7"]*$objArr[15];
$unit8 = $fetch2["unit8"]*$objArr[15];
$unit9 = $fetch2["unit9"]*$objArr[15];
$unit10 = $fetch2["unit10"]*$objArr[15];

	
$waranty1 = $fetch2["waranty1"];
$waranty2 = $fetch2["waranty2"];
$waranty3 = $fetch2["waranty3"];
$waranty4 = $fetch2["waranty4"];
$waranty5 = $fetch2["waranty5"];
$waranty6 = $fetch2["waranty6"];
$waranty7 = $fetch2["waranty7"];
$waranty8 = $fetch2["waranty8"];
$waranty9 = $fetch2["waranty9"];
$waranty10 = $fetch2["waranty10"];
	
$price_per_unit = $objArr[13]/$unit1;	
$sum_amount = $objArr[13];
	
	
if($Num_Rows2 > 0){


	
$order_id = $objArr[6];

$customer_name = $objArr[18];
$delivery_name = $objArr[18];

$order_name = $objArr[18];
$province = $objArr[23];

$ampher = $objArr[22];



$delivery_contact = "$objArr[18] / $objArr[19]";
$address1 = $objArr[21];
$delivery_place = "$objArr[21] $objArr[22] $objArr[23] $objArr[24]";
$postcode =	$objArr[24];


$bill_vat = '1';
$send_supadm = '1';
$status_vat  = "Approve";	
$select_type_doc ='3';	
$payment = '36';
$account_approve = '1';		
	
if($objArr[35]!=''){	
	
$billing_address = $objArr[32];
$billing_name =	$objArr[28];
$billing_tel = $objArr[36];
$ex_add = "$objArr[33] $objArr[30]";
$bill_ampher = '';	
$bill_province	= '';	
$bill_postcode =$objArr[34];		
	
}else{
	
$billing_address = "$objArr[21] $objArr[22] $objArr[23] $objArr[24]";
$billing_name =	$objArr[18];
$billing_tel = $objArr[19];
$ex_add = $objArr[21];	
$bill_ampher = $objArr[22];	
$bill_province	= $province;	
$bill_postcode =$postcode;	


}

$tel = $objArr[19];
$email = $objArr[26]; 	
$add_date = date('Y-m-d H:i:s');
$order_refer_code = $objArr[17];
$sale_channel = '44';
$delivery_date = date('Y-m-d');
$employee_name ="SOL94";
$job_id = "Amaze";
$delivery = '37';

$cus_online  = $objArr[1];
$tax_id = $objArr[35];
$create_order = $objArr[4];
$address2 = $objArr[22];	
	


$brun_no = $objArr[31];	
//echo $objArr[3];	
	
if($objArr[6]!=''){
	
$sql9 = "SELECT customer_name FROM tb_customer where cus_tel = '".$objArr[19]."'";
$query9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$Num_Rows9 = mysqli_num_rows($query9);
$fetch9 = mysqli_fetch_array($query9);
	
if($Num_Rows9 > 0){
	
$save9="UPDATE tb_customer SET
(customer_name='".$customer_name."',type_customer='7',cus_address='".$address1."',cus_ampher='".$ampher."',cus_province='".$province."',cus_postcode='".$postcode."',cus_tel='".$tel."',bill_name='".$billing_name."',bill_address='".$billing_address."',bill_ampher='".$bill_ampher."',billl_province='".$bill_province."',bill_postcode='".$bill_postcode."',bill_tel='".$billing_tel."',tax_id='".$tax_id."',delivery_name='".$delivery_name."',del_address='".$delivery_place."',del_ampher='".$ampher."',del_province='".$province."',del_postcode='".$postcode."',del_tel='".$tel."',contact_name='".$delivery_contact."',email_cus='".$email."',h_ckk='".$h_ckk."',brun_no='".$brun_no."'  where cus_tel = '".$objArr[19]."'";
//echo $sql9;
$qsave9=mysqli_query($conn,$save9);	
	
	
}else {	
	
$save9="insert into tb_customer
(customer_name,type_customer,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,sale_code,cus_online,email_cus,h_ckk,brun_no)
values
('".$customer_name."','7','".$address1."','".$ampher."','".$province."','".$postcode."','".$tel."','".$billing_name."','".$billing_address."','".$bill_ampher."','".$bill_province."','".$bill_postcode."','".$billing_tel."','".$tax_id."','".$delivery_name."','".$delivery_place."','".$ampher."','".$province."','".$postcode."','".$tel."','".$delivery_contact."','".$employee_name."','".$cus_online."','".$email."','".$h_ckk."','".$brun_no."')";

$qsave9=mysqli_query($conn,$save9);
	
}
	
	
$sql10 = "SELECT customer_id FROM tb_customer where cus_tel = '".$objArr[19]."'";

$query10 = mysqli_query($conn,$sql10) or die(mysqli_error());
$fetch10 = mysqli_fetch_array($query10);
$bill_id = $fetch10["customer_id"];	
	
	
	
	
if($objArr[35]!=''){	
	
$date = explode('-' , $doc_release_date );
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
		
$save5="insert into tb_et_awl (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."','".$main_id."')";
$qsave5=mysqli_query($conn,$save5);	
	
	
}else{		
	
$date = explode('-' , $doc_release_date );
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

$save9="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$register_date."','".$main_id."')";
$qsave9=mysqli_query($conn,$save9);	

	
}
	
	
if($select_type_doc =='3'){
$save19="UPDATE tb_doc_ptl SET ref_so ='".$main_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}else if($select_type_doc =='4'){
$save19="UPDATE tb_doc_nbm SET ref_so ='".$main_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}
	
	

 $strSQL = "INSERT INTO so__main (ref_id,register_date,register_time,delivery_name,address1,address2,province,postcode,billing_address,billing_name,billing_tel,tel,order_id,customer_name,order_name,delivery_contact,delivery_place,add_date,add_by,order_refer_code,sale_channel,select_type_doc,doc_release_date,status_doc,delivery_date,approve_complete,employee_name,job_id,delivery,payment,sale_remark,send_stock,bill_id,doc_no,prefer_name,po_no,ex_add,ex_aumper,ex_provin,ex_post,pre_name,bill_vat,send_supadm,status_vat,tax_id,create_order,email,account_approve) VALUES ('".$main_id."','".$register_date."','".$register_time."','".$delivery_name."','".$address1."','".$address2."','".$province."','".$postcode."','".$billing_address."','".$billing_name."','".$billing_tel."','".$tel."','".$order_id."','".$customer_name."','".$order_name."','".$delivery_contact."','".$delivery_place."','".$add_date."','".$add_by."','".$order_refer_code."','".$sale_channel."','".$select_type_doc."','".$doc_release_date."','2','".$delivery_date."','".$approve_complete."','".$employee_name."','".$job_id."','".$delivery."','".$payment."','Amaze','1','".$bill_id."','".$doc_no."','Amaze','".$order_id."','".$ex_add."','".$bill_ampher."','".$bill_province."','".$bill_postcode."','".$pre_name."','".$bill_vat."','".$send_supadm."','".$status_vat."','".$tax_id."','".$create_order."','".$email."','".$account_approve."')";
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL)or die(mysqli_error());
	
	
}
//mysql_affected_rows()

$price_lazada = $fetch2["percen_price"];


if($sum_amount < $price_lazada){
	
$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	
	
}
	
if($id_product1 !=''){

	$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit1."','".$unit1."','".$price_per_unit."','".$price_per_unit."','".$sum_amount."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','Approve')";

$objQuery1 = mysqli_query($conn,$strSQL1);

}


if($id_product2 !=''){

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','0.00','".$id_product2."','".$id_product2."','".$waranty2."','Approve')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
}


if($id_product3 !=''){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','0.00','".$id_product3."','".$id_product3."','".$waranty3."','Approve')";

	$objQuery3 = mysqli_query($conn,$strSQL3);

}

if($id_product4 !=''){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','0.00','".$id_product4."','".$id_product4."','".$waranty4."','Approve')";

	$objQuery4 = mysqli_query($conn,$strSQL4);
	
}
	
if($id_product5 !=''){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','0.00','".$id_product5."','".$id_product5."','".$waranty5."','Approve')";
//echo $strSQL5;
	
	$objQuery5 = mysqli_query($conn,$strSQL5);
}	

	
if($id_product6 !=''){

$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','0.00','".$id_product6."','".$id_product6."','".$waranty6."','Approve')";
	$objQuery6 = mysqli_query($conn,$strSQL6);
}	
		
if($id_product7 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','0.00','".$id_product7."','".$id_product7."','".$waranty7."','Approve')";
	$objQuery7 = mysqli_query($conn,$strSQL7);
}	

if($id_product8 !=''){

$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','0.00','".$id_product8."','".$id_product8."','".$waranty8."','Approve')";
	$objQuery8 = mysqli_query($conn,$strSQL8);
}		
	
if($id_product9 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','0.00','".$id_product9."','".$id_product9."','".$waranty9."','Approve')";
	$objQuery9 = mysqli_query($conn,$strSQL9);
}		

if($id_product10 !=''){

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','0.00','".$id_product10."','".$id_product10."','".$waranty10."','Approve')";
	$objQuery10 = mysqli_query($conn,$strSQL10);
}		

	
$sku = $objArr[8];		
	
if($objArr[16] !='0.00'){	
$sum_amount = -$objArr[16];	
	
$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,add_date,sale_remark,code_dis,doc_date)
values ('".$main_id."','1','1','0.00','0.00','".$sum_amount."','".$objArr[16]."','3196','3196','".$add_date."','ส่วนลดพิเศษ','','".$register_date."')";

$objQuery3 = mysqli_query($conn,$strSQL3);	
	
}	
		

}


		   
	  }
	   }
}
}
		
	
	
	

	







	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($objQuery){
	 
	 
 $strSQL5 = "SELECT *  FROM so__main  WHERE sale_channel = '44' and register_date = '" . $register_date . "' and select_type_doc='3'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die(mysqli_error());
while($objResuut5 = mysqli_fetch_array($objQuery5)){
	
if ($objResuut5["select_type_doc"]=='3'){
$com ="ออลล์เวล ไลฟ์ บจก.";
}else if ($objResuut5["select_type_doc"]=='4'){
$com="โนเบิล เมด บจก.";	
}	
	
if($objResuut5["delivery_date"]!='0000-00-00'){		
$delivery_date = $objResuut5["delivery_date"];
}else{
$delivery_date = $objResuut5["doc_release_date"];	
}	
		
$billing_name = $objResuut5["billing_name"];
$ref_id = $objResuut5["ref_id"];	
$bill_id = $objResuut5["bill_id"];	
$sale_channel = $objResuut5["sale_channel"];	
$doc_no = $objResuut5["doc_no"];		
	
$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$objResuut5["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);	
	
$amount_1 = $objResult15["amount_1"];	

$strSQL2 = "SELECT ref_id FROM tb_register_data  WHERE ref_id = '".$objResuut5["ref_id"]."' ";
$objQuery2 = mysqli_query($code,$strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);

if($Num_Rows2 > 0){ }else{

$strSQL29="insert into   tb_register_data (IV_number,date_inv,company,customer_name,unit_cash,cash,employee_name,ref_id,credit,description,bill_id,sale_channel,summary,summary_work,summary_ckk) values ('".$doc_no."','".$delivery_date."','".$com."','".$billing_name."','".$amount_1."','36','".$add_by."','".$ref_id."','1','BeDee','".$bill_id."','".$sale_channel."','สมบูรณ์','สมบูรณ์','1')";
		
$objQuery29 = mysqli_query($code,$strSQL29);	
	
	 
 }
	 
}
 //}	 
	 
	 
$sql2 = "SELECT ref_id FROM so__main WHERE sale_channel = '44' and register_date = '" . $register_date . "' and register_time = '" . $register_time . "' and add_by ='" . $add_by . "' ";
$result2 = mysqli_query($conn, $sql2);
$Num_Rows21 = mysqli_num_rows($result2);	
	 
	echo "<script language=\"JavaScript\">";
echo "alert('Importข้อมูลของท่านเรียบร้อยแล้วจำนวน $Num_Rows21 ออเดอร์');window.location='main_admin.php';";
echo "</script>";
	  }else{
   echo 'ไม่สามารถ Import ข้อมูลได้';
 }
?>

<?php include('foot.php'); ?>
