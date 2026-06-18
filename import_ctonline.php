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


	
if($objArr[2]!=''){


$sql21 = "SELECT ref_id FROM so__main where order_id='".$objArr[1]."'";
//echo $sql21."<br>";
$query21 = mysqli_query($conn,$sql21) or die(mysqli_error());
$Num_Rows21 = mysqli_num_rows($query21);
$fetch21 = mysqli_fetch_array($query21);


if($fetch21["ref_id"]!=''){

$sql2 = "SELECT * FROM tb_product_lzd where code_lazada = '".$objArr[6]."'";
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
	
	

$unit1 = $fetch2["unit1"]*$objArr[2];
$unit2 = $fetch2["unit2"]*$objArr[2];
$unit3 = $fetch2["unit3"]*$objArr[2];
$unit4 = $fetch2["unit4"]*$objArr[2];
$unit5 = $fetch2["unit5"]*$objArr[2];
$unit6 = $fetch2["unit6"]*$objArr[2];
$unit7 = $fetch2["unit7"]*$objArr[2];
$unit8 = $fetch2["unit8"]*$objArr[2];
$unit7 = $fetch2["unit7"]*$objArr[2];
$unit8 = $fetch2["unit8"]*$objArr[2];
$unit9 = $fetch2["unit9"]*$objArr[2];
$unit10 = $fetch2["unit10"]*$objArr[2];

	
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
	
$price_per_unit = ($objArr[5]/$unit1);	
	
if($Num_Rows2 > 0){
	

if($objArr[6]=='AW100TL' or $objArr[6]=='AW50TL'  or $objArr[6]=='AW50T' or $objArr[6]=='AW25T'){

$save69="UPDATE so__main SET glu_ckk ='1' where ref_id='".$fetch21["ref_id"]."'";
$qsave69=mysqli_query($conn,$save69);	
	
}
	
$price_lazada = $fetch2["percen_price"];
$sum_amount = $objArr[5];

if($sum_amount < $price_lazada){
	
$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$fetch21["ref_id"]."'";
$qsave19=mysqli_query($conn,$save19);	
	
}		

if($id_product1 !=''){

	$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$fetch21["ref_id"]."','".$unit1."','".$unit1."','".$price_per_unit."','".$objArr[5]."','".$objArr[5]."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','Approve')";

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
	
$sku = $objArr[6];	


$sku_list1 = [
    "BPM-BSX-593",
    "BPM-BSX-593CUF40",
    "BSX593+GCA10"
];

if (in_array($sku, $sku_list1)) {
    // เข้าเงื่อนไข
$strSQLfe = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date,sale_remark)
values ('".$fetch21["ref_id"]."','1','1','0.00','0.00','0.00','0.00','6326','6326','','".$add_date."','ครื่องวัดความดันรุ่น BSX593 (ทุกขนาด+เซตจับคู่) แถม สมุดบันทึกความดัน 1 ออเดอร์ ต่อ 1 เล่ม')";
$objQueryfe = mysqli_query($conn,$strSQLfe);
	
}		
	
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
	
}*/	
	
	
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
$customer_name = "$objArr[11] $objArr[12]";
$delivery_name = "$objArr[11] $objArr[12]";
$tax_id = $objArr[31];	
$create = substr($objArr[0],0,10);	
$create_time1 = substr($objArr[0],-12);	
$create_time = substr($create_time1,0,-2);	
$date_arr = explode('/' ,$create);
$xdate = $date_arr[2].'-'.$date_arr[0].'-'.$date_arr[1];
$create_order = "$xdate $create_time";

$order_name = "$objArr[11] $objArr[12]";
$delivery_contact = "$objArr[11] $objArr[12] / $objArr[20]";
$address1 = "$objArr[14] $objArr[15]";
$address2 = "$objArr[17]";
$province = $objArr[18];
$delivery_place = "$objArr[14] $objArr[15] $objArr[17] $objArr[18] $objArr[16]";


$postcode =	$objArr[16];
	
	
if($tax_id!='' and $objArr[32]!='' ){		

$billing_address = "$objArr[34] $objArr[35] $objArr[37] $objArr[36] $objArr[38]";
$billing_name =	$objArr[32];
$billing_tel =	$objArr[30];
$billing_postcode =	$objArr[38];	
$billing_add = "$objArr[24] $objArr[34]";
$billing_aum = $objArr[37];
$billing_pro = $objArr[36];	
	
}else if($tax_id!=''){	
	
$billing_address = "$objArr[24] $objArr[25] $objArr[27] $objArr[28] $objArr[26]";
$billing_name =	"$objArr[21] $objArr[22]";
$billing_tel =	$objArr[30];
$billing_postcode =	$objArr[26];	
$billing_add = "$objArr[24] $objArr[25]";
$billing_aum = $objArr[27];
$billing_pro = $objArr[28];	
	
}else{
	
$billing_address = "$objArr[14] $objArr[15] $objArr[17] $objArr[18] $objArr[16]";
$billing_name =	"$objArr[11] $objArr[12]";
$billing_tel =	$objArr[20];
$billing_postcode =	$objArr[16];	
$billing_add = $objArr[14];
$billing_aum = $objArr[17];
$billing_pro = $objArr[18];

}

$tel =	$objArr[20];
$add_date = date('Y-m-d H:i:s');
   
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$order_refer_code = $objArr[7];
$order_id = $objArr[1];
	
//$create = $objArr[0];	

 //echo $objArr[51];
//$order_refer_code = $objArr[36];
if($objArr[67]=='PowerBuy'){	
$sale_channel = '37';	
}else{
$sale_channel = '25';
}
//}else if($objArr[67]='OFM_SA_000'){
//$sale_channel = '30';	
//}
	
$delivery = '23';
$employee_name ="SOL94";
$job_id = "";
$approve_complete = "Approve";
$pre_name = 'คุณ';
	
$email = 'MPops@central.co.th';
	

$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$objArr[6]."'";
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
	
	

$unit1 = $fetch2["unit1"]*$objArr[2];
$unit2 = $fetch2["unit2"]*$objArr[2];
$unit3 = $fetch2["unit3"]*$objArr[2];
$unit4 = $fetch2["unit4"]*$objArr[2];
$unit5 = $fetch2["unit5"]*$objArr[2];
$unit6 = $fetch2["unit6"]*$objArr[2];
$unit7 = $fetch2["unit7"]*$objArr[2];
$unit8 = $fetch2["unit8"]*$objArr[2];
$unit7 = $fetch2["unit7"]*$objArr[2];
$unit8 = $fetch2["unit8"]*$objArr[2];
$unit9 = $fetch2["unit9"]*$objArr[2];
$unit10 = $fetch2["unit10"]*$objArr[2];

	
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
	
$price_per_unit = $objArr[5]/$unit1;	

if($Num_Rows2 > 0){

$sql9 = "SELECT customer_name FROM tb_customer where cus_tel = '".$tel."'";

$query9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$Num_Rows9 = mysqli_num_rows($query9);
//$fetch9 = mysqli_fetch_array($query9);
	
if($Num_Rows9 > 0){
}else {	
	

$qfirst = "select * from tb_customer ORDER BY customer_id DESC LIMIT 1";
$first = mysqli_query($conn,$qfirst);
$Num_Rows88 = mysqli_num_rows($first);
$ffirst = mysqli_fetch_array($first);
	
$customer_id = $ffirst['customer_id']+1;	
	
	
$save9="insert into tb_customer
(customer_name,type_customer,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,sale_code,email_cus)
values
('".$customer_name."','7','".$address1."','".$address2."','".$province."','".$postcode."','".$tel."','".$billing_name."','".$billing_add."','".$billing_aum."','".$billing_pro."','".$billing_postcode."','".$billing_tel."','".$tax_id."','".$delivery_name."','".$address1."','".$address2."','".$province."','".$postcode."','".$tel."','".$delivery_contact."','".$employee_name."','".$email."')";
$qsave9=mysqli_query($conn,$save9);

$sql = "INSERT INTO tb_selected_sales (sale_code, id_customer, customer_name) VALUES ('$employee_name', '$customer_id', '$billing_name')";
$qsave2 = mysqli_query($conn, $sql);		
	
}
	
$sql10 = "SELECT customer_id FROM tb_customer where cus_tel = '".$tel."'";

$query10 = mysqli_query($conn,$sql10) or die(mysqli_error());
$fetch10 = mysqli_fetch_array($query10);
$bill_id = $fetch10["customer_id"];

$date = explode('-' , $register_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
	
if($objArr[31] !=''){	
	

/*$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_ptl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$mont.$nextId;

$save9="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."')";
$qsave9=mysqli_query($conn,$save9);	*/
	
	
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
	
	
	
$bill_vat = '1';
$send_supadm = '1';
$select_type_doc = '3';	
$status_vat  = "Approve";	
$account_approve ='1';	
$payment = '36';	
	
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

$account_approve ='0';	
$bill_vat = '0';
$send_supadm = '0';
$select_type_doc = '1';	
$status_vat  = "";	
$payment = '35';	
	}		

	
	
	
if($Num_Rows2 > 0){	

	
if($so =='IE'){
$save19="UPDATE tb_doc_ptl SET ref_so ='".$main_id."' where doc_no='".$doc_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}		

$strSQL = "INSERT INTO so__main (ref_id,register_date,register_time,delivery_name,address1,address2,province,postcode,billing_address,billing_name,billing_tel,tel,order_id,customer_name,order_name,delivery_contact,delivery_place,add_date,add_by,order_refer_code,sale_channel,select_type_doc,doc_release_date,status_doc,delivery_date,approve_complete,employee_name,job_id,delivery,payment,sale_remark,send_stock,bill_id,doc_no,prefer_name,po_no,ex_add,ex_aumper,ex_provin,ex_post,pre_name,tax_id,bill_vat,send_supadm,status_vat,create_order,email,account_approve) VALUES ('".$main_id."','".$register_date."','".$register_time."','".$delivery_name."','".$address1."','".$address2."','".$province."','".$postcode."','".$billing_address."','".$billing_name."','".$billing_tel."','".$tel."','".$order_id."','".$customer_name."','".$order_name."','".$delivery_contact."','".$delivery_place."','".$add_date."','".$add_by."','".$order_refer_code."','".$sale_channel."','".$select_type_doc."','".$doc_release_date."','".$select_type_doc."','".$delivery_date."','".$approve_complete."','".$employee_name."','".$job_id."','".$delivery."','".$payment."','Central Online','1','".$bill_id."','".$doc_no."','Central Online','".$order_id."','".$billing_add."','".$billing_aum."','".$billing_pro."','".$billing_postcode."','".$pre_name."','".$tax_id."','".$bill_vat."','".$send_supadm."','".$status_vat."','".$create_order."','".$email."','".$account_approve."')";

$objQuery = mysqli_query($conn,$strSQL)or die(mysqli_error());
	
	
}
//mysql_affected_rows()

	
if($objArr[6]=='AW100TL' or $objArr[6]=='AW50TL'  or $objArr[6]=='AW50T' or $objArr[6]=='AW25T'){

$save69="UPDATE so__main SET glu_ckk ='1' where ref_id='".$main_id."'";
$qsave69=mysqli_query($conn,$save69);	
	
}
	
$price_lazada = $fetch2["percen_price"];
$sum_amount = $objArr[5];

if($sum_amount < $price_lazada){
	
$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	
	
}	

if($id_product1 !=''){

	$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit1."','".$unit1."','".$price_per_unit."','".$objArr[5]."','".$objArr[5]."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','Approve')";

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

	
$sku = $objArr[12];	
	
$sku_list1 = [
    "BPM-BSX-593",
    "BPM-BSX-593CUF40",
    "BSX593+GCA10"
];

if (in_array($sku, $sku_list1)) {
    // เข้าเงื่อนไข
$strSQLfe = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date,sale_remark)
values ('".$main_id."','1','1','0.00','0.00','0.00','0.00','6326','6326','','".$add_date."','ครื่องวัดความดันรุ่น BSX593 (ทุกขนาด+เซตจับคู่) แถม สมุดบันทึกความดัน 1 ออเดอร์ ต่อ 1 เล่ม')";
$objQueryfe = mysqli_query($conn,$strSQLfe);
	
}		
	

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

	
}






	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($objQuery){
	 
	 
$strSQL5 = "SELECT *  FROM so__main  WHERE sale_channel = '25' and register_date = '" . $register_date . "' and doc_no NOT LIKE 'SOL%'";
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

$strSQL29="insert into   tb_register_data (IV_number,date_inv,company,customer_name,unit_cash,cash,employee_name,ref_id,credit,description,bill_id,sale_channel,summary,summary_work,summary_ckk) values ('".$doc_no."','".$delivery_date."','".$com."','".$billing_name."','".$amount_1."','36','".$add_by."','".$ref_id."','1','Central Online','".$bill_id."','".$sale_channel."','สมบูรณ์','สมบูรณ์','1')";
		
$objQuery29 = mysqli_query($code,$strSQL29);	
	
	 
 }
	 
}
 //}
	 
	 
$sql2 = "SELECT ref_id FROM so__main WHERE sale_channel = '25' and register_date = '" . $register_date . "' and register_time = '" . $register_time . "' and add_by ='" . $add_by . "' ";
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
