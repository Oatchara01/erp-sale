<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 16px; color: #FF0000;}
.style17 {font-size: 16px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 14px; color: #000000;}
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
$customer_no = $_GET["customer_no"]; 
$cus_tel = $_GET["cus_tel"]; 

include"dbconnect.php";



?>
<body>


<center>
<span class="style15">รายงานสรุปการขายลูกค้าบัตรสมาชิก</span></p>

</center>
</p>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่ออกบิล</td>
<td width="10%" align="center" class="style30">เลขที่ IV</td>
<td width="10%" align="center" class="style30">ระหัสบัตรสมาชิก</td> 
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เบอร์โทร</td> 
<td width="25%" align="center" class="style30">รายการ</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ราคา</td> 


	</tr>


<?php

	
$strSQL10 ="SELECT  doc_no,customer_no,customer_name,ref_id,doc_release_date,tel_mem FROM so__main WHERE  customer_no != '' and doc_no !=''";


if($start_date !=""){ 
    $strSQL10 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL10 .= ' AND register_date <= "'.$end_date.'"'; 
}


if($customer_no !=""){ 
    $strSQL10 .= ' AND customer_no = "'.$customer_no.'"'; 
}

if($cus_tel !=''){
$strSQL10 .= ' AND tel_mem = "'.$cus_tel.'"'; 	
}

$strSQL10 .=" order  by customer_no ASC  ";

$objQuery10 =mysqli_query($conn,$strSQL10);
while($objResult10=mysqli_fetch_array($objQuery10)){

$strSQL7 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult10["ref_id"]."'  ";

$objQuery7 =mysqli_query($conn,$strSQL7);
while($objResult7=mysqli_fetch_array($objQuery7)){



$strSQL16 ="SELECT access_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult7["product_id"]."'  ";

$objQuery16 =mysqli_query($conn,$strSQL16);
while($objResult16=mysqli_fetch_array($objQuery16)){

	
$summary_17=$objResult7['sum_amount'];
$summary17= number_format( $summary_17,2)."";



?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult10["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult10["doc_no"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult10["customer_no"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult10["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult10["tel_mem"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult16["access_name"]; ?></td> 

<td align="right" class="style30"><?php echo $objResult7["sale_count"];  ?>&nbsp;<?php echo $objResult16["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary17; ?></td> 


	</tr>




	<?php
}
}
}



?>


</table>







</body>
</html>