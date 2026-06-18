<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-grey"><h3>ใบรับคืนสินค้า รอคลังรับสินค้า</h3></div>

<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$sale_code = $_SESSION['code'];
$user_type = $_SESSION['user_type'];

if($user_type=='Engineer'){
$strSQL = "SELECT *  FROM hos__receive  where  sale_code LIKE'%EN%' and report_ckk ='0'";
}else{
$strSQL = "SELECT *  FROM hos__receive  where  sale_code ='".$sale_code."' and report_ckk ='0' ";	
}

if($start_date !=""){ 
    $strSQL .= ' AND date_receive >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_receive <= "'.$end_date.'"'; 
}

if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 

}
//echo $strSQL;

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


$strSQL .=" order  by id_auto DESC   LIMIT $Page_Start , $Per_Page";
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
			<th width="5%">สถานะการดำเนินงาน</th>
			<th width="5%">รับคืนโดย</th>
			<th width="5%">สถานะสินค้า</th>
			<th width="2%">ดูรายละเอียด</th>

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
 echo DateThai($objResult["date_receive"]);
					?></td>
				<td><?php echo $objResult["iv_no"];?></td>
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subreceive LEFT JOIN tb_product ON hos__subreceive.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 
	echo $objResult1["access_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				<td><div align="left"><?php echo $objResult["customer_name"];?></div></td>
				<td><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
<?php
					if($objResult["report_ckk"]=='0'){	?>
						<td bgcolor="#FF3030"><?php echo 'รอสินค้า';?></td>
				<?php }
					else if ($objResult["report_ckk"]=='1'){ ?>
				<td bgcolor = "#00FF00" ><?php echo 'รับคืนแล้ว';?></td>
				<?php } ?>
					
				<td><div align="left"><?php echo $objResult["stock_print"];?></div></td>
				
				<?php
				if($objResult["stock_complete"]=='1'){	?>
				<td bgcolor="#33FF00"><?php echo 'สมบูรณ์';?></td>
				<?php }
					else if ($objResult["stock_complete"]=='2'){ ?>
				<td bgcolor = "#FF0000" ><?php echo 'ไม่สมบูรณ์';?></td>
				<?php }
					else if ($objResult["stock_complete"]=='3'){ ?>
				<td bgcolor = "#FFFF00" ><?php echo 'รอสินค้า';?></td>
				<?php }	else { ?>
				<td></td>
				<?php } ?>				

<td>
<a href="rister_clearbrpn_stedit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
												
				</td>

			</tr>
			<?php $i++; 
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'>
<font color='black'><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'>
<font color='black'>$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'>
<font color='black'>Next>></font></a> ";
	}
	
	?>
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>