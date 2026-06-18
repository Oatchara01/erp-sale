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

$strSQL = "SELECT * FROM  hos__br WHERE ref_id_br = '".$ref_id_br."' ";
//echo  $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL3 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_id_br."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);


$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subbr WHERE ref_idd_br = '".$ref_id_br."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";


$month = date('m');
$day = date('d');
$year = date('Y');

$today1 = $year . '-' . $month . '-' . $day;
$today=DateThai($today1);


$ref_id_br=$objResult["ref_id_br"];
$dep_no =$objResult["dep_no"];
$job_no =$objResult["job_no"];
$iv_no =$objResult["iv_no"];
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

if($objResult["delivery_date"]!=''){
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

?>


<span class="style39">เลขที่อ้างอิง</span> <u><span class="style39"><?php echo $ref_id_br; ?></span></u>
<br>
	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;ก&nbsp;
	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;C



	<a href=""><img src="img/nb_logo.jpg" width="80" align="right" height="30" /></a><p>

<center>
<span class="style15">ใบสั่งพิมพ์ใบเบิกจ่ายสินค้า</span><br>

<span class="style15">(Request for issuing stock movement order)</span>
</center>

<span class="style39">ฝากส่งสินค้าเลขที่</span> <u>&nbsp;&nbsp;<span class="style39"><?php echo $dep_no; ?></span>&nbsp;&nbsp;</u><br>

<span class="style39">เลขที่ลงงาน</span> <u>&nbsp;&nbsp;<span class="style39"><?php echo $job_no; ?></span>&nbsp;&nbsp;</u>

<span class="style33" align="right"><div align="right"><?php echo $iv_no;?></div></span>
<div align="right"><?php echo barcode($iv_no);?></div>

<table border="1" width="100%" class='w3-table'>
<tr>
<td>
<span class="style40">ชื่อลูกค้า/รพ. </span>&nbsp;&nbsp;<span class="style39"><?php echo $customer; ?></span><hr color="black"  width="80%" size="0.1" align="right">

<span class="style40">ทีอยู่</span>&nbsp;&nbsp;<span class="style39"><?php echo $address; ?></span><hr color="black"  width="90%" size="0.1" align="right">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php  ?></span><hr color="black"  width="90%" size="0.1" align="right">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $province_id; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $zip_code; ?></span><hr color="black"  width="100%" size="0.1" align="right">

<span class="style40">สถานที่ส่งสินค้า </span>&nbsp;&nbsp;<span class="style39"><?php echo  $delivery_name; ?></span><hr color="black"  width="70%" size="0.1" align="right">
<span class="style40">Ward/ชั้น/ตึก </span>&nbsp;&nbsp;<span class="style39"><?php echo $delivery_address; ?>&nbsp;&nbsp;<span class="style39"><?php echo $postcode; ?></span><hr color="black"  width="70%" size="0.1" align="right">
<span class="style40">ชื่อผู้ติดต่อ/โทร</span>&nbsp;&nbsp;<span class="style39"><?php echo $delivery_contact1; ?></span><hr color="black"  width="70%" size="0.1" align="right">




</td>

<td>


<span class="style40">วันที่ </span>&nbsp;&nbsp;<span class="style39"><?php echo  $date_br; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<span class="style40">เลขที่ </span>&nbsp;&nbsp;<span class="style39"><?php echo $iv_no; ?></span><hr color="black"  width="100%" size="0.1" align="right">
<span class="style30">วัตถุประสงค์การเบิก </span></p>

<?php if($objective=='1'){ ?>

<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;เป็นสินค้าสำรอง 

<?php }else{ ?>

&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;เป็นสินค้าสำรอง 
	<?php } ?>


<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $objective_des1; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>

<?php if($objective=='2'){ ?>

	<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;สำหรับลูกค้าทดลองใช้ 

<?php }else{ ?>

&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;สำหรับลูกค้าทดลองใช้ 

	<?php } ?>

<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $objective_des2; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><span class="style39">วัน</span><br>


<?php if($objective=='3'){ ?>

<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;ส่งสินค้าล่วงหน้าเพื่อรอรับใบส่งซื้อ<br>

<?php }else{ ?>

&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;ส่งสินค้าล่วงหน้าเพื่อรอรับใบส่งซื้อ<br>

<?php } ?>
<?php if($objective=='4'){ ?>

<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;แลกเปลี่ยนสินค้า ตามใบงานบริการเลขที่

<?php }else{ ?>

&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;แลกเปลี่ยนสินค้า ตามใบงานบริการเลขที่ 
<?php } ?>

<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $objective_des4; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><span class="style39">*</span><br>
<span class="style35">(เฉพาะกรณีแลกเปลี่ยนสินค้าที่มีหมายเลขเครื่องต้องระบุเลขที่ใบงานบริการทุกครั้ง)</span><br>
<?php if($objective=='4'){ ?>

<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;อื่นๆ

<?php }else{ ?>

&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;อื่นๆ
<?php } ?>


&nbsp;&nbsp;<?php echo $objective_des5; ?><hr color="black"  width="80%" size="0.1" align="right">
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

<?php

$strSQL1 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' ";
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
$product_name  =$objResult1["access_name"];
$sale_count  =$objResult1["count"];
$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];
$product = "$product_name:$sale_remark";

/*echo barcode($product_code)."<br>";
echo $product_code."<br>";*/
?>
	<tr>
<td align="center" class="style39"><?php echo $i;?></td>
<td align="center" class="style39"><?php 
		echo $product_code;

?></td>
<td align="left" class="style39"><?php echo $product;?> </td>
<td align="right" class="style39"><?php echo $sale_count;?> &nbsp <?php echo $unit_name;?></td>
<td align="right" class="style39"><?php echo $price_per_unit;?></td>
<td align="right" class="style39"><?php echo $sum_amount;?></td>



<?php
$i++;
}

?>
</tr>
</table>
<table border= "1" width="100%" class='w3-table'>

<tr>
<td><br>

<?php
if ($sn_ckk=='1'){
?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39">ต้องการ</span>
<?php
}else{
	?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39">ต้องการ</span>


		<?php
		}
		?>
&nbsp;&nbsp;<span class="style39">Serial No.</span>&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $sn; ?></span>&nbsp;&nbsp;&nbsp;</u><br>


</td>
</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td  align="right" >Total : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $summary;?></td>

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
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >บริษัทจัดส่ง</span>&nbsp&nbsp

			<?php
	}
			?>
		
<br>
<?php
if ($delivery_type =='2'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >Engineer รับเอง</span>&nbsp&nbsp
	<?php }else{
		?>
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Engineer รับเอง</span>&nbsp&nbsp

			<?php
	}
			?>
			
<br>
<?php
if ($delivery_type =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >Sale รับเอง</span>&nbsp&nbsp
	<?php }else{
		?>
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >Sale รับเอง</span>&nbsp&nbsp

			<?php
	}
			?>
			<br>

<?php
if ($want_bus =='1'){

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
&nbsp&nbsp&nbsp&nbsp<span class="style40">วันที่ </span>&nbsp;&nbsp;<u>&nbsp;&nbsp;<span class="style39"><?php echo $delivery_date; ?></span>&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;<span class="style40">เวลา </span><u>&nbsp;<span class="style39"><?php echo $delivery_time; ?></span>&nbsp;</u><br>

<?php
if ($call_customer =='1'){
?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >โทรแจ้งลูกค้าก่อนไป</span>&nbsp&nbsp
	<?php }else{
		?>
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >โทรแจ้งลูกค้าก่อนไป</span>&nbsp&nbsp

			<?php
	}
			?>
<br>
<?php
if ($fix_date =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;&nbsp;<span class="style39" >นัดวันและเวลาเรียบร้อยแล้ว</span>&nbsp&nbsp
	<?php }else{
		?>
	&nbsp;&nbsp;<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >นัดวันและเวลาเรียบร้อยแล้ว</span>&nbsp&nbsp

			<?php
	}
			?>
<br>

<span class="style40">หมายเหตุ </span>&nbsp;&nbsp;&nbsp;&nbsp; <span class="style39"><?php echo $sale_comment; ?>

<hr color="black"  width="80%" size="0.1" align="right">

<span class="style40">.</span>&nbsp;<span class="style39">&nbsp;<hr color="black"  width="80%" size="0.1" align="right">






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

			&nbsp&nbsp&nbsp&nbsp<span class="style39"><?php echo $returns_name; ?></span>
<hr color="black"  width="70%" size="0.1" align="right">

<span class="style39" >วันที่รับคืน</span>&nbsp&nbsp<span class="style39"><?php echo $returns_date; ?><hr color="black"  width="70%" size="0.1" align="right">
<span class="style39" >เวลาที่รับคืน</span>&nbsp&nbsp<span class="style39"><?php echo $returns_time; ?><hr color="black"  width="70%" size="0.1" align="right">

<span class="style39" >Ward/ชั้น/ตึก</span>&nbsp&nbsp<span class="style39"><?php echo $returns_address; ?><hr color="black"  width="70%" size="0.1" align="right">
<span class="style39" >.</span>&nbsp&nbsp<hr color="black"  width="70%" size="0.1" align="right">
<span class="style39" >ชื่อผู้ติดต่อ/โทร</span>&nbsp&nbsp<span class="style39"><?php echo $returns_contact; ?><hr color="black"  width="70%" size="0.1" align="right">
<span class="style39" >.</span>&nbsp&nbsp<hr color="black"  width="70%" size="0.1" align="right">


</td>

</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>

<td>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" >ผู้เบิกสินค้า</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" >ผู้อนุมัติ</span><br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" >(</span>&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" ><?php echo $sale_code; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;<span class="style40" >)</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style40" >(</span>&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" ><?php echo $approve; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;<span class="style40" >)</span><br>



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" >วันที่</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" ><?php echo $sale_date; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;วันที่
&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style40" ><?php echo $approve_date; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;<br><br>


</td>

</tr>
</table>

<span class="style35" >อนุมัติวันที่ 29 สิงหาคม 2559 </span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style35" >FM-SA-04:Rev.9</span><br>
<span class="style35" ><?php echo $date   ; ?></span></p></p>


</p>
</body>

</html>
