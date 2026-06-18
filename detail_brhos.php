<html>
<head>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


</head>

<script type="text/javascript">
function ck_frm(){
var ck = document.getElementById('ckk');
if(ck.checked == true){
document.getElementById('frm_txt').style.display = "";
}else{
document.getElementById('frm_txt').style.display = "none";
}

}


function ck_frm1(){
var ck = document.getElementById('ckk1');
if(ck.checked == true){
document.getElementById('frm_txt1').style.display = "";
}else{
document.getElementById('frm_txt1').style.display = "none";
}

}

function ck_frm2(){
var ck = document.getElementById('ckk2');
if(ck.checked == true){
document.getElementById('frm_txt2').style.display = "";
}else{
document.getElementById('frm_txt2').style.display = "none";
}

}

function ck_frm3(){
var ck = document.getElementById('ckk3');
if(ck.checked == true){
document.getElementById('frm_txt3').style.display = "";
}else{
document.getElementById('frm_txt3').style.display = "none";
}

}

function ck_frm4(){
var ck = document.getElementById('ckk4');
if(ck.checked == true){
document.getElementById('frm_txt4').style.display = "";
}else{
document.getElementById('frm_txt4').style.display = "none";
}

}




</script>


<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_code,product_id,product_name,unit_name,product_price,warranty) {
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
var url = 'data_product_hos1.php';
var pmeters = "product_code=" + encodeURI( document.getElementById(product_code).value);
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

document.getElementById(product_id).value = myArr[0];
document.getElementById(product_name).value = myArr[1];
document.getElementById(unit_name).value = myArr[2];
document.getElementById(product_price).value = myArr[3];
document.getElementById(warranty).value = myArr[5];

}
}
}
}


function chkNumber(ele)

{

var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
ele.onKeyPress=vchar;
}


</script>

<script src="dist/jautocalc.js"></script></head>

<body>
<table width="100%" border="0" class="w3-table">
<thead>

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
    <th>ยอดรวม</th>
	<th>รับประกัน</th>
	<th>ระยะเวลายืม</th>
	<th>หมายเหตุ</th>
</thead>
<tbody>
<tr>
<td style="width:10%;">
<input type='text' name = "product_codet1"  id = "product_codet1" class="button4" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet1','product_id1','product_name1','unit_name1','product_price1','warranty1');"/> 
<input type='hidden' name = "h_product_codet1"  id = "h_product_codet1"  class="button4" readonly>

<input type='text' name = "product_code1"  id = "product_code1" class="button4" placeholder="Search ชื่ออังกฤษ..."  size="10" OnChange="JavaScript:doCallAjax('product_code1','product_id1','product_name1','unit_name1','product_price1','warranty1');"/> 
<input type='hidden' name = "h_product_code1"  id = "h_product_code1"  class="button4" readonly>
	
<input type='text' name = "product_c1"  id = "product_c1" class="button4" placeholder="Search ชื่อไทย..."  size="10" OnChange="JavaScript:doCallAjax('product_c1','product_id1','product_name1','unit_name1','product_price1','warranty1');"/> 
<input type='hidden' name = "h_product_c1"  id = "h_product_c1"  class="button4" readonly>	
<input type='hidden' name = "product_id1"  id = "product_id1" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name1"  id = "product_name1"  rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1"  id = "unit_name1"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count1" id = "sale_count1"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<input type='text' name = "product_price1"  id = "product_price1"  class="button4" size="10" style="color:black;text-align:right" />
</td >

<td style="width:10%;"><input type='text' name = "sum_amount1"  id = "sum_amount1"  class="button4" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count1} * {product_price1}'readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "warranty1"  id = "warranty1"  class="w3-input" />
</td>	
	
	<td style="width:5%;">
<input type='text' name = "br_period1" id = "br_period1" placeholder="จำนวนวัน" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="button4" style="color:black;text-align:center" size="10"  />
</td>
<td style="width:20%;">
<textarea name = "sale_remarkk1"  id = "sale_remarkk1"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code1').value = '';
document.getElementById('product_codet1').value  = ''; 

document.getElementById('product_name1').value  = ''; 
document.getElementById('unit_name1').value  = '';
document.getElementById('product_price1').value  = '';
document.getElementById('sale_count1').value  = '';

document.getElementById('sum_amount1').value  = '';
document.getElementById('product_id1').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet2"  id = "product_codet2" class="button4" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet2','product_id2','product_name2','unit_name2','product_price2','warranty2');"/> 
<input type='hidden' name = "h_product_codet2"  id = "h_product_codet2"  class="button4" readonly>

<input type='text' name = "product_code2"  id = "product_code2" class="button4" placeholder="Search ชื่ออังกฤษ..."  size="10" OnChange="JavaScript:doCallAjax('product_code2','product_id2','product_name2','unit_name2','product_price2','warranty2');"/> 
<input type='hidden' name = "h_product_code2"  id = "h_product_code2"  class="button4" readonly>
	
<input type='text' name = "product_c2"  id = "product_c2" class="button4" placeholder="Search ชื่อไทย..."  size="10" OnChange="JavaScript:doCallAjax('product_c2','product_id2','product_name2','unit_name2','product_price2','warranty2');"/> 
<input type='hidden' name = "h_product_c2"  id = "h_product_c2"  class="button4" readonly>	
<input type='hidden' name = "product_id2"  id = "product_id2" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name2"  id = "product_name2"  rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name2"  id = "unit_name2"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count2" id = "sale_count2"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<input type='text' name = "product_price2"  id = "product_price2"  class="button4" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount2"  id = "sum_amount2"  class="button4" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count2} * {product_price2}'readonly/>
</td>

<td style="width:5%;">
<input type='text' name = "warranty2"  id = "warranty2"  class="w3-input" />
</td>	
	
<td style="width:5%;">
<input type='text' name = "br_period2" id = "br_period2" placeholder="จำนวนวัน" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="button4" style="color:black;text-align:center" size="10"  />
</td>
<td style="width:20%;">
<textarea name = "sale_remarkk2"  id = "sale_remarkk2"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code2').value = '';
document.getElementById('product_name2').value  = ''; 
document.getElementById('unit_name2').value  = '';
document.getElementById('product_price2').value  = '';
document.getElementById('sale_count2').value  = '';
document.getElementById('product_codet2').value  = ''; 

document.getElementById('sum_amount2').value  = '';
document.getElementById('product_id2').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>



</tr>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet3"  id = "product_codet3" class="button4" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet3','product_id3','product_name3','unit_name3','product_price3','warranty3');"/> 
<input type='hidden' name = "h_product_codet3"  id = "h_product_codet3"  class="button4" readonly>

<input type='text' name = "product_code3"  id = "product_code3" class="button4" placeholder="Search ชื่ออังกฤษ..."  size="10" OnChange="JavaScript:doCallAjax('product_code3','product_id3','product_name3','unit_name3','product_price3','warranty3');"/> 
<input type='hidden' name = "h_product_code3"  id = "h_product_code3"  class="button4" readonly>
	
<input type='text' name = "product_c3"  id = "product_c3" class="button4" placeholder="Search ชื่อไทย..."  size="10" OnChange="JavaScript:doCallAjax('product_c3','product_id3','product_name3','unit_name3','product_price3','warranty3');"/> 
<input type='hidden' name = "h_product_c3"  id = "h_product_c3"  class="button4" readonly>	
<input type='hidden' name = "product_id3"  id = "product_id3" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name3"  id = "product_name3"  rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name3"  id = "unit_name3"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count3" id = "sale_count3"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<input type='text' name = "product_price3"  id = "product_price3"  class="button4" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount3"  id = "sum_amount3"  class="button4" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count3} * {product_price3}'readonly/>
</td>

<td style="width:5%;">
<input type='text' name = "warranty3"  id = "warranty3"  class="w3-input" />
</td>	
	
	
<td style="width:5%;">
<input type='text' name = "br_period3" id = "br_period3" placeholder="จำนวนวัน" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="button4" style="color:black;text-align:center" size="10"  />
</td>
<td style="width:20%;">
<textarea name = "sale_remarkk3"  id = "sale_remarkk3"  class="w3-input" ></textarea>
</td>


<td><a onclick="document.getElementById('product_code3').value = '';
document.getElementById('product_name3').value  = ''; 
document.getElementById('unit_name3').value  = '';
document.getElementById('product_price3').value  = '';
document.getElementById('sale_count3').value  = '';
document.getElementById('product_codet3').value  = ''; 

document.getElementById('sum_amount3').value  = '';
document.getElementById('product_id3').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet4"  id = "product_codet4" class="button4" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet4','product_id4','product_name4','unit_name4','product_price4','warranty4');"/> 
<input type='hidden' name = "h_product_codet4"  id = "h_product_codet4"  class="button4" readonly>

<input type='text' name = "product_code4"  id = "product_code4" class="button4" placeholder="Search ชื่อสินค้า..."  size="10" OnChange="JavaScript:doCallAjax('product_code4','product_id4','product_name4','unit_name4','product_price4','warranty4');"/> 
<input type='hidden' name = "h_product_code4"  id = "h_product_code4"  class="button4" readonly>
	
<input type='text' name = "product_c4"  id = "product_c4" class="button4" placeholder="Search ชื่อสินค้า..."  size="10" OnChange="JavaScript:doCallAjax('product_c4','product_id4','product_name4','unit_name4','product_price4','warranty4');"/> 
<input type='hidden' name = "h_product_c4"  id = "h_product_c4"  class="button4" readonly>	
<input type='hidden' name = "product_id4"  id = "product_id4" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name4"  id = "product_name4"  rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name4"  id = "unit_name4"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count4" id = "sale_count4"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<input type='text' name = "product_price4"  id = "product_price4"  class="button4" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount4"  id = "sum_amount4"  class="button4" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count4} * {product_price4}'readonly/>
</td>

<td style="width:5%;">
<input type='text' name = "warranty4"  id = "warranty4"  class="w3-input" />
</td>	
	
	
<td style="width:5%;">
<input type='text' name = "br_period4" id = "br_period4" placeholder="จำนวนวัน" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="button4" style="color:black;text-align:center" size="10"  />
</td>
<td style="width:20%;">
<textarea name = "sale_remarkk4"  id = "sale_remarkk4"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code4').value = '';
document.getElementById('product_name4').value  = ''; 
document.getElementById('unit_name4').value  = '';
document.getElementById('product_price4').value  = '';
document.getElementById('sale_count4').value  = '';
document.getElementById('product_codet4').value  = ''; 

document.getElementById('sum_amount4').value  = '';
document.getElementById('product_id4').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet5"  id = "product_codet5" class="button4" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet5','product_id5','product_name5','unit_name5','product_price5','warranty5');"/> 
<input type='hidden' name = "h_product_codet5"  id = "h_product_codet5"  class="button4" readonly>

<input type='text' name = "product_code5"  id = "product_code5" class="button4" placeholder="Search ชื่ออังกฤษ..."  size="10" OnChange="JavaScript:doCallAjax('product_code5','product_id5','product_name5','unit_name5','product_price5','warranty5');"/> 
<input type='hidden' name = "h_product_code5"  id = "h_product_code5"  class="button4" readonly>

<input type='text' name = "product_c5"  id = "product_c5" class="button4" placeholder="Search ชื่อไทย..."  size="10" OnChange="JavaScript:doCallAjax('product_c5','product_id5','product_name5','unit_name5','product_price5','warranty5');"/> 
<input type='hidden' name = "h_product_c5"  id = "h_product_c5"  class="button4" readonly>	
<input type='hidden' name = "product_id5"  id = "product_id5" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name5"  id = "product_name5"  rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name5"  id = "unit_name5"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count5" id = "sale_count5"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<input type='text' name = "product_price5"  id = "product_price5"  class="button4" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount5"  id = "sum_amount5"  class="button4" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count5} * {product_price5}'readonly/>
</td>

<td style="width:5%;">
<input type='text' name = "warranty5"  id = "warranty5"  class="w3-input" />
</td>	
	
	
<td style="width:5%;">
<input type='text' name = "br_period5" id = "br_period5" placeholder="จำนวนวัน" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="button4" style="color:black;text-align:center" size="10"  />
</td>
<td style="width:20%;">
<textarea name = "sale_remarkk5"  id = "sale_remarkk5"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code5').value = '';
document.getElementById('product_name5').value  = ''; 
document.getElementById('unit_name5').value  = '';
document.getElementById('product_price5').value  = '';
document.getElementById('sale_count5').value  = '';
document.getElementById('product_codet5').value  = ''; 

document.getElementById('sum_amount5').value  = '';
document.getElementById('product_id5').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>
</tbody>
</table>

 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk" id="ckk" onClick="ck_frm();" value="1"/>เพิ่มเติม<br/>
<div id="frm_txt" style="display:none;">


<table width="100%" border="0" class="w3-table">
<thead>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet6"  id = "product_codet6" class="button4" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet6','product_id6','product_name6','unit_name6','product_price6','warranty6');"/> 
<input type='hidden' name = "h_product_codet6"  id = "h_product_codet6"  class="button4" readonly>

<input type='text' name = "product_code6"  id = "product_code6" class="button4" placeholder="Search ชื่อสินค้า..."  size="10" OnChange="JavaScript:doCallAjax('product_code6','product_id6','product_name6','unit_name6','product_price6','warranty6');"/> 
<input type='hidden' name = "h_product_code6"  id = "h_product_code6"  class="button4" readonly>
	
<input type='text' name = "product_c6"  id = "product_c6" class="button4" placeholder="Search ชื่อสินค้า..."  size="10" OnChange="JavaScript:doCallAjax('product_c6','product_id6','product_name6','unit_name6','product_price6','warranty6');"/> 
<input type='hidden' name = "h_product_c6"  id = "h_product_c6"  class="button4" readonly>	
<input type='hidden' name = "product_id6"  id = "product_id6" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name6"  id = "product_name6"  rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name6"  id = "unit_name6"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count6" id = "sale_count6"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<input type='text' name = "product_price6"  id = "product_price6"  class="button4" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount6"  id = "sum_amount6"  class="button4" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count6} * {product_price6}'readonly/>
</td>

<td style="width:5%;">
<input type='text' name = "warranty6"  id = "warranty6"  class="w3-input" />
</td>	
	
	
<td style="width:5%;">
<input type='text' name = "br_period6" id = "br_period6" placeholder="จำนวนวัน" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="button4" style="color:black;text-align:center" size="10"  />
</td>
<td style="width:20%;">
<textarea name = "sale_remarkk6"  id = "sale_remarkk6"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code6').value = '';

document.getElementById('product_name6').value  = ''; 
document.getElementById('unit_name6').value  = '';
document.getElementById('product_price6').value  = '';
document.getElementById('sale_count6').value  = '';
document.getElementById('product_codet6').value  = ''; 

document.getElementById('sum_amount6').value  = '';
document.getElementById('product_id6').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet7"  id = "product_codet7" class="button4" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet7','product_id7','product_name7','unit_name7','product_price7','warranty7');"/> 
<input type='hidden' name = "h_product_codet7"  id = "h_product_codet7"  class="button4" readonly>

<input type='text' name = "product_code7"  id = "product_code7" class="button4" placeholder="Search ชื่อสินค้า..."  size="10" OnChange="JavaScript:doCallAjax('product_code7','product_id7','product_name7','unit_name7','product_price7','warranty7');"/> 
<input type='hidden' name = "h_product_code7"  id = "h_product_code7"  class="button4" readonly>
	
<input type='text' name = "product_c7"  id = "product_c7" class="button4" placeholder="Search ชื่อสินค้า..."  size="10" OnChange="JavaScript:doCallAjax('product_c7','product_id7','product_name7','unit_name7','product_price7','warranty7');"/> 
<input type='hidden' name = "h_product_c7"  id = "h_product_c7"  class="button4" readonly>	
<input type='hidden' name = "product_id7"  id = "product_id7" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name7"  id = "product_name7"  rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name7"  id = "unit_name7"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count7" id = "sale_count7"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<input type='text' name = "product_price7"  id = "product_price7"  class="button4" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount7"  id = "sum_amount7"  class="button4" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count7} * {product_price7}'readonly/>
</td>

<td style="width:5%;">
<input type='text' name = "warranty7"  id = "warranty7"  class="w3-input" />
</td>	
	
<td style="width:5%;">
<input type='text' name = "br_period7" id = "br_period7" placeholder="จำนวนวัน" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="button4" style="color:black;text-align:center" size="10"  />
</td>
<td style="width:20%;">
<textarea name = "sale_remarkk7"  id = "sale_remarkk7"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code7').value = '';
document.getElementById('product_name7').value  = ''; 
document.getElementById('unit_name7').value  = '';
document.getElementById('product_price7').value  = '';
document.getElementById('sale_count7').value  = '';
document.getElementById('product_codet7').value  = ''; 

document.getElementById('sum_amount7').value  = '';
document.getElementById('product_id7').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>



</tr>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet8"  id = "product_codet8" class="button4" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet8','product_id8','product_name8','unit_name8','product_price8','warranty8');"/> 
<input type='hidden' name = "h_product_codet8"  id = "h_product_codet8"  class="button4" readonly>

<input type='text' name = "product_code8"  id = "product_code8" class="button4" placeholder="Search ชื่อสินค้า..."  size="10" OnChange="JavaScript:doCallAjax('product_code8','product_id8','product_name8','unit_name8','product_price8','warranty8');"/> 
<input type='hidden' name = "h_product_code8"  id = "h_product_code8"  class="button4" readonly>
	
<input type='text' name = "product_c8"  id = "product_c8" class="button4" placeholder="Search ชื่อสินค้า..."  size="10" OnChange="JavaScript:doCallAjax('product_c8','product_id8','product_name8','unit_name8','product_price8','warranty8');"/> 
<input type='hidden' name = "h_product_c8"  id = "h_product_c8"  class="button4" readonly>	
<input type='hidden' name = "product_id8"  id = "product_id8" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name8"  id = "product_name8"  rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name8"  id = "unit_name8"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count8" id = "sale_count8"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<input type='text' name = "product_price8"  id = "product_price8"  class="button4" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount8"  id = "sum_amount8"  class="button4" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count8} * {product_price8}'readonly/>
</td>

<td style="width:5%;">
<input type='text' name = "warranty8"  id = "warranty8"  class="w3-input" />
</td>	
	
	
<td style="width:5%;">
<input type='text' name = "br_period8" id = "br_period8" placeholder="จำนวนวัน" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="button4" style="color:black;text-align:center" size="10"  />
</td>
<td style="width:20%;">
<textarea name = "sale_remarkk8"  id = "sale_remarkk8"  class="w3-input" ></textarea>
</td>


<td><a onclick="document.getElementById('product_code8').value = '';
document.getElementById('product_name8').value  = ''; 
document.getElementById('unit_name8').value  = '';
document.getElementById('product_price8').value  = '';
document.getElementById('sale_count8').value  = '';
document.getElementById('product_codet8').value  = ''; 

document.getElementById('sum_amount8').value  = '';
document.getElementById('product_id8').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

</table>


</div>

</body>
</html>
<script>
$('form').jAutoCalc({
  attribute: 'jAutoCalc',
  thousandOpts: [',', '.', ' '],
  decimalOpts: ['.', ','],
  decimalPlaces: -1,
  initFire: true,
  chainFire: true,
  keyEventsFire: false,
  readOnlyResults: true,
  showParseError: true,
  emptyAsZero: false,
  smartIntegers: false,
  onShowResult: null,
  funcs: {},
  vars: {}
});
</script>

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
		return "data_product_hos.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code1","h_product_code1");
        </script>



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
		return "data_product_hos.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code2","h_product_code2");
        </script>


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
		return "data_product_hos.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code3","h_product_code3");
        </script>



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
		return "data_product_hos.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code4","h_product_code4");
        </script>


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
		return "data_product_hos.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code5","h_product_code5");
        </script>


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
		return "data_product_hos.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code6","h_product_code6");
        </script>


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
		return "data_product_hos.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code7","h_product_code7");
        </script>


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
		return "data_product_hos.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code8","h_product_code8");
        </script>



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
		return "data_product_hosi.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet1","h_product_codet1");
        </script>


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
		return "data_product_hosi.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet2","h_product_codet2");
        </script>


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
		return "data_product_hosi.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet3","h_product_codet3");
        </script>


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
		return "data_product_hosi.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet4","h_product_codet4");
        </script>


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
		return "data_product_hosi.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet5","h_product_codet5");
        </script>


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
		return "data_product_hosi.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet6","h_product_codet6");
        </script>


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
		return "data_product_hosi.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet7","h_product_codet7");
        </script>


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
		return "data_product_hosi.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet8","h_product_codet8");
        </script>





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
		return "data_product_hosth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c1","h_product_c1");
        </script>



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
		return "data_product_hosth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c2","h_product_c2");
        </script>


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
		return "data_product_hosth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c3","h_product_c3");
        </script>



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
		return "data_product_hosth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c4","h_product_c4");
        </script>


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
		return "data_product_hosth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c5","h_product_c5");
        </script>


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
		return "data_product_hosth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c6","h_product_c6");
        </script>


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
		return "data_product_hosth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c7","h_product_c7");
        </script>


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
		return "data_product_hosth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c8","h_product_c8");
        </script>



