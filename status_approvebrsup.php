<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white w3-container w3-padding-large">

<div class="w3-container w3-panel w3-light-gray"><h4>Approve Borrow (BR)</h4></div>




<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">วันที่ลงทะเบียน</td >
			<td width="10%">เลขที่เอกสาร</td > 
			<td width="10%">วันที่ออกเอกสาร</td >
			<td width="30%">รายการสินค้า</td >
			<td width="25%">ชื่อผู้ออกบิล</td >
			<td width="10%">เขตการขาย</td >
			<td width="10%">สถานะ</td>
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

if($emid=='SS1'){
$sddd = " AND sale_code IN ('S15','S16','S21','S22','S14')";
}else if($emid=='SS2'){
$sddd = " AND sale_code IN ('S11','S12','S17','S24','S13')";	
}else if($emid=='SS3'){
$sddd = " AND sale_code IN ('SM1','S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
}else if($emid=='SS5'){
$sddd = " AND sale_code IN ('S31','S32')";	
}else if($emid=='SUP_EN'){
$sddd = " and sale_code LIKE '%EN%'";	
}else if($emid=='SUP_MK'){
$sddd = " and  sale_code  IN ('MK','SOL91','SOL92','SOL93','SOL94','SOL99')";			
}else{
$sddd = "";			
}
	

		
if($emid=='SS5'){
$status_doc = "AND status_doc ='Pending review'";	
}else{
$status_doc = "AND status_doc ='Request' ";		
}


$strSQL = "SELECT *  FROM hos__br  where send_sup ='1' and send_dm ='0' $sddd $status_doc ";
//echo $strSQL;	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by id DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id_br"];?></td>
				

				<td ><?php
 echo DateThai($objResult["date_br"]);
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
						$strSQL2 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$objResult["ref_id_br"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						$Num_Rows2 = mysqli_num_rows($objQuery2);

						while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
							<?php
 
	echo $objResult2["sol_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				<td ><div align="left"><?php echo $objResult["customer"];?></div></td>
				<td ><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				
<?php if($_SESSION['name']=='บรรเทิง'){ ?>
<td>
<?php echo $objResult["send_supname"];?><br>
<?php if($objResult["send_supdate"]!='0000-00-00 00:00:00'){ echo Datethai($objResult["send_supdate"]); ?> <?php   echo   substr($objResult["send_supdate"],-9);   }  ?>				
</td>					
<?php } ?>	
				<td  >
				<?php if($objResult["status_doc"] !='Rejected' or $objResult["status_doc"] !='Approve'){	?> 

				<a href="register_supbrhos_approve.php?ref_id_br=<?php echo $objResult["ref_id_br"];?>"><img src="img/sticker.png" width="23" height="23" border="0" /></a>
				<?php } ?>
								
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