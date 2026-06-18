<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
.style17 {font-size: 18px; color: #3333FF;}
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
$payment = $_GET["payment"];
$h_product_code = $_GET["h_product_code"];
$sale_code = $_GET["sale_code"];

include"dbconnect.php";
include "dbconnect_sale.php";




?>
<body>



<center>
<span class="style15">รายงานยอดขายประจำวัน</span></p>

<span class="style15"><?php echo Datethai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo Datethai($end_date); ?></span><br>


</center>
</p>

</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่ออกเอกสาร</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="12%" align="center" class="style30">ช่องทางการขาย</td> 
<td width="12%" align="center" class="style30">หมายเลขคำสั่งซื้อ</td>
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">การชำระเงิน</td> 
<td width="15%" align="center" class="style30">รายการสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td>
<td width="10%" align="center" class="style30">ยอดรวม</td> 
	</tr>





<?php

$sql1 = "SELECT doc_release_date,order_id,doc_no,iv_no,sale_channel,payment,access_name,billing_name,sum_amount,sale_count,unit_name  FROM ((so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) where approve_complete = 'Approve' and  cancel_ckk = '0'  ";
	


if($start_date !=""){ 
    $sql1 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql1 .= ' AND register_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $sql1 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

if($payment !=""){ 
    $sql1 .= ' AND payment = "'.$payment.'"'; 
}
	
if($sale_code !=""){ 
    $sql1 .= ' AND employee_name = "'.$sale_code.'"'; 
}


if($h_product_code !=""){ 
    $sql1 .= ' AND product_code = "'.$h_product_code.'"'; 
}
	$sql1 .=" order  by doc_no ASC   ";

	
$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());



	while($result1 = mysqli_fetch_array($query1)){

$strSQL5 = "select payment_name,bank_name from tb_payment where payment_ID ='".$result1["payment"]."'";
$objQuery5 = mysqli_query($conn,$strSQL5);
$objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC);

$sqlchannel = "select salechannel_nameshort from tb_salechannel where salechannel_ID ='".$result1["sale_channel"]."'";
$querychannel = mysqli_query($conn,$sqlchannel);
$fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC);
?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["doc_no"]; ?> </td>
<td  align="center" class="style30"><?php echo  $fetchchannel["salechannel_nameshort"]; ?></td> 
<td align="center" class="style30"><?php echo $result1["order_id"];  ?></td> 
<td align="center" class="style30"><?php echo $result1["billing_name"];  ?></td> 
<td  align="center" class="style30"><?php echo  $objResuut5["payment_name"]; ?> | <?php echo  $objResuut5["bank_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $result1["access_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $result1["sale_count"]; ?> <?php echo  $result1["unit_name"]; ?></td> 
<td  align="right" class="style30"><?php echo   number_format( $result1["sum_amount"],2).""; ?></td> 
	</tr>



<?php } ?>
	
	
	

</table>

<?php

$sql2 = "SELECT SUM(sum_amount) As sum_amount  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  where approve_complete = 'Approve' and  cancel_ckk = '0' ";
	


if($start_date !=""){ 
    $sql2 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql2 .= ' AND register_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $sql2 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

if($payment !=""){ 
    $sql2 .= ' AND payment = "'.$payment.'"'; 
}
if($sale_code !=""){ 
    $sql2 .= ' AND employee_name = "'.$sale_code.'"'; 
}
if($h_product_code !=""){ 
    $sql2 .= ' AND product_code = "'.$h_product_code.'"'; 
}


$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$result2 = mysqli_fetch_array($query2);


$sql3 = "SELECT SUM(sale_count) As sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  where approve_complete = 'Approve' and  cancel_ckk = '0' ";
	


if($start_date !=""){ 
    $sql3 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql3 .= ' AND register_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $sql3 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

if($payment !=""){ 
    $sql3 .= ' AND payment = "'.$payment.'"'; 
}
if($sale_code !=""){ 
    $sql3 .= ' AND employee_name = "'.$sale_code.'"'; 
}
if($h_product_code !=""){ 
    $sql3 .= ' AND product_code = "'.$h_product_code.'"'; 
}


$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);
		
		?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="77%" align="center" class="style16">ยอดรวมทั้งหมด</td>

<td width="10%" align="right" class="style16"><?php echo number_format( $result3["sale_count"],2).""; ?></td>
<td width="10%" align="right" class="style16"><?php echo number_format( $result2["sum_amount"],2).""; ?></td> 
	</tr>
</table>




</p>
</body>
</html>