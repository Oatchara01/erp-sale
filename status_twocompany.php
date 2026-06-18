<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Status ออเดอร์ 2 บริษัท</h4></div>

<div class="w3-half">

<div class="w3-bar w3-quarter w3-third">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>"></div>
<div class="w3-bar w3-quarter w3-third">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>"></div>
<div class="w3-bar w3-quarter w3-third">
หมายเลขคำสั่งซื้อ : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
</div>
<div class="w3-half">	
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
		
		</div>	
<div class="w3-bar w3-quarter w3-third">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</div>
</form>
<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$strSQL = "SELECT ref_id,select_type_doc,register_date,doc_no,doc_release_date,delivery_contact,approve_complete,ckk_h,bill_vat,select_type_doc,status_vat,print_vat,print_doc,sale_channel,close_mount,billing_name,order_id  FROM so__main  where doc_release_date ='0000-00-00' and (sale_channel = '1' or sale_channel ='12') and cancel_ckk ='0' and approve_complete ='Approve'";
/*and doc_no LIKE '%IV%'*/

if($start_date !=""){ 
    $strSQL .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND register_date <= "'.$end_date.'"'; 

}
if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	
	$strSQL .= ' AND order_id  LIKE "%'.$Keyword.'%"'; 
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


$strSQL .=" order  by main_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);
//echo $strSQL;

?>
<div class="w3-container">
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%">เลขที่อ้างอิง</th>
<th width="10%">ประเภทเอกสาร</th>
<th width="10%">วันที่ลงทะเบียน</th>
<th width="10%">เลขที่เอกสาร</th> 
<th width="10%">วันที่ออกเอกสาร</th>
<th width="10%">หมายเลขคำสั่งซื้อ</th>
<th width="23%">รายการสินค้า</th>
<th width="22%">ชื่อลูกค้า</th>
	
<th width="20%">ช่องทางการขาย</th>
<th width="5%">สถานะการอนุมัติ</th>
<th width="5%">แก้ไข</th>
<th width="5%" >copy</th>	

</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tbody>




<tr align="">
	
	
		<?php if($objResult["ckk_h"] =='0' and $objResult["doc_no"]!="ยกเลิก") { ?>
	<td bgcolor="#FF3030"><?php echo $objResult["ref_id"];?></td>
		<?php }else{ ?> 
		<td><?php echo $objResult["ref_id"];?></td>
		<?php } ?>
	<?php if($objResult["print_doc"] =='0'){ ?>
	<td bgcolor="#FF99FF">
	<?php }else{ ?>
<td>
<?php } ?>	
	
	<?php if ($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='2'){
	echo 'ใบยืม'; }else { echo 'ใบสั่งขาย';  }?></td>
<td><?php echo DateThai($objResult["register_date"]);?></td>
<td><?php echo $objResult["doc_no"];?></td>
<td>
<?php if ($objResult["doc_release_date"]=="" or $objResult["doc_release_date"]=="0000-00-00") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult["doc_release_date"]);
	}
	?> 
</td>
<td><div align="left"><?php echo $objResult["order_id"];?></div></td>
	
<td><div align="left">
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
<td><div align="left"><?php echo $objResult["billing_name"];?></div></td>

<td><div align="left">
	

<?php
$strSQL2 = "SELECT salechannel_nameshort  FROM  tb_salechannel  where salechannel_ID = '".$objResult["sale_channel"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>


<?php echo $objResult2["salechannel_nameshort"];?>
<?php
}
?>

</div></td>


<?php
					if($objResult["approve_complete"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else if ($objResult["approve_complete"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["approve_complete"];?></td>
				<?php } ?>

<td>
	<?php if($objResult["close_mount"]=='0'){ ?>
	<a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" />
	<?php } ?>
	</a>
	</td>
<td style="font-size: 12px;"><a href="register_admin_createnew.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a></td>

	
</tr>


<?php

$i++;
}
?>
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
 <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
</body>
</html>