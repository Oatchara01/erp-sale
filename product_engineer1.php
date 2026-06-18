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
function doCallAjax(product_code,product_id,product_name,unit_name,product_price,discount_unit,warranty) {
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
document.getElementById(discount_unit).value = myArr[4];
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


 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk" id="ckk" onClick="ck_frm();" value="1"/>เพิ่มเติม<br/>
<div id="frm_txt" style="display:none;">


<table width="100%" border="0" class="w3-table">
<thead>

<tr>
<td  style="width:10%;">

<input type='text' name = "product_codet6"  id = "product_codet6" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet6','product_id6','product_name6','unit_name6','product_price6','discount_unit6','warranty6');"/> 
<input type='hidden' name = "h_product_codet6"  id = "h_product_codet6"  class="button4" readonly>

<input type='text' name = "product_code6"  id = "product_code6"  class="w3-input" placeholder="Search ชื่ออังกฤษ..." OnChange="JavaScript:doCallAjax('product_code6','product_id6','product_name6','unit_name6','product_price6','discount_unit6','warranty6');"/> 
<input type='hidden' name = "h_product_code6"  id = "h_product_code6"  class="w3-input" readonly>
	
<input type='text' name = "product_c6"  id = "product_c6"  class="w3-input" placeholder="Search ชื่อไทย..." OnChange="JavaScript:doCallAjax('product_c6','product_id6','product_name6','unit_name6','product_price6','discount_unit6','warranty6');"/> 
<input type='hidden' name = "h_product_c6"  id = "h_product_c6"  class="w3-input" readonly>	
<input type='hidden' name = "product_id6"  id = "product_id6" class="w3-input" />

</td>
<td style="width:15%;">
<textarea  name = "product_name6"  id = "product_name6"  class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name6"  id = "unit_name6"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count6"  id = "sale_count6"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price6"  id = "product_price6"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td style="width:8%;"><input type='text' name = "discount_unit6"  id = "discount_unit6" class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' name = "sum_amount6"  id = "sum_amount6"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count6} * {product_price6} - {discount_unit6} * {sale_count6}'readonly/>
</td>

<td style="width:5%;"><input type='text' name = "warranty6"  id = "warranty6"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal6"  id = "cal6"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "pm6"  id = "pm6"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>


<td style="width:10%;">
<textarea  name = "sale_remarkk6"  id = "sale_remarkk6"  class="w3-input" ></textarea>
</td>
<td style="width:10%;" >
	<input type='checkbox' name = "clear_br6"  id = "clear_br6" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno6"  id = "clear_ivno6"  class="w3-input"   >
	</td>
<td style="width:2%;"><a onclick="document.getElementById('product_code6').value = '';
document.getElementById('product_name6').value  = ''; 
document.getElementById('unit_name6').value  = '';
document.getElementById('product_price6').value  = '';
document.getElementById('sale_count6').value  = '';

document.getElementById('sum_amount6').value  = '';
document.getElementById('discount_unit6').value  = '';
document.getElementById('product_id6').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td style="width:10%;">

<input type='text' name = "product_codet7"  id = "product_codet7" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet7','product_id7','product_name7','unit_name7','product_price7','discount_unit7','warranty7');"/> 
<input type='hidden' name = "h_product_codet7"  id = "h_product_codet7"  class="button4" readonly>

<input type='text' name = "product_code7"  id = "product_code7" class="w3-input" placeholder="Search ชื่ออังกฤษ..."  OnChange="JavaScript:doCallAjax('product_code7','product_id7','product_name7','unit_name7','product_price7','discount_unit7','warranty7');"/> 
<input type='hidden' name = "h_product_code7"  id = "h_product_code7"  class="w3-input" readonly>
	
<input type='text' name = "product_c7"  id = "product_c7" class="w3-input" placeholder="Search ชื่อไทย..."  OnChange="JavaScript:doCallAjax('product_c7','product_id7','product_name7','unit_name7','product_price7','discount_unit7','warranty7');"/> 
<input type='hidden' name = "h_product_c7"  id = "h_product_c7"  class="w3-input" readonly>	
<input type='hidden' name = "product_id7"  id = "product_id7" class="w3-input" />

</td>
<td style="width:15%;">
<textarea name = "product_name7"  id = "product_name7"  class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name7"  id = "unit_name7"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count7"  id = "sale_count7"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price7"  id = "product_price7"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td style="width:8%;"><input type='text' name = "discount_unit7"  id = "discount_unit7"  class="w3-input"  style="color:black;text-align:right" /></td>

<td style="width:8%;"><input type='text' name = "sum_amount7"  id = "sum_amount7"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count7} * {product_price7} - {discount_unit7} * {sale_count7}'readonly/>
</td>


<td style="width:5%;"><input type='text' name = "warranty7"  id = "warranty7"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal7"  id = "cal7"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "pm7"  id = "pm7"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>


<td style="width:10%;">
<textarea name = "sale_remarkk7"  id = "sale_remarkk7"  class="w3-input" ></textarea>
</td>
<td style="width:10%;" >
	<input type='checkbox' name = "clear_br7"  id = "clear_br7" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno7"  id = "clear_ivno7"  class="w3-input"   >
	</td>
<td style="width:2%;"><a onclick="document.getElementById('product_code7').value = '';
document.getElementById('product_name7').value  = ''; 
document.getElementById('unit_name7').value  = '';
document.getElementById('product_price7').value  = '';
document.getElementById('sale_count7').value  = '';

document.getElementById('sum_amount7').value  = '';
document.getElementById('discount_unit7').value  = '';
document.getElementById('product_id7').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td >

<input type='text' name = "product_codet8"  id = "product_codet8" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet8','product_id8','product_name8','unit_name8','product_price8','discount_unit8','warranty8');"/> 
<input type='hidden' name = "h_product_codet8"  id = "h_product_codet8"  class="button4" readonly>

<input type='text' name = "product_code8"  id = "product_code8" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax('product_code8','product_id8','product_name8','unit_name8','product_price8','discount_unit8','warranty8');"/> 
<input type='hidden' name = "h_product_code8"  id = "h_product_code8"  class="w3-input" readonly>
	
<input type='text' name = "product_c8"  id = "product_c8" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax('product_c8','product_id8','product_name8','unit_name8','product_price8','discount_unit8','warranty8');"/> 
<input type='hidden' name = "h_product_c8"  id = "h_product_c8"  class="w3-input" readonly>	
<input type='hidden' name = "product_id8"  id = "product_id8" class="w3-input" />

</td>
<td>
<textarea name = "product_name8"  id = "product_name8"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name8"  id = "unit_name8"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count8"  id = "sale_count8"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price8"  id = "product_price8"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit8"  id = "discount_unit8" class="w3-input" style="color:black;text-align:right" /></td>

<td><input type='text' name = "sum_amount8"  id = "sum_amount8"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count8} * {product_price8} - {discount_unit8} * {sale_count8}'readonly/>
</td>

<td><input type='text' name = "warranty8"  id = "warranty8"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal8"  id = "cal8"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm8"  id = "pm8"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>


<td>
<textarea  name = "sale_remarkk8"  id = "sale_remarkk8"  class="w3-input" ></textarea>
</td>
<td style="width:10%;" >
	<input type='checkbox' name = "clear_br8"  id = "clear_br8" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno8"  id = "clear_ivno8"  class="w3-input"   >
	</td>
<td><a onclick="document.getElementById('product_code8').value = '';
document.getElementById('product_name8').value  = ''; 
document.getElementById('unit_name8').value  = '';
document.getElementById('product_price8').value  = '';
document.getElementById('sale_count8').value  = '';

document.getElementById('sum_amount8').value  = '';
document.getElementById('discount_unit8').value  = '';
document.getElementById('product_id8').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td >
<input type='text' name = "product_codet9"  id = "product_codet9" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet9','product_id9','product_name9','unit_name9','product_price9','discount_unit9','warranty9');"/> 
<input type='hidden' name = "h_product_codet9"  id = "h_product_codet9"  class="button4" readonly>

<input type='text' name = "product_code9"  id = "product_code9" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax('product_code9','product_id9','product_name9','unit_name9','product_price9','discount_unit9','warranty9');"/> 
<input type='hidden' name = "h_product_code9"  id = "h_product_code9"  class="w3-input" readonly>
	
<input type='text' name = "product_c9"  id = "product_c9" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax('product_c9','product_id9','product_name9','unit_name9','product_price9','discount_unit9','warranty9');"/> 
<input type='hidden' name = "h_product_c9"  id = "h_product_c9"  class="w3-input" readonly>	
<input type='hidden' name = "product_id9"  id = "product_id9" class="w3-input" />

</td>
<td>
<textarea  name = "product_name9"  id = "product_name9"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name9"  id = "unit_name9"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count9"  id = "sale_count9"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price9"  id = "product_price9"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit9"  id = "discount_unit9"  class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount9"  id = "sum_amount9"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count9} * {product_price9} - {discount_unit9} * {sale_count9}'readonly/>
</td>

<td><input type='text' name = "warranty9"  id = "warranty9"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal9"  id = "cal9"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm9"  id = "pm9"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>


<td>
<textarea  name = "sale_remarkk9"  id = "sale_remarkk9"  class="w3-input" ></textarea>
</td>
<td style="width:10%;" >
	<input type='checkbox' name = "clear_br9"  id = "clear_br9" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno9"  id = "clear_ivno9"  class="w3-input"   >
	</td>
<td><a onclick="document.getElementById('product_code9').value = '';
document.getElementById('product_name9').value  = ''; 
document.getElementById('unit_name9').value  = '';
document.getElementById('product_price9').value  = '';
document.getElementById('sale_count9').value  = '';

document.getElementById('sum_amount9').value  = '';
document.getElementById('discount_unit9').value  = '';
document.getElementById('product_id9').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td >
<input type='text' name = "product_codet10"  id = "product_codet10" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet10','product_id10','product_name10','unit_name10','product_price10','discount_unit10','warranty10');"/> 
<input type='hidden' name = "h_product_codet10"  id = "h_product_codet10"  class="button4" readonly>

<input type='text' name = "product_code10"  id = "product_code10" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax('product_code10','product_id10','product_name10','unit_name10','product_price10','discount_unit10','warranty10');"/> 
<input type='hidden' name = "h_product_code10"  id = "h_product_code10"  class="w3-input" readonly>
	
<input type='text' name = "product_c10"  id = "product_c10" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax('product_c10','product_id10','product_name10','unit_name10','product_price10','discount_unit10','warranty10');"/> 
<input type='hidden' name = "h_product_c10"  id = "h_product_c10"  class="w3-input" readonly>	
<input type='hidden' name = "product_id10"  id = "product_id10" class="w3-input" />

</td>
<td>
<textarea  name = "product_name10"  id = "product_name10"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name10"  id = "unit_name10"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count10"  id = "sale_count10"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price10"  id = "product_price10"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit10"  id = "discount_unit10" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount10"  id = "sum_amount10"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count10} * {product_price10} - {discount_unit10} * {sale_count10}'readonly/>
</td>

<td><input type='text' name = "warranty10"  id = "warranty10"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal10"  id = "cal10"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm10"  id = "pm10"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk10"  id = "sale_remarkk10"  class="w3-input" ></textarea>
</td>
<td style="width:10%;" >
	<input type='checkbox' name = "clear_br10"  id = "clear_br10" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno10"  id = "clear_ivno10"  class="w3-input"   >
	</td>
<td><a onclick="document.getElementById('product_code10').value = '';
document.getElementById('product_name10').value  = ''; 
document.getElementById('unit_name10').value  = '';
document.getElementById('product_price10').value  = '';
document.getElementById('sale_count10').value  = '';

document.getElementById('sum_amount10').value  = '';
document.getElementById('discount_unit10').value  = '';
document.getElementById('product_id10').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>
</tbody>
</table>
 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk1" id="ckk1" onClick="ck_frm1();" value="1"/>เพิ่มเติม1<br/>

</div>
<?php //******************************************************************************* ?>
<div id="frm_txt1" style="display:none;">



<table width="100%" border="0" class="w3-table">
<thead>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet11"  id = "product_codet11" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet11','product_id11','product_name11','unit_name11','product_price11','discount_unit11','warranty11');"/> 
<input type='hidden' name = "h_product_codet11"  id = "h_product_codet11"  class="button4" readonly>

<input type='text' name = "product_code11"  id = "product_code11" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax('product_code11','product_id11','product_name11','unit_name11','product_price11','discount_unit11','warranty11');"/> 
<input type='hidden' name = "h_product_code11"  id = "h_product_code11"  class="w3-input" readonly>
	
<input type='text' name = "product_c11"  id = "product_c11" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax('product_c11','product_id11','product_name11','unit_name11','product_price11','discount_unit11','warranty11');"/> 
<input type='hidden' name = "h_product_c11"  id = "h_product_c11"  class="w3-input" readonly>	
<input type='hidden' name = "product_id11"  id = "product_id11" class="w3-input" />

</td>
<td style="width:15%;">
<textarea  name = "product_name11"  id = "product_name11"  class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name11"  id = "unit_name11"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count11"  id = "sale_count11"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price11"  id = "product_price11"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td style="width:8%;"><input type='text' name = "discount_unit11"  id = "discount_unit11"  class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' name = "sum_amount11"  id = "sum_amount11"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count11} * {product_price11} - {discount_unit11} * {sale_count11}'readonly/>
</td>

<td style="width:5%;"><input type='text' name = "warranty11"  id = "warranty11"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal11"  id = "cal11"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "pm11"  id = "pm11"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td style="width:10%;">
<textarea  name = "sale_remarkk11"  id = "sale_remarkk11"  class="w3-input" ></textarea>
</td>
<td style="width:10%;" >
	<input type='checkbox' name = "clear_br11"  id = "clear_br11" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno11"  id = "clear_ivno11"  class="w3-input"   >
	</td>
<td style="width:2%;"><a onclick="document.getElementById('product_code11').value = '';
document.getElementById('product_name11').value  = ''; 
document.getElementById('unit_name11').value  = '';
document.getElementById('product_price11').value  = '';
document.getElementById('sale_count11').value  = '';

document.getElementById('sum_amount11').value  = '';
document.getElementById('discount_unit11').value  = '';
document.getElementById('product_id11').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>



<tr>
<td >
<input type='text' name = "product_codet12"  id = "product_codet12" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet12','product_id12','product_name12','unit_name12','product_price12','discount_unit12','warranty12');"/> 
<input type='hidden' name = "h_product_codet12"  id = "h_product_codet12"  class="button4" readonly>

<input type='text' name = "product_code12"  id = "product_code12" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax('product_code12','product_id12','product_name12','unit_name12','product_price12','discount_unit12','warranty12');"/> 
<input type='hidden' name = "h_product_code12"  id = "h_product_code12"  class="w3-input" readonly>
	
<input type='text' name = "product_c12"  id = "product_c12" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax('product_c12','product_id12','product_name12','unit_name12','product_price12','discount_unit12','warranty12');"/> 
<input type='hidden' name = "h_product_c12"  id = "h_product_c12"  class="w3-input" readonly>	
<input type='hidden' name = "product_id12"  id = "product_id12" class="w3-input" />

</td>
<td>
<textarea  name = "product_name12"  id = "product_name12"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name12"  id = "unit_name12"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count12"  id = "sale_count12"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price12"  id = "product_price12"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit12"  id = "discount_unit12" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount12"  id = "sum_amount12"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count12} * {product_price12} - {discount_unit12} * {sale_count12}'readonly/>
</td>

<td><input type='text' name = "warranty12"  id = "warranty12"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal12"  id = "cal12"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm12"  id = "pm12"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk12"  id = "sale_remarkk12"  class="w3-input" ></textarea>
</td>
<td style="width:10%;" >
	<input type='checkbox' name = "clear_br12"  id = "clear_br12" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno12"  id = "clear_ivno12"  class="w3-input"   >
	</td>
<td><a onclick="document.getElementById('product_code12').value = '';
document.getElementById('product_name12').value  = ''; 
document.getElementById('unit_name12').value  = '';
document.getElementById('product_price12').value  = '';
document.getElementById('sale_count12').value  = '';

document.getElementById('sum_amount12').value  = '';
document.getElementById('discount_unit12').value  = '';
document.getElementById('product_id12').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>



<tr>
<td >
<input type='text' name = "product_codet13"  id = "product_codet13" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet13','product_id13','product_name13','unit_name13','product_price13','discount_unit13','warranty13');"/> 
<input type='hidden' name = "h_product_codet13"  id = "h_product_codet13"  class="button4" readonly>

<input type='text' name = "product_code13"  id = "product_code13" class="w3-input" placeholder="Search ชื่ออังกฤษ..."    OnChange="JavaScript:doCallAjax('product_code13','product_id13','product_name13','unit_name13','product_price13','discount_unit13','warranty13');"/> 
<input type='hidden' name = "h_product_code13"  id = "h_product_code13"  class="w3-input" readonly>
	
<input type='text' name = "product_c13"  id = "product_c13" class="w3-input" placeholder="Search ชื่อไทย..."    OnChange="JavaScript:doCallAjax('product_c13','product_id13','product_name13','unit_name13','product_price13','discount_unit13','warranty13');"/> 
<input type='hidden' name = "h_product_c13"  id = "h_product_c13"  class="w3-input" readonly>	
<input type='hidden' name = "product_id13"  id = "product_id13" class="w3-input" />

</td>
<td>
<textarea  name = "product_name13"  id = "product_name13"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name13"  id = "unit_name13"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count13"  id = "sale_count13"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price13"  id = "product_price13"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit13"  id = "discount_unit13" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount13"  id = "sum_amount13"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count13} * {product_price13} - {discount_unit13} * {sale_count13}'readonly/>
</td>

<td><input type='text' name = "warranty13"  id = "warranty13"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal13"  id = "cal13"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm13"  id = "pm13"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk13"  id = "sale_remarkk10"  class="w3-input" ></textarea>
</td>
<td style="width:10%;" >
	<input type='checkbox' name = "clear_br13"  id = "clear_br13" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno13"  id = "clear_ivno13"  class="w3-input"   >
	</td>
<td><a onclick="document.getElementById('product_code13').value = '';
document.getElementById('product_name13').value  = ''; 
document.getElementById('unit_name13').value  = '';
document.getElementById('product_price13').value  = '';
document.getElementById('sale_count13').value  = '';

document.getElementById('sum_amount13').value  = '';
document.getElementById('discount_unit13').value  = '';
document.getElementById('product_id13').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


<tr>
<td >
<input type='text' name = "product_codet14"  id = "product_codet14" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet14','product_id14','product_name14','unit_name14','product_price14','discount_unit14','warranty14');"/> 
<input type='hidden' name = "h_product_codet14"  id = "h_product_codet14"  class="button4" readonly>

<input type='text' name = "product_code14"  id = "product_code14" class="w3-input" placeholder="Search ชื่ออังกฤษ..."    OnChange="JavaScript:doCallAjax('product_code14','product_id14','product_name14','unit_name14','product_price14','discount_unit14','warranty14');"/> 
<input type='hidden' name = "h_product_code14"  id = "h_product_code14"  class="w3-input" readonly>
	
<input type='text' name = "product_c14"  id = "product_c14" class="w3-input" placeholder="Search ชื่อไทย..."    OnChange="JavaScript:doCallAjax('product_code14','product_id14','product_name14','unit_name14','product_price14','discount_unit14','warranty14');"/> 
<input type='hidden' name = "h_product_c14"  id = "h_product_c14"  class="w3-input" readonly>	
<input type='hidden' name = "product_id14"  id = "product_id14" class="w3-input" />

</td>
<td>
<textarea  name = "product_name14"  id = "product_name14"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name14"  id = "unit_name14"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count14"  id = "sale_count14"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price14"  id = "product_price14"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit14"  id = "discount_unit14" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount14"  id = "sum_amount14"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count14} * {product_price14} - {discount_unit14} * {sale_count14}'readonly/>
</td>

<td><input type='text' name = "warranty14"  id = "warranty14"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal14"  id = "cal14"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm14"  id = "pm14"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk14"  id = "sale_remarkk14"  class="w3-input" ></textarea>
</td>
<td style="width:10%;" >
	<input type='checkbox' name = "clear_br14"  id = "clear_br14" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno14"  id = "clear_ivno14"  class="w3-input"   >
	</td>
<td><a onclick="document.getElementById('product_code14').value = '';
document.getElementById('product_name14').value  = ''; 
document.getElementById('unit_name14').value  = '';
document.getElementById('product_price14').value  = '';
document.getElementById('sale_count14').value  = '';

document.getElementById('sum_amount14').value  = '';
document.getElementById('discount_unit14').value  = '';
document.getElementById('product_id14').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


<tr>
<td >
<input type='text' name = "product_codet15"  id = "product_codet15" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet15','product_id15','product_name15','unit_name15','product_price15','discount_unit15','warranty15');"/> 
<input type='hidden' name = "h_product_codet15"  id = "h_product_codet15"  class="button4" readonly>

<input type='text' name = "product_code15"  id = "product_code15" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax('product_code15','product_id15','product_name15','unit_name15','product_price15','discount_unit15','warranty15');"/> 
<input type='hidden' name = "h_product_code15"  id = "h_product_code15"  class="w3-input" readonly>
	
<input type='text' name = "product_c15"  id = "product_c15" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax('product_c15','product_id15','product_name15','unit_name15','product_price15','discount_unit15','warranty15');"/> 
<input type='hidden' name = "h_product_c15"  id = "h_product_c15"  class="w3-input" readonly>	
<input type='hidden' name = "product_id15"  id = "product_id15" class="w3-input" />

</td>
<td>
<textarea  name = "product_name15"  id = "product_name15"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name15"  id = "unit_name15"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count15"  id = "sale_count15"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price15"  id = "product_price15"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit15"  id = "discount_unit15" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount15"  id = "sum_amount15"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count15} * {product_price15} - {discount_unit15} * {sale_count15}'readonly/>
</td>

<td><input type='text' name = "warranty15"  id = "warranty15"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal15"  id = "cal15"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm15"  id = "pm15"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk15"  id = "sale_remarkk15"  class="w3-input" ></textarea>
</td>
<td style="width:10%;" >
	<input type='checkbox' name = "clear_br15"  id = "clear_br15" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno15"  id = "clear_ivno15"  class="w3-input"   >
	</td>
<td><a onclick="document.getElementById('product_code15').value = '';
document.getElementById('product_name15').value  = ''; 
document.getElementById('unit_name15').value  = '';
document.getElementById('product_price15').value  = '';
document.getElementById('sale_count15').value  = '';

document.getElementById('sum_amount15').value  = '';
document.getElementById('discount_unit15').value  = '';
document.getElementById('product_id15').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


</tbody>
</table>

 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk2" id="ckk2" onClick="ck_frm2();" value="1"/>เพิ่มเติม2<br/>

</div>
<?php //******************************************************************************* ?>
<div id="frm_txt2" style="display:none;">



<table width="100%" border="0" class="w3-table">
<thead>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet16"  id = "product_codet16" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet16','product_id16','product_name16','unit_name16','product_price16','discount_unit16');"/> 
<input type='hidden' name = "h_product_codet16"  id = "h_product_codet16"  class="button4" readonly>

<input type='text' name = "product_code16"  id = "product_code16" class="w3-input" placeholder="Search ชื่อสินค้า..."  OnChange="JavaScript:doCallAjax('product_code16','product_id16','product_name16','unit_name11','product_price16','discount_unit16');"/> 

<input type='hidden' name = "h_product_code16"  id = "h_product_code16"  class="w3-input" readonly>
<input type='hidden' name = "product_id16"  id = "product_id16" class="w3-input" />

</td>
<td style="width:15%;">
<textarea  name = "product_name16"  id = "product_name16"  class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name16"  id = "unit_name16"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count16"  id = "sale_count16"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price16"  id = "product_price16"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td style="width:8%;"><input type='text' name = "discount_unit16"  id = "discount_unit16" class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' name = "sum_amount16"  id = "sum_amount16"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count16} * {product_price16} - {discount_unit16} * {sale_count16}'readonly/>
</td>

<td style="width:5%;"><input type='text' name = "warranty16"  id = "warranty11"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal16"  id = "cal16"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "pm16"  id = "pm16"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td style="width:10%;">
<textarea  name = "sale_remarkk16"  id = "sale_remarkk16"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code16').value = '';
document.getElementById('product_name16').value  = ''; 
document.getElementById('unit_name16').value  = '';
document.getElementById('product_price16').value  = '';
document.getElementById('sale_count16').value  = '';

document.getElementById('sum_amount16').value  = '';
document.getElementById('discount_unit16').value  = '';
document.getElementById('product_id16').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>



<tr>
<td >
<input type='text' name = "product_codet17"  id = "product_codet17" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet17','product_id17','product_name17','unit_name17','product_price17','discount_unit17');"/> 
<input type='hidden' name = "h_product_codet17"  id = "h_product_codet17"  class="button4" readonly>

<input type='text' name = "product_code17"  id = "product_code17" class="w3-input" placeholder="Search ชื่อสินค้า..."   OnChange="JavaScript:doCallAjax('product_code17','product_id17','product_name17','unit_name17','product_price17','discount_unit17');"/> 

<input type='hidden' name = "h_product_code17"  id = "h_product_code17"  class="w3-input" readonly>
<input type='hidden' name = "product_id17"  id = "product_id17" class="w3-input" />

</td>
<td>
<textarea  name = "product_name17"  id = "product_name17"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name17"  id = "unit_name17"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count17"  id = "sale_count17"  class="w3-input"  style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price17"  id = "product_price17"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit17"  id = "discount_unit17" class="w3-input"   style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount17"  id = "sum_amount17"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count17} * {product_price17} - {discount_unit17} * {sale_count17}'readonly/>
</td>

<td><input type='text' name = "warranty17"  id = "warranty17"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal17"  id = "cal17"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm17"  id = "pm17"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk17"  id = "sale_remarkk17"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code17').value = '';
document.getElementById('product_name17').value  = ''; 
document.getElementById('unit_name17').value  = '';
document.getElementById('product_price17').value  = '';
document.getElementById('sale_count17').value  = '';

document.getElementById('sum_amount17').value  = '';
document.getElementById('discount_unit17').value  = '';
document.getElementById('product_id17').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>



<tr>
<td >
<input type='text' name = "product_codet18"  id = "product_codet18" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet18','product_id18','product_name18','unit_name18','product_price18','discount_unit1');"/> 
<input type='hidden' name = "h_product_codet18"  id = "h_product_codet18"  class="button4" readonly>

<input type='text' name = "product_code18"  id = "product_code18" class="w3-input" placeholder="Search ชื่อสินค้า..."    OnChange="JavaScript:doCallAjax('product_code18','product_id18','product_name18','unit_name18','product_price18','discount_unit18');"/> 

<input type='hidden' name = "h_product_code18"  id = "h_product_code18"  class="w3-input" readonly>
<input type='hidden' name = "product_id18"  id = "product_id18" class="w3-input" />

</td>
<td>
<textarea  name = "product_name18"  id = "product_name18"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name18"  id = "unit_name18"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count18"  id = "sale_count18"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price18"  id = "product_price18"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit18"  id = "discount_unit18" class="w3-input" style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount18"  id = "sum_amount18"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count13} * {product_price18} - {discount_unit18} * {sale_count18}'readonly/>
</td>

<td><input type='text' name = "warranty18"  id = "warranty18"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal18"  id = "cal18"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm18"  id = "pm18"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk18"  id = "sale_remarkk18"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code18').value = '';
document.getElementById('product_name18').value  = ''; 
document.getElementById('unit_name18').value  = '';
document.getElementById('product_price18').value  = '';
document.getElementById('sale_count18').value  = '';

document.getElementById('sum_amount18').value  = '';
document.getElementById('discount_unit18').value  = '';
document.getElementById('product_id18').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


<tr>
<td >
<input type='text' name = "product_codet19"  id = "product_codet19" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet19','product_id19','product_name19','unit_name19','product_price19','discount_unit19');"/> 
<input type='hidden' name = "h_product_codet19"  id = "h_product_codet19"  class="button4" readonly>

<input type='text' name = "product_code19"  id = "product_code19" class="w3-input" placeholder="Search ชื่อสินค้า..."   OnChange="JavaScript:doCallAjax('product_code19','product_id19','product_name19','unit_name19','product_price19','discount_unit19');"/> 

<input type='hidden' name = "h_product_code19"  id = "h_product_code19"  class="w3-input" readonly>
<input type='hidden' name = "product_id19"  id = "product_id19" class="w3-input" />

</td>
<td>
<textarea  name = "product_name19"  id = "product_name19"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name19"  id = "unit_name19"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count19"  id = "sale_count19"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price19"  id = "product_price19"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit19"  id = "discount_unit19" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount19"  id = "sum_amount19"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count19} * {product_price19} - {discount_unit19} * {sale_count19}'readonly/>
</td>

<td><input type='text' name = "warranty19"  id = "warranty19"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal19"  id = "cal19"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm19"  id = "pm19"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk19"  id = "sale_remarkk19"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code19').value = '';
document.getElementById('product_name19').value  = ''; 
document.getElementById('unit_name19').value  = '';
document.getElementById('product_price19').value  = '';
document.getElementById('sale_count19').value  = '';

document.getElementById('sum_amount19').value  = '';
document.getElementById('discount_unit19').value  = '';
document.getElementById('product_id19').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


<tr>
<td >
<input type='text' name = "product_codet20"  id = "product_codet20" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet20','product_id20','product_name20','unit_name20','product_price20','discount_unit20');"/> 
<input type='hidden' name = "h_product_codet20"  id = "h_product_codet20"  class="button4" readonly>

<input type='text' name = "product_code20"  id = "product_code20" class="w3-input" placeholder="Search ชื่อสินค้า..."   OnChange="JavaScript:doCallAjax('product_code20','product_id20','product_name20','unit_name20','product_price20','discount_unit20');"/> 

<input type='hidden' name = "h_product_code20"  id = "h_product_code20"  class="w3-input" readonly>
<input type='hidden' name = "product_id20"  id = "product_id20" class="w3-input" />

</td>
<td>
<textarea  name = "product_name20"  id = "product_name20"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name20"  id = "unit_name20"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count20"  id = "sale_count20"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price20"  id = "product_price20"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit20"  id = "discount_unit20" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount20"  id = "sum_amount20"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count20} * {product_price20} - {discount_unit20} * {sale_count20}'readonly/>
</td>

<td><input type='text' name = "warranty20"  id = "warranty20"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal20"  id = "cal20"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm20"  id = "pm20"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk20"  id = "sale_remarkk20"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code20').value = '';
document.getElementById('product_name20').value  = ''; 
document.getElementById('unit_name20').value  = '';
document.getElementById('product_price20').value  = '';
document.getElementById('sale_count20').value  = '';

document.getElementById('sum_amount20').value  = '';
document.getElementById('discount_unit20').value  = '';
document.getElementById('product_id20').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


</tbody>
</table>

 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk3" id="ckk3" onClick="ck_frm3();" value="1"/>เพิ่มเติม3<br/>

</div>
<?php //******************************************************************************* ?>
<div id="frm_txt3" style="display:none;">



<table width="100%" border="0" class="w3-table">
<thead>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet21"  id = "product_codet21" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet21','product_id21','product_name21','unit_name21','product_price21','discount_unit21');"/> 
<input type='hidden' name = "h_product_codet21"  id = "h_product_codet21"  class="button4" readonly>

<input type='text' name = "product_code21"  id = "product_code21" class="w3-input" placeholder="Search ชื่อสินค้า..."   OnChange="JavaScript:doCallAjax('product_code21','product_id21','product_name21','unit_name21','product_price21','discount_unit21');"/> 

<input type='hidden' name = "h_product_code21"  id = "h_product_code21"  class="w3-input" readonly>
<input type='hidden' name = "product_id21"  id = "product_id21" class="w3-input" />

</td>
<td style="width:15%;">
<textarea  name = "product_name21"  id = "product_name21"  class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name21"  id = "unit_name21"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count21"  id = "sale_count21"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price21"  id = "product_price21"  class="w3-input"   style="color:black;text-align:right" />
</td>
<td style="width:8%;"><input type='text' name = "discount_unit21"  id = "discount_unit21" class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' name = "sum_amount21"  id = "sum_amount21" class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count21} * {product_price21} - {discount_unit21} * {sale_count21}'readonly/>
</td>

<td style="width:5%;"><input type='text' name = "warranty21"  id = "warranty21"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal21"  id = "cal21"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "pm21"  id = "pm21"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td style="width:10%;">
<textarea  name = "sale_remarkk21"  id = "sale_remarkk21"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code21').value = '';
document.getElementById('product_name21').value  = ''; 
document.getElementById('unit_name21').value  = '';
document.getElementById('product_price21').value  = '';
document.getElementById('sale_count21').value  = '';

document.getElementById('sum_amount21').value  = '';
document.getElementById('discount_unit21').value  = '';
document.getElementById('product_id21').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>



<tr>
<td >
<input type='text' name = "product_codet22"  id = "product_codet22" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet22','product_id22','product_name22','unit_name22','product_price22','discount_unit22');"/> 
<input type='hidden' name = "h_product_codet22"  id = "h_product_codet22"  class="button4" readonly>

<input type='text' name = "product_code22"  id = "product_code22" class="w3-input" placeholder="Search ชื่อสินค้า..."   OnChange="JavaScript:doCallAjax('product_code22','product_id22','product_name22','unit_name22','product_price22','discount_unit22');"/> 

<input type='hidden' name = "h_product_code22"  id = "h_product_code22"  class="w3-input" readonly>
<input type='hidden' name = "product_id22"  id = "product_id22" class="w3-input" />

</td>
<td>
<textarea  name = "product_name22"  id = "product_name22"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name22"  id = "unit_name22"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count22"  id = "sale_count22"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price22"  id = "product_price22"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit22"  id = "discount_unit22" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount22"  id = "sum_amount22"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count22} * {product_price22} - {discount_unit22} * {sale_count22}'readonly/>
</td>

<td><input type='text' name = "warranty22"  id = "warranty22"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal22"  id = "cal22"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm22"  id = "pm22"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk22"  id = "sale_remarkk22"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code22').value = '';
document.getElementById('product_name22').value  = ''; 
document.getElementById('unit_name22').value  = '';
document.getElementById('product_price22').value  = '';
document.getElementById('sale_count22').value  = '';

document.getElementById('sum_amount22').value  = '';
document.getElementById('discount_unit22').value  = '';
document.getElementById('product_id22').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>



<tr>
<td >
<input type='text' name = "product_codet23"  id = "product_codet23" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet23','product_id23','product_name23','unit_name23','product_price23','discount_unit23');"/> 
<input type='hidden' name = "h_product_codet23"  id = "h_product_codet23"  class="button4" readonly>

<input type='text' name = "product_code23"  id = "product_code23" class="w3-input" placeholder="Search ชื่อสินค้า..."  OnChange="JavaScript:doCallAjax('product_code23','product_id23','product_name23','unit_name23','product_price23','discount_unit23');"/> 

<input type='hidden' name = "h_product_code23"  id = "h_product_code23"  class="w3-input" readonly>
<input type='hidden' name = "product_id23"  id = "product_id23" class="w3-input" />

</td>
<td>
<textarea name = "product_name23"  id = "product_name23"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name23"  id = "unit_name23"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count23"  id = "sale_count23"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price23"  id = "product_price23"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit23"  id = "discount_unit23" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount23"  id = "sum_amount23"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count23} * {product_price23} - {discount_unit23} * {sale_count23}'readonly/>
</td>

<td><input type='text' name = "warranty23"  id = "warranty23"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal23"  id = "cal23"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm23"  id = "pm23"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk23"  id = "sale_remarkk23"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code23').value = '';
document.getElementById('product_name23').value  = ''; 
document.getElementById('unit_name23').value  = '';
document.getElementById('product_price23').value  = '';
document.getElementById('sale_count23').value  = '';

document.getElementById('sum_amount23').value  = '';
document.getElementById('discount_unit23').value  = '';
document.getElementById('product_id23').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


<tr>
<td >
<input type='text' name = "product_codet24"  id = "product_codet24" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet24','product_id24','product_name24','unit_name24','product_price24','discount_unit24');"/> 
<input type='hidden' name = "h_product_codet24"  id = "h_product_codet24"  class="button4" readonly>

<input type='text' name = "product_code24"  id = "product_code24" class="w3-input" placeholder="Search ชื่อสินค้า..."   OnChange="JavaScript:doCallAjax('product_code24','product_id24','product_name24','unit_name24','product_price24','discount_unit24');"/> 

<input type='hidden' name = "h_product_code24"  id = "h_product_code24"  class="w3-input" readonly>
<input type='hidden' name = "product_id24"  id = "product_id24" class="w3-input" />

</td>
<td>
<textarea  name = "product_name24"  id = "product_name24"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name24"  id = "unit_name24"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count24"  id = "sale_count24"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price24"  id = "product_price24"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit24"  id = "discount_unit24" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount24"  id = "sum_amount24"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count24} * {product_price24} - {discount_unit24} * {sale_count24}'readonly/>
</td>

<td><input type='text' name = "warranty24"  id = "warranty24"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal24"  id = "cal24"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm24"  id = "pm24"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk24"  id = "sale_remarkk24"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code24').value = '';
document.getElementById('product_name24').value  = ''; 
document.getElementById('unit_name24').value  = '';
document.getElementById('product_price24').value  = '';
document.getElementById('sale_count24').value  = '';

document.getElementById('sum_amount24').value  = '';
document.getElementById('discount_unit24').value  = '';
document.getElementById('product_id24').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


<tr>
<td >
<input type='text' name = "product_codet25"  id = "product_codet25" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet25','product_id25','product_name25','unit_name25','product_price25','discount_unit25');"/> 
<input type='hidden' name = "h_product_codet25"  id = "h_product_codet25"  class="button4" readonly>

<input type='text' name = "product_code25"  id = "product_code25" class="w3-input" placeholder="Search ชื่อสินค้า..."   OnChange="JavaScript:doCallAjax('product_code25','product_id25','product_name25','unit_name25','product_price25','discount_unit25');"/> 

<input type='hidden' name = "h_product_code25"  id = "h_product_code25"  class="w3-input" readonly>
<input type='hidden' name = "product_id25"  id = "product_id25" class="w3-input" />

</td>
<td>
<textarea  name = "product_name25"  id = "product_name25"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name25"  id = "unit_name25"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count25"  id = "sale_count25"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price25"  id = "product_price25"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit25"  id = "discount_unit25" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount25"  id = "sum_amount25"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count25} * {product_price25} - {discount_unit25} * {sale_count25}'readonly/>
</td>

<td><input type='text' name = "warranty25"  id = "warranty25"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal25"  id = "cal25"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm25"  id = "pm25"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk25"  id = "sale_remarkk25"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code25').value = '';
document.getElementById('product_name25').value  = ''; 
document.getElementById('unit_name25').value  = '';
document.getElementById('product_price25').value  = '';
document.getElementById('sale_count25').value  = '';

document.getElementById('sum_amount25').value  = '';
document.getElementById('discount_unit25').value  = '';
document.getElementById('product_id25').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


</tbody>
</table>

 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk4" id="ckk4" onClick="ck_frm4();" value="1"/>เพิ่มเติม4<br/>

</div>
<?php //******************************************************************************* ?>
<div id="frm_txt4" style="display:none;">



<table width="100%" border="0" class="w3-table">
<thead>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet26"  id = "product_codet26" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet26','product_id26','product_name26','unit_name26','product_price26','discount_unit26');"/> 
<input type='hidden' name = "h_product_codet26"  id = "h_product_codet26"  class="button4" readonly>

<input type='text' name = "product_code26"  id = "product_code26" class="w3-input" placeholder="Search ชื่อสินค้า..."    OnChange="JavaScript:doCallAjax('product_code26','product_id26','product_name26','unit_name26','product_price26','discount_unit26');"/> 

<input type='hidden' name = "h_product_code26"  id = "h_product_code26"  class="w3-input" readonly>
<input type='hidden' name = "product_id26"  id = "product_id26" class="w3-input" />

</td>
<td style="width:15%;">
<textarea  name = "product_name26"  id = "product_name26"  class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name26"  id = "unit_name26"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count26"  id = "sale_count26"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price26"  id = "product_price26"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td style="width:8%;"><input type='text' name = "discount_unit26"  id = "discount_unit26"  class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' name = "sum_amount26"  id = "sum_amount26"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count26} * {product_price26} - {discount_unit26} * {sale_count26}'readonly/>
</td>

<td style="width:5%;"><input type='text' name = "warranty26"  id = "warranty26"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal26"  id = "cal26"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "pm26"  id = "pm26"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td style="width:10%;">
<textarea  name = "sale_remarkk26"  id = "sale_remarkk26"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code26').value = '';
document.getElementById('product_name26').value  = ''; 
document.getElementById('unit_name26').value  = '';
document.getElementById('product_price26').value  = '';
document.getElementById('sale_count26').value  = '';

document.getElementById('sum_amount26').value  = '';
document.getElementById('discount_unit26').value  = '';
document.getElementById('product_id26').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>



<tr>
<td >
<input type='text' name = "product_codet27"  id = "product_codet27" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet27','product_id27','product_name27','unit_name27','product_price27','discount_unit27');"/> 
<input type='hidden' name = "h_product_codet27"  id = "h_product_codet27"  class="button4" readonly>

<input type='text' name = "product_code27"  id = "product_code27" class="w3-input" placeholder="Search ชื่อสินค้า..."   OnChange="JavaScript:doCallAjax('product_code27','product_id27','product_name27','unit_name27','product_price27','discount_unit27');"/> 

<input type='hidden' name = "h_product_code27"  id = "h_product_code27"  class="w3-input" readonly>
<input type='hidden' name = "product_id27"  id = "product_id27" class="w3-input" />

</td>
<td>
<textarea  name = "product_name27"  id = "product_name27"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name27"  id = "unit_name27"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count27"  id = "sale_count27"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price27"  id = "product_price27"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit27"  id = "discount_unit27" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount27"  id = "sum_amount27"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count27} * {product_price27} - {discount_unit27} * {sale_count27}'readonly/>
</td>

<td><input type='text' name = "warranty27"  id = "warranty27"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal27"  id = "cal27"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm27"  id = "pm27"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk27"  id = "sale_remarkk27"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code27').value = '';
document.getElementById('product_name27').value  = ''; 
document.getElementById('unit_name27').value  = '';
document.getElementById('product_price27').value  = '';
document.getElementById('sale_count27').value  = '';

document.getElementById('sum_amount27').value  = '';
document.getElementById('discount_unit27').value  = '';
document.getElementById('product_id27').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>



<tr>
<td >
<input type='text' name = "product_codet28"  id = "product_codet28" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax('product_codet28','product_id28','product_name28','unit_name28','product_price28','discount_unit28');"/> 
<input type='hidden' name = "h_product_codet28"  id = "h_product_codet28"  class="button4" readonly>

<input type='text' name = "product_code28"  id = "product_code28" class="w3-input" placeholder="Search ชื่อสินค้า..."  OnChange="JavaScript:doCallAjax('product_code28','product_id28','product_name28','unit_name28','product_price28','discount_unit28');"/> 

<input type='hidden' name = "h_product_code28"  id = "h_product_code28"  class="w3-input" readonly>
<input type='hidden' name = "product_id28"  id = "product_id28" class="w3-input" />

</td>
<td>
<textarea  name = "product_name28"  id = "product_name28"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name28"  id = "unit_name28"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count28"  id = "sale_count28"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price28"  id = "product_price28"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit28"  id = "discount_unit28" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount28"  id = "sum_amount28"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count28} * {product_price28} - {discount_unit28} * {sale_count28}'readonly/>
</td>

<td><input type='text' name = "warranty28"  id = "warranty28"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal28"  id = "cal28"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm28"  id = "pm28"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk28"  id = "sale_remarkk28"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code28').value = '';
document.getElementById('product_name28').value  = ''; 
document.getElementById('unit_name28').value  = '';
document.getElementById('product_price28').value  = '';
document.getElementById('sale_count28').value  = '';

document.getElementById('sum_amount28').value  = '';
document.getElementById('discount_unit28').value  = '';
document.getElementById('product_id28').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


<tr>
<td >
<input type='text' name = "product_codet29"  id = "product_codet29" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet29','product_id29','product_name29','unit_name29','product_price29','discount_unit29');"/> 
<input type='hidden' name = "h_product_codet29"  id = "h_product_codet29"  class="button4" readonly>

<input type='text' name = "product_code29"  id = "product_code29" class="w3-input" placeholder="Search ชื่อสินค้า..."   OnChange="JavaScript:doCallAjax('product_code29','product_id29','product_name29','unit_name29','product_price29','discount_unit29');"/> 

<input type='hidden' name = "h_product_code29"  id = "h_product_code29"  class="w3-input" readonly>
<input type='hidden' name = "product_id29"  id = "product_id29" class="w3-input" />

</td>
<td>
<textarea  name = "product_name29"  id = "product_name29"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name29"  id = "unit_name29"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count29"  id = "sale_count29"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price29"  id = "product_price29"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit29"  id = "discount_unit29" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount29"  id = "sum_amount29"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count29} * {product_price29} - {discount_unit29} * {sale_count29}'readonly/>
</td>

<td><input type='text' name = "warranty29"  id = "warranty29"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal29"  id = "cal29"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm29"  id = "pm29"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk29"  id = "sale_remarkk29"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code29').value = '';
document.getElementById('product_name29').value  = ''; 
document.getElementById('unit_name29').value  = '';
document.getElementById('product_price29').value  = '';
document.getElementById('sale_count29').value  = '';

document.getElementById('sum_amount29').value  = '';
document.getElementById('discount_unit29').value  = '';
document.getElementById('product_id29').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


<tr>
<td >
<input type='text' name = "product_codet30"  id = "product_codet30" class="w3-input" placeholder="Search รหัสสินค้า..."  OnChange="JavaScript:doCallAjax('product_codet30','product_id30','product_name30','unit_name30','product_price30','discount_unit30');"/> 
<input type='hidden' name = "h_product_codet30"  id = "h_product_codet30"  class="button4" readonly>

<input type='text' name = "product_code30"  id = "product_code30" class="w3-input" placeholder="Search ชื่อสินค้า..."  OnChange="JavaScript:doCallAjax('product_code30','product_id30','product_name30','unit_name30','product_price30','discount_unit30');"/> 

<input type='hidden' name = "h_product_code30"  id = "h_product_code30"  class="w3-input" readonly>
<input type='hidden' name = "product_id30"  id = "product_id30" class="w3-input" />

</td>
<td>
<textarea  name = "product_name30"  id = "product_name30"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name30"  id = "unit_name30"  class="w3-input" />
</td>
<td>
<input type='text' name = "sale_count30"  id = "sale_count30"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price30"  id = "product_price30"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "discount_unit30"  id = "discount_unit30" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount30"  id = "sum_amount30"  class="w3-input"  style="color:black;text-align:right" value="" jAutoCalc= '{sale_count30} * {product_price30} - {discount_unit30} * {sale_count30}'readonly/>
</td>

<td><input type='text' name = "warranty30"  id = "warranty30"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal30"  id = "cal30"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm30"  id = "pm30"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>


<td>
<textarea  name = "sale_remarkk30"  id = "sale_remarkk30"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code30').value = '';
document.getElementById('product_name30').value  = ''; 
document.getElementById('unit_name30').value  = '';
document.getElementById('product_price30').value  = '';
document.getElementById('sale_count30').value  = '';

document.getElementById('sum_amount30').value  = '';
document.getElementById('discount_unit30').value  = '';
document.getElementById('product_id30').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>


</tbody>
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code9","h_product_code9");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code10","h_product_code10");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code11","h_product_code11");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code12","h_product_code12");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code13","h_product_code13");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code14","h_product_code14");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code15","h_product_code15");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code16","h_product_code16");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code17","h_product_code17");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code18","h_product_code18");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code19","h_product_code19");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code20","h_product_code20");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code21","h_product_code21");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code22","h_product_code22");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code23","h_product_code23");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code24","h_product_code24");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code25","h_product_code25");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code26","h_product_code26");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code27","h_product_code27");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code28","h_product_code28");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code29","h_product_code29");
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
		return "data_pro_engdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code30","h_product_code30");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet9","h_product_codet9");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet10","h_product_codet10");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet11","h_product_codet11");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet12","h_product_codet12");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet13","h_product_codet13");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet14","h_product_codet14");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet15","h_product_codet15");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet16","h_product_codet16");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet17","h_product_codet17");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet18","h_product_codet18");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet19","h_product_codet19");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet20","h_product_codet20");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet21","h_product_codet21");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet22","h_product_codet22");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet23","h_product_codet23");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet24","h_product_codet24");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet25","h_product_codet25");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet26","h_product_codet26");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet27","h_product_codet27");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet28","h_product_codet28");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet29","h_product_codet29");
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
		return "data_pro_engdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet30","h_product_codet30");
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
		return "data_pro_engdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_engdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_engdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c8","h_product_c8");
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
		return "data_pro_engdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c9","h_product_c9");
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
		return "data_pro_engdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c10","h_product_c10");
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
		return "data_pro_engdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c11","h_product_c11");
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
		return "data_pro_engdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c12","h_product_c12");
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
		return "data_pro_engdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c13","h_product_c13");
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
		return "data_pro_engdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c14","h_product_c14");
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
		return "data_pro_engdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c15","h_product_c15");
        </script>
		


