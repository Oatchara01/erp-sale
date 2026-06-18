<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey"><h3>Status ค้างส่งสินค้า</h3></div>

<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>"></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>"></div>
<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo 	$keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php		  
	$keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

	$to_day = date('Y-m-d');

include "dbconnect.php";
/*and sale_channel = '4'*/
$strSQL = "SELECT ref_id,select_type_doc,register_date,doc_no,doc_release_date,delivery_contact,approve_complete,ckk_h,send_erpst,
printst_ckk,stock_print,billing_name   FROM so__main   where   approve_complete = 'Approve' and cancel_ckk='0' and send_stock = '1' and send_erpst='0' and doc_no NOT LIKE '%A%' ";

if($start_date !=""){ 
    $strSQL .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND register_date <= "'.$end_date.'"'; 
}

if($keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND delivery_contact  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or customer_name  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or tel  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or doc_no  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or order_id  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or order_refer_code  LIKE "%'.$keyword.'%"'; 
   $strSQL .= ' or ref_id  LIKE "%'.$keyword.'%"'; 
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
<th width="5%">สถานะการดำเนินงาน</th>
<th width="5%">แก้ไข</th>
</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql5 = "SELECT *
        FROM so__submain 
        LEFT JOIN tb_product ON so__submain.product_ID = tb_product.product_id
        WHERE ref_idd = '".$objResult["ref_id"]."' AND clear_br = '0' and product_type ='อื่นๆ' and  ckk_st = '0'";
$query5 = mysqli_query($conn, $sql5);

while ($objResupo = mysqli_fetch_assoc($query5)) {	
	
$strSQL9 = "Update   so__submain set   ckk ='1',ckk_st='1' Where id= '".$objResupo["id"]."' ";
$objQuery9 = mysqli_query($conn,$strSQL9);
	
}
	
$strSQL21 = "SELECT * FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' and ckk_st = '0'";
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 == 0){

$save22="Update  so__main set send_erpst ='1'  Where ref_id='".$objResult["ref_id"]."'";
$qsave22=mysqli_query($conn,$save22);


}
	
	
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
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' and ckk_st='0'";
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




				<?php if ($objResult["ckk_h"]=='0'){ ?>
				<td bgcolor = "#FFFF33" ><?php echo 'รอจัดของ';?></td>
				<?php }else
					if ($objResult["ckk_h"]=='1' and $objResult["send_erpst"]=='0'){ ?>
					<td bgcolor="#FF9933"><?php echo 'จัดของยังไม่ครบ';?></td>
					<?php
					}else if ($objResult["ckk_h"]=='1'){ ?>
					<td bgcolor="#00FF00"><?php echo 'จัดของแล้ว';?></td>
				<?php } ?>
						
	<td>
		<a href="register_awsend2_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
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
</div>
 </div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>