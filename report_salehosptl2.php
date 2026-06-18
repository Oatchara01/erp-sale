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
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {font-size: 16px; color: #FF0000; }
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

<style>
		body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 16pt "Angsana New";
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
        background: white;
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

<?php


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
include"dbconnect_acc.php";

$strSQL = "SELECT * from hos__so  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQLp = "SELECT pay_in FROM tb_bank WHERE id  = '".$objResult["payment"]."' ";
$objQueryp = mysqli_query($code,$strSQLp) or die(mysqli_error());
$objResultp = mysqli_fetch_array($objQueryp);
$pay_in = $objResultp["pay_in"];



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


$id = $objResult['id'];
$ref_id = $objResult['ref_id'];
$type_doc = $objResult['type_doc'];
$suggest = $objResult['suggest'];
$date = $objResult['date_so'];
$job_no = $objResult['job_no'];
$dep_no = $objResult['dep_no'];
$bill_name = $objResult['bill_name'];
$bill_address = $objResult['bill_address'];
$bill_tel = $objResult['bill_tel'];
$credit_name = $objResult['credit_name'];
$payment = $objResult['payment'];

$delivery = $objResult['delivery_contact'];
$delivery_tel = $objResult['delivery_tel'];
$delivery_contact = "$delivery / $delivery_tel";
$install_place = $objResult['install_place'];
$po_no = $objResult['po_no'];
$delivery_contract = $objResult['delivery_contract'];
$book_clear = $objResult['book_clear'];
$book_no = $objResult['book_no'];
$brn_clear = $objResult['brn_clear'];
$brn_no = $objResult['brn_no'];
$brnp_clear = $objResult['brnp_clear'];
$brnp_no = $objResult['brnp_no'];
$with_pr = $objResult['with_pr'];
$pr_no = $objResult['pr_no'];
$full_bill = $objResult['full_bill'];
$type_type = $objResult['type_type'];
$tax_id = $objResult['tax_id'];
$type_detail = $objResult['type_detail'];
if($objResult['iv_date']=='0000-00-00'){
	$iv_date ='-';
}else{
$iv_date = DateThai($objResult['iv_date']);
}
if($objResult['delivery_date']!='0000-00-00'){

$delivery_date = DateThai($objResult['delivery_date']);
}else{
$delivery_date = $objResult3['between_date'];
}

$mk_research = $objResult3['mk_research'];
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
$iv_no  = $objResult['iv_no'];
$product_free = $objResult['product_free'];
$sale_code = $objResult['sale'];
$delivery_type = $objResult['delivery_type'];
$address_name  = $objResult3['address_name'];
$address_1  = $objResult3['address_1'];
$delivery_address = "$address_name $address_1";
$payment_des = $objResult['payment_des'];
$want_bus  = $objResult3['want_bus'];
$call_customer  = $objResult3['call_customer'];
$fix_date  = $objResult3['fix_date'];
$on_time = $objResult3['on_time'];
$call_back = $objResult3['call_back'];
$no_money = $objResult3['no_price'];

$product_free1 = $objResult['product_free1'];
$product_free2 = $objResult['product_free2'];
$product_free3 = $objResult['product_free3'];
$product_free4 = $objResult['product_free4'];
$product_free5 = $objResult['product_free5'];
$product_free6 = $objResult['product_free6'];
$product_free7 = $objResult['product_free7'];
$product_free8 = $objResult['product_free8'];
$product_free9 = $objResult['product_free9'];
$pre_name = $objResult['pre_name'];



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
		<td style="width:30%;text-align:left;"><span align="left" style="color:red"><div align="left"><?php echo $customer_no;?></div>
			<?php if($type_doc=='4'){ ?>
			<img src="img/nb_logo.jpg" width="80" align="left" height="40" /> <?php } ?> </td>
		<td style="width:40%;text-align:center;"><font size="5">ใบสั่งขาย</font><br><font size="4">(SALE ORDER)</font></td>
		<td style="width:30%;text-align:right;"><span align="right"><div align="right"><?php echo $iv_no;?></div><div align="right"><?php echo barcode($iv_no);?></div></span></td>
	</tr>
</table>
<!--div align="right"><?php echo barcode($iv_no);?></div-->
<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			เลขที่อ้างอิง : <span class="style38"><?php echo $ref_id; ?></span>
		</td>
		<td style="width:50%;">
			เลขที่ลงงาน : <span class="style38"><?php echo $job_no; ?></span>
		</td>
		<td style="width:30%;text-align:left;padding-left:15px;">
			ฝากสินค้าเลขที่ : <span class="style38"><?php echo $order_no; ?></span>
		</td>
	</tr>
</table>

<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>ชื่อผู้แนะนำ/รพ./แผนก</span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<span class="style38"><?php echo $suggest; ?></span>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>วันที่ </span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span class="style38"><?php echo datethai($date); ?></span>
		</td>
	</tr>
	<tr>
		<td style="width:20%;">
			<span>ชื่อที่ต้องการออกบิล </span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<span class="style38"><?php echo $bill_name; ?> </span> <?php echo 'เลขผู้เสียภาษี :'; ?>  <span class="style38"><?php echo $tax_id; ?></span>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>เบอร์โทร </span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span class="style38"><?php echo $bill_tel; ?></span>
		</td>
	</tr>
</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>ที่อยู่ที่ต้องการออกบิล </span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span class="style38"><?php echo $bill_address; ?></span>
		</td>
	</tr>
	<tr>
		<td style="width:20%;">
			<span>สถานที่ส่งสินค้า </span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span class="style38"><?php echo $delivery_address; ?></span>
		</td>
	</tr>
	<tr>
		<td style="width:20%;">
			<span>ที่อยู่ในการส่งสินค้า </span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span class="style38"><?php echo $address_1; ?></span>
		</td>
	</tr>
</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>ชื่อผู้ติดต่อ/โทร </span>
		</td>
		<td style="border-bottom: 1px solid black;width:30%;">
			<span class="style38"><?php echo $delivery_contact; ?></span>
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
							<u><span class="style38"><?php echo $payment_des; ?></span></u>
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
			<span class="style38"><?php echo $po_no; ?></span>
		</td>
		<td style="width:20%;text-align:center;">
			<span>กำหนดส่งตามสัญญา</span>
		</td>
		<td style="width:30%;border-bottom: 1px solid black;">
			<span class="style38"><?php echo $delivery_contract; ?></span>
		</td>
	</tr>
</table>
<br>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" >เคลียร์ยืม</td>
<td width="5%" align="center" >ลำดับ</td>
<td width="15%" align="center" >รหัสสินค้า</td>
<td width="30%" align="center" >รายละเอียด</td> 
<td width="10%" align="center" >จำนวน</td> 
<td width="10%" align="center" >ราคาต่อหน่วย</td> 
<td width="10%" align="center" >ส่วนลดต่อหน่วย</td> 
<td width="10%" align="center" >ยอดรวม</td> 
</tr>
<?php

$strSQL1 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) where ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

	if($objResult1["bom_ckk"]=='0'){
	
$sum_amount1  =$objResult1["amount"];
$sum_amount= number_format($sum_amount1,2)."";
$price1  =$objResult1["price"];
$price= number_format( $price1,2)."";
$access_code  =$objResult1["access_code"];
$access_name  =$objResult1["sol_name"];
$count  =$objResult1["count"];
$unit  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];
$product = "$access_name:$sale_remark";
$warranty = $objResult1["warranty"];
$cal = $objResult1["cal"];
$pm = $objResult1["pm"];
$clear_br = $objResult1["clear_br"];
$clear_ivno = $objResult1["clear_ivno"];
$discount1  = $objResult1["discount"];
$discount= number_format($discount1,2)."";


?>
	<tr>
<td align="center" class="style38"><?php if($clear_br=='1'){?> <input type='checkbox' checked='checked'> <br><?php echo $clear_ivno; ?><?php }else{ ?><input type='checkbox' > <?php } ?></td>
<td align="center" class="style38"><?php echo $i;?></td>
<td align="center" class="style38"><?php 
		echo $access_code;

?></td>
<td align="left" class="style38"><?php echo $product;?>
<?php if ($warranty > 0){  echo ':รับประกัน'; echo $warranty; }?>
<?php if ($cal > 0){  echo ':cal'; echo $cal; echo 'ครั้ง/ปี'; }?>
<?php if ($pm > 0){  echo ':pm'; echo $pm; echo 'ครั้ง/ปี'; }?>
</td>
<td align="right" class="style38"><?php echo $count;?> &nbsp <?php echo $unit;?></td>
<td align="right" class="style38"><?php echo $price;?></td>
<td align="right" class="style38"><?php echo $discount;?></td>
<td align="right" class="style38"><?php echo $sum_amount;?></td>



<?php $i++; 
	}
}
		?>
</tr>
	<?php
	$strSQL2 = "SELECT distinct code_bom  FROM hos__subso  WHERE ref_idd = '".$ref_id."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2)){
		
$code_bom	= $objResult2["code_bom"];	
	
$strSQL3 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product_bomhos ON hos__subso.code_bom=tb_product_bomhos.bom_code) WHERE ref_idd = '".$ref_id."' and code_bom = '".$code_bom."'";

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);



while($objResult3 = mysqli_fetch_array($objQuery3))
{
	if($objResult3["code_bom"]!=''){
		
$sum_amount1  =$objResult3["amount"];
$sum_amount= number_format($sum_amount1,2)."";
$price1  =$objResult3["price"];
$price= number_format( $price1,2)."";
$access_code  =$objResult3["bom_code"];
$access_name  =$objResult3["bom_name"];
$count  =$objResult3["count"];
$unit  =$objResult3["unit_name"];
$sale_remark = $objResult3["sale_remark"];
$product = "$access_name:$sale_remark";
$warranty = $objResult3["warranty"];
$cal = $objResult3["cal"];
$pm = $objResult3["pm"];
$clear_br = $objResult3["clear_br"];
$clear_ivno = $objResult3["clear_ivno"];
$discount1  = $objResult3["discount"];
$discount= number_format($discount1,2)."";


?>
	<tr>
<td align="center" class="style38"><?php if($clear_br=='1'){?> <input type='checkbox' checked='checked'> <br><?php echo $clear_ivno; ?><?php }else{ ?><input type='checkbox' > <?php } ?></td>
<td align="center" class="style38"><?php echo $i;?></td>
<td align="center" class="style38"><?php 
		echo $access_code;

?></td>
<td align="left" class="style38"><?php echo $product;?>
<?php if ($warranty > 0){  echo ':รับประกัน'; echo $warranty; }?>
<?php if ($cal > 0){  echo ':cal'; echo $cal; echo 'ครั้ง/ปี'; }?>
<?php if ($pm > 0){  echo ':pm'; echo $pm; echo 'ครั้ง/ปี'; }?>
</td>
<td align="right" class="style38"><?php echo $count;?> &nbsp <?php echo $unit;?></td>
<td align="right" class="style38"><?php echo $price;?></td>
<td align="right" class="style38"><?php echo $discount;?></td>
<td align="right" class="style38"><?php echo $sum_amount;?></td>



<?php $i++; 
	}
}
}
		?>
	
	
</tr>
</table>

<table class="tablep" width="100%" style="border-top:0px;border-bottom:0px;">
<tr>
	<td style="border-right:1px solid black;"><?php if ($full_bill ==1){ ?><input type="checkbox" checked>  <span>ต้องการใบกำกับภาษีเต็มรูปแบบ</span><?php } else{ ?><input type="checkbox">  <span >ต้องการใบกำกับภาษีเต็มรูปแบบ</span><?php } ?></td>
	<td style="text-align:right;width:23.2%;">Total : <?php echo $summary;?></td>
</tr>
</table>


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
				<input type="checkbox" checked>   <span >Clear ใบจองสินค้าเลขที่</span> <span style="text-decoration:underline;"><?php echo $book_no; ?></span>
			<?php } else{ ?>
				<input type="checkbox">   <span >Clear ใบจองสินค้าเลขที่</span>  
			<?php } ?>
			<br>
			<span >ไม่ต้องส่งสินค้า</span>
			<br>
			<?php if ($brn_clear =='1'){ ?>
				<input type="checkbox" checked>   <span >Clear ใบยืมสินค้าติดเล่ม BRN</span> <span class="style38" style="text-decoration:underline;"><?php echo $brn_no; ?></span>
			<?php } else{ ?>
				<input type="checkbox">   <span >Clear ใบยืมสินค้าติดเล่ม BRN</span>  
			<?php }	?>
			<br>
			<?php if ($brnp_clear =='1'){ ?>
				<input type="checkbox" checked>   <span >Clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span> <span class="style38" style="text-decoration:underline;"><?php echo $brnp_no; ?></span>
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
				<u><span class="style38"><?php echo $type_detail;?></span></u>
			เลขที่ใบงานบริการ : <u><span class="style38"><?php echo $cm_no;?></span></u><br>
		</td>
	
		<td valign="top" style="text-align:left;">
			<table style="width:100%;">
				<tr>
					<td style="width:40%;">
						<?php if ($delivery_type =='4'){ ?>
							<input type="checkbox" checked> บริษัทจัดส่ง
						<?php } else{ ?>
							<input type="checkbox"> บริษัทจัดส่ง
						<?php }	?>
					</td>
					<td>
						<?php if ($delivery_type =='2'){ ?>
							<input type="checkbox" checked> ส่งสินค้าแผนกช่าง
						<?php } else{ ?>
							<input type="checkbox"> ส่งสินค้าแผนกช่าง
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
					<td><?php if ($call_customer  =='1'){ ?><input type="checkbox" checked>   <span >แจ้งลูกค้าก่อนส่ง</span>	<?php }else{ ?><input type="checkbox">   <span >แจ้งลูกค้าก่อนส่ง<?php } ?></td>
					<td><?php if ($fix_date  =='1'){ ?><input type="checkbox" checked>   <span >นัดวันและเวลาเรียบร้อยแล้ว</span><?php }else{ ?>	<input type="checkbox">   <span >นัดวันและเวลาเรียบร้อยแล้ว</span>	<?php } ?></td>
				</tr>
			</table>
			Sales Comment :<br>
			<u><span class="style38"><?php echo $sale_comment;?>
				
				<?php if($comment_ad1!=''){  echo $comment_ad; ?><br><?php } ?>	
	<?php if($comment_en1!=''){  echo $comment_en; ?><br><?php } ?>
	<?php if($comment_cs1!=''){  echo $comment_cs; ?><br><?php } ?>
	<?php if($comment_st1!=''){  echo $comment_st; ?><br><?php } ?>

				
				</span></u>
			
			
			
	
			<span >สถานที่ติดตั้งเครื่อง</span><br><u><span class="style38"><?php echo $install_place; ?></span></u><br> 
		</td>
	</tr>
</table>
<div style="padding-top:5px;"></div>
<table style="width:100%;" border="0">
	<tr>
		<td style="text-align:center;width:33%;">
			<span ><?php echo $sale; echo "("; echo $sale_code; echo ")"; echo "/"; echo $sale_date; ?></span>
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
	<br><br>
	
	<?php

$qfirst = "select * from st__signature where ref_id = '".$ref_id."'";
$first = mysqli_query($conn,$qfirst);
$ffirst = mysqli_fetch_array($first);

$qfirst1 = "select name,surname from tb_user where em_id = '".$ffirst["en_code"]."'";
$first1 = mysqli_query($conn,$qfirst1);
$ffirst1 = mysqli_fetch_array($first1);

$qfirst2 = "select name,surname from tb_user where em_id = '".$ffirst["cs_code"]."'";
$first2 = mysqli_query($conn,$qfirst2);
$ffirst2 = mysqli_fetch_array($first2);

	?>

		<table style="width:100%;" >
	
	<tr>
	<td style="width:33%;text-align:center;"><?php echo "("; echo $ffirst["st_name"]; echo ")";  ?></td>
	<td style="width:33%;text-align:center;">
		<?php if($ffirst["en_name"]!=''){ ?>
		<img src="data:<?php echo $ffirst["en_name"];?>" width="150" align="center" height="60" />
		<?php } ?>
		</td>
	<td style="width:33%;text-align:center;">
		<?php if($ffirst["cs_name"]!=''){ ?>
		<img src="data:<?php echo $ffirst["cs_name"];?>" width="150" align="center" height="60" />
		<?php } ?>
		</td>
	</tr>
			
	<tr>
	<td style="width:33%;text-align:center;"></td>
	<td style="width:33%;text-align:center;"><?php echo "("; ?>  <?php echo $ffirst1["name"]; ?> <?php echo $ffirst1["surname"]; ?>  <?php echo ")";  ?></td>
	<td style="width:33%;text-align:center;"><?php echo "("; ?>  <?php echo $ffirst2["name"]; ?> <?php echo $ffirst2["surname"]; ?>  <?php echo ")";  ?></td>
	</tr>			
			
	<tr>
	<td style="width:33%;text-align:center;">แผนกคลังสินค้า</td>
	<td style="width:33%;text-align:center;">ช่างผู้ตรวจเช็ค</td>
	<td style="width:33%;text-align:center;">ผู้รับสินค้า/ผู้จัดส่งสินค้า</td>
	</tr>
		
		<tr>
		<td style="width:33%;text-align:center;">วันที่ <?php echo $ffirst["stock_dt"]; ?></td>
		<td style="width:33%;text-align:center;">วันที่ <?php echo $ffirst["en_dt"]; ?></td>
		<td style="width:33%;text-align:center;">วันที่ <?php echo $ffirst["cs_dt"]; ?></td>
		</tr>
</table>
<br>
	
	
<br><br><br>
</body>
</html>