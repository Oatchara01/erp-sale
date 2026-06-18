<?php 
include('head.php');
//include "dateselect1.php";
?>

<form name="frmSearch" method="GET" action="report_service3.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>ดึงข้อมูลลงทะเบียนติดตั้ง Service Engineer</h4> </div>

<div class="w3-half">

<div class="w3-container w3-third">	
วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
</div>	
	
<div class="w3-container w3-third">	
  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">
	</div>	
<!--input name="start_date" type='text' id="start_date" class="button4" style="width:20%"  /><a href="javascript:displayDatePicker('start_date')"> <img src="img/formcal.gif" alt="" width="20" height="20" border="0" /></a-->	
	
	<div class="w3-container w3-third">	
  <input type="submit" value="Search" class="w3-button w3-teal">
</div>	
		</div>	
	
</div>	
</div>


</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
