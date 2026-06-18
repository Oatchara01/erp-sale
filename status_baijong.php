<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
</form>
<?php	

include "dbconnect_sale.php";
$sale_area = $_GET['sale_area'];
$date_plan = $_GET['date_plan'];


$strSQL = "SELECT *  FROM tb_register_data where sale_area='".$sale_area."' and status_reser ='Approve' and date_plan = '".$date_plan."'";



$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
<td width="10%" align="center" >วันที่</td>
<td width="15%" align="center" >โรงพยาบาล</td> 
<td width="10%" align="center" >หน่วยงาน</td>
<td width="20%" align="center" >รายการ</td>
<td width="8%" align="center" >มูลค่า</td>
<td width="10%" align="center" >เดือนที่จะได้รับ P/O</td>
<td width="10%" align="center" >วันที่ Update</td>
<td width="5%" align="center" >สถานะ</td>
<td width="5%" align="center" >Print ใบจอง</td>

	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
	

<td  class="style39"><?php
	$date = explode('-' , $objResult["date_plan"] );
$xdate = $date[2].'-'.$date[1].'-'.$date[0];
 echo $xdate;?></td>
<td  class="style39"><?php echo $objResult["hospital_name"];?></td>


<td  class="style39"><?php echo $objResult["hospital_ward"];?></td>
<td  class="style39"><?php  echo $objResult["summary_quote"]; ?><?php  echo $objResult["summary_product1"]; ?>&nbsp;<?php  echo $objResult["model_name1"]; ?>&nbsp;<?php if ($objResult["unit_product1"]!='0') { echo $objResult["unit_product1"]; }?>&nbsp;<?php echo $objResult["unit_name1"];?>&nbsp;&nbsp; <?php  echo $objResult["summary_product2"]; ?>&nbsp;<?php  echo $objResult["model_name2"]; ?>&nbsp;<?php if ($objResult["unit_product2"]!='0') { echo $objResult["unit_product2"]; }?>&nbsp;<?php echo $objResult["unit_name2"];?>&nbsp;&nbsp; <?php  echo $objResult["summary_product3"]; ?>&nbsp;<?php  echo $objResult["model_name3"]; ?>&nbsp;<?php if ($objResult["unit_product3"]!='0') { echo $objResult["unit_product3"]; }?>&nbsp;<?php echo $objResult["unit_name3"];?>&nbsp;&nbsp; <?php  echo $objResult["summary_product4"]; ?>&nbsp;<?php  echo $objResult["model_name4"]; ?>&nbsp;<?php if ($objResult["unit_product4"]!='0') { echo $objResult["unit_product4"]; }?>&nbsp;<?php echo $objResult["unit_name4"];?>&nbsp;&nbsp; <?php  echo $objResult["summary_product5"]; ?>&nbsp;<?php  echo $objResult["model_name5"]; ?>&nbsp;<?php if ($objResult["unit_product5"]!='0') { echo $objResult["unit_product5"]; }?>&nbsp;<?php echo $objResult["unit_name5"];?></td>

<td  class="style39"><?php $sum_price_product=$objResult["sum_price_product"]; echo number_format( $sum_price_product,0).""; ?></td>
<td  class="style39"><?php echo $objResult["month_po"]; ?></td>

<td class="style39" ><?php
	$date_order = explode('-' , $objResult["date_update"] );
$ydate = $date_order[2].'-'.$date_order[1].'-'.$date_order[0];
 echo $ydate;?></td>

<?php
if($objResult["status_reser"]=='Approve'){
	?>

<td class="style39" bgcolor="#00FF00"><?php echo $objResult["status_reser"]; ?></td>
<?php
}else if($objResult["status_reser"]=='Reject'){
	?>
<td class="style39" bgcolor="#FF3333"><?php echo $objResult["status_reser"]; ?></td>
<?php
}else if($objResult["status_reser"]=='Reques'){
	?>

<td class="style39" bgcolor="#FFFF00" ><?php echo $objResult["status_reser"]; ?></td>


		<?php
	}
		?>

<td  align="center"><a href="report_baijong.php?id_work=<?php echo $objResult["id_work"];?>"><img src="img/print_icon-2.png" width="30" height="30" border="0" /></a></td>


					</tr>
			<?php $i++; } ?>
		</tbody>
	</table>

 
      </p>
<?php include('foot.php'); ?>
</div>
</body>
</html>