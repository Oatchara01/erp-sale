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

?>

<fieldset></p></p></p>

<center>
<img src="img/warnning.png" align="center"  width="140" height="100" border="0" /></br></p></p></p>
		
<span class="style15"><font color='red'><b>ไม่สามารถลงทะเบียนรับประกันสินค้าได้ !!!!!!!!</b></font></span></p>
<span class="style15">สินค้า :</span> <span class="style15"><b><?php echo $_GET["product"];?> </b></span> </p>
<span class="style15">หมายเลขเครื่อง :</span> <span class="style15"><b><?php echo $_GET["sn"];?> </b></span> </p>
<span class="style15"><font color='red'><b>*** กรุณาแคปหน้าจอของท่าน และส่งข้อมูลให้กับศูนย์บริการหลังการขายผ่าน LINE</b></font></span></p>	
<a href="https://lin.ee/svUcVUP" class="w3-center"><img src="img/line_allwellsv.png" align="center"  width="220" height="80" border="0" /></center>
</p>
</fieldset>


