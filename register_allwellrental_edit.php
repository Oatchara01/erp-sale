<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>
<?php include('dbconnect_cs.php'); ?>

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
</style>

<body>
<?php
$ref_id = $_GET["ref_id"];
	
$strSQL = "SELECT *  FROM hos__rental WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
 ?>

<form action='register_allwellrental_edit1.php' method="post" name="frmMain" enctype="multipart/form-data"  >
		


<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray">
				<div class="w3-half">
				<h4>ใบสั่งเช่า</h4></div>
				
				<div class="w3-half">

<?php if($objResult["send_sup"]=='0'){ ?>			
<a href="send_supallwellrental.php?ref_id=<?php echo $objResult["ref_id"];?>" class="w3-button w3-yellow w3-right"><font color="red">ส่งใบสั่งเช่าให้ Sup อนุมัติ</font></a>&nbsp;&nbsp;
<?php } ?>

<?php if($objResult["ref_iv"]==''){ ?>			
<a href="register_allwellso_rental.php?ref_id=<?php echo $objResult["ref_id"];?>&type=<?php echo 'IV'; ?>" class="w3-button w3-blue w3-right"><font color="black">เปิดใบค่าเช่าสินค้า</font></a>&nbsp;&nbsp;
<?php } ?>	
<?php if($objResult["ref_ai"]=='0'){ ?>
<a href="register_allwellso_rental.php?ref_id=<?php echo $objResult["ref_id"];?>&type=<?php echo 'AI'; ?>" class="w3-button w3-grey w3-right"><font color="black">เปิดใบค่ามัดจำสินค้า</font></a>&nbsp;&nbsp;
<?php } ?>
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
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $objResult["ref_id"]; ?>" ><br>
	<?php if($objResult["type_product"]=='1'){ ?>
<input type="radio"  name="type_product" checked='checked' id="type_product" value = "1" required>&nbsp;สินค้าเตียง  	&nbsp;
<input type="radio"  name="type_product" id="type_product" value = "2" required>&nbsp;สินค้าที่นอน  	&nbsp;
<input type="radio"  name="type_product" id="type_product" value = "3" required>&nbsp;สินค้าอื่นๆ  	&nbsp;
	<?php }else if($objResult["type_product"]=='2'){ ?>
<input type="radio"  name="type_product" id="type_product" value = "1" required>&nbsp;สินค้าเตียง  	&nbsp;
<input type="radio"  name="type_product"  checked='checked' id="type_product" value = "2" required>&nbsp;สินค้าที่นอน  	&nbsp;
<input type="radio"  name="type_product" id="type_product" value = "3" required>&nbsp;สินค้าอื่นๆ  	&nbsp;
	
	<?php }else if($objResult["type_product"]=='3'){ ?>
<input type="radio"  name="type_product" id="type_product" value = "1" required>&nbsp;สินค้าเตียง  	&nbsp;
<input type="radio"  name="type_product" id="type_product" value = "2" required>&nbsp;สินค้าที่นอน  	&nbsp;
<input type="radio"  name="type_product"  checked='checked' id="type_product" value = "3" required>&nbsp;สินค้าอื่นๆ  	&nbsp;
	<?php }else{ ?>
	
<input type="radio"  name="type_product" id="type_product" value = "1" required>&nbsp;สินค้าเตียง  	&nbsp;
<input type="radio"  name="type_product" id="type_product" value = "2" required>&nbsp;สินค้าที่นอน  	&nbsp;
<input type="radio"  name="type_product"  id="type_product" value = "3" required>&nbsp;สินค้าอื่นๆ  	&nbsp;
	
	<?php } ?>
	
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
เลขที่เอกสาร : 
<input type="text" name = "iv_no"  value="<?php echo $objResult["iv_no"]; ?>" id="iv_no" style="width:90%;" class = "w3-input" readonly> 
	
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

เขตการขาย :

<select name="sale_code" id="sale_code"  class="w3-input" style="width:90%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL4 = "select * from tb_team_allwell order by allwell_id";
$objQuery4 = mysqli_query($com,$strSQL4);

while ($objResuut4 = mysqli_fetch_array($objQuery4,MYSQLI_ASSOC)) {
if($objResult["sale_code"] == $objResuut4["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}

?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut4['sale_code']; ?>" <?php echo $sel;?>><?php echo $objResuut4['sale_code']; ?></option>
<?php } ?>
</select>


</div>
		
<div class="w3-half 1">
เลขที่สัญญา : 
<input type="text" name = "promis_no"  value="<?php echo $objResult["promis_no"]; ?>" id="promis_no" style="width:90%;" class = "w3-input" readonly> 
	
	วันที่สิ้นสุดสัญญา : 
<input type="date" name = "end_promis"  value="<?php echo $objResult["end_promis"]; ?>" id="end_promis" style="width:90%;"   class = "w3-input"> 
ระยะเวลาในการเช่า/เดือน : 
<input type="text" name = "count_m" id="count_m" style="width:90%;" value ='<?php echo $objResult["count_m"]; ?>'  class = "w3-input" > 
หมายเหตุเพิ่มเติม
<textarea name="des_sale" id="des_sale" class="w3-input" rows="2" style="width:90%"><?php echo $objResult["des_sale"]; ?></textarea>					
</div>
	</p></fieldset></p><br>


<fieldset><legend ><b><font color="red">ข้อมูลการคืนเงินลูกค้า</font></b></legend></p>	
	
<div class="w3-half 1">
ธนาคาร : 
<input type="text" name = "bank_name" id="bank_name" style="width:90%;" value="<?php echo $objResult["bank_name"]; ?>" class = "w3-input" required> 
เลขที่บัญชี
<input type="text" name = "bank_no" id="bank_no" style="width:90%;" value="<?php echo $objResult["bank_no"]; ?>" class = "w3-input" required> 	
</div>
	
<div class="w3-half 1">
ชื่อบัญชี
<input type="text" name = "accbank_name" id="accbank_name" style="width:90%;" value="<?php echo $objResult["accbank_name"]; ?>" class = "w3-input" required> 	
แนบไฟล์รูป Book Bank
<input type='hidden' name='bank_img' id='bank_img' value ="<?php echo $objResult['bank_img']; ?>"  />	
<input name="bank_img" class = "w3-input" style="width:30%;" type="file" ><?php if($objResult['bank_img']!=''){ ?><a href="credit_no/<?php echo $objResult['bank_img']; ?>" target="_blank">ดูไฟล์แนบ</a><?php } ?>
</div>

	</p></fieldset></p><br>


<div class="w3-bar w3-light-grey w3-border">
<a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>การจัดส่ง(เพิ่มเติม)</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity1('cs2')"><font color="#404040"><b>ข้อมูลการชำระเงิน</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity1('cs1')"><font color="#404040"><b>เอกสารประกอบ</b></font></a>	
</div>


<div id="cs2" class="w3-container city1"  style="display:none">
<br>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="10%">จำนวนครั้ง</th>
			<th width="10%">วันที่เริ่ม</th> 
			<th width="10%">วันที่สิ้นสุด</th>
			<th width="23%">เลขที่ใบสั่งขาย</th>
			<th width="22%">การชำระเงิน</th>
			
	</thead>
		
<?php 	
$ref_iv = substr($objResult["ref_ai"],0,2);	
if($ref_iv=='SO'){ 
$strSQL15 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult["ref_ai"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
$doc__n = $objResult15["iv_no"];	
	
}else{
$strSQL15 = "SELECT doc_no FROM so__main WHERE ref_id = '".$objResult["ref_ai"]."' ";
	
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
$doc__n = $objResult15["doc_no"];
	
}
		
$strSQL16 = "SELECT summary_cash FROM tb_register_data WHERE ref_id = '".$objResult["ref_ai"]."' ";
$objQuery16 = mysqli_query($code,$strSQL16);
$objResult16= mysqli_fetch_array($objQuery16);

$strSQL18 = "SELECT date_tran FROM tb_credit_note WHERE iv_no_ref LIKE '".$doc__n."' and status_doc='Approve'";
$objQuery18 = mysqli_query($conn,$strSQL18);
$Num_Rows18 = mysqli_num_rows($objQuery18);		
$objResult18= mysqli_fetch_array($objQuery18);
		
		?>	
<tr>		
<th width="10%">0.เงินประกัน</th>
<th width="10%"></th> 
<th width="10%"></th>
<th width="23%"><?php echo $doc__n; ?></th>
<th width="22%"><?php if($Num_Rows18 > 0){ if($objResult18["date_tran"]!='0000-00-00'){ echo "คืนเงินค้ำประกันเรียบร้อย วันที่ ";  echo Datethai($objResult18["date_tran"]); }else{ echo $objResult16["summary_cash"]; } } ?></th>		
</tr>	
		
<?php
$strSQL2 = "SELECT *  FROM hos__rental_runiv  where ref_idren = '".$objResult["ref_id"]."' and ref_idiv !=''";	
$strSQL2 .=" order  by date_runiv DESC ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

$n = $Num_Rows2+1;
while($objResult2 = mysqli_fetch_array($objQuery2))
{
	
		
$ref_iv = substr($objResult2["ref_idiv"],0,2);	
if($ref_iv=='SO'){ 
$strSQL15 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult2["ref_idiv"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
$doc__n2 = $objResult15["iv_no"];		
}else{
$strSQL15 = "SELECT doc_no FROM so__main WHERE ref_id = '".$objResult2["ref_idiv"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
$doc__n2 = $objResult15["doc_no"];	
}
		
$strSQL17 = "SELECT summary_cash FROM tb_register_data WHERE ref_id = '".$objResult2["ref_idiv"]."' ";
$objQuery17 = mysqli_query($code,$strSQL17);
$objResult17 = mysqli_fetch_array($objQuery17);		
	?>
		
<tr>		
<th width="10%">ชำระครั้งที่ <?php echo $n; ?></th>
<th width="10%"><?php echo Datethai($objResult2["date_runiv"]); ?></th> 
<th width="10%"><?php
	$date_runiv = $objResult2["date_runiv"];
	/*if($objResult["ref_id"]=='RT68030001' and $n=='2'){
	$new_date = date('Y-m-d', strtotime($date_runiv . ' +4 month'));	
	}else{
	$new_date = date('Y-m-d', strtotime($date_runiv . ' +1 month'));
	}*/
	echo Datethai($objResult2["end_date"]);
	//echo Datethai($new_date); ?></th>
<th width="23%">
  <?php if ($ref_iv == 'SO') { ?>
    <a href="register_adminhos_edit.php?ref_id=<?php echo $objResult2["ref_idiv"]; ?>" target="_blank">
      <?php echo $doc__n2; ?>
    </a>
  <?php } else { ?>
    <a href="register_admin_edit.php?ref_id=<?php echo $objResult2["ref_idiv"]; ?>" target="_blank">
      <?php echo $doc__n2; ?>
    </a>
  <?php } ?>
</th>
<th width="22%"><?php echo $objResult17["summary_cash"]; ?></th>		
</tr>				
<?php 
$n--;
}
?>		
		
		
<?php 	
$ref_iv = substr($objResult["ref_iv"],0,2);	
if($ref_iv=='SO'){ 
$strSQL15 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult["ref_iv"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
$doc__n1 = $objResult15["iv_no"];		
}else{
$strSQL15 = "SELECT doc_no FROM so__main WHERE ref_id = '".$objResult["ref_iv"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
$doc__n1 = $objResult15["doc_no"];	
}
		
$strSQL17 = "SELECT summary_cash FROM tb_register_data WHERE ref_id = '".$objResult["ref_iv"]."' ";
$objQuery17 = mysqli_query($code,$strSQL17);
$objResult17 = mysqli_fetch_array($objQuery17);
		
		?>	
		
<tr>		
<th width="10%">ชำระครั้งที่ 1</th>
<th width="10%"><?php echo Datethai($objResult["start_promis"]); ?></th> 
<th width="10%"><?php echo Datethai($objResult["end_promis"]); ?></th>
<th width="23%">
	 <?php if ($ref_iv == 'SO') { ?>
    <a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_iv"]; ?>" target="_blank">
      <?php echo $doc__n1; ?>
    </a>
  <?php } else { ?>
    <a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_iv"]; ?>" target="_blank">
      <?php echo $doc__n1; ?>
    </a>
  <?php } ?>
	</th>
<th width="22%"><?php echo $objResult16["summary_cash"]; ?></th>		
</tr>				
		

</table>	

<br>

	<b>ข้อมูลการับส่งสินค้า</b><br>
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="10%">เลขที่ลงงาน</th>
			<th width="10%">สถานะ</th> 
			<th width="10%">วันที่</th> 
			<th width="10%">ผู้ดำเนินการ</th>
			<th width="10%">สรุปงาน</th>
			<th width="15%">หมายเหตุ</th>
			
	</thead>	
<?php 
if($objResult["job_no"]){ 
		
$sql1 = "select * from tb_register_data where running='".$objResult["job_no"]."'";
$query1 = mysqli_query($com1,$sql1);
$fetch1 = mysqli_fetch_array($query1);
		
		
?>		
	<tr>		
<th width="10%"><a href="https://cs.allwellcenter.com/7112018.php?running=<?php echo $fetch1["running"]; ?>" target="_blank"><?php echo $fetch1["running"]; ?> </a></th> 
<th width="10%">ส่งสินค้า</th>		
<th width="10%"><?php echo Datethai($fetch1["start_date"]); ?></th>
<th width="10%"><?php echo $fetch1["employee_send"]; ?></th>
<th width="10%"><?php echo $fetch1["summary_cs"]; ?></th>	
<th width="10%"><?php echo $fetch1["description_cs"]; ?></th>		
		
		
</tr>
		
<?php } ?>		
		
		
<?php 
if($objResult["job_idreturn"]){ 
		
$sql2 = "select * from tb_register_data where running='".$objResult["job_idreturn"]."'";
$query2 = mysqli_query($com1,$sql2);
$fetch2 = mysqli_fetch_array($query2);
		
		
?>		
	<tr>		
<th width="10%"><a href="https://cs.allwellcenter.com/7112018.php?running=<?php echo $fetch2["running"]; ?>" target="_blank"><?php echo $fetch2["running"]; ?> </a></th> 
<th width="10%">รับสินค้า</th>				
<th width="10%"><?php echo Datethai($fetch2["start_date"]); ?></th>
<th width="10%"><?php echo $fetch2["employee_send"]; ?></th>
<th width="10%"><?php echo $fetch2["summary_cs"]; ?></th>	
<th width="10%"><?php echo $fetch2["description_cs"]; ?></th>		
		
		
</tr>
		
<?php } ?>		
	
<?php 
if($objResult["ref_rt"]){ 
		
$sql3 = "select * from hos__receive where ref_id='".$objResult["ref_rt"]."'";
$query3 = mysqli_query($conn,$sql3);
$fetch3 = mysqli_fetch_array($query3);
		
		
?>		
	<tr>		
<th width="10%"><a href="rister_clearbrpn_stedit.php?ref_id=<?php echo $fetch3["ref_id"]; ?>" target="_blank"><?php echo $fetch3["ref_id"]; ?> </a></th> 
<th width="10%">คืนสินค้า</th>		
<th width="10%"><?php echo Datethai($fetch3["stock_date"]); ?></th>
<th width="10%"><?php echo $fetch3["stock_name"]; ?></th>
<th width="10%"><?php 
	if($fetch3["stock_complete"]=='1'){ 
		echo "สมบูรณ์"; 
	}else if($fetch3["stock_complete"]=='2'){ 
	echo "ไม่สมบูรณ์"; 
	}else if($fetch3["stock_complete"]=='2'){ 		
	echo "รอสินค้า"; 
		}else{
	echo "รอสินค้า"; 	
	}
	
	?></th>	
<th width="10%"><?php echo $fetch3["edit_des"]; ?></th>		
		
		
</tr>
		
<?php } ?>				
		
		
	</table>	
	
</div>		
	
</div>		
	
	
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
	
	
	
	
$strSQL2 = "SELECT product_code,count  FROM hos__subrental where ref_idd = '".$ref_id."' and product_code ='".$objResult1["product_code"]."' and ckk_pro='0'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);	

if($Num_Rows2 > 0){
	
$strSQL3 = "SELECT * FROM  tb_product_checklist  WHERE ref_id = '".$ref_id."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
$strSQLreb = "SELECT * FROM tb_product_rental where product_id ='".$objResult1["product_code"]."'";
$objQueryreb = mysqli_query($conn,$strSQLreb) or die ("Error Query [".$strSQL2."]");
$Num_Rowsreb = mysqli_num_rows($objQueryreb);
$objResultreb = mysqli_fetch_array($objQueryreb);	
	

if($objResult3["ref_id"]!=''){ }else{
	
	
$save99="insert into tb_product_rentalref
(ref_idrt,product_id,sn_number,list_des1,list_des2,list_des3,list_des4,list_des5,list_des6,list_des7,list_des8,list_des9,list_des11,list_des12,list_des13,list_des14,list_des15,list_des16)
values
('".$ref_id."','".$objResult1["product_code"]."','".$objResultreb["sn_number"]."','".$objResultreb["list_des1"]."','".$objResultreb["list_des2"]."','".$objResultreb["list_des3"]."','".$objResultreb["list_des4"]."','".$objResultreb["list_des5"]."','".$objResultreb["list_des6"]."','".$objResultreb["list_des7"]."','".$objResultreb["list_des8"]."','".$objResultreb["list_des9"]."','".$objResultreb["list_des10"]."','".$objResultreb["list_des11"]."','".$objResultreb["list_des12"]."','".$objResultreb["list_des13"]."','".$objResultreb["list_des14"]."','".$objResultreb["list_des15"]."','".$objResultreb["list_des16"]."')";
$qsave99=mysqli_query($conn,$save99);	
	
	

$product_id = $objResult1["product_code"]; 
$count = str_replace('.00','',$objResult2["count"]);
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

$strDate = date('Y-m-d');

$strYear = date("Y",strtotime($strDate))+543;
$strYear1 =substr( $strYear , 2 , 2 );

//for ($x = 0; $x <= $count; $x+=$count) {
	

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_pc) AS MAXID FROM tb_product_checklist where head_pc='DO'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);

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

$so = "DO";
$ref_pc ="$so$nextId";



$save99="insert into tb_product_checklist
(ref_pc,doc_no,year_no,ref_id,product_id,add_date,add_by,date_create,head_pc)
values
('".$ref_pc."','".$ref_pc."','".$strYear1."','".$ref_id."','".$product_id."','".$add_date."','".$add_by."','".$strDate."','".$so."')";
$qsave99=mysqli_query($conn,$save99);


$save1="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','ST','1')";
$qsave1=mysqli_query($conn,$save1);

$save2="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','EN','1')";
$qsave2=mysqli_query($conn,$save2);

$save3="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','CS','1')";
$qsave3=mysqli_query($conn,$save3);

$save4="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','CS','2')";
$qsave4=mysqli_query($conn,$save4);

$save5="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','EN','2')";
$qsave5=mysqli_query($conn,$save5);

$save6="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','ST','2')";
$qsave6=mysqli_query($conn,$save6);	
	
	
//}	
	
$strSQL = "Update   hos__subrental set ckk_pro='1'  Where ref_idd = '".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL);
	
	
}
}
		
	
	
	
	
	
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
<?php if($objResult["send_sup"]=='0'){ ?>
<td style="width:2%;"><a href="product_choadelete.php?ref_id=<?php echo $objResult["ref_id"];?>&id_sub=<?php echo $objResult1["id_sub"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a></td>
<?php } ?>
</tr>

<?php } ?>
</table>

<?php 
	if($objResult["send_sup"]=='0'){
	if($objResult["type_doc"]=='3'){
	include ('product_rentalawl1.php');	
	}else if($objResult["type_doc"]=='4'){
	include ('product_rentalnbm1.php');		
	}
	}
	?>
	
	
</div>
<div id="cs1" class="w3-container city1" style="display:none">
<br>
	
<a href="delivery_from.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-center"><font color="purple">ใบรับส่งสินค้า</font></a>
	
<a href="delivery_from_pw.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-center"><font color="purple">ใบรับส่งสินค้า preview</font></a>	
	
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
<?php if ($objResult['send_cs']=='2'){ ?>
	<input type="checkbox" name="send_cs" checked='checked' value="2">&nbsp;ส่งข้อมูลไปสมุดลงงาน CS 

	<?php }else{ ?>

	<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไปสมุดลงงาน CS 

		<?php
	} 
		?><br>
 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date" value="<?php echo $fetch1["start_date"]; ?>"  class="button4" style="width:20%" /></p>


วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="button4" type='text'  value="<?php echo $fetch1["between_date"]; ?>" id="between_date" style="width:20%" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เวลา :&nbsp;&nbsp;&nbsp;&nbsp;
<input id="start_time"  name="start_time"  value="<?php echo $fetch1["start_time"]; ?>" class="button4" type="text" style="width:10%"/>
ถึง
<input id="end_time" name="end_time"  value="<?php echo $fetch1["end_time"]; ?>"  class="button4" type="text" style="width:10%"/></p>



สถานะการทำงาน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

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
<input name="department_show" value="<?php echo $fetch1["department_show"]; ?>"  class="button4" type='text' id="department_show">


</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทลูกค้า :

	   <input name="customer_typename"  value="<?php echo $fetch1["type_customer"]; ?>"  class="button4" type='text' id="customer_typename">

</p>



       หน่วยงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   	   <input name="company_name"  value="<?php echo $fetch1["type_company"]; ?>"  class="button4" type='text' id="company_name">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทงาน :&nbsp;&nbsp;
	   <input name="department_name" value="<?php echo $fetch1["department"]; ?>"  class="button4" type='text' id="department_name">

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

	<?php
	$sql2 = "select * from tb_transaction where ref_id = '".$objResult["ref_id"]."'";
				$query2 = mysqli_query($conn,$sql2);
				$fetch2 = mysqli_fetch_array($query2,MYSQLI_ASSOC); 
if ($fetch1["check_detail"]=='0' or $fetch1["check_detail"]==''){
		?>
	<fieldset><legend><input type="checkbox" name="more" id="more" value="1"> <b>รายละเอียดการจัดส่ง</b></legend>
	<div id="more-2" style="display:none;">
		<div class="w3-container w3-third 112">
			<div class="w3-bar 1">

						<input type="checkbox" name="runway"id = "runway" value="1"> ติดถนนรันเวย์
			</div>
			<div class="w3-container w3-bar 2">
					<input type="checkbox" name="road"id = "road" value="1"> ติดถนนวิ่งสวนกัน

			</div>
			<div class="w3-container w3-bar 3">
				<input type="checkbox" name="soy"id = "soy" value="1"> เข้าซอย

			</div>
			<div class="w3-container w3-bar 4">
				ทางเข้ากว้าง
				<input name="soy_big" class="w3-input" value="<?php echo $fetch1["soy_big"]; ?>" type='text' id="soy_big" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 5">
			 		<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง

			</div>
			<div class="w3-container w3-bar 6">
				<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได้
			</div>
			<div class="w3-container w3-bar 7">
				<input type="checkbox" name="no_car_road"id = "no_car_road" value="1"> รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 8">
				การจอดรถ
			</div>
			<div class="w3-container w3-bar 9">
				<input type="checkbox" name="car_road" id = "car_road" value="1"> จอดรถข้างถนน
			</div>
			<div class="w3-container w3-bar 10">
				<input type="checkbox" name="car_home"id = "car_home" value="1"> จอดรถหน้าบ้านได้
			</div>
			<div class="w3-container w3-bar 11">
				ประตูหน้าบ้านสูง
				<input name="door_long" class="w3-input" type='text' id="door_long" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 12">
				<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
			</div>
			<div class="w3-container w3-bar 13">
				<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน
			</div>
			<div class="w3-container w3-bar 14">
				<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" style="width:90%;" placeholder="จำนวน (ขั้น)" />
			</div>
			<div class="w3-container w3-bar 15">
				ประตูบ้านกว้าง
				<input name="door_bigger" class="w3-input" type='text' id="door_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 16">
				ประตูสูง 
				<input name="door_longer" class="w3-input" type='text' id="door_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 17">
				ประตูห้องกว้าง 
				<input name="room_bigger" class="w3-input" type='text' id="room_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 18">
				ประตูห้องสูง 
				<input name="room_longer" class="w3-input" type='text' id="room_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
		</div>
		<div class="w3-container w3-third 212">
			<div class="w3-bar 1">
				ประตูบ้านเป็นแบบ
				<input name="type_door" class="w3-input" type='text' id="type_door" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 2">
				พื้นบ้านเป็นแบบ
				<input name="home_type" class="w3-input" type='text' id="home_type" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 3">
				ติดตั้งที่ชั้น
				<input name="install" class="w3-input" type='text' id="install" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 4">
				<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง
			</div>
			<div class="w3-container w3-bar 5">
				<input name="bundai_big" class="w3-input" type='text' id="bundai_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-container w3-bar 6">
				หักมุมบันได
				<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 7">
				ชนิดของบันได
				<input name="type_bundai" class="w3-input" type='text' id="type_bundai" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 8">
				<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง
			</div>
			<div class="w3-container w3-bar 9">
				<input name="lip_big" class="w3-input" type='text' id="lip_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-container w3-bar 10">
				สูง
				<input name="lip_long" class="w3-input" type='text' id="lip_long" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-container w3-bar 11">
				รับน้ำหนักได้ 
				<input name="lip_weight" class="w3-input" type='text' id="lip_weight" style="width:90%;" />
			</div>
			
		</div>
		<div class="w3-container w3-third 312">
			<div class="w3-container w3-bar 12">
				<input type="checkbox" name="up"id ="up" value="1"> ขึ้นลิฟท์ได้
			</div>
			<div class="w3-container w3-bar 13">
				<input type="checkbox" name="no_up"id ="no_up" value="1"> ขึ้นลิฟท์ไม่ได้
			</div>
			<div class="w3-container w3-bar 14">
				<input type="checkbox" name="head_bad"id ="head_bad" value="1"> ต้องถอดหัวเตียง-ท้ายเตียง
			</div>
			<div class="w3-container w3-bar 15">
				<input type="checkbox" name="want_employee"id ="want_employee" value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
			</div>
			<div class="w3-container w3-bar 16">
				จำนวนคนที่ใช้ 
				<input name="employee_unit" class="w3-input" type='text' id="employee_unit" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 17">
				ย้ายเฟอร์นิเจอร์ 
				<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 18">
				ย้ายไปที่ 
				<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar">
				<input type="checkbox" name="want_ex"id = "want_ex" value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
			</div>
			<div class="w3-container w3-bar">
				<input type="checkbox" name="want_credit"id = "want_credit" value="1"> ต้องเตรียมเครื่องรูดบัตร
			</div>
			<div class="w3-container w3-bar">
				ธนาคาร 
				<input name="bank" class="w3-input" type='text' id="bank" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar">
				<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
			</div>
			<div class="w3-container w3-bar">
				รายละเอียดเพิ่มเติม
				<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"></textarea>
			</div>
		</div>
	</div>
	</fieldset>
<?php
}else if ($fetch1["check_detail"]=='1'){
		?>
<fieldset><legend><input type="checkbox" name="more" id="more" value="1" checked="checked"> <b>รายละเอียดการจัดส่ง</b></legend>

		<div class="w3-third 112">
			<div class="w3-bar 1">

<?php
if ($fetch2["runway"]=='1'){
		?>
				<input type="checkbox" name="runway"id = "runway" checked='checked' value="1"> ติดถนนรันเวย์
	<?php
}else{
			?>
			<input type="checkbox" name="runway"id = "runway" value="1"> ติดถนนรันเวย
				<?php
		}
					?>
			</div>
			<div class="w3-bar 2">

			<?php
if ($fetch2["road"]=='1'){
		?>
				<input type="checkbox" name="road"id = "road" checked='checked' value="1"> ติดถนนวิ่งสวนกัน
<?php
			}else{
			?>

				<input type="checkbox" name="road"id = "road" value="1"> ติดถนนวิ่งสวนกัน
				<?php
		}
				?>

			</div>
			<div class="w3-bar 3">
			<?php
if ($fetch2["soy"]=='1'){
		?>
				<input type="checkbox" name="soy"id = "soy" checked='checked' value="1"> เข้าซอย
				<?php
			}else{
			?>
				<input type="checkbox" name="soy"id = "soy" value="1"> เข้าซอย

				<?php
		}
				?>
			</div>
			<div class="w3-bar 4">
				ทางเข้ากว้าง
				<input name="soy_big" class="w3-input" value="<?php echo $fetch2["soy_big"]; ?>" type='text' id="soy_big" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 5">
			<?php
		if ($fetch2["height_ltd"]=='1'){
		?>
				<input type="checkbox" name="height_ltd" id = "height_ltd" checked='checked' value="1"> มีตัวจำกัดความสูง
				<?php
				}else{
			?>
				<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง

				<?php
		}
				?>
			</div>
			<div class="w3-bar 6">
			<?php
		if ($fetch2["car_load"]=='1'){
		?>
				<input type="checkbox" name="car_load"id = "car_load" checked='checked' value="1"> รถยนต์สามารถเข้าได้
	<?php
				}else{
			?>
				<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได้

				<?php
		}
				?>
			
			
			</div>
			<div class="w3-bar 7">
			<?php
		if ($fetch2["no_car_road"]=='1'){
		?>
				<input type="checkbox" name="no_car_road"id = "no_car_road" checked='checked' value="1">
			<?php
			}else{
			?>
			<input type="checkbox" name="no_car_road"id = "no_car_road" value="1">
		<?php
		}
			?>
				
				รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" value ="<?php echo $fetch2["car_park"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				การจอดรถ
			</div>
			<div class="w3-bar 9">
	<?php
		if ($fetch2["car_road"]=='1'){
		?>

				<input type="checkbox" name="car_road" id = "car_road" checked='checked' value="1"> จอดรถข้างถนน
<?php
				}else{
					?>
				<input type="checkbox" name="car_road" id = "car_road" value="1"> จอดรถข้างถนน

						<?php
				}
						?>

			</div>
			<div class="w3-bar 10">
	<?php
		if ($fetch2["car_home"]=='1'){
		?>

				<input type="checkbox" name="car_home"id = "car_home" checked='checked' value="1"> จอดรถหน้าบ้านได้
				<?php
			}else{
				?>
				<input type="checkbox" name="car_home"id = "car_home" value="1"> จอดรถหน้าบ้านได้

					<?php
				}
					?>
			</div>
			<div class="w3-bar 11">
				ประตูหน้าบ้านสูง
				<input name="door_long" class="w3-input" type='text' value="<?php echo $fetch2["door_long"]; ?>" id="door_long" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 12">
			<?php
		if ($fetch2["slope"]=='1'){
		?>
				<input type="checkbox" name="slope"id = "slope" checked='checked' value="1"> มีทางราบก่อนประตูบ้าน
				<?php
					}else{
		?>
		<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
			<?php
		}
			?>

			</div>
			<div class="w3-bar 13">
	<?php
		if ($fetch2["bundai"]=='1'){
		?>
				<input type="checkbox" name="bundai"id = "bundai" checked='checked' value="1"> มีบันไดก่อนประตูบ้าน
				<?php
			}else{
			?>
				<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน

				<?php
		}
				?>
			</div>
			<div class="w3-bar 14">
				<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" value="<?php echo $fetch2["unit_bundai"]; ?>" style="width:90%;" placeholder="จำนวน (ขั้น)" />
			</div>
			<div class="w3-bar 15">
				ประตูบ้านกว้าง
				<input name="door_bigger" class="w3-input" type='text' id="door_bigger" value="<?php echo $fetch2["door_bigger"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 16">
				ประตูสูง 
				<input name="door_longer" class="w3-input" type='text' id="door_longer" value="<?php echo $fetch2["door_longer"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 17">
				ประตูห้องกว้าง 
				<input name="room_bigger" class="w3-input" type='text' id="room_bigger" value="<?php echo $fetch2["room_bigger"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 18">
				ประตูห้องสูง 
				<input name="room_longer" class="w3-input" type='text' id="room_longer"  value="<?php echo $fetch2["room_longer"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
		</div>
		<div class="w3-third 212">
			<div class="w3-bar 1">
				ประตูบ้านเป็นแบบ
				<input name="type_door" class="w3-input" type='text' id="type_door"  value="<?php echo $fetch2["type_door"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 2">
				พื้นบ้านเป็นแบบ
				<input name="home_type" class="w3-input" type='text' id="home_type" value="<?php echo $fetch2["home_type"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 3">
				ติดตั้งที่ชั้น
				<input name="install" class="w3-input" type='text' id="install" value="<?php echo $fetch2["install"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 4">

			<?php
		if ($fetch2["bundai_install"]=='1'){
		?>
				<input type="checkbox" name="bundai_install"id ="bundai_install" checked='checked' value="1"> บันไดกว้าง
<?php
			}else{
			?>
				<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง

				<?php
		}
				?>

			</div>
			<div class="w3-bar 5">
				<input name="bundai_big" class="w3-input" type='text' id="bundai_big" value="<?php echo $fetch2["bundai_big"]; ?>" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 6">
				หักมุมบันได
				<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" value="<?php echo $fetch2["bundai_hug"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 7">
				ชนิดของบันได
				<input name="type_bundai" class="w3-input" type='text' id="type_bundai" value="<?php echo $fetch2["type_bundai"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
			<?php
		if ($fetch2["lip"]=='1'){
		?>
				<input type="checkbox" name="lip"id = "lip" checked='checked' value="1"> ลิฟท์กว้าง
				<?php
			}else{
			?>

				<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง

				<?php
		}
				?>
			</div>
			<div class="w3-bar 9">
				<input name="lip_big" class="w3-input" type='text' id="lip_big" value="<?php echo $fetch2["lip_big"]; ?>" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 10">
				สูง
				<input name="lip_long" class="w3-input" type='text' id="lip_long" value="<?php echo $fetch2["lip_long"]; ?>" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 11">
				รับน้ำหนักได้ 
				<input name="lip_weight" class="w3-input" type='text' id="lip_weight" value="<?php echo $fetch2["lip_weight"]; ?>" style="width:90%;" />
			</div>
			
		</div>
		<div class="w3-third 312">
			<div class="w3-bar 12">
		<?php
		if ($fetch2["up"]=='1'){
		?>
				<input type="checkbox" name="up"id ="up" checked='checked' value="1"> ขึ้นลิฟท์ได้
				<?php
		}else{
			?>
				<input type="checkbox" name="up"id ="up" value="1"> ขึ้นลิฟท์ได้

				<?php
		}
				?>
			</div>
			<div class="w3-bar 13">
			<?php
		if ($fetch2["no_up"]=='1'){
		?>
				<input type="checkbox" name="no_up"id ="no_up" checked='checked' value="1"> ขึ้นลิฟท์ไม่ได้
				<?php
				}else{
			?>
		<input type="checkbox" name="no_up"id ="no_up" value="1"> ขึ้นลิฟท์ไม่ได
				<?php
		}
				?>
			</div>
			<div class="w3-bar 14">
			<?php
		if ($fetch2["head_bad"]=='1'){
		?>
				<input type="checkbox" name="head_bad"id ="head_bad" checked='checked' value="1"> ต้องถอดหัวเตียง-ท้ายเตียง
				<?php
				}else{
			?>
				<input type="checkbox" name="head_bad"id ="head_bad" value="1"> ต้องถอดหัวเตียง-ท้ายเตียง

				<?php
		}
				?>
			</div>
			<div class="w3-bar 15">
			<?php
		if ($fetch2["want_employee"]=='1'){
		?>
				<input type="checkbox" name="want_employee"id ="want_employee" checked='checked' value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
		<?php
				}else{
			?>
				<input type="checkbox" name="want_employee"id ="want_employee" value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์

				<?php
		}
				?>
			
			</div>
			<div class="w3-bar 16">
				จำนวนคนที่ใช้ 
				<input name="employee_unit" class="w3-input" type='text' value="<?php echo $fetch2["employee_unit"]; ?>" id="employee_unit" style="width:90%;" />
			</div>
			<div class="w3-bar 17">
				ย้ายเฟอร์นิเจอร์ 
				<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" value="<?php echo $fetch2["ferniger_name"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 18">
				ย้ายไปที่ 
				<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" value="<?php echo $fetch2["ferniger_address"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar">
		<?php
		if ($fetch2["want_ex"]=='1'){
		?>
				<input type="checkbox" name="want_ex"id = "want_ex" checked='checked' value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
				<?php
			}else{
			?>
				<input type="checkbox" name="want_ex"id = "want_ex" value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ

				<?php
		}
			?>
			</div>
			<div class="w3-bar">
		<?php
		if ($fetch2["want_credit"]=='1'){
		?>

				<input type="checkbox" name="want_credit"id = "want_credit" checked='checked' value="1"> ต้องเตรียมเครื่องรูดบัตร
		<?php
			}else{
					?>
				<input type="checkbox" name="want_credit"id = "want_credit" value="1"> ต้องเตรียมเครื่องรูดบัตร

						<?php
				}
						?>

			</div>
			<div class="w3-bar">
				ธนาคาร 
				<input name="bank" class="w3-input" type='text' id="bank" value="<?php echo $fetch2["bank"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar">
		<?php
		if ($fetch2["want_prem"]=='1'){
		?>
				<input type="checkbox" name="want_prem"id ="want_prem" checked='checked' value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
				<?php
			}else{
					?>
				<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า

						<?php
				}
						?>
			</div>
			<div class="w3-bar">
				รายละเอียดเพิ่มเติม
				<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"><?php echo $fetch2["description"]; ?></textarea>
			</div>
		</div>
	
	</fieldset>



<?php
		}
		?>

</div>


<br>
<center>
	<?php if($objResult["status_doc"] != 'Approve'){ ?>	
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
	<?php } ?>
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
