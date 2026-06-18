<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายการออเดอร์เครื่องวัดน้ำตาล GLUCOSURE</h4></div>
	
<div class="w3-half">

<div class="w3-bar w3-quarter w3-third">
ชื่อลูกค้า : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	
<div class="w3-bar w3-quarter w3-third">
หมายเลขคำสั่งซื้อ : <input name="Keyword2" class="w3-input" style="width:90%;" type="text" id="Keyword2" value="<?php echo $Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';?>"></div>		
<div class="w3-bar w3-quarter w3-third">		
หมายเลขเครื่อง : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>"></div>
	
	</div><div class="w3-half"><div class="w3-bar w3-quarter w3-third">
		ช่องทางการขาย
	<select name="sale_channel" id="sale_channel" class="w3-select" style="width:90%;" class="w3-input" >
				<option  value="">**โปรดเลือกช่องทางการขาย**</option>
				<?php
					$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
					$querychannel = mysqli_query($conn,$sqlchannel);
					while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) {
						if($_GET["sale_channel"] == $fetchchannel["salechannel_ID"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>
				<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>" <?php echo $sel;?>><?php echo $fetchchannel['salechannel_nameshort']; ?></option>
				<?php } ?>
			</select>	
		
		</div>
<div class="w3-bar w3-quarter w3-third">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div><br><br>
</form>
<?php	
	$sale_channel = isset($_GET['sale_channel']) ? $_GET['sale_channel'] : '';
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
	$Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$strSQL = "SELECT *  FROM tb__glucos  where sn !='' ";


if($Keyword !=""){ 

	$strSQL .= ' AND customer  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or bill_name  = "'.$Keyword.'"'; 
}
	
if($Keyword2 !=""){ 
	$strSQL .= ' AND order_id  LIKE "%'.$Keyword2.'%"'; 
}	
	
if($Keyword1 !=""){ 
	$strSQL .= ' AND sn  LIKE "%'.$Keyword1.'%"'; 
}

if($sale_channel !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND sale_chan  = "'.$sale_channel.'"'; 
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


$strSQL .=" order  by doc_date DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<br><br>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%" style="font-size: 12px;">เลขที่อ้างอิง</th>
<th width="8%" style="font-size: 12px;">เลขที่เอกสาร</th> 
<th width="8%" style="font-size: 12px;">วันที่ออกเอกสาร</th>
<th width="8%" style="font-size: 12px;">หมายเลขคำสั่งซื้อ</th> 
<th width="15%" style="font-size: 12px;">รายการสินค้า</th>
<th width="8%" style="font-size: 12px;">จำนวน</th>
<th width="8%" style="font-size: 12px;">ราคารวม</th>
<th width="8%" style="font-size: 12px;">หมายเลขเครื่อง</th>
<th width="15%" style="font-size: 12px;">ชื่อลูกค้า</th>
<th width="5%" style="font-size: 12px;">ช่องทางการขาย</th>
<th width="5%" style="font-size: 12px;">เขตการขาย</th>
<th width="2%" style="font-size: 12px;">ใบเบิก SMP</th> 
<th width="2%" style="font-size: 12px;">รูปแนบ</th> 	
</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$go = substr($objResult["ref_id"],0,2);	
	
$sql12 = "SELECT ref_idsmp,status_sup,img_upsn  FROM hos__smp where ref_idsmp = '".$objResult["smp_ref"]."'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_assoc($qry12);	

$strSQL1 = "SELECT sol_name,unit_name  FROM tb_product where product_ID = '".$objResult["product_id"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT salechannel_nameshort  FROM tb_salechannel where salechannel_ID  = '".$objResult["sale_chan"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


?>
<tbody>
<tr>
	
	
<td style="font-size: 12px;"><?php echo $objResult["ref_id"]; ?></td>
<td style="font-size: 12px;"><?php echo $objResult["iv_no"]; ?></td>
<td style="font-size: 12px;"><?php echo DateThai($objResult["doc_date"]);	?></td>

<td style="font-size: 12px;"><?php echo $objResult["order_id"];?></td>


<td style="font-size: 12px;"><div align="left"><?php echo $objResult1["sol_name"]; ?></div></td>
<td style="font-size: 12px;"><div align="right"><?php echo number_format($objResult["count"],0).""; ?> <?php echo $objResult1["unit_name"]; ?></div></td>

<td style="font-size: 12px;"><div align="right"><?php echo number_format($objResult["amount"],2).""; ?></div></td>

<td style="font-size: 12px;"><?php echo $objResult["sn"]; ?></td>

<td style="font-size: 12px;"><div align="left"><?php echo $objResult["customer"]; ?></div></td>
	

<td style="font-size: 12px;"><div align="left"><?php echo $objResult2["salechannel_nameshort"]; ?></div></td>
	
<td style="font-size: 12px;"><?php echo $objResult["sale_code"]; ?></td>
	
	<td>
	<?php if($objResult["chang_ckk"]=='0'){ 
		if($go=='SO'){ 
		
		?>
		
<a href=javascript:if(confirm('!!!ต้องการเปิดเอกสารSMPแลกเปลี่ยนสินค้าใช่หรือไม่')==true){window.location='register_changglucosh.php?ref_id=<?php echo $objResult["ref_id"];?>&id=<?php echo $objResult["id"];?>';}><img src="img/receipt_product.png" width="23" height="23" border="0" /></a>	
	
		<?php }else{ ?>
<a href=javascript:if(confirm('!!!ต้องการเปิดเอกสารSMPแลกเปลี่ยนสินค้าใช่หรือไม่')==true){window.location='register_changglucos.php?ref_id=<?php echo $objResult["ref_id"];?>&id=<?php echo $objResult["id"];?>';}><img src="img/receipt_product.png" width="23" height="23" border="0" /></a>	
		
		<?php } ?>

	<?php }else if($objResult["chang_ckk"]=='1'){ ?>
	
<a href="report_sample_ad.php?ref_idsmp=<?php echo $rs12["ref_idsmp"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

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