<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>รายการทำแบบประเมินความพึงพอใจในการจัดสินค้า</h3></div>

</form>
<?php	
date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
	
$sale_code = $_SESSION['emid'];

$strSQL = "SELECT *  FROM st__signature  where cs_code = '".$sale_code."'  and reserch_ckk='0' ";
$objQuery = mysqli_query($new,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">วันที่รับสินค้า</th>
			<th width="10%">เลขที่เอกสาร</th> 
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อลูกค้า</th>
			<th width="10%">ผู้จัดสินค้า</th>
			<th width="5%">แบบสอบถาม</th>
</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
$ref_no = substr($objResult["ref_id"],0,2); 
$iv_no1 = substr($objResult["iv_no"],0,4);	
	
?>
<tbody>

<tr>
<td><?php echo $objResult["ref_id"]; ?></td>
<td><?php echo DateThai($objResult["cs_d"]);	?></td>
<td><?php echo $objResult["iv_no"];?></td>
<td><div align="left">
<?php
  
	if($ref_no=='SO'){			
 $strSQL1 = "SELECT sol_name,sale_remark FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
	echo $objResult1["sol_name"]; 
	?> <?php echo $objResult1["sale_remark"]; ?><br><?php }  ?>
	<?php }else if($ref_no=='BR'){ ?>
	
	<?php
$strSQL1 = "SELECT sol_name,sale_remark FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?><br>
						<?php } ?>
	
	<?php }else if($ref_no=='SM'){ ?>
	
	<?php
$strSQL2 = "SELECT sol_name,sale_remark FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2 = mysqli_fetch_array($objQuery2)) {
echo $objResult2["sol_name"]; ?> <?php echo $objResult2["sale_remark"]; ?><br>
<?php } ?>
	
<?php }else if($ref_no=='SP'){ ?>
	<?php
$strSQL1 = "SELECT sol_name,sale_remark FROM (hos__subspr LEFT JOIN tb_product ON hos__subspr.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
	echo $objResult1["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?><br>
<?php } ?>
	<?php }else if($ref_no=='CH'){ ?>
	
	<?php
$strSQL1 = "SELECT sol_name,sale_remark FROM (hos__subchange LEFT JOIN tb_product ON hos__subchange.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?><br>
						<?php } ?>
	
	<?php }else if($ref_no=='RG'){ ?>
	<?php
$strSQL1 = "SELECT sol_name,remark_eng2 FROM (hos__subbreg2 LEFT JOIN tb_product ON hos__subbreg2.product_id2=tb_product.product_ID) WHERE ref_id2 = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; ?> <?php echo $objResult1["remark_eng2"]; ?><br>
						<?php } ?>
<?php }else if($ref_no=='RT'){ ?>
	<?php
$strSQL1 = "SELECT sol_name,remark_sale FROM (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_id=tb_product.product_ID) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; ?> <?php echo $objResult1["remark_sale"]; ?><br>
						<?php } ?>	
	
	<?php }else{ ?>
<?php
$strSQL1 = "SELECT sol_name,sale_remark FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1))
{  	echo $objResult1["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?><br>
<?php
}
?>
	
	<?php } ?>
	
</div></td>
<td>
	<?php 	if($ref_no=='SO'){ 
	
$strSQL3 = "SELECT bill_name FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["bill_name"];	
	?>
	
	<?php 	}else if($ref_no=='BR'){ 
$strSQL3 = "SELECT customer FROM hos__br WHERE ref_id_br = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["customer"];	
	?>
	
	<?php 	}else if($ref_no=='CH'){ 
	
	$strSQL3 = "SELECT customer FROM hos__change WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["customer"];	
	?>
	
	<?php 	}else if($ref_no=='SP'){ 
$strSQL3 = "SELECT customer FROM hos__spr WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["customer"];	
	
	?>
	
	<?php 	}else if($ref_no=='SM'){ 
	$strSQL3 = "SELECT customer_name FROM hos__smp WHERE ref_idsmp = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["customer_name"];	
	
	?>
	
	<?php 	}else if($ref_no=='RG'){
	
	$strSQL3 = "SELECT customer_name FROM hos__breg WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["customer_name"];		
	?>
	
	<?php 	}else if($ref_no=='RT'){
	
	$strSQL3 = "SELECT rental_name FROM hos__rental WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["rental_name"];		
	?>
	
	<?php 	}else{ 
$strSQL3 = "SELECT billing_name FROM so__main WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["billing_name"];	
	
	?>
	<?php } ?>
	</td>
<td><?php echo $objResult["st_name"];?><br><?php echo DateThai($objResult["stock_d"]); ?></td>
				
	<td> 
 <a href=javascript:if(confirm('!!!ต้องการทำแบบประเมินความพึงพอในการจัดสินค้า')==true){window.location='register_reseach_stock.php?ref_id=<?php echo $objResult["ref_id"]; ?>';}><img src="img/receipt_product.png" width="23" height="23" border="0" /></a>
</td>
</tr>
<?php 	$i++;  }	?>
		</tbody>
	</table>

 
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>