<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
.style17 {font-size: 18px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style39 {font-size: 14px; color: #000000;}
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


include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";




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
$sale_code = $_GET["sale_code"];
$company = $_GET["company"]; 
$emid = $_GET['code'];


include"dbconnect.php";
include "dbconnect_sale.php";




?>
<body>

<?php 
if($company =='3'){
$company_name = "บริษัท ออลล์เวล ไลฟ์ จำกัด";

}else if($company =='4'){
$company_name = "บริษัท โนเบิ้ล เมด จำกัด";

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
<span class="style15">Monthly Sales Record</span></p>

<span class="style15"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></span><br>


<span class="style15"><?php echo $company_name ; ?></span>
</center>
</p>





<?php

if ($sale_code !=''){


if( $sale_code =='S11'){
$sale_name ="S11";
}else if( $sale_code =='S12'){
$sale_name ="S12";

}else if( $sale_code =='S13'){
$sale_name ="S13";

}else if( $sale_code =='S14'){
$sale_name ="S14";

}else if( $sale_code =='S15'){
$sale_name ="S15";

}else if( $sale_code =='S16'){
$sale_name ="S16";

}else if( $sale_code =='S17'){
$sale_name ="S17";

}else if( $sale_code =='S21'){
$sale_name ="S21";

}else if( $sale_code =='S22'){
$sale_name ="S22";

}else if( $sale_code =='S23'){
$sale_name ="S23";

}else if( $sale_code =='S24'){
$sale_name ="S24";

}else if( $sale_code =='S31'){
$sale_name ="S31";

}else if( $sale_code =='SM1'){
$sale_name ='SM1';

}else if( $sale_code =='MM1'){
$sale_name ='MM1';

} else if( $sale_code =='EN1'){
$sale_name ="ช่าง";

}

?>

</p>
	<center>
<span class="style16"><?php echo $sale_name ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $sale_code ;  ?></span>
</center> 
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>





<?php

	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' ";

if($start_date !=""){ 
    $strSQL5 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL5 .= ' AND sale_code = "'.$sale_code.'"'; 
}


$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");

while($objResult5 = mysqli_fetch_array($objQuery5))
{


$strSQL15 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' ";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL15 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL15 .= ' AND sale_code = "'.$sale_code.'"'; 
}


$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");

while($objResult15 = mysqli_fetch_array($objQuery15)){


$total15=$objResult15['total1'];
$total5=$objResult5['total'];
$total1=$total15+$total5;

$total= number_format( $total1,2)."";

$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '0' ";


if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}


$strSQL1 .=" order  by iv_no ASC  ";


$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){

$strSQL2 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";

$objQuery2 =mysqli_query($conn,$strSQL2);
while($objResult2=mysqli_fetch_array($objQuery2)){



$strSQL3 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult2["product_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){


$summary_1=$objResult2['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult3["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult2["count"];  ?>&nbsp;<?php echo $objResult3["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?php
}
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,bill_tel,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' ";


if($start_date !=""){ 
    $strSQL61 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL61 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL61 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL61 .= ' AND sale_code = "'.$sale_code.'"'; 
}


$objQuery61 =mysqli_query($conn,$strSQL61);
while($objResult61=mysqli_fetch_array($objQuery61)){

$strSQL62 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery62 =mysqli_query($conn,$strSQL62);
while($objResult62=mysqli_fetch_array($objQuery62)){



$strSQL63 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult62["product_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult62['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult61["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult63["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult62["count"];  ?>&nbsp;<?php echo $objResult63["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary6; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat6; ?></td> 

	</tr>




	<?
}
}
}


?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	<?php
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve'";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL211 .= ' AND sale_code = "'.$sale_code.'"'; 
}


$strSQL211 .=" order  by credit_no ASC  ";


$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult222['sum_amount'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult233["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult222["count"];  ?>&nbsp;<?php echo $objResult233["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
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

if($sale_code !=""){ 
    $strSQL151 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 
$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total1-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>
	<?
}
}




}else{



$strSQL = "SELECT * FROM tb_user_team WHERE em_id = '".$emid."' ";
//echo $strSQL1;
//exit();
$objQuery = mysqli_query($com,$strSQL) or die(mysqli_error());

while($objResult=mysqli_fetch_array($objQuery)){

$sale_code1 = $objResult["sale_code"];


if($sale_code1 =='S11' ){
$sale_name ="S11";
}else if($sale_code1 =='S12' ){
$sale_name ="S12";

}else if($sale_code1 =='S13' ){
$sale_name ="S13";

}else if($sale_code1 =='S14' ){
$sale_name ="S14";

}else if($sale_code1 =='S15' ){
$sale_name ="S15";

}else if($sale_code1 =='S16' ){
$sale_name ="S16";

}else if($sale_code1 =='S17'){
$sale_name ="S17";

}else if($sale_code1 =='S21' ){
$sale_name ="S21";

}else if($sale_code1 =='S22' ){
$sale_name ="S22";

}else if($sale_code1 =='S23' ){
$sale_name ="S23";

}else if($sale_code1 =='S24' ){
$sale_name ="S24";

}else if($sale_code1 =='S31' ){
$sale_name ="S31";

}else if($sale_code1 =="SM1"){
$sale_name ='SM1';

}else if($sale_code1 =='MM1' ){
$sale_name ='MM1';

} else if($sale_code1 =='EN'){
$sale_name ="ช่าง";

} else if($sale_code1 =='S51'){
$sale_name ="S51";

}








?>
	</p>
	<center>
<span class="style16"><?php echo $sale_name ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $sale_code1 ;  ?></span>
</center> 
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>





<?php

	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' ";

if($start_date !=""){ 
    $strSQL5 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL5 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL5 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");

while($objResult5 = mysqli_fetch_array($objQuery5))
{


$strSQL15 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' ";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL15 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL15 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL15 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");

while($objResult15 = mysqli_fetch_array($objQuery15)){


$total15=$objResult15['total1'];
$total5=$objResult5['total'];
$total1=$total15+$total5;

$total= number_format( $total1,2)."";

$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";





$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '0' ";


if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL1 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$strSQL1 .=" order  by iv_no ASC  ";


$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){

$strSQL2 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";

$objQuery2 =mysqli_query($conn,$strSQL2);
while($objResult2=mysqli_fetch_array($objQuery2)){



$strSQL3 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult2["product_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){


$summary_1=$objResult2['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult3["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult2["count"];  ?>&nbsp;<?php echo $objResult3["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?
}
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,bill_tel,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' ";


if($start_date !=""){ 
    $strSQL61 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL61 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL61 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL61 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL61 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$strSQL61 .=" order  by iv_no ASC  ";


$objQuery61 =mysqli_query($conn,$strSQL61);
while($objResult61=mysqli_fetch_array($objQuery61)){

$strSQL62 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery62 =mysqli_query($conn,$strSQL62);
while($objResult62=mysqli_fetch_array($objQuery62)){



$strSQL63 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult62["product_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult62['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult61["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult63["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult62["count"];  ?>&nbsp;<?php echo $objResult63["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary6; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat6; ?></td> 

	</tr>




	<?
}
}
}


?>

</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>



<?
}
}
	?>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	<?php
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve'";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}
	
$strSQL211 .= ' AND sale_code = "'.$sale_code1.'"'; 
$strSQL211 .=" order  by credit_no ASC  ";


$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult222['sum_amount'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult233["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult222["count"];  ?>&nbsp;<?php echo $objResult233["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
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

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 
$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total1-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>

<?php
}
}
?>

</p>

<?php /*if ($emid == 'SS2' and $sale_code ==''){?>

<center>
<span class="style16"><?php echo 'S23'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo 'S23';   ?></span>
</center> 
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>





<?php

	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' ";

if($start_date !=""){ 
    $strSQL5 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL5 .= ' AND sale_code = "S23"'; 
}


$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");

while($objResult5 = mysqli_fetch_array($objQuery5))
{


$strSQL15 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' ";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL15 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL15 .= ' AND sale_code = "S23"'; 
}


$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");

while($objResult15 = mysqli_fetch_array($objQuery15)){


$total15=$objResult15['total1'];
$total5=$objResult5['total'];
$total1=$total15+$total5;

$total= number_format( $total1,2)."";

$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL1 ="SELECT  iv_no,date_so,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '0' ";


if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "S23"'; 
}


$strSQL1 .=" order  by iv_no ASC  ";


$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){

$strSQL2 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";

$objQuery2 =mysqli_query($conn,$strSQL2);
while($objResult2=mysqli_fetch_array($objQuery2)){



$strSQL3 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult2["product_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){


$summary_1=$objResult2['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["date_so"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult3["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult2["count"];  ?>&nbsp;<?php echo $objResult3["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?php
}
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,bill_tel,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' ";


if($start_date !=""){ 
    $strSQL61 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL61 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL61 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL61 .= ' AND sale_code = "S23"';
}


$objQuery61 =mysqli_query($conn,$strSQL61);
while($objResult61=mysqli_fetch_array($objQuery61)){

$strSQL62 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery62 =mysqli_query($conn,$strSQL62);
while($objResult62=mysqli_fetch_array($objQuery62)){



$strSQL63 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult62["product_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult62['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult61["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult63["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult62["count"];  ?>&nbsp;<?php echo $objResult63["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary6; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat6; ?></td> 

	</tr>




	<?
}
}
}


?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo "S23" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	<?php
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve'";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL211 .= ' AND sale_code = "S23"'; 
}


$strSQL211 .=" order  by credit_no ASC  ";


$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult222['sum_amount'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult233["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult222["count"];  ?>&nbsp;<?php echo $objResult233["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
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

if($sale_code !=""){ 
    $strSQL151 .= ' AND sale_code = "S23"'; 
}

$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo "S23" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 
$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total1-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo "S23"; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>
	<?
}
}






}*/
	?>

</p>
</body>
</html>