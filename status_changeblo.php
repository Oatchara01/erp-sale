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
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>ออเดอร์สั่งซื้อสินค้าแผ่น G-426</h4></div>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$strSQL = "SELECT ref_id,select_type_doc,register_date,sr_no,doc_no,doc_release_date,delivery_contact,approve_complete,ckk_h,bill_vat,select_type_doc,status_vat,print_vat,print_doc,close_mount,cancel_ckk,order_id,billing_name,approve_date,pre_name,cus_sb,que_ckk,bill_id,smp_ckk   FROM so__main  where glu_ckk='1' and approve_complete='Approve'";

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$strSQL .=" order  by ref_id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%" style="font-size: 12px;">เลขที่อ้างอิง</th>
<th width="5%" style="font-size: 12px;">ประเภทเอกสาร</th>
<th width="8%" style="font-size: 12px;">วันที่ลงทะเบียน</th>
<th width="8%" style="font-size: 12px;">เลขที่เอกสาร</th> 
<th width="8%" style="font-size: 12px;">วันที่ออกเอกสาร</th>
<th width="8%" style="font-size: 12px;">หมายเลขคำสั่งซื้อ</th> 
<th width="10%" style="font-size: 12px;">รายการสินค้า</th>
<th width="8%" style="font-size: 12px;">ราคารวม</th>
<th width="10%" style="font-size: 12px;">ชื่อลูกค้า</th>
<th width="8%" style="font-size: 12px;">ช่องทางการขาย</th>
<th width="5%" style="font-size: 12px;">สถานะลูกค้า</th>
<th width="5%" style="font-size: 12px;">สถานะการอนุมัติ</th>
<th width="5%" style="font-size: 12px;">แก้ไข</th>
<th width="5%" style="font-size: 12px;">ประวัติการสั่งซื้อ</th>
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
<td style="font-size: 12px;"><?php echo $objResult["order_id"];?></td>
<td style="font-size: 12px;"><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
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
$strSQL4 = "SELECT sum_amount FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' ";
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
	
<td style="font-size: 12px;">
	<a href="register_adminmk_edit.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
</td>	

<td style="font-size: 12px;">
	<a href="status_customer_sale.php?bill_id=<?php echo $objResult["bill_id"];?>"  target="_blank"><img src="img/create.png" width="23" height="23" border="0" /></a>
</td>	



</tr>


<?php
		  
$i++;
}
?>
	
	
	
</tbody>
	
	
	
	
	
	
	
	
	
	
	
</table>

 <div class="w3-panel"  style="font-size: 12px;">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ</strong>
      
	 <br> 
	  </div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 
</form>
</body>
</html>