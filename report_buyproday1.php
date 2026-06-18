<?php 
include('head1.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";
?>
<link rel="stylesheet" href="css/w33.css">
<style type="text/css">
<!--

.style15 {
	font-size: 16px; color: #000000;
}
.style16 {font-size: 15px; color: #FF0000;}
.style17 {font-size: 18px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #CC0066; font-size: 14px; }
.style38 {font-size: 14px; color: #FF0000;}
.style39 {font-size: 14px; color: #339900;}
.style40 {font-size: 14px; color: #3333CC; }
-->

</style>

<?php
function DateThai($strDate)
	{
		$strYear1 = date("Y",strtotime($strDate))+543;
		$strYear = substr($strYear1, 2 ,2);
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
?>

<?php

date_default_timezone_set("Asia/Bangkok");
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$str_arr = $_GET["company"]; 
$company = substr($str_arr, 0,1);
$company1 = substr($str_arr,-1);
$time = date('H:i:s');


if($company =='3'){
$company_name = "บริษัท ออลล์เวล ไลฟ์ จำกัด";

}else if($company =='4'){
$company_name = "บริษัท โนเบิล เมด จำกัด";

}else{
$company_name = "";
}


?>
<body>


<div class="w3-container w3-padding-large">

<center>
<span class="style15">รายงานลูกค้าซื้อสินค้าทั้งหมด</span><br>

<span class="style33"><?php echo Datethai($start_date); ?> ถึง<?php echo Datethai($end_date); ?></span><br>

<span class="style15"><?php echo $company_name ; ?></span>

</center>


<br>
			


	<?php
$strSQL ="SELECT * FROM tb_team_adm where ckk='0' ";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){
	
if($objResult["sale_code"]=='SM1'){
$type_arae = '3';	
}else if($objResult["sale_code"]=='S31' or $objResult["sale_code"]=='MM1' or $objResult["sale_code"]=='MM2'){
$type_arae = '2';	
}else{
$type_arae = '1';		
}	
	
	
$strSQL1 ="SELECT  iv_no,iv_date,bill_id,bill_name,ref_id,sale_code,mode_cus FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and sale_code ='".$objResult["sale_code"]."'";


if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}


$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){
	
$strSQL4 ="SELECT customer_no FROM tb_customer  WHERE customer_id  = '".$objResult1["bill_id"]."'  ";
$objQuery4 =mysqli_query($conn,$strSQL4);
$objResult4=mysqli_fetch_array($objQuery4);
	
if($objResult4["customer_no"]!=''){	
$mem_ckk = '1';	
}else{
$mem_ckk = '0';		
}	
	
$strSQL2 ="SELECT product_id,count,amount,price,discount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";
$objQuery2 =mysqli_query($conn,$strSQL2);
while($objResult2=mysqli_fetch_array($objQuery2)){



$strSQL3 ="SELECT sol_name,unit_name,group1  FROM tb_product  WHERE product_ID = '".$objResult2["product_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){



$strSQL71 = "insert into tb__buypro
(ref_id,bill_id,customer,doc_date,sale_code,doc_no,product_no,count,price,discount,amount,group_pro,company,type_arae,mode_cus,mem_ckk)
values ('".$objResult1["ref_id"]."','".$objResult1["bill_id"]."','".$objResult1["bill_name"]."','".$objResult1["iv_date"]."','".$objResult1["sale_code"]."','".$objResult1["iv_no"]."','".$objResult2["product_id"]."','".$objResult2["count"]."','".$objResult2["price"]."','".$objResult2["discount"]."','".$objResult2["amount"]."','".$objResult3["group1"]."','".$company."','".$type_arae."','".$objResult1["mode_cus"]."','".$mem_ckk."')";
$objQuery71 = mysqli_query($conn,$strSQL71);





}
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,bill_id,bill_tel,ref_id,sale_code,mode_cus FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code ='".$objResult["sale_code"]."' ";


if($start_date !=""){ 
    $strSQL61 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL61 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL61 .= ' AND type_doc = "'.$company.'"'; 
}

$objQuery61 =mysqli_query($conn,$strSQL61);
while($objResult61=mysqli_fetch_array($objQuery61)){
	
$strSQL64 ="SELECT customer_no FROM tb_customer  WHERE customer_id  = '".$objResult61["bill_id"]."'  ";
$objQuery64 =mysqli_query($conn,$strSQL64);
$objResult64=mysqli_fetch_array($objQuery64);
	
if($objResult64["customer_no"]!=''){	
$mem_ckk = '1';	
}else{
$mem_ckk = '0';		
}		
	

$strSQL62 ="SELECT product_id,count,amount,price,discount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery62 =mysqli_query($conn,$strSQL62);
while($objResult62=mysqli_fetch_array($objQuery62)){



$strSQL63 ="SELECT sol_name,unit_name,group1  FROM tb_product  WHERE product_ID = '".$objResult62["product_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){

	
if($objResult61["sale_code"]=='SM1'){
$type_arae = '3';	
}else if($objResult61["sale_code"]=='S31' or $objResult61["sale_code"]=='MM1' or $objResult61["sale_code"]=='MM2'){
$type_arae = '2';	
}else{
$type_arae = '1';		
}	

$strSQL71 = "insert into tb__buypro
(ref_id,bill_id,customer,doc_date,sale_code,doc_no,product_no,count,price,discount,amount,group_pro,company,type_arae,mode_cus,mem_ckk)
values ('".$objResult61["ref_id"]."','".$objResult61["bill_id"]."','".$objResult61["bill_name"]."','".$objResult61["iv_date"]."','".$objResult61["sale_code"]."','".$objResult61["iv_no"]."','".$objResult62["product_id"]."','".$objResult62["count"]."','".$objResult62["price"]."','".$objResult62["discount"]."','".$objResult62["amount"]."','".$objResult63["group1"]."','".$company."','".$type_arae."','".$objResult61["mode_cus"]."','".$mem_ckk."')";

$objQuery71 = mysqli_query($conn,$strSQL71);





}
}
}
	
	
	
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit,company_type,sale_code,bill_id,mode_cus FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code ='".$objResult["sale_code"]."'";

if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}
$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount,unit_price,discount_unit  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT group1  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$strSQL71 = "insert into tb__discash
(ref_id,company,iv_no,date_cash,sale_code,product_no,count,price,discount,amount,group_1,type_arae,bill_id,mode_cus)
values ('".$objResult211["ref_credit"]."','".$objResult211["company_type"]."','".$objResult211["credit_no"]."','".$objResult211["date_credit"]."','".$objResult211["sale_code"]."','".$objResult222["product_id"]."','".$objResult222["count"]."','".$objResult222["unit_price"]."','".$objResult222["discount_unit"]."','".$objResult222["sum_amount"]."','".$objResult233["group1"]."','".$type_arae."','".$objResult211["bill_id"]."','".$objResult211["mode_cus"]."')";

$objQuery71 = mysqli_query($conn,$strSQL71);



}
}
}	
	

	
}
	
	
	
	
	
$strSQL1 ="SELECT  iv_no,iv_date,bill_id,bill_name,ref_id,sale_code,mode_cus FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and sale_code LIKE '%EN%'";


if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}


$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){
	
$strSQL4 ="SELECT customer_no FROM tb_customer  WHERE customer_id  = '".$objResult1["bill_id"]."'  ";
$objQuery4 =mysqli_query($conn,$strSQL4);
$objResult4=mysqli_fetch_array($objQuery4);
	
if($objResult4["customer_no"]!=''){	
$mem_ckk = '1';	
}else{
$mem_ckk = '0';		
}	

$strSQL2 ="SELECT product_id,count,amount,price,discount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";
$objQuery2 =mysqli_query($conn,$strSQL2);
while($objResult2=mysqli_fetch_array($objQuery2)){



$strSQL3 ="SELECT sol_name,unit_name,group1  FROM tb_product  WHERE product_ID = '".$objResult2["product_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){



$strSQL71 = "insert into tb__buypro
(ref_id,bill_id,customer,doc_date,sale_code,doc_no,product_no,count,price,discount,amount,group_pro,company,type_arae,mode_cus,mem_ckk)
values ('".$objResult1["ref_id"]."','".$objResult1["bill_id"]."','".$objResult1["bill_name"]."','".$objResult1["iv_date"]."','".$objResult1["sale_code"]."','".$objResult1["iv_no"]."','".$objResult2["product_id"]."','".$objResult2["count"]."','".$objResult2["price"]."','".$objResult2["discount"]."','".$objResult2["amount"]."','".$objResult3["group1"]."','".$company."','3','".$objResult1["mode_cus"]."','".$mem_ckk."')";
$objQuery71 = mysqli_query($conn,$strSQL71);




}
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,bill_id,bill_tel,ref_id,sale_code,mode_cus FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code LIKE '%EN%' ";


if($start_date !=""){ 
    $strSQL61 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL61 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL61 .= ' AND type_doc = "'.$company.'"'; 
}

$objQuery61 =mysqli_query($conn,$strSQL61);
while($objResult61=mysqli_fetch_array($objQuery61)){

$strSQL64 ="SELECT customer_no FROM tb_customer  WHERE customer_id  = '".$objResult61["bill_id"]."'  ";
$objQuery64 =mysqli_query($conn,$strSQL64);
$objResult64=mysqli_fetch_array($objQuery64);
	
if($objResult64["customer_no"]!=''){	
$mem_ckk = '1';	
}else{
$mem_ckk = '0';		
}	
	
$strSQL62 ="SELECT product_id,count,amount,price,discount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";
$objQuery62 =mysqli_query($conn,$strSQL62);
while($objResult62=mysqli_fetch_array($objQuery62)){



$strSQL63 ="SELECT sol_name,unit_name,group1  FROM tb_product  WHERE product_ID = '".$objResult62["product_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$strSQL71 = "insert into tb__buypro
(ref_id,bill_id,customer,doc_date,sale_code,doc_no,product_no,count,price,discount,amount,group_pro,company,type_arae,mode_cus,mem_ckk)
values ('".$objResult61["ref_id"]."','".$objResult61["bill_id"]."','".$objResult61["bill_name"]."','".$objResult61["iv_date"]."','".$objResult61["sale_code"]."','".$objResult61["iv_no"]."','".$objResult62["product_id"]."','".$objResult62["count"]."','".$objResult62["price"]."','".$objResult62["discount"]."','".$objResult62["amount"]."','".$objResult63["group1"]."','".$company."','3','".$objResult61["mode_cus"]."','".$mem_ckk."')";

$objQuery71 = mysqli_query($conn,$strSQL71);






}
}
}
	
	
	
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit,company_type,sale_code,bill_id,mode_cus FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code LIKE '%EN%'";

if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}
//echo $strSQL211;	
$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount,unit_price,discount_unit  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT group1  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$strSQL71 = "insert into tb__discash
(ref_id,company,iv_no,date_cash,sale_code,product_no,count,price,discount,amount,group_1,type_arae,bill_id,mode_cus)
values ('".$objResult211["ref_credit"]."','".$objResult211["company_type"]."','".$objResult211["credit_no"]."','".$objResult211["date_credit"]."','".$objResult211["sale_code"]."','".$objResult222["product_id"]."','".$objResult222["count"]."','".$objResult222["unit_price"]."','".$objResult222["discount_unit"]."','".$objResult222["sum_amount"]."','".$objResult233["group1"]."','3','".$objResult211["bill_id"]."','".$objResult211["mode_cus"]."')";
//echo $strSQL71;
$objQuery71 = mysqli_query($conn,$strSQL71);



}
}
}	
		
	
	
	
	
	
	
$strSQL ="SELECT * FROM tb_team_adm where ckk='1' ";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){



$strSQL10 ="SELECT  doc_no,doc_release_date,bill_id,customer_name,ref_id,tel,sale_channel,employee_name FROM so__main WHERE doc_no !='' and cancel_ckk = '0' and employee_name = '".$objResult["sale_code"]."'";


if($start_date !=""){ 
    $strSQL10 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL10 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL10 .= ' AND select_type_doc = "'.$company.'"'; 
}


$objQuery10 =mysqli_query($conn,$strSQL10);
while($objResult10=mysqli_fetch_array($objQuery10)){
	
	
$strSQL40 ="SELECT customer_no FROM tb_customer  WHERE customer_id  = '".$objResult10["bill_id"]."'  ";
$objQuery40 =mysqli_query($conn,$strSQL40);
$objResult40=mysqli_fetch_array($objQuery40);
	
if($objResult40["customer_no"]!=''){	
$mem_ckk = '1';	
}else{
$mem_ckk = '0';		
}		

$strSQL7 ="SELECT product_id,sale_count,sum_amount,price_per_unit,discount_unit  FROM so__submain  WHERE ref_idd = '".$objResult10["ref_id"]."' and dis_ckk ='0'";

$objQuery7 =mysqli_query($conn,$strSQL7);
while($objResult7=mysqli_fetch_array($objQuery7)){



$strSQL16 ="SELECT sol_name,unit_name,group1  FROM tb_product  WHERE product_ID = '".$objResult7["product_id"]."'  ";

$objQuery16 =mysqli_query($conn,$strSQL16);
while($objResult16=mysqli_fetch_array($objQuery16)){



$strSQL71 = "insert into tb__buypro
(ref_id,bill_id,customer,doc_date,sale_code,doc_no,product_no,count,price,discount,amount,group_pro,sale_chan,company,type_arae,mem_ckk)
values ('".$objResult10["ref_id"]."','".$objResult10["bill_id"]."','".$objResult10["customer_name"]."','".$objResult10["doc_release_date"]."','".$objResult10["employee_name"]."','".$objResult10["doc_no"]."','".$objResult7["product_id"]."','".$objResult7["sale_count"]."','".$objResult7["price_per_unit"]."','".$objResult7["discount_unit"]."','".$objResult7["sum_amount"]."','".$objResult16["group1"]."','".$objResult10["sale_channel"]."','".$company."','2','".$mem_ckk."')";

$objQuery71 = mysqli_query($conn,$strSQL71);





}
}
}






$strSQL26 ="SELECT  iv_no,iv_date,bill_id,customer_name,ref_id,tel,sale_channel,employee_name FROM so__main WHERE iv_no !=''  and cancel_ckk = '0'  and employee_name = '".$objResult["sale_code"]."'";


if($start_date !=""){ 
    $strSQL26 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL26 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL26 .= ' AND select_type_doc = "'.$company1.'"'; 
}

$objQuery26 =mysqli_query($conn,$strSQL26);
while($objResult26=mysqli_fetch_array($objQuery26)){
	
$strSQL24 ="SELECT customer_no FROM tb_customer  WHERE customer_id  = '".$objResult26["bill_id"]."'  ";
$objQuery24 =mysqli_query($conn,$strSQL24);
$objResult24=mysqli_fetch_array($objQuery24);
	
if($objResult24["customer_no"]!=''){	
$mem_ckk = '1';	
}else{
$mem_ckk = '0';		
}		
	

$strSQL27 ="SELECT product_id,sale_count,sum_amount,price_per_unit,discount_unit  FROM so__submain  WHERE ref_idd = '".$objResult26["ref_id"]."' and dis_ckk ='0' ";

$objQuery27 =mysqli_query($conn,$strSQL27);
while($objResult27=mysqli_fetch_array($objQuery27)){



$strSQL28 ="SELECT sol_name,unit_name,group1  FROM tb_product  WHERE product_ID = '".$objResult27["product_id"]."'  ";

$objQuery28 =mysqli_query($conn,$strSQL28);
while($objResult28=mysqli_fetch_array($objQuery28)){


$strSQL71 = "insert into tb__buypro
(ref_id,bill_id,customer,doc_date,sale_code,doc_no,product_no,count,price,discount,amount,group_pro,sale_chan,company,type_arae,mem_ckk)
values ('".$objResult26["ref_id"]."','".$objResult26["bill_id"]."','".$objResult26["customer_name"]."','".$objResult26["iv_date"]."','".$objResult26["employee_name"]."','".$objResult26["iv_no"]."','".$objResult27["product_id"]."','".$objResult27["sale_count"]."','".$objResult27["price_per_unit"]."','".$objResult27["discount_unit"]."','".$objResult27["sum_amount"]."','".$objResult28["group1"]."','".$objResult26["sale_channel"]."','".$company."','2','".$mem_ckk."')";

$objQuery71 = mysqli_query($conn,$strSQL71);



}
}
}



$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit,company_type,sale_code,bill_id,sale_chan FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve'  and sale_code = '".$objResult["sale_code"]."'";

if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}

//echo $strSQL211;	
	
$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount,unit_price,discount_unit  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT group1  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){



$strSQL71 = "insert into tb__discash
(ref_id,company,iv_no,date_cash,sale_code,product_no,count,price,discount,amount,group_1,type_arae,bill_id,sale_chan)
values ('".$objResult211["ref_credit"]."','".$objResult211["company_type"]."','".$objResult211["credit_no"]."','".$objResult211["date_credit"]."','".$objResult211["sale_code"]."','".$objResult222["product_id"]."','".$objResult222["count"]."','".$objResult222["unit_price"]."','".$objResult222["discount_unit"]."','".$objResult222["sum_amount"]."','".$objResult233["group1"]."','2','".$objResult211["bill_id"]."','".$objResult211["sale_chan"]."')";
//echo $strSQL71;
$objQuery71 = mysqli_query($conn,$strSQL71);



}
}
}
}
	
?>




</div>
</body>
</html>