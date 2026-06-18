<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
</form>

<br>
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-container w3-panel w3-light-gray"><h4>อนุมัติใบจองสินค้า</h4></div>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">วันที่ลงทะเบียน</th>
			<th width="10%">วันที่ต้องการสินค้า</th>
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อลูกค้า</th>
			<th width="10%">เขตการขาย</th>
			<th width="10%">สถานะ</th>
			<th width="5%">ดูรายละเอียด</th>
			
	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

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
$status_doc = "AND status_doc ='Request'";		
}		
		
/*$strSQL1 = "SELECT * FROM tb_user_team WHERE em_id = '".$emid."' ";
$objQuery1 = mysqli_query($com,$strSQL1) or die(mysqli_error());
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$zone=$objResult1["sale_code"];*/
//echo $zone;

$strSQL = "SELECT *  FROM hos__jongproduct  where send_sup = '1' and status_doc = 'Request' $status_doc $sddd";

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$strSQL .=" order  by id_jong DESC ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				
<td><?php
 echo DateThai($objResult["date_jong"]);
					?></td>
				
				<td><?php
 echo $objResult["date_jong"];
					?></td>
				
				
				<td><div align="left">
					<?php
						$strSQL2 = "SELECT * FROM (hos__subjongpro LEFT JOIN tb_product ON hos__subjongpro.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'  ";
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
				<td><div align="left"><?php echo $objResult["customer"];?></div></td>
				<td><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				<td>
				

				<a href="register_appbook.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				
								
				</td>
					


			</tr>
			<?php 
			$i++; 
		}		
//}
?>
		
	</table>
	

 
      </p>
</div></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>			

</body>
</html>