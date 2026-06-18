<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value = "<?php  echo $_GET["start_date"]; ?>"></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value = "<?php  echo $_GET["end_date"]; ?>"></div>



<div class="w3-bar w3-quarter">


Sale : 
<?php 
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<?php
}else 	if ($_SESSION['code']=='SS2'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<?php
}else 	if ($_SESSION['code']=='MK2'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_sm1 ORDER BY sale_code ASC";

$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


		<?php
}else 	if ($_SESSION['code']=='SUP_EN'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


		<?php
}else 	{
			?>
				<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


				<?php
}
			
?>


</div>

<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div></div></p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
</form>


<?php
	
		$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
		$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';


	
	
	if($Keyword!="" or $start_date!="" or $end_date!="" or $sale_code){
?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">วันที่ลงทะเบียน</th>
			<th width="10%">เลขที่เอกสาร</th> 
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อลูกค้า</th>
			<th width="10%">เขตการขาย</th>
			<th width="2%">แก้ไข</th>

	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');
		
		if ($sale_code !=''){
		
	$strSQL = "SELECT *  FROM hos__receive  where  sale_code = '".$sale_code."' ";

if($start_date !=""){ 
    $strSQL .= ' AND date_receive >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_receive <= "'.$end_date.'"'; 
}

if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 

}
//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



$strSQL .=" order  by id_auto DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				

				<td><?php
 echo DateThai($objResult["date_receive"]);
					?></td>
				<td><?php echo $objResult["iv_no"];?></td>
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subreceive LEFT JOIN tb_product ON hos__subreceive.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 
	echo $objResult1["access_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				<td><div align="left"><?php echo $objResult["customer_name"];?></div></td>
				<td><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				

<td>
<a href="rister_clearbrpn_stedit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
												
				</td>

			</tr>
			<?php $i++; 
			}
		}
			?>
		</tbody>
		
	</table>


      </p>
<?php include('foot.php'); ?>
		<?php } ?>
</div>
</body>
</html>