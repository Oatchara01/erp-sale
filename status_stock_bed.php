<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>"></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>"></div>
	
<div class="w3-bar w3-quarter">


 ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)" OnChange="resutName(this.value);">
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?><?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>


</div>
<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo 	$keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php		  
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	$sale_channel = isset($_GET['sale_channel']) ? $_GET['sale_channel'] : '';
	date_default_timezone_set("Asia/Bangkok");

	$to_day = date('Y-m-d');

include "dbconnect.php";

$strSQL = "SELECT ref_id,select_type_doc,register_date,doc_no,doc_release_date,delivery_contact,approve_complete,ckk_h,
printst_ckk,close_mount    FROM so__main   where   approve_complete = 'Approve' and allwell_ckk ='1' and send_stock = '1' and ckk_h ='0'  and cancel_ckk='0' and printst_ckk='0' and doc_no !='IV'";

if($start_date !=""){ 
    $strSQL .= ' AND register_date >= "'.$start_date.'"'; 
}/*else{
    $strSQL .= ' AND register_date >= "'.$to_day.'"'; 

}*/
	
	if($sale_channel !=''){
	$strSQL .= ' AND sale_channel = "'.$sale_channel.'"'; 
	}

if($end_date !=""){ 
    $strSQL .= ' AND register_date <= "'.$end_date.'"'; 
}/*else{
    $strSQL .= ' AND register_date <= "'.$to_day.'"'; 

}*/
if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND delivery_contact  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or tel  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or doc_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or order_id  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or order_refer_code  LIKE "%'.$Keyword.'%"'; 
   $strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 
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
<th width="20%">ช่องทางการขาย</th>
<th width="5%">สถานะการอนุมัติ</th>
<th width="5%">แก้ไข</th>
<th width="2%">Print</th >
</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tbody>
	<?php if($objResult["doc_no"]!=''){ ?>	
	
<tr align="">
<td><?php echo $objResult["ref_id"];?></td>
<td><?php echo DateThai($objResult["register_date"]);?></td>
<td><?php echo $objResult["doc_no"];?></td>
<td>
<?php if ($objResult["doc_release_date"]=="0000-00-00") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult["doc_release_date"]);
	}
	?> 
</td>
<td><div align="left">
<?php
$strSQL1 = "SELECT access_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["access_name"]; 
 	?><br />
<?php
}
?>
</div>
</td>
<td><div align="left"><?php echo $objResult["delivery_contact"];?></div></td>


<td><div align="left">
	

<?php
$strSQL2 = "SELECT salechannel_nameshort FROM (so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where ref_id = '".$objResult["ref_id"]."'";
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
<?php 	if($objResult["close_mount"]=='0'){ ?>
	<a href="register_stock_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date;  ?>&end_date=<?php echo $end_date;?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
	
	<?php } ?>
	</td>
	
	<?php if($objResult["printst_ckk"] =='1'){	 ?>
				<td bgcolor="#00FF00">
					<?php }else{ ?>
					<td>
					<?php } ?>
<?php if ($objResult["select_type_doc"]=='1'){?>
<a href="report_loanptl_st.php?ref_id=<?php echo $objResult["ref_id"];?>&stock=<?php echo $_SESSION['name'];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				<?php }else if ($objResult["select_type_doc"]=='2'){?>
<a href="report_loannbm_st.php?ref_id=<?php echo $objResult["ref_id"];?>&stock=<?php echo $_SESSION['name'];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

<?php }else if ($objResult["select_type_doc"]=='3'){?>
<a href="report_saleptl1_st.php?ref_id=<?php echo $objResult["ref_id"];?>&stock=<?php echo $_SESSION['name'];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

<?php }else if ($objResult["select_type_doc"]=='4'){?>
<a href="report_salenbm1_st.php?ref_id=<?php echo $objResult["ref_id"];?>&stock=<?php echo $_SESSION['name'];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

<?php } ?>
		</td>
</tr>
<?php
$i++;
}
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_channel=$sale_channel'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_channel=$sale_channel'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_channel=$sale_channel'><span class='style40'>Next>></span></a> ";
	}
	
	?>
</div>
<?php include('foot.php'); ?>
</div>
</body>
</html>