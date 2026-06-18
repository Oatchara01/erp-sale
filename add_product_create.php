<?php 


include('head.php');

 
 
 ?>


<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>


<body>
<form   method="GET" name="frmMain" enctype="multipart/form-data" >
<div class="w3-panel w3-light-gray"><h4>ADD : PRODUCT</h4></div>

<div class="w3-bar ">
	

	<fieldset><legend ><b><font color="red">ข้อมูลพื้นฐาน</font></b></legend></p>
	<div class="w3-half">
<div class="w3-container w3-third">
บริษัท
<select name="type_company" id="type_company" class="w3-input"   >
<option  value="">**โปรดเลือกบริษัท**</option>
<option  value="PTL">PTL</option>
<option  value="NBM">NBM</option>

</select>
</div><div class="w3-container w3-third">
	
	<input type='checkbox' name='sale_ckk'  value='1'>&nbsp;Sale Hos
 <input type='checkbox' name='engineer_ckk'  value='1'>&nbsp;Engineer 
 <input type='checkbox' name='adm_ckk'  value='1'>&nbsp;Admin  </p>
	 <input type='checkbox' name='online_ckk'  value='1'>&nbsp;Sale Online 
	 <input type='checkbox' name='demo_ckk'  value='1'>&nbsp;สินค้าสาธิต 
</div><div class="w3-container w3-third">
รหัสบาร์โค้ดสินค้า
<input name="sol_code" class="w3-input" >
</div>
</div>
<div class="w3-half">
<div class="w3-container w3-third">
รหัส Access เก่า
<input name="access_code_old"  class="w3-input" >
</div>

<div class="w3-container w3-third">
รหัสสินค้า
<input name="access_code" class="w3-input"  >
</div><div class="w3-container w3-third">
ชื่อสินค้า
<input name="access_name" class="w3-input" >
</div>
	</div>
<div class="w3-half">	
	<div class="w3-container w3-third">
ราคาสินค้า
<input name="sol_price" class="w3-input" >
	</div>
<div class="w3-container w3-third">
รหัสสินค้า Express
<input name="express_code" class="w3-input" >
</div><div class="w3-container w3-third">
ชื่อสินค้า Express
<input name="express_name" class="w3-input" >
</div>
	</div>
	<div class="w3-half">
	<div class="w3-container w3-third">
หน่วย
		<select name="unit_name" id="unit_name" style="width:160" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_unit ORDER BY unit_id ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
?>
<option value="<?php echo $objResuut5["unit_name"];?>"><?php echo $objResuut5["unit_name"];?></option>
<?php
}
?>
</select>
</div>
	
	<div class="w3-container w3-third">
ประเภทสินค้า
	
	<select name="product_type" id="product_type" style="width:160" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_type_product ORDER BY id ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
?>
<option value="<?php echo $objResuut5["typeproduct_name"];?>"><?php echo $objResuut5["typeproduct_name"];?></option>
<?php
}
?>
</select>

</div></div>
</p>
</fieldset>
</p>

<fieldset><legend ><b><font color="red">สินค้ามีปัญหา & หมดอายุ</font></b></legend></p>
<div class="w3-half">
<div class="w3-container w3-third">

<input type='checkbox' name="expire" value = '1' >&nbsp;&nbsp;หมดอายุ
</div><div class="w3-container w3-third">
 ยอดหมดอายุ
<input name="expire_total" class="w3-input" >
</div><div class="w3-container w3-third">

<input  name="problem" type='checkbox' value = '1' >&nbsp;&nbsp; มีปัญหา
</div>
</div><div class="w3-half">
<div class="w3-container w3-third">
ยอดมีปัญหา
<input name="problem_total" class="w3-input" >
</div><div class="w3-container w3-third">
หมายเหตุ ยอดคงเหลือ
<input name="balance_remark" class="w3-input" >
</div><div class="w3-container w3-third">

<input name="add_info" type='checkbox' value = '1' >&nbsp;&nbsp; เพิ่มเติมข้อมูล
</div>

</div><div class="w3-half">
<div class="w3-container w3-third">
ข้อมูลสินค้าเพิ่มเติม
<input name="more_product_info" class="w3-input" >
</div><div class="w3-container w3-third">
 ที่ตั้ง
<input name="store" class="w3-input" >
</div>
<div class="w3-container w3-third">
หมวดสินค้า

	<select name="group1" id="group1" style="width:160" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_modepro ORDER BY id ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
?>
<option value="<?php echo $objResuut5["mode_name"];?>"><?php echo $objResuut5["mode_name"];?></option>
<?php
}
?>
</select>
</div>
</div>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">การสั่งซื้อ & จุดสั่งซื้อ</font></b></legend></p>
<div class="w3-half">
<div class="w3-container w3-third">
<input name="ordered" type='checkbox'  value = '1' >&nbsp;&nbsp;สั่งแล้ว
</div><div class="w3-container w3-third">
จุดสั่งซื้อ
<input name="reorder_point" class="w3-input" >
</div>


<div class="w3-container w3-third">
เลขที่ใบสั่งซื้อ
<input name="order_no" class="w3-input" >
</div>
	</div><div class="w3-half">
	<div class="w3-container w3-third">
 จำนวนที่สั่งซื้อ
<input name="order_count" class="w3-input" >
</div>
</div>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">สินค้าหมดอายุ</font></b></legend></p>
<div class="w3-half">
<div class="w3-container w3-third">
 
<input name="pannipha" type='checkbox' value = '1' >&nbsp;&nbsp;คุณพรรณิภา
</div>
<div class="w3-container w3-third">

<input name="expire_date" type='checkbox' value = '1' >&nbsp;&nbsp;วันหมดอายุของสินค้า
</div><div class="w3-container w3-third">
1-1 EXP (จำนวน)
<input name="1_1EXP" class="w3-input" >
</div>
</div><div class="w3-half">

<div class="w3-container w3-third">
1-2 EXP (จำนวน)
<input name="1_2EXP" class="w3-input" >
</div><div class="w3-container w3-third">
 1-3 EXP (จำนวน)
<input name="1_3EXP" class="w3-input" >
</div><div class="w3-container w3-third">
 1-4 EXP (จำนวน)
<input name="1_4EXP" class="w3-input" >
</div>
</div>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">สินค้าหมดอายุ ตัดบัญชีแล้ว</font></b></legend></p>
<div class="w3-half">
<div class="w3-container w3-third">

<input name="clearing" type='checkbox'  value = '1' >&nbsp;&nbsp;ตัดบัญชีแล้ว
</div><div class="w3-container w3-third">
จำนวนที่ตัดบัญชีแล้ว
<input name="Clearing_count" class="w3-input" >
</div><div class="w3-container w3-third">
2-1 EXP (จำนวน)
<input name="2_1EXP" class="w3-input" >
</div>

</div><div class="w3-half">
<div class="w3-container w3-third">
2-2 EXP (จำนวน)
<input name="2_2EXP" class="w3-input" >
</div><div class="w3-container w3-third">
 2-3 EXP (จำนวน)
<input name="2_3EXP" class="w3-input" >
</div><div class="w3-container w3-third">
 หมายเหตุ ตัดบัญชี
<input name="clearing_remark" class="w3-input" >
</div>
</div>

</fieldset>
</p>
<fieldset><legend ><b><font color="red">ค่าอุณหภูมิ</font></b></legend></p>
<div class="w3-half">
<div class="w3-container w3-third">
 ชนิดการหมุนเวียนสินค้า

	<select name="itr_type" id="itr_type" style="width:160" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_proretae ORDER BY id ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
?>
<option value="<?php echo $objResuut5["retae_name"];?>"><?php echo $objResuut5["retae_name"];?></option>
<?php
}
?>
</select>
</div>

<div class="w3-container w3-third">

<input name="humidity"  type='checkbox'  value = '1' >&nbsp;&nbsp;อุณหภูมิและความชื้น
</div><div class="w3-container w3-third">
ค่าอุณหภูมิ (C)
<input name="temperator" class="w3-input" >
</div>
	</div><div class="w3-half">
	<div class="w3-container w3-third">
ความชื้นสัมพันธ์ (%)
<input name="rh" class="w3-input" >
</div>
<div class="w3-container w3-third">
หมายเหตุ ในการจัดเก็บ
<input name="store_remark" class="w3-input" >
</div>
<div class="w3-container w3-third">
 ระยะเวลาเช่า-ยืม
<input name="br_period" class="w3-input" >
</div>
		</div><div class="w3-half">
<div class="w3-container w3-third">
แหล่งพลังงาน

	<select name="energy" id="energy" style="width:160" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_energy ORDER BY id ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
?>
<option value="<?php echo $objResuut5["energy_name"];?>"><?php echo $objResuut5["energy_name"];?></option>
<?php
}
?>
</select>
</div>
</div>
</fieldset>

</p>
<fieldset><legend ><b><font color="red">การปรับปรุงรายการ</font></b></legend></p>
<div class="w3-half">
<div class="w3-container w3-third">
 เลือกไม่พิมพ์
<input name="no_print" class="w3-input" >
</div>


<div class="w3-container w3-third">
แฟ้มที่
<input name="folder_no" class="w3-input" >
</div><div class="w3-container w3-third">
เลือกอะไหล่
	
<select name="spare_select" id="spare_select" style="width:160" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_typespare ORDER BY id ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
?>
<option value="<?php echo $objResuut5["type_name"];?>"><?php echo $objResuut5["type_name"];?></option>
<?php
}
?>
</select>	
</div>
	</div><div class="w3-half">
	<div class="w3-container w3-third">

<input name="adjust" type='checkbox'  value = '1' >&nbsp;&nbsp;ปรับปรุงสินค้า
</div>


<div class="w3-container w3-third">
รายการปรับปรุงสินค้า
<input name="adjust_list" class="w3-input" >
</div><div class="w3-container w3-third">
 
<input name="reserved"  type='checkbox'  value = '1' >&nbsp;&nbsp;จองแล้ว
</div>
		</div><div class="w3-half">
		<div class="w3-container w3-third">
 จำนวนการจอง
<input name="reserved_amount" class="w3-input" >
</div>

<div class="w3-container w3-third">
 
<input name="ordered_ready" type='checkbox'  value = '1' >&nbsp;&nbsp;จอง Order แล้ว
</div><div class="w3-container w3-third">
 จำนวน Order
<input name="ordered_amount" class="w3-input" >
</div>
</div>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">รายการสินค้าประกอบชุด</font></b></legend></p>
<div class="w3-half">
<div class="w3-container w3-third">
<input name="import_check" type='checkbox'  value = '1' >&nbsp;&nbsp;ตรวจสอบสินค้าเข้า
</div><div class="w3-container w3-third">

<input name="verify" type='checkbox'  value = '1' >&nbsp;&nbsp;ตรวจทาน
</div><div class="w3-container w3-third">
ตรวจทาน01
<input name="verify01" class="w3-input" >
</div>

</div><div class="w3-half">
<div class="w3-container w3-third">
ตรวจทาน02
<input name="verify02" class="w3-input" >
</div><div class="w3-container w3-third">
 ตรวจทาน03
<input name="verify03" class="w3-input" >
</div><div class="w3-container w3-third">
 ตรวจทาน04
<input name="verify04" class="w3-input" >
</div>

</div><div class="w3-half">
<div class="w3-container w3-third">
ตรวจทาน05
<input name="verify05" class="w3-input" >
</div><div class="w3-container w3-third">
ตรวจทาน06
<input name="verify06" class="w3-input" >
</div><div class="w3-container w3-third">
ตรวจทาน07
<input name="verify07" class="w3-input" >
</div>
</div><div class="w3-half">

<div class="w3-container w3-third">
ตรวจทาน08
<input name="verify08" class="w3-input" >
</div><div class="w3-container w3-third">
 ตรวจทาน09
<input name="verify09" class="w3-input" >
</div><div class="w3-container w3-third">
 ตรวจทาน10
<input name="verify10" class="w3-input" >
</div>
</div><div class="w3-half">

<div class="w3-container w3-third">
เพิ่มเติม ตรวจทาน
<input name="verify_add" class="w3-input" >
</div><div class="w3-container w3-third">
ประกอบชุดต่อวัน
<input name="assemble_per_day" class="w3-input" >
</div><div class="w3-container w3-third">
ตรวจเช็คต่อวัน
<input name="check_per_day" class="w3-input" >
</div>

</div>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">อื่นๆ</font></b></legend></p>
<div class="w3-half">
<div class="w3-container w3-third">
กลุ่มสินค้าคงเหลือ
<input name="inventory_group" class="w3-input" >
</div><div class="w3-container w3-third">

<input name="update_chula" type='checkbox'  value = '1' >&nbsp;&nbsp;Up Date รพ จุฬา
</div><div class="w3-container w3-third">
พิมพ์ตามช่วงเวลา
<input name="type_time" class="w3-input" >
</div>
</div><div class="w3-half">

<div class="w3-container w3-third">

<input name="popular_1" type='checkbox'  value = '1' >&nbsp;&nbsp;ยอดนิยม_1
</div><div class="w3-container w3-third">
 
<input name="popular_2" type='checkbox'  value = '1' >&nbsp;&nbsp;ยอดนิยม_2
</div><div class="w3-container w3-third">
 
<input name="popular_3" type='checkbox'  value = '1' >&nbsp;&nbsp;ยอดนิยม_3
</div>
</div><div class="w3-half">
<div class="w3-container w3-third">

<input name="popular_4" type='checkbox'  value = '1' >&nbsp;&nbsp;ยอดนิยม_4
</div>
<div class="w3-container w3-third">

<input name="popular_5" type='checkbox'  value = '1' >&nbsp;&nbsp;ยอดนิยม_5
</div>
</div>
</fieldset>
</p>



<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='add_product1.php'; submit()">
</center>

</p>



<?php include('foot.php'); ?>















</form>














</body>
</html>


