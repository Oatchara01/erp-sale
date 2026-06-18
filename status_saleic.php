<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Status ใบสั่งขาย (IC) ฝากขาย</h4></div>
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter">
ค้นหาเลขที่ IV ,ใบยืม : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
<div class="w3-bar w3-quarter">
ค้นหาชื่อลูกค้า : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>"></div>	
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$Keyword1  = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
if($_SESSION['code']=='MK'){
$sale_code = "SM1";	
}else{
$sale_code = $_SESSION['code'];
}
$user_type = $_SESSION['user_type'];

if($user_type=='Engineer'){
$strSQL = "SELECT *  FROM hos__so  where sale_code LIKE '%EN%' and ic_ckk='1'";
}else{
$strSQL = "SELECT *  FROM hos__so  where sale_code = '".$sale_code."' and ic_ckk='1'";	
}

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}
	 
if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' OR brnp_no  LIKE "%'.$Keyword.'%"'; 	

}
if($Keyword1 !=""){ 
$strSQL .= ' AND bill_name  LIKE "%'.$Keyword1.'%"'; 
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
			<th width="10%">เลขที่เคลียร์ยืม</th> 
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อผู้ออกบิล</th>
			<th width="10%">เลขพัสดุ</th>
			<th width="10%">เขตการขาย</th>
			<th width="10%">สถานะ</th>
			<th width="5%">แก้ไข</th>
			<th width="5%">Print</th>
			<th width="5%">copy doc</th>
			<th width="5%">สร้างใบสั่งลดหนี้</th>
			<?php /*<th width="5%">แบบสอบถามการจัดส่ง</th>*/ ?>

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
 echo DateThai($objResult["date_so"]);
					?></td>
				<td><?php echo $objResult["iv_no"];?></td>
				<td>
					<?php if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}
					?> 
				</td>
				<td><div align="left">
					<?php
						$strSQL91 = "SELECT clear_ivno FROM hos__subso WHERE ref_idd = '".$objResult["ref_id"]."' and clear_ivno !=''";
						$objQuery91 = mysqli_query($conn,$strSQL91) or die ("Error Query [".$strSQL91."]");
						while($objResult91 = mysqli_fetch_array($objQuery91)) { 
	echo $objResult91["clear_ivno"]; ?> 
					
						<?php }  ?>
							</div></td>
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 if($objResult1["bom_ckk"]=='0'){
	echo $objResult1["sol_name"];  echo $objResult1["sale_remark"]; 

	
	?><br />
					
						<?php }  
						}
					
$strSQL2 = "SELECT distinct code_bom  FROM hos__subso  WHERE ref_idd = '".$objResult["ref_id"]."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2)){
		
$code_bom	= $objResult2["code_bom"];	

$strSQL3 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product_bomhos ON hos__subso.code_bom=tb_product_bomhos.bom_code) WHERE ref_idd = '".$objResult["ref_id"]."' and code_bom = '".$code_bom."'";

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);
while($objResult3 = mysqli_fetch_array($objQuery3))
{
if($objResult3["code_bom"]!=""){
	echo $objResult3["bom_name"]; echo $objResult3["sale_remark"];
?> <br>
					<?php
	
 }
}
}
		
					
					
					?>
					
				</div></td>
				<td><div align="left"><?php echo $objResult["pre_name"];?><?php echo $objResult["bill_name"];?></div></td>
	<td><div align="left"><?php echo $objResult["order_refer_code"];?><br><?php echo $objResult["order_refer_code1"];?></div></td>
				<td><div align="left"><?php echo $objResult["sale_code"];?> <?php echo '-';?> <?php echo $objResult["sale"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='Request' and $objResult["send_cm"]=='2'){ ?>
					<td  bgcolor="#FFFF00"><?php echo "รอผู้บริหารอนุมัติ";?></td>
				<?php }else if($objResult["status_doc"]=='Request' and $objResult["send_sup"]=='1'){ ?>
					<td  bgcolor="#FFFF00"><?php echo "รอหัวหน้าอนุมัติ";?></td>
				<?php }else{ ?>
				 <td><?php echo "รอกดส่งหัวหน้า";?></td>
				<?php } ?>
				<td>
				
				<a href="register_salehos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
					
				</td>
				<td>
<a href="report_salehosptl2.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

				</td>

<td>
<?php if($objResult["status_doc"]=='Approve'){ ?>
	<a href=javascript:if(confirm('!!!ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')==true){window.location='register_salehos_createnew.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
<?php } ?>	
</td>

	<td>

	<a href=javascript:if(confirm('!!!ต้องการเพิ่มเอกสารใบสั่งลดหนี้ใช่หรือไม่')==true){window.location='register_credit_saleso.php?ref_id=<?php echo $objResult["ref_id"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
	
</td>
<?php
/*	<td>
 $strSQL9 = "SELECT mk_research FROM tb_register_data WHERE ref_id = '".$objResult["ref_id"]."' ";
						$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
						$objResult9 = mysqli_fetch_array($objQuery9);
 
 if($objResult["close_reseach"]=='0' and $objResult9["mk_research"]=='1'){ ?>
	<a href=javascript:if(confirm('!!!ต้องการทำแบบสอบถามหลังการติดตั้ง')==true){window.location='register_reseachsale.php?running=<?php echo $objResult["job_no"];?>&ref_id=<?php echo $objResult["ref_id"]; ?>';}><img src="img/receipt_product.png" width="23" height="23" border="0" /></a>
	<?php }
</td>
*/ ?>

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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&Keyword1=$Keyword1&start_date=$start_date&end_date=$end_date'>
<font color='black'><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&Keyword1=$Keyword1&start_date=$start_date&end_date=$end_date'>
<font color='black'>$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&Keyword1=$Keyword1&start_date=$start_date&end_date=$end_date'>
<font color='black'>Next>></font></a> ";
	}
	
	?>
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>