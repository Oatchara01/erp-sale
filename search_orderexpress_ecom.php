<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<form name="frmSearch" method="GET" action="report_orderexpress_ecom.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>ดึงข้อมูล Order E-Commerce ลง Express</h4></div>

<div class="w3-half">

<div class="w3-container w3-third">

  เลขที่ IV เคลียร์
  <input name="iv_no" type="text" id="iv_no" class="w3-input w3-light-gray" value="<?php echo $_GET["iv_no"];?>">

</div>


<div class="w3-container w3-third">
  <input type="submit" value="ดึงข้อมูลเข้า Express" class="w3-button w3-teal">
</div>
<div class="w3-container w3-third">	
 <input type="button" name ="Submit" value="แบบฟอร์ม" class = "w3-button w3-teal w3-yellow" onClick="this.form.action='from_orderexpress_ecom.php'; submit()">
	
 </div>
</div>
</div>
</div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
