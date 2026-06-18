
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 16px; color: #FF0000;}
.style17 {font-size: 14px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 16px; color: #000000;}
.style40 {font-size: 15px; color: #000000; }
-->




</style>
<?php


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

include"dbconnect.php";
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];
$h_product_code =$_GET["h_product_code"];


$newDate = DateThai($_GET["start_date"]);
?>
<center>
<span class="style15"><?php echo "รายงานสรุปตามวันที่"; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $newDate; ?></span>
</center> 
	<?php
	$sql = "SELECT  salechannel_nameshort,salechannel_ID,salechannel_name FROM tb_salechannel  where ckk ='1' ";

$query = mysqli_query($conn,$sql) or die(mysqli_error());

	while($result = mysqli_fetch_array($query)){



$salechannel_nameshort=$result["salechannel_nameshort"];
$sale_channel =$result["salechannel_ID"];
$salechannel_name = $result["salechannel_name"];
$sum_salechannel = "$salechannel_nameshort $salechannel_name";
?>
</p></p>
	<span class="style16"><?php echo "ช่องทางการขาย"; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sum_salechannel; ?></span></p>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="5%" align="center" class="style30">ID</td>
<td width="10%" align="center" class="style30">หมายเลขคำสั่งซื้อ</td>
<td width="15%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="20%" align="center" class="style30">รายการสินค้า</td> 
<td width="2%" align="center" class="style30">จำนวน</td> 
<td width="8%" align="center" class="style30">ราคา</td> 
<td width="8%" align="center" class="style30">รวมเป็นเงิน</td> 
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td> 
<td width="15%" align="center" class="style30">การจัดส่ง</td> 


	</tr>


	<?php

$sql1 = "SELECT register_date,billing_name,ref_id,order_id,doc_no,delivery,customer_name,sale_count,price_per_unit,sum_amount,sol_name  FROM ((so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) where sale_channel='".$sale_channel."' and cancel_ckk ='0'";
	


	if($start_date !=""){ 
    $sql1 .= ' AND register_date = "'.$start_date.'"'; 
}
		if($h_product_code !=""){ 
    $sql1 .= ' AND product_code = "'.$h_product_code.'"'; 
}



$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());



	while($result1 = mysqli_fetch_array($query1)){

$register_date=$result1["register_date"];
$ref_id=$result1["ref_id"];
$order_id=$result1["order_id"];
$access_name=$result1["sol_name"];


	$billing_name=$result1["billing_name"];
$sale_count=$result1["sale_count"];
$price_per_unit1=$result1["price_per_unit"];

$price_per_unit= number_format( $price_per_unit1,2)."";

$sum_amount1=$result1["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$doc_no=$result1["doc_no"];
$delivery=$result1["delivery"];


$sql2 = "SELECT delivery_name FROM tb_delivery where delivery_id='".$delivery."' ";
	$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
	$result2 = mysqli_fetch_array($query2);
		$delivery_name=$result2["delivery_name"];
?>

	

<tr>
<td ><?php echo Datethai($register_date);?></td>
<td ><?php echo $ref_id ;?></td>
<td ><?php echo $order_id ;?></td>
<td ><?php echo $billing_name ;?></td> 
<td ><?php echo $access_name ;?></td> 
<td align="right"><?php echo $sale_count ;?></td> 
<td align="right"><?php echo $price_per_unit ;?></td> 
<td align="right"><?php echo $sum_amount ;?></td> 
<td ><?php echo $doc_no ;?></td> 
<td ><?php echo $delivery_name ;?></td> 


	</tr>




<?php
	}
?>

	<?php

$strSQL1 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk ='0'";
	


	if($start_date !=""){ 
    $strSQL1 .= ' AND register_date = "'.$start_date.'"'; 
}

		if($h_product_code !=""){ 
    $strSQL1 .= ' AND product_code = "'.$h_product_code.'"'; 
}

		
/*if($end_date !=""){ 
    $strSQL1 .= ' AND delivery_date = "'.$end_date.'"'; 
}*/
//echo $strSQL1;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1= mysqli_fetch_array($objQuery1);

$summary_1=$objResult1['amount_1'];
$summary= number_format( $summary_1,2)."";


$strSQL2 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk ='0'";
	


	if($start_date !=""){ 
    $strSQL2 .= ' AND register_date = "'.$start_date.'"'; 
}

		if($h_product_code !=""){ 
    $strSQL2 .= ' AND product_code = "'.$h_product_code.'"'; 
}
		
/*if($end_date !=""){ 
    $strSQL2 .= ' AND delivery_date = "'.$end_date.'"'; 
}*/
//echo $strSQL1;
//exit();
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2= mysqli_fetch_array($objQuery2);


$sale_count1=$objResult2['sale_count'];
$sale_count= number_format( $sale_count1,2)."";
?>


<tr>
<td >รวมตามช่องทางการขาย</td>
<td ></td>
<td ></td>
<td ></td> 
<td ></td> 
<td ><?php echo $sale_count; ?></td> 
<td ></td> 
<td ><?php echo $summary; ?><?php echo "บาท"; ?></td> 
<td ></td> 
<td ></td> 


	</tr>
		</table>

<?php

	}

?>
<?php
$strSQL3 = "SELECT SUM(sale_count) AS sale_count_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where  cancel_ckk ='0' ";
	


	if($start_date !=""){ 
    $strSQL3 .= ' AND register_date = "'.$start_date.'"'; 
	}

if($h_product_code !=""){ 
    $strSQL3 .= ' AND product_code = "'.$h_product_code.'"'; 
}



	$objQuery3 = mysqli_query($conn,$strSQL3);
	$objResult3= mysqli_fetch_array($objQuery3);

	$sale_count2=$objResult3['sale_count_1'];
	$sale_count_2= number_format( $sale_count2,2)."";


$strSQL4 = "SELECT SUM(sum_amount) AS amount_2 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where   cancel_ckk ='0' ";
	


	if($start_date !=""){ 
    $strSQL4 .= ' AND register_date = "'.$start_date.'"'; 
	}

if($h_product_code !=""){ 
    $strSQL4 .= ' AND product_code = "'.$h_product_code.'"'; 
}



	$objQuery4 = mysqli_query($conn,$strSQL4);
	$objResult4= mysqli_fetch_array($objQuery4);

	$amount_2=$objResult4['amount_2'];
	$amount_23= number_format( $amount_2,2)."";

	

	?>
<table border= "1" width="100%" class='w3-table'>	
<tr>
<td class="style16" width="100%" align="center" >รวมทั้งหมด &nbsp;&nbsp; จำนวน &nbsp;&nbsp;<?php echo $sale_count_2; ?>&nbsp;&nbsp; ชิ้น &nbsp;&nbsp;ยอดเงิน &nbsp;&nbsp; <?php echo $amount_23; ?> &nbsp;&nbsp; <?php echo "บาท"; ?></td>

	</tr>
	</table>
