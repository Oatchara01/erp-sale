<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายการใบสั่งขาย</h4></div>


<?php	
	$h_bill_id = isset($_GET['h_bill_id']) ? $_GET['h_bill_id'] : '';
    $h_mode_name = isset($_GET['h_mode_name']) ? $_GET['h_mode_name'] : '';
	$month = isset($_GET['month']) ? $_GET['month'] : '';
	$name = $_SESSION["name"];
if($name=='สมบัติ' or $name=='ชลชินี' or $name=='อัจฉรา' or $name=='ลักษณาวรรณ' or $name=='มาลินี'){
	
}else{
$sale="and (sale_code ='S31' or sale_code ='S32')";	
}

date_default_timezone_set("Asia/Bangkok");


include "dbconnect.php";

$strSQL = "SELECT *  FROM hos__so  where iv_date LIKE '%$month%'  and status_doc ='Approve' $sale";	
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by iv_date ASC";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">เลขที่เอกสาร</th> 
			<th width="10%">วันที่ออกเอกสาร</th>
			<th width="23%">รายการสินค้า</th>
			<th width="8%">จำนวน</th>
			<th width="8%">ยอดขายรวม</th>
			<th width="22%">ชื่อผู้ออกบิล</th>
			<th width="10%">เขตการขาย</th>
			<th width="10%">สถานะ</th>
			

	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				<td><?php echo $objResult["iv_no"];?></td>
				<td><?php if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}
					?> 
				</td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name,sale_remark FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { 
	                    echo $objResult1["sol_name"];  echo $objResult1["sale_remark"]; ?><br/><?php } ?>
					
				</div></td>
				<td><div align="right">
					<?php
						$strSQL2 = "SELECT count,unit_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						$Num_Rows2 = mysqli_num_rows($objQuery2);

						while($objResult2 = mysqli_fetch_array($objQuery2)) { 
	                    echo $objResult2["count"]; ?> <?php  echo $objResult2["unit_name"]; ?><br/><?php } ?>
					
				</div></td>
				<td><div align="right">
					<?php
						$strSQL3 = "SELECT SUM(amount) AS amount FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
						$objResult3 = mysqli_fetch_array($objQuery3); 
	                    echo number_format($objResult3["amount"]/1.07,2).""; ?> 
					
				</div></td>
				<td><div align="left"><?php echo $objResult["pre_name"];?><?php echo $objResult["bill_name"];?></div></td>
				<td><div align="left"><?php echo $objResult["sale_code"];?> <?php echo '-';?> <?php echo $objResult["sale"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				
			</tr>
			<?php $i++; } ?>
			
			<?php

			
			?>
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>ยอดขายรวม</td>
				<td><div align="right">
					<?php
$strSQL4 = "SELECT SUM(amount) AS amount FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE iv_date LIKE '%$month%'  $sale and status_doc ='Approve' ";
if($h_bill_id !=""){ 
    $strSQL4 .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL4 .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4); 
echo number_format($objResult4["amount"]/1.07,2).""; ?> 
					
				</div></td>
				<td></td>
				<td></td>
				<td></td>
				
			</tr>
			
		</tbody>
	
		<thead class="w3-gray">
			<th>เลขที่อ้างอิง</th>
			<th>วันที่ลงทะเบียน</th>
			<th>เลขที่ลดหนี้</th> 
			<th>รายการสินค้า</th>
			<th>จำนวน</th>
			<th>ยอดรวม</th>
			<th>ชื่อลูกค้า</th>
			<th>เขตการขาย</th>
			<th>สถานะ</th>
	</thead>
		<?php
$strSQL10 = "SELECT *  FROM tb_credit_note  where date_credit LIKE '%$month%' $sale  and status_doc ='Approve'";
if($h_bill_id !=""){ 
    $strSQL10 .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL10 .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}
	
$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$Num_Rows10 = mysqli_num_rows($objQuery10);
$strSQL10 .=" order  by credit_id DESC ";
$objQuery10  = mysqli_query($conn,$strSQL10);


?>

	
<?php
$i = 1;
while($objResult10 = mysqli_fetch_array($objQuery10))
{
?>
<tr>
<td><?php echo $objResult10["ref_credit"];?></td>
<td ><?php echo DateThai($objResult10["date_credit"]);
					?></td>
				<td ><?php echo $objResult10["credit_no"];?></td>
				<td><div align="left">
					<?php
						$strSQL11 ="SELECT sol_name FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) WHERE ref_creditt = '".$objResult10["ref_credit"]."'";
						$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
						$Num_Rows11 = mysqli_num_rows($objQuery11);
						while($objResult11 = mysqli_fetch_array($objQuery11)) { ?>
<?php	echo $objResult11["sol_name"]; 	?><br />
						<?php } ?>
				</div></td>
	<td><div align="left">
					<?php
						$strSQL12 ="SELECT count,unit_name FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) WHERE ref_creditt = '".$objResult10["ref_credit"]."'";
						$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
						$Num_Rows12 = mysqli_num_rows($objQuery12);
						while($objResult12 = mysqli_fetch_array($objQuery12)) { 
							echo $objResult12["count"]; ?> <?php echo $objResult12["unit_name"]; ?><br>
						<?php } ?>
				</div></td>
	<td><div align="left">
					<?php
$strSQL13 ="SELECT SUM(sum_amount) AS sum_amount FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) WHERE ref_creditt = '".$objResult10["ref_credit"]."'";
$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
$objResult13 = mysqli_fetch_array($objQuery13);
echo number_format($objResult13["sum_amount"]/1.07,2).""; 	?></div></td>
	
				<td ><div align="left"><?php echo $objResult10["customer_name"];?></div></td>
				<td><div align="left"><?php echo $objResult10["sale_code"];?> <?php echo '-'; ?> <?php echo $objResult10["sale_name"];?></div></td>
				
				<?php if($objResult10["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult10["status_doc"];?></td>
				<?php }else if($objResult10["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult10["status_doc"];?></td>
				<?php }
					else if ($objResult10["status_doc"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult10["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult10["status_doc"];?></td>
				<?php } ?>
					
					<td>
			</tr>
		
		
		
			<?php	}	$i++; ?>
		
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>ยอดลดหนี้รวม</td>
				<td><div align="right">
					<?php
$strSQL14 ="SELECT SUM(sum_amount) AS sum_amount FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_subcredit.ref_creditt=tb_credit_note.ref_credit) WHERE date_credit LIKE '%$month%' $sale  and status_doc ='Approve'";
if($h_bill_id !=""){ 
    $strSQL14 .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL14 .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}					
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$objResult14 = mysqli_fetch_array($objQuery14);
 echo number_format($objResult14["sum_amount"]/1.07,2).""; ?> 
					
				</div></td>
				<td></td>
				<td></td>
				<td></td>
				
			</tr>
		
		<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>ยอดขายทั้งหมด</td>
				<td><div align="right">
<?php  echo number_format(($objResult4["amount"]/1.07)-($objResult14["sum_amount"]/1.07),2).""; ?> 
					
				</div></td>
				<td></td>
				<td></td>
				<td></td>
				
			</tr>
		
		</table>
      
      <br></div></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>