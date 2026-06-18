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

<input type='text' name = "product_codet6"  id = "product_codet6" class="w3-input" placeholder="Search รหัสสินค้า..."OnChange="JavaScript:doCallAjax('product_codet6','product_id6','product_name6','unit_name6','product_price6','discount_unit6','warranty6');"/> 
<input type='hidden' name = "h_product_codet6"  id = "h_product_codet6"  class="w3-input" readonly>

<input type='text' name = "product_code6"  id = "product_code6" class="w3-input" placeholder="Search ชื่ออังกฤษ..." OnChange="JavaScript:doCallAjax('product_code6','product_id6','product_name6','unit_name6','product_price6','discount_unit6','warranty6');"/> 
<input type='hidden' name = "h_product_code6"  id = "h_product_code6"  class="w3-input" readonly>
	
<input type='text' name = "product_c6"  id = "product_c6" class="w3-input" placeholder="Search ชื่อไทย..." OnChange="JavaScript:doCallAjax('product_c6','product_id6','product_name6','unit_name6','product_price6','discount_unit6','warranty6');"/> 
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

<input type='text' name = "product_codet7"  id = "product_codet7" class="w3-input" placeholder="Search รหัสสินค้า..."OnChange="JavaScript:doCallAjax('product_codet7','product_id7','product_name7','unit_name7','product_price7','discount_unit7','warranty7');"/> 
<input type='hidden' name = "h_product_codet7"  id = "h_product_codet7"  class="w3-input" readonly>

<input type='text' name = "product_code7"  id = "product_code7" class="w3-input" placeholder="Search ชื่ออังกฤษ..." OnChange="JavaScript:doCallAjax('product_code7','product_id7','product_name7','unit_name7','product_price7','discount_unit7','warranty7');"/> 
<input type='hidden' name = "h_product_code7"  id = "h_product_code7"  class="w3-input" readonly>
	
<input type='text' name = "product_c7"  id = "product_c7" class="w3-input" placeholder="Search ชื่อไทย..." OnChange="JavaScript:doCallAjax('product_c7','product_id7','product_name7','unit_name7','product_price7','discount_unit7','warranty7');"/> 
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

<input type='text' name = "product_codet8"  id = "product_codet8" class="w3-input" placeholder="Search รหัสสินค้า..."OnChange="JavaScript:doCallAjax('product_codet8','product_id8','product_name8','unit_name8','product_price8','discount_unit8','warranty8');"/> 
<input type='hidden' name = "h_product_codet8"  id = "h_product_codet8"  class="w3-input" readonly>	

<input type='text' name = "product_code8"  id = "product_code8" class="w3-input" placeholder="Search ชื่ออังกฤษ..." OnChange="JavaScript:doCallAjax('product_code8','product_id8','product_name8','unit_name8','product_price8','discount_unit8','warranty8');"/> 
<input type='hidden' name = "h_product_code8"  id = "h_product_code8"  class="w3-input" readonly>
	
<input type='text' name = "product_c8"  id = "product_c8" class="w3-input" placeholder="Search ชื่อไทย..." OnChange="JavaScript:doCallAjax('product_c8','product_id8','product_name8','unit_name8','product_price8','discount_unit8','warranty8');"/> 
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
<input type='text' name = "product_codet9"  id = "product_codet9" class="w3-input" placeholder="Search รหัสสินค้า..."OnChange="JavaScript:doCallAjax('product_codet9','product_id9','product_name9','unit_name9','product_price9','discount_unit9','warranty9');"/> 
<input type='hidden' name = "h_product_codet9"  id = "h_product_codet9"  class="w3-input" readonly>	

<input type='text' name = "product_code9"  id = "product_code9" class="w3-input" placeholder="Search ชื่ออังกฤษ..." OnChange="JavaScript:doCallAjax('product_code9','product_id9','product_name9','unit_name9','product_price9','discount_unit9','warranty9');"/> 
<input type='hidden' name = "h_product_code9"  id = "h_product_code9"  class="w3-input" readonly>
	
<input type='text' name = "product_c9"  id = "product_c9" class="w3-input" placeholder="Search ชื่อไทย..." OnChange="JavaScript:doCallAjax('product_c9','product_id9','product_name9','unit_name9','product_price9','discount_unit9','warranty9');"/> 
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
<input type='text' name = "product_codet10"  id = "product_codet10" class="w3-input" placeholder="Search รหัสสินค้า..."OnChange="JavaScript:doCallAjax('product_codet10','product_id10','product_name10','unit_name10','product_price10','discount_unit10','warranty10');"/> 
<input type='hidden' name = "h_product_codet10"  id = "h_product_codet10"  class="w3-input" readonly>	

<input type='text' name = "product_code10"  id = "product_code10" class="w3-input" placeholder="Search ชื่ออังกฤษ..." OnChange="JavaScript:doCallAjax('product_code10','product_id10','product_name10','unit_name10','product_price10','discount_unit10','warranty10');"/> 
<input type='hidden' name = "h_product_code10"  id = "h_product_code10"  class="w3-input" readonly>
	
<input type='text' name = "product_c10"  id = "product_c10" class="w3-input" placeholder="Search ชื่อไทย..." OnChange="JavaScript:doCallAjax('product_c10','product_id10','product_name10','unit_name10','product_price10','discount_unit10','warranty10');"/> 
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
<input type='hidden' name = "h_product_codet11"  id = "h_product_codet11"  class="w3-input" readonly>	

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
<input type='hidden' name = "h_product_codet12"  id = "h_product_codet12"  class="w3-input" readonly>	

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
<input type='hidden' name = "h_product_codet13"  id = "h_product_codet13"  class="w3-input" readonly>	

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
<input type='hidden' name = "h_product_codet14"  id = "h_product_codet14"  class="w3-input" readonly>	

<input type='text' name = "product_code14"  id = "product_code14" class="w3-input" placeholder="Search ชื่ออังกฤษ..."    OnChange="JavaScript:doCallAjax('product_code14','product_id14','product_name14','unit_name14','product_price14','discount_unit14','warranty14');"/> 
<input type='hidden' name = "h_product_code14"  id = "h_product_code14"  class="w3-input" readonly>
	
<input type='text' name = "product_c14"  id = "product_c14" class="w3-input" placeholder="Search ชื่อไทย..."    OnChange="JavaScript:doCallAjax('product_c14','product_id14','product_name14','unit_name14','product_price14','discount_unit14','warranty14');"/> 
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
<input type='hidden' name = "h_product_codet15"  id = "h_product_codet15"  class="w3-input" readonly>	

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



</div>



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
		return "data_pro_admdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemocd.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemocd.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemocd.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemocd.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemocd.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemocd.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemocd.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemocd.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemocd.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemocd.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_admdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c15","h_product_c15");
        </script>
		


