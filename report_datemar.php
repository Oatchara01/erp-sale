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
$h_product_code = $_GET["h_product_code"];
$sale_channel = $_GET["sale_channel"];
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
if($h_product_code !='' and $sale_channel ==''){

	$sql1 ="SELECT salechannel_ID,salechannel_nameshort,salechannel_name  FROM tb_salechannel  WHERE ckk = '1'  ";
$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());
	
while($result1 = mysqli_fetch_array($query1)){
	
$sale_channel =$result1["salechannel_ID"];
$salechannel_nameshort = $result1["salechannel_nameshort"];
$salechannel_name      = $result1["salechannel_name"];
$sum_salechannel       = "$salechannel_nameshort";

	
?>

</p><span class="style15">ช่องทางการขาย :  <?php echo $sum_salechannel; ?> </span></p>

<table border= "1" width="100%" class='w3-table'>

<tr>
<td width="20%" align="center" class="style30">รหัสสินค้า </td>
<td width="20%" align="center" class="style30">ชื่อสินค้า </td>
<td width="10%" align="center" class="style30">จำนวน </td>
<td width="10%" align="center" class="style30">รวมเป็นเงิน </td>



</tr>

		


<?php	

$strSQL1 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


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


$strSQL2 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $strSQL2 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND register_date <= "'.$end_date.'"'; 
}

if($h_product_code !=""){ 
    $strSQL2 .= ' AND product_code = "'.$h_product_code.'"'; 
}	

//echo $strSQL2;
//exit();
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2= mysqli_fetch_array($objQuery2);


$sale_count1=$objResult2['sale_count'];
$sale_count= number_format( $sale_count1,2)."";

$sqlchannel1 = "select access_name,access_code from tb_product where product_ID='".$h_product_code."'";
$querychannel1 = mysqli_query($conn,$sqlchannel1);
$fetchchannel1 = mysqli_fetch_array($querychannel1);


?>

<tr>

<td align="left" class="style30"><?php echo $fetchchannel1["access_code"]; ?></td>
<td align="center" class="style30"><?php echo $fetchchannel1["access_name"]; ?></td>
<td align="right" class="style30"> <?php echo $sale_count; ?></td>
<td align="right" class="style30"><?php echo $summary; ?> </td>



</tr>
</table>


<?

	
	}

$strSQL3 = "SELECT SUM(sale_count) AS sale_count_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where  cancel_ckk = '0' and doc_no NOT LIKE '%BRN%' ";
	


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


$strSQL4 = "SELECT SUM(sum_amount) AS amount_2 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where  cancel_ckk = '0' and doc_no NOT LIKE '%BRN%' ";
	


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

<td width="20%" align="left" class="style30">รวมทั้งหมด</td>
<td width="20%" align="right" class="style30"> </td>
<td width="10%" align="right" class="style30"><?php echo $sale_count_2; ?> </td>
<td width="10%" align="right" class="style30"><?php echo $amount_23; ?> </td>


</tr>
</table> 
	<?
}else if($h_product_code !='' and $sale_channel !=''){

	



$sale_channel =$_GET["sale_channel"];

$sqlchannel = "select salechannel_nameshort,salechannel_name from tb_salechannel where salechannel_ID='".$sale_channel."'";
$querychannel = mysqli_query($conn,$sqlchannel);
$fetchchannel = mysqli_fetch_array($querychannel);

$salechannel_nameshort = $fetchchannel["salechannel_nameshort"];
$salechannel_name      = $fetchchannel["salechannel_name"];
$sum_salechannel       = "$salechannel_nameshort";

	
?>

</p><span class="style15">ช่องทางการขาย :  <?php echo $sum_salechannel; ?> </span></p>

<table border= "1" width="100%" class='w3-table'>

<tr>
<td width="20%" align="center" class="style30">รหัสสินค้า </td>
<td width="20%" align="center" class="style30">ชื่อสินค้า </td>
<td width="10%" align="center" class="style30">จำนวน </td>
<td width="10%" align="center" class="style30">รวมเป็นเงิน </td>



</tr>

		


<?php	

$strSQL1 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


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


$strSQL2 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $strSQL2 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND register_date <= "'.$end_date.'"'; 
}

if($h_product_code !=""){ 
    $strSQL2 .= ' AND product_code = "'.$h_product_code.'"'; 
}	

//echo $strSQL2;
//exit();
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2= mysqli_fetch_array($objQuery2);


$sale_count1=$objResult2['sale_count'];
$sale_count= number_format( $sale_count1,2)."";

$sqlchannel1 = "select access_name,access_code from tb_product where product_ID='".$h_product_code."'";
$querychannel1 = mysqli_query($conn,$sqlchannel1);
$fetchchannel1 = mysqli_fetch_array($querychannel1);


?>

<tr>

<td align="left" class="style30"><?php echo $fetchchannel1["access_code"]; ?></td>
<td align="center" class="style30"><?php echo $fetchchannel1["access_name"]; ?></td>
<td align="right" class="style30"> <?php echo $sale_count; ?></td>
<td align="right" class="style30"><?php echo $summary; ?> </td>



</tr>
</table>




	

	<?
}else if($h_product_code =='' and $sale_channel !=''){

	



$sale_channel =$_GET["sale_channel"];

$sqlchannel = "select salechannel_nameshort,salechannel_name from tb_salechannel where salechannel_ID='".$sale_channel."'";
$querychannel = mysqli_query($conn,$sqlchannel);
$fetchchannel = mysqli_fetch_array($querychannel);

$salechannel_nameshort = $fetchchannel["salechannel_nameshort"];
$salechannel_name      = $fetchchannel["salechannel_name"];
$sum_salechannel       = "$salechannel_nameshort";

	
?>

</p><span class="style15">ช่องทางการขาย :  <?php echo $sum_salechannel; ?> </span></p>

<table border= "1" width="100%" class='w3-table'>

<tr>
<td width="20%" align="center" class="style30">รหัสสินค้า </td>
<td width="20%" align="center" class="style30">ชื่อสินค้า </td>
<td width="10%" align="center" class="style30">จำนวน </td>
<td width="10%" align="center" class="style30">รวมเป็นเงิน </td>



</tr>

		


<?php	

$sql = "SELECT distinct product_code FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where   cancel_ckk = '0'  and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $sql .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql .= ' AND register_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $sql .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

//echo $sql;
	//exit();
$query = mysqli_query($conn,$sql) or die(mysqli_error());



	while($result = mysqli_fetch_array($query)){

$h_product_code = $result["product_code"];



$strSQL3 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $strSQL3 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND register_date <= "'.$end_date.'"'; 
}
		
if($h_product_code !=""){ 
    $strSQL3 .= ' AND product_code = "'.$h_product_code.'"'; 
}	

		
//echo $strSQL1;
//exit();
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3= mysqli_fetch_array($objQuery3);

$summary_3=$objResult3['amount_1'];
$summary3= number_format( $summary_3,2)."";


$strSQL4 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $strSQL4 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL4 .= ' AND register_date <= "'.$end_date.'"'; 
}

if($h_product_code !=""){ 
    $strSQL4 .= ' AND product_code = "'.$h_product_code.'"'; 
}	

//echo $strSQL1;
//exit();
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4= mysqli_fetch_array($objQuery4);


$sale_count4=$objResult4['sale_count'];
$sale_coun4= number_format( $sale_count4,2)."";

$sqlchannel1 = "select access_name,access_code from tb_product where product_ID='".$h_product_code."'";
$querychannel1 = mysqli_query($conn,$sqlchannel1);
$fetchchannel1 = mysqli_fetch_array($querychannel1);
?>


<tr>

<td align="left" class="style30"><?php echo $fetchchannel1["access_code"]; ?></td>
<td align="center" class="style30"><?php echo $fetchchannel1["access_name"]; ?></td>
<td align="right" class="style30"> <?php echo $sale_coun4; ?></td>
<td align="right" class="style30"><?php echo $summary3; ?> </td>



</tr>


<?php
	}



$strSQL1 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $strSQL1 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND register_date <= "'.$end_date.'"'; 
}
		
		
//echo $strSQL1;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1= mysqli_fetch_array($objQuery1);

$summary_1=$objResult1['amount_1'];
$summary= number_format( $summary_1,2)."";


$strSQL2 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $strSQL2 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND register_date <= "'.$end_date.'"'; 
}

	

//echo $strSQL1;
//exit();
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2= mysqli_fetch_array($objQuery2);


$sale_count1=$objResult2['sale_count'];
$sale_count= number_format( $sale_count1,2)."";


?>

<tr>

<td align="left" class="style30"><?php echo "รวมช่องทางการขาย"; ?></td>
<td align="center" class="style30"></td>
<td align="right" class="style30"> <?php echo $sale_count; ?></td>
<td align="right" class="style30"><?php echo $summary; ?> </td>



</tr>
</table>




	

	<?
}else if($h_product_code =='' and $sale_channel ==''){

	

$sql1 ="SELECT salechannel_ID,salechannel_nameshort,salechannel_name  FROM tb_salechannel  WHERE ckk = '1'  ";
$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());
while($result1 = mysqli_fetch_array($query1)){
$sale_channel =$result1["salechannel_ID"];
$salechannel_nameshort = $result1["salechannel_nameshort"];
$salechannel_name      = $result1["salechannel_name"];
$sum_salechannel       = "$salechannel_nameshort";

	
?>

</p><span class="style15">ช่องทางการขาย :  <?php echo $sum_salechannel; ?> </span></p>

<table border= "1" width="100%" class='w3-table'>

<tr>
<td width="20%" align="center" class="style30">รหัสสินค้า </td>
<td width="20%" align="center" class="style30">ชื่อสินค้า </td>
<td width="10%" align="center" class="style30">จำนวน </td>
<td width="10%" align="center" class="style30">รวมเป็นเงิน </td>



</tr>

		


<?php	

$sql = "SELECT distinct product_code FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where  cancel_ckk = '0'  and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $sql .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql .= ' AND register_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $sql .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

$query = mysqli_query($conn,$sql) or die(mysqli_error());



	while($result = mysqli_fetch_array($query)){

$h_product_code = $result["product_code"];



$strSQL3 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $strSQL3 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND register_date <= "'.$end_date.'"'; 
}
		
if($h_product_code !=""){ 
    $strSQL3 .= ' AND product_code = "'.$h_product_code.'"'; 
}	

		
//echo $strSQL1;
//exit();
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3= mysqli_fetch_array($objQuery3);

$summary_3=$objResult3['amount_1'];
$summary3= number_format( $summary_3,2)."";


$strSQL4 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $strSQL4 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL4 .= ' AND register_date <= "'.$end_date.'"'; 
}

if($h_product_code !=""){ 
    $strSQL4 .= ' AND product_code = "'.$h_product_code.'"'; 
}	

//echo $strSQL1;
//exit();
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4= mysqli_fetch_array($objQuery4);


$sale_count4=$objResult4['sale_count'];
$sale_coun4= number_format( $sale_count4,2)."";

$sqlchannel1 = "select access_name,access_code from tb_product where product_ID='".$h_product_code."'";
$querychannel1 = mysqli_query($conn,$sqlchannel1);
$fetchchannel1 = mysqli_fetch_array($querychannel1);
?>


<tr>

<td align="left" class="style30"><?php echo $fetchchannel1["access_code"]; ?></td>
<td align="center" class="style30"><?php echo $fetchchannel1["access_name"]; ?></td>
<td align="right" class="style30"> <?php echo $sale_coun4; ?></td>
<td align="right" class="style30"><?php echo $summary3; ?> </td>



</tr>


<?php
	}



$strSQL1 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $strSQL1 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND register_date <= "'.$end_date.'"'; 
}
		
		
//echo $strSQL1;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1= mysqli_fetch_array($objQuery1);

$summary_1=$objResult1['amount_1'];
$summary= number_format( $summary_1,2)."";


$strSQL2 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."'  and cancel_ckk = '0' and doc_no NOT LIKE '%BRN%'";
	


	if($start_date !=""){ 
    $strSQL2 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND register_date <= "'.$end_date.'"'; 
}

	

//echo $strSQL1;
//exit();
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2= mysqli_fetch_array($objQuery2);


$sale_count1=$objResult2['sale_count'];
$sale_count= number_format( $sale_count1,2)."";


?>

<tr>

<td align="left" class="style30"><?php echo "รวมช่องทางการขาย"; ?></td>
<td align="center" class="style30"></td>
<td align="right" class="style30"> <?php echo $sale_count; ?></td>
<td align="right" class="style30"><?php echo $summary; ?> </td>



</tr>
</table>

<?php
	}

$strSQL3 = "SELECT SUM(sale_count) AS sale_count_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where  cancel_ckk = '0' and doc_no NOT LIKE '%BRN%' ";
	

if($start_date !=""){ 
    $strSQL3 .= ' AND register_date >= "'.$start_date.'"'; 
	}

if($end_date !=""){ 
    $strSQL3 .= ' AND register_date <= "'.$end_date.'"'; 
	}


	$objQuery3 = mysqli_query($conn,$strSQL3);
	$objResult3= mysqli_fetch_array($objQuery3);

	$sale_count2=$objResult3['sale_count_1'];
	$sale_count_2= number_format($sale_count2,2)."";


$strSQL4 = "SELECT SUM(sum_amount) AS amount_2 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where  cancel_ckk = '0' and doc_no NOT LIKE '%BRN%' ";
	


	if($start_date !=""){ 
    $strSQL4 .= ' AND register_date >= "'.$start_date.'"'; 
	}

	if($end_date !=""){ 
    $strSQL4 .= ' AND register_date <= "'.$end_date.'"'; 
	}



	$objQuery4 = mysqli_query($conn,$strSQL4);
	$objResult4= mysqli_fetch_array($objQuery4);

	$amount_2=$objResult4['amount_2'];
	$amount_23= number_format( $amount_2,2)."";

?>

<table border= "1" width="100%" class='w3-table'>
	
<tr>

<td width="20%" align="left" class="style30">รวมทั้งหมด</td>
<td width="20%" align="right" class="style30"> </td>
<td width="10%" align="right" class="style30"><?php echo $sale_count_2; ?> </td>
<td width="10%" align="right" class="style30"><?php echo $amount_23; ?> </td>


</tr>
</table> 
	

	<?
} 
?>
</p></p>
