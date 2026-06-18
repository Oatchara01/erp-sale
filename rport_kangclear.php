<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
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
$sol = $_GET["sol"];

include"dbconnect.php";




?>
<body>


<center>
<span class="style15">รายงานออร์เดอร์ค้างเคลียร์ยืม</span></p>

</center>
</p>



<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">หมายเลขคำสั่งซื้อ</td>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">ID ลุกค้า</td>	
<td width="25%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">รหัสสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ราคา</td> 
<td width="10%" align="center" class="style30">เลขที่อ้างอิง</td> 
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td> 
	<td width="10%" align="center" class="style30">ช่องทางการขาย</td> 
	</tr>


<?php 
$strSQL ="SELECT  doc_no,doc_release_date,customer_name,delivery_name,order_id,register_time,ref_id,sale_channel,bill_id FROM so__main WHERE doc_no LIKE '%".$sol."%' and iv_no ='' and sr_no ='' and cancel_ckk ='0' and (sale_channel !='44' or sale_channel!='40' or sale_channel='39' or sale_channel='42')";


if($start_date !=""){ 
    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL .= ' AND sale_channel = "'.$sale_channel.'"'; 
}
	


$strSQL .=" order  by doc_release_date ASC ";
//echo $strSQL;

$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){



$strSQL1 = "SELECT access_name,sol_code,sale_count,sum_amount FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
$strSQL2 = "SELECT salechannel_nameshort  FROM tb_salechannel  where salechannel_ID = '".$objResult["sale_channel"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2=mysqli_fetch_array($objQuery2);


?>

<tr>
<td width="10%" align="center" class="style30"><?php echo $objResult["order_id"]; ?></td>
<td width="10%" align="reft" class="style30"><?php echo datethai($objResult["doc_release_date"]); ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult["bill_id"]; ?></td>	
<td width="25%" align="reft" class="style30"><?php if ($objResult["customer_name"]!=''){ echo $objResult["customer_name"];  }else{    echo $objResult["delivery_name"];  } ?></td> 
<td width="25%" align="reft" class="style30"><?php echo $objResult1["access_name"]; ?></td> 
<td width="10%" align="reft" class="style30"><?php echo $objResult1["sol_code"]; ?></td> 
<td width="10%" align="right" class="style30"><?php echo $objResult1["sale_count"]; ?></td> 
<td width="10%" align="right" class="style30"><?php $price=$objResult1["sum_amount"]; echo number_format( $price,2).""; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $objResult["ref_id"]; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $objResult["doc_no"]; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $objResult2["salechannel_nameshort"]; ?></td>	
	</tr>





<?php
}
}

$strSQL9 = "SELECT SUM(sale_count)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE doc_no LIKE '%".$sol."%' and iv_no =''  and sr_no =''  and cancel_ckk ='0'  and (sale_channel !='44' or sale_channel!='40' or sale_channel='39' or sale_channel='42')";


if($start_date !=""){ 
    $strSQL9 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL9 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL9 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");

$objResult9 = mysqli_fetch_array($objQuery9);

$total1 =$objResult9["total1"];

//echo $total1;


$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  doc_no LIKE '%".$sol."%' and iv_no =''  and sr_no =''  and cancel_ckk ='0'  and (sale_channel !='44' or sale_channel!='40' or sale_channel='39' or sale_channel='42')";


if($start_date !=""){ 
    $strSQL8 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL8 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL8 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");

$objResult8 = mysqli_fetch_array($objQuery8);

$total =$objResult8["total"];
//echo $total;


?>

<tr>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="reft" class="style30"></td>
<td width="25%" align="reft" class="style30"></td> 
<td width="25%" align="reft" class="style30"></td> 
<td width="10%" align="reft" class="style30"></td> 
<td width="10%" align="right" class="style30"><?php echo $total1; ?></td> 
<td width="10%" align="right" class="style30"><?php  echo number_format( $total,2).""; ?></td> 
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
	</tr>


</table>
</body>
</html>