<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>Status Ecommerce </h4></div>
	
<div class="w3-half">

<div class="w3-bar w3-quarter w3-third">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>"></div>
<div class="w3-bar w3-quarter w3-third">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>"></div>
<div class="w3-bar w3-quarter w3-third">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	</div><div class="w3-half">

	
<div class="w3-bar w3-quarter w3-third">
หมายเลขคำสั่งซื้อ : <input name="Keyword2" class="w3-input" style="width:90%;" type="text" id="Keyword2" value="<?php echo $Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';?>"></div>		
<div class="w3-bar w3-quarter w3-third">		
เลขพัสดุ : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>"></div>
	
	<div class="w3-bar w3-quarter w3-third">
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
		
		</div></div><div class="w3-half">
<div class="w3-bar w3-quarter w3-third">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div><br><br>
</form>
<?php	
	$sale_channel = isset($_GET['sale_channel']) ? $_GET['sale_channel'] : '';
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
	$Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

	?>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%" style="font-size: 12px;">เลขที่อ้างอิง</th>
<th width="10%" style="font-size: 12px;">ประเภทเอกสาร</th>
<th width="10%" style="font-size: 12px;">วันที่ลงทะเบียน</th>
<th width="10%" style="font-size: 12px;">เลขที่เอกสาร</th> 
<th width="10%" style="font-size: 12px;">วันที่ออกเอกสาร</th>
<th width="10%" style="font-size: 12px;">หมายเลขคำสั่งซื้อ</th> 
<th width="23%" style="font-size: 12px;">รายการสินค้า</th>
<th width="13%" style="font-size: 12px;">ราคารวม</th>
<th width="22%" style="font-size: 12px;">ชื่อลูกค้า</th>
<th width="20%" style="font-size: 12px;">ช่องทางการขาย</th>
<th width="5%" style="font-size: 12px;">สถานะลูกค้า</th>
<th width="5%" style="font-size: 12px;">สถานะการอนุมัติ</th>
<th width="5%" style="font-size: 12px;">แก้ไข</th>
<th width="2%" style="font-size: 12px;">SMP รีวิวสินค้า</th> 
</thead>


	<?php

$to_day = date('Y-m-d');

include "dbconnect.php";
if($start_date !="" or $end_date !="" or $sale_channel !="" or $Keyword !="" or $Keyword1 !="" or $Keyword2 !=""){ 	
$strSQL = "SELECT ref_id,select_type_doc,register_date,sr_no,doc_no,doc_release_date,delivery_contact,approve_complete,ckk_h,bill_vat,select_type_doc,status_vat,print_vat,print_doc,close_mount,cancel_ckk,order_id,billing_name,approve_date,pre_name,cus_sb,que_ckk,bill_id,smp_ckk   FROM so__main  where 1";


if($start_date !=""){ 
    $strSQL .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND register_date <= "'.$end_date.'"'; 
}

if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND delivery_contact  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  = "'.$Keyword.'"'; 
	$strSQL .= ' or customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or doc_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or billing_name  LIKE "%'.$Keyword.'%"';

}
	
if($Keyword2 !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND order_id  LIKE "%'.$Keyword2.'%"'; 
}	
	
	if($Keyword1 !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND order_refer_code  LIKE "%'.$Keyword1.'%"'; 
	$strSQL .= ' or order_refer_code1  LIKE "%'.$Keyword1.'%"'; 
	}
	if($sale_channel !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND sale_channel  = "'.$sale_channel.'"'; 
	
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


$strSQL .=" order  by ref_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>



<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql = "SELECT status_cus,customer_no  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
$sql12 = "SELECT ref_idsmp,status_sup  FROM hos__smp where ref_idsale = '".$objResult["ref_id"]."'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_assoc($qry12);	
?>
<tbody>




<tr>
	
	<?php if($objResult["ckk_h"] =='0' and $objResult["doc_no"]!="ยกเลิก") { ?>
	<td bgcolor="#FF3030" style="font-size: 12px;"><?php echo $objResult["ref_id"];?></td>
		<?php }else{ ?> 
		<td style="font-size: 12px;"><?php echo $objResult["ref_id"];?></td>
		<?php } ?>
	<?php if($objResult["print_doc"] =='0'){ ?>
	<td bgcolor="#FF99FF" style="font-size: 12px;">
	<?php }else{ ?>
<td style="font-size: 12px;">
<?php } ?>	
	
	<?php if ($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='2'){
	echo 'ใบยืม'; }else { echo 'ใบสั่งขาย';  }?></td>
<td style="font-size: 12px;"><?php echo DateThai($objResult["register_date"]);?></td>
<?php if($objResult["que_ckk"] =='1'){ ?>
	<td bgcolor="#FF0000" style="font-size: 12px;">
	<?php }else{ ?>
<td style="font-size: 12px;">
<?php } ?>	<?php echo $objResult["doc_no"];?></td>
<td style="font-size: 12px;">
<?php if ($objResult["doc_release_date"]=="0000-00-00") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult["doc_release_date"]);
	}
	?> 
</td>
<td style="font-size: 12px;"><?php echo $objResult["order_id"];?></td>
<td style="font-size: 12px;"><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>
	
<td style="font-size: 12px;"><div align="rihgt">
<?php
$strSQL4 = "SELECT sum_amount FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);

while($objResult4 = mysqli_fetch_array($objQuery4))
{
?>
<?php
	echo number_format($objResult4["sum_amount"],2).""; 
	?><br />
<?php
}
?>
</div>
</td>	
	
<td style="font-size: 12px;"><div align="left"><?php echo $objResult["pre_name"];?><?php echo $objResult["billing_name"];?></div></td>


	

<td style="font-size: 12px;"><div align="left">

<?php
$strSQL2 = "SELECT salechannel_nameshort  FROM (so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where ref_id = '".$objResult["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>


<?php echo $objResult2["salechannel_nameshort"]; ?>
<?php
}
?>
</div></td>
	
<?php
 if($rs["customer_no"] !=''){
 if($rs["status_cus"]=='0'){ ?>
				<td  style="font-size: 12px;" bgcolor="#FFFF00">Gold Customer</td>
				<?php }else if($rs["status_cus"]=='1'){ ?>
				<td  style="font-size: 12px;" bgcolor="#CCFF99">Platinum Customer</td>
				<?php }else if($rs["status_cus"]=='2'){ ?>
				<td  style="font-size: 12px;" bgcolor="#00FF00">Daimond Customer</td>
				<?php
}									 
}else{ ?>
				<td></td>
				<?php } ?>	
	


<?php
					 if($objResult["approve_complete"]=='Rejected'){	?>
						<td bgcolor="#FF3030" style="font-size: 12px;"><?php echo $objResult["approve_complete"];?></td>
				<?php }else if($objResult["cancel_ckk"]=='1'){	?>
						<td bgcolor="#FF3030" style="font-size: 12px;"><?php echo 'ยกเลิก';?></td>
				<?php }
					else if ($objResult["approve_complete"]=='Approve'){ ?>
				<td bgcolor="#00FF00" style="font-size: 12px;"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else{ ?>
					<td style="font-size: 12px;"><?php echo $objResult["approve_complete"];?></td>
				<?php } ?>
	
	
<td style="font-size: 12px;">
	<?php if($objResult["approve_complete"]=='Approve'){	?>
	<a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
	<?php } ?>
	</td>

	<td>
	<?php if($objResult["smp_ckk"]=='0'){ ?>
<a href=javascript:if(confirm('!!!ต้องการเปิดเอกสารSMPรีวิวสินค้าใช่หรือไม่')==true){window.location='main_admin_smp.php?ref_id=<?php echo $objResult["ref_id"];?>';}><img src="img/receipt_product.png" width="23" height="23" border="0" /></a>		

	<?php }else if($objResult["smp_ckk"]=='1'){ ?>
	
<a href="report_sample_ad.php?ref_idsmp=<?php echo $rs12["ref_idsmp"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

	<?php } ?>
	</td>									 
	
</tr>


<?php
}	  
$i++;
}
?>
</tbody>
</table>

 <div class="w3-panel"  style="font-size: 12px;"><strong>พบทั้งหมด</strong>
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