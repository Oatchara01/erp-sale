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
$group1 = $_GET["group1"];
$time = date('H:i:s');

?>
<body>

</p>
</p>

<div class="w3-container w3-padding-large">

<center>
<h4>รายงานลูกค้าซื้อซ้ำ</h4>

<h4><?php echo Datethai($start_date); ?> ถึง<?php echo Datethai($end_date); ?></h4>
<?php if($group1!=''){ ?><h4><?php echo $group1; ?></h4> <?php } ?>
</center>


</p>
			


	
<table border= "1" width="100%" class='w3-table'>
<thead>	
<tr>
<th width="2%" align="center" class="style30">ลำดับ</th>
<th width="10%" align="center" class="style30">รหัสบัตรสมาชิก</th>
<th width="15%" align="center" class="style30">ชื่อลุกค้า</th>
<th width="10%" align="center" class="style30">ยอดสั่งซื้อ</th>
</tr>
</thead>	


<?php

	
		
	

$strSQL8 = "SELECT DISTINCT bill_id  FROM  tb__buypro    WHERE sale_code LIKE '%SOL%'";

if($start_date !=""){ 

    $strSQL8 .= ' AND doc_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL8 .= ' AND doc_date <= "'.$end_date.'"'; 
}
	
if($group1 !=''){	
	$strSQL8 .= ' AND group_pro = "'.$group1.'"'; 
	
		}	
	
	$strSQL8 .= 'GROUP BY bill_id HAVING COUNT(bill_id) >= "2"';  
	
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows8 = mysqli_num_rows($objQuery8);

while($objResult8 = mysqli_fetch_array($objQuery8))
{

$strSQL7 = "SELECT bill_name,customer_no,type_customer  FROM tb_customer    WHERE  customer_id ='".$objResult8["bill_id"]."'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);
$objResult7 = mysqli_fetch_array($objQuery7);
	

$strSQL5 = "SELECT SUM(amount) as amount  FROM tb__buypro   WHERE  bill_id ='".$objResult8["bill_id"]."'";

if($start_date !=""){ 

    $strSQL5 .= ' AND doc_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL5 .= ' AND doc_date <= "'.$end_date.'"'; 

}
	
if($group1 !=''){	
	$strSQL5 .= ' AND group_pro = "'.$group1.'"'; 
	
		}	
	
$strSQL5 .=" order  by amount DESC ";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);
$objResult5 = mysqli_fetch_array($objQuery5);	

	if($objResult7["type_customer"]=='6'){ 
	if($objResult5["amount"] !='0.00'){ $i++;
?>
	
	
	<tr>
<td  class="style30"><div align="center"><?php echo $i; ?></div></td>
<td  align="center" class="style30"><?php echo $objResult7["customer_no"]; ?></td> 
<td  align="left" class="style30"><div align="left"><a href="report_buyagain2.php?bill_id=<?php echo $objResult8["bill_id"]; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&group_1=<?php echo $group1; ?>" target="_blank"><span class="style30"><?php echo $objResult7["bill_name"]; ?></span></a></div></td>
<td  class="style30"><div align="right"><?php echo number_format($objResult5["amount"],2).""; ?></div></td> 
	

</tr>

<?php
									   
									  }
	}	

}
		
?>

</table>


</div>
</body>
</html>