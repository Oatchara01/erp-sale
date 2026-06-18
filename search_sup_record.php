<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_suprecord.php">
<div class="w3-white w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>ดึงข้อมูล Monthly Sales Record</h4></div>

<div class="w3-half">

<div class="w3-container w3-third">

<input name="code" type="hidden" id="code" class="w3-input w3-light-gray" value="<?php echo $_SESSION['code'];?>">


วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
</div>
<div class="w3-container w3-third">


  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">

</div>

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
<option  value="">**Please Select**</option>
<option  value="S31">S31 - S31</option>
<option  value="MM1">MM1 - MM1</option>
<option  value="SM1">SM1 - SM1</option>
<option  value="(SOL99)">(SOL99)</option>
<option  value="รัชดาภรณ์ สีสัน (SOL2)">รัชดาภรณ์ สีสัน (SOL2)</option>
<option  value="หทัยชนก  ไชยแสง (SOL1)">หทัยชนก  ไชยแสง (SOL1)</option>
<option  value="SOL3">SOL3</option>

</select>

		<?php
}else 	{
			?>
				<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option  value="">**Please Select**</option>
<option  value="S11">S11 - พจนีย์</option>
<option  value="S12">S12 - S12</option>
<option  value="S13">S13 - S13</option>
<option  value="S14">S14 - S14</option>
<option  value="S15">S15 - ชลกานต์</option>
<option  value="S16">S16 - ภัณฑิลา</option>
<option  value="S17">S17 - S17</option>
<option  value="S21">S21 - S21</option>
<option  value="S22">S22 - S22</option>
<option  value="S23">S23 - S23</option>
<option  value="S24">S24 - S24</option>
<option  value="S31">S31 - S31</option>
<option  value="S51">S51 - S51</option>
<option  value="MM1">MM1 - MM1</option>
<option  value="SM1">SM1 - SM1</option>
<option  value="(SOL99)">(SOL99)</option>
<option  value="รัชดาภรณ์ สีสัน (SOL2)">รัชดาภรณ์ สีสัน (SOL2)</option>
<option  value="หทัยชนก  ไชยแสง (SOL1)">หทัยชนก  ไชยแสง (SOL1)</option>
<option  value="SOL3">SOL3</option>

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
<option  value="3">ออลล์เวล ไลฟ์ บจก.</option>
<option  value="4">โนเบิล เมด บจก.</option>

</select>

</div>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div><br>
</div>
</div>

</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
