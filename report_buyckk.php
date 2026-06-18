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

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$h_product_code = $_GET["h_product_code"];
$group1 = $_GET["group1"];

include"dbconnect.php";

?>
<body>



<div class="w3-container w3-padding-large">

<center>
<h4>รายงานลูกค้าซื้อซ้ำ</h4>

<h4><?php echo Datethai($start_date); ?> ถึง<?php echo Datethai($end_date); ?></h4>
<?php if($group1!=''){ ?><h4><?php echo $group1; ?></h4> <?php } ?>
</center>


</p>
			



	



<?php

	
		
	

$strSQL8 = "SELECT DISTINCT bill_id  FROM  tb__buycustomer    WHERE sale_code LIKE '%SOL%'";

if($start_date !=""){ 

    $strSQL8 .= ' AND doc_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL8 .= ' AND doc_date <= "'.$end_date.'"'; 
}
	
if($group1 !=''){	
	$strSQL8 .= ' AND group_pro = "'.$group1.'"'; 
	
		}	
	
if($h_product_code !=''){	
	$strSQL8 .= ' AND product_no = "'.$h_product_code.'"'; 
	
		}		
	
	$strSQL8 .= 'GROUP BY bill_id HAVING COUNT(bill_id) >= "2"';  
	
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows8 = mysqli_num_rows($objQuery8);

while($objResult8 = mysqli_fetch_array($objQuery8))
{

$strSQL7 = "SELECT bill_name,customer_no,type_customer,status_cus  FROM tb_customer    WHERE  customer_id ='".$objResult8["bill_id"]."'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);
$objResult7 = mysqli_fetch_array($objQuery7);
?>	
<span class="style15"><font color="blue"><?php echo $objResult7["bill_name"]; ?> <?php if($objResult7["customer_no"]!=''){ ?> รหัสบัตรสมาชิก  <?php echo $objResult7["customer_no"]; ?>  <?php if($objResult7["status_cus"]!=''){ ?> สถานะ <?php if($objResult7["status_cus"]=='0'){ echo "Gold Customer";
		 }else if($objResult7["status_cus"]=='1'){ 
				echo "Platinum Customer";
	 }else if($result3["status_cus"]=='2'){ 
				echo "Daimond Customer";
			
}	 } } 
		?> </font></span><br>	
	<table border= "1" width="100%" class='w3-table'>
<tr>

<td width="10%" align="center" class="style30">วันที่ออกบิล</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="20%" align="center" class="style30">รายการสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดรวม</td> 
</tr>
<?php
$strSQL5 = "SELECT DISTINCT ref_id  FROM tb__buycustomer   WHERE  bill_id ='".$objResult8["bill_id"]."'";

if($start_date !=""){ 

    $strSQL5 .= ' AND doc_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL5 .= ' AND doc_date <= "'.$end_date.'"'; 

}
	
if($group1 !=''){	
	$strSQL5 .= ' AND group_pro = "'.$group1.'"'; 
	
		}	
	
if($h_product_code !=''){	
	$strSQL5 .= ' AND product_no = "'.$h_product_code.'"'; 
	
		}		
	
$strSQL5 .=" order  by doc_date ASC ";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);
while($objResult5 = mysqli_fetch_array($objQuery5))
{	

$strSQL12 = "SELECT doc_date,doc_no  FROM tb__buycustomer    WHERE  ref_id ='".$objResult5["ref_id"]."'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	
$strSQL3 = "SELECT SUM(amount) AS amount FROM tb__buycustomer    WHERE  ref_id ='".$objResult5["ref_id"]."'";
if($group1 !=''){	
	$strSQL3 .= ' AND group_pro = "'.$group1.'"'; 
	
		}
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);	
?>
	
	
	<tr>
<td  class="style30"><div align="center"><?php echo Datethai($objResult12["doc_date"]); ?></div></td>
<td  align="center" class="style30"><?php echo $objResult12["doc_no"]; ?></td> 

<td align="left" class="style30">

<?php
$strSQL1 = "SELECT sol_name FROM (tb__buycustomer LEFT JOIN tb_product ON tb__buycustomer.product_no=tb_product.product_ID) WHERE ref_id = '".$objResult5["ref_id"]."' ";
if($group1 !=''){	
	$strSQL1 .= ' AND group_pro = "'.$group1.'"'; 
	
		}		
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br>
<?php
}
?>
</td> 
<td align="right" class="style30">

<?php
$strSQL2 = "SELECT count,unit_name FROM (tb__buycustomer LEFT JOIN tb_product ON tb__buycustomer.product_no=tb_product.product_ID) WHERE ref_id = '".$objResult5["ref_id"]."' ";
if($group1 !=''){	
	$strSQL2 .= ' AND group_pro = "'.$group1.'"'; 
	
		}			
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>
<?php	echo $objResult2["count"]; 	?>
<?php	echo $objResult2["unit_name"]; 	?>
	<br>
<?php
}
?>
</td>		
		
		
<td  class="style30"><div align="right"><?php echo number_format($objResult3["amount"],2).""; ?></div></td> 
</tr>

<?php  } ?>
</table>	<br><br>
	<?php 	}	?>




</div>
</body>
</html>