<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(rental_id,rental_name,rental_tel,emergency_name,emergency_tel,rental_address,install_address,bill_name,bill_address,bill_tel,tax_no,connect_name,connect_tel,patient_name) {
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
var url = 'data_rental_name.php';
var pmeters = "rental_id=" + encodeURI( document.getElementById(rental_id).value);
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

document.getElementById(rental_id).value = myArr[0];
document.getElementById(rental_name).value = myArr[1];
document.getElementById(rental_tel).value = myArr[2];
document.getElementById(emergency_name).value = myArr[3];
document.getElementById(emergency_tel).value = myArr[4];
document.getElementById(rental_address).value = myArr[5];
document.getElementById(install_address).value = myArr[6];
document.getElementById(bill_name).value = myArr[7];
document.getElementById(bill_address).value = myArr[8];
document.getElementById(bill_tel).value = myArr[9];
document.getElementById(tax_no).value = myArr[10];
document.getElementById(connect_name).value = myArr[11];
document.getElementById(connect_tel).value = myArr[12];
document.getElementById(patient_name).value = myArr[13];

}
}
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
$ref_id = $_GET["ref_id"];
	
$strSQL = "SELECT *  FROM hos__rental WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);





	 ?>

<form action='close_rental1.php' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
if(document.frmMain.start_time.value == ""){
			
		alert('กรุณาใส่เวลารับ');
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
		
	if(document.frmMain.h_employee_name.value == ""){
		alert('กรุณาเลือกชื่อพนักงาน');
		document.frmMain.employee_name.focus();
		return false;
		}		
	if(document.frmMain.province_name.value == ""){
		alert('กรุณาเลือกจังหวัดที่ต้องการรับสินค้า');
		document.frmMain.province_name.focus();
		return false;
		}
	document.frmMain.submit();
}

</script>

<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray">
				<div class="w3-half">
				<h4>ใบสั่งเช่า</h4></div>
				
				<div class="w3-half">
					
<a href="from_rental.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="purple">แบบฟอร์มใบสั่งเช่า</font></a>

				</div>
			</div>

<div class="w3-bar">
	
<?php if($objResult["type_doc"]=='3'){ ?>	
<input type="radio" checked='checked' name="type_doc" value = "3">&nbsp;AWL
<input type="radio"  name="type_doc" value = "4">&nbsp;NBM
	<?php }else if($objResult["type_doc"]=='4'){ ?>
<input type="radio"  name="type_doc" value = "3">&nbsp;AWL
<input type="radio" checked='checked' name="type_doc" value = "4">&nbsp;NBM
	
	<?php } ?>

		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $objResult["ref_id"]; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $objResult["ref_id"]; ?>" >
	</div>

</p>


<fieldset><legend ><b><font color="red">ข้อมูลผู้เช่า</font></b></legend></p>	
	
<div class="w3-half 1">
วันที่ : 
<input type="date" name = "register_date" id="register_date" style="width:90%;"  value="<?php echo $objResult["register_date"]; ?>" class = "w3-input"> 	
ชื่อลูกค้า :
<input type='text' name = "rental_name"  id = "rental_name" style="width:90%;" value="<?php echo $objResult["rental_name"]; ?>"  class="w3-input" >	
ที่อยู่
<textarea name="rental_address" id="rental_address" class="w3-input" rows="2" style="width:90%"><?php echo $objResult["rental_address"]; ?></textarea>

		
</div>
		
<div class="w3-half 1">
รหัสลูกค้า  : 
<input type='text' name = "rental_id"  id = "rental_id" class="w3-input" value="<?php echo $objResult["rental_id"]; ?>"  placeholder="Search ชื่อผู้เช่า..."  style="width:90%;" OnChange="JavaScript:doCallAjax1('rental_id','rental_name','rental_tel','emergency_name','emergency_tel','rental_address','install_address','bill_name','bill_address','bill_tel','tax_no','connect_name','connect_tel','patient_name');"/> 

<input type='hidden' name = "h_rental_id"  id = "h_rental_id"  class="button4" readonly>
เบอร์โทรศัพท์ :
<input type='text' name = "rental_tel"  value="<?php echo $objResult["rental_tel"]; ?>"  id = "rental_tel" style="width:90%;" class="w3-input" >
						
</div>
	</p></fieldset></p>

<fieldset><legend ><b><font color="red">ข้อมูลออกบิล</font></b></legend></p>	
	
<div class="w3-half 1">
ชื่อที่ต้องการออกบิล :
<input type='text' name = "bill_name"  value="<?php echo $objResult["bill_name"]; ?>"  id = "bill_name" style="width:90%;" class="w3-input" >
ที่อยู่ต้องการออกบิล
<textarea name="bill_address" id="bill_address" class="w3-input" rows="2" style="width:90%"><?php echo $objResult["bill_address"]; ?></textarea>

			
</div>
		
<div class="w3-half 1">

เบอร์โทร :
<input type='text' name = "bill_tel"  value="<?php echo $objResult["bill_tel"]; ?>"  id = "bill_tel" style="width:90%;" class="w3-input" >
	<?php if($objResult["bill_vat"]=='1'){ ?>
	<input type='checkbox' name = "bill_vat" checked="checked" id = "bill_vat" value="1" > 
	<?php }else{ ?>
	<input type='checkbox' name = "bill_vat"  id = "bill_vat" value="1" > 
	<?php } ?>
	
	ต้องการใบกำกับภาษีเต็มรูปแบบ
Tex ID :
<input type='text' name = "tax_no"  value="<?php echo $objResult["tax_no"]; ?>"  id = "tax_no" style="width:90%;" class="w3-input" >
	
</div>
	</p></fieldset></p><br>


<fieldset><legend ><b><font color="red">ข้อมูลการติดต่อ & การติดตั้ง</font></b></legend></p>	
	
<div class="w3-half 1">
ชื่อผู้ติดต่อ :
<input type='text' name = "connect_name"  value="<?php echo $objResult["connect_name"]; ?>"  id = "connect_name" style="width:90%;" class="w3-input" >	
บุคคลที่สามารถติดต่อได้กรณีฉุกเฉิน :
<input type='text' name = "emergency_name"  value="<?php echo $objResult["emergency_name"]; ?>"  id = "emergency_name" style="width:90%;" class="w3-input" >	
วันที่ติดตั้ง : 
<input type="date" name = "install_date" value="<?php echo $objResult["install_date"]; ?>"  id="install_date" style="width:90%;"   class = "w3-input"> 
ผู้ป่วย :
<input type='text' name = "patient_name"  value="<?php echo $objResult["patient_name"]; ?>"  id = "patient_name" style="width:90%;" class="w3-input" >	
			
</div>
		
<div class="w3-half 1">

โทรผู้ติดต่อ :
<input type='text' name = "connect_tel"  value="<?php echo $objResult["connect_tel"]; ?>"  id = "connect_tel" style="width:90%;" class="w3-input" >
เบอร์ฉุกเฉิน :
<input type='text' name = "emergency_tel"  value="<?php echo $objResult["emergency_tel"]; ?>"  id = "emergency_tel" style="width:90%;" class="w3-input" >
สถานที่ติดตั้ง
<textarea name="install_address" id="install_address" class="w3-input" rows="2" style="width:90%"><?php echo $objResult["install_address"]; ?></textarea>					
</div>
	</p></fieldset></p><br>


<fieldset><legend ><b><font color="red">ข้อมูลเอกสารสัญญา</font></b></legend></p>	
	
<div class="w3-half 1">
วันที่เริ่มต้นสัญญา : 
<input type="date" name = "start_promis"  value="<?php echo $objResult["start_promis"]; ?>" id="start_promis" style="width:90%;"   class = "w3-input"> 
	
การชำระเงิน :

<select name="payment" class="w3-input" style="width:90%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_credit order by credit_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["payment"] == $objResuut5["credit_id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
	?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['credit_id']; ?>" <?php echo $sel;?>><?php echo $objResuut5['credit_name']; ?></option>
<?php } ?>
</select>
</div>
		
<div class="w3-half 1">
	วันที่สิ้นสุดสัญญา : 
<input type="date" name = "end_promis"  value="<?php echo $objResult["end_promis"]; ?>" id="end_promis" style="width:90%;"   class = "w3-input"> 
ระยะเวลาในการเช่า/เดือน : 
<input type="text" name = "count_m" id="count_m" style="width:90%;" value ='<?php echo $objResult["count_m"]; ?>'  class = "w3-input" > 
หมายเหตุเพิ่มเติม
<textarea name="des_sale" id="des_sale" class="w3-input" rows="2" style="width:90%"><?php echo $objResult["des_sale"]; ?></textarea>					
</div>
	</p></fieldset></p><br>



<div class="w3-bar w3-light-grey w3-border">
<a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>ลงงานรับคืน</b></font></a>

</div>
<div id="pd" class="w3-container city1" >


<table width="100%" border="0" class="w3-table">

<tbody>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ค่ามัดจำ</th>
	<th>ยอดรวม</th>
	<th>หมายเลขเครื่อง</th>
	<th>หมายเหตุ</th>

</tbody>
<?php 	
$strSQL1 = "SELECT * FROM  (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>	
	
<tr>
<td style="width:10%;">

<input type='text' name = "product_code[]<?php echo $objResult1["id_sub"];?>" value="<?php echo $objResult1["access_code"]; ?>" id = "product_code[]<?php echo $objResult1["id_sub"];?>" class="w3-input"   size="7" readonly> 
<input type='hidden' name = "id_sub[]<?php echo $objResult1["id_sub"];?>" value="<?php echo $objResult1["id_sub"]; ?>" id = "id_sub[]<?php echo $objResult1["id_sub"];?>"  class="w3-input" readonly>	
<input type='hidden' name = "product_id[]<?php echo $objResult1["id_sub"];?>" value="<?php echo $objResult1["product_code"]; ?>" id = "product_id[]<?php echo $objResult1["id_sub"];?>" class="w3-input" />

</td>
<td  style="width:10%;">
<textarea  name = "product_name[]<?php echo $objResult1["id_sub"];?>"  id = "product_name[]<?php echo $objResult1["id_sub"];?>"  rows="2" class="w3-input" readonly><?php echo $objResult1["sol_name"]; ?></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name[]<?php echo $objResult1["id_sub"];?>"  id = "unit_name[]<?php echo $objResult1["id_sub"];?>" value="<?php echo $objResult1["unit_name"]; ?>" class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count[]<?php echo $objResult1["id_sub"];?>" id = "sale_count[]<?php echo $objResult1["id_sub"];?>" value="<?php echo $objResult1["count"]; ?>"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price[]<?php echo $objResult1["id_sub"];?>"  id = "product_price[]<?php echo $objResult1["id_sub"];?>"  class="w3-input"  value="<?php echo $objResult1["price"]; ?>" size="7" style="color:black;text-align:right" />
</td >

<td style="width:8%;"><input type='text' name = "sum_amount[]<?php echo $objResult1["id_sub"];?>"  id = "sum_amount[]<?php echo $objResult1["id_sub"];?>"  class="w3-input" size="7" style="color:black;text-align:right"  value="<?php echo $objResult1["amount"]; ?>" readonly/>
</td>

<td style="width:8%;">
<textarea name = "sn_number[]<?php echo $objResult1["id_sub"];?>"  id = "sn_number[]<?php echo $objResult1["id_sub"];?>"  class="w3-input" ><?php echo $objResult1["sn_number"]; ?></textarea>
</td>	

<td style="width:8%;">
<textarea name = "sale_remarkk[]<?php echo $objResult1["id_sub"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id_sub"];?>"  class="w3-input" ><?php echo $objResult1["remark_sale"]; ?></textarea>
</td>

</tr>

<?php } ?>
</table>

	
</div>

<div id="cs" class="w3-container city1" style="display:none">

<?php if($objResult["delivery_type"]=='1') { ?>
<input type="radio" name="delivery_type" value="1" checked='checked' >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  >&nbsp;บริษัทจัดส่ง <br />

</p>

<?php }else if ($objResult["delivery_type"]=='2') { ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2" checked='checked' >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  >&nbsp;บริษัทจัดส่ง <br />

<?php }else if ($objResult["delivery_type"]=='3') { ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3" checked='checked' >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  >&nbsp;บริษัทจัดส่ง <br />


<?php }else if ($objResult["delivery_type"]=='4') { ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4" checked='checked' >&nbsp;บริษัทจัดส่ง <br />

<?php }else{ ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4" >&nbsp;บริษัทจัดส่ง <br />
	<?php } ?>

	<?php
		$sql1 = "select * from tb_register_data where ref_id = '".$objResult["ref_id"]."'";
		$query1 = mysqli_query($conn,$sql1);
		$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
	?>
	<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไปสมุดลงงาน CS 
<br>
 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date"  class="button4" style="width:20%" /></p>


วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="button4" type='text'   id="between_date" style="width:20%" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เวลา :&nbsp;&nbsp;&nbsp;&nbsp;
<input id="start_time"  name="start_time"  value="<?php echo $fetch1["start_time"]; ?>" class="button4" type="text" style="width:10%"/>
ถึง
<input id="end_time" name="end_time"  value="<?php echo $fetch1["end_time"]; ?>"  class="button4" type="text" style="width:10%"/></p>



สถานะการทำงาน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='radio'  name='status' id = 'status' value='ส่ง' />ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' checked='checked' value='รับ' />รับ

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
สถานะ :&nbsp;&nbsp;
      <input name="status_comment" type='text' id="status_comment" value="<?php echo $fetch1["status_comment"]; ?>"  style="width:22%" class="button4"/></p>



<?php if($fetch1["mk_research"]=='1'){ ?>

<input type="checkbox"  name="mk_research" checked='checked' id = "mk_research" value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span>&nbsp;&nbsp;
<?php }else{ ?>

<input type="checkbox"  name="mk_research" id = "mk_research" value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span>&nbsp;&nbsp;

	<?php } ?>
<?php if($fetch1["fix_date"]=='1'){ ?>

<input type="checkbox"  name="fix_datetime" checked='checked' id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;
<?php }else{ ?>

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;

	<?php } ?>
	
<?php 
	if($fetch1["on_time"]=='1'){
	?>

<input type="checkbox"  id = "on_time" checked='checked' name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;;

<?php }else{ ?>
<input type="checkbox"  id = "on_time" name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;

	<?php } ?>
<?php
	if($fetch1["call_customer"]=='1'){
		?>

<input type="checkbox" checked='checked' id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
<?php }else{ ?>

<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป

	<?php } 
	if($fetch1["call_employee"]=='1'){
	?>
&nbsp;&nbsp;<input type="checkbox"  id = "call_back" checked='checked' name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
&nbsp;&nbsp;
<?php }else{ ?>
&nbsp;&nbsp;<input type="checkbox"  id = "call_back"  name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
&nbsp;&nbsp;

	<?php } 
	?>
<?php 
	if($fetch1["no_price"]=='1'){
	?>

<input type="checkbox"  id = "no_money" checked='checked' name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;

<?php }else{ ?>
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;

	<?php } ?>
<?php
		if($fetch1["want_bus"]=='1'){

	?>


<input type="checkbox" checked='checked'  name="want_bus" value="1">ต้องการรถใหญ่</p>
<?php }else{ ?>

<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่</p>

	<?php } 
	if($fetch1["cash"]=='1'){
	?>
	
<input type="checkbox" checked='checked'  name="cash"id = "cash"  value="1">เก็บเงินสด : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }else { ?>

<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<?php } ?>
		 <input name="unit_cash" type='text' class="button4" id="unit_cash" size="20" value="<?php echo $fetch1["price"]; ?>"  rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php 	if($fetch1["check_peper"]=='1'){ ?>

	<input type="checkbox"  name="check_paper" checked='checked' id = "check_paper" value="1">รับเช็ค : &nbsp;
<?php }else{ ?>
	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค : &nbsp;

	<?php } ?>

	<input name="unit_check" type='text' class="button4" value="<?php echo $fetch1["unit_check"]; ?>"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/></p>
		
<?php if($fetch1["credit"]=='1'){ ?>
<input type="checkbox"  id = "credit_card" name="credit_card" checked='checked' value="1">รูดการ์ด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php }else{ ?>
<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php } ?>
	
	<input name="unit_credit" type='text' class="button4" value="<?php echo $fetch1["unit_credit"]; ?>"  id="unit_credit"  size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php if($fetch1["bill"]=='1'){  ?>
<input type="checkbox"  checked='checked' id = "bill" name="bill" value="1">วางบิล : &nbsp;
<?php }else{ ?>
<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล : &nbsp;

	<?php } ?>

<input name="unit_bill" type='text' class="button4" style="color:black;text-align:right" id="unit_bill" value="<?php echo $fetch1["unit_bill"]; ?>"  size="20" OnChange="JavaScript:chkNum(this)" /></p>

<?php  if($fetch1["tran"]=='1'){ ?>

<input type="checkbox"  name="tran"id = "tran" checked='checked' value="1">ลูกค้าโอนเงินหน้างาน :
<?php }else{ ?>
<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน :
<?php } ?>
		 <input name="unit_tran" type='text' class="button4" id="unit_tran" value="<?php echo $fetch1["unit_tran"]; ?>"  size="20" style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php  if($fetch1["dep"]=='1'){ ?>

<input type="checkbox" checked='checked' id = "dep" name="dep" value="1">อื่นๆ : &nbsp;&nbsp;&nbsp;
<?php }else{ ?>
<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ : &nbsp;&nbsp;&nbsp;


	<?php } ?>

<input name="dept" type='text' class="button4" value="<?php echo $fetch1["dept"]; ?>"   id="dept"  size="20"  /></p>


แผนก - ฝ่าย :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="department_show" value="<?php echo "ฝ่ายขาย"; ?>"  class="button4" type='text' id="department_show">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทลูกค้า :

	   <input name="customer_typename"  value="<?php echo $fetch1["type_customer"]; ?>"  class="button4" type='text' id="customer_typename">

</p>



       หน่วยงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   	   <input name="company_name"  value="<?php echo $fetch1["type_company"]; ?>"  class="button4" type='text' id="company_name">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทงาน :&nbsp;&nbsp;
	   <input name="department_name" value="<?php echo "Sale"; ?>"  class="button4" type='text' id="department_name">

</p>



ชื่อพนักงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="employee_name" value="<?php echo $fetch1["employee_name"]; ?>" class="button4" type='text' value="<?php echo $_SESSION['name']; ?>" id="employee_name" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรพนักงาน :&nbsp;
<input name="employee_tel" value="<?php echo $fetch1["employee_tel"]; ?>" class="button4" type='text' id="employee_tel" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
<input name="add_by" value="<?php echo $fetch1["add_by"]; ?>" type='hidden' class="button4" >

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
if($fetch1["province_name"] == $objResuut5["province_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
	?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['province_name']; ?>"<?php echo $sel;?>><?php echo $objResuut5['province_name']; ?></option>
<?php } ?>
</select>
</p>
สถาที่ส่งสินค้า :</p>
          
<textarea  class="button4" name="address_1"  style="width:50%" ><?php echo $fetch1["address_1"]; ?></textarea>
</p>
ที่อยู่ในการส่งสินค้า :</p>
<textarea   class="button4" name="address_name" style="width:50%" ><?php echo $fetch1["address_name"]; ?></textarea>               
</p>

  สถานที่ติดตั้งเครื่อง :</p>
<textarea   class="button4" name="address_send"  style="width:50%" rows="2"><?php echo $fetch1["address_send"]; ?></textarea>
</p>

ชื่อผู้ติดต่อ  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name"  class="button4" type='text' value="<?php echo $fetch1["customer_name"]; ?>" id="customer_name">




&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า :
<input name="customer_tel" value="<?php echo $fetch1["customer_tel"]; ?>"  class="button4" type='text' id="customer_tel" >
</p>
เลขที่เอกสาร/เลขที่เครื่อง :</p> 
<textarea name="product_sn"  class="button4" id="product_sn" style="width:50%" rows="2"><?php echo $fetch1["product_sn"]; ?></textarea>
</p>
สินค้า/เอกสาร :</p>
<textarea name="product"  class="button4" id="product" style="width:50%" rows="2"><?php echo $fetch1["product_name"]; ?></textarea>


</p>
รายละเอียดเพิ่มเติม :</p>
     <textarea name="description"  class="button4" id="description" style="width:50%" rows="2"><?php echo $fetch1["description"]; ?></textarea>

</div>


<br>
<center>

<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >

</center>


</form>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>

  <!--/div-->

  

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
		return "data_rentel_name.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("rental_id","h_rental_id");
</script> 

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
