<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";
include "dbconnect_cs.php";
?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>รายการทำแบบสอบถาม</h3></div>	

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
<?php } ?>


</div>

<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div></div></p>
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
			<!--td width="10%">วันที่ลงทะเบียน</td -->
			<td width="10%">วันที่ส่งของ</td >
			<td width="10%">เลขที่เอกสาร</td > 
			<td width="30%">รายการสินค้า</td >
			<td width="25%">ชื่อผู้ออกบิล</td >
			<td width="10%">เขตการขาย</td >
			<td width="10%">สถานะ</td >
			<th width="5%">แบบสอบถาม</th>

	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');
		

$emid = $_SESSION['code'];
	
if($emid=='SS1'){
$sddd = " AND sale_code IN ('S15','S16','S21','S22','S14')";
	
}else if($emid=='SS2'){
$sddd = " AND sale_code IN ('S11','S12','S17','S24','S13')";	
}else if($emid=='SS3'){
$sddd = " AND sale_code IN ('SM1','S33')";	
}else if($emid=='SUP_EN'){
$sddd = " and  sale_code LIKE '%EN%'";		
}else{
$sddd = "";			
}
//AND DATEDIFF(CURDATE(), iv_date) >= 60
$strSQL = "SELECT ref_id,iv_no,iv_date,bill_name,sale_code,status_doc,job_no,delivery_date,date_send_key  FROM hos__so  where  status_doc ='Approve' and close_reseach ='0' and reseach_kk='1' and status_doc = 'Approve' and iv_date !='0000-00-00'   $sddd";

if($start_date !=""){ 
    $strSQL .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_so <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND bill_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or po_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or status_doc  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 

}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



$strSQL .=" order  by iv_no DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);
?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
if($objResult["sale_code"]=='SM1' ){
	
}else{
	
?>

		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>
				
<td >
					<?php if ($objResult["delivery_date"]=="0000-00-00") {
						echo $objResult["date_send_key"];
					} 
					else 
					{ echo DateThai($objResult["delivery_date"]);
					}
					?> 
	<?php /*if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}*/
					?> 
				</td>
				<!--td ><?php echo DateThai($objResult["date_so"]);	?></td-->
				<td ><?php echo $objResult["iv_no"];?></td>
				
				<td><div align="left">
					<?php
						$strSQL9 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
						$Num_Rows9 = mysqli_num_rows($objQuery9);

						while($objResult9 = mysqli_fetch_array($objQuery9)) { ?>
							<?php
 if($objResult9["bom_ckk"]=='0'){
	echo $objResult9["sol_name"]; 

	
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
	echo $objResult3["bom_name"]; 
?> </br>
					<?php
	
 }
}
}
?>
					
				</div></td>
				<td ><div align="left"><?php echo $objResult["bill_name"];?></div></td>
				<td ><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				
					<td>

<?php 
if ($objResult["iv_date"] >= '2026-03-01') { ?>
    <a href="javascript:if(confirm('!!!ต้องการทำแบบสอบถามหลังการติดตั้ง')==true){window.location='research_010369.php?ref_id=<?php echo $objResult["ref_id"]; ?>';}">
        <img src="img/receipt_product.png" width="23" height="23" border="0" />
    </a>

<?php } elseif ($objResult["iv_date"] <= '2022-03-31') { ?>
    <a href="javascript:if(confirm('!!!ต้องการทำแบบสอบถามหลังการติดตั้ง')==true){window.location='register_reseachsale.php?running=<?php echo $objResult["job_no"];?>&ref_id=<?php echo $objResult["ref_id"]; ?>';}">
        <img src="img/receipt_product.png" width="23" height="23" border="0" />
    </a>

<?php } elseif ($objResult["iv_date"] >= '2025-10-01') { ?>
    <a href="javascript:if(confirm('!!!ต้องการทำแบบสอบถามหลังการติดตั้ง')==true){window.location='register_reseachsalenws.php?running=<?php echo $objResult["job_no"];?>&ref_id=<?php echo $objResult["ref_id"]; ?>';}">
        <img src="img/receipt_product.png" width="23" height="23" border="0" />
    </a>

<?php } else { ?>
    <a href="javascript:if(confirm('!!!ต้องการทำแบบสอบถามหลังการติดตั้ง')==true){window.location='register_reseachsalenew.php?running=<?php echo $objResult["job_no"];?>&ref_id=<?php echo $objResult["ref_id"]; ?>';}">
        <img src="img/receipt_product.png" width="23" height="23" border="0" />
    </a>
<?php } ?>
		
	
</td>


			</tr>
			<?php $i++; 
				
}
}
//}		
?>
		
	</table>
	

<br></div></div><div id="cr_bar"> <?php include "foot.php"; ?></div>		

		

</body>
</html>