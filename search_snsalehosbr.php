<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<form name="frmSearch1" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายการใบยืม</h4></div>



<div class="w3-bar w3-quarter">
ค้นหาเลข SN : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>"></div></div></p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
</form>

<?php
$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
 if($Keyword1 !=''){
	


?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">วันที่ลงทะเบียน</td >
			<td width="10%">เลขที่เอกสาร</td > 
			<td width="10%">วันที่ออกเอกสาร</td >
			<td width="30%">รายการสินค้า</td >
			<td width="30%">SN Number</td >
			<td width="25%">ชื่อผู้ออกบิล</td >
			<td width="10%">เขตการขาย</td >
			<td width="10%">สถานะ</td >
			<td width="2%">แก้ไข</td >
			<td width="2%">Print</td >
		

	</thead>
	

	




	
<?php
$strSQL = "SELECT *  FROM  hos__subbr  where  sn  LIKE '%".$Keyword1."%'";

/*if($Keyword1 !=""){ 
	$strSQL .= ' AND '; 
}*/

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);	 
	 
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
	$strSQL9 = "SELECT *  FROM  hos__br  where  ref_id_br  ='".$objResult["ref_idd_br"]."'";


$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);	 
	 
$i = 1;
while($objResult9 = mysqli_fetch_array($objQuery9))
{
?>
		
			<tr>
				
					<td ><?php echo $objResult["ref_idd_br"];?></td>
				
				<td ><?php
 echo DateThai($objResult9["date_br"]);
					?></td>
				<td ><?php echo $objResult9["iv_no"];?></td>
				<td >
					<?php if ($objResult9["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult9["iv_date"]);
					}
					?> 
				</td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$objResult9["ref_id_br"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 
	echo $objResult1["sol_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				
				<td ><div align="left" >
														
				
				<span class="w3-red" ><?php echo $objResult["sn"];?></span>
					<br /></div></td>
				
				<td ><div align="left"><?php echo $objResult9["customer"];?></div></td>
				<td ><div align="left"><?php echo $objResult9["sale_code"];?></div></td>
				
				<?php if($objResult9["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult9["status_doc"];?></td>
				<?php }
					else if ($objResult9["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult9["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult9["status_doc"];?></td>
				<?php } ?>
				

	<td  >
				<?php if($objResult9["send_admin"] =='1'){	?> 

				<a href="register_stockbrhos.php?ref_id_br=<?php echo $objResult9["ref_id_br"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				<?php } ?>
								
				</td>

								
					<td>
<?php if($objResult9["send_admin"] =='1'){	if($objResult9["company"] =='1' ){				
					?> 
					
				<a href="report_loanhosptl_st.php?ref_id_br=<?php echo $objResult9["ref_id_br"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
					<?php }else{ ?>
				<a href="report_loanhosnbm_st.php?ref_id_br=<?php echo $objResult9["ref_id_br"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>	
				<?php } } ?>
				</td>
				

			</tr>
			<?php $i++; 
				}
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