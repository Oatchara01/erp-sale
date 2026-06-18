<?php 
//include('head1.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";
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
$start_date = date('Y-m-d');

?>
<body>


<div class="w3-container w3-padding-large">

<center>
<span class="style15">รายงานลูกค้าซื้อสินค้าตามช่องทาง E-Commerce</span><br>

<span class="style33"><?php echo Datethai($start_date); ?></span><br>
</center>


<br>
			


<?php

$strSQL19 ="SELECT  DISTINCT ref_id FROM so__main WHERE doc_no NOT LIKE '%BRNP%' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL19 .= ' AND register_date = "'.$start_date.'"'; 
}

$objQuery19 =mysqli_query($conn,$strSQL19);
while($objResult19=mysqli_fetch_array($objQuery19)){
	

$checkSQL = "SELECT ref_id FROM tb__buyecomercs1 WHERE ref_id ='".$objResult19["ref_id"]."' LIMIT 1";
$exists = mysqli_query($conn, $checkSQL);

if (mysqli_num_rows($exists) == 0) {	
	
$strSQL10 ="SELECT  doc_no,doc_release_date,bill_id,customer_name,ref_id,tel,sale_channel,employee_name,select_type_doc,order_id,create_order FROM so__main WHERE ref_id ='".$objResult19["ref_id"]."'";
$objQuery10 =mysqli_query($conn,$strSQL10);
while($objResult10=mysqli_fetch_array($objQuery10)){

$strSQL7 ="SELECT product_id,sale_count,sum_amount,price_per_unit,discount_unit  FROM so__submain  WHERE ref_idd = '".$objResult10["ref_id"]."' and dis_ckk='0'";

$objQuery7 =mysqli_query($conn,$strSQL7);
while($objResult7=mysqli_fetch_array($objQuery7)){



$strSQL16 ="SELECT sol_name,unit_name,group1  FROM tb_product  WHERE product_ID = '".$objResult7["product_id"]."'  ";

$objQuery16 =mysqli_query($conn,$strSQL16);
while($objResult16=mysqli_fetch_array($objQuery16)){


if($objResult10["select_type_doc"]=='1' or $objResult10["select_type_doc"]=='3'){
$company='3';
}else if($objResult10["select_type_doc"]=='2' or $objResult10["select_type_doc"]=='4'){
$company='4';
}



$strSQL71 = "insert into tb__buyecomercs1
(ref_id,bill_id,customer,doc_date,sale_code,doc_no,product_no,count,price,discount,amount,group_pro,sale_chan,company,type_arae,order_id,create_date)
values ('".$objResult10["ref_id"]."','".$objResult10["bill_id"]."','".$objResult10["customer_name"]."','".$objResult10["doc_release_date"]."','".$objResult10["employee_name"]."','".$objResult10["doc_no"]."','".$objResult7["product_id"]."','".$objResult7["sale_count"]."','".$objResult7["price_per_unit"]."','".$objResult7["discount_unit"]."','".$objResult7["sum_amount"]."','".$objResult16["group1"]."','".$objResult10["sale_channel"]."','".$company."','2','".$objResult10["order_id"]."','".$objResult10["create_order"]."')";

$objQuery71 = mysqli_query($conn,$strSQL71);





}
}
}
}
}


?>




</div>
</body>
</html>