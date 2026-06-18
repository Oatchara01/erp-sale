<?php include('head.php'); ?>


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
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>EDIT : ช่องทางการขาย</h4></div>

<?php
		$strSQL = "SELECT *  FROM tb_salechannel WHERE salechannel_ID = '".$_GET["salechannel_ID"]."' ";


		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	?>


<div class=" w3-container w3-half">

ชื่อช่องทางการขายแบบสั้น
<input name="salechannel_nameshort"  value = "<?php echo $objResult["salechannel_nameshort"]; ?>" class="w3-input" >
<input name="salechannel_ID"  type ='hidden' value = "<?php echo $objResult["salechannel_ID"]; ?>" class="w3-input" >

</div><div class=" w3-container w3-half">


ชื่อช่องทางการขาย
<input name="salechannel_name" value = "<?php echo $objResult["salechannel_name"]; ?>" class="w3-input" >
</div><div class=" w3-container w3-half">

ที่อยู่ 1 
<input name="address1" value = "<?php echo $objResult["address1"]; ?>" class="w3-input" >
</div><div class=" w3-container w3-half">

ที่อยู่ 2
<input name="address2" value = "<?php echo $objResult["address2"]; ?>" class="w3-input" >

</div><div class=" w3-container w3-half">
จังหวัด
<select name="province_id" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_id";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) {

if($objResult["province_id"] == $fepro["province_name"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>

<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>" <?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>


</div><div class=" w3-container w3-half">

รหัสไปรษณีย์
<input name="zip_code" class="w3-input" value = "<?php echo $objResult["zip_code"]; ?>">
</div><div class=" w3-container w3-half">

เพิ่มเติม
<input name="description_chanel" class="w3-input" value = "<?php echo $objResult["description_chanel"]; ?>">
</div>



<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_salechannel1.php'; submit()">
</center>

<br>

</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
</form>
</body>
</html>


