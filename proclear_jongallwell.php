
<font color='red'>**กรุณาเลือกสินค้าที่ต้องการเคลียร์เท่านั้น !!!</font>

<table width="100%" border="0" class="w3-table">
<thead>
	<th>เลือกสินค้า</th>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
	<th>ส่วนลด/หน่วย</th>
    <th>ยอดรวม</th>
	<th>รับประกัน (ปี)</th>
	<th>Cal(ครั้ง/ปี)</th>
	<th>PM (ครั้ง/ปี)</th>
    <th>หมายเหตุ</th>	

</thead>
<tbody>
<?php

$i = 1;


$strSQL1 = "SELECT * FROM (hos__subjongpro LEFT JOIN tb_product ON hos__subjongpro.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult1['product_id']."' and jong_ckk = '1' and jong_no ='".$objResult["iv_no"]."' and status_sol='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult1['product_id']."' and jong_ckk = '1' and jong_no ='".$objResult["iv_no"]."' and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_assoc($qry13);
	

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
	
$count2 = $objResult1["count"] - ($count3+$count13);



	
	if($count2=='0'){

}else{

	?>
<tr>
<td style="width:5%;">
<input type='checkbox' name = "jong_ckk[<?php echo $objResult1["id"];?>]"  checked="checked" value="1" id = "jong_ckk[<?php echo $objResult1["id"];?>]" >
</td>
<td >
<input type='hidden' name = "id[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["id"];?>" id = "id[]"    size='16' readonly/>
<input type='hidden' name = "product_id[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["product_id"];?>" id = "product_id[<?php echo $objResult1["id"];?>]"    size='16' class="w3-input"  />
 <input type='text' name = "product_code[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["access_code"];?>" id = "product_code[<?php echo $objResult1["id"];?>]"  class="w3-input"    size='16' readonly/>  


</td>


<td><input type='text' name = "product_name[<?php echo $objResult1["id"];?>]"  value="<?php echo $objResult1["sol_name"];?>" id = "product_name[<?php echo $objResult1["id"];?>]"  class="w3-input" readonly></td>	
	
	

<td><input type='text' name = "unit_name[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[<?php echo $objResult1["id"];?>]"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[<?php echo $objResult1["id"];?>]" value="<?php echo $count2;?>" id = "sale_count[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:center"   size='7' ></td>

<td><input type='text' name = "product_price[<?php echo $objResult1["id"];?>]"  id = "product_price[<?php echo $objResult1["id"];?>]"  class="w3-input"  style="color:black;text-align:right"   /></td>

<td><input type='text' name = "discount_unit[<?php echo $objResult1["id"];?>]"  id = "discount_unit[<?php echo $objResult1["id"];?>]"  class="w3-input"  style="color:black;text-align:right"   /></td>


<td><input type='text' name = "sum_amount[<?php echo $objResult1["id"];?>]"  id = "sum_amount[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:right"    readonly/></td>


<td><input type='text' name = "warranty[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["warranty"];?>" id = "warranty[<?php echo $objResult1["id"];?>]"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["cal"];?>" id = "cal[<?php echo $objResult1["id"];?>]"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "pm[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["pm"];?>" id = "pm[<?php echo $objResult1["id"];?>]"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "sale_remarkk[<?php echo $objResult1["id"];?>]"  id = "sale_remarkk[<?php echo $objResult1["id"];?>]"  class="w3-input"    size='13' /></td>



</tr>


<?php
	}	
	$i++;
	

}


?>
</tbody>
</table>