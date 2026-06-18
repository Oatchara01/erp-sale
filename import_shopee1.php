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
  
$files_url = $_POST['linkurl']; ////'uploads/installdata_test2.csv';
$objCSV = fopen($files_url,'r');
$objArr = fgetcsv($objCSV, 1000, ",");


$MSG = "";
date_default_timezone_set("Asia/Bangkok");

while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) { 

if($objArr[0]!=''){

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
$pre_name = "";

$product_code = $objArr[4];
$product_price = $objArr[9];
$sum_amount = $objArr[9];
$count = $objArr[8];



$sql21 = "SELECT ref_id,order_id FROM so__main where order_id='".$objArr[0]."' and ckk_h ='0'  and ckk_item='0'";
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

$price = $product_price/$unit1;	
	
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
	
$price_lazada = $fetch2["percen_price"]; 	

if($Num_Rows2 > 0){
	
	
if($objArr[4]=='AW100TL' or $objArr[4]=='AW50TL'  or $objArr[4]=='AW50T' or $objArr[4]=='AW25T'){

$save69="UPDATE so__main SET glu_ckk ='1' where ref_id='".$fetch21["ref_id"]."'";
$qsave69=mysqli_query($conn,$save69);	
	
}
	
	
	
if($sum_amount < $price_lazada){	
	
$strSQL15 = "SELECT ref_id,doc_no,select_type_doc FROM  so__main  where ref_id='".$fetch21["ref_id"]."'";
$objQuery15 = mysqli_query($stock_out,$strSQL15);
$objResult15 = mysqli_fetch_array($objQuery15);		


	
$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$fetch21["ref_id"]."'";
$qsave19=mysqli_query($conn,$save19);	
	
	

if($objResult15["select_type_doc"]=='3'){

$strSQL = "DELETE FROM tb_et_awl WHERE doc_no = '".$objResult15["doc_no"]."'";
$objQuery = mysqli_query($conn,$strSQL);
	
$save19="UPDATE so__main SET price_ckk ='1',doc_no ='' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	

}

if($objResult15["select_type_doc"]=='4'){
	
$strSQL = "DELETE FROM tb_et_nbm WHERE doc_no = '".$objResult15["doc_no"]."'";
$objQuery = mysqli_query($conn,$strSQL);	

$save19="UPDATE so__main SET price_ckk ='1',doc_no ='' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	

}		
	

}

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date,sku_code)
values ('".$fetch21["ref_id"]."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','".$add_date."','".$objArr[4]."')";
$objQuery1 = mysqli_query($conn,$strSQL1);


$sum_amount55 = $objArr[9]-($objArr[11]+$objArr[12]+$objArr[13]);
	
$register_date = date('Y-m-d');
$order_id = $fetch21["order_id"];

$strSQL11 = "insert into so__disecom(ref_so,price_dis,order_num,sale_chan,date_today) 
values 
('".$fetch21["ref_id"]."','".$sum_amount55."','".$objArr[0]."','12','".$register_date."')";
$objQuery11 = mysqli_query($conn,$strSQL11);		

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
		
$sku = $objArr[4];	
	



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
	
	

/*$sql22 = "SELECT ref_idd,sale_count FROM so__submain where ref_idd='".$fetch21["ref_id"]."' and sku_code='".$sku."'";
$query22 = mysqli_query($conn,$sql22) or die(mysqli_error());
$Num_Rows22 = mysqli_num_rows($query22);
$fetch22 = mysqli_fetch_array($query22);
	

if($sku=='4987067510801' or $sku=='4987067510900' or $sku=='4987067511006' ){

if ($fetch22["sale_count"] >= 1 && $fetch22["sale_count"] <= 100) {
    $count_free = $fetch22["sale_count"];
} else {
    $count_free = '0'; // ค่าเริ่มต้น ถ้าเกินขอบเขต
}
	
$strSQL19 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$fetch21["ref_id"]."','".$count_free."','".$count_free."','0.00','0.00','0.00','0.00','5795','5795','','Approve','แถมพิเศษ หน้ากากอนมัยคละสี 1 ซอง')";
$objQuery19 = mysqli_query($conn,$strSQL19);
	
} else if($sku=='4987067923809' or $sku=='4987067923908' or $sku=='4987067924004' or $sku=='4987067923106' or $sku=='4987067923205' or $sku=='4987067923304'  or $sku=='4987067140909' or $sku=='4987067141005' or $sku=='4987067141104'  or $sku=='4987067141807' or $sku=='4987067141906' or $sku=='4987067142002'  or $sku=='SUP-KOW-CFKNEM' or $sku=='SUP-KOW-CFKNEL'){

if($fetch22["sale_count"]>='2'){

if($fetch22["sale_count"] >= 2 && $fetch22["sale_count"] <= 100){
    $count_free = floor($fetch22["sale_count"] / 2); // คำนวณหารค่า free ตามที่กำหนด
} else {
    $count_free = 0; // ค่าเริ่มต้นในกรณีที่ไม่อยู่ในช่วงที่กำหนด
}


$strSQL19 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$fetch21["ref_id"]."','".$count_free."','".$count_free."','0.00','0.00','0.00','0.00','5795','5795','','Approve','แถมพิเศษ หน้ากากอนมัยคละสี 1 ซอง')";
$objQuery19 = mysqli_query($conn,$strSQL19);

}

}	
	*/

}


}else{

	
$sql31 = "SELECT ref_id FROM so__main where order_id='".$objArr[0]."'";
$query31 = mysqli_query($conn,$sql31) or die(mysqli_error());
$Num_Rows31 = mysqli_num_rows($query31);
$fetch31 = mysqli_fetch_array($query31);	

if($fetch31["ref_id"] !=''){	}else{
	

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

$product_code = $objArr[4];
$product_price = $objArr[9];
$sum_amount = $objArr[9];
$count = $objArr[8];

$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$objArr[4]."'";
//echo $sql2; //ดู SKU
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

$price_lazada = $fetch2["percen_price"]; 	

$price = $product_price/$unit1;	
	

$order_id = $objArr[0];

$customer_name = $objArr[15];
$delivery_name = $objArr[15];

$order_name = $objArr[15];
$province = $objArr[19];

$ampher = $objArr[20];



$delivery_contact = "$objArr[15] / $objArr[16]";
$address1 = $objArr[18];
$delivery_place = $objArr[18];
$postcode =	$objArr[21];


	
	
if($objArr[22]=='Yes'){	
	
$billing_address = $objArr[28];
$billing_name =	"$objArr[24] $objArr[25]";
$billing_tel = $objArr[35];
$ex_add = "$objArr[29] $objArr[30]";
$bill_ampher = $objArr[31];	
$bill_province	= $objArr[32];	
$bill_postcode =$objArr[33];		
	
$bill_vat = '1';
$send_supadm = '1';
$status_vat  = "Approve";	
if($fetch2["company"]=="AWL"){	
$select_type_doc ='3';	
}else if($fetch2["company"]=="NBM"){
$select_type_doc ='4';		
}
$payment = '36';
$account_approve = '1';	
	
}else{
$billing_address = $objArr[18];
$billing_name =	$objArr[15];
$billing_tel = $objArr[16];
$bill_ampher = $ampher;	
$bill_province	= $province;	
$bill_postcode =$postcode;	
$payment = '35';	
$account_approve = '0';		
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";	
if($fetch2["company"]=="AWL"){	
$select_type_doc ='1';	
}else if($fetch2["company"]=="NBM"){
$select_type_doc ='2';		
}
	
}

$tel = $objArr[16];
$email = $objArr[36]; 	
$add_date = date('Y-m-d H:i:s');
$order_refer_code = $objArr[3];
$sale_channel = '12';
$delivery_date = date('Y-m-d');
$employee_name ="SOL92";
$job_id = "Kerry มารับ";
$delivery = '38';

$cus_online  = $objArr[1];
$tax_id = $objArr[34];
$create_order = $objArr[2];
	
	

if($objArr[27]!=''){
$h_ckk='2';		
}else if($objArr[25]!=''){
$h_ckk='1';	
}else{
$h_ckk='0';		
}

$brun_no = "$objArr[27]";	
//echo $objArr[3];	
	
//if($objArr[3]!=''){
	
$sql9 = "SELECT customer_name FROM tb_customer where cus_online = '".$cus_online."'";
	//echo $sql9;
$query9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$Num_Rows9 = mysqli_num_rows($query9);
$fetch9 = mysqli_fetch_array($query9);
	
if($Num_Rows9 > 0){
	
$save9="UPDATE tb_customer SET
(customer_name='".$customer_name."',type_customer='7',cus_address='".$address1."',cus_ampher='".$ampher."',cus_province='".$province."',cus_postcode='".$postcode."',cus_tel='".$tel."',bill_name='".$billing_name."',bill_address='".$billing_address."',bill_ampher='".$bill_ampher."',billl_province='".$bill_province."',bill_postcode='".$bill_postcode."',bill_tel='".$billing_tel."',tax_id='".$tax_id."',delivery_name='".$delivery_name."',del_address='".$delivery_place."',del_ampher='".$ampher."',del_province='".$province."',del_postcode='".$postcode."',del_tel='".$tel."',contact_name='".$delivery_contact."',email_cus='".$email."',h_ckk='".$h_ckk."',brun_no='".$brun_no."'  where cus_online = '".$cus_online."'";
//echo $sql9;
$qsave9=mysqli_query($conn,$save9);	
	
	
}else {	
	
	
$qfirst = "select * from tb_customer ORDER BY customer_id DESC LIMIT 1";
$first = mysqli_query($conn,$qfirst);
$Num_Rows88 = mysqli_num_rows($first);
$ffirst = mysqli_fetch_array($first);
	
$customer_id = $ffirst['customer_id']+1;	
	
$save9="insert into tb_customer
(customer_name,type_customer,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,sale_code,cus_online,email_cus,h_ckk,brun_no)
values
('".$customer_name."','7','".$address1."','".$ampher."','".$province."','".$postcode."','".$tel."','".$billing_name."','".$billing_address."','".$bill_ampher."','".$bill_province."','".$bill_postcode."','".$billing_tel."','".$tax_id."','".$delivery_name."','".$delivery_place."','".$ampher."','".$province."','".$postcode."','".$tel."','".$delivery_contact."','".$employee_name."','".$cus_online."','".$email."','".$h_ckk."','".$brun_no."')";

$qsave9=mysqli_query($conn,$save9);
	
$sql = "INSERT INTO tb_selected_sales (sale_code, id_customer, customer_name) VALUES ('$employee_name', '$customer_id', '$billing_name')";
$qsave2 = mysqli_query($conn, $sql);		
	
	
}
	
	
$sql10 = "SELECT customer_id FROM tb_customer where cus_online = '".$cus_online."'";

$query10 = mysqli_query($conn,$sql10) or die(mysqli_error());
$fetch10 = mysqli_fetch_array($query10);
$bill_id = $fetch10["customer_id"];	
	
	
if($fetch2["company"]=="AWL"){	
	
	
if($objArr[22]=='Yes' and $objArr[34]!='' and $objArr[36] !=''){	
	
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
	
	

/*$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_ptl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$mont.$nextId;

$save9="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$register_date."','".$main_id."')";
$qsave9=mysqli_query($conn,$save9);	*/


	
	
	
	
}else{	
	
$sql1 = "SELECT doc_no FROM tb_solptl where sale_channel = '".$sale_channel."' and date_sol = '".$register_date."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);	

	
if($Num_Rows > 0){
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
	
}
}else if($fetch2["company"]=="NBM"){
	
	
if($objArr[22]=='Yes' and $objArr[34]!='' and $objArr[36] !=''){		
	
$date = explode('-' , $doc_release_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";
$so1 = "-";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_et_nbm (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."','".$main_id."')";
$qsave=mysqli_query($conn,$save);
	
	

/*$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";
$so1 = "/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save9="insert into tb_doc_nbm (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$register_date."','".$main_id."')";
$qsave9=mysqli_query($conn,$save9);	*/


	
	
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
	
	
	
	
}
	
	
if($select_type_doc =='3'){
$save19="UPDATE tb_doc_ptl SET ref_so ='".$main_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}else if($select_type_doc =='4'){
$save19="UPDATE tb_doc_nbm SET ref_so ='".$main_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}
	
	

 $strSQL = "INSERT INTO so__main (ref_id,register_date,register_time,delivery_name,address1,province,postcode,billing_address,billing_name,billing_tel,tel,order_id,customer_name,order_name,delivery_contact,delivery_place,add_date,add_by,order_refer_code,sale_channel,select_type_doc,doc_release_date,status_doc,delivery_date,approve_complete,employee_name,job_id,delivery,payment,sale_remark,send_stock,bill_id,doc_no,prefer_name,po_no,ex_add,ex_aumper,ex_provin,ex_post,pre_name,bill_vat,send_supadm,status_vat,tax_id,create_order,email,account_approve) VALUES ('".$main_id."','".$register_date."','".$register_time."','".$delivery_name."','".$address1."','".$province."','".$postcode."','".$billing_address."','".$billing_name."','".$billing_tel."','".$tel."','".$order_id."','".$customer_name."','".$order_name."','".$delivery_contact."','".$delivery_place."','".$add_date."','".$add_by."','".$order_refer_code."','".$sale_channel."','".$select_type_doc."','".$doc_release_date."','2','".$delivery_date."','".$approve_complete."','".$employee_name."','".$job_id."','".$delivery."','".$payment."','Shopee','1','".$bill_id."','".$doc_no."','Shopee','".$order_id."','".$ex_add."','".$bill_ampher."','".$bill_province."','".$bill_postcode."','".$pre_name."','".$bill_vat."','".$send_supadm."','".$status_vat."','".$tax_id."','".$create_order."','".$email."','".$account_approve."')";
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL)or die(mysqli_error());

	
if($Num_Rows2 > 0){
	
	
if($objArr[4]=='AW100TL' or $objArr[4]=='AW50TL'  or $objArr[4]=='AW50T' or $objArr[4]=='AW25T'){

$save69="UPDATE so__main SET glu_ckk ='1' where ref_id='".$main_id."'";
$qsave69=mysqli_query($conn,$save69);	
	
}
	
	

if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date,sku_code)
values ('".$main_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','".$add_date."','".$objArr[4]."')";
//echo $strSQL1."<br>";
$objQuery1 = mysqli_query($conn,$strSQL1);
	
	
$sum_amount55 = $objArr[9]-($objArr[11]+$objArr[12]+$objArr[13]);
	
$register_date = date('Y-m-d');
$order_id = $fetch21["order_id"];

$strSQL11 = "insert into so__disecom(ref_so,price_dis,order_num,sale_chan,date_today) 
values 
('".$main_id."','".$sum_amount55."','".$objArr[0]."','12','".$register_date."')";
$objQuery11 = mysqli_query($conn,$strSQL11);		
	

}

	
if($sum_amount < $price_lazada){	
	
$strSQL15 = "SELECT ref_id,doc_no,select_type_doc FROM  so__main  where ref_id='".$main_id."'";
$objQuery15 = mysqli_query($stock_out,$strSQL15);
$objResult15 = mysqli_fetch_array($objQuery15);	

	
	
$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);
	

	
if($objResult15["select_type_doc"]=='3'){

$strSQL = "DELETE FROM tb_et_awl WHERE doc_no = '".$objResult15["doc_no"]."'";
$objQuery = mysqli_query($conn,$strSQL);
	
$save19="UPDATE so__main SET price_ckk ='1',doc_no ='' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	

}

if($objResult15["select_type_doc"]=='4'){
	
$strSQL = "DELETE FROM tb_et_nbm WHERE doc_no = '".$objResult15["doc_no"]."'";
$objQuery = mysqli_query($conn,$strSQL);	

$save19="UPDATE so__main SET price_ckk ='1',doc_no ='' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	

}	
	
	

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
	
$sku = $objArr[4];	
	
	
	

	

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
		
	
	
	
/*$sql22 = "SELECT ref_idd,sale_count FROM so__submain where ref_idd='".$main_id."' and sku_code='".$sku."'";
$query22 = mysqli_query($conn,$sql22) or die(mysqli_error());
$Num_Rows22 = mysqli_num_rows($query22);
$fetch22 = mysqli_fetch_array($query22);
	

if($sku=='4987067510801' or $sku=='4987067510900' or $sku=='4987067511006' ){

if ($fetch22["sale_count"] >= 1 && $fetch22["sale_count"] <= 100) {
    $count_free = $fetch22["sale_count"];
} else {
    $count_free = '0'; // ค่าเริ่มต้น ถ้าเกินขอบเขต
}
	
$strSQL19 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$main_id."','".$count_free."','".$count_free."','0.00','0.00','0.00','0.00','5795','5795','','Approve','แถมพิเศษ หน้ากากอนมัยคละสี 1 ซอง')";
$objQuery19 = mysqli_query($conn,$strSQL19);
	
} else if($sku=='4987067923809' or $sku=='4987067923908' or $sku=='4987067924004' or $sku=='4987067923106' or $sku=='4987067923205' or $sku=='4987067923304'  or $sku=='4987067140909' or $sku=='4987067141005' or $sku=='4987067141104'  or $sku=='4987067141807' or $sku=='4987067141906' or $sku=='4987067142002'  or $sku=='SUP-KOW-CFKNEM' or $sku=='SUP-KOW-CFKNEL'){

if($fetch22["sale_count"]>='2'){

if($fetch22["sale_count"] >= 2 && $fetch22["sale_count"] <= 100){
    $count_free = floor($fetch21["sale_count"] / 2); // คำนวณหารค่า free ตามที่กำหนด
} else {
    $count_free = 0; // ค่าเริ่มต้นในกรณีที่ไม่อยู่ในช่วงที่กำหนด
}


$strSQL19 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$main_id."','".$count_free."','".$count_free."','0.00','0.00','0.00','0.00','5795','5795','','Approve','แถมพิเศษ หน้ากากอนมัยคละสี 1 ซอง')";
$objQuery19 = mysqli_query($conn,$strSQL19);

}

}*/	

	


	


}

	
	
	
	
if($objArr[11] !='0.00'){	
$sum_amount = -$objArr[11];	
	
$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,add_date,sale_remark,code_dis,doc_date)
values ('".$main_id."','1','1','0.00','0.00','".$sum_amount."','".$objArr[11]."','3196','3196','".$add_date."','ส่วนลดพิเศษ','".$objArr[14]."','".$register_date."')";

$objQuery3 = mysqli_query($conn,$strSQL3);	
	
}	
	
/*$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,add_date)
values ('".$main_id."','1','1','0.00','0.00','0.00','0.00','2719','2719','".$add_date."')";

$objQuery4 = mysqli_query($conn,$strSQL4);	*/
	

}
}
}
}
}
//}
	
//echo $fetch_shop;
//exit();
	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($objQuery){
	 

	 
$strSQL5 = "SELECT *  FROM so__main  WHERE sale_channel = '12' and register_date = '" . $register_date . "'  and ckk_item='0' and doc_no LIKE '%E%'";
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
$doc_no	= $objResuut5["doc_no"];
	
	
$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$objResuut5["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);	
	
$amount_1 = $objResult15["amount_1"];	

$strSQL2 = "SELECT ref_id FROM tb_register_data  WHERE ref_id = '".$objResuut5["ref_id"]."' ";
$objQuery2 = mysqli_query($code,$strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);

if($Num_Rows2 > 0){ }else{

$strSQL29="insert into   tb_register_data (IV_number,date_inv,company,customer_name,unit_cash,cash,employee_name,ref_id,credit,description,bill_id,sale_channel,summary,summary_work,summary_ckk) 
values ('".$doc_no."','".$delivery_date."','".$com."','".$billing_name."','".$amount_1."','36','".$add_by."','".$ref_id."','1','Shopee','".$bill_id."','".$sale_channel."','สมบูรณ์','สมบูรณ์','1')";
		
$objQuery29 = mysqli_query($code,$strSQL29);	
	
	 
 }
	 
}
 	 
	 
	 
$sql2 = "SELECT ref_id FROM so__main WHERE sale_channel = '12' and register_date = '" . $register_date . "' and ckk_item='0' ";
$result2 = mysqli_query($conn, $sql2);
$Num_Rows21 = mysqli_num_rows($result2);	
	 
$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '12' and register_date = '".$register_date."'";
$objQuery = mysqli_query($conn,$strSQL);	 
	 
	 
echo "<script language=\"JavaScript\">";
echo "alert('Importข้อมูลของท่านเรียบร้อยแล้วจำนวน $Num_Rows21 ออเดอร์');window.location='main_admin.php';";
echo "</script>";
	  }else{
   echo 'ไม่สามารถ Import ข้อมูลได้';
 }
?>

</div>
</body>
</html>