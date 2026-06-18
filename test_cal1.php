<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<form action="" name="frmAdd" method="post">




Select Line :
<select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
<?
for($i=1;$i<=100;$i++)
{
if($_GET["Line"] == $i)
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
<td> <div align="center" style="font-weight: bold">No. </div></td>
    <td> <div align="center" style="font-weight: bold">Product Code </div></td>
    <td> <div align="center" style="font-weight: bold">Product Name </div></td>
    <td> <div align="center" style="font-weight: bold">Unit Name </div></td>
    <td> <div align="center" style="font-weight: bold">Sale Count </div></td>
    <td> <div align="center" style="font-weight: bold">Product Price </div></td>
    <td> <div align="center" style="font-weight: bold">Amount </div></td>
    <td> <div align="center" style="font-weight: bold">Sale Remark </div></td>
    <td> <div align="center" style="font-weight: bold">Stock Remark </div></td>
</tr>

<?

$line = $_GET["Line"];

if($line == 0){$line=1;}

for($i=1;$i<=$line;$i++)

{

?>

<tr>
<td> <?php echo $i;?> 
</td>


<td><div align="center">

<select name="product<?php echo $i;?><?php echo $objResult["running"];?>" class="button4" style="width:120px"  onchange="document.getElementById('product_code<?php echo $i;?>').value = this.value.split('|')[0];

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
<option value="<?php echo $objResult2["product_code"];?>|<?php  echo $objResult2["product_name"];?>|<?php  echo $objResult2["unit_name"];?>|<?php  echo $objResult2["product_price"];?>" <?php echo $sel;?>><?php echo $objResult2["product_code"];?> |<?php  echo $objResult2["product_name"];?>|<?php  echo $objResult2["unit_name"];?>|<?php  echo $objResult2["product_price"];?></option>

<?php
}
?>
</select>

 <input type='text' name = "product_code<?php echo $i;?>"  id = "product_code<?php echo $i;?>"  class="button4"    size='10' /> 

</div></td>

<td> <input type='text' name = "product_name<?php echo $i;?>"  id = "product_name<?php echo $i;?>"  class="button4"    size='25' /></td>

<td><input type='text' name = "unit_name<?php echo $i;?>"  id = "unit_name<?php echo $i;?>"  class="button4"    size='8' /></td>

<td><input type='text' name = "sale_count<?php echo $i;?>"  id = "sale_count<?php echo $i;?>"  class="button4" style="color:black;text-align:center"   size='8' /></td>

<td><input type='text' name = "product_price<?php echo $i;?>"  id = "product_price<?php echo $i;?>"  class="button4"  style="color:black;text-align:right"   size='10' /></td>

<td><input type='text' name = "amount<?php echo $i;?>"  id = "amount<?php echo $i;?>"  class="button4" style="color:black;text-align:right"  size='10' value='<?php jAutoCalc"{sale_count echo $i} * {product_price echo $i}"; ?>' /></td>
<?php/* */?>
<td><input type='text' name = "sale_remark<?php echo $i;?>"  id = "sale_remark<?php echo $i;?>"  class="button4"    size='15' /></td>

<td><input type='text' name = "stock_remark<?php echo $i;?>"  id = "stock_remark<?php echo $i;?>"  class="button4"    size='15' /></td>


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

<input type="submit" name="submit" value="submit">

<input type="hidden" name="hdnLine" value="<?php echo $i;?>">

</form>
