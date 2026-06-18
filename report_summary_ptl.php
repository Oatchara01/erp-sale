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
.style39 {font-size: 13px; color: #000000;}
.style40 {font-size: 14px; color: #000000; }
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

$doc_release_date =$_GET["doc_release_date"];
$doc_no =$_GET["doc_no"];



include"dbconnect.php";

/*$strSQL = "SELECT
so__main.* ,tb_salechannel.*, tb_delivery.* FROM ((so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID) WHERE sale_channel = '".$sale_channel."'  and doc_no  ='".$doc_no."'";

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
$payment = $objResult["payment"];
$province_id = $objResult["province_id"];
?>


<span class="style39">เลขที่อ้างอิง</span> <u><span class="style39"><?php echo $ref_id; ?></span></u>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style33"><?php echo $time_delivery; echo $packing_remark; ?></span>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $delivery_name; ?><br>
	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;ก&nbsp;
	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;C
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style33"><?php echo $time_delivery; echo $packing_remark; ?></span>




<center>
<span class="style15">ใบสั่งพิมพ์ใบเบิกจ่ายสินค้า</span><br>

<span class="style15">(Request for issuing stock movement order)</span>
</center>

<span class="style39">ฝากส่งสินค้าเลขที่</span> <u>&nbsp;&nbsp;<span class="style39"><?php echo $deposit_no; ?></span>&nbsp;&nbsp;</u><br>

<span class="style39">เลขที่ลงงาน</span> <u>&nbsp;&nbsp;<span class="style39"><?php echo $job_id; ?></span>&nbsp;&nbsp;</u>

<span class="style33" align="right"><div align="right"><?php echo $doc_no;?></div></span>
<div align="right"><?php echo barcode($doc_no);?></div>

<table border="1" width="100%" class='w3-table'>
<tr>
<td>
<span class="style40">ชื่อลูกค้า/รพ. </span>&nbsp;&nbsp;<span class="style39"><?php echo $prefer_name; ?></span><hr color="black"  width="80%" size="0.1" align="right">

<span class="style40">ทีอยู่</span>&nbsp;&nbsp;<span class="style39"><?php echo $address1; ?></span><hr color="black"  width="90%" size="0.1" align="right">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $address2; ?></span><hr color="black"  width="90%" size="0.1" align="right">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $province_id; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $zip_code; ?></span><hr color="black"  width="100%" size="0.1" align="right">

<span class="style40">สถานที่ส่งสินค้า </span>&nbsp;&nbsp;<hr color="black"  width="70%" size="0.1" align="right">
<span class="style40">Ward/ชั้น/ตึก </span>&nbsp;&nbsp;<hr color="black"  width="70%" size="0.1" align="right">
<span class="style40">ชื่อผู้ติดต่อ/โทร</span>&nbsp;&nbsp;<hr color="black"  width="70%" size="0.1" align="right">




</td>

<td>


<span class="style40">วันที่ </span>&nbsp;&nbsp;<span class="style39"><?php echo $register_date; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<span class="style40">เลขที่ </span>&nbsp;&nbsp;<span class="style39"><?php echo $doc_no; ?></span><hr color="black"  width="100%" size="0.1" align="right">
<span class="style30">วัตถุประสงค์การเบิก </span></p>

<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;เป็นสินค้าสำรอง <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;สำหรับลูกค้าทดลองใช้ <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><span class="style39">ปี</span><br>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;ส่งสินค้าล่วงหน้าเพื่อรอรับใบส่งซื้อ<br>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;แลกเปลี่ยนสินค้า ตามใบงานบริการเลขที่ <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><span class="style39">*</span><br>
<span class="style35">(เฉพาะกรณีแลกเปลี่ยนสินค้าที่มีหมายเลขเครื่องต้องระบุเลขที่ใบงานบริการทุกครั้ง)</span><br>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;อื่นๆ&nbsp;&nbsp;<?php echo $salechannel_nameshort; ?><hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">. </span><hr color="black"  width="80%" size="0.1" align="right">

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
<tr>
<td></td>
<td></td>
<td><br><br><br><span class="style40"><div  align="center">*รายละเอียดตามเอกสารแนบท้าย*</div></span><br><br>

<?php
if ($sn_ckk=='1'){
?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39">ไม่ต้องการ</span>&nbsp;&nbsp;
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39">ต้องการ</span>
<?php
}else{
	?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39">ไม่ต้องการ</span>&nbsp;&nbsp;
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39">ต้องการ</span>


		<?php
		}
		?>
&nbsp;&nbsp;<span class="style39">Serial No.</span>&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>

<?php
if ($bq_ckk =='1'){
?>
&nbsp;&nbsp;<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39">BQ เลขที่ </span>
<?php }else { ?>
&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp; <span class="style39">BQ เลขที่ </span>

		<?php } ?>

&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
<?php
if ($ot_ckk =='1'){
?>
&nbsp;&nbsp;<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39">OT เลขที่ </span>
<?php }else { ?>
&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp; <span class="style39">OT เลขที่ </span>

		<?php } ?>

&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>


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

<td>
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
		
<br>
<?php
if ($delivery_type =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >Engineer รับเอง</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Engineer รับเอง</span>&nbsp&nbsp

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
&nbsp&nbsp&nbsp&nbsp<span class="style40">วันที่ </span>&nbsp;&nbsp;<u>&nbsp;&nbsp;<span class="style39"><?php echo $register_date; ?></span>&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;<span class="style40">วันที่ </span><u>&nbsp;&nbsp;</u><br>

<?php
if ($call_before =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >โทรแจ้งลูกค้าก่อนไป</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >โทรแจ้งลูกค้าก่อนไป</span>&nbsp&nbsp

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

<span class="style40">หมายเหตุ </span>&nbsp;&nbsp;

<hr color="black"  width="80%" size="0.1" align="right">

<span class="style40">.</span>&nbsp;&nbsp;<hr color="black"  width="80%" size="0.1" align="right">






</td>

<td>
<?php
if ($returns =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >รับสินค้าคืน</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >รับสินค้าคืน</span>&nbsp&nbsp

			<?php
	}
			?>
<hr color="black"  width="70%" size="0.1" align="right">

<span class="style39" >Ward/ชั้น/ตึก</span>&nbsp&nbsp<hr color="black"  width="70%" size="0.1" align="right">
<span class="style39" >.</span>&nbsp&nbsp<hr color="black"  width="70%" size="0.1" align="right">
<span class="style39" >ชื่อผู้ติดต่อ/โทร</span>&nbsp&nbsp<hr color="black"  width="70%" size="0.1" align="right">
<span class="style39" >.</span>&nbsp&nbsp<hr color="black"  width="70%" size="0.1" align="right">
<span class="style39" >.</span>&nbsp&nbsp<hr color="black"  width="70%" size="0.1" align="right">
<span class="style39" >.</span>&nbsp&nbsp<hr color="black"  width="70%" size="0.1" align="right">


</td>

</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>

<td>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" >ผู้เบิกสินค้า</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" >ผู้อนุมัติ</span><br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" >(</span>&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" ><?php echo $employee_name; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;<span class="style40" >)</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style40" >(</span>&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" ><?php echo $approve_name; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;<span class="style40" >)</span><br>



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" >วันที่</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" ><?php echo $register_date; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;วันที่
&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" ><?php echo $register_date; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;<br><br>


</td>

</tr>
</table>

<span class="style35" >อนุมัติวันที่ 29 สิงหาคม 2559 </span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style35" >FM-SA-04:Rev.9</span><br>
<span class="style35" ><?php echo $date   ; ?></span></p></p>



<?php


$sale_channel =$_GET["sale_channel"];

$doc_release_date =$_GET["doc_release_date"];



$strSQL2 = "SELECT *  FROM so__main  WHERE sale_channel = '".$sale_channel."' and doc_no  LIKE '%".$doc_no."%'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){

$strSQL89="Update  so__main set print_sol = '1'  where ref_id='".$objResult2["ref_id"]."'";
$objQuery89 = mysqli_query($conn,$strSQL89);	
	
$strSQL11 = "SELECT ref_id FROM so__main  WHERE order_id = '".$objResult2["order_id"]."'";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);		
	
$ref_id1 = $objResult2["ref_id"];
	
if($Num_Rows11 > 1){ echo "**"; }		echo $ref_id1;
$order_id = $objResult2["order_id"];
$tel  = $objResult2["tel"];
		
if($objResult2["delivery_name"]!=""){
$delivery_name  = $objResult2["delivery_name"];
}else if ($objResult2["customer_name"]!=""){
$delivery_name  = $objResult2["customer_name"];	
}else{
$delivery_name  = $objResult2["billing_name"];		
}
		
$order_refer_code  = $objResult2["order_refer_code"];

$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$ref_id1."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";
?>


<table  width="100%" class='w3-table'>

<tr>

<td width="25%" align="left" class="style39">เลขที่อ้างอิง : <?php echo $ref_id1; ?></td>

<td width="25%" align="left" class="style39"> <?php echo $delivery_name; ?> :<br> <?php echo barcode($order_id) ; echo $order_id; ?></td>

<td width="25%" align="left" class="style39"> 
	<?php if ($order_refer_code !=""){  echo barcode($order_refer_code) ; }
	echo $order_refer_code."<br>"; ?>
	</td>
<td width="25%" align="left" class="style39">โทร : <?php echo $delivery_name; ?> /<?php echo $tel; ?><br>
<?php echo $order_refer_code; ?>
<br>
</td>


</tr>


		
<?

$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id1."' ";
//echo $strSQL1;
//exit();

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$i=1;

while($objResult1 = mysqli_fetch_array($objQuery1))
{
$ref_idd  =$objResult1["ref_idd"];

$price_per_unit_1  =$objResult1["price_per_unit"];
$price_per_unit= number_format( $price_per_unit_1,2)."";

$product_code  =$objResult1["product_code"];
$product_name  =$objResult1["access_name"];
$sale_count  =$objResult1["sale_count"];
$unit_name  =$objResult1["unit_name"];
$sn_number =$objResult1["sn_number"];
// echo  $ref_idd ;
?>

	<tr>

<td width="25%" align="left" class="style39"><?php echo $i; ?></td>

<td width="25%" align="left" class="style39"> <?php echo $product_code; ?></td>

<td width="25%" align="left" class="style39"> <?php  echo $product_name ;?>
		</td>
<td width="25%" align="left" class="style39"> <?php echo $sale_count; ?> <?php echo $unit_name; ?></td>
<td width="25%" align="left" class="style39"><?php if ($sn_number !=""){ echo barcode($sn_number) ;} echo $sn_number; ?> </td>
<td width="25%" align="right" class="style39"><?php echo $price_per_unit; ?> </td>

</tr>
<?php
$i++;	
	}

	?>
	<tr>

<td width="25%" align="left" class="style39"></td>

<td width="25%" align="left" class="style39"></td>

<td width="25%" align="left" class="style39"> 
	</td>
		<td width="25%" align="left" class="style39"> 
	</td>
<td width="25%" align="left" class="style39">Total :</td>
<td width="25%" align="left" class="style39"><?php echo $summary; ?> </td>

</tr>


</table>
</p></p>
<hr color="black"  width="100%" size="0.1" align="right">
</p></p>
<?php	
}

?>

</p></p></p>



<?php
*/
$sale_channel =$_GET["sale_channel"];

$register_date =$_GET["register_date"];


/*$strSQL7 = "SELECT count(*) as total FROM so__main WHERE doc_no LIKE '%".$doc_no."%' ";
$objQuery7 = mysqli_query($conn,$strSQL7) or die(mysqli_error());
$Num_Rows7 = mysqli_num_rows($objQuery7);
$objResult7 = mysqli_fetch_array($objQuery7);
$sum_sol =$objResult7["total"];*/

$strSQL6 = "SELECT * FROM so__main  WHERE sale_channel = '".$sale_channel."'   and doc_no LIKE '%".$doc_no."%'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die(mysqli_error());
$objResult6 = mysqli_fetch_array($objQuery6);

$doc_no =$objResult6["doc_no"];
?>

&nbsp;&nbsp;<span class="style15" >เลขที่เอกสาร : </span>&nbsp;&nbsp;<span class="style15" ><?php echo $doc_no;  ?></span>
</p>

<div class="w3-container">

<table  border="1" width="100%" class='w3-table'>
	
<thead class="w3-gray">
			<th width="20%">รหัสสินค้า</th>
			<th width="20%">ชื่อสินค้า</th>
			<th width="20%">จำนวนขาย</th>
			<th width="20%">ราคารวม</th>
			
</thead>	

<?php
		
$strSQL5="SELECT distinct product_code FROM (so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id) WHERE doc_no LIKE '%".$doc_no."%' and sale_channel = '".$sale_channel."' ";
$objQuery5 =mysqli_query($conn,$strSQL5);
while($objResult5=mysqli_fetch_array($objQuery5)){
	
$strSQL19 = "SELECT sol_name,unit_name,access_code  FROM tb_product WHERE product_ID = '".$objResult5["product_code"]."'";
$objQuery19 = mysqli_query($conn,$strSQL19) or die ("Error Query [".$strSQL19."]");
$objResult19 = mysqli_fetch_array($objQuery19);	

$product_code =$objResult5["product_code"];
$access_code =$objResult19["access_code"];	
$sol_name =$objResult19["sol_name"];
$unit_name1 =$objResult19["unit_name"];
?>


<tr>
<td width="20%" align="left" class="style39"><?php echo $access_code; ?></td>
<td width="20%" align="left" class="style39"><?php echo $sol_name; ?></td>

<?php 


$strSQL9 = "SELECT SUM(sale_count)  as total1,SUM(sum_amount)  as total12  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_code = '".$product_code."' and sale_channel = '".$sale_channel."'   and doc_no LIKE '%".$doc_no."%'";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);
$total1 =$objResult9["total1"];
$total123 =$objResult9["total12"];
$total12= number_format( $total123,2)."";
?>

<td width="20%" align="right" class="style39"><?php echo $total1; ?>&nbsp; <?php echo $unit_name1; ?></td>


<td width="20%" align="right" class="style39"><?php echo $total12; ?>&nbsp; บาท</td>

</tr>


<?php

}

?>


<?php
$strSQL10 = "SELECT SUM(sale_count) AS sale_count,SUM(sum_amount) AS amount_2   FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE sale_channel = '".$sale_channel."'  and doc_no LIKE '%".$doc_no."%'";
$objQuery10 = mysqli_query($conn,$strSQL10) or die(mysqli_error());
$Num_Rows10 = mysqli_num_rows($objQuery10);
$objResult10 = mysqli_fetch_array($objQuery10);

$sale_count  = $objResult10["sale_count"];
$amount_3  = $objResult10["amount_2"];

$amount_2= number_format( $amount_3,2)."";
?>


<tr>
	
<td width="20%" align="right" class="style30"></td>
<td width="20%" align="left" class="style30">รวมรายการ</td>
<td width="20%" align="right" class="style30"><?php echo $sale_count; ?>&nbsp; รายการ</td>
<td width="20%" align="right" class="style30"><?php echo $amount_2; ?>&nbsp; บาท</td>

</tr>
</table>



</p>
</body>

</html>
