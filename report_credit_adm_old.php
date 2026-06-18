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
.style37 {font-size: 16px; color: #000000; }
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

$ref_credit=$_GET["ref_credit"];



include"dbconnect.php";

$strSQL25="Update  tb_credit_note set print_adm = '1'  where ref_credit ='".$ref_credit."'";


$objQuery25 = mysqli_query($conn,$strSQL25);


$strSQL = "SELECT * from tb_credit_note WHERE ref_credit = '".$ref_credit."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM tb_subcredit WHERE ref_creditt = '".$ref_credit."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

/*$strSQL3 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_id."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);*/

$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM tb_subcredit WHERE ref_creditt = '".$ref_credit."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";


$strSQL16 = "SELECT SUM(sum_discount) AS discount_unit FROM tb_subcredit WHERE ref_creditt = '".$ref_credit."' ";
$objQuery16 = mysqli_query($conn,$strSQL16);
$objResult16= mysqli_fetch_array($objQuery16);

$discount_unit1=$objResult16['discount_unit'];
$discount_unit= number_format( $discount_unit1,2)."";


$id = $objResult['id'];
$ref_credit = $objResult['ref_credit'];
$date_credit = DateThai($objResult['date_credit']);
$customer_name = $objResult['customer_name'];
$address_name = $objResult['address_name'];
$customer_tel = $objResult['customer_tel'];
$iv_no_ref = $objResult['iv_no_ref'];
$ttype_doc = $objResult['ttype_doc'];
$return_des = $objResult['return_des'];
$send_return_name = $objResult['send_return_name'];
$date_send_return = DateThai($objResult['date_send_return']);
$receive_name = $objResult['receive_name'];
$date_receive = DateThai($objResult['date_receive']);
$sale_name = $objResult['sale_name'];
$sale_date = DateThai($objResult['sale_date']);
$stock_complete = $objResult['stock_complete'];
$stock_name = $objResult['stock_name'];
$stock_date = DateThai($objResult['stock_date']);
$warraty_ckk = $objResult['warraty_ckk'];
$credit_ckk = $objResult['credit_ckk'];
$credit_no = $objResult['credit_no'];
$type_return_ckk = $objResult['type_return_ckk'];
$type_return_no = $objResult['type_return_no'];
$dis_credit = $objResult['dis_credit'];
$stock_des = $objResult['stock_des'];



?>
<body>


	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;ก&nbsp;
	<a href=""><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;C





<center>
<span class="style15">ใบสั่งลดหนี้</span><br>

<span class="style15">(Credit Note Order)</span>
</center>
</p>





&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39">Date :</span> <u>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $date_credit; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</u>

<br>
<span class="style40">ชื่อลูกค้า : </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $customer_name; ?></span>&nbsp;&nbsp;<hr color="black"  width="90%" size="0.1" align="right">
<span class="style40">ที่อยู่่ : </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $address_name; ?></span>&nbsp;&nbsp;<hr color="black"  width="90%" size="0.1" align="right">
<span class="style40">เบอร์โทร : </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $customer_tel; ?></span>&nbsp;&nbsp;<hr color="black"  width="90%" size="0.1" align="right">


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="100%" align="left" class="style30">


<span class="style39">อ้างอิงใบส่งสินค้าเลขที่ :</span> <u>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $iv_no_ref; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</u>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php
if ($ttype_doc =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39" >คืนสินค้า</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >คืนสินค้า</span>&nbsp&nbsp

			<?php
	}
			?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php
if ($ttype_doc =='2'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39" >ส่วนลด</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ส่วนลด</span>&nbsp&nbsp

			<?php
	}
			?>

</td>
</tr>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">ITEM</td>
<td width="10%" align="center" class="style30">Product Code</td>
<td width="30%" align="center" class="style30">Description</td> 
<td width="10%" align="center" class="style30">Qty</td> 
<td width="10%" align="center" class="style30">Unit Price</td> 
<td width="10%" align="center" class="style30">Amount</td> 
</tr>
<?php

$strSQL1 = "SELECT * FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) where ref_creditt = '".$ref_credit."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["sum_amount"];
$sum_amount= number_format($sum_amount1,2)."";
$price1  =$objResult1["unit_price"];
$price= number_format( $price1,2)."";
$access_name  =$objResult1["access_name"];
$access_code  =$objResult1["access_code"];
$count  =$objResult1["count"];
$unit  =$objResult1["unit_name"];

?>
	<tr>
<td align="center" class="style37"><?php echo $i;?></td>
<td align="left" class="style37"><?php echo $access_code;?></td>
<td align="left" class="style37"><?php echo $access_name;?></td>
<td align="right" class="style37"><?php echo $count;?> &nbsp <?php echo $unit;?></td>
<td align="right" class="style37"><?php echo $price;?></td>
<td align="right" class="style37"><?php echo $sum_amount;?></td>



<?php $i++; } ?>
</tr>
</table>


<table border="1" width="100%" class='w3-table'>
<tr>
<td  align="right" >ส่วนลดพิเศษ : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $discount_unit;?></td>

</tr>

</table>

<table border="1" width="100%" class='w3-table'>
<tr>
<td  align="right" >ราคาสุทธิ : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $summary;?></td>

</tr>

</table><br>
<span class="style40">สาเหตุที่คืน : </span>&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $return_des; ?></span>&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;
</p>

<table border="1" width="100%" class='w3-table'>
<tr>
<td width="50%" align="center" ><br>
&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $send_return_name; ?>&nbsp;&nbsp;/&nbsp;&nbsp; <?php echo $date_send_return ; ?></span>&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;<br>
<?php echo "ผู้ขอคืนสินค้า / วันที่"; ?> <br>.

</td>

<td width="50%" align="center" >

<br>
&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $receive_name; ?>&nbsp;&nbsp;/&nbsp;&nbsp; <?php echo $date_receive ; ?></span>&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;<br>
<?php echo "ผู้รับคืนสินค้า / วันที่"; ?> <br>.
</td>

</tr>


<tr>
<td width="50%" align="center" >
<br>
&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $sale_name; ?>&nbsp;&nbsp;/&nbsp;&nbsp; <?php echo $sale_date ; ?></span>&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;<br>
<?php echo "ผู้แทนขาย / วันที่"; ?> <br>.


</td>

<td width="50%" align="center" >

<br>
&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;<br>
<?php echo "ผู้อนุมัติ / วันที่"; ?> <br>.

</td>

</tr>


<tr>
<td width="50%" align="center" ><br>
&nbsp;&nbsp; ได้รับสินค้าข้างต้นคืนคลังสินค้าแล้วโดยสภาพ<br>


<?php
if ($stock_complete =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39" >สมบูรณ์</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >สมบูรณ์</span>&nbsp&nbsp

			<?php
	}
			?>
&nbsp;&nbsp;&nbsp;
			<?php
if ($stock_complete =='2'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39" >ไม่สมบูรณ์</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ไม่สมบูรณ์</span>&nbsp&nbsp

			<?php
	}
			?>

			
	
	&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $stock_des; ?>&nbsp;&nbsp;
	</span>&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;<br>
	
&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $stock_name; ?>&nbsp;&nbsp;/&nbsp;&nbsp; <?php echo $stock_date ; ?></span>&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;<br>
<?php echo "ผู้แทนขาย / วันที่"; ?> <br>

<?php
if ($warraty_ckk =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39" >ดำเนินการปรับปรุงข้อมูลใบรับประกันสินค้าแล้ว</span>&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ดำเนินการปรับปรุงข้อมูลใบรับประกันสินค้าแล้ว</span>&nbsp&nbsp

			<?php
	}
			?><br>.


</td>

<td width="50%" align="left" >

&nbsp;&nbsp;&nbsp;แผนกบัญชี <br>
&nbsp;&nbsp&nbsp;&nbsp
<?php
if ($credit_ckk =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39" >ทำใบลดหนี้เลขที่</span>&nbsp&nbsp&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ทำใบลดหนี้เลขที่</span>&nbsp&nbsp&nbsp&nbsp

			<?php
	}
			?>
			&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $credit_no; ?></span>&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;<br>

&nbsp;&nbsp&nbsp;&nbsp
<?php
if ($type_return_ckk =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39" >ชำระคืนค่าสินค้าโดย</span>&nbsp&nbsp&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ชำระคืนค่าสินค้าโดย</span>&nbsp&nbsp&nbsp&nbsp

			<?php
	}
			?>
			&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;<span class="style39"><?php echo $type_return_no; ?></span>&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;<br>


&nbsp;&nbsp&nbsp;&nbsp
<?php
if ($dis_credit =='1'){

?>
<a><img src="img/cor.jpeg" width="35"  height="20" /></a>&nbsp;<span class="style39" >ลดหนี้</span>&nbsp&nbsp&nbsp&nbsp
	<?php }else{
		?>
	<a><img src="img/box.gif" width="15"  height="15" /></a>&nbsp;&nbsp;<span class="style39" >ลดหนี้</span>&nbsp&nbsp&nbsp&nbsp

			<?php
	}
			?><br>.


</td>

</tr>

</table>



<span class="style39" >อนุมัติวันที่ 16 ม.ค. 2561 </span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="style39" >FM-SA-13:Rev.2</span>
</p>
</body>
</html>