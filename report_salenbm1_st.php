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
$stock=$_GET["stock"];


include"dbconnect.php";

$strSQL25="Update  so__main set printst_ckk = '1',stock_print = '".$stock."'  where ref_id ='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);


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
?>



	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;ก&nbsp;
	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;C
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style33"><?php echo $time_delivery; echo $packing_remark; ?></span>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $delivery_name; ?>

</p>
	<a><img src="img/nb_logo.jpg" width="80" align="right" height="40" /></a><p>

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
<span class="style33" align="right"><div align="right"><?php echo $doc_no;?></div></span>
<div align="right"><?php echo barcode($doc_no);?></div>
<span class="style40">ชื่อผู้แนะนำ/รพ./แผนก </span>&nbsp;&nbsp;<span class="style39"><?php echo $prefor_name; ?></span>&nbsp;&nbsp;<br>
<span class="style40">ชื่อที่ต้องการออกบิล </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $billing_name; ?></span>&nbsp;&nbsp;<br>
<span class="style40">ที่อยูที่ต้องการออกบิล </span>&nbsp;&nbsp;<span class="style39" ><?php echo $billing_address; ?></span><br>
<span class="style40">เบอร์โทร </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $billing_tel; ?></span>&nbsp;&nbsp;
<br><span class="style40">สถานที่ส่งสินค้า </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $delivery_place; ?></span>&nbsp;&nbsp;<br>
<span class="style40">ชื่อผู้ติดด่อ/โทร </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $delivery_contact; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style40">เบอร์โทร</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $tel; ?></span>&nbsp;&nbsp;

<br>
<span class="style40">ใบสั่งซื้อเลขที่</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $po_no; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style40">กำหนดส่งตามสัญญา</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $delivery_contract; ?></span>&nbsp;&nbsp;
<br>
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
<td width="50" align="center" class="style30">รายละเอียด</td> 
<td width="50" align="center" class="style30">จำนวน</td> 
<td width="50" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="50" align="center" class="style30">ยอดรวม</td> 


</tr>


<?php

$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

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
<td align="center" class="style39"><?php echo $i;?></td>
<td align="center" class="style39"><?php 
	echo barcode($product_code);
	echo $product_code;

?></td>
<td align="left" class="style39"><?php echo $product;?> <?php if ($warranty > 0){  echo ':รับประกัน'; echo $warranty; echo 'ปี'; }?>
<?php if ($cal > 0){  echo ':cal'; echo $cal; echo 'ครั้ง/ปี'; }?>
<?php if ($pm > 0){  echo ':pm'; echo $pm; echo 'ครั้ง/ปี'; }?>



</td>
<td align="right" class="style39"><?php echo $sale_count;?> &nbsp <?php echo $unit_name;?></td>
<td align="right" class="style39"><?php echo $price_per_unit;?></td>
<td align="right" class="style39"><?php echo $sum_amount;?></td>



<?php
$i++;
}

?>
</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td  align="right" >Total : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $summary;?></td>

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
<td width="50%">
Sales Comment <br>
<u>&nbsp&nbsp<span class="style39" ><?php echo $sale_remarkk;?></span>&nbsp&nbsp</u>
<br>

<?php
if ($with_pr =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >แนบใบเสนอราคา</span>&nbsp&nbsp
	<?php }else{
		?>
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >แนบใบเสนอราคา</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Clear ใบจองสินค้าเลขที่</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Clear ใบยืมสินค้าติดเล่ม BRN</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >บริษัทจัดส่ง</span>&nbsp&nbsp

			<?php
	}
			?>
		

<?php
if ($delivery_type =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >ส่งสินค้าแผนกช่าง</span>&nbsp&nbsp
	<?php }else{
		?>
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ส่งสินค้าแผนกช่าง</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Sale รับเอง</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ลูกค้ารับเอง</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ต้องการรถใหญ่</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >มีแผนที่ประกอบ</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >แจ้งลูกค้าก่อนส่ง</span>&nbsp&nbsp

			<?php
	}
			?>

			<br>

<?php
if ($objResult3["fix_date"] =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >นัดวันและเวลาเรียบร้อยแล้ว</span>&nbsp&nbsp
	<?php }else{
		?>
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >นัดวันและเวลาเรียบร้อยแล้ว</span>&nbsp&nbsp

			<?php
	}
			?>

			<br>

</td>
</tr>

<tr>

<td width="50%">

<?php
if ($type_type =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตาม Computer</span>&nbsp&nbsp
	<?php }else{
		?>
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตาม Computer</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตามใบสั่งซื้อ</span>&nbsp&nbsp

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตามที่เขียน</span>&nbsp&nbsp

			<?php
	}
			?>
			<br>
<u>&nbsp&nbsp<span class="style39" ><?php echo $type_type_detail;?></span>&nbsp&nbsp</u>


</td>

<td>
<span class="style39" >ระยะเวลารับประกัน</span>&nbsp<u>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" ><?php echo $waranty_h;?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</u>&nbsp&nbsp<span class="style39" >ปี</span><br>

<span class="style39" >จำนวนครั้งในการ CAL</span>&nbsp<u>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" ><?php echo $cal;?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</u>&nbsp&nbsp<span class="style39" >ครั้งปี</span><br>

<span class="style39" >จำนวนครั้งในการ PM</span>&nbsp<u>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" ><?php echo $pm;?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</u>&nbsp&nbsp<span class="style39" >ครั้งปี</span><br>

<span class="style39" >สถานที่ติดตั้งเครื่อง</span>&nbsp<u>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" ><?php echo $install_place;?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</u>&nbsp&nbsp<br>


</td>

</tr>

</table>


</p>



&nbsp<u>&nbsp<span class="style39" ><?php echo $employee_name; echo "/"; echo $register_date;?></span>&nbsp</u>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style40" align="right"><?php echo $doc_no ; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u>&nbsp<span class="style39" ><?php echo $approve_name; echo "/"; echo $register_date;?></span>&nbsp</u>

<br>
&nbsp<span class="style40" >Sales Signature/Area/Date</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style40" align="right"><?php echo $doc_release_date ; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u>&nbsp<span class="style39" >Authorized Signature/Date</span>&nbsp</u></p>
<span class="style39" >อนุมัติวันที่ 29 สิงหาคม 2559 </span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" >FM-SA-04:Rev.9</span>

</p>
</body>

</html>
