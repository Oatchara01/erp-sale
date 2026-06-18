

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
.style38 {color: #f2f2f2 }
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



<?php

include "error_page.php";

//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment; filename=testing.doc");


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

$sale_channel =$_GET["sale_channel"];

$register_date =$_GET["register_date"];
$iv_no =$_GET["iv_no"];



include"dbconnect.php";

$strSQL = "SELECT * FROM ((so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID) WHERE sale_channel = '".$sale_channel."'  and iv_no  ='".$iv_no."'";

//echo $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);


$month = date('m');
$day = date('d');
$year = date('Y');

$today1 = $year . '-' . $month . '-' . $day;
$today=DateThai($today1);


$ref_id=$objResult["ref_id"];
$delivery =$objResult["delivery"];
$time_send =$objResult["time_send"];
$description_wrap=$objResult["description_wrap"];
$time_description="$time_send $description_wrap";
$job_id =$objResult["job_id"];
$date = date('d-m-Y H:i:s');
$prefer_name = $objResult["prefer_name"];
$register_date=DateThai($objResult["register_date"]);


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
$delivery_date  =DateThai($objResult["delivery_date"]);


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

$with_pr   =  $objResult["with_pr"];
$clear_book_no   =  $objResult["clear_book_no"];
$clear_brn_no   =  $objResult["clear_brn_no"];
$clear_brnp_no   =  $objResult["clear_brnp_no"];



$time_delivery=$objResult["time_delivery"];
$packing_remark =$objResult["packing_remark"];
$deposit_no  =$objResult["deposit_no"];

$clear_book_ckk   =  $objResult["clear_book_ckk"];
$clear_brn_no_ckk   =  $objResult["clear_brn_no_ckk"];
$clear_brnp_no_ckk   =  $objResult["clear_brnp_no_ckk"];

$delivery_contact  =  $objResult["delivery_contact"];
$delivery_name =   $objResult["delivery_name"];
$tel =   $objResult["tel"];
$payment_name =   $objResult["payment_name"];
$payment = $objResult["payment"];
$province_id = $objResult["province_id"];
$prefor_name = $objResult["prefor_name"];
?>


	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;ก&nbsp;
	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;C
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style33"><?php echo $time_delivery; echo $packing_remark; ?></span>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $delivery_name; ?>

</p>

<center>
<span class="style15">ใบสั่งขาย</span><br>

<span class="style15">(SALES ORDER)</span>
</center>






<span class="style39">เลขที่อ้างอิง</span> <u><span class="style39"><?php echo $ref_id; ?></span></u>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39">ฝากส่งสินค้าเลขที่</span> <u><span class="style39"><?php echo $deposit_no; ?></span></u>

<br>

<span class="style39">เลขที่ลงงาน</span> <u><span class="style39"><?php echo $job_id; ?></span></u>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39">วันที่</span> <span class="style39"><?php echo $register_date; ?> &nbsp;<?php echo $register_time ; ?></span>



<br>
<span class="style33" align="right"><div align="right"><?php echo $iv_no;?></div></span>
<div align="right"><?php echo barcode($iv_no);?></div>
<span class="style40">ชื่อผู้แนะนำ/รพ./แผนก </span>&nbsp;&nbsp;<span class="style39"><?php echo $prefor_name; ?></span>&nbsp;&nbsp;<hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">ชื่อที่ต้องการออกบิล </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $billing_name; ?></span>&nbsp;&nbsp;<hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">ที่อยูที่ต้องการออกบิล </span>&nbsp;&nbsp;<span class="style39" ><?php echo $billing_address; ?></span><hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">เบอร์โทร </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $billing_tel; ?></span>&nbsp;&nbsp;
<hr color="black"  width="80%" size="0.1" align="right"><span class="style40">สถานที่ส่งสินค้า </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $delivery_place; ?></span>&nbsp;&nbsp;<hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">ชื่อผู้ติดด่อ/โทร </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $delivery_contact; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style40">เบอร์โทร</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $tel; ?></span>&nbsp;&nbsp;

<hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">ใบสั่งซื้อเลขที่</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $po_no; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style40">กำหนดส่งตามสัญญา</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $delivery_contract; ?></span>&nbsp;&nbsp;
<hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">ชำระโดย </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<?php
if ($payment==''){
?>
	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>

	<?php }else{
		?>
<a href=""><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39"><?php echo $payment_name; ?></span>
			<?php
	}
			?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href=""><img src="img/box.gif"  width="15"   height="15" /></a>&nbsp;<span class="style39">อื่นๆ</span>

<br>

</p>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10" align="center" class="style30">ลำดับ</td>
<td width="50" align="center" class="style30">รหัสสินค้า</td>
<td width="80" align="center" class="style30">รายละเอียด</td> 
<td width="30" align="center" class="style30">จำนวน</td> 
<td width="30" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="30" align="center" class="style30">ยอดรวม</td> 


</tr>
<tr>
<td></td>
<td></td>
<td><br><br><br><br><span class="style40"><div  align="center">*รายละเอียดตามเอกสารแนบท้าย*</div></span><br><br><br>

</td>
<td></td>
<td></td>
<td></td>
</tr>
</table>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td align="center">
<span class="style40">TOTAL</span>
</td>
</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td  class="style39">

<?php
if ($bq_ckk =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39" >BQ เลขที่</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >BQ เลขที่</span>&nbsp&nbsp

			<?php
	}
			?>

<span class="style39" style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;<?php echo $bq; ?>&nbsp;&nbsp;&nbsp;</span>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
if ($ot_ckk =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39" >OT เลขที่</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >OT เลขที่</span>&nbsp&nbsp

			<?php
	}
			?>

<span class="style39" style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;<?php echo $ot; ?>&nbsp;&nbsp;&nbsp;</span>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php
if ($full_bill =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >ต้องการใบกำกับภาษีเต็มรูปแบบ</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ต้องการใบกำกับภาษีเต็มรูปแบบ</span>&nbsp&nbsp

			<?php
	}
			?>

</td>

</tr>

</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td>
Sales Comment <br>
<u>&nbsp&nbsp<span class="style39" ><?php echo $sale_remarkk;?></span>&nbsp&nbsp</u>
<br>

<?php
if ($with_pr =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >แนบใบเสนอราคา</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >แนบใบเสนอราคา</span>&nbsp&nbsp

			<?php
	}
			?>

			<br>

<?php
if ($clear_book_ckk =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >Clear ใบจองสินค้าเลขที่</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Clear ใบจองสินค้าเลขที่</span>&nbsp&nbsp

			<?php
	}
			?>
<span class="style39" style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;<?php echo $clear_book_no; ?>&nbsp;&nbsp;&nbsp;</span></p>
<span class="style40" >ไม่ต้องส่งสินค้า</span>

<br>

<?php
if ($clear_brn_no_ckk =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >Clear ใบยืมสินค้าติดเล่ม BRN</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Clear ใบยืมสินค้าติดเล่ม BRN</span>&nbsp&nbsp

			<?php
	}
			?>
<span class="style39" style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;<?php echo $clear_brn_no; ?>&nbsp;&nbsp;&nbsp;</span>
<br>

<?php
if ($clear_brnp_no_ckk =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span>&nbsp&nbsp

			<?php
	}
			?>
<span class="style39" style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;<?php echo $clear_brnp_no; ?>&nbsp;&nbsp;&nbsp;</span>


</td>

<td >


<?php
if ($delivery_type =='4'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >บริษัทจัดส่ง</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >บริษัทจัดส่ง</span>&nbsp&nbsp

			<?php
	}
			?>
		

<?php
if ($delivery_type =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >ส่งสินค้าแผนกช่าง</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ส่งสินค้าแผนกช่าง</span>&nbsp&nbsp

			<?php
	}
			?>
			
			<br>

<?php
if ($delivery_type =='2'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >Sale รับเอง</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Sale รับเอง</span>&nbsp&nbsp

			<?php
	}
			?>
&nbsp
<?php
if ($delivery_type =='3'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >ลูกค้ารับเอง</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ลูกค้ารับเอง</span>&nbsp&nbsp

			<?php
	}
			?>
<br>

วันที่ <u><?php echo $delivery_date; ?></u>&nbsp;เวลา&nbsp;&nbsp;<u>&nbsp;&nbsp;<?php echo $delivery_time; ?>&nbsp;&nbsp;</u>

<br>

<?php
if ($big_car =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >ต้องการรถใหญ่</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ต้องการรถใหญ่</span>&nbsp&nbsp

			<?php
	}
			?>


<br>

<?php
if ($maps =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >มีแผนที่ประกอบ</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >มีแผนที่ประกอบ</span>&nbsp&nbsp

			<?php
	}
			?>

			<br>

<?php
if ($call_before =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >แจ้งลูกค้าก่อนส่ง</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >แจ้งลูกค้าก่อนส่ง</span>&nbsp&nbsp

			<?php
	}
			?>

			<br>

<?php
if ($assign_date_time =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >นัดวันและเวลาเรียบร้อยแล้ว</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >นัดวันและเวลาเรียบร้อยแล้ว</span>&nbsp&nbsp

			<?php
	}
			?>

			<br>

</td>
</tr>

<tr>

<td>

<?php
if ($type_type =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตาม Computer</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตาม Computer</span>&nbsp&nbsp

			<?php
	}
			?>
			<br>

<?php
if ($type_type =='2'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตามใบสั่งซื้อ</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตามใบสั่งซื้อ</span>&nbsp&nbsp

			<?php
	}
			?>



				<br>

<?php
if ($type_type =='3'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตามที่เขียน</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตามที่เขียน</span>&nbsp&nbsp

			<?php
	}
			?>
			<br>
<u>&nbsp&nbsp<span class="style39" ><?php echo $type_type_detail;?></span>&nbsp&nbsp</u>


</td>

<td>
<span class="style39" >ระยะเวลารับประกัน</span>&nbsp<u>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" ><?php echo $waranty;?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</u>&nbsp&nbsp<span class="style39" >ปี</span><br>

<span class="style39" >จำนวนครั้งในการ CAL</span>&nbsp<u>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" ><?php echo $cal;?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</u>&nbsp&nbsp<span class="style39" >ครั้งปี</span><br>

<span class="style39" >จำนวนครั้งในการ PM</span>&nbsp<u>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" ><?php echo $pm;?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</u>&nbsp&nbsp<span class="style39" >ครั้งปี</span><br>

<span class="style39" >สถานที่ติดตั้งเครื่อง</span>&nbsp<u>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" ><?php echo $install_place;?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</u>&nbsp&nbsp<br>


</td>

</tr>

</table>


</p>



&nbsp<u>&nbsp<span class="style39" ><?php echo $employee_name; echo "/"; echo $register_date;?></span>&nbsp</u>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style40" align="right"><?php echo $iv_no ; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u>&nbsp<span class="style39" ><?php echo $approve_name; echo "/"; echo $register_date;?></span>&nbsp</u>

<br>
&nbsp<span class="style40" >Sales Signature/Area/Date</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style40" align="right"><?php echo $register_date ; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u>&nbsp<span class="style39" >Authorized Signature/Date</span>&nbsp</u></p>
<span class="style39" >อนุมัติวันที่ 29 สิงหาคม 2559 </span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" >FM-SA-02:Rev.9</span>

</p></p></p>



<?php

$sale_channel =$_GET["sale_channel"];

$register_date =$_GET["register_date"];
$iv_no  =$_GET["iv_no"];


$strSQL2 = "SELECT distinct doc_no  FROM so__main  WHERE sale_channel = '".$sale_channel."'  and iv_no  ='".$iv_no."'";

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){
		
$doc_no	= $objResult2["doc_no"];	
	?>
</p>
<?php
 echo "เลขที่"; ?> &nbsp&nbsp <?php echo $doc_no;		
	?>
	</p>
	<?php
$strSQL15="SELECT distinct product_code FROM (so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id) WHERE doc_no = '".$doc_no."' and sale_channel = '".$sale_channel."' and iv_no  ='".$iv_no."'";

$objQuery15 =mysqli_query($conn,$strSQL15);
while($objResult15=mysqli_fetch_array($objQuery15)){

	$product_code5 =$objResult15["product_code"];

$strSQL151="SELECT unit_name,access_name FROM tb_product WHERE product_ID = '".$product_code5."' ";

$objQuery151 =mysqli_query($conn,$strSQL151);
$objResult151=mysqli_fetch_array($objQuery151);


	$unit_name5 =$objResult151["unit_name"];
	$product_name5 =$objResult151["access_name"];

?>
<table  width="100%" class='w3-table'>




<tr>

<td width="40%" align="left" class="style39"><?php echo $product_name5; ?></td>

<?php 


$strSQL19 = "SELECT SUM(sale_count)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_code = '".$product_code5."'  and sale_channel = '".$sale_channel."'  and doc_no = '".$doc_no."' and iv_no  ='".$iv_no."'";
//echo $strSQL9;
//exit();

$objQuery19 = mysqli_query($conn,$strSQL19) or die ("Error Query [".$strSQL19."]");

while($objResult19 = mysqli_fetch_array($objQuery19))
{
$total19 =$objResult19["total1"];

?>

<td width="20%" align="right" class="style39"><?php echo $total19; ?>&nbsp<?php echo $unit_name5; ?></td>


<?php


}
?>




<?php

$strSQL123 = "SELECT SUM(sum_amount)  as total123  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_code = '".$product_code5."'  and sale_channel = '".$sale_channel."'  and doc_no = '".$doc_no."' and iv_no  ='".$iv_no."'";
//echo $strSQL9;
//exit();

$objQuery123 = mysqli_query($conn,$strSQL123) or die ("Error Query [".$strSQL123."]");

while($objResult123 = mysqli_fetch_array($objQuery123))
{
$total1234 =$objResult123["total123"];
$total124= number_format( $total1234,2)."";


?>

<td width="20%" align="right" class="style39"><?php echo $total124; ?>&nbspบาท</td>
</tr>


<?php

}



	}

	?>
</table>

<?php
$strSQL20 = "SELECT SUM(sale_count) AS sale_count   FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE sale_channel = '".$sale_channel."'  and doc_no = '".$doc_no."' and iv_no  ='".$iv_no."'";
//echo $strSQL10;
//exit();

$objQuery20 = mysqli_query($conn,$strSQL20) or die(mysqli_error());
$Num_Rows20 = mysqli_num_rows($objQuery20);
$objResult20 = mysqli_fetch_array($objQuery20);

	$strSQL21 = "SELECT SUM(sum_amount) AS amount_2  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  sale_channel = '".$sale_channel."'  and doc_no = '".$doc_no."' and iv_no  ='".$iv_no."'";
//echo $strSQL11;
//exit();

$objQuery21 = mysqli_query($conn,$strSQL21) or die(mysqli_error());
$Num_Rows21 = mysqli_num_rows($objQuery21);
$objResult21 = mysqli_fetch_array($objQuery21);


$sale_count2  = $objResult20["sale_count"];
$amount_5  = $objResult21["amount_2"];

$amount_6= number_format( $amount_5,2)."";
?>
<table  width="100%" class='w3-table'>

<tr>

<td width="40%" align="left" class="style30">รวมรายการ</td>
<td width="20%" align="right" class="style30"><?php echo $sale_count2; ?>&nbsp รายการ</td>
<td width="20%" align="right" class="style30"><?php echo $amount_6; ?>&nbspบาท</td>

</tr>
</table>
	
	
<?php	
	
}

?>

</p></p></p>



<?php

$sale_channel =$_GET["sale_channel"];
$iv_no =$_GET["iv_no"];
$register_date =$_GET["register_date"];

?>

&nbsp&nbsp<span class="style15" >เลขที่เอกสาร : </span>&nbsp&nbsp<span class="style15" ><?php echo $iv_no;  ?></span>
</p>
<?
		
$strSQL5="SELECT distinct product_code FROM (so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id) WHERE iv_no = '".$iv_no."' and sale_channel = '".$sale_channel."' ";
$objQuery5 =mysqli_query($conn,$strSQL5);
while($objResult5=mysqli_fetch_array($objQuery5)){

	$product_code =$objResult5["product_code"];

$strSQL51="SELECT unit_name,access_name FROM tb_product WHERE product_ID = '".$product_code."' ";
$objQuery51 =mysqli_query($conn,$strSQL51);
$objResult51=mysqli_fetch_array($objQuery51);




	$product_name =$objResult51["access_name"];
	$unit_name1 =$objResult51["unit_name"];

?>
<table  width="100%" class='w3-table'>




<tr>

<td width="40%" align="left" class="style39"><?php echo $product_name; ?></td>

<?php 


$strSQL9 = "SELECT SUM(sale_count)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_code = '".$product_code."' and  sale_channel = '".$sale_channel."'  and iv_no = '".$iv_no."' ";
//echo $strSQL9;
//exit();

$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");

while($objResult9 = mysqli_fetch_array($objQuery9))
{
$total1 =$objResult9["total1"];

?>

<td width="20%" align="right" class="style39"><?php echo $total1; ?>&nbsp<?php echo $unit_name1; ?></td>


<?php


}
?>




<?php

$strSQL12 = "SELECT SUM(sum_amount)  as total12  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_code = '".$product_code."'  and sale_channel = '".$sale_channel."'  and iv_no = '".$iv_no."'";
//echo $strSQL9;
//exit();

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");

while($objResult12 = mysqli_fetch_array($objQuery12))
{
$total123 =$objResult12["total12"];
$total12= number_format( $total123,2)."";


?>

<td width="20%" align="right" class="style39"><?php echo $total12; ?>&nbspบาท</td>
</tr>


<?php

}



	}

	?>
</table>

<?php
$strSQL10 = "SELECT SUM(sale_count) AS sale_count   FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE sale_channel = '".$sale_channel."'  and iv_no = '".$iv_no."'";
//echo $strSQL10;
//exit();

$objQuery10 = mysqli_query($conn,$strSQL10) or die(mysqli_error());
$Num_Rows10 = mysqli_num_rows($objQuery10);
$objResult10 = mysqli_fetch_array($objQuery10);

	$strSQL11 = "SELECT SUM(sum_amount) AS amount_2  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  sale_channel = '".$sale_channel."'  and iv_no = '".$iv_no."'";
//echo $strSQL11;
//exit();

$objQuery11 = mysqli_query($conn,$strSQL11) or die(mysqli_error());
$Num_Rows11 = mysqli_num_rows($objQuery11);
$objResult11 = mysqli_fetch_array($objQuery11);


$sale_count  = $objResult10["sale_count"];
$amount_3  = $objResult11["amount_2"];

$amount_2= number_format( $amount_3,2)."";
?>
<table  width="100%" class='w3-table'>

<tr>

<td width="40%" align="left" class="style30">รวมรายการ</td>
<td width="20%" align="right" class="style30"><?php echo $sale_count; ?>&nbsp รายการ</td>
<td width="20%" align="right" class="style30"><?php echo $amount_2; ?>&nbspบาท</td>

</tr>
</table>

<?php

$strSQL7 = "SELECT count(*) as total FROM so__main WHERE iv_no = '".$iv_no."' ";
//echo  $strSQL7;
//exit();

$objQuery7 = mysqli_query($conn,$strSQL7) or die(mysqli_error());
$Num_Rows7 = mysqli_num_rows($objQuery7);
$objResult7 = mysqli_fetch_array($objQuery7);
$sum_sol =$objResult7["total"];
?>

</p>
&nbsp&nbsp<span class="style15" >สรุปเลขที่เอกสาร : </span>&nbsp&nbsp<span class="style15" ><?php echo $iv_no;  ?></span>&nbsp&nbsp<span class="style15" >( <?php echo $sum_sol; ?>&nbsp ราย )</span>
</p>




















</p>
</body>

</html>
