<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายการออเดอร์</h4></div>

<input name='bill_id' type='hidden' value ="<?php echo $_GET["bill_id"]; ?>">
</form>
<?php	
$bill_id = isset($_GET['bill_id']) ? $_GET['bill_id'] : '';
include "dbconnect.php";
$strSQL = "SELECT ref_id,select_type_doc,register_date,sr_no,doc_no,doc_release_date,delivery_contact,approve_complete,ckk_h,bill_vat,select_type_doc,status_vat,print_vat,print_doc,close_mount,cancel_ckk,order_id,billing_name,approve_date,pre_name,cus_sb,que_ckk,bill_id,employee_name,sale_channel   FROM so__main  where bill_id ='".$bill_id."' and cancel_ckk='0' and doc_release_date !='0000-00-00'";


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by ref_id DESC";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%">เลขที่อ้างอิง</th>
<th width="10%">วันที่ลงทะเบียน</th>
<th width="10%">เลขที่เอกสาร</th> 
<th width="10%">วันที่ออกเอกสาร</th>
<th width="23%">รายการสินค้า</th>
<th width="13%">ราคารวม</th>
<th width="13%">หมายเลขเครื่อง</th>
<th width="22%">ชื่อออกบิล</th>
<th width="5%">เขตการขาย</th>
<th width="20%">ช่องทางการขาย</th>
<th width="5%">สถานะลูกค้า</th>
<th width="5%">สถานะการอนุมัติ</th>
<th width="5%">แก้ไข</th>
	
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
<td><?php echo $objResult["ref_id"];?></td>
<td><?php echo DateThai($objResult["register_date"]);?></td>
<td style="font-size: 12px;"><?php echo $objResult["doc_no"];?></td>
<td style="font-size: 12px;"><?php echo DateThai($objResult["doc_release_date"]);	?> </td>
<td style="font-size: 12px;"><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
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
	
<td style="font-size: 12px;"><div align="rihgt">
<?php
$strSQL54 = "SELECT sn_number FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery54 = mysqli_query($conn,$strSQL54) or die ("Error Query [".$strSQL4."]");
$Num_Rows54 = mysqli_num_rows($objQuery54);

while($objResult54 = mysqli_fetch_array($objQuery54))
{
?>
<?php
	echo $objResult54["sn_number"]; 
	?><br />
<?php
}
?>
</div>
</td>		
	
<td><div align="left"><?php echo $objResult["pre_name"];?><?php echo $objResult["billing_name"];?></div></td>

<td><?php echo $objResult["employee_name"];?></td>
	

<td><div align="left">

<?php
$strSQL2 = "SELECT salechannel_nameshort  FROM tb_salechannel  where salechannel_ID  = '".$objResult["sale_channel"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
?>


<?php echo $objResult2["salechannel_nameshort"]; ?>

</div></td>
	
<?php
 if($rs["customer_no"] !=''){
 if($rs["status_cus"]=='0'){ ?>
				<td bgcolor="#FFFF00">Gold Customer</td>
				<?php }else if($rs["status_cus"]=='1'){ ?>
				<td bgcolor="#CCFF99">Platinum Customer</td>
				<?php }else if($rs["status_cus"]=='2'){ ?>
				<td bgcolor="#00FF00">Daimond Customer</td>
				<?php
}									 
}else{ ?>
				<td></td>
				<?php } ?>	
	
<?php
					 if($objResult["approve_complete"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["approve_complete"];?></td>
				<?php }else if($objResult["cancel_ckk"]=='1'){	?>
						<td bgcolor="#FF3030"><?php echo 'ยกเลิก';?></td>
				<?php }
					else if ($objResult["approve_complete"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else{ ?>
					<td><?php echo $objResult["approve_complete"];?></td>
				<?php } ?>
		
<td>
	
	<a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
	
	</td>

</tr>


<?php
		  
$i++;
}
?>
</tbody>
	
	
<?php
	
$strSQL = "SELECT *  FROM hos__so  where  bill_id ='".$bill_id."' and status_doc ='Approve' and iv_no !='' and iv_date !='0000-00-00'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by ref_id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);

?>
	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
$sql = "SELECT status_cus,customer_no  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
?>
		
<tr>
<td><?php echo $objResult["ref_id"];?></td>
<td><?php echo DateThai($objResult["date_so"]);	?></td>
<td><?php echo $objResult["iv_no"];?></td>
<td><?php echo DateThai($objResult["iv_date"]); ?></td>
<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; ?><br>
						<?php } ?>
				</div></td>
	<td><div align="right">
<?php
$strSQL12 = "SELECT SUM(amount) AS amount FROM hos__subso WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
echo number_format($objResult12["amount"],0)."";  ?>
				</div></td>
	<td><div align="right">
<?php
$strSQL26 = "SELECT sn FROM hos__subso WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery26 = mysqli_query($conn,$strSQL26) or die ("Error Query [".$strSQL26."]");
while($objResult26 = mysqli_fetch_array($objQuery26)) { 
echo $objResult26["sn"];  ?><br>
	<?php } ?>
				</div></td>
				
				<td><div align="left"><?php echo $objResult["pre_name"];?><?php echo $objResult["bill_name"];?></div></td>
				
				<td><?php echo $objResult["sale_code"];?></td>
	<td></td>	
	<?php
 if($rs["customer_no"] !=''){
 if($rs["status_cus"]=='0'){ ?>
				<td bgcolor="#FFFF00">Gold Customer</td>
				<?php }else if($rs["status_cus"]=='1'){ ?>
				<td bgcolor="#CCFF99">Platinum Customer</td>
				<?php }else if($rs["status_cus"]=='2'){ ?>
				<td bgcolor="#00FF00">Daimond Customer</td>
				<?php
}									 
}else{ ?>
				<td></td>
				<?php } ?>	
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030" ><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030" ><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
	
				<td>
<a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
								
				</td>
				
				
			</tr>
		
	
			<?php $i++; 
				}

?>
	
	
	
</table>

 
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 

</body>
</html>