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
	<form action='register_recevebr_edit1.php' method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>รายการรับจ่ายเอกสารใบยืมสินค้า</h4>
			<h4>(Record for Stock movement order)</h4></div>

			<?php
include "dbconnect.php";

date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;

$strSQL = "SELECT *  FROM tb_register_br  where id_br = '".$_GET["id_br"]."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);



?>


<div class="w3-bar">
		
<?php if($objResult["company"]=='1'){ ?>
		
<input type="radio" checked='checked' name="company" value = "1">&nbsp; AWL
<input type="radio" name="company"  value="2" >&nbsp;NBM
<?php }else{ ?>
<input type="radio"  name="company" value = "1">&nbsp; AWL
<input type="radio" name="company" checked='checked' value="2" >&nbsp;NBM

	<?php } ?>

		
	</div>

</p>

<input type="hidden" name="id_br"  id="id_br"  class="button4" value="<?php echo $objResult["id_br"]; ?>" style="width:30%;" required> 


		วันที่ : &nbsp;&nbsp;&nbsp;<input type="date" name = "br_date" id="br_date" value="<?php echo $objResult["br_date"]; ?>" class = "button4"> &nbsp;&nbsp;
		<?php if($objResult["doc_2"]=='1'){ ?>
		
<input type="checkbox" checked='checked' name="doc_2" value = "1">&nbsp; เอกสารรอบ 2 
<?php }else{ ?>
<input type="checkbox"  name="doc_2" value = "1">&nbsp; เอกสารรอบ 2

	<?php } ?> 
		</p>
		
		
เลขที่ BRN.P : &nbsp;<input type="text" name="iv_no"  id="iv_no"  class="button4" value="<?php echo $objResult["iv_no"]; ?>" style="width:30%;" required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

ชื่อลูกค้า  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='text' name = "customer_name"  id = "customer_name" class="button4" value="<?php echo $objResult["customer_name"]; ?>" style="width:30%;" /> </p>




				</p>


เอกสาร 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	

<?php if($objResult["company"]=='1'){ ?>

<?php if($objResult["doc_white"]=='1'){ ?>
		
<input type="checkbox" checked='checked' name="doc_white" value = "1">&nbsp; สีขาว
<?php }else{ ?>
<input type="checkbox"  name="doc_white" value = "1">&nbsp; สีขาว

	<?php } ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php if($objResult["doc_green"]=='1'){ ?>
		
<input type="checkbox" checked='checked' name="doc_green" value = "1">&nbsp; สีเขียว
<?php }else{ ?>
<input type="checkbox"  name="doc_green" value = "1">&nbsp; สีเขียว

	<?php } 
									}
?>

<?php if($objResult["company"]=='2'){ ?>
<?php	
		if($objResult["doc_purple"]=='1'){ ?>
		
<input type="checkbox" checked='checked' name="doc_purple" value = "1">&nbsp; สีม่วง
<?php }else{ ?>
<input type="checkbox"  name="doc_purple" value = "1">&nbsp; สีม่วง

	<?php } ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php if($objResult["doc_greenckk"]=='1'){ ?>
		
<input type="checkbox" checked='checked' name="doc_greenckk" value = "1">&nbsp; สีเขียว
<?php }else{ ?>
<input type="checkbox"  name="doc_greenckk" value = "1">&nbsp; สีเขียว



	<?php } 
}
?>


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php if($objResult["doc_check"]=='1'){ ?>
		
<input type="checkbox" checked='checked' name="doc_check" value = "1">&nbsp; ใบตรวจทาน
<?php }else{ ?>
<input type="checkbox"  name="doc_check" value = "1">&nbsp; ใบตรวจทาน

	<?php } ?>
	</p>
	การติดตามงาน : </p>
	ครั้งที่่ 1 (วันที่) : &nbsp;&nbsp;&nbsp;<input type="date" name = "date_trace1" id="date_trace1" value="<?php echo $objResult["date_trace1"]; ?>" class = "button4"> </p>
สาเหตุ :   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  

<?php if($objResult["doc_2"]=='1'){ ?>

<?php if($objResult["complete_ckk"]=='1'){ ?>
<input type="checkbox" checked='checked' name="complete_ckk" value = "1">&nbsp; Complete เหตุผล :
<?php }else{ ?>
<input type="checkbox"  name="complete_ckk" value = "1">&nbsp; Complete เหตุผล :
<?php } ?>

<?php } ?>

</p>
<textarea name="trace_des1"  class="button4" id="trace_des1" cols="54" rows="3" ><?php echo $objResult["trace_des1"]; ?></textarea> 

<?php if($objResult["doc_2"]=='1'){ ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<textarea name="complete_des"  class="button4" id="complete_des" cols="54" rows="3" ><?php echo $objResult["complete_des"]; ?></textarea>
<?php } ?>
</p>
	ครั้งที่่ 2 (วันที่) : &nbsp;&nbsp;&nbsp;<input type="date" name = "date_trace2" id="date_trace2" value="<?php echo $objResult["date_trace2"]; ?>" class = "button4"> </p>
สาเหตุ : </p>
<textarea name="trace_des2"  class="button4" id="trace_des2" cols="54" rows="3" ><?php echo $objResult["trace_des2"]; ?></textarea> </p>
แจ้ง Sup (วันที่) : &nbsp;<input type="date" name = "sup_date" id="sup_date" value="<?php echo $objResult["sup_date"]; ?>" class = "button4"> </p>
สาเหตุ : </p>
<textarea name="sup_des"  class="button4" id="sup_des" cols="54" rows="3" ><?php echo $objResult["sup_des"]; ?></textarea> </p>
	ใบ Car (วันที่) : &nbsp;&nbsp;&nbsp;<input type="date" name = "car_date" id="car_date" value="<?php echo $objResult["car_date"]; ?>" class = "button4"> </p>
สาเหตุ : </p>
<textarea name="car_des"  class="button4" id="car_des" cols="54" rows="3" ><?php echo $objResult["car_des"]; ?></textarea> </p>

หมายเหตุ : </p>
 <textarea name="remark"  class="button4" id="remark" cols="54" rows="3" ><?php echo $objResult["remark"]; ?></textarea></p>

<?php if($objResult["cancel"]=='1'){ ?>
		
<input type="checkbox" checked='checked' name="cancel" value = "1">&nbsp; ยกเลิก
<?php }else{ ?>
<input type="checkbox"  name="cancel" value = "1">&nbsp; ยกเลิก

	<?php } ?> </p>
หมายเหตุการยกเลิก : </p>
<textarea name="cancel_des"  class="button4" id="cancel_des" cols="54" rows="3" ><?php echo $objResult["cancel_des"]; ?></textarea></p>

<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</form>
</div></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	

  </body>
</html>
  

