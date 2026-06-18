<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_member.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>ดึงข้อมูล การขายลูกค้าบัตรสมาชิก</h4></div>

<div class="w3-container w3-padding-large">

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

  รหัสบัตรสมาชิก

 <input name="customer_no" class="w3-input" style="width:90%;" type="text" id="customer_no" value="<?php echo $customer_no = isset($_GET['customer_no']) ? $_GET['customer_no'] : '';?>">


</div>
</div>
<div class="w3-half">

<div class="w3-container w3-third">

  เบอร์โทร

 <input name="cus_tel" class="w3-input" style="width:90%;" type="text" id="cus_tel"  onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}"  value="<?php echo $cus_tel = isset($_GET['cus_tel']) ? $_GET['cus_tel'] : '';?>">


</div>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
<br>

</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
