
<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #FF0000;
}
.style30 {font-size: 12; }
.style32 {font-size: 14px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->
</style>
<?php error_reporting(~E_NOTICE);

include"dbconnect.php";
include"head.php";
$sale_code = $_GET['sale_code'];
?>
<div  class="w3-white" >
	<div class="w3-container">

<form action='save_brkangstsup.php' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
<body><br>
<center><font size="5">รายงานตรวจเช็คใบยืมค้างเคลียร์ เขตการขาย <?php echo $sale_code; ?> </font></center>
<br>
	
<input name="sale_area"  class="button4" type='hidden' id="sale_area" value="<?php echo $sale_code; ?>" >	
	
	
<table  border= "1" width="100%" class='w3-table'>
<tr >
<td width="8%" align="center"  ><div class="style32">วันที่</div></td>
<td width="8%" align="center" ><div class="style32">เลขที่ใบยืม</div></td>
<td width="10%" align="center" ><div class="style32">ชื่อลูกค้า</div></td>
<td width="15%" align="center" ><div class="style32">ชื่อสินค้า</div></td> 
<td width="10%" align="center" ><div class="style32">จำนวน</div></td> 
<td width="10%" align="center" ><div class="style32">หมายเลขเครื่อง</div></td> 
<td width="5%" align="center" ><div class="style32">ถูกต้อง</div></td> 
<td width="5%" align="center" ><div class="style32">ไม่ถูกต้อง</div></td> 
<td width="15%" align="center" ><div class="style32">หมายเหตุ</div></td> 

</tr>

<?php


$strSQL9 = "SELECT iv_no,stock_date,customer_name,address_name,product_id,count_send,sale_remark,order_id,sn_number,iv_date,id_submain  FROM (st__main LEFT JOIN st__sbmain ON st__main.ref_id=st__sbmain.ref_idd) WHERE sale_code = '".$sale_code."'  and type_doc = '3'";
$strSQL9 .=" order  by stock_date ASC";
$objQuery9 = mysqli_query($new,$strSQL9) or die ("Error Query [".$strSQL9."]");
$i = 1;
while($objResult9 = mysqli_fetch_array($objQuery9))
{

$strSQL = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult9["product_id"]."' ";
$objQuery = mysqli_query($new,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

?>



<tr>
	
<td align="center" ><div class="style33"><?php echo Datethai($objResult9["stock_date"]);?></div></td>
<td align="center" ><div class="style33"><?php echo $objResult9["iv_no"]; ?></div></td>
<td ><div align="left"  class="style33"><?php echo $objResult9["customer_name"]; ?></div></td>
<td ><div align="left" class="style33"><?php echo $objResult["sol_name"]; ?> <?php echo $objResult9["sale_remark"]; ?></div></td>
<td><div align="right"  class="style33"><?php echo $objResult9["count_send"]; ?> <?php echo $objResult["unit_name"]; ?></div></td>
<td ><div align="left" class="style33"><?php echo $objResult9["sn_number"]; ?></div></td>
<td><input type="radio" name="have_ckk[<?php echo $i?>]" id="have_ckk[<?php echo $i?>]"  class="w3-input w3-center" size="100%" value="1" requried></td>
<td><input type="radio" name="have_ckk[<?php echo $i?>]" id="have_ckk[<?php echo $i?>]"  class="w3-input w3-center" size="100%" value="2" requried></td>
<td><textarea name="des_sale[<?php echo $i?>]"  class="button4" id="des_sale[<?php echo $i?>]" style="width:100%" rows="2"></textarea>
<input name="sale_code[<?php echo $i?>]"  class="button4" type='hidden' id="sale_code[<?php echo $i?>]" value="<?php echo $sale_code; ?>" >
<input name="customer_name[<?php echo $i?>]"  class="button4" type='hidden' id="customer[<?php echo $i?>]" value="<?php echo $objResult9["customer_name"]; ?>" >
<input name="product_id[<?php echo $i?>]"  class="button4" type='hidden' id="product_id[<?php echo $i?>]" value="<?php echo $objResult9["product_id"]; ?>" >
<input name="count[<?php echo $i?>]"  class="button4" type='hidden' id="count[<?php echo $i?>]" value="<?php echo $objResult9["count_send"]; ?>" >
<input name="sn_number[<?php echo $i?>]"  class="button4" type='hidden' id="sn_number[<?php echo $i?>]" value="<?php echo $objResult9["sn_number"]; ?>" >	
<input name="iv_no[<?php echo $i?>]"  class="button4" type='hidden' id="iv_no[<?php echo $i?>]" value="<?php echo $objResult9["iv_no"]; ?>" ><input name="stock_date[<?php echo $i?>]"  class="button4" type='hidden' id="stock_date[<?php echo $i?>]" value="<?php echo $objResult9["stock_date"]; ?>" >
	<input name="iv_date[<?php echo $i?>]"  class="button4" type='hidden' id="iv_date[<?php echo $i?>]" value="<?php echo $objResult9["iv_date"]; ?>" >
	
<input name="id[<?php echo $i?>]"  class="button4" type='hidden' id="id[<?php echo $i?>]" value="<?php echo $objResult9["id_submain"]; ?>" >	
	
	</td>

<?php $i++; 

}
	?>
</tr>
</table>
<br><br>
	<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>
	<br>
</body>
	</form>

</div></div>