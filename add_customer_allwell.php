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
<form  action ="add_customer_allwell1.php"  method="POST" name="frmMain" enctype="multipart/form-data" >
	<div class="w3-white">
		<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>ADD : CUSTOMER</h4></div>

	<fieldset><legend ><b><font color="red">ข้อมูลพื้นฐาน</font></b></legend></p>

	
		<div class="w3-container w3-third">
		เขตการขาย
<?php if($_SESSION["department"]=='วิศวกรรม'){ ?>
	<select name="sale_code" id="sale_code"  class="w3-input"  required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>		
			<?php }else{ ?>
<select name="sale_code" id="sale_code"  class="w3-input"  required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_allwell ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
			
	<?php } ?>		
</div><div class="w3-container w3-third">
ประเภทลูกค้า

<select name="type_customer" id="type_customer" class="w3-input"   required>
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_typecustomer order by type_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['type_id']; ?>"><?php echo $objResuut5['type_name']; ?></option>
<?php } ?>
</select>


</div><div class="w3-container w3-third">
คำนำหน้าชื่อ

<select name="preface_name" id="preface_name" class="w3-input"   >
<option  value="">**โปรดเลือกคำนำหน้าชื่อ**</option>
<option  value="คุณ">คุณ</option>
<option  value="มหาวิทยาลัย">มหาวิทยาลัย</option>
<option  value="บริษัท">บริษัท</option>
<option  value="หจก.">หจก.</option>
<option  value="คลินิก">คลินิก</option>
<option  value="ร้าน">ร้าน</option>
<option  value="มูลนิธิ">มูลนิธิ</option>
<option  value="ร้านขายยา">ร้านขายยา</option>
<option  value="ร้านค้า">ร้านค้า</option>
<option  value="โรงพยาบาล">โรงพยาบาล</option>
<option  value="โรงเรียน">โรงเรียน</option>
<option  value="สถาบัน">สถาบัน</option>
<option  value="สำนักงาน">สำนักงาน</option>
<option  value="หสน.">หสน.</option>
<option  value="หสม.">หสม.</option>


		</select>


</div>
<!--div class="w3-container w3-third">
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

?>

<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['id']; ?>" ><?php echo $objResuut5['pay_in']; ?></option>
<?php } ?>
</select>



</div-->
</p>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">ข้อมูลลูกค้า</font></b></legend></p>


<div class="w3-container w3-third">

<?php /**/ ?>
ชื่อลูกค้า
<input name="customer_name" id="customer_name" class="w3-input" required autocomplete="off" required>
<input type="hidden" name="customer_name_dup" id="customer_name_dup" value="0">
<div id="customer_name_msg" style="color:red; font-size:12px; margin-top:4px;"></div>


</div><div class="w3-container w3-third" >
 ที่อยู่
<input name="cus_address" class="w3-input"  required>
</div><div class="w3-container w3-third">
 เขต/อำเภอ
<input name="cus_ampher" class="w3-input" required>
</div>




<div class="w3-container w3-third">
 จังหวัด
<select name="cus_province" class="w3-select" required>
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

</div><div class="w3-container w3-third">
 รหัสไปรษณีย์
<input name="cus_postcode" class="w3-input" required>
</div><div class="w3-container w3-third">
โทรศัพท์
<input name="cus_tel" class="w3-input"  onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}"   required>
</div>



<div class="w3-container w3-third">
แฟ็กซ์
<input name="cus_fax" class="w3-input" >
</div>
<div class="w3-container w3-third">
<br><input type='checkbox' value='1' id='vip_ckk' name = 'vip_ckk'> ลูกค้า VIP	
	</div>
</p>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">ข้อมูลการออกบิล</font></b></legend></p>

<input type="checkbox" name="ckk_1" value ='1' > <font color="blue"> ใช้ข้อมูลเดียวกับข้อมูลลูกค้า</font>
</p>


<div class="w3-container w3-third">
 ชื่อที่ใช้ออกบิล
<input name="bill_name" class="w3-input" >
</div><div class="w3-container w3-third">
 ที่อยู่ออกบิล
<input name="bill_address" class="w3-input" >
</div>


<div class="w3-container w3-third">
เขต/อำเภอ
<input name="bill_ampher" class="w3-input" >
</div><div class="w3-container w3-third">
 
จังหวัด
<select name="billl_province" class="w3-select" >
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>


</div><div class="w3-container w3-third">
รหัสไปรษณีย์
<input name="bill_postcode" class="w3-input" >
</div>


<div class="w3-container w3-third">
โทรศัพท์
<input name="bill_tel" class="w3-input" >
</div><div class="w3-container w3-third">
 TAX ID
<input name="tax_id" class="w3-input" >
</div>
<div class="w3-container w3-third">
E-Mail
<input name="email_cus" class="w3-input" >
</div>
</p>
</fieldset>
</p>
<fieldset><legend ><b><font color="red">ข้อมูลการจัดส่ง</font></b></legend></p>

<input type="checkbox" name="ckk_2" value ='1' > <font color="blue"> ใช้ข้อมูลเดียวกับข้อมูลลูกค้า</font>
</p>


<div class="w3-container w3-third">
 ชื่อที่ใช้ในการจัดส่ง
<input name="delivery_name" class="w3-input" >
</div>


<div class="w3-container w3-third">
ที่อยู่
<input name="del_address" class="w3-input" >
</div><div class="w3-container w3-third">
เขต/อำเภอ
<input name="del_ampher" class="w3-input" >
</div><div class="w3-container w3-third">
จังหวัด
<select name="del_province" class="w3-select" >
<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

</div>


<div class="w3-container w3-third">
รหัสไปรษณีย์
<input name="del_postcode" class="w3-input" >
</div><div class="w3-container w3-third">
 โทรศัพท์
<input name="del_tel" class="w3-input" >
</div><div class="w3-container w3-third">
 ผู้ติดต่อ
<input name="contact_name" class="w3-input" >
</div>

</p>
</fieldset>
</p>



<br>

<center>
		  <input type="submit" name ="Submit" value="บันทึก" class = "button button4" >
</center>
<br>


</div>
<div id="cr_bar"><?php include "foot.php"; ?></div>





</form>


</body>
</html>


<script type="text/javascript">
	
var customerNameInput = document.getElementById("customer_name");
var customerDupInput  = document.getElementById("customer_name_dup");
var customerMsg       = document.getElementById("customer_name_msg");
var formMain          = document.forms["frmMain"];

var lastCheckedName = "";
var duplicateAlertShown = false;
var duplicateNames = [];

function checkCustomerName(callback) {
    var name = customerNameInput.value.trim();

    if (name === "") {
        customerDupInput.value = "0";
        customerMsg.innerHTML = "";
        duplicateNames = [];
        lastCheckedName = "";
        duplicateAlertShown = false;
        if (callback) callback(false);
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "check_customer_name.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                var res = JSON.parse(xhr.responseText);

                if (res.exists) {
                    customerDupInput.value = "1";
                    duplicateNames = res.names || [];

                    var html = "มีชื่อลูกค้าใกล้เคียงในระบบ:<br>";
                    for (var i = 0; i < duplicateNames.length; i++) {
                        html += "- " + duplicateNames[i] + "<br>";
                    }
                    customerMsg.innerHTML = html;

                    if (lastCheckedName !== name || duplicateAlertShown === false) {
                        alert("มีชื่อลูกค้าอยู่แล้ว เช่น:\n- " + duplicateNames.join("\n- "));
                        duplicateAlertShown = true;
                    }
                } else {
                    customerDupInput.value = "0";
                    customerMsg.innerHTML = "";
                    duplicateNames = [];
                    duplicateAlertShown = false;
                }

                lastCheckedName = name;
                if (callback) callback(res.exists);
            } catch (e) {
                customerDupInput.value = "0";
                customerMsg.innerHTML = "";
                duplicateNames = [];
                if (callback) callback(false);
            }
        }
    };

    xhr.send("customer_name=" + encodeURIComponent(name));
}

customerNameInput.addEventListener("blur", function() {
    duplicateAlertShown = false;
    checkCustomerName();
});

customerNameInput.addEventListener("keyup", function() {
    duplicateAlertShown = false;
});

formMain.addEventListener("submit", function(e) {
    e.preventDefault();

    checkCustomerName(function(isDuplicate) {
        if (isDuplicate) {
            var msg = "มีชื่อลูกค้าใกล้เคียงในระบบ:\n- " + duplicateNames.join("\n- ");
            msg += "\n\nต้องการบันทึกต่อหรือไม่?";
            if (!confirm(msg)) {
                return false;
            }
        }

        if (confirm("คุณต้องการบันทึกข้อมูลนี้ใช่หรือไม่?")) {
            formMain.submit();
        }
    });
});
</script>
