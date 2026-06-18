<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_supgraph.php">
<div class="w3-white w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Search ข้อมูลยอดขาย</h4></div>



<div class="w3-half">

<div class="w3-container w3-third">

<input name="code" type="hidden" id="code" class="w3-input w3-light-gray" value="<?php echo $_SESSION['code'];?>">
<input name="name" type="hidden" id="name" class="w3-input w3-light-gray" value="<?php echo $_SESSION["name"];?>">
<input name="surname" type="hidden" id="surname" class="w3-input w3-light-gray" value="<?php echo $_SESSION["surname"];?>">


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
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:160px" class="w3-input"  required>
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
<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" required>
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
<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" required>
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
}else 	{
			?>
				<select name="sale_code" id="sale_code" style="width:160px" class="w3-input"  required>
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_adm where ckk ='0' ORDER BY sale_code ASC";
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



</div>
<div class="w3-half">
	<?php /*
<div class="w3-container w3-third">

  บริษัท

<select name="company" id="company" style="width:160px" class="w3-input"   required>
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="3">ฟาร์ ทริลเลี่ยน บจก.</option>
<option  value="4">โนเบิล เมด บจก.</option>

</select>
	</div>*/ ?>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>

</div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
