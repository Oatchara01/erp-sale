<?php include('head.php'); 

include "dbconnect.php";

$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$mm = substr($_GET["tart_date"],5);
$yy = substr($_GET["tart_date"],0,4);
$thai= $_month_name[$mm];
$year =$yy+543;
$start_date = "$yy-$mm";
$sale_code = $_GET["sale_code"];
?>
<body>
	<div class="w3-white">
<div class="w3-container w3-padding-large">

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">

<center>
<h4>รายงานการเปิดออเดอร์ เขตการขาย </h4>
<h4>เดือน <?php echo  $thai; ?>   <?php echo  $year; ?></h4>	
	
</center><br>
</form>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="8%">เลขที่เอกสาร</td > 
			<td width="10%">วันที่ออกเอกสาร</td >
			<td width="15%">รายการสินค้า</td >
			<td width="10%">จำนวน</td >
			<td width="10%">ยอดขายรวม</td >
			<td width="15%">ชื่อผู้ออกบิล</td >
			<td width="10%">เขตการขาย</td >
			<td width="5%">สถานะ</td >
        </thead>
	

<?php	

$strSQL = "SELECT *  FROM  hos__so  where  iv_date LIKE '%$start_date%' and status_doc = 'Approve' and ic_ckk ='1'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by iv_date ASC";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>
<td><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"  target="_blank"><?php echo $objResult["iv_no"];?></a>
				</td>
				<td ><?php  echo DateThai($objResult["iv_date"]); ?></td>
				
				<td><div align="left">
					<?php
$strSQL2 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
<?php echo $objResult2["sol_name"];	?><br>
						<?php } ?>
				</div></td>
				
				<td><div align="right">
					<?php
$strSQL1 = "SELECT count,unit_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo number_format($objResult1["count"],0); ?> <?php echo $objResult1["unit_name"]; ?><br><?php } ?>
				</div></td>
<td><div align="right">
<?php
$strSQL3 = "SELECT SUM(amount) AS amount FROM hos__subso  WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3); echo number_format($objResult3["amount"],0);	?>
				</div></td>				
				
				<td ><div align="left"><?php echo $objResult["bill_name"];?></div></td>
				<td ><div align="center"><?php echo $objResult["sale_code"];?> <?php echo '-';?> <?php echo $objResult["sale"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				
			</tr>
			<?php $i++; 
				}

?>
		
		
<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>ยอดรวม</td>
<td><div align="right">
<?php
$strSQL4 = "SELECT SUM(amount) AS amount FROM (hos__so LEFT JOIN hos__subso ON hos__subso.ref_idd=hos__so.ref_id)  WHERE  iv_date LIKE '%$start_date%'  and status_doc = 'Approve'  and ic_ckk ='1'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4); echo number_format($objResult4["amount"],2);	?>
				</div></td>				
				
				<td></td>
				<td></td>
				<td></td>
				
			</tr>		
		
		
	</table>
	

 
      <br>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>
</html>

