<table width="100%" border="0" class="w3-table">
<tr>
    <td align="center"><b>รหัสสินค้า</b></td>
    <td align="center"><b>ชื่อสินค้า</b></td>
    <td align="center"><b>หน่วย</b></td>
    <td align="center"><b>จำนวน</b></td>
    <td align="center"><b>ราคาต่อหน่วย</b></td>
	<td align="center"><b>ส่วนลด/หน่วย</b></td>
    <td align="center"><b>ยอดรวม</b></td>
	 <td align="center"><b>รับประกัน (ปี</b></td>
	 <td align="center"><b>Cal (ครั้ง/ปี)</b></td>
	 <td align="center"><b>PM (ครั้ง/ปี)</b></td>
	 <td align="center"><b>หมายเลขเครื่อง</b></td>
    <td align="center"><b>หมายเหตุ</b></td>

</tr>
<tbody>
<?php

$i = 1;


$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
//echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


while($objResult1 = mysqli_fetch_array($objQuery1))
{



if($objResult1["sn_number"] !=''){
$sn_number =  $objResult1["sn_number"];
$str_arr = explode("\n",$sn_number);
foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);

	
/*$strSQL21 = "SELECT ref_id FROM so__main  WHERE clear_brnp_no LIKE '%".$objResult["doc_no"]."%' ";
 
//echo $strSQL21;

$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$objResult21 = mysqli_fetch_array($objQuery21);*/
	
$strSQL2 = "SELECT sn_number FROM  so__submain  WHERE clear_ivno ='".$objResult["doc_no"]."' and product_id = '".$objResult1['product_id']."' and sn_number LIKE '".$product_sn1."' and clear_br = '1'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

$strSQL12 = "SELECT sn FROM  hos__subso  WHERE clear_ivno ='".$objResult["doc_no"]."' and product_id = '".$objResult1['product_id']."' and sn = '".$product_sn1."' and clear_br = '1'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rows12 = mysqli_num_rows($objQuery12);
	
$strSQL31 = "SELECT ref_id FROM hos__receive  WHERE iv_no = '".$objResult["doc_no"]."' ";

$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$objResult31 = mysqli_fetch_array($objQuery31);

	
$strSQL3 = "SELECT sn FROM   hos__subreceive  WHERE ref_idd = '".$objResult31["ref_id"]."' and product_id = '".$objResult1['product_id']."' and sn = '".$product_sn1."' ";

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);

$sql2 = "SELECT sn  FROM   hos__subsmp   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and br_no ='".$objResult["doc_no"]."'  and sn ='".$product_sn1."'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows19 = mysqli_num_rows($qry2);
//$rs2 = mysqli_fetch_assoc($qry2);

if($Num_Rows2 > 0){

}else if ($Num_Rows3 > 0){

}else if ($Num_Rows19 > 0){

}else if ($Num_Rows12 > 0){

}else{

if($product_sn1 !=''){
?>
<tr>

<td >
<input type='hidden' name = "id[]" value="<?php echo $objResult1["id"];?>" id = "id[]"    size='16' readonly/>
<input type='text' name = "product_id[]" value="<?php echo $objResult1["product_id"];?>" id = "product_id[]"    size='16' class="w3-input" />
 <input type='hidden' name = "product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sol_code"];?>" id = "product_code[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='16' readonly/>  
</td>

<td><input type='text' name = "product_name[]<?php echo $objResult1["id"];?>"  value="<?php echo $objResult1["sol_name"];?>" id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly></td>	
	
<td><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo "1";?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"   size='7' readonly></td>

<td><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php $price_per_unit= $objResult1["price_per_unit"]; echo number_format( $price_per_unit,2)."";?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   /></td>

<td><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php $discount_unit= $objResult1["discount_unit"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   /></td>


<td><input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>" id = "sum_amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"    readonly/></td>


<td><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["warranty"];?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "sn_number[]<?php echo $objResult1["id"];?>"  id = "sn_number[]<?php echo $objResult1["id"];?>" value="<?php echo $product_sn1;?>" class="w3-input"    size='13' /></td>

<td><input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input"    size='13' /></td>




</tr>


<?php
}
}
}
}

else {

	/*$sql31 = "SELECT ref_id   FROM  so__main  where clear_brnp_no LIKE '%".$objResult["doc_no"]."%' ";
echo $sql31;
$qry31 = mysqli_query($conn,$sql31) or die(mysqli_error());
	$rs31 = mysqli_fetch_assoc($qry31);*/
	
$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["doc_no"]."'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["doc_no"]."'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_assoc($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$objResult["doc_no"]."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
	$rs41 = mysqli_fetch_assoc($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41["ref_id"]."' and product_id = '".$objResult1['product_id']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);

$sql2 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and br_no ='".$objResult["doc_no"]."'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs2["count3"];
	
$count2 = $objResult1["sale_count"] - ($count3+$count4+$count5+$count13);



	
	if($count2=='0'){

}else{

	?>
<tr>

<td >
<input type='hidden' name = "id[]" value="<?php echo $objResult1["id"];?>" id = "id[]"    size='16' readonly/>
<input type='text' name = "product_id[]" value="<?php echo $objResult1["product_id"];?>" id = "product_id[]"    size='16' class="w3-input"  />
 <input type='hidden' name = "product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sol_code"];?>" id = "product_code[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='16' readonly/>  


</td>


<td><input type='text' name = "product_name[]<?php echo $objResult1["id"];?>"  value="<?php echo $objResult1["sol_name"];?>" id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly></td>	
	
	

<td><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $count2;?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"   size='7' readonly></td>

<td><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php $price_per_unit= $objResult1["price_per_unit"]; echo number_format( $price_per_unit,2)."";?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   /></td>

<td><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php $discount_unit= $objResult1["discount_unit"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   /></td>


<td><input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>" id = "sum_amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"    readonly/></td>


<td><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["warranty"];?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "sn_number[]<?php echo $objResult1["id"];?>"  id = "sn_number[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sn_number"];?>" class="w3-input"    size='13' /></td>

<td><input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input"    size='13' /></td>



</tr>
<?php }
}
?>




<?php
	$i++;
	

}


?>
</tbody>
</table>