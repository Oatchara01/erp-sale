
<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery-3.4.1.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/w3.css">
<?php 
include('dbconnect.php');
$sql = "SELECT * FROM (hos__subchange LEFT JOIN tb_product ON hos__subchange.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
$query = mysqli_query($conn,$sql) or die ("Error Query [".$sql."]");
?>


<table width="100%" border="0" class="w3-table">
<thead>
    <th>รหัสสินค้า</th>
	 <th>รหัสจัดสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>แลกเข้า</th>
	<th>แลกออก</th>
	<th>จำนวนจัดสินค้า</th>
    <th>ราคาต่อหน่วย</th>
    <th>ยอดรวม</th>
	<th>หมายเหตุ Sale</th>
	<th>หมายเหตุ Stock</th>
	<th>หมายเลขเครื่อง</th>

</thead>
<tbody>
<?php




$i = 1;
while($fetch = mysqli_fetch_array($query))
{
?>
<tr>
<td style="width:10%;">   <input type="hidden" name="id[<?php echo $i?>]" class="w3-input w3-center" size="1%" value="<?php echo $fetch['id']; ?>">

   <input type="text" name="product_code<?=$i?>"  id="product_code<?php echo $i; ?>" class="w3-input" size="8%" value="<?php echo $fetch['sol_code'];?>" readonly></td>
   <td style="width:10%;">
   <input type="hidden" name="product_code_1[<?php echo $i?>]"  id="product_code_1[<?php echo $i?>]" class="w3-input" size="8%" value="<?php echo $fetch['product_code'];?>" readonly>

   <input name="product_code_same[<? echo $i?>]" value="<?php echo $fetch['code_same'];?>" id="product_code_same<?=$i?>" type="text" class="w3-input" size="8%" onblur="JavaScript:fncAlert([<? echo $i?>]);"></td>



<td style="width:15%;"><textarea name = "product_name[<?php echo $i?>]"   id = "product_name[<?php echo $i?>]"  class="w3-input" readonly><?php echo $fetch["access_name"];?> <?php echo $fetch["sale_remark"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[<?php echo $i?>]" value="<?php echo $fetch["unit_name"];?>" id = "unit_name[<?php echo $i?>]"  class="w3-input"    readonly/></td>


<td style="width:5%;"><input type='text' name = "count_stock[<? echo $i?>]" value="<?php echo $fetch["count_stock"];?>" id = "count_stock[<? echo $i?>]"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:5%;"><input type='text' name = "count_sale[<? echo $i?>]" value="<?php echo $fetch["count_sale"];?>" id = "count_sale[<? echo $i?>]"  class="w3-input" style="color:black;text-align:center"    />
	<input type="hidden" name="sale_count<?=$i?>" id="sale_count<?=$i?>" class="w3-input w3-center" size="2%" value="<?php if($fetch["count_sale"] !='0.00'){ echo $fetch['count_sale']; }else{  echo $fetch['count_stock']; }  ?>" readonly>
	</td>

	<td style="width:5%;">
   
   <input name="sale_count_same[<? echo $i?>]" value="<?php if($fetch['count_same']=='0'){ echo ''; }else{ echo $fetch['count_same']; }?>" id="sale_count_same<?=$i?>" type="text" class="w3-input" size="8%" onblur="JavaScript:fnc([<? echo $i?>]);" required>
   <input name="c3" id="c3" value="<?php echo $i; ?>" type="hidden">
   </td>	
	
<td style="width:8%;"><input type='text' name = "product_price[<?php echo $i?>]" value="<?php  $price=$fetch["price"]; echo number_format( $price,2)."";?>" id = "product_price[<?php echo $i?>]"  class="w3-input"  style="color:black;text-align:right"  size="10"  /></td>


<td style="width:8%;">
<input type='text' name = "sum_amount[<?php echo $i?>]" value="<?php  $sum_amount=$fetch["amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[<?php echo $i?>]" size="10" class="w3-input" style="color:black;text-align:right"   />


</td>

<td style="width:10%;">

<textarea name = "sale_remarkk[<?php echo $i?>]"  id = "sale_remarkk[<?php echo $i?>]"  class="w3-input" /><?php echo $fetch["sale_remark"];?></textarea>

</td>
   <td style="width:10%;">
 
   <textarea name="stock_remark[<?php echo $i?>]" class="w3-input" rows="1"><?php echo $fetch['stock_remark']; ?></textarea></td>
   <td style="width:10%;"><textarea name="sn_number[<?php echo $i?>]" class="w3-input" rows="1"><?php echo $fetch['sn']; ?></textarea></td>


</tr>



<?php
	$i++;
	}
?>






 <input name="hdnCount2" id="hdnCount2" value="<?php echo $i; ?>" type="hidden"> 
			
  </tbody>
</table>

<script type="text/javascript">
   
    var i=1;
    var a = $('#hdnCount2').val();
    var b = $('#c2').val();

  for(i=b;i<=a;i++)
  {
   aa= i;
  }
  var test = aa;
            function ShowBrand(1) {
  alert('aa');
  
                var val1 = $('#product_code'+test).val();
       var val2 = $('#product_code_same'+test).val();
  if(val1 != val2){
       alert("ข้อมูลไม่ตรงค่ะ");
    $('#product_code_same'+test).focus();
    return false;
  }
  
             
   
        </script>
		<script language="javascript">
		    var i=1;
    var a = $('#hdnCount2').val();
    var b = $('#c2').val();

  for(i=b;i<=a;i++)
  {
   aa= i;
  }
   var test = aa;
function fncAlert(test)

{
	 var val1 = $('#product_code'+test).val();
       var val2 = $('#product_code_same'+test).val();
 if(val1 != val2){
	alert("ข้อมูลไม่ตรงค่ะ!");
$('#product_code_same'+test).val();
    return false;
 }
}
</script>


	<script language="javascript">
		    var i=1;
    var c = $('#hdnCount3').val();
    var d = $('#c3').val();

  for(i=d;i<=c;i++)
  {
   cc= i;
  }
   var test1 = cc;
function fnc(test1)

{
	 var val3 = $('#sale_count'+test1).val();
       var val4 = $('#sale_count_same'+test1).val();
 if(val3 != val4){
	alert("ข้อมูลไม่ตรงค่ะ!");
$('#sale_count_same'+test1).val();
    return false;
 }
}
</script>
