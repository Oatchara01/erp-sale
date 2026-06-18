<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
	<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">

วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
</div>
<div class="w3-container w3-third">


  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">

</div>

<div class="w3-container w3-third">


  เขตการขาย


<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option  value="">**Please Select**</option>
<option  value="EN">EN - ช่าง</option>
<option  value="S11">S11 - พจนีย์</option>
<option  value="S12">S12 - S12</option>
<option  value="S13">S13 - S13</option>
<option  value="S14">S14 - S14</option>
<option  value="S15">S15 - ชลกานต์</option>
<option  value="S16">S16 - ภัณฑิลา</option>
<option  value="S17">S17 - S17</option>
<option  value="S21">S21 - S21</option>
<option  value="S22">S22 - S22</option>
<option  value="S23">S23 - S23</option>
<option  value="S24">S24 - S24</option>
<option  value="S31">S31 - S31</option>
<option  value="S51">S51 - S51</option>
<option  value="MM1">MM1 - MM1</option>
<option  value="SM1">SM1 - SM1</option>
<option  value="(SOL99)">(SOL99)</option>
<option  value="รัชดาภรณ์ สีสัน (SOL2)">รัชดาภรณ์ สีสัน (SOL2)</option>
<option  value="หทัยชนก  ไชยแสง (SOL1)">หทัยชนก  ไชยแสง (SOL1)</option>
<option  value="SOL3">SOL3</option>

</select>



</div>
</div>

<div class="w3-half">

<div class="w3-container w3-third">

  ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>">
</div>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
<?php	
	$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";


$strSQL = "SELECT *  FROM hos__smp  where  create_adm = '1'";

if($start_date !=""){ 
    $strSQL .= ' AND smp_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND smp_date <= "'.$end_date.'"'; 
}
	if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or smp_no  LIKE "%'.$Keyword.'%"'; 
	

}


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


$strSQL .=" order  by id_smp DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">วันที่ลงทะเบียน</th>
			<th width="10%">เลขที่เอกสาร</th>
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อลูกค้า</th>
			<th width="10%">เขตการขาย</th>
			<th width="10%">สถานะ</th>
			<th width="5%">แก้ไข</th>
			<th width="5%">Print</th>
			<th width="5%">Copy Page</th>

	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
					<?php if($objResult["send_stock"] =='1'){	 ?>
				<td bgcolor="#00FF00">
					<?php }else{ ?>
					<td>
					<?php } ?>
						<?php echo $objResult["ref_idsmp"];?></td>
				

				<td><?php
 echo DateThai($objResult["smp_date"]);
					?></td>
				
				<td><?php
 echo $objResult["smp_no"];
					?></td>
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult["ref_idsmp"]."' ";
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
				<td><div align="left"><?php echo $objResult["customer_name"];?></div></td>
				<td><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				<?php if($objResult["status_sup"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_sup"];?></td>
				<?php }
					else if ($objResult["status_sup"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["status_sup"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_sup"];?></td>
				<?php } ?>
				<td>
					<?php  if($objResult["status_sup"]!='Approve'){  ?>
					
				<a href="register_adminsmp1_edit.php?ref_idsmp=<?php echo $objResult["ref_idsmp"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
					<?php } ?>	
					
				</td>
				<?php if($objResult["print_adm"] =='1'){	 ?>
				<td bgcolor="#00FF00">
					<?php }else{ ?>
					<td>
					<?php } ?>


<a href="report_sample_ad.php?ref_idsmp=<?php echo $objResult["ref_idsmp"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				
				</td>
<td>
						<a href=javascript:if(confirm('!!!ต้องการเพิ่มเอกสารใบเบิกสินค้าใช่หรือไม่')==true){window.location='register_adminsmp_createnew.php?ref_idsmp=<?php echo $objResult["ref_idsmp"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
						
				
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
      </p>
<?php include('foot.php'); ?>
</div>
</body>
