<html>
<head>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

</head>


<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_code,product_id,product_name,unit_name,product_price) {
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
<thead>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>แลกเข้า</th>
	<th>แลกออก</th>
    <th>ราคาต่อหน่วย</th>
    <th>ยอดรวม</th>
	<th>หมายเลขเครื่อง</th>
	<th>หมายเหตุ</th>

</thead>

<tbody>


<tr>
<td style="width:10%;">
<input type='text' name = "product_codet1"  id = "product_codet1" class="w3-input" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet1','product_id1','product_name1','unit_name1','product_price1');"/> 
<input type='hidden' name = "h_product_codet1"  id = "h_product_codet1"  class="button4" readonly>

<input type='text' name = "product_code1"  id = "product_code1" class="w3-input" placeholder="Search ชื่ออังกฤษ..."  size="10" OnChange="JavaScript:doCallAjax('product_code1','product_id1','product_name1','unit_name1','product_price1');"/> 
<input type='hidden' name = "h_product_code1"  id = "h_product_code1"  class="button4" readonly>
	
<input type='text' name = "product_c1"  id = "product_c1" class="w3-input" placeholder="Search ชื่อไทย..."  size="10" OnChange="JavaScript:doCallAjax('product_c1','product_id1','product_name1','unit_name1','product_price1');"/> 
<input type='hidden' name = "h_product_c1"  id = "h_product_c1"  class="button4" readonly>	
<input type='hidden' name = "product_id1"  id = "product_id1" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name1"  id = "product_name1"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1"  id = "unit_name1"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "count_stock1" id = "count_stock1"  class="w3-input" style="color:black;text-align:center"  readonly>
</td>

<td style="width:5%;">
<input type='text' name = "count_sale1" id = "count_sale1"  class="w3-input" style="color:black;text-align:center"  />
</td>


<td style="width:10%;">
<input type='text' name = "product_price1"  id = "product_price1"  class="w3-input" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount1"  id = "sum_amount6"  class="w3-input" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{count_sale1} * {product_price1}'readonly/>
</td>

<td style="width:20%;">
<textarea name = "sn1"  id = "sn1"  class="w3-input" ></textarea>
</td>		
	
<td style="width:20%;">
<textarea name = "sale_remarkk1"  id = "sale_remarkk1"  class="w3-input" ></textarea>
</td>

<td><a onclick="document.getElementById('product_code1').value = '';

document.getElementById('product_name1').value  = ''; 
document.getElementById('unit_name1').value  = '';
document.getElementById('product_price1').value  = '';
document.getElementById('sale_count1').value  = '';
document.getElementById('product_codet1').value  = ''; 

document.getElementById('sum_amount1').value  = '';
document.getElementById('product_id1').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>


<tr>
<td style="width:10%;">
<input type='text' name = "product_codet2" value="<?php echo $objResult3["access_code"]; ?>" id = "product_codet2" class="w3-input" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet2','product_id2','product_name2','unit_name2','product_price2');"/> 
<input type='hidden' name = "h_product_codet2"  id = "h_product_codet2"  class="button4" readonly>

<input type='text' name = "product_code2"  id = "product_code2" class="w3-input" placeholder="Search ชื่ออังกฤษ..."  size="10" OnChange="JavaScript:doCallAjax('product_code2','product_id2','product_name2','unit_name2','product_price2');"/> 
<input type='hidden' name = "h_product_code2"  id = "h_product_code2"  class="button4" readonly>
	
<input type='text' name = "product_c2"  id = "product_c2" class="w3-input" placeholder="Search ชื่อไทย..."  size="10" OnChange="JavaScript:doCallAjax('product_c2','product_id2','product_name2','unit_name2','product_price2');"/> 
<input type='hidden' name = "h_product_c2"  id = "h_product_c2"  class="button4" readonly>	
<input type='hidden' name = "product_id2"  id = "product_id2" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name2"  id = "product_name2"  rows="2" class="w3-input" readonly><?php echo $objResult3["sol_name"]; ?></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name2"  id = "unit_name2" value="<?php echo $objResult3["unit_name"]; ?>"	 class="w3-input" readonly/>
</td>
<td style="width:5%;">
<?php if($objResult3["sol_name"]!=''){ $dfgi = '1'; }else{ $dfgi = ''; }?>	
<input type='text' name = "count_stock2" id = "count_stock2"  value="<?php echo $dfgi; ?>" class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:5%;">
<input type='text' name = "count_sale2" id = "count_sale2"  class="w3-input" style="color:black;text-align:center"  readonly>
</td>


<td style="width:10%;">
<input type='text' name = "product_price2"  id = "product_price2"  class="w3-input" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount2"  id = "sum_amount2"  class="w3-input" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{count_stock2} * {product_price2}'readonly/>
</td>

<td style="width:20%;">
<textarea name = "sn2"  id = "sn2"  class="w3-input" ><?php echo $objResult["product_sn"]; ?></textarea>
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
<input type='text' name = "product_codet3"  id = "product_codet3" class="w3-input" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet3','product_id3','product_name3','unit_name3','product_price3');"/> 
<input type='hidden' name = "h_product_codet3"  id = "h_product_codet3"  class="button4" readonly>

<input type='text' name = "product_code3"  id = "product_code3" class="w3-input" placeholder="Search ชื่ออังกฤษ..."  size="10" OnChange="JavaScript:doCallAjax('product_code3','product_id3','product_name3','unit_name3','product_price3');"/> 
<input type='hidden' name = "h_product_code3"  id = "h_product_code3"  class="button4" readonly>
	
<input type='text' name = "product_c3"  id = "product_c3" class="w3-input" placeholder="Search ชื่อไทย..."  size="10" OnChange="JavaScript:doCallAjax('product_c3','product_id3','product_name3','unit_name3','product_price3');"/> 
<input type='hidden' name = "h_product_c3"  id = "h_product_c3"  class="button4" readonly>	
<input type='hidden' name = "product_id3"  id = "product_id3" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name3"  id = "product_name3"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name3"  id = "unit_name3"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "count_stock3" id = "count_stock3"  class="w3-input" style="color:black;text-align:center"  readonly>
</td>

<td style="width:5%;">
<input type='text' name = "count_sale3" id = "count_sale3"  class="w3-input" style="color:black;text-align:center"  />
</td>


<td style="width:10%;">
<input type='text' name = "product_price3"  id = "product_price3"  class="w3-input" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount3"  id = "sum_amount3"  class="w3-input" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{count_sale3} * {product_price3}'readonly/>
</td>

<td style="width:20%;">
<textarea name = "sn3"  id = "sn3"  class="w3-input" ></textarea>
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
<input type='text' name = "product_codet4"  id = "product_codet4" class="w3-input" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet4','product_id4','product_name4','unit_name4','product_price4');"/> 
<input type='hidden' name = "h_product_codet4"  id = "h_product_codet4"  class="button4" readonly>

<input type='text' name = "product_code4"  id = "product_code4" class="w3-input" placeholder="Search ชื่ออังกฤษ..."  size="10" OnChange="JavaScript:doCallAjax('product_code4','product_id4','product_name4','unit_name4','product_price4');"/> 
<input type='hidden' name = "h_product_code4"  id = "h_product_code4"  class="button4" readonly>
	
<input type='text' name = "product_c4"  id = "product_c4" class="w3-input" placeholder="Search ชื่อไทย..."  size="10" OnChange="JavaScript:doCallAjax('product_c4','product_id4','product_name4','unit_name4','product_price4');"/> 
<input type='hidden' name = "h_product_c4"  id = "h_product_c4"  class="button4" readonly>	
<input type='hidden' name = "product_id4"  id = "product_id4" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name4"  id = "product_name4"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name4"  id = "unit_name4"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "count_stock4" id = "count_stock4"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:5%;">
<input type='text' name = "count_sale4" id = "count_sale4"  class="w3-input" style="color:black;text-align:center"  readonly>
</td>


<td style="width:10%;">
<input type='text' name = "product_price4"  id = "product_price4"  class="w3-input" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount4"  id = "sum_amount4"  class="w3-input" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{count_stock4} * {product_price4}'readonly/>
</td>

<td style="width:20%;">
<textarea name = "sn4"  id = "sn4"  class="w3-input" ></textarea>
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
<input type='text' name = "product_codet5"  id = "product_codet5" class="w3-input" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet5','product_id5','product_name5','unit_name5','product_price5');"/> 
<input type='hidden' name = "h_product_codet5"  id = "h_product_codet5"  class="button4" readonly>

<input type='text' name = "product_code5"  id = "product_code5" class="w3-input" placeholder="Search ชื่ออังกฤษ..."  size="10" OnChange="JavaScript:doCallAjax('product_code5','product_id5','product_name5','unit_name5','product_price5');"/> 
<input type='hidden' name = "h_product_code5"  id = "h_product_code5"  class="button4" readonly>
	
<input type='text' name = "product_c5"  id = "product_c5" class="w3-input" placeholder="Search ชื่อไทย..."  size="10" OnChange="JavaScript:doCallAjax('product_c5','product_id5','product_name5','unit_name5','product_price5');"/> 
<input type='hidden' name = "h_product_c5"  id = "h_product_c5"  class="button4" readonly>	
<input type='hidden' name = "product_id5"  id = "product_id5" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name5"  id = "product_name5"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name5"  id = "unit_name5"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "count_stock5" id = "count_stock5"  class="w3-input" style="color:black;text-align:center"  readonly>
</td>

<td style="width:5%;">
<input type='text' name = "count_sale5" id = "count_sale5"  class="w3-input" style="color:black;text-align:center"  />
</td>


<td style="width:10%;">
<input type='text' name = "product_price5"  id = "product_price5"  class="w3-input" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount5"  id = "sum_amount5"  class="w3-input" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{count_sale5} * {product_price5}'readonly/>
</td>

<td style="width:20%;">
<textarea name = "sn5"  id = "sn5"  class="w3-input" ></textarea>
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



<tr>
<td style="width:10%;">
<input type='text' name = "product_codet6"  id = "product_codet6" class="w3-input" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet6','product_id6','product_name6','unit_name6','product_price6');"/> 
<input type='hidden' name = "h_product_codet6"  id = "h_product_codet6"  class="w3-input" readonly>

<input type='text' name = "product_code6"  id = "product_code6" class="w3-input" placeholder="Search ชื่ออังกฤษ..."  size="10" OnChange="JavaScript:doCallAjax('product_code6','product_id6','product_name6','unit_name6','product_price6');"/> 
<input type='hidden' name = "h_product_code6"  id = "h_product_code6"  class="button4" readonly>
	
<input type='text' name = "product_c6"  id = "product_c6" class="w3-input" placeholder="Search ชื่อไทย..."  size="10" OnChange="JavaScript:doCallAjax('product_c6','product_id6','product_name6','unit_name6','product_price6');"/> 
<input type='hidden' name = "h_product_c6"  id = "h_product_c6"  class="button4" readonly>	
<input type='hidden' name = "product_id6"  id = "product_id6" class="w3-input" />

</td>
<td  style="width:12%;">
<textarea  name = "product_name6"  id = "product_name6"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name6"  id = "unit_name6"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "count_stock6" id = "count_stock6"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:5%;">
<input type='text' name = "count_sale6" id = "count_sale6"  class="w3-input" style="color:black;text-align:center"  readonly>
</td>


<td style="width:10%;">
<input type='text' name = "product_price6"  id = "product_price6"  class="w3-input" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount6"  id = "sum_amount6"  class="w3-input" size="10" style="color:black;text-align:right" value="" jAutoCalc= '{count_stock6} * {product_price6}'readonly/>
</td>

<td style="width:20%;">
<textarea name = "sn6"  id = "sn6"  class="w3-input" ></textarea>
</td>		
	
<td style="width:20%;">
<textarea name = "sale_remarkk6"  id = "sale_remarkk6"  class="w3-input" ></textarea>
</td>

<td style="width:2%;"><a onclick="document.getElementById('product_code6').value = '';

document.getElementById('product_name6').value  = ''; 
document.getElementById('unit_name6').value  = '';
document.getElementById('product_price6').value  = '';
document.getElementById('sale_count6').value  = '';
document.getElementById('product_codet6').value  = ''; 

document.getElementById('sum_amount6').value  = '';
document.getElementById('product_id6').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>




</tbody>
</table>


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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_engnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_enginb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_product_engthnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c6","h_product_c6");
        </script>



