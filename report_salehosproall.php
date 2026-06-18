
<?php
include "head.php";
include "dbconnect.php";


$start_date = '2022-01-01';
$end_date = '2022-06-30';
?>
<div class="w3-white" ><br>



<center>
<h3 align="center">รายงานยอดขายตามสินค้าเตียง</h3>
<h3 align="center">ตามช่วงวันที่ <?php echo Datethai($start_date); ?>&nbsp;&nbsp;<?php echo Datethai($end_date); ?></h3><br>
	
<?php
	$strSQL33 ="SELECT distinct sale_code FROM tb__buypro WHERE sale_code LIKE '%SOL%' and group_pro = 'เตียงผู้ป่วย' ";

if($start_date !=""){ 
    $strSQL33 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL33 .= ' AND doc_date <= "'.$end_date.'"'; 
}

$objQuery33 =mysqli_query($conn,$strSQL33);
while($objResult33=mysqli_fetch_array($objQuery33)){
	
	?>

<h3 align="center"><?php echo $objResult33["sale_code"]; ?></h3>	
<table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
	 <th width="5%">ลำดับ</th>
	 <th width="15%">สินค้า</th>
	 <th width="10%">ยอดขาย</th>
	 <th width="10%">จังหวัด</th>
	 <th width="10%">รหัสลูกค้า</th>
	
	  </tr>
  </thead>
	
	<?php	
	
$strSQL ="SELECT distinct product_no,bill_id FROM tb__buypro WHERE  sale_code ='".$objResult33["sale_code"]."' and group_pro = 'เตียงผู้ป่วย'";

if($start_date !=""){ 
    $strSQL .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_date <= "'.$end_date.'"'; 
}

$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL7 ="SELECT sol_name  FROM tb_product  WHERE  product_ID = '".$objResult["product_no"]."'";
$objQuery7 =mysqli_query($conn,$strSQL7);
$objResult7 = mysqli_fetch_array($objQuery7);		
	
$strSQL8 ="SELECT cus_province  FROM tb_customer  WHERE  customer_id  = '".$objResult["bill_id"]."'";
$objQuery8 =mysqli_query($conn,$strSQL8);
$objResult8 = mysqli_fetch_array($objQuery8);	
	
$strSQL3 ="SELECT SUM(amount) as amount  FROM tb__buypro  WHERE  product_no = '".$objResult["product_no"]."'   and sale_code ='".$objResult33["sale_code"]."' and group_pro = 'เตียงผู้ป่วย'";

if($start_date !=""){ 
    $strSQL3 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND doc_date <= "'.$end_date.'"'; 
}	
	

$objQuery3 =mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);		
	
	
	
$strSQL13 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE  product_no = '".$objResult["product_no"]."' and sale_code ='".$objResult33["sale_code"]."'";

if($start_date !=""){ 
    $strSQL13 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL13 .= ' AND date_cash <= "'.$end_date.'"'; 
}	
	

$objQuery13 =mysqli_query($conn,$strSQL13);
$objResult13 = mysqli_fetch_array($objQuery13);	

	
$sum_disall1 = $objResult3["amount"]-$objResult13["amount"];


?>


     
	<tr>
<td  align="center" class="style30"><?php echo  $i; ?></td>
<td  align="left" class="style30"><?php echo $objResult7["sol_name"]; ?></td>
<td  align="left" class="style30"><?php echo  number_format($sum_disall1,2).""; ?></td> 
<td  align="left" class="style30"><?php echo $objResult8["cus_province"]; ?></td>   
<td  align="left" class="style30"><?php echo $objResult["bill_id"]; ?></td>   
    </tr>
	  
	<?php 
$i++;
} 
	

	?>
  

</table>
	<?php 
}
	?>
	
	
