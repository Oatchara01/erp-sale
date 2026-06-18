<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";
 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานใบเบิกสินค้า SMP (GLUCOALL-1B)</h4></div>

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

</div>
	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<br>
<?php

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$sale_code = $_GET["sale_code"];
	
?>



<?php 
if($start_date!='' or $end_date!='' or $sale_code){ 

$strSQL = "SELECT DISTINCT sale_code  FROM hos__smp  where status_sup='Approve' and chang_ckk='1'";

if($start_date !=""){ 
    $strSQL .= ' AND smp_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND smp_date <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}

$strSQL .=" order  by sale_code ASC";	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery))
{

?>
<br>
	<div class="w3-container"><h5>เขตการขาย : <?php echo $objResult["sale_code"]; ?></h5></div>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%" >เลขที่อ้างอิง</th>
<th width="8%" >วันที่ออกเอกสาร</th>
<th width="8%" >เลขที่เอกสาร</th> 
<th width="15%" >ชื่อลูกค้า</th>
<th width="8%" >หมายเลขคำสั่งซื้อ</th> 
<th width="15%" >รายการสินค้าคำสั่งซื้อ</th>
<th width="15%" >รายการสินค้า</th>
<th width="8%" >จำนวน</th>
<th width="8%" >ราคาต่อหน่วย</th>
<th width="8%" >ราคารวม</th>
<th width="8%" >ช่องทางการขาย</th>
</thead>

<?php

$strSQL1 = "SELECT * FROM hos__smp  where sale_code='".$objResult["sale_code"]."' and  status_sup='Approve' and chang_ckk='1'";

if($start_date !=""){ 
    $strSQL1 .= ' AND smp_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND smp_date <= "'.$end_date.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$sum=0;
$sale_count=0; 
 $i=0;
while($objResult1 = mysqli_fetch_array($objQuery1))
{


$sql = "SELECT sale_channel,order_id FROM so__main where ref_id = '".$objResult1["ref_idsale"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);	


$sql12 = "SELECT salechannel_nameshort FROM tb_salechannel where salechannel_ID  = '".$rs["sale_channel"]."'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_assoc($qry12);	


?>

<tr>
<td><?php echo $objResult1["ref_idsmp"];?></td>
<td><?php echo Datethai($objResult1["smp_date"]);?></td>
<td><?php echo $objResult1["smp_no"];?></td>
<td><div align="left"><?php echo $objResult1["customer_name"];?></div></td>

<?php if($rs["order_id"] ==''){ ?><td bgcolor="#FF0000"><?php }else{ ?><td><?php } ?>
<?php echo $rs["order_id"];?></td>

<td><div align="left">
<?php


$strSQL11 = "SELECT sol_name,count,unit_name FROM (tb__glu426 LEFT JOIN tb_product ON tb__glu426.product_id=tb_product.product_ID) WHERE ref_id = '".$objResult1["ref_idsale"]."' ";

$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);
$objResult11 = mysqli_fetch_array($objQuery11); 
	echo $objResult11["sol_name"]; ?> <?php echo $objResult11["count"]; ?> <?php echo $objResult11["unit_name"]; ?>

</div></td>	
	
	
<td><div align="left">
<?php
$strSQL14 = "SELECT sol_name FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult1["ref_idsmp"]."' ";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$Num_Rows14 = mysqli_num_rows($objQuery14);
while($objResult14 = mysqli_fetch_array($objQuery14)) { ?>
<?php	echo $objResult14["sol_name"]; ?><br>
<?php } ?>
</div></td>
	
<td><div align="right">
<?php
$strSQL15 = "SELECT sale_count,unit_name FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult1["ref_idsmp"]."' ";
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
	
<td><div align="right">
<?php
$strSQL16 = "SELECT unit_price FROM hos__subsmp WHERE reff_idsmp = '".$objResult1["ref_idsmp"]."' ";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$Num_Rows16 = mysqli_num_rows($objQuery16);
while($objResult16 = mysqli_fetch_array($objQuery16)) { ?>
<?php	echo number_format($objResult16["unit_price"],2)."";  ?><br>
<?php } ?>
</div></td>

<td><div align="right">
<?php
$strSQL17 = "SELECT SUM(sum_amount) AS sum_amount FROM hos__subsmp WHERE reff_idsmp = '".$objResult1["ref_idsmp"]."' ";
$objQuery17 = mysqli_query($conn,$strSQL17) or die ("Error Query [".$strSQL17."]");
$objResult17 = mysqli_fetch_array($objQuery17); 
echo number_format($objResult17["sum_amount"],2).""; 
	
$sum = $sum + $objResult17["sum_amount"];	
	
	?>
</div></td>




<td><?php echo $rs12["salechannel_nameshort"];?></td>

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
<td></td>	
<td bgcolor='yellow' >ยอดรวม</td>
<td bgcolor='yellow' ><div align="right"><?php echo number_format($sale_count-$i,0).""; ?> รายการ</div></td>	
<td bgcolor='yellow' ></td>
<td bgcolor='yellow' ><div align="right"><?php echo number_format($sum-$i,2).""; ?></div></td>	
<td></td>	

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




