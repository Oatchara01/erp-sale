<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";
 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานการแก้ไข เอกสารใบจอง</h4></div>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	
<div class="w3-quarter">
วันที่ :
<input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>">
</div>
<div class="w3-quarter">
ถึง :
<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>">
	</div>

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

</div><div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>

	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<br>

<?php

	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
	
?>



<?php 
if($start_date!='' or $end_date!='' or $sale_code or $Keyword){ 

$strSQL = "SELECT DISTINCT ref_id  FROM hos__jongproduct_rt  where remark_edit!='' ";

if($start_date !=""){ 
    $strSQL .= ' AND date_jong >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_jong <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND ref_id  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or customer  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 

}



$strSQL .=" order  by sale_code ASC";	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery))
{

$sql12 = "SELECT * FROM hos__jongproduct where ref_id  = '".$objResult["ref_id"]."'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_assoc($qry12);	
	
$sql13 = "SELECT * FROM hos__jongproduct_rt where ref_id  = '".$objResult["ref_id"]."'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$Num_Rows9 = mysqli_num_rows($qry13);
	
 //and $Num_Rows9 > 1
if($rs12["status_doc"]=='Approve'){
?>
<br>
	<div class="w3-container"><h5>เลขที่อ้างอิง : <?php echo $objResult["ref_id"]; ?></h5></div>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%" >เลขที่อ้างอิง</th>
<th width="8%" >วันที่ออกเอกสาร</th>
<th width="8%" >เลขที่เอกสาร</th> 
<th width="10%" >ชื่อลูกค้า</th>
<th width="8%" >เขตการขาย</th> 
<th width="8%" >วันที่ต้องการสินค้า</th> 
<th width="10%" >หมายเหตุการแก้ไข</th>
<th width="15%" >รายการสินค้า</th>
<th width="8%" >จำนวน</th>
<th width="8%" >แก้ไขโดย</th>
<th width="8%" >วันที่แก้ไข</th>
</thead>

<?php

$strSQL1 = "SELECT * FROM hos__jongproduct_rt  where ref_id ='".$objResult["ref_id"]."' and remark_edit!=''";

if($start_date !=""){ 
    $strSQL1 .= ' AND date_jong >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND date_jong <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($Keyword !=""){ 
	$strSQL1 .= ' AND ref_id  LIKE "%'.$Keyword.'%"'; 
	$strSQL1 .= ' or customer  LIKE "%'.$Keyword.'%"'; 
	$strSQL1 .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 

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
<td><?php echo $objResult1["ref_id"];?></td>
<td><?php echo Datethai($objResult1["date_jong"]);?></td>
<td><?php echo $rs12["iv_no"];?></td>
<td><div align="left"><?php echo $objResult1["customer"];?></div></td>
<td><?php echo $rs12["sale_code"];?></td>
<td><?php echo Datethai($objResult1["date_receive"]);?></td>
<td><?php echo $objResult1["remark_edit"];?></td>



	
<td><div align="left">
<?php
$strSQL14 = "SELECT sol_name FROM (hos__subjongpro LEFT JOIN tb_product ON hos__subjongpro.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$Num_Rows14 = mysqli_num_rows($objQuery14);
while($objResult14 = mysqli_fetch_array($objQuery14)) { ?>
<?php	echo $objResult14["sol_name"]; ?><br>
<?php } ?>
</div></td>
	
<td><div align="right">
<?php
$strSQL15 = "SELECT count,unit_name FROM (hos__subjongpro LEFT JOIN tb_product ON hos__subjongpro.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$Num_Rows15 = mysqli_num_rows($objQuery15);

while($objResult15 = mysqli_fetch_array($objQuery15)) { ?>
<?php	echo number_format($objResult15["count"],0).""; ?> <?php	echo $objResult15["unit_name"]; ?><br>
<?php }	?>
</div></td>
	

<td><?php echo $objResult1["add_by"];?></td>
<td><?php echo Datethai($objResult1["add_date"]);?> <?php echo substr($objResult1["add_date"], 10, 10); ?></td>

</tr>
<?php 
} 
?>
	
	
	

</table>
	
	
	
<br>

<?php 
}	
}
}
?>


<br><br>
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>




