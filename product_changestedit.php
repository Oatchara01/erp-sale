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




 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk" id="ckk" onClick="ck_frm();" value="1"/>เพิ่มเติม<br/>
<div id="frm_txt" style="display:none;">


<table width="100%" border="0" class="w3-table">
<thead>



<tr>
<td style="width:12%;">
<input type='text' name = "product_codet1"  id = "product_codet1" class="w3-input" placeholder="Search รหัส..."  size="10" OnChange="JavaScript:doCallAjax('product_codet1','product_id1','product_name1','unit_name1','product_price1');"/> 
<input type='hidden' name = "h_product_codet1"  id = "h_product_codet1"  class="w3-input" readonly>

<input type='text' name = "product_code1"  id = "product_code1" class="w3-input" placeholder="Search ชื่อสินค้า..."  size="10" OnChange="JavaScript:doCallAjax('product_code1','product_id1','product_name1','unit_name1','product_price1');"/> 
<input type='hidden' name = "h_product_code1"  id = "h_product_code1"  class="w3-input" readonly>
<input type='hidden' name = "product_id1"  id = "product_id1" class="w3-input" />

</td>
<td  style="width:20%;">
<textarea  name = "product_name1"  id = "product_name1"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:8%;">
<input type='text' name = "unit_name1"  id = "unit_name1"  class="w3-input" readonly/>
</td>
<td style="width:8%;">
<input type='text' name = "count_stock1" id = "count_stock1"  class="w3-input" style="color:black;text-align:center"  >
</td>

<td style="width:8%;">
<input type='text' name = "count_sale1" id = "count_sale1"  class="w3-input" style="color:black;text-align:center"  />
</td>


<td style="width:10%;">
<input type='text' name = "product_price1"  id = "product_price1"  class="w3-input" size="10" style="color:black;text-align:right" />
</td >


<td style="width:10%;"><input type='text' name = "sum_amount1"  id = "sum_amount6"  class="w3-input" size="10" style="color:black;text-align:right" value="" readonly/>
</td>

<td style="width:20%;">
<textarea name = "sale_remarkk1"  id = "sale_remarkk1"  class="w3-input" ></textarea>
</td>

<td style="width:5%;"><a onclick="document.getElementById('product_code1').value = '';

document.getElementById('product_name1').value  = ''; 
document.getElementById('unit_name1').value  = '';
document.getElementById('product_price1').value  = '';
document.getElementById('sale_count1').value  = '';
document.getElementById('product_codet1').value  = ''; 

document.getElementById('sum_amount1').value  = '';
document.getElementById('product_id1').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>

</tbody>
</table>

</div>


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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet1","h_product_codet1");
        </script>