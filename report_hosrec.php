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
$sale_code = $_GET["sale_code"];
$company = $_GET["company"]; 
$str_arr = $_GET["company"]; 

$company = substr($str_arr, 0,1);
$company1 = substr($str_arr,-1);



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
<span class="style15">Monthly Sales Record</span></p>

<span class="style15"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></span><br>


<span class="style15"><?php echo $company_name ; ?></span>
</center>
</p>





<?php

if ($sale_code !=''){


$strSQL555 = "SELECT * FROM tb_team_adm where sale_code='".$sale_code."' ";
$objQuery555 = mysqli_query($com,$strSQL555);
$objResuut555 = mysqli_fetch_array($objQuery555);

$sale_name = $objResuut555["sale_name"];
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
<td width="10%" align="center" class="style30">ช่องทางการขาย</td> 
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>

<?
	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and status_adm !='ยกเลิก'";

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


$strSQL15 = "SELECT SUM(amount)  as total15  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and status_adm !='ยกเลิก'";

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

while($objResult15 = mysqli_fetch_array($objQuery15))
{

	$total15=$objResult15['total15'];
	$total5=$objResult5['total'];
	$total1=$total15+$total5;

$total= number_format( $total1,2)."";

$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and status_adm !='ยกเลิก'";


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



$strSQL3 ="SELECT SUM(amount)  as amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){


$summary_1=$objResult3['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult1["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
	<td  align="left" class="style30"> </td> 
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?php
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and status_adm !='ยกเลิก'";


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



$strSQL63 ="SELECT SUM(amount)  as amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult63['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult61["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult61["iv_no"]; ?></span></a></td>
		<td  align="left" class="style30"> </td>
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary6; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat6; ?></td> 

	</tr>




	<?php
}
}


?>

</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16"><?php echo "รวมยอดขายของ Sale :"; ?>&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="15%" align="center" class="style30">วันเดือนปี</td>
<td width="15%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
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



$strSQL233 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no ='".$objResult211["credit_no"]."' and status_doc = 'Approve'";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult233['sum_amount1'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php

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
<td width="55%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
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
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>


	<?
}
	}

	
} else{

	

$strSQL ="SELECT * FROM tb_team_adm where ckk='0' ";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code1 = $objResult["sale_code"];
$sale_name = $objResult["sale_name"];




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
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
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


$strSQL15 = "SELECT SUM(amount)  as total15  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' ";

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

while($objResult15 = mysqli_fetch_array($objQuery15))
{

	$total15=$objResult15['total15'];
	$total5=$objResult5['total'];
	$total1=$total15+$total5;

$total= number_format( $total1,2)."";

$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and status_adm !='ยกเลิก'";


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




$strSQL3 ="SELECT SUM(amount)  as amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){




$summary_1=$objResult3['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult1["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and status_adm !='ยกเลิก'";


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



$strSQL63 ="SELECT SUM(amount)  as amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult63['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult61["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult61["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary6; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat6; ?></td> 

	</tr>




	<?php
}
}


?>

</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="45%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
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



$strSQL233 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no ='".$objResult211["credit_no"]."' and status_doc = 'Approve'";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult233['sum_amount1'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php

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
<td width="45%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
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
<td width="45%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>


	<?
}
} 
}

?>



<center>
<span class="style16"><?php echo "ช่าง" ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "ช่าง";  ?></span>
</center> 
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>





<?php

	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code LIKE '%EN%'";

if($start_date !=""){ 
    $strSQL5 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}

/*if($sale_code !=""){ 
    $strSQL5 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL5 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}*/


$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");

$objResult5 = mysqli_fetch_array($objQuery5);



$strSQL15 = "SELECT SUM(amount)  as total15  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2'  and sale_code LIKE '%EN%' ";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL15 .= ' AND type_doc = "'.$company.'"'; 
}

/*if($sale_code !=""){ 
    $strSQL15 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL15 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}*/


$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);


	$total15=$objResult15['total15'];
	$total5=$objResult5['total'];
	$total1=$total15+$total5;

$total= number_format( $total1,2)."";

$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and status_adm !='ยกเลิก'  and sale_code LIKE '%EN%'";


if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}

/*if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL1 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}*/


$strSQL1 .=" order  by iv_no ASC  ";


$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){




$strSQL3 ="SELECT SUM(amount)  as amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){




$summary_1=$objResult3['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult1["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and status_adm !='ยกเลิก'  and sale_code LIKE '%EN%'";


if($start_date !=""){ 
    $strSQL61 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL61 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL61 .= ' AND type_doc = "'.$company.'"'; 
}

/*if($sale_code !=""){ 
    $strSQL61 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL61 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}*/


$strSQL61 .=" order  by iv_no ASC  ";


$objQuery61 =mysqli_query($conn,$strSQL61);
while($objResult61=mysqli_fetch_array($objQuery61)){



$strSQL63 ="SELECT SUM(amount)  as amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult63['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult61["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult61["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary6; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat6; ?></td> 

	</tr>




	<?php
}
}


?>

</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="45%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo "ช่าง" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	<?php
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve'  and sale_code LIKE '%EN%'";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}

//$strSQL211 .= ' AND sale_code = "'.$sale_code1.'"'; 

$strSQL211 .=" order  by credit_no ASC  ";


$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){



$strSQL233 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no ='".$objResult211["credit_no"]."' and status_doc = 'Approve'  and sale_code LIKE '%EN%'";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult233['sum_amount1'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php

}
}

?>
</table>

<?php
		
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

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="45%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo "ช่าง" ; ?></td>
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
<td width="45%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo "ช่าง" ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>


	


<?php


	
$strSQL50 = "SELECT SUM(sum_amount)  as total50  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code NOT LIKE '%SOL%'";

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


	
$strSQL53 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0'  and status_adm !='ยกเลิก' and sale_code !=''";

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

	
$strSQL54 = "SELECT SUM(amount)  as total53  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2'   and status_adm !='ยกเลิก' and sale_code !=''";

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


	
$hos_1=$objResult54['total53'];
$hos_2=$objResult53['total'];

$total_online = $hos_1+$hos_2;

$credit50=$objResult50['total50'];
$no_vat_credit50 = ($credit50 / 1.07); 	

$total_online1 = ($total_online / 1.07); 

$summary_all = $total_online -$credit50 ;

	
$summary_novatall = $total_online1 -$no_vat_credit50 ;
$summary_allrec = number_format( $summary_all,2)."";
$summary_rec = number_format( $summary_novatall,2)."";
?>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="45%" align="left" class="style16">ยอดรวมทั้งหมด</td>
<td width="10%" align="right" class="style16"><?php echo $summary_allrec; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $summary_rec; ?></td> 

	</tr>
</table>

<?php 
}

?>
</body>
</html>