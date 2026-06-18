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

$iv_no = $_GET["iv_no"];

include"dbconnect.php";




?>
<body>


<center>
<span class="style15">รายงานสรุป IV ที่ออกบิลแล้ว</span></p>

</center>


<span class="style16"><?php echo $iv_no ; ?></span></p>



<?php 

$strSQL2 = "SELECT distinct product_id,price_per_unit FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' ";

if($iv_no !=""){ 
    $strSQL2 .= ' AND iv_no = "'.$iv_no.'"'; 
}

$objQuery2 =mysqli_query($conn,$strSQL2);


?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">ลำดับ</td>
<td width="10%" align="center" class="style30">รหัสสินค้า</td> 
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">หน่วย</td> 
<td width="10%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="10%" align="center" class="style30">ราคารวม</td> 



	</tr>


<?php 
$i=1;
while($objResult2=mysqli_fetch_array($objQuery2)){

$strSQL1 = "SELECT sol_name,unit_name,express_code FROM tb_product   WHERE product_ID = '".$objResult2["product_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL = "SELECT SUM(sum_amount) AS sum_amount,SUM(sale_count) AS sale_count FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)   WHERE product_id = '".$objResult2["product_id"]."' and price_per_unit ='".$objResult2["price_per_unit"]."' and cancel_ckk='0'";

if($iv_no !=""){ 
    $strSQL .= ' AND iv_no = "'.$iv_no.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

?>

<tr>
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="left" class="style30"><?php echo $objResult1["express_code"]; ?></td>
<td align="reft" class="style30"><?php echo $objResult1["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult["sale_count"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult1["unit_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult2["price_per_unit"]; ?></td> 
<td align="right" class="style30"><?php $price=$objResult["sum_amount"]; echo number_format( $price,2).""; ?></td> 

	</tr>





<?php
$i++;
}


$strSQL9 = "SELECT SUM(sum_amount) AS sum_amount,SUM(sale_count) AS sale_count FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)   WHERE cancel_ckk='0'";

if($iv_no !=""){ 
    $strSQL9 .= ' AND iv_no = "'.$iv_no.'"'; 
}


$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);
$objResult9 = mysqli_fetch_array($objQuery9);
$total1 =$objResult9["sum_amount"];

?>

<tr>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td align="reft" class="style16">ยอดรวมทั้งหมด</td> 
<td align="right" class="style16"><?php echo $objResult9["sale_count"]; ?></td> 
<td align="right" class="style30"></td> 
<td align="right" class="style30"></td> 
<td align="right" class="style16"><?php $price=$objResult9["sum_amount"]; echo number_format( $price,2).""; ?></td> 


	</tr>


</table>
</p>

</body>
</html>