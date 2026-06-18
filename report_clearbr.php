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

$iv_no = $_POST["iv_no"];
$h_product_code = $_POST["h_product_code"];


include"dbconnect.php";




?>
<body>


<center>
<span class="style15">รายงานออร์เดอร์เคลียร์ยืม</span><br>
</center>

<span class="style16"><?php echo $iv_no; ?></span><br>

	<table border= "1" width="100%" class='w3-table'>
<tr>

<td width="10%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="10%" align="center" class="style30">วันที่ออกบิล</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>	
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="25%" align="center" class="style30">รายการสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">หมายเลขเครื่อง</td> 
<td width="5%" align="center" class="style30">เขตการขาย</td> 
	</tr>

<?php 
	

$strSQL2 = "SELECT * FROM  hos__subso  WHERE clear_br ='1' and status_so ='Approve'";

if($iv_no !=""){ 
    $strSQL2 .= ' AND clear_ivno = "'.$iv_no.'"'; 
}

if($h_product_code !=""){ 
    $strSQL2 .= ' AND product_id = "'.$h_product_code.'"'; 
}

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){

$strSQL = "SELECT iv_no,iv_date,bill_name,sale_code,status_doc FROM hos__so  WHERE ref_id = '".$objResult2["ref_idd"]."' and status_doc ='Approve'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT sol_name,unit_name FROM  tb_product  WHERE product_ID = '".$objResult2["product_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
if($objResult["status_doc"] !='Rejected' or $objResult["status_doc"] !='ยกเลิก'){													
if($Num_Rows > 0){	
	
?>

<tr>

<td width="10%" align="center" class="style30"><?php echo $objResult2['ref_idd']; ?></td>
<td width="10%" align="center" class="style30"><?php  echo Datethai($objResult['iv_date']); ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult['iv_no']; ?></td>
<td width="20%" align="left" class="style30"><?php echo $objResult['bill_name']; ?></td>
<td width="25%" align="left" class="style30"><?php  echo $objResult1['sol_name'];  ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format($objResult2['count'],0); ?> <?php echo $objResult1['unit_name']; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult2['sn']; ?></td> 
<td width="5%" align="center" class="style30"><?php echo $objResult['sale_code']; ?></td>
	</tr>

<?php
}
}
}
?>

		
		
<?php 

$strSQL2 = "SELECT * FROM  so__submain  WHERE clear_br ='1' and status_sol='Approve'";

if($iv_no !=""){ 
    $strSQL2 .= ' AND clear_ivno = "'.$iv_no.'"'; 
}

if($h_product_code !=""){ 
    $strSQL2 .= ' AND product_id = "'.$h_product_code.'"'; 
}

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){

$strSQL = "SELECT doc_no,doc_release_date,billing_name,employee_name FROM so__main  WHERE ref_id = '".$objResult2["ref_idd"]."' and approve_complete ='Approve' and cancel_ckk='0'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT sol_name,unit_name FROM  tb_product  WHERE product_ID = '".$objResult2["product_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
													
if($Num_Rows > 0){	
	
?>

<tr>

<td width="10%" align="center" class="style30"><?php echo $objResult2['ref_idd']; ?></td>
<td width="10%" align="center" class="style30"><?php  echo Datethai($objResult['doc_release_date']); ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult['doc_no']; ?></td>
<td width="20%" align="left" class="style30"><?php echo $objResult['billing_name']; ?></td>
<td width="25%" align="left" class="style30"><?php  echo $objResult1['sol_name'];  ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format($objResult2['sale_count'],0); ?> <?php echo $objResult1['unit_name']; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult2['sn_number']; ?></td> 
<td width="5%" align="center" class="style30"><?php echo $objResult['employee_name']; ?></td>
	</tr>

<?php
}
}
?>		
		

<?php 

$strSQL2 = "SELECT * FROM  hos__subsmp  WHERE clear_br ='1' and status_smp ='Approve'";

if($iv_no !=""){ 
    $strSQL2 .= ' AND br_no = "'.$iv_no.'"'; 
}

if($h_product_code !=""){ 
    $strSQL2 .= ' AND product_id = "'.$h_product_code.'"'; 
}

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){

$strSQL = "SELECT smp_no,smp_date,customer_name,sale_code,status_sup FROM hos__smp  WHERE ref_idsmp = '".$objResult2["reff_idsmp"]."' and status_sup ='Approve'";

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT sol_name,unit_name FROM  tb_product  WHERE product_ID = '".$objResult2["product_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
if($objResult["status_sup"] !='Rejected' or $objResult["status_sup"] !='ยกเลิก'){														
if($Num_Rows > 0){	
	
?>

<tr>

<td width="10%" align="center" class="style30"><?php echo $objResult2['reff_idsmp']; ?></td>
<td width="10%" align="center" class="style30"><?php  echo Datethai($objResult['smp_date']); ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult['smp_no']; ?></td>
<td width="20%" align="left" class="style30"><?php echo $objResult['customer_name']; ?></td>
<td width="25%" align="left" class="style30"><?php  echo $objResult1['sol_name'];  ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format($objResult2['sale_count'],0); ?> <?php echo $objResult1['unit_name']; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult2['sn']; ?></td> 
<td width="5%" align="center" class="style30"><?php echo $objResult['sale_code']; ?></td>
	</tr>

<?php
}
}
}
?>	
		
		
<?php 

$strSQL2 = "SELECT * FROM  hos__subspr  WHERE clear_br ='1' and status_spr ='Approve'";

if($iv_no !=""){ 
    $strSQL2 .= ' AND clear_ivno = "'.$iv_no.'"'; 
}

if($h_product_code !=""){ 
    $strSQL2 .= ' AND product_id = "'.$h_product_code.'"'; 
}

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
while($objResult2 = mysqli_fetch_array($objQuery2)){

$strSQL = "SELECT spr_no,spr_date,customer,sale_code,status_doc FROM hos__spr  WHERE ref_id = '".$objResult2["ref_idd"]."' and status_doc='Approve'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT sol_name,unit_name FROM  tb_product  WHERE product_ID = '".$objResult2["product_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
if($objResult["status_doc"] !='Rejected' or $objResult["status_doc"] !='ยกเลิก'){													
if($Num_Rows > 0){	
	
?>

<tr>

<td width="10%" align="center" class="style30"><?php echo $objResult2['ref_idd']; ?></td>
<td width="10%" align="center" class="style30"><?php  echo Datethai($objResult['spr_date']); ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult['spr_no']; ?></td>
<td width="20%" align="left" class="style30"><?php echo $objResult['customer']; ?></td>
<td width="25%" align="left" class="style30"><?php  echo $objResult1['sol_name'];  ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format($objResult2['sale_count'],0); ?> <?php echo $objResult1['unit_name']; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult2['sn']; ?></td> 
<td width="5%" align="center" class="style30"><?php echo $objResult['sale_code']; ?></td>
	</tr>

<?php
}
}
}
?>				
		
		
<?php 

$strSQL2 = "SELECT * FROM (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  WHERE 1";

if($iv_no !=""){ 
    $strSQL2 .= ' AND iv_no = "'.$iv_no.'"'; 
}

if($h_product_code !=""){ 
    $strSQL2 .= ' AND product_id = "'.$h_product_code.'"'; 
}

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
	
while($objResult2 = mysqli_fetch_array($objQuery2)){

$strSQL1 = "SELECT sol_name,unit_name FROM  tb_product  WHERE product_ID = '".$objResult2["product_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
													

?>

<tr>

<td width="10%" align="center" class="style30"><?php echo $objResult2['ref_id']; ?></td>
<td width="10%" align="center" class="style30"><?php if($objResult2['date_receive'] !='0000-00-00'){ echo Datethai($objResult2['date_receive']); } ?></td>
<td width="10%" align="center" class="style30"><?php echo "รับคืนสินค้า"; ?></td>
<td width="20%" align="left" class="style30"><?php echo $objResult2['customer_name']; ?></td>
<td width="25%" align="left" class="style30"><?php  echo $objResult1['sol_name'];  ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format($objResult2['count'],0); ?> <?php echo $objResult1['unit_name']; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult2['sn']; ?></td> 
<td width="5%" align="center" class="style30"><?php echo $objResult2['sale_code']; ?></td>
	</tr>

<?php

}
?>				

</table>
<br>



</body>
