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
	<div class="w3-white">
<?php
include "dbconnect.php";

date_default_timezone_set("Asia/Bangkok");

$files_url = $_POST['linkurl'];
$objCSV = fopen($files_url,'r');
$objArr = fgetcsv($objCSV, 1000, ",");

while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE){ 

	
$order_id = trim($objArr[0]);
$ref_no = $objArr[1];

if($order_id !=''){	
	
$date_arr = explode('/' , $objArr[2] );
$date_ker = $date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0];

$save=" Update  hos__smp set ref_no='".$ref_no."',date_ker = '".$date_ker."'  where  order_id ='".$order_id."'";
$qsave=mysqli_query($conn,$save);

	

}
}
	
	


	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($qsave){
echo "<script language=\"JavaScript\">";
echo "alert('Importข้อมูลของท่านเรียบร้อยแล้ว');window.location='main_admin.php';";
echo "</script>";
	  }else{
   echo 'ไม่สามารถ Import ข้อมูลได้';
 }
?>


</body>
</html>