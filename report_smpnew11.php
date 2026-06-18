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
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานใบเบิกสินค้า SMP (GLUCOALL-1B)</h4></div>
<center><h4><?php echo DateThai1($_GET["date_sum"]); ?></h4></center>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	

<?php

$date_sum = $_GET["date_sum"];
$comment_sale = $_GET["comment_sale"];	
?>



<br>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%" >เลขที่อ้างอิง</th>
<th width="8%" >วันที่ออกเอกสาร</th>
<th width="8%" >เลขที่เอกสาร</th> 
<th width="10%" >ชื่อลูกค้า</th>
<th width="8%" >หมายเลขคำสั่งซื้อ</th> 
<th width="15%" >รายการสินค้าคำสั่งซื้อ</th>
<th width="15%" >รายการสินค้า</th>
<th width="8%" >จำนวน</th>
<th width="8%" >ราคาต่อหน่วย</th>
<th width="8%" >ราคารวม</th>
<th width="8%" >ผู้ทำรายการ</th>	
<th width="8%" >ช่องทางการขาย</th>
</thead>

<?php

$strSQL1 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%$comment_sale%'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$sum=0;
$sale_count=0; 
 $i=0;
while($objResult1 = mysqli_fetch_array($objQuery1))
{


$sql = "SELECT sale_channel,order_id FROM so__main where ref_id = '".$objResult1["ref_idsale"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);	


$sql12 = "SELECT salechannel_nameshort FROM tb_salechannel where salechannel_ID  = '".$rs["sale_channel"]."'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_assoc($qry12);	


?>

<tr>
<td><?php echo $objResult1["ref_idsmp"];?></td>
<td><?php echo Datethai($objResult1["smp_date"]);?></td>
<td><a href="report_sample_ad.php?ref_idsmp=<?php echo $objResult1["ref_idsmp"];?>"><?php echo $objResult1["smp_no"];?></a></td>
<td><div align="left"><?php echo $objResult1["customer_name"];?></div></td>

<?php if($rs["order_id"] ==''){ ?><td bgcolor="#FF0000"><?php }else{ ?><td><?php } ?>
<?php echo $rs["order_id"];?></td>

<td><div align="left">
<?php


$strSQL11 = "SELECT sol_name,count,unit_name FROM (tb__glu426 LEFT JOIN tb_product ON tb__glu426.product_id=tb_product.product_ID) WHERE ref_id = '".$objResult1["ref_idsale"]."' ";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);
$objResult11 = mysqli_fetch_array($objQuery11); 
	
if($Num_Rows11 > 0){	
	echo $objResult11["sol_name"]; ?> <?php echo $objResult11["count"]; ?> <?php echo $objResult11["unit_name"];  } 

$strSQL18 = "SELECT sol_name,count,unit_name FROM (tb__glucos LEFT JOIN tb_product ON tb__glucos.product_id=tb_product.product_ID) WHERE ref_id = '".$objResult1["ref_idsale"]."' ";
$objQuery18 = mysqli_query($conn,$strSQL18) or die ("Error Query [".$strSQL18."]");
$Num_Rows18 = mysqli_num_rows($objQuery18);
$objResult18 = mysqli_fetch_array($objQuery18); 
	
if($Num_Rows18 > 0){	
	echo $objResult18["sol_name"]; ?> <?php echo $objResult18["count"]; ?> <?php echo $objResult18["unit_name"];  } ?>
	
	
</div></td>	
	
	
<td><div align="left">
<?php
$strSQL14 = "SELECT sol_name FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult1["ref_idsmp"]."' ";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$Num_Rows14 = mysqli_num_rows($objQuery14);
while($objResult14 = mysqli_fetch_array($objQuery14)) { ?>
<?php	echo $objResult14["sol_name"]; ?><br>
<?php } ?>
</div></td>
	
<td><div align="right">
<?php
$strSQL15 = "SELECT sale_count,unit_name FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult1["ref_idsmp"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$Num_Rows15 = mysqli_num_rows($objQuery15);
$count=0;
$j=0;	
while($objResult15 = mysqli_fetch_array($objQuery15)) { ?>
<?php	echo number_format($objResult15["sale_count"],0).""; ?> <?php	echo $objResult15["unit_name"]; 
	
	$count = $count + $objResult15["sale_count"];
	
	?><br>
<?php 
	$count++;
	$j++;
													  } 
	//echo $count;
	$sale_count = $sale_count + ($count-$j);
	
	?>
</div></td>
	
<td><div align="right">
<?php
$strSQL16 = "SELECT unit_price FROM hos__subsmp WHERE reff_idsmp = '".$objResult1["ref_idsmp"]."' ";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$Num_Rows16 = mysqli_num_rows($objQuery16);
while($objResult16 = mysqli_fetch_array($objQuery16)) { ?>
<?php	echo number_format($objResult16["unit_price"],2)."";  ?><br>
<?php } ?>
</div></td>

<td><div align="right">
<?php
$strSQL17 = "SELECT SUM(sum_amount) AS sum_amount FROM hos__subsmp WHERE reff_idsmp = '".$objResult1["ref_idsmp"]."' ";
$objQuery17 = mysqli_query($conn,$strSQL17) or die ("Error Query [".$strSQL17."]");
$objResult17 = mysqli_fetch_array($objQuery17); 
echo number_format($objResult17["sum_amount"],2).""; 
	
$sum = $sum + $objResult17["sum_amount"];	
	
	?>
</div></td>



<td><?php
	
if (!function_exists('cutStringAfterSpace')) {
    function cutStringAfterSpace($inputString) {
        // แยกคำจากช่องว่าง
        $wordsArray = explode(' ', $inputString);
        // รับค่าแรก (ก่อนช่องว่าง)
        $firstWord = array_shift($wordsArray);
        return $firstWord;
    }
}

$result = cutStringAfterSpace($objResult1["add_by"]);
echo $result;
	
	
 ?></td>
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
<td></td>	
<td bgcolor='yellow' >ยอดรวม</td>
<td bgcolor='yellow' ><div align="right"><?php echo number_format($sale_count-$i,0).""; ?> รายการ</div></td>	
<td bgcolor='yellow' ></td>
<td bgcolor='yellow' ><div align="right"><?php echo number_format($sum-$i,2).""; ?></div></td>	
<td></td>	

</tr>	
	

</table>
	
	
	



<br><br>
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>




