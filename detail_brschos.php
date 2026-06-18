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
<table width="100%" border="0" class="w3-table">

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
	<th>ส่วนลด/หน่วย</th>
    <th>ยอดรวม</th>
	<th>รับประกัน (ปี)</th>
	<th>Cal(ครั้ง/ปี)</th>
	<th>PM (ครั้ง/ปี)</th>
    <th>หมายเหตุ</th>
	
<tbody>
<tr>
<td style="width:10%;">

<input type='text' name = "product_codet1" style="width:100%;" id = "product_codet1" class="button4" placeholder="Search รหัส"  size="7" OnChange="JavaScript:doCallAjax('product_codet1','product_id1','product_name1','unit_name1','product_price1','discount_unit1','warranty1');"/> 
<input type='hidden' name = "h_product_codet1"  id = "h_product_codet1"  class="button4" readonly>


<input type='text' name = "product_code1" style="width:100%;" id = "product_code1" class="button4" placeholder="Search ชื่ออังกฤษ"  size="7" OnChange="JavaScript:doCallAjax('product_code1','product_id1','product_name1','unit_name1','product_price1','discount_unit1','warranty1');"/> 
<input type='hidden' name = "h_product_code1"  id = "h_product_code1"  class="button4" readonly>
	
<input type='text' name = "product_c1" style="width:100%;" id = "product_c1" class="button4" placeholder="Search ชื่อไทย"  size="7" OnChange="JavaScript:doCallAjax('product_c1','product_id1','product_name1','unit_name1','product_price1','discount_unit1','warranty1');"/> 
<input type='hidden' name = "h_product_c1"  id = "h_product_c1"  class="button4" readonly>	
<input type='hidden' name = "product_id1"  id = "product_id1" class="w3-input" />

</td>
<td  style="width:10%;">
<textarea  name = "product_name1"  id = "product_name1" style="width:100%;" rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1" style="width:100%;" id = "unit_name1"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count1" style="width:100%;" id = "sale_count1"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price1" style="width:100%;" id = "product_price1"  class="button4" size="7" style="color:black;text-align:right" />
</td >

<td style="width:8%;"><input type='text' style="width:100%;" name = "discount_unit1" size="5" id = "discount_unit1" class="button4"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' style="width:100%;" name = "sum_amount1"  id = "sum_amount1"  class="button4" size="7" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count1} * {product_price1} - {discount_unit1} * {sale_count1}'readonly/>
</td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "warranty1"  id = "warranty1"  class="w3-input"   /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "cal1"  id = "cal1"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "pm1"  id = "pm1"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>



<td style="width:8%;">
<textarea name = "sale_remarkk1" style="width:100%;" id = "sale_remarkk1"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code1').value = '';

document.getElementById('product_name1').value  = ''; 
document.getElementById('unit_name1').value  = '';
document.getElementById('product_price1').value  = '';
document.getElementById('sale_count1').value  = '';

document.getElementById('sum_amount1').value  = '';
document.getElementById('discount_unit1').value  = '';
document.getElementById('product_codet1').value  = '';
document.getElementById('product_id1').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>

<tr>
<td style="width:10%;">

<input type='text' name = "product_codet2" style="width:100%;" id = "product_codet2" class="button4" placeholder="Search รหัส" size="7"  OnChange="JavaScript:doCallAjax('product_codet2','product_id2','product_name2','unit_name2','product_price2','discount_unit2','warranty2');"/> 
<input type='hidden' name = "h_product_codet2"  id = "h_product_codet2"  class="w3-input" readonly>

<input type='text' name = "product_code2" style="width:100%;" id = "product_code2" class="button4" placeholder="Search ชื่ออังกฤษ..." size="7" OnChange="JavaScript:doCallAjax('product_code2','product_id2','product_name2','unit_name2','product_price2','discount_unit2','warranty2');"/> 
<input type='hidden' name = "h_product_code2"  id = "h_product_code2"  class="w3-input" readonly>
	
<input type='text' name = "product_c2" style="width:100%;" id = "product_c2" class="button4" placeholder="Search ชื่อไทย..." size="7" OnChange="JavaScript:doCallAjax('product_c2','product_id2','product_name2','unit_name2','product_price2','discount_unit2','warranty2');"/> 
<input type='hidden' name = "h_product_c2"  id = "h_product_c2"  class="w3-input" readonly>	
<input type='hidden' name = "product_id2"  id = "product_id2" class="w3-input" />

</td>
<td style="width:15%;">
<textarea name = "product_name2" style="width:100%;" id = "product_name2"  class="button4" rows="2" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name2" style="width:100%;" id = "unit_name2"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count2" style="width:100%;" id = "sale_count2"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price2" style="width:100%;" id = "product_price2" size="7" class="button4"  style="color:black;text-align:right" />
</td style="width:8%;">
<td><input type='text' name = "discount_unit2" style="width:100%;" id = "discount_unit2" size="5" class="button4"  style="color:black;text-align:right" /></td>

<td style="width:8%;"><input type='text' style="width:100%;" name = "sum_amount2"  id = "sum_amount2" size="7" class="button4" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count2} * {product_price2} - {discount_unit2} * {sale_count2}'readonly/>
</td>


<td style="width:5%;"><input type='text' style="width:100%;" name = "warranty2"  id = "warranty2"  class="w3-input"   /></td>

<td style="width:5%;"><input type='text' style="width:100%;" name = "cal2"  id = "cal2"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:5%;"><input type='text' style="width:100%;" name = "pm2"  id = "pm2"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>



<td style="width:10%;">
<textarea name = "sale_remarkk2" style="width:100%;" id = "sale_remarkk2"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code2').value = '';
document.getElementById('product_name2').value  = ''; 
document.getElementById('unit_name2').value  = '';
document.getElementById('product_price2').value  = '';
document.getElementById('sale_count2').value  = '';
document.getElementById('product_codet2').value  = '';

document.getElementById('sum_amount2').value  = '';
document.getElementById('discount_unit2').value  = '';
document.getElementById('product_id2').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>



</tr>

<tr>
<td style="width:10%;">

<input type='text' name = "product_codet3" style="width:100%;" id = "product_codet3" class="button4" placeholder="Search รหัส" size="7"  OnChange="JavaScript:doCallAjax('product_codet3','product_id3','product_name3','unit_name3','product_price3','discount_unit3','warranty3');"/> 
<input type='hidden' name = "h_product_codet3"  id = "h_product_codet3"  class="w3-input" readonly>

<input type='text' name = "product_code3" style="width:100%;" id = "product_code3" class="button4" placeholder="Search ชื่ออังกฤษ..." size="7" OnChange="JavaScript:doCallAjax('product_code3','product_id3','product_name3','unit_name3','product_price3','discount_unit3','warranty3');"/> 
<input type='hidden' name = "h_product_code3"  id = "h_product_code3"  class="w3-input" readonly>
	
<input type='text' name = "product_c3" style="width:100%;" id = "product_c3" class="button4" placeholder="Search ชื่อไทย..." size="7" OnChange="JavaScript:doCallAjax('product_c3','product_id3','product_name3','unit_name3','product_price3','discount_unit3','warranty3');"/> 
<input type='hidden' name = "h_product_c3"  id = "h_product_c3"  class="w3-input" readonly>	
<input type='hidden' name = "product_id3"  id = "product_id3" class="w3-input" />

</td>
<td style="width:15%;">
<textarea name = "product_name3" style="width:100%;" id = "product_name3"  class="button4" rows="2" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name3" style="width:100%;" id = "unit_nam3"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count3" style="width:100%;" id = "sale_count3"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price3" style="width:100%;" id = "product_price3" size="7" class="button4"  style="color:black;text-align:right" />
</td style="width:8%;">
<td><input type='text' name = "discount_unit3" style="width:100%;" id = "discount_unit3" size="5" class="button4"  style="color:black;text-align:right" /></td>

<td style="width:8%;"><input type='text' style="width:100%;" name = "sum_amount3"  id = "sum_amount3" size="7" class="button4" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count3} * {product_price3} - {discount_unit3} * {sale_count3}'readonly/>
</td>


<td style="width:5%;"><input type='text' style="width:100%;" name = "warranty3"  id = "warranty3"  class="w3-input"   /></td>

<td style="width:5%;"><input type='text' style="width:100%;" name = "cal3"  id = "cal3"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:5%;"><input type='text' style="width:100%;" name = "pm3"  id = "pm3"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>



<td style="width:10%;">
<textarea name = "sale_remarkk3" style="width:100%;" id = "sale_remarkk3"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code3').value = '';
document.getElementById('product_name3').value  = ''; 
document.getElementById('unit_name3').value  = '';
document.getElementById('product_price3').value  = '';
document.getElementById('sale_count3').value  = '';
document.getElementById('product_codet3').value  = '';

document.getElementById('sum_amount3').value  = '';
document.getElementById('discount_unit3').value  = '';
document.getElementById('product_id3').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>



</tr>


<tr>
<td style="width:10%;">

<input type='text' name = "product_codet4" style="width:100%;" id = "product_codet4" class="button4" placeholder="Search รหัส" size="7"  OnChange="JavaScript:doCallAjax('product_codet4','product_id4','product_name4','unit_name4','product_price4','discount_unit4','warranty4');"/> 
<input type='hidden' name = "h_product_codet4"  id = "h_product_codet4"  class="w3-input" readonly>

<input type='text' name = "product_code4" style="width:100%;" id = "product_code4" class="button4" placeholder="Search ชื่ออังกฤษ..." size="7" OnChange="JavaScript:doCallAjax('product_code4','product_id4','product_name4','unit_name4','product_price4','discount_unit4','warranty4');"/> 
<input type='hidden' name = "h_product_code4"  id = "h_product_code4"  class="w3-input" readonly>
	
<input type='text' name = "product_c4" style="width:100%;" id = "product_c4" class="button4" placeholder="Search ชื่อไทย..." size="7" OnChange="JavaScript:doCallAjax('product_c4','product_id4','product_name4','unit_name4','product_price4','discount_unit4','warranty4');"/> 
<input type='hidden' name = "h_product_c4"  id = "h_product_c4"  class="w3-input" readonly>	
<input type='hidden' name = "product_id4"  id = "product_id4" class="w3-input" />

</td>
<td style="width:15%;">
<textarea name = "product_name4" style="width:100%;" id = "product_name4"  class="button4" rows="2" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name4" style="width:100%;" id = "unit_name4"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count4" style="width:100%;" id = "sale_count4"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price4" style="width:100%;" id = "product_price4" size="7" class="button4"  style="color:black;text-align:right" />
</td style="width:8%;">
<td><input type='text' name = "discount_unit4" style="width:100%;" id = "discount_unit4" size="5" class="button4"  style="color:black;text-align:right" /></td>

<td style="width:8%;"><input type='text' style="width:100%;" name = "sum_amount4"  id = "sum_amount4" size="7" class="button4" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count4} * {product_price4} - {discount_unit4} * {sale_count4}'readonly/>
</td>


<td style="width:5%;"><input type='text' style="width:100%;" name = "warranty4"  id = "warranty4"  class="w3-input"   /></td>

<td style="width:5%;"><input type='text' style="width:100%;" name = "cal4"  id = "cal4"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:5%;"><input type='text' style="width:100%;" name = "pm4"  id = "pm4"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>



<td style="width:10%;">
<textarea name = "sale_remarkk4" style="width:100%;" id = "sale_remarkk4"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code4').value = '';
document.getElementById('product_name4').value  = ''; 
document.getElementById('unit_name4').value  = '';
document.getElementById('product_price4').value  = '';
document.getElementById('sale_count4').value  = '';
document.getElementById('product_codet4').value  = '';

document.getElementById('sum_amount4').value  = '';
document.getElementById('discount_unit4').value  = '';
document.getElementById('product_id4').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>



</tr>



<tr>
<td style="width:10%;">

<input type='text' name = "product_codet5" style="width:100%;" id = "product_codet5" class="button4" placeholder="Search รหัส" size="7"  OnChange="JavaScript:doCallAjax('product_codet5','product_id5','product_name5','unit_name5','product_price5','discount_unit5','warranty5');"/> 
<input type='hidden' name = "h_product_codet5"  id = "h_product_codet5"  class="w3-input" readonly>

<input type='text' name = "product_code5" style="width:100%;" id = "product_code5" class="button4" placeholder="Search ชื่ออังกฤษ..." size="7" OnChange="JavaScript:doCallAjax('product_code5','product_id5','product_name5','unit_name5','product_price5','discount_unit5','warranty5');"/> 
<input type='hidden' name = "h_product_code5"  id = "h_product_code5"  class="w3-input" readonly>
	
<input type='text' name = "product_c5" style="width:100%;" id = "product_c5" class="button4" placeholder="Search ชื่อไทย..." size="7" OnChange="JavaScript:doCallAjax('product_c5','product_id5','product_name5','unit_name5','product_price5','discount_unit5','warranty5');"/> 
<input type='hidden' name = "h_product_c5"  id = "h_product_c5"  class="w3-input" readonly>	
<input type='hidden' name = "product_id5"  id = "product_id5" class="w3-input" />

</td>
<td style="width:15%;">
<textarea name = "product_name5" style="width:100%;" id = "product_name5"  class="button4" rows="2" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name5" style="width:100%;" id = "unit_name5"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count5" style="width:100%;" id = "sale_count5"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price5" style="width:100%;" id = "product_price5" size="7" class="button4"  style="color:black;text-align:right" />
</td style="width:8%;">
<td><input type='text' name = "discount_unit5" style="width:100%;" id = "discount_unit5" size="5" class="button4"  style="color:black;text-align:right" /></td>

<td style="width:8%;"><input type='text' style="width:100%;" name = "sum_amount5"  id = "sum_amount5" size="7" class="button4" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count5} * {product_price5} - {discount_unit5} * {sale_count5}'readonly/>
</td>


<td style="width:5%;"><input type='text' style="width:100%;" name = "warranty5"  id = "warranty5"  class="w3-input"   /></td>

<td style="width:5%;"><input type='text' style="width:100%;" name = "cal5"  id = "cal5"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:5%;"><input type='text' style="width:100%;" name = "pm5"  id = "pm5"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>



<td style="width:10%;">
<textarea name = "sale_remarkk5" style="width:100%;" id = "sale_remarkk5"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code5').value = '';
document.getElementById('product_name5').value  = ''; 
document.getElementById('unit_name5').value  = '';
document.getElementById('product_price5').value  = '';
document.getElementById('sale_count5').value  = '';
document.getElementById('product_codet5').value  = '';

document.getElementById('sum_amount5').value  = '';
document.getElementById('discount_unit5').value  = '';
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

<input type='text' name = "product_codet6" style="width:100%;" id = "product_codet6" class="button4" placeholder="Search รหัส"  size="7" OnChange="JavaScript:doCallAjax('product_codet6','product_id6','product_name6','unit_name6','product_price6','discount_unit6','warranty6');"/> 
<input type='hidden' name = "h_product_codet6"  id = "h_product_codet6"  class="button4" readonly>


<input type='text' name = "product_code6" style="width:100%;" id = "product_code6" class="button4" placeholder="Search ชื่ออังกฤษ"  size="7" OnChange="JavaScript:doCallAjax('product_code6','product_id6','product_name6','unit_name6','product_price6','discount_unit6','warranty6');"/> 
<input type='hidden' name = "h_product_code6"  id = "h_product_code6"  class="button4" readonly>
	
<input type='text' name = "product_c6" style="width:100%;" id = "product_c6" class="button4" placeholder="Search ชื่อไทย"  size="7" OnChange="JavaScript:doCallAjax('product_c6','product_id6','product_name6','unit_name6','product_price6','discount_unit6','warranty6');"/> 
<input type='hidden' name = "h_product_c6"  id = "h_product_c6"  class="button4" readonly>	
<input type='hidden' name = "product_id6"  id = "product_id6" class="w3-input" />

</td>
<td  style="width:10%;">
<textarea  name = "product_name6"  id = "product_name6" style="width:100%;" rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name6" style="width:100%;" id = "unit_name6"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count6" style="width:100%;" id = "sale_count6"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price6" style="width:100%;" id = "product_price6"  class="button4" size="7" style="color:black;text-align:right" />
</td >

<td style="width:8%;"><input type='text' style="width:100%;" name = "discount_unit6" size="5" id = "discount_unit6" class="button4"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' style="width:100%;" name = "sum_amount6"  id = "sum_amount6"  class="button4" size="7" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count6} * {product_price6} - {discount_unit6} * {sale_count6}'readonly/>
</td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "warranty6"  id = "warranty6"  class="w3-input"   /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "cal6"  id = "cal6"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "pm6"  id = "pm6"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>



<td style="width:8%;">
<textarea name = "sale_remarkk6" style="width:100%;" id = "sale_remarkk6"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code6').value = '';

document.getElementById('product_name6').value  = ''; 
document.getElementById('unit_name6').value  = '';
document.getElementById('product_price6').value  = '';
document.getElementById('sale_count6').value  = '';

document.getElementById('sum_amount6').value  = '';
document.getElementById('discount_unit6').value  = '';
document.getElementById('product_codet6').value  = '';
document.getElementById('product_id6').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>


<tr>
<td style="width:10%;">

<input type='text' name = "product_codet7" style="width:100%;" id = "product_codet7" class="button4" placeholder="Search รหัส"  size="7" OnChange="JavaScript:doCallAjax('product_codet7','product_id7','product_name7','unit_name7','product_price7','discount_unit7','warranty7');"/> 
<input type='hidden' name = "h_product_codet7"  id = "h_product_codet7"  class="button4" readonly>


<input type='text' name = "product_code7" style="width:100%;" id = "product_code7" class="button4" placeholder="Search ชื่ออังกฤษ"  size="7" OnChange="JavaScript:doCallAjax('product_code7','product_id7','product_name7','unit_name7','product_price7','discount_unit7','warranty7');"/> 
<input type='hidden' name = "h_product_code7"  id = "h_product_code7"  class="button4" readonly>
	
<input type='text' name = "product_c7" style="width:100%;" id = "product_c7" class="button4" placeholder="Search ชื่อไทย"  size="7" OnChange="JavaScript:doCallAjax('product_c7','product_id7','product_name7','unit_name7','product_price7','discount_unit7','warranty7');"/> 
<input type='hidden' name = "h_product_c7"  id = "h_product_c7"  class="button4" readonly>	
<input type='hidden' name = "product_id7"  id = "product_id7" class="w3-input" />

</td>
<td  style="width:10%;">
<textarea  name = "product_name7"  id = "product_name7" style="width:100%;" rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name7" style="width:100%;" id = "unit_name7"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count7" style="width:100%;" id = "sale_count7"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price7" style="width:100%;" id = "product_price7"  class="button4" size="7" style="color:black;text-align:right" />
</td >

<td style="width:8%;"><input type='text' style="width:100%;" name = "discount_unit7" size="5" id = "discount_unit7" class="button4"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' style="width:100%;" name = "sum_amount7"  id = "sum_amount7"  class="button4" size="7" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count7} * {product_price7} - {discount_unit7} * {sale_count7}'readonly/>
</td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "warranty7"  id = "warranty7"  class="w3-input"   /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "cal7"  id = "cal7"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "pm7"  id = "pm7"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>



<td style="width:8%;">
<textarea name = "sale_remarkk7" style="width:100%;" id = "sale_remarkk7"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code7').value = '';

document.getElementById('product_name7').value  = ''; 
document.getElementById('unit_name7').value  = '';
document.getElementById('product_price7').value  = '';
document.getElementById('sale_count7').value  = '';

document.getElementById('sum_amount7').value  = '';
document.getElementById('discount_unit7').value  = '';
document.getElementById('product_codet7').value  = '';
document.getElementById('product_id7').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>

<tr>
<td style="width:10%;">

<input type='text' name = "product_codet8" style="width:100%;" id = "product_codet8" class="button4" placeholder="Search รหัส"  size="7" OnChange="JavaScript:doCallAjax('product_codet8','product_id8','product_name8','unit_name8','product_price8','discount_unit8','warranty8');"/> 
<input type='hidden' name = "h_product_codet8"  id = "h_product_codet8"  class="button4" readonly>


<input type='text' name = "product_code8" style="width:100%;" id = "product_code8" class="button4" placeholder="Search ชื่ออังกฤษ"  size="7" OnChange="JavaScript:doCallAjax('product_code8','product_id8','product_name8','unit_name8','product_price8','discount_unit8','warranty8');"/> 
<input type='hidden' name = "h_product_code8"  id = "h_product_code8"  class="button4" readonly>
	
<input type='text' name = "product_c8" style="width:100%;" id = "product_c8" class="button4" placeholder="Search ชื่อไทย"  size="7" OnChange="JavaScript:doCallAjax('product_c8','product_id8','product_name8','unit_name8','product_price8','discount_unit8','warranty8');"/> 
<input type='hidden' name = "h_product_c8"  id = "h_product_c8"  class="button4" readonly>	
<input type='hidden' name = "product_id8"  id = "product_id8" class="w3-input" />

</td>
<td  style="width:10%;">
<textarea  name = "product_name8"  id = "product_name8" style="width:100%;" rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name8" style="width:100%;" id = "unit_name8"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count8" style="width:100%;" id = "sale_count8"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price8" style="width:100%;" id = "product_price8"  class="button4" size="7" style="color:black;text-align:right" />
</td >

<td style="width:8%;"><input type='text' style="width:100%;" name = "discount_unit8" size="5" id = "discount_unit8" class="button4"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' style="width:100%;" name = "sum_amount8"  id = "sum_amount8"  class="button4" size="7" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count8} * {product_price8} - {discount_unit8} * {sale_count8}'readonly/>
</td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "warranty8"  id = "warranty8"  class="w3-input"   /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "cal8"  id = "cal8"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "pm8"  id = "pm8"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>



<td style="width:8%;">
<textarea name = "sale_remarkk8" style="width:100%;" id = "sale_remarkk8"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code8').value = '';

document.getElementById('product_name8').value  = ''; 
document.getElementById('unit_name8').value  = '';
document.getElementById('product_price8').value  = '';
document.getElementById('sale_count8').value  = '';

document.getElementById('sum_amount8').value  = '';
document.getElementById('discount_unit8').value  = '';
document.getElementById('product_codet8').value  = '';
document.getElementById('product_id8').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>

<tr>
<td style="width:10%;">

<input type='text' name = "product_codet9" style="width:100%;" id = "product_codet9" class="button4" placeholder="Search รหัส"  size="7" OnChange="JavaScript:doCallAjax('product_codet9','product_id9','product_name9','unit_name9','product_price9','discount_unit9','warranty9');"/> 
<input type='hidden' name = "h_product_codet9"  id = "h_product_codet9"  class="button4" readonly>


<input type='text' name = "product_code9" style="width:100%;" id = "product_code9" class="button4" placeholder="Search ชื่ออังกฤษ"  size="7" OnChange="JavaScript:doCallAjax('product_code9','product_id9','product_name9','unit_name9','product_price9','discount_unit9','warranty9');"/> 
<input type='hidden' name = "h_product_code9"  id = "h_product_code9"  class="button4" readonly>
	
<input type='text' name = "product_c9" style="width:100%;" id = "product_c9" class="button4" placeholder="Search ชื่อไทย"  size="7" OnChange="JavaScript:doCallAjax('product_c9','product_id9','product_name9','unit_name9','product_price9','discount_unit9','warranty9');"/> 
<input type='hidden' name = "h_product_c9"  id = "h_product_c9"  class="button4" readonly>	
<input type='hidden' name = "product_id9"  id = "product_id9" class="w3-input" />

</td>
<td  style="width:10%;">
<textarea  name = "product_name9"  id = "product_name9" style="width:100%;" rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name9" style="width:100%;" id = "unit_name9"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count9" style="width:100%;" id = "sale_count9"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price9" style="width:100%;" id = "product_price9"  class="button4" size="7" style="color:black;text-align:right" />
</td >

<td style="width:8%;"><input type='text' style="width:100%;" name = "discount_unit9" size="5" id = "discount_unit9" class="button4"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' style="width:100%;" name = "sum_amount9"  id = "sum_amount9"  class="button4" size="7" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count1} * {product_price1} - {discount_unit1} * {sale_count1}'readonly/>
</td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "warranty9"  id = "warranty9"  class="w3-input"   /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "cal9"  id = "cal9"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "pm9"  id = "pm9"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>



<td style="width:8%;">
<textarea name = "sale_remarkk9" style="width:100%;" id = "sale_remarkk9"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code9').value = '';

document.getElementById('product_name9').value  = ''; 
document.getElementById('unit_name9').value  = '';
document.getElementById('product_price9').value  = '';
document.getElementById('sale_count9').value  = '';

document.getElementById('sum_amount9').value  = '';
document.getElementById('discount_unit9').value  = '';
document.getElementById('product_codet9').value  = '';
document.getElementById('product_id9').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>

<tr>
<td style="width:10%;">

<input type='text' name = "product_codet10" style="width:100%;" id = "product_codet10" class="button4" placeholder="Search รหัส"  size="7" OnChange="JavaScript:doCallAjax('product_codet10','product_id10','product_name10','unit_name10','product_price10','discount_unit10','warranty10');"/> 
<input type='hidden' name = "h_product_codet10"  id = "h_product_codet10"  class="button4" readonly>


<input type='text' name = "product_code10" style="width:100%;" id = "product_code10" class="button4" placeholder="Search ชื่ออังกฤษ"  size="7" OnChange="JavaScript:doCallAjax('product_code10','product_id10','product_name10','unit_name10','product_price10','discount_unit10','warranty10');"/> 
<input type='hidden' name = "h_product_code10"  id = "h_product_code10"  class="button4" readonly>
	
<input type='text' name = "product_c10" style="width:100%;" id = "product_c10" class="button4" placeholder="Search ชื่อไทย"  size="7" OnChange="JavaScript:doCallAjax('product_c10','product_id10','product_name10','unit_name10','product_price10','discount_unit10','warranty10');"/> 
<input type='hidden' name = "h_product_c10"  id = "h_product_c10"  class="button4" readonly>	
<input type='hidden' name = "product_id10"  id = "product_id10" class="w3-input" />

</td>
<td  style="width:10%;">
<textarea  name = "product_name10"  id = "product_name10" style="width:100%;" rows="2" class="button4" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name10" style="width:100%;" id = "unit_name10"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count10" style="width:100%;" id = "sale_count10"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price10" style="width:100%;" id = "product_price10"  class="button4" size="7" style="color:black;text-align:right" />
</td >

<td style="width:8%;"><input type='text' style="width:100%;" name = "discount_unit10" size="5" id = "discount_unit10" class="button4"  style="color:black;text-align:right" /></td>


<td style="width:8%;"><input type='text' style="width:100%;" name = "sum_amount10"  id = "sum_amount10"  class="button4" size="7" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count10} * {product_price10} - {discount_unit10} * {sale_count10}'readonly/>
</td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "warranty10"  id = "warranty10"  class="w3-input"   /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "cal10"  id = "cal10"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;" ><input type='text' style="width:100%;" name = "pm10"  id = "pm10"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>



<td style="width:8%;">
<textarea name = "sale_remarkk10" style="width:100%;" id = "sale_remarkk10"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code10').value = '';

document.getElementById('product_name10').value  = ''; 
document.getElementById('unit_name10').value  = '';
document.getElementById('product_price10').value  = '';
document.getElementById('sale_count10').value  = '';

document.getElementById('sum_amount10').value  = '';
document.getElementById('discount_unit10').value  = '';
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



