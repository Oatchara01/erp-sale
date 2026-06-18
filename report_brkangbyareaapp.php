
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
$ref_id = $_GET["ref_id"];

$strSQL2 = "SELECT send_stock,sale_code,employee_code,add_by FROM st__checkbr WHERE ref_id = '".$ref_id."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
$sale_code = $objResult2["sale_code"];

?>
<div  class="w3-white" >
	<div class="w3-container">

<form action='save_brkangstsuped1.php' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
<body><br>
<center><font size="5">รายงานตรวจเช็คใบยืมค้างเคลียร์ เขตการขาย <?php echo $sale_code; ?> </font></center>
<br><center>
	<?php if($objResult2["send_stock"]=='0'){ ?>
	<a href="sendbr_saleexaminestckk.php?ref_id=<?php echo $_GET["ref_id"];?>&sale_code=<?php echo $sale_code; ?>&add_by=<?php echo $objResult2["add_by"]; ?>"  class="w3-button w3-green w3-center"><font color="black">Approve</font></a>
	<a href="sendbr_saleexamineeditckk.php?ref_id=<?php echo $_GET["ref_id"];?>&sale_code=<?php echo $sale_code; ?>&employee_code=<?php echo $objResult2["employee_code"]; ?>"  class="w3-button w3-yellow w3-center"><font color="black">ส่งข้อมูลกลับแก้ไข</font></a>
	<?php } ?>
	</center><br>
<input name="sale_code"  class="button4" type='hidden' id="sale_code" value="<?php echo $objResult2["sale_code"]; ?>" >	
	
	
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
<input type='hidden' name='ref_id' id ='ref_id' value="<?php echo $_GET["ref_id"]; ?>" >
<?php


$strSQL9 = "SELECT id,iv_no,stock_date,customer_name,product_code,count,iv_date,sn_number,have_ckk,des_sale  FROM st__checkbr WHERE sale_code = '".$sale_code."'  and ref_id = '".$ref_id."'";
$strSQL9 .=" order  by stock_date ASC";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$i = 1;
while($objResult9 = mysqli_fetch_array($objQuery9))
{

$strSQL = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult9["product_code"]."' ";
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
<td>
<?php if($objResult9["have_ckk"]=='1'){ ?>
<input type="radio" name="have_ckk[<?php echo $i?>]" id="have_ckk[<?php echo $i?>]" checked="checked" class="w3-input w3-center" size="100%" value="1" requried>
	<?php }else{ ?>
<input type="radio" name="have_ckk[<?php echo $i?>]" id="have_ckk[<?php echo $i?>]"  class="w3-input w3-center" size="100%" value="1" requried>
	<?php } ?>
	</td>
<td>
<?php if($objResult9["have_ckk"]=='2'){ ?>
<input type="radio" name="have_ckk[<?php echo $i?>]" id="have_ckk[<?php echo $i?>]" checked="checked" class="w3-input w3-center" size="100%" value="2" requried>
	<?php }else{ ?>
<input type="radio" name="have_ckk[<?php echo $i?>]" id="have_ckk[<?php echo $i?>]"  class="w3-input w3-center" size="100%" value="2" requried>
	<?php } ?>	
	
	</td>
<td><textarea name="des_sale[<?php echo $i?>]"  class="button4" id="des_sale[<?php echo $i?>]" style="width:100%" rows="2"><?php echo $objResult9["des_sale"]; ?></textarea>
<input name="sale_code[<?php echo $i?>]"  class="button4" type='hidden' id="sale_code[<?php echo $i?>]" value="<?php echo $sale_code; ?>" >
<input name="customer_name[<?php echo $i?>]"  class="button4" type='hidden' id="customer[<?php echo $i?>]" value="<?php echo $objResult9["customer_name"]; ?>" >
<input name="product_id[<?php echo $i?>]"  class="button4" type='hidden' id="product_id[<?php echo $i?>]" value="<?php echo $objResult9["product_id"]; ?>" >
<input name="count[<?php echo $i?>]"  class="button4" type='hidden' id="count[<?php echo $i?>]" value="<?php echo $objResult9["count_send"]; ?>" >
<input name="sn_number[<?php echo $i?>]"  class="button4" type='hidden' id="sn_number[<?php echo $i?>]" value="<?php echo $objResult9["sn_number"]; ?>" >	
<input name="iv_no[<?php echo $i?>]"  class="button4" type='hidden' id="iv_no[<?php echo $i?>]" value="<?php echo $objResult9["iv_no"]; ?>" ><input name="stock_date[<?php echo $i?>]"  class="button4" type='hidden' id="stock_date[<?php echo $i?>]" value="<?php echo $objResult9["stock_date"]; ?>" >
	<input name="iv_date[<?php echo $i?>]"  class="button4" type='hidden' id="iv_date[<?php echo $i?>]" value="<?php echo $objResult9["iv_date"]; ?>" >
	
<input name="id[<?php echo $i?>]"  class="button4" type='hidden' id="id[<?php echo $i?>]" value="<?php echo $objResult9["id"]; ?>" >	
	
	</td>

<?php $i++; 

}
	?>
</tr>
</table>
<br><br>
	<center>
	<?php if($objResult2["send_stock"]=='0'){ ?>		
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
		<?php } ?>
</center>
	<br>
</body>
	</form>

</div></div>