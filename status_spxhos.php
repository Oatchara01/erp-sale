<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<?php
	
		$address_1 = $_GET["address_1"];
		$start_date = $_GET["start_date"];
		$type_doc = $_GET["type_doc"];
		$payment = $_GET["payment"];
		$company = $_GET["company"]
			
?>
<div class="w3-white">
<div class="w3-container w3-padding-large">
<center>
<h4>ตารางข้อมูลการจัดส่งสินค้า</h4>
	<h4>วันที่ <?php echo  Datethai($start_date); ?></h4>	
	</center><br>




<div class="w3-container">
	<table border="1" width="100%" class="w3-table" style ="margin : 0px -10px;">
		<thead class="w3-gray">
			<td width="5%" >เลขที่อ้างอิง</td>
			<td width="8%">เลขที่เอกสาร</td>
			<td width="8%">วันที่ออกเอกสาร</td>
			<td width="8%"  >รายการสินค้า</td>
			<td width="8%">ชื่อผู้ออกบิล</td>
			<td width="8%" >เขตการขาย</td>
			<td width="8%" >สถานะ</td>
			<td width="2%" >จำนวนกล่อง</td>
			<td width="2%" >แก้ไข</td>
			
	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');


$strSQL = "SELECT iv_no,iv_date,bill_name,sale_code,status_doc,hos__so.ref_id FROM (tb_register_data LEFT JOIN hos__so ON tb_register_data.ref_id=hos__so.ref_id) where address_1 LIKE '%$address_1%' and start_date='".$start_date."'  and status_doc ='Approve'";

if($type_doc !=""){ 
    $strSQL .= ' AND type_doc = "'.$type_doc.'"'; 
}

if($payment !=""){ 
    $strSQL .= ' AND payment = "'.$payment.'"'; 
}else{

$strSQL .= ' AND payment!="29" and payment!="26"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

?>
		
		
			<tr>
<td ><?php echo $objResult["ref_id"];?></td>
		
<td><?php echo $objResult["iv_no"];?></td>
<td ><?php if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}
					?> 
				</td>
				
			<td ><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 
	echo $objResult1["sol_name"]; 

	
	?><br>
						<?php } ?>
				</div></td>
					<td ><div align="left"><?php echo $objResult["bill_name"];?></div></td>		
				<td ><div align="left"><?php echo $objResult["sale_code"];?></div></td>
			
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  ><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030" ><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00" ><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				<td ><?php echo '1';?></td>
				<td >
<a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
								
				</td>
				
				
			</tr>
		

	
<?php

}
	
$strSQL = "SELECT ref_id  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$start_date."' and ref_id LIKE '%BR%'";

if($company !=''){
    $strSQL .= ' AND type_company = "'.$company.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$strSQL3 = "SELECT ref_id_br,iv_no,iv_date,customer,sale_code,status_doc   FROM hos__br  where ref_id_br ='".$objResult["ref_id"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);
$objResult3 = mysqli_fetch_array($objQuery3)


?>

<tr>
				<td><?php echo $objResult3["ref_id_br"];?></td>
				<td><?php echo $objResult3["iv_no"];?></td>
				<td>
					<?php if ($objResult3["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult3["iv_date"]);
					}
					?> 
				</td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$objResult3["ref_id_br"]."' ";
												$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);
						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
						<?php	echo $objResult1["sol_name"]; 	?><br />
						<?php } ?>
				</div></td>
			
				<td ><div align="left"><?php echo $objResult3["customer"];?></div></td>
				<td ><div align="left"><?php echo $objResult3["sale_code"];?></div></td>
				
				<?php if($objResult3["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult3["status_doc"];?></td>
				<?php }else if($objResult3["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult3["status_doc"];?></td>
				<?php }
					else if ($objResult3["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult3["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult3["status_doc"];?></td>
				<?php } ?>
	<td  style="font-size: 10px;" ><?php echo '1';?></td>
				<td>
				<a href="register_adminbrhos_edit.php?ref_id_br=<?php echo $objResult3["ref_id_br"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
			
								
				</td>
				
			</tr>


<?php
	
			$i++; 
				}


$strSQL = "SELECT ref_id  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$start_date."' and ref_id LIKE '%CH%'";

if($company !=''){
    $strSQL .= ' AND type_company = "'.$company.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$strSQL3 = "SELECT ref_id,iv_no,iv_date,customer,sale_code,status_doc   FROM hos__change  where ref_id ='".$objResult["ref_id"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);
$objResult3 = mysqli_fetch_array($objQuery3)


?>

<tr>
				<td><?php echo $objResult3["ref_id"];?></td>
				<td><?php echo $objResult3["iv_no"];?></td>
				<td>
					<?php if ($objResult3["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult3["iv_date"]);
					}
					?> 
				</td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subchange LEFT JOIN tb_product ON hos__subchange.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult3["ref_id"]."' ";
												$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);
						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
						<?php	echo $objResult1["sol_name"]; 	?><br />
						<?php } ?>
				</div></td>
			
				<td ><div align="left"><?php echo $objResult3["customer"];?></div></td>
				<td ><div align="left"><?php echo $objResult3["sale_code"];?></div></td>
				
				<?php if($objResult3["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult3["status_doc"];?></td>
				<?php }else if($objResult3["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult3["status_doc"];?></td>
				<?php }
					else if ($objResult3["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult3["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult3["status_doc"];?></td>
				<?php } ?>
	<td  style="font-size: 10px;" ><?php echo '1';?></td>
				<td>
				<a href="register_adminchange_edit.php?ref_id=<?php echo $objResult3["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
			
								
				</td>
				
			</tr>


<?php
	
			$i++; 
				}


?>




		
	</table>
	

 
      <br>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	
</body>
</html>