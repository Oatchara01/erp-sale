<?php include('head.php'); ?>
<body>
<div class="w3-container w3-white">	
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large w3-white">
<div class="w3-panel w3-light-grey"><h3>อนุมัติใบเบิกเป็นสินค้าสาธิต</h3></div>
</div>
</form>
<?php	
include "dbconnect.php";
$strSQL = "SELECT *  FROM st__expro  where send_dm='1' and status_doc ='Request' ";

$objQuery = mysqli_query($new,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$Per_Page = '50';  
		$Page = isset($_GET['Page']) ? $_GET['Page'] : '';

	if(!isset($_GET['Page']))
	{
		$Page=1;
	}

	$Prev_Page = $Page-1;
	$Next_Page = $Page+1;

	$Page_Start = (($Per_Page*$Page)-$Per_Page);
	if($Num_Rows<=$Per_Page)
	{
		$Num_Pages =1;
	}
	else if(($Num_Rows % $Per_Page)==0)
	{
		$Num_Pages =($Num_Rows/$Per_Page) ;
	}
	else
	{
		$Num_Pages =($Num_Rows/$Per_Page)+1;
		$Num_Pages = (int)$Num_Pages;
	}


$strSQL .=" order  by ref_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($new,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">วันที่ออกเอกสาร</th>
			<th width="10%">เลขที่เอกสาร</th>
			<th width="23%">รายการสินค้า</th>
			<th width="10%">จำนวน</th>
			<th width="22%">หมายเหตุ</th>
			<th width="10%">ผู้บันทึก</th>
			<th width="10%">สถานะ</th>
			<th width="5%">แก้ไข</th>

	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				

				<td><?php
 echo DateThai($objResult["iv_date"]);
					?></td>
				
				<td><?php
 echo $objResult["iv_no"];
					?></td>
				
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name FROM (st__subexpro LEFT JOIN tb_product ON st__subexpro.product_id=tb_product.product_ID) WHERE ref_idd	 = '".$objResult["ref_id"]."' ";
						$objQuery1 = mysqli_query($new,$strSQL1) or die ("Error Query [".$strSQL1."]");
						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 
	echo $objResult1["sol_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				<td><div align="right">
					<?php
						$strSQL2 = "SELECT count,unit_name FROM (st__subexpro LEFT JOIN tb_product ON st__subexpro.product_id=tb_product.product_ID) WHERE ref_idd	 = '".$objResult["ref_id"]."' ";
						$objQuery2 = mysqli_query($new,$strSQL2) or die ("Error Query [".$strSQL2."]");
						while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
							<?php
 
	echo $objResult2["count"]; echo " " ;   echo $objResult2["unit_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				<td><div align="left"><?php echo $objResult["description"];?></div></td>
				<td><div align="left"><?php echo $objResult["add_by"];?></div></td>
				
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
				
				<a href="register_exproduct_app.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a>
												
				</td>
					
				
			</tr>
			<?php $i++; } ?>
		</tbody>
	</table>

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page'><span class='style40'>Next>></span></a> ";
	}
	
	?>
      </p>
<?php include('foot.php'); ?>
</div>
</body>
</html>