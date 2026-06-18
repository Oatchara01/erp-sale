<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 16px; color: #000000;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 10.5px; color: #000000; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {font-size: 14px; color: #FF0000; }
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


$id_work=$_GET["id_work"];

include"dbconnect_sale.php";

$strSQL1 = "UPDATE tb_register_data SET ckk_st='1' WHERE id_work = '".$id_work."'";
$objQuery1 = mysqli_query($com,$strSQL1) or die(mysqli_error($strSQL1));



$strSQL = "SELECT * FROM tb_register_data WHERE id_work = '".$id_work."' ";

$objQuery = mysqli_query($com,$strSQL)or die ("Error Query [".$strSQL."]");;
$objResult = mysqli_fetch_array($objQuery);




 $date_plan = $objResult['date_plan'];
$date_plan1 = explode('-' , $objResult["date_plan"] );
$date_plan_new = $date_plan1[2].'-'.$date_plan1[1].'-'.$date_plan1[0];

 $hospital_name = $objResult['hospital_name'];
 $hospital_ward = $objResult['hospital_ward'];
 $sale_name  = $objResult['sale_name'];


$summary_product1=$objResult['summary_product1'];
$summary_product2=$objResult['summary_product2'];
$summary_product3=$objResult['summary_product3'];
$summary_product4=$objResult['summary_product4'];
$summary_product5=$objResult['summary_product5'];

if ($objResult['unit_product1']=='0'){
	$unit_product1='';
}else{
$unit_product1=$objResult['unit_product1'];
}

if ($objResult['unit_product2']=='0'){
	$unit_product2='';
}else{
$unit_product2=$objResult['unit_product2'];
}

if ($objResult['unit_product3']=='0'){
	$unit_product3='';
}else{
$unit_product3=$objResult['unit_product3'];
}
	
if ($objResult['unit_product4']=='0'){
	$unit_product4='';
}else{
$unit_product4=$objResult['unit_product4'];
}

if ($objResult['unit_product5']=='0'){
	$unit_product5='';
}else{
$unit_product5=$objResult['unit_product5'];
}


$product_code1=$objResult['product_code1'];
$product_code2=$objResult['product_code2'];
$product_code3=$objResult['product_code3'];
$product_code4=$objResult['product_code4'];
$product_code5=$objResult['product_code5'];

$unit_name1=$objResult['unit_name1'];
$unit_name2=$objResult['unit_name2'];
$unit_name3=$objResult['unit_name3'];
$unit_name4=$objResult['unit_name4'];
$unit_name5=$objResult['unit_name5'];
$bq_number=$objResult['bq_number'];
$date_request=$objResult['date_request'];
$date_request1 = explode('-' , $objResult["date_request"] );
$date_request_new = $date_request1[2].'-'.$date_request1[1].'-'.$date_request1[0];


$description_order=$objResult['description_order'];
$date_order=$objResult['date_order'];

$newadd_date = date("d-m-Y H:i:s");

?>

<center>
	
<span class="style15">ใบจองสินค้า</span><br>

<span class="style15">(Product Booking)</span>
</center>


<fieldset><legend><b>ข้อมูลการจอง</b></legend></br>
วันที่แจ้ง : &nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<?php echo $date_plan_new; ?>&nbsp;&nbsp;&nbsp;</u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ชื่อลูกค้า : &nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<?php echo $hospital_name; ?>&nbsp;&nbsp;&nbsp;</u></p>

สถานที่ส่ง : &nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<?php echo $hospital_name; ?>&nbsp;&nbsp;&nbsp;</u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; วันที่ต้องการรับสินค้า : &nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<?php echo $date_request_new; ?>&nbsp;&nbsp;&nbsp;</u></p>

ชื่อพนักงาน : &nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<?php echo $sale_name; ?>&nbsp;&nbsp;&nbsp;</u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เลขที่ BQ : &nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<?php echo $bq_number; ?>&nbsp;&nbsp;&nbsp;</u></p>

ผู้จองสินค้า : &nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<?php echo $sale_name; ?>&nbsp;&nbsp;&nbsp;</u> </p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></p>

</fieldset>
<fieldset>

ผู้อนุมัติ : &nbsp; <input type='checkbox'>&nbsp;อนุมัติ &nbsp;&nbsp; <input type='checkbox'>&nbsp;ไม่อนุมัติ
	</p>
&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<?php echo $sale_name; ?>&nbsp;&nbsp;&nbsp;</u> </p>
&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<?php echo $date_plan_new; ?>&nbsp;&nbsp;&nbsp;</u> 
	
</fieldset>

<table border= "1" width="100%" >
<tr>
<td width="10%" align="center" class="style30">รหัสสินค้า</td>
<td width="20%" align="center" class="style30">รายการ</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">หน่วย</td> 
</tr>
<tr>
<td width="10%" align="center" class="style30">.<?php echo $product_code1; ?></td>
<td width="20%" align="center" class="style30"><?php echo $summary_product1; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $unit_product1; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $unit_name1; ?></td> 
</tr>
	
	<tr>
<td width="10%" align="center" class="style30">.<?php echo $product_code2; ?></td>
<td width="20%" align="center" class="style30"><?php echo $summary_product2; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $unit_product2; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $unit_name2; ?></td> 
</tr>
	
	<tr>
<td width="10%" align="center" class="style30">.<?php echo $product_code3; ?></td>
<td width="20%" align="center" class="style30"><?php echo $summary_product3; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $unit_product3; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $unit_name3; ?></td> 
</tr>
	
	<tr>
<td width="10%" align="center" class="style30">.<?php echo $product_code4; ?></td>
<td width="20%" align="center" class="style30"><?php echo $summary_product4; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $unit_product4; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $unit_name4; ?></td> 
</tr>
	
	<tr>
<td width="10%" align="center" class="style30">.<?php echo $product_code5; ?></td>
<td width="20%" align="center" class="style30"><?php echo $summary_product5; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $unit_product5; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $unit_name5; ?></td> 
</tr>
	
	<tr>
<td width="10%" align="center" class="style30">.</td>
<td width="20%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
</tr>
		<tr>
<td width="10%" align="center" class="style30">.</td>
<td width="20%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
</tr>
		<tr>
<td width="10%" align="center" class="style30">.</td>
<td width="20%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
</tr>
		<tr>
<td width="10%" align="center" class="style30">.</td>
<td width="20%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
</tr>
		<tr>
<td width="10%" align="center" class="style30">.</td>
<td width="20%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
</tr>
	
</table>

<fieldset>

หมายเหตุ : &nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<?php echo $description_order; ?>&nbsp;&nbsp;&nbsp;</u>
	
</fieldset>

<fieldset>

คลังสินค้า : &nbsp;&nbsp;&nbsp; JG &nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>/<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
	&nbsp;&nbsp; <input type='checkbox'>&nbsp;ลงทะเบียน &nbsp;&nbsp; <input type='checkbox'>&nbsp;ยกเลิก
	หมายเหตุ : &nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
</fieldset>

