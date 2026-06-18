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
$ref_idsmp = $_GET["ref_idsmp"];
include"dbconnect.php";
$strSQL1 = "Update  hos__smp set print_adm = '1' WHERE ref_idsmp = '".$ref_idsmp."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());

$strSQL2 = "SELECT * FROM  hos__subsmp WHERE reff_idsmp = '".$ref_idsmp."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
$objResult2 = mysqli_fetch_array($objQuery2);

if($objResult2["sn_old"]!=''){
$sn_old1 = $objResult2["sn_old"];
$sn_old = "SN เครื่องวัดน้ำตาล G-426 : $sn_old1";
$sn_1 = $objResult2["sn"];	
$sn_ = "SN เครื่องวัดน้ำตาล GLUCOALL-1B : $sn_1";	
}


$strSQL = "SELECT * FROM  hos__smp WHERE ref_idsmp = '".$ref_idsmp."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL3 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_idsmp."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);

$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM hos__subsmp WHERE reff_idsmp = '".$ref_idsmp."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";

$month = date('m');
$day = date('d');
$year = date('Y');

$today1 = $year . '-' . $month . '-' . $day;
$today=DateThai($today1);

if($objResult["order_no"]!=''){
$order_no1 = $objResult["order_no"];
$order_no = "หมายเลขคำสั่งซื้อใหม่ : $order_no1";	
}

$ref_idsmp = $objResult["ref_idsmp"];
$smp_no = $objResult["smp_no"];
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];
$smp_date = DateThai($objResult["smp_date"]);
$comment_sale = $objResult["comment_sale"];
$sale_code = $objResult["sale_code"];
$sale_name = $objResult["sale_name"];
$sale_date = DateThai($objResult["sale_date"]);
$sup_name = $objResult["sup_name"];
$sup_date = DateThai($objResult["sup_date"]);
$comment_sup = $objResult["comment_sup"];
$status_sup = $objResult["status_sup"];
$comment_dm =  $objResult["comment_dm"];
$dm_name =  $objResult["dm_name"];
$stock_name  =  $objResult["stock_name"];
if($objResult["stock_date"]!='0000-00-00'){ $stock_date = DateThai($objResult["stock_date"]); }
else{ $stock_date = '-'; }
$send_dm =  $objResult["send_dm"];

if($objResult["dm_date"]!='0000-00-00'){ $dm_date = DateThai($objResult["dm_date"]); }
else{$dm_date = '-'; }
$status_dm = $objResult["status_dm"];
$type_company = $objResult["type_company"];

if($objResult3['start_date']!='0000-00-00'){
$delivery_date = DateThai($objResult3['start_date']);
}else{
$delivery_date = $objResult3['between_date'];
}

$start_time = $objResult3['start_time'];
$end_time = $objResult3['end_time'];
$delivery_time ="$start_time $end_time";

$want_bus  = $objResult3['want_bus'];
$call_customer  = $objResult3['call_customer'];
$fix_date  = $objResult3['fix_date'];

?>
<body>
<div class="Section2 page">
<table style="width:100%;">
	<tr>
		<td style="width:25%;" valign="top">
			<input type="checkbox"> ก <input type="checkbox"> C
			<?php if($type_company =='2') { ?>
				<br><img src="img/nb_logo.jpg" width="100" align="left" height="40" />
			<?php } ?>
			<div align="left"><?php echo 'เลขที่อ้างอิง'; echo ' : '; echo $ref_idsmp;?></div>
		</td>
		<td style="width:50%;" valign="top">
			<center><h3><b>ใบเบิกสินค้าและอะไหล่เพื่อสนับสนุนการขาย<br>(Sample Request)</b></h3></center>
		</td>
		<td style="width:25%;" valign="bottom">
			<div align="right"><?php echo $smp_no;?></div>
			<div align="right"><?php echo barcode($smp_no);?></div>
		</td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td>Customer Name : <?php echo $customer_name; ?> </td>
		<td style="text-align:right;">Date : <?php echo $smp_date; ?></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td>Address : <?php echo $address_name; ?></td>
	</tr>
</table>
<table border= "1" width="100%">
<tr>
<th width="20%">เคลียร์ยืม</th>
<th width="5%" align="center">ITEM</th>
<th width="20%">Code</th>
<th width="50%" align="center">Description</th> 
<th width="15%" align="center">SN</th> 
<th width="15%" align="center">QTY</th> 
<th width="10%" align="center">Amount</th> 
</tr>
<?php
$strSQL1 = "SELECT * FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$ref_idsmp."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1)) {
	$sum_amount1  =$objResult1["sum_amount"];
	$sum_amount= number_format( $sum_amount1,2)."";
	$product_code=$objResult1["access_code"];
	$product_name  =$objResult1["sol_name"];
	$sale_count  =$objResult1["sale_count"];
	$unit_name  =$objResult1["unit_name"]; 
	$clear_br  =$objResult1["clear_br"];
	$br_no  =$objResult1["br_no"];
	
	?>
	<tr>
		<td align="center"><?php if($clear_br=='1'){ ?> <input type="checkbox" checked> <? } ?> <br><?php echo $br_no;?></td>
		<td align="center"><?php echo $i;?></td>
		<td align="left"><?php echo $product_code;?> </td>
		<td align="left" style="padding-left:5px;"><?php echo $product_name;?> </td>
				<td align="left" style="padding-left:5px;"><?php echo $objResult1["sn"];;?> </td>
		<td align="right" style="padding-right:5px;"><?php echo $sale_count;?>  <?php echo $unit_name;?></td>
		<td align="right" style="padding-right:5px;"><?php echo $sum_amount;?></td>
	<?php $i++;} ?>
	</tr>
	<?php if($Num_Rows1 < 8) {
		for($y=$Num_Rows1+1;$y<=8;$y++) { ?>
			<tr>
				<td align="center"></td>
				<td align="center"><?php echo $y; ?></td>
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
		<td style="width:50%;text-align:right;border-right:0px;">Total</td>
		<td style="width:50%;text-align:right;border-left:0px;padding-right:5px;"><?php echo $summary;?></td> 
	</tr>
</table>
	
	<table  border= "1" width="100%" >
		<tr>
			<td style="width:10%;">วันที่     <u><?php echo $delivery_date; ?></u> เวลา       <u><?php echo $delivery_time; ?></u></p>
	
				<?php if ($want_bus  =='1'){ ?><input type="checkbox" checked>   <span >ต้องการรถใหญ่</span><?php }else{ ?>	<input type="checkbox">   <span >ต้องการรถใหญ่</span>	<?php } ?>
					<input type="checkbox">   <span >มีแผนที่ประกอบ</span></p>
			
					<?php if ($call_customer  =='1'){ ?><input type="checkbox" checked></a>   <span >แจ้งลูกค้าก่อนส่ง</span>	<?php }else{ ?><input type="checkbox">   <span >แจ้งลูกค้าก่อนส่ง<?php } ?>
					<?php if ($fix_date  =='1'){ ?><input type="checkbox" checked>   <span >นัดวันและเวลาเรียบร้อยแล้ว</span><?php }else{ ?>	<input type="checkbox">   <span >นัดวันและเวลาเรียบร้อยแล้ว</span>	<?php } ?>
		</td>
				</tr>
			</table>
<table style="width:100%;" border="0">
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="height:50px;padding-left:5px;">Comment : <?php echo $comment_sale; ?>
		<br><input type="checkbox" checked>
<font color='red'><?php echo $order_no; ?></font><br>
		<font color='red'><?php echo $sn_old; ?></font><br>
		<font color='red'><?php echo $sn_; ?></font></td>
		
	</tr>
</table>
<table style="width:100%;" border="0">
	<tr style="border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black">
		<td style="width:70%;border-right:0px;"></td>
		<td style="width:30%;border-left:0px;"><center><u><?php echo $sale_name; ?><?php echo "("; echo $sale_code; echo ")"; ?><?php echo "/"; ?><?php echo $sale_date; ?></u><br>Sale/Date</center> </td>
	</tr>
</table>
<?php if($send_dm=='1'){ ?>
<table style="width:100%;" border="0">
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="height:50px;padding-left:5px;">Comment : <?php echo $comment_dm; ?></td>
	</tr>
</table>
<?php if($dm_name !=''){ ?>
<table style="width:100%;" border="0">
	<tr style="border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">
		<td style="width:70%;border-right:0px;"><?php if($status_dm=='Approve'){ ?><input type="checkbox" checked='checked' > Yes <input type="checkbox" > No <?php }
				else if($status_dm=='Rejected'){ ?><input type="checkbox" > Yes <input type="checkbox" checked='checked' > No<?php }
				else{ ?><input type="checkbox"  > Yes <input type="checkbox" > No <?php } ?>
		</td>
		<td style="width:30%;text-align:center;border-left:0px;">
			<u><?php echo $dm_name; ?><?php echo "/"; ?><?php echo $dm_date; ?></u><br>Authorized/Date
		</td>
	</tr>
</table>
<?php } }?>
<table style="width:100%" border="0">
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="height:50px;padding-left:5px;">Comment : <?php echo $comment_sup; ?></td>
	</tr>
</table>
<table style="width:100%" border="0">
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="width:70%;border-right:0px;"><?php if($status_sup=='Approve'){ ?><input type="checkbox" checked='checked' > Yes <input type="checkbox" > No<?php }
				else if($status_sup=='Rejected'){ ?><input type="checkbox"  > Yes <input type="checkbox" checked='checked' > No<?php }
				else{ ?><input type="checkbox"  > Yes <input type="checkbox" > No<?php } ?>
		</td>
		<td style="width:30%;text-align:center;border-left:0px;">
			<u><?php echo $sup_name; ?><?php echo "/"; ?><?php echo $sup_date; ?></u><br>Authorized/Date
		</td>
	</tr>
</table>
<table style="width:100%;" border="1">
	<tr style="border-bottom:0px;">
		<td style="width:50%;text-align:center;border-right:0px;">ผู้จ่ายสินค้า<br>(<u><?php echo $stock_name; ?></u>)<br>วันที่ <u><?php echo $stock_date; ?></u></td>
		<td style="width:50%;text-align:center;border-left:0px;" valign="top">บัญชี</td>
	</tr>
</table>
<br><br>

	<?php

$qfirst = "select * from st__signature where ref_id = '".$ref_idsmp."'";
$first = mysqli_query($conn,$qfirst);
$ffirst = mysqli_fetch_array($first);

$qfirst1 = "select name,surname from tb_user where em_id = '".$ffirst["en_code"]."'";
$first1 = mysqli_query($conn,$qfirst1);
$ffirst1 = mysqli_fetch_array($first1);

$qfirst2 = "select name,surname from tb_user where em_id = '".$ffirst["cs_code"]."'";
$first2 = mysqli_query($conn,$qfirst2);
$ffirst2 = mysqli_fetch_array($first2);

	?>

			<table style="width:100%;">
	
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
		<td style="width:33%;text-align:center;"><span>วันที่ <?php echo $ffirst["stock_dt"]; ?></span></td>
		<td style="width:33%;text-align:center;">วันที่ <?php echo $ffirst["en_dt"]; ?></td>
		<td style="width:33%;text-align:center;">วันที่ <?php echo $ffirst["cs_dt"]; ?></td>
		</tr>
</table>
<br>



<table style="width:100%;">
	<tr>
		<td>อนุมัติวันที่ 16 ม.ค. 2561</td>
		<td style="text-align:right;"><?php if($type_company =='1') { echo "FM-SA-03:Rev.1"; } else { echo "160161:Rev.1"; } ?></td>
	</tr>
</table>
<?php echo $date ; ?>
<!---------------------------------------------------------END------------------------------------------------------------------------------------>
</div>
</body>
</html>