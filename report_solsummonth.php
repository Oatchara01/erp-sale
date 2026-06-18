<?php include('head.php'); 
include "dbconnect.php";
?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	<div class="w3-white">
<div class="w3-container w3-padding-large">

<?php

$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$mm = substr($_GET["start_date"],5);
$yy = substr($_GET["start_date"],0,4);
$thai= $_month_name[$mm];
$year =$yy+543;
$start_date = "$yy-$mm";
$sale_code = $_GET["sale_code"];
?>

<center>
<h4>รายงานการเปิดออเดอร์ เขตการขาย <?php echo $_GET["sale_code"]; ?></h4>
<h4>เดือน <?php echo  $thai; ?>   <?php echo  $year; ?></h4>	
	
</center><br>
</form>
		
<div class="w3-container">
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%">เลขที่อ้างอิง</th>
<th width="10%">วันที่ออกเอกสาร</th>
<th width="10%">เลขที่เอกสาร</th> 
<th width="10%">หมายเลขคำสั่งซื้อ</th> 
<th width="23%">รายการสินค้า</th>
<th width="23%">จำนวน</th>
<th width="23%">ยอดขายรวม</th>
<th width="22%">ชื่อลูกค้า</th>
<th width="10%">เขตการขาย</th>
<th width="20%">ช่องทางการขาย</th>
</thead>		
		
<?php	

$strSQL = "SELECT DISTINCT ref_id FROM so__main  where  employee_name !='SOL91' and employee_name !='SOL92' and employee_name !='SOL93' and employee_name !='SOL94' and doc_release_date LIKE '%".$start_date."%' and doc_no NOT LIKE '%BR%' and cancel_ckk='.' and approve_complete='Approve'";
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by doc_release_date DESC ";
$objQuery  = mysqli_query($conn,$strSQL);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL6 = "SELECT doc_release_date,doc_no,order_id,customer_name,sale_channel,employee_name FROM so__main WHERE ref_id='".$objResult["ref_id"]."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL3 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID  = '".$objResult6["sale_channel"]."'  ";
$objQuery3 =mysqli_query($conn,$strSQL3);
$objResult3=mysqli_fetch_array($objQuery3);	
?>
<tbody>
<tr>
<td><?php echo $objResult["ref_id"];?></td>
	
<td><?php echo DateThai($objResult6["doc_release_date"]);?></td>

<td><a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"  target="_blank" ><?php echo $objResult6["doc_no"];?></a></td>
<td><?php echo $objResult6["order_id"];?></td>

<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_id=tb_product.product_ID) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{	echo $objResult1["sol_name"]; 	?><br><?php } ?>
</div>

<td><div align="right">
<?php
$strSQL2 = "SELECT unit_name,sale_count FROM (so__submain LEFT JOIN tb_product ON so__submain.product_id=tb_product.product_ID) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{	echo $objResult2["sale_count"]; ?> <?php echo $objResult2["unit_name"]; ?><br><?php } ?>
</div>


<td><div align="right">
<?php
$strSQL4 = "SELECT SUM(sum_amount) AS sum_amount FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
	echo number_format($objResult4["sum_amount"],2); ?>
</div>

</td>
<td><div align="left"><?php echo $objResult6["customer_name"]; ?></div></td>	
<td><div align="left"><?php echo $objResult6["employee_name"]; ?></div></td>	
<td><div align="left"><?php echo $objResult3["salechannel_nameshort"]; ?></div></td>

</tr>


<?php
		  
$i++;
}
?>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td>ยอดรวม</td>

<td><div align="right">
<?php
$strSQL4 = "SELECT SUM(sum_amount) AS sum_amount FROM (so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id) WHERE  employee_name !='SOL91' and employee_name !='SOL92' and employee_name !='SOL93' and employee_name !='SOL94' and doc_release_date LIKE '%".$start_date."%' and doc_no NOT LIKE '%BR%' and cancel_ckk='.' and approve_complete='Approve'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
	echo number_format($objResult4["sum_amount"],2); ?>
	
</div>

</td>
<td></td>
<td></td>
<td></td>
</tr>	

</table>

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ</strong>
     

      <br></div></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>

</body>
</html>