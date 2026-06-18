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
  
$files_url = $_POST['linkurl']; ////'uploads/installdata_test2.csv';
///เช็ค  error	file
//echo $files_url;
//exit();
$objCSV = fopen($files_url,'r');

///เช็คการอ่านไฟล์
$objArr = fgetcsv($objCSV, 1000, ",");

//echo '<br>'.$objArr[46] ;
//exit();
$MSG = "";
 	date_default_timezone_set("Asia/Bangkok");

		
//exit();


while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) { 


if($objArr[0]!=''){

$ref_id = $fetch1['ref_id']+1;
$main_id =$fetch1['main_id']+1;
$doc_release_date= date('Y-m-d');
$register_date = date('Y-m-d');
$register_time = date('H:i:s');
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$approve_complete = "Approve";
$pre_name = "คุณ";
$product_code = $objArr[29];
$price = $objArr[33];
//$sum_amount = $objArr[27];
$count = $objArr[32];



$sql21 = "SELECT ref_id FROM so__main where order_id='".$objArr[0]."'";
$query21 = mysqli_query($conn,$sql21) or die(mysqli_error());
$Num_Rows21 = mysqli_num_rows($query21);
$fetch21 = mysqli_fetch_array($query21);


if($fetch21["ref_id"]!=''){


$sql2 = "SELECT * FROM tb_product_99 where code_99='".$objArr[29]."'";
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
	

$unit11 = $fetch2["unit1"];
$unit22 = $fetch2["unit2"];
$unit33 = $fetch2["unit3"];
$unit44 = $fetch2["unit4"];
$unit55 = $fetch2["unit5"];
$unit66 = $fetch2["unit6"];
$unit77 = $fetch2["unit7"];
$unit88 = $fetch2["unit8"];
$unit99 = $fetch2["unit9"];
$unit110 = $fetch2["unit10"];


$unit1 = $count*$unit11 ;
$unit2 = $count*$unit22 ;
$unit3 = $count*$unit33 ;
$unit4 = $count*$unit44 ;
$unit5 = $count*$unit55 ;
$unit6 = $count*$unit66 ;
$unit7 = $count*$unit77 ;
$unit8 = $count*$unit88 ;	
$unit9 = $count*$unit99 ;
$unit10 = $count*$unit110 ;

$sum_amount = $price*$unit1;	
	
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


if($Num_Rows2 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$fetch21["ref_id"]."','".$unit1."','".$unit1."','".$price."','".$product_price."','".$sum_amount."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','".$add_date."')";
$objQuery1 = mysqli_query($conn,$strSQL1);
	


}


if($id_product2 !=''){

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$fetch21["ref_id"]."','".$unit2."','".$unit2."','0.00','0.00','0.00','0.00','".$id_product2."','".$id_product2."','".$waranty2."','".$add_date."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	

}


if($id_product3 !=''){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$fetch21["ref_id"]."','".$unit3."','".$unit3."','0.00','0.00','0.00','0.00','".$id_product3."','".$id_product3."','".$waranty3."','".$add_date."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
	
}
if($id_product4 !=''){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$fetch21["ref_id"]."','".$unit4."','".$unit4."','0.00','0.00','0.00','0.00','".$id_product4."','".$id_product4."','".$waranty4."','".$add_date."')";

$objQuery4 = mysqli_query($conn,$strSQL4);
	
}
	
if($id_product5 !=''){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$fetch21["ref_id"]."','".$unit5."','".$unit5."','0.00','0.00','0.00','0.00','".$id_product5."','".$id_product5."','".$waranty5."','".$add_date."')";
	$objQuery5 = mysqli_query($conn,$strSQL5);
}	

	
if($id_product6 !=''){

$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$fetch21["ref_id"]."','".$unit6."','".$unit6."','0.00','0.00','0.00','0.00','".$id_product6."','".$id_product6."','".$waranty6."','".$add_date."')";
	$objQuery6 = mysqli_query($conn,$strSQL6);
}	
		
if($id_product7 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$fetch21["ref_id"]."','".$unit7."','".$unit7."','0.00','0.00','0.00','0.00','".$id_product7."','".$id_product7."','".$waranty7."','".$add_date."')";
	$objQuery7 = mysqli_query($conn,$strSQL7);
}	

if($id_product8 !=''){

$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$fetch21["ref_id"]."','".$unit8."','".$unit8."','0.00','0.00','0.00','0.00','".$id_product8."','".$id_product8."','".$waranty8."','".$add_date."')";
	$objQuery8 = mysqli_query($conn,$strSQL8);
}		
	
if($id_product9 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$fetch21["ref_id"]."','".$unit9."','".$unit9."','0.00','0.00','0.00','0.00','".$id_product9."','".$id_product9."','".$waranty9."','".$add_date."')";
	$objQuery9 = mysqli_query($conn,$strSQL9);
}		

if($id_product10 !=''){

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$fetch21["ref_id"]."','".$unit10."','".$unit10."','0.00','0.00','0.00','0.00','".$id_product10."','".$id_product10."','".$waranty10."','".$add_date."')";
	$objQuery10 = mysqli_query($conn,$strSQL10);
}		
			
	


}

}else{



$sql1 = "SELECT MAX(main_id) AS main_id FROM so__main";
$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());
//$fetch1 = mysqli_fetch_assoc($query1);
while($fetch1 = mysqli_fetch_array($query1)){



/*$sql1 = "select * from so__main order by main_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); */

$ref_id = $fetch1['ref_id']+1;
$main_id =$fetch1['main_id']+1;
$doc_release_date= date('Y-m-d');
$register_date = date('Y-m-d');
$register_time = date('H:i:s');
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$approve_complete = "Approve";

$product_code = $objArr[29];
$price = $objArr[33];
//$sum_amount = $objArr[27];
$count = $objArr[32];


$sql2 = "SELECT * FROM tb_product_99 where code_99='".$objArr[29]."'";
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
	

$unit11 = $fetch2["unit1"];
$unit22 = $fetch2["unit2"];
$unit33 = $fetch2["unit3"];
$unit44 = $fetch2["unit4"];
$unit55 = $fetch2["unit5"];
$unit66 = $fetch2["unit6"];
$unit77 = $fetch2["unit7"];
$unit88 = $fetch2["unit8"];
$unit99 = $fetch2["unit9"];
$unit110 = $fetch2["unit10"];


$unit1 = $count*$unit11 ;
$unit2 = $count*$unit22 ;
$unit3 = $count*$unit33 ;
$unit4 = $count*$unit44 ;
$unit5 = $count*$unit55 ;
$unit6 = $count*$unit66 ;
$unit7 = $count*$unit77 ;
$unit8 = $count*$unit88 ;	
$unit9 = $count*$unit99 ;
$unit10 = $count*$unit110 ;

$sum_amount = $price*$unit1;	
	
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


if($Num_Rows2 > 0){

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$main_id."','".$unit1."','".$unit1."','".$price."','".$product_price."','".$sum_amount."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','".$add_date."')";
$objQuery1 = mysqli_query($conn,$strSQL1);
	


}


if($id_product2 !=''){

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$main_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','0.00','".$id_product2."','".$id_product2."','".$waranty2."','".$add_date."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	

}


if($id_product3 !=''){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$main_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','0.00','".$id_product3."','".$id_product3."','".$waranty3."','".$add_date."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
	
}
if($id_product4 !=''){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$main_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','0.00','".$id_product4."','".$id_product4."','".$waranty4."','".$add_date."')";

$objQuery4 = mysqli_query($conn,$strSQL4);
	
}
	
if($id_product5 !=''){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$main_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','0.00','".$id_product5."','".$id_product5."','".$waranty5."','".$add_date."')";
	$objQuery5 = mysqli_query($conn,$strSQL5);
}	

	
if($id_product6 !=''){

$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$main_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','0.00','".$id_product6."','".$id_product6."','".$waranty6."','".$add_date."')";
	$objQuery6 = mysqli_query($conn,$strSQL6);
}	
		
if($id_product7 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$main_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','0.00','".$id_product7."','".$id_product7."','".$waranty7."','".$add_date."')";
	$objQuery7 = mysqli_query($conn,$strSQL7);
}	

if($id_product8 !=''){

$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$main_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','0.00','".$id_product8."','".$id_product8."','".$waranty8."','".$add_date."')";
	$objQuery8 = mysqli_query($conn,$strSQL8);
}		
	
if($id_product9 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$main_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','0.00','".$id_product9."','".$id_product9."','".$waranty9."','".$add_date."')";
	$objQuery9 = mysqli_query($conn,$strSQL9);
}		

if($id_product10 !=''){

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$main_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','0.00','".$id_product10."','".$id_product10."','".$waranty10."','".$add_date."')";
	$objQuery10 = mysqli_query($conn,$strSQL10);
}		
			
	


}


$order_id = $objArr[0];
$ff1 =$objArr[14];
$pp1 =$objArr[15];
$customer_name = "$ff1 $pp1";
$delivery_name = "$ff1 $pp1";
$order_name = "$ff1 $pp1";


$sql20 = "SELECT province_name FROM tb_province where code_run = '".$objArr[9]."'";

$query20 = mysqli_query($conn,$sql20) or die(mysqli_error());
$fetch20 = mysqli_fetch_array($query20);
$province = $fetch20["province_name"];		

$sql21 = "SELECT province_name FROM tb_province where code_run = '".$objArr[9]."'";
$query21 = mysqli_query($conn,$sql21) or die(mysqli_error());
$fetch21 = mysqli_fetch_array($query21);
$province1 = $fetch21["province_name"];	
	
$ampher = $objArr[8];
$ampher1 = $objArr[18];
$delivery_contact = "$ff1 $pp1 / $objArr[13]";
$address_bill = "$objArr[6] $objArr[7]";
$address_cus = "$objArr[16]";
$address1 = "$objArr[16] $objArr[17]  $province1 $objArr[19]";
$delivery_place = "$objArr[16] $objArr[17]  $province1 $objArr[19]";
$postcode =	$objArr[10];
$postcode1 =	$objArr[10];
$billing_address = "$objArr[6] $objArr[7] $objArr[8] $province $objArr[10]";
$ff =$objArr[4];
$pp =$objArr[5];
$billing_name =	"$ff $pp";
$billing_tel =	$objArr[13];
$tel =	$objArr[13];
$tax_id =	$objArr[37];
if($tax_id !=''){
$bill_vat ='1';	
}else{
$bill_vat ='0';		
}
	
$email = $objArr[12];
$add_date = date('Y-m-d H:i:s');
$order_refer_code = "";
$sale_channel = '3';
$delivery_date = date('Y-m-d');
$employee_name ="SOL3";
$job_id = "";
$delivery = '1';
$payment = '22';
$prefer_name = '99 HealthMart';	

	
	
if($objArr[13]!=''){
	
$sql9 = "SELECT customer_name FROM tb_customer where cus_tel = '".$tel."'";

$query9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$Num_Rows9 = mysqli_num_rows($query9);
//$fetch9 = mysqli_fetch_array($query9);
	
if($Num_Rows9 > 0){
}else {	
	
$save9="insert into tb_customer
(customer_name,type_customer,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,sale_code,online,email_cus)
values
('".$customer_name."','6','".$address_cus."','".$ampher1."','".$province1."','".$postcode1."','".$tel."','".$billing_name."','".$address_bill."','".$ampher."','".$province."','".$postcode."','".$billing_tel."','".$tax_id."','".$delivery_name."','".$address_cus."','".$ampher."','".$province."','".$postcode."','".$tel."','".$delivery_contact."','".$employee_name."','1','".$email."')";



$qsave9=mysqli_query($conn,$save9);
	
}
}
	
$sql10 = "SELECT customer_id FROM tb_customer where cus_tel = '".$tel."'";

$query10 = mysqli_query($conn,$sql10) or die(mysqli_error());
$fetch10 = mysqli_fetch_array($query10);
$bill_id = $fetch10["customer_id"];	
	
/*$sql1 = "SELECT doc_no FROM tb_solptl where sale_channel = '".$sale_channel."' and date_sol = '".$register_date."'";
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

}*/

$doc_no = "IV";

 $strSQL = "INSERT INTO so__main (ref_id,register_date,register_time,delivery_name,address1,province,postcode,billing_address,billing_name,billing_tel,tel,order_id,customer_name,order_name,delivery_contact,delivery_place,add_date,add_by,order_refer_code,sale_channel,select_type_doc,doc_release_date,status_doc,delivery_date,employee_name,job_id,delivery,payment,sale_remark,send_stock,bill_id,doc_no,po_no,allwell_ckk,bill_vat,amount,delivery_type,delivery_time,approve_complete,ex_add,ex_aumper,ex_provin,ex_post,prefer_name,pre_name) VALUES ('".$main_id."','".$register_date."','".$register_time."','".$delivery_name."','".$address1."','".$province."','".$postcode."','".$billing_address."','".$billing_name."','".$billing_tel."','".$tel."','".$order_id."','".$customer_name."','".$order_name."','".$delivery_contact."','".$delivery_place."','".$add_date."','".$add_by."','".$order_refer_code."','".$sale_channel."','3','".$doc_release_date."','2','".$delivery_date."','".$employee_name."','".$job_id."','".$delivery."','".$payment."','','1','".$bill_id."','".$doc_no."','".$order_id."','1','".$bill_vat."','".$sum_amount."','1','ก่อน 15.00 น.','".$approve_complete."','".$address_cus."','".$ampher."','".$province."','".$postcode."','".$prefer_name."','".$pre_name."')";
      //echo $strSQL."<br>";
	   //exit();
$objQuery = mysqli_query($conn,$strSQL)or die(mysqli_error());

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
           <form action = "upload_99.php" method ="post">
    
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