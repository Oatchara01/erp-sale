<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 15px; color: #000000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#CCFF66;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#FF3333;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}



</style>



<?php


include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";




date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

$iv_no = $_GET["iv_no"];

include"dbconnect.php";




?>
<body>


<center>
<span class="style15">รายงานสรุปรายการในเลขที่เอกสาร</span></p>

</center>
</p>




<?php 
$strSQL ="SELECT  distinct product_code,price_per_unit FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no ='".$iv_no."' ";

$strSQL .=" order  by product_code ASC ";

$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$product_code = $objResult["product_code"];
$price_per_unit = $objResult["price_per_unit"];
?>
	
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">หมายเลขคำสั่งซื้อ</td>
<td width="15%" align="center" class="style30">วันที่</td>
<td width="25%" align="center" class="style30">รายการ</td> 
<td width="10%" align="center" class="style30">จำนวน/หน่วย</td> 
<td width="10%" align="center" class="style30">ราคา</td> 
<td width="10%" align="center" class="style30">ยอดรวม</td> 
<td width="10%" align="center" class="style30">ID</td> 
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td> 

	</tr>
<?php
$strSQL1 ="SELECT  order_id,register_date,register_time,doc_no,ref_id,sale_count,sum_amount,price_per_unit  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no ='".$iv_no."' and product_code = '".$product_code."' and  price_per_unit = '".$price_per_unit."'  ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{

$strSQL2 ="SELECT  access_name,unit_name FROM tb_product WHERE  product_ID = '".$product_code."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


?>

<tr>
<td  align="center" class="style30"><?php echo $objResult1["order_id"]; ?></td>
<td  align="reft" class="style30"><?php echo datethai($objResult1["register_date"]); ?> <?php echo $objResult1["register_time"]; ?></td>
<td  align="reft" class="style30"><?php echo $objResult2["access_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $objResult1["sale_count"]; ?> <?php echo $objResult2["unit_name"]; ?></td> 
<td  align="right" class="style30"><?php $price_per_unit=$objResult1["price_per_unit"]; echo number_format( $price_per_unit,2).""; ?></td> 
<td  align="right" class="style30"><?php $price=$objResult1["sum_amount"]; echo number_format( $price,2).""; ?></td> 
<td  align="center" class="style30"><?php echo $objResult1["ref_id"]; ?></td> 
<td  align="center" class="style30"><?php echo $objResult1["doc_no"]; ?></td> 
	</tr>
	<?php } 
	
	$strSQL5 ="SELECT  SUM(sale_count)  as sale_count1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no ='".$iv_no."' and product_code = '".$product_code."' and  price_per_unit = '".$price_per_unit."'  ";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
	
	
$strSQL6 ="SELECT  SUM(sum_amount)  as sum_amount1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no ='".$iv_no."' and product_code = '".$product_code."' and  price_per_unit = '".$price_per_unit."'  ";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
	
	
	?>
	
	<tr>
<td  align="center" class="style30"></td>
<td  align="reft" class="style30"></td>
<td  align="reft" class="style30">ยอดรวม</td> 
<td  align="right" class="style30"><?php $sale_count1 = $objResult5["sale_count1"]; echo number_format($sale_count1,2).""; ?></td> 
<td  align="right" class="style30"></td> 
<td  align="right" class="style30"><?php $price=$objResult6["sum_amount1"]; echo number_format( $price,2).""; ?></td> 
<td  align="center" class="style30"></td> 
<td  align="center" class="style30"></td> 
	</tr>
</table>
</p>



<?php

}
?>

</p>
<span class="style15">เลขที่เอกสาร <?php echo $iv_no; ?></span></p>

<table border= "1" width="100%" class='w3-table'>
<tr>

<td width="25%" align="center" class="style30">รายการ</td> 
<td width="10%" align="center" class="style30">จำนวน/หน่วย</td> 
<td width="10%" align="center" class="style30">ราคา</td> 
<td width="10%" align="center" class="style30">ยอดรวม</td> 


	</tr>

<?php 
$strSQL ="SELECT  distinct product_code,price_per_unit FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no ='".$iv_no."' ";

$strSQL .=" order  by product_code ASC ";

$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$product_code = $objResult["product_code"];
$price_per_unit = $objResult["price_per_unit"];
	
$strSQL2 ="SELECT  access_name,unit_name FROM tb_product WHERE  product_ID = '".$product_code."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

	
	$strSQL5 ="SELECT  SUM(sale_count)  as sale_count1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no ='".$iv_no."' and product_code = '".$product_code."' and  price_per_unit = '".$price_per_unit."'  ";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
	
	
$strSQL6 ="SELECT  SUM(sum_amount)  as sum_amount1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no ='".$iv_no."' and product_code = '".$product_code."' and  price_per_unit = '".$price_per_unit."'  ";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
?>

<tr>

<td  align="reft" class="style30"><?php echo $objResult2["access_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $objResult5["sale_count1"]; ?> <?php echo $objResult2["unit_name"]; ?></td> 
<td  align="right" class="style30"><?php  echo number_format( $price_per_unit,2).""; ?></td> 
<td  align="right" class="style30"><?php $price=$objResult6["sum_amount1"]; echo number_format( $price,2).""; ?></td> 

	</tr>
<?php } ?>
</table>
<?php
	$strSQL15 ="SELECT  SUM(sale_count)  as sale_count1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no ='".$iv_no."'  ";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);
	
	
$strSQL16 ="SELECT  SUM(sum_amount)  as sum_amount1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no ='".$iv_no."' ";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$objResult16 = mysqli_fetch_array($objQuery16);
	
	
	?>
<table border= "1" width="100%" class='w3-table'>	
	<tr>
<td width="25%" align="center" class="style30">ยอดรวม</td> 
<td width="10%" align="right" class="style30"><?php $sale_count11 = $objResult15["sale_count1"]; echo number_format($sale_count11,2).""; ?></td> 
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="right" class="style30"><?php $price1=$objResult16["sum_amount1"]; echo number_format( $price1,2).""; ?></td> 
	</tr>
</table>


</body>
</html>