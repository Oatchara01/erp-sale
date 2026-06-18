<style>
	
	body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 12pt "Angsana New";
	
    }
	table {
	  border-collapse: collapse;
	  font-size:14pt;
	}
	.tablel {
	  border-collapse: collapse;
	  font-size:10pt;
	}
	.tablepr {
	  border-collapse: collapse;
	  font-size:12pt;
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
        padding-left: 10mm;
		padding-right: 10mm;
		padding-top: 5mm;
		padding-bottom: 0mm;
        margin: 0mm auto;
        /*border: 0px #D3D3D3 solid;
        border-radius: 0px;*/
        background: White;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0);
    }
    
    @page {
        size: A4;
        margin: 0;
    }
	@page Section1 {size:841.7pt 595.45pt; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	div.Section1 {page:Section1;}
	@page Section2 {size:595.45pt 841.7pt;mso-page-orientation:landscape;margin:0.4in 0.4in 0.4in 0.4in;mso-header-margin:.4in;mso-footer-margin:.4in;mso-paper-source:0;}
	div.Section2 {page:Section2;}

	@media screen {
	  div.divFooter {
		display: none;
	  }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
			margin: 0;
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
<?php error_reporting(~E_NOTICE);
include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";

function barcode($code){
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 0.5;//กำหนดความหน้าของเส้น Barcode
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
include"dbconnect_acc.php";


$strSQL25="Update  hos__so set status_ad_print = '1'  where ref_id ='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);

$strSQL = "SELECT * from hos__so  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQLp = "SELECT pay_in FROM tb_bank WHERE id  = '".$objResult["payment"]."' ";
$objQueryp = mysqli_query($code,$strSQLp) or die(mysqli_error());
$objResultp = mysqli_fetch_array($objQueryp);
$pay_in = $objResultp["pay_in"];


$strSQL10 = "SELECT customer_code,customer_coden FROM tb_customer WHERE customer_id  = '".$objResult["bill_id"]."' ";
$objQuery10 = mysqli_query($conn,$strSQL10) or die(mysqli_error());
$objResult10 = mysqli_fetch_array($objQuery10);

$strSQL11 = "SELECT * FROM tb_other_bill WHERE ref_id  = '".$ref_id."' ";
$objQuery11 = mysqli_query($conn,$strSQL11) or die(mysqli_error());
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL1 = "SELECT * FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL3 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_id."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);

$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";

if ($objResult['type_doc']==3)
{
$customer_no=$objResult10['customer_code'];
}
else if ($objResult['type_doc']==4)
{
$customer_no=$objResult10['customer_coden'];
}

$id = $objResult['id'];
$ref_id = $objResult['ref_id'];
$type_doc = $objResult['type_doc'];
$suggest = $objResult['suggest'];
$date = $objResult['date_so'];
$job_no = $objResult['job_no'];
$dep_no = $objResult['dep_no'];
$cm_no = $objResult['cm_no'];
$bill_name = $objResult['bill_name'];
$bill_address = $objResult['bill_address'];
$bill_tel = $objResult['bill_tel'];
$credit_name = $objResult['credit_name'];
$payment = $objResult['payment'];
$pre_name = $objResult['pre_name'];
$delivery = $objResult['delivery_contact'];
$delivery_tel = $objResult['delivery_tel'];
$delivery_contact = "$delivery / $delivery_tel";
$tax_id = $objResult['tax_id'];
$po_no = $objResult['po_no'];
$delivery_contract = $objResult['delivery_contract'];
$book_clear = $objResult['book_clear'];
$book_no = $objResult['book_no'];
$brn_clear = $objResult['brn_clear'];
$brn_no = $objResult['brn_no'];
$brnp_clear = $objResult['brnp_clear'];
$brnp_no = $objResult['brnp_no'];
$with_pr = $objResult['with_pr'];
$pr_no  = $objResult['pr_no'];
$full_bill = $objResult['full_bill'];
$type_type = $objResult['type_type'];
$type_detail = $objResult['type_detail'];
$iv_date = DateThai($objResult['iv_date']);
if($objResult['delivery_date']!='0000-00-00'){

$delivery_date = DateThai($objResult['delivery_date']);
}else{
$delivery_date = $objResult3['between_date'];
}

$delivery_time = $objResult['delivery_time'];
$sale_comment  = $objResult['sale_comment'];

if ($objResult['sale_date']!='0000-00-00') {
$sale_date = DateThai($objResult['sale_date']);
}else {
$sale_date = '-';
}

$approve = $objResult['approve'];
if ($objResult['approve_date']!='0000-00-00') {
$approve_date = DateThai($objResult['approve_date']);
}else {
$approve_date = '-';
}
$sale  = $objResult['sale'];
$iv_no  = $objResult['iv_no'];
$product_free = $objResult['product_free'];
$product_free1 = $objResult['product_free1'];
$product_free2 = $objResult['product_free2'];
$product_free3 = $objResult['product_free3'];
$product_free4 = $objResult['product_free4'];
$product_free5 = $objResult['product_free5'];
$product_free6 = $objResult['product_free6'];
$product_free7 = $objResult['product_free7'];
$product_free8 = $objResult['product_free8'];
$product_free9 = $objResult['product_free9'];
$sale_code = $objResult['sale_code'];
$delivery_type = $objResult['delivery_type'];
$address_name  = $objResult3['address_name'];
$address_1  = $objResult3['address_1'];
$delivery_address = "$address_name $address_1";
$payment_des = $objResult['payment_des'];
$install_place = $objResult['install_place'];
$want_bus  = $objResult3['want_bus'];
$call_customer  = $objResult3['call_customer'];
$fix_date  = $objResult3['fix_date'];
$order_no = $objResult["order_no"];

if($objResult11["ref_1"]=='1'){
$ref_1 ="1.เตรียมเอกสาร N-Health";
}else{
$ref_1 ="";	
}

if($objResult11["ref_2"]=='1'){
$ref_2 ="2.เตรียมเอกสารตามที่แนบไฟล์";
}else{
$ref_2 ="";	
}

if($objResult11["ref_3"]=='1'){
$ref_3 ="3.ใบ อย.";
}else{
$ref_3 ="";	
}

if($objResult11["ref_4"]=='1'){
$ref_4 ="4.ใบตัวแทนจำหน่าย";
}else{
$ref_4 ="";	
}

if($objResult11["ref_5"]=='1'){
$ref_5 ="5.ใบช่างอบรม";
}else{
$ref_5 ="";	
}

if($objResult11["ref_6"]=='1'){
$ref_6 ="6.ใบนำเข้าสินค้า";
}else{
$ref_6 ="";	
}

if($objResult11["ref_7"]=='1'){
$ref_7 ="7.ใบ CER เครื่องมือที่ใช้ทดสอบ";
}else{
$ref_7 ="";	
}

if($objResult11["ref_8"]=='1'){
$ref_8 ="8.ใบ PM";
}else{
$ref_8 ="";	
}

if($objResult11["ref_9"]=='1'){
$ref_9 ="9.ใบ CAL";
}else{
$ref_9 ="";	
}
if($objResult11["ref_11"]=='1'){
$ref_11 ="11.ใบประเมินสินค้า";
}else{
$ref_11 ="";	
}

if($objResult11["ref_12"]=='1'){
$ref_12 ="12.ส่งสินค้าด้วยใบรับสินค้า [ไม่ระบุราคา]";
}else{
$ref_12 ="";	
}

if($objResult11["ref_13"]=='1'){
$ref_13 ="13.ไม่ต้องนำใบกำกับภาษี/ใบเสร็จไปส่งสินค้า";
}else{
$ref_13 ="";	
}


if($objResult11["ref_11"]=='1'){
$ref_11 ="11.ใบประเมินสินค้า";
}else{
$ref_11 ="";	
}

if($objResult11["ref_10"]=='1'){
$ref_des = $objResult11["ref_des"];
$ref_10 ="อื่น ๆ $ref_des";
}else{
$ref_10 ="";	
}


$strSQL91 = "SELECT comment_cs,comment_st,comment_en,comment_ad FROM tb_comment_so WHERE ref_id  = '".$ref_id."' ";
$objQuery91 = mysqli_query($conn,$strSQL91) or die(mysqli_error());
$objResult91 = mysqli_fetch_array($objQuery91);


$comment_ad1 = $objResult91["comment_ad"];
$comment_en1 = $objResult91["comment_en"];
$comment_st1 = $objResult91["comment_st"];
$comment_cs1 = $objResult91["comment_cs"];

$comment_ad = "หมายเหตุ Admin : $comment_ad1";
$comment_en = "หมายเหตุ ช่าง : $comment_en1";
$comment_st = "หมายเหตุ Stock : $comment_st1";
$comment_cs = "หมายเหตุ CS : $comment_cs1";


?>
<div class="Section2 page">
<body>
<table style="width:100%;">
	<tr>
		<td style="width:15%;"><input type="checkbox"> ก <input type="checkbox"> C</td>
		<td style="width:45%;"><span><?php echo $time_delivery; echo $packing_remark; ?></span></td>
		<td align="right" style="width:40%;"><font size="5"><?php echo $delivery_name; ?></font></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
	<td style="width: 10%;text-align:left;"><span align="left"><div align="left" style="color:red"><?php echo $customer_no;?></div></span></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:30%;text-align:left;"><img src="img/nb_logo.jpg" width="80" align="left" height="40" /></td>
		<td style="width:40%;text-align:center;"><font size="5">ใบสั่งขาย</font><br><font size="4">(SALE ORDER)</font></td>
		<td style="width:30%;text-align:right;"><span align="right"><div align="right"><?php echo $iv_no;?></div><div align="right"><?php echo barcode($iv_no); ?></div></span></td>
	</tr>
</table>
<!--div align="right"><?php //echo barcode($iv_no);?></div-->
<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>เลขที่อ้างอิง : <?php echo $ref_id; ?></span>
		</td>
		<td style="width:50%;">
			<span>เลขที่ลงงาน : <?php echo $job_no; ?></span>
		</td>
		<td style="width:30%;text-align:left;padding-left:15px;">
			<span>ฝากสินค้าเลขที่ : <?php echo $order_no; ?></span>
		</td>
	</tr>
</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>ชื่อผู้แนะนำ/รพ./แผนก</span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<span><?php echo $suggest; ?></span>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>วันที่ </span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span><?php echo datethai($date); ?></span>
		</td>
	</tr>
	<tr>
		<td style="width:20%;">
			<span>ชื่อที่ต้องการออกบิล </span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<span><?php echo $bill_name; ?></span>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>เบอร์โทร </span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span><?php echo $bill_tel; ?></span>
		</td>
	</tr>
</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>ที่อยู่ที่ต้องการออกบิล </span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span><?php echo $bill_address; ?> <?php echo 'เลขผู้เสียภาษี :'; ?> <?php echo $tax_id; ?></span>
		</td>
	</tr>
	<tr>
		<td style="width:20%;">
			<span>สถานที่ส่งสินค้า </span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span><?php echo $delivery_address; ?></span>
		</td>
	</tr>
	<tr>
		<td style="width:20%;">
			<span>ที่อยู่ในการส่งสินค้า </span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span><?php echo $address_1; ?></span>
		</td>
	</tr>
</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>ชื่อผู้ติดต่อ/โทร </span>
		</td>
		<td style="border-bottom: 1px solid black;width:30%;">
			<span><?php echo $delivery_contact; ?></span>
		</td>
		<td style="width:20%;text-align:center;">
			<span>ชำระโดย </span>
		</td>
		<td style="border-bottom: 1px solid black;width:30%;">
			<span><?php
							if ($pay_in==''){ ?> - <?php } else{ ?>
							<input type="checkbox" checked>   <span><?php echo $pay_in; ?></span>
							<?php }	
							if ($payment=='6'){ ?>
							<u><span><?php echo $payment_des; ?></span></u>
							<?php }
								?>
			</span>
		</td>
	</tr>
</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>ใบสั่งซื้อเลขที่</span>
		</td>
		<td style="width:30%;border-bottom: 1px solid black;">
			<span><?php echo $po_no; ?></span>
		</td>
		<td style="width:20%;text-align:center;">
			<span>กำหนดส่งตามสัญญา</span>
		</td>
		<td style="width:30%;border-bottom: 1px solid black;">
			<span><?php echo $delivery_contract; ?></span>
		</td>
	</tr>
</table>
<br>

<?php
$strSQL1 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) where ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1); ?>
<table>
<tr class="tr">
	<td width="8%" align="center" >เคลียร์ยืม</td>
<td width="3%" align="center" class="td">ลำดับ</td>
<td width="14%" align="center" class="td">รหัสสินค้า</td>
<td width="35%" align="center" class="td">รายละเอียด</td> 
<td width="8%" align="center" class="td">จำนวน</td> 
<td width="9%" align="center" class="td">ราคา/หน่วย</td> 
<td width="11%" align="center" class="td">ส่วนลด/หน่วย</td> 
<td width="10%" align="center" class="td">ยอดรวม</td> 
</tr>
<?php 
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sql = "SELECT date_expir   FROM st__lotno where product_id ='".$objResult1["product_id"]."' and lot_no='".$objResult1["lot_no"]."'";
$qry = mysqli_query($new,$sql) or die(mysqli_error());
$Num = mysqli_num_rows($qry);
$rs = mysqli_fetch_assoc($qry);	
	
	
$sum_amount1  =$objResult1["amount"];
$sum_amount= number_format($sum_amount1,2)."";
$price1  =$objResult1["price"];
$price= number_format( $price1,2)."";
$access_code  =$objResult1["express_code"];
$access_name  =$objResult1["sol_name"];
$count  =$objResult1["count"];
$unit  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];
$product = "$access_name:$sale_remark";
$warranty = $objResult1["warranty"];
$cal = $objResult1["cal"];
$pm = $objResult1["pm"];
$discount1  = $objResult1["discount"];
$discount= number_format($discount1,2)."";
	$clear_br = $objResult1["clear_br"];
$clear_ivno = $objResult1["clear_ivno"];
$lot_no = $objResult1["lot_no"];	
$date_expir = $rs["date_expir"];
	
?>
<tr>
	<td align="center" class="td" ><?php if ($clear_br =='1'){?><input type="checkbox" checked><?php } ?></p>
	<?php echo $clear_ivno; ?>
	</td>
<td align="center" class="td"><?php echo $i;?></td>
<td align="center" class="td"><?php 
	echo $access_code;
?></td>
<td align="left" class="td"><?php echo $product;?>
<?php if ($warranty > 0){  echo ':รับประกัน'; echo $warranty; }?>
<?php if ($cal > 0){  echo ':cal'; echo $cal; echo 'ครั้ง/ปี'; }?>
<?php if ($pm > 0){  echo ':pm'; echo $pm; echo 'ครั้ง/ปี'; }?>
<?php if ($lot_no !=''){  echo '::Lot No : '; echo $lot_no;  }?>
<?php if($Num > 0){ if ($date_expir !='' or $date_expir !='0000-00-00'){  echo '::Date Exp. : '; echo Datethai($date_expir); }  } ?>
	
</td>
<td style="text-align:right;padding-right:3px;" class="td"><?php echo $count;?>  <?php echo $unit;?></td>
<td style="text-align:right;padding-right:3px;" class="td"><?php echo $price;?></td>
<td style="text-align:right;padding-right:3px;" class="td"><?php echo $discount;?></td>
<td style="text-align:right;padding-right:3px;" class="td"><?php echo $sum_amount;?></td>
<?php $i++; } ?>
</tr>
</table>

<table class="tablep" width="100%" style="border-top:0px;border-bottom:0px;">
<tr>
	<td style="border-right:1px solid black;"><?php if ($full_bill ==1){ ?><input type="checkbox" checked>  <span>ต้องการใบกำกับภาษีเต็มรูปแบบ</span><?php } else{ ?><input type="checkbox">  <span >ต้องการใบกำกับภาษีเต็มรูปแบบ</span><?php } ?></td>
	<td style="text-align:right;width:23.2%;">Total : <?php echo $summary;?></td>
</tr>
<table width="100%" class="tablep">
	<tr>
		<td valign="top" style="width:50%;"  class="td">
			<?php if ($with_pr =='1'){ ?>
				<input type="checkbox" checked>   <span >แนบใบเสนอราคา</span>
			<?php } else{ ?>
				<input type="checkbox">   <span >แนบใบเสนอราคา</span>
			<?php }	?>
			<u><span ><?php echo $pr_no;?></span></u>
			<br>
			<?php if ($book_clear =='1'){ ?>
				<input type="checkbox" checked>   <span >Clear ใบจองสินค้าเลขที่</span>  <span style="text-decoration:underline;"><?php echo $book_no; ?></span>
			<?php } else{ ?>
				<input type="checkbox">   <span >Clear ใบจองสินค้าเลขที่</span>  
			<?php } ?>
			<br>
			<span >ไม่ต้องส่งสินค้า</span>
			<br>
			<?php if ($brn_clear =='1'){ ?>
				<input type="checkbox" checked>   <span >Clear ใบยืมสินค้าติดเล่ม BRN</span>  <span style="text-decoration:underline;"><?php echo $brn_no; ?></span>
			<?php } else{ ?>
				<input type="checkbox">   <span >Clear ใบยืมสินค้าติดเล่ม BRN</span>  
			<?php }	?>
			<br>
			<?php if ($brnp_clear =='1'){ ?>
				<input type="checkbox" checked>   <span >Clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span>  <span style="text-decoration:underline;"><?php echo $brnp_no; ?></span>
			<?php } else{ ?>
				<input type="checkbox">   <span >Clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span> 
			<?php }	?>
			<hr>
			<?php if ($type_type =='1'){ ?>
				<input type="checkbox" checked>   <span >พิมพ์ตาม Computer</span>
			<?php }else{ ?>
				<input type="checkbox">   <span >พิมพ์ตาม Computer</span>
			<?php }	?>
			<br>
			<?php if ($type_type =='2'){ ?>
				<input type="checkbox" checked>   <span >พิมพ์ตามใบสั่งซื้อ</span>
			<?php }else{ ?>
				<input type="checkbox">   <span >พิมพ์ตามใบสั่งซื้อ</span>
			<?php }	?>
			<br>
			<?php if ($type_type =='3'){ ?>
				<input type="checkbox" checked>   <span >พิมพ์ตามที่เขียน</span>
			<?php }else{ ?>
				<input type="checkbox">   <span >พิมพ์ตามที่เขียน</span>
			<?php }	?>
			<br>
				<u><span ><?php echo $type_detail;?></span></u>
			เลขที่ใบงานบริการ : <u><span ><?php echo $cm_no;?></span></u><br>
		</td>
		
		<td valign="top" style="text-align:left;">
			<table style="width:100%;">
				<tr>
					<td style="width:40%;">
						<?php if ($delivery_type =='4'){ ?>
							<input type="checkbox" checked> บริษัทจัดส่ง</span>
						<?php } else{ ?>
							<input type="checkbox"> บริษัทจัดส่ง</span>
						<?php }	?>
					</td>
					<td>
						<?php if ($delivery_type =='2'){ ?>
							<input type="checkbox" checked> ส่งสินค้าแผนกช่าง</span>
						<?php } else{ ?>
							<input type="checkbox"> ส่งสินค้าแผนกช่าง</span>
						<?php }	?>
					</td>
				</tr>
				<tr>
					<td>
						<?php if ($delivery_type =='1'){ ?>
							<input type="checkbox" checked> <span >Sales รับเอง    </span>
						<?php } else{ ?>
							<input type="checkbox"> <span >Sales รับเอง    </span>
						<?php }	?>
					</td>
					<td>
						<?php if ($delivery_type =='3'){ ?>
							<input type="checkbox" checked> <span >ลูกค้ารับเอง</span>
						<?php } else{ ?>
							<input type="checkbox"> <span >ลูกค้ารับเอง</span>
						<?php }	?>
					</td>
				</tr>
			</table>
			<table><tr><td style="width:10%;">วันที่</td><td style="width:30%;"><u><?php echo $delivery_date; ?></u></td><td style="width:10%;text-align:center;">เวลา</td><td style="width:50%;"><u><?php echo $delivery_time; ?></u></td></tr></table>
			<table style="width:100%;">
				<tr>
					<td style="width:40%;"><?php if ($want_bus  =='1'){ ?><input type="checkbox" checked>   <span >ต้องการรถใหญ่</span><?php }else{ ?>	<input type="checkbox">   <span >ต้องการรถใหญ่</span>	<?php } ?></td>
					<td><input type="checkbox">   <span >มีแผนที่ประกอบ</span></td>
				</tr>
				<tr>
					<td><?php if ($call_customer  =='1'){ ?><input type="checkbox" checked></a>   <span >แจ้งลูกค้าก่อนส่ง</span>	<?php }else{ ?><input type="checkbox">   <span >แจ้งลูกค้าก่อนส่ง<?php } ?></td>
					<td><?php if ($fix_date  =='1'){ ?><input type="checkbox" checked>   <span >นัดวันและเวลาเรียบร้อยแล้ว</span><?php }else{ ?>	<input type="checkbox">   <span >นัดวันและเวลาเรียบร้อยแล้ว</span>	<?php } ?></td>
				</tr>
			</table>
			Sales Comment <br>
			<u><span ><?php echo $sale_comment;?> <?php echo $ref_1; ?> <?php echo $ref_2; ?> <?php echo $ref_3; ?> <?php echo $ref_4; ?> <?php echo $ref_5; ?> <?php echo $ref_6; ?> <?php echo $ref_7; ?> <?php echo $ref_8; ?> <?php echo $ref_9; ?> <?php echo $ref_10; ?> <?php echo $ref_11; ?> <?php echo $ref_12; ?> <?php echo $ref_13; ?></span></u>
			<br>
<?php if($comment_ad1!=''){  echo $comment_ad; ?><br><?php } ?>	
<?php if($comment_en1!=''){  echo $comment_en; ?><br><?php } ?>
<?php if($comment_cs1!=''){  echo $comment_cs; ?><br><?php } ?>
<?php if($comment_st1!=''){  echo $comment_st; ?><br><?php } ?>
<br>
			<span >สถานที่ติดตั้งเครื่อง</span><br><u><span ><?php echo $install_place; ?></span></u><br> 
		</td>
	</tr>
</table>
<div style="padding-top:5px;"></div>
<table style="width:100%;" border="0">
	<tr>
		<td style="text-align:center;width:33%;">
			<span ><?php echo $sale; echo "("; echo $sale_code; echo ")";  echo "/"; echo $sale_date;?></span>
		</td>
		<td style="text-align:center;width:33%;">
			<span align="right"><?php echo $iv_no ; ?></span>
		</td>
		<td style="text-align:center;width:33%;">
			<span ><?php echo $approve; echo "/"; echo $approve_date; ?></span>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;width:33%;">
			<span >Sales Signature/Area/Date</span>
		</td>
		<td style="text-align:center;width:33%;">
			<span align="right"><?php echo $iv_date; ?></span>
		</td>
		<td style="text-align:center;width:33%;">
			<span >Authorized Signature/Date</span>
		</td>
	</tr>
</table>
</p>
	<table style="width:100%;">
	
	<tr>
		<td style="width:33%;text-align:center;"><span>____________________</span></td>
		<td style="width:33%;text-align:center;">____________________</td>
		<td style="width:33%;text-align:center;"><span>____________________</span></td>
		<td style="width:33%;text-align:center;"><span>____________________</span></td>
	</tr>
		<tr>
		<td style="width:33%;text-align:center;"><span><?php echo 'แผนกคลังสินค้า';?></span></td>
		<td style="width:33%;text-align:center;"><?php echo "ช่างผู้ตรวจเช็ค"; ?></td>
			<td style="width:33%;text-align:center;"><?php echo "ผู้รับสินค้า";?></td>
		<td style="width:33%;text-align:center;"><?php echo "ผู้จัดส่งสินค้า";?></td>
	</tr>
		
		<tr>
		<td style="width:33%;text-align:center;"><span>วันที่ <?php echo "(____/____/____)"; ?></span></td>
		<td style="width:33%;text-align:center;">วันที่ <?php echo "(____/____/____)"; ?></td>
			<td style="width:33%;text-align:center;">วันที่ <?php echo "(____/____/____)"; ?></td>
		<td style="width:33%;text-align:center;"><span>วันที่ <?php echo "(____/____/____)"; ?></span></td>
	</tr>
</table>

<table style="width:100%;" class="tablel">
	<tr>
		<td>
			<span >อนุมัติวันที่ 8 พฤษภาคม 2563 </span>
		</td>
		<td style="text-align:right;">
			<span ><!--FM-SA-04:Rev.10-->080563:Rev.10</span>
		</td>
	</tr>
</table>

</body>
</div>
</html>