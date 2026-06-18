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
function doCallAjax1(product_code,product_id,product_name,unit_name) {
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



</script>


<script src="dist/jautocalc.js"></script></head>

<body>

 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk" id="ckk" onClick="ck_frm();" value="1"/>เพิ่มเติม<br/>
<div id="frm_txt" style="display:none;">
<table width="100%" border="0" class="w3-table">

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>หมายเหตุ</th>

<tbody>
<tr>
<td style="width:10%;">
<input type='text' name = "product_code1"  id = "product_code1" class="w3-input" placeholder="Search รหัสสินค้า..."  size="7" OnChange="JavaScript:doCallAjax1('product_code1','product_id1','product_name1','unit_name1');"/> 
<input type='hidden' name = "h_product_code1"  id = "h_product_code1"  class="w3-input" readonly>
<input type='hidden' name = "product_id1"  id = "product_id1" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name1"  id = "product_name1"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1"  id = "unit_name1"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count1" id = "sale_count1"  class="w3-input" style="color:black;text-align:center"  />
</td>


<td style="width:10%;">
<textarea name = "stock_remark1"  id = "stock_remark1"  class="w3-input" ></textarea>
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

<input type='text' name = "product_code2"  id = "product_code2" class="w3-input" placeholder="Search รหัสสินค้า..." size="7" OnChange="JavaScript:doCallAjax1('product_code2','product_id2','product_name2','unit_name2');"/> 
<input type='hidden' name = "h_product_code2"  id = "h_product_code2"  class="w3-input" readonly>
<input type='hidden' name = "product_id2"  id = "product_id2" class="w3-input" />

</td>
<td style="width:15%;">
<textarea name = "product_name2"  id = "product_name2"  class="w3-input" rows="2" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name2"  id = "unit_name2"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count2"  id = "sale_count2"  class="w3-input" style="color:black;text-align:center"  />
</td>


<td style="width:10%;">
<textarea name = "stock_remark2"  id = "stock_remark2"  class="w3-input" ></textarea>
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

<input type='text' name = "product_code3"  id = "product_code3" class="w3-input" placeholder="Search รหัสสินค้า..."  size="7" OnChange="JavaScript:doCallAjax1('product_code3','product_id3','product_name3','unit_name3');"/> 

<input type='hidden' name = "h_product_code3"  id = "h_product_code3"  class="w3-input" readonly>
<input type='hidden' name = "product_id3"  id = "product_id3" class="w3-input" />

</td>
<td>
<textarea name = "product_name3"  id = "product_name3"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name3"  id = "unit_name3"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count3"  id = "sale_count3"  class="w3-input" style="color:black;text-align:center"  />
</td>

<td>
<textarea name = "stock_remark3"  id = "stock_remark3"  class="w3-input" ></textarea>
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


<input type='text' name = "product_code4"  id = "product_code4" class="w3-input" placeholder="Search รหัสสินค้า..."  size="7" OnChange="JavaScript:doCallAjax1('product_code4','product_id4','product_name4','unit_name4');"/> 
<input type='hidden' name = "h_product_code4"  id = "h_product_code4"  class="w3-input" readonly>
<input type='hidden' name = "product_id4"  id = "product_id4" class="w3-input" />

</td>
<td>
<textarea  name = "product_name4"  id = "product_name4"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name4"  id = "unit_name4"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count4"  id = "sale_count4"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<textarea  name = "stock_remark4"  id = "stock_remark4"  class="w3-input" ></textarea>
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

<input type='text' name = "product_code5"  id = "product_code5" class="w3-input" placeholder="Search รหัสสินค้า..."  size="7" OnChange="JavaScript:doCallAjax1('product_code5','product_id5','product_name5','unit_name5');"/> 

<input type='hidden' name = "h_product_code5"  id = "h_product_code5"  class="w3-input" readonly>
<input type='hidden' name = "product_id5"  id = "product_id5" class="w3-input" />

</td>
<td>
<textarea  name = "product_name5"  id = "product_name5"  class="w3-input" readonly></textarea>
</td>
<td>
<input type='text' name = "unit_name5"  id = "unit_name5"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count5"  id = "sale_count5"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<textarea  name = "stock_remark5"  id = "stock_remark5"  class="w3-input" ></textarea>
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
		return "data_pro1.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro1.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro1.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro1.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code5","h_product_code5");
        </script>






