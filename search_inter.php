<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey"><h3>รายการขนส่งอินเตอร์</h3></div>

<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>

<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>


<?php	
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';


	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
?>

<div class="w3-container">
</p>

	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="5%">เลขที่เอกสาร</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="10%">ชื่อสินค้า</th> 
			<th width="10%">จำนวนของ</th> 
			</thead>
	<?php		
			$strSQL = "SELECT ref_id  FROM tb_register_data  where bus_inter ='1' and ref_id LIKE '%SO%'";

if($start_date !=""){ 
    $strSQL .= ' AND start_date = "'.$start_date.'"'; 
}else{ 
    $strSQL .= ' AND start_date = "'.$to_day.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>

		<tr>
				<?php
$strSQL1 = "SELECT iv_no,bill_name,ref_id  FROM hos__so  where ref_id ='".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1)

?>
				<td><?php echo $objResult1["ref_id"];?></td>
				<td><?php echo $objResult1["iv_no"];?></td>
				<td><?php echo $objResult1["bill_name"];?></td>
				

				
				<td><div align="left">
					<?php
						$strSQL3 = "SELECT product_id FROM hos__subso WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
						$Num_Rows3 = mysqli_num_rows($objQuery3);

						while($objResult3 = mysqli_fetch_array($objQuery3)) { 

						$strSQL2 = "SELECT access_name FROM tb_product WHERE product_ID = '".$objResult3["product_id"]."' ";
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						$objResult2 = mysqli_fetch_array($objQuery2);
							?>
							<?php
 
	echo $objResult2["access_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>


<td><div align="left">
					<?php
						$strSQL4 = "SELECT product_id,count FROM hos__subso WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
						$Num_Rows4 = mysqli_num_rows($objQuery4);

						while($objResult4 = mysqli_fetch_array($objQuery4)) { 

						$strSQL5 = "SELECT unit_name FROM tb_product WHERE product_ID = '".$objResult4["product_id"]."' ";
						$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
						$objResult5 = mysqli_fetch_array($objQuery5);
							?>
							<?php	echo $objResult4["count"];	?>  <?php	echo $objResult5["unit_name"];	?><br />
						<?php } ?>
				</div></td>


				


			</tr>

			<?php $i++; } ?>
		
	<?php		
			$strSQL = "SELECT ref_id  FROM tb_register_data  where bus_inter ='1' and ref_id LIKE '%BR%'";

if($start_date !=""){ 
    $strSQL .= ' AND start_date = "'.$start_date.'"'; 
}else{ 
    $strSQL .= ' AND start_date = "'.$to_day.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tbody>

		
			<tr>
				<?php
$strSQL1 = "SELECT iv_no,customer  FROM hos__br  where ref_id_br ='".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1)

?>
				<td><?php echo $objResult["ref_id"];?></td>
				<td><?php echo $objResult1["iv_no"];?></td>
				<td><?php echo $objResult1["customer"];?></td>
				

				
				<td><div align="left">
					<?php
						$strSQL3 = "SELECT product_id FROM hos__subbr WHERE ref_idd_br = '".$objResult["ref_id"]."' ";
						$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
						$Num_Rows3 = mysqli_num_rows($objQuery3);

						while($objResult3 = mysqli_fetch_array($objQuery3)) { 

						$strSQL2 = "SELECT access_name FROM tb_product WHERE product_ID = '".$objResult3["product_id"]."' ";
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						$objResult2 = mysqli_fetch_array($objQuery2);
							?>
							<?php
 
	echo $objResult2["access_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>


<td><div align="left">
					<?php
						$strSQL4 = "SELECT product_id,count FROM hos__subbr WHERE ref_idd_br = '".$objResult["ref_id"]."' ";
						$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
						$Num_Rows4 = mysqli_num_rows($objQuery4);

						while($objResult4 = mysqli_fetch_array($objQuery4)) { 

						$strSQL5 = "SELECT unit_name FROM tb_product WHERE product_ID = '".$objResult4["product_id"]."' ";
						$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
						$objResult5 = mysqli_fetch_array($objQuery5);
							?>
							<?php	echo $objResult4["count"];	?>  <?php	echo $objResult5["unit_name"];	?><br />
						<?php } ?>
				</div></td>


				


			</tr>
			<?php $i++; } ?>
		</tbody>
	</table>

 
	
      </p>
<?php include('foot.php'); ?>
</div>
</body>
</html>