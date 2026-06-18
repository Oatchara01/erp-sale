<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Allwell Healthcare</title>
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

<script type="text/javascript">
function ck_frm(){
var ck = document.getElementById('ckk');
if(ck.checked == true){
document.getElementById('frm_txt').style.display = "";
}else{
document.getElementById('frm_txt').style.display = "none";
}

}


</script>



<?php 
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
    background-color: #FF99FF;
    border: none;
    color: black;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin: 4px 2px;
    cursor: pointer;
}	

.button1 {border-radius: 2px;}
.button2 {padding: 0px 0px; border-radius: -5px; border: 0.1px solid #9B9B9B;} 
.button3 {border-radius: 25px;padding: 4px 16px;}
.button4 {padding: 2px 16px; border-radius: 12px; border: 0.1px solid #9B9B9B;}
.button5 {border-radius: 50%;}
</style>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>

<body>
<form  action= "register_cusetax_create1.php"  method="POST" name="frmMain" enctype="multipart/form-data" >
	<div class="w3-container">
		<center><br><br>
<img src="img/allwell_logo.png" width="240" align="center" height="70" /><br><br>
	
<h2><b><font color='#652076'>ขอใบกำกับภาษีอิเล็กทรอนิกส์</font></b></h2>
<h4>(Request e-Tax invoice & e-Receipt)</h4>	
<div class="w3-container w3-red" style="width:80%;"><h5>กรุณาขอใบกำกับภาษีภายใน 7 วันหลังจากสั่งซื้อสินค้า</h5></div>
	</center><br><br>

<div class="w3-container w3-purple"><h5>ข้อมูลสำหรับออกใบกำกับภาษี</h5></div>
<br>
<div class="w3-container w3-half">
<b>ประเภทของผู้ขอออกใบกำกับภาษี (Type of Requester) <font color='red'>*</font></b> 
<select name="type_tax" class="w3-input" required>
<option  value="">กดเพื่อเลือกตัวเลือก</option>
<option  value="บุคคลธรรมดา">บุคคลธรรมดา</option>
<option  value="นิติบุคคล / บุคคลธรรมดาที่จด VAT">นิติบุคคล / บุคคลธรรมดาที่จด VAT</option>

</select>
<div class="div-a"></div>
</div><div class="w3-container w3-half">		
<b>ช่องทางการซื้อสินค้า <font color='red'>*</font></b>
<select id="sale_channel" name="sale_channel" style="width:100%;"  class="w3-input" required>
<option  value="">กดเพื่อเลือกตัวเลือก</option>
<option  value="LAZADA">LAZADA</option>
<option  value="SHOPEE">SHOPEE</option>
<option  value="อื่นๆ">อื่นๆ</option>
		
</select>

<div class="div-a"></div>
	</div>
<div class="w3-container w3-half">	
    <b>หมายเลขคำสั่งซื้อ <font color='red'>*</font></b>
    <input name="order_id" id="order_id" class="w3-input" style="width:100%;" required>		
    <div class="div-a"></div>
</div>	
	<div class="div-a"></div>
</div>	
<div class="w3-container">	
<div class="w3-container w3-half">		
<input type="checkbox" name="ckk" id="ckk" onClick="ck_frm();" value="1"/><font color='red' >เพิ่มเติมหมายเลขคำสั่งซื้อ</font><br>
<div class="div-a"></div>
</div>		
<div id="frm_txt" style="display:none;">
	
<div class="w3-container w3-half">	
    <b>หมายเลขคำสั่งซื้อ </b>
    <input name="order_id9" id="order_id9" class="w3-input" style="width:100%;" >		
    <div class="div-a"></div>
</div>	
	
	
<div class="w3-container w3-half">	
    <b>หมายเลขคำสั่งซื้อ </b>
    <input name="order_id1" id="order_id1" class="w3-input" style="width:100%;" >		
    <div class="div-a"></div>
</div>	

	
<div class="w3-container w3-half">	
    <b>หมายเลขคำสั่งซื้อ </b>
    <input name="order_id2" id="order_id2" class="w3-input" style="width:100%;" >		
    <div class="div-a"></div>
</div>	

		
<div class="w3-container w3-half">	
    <b>หมายเลขคำสั่งซื้อ </b>
    <input name="order_id3" id="order_id3" class="w3-input" style="width:100%;" >		
    <div class="div-a"></div>
</div>	

		
<div class="w3-container w3-half">	
    <b>หมายเลขคำสั่งซื้อ </b>
    <input name="order_id4" id="order_id4" class="w3-input" style="width:100%;" >		
    <div class="div-a"></div>
</div>	

		
<div class="w3-container w3-half">	
    <b>หมายเลขคำสั่งซื้อ </b>
    <input name="order_id5" id="order_id5" class="w3-input" style="width:100%;" >		
    <div class="div-a"></div>
</div>	

		
<div class="w3-container w3-half">	
    <b>หมายเลขคำสั่งซื้อ </b>
    <input name="order_id6" id="order_id6" class="w3-input" style="width:100%;" >		
    <div class="div-a"></div>
</div>	

<div class="w3-container w3-half">	
    <b>หมายเลขคำสั่งซื้อ </b>
    <input name="order_id7" id="order_id7" class="w3-input" style="width:100%;" >		
    <div class="div-a"></div>
</div>	

<div class="w3-container w3-half">	
    <b>หมายเลขคำสั่งซื้อ </b>
    <input name="order_id8" id="order_id8" class="w3-input" style="width:100%;" >		
    <div class="div-a"></div>
</div>	
	
	
</div>		
</div>	
	
	
<div class="w3-container">

<div class="w3-container w3-half">	
<b>เลขประจำตัวผู้เสียภาษี (Tax Id) <font color='red'>*</font></b>
<input name="tax_id" id="tax_id" class="w3-input" style="width:100%;" required>		
	
<div class="div-a"></div>
	</div>		
<div class="w3-container w3-half">	
<b>เลขสาขา (ถ้ามี)</b>
<input name="brun_no" id="brun_no" class="w3-input" style="width:100%;" >		
	
<div class="div-a"></div>
	</div>				
	
<div class="w3-container w3-half">
	<b>ชื่อ</b> (first Name) <font color='red'>*</font>
<input name="head_name" id="head_name" class="w3-input" style="width:100%;" required>
<div class="div-a"></div>	
</div><div class="w3-container w3-half">
	<b>นามสกุล</b> (Last Name) <font color='red'>*</font>
<input name="last_name" id="last_name" class="w3-input" style="width:100%;" required>
	<div class="div-a"></div>
</div>	<div class="w3-container">
<b>ที่อยู่</b> (Address) <font color='red'>*</font>
<textarea name="address" id="address" class="w3-input" rows="2" style="width:100%;" required></textarea>
<div class="div-a"></div>
</div>

<div class="w3-container w3-third">
<b>แขวง/ตำบล</b> (Sub-district) <font color='red'>*</font>
<input name="sub_district" id="sub_district" class="w3-input" style="width:100%;" required>
		<div class="div-a"></div>
</div><div class="w3-container w3-third ">
<b>เขต/อำเภอ</b> (District) <font color='red'>*</font>
<input name="district" id = "district" class="w3-input" style="width:100%;" required>
		<div class="div-a"></div>
</div><div class="w3-container w3-third ">

<b>จังหวัด</b> (Province) <font color='red'>*</font>
<select name="province" class="w3-input" style="width:100%;" required>
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
		<div class="div-a"></div>
</div>

<div class="w3-container w3-half">
<b> รหัสไปรษณีย์ </b> (Post Code)  <font color='red'>*</font>
<input name="postcode" id = "postcode" class="w3-input" style="width:100%;" required>
<div class="div-a"></div>
</div><div class="w3-container w3-half">
<b>เบอร์โทรศัพท์ </b> (Phone Number)  <font color='red'>*</font>
<input name="tel_num" id = "tel_num" class="w3-input" style="width:100%;" required>
<div class="div-a"></div>
</div>
<div class="w3-container">
<b> อีเมล์สำหรับนำส่งใบกำกับภาษี </b> (E-mail)  <font color='red'>*</font>
<input name="mail_cus" id = "mail_cus" class="w3-input" style="width:100%;" required>
	<div class="div-a"></div>
</div>
</div>
<br>
	<div class="w3-container">
<div class="w3-container w3-dark-grey"><h5>เงื่อนไขการขอใบกำกับภาษีอิเล็กทรอนิกส์</h5></div>
<br>

<b> 1. ลูกค้าสามารถดำเนินการกรอกข้อมูลที่จำเป็นเพื่อขอออกใบกำกับภาษีแบบเต็มรูปในรูปแบบอิเล็กทรอนิกส์ ภายหลังจากที่ซื้อสินค้า 7 วัน</b><br>
<b> 2. โปรดตรวจสอบความถูกต้องของข้อมูล ก่อนส่งข้อมูล กรณีที่ข้อมูลไม่ถูกต้องจะไม่สามารถแก้ไขได้</b><br>
<b> 3. การเก็บใช้และเปิดเผยข้อมูลส่วนบุคคลเพื่อดำเนินการออกใบกำกับภาษีแบบเต็มรูปในรูปแบบอิเล็กทรอนิกส์ สามารถดูรายละเอียดเพิ่มเติมได้ที่ <a href="https://allwellhealthcare.com/privacy-policy-2/"  target="_blank" ><font color="blue">Click ที่นี่</font></a></b><br>
<b> 4. ใบกำกับภาษีอิเล็กทรอนิกส์จะจัดส่งทางอีเมล์ภายใน 7 วันหลังกรอกแบบฟอร์ม</b><br>


<br><br>

<center>


		  <input type="submit" name ="Submit" value="ยืนยัน" class = "button button4" onclick="return confirm('โปรดตรวจสอบความถูกต้องของข้อมูล ก่อนส่งข้อมูล กรณีที่ข้อมูลไม่ถูกต้องจะไม่สามารถแก้ไขได้')" >
</center>
<br>

</div></div></div></div></div>

<?php include('foot.php'); ?>
</form>

</body>
</html>

