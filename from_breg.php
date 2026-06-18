<style>
		body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 14pt "Angsana New";
    }
	table {
	  border-collapse: collapse;
	  font-size:14pt;
	}

	.tablep, .tr, .td {
	  border: 1px solid black;
	}
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        max-height: 297mm;
        padding: 10mm;
        margin: 0mm auto;
        /*border: 0px #D3D3D3 solid;
        border-radius: 0px;*/
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0);
    }
    
    @page {
        size: A4;
        margin: 0;
    }
	@page Section1 {size:841.7pt 595.45pt; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	div.Section1 {page:Section1;}
	@page Section2 {size:595.45pt 841.7pt;mso-page-orientation:landscape;margin:0.6in 0.6in 0.6in 0.6in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	div.Section2 {page:Section2;}

	@media screen {
	  div.divFooter {
		display: none;
	  }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
			 div.divFooter {
				position: fixed;
				bottom: 0;
			 }
        }
    }
	h1,h2,h3,h4,h5,h6 {
		font: 18pt "Angsana New";
	}
</style>
<?php
include "error_page.php";
include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";

function barcode($code){
    
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 1.0;//กำหนดความหน้าของเส้น Barcode
    $height = 20;//กำหนดความสูงของ Barcode
 
    return $generator->getBarcode($code , $generator::TYPE_CODE_128,$border,$height);
 }
date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
}
///
$ref_id = $_GET["ref_id"];
include"dbconnect.php";
$strSQL = "SELECT * FROM  hos__breg WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);


$month = date('m');
$day = date('d');
$year = date('Y');

$today1 = $year . '-' . $month . '-' . $day;
$today=DateThai($today1);

if($objResult["iv_date"]!='0000-00-00 00:00:00'){ $iv_date = DateThai($objResult["iv_date"]); }else{ $iv_date = '-'; }
if($objResult["add_date"]!='0000-00-00 00:00:00'){ $add_date = DateThai($objResult["add_date"]); }else{ $add_date = '-'; }
if($objResult["sup_date"]!='0000-00-00 00:00:00'){ $sup_date = DateThai($objResult["sup_date"]); }else{ $sup_date = '-'; }
if($objResult["dm_date"]!='0000-00-00 00:00:00'){ $dm_date = DateThai($objResult["dm_date"]); }else{ $dm_date = '-'; }
if($objResult["receive_date"]!='0000-00-00 00:00:00'){ $receive_date = DateThai($objResult["receive_date"]); }else{ $receive_date = '-'; }
if($objResult["st_date"]!='0000-00-00 00:00:00'){ $st_date = DateThai($objResult["st_date"]); }else{ $st_date = '-'; }
if($objResult["date_brdoc"]!='0000-00-00 00:00:00'){ $date_brdoc = DateThai($objResult["date_brdoc"]); }else{ $date_brdoc = '-'; }



?>
<body>
<div class="Section2 page">
<table style="width:100%;">
	<tr>
		<td style="width:25%;" valign="top">
			<div align="left"><?php echo 'เลขที่อ้างอิง'; echo ' : '; echo $ref_id;?></div>
		</td>
		<td style="width:50%;" valign="top">
			<center><h3><b>ใบขอเบิกอะไหล่จากสินค้าขาย<br>(Request For Part Withdrawal From Goods Sold)</b></h3></center>
		</td>
		<td style="width:25%;" valign="bottom">
			<div align="right">เลขที่ : <?php echo $objResult["iv_no"];?></div>
			<div align="right"><?php echo barcode($objResult["iv_no"]);?></div>
		</td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:70%;"><b>ชื่อผู้เบิก :</b> <?php echo $objResult["add_by"]; ?> </td>
		<td style="text-align:right;" style="width:30%;"><b>Date : </b><?php echo $iv_date; ?></td>
	</tr>
	</table>
<table style="width:100%;">
	<tr>
		
		<td style="width:100%;"><b>วัตถุประสงค์การเบิก : </b><?php echo $objResult["description"]; ?> </td>
		
	</tr>
	</table>
	<table style="width:100%;">
	<tr>
		<td><b>ชื่อลูกค้า : </b><?php echo $objResult["customer_name"]; ?> </td>
		<td><b>เลขที่ PER : </b><?php echo $objResult["per_no"]; ?> </td>
		<td style="text-align:right;"><b>เลขที่ใบงาน : </b><?php echo $objResult["cm_no"]; ?></td>
	</tr>	
	
</table><p>
<b>รายการอะไหล่ที่ต้องการเบิก :</b>
<table border= "1" width="100%">
<tr>

<th width="5%" align="center">ที่</th>
<th width="30%">รายการ</th>
<th width="8%" align="center">จำนวน</th> 
<th width="10%" align="center">หน่วย</th> 
<th width="10%" align="center">หมายเลขเครื่อง</th> 
<th width="30%" align="center">หมายเหตุ</th> 
</tr>
<?php
$strSQL1 = "SELECT * FROM (hos__subbreg1 LEFT JOIN tb_product ON hos__subbreg1.product_id1=tb_product.product_ID) WHERE ref_id1 = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1)) {
		
	?>
	<tr>
		
		<td align="center"><?php echo $i;?></td>
		<td align="left"><?php echo $objResult1["sol_name"];?> </td>
		<td align="right" style="padding-left:5px;"><?php echo $objResult1["count1"];?> </td>
		<td align="center" style="padding-right:5px;"><?php echo $objResult1["unit_name"];?></td>
		<td align="left" style="padding-right:5px;"><?php echo $objResult1["sn_number1"];?></td>
		<td align="left" style="padding-right:5px;"><?php echo $objResult1["remark_eng1"];?></td>
	<?php $i++;} ?>
	</tr>
	
</table>

	<p><b>เบิกอะไหล่จากสินค้า :</b>
	<table border= "1" width="100%">
<tr>

<th width="5%" align="center">ที่</th>
<th width="30%">ชื่อสินค้า</th>
<th width="10%" align="center">หมายเลขเครื่อง</th> 
<th width="8%" align="center">จำนวน</th> 
<th width="10%" align="center">หน่วย</th> 
<th width="30%" align="center">หมายเหตุ</th> 
<th width="10%" align="center">ประเภทสินค้า</th> 
</tr>
<?php
$strSQL2 = "SELECT * FROM (hos__subbreg2 LEFT JOIN tb_product ON hos__subbreg2.product_id2=tb_product.product_ID) WHERE ref_id2 = '".$ref_id."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$i=1;
while($objResult2 = mysqli_fetch_array($objQuery2)) {
		
	?>
	<tr>
		
		<td align="center"><?php echo $i;?></td>
		<td align="left"><?php echo $objResult2["sol_name"];?> </td>
		<td align="left" style="padding-right:5px;"><?php echo $objResult2["sn_number2"];?></td>
		<td align="right" style="padding-left:5px;"><?php echo $objResult2["count2"];?> </td>
		<td align="center" style="padding-right:5px;"><?php echo $objResult2["unit_name"];?></td>
		<td align="left" style="padding-right:5px;"><?php echo $objResult2["remark_eng2"];?></td>
		<td align="center" style="padding-right:5px;"><?php echo $objResult2["type_probd"];?></td>
	<?php $i++;} ?>
	</tr>
	
</table>
	

<br>
<table style="width:100%;" border="0">
	<tr>
		<td>ผู้เบิก : </td>
		<td>หัวหน้า : </td>
		<td>ผู้อนุมัติ : </td>
	</tr>	
	<tr>
		<td align="center">( <u> <?php echo $objResult["add_by"]; ?> </u> )<br>วันที่ <u> <?php echo $add_date; ?> </u></td>
		<td align="center">( <u> <?php echo $objResult["sup_name"]; ?> </u> )<br>วันที่ <u> <?php echo $sup_date; ?> </u></td>
		<td align="center">( <u> <?php echo $objResult["dm_name"]; ?> </u> )<br>วันที่ <u> <?php echo $dm_date; ?> </u></td>
	</tr>	
	</table><p>
	<table style="width:100%;" border="0">
	<tr>
		<td width="35%">ผู้รับสินค้า : </td>
		<td width="35%">คลังสินค้า : </td>
		<td width="35%"></td>
	</tr>	
	<tr>
		<td align="center">( <u> <?php echo $objResult["receive_pro"]; ?> </u> )<br>วันที่ <u> <?php echo $receive_date; ?> </u></td>
		<td align="center">( <u> <?php echo $objResult["st_name"]; ?> </u> )<br>วันที่ <u> <?php echo $st_date; ?> </u></td>
		<td>
		<?php if($objResult["send_erpst"]=='1'){  ?> <input type="radio" checked="checked" > <?php }else{ ?>  <input type="radio" > <?php } ?> ลงข้อมูลในระบบแล้ว <p>
		<?php if($objResult["print_brdoc"]=='1'){  ?> <input type="radio" checked="checked" > <?php }else{ ?>  <input type="radio" > <?php } ?> Print ใบบันทึก และติดแจ้งแล้ว <p>
		<?php if($objResult["type_brdoc"]=='1'){  ?> <input type="radio" checked="checked" > <?php }else{ ?>  <input type="radio" > <?php } ?> แยกหมวดสินค้าแล้ว <p>
		<?php if($objResult["brdoc_eng"]=='1'){  ?> <input type="radio" checked="checked" > <?php }else{ ?>  <input type="radio" > <?php } ?> ประกอบคืนสินค้าวันที่  <u> <?php echo $date_brdoc; ?> </u> <p>
		
		</td>
	</tr>
</table>
<br>
<table style="width:100%;">
	<tr>
		<td>อนุมัติวันที่ 18 ส.ค. 2563</td>
		<td style="text-align:right;"><?php echo "FM-OF-60:Rev.0"; ?></td>
	</tr>
</table>
</div>
</body>
</html>