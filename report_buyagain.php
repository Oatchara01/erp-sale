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
<span class="style15">รายงานลูกค้าซื้อซ้ำ</span></p>

<span class="style33"><?php echo Datethai($start_date); ?> ถึง<?php echo Datethai($end_date); ?></span></p>
<?php if($group1!=''){ ?><span class="style15"><?php echo $group1; ?></span></p> <?php } ?>
</center>


</p>
			


	<?php
/*<table border= "1" width="100%" class='w3-table'>
<thead>	
<tr>
<th width="5%" align="center" class="style30">ID ลำดับ</th>
<th width="15%" align="center" class="style30">ชื่อลุกค้า</th>
<th width="2%" align="center" class="style30">รหัสบัตรสมาชิก</th>
<th width="2%" align="center" class="style30">จำนวนครั้ง</th> 
<th width="2%" align="center" class="style30">ยอดสั่งซื้อ</th>
</tr>
</thead>	*/



/*$strSQL8 = "SELECT DISTINCT bill_id  FROM so__main   WHERE bill_id !='0' and select_type_doc !='2' and select_type_doc !='1'";

if($start_date !=""){ 

    $strSQL8 .= ' AND doc_release_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL8 .= ' AND doc_release_date <= "'.$end_date.'"'; 

}
$strSQL8 .=" order  by bill_id ASC  ";	
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows8 = mysqli_num_rows($objQuery8);

while($objResult8 = mysqli_fetch_array($objQuery8))
{

$strSQL7 = "SELECT bill_id  FROM so__main   WHERE bill_id !='0' and select_type_doc !='2' and select_type_doc !='1' and bill_id ='".$objResult8["bill_id"]."'";

if($start_date !=""){ 

    $strSQL7 .= ' AND doc_release_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL7 .= ' AND doc_release_date <= "'.$end_date.'"'; 

}
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);
if($Num_Rows7 > 1){ */
	
	

	
$strSQL6 = "SELECT bill_id,sale_channel,billing_name,doc_no,doc_release_date,employee_name,ref_id  FROM so__main   WHERE bill_id !='0' and select_type_doc !='2' and select_type_doc !='1'  and cancel_ckk ='0'";
	if($start_date !=""){ 

    $strSQL6 .= ' AND doc_release_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL6 .= ' AND doc_release_date <= "'.$end_date.'"'; 

}
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");	
while($objResult6 = mysqli_fetch_array($objQuery6))
{
	
$strSQL7 = "SELECT ref_id  FROM tb__mainreort   WHERE ref_id ='".$objResult6["ref_id"]."'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);
if($Num_Rows7 > 0){ }else{	
	
	
$strSQL5 = "SELECT customer_no  FROM tb_customer   WHERE customer_id ='".$objResult6["bill_id"]."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");	
$objResult5 = mysqli_fetch_array($objQuery5);	
	
$strSQL71 = "insert into tb__mainreort
(ref_id,bill_id,cutomer,customer_number,sale_chan,doc_date,sale_code,doc_no)
values ('".$objResult6["ref_id"]."','".$objResult6["bill_id"]."','".$objResult6["billing_name"]."','".$objResult5["customer_no"]."','".$objResult6["sale_channel"]."','".$objResult6["doc_release_date"]."','".$objResult6["employee_name"]."','".$objResult6["doc_no"]."')";

$objQuery71 = mysqli_query($conn,$strSQL71);
	
	
$sql = "SELECT product_code,sale_count,price_per_unit,sum_amount,group1 FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult6["ref_id"]."'";
$query = mysqli_query($conn,$sql) or die ("Error Query [".$sql."]");
while ($fetch=mysqli_fetch_array($query,MYSQLI_ASSOC)) { 	
	
$strSQL72 = "insert into tb__submain
(re_idd,product_no,count,price_one,amount,group_1)
values ('".$objResult6["ref_id"]."','".$fetch["product_code"]."','".$fetch["sale_count"]."','".$fetch["price_per_unit"]."','".$fetch["sum_amount"]."','".$fetch["group1"]."')";

$objQuery72 = mysqli_query($conn,$strSQL72);
}
}	
}
	
	  ?>
<br>

		<?php

/*$strSQL9 = "SELECT bill_id  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE bill_id !='0' and select_type_doc !='2' and select_type_doc !='1'";

if($start_date !=""){ 

    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 

}

$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);


while($objResult9 = mysqli_fetch_array($objQuery9))
{	
	?>


<?php	
$strSQL = "SELECT expire_total,problem_total,reorder_point,access_code,sol_name,order_no,unit_name,product_ID,ordered,order_count,grade_b,code_type,due_date   FROM tb_product  WHERE popular_1 ='1' and group1 = '".$objResult9["group1"]."' and close_pro ='0'";
	

$strSQL .=" order  by number ASC  ";	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


while($objResult = mysqli_fetch_array($objQuery))
{
	
	
?>
	<tr>
<td  align="left" class="style30"><div align="left"><?php echo $objResult["access_code"]; ?></div></td>
<td  align="left" class="style30"><div align="left"><?php echo $objResult["sol_name"]; ?></div></td>
<td  align="center" class="style30"><?php echo $objResult["unit_name"]; ?></td> 
<td   align="center" class="style40"><?php echo $buy_sale1;  ?></td> 
<td   align="center" class="style30"><b><?php echo $count_pro1;  ?></b></td> 
<td   align="center" class="style30"><?php echo $objResult["expire_total"]; ?></td> 
<td   align="center" class="style30"><?php echo $objResult["problem_total"]; ?></td> 
<td   align="center" class="style30"><?php echo $objResult["grade_b"]; ?></td> 		
<td  align="center" class="style30"><?php echo $jong;  ?></td> 
<td  align="center" class="style30"><?php echo $sale;  ?></td> 

	
<?php if($count_pro7 < $send_cm){ ?>
	<td  align="center" bgcolor="#FF3030" class="style30">
	<?php }else if($count_pro7 >= $send_cm){ ?>
	<td  align="center" bgcolor="#00FF00" class="style30">
		<?php } ?>
	<?php echo $send_cm;  ?>
	
	</td>	

	
	
<td  align="center" class="style38"><?php echo $send_3m;  ?></td>	
		
		
<td   align="center" class="style30"><?php 
if($objResult["ordered"]=='1'){	
echo "<input type='checkbox' checked='checked' >"; }else{  echo "<input type='checkbox'>";   } ?></td> 
<td   align="left" class="style37"><div align="left"><?php echo $objResult["order_no"]; ?></div></td> 
<td   align="left" class="style30"><div align="left"><?php echo $objResult["order_count"]; ?></div></td> 

</tr>

<?php
	

}
}
*/
?>

</table>


</div>
</body>
</html>