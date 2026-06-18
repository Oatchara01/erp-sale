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
$sale_code = $_GET["sale_code"];

include"dbconnect.php";




?>
<body>

<center>
<span class="style15">รายงานสินค้ารอออก ORDER (ตามเลขที่เอกสาร)</span></p>
</center>
</p>



<?php 
if ($sale_code !=""){



if( $sale_code =='S11'){
$sale_name ="พจนีย์  พ่วงศรี";
}else if( $sale_code =='S12'){
$sale_name ="S12";

}else if( $sale_code =='S13'){
$sale_name ="S13";

}else if( $sale_code =='S14'){
$sale_name ="S14";

}else if( $sale_code =='S15'){
$sale_name ="ชลกานต์ ชัยชนะ";

}else if( $sale_code =='S16'){
$sale_name ="ภัณฑิลา มงคลสวัสดิ์";

}else if( $sale_code =='S17'){
$sale_name ="S17";

}else if( $sale_code =='S21'){
$sale_name ="S21";

}else if( $sale_code =='S22'){
$sale_name ="S22";

}else if( $sale_code =='S23'){
$sale_name ="S23";

}else if( $sale_code =='S24'){
$sale_name ="S24";

}else if( $sale_code =='S31'){
$sale_name ="S31";

}else if( $sale_code =='SM1'){
$sale_name ='SM1';

}else if( $sale_code =='MM1'){
$sale_name ='MM1';

} else if( $sale_code =='EN1'){
$sale_name ="ช่าง";

}



?>

	
<span class="style16"><?php echo $sale_name ; ?></span></p>

<?php

$strSQL = "SELECT order_no,date_so,bill_name,po_no,ref_id,delivery_date,des_product,sale_comment,sale  FROM hos__so  where  status_doc ='Approve'  and have_order ='1'  and order_no !='' and have_product ='0' and type_doc = '3'";

if($start_date !=""){ 
    $strSQL .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_so <= "'.$end_date.'"'; 
}
if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

$Num_Rows = mysqli_num_rows($objQuery);

if ($Num_Rows > 0){

?>
<span class="style16"><?php echo  "บริษัท ฟาร์ ทริลเลียน จำกัด" ; ?></span>
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">เลขที่ใบฝาก</td>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="15%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="10%" align="center" class="style30">เลขที่สัญญา</td> 
<td width="10%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">กำหนดส่ง</td> 
<td width="15%" align="center" class="style30">คลังสินค้า</td> 


	</tr>



<?php
while($objResult=mysqli_fetch_array($objQuery)){



$strSQL1 = "SELECT product_id,count,price,amount  FROM hos__subso  where  ref_idd = '".$objResult["ref_id"]."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1=mysqli_fetch_array($objQuery1)){


$strSQL2 = "SELECT access_name,access_code  FROM tb_product  where  product_ID = '".$objResult1["product_id"]."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2=mysqli_fetch_array($objQuery2)){




?>
<tr>

	<td  align="center" class="style30"><?php echo $objResult["order_no"]; ?></td>
<td  align="center" class="style30"><?php echo DateThai($objResult["date_so"]); ?></td>
<td align="reft" class="style30"><?php echo $objResult["bill_name"]; ?></td> 
<td  align="center" class="style30"><?php echo $objResult["po_no"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult2["access_code"]; ?></td>
<td  align="reft" class="style30"><?php echo $objResult2["access_name"]; ?></td> 
<td  align="center" class="style30"><?php echo $objResult1["count"]; ?></td> 
<td  align="center" class="style30"><?php if($objResult["delivery_date"]="0000-00-00"){ echo "-"; }else{ echo DateThai($objResult["delivery_date"]); } ?></td> 
<td  align="center" class="style30"><?php echo $objResult["des_product"]; ?></td> 


</tr>




	<?
}
}
}
?>
</table>
<?php 

$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd)  where  status_doc ='Approve'  and have_order ='1'  and order_no !='' and have_product ='0' and type_doc = '3'";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_so <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL11 .= ' AND sale_code = "'.$sale_code.'"'; 
}


//echo $strSQL; 

$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

	$total =$objResult11["total"];

?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="100%" align="center" class="style30"><?php echo "รวมเป็๋นเงิน :"; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo number_format( $total,2).""; ?></td>
</tr>
</table>

<?php } ?>

</p></p>

<?php

$strSQL = "SELECT order_no,date_so,bill_name,po_no,ref_id,delivery_date,des_product,sale_comment,sale  FROM hos__so  where  status_doc ='Approve'  and have_order ='1'  and order_no !='' and have_product ='0' and type_doc = '4'";

if($start_date !=""){ 
    $strSQL .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_so <= "'.$end_date.'"'; 
}
if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}
 

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){


?>
<span class="style16"><?php echo  "บริษัท โนเบิล เมด จำกัด" ; ?></span>
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">เลขที่ใบฝาก</td>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="15%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="10%" align="center" class="style30">เลขที่สัญญา</td> 
<td width="10%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">กำหนดส่ง</td> 
<td width="15%" align="center" class="style30">คลังสินค้า</td> 


	</tr>



<?php

while($objResult=mysqli_fetch_array($objQuery)){



$strSQL1 = "SELECT product_id,count,price,amount  FROM hos__subso  where  ref_idd = '".$objResult["ref_id"]."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1=mysqli_fetch_array($objQuery1)){


$strSQL2 = "SELECT access_name,access_code  FROM tb_product  where  product_ID = '".$objResult1["product_id"]."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2=mysqli_fetch_array($objQuery2)){




?>
<tr>

	<td  align="center" class="style30"><?php echo $objResult["order_no"]; ?></td>
<td  align="center" class="style30"><?php echo DateThai($objResult["date_so"]); ?></td>
<td align="reft" class="style30"><?php echo $objResult["bill_name"]; ?></td> 
<td  align="center" class="style30"><?php echo $objResult["po_no"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult2["access_code"]; ?></td>
<td  align="reft" class="style30"><?php echo $objResult2["access_name"]; ?></td> 
<td  align="center" class="style30"><?php echo $objResult1["count"]; ?></td> 
<td  align="center" class="style30"><?php if($objResult["delivery_date"]="0000-00-00"){ echo "-"; }else{ echo DateThai($objResult["delivery_date"]); } ?></td> 
<td  align="center" class="style30"><?php echo $objResult["des_product"]; ?></td> 


</tr>




	<?
}
}
}
?>
</table>

<?php 

$strSQL12 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd)  where  status_doc ='Approve'  and have_order ='1'  and order_no !='' and have_product ='0' and type_doc = '4'";

if($start_date !=""){ 
    $strSQL12 .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL12 .= ' AND date_so <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL12 .= ' AND sale_code = "'.$sale_code.'"'; 
}


//echo $strSQL; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);

	$total1 =$objResult12["total1"];

?>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="100%" align="center" class="style30"><?php echo "รวมเป็๋นเงิน :"; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo number_format( $total1,2).""; ?></td>
</tr>
</table>



<?php

}
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style39" align="right"><?php echo  "(" ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  ")" ; ?></span>
</p>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style39" align="right"><?php echo  "ผู้แทนฝ่ายขาย รับทราบ" ; ?></span> </p>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style39" align="right"><?php echo  "(" ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  ")" ; ?></span>
</p>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style39" align="right"><?php echo  "หัวหน้าเขตการขาย รับทราบ" ; ?></span> </p>

<?php  

$register_date = date("Y-m-d");
$to_day = Datethai($register_date);
$register_time = date("H:i:s");


?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="style39" align="right"><?php echo $to_day; ?>&nbsp;<?php echo $register_time; ?></span> </p>



<?php
	 }else{  


$strSQL = "SELECT order_no,date_so,bill_name,po_no,ref_id,delivery_date,des_product,sale_comment,sale  FROM hos__so  where  status_doc ='Approve'  and have_order ='1'  and order_no !='' and have_product ='0' and type_doc = '3'";

if($start_date !=""){ 
    $strSQL .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_so <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
<span class="style16"><?php echo  "บริษัท ฟาร์ ทริลเลียน จำกัด" ; ?></span>
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">เลขที่ใบฝาก</td>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="15%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="10%" align="center" class="style30">เลขที่สัญญา</td> 
<td width="10%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">กำหนดส่ง</td> 
<td width="10%" align="center" class="style30">sale</td> 
<td width="15%" align="center" class="style30">คลังสินค้า</td> 
<td width="10%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="10%" align="center" class="style30">ราคารวม</td> 
<td width="10%" align="center" class="style30">หมายเหตุ</td>


	</tr>



<?php

while($objResult=mysqli_fetch_array($objQuery)){



$strSQL1 = "SELECT product_id,count,price,amount  FROM hos__subso  where  ref_idd = '".$objResult["ref_id"]."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1=mysqli_fetch_array($objQuery1)){


$strSQL2 = "SELECT access_name,access_code  FROM tb_product  where  product_ID = '".$objResult1["product_id"]."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2=mysqli_fetch_array($objQuery2)){




?>
<tr>

	<td  align="center" class="style30"><?php echo $objResult["order_no"]; ?></td>
<td  align="center" class="style30"><?php echo DateThai($objResult["date_so"]); ?></td>
<td align="reft" class="style30"><?php echo $objResult["bill_name"]; ?></td> 
<td  align="center" class="style30"><?php echo $objResult["po_no"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult2["access_code"]; ?></td>
<td  align="reft" class="style30"><?php echo $objResult2["access_name"]; ?></td> 
<td  align="center" class="style30"><?php echo $objResult1["count"]; ?></td> 
<td  align="center" class="style30"><?php if($objResult["delivery_date"]="0000-00-00"){ echo "-"; }else{ echo DateThai($objResult["delivery_date"]); } ?></td> 
<td  align="reft" class="style30"><?php echo $objResult["sale"]; ?></td>  
<td  align="reft" class="style30"><?php echo $objResult["des_product"]; ?></td> 
<td  align="center" class="style30"><?php $price= $objResult1["price"]; echo number_format( $price,2)."";?></td> 
<td  align="center" class="style30"><?php  $amount = $objResult1["amount"]; echo number_format( $amount,2).""; ?></td>  
<td  align="reft" class="style30"><?php echo $objResult["sale_comment"]; ?></td> 


</tr>




	<?
}
}
}
?>
</table>
<?php 

$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd)  where  status_doc ='Approve'  and have_order ='1'  and order_no !='' and have_product ='0' and type_doc = '3'";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_so <= "'.$end_date.'"'; 
}

//echo $strSQL; 

$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

	$total =$objResult11["total"];

?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="100%" align="center" class="style30"><?php echo "รวมเป็๋นเงิน :"; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo number_format( $total,2).""; ?></td>
</tr>
</table>

<?php } ?>
</p></p>



<?php  
	
$strSQL = "SELECT order_no,date_so,bill_name,po_no,ref_id,delivery_date,des_product,sale_comment,sale  FROM hos__so  where  status_doc ='Approve'  and have_order ='1'  and order_no !='' and have_product ='0' and type_doc = '4'";

if($start_date !=""){ 
    $strSQL .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_so <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){

?>

<span class="style16"><?php echo  "บริษัท โนเบิ้ล เมด จำกัด" ; ?></span>
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">เลขที่ใบฝาก</td>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="15%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="10%" align="center" class="style30">เลขที่สัญญา</td> 
<td width="10%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">กำหนดส่ง</td> 
<td width="10%" align="center" class="style30">sale</td> 
<td width="15%" align="center" class="style30">คลังสินค้า</td> 
<td width="10%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="10%" align="center" class="style30">ราคารวม</td> 
<td width="10%" align="center" class="style30">หมายเหตุ</td>


	</tr>



<?php

while($objResult=mysqli_fetch_array($objQuery)){



$strSQL1 = "SELECT product_id,count,price,amount  FROM hos__subso  where  ref_idd = '".$objResult["ref_id"]."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1=mysqli_fetch_array($objQuery1)){


$strSQL2 = "SELECT access_name,access_code  FROM tb_product  where  product_ID = '".$objResult1["product_id"]."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2=mysqli_fetch_array($objQuery2)){




?>
<tr>

	<td  align="center" class="style30"><?php echo $objResult["order_no"]; ?></td>
<td  align="center" class="style30"><?php echo DateThai($objResult["date_so"]); ?></td>
<td align="reft" class="style30"><?php echo $objResult["bill_name"]; ?></td> 
<td  align="center" class="style30"><?php echo $objResult["po_no"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult2["access_code"]; ?></td>
<td  align="reft" class="style30"><?php echo $objResult2["access_name"]; ?></td> 
<td  align="center" class="style30"><?php echo $objResult1["count"]; ?></td> 
<td  align="center" class="style30"><?php if($objResult["delivery_date"]="0000-00-00"){ echo "-"; }else{ echo DateThai($objResult["delivery_date"]); } ?></td> 
<td  align="reft" class="style30"><?php echo $objResult["sale"]; ?></td>  
<td  align="reft" class="style30"><?php echo $objResult["des_product"]; ?></td> 
<td  align="center" class="style30"><?php $price= $objResult1["price"]; echo number_format( $price,2)."";?></td> 
<td  align="center" class="style30"><?php  $amount = $objResult1["amount"]; echo number_format( $amount,2).""; ?></td>  
<td  align="reft" class="style30"><?php echo $objResult["sale_comment"]; ?></td> 


</tr>




	<?
}
}
}
?>
</table>

<?php 

$strSQL12 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd)  where  status_doc ='Approve'  and have_order ='1'  and order_no !='' and have_product ='0' and type_doc = '4'";

if($start_date !=""){ 
    $strSQL12 .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL12 .= ' AND date_so <= "'.$end_date.'"'; 
}

//echo $strSQL; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);

	$total1 =$objResult12["total1"];

?>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="100%" align="center" class="style30"><?php echo "รวมเป็๋นเงิน :"; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo number_format( $total1,2).""; ?></td>
</tr>
</table>
<?php 
	}
	 }
?>

</body>
</html>