<?php include('head.php') ;

include "dbconnect.php";

$strSQL78 = "DELETE FROM  tb__bypro_no1  ";
$objQuery78 = mysqli_query($conn,$strSQL78);

 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายงานยอดขายเรียงตามสินค้า</h4></div>

<form name="frmSearch" action = "report_sumbyproduct1.php" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	
<div class="w3-quarter">
	วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" style="width:90%" value="<?php echo $_GET["start_date"];?>" required>


	</div>
	<div class="w3-quarter">
	 ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" style="width:90%" value="<?php echo $_GET["end_date"];?>" required> 

	</div>
<div class="w3-quarter">
 บริษัท

<select name="company" id="company" style="width:90%" class="w3-input"   required>
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="3">ออลล์เวล ไลฟ์ บจก.</option>
<option  value="4">โนเบิล เมด บจก.</option>
	</select>
</div>

<div class="w3-quarter">
 ประเภทฝ่ายขาย

<select name="type_type" id="type_type" style="width:90%" class="w3-input"   required>
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="1">แผนกโรงพยาบาล</option>
<option  value="2">แผนก Home Care</option>
<option  value="3">แผนก อื่นๆ</option>
	</select>
</div>

	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<br>


</div>

<div id="cr_bar"> <?php include "foot.php"; ?></div>




