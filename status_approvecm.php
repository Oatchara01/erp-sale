<?php include('head.php'); 


?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-container w3-panel w3-light-gray"><h4>Approve ใบสั่งขายฝากขาย</h4></div>

</form>




<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">วันที่ลงทะเบียน</td >
			<td width="10%">เลขที่เอกสาร</td > 
			<td width="10%">วันที่ออกเอกสาร</td >
			<td width="30%">รายการสินค้า</td >
			<td width="15%">ยอดรวม</td >
			<td width="25%">ชื่อผู้ออกบิล</td >
			<td width="10%">เขตการขาย</td >
			<td width="10%">สถานะ</td >
			<td width="2%">VIP</td >
			<?php if($_SESSION['name']=='บรรเทิง'){ ?>
			<td width="8%">เวลาส่งอนุมัติ</td >
			<?php } ?>
			<td width="2%">ดูรายละเอียด</td >
	</thead>


<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
		$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';

	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');


$emid = $_SESSION['code'];


$strSQL = "SELECT *  FROM hos__so  where  status_doc ='Request' and send_cm ='2' and ic_ckk='1'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by id DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql = "SELECT vip_ckk  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);	
	
?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>
				

				<td ><?php
 echo DateThai($objResult["date_so"]);
					?></td>
				<td ><?php echo $objResult["iv_no"];?></td>
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
						$strSQL11 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
						$Num_Rows11 = mysqli_num_rows($objQuery11);

						while($objResult11 = mysqli_fetch_array($objQuery11)) { ?>
							<?php
 if($objResult11["bom_ckk"]=='0'){
	echo $objResult11["sol_name"]; 

	
	?><br />
					
						<?php }  
						}
					
$strSQL2 = "SELECT distinct code_bom  FROM hos__subso  WHERE ref_idd = '".$objResult["ref_id"]."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2)){
		
$code_bom	= $objResult2["code_bom"];	

$strSQL3 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product_bomhos ON hos__subso.code_bom=tb_product_bomhos.bom_code) WHERE ref_idd = '".$objResult["ref_id"]."' and code_bom = '".$code_bom."'";

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);
while($objResult3 = mysqli_fetch_array($objQuery3))
{
if($objResult3["code_bom"]!=""){
	echo $objResult3["bom_name"]; 
?> <br>
					<?php
	
 }
}
}
	
					
					
					
					?>
					
				</div></td>
				<td style="font-size: 12px;"><div align="rihgt">
<?php
$strSQL4 = "SELECT SUM(amount) AS amount FROM hos__subso  WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);
$objResult4 = mysqli_fetch_array($objQuery4);

	echo number_format($objResult4["amount"],2).""; 
	?>
</div>
</td>	
				<td ><div align="left"><?php echo $objResult["bill_name"];?></div></td>
				<td ><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				<?php  if($rs["vip_ckk"]=='1'){ ?>
				<td  bgcolor="#00FF00">VIP</td>
				<?php }else{ ?>
				<td></td>
				<?php } ?>
				<?php if($objResult["status_doc"] !='Rejected' or $objResult["status_doc"] !='Approve'){	?> 
<?php if($_SESSION['name']=='บรรเทิง'){ ?>
<td>
<?php echo $objResult["send_supname"];?><br>
<?php if($objResult["send_supdate"]!='0000-00-00 00:00:00'){ echo Datethai($objResult["send_supdate"]); ?> <?php   echo   substr($objResult["send_supdate"],-9); }    ?>				
</td>					
<?php } ?>	<td>				
				<a href="register_cmhos_approve.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				
								
				</td><?php } ?>
				
			</tr>
			<?php 

	$i++; 			
}
		
?>
		
	</table>
 <br>
 </div></div>


     
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
</body>
</html>