<?php 
include('head.php');

 ?>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(id_customer_run,customer_code,customer_name,status,payment_term,bill_name) {
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
var url = 'data_customer_add1.php';
var pmeters = "id_customer_run=" + encodeURI( document.getElementById(id_customer_run).value);
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

document.getElementById(customer_code).value = myArr[0];
document.getElementById(customer_name).value = myArr[1];
document.getElementById(status).value = myArr[2];
document.getElementById(payment_term).value = myArr[3];
document.getElementById(bill_name).value = myArr[4];
	
}
}
}
}

</script>






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
<form   method="POST" name="frmMain" action='add_document1.php'  enctype="multipart/form-data" >
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>ADD : เอกสารประกอบการออกบิล</h4></div>

<fieldset><legend ><b><font color="red">ข้อมูลพื้นฐาน</font></b></legend><br>

<div class="w3-container w3-third">

ID ลูกค้า
<input name="id_customer_run" id ='id_customer_run' class="w3-input" placeholder="Search ชื่อลูกค้า..." OnChange="JavaScript:doCallAjax('id_customer_run','customer_code','customer_name','status','payment_term','bill_name');"/>
<input type ='hidden' name="h_id_customer_run"  id="h_id_customer_run" class="w3-input" >


</div><div class="w3-container w3-third">
รหัสโรงพยาบาล
<input name="customer_code" id="customer_code" class="w3-input" >
</div><div class="w3-container w3-third">
ชื่อโรงพยาบาล
<input name="customer_name"  id = "customer_name" class="w3-input" >

</div><div class="w3-container w3-third">

ชื่อที่ใช้ในการออกบิล
<input name="bill_name" id="bill_name" class="w3-input" >

</div><div class="w3-container w3-third">
สถานะ
 <select name="status" id="status" class="w3-input"   required>
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_typecustomer order by type_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['type_id']; ?>"><?php echo $objResuut5['type_name']; ?></option>
<?php } ?>
</select>


</div><div class="w3-container w3-third">
วันที่

 <select name="date_specify" id="date_specify" class="w3-input"   required>
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_billdate order by billd_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['billd_name']; ?>"><?php echo $objResuut5['billd_name']; ?></option>
<?php } ?>
</select>	
	

</div><div class="w3-container w3-third">
ชำระเงินโดย

<select name="payment_term" id="payment_term" class="w3-input"   required >
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
	
	
</div>
	<br>
</fieldset>
<br>

	
<fieldset><legend ><b><font color="red">ข้อมูลการวางบิล</font></b></legend><br>	
<div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> ส่งของพร้อมวางบิล		
</div><div class="w3-container w3-third">
ไฟล์แนบปฏิทิน-รับเช็ค รพ.
<input name="img_1" class="w3-input" type="file" >
</div><div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> ขั้นตอนการวางบิล		
</div>	
	
<br>
</fieldset>
<br>
<fieldset><legend ><b><font color="red">เอกสารที่ต้องใช้วางบิล</font></b></legend><br>		

<div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> ใบวางบิล		
</div><div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> ใบเสร็จรับเงิน		
</div><div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> ใบกำกับภาษี/ใบส่งสินค้า	
	
<select name="invoice_no" id="invoice_no" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_invoice order by id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['id']; ?>"><?php echo $objResuut5['invoice_name']; ?></option>
<?php } ?>
</select>	
	
</div><div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> ใบ PO		
</div><div class="w3-container w3-third">
สถานที่วางบิล
<input name="" id="" class="w3-input" >
</div><div class="w3-container w3-third">
วัน / เวลา วางบิล
<input name="" id="" class="w3-input" >
</div><div class="w3-container w3-third">
เบอร์โทรศัพท์
<input name="" id="" class="w3-input" >
</div>	
	
<br>
</fieldset>
<br>
<fieldset><legend ><b><font color="red">เอกสารที่ต้องใช้รับเช็ค</font></b></legend><br>	
	
<div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> ใบเสร็จรับเงิน		
</div><div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> มอบอำนาจ	
	
<select name="authorize" id="authorize" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_authorize order by id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['id']; ?>"><?php echo $objResuut5['authorize']; ?></option>
<?php } ?>
</select>		
	
</div><div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> ค่าสวัสดิการ	
	
<select name="welfare" id="welfare" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_welfare order by id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['id']; ?>"><?php echo $objResuut5['welfare']; ?></option>
<?php } ?>
</select>		
	
</div><div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> การชำระเงิน	
	
<select name="payment_name" id="payment_name" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_payment where ckk ='1' order by payment_ID ASC";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"><?php echo $objResuut5['payment_name']; ?></option>
<?php } ?>
</select>		
	
</div><div class="w3-container w3-third">
สถานที่รับเช็ค
<input name="" id="" class="w3-input" >
</div><div class="w3-container w3-third">
วัน / เวลา รับเช็ค
<input name="" id="" class="w3-input" >
</div>				
	
	
<br>
</fieldset>
<br>
<fieldset><legend ><b><font color="red">เอกสารที่ต้องใช้รับภาษีหัก ณ ที่จ่าย</font></b></legend><br>	
	
<div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> ใบเสร็จรับเงิน		
</div><div class="w3-container w3-third">
<input type ="checkbox" name ="" id ="" value = '1'> จดหมาย	
	
<select name="note" id="note" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_note order by id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['id']; ?>"><?php echo $objResuut5['note']; ?></option>
<?php } ?>
</select>		
	
</div><div class="w3-container w3-third">
สถานที่รับภาษีหัก ณ ที่จ่าย
<input name="" id="" class="w3-input" >
</div><div class="w3-container w3-third">
วัน / เวลา รับภาษีหัก ณ ที่จ่าย
<input name="" id="" class="w3-input" >
</div>		
	
<br>
</fieldset>
<br>	

<br>


<center>
		  <input type="submit" name ="Submit" value="บันทึก" class = "button button4" >
</center>

</p>



  <br></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>


</form>

</body>
</html>

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
		return "data_customer_add.php?customer_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("id_customer_run","h_id_customer_run");
        </script>



