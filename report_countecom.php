<?php include "head.php"; ?>
<title>SOL :: ITEAMDEV</title>
<meta name="viewport" content="width=device-width, initial-scale=-1" charset="utf8">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/tab.css">
<link rel="stylesheet" href="awesome/css/all.css">
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/w3open.js"></script>
<script type="text/javascript" src="js/tab.js"></script>
<script type="text/javascript" src="js/ready.js"></script>
<script type="text/javascript" src="js/table.js"></script>
<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery-3.4.1.js" type="text/javascript"></script>

<div class="w3-white w3-container">
	
<br><br><br>
<?php include "dbconnect.php"; ?>	
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-quarter">
	ปี :
	<select name="year" id="year" style="width:90%" class="w3-input" >
<option  value="">**Please Select**</option>
<option  value="2021">2564</option>
<option  value="2022">2565</option>
<option  value="2023">2566</option>
<option  value="2024">2567</option>
<option  value="2025">2568</option>
<option  value="2026">2569</option>
<option  value="2027">2570</option>
<option  value="2028">2571</option>
<option  value="2029">2572</option>
<option  value="2030">2573</option>
</select>
	</div>

<div class="w3-quarter">
  ช่องทางการขาย

<select name="sale_channel" id="sale_channel" style="width:90%" class="w3-input" >
<option value="">**Please Select**</option>
<?php
$strSQL9 = "SELECT * FROM tb_salechannel ORDER BY salechannel_ID ASC";
$objQuery9 = mysqli_query($conn,$strSQL9);
while($objResuut9 = mysqli_fetch_array($objQuery9))
{
if($_GET["sale_channel"] == $objResuut9["salechannel_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option value="<?php echo $objResuut9["salechannel_ID"];?>"<?php echo $sel;?>><?php echo $objResuut9["salechannel_nameshort"];?></option>
<?php
}
?>
</select>


</div>
	<div class="w3-quarter">
	หมวดสินค้า

	<select name="group1" id="group1" style="width:90%" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_modepro where adm_ckk ='1' ORDER BY id ASC";

$objQuery5 = mysqli_query($new,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($_GET["group1"] == $objResuut5["mode_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["mode_name"];?>"<?php echo $sel;?>><?php echo $objResuut5["mode_name"];?></option>
<?php
}
?>
</select>
</div>

	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<br>	
<?php
	
if($_GET["year"] !=''){
$yy = $_GET["year"];
}else{
$yy = date('Y');
}

$sale_channel = $_GET["sale_channel"];
$group1 = $_GET["group1"];

if($sale_channel!=''){

$yy1 = $yy-1;
	
$year =$yy+543;
$year1 =$yy1+543;

$month1 ="$yy-01";	
$month2 ="$yy-02";	
$month3 ="$yy-03";	
$month4 ="$yy-04";	
$month5 ="$yy-05";	
$month6 ="$yy-06";	
$month7 ="$yy-07";	
$month8 ="$yy-08";	
$month9 ="$yy-09";	
$month10 ="$yy-10";	
$month11 ="$yy-11";	
$month12 ="$yy-12";	
	
$month_1 ="$yy1-01";	
$month_2 ="$yy1-02";	
$month_3 ="$yy1-03";	
$month_4 ="$yy1-04";	
$month_5 ="$yy1-05";	
$month_6 ="$yy1-06";	
$month_7 ="$yy1-07";	
$month_8 ="$yy1-08";	
$month_9 ="$yy1-09";	
$month_10 ="$yy1-10";	
$month_11 ="$yy1-11";	
$month_12 ="$yy1-12";	
	
	

	
$strSQLsa = "SELECT salechannel_nameshort  FROM tb_salechannel WHERE salechannel_ID ='".$sale_channel."'";
	
$objQuerysa = mysqli_query($conn,$strSQLsa) or die ("Error Query [".$strSQLsa."]");
$objResultsa = mysqli_fetch_array($objQuerysa);

$type_salw = $objResultsa["salechannel_nameshort"];
	
	
?>	
<center>	
<h5><b>
	รายงานจำนวนขาย  ปี <?php echo $year ?>
	<br><?php if($group1!=''){ echo "กลุ่มสินค้า : "; echo $group1;  } ?> ช่องทาง : <?php echo $type_salw; ?>
	</b></h5>
	</center><br>	
	
<?php	

//2564

	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_1%' and sale_chan ='".$sale_channel."'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_1%' and sale_chan ='".$sale_channel."'";
if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_01 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_2%' and sale_chan ='".$sale_channel."'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_2%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_02 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_3%' and sale_chan ='".$sale_channel."'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_3%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_03 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_4%' and sale_chan ='".$sale_channel."'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_4%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_04 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_5%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_5%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_05 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_6%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_6%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_06 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_7%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_7%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_07 = $sumhos_awl-$sumhos_nbm;		
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_8%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_8%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_08 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_9%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_9%' and sale_chan ='".$sale_channel."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_09 = $sumhos_awl-$sumhos_nbm;		
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_10%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_10%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_10 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_11%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_11%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_11 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_12%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month_12%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_12 = $sumhos_awl-$sumhos_nbm;	
	

		
	

	

//2565

	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month1%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month1%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_01 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month2%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month2%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_02 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month3%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month3%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_03 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month4%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month4%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_04 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month5%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month5%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_05 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month6%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month6%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_06 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month7%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month7%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_07 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month8%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month8%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_08 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month9%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month9%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_09 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month10%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month10%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_10 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month11%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month11%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_11 = $sumhos_awl-$sumhos_nbm;	
	

		
	
	
$strSQL = "SELECT SUM(count) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month12%' and sale_chan ='".$sale_channel."'";
	if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(count) As amount  FROM tb__discash WHERE  date_cash LIKE '%$month12%' and sale_chan ='".$sale_channel."'";
if($group1 !=''){
$strSQL1 .= ' AND group_1 = "'.$group1.'"'; 
}
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_12 = $sumhos_awl-$sumhos_nbm;	
	

		
	



	
	
	
	
	?>
<?php
 
$dataPoints1 = array(
	array("label"=> "มกราคม", "y"=> $sum2564_01),
	array("label"=> "กุมภาพันธ์", "y"=> $sum2564_02),
	array("label"=> "มีนาคม", "y"=> $sum2564_03),
	array("label"=> "เมษายน", "y"=> $sum2564_04),
	array("label"=> "พฤษภาคม", "y"=> $sum2564_05),
	array("label"=> "มิถุนายน", "y"=> $sum2564_06),
	array("label"=> "กรกฎาคม", "y"=> $sum2564_07),
	array("label"=> "สิงหาคม", "y"=> $sum2564_08),
	array("label"=> "กันยายน", "y"=> $sum2564_09),
	array("label"=> "ตุลาคม", "y"=> $sum2564_10),
	array("label"=> "พฤศจิกายน", "y"=> $sum2564_11),
	array("label"=> "ธันวาคม", "y"=> $sum2564_12)
);
	
	
$dataPoints2 = array(
	array("label"=> "มกราคม", "y"=> $sum2565_01),
	array("label"=> "กุมภาพันธ์", "y"=> $sum2565_02),
	array("label"=> "มีนาคม", "y"=> $sum2565_03),
	array("label"=> "เมษายน", "y"=> $sum2565_04),
	array("label"=> "พฤษภาคม", "y"=> $sum2565_05),
	array("label"=> "มิถุนายน", "y"=> $sum2565_06),
	array("label"=> "กรกฎาคม", "y"=> $sum2565_07),
	array("label"=> "สิงหาคม", "y"=> $sum2565_08),
	array("label"=> "กันยายน", "y"=> $sum2565_09),
	array("label"=> "ตุลาคม", "y"=> $sum2565_10),
	array("label"=> "พฤศจิกายน", "y"=> $sum2565_11),
	array("label"=> "ธันวาคม", "y"=> $sum2565_12)
);	
 


	
 
 
 
?>
<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: ""
	},
	theme: "light2",
	animationEnabled: true,
	toolTip:{
		shared: true,
		reversed: true
	},
	axisY: {
		title: "จำนวน",
		suffix: " ชิ้น"
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	data: [
		{
			
			type: "stackedColumn",
			name: "จำนวนปี <?php echo $year ?>",
			color : "#0099CC",
			showInLegend: true,
			yValueFormatString: "#,##0 ชิ้น",
			dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK);
			
			 ?>
		},{
			type: "line",
			name: "จำนวนปี <?php echo $year1; ?>",
			showInLegend: true,
			yValueFormatString: "#,##0 ชิ้น",
			dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
		}
	]
});
 
chart.render();
 
function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html> 
<br><br>
<div class="w3-container"><br>
	<h6>จำนวนขาย <?php if($group1!=''){ echo "กลุ่มสินค้า : "; echo $group1;  } ?></h6>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="7%">เดือน</th>
<th width="5%">มกราคม</th>
<th width="5%">กุมภาพันธ์</th>
<th width="5%">มีนาคม</th>
<th width="5%">เมษายน</th>
<th width="5%">พฤษภาคม</th>
<th width="5%">มิถุนาคม</th>
<th width="5%">กรกฎาคม</th>
<th width="5%">สิงหาคม</th>
<th width="5%">กันยายน</th>
<th width="5%">ตุลาคม</th>
<th width="5%">พฤศจิกายน</th>
<th width="5%">ธันวาคม</th>
<th width="5%">ยอดรวม</th>

</thead>

<tr>
<td>จำนวนขาย ปี <?php echo $year1; ?></td>
<td><?php echo number_format($sum2564_01,0).""; ?></td>	
<td><?php echo number_format($sum2564_02,0).""; ?></td>	
<td><?php echo number_format($sum2564_03,0).""; ?></td>	
<td><?php echo number_format($sum2564_04,0).""; ?></td>	
<td><?php echo number_format($sum2564_05,0).""; ?></td>	
<td><?php echo number_format($sum2564_06,0).""; ?></td>	
<td><?php echo number_format($sum2564_07,0).""; ?></td>	
<td><?php echo number_format($sum2564_08,0).""; ?></td>	
<td><?php echo number_format($sum2564_09,0).""; ?></td>	
<td><?php echo number_format($sum2564_10,0).""; ?></td>	
<td><?php echo number_format($sum2564_11,0).""; ?></td>	
<td><?php echo number_format($sum2564_12,0).""; ?></td>	
<td><?php echo number_format($sum2564_01+$sum2564_02+$sum2564_03+$sum2564_04+$sum2564_05+$sum2564_06+$sum2564_07+$sum2564_08+$sum2564_09+$sum2564_10+$sum2564_11+$sum2564_12,0).""; ?></td>	
</tr>	

<tr>
<td>จำนวนขาย ปี <?php echo $year; ?></td>
<td><?php echo number_format($sum2565_01,0).""; ?></td>	
<td><?php echo number_format($sum2565_02,0).""; ?></td>	
<td><?php echo number_format($sum2565_03,0).""; ?></td>	
<td><?php echo number_format($sum2565_04,0).""; ?></td>	
<td><?php echo number_format($sum2565_05,0).""; ?></td>	
<td><?php echo number_format($sum2565_06,0).""; ?></td>	
<td><?php echo number_format($sum2565_07,0).""; ?></td>	
<td><?php echo number_format($sum2565_08,0).""; ?></td>	
<td><?php echo number_format($sum2565_09,0).""; ?></td>	
<td><?php echo number_format($sum2565_10,0).""; ?></td>	
<td><?php echo number_format($sum2565_11,0).""; ?></td>	
<td><?php echo number_format($sum2565_12,0).""; ?></td>	
<td><?php echo number_format($sum2565_01+$sum2565_02+$sum2565_03+$sum2565_04+$sum2565_05+$sum2565_06+$sum2565_07+$sum2565_08+$sum2565_09+$sum2565_10+$sum2565_11+$sum2565_12,0).""; ?></td>	
</tr>		
	
	</table>
	<br><br>

	
<?php	
if($group1=='เครื่องวัดน้ำตาล - Glucosure' or $group1=='เครื่องวัดน้ำตาล - G-426'){

//2564

$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_1%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k01 = $objResult["amount"];
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_2%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k02 = $objResult["amount"];

$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_3%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k03 = $objResult["amount"];

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_4%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k04 = $objResult["amount"];

$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_5%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k05 = $objResult["amount"];
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_6%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k06 = $objResult["amount"];

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_7%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k07 = $objResult["amount"];

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_8%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k08 = $objResult["amount"];
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_9%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k09 = $objResult["amount"];
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_10%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k10 = $objResult["amount"];

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_11%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k11 = $objResult["amount"];

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_12%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2564_k12 = $objResult["amount"];
	
	
//2565

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month1%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k01 = $objResult["amount"];
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month2%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k02 = $objResult["amount"];

$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month3%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k03 = $objResult["amount"];

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month4%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k04 = $objResult["amount"];

$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month5%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k05 = $objResult["amount"];
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month6%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k06 = $objResult["amount"];

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month7%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k07 = $objResult["amount"];

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month8%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k08 = $objResult["amount"];
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month9%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k09 = $objResult["amount"];
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month10%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k10 = $objResult["amount"];

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month11%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k11 = $objResult["amount"];

	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month12%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%เครื่อง%' and unit_name ='เครื่อง'";
	
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
$sum2565_k12 = $objResult["amount"];
	
	
	
	
	
	?>
<h6>จำนวนขาย <?php if($group1!=''){ echo "เครื่องวัดน้ำตาล"; } ?></h6>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="7%">เดือน</th>
<th width="5%">มกราคม</th>
<th width="5%">กุมภาพันธ์</th>
<th width="5%">มีนาคม</th>
<th width="5%">เมษายน</th>
<th width="5%">พฤษภาคม</th>
<th width="5%">มิถุนาคม</th>
<th width="5%">กรกฎาคม</th>
<th width="5%">สิงหาคม</th>
<th width="5%">กันยายน</th>
<th width="5%">ตุลาคม</th>
<th width="5%">พฤศจิกายน</th>
<th width="5%">ธันวาคม</th>
<th width="5%">ยอดรวม</th>

</thead>

<tr>
<td>จำนวนขาย ปี <?php echo $year1; ?></td>
<td><?php echo number_format($sum2564_k01,0).""; ?></td>	
<td><?php echo number_format($sum2564_k02,0).""; ?></td>	
<td><?php echo number_format($sum2564_k03,0).""; ?></td>	
<td><?php echo number_format($sum2564_k04,0).""; ?></td>	
<td><?php echo number_format($sum2564_k05,0).""; ?></td>	
<td><?php echo number_format($sum2564_k06,0).""; ?></td>	
<td><?php echo number_format($sum2564_k07,0).""; ?></td>	
<td><?php echo number_format($sum2564_k08,0).""; ?></td>	
<td><?php echo number_format($sum2564_k09,0).""; ?></td>	
<td><?php echo number_format($sum2564_k10,0).""; ?></td>	
<td><?php echo number_format($sum2564_k11,0).""; ?></td>	
<td><?php echo number_format($sum2564_k12,0).""; ?></td>	
<td><?php echo number_format($sum2564_k01+$sum2564_k02+$sum2564_k03+$sum2564_k04+$sum2564_k05+$sum2564_k06+$sum2564_k07+$sum2564_k08+$sum2564_k09+$sum2564_k10+$sum2564_k11+$sum2564_k12,0).""; ?></td>	
</tr>	

<tr>
<td>จำนวนขาย ปี <?php echo $year; ?></td>
<td><?php echo number_format($sum2565_k01,0).""; ?></td>	
<td><?php echo number_format($sum2565_k02,0).""; ?></td>	
<td><?php echo number_format($sum2565_k03,0).""; ?></td>	
<td><?php echo number_format($sum2565_k04,0).""; ?></td>	
<td><?php echo number_format($sum2565_k05,0).""; ?></td>	
<td><?php echo number_format($sum2565_k06,0).""; ?></td>	
<td><?php echo number_format($sum2565_k07,0).""; ?></td>	
<td><?php echo number_format($sum2565_k08,0).""; ?></td>	
<td><?php echo number_format($sum2565_k09,0).""; ?></td>	
<td><?php echo number_format($sum2565_k10,0).""; ?></td>	
<td><?php echo number_format($sum2565_k11,0).""; ?></td>	
<td><?php echo number_format($sum2565_k12,0).""; ?></td>	
<td><?php echo number_format($sum2565_k01+$sum2565_k02+$sum2565_k03+$sum2565_k04+$sum2565_k05+$sum2565_k06+$sum2565_k07+$sum2565_k08+$sum2565_k09+$sum2565_k10+$sum2565_k11+$sum2565_k12,0).""; ?></td>	
</tr>		
	
	</table>
	<br><br>
	
<?php
	
//2564

$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_1%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_1%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp1 = ($objResult["amount"]*2);
$sum2564_pb1 = $objResult1["amount"];
$sum2564_p01	= $sum2564_pp1+$sum2564_pb1;
	

$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_2%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_2%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp2 = ($objResult["amount"]*2);
$sum2564_pb2 = $objResult1["amount"];
$sum2564_p02	= $sum2564_pp2+$sum2564_pb2;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_3%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_3%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp3 = ($objResult["amount"]*2);
$sum2564_pb3 = $objResult1["amount"];
$sum2564_p03	= $sum2564_pp3+$sum2564_pb3;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_4%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_4%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp4 = ($objResult["amount"]*2);
$sum2564_pb4 = $objResult1["amount"];
$sum2564_p04	= $sum2564_pp4+$sum2564_pb4;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_5%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_5%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp5 = ($objResult["amount"]*2);
$sum2564_pb5 = $objResult1["amount"];
$sum2564_p05	= $sum2564_pp5+$sum2564_pb5;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_6%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_6%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp6 = ($objResult["amount"]*2);
$sum2564_pb6 = $objResult1["amount"];
$sum2564_p06	= $sum2564_pp6+$sum2564_pb6;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_7%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_7%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp7 = ($objResult["amount"]*2);
$sum2564_pb7 = $objResult1["amount"];
$sum2564_p07	= $sum2564_pp7+$sum2564_pb7;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_8%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_8%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp8 = ($objResult["amount"]*2);
$sum2564_pb8 = $objResult1["amount"];
$sum2564_p08 = $sum2564_pp8+$sum2564_pb8;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_9%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_9%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp9 = ($objResult["amount"]*2);
$sum2564_pb9 = $objResult1["amount"];
$sum2564_p09	= $sum2564_pp9+$sum2564_pb9;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_10%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_10%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp10 = ($objResult["amount"]*2);
$sum2564_pb10 = $objResult1["amount"];
$sum2564_p010	= $sum2564_pp10+$sum2564_pb10;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_11%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_11%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp11 = ($objResult["amount"]*2);
$sum2564_pb11 = $objResult1["amount"];
$sum2564_p11	= $sum2564_pp11+$sum2564_pb11;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_12%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month_12%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2564_pp12 = ($objResult["amount"]*2);
$sum2564_pb12 = $objResult1["amount"];
$sum2564_p12 = $sum2564_pp12+$sum2564_pb12;
	
				
//2565


$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month1%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month1%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp1 = ($objResult["amount"]*2);
$sum2565_pb1 = $objResult1["amount"];
$sum2565_p01	= $sum2565_pp1+$sum2565_pb1;
	

$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month2%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month2%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp2 = ($objResult["amount"]*2);
$sum2565_pb2 = $objResult1["amount"];
$sum2565_p02	= $sum2565_pp2+$sum2565_pb2;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month3%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month3%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp3 = ($objResult["amount"]*2);
$sum2565_pb3 = $objResult1["amount"];
$sum2565_p03	= $sum2565_pp3+$sum2565_pb3;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month4%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month4%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp4 = ($objResult["amount"]*2);
$sum2565_pb4 = $objResult1["amount"];
$sum2565_p04	= $sum2565_pp4+$sum2565_pb4;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month5%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month5%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp5 = ($objResult["amount"]*2);
$sum2565_pb5 = $objResult1["amount"];
$sum2565_p05	= $sum2565_pp5+$sum2565_pb5;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month6%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month6%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp6 = ($objResult["amount"]*2);
$sum2565_pb6 = $objResult1["amount"];
$sum2565_p06	= $sum2565_pp6+$sum2565_pb6;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month7%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month7%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp7 = ($objResult["amount"]*2);
$sum2565_pb7 = $objResult1["amount"];
$sum2565_p07	= $sum2565_pp7+$sum2565_pb7;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month8%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month8%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp8 = ($objResult["amount"]*2);
$sum2565_pb8 = $objResult1["amount"];
$sum2565_p08 = $sum2565_pp8+$sum2565_pb8;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month9%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month9%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp9 = ($objResult["amount"]*2);
$sum2565_pb9 = $objResult1["amount"];
$sum2565_p09	= $sum2565_pp9+$sum2565_pb9;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month10%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month10%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp10 = ($objResult["amount"]*2);
$sum2565_pb10 = $objResult1["amount"];
$sum2565_p010	= $sum2565_pp10+$sum2565_pb10;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month11%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month11%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp11 = ($objResult["amount"]*2);
$sum2565_pb11 = $objResult1["amount"];
$sum2565_p11	= $sum2565_pp11+$sum2565_pb11;
	
	
$strSQL = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month12%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%50%'";
if($group1 !=''){
$strSQL .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT SUM(count) As amount  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE  doc_date LIKE '%$month12%' and sale_chan ='".$sale_channel."' and sol_name LIKE '%แผ่น%' and unit_name !='เครื่อง' and access_code LIKE '%25%'";
if($group1 !=''){
$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$sum2565_pp12 = ($objResult["amount"]*2);
$sum2565_pb12 = $objResult1["amount"];
$sum2565_p12 = $sum2565_pp12+$sum2565_pb12;
	
					
	?>
	
	
<h6>จำนวนขาย <?php if($group1!=''){ echo "แผ่นตรวจน้ำตาล"; } ?></h6>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="7%">เดือน</th>
<th width="5%">มกราคม</th>
<th width="5%">กุมภาพันธ์</th>
<th width="5%">มีนาคม</th>
<th width="5%">เมษายน</th>
<th width="5%">พฤษภาคม</th>
<th width="5%">มิถุนาคม</th>
<th width="5%">กรกฎาคม</th>
<th width="5%">สิงหาคม</th>
<th width="5%">กันยายน</th>
<th width="5%">ตุลาคม</th>
<th width="5%">พฤศจิกายน</th>
<th width="5%">ธันวาคม</th>
<th width="5%">ยอดรวม</th>

</thead>

<tr>
<td>จำนวนขาย ปี <?php echo $year1; ?></td>
<td><?php echo number_format($sum2564_p01,0).""; ?></td>	
<td><?php echo number_format($sum2564_p02,0).""; ?></td>	
<td><?php echo number_format($sum2564_p03,0).""; ?></td>	
<td><?php echo number_format($sum2564_p04,0).""; ?></td>	
<td><?php echo number_format($sum2564_p05,0).""; ?></td>	
<td><?php echo number_format($sum2564_p06,0).""; ?></td>	
<td><?php echo number_format($sum2564_p07,0).""; ?></td>	
<td><?php echo number_format($sum2564_p08,0).""; ?></td>	
<td><?php echo number_format($sum2564_p09,0).""; ?></td>	
<td><?php echo number_format($sum2564_p10,0).""; ?></td>	
<td><?php echo number_format($sum2564_p11,0).""; ?></td>	
<td><?php echo number_format($sum2564_p12,0).""; ?></td>	
<td><?php echo number_format($sum2564_p01+$sum2564_p02+$sum2564_p03+$sum2564_p04+$sum2564_p05+$sum2564_p06+$sum2564_p07+$sum2564_p08+$sum2564_p09+$sum2564_p10+$sum2564_p11+$sum2564_p12,0).""; ?></td>	
</tr>	

<tr>
<td>จำนวนขาย ปี <?php echo $year; ?></td>
<td><?php echo number_format($sum2565_p01,0).""; ?></td>	
<td><?php echo number_format($sum2565_p02,0).""; ?></td>	
<td><?php echo number_format($sum2565_p03,0).""; ?></td>	
<td><?php echo number_format($sum2565_p04,0).""; ?></td>	
<td><?php echo number_format($sum2565_p05,0).""; ?></td>	
<td><?php echo number_format($sum2565_p06,0).""; ?></td>	
<td><?php echo number_format($sum2565_p07,0).""; ?></td>	
<td><?php echo number_format($sum2565_p08,0).""; ?></td>	
<td><?php echo number_format($sum2565_p09,0).""; ?></td>	
<td><?php echo number_format($sum2565_p10,0).""; ?></td>	
<td><?php echo number_format($sum2565_p11,0).""; ?></td>	
<td><?php echo number_format($sum2565_p12,0).""; ?></td>	
<td><?php echo number_format($sum2565_p01+$sum2565_p02+$sum2565_p03+$sum2565_p04+$sum2565_p05+$sum2565_p06+$sum2565_p07+$sum2565_p08+$sum2565_p09+$sum2565_p10+$sum2565_p11+$sum2565_p12,0).""; ?></td>	
</tr>		
	
	</table>
	<br><br>
		
	
	
<?php } ?>	
	
</div>

<?php } ?>

