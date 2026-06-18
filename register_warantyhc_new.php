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

<?php 
include('dbconnect.php');
 ?>

<script language = "JavaScript">

		function ListProductBrand(SelectValue)
		{
			frmMain.ddlProductBrand.length = 0
			frmMain.ddlProductBrand.length = 0
			
			//*** Insert null Default Value ***//
			var myOption = new Option('','')  
			frmMain.ddlProductBrand.options[frmMain.ddlProductBrand.length]= myOption
			
			<?
			$intRows = 0;
			$strSQL = "SELECT * FROM tb_prowaranty ORDER BY id  ASC ";
			$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
			$intRows = 0;
			while($objResult = mysqli_fetch_array($objQuery))
			{
			$intRows++;
			?>			
				x = <? echo $intRows;?>;
				mySubList = new Array();
				
				strGroup = <? echo $objResult["group"];?>;
				strValue = "<? echo $objResult["product_name"];?>";
				strItem = "<? echo $objResult["product_name"];?>";
			    strImg = "<? echo $objResult["img_up"];?>";
				mySubList[x,0] = strItem;
				mySubList[x,1] = strGroup;
				mySubList[x,2] = strValue;
			    mySubList[x,3] = strImg;
			
				if (mySubList[x,1] == SelectValue){
					var myOption = new Option(mySubList[x,0], mySubList[x,2])  
					frmMain.ddlProductBrand.options[frmMain.ddlProductBrand.length]= myOption					
				}
			<?
			}
			?>																	
		}
	
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
<form  action= "register_warantyhc_new1.php"  method="POST" name="frmMain" enctype="multipart/form-data" >
	<div class="w3-container">
		<center><br><br>
<img src="img/allwell_logo.png" width="240" align="center" height="70" /><br><br>
	
<h2><b><font color='#652076'>ลงทะเบียนรับประกันสินค้าออนไลน์</font></b></h2>
<h4>Allwell Online Warranty</h4>	
<div class="w3-container w3-red" style="width:80%;"><h5>กรุณาลงทะเบียนภายใน 14 วันหลังจากได้รับสินค้า</h5></div>
	</center><br><br>

<div class="w3-container w3-purple"><h5>ข้อมูลสินค้า</h5></div>
<br>
<div class="w3-container w3-half">
<b>ประเภทสินค้า</b> 
<select name="product_name" class="w3-input" onChange = "ListProductBrand(this.value)" style="width:100%;" required>
<option class="w3-bar" value="">**โปรดเลือกรุ่นสินค้า**</option>
<?php
$province="select * from tb_growaranty order by id_group ";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["id_group"]; ?>"><?php echo $fepro["group_name"]; ?></option>
<?php } ?>
</select>
<div class="div-a"></div>
</div><div class="w3-container w3-half">		
<b>รุ่นสินค้า</b>
<select id="ddlProductBrand" name="ddlProductBrand" style="width:100%;"  class="w3-input" required></select>

<div class="div-a"></div>
	</div>
<div class="w3-container w3-half">	
<b>Serial number</b>
<input name="serial_num" id="serial_num" class="w3-input" style="width:100%;" required>		
	
<input type="button" name ="Submit" value="ดูตัวอย่าง SN สินค้า" class = "button99 button4"  onClick="this.form.action='sn_waranty.php'; submit()" target="_blank">
	<div class="div-a"></div>
	</div>		
<div class="w3-container w3-half">	
<b>วันที่ติดตั้ง/ซื้อสินค้า</b>
<input name="date_install" id="date_install" value="<?php echo $today; ?>" type="date" class="w3-input" style="width:100%;" required>			<div class="div-a"></div>
		</div>
</div>

	<br>
<div class="w3-container">
<div class="w3-container w3-purple"><h5>ข้อมูลผู้ลงทะเบียนรับประกันสินค้า</h5></div>
<br>
	
<div class="w3-container w3-half">
	<b>ชื่อ</b> (first Name)
<input name="cus_name" id="cus_name" class="w3-input" style="width:100%;" required>
<div class="div-a"></div>	
</div><div class="w3-container w3-half">
	<b>นามสกุล</b> (Last Name)
<input name="cus_lastname" id="cus_lastname" class="w3-input" style="width:100%;" required>
	<div class="div-a"></div>
</div>	<div class="w3-container">
<b>ที่อยู่</b> (Address)
<textarea name="cus_address" id="cus_address" class="w3-input" rows="2" style="width:100%;" required></textarea>
<div class="div-a"></div>
</div>

<div class="w3-container w3-third">
<b>แขวง/ตำบล</b> (Sub-district)
<input name="cus_addtum" id="cus_addtum" class="w3-input" style="width:100%;" required>
		<div class="div-a"></div>
</div><div class="w3-container w3-third ">
<b>เขต/อำเภอ</b> (District)
<input name="cus_ampher" id = "cus_ampher" class="w3-input" style="width:100%;" required>
		<div class="div-a"></div>
</div><div class="w3-container w3-third ">

<b>จังหวัด</b> (Province)
<select name="cus_province" class="w3-input" style="width:100%;" required>
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
<b> รหัสไปรษณีย์</b>
<input name="cus_postcode" id = "cus_postcode" class="w3-input" style="width:100%;" required>
<div class="div-a"></div>
</div><div class="w3-container w3-half">
<b>เบอร์ติดต่อ</b>
<input name="tel_cus" id = "tel_cus" class="w3-input" style="width:100%;" required>
<div class="div-a"></div>
</div>
<div class="w3-container">
<b> อีเมลล์</b>
<input name="email" id = "email" class="w3-input" style="width:100%;" required>
	<div class="div-a"></div>
</div>
<div class="w3-container">
<b>แนบรูปใบเสร็จ</b>
<input type="file"  name="img_upload" id = "img_upload" required>
	<div class="div-a"></div>
</div>
</div>
<br>
	<div class="w3-container">
<div class="w3-container w3-dark-grey"><h5>เงื่อนไขการรับประกัน</h5></div>
<br>

<b> 1. ทางบริษัทฯ ยินดีซ่อมหรือเปลี่ยนอะไหล่ให้โดยไม่คิดมูลค่าใดๆ ในกรณีที่มีความชำรุดของอุปกรณ์ อันเนื่องมาจากความผิดพลาดในการผลิตหรือความบกพร่องของชิ้นส่วน</b><br>
<b> 2. การรับประกันดังกล่าวไม่ครอบคลุมเงื่อนไขดังต่อไปนี้</b><br>
&nbsp;&nbsp;&nbsp;2.1 ไม่มีบัตรรับประกันที่ถูกต้องหรือบัตรรับประกันมีรอยแก้ไขส่วนที่เป็นสาระสำคัญ หรือ ไม่มีการลงทะเบียนรับประกันทางออนไลน์<br>
&nbsp;&nbsp;&nbsp;2.2 สติ๊กเกอร์หมายเลขเครื่องสูญหายหรือถูกแก้ไข<br>
&nbsp;&nbsp;&nbsp;2.3 อุปกรณ์ได้รับการดัดแปลงหรือซ่อมจากบุคคลอื่น<br>
&nbsp;&nbsp;&nbsp;2.4 ความเสียหายของอุปกรณ์เนื่องมาจากอุบัติเหตุ, ความประมาท หรือจากการใช้งานไม่ถูกต้อง<br>
&nbsp;&nbsp;&nbsp;2.5 ความสึกหรอของชิ้นส่วนสิ้นเปลืองจากการใช้งานตามปกติ<br>
<b> 3. สินค้านี้รับประกันนับจากวันที่ซื้อสินค้าเป็นต้นไป</b><br>
<input type='checkbox'  name='accept' id = 'accept' value='1' required> <span class = 'style37'> ยอมรับ เงื่อนไขการรับประกัน </span>


<br><br>

<center>
		  <input type="submit" name ="Submit" value="บันทึกข้อมูลการรับประกัน" class = "button button4" >
</center>
<br>

</div></div></div></div></div>

<?php include('foot.php'); ?>
</form>

</body>
</html>


