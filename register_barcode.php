<html>
<head>
<title>Sale Online</title>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->



<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_code,product_name,unit_name,product_price) {
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
var url = 'data_product_code1.php';
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
document.getElementById(product_name).value = myArr[0];
document.getElementById(unit_name).value = myArr[1];
document.getElementById(product_price).value = myArr[2];
}
}
}
}



</script>
<script src="dist/jautocalc.js"></script></head>
</head>
<body>

<form name="frmMain">
<table width="100%" border="0" class="w3-table">

<tr>
	<th>No. </th>
    <th>Product Code</th>
    <th>Product Name </th>
    <th>Unit Name </th>
    <th>Sale Count </th>
    <th>Product Price </th>
    <th>Amount </th>
    <th>Sale Remark </th>
    <th>Stock Remark </th>
</tr>


<tr>
<th><?php echo 1;?> 
</th>

<th style="width:15%;">


<input type='text' name = "product_code"  id = "product_code" class="w3-input" OnChange="JavaScript:doCallAjax('product_code','product_name','unit_name','product_price');"/> 
<input name="h_product_code1" type="hidden" id="h_product_code1" value="" class="button4" />
</th>
<th>
<input type='text' name = "product_name"  id = "product_name"  class="w3-input" readonly>
</th>
<th>
<input type='text' name = "unit_name"  id = "unit_name"  class="w3-input" readonly/>
</th>
<th>
<input type='text' name = "sale_count"  id = "sale_count"  class="w3-input" style="color:black;text-align:center"  />
</th>
<th>
<input type='text' name = "product_price"  id = "product_price"  class="w3-input"  style="color:black;text-align:right" />
</th>
<th><input type='text' name = "sum_amount"  id = "sum_amount"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count} * {product_price}'readonly/>
</th>
<?php/* */?>
<th>
<input type='text' name = "sale_remarkk1"  id = "sale_remarkk1"  class="w3-input" />
</th>
<th>
<input type='text' name = "stock_remark1"  id = "stock_remark1"  class="w3-input" />
</th>
</tr>

<tr>
<td><?php echo 2;?> 
</td>

<td style="width:15%;"><div align="center">


<input type='text' name = "product_code2"  id = "product_code2" class="w3-input" OnChange="JavaScript:doCallAjax('product_code2','product_name2','unit_name2','product_price2');"/> 
</div></td>
<td>
<input type='text' name = "product_name2"  id = "product_name2"  class="w3-input" readonly>
</td>
<td>
<input type='text' name = "unit_name2"  id = "unit_name2"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count2"  id = "sale_count2"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price2"  id = "product_price2"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "sum_amount2"  id = "sum_amount2"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count2} * {product_price2}'readonly/>
</td>
<?php/* */?>
<td>
<input type='text' name = "sale_remarkk2"  id = "sale_remarkk2"  class="w3-input" />
</td>
<td>
<input type='text' name = "stock_remark2"  id = "stock_remark2"  class="w3-input" />
</td>




</tr>

<tr>
<td><?php echo 3;?> 
</td>

<td style="width:15%;"><div align="center">


<input type='text' name = "product_code3"  id = "product_code3" class="w3-input"/> 
</div></td>
<td>
<input type='text' name = "product_name3"  id = "product_name3"  class="w3-input" readonly>
</td>
<td>
<input type='text' name = "unit_name3"  id = "unit_name3"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count3"  id = "sale_count3"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price3"  id = "product_price3"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "sum_amount3"  id = "sum_amount3"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count3} * {product_price3}'readonly/>
</td>
<?php/* */?>
<td>
<input type='text' name = "sale_remarkk3"  id = "sale_remarkk3"  class="w3-input" />
</td>
<td>
<input type='text' name = "stock_remark3"  id = "stock_remark3"  class="w3-input" />
</td>




</tr>

<tr>
<td><?php echo 4;?> 
</td>

<td style="width:15%;"><div align="center">


<input type='text' name = "product_code4"  id = "product_code4" class="w3-input"/> 
</div></td>
<td>
<input type='text' name = "product_name4"  id = "product_name4"  class="w3-input" readonly>
</td>
<td>
<input type='text' name = "unit_name4"  id = "unit_name4"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count4"  id = "sale_count4"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price4"  id = "product_price4"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "sum_amount4"  id = "sum_amount4"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count4} * {product_price4}'readonly/>
</td>
<?php/* */?>
<td>
<input type='text' name = "sale_remarkk4"  id = "sale_remarkk4"  class="w3-input" />
</td>
<td>
<input type='text' name = "stock_remark4"  id = "stock_remark4"  class="w3-input" />
</td>




</tr>

<tr>
<td><?php echo 5;?> 
</td>

<td style="width:15%;"><div align="center">


<input type='text' name = "product_code5"  id = "product_code5" class="w3-input"/> 
</div></td>
<td>
<input type='text' name = "product_name5"  id = "product_name5"  class="w3-input" readonly>
</td>
<td>
<input type='text' name = "unit_name5"  id = "unit_name5"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count5"  id = "sale_count5"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price5"  id = "product_price5"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "sum_amount5"  id = "sum_amount5"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count5} * {product_price5}'readonly/>
</td>
<?php/* */?>
<td>
<input type='text' name = "sale_remarkk5"  id = "sale_remarkk5"  class="w3-input" />
</td>
<td>
<input type='text' name = "stock_remark5"  id = "stock_remark5"  class="w3-input" />
</td>




</tr>

<tr>
<td><?php echo 6;?> 
</td>

<td style="width:15%;"><div align="center">


<input type='text' name = "product_code6"  id = "product_code6" class="w3-input"/> 
</div></td>
<td>
<input type='text' name = "product_name6"  id = "product_name6"  class="w3-input" readonly>
</td>
<td>
<input type='text' name = "unit_name6"  id = "unit_name6"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count6"  id = "sale_count6"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price6"  id = "product_price6"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "sum_amount6"  id = "sum_amount6"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count6} * {product_price6}'readonly/>
</td>
<?php/* */?>
<td>
<input type='text' name = "sale_remarkk6"  id = "sale_remarkk6"  class="w3-input" />
</td>
<td>
<input type='text' name = "stock_remark6"  id = "stock_remark6"  class="w3-input" />
</td>




</tr>

<tr>
<td><?php echo 7;?> 
</td>

<td style="width:15%;"><div align="center">


<input type='text' name = "product_code7"  id = "product_code7" class="w3-input"/> 
</div></td>
<td>
<input type='text' name = "product_name7"  id = "product_name7"  class="w3-input" readonly>
</td>
<td>
<input type='text' name = "unit_name7"  id = "unit_name7"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count7"  id = "sale_count7"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price7"  id = "product_price7"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "sum_amount7"  id = "sum_amount7"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count7} * {product_price7}'readonly/>
</td>
<?php/* */?>
<td>
<input type='text' name = "sale_remarkk7"  id = "sale_remarkk7"  class="w3-input" />
</td>
<td>
<input type='text' name = "stock_remark7"  id = "stock_remark7"  class="w3-input" />
</td>




</tr>

<tr>
<td><?php echo 8;?> 
</td>

<td style="width:15%;"><div align="center">


<input type='text' name = "product_code8"  id = "product_code8" class="w3-input"/> 
</div></td>
<td>
<input type='text' name = "product_name8"  id = "product_name8"  class="w3-input" readonly>
</td>
<td>
<input type='text' name = "unit_name8"  id = "unit_name8"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count8"  id = "sale_count8"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price8"  id = "product_price8"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "sum_amount8"  id = "sum_amount8"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count8} * {product_price8}'readonly/>
</td>
<?php/* */?>
<td>
<input type='text' name = "sale_remarkk8"  id = "sale_remarkk8"  class="w3-input" />
</td>
<td>
<input type='text' name = "stock_remark8"  id = "stock_remark8"  class="w3-input" />
</td>




</tr>

<tr>
<td><?php echo 9;?> 
</td>

<td style="width:15%;"><div align="center">


<input type='text' name = "product_code9"  id = "product_code9" class="w3-input"/> 
</div></td>
<td>
<input type='text' name = "product_name9"  id = "product_name9"  class="w3-input" readonly>
</td>
<td>
<input type='text' name = "unit_name9"  id = "unit_name9"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count9"  id = "sale_count9"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price9"  id = "product_price9"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "sum_amount9"  id = "sum_amount9"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count9} * {product_price9}'readonly/>
</td>
<?php/* */?>
<td>
<input type='text' name = "sale_remarkk9"  id = "sale_remarkk9"  class="w3-input" />
</td>
<td>
<input type='text' name = "stock_remark9"  id = "stock_remark9"  class="w3-input" />
</td>




</tr>

<tr>
<td><?php echo 10;?> 
</td>

<td style="width:15%;"><div align="center">


<input type='text' name = "product_code10"  id = "product_code10" class="w3-input"/> 
</div></td>
<td>
<input type='text' name = "product_name10"  id = "product_name10"  class="w3-input" readonly>
</td>
<td>
<input type='text' name = "unit_name10"  id = "unit_name10"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count10"  id = "sale_count10"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price10"  id = "product_price10"  class="w3-input"  style="color:black;text-align:right" />
</td>
<td><input type='text' name = "sum_amount10"  id = "sum_amount10"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count10} * {product_price10}'readonly/>
</td>
<?php/* */?>
<td>
<input type='text' name = "sale_remarkk10"  id = "sale_remarkk10"  class="w3-input" />
</td>
<td>
<input type='text' name = "stock_remark10"  id = "stock_remark10"  class="w3-input" />
</td>




</tr>




</table>
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
</br>
<center>
<!--<input type="submit" name="submit" class="button button4">-->
</center>
<input type="hidden" name="hdnLine" value="<?php echo $i;?>">
</br></br></br>

<!--</form>-->
</form>
</body>
</html>

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
		return "data_product_code1.1.php?product_code1_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code1","h_product_code1");
        </script>


<?php /*
<script type="text/javascript">
function make_autocom(autoObj,showObj){
    var mkAutoObj=autoObj; 
    var mkSerValObj=showObj; 
    new Autocomplete(mkAutoObj, function() {
        this.setValue = function(id) {      
            document.getElementById(mkSerValObj).value = id;
            // ถ้ามี id ที่ได้จากการเลือกใน autocomplete 
            if(id!=""){
                // ส่งค่าไปคิวรี่เพื่อเรียกข้อมูลเพิ่มเติมที่ต้องการ โดยใช้ ajax 
                $.post("data_product_code1.php",{id:id},function(data){
                    if(data!=null && data.length>0){ // ถ้ามีข้อมูล
                            // นำข้อมูลไปแสดงใน textbox ที่่เตรียมไว้
                            $("#product_code1").val(data[0].product_code);
                            $("#product_name1").val(data[0].product_name);
                            $("#unit_name1").val(data[0].unit_name);
							 $("#product_price1").val(data[0].product_price);
                    }
                });
            }else{
                // ล้างค่ากรณีไม่มีการส่งค่า id ไปหรือไม่มีการเลือกจาก autocomplete
                $("#product_code1").val("");
                $("#product_name1").val("");
                $("#unit_name1").val(""); 
				 $("#product_price1").val("");             
            }
            }
        }
        if ( this.isModified )
            this.setValue("");
        if ( this.value.length < 1 && this.isNotClick ) 
            return ;    
        return "data_product_code1.1.php?product_code1_search=" +encodeURIComponent(this.value);
    }); 
}   
   
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code1","h_product_code1");
</script>
	*/?>