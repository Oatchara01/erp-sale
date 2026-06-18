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
   	date_default_timezone_set("Asia/Bangkok");

$files_url = $_POST['linkurl']; ////'uploads/installdata_test2.csv';
$objCSV = fopen($files_url,'r');

$objArr = fgetcsv($objCSV, 1000, ",");

while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) { 
	


if($objArr[0]!=''){

$order_id = trim($objArr[0]);

$sql21 = "SELECT ref_id FROM so__main where order_id='".$order_id."'";

$query21 = mysqli_query($conn,$sql21) or die(mysqli_error());
$Num_Rows21 = mysqli_num_rows($query21);
$fetch21 = mysqli_fetch_array($query21);


if($fetch21["ref_id"]!=''){

$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$objArr[21]."'";
//echo $sql2."<br>";
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
	
	

$unit1 = $fetch2["unit1"]*$objArr[23];
$unit2 = $fetch2["unit2"]*$objArr[23];
$unit3 = $fetch2["unit3"]*$objArr[23];
$unit4 = $fetch2["unit4"]*$objArr[23];
$unit5 = $fetch2["unit5"]*$objArr[23];
$unit6 = $fetch2["unit6"]*$objArr[23];
$unit7 = $fetch2["unit7"]*$objArr[23];
$unit8 = $fetch2["unit8"]*$objArr[23];
$unit7 = $fetch2["unit7"]*$objArr[23];
$unit8 = $fetch2["unit8"]*$objArr[23];
$unit9 = $fetch2["unit9"]*$objArr[23];
$unit10 = $fetch2["unit10"]*$objArr[23];

	
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
	
$sum_amount = $objArr[3];
$price_per_unit = $objArr[5];	
$discount_unit = $objArr[7];	
	
	
$price_lazada = $fetch2["percen_price"];


if($sum_amount < $price_lazada){
	
$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$fetch21["ref_id"]."'";
$qsave19=mysqli_query($conn,$save19);	
	
}	
	
	
	
	
if($Num_Rows2 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit1."','".$unit1."','".$price_per_unit."','".$sum_amount."','".$sum_amount."','".$discount_unit."','".$id_product1."','".$id_product1."','".$waranty1."','Approve')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
	
/*if($objArr[14]!='' or $objArr[14]!='0' or $objArr[14]!='0.00'){	
$sum_dis = "-$objArr[14]";
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit1."','".$unit1."','0.00','0.00','".$sum_dis."','".$objArr[14]."','3196','3196','','Approve')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}*/

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
	
	
$sku = $objArr[21];	
	

/*$sql22 = "SELECT ref_idd FROM so__submain where ref_idd='".$fetch21["ref_id"]."' and sale_remark LIKE '%แถมพิเศษ ปฏิทิน ปี 2025%'";
$query22 = mysqli_query($conn,$sql22) or die(mysqli_error());
$Num_Rows22 = mysqli_num_rows($query22);
$fetch22 = mysqli_fetch_array($query22);
	
if($fetch22["ref_idd"]!=''){	}else{	

$skuss = array(
    "GBWHGK", "GBWHGK+Superior", "BBBWHGK", "BBBSWHGK", "BBBWHGK+Superior", "BBBSWHGK+Superior", "WCH-DON-MOVD1BLA", "WCH-DON-MOVD1BLA+Superior", "WKI-OSC-WALKASIL", "Community", "Community+bedsheet", "Community+MPAllwell", "DYMR15cm", "DYMR15cm+bedsheet", "DYMR15cm+MPAllwell", "DYMR10cm", "DYMR10cm+bedsheet", "DYMR10cm+MPAllwell", "PMLG1PCS", "PMLG3PCS", "PMLG6PCS"
);


if (!empty($sku) && in_array($sku, $skuss)) {

	
$strSQL19 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$fetch21["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5734','5734','','Approve','แถมพิเศษ ปฏิทิน ปี 2025')";
$objQuery19 = mysqli_query($conn,$strSQL19);	
	
} else {

}	
	
}	*/
		
	
	
}



}else{

	

$sql1 = "SELECT MAX(main_id) AS main_id FROM so__main";
$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());
//$fetch1 = mysqli_fetch_assoc($query1);
while($fetch1 = mysqli_fetch_array($query1)){

$ref_id = $fetch1['ref_id']+1;
$main_id =$fetch1['main_id']+1;
$doc_release_date= date('Y-m-d');
$register_date = date('Y-m-d');
$register_time = date('H:i:s');
$delivery_date = date('Y-m-d');
$customer_name = $objArr[32];
$delivery_name = $objArr[32];
$tax_id = "";	
	
	
$create = substr($objArr[2],0,10);	
$create_time = substr($objArr[2],-9);	
$date_arr = explode('/' ,$create);
$xdate = $date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0];
$create_order = "$xdate $create_time";	

$tel = $objArr[27];
$order_name = $objArr[32];
$delivery_contact = "$objArr[32]/$tel";
$address1 = "$objArr[26] $objArr[30]";
$address2 = $objArr[29];
$province = $objArr[28];
$delivery_place = "$objArr[26] $objArr[30] $objArr[29] $objArr[28] $objArr[31]";
$ampher = $objArr[29];

$postcode =	$objArr[31];
	
$billing_address = "$objArr[26] $objArr[30] $objArr[29] $objArr[28] $objArr[31]";
$billing_name =	$objArr[32];
$billing_tel =	substr($objArr[27],10);
$billing_postcode =	$objArr[31];
$billing_add = "$objArr[26] $objArr[30]";
$billing_aum = $objArr[29];
$billing_pro = $objArr[28];	

	
		
$sql9 = "SELECT customer_name FROM tb_customer where cus_tel LIKE '%".$tel."%'";
$query9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$Num_Rows9 = mysqli_num_rows($query9);
$fetch9 = mysqli_fetch_array($query9);
	
if($Num_Rows9 > 0){
	
$save9="UPDATE tb_customer SET
(customer_name='".$customer_name."',type_customer='7',cus_address='".$address1."',cus_ampher='".$ampher."',cus_province='".$province."',cus_postcode='".$postcode."',cus_tel='".$tel."',bill_name='".$billing_name."',bill_address='".$billing_address."',bill_ampher='".$bill_ampher."',billl_province='".$billl_province."',bill_postcode='".$bill_postcode."',bill_tel='".$$billing_tel."',tax_id='".$tax_id."',delivery_name='".$delivery_name."',del_address='".$delivery_place."',del_ampher='".$ampher."',del_province='".$province."',del_postcode='".$postcode."',del_tel='".$tel."',contact_name='".$delivery_contact."',email_cus='".$email."',h_ckk='".$h_ckk."',brun_no='".$brun_no."'  where cus_tel = '".$cus_online."'";

$qsave9=mysqli_query($conn,$save9);	
	
	
}else{	
	
$save9="insert into tb_customer
(customer_name,type_customer,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,sale_code,cus_online,email_cus,h_ckk,brun_no)
values
('".$customer_name."','7','".$address1."','".$ampher."','".$province."','".$postcode."','".$tel."','".$billing_name."','".$billing_address."','".$ampher."','".$province."','".$billing_postcode."','".$billing_tel."','".$tax_id."','".$delivery_name."','".$delivery_place."','".$ampher."','".$province."','".$postcode."','".$tel."','".$delivery_contact."','".$employee_name."','','".$email."','".$h_ckk."','".$brun_no."')";
$qsave9=mysqli_query($conn,$save9);
	
}
	
$sql10 = "SELECT customer_id FROM tb_customer where cus_tel LIKE '%".$tel."%'";
$query10 = mysqli_query($conn,$sql10) or die(mysqli_error());
$fetch10 = mysqli_fetch_array($query10);
$bill_id = $fetch10["customer_id"];	




$add_date = date('Y-m-d H:i:s');
   
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$order_refer_code = $objArr[34];
$order_id = trim($objArr[0]);

$sale_channel = '38';
	
$delivery = '34';
$payment = '35';
$employee_name ="SOL94";
$job_id = "Thisshop";
$approve_complete = "Approve";
$pre_name = 'คุณ';
	

	

$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$objArr[21]."'";
//echo $sql2 ;
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
	
	

$unit1 = $fetch2["unit1"]*$objArr[23];
$unit2 = $fetch2["unit2"]*$objArr[23];
$unit3 = $fetch2["unit3"]*$objArr[23];
$unit4 = $fetch2["unit4"]*$objArr[23];
$unit5 = $fetch2["unit5"]*$objArr[23];
$unit6 = $fetch2["unit6"]*$objArr[23];
$unit7 = $fetch2["unit7"]*$objArr[23];
$unit8 = $fetch2["unit8"]*$objArr[23];
$unit7 = $fetch2["unit7"]*$objArr[23];
$unit8 = $fetch2["unit8"]*$objArr[23];
$unit9 = $fetch2["unit9"]*$objArr[23];
$unit10 = $fetch2["unit10"]*$objArr[23];

	
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
	
$sum_amount = $objArr[3];
$price_per_unit = $objArr[5];	
$discount_unit = $objArr[7];	



$date = explode('-' , $register_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
	
if($Num_Rows2  > 0){	
	
$sql1 = "SELECT doc_no FROM tb_solptl where sale_channel = '".$sale_channel."' and date_sol = '".$register_date."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);	

	
if($Num_Rows>0){
$doc_no = $rs1["doc_no"];	
}else{

$yearMonth = substr(date("Y")+543, -2).date("m");
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
	

$save="insert into tb_solptl (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$register_date."','".$sale_channel."')";
$qsave=mysqli_query($conn,$save);

}
	
$bill_vat = '0';
$send_supadm = '0';
$select_type_doc = '1';	
$status_vat  = "";	
	


$strSQL = "INSERT INTO so__main (ref_id,register_date,register_time,delivery_name,address1,address2,province,postcode,billing_address,billing_name,billing_tel,tel,order_id,customer_name,order_name,delivery_contact,delivery_place,add_date,add_by,order_refer_code,sale_channel,select_type_doc,doc_release_date,status_doc,delivery_date,approve_complete,employee_name,job_id,delivery,payment,sale_remark,send_stock,bill_id,doc_no,prefer_name,po_no,ex_add,ex_aumper,ex_provin,ex_post,pre_name,tax_id,bill_vat,send_supadm,status_vat,create_order) VALUES ('".$main_id."','".$register_date."','".$register_time."','".$delivery_name."','".$address1."','".$address2."','".$province."','".$postcode."','".$billing_address."','".$billing_name."','".$billing_tel."','".$tel."','".$order_id."','".$customer_name."','".$order_name."','".$delivery_contact."','".$delivery_place."','".$add_date."','".$add_by."','".$order_refer_code."','".$sale_channel."','".$select_type_doc."','".$doc_release_date."','".$select_type_doc."','".$delivery_date."','".$approve_complete."','".$employee_name."','".$job_id."','".$delivery."','".$payment."','Thisshop','1','".$bill_id."','".$doc_no."','Thisshop','".$order_id."','".$billing_add."','".$billing_aum."','".$billing_pro."','".$billing_postcode."','".$pre_name."','".$tax_id."','".$bill_vat."','".$send_supadm."','".$status_vat."','".$create_order."')";

$objQuery = mysqli_query($conn,$strSQL)or die(mysqli_error());





$save19="UPDATE tb_doc_ptl SET ref_so ='".$main_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	

}


$price_lazada = $fetch2["percen_price"];


if($sum_amount < $price_lazada){
	
$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	
	
}
	
if($id_product1 !=''){

	$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit1."','".$unit1."','".$price_per_unit."','".$sum_amount."','".$sum_amount."','".$discount_unit."','".$id_product1."','".$id_product1."','".$waranty1."','Approve')";

$objQuery1 = mysqli_query($conn,$strSQL1);

	
/*if($objArr[14]!='' or $objArr[14]!='0' or $objArr[14]!='0.00'){	
$sum_dis = "-$objArr[14]";
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit1."','".$unit1."','0.00','0.00','".$sum_dis."','".$objArr[14]."','3196','3196','','Approve')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}*/	
	
	
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
		

$sku = $objArr[21];		
	

/*$sql22 = "SELECT ref_idd FROM so__submain where ref_idd='".$main_id."' and sale_remark LIKE '%แถมพิเศษ ปฏิทิน ปี 2025%'";
$query22 = mysqli_query($conn,$sql22) or die(mysqli_error());
$Num_Rows22 = mysqli_num_rows($query22);
$fetch22 = mysqli_fetch_array($query22);
	
if($fetch22["ref_idd"]!=''){	}else{	

$skuss = array(
    "GBWHGK", "GBWHGK+Superior", "BBBWHGK", "BBBSWHGK", "BBBWHGK+Superior", "BBBSWHGK+Superior", "WCH-DON-MOVD1BLA", "WCH-DON-MOVD1BLA+Superior", "WKI-OSC-WALKASIL", "Community", "Community+bedsheet", "Community+MPAllwell", "DYMR15cm", "DYMR15cm+bedsheet", "DYMR15cm+MPAllwell", "DYMR10cm", "DYMR10cm+bedsheet", "DYMR10cm+MPAllwell", "PMLG1PCS", "PMLG3PCS", "PMLG6PCS"
);


if (!empty($sku) && in_array($sku, $skuss)) {

	
$strSQL19 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$main_id."','1','1','0.00','0.00','0.00','0.00','5734','5734','','Approve','แถมพิเศษ ปฏิทิน ปี 2025')";
$objQuery19 = mysqli_query($conn,$strSQL19);	
	
} else {

}	
	
}*/	
	
	

}


		   
	  }
	   }
}
	

	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($objQuery){
$sql2 = "SELECT ref_id FROM so__main WHERE sale_channel = '38' and register_date = '" . $register_date . "' and register_time = '" . $register_time . "' and add_by ='" . $add_by . "' ";
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
