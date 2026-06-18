<font color='red'>**กรุณาเลือกสินค้าที่ต้องการเคลียร์เท่านั้น !!!</font>
<table width="100%" border="0" class="w3-table">
<thead>
	  <th>เลือกสินค้าคืน</th>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>

</thead>
<tbody>
<?php

$i = 1;


$strSQL1 = "SELECT * FROM  (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$objResult["ref_id_br"]."' ";
//echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


while($objResult1 = mysqli_fetch_array($objQuery1))
{

if($objResult1["sn"] !=''){


$sn_number =  $objResult1["sn"];
$str_arr = explode("\n",$sn_number);
foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);

$strSQL2 = "SELECT sn FROM   hos__subso  WHERE clear_ivno = '".$objResult["iv_no"]."' and product_id = '".$objResult1['product_id']."' and sn = '".$product_sn1."' and status_so ='Approve'";

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

$strSQL3 = "SELECT sn FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd) WHERE iv_no = '".$objResult["iv_no"]."' and product_id = '".$objResult1['product_id']."' and sn = '".$product_sn1."' ";

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);

$sql2 = "SELECT sn  FROM   hos__subsmp   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and br_no ='".$objResult["iv_no"]."' and sn ='".$product_sn1."'  and status_smp ='Approve'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows19 = mysqli_num_rows($qry2);
	
$sql5 = "SELECT sn  FROM   hos__subspr   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."' and sn ='".$product_sn1."'  and status_spr ='Approve'";
$qry5 = mysqli_query($conn,$sql5) or die(mysqli_error());
$Num_Rows20 = mysqli_num_rows($qry5);


if($Num_Rows2 > 0){

}else if ($Num_Rows3 > 0){

}else if ($Num_Rows19 > 0){

}else if ($Num_Rows20 > 0){

}else{

if($product_sn1 !=''){
	
?>
<tr>
<td style="width:5%;">
<input type='checkbox' name = "clear_br[<?php echo $objResult1["id"];?>]" value="1" id = "clear_br[<?php echo $objResult1["id"];?>]" >
			
			</td>
	<td style="width:10%;">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">
<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='hidden' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"  size="7"  class="button4" OnChange="JavaScript:doCallAjax('product_code[]<?php echo $objResult1["id"];?>','product_name[]<?php echo $objResult1["id"];?>','unit_name[]<?php echo $objResult1["id"];?>','product_price[]<?php echo $objResult1["id"];?>','discount_unit[]<?php echo $objResult1["id"];?>');"/></td>

<td  style="width:12%;">
<textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly><?php echo $objResult1["sol_name"];  echo $objResult1["sale_remark"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo "1";?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>


<td style="width:10%;">

<textarea name = "sn[]<?php echo $objResult1["id"];?>"  id = "sn[]<?php echo $objResult1["id"];?>"  class="w3-input" /><?php echo $product_sn1;?></textarea>
</td>


<td style="width:10%;">
<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />
</td>
</tr>

<?php
}
}
}
}

else if($objResult1["sn"]=='' ){

	$sql3 = "SELECT sum(sale_count) as count3   FROM   hos__subspr   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."'  and status_spr ='Approve'";
	
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."'  and status_so ='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$objResult["iv_no"]."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$objResult1['product_id']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and br_no ='".$objResult["iv_no"]."'  and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = $objResult1["count"] - ($count3+$count4+$count5+$count13);
		
	if($count2=='0' or $count2<'0'){

}else{

	?>
<tr>
		<td style="width:5%;">
<input type='checkbox' name = "clear_br[<?php echo $objResult1["id"];?>]" value="1" id = "clear_br[<?php echo $objResult1["id"];?>]" >
			
			</td>
	<td style="width:10%;">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">
<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">
		
		<input type="text"  class="w3-input w3-center" size="1%" value="<?php echo $objResult1['access_code']; ?>">

<input type='hidden' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"  size="7"  class="button4" OnChange="JavaScript:doCallAjax('product_code[]<?php echo $objResult1["id"];?>','product_name[]<?php echo $objResult1["id"];?>','unit_name[]<?php echo $objResult1["id"];?>','product_price[]<?php echo $objResult1["id"];?>','discount_unit[]<?php echo $objResult1["id"];?>');"/></td>

<td  style="width:12%;">
<textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly><?php echo $objResult1["sol_name"]; echo $objResult1["sale_remark"]; ?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $count2;?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:10%;">

<textarea name = "sn[]<?php echo $objResult1["id"];?>"  id = "sn[]<?php echo $objResult1["id"];?>"  class="w3-input" /><?php echo $objResult1["sn"];?></textarea>
</td>


<td style="width:10%;">
<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />
</td>
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