<?php include('head.php'); ?>

<form name="frmSearch" method="GET" action="report_bycustomer.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">
รายงานสรุปจำนวนลูกค้า (เลือกวัน) </p>

วันที่ซื้อ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
วันที่ส่ง :
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">
  <input type="submit" value="Search" class="w3-button w3-teal">

</div>
</div>
</form>
<div id="cr_bar"><?php include "foot.php"; ?></div>
