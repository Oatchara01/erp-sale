<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_logall.php">
	<div class="w3-white">
<div class="w3-panel w3-light-gray"><h4>ดึงข้อมูล การปรับเพิ่ม - ลบ รายการสินค้า</h4></div>

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

  ประเภทเอกสาร

<select name="type_doc" id="type_doc" style="width:160px" class="w3-input"  >
<option  value="">**โปรดเลือกประเภทเอกสาร**</option>
<option  value="1">Sale Online</option>
<option  value="2">ใบสั่งขาย รพ.</option>
<option  value="3">ใบยืม รพ.</option>
<option  value="4">ใบเบิก SMP</option>
<option  value="5">ใบแลกเปลี่ยนสินค้า</option>
<option  value="6">ใบจองสินค้า</option>
<option  value="7">ใบเบิก SPR</option>



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

