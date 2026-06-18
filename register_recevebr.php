<?php include ("head.php"); ?>
<html>
<head>


<style type="text/css">

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 8px 10px;
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
<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
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
</head>
<body>
	<form action='register_recevebr1.php' method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>รายการรับจ่ายเอกสารใบยืมสินค้า</h4>
			<h4>(Record for Stock movement order)</h4></div>

<div class="w3-bar">
		
<input type="radio" checked='checked' name="company" value = "1">&nbsp; AWL
<input type="radio" name="company"  value="2" >&nbsp;NBM

		
	</div>

</p>

<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>



		วันที่ : &nbsp;&nbsp;&nbsp;<input type="date" name = "br_date" id="br_date" value="<?php echo $today; ?>" class = "button4"> </p>
		
		
เลขที่ BRN.P : &nbsp;<input type="text" name="iv_no"  id="iv_no"  class="button4" style="width:30%;" required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

ชื่อลูกค้า  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='text' name = "customer_name"  id = "customer_name" class="button4"  style="width:30%;" /> </p>




				</p>

<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</form></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
  
  <!--/div-->

  </body>
</html>
  

