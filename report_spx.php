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
<span class="style15">รายการจัดส่ง SPX EXPRESS <?php echo $company_name; ?></span></p>

</center>
</p>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">ชื่อผู้รับ/Recipient Name</td>
<td width="8%" align="center" class="style30">เบอร์โทรศัพท์ผู้รับ/Recipient Phone</td>
<td width="12%" align="center" class="style30">รายละเอียดที่อยู่/Detail Address</td> 
<td width="10%" align="center" class="style30">แขวง/ตำบล/Sub-district</td> 	
<td width="10%" align="center" class="style30">อำเภอ/เขต/City</td> 
<td width="8%" align="center" class="style30">จังหวัด/Province</td> 
<td width="8%" align="center" class="style30">รหัสไปรษณีย์/Postal Code</td> 
<td width="5%" align="center" class="style30">น้ำหนักพัสดุ</td> 
<td width="2%" align="center" class="style30">ช่องว่างไว้</td> 
<td width="2%" align="center" class="style30">ช่องว่างไว้</td> 
<td width="2%" align="center" class="style30">ช่องว่างไว้</td> 
<td width="10%" align="center" class="style30">ชื่อสินค้า </td> 
<td width="2%" align="center" class="style30">ช่องว่างไว้</td> 
<td width="10%" align="center" class="style30">หมายเลขอ้างอิงพัสดุ/Customer Reference No.</td> 
<td width="10%" align="center" class="style30">วิธีการชำระเงิน</td> 
<td width="2%" align="center" class="style30">เก็บเงินปลายทาง (Y/N)/COD Collection(Y/N )</td> 
<td width="10%" align="center" class="style30">มูลค่าการเก็บเงินปลายทาง</td> 
<td width="2%" align="center" class="style30">ประกันคุ้มครองพัสดุ</td> 

	</tr>


<?php

	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='12' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$n=1;
while($objResult=mysqli_fetch_array($objQuery)){

?>


<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo  $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>
	
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);

while($objResult4=mysqli_fetch_array($objQuery4)){
?>
	
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>
		

<?php 
}												 
}
	

	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='3' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$n=1;
while($objResult=mysqli_fetch_array($objQuery)){

?>


<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo  $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>
	
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);

while($objResult4=mysqli_fetch_array($objQuery4)){
?>
	
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>
		

<?php 
}												 
}
	
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='3' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$s=$n;
while($objResult=mysqli_fetch_array($objQuery)){
	
	?>
	
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo  $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>
			
	
<?php
}
	}
	
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='3' and delivery ='36' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$m=$s;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">Y</td>
<td  align="left" class="style30"><?php echo number_format($objResult2["sum_amount"]); ?></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
	
<?php
}
	}

	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='3' and delivery ='36' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);

while($objResult=mysqli_fetch_array($objQuery)){


$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">Y</td>
<td  align="left" class="style30"><?php echo number_format($objResult2["sum_amount"]); ?></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
		

	<?php 
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='41' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$n=1;
while($objResult=mysqli_fetch_array($objQuery)){

?>


<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo  $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>
	
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);

while($objResult4=mysqli_fetch_array($objQuery4)){
?>
	
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>
		

<?php 
}												 
}
	
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='41' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$s=$n;
while($objResult=mysqli_fetch_array($objQuery)){
	
	?>
	
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo  $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>
			
	
<?php
}
	}
	
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='41' and delivery ='36' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$m=$s;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">Y</td>
<td  align="left" class="style30"><?php echo number_format($objResult2["sum_amount"]); ?></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
	
<?php
}
	}

	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='41' and delivery ='36' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);

while($objResult=mysqli_fetch_array($objQuery)){


$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">Y</td>
<td  align="left" class="style30"><?php echo number_format($objResult2["sum_amount"]); ?></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
		

	<?php 
}
	}	
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id,doc_no FROM so__main WHERE  sale_channel='4' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$i=$o;
while($objResult=mysqli_fetch_array($objQuery)){

	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
<?php 
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id,doc_no FROM so__main WHERE  sale_channel='4' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$c=$i;
while($objResult=mysqli_fetch_array($objQuery)){
	

	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='4' and delivery ='36' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$k=$c;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);
	
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">Y</td>
<td  align="left" class="style30"><?php echo  number_format($objResult2["sum_amount"]); ?></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
		
<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='4' and delivery ='36' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$h=$k;
while($objResult=mysqli_fetch_array($objQuery)){
	

$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">Y</td>
<td  align="left" class="style30"><?php echo  number_format($objResult2["sum_amount"]); ?></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>			

<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='22' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$j=$h;
while($objResult=mysqli_fetch_array($objQuery)){
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>				
	
<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='22' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$a=$j;
while($objResult=mysqli_fetch_array($objQuery)){
	
	?>
	
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>					
<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='22' and delivery ='36' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$b=$a;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">Y</td>
<td  align="left" class="style30"><?php echo  number_format($objResult2["sum_amount"]); ?></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>						
<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel='22' and delivery ='36' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$d=$b;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);
	
	?>
	
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">Y</td>
<td  align="left" class="style30"><?php echo  number_format($objResult2["sum_amount"]); ?></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>							
<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no,order_id FROM so__main WHERE  sale_channel='33'  and approve_complete ='Approve' and cancel_ckk='0' and delivery='35'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}

$objQuery =mysqli_query($conn,$strSQL);
$q=$o;
while($objResult=mysqli_fetch_array($objQuery)){
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>								
	
<?php
}
	}
	
/*$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no,order_id FROM so__main WHERE  sale_channel='31' and delivery ='25' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$ss=$q;
while($objResult=mysqli_fetch_array($objQuery)){
	
	?>
	<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>								
<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no,order_id FROM so__main WHERE  sale_channel='31' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);

while($objResult=mysqli_fetch_array($objQuery)){	
	?>
	<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>		
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>							
	
<?php
}
	}*/
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no,order_id FROM so__main WHERE  sale_channel='32' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){
	
	?>
	<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>		
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>							
		
<?php
}
	}

$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no,order_id FROM so__main WHERE  sale_channel='32' and delivery ='36' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
$objQuery =mysqli_query($conn,$strSQL);
$sy=$st;
while($objResult=mysqli_fetch_array($objQuery)){	

$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);
	
	?>
	
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">Y</td>
<td  align="left" class="style30"><?php echo  number_format($objResult2["sum_amount"]); ?></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>							
<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no,order_id,sale_remark FROM so__main WHERE  sale_channel='35' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$sr=$sy;
while($objResult=mysqli_fetch_array($objQuery)){
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>								
	
<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no,order_id,sale_remark FROM so__main WHERE  sale_channel='39' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$sr=$sy;
while($objResult=mysqli_fetch_array($objQuery)){
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>								
	

<?php
}
	}
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no,order_id,sale_remark FROM so__main WHERE  sale_channel='40' and delivery ='35' and approve_complete ='Approve' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$sr=$sy;
while($objResult=mysqli_fetch_array($objQuery)){
	
	?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult4["tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>								
	


	
	
<?php
}
	}
	
$strSQL ="SELECT customer_name,customer_tel,address_name,ref_id,cash FROM tb_register_data WHERE  address_1 LIKE '%SPX%'";

if($start_date !=""){ 
    $strSQL .= ' AND start_date = "'.$start_date.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){
	
$strSQL5 ="SELECT iv_no,payment FROM hos__so WHERE  ref_id ='".$objResult["ref_id"]."' and status_doc ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);
$objResult5=mysqli_fetch_array($objQuery5);	
if($Num_Rows5 > 0){	
if($objResult5["payment"]=='25' or $objResult5["payment"]=='30'){
$strSQL11 ="SELECT SUM(amount) AS amount FROM hos__subso WHERE  ref_idd='".$objResult["ref_id"]."'";
$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11=mysqli_fetch_array($objQuery11);

}	
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["customer_tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30"><?php if($objResult5["payment"]=='25' or $objResult5["payment"]=='30'){ echo "Y";  }else{ echo "N"; } ?></td>
<td  align="left" class="style30"><?php if($objResult5["payment"]=='25' or $objResult5["payment"]=='30'){ echo number_format($objResult11["amount"]);  } ?></td>
<td  align="center" class="style30">N</td>
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
<td  align="left" class="style30"><?php echo $objResult6["customer_name1"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel1"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name2"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name2"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel2"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name2"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name3"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name3"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel3"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name3"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
<?php } if($objResult6["customer_name4"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name4"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel4"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name4"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name5"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name5"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel5"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name5"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
<?php } if($objResult6["customer_name6"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name6"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel6"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name6"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
<?php } if($objResult6["customer_name7"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name7"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel7"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name7"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		

<?php } if($objResult6["customer_name8"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name8"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel8"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name8"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
<?php } if($objResult6["customer_name9"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name9"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel9"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name9"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
<?php
	}
}
}
	
$strSQL5 ="SELECT customer_id,iv_no FROM hos__br WHERE  ref_id_br ='".$objResult["ref_id"]."' and status_doc ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND company = "'.$company1.'"'; 
}	
	
//echo $strSQL5;
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$objResult5=mysqli_fetch_array($objQuery5);	

if($Num_Rows5 > 0){	
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["customer_tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
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
<td  align="left" class="style30"><?php echo $objResult6["customer_name1"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel1"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name2"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name2"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel2"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name2"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name3"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name3"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel3"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name3"]; ?></td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
<?php } if($objResult6["customer_name4"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name4"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel4"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name4"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name5"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name5"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel5"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name5"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
<?php } if($objResult6["customer_name6"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name6"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel6"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name6"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
<?php } if($objResult6["customer_name7"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name7"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel7"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name7"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		

<?php } if($objResult6["customer_name8"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name8"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel8"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name8"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
<?php } if($objResult6["customer_name9"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name9"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel9"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name9"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
<?php
	}
}
}

$strSQL5 ="SELECT customer_name,smp_no FROM hos__smp WHERE  ref_idsmp ='".$objResult["ref_id"]."' and status_sup ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND type_company = "'.$company1.'"'; 
}	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);
$objResult5=mysqli_fetch_array($objQuery5);	
	
if($Num_Rows5 > 0){	
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["customer_tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td>
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["smp_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
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
<td  align="left" class="style30"><?php echo $objResult6["customer_name1"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel1"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["smp_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name2"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name2"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel2"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name2"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["smp_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name3"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name3"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel3"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name3"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["smp_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
<?php } if($objResult6["customer_name4"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name4"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel4"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name4"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["smp_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name5"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name5"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel5"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name5"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["smp_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
<?php } if($objResult6["customer_name6"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name6"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel6"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name6"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["smp_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
<?php } if($objResult6["customer_name7"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name7"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel7"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name7"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["smp_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		

<?php } if($objResult6["customer_name8"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name8"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel8"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name8"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["smp_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
<?php } if($objResult6["customer_name9"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name9"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel9"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name9"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["smp_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
<?php
	}
}
}	
	
$strSQL5 ="SELECT customer,iv_no FROM hos__change WHERE  ref_id ='".$objResult["ref_id"]."' and status_doc ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND company = "'.$company1.'"'; 
}	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$objResult5=mysqli_fetch_array($objQuery5);	


if($Num_Rows5 > 0){	
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["customer_tel"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
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
<td  align="left" class="style30"><?php echo $objResult6["customer_name1"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel1"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name1"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name2"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name2"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel2"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name2"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name3"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name3"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel3"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name3"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
<?php } if($objResult6["customer_name4"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name4"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel4"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name4"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
<?php } if($objResult6["customer_name5"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name5"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel5"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name5"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>	
	
<?php } if($objResult6["customer_name6"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name6"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel6"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name6"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
<?php } if($objResult6["customer_name7"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name7"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel7"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name7"]; ?></td>
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		

<?php } if($objResult6["customer_name8"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name8"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel8"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name8"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
<?php } if($objResult6["customer_name9"]!=''){ ?>	
<tr>
<td  align="left" class="style30"><?php echo $objResult6["customer_name9"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult6["customer_tel9"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name9"]; ?></td> 
<td  align="left" class="style30"></td>	
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="center" class="style30">1</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30"></td>
<td  align="left" class="style30">02 - ของใช้/ เฟอร์นิเจอร์</td> 
<td  align="left" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30">ชำระโดยผู้ส่ง</td>
<td  align="center" class="style30">N</td>
<td  align="left" class="style30"></td>
<td  align="center" class="style30">N</td>
</tr>		
	
<?php
	}
}
}
	
	?>
	
<?php
}

	?>
	
</table>
<br> <br>

</body>
</html>