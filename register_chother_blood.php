<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

<style type="text/css">

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 8px 10px;
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
<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->
</style>

<body>
<?php

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb__gluboold";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "OT";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}





	 ?>

	<!--action="register_office1.php"-->
	<form action='register_chother_blood1.php' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	
		
	document.frmMain.submit();
}


</script>
<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>ลงทะเบียนลูกค้าแลกเครื่องวัดน้ำตาล</h4></div>

<div class="w3-bar">
	<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
	</div>

</p>

<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>
	
<fieldset><legend ><b><font color="red">ข้อมูลลูกค้า</font></b></legend></p>	
	
<div class="w3-container w3-third">
วันที่ : 
<input type="date" name = "register_date" id="register_date" style="width:90%;"  value="<?php echo $today; ?>" class = "w3-input" required> 	

</div><div class="w3-container w3-third">
ชื่อลูกค้า :
<input type='text' name = "customer_name"  id = "customer_name" style="width:90%;" class="w3-input" required>
</div><div class="w3-container w3-third">

ที่อยู่
<textarea name="address" id="address" class="w3-input" rows="2" style="width:90%" required></textarea>
	
</div><div class="w3-container w3-third">
เขต/อำเภอ :
<input type='text' name = "add_aumpher"  id = "add_aumpher" style="width:90%;" class="w3-input" required>

</div><div class="w3-container w3-third">
เบอร์โทรศัพท์ :
<input type='text' name = "customer_tel"  id = "customer_tel" style="width:90%;" class="w3-input" required>
						
</div>


<div class="w3-container w3-third">
จังหวัด
<select name="province" id="province"  style="width:90%;" class="w3-input" required>
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { 
 ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

</div>


<div class="w3-container w3-third">
รหัสไปรษณีย์
<input name="postcode" id="postcode"  style="width:90%;" class="w3-input" required>
</div>
<div class="w3-container w3-third">
ยี่ห้อ / รุ่น เครื่องวัดน้ำตาลที่แลก
<select name="type_product" id="type_product"  style="width:90%;" class="w3-select" required>
<option class="w3-bar" value="">**โปรดเลือก**</option>
<?php
$province="select * from tb_prochange order by prochange";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { 
 ?>
<option class="w3-bar" value="<?php echo $fepro["prochange"]; ?>"><?php echo $fepro["prochange"]; ?></option>
<?php } ?>
</select>

</div>
<div class="w3-container w3-third">
SN
<input name="sn_number" id="sn_number"  style="width:90%;" class="w3-input" required>
</div>


<div class="w3-container">

แนบไฟล์ <br>
<input name="img_pro1" type='file' id="img_pro1"><br>
<input name="img_pro2" type='file' id="img_pro2"><br>
<input name="img_pro3" type='file' id="img_pro3"><br>



</div>



	</p></fieldset></p>

<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</form>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>

  <!--/div-->

 