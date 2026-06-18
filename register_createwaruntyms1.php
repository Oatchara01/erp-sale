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
$id = $_POST["id"];
$sn = $_POST["sn"];

$strSQL = "SELECT * FROM tb_prowaranty WHERE id = '".$id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);	

$strSQL1 = "SELECT group_name FROM tb_growaranty WHERE id_group = '".$objResult["group"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery1);	

?>

<body>
<!--form  action="register_waranty1.php"  method="POST" name="frmMain" enctype="multipart/form-data"  -->
<form action="register_waranty1.php"
      method="POST"
      name="frmMain"
      enctype="multipart/form-data"
      onsubmit="return preventDoubleSubmit();">	
	
	
	<div class="w3-container">
		<center><br><br>
<img src="img/allwell_logo.png" width="240" align="center" height="70" /><br><br>
	
<h2><b><font color='#652076'>ลงทะเบียนรับประกันสินค้าออนไลน์</font></b></h2>
<h4>Allwell Online Warranty</h4>	
<font color='red'><h6>กรุณาลงทะเบียนภายใน 14 วันหลังจากได้รับสินค้า</h6></font>
<h6><a href="https://sol.allwellcenter.com/search_sncus.php" target="_blank" class="w3-button w3-green" style="border-radius:12px;">ตรวจสอบข้อมูลรับประกันสินค้าออนไลน์ Allwell<br><span style="font-size:12px;color:#FFFF00;font-weight:600;">
  **หากต้องการตรวจสอบข้อมูลที่เคยลงทะเบียนรับประกันแล้ว**
</span></a></h6>		
	
			
			<?php if($id=='35'){ ?>
			<h5>** รับประกันสินค้า 3 ปี นับจากวันที่ซื้อ กรณีลูกค้าลงทะเบียนรับประกันผ่านเว็บไซต์บริษัทฯ เพิ่มระยะเวลารับประกันเป็น 5 ปี **</h5>	
			<?php } ?>
	</center><br><br>

<div class="w3-container w3-purple"><h5>ข้อมูลสินค้า</h5></div>
<br>
<div class="w3-container w3-half">
<b>ประเภทสินค้า</b> 

<input  class="w3-input" style="width:100%;" value="<?php echo $objResult1["group_name"]; ?>" readonly>	
<input name="product_name" id="product_name"  type='hidden' value="<?php echo $objResult["group"]; ?>" class="w3-input" style="width:100%;" required>	
<input name="type_warr" id="type_warr" value="2" type='hidden' class="w3-input" style="width:100%;" >	
<div class="div-a"></div>
</div><div class="w3-container w3-half">		
<b>รุ่นสินค้า</b>
<textarea name="ddlProductBrand"  class="w3-input" id="ddlProductBrand" cols="54" rows="2" readonly><?php echo $objResult["product_name"]; ?></textarea> 


<div class="div-a"></div>
	</div>
		
<?php if($id=='66'){ 	
$product_idpp = "5398";		
}else if($id=='68'){  
$product_idpp = "5620";		
}else if($id=='83'){  
$product_idpp = "5277";			
	
 } ?>		
		
<?php if($id=='66' or $id=='68' or $id=='83'){ ?>
<div class="w3-container w3-half">	
<b>Lot. Number</b>

<select name="lot_no" id="lot_no" class="w3-input" style="width:100%" required>
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from st__lotno where product_id ='".$product_idpp."' order by id";
$objQuery5 = mysqli_query($new,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['lot_no']; ?>"><?php echo $objResuut5['lot_no']; ?></option>
<?php } ?>
</select>	
<input type="button" name ="Submit" value="ดูตัวอย่างเลข Lot." class = "button99 button4"  onClick="this.form.action='lot_waranty.php'; submit()" target="_blank">
	<div class="div-a"></div>
	</div>				
<?php }else{ ?>		
<div class="w3-container w3-half">	
<b>Serial number</b>
<input name="serial_num" id="serial_num" class="w3-input"  value="<?php echo $sn; ?>" style="width:100%;" required>		
	
<input type="button" name ="Submit" value="ดูตัวอย่าง SN สินค้า" class = "button99 button4"  onClick="this.form.action='sn_waranty.php'; submit()" target="_blank">
	<div class="div-a"></div>
	</div>		
<?php } ?>		
<div class="w3-container w3-half">	
<b>วันที่ติดตั้ง/ซื้อสินค้า</b>
<input name="date_install" id="date_install" value="<?php echo $today; ?>" type="date" class="w3-input" style="width:100%;" required>			<div class="div-a"></div>
		</div>
		
<?php if($id=='85'){ ?>		
<div class="w3-container">
<div id="sn-warning" style="color:red; margin-top:6px; font-size:14px; font-weight:600;">
        กรุณาเก็บกล่องสินค้าตลอดระยะเวลารับประกัน เพื่อใช้เป็นหลักฐานในการรับประกันสินค้า
    </div> </div>		
<?php } ?>	
<?php if($id=='66'){ ?>
	
<div class="w3-container w3-half">	
<b>ชื่อร้านค้า/ช่องทางที่ซื้อ (โปรดระบุชื่อร้าน)</b>
<input name="sale_channel" id="sale_channel" class="w3-input"  value="<?php echo $sn; ?>" style="width:100%;" required>		
	<div class="div-a"></div>
	</div>	
<div class="w3-container w3-half">	
<b>แนบภาพใบเสร็จ หรือภาพคำสั่งซื้อ	</b>
<input type="file" name="img_upload" id="img_upload" onchange="previewFile(event)" class="w3-input" required>
<font color='grey'> ภาพต้องเห็นรายการสินค้า และ วันที่ซื้อสินค้าที่ตรงกับวันที่ระบุในแบบฟอร์ม</font>
<div id="previewContainer" style="display: none;">
        <img id="imagePreview" src="" alt="Image Preview" style="max-width: 300px; display: none;">
        <video id="videoPreview" controls style="max-width: 300px; display: none;"></video>
        <embed id="pdfPreview" type="application/pdf" style="max-width: 300px; display: none;">
    </div>			
<div class="div-a"></div>
	</div>		
<?php } ?>	
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
<input
          name="tel_cus"
          id="tel_cus"
          class="w3-input"
          type="tel"
          inputmode="tel"
          autocomplete="tel"
          required
          placeholder="เช่น 0812345678"
          pattern="0\d{8,9}"
          maxlength="10"
          title="กรอกเบอร์มือถือไทย 10 หลัก เริ่มต้นด้วย 0"
        >
<div class="div-a"></div>
</div>
<div class="w3-container">
<b> อีเมลล์</b>
<input name="email" id = "email" class="w3-input" style="width:100%;" required>
	<div class="div-a"></div>
</div>
	
<div class="w3-container">
<b>แนบรูปใบเสร็จ</b>
<input type="file"  name="img_upload" id = "img_upload" >
<br>(กรณีซื้อจากร้านอื่นๆที่ไม่ใช่ ALLWELL โดยตรง เช่น โรงพยาบาล ร้านยา ห้างสรรพสินค้า เป็นต้น)	
	<div class="div-a"></div>
</div>
	
</div>
<br>
	<div class="w3-container">
<div class="w3-container w3-dark-grey"><h5>เงื่อนไขการรับประกัน</h5></div>
<br>

<?php if($id=='35' or $id=='53'){ ?>		
<b> 1. ทางบริษัทฯ รับประกันเฉพาะตัวเครื่องนับจากวันที่ซื้อในระยะเวลารับประกัน ทางบริษัทฯ ยินดีซ่อมหรือเปลี่ยนอะไหล่ให้โดยไม่คิดมูลค่าใด ๆ ในกรณีที่มีความชำรุดของอุปกรณ์อันเนื่องมาจากความผิดพลาดในการผลิตหรือความบกพร่องของชิ้นส่วน</b><br>
	
<?php }else{ ?>
<b> 1. ทางบริษัทฯ ยินดีซ่อมหรือเปลี่ยนอะไหล่ให้โดยไม่คิดมูลค่าใดๆ ในกรณีที่มีความชำรุดของอุปกรณ์ อันเนื่องมาจากความผิดพลาดในการผลิตหรือความบกพร่องของชิ้นส่วน</b><br>
		<?php } ?>
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
		  <!--input type="submit" name ="Submit" value="บันทึกข้อมูลการรับประกัน" class = "button button4" -->
	<input type="submit" id="btnSubmit" name="Submit"
         value="บันทึกข้อมูลการรับประกัน"
         class="button button4">
</center>
<br>

</div></div></div></div></div>

<?php include('foot.php'); ?>
</form>

</body>
</html>

<script>
        function previewFile(event) {
            var file = event.target.files[0];
            var previewContainer = document.getElementById('previewContainer');
            var imagePreview = document.getElementById('imagePreview');
            var videoPreview = document.getElementById('videoPreview');
            var pdfPreview = document.getElementById('pdfPreview');
            
            previewContainer.style.display = 'block';
            imagePreview.style.display = 'none';
            videoPreview.style.display = 'none';
            pdfPreview.style.display = 'none';

            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var fileType = file.type;
                    
                    if (fileType.startsWith('image/')) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    } else if (fileType.startsWith('video/')) {
                        videoPreview.src = e.target.result;
                        videoPreview.style.display = 'block';
                    } else if (fileType === 'application/pdf') {
                        pdfPreview.src = e.target.result;
                        pdfPreview.style.display = 'block';
                    }
                }
                reader.readAsDataURL(file);
            }
        }
		
</script>

<script>
let submitted = false;

function preventDoubleSubmit() {
  if (submitted) return false; // กัน submit ซ้ำ
  submitted = true;

  const btn = document.getElementById('btnSubmit');
  if (btn) {
    btn.disabled = true;
    btn.value = 'กำลังบันทึก...';
    btn.style.opacity = '0.7';
    btn.style.cursor = 'not-allowed';
  }
  return true;
}
</script>

