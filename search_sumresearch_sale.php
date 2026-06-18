<?php include('head.php'); 
?>

<?php /*<form name="frmSearch" method="GET" action="report_sumresearch_sale.php">*/ ?>

<form name="frmSearch" method="GET" action="report_research_new.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายงานสรุปความพึงพอใจลูกค้าหลังการขาย</h4></div>



<div class="w3-half">

<div class="w3-container w3-third">


วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
</div>
<div class="w3-container w3-third">

  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">

</div>
	
	
<div class="w3-container w3-third">
ประเภท

<select name="type_customer" id="type_customer" style="width:160px" class="w3-input"   >
<option  value="">**โปรดเลือกประเภท**</option>
<option  value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
<option  value="โรงพยาบาล">โรงพยาบาล</option>
<option  value="ร้านขายยา">ร้านขายยา</option>

</select>
</div>
	</div>
	<div class="w3-half">
	
	<div class="w3-container w3-third">
ส่วนการประเมิน

<select name="type_cs" id="type_cs" style="width:160px" class="w3-input"   >
<option  value="">**โปรดเลือกประเภท**</option>
<option  value="1">Sale</option>
<option  value="2">Product</option>
<option  value="3">Customer Service</option>

</select>
</div>	
		
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>
</div>

</form>
<div id="cr_bar"><?php include "foot.php"; ?></div>
