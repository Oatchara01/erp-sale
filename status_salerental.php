<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Status ใบสั่งเช่า</h4></div>
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
$strSQL = "SELECT *  FROM hos__rental  where sale_code LIKE '%EN%' ";
}else{
$strSQL = "SELECT *  FROM hos__rental  where sale_code = '".$sale_code."' ";	
}

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND rental_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
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


$strSQL .=" order  by id DESC   LIMIT $Page_Start , $Per_Page";
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
			<th width="22%">ชื่อผู้เช่า</th>
			<th width="10%">เขตการขาย</th>
			<th width="8%">การอนุมัติ</th>
			<th width="10%">สถานะ</th>
			<th width="5%">แก้ไข</th>
			<th width="5%">Print</th>
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
$strSQL12 ="SELECT close_ckk FROM hos__rental_runiv WHERE ref_idren = '".$objResult['ref_id']."' ";
$objQuery12 =mysqli_query($conn,$strSQL12);
$objResult12=mysqli_fetch_array($objQuery12);
	
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				<td><?php echo DateThai($objResult["register_date"]);	?></td>
				<td><?php echo $objResult["iv_no"];?></td>
				<td><?php if ($objResult["iv_date"]=="0000-00-00") { echo "-"; }else{ echo DateThai($objResult["iv_date"]);	} ?> 
				</td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { 
	echo $objResult1["sol_name"];  ?><br> <?php }  ?>
					
				</div></td>
				<td><div align="left"><?php echo $objResult["rental_name"];?></div></td>
				<td><div align="center"><?php echo $objResult["sale_code"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				
				<?php if($objResult12["close_ckk"]=='1'){	?>
						<td bgcolor="#FF3030">ปิดการเช่าสินค้า</td>
				<?php }
					else if ($objResult12["close_ckk"]=='0'){ ?>
				<td bgcolor="#00FF00">อยู่ระหว่างการเช่าสินค้า</td>
				<?php }
					else{ ?>
					<td ></td>
				<?php } ?>
				
				<td><a href="register_salerental_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
<td>
<a href="from_rental.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

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