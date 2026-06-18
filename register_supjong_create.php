<?php include ("head.php");

include ("dbconnect_sale.php");
?>

<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(bill_id,bill_name,bill_address,bill_tel,tax_id) {
HttPRequest = false;
if (window.XMLHttpRequest) { // Mozilla, Safari,...
HttPRequest = new XMLHttpRequest();

if (HttPRequest.overrideMimeType) {
HttPRequest.overrideMimeType('text/html');
}
} else if (window.ActiveXObject) { // IE
try {
HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
} catch (e) {}
}
}

if (!HttPRequest) {

alert('Cannot create XMLHTTP instance');
return false;
}
var url = 'data_bill_name1.php';
var pmeters = "bill_id=" + encodeURI( document.getElementById(bill_id).value);
HttPRequest.open('POST',url,true);

HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
HttPRequest.setRequestHeader("Content-length", pmeters.length);
HttPRequest.setRequestHeader("Connection", "close");
HttPRequest.send(pmeters);

HttPRequest.onreadystatechange = function()
{
if(HttPRequest.readyState == 4) // Return Request
{
var myProduct = HttPRequest.responseText;

if(myProduct != "")
{

var myArr = myProduct.split("|");

document.getElementById(bill_name).value = myArr[0];
document.getElementById(bill_address).value = myArr[1];
document.getElementById(bill_tel).value = myArr[2];
document.getElementById(tax_id).value = myArr[3];

}
}
}
}

    
</script>

<script>
   

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



function ckk_2() {
		if (document.getElementById('object8').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object9').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object10').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
			else if (document.getElementById('object11').checked) {
			document.getElementById('dv1').style.display = 'none';
			document.getElementById('dv2').style.display = 'block';
		}
}




</script>

<style type="text/css">

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 8px 10px;
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
<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->
</style>

<body>
<?php

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__so";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SO";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$ref_id = $_GET["ref_id"];
	
$strSQL = "SELECT * FROM hos__jongproduct WHERE ref_id = '".$ref_id."' ";

$objQuery = mysqli_query($conn,$strSQL)or die ("Error Query [".$strSQL."]");;
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM (hos__subjongpro LEFT JOIN tb_product ON hos__subjongpro.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	
	
$strSQL2 = "SELECT * FROM tb_customer WHERE customer_id = '".$objResult["customer_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2)or die ("Error Query [".$strSQL2."]");;
$objResult2 = mysqli_fetch_array($objQuery2);	

	 ?>


	<!--action="register_office1.php"-->
	<form action='register_supjong_create1.php' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	if(document.frmMain.payment.value != "")
	{
		if(document.frmMain.payment.value == "7")
	{
	
		
		if(document.frmMain.date_tranfer.value == ""){
			
		alert('กรุณาใส่วันที่โอน');
		document.frmMain.date_tranfer.focus();
		return false;
		}
	}	
	}
	
	if(document.frmMain.start_time.value == ""){
			
		alert('กรุณาใส่เวลาส่ง');
		document.frmMain.start_time.focus();
		return false;
		}
	
		if(document.frmMain.customer_name.value == ""){
		alert('กรุณาใส่ชื่อลูกค้า');
		document.frmMain.customer_name.focus();
		return false;
		}
	
	if(document.frmMain.customer_tel.value == ""){
		alert('กรุณาใส่เบอร์โทรลูกค้า');
		document.frmMain.customer_tel.focus();
		return false;
		}
	if(document.frmMain.address_1.value == ""){
		alert('กรุณาใส่สถานที่ส่งสินค้า');
		document.frmMain.address_1.focus();
		return false;
		}
	
		if(document.frmMain.address_name.value == ""){
		alert('กรุณาใส่ที่อยู่ในการส่งสินค้า');
		document.frmMain.address_name.focus();
		return false;
		}
	
	if(document.frmMain.address_send.value == ""){
		alert('กรุณาใส่สถานที่ติดตั้งเครื่อง');
		document.frmMain.address_send.focus();
		return false;
		}
		
	
	document.frmMain.submit();
}


</script>
		<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>Register Sale Order</h4></div>

<div class="w3-bar">
		
<input type="radio" checked='checked' name="type_doc" value = "3">&nbsp;ใบสั่งขาย AWL
<input type="radio" name="type_doc"  value="4" >&nbsp;ใบสั่งขาย NBM

		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
	<input type="hidden" name="ref_id_jong" class="w3-input" value="<?php echo $ref_id; ?>">
	</div>

</p>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>


		วันที่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name = "date_so" id="date_so" value="<?php echo $today;?>" class = "button4"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="checkbox" name="have_order" value="1" > ออเดอร์ฝาก</p>





ชื่อผู้แนะนำ/ร.พ./แผนก  : &nbsp;<input type="text" name="suggest" class="button4" style="width:30%;" required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				
 </p>
			รหัสลูกค้า  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='text' name = "bill_id"  id = "bill_id" class="button4" placeholder="Search ชื่อลูกค้า..."  value = "<?php echo $objResult2["customer_id"]; ?>" style="width:30%;" OnChange="JavaScript:doCallAjax1('bill_id','bill_name','bill_address','bill_tel','tax_id');"/> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>



				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ชื่อที่ต้องการออกบิล :&nbsp; 
				
<input type='text' name = "bill_name"  id = "bill_name" style="width:30%;"  value = "<?php echo $objResult2["bill_name"]; ?>" class="button4" >
				</p>
			
					ที่อยู่ที่ใช้ในการออกบิล : &nbsp;
					
					<textarea  name = "bill_address"  id = "bill_address" style="width:30%;" rows="2" class="button4" readonly><?php echo $objResult2["bill_address"];  echo $objResult2["bill_ampher"];  echo $objResult2["billl_province"];  echo $objResult2["bill_postcode"]; ?></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
				เบอร์โทรศัพท์ :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input type='text' name = "bill_tel"  id = "bill_tel" style="width:30%;" value = "<?php echo $objResult2["bill_tel"]; ?>"  class="button4" readonly></p>


<input type="checkbox" name="full_bill" value="1"> &nbsp;บิล VAT
 &nbsp;&nbsp;
เลขประจำตัวผู้เสียภาษี :&nbsp;&nbsp;&nbsp;<input type="text" name="tax_id" value = "<?php echo $objResult2["tax_id"]; ?>" id = 'tax_id' class="button4" style="width:22%;" readonly>
</p>
&nbsp;ต้องการเอกสารแนบบิล<br>

<input type="checkbox" name="ref_1"  id="ref_1" value="1"> &nbsp;เตรียมเอกสาร N-Health&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_2"  id="ref_2" value="1"> &nbsp;เตรียมเอกสารตามสเปคใบเสนอราคา&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_3"  id="ref_3" value="1"> &nbsp;ใบ อย.&nbsp;&nbsp;&nbsp;<br>

<input type="checkbox" name="ref_4"  id="ref_4" value="1">&nbsp;ใบตัวแทนจำหน่าย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_5"  id="ref_5" value="1"> &nbsp;ใบช่างอบรม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_6"  id="ref_6" value="1"> &nbsp;ใบนำเข้าสินค้า&nbsp;&nbsp;&nbsp;<br>

<input type="checkbox" name="ref_7"  id="ref_7" value="1"> &nbsp;ใบ CER เครื่องมือที่ใช้ทดสอบ&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_8"  id="ref_8" value="1"> &nbsp;ใบ PM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_9"  id="ref_9" value="1"> &nbsp;ใบ CAL&nbsp;&nbsp;&nbsp;<br>
<input type="checkbox" name="ref_11"  id="ref_11" value="1"> &nbsp;ใบประเมินสินค้า&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_10"  id="ref_10" value="1"> &nbsp;อื่น ๆ&nbsp;&nbsp;&nbsp;&nbsp;
<input name="ref_des" id="ref_des"   class="button4" style="width:20%">
</p>


การชำระเงิน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<select name="payment" class="button4" style="width:30%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_credit order by credit_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['credit_id']; ?>"><?php echo $objResuut5['credit_name']; ?></option>
<?php } ?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Sales Comment :&nbsp;
<textarea name="sale_comment"  class="button4" style="width:30%" id="sale_comment"  rows="2"></textarea></p>


เพิ่มเติมการชำระเงิน :&nbsp;&nbsp;
<input type="text" name="payment_des" id="payment_des" class="button4" style="width:30%;"  placeholder="ระบุในการณีเลือกอื่นๆ..."> </p>

วันที่โอนเงิน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name = "date_tranfer" id="date_tranfer"  class = "button4"></p>

ใบสั่งซื้อเลขที่:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="po_no" class="button4" style="width:30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
กำหนดส่งตามสัญญา :
<input name="delivery_contract" class="button4" style="width:30%"> </p>
<input type="checkbox" name="book_clear" checked='checked' value="1">&nbsp; เคลียร์ใบจอง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="book_no" class="button4" value = "<?php echo $objResult["iv_no"]; ?>" placeholder="เลขที่" style="width:30%">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="brn_clear" value="1">&nbsp;เคลียร์ใบยืมสินค้า ติดเล่ม  :
<input name="brn_no" class="button4" style="width:27%" placeholder="เลขที่" ></p>
<input type="checkbox" name="brnp_clear" value="1">&nbsp;เคลียร์ใบยืมสินค้า กระดาษต่อเนื่อง :&nbsp;
<input name="brnp_no" class="button4" style="width:23%" placeholder="เลขที่" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="sn_no" class="button4" style="width:30%" placeholder="เลขที่"> </p>

Sale : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($objResult["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<?php
}else 	if ($_SESSION['code']=='SS2'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($objResult["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


<?php
}else 	if ($_SESSION['code']=='SS5'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 where sale_code IN ('S31','S32') ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($objResult["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>

<?php
}else 	if ($_SESSION['code']=='MK2'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_sm1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($objResult["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


		<?php
}else 	if ($_SESSION['code']=='SUP_EN'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($objResult["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


		<?php
}else 	{
			?>
				<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($objResult["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


				<?php
}
			
?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="with_pr" type="checkbox" value="1"> แนบใบเสนอราคา
เลขที่  : 
<input name="pr_no" class="button4" style="width:28%" placeholder="เลขที่"></p>
<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />
<div id="dt5" style="display:none">

ระบุ:
<textarea name="type_detail" class="button4" rows="2" style="width:30%"></textarea>

</div>
<br><fieldset><legend><b>หมายเหตุแจ้งแผนกที่เกี่ยวข้อง</b></legend>	
<br>
	

จัดส่ง :
<textarea name="comment_cs"  class="w3-input" style="width:90%" id="comment_cs"  rows="2"></textarea>	
	
ช่าง :
<textarea name="comment_en"  class="w3-input" style="width:90%" id="comment_en"  rows="2"></textarea>	
	
คลังสินค้า :
<textarea name="comment_st"  class="w3-input" style="width:90%" id="comment_st"  rows="2"></textarea>	
	
Admin :
<textarea name="comment_ad"  class="w3-input" style="width:90%" id="comment_ad"  rows="2"></textarea>	

<br></fieldset>	<br>
แนบไฟล์ </p>
<input name="slip1"  type="file">


</p>
<input name="slip2"  type="file">


</p>
<input name="slip3"  type="file">


</p>
<input name="slip4"  type="file">


</p>
<input name="slip5"  type="file">

</p>


<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>

</div>

<div id="pd" class="w3-container city1" >


<?php
if($_SESSION["department"]=='วิศวกรรม'){
	?>
	<table width="100%" border="0" class="w3-table">
<thead>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
	<th>ส่วนลด/หน่วย</th>
    <th>ยอดรวม</th>
	<th>รับประกัน (ปี)</th>
	<th>Cal(ครั้ง/ปี)</th>
	<th>PM (ครั้ง/ปี)</th>
	<th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>

</thead>
<tbody>
<?php

$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
?>
<tr>
<td style="width:10%;">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"  size="5"  class="button4" /></td>

<td style="width:15%;"><textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="button4" readonly><?php echo $objResult1["access_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:8%;"><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php  $price=$objResult1["price"]; echo number_format( $price,2)."";?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="button4"  style="color:black;text-align:right"  size="7"  /></td>

<td style="width:8%;"><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php  $discount_unit=$objResult1["discount"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>" size="5" class="button4" style="color:black;text-align:right"   /></td>


<td style="width:8%;">
<input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[]<?php echo $objResult1["id"];?>" size="7" class="button4" style="color:black;text-align:right"   />


</td>

<td style="width:5%;"><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php if($objResult1["war_hos"]!='0'){ echo $objResult1["war_hos"];?><?php echo $objResult1["unit_hos"]; } ?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:5%;"><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

	<td style="width:10%;">

<textarea name = "sn[]<?php echo $objResult1["id"];?>"  id = "sn[]<?php echo $objResult1["id"];?>" class="w3-input" ><?php echo $objResult1["sn"];?></textarea>

</td>
	
<td style="width:10%;">
<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />

</td>

<td style="width:2%;"><a href="producthos_delete.php?ref_id=<?php echo $rs["ref_id"];?>&id=<?php echo $objResult1["id"];?>&code=<?php echo $_SESSION["type_login"]; ?>"><img src="img/false.png" width="16" height="16" border="0" /></a></td>

</tr>



<?php
	$i++;
	}
?>






</tbody>
</table>

	<?php
include ('product_engineer1.php');

}else{ ?>
	
	
	
	

<table width="100%" border="0" class="w3-table">
<thead>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
	<th>ส่วนลด/หน่วย</th>
    <th>ยอดรวม</th>
	<th>รับประกัน (ปี)</th>
	<th>Cal(ครั้ง/ปี)</th>
	<th>PM (ครั้ง/ปี)</th>
	<th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>

</thead>
<tbody>
<?php


$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
?>
<tr>
<td style="width:10%;">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"  size="5"  class="button4" /></td>

<td style="width:15%;"><textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="button4" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:8%;"><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php  $price=$objResult1["price"]; echo number_format( $price,2)."";?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="button4"  style="color:black;text-align:right"  size="7"  /></td>

<td style="width:8%;"><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php  $discount_unit=$objResult1["discount"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>" size="5" class="button4" style="color:black;text-align:right"   /></td>


<td style="width:8%;">
<input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[]<?php echo $objResult1["id"];?>" size="7" class="button4" style="color:black;text-align:right"   />


</td>

<td style="width:5%;"><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php if($objResult1["war_hos"]!='0'){ echo $objResult1["war_hos"];?><?php echo $objResult1["unit_hos"]; } ?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:5%;"><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:10%;">

<textarea name = "sn[]<?php echo $objResult1["id"];?>"  id = "sn[]<?php echo $objResult1["id"];?>" class="w3-input" ><?php echo $objResult1["sn"];?></textarea>

</td>
	
<td style="width:10%;">
<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />

</td>

<td style="width:2%;"><a href="producthos_delete.php?ref_id=<?php echo $rs["ref_id"];?>&id=<?php echo $objResult1["id"];?>&code=<?php echo $_SESSION["type_login"]; ?>"><img src="img/false.png" width="16" height="16" border="0" /></a></td>

</tr>



<?php
	$i++;
	}
?>

</tbody>
</table>

<?php include ('product_salehos1.php');
}
	?>


</div>

<div id="cs" class="w3-container city1" style="display:none">

<input type="radio" name="delivery_type" value="1" checked='checked' onclick="javascript:ckk_2();" id="object8">&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  onclick="javascript:ckk_2();" id="object9">&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  onclick="javascript:ckk_2();" id="object10">&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  onclick="javascript:ckk_2();" id="object11">&nbsp;บริษัทจัดส่ง <br />

</p>




 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date"   class="button4" style="width:20%" /></p>


วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="button4" type='text' id="between_date" style="width:20%" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เวลา :&nbsp;&nbsp;&nbsp;&nbsp;
<input id="start_time"  name="start_time"  class="button4" type="text" style="width:10%" >
ถึง
<input id="end_time" name="end_time"  class="button4" type="text" style="width:10%"/></p>



สถานะการทำงาน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
สถานะ :&nbsp;&nbsp;
      <input name="status_comment" type='text' id="status_comment"  style="width:22%" class="button4"/></p>


<input type="checkbox" name="mk_research" value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span>&nbsp;&nbsp;

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;
<input type="checkbox"  id = "on_time" name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;


<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
		
&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว&nbsp;&nbsp;
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;
<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่</p>
		
	 
<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <input name="unit_cash" type='text' class="button4" id="unit_cash" size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค : &nbsp;
	<input name="unit_check" type='text' class="button4"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/></p>
		

<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="unit_credit" type='text' class="button4"  id="unit_credit"  size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล : &nbsp;
<input name="unit_bill" type='text' class="button4" style="color:black;text-align:right" id="unit_bill"  size="20" OnChange="JavaScript:chkNum(this)" /></p>



<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน :
		 <input name="unit_tran" type='text' class="button4" id="unit_tran" size="20" style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ : &nbsp;&nbsp;&nbsp;
<input name="dept" type='text' class="button4"  id="dept"  size="20"  /></p>

<?php
if($_SESSION['department']=="วิศวกรรม"){
	$department="ฝ่ายวิศวกรรม";
}else{
	$department="ฝ่ายขาย";	
}
?>

แผนก - ฝ่าย :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="department_show" value="<?php echo $department; ?>" class="button4" type='text' id="department_show">


</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทลูกค้า :
<select name="customer_typename" id="customer_typename" class="button4"   >
<option  value="">**โปรดเลือกประเภทลูกค้า**</option>
<option  value="ร้านขายยา">ร้านขายยา</option>
<option  value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
<option  value="โรงพยาบาล">โรงพยาบาล</option>

</select></p>


<?php /*
       หน่วยงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<select name="company_name" id="company_name" class="button4"  style="width:14%" >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="ฟาร์ ทริลเลี่ยน บจก.">ฟาร์ ทริลเลี่ยน บจก.</option>
<option  value="โนเบิล เมด บจก.">โนเบิล เมด บจก.</option>
<option  value="อื่นๆ">อื่นๆ</option>

</select>*/ 

if($_SESSION['department']=="วิศวกรรม"){
$sale='วิศวกรรม';
	}else{
$sale='Sale';	
}
?>
       ประเภทงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   <input name="department_name" value="<?php echo $sale; ?>"  class="button4" type='text' id="department_name">

</p>



ชื่อพนักงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="employee_name"  class="button4" type='text' value="<?php echo $_SESSION['name']; ?>" id="employee_name" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรพนักงาน :&nbsp;
<input name="employee_tel"  class="button4" type='text' id="employee_tel" >
<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='hidden' class="button4" >

</p>
จังหวัด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
<select name="province_name" id ="province_name" class="button4" style="width:30%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_province order by province_ID ";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['province_name']; ?>"><?php echo $objResuut5['province_name']; ?></option>
<?php } ?>
</select>

</p>

สถานที่ส่งสินค้า :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       
<input type='text'  class="button4" name="address_1" style="width:30%" >             
</p>
ที่อยู่ในการส่งสินค้า :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name" style="width:30%" >  
</p>

  สถานที่ติดตั้งเครื่อง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<textarea   class="button4" name="address_send"  style="width:30%" rows="2" ></textarea>
</p>
ชื่อผู้ติดต่อ  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name"  class="button4" type='text' id="customer_name" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="button4" type='text' id="customer_tel" >
</p>
เลขที่เอกสาร/เลขที่เครื่อง : </p>
<textarea name="product_sn"  class="button4" id="product_sn" style="width:50%" rows="2"></textarea>
</p>
สินค้า/เอกสาร :</p>
<textarea name="product"  class="button4" id="product" style="width:50%" rows="2"></textarea>


</p>
รายละเอียดเพิ่มเติม :</p> 
     <textarea name="description"  class="button4" id="description" style="width:50%" rows="2"></textarea>



	
</div><!-- cs -->

<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</form>
<div id="cr_bar"> Copyright © 2019 phar trillion co., ltd. </div>
  </div>
  <!--/div-->



<?php if($_SESSION['department']=="วิศวกรรม"){ ?>

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
		return "data_bill_name.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 

<?php }else{ ?>

  
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
		return "data_bill_name2.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 

<?php
}
?>

<script>
$('#more').click(function() {
  if($(this).is(":checked")){
   $("#more-2").show();
  }
  else{
   $("#more-2").hide();
  }
});
</script>