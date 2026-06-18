<?php 
include('head1.php'); 

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
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$time = date('H:i:s');

?>
<body>


<div class="w3-container w3-padding-large">

<center>
<span class="style15">รายงานลูกค้าซื้อสินค้าตามลูกค้า</span><br>

<span class="style33"><?php echo Datethai($start_date); ?> ถึง<?php echo Datethai($end_date); ?></span><br>
</center>


<br>
			


<?php
$strSQL10 ="SELECT  doc_no,doc_release_date,bill_id,customer_name,ref_id,tel,sale_channel,employee_name,select_type_doc,order_id,province FROM so__main WHERE doc_no NOT LIKE '%BRNP%' and cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL10 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL10 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

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



$strSQL71 = "insert into tb__buycustomer
(ref_id,bill_id,customer,doc_date,sale_code,doc_no,product_no,count,price,discount,amount,group_pro,sale_chan,company,type_arae,order_id,province,tel)
values ('".$objResult10["ref_id"]."','".$objResult10["bill_id"]."','".$objResult10["customer_name"]."','".$objResult10["doc_release_date"]."','".$objResult10["employee_name"]."','".$objResult10["doc_no"]."','".$objResult7["product_id"]."','".$objResult7["sale_count"]."','".$objResult7["price_per_unit"]."','".$objResult7["discount_unit"]."','".$objResult7["sum_amount"]."','".$objResult16["group1"]."','".$objResult10["sale_channel"]."','".$company."','2','".$objResult10["order_id"]."','".$objResult10["province"]."','".$objResult10["tel"]."')";

$objQuery71 = mysqli_query($conn,$strSQL71);





}
}
}
 if($objQuery71){
echo "<script language=\"JavaScript\">";
echo "alert('ดำเนินการเรียบร้อยแล้วค่ะ');window.location='search_buyprodaybuy.php';";
echo "</script>";
	  }else{
   echo 'ไม่สามารถบันทึกข้อมูลได้';
 }

?>




</div>
</body>
</html>