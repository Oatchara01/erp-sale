<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_creditnot.php">
<div class="w3-panel w3-light-gray"><h4>รายงานใบลดหนี้</h4></div>

<div class="w3-container w3-padding-large">

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


  ชำระคืนโดย
	
<select name="type_return" id="type_return" style="width:160px" class="w3-input" >
<option  value="">**โปรดเลือก**</option>
<option  value="1">เงินสด</option>
<option  value="2">เงินโอน</option>
<option  value="3">ลดหนี้จากยอดลูกหนี้ค้างชำระ</option>


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
<?php require_once('foot.php'); ?>
