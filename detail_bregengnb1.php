<html>
<head>
<!--link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script-->


</head>

<script type="text/javascript">
function ck_frms(){
var ck = document.getElementById('ckks');
if(ck.checked == true){
document.getElementById('frm_txts').style.display = "";
}else{
document.getElementById('frm_txts').style.display = "none";
}

}





</script>



<script language="JavaScript">
var HttPRequest = false;
function doCallAjax2(product_code,product_id,product_name,unit_name,type_probd) {
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
document.getElementById(type_probd).value = myArr[6];	
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

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>
	<th>ประเภทสินค้า</th>
	
<tbody>

<tr>
<td style="width:10%;">
<input type='text' name = "product_codet_1"  id = "product_codet_1" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax2('product_codet_1','product_id_1','product_name_1','unit_name_1','type_probd_1');"/> 
<input type='hidden' name = "h_product_codet_1"  id = "h_product_codet_1"  class="button4" readonly>

<input type='text' name = "product_code_1"  id = "product_code_1" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax2('product_code_1','product_id_1','product_name_1','unit_name_1','type_probd_1');"/> 
<input type='hidden' name = "h_product_code_1"  id = "h_product_code_1"  class="button4" readonly>
	
<input type='text' name = "product_c_1"  id = "product_c_1" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax2('product_c_1','product_id_1','product_name_1','unit_name_1','type_probd_1');"/> 
<input type='hidden' name = "h_product_c_1"  id = "h_product_c_1"  class="button4" readonly>	
<input type='hidden' name = "product_id_1"  id = "product_id_1" class="w3-input" />

</td>
<td  style="width:15%;">
<textarea  name = "product_name_1"  id = "product_name_1"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_1"  id = "unit_name_1"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_1" id = "sale_count_1"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_1"  id = "sn_number_1"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_1"  id = "remark_eng_1"  class="w3-input" ></textarea>
</td>

<td style="width:8%;">
<input type='text'  name = "type_probd_1"  id = "type_probd_1"  class="w3-input" readonly>
</td>

<td style="width:2%;">
<a onclick="document.getElementById('product_code_1').value = '';
document.getElementById('product_name_1').value  = ''; 
document.getElementById('unit_name_1').value  = '';
document.getElementById('product_codet_1').value  = '';
document.getElementById('product_id_1').value  = '';
document.getElementById('product_c_1').value  = '';
document.getElementById('sale_count_1').value  = '';
document.getElementById('sn_number_1').value  = '';
document.getElementById('remark_eng_1').value  = '';
document.getElementById('type_probd_1').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>

</tr>


<tr>
<td style="width:10%;">
<input type='text' name = "product_codet_2"  id = "product_codet_2" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax2('product_codet_2','product_id_2','product_name_2','unit_name_2','type_probd_2');"/> 
<input type='hidden' name = "h_product_codet_2"  id = "h_product_codet_2"  class="button4" readonly>

<input type='text' name = "product_code_2"  id = "product_code_2" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax2('product_code_2','product_id_2','product_name_2','unit_name_2','type_probd_2');"/> 
<input type='hidden' name = "h_product_code_2"  id = "h_product_code_2"  class="button4" readonly>
	
<input type='text' name = "product_c_2"  id = "product_c_2" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax2('product_c_2','product_id_2','product_name_2','unit_name_2','type_probd_2');"/> 
<input type='hidden' name = "h_product_c_2"  id = "h_product_c_2"  class="button4" readonly>	
<input type='hidden' name = "product_id_2"  id = "product_id_2" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name_2"  id = "product_name_2"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_2"  id = "unit_name_2"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_2" id = "sale_count_2"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_2"  id = "sn_number_2"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_2"  id = "remark_eng_2"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<input type='text'  name = "type_probd_2"  id = "type_probd_2"  class="w3-input" readonly>
</td>

<td style="width:2%;">
<a onclick="document.getElementById('product_code_2').value = '';
document.getElementById('product_name_2').value  = ''; 
document.getElementById('unit_name_2').value  = '';
document.getElementById('product_codet_2').value  = '';
document.getElementById('product_id_2').value  = '';
document.getElementById('product_c_2').value  = '';
document.getElementById('sale_count_2').value  = '';
document.getElementById('sn_number_2').value  = '';
document.getElementById('remark_eng_2').value  = '';
document.getElementById('type_probd_2').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>

</tr>



<tr>
<td style="width:10%;">
<input type='text' name = "product_codet_3"  id = "product_codet_3" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax2('product_codet_3','product_id_3','product_name_3','unit_name_3','type_probd_3');"/> 
<input type='hidden' name = "h_product_codet_3"  id = "h_product_codet_3"  class="button4" readonly>

<input type='text' name = "product_code_3"  id = "product_code_3" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax2('product_code_3','product_id_3','product_name_3','unit_name_3','type_probd_3');"/> 
<input type='hidden' name = "h_product_code_3"  id = "h_product_code_3"  class="button4" readonly>
	
<input type='text' name = "product_c_3"  id = "product_c_3" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax2('product_c_3','product_id_3','product_name_3','unit_name_3','type_probd_3');"/> 
<input type='hidden' name = "h_product_c_3"  id = "h_product_c_3"  class="button4" readonly>	
<input type='hidden' name = "product_id_3"  id = "product_id_3" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name_3"  id = "product_name_3"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_3"  id = "unit_name_3"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_3" id = "sale_count_3"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_3"  id = "sn_number_3"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_3"  id = "remark_eng_3"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<input type='text'  name = "type_probd_3"  id = "type_probd_3"  class="w3-input" readonly>
</td>

<td style="width:2%;">
<a onclick="document.getElementById('product_code_3').value = '';
document.getElementById('product_name_3').value  = ''; 
document.getElementById('unit_name_3').value  = '';
document.getElementById('product_codet_3').value  = '';
document.getElementById('product_id_3').value  = '';
document.getElementById('product_c_3').value  = '';
document.getElementById('sale_count_3').value  = '';
document.getElementById('sn_number_3').value  = '';
document.getElementById('remark_eng_3').value  = '';
document.getElementById('type_probd_3').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>

</tr>


<tr>
<td style="width:10%;">
<input type='text' name = "product_codet_4"  id = "product_codet_4" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax2('product_codet_4','product_id_4','product_name_4','unit_name_4','type_probd_4');"/> 
<input type='hidden' name = "h_product_codet_4"  id = "h_product_codet_4"  class="button4" readonly>

<input type='text' name = "product_code_4"  id = "product_code_4" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax2('product_code_4','product_id_4','product_name_4','unit_name_4','type_probd_4');"/> 
<input type='hidden' name = "h_product_code_4"  id = "h_product_code_4"  class="button4" readonly>
	
<input type='text' name = "product_c_4"  id = "product_c_4" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax2('product_c_4','product_id_4','product_name_4','unit_name_4','type_probd_4');"/> 
<input type='hidden' name = "h_product_c_4"  id = "h_product_c_4"  class="button4" readonly>	
<input type='hidden' name = "product_id_4"  id = "product_id_4" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name_4"  id = "product_name_4"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_4"  id = "unit_name_4"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_4" id = "sale_count_4"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_4"  id = "sn_number_4"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_4"  id = "remark_eng_4"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<input type='text'  name = "type_probd_4"  id = "type_probd_4"  class="w3-input" readonly>
</td>

<td style="width:2%;">
<a onclick="document.getElementById('product_code_4').value = '';
document.getElementById('product_name_4').value  = ''; 
document.getElementById('unit_name_4').value  = '';
document.getElementById('product_codet_4').value  = '';
document.getElementById('product_id_4').value  = '';
document.getElementById('product_c_4').value  = '';
document.getElementById('sale_count_4').value  = '';
document.getElementById('sn_number_4').value  = '';
document.getElementById('remark_eng_4').value  = '';
document.getElementById('type_probd_4').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>

</tr>


<tr>
<td style="width:10%;">
<input type='text' name = "product_codet_5"  id = "product_codet_5" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax2('product_codet_5','product_id_5','product_name_5','unit_name_5','type_probd_5');"/> 
<input type='hidden' name = "h_product_codet_5"  id = "h_product_codet_5"  class="button4" readonly>

<input type='text' name = "product_code_5"  id = "product_code_5" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax2('product_code_5','product_id_5','product_name_5','unit_name_5','type_probd_5');"/> 
<input type='hidden' name = "h_product_code_5"  id = "h_product_code_5"  class="button4" readonly>
	
<input type='text' name = "product_c_5"  id = "product_c_5" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax2('product_c_5','product_id_5','product_name_5','unit_name_5','type_probd_5');"/> 
<input type='hidden' name = "h_product_c_5"  id = "h_product_c_5"  class="button4" readonly>	
<input type='hidden' name = "product_id_5"  id = "product_id_5" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name_5"  id = "product_name_5"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_5"  id = "unit_name_5"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_5" id = "sale_count_5"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_5"  id = "sn_number_5"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_5"  id = "remark_eng_5"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<input type='text'  name = "type_probd_5"  id = "type_probd_5"  class="w3-input" readonly>
</td>

<td style="width:2%;">
<a onclick="document.getElementById('product_code_5').value = '';
document.getElementById('product_name_5').value  = ''; 
document.getElementById('unit_name_5').value  = '';
document.getElementById('product_codet_5').value  = '';
document.getElementById('product_id_5').value  = '';
document.getElementById('product_c_5').value  = '';
document.getElementById('sale_count_5').value  = '';
document.getElementById('sn_number_5').value  = '';
document.getElementById('remark_eng_5').value  = '';
document.getElementById('type_probd_5').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>

</tr>





</tbody>
</table>

 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckks" id="ckks" onClick="ck_frms();" value="1"/>เพิ่มเติม<br/>
<div id="frm_txts" style="display:none;">


<table width="100%" border="0" class="w3-table">
<thead>



<tr>
<td style="width:10%;">
<input type='text' name = "product_codet_6"  id = "product_codet_6" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax2('product_codet_6','product_id_6','product_name_6','unit_name_6','type_probd_6');"/> 
<input type='hidden' name = "h_product_codet_6"  id = "h_product_codet_6"  class="button4" readonly>

<input type='text' name = "product_code_6"  id = "product_code_6" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax2('product_code_6','product_id_6','product_name_6','unit_name_6','type_probd_6');"/> 
<input type='hidden' name = "h_product_code_6"  id = "h_product_code_6"  class="button4" readonly>
	
<input type='text' name = "product_c_6"  id = "product_c_6" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax2('product_c_6','product_id_6','product_name_6','unit_name_6','type_probd_6');"/> 
<input type='hidden' name = "h_product_c_6"  id = "h_product_c_6"  class="button4" readonly>	
<input type='hidden' name = "product_id_6"  id = "product_id_6" class="w3-input" />

</td>
<td  style="width:15%;">
<textarea  name = "product_name_6"  id = "product_name_6"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_6"  id = "unit_name_6"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_6" id = "sale_count_6"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_6"  id = "sn_number_6"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_6"  id = "remark_eng_6"  class="w3-input" ></textarea>
</td>

<td style="width:8%;">
<input type='text'  name = "type_probd_6"  id = "type_probd_6"  class="w3-input" readonly>
</td>

<td style="width:2%;">
<a onclick="document.getElementById('product_code_6').value = '';
document.getElementById('product_name_6').value  = ''; 
document.getElementById('unit_name_6').value  = '';
document.getElementById('product_codet_6').value  = '';
document.getElementById('product_id_6').value  = '';
document.getElementById('product_c_6').value  = '';
document.getElementById('sale_count_6').value  = '';
document.getElementById('sn_number_6').value  = '';
document.getElementById('remark_eng_6').value  = '';
document.getElementById('type_probd_6').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>

</tr>


<tr>
<td style="width:10%;">
<input type='text' name = "product_codet_7"  id = "product_codet_7" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax2('product_codet_7','product_id_7','product_name_7','unit_name_7','type_probd_7');"/> 
<input type='hidden' name = "h_product_codet_7"  id = "h_product_codet_7"  class="button4" readonly>

<input type='text' name = "product_code_7"  id = "product_code_7" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax2('product_code_7','product_id_7','product_name_7','unit_name_7','type_probd_7');"/> 
<input type='hidden' name = "h_product_code_7"  id = "h_product_code_7"  class="button4" readonly>
	
<input type='text' name = "product_c_7"  id = "product_c_7" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax2('product_c_7','product_id_7','product_name_7','unit_name_7','type_probd_7');"/> 
<input type='hidden' name = "h_product_c_7"  id = "h_product_c_7"  class="button4" readonly>	
<input type='hidden' name = "product_id_7"  id = "product_id_7" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name_7"  id = "product_name_7"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_7"  id = "unit_name_7"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_7" id = "sale_count_7"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_7"  id = "sn_number_7"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_7"  id = "remark_eng_7"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<input type='text'  name = "type_probd_7"  id = "type_probd_7"  class="w3-input" readonly>
</td>

<td style="width:2%;">
<a onclick="document.getElementById('product_code_7').value = '';
document.getElementById('product_name_7').value  = ''; 
document.getElementById('unit_name_7').value  = '';
document.getElementById('product_codet_7').value  = '';
document.getElementById('product_id_7').value  = '';
document.getElementById('product_c_7').value  = '';
document.getElementById('sale_count_7').value  = '';
document.getElementById('sn_number_7').value  = '';
document.getElementById('remark_eng_7').value  = '';
document.getElementById('type_probd_7').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>

</tr>


<tr>
<td style="width:10%;">
<input type='text' name = "product_codet_8"  id = "product_codet_8" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax2('product_codet_8','product_id_8','product_name_8','unit_name_8','type_probd_8');"/> 
<input type='hidden' name = "h_product_codet_8"  id = "h_product_codet_8"  class="button4" readonly>

<input type='text' name = "product_code_8"  id = "product_code_8" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax2('product_code_8','product_id_8','product_name_8','unit_name_8','type_probd_8');"/> 
<input type='hidden' name = "h_product_code_8"  id = "h_product_code_8"  class="button4" readonly>
	
<input type='text' name = "product_c_8"  id = "product_c_8" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax2('product_c_8','product_id_8','product_name_8','unit_name_8','type_probd_8');"/> 
<input type='hidden' name = "h_product_c_8"  id = "h_product_c_8"  class="button4" readonly>	
<input type='hidden' name = "product_id_8"  id = "product_id_8" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name_8"  id = "product_name_8"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_8"  id = "unit_name_8"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_8" id = "sale_count_8"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_8"  id = "sn_number_8"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_8"  id = "remark_eng_8"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<input type='text'  name = "type_probd_8"  id = "type_probd_8"  class="w3-input" readonly>
</td>

<td style="width:2%;">
<a onclick="document.getElementById('product_code_8').value = '';
document.getElementById('product_name_8').value  = ''; 
document.getElementById('unit_name_8').value  = '';
document.getElementById('product_codet_8').value  = '';
document.getElementById('product_id_8').value  = '';
document.getElementById('product_c_8').value  = '';
document.getElementById('sale_count_8').value  = '';
document.getElementById('sn_number_8').value  = '';
document.getElementById('remark_eng_8').value  = '';
document.getElementById('type_probd_8').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>

</tr>


<tr>
<td style="width:10%;">
<input type='text' name = "product_codet_9"  id = "product_codet_9" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax2('product_codet_9','product_id_9','product_name_9','unit_name_9','type_probd_9');"/> 
<input type='hidden' name = "h_product_codet_9"  id = "h_product_codet_9"  class="button4" readonly>

<input type='text' name = "product_code_9"  id = "product_code_9" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax2('product_code_9','product_id_9','product_name_9','unit_name_9','type_probd_9');"/> 
<input type='hidden' name = "h_product_code_9"  id = "h_product_code_9"  class="button4" readonly>
	
<input type='text' name = "product_c_9"  id = "product_c_9" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax2('product_c_9','product_id_9','product_name_9','unit_name_9','type_probd_9');"/> 
<input type='hidden' name = "h_product_c_9"  id = "h_product_c_9"  class="button4" readonly>	
<input type='hidden' name = "product_id_9"  id = "product_id_9" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name_9"  id = "product_name_9"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_9"  id = "unit_name_9"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_9" id = "sale_count_9"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_9"  id = "sn_number_9"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_9"  id = "remark_eng_9"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<input type='text'  name = "type_probd_9"  id = "type_probd_9"  class="w3-input" readonly>
</td>

<td style="width:2%;">
<a onclick="document.getElementById('product_code_9').value = '';
document.getElementById('product_name_9').value  = ''; 
document.getElementById('unit_name_9').value  = '';
document.getElementById('product_codet_9').value  = '';
document.getElementById('product_id_9').value  = '';
document.getElementById('product_c_9').value  = '';
document.getElementById('sale_count_9').value  = '';
document.getElementById('sn_number_9').value  = '';
document.getElementById('remark_eng_9').value  = '';
document.getElementById('type_probd_9').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>

</tr>



<tr>
<td style="width:10%;">
<input type='text' name = "product_codet_10"  id = "product_codet_10" class="w3-input" placeholder="Search รหัสสินค้า..." OnChange="JavaScript:doCallAjax2('product_codet_10','product_id_10','product_name_10','unit_name_10','type_probd_10');"/> 
<input type='hidden' name = "h_product_codet_10"  id = "h_product_codet_10"  class="button4" readonly>

<input type='text' name = "product_code_10"  id = "product_code_10" class="w3-input" placeholder="Search ชื่ออังกฤษ..."   OnChange="JavaScript:doCallAjax2('product_code_10','product_id_10','product_name_10','unit_name_10','type_probd_10');"/> 
<input type='hidden' name = "h_product_code_10"  id = "h_product_code_10"  class="button4" readonly>
	
<input type='text' name = "product_c_10"  id = "product_c_10" class="w3-input" placeholder="Search ชื่อไทย..."   OnChange="JavaScript:doCallAjax2('product_c_10','product_id_10','product_name_10','unit_name_10','type_probd_10');"/> 
<input type='hidden' name = "h_product_c_10"  id = "h_product_c_10"  class="button4" readonly>	
<input type='hidden' name = "product_id_10"  id = "product_id_10" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name_10"  id = "product_name_10"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_10"  id = "unit_name_10"  class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_10" id = "sale_count_10"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_10"  id = "sn_number_10"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_10"  id = "remark_eng_10"  class="w3-input" ></textarea>
</td>

<td style="width:10%;">
<input type='text'  name = "type_probd_10"  id = "type_probd_10"  class="w3-input" readonly>
</td>

<td style="width:2%;">
<a onclick="document.getElementById('product_code_10').value = '';
document.getElementById('product_name_10').value  = ''; 
document.getElementById('unit_name_10').value  = '';
document.getElementById('product_codet_10').value  = '';
document.getElementById('product_id_10').value  = '';
document.getElementById('product_c_10').value  = '';
document.getElementById('sale_count_10').value  = '';
document.getElementById('sn_number_10').value  = '';
document.getElementById('remark_eng_10').value  = '';
document.getElementById('type_probd_10').value  = '';

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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code_1","h_product_code_1");
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code_2","h_product_code_2");
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code_3","h_product_code_3");
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code_4","h_product_code_4");
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code_5","h_product_code_5");
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code_6","h_product_code_6");
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code_7","h_product_code_7");
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code_8","h_product_code_8");
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code_9","h_product_code_9");
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code_10","h_product_code_10");
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet_1","h_product_codet_1");
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet_2","h_product_codet_2");
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet_3","h_product_codet_3");
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet_4","h_product_codet_4");
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet_5","h_product_codet_5");
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet_6","h_product_codet_6");
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet_7","h_product_codet_7");
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet_8","h_product_codet_8");
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet_9","h_product_codet_9");
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet_10","h_product_codet_10");
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c_1","h_product_c_1");
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c_2","h_product_c_2");
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c_3","h_product_c_3");
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c_4","h_product_c_4");
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c_5","h_product_c_5");
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c_6","h_product_c_6");
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c_7","h_product_c_7");
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c_8","h_product_c_8");
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c_9","h_product_c_9");
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c_10","h_product_c_10");
        </script>

