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
.style35 {font-size: 10.5px; color: #000000; }
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
include"dbconnect.php";


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

$ref_id_br=$_GET["ref_id_br"];


include"dbconnect.php";

$strSQL = "SELECT * FROM  in__br WHERE ref_id_br = '".$ref_id_br."' ";
//echo  $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM (in__subbr LEFT JOIN tb_product ON in__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL3 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_id_br."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);


$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM in__subbr WHERE ref_idd_br = '".$ref_id_br."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";

$strSQL11 = "SELECT * FROM tb_other_bill WHERE ref_id  = '".$ref_id_br."' ";
$objQuery11 = mysqli_query($conn,$strSQL11) or die(mysqli_error());
$objResult11 = mysqli_fetch_array($objQuery11);


$month = date('m');
$day = date('d');
$year = date('Y');

$today1 = $year . '-' . $month . '-' . $day;
$today=DateThai($today1);


$ref_id_br=$objResult["ref_id_br"];
$dep_no =$objResult["dep_no"];
$job_no =$objResult["job_no"];
$iv_no =$objResult["iv_no"];
$company = $objResult["company"];
$customer=$objResult["customer"];
$address =$objResult["address"];
$delivery_name =$objResult["delivery_name"];
$delivery_address =$objResult["delivery_address"];
$delivery_contact =$objResult["delivery_contact"];
$delivery_tel =$objResult["delivery_tel"];
$delivery_contact1="$delivery_contact / $delivery_tel";
$date_br = DateThai($objResult["date_br"]);
$objective =$objResult["objective"];
$objective_des1 = $objResult["objective_des1"];
$objective_des2 = $objResult["objective_des2"];
$objective_des4 = $objResult["objective_des4"];
$objective_des5 = $objResult["objective_des5"];
$sn_ckk=$objResult["sn_ckk"];
$sn =$objResult["sn"];
$delivery_type = $objResult["delivery_type"];
$sale_comment = $objResult["sale_comment"];

if($objResult["date_send_key"]!=''){
$delivery_date=$objResult["date_send_key"];
}else{
$delivery_date=DateThai($objResult["delivery_date"]);
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


if($objResult11["ref_1"]=='1'){
$ref_1 ="1.เตรียมเอกสาร N-Health";
}else{
$ref_1 ="";	
}

if($objResult11["ref_2"]=='1'){
$ref_2 ="2.เตรียมเอกสารตามสเปคใบเสนอราคา";
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
$ref_11des = $objResult11["ref_11des"];
$ref_11 ="11.ใบประเมินสินค้า จำนวน $ref_11des";
}else{
$ref_11 ="";	
}


if($objResult11["ref_10"]=='1'){
$ref_des = $objResult11["ref_des"];
$ref_10 ="อื่น ๆ $ref_des";
}else{
$ref_10 ="";	
}
?>



<div class="Section2 page">
<body>
<table style="width:100%;">
	<tr>
		<td valign="bottom" style="width:20%;">เลขที่อ้างอิง <u> <span class="style38"><?php echo $ref_id_br; ?></span></u></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td valign="top" style="width:20%;"><input type="checkbox"> ก <input type="checkbox"> C</td>
		<td valign="top" style="text-align:center; width:60%;"><font size="5">ใบสั่งพิมพ์ใบเบิกจ่ายสินค้า</font><br><font size="4">(Request for issuing stock movement order)</font></td>
		<?php if($company=='1'){ ?>
	<td valign="top" style="width:20%;"></td>
	<?php }else if($company=='2'){ ?>
		<td valign="top" style="width:20%;"><img src="img/nb_logo.jpg" width="80" align="right" height="30" /></td>
		<?php } ?>
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
		<td><div align="right" class="style38"><?php echo $iv_no;?></div><div align="right"><?php echo barcode($iv_no);?></div></td>
	</tr>
</table>

<table border="1" width="100%">
<tr>
<td style="width:50%;" valign="top">
	<table style="width:100%;">
		<tr>
			<td style="width:30%;"><span>ชื่อลูกค้า/รพ. </span></td>
			<td style="border-bottom: 1px solid black;width:70%;"><span class="style38"><?php echo $customer; ?></span></td>
		</tr>
		<tr>
			<td><span>ทีอยู่</span></td>
			<td style="border-bottom: 1px solid black;width:70%;"><span class="style38"><?php echo $address; ?></span><span class="style38"><?php echo $province_id; ?></span><span class="style38"><?php echo $zip_code; ?></span></td>
		</tr>
	</table>
	<hr>
	<table style="width:100%;">
		<tr>
			<td style="width:30%;"><span>สถานที่ส่งสินค้า </span></td>
			<td style="border-bottom: 1px solid black;width:70%;"><span class="style38"><?php echo  $address_1; ?> <?php echo  $address_name; ?></span></td>
		</tr>
		<tr>
			<td><span>Ward/ชั้น/ตึก </span></td>
			<td style="border-bottom: 1px solid black;width:70%;"><span class="style38"><?php echo $address_send; ?></span></td>
		</tr>
		<tr>
			<td><span>ชื่อผู้ติดต่อ/โทร</span></td>
			<td style="border-bottom: 1px solid black;width:70%;"><span class="style38"><?php echo $delivery_contact1; ?></span></td>
		</tr>
	</table>
</td>
<td>
	<table style="width:100%;">
		<tr>
			<td style="width:20%;"><span>วันที่ </span></td>
			<td style="width:30%;"><span class="style38"><?php echo  $date_br; ?></span></td>
			<td style="width:20%;"><span>เลขที่ </span></td>
			<td style="width:30%;"><span class="style38"><?php echo $iv_no; ?></span></td>
		</tr>
	</table>
	<hr>
	<span>วัตถุประสงค์การเบิก </span><br>
	<?php if($objective=='1'){ ?>
		<input type="checkbox" checked> เป็นสินค้าสำรอง 
		<?php }else{ ?>
		<input type="checkbox"> เป็นสินค้าสำรอง 
	<?php } ?>
		<u><span><?php if($objective_des1!='') { echo $objective_des1; } else { echo ' *-*'; } ?></span></u><br>
	<?php if($objective=='2'){ ?>
		<input type="checkbox" checked> สำหรับลูกค้าทดลองใช้ 
	<?php }else{ ?>
		<input type="checkbox"> สำหรับลูกค้าทดลองใช้ 
	<?php } ?>
	<u><span><?php if($objective_des2=='') { echo " *-*"; } else { echo ' '.$objective_des2.' '; } ?></span></u><span> วัน</span><br>
	<?php if($objective=='3'){ ?>
		<input type="checkbox" checked>ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ<br>
	<?php }else{ ?>
		<input type="checkbox">ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ<br>
	<?php } ?>
	<?php if($objective=='4'){ ?>
		<input type="checkbox" checked>แลกเปลี่ยนสินค้า ตามใบงานบริการเลขที่
	<?php }else{ ?>
		<input type="checkbox">แลกเปลี่ยนสินค้า ตามใบงานบริการเลขที่ 
	<?php } ?>
	
	<u><span><?php if($objective_des4!='') { echo $objective_des4; } else { echo ' *-*'; }?></span></u><span>*</span><br>
	<span><font size="2px">(เฉพาะกรณีแลกเปลี่ยนสินค้าที่มีหมายเลขเครื่องต้องระบุเลขที่ใบงานบริการทุกครั้ง)</font></span><br>
	<?php if($objective=='6'){ ?>
		<input type="checkbox" checked>สินค้าฝากขาย (มีใบรับประกัน)
	<?php }else{ ?>
		<input type="checkbox">สินค้าฝากขาย (มีใบรับประกัน) 
	<?php } ?><br>
	<?php if($objective=='5'){ ?>
		<input type="checkbox" checked>อื่นๆ
	<?php }else{ ?>
		<input type="checkbox">อื่นๆ
	<?php } ?>
	<?php if($objective_des5!='') { echo $objective_des5; } else { echo ' *-* '; } ?>
</td>
</tr>
</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10" align="center" class="style30">ลำดับ</td>
<td width="50" align="center" class="style30">รหัสสินค้า</td>
<td width="80" align="center" class="style30">รายละเอียด</td> 
<td width="30" align="center" class="style30">จำนวน</td> 
<td width="30" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="30" align="center" class="style30">ยอดรวม</td> 


</tr>

<?php

$strSQL1 = "SELECT * FROM (in__subbr LEFT JOIN tb_product ON in__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["amount"];
$sum_amount= number_format( $sum_amount1,2)."";
$price_per_unit_1  =$objResult1["price"];
$price_per_unit= number_format( $price_per_unit_1,2)."";
$product_code  =$objResult1["express_code"];
$product_name  =$objResult1["sol_name"];
$sale_count  =$objResult1["count"];
$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];
$product = "$product_name:$sale_remark";

/*echo barcode($product_code)."<br>";
echo $product_code."<br>";*/
?>
	<tr>
<td align="center" class="style38"><?php echo $i;?></td>
<td align="center" class="style38"><?php 
		echo $product_code;

?></td>
<td align="left" class="style38"><?php echo $product;?> </td>
<td align="right" class="style38"><?php echo $sale_count;?>  <?php echo $unit_name;?></td>
<td align="right" class="style38"><?php echo $price_per_unit;?></td>
<td align="right" class="style38"><?php echo $sum_amount;?></td>



<?php
$i++;
}

?>
</tr>
</table>
<table border= "1" width="100%" class='w3-table'>

<tr>
<td>

<?php
if ($sn_ckk=='1'){
?>
<input type="checkbox" checked><span>ต้องการ</span>
<?php
}else{
	?>
	<input type="checkbox"><span>ต้องการ</span>


		<?php
		}
		?>
<span>Serial No.</span><u><span class="style38"><?php echo $sn; ?></span></u><br>


</td>
</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td style="width:50%;text-align:right;border:none;" >Total : </td>
<td style="width:50%;text-align:right;text-padding:right;border:none;" class="style38"><?php echo $summary;?></td>
</tr>

</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td style="width:50%;" valign="top">
	<table style="width:90%;border:none;">
		<tr>
			<td valign="top" style="width:50%;">
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
			<td style="width:10%;"><span>วันที่ </span></td><td style="width:40%;"><u><span class="style38"><?php echo $delivery_date; ?></span></u></td><td style="width:10%;"><span> เวลา </span></td><td style="width:40%;"><u><span class="style38"><?php echo $delivery_time; ?></span></u></td>
		</tr>
	</table>
	<table style="width:90%;">
		<tr>
			<td style="width:50%;">
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

<span>หมายเหตุ </span><br /><span><u><?php echo $sale_comment; ?> <?php echo $ref_1; ?> <?php echo $ref_2; ?> <?php echo $ref_3; ?> <?php echo $ref_4; ?> <?php echo $ref_5; ?> <?php echo $ref_6; ?> <?php echo $ref_7; ?> <?php echo $ref_8; ?> <?php echo $ref_9; ?> <?php echo $ref_10; ?> <?php echo $ref_11; ?></u></span>
</td>
<td  style="width:50%;" valign="top">
<?php
if ($returns =='1'){ ?>
<input type="checkbox" checked><span >รับสินค้าคืน</span><br>
<span >วันที่รับคืน : </span><span class="style38"><u><?php echo $returns_date; ?></u></span><br>
<span >เวลาที่รับคืน : </span><span class="style38"><u><?php echo $returns_time; ?></u></span><br>

<span >Ward/ชั้น/ตึก : </span><span class="style38"><u><?php echo $returns_address; ?></u></span>
<span >.</span><br>
<span >ชื่อผู้ติดต่อ/โทร : </span><span class="style38"><u><?php echo $returns_contact; ?></u></span>
<span ></span><br>
<span class="style38"><u><?php echo $returns_name; ?></u></span>
<?php } else{ ?>
	<input type="checkbox"><span >รับสินค้าคืน</span> 
<?php	} ?>
</td>
</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td style="width:50%;text-align:center;border:none;"><span >ผู้เบิกสินค้า</span></td>
<td style="width:50%;text-align:center;border:none;"><span >ผู้อนุมัติ</span></td>
</tr>
<tr>
<td style="text-align:center;border:none;"><span >(</span><u><span ><?php echo $sale_code; ?></span></u><span >)</span></td>
<td style="text-align:center;border:none;"><span >(</span><u><span ><?php echo $approve; ?></span></u><span >)</span></td>
</tr>
<tr>
<td style="text-align:center;border:none;"><span >วันที่</span><u><span ><?php echo $sale_date; ?></span></u></td>
<td style="text-align:center;border:none;"><span >วันที่<u><?php echo $approve_date; ?></u></span></td>
</tr>
</table>
</p>
	<?php

$qfirst = "select * from st__signature where ref_id = '".$ref_id."'";
$first = mysqli_query($new,$qfirst);
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


<table border="0" style="width:100%;">
	<?php if($company=='1'){ ?>
<tr>
<td style="width:50%;text-align:left"><span>อนุมัติวันที่ 15 กุมภาพันธ์ 2566</span></td>
<td style="width:50%;text-align:right;"><span>FM-SA-02:Rev.11</span></td>
</tr>
<?php
}
if($company=='2'){ ?>	
<tr>
<td style="width:50%;text-align:left"><span>อนุมัติวันที่ 15 กุมภาพันธ์ 2566</span></td>
<td style="width:50%;text-align:right;"><span>150266:Rev.11</span></td>
</tr>	
<?php } ?>
</table>

<br>
</body>

</html>
