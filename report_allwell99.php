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
$sale_code = $_GET["sale_code"]; 
$str_arr = $_GET["company"]; 

$company = substr($str_arr, 0,1);
$company1 = substr($str_arr,-1);
$emid = $_GET['code'];
$doc_no = 'BRNP';

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


<center>
<span class="style16"><?php echo $sale_code; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $sale_code ;  ?></span>
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

	

$strSQL8 = "SELECT SUM(sum_amount)  as total8  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  employee_name = '".$sale_code."' ";

if($start_date !=""){ 
    $strSQL8 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL8 .= ' AND register_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL8 .= ' AND select_type_doc = "'.$company.'"'; 
}

$strSQL8 .= ' AND doc_no NOT LIKE "%'.$doc_no.'%"'; 

$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total9  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  employee_name = '".$sale_code."' ";

if($start_date !=""){ 
    $strSQL9 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL9 .= ' AND register_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL9 .= ' AND select_type_doc = "'.$company1.'"'; 
}
	
	$strSQL9 .= ' AND doc_no NOT LIKE "%'.$doc_no.'%"'; 


$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$total8=$objResult8['total8'];
$total9=$objResult9['total9'];
$total10 = $total8+$total9;
$no_vat1 = ($total10 / 1.07); 
$tot= number_format( $total10,2)."";
$no_vat = number_format( $no_vat1,2)."";




$strSQL10 ="SELECT  doc_no,register_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE  employee_name = '".$sale_code."' ";


if($start_date !=""){ 
    $strSQL10 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL10 .= ' AND register_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL10 .= ' AND select_type_doc = "'.$company.'"'; 
}
$strSQL10 .= ' AND doc_no NOT LIKE "%'.$doc_no.'%"'; 

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
<td  align="center" class="style30"><?php echo  DateThai($objResult10["register_date"]); ?></td>
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






$strSQL26 ="SELECT  doc_no,register_date,customer_name,ref_id,tel,sale_channel FROM so__main WHERE  employee_name = '".$sale_code."' ";


if($start_date !=""){ 
    $strSQL26 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL26 .= ' AND register_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL26 .= ' AND select_type_doc = "'.$company1.'"'; 
}

$strSQL26 .= ' AND doc_no NOT LIKE "%'.$doc_no.'%"'; 
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
	
$summary_28=$objResult27['sum_amount'];
$summary28= number_format( $summary_28,2)."";

$no_vat28 = ($summary_28 / 1.07); 
$no_vat28 = number_format( $no_vat28,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult26["register_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult26["doc_no"]; ?></td>
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
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_code; ?></td>
<td width="10%" align="right" class="style16"><?php echo $tot; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat; ?></td> 

	</tr>
</table>







</body>
</html>