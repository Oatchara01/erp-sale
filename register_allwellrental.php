<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

<script language="JavaScript">

function selectByValueOrText(selectEl, raw) {
  const norm = s => (s ?? '').toString().trim();
  const target = norm(raw);
  if (!selectEl) return;

  // ลองเทียบกับ value ตรง ๆ
  for (const opt of selectEl.options) {
    if (norm(opt.value) === target) {
      selectEl.value = opt.value;
      return;
    }
  }
  // ไม่เจอ: ลองเทียบกับ text
  for (const opt of selectEl.options) {
    if (norm(opt.text) === target) {
      selectEl.value = opt.value;
      return;
    }
  }
  // เผื่อบางเคส: เพิ่ม option ชั่วคราวแล้วเลือกให้
  const o = new Option(target, target, true, true);
  selectEl.add(o);
}	
	
	
	
var HttPRequest = false;
function doCallAjax1(rental_id,rental_name,rental_tel,emergency_name,emergency_tel,rental_address,install_address,bill_name,bill_address,bill_tel,tax_no,connect_name,connect_tel,patient_name,install_address,address_1,address_name,address_send,customer_name,customer_tel,province_name) {
HttPRequest = false;
if (window.XMLHttpRequest) { // Mozilla, Safari,...
HttPRequest = new XMLHttpRequest();

if (HttPRequest.overrideMimeType) {
HttPRequest.overrideMimeType('text/html');
}
} else if (window.ActiveXObject) { // IE
try {
HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
} catch (e) {}
}
}

if (!HttPRequest) {

alert('Cannot create XMLHTTP instance');
return false;
}
var url = 'data_rental_name.php';
var pmeters = "rental_id=" + encodeURI( document.getElementById(rental_id).value);
HttPRequest.open('POST',url,true);

HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
HttPRequest.setRequestHeader("Content-length", pmeters.length);
HttPRequest.setRequestHeader("Connection", "close");
HttPRequest.send(pmeters);

HttPRequest.onreadystatechange = function()
{
if(HttPRequest.readyState == 4) // Return Request
{
var myProduct = HttPRequest.responseText;

if(myProduct != "")
{

var myArr = myProduct.split("|");

document.getElementById(rental_id).value = myArr[0];
document.getElementById(rental_name).value = myArr[1];
document.getElementById(rental_tel).value = myArr[2];
document.getElementById(emergency_name).value = myArr[3];
document.getElementById(emergency_tel).value = myArr[4];
document.getElementById(rental_address).value = myArr[5];
document.getElementById(install_address).value = myArr[6];
document.getElementById(bill_name).value = myArr[7];
document.getElementById(bill_address).value = myArr[8];
document.getElementById(bill_tel).value = myArr[9];
document.getElementById(tax_no).value = myArr[10];
document.getElementById(connect_name).value = myArr[11];
document.getElementById(connect_tel).value = myArr[12];
document.getElementById(patient_name).value = myArr[13];
document.getElementById(install_address).value = myArr[14];
document.getElementById(address_1).value = myArr[14];
document.getElementById(address_name).value = myArr[14];
document.getElementById(address_send).value = myArr[14];
document.getElementById(customer_name).value = myArr[11];
document.getElementById(customer_tel).value = myArr[12];
selectByValueOrText(document.getElementById(province_name), myArr[15]);
	

}
}
}
}

    
</script>



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
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__rental";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "RT";

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
	<form action='register_allwellrental1.php' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	
		
	document.frmMain.submit();
}


</script>
<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>ใบสั่งเช่า (Rental Order)</h4></div>

<div class="w3-bar">
		
<input type="radio" checked='checked' name="type_doc" value = "3">&nbsp;AWL 
<!--input type="radio" checked='checked' name="type_doc" value = "4">&nbsp;NBM-->

<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $ffirst['ref_id']+1; ?>" ><br>
	
<input type="radio"  name="type_product" id="type_product" value = "1" required>&nbsp;สินค้าเตียง  	&nbsp;
<input type="radio"  name="type_product" id="type_product" value = "2" required>&nbsp;สินค้าที่นอน  	&nbsp;
<input type="radio"  name="type_product" id="type_product" value = "3" required>&nbsp;สินค้าอื่นๆ  	&nbsp;
	
	</div>

</p>

<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>
	
<fieldset><legend ><b><font color="red">ข้อมูลผู้เช่า</font></b></legend></p>	
	
<div class="w3-half 1">
วันที่ : 
<input type="date" name = "register_date" id="register_date" style="width:90%;"  value="<?php echo $today; ?>" class = "w3-input"> 	
ชื่อลูกค้า :
<input type='text' name = "rental_name"  id = "rental_name" style="width:90%;" class="w3-input" >	
ที่อยู่
<textarea name="rental_address" id="rental_address" class="w3-input" rows="2" style="width:90%"></textarea>

		
</div>
		
<div class="w3-half 1">
รหัสลูกค้า  : 
<input type='text' name = "rental_id"  id = "rental_id" class="w3-input" placeholder="Search ชื่อผู้เช่า..."  style="width:90%;" OnChange="JavaScript:doCallAjax1('rental_id','rental_name','rental_tel','emergency_name','emergency_tel','rental_address','install_address','bill_name','bill_address','bill_tel','tax_no','connect_name','connect_tel','patient_name','install_address','address_1','address_name','address_send','customer_name','customer_tel','province_name');"/> 

<input type='hidden' name = "h_rental_id"  id = "h_rental_id"  class="button4" readonly>
เบอร์โทรศัพท์ :
<input type='text' name = "rental_tel"  id = "rental_tel" style="width:90%;" class="w3-input" >
						
</div>
	</p></fieldset></p>

<fieldset><legend ><b><font color="red">ข้อมูลออกบิล</font></b></legend></p>	
	
<div class="w3-half 1">
ชื่อที่ต้องการออกบิล :
<input type='text' name = "bill_name"  id = "bill_name" style="width:90%;" class="w3-input" >
ที่อยู่ต้องการออกบิล
<textarea name="bill_address" id="bill_address" class="w3-input" rows="2" style="width:90%"></textarea>

			
</div>
		
<div class="w3-half 1">

เบอร์โทร :
<input type='text' name = "bill_tel"  id = "bill_tel" style="width:90%;" class="w3-input" >
<input type='checkbox' name = "bill_vat"  id = "bill_vat" value="1" > ต้องการใบกำกับภาษีเต็มรูปแบบ
Tex ID :
<input type='text' name = "tax_no"  id = "tax_no" style="width:90%;" class="w3-input" >
	
</div>
	</p></fieldset></p><br>


<fieldset><legend ><b><font color="red">ข้อมูลการติดต่อ & การติดตั้ง</font></b></legend></p>	
	
<div class="w3-half 1">
ชื่อผู้ติดต่อ :
<input type='text' name = "connect_name"  id = "connect_name" style="width:90%;" class="w3-input" >	
บุคคลที่สามารถติดต่อได้กรณีฉุกเฉิน :
<input type='text' name = "emergency_name"  id = "emergency_name" style="width:90%;" class="w3-input" >	
วันที่ติดตั้ง : 
<input type="date" name = "install_date" id="install_date" style="width:90%;"   class = "w3-input"> 
ผู้ป่วย :
<input type='text' name = "patient_name"  id = "patient_name" style="width:90%;" class="w3-input" >	
			
</div>
		
<div class="w3-half 1">

โทรผู้ติดต่อ :
<input type='text' name = "connect_tel"  id = "connect_tel" style="width:90%;" class="w3-input" >
เบอร์ฉุกเฉิน :
<input type='text' name = "emergency_tel"  id = "emergency_tel" style="width:90%;" class="w3-input" >
สถานที่ติดตั้ง
<textarea name="install_address" id="install_address" class="w3-input" rows="2" style="width:90%"></textarea>					
</div>
	</p></fieldset></p><br>


<fieldset><legend ><b><font color="red">ข้อมูลเอกสารสัญญา</font></b></legend></p>	
	
<div class="w3-half 1">
วันที่เริ่มต้นสัญญา : 
<input type="date" name = "start_promis" id="start_promis" style="width:90%;"   class = "w3-input"> 
	
การชำระเงิน :

<select name="payment" class="w3-input" style="width:90%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_credit order by credit_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['credit_id']; ?>"><?php echo $objResuut5['credit_name']; ?></option>
<?php } ?>
</select>
	
เขตการขาย :

<select name="sale_code" id="sale_code"  class="w3-input" style="width:90%" required>
<option value="">**Please Select Item**</option>
<?php
$strSQL4 = "select * from tb_team_allwell order by allwell_id";
$objQuery4 = mysqli_query($com,$strSQL4);
if (!$objQuery4) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut4 = mysqli_fetch_array($objQuery4,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut4['sale_code']; ?>"><?php echo $objResuut4['sale_code']; ?></option>
<?php } ?>
</select>
	
	
</div>
		
<div class="w3-half 1">
ระยะเวลาในการเช่า/เดือน : 
<input type="text" name = "count_m" id="count_m" style="width:90%;" value ='2'  class = "w3-input" > 
หมายเหตุเพิ่มเติม
<textarea name="des_sale" id="des_sale" class="w3-input" rows="2" style="width:90%"></textarea>		




</div>
	</p></fieldset></p><br>


<fieldset><legend ><b><font color="red">ข้อมูลการคืนเงินลูกค้า</font></b></legend></p>	
	
<div class="w3-half 1">
ธนาคาร : 
<input type="text" name = "bank_name" id="bank_name" style="width:90%;"  class = "w3-input" required> 
เลขที่บัญชี
<input type="text" name = "bank_no" id="bank_no" style="width:90%;"  class = "w3-input" required> 	
</div>
	
<div class="w3-half 1">
ชื่อบัญชี
<input type="text" name = "accbank_name" id="accbank_name" style="width:90%;"  class = "w3-input" required> 	
แนบไฟล์รูป Book Bank
<input name="bank_img" class = "w3-input" style="width:30%;" type="file" required>
</div>

	</p></fieldset></p><br>
<div class="w3-bar w3-light-grey w3-border">
<a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>

</div>
<div id="pd" class="w3-container city1" >

<?php include ('product_rentalawl.php');		 ?>
</div>

<div id="cs" class="w3-container city1" style="display:none">

<input type="radio" name="delivery_type" value="1" checked='checked' onclick="javascript:ckk_2();" id="object8">&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  onclick="javascript:ckk_2();" id="object9">&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  onclick="javascript:ckk_2();" id="object10">&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  onclick="javascript:ckk_2();" id="object11">&nbsp;บริษัทจัดส่ง <br />

</p>

	<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไปสมุดลงงาน CS 
<br>


 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date"   class="button4" style="width:20%" /></p>


วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="button4" type='text' id="between_date" style="width:20%" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เวลา :&nbsp;&nbsp;&nbsp;&nbsp;
<input id="start_time"  name="start_time"  class="button4" type="text" style="width:10%" >
ถึง
<input id="end_time" name="end_time"  class="button4" type="text" style="width:10%"/></p>



สถานะการทำงาน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
สถานะ :&nbsp;&nbsp;
<input name="status_comment" type='text' id="status_comment"  style="width:22%" class="button4"/></p>


<input type="checkbox" name="mk_research" value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span>&nbsp;&nbsp;

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;
<input type="checkbox"  id = "on_time" name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;


<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
		
&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว&nbsp;&nbsp;
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;
<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่</p>
		
	 
<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <input name="unit_cash" type='text' class="button4" id="unit_cash" size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค : &nbsp;
	<input name="unit_check" type='text' class="button4"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/></p>
		

<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="unit_credit" type='text' class="button4"  id="unit_credit"  size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล : &nbsp;
<input name="unit_bill" type='text' class="button4" style="color:black;text-align:right" id="unit_bill"  size="20" OnChange="JavaScript:chkNum(this)" /></p>



<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน :
		 <input name="unit_tran" type='text' class="button4" id="unit_tran" size="20" style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ : &nbsp;&nbsp;&nbsp;
<input name="dept" type='text' class="button4"  id="dept"  size="20"  /></p>

แผนก - ฝ่าย :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="department_show" value="<?php echo "ฝ่ายขาย"; ?>" class="button4" type='text' id="department_show" readonly>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทลูกค้า :
<input name="department_show" value="<?php echo "ลูกค้าทั่วไป"; ?>" class="button4" type='text' id="department_show" readonly>
</p>

ประเภทงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   <input name="department_name" value="<?php echo "Online"; ?>"  class="button4" type='text' id="department_name" readonly>

</p>



ชื่อพนักงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="employee_name"  class="button4" type='text' value="<?php echo $_SESSION['name']; ?>" id="employee_name"  readonly>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรพนักงาน :&nbsp;
<input name="employee_tel"  class="button4" type='text' id="employee_tel" >
<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='hidden' class="button4" >
</p>
จังหวัด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
<select name="province_name" id ="province_name" class="button4" style="width:30%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_province order by province_ID ";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['province_name']; ?>"><?php echo $objResuut5['province_name']; ?></option>
<?php } ?>
</select>

</p>
สถานที่ส่งสินค้า :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       
<input type='text'  class="button4" name="address_1" id="address_1" style="width:30%" >             
</p>
ที่อยู่ในการส่งสินค้า :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name" id="address_name" style="width:30%" >  
</p>

  สถานที่ติดตั้งเครื่อง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<textarea   class="button4" name="address_send" id="address_send" style="width:30%" rows="2" ></textarea>
</p>
ชื่อผู้ติดต่อ  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name"  class="button4" type='text' id="customer_name" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="button4" type='text' id="customer_tel" >
</p>
เลขที่เอกสาร/เลขที่เครื่อง : </p>
<textarea name="product_sn"  class="button4" id="product_sn" style="width:50%" rows="2"></textarea>
</p>
สินค้า/เอกสาร :</p>
<textarea name="product"  class="button4" id="product" style="width:50%" rows="2"></textarea>


</p>
รายละเอียดเพิ่มเติม :</p> 
     <textarea name="description"  class="button4" id="description" style="width:50%" rows="2"><?php echo "รับเอกสารสำเนาบัตรประชาชน และสำเนาทะเบียนบ้านลูกค้าแนบมากับหนังสือสัญญา เอกสารส่งที่บัญชีนะคะ"; ?></textarea>


<fieldset><legend><input type="checkbox" name="more" id="more" value="1"> <b>รายละเอียดการจัดส่ง</b></legend>
	<div id="more-2" style="display:none;">
		<div class="w3-third 112">
			<div class="w3-bar 1">
				<input type="checkbox" name="runway"id = "runway" value="1"> ติดถนนรันเวย์
			</div>
			<div class="w3-bar 2">
				<input type="checkbox" name="road"id = "road" value="1"> ติดถนนวิ่งสวนกัน
			</div>
			<div class="w3-bar 3">
				<input type="checkbox" name="soy"id = "soy" value="1"> เข้าซอย
			</div>
			<div class="w3-bar 4">
				ทางเข้ากว้าง
				<input name="soy_big" class="w3-input" type='text' id="soy_big" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 5">
				<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง
			</div>
			<div class="w3-bar 6">
				<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได้
			</div>
			<div class="w3-bar 7">
				<input type="checkbox" name="no_car_road"id = "no_car_road" value="1"> รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				การจอดรถ
			</div>
			<div class="w3-bar 9">
				<input type="checkbox" name="car_road" id = "car_road" value="1"> จอดรถข้างถนน
			</div>
			<div class="w3-bar 10">
				<input type="checkbox" name="car_home"id = "car_home" value="1"> จอดรถหน้าบ้านได้
			</div>
			<div class="w3-bar 11">
				ประตูหน้าบ้านสูง
				<input name="door_long" class="w3-input" type='text' id="door_long" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 12">
				<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
			</div>
			<div class="w3-bar 13">
				<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน
			</div>
			<div class="w3-bar 14">
				<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" style="width:90%;" placeholder="จำนวน (ขั้น)" />
			</div>
			<div class="w3-bar 15">
				ประตูบ้านกว้าง
				<input name="door_bigger" class="w3-input" type='text' id="door_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 16">
				ประตูสูง 
				<input name="door_longer" class="w3-input" type='text' id="door_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 17">
				ประตูห้องกว้าง 
				<input name="room_bigger" class="w3-input" type='text' id="room_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 18">
				ประตูห้องสูง 
				<input name="room_longer" class="w3-input" type='text' id="room_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
		</div>
		<div class="w3-third 212">
			<div class="w3-bar 1">
				ประตูบ้านเป็นแบบ
				<input name="type_door" class="w3-input" type='text' id="type_door" style="width:90%;" />
			</div>
			<div class="w3-bar 2">
				พื้นบ้านเป็นแบบ
				<input name="home_type" class="w3-input" type='text' id="home_type" style="width:90%;" />
			</div>
			<div class="w3-bar 3">
				ติดตั้งที่ชั้น
				<input name="install" class="w3-input" type='text' id="install" style="width:90%;" />
			</div>
			<div class="w3-bar 4">
				<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง
			</div>
			<div class="w3-bar 5">
				<input name="bundai_big" class="w3-input" type='text' id="bundai_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 6">
				หักมุมบันได
				<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" style="width:90%;" />
			</div>
			<div class="w3-bar 7">
				ชนิดของบันได
				<input name="type_bundai" class="w3-input" type='text' id="type_bundai" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง
			</div>
			<div class="w3-bar 9">
				<input name="lip_big" class="w3-input" type='text' id="lip_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 10">
				สูง
				<input name="lip_long" class="w3-input" type='text' id="lip_long" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 11">
				รับน้ำหนักได้ 
				<input name="lip_weight" class="w3-input" type='text' id="lip_weight" style="width:90%;" />
			</div>
			
		</div>
		<div class="w3-third 312">
			<div class="w3-bar 12">
				<input type="checkbox" name="up"id ="up" value="1"> ขึ้นลิฟท์ได้
			</div>
			<div class="w3-bar 13">
				<input type="checkbox" name="no_up"id ="no_up" value="1"> ขึ้นลิฟท์ไม่ได้
			</div>
			<div class="w3-bar 14">
				<input type="checkbox" name="head_bad"id ="head_bad" value="1"> ต้องถอดหัวเตียง-ท้ายเตียง
			</div>
			<div class="w3-bar 15">
				<input type="checkbox" name="want_employee"id ="want_employee" value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
			</div>
			<div class="w3-bar 16">
				จำนวนคนที่ใช้ 
				<input name="employee_unit" class="w3-input" type='text' id="employee_unit" style="width:90%;" />
			</div>
			<div class="w3-bar 17">
				ย้ายเฟอร์นิเจอร์ 
				<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" style="width:90%;" />
			</div>
			<div class="w3-bar 18">
				ย้ายไปที่ 
				<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" style="width:90%;" />
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_ex"id = "want_ex" value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_credit"id = "want_credit" value="1"> ต้องเตรียมเครื่องรูดบัตร
			</div>
			<div class="w3-bar">
				ธนาคาร 
				<input name="bank" class="w3-input" type='text' id="bank" style="width:90%;" />
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
			</div>
			<div class="w3-bar">
				รายละเอียดเพิ่มเติม
				<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"></textarea>
			</div>
		</div>
	</div>
	</fieldset>

</div>


<br>
<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</form>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>

  <!--/div-->

  

<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_rentel_name.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("rental_id","h_rental_id");
</script> 

<script>
$('#more').click(function() {
  if($(this).is(":checked")){
   $("#more-2").show();
  }
  else{
   $("#more-2").hide();
  }
});
</script>
