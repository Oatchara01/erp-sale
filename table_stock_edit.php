<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery-3.4.1.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/w3.css">
<?php 
include('dbconnect.php');
$strSQL1 = "SELECT * FROM so__submain WHERE ref_idd = '".$_GET["ref_id"]."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
?>
<table width="100%" border="0" class="w3-table" id="table">
<tr>
	<td width="3%" align="center">No.</td>
    <td width="12%" align="center">รหัสสินค้า</td>
    <td width="10%" align="center">รหัสจัดสินค้า</td>
    <td width="15%" align="center">รายการสินค้า</td>
    <td width="10%" align="center">หน่วย</td>
    <td width="10%" align="center">จำนวน</td>
    <td width="12%" align="center">ราคาต่อหน่วย</td>
	<td width="12%" align="center">ส่วนลด</td>
    <td width="12%" align="center">หมายเหตุ</td>
	<td width="12%" align="center">หมายเลขเครื่อง</td>
</tr>
<?php

$i = 1;

while($objResult1 = mysqli_fetch_array($objQuery1))

{
?>
<tr>

<td><?=$i?> <input type='hidden' name = "Number_run<?php echo $i;?>" style="color:black;text-align:center" id = "Number_run[]<?php echo $i;?>" value ="<?php echo $i;?>" />   <input type='text' name = "id<?php echo $i;?>" value="<?php echo $objResult1["id"];?>" id = "id<?php echo $i;?>"    size='16' readonly/> 
</td>

<td style="width:15%;" class="code">
 <input type='code' name = "product_code<?php echo $i;?>" value="<?php echo $objResult1["product_code"];?>" id='pd1<?php echo $i;?>' class="pd1"  size='16'/>  
</td>

<td class="code">
<input type='code' name = "product_code_same<?php echo $i;?>"  value="<?php echo $objResult1["product_code_same"];?>"  id='pd2<?php echo $i;?>' class="pd2" size='9' OnChange="return aaa()"/></td>

<td> <input type='text' name = "product_name[]<?php echo $objResult1["id"];?>"  value="<?php echo $objResult1["product_name"];?>" id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly ></td>

<td><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"   size='7' readonly/></td>

<td><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["price_per_unit"];?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   size='10' readonly/></td>


<td><input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input"    size='13' readonly/></td>

<td><input type='text' name = "sn_number[]<?php echo $objResult1["id"];?>"  id = "sn_number[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sn_number"];?>" class="w3-input" /></td>



</tr>

<?

	$i++;

}


?>

</table>
<!--
<script>
function aaa(){
	if ((document.getElementById("product_code".value)!=(document.getElementById("product_code_same".value)){
		alert("สินค้าไม่ถูกต้อง กรุณาตรวจสอบสินค้าค่ะ");
		alert ("product_code");
		alert ("product_code_same");
		document.getElementById("product_code_same").value='';
		return false;
	}
	else{
		return true;
	}
}
</script>
-->
<script type="text/javascript">
function bbb() {
var i = 1;
while
 (i < 99) {
  var a=document.getElementById("product_code"+i.value);
  var b=document.getElementById("product_code_same"+i.value);
  if (a!=b){
		alert("สินค้าไม่ถูกต้อง กรุณาตรวจสอบสินค้าค่ะ");
		alert (a);
		alert (b);
		b='';
		return false;
	}
	else{
		return true;
	}
}
</script>

<script>
$('#table > tbody  > tr').each(function() {
	$('input[type=code]').change(function() {
	if ($(".pd2").val() != $(".pd1").val())
	{
		alert("Not Same Value!");
		return false;
	}
	else
	{
		return true;
	}
	});
});

</script>

<script>
$(document).ready(function(){
  $("input").change(function(){
    $("pd1").each(function(){
      if ($)
      {
      }
    });
  });
});
</script>