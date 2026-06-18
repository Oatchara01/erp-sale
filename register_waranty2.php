<?php include('head3.php');
?>
 
 </br>
<style type="text/css">
<!--
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
	
-->
</style>

	
	
<?php

include"dbconnect.php";

$serial_num = $_GET["serial_num"];

$ref_war = $_GET["ref_war"];


if($ref_war!=''){
$strSQL22 = "SELECT product_name,lot_no,cus_name FROM tb_waranty WHERE ref_war = '".$ref_war."' ";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);
	
}else{	
$strSQL22 = "SELECT product_name,serial_num,cus_name FROM tb_waranty WHERE serial_num = '".$serial_num."' ";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);
}

?>

<fieldset></p></p></p>

<center>
<img src="img/allwell_2307.png" align="center"  width="100" height="120" border="0" /></br></p></p></p>
</center>		
<span class="style15">คุณ :</span> <span class="style15"><b><?php echo $objResult22["cus_name"];?></b></span></p> 
<span class="style15">สินค้า :</span> <span class="style15"><b><?php echo $objResult22["product_name"];?> </b></span> </p>
<?php if($ref_war!=''){ ?>
<span class="style15">Lot Number :</span> <span class="style15"><b><?php echo $objResult22["lot_no"];?> </b></span> </p>
<?php }else{ ?>
<span class="style15">หมายเลขเครื่อง :</span> <span class="style15"><b><?php echo $objResult22["serial_num"];?> </b></span> </p>
<?php } ?>
<center>	
<a href="" class="w3-button w3-grey w3-center"><span class="style15"><b>ได้ทำการบันทึกใบรับประกันเสร็จสิ้นเเล้ว</b></span></a></center>
</p>
</fieldset>


