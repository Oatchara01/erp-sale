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
$company = $_GET["company"];
if($company=='3'){
$company1 = '1';
}else if($company=='4'){
$company1 = '2';	
}

include"dbconnect.php";


?>
<body>



<center>
<?php
if($company =='3'){
$company_name = "บริษัท ออลล์เวล ไลฟ์ จำกัด";

}else if($company =='4'){
$company_name = "บริษัท โนเบิล เมด จำกัด";

}else{
$company_name = "";
}
?>
<span class="style15"><?php echo $company_name; ?></span></p>
<span class="style15">รายการสรุปเบิกเงินสำรองจ่าย</span></p>

<span class="style15">ประจำวันที่ <?php echo Datethai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo Datethai($end_date); ?></span><br>


</center>
</p>

</p>

<?php

$sql1 = "SELECT ref_id,delivery,date_ker,ker_bath,order_refer_code1,order_refer_code,doc_no  FROM so__main  where 1  ";

if($start_date !=""){ 
    $sql1 .= ' AND date_ker >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql1 .= ' AND date_ker <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $sql1 .= ' AND select_type_doc = "'.$company.'"'; 
}


$query1 = mysqli_query($conn,$sql1) or die ("Error Query [".$sql1."]");
$Num_Rows1 = mysqli_num_rows($query1);
$i=1;	
while($result1 = mysqli_fetch_array($query1)){

$strSQL3 = "select delivery_name from tb_delivery where delivery_id ='".$result1["delivery"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResuut3 = mysqli_fetch_array($objQuery3,MYSQLI_ASSOC);
	
$order_refer_code=$result1["order_refer_code"];	
$order_refer_code1=$result1["order_refer_code1"];	
if($order_refer_code1 !=''){
$order_refer = "$order_refer_code/$order_refer_code1";
}else{
$order_refer = $result1["order_refer_code"];
}
	
if($result1["delivery"]=='1' or $result1["delivery"]=='2'){
$delivery_name = substr($objResuut3["delivery_name"],0,5);	
}else{
$delivery_name = $objResuut3["delivery_name"];		
}
	
	
 $save="insert into tb_delivery_report (ref_id,date_send,tracking,iv_no,product_name,count_ss,delivery,delivery_price) values ('".$result1["ref_id"]."','".$result1["date_ker"]."','".$order_refer."','".$result1["doc_no"]."','','','".$delivery_name."','".$result1["ker_bath"]."')";
$qsave=mysqli_query($conn,$save);

} 

$sql4 = "SELECT ref_id,delivery,date_ker,ker_bath,order_refer_code1,order_refer_code,doc_no  FROM so__main  where 1  ";

if($start_date !=""){ 
    $sql4 .= ' AND date_ker >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql4 .= ' AND date_ker <= "'.$end_date.'"'; 
}

if($company1 !=""){ 
    $sql4 .= ' AND select_type_doc = "'.$company1.'"'; 
}

$query4 = mysqli_query($conn,$sql4) or die ("Error Query [".$sql4."]");
$Num_Rows4 = mysqli_num_rows($query4);

while($result4 = mysqli_fetch_array($query4)){

$strSQL6 = "select delivery_name from tb_delivery where delivery_id ='".$result4["delivery"]."'";
$objQuery6 = mysqli_query($conn,$strSQL6);
$objResuut6 = mysqli_fetch_array($objQuery6,MYSQLI_ASSOC);
	
$order_refer_coden = $result4["order_refer_code"];	
$order_refer_coden1 = $result4["order_refer_code1"];	
if($order_refer_coden1 !=''){
$order_refer1 = "$order_refer_coden/$order_refer_coden1";
}else{
$order_refer1 = $result4["order_refer_code"];
}	
	
if($result4["delivery"]=='1' or $result4["delivery"]=='2'){
$delivery_name = substr($objResuut6["delivery_name"],0,5);	
}else{
$delivery_name = $objResuut6["delivery_name"];		
}	
	
 $save="insert into tb_delivery_report (ref_id,date_send,tracking,iv_no,product_name,count_ss,delivery,delivery_price) values ('".$result4["ref_id"]."','".$result4["date_ker"]."','".$order_refer1."','".$result4["doc_no"]."','','','".$delivery_name."','".$result4["ker_bath"]."')";
$qsave=mysqli_query($conn,$save);	

} 

$sql8 = "SELECT ref_idsmp,smp_no,date_ker,ker_bath,ref_no,ref_no1  FROM hos__smp  where 1  ";
if($start_date !=""){ 
    $sql8 .= ' AND date_ker >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql8 .= ' AND date_ker <= "'.$end_date.'"'; 
}

if($company1 !=""){ 
    $sql8 .= ' AND type_company = "'.$company1.'"'; 
}

$query8 = mysqli_query($conn,$sql8) or die ("Error Query [".$sql8."]");
$Num_Rows8 = mysqli_num_rows($query8);


while($result8 = mysqli_fetch_array($query8)){
		
$strSQL9 = "select address_1 from tb_register_data where ref_id ='".$result8["ref_idsmp"]."'";
$objQuery9 = mysqli_query($conn,$strSQL9);
$objResuut9 = mysqli_fetch_array($objQuery9,MYSQLI_ASSOC);
	
$ref_no = $result8["ref_no"];	
$ref_no1 = $result8["ref_no1"];	
if($ref_no1 !=''){
$ref_non = "$ref_no/$ref_no1";
}else{
$ref_non = $result8["ref_no"];
}		

$address_19=trim($objResuut9["address_1"]);	
	
 $save="insert into tb_delivery_report (ref_id,date_send,tracking,iv_no,product_name,count_ss,delivery,delivery_price) values ('".$result8["ref_idsmp"]."','".$result8["date_ker"]."','".$ref_non."','".$result8["smp_no"]."','','','".$address_19."','".$result8["ker_bath"]."')";
$qsave=mysqli_query($conn,$save);			

} 

$sql11 = "SELECT ref_id,iv_no,date_ker,ker_bath,order_refer_code,order_refer_code1  FROM hos__so  where 1  ";
if($start_date !=""){ 
    $sql11 .= ' AND date_ker >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql11 .= ' AND date_ker <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $sql11 .= ' AND type_doc = "'.$company.'"'; 
}

$query11 = mysqli_query($conn,$sql11) or die ("Error Query [".$sql11."]");
$Num_Rows11 = mysqli_num_rows($query11);

	while($result11 = mysqli_fetch_array($query11)){
		
$strSQL12 = "select address_1 from tb_register_data where ref_id ='".$result11["ref_id"]."'";
$objQuery12 = mysqli_query($conn,$strSQL12);
$objResuut12 = mysqli_fetch_array($objQuery12,MYSQLI_ASSOC);
		
$ref_nor = $result11["order_refer_code"];	
$ref_nor1 = $result11["order_refer_code"];	
if($ref_no1 !=''){
$ref_nonr = "$ref_nor/$ref_nor1";
}else{
$ref_nonr = $result11["order_refer_code"];
}		
$address_112 =	trim($objResuut12["address_1"]);		
		
 $save="insert into tb_delivery_report (ref_id,date_send,tracking,iv_no,product_name,count_ss,delivery,delivery_price) values ('".$result11["ref_id"]."','".$result11["date_ker"]."','".$ref_nonr."','".$result11["iv_no"]."','','','".$address_112."','".$result11["ker_bath"]."')";
$qsave=mysqli_query($conn,$save);		
		

} 

$sql14 = "SELECT ref_id_br,iv_no,date_ker,ker_bath,order_refer_code,order_refer_code1  FROM hos__br  where 1  ";
if($start_date !=""){ 
    $sql14 .= ' AND date_ker >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql14 .= ' AND date_ker <= "'.$end_date.'"'; 
}

if($company1 !=""){ 
    $sql14 .= ' AND company = "'.$company1.'"'; 
}

$query14 = mysqli_query($conn,$sql14) or die ("Error Query [".$sql14."]");
$Num_Rows14 = mysqli_num_rows($query14);

while($result14 = mysqli_fetch_array($query14)){
		
$strSQL15 = "select address_1 from tb_register_data where ref_id ='".$result14["ref_id_br"]."'";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResuut15 = mysqli_fetch_array($objQuery15,MYSQLI_ASSOC);
	
$ref_nobr = $result14["order_refer_code"];	
$ref_norb1 = $result14["order_refer_code1"];	
if($ref_no1 !=''){
$ref_nonbr = "$ref_nor/$ref_nor1";
}else{
$ref_nonbr = $result14["order_refer_code"];
}		
$address_115 =	trim($objResuut15["address_1"]);		
$save="insert into tb_delivery_report (ref_id,date_send,tracking,iv_no,product_name,count_ss,delivery,delivery_price) values ('".$result14["ref_id_br"]."','".$result14["date_ker"]."','".$ref_nonbr."','".$result14["iv_no"]."','','','".$address_115."','".$result14["ker_bath"]."')";
$qsave=mysqli_query($conn,$save);		

} 


$sql17 = "SELECT del_date,iv_no,ker_bath,ref_no,ref_no1,pro_name,type_del  FROM tb_deloth  where 1  ";
if($start_date !=""){ 
    $sql17 .= ' AND del_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql17 .= ' AND del_date <= "'.$end_date.'"'; 
}

if($company1 !=""){ 
    $sql17 .= ' AND company = "'.$company1.'"'; 
}

$query17 = mysqli_query($conn,$sql17) or die ("Error Query [".$sql17."]");
$Num_Rows17 = mysqli_num_rows($query17);

while($result17 = mysqli_fetch_array($query17)){
	
$ref_nonor = $result17["ref_no"];	
$ref_nonor1 = $result17["ref_no1"];	
if($ref_nonor1 !=''){
$ref_nonbrm = "$ref_nonor/$ref_nonor";
}else{
$ref_nonbrm = $result17["ref_no"];
}		
		
$save="insert into tb_delivery_report (ref_id,date_send,tracking,iv_no,product_name,count_ss,delivery,delivery_price) values ('','".$result17["del_date"]."','".$ref_nonbrm."','".$result17["iv_no"]."','".$result17["pro_name"]."','','".$result17["type_del"]."','".$result17["ker_bath"]."')";
$qsave=mysqli_query($conn,$save);			
		

} 
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">ลำดับที่</td>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="12%" align="center" class="style30">เลขที่พัสดุ</td> 
<td width="12%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">รายการสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">การจัดส่ง</td> 
<td width="8%" align="center" class="style30">ค่าจัดส่ง</td> 
</tr>

<?php
	
$sql20 = "SELECT *  FROM tb_delivery_report  where 1  ";
if($start_date !=""){ 
    $sql20 .= ' AND date_send >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql20 .= ' AND date_send <= "'.$end_date.'"'; 
}
$sql20 .= 'ORDER BY delivery DESC ,date_send ASC'; 
$query20 = mysqli_query($conn,$sql20) or die ("Error Query [".$sql20."]");
$Num_Rows20 = mysqli_num_rows($query20);
$i=1;
while($result20 = mysqli_fetch_array($query20)){
	
	?>
<tr>
<td  align="center" class="style30"><?php echo  $i; ?></td>
<td  align="center" class="style30"><?php echo  Datethai($result20["date_send"]); ?> </td>
<td   class="style30"><div align="left"><?php echo  $result20["tracking"]; ?></div></td> 
<td align="center" class="style30"><?php echo $result20["iv_no"];  ?></td> 

<td class="style30">
<div align="left">
<?php
$ref_id =  substr($result20["ref_id"], 0, 2);	
	
if($ref_id=='')	{
	 echo $result20["product_name"];
}else if($ref_id=='SO'){
	$strSQL13 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$result20["ref_id"]."' ";
		$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
		while($objResult13 = mysqli_fetch_array($objQuery13)) { ?>
							<?php
 	echo $objResult13["sol_name"]; 
	?><br />
						<?php }
}else if($ref_id=='SM'){
	
$strSQL10 = "SELECT sol_name FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$result20["ref_id"]."' ";
$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
while($objResult10 = mysqli_fetch_array($objQuery10)) {  
	echo $objResult10["sol_name"]; 

	
	?><br><?php } 
	}else if($ref_id=='BR'){
	
	$strSQL16 = "SELECT sol_name FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$result20["ref_id"]."' ";
		$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
		while($objResult16 = mysqli_fetch_array($objQuery16)) { ?>
							<?php
 	echo $objResult16["sol_name"]; 
	?><br />
						<?php }
	}else{
	
$strSQL2 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$result20["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
<?php	echo $objResult2["sol_name"]; 	?><br>
						<?php }
}
	?>
	
	
</div></td> 


	

<td  class="style30"><div align="right">
	<?php 
	if($ref_id=='')	{
		
	}else if($ref_id=='SO'){
		
	$strSQL15 = "SELECT count,unit_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$result20["ref_id"]."' and product_type !='อื่นๆ'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
while($objResult15 = mysqli_fetch_array($objQuery15)) { ?>
	
	<?php echo  $objResult15["count"]; ?> <?php echo  $objResult15["unit_name"]; ?>
		<br>
													<?php }	
		
		}else if($ref_id=='SMP'){
		
		$strSQL15 = "SELECT sale_count,unit_name FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$result20["ref_id"]."' and product_type !='อื่นๆ'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
while($objResult15 = mysqli_fetch_array($objQuery15)) { ?>
	
	<?php echo  $objResult15["sale_count"]; ?> <?php echo  $objResult15["unit_name"]; ?>
		<br>
													<?php } 
		
		}else if($ref_id=='BR')	{
		
		$strSQL15 = "SELECT count,unit_name FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$result20["ref_id"]."' and product_type !='อื่นๆ'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
while($objResult15 = mysqli_fetch_array($objQuery15)) { ?>
	
	<?php echo  $objResult15["count"]; ?> <?php echo  $objResult15["unit_name"]; ?>
		<br>
													<?php }
		
		}else{
$strSQL5 = "SELECT sale_count,unit_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$result20["ref_id"]."' and product_type !='อื่นๆ'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
while($objResult5 = mysqli_fetch_array($objQuery5)) { ?>
	
	<?php echo  $objResult5["sale_count"]; ?> <?php echo  $objResult5["unit_name"]; ?>
		<br>
													<?php } 
	}
	?>

	</div></td> 
<td  class="style30"><div align="left"><?php echo $result20["delivery"]; ?></div></td> 
<td  align="right" class="style30"><?php echo number_format($result20["delivery_price"],2).""; ?></td> 
	</tr>



<?php 
$i++;
} ?>

<?php
$strSQL25 = "SELECT SUM(delivery_price) AS sum_amount FROM tb_delivery_report WHERE 1 ";
$objQuery25 = mysqli_query($conn,$strSQL25);
$objResult25 = mysqli_fetch_array($objQuery25);
?>


<tr>
<td width="5%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="12%" align="center" class="style30"></td> 
<td width="12%" align="center" class="style30"></td>
<td width="25%" align="center" class="style30">รวมค่าจัดส่งทั้งหมด</td> 
	<td width="8%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
<td width="8%"  class="style30"><div align="right"><?php echo   number_format($objResult25["sum_amount"],2).""; ?> บาท</div></td> 
	</tr>
</table>

</p>
</body>
</html>