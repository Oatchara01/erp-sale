<?php 


include('head.php');
include('dbconnect_sale.php');

 
 
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
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>EDIT : ข้อมูลวงเงินลูกค้า</h4></div>
<?php
		$strSQL = "SELECT *  FROM tb_customer WHERE customer_id = '".$_GET["customer_id"]."' ";
		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	
	   $strSQLmode = "SELECT *  FROM tb_mode_customer WHERE id_mode = '".$objResult["mode_name"]."' ";
	   $objQuerymode = mysqli_query($conn,$strSQLmode) or die(mysqli_error());
	   $objResultmode = mysqli_fetch_array($objQuerymode);
	   
	   $sql20 = "SELECT * FROM tb_cuscredit_upfile WHERE cus_id = '".$objResult["customer_id"]."'";
       $qry20 = mysqli_query($conn, $sql20) or die(mysqli_error($conn));
       $rs20 = mysqli_fetch_assoc($qry20);

	   
	
	
	
	
	?>
<fieldset><legend ><b><font color="red">ข้อมูลพื้นฐาน</font></b></legend></p>
	
<div class="w3-container w3-third">
ประเภทลูกค้า
<select name="type_customer" id="type_customer" class="w3-input"   readonly>
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_typecustomer order by type_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["type_customer"] == $objResuut5["type_id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['type_id']; ?>" <?php echo $sel;?>><?php echo $objResuut5['type_name']; ?></option>
<?php } ?>
</select>



</div><div class="w3-container w3-third">
รหัสลูกค้า AWL
<input name="customer_code" value = "<?php echo $objResult["customer_code"]; ?>" class="w3-input" readonly>
</div><div class="w3-container w3-third">
รหัสลูกค้า NBM
<input name="customer_coden" value = "<?php echo $objResult["customer_coden"]; ?>" class="w3-input" readonly>
</div><div class="w3-container w3-third">
คำนำหน้าชื่อ
<input name="preface_name" value = "<?php echo $objResult["preface_name"]; ?>" class="w3-input" readonly>


</div>

	
<div class="w3-container w3-third">
กลุ่มลูกค้า
<input name="mode_name" id ="mode_name" placeholder="ค้นหากลุ่มลูกค้า..." value = "<?php echo $objResultmode["mode_name"]; ?>" class="w3-input" readonly>
<input name="h_mode_name" type='hidden' id="h_mode_name" value = "<?php echo $objResult["mode_name"]; ?>" class="w3-input" >
</div>		
<div class="w3-container w3-third">
หมายเหตุ(รหัสลูกค้าอื่นๆ)
<textarea name="remark_cus" rows="2" class="w3-input" readonly><?php echo $objResult["remark_cus"]; ?></textarea>
</div>	
<?php if($_SESSION["name"]=='นงลักษณ์' or $_SESSION["name"]=='อัจฉรา' or $_SESSION["name"]=='พัชร์ชนัญ' or $_SESSION["name"]=='สุดารัตน์' or $_SESSION["name"]=='รุจิรา' ){ ?>	
<div class="w3-container w3-third">
การชำระเงิน
<select name="credit_ckk" id="credit_ckk" class="w3-input"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_bank where close_ckk ='0' order by id";
$objQuery5 = mysqli_query($code,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["credit_ckk"] == $objResuut5["id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['id']; ?>" <?php echo $sel;?>><?php echo $objResuut5['pay_in']; ?></option>
<?php } ?>
</select>
</div>	

<div class="w3-container w3-third">
วงเงิน
<input name="credit_thb" id="credit_thb" value = "<?php echo number_format($objResult["credit_thb"],2).""; ?>" style="color:black;text-align:right" class="w3-input" >
</div>	
	
<?php } ?>	
	
</p>
</fieldset>
</p>

<fieldset><legend ><b><font color="red">ข้อมูลลูกค้า</font></b></legend></p>


<div class="w3-container w3-third">

<?php /**/ ?>
ชื่อลูกค้า
<input name="customer_name" value = "<?php echo $objResult["customer_name"]; ?>" class="w3-input" readonly>
	<input name="customer_id" type='hidden' value = "<?php echo $objResult["customer_id"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">
 ที่อยู่
<input name="cus_address" value = "<?php echo $objResult["cus_address"]; ?>" class="w3-input" readonly>
</div><div class="w3-container w3-third">
 เขต/อำเภอ
<input name="cus_ampher" value = "<?php echo $objResult["cus_ampher"]; ?>" class="w3-input" readonly>
</div>




<div class="w3-container w3-third"readonly>
 จังหวัด
<select name="cus_province" class="w3-select">
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { 

if($objResult["cus_province"] == $fepro["province_name"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>" <?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

</div><div class="w3-container w3-third">
 รหัสไปรษณีย์
<input name="cus_postcode" value = "<?php echo $objResult["cus_postcode"]; ?>" class="w3-input" readonly>
</div><div class="w3-container w3-third">
โทรศัพท์
<input name="cus_tel" value = "<?php echo $objResult["cus_tel"]; ?>" maxlength ="15" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="w3-input" readonly>
</div>



<div class="w3-container w3-third">
แฟ็กซ์
<input name="cus_fax" value = "<?php echo $objResult["cus_fax"]; ?>" class="w3-input" readonly>
</div>
<div class="w3-container w3-third">
<?php if($objResult["vip_ckk"]=='1'){ ?>	
<br><input type='checkbox' value='1' checked='checked' id='vip_ckk' name = 'vip_ckk'> ลูกค้า VIP	
	<?php }else{ ?>
<br><input type='checkbox' value='1' id='vip_ckk' name = 'vip_ckk'> ลูกค้า VIP	
	<?php } ?>
	</div>
</p>
</fieldset>
</p>

<fieldset><legend ><b><font color="red">ข้อมูลการแก้ไข</font></b></legend></p>


<div class="w3-container w3-third">
รายละเอียดการแก้ไข
<textarea name="remark_edit" id="remark_edit" rows="2" class="w3-input" ></textarea>
</div>	
<div class="w3-container">
	
<input type = "hidden" name="img_up_1" value = "<?php echo $rs20["img_up1"]; ?>" class="w3-input" >	
<input type = "hidden"  name="img_up_2" value = "<?php echo $rs20["img_up2"]; ?>" class="w3-input" >	
<input  type = "hidden" name="img_up_3" value = "<?php echo $rs20["img_up3"]; ?>" class="w3-input" >	
	
	
</p>แนบไฟล์ </p>
<input name="img_up1"  type="file">
<?php if($rs20['img_up1']!=''){ ?>
                        <a href="up_cuscredit/<?php echo $rs20['img_up1']; ?>" target="_blank">
                            <img src="img/create.png" width="23" height="23" border="0" />
                        </a>
                    <?php } ?>

</p>
<input name="img_up2"  type="file">
<?php if($rs20['img_up2']!=''){ ?>
                        <a href="up_cuscredit/<?php echo $rs20['img_up2']; ?>" target="_blank">
                            <img src="img/create.png" width="23" height="23" border="0" />
                        </a>
                    <?php } ?>

</p>
<input name="img_up3"  type="file">
<?php if($rs20['img_up3']!=''){ ?>
                        <a href="up_cuscredit/<?php echo $rs20['img_up3']; ?>" target="_blank">
                            <img src="img/create.png" width="23" height="23" border="0" />
                        </a>
                    <?php } ?>
</div>

</p>
</fieldset>
</p>

<br>
<center>
<?php
$name =	$_SESSION["name"];
if($_SESSION['user_type']=="Engineer"){}else{
	//if($name=='ปิยะ' or $name=='พัชร์ชนัญ' or $name=='บรรจบพร' or $name=='สุภาวดี' or $name=='ขนิษฐา'){	?>
<input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_customer_credit1.php'; submit()">
<?php } ?>	
</center>

<br></div></div>



<div id="cr_bar"><?php include "foot.php"; ?></div>

</form>

</body>
</html>

<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_mode_cus.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("mode_name","h_mode_name");
</script> 
