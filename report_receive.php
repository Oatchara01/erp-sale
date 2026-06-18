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
$ref_id = $_GET["ref_id"];
$stock = $_GET["stock"];

include"dbconnect.php";
/*$strSQL1 = "Update  hos__receive set report_ckk = '1',stock_print = '".$stock."' WHERE ref_id = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());*/

$strSQL = "SELECT * FROM  hos__receive WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);


$month = date('m');
$day = date('d');
$year = date('Y');

$today1 = $year . '-' . $month . '-' . $day;
$today=DateThai($today1);

$ref_id = $objResult["ref_id"];
$date_receive = DateThai($objResult["date_receive"]);

$iv_no = $objResult["iv_no"];
$sale_code = $objResult["sale_code"];
$sale_name = $objResult["sale_name"];
$receive_ckk = $objResult["receive_ckk"];
$receive_name = $objResult["receive_name"];
$customer_name = $objResult["customer_name"];
$remark_st = $objResult["remark_st"];

?>
<body>
<div class="Section2 page">
<table style="width:100%;">
	<tr>
		<td style="width:25%;" valign="top">
			<input type="checkbox"> ก <input type="checkbox"> C
			

		</td>
		<td style="width:30%;" valign="top">
			<h3><b>บันทึกรับคืนสินค้า<br>(Product Return)</b></h3>
		</td>
		
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td>ชื่อพนักงาน : <?php echo $sale_name; ?> </td>
		<td style="text-align:right;">วันที่ : <?php echo $date_receive; ?></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>		<td><?php if($receive_ckk=='1'){ ?><input type="checkbox" checked='checked' > คืนสินค้าด้วยตัวเอง <input type="checkbox" > ฝากบุคลอื่นคืน <?php }

				else if($receive_ckk=='2'){ ?><input type="checkbox"  > คืนสินค้าด้วยตัวเอง <input type="checkbox" checked='checked'> ฝากบุคลอื่นคืน <?php }
				else{ ?><input type="checkbox"  > คืนสินค้าด้วยตัวเอง <input type="checkbox" > ฝากบุคลอื่นคืน <?php } ?>
				คุณ : <?php echo $receive_name; ?></td>
	</tr>
</table>
<table border= "1" width="100%">
<tr>
<th width="5%" align="center">ITEM</th>
<th width="20%">รายการ</td>
<th width="10%" align="center">จำนวน</th> 
<th width="10%" align="center">หน่วย</th> 
<th width="20%" align="center">หมายเลขเครื่อง</th> 
<th width="20%" align="center">โรงพยาบาล</th> 
<th width="10%" align="center">เลขที่เอกสาร</th> 

</tr>
<?php
$strSQL1 = "SELECT * FROM (hos__subreceive LEFT JOIN tb_product ON hos__subreceive.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1)) {
	
	$product_name  =$objResult1["sol_name"];
	$sn  =$objResult1["sn"];
	$sale_count  =$objResult1["count"];
	$unit_name  =$objResult1["unit_name"]; ?>
	<tr>
		<td align="center"><?php echo $i;?></td>
		<td align="left" style="padding-left:5px;"><?php echo $product_name;?></td>
		<td align="right" style="padding-right:5px;"><?php echo $sale_count;?></td>
		<td align="center" style="padding-right:5px;"><?php echo $unit_name;?></td>
		<td align="left" style="padding-right:5px;"><?php echo $sn;?></td>
		<td align="left" style="padding-right:5px;"><?php echo $customer_name;?></td>
		<td align="left" style="padding-right:5px;"><?php echo $iv_no;?></td>

	<?php $i++;} ?>
	</tr>
	<?php if($Num_Rows1 < 8) {
		for($y=$Num_Rows1+1;$y<=8;$y++) { ?>
			<tr>
				<td align="center"><?php echo $y; ?></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"></td>
			</tr>
		<?php }
	}?>
</table>
<table border= "1" width="100%" style="border-top:0px;">
	<tr>
		<td style="width:50%;text-align:right;border-right:0px;">รวม</td>
		<td style="width:50%;text-align:right;border-left:0px;padding-right:5px;"><?php echo '';?></td> 
	</tr>
</table>


<table style="width:100%;" border="0">
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="height:50px;padding-left:5px;">หมายเหตุ : <?php echo $remark_st; ?></td>
	</tr>
</table>


<table style="width:100%;" border="1">
	<tr style="border-bottom:0px;">
		<td style="width:50%;text-align:center;border-right:0px;">ผู้จ่ายสินค้า<u><?php echo '__________________________';  ?></u></td>
				<td style="width:50%;text-align:center;border-right:0px;">วันที่รับคืน<u><?php echo '__________________________';  ?></u></td>

	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td>อนุมัติวันที่ 16 ม.ค. 2561</td>
		<td style="text-align:right;"><?php  echo "FM SA 15:Rev.2"; ?></td>
	</tr>
</table>

</div>
</body>
</html>