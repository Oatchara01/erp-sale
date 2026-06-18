<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";
 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานการเคลียร์ใบยืม</h4></div>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	
<div class="w3-quarter">
เลขที่ใบยืม :
 	
<input type='text' name='iv_no' id = 'iv_no' required>

</div>
	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<br>
<?php 
$iv_no = $_GET["iv_no"]; 
	
	
if($iv_no !='' ){ 
	
	
	

?>
<br>
<br><center><font size="4" color='blue'><b>รายการเคลียร์ใบยืมคงค้าง เลขที่ <?php echo $iv_no; ?></b></font></center><br>
	
	
	
	
	
<?php
	
$strSQL = "SELECT * FROM hos__br  where iv_no ='".$iv_no."' and status_doc = 'Approve'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);	

if($Num_Rows > 0){	
?>	
<div class="w3-half">	
<br><center><font size="4" color='black'><b>ERP Sale</b></font></center><br>	
	
<table border= "1" width="100%" class='w3-table'>

<tr bgcolor = 'grey'>
<td width="8%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="5%" align="center" class="style30">เขตการขาย</td> 
<td width="8%" align="center" class="style30">รหัสสินค้า</td> 	
<td width="15%" align="center" class="style30">สินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 


</tr>
	
<?php 
	
$strSQL1 = "SELECT * FROM hos__subbr  WHERE ref_idd_br = '".$objResult["ref_id_br"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1)){	
	
$strSQL12 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE  product_ID = '".$objResult1["product_id"]."'";
$objQuery12= mysqli_query($conn,$strSQL12) or die(mysqli_error());
$objResult12 = mysqli_fetch_array($objQuery12);	
	
$count_br = $objResult1["count"];	
?>	
<tr bgcolor = '#FF6666'>
<td align="center" class="style30"><?php echo $objResult["ref_id_br"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult["iv_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult["iv_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult["customer"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult1["count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>		
	
<?php	
$strSQL2 = "SELECT * FROM hos__subso WHERE  product_id = '".$objResult1["product_id"]."' and clear_ivno LIKE '%$iv_no%' and status_so='Approve'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){
	
$strSQL21 = "SELECT * FROM hos__so WHERE  ref_id = '".$objResult2["ref_idd"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);	


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_idd"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult21["iv_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult21["iv_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult21["bill_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult21["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult2["count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 
}
	?>	
	
	
	
<?php	
$strSQL2 = "SELECT * FROM hos__subspr WHERE  product_id = '".$objResult1["product_id"]."' and clear_ivno LIKE '%$iv_no%' and status_spr='Approve'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){

	
$strSQL21 = "SELECT * FROM hos__spr WHERE  ref_id = '".$objResult2["ref_idd"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);	


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_idd"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult21["spr_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult21["spr_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult21["customer"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult21["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult2["sale_count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 

} ?>	
		
	

<?php	
$strSQL2 = "SELECT * FROM hos__subsmp WHERE  product_id = '".$objResult1["product_id"]."' and br_no LIKE '%$iv_no%' and status_smp='Approve'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
	
while($objResult2 = mysqli_fetch_array($objQuery2)){
	
$count3 =+ $objResult2["sale_count"];	
$strSQL21 = "SELECT * FROM hos__smp WHERE  reff_idsmp = '".$objResult2["ref_idsmp"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);	


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_idsmp"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult21["smp_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult21["smp_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult21["customer_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult21["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult2["sale_count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 

} 
	?>	
	
	
	
<?php	
$strSQL2 = "SELECT DISTINCT ref_id FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$iv_no."' and product_id = '".$objResult1["product_id"]."'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
	
while($objResult2 = mysqli_fetch_array($objQuery2)){
	
$strSQL21 = "SELECT SUM(count) AS count  FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where ref_id = '".$objResult2["ref_id"]."' and product_id = '".$objResult1["product_id"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);
	
$strSQL22 = "SELECT * FROM hos__receive WHERE  ref_id = '".$objResult2["ref_id"]."'";
$objQuery22= mysqli_query($conn,$strSQL22) or die(mysqli_error());
$objResult22 = mysqli_fetch_array($objQuery22);	
	

?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_id"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult22["date_receive"]); ?></td>
<td align="center" class="style30"><?php echo "รับคืน"; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult22["customer_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult22["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult21["count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 
} 
	
	
	
$sql3 = "SELECT sum(sale_count) as count3   FROM  hos__subspr  where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$iv_no."' and status_spr='Approve'";

$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM hos__subso where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$iv_no."' and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$iv_no."' and product_id = '".$objResult1["product_id"]."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and br_no ='".$iv_no."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = ($count_br - ($count3+$count4+$count5+$count13));	
	
	
	?>	
		
<tr>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td class="style30"><div  align="left"></div></td> 
<td align="center" class="style30"></td> 
<td align="center" class="style30"></td> 	
<td class="style30" bgcolor='#66FF33'>ยอดยืมคงค้าง</td> 
<td class="style30" bgcolor='#66FF33'><div  align="right"><?php echo number_format($count2,0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
	
<?php 

}

	?>
		
	
</table>
	
	
</div><div class="w3-half">		
	
<br><center><font size="4" color='black'><b>ERP Stock</b></font></center><br>	
<table border= "1" width="100%" class='w3-table'>

<tr bgcolor = 'grey'>
<td width="8%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="5%" align="center" class="style30">เขตการขาย</td> 
<td width="8%" align="center" class="style30">รหัสสินค้า</td> 	
<td width="15%" align="center" class="style30">สินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 


</tr>
	
<?php 
	
$strSQL = "SELECT * FROM hos__br  where iv_no ='".$iv_no."' and status_doc = 'Approve'";
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

	
$strSQL1 = "SELECT * FROM hos__subbr  WHERE ref_idd_br = '".$objResult["ref_id_br"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)){	
	
$strSQL12 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE  product_ID = '".$objResult1["product_id"]."'";
$objQuery12= mysqli_query($conn,$strSQL12) or die(mysqli_error());
$objResult12 = mysqli_fetch_array($objQuery12);	
	
?>	
<tr bgcolor = '#FF6666'>
<td align="center" class="style30"><?php echo $objResult["ref_id_br"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult["iv_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult["iv_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult["customer"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult1["count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>
	
	
<?php	
	
$strSQL2 = "SELECT * FROM st__main WHERE iv_no = '".$iv_no."' and ref_idsale ='".$objResult["ref_id_br"]."'";
$objQuery2= mysqli_query($new,$strSQL2) or die(mysqli_error());
$objResult2 = mysqli_fetch_array($objQuery2);
	
	
$strSQL21 = "SELECT * FROM st__sbmain WHERE  product_id = '".$objResult1["product_id"]."' and ref_idd = '".$objResult2["ref_id"]."' and type_doc !='3'";
$objQuery21= mysqli_query($new,$strSQL21) or die(mysqli_error());
while($objResult21 = mysqli_fetch_array($objQuery21)){


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_id"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult2["iv_date"]); ?></td>
<td align="center" class="style30"><?php if($objResult21["type_doc"]=='23'){ echo "รับคืน"; }else{ echo $objResult21["stock_remark"]; } ?></td>
<td class="style30"><div  align="left"><?php echo $objResult2["customer_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult2["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult21["count_send"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php } ?>		
	
<?php
$strSQL23 = "SELECT SUM(count_send) AS count_send  FROM st__sbmain WHERE product_id = '".$objResult1["product_id"]."' and ref_idd = '".$objResult2["ref_id"]."' and type_doc ='3'";
$objQuery23= mysqli_query($new,$strSQL23) or die(mysqli_error());
$objResult23 = mysqli_fetch_array($objQuery23);	
	
?>	
<tr>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td class="style30"><div  align="left"></div></td> 
<td align="center" class="style30"></td> 
<td align="center" class="style30"></td> 	
<td class="style30" bgcolor='#66FF33'>ยอดยืมคงค้าง</td> 
<td class="style30" bgcolor='#66FF33'><div  align="right"><?php echo number_format($objResult23["count_send"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>				
	
<?php } ?>	
	
	
	
</table>	
</div>	
<?php } ?>
	
	

<?php

//ใบฝากขาย
	
$strSQL = "SELECT * FROM hos__consig  where iv_no ='".$iv_no."' and status_doc = 'Approve'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);	

if($Num_Rows > 0){	
?>	
<div class="w3-half">	
<br><center><font size="4" color='black'><b>ERP Sale</b></font></center><br>	
	
<table border= "1" width="100%" class='w3-table'>

<tr bgcolor = 'grey'>
<td width="8%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="5%" align="center" class="style30">เขตการขาย</td> 
<td width="8%" align="center" class="style30">รหัสสินค้า</td> 	
<td width="15%" align="center" class="style30">สินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 


</tr>
	
<?php 
	
$strSQL1 = "SELECT * FROM hos__subconsig  WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1)){	
	
$strSQL12 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE  product_ID = '".$objResult1["product_id"]."'";
$objQuery12= mysqli_query($conn,$strSQL12) or die(mysqli_error());
$objResult12 = mysqli_fetch_array($objQuery12);	
	
$count_br = $objResult1["count"];	
?>	
<tr bgcolor = '#FF6666'>
<td align="center" class="style30"><?php echo $objResult["ref_id"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult["iv_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult["iv_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult["customer"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult1["count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>		
	
<?php	
$strSQL2 = "SELECT * FROM hos__subso WHERE  product_id = '".$objResult1["product_id"]."' and clear_ivno LIKE '%$iv_no%' and status_so='Approve'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){
	
$strSQL21 = "SELECT * FROM hos__so WHERE  ref_id = '".$objResult2["ref_idd"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);	


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_idd"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult21["iv_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult21["iv_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult21["bill_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult21["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult2["count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 
}
	?>	
	
	
	
<?php	
$strSQL2 = "SELECT * FROM hos__subspr WHERE  product_id = '".$objResult1["product_id"]."' and clear_ivno LIKE '%$iv_no%' and status_spr='Approve'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){

	
$strSQL21 = "SELECT * FROM hos__spr WHERE  ref_id = '".$objResult2["ref_idd"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);	


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_idd"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult21["spr_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult21["spr_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult21["customer"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult21["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult2["sale_count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 

} ?>	
		
	

<?php	
$strSQL2 = "SELECT * FROM hos__subsmp WHERE  product_id = '".$objResult1["product_id"]."' and br_no LIKE '%$iv_no%' and status_smp='Approve'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
	
while($objResult2 = mysqli_fetch_array($objQuery2)){
	
$count3 =+ $objResult2["sale_count"];	
$strSQL21 = "SELECT * FROM hos__smp WHERE  reff_idsmp = '".$objResult2["ref_idsmp"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);	


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_idsmp"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult21["smp_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult21["smp_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult21["customer_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult21["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult2["sale_count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 

} 
	?>	
	
	
	
<?php	
$strSQL2 = "SELECT DISTINCT ref_id FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$iv_no."' and product_id = '".$objResult1["product_id"]."'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
	
while($objResult2 = mysqli_fetch_array($objQuery2)){
	
$strSQL21 = "SELECT SUM(count) AS count  FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where ref_id = '".$objResult2["ref_id"]."' and product_id = '".$objResult1["product_id"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);
	
$strSQL22 = "SELECT * FROM hos__receive WHERE  ref_id = '".$objResult2["ref_id"]."'";
$objQuery22= mysqli_query($conn,$strSQL22) or die(mysqli_error());
$objResult22 = mysqli_fetch_array($objQuery22);	
	

?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_id"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult22["date_receive"]); ?></td>
<td align="center" class="style30"><?php echo "รับคืน"; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult22["customer_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult22["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult21["count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 
} 
	
	
	
$sql3 = "SELECT sum(sale_count) as count3   FROM  hos__subspr  where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$iv_no."' and status_spr='Approve'";

$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM hos__subso where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$iv_no."' and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$iv_no."' and product_id = '".$objResult1["product_id"]."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and br_no ='".$iv_no."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = ($count_br - ($count3+$count4+$count5+$count13));	
	
	
	?>	
		
<tr>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td class="style30"><div  align="left"></div></td> 
<td align="center" class="style30"></td> 
<td align="center" class="style30"></td> 	
<td class="style30" bgcolor='#66FF33'>ยอดยืมคงค้าง</td> 
<td class="style30" bgcolor='#66FF33'><div  align="right"><?php echo number_format($count2,0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
	
<?php 

}

	?>
		
	
</table>
	
	
</div>	

<div class="w3-half">	
<br><center><font size="4" color='black'><b>ERP Stock</b></font></center><br>	
	
<table border= "1" width="100%" class='w3-table'>

<tr bgcolor = 'grey'>
<td width="8%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="5%" align="center" class="style30">เขตการขาย</td> 
<td width="8%" align="center" class="style30">รหัสสินค้า</td> 	
<td width="15%" align="center" class="style30">สินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 


</tr>

<?php 
	
$strSQL = "SELECT * FROM hos__consig  where iv_no ='".$iv_no."' and status_doc = 'Approve'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);		
	
$strSQL1 = "SELECT * FROM hos__subconsig  WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)){	
	
$strSQL12 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE  product_ID = '".$objResult1["product_id"]."'";
$objQuery12= mysqli_query($conn,$strSQL12) or die(mysqli_error());
$objResult12 = mysqli_fetch_array($objQuery12);	
	
?>	
<tr bgcolor = '#FF6666'>
<td align="center" class="style30"><?php echo $objResult["ref_id"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult["iv_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult["iv_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult["customer"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult1["count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>
	
	
<?php	
	
$strSQL2 = "SELECT * FROM st__main WHERE iv_no = '".$iv_no."' and ref_idsale ='".$objResult["ref_id"]."'";
$objQuery2= mysqli_query($new,$strSQL2) or die(mysqli_error());
$objResult2 = mysqli_fetch_array($objQuery2);
	
	
$strSQL21 = "SELECT * FROM st__sbmain WHERE  product_id = '".$objResult1["product_id"]."' and ref_idd = '".$objResult2["ref_id"]."' and type_doc !='25'";
$objQuery21= mysqli_query($new,$strSQL21) or die(mysqli_error());
while($objResult21 = mysqli_fetch_array($objQuery21)){


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_id"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult2["iv_date"]); ?></td>
<td align="center" class="style30"><?php if($objResult21["type_doc"]=='23'){ echo "รับคืน"; }else{ echo $objResult21["stock_remark"]; } ?></td>
<td class="style30"><div  align="left"><?php echo $objResult2["customer_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult2["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult21["count_send"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php } ?>		
	
<?php
$strSQL23 = "SELECT SUM(count_send) AS count_send  FROM st__sbmain WHERE product_id = '".$objResult1["product_id"]."' and ref_idd = '".$objResult2["ref_id"]."' and type_doc ='25'";
$objQuery23= mysqli_query($new,$strSQL23) or die(mysqli_error());
$objResult23 = mysqli_fetch_array($objQuery23);	
	
?>	
<tr>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td class="style30"><div  align="left"></div></td> 
<td align="center" class="style30"></td> 
<td align="center" class="style30"></td> 	
<td class="style30" bgcolor='#66FF33'>ยอดยืมคงค้าง</td> 
<td class="style30" bgcolor='#66FF33'><div  align="right"><?php echo number_format($objResult23["count_send"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>				
	
<?php } ?>	
	</table>	
</div>	
<?php } ?>	
	
	
	
<?php

//ใบยืมโชว์รูฒ
	
$strSQL = "SELECT * FROM so__main  where doc_no ='".$iv_no."' and approve_complete = 'Approve'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);	

if($Num_Rows > 0){	
?>	
<div class="w3-half">	
<br><center><font size="4" color='black'><b>ERP Sale</b></font></center><br>	
	
<table border= "1" width="100%" class='w3-table'>

<tr bgcolor = 'grey'>
<td width="8%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="5%" align="center" class="style30">เขตการขาย</td> 
<td width="8%" align="center" class="style30">รหัสสินค้า</td> 	
<td width="15%" align="center" class="style30">สินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 


</tr>
	
<?php 
	
$strSQL1 = "SELECT * FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1)){	
	
$strSQL12 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE  product_ID = '".$objResult1["product_id"]."'";
$objQuery12= mysqli_query($conn,$strSQL12) or die(mysqli_error());
$objResult12 = mysqli_fetch_array($objQuery12);	
	
$count_br = $objResult1["sale_count"];	
?>	
<tr bgcolor = '#FF6666'>
<td align="center" class="style30"><?php echo $objResult["ref_id"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult["doc_release_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult["doc_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult["billing_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult["employee_name"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult1["sale_count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>	

<?php	
$strSQL2 = "SELECT *  FROM   so__submain   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$iv_no."' and status_sol='Approve'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){
	
$strSQL21 = "SELECT * FROM so__main WHERE  ref_id = '".$objResult2["ref_idd"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);	


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_idd"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult21["doc_release_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult21["doc_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult21["billing_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult21["employee_name"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult2["sale_count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 
}
	?>	


	
<?php	
$strSQL2 = "SELECT * FROM hos__subso WHERE  product_id = '".$objResult1["product_id"]."' and clear_ivno LIKE '%$iv_no%' and status_so='Approve'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){
	
$strSQL21 = "SELECT * FROM hos__so WHERE  ref_id = '".$objResult2["ref_idd"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);	


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_idd"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult21["iv_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult21["iv_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult21["bill_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult21["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult2["sale_count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 
}
	?>	
	
	
	
<?php	
$strSQL2 = "SELECT * FROM hos__subspr WHERE  product_id = '".$objResult1["product_id"]."' and clear_ivno LIKE '%$iv_no%' and status_spr='Approve'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){

	
$strSQL21 = "SELECT * FROM hos__spr WHERE  ref_id = '".$objResult2["ref_idd"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);	


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_idd"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult21["spr_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult21["spr_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult21["customer"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult21["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult2["sale_count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 

} ?>	
		
	

<?php	
$strSQL2 = "SELECT * FROM hos__subsmp WHERE  product_id = '".$objResult1["product_id"]."' and br_no LIKE '%$iv_no%' and status_smp='Approve'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
	
while($objResult2 = mysqli_fetch_array($objQuery2)){
	
$count3 =+ $objResult2["sale_count"];	
$strSQL21 = "SELECT * FROM hos__smp WHERE  reff_idsmp = '".$objResult2["ref_idsmp"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);	


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_idsmp"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult21["smp_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult21["smp_no"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult21["customer_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult21["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult2["sale_count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 

} 
	?>	
	
	
	
<?php	
$strSQL2 = "SELECT DISTINCT ref_id FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$iv_no."' and product_id = '".$objResult1["product_id"]."'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
	
while($objResult2 = mysqli_fetch_array($objQuery2)){
	
$strSQL21 = "SELECT SUM(count) AS count  FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where ref_id = '".$objResult2["ref_id"]."' and product_id = '".$objResult1["product_id"]."'";
$objQuery21= mysqli_query($conn,$strSQL21) or die(mysqli_error());
$objResult21 = mysqli_fetch_array($objQuery21);
	
$strSQL22 = "SELECT * FROM hos__receive WHERE  ref_id = '".$objResult2["ref_id"]."'";
$objQuery22= mysqli_query($conn,$strSQL22) or die(mysqli_error());
$objResult22 = mysqli_fetch_array($objQuery22);	
	

?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_id"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult22["date_receive"]); ?></td>
<td align="center" class="style30"><?php echo "รับคืน"; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult22["customer_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult22["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult21["count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php 
} 
	
$sql23 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$iv_no."' and status_sol='Approve'";

$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_array($qry23);	
	
$sql3 = "SELECT sum(sale_count) as count3   FROM  hos__subspr  where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$iv_no."' and status_spr='Approve'";

$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM hos__subso where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$iv_no."' and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$iv_no."' and product_id = '".$objResult1["product_id"]."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and br_no ='".$iv_no."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];
$count23 =  $rs23["count3"];
	
$count2 = ($count_br - ($count3+$count4+$count5+$count13+$count23));	
	
	
	?>	
		
<tr>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td class="style30"><div  align="left"></div></td> 
<td align="center" class="style30"></td> 
<td align="center" class="style30"></td> 	
<td class="style30" bgcolor='#66FF33'>ยอดยืมคงค้าง</td> 
<td class="style30" bgcolor='#66FF33'><div  align="right"><?php echo number_format($count2,0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
	
<?php 

}

	?>
		
	
</table>
	
	
</div>	

<div class="w3-half">	
<br><center><font size="4" color='black'><b>ERP Stock</b></font></center><br>	
	
<table border= "1" width="100%" class='w3-table'>

<tr bgcolor = 'grey'>
<td width="8%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="5%" align="center" class="style30">เขตการขาย</td> 
<td width="8%" align="center" class="style30">รหัสสินค้า</td> 	
<td width="15%" align="center" class="style30">สินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 


</tr>

<?php 
	
$strSQL = "SELECT * FROM so__main  where doc_no ='".$iv_no."' and approve_complete = 'Approve'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);		
	
$strSQL1 = "SELECT * FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)){	
	
$strSQL12 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE  product_ID = '".$objResult1["product_id"]."'";
$objQuery12= mysqli_query($conn,$strSQL12) or die(mysqli_error());
$objResult12 = mysqli_fetch_array($objQuery12);	
	
?>	
<tr bgcolor = '#FF6666'>
<td align="center" class="style30"><?php echo $objResult["ref_id"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult["doc_release_date"]); ?></td>
<td align="center" class="style30"><?php echo $objResult["doc"]; ?></td>
<td class="style30"><div  align="left"><?php echo $objResult["billing_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult["employee_name"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult1["sale_count"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>
	
	
<?php	
	
$strSQL2 = "SELECT * FROM st__main WHERE iv_no = '".$iv_no."' and ref_idsale ='".$objResult["ref_id"]."'";
$objQuery2= mysqli_query($new,$strSQL2) or die(mysqli_error());
$objResult2 = mysqli_fetch_array($objQuery2);
	
	
$strSQL21 = "SELECT * FROM st__sbmain WHERE  product_id = '".$objResult1["product_id"]."' and ref_idd = '".$objResult2["ref_id"]."' and type_doc !='3'";
$objQuery21= mysqli_query($new,$strSQL21) or die(mysqli_error());
while($objResult21 = mysqli_fetch_array($objQuery21)){


?>
	
<tr>
<td align="center" class="style30"><?php echo $objResult2["ref_id"]; ?></td>
<td align="center" class="style30"><?php echo Datethai($objResult2["stock_date"]); ?></td>
<td align="center" class="style30"><?php if($objResult21["type_doc"]=='23'){ echo "รับคืน"; }else{ echo $objResult21["stock_remark"]; } ?></td>
<td class="style30"><div  align="left"><?php echo $objResult2["customer_name"]; ?></div></td> 
<td align="center" class="style30"><?php echo $objResult2["sale_code"]; ?></td> 
<td align="center" class="style30"><?php echo $objResult12["access_code"]; ?></td> 	
<td class="style30"><div  align="left"><?php echo $objResult12["sol_name"]; ?></div></td> 
<td class="style30"><div  align="right"><?php echo number_format($objResult21["count_send"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>			
<?php } ?>		
	
<?php
$strSQL23 = "SELECT SUM(count_send) AS count_send  FROM st__sbmain WHERE product_id = '".$objResult1["product_id"]."' and ref_idd = '".$objResult2["ref_id"]."' and type_doc ='3'";
$objQuery23= mysqli_query($new,$strSQL23) or die(mysqli_error());
$objResult23 = mysqli_fetch_array($objQuery23);	
	
?>	
<tr>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td class="style30"><div  align="left"></div></td> 
<td align="center" class="style30"></td> 
<td align="center" class="style30"></td> 	
<td class="style30" bgcolor='#66FF33'>ยอดยืมคงค้าง</td> 
<td class="style30" bgcolor='#66FF33'><div  align="right"><?php echo number_format($objResult23["count_send"],0).""; ?> <?php echo $objResult12["unit_name"]; ?></div></td> 

</tr>				
	
<?php } ?>	
	</table>	
</div>	
<?php } ?>		
	
	
	
	
	
	
	
	
	
	
	
	
<?php	
	
}

?>



</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
