<?php
include "head.php";
include "dbconnect.php";
 ?>

<div class="w3-white">
<div class="w3-container w3-padding-large">
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายงานยอดขายตาม IV</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">

วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
</div>
<div class="w3-container w3-third">


  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">

</div>


<div class="w3-container w3-third">

  บริษัท

<select name="company" id="company" style="width:160px" class="w3-input"   required>
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="31">ออลล์เวล ไลฟ์ บจก.</option>
<option  value="42">โนเบิล เมด บจก.</option>

</select>

</div>
</div>

<div class="w3-half">

<div class="w3-container w3-third">


<input type="submit" value="Search" class="w3-button w3-teal">
</div>
</div>
</div>
</div>
</div>
</form>
	
<?php
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$str_arr = $_GET["company"]; 
$company = substr($str_arr, 0,1);
$company1 = substr($str_arr,-1);

if($start_date !='' and $end_date !='' and $company !=''){	
	?>
	

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่ออกบิล</td>
<td width="10%" align="center" class="style30">เลขที่ IV</td>
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="20%" align="center" class="style30">รายการ</td> 
<td width="10%" align="center" class="style30">ยอดขายก่อน Vat</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 

	</tr>
	
	
<?php	 //and have_order = '0'
$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id,sale_code FROM hos__so WHERE status_doc ='Approve'";
if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}
$strSQL1 .=" order  by iv_date DESC ";
$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){

$strSQL2 ="SELECT SUM(amount) AS amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2=mysqli_fetch_array($objQuery2);
$summary_1=$objResult2['amount'];
$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";

?>

<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult1["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
<td class="style30"><div  align="left" ><?php echo  $objResult1["bill_name"]; ?></div></td> 
<td class="style30"><div  align="left" >
	<?php
$strSQL3 ="SELECT sol_name  FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id)  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";
$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){
echo $objResult3["sol_name"];	?><br><?php } ?>
	</div></td> 
<td class="style30"><div  align="right" ><?php echo $no_vat; ?></div></td> 
<td  align="center" class="style30"><?php echo $objResult1["sale_code"]; ?></td>
	</tr>

	<?php } 
$strSQL11 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,employee_name FROM so__main WHERE doc_no !=''  and  cancel_ckk = '0'";
if($start_date !=""){ 
    $strSQL11 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL11 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}
if($company !=""){ 
    $strSQL11 .= ' AND select_type_doc = "'.$company.'"'; 
}
	
$strSQL11 .=" order  by doc_release_date DESC ";
$objQuery11 =mysqli_query($conn,$strSQL11);
while($objResult11=mysqli_fetch_array($objQuery11)){

$strSQL12 ="SELECT SUM(sum_amount) AS sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult11["ref_id"]."'  ";
$objQuery12 =mysqli_query($conn,$strSQL12);
$objResult12=mysqli_fetch_array($objQuery12);

$summary_1=$objResult12['sum_amount'];
$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";
?>

<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult11["doc_release_date"]); ?></td>
<td  align="center" class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult11["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult11["doc_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult11["customer_name"]; ?></td> 
<td class="style30">
	<div  align="left" >
	<?php
$strSQL13 ="SELECT sol_name  FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id)  WHERE ref_idd = '".$objResult11["ref_id"]."'  ";
$objQuery13 =mysqli_query($conn,$strSQL13);
while($objResult13=mysqli_fetch_array($objQuery13)){
echo $objResult13["sol_name"];	?><br><?php } ?>
	</div>
	</td> 
<td class="style30"><div  align="right" ><?php echo $no_vat; ?></div></td> 
<td align="left" class="style30"><?php echo  $objResult11["employee_name"]; ?></td> 
	</tr>

<?php } 
	

$strSQL21 ="SELECT  iv_no,iv_date,customer_name,ref_id,doc_no,employee_name FROM so__main WHERE iv_no !='' and cancel_ckk = '0'";
if($start_date !=""){ 
    $strSQL21 .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL21 .= ' AND iv_date <= "'.$end_date.'"'; 
}
if($company1 !=""){ 
    $strSQL21 .= ' AND select_type_doc = "'.$company1.'"'; 
}

$strSQL21 .=" order  by iv_date DESC";
$objQuery21 =mysqli_query($conn,$strSQL21);
while($objResult21=mysqli_fetch_array($objQuery21)){

$strSQL22 ="SELECT SUM(sum_amount) AS sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult21["ref_id"]."'  ";
$objQuery22 =mysqli_query($conn,$strSQL22);
$objResult22=mysqli_fetch_array($objQuery22);

$summary_2=$objResult22['sum_amount'];
$no_vat2 = ($summary_2 / 1.07); 
$no_vat2 = number_format( $no_vat2,2)."";


?>
<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult21["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult21["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult21["iv_no"]; ?></span></a></td>

<td  align="left" class="style30"><?php echo  $objResult21["customer_name"]; ?></td> 
<td  align="left" class="style30">
<div  align="left" >
	<?php
$strSQL23 ="SELECT sol_name  FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id)  WHERE ref_idd = '".$objResult21["ref_id"]."'  ";
$objQuery23 =mysqli_query($conn,$strSQL23);
while($objResult23=mysqli_fetch_array($objQuery23)){
echo $objResult23["sol_name"];	?><br><?php } ?>
	</div>	
	</td> 
<td  align="right" class="style30"><?php echo $no_vat2; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult21["employee_name"]; ?></td> 
	</tr>

	<?php } ?>	
	

</table>

<?php } ?>
	
</div>
</div>	
	
	
	