<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<?php

		//$type_del = $_GET["type_del"];
		$del_date = $_GET["del_date"];
	
	$e = explode("/", $_GET["type_del"]);
 	$type_del = $e[0];
	$type_del1 = $e[1];
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
$strSQL = "SELECT *  FROM tb_deloth  where type_del='".$type_del."' and del_date='".$del_date."' ";
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
		
		
	</table>

 
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>