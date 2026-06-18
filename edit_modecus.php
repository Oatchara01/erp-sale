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
		$strSQL = "SELECT *  FROM tb_mode_customer WHERE id_mode = '".$_GET["id_mode"]."' ";
		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	?>


<div class=" w3-container w3-half">

ชื่อช่องทางการขายแบบสั้น
<input name="mode_name"  value = "<?php echo $objResult["mode_name"]; ?>" class="w3-input" >
<input name="id_mode"  type ='hidden' value = "<?php echo $objResult["id_mode"]; ?>" class="w3-input" >

</div>



<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_modecus1.php'; submit()">
</center>

<br>

</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
</form>
</body>
</html>


