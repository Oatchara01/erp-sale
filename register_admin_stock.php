<html>
<head>
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
<select name="menu1"  class="w3-select" style="width:5%;" onChange="MM_jumpMenu('parent',this,0)">
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
<td width="3%" align="center">No. </td>
    <td width="12%" align="center">รหัสสินค้า</td>
    <td width="10%" align="center">รหัสจัดสินค้า</td>
    <td width="10%" align="center">การตรวจทาน</td>
    <td width="15%" align="center">รายการสินค้า</td>
    <td width="10%" align="center">หน่วย</td>
    <td width="10%" align="center">จำนวน</td>
    <td width="12%" align="center">ราคาต่อหน่วย</td>
    <td width="12%" align="center">หมายเหตุ</td>
	<td width="12%" align="center">หมายเลขเครื่อง</td>

</tr>

<?

$line = $_GET["Line"];

if($line == 0){$line=1;}

for($i=1;$i<=$line;$i++)

{

?>
<tr>
<td class='style15'><?php echo $i;?> <input type='hidden' name = "Number_run<?php echo $i;?>" style="color:black;text-align:center" id = "Number_run<?php echo $i;?>" value ="<?php echo $i;?>" class="button4"    size='1' />  
</td>
<td><div align="center">
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
<option value="<?php echo $objResult2["product_code"];?>|<?php  echo $objResult2["product_name"];?>|<?php  echo $objResult2["unit_name"];?>|<?php  echo $objResult2["product_price"];?>" <?php echo $sel;?>><?php echo $objResult2["product_code"];?> |<?php  echo $objResult2["product_name"];?>|<?php  echo $objResult2["unit_name"];?>|<?php  echo $objResult2["product_price"];?></option>

<?php
}
?>
</select>
<input type='hidden' name = "product_code<?php echo $i;?>"  id = "product_code<?php echo $i;?>"  class="button4"    size='10' /> 
</div></td>
<td><input type='text' name = "product_code_same<?php echo $i;?>"  id = "product_code_same<?php echo $i;?>"  class="w3-input"    size='9' /></td>
<td><input type='text' name = "test<?php echo $i;?>"  id = "test<?php echo $i;?>"  class="w3-input"    size='9' /></td>
<td><input type='text' name = "product_name<?php echo $i;?>"  id = "product_name<?php echo $i;?>"  class="w3-input"></td>
<td><input type='text' name = "unit_name<?php echo $i;?>"  id = "unit_name<?php echo $i;?>"  class="w3-input" /></td>
<td><input type='text' name = "sale_count<?php echo $i;?>"  id = "sale_count<?php echo $i;?>"  class="w3-input" style="color:black;text-align:center" /></td>
<td><input type='text' name = "product_price<?php echo $i;?>"  id = "product_price<?php echo $i;?>"  class="w3-input"  style="color:black;text-align:right" /></td>
<td><input type='text' name = "sale_remarkk<?php echo $i;?>"  id = "sale_remarkk<?php echo $i;?>"  class="w3-input" /></td>
<td><input type='text' name = "sn_number<?php echo $i;?>"  id = "sn_number<?php echo $i;?>"  class="w3-input" /></td>
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
