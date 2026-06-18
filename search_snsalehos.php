
<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>

	
	<form name="frmSearch1" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายการใบสั่งขาย</h4></div>



<div class="w3-bar w3-quarter">
ค้นหาเลข SN : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>"></div></div></p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
</form>

<?php
$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
 if($Keyword1 !=''){

$strSQL = "SELECT *  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd)  where  status_doc !='Rejected'    and stock !='' ";

if($Keyword1 !=""){ 
	$strSQL .= ' AND sn  LIKE "%'.$Keyword1.'%"'; 
	

}
//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
?>

<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">วันที่ลงทะเบียน</td >
			<td width="10%">เลขที่เอกสาร</td > 
			<td width="10%">เลขที่ใบฝาก</td > 
			<td width="10%">วันที่ออกเอกสาร</td >
			<td width="30%">รายการสินค้า</td >
			<td width="5%">SN</td >
			<td width="25%">ชื่อผู้ออกบิล</td >
			<td width="10%">เขตการขาย</td >
			<td width="10%">สถานะ</td >
			<td width="2%">แก้ไข</td >
			<td width="2%">Print</td >
		

	</thead>
	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
			<tr>
				
					<td  ><?php echo $objResult["ref_id"];?></td>
				

								

				<td ><?php
 echo DateThai($objResult["date_so"]);
					?></td>
				<td ><?php echo $objResult["iv_no"];?></td>
				<td ><?php echo $objResult["order_no"];?></td>
				<td >
					<?php if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}
					?> 
				</td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name,sn FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php	echo $objResult1["sol_name"]; ?>
				
				
					
					<br /><?php } ?></div></td>
				
				
						
				<td ><div align="left" >
				<?php
						
				$strSQL2 = "SELECT sn FROM hos__subso  WHERE ref_idd = '".$objResult["ref_id"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						$Num_Rows2 = mysqli_num_rows($objQuery2);

						while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
							
				
				<span class="w3-red" ><?php echo $objResult2["sn"];?></span>
					<br /><?php } ?></div></td>
				
				<td ><div align="left"><?php echo $objResult["bill_name"];?></div></td>
				<td ><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				<td  >
				<?php if($objResult["send_admin"] =='1'){	?> 

				<a href="register_stockhos.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				<?php } ?>
								
				</td>
				<?php if($objResult["status_stock"] =='1'){	 ?>
				<td bgcolor="#00FF00">
					<?php }else{ ?>
					<td>
					<?php } ?>
					
<?php if($objResult["send_admin"] =='1'){	 ?>

<?php if ($objResult["type_doc"]=='3'){?>
				<a href="report_salehosptl_st.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				<?php }else if ($objResult["type_doc"]=='4'){?>
								<a href="report_salehosnbm_st.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

<?php } 
										}
	?>
				</td>
				
</tr>
			
			<?php 
 
 $i++; 
				}
		
 
?>
		
	</table>
	
	
<?php 
 }
?>

	 <br>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>