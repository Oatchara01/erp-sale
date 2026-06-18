<?php include('head.php'); 
?>

<?php /*<form name="frmSearch" method="GET" action="report_sumresearch_sale.php">*/ ?>

<form name="frmSearch" method="GET" action="report_sumresearch_company.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายงานสรุปความพึงพอใจลูกค้าหลังการขาย</h4></div>



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
กลุ่มลูกค้า

<select name="type_customer" id="type_customer" style="width:160px" class="w3-input"   required>
<option  value="">**โปรดเลือกประเภท**</option>
<option  value="1">Hospital</option>
<option  value="2">Homecare</option>
<option  value="3">ศูนย์ผู้สูงอายุ,คลินิก</option>

</select>
</div>
	</div>
<div class="w3-half">
<div class="w3-container w3-third">
ส่วนการประเมิน

<select name="type_cs" id="type_cs" style="width:160px" class="w3-input"   required>
<option  value="">**โปรดเลือกประเภท**</option>
<option  value="1">Sale</option>
<option  value="2">Product</option>
<option  value="3">Customer Service</option>
<option  value="4">Customer Services ขนส่งนอก</option>
<option  value="5">NSP</option>

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
