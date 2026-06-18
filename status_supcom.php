<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>Status หมายเหตุแจ้งฝ่ายต่าง ๆ </h3></div>
	
<div class="w3-bar w3-quarter">

วันที่ IV : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter">


Sale : 
<?php 
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:90%" class="w3-input" >
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
}else 	if ($_SESSION['code']=='SS3'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 where ckk_1='0' ORDER BY sale_code ASC";
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
}else 	if ($_SESSION['code']=='MK2'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_sm1 ORDER BY sale_code ASC";

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
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	</div>
	</p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
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
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="8%">วันที่ส่งสินค้า</td >
			<td width="8%">เลขที่ IV</td >
			<td width="8%">วันที่ออก IV</td >
			<td width="10%">รายการสินค้า</td >
			<td width="10%">ชื่อลูกค้า</td >
			<td width="10%">เขตการขาย</td >
			<td width="10%">หมายเหตุ Admin</td >
			<td width="10%">หมายเหตุ CS</td >
			<td width="10%">หมายเหตุ ช่าง</td >
			<td width="10%">หมายเหตุ stock</td >
			
			
	</thead>
	

<?php	
	
date_default_timezone_set("Asia/Bangkok");

$emid = $_SESSION['code'];
	
if($emid=='SS1'){
$sddd = " sale_code IN ('S15','S16','S21','S22','S14')";
}else if($emid=='SS2'){
$sddd = " sale_code IN ('S11','S12','S17','S24','S13')";	
}else if($emid=='SS3'){
$sddd = " sale_code IN ('S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
}else if($emid=='SS5'){
$sddd = " sale_code IN ('S31','S32')";	
}else if($emid=='SUP_EN'){
$sddd = " sale_code LIKE '%EN%'";	
}else if($emid=='SUP_MK'){
$sddd = " sale_code  IN ('MK','SOL91','SOL92','SOL93','SOL94','SOL99')";			
}else{
$sddd = "1";			
}
	

$strSQL = "SELECT * FROM  (tb_comment_so LEFT JOIN   hos__so ON   tb_comment_so.ref_id = hos__so.ref_id) WHERE $sddd";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND bill_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or  iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id.hos__so  LIKE "%'.$Keyword.'%"'; 
	
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


$strSQL .=" order  by hos__so.delivery_date DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
			<tr>
				
				
				<td><?php echo $objResult["ref_id"];?></td>
				<td ><?php echo DateThai($objResult["delivery_date"]);?></td>
				<td  ><?php echo $objResult["iv_no"];?></td>
				<td  ><?php if($objResult["iv_date"]!='0000-00-00'){ echo DateThai($objResult["iv_date"]); } ?></td>
				
				<td><div align="left">
					<?php
			$strSQL2 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
			$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
			$Num_Rows2 = mysqli_num_rows($objQuery2);
			while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
			<?php	echo $objResult2["sol_name"];	?><br />
			<?php } ?>
				</div></td>
						
				
				<td ><div align="left"><?php echo $objResult["bill_name"];?></div></td>
					<td><?php echo $objResult["sale_code"];?></td>		
				<td ><div align="left"><font color='red'><?php echo $objResult["comment_ad"];?></font>
					<?php if($objResult["complete_adckk"]=='2'){ ?>
					<br><font color='green'><img src="img/success.gif" width="23" height="23" border="0" />ดำเนินการเรียบร้อยแล้ว</font><br>
					รายละเอียด : <?php echo $objResult["cls_desad"];?><br>
					ผู้ปิดงาน : <?php echo $objResult["name_ad"];?><br>
					วันที่ปิดงาน : <?php echo Datethai($objResult["date_ad"]);?>
					<?php } ?>					
					</div></td>
				<td ><div align="left"><font color='red'><?php echo $objResult["comment_cs"];?></font>
					<?php if($objResult["complete_csckk"]=='2'){ ?>
					<br><font color='green'><img src="img/success.gif" width="23" height="23" border="0" />ดำเนินการเรียบร้อยแล้ว</font><br>
					รายละเอียด : <?php echo $objResult["cls_descs"];?><br>
					ผู้ปิดงาน : <?php echo $objResult["name_cs"];?><br>
					วันที่ปิดงาน : <?php echo Datethai($objResult["date_cs"]);?>
					<?php } ?>
					
					
					</div></td>
				<td ><div align="left"><font color='red'><?php echo $objResult["comment_en"];?></font>
					<?php if($objResult["complete_enckk"]=='2'){ ?>
					<br><font color='green'><img src="img/success.gif" width="23" height="23" border="0" />ดำเนินการเรียบร้อยแล้ว</font><br>
					รายละเอียด : <?php echo $objResult["cls_desen"];?><br>
					ผู้ปิดงาน : <?php echo $objResult["name_en"];?><br>
					วันที่ปิดงาน : <?php echo Datethai($objResult["date_en"]);?>
					<?php } ?>
					
					</div></td>
				<td ><div align="left"><font color='red'><?php echo $objResult["comment_st"];?></font>
					<?php if($objResult["complete_stckk"]=='2'){ ?>
					<br><font color='green'><img src="img/success.gif" width="23" height="23" border="0" />ดำเนินการเรียบร้อยแล้ว</font><br>
					รายละเอียด : <?php echo $objResult["cls_desst"];?><br>
					ผู้ปิดงาน : <?php echo $objResult["name_st"];?><br>
					วันที่ปิดงาน : <?php echo Datethai($objResult["date_st"]);?>
					<?php } ?>
					
					</div></td>
					
			</tr>
		
			<?php $i++; 
				}

?>
		
	</table>
	

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><span class='style40'>Next>></span></a> ";
	}

	
	?>
      </p>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>
</body>
</html>