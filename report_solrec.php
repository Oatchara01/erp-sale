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
$sale_channel = $_GET["sale_channel"]; 
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

if($sale_code !=""){ 
    $strSQL5 .= ' AND employee_name = "'.$sale_code.'"'; 
}
	
if($sale_channel !=''){
   $strSQL5 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
}


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
	
if($sale_channel !=''){
   $strSQL15 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
}
	

$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);








	$total1=$objResult5['total'];
$total2=$objResult15['total1'];
$total3 = $total1+$total2;

$total= number_format( $total3,2)."";

$no_vat_to1 = ($total3 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL11 ="SELECT  doc_no,doc_release_date,billing_name,ref_id,sale_channel FROM so__main WHERE doc_no !='' and cancel_ckk ='0'";


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

if($sale_channel !=''){
   $strSQL11 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
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

if($sale_channel !=''){
   $strSQL12 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
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
<td  align="center" class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult11["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult11["doc_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult11["billing_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary12; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_12; ?></td> 

	</tr>




	<?php

}
}






$strSQL21 ="SELECT distinct iv_no,iv_date FROM so__main WHERE iv_no !='' and cancel_ckk ='0'";


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
	
if($sale_channel !=''){
   $strSQL21 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
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

if($sale_channel !=''){
   $strSQL22 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
}
	

$objQuery22 =mysqli_query($conn,$strSQL22);
$objResult22=mysqli_fetch_array($objQuery22);


$summary_22=$objResult22['sum_amount22'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat_22 = number_format( $no_vat22,2)."";

/*$strSQL23 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult21["sale_channel"]."'  ";

$objQuery23 =mysqli_query($conn,$strSQL23);
$objResult23=mysqli_fetch_array($objQuery23);*/



?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult21["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult21["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult21["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"></td> 
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

if($start_date !=""){ 
    $strSQL233 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL233 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL233 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL233 .= ' AND sale_code = "'.$sale_code.'"'; 
}	
	
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


} else{


$strSQL ="SELECT * FROM tb_team_adm where ckk='1' ";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code1 = $objResult["sale_code"];

$sale_name = $objResult["sale_name"];



/*$strSQL20 ="SELECT  doc_no,doc_release_date,billing_name,ref_id FROM so__main WHERE doc_no !='' and employee_name = '".$sale_code1."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL20 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL20 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL20 .= ' AND select_type_doc = "'.$company.'"'; 
}
	
if($sale_channel !=''){
   $strSQL20 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
}
	


$objQuery20 =mysqli_query($conn,$strSQL20);
$Num_Rows20 = mysqli_num_rows($objQuery20);

 if ($Num_Rows20 > 0){*/

?>

</p>
<center>
<span class="style16"><?php echo $sale_code1 ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $sale_name ;  ?></span>
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
					  
if($sale_channel !=''){
   $strSQL21 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
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
					  
if($sale_channel !=''){
   $strSQL22 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
}
					  

$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);








	$total21=$objResult21['total21'];
$total22=$objResult22['total22'];
$total23 = $total21+$total22;

$total_23= number_format( $total23,2)."";

$no_vat_to24 = ($total23 / 1.07); 
$no_vat_to23 = number_format( $no_vat_to24,2)."";




$strSQL23 ="SELECT  doc_no,doc_release_date,billing_name,ref_id,sale_channel FROM so__main WHERE doc_no !='' and employee_name = '".$sale_code1."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL23 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL23 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL23 .= ' AND select_type_doc = "'.$company.'"'; 
}
					  
if($sale_channel !=''){
   $strSQL23 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
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

if($sale_channel !=''){
   $strSQL24 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
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
<td  align="center" class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult23["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult23["doc_no"]; ?></span></a></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult23["billing_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary24; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_24; ?></td> 

	</tr>




	<?php

}
}






$strSQL25 ="SELECT distinct iv_no FROM so__main WHERE iv_no !='' and employee_name = '".$sale_code1."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL25 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL25 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL25 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_channel !=''){
   $strSQL25 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
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

if($sale_channel !=''){
   $strSQL26 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
}

$objQuery26 =mysqli_query($conn,$strSQL26);
$objResult26=mysqli_fetch_array($objQuery26);


$summary_26=$objResult26['sum_amount26'];
$summary26= number_format( $summary_26,2)."";

$no_vat26 = ($summary_26 / 1.07); 
$no_vat_26 = number_format( $no_vat26,2)."";

$strSQL37 ="SELECT sale_channel,iv_date  FROM so__main  WHERE iv_no = '".$objResult25["iv_no"]."' and employee_name = '".$sale_code1."' and cancel_ckk ='0'  ";

if($sale_channel !=''){
   $strSQL37 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
}
	
	
$objQuery37 =mysqli_query($conn,$strSQL37);
$objResult37=mysqli_fetch_array($objQuery37);
		
$strSQL27 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult37["sale_channel"]."'  ";

$objQuery27 =mysqli_query($conn,$strSQL27);
$objResult27=mysqli_fetch_array($objQuery27);



?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult37["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult25["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult25["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"></td> 
	<td  align="center" class="style30"><?php echo  $objResult27["salechannel_nameshort"]; ?></td>
<td  align="right" class="style30"><?php echo $summary26; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_26; ?></td> 

	</tr>




	<?php


}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
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
<td width="55%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_name; ?></td>
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
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>




<?php
//}
}
	





	
$strSQL50 = "SELECT SUM(sum_amount)  as total50  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code LIKE '%SOL%'";

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


	


$strSQL55 = "SELECT SUM(sum_amount)  as sum_amount  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  cancel_ckk ='0' and doc_no !=''  ";
//and employee_name LIKE '%SOL%'
if($start_date !=""){ 
    $strSQL55 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL55 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL55 .= ' AND select_type_doc = "'.$company.'"'; 
}

if($sale_channel !=''){
   $strSQL55 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
}

$objQuery55 = mysqli_query($conn,$strSQL55) or die ("Error Query [".$strSQL55."]");
$objResult55 = mysqli_fetch_array($objQuery55);


$strSQL56 = "SELECT SUM(sum_amount)  as total22  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !=''   and cancel_ckk ='0' ";
//and employee_name LIKE '%SOL%'
if($start_date !=""){ 
    $strSQL56 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL56 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL56 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_channel !=''){
   $strSQL56 .= ' AND sale_channel = "'.$sale_channel.'"'; 	
}
	
	
$objQuery56 = mysqli_query($conn,$strSQL56) or die ("Error Query [".$strSQL56."]");
$objResult56 = mysqli_fetch_array($objQuery56);
		
		

$sol_1=$objResult55['sum_amount'];
$sol_2=$objResult56['total22'];

	

$total_online = $sol_1+$sol_2;

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
<td width="55%" align="left" class="style16">ยอดรวมทั้งหมด</td>
<td width="10%" align="right" class="style16"><?php echo $summary_allrec; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $summary_rec; ?></td> 

	</tr>
</table>

<?php 
}

?>
</body>
</html>