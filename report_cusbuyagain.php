<?php 
include('head1.php'); 

include "dbconnect.php";

?>
<link rel="stylesheet" href="css/w33.css">
<style type="text/css">
<!--

.style15 {
	font-size: 16px; color: #000000;
}
.style16 {font-size: 15px; color: #FF0000;}
.style17 {font-size: 18px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #CC0066; font-size: 14px; }
.style38 {font-size: 14px; color: #FF0000;}
.style39 {font-size: 14px; color: #339900;}
.style40 {font-size: 14px; color: #3333CC; }
-->

</style>

<?php
function DateThai($strDate)
	{
		$strYear1 = date("Y",strtotime($strDate))+543;
		$strYear = substr($strYear1, 2 ,2);
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
?>

<?php

date_default_timezone_set("Asia/Bangkok");
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];

/*$start_date = "2020-01-01";
$end_date = "2022-08-01";*/


$time = date('H:i:s');

?>
<body>

<div class="w3-container w3-padding-large">

<center>
<b><h3>รายงานลูกค้าซื้อซ้ำของสมาชิก Allwell</h3></b>

<h4><?php echo Datethai($start_date); ?> ถึง <?php echo Datethai($end_date); ?></h4>
</center>

<?php

$strSQL8 = "SELECT DISTINCT bill_id  FROM  (tb__buypro LEFT JOIN tb_customer ON tb__buypro.bill_id=tb_customer.customer_id)  WHERE tb__buypro.sale_code LIKE '%SOL%' and customer_no !=''";

if($start_date !=""){ 

    $strSQL8 .= ' AND doc_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL8 .= ' AND doc_date <= "'.$end_date.'"'; 
}

	$strSQL8 .= 'GROUP BY ref_id HAVING COUNT(ref_id) >= "2"';  
	
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows8 = mysqli_num_rows($objQuery8);
//echo $strSQL8;
while($objResult8 = mysqli_fetch_array($objQuery8))
{
	
$strSQL5 = "SELECT first_name,last_name,status_cus,customer_no  FROM tb_customer   WHERE customer_id ='".$objResult8["bill_id"]."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");	
$objResult5 = mysqli_fetch_array($objQuery5);	
	
	
	$strSQL = "SELECT DISTINCT ref_id FROM tb__buypro where bill_id ='".$objResult8["bill_id"]."'  ";

	if($start_date !=""){ 
    $strSQL .= ' AND doc_date >= "'.$start_date.'"'; 
     }

if($end_date !=""){ 
    $strSQL .= ' AND doc_date <= "'.$end_date.'"'; 

}

 $strSQL .= 'ORDER BY doc_date ASC'; 
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");	
$Num_Rows = mysqli_num_rows($objQuery);	
if($Num_Rows >='2'){	
?>
<h4>คุณ <?php echo $objResult5["first_name"]; ?> <?php echo $objResult5["last_name"]; ?> รหัสสมาชิก : <?php echo $objResult6["customer_no"]; ?> สถานะ :  <?php if($objResult5["status_cus"]=='0'){ echo "Gold Customer"; }else if($objResult5["status_cus"]=='1'){ echo "Platinum Customer";  }else if($objResult5["status_cus"]=='2'){ echo "Daimond Customer";  } ?></h4>
	
<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">ลำดับ</td >
			<td width="5%">เลขที่อ้างอิง</td>
			<td width="8%">เลขที่เอกสาร</td>
			<td width="8%">วันที่ออกบิล</td>
			<td width="10%">ชื่อออกบิล</td>
			<td width="15%">รายการสินค้า</td>
			<td width="8%">จำนวน</td>
			<td width="8%">ราคารวม</td>
			<td width="8%">ยอดรวม</td>
			
		</thead>
		
<?php
$i=1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
	
$strSQL9 = "SELECT doc_no,doc_date,customer  FROM tb__buypro  WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery9 = mysqli_query($conn,$strSQL9) or die(mysqli_error());
$objResult9 = mysqli_fetch_array($objQuery9);
	
	
	?>
	<tr>
			<td><div align="center"><?php echo $i; ?></div></td >
			<td><?php echo $objResult["ref_id"]; ?></td>
			<td><?php echo $objResult9["doc_no"]; ?></td>
			<td><?php echo Datethai($objResult9["doc_date"]); ?></td>
			<td><?php echo $objResult9["customer"]; ?></td>
			<td>
		<div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE ref_id = '".$objResult["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br />
<?php
}
?>
</div>
		
		</td>
			<td>
		
		<div align="right">
<?php
$strSQL11 = "SELECT unit_name,count FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) WHERE ref_id = '".$objResult["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);

while($objResult11 = mysqli_fetch_array($objQuery11))
{
?>
<?php echo $objResult11["count"]; ?> <?php echo $objResult11["unit_name"]; ?> <br>
<?php
}
?>
</div>
		
		</td>
			<td>
		
		<div align="right">
<?php
$strSQL4 = "SELECT amount FROM tb__buypro  WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);

while($objResult4 = mysqli_fetch_array($objQuery4))
{
?>
<?php
	echo number_format($objResult4["amount"],2).""; 
	?><br>
<?php
}
?>
</div>
		
		</td>
			<td>

			<div align="right">
<?php
$strSQL2 = "SELECT SUM(amount) As amount  FROM tb__buypro  WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

	echo number_format($objResult2["amount"],2).""; 
	
?>
</div>
		
		</td>
			
		</tr>
	
	
	
	<?php 
$i++;
} ?>
	
	
<tr>
			<td></td >
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>ยอดรวม</td>
			<td>

			<div align="right">
<?php
$strSQL12 = "SELECT SUM(amount) As amount  FROM tb__buypro  WHERE bill_id = '".$objResult8["bill_id"]."' ";
	if($start_date !=""){ 
    $strSQL12 .= ' AND doc_date >= "'.$start_date.'"'; 
     }

if($end_date !=""){ 
    $strSQL12 .= ' AND doc_date <= "'.$end_date.'"'; 

}

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);

	echo number_format($objResult12["amount"],2).""; 
	
?>
</div>
		
		</td>
			
		</tr>
		
	
	

</table>	
<br>
<?php
}
}
	
	  ?>




</div>
</body>
</html>