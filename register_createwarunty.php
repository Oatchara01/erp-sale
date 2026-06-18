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

<script>
function ListProductBrand(SelectValue) {
    const ddl = document.getElementById("ddlProductBrand");
    ddl.options.length = 0;
    ddl.options[ddl.options.length] = new Option('', '');

    const allProducts = [
        <?php
        $stmt = $conn->prepare("SELECT * FROM tb_prowaranty ORDER BY number_ckk ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "{ id: '{$row['id']}', group: '{$row['group']}', name: '".addslashes($row['product_name'])."', value: '".addslashes($row['product_name'])."', img: '".addslashes($row['img_up'])."' },";
        }
        ?>
    ];

    allProducts.forEach(product => {
        if (product.group == SelectValue) {
            const opt = new Option(product.name, product.id);
            ddl.options[ddl.options.length] = opt;
        }
    });

    // ซ่อน Lot/Serial ตอนยังไม่ได้เลือก
    document.getElementById("lot-serial-container").style.display = "none";
}

function ShowLotOrSerial(productId) {
    const lotContainer = document.getElementById("lot-container");
    const serialContainer = document.getElementById("serial-container");
    const warningMsg = document.getElementById("sn-warning");

    // เงื่อนไขรุ่นที่ใช้ Lot No.
    const lotIds = ['66', '68', '83'];
    document.getElementById("lot-serial-container").style.display = "block";

    if (lotIds.includes(productId)) {
        lotContainer.style.display = "block";
        serialContainer.style.display = "none";
        if (warningMsg) warningMsg.style.display = "none";
        loadLotNumbers(productId);
    } else {
        lotContainer.style.display = "none";
        serialContainer.style.display = "block";

        // ถ้า productId = 85 ให้แสดงข้อความเตือน
        if (productId === '85') {
            warningMsg.style.display = "block";
        } else {
            if (warningMsg) warningMsg.style.display = "none";
        }
    }
}


function loadLotNumbers(productId) {
    fetch("load_lot.php?product_id=" + productId)
        .then(response => response.json())
        .then(data => {
            const lotSelect = document.getElementById("lot_no");
            lotSelect.innerHTML = '<option value="">**Please Select Item**</option>';
            data.forEach(item => {
                const opt = document.createElement("option");
                opt.value = item.lot_no;
                opt.text = item.lot_no;
                lotSelect.add(opt);
            });
        });
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
<!--form  action= "register_waranty1.php"  method="POST" name="frmMain" enctype="multipart/form-data" -->
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
	</center><br>	
<div class="w3-container w3-purple"><h5>ข้อมูลสินค้า</h5></div>
<br>

<div class="w3-container w3-half">
    <b>ประเภทสินค้า</b>
    <select name="product_name" class="w3-input" onchange="ListProductBrand(this.value)" style="width:100%;" required>
        <option value="">**โปรดเลือกรุ่นสินค้า**</option>
        <?php
        $stmt = $conn->prepare("SELECT * FROM tb_growaranty ORDER BY group_ckk ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["id_group"].'">'.$row["group_name"].'</option>';
        }
        ?>
    </select>
</div>
<div class="w3-container w3-half">
    <b>รุ่นสินค้า</b>
    <select id="ddlProductBrand" name="ddlProductBrand" class="w3-input" style="width:100%;" onchange="ShowLotOrSerial(this.value)" required></select>
</div>

<input name="type_warr" id="type_warr" value="1" type='hidden' class="w3-input" style="width:100%;" >		
		
<div id="lot-serial-container" style="display:none;">
    <div id="lot-container" class="w3-container w3-half" style="display:none;">
        <b>Lot. Number</b>
        <select name="lot_no" id="lot_no" class="w3-input" style="width:100%" ></select>
        <input type="button" value="ดูตัวอย่างเลข Lot." class="button99 button4" onclick="this.form.action='lot_waranty.php'; this.form.submit();">
    </div>

    <div id="serial-container" class="w3-container w3-half" style="display:none;">
        <b>Serial number</b>
        <input name="serial_num" id="serial_num" class="w3-input" style="width:100%;" >
        <input type="button" value="ดูตัวอย่าง SN สินค้า" class="button99 button4" onclick="this.form.action='sn_waranty.php'; this.form.submit();">
    </div>
	
</div>
<div class="w3-container w3-half">	
<b>วันที่ติดตั้ง/ซื้อสินค้า</b>
<input name="date_install" id="date_install" value="<?php echo $today; ?>" type="date" class="w3-input" style="width:100%;" required>			<div class="div-a"></div>
		</div>
</div>
<div class="w3-container">
<div id="sn-warning" style="display:none; color:red; margin-top:6px; font-size:14px; font-weight:600;">
        กรุณาเก็บกล่องสินค้าตลอดระยะเวลารับประกัน เพื่อใช้เป็นหลักฐานในการรับประกันสินค้า
    </div> </div>
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
<input type="file"  name="img_upload" id = "img_upload" ><br>
(กรณีซื้อจากร้านอื่นๆที่ไม่ใช่ ALLWELL โดยตรง เช่น โรงพยาบาล ร้านยา ห้างสรรพสินค้า เป็นต้น)	<div class="div-a"></div>
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
