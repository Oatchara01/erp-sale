<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";
 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานใบเบิกสินค้า SMP </h4></div>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	
<div class="w3-row" style="display: flex; gap: 10px;">
    <div class="w3-third" style="flex: 1;">
วันที่ :
<input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>">
</div>
    <div class="w3-third" style="flex: 1;">
ถึง :
<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>">
	</div>

    <div class="w3-third" style="flex: 1;">

  บริษัท

<select name="company" id="company" style="width:90%" class="w3-input"   required>
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="1">ออลล์เวล ไลฟ์ บจก.</option>
<option  value="2">โนเบิล เมด บจก.</option>

</select>

</div>
    <div class="w3-third" style="flex: 1;">

  เขตการขาย

<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_all where ckk='1' ORDER BY sale_code ASC";
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

    <div class="w3-third" style="flex: 1;">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>	</div>
<br>
<?php

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$company = $_GET["company"];
$sale_code = $_GET["sale_code"];
	
?>


<?php 

 if($start_date!='' or $end_date!='' or $company){

$strSQL = "SELECT DISTINCT product_id  FROM (hos__smp LEFT JOIN hos__subsmp ON hos__smp.ref_idsmp=hos__subsmp.reff_idsmp)  where status_sup='Approve' and chang_ckk='0' and sale_code ='".$sale_code."'";

if($start_date !=""){ 
    $strSQL .= ' AND smp_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND smp_date <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL .= ' AND type_company = "'.$company.'"'; 
}

$strSQL .=" order  by sale_code ASC";	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery))
{

$sql12 = "SELECT express_code,sol_name FROM tb_product where product_ID  = '".$objResult["product_id"]."'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_assoc($qry12);	


?>
<br>
<font color ='blue'><?php echo $rs12["express_code"]; ?> <?php echo $rs12["sol_name"]; ?></font>

<br>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%" >เลขที่อ้างอิง</th>
<th width="8%" >วันที่ออกเอกสาร</th>
<th width="8%" >เลขที่เอกสาร</th> 
<th width="10%" >ชื่อลูกค้า</th>
<th width="10%" >รหัสสินค้า</th>
<th width="15%" >รายการสินค้า</th>
<th width="8%" >จำนวน</th>
</thead>

<?php



$strSQL1 = "SELECT * FROM (hos__smp LEFT JOIN hos__subsmp ON hos__smp.ref_idsmp=hos__subsmp.reff_idsmp)  where status_sup='Approve' and chang_ckk='0' and sale_code='".$sale_code."' and product_id='".$objResult["product_id"]."'";

if($start_date !=""){ 
    $strSQL1 .= ' AND smp_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND smp_date <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL1 .= ' AND type_company = "'.$company.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$sum=0;
$sale_count=0; 
 $i=0;
while($objResult1 = mysqli_fetch_array($objQuery1))
{


?>

<tr>
<td><?php echo $objResult1["ref_idsmp"];?></td>
<td><?php echo Datethai($objResult1["smp_date"]);?></td>
<td><?php echo $objResult1["smp_no"];?></td>
<td><div align="left"><?php echo $objResult1["customer_name"];?></div></td>

<td><div align="left">
<?php
$strSQL13 = "SELECT express_code FROM tb_product WHERE  product_ID='".$objResult["product_id"]."' ";
$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
$objResult13 = mysqli_fetch_array($objQuery13);
echo $objResult13["express_code"]; ?>

</div></td>
	
	
<td><div align="left">
<?php
$strSQL14 = "SELECT sol_name FROM tb_product WHERE product_ID='".$objResult["product_id"]."'";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$objResult14 = mysqli_fetch_array($objQuery14);
 echo $objResult14["sol_name"]; ?>
</div></td>
	
<td><div align="right">
<?php
$strSQL15 = "SELECT sale_count,unit_name FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult1["ref_idsmp"]."' and product_code='".$objResult["product_id"]."'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$Num_Rows15 = mysqli_num_rows($objQuery15);
$count=0;
$j=0;	
while($objResult15 = mysqli_fetch_array($objQuery15)) { ?>
<?php	echo number_format($objResult15["sale_count"],0).""; ?> <?php	echo $objResult15["unit_name"]; 
	
	$count = $count + $objResult15["sale_count"];
	
	?><br>
<?php 
	$count++;
	$j++;
													  } 
	//echo $count;
	$sale_count = $sale_count + ($count-$j);
	
	?>
</div></td>
	

</tr>
<?php 
$i++;
$sum++;
$sale_count++;
} 
	
	

	?>
	
	
<tr>
<td></td>
<td></td>	
<td></td>
<td></td>
<td></td>	
<td bgcolor='yellow' >ยอดรวม</td>
<td bgcolor='yellow' ><div align="right"><?php echo number_format($sale_count-$i,0).""; ?> รายการ</div></td>	

</tr>	
	

</table>
	
	
	
<br>

<?php 
}	
}
?>


<br><br>
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>




