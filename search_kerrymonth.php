<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_kerrymonth.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>ข้อมูลการจัดส่งสินค้า ขนส่ง</h4></div>

<div class="w3-container w3-padding-large">


<div class="w3-container w3-third">
เดือน
<select name="mount" id="mount" class="w3-select" required>
<option  value="">**เลือกเดือน**</option>
<?php
$sql = "select * from tb_month order by month_id";
$query = mysqli_query($conn,$sql);
while ($fetch = mysqli_fetch_array($query,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetch['month_code']; ?>"><?php echo $fetch['month_name']; ?></option>
<?php } ?>
</select>

</div>
<div class="w3-container w3-third">

ปี
<select name="year" id="year" class="w3-select" required>
<option  value="">**เลือกปี**</option>
<?php
$sql = "select * from tb_year order by id_year  DESC";
$query = mysqli_query($conn,$sql);
while ($fetch = mysqli_fetch_array($query,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetch['year_no']; ?>"><?php echo $fetch['year_name']; ?></option>
<?php } ?>
</select>

</div>



	
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>

</form>
  <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
