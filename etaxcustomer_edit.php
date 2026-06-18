<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/tab.css">
<style>
.div-a{
float:left;
height:2%;
}
.div-b{
float:left;
height:2%;
}	
	
</style>

<?php 
include('head.php'); 

include('dbconnect.php');
 ?>

<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 1px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #000000; font-size: 16px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 16px; color: #3300FF;}
.style40 {font-size: 14px; color: #FF0000; }
-->

.button {
    background-color: #652076;
    border: 1px solid black;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 2px 2px;
    cursor: pointer;
}


	
.button99 {
    background-color: #FF0000;
    border: 1px solid black;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 2px 2px;
    cursor: pointer;
}	

.button1 {border-radius: 2px;}
.button2 {padding: 0px 0px; border-radius: -5px; border: 0.1px solid #9B9B9B;} 
.button3 {border-radius: 25px;padding: 4px 16px;}
.button4 {padding: 2px 16px; border-radius: 12px; border: 0.1px solid #9B9B9B;}
.button44 {padding: 2px 16px; border-radius: 12px; border: 0.1px solid #FF0000;}
.button5 {border-radius: 50%;}
</style>
<?php
date_default_timezone_set("Asia/Bangkok");

$ref_id = $_GET["ref_id"];

$strSQL = "SELECT * FROM tb_customer_etax WHERE ref_id = '".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL) or die("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

?>

<body>
<form  action= "etaxcustomer_edit1.php"  method="POST" name="frmMain" enctype="multipart/form-data" >
<div class="w3-white">	
	
	<div class="w3-container w3-padding-large">

<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h5>ข้อมูลสำหรับออกใบกำกับภาษี</h5></div>
<br>
<div class="w3-container w3-half">
<b>ประเภทของผู้ขอออกใบกำกับภาษี (Type of Requester) <font color='red'>*</font></b> 
<select name="type_tax" class="w3-input" required>
<option value="<?php echo $objResult["type_tax"]; ?>"><?php echo $objResult["type_tax"]; ?></option>
<option  value="บุคคลธรรมดา">บุคคลธรรมดา</option>
<option  value="นิติบุคคล / บุคคลธรรมดาที่จด VA">นิติบุคคล / บุคคลธรรมดาที่จด VAT</option>

</select>
<div class="div-a"></div>
</div><div class="w3-container w3-half">		
<b>ช่องทางการซื้อสินค้า <font color='red'>*</font></b>
<select id="sale_channel" name="sale_channel" style="width:100%;"  class="w3-input" required>
<option value="<?php echo $objResult["sale_channel"]; ?>"><?php echo $objResult["sale_channel"]; ?></option>
<option  value="LAZADA">LAZADA</option>
<option  value="SHOPEE">SHOPEE</option>
<option  value="อื่นๆ">อื่นๆ</option>
		
</select>

<div class="div-a"></div>
	</div>
<div class="w3-container w3-half">	
<b>หมายเลขคำสั่งซื้อ <font color='red'>*</font></b>
<input name="order_id" id="order_id" value ="<?php echo $objResult["order_id"]; ?>" class="w3-input" style="width:100%;" required>		
<input name="ref_id" id="ref_id" type="hidden" value ="<?php echo $objResult["ref_id"]; ?>" class="w3-input" style="width:100%;" required>		
	
<div class="div-a"></div>
	</div>		
<!--div class="w3-container w3-half">	
<b>จำนวนเงินทั้งหมด (Total Payment Amount) <font color='red'>*</font></b>
<input name="amount" id="amount" value ="<?php echo $objResult["amount"]; ?>" class="w3-input"  style="width:100%;color:black;text-align:right" required>			
<div class="div-a"></div>
		</div-->
<div class="w3-container w3-half">	
<b>เลขประจำตัวผู้เสียภาษี (Tax Id) <font color='red'>*</font></b>
<input name="tax_id" id="tax_id" value ="<?php echo $objResult["tax_id"]; ?>" class="w3-input" style="width:100%;" required>		
	
<div class="div-a"></div>
	</div>		
<div class="w3-container w3-half">	
<b>เลขสาขา (ถ้ามี)</b>
<input name="brun_no" id="brun_no" value ="<?php echo $objResult["brun_no"]; ?>" class="w3-input" style="width:100%;" >		
	
<div class="div-a"></div>
	</div>	
		
	<div class="div-a"></div>
	</div>	
<div class="w3-container">	
<div class="w3-container w3-half">
	<b>ชื่อ</b> (first Name) <font color='red'>*</font>
<input name="head_name" id="head_name"  value ="<?php echo $objResult["head_name"]; ?>" class="w3-input" style="width:100%;" required>
<div class="div-a"></div>	
</div><div class="w3-container w3-half">
	<b>นามสกุล</b> (Last Name) <font color='red'>*</font>
<input name="last_name" id="last_name"  value ="<?php echo $objResult["last_name"]; ?>" class="w3-input" style="width:100%;" required>
	<div class="div-a"></div>
</div>	<div class="w3-container">
<b>ที่อยู่</b> (Address) <font color='red'>*</font>
<textarea name="address" id="address" class="w3-input" rows="2" style="width:100%;" required><?php echo $objResult["address"]; ?></textarea>
<div class="div-a"></div>
</div>

<div class="w3-container w3-third">
<b>แขวง/ตำบล</b> (Sub-district) <font color='red'>*</font>
<input name="sub_district" id="sub_district"  value ="<?php echo $objResult["sub_district"]; ?>" class="w3-input" style="width:100%;" required>
		<div class="div-a"></div>
</div><div class="w3-container w3-third ">
<b>เขต/อำเภอ</b> (District) <font color='red'>*</font>
<input name="district" id = "district" value ="<?php echo $objResult["district"]; ?>"  class="w3-input" style="width:100%;" required>
		<div class="div-a"></div>
</div><div class="w3-container w3-third ">

<b>จังหวัด</b> (Province) <font color='red'>*</font>
<select name="province" class="w3-input" style="width:100%;" required>
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) 
{ 
if($objResult["province"] == $fepro["province_name"]){
$sel = "selected";
} else {
$sel = "";
}
	?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
		<div class="div-a"></div>
</div>

<div class="w3-container w3-half">
<b> รหัสไปรษณีย์ </b> (Post Code)  <font color='red'>*</font>
<input name="postcode" id = "postcode"  value ="<?php echo $objResult["postcode"]; ?>" class="w3-input" style="width:100%;" required>
<div class="div-a"></div>
</div><div class="w3-container w3-half">
<b>เบอร์โทรศัพท์ </b> (Phone Number)  <font color='red'>*</font>
<input name="tel_num" id = "tel_num"  value ="<?php echo $objResult["tel_num"]; ?>" class="w3-input" style="width:100%;" required>
<div class="div-a"></div>
</div>
<div class="w3-container">
<b> อีเมล์สำหรับนำส่งใบกำกับภาษี </b> (E-mail)  <font color='red'>*</font>
<input name="mail_cus" id = "mail_cus"  value ="<?php echo $objResult["mail_cus"]; ?>" class="w3-input" style="width:100%;" required>
	<div class="div-a"></div>
	</div>
	<div class="w3-container w3-half">
		<?php if($objResult["import_order"]=='0'){ ?>
	<input name="import_order" id = "import_order"  value ="<?php echo $objResult["import_order"]; ?>" type="hidden" >
		<?php }else if($objResult["import_order"]=='2'){ ?>
	<input name="import_order" id = "import_order"  value ="1" type="checkbox" > ดำเนินการแก้ไขบิลเรียบร้อยแล้ว	
		<?php }else{ ?>
	<input name="import_order" id = "import_order" checked="checked"  value ="1" type="checkbox" > ดำเนินการแก้ไขบิลเรียบร้อยแล้ว		
		<?php } ?>
		<div class="div-a"></div>
</div>
</div>
<br>

<center>


<input type="submit" name="submit" value="บันทึกข้อมูล" class="w3-button w3-teal" >
</center>
<br>

</div></div></div></div></div>

<?php include('foot.php'); ?>
</form>

</body>
</html>


