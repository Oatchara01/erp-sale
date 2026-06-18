<?php include('head.php'); 

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">

<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Status Sale Order (ใบฝาก)</h4></div>

<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>



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
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
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
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
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
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
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
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
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
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
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
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
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
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
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
			<td width="5%">เลขที่อ้างอิง</td>
			<td width="10%">วันที่ลงทะเบียน</td>
			<td width="8%">เลขที่เอกสาร</td> 
			<td width="8%">เลขที่ใบสั่งซื้อ</td>
			<td width="8%">เลขที่ใบฝาก</td>
			<td width="10%">วันที่ออกเอกสาร</td>
			<td width="10%">กำหนดส่งตามสัญญา</td>
			<td width="30%">รายการสินค้า</td>
			<td width="25%">ชื่อผู้ออกบิล</td>
			<td width="10%">เขตการขาย</td>
			<td width="10%">สถานะ</td>
			<td width="5%">แก้ไขรายละเอียด</td>
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
$sddd = " AND sale_code IN ('S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
}else if($emid=='SS5'){
$sddd = " AND sale_code IN ('S31','S32')";	
}else if($emid=='SUP_EN'){
$sddd = " and sale_code LIKE '%EN%'";	
}else if($emid=='SUP_MK'){
$sddd = " and  sale_code  IN ('MK','SOL91','SOL93','SOL93','SOL94','SOL99')";			
}else{
$sddd = "";			
}
			


/*$strSQL1 = "SELECT * FROM tb_user_team WHERE em_id = '".$emid."' ";

$objQuery1 = mysqli_query($com,$strSQL1) or die(mysqli_error());
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$zone=$objResult1["sale_code"];*/


$strSQL = "SELECT *  FROM hos__so  where  status_doc ='Approve'  and have_order ='1' and have_product ='0' $sddd";

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

$strSQL .=" order  by id DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>
				

				<td ><?php
 echo DateThai($objResult["date_so"]);
					?></td>
				<td ><?php echo $objResult["iv_no"];?></td>
				<td ><?php echo $objResult["po_no"];?></td>
				<td ><?php echo $objResult["order_no"];?></td>
				<td >
					<?php if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}
					?> 
				</td>
				<td ><?php echo $objResult["delivery_contract"];?></td>
				<td><div align="left">
					<?php
						$strSQL2 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
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
			<a href="register_suphosfak_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>					
</td>

			</tr>
			<?php $i++; 
				}
//}
?>
		
	</table>
	
	

 
    <br><br>  <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
 		

</body>
</html>