<?php include('head.php'); ?>


<style type="text/css">
<!--
.style15 {
	font-size: 17px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
	
.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>

<body>
<?
include "dbconnect.php";
	
   	date_default_timezone_set("Asia/Bangkok");

$files_url = $_POST['linkurl']; ////'uploads/installdata_test2.csv';
$objCSV = fopen($files_url,'r');

$objArr = fgetcsv($objCSV, 1000, ",");

while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) { 
	
$order_id = $objArr[0];

$strSQL ="SELECT ref_id,select_type_doc FROM so__main WHERE  order_id ='".$order_id."'";
$objQuery =mysqli_query($conn,$strSQL);
$objResult = mysqli_fetch_array($objQuery);
//echo $objResult["ref_id"];
	
$strSQL1 ="SELECT SUM(sum_amount) As sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);

if($objResult1["sum_amount"] >= '2222'){

if($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='3'){
$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,sale_remark)
values ('".$objResult["ref_id"]."','2','2','0.00','0.00','0.00','0.00','4170','4170','0','แถมพิเศษลูกค้าซื้อครบ 2222')";
$objQuery5 = mysqli_query($conn,$strSQL5);
	
}else if($objResult["select_type_doc"]=='2' or $objResult["select_type_doc"]=='4'){
	
$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,sale_remark)
values ('".$objResult["ref_id"]."','2','2','0.00','0.00','0.00','0.00','4182','4182','0','แถมพิเศษลูกค้าซื้อครบ 2222')";
$objQuery5 = mysqli_query($conn,$strSQL5);	
	
}

}else if($objResult1["sum_amount"] >= '2222'){

if($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='3'){
$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,sale_remark)
values ('".$objResult["ref_id"]."','1','1','0.00','0.00','0.00','0.00','4170','4170','0','แถมพิเศษลูกค้าซื้อครบ 2222')";
echo $strSQL5;
$objQuery5 = mysqli_query($conn,$strSQL5);
}else if($objResult["select_type_doc"]=='2' or $objResult["select_type_doc"]=='4'){
	
$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,sale_remark)
values ('".$objResult["ref_id"]."','1','1','0.00','0.00','0.00','0.00','4182','4182','0','แถมพิเศษลูกค้าซื้อครบ 2222')";
echo $strSQL5;
$objQuery5 = mysqli_query($conn,$strSQL5);	
}
}
	


}



	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($objQuery5){
	echo "<script language=\"JavaScript\">";
echo "alert('Importข้อมูลของท่านเรียบร้อยแล้ว');window.location='main_admin.php';";
echo "</script>";
	  }else{
   echo 'ไม่สามารถ Import ข้อมูลได้';
 }
?>
