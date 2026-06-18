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

$date = explode('-' , $_GET["start_date"] );
$newDate = $date[2].'-'.$date[1].'-'.$date[0];


$date1 = explode('-' , $_GET["end_date"] );
$newDate1 = $date1[2].'-'.$date1[1].'-'.$date1[0];


?>
<center>
<span class="style15">รายงานสรุปตามวันที่</span></p>
<span class="style15"><?php echo $newDate; ?> - <?php echo $newDate1; ?></span></p>

</center>


<?php


	$sql = "SELECT distinct sale_channel FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $sql .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql .= ' AND register_date <= "'.$end_date.'"'; 
}

if($h_product_code !=""){ 
    $sql .= ' AND product_code = "'.$h_product_code.'"'; 
}

$query = mysqli_query($conn,$sql) or die(mysqli_error());



	while($result = mysqli_fetch_array($query)){




$sale_channel =$result["sale_channel"];

$sqlchannel = "select salechannel_nameshort,salechannel_name from tb_salechannel where salechannel_ID='".$sale_channel."'";
$querychannel = mysqli_query($conn,$sqlchannel);
$fetchchannel = mysqli_fetch_array($querychannel);

$salechannel_nameshort = $fetchchannel["salechannel_nameshort"];
$salechannel_name      = $fetchchannel["salechannel_name"];
$sum_salechannel       = "$salechannel_nameshort $salechannel_name";

	
?>

</p><span class="style15">ช่องทางการขาย :  <?php echo $sum_salechannel; ?> </span></p>


		
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่ </td>
<td width="8%" align="center" class="style30">ID </td>
<td width="10%" align="center" class="style30">หมายเลขคำสั่งซื้อ </td>
<td width="15%" align="center" class="style30">ชื่อลูกค้า </td>
<td width="15%" align="center" class="style30">รายการสินค้า </td>
<td width="5%" align="center" class="style30">จำนวน </td>
<td width="8%" align="center" class="style30">ราคา </td>
<td width="8%" align="center" class="style30">รวมเป็นเงิน </td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร </td>
<td width="15%" align="center" class="style30">การจัดส่ง </td>



</tr>



<?php

$sql1 = "SELECT * FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' ";
	


	if($start_date !=""){ 
    $sql1 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql1 .= ' AND register_date <= "'.$end_date.'"'; 
}
		
if($h_product_code !=""){ 
    $sql1 .= ' AND product_code = "'.$h_product_code.'"'; 
}
//echo $sql1;
//exit();

$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());



	while($result1 = mysqli_fetch_array($query1)){

$register_date = Datethai($result1["register_date"]);
$ref_id=$result1["ref_id"];
$order_id=$result1["order_id"];
$customer_name=$result1["customer_name"];

$sale_count=$result1["sale_count"];
$price_per_unit1=$result1["price_per_unit"];

$price_per_unit= number_format( $price_per_unit1,2)."";

$sum_amount1=$result1["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";
$product_code=$result1["product_code"];
$doc_no=$result1["doc_no"];
$delivery_name=$result1["delivery_name"];

$sqlchannel1 = "select sol_name from tb_product where product_ID='".$product_code."'";
$querychannel1 = mysqli_query($conn,$sqlchannel1);
$fetchchannel1 = mysqli_fetch_array($querychannel1);


$product_name=$fetchchannel1["sol_name"];
?>

<tr>
<td align="center" class="style30"><?php echo $register_date; ?></td>
<td align="center" class="style30"><?php echo $ref_id; ?> </td>
<td align="center" class="style30"><?php echo $order_id; ?> </td>
<td align="center" class="style30"><?php echo $customer_name; ?> </td>
<td align="left" class="style30"><?php echo $product_name; ?> </td>
<td align="center" class="style30"><?php echo $sale_count; ?> </td>
<td align="right" class="style30"><?php echo $price_per_unit; ?> </td>
<td align="right" class="style30"><?php echo $sum_amount; ?> </td>
<td align="center" class="style30"><?php echo $doc_no; ?> </td>
<td align="center" class="style30"><?php echo $delivery_name; ?> </td>



</tr>

<?php
	}


	

$strSQL1 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' ";
	


	if($start_date !=""){ 
    $strSQL1 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND register_date <= "'.$end_date.'"'; 
}
		
if($h_product_code !=""){ 
    $strSQL1 .= ' AND product_code = "'.$h_product_code.'"'; 
}		
		
//echo $strSQL1;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1= mysqli_fetch_array($objQuery1);

$summary_1=$objResult1['amount_1'];
$summary= number_format( $summary_1,2)."";


$strSQL2 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' ";
	


	if($start_date !=""){ 
    $strSQL2 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND register_date <= "'.$end_date.'"'; 
}

if($h_product_code !=""){ 
    $strSQL2 .= ' AND product_code = "'.$h_product_code.'"'; 
}	

//echo $strSQL1;
//exit();
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2= mysqli_fetch_array($objQuery2);


$sale_count1=$objResult2['sale_count'];
$sale_count= number_format( $sale_count1,2)."";



?>
<tr>
<td align="center" class="style30"></td>
<td align="center" class="style30"> </td>
<td align="center" class="style30"></td>
<td align="center" class="style30"></td>
<td align="left" class="style30">รวมตามช่องทางการขาย</td>
<td align="center" class="style30"><?php echo $sale_count; ?> </td>
<td align="right" class="style30"> </td>
<td align="right" class="style30"><?php echo $summary; ?> </td>
<td align="center" class="style30"> </td>
<td align="center" class="style30"> </td>



</tr>
</table>


<?

	
	}

$strSQL3 = "SELECT SUM(sale_count) AS sale_count_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $strSQL3 .= ' AND register_date >= "'.$start_date.'"'; 
	}

	if($end_date !=""){ 
    $strSQL3 .= ' AND register_date <= "'.$end_date.'"'; 
	}

if($h_product_code !=""){ 
    $strSQL3 .= ' AND product_code = "'.$h_product_code.'"'; 
}	

//echo $strSQL3;
//exit();

	$objQuery3 = mysqli_query($conn,$strSQL3);
	$objResult3= mysqli_fetch_array($objQuery3);

	$sale_count2=$objResult3['sale_count_1'];
	$sale_count_2= number_format( $sale_count2,2)."";


$strSQL4 = "SELECT SUM(sum_amount) AS amount_2 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $strSQL4 .= ' AND register_date >= "'.$start_date.'"'; 
	}

	if($end_date !=""){ 
    $strSQL4 .= ' AND register_date <= "'.$end_date.'"'; 
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
<td width="10%" align="center" class="style30"></td>
<td  width="8%" align="center" class="style30"> </td>
<td width="10%" align="center" class="style30"></td>
<td width="15%" align="center" class="style30"></td>
<td width="15%" align="left" class="style30">รวมทั้งหมด</td>
<td width="5%" align="center" class="style30"><?php echo $sale_count_2; ?> </td>
<td width="8%" align="right" class="style30"> </td>
<td width="8%" align="right" class="style30"><?php echo $amount_23; ?> </td>
<td width="10%" align="center" class="style30"> </td>
<td width="15%" align="center" class="style30"> </td>


</tr>
</table>
</p></p>
