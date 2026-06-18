<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
.style17 {font-size: 18px; color: #000000;}

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

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$sale_channel = $_GET["sale_channel"];
$iv_no = $_GET["iv_no"];
//$sol = "SOL";

include"dbconnect.php";




?>
<body>


<center>
<span class="style15">รายงานสรุปแยก SOL และ IV ที่ออกบิลแล้ว</span></p>

</center>


<span class="style16"><?php echo $iv_no ; ?></span></p>



<?php 

$strSQL2 = "SELECT distinct doc_no FROM so__main WHERE cancel_ckk ='0' ";

if($start_date !=""){ 
    $strSQL2 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL2 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

if($iv_no !=""){ 
    $strSQL2 .= ' AND iv_no = "'.$iv_no.'"'; 
}

$strSQL2 .=" order  by doc_no ASC ";
$objQuery2 =mysqli_query($conn,$strSQL2);
while($objResult2=mysqli_fetch_array($objQuery2)){

$doc_no = $objResult2["doc_no"];

?>
<span class="style17"><?php echo  $objResult2["doc_no"];  ?></span></p>



<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="10%" align="center" class="style30">หมายเลขคำสั่งซื้อ</td>
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">รหัสสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ราคา</td> 
	</tr>


<?php 
$strSQL ="SELECT  order_id,ref_id,product_code,sale_count,sum_amount FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no ='".$doc_no."' and iv_no  ='".$iv_no."' and cancel_ckk ='0' ";


if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

$strSQL .=" order  by product_code ASC ";
$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){



$strSQL1 = "SELECT access_name,sol_code FROM tb_product   WHERE product_ID = '".$objResult["product_code"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{

?>

<tr>
<td width="10%" align="center" class="style30"><?php echo $objResult["ref_id"]; ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult["order_id"]; ?></td>
<td width="25%" align="reft" class="style30"><?php echo $objResult1["access_name"]; ?></td> 
<td width="10%" align="reft" class="style30"><?php echo $objResult1["sol_code"]; ?></td> 
<td width="10%" align="right" class="style30"><?php echo $objResult["sale_count"]; ?></td> 
<td width="10%" align="right" class="style30"><?php $price=$objResult["sum_amount"]; echo number_format( $price,2).""; ?></td> 
	</tr>





<?php
}
}

$strSQL9 = "SELECT SUM(sale_count)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE  doc_no ='".$doc_no."' and iv_no  ='".$iv_no."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL9 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL9 .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL9 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");

$objResult9 = mysqli_fetch_array($objQuery9);

$total1 =$objResult9["total1"];

//echo $total1;


$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  doc_no ='".$doc_no."' and iv_no  ='".$iv_no."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL8 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL8 .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL8 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

//echo  $strSQL8; 

$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");

$objResult8 = mysqli_fetch_array($objQuery8);

$total =$objResult8["total"];
//echo $total;


?>

<tr>
<td width="10%" align="reft" class="style30"></td>
<td width="10%" align="reft" class="style30"></td>
<td width="25%" align="reft" class="style30"></td> 
<td width="10%" align="reft" class="style30"></td> 
<td width="10%" align="right" class="style30"><?php echo $total1; ?></td> 
<td width="10%" align="right" class="style30"><?php  echo number_format( $total,2).""; ?></td> 
	</tr>


</table>
</p>






<?php
}



$strSQL10 = "SELECT SUM(sum_amount)  as sum_amount10  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  iv_no  ='".$iv_no."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL10 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL10 .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL10 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}
//echo $strSQL10 ;

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");

$objResult10 = mysqli_fetch_array($objQuery10);

$sum_amount10 =$objResult10["sum_amount10"];

	?>
	<table  width="100%" class='w3-table'>
<tr>
<td width="100%" align="right" class="style16"><?php echo "ยอดรวมทั้งหมด " ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format( $sum_amount10,2).""; ?>&nbsp;&nbsp;&nbsp;<?php echo "บาท" ; ?></td>
	</tr>
	</table>



</body>
</html>