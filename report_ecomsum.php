<?php include('head.php'); 

include "dbconnect.php";

$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$mm = substr($_GET["start_date"],5);
$yy = substr($_GET["start_date"],0,4);
$thai= $_month_name[$mm];
$year =$yy+543;
$start_date = "$yy-$mm";
$sale_code = $_GET["sale_code"];
?>
<body>
	<div class="w3-white">
<div class="w3-container w3-padding-large">

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">

<center>
<h4>รายงานการเปิดออเดอร์ เขตการขาย <?php echo $_GET["sale_code"]; ?></h4>
<h4>เดือน <?php echo  $thai; ?>   <?php echo  $year; ?></h4>	
	
</center><br>
</form>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="8%">เลขที่เอกสาร</td > 
			<td width="10%">วันที่ออกเอกสาร</td >
			<td width="15%">ชื่อผู้ออกบิล</td >
			<td width="10%">ยอดขายรวม</td >
			<td width="10%">ช่องทางการขาย</td >
			<td width="10%">เขตการขาย</td >
			<td width="5%">สถานะ</td >
        </thead>
	

<?php	

$strSQL = "SELECT ref_id,doc_no,doc_release_date,billing_name,approve_complete,employee_name,sale_channel  
FROM so__main  
WHERE doc_release_date LIKE '%$start_date%' 
  AND employee_name LIKE '%SOL9%'  
  AND employee_name != 'SOL99' 
  AND approve_complete = 'Approve' 
  AND cancel_ckk = '0' 
  AND (select_type_doc = '3' OR select_type_doc = '4')";

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by doc_release_date ASC";
$objQuery  = mysqli_query($conn,$strSQL);
$total_amount1 = 0;

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL2 = "SELECT salechannel_nameshort  FROM tb_salechannel where salechannel_ID = '".$objResult["sale_channel"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
	
	
?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>
<td><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"  target="_blank"><?php echo $objResult["doc_no"];?></a>
				</td>
				<td ><?php  echo DateThai($objResult["doc_release_date"]); ?></td>
<td ><div align="left"><?php echo $objResult["billing_name"];?></div></td>				
								
<td><div align="right">
<?php
$strSQL3 = "SELECT SUM(sum_amount) AS amount FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
$total_amount1 += $objResult3["amount"];
 echo number_format($objResult3["amount"],0);	?>
				</div></td>				
<td ><div align="left"><?php echo $objResult2["salechannel_nameshort"];?></div></td>				
				
				<td ><div align="center"><?php echo $objResult["employee_name"];?></div></td>
				
				<?php if($objResult["approve_complete"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else if ($objResult["approve_complete"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["approve_complete"];?></td>
				<?php } ?>
				
			</tr>
<?php 
 $i++; 
}
?>
		
	
<?php	

/*$strSQL = "SELECT DISTINCT iv_no,sale_channel,iv_date,employee_name 
FROM so__main  
WHERE iv_date LIKE '%$start_date%' 
  AND employee_name LIKE '%SOL9%'  
  AND employee_name != 'SOL99' 
  AND approve_complete = 'Approve' 
  AND cancel_ckk = '0' 
  AND (select_type_doc = '1' OR select_type_doc = '2')";
		
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by doc_release_date ASC";
$objQuery  = mysqli_query($conn,$strSQL);
$total_amount = 0;

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql3 = "SELECT salechannel_name FROM tb_salechannel where salechannel_ID  ='".$objResult["sale_channel"]."'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
	
?>
		
			<tr>
				<td></td>
<td><?php echo $objResult["iv_no"];?></td>
				<td ><?php  echo DateThai($objResult["iv_date"]); ?></td>
<td ><div align="left"><?php echo $rs3["salechannel_name"];?></div></td>				
				
<td><div align="right">
<?php
$strSQL3 = "SELECT SUM(sum_amount) AS amount FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE iv_date LIKE '%$start_date%' 
  AND employee_name LIKE '%SOL9%'  AND employee_name != 'SOL99'  AND approve_complete = 'Approve'  AND cancel_ckk = '0'   AND (select_type_doc = '1' OR select_type_doc = '2') and iv_no = '".$objResult["iv_no"]."' and sale_channel = '".$objResult["sale_channel"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
$total_amount += $objResult3["amount"];
 echo number_format($objResult3["amount"],2);	?>
				</div></td>				
	<td ><div align="left"><?php echo $rs3["salechannel_nameshort"];?></div></td>			
	<td ><div align="left"><?php echo $objResult["employee_name"];?></div></td>				
			
					<td  bgcolor="#00FF00">Approve</td>
	
				
			</tr>
<?php 
 $i++; 
}
?>		
		
		
		
<?php	

$strSQL = "SELECT * FROM  tb_credit_note  where  date_credit LIKE '%$start_date%' AND sale_code LIKE '%SOL9%'  AND sale_code != 'SOL99' and status_doc = 'Approve'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by date_credit ASC";
$objQuery  = mysqli_query($conn,$strSQL);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
<tr>
<td><?php echo $objResult["ref_credit"];?></td>
<td><a href="register_credit_adm.php?ref_credit=<?php echo $objResult["ref_credit"];?>"  target="_blank"><?php echo $objResult["credit_no"];?></a>
				</td>
<td ><?php if($objResult["iv_date"]!='0000-00-00'){  echo DateThai($objResult["iv_date"]); } ?></td>
<td ><div align="left"><?php echo $objResult["customer_name"];?></div></td>				
<td><div align="right"><font color='red'>
<?php
$strSQL3 = "SELECT SUM(sum_amount) AS sum_amount FROM tb_subcredit  WHERE ref_creditt = '".$objResult["ref_credit"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3); 
  echo "- ";
 echo number_format($objResult3["sum_amount"],2);	?>
				</font></div></td>				
				
				
				<td ><div align="center"><?php echo $objResult["sale_code"];?> <?php echo '-';?> <?php echo $objResult["sale_name"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				
			</tr>
<?php 
 $i++; 
}*/
?>
		
		
		
<tr>
				
				<td></td>
				<td></td><td></td>
				<td>ยอดรวม</td>
<td><div align="right">
<?php
	
$strSQL14 = "SELECT SUM(sum_amount) AS sum_amount FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_subcredit.ref_creditt=tb_credit_note.ref_credit)  WHERE date_credit LIKE '%$start_date%' AND sale_code LIKE '%SOL9%'  AND sale_code != 'SOL99' and status_doc = 'Approve'";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$objResult14 = mysqli_fetch_array($objQuery14); 
	
	
	
echo number_format((($total_amount+$total_amount1)-$objResult14["sum_amount"]),2);	?>
				</div></td>				
				
				<td></td>
				<td></td>
				<td></td>
				
			</tr>		
		
		
	</table>
	

 
      <br>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>
</html>

