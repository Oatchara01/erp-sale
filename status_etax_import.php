<?php 
include('head.php'); 
include('dbconnect_sale.php'); 
?>

<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Import ข้อมูลลูกค้าขอใบกำกับภาษี</h4></div>



<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

	date_default_timezone_set("Asia/Bangkok");

include "dbconnect.php";

$strSQL = "SELECT *  FROM tb_customer_etax  where import_order !='1' and import_order !='3' ";	

if($Keyword !=""){ 
	$strSQL .= ' AND order_id  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or tel_num  LIKE "%'.$Keyword.'%"'; 

}
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="8%">วันที่ลงทะเบียน</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="8%">เลขผู้เสียภาษี</th>
			<th width="8%">เบอร์โทร</th>
			<th width="15%">ที่อยุ่</th> 
			<th width="8%">Email</th>
			<!--th width="8%">ยอดขาย</th-->
			<th width="8%">หมายเลขคำสังซื้อ</th>
			<th width="8%">ช่องทางการขาย</th>
			
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$head_name = $objResult["head_name"];
$last_name = $objResult["last_name"];
$customer_name = "$head_name $last_name";


$address = $objResult["address"];
$sub_district = $objResult["sub_district"];
$district = $objResult["district"];
$province = $objResult["province"];
$postcode = $objResult["postcode"];

$address_name = "$address $sub_district $district $province $postcode";
	
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				<td><?php echo DateThai($objResult["add_date"]);	?></td>
				<td><?php echo $customer_name;?></td>
				<td><?php echo $objResult["tax_id"];?></td>
				<td><?php echo $objResult["tel_num"];?></td>
				<td><?php echo $address_name;?></td>
				<td><?php echo $objResult["mail_cus"];?></td>
				<!--td><div align="rihgt"><?php echo number_format($objResult["amount"],2)."";?></div></td-->
				<td><?php echo $objResult["order_id"];?></td>
				<td><?php echo $objResult["sale_channel"];?>
				
				<input type='hidden' name="ref_id[<?php echo $objResult1["id"];?>]" id="ref_id[<?php echo $objResult1["id"];?>]" value ="<?php echo $objResult["ref_id"]; ?>" class="w3-input" style="width:100%;" >
				<input type='hidden' name="id[<?php echo $objResult1["id"];?>]" id="id[<?php echo $objResult1["id"];?>]" value ="<?php echo $objResult["id"]; ?>" class="w3-input" style="width:100%;" >			
				
				</td>
				


			</tr>
			<?php $i++; } ?>
		</tbody>
	</table><br><br>
<center>
<input type="button" name ="Submit" value="Update ข้อมูลออกบิล" class="w3-button w3-teal" onClick="this.form.action='status_etax_import1.php'; submit()">
</center>

</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
</form>
</body>
</html>