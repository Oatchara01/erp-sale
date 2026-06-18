<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายการเก็บเงินปลายทาง</h4></div>
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">วันที่เอกสาร</th>
			<th width="10%">เลขที่เอกสาร</th>
			<th width="25%">ชื่อลูกค้า</th>
			<th width="15%">สินค้า</th>
			<th width="5%">จำนวนเงิน</th>
			<th width="5%">สถานะ</th>
			<th width="10%">วันที่รับเงิน</th>
			<th width="10%">หมายเหตุโชว์รูม</th>
			<th width="2%">แก้ไข</th>		
	</thead>
<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");


include "dbconnect_acc.php";
include "dbconnect.php";

if($Keyword!='' or $start_date!='' or $end_date!=''){		
		
$strSQL ="SELECT * FROM tb_register_data WHERE  cash='25' and ref_id NOT LIKE '%SO%'";

if($start_date !=""){ 
    $strSQL .= ' AND date_inv >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_inv <= "'.$end_date.'"'; 
}
if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND IV_number  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or customer_name  LIKE "%'.$Keyword.'%"'; 
	 

}

//$strSQL .=" order  by main_id DESC ";
$objQuery = mysqli_query($code,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);




$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				
				<td><?php echo DateThai($objResult["date_inv"]); ?></td>
				<td><?php echo $objResult["IV_number"];?></td>
				<td><?php echo $objResult["customer_name"];?></td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name,unit_name,sale_count FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php	echo $objResult1["sol_name"]; ?> <?php	echo $objResult1["sale_count"]; ?> <?php	echo $objResult1["unit_name"]; ?><br>
						<?php } ?>
				</div></td>
				
				
				<td><div align="right"><?php echo number_format($objResult["unit_cash"],2).""; ?></div></td>
				
				<?php
					if($objResult["summary_cash"]=='ไม่สมบูรณ์'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["summary_cash"];?></td>
								<?php }
					else if ($objResult["summary_cash"]=='สมบูรณ์'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["summary_cash"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["summary_cash"];?></td>
				<?php } ?>
			
					<td><?php if($objResult["date_cash"]=='0000-00-00'){ }else if($objResult["date_cash"]==''){ }else{ echo DateThai($objResult["date_cash"]); } ?></td>
					<td ><?php echo $objResult["remark_salehc"];?></td>
				
	<td><a href="register_waitcod.php?ref_id=<?php echo $objResult["ref_id"];?>&Keyword=<?php echo $_GET['Keyword']; ?>&start_date=<?php echo $_GET['start_date']; ?>&end_date=<?php echo $_GET['end_date']; ?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
			</tr>
			
		</tbody>
		<?php $i++;
} 
}
		?>
	</table>

</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
</body>
</html>