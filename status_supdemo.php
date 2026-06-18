<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey">
		<div class="w3-half">
		<h3>แบบสอบถามสินค้าสาธิต</h3>
</div>
<div class="w3-half">	
<a href="report_memoresear_sup.php" target="_blank" class="w3-button w3-yellow w3-right"><font color="red">เปอร์เซ็นต์การทำแบบสอบถาม</font></a>	
</div>	
		</div>

<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter">
เลขที่เอกสาร : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php	
	
	 function DateDiff($strDate1,$strDate2)
{
return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}
function TimeDiff($strTime1,$strTime2)
{
return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
function DateTimeDiff($strDateTime1,$strDateTime2)
{
return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
		
	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$sale_code = $_SESSION['code'];
$user_type = $_SESSION['user_type'];
$emid = $_SESSION['code'];
	
if($emid=='SS1'){
$sddd = " AND sale_code IN ('S15','S16','S21','S22','S14')";
	
}else if($emid=='SS2'){
$sddd = " AND sale_code IN ('S11','S12','S17','S24')";	
}else if($emid=='SS3'){
$sddd = " AND sale_code IN ('MM1','SM1','S33','S32','S31')";	
}else if($emid=='SUP_EN'){
$sddd = " and  sale_code LIKE '%EN%'";		
}else{
$sddd = "";			
}


$strSQL = "SELECT *  FROM hos__br  where  research_demo ='1' and status_doc ='Approve' $sddd";	

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}


if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND iv_no  LIKE "%'.$Keyword.'%"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by id DESC";
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
			<th width="10%">เขตการขาย</th>
			<th width="10%">สถานะ</th>
			<th width="5%">ทำแบบสอบถาม</th>
			
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$add_date = date('Y-m-d');	
$delivery_date = $objResult["delivery_date"];

$date_late = DateDiff($delivery_date,$add_date);

if($date_late >='14'){

$save1="Update  hos__br set research_demo ='2'  where ref_id_br = '".$objResult["ref_id_br"]."' ";
$qsave1=mysqli_query($conn,$save1);	
	
}
	
?>
		<tbody>


<tr>
<td><?php echo $objResult["ref_id_br"];?></td>
<td><?php echo DateThai($objResult["date_br"]);	?></td>
<td><?php echo $objResult["iv_no"];?></td>
<td><?php if ($objResult["iv_date"]=="0000-00-00") { echo "-"; 	} else	{ echo DateThai($objResult["iv_date"]);	}	?> </td>
<td><div align="left">
<?php
$strSQL1 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$objResult["ref_id_br"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
<?php	echo $objResult1["sol_name"]; ?> <?php	echo $objResult1["sale_remark"]; ?>
<br><?php } ?></div></td>
				<td><div align="left"><?php echo $objResult["customer"];?></div></td>
				<td><div align="left"><?php echo $objResult["sale_code"]; ?> <?php echo '-';?> <?php echo $objResult["sale"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				<td>
				
				<a href="reserch_demo.php?ref_id_br=<?php echo $objResult["ref_id_br"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a>
												
				</td>
				


			</tr>


			<?php $i++; } ?>
		</tbody>
	</table>


      </p>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		


</body>
</html>