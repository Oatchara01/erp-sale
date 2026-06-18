<?php include('head.php'); 
include "dbconnect.php";
?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	<div class="w3-white">
<div class="w3-container w3-padding-large">

<?php

$sale_channel= $_GET["sale_channel"];
$register_date = $_GET["register_date"];

$strSQL3 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID  = '".$sale_channel."'  ";
$objQuery3 =mysqli_query($conn,$strSQL3);
$objResult3=mysqli_fetch_array($objQuery3);

?>

<center>
<h4>รายงานการเปิดออเดอร์ <?php echo $objResult3["salechannel_nameshort"]; ?></h4>
	<h4>วันที่ <?php echo  Datethai($register_date); ?></h4>	
	
</center><br>
</form>
		
<div class="w3-container">
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%">เลขที่อ้างอิง</th>
<th width="10%">วันที่สั่งซื้อ</th>
<th width="10%">วันที่ออกเอกสาร</th>
<th width="10%">เลขที่เอกสาร</th> 
<th width="10%">หมายเลขคำสั่งซื้อ</th> 
<th width="15%">รายการสินค้า</th>
<th width="8%">จำนวน</th>
<th width="10%">ยอดขายรวม</th>
<th width="15%">ชื่อลูกค้า</th>
<th width="10%">ช่องทางการขาย</th>
</thead>		
		
<?php	

$strSQL = "SELECT DISTINCT ref_id FROM tb__buyecomercs1  where sale_chan='".$sale_channel."' and doc_date='".$register_date."'";
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by ref_id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL6 = "SELECT doc_date,create_date,doc_no,order_id,customer FROM tb__buyecomercs1 WHERE ref_id='".$objResult["ref_id"]."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
	
	
?>
<tbody>
<tr>
<td><?php echo $objResult["ref_id"];?></td>
<td><?php if($objResult6["create_date"] !='0000-00-00'){ echo DateThai($objResult6["create_date"]); } ?></td>	
<td><?php echo DateThai($objResult6["doc_date"]);?></td>

<td><a href="register_admin_edit.php?ref_id=<?php echo $objResult['ref_id']; ?>" target="_blank"><?php echo $objResult6["doc_no"];?></a></td>
<td><?php echo $objResult6["order_id"];?></td>

<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (tb__buyecomercs1 LEFT JOIN tb_product ON tb__buyecomercs1.product_no=tb_product.product_ID) WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{	echo $objResult1["sol_name"]; 	?><br><?php } ?>
</div>

<td><div align="right">
<?php
$strSQL2 = "SELECT unit_name,count FROM (tb__buyecomercs1 LEFT JOIN tb_product ON tb__buyecomercs1.product_no=tb_product.product_ID) WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{	echo $objResult2["count"]; ?> <?php echo $objResult2["unit_name"]; ?><br><?php } ?>
</div>


<td><div align="right">
<?php
$strSQL4 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1  WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
	echo number_format($objResult4["sum_amount"],2); ?>
</div>

</td>
<td><div align="left"><?php echo $objResult6["customer"]; ?></div></td>	
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
<td></td>
<td>ยอดรวม</td>
<td><div align="right">
<?php
$strSQL4 = "SELECT SUM(amount) AS sum_amount FROM tb__buyecomercs1  WHERE sale_chan='".$sale_channel."' and doc_date='".$register_date."'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
	echo number_format($objResult4["sum_amount"],2); ?>
	
</div>

</td>
<td></td><td></td>
</tr>	

</table>

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ</strong>
     

      <br></div></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>

</body>
</html>