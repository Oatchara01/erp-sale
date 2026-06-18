<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";
 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานขอปรับปรุงยอดสต็อก (ทั้งหมด)</h4></div>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	<div class="w3-half">	
<div class="w3-bar w3-quarter w3-third">
วันที่ :
<input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>">
</div>
<div class="w3-bar w3-quarter w3-thirdr">
ถึง :
<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>">
	</div>


	<div class="w3-margin-bottom w3-third">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div></div>
<br><br>
<?php

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
	
?>



<?php 
if($start_date!='' or $end_date!='' ){ 
?>
<br>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">

<th width="5%" >เลขที่อ้างอิง</th>
<td width="8%">วันที่ปรับปรุงรายการ</td>
<td width="10%">เลขที่เอกสาร</td> 
<td width="15%">ชื่อผู้ออกบิล</td>
<td width="15%">รายละเอียดการแก้ไข</td>
<td width="10%">ผู้ดำเนินการ</td>
<td width="8%">ผู้อนุมัติ</td>
<td width="8%">วันที่อนุมัติ</td>
<th width="5%">สถานะ</th>	
<td width="2%">ดูรายละเอียด</td>


</thead>

<?php

$strSQL = "SELECT * FROM st__main_new  where  status_doc ='Rejected'";

if($start_date !=""){ 
$strSQL .= ' AND app_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
$strSQL .= ' AND app_date <= "'.$end_date.'"'; 
}

$strSQL .=" order  by app_date ASC";	
$objQuery = mysqli_query($new,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{


?>

<tr>
				
<td ><?php echo $objResult["ref_id"];?></td>
<td ><?php echo DateThai($objResult["add_date"]); ?></td>
<td ><?php echo $objResult["iv_no"];?></td>
<td ><?php echo $objResult["customer_name"];?></td>
<td ><div align="left"><?php echo $objResult["edit_remark"];?></div></td>
<td ><?php echo $objResult["add_by"];?></td>
<td ><?php echo $objResult["cm_name"];?></td>
<td ><?php echo DateThai($objResult["app_date"]); ?></td>
	
<?php if($objResult["status_doc"]=='Rejected'){	?>	
<td bgcolor="#FF3030" ><?php echo $objResult["status_doc"];?></td>	
<?php }	else if ($objResult["status_doc"]=='Approve'){ ?>
<td  bgcolor="#00FF00" ><?php echo $objResult["status_doc"];?></td>
<?php }else{ ?>
<td ><?php echo $objResult["status_doc"];?></td>
<?php } ?>
	
<td><a href="register_readonly.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a></td>
				
</tr>
<?php 
$i++;
} 
	
	

	?>
	
	
	

</table>
	
<?php }	?>


<br><br>
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

