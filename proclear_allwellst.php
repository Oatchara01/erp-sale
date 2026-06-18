<table width="100%" border="0" class="w3-table">
<tr>
     <th>ID สินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>

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

$strSQL2 = "SELECT sn_number FROM  so__submain  WHERE clear_ivno ='".$objResult["doc_no"]."' and product_id = '".$objResult1['product_id']."' and sn_number LIKE '".$product_sn1."' and clear_br = '1' and status_sol='Approve'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

$strSQL12 = "SELECT sn FROM  hos__subso  WHERE clear_ivno ='".$objResult["doc_no"]."' and product_id = '".$objResult1['product_id']."' and sn = '".$product_sn1."' and clear_br = '1' and status_so='Approve'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rows12 = mysqli_num_rows($objQuery12);
	
$strSQL3 = "SELECT sn FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd) WHERE iv_no = '".$objResult["doc_no"]."' and product_id = '".$objResult1['product_id']."' and sn = '".$product_sn1."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);


$sql2 = "SELECT sn  FROM   hos__subsmp   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and br_no ='".$objResult["doc_no"]."'  and sn ='".$product_sn1."' and status_smp ='Approve'";
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

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo "1";?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"   size='7' /></td>

<td><input type='text' name = "sn[]<?php echo $objResult1["id"];?>"  id = "sn[]<?php echo $objResult1["id"];?>" value="<?php echo $product_sn1; ?>" class="w3-input"    size='13' /></td>

<td><input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input"    size='13' /></td>




</tr>


<?php
}
}
}
}

else if($objResult1["sn"]==''){

$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["doc_no"]."' and status_sol ='Approve'";
	//echo $sql3;
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["doc_no"]."' and status_so ='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_assoc($qry13);
	
/*$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$objResult["doc_no"]."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
	$rs41 = mysqli_fetch_assoc($qry41);*/

$sql4 = "SELECT sum(count) as count4   FROM   (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd) where iv_no = '".$objResult["doc_no"]."'  and product_id = '".$objResult1['product_id']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);

$sql2 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and br_no ='".$objResult["doc_no"]."' and status_smp ='Approve'";
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

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $count2;?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"   size='7' /></td>


<td><input type='text' name = "sn[]<?php echo $objResult1["id"];?>"  id = "sn[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sn_number"];?>" class="w3-input"    size='13' /></td>

<td><input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input"    size='13' /></td>



</tr>
<?php 
	}
}

?>




<?php
	$i++;
	

}


?>
</tbody>
</table>