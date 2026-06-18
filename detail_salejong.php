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



</script>



<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_code,product_id,product_name,unit_name,product_price,discount_unit) {
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
    <th>จำนวน</th>
    <th>หน่วย</th>
	 <th>หมายเหตุ</th>

<tbody>
<tr>
<td style="width:10%;">

<input type='text' name = "product_codet1"  id = "product_codet1" class="w3-input" placeholder="Search รหัสสินค้า"  size="7" OnChange="JavaScript:doCallAjax('product_codet1','product_id1','product_name1','unit_name1');"/> 
<input type='hidden' name = "h_product_codet1"  id = "h_product_codet1"  class="button4" readonly>


<input type='text' name = "product_code1"  id = "product_code1" class="w3-input" placeholder="Search ชื่อสินค้าอังกฤษ"  size="7" OnChange="JavaScript:doCallAjax('product_code1','product_id1','product_name1','unit_name1');"/> 
<input type='hidden' name = "h_product_code1"  id = "h_product_code1"  class="button4" readonly>
	
<input type='text' name = "product_c1"  id = "product_c1" class="w3-input" placeholder="Search ชื่อสินค้าไทย"  size="7" OnChange="JavaScript:doCallAjax('product_c1','product_id1','product_name1','unit_name1');"/> 
<input type='hidden' name = "h_product_c1"  id = "h_product_c1"  class="button4" readonly>	
<input type='hidden' name = "product_id1"  id = "product_id1" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name1"  id = "product_name1"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count1" id = "sale_count1"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1"  id = "unit_name1"  class="w3-input" readonly/>
</td>

<td style="width:10%;">
<textarea name = "sale_remarkk1"  id = "sale_remarkk1"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code1').value = '';

document.getElementById('product_name1').value  = ''; 
document.getElementById('unit_name1').value  = '';
document.getElementById('sale_count1').value  = '';
document.getElementById('product_codet1').value  = '';
document.getElementById('product_id1').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>

<tr>
<td style="width:10%;">

<input type='text' name = "product_codet2"  id = "product_codet2" class="w3-input" placeholder="Search รหัสสินค้า" size="7"  OnChange="JavaScript:doCallAjax('product_codet2','product_id2','product_name2','unit_name2');"/> 
<input type='hidden' name = "h_product_codet2"  id = "h_product_codet2"  class="w3-input" readonly>

<input type='text' name = "product_code2"  id = "product_code2" class="w3-input" placeholder="Search ชื่อสินค้าอังกฤษ..." size="7" OnChange="JavaScript:doCallAjax('product_code2','product_id2','product_name2','unit_name2');"/> 
<input type='hidden' name = "h_product_code2"  id = "h_product_code2"  class="w3-input" readonly>
	
<input type='text' name = "product_c2"  id = "product_c2" class="w3-input" placeholder="Search ชื่อสินค้าไทย..." size="7" OnChange="JavaScript:doCallAjax('product_c2','product_id2','product_name2','unit_name2');"/> 
<input type='hidden' name = "h_product_c2"  id = "h_product_c2"  class="w3-input" readonly>	
<input type='hidden' name = "product_id2"  id = "product_id2" class="w3-input" />

</td>
<td style="width:15%;">
<textarea name = "product_name2"  id = "product_name2"  class="w3-input" rows="2" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count2"  id = "sale_count2"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:5%;">
<input type='text' name = "unit_name2"  id = "unit_name2"  class="w3-input" readonly/>
</td>

<td style="width:10%;">
<textarea name = "sale_remarkk2"  id = "sale_remarkk2"  class="w3-input" ></textarea>
</td>


<td><a onclick="document.getElementById('product_code2').value = '';
document.getElementById('product_name2').value  = ''; 
document.getElementById('unit_name2').value  = '';
document.getElementById('sale_count2').value  = '';
document.getElementById('product_codet2').value  = '';
document.getElementById('product_id2').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>



</tr>

<tr>
<td >

<input type='text' name = "product_codet3"  id = "product_codet3" class="w3-input" placeholder="Search รหัสสินค้า" size="7"  OnChange="JavaScript:doCallAjax('product_codet3','product_id3','product_name3','unit_name3');"/> 
<input type='hidden' name = "h_product_codet3"  id = "h_product_codet3"  class="w3-input" readonly>

<input type='text' name = "product_code3"  id = "product_code3" class="w3-input" placeholder="Search ชื่อสินค้าอังกฤษ..."  size="7" OnChange="JavaScript:doCallAjax('product_code3','product_id3','product_name3','unit_name3');"/> 
<input type='hidden' name = "h_product_code3"  id = "h_product_code3"  class="w3-input" readonly>
	
<input type='text' name = "product_c3"  id = "product_c3" class="w3-input" placeholder="Search ชื่อสินค้าไทย..."  size="7" OnChange="JavaScript:doCallAjax('product_c3','product_id3','product_name3','unit_name3');"/> 
<input type='hidden' name = "h_product_c3"  id = "h_product_c3"  class="w3-input" readonly>	
<input type='hidden' name = "product_id3"  id = "product_id3" class="w3-input" />

</td>
<td>
<textarea name = "product_name3"  id = "product_name3"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "sale_count3"  id = "sale_count3"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "unit_name3"  id = "unit_name3"  class="w3-input" readonly/>
</td>

<td style="width:10%;">
<textarea name = "sale_remarkk3"  id = "sale_remarkk3"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code3').value = '';
document.getElementById('product_name3').value  = ''; 
document.getElementById('unit_name3').value  = '';
document.getElementById('sale_count3').value  = '';
document.getElementById('product_codet3').value  = '';
document.getElementById('product_id3').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td >

<input type='text' name = "product_codet4"  id = "product_codet4" class="w3-input" placeholder="Search รหัสสินค้า" size="7"  OnChange="JavaScript:doCallAjax('product_codet4','product_id4','product_name4','unit_name4');"/> 
<input type='hidden' name = "h_product_codet4"  id = "h_product_codet4"  class="w3-input" readonly>

<input type='text' name = "product_code4"  id = "product_code4" class="w3-input" placeholder="Search ชื่อสินค้าอังกฤษ..."  size="7" OnChange="JavaScript:doCallAjax('product_code4','product_id4','product_name4','unit_name4');"/> 
<input type='hidden' name = "h_product_code4"  id = "h_product_code4"  class="w3-input" readonly>
	
<input type='text' name = "product_c4"  id = "product_c4" class="w3-input" placeholder="Search ชื่อสินค้าไทย..."  size="7" OnChange="JavaScript:doCallAjax('product_c4','product_id4','product_name4','unit_name4');"/> 
<input type='hidden' name = "h_product_c4"  id = "h_product_c4"  class="w3-input" readonly>	
<input type='hidden' name = "product_id4"  id = "product_id4" class="w3-input" />

</td>
<td>
<textarea  name = "product_name4"  id = "product_name4"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "sale_count4"  id = "sale_count4"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "unit_name4"  id = "unit_name4"  class="w3-input" readonly/>
</td>
<td style="width:10%;">
<textarea name = "sale_remarkk4"  id = "sale_remarkk4"  class="w3-input" ></textarea>
</td>


<td><a onclick="document.getElementById('product_code4').value = '';
document.getElementById('product_name4').value  = ''; 
document.getElementById('unit_name4').value  = '';
document.getElementById('sale_count4').value  = '';
document.getElementById('product_codet4').value  = '';
document.getElementById('product_id4').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td >

<input type='text' name = "product_codet5"  id = "product_codet5" class="w3-input" placeholder="Search รหัสสินค้า" size="7"  OnChange="JavaScript:doCallAjax('product_codet5','product_id5','product_name5','unit_name5');"/> 
<input type='hidden' name = "h_product_codet5"  id = "h_product_codet5"  class="w3-input" readonly>

<input type='text' name = "product_code5"  id = "product_code5" class="w3-input" placeholder="Search ชื่อสินค้าอังกฤษ..."  size="7" OnChange="JavaScript:doCallAjax('product_code5','product_id5','product_name5','unit_name5');"/> 
<input type='hidden' name = "h_product_code5"  id = "h_product_code5"  class="w3-input" readonly>
	
<input type='text' name = "product_c5"  id = "product_c5" class="w3-input" placeholder="Search ชื่อสินค้าไทย..."  size="7" OnChange="JavaScript:doCallAjax('product_c5','product_id5','product_name5','unit_name5');"/> 
<input type='hidden' name = "h_product_c5"  id = "h_product_c5"  class="w3-input" readonly>	
<input type='hidden' name = "product_id5"  id = "product_id5" class="w3-input" />

</td>
<td>
<textarea  name = "product_name5"  id = "product_name5"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "sale_count5"  id = "sale_count5"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "unit_name5"  id = "unit_name5"  class="w3-input" readonly/>
</td>
	
<td style="width:10%;">
<textarea name = "sale_remarkk5"  id = "sale_remarkk5"  class="w3-input" ></textarea>
</td>


<td><a onclick="document.getElementById('product_code5').value = '';
document.getElementById('product_name5').value  = ''; 
document.getElementById('unit_name5').value  = '';
document.getElementById('sale_count5').value  = '';
document.getElementById('product_codet5').value  = '';
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
<td  style="width:10%;">
<input type='text' name = "product_codet6"  id = "product_codet6" class="w3-input" placeholder="Search รหัสสินค้า" size="7"  OnChange="JavaScript:doCallAjax('product_codet6','product_id6','product_name6','unit_name6');"/> 
<input type='hidden' name = "h_product_codet6"  id = "h_product_codet6"  class="w3-input" readonly>

<input type='text' name = "product_code6"  id = "product_code6" size="7" class="w3-input" placeholder="Search ชื่อสินค้าอังกฤษ..." OnChange="JavaScript:doCallAjax('product_code6','product_id6','product_name6','unit_name6');"/> 
<input type='hidden' name = "h_product_code6"  id = "h_product_code6"  class="w3-input" readonly>
	
<input type='text' name = "product_c6"  id = "product_c6" size="7" class="w3-input" placeholder="Search ชื่อสินค้าไทย..." OnChange="JavaScript:doCallAjax('product_c6','product_id6','product_name6','unit_name6');"/> 
<input type='hidden' name = "h_product_c6"  id = "h_product_c6"  class="w3-input" readonly>	
<input type='hidden' name = "product_id6"  id = "product_id6" class="w3-input" />

</td>
<td style="width:15%;">
<textarea  name = "product_name6"  id = "product_name6"  class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count6"  id = "sale_count6"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:5%;">
<input type='text' name = "unit_name6"  id = "unit_name6"  class="w3-input" readonly/>
</td>

<td style="width:10%;">
<textarea name = "sale_remarkk6"  id = "sale_remarkk6"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code6').value = '';
document.getElementById('product_name6').value  = ''; 
document.getElementById('unit_name6').value  = '';
document.getElementById('sale_count6').value  = '';
document.getElementById('product_codet6').value  = '';
document.getElementById('product_id6').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td style="width:10%;">

<input type='text' name = "product_codet7"  id = "product_codet7" class="w3-input" placeholder="Search รหัสสินค้า" size="7"  OnChange="JavaScript:doCallAjax('product_codet7','product_id7','product_name7','unit_name7');"/> 
<input type='hidden' name = "h_product_codet7"  id = "h_product_codet7"  class="w3-input" readonly>

<input type='text' name = "product_code7"  id = "product_code7" class="w3-input" placeholder="Search ชื่อสินค้าอังกฤษ..." size="7" OnChange="JavaScript:doCallAjax('product_code7','product_id7','product_name7','unit_name7');"/> 
<input type='hidden' name = "h_product_code7"  id = "h_product_code7"  class="w3-input" readonly>
	
<input type='text' name = "product_c7"  id = "product_c7" class="w3-input" placeholder="Search ชื่อสินค้าไทย..." size="7" OnChange="JavaScript:doCallAjax('product_c7','product_id7','product_name7','unit_name7');"/> 
<input type='hidden' name = "h_product_c7"  id = "h_product_c7"  class="w3-input" readonly>	
<input type='hidden' name = "product_id7"  id = "product_id7" class="w3-input" />

</td>
<td style="width:15%;">
<textarea name = "product_name7"  id = "product_name7"  class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count7"  id = "sale_count7"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:5%;">
<input type='text' name = "unit_name7"  id = "unit_name7"  class="w3-input" readonly/>
</td>

<td style="width:10%;">
<textarea name = "sale_remarkk7"  id = "sale_remarkk7"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code7').value = '';
document.getElementById('product_name7').value  = ''; 
document.getElementById('unit_name7').value  = '';
document.getElementById('sale_count7').value  = '';
document.getElementById('product_codet7').value  = '';
document.getElementById('product_id7').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td >

<input type='text' name = "product_codet8"  id = "product_codet8" class="w3-input" placeholder="Search รหัสสินค้า" size="7"  OnChange="JavaScript:doCallAjax('product_codet8','product_id8','product_name8','unit_name8');"/> 
<input type='hidden' name = "h_product_codet8"  id = "h_product_codet8"  class="w3-input" readonly>

<input type='text' name = "product_code8"  id = "product_code8" class="w3-input" placeholder="Search ชื่อสินค้าอังกฤษ..."  size="7" OnChange="JavaScript:doCallAjax('product_code8','product_id8','product_name8','unit_name8');"/> 
<input type='hidden' name = "h_product_code8"  id = "h_product_code8"  class="w3-input" readonly>
	
<input type='text' name = "product_c8"  id = "product_c8" class="w3-input" placeholder="Search ชื่อสินค้าไทย..."  size="7" OnChange="JavaScript:doCallAjax('product_c8','product_id8','product_name8','unit_name8');"/> 
<input type='hidden' name = "h_product_c8"  id = "h_product_c8"  class="w3-input" readonly>	
<input type='hidden' name = "product_id8"  id = "product_id8" class="w3-input" />

</td>
<td>
<textarea name = "product_name8"  id = "product_name8"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "sale_count8"  id = "sale_count8"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "unit_name8"  id = "unit_name8"  class="w3-input" readonly/>
</td>
<td style="width:10%;">
<textarea name = "sale_remarkk8"  id = "sale_remarkk8"  class="w3-input" ></textarea>
</td>


<td><a onclick="document.getElementById('product_code8').value = '';
document.getElementById('product_name8').value  = ''; 
document.getElementById('unit_name8').value  = '';
document.getElementById('sale_count8').value  = '';
document.getElementById('product_codet8').value  = '';
document.getElementById('product_id8').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td >

<input type='text' name = "product_codet9"  id = "product_codet9" class="w3-input" placeholder="Search รหัสสินค้า" size="7"  OnChange="JavaScript:doCallAjax('product_codet9','product_id9','product_name9','unit_name9');"/> 
<input type='hidden' name = "h_product_codet9"  id = "h_product_codet9"  class="w3-input" readonly>

<input type='text' name = "product_code9"  id = "product_code9" class="w3-input" placeholder="Search ชื่อสินค้าอังกฤษ..."  size="7" OnChange="JavaScript:doCallAjax('product_code9','product_id9','product_name9','unit_name9');"/> 
<input type='hidden' name = "h_product_code9"  id = "h_product_code9"  class="w3-input" readonly>
	
<input type='text' name = "product_c9"  id = "product_c9" class="w3-input" placeholder="Search ชื่อสินค้าไทย..."  size="7" OnChange="JavaScript:doCallAjax('product_c9','product_id9','product_name9','unit_name9');"/> 
<input type='hidden' name = "h_product_c9"  id = "h_product_c9"  class="w3-input" readonly>	
<input type='hidden' name = "product_id9"  id = "product_id9" class="w3-input" />

</td>
<td>
<textarea  name = "product_name9"  id = "product_name9"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "sale_count9"  id = "sale_count9"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "unit_name9"  id = "unit_name9"  class="w3-input" readonly/>
</td>
<td style="width:10%;">
<textarea name = "sale_remarkk9"  id = "sale_remarkk9"  class="w3-input" ></textarea>
</td>


<td><a onclick="document.getElementById('product_code9').value = '';
document.getElementById('product_name9').value  = ''; 
document.getElementById('unit_name9').value  = '';
document.getElementById('sale_count9').value  = '';
document.getElementById('product_codet9').value  = '';
document.getElementById('product_id9').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>


</tr>

<tr>
<td >

<input type='text' name = "product_codet10"  id = "product_codet10" class="w3-input" placeholder="Search รหัสสินค้า" size="7"  OnChange="JavaScript:doCallAjax('product_codet10','product_id10','product_name10','unit_name10');"/> 
<input type='hidden' name = "h_product_codet10"  id = "h_product_codet10"  class="w3-input" readonly>

<input type='text' name = "product_code10"  id = "product_code10" class="w3-input" placeholder="Search ชื่อสินค้าอังกฤษ..."  size="7" OnChange="JavaScript:doCallAjax('product_code10','product_id10','product_name10','unit_name10');"/> 
<input type='hidden' name = "h_product_code10"  id = "h_product_code10"  class="w3-input" readonly>
	
<input type='text' name = "product_c10"  id = "product_c10" class="w3-input" placeholder="Search ชื่อสินค้าไทย..."  size="7" OnChange="JavaScript:doCallAjax('product_c10','product_id10','product_name10','unit_name10');"/> 
<input type='hidden' name = "h_product_c10"  id = "h_product_c10"  class="w3-input" readonly>	
<input type='hidden' name = "product_id10"  id = "product_id10" class="w3-input" />

</td>
<td>
<textarea  name = "product_name10"  id = "product_name10"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "sale_count10"  id = "sale_count10"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "unit_name10"  id = "unit_name10"  class="w3-input" readonly/>
</td>
<td style="width:10%;">
<textarea name = "sale_remarkk10"  id = "sale_remarkk10"  class="w3-input" ></textarea>
</td>


<td><a onclick="document.getElementById('product_code10').value = '';
document.getElementById('product_name10').value  = ''; 
document.getElementById('unit_name10').value  = '';
document.getElementById('sale_count10').value  = '';
document.getElementById('product_codet10').value  = '';
document.getElementById('product_id10').value  = '';

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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c10","h_product_c10");
        </script>



