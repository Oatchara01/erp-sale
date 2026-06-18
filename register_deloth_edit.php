<?php include ("head.php"); ?>
<?php include('dbconnect.php'); ?>

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
	<form action='register_deloth_edit1.php' method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>รายการค่าจัดส่ง</h4></div>


<?php
date_default_timezone_set("Asia/Bangkok");

$strSQL1 = "SELECT * FROM tb_deloth WHERE id = '".$_GET["id"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);

?>
<?php if($objResult1["company"]=='1'){ ?>
<input type="radio" name="company"  id="company" value = '1' checked="checked" class="button4" > AWL &nbsp;&nbsp;
			<input type="radio" name="company"  id="company" value = '2' class="button4" > NBM
			<?php }elseif($objResult1["company"]=='2'){ ?>
			<input type="radio" name="company"  id="company" value = '1'  class="button4" > AWL &nbsp;&nbsp;
			<input type="radio" name="company"  id="company" value = '2' checked="checked" class="button4" > NBM
			<?php } ?>
			
			</p>
		<?php if($objResult1["send_cs"]=='2'){ ?>
<input type="checkbox" name="send_cs"  id="send_cs" checked="checked" value = '2' class="button4" > ส่งข้อมูลเข้าระบบลงงาน CS
		<?php }else{ ?>
<input type="checkbox" name="send_cs"  id="send_cs"  value = '1' class="button4" > ส่งข้อมูลเข้าระบบลงงาน CS	
		<?php } ?>
		<br>
		<input name="id" class="button4" type="hidden" id="id" value="<?php echo $_GET["id"];?>">
		
		วันที่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="del_date" class="button4" style="width:20%;" type="date" id="del_date" value="<?php echo $objResult1["del_date"];?>">
		</p>
		
		
เลขที่เอกสาร : &nbsp;
		<input type="text" name="iv_no"  id="iv_no" value="<?php echo $objResult1["iv_no"];?>" class="button4" style="width:20%;" > &nbsp;&nbsp;&nbsp;
</p>
สินค้า  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

 <textarea type='text' name = "pro_name"  id = "pro_name" class="button4"  style="width:25%;" ><?php echo $objResult1["pro_name"];?></textarea>


</p>
เลขที่พัสดุ1  :  &nbsp;&nbsp;

<input type='text' name = "ref_no"  id = "ref_no" class="button4" value="<?php echo $objResult1["ref_no"];?>" style="width:20%;" />

 </p>
เลขที่พัสดุ2  :  &nbsp;&nbsp;
<input type='text' name = "ref_no1"  id = "ref_no1" class="button4" value="<?php echo $objResult1["ref_no1"];?>" style="width:20%;" />


</p>

การขนส่ง : &nbsp; &nbsp;&nbsp;

<select name="type_del" id="type_del" style="width:260px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_typedel ORDER BY id ASC";
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($objResult1["type_del"] == $objResuut5["type_del"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["type_del"];?>" <?php echo $sel;?>><?php echo $objResuut5["type_del"];?></option>
<?php
}
?>
</select>

</p>
ค่าจัดส่ง  : &nbsp; &nbsp;&nbsp;

<input type='text' name = "ker_bath"  id = "ker_bath" class="button4" value="<?php echo $objResult1["ker_bath"];?>" style="width:20%;" /> 

</p>


<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</form></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	
  
  <!--/div-->

  </body>
</html>
  

