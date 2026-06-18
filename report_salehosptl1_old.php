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


include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";


function barcode($code){
    
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 1.5;//กำหนดความหน้าของเส้น Barcode
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

$strSQL25="Update  hos__so set status_ad_print = '1'  where ref_id ='".$ref_id."'";


$objQuery25 = mysqli_query($conn,$strSQL25);


$strSQL = "SELECT * from (hos__so LEFT JOIN tb_credit ON hos__so.payment=tb_credit.credit_id) WHERE ref_id = '".$ref_id."' ";
//echo  $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

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
$delivery_date = $objResult['date_send_key'];
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


?>
<body>


	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;ก&nbsp;
	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;C

</p>

<center>
<span class="style15">ใบสั่งขาย</span><br>

<span class="style15">(SALES ORDER)</span>
</center>






<span class="style39">เลขที่อ้างอิง</span> <u><span class="style39"><?php echo $ref_id; ?></span></u>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39">ฝากสินค้าเลขที่</span> <u><span class="style39"><?php echo $dep_no; ?></span></u>

<br>

<span class="style39">เลขที่ลงงาน</span> <u><span class="style39"><?php echo $job_no; ?></span></u>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39">วันที่</span> <span class="style39"><?php echo datethai($date); ?></span>

<br>
<span class="style39">เลขที่ใบฝาก</span> <u><span class="style39"><?php echo $order_no; ?></span></u>


<br>
<span class="style33" align="right"><div align="right"><?php echo $iv_no;?></div></span>
<div align="right"><?php echo barcode($iv_no);?></div>
<span class="style40">ชื่อผู้แนะนำ/รพ./แผนก </span>&nbsp;&nbsp;<span class="style39"><?php echo $suggest; ?></span>&nbsp;&nbsp;<hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">ชื่อที่ต้องการออกบิล </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $bill_name; ?></span>&nbsp;&nbsp;<hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">ที่อยูที่ต้องการออกบิล </span>&nbsp;&nbsp;<span class="style39" ><?php echo $bill_address; ?></span><hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">เบอร์โทร </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $bill_tel; ?></span>&nbsp;&nbsp;
<hr color="black"  width="80%" size="0.1" align="right"><span class="style40">สถานที่ส่งสินค้า </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $delivery_address; ?></span>&nbsp;&nbsp;<hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">ชื่อผู้ติดด่อ/โทร </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $delivery_contact; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">ใบสั่งซื้อเลขที่</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $po_no; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style40">กำหนดส่งตามสัญญา</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $delivery_contract; ?></span>&nbsp;&nbsp;
<hr color="black"  width="80%" size="0.1" align="right">
<span class="style40">ชำระโดย </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<?php
if ($payment==''){ ?>
	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>

<?php } else{ ?>
<a href=""><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39"><?php echo $credit_name; ?></span>
<?php }	

if ($payment=='6'){ ?>
&nbsp;&nbsp;&nbsp;<u><span class="style39"><?php echo $payment_des; ?></span></u>

<?php }
	?>

<br>
</p>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">ลำดับ</td>
<td width="15%" align="center" class="style30">รหัสสินค้า</td>
<td width="30%" align="center" class="style30">รายละเอียด</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="10%" align="center" class="style30">ส่วนลดต่อหน่วย</td> 
<td width="10%" align="center" class="style30">ยอดรวม</td> 
</tr>
<?php

$strSQL1 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) where ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["amount"];
$sum_amount= number_format($sum_amount1,2)."";
$price1  =$objResult1["price"];
$price= number_format( $price1,2)."";
$access_code  =$objResult1["express_code"];
$access_name  =$objResult1["access_name"];
$count  =$objResult1["count"];
$unit  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];
$product = "$access_name:$sale_remark";
$warranty = $objResult1["warranty"];
$cal = $objResult1["cal"];
$pm = $objResult1["pm"];
$discount1  = $objResult1["discount"];
$discount= number_format($discount1,2)."";

?>
	<tr>
<td align="center" class="style39"><?php echo $i;?></td>
<td align="center" class="style39"><?php 
	echo barcode($access_code)."<br>";
	echo $access_code;

?></td>
<td align="left" class="style39"><?php echo $product;?>
<?php if ($warranty > 0){  echo ':รับประกัน'; echo $warranty; echo 'ปี'; }?>
<?php if ($cal > 0){  echo ':cal'; echo $cal; echo 'ครั้ง/ปี'; }?>
<?php if ($pm > 0){  echo ':pm'; echo $pm; echo 'ครั้ง/ปี'; }?>
</td>
<td align="right" class="style39"><?php echo $count;?> &nbsp <?php echo $unit;?></td>
<td align="right" class="style39"><?php echo $price;?></td>
<td align="right" class="style39"><?php echo $discount;?></td>
<td align="right" class="style39"><?php echo $sum_amount;?></td>



<?php $i++; } ?>
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


<?php if ($full_bill ==1){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >ต้องการใบกำกับภาษีเต็มรูปแบบ</span>&nbsp&nbsp
<?php } else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ต้องการใบกำกับภาษีเต็มรูปแบบ</span>&nbsp&nbsp
<?php } ?>
</td>
</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td width="50%">
<u>&nbsp&nbspรายการของแถม&nbsp&nbsp</u> <br>
	
	<?php if($product_free!=''){?>
<span class="style39" ><?php echo $product_free;?></span>
<br>
	<?php }
	if($product_free1 !=''){
	?>
	<span class="style39" ><?php echo $product_free1;?></span>
<br>
	<?php } 
	if($product_free2 !=''){
		?>
	<span class="style39" ><?php echo $product_free2;?></span>
<br>
	
	<?php }
	if($product_free3!=''){
	?>
		<span class="style39" ><?php echo $product_free3;?></span>
<br>
	<?php }
	if($product_free4!=''){
	?>
	<span class="style39" ><?php echo $product_free4;?></span>
<br>
	<?php }
	if($product_free5!=''){
	?>
	<span class="style39" ><?php echo $product_free5;?></span>
<br>
	<?php }
	if($product_free6!=''){
	?>
	<span class="style39" ><?php echo $product_free6;?></span>
<br>
	<?php }
	if($product_free7!=''){
	?>
	<span class="style39" ><?php echo $product_free7;?></span>
<br>
	<?php }
	if($product_free8!=''){
	?>
	<span class="style39" ><?php echo $product_free8;?>
<br>
	<?php }
	if($product_free9!=''){
	?>
	<span class="style39" ><?php echo $product_free9;?></span>
<br>
<?php } ?>
<br>	

<?php if ($with_pr =='1'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >แนบใบเสนอราคา</span>&nbsp&nbsp
<?php } else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >แนบใบเสนอราคา</span>&nbsp&nbsp
<?php }	?>

	<u>&nbsp&nbsp<span class="style39" ><?php echo $pr_no;?></span>&nbsp&nbsp</u>

<br>
<?php if ($book_clear =='1'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >Clear ใบจองสินค้าเลขที่</span>&nbsp&nbsp
<?php } else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Clear ใบจองสินค้าเลขที่</span>&nbsp&nbsp
<?php }	?>
<span class="style39" style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;<?php echo $book_no; ?>&nbsp;&nbsp;&nbsp;</span></p>
<span class="style40" >ไม่ต้องส่งสินค้า</span>
<br>
<?php if ($brn_clear =='1'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >Clear ใบยืมสินค้าติดเล่ม BRN</span>&nbsp&nbsp
<?php } else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Clear ใบยืมสินค้าติดเล่ม BRN</span>&nbsp&nbsp
<?php }	?>
<span class="style39" style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;<?php echo $brn_no; ?>&nbsp;&nbsp;&nbsp;</span>
<br>
<?php if ($brnp_clear =='1'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span>&nbsp&nbsp
<?php } else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP</span>&nbsp&nbsp
<?php }	?>
<span class="style39" style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;<?php echo $brnp_no; ?>&nbsp;&nbsp;&nbsp;</span>
</td>
<td >
<?php if ($delivery_type =='4'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >บริษัทจัดส่ง</span>&nbsp&nbsp
<?php } else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >บริษัทจัดส่ง</span>&nbsp&nbsp
<?php }	?>
<?php if ($delivery_type =='2'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >ส่งสินค้าแผนกช่าง</span>&nbsp&nbsp
<?php } else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ส่งสินค้าแผนกช่าง</span>&nbsp&nbsp
<?php }	?>
<br>
<?php if ($delivery_type =='1'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >Sale รับเอง</span>&nbsp&nbsp
<?php } else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Sale รับเอง</span>&nbsp&nbsp
<?php }	?>&nbsp
<?php if ($delivery_type =='3'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >ลูกค้ารับเอง</span>&nbsp&nbsp
<?php } else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ลูกค้ารับเอง</span>&nbsp&nbsp
<?php }	?>
<br>
วันที่ <u><?php echo $delivery_date; ?></u>&nbsp;เวลา&nbsp;&nbsp;<u>&nbsp;&nbsp;<?php echo $delivery_time; ?>&nbsp;&nbsp;</u>
<br>

<?php if ($want_bus  =='1'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >ต้องการรถใหญ่</span>&nbsp&nbsp
<?php }else{ ?>
&nbsp&nbsp<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ต้องการรถใหญ่</span>&nbsp&nbsp	
	<?php } ?>
	
	
<br>
	
&nbsp&nbsp<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >มีแผนที่ประกอบ</span>&nbsp&nbsp
<br>
<?php if ($call_customer  =='1'){ ?>
	<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >แจ้งลูกค้าก่อนส่ง</span>&nbsp&nbsp
	<?php }else{ ?>
	&nbsp&nbsp<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >แจ้งลูกค้าก่อน
	<?php } ?>
	
	
	
<br>
	
<?php if ($fix_date  =='1'){ ?>	
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >นัดวันและเวลาเรียบร้อยแล้ว</span>&nbsp&nbsp
<?php }else{ ?>
&nbsp&nbsp<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >นัดวันและเวลาเรียบร้อยแล้ว</span>&nbsp&nbsp	
	<?php } ?>
<br>
Sale Comment <br>
<u>&nbsp&nbsp<span class="style39" ><?php echo $sale_comment;?></span>&nbsp&nbsp</u>
<br>
</td>
</tr>

<tr>
<td width="50%">
<?php if ($type_type =='1'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตาม Computer</span>&nbsp&nbsp
<?php }else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตาม Computer</span>&nbsp&nbsp
<?php }	?>
<br>
<?php if ($type_type =='2'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตามใบสั่งซื้อ</span>&nbsp&nbsp
<?php }else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตามใบสั่งซื้อ</span>&nbsp&nbsp
<?php }	?>
<br>
<?php if ($type_type =='3'){ ?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตามที่เขียน</span>&nbsp&nbsp
<?php }else{ ?>
<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >พิมพ์ตามที่เขียน</span>&nbsp&nbsp
<?php }	?>
<br>
<u>&nbsp&nbsp<span class="style39" ><?php echo $type_detail;?></span>&nbsp&nbsp</u>
</td>
<td>

<span class="style39" >สถานที่ติดตั้งเครื่อง</span>&nbsp<u>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" ><?php echo $install_place;?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</u>&nbsp&nbsp<br> 
</td>
</tr>
</table>
</p>
&nbsp<u>&nbsp<span class="style39" ><?php echo $sale_code; echo "/"; echo $sale_date;?></span>&nbsp</u>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style40" align="right"><?php echo $iv_no ; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u>&nbsp<span class="style39" ><?php echo $approve; echo "/"; echo $approve_date; ?></span>&nbsp</u>

<br>
&nbsp<span class="style40" >Sales Signature/Area/Date</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style40" align="right"><?php echo $iv_date; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<u>&nbsp<span class="style39" >Authorized Signature/Date</span>&nbsp</u></p>
<span class="style39" >อนุมัติวันที่ 29 สิงหาคม 2559 </span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" >FM-SA-04:Rev.9</span>
</p>
</body>
</html>