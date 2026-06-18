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
<form   method="GET" name="frmMain" enctype="multipart/form-data" >
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>EDIT : สินค้าแลกเครื่องวัดน้ำตาล</h4></div>


<?php
		$strSQL = "SELECT *  FROM tb_prochange WHERE id = '".$_GET["id"]."' ";
		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	?>


<div class="w3-container w3-third">
สินค้าแลกเครื่องวัดน้ำตาล
<input name="prochange" id="prochange" value ="<?php echo $objResult["prochange"]; ?>" class="w3-input" >
<input name="id" id="id" type='hidden' value ="<?php echo $objResult["id"]; ?>" class="w3-input" >

</div>

<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_prochang1.php'; submit()">
</center>

</p>


</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	















</form>














</body>
</html>


