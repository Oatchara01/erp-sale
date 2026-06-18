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
include "dbconnect_sale.php";

   	date_default_timezone_set("Asia/Bangkok");

$files_url = $_POST['linkurl']; ////'uploads/installdata_test2.csv';
$objCSV = fopen($files_url,'r');

$objArr = fgetcsv($objCSV, 1000, ",");

while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) { 

	
$order_id = $objArr[0];
$product_id = $objArr[1];
$iv_no = $objArr[2];


if($order_id !=''){	

$strSQL1 ="SELECT id  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  order_id ='".$order_id."' and product_id";
$objQuery1 =mysqli_query($conn,$strSQL1);
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);



$save1 = " Update  so__submain set clear_ivno1 = '".$iv_no."' where  id ='".$objResult1["id"]."'";
$qsave1 = mysqli_query($conn,$save1);


	
$strSQL ="SELECT id_submain  FROM (st__main LEFT JOIN st__sbmain ON st__main.ref_id=st__sbmain.ref_idd) WHERE  order_id ='".$order_id."' and product_id = '".$product_id."'";

$objQuery =mysqli_query($new,$strSQL);
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);



$save2 = " Update  st__sbmain set clear_ivno = '".$iv_no."'  where  id_submain ='".$objResult["id_submain"]."'";
$qsave2 = mysqli_query($new,$save2);


}
}


fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($qsave1){
	echo "<script language=\"JavaScript\">";
echo "alert('Importข้อมูลของท่านเรียบร้อยแล้ว');window.location='main_admin.php';";
echo "</script>";
	  }else{
   echo 'ไม่สามารถ Import ข้อมูลได้';
 }
?>
