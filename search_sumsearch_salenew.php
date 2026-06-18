<?php include('head.php'); 
?>
<div class="w3-container w3-white">
<?php /*<form name="frmSearch" method="GET" action="report_sumresearch_sale.php">*/ ?>

<form name="frmSearch" method="GET" action="report_sumsearch_salenew.php">
<div class="w3-panel w3-light-gray"><h4>รายงานสรุปความพึงพอใจลูกค้าหลังการขาย</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">


 ปี

<select name="year_ckk" id="year_ckk" style="width:160px" class="w3-input"   required>
<option  value="">**โปรดเลือกปี**</option>
<option  value="2020">2563</option>
<option  value="2021">2564</option>
<option  value="2022">2565</option>
<option  value="2023">2566</option>
<option  value="2024">2567</option>
<option  value="2025">2568</option>

</select>


</div>
	
	
<div class="w3-container w3-third">
ประเภท

<select name="type_customer" id="type_customer" style="width:160px" class="w3-input"   required>
<option  value="">**โปรดเลือกประเภท**</option>
<option  value="A">ประเภท A</option>
<option  value="B">ประเภท B</option>
<!--option  value="D">ประเภท D</option-->

</select>
</div>
	
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
<?php require_once('foot.php'); ?>
