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
//$company = $_GET["company"]; 
$str_arr = $_GET["company"]; 
$em_id = $_GET["code"]; 
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

} else if( $sale_code =='S51'){
$sale_name ="S51";

} else if( $sale_code =='SOL99'){
$sale_name ="SOL99";

} else if( $sale_code =='SOL2'){
$sale_name ="รัชดาภรณ์ สีสัน SOL2";

} else if( $sale_code =='SOL1'){
$sale_name ="หทัยชนก  ไชยแสง SOL1";

}else if( $sale_code =='SOL3'){
$sale_name ="SOL3";

}else if( $sale_code =='SOL4'){
$sale_name ="SOL4";

}else if( $sale_code =='SOL5'){
$sale_name ="SOL5";

}else if( $sale_code =='SOL6'){
$sale_name ="SOL6";

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
<td width="10%" align="center" class="style30">ช่องทางการขาย</td> 
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="25%" align="center" class="style30">ผู้ออกเอกสาร</td>
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>

<?php
if($sale_code =='SOL99' or $sale_code =='SOL2' or $sale_code =='SOL1' or $sale_code =='SOL3' or $sale_code =='SOL4' or $sale_code =='SOL5' or $sale_code =='SOL6'){




$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' ";

if($start_date !=""){ 
    $strSQL5 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND select_type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL5 .= ' AND employee_name = "'.$sale_code.'"'; 
}

//echo $strSQL5;


$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL15 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL15 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_code !=""){ 
    $strSQL15 .= ' AND employee_name = "'.$sale_code.'"'; 
}


//echo $strSQL15;



$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);








	$total1=$objResult5['total'];
$total2=$objResult15['total1'];
$total3 = $total1+$total2;

$total= number_format( $total3,2)."";

$no_vat_to1 = ($total3 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL11 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,sale_channel,add_by FROM so__main WHERE doc_no !='' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL11 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL11 .= ' AND select_type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL11 .= ' AND employee_name = "'.$sale_code.'"'; 
}

$strSQL11 .=" order  by doc_no ASC  ";


$objQuery11 =mysqli_query($conn,$strSQL11);
while($objResult11=mysqli_fetch_array($objQuery11)){

$strSQL12 ="SELECT SUM(sum_amount) as sum_amount12  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE doc_no = '".$objResult11["doc_no"]."'  and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL12 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL12 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL12 .= ' AND select_type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL12 .= ' AND employee_name = "'.$sale_code.'"'; 
}


$objQuery12 =mysqli_query($conn,$strSQL12);
while($objResult12=mysqli_fetch_array($objQuery12)){

$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult11["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);



$summary_12=$objResult12['sum_amount12'];
$summary12= number_format( $summary_12,2)."";

$no_vat12 = ($summary_12 / 1.07); 
$no_vat_12 = number_format( $no_vat12,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult11["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult11["doc_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult11["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult11["add_by"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary12; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_12; ?></td> 

	</tr>




	<?php

}
}






$strSQL21 ="SELECT distinct iv_no,iv_date,sale_channel,add_by FROM so__main WHERE iv_no !='' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL21 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL21 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL21 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_code !=""){ 
    $strSQL21 .= ' AND employee_name = "'.$sale_code.'"'; 
}


$strSQL21 .=" order  by iv_no ASC  ";



$objQuery21 =mysqli_query($conn,$strSQL21);
while($objResult21=mysqli_fetch_array($objQuery21)){

$strSQL22 ="SELECT SUM(sum_amount) as sum_amount22  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE iv_no = '".$objResult21["iv_no"]."'  and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL22 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL22 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL22 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_code !=""){ 
    $strSQL22 .= ' AND employee_name = "'.$sale_code.'"'; 
}


$objQuery22 =mysqli_query($conn,$strSQL22);
$objResult22=mysqli_fetch_array($objQuery22);


$summary_22=$objResult22['sum_amount22'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat_22 = number_format( $no_vat22,2)."";

$strSQL23 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult21["sale_channel"]."'  ";

$objQuery23 =mysqli_query($conn,$strSQL23);
$objResult23=mysqli_fetch_array($objQuery23);



?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult21["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult21["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult23["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30"><?php echo  $objResult21["add_by"]; ?></td>
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_22; ?></td> 

	</tr>




	<?php


}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
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
<td width="55%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 

$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total3-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>




<?php



	}else{

	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and status_adm !='ยกเลิก' and ic_ckk='0'";

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


$strSQL15 = "SELECT SUM(amount)  as total15  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and status_adm !='ยกเลิก' and ic_ckk='0'";

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




$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id,sale FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and status_adm !='ยกเลิก' and ic_ckk='0'";


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



$strSQL3 ="SELECT SUM(amount)  as amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){


$summary_1=$objResult3['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["iv_no"]; ?></td>
	<td  align="left" class="style30"> </td> 
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult1["sale"]; ?></td> 	
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?php
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,ref_id,sale FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and status_adm !='ยกเลิก' and ic_ckk='0'";


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



$strSQL63 ="SELECT SUM(amount)  as amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."' ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult63['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult61["iv_no"]; ?></td>
		<td  align="left" class="style30"> </td>
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult61["sale"]; ?></td> 	
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
<td width="55%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
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
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>


	<?
}
	}

	}


}else{

if($em_id=='SS3' or $em_id=='SOL99'  or $em_id=='SOL4'){

if($em_id=='SOL4'){
$rk = "ckk_1='2'"	;
}else{
$rk = "1"	; 	
}
	
$strSQL ="SELECT * FROM tb_team_ss3 where $rk";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code1 = $objResult["sale_code"];
$sale_name = $objResult["sale_name"];




if($sale_code1 =='SOL99' or $sale_code1 =='SOL2' or $sale_code1 =='SOL1' or $sale_code1 =='SOL3' or $sale_code1 =='SOL4' or $sale_code1 =='SOL5' or $sale_code1 =='SOL6'){
?>
	
	<center>
<span class="style16"><?php echo $sale_name ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $sale_code1 ;  ?></span>
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

<?php

$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' ";

if($start_date !=""){ 
    $strSQL5 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND select_type_doc = "'.$company.'"'; 
}

if($sale_code1 !=""){ 
    $strSQL5 .= ' AND employee_name = "'.$sale_code1.'"'; 
}

//echo $strSQL5;


$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL15 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL15 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_code1 !=""){ 
    $strSQL15 .= ' AND employee_name = "'.$sale_code1.'"'; 
}


//echo $strSQL15;



$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);








	$total1=$objResult5['total'];
$total2=$objResult15['total1'];
$total3 = $total1+$total2;

$total= number_format( $total3,2)."";

$no_vat_to1 = ($total3 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL11 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,sale_channel FROM so__main WHERE doc_no !='' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL11 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL11 .= ' AND select_type_doc = "'.$company.'"'; 
}

if($sale_code1 !=""){ 
    $strSQL11 .= ' AND employee_name = "'.$sale_code1.'"'; 
}

$strSQL11 .=" order  by doc_no ASC  ";


$objQuery11 =mysqli_query($conn,$strSQL11);
while($objResult11=mysqli_fetch_array($objQuery11)){

$strSQL12 ="SELECT SUM(sum_amount) as sum_amount12  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE doc_no = '".$objResult11["doc_no"]."'  and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL12 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL12 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL12 .= ' AND select_type_doc = "'.$company.'"'; 
}

if($sale_code1 !=""){ 
    $strSQL12 .= ' AND employee_name = "'.$sale_code1.'"'; 
}


$objQuery12 =mysqli_query($conn,$strSQL12);
while($objResult12=mysqli_fetch_array($objQuery12)){

$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult11["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);



$summary_12=$objResult12['sum_amount12'];
$summary12= number_format( $summary_12,2)."";

$no_vat12 = ($summary_12 / 1.07); 
$no_vat_12 = number_format( $no_vat12,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult11["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult11["doc_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult11["customer_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary12; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_12; ?></td> 

	</tr>




	<?php

}
}






$strSQL21 ="SELECT distinct iv_no,iv_date,sale_channel FROM so__main WHERE iv_no !='' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL21 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL21 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL21 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_code1 !=""){ 
    $strSQL21 .= ' AND employee_name = "'.$sale_code1.'"'; 
}


$strSQL21 .=" order  by iv_no ASC  ";



$objQuery21 =mysqli_query($conn,$strSQL21);
while($objResult21=mysqli_fetch_array($objQuery21)){

$strSQL22 ="SELECT SUM(sum_amount) as sum_amount22  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE iv_no = '".$objResult21["iv_no"]."'  and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL22 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL22 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL22 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_code1 !=""){ 
    $strSQL22 .= ' AND employee_name = "'.$sale_code1.'"'; 
}


$objQuery22 =mysqli_query($conn,$strSQL22);
$objResult22=mysqli_fetch_array($objQuery22);


$summary_22=$objResult22['sum_amount22'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat_22 = number_format( $no_vat22,2)."";

$strSQL23 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult21["sale_channel"]."'  ";

$objQuery23 =mysqli_query($conn,$strSQL23);
$objResult23=mysqli_fetch_array($objQuery23);



?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult21["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult21["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult23["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_22; ?></td> 

	</tr>




	<?php


}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
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

if($sale_code1 !=""){ 
    $strSQL211 .= ' AND sale_code = "'.$sale_code1.'"'; 
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

if($sale_code1 !=""){ 
    $strSQL151 .= ' AND sale_code = "'.$sale_code1.'"'; 
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
<td width="55%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 

$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total3-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>




<?php



	}else{

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

	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0'  and ic_ckk='0'";

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




$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and status_adm !='ยกเลิก' and ic_ckk='0'";


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
<td  align="center" class="style30"><?php echo  $objResult1["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and status_adm !='ยกเลิก' and ic_ckk='0'";


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
<td  align="center" class="style30"><?php echo  $objResult61["iv_no"]; ?></td>
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
<td width="45%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
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
<td width="45%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>


	<?
}
} 
}
}
?>

<?php }else{ 

$strSQL ="SELECT * FROM tb_team_all ";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code1 = $objResult["sale_code"];
//echo $sale_code1;
	//exit();

if($sale_code1 =='S11' ){
$sale_name ="พจนีย์  พ่วงศรี";
}else if($sale_code1 =='S12' ){
$sale_name ="S12";

}else if($sale_code1 =='S13' ){
$sale_name ="S13";

}else if($sale_code1 =='S14' ){
$sale_name ="S14";

}else if($sale_code1 =='S15' ){
$sale_name ="ชลกานต์ ชัยชนะ";

}else if($sale_code1 =='S16' ){
$sale_name ="ภัณฑิลา มงคลสวัสดิ์";

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

}else if($sale_code1 =='S32'){
$sale_name ="S32";

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
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>





<?php

	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0'  and ic_ckk='0'";

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




$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and status_adm !='ยกเลิก' and ic_ckk='0'";


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
<td  align="center" class="style30"><?php echo  $objResult1["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and status_adm !='ยกเลิก' and ic_ckk='0'";


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
<td  align="center" class="style30"><?php echo  $objResult61["iv_no"]; ?></td>
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
<td width="45%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
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
<td width="45%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>


	<?
}
} 
}
?>

<?php } ?>




<?php 
	
/*$strSQL ="SELECT * FROM tb_team_allwell order by allwell_id ASC";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code1 = $objResult["sale_code"];
	
$strSQL20 ="SELECT  doc_no,doc_release_date,customer_name,ref_id FROM so__main WHERE doc_no !='' and employee_name = '".$sale_code1."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL20 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL20 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL20 .= ' AND select_type_doc = "'.$company.'"'; 
}

//echo $strSQL20;


$objQuery20 =mysqli_query($conn,$strSQL20);
$Num_Rows20 = mysqli_num_rows($objQuery20);

 if ($Num_Rows20 > 0){

?>

</p>
<center>
<span class="style16"><?php echo $sale_code1; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $sale_code1 ;  ?></span>
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

<?php

$strSQL21 = "SELECT SUM(sum_amount)  as total21  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  cancel_ckk ='0' and employee_name = '".$sale_code1."'";

if($start_date !=""){ 
    $strSQL21 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL21 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL21 .= ' AND select_type_doc = "'.$company.'"'; 
}



//echo $strSQL5;


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



//echo $strSQL15;



$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);








	$total21=$objResult21['total21'];
$total22=$objResult22['total22'];
$total23 = $total21+$total22;

$total_23= number_format( $total23,2)."";

$no_vat_to24 = ($total23 / 1.07); 
$no_vat_to23 = number_format( $no_vat_to24,2)."";




$strSQL23 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,sale_channel FROM so__main WHERE doc_no !='' and employee_name = '".$sale_code1."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL23 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL23 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL23 .= ' AND select_type_doc = "'.$company.'"'; 
}



$strSQL23 .=" order  by doc_no ASC  ";


$objQuery23 = mysqli_query($conn,$strSQL23);
while($objResult23 = mysqli_fetch_array($objQuery23)){

$strSQL24 ="SELECT SUM(sum_amount) as sum_amount24  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE doc_no = '".$objResult23["doc_no"]."' and employee_name = '".$sale_code1."' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL24 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL24 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL24 .= ' AND select_type_doc = "'.$company.'"'; 
}



$objQuery24 =mysqli_query($conn,$strSQL24);
while($objResult24 = mysqli_fetch_array($objQuery24)){


$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult23["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);


$summary_24=$objResult24['sum_amount24'];
$summary24= number_format( $summary_24,2)."";

$no_vat24 = ($summary_24 / 1.07); 
$no_vat_24 = number_format( $no_vat24,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult23["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult23["doc_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult23["customer_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary24; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_24; ?></td> 

	</tr>




	<?php

}
}






$strSQL25 ="SELECT distinct iv_no,iv_date,sale_channel FROM so__main WHERE iv_no !='' and employee_name = '".$sale_code1."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL25 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL25 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL25 .= ' AND select_type_doc = "'.$company1.'"'; 
}



$strSQL25 .=" order  by iv_no ASC  ";



$objQuery25 =mysqli_query($conn,$strSQL25);
while($objResult25=mysqli_fetch_array($objQuery25)){

$strSQL26 ="SELECT SUM(sum_amount) as sum_amount26  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE iv_no = '".$objResult25["iv_no"]."' and employee_name = '".$sale_code1."' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL26 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL26 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL26 .= ' AND select_type_doc = "'.$company1.'"'; 
}


$objQuery26 =mysqli_query($conn,$strSQL26);
$objResult26=mysqli_fetch_array($objQuery26);


$summary_26=$objResult26['sum_amount26'];
$summary26= number_format( $summary_26,2)."";

$no_vat26 = ($summary_26 / 1.07); 
$no_vat_26 = number_format( $no_vat26,2)."";

$strSQL27 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult25["sale_channel"]."'  ";

$objQuery27 =mysqli_query($conn,$strSQL27);
$objResult27=mysqli_fetch_array($objQuery27);



?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult25["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult25["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult27["salechannel_nameshort"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary26; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_26; ?></td> 

	</tr>




	<?php


}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_code1; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total_23; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to23; ?></td> 

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
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = '".$sale_code1."'";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
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

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code1; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 

$creditno_vat1 = $no_vat_to24-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total23-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>


<?php } 
}
?>



<?php  
	
	
	/*$strSQL51 = "SELECT SUM(sum_amount)  as total41  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  cancel_ckk = '0' ";

if($start_date !=""){ 
    $strSQL51 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL51 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL51 .= ' AND select_type_doc = "'.$company.'"'; 
}


$objQuery51 = mysqli_query($conn,$strSQL51) or die ("Error Query [".$strSQL51."]");
$objResult51 = mysqli_fetch_array($objQuery51);

$strSQL52 = "SELECT SUM(sum_amount)  as total42  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !=''  and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL52 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL52 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL52 .= ' AND select_type_doc = "'.$company1.'"'; 
}


$objQuery52 = mysqli_query($conn,$strSQL52) or die ("Error Query [".$strSQL52."]");
$objResult52 = mysqli_fetch_array($objQuery52);*/
	/*
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
	
$strSQL53 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' ";

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
	
$strSQL54 = "SELECT SUM(amount)  as total53  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' ";

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
	
	
$total53=$objResult54['total53'];
//echo $total53;
$total1=$objResult53['total'];
//$total51=$objResult51['total41'];
//$total52=$objResult52['total42'];
	
$credit50=$objResult50['total50'];
$no_vat_credit50 = ($credit50 / 1.07); 	
$total_online = $total23+$total33+$total1+$total53+$total43+$total63;

$total_online1 = ($total_online / 1.07); 

$summary = $total_online -$credit50 ;
$summary_novat = $total_online1 -$no_vat_credit50 ;
$summary1 = number_format( $summary,2)."";
$summary_novat1 = number_format( $summary_novat,2)."";
?>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">ยอดรวมทั้งหมด</td>
<td width="10%" align="right" class="style16"><?php echo $summary1; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $summary_novat1; ?></td> 

	</tr>
</table>
*/
?>
<?php 
}
?>
</body>
</html>