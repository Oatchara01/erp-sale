<?php include('head.php');
 include('dbconnect_sale.php');
?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายการใบเบิกสินค้า (ทั้งหมด)</h4></div>

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


<select name="sale_code" id="sale_code" style="width:90%" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm  ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($_GET["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>



</div>
</div>

<div class="w3-half">

<div class="w3-container w3-third">

  เลขที่อ้างอิง : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>">
</div>
<div class="w3-container w3-third">

  เลขที่เอกสาร : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>">
</div>	
<div class="w3-container w3-third">

 ชื่อลูกค้า : <input name="Keyword2" class="w3-input" style="width:90%;" type="text" id="Keyword2" value="<?php echo $Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';?>">
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
	$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
	$Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";


$strSQL = "SELECT *  FROM hos__smp  where 1";

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
	$strSQL .= ' AND ref_idsmp  LIKE "%'.$Keyword.'%"'; 
	
}

if($Keyword1 !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND smp_no  LIKE "%'.$Keyword1.'%"';
	
}	
	
if($Keyword2 !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword2.'%"';
	
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
			<th width="10%">หมายเลขคำสั่งซื้อใหม่</th>
			<th width="8%">เคลียร์ยืม</th>
			<th width="23%">รายการสินค้า</th>
			<th width="8%">จำนวน</th>
			<th width="10%">Comment</th>
			<th width="22%">ชื่อลูกค้า</th>
			<th width="7%">เขตการขาย</th>
			<th width="7%">สถานะ</th>
			<th width="8%">ผู้อนุมัติ</th>
			<th width="5%">แก้ไข</th>
			<th width="5%">Print</th>
			<th width="2%">สร้างใบรับสินค้า</th>
			<th width="2%">ใบรับคืนสินค้า</th>
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
				
				<td><?php echo $objResult["smp_no"]; ?></td>
				<td><?php echo $objResult["order_no"]; ?></td>
				<td><div align="left">
					<?php
						$strSQL18 = "SELECT br_no FROM hos__subsmp  WHERE reff_idsmp = '".$objResult["ref_idsmp"]."' ";
						$objQuery18 = mysqli_query($conn,$strSQL18) or die ("Error Query [".$strSQL18."]");
						$Num_Rows18 = mysqli_num_rows($objQuery18);

						while($objResult18 = mysqli_fetch_array($objQuery18)) { ?>
							<?php
 
	echo $objResult18["br_no"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult["ref_idsmp"]."' ";
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
				
				<td><div align="left">
					<?php
						$strSQL19 = "SELECT sale_count,unit_name FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id)  WHERE reff_idsmp = '".$objResult["ref_idsmp"]."' ";
						$objQuery19 = mysqli_query($conn,$strSQL19) or die ("Error Query [".$strSQL19."]");
						$Num_Rows19 = mysqli_num_rows($objQuery19);

						while($objResult19 = mysqli_fetch_array($objQuery19)) { ?>
							<?php
 
	echo $objResult19["sale_count"];  echo $objResult19["unit_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				
				<td><div align="left"><?php echo $objResult["comment_sale"];?></div></td>
				<td><div align="left"><?php echo $objResult["customer_name"];?></div></td>
				<td><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				<?php if($objResult["status_sup"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_sup"];?></td>
				<?php }else if ($objResult["status_sup"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["status_sup"];?></td>
				<?php }else if ($objResult["status_sup"]=='Request' and $objResult["send_dm"]=='1'){ ?>
					<td ><?php echo "รอผู้บริหารอนุมัติ";?></td>
	            <?php }else if ($objResult["status_sup"]=='Request' and $objResult["send_dm"]=='0' and $objResult["sup_name"]!='' and $objResult["send_sup"]=='1'){ ?>
					<td ><?php echo "รอกดส่งผู้บริหารอนุมัติ"; echo  $objResult["sup_name"]; ?></td>
	<?php }else if ($objResult["status_sup"]=='Request' and $objResult["send_sup"]=='1'){ ?>
					<td ><?php echo "รอหัวหน้าอนุมัติ";?></td>
	<?php }else if ($objResult["status_sup"]=='Request' and $objResult["send_sup"]=='0'){ ?>
					<td ><?php echo "รอกดส่งหัวหน้าอนุมัติ";?></td>
				<?php } ?>
				<td><div align="left"><?php 
 if ($objResult["status_sup"] !=''){
 if($objResult["dm_name"] !=''){
  echo $objResult["dm_name"];
 }else{
	 echo $objResult["sup_name"];
 }
 }		?></div></td>
				<td>
					<?php if ($objResult["status_sup"]=='Approve'){ ?>
				<a href="register_adminsmp_edit.php?ref_idsmp=<?php echo $objResult["ref_idsmp"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				<?php } ?>				
				</td>
				<?php if($objResult["print_adm"] =='1'){	 ?>
				<td bgcolor="#00FF00">
					<?php }else{ ?>
					<td>
					<?php } ?>

<?php if ($objResult["status_sup"]=='Approve'){ ?>
<a href="report_sample_ad.php?ref_idsmp=<?php echo $objResult["ref_idsmp"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				<?php } ?>		
				</td>
<td>
<?php if ($objResult["status_sup"]=='Approve'){ ?>
<a href=javascript:if(confirm('!!!ต้องการสร้างใบรับสินค้าใช่หรือไม่')==true){window.location='register_receivepro_smp.php?ref_id=<?php echo $objResult["ref_idsmp"];?>';}><img src="img/create.png" width="23" height="23" border="0" /></a>
	<?php } ?>
</td>	
<td>
<a href=javascript:if(confirm('!!!ต้องการคืนสินค้าใช่หรือไม่')==true){window.location='register_receive_smp.php?ref_idsmp=<?php echo $objResult["ref_idsmp"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>		</td>
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&sale_code=$sale_code&Keyword2=$Keyword2&start_date=$start_date&end_date=$end_date&Keyword1=$Keyword1'><font color ='black'><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&Keyword1=$Keyword1&sale_code=$sale_code&Keyword2=$Keyword2'><font color ='black'>$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&Keyword1=$Keyword1&sale_code=$sale_code&Keyword2=$Keyword2'><font color ='black'>Next>></font></a> ";
	}
	
	?>
      <br>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>
