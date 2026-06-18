<?php 
include ("head.php"); 
include("dbconnect.php");


	$bill_id = $_GET["bill_id"];
	$start_date = $_GET["start_date"];
	$end_date = $_GET["end_date"];
	$group_1 = $_GET["group_1"];
	
$strSQL = "SELECT bill_name FROM tb_customer WHERE customer_id = '".$bill_id."' ";
$objQuery = mysqli_query($conn,$strSQL);
$objResult = mysqli_fetch_array($objQuery);

	
	?>
<div class="w3-white">
<div class="w3-container w3-padding-large">

<br><fieldset><br>


<center>
	<h4>รายการสั่งซื้อสินค้า </h4>
	<h4>คุณ :  <?php echo $objResult["bill_name"]; ?> </h4>
	<h4>วันที่  :  <?php echo Datethai($start_date); ?> ถึง <?php echo Datethai($end_date); ?></h4>
	</center>

<br>
<?php 
$strSQL1 = "SELECT DISTINCT ref_id,doc_no,doc_date FROM tb__buypro WHERE bill_id ='".$bill_id."' and doc_date >='".$start_date."'  and doc_date <='".$end_date."' and sale_code LIKE '%SOL%'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

 
?>
	
	<table  width="100%" class="w3-table">
		
			
			<td width="5%"><h5>วันที่</h5></td>
			<td width="10%"><h5><div align="left"><?php echo Datethai($objResult1["doc_date"]); ?></div></h5></td> 
			<td width="10%"><h5>เลขที่เอกสาร</h5></td>
			<td width="75%"><h5><div align="left"><a href="register_admin_edit.php?ref_id=<?php echo $objResult1['ref_id'];?>" target="_blank"><?php echo $objResult1["doc_no"]; ?></a></div></h5></td> 
			</table>


<table border="1"  width="100%" class="w3-table">
		
			<tr>
			
			<td width="10%">รหัสสินค้า</td>
			<td width="20%">ชื่อสินค้า</td>
			<td width="10%">จำนวน</td>
			<td width="10%">ยอดรวม</td>
			</tr>
	
	
	<?php
$strSQL2 = "SELECT amount,count,sol_name,access_code FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE ref_id ='".$objResult1["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{

	?>
	<tr>
			<td ><?php echo $objResult2["access_code"]; ?></td>
			<td ><div align="left"><?php echo $objResult2["sol_name"]; ?></div></td>
			<td ><?php echo $objResult2["count"]; ?></td>
			<td><div align="right"><?php echo number_format($objResult2["amount"],2).""; ?></div></td>
			</tr>
	
	
	<?php } 
	
$strSQL3 = "SELECT SUM(amount) AS amount FROM tb__buypro WHERE ref_id ='".$objResult1["ref_id"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
	?>
	
	<tr>
			<td ></td>
			<td ><div align="left"></div></td>
			<td >ยอดรวม</td>
			<td><div align="right"><?php echo number_format($objResult3["amount"],2).""; ?></div></td>
			</tr>
	
			</table>

<br><br>


<?php } ?>



<br></fieldset><br>
	</div></div>
