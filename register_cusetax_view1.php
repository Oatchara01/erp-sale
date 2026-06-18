<?php //include('head3.php');?>
 <?php include('dbconnect.php'); ?>
 </br>
<style type="text/css">
.style15 {
	font-size: 18px; color: #000000; 
}
	.style16 {
	font-size: 16px; color: #000000; 
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
	
</style>

	
	
<?php

// include "dbconnect.php";

$ref_id = $_GET["ref_id"];

$strSQL22 = "SELECT * FROM tb_customer_etax WHERE ref_id = '".$ref_id."' ";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);

?>

<fieldset></p></p></p>

<center>
<img src="img/allwell_2307.png" align="center"  width="100" height="120" border="0" /></br></p></p></p>
		
<span class="style15">คุณ :</span> <span class="style15"><b><?php echo $objResult22["head_name"];?> <?php echo $objResult22["last_name"];?></b></span></p> 
<span class="style15">E-mail :</span> <span class="style15"><b><?php echo $objResult22["mail_cus"];?> </b></span> </p>

	
<a href="" class="w3-button w3-grey w3-center"><span class="style15"><b>ได้ทำการบันทึกขอใบกำกับภาษีอิเล็กทรอนิกส์เรียบร้อยแล้ว</b></span></a></center>
</p>
</fieldset>


