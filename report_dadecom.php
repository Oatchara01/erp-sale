<?php include('head.php') ;

include "dbconnect.php";
 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
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
<option  value="2018">2561</option>
<option  value="2019">2562</option>
<option  value="2020">2563</option>
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
	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<br>
<?php

$mm = $_GET["mount"];
$yy = $_GET["year"];


$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;

if($mm !=''){
$start_date = "$yy-$mm";
}else{
$start_date = "$yy";
}
	
if($mm!='' or $yy!=''){
?>
<h3 align="center">ยอดขายของช่องทาง E-commerce</h3>
<h3 align="center"><?php if($mm !=''){ echo $thai; } ?>&nbsp;&nbsp;<?php if($yy !=''){ echo $year; } ?></h3><br>

<?php } ?>

 <table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
	  <th width="8%">ช่องทางการขาย </th>
    <th width="10%">ยอดขาย AWL</th>
	<th width="10%">ยอดขาย NBM</th>
    <th width="10%">ยอดขายทั้งหมด</th>
    
  </tr>
  </thead>
  
<?php

if($mm!='' or $yy!=''){

$strSQL1 = "SELECT salechannel_ID,salechannel_nameshort FROM tb_salechannel WHERE ckk = '1' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$strSQL = "SELECT SUM(amount) AS amount  FROM tb__buypro WHERE sale_chan ='".$objResult1["salechannel_ID"]."' and doc_date LIKE '%".$start_date."%' and company='1'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$strSQL2 = "SELECT SUM(amount) AS amount  FROM tb__buypro WHERE sale_chan ='".$objResult1["salechannel_ID"]."' and doc_date LIKE '%".$start_date."%' and company='3'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
	
$strSQL22 = "SELECT SUM(amount) AS amount  FROM tb__discash WHERE sale_chan ='".$objResult1["salechannel_ID"]."' and date_cash LIKE '%".$start_date."%' and company='3'";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);	

$amount1 = $objResult["amount"];
$amount2 = $objResult2["amount"];

$sumawl_sol = $amount1+$amount2;



$strSQL3 = "SELECT SUM(amount) AS amount  FROM tb__buypro WHERE sale_chan ='".$objResult1["salechannel_ID"]."' and doc_date LIKE '%".$start_date."%' and company='2'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);

$strSQL4 = "SELECT SUM(amount) AS amount  FROM tb__buypro WHERE sale_chan ='".$objResult1["salechannel_ID"]."' and doc_date LIKE '%".$start_date."%' and company='4'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$amount3 = $objResult3["amount"];
$amount4 = $objResult4["amount"];
$sumnbm_sol = $amount3+$amount4;
	
	
$strSQL5 = "SELECT SUM(amount) AS amount  FROM tb__discash WHERE sale_chan ='".$objResult1["salechannel_ID"]."' and date_cash LIKE '%".$start_date."%' ";
	//echo $strSQL5;
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);	

$dis = 	$objResult5["amount"];

$sum_sol = ($sumawl_sol+$sumnbm_sol)-$dis;



?>

  
    <tr> 
	
      <td align="center"><?php echo $objResult1["salechannel_nameshort"]; ?></td>
	  <td align="right"><?php echo number_format($sumawl_sol,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_sol,2);?></td> 
      <td align="right"><?php echo number_format($sum_sol,2);?></td> 
	  
    </tr>

	<?php 
	$i++; 
	}
	
	
$strSQL = "SELECT SUM(amount) AS amount  FROM tb__buypro WHERE  sale_chan !='' and doc_date LIKE '%".$start_date."%' and company='1'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$strSQL2 = "SELECT SUM(amount) AS amount  FROM tb__buypro WHERE  sale_chan !='' and doc_date LIKE '%".$start_date."%' and company='3'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$amounts1 = $objResult["amount"];
$amounts2 = $objResult2["amount"];

$sumawl_ssol = $amounts1+$amounts2;



$strSQL3 = "SELECT SUM(amount) AS amount  FROM tb__buypro WHERE sale_chan !='' and doc_date LIKE '%".$start_date."%' and company='2'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);

$strSQL4 = "SELECT SUM(amount) AS amount  FROM tb__buypro WHERE  sale_chan !='' and doc_date LIKE '%".$start_date."%' and company='4'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$amounts3 = $objResult3["amount"];
$amounts4 = $objResult4["amount"];
$sumnbm_ssol = $amounts3+$amounts4;
	
$strSQL5 = "SELECT SUM(amount) AS amount  FROM tb__discash WHERE  date_cash LIKE '%".$start_date."%' and sale_chan !=''";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);	

$sum_dis = 	$objResult5["amount"];	

$sum_ssol = ($sumawl_ssol+$sumnbm_ssol)-$sum_dis;	
	
	
	?>
	
  <tr> 
	
      <td align="center">ยอดรวม</td>
	  <td align="right"><?php echo number_format($sumawl_ssol,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_ssol,2);?></td> 
      <td align="right"><?php echo number_format($sum_ssol,2);?></td> 
	  
    </tr>
	 
	 
	 <?php
}

	?>

</table>

<br>
</div>

</div>

<div id="cr_bar"> <?php include "foot.php"; ?></div>




