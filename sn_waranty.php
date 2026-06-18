<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Allwell Healthcare</title>
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/tab.css">
<?php 
include('dbconnect.php');
 ?>
<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 18px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
-->
	
	</style>
<center><br><br>
<?php

$iinn = $_POST["ddlProductBrand"];	
$type_warr = $_POST["type_warr"];	

if($type_warr=='2'){	
$strSQL = "SELECT * FROM tb_prowaranty where product_name ='".$iinn."' ";
}else{
$strSQL = "SELECT * FROM tb_prowaranty where id ='".$iinn."' ";	
}
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);	
	?>
<!--img src="img/waranty_sn.jpeg" align="center"  width="360" height="150" border="0" /-->	
	
	<h3><b>สินค้า <?php echo $objResult["product_name"]; ?></b></h3>
	<br><br>
	
	<?php if($objResult["img_up"]!=''){ ?>
	<img src="waranty/<?php echo $objResult["img_up"]; ?>" align="center"  width="350" height="250" border="0" >
	<?php }else{ ?>
	
	<center>ไม่มีรูปแสดง</center>
 	<?php } ?>
	
<br><span class = 'style37'>
	<br>
	ตัวอย่าง การดูเลข Serial Number
ให้ลูกค้าใช้ ตัวอักษร ตัวเลข ทั้งหมด ที่อยู่บนสติกเกอร์ Barcode ที่กล่องสินค้าเหมือนรูปตัวอย่าง
กรอกในช่อง Serial number ค่ะ </span>	
	
	</center>