<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>รายการทำแบบสอบถาม</h3></div>

<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
include "dbconnect_cs.php";
	
$sale_code = $_SESSION['code'];
//AND DATEDIFF(CURDATE(), iv_date) >= 60
$strSQL = "SELECT *  FROM hos__so  where sale_code = '".$sale_code."' and status_doc = 'Approve' and close_reseach='0' and reseach_kk='1' and iv_date !='0000-00-00' ";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}
	
if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}
	
if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND bill_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or po_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or status_doc  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 

}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$strSQL .=" order  by id DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<!--th width="10%">วันที่ลงทะเบียน</th-->
			<th width="10%">วันที่ส่งของ</th>
			<th width="10%">เลขที่เอกสาร</th> 
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อผู้ออกบิล</th>
			<th width="10%">เขตการขาย</th>
			<th width="10%">สถานะ</th>
			<th width="5%">แบบสอบถาม</th>

	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>

					<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				<td>
					<?php /*if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}*/
					?> 
					<?php if ($objResult["delivery_date"]=="0000-00-00") {
						echo $objResult["date_send_key"];
					} 
					else 
					{ echo DateThai($objResult["delivery_date"]);
					}
					?> 
					
				</td>

				<!--td><?php echo DateThai($objResult["date_so"]);	?></td-->
				<td><?php echo $objResult["iv_no"];?></td>
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 if($objResult1["bom_ckk"]=='0'){
	echo $objResult1["sol_name"]; 

	
	?><br />
					
						<?php }  
						}
					
$strSQL2 = "SELECT distinct code_bom  FROM hos__subso  WHERE ref_idd = '".$objResult["ref_id"]."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2)){
		
$code_bom	= $objResult2["code_bom"];	

$strSQL3 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product_bomhos ON hos__subso.code_bom=tb_product_bomhos.bom_code) WHERE ref_idd = '".$objResult["ref_id"]."' and code_bom = '".$code_bom."'";

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);
while($objResult3 = mysqli_fetch_array($objQuery3))
{
if($objResult3["code_bom"]!=""){
	echo $objResult3["bom_name"]; 
?> </br>
					<?php
	
 }
}
}
	
					
					
					
					?>
					
				</div></td>
				<td><div align="left"><?php echo $objResult["bill_name"];?></div></td>
				<td><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				
	<td>
<?php 
if ($objResult["iv_date"] >= '2026-03-01') { ?>
    <a href="javascript:if(confirm('!!!ต้องการทำแบบสอบถามหลังการติดตั้ง')==true){window.location='research_010369.php?ref_id=<?php echo $objResult["ref_id"]; ?>';}">
        <img src="img/receipt_product.png" width="23" height="23" border="0" />
    </a>

<?php } elseif ($objResult["iv_date"] <= '2022-03-31') { ?>
    <a href="javascript:if(confirm('!!!ต้องการทำแบบสอบถามหลังการติดตั้ง')==true){window.location='register_reseachsale.php?running=<?php echo $objResult["job_no"];?>&ref_id=<?php echo $objResult["ref_id"]; ?>';}">
        <img src="img/receipt_product.png" width="23" height="23" border="0" />
    </a>

<?php } elseif ($objResult["iv_date"] >= '2025-10-01') { ?>
    <a href="javascript:if(confirm('!!!ต้องการทำแบบสอบถามหลังการติดตั้ง')==true){window.location='register_reseachsalenws.php?running=<?php echo $objResult["job_no"];?>&ref_id=<?php echo $objResult["ref_id"]; ?>';}">
        <img src="img/receipt_product.png" width="23" height="23" border="0" />
    </a>

<?php } else { ?>
    <a href="javascript:if(confirm('!!!ต้องการทำแบบสอบถามหลังการติดตั้ง')==true){window.location='register_reseachsalenew.php?running=<?php echo $objResult["job_no"];?>&ref_id=<?php echo $objResult["ref_id"]; ?>';}">
        <img src="img/receipt_product.png" width="23" height="23" border="0" />
    </a>
<?php } ?>
	
</td>


			</tr>
			<?php 
	$i++;  
}

	?>
		</tbody>
	</table>

 
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>