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
	<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-gray"><h4>รายงานเปิดออเดอร์ E-Commerce</h4></div>
<?php include "dbconnect.php"; ?>	
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-quarter">
		เดือน :
	<select name="mount" id="mount" style="width:90%" class="w3-input" >
<option  value="">**Please Select**</option>
<option  value="01">มกราคม</option>
<option  value="02">กุมภาพันธ์</option>
<option  value="03">มีนาคม</option>
<option  value="04">เมษายน</option>
<option  value="05">พฤษภาคม</option>
<option  value="06">มิถุนายน</option>
<option  value="07">กรกฎาคม</option>
<option  value="08">สิงหาคม</option>
<option  value="09">กันยายน</option>
<option  value="10">ตุลาคม</option>
<option  value="11">พฤศจิกายน</option>
<option  value="12">ธันวาคม</option>
</select>
</div>
<div class="w3-quarter">
	ปี :
<select name="year" id="year" style="width:90%" class="w3-input" >
<option  value="">**Please Select**</option>
<option  value="2027">2570</option>
<option  value="2026">2569</option>
<option  value="2025">2568</option>
<option  value="2024">2567</option>
<option  value="2023">2566</option>
<option  value="2022">2565</option>
<option  value="2021">2564</option>

<!--option  value="2028">2571</option>
<option  value="2029">2572</option>
<option  value="2030">2573</option-->
</select>
	</div>



	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<br>	
<?php
if($_GET["mount"] !='' and $_GET["year"] !=''){
$mm = $_GET["mount"];
$yy = $_GET["year"];
}else{
$mm = date('m');
$yy = date('Y');
}	
$to_day = date('Y-m-d');
	
	
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;
$start_date = "$yy-$mm";
	
	
	$day_1 = "$yy-$mm-01";
	$day_2 = "$yy-$mm-02";
	$day_3 = "$yy-$mm-03";
	$day_4 = "$yy-$mm-04";
	$day_5 = "$yy-$mm-05";
	$day_6 = "$yy-$mm-06";
	$day_7 = "$yy-$mm-07";
	$day_8 = "$yy-$mm-08";
	$day_9 = "$yy-$mm-09";
	$day_10 = "$yy-$mm-10";
	$day_11 = "$yy-$mm-11";
	$day_12 = "$yy-$mm-12";
	$day_13 = "$yy-$mm-13";
	$day_14 = "$yy-$mm-14";
	$day_15 = "$yy-$mm-15";
	$day_16 = "$yy-$mm-16";
	$day_17 = "$yy-$mm-17";
	$day_18 = "$yy-$mm-18";
	$day_19 = "$yy-$mm-19";
	$day_20 = "$yy-$mm-20";
	$day_21 = "$yy-$mm-21";
	$day_22 = "$yy-$mm-22";
	$day_23 = "$yy-$mm-23";
	$day_24 = "$yy-$mm-24";
	$day_25 = "$yy-$mm-25";
	$day_26 = "$yy-$mm-26";
	$day_27 = "$yy-$mm-27";
	$day_28 = "$yy-$mm-28";
	$day_29 = "$yy-$mm-29";
	$day_30 = "$yy-$mm-30";
	$day_31 = "$yy-$mm-31";	
	
	

	?>
	<h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3>
<table border= "1" width="100%" class='w3-table'>
<thead class='w3-grey' >	
<tr>
<th width="10%" align="center" class="style30">ช่องทางการขาย</th>
<th width="3%" align="center" class="style30">สูตร GP+VAT</th>
<th width="3%" align="center" class="style30">ยอดรวม</th>
<th width="3%" align="center" class="style30">1</th>
<th width="3%" align="center" class="style30">2</th>
<th width="3%" align="center" class="style30">3</th> 
<th width="3%" align="center" class="style30">4</th>
<th width="3%" align="center" class="style30">5</th> 
<th width="3%" align="center" class="style30">6</th>
<th width="3%" align="center" class="style30">7</th>
<th width="3%" align="center" class="style30">8</th> 
<th width="3%" align="center" class="style30">9</th>
<th width="3%" align="center" class="style30">10</th> 
<th width="3%" align="center" class="style30">11</th>
<th width="3%" align="center" class="style30">12</th> 
<th width="3%" align="center" class="style30">13</th>
<th width="3%" align="center" class="style30">14</th>
<th width="3%" align="center" class="style30">15</th> 

</tr>
</thead>
	
<?php
$strSQL = "SELECT salechannel_ID,salechannel_nameshort,GP_sum FROM tb_salechannel where salechannel_ID !='3' and salechannel_ID !='4' and salechannel_ID !='5' and salechannel_ID !='6' and ckk='1'";	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);	
$total = 0;	
while($objResult = mysqli_fetch_array($objQuery))
{

$strSQL1 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_1."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
	
$strSQL2 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date  ='".$day_2."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
	
$strSQL3 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_3."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
$strSQL4 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_4."'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
	
$strSQL5 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_5."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
	
$strSQL6 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_6."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL7 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_7."'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
$strSQL8 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_8."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);
	
$strSQL9 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_9."'";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);
	
$strSQL10 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_10."'";
$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$strSQL11 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_11."'";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);
	
$strSQL12 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_12."'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	
$strSQL13 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_13."'";
$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
$objResult13 = mysqli_fetch_array($objQuery13);
	
$strSQL14 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_14."'";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$objResult14 = mysqli_fetch_array($objQuery14);
	
$strSQL15 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_15."'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);	

$strSQL16 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date >='".$day_1."'  and doc_date <='".$day_31."'";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$objResult16 = mysqli_fetch_array($objQuery16);	

if($objResult["GP_sum"]=='0.0000'){
$price = $objResult16["sum_amount"];	
}else{	
$price = ($objResult16["sum_amount"]*$objResult["GP_sum"])/1.07;	
}
$total += $price;
?>
<tr>	
<td><?php echo $objResult["salechannel_nameshort"]; ?></td>
<td bgcolor = "#FFCC99" ><?php  if($objResult["GP_sum"]=='0.0000'){  echo number_format($objResult16["sum_amount"]/1.07,2); }else{ echo number_format(($objResult16["sum_amount"]*$objResult["GP_sum"])/1.07,2); } ?></td>	
<td bgcolor = "#99FF33" ><?php echo number_format($objResult16["sum_amount"],2); ?></td>
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_1; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult1["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_2; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult2["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_3; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult3["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_4; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult4["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_5; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult5["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_6; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult6["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_7; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult7["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_8; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult8["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_9; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult9["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_10; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult10["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_11; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult11["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_12; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult12["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_13; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult13["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_14; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult14["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_15; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult15["sum_amount"],2); ?></a></td>	
	
	
	
</tr>
	<?php } 
	
$strSQL1 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_1."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
	
$strSQL2 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_2."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
	
$strSQL3 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_3."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
$strSQL4 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_4."'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
	
$strSQL5 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_5."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
	
$strSQL6 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_6."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL7 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_7."'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
$strSQL8 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_8."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);
	
$strSQL9 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_9."'";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);
	
$strSQL10 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_10."'";
$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$strSQL11 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_11."'";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);
	
$strSQL12 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_12."'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	
$strSQL13 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_13."'";
$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
$objResult13 = mysqli_fetch_array($objQuery13);
	
$strSQL14 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_14."'";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$objResult14 = mysqli_fetch_array($objQuery14);
	
$strSQL15 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date ='".$day_15."'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);	

$strSQL16 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE  sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43' and doc_date >='".$day_1."'  and doc_date <='".$day_31."'";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$objResult16 = mysqli_fetch_array($objQuery16);		
	
?>
<tr>	
<td><b>ยอดรวม</b></td>
<td bgcolor = "#FFCC99" ><?php echo number_format($total,2); ?></td>		
<td bgcolor = "#99FF33" ><?php echo number_format($objResult16["sum_amount"],2); ?></td>		
<td><?php echo number_format($objResult1["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult2["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult3["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult4["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult5["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult6["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult7["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult8["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult9["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult10["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult11["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult12["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult13["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult14["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult15["sum_amount"],2); ?></td>	
	
	
	
</tr>	
	
	
	
	
	<?php if($to_day >= $day_16){ ?>
	
	
<thead  class='w3-grey'>	
<tr>
<th width="10%" align="center" class="style30">ช่องทางการขาย</th>
<th width="3%" align="center" class="style30"></th>	
<th width="3%" align="center" class="style30">16</th>
<th width="3%" align="center" class="style30">17</th> 
<th width="3%" align="center" class="style30">18</th>
<th width="3%" align="center" class="style30">19</th>
<th width="3%" align="center" class="style30">20</th> 
<th width="3%" align="center" class="style30">21</th>
<th width="3%" align="center" class="style30">22</th> 
<th width="3%" align="center" class="style30">23</th>
<th width="3%" align="center" class="style30">24</th> 
<th width="3%" align="center" class="style30">25</th> 
<th width="3%" align="center" class="style30">26</th>
<th width="3%" align="center" class="style30">27</th>
<th width="3%" align="center" class="style30">28</th> 
<th width="3%" align="center" class="style30">29</th>
<th width="3%" align="center" class="style30">30</th> 
<th width="3%" align="center" class="style30">31</th>

</tr>
</thead>	
	
<?php
$strSQL = "SELECT salechannel_ID,salechannel_nameshort FROM tb_salechannel where salechannel_ID !='3' and salechannel_ID !='4' and salechannel_ID !='5' and salechannel_ID !='6' and ckk='1'";	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);		
while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL1 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_16."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
	
$strSQL2 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_17."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
	
$strSQL3 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_18."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
$strSQL4 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_19."'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
	
$strSQL5 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_20."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
	
$strSQL6 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_21."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL7 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_22."'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
$strSQL8 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_23."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);
	
$strSQL9 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_24."'";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);
	
$strSQL10 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_25."'";
$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$strSQL11 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_26."'";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);
	
$strSQL12 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_27."'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	
$strSQL13 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_28."'";
$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
$objResult13 = mysqli_fetch_array($objQuery13);
	
$strSQL14 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_29."'";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$objResult14 = mysqli_fetch_array($objQuery14);
	
$strSQL15 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_30."'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);		
	
$strSQL16 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan = '".$objResult["salechannel_ID"]."' and doc_date ='".$day_31."'";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$objResult16 = mysqli_fetch_array($objQuery16);			
	
?>
<tr>	
<td><?php echo $objResult["salechannel_nameshort"]; ?></td>
<td></td>
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_16; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult1["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_17; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult2["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_18; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult3["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_19; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult4["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_20; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult5["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_21; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult6["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_22; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult7["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_23; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult8["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_24; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult9["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_25; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult10["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_26; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult11["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_27; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult12["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_28; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult13["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_29; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult14["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_30; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult15["sum_amount"],2); ?></a></td>	
<td><a href="status_ecomercvip.php?register_date=<?php echo $day_31; ?>&sale_channel=<?php echo $objResult["salechannel_ID"]; ?>" target="_blank"><?php echo number_format($objResult16["sum_amount"],2); ?></a></td>	

</tr>
	<?php } 
	
$strSQL1 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_16."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
	
$strSQL2 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_17."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
	
$strSQL3 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_18."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
$strSQL4 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_19."'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
	
$strSQL5 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_20."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
	
$strSQL6 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_21."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL7 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_22."'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
$strSQL8 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_23."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);
	
$strSQL9 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_24."'";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);
	
$strSQL10 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_25."'";
$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$strSQL11 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_26."'";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);
	
$strSQL12 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_27."'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	
$strSQL13 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_28."'";
$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
$objResult13 = mysqli_fetch_array($objQuery13);
	
$strSQL14 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_29."'";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$objResult14 = mysqli_fetch_array($objQuery14);
	
$strSQL15 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_30."'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);		
	
$strSQL16 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1 WHERE sale_chan !='3' and sale_chan !='4' and sale_chan !='5' and sale_chan !='6' and sale_chan !='0' and sale_chan !='23' and sale_chan !='24' and sale_chan !='26' and sale_chan !='41' and sale_chan !='42' and sale_chan !='43'  and doc_date ='".$day_31."'";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$objResult16 = mysqli_fetch_array($objQuery16);			
	?>
<tr>	
<td><b>ยอดรวม</b></td>
<td></td>
<td><?php echo number_format($objResult1["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult2["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult3["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult4["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult5["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult6["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult7["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult8["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult9["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult10["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult11["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult12["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult13["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult14["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult15["sum_amount"],2); ?></td>	
<td><?php echo number_format($objResult16["sum_amount"],2); ?></td>		

</tr>

	<?php } ?></table>
<br><br>