<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #000000;}
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
$str_arr = $_GET["company"]; 

$company = substr($str_arr, 0,1);
$company1 = substr($str_arr,-1);

if($company =='3'){
$company_name = "บริษัท ออลล์เวล ไลฟ์ จำกัด";

}else if($company =='4'){
$company_name = "บริษัท โนเบิล เมด จำกัด";

}else{
$company_name = "";
}
include"dbconnect.php";



?>
<body>


<center>
<span class="style15">รายการจัดส่ง Kerry <?php echo $company_name; ?></span></p>

</center>
</p>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">NO</td>
<td width="10%" align="center" class="style30">ชื่อผู้รับ/Recipient Name</td>
<td width="10%" align="center" class="style30">เบอร์ผู้รับ/Mobile No.</td> 
<!--td width="10%" align="center" class="style30">Email</td--> 
<td width="10%" align="center" class="style30">ที่อยู่/Address</td> 
<!--td width="10%" align="center" class="style30">Address #2</td--> 
<td width="5%" align="center" class="style30">รหัสไปรษณีย์/Postal code</td> 
<td width="5%" align="center" class="style30">COD Amt (Baht)</td> 
<td width="5%" align="center" class="style30">ชื่อสินค้า/Product name</td> 	
<!--td width="5%" align="center" class="style30">ประเภทพัสดุ/Parcel Type (Box/Envelope/Seal bag)</td--> 
<td width="5%" align="center" class="style30">น้ำหนัก/Weight(kg)</td> 	
<td width="5%" align="center" class="style30">กว้าง/Width(cm)</td> 	
<td width="5%" align="center" class="style30">ยาว/Length(cm)</td> 	
<td width="5%" align="center" class="style30">สูง/Height(cm)</td> 	
<td width="5%" align="center" class="style30">Remark</td> 
<td width="5%" align="center" class="style30">Ref #1</td> 
<td width="5%" align="center" class="style30">Ref #2</td> 
<td width="5%" align="center" class="style30">Sender Ref</td> 

	</tr>
	
<?php

	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  delivery ='1' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$n2=1;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult["bill_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
	

	
	
?>


<tr>
<td  align="center" class="style30"><?php echo $n2; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["tel"]; ?></td>
<!--td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td-->
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?> <?php echo  $objResult["address2"]; ?> <?php echo  $objResult["province"]; ?> <?php echo  $objResult["postcode"]; ?></td> 
<!--td  align="left" class="style30"></td--> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);

while($objResult4=mysqli_fetch_array($objQuery4)){
?>

<tr>
<td  align="center" class="style30"><?php echo $n2; ?></td>
<td  align="center" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult4["tel"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?> <?php echo  $objResult4["address2"]; ?> <?php echo  $objResult4["province"]; ?> <?php echo  $objResult4["postcode"]; ?></td> 
<!--td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?> <?php echo  $objResult4["province"]; ?></td--> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>

<?php
}
$n2++;
} 
?>
	
	
<?php

	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE   delivery ='2' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$n1=$n2;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult["bill_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
	
	
	
$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";	
	
?>


<tr>
<td  align="center" class="style30"><?php echo $n1; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["tel"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?> <?php echo  $objResult["address2"]; ?> <?php echo  $objResult["province"]; ?> <?php echo  $objResult["postcode"]; ?></td> 
<!--td  align="left" class="style30"></td--> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="left" class="style30"><?php echo $summary; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);

while($objResult4=mysqli_fetch_array($objQuery4)){
?>

<tr>
<td  align="center" class="style30"><?php echo $n1; ?></td>
<td  align="center" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult4["tel"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?> <?php echo  $objResult4["address2"]; ?> <?php echo  $objResult4["province"]; ?> <?php echo  $objResult4["postcode"]; ?></td> 
<!--td  align="left" class="style30"></td--> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>

<?php
}
$n1++;
} 
?>
<?php

	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  delivery ='1' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$n3=$n1;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult["bill_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
	
	
	
?>


<tr>
<td  align="center" class="style30"><?php echo $n2; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["tel"]; ?></td>
<!--td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td-->
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?> <?php echo  $objResult["address2"]; ?> <?php echo  $objResult["province"]; ?> <?php echo  $objResult["postcode"]; ?></td> 
<!--td  align="left" class="style30"></td--> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);

while($objResult4=mysqli_fetch_array($objQuery4)){
?>

<tr>
<td  align="center" class="style30"><?php echo $n2; ?></td>
<td  align="center" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult4["tel"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?> <?php echo  $objResult4["address2"]; ?> <?php echo  $objResult4["province"]; ?> <?php echo  $objResult4["postcode"]; ?></td> 
<!--td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?> <?php echo  $objResult4["province"]; ?></td--> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>

<?php
}
$n3++;
} 
?>
	
	
<?php

	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE   delivery ='2' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
$objQuery =mysqli_query($conn,$strSQL);
$n3=$n4;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult["bill_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
	
	
	
$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";	
	
	
?>


<tr>
<td  align="center" class="style30"><?php echo $n1; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["tel"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?> <?php echo  $objResult["address2"]; ?> <?php echo  $objResult["province"]; ?> <?php echo  $objResult["postcode"]; ?></td> 
<!--td  align="left" class="style30"></td--> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="left" class="style30"><?php echo $summary; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);

while($objResult4=mysqli_fetch_array($objQuery4)){
?>

<tr>
<td  align="center" class="style30"><?php echo $n1; ?></td>
<td  align="center" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult4["tel"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?> <?php echo  $objResult4["address2"]; ?> <?php echo  $objResult4["province"]; ?> <?php echo  $objResult4["postcode"]; ?></td> 
<!--td  align="left" class="style30"></td--> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>

<?php
}
$n4++;
} 
?>


<?php
	
$strSQL ="SELECT customer_name,customer_tel,address_name,ref_id FROM tb_register_data WHERE  address_1 LIKE '%KEX%'";

if($start_date !=""){ 
    $strSQL .= ' AND start_date = "'.$start_date.'"'; 
}

$objQuery =mysqli_query($conn,$strSQL);
$y=$n4;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL5 ="SELECT bill_id,iv_no,payment FROM hos__so WHERE  ref_id ='".$objResult["ref_id"]."' and status_doc ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$objResult5=mysqli_fetch_array($objQuery5);	
if($Num_Rows5 > 0){	
$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult5["bill_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
	
if($objResult5["payment"]=='26'){
$strSQL11 ="SELECT SUM(amount) AS amount FROM hos__subso WHERE  ref_idd='".$objResult["ref_id"]."'";
$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11=mysqli_fetch_array($objQuery11);

}	
?>


<tr>
<td  align="center" class="style30"><?php echo $y; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["customer_tel"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="right" class="style30"><?php if($objResult5["payment"]=='26'){ echo number_format($objResult11["amount"]);  } ?></td> 
<td  align="left" class="style30">
	
<?php
if($objResult5["payment"]=='26'){	
	$strSQL31 ="SELECT sol_name,count,unit_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id)  WHERE  ref_idd='".$objResult["ref_id"]."'";
$objQuery31 =mysqli_query($conn,$strSQL31);
while($objResult31=mysqli_fetch_array($objQuery31)){
	echo $objResult31["sol_name"]; echo  $objResult31["count"]; echo  $objResult31["unit_name"];
	?>
	
	<br>
	<?php
}
}
	?>
</td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
	
<td  align="left" class="style30">
	
<?php
	$strSQL31 ="SELECT sol_name,count,unit_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id)  WHERE  ref_idd='".$objResult["ref_id"]."'";
$objQuery31 =mysqli_query($conn,$strSQL31);
while($objResult31=mysqli_fetch_array($objQuery31)){
	echo $objResult31["sol_name"]; echo  $objResult31["count"]; echo  $objResult31["unit_name"];
	?>
	
	<br>
	<?php
}
	?>
</td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
	
<?php

$strSQL6 ="SELECT * FROM tb_delivery_print WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery6 =mysqli_query($conn,$strSQL6);
$Num_Rows6 = mysqli_num_rows($objQuery6);	
$objResult6=mysqli_fetch_array($objQuery6);
if($Num_Rows6 > 0){	
	?>
	
<?php if($objResult6["customer_name1"]!=''){ ?>
<tr>
<td  align="center" class="style30"></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name1"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel1"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name1"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name2"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name2"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel2"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name2"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name3"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name3"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel3"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name3"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name4"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name4"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel4"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name4"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>

<?php if($objResult6["customer_name5"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name5"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel5"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name5"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name6"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name6"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel6"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name6"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
<?php if($objResult6["customer_name7"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name7"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel7"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name7"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
<?php if($objResult6["customer_name8"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name8"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel8"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name8"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
				
<?php if($objResult6["customer_name9"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name9"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel9"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name9"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php
} 
}
	?>
	
<?php
	$y++;
}
?>

<?php

$strSQL5 ="SELECT customer_id,iv_no FROM hos__br WHERE  ref_id_br ='".$objResult["ref_id"]."' and status_doc ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND company = "'.$company1.'"'; 
}	
	
//echo $strSQL5;
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$objResult5=mysqli_fetch_array($objQuery5);	
if($Num_Rows5 > 0){	
$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult5["customer_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
?>


<tr>
<td  align="center" class="style30"></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["customer_tel"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
	
<?php

$strSQL6 ="SELECT * FROM tb_delivery_print WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery6 =mysqli_query($conn,$strSQL6);
$Num_Rows6 = mysqli_num_rows($objQuery6);	
$objResult6=mysqli_fetch_array($objQuery6);
if($Num_Rows6 > 0){	
	?>
	
<?php if($objResult6["customer_name1"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name1"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel1"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name1"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name2"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name2"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel2"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name2"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name3"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name3"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel3"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name3"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name4"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name4"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel4"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name4"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>

<?php if($objResult6["customer_name5"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name5"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel5"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name5"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name6"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name6"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel6"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name6"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
<?php if($objResult6["customer_name7"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name7"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel7"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name7"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
<?php if($objResult6["customer_name8"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name8"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel8"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name8"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
				
<?php if($objResult6["customer_name9"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name9"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel9"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name9"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php
} 
}
	?>
	
<?php
}
?>



<?php

$strSQL5 ="SELECT customer_name,smp_no FROM hos__smp WHERE  ref_idsmp ='".$objResult["ref_id"]."' and status_sup ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND type_company = "'.$company1.'"'; 
}	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$objResult5=mysqli_fetch_array($objQuery5);	
if($Num_Rows5 > 0){	
/*$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult5["customer_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);*/
?>


<tr>
<td  align="center" class="style30"></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["customer_tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
	
<?php

$strSQL6 ="SELECT * FROM tb_delivery_print WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery6 =mysqli_query($conn,$strSQL6);
$Num_Rows6 = mysqli_num_rows($objQuery6);	
$objResult6=mysqli_fetch_array($objQuery6);
if($Num_Rows6 > 0){	
	?>
	
<?php if($objResult6["customer_name1"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name1"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel1"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name1"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name2"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name2"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel2"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name2"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name3"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name3"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel3"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult6["address_name3"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name4"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name4"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel4"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name4"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>

<?php if($objResult6["customer_name5"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name5"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel5"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name5"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name6"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name6"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel6"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name6"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
<?php if($objResult6["customer_name7"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name7"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel7"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name7"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
<?php if($objResult6["customer_name8"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name8"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel8"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name8"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
				
<?php if($objResult6["customer_name9"]!=''){ ?>
<tr>
<td  align="center" class="style30"><?php echo ''; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name9"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel9"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name9"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php
} 
}
	?>
	
<?php
}
?>

<?php

$strSQL5 ="SELECT customer,iv_no FROM hos__change WHERE  ref_id ='".$objResult["ref_id"]."' and status_doc ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND company = "'.$company1.'"'; 
}	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$objResult5=mysqli_fetch_array($objQuery5);	
if($Num_Rows5 > 0){	
$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult5["customer_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
?>


<tr>
<td  align="center" class="style30"><?php echo $y; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["customer_tel"]; ?></td>

<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="right" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>

	<?php
}
} 
?>
	

</table>
<br> <br>

<div  align="right" class="style16">ผู้รับ ....................................................................</div>	<br> <br>

<div  align="right" class="style16">เบอร์โทร .............................................................</div>	<br> <br>

<div  align="right" class="style16">ทะเบียนรถ ..........................................................</div>	

<br> <br>

</body>
</html>