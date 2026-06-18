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

	
if($objArr[8]!=''){


$sql21 = "SELECT ref_id FROM so__main where order_id='".$objArr[8]."'";
//echo $sql21."<br>";
$query21 = mysqli_query($conn,$sql21) or die(mysqli_error());
$Num_Rows21 = mysqli_num_rows($query21);
$fetch21 = mysqli_fetch_array($query21);


if($fetch21["ref_id"]!=''){

$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$objArr[4]."'";
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
	
	

$unit1 = $fetch2["unit1"];
$unit2 = $fetch2["unit2"];
$unit3 = $fetch2["unit3"];
$unit4 = $fetch2["unit4"];
$unit5 = $fetch2["unit5"];
$unit6 = $fetch2["unit6"];
$unit7 = $fetch2["unit7"];
$unit8 = $fetch2["unit8"];
$unit7 = $fetch2["unit7"];
$unit8 = $fetch2["unit8"];
$unit9 = $fetch2["unit9"];
$unit10 = $fetch2["unit10"];

	
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
	
$price_per_unit = ($objArr[42]/$unit1);	
	
if($Num_Rows2 > 0){

if($id_product1 !=''){

	$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$fetch21["ref_id"]."','".$unit1."','".$unit1."','".$price_per_unit."','".$objArr[42]."','".$objArr[42]."','0.00','".$id_product1."','".$id_product1."','".$waranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);

}


if($id_product2 !=''){

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$fetch21["ref_id"]."','".$unit2."','".$unit2."','0.00','0.00','0.00','0.00','".$id_product2."','".$id_product2."','".$waranty2."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
}


if($id_product3 !=''){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$fetch21["ref_id"]."','".$unit3."','".$unit3."','0.00','0.00','0.00','0.00','".$id_product3."','".$id_product3."','".$waranty3."')";

	$objQuery3 = mysqli_query($conn,$strSQL3);

	
}

if($id_product4 !=''){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$fetch21["ref_id"]."','".$unit4."','".$unit4."','0.00','0.00','0.00','0.00','".$id_product4."','".$id_product4."','".$waranty4."')";

	$objQuery4 = mysqli_query($conn,$strSQL4);
}
	
if($id_product5 !=''){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$fetch21["ref_id"]."','".$unit5."','".$unit5."','0.00','0.00','0.00','0.00','".$id_product5."','".$id_product5."','".$waranty5."')";
	$objQuery5 = mysqli_query($conn,$strSQL5);
}	

	
if($id_product6 !=''){

$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$fetch21["ref_id"]."','".$unit6."','".$unit6."','0.00','0.00','0.00','0.00','".$id_product6."','".$id_product6."','".$waranty6."')";
	$objQuery6 = mysqli_query($conn,$strSQL6);
}	
		
if($id_product7 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$fetch21["ref_id"]."','".$unit7."','".$unit7."','0.00','0.00','0.00','0.00','".$id_product7."','".$id_product7."','".$waranty7."')";
	$objQuery7 = mysqli_query($conn,$strSQL7);
}	

if($id_product8 !=''){

$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$fetch21["ref_id"]."','".$unit8."','".$unit8."','0.00','0.00','0.00','0.00','".$id_product8."','".$id_product8."','".$waranty8."')";
	$objQuery8 = mysqli_query($conn,$strSQL8);
}		
	
if($id_product9 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$fetch21["ref_id"]."','".$unit9."','".$unit9."','0.00','0.00','0.00','0.00','".$id_product9."','".$id_product9."','".$waranty9."')";
	$objQuery9 = mysqli_query($conn,$strSQL9);
}		

if($id_product10 !=''){

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$fetch21["ref_id"]."','".$unit10."','".$unit10."','0.00','0.00','0.00','0.00','".$id_product10."','".$id_product10."','".$waranty10."')";
	$objQuery10 = mysqli_query($conn,$strSQL10);
}		
	
	
	
	
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
$customer_name = $objArr[13];
$delivery_name = $objArr[13];
$tax_id = $objArr[37];	
$bill_vat1 = $objArr[39];
	if($bill_vat1 =='TRUE'){
	$bill_vat = '1';
	$send_supadm = '1';
	$select_type_doc = '4';	
		$status_vat  = "Approve";
	}else if($bill_vat1 =='FALSE'){
	$bill_vat = '0';
	$select_type_doc = '2';
	$send_supadm = '0';	
		$status_vat  = '';
	}
$order_name = $objArr[13];
$str_arr = explode('/',$objArr[16]);
 
$str_arr[0];
$str_arr[1];

$str_arr1 = explode('/',$objArr[17]);

$str_arr1[0];
$str_arr1[1];

$delivery_contact = "$objArr[13] / $objArr[19]";
$address1 = "$objArr[14] $objArr[15]";
$address2 = $str_arr1[0];
$delivery_place = "$objArr[14] $objArr[15] $str_arr[0]  $objArr[18]";


$postcode =	$objArr[18];
	
	$str_arr2 = explode('/',$objArr[29]);
 
$str_arr2[0];
$str_arr2[1];

$str_arr3 = explode('/',$objArr[28]);

$str_arr3[0];
$str_arr3[1];	
	
$billing_address = " $objArr[26] $objArr[27] $str_arr2[0] $str_arr3[0]  $objArr[30]";
$billing_name =	$objArr[25];
$billing_tel =	$objArr[31];
$billing_postcode =	$objArr[30];	

$tel =	$objArr[19];
$add_date = date('Y-m-d H:i:s');
   
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$order_refer_code = $objArr[36];
$order_id = $objArr[8];

 //echo $objArr[51];
//$order_refer_code = $objArr[36];
$sale_channel = '1';
$delivery = '1';
$payment = '12';
$employee_name ="(SOL99)";
$job_id = "LZD";
$approve_complete = "Approve";

	

	

$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$objArr[4]."'";
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
	
	

$unit1 = $fetch2["unit1"];
$unit2 = $fetch2["unit2"];
$unit3 = $fetch2["unit3"];
$unit4 = $fetch2["unit4"];
$unit5 = $fetch2["unit5"];
$unit6 = $fetch2["unit6"];
$unit7 = $fetch2["unit7"];
$unit8 = $fetch2["unit8"];
$unit7 = $fetch2["unit7"];
$unit8 = $fetch2["unit8"];
$unit9 = $fetch2["unit9"];
$unit10 = $fetch2["unit10"];

	
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
	
$price_per_unit = ($objArr[42]/$unit1);

if($Num_Rows2 > 0){

$sql9 = "SELECT customer_name FROM tb_customer where cus_tel = '".$tel."'";

$query9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$Num_Rows9 = mysqli_num_rows($query9);
//$fetch9 = mysqli_fetch_array($query9);
	
if($Num_Rows9 > 0){
}else {	
	
$save9="insert into tb_customer
(customer_name,type_customer,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,sale_code,cus_online)
values
('".$customer_name."','6','".$address1."','".$address2."','".$str_arr[0]."','".$postcode."','".$tel."','".$billing_name."','".$billing_address."','".$str_arr2[0]."','".$str_arr3[0]."','".$billing_postcode."','".$billing_tel."','".$tax_id."','".$delivery_name."','".$delivery_place."','".$address2."','".$str_arr[0]."','".$postcode."','".$tel."','".$delivery_contact."','".$employee_name."','".$objArr[10]."')";



$qsave9=mysqli_query($conn,$save9);
	
}
	
$sql10 = "SELECT customer_id FROM tb_customer where cus_tel = '".$tel."'";

$query10 = mysqli_query($conn,$sql10) or die(mysqli_error());
$fetch10 = mysqli_fetch_array($query10);
$bill_id = $fetch10["customer_id"];

if($bill_vat=='1'){
		
$date = explode('-' , $register_date);
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
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save9="insert into tb_doc_nbm (doc_no,year_no,mount_no,run_no) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."')";
$qsave9=mysqli_query($conn,$save9);
		
	}else{
	$sql1 = "SELECT doc_no FROM tb_solnbm where sale_channel = '".$sale_channel."' and date_sol = '".$register_date."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);	

	
if($Num_Rows > 0){
$doc_no = $rs1["doc_no"];	
}else{
$yearMonth = substr(date("Y")+543, -2).date("m");
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
	

$save="insert into tb_solnbm (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$register_date."','".$sale_channel."')";
$qsave=mysqli_query($conn,$save);

}	
	}
if($Num_Rows2 > 0){	

 $strSQL = "INSERT INTO so__main (ref_id,register_date,register_time,delivery_name,address1,province,postcode,billing_address,billing_name,billing_tel,tel,order_id,customer_name,order_name,delivery_contact,delivery_place,add_date,add_by,order_refer_code,sale_channel,select_type_doc,doc_release_date,status_doc,delivery,payment,employee_name,job_id,address2,delivery_date,approve_complete,send_stock,bill_vat,tax_id,send_supadm,status_vat,bill_id,doc_no) VALUES ('".$main_id."','".$register_date."','".$register_time."','".$delivery_name."','".$address1."','".$str_arr[0]."','".$postcode."','".$billing_address."','".$billing_name."','".$billing_tel."','".$tel."','".$order_id."','".$customer_name."','".$order_name."','".$delivery_contact."','".$delivery_place."','".$add_date."','".$add_by."','".$order_refer_code."','".$sale_channel."','2','".$doc_release_date."','".$select_type_doc."','".$delivery."','".$payment."','".$employee_name."','".$job_id."','".$address2."','".$delivery_date."','".$approve_complete."','1','".$bill_vat."','".$tax_id."','".$send_supadm."','".$status_vat."','".$bill_id."','".$doc_no."')";
 
$objQuery = mysqli_query($conn,$strSQL)or die(mysqli_error());
	
}

if($bill_vat =='1'){
		
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "SmZEYdSGJdzIAx48jPfPfoeDfxiAjsExm46nSYNdvKz";
$sMessage = "หมายเลขอ้างอิง $main_id คุณ $billing_name ต้องการบิลค่ะ ";
$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt( $chOne, CURLOPT_POST, 1);
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
if(curl_error($chOne))
{
echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne );  
		
	}
	
	
	

if($id_product1 !=''){

	$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$main_id."','".$unit1."','".$unit1."','".$price_per_unit."','".$objArr[42]."','".$objArr[42]."','0.00','".$id_product1."','".$id_product1."','".$waranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);

}


if($id_product2 !=''){

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$main_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','0.00','".$id_product2."','".$id_product2."','".$waranty2."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
}


if($id_product3 !=''){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$main_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','0.00','".$id_product3."','".$id_product3."','".$waranty3."')";

	$objQuery3 = mysqli_query($conn,$strSQL3);

}

if($id_product4 !=''){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$main_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','0.00','".$id_product4."','".$id_product4."','".$waranty4."')";

	$objQuery4 = mysqli_query($conn,$strSQL4);
	
}
	
if($id_product5 !=''){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$main_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','0.00','".$id_product5."','".$id_product5."','".$waranty5."')";
echo $strSQL5;
	
	$objQuery5 = mysqli_query($conn,$strSQL5);
}	

	
if($id_product6 !=''){

$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$main_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','0.00','".$id_product6."','".$id_product6."','".$waranty6."')";
	$objQuery6 = mysqli_query($conn,$strSQL6);
}	
		
if($id_product7 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$main_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','0.00','".$id_product7."','".$id_product7."','".$waranty7."')";
	$objQuery7 = mysqli_query($conn,$strSQL7);
}	

if($id_product8 !=''){

$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$main_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','0.00','".$id_product8."','".$id_product8."','".$waranty8."')";
	$objQuery8 = mysqli_query($conn,$strSQL8);
}		
	
if($id_product9 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$main_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','0.00','".$id_product9."','".$id_product9."','".$waranty9."')";
	$objQuery9 = mysqli_query($conn,$strSQL9);
}		

if($id_product10 !=''){

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty)
values ('".$main_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','0.00','".$id_product10."','".$id_product10."','".$waranty10."')";
	$objQuery10 = mysqli_query($conn,$strSQL10);
}		
		
	
/*if($objArr[42] > 3499){
//กระบอกน้ำสีม่วง

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,sale_remark)
values ('".$main_id."','1','1','0.00','0.00','0.00','0.00','4214','4214','0','แถมพิเศษลูกค้าซื้อครบ 3500')";

$objQuery5 = mysqli_query($conn,$strSQL5);

}else if($objArr[42] > 1499){

//กล่องใส่ยา
$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,sale_remark)
values ('".$main_id."','1','1','0.00','0.00','0.00','0.00','4170','4170','0','แถมพิเศษลูกค้าซื้อครบ 1500')";

$objQuery5 = mysqli_query($conn,$strSQL5);

}else if($objArr[42] > 499){

//ที่ตัดยา

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,sale_remark)
values ('".$main_id."','1','1','0.00','0.00','0.00','0.00','4169','4169','0','แถมพิเศษลูกค้าซื้อครบ 500')";

$objQuery5 = mysqli_query($conn,$strSQL5);

}*/
	
	

}


		   
	  }
	   }
}

	
}






	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($objQuery){
	 echo '<br>
	 <br>
<br>
<br>
<br>
<br>

	 <center>
	 <table width=60% cellpadding="4" cellspacing="0" style="border:double 5px #330033	;"><tr><td style="border:double 5px #330033	;" background =http://www.yenta4.com/webboard/upload_images/81631_688240.gif>
	   <center>
	   <br>
	   <br>
	   <br>
	   <p><legend><b> Data import successful<b><legend></p> 
	   <br>
	   <br>
	   <br>
           <form action = "main_admin.php" method ="post">
    
  <input type="submit" class="button button3""  value="กลับสู่หน้าหลัก">
  </center>
  <br>
	   <br>
	   <br>
           </form>
		   </td></tr></table>
          </center> ';
	  }else{
   echo 'ไม่สามารถ Import ข้อมูลได้';
 }
?>
<br>
	   <br>
	   <br>
	   <br>
	   <br>
	   <br>
 </center> 

 </br>

<?php include('foot.php'); ?>
</div>
</body>
</html>