<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 16px; color: #FF0000;}
.style17 {font-size: 16px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 14px; color: #000000;}
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
if($emid =='SOL1' ){

?>

<?php

$strSQL ="SELECT * FROM tb_team_allwell order by allwell_id ASC";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code = $objResult["sale_code"];
$sale_name = $objResult["sale_name"];

?>

<center>
<span class="style16"><?php echo $sale_code; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $sale_name ;  ?></span>
</center> 
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="10%" align="center" class="style30">ช่องทางการขาย</td> 
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>


<?php

	

$strSQL8 = "SELECT SUM(sum_amount)  as total8  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='' AND employee_name = '".$sale_code."' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL8 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL8 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL8 .= ' AND select_type_doc = "'.$company.'"'; 
}


//echo $strSQL5;


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total9  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' AND employee_name = '".$sale_code."' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL9 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL9 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL9 .= ' AND select_type_doc = "'.$company1.'"'; 
}


$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$total8=$objResult8['total8'];
$total9=$objResult9['total9'];
$total10 = $total8+$total9;
$no_vat1 = ($total10 / 1.07); 
$tot= number_format( $total10,2)."";
$no_vat = number_format( $no_vat1,2)."";




$strSQL10 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE doc_no !='' and employee_name = '".$sale_code."' and cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL10 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL10 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL10 .= ' AND select_type_doc = "'.$company.'"'; 
}


$strSQL10 .=" order  by doc_no ASC  ";

$objQuery10 =mysqli_query($conn,$strSQL10);
while($objResult10=mysqli_fetch_array($objQuery10)){

$strSQL7 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult10["ref_id"]."'  ";

$objQuery7 =mysqli_query($conn,$strSQL7);
while($objResult7=mysqli_fetch_array($objQuery7)){



$strSQL16 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult7["product_id"]."'  ";

$objQuery16 =mysqli_query($conn,$strSQL16);
while($objResult16=mysqli_fetch_array($objQuery16)){

$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult10["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);
	
$summary_17=$objResult7['sum_amount'];
$summary17= number_format( $summary_17,2)."";

$no_vat17 = ($summary_17 / 1.07); 
$no_vat_17 = number_format( $no_vat17,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult10["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult10["doc_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult10["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult16["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult7["sale_count"];  ?>&nbsp;<?php echo $objResult16["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary17; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_17; ?></td> 

	</tr>




	<?php
}
}
}






$strSQL26 ="SELECT  iv_no,iv_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE iv_no !='' and employee_name = '".$sale_code."' and cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL26 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL26 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL26 .= ' AND select_type_doc = "'.$company1.'"'; 
}


$strSQL26 .=" order  by iv_no ASC  ";


$objQuery26 =mysqli_query($conn,$strSQL26);
while($objResult26=mysqli_fetch_array($objQuery26)){

$strSQL27 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult26["ref_id"]."'  ";

$objQuery27 =mysqli_query($conn,$strSQL27);
while($objResult27=mysqli_fetch_array($objQuery27)){



$strSQL28 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult27["product_id"]."'  ";

$objQuery28 =mysqli_query($conn,$strSQL28);
while($objResult28=mysqli_fetch_array($objQuery28)){

$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult26["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);
	
$summary_28=$objResult28['sum_amount'];
$summary28= number_format( $summary_28,2)."";

$no_vat28 = ($summary_28 / 1.07); 
$no_vat28 = number_format( $no_vat28,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult26["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult26["iv_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult26["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult28["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult27["sale_count"];  ?>&nbsp;<?php echo $objResult28["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary28; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat28; ?></td> 

	</tr>




	<?php
}
}
}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $tot; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat; ?></td> 

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
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = '".$sale_code."'";


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
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = '".$sale_code."'";

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
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php

$creditno_vat1 = $no_vat1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total10-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>

<br>

<?php } ?>



<?php
}
?>




<?php 
if($emid == 'SOL2'){	
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
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>


<?php

	

$strSQL31 = "SELECT SUM(sum_amount)  as total31  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='' AND employee_name = 'SOL2' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL31 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL31 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL31 .= ' AND select_type_doc = "'.$company.'"'; 
}



$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$objResult31 = mysqli_fetch_array($objQuery31);


$strSQL32 = "SELECT SUM(sum_amount)  as total32  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' AND employee_name = 'SOL2' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL32 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL32 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL32 .= ' AND select_type_doc = "'.$company1.'"'; 
}


$objQuery32 = mysqli_query($conn,$strSQL32) or die ("Error Query [".$strSQL32."]");
$objResult32 = mysqli_fetch_array($objQuery32);


$total31=$objResult31['total31'];
$total32=$objResult32['total32'];
$total12 = $total31+$total32;

$total13= number_format( $total12,2)."";

$no_vat18 = ($total12 / 1.07); 
$no_vat12 = number_format( $no_vat18,2)."";




$strSQL33 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE doc_no !='' and employee_name = 'SOL2' and cancel_ckk = '0'";


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
					
$objQuery33 =mysqli_query($conn,$strSQL33);
while($objResult33=mysqli_fetch_array($objQuery33)){

$strSQL34 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult33["ref_id"]."'  ";

$objQuery34 =mysqli_query($conn,$strSQL34);
	
while($objResult34=mysqli_fetch_array($objQuery34)){



$strSQL35 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult34["product_id"]."'  ";

$objQuery35 =mysqli_query($conn,$strSQL35);
while($objResult35=mysqli_fetch_array($objQuery35)){

	
$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult33["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);

$summary_15=$objResult34['sum_amount'];
$summary34= number_format( $summary_15,2)."";

$no_vat15 = ($summary_15 / 1.07); 
$no_vat_34 = number_format( $no_vat15,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult33["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult33["doc_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult33["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult35["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult34["sale_count"];  ?>&nbsp;<?php echo $objResult35["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary34; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_34; ?></td> 

	</tr>




	<?php
}
}
}






$strSQL36 ="SELECT  iv_no,iv_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE iv_no !='' and employee_name = 'SOL2' and cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL36 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL36 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL36 .= ' AND select_type_doc = "'.$company1.'"'; 
}



$objQuery36 =mysqli_query($conn,$strSQL36);
while($objResult36=mysqli_fetch_array($objQuery36)){

$strSQL37 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult36["ref_id"]."'  ";

$objQuery37 =mysqli_query($conn,$strSQL37);
while($objResult37=mysqli_fetch_array($objQuery37)){



$strSQL38 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult37["product_id"]."'  ";

$objQuery38 =mysqli_query($conn,$strSQL38);
while($objResult38=mysqli_fetch_array($objQuery38)){

	
$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult36["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);

$summary_38=$objResult38['sum_amount'];
$summary38= number_format( $summary_38,2)."";

$no_vat38 = ($summary_38 / 1.07); 
$no_vat38 = number_format( $no_vat38,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult36["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult36["iv_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult36["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult38["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult37["sale_count"];  ?>&nbsp;<?php echo $objResult38["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary38; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat38; ?></td> 

	</tr>




	<?php
}
}
}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo "รัชดาภรณ์ สีสัน SOL2" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total13; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat12; ?></td> 

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
$strSQL111 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL2'";


if($start_date !=""){ 
    $strSQL111 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL111 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL111 .= ' AND company_type = "'.$company.'"'; 
}

$strSQL111 .=" order  by credit_no ASC  ";


$objQuery111 =mysqli_query($conn,$strSQL111);
while($objResult111=mysqli_fetch_array($objQuery111)){

$strSQL122 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult111["ref_credit"]."'  ";

$objQuery122 = mysqli_query($conn,$strSQL122);
while($objResult122 = mysqli_fetch_array($objQuery122)){



$strSQL133 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult122["product_id"]."'  ";

$objQuery133 = mysqli_query($conn,$strSQL133);
while($objResult133 = mysqli_fetch_array($objQuery133)){


$summary_12=$objResult122['sum_amount'];
$summary12= number_format( $summary_12,2)."";

$no_vat12 = ($summary_12 / 1.07); 
$no_vat12 = number_format( $no_vat12,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult111["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult111["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult111["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult133["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult122["count"];  ?>&nbsp;<?php echo $objResult133["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary12; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat12; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
$strSQL141 = "SELECT SUM(sum_amount)  as total14  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL2'";

if($start_date !=""){ 
    $strSQL141 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL141 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL141 .= ' AND company_type = "'.$company.'"'; 
}

$objQuery141 = mysqli_query($conn,$strSQL141) or die ("Error Query [".$strSQL141."]");
$objResult141 = mysqli_fetch_array($objQuery141);

$total32=$objResult141['total14'];
$total23= number_format( $total32,2)."";

$no_vat_to13 = ($total32 / 1.07); 
$no_vat_to3 = number_format( $no_vat_to13,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo 'รัชดาภรณ์ สีสัน SOL2' ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total23; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to3; ?></td> 

	</tr>
</table>

<?php

$creditno_vat3 =$no_vat18- $no_vat_to13;
$creditno_vat4 = number_format( $creditno_vat3,2)."";

$credit_total2 = $total12-$total32;
$credit_total3 = number_format( $credit_total2,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo 'รัชดาภรณ์ สีสัน SOL2' ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total3; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat4; ?></td> 

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
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>


<?php

	

$strSQL41 = "SELECT SUM(sum_amount)  as total41  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='' AND employee_name = 'SOL3' and cancel_ckk = '0'";

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


$strSQL42 = "SELECT SUM(sum_amount)  as total42  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' AND employee_name = 'SOL3' and cancel_ckk = '0'";

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
$total46 = $total41+$total42;

$total43= number_format( $total46,2)."";

$no_vat40 = ($total46 / 1.07); 
$no_vat42 = number_format( $no_vat40,2)."";




$strSQL43 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE doc_no !='' and employee_name = 'SOL3' and cancel_ckk = '0'";


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


$objQuery43 =mysqli_query($conn,$strSQL43);
while($objResult43=mysqli_fetch_array($objQuery43)){

$strSQL44 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult43["ref_id"]."'  ";

$objQuery44 =mysqli_query($conn,$strSQL44);
while($objResult44=mysqli_fetch_array($objQuery44)){



$strSQL45 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult44["product_id"]."'  ";

$objQuery45 =mysqli_query($conn,$strSQL45);
while($objResult45=mysqli_fetch_array($objQuery45)){

	
$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult43["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);
	
$summary_16=$objResult44['sum_amount'];
$summary44= number_format( $summary_16,2)."";

$no_vat16 = ($summary_16 / 1.07); 
$no_vat_44 = number_format( $no_vat16,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult43["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult43["doc_no"]; ?></td>
	
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult43["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult45["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult44["sale_count"];  ?>&nbsp;<?php echo $objResult45["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary44; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_44; ?></td> 

	</tr>




	<?php
}
}
}






$strSQL46 ="SELECT  iv_no,iv_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE iv_no !='' and employee_name = 'SOL3' and cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL46 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL46 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL46 .= ' AND select_type_doc = "'.$company1.'"'; 
}

$strSQL46 .=" order  by iv_no ASC  ";


$objQuery46 =mysqli_query($conn,$strSQL46);
while($objResult46=mysqli_fetch_array($objQuery46)){

$strSQL47 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult46["ref_id"]."'  ";

$objQuery47 =mysqli_query($conn,$strSQL47);
while($objResult47=mysqli_fetch_array($objQuery47)){



$strSQL48 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult47["product_id"]."'  ";

$objQuery48 =mysqli_query($conn,$strSQL48);
while($objResult48=mysqli_fetch_array($objQuery48)){

$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult46["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);
	
$summary_48=$objResult47['sum_amount'];
$summary48= number_format( $summary_48,2)."";

$no_vat48 = ($summary_48 / 1.07); 
$no_vat48 = number_format( $no_vat48,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult46["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult46["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult46["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult48["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult47["sale_count"];  ?>&nbsp;<?php echo $objResult48["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary48; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat48; ?></td> 

	</tr>




	<?php
}
}
}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo "SOL3" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total43; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat42; ?></td> 

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
$strSQL301 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL3'";


if($start_date !=""){ 
    $strSQL301 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL301 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL301 .= ' AND company_type = "'.$company.'"'; 
}

$strSQL301 .=" order  by credit_no ASC  ";


$objQuery301 =mysqli_query($conn,$strSQL301);
while($objResult301=mysqli_fetch_array($objQuery301)){

$strSQL302 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult301["ref_credit"]."'  ";

$objQuery302 = mysqli_query($conn,$strSQL302);
while($objResult302 = mysqli_fetch_array($objQuery302)){



$strSQL303 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult302["product_id"]."'  ";

$objQuery303 = mysqli_query($conn,$strSQL303);
while($objResult303 = mysqli_fetch_array($objQuery303)){


$summary_302=$objResult302['sum_amount'];
$summary302= number_format( $summary_302,2)."";

$no_vat302 = ($summary_302 / 1.07); 
$no_vat302 = number_format( $no_vat302,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult301["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult301["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult301["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult303["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult302["count"];  ?>&nbsp;<?php echo $objResult303["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary302; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat302; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
$strSQL331 = "SELECT SUM(sum_amount)  as total33  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL3'";

if($start_date !=""){ 
    $strSQL331 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL331 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL331 .= ' AND company_type = "'.$company.'"'; 
}

$objQuery331 = mysqli_query($conn,$strSQL331) or die ("Error Query [".$strSQL331."]");
$objResult331 = mysqli_fetch_array($objQuery331);

$total332=$objResult331['total33'];
$total233= number_format( $total332,2)."";

$no_vat_to133 = ($total332 / 1.07); 
$no_vat_to33 = number_format( $no_vat_to133,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo 'SOL3' ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total233; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to33; ?></td> 

	</tr>
</table>

<?php

$creditno_vat33 =$no_vat40- $no_vat_to133;
$creditno_vat34 = number_format( $creditno_vat33,2)."";

$credit_total32 = $total46-$total332;
$credit_total33 = number_format( $credit_total32,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo 'SOL3' ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total33; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat34; ?></td> 

	</tr>
</table>


<?php } ?>





<?php if($emid =='SOL99'){ ?>

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
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>


<?php

	

$strSQL41 = "SELECT SUM(sum_amount)  as total41  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='' AND employee_name = 'SOL99' and cancel_ckk = '0'";

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


$strSQL42 = "SELECT SUM(sum_amount)  as total42  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' AND employee_name = 'SOL99' and cancel_ckk = '0'";

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
$total49 = $total41+$total42;

$total43= number_format( $total49,2)."";

$no_vat41 = ($total42 / 1.07); 
$no_vat42 = number_format( $no_vat41,2)."";




$strSQL43 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE doc_no !='' and employee_name = 'SOL99' and cancel_ckk = '0'";


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


$objQuery43 =mysqli_query($conn,$strSQL43);
while($objResult43=mysqli_fetch_array($objQuery43)){

$strSQL44 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult43["ref_id"]."'  ";

$objQuery44 =mysqli_query($conn,$strSQL44);
while($objResult44=mysqli_fetch_array($objQuery44)){



$strSQL45 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult44["product_id"]."'  ";

$objQuery45 =mysqli_query($conn,$strSQL45);
while($objResult45=mysqli_fetch_array($objQuery45)){

	
$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult43["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);

$summary_16=$objResult44['sum_amount'];
$summary44= number_format( $summary_16,2)."";

$no_vat16 = ($summary_16 / 1.07); 
$no_vat_44 = number_format( $no_vat16,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult43["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult43["doc_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult43["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult45["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult44["sale_count"];  ?>&nbsp;<?php echo $objResult45["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary44; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_44; ?></td> 

	</tr>




	<?php
}
}
}






$strSQL46 ="SELECT  iv_no,iv_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE iv_no !='' and employee_name = 'SOL99' and cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL46 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL46 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL46 .= ' AND select_type_doc = "'.$company1.'"'; 
}

$strSQL46 .=" order  by iv_no ASC  ";


$objQuery46 =mysqli_query($conn,$strSQL46);
while($objResult46=mysqli_fetch_array($objQuery46)){

$strSQL47 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult46["ref_id"]."'  ";

$objQuery47 =mysqli_query($conn,$strSQL47);
while($objResult47=mysqli_fetch_array($objQuery47)){



$strSQL48 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult47["product_id"]."'  ";

$objQuery48 =mysqli_query($conn,$strSQL48);
while($objResult48=mysqli_fetch_array($objQuery48)){

	
$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult46["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);

$summary_48=$objResult47['sum_amount'];
$summary48= number_format( $summary_48,2)."";

$no_vat48 = ($summary_48 / 1.07); 
$no_vat48 = number_format( $no_vat48,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult46["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult46["iv_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult46["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult48["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult47["sale_count"];  ?>&nbsp;<?php echo $objResult48["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary48; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat48; ?></td> 

	</tr>




	<?php
}
}
}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo "SOL99" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total43; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat42; ?></td> 

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
$strSQL101 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL99'";


if($start_date !=""){ 
    $strSQL101 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL101 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL101 .= ' AND company_type = "'.$company.'"'; 
}

$strSQL101 .=" order  by credit_no ASC  ";


$objQuery101 =mysqli_query($conn,$strSQL101);
while($objResult101=mysqli_fetch_array($objQuery101)){

$strSQL102 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult101["ref_credit"]."'  ";

$objQuery102 = mysqli_query($conn,$strSQL102);
while($objResult102 = mysqli_fetch_array($objQuery102)){



$strSQL103 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult102["product_id"]."'  ";

$objQuery103 = mysqli_query($conn,$strSQL103);
while($objResult103 = mysqli_fetch_array($objQuery103)){


$summary_102=$objResult102['sum_amount'];
$summary102= number_format( $summary_102,2)."";

$no_vat102 = ($summary_102 / 1.07); 
$no_vat102 = number_format( $no_vat102,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult101["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult101["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult101["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult103["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult102["count"];  ?>&nbsp;<?php echo $objResult103["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary102; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat102; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
$strSQL131 = "SELECT SUM(sum_amount)  as total13  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL99'";

if($start_date !=""){ 
    $strSQL131 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL131 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL131 .= ' AND company_type = "'.$company.'"'; 
}

$objQuery131 = mysqli_query($conn,$strSQL131) or die ("Error Query [".$strSQL131."]");
$objResult131 = mysqli_fetch_array($objQuery131);

$total302=$objResult131['total13'];
$total203= number_format( $total302,2)."";

$no_vat_to103 = ($total302 / 1.07); 
$no_vat_to03 = number_format( $no_vat_to103,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo 'SOL99' ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total203; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to03; ?></td> 

	</tr>
</table>

<?php

$creditno_vat03 =$no_vat41- $no_vat_to103;
$creditno_vat04 = number_format( $creditno_vat03,2)."";

$credit_total02 = $total49-$total302;
$credit_total03 = number_format( $credit_total02,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo 'SOL99' ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total03; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat04; ?></td> 

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
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>


<?php

	

$strSQL41 = "SELECT SUM(sum_amount)  as total41  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='' AND employee_name = 'SOL6' and cancel_ckk = '0'";

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


$strSQL42 = "SELECT SUM(sum_amount)  as total42  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' AND employee_name = 'SOL6' and cancel_ckk = '0'";

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
$total46 = $total41+$total42;

$total43= number_format( $total46,2)."";

$no_vat40 = ($total46 / 1.07); 
$no_vat42 = number_format( $no_vat40,2)."";




$strSQL43 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE doc_no !='' and employee_name = 'SOL6' and cancel_ckk = '0'";


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


$objQuery43 =mysqli_query($conn,$strSQL43);
while($objResult43=mysqli_fetch_array($objQuery43)){

$strSQL44 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult43["ref_id"]."'  ";

$objQuery44 =mysqli_query($conn,$strSQL44);
while($objResult44=mysqli_fetch_array($objQuery44)){



$strSQL45 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult44["product_id"]."'  ";

$objQuery45 =mysqli_query($conn,$strSQL45);
while($objResult45=mysqli_fetch_array($objQuery45)){

	
$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult43["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);
	
$summary_16=$objResult44['sum_amount'];
$summary44= number_format( $summary_16,2)."";

$no_vat16 = ($summary_16 / 1.07); 
$no_vat_44 = number_format( $no_vat16,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult43["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult43["doc_no"]; ?></td>
	
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult43["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult45["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult44["sale_count"];  ?>&nbsp;<?php echo $objResult45["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary44; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_44; ?></td> 

	</tr>




	<?php
}
}
}






$strSQL46 ="SELECT  iv_no,iv_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE iv_no !='' and employee_name = 'SOL6' and cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL46 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL46 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL46 .= ' AND select_type_doc = "'.$company1.'"'; 
}

$strSQL46 .=" order  by iv_no ASC  ";


$objQuery46 =mysqli_query($conn,$strSQL46);
while($objResult46=mysqli_fetch_array($objQuery46)){

$strSQL47 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult46["ref_id"]."'  ";

$objQuery47 =mysqli_query($conn,$strSQL47);
while($objResult47=mysqli_fetch_array($objQuery47)){



$strSQL48 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult47["product_id"]."'  ";

$objQuery48 =mysqli_query($conn,$strSQL48);
while($objResult48=mysqli_fetch_array($objQuery48)){

$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult46["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);
	
$summary_48=$objResult47['sum_amount'];
$summary48= number_format( $summary_48,2)."";

$no_vat48 = ($summary_48 / 1.07); 
$no_vat48 = number_format( $no_vat48,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult46["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult46["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult46["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult48["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult47["sale_count"];  ?>&nbsp;<?php echo $objResult48["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary48; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat48; ?></td> 

	</tr>




	<?php
}
}
}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo "SOL6" ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total43; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat42; ?></td> 

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
$strSQL301 ="SELECT credit_no,date_credit,customer_name,ref_credit FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL6'";


if($start_date !=""){ 
    $strSQL301 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL301 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL301 .= ' AND company_type = "'.$company.'"'; 
}

$strSQL301 .=" order  by credit_no ASC  ";


$objQuery301 =mysqli_query($conn,$strSQL301);
while($objResult301=mysqli_fetch_array($objQuery301)){

$strSQL302 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult301["ref_credit"]."'  ";

$objQuery302 = mysqli_query($conn,$strSQL302);
while($objResult302 = mysqli_fetch_array($objQuery302)){



$strSQL303 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult302["product_id"]."'  ";

$objQuery303 = mysqli_query($conn,$strSQL303);
while($objResult303 = mysqli_fetch_array($objQuery303)){


$summary_302=$objResult302['sum_amount'];
$summary302= number_format( $summary_302,2)."";

$no_vat302 = ($summary_302 / 1.07); 
$no_vat302 = number_format( $no_vat302,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult301["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult301["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult301["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult303["access_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult302["count"];  ?>&nbsp;<?php echo $objResult303["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary302; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat302; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
$strSQL331 = "SELECT SUM(sum_amount)  as total33  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = 'SOL6'";

if($start_date !=""){ 
    $strSQL331 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL331 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL331 .= ' AND company_type = "'.$company.'"'; 
}

$objQuery331 = mysqli_query($conn,$strSQL331) or die ("Error Query [".$strSQL331."]");
$objResult331 = mysqli_fetch_array($objQuery331);

$total332=$objResult331['total33'];
$total233= number_format( $total332,2)."";

$no_vat_to133 = ($total332 / 1.07); 
$no_vat_to33 = number_format( $no_vat_to133,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo 'SOL6' ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total233; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to33; ?></td> 

	</tr>
</table>

<?php

$creditno_vat33 =$no_vat40- $no_vat_to133;
$creditno_vat34 = number_format( $creditno_vat33,2)."";

$credit_total32 = $total46-$total332;
$credit_total33 = number_format( $credit_total32,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo 'SOL6' ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total33; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat34; ?></td> 

	</tr>
</table>


<?php //} ?>




</body>
</html>