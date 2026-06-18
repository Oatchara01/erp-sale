<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://code.jquery.com/jquery-1.8.3.js"></script>
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/tab.css">
<?php 

include('dbconnect.php');
 
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
.style39 {font-size: 16px; color: #3300FF;}
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
.button4 {padding: 14px 16px; border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>


<body>
<form    method="POST" name="frmMain" enctype="multipart/form-data"  OnSubmit="return fncSubmit();">
	

<?php
$ref_id = $_GET["ref_id"];
	
$sql = "SELECT *   FROM tb_research_showroom where ref_id = '".$ref_id."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);


?>

<div class="w3-container">
 <br><fieldset><br><br>
		
<center>
	<img src="img/allwell_logo.png" align="center" width="250" height="70">
	
<div class="w3-white">
<div class="w3-container w3-padding-large">
		
<div class="w3-panel w3-light-gray"><h3>แบบประเมินเข้าเยี่ยมโชว์รูม ALLWELL</h3></div>
	</center>

	


<h4>วันที่</h4>
<input name="date_research" type='date' id="date_research" value ="<?php echo $rs["date_research"]; ?>" class="button4" style="width:100%;" required>

<h4>ชื่อ - นามสกุล</h4>
<input name="customer_name" id="customer_name" value ="<?php echo $rs["customer_name"]; ?>" class="button4" style="width:100%;" required>

<?php /*<h4>จังหวัด</h4>		
	<select name="province" id="province"  class="button4" style="width:100%;" required>
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_ID ";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { 
if($rs["province"] == $fepro["province_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
	
	?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>" <?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>	<h4>E-Mail</h4>
<input name="email" id="email" class="button4" value ="<?php echo $rs["email"]; ?>" style="width:100%;" required> <h4>งบประมาณที่กำหนดไว้</h4>
	<?php if($rs["price"]=='1'){ ?>
<input type='radio'  name='price' id = 'price' value='1' checked='checked' required> <span class = 'style15' > <?php echo "น้อยกว่า 50,000 ฿" ?> </span><br>
<input type='radio'  name='price' id = 'price' value='2' required> <span class = 'style15'> 50,001 - 100,000 ฿ </span><br>
<input type='radio'  name='price' id = 'price' value='3' required> <span class = 'style15'> <?php echo "มากกว่า 100,000 ฿" ?> </span><br>	
	<?php }else if($rs["price"]=='2'){ ?>
<input type='radio'  name='price' id = 'price' value='1' required> <span class = 'style15' > <?php echo "น้อยกว่า 50,000 ฿" ?> </span><br>
<input type='radio'  name='price' id = 'price' value='2' checked='checked' required> <span class = 'style15'> 50,001 - 100,000 ฿ </span><br>
<input type='radio'  name='price' id = 'price' value='3' required> <span class = 'style15'> <?php echo "มากกว่า 100,000 ฿" ?> </span><br>	
	<?php }else if($rs["price"]=='3'){ ?>
<input type='radio'  name='price' id = 'price' value='1' required> <span class = 'style15' > <?php echo "น้อยกว่า 50,000 ฿" ?> </span><br>
<input type='radio'  name='price' id = 'price' value='2' required> <span class = 'style15'> 50,001 - 100,000 ฿ </span><br>
<input type='radio'  name='price' id = 'price' value='3' checked='checked' required> <span class = 'style15'> <?php echo "มากกว่า 100,000 ฿" ?> </span><br>	
	<?php } ?>
	
	<h4>อุปกรณ์ที่ลูกค้าต้องการให้จำหน่ายเพิ่มเติม</h4>			
<textarea name="remark" id = "remark" class="button4" rows="3" style="width:100%;" required><?php echo $rs["remark"]; ?></textarea>		*/ ?>

<h4>เบอร์ติดต่อ</h4>

<input name="tel"  class="button4" value ="<?php echo $rs["tel"]; ?>" id="tel"  style="width:100%;" required>

	
	
		
<h4>รายการที่ท่านสนใจ</h4>

<select name="product_code" id="product_code"  class="button4" style="width:100%;" required>
<option class="w3-bar" value="">**โปรดเลือกสินค้า**</option>
<?php
$strSQL5 = "SELECT * FROM tb_groresear  ORDER BY id_group ASC";
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($rs["product_code"] == $objResuut5["id_group"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["id_group"];?>" <?php echo $sel;?>><?php echo $objResuut5["group_name"];?></option>
<?php
}
?>

</select>			
		

	
<h4>คะแนนความพึงพอใจการรับบริการหน้าโชว์รูม</h4>	

<?php if($rs["research_ckk"]=='10'){ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' checked='checked' value='10' required> <span class = 'style15'  >10 </span> 
	<?php }else{ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='10' required> <span class = 'style15'  >10 </span>
	<?php } ?>
	
	<?php if($rs["research_ckk"]=='9'){ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' checked='checked' value='9' required> <span class = 'style15'  >9 </span> 
	<?php }else{ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='9' required> <span class = 'style15'  >9 </span>
	<?php } ?>
	
	<?php if($rs["research_ckk"]=='8'){ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' checked='checked' value='8' required> <span class = 'style15'  >8 </span> 
	<?php }else{ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='8' required> <span class = 'style15'  >8 </span>
	<?php } ?>
	
	<?php if($rs["research_ckk"]=='7'){ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' checked='checked' value='7' required> <span class = 'style15'  >7 </span> 
	<?php }else{ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='7' required> <span class = 'style15'  >7 </span>
	<?php } ?>
	
	<?php if($rs["research_ckk"]=='6'){ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' checked='checked' value='6' required> <span class = 'style15'  >6 </span> 
	<?php }else{ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='6' required> <span class = 'style15'  >6 </span>
	<?php } ?>
	
	<?php if($rs["research_ckk"]=='5'){ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' checked='checked' value='5' required> <span class = 'style15'  >5 </span> 
	<?php }else{ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='5' required> <span class = 'style15'  >5 </span>
	<?php } ?>
	
	<?php if($rs["research_ckk"]=='4'){ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' checked='checked' value='4' required> <span class = 'style15'  >4 </span> 
	<?php }else{ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='4' required> <span class = 'style15'  >4 </span>
	<?php } ?>
	
	<?php if($rs["research_ckk"]=='3'){ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' checked='checked' value='3' required> <span class = 'style15'  >3 </span> 
	<?php }else{ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='3' required> <span class = 'style15'  >3 </span>
	<?php } ?>
	
	<?php if($rs["research_ckk"]=='2'){ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' checked='checked' value='2' required> <span class = 'style15'  >2 </span> 
	<?php }else{ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='2' required> <span class = 'style15'  >2 </span>
	<?php } ?>
	
	<?php if($rs["research_ckk"]=='1'){ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' checked='checked' value='1' required> <span class = 'style15'  >1 </span> 
	<?php }else{ ?>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='1' required> <span class = 'style15'  >1 </span>
	<?php } ?>

		
<h4>ข้อคิดเห็น</h4>			
<textarea name="reseach_des" id = "reseach_des" class="button4" rows="3" style="width:100%;"><?php echo $rs["reseach_des"]; ?></textarea>	
	
<br>
<br>

<br><br>
	<center>
<a href="main_allwell.php"  class="w3-button w3-grey w3-center"><font color="red">กลับสู่หน้าหลัก</font></a>	
	</center>
</fieldset>
</div>
</div>
</div>

<div id="cr_bar"> <?php include "foot.php"; ?></div>		
</form>

</body>
</html>


