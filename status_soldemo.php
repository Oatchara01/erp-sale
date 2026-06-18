<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>แบบสอบถามสินค้าสาธิต</h3></div>
</form>
<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
include "dbconnect_cs.php";
$strSQL = "SELECT ref_id,select_type_doc,register_date,doc_no,doc_release_date,delivery_contact,approve_complete,cancel_ckk,order_refer_code,order_refer_code1,employee_name,sale_channel,bill_id,bill_vat,status_vat  FROM so__main  where research_demo = '1' ";


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$Per_Page = '20';  
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


$strSQL .=" order  by main_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">วันที่ลงทะเบียน</th>
			<th width="10%">เลขที่เอกสาร</th> 
			<th width="10%">วันที่ออกเอกสาร</th>
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อลูกค้า</th>
			<th width="10%">สถานะ</th>
			<th width="5%">ทำแบบสอบถาม</th>
			
			
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
 echo DateThai($objResult["register_date"]);
					?></td>
				<td><?php echo $objResult["doc_no"];?></td>
				<td>
					<?php if ($objResult["doc_release_date"]=="0000-00-00" or $objResult["doc_release_date"]=="") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["doc_release_date"]);
					}
					?> 
				</td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						///echo $strSQL;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php

	echo $objResult1["sol_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				
				<?php /*<td><div align="left">
					
						$strSQL1 = "SELECT SUM(sum_amount) AS sum FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$objResult1 = mysqli_fetch_array($objQuery1); 

	echo $objResult1["sum"]; 
				</div></td>*/ ?>
				
				
				<td><div align="left"><?php echo $objResult["delivery_contact"];?></div></td>
				
				<?php
					if($objResult["approve_complete"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["approve_complete"];?></td>
				<?php }else if($objResult["cancel_ckk"]=='1'){	?>
						<td bgcolor="#FF3030"><?php echo 'ยกเลิก';?></td>
				<?php }
					else if ($objResult["approve_complete"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["approve_complete"];?></td>
				<?php } ?>
	<td><a href="reserch_soldemo.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a></td>
	
	
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'><span class='style40'>Next>></span></a> ";
	}
	
	?>
      <br></div></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>