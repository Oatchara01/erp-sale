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
	.tablel {
	  border-collapse: collapse;
	  font-size:10pt;
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
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
$iv_no=$_GET["iv_no"];
include "dbconnect.php";
include "dbconnect_acc.php";


$strSQL = "SELECT sale_channel,iv_no,iv_date,employee_name  FROM so__main WHERE iv_no = '".$iv_no."' ";

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$iv_date = datethai($objResult["iv_date"]);
$iv_no = $objResult["iv_no"];
$sale_channel = $objResult["sale_channel"]; 
$employee_name = $objResult["employee_name"];  

if($sale_channel=='1'){
$prefor_name = "LAZADA";
$bill_id ='1398';
	
}else if($sale_channel=='12'){
$prefor_name = "SHOPEE";
$bill_id ='24995';
	
}else if($sale_channel=='34'){
$prefor_name = "TIKTOK";
$bill_id ='106403';
	
}else if($sale_channel=='25'){
$prefor_name = "Central Online";
$bill_id ='63624';	
}	

$strSQL1 = "SELECT customer_code,customer_coden,preface_name,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id FROM tb_customer WHERE customer_id = '".$bill_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$bill_name = $objResult1["bill_name"];
$bill_address = $objResult1["bill_address"];
$bill_ampher = $objResult1["bill_ampher"];
$billl_province = $objResult1["billl_province"];
$bill_postcode = $objResult1["bill_postcode"];
$bill_tel = $objResult1["bill_tel"];
$tax_id = $objResult1["tax_id"];

?><!-- ------------------End PHP Query------------------ -->
<div class="Section2 page">
<body>
<table style="width:100%;">
	<tr>
		<td style="width:15%;"><input type="checkbox"> ก <input type="checkbox"> C</td>
		<td style="width:35%;"></td>
		<td style="width:10%;"></td>
		<td align="right" style="width:40%;"><font size="5"></font></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:30%;text-align:left;"><font color='red'></font></td>
		<td style="width:40%;text-align:center;"><font size="5">ใบสั่งขาย&nbsp;&nbsp;&nbsp;</font><br><font size="4">(SALE ORDER)</font></td>
		<td style="width:30%;text-align:right;"><span align="right"><div align="right"><?php echo $iv_no;?></div><div align="right"><?php echo barcode($iv_no);?></div></span></td>
	</tr>
</table>

<table style="width:100%;">
	<tr>
		<td style="width:20%;"><span>ชื่อผู้แนะนำ/รพ./แผนก </span></td>
		<td style="width:50%;border-bottom:1px solid black"><span><?php echo $prefor_name; ?></span></td>
		<td style="width:10%;text-align:left;padding-left:15px;"><span>วันที่ </span>
		<td style="width:20%;border-bottom:1px solid black"><span><?php echo $iv_date; ?></span></td>
	</tr>
	<tr>
		<td><span>ชื่อที่ต้องการออกบิล </span></td>
		<td style="border-bottom:1px solid black"><span><?php echo $bill_name; ?></span></td>
		<td style="width:10%;text-align:left;padding-left:15px;"><span>เบอร์โทร </span>
		<td style="width:20%;border-bottom:1px solid black"><span><?php echo $bill_tel; ?></span></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:20%;"><span>ที่อยูที่ต้องการออกบิล </span></td>
		<td style="border-bottom:1px solid black"><span><?php echo $bill_address; echo " ";  echo $bill_ampher;  echo " ";  echo $billl_province;  echo " ";  echo $bill_postcode;  echo " ";  echo "เลขประจำตัวผู้เสียภาษี";  echo $tax_id ;?></span></td>
	</tr>
	<tr>
		
	</tr>
	<tr>
		<td style="width:20%;"><span>สถานที่ส่งสินค้า </span></td>
		<td style="border-bottom:1px solid black"><span><?php echo $delivery_place; ?></span></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:20%;"><span>ชื่อผู้ติดต่อ/โทร</span></td>
		<td style="width:30%;border-bottom:1px solid black"><span></span></td>
		<td style="width:20%;text-align:center;"><span>ชำระโดย</span></td>
		<td style="width:30%;border-bottom:1px solid black"></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:20%;"><span>ใบสั่งซื้อเลขที่</span></td>
		<td style="width:30%;border-bottom:1px solid black"><span></span></td>
		<td style="width:20%;text-align:center;"><span>กำหนดส่งตามสัญญา</span></td>
		<td style="width:30%;border-bottom:1px solid black"><span></span></td>
	</tr>
</table>
<br />
<table border= "1" width="100%">
<tr>

<td width="5%" align="center" >ลำดับ</td>
<td width="15%" align="center" >รหัสสินค้า</td>
<td width="50" align="center" >ชื่อสินค้า</td> 
<td width="10%" align="center" >จำนวน</td> 
<td width="10%" align="center" >หน่วย</td> 
<td width="10%" align="center" >ราคาต่อหน่วย</td> 
<td width="10%" align="center" >ยอดรวม</td> 
</tr>
<?php
$strSQL42 = "SELECT DISTINCT 
                s.product_code, 
                s.price_per_unit
            FROM so__main m
            LEFT JOIN so__submain s ON m.ref_id = s.ref_idd
            LEFT JOIN tb_product p ON p.product_id = s.product_id
            WHERE m.cancel_ckk = '0'
              AND m.approve_complete = 'Approve'";

if($iv_no != ''){
    $strSQL42 .= " AND m.iv_no = '".$iv_no."' ";
}

$strSQL42 .= " ORDER BY p.express_code ASC, s.price_per_unit DESC ";

$objQuery42 = mysqli_query($conn,$strSQL42) or die ("Error Query [".$strSQL42."]");

$i = 1;
$summary = 0.00;

while($objResult42 = mysqli_fetch_array($objQuery42))
{
    // สรุปยอด/จำนวน ตามสินค้า + ราคาต่อหน่วย
    $strSQL9 = "SELECT 
                    SUM(so__submain.discount_unit) AS discount_unit,
                    SUM(so__submain.sum_amount) AS sum_amount,
                    SUM(so__submain.sale_count) AS sale_count
                FROM so__main 
                LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd
                WHERE so__main.cancel_ckk='0' 
                  AND so__main.approve_complete='Approve'
                  AND so__submain.product_id ='".$objResult42["product_code"]."'
                  AND so__submain.price_per_unit = '".$objResult42["price_per_unit"]."' ";

    if($iv_no != ''){
        $strSQL9 .= ' AND so__main.iv_no = "'.$iv_no.'" ';
    }

    $objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
    $objResult9 = mysqli_fetch_array($objQuery9);

    // ดึงข้อมูลชื่อสินค้า/หน่วย
    $strSQL2 = "SELECT express_code, sol_name, unit_name 
                FROM tb_product 
                WHERE product_ID = '".$objResult42["product_code"]."' ";
    $objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
    $objResult2 = mysqli_fetch_array($objQuery2);

    $sale_count = (float)($objResult9["sale_count"] ?? 0);
    $sum_amount = (float)($objResult9["sum_amount"] ?? 0);
    $price_per_unit = (float)($objResult42["price_per_unit"] ?? 0);

    $summary += $sum_amount;
?>
<tr>
    <td align="center"><?php echo $i; ?></td>
    <td align="center"><?php echo $objResult2["express_code"]; ?></td>
    <td style="text-align:left;padding-left:3px;"><?php echo $objResult2["sol_name"]; ?></td>
    <td style="text-align:right;padding-right:3px;"><?php echo number_format($sale_count,0); ?></td>
    <td style="text-align:right;padding-right:3px;"><?php echo $objResult2["unit_name"]; ?></td>
    <td style="text-align:right;padding-right:3px;"><?php echo number_format($price_per_unit,2); ?></td>
    <td style="text-align:right;padding-right:3px;"><?php echo number_format($sum_amount,2); ?></td>
</tr>
<?php
    $i++;
}
?>

</table>

<table border="1" style="width:100%;border-top:0px;border-bottom:0px;">
<tr>
<td style="border-right:1px solid black;">
<?php
	?>
<input type="checkbox"><span>ต้องการใบกำกับภาษีเต็มรูปแบบ</span>

</td>
<td style="text-align:right;padding-right:3px;width:19.9%;">Total : <?php echo number_format($summary,2); ?></td>

</tr>

</table>

<table border="1" width="100%" class='w3-table'>
<tr>

</tr>
</table>
<table border="1" width="100%" class='w3-table'>
<tr>
<td width="50%" valign="top">
<input type="checkbox"><span>แนบใบเสนอราคา</span>

<br>

<input type="checkbox"><span>Clear ใบจองสินค้าเลขที่</span>

<span style="text-decoration:underline;"></span><br>
<span class="style40" >ไม่ต้องส่งสินค้า</span><br>
<input type="checkbox"><span >Clear ใบยืมสินค้าติดเล่ม BRN</span>

<span style="text-decoration:underline;"></span>
<br>
<input type="checkbox"><span>clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span>

<span style="text-decoration:underline;"></span>
</td>
<td><!-- -->
<table style="width:100%;">
	<tr>
		<td style="width:40%;"><input type="checkbox"><span>บริษัทจัดส่ง</span></td>
		<td><input type="checkbox"><span>ส่งสินค้าแผนกช่าง</span></td>
	</tr>
	<tr>
		<td><input type="checkbox"><span>Sales รับเอง</span></td>
		<td><input type="checkbox"><span>ลูกค้ารับเอง</span></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td>วันที่</td>
		<td><u></u></td>
		<td>เวลา</td>
		<td><u></u>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:40%;"><input type="checkbox"><span>ต้องการรถใหญ่</span></td>
		<td><input type="checkbox"><span>มีแผนที่ประกอบ</span></td>
	</tr>
	<tr>
		<td><input type="checkbox"><span>แจ้งลูกค้าก่อนส่ง</span></td>
		<td><input type="checkbox"><span>นัดวันและเวลาเรียบร้อยแล้ว</span></td>
	</tr>
</table>
</td>
</tr>
<tr>
<td width="50%" valign="top">
<input type="checkbox"><span>พิมพ์ตาม Computer</span><br>
<input type="checkbox"><span>พิมพ์ตามใบสั่งซื้อ</span><br>
<input type="checkbox"><span>พิมพ์ตามที่เขียน</span><br>
<u><span></span></u>
</td>
<td>
<table style="width:100%;">
	<tr>
		<td>Sales Comment</td>
	</tr>
	<tr>
		<td>สถานที่ติดตั้งเครื่อง<br><span><u></u></span></td>
	</tr>
</table>
</td>
</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:33%;text-align:center;"><span><?php echo $employee_name; echo "/"; echo $iv_date;?></span></td>
		<td style="width:33%;text-align:center;"><?php echo $iv_no ; ?></td>
		
	</tr>
	<tr>
		<td style="width:33%;text-align:center;"><span>Sales Signature/Area/Date</span></td>
		<td style="width:33%;text-align:center;"><?php echo $iv_date ; ?></td>
		<td style="width:33%;text-align:center;"><span>Authorized Signature/Date</span></td>
	</tr>
</table>
	</p>
	

<table style="width:100%;" class="tablel">
	<tr>
		<td><span>อนุมัติวันที่ 8 พฤษภาคม 2563 </span></td>
		<td style="text-align:right;"><span>FM-SA-04:Rev.10</span></td>
	</tr>
</table>
</body>
</div>
</html>