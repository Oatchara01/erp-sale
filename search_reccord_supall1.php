<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_supallwell_record1.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>ดึงข้อมูล Monthly Sales Record</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">

<input name="code" type="hidden" id="code" class="w3-input w3-light-gray" value="<?php echo $_SESSION['code'];?>">


วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>" required>
</div>
<div class="w3-container w3-third">


  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>" required>

</div>

<div class="w3-container w3-third">


   เขตการขาย
<?php
	if ($_SESSION['name']=='ธนบัตร'){

	?>
	
	<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" required>
<option  value="">**Please Select**</option>
<option  value="SOL1">นิรชา ชานันโท SOL1</option>
<option  value="SOL2">รัชดาภรณ์ สีสัน SOL2</option>
<option  value="SOL3">SOL3</option>
<option  value="SOL4">SOL4</option>
<option  value="SOL5">SOL5</option>
<option  value="SOL6">SOL6</option>
</select>
	<?php
	}else if ($_SESSION['code']=='SS3' or $_SESSION['code']=='SOL99' or $_SESSION['code']=='SOL2'){

	?>
	
	<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" required>
<option  value="">**Please Select**</option>
<option  value="S31">S31 - S31</option>
<option  value="S32">S32 - S32</option>
<option  value="S33">S33 - S33</option>		
<option  value="MM1">MM1 - MM1</option>
<option  value="MM2">MM2 - MM2</option>
<option  value="SM1">SM1 - SM1</option>
<option  value="SOL99">SOL99</option>
<option  value="SOL2">รัชดาภรณ์ สีสัน SOL2</option>
<option  value="SOL1">นิรชา ชานันโท SOL1</option>
<option  value="SOL3">SOL3</option>
<option  value="SOL4">SOL4</option>
<option  value="SOL5">SOL5</option>
<option  value="SOL6">SOL6</option>
</select>

		<?php 
	}else if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:90%" class="w3-input" >
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
}else 	if ($_SESSION['code']=='SS3'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 where ckk_1='0' ORDER BY sale_code ASC";
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

$strSQL5 = "SELECT * FROM tb_team_ss3 where ckk_1='0' and sale_code IN ('S31','S32') ORDER BY sale_code ASC";
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
</div>

<div class="w3-half">

<div class="w3-container w3-third">

  บริษัท

<select name="company" id="company" style="width:160px" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="31">ออลล์เวล ไลฟ์ บจก.</option>
<option  value="42">โนเบิล เมด บจก.</option>

</select>

</div>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
<br>

</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
