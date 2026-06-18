<?php 
include('head.php'); 
include('dbconnect_sale.php'); 
?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Status ใบสั่งเช่ารอเปิดใบสั่งขาย</h4></div>

	
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">วันที่ครบรอบชำระเงิน</th>
			<th width="10%">เลขที่เอกสาร</th> 
			<th width="10%">วันที่ออกเอกสาร</th>
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อผู้เช่า</th>
			<th width="10%">เขตการขาย</th>
			<th width="10%">สถานะ</th>
			<th width="5%">เปิดใบสั่งขาย</th>
			<th width="5%">ปิดใบสั่งเช่า</th>
	</thead>
		
<?php	

date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$emid = $_SESSION['code'];

$strSQL = "SELECT *  FROM hos__rental_runiv  where ckk_open='0' and close_ckk='0'";	
$strSQL .=" order  by date_runiv ASC ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$sql = "SELECT *   FROM hos__rental where ref_id = '".$objResult["ref_idren"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);


$calculate =strtotime($objResult["date_runiv"])-strtotime(date('Y-m-d'));
$summary=floor($calculate / 86400);

?>
<tbody>
			<tr>
				<td><?php echo $objResult["ref_idren"];?></td>
				<?php if($summary <='3'){ ?>
				<td  bgcolor="#FF3030" >
				<?php }else{ ?>
				<td>
				<?php } ?>
			<?php echo DateThai($objResult["date_runiv"]);?></td>
<td><?php echo $rs["iv_no"];?></td>
				<td><?php if ($rs["iv_date"]=="0000-00-00") { echo "-"; }else{ echo DateThai($rs["iv_date"]);	} ?> 
				</td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) WHERE ref_idd = '".$rs["ref_id"]."' ";
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { 
	echo $objResult1["sol_name"];  ?><br> <?php }  ?>
					
				</div></td>
				<td><div align="left"><?php echo $rs["rental_name"];?></div></td>
				<td><div align="center"><?php echo $rs["sale_code"];?></div></td>
				
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
				<td>
<?php if($rs["ckk_allwell"]=='1'){?>					
<a href="open_rentaliv_sale.php?ref_id=<?php echo $rs["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a>
		<?php }else{ ?>
<a href="open_rentaliv_sup.php?ref_id=<?php echo $rs["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a>
			<?php } ?>
				</td>
                <td><a href="close_suprental.php?ref_id=<?php echo $rs["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>


			</tr>
			<?php 
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