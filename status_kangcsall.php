<?php include('head.php'); ?>
<?php include('dbconnect_sale.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<?php /*<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>*/ ?>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php	
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');
if($start_date !="" or $end_date !=""){ 
?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			
			<th width="8%">วันที่</th>
			<th width="5%">เวลา</th> 
			<th width="10%">โรงพยาบาล</th>
             <th width="8%">แผนก</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="20%">รายละเอียด</th>
			<th width="8%">โทร</th>
			<th width="8%">FAX</th>
			<th width="8%">E-mail</th>
			<th width="8%">เขตการขาย</th>
			<th width="5%">เพิ่มเติม</th>

	</thead>
	<?php
include "dbconnect.php";
$emid = $_SESSION['code'];


$strSQL = "SELECT *  FROM tb_register_story  where summary_sale = '1' and sale_code = 'CS'";

if($start_date !=""){ 
    $strSQL .= ' AND date_story >= "'.$start_date.'"'; 
}

if($end_date !=""){ 

    $strSQL .= ' AND date_story <= "'.$end_date.'"'; 
}
/*if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 

}*/
//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);




$strSQL .=" order  by id_story DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);



$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				
				

				<td><?php
 echo DateThai($objResult["date_story"]);
					?></td>
				<td><?php echo $objResult["time_story"];?></td>
				
				<td><div align="left"><?php echo $objResult["customer_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["address_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["contact_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["description"];?></div></td>

				<td><div align="left"><?php echo $objResult["tel_number"];?></div></td>

				<td><div align="left"><?php echo $objResult["fax"];?></div></td>

				<td><div align="left"><?php echo $objResult["email"];?></div></td>

				<td><div align="center"><?php echo $objResult["sale_code"];?></div></td>

				

<td>

				<a href="register_storysalesum.php?id_story=<?php echo $objResult["id_story"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				
								
				</td>



			</tr>
			<?php $i++; 
}
			
			 ?>
		</tbody>
	</table>
<?php } ?>
 
      </p>
<?php include('foot.php'); ?>
</div>
</body>
</html>