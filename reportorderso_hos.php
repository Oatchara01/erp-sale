<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<div class="w3-white">	
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>



<div class="w3-bar w3-quarter">


Sale : 

<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php
$strSQL5 = "SELECT * FROM tb_team_adm  ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
</div>

<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	</div>
	</p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
</form>


<?php
	
		$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
		$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';


	
	
?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">วันที่ลงทะเบียน</td >
			<td width="8%">เลขที่เอกสาร</td >
			<td width="8%">เลขที่ใบงาน CM</td >
			<td width="8%">เลขที่ใบยืม</td >
			<td width="8%">เลขที่ SR</td >
			<?php  if($_SESSION['name']=="พรทวี" or $_SESSION['name']=="ศิริพร"  or $_SESSION['name']=="พัชร์ชนัญ"){ ?>
			<td width="8%">วันที่ส่งของ</td >
			<?php } ?>
			<td width="6%">เลขที่ใบฝาก</td >
			<td width="10%">วันที่ออกเอกสาร</td >
			<td width="15%">รหัสสินค้า</td >
			<td width="25%">รายการสินค้า</td >
			<td width="20%">ชื่อผู้ออกบิล</td >
			<td width="8%">เขตการขาย</td >
			<td width="15%">เวลา Approve</td >
			<td width="10%">สถานะ</td >
			<td width="2%">สลิป</td >
			

	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');




$strSQL = "SELECT *  FROM hos__so  where  send_sup ='1' and iv_date !='0000-00-00'";

if($start_date !=""){ 
    $strSQL .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_so <= "'.$end_date.'"'; 
}else{
    $strSQL .= ' AND date_so >= "'.$to_day.'"'; 

}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}else{
    $strSQL .= ' AND date_so <= "'.$to_day.'"'; 

}

if($Keyword !=""){ 
	$strSQL .= ' AND bill_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or  brnp_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or  cm_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or order_refer_code  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or order_refer_code1  LIKE "%'.$Keyword.'%"'; 

}
		

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by id DESC  ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
		<?php if($objResult["have_order"]=='0'){?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>
				

				<td ><?php
 echo DateThai($objResult["date_so"]);
					?></td>
				<td ><?php echo $objResult["iv_no"];?></td>
				<td ><?php echo $objResult["cm_no"];?></td>
				<td ><?php echo $objResult["brnp_no"];?></td>
				<td ><?php echo $objResult["sr_no"];?></td>
				
				<?php  if($_SESSION['name']=="พรทวี" or $_SESSION['name']=="ศิริพร"  or $_SESSION['name']=="พัชร์ชนัญ"){ ?>
				
				<?php if($objResult["send_cs"]=='2'){	?>
						<td bgcolor="#00FF00" >
				<?php } else { ?>
						<td >	
							<?php } ?>
				
				
					
					<?php 
							if ($objResult["delivery_date"]=="0000-00-00") {
						echo $objResult["date_send_key"]; 
					}else{														 
						echo DateThai($objResult["delivery_date"]);?></td>
				
				<?php 
							}
					}
				?>
				
				<td ><div align="left"><?php echo $objResult["order_no"];?></div></td>
				<td >
					<?php if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}
					?> 
				</td>
				
				<td><div align="left">
					<?php
						$strSQL2 = "SELECT express_code FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						$Num_Rows2 = mysqli_num_rows($objQuery2);

						while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
							<?php
 
	echo $objResult2["express_code"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				
				
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
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
				<td ><div align="left"><?php echo $objResult["pre_name"];?><?php echo $objResult["bill_name"];?></div></td>
				
				<td ><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				<td ><div align="left"><?php echo Datethai($objResult["approve_date"]); ?>   <?php echo $objResult["approve_time"]; ?></div></td>
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				
				<td>
	
		<?php if($objResult['slip1'] !=''){ ?>
		<a href="upload/<?php echo $objResult['slip1']; ?>" target="_blank"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
		<?php } ?>
		
		<?php if($objResult['slip2'] !=''){ ?>
		</p>
		<a href="upload/<?php echo $objResult['slip2']; ?>" target="_blank"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
		<?php } ?>
		
		<?php if($objResult['slip3'] !=''){ ?>
	</p>
		<a href="upload/<?php echo $objResult['slip3']; ?>" target="_blank"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
		<?php } ?>
		
		<?php if($objResult['slip4'] !=''){ ?>
	</p>
		<a href="upload/<?php echo $objResult['slip4']; ?>" target="_blank"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
		<?php } ?>
		
		<?php if($objResult['slip4'] !=''){ ?>
	</p>
		<a href="upload/<?php echo $objResult['slip4']; ?>" target="_blank"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
		<?php } ?>
		
		</td>
					
			</tr>
		
		
		<?php }else if($objResult["have_order"]=='1' && $objResult["have_product"]=='2'){?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>
				

				<td ><?php
 echo DateThai($objResult["date_so"]);
					?></td>
				<td ><?php echo $objResult["iv_no"];?></td>
				<td ><?php echo $objResult["cm_no"];?></td>
				<td ><?php echo $objResult["brnp_no"];?></td>
				<td ><?php echo $objResult["sr_no"];?></td>
				<td ><div align="left"><?php echo $objResult["order_no"];?></div></td>
				<td >
					<?php if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}
					?> 
				</td>
				<td><div align="left">
					<?php
						$strSQL2 = "SELECT express_code,bom_ckk,code_bom FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						$Num_Rows2 = mysqli_num_rows($objQuery2);

						while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
							<?php
 if($objResult2["bom_ckk"]=='1'){
	 	echo $objResult2["code_bom"]; 
 }else{
	 
	echo $objResult2["express_code"]; 
 }
	
	?><br />
						<?php } ?>
				</div></td>
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 
	echo $objResult1["access_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				<td ><div align="left"><?php echo $objResult["pre_name"];?><?php echo $objResult["bill_name"];?></div></td>
				
				<td ><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				<td ><div align="left"><?php echo $objResult["add_date"];?></div></td>
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
			
			<td>
	
		<?php if($objResult['slip1'] !=''){ ?>
		<a href="upload/<?php echo $objResult['slip1']; ?>" target="_blank"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
		<?php } ?>
		
		<?php if($objResult['slip2'] !=''){ ?>
		</p>
		<a href="upload/<?php echo $objResult['slip2']; ?>" target="_blank"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
		<?php } ?>
		
		<?php if($objResult['slip3'] !=''){ ?>
	</p>
		<a href="upload/<?php echo $objResult['slip3']; ?>" target="_blank"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
		<?php } ?>
		
		<?php if($objResult['slip4'] !=''){ ?>
	</p>
		<a href="upload/<?php echo $objResult['slip4']; ?>" target="_blank"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
		<?php } ?>
		
		<?php if($objResult['slip4'] !=''){ ?>
	</p>
		<a href="upload/<?php echo $objResult['slip4']; ?>" target="_blank"><img src="img/preview.jpg" width="23" height="23" border="0" /></a>
		<?php } ?>
		
		</td>
			</tr>
		
		<?php } ?>
			<?php $i++; 
				}

?>
		
	</table>
	


      </p>
<?php include('foot.php'); ?>
</div>
</body>
</html>