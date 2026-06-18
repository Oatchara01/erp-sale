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
$type_1 = $_GET["type_1"];
if($company=='3'){
$company1='1';
}else if($company=='4'){
$company1='2';
}
include"dbconnect.php";




?>
<body>

<?php 

$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;



?>

<center>
<span class="style15">รายการเลขที่เอกสารทั้งหมด</span></p>

<span class="style15"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></span><br>

</center>
</p>



<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่ออกเอกสาร</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="25%" align="center" class="style30">รายการสินค้า</td> 

</tr>
	
<?php if($type_1=='1'){	
	
$strSQL ="SELECT  doc_no,doc_release_date,customer_name,ref_id,product_id,sn_number FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no NOT LIKE'%AI%'  and  cancel_ckk = '0' ";


if($start_date !=""){ 
    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
$strSQL .=" order  by doc_release_date ASC  ";


$objQuery =mysqli_query($conn,$strSQL);
while($objResult = mysqli_fetch_array($objQuery)){	

$strSQL1 = "SELECT sol_name FROM tb_product  WHERE product_ID = '".$objResult["product_id"]."' and product_type !='อื่นๆ'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);	
if($Num_Rows1 > 0){	
	?>
<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult["doc_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php	echo $objResult1["sol_name"]; 	?></td> 
<td  align="left" class="style30"><?php echo  $objResult["sn_number"]; ?></td> 

	</tr>	
<?php } 
}
	
	$strSQL ="SELECT  doc_no,doc_release_date,customer_name,ref_id,product_id,sn_number FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no NOT LIKE'%BRN%'  and  cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
	
$strSQL .=" order  by doc_release_date ASC  ";

$objQuery =mysqli_query($conn,$strSQL);
while($objResult = mysqli_fetch_array($objQuery)){	
$strSQL1 = "SELECT sol_name FROM tb_product  WHERE product_ID = '".$objResult["product_id"]."' and product_type !='อื่นๆ'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);
if($Num_Rows1 > 0){	
	
	?>
<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult["doc_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php	echo $objResult1["sol_name"]; 	?></td> 
<td  align="left" class="style30"><?php echo  $objResult["sn_number"]; ?></td> 

	</tr>	
<?php

}
} ?>	


<?php
	}
if($type_1=='2'){

$strSQL ="SELECT  iv_no,iv_date,bill_name,ref_id,product_id,sn FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and status_adm !='ยกเลิก'";


if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}
	
if($company !=""){ 
    $strSQL .= ' AND type_doc = "'.$company.'"'; 
}	

$strSQL .=" order  by iv_date ASC  ";


$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){
$strSQL1 = "SELECT sol_name FROM tb_product  WHERE product_ID = '".$objResult["product_id"]."' and product_type !='อื่นๆ'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);
if($Num_Rows1 > 0){	
?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php	echo $objResult1["sol_name"]; 	?></td> 
<td  align="left" class="style30"><?php echo  $objResult["sn"]; ?></td> 

	</tr>




	<?php
}
}


$strSQL ="SELECT  iv_no,iv_date,bill_name,ref_id,product_id,sn FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and status_adm !='ยกเลิก' ";


if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL .= ' AND type_doc = "'.$company.'"'; 
}	
	
$strSQL .=" order  by iv_date ASC  ";


$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 = "SELECT sol_name FROM tb_product  WHERE product_ID = '".$objResult["product_id"]."' and product_type !='อื่นๆ'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);
if($Num_Rows1 > 0){	
?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php	echo $objResult1["sol_name"]; 	?></td> 
<td  align="left" class="style30"><?php echo  $objResult["sn"]; ?></td>


	</tr>

	<?php }
	
}
}
	?>

	</table>


</body>
</html>