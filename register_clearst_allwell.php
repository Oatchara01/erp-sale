<?php include ("head.php"); ?>



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

<body>
<?php

$sql1 = "select * from hos__receive order by id_auto desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 



$ref_id =$_GET["ref_id"];

$strSQL = "SELECT *   FROM so__main where ref_id ='".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_assoc($objQuery);


	 ?>


	<!--action="register_office1.php"-->
	<form action='register_clearst_allwell1.php' method="post" name="frmMain" enctype="multipart/form-data">
		<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>Register Sale Order</h4></div>

<div class="w3-bar">
		
	<?php if ($objResult['select_type_doc']=='1'){
		?>
<input type="radio" checked='checked' name="type_company" value = "3">&nbsp; ALL
<input type="radio" name="type_company"  value="4" >&nbsp;NBM
<?php }else{ ?>

<input type="radio"  name="type_company" value = "3">&nbsp; ALL
<input type="radio" name="type_company" checked='checked' value="4" >&nbsp;NBM

			<?php } ?>

		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $fetch1['ref_id']+1; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $fetch1['ref_id']+1; ?>">
	</div>

</p>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>
<input type="radio"  name="receive_ckk" value = "1" required>&nbsp; คืนสินค้าด้วยตัวเอง
<input type="radio" name="receive_ckk"  value="2" required>&nbsp;ฝากบุคคลอื่นคืน คุณ &nbsp;

			
  : &nbsp;<input type="text" name="receive_name" class="button4" style="width:15%;" > 
</p>

		วันที่ : 
<input type="date" name = "date_receive" id="date_receive" value="<?php echo $today;?>" class = "button4"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

เลขที่ใบยืม :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="iv_no" value = '<?php echo $objResult['doc_no'];?>' class="button4" style="width:30%;" 	></p>
</p>


ชื่อลูกค้า  : &nbsp;<input type="text" name="customer_name" class="button4" value = '<?php echo $objResult['customer_name'];?>' style="width:30%;" required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	

					ที่อยู่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <textarea rows="2" name="customer_address" class="button4" style="width:30%"  ><?php echo $objResult["address1"]; echo $objResult["address2"]; ?></textarea>
			
			



</p>

เขตการขาย : &nbsp;<input type="text" name="sale_code" class="button4" style="width:30%;" value = '<?php echo $objResult['employee_name'];?>' required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				
				ชื่อผู้ยืม :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="sale_name" value = '<?php echo $_SESSION['name'];?> <?php echo $_SESSION['surname'];?>' class="button4" style="width:30%;" 	></p>

	หมายเหตุ :</p> <textarea rows="2" name="remark_st" class="button4" style="width:30%"  ></textarea></p>


<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>

</div>

<div id="pd" class="w3-container city1" >


	<?php include ('proclear_allwellst.php') ?>



</div>



<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</form> </div> </div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

 
  <!--/div-->

  
 





<script>
$('#more').click(function() {
  if($(this).is(":checked")){
   $("#more-2").show();
  }
  else{
   $("#more-2").hide();
  }
});
</script>