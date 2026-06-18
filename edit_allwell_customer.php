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
<form   method="post" action="edit_allwell_customer1.php" name="frmMain" enctype="multipart/form-data"  onSubmit="JavaScript:return fncSubmit();" >
	
	<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	if(document.frmMain.ckk_chnge.value == "1")
	{
		
		
		if(document.frmMain.remark_edit.value == ""){
			
		alert('กรุณาใส่เหตุผลการแก้ไขด้วยค่ะ');
		document.frmMain.remark_edit.focus();
		return false;
		}
	
	}
	
		
	
	document.frmMain.submit();
}


</script>

	<?php
		$strSQL = "SELECT *  FROM tb_customer_pre WHERE id = '".$_GET["id"]."' ";
		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	?>
	<div class="w3-white">
		<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray">
<div class="w3-half"><h4>EDIT : CUSTOMER</h4></div>
<div class="w3-half">
<a href="send_cusadmin.php?id=<?php echo $objResult["id"];?>" class="w3-button w3-grey w3-right"><font color="330066">ส่งข้อมูลให้ Admin</font></a>

</div>
</div>

	<fieldset><legend ><b><font color="red">ข้อมูลพื้นฐาน</font></b></legend></p>

<div class="w3-container w3-third">
		เขตการขาย
<?php if($_SESSION["department"]=='วิศวกรรม'){ ?>
	
<select name="sale_code" id="sale_code"  class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL6 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
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
	<?php }else{ ?>
	
<select name="sale_code" id="sale_code"  class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL6 = "SELECT * FROM tb_team_allwell ORDER BY sale_code ASC";
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
	<?php } ?>
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
คำนำหน้าชื่อ
<input name="preface_name" value = "<?php echo $objResult["preface_name"]; ?>" class="w3-input" >

</div>
<div class="w3-container w3-third">
การชำระเงิน
<select name="credit_ckk" id="credit_ckk" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_bank where close_ckk ='0' order by id";
$objQuery5 = mysqli_query($code,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["credit_ckk"] == $objResuut5["id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['id']; ?>" <?php echo $sel;?>><?php echo $objResuut5['pay_in']; ?></option>
<?php } ?>
</select>



</div>
</p>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">ข้อมูลลูกค้า</font></b></legend></p>

<div class="w3-container w3-third">

<?php /**/ ?>
ชื่อลูกค้า
<input name="customer_name" value = "<?php echo $objResult["customer_name"]; ?>" class="w3-input" >
	<input name="id" type='hidden' value = "<?php echo $objResult["id"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">
 ที่อยู่
<input name="cus_address" value = "<?php echo $objResult["cus_address"]; ?>" class="w3-input" >
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
แฟ็กซ์
<input name="cus_fax" value = "<?php echo $objResult["cus_fax"]; ?>" class="w3-input" >
</div>
<div class="w3-container w3-third">
<?php if($objResult["vip_ckk"]=='1'){ ?>	
<br><input type='checkbox' value='1' checked='checked' id='vip_ckk' name = 'vip_ckk'> ลูกค้า VIP	
	<?php }else{ ?>
<br><input type='checkbox' value='1' id='vip_ckk' name = 'vip_ckk'> ลูกค้า VIP	
	<?php } ?>
	</div>
</p>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">ข้อมูลการออกบิล</font></b></legend><br>

<div class="w3-container w3-third">
 ชื่อที่ใช้ออกบิล
<input name="bill_name" value = "<?php echo $objResult["bill_name"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 ที่อยู่ออกบิล
<input name="bill_address" value = "<?php echo $objResult["bill_address"]; ?>" class="w3-input" >
</div>


<div class="w3-container w3-third">
เขต/อำเภอ
<input name="bill_ampher" value = "<?php echo $objResult["bill_ampher"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 
จังหวัด
<select name="billl_province"  class="w3-select">
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { 

if($objResult["billl_province"] == $fepro["province_name"]) {
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
<input name="bill_postcode" value = "<?php echo $objResult["bill_postcode"]; ?>" class="w3-input" >
</div>


<div class="w3-container w3-third">
โทรศัพท์
<input name="bill_tel" value = "<?php echo $objResult["bill_tel"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 TAX ID
<input name="tax_id" value = "<?php echo $objResult["tax_id"]; ?>" class="w3-input" >
</div>
<div class="w3-container w3-third">
 E-Mail
<input name="email_cus" value = "<?php echo $objResult["email_cus"]; ?>" class="w3-input" >
</div>
</p>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">ข้อมูลการจัดส่ง</font></b></legend></p>


<div class="w3-container w3-third">
 ชื่อที่ใช้ในการจัดส่ง
<input name="delivery_name" value = "<?php echo $objResult["delivery_name"]; ?>" class="w3-input" >
</div>


<div class="w3-container w3-third">
ที่อยู่
<input name="del_address" value = "<?php echo $objResult["del_address"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
เขต/อำเภอ
<input name="del_ampher" value = "<?php echo $objResult["del_ampher"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
จังหวัด
<select name="del_province" class="w3-select">
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { 

if($objResult["del_province"] == $fepro["province_name"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>

<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>" <?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

</div>


<div class="w3-container w3-third">
รหัสไปรษณีย์
<input name="del_postcode" value = "<?php echo $objResult["del_postcode"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 โทรศัพท์
<input name="del_tel" value = "<?php echo $objResult["del_tel"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 ผู้ติดต่อ
<input name="contact_name" value = "<?php echo $objResult["contact_name"]; ?>" class="w3-input" >
</div>

</p>
</fieldset>
</p>






<br>
<center>
		  <input type="submit" name ="Submit" value="บันทึก" class = "button button4" >
</center>

<br>


</div>
<div id="cr_bar"><?php include "foot.php"; ?></div>


</form>

</body>
</html>


