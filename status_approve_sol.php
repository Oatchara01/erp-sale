<?php include('head.php'); ?>
<body>
	<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	<div class="w3-white">
<div class="w3-container w3-padding-large">

			<div class="w3-panel w3-light-gray"><h4>Status Approve</h4></div>
	
	</form>
<?php		  

include "dbconnect.php";

$name = $_SESSION['name'];
		
if($name=='รุจิรา'){	
$fff = " and employee_name IN ('MK','SOL91','SOL92','SOL93','SOL94')";	
}else{
$fff ="  and employee_name IN ('SOL0','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";	
}

$strSQL = "SELECT *  FROM so__main  where approve_complete ='Request' and cancel_ckk ='0' $fff";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by main_id DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);
// echo $strSQL;
?>
</p></p></p></p></p></p></p></p>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">ประเภทเอกสาร</th>
			<th width="10%">วันที่ลงทะเบียน</th>
			<th width="10%">เลขที่เอกสาร</th> 
			<th width="10%">วันที่ออกเอกสาร</th>
			<th width="10%">หมายเลขคำสั่งซื้อ</th>
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อลูกค้า</th>
			<th width="20%">ช่องทางการขาย</th>
			<th width="5%">เขตการขาย</th>
			<th width="20%">สถานะ</th>
			<th width="5%">ดูข้อมูล</th>
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				<td><?php if ($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='2'){
	echo 'ใบยืม'; }else { echo 'ใบสั่งขาย';  }?></td>

				<td><?php echo DateThai($objResult["register_date"]);?></td>
				<td><?php echo $objResult["doc_no"];?></td>
				<td>
					<?php if ($objResult["doc_release_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["doc_release_date"]);
					}
					?> 
				</td>
				<td><?php echo $objResult["order_id"];?></td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						///echo $strSQL;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php echo $objResult1["sol_name"];?><br />
						<?php } ?>
				</div></td>
				<td><div align="left">
ชื่อออกบิล : <?php echo $objResult["billing_name"];?><br>
ชื่อผู้รับสินค้า : <?php echo $objResult["delivery_contact"];?>
</div></td>
				<td><div align="left">
							<?php
								$strSQL2 = "SELECT so__main.* ,tb_salechannel.*  FROM (so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where ref_id = '".$objResult["ref_id"]."'";
								$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
								$Num_Rows2 = mysqli_num_rows($objQuery2);

								while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
									<?php echo $objResult2["salechannel_nameshort"];?>
									<?php } ?>
				</div></td>
				<td><div align="left"><?php echo $objResult["employee_name"];?></div></td>
				<?php
					if($objResult["approve_complete"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else if ($objResult["approve_complete"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["approve_complete"];?></td>
				<?php } ?>
				<td>
				<?php if ($objResult["select_type_doc"]=='3' or $objResult["select_type_doc"]=='4' ){ ?>
				<a href="allwell_approve_sale.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
				<?php }else if ($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='2'){ ?>

				<a href="allwell_approve_br.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>

						<?php } ?>
				
				</td>
			</tr>
			<?php $i++; } ?>
		</tbody>
	</table>

</div></div></div>

<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>