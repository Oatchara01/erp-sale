<html>
<head>
<title>Sale Online</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script src="dist/jautocalc.js"></script></head>
</head>
<body>
<!--<form action="save_register" name="frmAdd" method="post">-->
Select Line :
<select name="menu1"  class="w3-select" style="width:5%" onChange="MM_jumpMenu('parent',this,0)">
<?
for($i=1;$i<=100;$i++)
{
if($_POST["Line"] == $i)
{
$sel = "selected";
}
else
{
$sel = "";

}

?>

<option value="<?php echo $_SERVER["PHP_SELF"];?>?Line=<?php echo $i;?>" <?php echo $sel;?>><?php echo $i;?></option>

<?
}

?>

</select>
<table width="100%" border="0" class="w3-table">

<tr>
	<td>No. </td>
    <td>Product Code</td>
    <td>Product Name </td>
    <td>Unit Name </td>
    <td>Sale Count </td>
    <td>Product Price </td>
	<td>Discount/Unit</td>
    <td>Amount </td>
    <td>Sale Remark </td>
    <td>Stock Remark </td>
</tr>

<?

$line = $_GET["Line"];

if($line == 0){$line=1;}

for($i=1;$i<=$line;$i++)

{

?>

<tr>
<td><?php echo $i;?> <input type='hidden' name = "Number_run<?php echo $i;?>" style="color:black;text-align:center" id = "Number_run<?php echo $i;?>" value ="<?php echo $i;?>" size='1' />  
</td>

<td style="width:15%;"><div align="center">
<select name="product<?php echo $i;?>" class="w3-select" onchange="document.getElementById('product_code<?php echo $i;?>').value = this.value.split('|')[0];

document.getElementById('product_name<?php echo $i;?>').value  = this.value.split('|')[1]; 
document.getElementById('unit_name<?php echo $i;?>').value  = this.value.split('|')[2];
document.getElementById('product_price<?php echo $i;?>').value  = this.value.split('|')[3];
">
<option value=""></option>
<?php
$strSQL2 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2 = mysqli_fetch_array($objQuery2))
{
if($objResult["product_code"] == $objResult2["product_code"])
{
$sel = "selected";
}
else
{
$sel = ""; 
}
?>
<option value="<?php echo $objResult2["product_code"];?>|<?php  echo $objResult2["product_name"];?>|<?php  echo $objResult2["unit_name"];?>|<?php  echo $objResult2["product_price"];?>" <?php echo $sel;?>><?php echo $objResult2["product_code"];?></option>

<?php
}
?>
</select>
<input type='hidden' name = "product_code<?php echo $i;?>"  id = "product_code<?php echo $i;?>" /> 
</div></td>
<td>
<input type='text' name = "product_name<?php echo $i;?>"  id = "product_name<?php echo $i;?>"  class="w3-input" readonly>
</td>
<td>
<input type='text' name = "unit_name<?php echo $i;?>"  id = "unit_name<?php echo $i;?>"  class="w3-input" readonly/>
</td>
<td>
<input type='text' name = "sale_count<?php echo $i;?>"  id = "sale_count<?php echo $i;?>"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td>
<input type='text' name = "product_price<?php echo $i;?>"  id = "product_price<?php echo $i;?>"  class="w3-input"  style="color:black;text-align:right" />
</td>

<td><input type='text' name = "discount_unit<?php echo $i;?>"  id = "discount_unit<?php echo $i;?>"  class="w3-input"  style="color:black;text-align:right" /></td>



<td><input type='text' name = "sum_amount<?php echo $i;?>"  id = "sum_amount<?php echo $i;?>"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{product_price<?php echo $i;?>} * {sale_count<?php echo $i;?>} - {discount_unit<?php echo $i;?>} * {sale_count<?php echo $i;?>}' readonly/>
</td>
<?php/* */?>
<td>
<input type='text' name = "sale_remarkk<?php echo $i;?>"  id = "sale_remarkk<?php echo $i;?>"  class="w3-input" />
</td>
<td>
<input type='text' name = "stock_remark<?php echo $i;?>"  id = "stock_remark<?php echo $i;?>"  class="w3-input" />
</td>
</tr>
<?
}
?>
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
</body>
</html>
