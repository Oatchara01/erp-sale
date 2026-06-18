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

<style type="text/css">

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 12px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button10 {
    background-color: #339900;
    border: none;
    color: white;
    padding: 12px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
.buttonn {
    background-color: #FFFFFF;
    border: none;
    color: #000000;
    padding: 6px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 30px;}
.button5 {border-radius: 50%;}

</style>
<style type="text/css">
<!--
.style15 {
	font-size: 16px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->
</style>

</head>
<body>
<!--<form action="save_register" name="frmAdd" method="post">-->

</br>


Select Line :
<select name="menu1"  class="buttonn button4" onChange="MM_jumpMenu('parent',this,0)">
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
<table width="100%" border="1">

<tr>
<td width="3%" align="center" class='style15'>No. </td>
    <td width="15%" align="center" class='style15'>Product Code</td>
    <td width="19%" align="center" class='style15'>Product Name </td>
    <td width="10%" align="center" class='style15'>Unit Name </td>
    <td width="8%" align="center" class='style15'>Sale Count </td>
    <td width="10%" align="center" class='style15'>Product Price </td>
    <td width="10%" align="center" class='style15'>Amount </td>
    <td width="12%" align="center" class='style15'>Sale Remark </td>
    <td width="12%" align="center" class='style15'>Stock Remark </td>
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

<select name="product<?php echo $i;?>" class="buttonn button4" style="width:160px"  onchange="document.getElementById('product_code<?php echo $i;?>').value = this.value.split('|')[0];

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

 <input type='text' name = "product_code<?php echo $i;?>"  id = "product_code<?php echo $i;?>"  class="button4"    size='16' /> 

</div></td>

<td> <textarea type='text' name = "product_name<?php echo $i;?>"  id = "product_name<?php echo $i;?>"  class="button4"   cols="20" ></textarea></td>

<td><input type='text' name = "unit_name<?php echo $i;?>"  id = "unit_name<?php echo $i;?>"  class="button4"    size='9' /></td>

<td><input type='text' name = "sale_count<?php echo $i;?>"  id = "sale_count<?php echo $i;?>"  class="button4" style="color:black;text-align:center"   size='7' /></td>

<td><input type='text' name = "product_price<?php echo $i;?>"  id = "product_price<?php echo $i;?>"  class="button4"  style="color:black;text-align:right"   size='10' /></td>

<td><input type='text' name = "sum_amount<?php echo $i;?>"  id = "sum_amount<?php echo $i;?>"  class="button4" style="color:black;text-align:right"  size='10' value="" jAutoCalc= '{sale_count<?php echo $i;?>} * {product_price<?php echo $i;?>}'/></td>
<?php/* */?>
<td><input type='text' name = "sale_remarkk<?php echo $i;?>"  id = "sale_remarkk<?php echo $i;?>"  class="button4"    size='13' /></td>

<td><input type='text' name = "stock_remark<?php echo $i;?>"  id = "stock_remark<?php echo $i;?>"  class="button4"    size='13' /></td>


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
