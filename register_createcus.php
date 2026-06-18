<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Allwell Healthcare</title>
<!--script src="https://code.jquery.com/jquery-1.8.3.js"></script-->
<link rel="stylesheet" href="css/w3.css">
<!--link rel="stylesheet" href="css/tab.css"-->
<?php include('dbconnect.php'); ?>

<style>
.div-a{
float:left;
height:7%;
}
.div-b{
float:left;
height:2%;
}	
	
</style>
<script language="javascript">

	    $("document").ready(function(){
    $("#cus_tel").focusout(function(){
        if($(this).val().length < 10){
            alert("กรุณากรอกเฉพาะตัวเลขให้ครบ10หลัก");
            $(this).focus();
        }
    });
});

</script>

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
.style37 {color: #FF0000; font-size: 14px; }
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

.button1 {border-radius: 2px;}
.button2 {padding: 0px 0px; border-radius: -5px; border: 0.1px solid #9B9B9B;} 
.button3 {border-radius: 25px;padding: 4px 16px;}
.button4 {padding: 2px 16px; border-radius: 12px; border: 0.1px solid #9B9B9B;}
.button5 {border-radius: 50%;}
	
</style>


<body>
<form  action= "register_customer1.php"  method="POST" name="frmMain" enctype="multipart/form-data"  OnSubmit="return fncSubmit();">
<div class="w3-container">
	
		
		 

<center><br><br>
<img src="img/allwell_logo.png" width="240" align="center" height="70" /><br><br>
	
<h2><b><font color='#652076'>แบบฟอร์มสมัครสมาชิก Allwell Member</font></b></h2>
<h4>Allwell Member Application Form</h4>	
	</center><br>
		
<div class="w3-container w3-purple"><h5>ข้อมูลสมาชิก</h5></div>
<br>

<div class="w3-container w3-third">
<b>ชื่อ</b> (first Name) 
<input name="first_name" id="first_name" class="button4" style="width:90%;" required>
	<div class="div-a"></div>
</div><div class="w3-container w3-third ">
<b>นามสกุล</b> (Last Name)
<input name="last_name" id="last_name" class="button4" style="width:90%;" required>
	<div class="div-a"></div>
</div><div class="w3-container w3-third ">

<b>วันเกิด</b> (Birthday)<br>
<select name="date_brith" id="date_brith" class="button4" style="width:30%;" required>
<option class="w3-bar" value="">วันที่</option>
<?php
$province="select * from tb_day order by date_no";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["date_no"]; ?>"><?php echo $fepro["date_no"]; ?></option>
<?php } ?>
</select>


<select name="month_brith" id="month_brith" class="button4" style="width:30%;" required>
<option class="w3-bar" value="">เดือน</option>
<?php
$province="select * from tb_month order by month_id ";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["month_code"]; ?>"><?php echo $fepro["month_name"]; ?></option>
<?php } ?>
</select>

<select name="year_brith" id="year_brith" class="button4" style="width:30%;" title="ปีเกิด" required >
<option class="w3-bar" value="">ปี</option>
<?php
$province="select * from tb_year ";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
	<?php if($fepro["year_name"] == '2510'){ ?>
<option class="w3-bar" selected value="<?php echo $fepro["year_no"]; ?>"><?php echo $fepro["year_name"]; ?></option>
		<?php } else { ?>
	<option class="w3-bar" value="<?php echo $fepro["year_no"]; ?>"><?php echo $fepro["year_name"]; ?></option>
	<?php } // ?>
<?php } // ?>
</select>
<div class="div-a"></div>
</div><div class="w3-container w3-third">		
<b>สถานภาพสมรส</b> (Marital status)<br>
<input type='radio'  name='status' id = 'status' value='โสด' required> โสด (Single)<br>
<input type='radio'  name='status' id = 'status' value='สมรส' required> สมรส (Married)<br>
<input type='hidden'  name='status' id = 'status' value='หย่าร้าง' ><!-- หย่าร้าง (Divorced)<br -->
	<!--div class="div-a"></div--><div class="div-b"></div>
</div>
	<div class="w3-container w3-third">
<b>อาชีพ</b> (Occupation)
<select name="occupation" id="occupation" class="button4" style="width:90%;" required>
<option class="w3-bar" value="">**Please choose**</option>
<?php
$province1="select * from tb_occupation order by occupation_id";
$prosql1=mysqli_query($conn,$province1);
while ($fepro1=mysqli_fetch_array($prosql1)) { ?>
<option class="w3-bar" value="<?php echo $fepro1["occupation_name"]; ?>"><?php echo $fepro1["occupation_name"]; ?></option>
<?php } ?>
</select>	
	
</div>
		<div class="w3-container w3-third">
<b>อายุ</b> (Age)
<br>
<input class="button4" type='number'  name='age' id = 'age'  required> ปี
</div>
	</div><br>
<div class="w3-container">
<div class="w3-container w3-purple"><h5>ข้อมูลติดต่อ</h5></div>
<br>
<div class="w3-container w3-third ">
<b>ที่อยู่</b> (Address)
<input name="cus_addno" id="cus_addno" class="button4" style="width:100%;" required>
		<div class="div-a"></div>
</div><div class="w3-container w3-third">
<b>แขวง/ตำบล</b> (Sub-district)
<input name="cus_addtum" id="cus_addtum" class="button4" style="width:100%;" required>
		<div class="div-a"></div>
</div><div class="w3-container w3-third ">
<b>เขต/อำเภอ</b> (District)
<input name="cus_ampher" id = "cus_ampher" class="button4" style="width:100%;" required>
		<div class="div-a"></div>
</div><div class="w3-container w3-third ">

<b>จังหวัด</b> (Province)
<select name="cus_province" class="button4" style="width:100%;" required>
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
		<div class="div-a"></div>
</div><div class="w3-container w3-third ">
<b>รหัสไปรษณีย์</b> (Post Code)
<input name="cus_postcode" id = "cus_postcode" class="button4" style="width:100%;" required>
		<div class="div-a"></div>
</div><div class="w3-container w3-third ">
<b>เบอร์ติดต่อ</b> (Phone Number)
<input name="cus_tel"  class="button4" id="cus_tel" minlength ="10" maxlength ="10" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกเฉพาะตัวเลขเท่านั้น'); this.value='';}" style="width:100%;" required>
	<div class="div-a"></div>
	</div><div class="w3-container w3-third">
<b>อีเมลล์</b> (E-mail)
<input name="email" id = "email" class="button4" style="width:100%;" required>
		<div class="div-a"></div>
	</div></div>
<br>
<div class="w3-container">
<div class="w3-container w3-dark-grey"><h5>อื่นๆ</h5></div>
<br>
<div class="w3-container w3-half">
<b>ท่านสนใจสินค้าสำหรับ</b> (Are you interested in product for?)
	
<select name="product_fer1" id="product_fer1" class="button4" style="width:100%;">
<option  value="">กดเพื่อเลือกตัวเลือก</option>
<option  value="1">ผู้ป่วยพักฟื้น</option>
<option  value="2">ผู้สูงอายุ</option>
<option  value="3">ผู้ป่วยติดเตียง</option>
<option  value="4">สินค้าดูแลสุขภาพ</option>
</select>
	<div class="div-a"></div>
</div><div class="w3-container w3-half ">	

<b>ท่านรู้จัก Allwell ครั้งแรกได้อย่างไร</b> (How did you know Allwell at first time?)
<select name="well_allwell" id="well_allwell" class="button4" style="width:100%;" required>
<option  value="">กดเพื่อเลือกตัวเลือก</option>
<option  value="1">ผลการค้นหาบน Google (Google search)</option>
<option  value="2">โฆษณา Banner บน Website (Banner on website)</option>
<option  value="3">คนรู้จัก / บุคลากรทางการแพทย์แนะนำ (Familiar person / Recommended by medical professional)</option>
<option  value="4">รู้จักจาก ฟาร์ ทริลเลียน (Knowing from Phar Trillion Co., Ltd.)</option>
<option  value="5">อื่นๆ(Others)</option>
</select>	
		<div class="div-a"></div>
</div><div class="w3-container w3-half ">	

<b>สิ่งสำคัญในการเลือกซื้อสินค้า / บริการ</b> (Which important matter do you consider before purchasing products / services?)
<select name="best_service1" id="best_service1" class="button4" style="width:100%;" required>
<option  value="">กดเพื่อเลือกตัวเลือก</option>
<option  value="1">บริการก่อนและหลังการขาย (Before and after sale services)</option>
<option  value="2">ความน่าเชื่อถือของบริษัท (Company's credibility)</option>
<option  value="3">สินค้าที่มีคุณภาพ (Quality of product)</option>
</select>	
		<div class="div-a"></div>
</div><div class="w3-container w3-half ">	
<b>ท่านเคยซื้อสินค้าจาก Allwell หรือไม่ ?</b> (Have you ever purchased Allwell product?)<br>

<input type='radio'  name='best_service4' id = 'best_service4' value='1'  required>  เคย (Yes) 
<input type='radio'  name='best_service4' id = 'best_service4' value='0'  required>  ไม่เคย (No) 
		<div class="div-a"></div>
	</div></div><div class="w3-container"><div class="w3-container">	
<b>อื่นๆ</b> (Other)
<textarea name="description" id = "description" class="button4" rows="3" style="width:100%;"></textarea>
	<div class="div-a"></div>
</div></div><br>
<center>
		  <input type="submit" name ="Submit" value="สมัครสมาชิก" class = "button button3" >
</center>

</div>
<br><br>
<?php include('foot.php'); ?>
</form>

</body>
</html>


