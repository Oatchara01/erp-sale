<?php include('head.php'); ?>
<script src="dist/jautocalc.js"></script></head>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script>
function object() {
		if (document.getElementById('object1').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object2').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object3').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'block';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object4').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'block';
		}
	
	}
function ckk_1() {
		if (document.getElementById('object5').checked) {
			document.getElementById('dt5').style.display = 'block';
		}
		else if (document.getElementById('object6').checked) {
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object7').checked) {
			document.getElementById('dt5').style.display = 'none';
		}
}
function chkNumber(ele)
{
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
ele.onKeyPress=vchar;
}
</script>
<body>
<?php
$strSQL = "SELECT
so__main.* ,tb_salechannel.* ,tb_delivery.* ,tb_payment.*  FROM (((so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_id) LEFT JOIN tb_payment ON so__main.payment=tb_payment.payment_ID) WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
?>
<form action='register_office_edit1.php' method="post" name="frmMain" enctype="multipart/form-data" onkeypress="return event.keyCode!=13">
<div class="w3-container w3-padding-large"><!-- main div -->
<div class="w3-container w3-panel w3-light-gray"><h4>Edit Data : Office</h4></div>
<div class="w3-half"><!-- first half -->
<div class="w3-bar w3-border">
<?php
if ($objResult["select_type_doc"]=='1'){
?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="1" onclick="javascript:object();"  id="object1">&nbsp;ใบยืมสินค้า PTL</div>
<?php
}else{
	?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="1" onclick="javascript:object();"  id="object1">&nbsp;ใบยืมสินค้า PTL</div>
		<?php
}
		if ($objResult["select_type_doc"]=='2'){
			?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="2" onclick="javascript:object();"  id="object2" >&nbsp;ใบยืมสินค้า NBM</div>
				<?php
		}else{
				?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="2" onclick="javascript:object();"  id="object2" >&nbsp;ใบยืมสินค้า NBM</div>
					<?php
					}
		if ($objResult["select_type_doc"]=='3'){
?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย PTL</div>
<?php
	}else{
	?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย PTL</div>
		<?php
}
			if ($objResult["select_type_doc"]=='4'){
			?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="4" onclick="javascript:object();"  id="object4" >&nbsp;ใบสั่งขาย NBM</div>
<?php
			}else{
				?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="4" onclick="javascript:object();"  id="object4">&nbsp;ใบสั่งขาย NBM</div>
					<?php
			}
						?>

</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
วันที่ <span class="w3-light-gray"><?php echo DateThai($objResult["register_date"]); ?></span>&nbsp;&nbsp;เลขที่อ้างอิง:&nbsp;<span class="w3-light-gray"><?php echo $objResult['ref_id']; ?></span> <input type="hidden" name="ref_id" class="w3-input25" value="<?php echo $objResult['ref_id']; ?>"> <input type="hidden" name="main_id" value="<?php echo $objResult['main_id']; ?>">
<input type="hidden" name="register_date" value="<?php echo $objResult['register_date']; ?>">
<input type="hidden" name="register_time" value="<?php echo $objResult['register_time']; ?>">
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select"   onchange="showUser(this.value)">
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) 
	{
if($objResult["sale_channel"] == $fetchchannel["salechannel_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>" <?php echo $sel;?>><?php echo $fetchchannel['salechannel_nameshort']; ?>&nbsp;&nbsp;<?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
การจัดส่ง
		<input name="delivery" type='text' class="w3-input" id="delivery" value="<?php echo $objResult["delivery_name"]; ?><?php echo $objResult["time_delivery"]; ?>" placeholder="Search การจัดส่ง..."> 
		<input name="h_delivery" type="hidden" id="h_delivery"  value="<?php echo $objResult["delivery"]; ?>" class="w3-input" /> 


<?php /*<select name="delivery" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
$querydeli = mysqli_query($conn,$sqldeli);

while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
if($objResult["delivery"] == $fetchdeli["delivery_id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>" <?php echo $sel;?>><?php echo $fetchdeli['delivery_name'];?> | <?php echo $fetchdeli['time_delivery']; ?> | <?php echo $fetchdeli['remark']; ?><?php echo $fetchdeli['packing_remark'];?></option>
<?php } ?>
</select>*/?>

</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
การชำระเงิน

<input name="payment" type='text' class="w3-input" id="payment"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน..."> 
<input name="h_payment" type="hidden" id="h_payment" value="<?php echo $objResult["payment"]; ?>" class="w3-input" /> 


<?php/*
<select name="payment" class="w3-select"  >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_payment order by payment_ID";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["payment"] == $objResuut5["payment_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"<?php echo $sel;?>><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?> | <?php echo $objResuut5['book_number']; ?> | <?php echo $objResuut5['branch_bank']; ?> | <?php echo $objResuut5['book_type']; ?> | <?php echo $objResuut5['book_name']; ?> | <?php echo $objResuut5['description_payment']; ?></option>
<?php } ?>
</select>*/?>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
หมายเหต
<textarea name="sale_remark"  class="w3-input" id="sale_remark"  rows="1"><?php echo $objResult['sale_remark']; ?></textarea>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
ชื่อพนักงาน


<input name="employee_name" type='text' class="w3-input" value ="<?php echo $objResult['employee_name']; ?>" id="employee_name" placeholder="Search พนักงาน..."> 
<input name="h_employee_name" type="hidden" id="h_employee_name" value="<?php echo $objResult["employee_name"]; ?>" class="w3-input" /> 



<?php /*
<select  name="employee_name" class="w3-select"  >
<option value="">**Please Select Item**</option>
<?php
$emp = "select * from tb_employee where status=1 order by employee_ID";
$sqlemp = mysqli_query($conn,$emp);
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) {
if($objResult["employee_name"] == $fetchemp["employee_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_ID']; ?>"<?php echo $sel;?>><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>*/?>
</div>
</div><!-- 1st half -->
<!-- tab -->
<div class="w3-half w3-container"><!-- second half -->
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-button"  onclick="openCity('br')"><font color="404040"><b>ใบยืมสินค้า</b></font></a>
  <a class="w3-button" onclick="openCity('so')"><font color="404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-button" onclick="openCity('mo')"><font color="404040"><b>เพิ่มเติม</b></font></a>
  <a class="w3-button" onclick="openCity('ca')"><font color="404040"><b>การโทรรีวิว</b></font></a>

</div>
<div id="br" class="city w3-container">
<?php
$sale_channel=$objResult["sale_channel"];
include "dbconnect.php";
$sql="SELECT tb_salechannel.*,tb_province.* FROM tb_salechannel LEFT JOIN tb_province ON tb_salechannel.province_id=tb_province.province_ID WHERE salechannel_ID = '".$sale_channel."'";

//echo  $sql;
//exit();
$result = mysqli_query($conn,$sql) or die(mysqli_error());
$row = mysqli_fetch_array($result);
?>
<div class="w3-padding-small"></div>
<div class="w3-bar">
วัตถุประสงค์การเบิก <input name='objective'  class='w3-input' value="<?php echo $row["salechannel_nameshort"];?>"/>
</div>
<div class="w3-bar">
หมายเลขคำสั่งซื้อ <input type='text' class='w3-input' name='order_id'  value="<?php echo $objResult["order_id"]; ?>">
</div>
<div class="w3-bar">
ชื่อลูกค้าตามคำสั่งซื้อ <input type='text' class='w3-input' name='order_name' value="<?php echo $objResult["order_name"]; ?>" >
</div>
<div class="w3-bar">
ชื่อลูกค้า <span class="w3-padding-small"><?php echo $row["salechannel_nameshort"];?></span>
</div>

<div class="w3-bar">
วันที่ออกเอกสาร <span class="w3-padding-small"><?php if ($objResult["doc_release_date"]=="0000-00-00") { echo "-"; } else { echo DateThai($objResult["doc_release_date"]); } ?></span>
</div>
<div class="w3-bar">
ชื่อลูกค้า <span class="w3-padding-small"><?php echo $row["salechannel_nameshort"];?></span>
</div>
<div class="w3-bar">
ที่อยู่ <span class="w3-padding-small"><?php echo $row["address1"]; ?>&nbsp;<?php echo $row["address2"]; ?>&nbsp;<?php echo $row['province_name']; ?>&nbsp;<?php echo $row['zip_code']; ?></span>
</div>
<div class="w3-bar">
หมายเหต <span class="w3-padding-small"><?php echo $row['description_chanel']; ?></span>
</div>
</div><!-- close br -->

<div id="so" class="city" style="display:none">
<div class="w3-padding-small"></div>
<div class="w3-half w3-container"><!-- first so half -->
ชื่อที่ออกบิล
<input name="billing_name" type='text' value="<?php echo $objResult['billing_name']; ?>" class="w3-input" >
ทีอยู่ที่ออกบิล
<textarea name="billing_address" class="w3-input" rows="1"><?php echo $objResult['billing_address']; ?></textarea>
<div class="w3-half">
Tel.
<input type="text" name="billing_tel" value="<?php echo $objResult['billing_tel']; ?>" class="w3-input">
</div>
<div class="w3-bar w3-half w3-container">
<?php
if ($objResult['bill_vat']=='1'){
?>
<input type="checkbox" name="bill_vat" checked='checked' value="1"> &nbsp;บิล VAT
<?php
}else{

?>
<input type="checkbox" name="bill_vat" value="1"> &nbsp;บิล VAT

<?php
}
?>

</div>
<div class="w3-bar">การชำระเงิน
<input name="payment1" type='text' class="w3-input" id="payment1"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน..."> 


<?php /*<select name="payment" class="w3-select" disabled>
<option value="">**Please Select Item**</option>
<?php
$strSQL6 = "select * from tb_payment order by payment_ID";
$objQuery6 = mysqli_query($conn,$strSQL6);
if (!$objQuery6) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut6 = mysqli_fetch_array($objQuery6,MYSQLI_ASSOC)) {
if($objResult["payment"] == $objResuut6["payment_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>


<option class="w3-bar-item w3-button"  value="<?php echo $objResuut6['payment_ID']; ?>"<?php echo $sel;?>><?php echo $objResuut6['payment_name']; ?> | <?php echo $objResuut6['bank_name']; ?> | <?php echo $objResuut6['book_number']; ?> | <?php echo $objResuut6['branch_bank']; ?> | <?php echo $objResuut6['book_type']; ?> | <?php echo $objResuut6['book_name']; ?> | <?php echo $objResuut6['description_payment']; ?></option>
<?php } ?>
</select>*/?>
</div>

การโอนเงิน
<select name="transfer" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$strSQL3 = "SELECT * FROM tb_transfer ORDER BY tranfer_ID ASC";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
while($objResult3 = mysqli_fetch_array($objQuery3)){
if($objResult["transfer"] == $objResult3["tranfer_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option value="<?php echo $objResult3["tranfer_name"];?>"<?php echo $sel;?>><?php echo $objResult3["tranfer_name"];?></option>

<?php
}
?>

</select>
<div class="w3-bar">
ส่งบัญชีตรวจสอบ

<?php
if($objResult["account_approve"]=='1'){
?>
<input type="checkbox" name="account_approve" checked='checked' value="1">

<?php
}else{
	?>
<input type="checkbox" name="account_approve" value="1">


		<?php
}
			?>
</div>
<div class="w3-bar">
วันที่โอน
<input type="date" name="transfer_date" id="transfer_date"  value="<?php echo $objResult['transfer_date']; ?>" class="w3-input">
</div>
<div class="w3-bar">
จำนวนเงินโอน/เก็บปลายทาง
<input type="text" name="amount" value="<?php echo $objResult['amount']; ?>" class="w3-input">
</div>
</div><!-- close so first half -->

<div class="w3-half w3-container w3-border"><!-- so second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="customer_name" type="text" value="<?php echo $objResult['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="address1" class="w3-input" value="<?php echo $objResult['address1']; ?>" type="text">
<input name="address2" class="w3-input" value="<?php echo $objResult['address2']; ?>" type="text">
จังหวัด
<select name="province" class="w3-select" >
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) {

if($objResult["province"] == $fepro["province_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
รหัสไปรษณีย์
<input name="postcode" type="text" value="<?php echo $objResult["postcode"]; ?>" class="w3-input">
โทรศัพท์
<input name="tel" type="text" value="<?php echo $objResult["tel"]; ?>" class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so second half -->
</div><!-- close so -->



<div id="ca" class="w3-container city" style="display:none">
<div class="w3-padding-small"></div>
วันที่โทร
<input type='date' name="review_date_call" value="<?php echo $objResult["review_date_call"]; ?>"  class="w3-input" >

รายละเอียดการโทร
<textarea  name="review_call_des" class="w3-input" ><?php echo $objResult["review_call_des"]; ?></textarea>
วันที่ลูกค้ามารีวิว
<input type='date' name="review_date" value="<?php echo $objResult["review_date"]; ?>"  class="w3-input" >
วันที่ส่งโปรโมชั่น
<input type='date' name="promotion_date" value="<?php echo $objResult["pomotion_date"]; ?>"  class="w3-input" >
หมายเหตุ
<textarea  name="review_description" class="w3-input" ><?php echo $objResult["review_description"]; ?></textarea>

</div>



<div id="mo" class="city" style="display:none">
<div class="w3-padding-small"></div>
<div class="w3-container w3-third"><!--first third -->
ชื่อผู้แนะนำ
<input name="prefer_name" value="<?php echo $objResult["prefer_name"]; ?>" class="w3-input" >
ใบสั่งซื้อเลขที่
<input name="po_no" class="w3-input" value="<?php echo $objResult["po_no"]; ?>">
กำหนดส่งตามสัญญา
<input name="delivery_contract" value="<?php echo $objResult["delivery_contract"]; ?>" class="w3-input" >

<?php
if($objResult["clear_book_ckk"]=='1'){
?>
<input type="checkbox" name="clear_book_ckk" checked="checked" value="1">&nbsp;

<?php
}else{
	?>
<input type="checkbox" name="clear_book_ckk" value="1">&nbsp;


<?php
}
?>



เคลียร์ใบจอง
<input name="clear_book_no" class="w3-input" value="<?php echo $objResult["clear_book_no"]; ?>" placeholder="เลขที่" >


<?php
if($objResult["clear_brn_no_ckk"]=='1'){
?>

<input type="checkbox" name="clear_brn_no_ckk" checked='checked' value="1">&nbsp;

<?php
}else{
?>
	<input type="checkbox" name="clear_brn_no_ckk" value="1">&nbsp;
<?php
}
?>


เคลียร์ใบยืม BRN
<input name="clear_brn_no" class="w3-input" value="<?php echo $objResult["clear_brn_no"]; ?>" placeholder="เลขที่" >

<?php
if($objResult["clear_brnp_no_ckk"]=='1'){
?>
<input type="checkbox" name="clear_brnp_no_ckk" checked='checked' value="1">&nbsp;

<?php
}else{
	?>

<input type="checkbox" name="clear_brnp_no_ckk" value="1">&nbsp;

		<?php
}
		?>


เคลียร์ใบยืม BRNP
<input name="clear_brnp_no" class="w3-input" value="<?php echo $objResult["clear_brnp_no"]; ?>" placeholder="เลขที่" >
</div><!--first third -->
<div class="w3-container w3-third"><!--second third -->

<?php
if($objResult["sn_ckk"]=='1'){
?>
<input type="checkbox" name="sn_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="sn_ckk" value="1">&nbsp;

		<?php
}
		?>



ต้องการ SN
<input name="sn" value="<?php echo $objResult["sn"]; ?>" class="w3-input" >

<?php
if($objResult["bq_ckk"]=='1'){
?>
<input type="checkbox" name="bq_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="bq_ckk" value="1">&nbsp;

		<?php
}
		?>


BQ เลขที่
<input name="bq"  value="<?php echo $objResult["bq"]; ?>" class="w3-input" >


<?php
if($objResult["ot_ckk"]=='1'){
?>
<input type="checkbox" name="ot_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="ot_ckk" value="1">&nbsp;

		<?php
}
		?>


OT เลขที่
<input name="ot" value="<?php echo $objResult["ot"]; ?>" class="w3-input" >
<?php
if($objResult["with_pr"]=='1'){
?>
<input name="with_pr" type="checkbox" checked='checked' value="1">
<?php
}else{
?>
<input name="with_pr" type="checkbox" value="1">

	<?php
}
	

	?>
แนบใบเสนอราคา<br />

<?php 
if($objResult["type_type"]=='1'){
?>

<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

<?php
}else if($objResult["type_type"]=='2'){
	?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" checked="checked" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

		<?php
}else if($objResult["type_type"]=='3'){

			?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" checked="checked" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

	<?php
}else {

			?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type"  value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />
<?php 
		}
if($objResult["type_type"]=='3'){
?>
ระบุ
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"><?php echo $objResult["type_type_detail"];?></textarea>
<?php
}else{
	?>

<div id="dt5" style="display:none">
ระบุ
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"></textarea>
</div> <?php }	?>
</div><!--second third -->
<div class="w3-container w3-third"><!--third third -->
สถานที่ติดตั้งเครื่อง
<input name="install_place" value="<?php echo $objResult["install_place"]; ?>" class="w3-input" ><br />




แนบไฟล์

<input type='hidden' name='upload1' id='upload1' value ="<?php echo $objResult['upload1']; ?>"  />
<input type='hidden' name='upload2' id='upload2' value ="<?php echo $objResult['upload2']; ?>"  />
<input type='hidden' name='upload3' id='upload3' value ="<?php echo $objResult['upload3']; ?>"  />
<input type='hidden' name='upload4' id='upload4' value ="<?php echo $objResult['upload4']; ?>"  />
<input type='hidden' name='upload5' id='upload5' value ="<?php echo $objResult['upload5']; ?>"  />

<input name="upload1"  type="file"><a href="upload/<?php echo $objResult['upload1']; ?>" target="_blank"><?php echo $objResult['upload1']; ?></a></p>
<input name="upload2"  type="file"><a href="upload/<?php echo $objResult['upload2']; ?>" target="_blank"><?php echo $objResult['upload2']; ?></a></p>
<input name="upload3"  type="file"><a href="upload/<?php echo $objResult['upload3']; ?>" target="_blank"><?php echo $objResult['upload3']; ?></a></p>
<input name="upload4"  type="file"><a href="upload/<?php echo $objResult['upload4']; ?>" target="_blank"><?php echo $objResult['upload4']; ?></a></p>
<input name="upload5"  type="file"><a href="upload/<?php echo $objResult['upload5']; ?>" target="_blank"><?php echo $objResult['upload5']; ?></a></p>



</div>


</div><!--third third -->
</div><!-- close more -->
</div><!-- close second half -->
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('ot')"><font color="#404040"><b>ปิดงาน</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<?php 

$strSQL1 = "SELECT * FROM so__submain WHERE ref_idd = '".$_GET["ref_id"]."' ";
///echo $strSQL;
//exit();

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);



?>

<table width="100%" border="0" class="w3-table">

<tr>
	<td align="center"><b>No.</b></td>
    <td align="center"><b>Product Code</b></td>
    <td align="center"><b>Product Name</b></td>
    <td align="center"><b>Unit Name</b></td>
    <td align="center"><b>Sale Count</b></td>
    <td align="center"><b>Product Price</b></td>
    <td align="center"><b>Amount</b></td>
	 <td align="center"><b>รับประกัน (ปี</b></td>
	 <td align="center"><b>Cal (ครั้ง/ปี)</b></td>
	 <td align="center"><b>PM (ครั้ง/ปี)</b></td>
    <td align="center"><b>Sale Remark</b></td>
</tr>
<?php
$i = 1;


while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>

<tr>
<td><?=$i?> <input type='hidden' name = "Number_run<?php echo $i;?>" style="color:black;text-align:center" id = "Number_run[]<?php echo $objResult1["id"];?>" value ="<?php echo $i;?>" />   <input type='hidden' name = "id[]" value="<?php echo $objResult1["id"];?>" id = "id[]"    size='16' readonly/> 

</td>
<td style="width:15%;">
<select name="product[]<?php echo $objResult1["id"];?>" class="w3-select" onchange="document.getElementById('product_code<?php echo $i;?>').value = this.value.split('|')[0];

document.getElementById('product_name<?php echo $i;?>').value  = this.value.split('|')[1]; 
document.getElementById('unit_name<?php echo $i;?>').value  = this.value.split('|')[2];
document.getElementById('product_price<?php echo $i;?>').value  = this.value.split('|')[3];
">
<option value=""></option>
<?php
$strSQL2 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2 = mysqli_fetch_array($objQuery2))
{
if($objResult1["product_code"] == $objResult2["product_code"])
{
$sel = "selected";
}
else
{
$sel = ""; 
}
?>
<option value="<?php echo $objResult2["product_code"];?>|<?php  echo $objResult2["product_name"];?>|<?php  echo $objResult2["unit_name"];?>|<?php  echo $objResult2["product_price"];?>" <?php echo $sel;?>><?php echo $objResult2["product_code"];?> |<?php  echo $objResult2["product_name"];?>|<?php  echo $objResult2["unit_name"];?>|<?php  echo $objResult2["product_price"];?></option>

<?php
}
?>
</select>

 <input type='hidden' name = "product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["product_code"];?>" id = "product_code[]<?php echo $objResult1["id"];?>"      size='16' readonly/>  


</div></td>

<td> <input type='text' name = "product_name[]<?php echo $objResult1["id"];?>"  value="<?php echo $objResult1["product_name"];?>" id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly></textarea></td>

<td><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"   size='7' /></td>

<td><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php $price_per_unit= $objResult1["price_per_unit"]; echo number_format( $price_per_unit,2)."";?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   /></td>

<td><input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $amount=$objResult1["sum_amount"]; echo number_format( $amount,2)."";?>" id = "sum_amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"   value="" jAutoCalc= '{sale_count<?php echo $objResult1["id"];?>} * {product_price<?php echo $objResult1["id"];?>}'  readonly/></td>


<td><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["warranty"];?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>



<td><input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remarkk"];?>" class="w3-input"    size='13' /></td>


</tr>

<?
	$i++;

}

?>

</table>

<script>


$('form').jAutoCalc({

  attribute: 'jAutoCalc',

  thousandOpts: [',', '.', ' '],

  decimalOpts: ['.', ','],

  decimalPlaces: -1,

  initFire: true,

  chainFire: true,

  keyEventsFire: false,

  readOnlyResults: true,

  showParseError: true,

  emptyAsZero: false,

  smartIntegers: false,

  onShowResult: null,

  funcs: {},

  vars: {}
});

</script>


<input type="hidden" name="hdnLine" value="<?php echo $i;?>">


</div>

<div id="cs" class="w3-container city1" style="display:none">
<div class="w3-quarter"><!-- first third-->
<input type="checkbox" name="" hidden><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >
การส่งสินค้า<br>
<?php
if($objResult["delivery_company"]){
?>
<input type="checkbox" name="delivery_company" checked='checked' value="1">บริษัทจัดส่ง<br />
<?php
}else{
	?>
<input type="checkbox" name="delivery_company" value="1">บริษัทจัดส่ง<br />
		<?php
}
		if($objResult["big_car"]){

			?>
<input type="checkbox" name="big_car" checked='checked' value="1">ต้องการรถใหญ่<br />
<?php
		}else{
	?>
<input type="checkbox" name="big_car" value="1">ต้องการรถใหญ่<br />

		<?php
}
		if($objResult["call_before"]){
			?>
<input type="checkbox" name="call_before" checked='checked' value="1">โทรแจ้งลูกค้าก่อนไป<br />
<?php
		}else{
	?>
<input type="checkbox" name="call_before" value="1">โทรแจ้งลูกค้าก่อนไป<br />
		<?php
}
		if($objResult["maps"]){
			?>
<input type="checkbox" name="maps" checked='checked' value="1">มีแผนที่ประกอบ<br />
<?php
		}else{
				?>
<input type="checkbox" name="maps" value="1">มีแผนที่ประกอบ<br />
					<?php
			}
				?>
<input type='hidden' name='upload_map' id='upload_map' value ="<?php echo $objResult['upload_map']; ?>"  />

<input name="upload_map"  type="file"><a href="upload/<?php echo $objResult['upload_map']; ?>" target="_blank"><?php echo $objResult['upload_map']; ?></a></p>

				<?php
				if($objResult["assign_date_time"]){
						?>
<input type="checkbox" name="assign_date_time" checked='checked' value="1">นัดวันเวลาเรียบร้อยแล้ว<br />

<?php
				}else{
	?>
<input type="checkbox" name="assign_date_time" value="1">นัดวันเวลาเรียบร้อยแล้ว<br />
</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second third-->
<?php
}
		if($objResult["delivery_sale"]){
			?>
<input type="checkbox" name="delivery_sale" checked='checked' value="1">Sale รับเอง
<?php
		}else{
	?>
<input type="checkbox" name="delivery_sale" value="1">Sale รับเอง

		<?php
}
		if($objResult["delivery_engineer"]){
			?>
	
<input type="checkbox" name="delivery_engineer" checked='checked' value="1">ช่างรับเอง

<?php
		}else{
		?>
<input type="checkbox" name="delivery_engineer" value="1">ช่างรับเอง

			<?php
}
			if($objResult["delivery_customer"]){
				?>

<input type="checkbox" name="delivery_customer" checked='checked' value="1">ลูกค้ารับเอง <br />
<?php
			}else{
	?>
<input type="checkbox" name="delivery_customer" value="1">ลูกค้ารับเอง <br />

		<?php
}
		?>
สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ><?php echo $objResult["delivery_place"] ; ?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" value ="<?php echo $objResult["delivery_contact"]; ?>" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd quarter-->
<?php
if ($objResult["return_date"]=='1'){
?>
<input type="checkbox" name="return" checked="checked" value="1">รับคืนสินค้า<br>
<?php
}else{
	?>
<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>
<?php
}
	?>
วันที่รับคืน
<input type="date" name="return_date"  value ="<?php echo $objResult["return_date"] ; ?>" class="w3-input" >
เวลา
<input type="text" name="return_time" value ="<?php echo $objResult["return_time"] ; ?>" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" value ="<?php echo $objResult["return_address"] ; ?>" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact" value ="<?php echo $objResult["return_contact"] ; ?>" class="w3-input" >
</div><!-- 3rd quarter-->
<div class="w3-quarter w3-container">

<?php
if ($objResult["select_type_doc"]=='1'){
?>
<input type="checkbox"  checked="checked" value="1">&nbsp;

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม PTL</font></a>&nbsp;&nbsp;
<?php
}else{
	?>

<div id="dt1" style="display:none">
					
<input type="checkbox"  checked="checked" value="1">&nbsp;

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม PTL</font></a>&nbsp;&nbsp;
</div>

<?php
}

if ($objResult["select_type_doc"]=='2'){

?>
<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
					

<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;
<?php
}else{
	?>
<div id="dt2" style="display:none">
<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
					

<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;

</div>
<?php
}
if ($objResult["select_type_doc"]=='3'){

?>
	<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
		
<a href="report_saleptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></button></a><br />

<?php
}else{
?>

<div id="dt3" style="display:none">

<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
		
<a href="report_saleptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></button></a><br />

</div>
<?php
}
if ($objResult["select_type_doc"]=='4'){

?>
	<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
<?php
}else{
	?>
	<div id="dt4" style="display:none">

		
<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
</div>
<?php
}
?>

</div><!-- forth quarter -->
</div>
<center>
<input type="submit" name="submit" class="w3-button w3-teal" >
</center>
<?php require_once('foot.php'); ?>
</div>
  <!--/div-->
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
		return "data_delivery.php?delivery_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("delivery","h_delivery");
        </script>



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
		return "data_payment.php?payment_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("payment","h_payment");
        </script>




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
		return "data_employee_name.php?employee_name_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("employee_name","h_employee_name");
        </script>
