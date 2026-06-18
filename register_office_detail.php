
<html>
<head>


</head>
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

    <th>Product Code</th>
    <th>Product Name </th>
    <th>Unit Name </th>
    <th>Sale Count </th>
    <th>Product Price </th>
	<th>Discount/Unit</th>
    <th>Amount </th>
	<th>รับประกัน (ปี)</th>
	<th>Cal(ครั้ง/ปี)</th>
	<th>PM (ครั้ง/ปี)</th>
    <th>Sale Remark </th>
</thead>
<tbody>
<tr>
<td style="width:15%;">

<?php/*
<input type='text' name = "product_code1"  id = "product_code1" class="w3-input" OnChange="JavaScript:doCallAjax('product_code1','product_name1','unit_name1','product_price1');"/> */?>

<select name="product1" class="w3-select" onchange="document.getElementById('product_code1').value = this.value.split('|')[0];

document.getElementById('product_name1').value  = this.value.split('|')[1]; 
document.getElementById('unit_name1').value  = this.value.split('|')[2];
document.getElementById('product_price1').value  = this.value.split('|')[3];
document.getElementById('discount_unit1').value  = '0';

">
<option value=""></option>
<?php
$strSQL1 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<option value="<?php echo $objResult1["product_code"];?>|<?php  echo $objResult1["product_name"];?>|<?php  echo $objResult1["unit_name"];?>|<?php  echo $objResult1["product_price"];?>"><?php echo $objResult1["product_code"];?> <?php  echo $objResult1["product_name"];?></option>

<?php
}
?>
</select>

<input type='hidden' name = "product_code1"  id = "product_code1"  class="w3-input" readonly>



</td>
<td>
<input type='text' name = "product_name1"  id = "product_name1"  class="w3-input" readonly>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1"  id = "unit_name1"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count1"  id = "sale_count1"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<input type='text' name = "product_price1"  id = "product_price1"  class="w3-input"  style="color:black;text-align:right" />
</td >

<td style="width:5%;"><input type='text' name = "discount_unit1"  id = "discount_unit1"  class="w3-input"  style="color:black;text-align:right" /></td>


<td style="width:10%;"><input type='text' name = "sum_amount1"  id = "sum_amount1"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count1} * {product_price1} - {discount_unit1} * {sale_count1}'readonly/>
</td>
<td><input type='text' name = "warranty1"  id = "warranty1"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal1"  id = "cal1"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm1"  id = "pm1"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td>
<input type='text' name = "sale_remarkk1"  id = "sale_remarkk1"  class="w3-input" />
</td>
</tr>

<tr>
<td >

<?php
/*<input type='text' name = "product_code2"  id = "product_code2" class="w3-input" OnChange="JavaScript:doCallAjax('product_code2','product_name2','unit_name2','product_price2');"/> */

?>


<select name="product2" class="w3-select" onchange="document.getElementById('product_code2').value = this.value.split('|')[0];

document.getElementById('product_name2').value  = this.value.split('|')[1]; 
document.getElementById('unit_name2').value  = this.value.split('|')[2];
document.getElementById('product_price2').value  = this.value.split('|')[3];
document.getElementById('discount_unit2').value  = '0';
">
<option value=""></option>
<?php
$strSQL2 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>
<option value="<?php echo $objResult2["product_code"];?>|<?php  echo $objResult2["product_name"];?>|<?php  echo $objResult2["unit_name"];?>|<?php  echo $objResult2["product_price"];?>"><?php echo $objResult2["product_code"];?> <?php  echo $objResult2["product_name"];?></option>

<?php
}
?>
</select>

<input type='hidden' name = "product_code2"  id = "product_code2"  class="w3-input" readonly>
</td>
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
<td><input type='text' name = "discount_unit2"  id = "discount_unit2"  class="w3-input"  style="color:black;text-align:right" /></td>
<td><input type='text' name = "sum_amount2"  id = "sum_amount2"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count2} * {product_price2} - {discount_unit2} * {sale_count2}'readonly/></td>


<td><input type='text' name = "warranty2"  id = "warranty2"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal2"  id = "cal2"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "pm2"  id = "pm2"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>
<td>
<input type='text' name = "sale_remarkk2"  id = "sale_remarkk2"  class="w3-input" />
</td>
</tr>

<tr>
<td >
<?php /*
<input type='text' name = "product_code3"  id = "product_code3" class="w3-input" OnChange="JavaScript:doCallAjax('product_code3','product_name3','unit_name3','product_price3');"/> */?>

<select name="product3" class="w3-select" onchange="document.getElementById('product_code3').value = this.value.split('|')[0];

document.getElementById('product_name3').value  = this.value.split('|')[1]; 
document.getElementById('unit_name3').value  = this.value.split('|')[2];
document.getElementById('product_price3').value  = this.value.split('|')[3];
document.getElementById('discount_unit3').value  = '0';
">
<option value=""></option>
<?php
$strSQL3 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
while($objResult3 = mysqli_fetch_array($objQuery3))
{
?>
<option value="<?php echo $objResult3["product_code"];?>|<?php  echo $objResult3["product_name"];?>|<?php  echo $objResult3["unit_name"];?>|<?php  echo $objResult3["product_price"];?>"><?php echo $objResult3["product_code"];?> <?php  echo $objResult3["product_name"];?></option>

<?php
}
?>
</select>

<input type='hidden' name = "product_code3"  id = "product_code3"  class="w3-input" readonly>

</td>
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
<td><input type='text' name = "discount_unit3"  id = "discount_unit3"  class="w3-input"  style="color:black;text-align:right" /></td>

<td><input type='text' name = "sum_amount3"  id = "sum_amount3"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count3} * {product_price3} - {discount_unit3} * {sale_count3}'readonly/>
</td>
<td><input type='text' name = "warranty3"  id = "warranty3"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal3"  id = "cal3"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm3"  id = "pm3"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td>
<input type='text' name = "sale_remarkk3"  id = "sale_remarkk3"  class="w3-input" />
</td>
</tr>

<tr>
<td >
<?php/*
<input type='text' name = "product_code4"  id = "product_code4" class="w3-input" OnChange="JavaScript:doCallAjax('product_code4','product_name4','unit_name4','product_price4');"/> */?>

<select name="product4" class="w3-select" onchange="document.getElementById('product_code4').value = this.value.split('|')[0];

document.getElementById('product_name4').value  = this.value.split('|')[1]; 
document.getElementById('unit_name4').value  = this.value.split('|')[2];
document.getElementById('product_price4').value  = this.value.split('|')[3];
document.getElementById('discount_unit4').value  = '0';
">
<option value=""></option>
<?php
$strSQL4 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
while($objResult4 = mysqli_fetch_array($objQuery4))
{
?>
<option value="<?php echo $objResult4["product_code"];?>|<?php  echo $objResult4["product_name"];?>|<?php  echo $objResult4["unit_name"];?>|<?php  echo $objResult4["product_price"];?>"><?php echo $objResult4["product_code"];?> <?php  echo $objResult4["product_name"];?></option>

<?php
}
?>
</select>

<input type='hidden' name = "product_code4"  id = "product_code4"  class="w3-input" readonly>

</td>
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
<td><input type='text' name = "discount_unit4"  id = "discount_unit4"  class="w3-input"  style="color:black;text-align:right" /></td>

<td><input type='text' name = "sum_amount4"  id = "sum_amount4"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count4} * {product_price4} - {discount_unit4} * {sale_count4}'readonly/>
</td>
<td><input type='text' name = "warranty4"  id = "warranty4"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal4"  id = "cal4"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm4"  id = "pm4"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td>
<input type='text' name = "sale_remarkk4"  id = "sale_remarkk4"  class="w3-input" />
</td>
</tr>

<tr>
<td >

<?php /*
<input type='text' name = "product_code5"  id = "product_code5" class="w3-input" OnChange="JavaScript:doCallAjax('product_code5','product_name5','unit_name5','product_price5');"/> */?>

<select name="product5" class="w3-select" onchange="document.getElementById('product_code5').value = this.value.split('|')[0];

document.getElementById('product_name5').value  = this.value.split('|')[1]; 
document.getElementById('unit_name5').value  = this.value.split('|')[2];
document.getElementById('product_price5').value  = this.value.split('|')[3];
document.getElementById('discount_unit5').value  = '0';
">
<option value=""></option>
<?php
$strSQL5 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
while($objResult5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResult5["product_code"];?>|<?php  echo $objResult5["product_name"];?>|<?php  echo $objResult5["unit_name"];?>|<?php  echo $objResult5["product_price"];?>"><?php echo $objResult5["product_code"];?> <?php  echo $objResult5["product_name"];?></option>

<?php
}
?>
</select>

<input type='hidden' name = "product_code5"  id = "product_code5"  class="w3-input" readonly>

</td>
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

<td><input type='text' name = "discount_unit5"  id = "discount_unit5"  class="w3-input"  style="color:black;text-align:right" /></td>


<th><input type='text' name = "sum_amount5"  id = "sum_amount5"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count5} * {product_price5} - {discount_unit5} * {sale_count5}'readonly/>
</td>
<td><input type='text' name = "warranty5"  id = "warranty5"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal5"  id = "cal5"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm5"  id = "pm5"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td>
<input type='text' name = "sale_remarkk5"  id = "sale_remarkk5"  class="w3-input" />
</td>
</tr>

<tr>
<td >
<?php /*
<input type='text' name = "product_code6"  id = "product_code6" class="w3-input" OnChange="JavaScript:doCallAjax('product_code6','product_name6','unit_name6','product_price6');"/> */?>

<select name="product6" class="w3-select" onchange="document.getElementById('product_code6').value = this.value.split('|')[0];

document.getElementById('product_name6').value  = this.value.split('|')[1]; 
document.getElementById('unit_name6').value  = this.value.split('|')[2];
document.getElementById('product_price6').value  = this.value.split('|')[3];
document.getElementById('discount_unit6').value  = '0';
">
<option value=""></option>
<?php
$strSQL6 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
while($objResult6 = mysqli_fetch_array($objQuery6))
{
?>
<option value="<?php echo $objResult6["product_code"];?>|<?php  echo $objResult6["product_name"];?>|<?php  echo $objResult6["unit_name"];?>|<?php  echo $objResult6["product_price"];?>"><?php echo $objResult6["product_code"];?> <?php  echo $objResult6["product_name"];?></option>

<?php
}
?>
</select>

<input type='hidden' name = "product_code6"  id = "product_code6"  class="w3-input" readonly>

</td>
<th>
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
<td><input type='text' name = "discount_unit6"  id = "discount_unit6"  class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount6"  id = "sum_amount6"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count6} * {product_price6} - {discount_unit6} * {sale_count6}'readonly/>
</td>
<td><input type='text' name = "warranty6"  id = "warranty6"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal6"  id = "cal6"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm6"  id = "pm6"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>
<td>
<input type='text' name = "sale_remarkk6"  id = "sale_remarkk6"  class="w3-input" />
</td>
</tr>

<tr>
<td >
<?php /*
<input type='text' name = "product_code7"  id = "product_code7" class="w3-input" OnChange="JavaScript:doCallAjax('product_code7','product_name7','unit_name7','product_price7');"/> */?>

<select name="product7" class="w3-select" onchange="document.getElementById('product_code7').value = this.value.split('|')[0];

document.getElementById('product_name7').value  = this.value.split('|')[1]; 
document.getElementById('unit_name7').value  = this.value.split('|')[2];
document.getElementById('product_price7').value  = this.value.split('|')[3];
document.getElementById('discount_unit7').value  = '0';
">
<option value=""></option>
<?php
$strSQL7 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
while($objResult7 = mysqli_fetch_array($objQuery7))
{
?>
<option value="<?php echo $objResult7["product_code"];?>|<?php  echo $objResult7["product_name"];?>|<?php  echo $objResult7["unit_name"];?>|<?php  echo $objResult7["product_price"];?>"><?php echo $objResult7["product_code"];?> <?php  echo $objResult7["product_name"];?></option>

<?php
}
?>
</select>

<input type='hidden' name = "product_code7"  id = "product_code7"  class="w3-input" readonly>

</td>
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
<td><input type='text' name = "discount_unit7"  id = "discount_unit7" class="w3-input"  style="color:black;text-align:right" /></td>

<td><input type='text' name = "sum_amount7"  id = "sum_amount7"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count7} * {product_price7} - {discount_unit7} * {sale_count7}'readonly/>
</td>
<td><input type='text' name = "warranty7"  id = "warranty7"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal7"  id = "cal7"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm7"  id = "pm7"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td>
<input type='text' name = "sale_remarkk7"  id = "sale_remarkk7"  class="w3-input" />
</td>
</tr>

<tr>
<td >
<?php/*
<input type='text' name = "product_code8"  id = "product_code8" class="w3-input" OnChange="JavaScript:doCallAjax('product_code8','product_name8','unit_name8','product_price8');"/> */?>

<select name="product8" class="w3-select" onchange="document.getElementById('product_code8').value = this.value.split('|')[0];

document.getElementById('product_name8').value  = this.value.split('|')[1]; 
document.getElementById('unit_name8').value  = this.value.split('|')[2];
document.getElementById('product_price8').value  = this.value.split('|')[3];
document.getElementById('discount_unit8').value  = '0';
">
<option value=""></option>
<?php
$strSQL8 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
while($objResult8 = mysqli_fetch_array($objQuery8))
{
?>
<option value="<?php echo $objResult8["product_code"];?>|<?php  echo $objResult8["product_name"];?>|<?php  echo $objResult8["unit_name"];?>|<?php  echo $objResult8["product_price"];?>"><?php echo $objResult8["product_code"];?> <?php  echo $objResult8["product_name"];?></option>

<?php
}
?>
</select>

<input type='hidden' name = "product_code8"  id = "product_code8"  class="w3-input" readonly>

</td>
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
<td><input type='text' name = "discount_unit8"  id = "discount_unit8" class="w3-input"  style="color:black;text-align:right" /></td>

<td><input type='text' name = "sum_amount8"  id = "sum_amount8"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count8} * {product_price8} - {discount_unit8} * {sale_count8}'readonly/>
</td>
<td><input type='text' name = "warranty8"  id = "warranty8"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal8"  id = "cal8"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm8"  id = "pm8"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td>
<input type='text' name = "sale_remarkk8"  id = "sale_remarkk8"  class="w3-input" />
</td>
</tr>

<tr>
<td >
<?php /*
<input type='text' name = "product_code9"  id = "product_code9" class="w3-input" OnChange="JavaScript:doCallAjax('product_code9','product_name9','unit_name9','product_price9');"/> */?>

<select name="product9" class="w3-select" onchange="document.getElementById('product_code9').value = this.value.split('|')[0];

document.getElementById('product_name9').value  = this.value.split('|')[1]; 
document.getElementById('unit_name9').value  = this.value.split('|')[2];
document.getElementById('product_price9').value  = this.value.split('|')[3];
document.getElementById('discount_unit9').value  = '0';
">
<option value=""></option>
<?php
$strSQL9 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
while($objResult9 = mysqli_fetch_array($objQuery9))
{
?>
<option value="<?php echo $objResult9["product_code"];?>|<?php  echo $objResult9["product_name"];?>|<?php  echo $objResult9["unit_name"];?>|<?php  echo $objResult9["product_price"];?>"><?php echo $objResult9["product_code"];?> <?php  echo $objResult9["product_name"];?></option>

<?php
}
?>
</select>

<input type='hidden' name = "product_code9"  id = "product_code9"  class="w3-input" readonly>

</td>
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
<td><input type='text' name = "discount_unit9"  id = "discount_unit9" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount9"  id = "sum_amount9"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count9} * {product_price9} - {discount_unit9} * {sale_count9}'readonly/>
</td>
<td><input type='text' name = "warranty9"  id = "warranty9"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal9"  id = "cal9"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm9"  id = "pm9"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td>
<input type='text' name = "sale_remarkk9"  id = "sale_remarkk9"  class="w3-input" />
</td>
</tr>

<tr>
<td > <?php /*
<input type='text' name = "product_code10"  id = "product_code10" class="w3-input" OnChange="JavaScript:doCallAjax('product_code10','product_name10','unit_name10','product_price10');"/> */?>


<select name="product10" class="w3-select" onchange="document.getElementById('product_code10').value = this.value.split('|')[0];

document.getElementById('product_name10').value  = this.value.split('|')[1]; 
document.getElementById('unit_name10').value  = this.value.split('|')[2];
document.getElementById('product_price10').value  = this.value.split('|')[3];
document.getElementById('discount_unit10').value  = '0';
">
<option value=""></option>
<?php
$strSQL10 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
while($objResult10 = mysqli_fetch_array($objQuery10))
{
?>
<option value="<?php echo $objResult10["product_code"];?>|<?php  echo $objResult10["product_name"];?>|<?php  echo $objResult10["unit_name"];?>|<?php  echo $objResult10["product_price"];?>"><?php echo $objResult10["product_code"];?> <?php  echo $objResult10["product_name"];?></option>

<?php
}
?>
</select>

<input type='hidden' name = "product_code10"  id = "product_code10"  class="w3-input" readonly>

</td>
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
<td><input type='text' name = "discount_unit10"  id = "discount_unit10" class="w3-input"  style="color:black;text-align:right" /></td>


<td><input type='text' name = "sum_amount10"  id = "sum_amount10"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count10} * {product_price10} - {discount_unit10} * {sale_count10}'readonly/>
</td>
<td><input type='text' name = "warranty10"  id = "warranty10"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal10"  id = "cal10"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "pm10"  id = "pm10"  class="w3-input"  OnKeyPress="return chkNumber(this)"  /></td>

<td>
<input type='text' name = "sale_remarkk10"  id = "sale_remarkk10"  class="w3-input" />
</td>
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















































