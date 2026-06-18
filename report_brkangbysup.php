<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_brkangbysup1.php">
<div class="w3-white w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>ตรวจเช็คใบยืมค้างเคลียร์ (Stock)</h4></div>

<div class="w3-half">

<div class="w3-container w3-third">

  เขตการขาย
<?php 
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:160px" class="w3-input"  >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<?php
}else 	if ($_SESSION['code']=='SS2'){

	?>
<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
	
	<?php
}else 	if ($_SESSION['code']=='SS3'){

	?>
	
	<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
	<?php
}else 	if ($_SESSION['code']=='SS5'){

	?>
	
<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 where sale_code IN ('S31','S32')  ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>	
<?php	
}else 	if ($_SESSION['code']=='SUP_EN'){

	?>
	
	<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
	
		<?php
}else 	{
			?>
<select name="sale_code" id="sale_code" style="width:160px" class="w3-input"  >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>

				<?php
}
			
?>


</div>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div><br>
</div>
</div>

</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
