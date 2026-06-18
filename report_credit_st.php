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
$ref_credit=$_GET["ref_credit"];
include"dbconnect.php";
$strSQL25="Update  tb_credit_note set print_adm = '1'  where ref_credit ='".$ref_credit."'";
$objQuery25 = mysqli_query($conn,$strSQL25);
$strSQL = "SELECT * from tb_credit_note WHERE ref_credit = '".$ref_credit."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
$strSQL1 = "SELECT * FROM tb_subcredit WHERE ref_creditt = '".$ref_credit."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

/*$strSQL3 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_id."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);*/

$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM tb_subcredit WHERE ref_creditt = '".$ref_credit."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";

$strSQL16 = "SELECT SUM(sum_discount) AS discount_unit FROM tb_subcredit WHERE ref_creditt = '".$ref_credit."' ";
$objQuery16 = mysqli_query($conn,$strSQL16);
$objResult16= mysqli_fetch_array($objQuery16);

$discount_unit1=$objResult16['discount_unit'];
$discount_unit= number_format( $discount_unit1,2)."";

$id = $objResult['id'];
$ref_credit = $objResult['ref_credit'];
$date_credit = DateThai($objResult['date_credit']);
$customer_name = $objResult['customer_name'];
$address_name = $objResult['address_name'];
$customer_tel = $objResult['customer_tel'];
$iv_no_ref = $objResult['iv_no_ref'];
$ttype_doc = $objResult['ttype_doc'];
$return_des = $objResult['return_des'];
$send_return_name = $objResult['send_return_name'];
$date_send_return = DateThai($objResult['date_send_return']);
$receive_name = $objResult['receive_name'];
$date_receive = DateThai($objResult['date_receive']);
$sale_name = $objResult['sale_name'];
$sale_date = DateThai($objResult['sale_date']);
$stock_complete = $objResult['stock_complete'];
$stock_name = $objResult['stock_name'];
$stock_date = DateThai($objResult['stock_date']);
$warraty_ckk = $objResult['warraty_ckk'];
$credit_ckk = $objResult['credit_ckk'];
$credit_no = $objResult['credit_no'];
$type_return_ckk = $objResult['type_return_ckk'];
$type_return_no = $objResult['type_return_no'];
$dis_credit = $objResult['dis_credit'];
$stock_des = $objResult['stock_des'];
?>
<body>
<div class="Section2 page">
<table style="width:100%;">
	<tr>
		<td valign="top" style="width:20%;"><input type="checkbox"> ก <input type="checkbox"> C</td>
		<td style="text-align:center;width:60%;"><h4>ใบสั่งลดหนี้<br>(Credit Note Order)</td>
		<td valign="bottom" style="text-align:right;width:20%;">Date : <?php echo $date_credit; ?></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:15%;">ชื่อลูกค้า : </td>
		<td style="width:85%;border-bottom:1px solid black;"><?php echo $customer_name; ?></td>
	</tr>
	<tr>
		<td>ที่อยู่ : </td>
		<td style="width:85%;border-bottom:1px solid black;"><?php echo $address_name; ?></td>
	</tr>
	<tr>
		<td>เบอร์โทร : </td>
		<td style="width:85%;border-bottom:1px solid black;"><?php echo $customer_tel; ?></td>
	</tr>
</table>
<br />
<table border= "0" width="100%">
	<tr style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;">
		<td style="width:30%;border-right:0px;">อ้างอิงใบส่งสินค้าเลขที่ : <?php echo $iv_no_ref; ?></td>
		<td style="width:70%;border-left:0px;">
			<?php if ($ttype_doc =='1'){ ?><input type="checkbox" checked><?php } else { ?><input type="checkbox"><?php } ?> คืนสินค้า 
			<?php if ($ttype_doc =='2'){ ?><input type="checkbox" checked><?php } else { ?><input type="checkbox"><?php } ?> ส่วนลด
		</td>
	</tr>
</table>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="3%" align="center">ITEM</td>
<td width="15%" align="center">Product Code</td>
<td width="35%" align="center">Description</td> 
<td width="8%" align="center">Qty</td> 
<td width="8%" align="center">Unit Price</td> 
<td width="8%" align="center">Amount</td> 
</tr>
<?php
$strSQL1 = "SELECT * FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) where ref_creditt = '".$ref_credit."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1)) {
$sum_amount1  =$objResult1["sum_amount"];
$sum_amount= number_format($sum_amount1,2)."";
$price1  =$objResult1["unit_price"];
$price= number_format( $price1,2)."";
$access_name  =$objResult1["access_name"];
$access_code  =$objResult1["access_code"];
$count  =$objResult1["count"];
$unit  =$objResult1["unit_name"];
?>
	<tr>
		<td style="text-align:center;"><?php echo $i;?></td>
		<td style="text-align:left;padding-left:5px;"><?php echo $access_code;?></td>
		<td style="text-align:left;padding-left:5px;"><?php echo $access_name;?></td>
		<td style="text-align:right;padding-right:5px;"><?php echo $count;?> <?php echo $unit;?></td>
		<td style="text-align:right;padding-right:5px;"><?php echo $price;?></td>
		<td style="text-align:right;padding-right:5px;"><?php echo $sum_amount;?></td>
	<?php $i++; } ?>
	</tr>
</table>
<table border="0" width="100%" style="border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">
	<tr>
		<td style="width:80%;text-align:right;">ส่วนลดพิเศษ : </td>
		<td style="width:20%;text-align:right;padding-right:5px;"><?php echo $discount_unit;?></td>
	</tr>
	<tr>
		<td style="text-align:right;">ราคาสุทธิ : </td>
		<td style="text-align:right;padding-right:5px;"><?php echo $summary;?></td>
	</tr>
</table>
<table border="0" style="width:100%;border-left:1px solid black;border-right:1px solid black;">
	<tr>
		<td style="width:10%;" valign="top">สาเหตุที่คืน : </td>
		<td style="width:90%;"><?php echo $return_des; ?></td>
	</tr>
</table>
<table border="1" width="100%"'>
	<tr>
		<td style="width:50%;text-align:center;padding-top:15px;" >
			<a style="border-bottom:1px solid black;"><?php echo $send_return_name; ?> / <?php echo $date_send_return ; ?></a><br><?php echo "ผู้ขอคืนสินค้า / วันที่"; ?></p>
		</td>
		<td style="width:50%;text-align:center;padding-top:15px;" >
			<a style="border-bottom:1px solid black;"><?php echo $receive_name; ?> / <?php echo $date_receive ; ?></a><br><?php echo "ผู้รับคืนสินค้า / วันที่"; ?></p>
		</td>
	</tr>
	<tr>
		<td style="width:50%;text-align:center;padding-top:15px;" >
			<a style="border-bottom:1px solid black;"><?php echo $sale_name; ?> / <?php echo $sale_date ; ?></a><br><?php echo "ผู้แทนขาย / วันที่"; ?></p>
		</td>
		<td style="width:50%;text-align:center;padding-top:15px;">
			<a style="border-bottom:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br><?php echo "ผู้อนุมัติ / วันที่"; ?> </p>
		</td>
	</tr>
	<tr>
		<td style="width:50%;text-align:center;padding-top:15px;" valign="top">ได้รับสินค้าข้างต้นคืนคลังสินค้าแล้วโดยสภาพ<br>
			<?php if ($stock_complete =='1'){ ?><input type="checkbox" checked><?php } else { ?><input type="checkbox"><?php } ?> สมบูรณ์
			<?php if ($stock_complete =='2'){ ?><input type="checkbox" checked><?php } else { ?><input type="checkbox"><?php } ?> ไม่สมบูรณ์ <a style="border-bottom:1px solid black;"><?php echo $stock_des; ?></a>
			</p><a style="border-bottom:1px solid black;"><?php echo $stock_name; ?> / <?php echo $stock_date ; ?></a><br><?php echo "คลังสินค้า / วันที่"; ?></p>
			<?php if ($warraty_ckk =='1'){ ?><input type="checkbox" checked><?php } else { ?><input type="checkbox"><?php } ?> ดำเนินการปรับปรุงข้อมูลใบรับประกันสินค้าแล้ว
		</td>
		<td style="width:50%;padding-top:15px;" valign="top"><center>แผนกบัญชี </center>
			<?php if ($credit_ckk =='1'){ ?><input type="checkbox" checked><?php } else { ?><input type="checkbox"><?php } ?> ทำใบลดหนี้เลขที่ <?php echo $credit_no; ?><br>
			<?php if ($type_return_ckk =='1'){ ?><input type="checkbox" checked><?php } else { ?><input type="checkbox"><?php } ?> ชำระคืนค่าสินค้าโดย <?php echo $type_return_no; ?><br>
			<?php if ($dis_credit =='1'){ ?><input type="checkbox" checked><?php } else { ?><input type="checkbox"><?php } ?> ลดหนี้
		</td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:50%;">อนุมัติวันที่ 16 ม.ค. 2561</td><td style="width:50%;text-align:right;">FM-SA-13:Rev.2</td>
	</tr>
</table>
</div>
</body>
</html>