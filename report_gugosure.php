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

$time = date('H:i:s');

?>
<body>

<div class="w3-container w3-padding-large">

<center>
<b><h3>รายงานลูกค้าซื้อเครื่องวัดน้ำตาล</h3></b>

<h4><?php echo Datethai($start_date); ?> ถึง <?php echo Datethai($end_date); ?></h4>
</center>

	<?php

	$strSQL6 = "SELECT DISTINCT bill_id  FROM tb__buypro where group_pro ='เครื่องวัดน้ำตาล' and product_no !='4178' and product_no !='4179'  and product_no !='4228' and product_no !='4229' and product_no !='4230' and product_no !='4293' and product_no !='4319' and product_no !='4326' and product_no !='4367' and product_no !='4449' and product_no !='4450' and product_no !='4602' and product_no !='4681' and product_no !='2637' and product_no !='2646' and product_no !='2646' and product_no !='3136' and product_no !='3166' and product_no !='3167' and product_no !='3168' and product_no !='3169' and product_no !='3170' and product_no !='3171' and product_no !='4213' and product_no !='4235' and product_no !='4274' and type_arae='2'";

	if($start_date !=""){ 
    $strSQL6 .= ' AND doc_date >= "'.$start_date.'"'; 
     }

    if($end_date !=""){ 
    $strSQL6 .= ' AND doc_date <= "'.$end_date.'"'; 

}
 $strSQL6 .= 'ORDER BY doc_date ASC'; 

$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");	
while($objResult6 = mysqli_fetch_array($objQuery6))
{
	
$strSQL5 = "SELECT customer_name,status_cus,customer_no,cus_tel  FROM tb_customer   WHERE customer_id ='".$objResult6["bill_id"]."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");	
$objResult5 = mysqli_fetch_array($objQuery5);	
	
	
?>
<h4> ID : <?php echo $objResult6["bill_id"]; ?> คุณ <?php echo $objResult5["customer_name"]; ?> เบอร์โทร : <?php echo $objResult5["cus_tel"]; ?><?php if($objResult5["customer_no"] !=''){ ?> รหัสสมาชิก : <?php echo $objResult5["customer_no"]; ?> สถานะ :  <?php if($objResult5["status_cus"]=='0'){ echo "Gold Customer"; }else if($objResult5["status_cus"]=='1'){ echo "Platinum Customer";  }else if($objResult5["status_cus"]=='2'){ echo "Daimond Customer";  } } ?></h4>
	
<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%"><div align="center">ลำดับ</div></td >
			<td width="5%"><div align="center">เลขที่อ้างอิง</div></td>
			<td width="8%"><div align="center">เลขที่เอกสาร</div></td>
			<td width="8%"><div align="center">วันที่ออกบิล</div></td>
			<td width="8%"><div align="center">ช่องทางการขาย</div></td>
			<td width="15%"><div align="center">รายการสินค้า</div></td>
			<td width="8%"><div align="center">จำนวน</div></td>
			<td width="8%"><div align="center">ราคารวม</div></td>
						
		</thead>
		
<?php
	
	$strSQL = "SELECT ref_id,doc_no,doc_date,sale_chan,product_no,count,amount  FROM tb__buypro where group_pro ='เครื่องวัดน้ำตาล' and bill_id ='".$objResult6["bill_id"]."'  and product_no !='4178' and product_no !='4179'  and product_no !='4228' and product_no !='4229' and product_no !='4230' and product_no !='4293' and product_no !='4319' and product_no !='4326' and product_no !='4367' and product_no !='4449' and product_no !='4450' and product_no !='4602' and product_no !='4681' and product_no !='2637' and product_no !='2646' and product_no !='2646' and product_no !='3136' and product_no !='3166' and product_no !='3167' and product_no !='3168' and product_no !='3169' and product_no !='3170' and product_no !='3171' and product_no !='4213' and product_no !='4235' and product_no !='4274' and type_arae='2'";

if($start_date !=""){ 
    $strSQL .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_date <= "'.$end_date.'"'; 
}
$strSQL .= 'ORDER BY doc_date ASC'; 
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");	
	
$i=1;
	
while($objResult = mysqli_fetch_array($objQuery))
{


	
	

/*$strSQL3 = "SELECT  FROM tb__buypro WHERE group_pro ='เครื่องวัดน้ำตาล' and bill_id ='".$objResult6["bill_id"]."'  and product_no !='4178' and product_no !='4179'  and product_no !='4228' and product_no !='4229' and product_no !='4230' and product_no !='4293' and product_no !='4319' and product_no !='4326' and product_no !='4367' and product_no !='4449' and product_no !='4450' and product_no !='4602' and product_no !='4681'";
	
if($start_date !=""){ 
    $strSQL3 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND doc_date <= "'.$end_date.'"'; 
}
$strSQL3 .= 'ORDER BY doc_date ASC'; 	
	
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);*/
	
$strSQL2 = "SELECT salechannel_nameshort FROM tb_salechannel WHERE salechannel_ID = '".$objResult["sale_chan"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);	
	
	
$strSQL1 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_no"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
	
	?>
	<tr>
			<td><div align="center"><?php echo $i; ?></div></td >
			<td><?php echo $objResult["ref_id"]; ?></td>
			<td><?php echo $objResult["doc_no"]; ?></td>
			<td><?php echo Datethai($objResult["doc_date"]); ?></td>
			<td><?php echo $objResult2["salechannel_nameshort"]; ?></td>
			<td><div align="left"><?php echo $objResult1["sol_name"]; ?></div></td>
			<td><div align="right"><?php echo $objResult["count"]; ?> <?php echo $objResult1["unit_name"]; ?></div></td>
			<td><div align="right"><?php	echo number_format($objResult["amount"],2).""; 	?></div></td>

						
		</tr>
	
	
	
	<?php 
$i++;
}
	?>
	
</table>	
<br>
<?php
}
	
	  ?>




</div>
</body>
</html>