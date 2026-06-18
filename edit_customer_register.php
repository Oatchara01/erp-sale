<?php 


include('head.php');
include('dbconnect_sale.php');

 
 
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
<form action = 'edit_customer_register1.php'   method="POST" name="frmMain" enctype="multipart/form-data" >
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>EDIT : CUSTOMER</h4></div>
<?php
		$strSQL = "SELECT *  FROM tb_customer WHERE customer_id = '".$_GET["customer_id"]."' ";


		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	?>
	
<div class="w3-container w3-third">
		เขตการขาย

<select name="sale_code" id="sale_code"  class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL6 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
$objQuery6 = mysqli_query($com,$strSQL6);
while($objResuut6 = mysqli_fetch_array($objQuery6))
{
if($objResult["sale_code"] == $objResuut6["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut6["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut6["sale_code"];?> - <?php echo $objResuut6["sale_name"];?></option>
<?php
}
?>
</select>
</div>	
	
<div class="w3-container w3-third">
ประเภทลูกค้า
<select name="type_customer" id="type_customer" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_typecustomer order by type_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["type_customer"] == $objResuut5["type_id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['type_id']; ?>" <?php echo $sel;?>><?php echo $objResuut5['type_name']; ?></option>
<?php } ?>
</select>



</div><div class="w3-container w3-third">
รหัสลูกค้า
<input name="customer_no" value = "<?php echo $objResult["customer_no"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
.

</div>



<div class="w3-container w3-third">

ชื่อลูกค้า
<input name="first_name" value = "<?php echo $objResult["first_name"]; ?>" class="w3-input" >
	<input name="customer_id" type='hidden' value = "<?php echo $objResult["customer_id"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">

นามสกุล
<input name="last_name" value = "<?php echo $objResult["last_name"]; ?>" class="w3-input" >
	<input name="customer_name" type='hidden' value = "<?php echo $objResult["customer_name"]; ?>" class="w3-input" >

</div>
	
<div class="w3-container w3-third">
 วันเกิด
<input type = 'date' name="brithday" value = "<?php echo $objResult["brithday"]; ?>" class="w3-input" >
</div>
	
<div class="w3-container w3-third">
 สถานภาพสมรส
<input name="status" value = "<?php echo $objResult["status"]; ?>" class="w3-input" >
</div>

<div class="w3-container w3-third">
อาชีพ
<input name="occupation" value = "<?php echo $objResult["occupation"]; ?>" class="w3-input" >
	
</div>
	<?php /*<div class="w3-container w3-third">
 รายได้ต่อเดือน</p>
<?php if($objResult["salary"]=='1'){ ?>
	<input type='radio'  name='salary' id = 'salary' value='1' checked='checked' > <?php echo "< 30,000 ฿"; ?> 
	<?php }elseif($objResult["salary"]=='2'){ ?>
	<input type='radio'  name='salary' id = 'salary' value='2' checked='checked' >  30,001 - 50,000 ฿ 
	<?php }elseif($objResult["salary"]=='3'){ ?>
<input type='radio'  name='salary' id = 'salary' value='3' checked='checked' >  50,001 - 100,000 ฿ 
<?php }elseif($objResult["salary"]=='4'){ ?>
<input type='radio'  name='salary' id = 'salary' value='4' checked='checked' >  100,001 - 200,000 ฿ 
<?php }elseif($objResult["salary"]=='5'){ ?>
<input type='radio'  name='salary' id = 'salary' value='5' checked='checked' >  > 200,000 ฿ 
	<?php } ?>
</div>*/ ?>
	
<div class="w3-container w3-third">
 อายุ 
	<div class="w3-input" style="border:hidden;">
<input style="width:96%;" type = 'number' name="age" value = "<?php echo $objResult["age"]; ?>"  > ปี
		</div>
</div>
<div class="w3-container w3-third">
Email
<input name="email_cus" value = "<?php echo $objResult["email_cus"]; ?>" class="w3-input" >
</div>
	
	<div class="w3-container w3-third">
 เลขที่/อาคาร/หมู่บ้าน
<input name="cus_addno" value = "<?php echo $objResult["cus_addno"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
แขวง/ตำบล
<input name="cus_addtum" value = "<?php echo $objResult["cus_addtum"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 เขต/อำเภอ
<input name="cus_ampher" value = "<?php echo $objResult["cus_ampher"]; ?>" class="w3-input" >
</div>
<div class="w3-container w3-third">
 จังหวัด
<select name="cus_province" class="w3-select">
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { 

if($objResult["cus_province"] == $fepro["province_name"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>" <?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

</div><div class="w3-container w3-third">
 รหัสไปรษณีย์
<input name="cus_postcode" value = "<?php echo $objResult["cus_postcode"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
โทรศัพท์
<input name="cus_tel" value = "<?php echo $objResult["cus_tel"]; ?>" class="w3-input" >
</div>
	<div class="w3-container w3-third">
.
</div><div class="w3-container w3-third">
.
</div>

<div class="w3-container w3-third"></p>
	ท่านสนใจสินค้าสำหรับ</p>
<?php if($objResult["product_fer1"] =='1'){ ?>
<input type='checkbox'  name='product_fer1' id = 'product_fer1'  value='1' checked='checked' />  ผู้ป่วยพักฟื้น </p>
<?php } if($objResult["product_fer2"] =='2'){ ?>
<input type='checkbox'  name='product_fer2' id = 'product_fer2' value='2' checked='checked' />  ผู้สูงอายุ </p>
<?php } if($objResult["product_fer3"] =='3'){ ?>
<input type='checkbox'  name='product_fer3' id = 'product_fer3' value='3' checked='checked' />  ผู้ป่วยติดเตียง </p>
<?php } if($objResult["product_fer4"] =='4'){ ?>
<input type='checkbox'  name='product_fer4' id = 'product_fer4' value='4' checked='checked' />  สินค้าดูแลสุขภาพ </p>
<?php } ?>
</div>		

<div class="w3-container w3-third"></p>
ท่านรุ้จัก Allwel ครั้งแรกได้อย่างไร </p>

<?php if($objResult["well_allwell"] =='1'){ ?>
<input type='radio'  name='well_allwell' id = 'well_allwell' value='1' checked='checked' >  ผลการค้นหาบน Google </p>
<?php }else if($objResult["well_allwell"] =='2'){ ?>
<input type='radio'  name='well_allwell' id = 'well_allwell' value='2' checked='checked' >  โฆษณา Banner บน Website </p>
<?php }else if($objResult["well_allwell"] =='3'){ ?>
<input type='radio'  name='well_allwell' id = 'well_allwell' value='3' checked='checked' >  คนรู้จัก / บุคลากรทางการแพทย์แนะนำ </p>
<?php }else if($objResult["well_allwell"] =='4'){ ?>
<input type='radio'  name='well_allwell' id = 'well_allwell' value='4' checked='checked' >  รู้จักจาก ฟาร์ ทริลเลียน </p>
<?php }else if($objResult["well_allwell"] =='5'){ ?>
<input type='radio'  name='well_allwell' id = 'well_allwell' value='5' checked='checked' >  อื่นๆ 
<?php } ?>
	</div>			

<div class="w3-container w3-third"></p>
สิ่งสำคัญในการเลือกซื้อสินค้า / บริการ</p>
<?php if($objResult["best_service1"] =='1'){ ?>
<input type='checkbox'  name='best_service1' id = 'best_service1' value='1' checked='checked'/>  บริการก่อนและหลังการขาย </p>
<?php } if($objResult["best_service2"] =='2'){ ?>
<input type='checkbox'  name='best_service2' id = 'best_service2' value='2' checked='checked'/>  ความน่าเชื่อถือของบริษัท</p>
<?php } if($objResult["best_service3"] =='3'){ ?>
<input type='checkbox'  name='best_service3' id = 'best_service3' value='3' checked='checked'/>  สินค้าที่มีคุณภาพ 
<?php } ?>
</div>


<div class="w3-container w3-third"></p>
ท่านเคยซื้อสินค้าจาก Allwell หรือไม่ ? 	</p>
<?php if($objResult["best_service4"] =='1'){ ?>
<input type='radio'  name='best_service4' id = 'best_service4' value='1' checked='checked'/>  เคย </p>
<?php }else if($objResult["best_service4"] =='0'){ ?>
<input type='radio'  name='best_service4' id = 'best_service4' value='0' checked='checked'/>  ไม่เคย </p>
<?php } ?>
</div>

<div class="w3-container w3-third">
อื่นๆ		

<textarea name="description" id = "description" class="w3-input" rows="3" style="width:100%;"><?php echo $objResult["description"]; ?></textarea>

</div>	
	
<div class="w3-container w3-third">
</p>สถานะลูกค้า</p>
<?php if($objResult["status_cus"] =='0'){ ?>
<input type='radio'  name='status_cus' id = 'status_cus' value='0' checked='checked'/>   Gold Customer </p>
<input type='radio'  name='status_cus' id = 'status_cus' value='1' />   Patinum Customer </p>
<input type='radio'  name='status_cus' id = 'status_cus' value='2'/>   Diamond Customer </p>
<?php }else if($objResult["status_cus"] =='1'){ ?>
<input type='radio'  name='status_cus' id = 'status_cus' value='0' />   Gold Customer </p>
<input type='radio'  name='status_cus' id = 'status_cus' value='1' checked='checked'/>   Patinum Customer </p>
<input type='radio'  name='status_cus' id = 'status_cus' value='2'/>   Diamond Customer </p>
<?php }else{ ?>
<input type='radio'  name='status_cus' id = 'status_cus' value='0' />   Gold Customer </p>
<input type='radio'  name='status_cus' id = 'status_cus' value='1' />   Patinum Customer </p>
<input type='radio'  name='status_cus' id = 'status_cus' value='2' checked='checked'/>   Diamond Customer </p>
<?php } ?>
</div>	



</br>
<center>
		  <input type="submit" name ="Submit" value="บันทึก" class = "button button4" >
</center>

<br><br>



</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

</form>


</body>
</html>


