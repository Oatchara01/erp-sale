<?php include('head.php'); 

include "dbconnect.php";
?>
<body>

<div class="w3-white">
<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey"><h3>EDIT : การรับประกันสินค้า</h3></div>
<form action="edit_warpro1.php" name="frmAdd" method="POST" onSubmit="JavaScript:return fncSubmit();">

<?php

$strSQL = "SELECT * FROM tb_product where product_ID='".$_GET["product_ID"]."'";
$objQuery = mysqli_query($conn,$strSQL);
$objResult = mysqli_fetch_array($objQuery);


?>
<fieldset><legend><b><font color='blue'>ข้อมูลสินค้า</font></b></legend><br>	
 <input type='hidden' id="product_ID" class="w3-input"  style="width:90%;" value="<?php echo $objResult["product_ID"];?>" name="product_ID">

<div class="w3-row" style="display: flex; gap: 10px;">
    <div class="w3-third" style="flex: 1;">
        รหัสสินค้า 
        <input type='text'  class="w3-input"  style="width:90%;" value="<?php echo $objResult["access_code"];?>" >
    </div>
  
    <div class="w3-third" style="flex: 1;">
        ชื่อสินค้า 

<textarea  class="w3-input"  style="width:90%;" rows="2"><?php echo $objResult["sol_name"];?></textarea>	
    </div>
</div>
	<br>


<br></fieldset>
<br>	
<fieldset><legend><b><font color='blue'>Homecare</font></b></legend><br>	
 <input type='hidden' id="product_ID" class="w3-input"  style="width:90%;" value="<?php echo $objResult["product_ID"];?>" name="product_ID">

<div class="w3-row" style="display: flex; gap: 10px;">
    <div class="w3-third" style="flex: 1;">
        จำนวนรับประกัน 
        <input type='text' id="war_hc" class="w3-input"  style="width:90%;" value="<?php echo $objResult["war_hc"];?>" name="war_hc">
    </div>
    <div class="w3-third" style="flex: 1;">
        หน่วยรับประกัน: 
        <input type='text' id="unit_hc" class="w3-input"  style="width:90%;" value="<?php echo $objResult["unit_hc"];?>" name="unit_hc">
    </div>
    <div class="w3-third" style="flex: 1;">
        หมายเหตุรับประกัน 

<textarea name="remark_hc"  class="w3-input" id="remark_hc" style="width:90%;" rows="2"><?php echo $objResult["remark_hc"];?></textarea>	
    </div>
</div>
	<br>


<br></fieldset>
<br>
<fieldset><legend><b><font color='blue'>Hospital</font></b></legend><br>	
 <input type='hidden' id="product_ID" class="w3-input"  style="width:90%;" value="<?php echo $objResult["product_ID"];?>" name="product_ID">

<div class="w3-row" style="display: flex; gap: 10px;">
    <div class="w3-third" style="flex: 1;">
        จำนวนรับประกัน 
        <input type='text' id="war_hos" class="w3-input"  style="width:90%;" value="<?php echo $objResult["war_hos"];?>" name="war_hos">
    </div>
    <div class="w3-third" style="flex: 1;">
        หน่วยรับประกัน: 
        <input type='text' id="unit_hos" class="w3-input"  style="width:90%;" value="<?php echo $objResult["unit_hos"];?>" name="unit_hos">
    </div>
    <div class="w3-third" style="flex: 1;">
        หมายเหตุรับประกัน 
<textarea name="remark_hos"  class="w3-input" id="remark_hos" style="width:90%;" rows="2"><?php echo $objResult["remark_hos"];?></textarea>
    </div>
</div>
	<br>


<br></fieldset>
	
<br>
<center>
<input type="submit" name="button" id="button" value="Submit"  class = "w3-button w3-green w3-center" />
</center>
	
<br>	
	
	
</form>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	
