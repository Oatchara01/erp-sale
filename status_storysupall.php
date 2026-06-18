<?php include('head.php'); ?>
<?php include('dbconnect_sale.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</h4></div>
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
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
	
if($emid=='SS1'){
$sddd = " AND sale_code IN ('S15','S16','S21','S22','S14')";
}else if($emid=='SS2'){
$sddd = " AND sale_code IN ('S11','S12','S17','S24','S13')";	
}else if($emid=='SS3'){
$sddd = " AND sale_code IN ('S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
}else if($emid=='SS5'){
$sddd = " AND sale_code IN ('S31','S32')";	
}else if($emid=='SUP_EN'){
$sddd = " and sale_code LIKE '%EN%'";	
}else if($emid=='SUP_MK'){
$sddd = " and  sale_code  IN ('MK','SOL91','SOL93','SOL93','SOL94','SOL99')";		
}else{
$sddd = "";			
}
	
$strSQL = "SELECT *  FROM tb_register_story  where summary_sale = '1' $sddd";

if($start_date !=""){ 
    $strSQL .= ' AND date_story >= "'.$start_date.'"'; 
}

if($end_date !=""){ 

    $strSQL .= ' AND date_story <= "'.$end_date.'"'; 
}
if($sale_code !=""){ 

    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}		
//echo $strSQL;		
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$Per_Page = '20';  
		$Page = isset($_GET['Page']) ? $_GET['Page'] : '';

	if(!isset($_GET['Page']))
	{
		$Page=1;
	}

	$Prev_Page = $Page-1;
	$Next_Page = $Page+1;

	$Page_Start = (($Per_Page*$Page)-$Per_Page);
	if($Num_Rows<=$Per_Page)
	{
		$Num_Pages =1;
	}
	else if(($Num_Rows % $Per_Page)==0)
	{
		$Num_Pages =($Num_Rows/$Per_Page) ;
	}
	else
	{
		$Num_Pages =($Num_Rows/$Per_Page)+1;
		$Num_Pages = (int)$Num_Pages;
	}



$strSQL .=" order  by id_story DESC   LIMIT $Page_Start , $Per_Page ";
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

				<a href="register_storysalesum.php?id_story=<?php echo $objResult["id_story"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a>
				
								
				</td>



			</tr>
			<?php $i++; 
}
			
			 ?>
		</tbody>
	</table>
<div class="w3-panel" >    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><font color='black'><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><font color='black'>$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><font color='black'>Next>></font></a> ";
	}

	
	?>
      <br>
 
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>