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
<?php
include("dbconnect.php");

/*$sql1 = "select * from tb_vendor where vendor_code  LIKE '%".$POST_["vendor_group_code"]."%'' order by vendor_code desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
<script type="text/javascript">
	function sSelect(){
		var vendor_group_code = document.frmMain.vendor_group_code.value
		
		if(vendor_group_code == 'VD1'){
			document.frmMain.vendor_group_name.value  = "Supplier ต่างประเทศ";
		}else if(vendor_group_code == 'VD2'){
			document.frmMain.vendor_group_name.value  = "Supplier ในประเทศ";
		}else if(vendor_group_code == 'VONE'){
			document.frmMain.vendor_group_name.value  = "Supplier เงินสด";
		}
	}
</script>*/
?>


<body>
<form   method="post" name="frmMain" enctype="multipart/form-data" >
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>EDIT : VENDOR</h4></div>


<?php
		$strSQL = "SELECT *  FROM tb_vendor WHERE vendor_id = '".$_GET["vendor_id"]."' ";


		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	?>


<div class="w3-half">

<div class="w3-container w3-third">
รหัสกลุ่มผู้ขาย
<input name="vendor_group_code" value="<?php echo $objResult["vendor_group_code"]; ?>" class="w3-input" >
<input  type ='hidden' name="vendor_id" value="<?php echo $objResult["vendor_id"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">
ชื่อกลุ่มผู้ขาย
<input name="vendor_group_name" value="<?php echo $objResult["vendor_group_name"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
รหัสผู้ขาย
<input name="vendor_code" value="<?php echo $objResult["vendor_code"]; ?>" class="w3-input" >
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">

<?php 
/*
จังหวัด
<select name="province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
*/ ?>
คำนำหน้าชื่อ 
<input name="prefix" value="<?php echo $objResult["prefix"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">
 ชื่อผู้ภาษาไทย
<input name="vendor_name_th"  value="<?php echo $objResult["vendor_name_th"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 รหัสผู้ขายเก่า
<input name="vendor_code_old" value="<?php echo $objResult["vendor_code_old"]; ?>" class="w3-input" >
</div>

</div>


<div class="w3-half">

<div class="w3-container w3-third">
 สกุลเงิน
<input name="currency" value="<?php echo $objResult["currency"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 รหัสบัญชีเจ้าหนี้
<input name="account_payable_code" value="<?php echo $objResult["account_payable_code"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
ชื่อบัญชีเจ้าหนี้
<input name="account_payable_name" value="<?php echo $objResult["account_payable_name"]; ?>" class="w3-input" >
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">

<?php
if ( $objResult["condition_id"]=='1'){
?>
<input type='checkbox' name="condition_id" value='1' checked='checked' >&nbsp;เงื่อนไขการชำระเงิน
<?php
}else {
	?>

<input type='checkbox' name="condition_id" value='1'  >&nbsp;เงื่อนไขการชำระเงิน

		<?php
}
		?>




</div><div class="w3-container w3-third">
 รหัสกลุ่มจัดซื้อ (Pur Group)
<input name="pur_group_code" value="<?php echo $objResult["pur_group_code"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 ชื่อรหัสกลุ่มจัดซื้อ
<input name="pur_group_name" value="<?php echo $objResult["pur_group_name"]; ?>" class="w3-input" >
</div>

</div>


<div class="w3-half">

<div class="w3-container w3-third">
เลขที่ผู้เสียภาษี
<input name="tax_number" value="<?php echo $objResult["tax_number"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 หมายเลขโทรศัพท์ติดต่อ1
<input name="telephone_number1" value="<?php echo $objResult["telephone_number1"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
หมายเลขโทรศัพท์ติดต่อ2
<input name="telephone_number2" value="<?php echo $objResult["telephone_number2"]; ?>" class="w3-input" >
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">
เบอร์มือถือ
<input name="mobile_number" value="<?php echo $objResult["mobile_number"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
 เบอร์แฟกซ์
<input name="fax" class="w3-input" value="<?php echo $objResult["fax"]; ?>" >
</div><div class="w3-container w3-third">
 อีเมลล์
<input name="email" class="w3-input" value="<?php echo $objResult["email"]; ?>">
</div>

</div>


<div class="w3-half">

<div class="w3-container w3-third">
เว็บไซต์
<input name="website" class="w3-input" value="<?php echo $objResult["website"]; ?>">
</div><div class="w3-container w3-third">
ลำดับผู้ติดต่อ
<input name="contact_number" class="w3-input" value="<?php echo $objResult["contact_number"]; ?>">
</div><div class="w3-container w3-third">
คำนำหน้าผู้ติดต่อ
<input  name="contact_prefix" class="w3-input" value="<?php echo $objResult["contact_prefix"]; ?>">
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">
ชื่อผู้ติดต่อ
<input name="contact_name" class="w3-input" value="<?php echo $objResult["contact_name"]; ?>">
</div><div class="w3-container w3-third">
 ตำแหน่งผู้ติดต่อ
<input name="contact_position" class="w3-input" value="<?php echo $objResult["contact_position"]; ?>">
</div><div class="w3-container w3-third">
 หมายเหตุ
<input name="description" class="w3-input" value="<?php echo $objResult["description"]; ?>">
</div>

</div>




<div class="w3-half">

<div class="w3-container w3-third">
หมายเลขโทรศัพท์ติดต่อ1
<input name="contact_telephone1" class="w3-input" value="<?php echo $objResult["contact_telephone1"]; ?>">
</div><div class="w3-container w3-third">
หมายเลขโทรศัพท์ติดต่อ2
<input name="contact_telephone2" class="w3-input" value="<?php echo $objResult["contact_telephone2"]; ?>">
</div><div class="w3-container w3-third">
Mobile ผู้ติดต่อ
<input  name="contact_mobile" class="w3-input" value="<?php echo $objResult["contact_mobile"]; ?>">
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">
Fax ผู้ติดต่อ
<input name="contact_fax" class="w3-input" value="<?php echo $objResult["contact_fax"]; ?>">
</div><div class="w3-container w3-third">
 Email ผู้ติดต่อ
<input name="contact_email" class="w3-input" value="<?php echo $objResult["contact_email"]; ?>">
</div><div class="w3-container w3-third">
 อาคาร
<input name="buiding" class="w3-input" value="<?php echo $objResult["buiding"]; ?>">
</div>

</div>


<div class="w3-half">

<div class="w3-container w3-third">
เลขที่
<input name="house_number" class="w3-input" value="<?php echo $objResult["house_number"]; ?>">
</div><div class="w3-container w3-third">
หมู่ที่
<input name="village_no" class="w3-input" value="<?php echo $objResult["village_no"]; ?>">
</div><div class="w3-container w3-third">
ซอย
<input  name="alley" class="w3-input" value="<?php echo $objResult["alley"]; ?>">
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">
ถนน
<input name="road" class="w3-input" value="<?php echo $objResult["road"]; ?>">
</div><div class="w3-container w3-third">
 แขวง
<input name="district" class="w3-input" value="<?php echo $objResult["district"]; ?>">
</div><div class="w3-container w3-third">
 เขต
<input name="area" class="w3-input" value="<?php echo $objResult["area"]; ?>">
</div>

</div>


<div class="w3-half">

<div class="w3-container w3-third">
จังหวัด
<input name="province" class="w3-input" value="<?php echo $objResult["province"]; ?>">
</div><div class="w3-container w3-third">
ไปรษณีย์
<input name="post_code" class="w3-input" value="<?php echo $objResult["post_code"]; ?>">
</div><div class="w3-container w3-third">
ประเทศ
<input  name="country" class="w3-input" value="<?php echo $objResult["country"]; ?>">
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">
ภ.ง.ด.
<input name="tax_id" class="w3-input" value="<?php echo $objResult["tax_id"]; ?>">
</div>

</div>







<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_vendor1.php'; submit()">
</center>

<br>

</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

</form>
</body>
</html>


