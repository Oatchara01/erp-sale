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


function barcode($code){
    
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 0.5;//กำหนดความหน้าของเส้น Barcode
    $height = 15;//กำหนดความสูงของ Barcode
 
    return $generator->getBarcode($code , $generator::TYPE_CODE_128,$border,$height);
 
}
 

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
$emid = $_GET['code'];



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
 if ($emid =='SOL1' ){

?>

<?php

$strSQL ="SELECT * FROM tb_team_allwell order by allwell_id ASC";

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
?><br><br>


<?php 
$strSQL ="SELECT * FROM tb_team_ss3 where ckk_1 ='0'";

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




$strSQL1 ="SELECT  iv_no,iv_date,bill_name,bill_tel,ref_id FROM hos__so WHERE status_doc ='Approve' and have_order = '0' ";


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



$strSQL233 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

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
<td  align="left" class="style30"><?php echo  $objResult233["access_name"]; ?></td> 
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

<?php
}

?>

<?php } ?>

<?php
 if ($emid =='SOL2' ){
?>
</p>
<center>
<span class="style16"><?php echo "รัชดาภรณ์ สีสัน SOL2" ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "รัชดาภรณ์ สีสัน SOL2" ;  ?></span>
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

$strSQL31 = "SELECT SUM(sum_amount)  as total31  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='' and employee_name = 'SOL2' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL31 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL31 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL31 .= ' AND select_type_doc = "'.$company.'"'; 
}



//echo $strSQL5;


$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$objResult31 = mysqli_fetch_array($objQuery31);


$strSQL32 = "SELECT SUM(sum_amount)  as total32  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !=''  and employee_name = 'SOL2' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL32 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL32 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL32 .= ' AND select_type_doc = "'.$company1.'"'; 
}



//echo $strSQL15;



$objQuery32 = mysqli_query($conn,$strSQL32) or die ("Error Query [".$strSQL32."]");
$objResult32 = mysqli_fetch_array($objQuery32);








	$total31=$objResult31['total31'];
$total32=$objResult32['total32'];
$total33 = $total31+$total32;
$no_vat_to31 = ($total33 / 1.07); 
$no_vat_to33 = number_format( $no_vat_to31,2)."";
$total_33= number_format( $total33,2)."";



$strSQL33 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,sale_channel FROM so__main WHERE doc_no !='' and employee_name = 'SOL2' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL33 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL33 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL33 .= ' AND select_type_doc = "'.$company.'"'; 
}



$strSQL33 .=" order  by doc_no ASC  ";


$objQuery33 = mysqli_query($conn,$strSQL33);
while($objResult33 = mysqli_fetch_array($objQuery33)){

$strSQL34 ="SELECT SUM(sum_amount) as sum_amount34  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE doc_no = '".$objResult33["doc_no"]."' and employee_name = 'SOL2' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL34 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL34 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL34 .= ' AND select_type_doc = "'.$company.'"'; 
}



$objQuery34 =mysqli_query($conn,$strSQL34);
while($objResult34 = mysqli_fetch_array($objQuery34)){

$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult33["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);


$summary_34=$objResult34['sum_amount34'];
$summary34= number_format( $summary_34,2)."";

$no_vat34 = ($summary_34 / 1.07); 
$no_vat_34 = number_format( $no_vat34,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult33["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult33["doc_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult33["customer_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary34; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_34; ?></td> 

	</tr>




	<?php

}
}






$strSQL35 ="SELECT distinct iv_no,iv_date,customer_name,sale_channel FROM so__main WHERE iv_no !='' and employee_name = 'SOL2' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL35 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL35 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL35 .= ' AND select_type_doc = "'.$company1.'"'; 
}



$strSQL35 .=" order  by iv_no ASC  ";



$objQuery35 =mysqli_query($conn,$strSQL35);
while($objResult35=mysqli_fetch_array($objQuery35)){

$strSQL36 ="SELECT SUM(sum_amount) as sum_amount36  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE iv_no = '".$objResult35["iv_no"]."' and employee_name = 'SOL2' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL36 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL36 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL36 .= ' AND select_type_doc = "'.$company1.'"'; 
}


$objQuery36 =mysqli_query($conn,$strSQL36);
$objResult36=mysqli_fetch_array($objQuery36);


	
$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult35["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);
	
$summary_36=$objResult36['sum_amount36'];
$summary36= number_format( $summary_36,2)."";

$no_vat36 = ($summary_36 / 1.07); 
$no_vat_36 = number_format( $no_vat36,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult35["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult35["iv_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult35["customer_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary36; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_36; ?></td> 

	</tr>




	<?php


}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo "รัชดาภรณ์ สีสัน SOL2" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total_33; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to33; ?></td> 

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
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL2'";


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
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL2'";

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
<td width="55%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo "รัชดาภรณ์ สีสัน SOL2" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 

$creditno_vat1 = $no_vat_to31-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total33-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo "รัชดาภรณ์ สีสัน SOL2" ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>

</p>
<center>
<span class="style16"><?php echo "SOL3" ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "SOL3" ;  ?></span>
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

$strSQL41 = "SELECT SUM(sum_amount)  as total41  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='ยกเลิก' and employee_name = 'SOL3' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL41 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL41 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL41 .= ' AND select_type_doc = "'.$company.'"'; 
}



//echo $strSQL5;


$objQuery41 = mysqli_query($conn,$strSQL41) or die ("Error Query [".$strSQL41."]");
$objResult41 = mysqli_fetch_array($objQuery41);


$strSQL42 = "SELECT SUM(sum_amount)  as total42  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !=''  and employee_name = 'SOL3' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL42 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL42 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL42 .= ' AND select_type_doc = "'.$company1.'"'; 
}



//echo $strSQL15;



$objQuery42 = mysqli_query($conn,$strSQL42) or die ("Error Query [".$strSQL42."]");
$objResult42 = mysqli_fetch_array($objQuery42);








	$total41=$objResult41['total41'];
$total42=$objResult42['total42'];
$total63 = $total41+$total42;
$no_vat_to42 = ($total63 / 1.07); 
$no_vat_to43 = number_format( $no_vat_to42,2)."";
$total_43= number_format( $total63,2)."";



$strSQL43 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,sale_channel FROM so__main WHERE doc_no !='' and employee_name = 'SOL3' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL43 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL43 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL43 .= ' AND select_type_doc = "'.$company.'"'; 
}



$strSQL43 .=" order  by doc_no ASC  ";


$objQuery43 = mysqli_query($conn,$strSQL43);
while($objResult43 = mysqli_fetch_array($objQuery43)){

$strSQL44 ="SELECT SUM(sum_amount) as sum_amount44  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE doc_no = '".$objResult43["doc_no"]."' and employee_name = 'SOL3' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL44 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL44 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL44 .= ' AND select_type_doc = "'.$company.'"'; 
}



$objQuery44 =mysqli_query($conn,$strSQL44);
while($objResult44 = mysqli_fetch_array($objQuery44)){


$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult43["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);

$summary_44=$objResult44['sum_amount44'];
$summary46= number_format( $summary_44,2)."";

$no_vat44 = ($summary_44 / 1.07); 
$no_vat_44 = number_format( $no_vat44,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult43["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult43["doc_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult43["customer_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary46; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_44; ?></td> 

	</tr>




	<?php

}
}






$strSQL45 ="SELECT distinct iv_no,iv_date,sale_channel,customer_name FROM so__main WHERE iv_no !='' and employee_name = 'SOL3' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL45 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL45 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL45 .= ' AND select_type_doc = "'.$company1.'"'; 
}



$strSQL45 .=" order  by iv_no ASC  ";



$objQuery45 =mysqli_query($conn,$strSQL45);
while($objResult45=mysqli_fetch_array($objQuery45)){

$strSQL46 ="SELECT SUM(sum_amount) as sum_amount46  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE iv_no = '".$objResult45["iv_no"]."' and employee_name = 'SOL3' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL46 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL46 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL46 .= ' AND select_type_doc = "'.$company1.'"'; 
}


$objQuery46 =mysqli_query($conn,$strSQL46);
$objResult46=mysqli_fetch_array($objQuery46);


$summary_46=$objResult46['sum_amount46'];
$summary47= number_format( $summary_46,2)."";

$no_vat46 = ($summary_46 / 1.07); 
$no_vat_46 = number_format( $no_vat46,2)."";

$strSQL47 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult45["sale_channel"]."'  ";

$objQuery47 =mysqli_query($conn,$strSQL47);
$objResult47=mysqli_fetch_array($objQuery47);



?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult45["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult45["iv_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult45["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult47["salechannel_nameshort"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary47; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_46; ?></td> 

	</tr>




	<?php


}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo "SOL3" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total_43; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to43; ?></td> 

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
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL3'";


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
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL3'";

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
<td width="55%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo "SOL3" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php


$creditno_vat1 = $no_vat_to42-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total63-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo "SOL3" ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>


<?php } ?>



<?php
 if ($emid =='SOL99' ){
?>
</p>
<center>
<span class="style16"><?php echo "SOL99" ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "SOL99" ;  ?></span>
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

$strSQL41 = "SELECT SUM(sum_amount)  as total41  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='ยกเลิก' and employee_name = 'SOL99' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL41 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL41 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL41 .= ' AND select_type_doc = "'.$company.'"'; 
}





$objQuery41 = mysqli_query($conn,$strSQL41) or die ("Error Query [".$strSQL41."]");
$objResult41 = mysqli_fetch_array($objQuery41);


$strSQL42 = "SELECT SUM(sum_amount)  as total42  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !=''  and employee_name = 'SOL99' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL42 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL42 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL42 .= ' AND select_type_doc = "'.$company1.'"'; 
}



//echo $strSQL15;



$objQuery42 = mysqli_query($conn,$strSQL42) or die ("Error Query [".$strSQL42."]");
$objResult42 = mysqli_fetch_array($objQuery42);








	$total41=$objResult41['total41'];
$total42=$objResult42['total42'];
$total43 = $total41+$total42;
$no_vat_to42 = ($total43 / 1.07); 
$no_vat_to43 = number_format( $no_vat_to42,2)."";
$total_43= number_format( $total43,2)."";



$strSQL43 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,sale_channel FROM so__main WHERE doc_no !='' and employee_name = 'SOL99' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL43 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL43 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL43 .= ' AND select_type_doc = "'.$company.'"'; 
}



$strSQL43 .=" order  by doc_no ASC  ";


$objQuery43 = mysqli_query($conn,$strSQL43);
while($objResult43 = mysqli_fetch_array($objQuery43)){

$strSQL44 ="SELECT SUM(sum_amount) as sum_amount44  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE doc_no = '".$objResult43["doc_no"]."' and employee_name = 'SOL99' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL44 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL44 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL44 .= ' AND select_type_doc = "'.$company.'"'; 
}



$objQuery44 =mysqli_query($conn,$strSQL44);
while($objResult44 = mysqli_fetch_array($objQuery44)){

$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult43["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);


$summary_44=$objResult44['sum_amount44'];
$summary46= number_format( $summary_44,2)."";

$no_vat44 = ($summary_44 / 1.07); 
$no_vat_44 = number_format( $no_vat44,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult43["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult43["doc_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult43["customer_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary46; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_44; ?></td> 

	</tr>




	<?php

}
}






$strSQL45 ="SELECT distinct iv_no,iv_date,sale_channel FROM so__main WHERE iv_no !='' and employee_name = 'SOL99' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL45 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL45 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL45 .= ' AND select_type_doc = "'.$company1.'"'; 
}



$strSQL45 .=" order  by iv_no ASC  ";



$objQuery45 =mysqli_query($conn,$strSQL45);
while($objResult45=mysqli_fetch_array($objQuery45)){

$strSQL46 ="SELECT SUM(sum_amount) as sum_amount46  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE iv_no = '".$objResult45["iv_no"]."' and employee_name = 'SOL99' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL46 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL46 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL46 .= ' AND select_type_doc = "'.$company1.'"'; 
}


$objQuery46 =mysqli_query($conn,$strSQL46);
$objResult46=mysqli_fetch_array($objQuery46);


$summary_46=$objResult46['sum_amount46'];
$summary47= number_format( $summary_46,2)."";

$no_vat46 = ($summary_46 / 1.07); 
$no_vat_46 = number_format( $no_vat46,2)."";

$strSQL47 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult45["sale_channel"]."'  ";

$objQuery47 =mysqli_query($conn,$strSQL47);
$objResult47=mysqli_fetch_array($objQuery47);



?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult45["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult45["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult47["salechannel_nameshort"]; ?></td> 
	<td  align="left" class="style30"></td> 
<td  align="right" class="style30"><?php echo $summary47; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_46; ?></td> 

	</tr>




	<?php


}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo "SOL99" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total_43; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to43; ?></td> 

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
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL99'";


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
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL99'";

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
<td width="55%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo "SOL99" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php


$creditno_vat1 = $no_vat_to42-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total43-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo "SOL99" ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>

<?php } ?>


</p>
<center>
<span class="style16"><?php echo "SOL6" ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "SOL6" ;  ?></span>
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

$strSQL41 = "SELECT SUM(sum_amount)  as total41  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='ยกเลิก' and employee_name = 'SOL6' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL41 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL41 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL41 .= ' AND select_type_doc = "'.$company.'"'; 
}



//echo $strSQL5;


$objQuery41 = mysqli_query($conn,$strSQL41) or die ("Error Query [".$strSQL41."]");
$objResult41 = mysqli_fetch_array($objQuery41);


$strSQL42 = "SELECT SUM(sum_amount)  as total42  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !=''  and employee_name = 'SOL6' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL42 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL42 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL42 .= ' AND select_type_doc = "'.$company1.'"'; 
}



//echo $strSQL15;



$objQuery42 = mysqli_query($conn,$strSQL42) or die ("Error Query [".$strSQL42."]");
$objResult42 = mysqli_fetch_array($objQuery42);








	$total41=$objResult41['total41'];
$total42=$objResult42['total42'];
$total63 = $total41+$total42;
$no_vat_to42 = ($total63 / 1.07); 
$no_vat_to43 = number_format( $no_vat_to42,2)."";
$total_43= number_format( $total63,2)."";



$strSQL43 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,sale_channel FROM so__main WHERE doc_no !='' and employee_name = 'SOL6' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL43 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL43 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL43 .= ' AND select_type_doc = "'.$company.'"'; 
}



$strSQL43 .=" order  by doc_no ASC  ";


$objQuery43 = mysqli_query($conn,$strSQL43);
while($objResult43 = mysqli_fetch_array($objQuery43)){

$strSQL44 ="SELECT SUM(sum_amount) as sum_amount44  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE doc_no = '".$objResult43["doc_no"]."' and employee_name = 'SOL6' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL44 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL44 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL44 .= ' AND select_type_doc = "'.$company.'"'; 
}



$objQuery44 =mysqli_query($conn,$strSQL44);
while($objResult44 = mysqli_fetch_array($objQuery44)){


$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult43["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);

$summary_44=$objResult44['sum_amount44'];
$summary46= number_format( $summary_44,2)."";

$no_vat44 = ($summary_44 / 1.07); 
$no_vat_44 = number_format( $no_vat44,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult43["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult43["doc_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult43["customer_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary46; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_44; ?></td> 

	</tr>




	<?php

}
}






$strSQL45 ="SELECT distinct iv_no,iv_date,sale_channel,customer_name FROM so__main WHERE iv_no !='' and employee_name = 'SOL6' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL45 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL45 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL45 .= ' AND select_type_doc = "'.$company1.'"'; 
}



$strSQL45 .=" order  by iv_no ASC  ";



$objQuery45 =mysqli_query($conn,$strSQL45);
while($objResult45=mysqli_fetch_array($objQuery45)){

$strSQL46 ="SELECT SUM(sum_amount) as sum_amount46  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE iv_no = '".$objResult45["iv_no"]."' and employee_name = 'SOL6' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL46 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL46 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL46 .= ' AND select_type_doc = "'.$company1.'"'; 
}


$objQuery46 =mysqli_query($conn,$strSQL46);
$objResult46=mysqli_fetch_array($objQuery46);


$summary_46=$objResult46['sum_amount46'];
$summary47= number_format( $summary_46,2)."";

$no_vat46 = ($summary_46 / 1.07); 
$no_vat_46 = number_format( $no_vat46,2)."";

$strSQL47 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult45["sale_channel"]."'  ";

$objQuery47 =mysqli_query($conn,$strSQL47);
$objResult47=mysqli_fetch_array($objQuery47);



?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult45["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult45["iv_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult45["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult47["salechannel_nameshort"]; ?></td> 
<td  align="right" class="style30"><?php echo $summary47; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_46; ?></td> 

	</tr>




	<?php


}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo "SOL6" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total_43; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to43; ?></td> 

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
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL6'";


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
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL6'";

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
<td width="55%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo "SOL6" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php


$creditno_vat1 = $no_vat_to42-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total63-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo "SOL6" ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>


<?php //} ?>




</body>
</html>