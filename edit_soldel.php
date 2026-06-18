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
	<form action='edit_soldel1.php' method="post" name="frmMain" enctype="multipart/form-data">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>รายการค่าจัดส่ง</h4>
			</div>


<?php
date_default_timezone_set("Asia/Bangkok");

$strSQL1 = "SELECT order_refer_code1,order_refer_code,ker_bath,date_ker,delivery,doc_no,ref_id FROM so__main WHERE ref_id = '".$_GET["ref_id"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);

?>

		<input name="id" class="button4" type="hidden" id="id" value="<?php echo $_GET["id"];?>">
		
		วันที่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="date_ker" class="button4" style="width:20%;" type="date" id="date_ker" value="<?php echo $objResult1["date_ker"];?>">
		</p>
		
		
เลขที่เอกสาร : &nbsp;
		<input type="text" name="doc_no"  id="doc_no" value="<?php echo $objResult1["doc_no"];?>" class="button4" style="width:20%;" > &nbsp;&nbsp;&nbsp;
		<input type="hidden" name="ref_id"  id="ref_id" value="<?php echo $objResult1["ref_id"];?>" class="button4" style="width:20%;" >
		<input type="hidden" name="start_date"  id="start_date" value="<?php echo $_GET["start_date"];?>" class="button4" style="width:20%;" >
		<input type="hidden" name="end_date"  id="end_date" value="<?php echo $_GET["end_date"];?>" class="button4" style="width:20%;" >

</p>
เลขที่พัสดุ1  :  &nbsp;&nbsp;

<input type='text' name = "order_refer_code"  id = "order_refer_code" class="button4" value="<?php echo $objResult1["order_refer_code"];?>" style="width:20%;" />

 </p>
เลขที่พัสดุ2  :  &nbsp;&nbsp;
<input type='text' name = "order_refer_code1"  id = "order_refer_code1" class="button4" value="<?php echo $objResult1["order_refer_code1"];?>" style="width:20%;" />


</p>

การขนส่ง : &nbsp; &nbsp;&nbsp;

<select name="delivery" class="w3-select" style="width:20%;" >
<option value="">**Please Select Item**</option>
<?php
$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
$querydeli = mysqli_query($conn,$sqldeli);

while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
if($objResult1["delivery"] == $fetchdeli["delivery_id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>" <?php echo $sel;?>><?php echo $fetchdeli['delivery_name'];?> </option>
<?php } ?>
</select>

</p>
ค่าจัดส่ง  : &nbsp; &nbsp;&nbsp;

<input type='text' name = "ker_bath"  id = "ker_bath" class="button4" value="<?php echo $objResult1["ker_bath"];?>" style="width:20%;" /> 

</p>


<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</form>
<div id="cr_bar"> Copyright © 2019 phar trillion co., ltd. </div>
  </div>
  <!--/div-->

  </body>
</html>
  

