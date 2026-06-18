<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<?php

		$type_del = $_GET["type_del"];
		$del_date = $_GET["del_date"];
		$company = $_GET["company"];
	if($company=='1'){
	$type_company = 'ออลล์เวล ไลฟ์ บจก.';
	}else if($company=='2'){
		
	$type_company = 'โนเบิล เมด บจก.';	
	}
	
	if($type_del=='Kerry'){
	$address_1 = 'Kerry';
	}else if($type_del=='SPX Express'){
		
	$address_1 = 'SPX';	
	}
	?>

<center>
<h4>ตารางข้อมูลการจัดส่งสินค้า</h4>
	<h4>วันที่ <?php echo  Datethai($del_date); ?></h4>	
	</center><br>

</form>
<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";

?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			
			<th width="10%">วันที่</th>
			<th width="10%">เลขที่เอกสาร</th>
            <th width="8%">เลขที่พัสดุ</th>
			<th width="15%">สินค้า</th>
			<th width="10%">ประเถทขนส่ง</th>
			<th width="5%">แก้ไข</th>
			

	</thead>
<?php
$strSQL = "SELECT *  FROM tb_deloth  where type_del='".$type_del."' and del_date='".$del_date."'  and company='".$company."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);		
		
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				
				

				<td><?php
 echo DateThai($objResult["del_date"]);
					?></td>
				<td><?php echo $objResult["iv_no"];?></td>
				
				<td><div align="left"><?php echo $objResult["ref_no"];?></div></td>

				<td><div align="left"><?php echo $objResult["pro_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["type_del"];?></div></td>

				
<td>
				<a href="register_deloth_edit.php?id=<?php echo $objResult["id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				
				</td>
				
			</tr>
			<?php $i++; } ?>
		</tbody>
		
		
	<?php
$strSQL = "SELECT *  FROM tb_deloth  where type_del='".$type_del1."' and del_date='".$del_date."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);		
		
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				
				

				<td><?php
 echo DateThai($objResult["del_date"]);
					?></td>
				<td><?php echo $objResult["iv_no"];?></td>
				
				<td><div align="left"><?php echo $objResult["ref_no"];?></div></td>

				<td><div align="left"><?php echo $objResult["pro_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["type_del"];?></div></td>

				
<td>
				<a href="register_deloth_edit.php?id=<?php echo $objResult["id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				
				</td>
				
			</tr>
			<?php $i++; } ?>
		</tbody>	
		
		
	</table><br><br>
	
	
	
	<table border="1" width="100%" class="w3-table" style ="margin : 0px -10px;">
		<thead class="w3-gray">
			<td width="5%" style="font-size: 12px;" >เลขที่อ้างอิง</td>
			<td width="8%" style="font-size: 12px;">เลขที่เอกสาร</td>
			<td width="8%" style="font-size: 12px;">วันที่ออกเอกสาร</td>
			<td width="8%" style="font-size: 12px;" >รายการสินค้า</td>
			<td width="8%" style="font-size: 12px;">ชื่อผู้ออกบิล</td>
			<td width="8%" style="font-size: 12px;">เขตการขาย</td>
			<td width="8%" style="font-size: 12px;">สถานะ</td>
			<td width="2%" style="font-size: 12px;">จำนวนกล่อง</td>
			<td width="2%" style="font-size: 12px;">แก้ไข</td>
			
	</thead>
	
	<?php
$strSQL = "SELECT ref_id  FROM tb_register_data  where address_1 LIKE '%$address_1%' and start_date='".$start_date."' and ref_id LIKE '%SMP%'";

if($type_company !=''){
    $strSQL .= ' AND type_company = "'.$type_company.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$strSQL3 = "SELECT ref_idsmp,smp_no,smp_date,customer_name,sale_code,status_sup   FROM hos__smp  where ref_idsmp ='".$objResult["ref_id"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);
$objResult3 = mysqli_fetch_array($objQuery3);
	
		
		
		?>

<tr>
				
					<td><?php echo $objResult3["ref_idsmp"];?></td>
				

				<td><?php
 echo DateThai($objResult3["smp_date"]);
					?></td>
				
				<td><?php
 echo $objResult3["smp_no"];
					?></td>
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult3["ref_idsmp"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 
	echo $objResult1["sol_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				<td><div align="left"><?php echo $objResult3["customer_name"];?></div></td>
				<td><div align="left"><?php echo $objResult3["sale_code"];?></div></td>
				
				<?php if($objResult3["status_sup"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult3["status_sup"];?></td>
				<?php }
					else if ($objResult3["status_sup"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult3["status_sup"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult3["status_sup"];?></td>
				<?php } ?>
	<td  style="font-size: 10px;" ><?php echo $objResult["count_box"]+$Num_Rows3;?></td>
				<td>					
				<a href="register_adminsmp1_edit.php?ref_idsmp=<?php echo $objResult3["ref_idsmp"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
										
				</td>
				

			</tr>

<?php	
}
			
		
$i++; 
?>
		
	
	</table><br><br>
 </div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>