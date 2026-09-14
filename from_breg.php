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
include "dbconnect.php";
include_once "report_breg_preview_helper.php";

/* โหมด Preview: render จากค่าที่ POST มาจากฟอร์ม register_bregawl.php โดยไม่แตะฐานข้อมูล
   โหมดปกติ (GET ?ref_id=...): โหลดเอกสารที่บันทึกแล้วเหมือนเดิม */
$bregIsPreview = breg_report_is_preview_request();

if ($bregIsPreview) {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	try {
		$bregPreview = breg_report_build_preview_context($conn);
	} catch (BregValidationException $e) {
		http_response_code(422);
		echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
		exit();
	}
	$objResult = $bregPreview['header'];
	$ref_id = $objResult['ref_id'];
	$bregItems1 = $bregPreview['items1'];
	$bregItems2 = $bregPreview['items2'];
} else {
	$ref_id = isset($_GET["ref_id"]) ? trim((string)$_GET["ref_id"]) : '';
	$strSQL = "SELECT * FROM  hos__breg WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "' ";
	$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
	$objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);

	// ต้องมีหัวเอกสารจริงก่อนจึงจะอ่าน offset ต่าง ๆ ได้ — ไม่ปล่อยให้ตกไปพิมพ์ใบเปล่า
	if (!$objResult) {
		echo '<div style="font:14pt \'Angsana New\';padding:24px;">ไม่พบเอกสารเลขที่ '
			. htmlspecialchars($ref_id, ENT_QUOTES, 'UTF-8') . '</div>';
		exit();
	}

	$bregItems1 = array();
	$strSQL1 = "SELECT sub.count1 AS count, sub.sn_number1 AS sn_number, sub.remark_eng1 AS remark_eng,
					p.sol_name, p.unit_name
				FROM hos__subbreg1 sub LEFT JOIN tb_product p ON sub.product_id1 = p.product_ID
				WHERE sub.ref_id1 = '" . mysqli_real_escape_string($conn, $ref_id) . "'
				ORDER BY " . (breg_report_items_order($conn, 'hos__subbreg1', 'id_sub1'));
	$objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [" . $strSQL1 . "]");
	while ($row = mysqli_fetch_assoc($objQuery1)) {
		$row['type_probd'] = '';
		$bregItems1[] = $row;
	}

	$bregItems2 = array();
	$strSQL2 = "SELECT sub.count2 AS count, sub.sn_number2 AS sn_number, sub.remark_eng2 AS remark_eng,
					sub.type_probd, p.sol_name, p.unit_name
				FROM hos__subbreg2 sub LEFT JOIN tb_product p ON sub.product_id2 = p.product_ID
				WHERE sub.ref_id2 = '" . mysqli_real_escape_string($conn, $ref_id) . "'
				ORDER BY " . (breg_report_items_order($conn, 'hos__subbreg2', 'id_sub2'));
	$objQuery2 = mysqli_query($conn, $strSQL2) or die("Error Query [" . $strSQL2 . "]");
	while ($row = mysqli_fetch_assoc($objQuery2)) {
		$bregItems2[] = $row;
	}
}


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
			<div>บริษัท : <?php echo (int)($objResult['type_doc'] ?? 1) === 2 ? 'NBM' : 'AWL'; ?></div>
		</td>
		<td style="width:50%;" valign="top">
			<center><h3><b>ใบขอเบิกอะไหล่จากสินค้าขาย<br>(Request For Part Withdrawal From Goods Sold)</b></h3></center>
		</td>
		<td style="width:25%;" valign="bottom">
			<div align="right">เลขที่ : <?php echo htmlspecialchars((string)$objResult["iv_no"], ENT_QUOTES, 'UTF-8');?></div>
			<?php /* เอกสารที่ยังไม่ได้ run เลข (รวมถึงโหมด Preview) ไม่มี iv_no —
			         BarcodeGenerator โยน exception ถ้าส่ง string ว่างเข้าไป */ ?>
			<div align="right"><?php echo (trim((string)$objResult["iv_no"]) !== '') ? barcode($objResult["iv_no"]) : '';?></div>
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
/* $bregItems1 เตรียมไว้ด้านบนแล้ว — โหมดปกติมาจาก DB (เรียงตาม sort_order เมื่อมีคอลัมน์)
   โหมด Preview มาจากค่าที่ POST มา คีย์เหมือนกันทั้งสองโหมด */
$i = 1;
foreach ($bregItems1 as $objResult1) {
	?>
	<tr>

		<td align="center"><?php echo $i;?></td>
		<td align="left"><?php echo htmlspecialchars((string)$objResult1["sol_name"], ENT_QUOTES, 'UTF-8');?> </td>
		<td align="right" style="padding-left:5px;"><?php echo htmlspecialchars((string)$objResult1["count"], ENT_QUOTES, 'UTF-8');?> </td>
		<td align="center" style="padding-right:5px;"><?php echo htmlspecialchars((string)$objResult1["unit_name"], ENT_QUOTES, 'UTF-8');?></td>
		<td align="left" style="padding-right:5px;"><?php echo nl2br(htmlspecialchars((string)$objResult1["sn_number"], ENT_QUOTES, 'UTF-8'));?></td>
		<td align="left" style="padding-right:5px;"><?php echo nl2br(htmlspecialchars((string)$objResult1["remark_eng"], ENT_QUOTES, 'UTF-8'));?></td>
	</tr>
<?php $i++; } ?>

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
$i = 1;
foreach ($bregItems2 as $objResult2) {
	?>
	<tr>

		<td align="center"><?php echo $i;?></td>
		<td align="left"><?php echo htmlspecialchars((string)$objResult2["sol_name"], ENT_QUOTES, 'UTF-8');?> </td>
		<td align="left" style="padding-right:5px;"><?php echo nl2br(htmlspecialchars((string)$objResult2["sn_number"], ENT_QUOTES, 'UTF-8'));?></td>
		<td align="right" style="padding-left:5px;"><?php echo htmlspecialchars((string)$objResult2["count"], ENT_QUOTES, 'UTF-8');?> </td>
		<td align="center" style="padding-right:5px;"><?php echo htmlspecialchars((string)$objResult2["unit_name"], ENT_QUOTES, 'UTF-8');?></td>
		<td align="left" style="padding-right:5px;"><?php echo nl2br(htmlspecialchars((string)$objResult2["remark_eng"], ENT_QUOTES, 'UTF-8'));?></td>
		<td align="center" style="padding-right:5px;"><?php echo htmlspecialchars((string)$objResult2["type_probd"], ENT_QUOTES, 'UTF-8');?></td>
	</tr>
<?php $i++; } ?>

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
