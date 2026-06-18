<?php 
include('head.php');

 ?>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_id,product_code,product_name,) {
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
var url = 'data_product_add1.php';
var pmeters = "product_id=" + encodeURI( document.getElementById(product_id).value);
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

document.getElementById(product_code).value = myArr[0];
document.getElementById(product_name).value = myArr[1];


}
}
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
<form   method="POST" name="frmMain"  enctype="multipart/form-data" action='add_leaflet1.php' >
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>ADD : ใบตรวจทาน</h4></div>

<div class="w3-half">

<div class="w3-container ">
ID รหัสสินค้า
<input name="product_id" id ='product_id'  class="w3-input" placeholder="Search ชื่อสินค้า.." OnChange="JavaScript:doCallAjax('product_id','product_code','product_name');" required>
<input type ='hidden' name="h_product_id"  id="h_product_id" class="w3-input" >
</div>
	
<div class="w3-container ">
ชื่อสินค้า
<input name="product_name"  id = "product_name"  class="w3-input" >

</div>	
	
<div class="w3-container ">
ส่วนประกอบ 01
 <input name="ingredient1"   class="w3-input" >

</div>

<div class="w3-container ">
ส่วนประกอบ 02
 <input name="ingredient2"   class="w3-input" >

</div><div class="w3-container ">
 ส่วนประกอบ 03
 <input name="ingredient3"   class="w3-input" >

</div><div class="w3-container ">
 ส่วนประกอบ 04
<input name="ingredient4" class="w3-input" >

</div>

<div class="w3-container w3-fourth">
ส่วนประกอบ 05
<input name="ingredient5"   class="w3-input" >
</div><div class="w3-container">
ส่วนประกอบ 06
 <input name="ingredient6" class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 07
 <input name="ingredient7"  class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 08
<input name="ingredient8"  class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 09
 <input name="ingredient9"  class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 10
<input name="ingredient10"   class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 11
<input name="ingredient11"   class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 12

 <input name="ingredient12"   class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 13
 <input name="ingredient13"   class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 14
<input name="ingredient14"   class="w3-input" >

</div><div class="w3-container">
 ส่วนประกอบ 15
<input name="ingredient15"   class="w3-input" >

</div><div class="w3-container">
 ส่วนประกอบ 16
<input name="ingredient16"   class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 17
<input  name="ingredient17"  class="w3-input" >

</div><div class="w3-container">
 ส่วนประกอบ 18
 <input name="ingredient18"  class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 19
<input name="ingredient19"  class="w3-input" >
 
</div>

<div class="w3-container">
ส่วนประกอบ 20
<input name="ingredient20"  class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 21
 <input name="ingredient21"  class="w3-input" >

</div><div class="w3-container">
 ส่วนประกอบ 22
 <input name="ingredient22"  class="w3-input" >

</div>

<div class="w3-container">
 ส่วนประกอบ 23
<input name="ingredient23"  class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 24
 <input name="ingredient24"  class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 25
 <input name="ingredient25"  class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 26
<input name="ingredient26"  class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 27
<input name="ingredient27"  class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 28
<input name="ingredient28"  class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 29
<input name="ingredient29"  class="w3-input" >

</div>
	</div>
	
<div class="w3-half">	
	
	<div class="w3-container ">
รหัสสินค้า
<input name="product_code"  id="product_code"  class="w3-input" >
<input type="hidden" name="leaflet_id"  id="leaflet_id"  class="w3-input" >

</div>

<div class="w3-container ">
หมายเลขเครื่อง
<input name="product_sn"   class="w3-input" >

</div>
<div class="w3-container ">	
	Upload รูปภาพ 1

<input name="img1" class="w3-input" type="file">

	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 2

<input name="img2" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 3

<input name="img3" class="w3-input" type="file">
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 4

<input name="img4" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 5

<input name="img5" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 6

<input name="img6" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 7

<input name="img7" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 8

<input name="img8" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 9

<input name="img9" class="w3-input" type="file">
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 10

<input name="img10" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 11

<input name="img11" class="w3-input" type="file">
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 12

<input name="img12" class="w3-input" type="file">
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 13

<input name="img13" class="w3-input" type="file">
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 14

<input name="img14" class="w3-input" type="file">
	
	</div>
	<div class="w3-container ">	
	Upload รูปภาพ 15

<input name="img15" class="w3-input" type="file">
	</div>
	<div class="w3-container ">	
	Upload รูปภาพ 16

<input name="img16" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 17

<input name="img17" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 18

<input name="img18" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 19

<input name="img19" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 20

<input name="img20" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 21

<input name="img21" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 22

<input name="img22" class="w3-input" type="file">
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 23

<input name="img23" class="w3-input" type="file">
	
	</div>
	<div class="w3-container ">	
	Upload รูปภาพ 24

<input name="img24" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 25

<input name="img25" class="w3-input" type="file">
	
	</div>
	<div class="w3-container ">	
	Upload รูปภาพ 26

<input name="img26" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 27

<input name="img27" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 28

<input name="img28" class="w3-input" type="file">
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 29

<input name="img29" class="w3-input" type="file">
	
	</div>
		
	</div>


<br>
<center>
		  <input type="Submit" name ="Submit" value="บันทึก" class = "button button4" >
</center>

<br>
	
	</div>
		
	</div>


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
		return "data_product_lesflet.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_id","h_product_id");
        </script>



