<?php include('head.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
</head>
<body>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4><?php if ($_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='ชลชินี') { ?>อนุมัติ<?php }else{ ?> Status <?php } ?>ออเดอร์สินค้าราคาต่ำกว่ากำหนด</h4></div>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$strSQL = "SELECT ref_id,select_type_doc,register_date,sr_no,doc_no,doc_release_date,delivery_contact,approve_complete,ckk_h,bill_vat,select_type_doc,status_vat,print_vat,print_doc,close_mount,cancel_ckk,order_id,billing_name,approve_date,pre_name,cus_sb,que_ckk,bill_id,smp_ckk,sale_channel   FROM so__main  where price_ckk='1' and approve_complete='Request' and cancel_ckk='0'";


if($start_date !=""){ 
    $strSQL .= ' AND register_date >= "'.$start_date.'"'; 
}


if($end_date !=""){ 
    $strSQL .= ' AND register_date <= "'.$end_date.'"'; 
}
	
if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND delivery_contact  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  = "'.$Keyword.'"'; 
	$strSQL .= ' or customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or doc_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or billing_name  LIKE "%'.$Keyword.'%"';

}
	
if($Keyword2 !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND order_id  LIKE "%'.$Keyword2.'%"'; 
}	
	
	if($Keyword1 !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND order_refer_code  LIKE "%'.$Keyword1.'%"'; 
	$strSQL .= ' or order_refer_code1  LIKE "%'.$Keyword1.'%"'; 
	}
	if($sale_channel !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND sale_channel  = "'.$sale_channel.'"'; 
	
	}

//echo 	$strSQL;

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$strSQL .=" order  by ref_id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<?php if ($_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='ชลชินี'  or $_SESSION['name']=='รุจิรา') { ?> 	
<th width="5%" style="font-size: 12px;">อนุมัติ</th>
<th width="5%" style="font-size: 12px;">ยกเลิก</th>
<?php } ?>	
<th width="5%" style="font-size: 12px;">เลขที่อ้างอิง</th>
<th width="5%" style="font-size: 12px;">ประเภทเอกสาร</th>
<th width="8%" style="font-size: 12px;">วันที่ลงทะเบียน</th>
<th width="8%" style="font-size: 12px;">เลขที่เอกสาร</th> 
<th width="8%" style="font-size: 12px;">วันที่ออกเอกสาร</th>
<th width="8%" style="font-size: 12px;">หมายเลขคำสั่งซื้อ</th> 
<th width="10%" style="font-size: 12px;">รายการสินค้า</th>
<th width="8%" style="font-size: 12px;">ราคารวม</th>
<th width="8%" style="font-size: 12px;"><font color ='red'>ราคาต่ำสุด</font></th>	
<th width="10%" style="font-size: 12px;">ชื่อลูกค้า</th>
<th width="8%" style="font-size: 12px;">ช่องทางการขาย</th>
<th width="5%" style="font-size: 12px;">สถานะลูกค้า</th>
<!--th width="5%" style="font-size: 12px;">สถานะการขาย</th-->
<th width="5%" style="font-size: 12px;">สถานะการอนุมัติ</th>

</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql = "SELECT status_cus,customer_no  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
?>
<tbody>

 <tr>
<?php if ($_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='ชลชินี'  or $_SESSION['name']=='รุจิรา') { ?> 		
<td bgcolor="#00FF00" style="font-size: 12px;">
	
<input type='checkbox' name = "order_ckk[<?php echo $objResult["ref_id"];?>]" value="1" id = "order_ckk[<?php echo $objResult["ref_id"];?>]" >

</td>
<td bgcolor="#FF3030" style="font-size: 12px;">
	
<input type='checkbox' name = "canncel_ckk[<?php echo $objResult["ref_id"];?>]" value="1" id = "canncel_ckk[<?php echo $objResult["ref_id"];?>]" >
</td>
<?php } ?>
<td style="font-size: 12px;"><?php echo $objResult["ref_id"];?>
<input type='hidden' name = "ref_id[<?php echo $objResult["ref_id"];?>]" value="<?php echo $objResult["ref_id"];?>" id = "ref_id[<?php echo $objResult["ref_id"];?>]" >
</td>
		
	
<td style="font-size: 12px;">
<?php if ($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='2'){
	echo 'ใบยืม'; }else { echo 'ใบสั่งขาย';  }?></td>
<td style="font-size: 12px;"><?php echo DateThai($objResult["register_date"]);?></td>
<?php if($objResult["que_ckk"] =='1'){ ?>
	<td bgcolor="#FF0000" style="font-size: 12px;">
	<?php }else{ ?>
<td style="font-size: 12px;">
<?php } ?>	<?php echo $objResult["doc_no"];?></td>
<td style="font-size: 12px;">
<?php if ($objResult["doc_release_date"]=="0000-00-00") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult["doc_release_date"]);
	}
	?> 
</td>
<td style="font-size: 12px;"><a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank"><?php echo $objResult["order_id"];?></a></td>
<td style="font-size: 12px;"><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'  order by id ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>
	
<td style="font-size: 12px;"><div align="rihgt">
<?php
$strSQL4 = "SELECT sum_amount FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."'  order by id ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);

while($objResult4 = mysqli_fetch_array($objQuery4))
{
?>
<?php
	echo number_format($objResult4["sum_amount"],2).""; 
	?><br />
<?php
}
?>
</div>
</td>
	
<td style="font-size: 12px;"><div align="left">
<?php
if($objResult["sale_channel"]=='34'){
$strSQL71 = "SELECT DISTINCT percen_price FROM (so__submain LEFT JOIN tb_product_tiktok ON so__submain.sku_code=tb_product_tiktok.code_jd) WHERE ref_idd = '".$objResult["ref_id"]."' and percen_price !='0.00' order by id ";
$objQuery71 = mysqli_query($conn,$strSQL71) or die ("Error Query [".$strSQL71."]");
$Num_Rows71 = mysqli_num_rows($objQuery71);

while($objResult71 = mysqli_fetch_array($objQuery71))
{
	
?>
<?php
	if($objResult71["percen_price"]!=''){
		
	echo number_format($objResult71["percen_price"],2).""; 
	}
	?><br />
<?php
}
	
	
}else{	
$strSQL71 = "SELECT DISTINCT percen_price FROM (so__submain LEFT JOIN tb_product_lzd ON so__submain.sku_code=tb_product_lzd.code_lazada) WHERE ref_idd = '".$objResult["ref_id"]."' and percen_price !='0.00' order by id ";
$objQuery71 = mysqli_query($conn,$strSQL71) or die ("Error Query [".$strSQL71."]");
$Num_Rows71 = mysqli_num_rows($objQuery71);

while($objResult71 = mysqli_fetch_array($objQuery71))
{
	
?>
<?php
	if($objResult71["percen_price"]!=''){
		
	echo number_format($objResult71["percen_price"],2).""; 
	}
	?><br />
<?php
}
}	
?>
</div>
</td>	
	
<td style="font-size: 12px;"><div align="left"><?php echo $objResult["pre_name"];?><?php echo $objResult["billing_name"];?></div></td>


	

<td style="font-size: 12px;"><div align="left">

<?php
$strSQL2 = "SELECT salechannel_nameshort  FROM (so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where ref_id = '".$objResult["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>


<?php echo $objResult2["salechannel_nameshort"]; ?>
<?php
}
?>
</div></td>
	
<?php
 if($rs["customer_no"] !=''){
 if($rs["status_cus"]=='0'){ ?>
				<td  style="font-size: 12px;" bgcolor="#FFFF00">Gold Customer</td>
				<?php }else if($rs["status_cus"]=='1'){ ?>
				<td  style="font-size: 12px;" bgcolor="#CCFF99">Platinum Customer</td>
				<?php }else if($rs["status_cus"]=='2'){ ?>
				<td  style="font-size: 12px;" bgcolor="#00FF00">Daimond Customer</td>
				<?php
}									 
}else{ ?>
				<td></td>
				<?php } ?>	
	
<?php
					 if($objResult["approve_complete"]=='Rejected'){	?>
						<td bgcolor="#FF3030" style="font-size: 12px;"><?php echo $objResult["approve_complete"];?></td>
				<?php }else if($objResult["cancel_ckk"]=='1'){	?>
						<td bgcolor="#FF3030" style="font-size: 12px;"><?php echo 'ยกเลิก';?></td>
				<?php }
					else if ($objResult["approve_complete"]=='Approve'){ ?>
				<td bgcolor="#00FF00" style="font-size: 12px;"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else{ ?>
					<td style="font-size: 12px;"><?php echo $objResult["approve_complete"];?></td>
				<?php } ?>
	
	
</tr>


<?php
		  
$i++;
}
?>
	
	
<?php
 if ($_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='ชลชินี' ) { 
	 
$strSQLh1 = "SELECT *  FROM hos__so  where status_doc ='Request' and send_sup ='1' and send_cm ='1'";
$objQueryh1 = mysqli_query($conn,$strSQLh1) or die ("Error Query [".$strSQLh1."]");
$Num_Rowsh1 = mysqli_num_rows($objQueryh1);
$strSQLh1 .=" order  by id DESC   ";
$objQueryh1  = mysqli_query($conn,$strSQLh1);	
	
$j = 1;
while($objResulth1 = mysqli_fetch_array($objQueryh1))
{
	
	
	?>	
	
	
 <tr>
<?php if ($_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='ชลชินี') {  //or $_SESSION['name']=='รุจิรา' or $_SESSION['name']=='ลักษณาวรรณ' ?> 	
<td bgcolor="#00FF00" style="font-size: 12px;">
	
<input type='checkbox' name = "order_ckk[<?php echo $objResulth1["ref_id"];?>]" value="1" id = "order_ckk[<?php echo $objResulth1["ref_id"];?>]" >

</td>
<td bgcolor="#FF3030" style="font-size: 12px;">
	
<input type='checkbox' name = "canncel_ckk[<?php echo $objResulth1["ref_id"];?>]" value="1" id = "canncel_ckk[<?php echo $objResulth1["ref_id"];?>]" >
</td>
<?php } ?>
<td style="font-size: 12px;"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResulth1["ref_id"];?>"><font color='black'><?php echo $objResulth1["ref_id"];?></font></a>
<input type='hidden' name = "ref_id[<?php echo $objResulth1["ref_id"];?>]" value="<?php echo $objResulth1["ref_id"];?>" id = "ref_id[<?php echo $objResulth1["ref_id"];?>]" >
</td>
		
	
<td style="font-size: 12px;"><?php  echo 'ใบสั่งขาย';  ?></td>
<td style="font-size: 12px;"><?php echo DateThai($objResulth1["date_so"]);?></td>
<?php if($objResult["que_ckk"] =='1'){ ?>
	<td bgcolor="#FF0000" style="font-size: 12px;">
	<?php }else{ ?>
<td style="font-size: 12px;">
<?php } ?>	<?php echo $objResult["iv_no"];?></td>
<td style="font-size: 12px;"><?php 	echo "-"; ?> </td>
<td style="font-size: 12px;"></td>
<td style="font-size: 12px;"><div align="left">
<?php
$strSQL7 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResulth1["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);

while($objResult7 = mysqli_fetch_array($objQuery7))
{
?>
<?php
	echo $objResult7["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>
	
<td style="font-size: 12px;"><div align="rihgt">
<?php
$strSQLh4 = "SELECT SUM(amount) AS amount FROM hos__subso  WHERE ref_idd = '".$objResulth1["ref_id"]."' ";
$objQueryh4 = mysqli_query($conn,$strSQLh4) or die ("Error Query [".$strSQLh4."]");
$objResulth4 = mysqli_fetch_array($objQueryh4);
echo number_format($objResulth4["amount"],2).""; ?></div></td>
	
<td style="font-size: 12px;"><div align="left"></div>
</td>	
	
<td style="font-size: 12px;"><div align="left"><?php echo $objResulth1["bill_name"];?></div></td>


	

<td style="font-size: 12px;"><div align="left"></div></td>
<td></td>
		
	
<?php
					 if($objResulth1["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030" style="font-size: 12px;"><?php echo $objResulth1["status_doc"];?></td>
				<?php }else if($objResulth1["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030" style="font-size: 12px;"><?php echo 'ยกเลิก';?></td>
				<?php }
					else if ($objResulth1["status_doc"]=='Approve'){ ?>
				<td bgcolor="#00FF00" style="font-size: 12px;"><?php echo $objResulth1["status_doc"];?></td>
				<?php }
					else{ ?>
					<td style="font-size: 12px;"><?php echo $objResulth1["status_doc"];?></td>
				<?php } ?>
	
	
</tr>	
	
	
	
	
<?php 
} 
 }	
	
	?>	
	
</tbody>
	
	
	
	
	
	
	
	
	
	
	
</table>

 <div class="w3-panel"  style="font-size: 12px;">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows+$Num_Rowsh1;?>
      <strong>รายการ</strong>
      
	 <br> 
<?php if ($_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='ชลชินี' or $_SESSION['name']=='รุจิรา') { ?> 		 
	 <div align="center">
		  <input type="button" name ="Submit" value="บันทึก" class="w3-button w3-teal" onClick="this.form.action='status_price_save.php'; submit()">
	</div>		 
<?php } ?>	  
	  </div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 
</form>
</body>
</html>