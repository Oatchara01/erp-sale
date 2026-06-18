<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://code.jquery.com/jquery-1.8.3.js"></script>
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/tab.css">
<?php 

include('dbconnect.php');
 


/*<script language="javascript">

	    $("document").ready(function(){
    $("#tel").focusout(function(){
        if($(this).val().length < 10){
            alert("กรุณากรอกเฉพาะตัวเลขให้ครบ10หลัก");
            $(this).focus();
        }
    });
});

</script>*/
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
<form  action= "research_showroom1.php"  method="POST" name="frmMain" enctype="multipart/form-data"  OnSubmit="return fncSubmit();">

	
<div class="w3-container">
 <br><fieldset><br><br>
	
	<center>
	<img src="img/allwell_logo.png" align="center" width="250" height="70">
	
		
<div class="w3-panel w3-light-gray"><h3>แบบประเมินเข้าเยี่ยมโชว์รูม ALLWELL</h3></div>
	</center>
<?php
	
/*$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_research_showroom";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so = "CT";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "001"; 
$nextId = $yearMonth.$maxId1;

}

echo $ref_id ="$so$nextId";*/
	
	
	?>

<h4>วันที่</h4>
<input name="date_research" type='date' id="date_research" value ="<?php echo date('Y-m-d'); ?>" class="button4" style="width:100%;" required>

<h4>ชื่อ - นามสกุล</h4>
<input name="customer_name" id="customer_name" class="button4" style="width:100%;" required>

<?php /*<h4>จังหวัด</h4>		
	<select name="province" id="province"  class="button4" style="width:100%;" required>
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_ID ";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>	*/ ?>

<h4>เบอร์ติดต่อ</h4>

<input name="tel"  class="button4" id="tel"  style="width:100%;" required>

	
<?php /*<h4>E-Mail</h4>
<input name="email" id="email" class="button4" style="width:100%;" required>	*/ ?>	
		
<h4>รายการที่ท่านสนใจ</h4>

<select name="product_code" id="product_code"  class="button4" style="width:100%;" required>
<option class="w3-bar" value="">**โปรดเลือกสินค้า**</option>
<?php
$strSQL5 = "SELECT * FROM tb_groresear   ORDER BY id_group ASC";
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["id_group"];?>"><?php echo $objResuut5["group_name"];?></option>
<?php
}
?>

</select>			
		
<?php /*<h4>งบประมาณที่กำหนดไว้</h4>
	
<input type='radio'  name='price' id = 'price' value='1' required> <span class = 'style15' > <?php echo "น้อยกว่า 50,000 ฿" ?> </span><br>
<input type='radio'  name='price' id = 'price' value='2' required> <span class = 'style15'> 50,001 - 100,000 ฿ </span><br>
<input type='radio'  name='price' id = 'price' value='3' required> <span class = 'style15'> <?php echo "มากกว่า 100,000 ฿" ?> </span><br>	
	
<h4>อุปกรณ์ที่ลูกค้าต้องการให้จำหน่ายเพิ่มเติม</h4>			
<textarea name="remark" id = "remark" class="button4" rows="3" style="width:100%;" required></textarea>	*/ ?>
	
<h4>คะแนนความพึงพอใจการรับบริการหน้าโชว์รูม</h4>	

	<input type='radio'  name='research_ckk' id = 'research_ckk' value='10' required> <span class = 'style15'>10 </span>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='9' required> <span class = 'style15'>9 </span>	
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='8' required> <span class = 'style15'>8</span>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='7' required> <span class = 'style15'  >7 </span> 
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='6' required> <span class = 'style15'>6 </span>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='5' required> <span class = 'style15'>5 </span>	
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='4' required> <span class = 'style15'>4</span>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='3' required> <span class = 'style15'  >3 </span> 
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='2' required> <span class = 'style15'>2</span>
	<input type='radio'  name='research_ckk' id = 'research_ckk' value='1' required> <span class = 'style15'  >1 </span> 	
		
<h4>ข้อคิดเห็น</h4>			
<textarea name="reseach_des" id = "reseach_des" class="button4" rows="3" style="width:100%;" required></textarea>	
	
<br>
<br>
<center>
		  <input type="submit" name ="Submit" value="บันทึก" class = "button button4" >
</center>
<br><br>
</fieldset>
</div>

<?php include('foot.php'); ?>
</form>

</body>
</html>


