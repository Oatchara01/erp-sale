<?php include('head.php') ;

include "dbconnect.php";

$strSQL78 = "DELETE FROM  tb__bypro_no2  ";
$objQuery78 = mysqli_query($conn,$strSQL78);

$strSQL79 = "DELETE FROM  tb_mode_proreport   ";
$objQuery79 = mysqli_query($conn,$strSQL79);


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
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 16px; color: #FF0000; }
-->


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
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายงานยอดขายเปรียบเทียบตามกลุ่มสินค้า</h4></div>
<form name="frmSearch" action = "report_sumbygrouppro1.php" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">

	<div class="w3-half 1">
<div class="w3-quarter">
	เปรียบเทียบ
	วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" style="width:90%" value="<?php echo $_GET["start_date"];?>" required>


	</div>
	<div class="w3-quarter">
	 ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" style="width:90%" value="<?php echo $_GET["end_date"];?>" required> 

	</div>
		
	<div class="w3-quarter">
กับ วันที่ :
<input name="start_date1" type="date" id="start_date1" class="w3-input w3-light-gray" style="width:90%" value="<?php echo $_GET["start_date1"];?>" required>


	</div>
	<div class="w3-quarter">
	 ถึง
  <input name="end_date1" type="date" id="end_date1" class="w3-input w3-light-gray" style="width:90%" value="<?php echo $_GET["end_date1"];?>" required> 

	</div>	
		</div>
		<div class="w3-half 1">
<div class="w3-quarter">
 บริษัท

<select name="company" id="company" style="width:90%" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="3">ออลล์เวล ไลฟ์ บจก.</option>
<option  value="4">โนเบิล เมด บจก.</option>
	</select>
</div>

<div class="w3-quarter">
 ประเภทฝ่ายขาย

<select name="type_type" id="type_type" style="width:90%" class="w3-input"  >
<option  value="">**โปรดเลือกประเภทฝ่ายขาย**</option>
<option  value="1">แผนกโรงพยาบาล</option>
<option  value="2">แผนก Home Care</option>
<option  value="3">แผนก อื่นๆ</option>
	</select>
</div>
			
<div class="w3-quarter">
 หมวดสินค้า

<select name="modepro" id="modepro" style="width:90%" class="w3-input" >
<option value="">**Please Select**</option>

<?php

$strSQL5 = "SELECT * FROM tb_modepro  ORDER BY mode_name ASC";
$objQuery5 = mysqli_query($new,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["mode_name"];?>"><?php echo $objResuut5["mode_name"];?></option>
<?php
}
?>
</select>

</div>			
			
<div class="w3-quarter">
 แสดงผล <br>

<input type="checkbox" name="count_ckk" id="count_ckk" value="1" > จำนวน
	<input type="checkbox" name="price_ckk" id="price_ckk" value="1" > มูลค่า

</div>					
			
	
	</div>

	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<br>
<!--center>
		  		  <input type="button" name ="Submit" value="ออกรายงาน Excel" class = "button button4" onClick="this.form.action='report_sumbygrouppro_exit.php'; submit()">
</center-->

</div>

<div id="cr_bar"> <?php include "foot.php"; ?></div>




