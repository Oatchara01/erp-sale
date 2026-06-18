<?php 
include('head.php'); 
include('dbconnect_sale.php'); 
?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Status ใบสั่งเช่าออกใบสั่งขาย</h4></div>
<div class="w3-bar w3-quarter w3-third">
เลขที่สัญญา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>

	<div class="w3-bar w3-quarter w3-third">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
<div class="w3-container"><br></div>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">เลขที่สัญญา</th> 
			<th width="10%">วันที่ออกเอกสาร</th>
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อผู้เช่า</th>
			<th width="10%">เขตการขาย</th>
			<th width="10%">เลขที่อ้างอิงใบสั่งขาย</th>
			<th width="10%">สถานะ</th>
			
	</thead>
		
<?php	

date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$emid = $_SESSION['code'];
$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

$strSQL = "SELECT *  FROM hos__rental  where status_doc = 'Approve'";	

if($Keyword!=''){		
$strSQL .= ' AND promis_no  LIKE "%'.$Keyword.'%"'; 		

}
		
$strSQL .=" order  by iv_date ASC ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{


?>
	<tr>
				<td><a href="register_adminrental_edit.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank"><?php echo $objResult["ref_id"];?></a></td>
				<td><?php echo $objResult["promis_no"];?></td>
				<td><?php echo DateThai($objResult["iv_date"]);?></td>
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { 
	echo $objResult1["sol_name"];  ?><br> <?php }  ?>
					
				</div></td>
				<td><div align="left"><?php echo $objResult["rental_name"];?></div></td>
				<td><div align="center"><?php echo $objResult["sale_code"];?></div></td>

				<td><div align="center">

				<?php 
				$ref_iv = substr($objResult["ref_iv"],0,2);	
				if($ref_iv=='SO'){ ?>
				<a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_iv"];?>"  target="_blank"><?php echo $objResult["ref_iv"];?></a>
				<?php }else{ ?>
<a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_iv"];?>"  target="_blank"><?php echo $objResult["ref_iv"];?></a>
<?php } ?>
				</div></td>
				
				<?php if($rs["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $rs["status_doc"];?></td>
				<?php }
					else if($rs["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"><?php echo $rs["status_doc"];?></td>
				<?php }
					else if ($rs["status_doc"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $rs["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				</tr>


<?php

$strSQL2 = "SELECT *  FROM hos__rental_runiv  where ref_idren = '".$objResult["ref_id"]."' and ref_idiv!=''";	
$strSQL2 .=" order  by date_runiv ASC ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);


$i = 1;
while($objResult2 = mysqli_fetch_array($objQuery2))
{

?>
<tbody>
			<tr>
				<td><a href="register_adminrental_edit.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank"><?php echo $objResult["ref_id"];?></a></td>
				<td><?php echo $objResult["promis_no"];?></td>
				<td><?php echo DateThai($objResult2["date_runiv"]);?></td>
				
				<td><div align="left">ค่าเช่าสินค้า</div></td>
				<td><div align="left"><?php echo $objResult["rental_name"];?></div></td>
				<td><div align="center"><?php echo $objResult["sale_code"];?></div></td>
				<td><div align="center">

				<?php 
				$ref_iv = substr($objResult["ref_iv"],0,2);	
				if($ref_iv=='SO'){ ?>
				<a href="register_adminhos_edit.php?ref_id=<?php echo $objResult2["ref_idiv"];?>"  target="_blank"><?php echo $objResult2["ref_idiv"];?></a>
				<?php }else{ ?>
<a href="register_admin_edit.php?ref_id=<?php echo $objResult2["ref_idiv"];?>"  target="_blank"><?php echo $objResult2["ref_idiv"];?></a>
<?php } ?>
				</div></td>
				<td></td>
				


			</tr>
			<?php 
	$i++; 
			}

	$i++; 
			}

?>




		</tbody>
	</table>

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ</strong>
     
     </div></div></div> <br>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	