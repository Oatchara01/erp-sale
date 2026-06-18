<?php include ("head2.php"); ?>
<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 14px; color: #FF0000;}
.style17 {font-size: 14px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 12px; color: #000000;}
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



</style>



<?php


$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$company = $_GET["company"]; 
$iv_no = $_GET["iv_no"]; 

include"dbconnect.php";
include"dbconnect_sale.php";




?>
<body>

<?php 
if($company =='3'){
$company_name = "บริษัท ออลล์เวล ไลฟ์ จำกัด";

}else if($company =='4'){
$company_name = "บริษัท โนเบิล เมด จำกัด";

}


$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;



?>

</p>



<table border= "1" width="100%" class='w3-table'>
<tr>
<?php /*if($_SESSION['name']=='พัชร์ชนัญ'){ ?>
	<td width="10%" align="center" class="style30">CUST_ID</td>
	<td width="10%" align="center" class="style30">REFID</td>
	<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
	<td width="10%" align="center" class="style30">ชื่อลูกค้า</td>
	<td width="10%" align="center" class="style30">ที่อยู่</td>
	<td width="10%" align="center" class="style30">เบอร์โทร</td>
	<?php }*/ ?>
<td width="10%" align="center" class="style30">CUSTID</td>
<td width="5%" align="center" class="style30">PRENAM</td>
<td width="10%" align="center" class="style30">CUSNAM</td> 
<td width="10%" align="center" class="style30">ADDR01</td> 
<td width="10%" align="center" class="style30">ADDR02</td> 
<td width="10%" align="center" class="style30">ADDR03</td> 
<td width="5%" align="center" class="style30">ZIPCOD</td>
<td width="10%" align="center" class="style30">TELNUM</td>
<td width="10%" align="center" class="style30">TAXID</td>
<td width="2%" align="center" class="style30">BR</td>
<td width="5%" align="center" class="style30">CUSTYP</td>
<td width="10%" align="center" class="style30">ACCNUM</td>
<td width="8%" align="center" class="style30">SALEID</td>
<td width="5%" align="center" class="style30">AREAID</td>

	</tr>

<?php

$strSQL = "SELECT ref_id,bill_id,type_doc,bill_name,bill_address,bill_tel,iv_no,type_doc,sale_code   FROM hos__so  where status_doc='Approve' ";


if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}
if($company !=""){ 
	$strSQL .= ' AND type_doc = "'.$company.'"'; 

}
	
if($iv_no =="1"){ 
	$strSQL .= ' AND iv_no LIKE "%E%"'; 

}else if($iv_no =="1"){
	
$strSQL .= ' AND (iv_no LIKE "%IV%" or iv_no LIKE "%IC%")'; 	

}
	
	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$strSQL1 = "SELECT customer_code,customer_coden,preface_name,sale_code,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,tax_id,bill_tel,type_customer FROM tb_customer WHERE customer_id = '".$objResult["bill_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);

?>
<tr>
	<?php /*if($_SESSION['name']=='พัชร์ชนัญ'){ ?>
	<td  align="left" class="style30"><?php echo $objResult["bill_id"]; ?></td> 
	<td  align="left" class="style30"><?php echo $objResult["ref_id"]; ?></td>
	<td  align="left" class="style30"><?php echo $objResult["iv_no"]; ?></td> 
	<td  align="left" class="style30"><?php echo $objResult["bill_name"]; ?></td>
	<td  align="left" class="style30"><?php echo $objResult["bill_address"]; ?></td>
	<td  align="left" class="style30"><?php echo $objResult["bill_tel"]; ?></td>
	<?php }*/ ?>

<td width="10%" align="left" class="style30"><?php if($objResult["type_doc"]=='3'){ echo $objResult1["customer_code"]; }else if($objResult["type_doc"]=='4'){ echo $objResult1["customer_coden"];  } ?>

</td>
<td  align="left" class="style30"><?php echo $objResult1["preface_name"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult1["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo $objResult1["bill_address"]; ?></td> 
<td  align="left" class="style30"><?php echo $objResult1["bill_ampher"]; ?></td> 
<td  align="left" class="style30"><?php echo $objResult1["billl_province"]; ?></td> 
<td  align="left" class="style30"><?php echo $objResult1["bill_postcode"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult1["bill_tel"]; ?></td>
<td width="10%" align="left" class="style30">
'<?php if($objResult1["tax_id"] !=''){ echo $objResult1["tax_id"]; }else{ echo "0000000000000"; } ?>
</td>
<td  align="left" class="style30"><?php echo '0'; ?></td>
<td  align="left" class="style30">
<?php
if($objResult1["type_customer"]=='1'){
echo 'DL';
}else if($objResult1["type_customer"]=='2'){
echo 'DS';
}else if($objResult1["type_customer"]=='3'){
echo 'GH';
}else if($objResult1["type_customer"]=='4'){
echo 'PH';
}else if($objResult1["type_customer"]=='5'){
echo 'CN';
}else if($objResult1["type_customer"]=='6'){
echo 'EC';
}else{
echo '';
}
?>
</td>
<td  align="left" class="style30"><?php if($company =='3'){ echo '1130-01-00'; }else if($company =='4'){ echo '1130-01';  } ?></td>
<td  align="left" class="style30"><?php echo $objResult["sale_code"]; ?></td>
<td  align="left" class="style30"><?php
if($objResult["sale_code"]=='S11'){
echo 'อก';
}elseif($objResult["sale_code"]=='S12'){
echo 'กล';
}elseif($objResult["sale_code"]=='S13' or $objResult["sale_code"]=='S14'){
echo 'หน';
}elseif($objResult["sale_code"]=='S15' or $objResult["sale_code"]=='S16'){
echo 'อส';
}elseif($objResult["sale_code"]=='S17'){
echo 'ตต';
}else{
echo 'กท';

}
?></td>


	</tr>
	
	<?php 
}
?>
</table>


</body>
</html>