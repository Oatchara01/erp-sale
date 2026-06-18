<?php include('head.php'); 
?>

<?php /*<form name="frmSearch" method="GET" action="report_sumresearch_sale.php">*/ ?>

<form name="frmSearch" method="GET" action="report_buyagain1.php">
	<div class="w3-white">
<div class="w3-panel w3-light-gray"><h4>รายงานสรุปยอดลูกค้าซื้อซ้ำ</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">


วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>" required>
</div>
<div class="w3-container w3-third">

  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>" required>

</div>
	
	
<div class="w3-container w3-third">
หมวดสินค้า

	<select name="group1" id="group1" style="width:160" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_modepro ORDER BY id ASC";

$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($_GET["group1"] == $objResuut5["mode_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["mode_name"];?>"<?php echo $sel;?>><?php echo $objResuut5["mode_name"];?></option>
<?php
}
?>
</select>
</div>
	</div>
	<div class="w3-half">
<div class="w3-container w3-third">
  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
<div id="cr_bar"><?php include "foot.php"; ?></div>

