<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class=" w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>รายการใบจองสินค้า</h3></div>
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value = "<?php  echo $_GET["start_date"]; ?>"></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value = "<?php  echo $_GET["end_date"]; ?>"></div>



<div class="w3-bar w3-quarter">


Sale : 
<?php 
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
	<?php
}else 	if ($_SESSION['code']=='SUP_MK'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_allwell ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<?php
}else 	if ($_SESSION['code']=='SS2'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<?php
}else 	if ($_SESSION['code']=='SS3'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
	
<?php
}else 	if ($_SESSION['code']=='SS5'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 where sale_code IN ('S31','S32') ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>	

		<?php
}else 	if ($_SESSION['code']=='SUP_EN'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


		<?php
}else 	{
			?>
				<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


				<?php
}
			
?>


</div>

<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div></div></p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
<br>
</form>


<?php
	
		$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
		$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';


	
	

?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="5%">เลขที่เอกสาร</th>
			<th width="10%">วันที่ลงทะเบียน</th>
			<th width="10%">วันที่ต้องการสินค้า</th>
			<th width="23%">รายการสินค้า</th>
			<th width="22%">ชื่อลูกค้า</th>
			<th width="10%">หมายเหตุ</th>
			<th width="10%">เขตการขาย</th>
			<th width="10%">สถานะ</th>
			<th width="5%">แก้ไข</th>
			<?php /*<th width="5%">Copy Page</th>*/ ?>
			<th width="5%">Print</th>

	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$emid = $_SESSION['code'];
	
if($emid=='SS1'){
$sddd = " AND sale_code IN ('S15','S16','S21','S22','S14')";
	
}else if($emid=='SS2'){
$sddd = " AND sale_code IN ('S11','S12','S17','S24','S13')";	
}else if($emid=='SS3'){
$sddd = " AND sale_code IN ('S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
}else if($emid=='SS5'){
$sddd = " AND sale_code IN ('S31','S32')";	
}else if($emid=='SUP_MK'){
$sddd = " and sale_code IN ('SOL91','SOL92','SOL93','SOL94','MK') ";
}else if($emid=='SM1'){
$sddd = " AND sale_code IN ('S31','S32','S33','MM1','MM2','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";	
}else if($emid=='SUP_EN'){
$sddd = " and sale_code LIKE '%EN%'";		
}else{
$sddd = "";			
}
	


$strSQL = "SELECT *  FROM hos__jongproduct  where send_sup = '1' $sddd";

if($start_date !=""){ 
    $strSQL .= ' AND date_jong >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_jong <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND customer  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' OR iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' OR ref_id  LIKE "%'.$Keyword.'%"'; 

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


$strSQL .=" order  by id_jong DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				<td><?php echo $objResult["iv_no"];?></td>
				
<td><?php
 echo DateThai($objResult["date_jong"]);
					?></td>
				
				<td><?php
 echo Datethai($objResult["date_receive"]);
					?></td>
				
				
				<td><div align="left">
					<?php
						$strSQL2 = "SELECT * FROM (hos__subjongpro LEFT JOIN tb_product ON hos__subjongpro.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'  ";
						//echo $strSQL1;
						//exit();
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						$Num_Rows2 = mysqli_num_rows($objQuery2);

						while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
							<?php
 
	echo $objResult2["sol_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				<td><div align="left"><?php echo $objResult["customer"];?></div></td>
				<td><div align="left"><?php echo $objResult["drescription"];?></div></td>
				<td><div align="left"><?php echo $objResult["sale_code"];?> <?php echo '-';?> <?php echo $objResult["sale_name"];?></div></td>
				
			<?php	 if($objResult["cancel_ckk"]=='1'){	?>
						<td bgcolor="#FF3030"><?php echo 'ยกเลิกใบจองแล้ว';?></td>
				<?php }
					else  if($objResult["close_jong"]=='1'){	?>
						<td bgcolor="#FF3030"><?php echo 'ปิดใบจองแล้ว';?></td>
				<?php }
					else if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				<td>
				

				<a href="register_supbook_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				
								
				</td>
					<?php /*<td>
						<a href=javascript:if(confirm('!!!ต้องการเพิ่มเอกสารใบเบิกสินค้าใช่หรือไม่')==true){window.location='register_salesmp_createnew.php?ref_idsmp=<?php echo $objResult["ref_idsmp"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
						
				
					</td>*/ ?>
				<td>

<a href="report_jongpro.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				
				</td>


			</tr>
			<?php 
			$i++; 
		}		

?>
		
	</table>
	

 <div class="w3-panel" >    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><font color='black'><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><font color='black'>$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><font color='black'>Next>></font></a> ";
	}

	
	?>
      <br>

	</div>	
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>