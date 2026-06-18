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
//include"dbconnect.php";
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

$ref_id =$_GET["ref_id"];

include"dbconnect.php";

$strSQL = "SELECT * FROM  hos__change WHERE ref_id = '".$ref_id."' ";
//echo  $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM (hos__subchange LEFT JOIN tb_product ON hos__subchange.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL3 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_id."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);

$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subchange WHERE ref_idd = '".$ref_id."' and count_sale !='0' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$strSQL16 = "SELECT SUM(amount) AS amount_1 FROM hos__subchange WHERE ref_idd = '".$ref_id."' and count_stock !='0' ";
$objQuery16 = mysqli_query($conn,$strSQL16);
$objResult16 = mysqli_fetch_array($objQuery16);

$summary_stock=$objResult16['amount_1'];
$summary_sale=$objResult15['amount_1'];

$summary_1 = $summary_sale-$summary_stock;

$summary= number_format( $summary_1,2)."";



$month = date('m');
$day = date('d');
$year = date('Y');

$today1 = $year . '-' . $month . '-' . $day;
$today=DateThai($today1);


$ref_id_br=$objResult["ref_id"];
$dep_no =$objResult["dep_no"];
$job_id =$objResult["job_no"];
$iv_no =$objResult["iv_no"];
$customer=$objResult["customer"];
$address =$objResult["address"];
$delivery_name =$objResult["delivery_name"];
$delivery_address =$objResult["delivery_address"];
$delivery_contact =$objResult["delivery_contact"];
$delivery_tel =$objResult["delivery_tel"];
$delivery_contact1="$delivery_contact / $delivery_tel";
$date_br = DateThai($objResult["iv_date"]);
$objective =$objResult["objective"];
$objective_des = $objResult["objective_des"];
$add_by = $objResult["add_by"];
$sn_ckk=$objResult["sn_ckk"];
$sn =$objResult["sn"];
$delivery_type = $objResult["delivery_type"];
$sale_comment = $objResult["sale_comment"];

if($objResult["delivery_date"]!='0000-00-00'){
$delivery_date=DateThai($objResult["delivery_date"]);
}else{
$delivery_date=$objResult["date_send_key"];
}
$delivery_time =$objResult["delivery_time"];
$returns  = $objResult["returns"];

if($objResult["returns_date"]!=''){
$returns_date = DateThai($objResult["returns_date"]);
}else{
$returns_date = $objResult["return_date_bet"];

}

$returns_time = $objResult["returns_time"];
$returns_name = $objResult["returns_name"];
$returns_address = $objResult["returns_address"];
$returns_contact = $objResult["returns_contact"];
$sale_code = $objResult["sale_code"];
$sale_date = DateThai($objResult["sale_date"]);
$approve = $objResult["approve"];
$approve_date = DateThai($objResult["approve_date"]);

$want_bus  = $objResult3['want_bus'];
$call_customer  = $objResult3['call_customer'];
$fix_date  = $objResult3['fix_date'];
$address_name = $objResult3['address_name'];
$address_1 = $objResult3['address_1'];
$address_send = $objResult3['address_send'];

?>
<div class="Section2 page">
<body>
<table style="width:100%;">
	<tr>
		<td valign="bottom" style="width:20%;">เลขที่อ้างอิง <u><?php echo $ref_id_br; ?></u></td>
		<td valign="bottom" style="width:40%;"><?php echo $time_delivery; echo $packing_remark; ?></td>
		<td valign="bottom" style="width:40%;text-align:right;"><font size=5><b><?php echo $delivery_name; ?></b></font></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td valign="top" style="width:20%;"><input type="checkbox"> ก <input type="checkbox"> C</td>
		<td valign="top" style="text-align:center; width:60%;"><font size="5">ใบสั่งพิมพ์ใบเบิกจ่ายสินค้า</font><br><font size="4">(Request for issuing stock movement order)</font></td>
		<td valign="top" style="width:20%;"><img src="img/nb_logo.jpg" width="80" align="right" height="30" /></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td ></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td>ฝากสินค้าเลขที่ <u><?php echo $deposit_no; ?></u></td>
		<td>เลขที่ลงงาน <u><?php echo $job_id; ?></u></td>
		<td><div align="right"><?php echo $iv_no;?></div><div align="right"><?php echo barcode($iv_no);?></div></td>
	</tr>
</table>
<table border="1" width="100%">
<tr>
<td style="width:50%;" valign="top">
	<table style="width:100%;">
		<tr>
			<td style="width:30%;"><span>ชื่อลูกค้า/รพ. </span></td>
			<td style="border-bottom: 1px solid black;width:70%;"><span><?php echo $customer; ?></span></td>
		</tr>
		<tr>
			<td><span>ทีอยู่</span></td>
			<td style="border-bottom: 1px solid black;width:70%;"><span><?php echo $address; ?><span></span><?php echo $province_id; ?></span><span><?php echo $zip_code; ?></span></td>
		</tr>
	</table>
	<hr>
	<table style="width:100%;">
		<tr>
			<td style="width:30%;"><span>สถานที่ส่งสินค้า </span></td>
			<td style="border-bottom: 1px solid black;width:70%;"><span><?php echo  $address_1; ?> <?php echo  $address_name; ?></span></td>
		</tr>
		<tr>
			<td><span>Ward/ชั้น/ตึก </span></td>
			<td style="border-bottom: 1px solid black;width:70%;"><span><?php echo $address_send; ?></span></td>
		</tr>
		<tr>
			<td><span>ชื่อผู้ติดต่อ/โทร</span></td>
			<td style="border-bottom: 1px solid black;width:70%;"><span><?php echo $delivery_contact1; ?></span></td>
		</tr>
	</table>
</td>
<td valign="top">
	<table style="width:100%;">
		<tr>
			<td style="width:20%;"><span>วันที่ </span></td>
			<td style="width:30%;"><span><?php echo  $date_br; ?></span></td>
			<td style="width:20%;"><span>เลขที่ </span></td>
			<td style="width:30%;"><span><?php echo $iv_no; ?></span></td>
		</tr>
	</table>
	<hr>
	<span>วัตถุประสงค์การเบิก </span><br>
			<input type="checkbox"> เป็นสินค้าสำรอง 
		<u><span><?php if($objective_des1!='') { echo $objective_des1; } else { echo ' *-*'; } ?></span></u><br>
	
		<input type="checkbox" > สำหรับลูกค้าทดลองใช้ 
		<u><span><?php if($objective_des2=='') { echo " *-*"; } else { echo ' '.$objective_des2.' '; } ?></span></u><span> วัน</span><br>
	
		<input type="checkbox">ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ<br>
	
	<?php if($objective=='1'){ ?>
		<input type="checkbox" checked>แลกเปลี่ยนสินค้า 
	<?php }else{ ?>
		<input type="checkbox">แลกเปลี่ยนสินค้า 
	<?php } ?>
	<u><span><?php if($objective_des!='') { echo $objective_des; } else { echo ' *-*'; }?></span></u><span>*</span><br>
	<span><font size="2px">(เฉพาะกรณีแลกเปลี่ยนสินค้าที่มีหมายเลขเครื่องต้องระบุเลขที่ใบงานบริการทุกครั้ง)</font></span><br>
	
		<input type="checkbox">อื่นๆ
	
</td>
</tr>
</table>

<table border= "1" style="width:100%;border-top:0px;">
<tr>
<td width="5%" align="center">ลำดับ</td>
<td width="20%" align="center">รหัสสินค้า</td>
<td width="45%" align="center">รายละเอียด</td> 
<td width="10%" align="center">แลกเข้า</td> 
<td width="10%" align="center">แลกออก</td> 
<td width="10%" align="center">ราคา/หน่วย</td> 
<td width="10%" align="center">ยอดรวม</td> 
</tr>
<?php

$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
$sum_amount1  =$objResult1["amount"];
$sum_amount= number_format( $sum_amount1,2)."";
$price_per_unit_1  =$objResult1["price"];
$price_per_unit= number_format( $price_per_unit_1,2)."";
$product_code  =$objResult1["express_code"];
$product_name  =$objResult1["sol_name"];
$count_sale  =$objResult1["count_sale"];
$count_stock  =$objResult1["count_stock"];
$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];
$product = "$product_name:$sale_remark";
/*echo barcode($product_code)."<br>";
echo $product_code."<br>";*/
?>
<tr>
<td align="center"><?php echo $i;?></td>
<td align="center"><?php 
		echo $product_code;

?></td>
<td style="text-align:left;padding-left:3px;"><?php echo $product;?> </td>
<td style="text-align:right;padding-right:3px;"><?php if($count_stock !='0.00'){ echo '-'; echo $count_stock; ?>  <?php echo $unit_name; }?></td>
<td style="text-align:right;padding-right:3px;"><?php if($count_sale !='0.00'){ echo $count_sale;?>  <?php echo $unit_name; }?></td>
<td style="text-align:right;padding-right:3px;"><?php echo $price_per_unit;?></td>
<td style="text-align:right;padding-right:3px;"><?php echo $sum_amount;?></td>
<?php
$i++; } ?>
</tr>
</table>
<table border= "1" style="width:100%;border-top:0px;border-bottom:0px;">
<tr>
<td>
<?php if ($sn_ckk=='1'){ ?><input type="checkbox" checked><span>ต้องการ</span><?php }else{ ?><input type="checkbox"><span>ต้องการ</span><?php } ?><span>Serial No.</span><u><span><?php echo $sn; ?></span></u>
</td>
<td style="width:19.9%;text-align:right;border:none;padding-right:3px;">Total : <?php echo $summary;?></td>
</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>

</tr>

</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td style="width:50%;" valign="top">
	<table style="width:100%;border:none;">
		<tr>
			<td valign="top" style="width:40%;">
				<?php
					if ($delivery_type =='4'){

					?>
					<input type="checkbox" checked><span >บริษัทจัดส่ง</span>
						<?php }else{
							?>
						<input type="checkbox"><span >บริษัทจัดส่ง</span>
								<?php
						}
					?>	
			</td>
			<td>
					<?php
					if ($delivery_type =='2'){
					?>
					<input type="checkbox" checked><span >Engineer รับเอง</span>
						<?php }else{
							?>
						<input type="checkbox"><span >Engineer รับเอง</span>

								<?php
						}
								?>
			</td>
		</tr>
		<tr>
			<td>
					<?php
					if ($delivery_type =='1'){

					?>
					<input type="checkbox" checked><span >Sale รับเอง</span>
						<?php }else{
							?>
						<input type="checkbox"><span >Sale รับเอง</span>

								<?php
						}
								?>
			</td>
			<td>
					<?php
					if ($delivery_type =='3'){

					?>
					<input type="checkbox" checked><span >ลูกค้ารับเอง</span>
						<?php }else{
							?>
						<input type="checkbox"><span >ลูกค้ารับเอง</span>

								<?php
						}
								?>
			</td>
		</tr>
	</table>
	<table style="width:90%;">
		<tr>
			<td style="width:10%;"><span>วันที่ </span></td><td style="width:40%;"><u><span><?php echo $delivery_date; ?></span></u></td><td style="width:10%;"><span> เวลา </span></td><td style="width:40%;"><u><span><?php echo $delivery_time; ?></span></u></td>
		</tr>
	</table>
	<table style="width:100%;">
		<tr>
			<td style="width:40%;">
					<?php
					if ($want_bus =='1'){

					?>
					<input type="checkbox" checked><span >ต้องการรถใหญ่</span>
						<?php }else{
							?>
						<input type="checkbox"><span >ต้องการรถใหญ่</span>

								<?php
						}
								?>
					<br>

					<?php
					if ($maps =='1'){

					?>
					<input type="checkbox" checked><span >มีแผนที่ประกอบ</span>
						<?php }else{
							?>
						<input type="checkbox"><span >มีแผนที่ประกอบ</span>

								<?php
						}
								?>
				</td>
				<td>
						<?php
						if ($call_customer =='1'){

						?>
						<input type="checkbox" checked><span >โทรแจ้งลูกค้าก่อนไป</span>
							<?php }else{
								?>
							<input type="checkbox"><span >โทรแจ้งลูกค้าก่อนไป</span>

									<?php
							}
									?>
						<br>
						<?php
						if ($fix_date =='1'){

						?>
						<input type="checkbox" checked><span >นัดวันและเวลาเรียบร้อยแล้ว</span>
							<?php }else{
								?>
							<input type="checkbox"><span >นัดวันและเวลาเรียบร้อยแล้ว</span>

									<?php
							}
									?>
				</td>
			</tr>
	</table>
<span>หมายเหตุ </span><br /><span><u><?php echo $sale_comment; ?></u></span>
</td>
<td  style="width:50%;" valign="top">
<?php
if ($returns =='1'){ ?>
<input type="checkbox" checked><span >รับสินค้าคืน</span><br>
<span >วันที่รับคืน : </span><span><u><?php echo $returns_date; ?></u></span><br>
<span >เวลาที่รับคืน : </span><span><u><?php echo $returns_time; ?></u></span><br>

<span >Ward/ชั้น/ตึก : </span><span><u><?php echo $returns_address; ?></u></span>
<span >.</span><br>
<span >ชื่อผู้ติดต่อ/โทร : </span><span><u><?php echo $returns_contact; ?></u></span>
<span ></span><br>
<span><u><?php echo $returns_name; ?></u></span>
<?php } else{ ?>
	<input type="checkbox"><span >รับสินค้าคืน</span> 
<?php	} ?>
</td>
</tr>
</table>

<table border="1" style="width:100%;border-top:0px;">
<tr>
<td style="width:50%;text-align:center;border:none;"><span >ผู้เบิกสินค้า</span></td>
<td style="width:50%;text-align:center;border:none;"><span >ผู้อนุมัติ</span></td>
</tr>
<tr>
<td style="text-align:center;border:none;"><span >(</span><u><span ><?php echo $add_by; ?></span></u><span >)</span></td>
<td style="text-align:center;border:none;"><span >(</span><u><span ><?php echo $approve; ?></span></u><span >)</span></td>
</tr>
<tr>
<td style="text-align:center;border:none;"><span >วันที่</span><u><span ><?php echo $sale_date; ?></span></u></td>
<td style="text-align:center;border:none;"><span >วันที่<u><?php echo $approve_date; ?></u></span></td>
</tr>
</table>
<table border="0" style="width:100%;" class="tablel">
<tr>
<td style="width:50%;text-align:left"><span>อนุมัติวันที่ 8 พฤษภาคม 2563 </span></td>
<td style="width:50%;text-align:right;"><span>FM-SA-02:Rev.10</span></td>
<!--td style="width:50%;text-align:right;"><span>290859:Rev.9</span></td-->
</tr>
</table>
</body>
</div>
</html>