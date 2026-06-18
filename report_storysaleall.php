<?php include('head.php'); ?>
<?php include('dbconnect_sale.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายงานรายการรับเรื่องจากลูกค้า</h4></div>
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" value="<?php echo $_GET["start_date"]; ?>" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input"  value="<?php echo $_GET["end_date"]; ?>" style="width:90%;" type="date" id="end_date" ></div>
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
}else 	if ($_SESSION['code']=='SUP_MK'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_allwell ORDER BY sale_code ASC";
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
}else 	if ($_SESSION['code']=='SS3'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 ORDER BY sale_code ASC";
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
}else 	if ($_SESSION['code']=='SS5'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 where sale_code IN ('S31','S32') ORDER BY sale_code ASC";
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

<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
<br></form>
<?php	
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

?>
<div class="w3-container"><br>
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">ลำดับ</th>
			<th width="8%">วันที่แจ้งเรื่อง</th>
			<th width="10%">โรงพยาบาล</th>
             <th width="8%">แผนก</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="15%">รายละเอียด</th>
			<th width="8%">เบอร์โทร</th>
			<th width="8%">วันที่สรุป</th>
			<th width="8%">ผู้สรุป</th>
			<th width="15%">หมายเหตุการปิดงาน</th>
			<th width="5%">จำนวนวันในการปิด</th>
			<th width="5%">เขตการขาย</th>
			

	</thead>
	<?php
include "dbconnect.php";
$emid = $_SESSION['code'];
		
if($emid=='SS1'){
$sddd = "  sale_code IN ('S15','S16','S21','S22','S14')";
}else if($emid=='SS2'){
$sddd = "  sale_code IN ('S11','S12','S17','S24','S13')";	
}else if($emid=='SS3'){
$sddd = "  sale_code IN ('S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
}else if($emid=='SS5'){
$sddd = "  sale_code IN ('S31','S32')";	
}else if($emid=='SUP_EN'){
$sddd = "  sale_code LIKE '%EN%'";	
}else if($emid=='SUP_MK'){
$sddd = "   sale_code  IN ('MK','SOL91','SOL93','SOL93','SOL94','SOL99')";		
}else{
$sddd = "1";			
}		
		
if($start_date !='' or $end_date!='' or $sale_code!=''){		
	
$sddd = " sale_code !='S31' and sale_code !='SM1' and sale_code !='MM1' and sale_code !='MM2' and sale_code !='S32'  and sale_code NOT LIKE '%E%' and sale_code NOT LIKE '%A%'  and sale_code NOT LIKE '%C%'  and sale_code NOT LIKE '%SOL%'";

	
$strSQL = "SELECT *  FROM tb_register_story  where $sddd";

if($start_date !=""){ 
    $strSQL .= ' AND date_story >= "'.$start_date.'"'; 
}

if($end_date !=""){ 

    $strSQL .= ' AND date_story <= "'.$end_date.'"'; 
}
if($sale_code !=""){ 

    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}		
 
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by date_story ASC ";
$objQuery  = mysqli_query($conn,$strSQL);



$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
								
<td><?php echo $i;	?></td>
				<td><?php echo DateThai($objResult["date_story"]);	?></td>
							
				<td><div align="left"><?php echo $objResult["customer_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["address_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["contact_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["description"];?></div></td>

				<td><div align="left"><?php echo $objResult["tel_number"];?></div></td>
<?php if($objResult["date_sumsale"]=='0000-00-00'){ ?>
			<td bgcolor ='red'>	
			<?php }else{ ?>	
				<td><?php } ?>
					
					<?php if($objResult["date_sumsale"]!='0000-00-00'){ echo DateThai($objResult["date_sumsale"]);	}else{ ?>-<?php } ?></td>

				<td><div align="left"><?php echo $objResult["sale_name"];?></div></td>
				<td><div align="left"><?php echo $objResult["remark_sale"];?></div></td>
				<?php  $calculate =strtotime($objResult["date_story"])-strtotime($objResult["date_sumsale"]);
					$summary=floor($calculate / 86400);	
				$rrr = substr($summary,-1);
 //echo $rrr;
				?>
				
<?php if($rrr=='0' or $rrr=='1'){ ?><td><?php }else if($rrr=='1'){ ?><td>	<?php }else{ ?>	<td bgcolor ='red'><?php } ?>	
								
<div align="right"><?php  if($objResult["date_sumsale"]!='0000-00-00'){if($summary!='0'){	echo -$summary;?> วัน <?php } } ?></div></td>

				<td><div align="center"><?php echo $objResult["sale_code"];?></div></td>

				
			</tr>
			<?php $i++; 
}
			
}	 ?>
		</tbody>
	</table>
</div>		
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>