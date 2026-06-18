<html>
<head>
<!--link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script-->


</head>

<!--script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_code,product_id,product_name,unit_name) {
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


</script-->

<script src="dist/jautocalc.js"></script></head>

<body>
<table width="100%" border="0" class="w3-table">

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
	<th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>
	 
<tbody>
<tr>
<td style="width:10%;">

<input type='text' name = "product_codet2"  id = "product_codet2" class="w3-input" placeholder="Search รหัส"  size="7" OnChange="JavaScript:doCallAjax('product_codet2','product_id2','product_name2','unit_name2');"/> 
<input type='hidden' name = "h_product_codet2"  id = "h_product_codet2"  class="button4" readonly>


<input type='text' name = "product_code2"  id = "product_code2" class="w3-input" placeholder="Search ชื่ออังกฤษ"  size="7" OnChange="JavaScript:doCallAjax('product_code2','product_id2','product_name2','unit_name2');"/> 
<input type='hidden' name = "h_product_code2"  id = "h_product_code2"  class="button4" readonly>
	
<input type='text' name = "product_c2"  id = "product_c2" class="w3-input" placeholder="Search ชื่อไทย"  size="7" OnChange="JavaScript:doCallAjax('product_c2','product_id2','product_name2','unit_name2');"/> 
<input type='hidden' name = "h_product_c2"  id = "h_product_c2"  class="button4" readonly>	
<input type='hidden' name = "product_id2"  id = "product_id2" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name2"  id = "product_name2"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name2"  id = "unit_name2"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count2" id = "sale_count2"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<textarea name = "sn_number2" id = "sn_number2"  class="w3-input"   ></textarea>
</td>
<td style="width:10%;">
<textarea name = "sale_remark2" id = "sale_remark2"  class="w3-input"   ></textarea>
</td>	
	
<td style="width:2%;"><a onclick="document.getElementById('product_code2').value = '';

document.getElementById('product_name2').value  = ''; 
document.getElementById('unit_name2').value  = '';
document.getElementById('sale_remark2').value  = '';
document.getElementById('sale_count2').value  = '';
document.getElementById('sn_number2').value  = '';
document.getElementById('product_codet2').value  = '';
document.getElementById('product_id2').value  = '';
document.getElementById('h_product_code2').value  = '';
document.getElementById('product_c2').value  = '';
document.getElementById('h_product_c2').value  = '';

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
		return "data_pro_engcusnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_codecusnb.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_thaicusnb.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c2","h_product_c2");
        </script>


