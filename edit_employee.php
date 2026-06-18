<?php 


include('head.php');

 
 
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
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
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


<body>
<form   method="post" name="frmMain" enctype="multipart/form-data" >

<?php
		$strSQL = "SELECT *  FROM tb_employee WHERE employee_ID = '".$_GET["employee_ID"]."' ";


		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	?>
<div class="w3-panel w3-light-gray"><h4>EDIT : พนักงาน</h4></div>

<div class=" w3-container w3-half">

ชื่อพนักงาน
<input name="employee_name" value="<?php echo $objResult["employee_name"]; ?>" class="w3-input" >
<input type='hidden' name="employee_ID" value="<?php echo $objResult["employee_ID"]; ?>" class="w3-input" >


</div><div class=" w3-container w3-half">

แผนก

<select name="department_id" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_department order by department_ID";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { 

if($objResult["department_id"] == $fepro["department_ID"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>
<option class="w3-bar" value="<?php echo $fepro["department_ID"]; ?>"<?php echo $sel;?>><?php echo $fepro["department_name"]; ?></option>
<?php } ?>
</select>

</div><div class=" w3-container w3-half">

 สถานะ
<select name="status" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_status order by status_ID";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { 
if($objResult["status"] == $fepro["status_ID"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>

<option class="w3-bar" value="<?php echo $fepro["status_ID"]; ?>"  <?php echo $sel;?>><?php echo $fepro["status_name"]; ?></option>
<?php } ?>
</select>
</div>


<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_employee1.php'; submit()">
</center>

</p>



<?php include('foot.php'); ?>















</form>














</body>
</html>


