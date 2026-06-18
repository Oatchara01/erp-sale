<?php include('head.php') ;

include "dbconnect.php";
 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	
<div class="w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>">
	</div>
	<div class="w3-quarter">
	ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>"></div>
	

<div class="w3-quarter">
 ช่องทางการขาย

	<select name="sale_channel" id="sale_channel" style="width:90%" class="w3-input" >
<option value="">**Please Select**</option>
<?php
$strSQL9 = "SELECT * FROM tb_salechannel ORDER BY salechannel_ID ASC";
$objQuery9 = mysqli_query($conn,$strSQL9);
while($objResuut9 = mysqli_fetch_array($objQuery9))
{
if($_GET["sale_channel"] == $objResuut9["salechannel_ID"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>
<option value="<?php echo $objResuut9["salechannel_ID"];?>" <?php echo $sel;?>><?php echo $objResuut9["salechannel_nameshort"];?></option>
<?php
}
?>
</select>

	</div>
	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<br><br>
<?php

$sale_channel = $_GET["sale_channel"];
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];



if($start_date!='' or $end_date!=''  or $sale_channel!=''){

$strSQL81 = "SELECT salechannel_nameshort FROM tb_salechannel WHERE salechannel_ID = '".$sale_channel."' ";
$objQuery81 = mysqli_query($conn,$strSQL81) or die(mysqli_error());
$objResult81 = mysqli_fetch_array($objQuery81);


?>
<h3 align="center">รายงานสรุปจำนวนลูกค้าสมาชิก Allwell member</h3>
<h3 align="center"><?php if($sale_channel!=''){  echo $objResult81["salechannel_nameshort"]; } ?></h3>
<h3 align="center"><?php if($start_date !=''){ echo Datethai($start_date); } ?>&nbsp;ถึง&nbsp;<?php if($end_date !=''){ echo Datethai($end_date); } ?></h3><br>

<?php } ?>

 <table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
	  <th width="8%">ช่องทางการขาย </th>
    <th width="10%">จำนวนออเดอร์(Allwell Member)</th>
	<th width="10%">จำนวนออเดอร์(No member)</th>
    <th width="10%">จำนวนออเดอร์ทั้งหมด</th>
	<th width="10%">อัตราการใช้สิทธิสมาชิก</th>
 
  </tr>
  </thead>
  
<?php

if($start_date!='' or $end_date!=''  or $sale_channel!=''){

$strSQL1 = "SELECT salechannel_ID,salechannel_nameshort FROM tb_salechannel WHERE ckk = '1' ";
if($sale_channel!=''){
$strSQL1 .= ' AND salechannel_ID = "'.$sale_channel.'"'; 	
}
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$strSQL = "SELECT DISTINCT ref_id  FROM tb__buypro WHERE sale_chan ='".$objResult1["salechannel_ID"]."' and doc_date >= '".$start_date."' and  doc_date <= '".$end_date."' and mem_ckk='1'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$strSQL2 = "SELECT DISTINCT ref_id  FROM tb__buypro WHERE sale_chan ='".$objResult1["salechannel_ID"]."' and doc_date >= '".$start_date."' and  doc_date <= '".$end_date."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);
	
if($Num_Rows2!='0'){
if($Num_Rows!='0'){	
$percent = number_format(($Num_Rows/$Num_Rows2)*100,2);
$percent1 = "$percent %";
}else{
$percent1 = "-";		
}
}else{
$percent1 = "-";	
}

?>

  
    <tr> 
	
      <td align="center"><?php echo $objResult1["salechannel_nameshort"]; ?></td>
	  <td align="center"><?php if($Num_Rows!='0'){ echo number_format($Num_Rows,0); }else{ echo "-"; }?></td> 
	  <td align="center"><?php  if($Num_Rows2!='0'){ echo number_format($Num_Rows2-$Num_Rows,0); }else{ echo "-"; } ?></td> 
      <td align="center"><?php if($Num_Rows2!='0'){ echo number_format($Num_Rows2,0); }else{ echo "-"; }?></td> 
	  <td align="center"><?php echo $percent1 ?></td> 
    </tr>

	<?php 
	$i++; 
	}
	
	
$strSQL = "SELECT DISTINCT ref_id  FROM tb__buypro WHERE doc_date >= '".$start_date."' and  doc_date <= '".$end_date."' and mem_ckk='1' and sale_chan!=''";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$strSQL2 = "SELECT DISTINCT ref_id  FROM tb__buypro WHERE doc_date >= '".$start_date."' and  doc_date <= '".$end_date."' and sale_chan!=''";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);
	

$percent = ($Num_Rows/$Num_Rows2)*100;
	
	
	?>
	
  <tr> 
	
      <td align="center">ยอดรวม</td>
	  <td align="center"><?php echo number_format($Num_Rows,0);?></td> 
	  <td align="center"><?php echo number_format($Num_Rows2-$Num_Rows,0);?></td> 
      <td align="center"><?php echo number_format($Num_Rows2,0);?></td> 
	  <td align="center"><?php echo number_format($percent,0);?> %</td>
	  
    </tr>
	 
	 
	 <?php
}

	?>

</table>

<br>
</div>

</div>

<div id="cr_bar"> <?php include "foot.php"; ?></div>




