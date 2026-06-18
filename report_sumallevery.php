<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 14px; color: #FF0000;}
.style17 {font-size: 14px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 12px; color: #000000;}
.style40 {font-size: 15px; color: #000000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#CCFF66;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#FF3333;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}



</style>



<?php

 

date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$company = $_GET["company"]; 
$str_arr = $_GET["company"]; 

$company = substr($str_arr, 0,1);
$company1 = substr($str_arr,-1);
$date = explode('-' , $start_date );
$start_date1 = $date[1].'-'.$date[0];


include"dbconnect.php";
include"dbconnect_sale.php";




?>
<body>

<?php 
if($company =='3'){
$company_name = "บริษัท ออลล์เวล ไลฟ์ จำกัด";

}else if($company =='4'){
$company_name = "บริษัท โนเบิล เมด จำกัด";

}else{
$company_name = "";
}

$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;



?>

<center>
<span class="style15">Monthly Sales Record</span><br>

<span class="style15"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></span><br>


<span class="style15"><?php echo $company_name ; ?></span>
</center>
<br>

	
<?php
$month_sum	= substr($start_date,0,7);
	
$strSQL53 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and status_adm !='ยกเลิก' and sale_code !='' and ic_ckk='1'";

if($start_date !=""){ 
    $strSQL53 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL53 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL53 .= ' AND type_doc = "'.$company.'"'; 
}

$objQuery53 = mysqli_query($conn,$strSQL53) or die ("Error Query [".$strSQL53."]");
$objResult53 = mysqli_fetch_array($objQuery53);
	
	
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and iv_no_ref LIKE '%IC%'";

if($start_date !=""){ 
    $strSQL151 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL151 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL151 .= ' AND company_type = "'.$company.'"'; 
}


$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total23 = $objResult53['total'];
$total22 = $objResult151['total15'];	
$credit_total = $total23-$total22;
	
	
if($company=='3'){
	
$strSQL26 = "SELECT *  FROM tb_sumall WHERE  month_sum ='".$month_sum."' and sale_cose = 'IC'";
$objQuery26 = mysqli_query($conn,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);

if($Num_Rows26 > 0){	

$save="UPDATE tb_sumall SET sum_awl ='".$credit_total."' where month_sum ='".$month_sum."' and sale_cose = 'IC'";
$qsave=mysqli_query($conn,$save);	
	
}else{

$save="insert into tb_sumall (month_sum,sale_cose,sum_awl,type_arae) values ('".$month_sum."','IC','".$credit_total."','0')";
$qsave=mysqli_query($conn,$save);	
	
	
}
	
	
}else if($company=='4'){
	
$strSQL26 = "SELECT *  FROM tb_sumall WHERE  month_sum ='".$month_sum."' and sale_cose = 'IC'";
$objQuery26 = mysqli_query($conn,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);

if($Num_Rows26 > 0){	

$save="UPDATE tb_sumall SET sum_nbm ='".$credit_total."' where month_sum ='".$month_sum."' and sale_cose = 'IC'";
$qsave=mysqli_query($conn,$save);	
	
}else{

$save="insert into tb_sumall (month_sum,sale_cose,sum_nbm,type_arae) values ('".$month_sum."','IC','".$credit_total."','0')";

$qsave=mysqli_query($conn,$save);	
	
	
}
	
}	
	
?>	
	
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="center" class="style30">เขตการขาย</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
</table>


<?php

$strSQL ="SELECT * FROM tb_team_adm where ckk='0' ";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code1 = $objResult["sale_code"];
$sale_name = $objResult["sale_name"];

$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and ic_ckk='0'";

if($start_date !=""){ 
    $strSQL5 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}
    $strSQL5 .= ' AND sale_code = "'.$sale_code1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL15 = "SELECT SUM(amount)  as total15  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2'  and ic_ckk='0'";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL15 .= ' AND type_doc = "'.$company.'"'; 
}

    $strSQL15 .= ' AND sale_code = "'.$sale_code1.'"'; 

$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);



$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'";

if($start_date !=""){ 
    $strSQL151 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL151 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL151 .= ' AND company_type = "'.$company.'"'; 
}
 $strSQL151 .= ' AND sale_code = "'.$sale_code1.'"'; 

$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

//$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to12 = $total22; 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		

	$total15=$objResult15['total15'];
	$total5=$objResult5['total'];
	$total1=$total15+$total5;

$total= number_format( $total1,2)."";

//$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to1 = $total1; 
$no_vat_to = number_format( $no_vat_to1,2)."";

$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total1-$total22;
$credit_total1 = number_format( $credit_total,2)."";		

if($sale_code1=='MM1' or $sale_code1=='MM2' or $sale_code1=='S31' or $sale_code1=='S32' or $sale_code1=='S33'){
$type_arae ='2';	
}else if($sale_code1=='SM1' or $sale_code1=='CM' or $sale_code1=='S51'){
$type_arae ='0';		
}else if($sale_code1=='HC_EXTRA' ){
$type_arae ='3';		
	
}else{
$type_arae ='1';		
}

$month_sum	= substr($start_date,0,7);
	
	
if($company=='3'){
	
$strSQL26 = "SELECT *  FROM tb_sumall WHERE  month_sum ='".$month_sum."' and sale_cose = '".$sale_code1."'";
$objQuery26 = mysqli_query($conn,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);

if($Num_Rows26 > 0){	

$save="UPDATE tb_sumall SET sum_awl ='".$creditno_vat1."' where month_sum ='".$month_sum."' and sale_cose = '".$sale_code1."'";
$qsave=mysqli_query($conn,$save);	
	
}else{

$save="insert into tb_sumall (month_sum,sale_cose,sum_awl,type_arae) values ('".$month_sum."','".$sale_code1."','".$creditno_vat1."','".$type_arae."')";
$qsave=mysqli_query($conn,$save);	
	
	
}
	
	
}else if($company=='4'){
	
$strSQL26 = "SELECT *  FROM tb_sumall WHERE  month_sum ='".$month_sum."' and sale_cose = '".$sale_code1."'";

$objQuery26 = mysqli_query($conn,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);

if($Num_Rows26 > 0){	

$save="UPDATE tb_sumall SET sum_nbm ='".$creditno_vat1."' where month_sum ='".$month_sum."' and sale_cose = '".$sale_code1."'";
$qsave=mysqli_query($conn,$save);	
	
}else{

$save="insert into tb_sumall (month_sum,sale_cose,sum_nbm,type_arae) values ('".$month_sum."','".$sale_code1."','".$creditno_vat1."','".$type_arae."')";

$qsave=mysqli_query($conn,$save);	
	
	
}
	
}
	
	
	
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>

<?php
}


	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code LIKE '%EN%' and ic_ckk='0'";

if($start_date !=""){ 
    $strSQL5 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}

$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);



$strSQL15 = "SELECT SUM(amount)  as total15  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2'  and sale_code LIKE '%EN%'  and ic_ckk='0'";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL15 .= ' AND type_doc = "'.$company.'"'; 
}
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);


	$total15=$objResult15['total15'];
	$total5=$objResult5['total'];
	$total1=$total15+$total5;

$total= number_format( $total1,2)."";

//$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to1 = $total1; 
$no_vat_to = number_format( $no_vat_to1,2)."";


		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code LIKE '%EN%'";

if($start_date !=""){ 
    $strSQL151 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL151 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL151 .= ' AND company_type = "'.$company.'"'; 
}

   //$strSQL151 .= ' AND sale_code = "'.$sale_code1.'"'; 

$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

//$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to12 = $total22; 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		

$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total1-$total22;
$credit_total1 = number_format( $credit_total,2)."";	
	
	
$month_sum	= substr($start_date,0,7);
	
	
if($company=='3'){
	
$strSQL26 = "SELECT *  FROM tb_sumall WHERE  month_sum ='".$month_sum."' and sale_cose = 'EN'";
$objQuery26 = mysqli_query($conn,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);

if($Num_Rows26 > 0){	

$save="UPDATE tb_sumall SET sum_awl ='".$creditno_vat1."' where month_sum ='".$month_sum."' and sale_cose = 'EN'";
$qsave=mysqli_query($conn,$save);	
	
}else{

$save="insert into tb_sumall (month_sum,sale_cose,sum_awl,type_arae) values ('".$month_sum."','EN','".$creditno_vat1."','0')";
$qsave=mysqli_query($conn,$save);	
	
	
}
	
	
}else if($company=='4'){
	
$strSQL26 = "SELECT *  FROM tb_sumall WHERE  month_sum ='".$month_sum."' and sale_cose = 'EN'";

$objQuery26 = mysqli_query($conn,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);

if($Num_Rows26 > 0){	

$save="UPDATE tb_sumall SET sum_nbm ='".$creditno_vat1."' where month_sum ='".$month_sum."' and sale_cose = 'EN'";
$qsave=mysqli_query($conn,$save);	
	
}else{

$save="insert into tb_sumall (month_sum,sale_cose,sum_nbm,type_arae) values ('".$month_sum."','EN','".$creditno_vat1."','0')";

$qsave=mysqli_query($conn,$save);	
	
	
}
	
}
		
	
	
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo 'ช่าง' ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>


	

<?php
$strSQL ="SELECT * FROM tb_team_adm where ckk='1' ";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code1 = $objResult["sale_code"];
$sale_name = $objResult["sale_name"];


$strSQL21 = "SELECT SUM(sum_amount)  as total21  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='' and cancel_ckk ='0' and employee_name = '".$sale_code1."'";

if($start_date !=""){ 
    $strSQL21 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL21 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL21 .= ' AND select_type_doc = "'.$company.'"'; 
}

$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$objResult21 = mysqli_fetch_array($objQuery21);


$strSQL22 = "SELECT SUM(sum_amount)  as total22  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !=''  and employee_name = '".$sale_code1."' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL22 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL22 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL22 .= ' AND select_type_doc = "'.$company1.'"'; 
}

$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);








	$total21=$objResult21['total21'];
$total22=$objResult22['total22'];
$total23 = $total21+$total22;

$total_23= number_format( $total23,2)."";

//$no_vat_to24 = ($total23 / 1.07);
$no_vat_to24 = $total23;
$no_vat_to23 = number_format( $no_vat_to24,2)."";


$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = '".$sale_code1."'";

if($start_date !=""){ 
    $strSQL151 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL151 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL151 .= ' AND company_type = "'.$company.'"'; 
}


$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

//$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to12 = $total22; 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		

$creditno_vat1 = $no_vat_to24-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total23-$total22;
$credit_total1 = number_format( $credit_total,2)."";	
	
if($sale_code1=='E01'){
$type_arae ='0';	
}else{
$type_arae ='2';		
}

$month_sum	= substr($start_date,0,7);
	
	
if($company=='3'){
	
$strSQL26 = "SELECT *  FROM tb_sumall WHERE  month_sum ='".$month_sum."' and sale_cose = '".$sale_code1."'";
$objQuery26 = mysqli_query($conn,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);

if($Num_Rows26 > 0){	

$save="UPDATE tb_sumall SET sum_awl ='".$creditno_vat1."' where month_sum ='".$month_sum."' and sale_cose = '".$sale_code1."'";
$qsave=mysqli_query($conn,$save);	
	
}else{

$save="insert into tb_sumall (month_sum,sale_cose,sum_awl,type_arae) values ('".$month_sum."','".$sale_code1."','".$creditno_vat1."','".$type_arae."')";

$qsave=mysqli_query($conn,$save);	
	
	
}
	
	
}else if($company=='4'){
	
$strSQL26 = "SELECT *  FROM tb_sumall WHERE  month_sum ='".$month_sum."' and sale_cose = '".$sale_code1."'";
$objQuery26 = mysqli_query($conn,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);

if($Num_Rows26 > 0){	

$save="UPDATE tb_sumall SET sum_nbm ='".$creditno_vat1."' where month_sum ='".$month_sum."' and sale_cose = '".$sale_code1."'";
$qsave=mysqli_query($conn,$save);	
	
}else{

$save="insert into tb_sumall (month_sum,sale_cose,sum_nbm,type_arae) values ('".$month_sum."','".$sale_code1."','".$creditno_vat1."','".$type_arae."')";

$qsave=mysqli_query($conn,$save);	
	
	
}
	
}	
	
	
	
	
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>




<?php
}

	
$strSQL50 = "SELECT SUM(sum_amount)  as total50  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' ";

if($start_date !=""){ 
    $strSQL50 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL50 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL50 .= ' AND company_type = "'.$company.'"'; 
}

$objQuery50 = mysqli_query($conn,$strSQL50) or die ("Error Query [".$strSQL50."]");
$objResult50 = mysqli_fetch_array($objQuery50);


	
$strSQL53 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0'  and status_adm !='ยกเลิก' and sale_code !='' and ic_ckk='0'";

if($start_date !=""){ 
    $strSQL53 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL53 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL53 .= ' AND type_doc = "'.$company.'"'; 
}

$objQuery53 = mysqli_query($conn,$strSQL53) or die ("Error Query [".$strSQL53."]");
$objResult53 = mysqli_fetch_array($objQuery53);

	
$strSQL54 = "SELECT SUM(amount)  as total53  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2'   and status_adm !='ยกเลิก' and sale_code !='' and ic_ckk='0'";

if($start_date !=""){ 
    $strSQL54 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL54 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL54 .= ' AND type_doc = "'.$company.'"'; 
}
	
$objQuery54 = mysqli_query($conn,$strSQL54) or die ("Error Query [".$strSQL54."]");
$objResult54 = mysqli_fetch_array($objQuery54);




$strSQL55 = "SELECT SUM(sum_amount)  as sum_amount  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  cancel_ckk ='0' and doc_no !=''  ";

if($start_date !=""){ 
    $strSQL55 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL55 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL55 .= ' AND select_type_doc = "'.$company.'"'; 
}


$objQuery55 = mysqli_query($conn,$strSQL55) or die ("Error Query [".$strSQL55."]");
$objResult55 = mysqli_fetch_array($objQuery55);


$strSQL56 = "SELECT SUM(sum_amount)  as total22  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !=''   and cancel_ckk ='0' ";

if($start_date !=""){ 
    $strSQL56 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL56 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL56 .= ' AND select_type_doc = "'.$company1.'"'; 
}

$objQuery56 = mysqli_query($conn,$strSQL56) or die ("Error Query [".$strSQL56."]");
$objResult56 = mysqli_fetch_array($objQuery56);
		
		

$sol_1=$objResult55['sum_amount'];
$sol_2=$objResult56['total22'];

	
$hos_1=$objResult54['total53'];
$hos_2=$objResult53['total'];

$total_online = $sol_1+$sol_2+$hos_1+$hos_2;

$credit50=$objResult50['total50'];

//$no_vat_credit50 = ($credit50 / 1.07); 	
$no_vat_credit50 = $credit50; 
//$total_online1 = ($total_online / 1.07); 
$total_online1 = $total_online;
$summary_all = $total_online -$credit50 ;

	
$summary_novatall = $total_online1 -$no_vat_credit50 ;
$summary_allrec = number_format( $summary_all,2)."";
$summary_rec = number_format( $summary_novatall,2)."";
?>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">ยอดรวมทั้งหมด</td>
<td width="10%" align="right" class="style16"><?php echo $summary_allrec; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $summary_rec; ?></td> 

	</tr>
</table>


</body>
</html>