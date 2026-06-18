<style>
		body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 13pt "Angsana New";
    }
	table {
	  border-collapse: collapse;
	  font-size:13pt;
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
$ref_id=$_GET["ref_id"];
include"dbconnect.php";
$strSQL = "SELECT
so__main.* ,tb_salechannel.*, tb_delivery.* , tb_payment.* FROM (((so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID)LEFT JOIN tb_payment ON so__main.payment=tb_payment.payment_ID) WHERE ref_id = '".$ref_id."' ";
//echo  $strSQL;
//exit();
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL3 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_id."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);


$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";

$ref_id=$objResult["ref_id"];
$delivery =$objResult["delivery"];
$time_send =$objResult["time_send"];
$description_wrap=$objResult["description_wrap"];
$time_description="$time_send $description_wrap";
$job_id =$objResult["job_id"];
$date = date('d-m-Y H:i:s');
$prefor_name=$objResult["prefer_name"];
$register_date=DateThai($objResult["register_date"]);
$doc_release_date =  DateThai($objResult["doc_release_date"]);
$date1 = explode('-' , $register_date );
$newDate = $date1[2].'-'.$date1[1].'-'.$date1[0];
$register_time =$objResult["register_time"];
$doc_no =$objResult["doc_no"];
$address1 =$objResult["address1"];
$address2 =$objResult["address2"];
$province_name =$objResult["province_name"];
$zip_code  =$objResult["zip_code"];
$delivery_place =$objResult["delivery_place"];
$postcode =$objResult["postcode"];
$return_contact =$objResult["return_contact"];
$customer_name =$objResult["customer_name"];
$po_no  =$objResult["po_no"];
$salechannel_nameshort =$objResult["salechannel_nameshort"];
$sn =$objResult["sn"];
$bq =$objResult["bq"];
$ot =$objResult["ot"];
$delivery_company =$objResult["delivery_company"];
$delivery_sale =$objResult["delivery_sale"];
$deliver_engineer =$objResult["deliver_engineer"];
$big_car =$objResult["big_car"];
$maps =$objResult["maps"];

if($objResult["delivery_date"]!="0000-00-00"){
$delivery_date  =DateThai($objResult["delivery_date"]);
}else{
$delivery_date  ="-";
}

$delivery_time  =$objResult["delivery_time"];
$call_before  =$objResult["call_before"];
$assign_date_time  =$objResult["assign_date_time"];
$sale_remarkk = $objResult["sale_remark"];
$returns = $objResult["returns"];
$return_address = $objResult["return_address"];
$return_contact = $objResult["return_contact"];
$employee_name = $objResult["employee_name"];
$approve_name = $objResult["approve_name"];

$billing_name = $objResult["billing_name"];
$billing_address = $objResult["billing_address"];
$billing_tel =  $objResult["billing_tel"];
$delivery_contract=  $objResult["delivery_contract"];

$discount=  $objResult["discount"];
$full_bill =  $objResult["full_bill"];
$with_pr   =  $objResult["with_pr"];
$clear_book_no   =  $objResult["clear_book_no"];
$clear_brn_no   =  $objResult["clear_brn_no"];
$clear_brnp_no   =  $objResult["clear_brnp_no"];

$type_com   =  $objResult["type_com"];
$type_po   =  $objResult["type_po"];
$type_type   =  $objResult["type_type"];
$type_type_detail   =  $objResult["type_type_detail"];

$waranty   =  $objResult["waranty"];
$cal   =  $objResult["cal"];
$pm   =  $objResult["pm"];
$install_place   =  $objResult["install_place"];

$time_delivery=$objResult["time_delivery"];
$packing_remark =$objResult["packing_remark"];
$deposit_no  =$objResult["deposit_no"];

$clear_book_ckk   =  $objResult["clear_book_ckk"];
$clear_brn_no_ckk   =  $objResult["clear_brn_no_ckk"];
$clear_brnp_no_ckk   =  $objResult["clear_brnp_no_ckk"];
$sn_ckk   =  $objResult["sn_ckk"];
$bq_ckk   =  $objResult["bq_ckk"];
$ot_ckk   =  $objResult["ot_ckk"];
$delivery_contact  =  $objResult["delivery_contact"];
$delivery_name =   $objResult["delivery_name"];
$tel =   $objResult["tel"];
$payment_name =   $objResult["payment_name"];
$payment =$objResult["payment"];
$delivery_type = $objResult["delivery_type"];
?><!-- ------------------End PHP Query------------------ -->
<div class="Section2 page">
<body>
<table style="width:100%;">
	<tr>
		<td style="width:15%;"><input type="checkbox"> ก <input type="checkbox"> C</td>
		<td style="width:35%;"><span><?php echo $time_delivery; echo $packing_remark; ?></span></td>
		<td style="width:10%;"></td>
		<td align="right" style="width:40%;"><font size="5"><?php echo $delivery_name; ?></font></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="text-align:right;width:55%;"><font size="5">ใบสั่งขาย&nbsp;&nbsp;&nbsp;</font><br><font size="4">(SALE ORDER)</font></td>
		<td style="width:20%;text-align:right;"><div align="right"><img src="img/nb_logo.jpg" width="80" align="right" height="40" /></div></td>
		<td style="width:25%;text-align:right;"><span align="right"><div align="right"><?php echo $doc_no;?></div><div align="right"><?php echo barcode($doc_no);?></div></span></td>
	</tr>
</table>
<table>
	<tr>
		<td style="width:25%;"><span>เลขที่อ้างอิง : </span><span><u><?php echo $ref_id; ?></u></span></td>
		<td style="width:25%;"><span>เลขที่ลงงาน : </span> <span><u><?php echo $job_id; ?></u></span></td>
		<td style="width:25%;"><span>ฝากส่งสินค้าเลขที่ : </span> <span><u><?php echo $deposit_no; ?></u></span></td>
		<td style="width:25%;text-align:right;"><span>วันที่ : </span> <span><?php echo $register_date; ?> <?php echo $register_time ; ?></span></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:20%;"><span>ชื่อผู้แนะนำ/รพ./แผนก </span></td>
		<td style="width:80%;border-bottom:1px solid black"><span><?php echo $prefor_name; ?></span></td>
	</tr>
	<tr>
		<td><span>ชื่อที่ต้องการออกบิล </span></td>
		<td style="border-bottom:1px solid black"><span><?php echo $billing_name; ?></span></td>
	</tr>
	<tr>
		<td><span>ที่อยูที่ต้องการออกบิล </span></td>
		<td style="border-bottom:1px solid black"><span><?php echo $billing_address; ?></span></td>
	</tr>
	<tr>
		<td><span>เบอร์โทร </span>
		<td style="border-bottom:1px solid black"><span><?php echo $billing_tel; ?></span></td>
	</tr>
	<tr>
		<td><span>สถานที่ส่งสินค้า </span></td>
		<td  style="border-bottom:1px solid black"><span><?php echo $delivery_place; ?></span></td>
	</tr>
	<tr>
		<td><span>ชื่อผู้ติดด่อ/โทร </span></td>
		<td  style="border-bottom:1px solid black"><span><?php echo $delivery_contact; ?></span></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:20%;"><span>เบอร์โทร</span></td>
		<td style="width:30%;border-bottom:1px solid black"><span><?php echo $tel; ?></span></td>
		<td style="width:20%;text-align:center;"><span>ชำระโดย</span></td>
		<td style="width:30%;border-bottom:1px solid black"><?php if ($payment==''){ ?><input type="checkbox"><?php }else{	?><input type="checkbox" checked><span><?php echo $payment_name; ?></span><?php	}	?> <input type="checkbox"><span>อื่นๆ</span></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:20%;"><span>ใบสั่งซื้อเลขที่</span></td>
		<td style="width:30%;border-bottom:1px solid black"><span><?php echo $po_no; ?></span></td>
		<td style="width:20%;text-align:center;"><span>กำหนดส่งตามสัญญา</span></td>
		<td style="width:30%;border-bottom:1px solid black"><span><?php echo $delivery_contract; ?></span></td>
	</tr>
</table>
<legend>รายการสินค้า</legend>
<table border= "1" width="100%">
<tr>
<td width="5%" align="center" >ลำดับ</td>
<td width="15%" align="center" >รหัสสินค้า</td>
<td width="50" align="center" >รายละเอียด</td> 
<td width="10%" align="center" >จำนวน</td> 
<td width="10%" align="center" >ราคาต่อหน่วย</td> 
<td width="10%" align="center" >ยอดรวม</td> 
</tr>
<?php
$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1)) {
$sum_amount1  =$objResult1["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";
$price_per_unit_1  =$objResult1["price_per_unit"];
$price_per_unit= number_format( $price_per_unit_1,2)."";
$product_code  =$objResult1["express_code"];
$product_name  =$objResult1["access_name"];
$sale_count  =$objResult1["sale_count"];
$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];
$product = "$product_name:$sale_remark";
$warranty = $objResult1["warranty"];
$cal = $objResult1["cal"];
$pm = $objResult1["pm"];
/*echo barcode($product_code)."<br>";
echo $product_code."<br>";*/
?>
<tr>
<td align="center"><?php echo $i;?></td>
<td align="center"><?php 
	//echo barcode($product_code);
	echo $product_code;
?></td>
<td align="left"><?php echo $product;?> <?php if ($warranty > 0){  echo ':รับประกัน'; echo $warranty; echo 'ปี'; }?>
<?php if ($cal > 0){  echo ':cal'; echo $cal; echo 'ครั้ง/ปี'; }?>
<?php if ($pm > 0){  echo ':pm'; echo $pm; echo 'ครั้ง/ปี'; }?>
</td>
<td align="right"><?php echo $sale_count;?>  <?php echo $unit_name;?></td>
<td align="right"><?php echo $price_per_unit;?></td>
<td align="right"><?php echo $sum_amount;?></td>
<?php
$i++;
}
?>
</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td  align="right" >Total : <?php echo $summary;?></td>

</tr>

</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td>
<?php if ($bq_ckk =='1'){?>
<input type="checkbox" checked><span>BQ เลขที่</span>
<?php }
else{	?>
<input type="checkbox"><span>BQ เลขที่</span>
<?php	}?>
<span style="text-decoration:underline;"><?php echo $bq; ?></span>
<?php if ($ot_ckk =='1'){?>
<input type="checkbox" checked><span>OT เลขที่</span>
<?php }else{?>
<input type="checkbox"><span>OT เลขที่</span>
<?php }?>
<span style="text-decoration:underline;"><?php echo $ot; ?></span>

<?php
if ($full_bill =='1'){?>
<input type="checkbox" checked><span>ต้องการใบกำกับภาษีเต็มรูปแบบ</span>
<?php }else{		?>
<input type="checkbox"><span>ต้องการใบกำกับภาษีเต็มรูปแบบ</span>
<?php	} ?>
</td>
</tr>
</table>
<table border="1" width="100%" class='w3-table'>
<tr>
<td width="50%">
Sales Comment<br>
<u><span><?php echo $sale_remarkk;?></span></u>
<br>
<?php if ($with_pr =='1'){?>
<input type="checkbox" checked><span>แนบใบเสนอราคา</span>
<?php }else{?>
<input type="checkbox"><span>แนบใบเสนอราคา</span>
<?php	}	?>
<br>
<?php if ($clear_book_ckk =='1'){ ?>
<input type="checkbox" checked><span>Clear ใบจองสินค้าเลขที่</span>
<?php }else{ ?>
<input type="checkbox"><span>Clear ใบจองสินค้าเลขที่</span>
<?php 	} ?>
<span style="text-decoration:underline;"><?php echo $clear_book_no; ?></span><br>
<span class="style40" >ไม่ต้องส่งสินค้า</span><br>
<?php if ($clear_brn_no_ckk =='1'){ ?>
<input type="checkbox" checked><span>Clear ใบยืมสินค้าติดเล่ม BRN</span>
<?php }else{ ?>
<input type="checkbox"><span >Clear ใบยืมสินค้าติดเล่ม BRN</span>
<?php	} ?>
<span style="text-decoration:underline;"><?php echo $clear_brn_no; ?></span>
<br>
<?php if ($clear_brnp_no_ckk =='1'){ ?>
<input type="checkbox" checked><span>clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span>
<?php }else{ ?>
<input type="checkbox"><span>clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span>
<?php	}	?>
<span style="text-decoration:underline;"><?php echo $clear_brnp_no; ?></span>
</td>
<td><!-- -->
<table style="width:100%;">
	<tr>
		<td><?php if ($delivery_type =='4'){ ?><input type="checkbox" checked><span>บริษัทจัดส่ง</span><?php }else{ ?><input type="checkbox"><span> >บริษัทจัดส่ง</span><?php	} ?></td>
		<td><?php if ($delivery_type =='1') { ?><input type="checkbox" checked><span>ส่งสินค้าแผนกช่าง</span><?php }else {	?><input type="checkbox"><span>ส่งสินค้าแผนกช่าง</span><?php	} ?></td>
	</tr>
	<tr>
		<td><?php if ($delivery_type =='2'){ ?><input type="checkbox" checked><span>Sale รับเอง</span><?php }else{ ?><input type="checkbox"><span>Sale รับเอง</span><?php } ?></td>
		<td><?php if ($delivery_type =='3'){ ?><input type="checkbox" checked><span>ลูกค้ารับเอง</span><?php }else{ ?><input type="checkbox"><span>ลูกค้ารับเอง</span><?php } ?></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td>วันที่</td>
		<td><u><?php echo $delivery_date; ?></u></td>
		<td>เวลา</td>
		<td><u><?php echo $delivery_time; ?></u>
	</tr>
</table>
<?php if ($big_car =='1'){ ?><input type="checkbox" checked><span>ต้องการรถใหญ่</span><?php } else{ ?><input type="checkbox"><span>ต้องการรถใหญ่</span><?php } ?><br>
<?php if ($maps =='1'){ ?><input type="checkbox" checked><span>มีแผนที่ประกอบ</span><?php } else{	?><input type="checkbox"><span>มีแผนที่ประกอบ</span><?php	} ?><br>
<?php if ($call_before =='1'){ ?><input type="checkbox" checked><span>แจ้งลูกค้าก่อนส่ง</span><?php } else{ ?><input type="checkbox"><span>แจ้งลูกค้าก่อนส่ง</span><?php } ?><br>
<?php if ($objResult3["fix_date"] =='1'){ ?><input type="checkbox" checked><span>นัดวันและเวลาเรียบร้อยแล้ว</span><?php } else{ ?><input type="checkbox"><span>นัดวันและเวลาเรียบร้อยแล้ว</span><?php } ?>
</td>
</tr>
<tr>
<td width="50%">
<?php if ($type_type =='1'){ ?><input type="checkbox" checked><span>พิมพ์ตาม Computer</span><?php } else{ ?><input type="checkbox"><span>พิมพ์ตาม Computer</span><?php } ?><br>
<?php if ($type_type =='2'){ ?><input type="checkbox" checked><span>พิมพ์ตามใบสั่งซื้อ</span><?php } else{ ?><input type="checkbox"><span>พิมพ์ตามใบสั่งซื้อ</span><?php } ?><br>
<?php if ($type_type =='3'){ ?><input type="checkbox" checked><span>พิมพ์ตามที่เขียน</span><?php } else{ ?><input type="checkbox"><span>พิมพ์ตามที่เขียน</span><?php }	?><br>
<u><span><?php echo $type_type_detail;?></span></u>
</td>
<td>
<table style="width:100%;">
	<tr>
		<td style="width:30%;"><span>ระยะเวลารับประกัน</span></td>
		<td style="border-bottom:1px solid black;"><span><?php echo $waranty_h; ?></span><span align="right"> ปี</span></td>
	</tr>
	<tr>
		<td><span>จำนวนครั้งในการ CAL</span></td>
		<td style="border-bottom:1px solid black;"><span><?php echo $cal;?></span><span> ครั้ง/ปี</span></td>
	</tr>
	<tr>
		<td><span>จำนวนครั้งในการ PM</span></td>
		<td style="border-bottom:1px solid black;"><span><?php echo $pm;?></span><span> ครั้ง/ปี</span</td>
	</tr>
	<tr>
		<td><span>สถานที่ติดตั้งเครื่อง</span></td>
		<td style="border-bottom:1px solid black;"><span><?php echo $install_place;?></span></td>
	</tr>
</table>
</td>
</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:33%;text-align:center;"><span><?php echo $employee_name; echo "/"; echo $register_date;?></span></td>
		<td style="width:33%;text-align:center;"><?php echo $doc_no ; ?></td>
		<td style="width:33%;text-align:center;"><?php echo $approve_name; echo "/"; echo $register_date;?></td>
	</tr>
	<tr>
		<td style="width:33%;text-align:center;"><span>Sales Signature/Area/Date</span></td>
		<td style="width:33%;text-align:center;"><?php echo $doc_release_date ; ?></td>
		<td style="width:33%;text-align:center;"><span>Authorized Signature/Date</span></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td><span>อนุมัติวันที่ 29 สิงหาคม 2559 </span></td>
		<td style="text-align:right;"><span>290859:Rev.9</span></td>
	</tr>
</table>
</body>
</div>
</html>