<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";
 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานใบยืมค้างเคลียร์ ตามเขตการขาย</h4></div>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	
<div class="w3-quarter">
เขตการขาย :
 	
<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($_GET["sale_code"] == $objResuut5["sale_code"]) {
$sel = "selected";
}else {
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>"  <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>

</div>
	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<?php if($_GET["sale_code"]!=''){ ?>	
	
<a href="report_mdkangbrpro1.php?sale_code=<?php echo $_GET["sale_code"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="red">ตามรหัสสินค้า</font></a>	
	
<?php } ?>	
<br>
<?php 
$sale_code = $_GET["sale_code"]; 
	
	
if($sale_code =='SOL0' or $sale_code =='SOL1' or $sale_code =='SOL2' or $sale_code =='SOL3' or $sale_code =='SOL4' or $sale_code =='SOL5' or $sale_code =='SOL91' or $sale_code =='SOL92' or $sale_code =='SOL93' or $sale_code =='SOL94' or $sale_code =='SOL6' or $sale_code =='SOL7'){ 
	
	
	

?>
<br>
<br><center><font size="5" color='blue'>รายการใบยืมคงค้าง เขตการขาย <?php echo $sale_code; ?> </font></center><br>
	
<table border= "1" width="100%" class='w3-table'>
<tr>
	
	
<td width="10%" align="center" class="style39">วันที่ออกเอกสาร</td>
<td width="10%" align="center" class="style39">เลขที่อ้างอิง</td>	
<td width="10%" align="center" class="style39">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style39">รหัสสินค้า</td>	
<td width="20%" align="center" class="style39">ชื่อสินค้า</td>	
<td width="10%" align="center" class="style39">จำนวนคงเหลือ ERP Sale</td> 
<td width="10%" align="center" class="style39">จำนวนคงเหลือ ERP Stock</td>
	</tr>	
	
<?php 
	
$strSQL1 = "SELECT distinct product_code FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id)  WHERE  type_br='1' and clear_ckk = '0' and ckk_st ='1'";

if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_area = "'.$sale_code.'"'; 
}
$strSQL1 .=" order  by number ASC";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1)){

$strSQL2 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE  product_ID='".$objResult1["product_code"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);	

$strSQL3 = "SELECT * FROM so__submain  WHERE  type_br='1' and clear_ckk = '0' and product_id = '".$objResult1["product_code"]."'  and ckk_st ='1' and status_sol='Approve'";
//$strSQL3 = "SELECT ref_idd,sale_count  FROM so__submain  WHERE  type_br='1' and clear_ckk = '0' and product_id = '4213'";
if($sale_code !=""){ 
    $strSQL3 .= ' AND sale_area = "'.$sale_code.'"'; 
}
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);

while($objResult3 = mysqli_fetch_array($objQuery3)){
	
	
$strSQL9 = "SELECT SUM(count_send) AS count  FROM (st__main LEFT JOIN st__sbmain ON st__main.ref_id=st__sbmain.ref_idd) WHERE product_id = '".$objResult1['product_code']."' and type_doc = '3' and ref_idsale ='".$objResult3["ref_idd"]."'";
$strSQL9 .=" order  by stock_date ASC";
$objQuery9 = mysqli_query($new,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);	
	
	
	
$strSQL4 = "SELECT doc_no,doc_release_date,ref_id,cancel_ckk FROM so__main WHERE  ref_id='".$objResult3["ref_idd"]."' and cancel_ckk ='0' and approve_complete ='Approve' and cancel_ckk='0'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

	
$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult1["product_code"]."' and clear_br = '1' and clear_ivno ='".$objResult4["doc_no"]."' and status_sol ='Approve'";
	
//$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '4213' and clear_br = '1' and clear_ivno ='".$objResult4["doc_no"]."'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql7 = "SELECT sum(count) as count   FROM   hos__subso   where  product_id = '".$objResult1["product_code"]."' and clear_br = '1' and clear_ivno ='".$objResult4["doc_no"]."'  and status_so ='Approve'";
	
//$sql7 = "SELECT sum(count) as count   FROM   hos__subso   where  product_id = '4213' and clear_br = '1' and clear_ivno ='".$objResult4["doc_no"]."'";	
	
$qry7 = mysqli_query($conn,$sql7) or die(mysqli_error());
$rs7 = mysqli_fetch_assoc($qry7);
	
$sql2 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '".$objResult1["product_code"]."' and clear_br = '1' and br_no ='".$objResult4["doc_no"]."' and status_smp ='Approve'";
//$sql2 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '4213' and clear_br = '1' and br_no ='".$objResult4["doc_no"]."'";

$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);
	
$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$objResult4["doc_no"]."' and product_id = '".$objResult1["product_code"]."' ";
//$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$objResult4["doc_no"]."' and product_id = '4213' ";	
	
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);

$count3 =  $rs3["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs2["count3"];
$count7 =  $rs7["count"];

//echo $count3+$count4+$count5+$count7;	
$count2 = $objResult3["sale_count"] - ($count3+$count4+$count5+$count7);		
if($count2=='0'){
$strSQL33 =  "Update so__submain SET clear_ckk='1'  where  id ='".$objResult3["id"]."'";
$objQuery33 = mysqli_query($conn,$strSQL33) or die(mysqli_error());	
}
	
$strSQL8 =  "Update so__submain SET count_kang='".$count2."'  where  id ='".$objResult3["id"]."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die(mysqli_error());	
	
$count9 = number_format($objResult9["count"],0)."";	
	
if( $objResult4["cancel_ckk"]=='0'){
	
?>
	
	
	
<tr>

<td width="10%" align="center" class="style39"><?php echo Datethai($objResult4["doc_release_date"]);  ?></td>
<td width="10%" align="center" class="style39"><?php echo $objResult4["ref_id"];  ?></td>	
<td width="10%" align="center" class="style39"><?php echo $objResult4["doc_no"];  ?></td>
<td width="10%"class="style39"><div align="left" ><?php echo $objResult2["access_code"];  ?></div></td>		
<td width="20%"class="style39"><div align="left" ><?php echo $objResult2["sol_name"];  ?></div></td>	
<td><?php if($count9!=$count2){ ?>	<font color='red'> <?php } ?>
<div align="right"  class="style33"><?php echo $count2; ?> <?php echo $objResult2["unit_name"]; ?></div>
<?php if($count9!=$count2){ ?>	</font> <?php } ?>		
</td>
<td>
<?php if($count9!=$count2){ ?>	<font color='red'> <?php } ?>	
<div align="right"  class="style33"><?php echo $count9; ?> <?php echo $objResult2["unit_name"]; ?></div>
<?php if($count9!=$count2){ ?>	</font> <?php } ?>		
</td>


	</tr>	
	

	
	
<?php 
}
}
}
	?>	</table>
<?php	
	
}

if($sale_code !=''){ 


$strSQL = "SELECT DISTINCT(customer_id) from hos__br WHERE close_br ='0' and status_doc ='Approve' and sale_code ='".$sale_code."'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);
	
if($Num_Rows > 0 ){
	?>
<br><center><font size="5" color='blue'>รายการใบยืมคงค้าง เขตการขาย <?php echo $sale_code; ?> </font></center>	
	
	<?
while($objResult = mysqli_fetch_array($objQuery)){

$strSQL3 = "SELECT * FROM tb_customer WHERE customer_id = '".$objResult["customer_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);

//
$strSQL1 = "SELECT ref_id_br,iv_no,iv_date FROM hos__br WHERE close_br ='0' and status_doc ='Approve'  and sale_code ='".$sale_code."' and customer_id ='".$objResult["customer_id"]."' and iv_date !='0000-00-00' ORDER BY iv_no ASC";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

?>


</p><div class="style15"><?php echo $objResult3["preface_name"]; ?> <?php echo $objResult3["customer_name"]; ?></div></p>

<table  border= "1" width="100%" class='w3-table'>
<tr >
<td width="8%" align="center"  ><div class="style32">วันที่</div></td>
<td width="8%" align="center" ><div class="style32">เลขที่ใบยืม</div></td>
<td width="10%" align="center" ><div class="style32">รหัสสินค้า</div></td>
<td width="20%" align="center" ><div class="style32">ชื่อสินค้า</div></td> 
<td width="10%" align="center" ><div class="style32">จำนวนคงเหลือ ERP Sale</div></td> 
<td width="10%" align="center" ><div class="style32">จำนวนคงเหลือ ERP Stock</div></td> 
	
</tr>
<?php 
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
$strSQL2 = "SELECT id,product_id,count,sale_remark FROM  hos__subbr  WHERE clear_ckk = '0' and ref_idd_br ='".$objResult1["ref_id_br"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2))
{	
	
$strSQL9 = "SELECT SUM(count_send) AS count  FROM (st__main LEFT JOIN st__sbmain ON st__main.ref_id=st__sbmain.ref_idd) WHERE product_id = '".$objResult2['product_id']."' and type_doc = '3' and ref_idsale ='".$objResult1["ref_id_br"]."'";
$strSQL9 .=" order  by stock_date ASC";
$objQuery9 = mysqli_query($new,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);	
	
/*$strSQL19 = "SELECT ref_id  FROM (st__main LEFT JOIN st__sbmain ON st__main.ref_id=st__sbmain.ref_idd) WHERE product_id = '".$objResult2['product_id']."' and sale_code = '".$sale_code."'  and type_doc = '3' and ref_idsale ='".$objResult1["ref_id_br"]."'";
$strSQL19 .=" order  by stock_date ASC";
$objQuery19 = mysqli_query($new,$strSQL19) or die ("Error Query [".$strSQL19."]");
while($objResult19 = mysqli_fetch_array($objQuery19))
{

$save="Update  st__sbmain set ckk_rpbr='1' where ref_idd ='".$objResult19["ref_id"]."'";
$qsave=mysqli_query($new,$save);		

}*/
	
	

	
	
$strSQL4 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE product_ID = '".$objResult2["product_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4 = mysqli_fetch_array($objQuery4);

	
$sql3 = "SELECT sum(sale_count) as count3   FROM   hos__subspr   where  product_id = '".$objResult2['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult1["iv_no"]."' and status_spr='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult2['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult1["iv_no"]."' and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
/*$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$objResult1["iv_no"]."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);*/

$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$objResult1["iv_no"]."' and product_id = '".$objResult2['product_id']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '".$objResult2['product_id']."' and clear_br = '1' and br_no ='".$objResult1["iv_no"]."' and status_smp='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = $objResult2["count"] - ($count3+$count4+$count5+$count13);	
if($count2=='0' ){	

$save3="Update  hos__subbr set clear_ckk = '1' where id='".$objResult2["id"]."' and ref_idd_br ='".$objResult1["ref_id_br"]."'";
$qsave3=mysqli_query($conn,$save3);	
	
}
	
$count9 = number_format($objResult9["count"],0)."";	
	
?>
<tr>
	
<td align="center" ><div class="style33"><?php echo Datethai($objResult1["iv_date"]);?></div></td>
<td align="center" ><div class="style33"><?php echo $objResult1["iv_no"]; ?></div></td>
<td ><div align="left"  class="style33"><?php echo $objResult4["access_code"]; ?></div></td>
<td ><div align="left" class="style33"><?php echo $objResult4["sol_name"]; ?> <?php echo $objResult2["sale_remark"]; ?></div></td>

<td><?php if($count9!=$count2){ ?>	<font color='red'> <?php } ?>
<div align="right"  class="style33"><?php echo $count2; ?> <?php echo $objResult4["unit_name"]; ?></div>
<?php if($count9!=$count2){ ?>	</font> <?php } ?>		
</td>
<td>
<?php if($count9!=$count2){ ?>	<font color='red'> <?php } ?>	
<div align="right"  class="style33"><?php echo number_format($objResult9["count"],0).""; ?> <?php echo $objResult4["unit_name"]; ?></div>
<?php if($count9!=$count2){ ?>	</font> <?php } ?>		
</td>


<?php $i++; }
}
	?>
</tr>
	

</table>

<?php 
}
	?>
<br>	
	<?php
}
	?>
	 
	 
<br>	 
	 

	 
<?php	
/*$strSQL9 = "SELECT ref_id,stock_date,product_id,count_send,iv_no,customer_name,st__sbmain.stock_remark  FROM (st__main LEFT JOIN st__sbmain ON st__main.ref_id=st__sbmain.ref_idd) WHERE  sale_code = '".$sale_code."'  and type_doc = '3' and ckk_rpbr='0'";
$strSQL9 .=" order  by stock_date ASC";
$objQuery9 = mysqli_query($new,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);	
if($Num_Rows9 > 0){	
?>	
	<center><br><font size="4" color='red'>ใบยืมคงค้างเพิ่มเติมจาก ERP Stock</font><br><br></center>
<table  border= "1" width="100%" class='w3-table'>
<tr >
<td width="8%" align="center"  ><div class="style32">วันที่</div></td>
<td width="8%" align="center" ><div class="style32">เลขที่ใบยืม</div></td>
<td width="20%" align="center" ><div class="style32">ชื่อลูกค้า</div></td> 	
<td width="10%" align="center" ><div class="style32">รหัสสินค้า</div></td>
<td width="20%" align="center" ><div class="style32">ชื่อสินค้า</div></td> 
<td width="10%" align="center" ><div class="style32">จำนวนคงเหลือ ERP Sale</div></td> 
<td width="10%" align="center" ><div class="style32">จำนวนคงเหลือ ERP Stock</div></td> 
	
</tr>	 
	 
<?php
while($objResult9 = mysqli_fetch_array($objQuery9))
{
	
$strSQL4 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE product_ID = '".$objResult9["product_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4 = mysqli_fetch_array($objQuery4);	
?>
<tr>
	
<td align="center" ><div class="style33"><?php echo Datethai($objResult9["stock_date"]);?></div></td>
<td align="center" ><div class="style33"><?php echo $objResult9["iv_no"]; ?></div></td>
<td  ><div class="style33" align="left"><?php echo $objResult9["customer_name"]; ?></div></td>	
<td ><div align="left"  class="style33"><?php echo $objResult4["access_code"]; ?></div></td>
<td ><div align="left" class="style33"><?php echo $objResult4["sol_name"]; ?> <?php echo $objResult9["stock_remark"]; ?></div></td>

<td><div align="right"  class="style33"></div></td>
<td><div align="right"  class="style33"><?php echo number_format($objResult9["count_send"],0).""; ?> <?php echo $objResult4["unit_name"]; ?></div></td>
	<?php
}
	
?>	
		 
</tr>	 
</table>
	 
<?php } ?>	 
	 
<?php 

$save="Update  st__sbmain set ckk_rpbr='0' where ckk_rpbr = '1'";
$qsave=mysqli_query($new,$save);
	*/
?>	 
	 
	
	
	
<?php	
$strSQL = "SELECT DISTINCT(customer_id) from hos__consig WHERE close_br ='0' and status_doc ='Approve' and sale_code ='".$sale_code."'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);
	
if($Num_Rows >0){
	?>
	 <br><br>
<center><font size="5"  color='blue'>รายการใบยืมฝากขายคงค้าง เขตการขาย <?php echo $sale_code; ?> </font></center>	
	
	<?
while($objResult = mysqli_fetch_array($objQuery)){

$strSQL3 = "SELECT * FROM tb_customer WHERE customer_id = '".$objResult["customer_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);

//
$strSQL1 = "SELECT ref_id,iv_no,iv_date FROM hos__consig WHERE close_br ='0' and status_doc ='Approve' and sale_code ='".$sale_code."' and customer_id ='".$objResult["customer_id"]."' and iv_date !='0000-00-00'  ORDER BY iv_no ASC";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

?>


</p><div class="style15"><?php echo $objResult3["preface_name"]; ?> <?php echo $objResult3["customer_name"]; ?></div></p>

<table  border= "1" width="100%" class='w3-table'>
<tr >
<td width="8%" align="center"  ><div class="style32">วันที่</div></td>
<td width="8%" align="center" ><div class="style32">เลขที่ใบยืม</div></td>
<td width="10%" align="center" ><div class="style32">รหัสสินค้า</div></td>
<td width="20%" align="center" ><div class="style32">ชื่อสินค้า</div></td> 
<td width="10%" align="center" ><div class="style32">จำนวนคงเหลือ ERP Sale</div></td> 
<td width="10%" align="center" ><div class="style32">จำนวนคงเหลือ ERP Stock</div></td> 
	
</tr>
<?php 
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
$strSQL2 = "SELECT id,product_id,count,sale_remark FROM  hos__subconsig  WHERE clear_ckk = '0' and ref_idd ='".$objResult1["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2))
{	
	
	
$strSQL9 = "SELECT SUM(count_send) AS count  FROM (st__main LEFT JOIN st__sbmain ON st__main.ref_id=st__sbmain.ref_idd) WHERE product_id = '".$objResult2['product_id']."'  and type_doc = '25' and ref_idsale ='".$objResult1["ref_id"]."'";
$strSQL9 .=" order  by stock_date ASC";
	
$objQuery9 = mysqli_query($new,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);	
	
/*$strSQL19 = "SELECT ref_id  FROM (st__main LEFT JOIN st__sbmain ON st__main.ref_id=st__sbmain.ref_idd) WHERE product_id = '".$objResult2['product_id']."' and sale_code = '".$sale_code."'  and type_doc = '25' and ref_idsale ='".$objResult1["ref_id"]."'";
$strSQL19 .=" order  by stock_date ASC";
$objQuery19 = mysqli_query($new,$strSQL19) or die ("Error Query [".$strSQL19."]");
while($objResult19 = mysqli_fetch_array($objQuery19))
{

$save="Update  st__sbmain set ckk_rpbr='1' where ref_idd ='".$objResult19["ref_id"]."'";
$qsave=mysqli_query($new,$save);		

}*/
	
	
$strSQL4 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE product_ID = '".$objResult2["product_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4 = mysqli_fetch_array($objQuery4);

	
/*$strSQL4 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE product_ID = '".$objResult1["product_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4 = mysqli_fetch_array($objQuery4);*/

$sql3 = "SELECT sum(sale_count) as count3   FROM   hos__subspr   where  product_id = '".$objResult2['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult1["iv_no"]."' and status_spr='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult2['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult1["iv_no"]."' and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
/*$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$objResult1["iv_no"]."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);*/

$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where  iv_no = '".$objResult1["iv_no"]."'  and product_id = '".$objResult2['product_id']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);
	

$sql12 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '".$objResult2['product_id']."' and clear_br = '1' and br_no ='".$objResult1["iv_no"]."' and status_smp='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = $objResult2["count"] - ($count3+$count4+$count5+$count13);	

if($count2=='0'){	

$save3="Update  hos__subconsig set clear_ckk = '1' where id='".$objResult2["id"]."' and ref_idd ='".$objResult1["ref_id"]."'";
$qsave3=mysqli_query($conn,$save3);	
	
}
	
$count9 = number_format($objResult9["count"],0)."";		
?>
<tr>
	
<td align="center" ><div class="style33"><?php echo Datethai($objResult1["iv_date"]);?></div></td>
<td align="center" ><div class="style33"><?php echo $objResult1["iv_no"]; ?></div></td>
<td ><div align="left"  class="style33"><?php echo $objResult4["access_code"]; ?></div></td>
<td ><div align="left" class="style33"><?php echo $objResult4["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?></div></td>

<td><?php if($count9!=$count2){ ?>	<font color='red'> <?php } ?>
<div align="right"  class="style33"><?php echo $count2; ?> <?php echo $objResult4["unit_name"]; ?></div>
<?php if($count9!=$count2){ ?>	</font> <?php } ?>		
</td>
<td>
<?php if($count9!=$count2){ ?>	<font color='red'> <?php } ?>	
<div align="right"  class="style33"><?php echo number_format($objResult9["count"],0).""; ?> <?php echo $objResult4["unit_name"]; ?></div>
<?php if($count9!=$count2){ ?>	</font> <?php } ?>		
</td>

<?php $i++; }
}
	?>
</tr>
</table>

<?php 
}
}

?>

<?php	
/*$strSQL89 = "SELECT ref_id,stock_date,product_id,count_send,iv_no,customer_name,st__sbmain.stock_remark  FROM (st__main LEFT JOIN st__sbmain ON st__main.ref_id=st__sbmain.ref_idd) WHERE  sale_code = '".$sale_code."'  and type_doc = '25' and ckk_rpbr='0'";
$strSQL89 .=" order  by stock_date ASC";
$objQuery89 = mysqli_query($new,$strSQL89) or die ("Error Query [".$strSQL89."]");
$Num_Rows89 = mysqli_num_rows($objQuery89);	
	
if($Num_Rows89 > 0){	
?>	
	<center><br><font size="4" color='red'>ใบยืมฝากขายคงค้างเพิ่มเติมจาก ERP Stock</font><br><br></center>
<table  border= "1" width="100%" class='w3-table'>
<tr >
<td width="8%" align="center"  ><div class="style32">วันที่</div></td>
<td width="8%" align="center" ><div class="style32">เลขที่ใบยืม</div></td>
<td width="20%" align="center" ><div class="style32">ชื่อลูกค้า</div></td> 	
<td width="10%" align="center" ><div class="style32">รหัสสินค้า</div></td>
<td width="20%" align="center" ><div class="style32">ชื่อสินค้า</div></td> 
<td width="10%" align="center" ><div class="style32">จำนวนคงเหลือ ERP Sale</div></td> 
<td width="10%" align="center" ><div class="style32">จำนวนคงเหลือ ERP Stock</div></td> 
	
</tr>	 
	 
<?php
while($objResult89 = mysqli_fetch_array($objQuery89))
{
	
$strSQL4 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE product_ID = '".$objResult89["product_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4 = mysqli_fetch_array($objQuery4);	
?>
<tr>
	
<td align="center" ><div class="style33"><?php echo Datethai($objResult89["stock_date"]);?></div></td>
<td align="center" ><div class="style33"><?php echo $objResult89["iv_no"]; ?></div></td>
<td  ><div class="style33" align="left"><?php echo $objResult89["customer_name"]; ?></div></td>	
<td ><div align="left"  class="style33"><?php echo $objResult4["access_code"]; ?></div></td>
<td ><div align="left" class="style33"><?php echo $objResult4["sol_name"]; ?> <?php echo $objResult89["stock_remark"]; ?></div></td>

<td><div align="right"  class="style33"></div></td>
<td><div align="right"  class="style33"><?php echo number_format($objResult89["count_send"],0).""; ?> <?php echo $objResult4["unit_name"]; ?></div></td>
	<?php
}
	
?>	
		 
</tr>	 
</table>
	 
<?php } ?>	 
	 
<?php 

$save="Update  st__sbmain set ckk_rpbr='0' where ckk_rpbr = '1'";
$qsave=mysqli_query($new,$save);
	*/
?>	 
	 
	

<?php

}
?>
<br><br>



</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
