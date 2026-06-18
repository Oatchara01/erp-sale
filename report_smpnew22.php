<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";


function DateThai1($strDate)
	{
		$strYear = date("y",strtotime($strDate))+43;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strMonthThai $strYear";
	}

 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานใบสั่งขาย (GLUCOALL-1B)</h4></div>
<center><h4><?php echo DateThai1($_GET["date_sum"]); ?></h4></center>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	

<?php

$date_sum = $_GET["date_sum"];
	
?>



<br>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%" >เลขที่อ้างอิง</th>
<th width="8%" >วันที่ออกเอกสาร</th>
<th width="8%" >เลขที่เอกสาร</th> 
<th width="15%" >ชื่อลูกค้า</th>
<th width="8%" >หมายเลขคำสั่งซื้อ</th> 
<th width="15%" >รายการสินค้า</th>
<th width="8%" >จำนวน</th>
<th width="8%" >ราคาต่อหน่วย</th>
<th width="8%" >ราคารวม</th>
<th width="8%" >เขตการขาย</th>	
<th width="8%" >ช่องทางการขาย</th>
</thead>

<?php

$strSQL1 = "SELECT *  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$sum=0;
$sale_count=0; 
 $i=0;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
$sale_count = $sale_count + $objResult1["count"];	

$sql = "SELECT sale_channel,order_id FROM so__main where ref_id = '".$objResult1["ref_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);	


$sql12 = "SELECT salechannel_nameshort FROM tb_salechannel where salechannel_ID  = '".$rs["sale_channel"]."'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_assoc($qry12);	


?>

<tr>
<td><?php echo $objResult1["ref_id"];?></td>
<td><?php echo Datethai($objResult1["doc_date"]);?></td>
<td><?php echo $objResult1["doc_no"];?></td>
<td><div align="left"><?php echo $objResult1["customer"];?></div></td>

<td><?php echo $rs["order_id"];?></td>

<td><div align="left">
<?php


$strSQL11 = "SELECT sol_name FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE ref_id = '".$objResult1["ref_id"]."' ";

$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);
while($objResult11 = mysqli_fetch_array($objQuery11)) {
	echo $objResult11["sol_name"]; ?> <br><?php } ?>

</div></td>	
	
	
<td><div align="right">
<?php
$strSQL15 = "SELECT count,unit_name FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE ref_id = '".$objResult1["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$Num_Rows15 = mysqli_num_rows($objQuery15);
while($objResult15 = mysqli_fetch_array($objQuery15)) { ?>
<?php	echo number_format($objResult15["count"],0).""; ?> <?php	echo $objResult15["unit_name"]; 
	
	?><br><?php } ?>

</div></td>
	
<td><div align="right">
<?php
$strSQL16 = "SELECT price FROM tb__buypro WHERE ref_id = '".$objResult1["ref_id"]."' ";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$Num_Rows16 = mysqli_num_rows($objQuery16);
while($objResult16 = mysqli_fetch_array($objQuery16)) { ?>
<?php	echo number_format($objResult16["price"],2)."";  ?><br>
<?php } ?>
</div></td>

<td><div align="right">
<?php
$strSQL17 = "SELECT SUM(amount) AS amount FROM tb__buypro WHERE ref_id = '".$objResult1["ref_id"]."' ";
$objQuery17 = mysqli_query($conn,$strSQL17) or die ("Error Query [".$strSQL17."]");
$objResult17 = mysqli_fetch_array($objQuery17); 
echo number_format($objResult17["amount"],2).""; 
	
?>
</div></td>



<td><?php echo $objResult1["sale_code"];?></td>
<td><?php echo $rs12["salechannel_nameshort"];?></td>

</tr>
<?php 
$i++;
$sum++;
$sale_count++;
} 
	
	

	?>
	

	
<tr>
<td></td>
<td></td>
<td></td>	
<td></td>
<td></td>
	
<td bgcolor='yellow' >ยอดรวม</td>
<td bgcolor='yellow' ><div align="right"><?php echo number_format($sale_count-$i,0).""; ?> เครื่อง</div></td>	
<td ></td>
<td></td>	
<td></td>	

</tr>	

</table>
	
	
	



<br><br>
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>




