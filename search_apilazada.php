<?php
include('head.php'); 
include "dbconnect.php";
?>


<script type="text/javascript">
function autoTab(obj) {
    var pattern = new String("__:__:__"); // กำหนดรูปแบบในนี้
    var pattern_ex = new String(":"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
    var returnText = new String("");
    var obj_l = obj.value.length;
    var obj_l2 = obj_l - 1;
    for (i = 0; i < pattern.length; i++) {
        if (obj_l2 == i && pattern.charAt(i + 1) == pattern_ex) {
            returnText += obj.value + pattern_ex;
            obj.value = returnText;
        }
    }
    if (obj_l >= pattern.length) {
        obj.value = obj.value.substr(0, pattern.length);
    }
}
	</script>

<?php
$save="Update  so__main set  ckk_item = '1' where sale_channel='1'";
$qsave=mysqli_query($conn,$save);

$save="Update  so__main set  ckk_item = '1' where sale_channel='20'";
$qsave=mysqli_query($conn,$save);

	?>

<form name="frmSearch" method="GET" action="getOrders.php">
<div class="w3-white">
		<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>ดึงข้อมูล Lazada</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">

วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>" required>
</div><div class="w3-container w3-third">
	เวลา :
<input type="text" tabindex="1"  placeholder="xx:xx:xx"   name="start_time" id="start_time" size="10%" value="" class="w3-input w3-light-gray"  onkeyup="autoTab(this)"  minlength="6" maxlength="20"  required>
</div>
<div class="w3-container w3-third">
  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>" required>
  	</div>
</div>

<div class="w3-half">	
	<div class="w3-container w3-third">
	เวลา :
	<input type="text" tabindex="1"  placeholder="xx:xx:xx"   name="end_time" id="end_time" size="10%" value="" class="w3-input w3-light-gray"  onkeyup="autoTab(this)"  minlength="6" maxlength="20" required>

</div>
<div class="w3-container w3-third">

  สถานะ

<select name="status" id="status" style="width:90%" class="w3-input w3-light-gray"   required>
<option  value="">**โปรดเลือกสถานะที่ต้องการดึงข้อมูล**</option>
<option  value="pending">กำลังดำเนินการ</option>
<option  value="ready_to_ship">พร้อมที่จะจัดส่ง</option>
<option  value="Packed">บรรจุแล้ว</option>

</select>

</div>	
	
<div class="w3-container w3-third">

  ร้านค้า

<select name="running" id="running" style="width:90%" class="w3-input w3-light-gray"   required>
<option  value="">**โปรดเลือกร้านที่ต้องการดึงข้อมูล**</option>
<option  value="1">LAZADA</option>
<option  value="20">ALLWELL BED (LZD)</option>

</select>

</div>



<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div></div>


</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		