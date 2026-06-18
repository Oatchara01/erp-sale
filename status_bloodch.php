<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายการลูกค้าแลกเครื่องวัดน้ำตาลยี้ห้ออื่น</h4></div>
	
<div class="w3-half">

<div class="w3-bar w3-quarter w3-third">
ชื่อลูกค้า : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>

<div class="w3-bar w3-quarter w3-third">
		ยี่ห้อเครื่อง / รุ่น
	<select name="type_product" id="type_product" class="w3-select" style="width:90%;" class="w3-input" >
				<option  value="">**โปรดเลือกสินค้า**</option>
				<?php
					$sqlchannel = "select * from tb_prochange order by id";
					$querychannel = mysqli_query($conn,$sqlchannel);
					while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) {
						if($_GET["type_product"] == $fetchchannel["prochange"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>
				<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['prochange']; ?>" <?php echo $sel;?>><?php echo $fetchchannel['prochange']; ?></option>
				<?php } ?>
			</select>	
		
		</div>	

<div class="w3-bar w3-quarter w3-third">		
หมายเลขเครื่อง : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>"></div>	

	</div>
		<div class="w3-half"><div class="w3-bar w3-quarter w3-third">
เบอร์โทรศัพท์ : <input name="Keyword2" class="w3-input" style="width:90%;" type="text" id="Keyword2" value="<?php echo $Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';?>"></div>		

<div class="w3-bar w3-quarter w3-third">

การเปิด SMP
<select name="chang_ckk" id="chang_ckk" style="width:160px" class="w3-input"   required>
<option  value="">**โปรดเลือกประเภท**</option>
<option  value="1">เบิกแล้ว</option>
<option  value="0">ยังไม่เบิก</option>
</div>
<div class="w3-bar w3-quarter w3-third">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div><br><br>
</form>
<?php	
	$type_product = isset($_GET['type_product']) ? $_GET['type_product'] : '';
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
	$Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$strSQL = "SELECT *  FROM tb__gluboold  where 1 ";


if($Keyword !=""){ 

	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
}
	
if($Keyword2 !=""){ 
	$strSQL .= ' AND customer_tel  LIKE "%'.$Keyword2.'%"'; 
}	
	
if($Keyword1 !=""){ 
	$strSQL .= ' AND sn_number  LIKE "%'.$Keyword1.'%"'; 
}

if($type_product !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND type_product  = "'.$type_product.'"'; 
}

if($type_product !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND type_product  = "'.$type_product.'"'; 
}

if($chang_ckk !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND chang_ckk  = "'.$chang_ckk.'"'; 
}


//echo 	$strSQL;

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


$strSQL .=" order  by register_date DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<br><br>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%" style="font-size: 12px;">วันที่ออกเอกสาร</th>
<th width="8%" style="font-size: 12px;">ยี่ห้อเครื่อง / รุ่น</th> 
<th width="8%" style="font-size: 12px;">จำนวน</th>
<th width="8%" style="font-size: 12px;">หมายเลขเครื่อง</th>
<th width="15%" style="font-size: 12px;">ชื่อลูกค้า</th>
<th width="5%" style="font-size: 12px;">เบอร์โทรศัพท์</th>
<th width="5%" style="font-size: 12px;">ผู้บันทึก</th>
<th width="2%" style="font-size: 12px;">แก้ไข</th>
<th width="2%" style="font-size: 12px;">ใบเบิก SMP</th> 
<th width="2%" style="font-size: 12px;">รูปแนบ</th> 
	
</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql12 = "SELECT ref_idsmp,status_sup,img_upsn  FROM hos__smp where ref_idsmp = '".$objResult["smp_ref"]."'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_assoc($qry12);	
	
	
?>
<tbody>
<tr>
	
	
<td style="font-size: 12px;"><?php echo DateThai($objResult["register_date"]);	?></td>

<td style="font-size: 12px;"><?php echo $objResult["type_product"];?></td>


<td style="font-size: 12px;"><div align="right"> 1 เครื่อง</div></td>

<td style="font-size: 12px;"><?php echo $objResult["sn_number"]; ?></td>

<td style="font-size: 12px;"><div align="left"><?php echo $objResult["customer_name"]; ?></div></td>
	
<td style="font-size: 12px;"><div align="left"><?php echo $objResult["customer_tel"]; ?></div></td>

	
<td style="font-size: 12px;"><?php echo $objResult["add_by"]; ?></td>
<td>
<?php if($objResult["chang_ckk"]=='0'){ ?><a href="register_blood_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a><?php } ?>
</td>
	<td>
	<?php if($objResult["chang_ckk"]=='0'){ ?>
		
<a href=javascript:if(confirm('!!!ต้องการเปิดเอกสารSMPแลกเปลี่ยนสินค้าใช่หรือไม่')==true){window.location='register_changblood.php?ref_id=<?php echo $objResult["ref_id"];?>';}><img src="img/receipt_product.png" width="23" height="23" border="0" /></a>	
	
	<?php }else if($objResult["chang_ckk"]=='1'){ ?>
	
<a href="report_sample_ad.php?ref_idsmp=<?php echo $objResult["smp_ref"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

	<?php } ?>
	</td>	
<td style="font-size: 12px;">
		<?php if($rs12["img_upsn"]!=''){ ?>
	
<a href="smp_up/<?php echo $rs12["img_upsn"]; ?>" target="_blank"><font color='blue'>Click</font></a>

	<?php } ?>
	
	</td>		
	</tr>


<?php
		  
$i++;
}
?>
</tbody>
</table>

 <div class="w3-panel"  style="font-size: 12px;">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&Keyword1=$Keyword1&Keyword2=$Keyword2&sale_channel=$sale_channel'><font color='black'><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&Keyword1=$Keyword1&Keyword2=$Keyword2&sale_channel=$sale_channel'><font color='black'>$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&Keyword1=$Keyword1&Keyword2=$Keyword2&sale_channel=$sale_channel'><font color='black'>Next>></font></a> ";
	}
	
	?>
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 

</body>
</html>