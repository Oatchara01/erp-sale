<?php 
include('head.php');

 ?>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(id_customer_run,customer_code,customer_name,status,payment_term) {
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


}
}
}
}

</script>

<script type="text/javascript">
function frm_order1(){
var ck = document.getElementById('order1');
if(ck.checked == true){
document.getElementById('frm_order1').style.display = "";
}else{
document.getElementById('frm_order1').style.display = "none";
}

}

</script>



<?php /*<script type="text/javascript">
$(document).ready(function(){

$("#id_customer_run").change(function(){
$.ajax({
url: "returnCustomer2.php" ,
type: "POST",
data: 'sCusID=' +$("#id_customer_run").val()
})
.success(function(result) {
var obj = jQuery.parseJSON(result);
if(obj == '')
{
$('input[type=text]').val('');
}
else
{
$.each(obj, function(key, inval) {

$("#id_customer_run").val(inval["customer_id"]);
$("#customer_code").val(inval["customer_code"]);
$("#customer_name").val(inval["cistomer_name"]);
$("#status").val(inval["type_customer"]);
$("#payment_term").val(inval["credit"]);

});
}

});

});
});
</script>*/ ?>


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
<form   method="post" name="frmMain" enctype="multipart/form-data" >
<div class='w3-white'>
<div class="w3-panel w3-light-gray"><h4>EDIT : เอกสารประกอบการออกบิล</h4></div>

<?php
	if($_GET["ref_id"]!=''){
		$strSQL = "SELECT *  FROM tb_document WHERE ref_id = '".$_GET["ref_id"]."' ";
		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	}else if($_GET["id_customer"]!=''){
		$strSQL = "SELECT *  FROM tb_document WHERE id_customer = '".$_GET["id_customer"]."' ";
		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
		
	}
	
	
	    $strSQL1 = "SELECT *  FROM tb_document_all WHERE ref_idd = '".$objResult["ref_id"]."' ";
		$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
		$objResult1 = mysqli_fetch_array($objQuery1);
	
	
	?>


<fieldset><legend ><b><font color="red">ข้อมูลพื้นฐาน</font></b></legend><br>
<div class="w3-container w3-third">

ID ลูกค้า
<input name="id_customer_run" id ='id_customer_run' value = "<?php echo $objResult["id_customer_run"]; ?>" class="w3-input" placeholder="Search ชื่อลูกค้า..." OnChange="JavaScript:doCallAjax('id_customer_run','customer_code','customer_name','status','payment_term');"/>
<input type ='hidden' name="h_id_customer_run"  id="h_id_customer_run" class="w3-input" >
<input type ='hidden' name="ref_id" value="<?php echo $objResult["ref_id"]; ?>" id="ref_id" class="w3-input" >


</div><div class="w3-container w3-third">
รหัสโรงพยาบาล
<input name="customer_code" id="customer_code" value = "<?php echo $objResult["customer_code"]; ?>" class="w3-input" >
<input type='hidden' name="id_customer" id="id_customer" value = "<?php echo $objResult["id_customer"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">
ชื่อโรงพยาบาล
<input name="customer_name"  id = "customer_name" class="w3-input" value = "<?php echo $objResult["customer_name"]; ?>">

</div>



<div class="w3-container w3-third">

ชื่อที่ใช้ในการออกบิล
<input name="bill_name" class="w3-input" value = "<?php echo $objResult["bill_name"]; ?>">

</div><div class="w3-container w3-third">
สถานะ
 	
 <select name="status" id="status" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_typecustomer order by type_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["status"] == $objResuut5["type_id"]){
	$sel = "selected";
} else {
	$sel = "";
}	
	
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['type_id']; ?>" <?php echo $sel;?> ><?php echo $objResuut5['type_name']; ?></option>
<?php } ?>
</select>
	

</div><div class="w3-container w3-third">
วันที่
 
 <select name="date_specify" id="date_specify" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_billdate order by billd_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["date_specify"] == $objResuut5["billd_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}	
	
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['billd_name']; ?>" <?php echo $sel;?> ><?php echo $objResuut5['billd_name']; ?></option>
<?php } ?>
</select>
	
</div>

<div class="w3-container w3-third">
ชำระเงินโดย
 
 <select name="payment_term" id="payment_term" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_credit order by credit_id ";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["payment_term"] == $objResuut5["credit_id"])
{
$sel = "selected";
}
else
{
$sel = "";
}	
	
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['credit_id']; ?>" <?php echo $sel;?> ><?php echo $objResuut5['credit_name']; ?></option>
<?php } ?>
</select>	
	
</div>

<br>
</fieldset>
<br>

<fieldset><legend ><b><font color="red">รายละเอียดเพิ่มเติม</font></b></legend><br>	
	
	<div class="w3-container w3-third">
ช่องรายละเอียดสินค้าเพิ่มเติม 1
 <input name="discription1" class="w3-input" value = "<?php echo $objResult["discription1"]; ?>">

</div><div class="w3-container w3-third">
ช่องรายละเอียดสินค้าเพิ่มเติม 2
<input name="discription2" class="w3-input" value = "<?php echo $objResult["discription2"]; ?>">

</div>


<div class="w3-container w3-third">
ช่องรายละเอียดสินค้าเพิ่มเติม 3
<input name="discription3" class="w3-input" value = "<?php echo $objResult["discription3"]; ?>">
</div><div class="w3-container w3-third">
ช่องรายละเอียดสินค้าเพิ่มเติม 4
 <input name="discription4" class="w3-input" value = "<?php echo $objResult["discription4"]; ?>">

</div><div class="w3-container w3-third">
ช่องรายละเอียดสินค้าเพิ่มเติม 5
 <input name="discription5" class="w3-input" value = "<?php echo $objResult["discription5"]; ?>">

</div>



<div class="w3-container w3-third">
ช่องรายละเอียดสินค้าเพิ่มเติม 6
<input name="discription6" class="w3-input" value = "<?php echo $objResult["discription6"]; ?>">

</div><div class="w3-container w3-third">
ช่องรายละเอียดสินค้าเพิ่มเติม 7
 <input name="discription7" class="w3-input" value = "<?php echo $objResult["discription7"]; ?>">

</div><div class="w3-container w3-third">
ช่องรายละเอียดสินค้าเพิ่มเติม 8
<input name="discription8" class="w3-input" value = "<?php echo $objResult["discription8"]; ?>">

</div>


<div class="w3-container w3-third">
ช่องรายละเอียดสินค้าเพิ่มเติม 9
<input name="discription9" class="w3-input" value = "<?php echo $objResult["discription9"]; ?>">

</div><div class="w3-container w3-third">
ช่องรายละเอียดสินค้าเพิ่มเติม 10
 <input name="discription10" class="w3-input" value = "<?php echo $objResult["discription10"]; ?>">

</div>
	<br>
</fieldset>
<br>

<fieldset><legend ><b><font color="red">ส่วนเพิ่มเติม</font></b></legend><br>		
	
	<div class="w3-container w3-third">
Sales 1
 <input name="sale1" class="w3-input" value = "<?php echo $objResult["sale1"]; ?>">

</div>


<div class="w3-container w3-third">
Sales 2
<input name="sale2" class="w3-input" value = "<?php echo $objResult["sale2"]; ?>">

</div><div class="w3-container w3-third">
หมายเหตุ ของโรงพยาบาล
<input name="customer_note" class="w3-input" value = "<?php echo $objResult["customer_note"]; ?>">

</div><div class="w3-container w3-third">
คำสั่ง Print
<input name="command_print" class="w3-input" value = "<?php echo $objResult["command_print"]; ?>">

</div>


<div class="w3-container w3-third">
ประทับตรา
	
 <select name="stamp" id="stamp" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_stick order by stick_it ";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["stamp"] == $objResuut5["stick_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}	
	
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['stick_name']; ?>" <?php echo $sel;?> ><?php echo $objResuut5['stick_name']; ?></option>
<?php } ?>
</select>			
	

</div><div class="w3-container w3-third">
หมายเหตุ ประทับตรา
 <input name="stamp_note" class="w3-input" value = "<?php echo $objResult["stamp_note"]; ?>">

</div><div class="w3-container w3-third">
จำนวนสำเนาใบกำกับภาษีเพิ่ม (ใบ)
<input name="count_tax" class="w3-input" value = "<?php echo $objResult["count_tax"]; ?>">
 
</div>



<div class="w3-container w3-third">
หมายเหตุจำนวนสำเนาใบกำกับภาษีเพิ่ม
<input name="description_tax" class="w3-input" value = "<?php echo $objResult["description_tax"]; ?>">

</div><div class="w3-container w3-third">
ให้ใบเสร็จลูกค้า
 	
 <select name="bill" id="bill" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_yesno order by yes_id ";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["bill"] == $objResuut5["yes_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}	
	
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['yes_name']; ?>" <?php echo $sel;?> ><?php echo $objResuut5['yes_name']; ?></option>
<?php } ?>
</select>		

</div><div class="w3-container w3-third">
หมายเหตุ ให้ใบเสร็จลูกค้า
 <input name="description_bill" class="w3-input" value = "<?php echo $objResult["description_bill"]; ?>">

</div>

	<br>
</fieldset>
<br>

<fieldset><legend ><b><font color="red">เอกสารแนบ</font></b></legend><br>	

<div class="w3-container w3-third">
เอกสารแนบเพิ่ม 1
<input name="attachment1" class="w3-input" value = "<?php echo $objResult["attachment1"]; ?>">

</div><div class="w3-container w3-third">
เอกสารแนบเพิ่ม 2
 <input name="attachment2" class="w3-input" value = "<?php echo $objResult["attachment2"]; ?>">

</div><div class="w3-container w3-third">
เอกสารแนบเพิ่ม 3
 <input name="attachment3" class="w3-input"  value = "<?php echo $objResult["attachment3"]; ?>">

</div>



<div class="w3-container w3-third">
เอกสารแนบเพิ่ม 4
<input name="attachment4" class="w3-input" value = "<?php echo $objResult["attachment4"]; ?>">

</div><div class="w3-container w3-third">
เอกสารแนบเพิ่ม 5
<input name="attachment5" class="w3-input" value = "<?php echo $objResult["attachment5"]; ?>">

</div>
	<div class="w3-container w3-third">
	<input type='hidden' name='img_11' id='img_11' value ="<?php echo $objResult['img_1']; ?>"  />

<input name="img_1"  type="file"><a href="upload/<?php echo $objResult['img_1']; ?>" target="_blank"><?php echo $objResult['img_1']; ?></a>
</div>
	<br>
</fieldset>

<br>

	
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_document1.php'; submit()">
</center>

<br>
</div>


<?php include('foot.php'); ?>


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



