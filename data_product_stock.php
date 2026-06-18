<html>
<head>
</head>
<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_codet,product_id,product_name,unit_name,product_price,discount_unit) {
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
var url = 'data_product_code2.php';
var pmeters = "product_codet=" + encodeURI( document.getElementById(product_codet).value);
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


function ck_frm(){
var ck = document.getElementById('ckk');
if(ck.checked == true){
document.getElementById('frm_txt').style.display = "";
}else{
document.getElementById('frm_txt').style.display = "none";
}

}




</script>

<script>

/*function fncSum() 
		{



	if (document.getElementById(product_codet1).value!=document.getElementById(product_code_same1).value){
		
		
		alert("สินค้าไม่ถูกต้อง กรุณาตรวจสอบสินค้าค่ะ");
		
		document.getElementById(product_code_same1).value='';
		return false;
	}
	else{
		return true;
	}
}*/
</script>


<script src="dist/jautocalc.js"></script></head>

<body>

 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk" id="ckk" onClick="ck_frm();" value="1"/>เพิ่มเติม<br/>
<div id="frm_txt" style="display:none;">


<table width="100%" border="0" class="w3-table">
 <thead>
 <th>รหัสสินค้า</th>
 <th>รายการสินค้า</th>
 <th>หน่วย</th>
 <th>จำนวน</th>
  <th>ราคาต่อหน่วย</th>
    <th>ส่วนลด</th>
  <th>ยอดรวม</th>
 <th>หมายเหตุ</th>
 <th>หมายเลขเครื่อง</th>
  </thead>
<tbody>
<tr>
<td style="width:10%;">

<input type='text' name = "product_codet1"  id = "product_codet1" class="w3-input" placeholder="ยิงบาร์โค้ด..." OnChange="JavaScript:doCallAjax('product_codet1','product_id1','product_name1','unit_name1','product_price1','discount_unit1');"/> 
<input type='hidden' name = "product_id1"  id = "product_id1" class="w3-input" />

</td>
<td style="width:12%;">
<input type='text' name = "product_name1"  id = "product_name1"  class="w3-input" readonly>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1"  id = "unit_name1"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count1"  id = "sale_count1"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:12%;">
<input type='text' name = "product_price1"  id = "product_price1"  class="w3-input"  style="color:black;text-align:right" />
</td>

<td style="width:12%;"><input type='text' name = "discount_unit1"  id = "discount_unit1" class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:12%;"><input type='text' name = "sum_amount1"  id = "sum_amount1"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count1} * {product_price1} - {discount_unit1} * {sale_count1}'readonly/>
</td>


<td style="width:12%;">
<input type='text' name = "stock_remarkk1"  id = "stock_remarkk1"  class="w3-input" />
</td>
<td style="width:12%;">
<input type='text' name = "sn_number1"  id = "sn_number1"  class="w3-input" />
</td>

<td style="width:2%;"> <a onclick="document.getElementById('product_codet1').value = '';
document.getElementById('product_name1').value  = ''; 
document.getElementById('unit_name1').value  = '';
document.getElementById('product_price1').value  = '';
document.getElementById('sale_count1').value  = '';
document.getElementById('sum_amount1').value  = '';
document.getElementById('discount_unit1').value  = '';
document.getElementById('product_id1').value  = '';
document.getElementById('sn_number1').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>



</tr>

<tr>
<td style="width:10%;">

<input type='text' name = "product_codet2"  id = "product_codet2" class="w3-input" placeholder="ยิงบาร์โค้ด..." OnChange="JavaScript:doCallAjax('product_codet2','product_id2','product_name2','unit_name2','product_price2','discount_unit2');"/> 
<input type='hidden' name = "product_id2"  id = "product_id2" class="w3-input" />

</td>
<td style="width:12%;">
<input type='text' name = "product_name2"  id = "product_name2"  class="w3-input" readonly>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name2"  id = "unit_name2"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count2"  id = "sale_count2"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:12%;">
<input type='text' name = "product_price2"  id = "product_price2"  class="w3-input"  style="color:black;text-align:right" />
</td>

<td style="width:12%;"><input type='text' name = "discount_unit2"  id = "discount_unit2" class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:12%;"><input type='text' name = "sum_amount2"  id = "sum_amount2"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count2} * {product_price2} - {discount_unit2} * {sale_count2}'readonly/>
</td>


<td style="width:12%;">
<input type='text' name = "stock_remarkk2"  id = "stock_remarkk2"  class="w3-input" />
</td>
<td style="width:12%;">
<input type='text' name = "sn_number2"  id = "sn_number2"  class="w3-input" />
</td>

<td style="width:2%;"> <a onclick="document.getElementById('product_codet2').value = '';
document.getElementById('product_name2').value  = ''; 
document.getElementById('unit_name2').value  = '';
document.getElementById('product_price2').value  = '';
document.getElementById('sale_count2').value  = '';
document.getElementById('sum_amount2').value  = '';
document.getElementById('discount_unit2').value  = '';
document.getElementById('product_id2').value  = '';
document.getElementById('sn_number2').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>



</tr>


<tr>
<td style="width:10%;">

<input type='text' name = "product_codet3"  id = "product_codet3" class="w3-input" placeholder="ยิงบาร์โค้ด..." OnChange="JavaScript:doCallAjax('product_codet3','product_id3','product_name3','unit_name3','product_price3','discount_unit3');"/> 
<input type='hidden' name = "h_product_code3"  id = "h_product_code3"  class="w3-input" readonly>
<input type='hidden' name = "product_id3"  id = "product_id3" class="w3-input" />

</td>
<td style="width:12%;">
<input type='text' name = "product_name3"  id = "product_name3"  class="w3-input" readonly>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name3"  id = "unit_name3"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count3"  id = "sale_count3"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:12%;">
<input type='text' name = "product_price3"  id = "product_price3"  class="w3-input"  style="color:black;text-align:right" />
</td>

<td style="width:12%;"><input type='text' name = "discount_unit3"  id = "discount_unit3" class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:12%;"><input type='text' name = "sum_amount3"  id = "sum_amount3"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count3} * {product_price3} - {discount_unit3} * {sale_count3}'readonly/>
</td>


<td style="width:12%;">
<input type='text' name = "stock_remarkk3"  id = "stock_remarkk3"  class="w3-input" />
</td>
<td style="width:12%;">
<input type='text' name = "sn_number3"  id = "sn_number3"  class="w3-input" />
</td>

<td style="width:2%;"> <a onclick="document.getElementById('product_code3').value = '';
document.getElementById('product_name3').value  = ''; 
document.getElementById('unit_name3').value  = '';
document.getElementById('product_price3').value  = '';
document.getElementById('sale_count3').value  = '';
document.getElementById('sum_amount3').value  = '';
document.getElementById('discount_unit3').value  = '';
document.getElementById('product_id3').value  = '';
document.getElementById('sn_number3').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>



</tr>


<tr>
<td style="width:10%;">

<input type='text' name = "product_codet4"  id = "product_codet4" class="w3-input" placeholder="ยิงบาร์โค้ด..." OnChange="JavaScript:doCallAjax('product_codet4','product_id4','product_name4','unit_name4','product_price4','discount_unit4');"/> 
<input type='hidden' name = "product_id4"  id = "product_id4" class="w3-input" />

</td>
<td style="width:12%;">
<input type='text' name = "product_name4"  id = "product_name4"  class="w3-input" readonly>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name4"  id = "unit_name4"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count4"  id = "sale_count4"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:12%;">
<input type='text' name = "product_price4"  id = "product_price4"  class="w3-input"  style="color:black;text-align:right" />
</td>

<td style="width:12%;"><input type='text' name = "discount_unit4"  id = "discount_unit4" class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:12%;"><input type='text' name = "sum_amount4"  id = "sum_amount4"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count4} * {product_price4} - {discount_unit4} * {sale_count4}'readonly/>
</td>


<td style="width:12%;">
<input type='text' name = "stock_remarkk4"  id = "stock_remarkk4"  class="w3-input" />
</td>
<td style="width:12%;">
<input type='text' name = "sn_number4"  id = "sn_number4"  class="w3-input" />
</td>

<td style="width:2%;"> <a onclick="document.getElementById('product_codet4').value = '';
document.getElementById('product_name4').value  = ''; 
document.getElementById('unit_name4').value  = '';
document.getElementById('product_price4').value  = '';
document.getElementById('sale_count4').value  = '';
document.getElementById('sum_amount4').value  = '';
document.getElementById('discount_unit4').value  = '';
document.getElementById('product_id4').value  = '';
document.getElementById('sn_number4').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>



</tr>


<tr>
<td style="width:10%;">

<input type='text' name = "product_codet5"  id = "product_codet5" class="w3-input" placeholder="ยิงบาร์โค้ด..." OnChange="JavaScript:doCallAjax('product_codet5','product_id5','product_name5','unit_name5','product_price5','discount_unit5');"/> 
<input type='hidden' name = "product_id5"  id = "product_id5" class="w3-input" />

</td>
<td style="width:12%;">
<input type='text' name = "product_name5"  id = "product_name5"  class="w3-input" readonly>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name5"  id = "unit_name5"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count5"  id = "sale_count5"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:12%;">
<input type='text' name = "product_price5"  id = "product_price5"  class="w3-input"  style="color:black;text-align:right" />
</td>

<td style="width:12%;"><input type='text' name = "discount_unit5"  id = "discount_unit5" class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:12%;"><input type='text' name = "sum_amount5"  id = "sum_amount5"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count5} * {product_price5} - {discount_unit5} * {sale_count5}'readonly/>
</td>


<td style="width:12%;">
<input type='text' name = "stock_remarkk5"  id = "stock_remarkk5"  class="w3-input" />
</td>
<td style="width:12%;">
<input type='text' name = "sn_number5"  id = "sn_number5"  class="w3-input" />
</td>

<td style="width:2%;"> <a onclick="document.getElementById('product_codet5').value = '';
document.getElementById('product_name5').value  = ''; 
document.getElementById('unit_name5').value  = '';
document.getElementById('product_price5').value  = '';
document.getElementById('sale_count5').value  = '';
document.getElementById('sum_amount5').value  = '';
document.getElementById('discount_unit5').value  = '';
document.getElementById('product_id5').value  = '';
document.getElementById('sn_number5').value  = '';

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




