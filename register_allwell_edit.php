<?php include('head.php'); ?>
<?php include('dbconnect_cs.php'); ?>
<script src="dist/jautocalc.js"></script></head>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>

<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(bill_id,billing_name,billing_address,billing_tel,tax_id,ex_add,ex_aumper,ex_provin,ex_post,pre_name,customer_name,address1,address2,province,postcode,tel,delivery_contact,delivery_place,email,customer_typename) {
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

document.getElementById(billing_name).value = myArr[0];
document.getElementById(billing_address).value = myArr[1];
document.getElementById(email).value = myArr[21];
document.getElementById(billing_tel).value = myArr[2];
document.getElementById(tax_id).value = myArr[3];
document.getElementById(ex_add).value = myArr[6];
document.getElementById(ex_aumper).value = myArr[7];
document.getElementById(ex_provin).value = myArr[8];
document.getElementById(ex_post).value = myArr[9];
document.getElementById(pre_name).value = myArr[10];
document.getElementById(customer_name).value = myArr[12];
document.getElementById(address1).value = myArr[13];
document.getElementById(address2).value = myArr[14];
document.getElementById(province).value = myArr[15];
document.getElementById(postcode).value = myArr[16];
document.getElementById(tel).value = myArr[17];	
document.getElementById(delivery_contact).value = myArr[18];
document.getElementById(delivery_place).value = myArr[19];

document.getElementById(customer_typename).value = myArr[22];

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




function chkNumber(ele) 
{
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
ele.onKeyPress=vchar;
}
</script>
<body>
<?php
$strSQL = "SELECT *  FROM so__main WHERE ref_id = '".$_GET['ref_id']."' ";

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
	
include("dbconnect_cs.php");
$strSQL27 = "SELECT * FROM tb_research WHERE red_id = '".$ref_id."' ";
$objQuery27 = mysqli_query($com1,$strSQL27) or die(mysqli_error());
$objResult27 = mysqli_fetch_array($objQuery27);

$ref_idd = $objResult["ref_id"];
$strSQL12 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='1'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);


$strSQL13 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='2'";
$objQuery13 = mysqli_query($conn,$strSQL13) or die("Error Query [".$strSQL13."]");
$objResult13 = mysqli_fetch_array($objQuery13);

$strSQL14 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='3'";
$objQuery14 = mysqli_query($conn,$strSQL14) or die("Error Query [".$strSQL14."]");
$objResult14 = mysqli_fetch_array($objQuery14);

$strSQL15 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='4'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);

$strSQL16 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='5'";
$objQuery16 = mysqli_query($conn,$strSQL16) or die("Error Query [".$strSQL16."]");
$objResult16 = mysqli_fetch_array($objQuery16);

$strSQL17 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='6'";
$objQuery17 = mysqli_query($conn,$strSQL17) or die("Error Query [".$strSQL17."]");
$objResult17 = mysqli_fetch_array($objQuery17);

$strSQL18 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='7'";
$objQuery18 = mysqli_query($conn,$strSQL18) or die("Error Query [".$strSQL18."]");
$objResult18 = mysqli_fetch_array($objQuery18);

$strSQL19 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='8'";
$objQuery19 = mysqli_query($conn,$strSQL19) or die("Error Query [".$strSQL19."]");
$objResult19 = mysqli_fetch_array($objQuery19);

$strSQL20 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='9'";
$objQuery20 = mysqli_query($conn,$strSQL20) or die("Error Query [".$strSQL20."]");
$objResult20 = mysqli_fetch_array($objQuery20);
	
$sql1 = "select * from tb_register_data where ref_id = '".$_GET["ref_id"]."'";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
	
$sql23 = "SELECT * FROM tb_other_bill where ref_id = '".$_GET["ref_id"]."'";
$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_assoc($qry23);		
	
$sql26 = "SELECT *   FROM tb_comment_so where ref_id = '".$_GET["ref_id"]."'";
$qry26 = mysqli_query($conn,$sql26) or die(mysqli_error());
$rs26 = mysqli_fetch_assoc($qry26);
	
	
$strCheck = "
SELECT EXISTS(
    SELECT 1
    FROM so__submain s
    LEFT JOIN tb_product p ON s.product_ID = p.product_id
    WHERE s.ref_idd = '".$ref_id."'
      AND (
            (p.group1 = '501105 ที่นอนโฟมป้องกันแผลกดทับ' AND p.unit_name = 'แผ่น')
         OR s.product_ID IN (6016,6015,6014,6013,6012)
         OR (p.group1 LIKE '%เตียง%' AND p.unit_name = 'เตียง')
      )
) AS has_match
";
 //OR (p.group1 LIKE '%รถเข็น%' AND p.unit_name = 'คัน')
$q = mysqli_query($conn, $strCheck) or die("Error Query [".$strCheck."]");
$r = mysqli_fetch_assoc($q);

$flag = (!empty($r) && $r['has_match'] == '1') ? '1' : '0';

// ✅ มี = 1, ไม่มี = 0
		
if ($objResult["select_type_doc"]=='3' || $objResult["select_type_doc"]=='4'){ 	
		
mysqli_query($conn, "UPDATE so__main SET reseach_kk='".$flag."' WHERE ref_id='".$ref_id."'");
mysqli_query($conn, "UPDATE tb_register_data SET mk_research='".$flag."' WHERE ref_id='".$ref_id."'");	
mysqli_query($com1, "UPDATE tb_register_data SET mk_research='".$flag."' WHERE ref_id='".$ref_id."'");			
		
}			
?>
<form action='register_allwell_edit1.php' method="post" name="frmMain" enctype="multipart/form-data" onkeypress="return event.keyCode!=13">
<div class="w3-white">
<div class="w3-container w3-padding-large"><!-- main div -->
<div class="w3-container w3-panel w3-light-gray">
	<div class="w3-half">
	<h4>Edit Data : ALLWELL</h4>
	</div><div class="w3-half">
	
<?php if ($objResult["job_id"]!=''){ ?>
		
<a href="https://cs.allwellcenter.com/7112018.php?running=<?php echo $objResult["job_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">รายละเอียดจัดส่ง</font></a>

<?php } ?>								
	
<a href="sendadmin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&bill_vat=<?php echo $objResult["bill_vat"];?>" class="w3-button w3-grey w3-right"><font color="330066">ส่งข้อมูลให้ Admin</font></a>
	<a href="sendsup_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&bill_vat=<?php echo $objResult["bill_vat"];?>" class="w3-button w3-grey w3-right"><font color="red">ส่งข้อมูลให้ Sup</font></a>
	
	
	<?php  if($objResult["bill_vat"]=='1' && $objResult["status_vat"]=='Approve') {
		if($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='3') {
		 ?>
</p><a href="report_vat1.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">ใบกำกับภาษี ตรากลม</font></a>
			
			<a href="report_vat.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">ใบกำกับภาษี ตราเหลี่ยม</font></a>
	
	</p><a href="report_vatph1.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">ใบกำกับภาษี ตรากลม(สินค้า)</font></a>
			
			<a href="report_vatph.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">ใบกำกับภาษี ตราเหลี่ยม(สินค้า)</font></a>
				
		
		<?php }else if($objResult["select_type_doc"]=='2' or $objResult["select_type_doc"]=='4') {
		 ?> 
			</p>
		
		<a href="report_vatnbm.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="DeepPink">ใบกำกับภาษี ตรากลม</font></a>
		<a href="report_vatnbm1.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="DeepPink">ใบกำกับภาษี ตราเหลี่ยม</font></a>
	</p><a href="report_vat_nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="DeepPink">ใบกำกับภาษี ตรากลม(สินค้า)</font></a>
		<a href="report_vat_nbm1.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="DeepPink">ใบกำกับภาษี ตราเหลี่ยม(สินค้า)</font></a>
				<?php 
		}
		} ?>
	
	</div>
	
	</div>
<div class="w3-third"><!-- first half -->
<div class="w3-bar w3-border">
<?php
		if ($objResult["select_type_doc"]=='3'){
?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย AWL</div>
<?php
	}else{
	?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย AWL</div>
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
<input type="hidden" name='start_date'  class='w3-input' value="<?php echo $_GET["start_date"];?>" readonly/>
<input type="hidden" name='end_date'  class='w3-input' value="<?php echo $_GET["end_date"];?>" readonly/>

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
		<!--input name="delivery" type='text' class="w3-input" id="delivery" value="<?php echo $objResult["delivery_name"]; ?><?php echo $objResult["time_delivery"]; ?>" placeholder="Search การจัดส่ง..."> 
		<input name="h_delivery" type="hidden" id="h_delivery"  value="<?php echo $objResult["delivery"]; ?>" class="w3-input" /--> 


<select name="h_delivery" id="h_delivery" class="w3-select">
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
<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>" <?php echo $sel;?>><?php echo $fetchdeli['delivery_name'];?><?php echo $fetchdeli['time_delivery']; ?></option>
<?php } ?>
</select>

</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
การชำระเงิน
	
<?php
if($objResult["select_type_doc"]=='3' or $objResult["select_type_doc"]=='1'){ 
$erer = '4';	 
}else{
$erer = '3';	
}
?>
	

<!--input name="payment" type='text' class="w3-input" id="payment"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน..."/>> 
<input name="h_payment" type="text" id="h_payment" value="<?php echo $objResult["payment"]; ?>" class="w3-input"  -->

<select name="h_payment"  id="h_payment" class="w3-select" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_bank  where close_ckk='0' and company !='".$erer."' order by number ASC";
$objQuery5 = mysqli_query($code,$strSQL5);
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["payment"] == $objResuut5["id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
	
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['id']; ?>"  <?php echo $sel;?>><?php echo $objResuut5['pay_in']; ?>  <?php echo $objResuut5['bank_name']; ?>    <?php echo $objResuut5['branch_bank']; ?> <?php echo $objResuut5['book_name']; ?> </option>
<?php } ?>
</select>

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

รหัสอ้างอิงการส่ง1
<input name="order_refer_code" class="w3-input w3-sand" value="<?php echo $objResult['order_refer_code']; ?>"  type="text" >
	รหัสอ้างอิงการส่ง2
<input name="order_refer_code1" class="w3-input w3-sand" value="<?php echo $objResult['order_refer_code1']; ?>"  type="text" >
	
<?php if($objResult["send_erpst"]=="1"){ ?>	
	
<font color="red">หมายเหตุการแก้ไข (เนื่องจาก Stock จัดของแล้ว)</font></p>
<textarea  name = "line_stock"  id = "line_stock"  rows="2" class="w3-input"  required ></textarea>

<?php }else if($objResult["stock_print"]==""){ ?>
<input type='hidden'  name = "line_stock"  id = "line_stock"  class="button4"   >
<?php }else{  ?>
<font color="red">หมายเหตุการแก้ไข (เนื่องจาก Stock ปริ้นเอกสารแล้ว)</font></p>
<textarea  name = "line_stock"  id = "line_stock"  rows="2" class="w3-input"  required ></textarea>
<?php } ?>
				
	
	</p>
	
	
	</p>	
	</p>	
	<?php if($objResult['buy_ckk']=='1'){ ?>
			<input type="checkbox" name="buy_ckk" checked='checked' value="1"> &nbsp;ลูกค้าซื้อซ้ำ<br>

	<?php }else{ ?>
		<input type="checkbox" name="buy_ckk" value="1"> &nbsp;ลูกค้าซื้อซ้ำ<br>
	<?php } ?>

<?php if($rs23["ref_12"]=='1'){ ?>
<input type="checkbox" name="ref_12" checked='checked' id="ref_12" value="1"> &nbsp;ส่งสินค้าด้วยใบรับสินค้า [ไม่ระบุราคา]<br>
<?php }else{ ?>
<input type="checkbox" name="ref_12"  id="ref_12" value="1"> &nbsp;ส่งสินค้าด้วยใบรับสินค้า [ไม่ระบุราคา]<br>

<?php } ?>

<?php if($rs23["ref_13"]=='1'){ ?>
<input type="checkbox" name="ref_13"  checked='checked' id="ref_13" value="1"> &nbsp;ไม่ต้องนำใบกำกับภาษี/ใบเสร็จไปส่งสินค้า
<?php }else{ ?>
<input type="checkbox" name="ref_13"  id="ref_13" value="1"> &nbsp;ไม่ต้องนำใบกำกับภาษี/ใบเสร็จไปส่งสินค้า
<?php } ?>
</div>
</div><!-- 1st half -->
<!-- tab -->
<div class="w3-twothird w3-container"><!-- second half -->
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity('so')"><font color="404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('mo')"><font color="404040"><b>เพิ่มเติม</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('ca')"><font color="404040"><b>การโทรรีวิว</b></font></a>
  <!--a class="w3-bar-item w3-button"  onclick="openCity('rs')"><font color="404040"><b>แบบสอบถาม</b></font></a-->

  <div class="dropdown">
<button class="w3-bar-item w3-button" ><font color="404040"><b>ที่อยู่เพิ่มเติม</b></font></button>
<div class="dropdown-content w3-light-grey w3-border">
<a class="w3-bar-item w3-button" onclick="openCity('so1')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 2</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so2')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 3</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so3')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 4</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so4')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 5</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so5')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 6</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so6')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 7</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so7')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 8</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so8')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 9</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so9')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 10</b></font></a>
</div>
</div>

</div>

<div id="so" class="city" >
<div class="w3-padding-small"></div>
<div class="w3-half w3-container"><!-- first so half -->
	<?php if($objResult['have_order'] =='1'){ ?>
	<input type="checkbox" name="have_order" id="have_order"  checked='checked' value="1"> &nbsp; มีออร์เดอร์ฝาก &nbsp;&nbsp;
	
<?php }else{
?>
	<input type="checkbox" name="have_order" id="have_order"  value="1"> &nbsp; มีออร์เดอร์ฝาก &nbsp;&nbsp;
	<?php } ?>
	<?php if($objResult['que_ckk'] =='1'){ ?>
	<input type="checkbox" name="que_ckk" checked='checked' value="1"> &nbsp; <font color='red'>งานด่วน</font> &nbsp;&nbsp;
<?php }else{
?>
	<input type="checkbox" name="que_ckk" value="1"> &nbsp; <font color='red'>งานด่วน</font> &nbsp;&nbsp;
	<?php } ?>

	<?php if($objResult['doc_no'] !=''){ 
}else{ 
	?><input type="checkbox" name="run_et" value="1"> &nbsp;Run เลขที่เอกสาร ET  &nbsp;&nbsp;
	<input type="checkbox" name="run_id" value="1"> &nbsp;Run เลขที่เอกสาร IE &nbsp;&nbsp;
	
	
	<?php } ?>
	<?php if($objResult['et_ckk'] =='1'){ ?>
	<input type="checkbox" name="et_ckk" checked='checked' value="1"> &nbsp; ต้องการใบกำกับภาษี E-Tax &nbsp;&nbsp;
<?php }else{
?>
	<input type="checkbox" name="et_ckk" value="1"> &nbsp; ต้องการใบกำกับภาษี E-Tax &nbsp;&nbsp;
	<?php } ?></p>
	เลขที่เอกสาร <input name="doc_no" class="w3-input" value="<?php echo $objResult['doc_no']; ?>"  type="text" style="width:90%;" readonly>
	
	วันที่ออกเอกสาร <input name="doc_release_date" class="w3-input" value="<?php echo $objResult['doc_release_date']; ?>" type="date" style="width:90%;" readonly>
	
<input name="doc_time" class="w3-input" value="<?php echo $objResult['doc_time']; ?>" type="hidden">	
<input name="admin_name" class="w3-input" value="<?php echo $objResult['admin_name']; ?>" type="hidden">				
	
รหัสลูกค้า
<input type='text' name = "bill_id"  id = "bill_id" value="<?php echo $objResult['bill_id']; ?>"  class="w3-input" placeholder="Search ชื่อลูกค้า..."   OnChange="JavaScript:doCallAjax1('bill_id','billing_name','billing_address','billing_tel','tax_id','ex_add','ex_aumper','ex_provin','ex_post','pre_name','customer_name','address1','address2','province','postcode','tel','delivery_contact','delivery_place','email','customer_typename');" required> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>	
	

	
<?php

$sql55 = "SELECT status_cus,customer_no  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
$qry55 = mysqli_query($conn,$sql55) or die(mysqli_error());
$rs55 = mysqli_fetch_assoc($qry55);	
	

 if($rs55["customer_no"] !=''){
 if($rs55["status_cus"]=='0'){
$status_cus="Gold Customer";
 }else if($rs55["status_cus"]=='1'){ 
$status_cus="Platinum Customer";
}else if($rs55["status_cus"]=='2'){ 
$status_cus="Daimond Customer";

}									 
}
	
	
if($rs55["customer_no"] !=''){	
	?>	

สถานะลูกค้า	
<?php if($rs55["status_cus"]=='0'){ ?>	
<input name="status_cus" id="status_cus" value="<?php echo "รหัสสมาชิก : "; echo $rs55["customer_no"];?> (<? echo $status_cus; ?>)" type='text' class="w3-input w3-yellow" readonly>	
<?php }else if($rs55["status_cus"]=='1'){ ?>	
<input name="status_cus" id="status_cus" value="<?php echo "รหัสสมาชิก : "; echo $rs55["customer_no"];?> (<? echo $status_cus; ?>)" type='text' class="w3-input w3-light-green" >		
<?php }if($rs55["status_cus"]=='2'){ ?>		
<input name="status_cus" id="status_cus" value="<?php echo "รหัสสมาชิก : "; echo $rs55["customer_no"];?> (<? echo $status_cus; ?>)" type='text' class="w3-input w3-green" >	
<?php 
	}
	} ?>	
	
คำนำหน้าชื่อ:
<input name="pre_name" id="pre_name" value="<?php echo $objResult['pre_name']; ?>" type='text' class="w3-input" >	

ชื่อที่ออกบิล
<input name="billing_name" id = "billing_name" type='text' value="<?php echo $objResult['billing_name']; ?>" class="w3-input" >
ทีอยู่ที่ออกบิล
<textarea name="billing_address" id = "billing_address" class="w3-input" rows="1" ><?php echo $objResult['billing_address']; ?></textarea>
	
<div class="w3-bar">
 <input type='hidden' name="ex_add" id="ex_add" value="<?php echo $objResult['ex_add']; ?>" class="w3-input" rows="1" >
			</div>
			<div class="w3-bar">
				 <input type='hidden' name="ex_aumper" id="ex_aumper" value="<?php echo $objResult['ex_aumper']; ?>"  class="w3-input" rows="1" >
			</div>
			<div class="w3-bar">
				<input type='hidden' name="ex_provin" id="ex_provin" value="<?php echo $objResult['ex_provin']; ?>" class="w3-input" rows="1" >
			</div>
			<div class="w3-bar">
				 <input type='hidden' name="ex_post" id="ex_post" value="<?php echo $objResult['ex_post']; ?>" class="w3-input" rows="1" >
			</div>	
<div class="w3-half">	
E-Mail
<input name="email" id="email" type='text' value="<?php echo $objResult['email']; ?>" class="w3-input" >
</div>
<div class="w3-bar w3-half w3-container">	
เลขที่ลงงาน
<input name="job_id" id="job_id" type='text' value="<?php echo $objResult['job_id']; ?>" class="w3-input" >	
</div>	
<div class="w3-half">
Tel.
<input type="text" name="billing_tel" id ="billing_tel" value="<?php echo $objResult['billing_tel']; ?>" class="w3-input" >
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
<input type="text" name="tax_id" id = "tax_id" value="<?php echo $objResult['tax_id']; ?>" class="w3-input" >
</div>
<div class="w3-bar"><?php /*การชำระเงิน
<input name="payment1" type='text' class="w3-input" id="payment1"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน..."> 


<select name="payment" class="w3-select" disabled>
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
<input name="customer_name" id="customer_name" type="text" value="<?php echo $objResult['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="address1" id="address1" class="w3-input" value="<?php echo $objResult['address1']; ?>" type="text">
<input name="address2" id="address2" class="w3-input" value="<?php echo $objResult['address2']; ?>" type="text">
จังหวัด
<select name="province" id="province" class="w3-select" >
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
<input name="postcode" id="postcode" type="text" value="<?php echo $objResult["postcode"]; ?>" class="w3-input">
โทรศัพท์
<input name="tel" id="tel" type="text" value="<?php echo $objResult["tel"]; ?>" class="w3-input">
<div class="w3-margin-bottom"></div>
	
<b>หมายเหตุแจ้งแผนกที่เกี่ยวข้อง</b>	
<br><br>	
จัดส่ง :
<textarea name="comment_cs"  class="w3-input" style="width:90%" id="comment_cs"  rows="2"><?php echo $rs26["comment_cs"]; ?></textarea>	
	
ช่าง :
<textarea name="comment_en"  class="w3-input" style="width:90%" id="comment_en"  rows="2"><?php echo $rs26["comment_en"]; ?></textarea>	
	
คลังสินค้า :
<textarea name="comment_st"  class="w3-input" style="width:90%" id="comment_st"  rows="2"><?php echo $rs26["comment_st"]; ?></textarea>	
	
Admin :
<textarea name="comment_ad"  class="w3-input" style="width:90%" id="comment_ad"  rows="2"><?php echo $rs26["comment_ad"]; ?></textarea>	
	<br>	
	
</div><!-- close so second half -->
</div><!-- close so -->

<div id="so1" class="w3-container city" style="display:none">
	<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 2</b><br/><!-- so1 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex1customer_name" type="text" value="<?php echo $objResult12['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex1address1" class="w3-input"  type="text" value="<?php echo $objResult12['address1']; ?>">
<input name="ex2address1" class="w3-input"  type="text" value="<?php echo $objResult12['address2']; ?>">

จังหวัด
<select name="ex1province" class="w3-select">
				<option class="w3-bar" value=""></option>
<?php
			$province="select * from tb_province order by province_name";
			$prosql=mysqli_query($conn,$province);
				while ($fepro=mysqli_fetch_array($prosql)) {
					if($objResult12["province"] == $fepro["province_name"]){
						$sel = "selected";
						} else {
						$sel = "";
					}
?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

รหัสไปรษณีย์
<input name="ex1postcode" type="text" value="<?php echo $objResult12["postcode"];?>"  class="w3-input">
โทรศัพท์
<input name="ex1tel" type="text" value="<?php echo $objResult12["tel"];?>"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so1 second half -->
</div><!-- close so1  -->

<div id="so2" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 3</b><br/><!-- so2 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex2customer_name" type="text" value="<?php echo $objResult13['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex2address1" class="w3-input"  type="text" value="<?php echo $objResult13['address1'];?>">
<input name="ex2address2" class="w3-input"  type="text" value="<?php echo $objResult13['address2'];?>">
จังหวัด
			<select name="ex2province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult13["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>

รหัสไปรษณีย์
<input name="ex2postcode" type="text" value="<?php echo $objResult13["postcode"];?>"  class="w3-input">
โทรศัพท์
<input name="ex2tel" type="text" value="<?php echo $objResult13["tel"];?>" class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so2 second half -->
</div><!-- close so2  -->

<div id="so3" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 4</b><br/><!-- so3 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex3customer_name" type="text" value="<?php echo $objResult14['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex3address1" class="w3-input"  type="text" value="<?php echo $objResult14['address1'];?>">
<input name="ex3address2" class="w3-input"  type="text" value="<?php echo $objResult14['address2'];?>">
จังหวัด
			<select name="ex3province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult14["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>

รหัสไปรษณีย์
<input name="ex3postcode" type="text" value="<?php echo $objResult14["postcode"];?>"  class="w3-input">
โทรศัพท์
<input name="ex3tel" type="text" value="<?php echo $objResult14["tel"];?>"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so3 second half -->
</div><!-- close so3  -->

<div id="so4" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 5</b><br/><!-- so4 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex4customer_name" type="text" value="<?php echo $objResult15['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex4address1" class="w3-input"  type="text" value="<?php echo $objResult15['address1'];?>">
<input name="ex4address2" class="w3-input"  type="text" value="<?php echo $objResult15['address2'];?>">
จังหวัด
			<select name="ex4province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult15["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>

รหัสไปรษณีย์
<input name="ex4postcode" type="text" value="<?php echo $objResult15["postcode"];?>"  class="w3-input">
โทรศัพท์
<input name="ex4tel" type="text" value="<?php echo $objResult15["tel"];?>" class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so4 second half -->
</div><!-- close so4  -->

<div id="so5" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 6</b><br/><!-- so5 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex5customer_name" type="text" value="<?php echo $objResult16['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex5address1" class="w3-input"  type="text" value="<?php echo $objResult16['address1'];?>">
<input name="ex5address2" class="w3-input"  type="text" value="<?php echo $objResult16['address2'];?>">
จังหวัด
			<select name="ex5province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult16["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>

รหัสไปรษณีย์
<input name="ex5postcode" type="text" value="<?php echo $objResult16["postcode"];?>"  class="w3-input">
โทรศัพท์
<input name="ex5tel" type="text" value="<?php echo $objResult16["tel"];?>"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so5 second half -->
</div><!-- close so5  -->

<div id="so6" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 7</b><br/><!-- so6 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex6customer_name" type="text" value="<?php echo $objResult17['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex6address1" class="w3-input"  type="text" value="<?php echo $objResult17['address1'];?>">
<input name="ex6address2" class="w3-input"  type="text" value="<?php echo $objResult17['address2'];?>">
จังหวัด
			<select name="ex6province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult17["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>

รหัสไปรษณีย์
<input name="ex6postcode" type="text" value="<?php echo $objResult17["postcode"];?>"  class="w3-input">
โทรศัพท์
<input name="ex6tel" type="text" value="<?php echo $objResult17["tel"];?>" class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so6 second half -->
</div><!-- close so6  -->

<div id="so7" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 8</b><br/><!-- so7 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex7customer_name" type="text" value="<?php echo $objResult18['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex7address1" class="w3-input"  type="text" value="<?php echo $objResult18['address1'];?>">
<input name="ex7address2" class="w3-input"  type="text" value="<?php echo $objResult18['address2'];?>">
จังหวัด
			<select name="ex7province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult18["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>

รหัสไปรษณีย์
<input name="ex7postcode" type="text" value="<?php echo $objResult18["postcode"];?>"  class="w3-input">
โทรศัพท์
<input name="ex7tel" type="text" value="<?php echo $objResult18["tel"];?>" class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so7 second half -->
</div><!-- close so7  -->

<div id="so8" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 9</b><br/><!-- so8 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex8customer_name" type="text" value="<?php echo $objResult19['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex8address1" class="w3-input"  type="text" value="<?php echo $objResult19['address1'];?>">
<input name="ex8address2" class="w3-input"  type="text" value="<?php echo $objResult19['address2'];?>">
จังหวัด
			<select name="ex8province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult19["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>

รหัสไปรษณีย์
<input name="ex8postcode" type="text" value="<?php echo $objResult19["postcode"];?>"  class="w3-input">
โทรศัพท์
<input name="ex8tel" type="text" value="<?php echo $objResult19["tel"];?>" class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so8 second half -->
</div><!-- close so8  -->

<div id="so9" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 10</b><br /><!-- so9 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex9customer_name" type="text" value="<?php echo $objResult20['customer_name']; ?>" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex9address1" class="w3-input"  type="text" value="<?php echo $objResult20['address1'];?>">
<input name="ex9address2" class="w3-input"  type="text" value="<?php echo $objResult20['address2'];?>">
จังหวัด
			<select name="ex9province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult20["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>

รหัสไปรษณีย์
<input name="ex9postcode" type="text" value="<?php echo $objResult20["postcode"];?>"  class="w3-input">
โทรศัพท์
<input name="ex9tel" type="text" value="<?php echo $objResult20["tel"];?>" class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so9 second half -->
</div><!-- close so9  -->

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

<div id="rs" class="w3-container city" style="display:none"></p>

	<?php


$strSQL27 = "SELECT * FROM tb_research WHERE red_id = '".$objResult["ref_id"]."' ";
$objQuery27 = mysqli_query($com1,$strSQL27) or die ("Error Query [".$strSQL27."]");
$objResult27 = mysqli_fetch_array($objQuery27);

	?>
	
วันที่ทำแบบสอบถาม : <input type='date'  name='date_research' value="<?php echo $objResult27["date_research"]; ?>"  id = 'date_research'  />
<input type='hidden'  name='doc_no' value="<?php echo $objResult["doc_no"]; ?>" id = 'doc_no'  />
	เลขที่ลงงาน :	<input type='text'  name='job_id' value="<?php echo $objResult["job_id"]; ?>" id = 'job_id'  /></p>

<?php if($objResult27["date_research"] >= '2025-10-01'){ ?>


<?php if($objResult27["sale_neat"] =='0' or $objResult27["sale_neat"]==''){ ?>
<span class='style39'><b>ความพึงพอใจต่อพนักงานขาย</b></span>
<table border="1" class="w3-table" width="100%">
<tr>
<td width="5%" align="center" bgcolor="#D3D3D3">ลำดับ</td>
<td width="40%" align="center" bgcolor="#D3D3D3">รายละเอียด</td> 
<td width="5%" align="center" bgcolor="#D3D3D3">5</td>
<td width="5%" align="center" bgcolor="#D3D3D3">4</td>
<td width="5%" align="center" bgcolor="#D3D3D3">3</td>
<td width="5%" align="center" bgcolor="#D3D3D3">2</td>
<td width="5%" align="center" bgcolor="#D3D3D3">1</td>	
</tr>
<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พนักงานพูดจาสุภาพ มีมารยาท และแต่งกายเหมาะสม</span>
</div></td>

<td align="center"><div align="center">
<?php if($objResult27["sale_neat"]=='5'){ ?>

<input type='radio'  name='sale_neat' id = 'sale_neat' value='5' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["sale_neat"]=='4'){ ?>

<input type='radio'  name='sale_neat' id = 'sale_neat' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat' value='4' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["sale_neat"]=='3'){ ?>

<input type='radio'  name='sale_neat' id = 'sale_neat' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat' value='3' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["sale_neat"]=='2'){ ?>

<input type='radio'  name='sale_neat' id = 'sale_neat' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat' value='2' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["sale_neat"]=='1'){ ?>

<input type='radio'  name='sale_neat' id = 'sale_neat' value='1' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat' value='1' />

<?php } ?>
</div></td>
</tr>
	
<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>มีความรู้ความเข้าใจเกี่ยวกับสินค้า ให้คำแนะนำได้ชัดเจน</span>
</div></td>

<td align="center"><div align="center">
<?php if($objResult27["sale_data"]=='5'){ ?>

<input type='radio'  name='sale_data' id = 'sale_data' value='5' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_data' id = 'sale_data' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["sale_data"]=='4'){ ?>

<input type='radio'  name='sale_data' id = 'sale_data' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_data' id = 'sale_data' value='4' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["sale_data"]=='3'){ ?>

<input type='radio'  name='sale_data' id = 'sale_data' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_data' id = 'sale_data' value='3' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["sale_data"]=='2'){ ?>

<input type='radio'  name='sale_data' id = 'sale_data' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_data' id = 'sale_data' value='2' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["sale_data"]=='1'){ ?>

<input type='radio'  name='sale_data' id = 'sale_data' value='1' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_data' id = 'sale_data' value='1' />

<?php } ?>
</div></td>
</tr>	
	
	
<tr>
<td align="center"><div align="center">
<span class='style39'>3</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>แสดงความใส่ใจ ติดตามผล และให้ความช่วยเหลือหลังการขาย</span>
</div></td>

<td align="center"><div align="center">
<?php if($objResult27["sale_3"]=='5'){ ?>

<input type='radio'  name='sale_3' id = 'sale_3' value='5' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_3' id = 'sale_3' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["sale_3"]=='4'){ ?>

<input type='radio'  name='sale_3' id = 'sale_3' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_3' id = 'sale_3' value='4' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["sale_3"]=='3'){ ?>

<input type='radio'  name='sale_3' id = 'sale_3' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_3' id = 'sale_3' value='3' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["sale_3"]=='2'){ ?>

<input type='radio'  name='sale_3' id = 'sale_3' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_3' id = 'sale_3' value='2' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["sale_3"]=='1'){ ?>

<input type='radio'  name='sale_3' id = 'sale_3' value='1' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='sale_3' id = 'sale_3' value='1' />

<?php } ?>
</div></td>
</tr>	
		
	
</table>	

</p>
ข้อเสนอแนะอื่นๆ 
<textarea name="suggest"  class="w3-input" id="suggest"  rows="2"><?php echo $objResult27["suggest"]; ?></textarea>
</p>

<?php } ?>


<span class='style39'><b>ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์</b></span>
<table border="1" class="w3-table" width="100%">
<tr>
<td width="5%" align="center" bgcolor="#D3D3D3">ลำดับ</td>
<td width="40%" align="center" bgcolor="#D3D3D3">รายละเอียด</td> 
<td width="5%" align="center" bgcolor="#D3D3D3">5</td>
<td width="5%" align="center" bgcolor="#D3D3D3">4</td>
<td width="5%" align="center" bgcolor="#D3D3D3">3</td>
<td width="5%" align="center" bgcolor="#D3D3D3">2</td>
<td width="5%" align="center" bgcolor="#D3D3D3">1</td>	
</tr>
	
<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>สินค้าตรงตามข้อมูลที่ได้รับก่อนซื้อ และสามารถใช้งานได้จริง</span>
</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='5'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='5' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='4'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='4' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='3'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='3' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='2'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='2' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='1'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='1' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='1' />

<?php } ?>
</div></td>
</tr>
	
<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>คุณภาพสินค้าตรงตามที่คาดหวัง</span>
</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='5'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='5' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='4'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='4' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='3'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='3' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='2'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='2' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='1'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='1' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='1' />

<?php } ?>
</div></td>
</tr>	
	
	
<tr>
<td align="center"><div align="center">
<span class='style39'>3</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>ความพึงพอใจในสินค้าโดยรวมที่มีต่อผลิตภัณฑ์ที่ได้รับ</span>
</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='5'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='5' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='4'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='4' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='3'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='3' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='2'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='2' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='1'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='1' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='1' />

<?php } ?>
</div></td>
</tr>		
	
	

</table>	
</p>
ข้อเสนอแนะอื่นๆ 
<textarea name="suggest_1"  class="w3-input" id="suggest_1"  rows="2"><?php echo $objResult27["suggest_1"]; ?></textarea>
</p>

<?php if($objResult27["cs_neat"] =='0' or $objResult27["cs_neat"]==''){ ?>
<span class='style39'><b>ความพึงพอใจต่อบริการจัดส่ง</b></span>
<table border="1" class="w3-table" width="100%">
<tr>
<td width="5%" align="center" bgcolor="#D3D3D3">ลำดับ</td>
<td width="40%" align="center" bgcolor="#D3D3D3">รายละเอียด</td> 
<td width="5%" align="center" bgcolor="#D3D3D3">5</td>
<td width="5%" align="center" bgcolor="#D3D3D3">4</td>
<td width="5%" align="center" bgcolor="#D3D3D3">3</td>
<td width="5%" align="center" bgcolor="#D3D3D3">2</td>
<td width="5%" align="center" bgcolor="#D3D3D3">1</td>	
</tr>

	
<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พนักงานจัดส่งสุภาพ แต่งกายเหมาะสม และปฏิบัติตามมาตรการความปลอดภัย</span>
</div></td>

<td align="center"><div align="center">
<?php if($objResult27["cs_neat"]=='5'){ ?>

<input type='radio'  name='cs_neat' id = 'cs_neat' value='5' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_neat' id = 'cs_neat' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["cs_neat"]=='4'){ ?>

<input type='radio'  name='cs_neat' id = 'cs_neat' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_neat' id = 'cs_neat' value='4' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["cs_neat"]=='3'){ ?>

<input type='radio'  name='cs_neat' id = 'cs_neat' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_neat' id = 'cs_neat' value='3' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["cs_neat"]=='2'){ ?>

<input type='radio'  name='cs_neat' id = 'cs_neat' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_neat' id = 'cs_neat' value='2' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["cs_neat"]=='1'){ ?>

<input type='radio'  name='cs_neat' id = 'cs_neat' value='1' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_neat' id = 'cs_neat' value='1' />

<?php } ?>
</div></td>
</tr>
	
<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>จัดส่งตรงเวลา พร้อมบริการติดตั้ง/สาธิตการใช้งานสินค้า</span>
</div></td>

<td align="center"><div align="center">
<?php if($objResult27["cs_explain"]=='5'){ ?>

<input type='radio'  name='cs_explain' id = 'cs_explain' value='5' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_explain' id = 'cs_explain' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["cs_explain"]=='4'){ ?>

<input type='radio'  name='cs_explain' id = 'cs_explain' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_explain' id = 'cs_explain' value='4' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["cs_explain"]=='3'){ ?>

<input type='radio'  name='cs_explain' id = 'cs_explain' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_explain' id = 'cs_explain' value='3' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["cs_explain"]=='2'){ ?>

<input type='radio'  name='cs_explain' id = 'cs_explain' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_explain' id = 'cs_explain' value='2' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='1'){ ?>

<input type='radio'  name='cs_explain' id = 'cs_explain' value='1' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_explain' id = 'cs_explain' value='1' />

<?php } ?>
</div></td>
</tr>	
	
	
<tr>
<td align="center"><div align="center">
<span class='style39'>3</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>ประสานงานก่อนส่ง และดูแลจนถึงการส่งมอบเรียบร้อย</span>
</div></td>

<td align="center"><div align="center">
<?php if($objResult27["cs_3"]=='5'){ ?>

<input type='radio'  name='cs_3' id = 'cs_3' value='5' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_3' id = 'cs_3' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["cs_3"]=='4'){ ?>

<input type='radio'  name='cs_3' id = 'cs_3' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_3' id = 'cs_3' value='4' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["cs_3"]=='3'){ ?>

<input type='radio'  name='cs_3' id = 'cs_3' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_3' id = 'cs_3' value='3' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["cs_3"]=='2'){ ?>

<input type='radio'  name='cs_3' id = 'cs_3' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_3' id = 'cs_3' value='2' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["cs_3"]=='1'){ ?>

<input type='radio'  name='cs_3' id = 'cs_3' value='1' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='cs_3' id = 'cs_3' value='1' />

<?php } ?>
</div></td>
</tr>		
		
</table>	
</p>
ข้อเสนอแนะอื่นๆ 
<textarea name="suggest_2"  class="w3-input" id="suggest_2"  rows="2"><?php echo $objResult27["suggest_2"]; ?></textarea>
</p>
<?php } ?>

<?php }else{ ?>

 <table border="1" class="w3-table" width="100%">
<tr>
<td width="5%" align="center" bgcolor="#D3D3D3">ลำดับ</td>
<td width="40%" align="center" bgcolor="#D3D3D3">รายละเอียด</td> 
<td width="5%" align="center" bgcolor="#D3D3D3">10</td>
<td width="5%" align="center" bgcolor="#D3D3D3">9</td>
<td width="5%" align="center" bgcolor="#D3D3D3">8</td>
<td width="5%" align="center" bgcolor="#D3D3D3">7</td>
<td width="5%" align="center" bgcolor="#D3D3D3">6</td>
<td width="5%" align="center" bgcolor="#D3D3D3">5</td>
<td width="5%" align="center" bgcolor="#D3D3D3">4</td>
<td width="5%" align="center" bgcolor="#D3D3D3">3</td>
<td width="5%" align="center" bgcolor="#D3D3D3">2</td>
<td width="5%" align="center" bgcolor="#D3D3D3">1</td>	

</tr>
<tr>
<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>

<td align="left" bgcolor="#B0C4DE"><div align="left">
<span class='style39'>ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์</span>
</div></td>

<td align="center" bgcolor="#B0C4DE"><div align="center"></div></td>
<td align="center" bgcolor="#B0C4DE"><div align="center"></div></td>
<td align="center" bgcolor="#B0C4DE"><div align="center"></div></td>
<td align="center" bgcolor="#B0C4DE"><div align="center"></div></td>
<td align="center" bgcolor="#B0C4DE"><div align="center"></div></td>
<td align="center" bgcolor="#B0C4DE"><div align="center"></div></td>
<td align="center" bgcolor="#B0C4DE"><div align="center"></div></td>
<td align="center" bgcolor="#B0C4DE"><div align="center"></div></td>
<td align="center" bgcolor="#B0C4DE"><div align="center"></div></td>
<td align="center" bgcolor="#B0C4DE"><div align="center"></div></td>


</tr>


<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>สินค้าจริงตรงกับข้อมูลที่บริษัทให้ก่อนสั่งซื้อ และสามารถใช้งานได้อย่างมีประสิทธิภาพ</span>
</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='10'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='10' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='10' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='9'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='9' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='9' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='8'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='8' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='8' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='7'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='7' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='7' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='6'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='6' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='6' />

<?php } ?>
</div></td>	
	
<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='5'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='5' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='4'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='4' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='3'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='3' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='2'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='2' />

<?php } ?>
</div></td>
<td align="center"><div align="center">
<?php if($objResult27["product_good"]=='1'){ ?>

<input type='radio'  name='product_good' id = 'product_good' value='1' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_good' id = 'product_good' value='1' />

<?php } ?>
</div></td>
</tr>
<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>ระดับคุณภาพสินค้าเมื่อเทียบกับบริษัทอื่นๆ</span>
</div></td>
	
<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='10'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='10' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_link' id = 'product_link' value='10' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='9'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='9' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='9' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='8'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='8' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='8' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='7'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='7' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='7' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='6'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='6' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_link' id = 'product_link' value='6' />

<?php } ?>
</div></td>
	
	

<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='5'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='5' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_link' id = 'product_link' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='4'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='4' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='3'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='3' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='2'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_link' id = 'product_link' value='2' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_link"]=='1'){ ?>

<input type='radio'  name='product_link' id = 'product_link' value='1' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_link' id = 'product_link' value='1' />

<?php } ?>
</div></td>


</tr>




<tr>
<td align="center"><div align="center">
<span class='style39'>3</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>ความพึงพอใจในสินค้าโดยรวม</span>
</div></td>
	
<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='10'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='10' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='10' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='9'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='9' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='9' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='8'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='8' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='8' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='7'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='7' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='7' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='6'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='6' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='6' />

<?php } ?>
</div></td>
	
	

<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='5'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='5' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='4'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='4' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='3'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='3' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='2'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_corect' id = 'product_corect' value='2' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_corect"]=='1'){ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='1' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_corect' id = 'product_corect' value='1' />

<?php } ?>
</div></td>


</tr>
	 
<tr>
<td align="center"><div align="center">
<span class='style39'>4</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>มีแนวโน้มที่จะแนะนำให้เพื่อน หรือคนรู้จักมาใช้บริการของ ALLWELL มากน้อยเพียงใด</span>
</div></td>
	
<td align="center"><div align="center">
<?php if($objResult27["product_3"]=='10'){ ?>

<input type='radio'  name='product_3' id = 'product_3' value='10' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_3' id = 'product_3' value='10' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_3"]=='9'){ ?>

<input type='radio'  name='product_3' id = 'product_3' value='9' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_3' id = 'product_3' value='9' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_3"]=='8'){ ?>

<input type='radio'  name='product_3' id = 'product_3' value='8' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_3' id = 'product_3' value='8' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_3"]=='7'){ ?>

<input type='radio'  name='product_3' id = 'product_3' value='7' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_3' id = 'product_3' value='7' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_3"]=='6'){ ?>

<input type='radio'  name='product_3' id = 'product_3' value='6' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_3' id = 'product_3' value='6' />

<?php } ?>
</div></td>
	
	

<td align="center"><div align="center">
<?php if($objResult27["product_3"]=='5'){ ?>

<input type='radio'  name='product_3' id = 'product_3' value='5' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_3' id = 'product_3' value='5' />

<?php } ?>

</div></td>

<td align="center"><div align="center">
<?php if($objResult27["product_3"]=='4'){ ?>

<input type='radio'  name='product_3' id = 'product_3' value='4' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_3' id = 'product_3' value='4' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_3"]=='3'){ ?>

<input type='radio'  name='product_3' id = 'product_3' value='3' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_3' id = 'product_3' value='3' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_3"]=='2'){ ?>

<input type='radio'  name='product_3' id = 'product_3' value='2' checked='checked'/>
<?php }else{ ?>
<input type='radio'  name='product_3' id = 'product_3' value='2' />

<?php } ?>

</div></td>


<td align="center"><div align="center">
<?php if($objResult27["product_3"]=='1'){ ?>

<input type='radio'  name='product_3' id = 'product_3' value='1' checked='checked'/>
<?php }else{ ?>

<input type='radio'  name='product_3' id = 'product_3' value='1' />

<?php } ?>
</div></td>


</tr>



</table>

</p>
ข้อเสนอแนะอื่นๆ 
<textarea name="suggest_1"  class="w3-input" id="suggest_1"  rows="2"><?php echo $objResult27["suggest_1"]; ?></textarea>
</p>
<?php } ?>
</div>

<div id="mo" class="city" style="display:none">
<div class="w3-padding-small"></div>
<div class="w3-container w3-third"><!--first third -->
ชื่อผู้แนะนำ
<input name="prefer_name" value="<?php echo $objResult["prefer_name"]; ?>" class="w3-input" >
ใบสั่งซื้อเลขที่
<input name="po_no" class="w3-input" value="<?php echo $objResult["po_no"]; ?>">
กำหนดส่งตามสัญญา
<input name="delivery_contract" id="delivery_contract" type='date' value="<?php echo $objResult["delivery_contract"]; ?>" class="w3-input" >

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

 แนบใบเสนอราคา
เลขที่
<input name="pr_no" value="<?php echo $objResult["pr_no"]; ?>" class="w3-input" >

<br />
<div class="w3-padding-small"></div>
หมายเลขคำสั่งซื้อ:
<input name="order_id" id="order_id" value="<?php echo $objResult["order_id"]; ?>"  class="w3-input" >

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
</div>


<div id="pd" class="w3-container city1">

<?php 

$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


?>

<table width="100%" border="0" class="w3-table">

<tr>
    <td align="center"><b>รหัสสินค้า</b></td>
    <td align="center"><b>ชื่อสินค้า</b></td>
    <td align="center"><b>หน่วย</b></td>
    <td align="center"><b>จำนวน</b></td>
    <td align="center"><b>ราคาต่อหน่วย</b></td>
	<td align="center"><b>ส่วนลด/หน่วย</b></td>
    <td align="center"><b>ยอดรวม</b></td>
	 <td align="center"><b>รับประกัน (ปี</b></td>
	 <td align="center"><b>Cal (ครั้ง/ปี)</b></td>
	 <td align="center"><b>PM (ครั้ง/ปี)</b></td>
    <td align="center"><b>หมายเหตุ</b></td>
	<td align="center"><b>หมายเลขเครื่อง</b></td>
<td align="center"><b>เคลียร์ยืม</b></td>
	<td align="center"><b>เคลียร์จอง</b></td>
</tr>
<?php
$i = 1;


while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
$strSQL12 ="SELECT research_ckk FROM tb_product WHERE product_ID = '".$objResult1['product_id']."' ";
$objQuery12 =mysqli_query($conn,$strSQL12);
$objResult12=mysqli_fetch_array($objQuery12);

if($objResult12["research_ckk"]=='1'){	
	
	
$strSQL6 = "Update   tb_register_data set mk_research='1'   Where ref_id= '".$objResult["ref_id"]."' ";
$objQuery6 = mysqli_query($conn,$strSQL6);		
}		
	
	
?>

<tr>

<td style="width:15%;">
<input type='hidden' name = "id[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["id"];?>" id = "id[<?php echo $objResult1["id"];?>]"    size='16' readonly/>
<input type='hidden' name = "product_id[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["product_id"];?>" id = "product_id[<?php echo $objResult1["id"];?>]"    size='16' readonly/>
 <input type='text' name = "product_code[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["sol_code"];?>" id = "product_code[<?php echo $objResult1["id"];?>]"  class="w3-input"    size='16' readonly/>  


</td>


<td style="width:15%;"><teaxarea name = "product_name[<?php echo $objResult1["id"];?>]" id = "product_name[<?php echo $objResult1["id"];?>]" style="color:black;text-align:left" class="w3-input" readonly><?php echo $objResult1["sol_name"];?></teaxarea></td>	
	
	

<td><input type='text' name = "unit_name[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[<?php echo $objResult1["id"];?>]"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:center"   size='7' /></td>

<td><input type='text' name = "product_price[<?php echo $objResult1["id"];?>]" value="<?php $price_per_unit= $objResult1["price_per_unit"]; echo number_format( $price_per_unit,2)."";?>" id = "product_price[<?php echo $objResult1["id"];?>]"  class="w3-input"  style="color:black;text-align:right"   /></td>

<td><input type='text' name = "discount_unit[<?php echo $objResult1["id"];?>]" value="<?php $discount_unit= $objResult1["discount_unit"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[<?php echo $objResult1["id"];?>]"  class="w3-input"  style="color:black;text-align:right"   /></td>


<td><input type='text' name = "sum_amount[<?php echo $objResult1["id"];?>]" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>" id = "sum_amount[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:right"    readonly/></td>


<td><input type='text' name = "warranty[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["war_hc"];?> <?php echo $objResult1["unit_hc"];?>" id = "warranty[<?php echo $objResult1["id"];?>]"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["cal"];?>" id = "cal[<?php echo $objResult1["id"];?>]"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "pm[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["pm"];?>" id = "pm[<?php echo $objResult1["id"];?>]"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>


<td style="width:10%;"><input type='text' name = "sale_remarkk[<?php echo $objResult1["id"];?>]" id = "sale_remarkk[<?php echo $objResult1["id"];?>]" value = "<?php echo $objResult1["sale_remark"];?>"  class="w3-input" ></td>	

<td style="width:8%;">
	<textarea name = "sn_number[<?php echo $objResult1["id"];?>]"  id = "sn_number[<?php echo $objResult1["id"];?>]"  class="w3-input"  placeholder="หมายเลขเครื่อง"  ><?php echo $objResult1["sn_number"];?></textarea>
</td>
	
<td style="width:8%;">
	
		
<?php if($objResult1["clear_br"]=='1'){ ?>
	<input type='checkbox' name = "clear_br[<?php echo $objResult1["id"];?>]" checked='checked' value="1" id = "clear_br[<?php echo $objResult1["id"];?>]" >
	<?php }else{ ?>
	<input type='checkbox' name = "clear_br[<?php echo $objResult1["id"];?>]" value="1" id = "clear_br[<?php echo $objResult1["id"];?>]" >
	<?php } ?>

<input type='text' name = "clear_ivno[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["clear_ivno"];?>" id = "clear_ivno[<?php echo $objResult1["id"];?>]" placeholder="เลขที่ใบยืม"  class="w3-input"  />
</td>
<td style="width:8%;">
	
		
<?php if($objResult1["jong_ckk"]=='1'){ ?>
	<input type='checkbox' name = "jong_ckk[<?php echo $objResult1["id"];?>]" checked='checked' value="1" id = "jong_ckk[<?php echo $objResult1["id"];?>]" >
	<?php }else{ ?>
	<input type='checkbox' name = "jong_ckk[<?php echo $objResult1["id"];?>]" value="1" id = "jong_ckk[<?php echo $objResult1["id"];?>]" >
	<?php } ?>

<input type='text' name = "jong_no[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["jong_no"];?>" id = "jong_no[<?php echo $objResult1["id"];?>]" placeholder="เลขที่ใบจอง"  class="w3-input"  />
</td>	
<?php if($objResult["approve_complete"]!='Approve'){ ?>	
<td><a href="product_allwel_del.php?ref_id=<?php echo $objResult["ref_id"];?>&id=<?php echo $objResult1["id"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a></td>
<?php } ?>

</tr>

<?
	$i++;

}

?>

</table>
<?php
if($objResult["approve_complete"]!='Approve'){
	if ($objResult["select_type_doc"]=='3'){
include ('data_product_allwell.php');
	}else if ($objResult["select_type_doc"]=='4'){
include ('data_product_allwellnb.php');		
	}
	}
	?>

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

<?php

		if($objResult["delivery_type"]=='1'){
			?>
<input type="radio" name="delivery_type" checked='checked' value="1" onclick="javascript:ckk_2();" id="object8" >Sale รับเอง
<input type="radio" name="delivery_type" value="2" onclick="javascript:ckk_2();" id="object9" >ช่างรับเอง<br/>
<input type="radio" name="delivery_type" value="3" onclick="javascript:ckk_2();" id="object10" >ลูกค้ารับเอง 
<input type="radio" name="delivery_type"  value="4" onclick="javascript:ckk_2();" id="object11" >บริษัทจัดส่ง <br />

<?php
		}else if($objResult["delivery_type"]=='2'){
	?>
<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8">Sale รับเอง
<input type="radio" name="delivery_type" checked='checked' value="2" onclick="javascript:ckk_2();" id="object9">ช่างรับเอง<br/>
<input type="radio" name="delivery_type" value="3" onclick="javascript:ckk_2();" id="object10" >ลูกค้ารับเอง 
<input type="radio" name="delivery_type"  value="4" onclick="javascript:ckk_2();" id="object11" >บริษัทจัดส่ง <br/>


		<?php
}else if($objResult["delivery_type"]=='3'){
		
			?>
	<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8" >Sale รับเอง
	<input type="radio" name="delivery_type" value="2" onclick="javascript:ckk_2();" id="object9" >ช่างรับเอง<br/>
    <input type="radio" name="delivery_type" checked='checked' value="3" onclick="javascript:ckk_2();" id="object10" >ลูกค้ารับเอง 
	<input type="radio" name="delivery_type"  value="4" onclick="javascript:ckk_2();" id="object11" >บริษัทจัดส่ง <br/>


<?php
		}else if($objResult["delivery_type"]=='4'){
		?>

	<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8" >Sale รับเอง
	<input type="radio" name="delivery_type" value="2" onclick="javascript:ckk_2();" id="object9" >ช่างรับเอง<br />
    <input type="radio" name="delivery_type"  value="3" onclick="javascript:ckk_2();" id="object10" >ลูกค้ารับเอง 
	<input type="radio" name="delivery_type" checked='checked' value="4" onclick="javascript:ckk_2();" id="object11" >บริษัทจัดส่ง <br />

			<?php
}else {
			?>
	<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8" >Sale รับเอง
	<input type="radio" name="delivery_type" value="2" onclick="javascript:ckk_2();" id="object9" >ช่างรับเอง<br />
    <input type="radio" name="delivery_type"  value="3" onclick="javascript:ckk_2();" id="object10" >ลูกค้ารับเอง 
	<input type="radio" name="delivery_type"  value="4" onclick="javascript:ckk_2();" id="object11" >บริษัทจัดส่ง <br />

				<?php
			}
				?>
	

<?php	if($fetch1["bus_inter"]=='1'){	?>
	<input type="checkbox" name="bus_inter"  value="4" checked ='checked' id="bus_inter" >ขนส่งอินเตอร์ <br />
	<?php }else{ ?>
	<input type="checkbox" name="bus_inter"  value="4"  id="bus_inter" >ขนส่งอินเตอร์ <br />
	<?php } ?>


<?php 
if ($objResult["delivery_type"]=='1' or $objResult["delivery_type"]=='2' or $objResult["delivery_type"]=='3'){
?>


<div class="w3-quarter"><!-- first third-->
<input type="checkbox" name="" hidden><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >
การส่งสินค้า<br>
		<?php
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
<?php
}
	?>

</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second third-->

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

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม ALL</font></a>&nbsp;&nbsp;
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
		
<a href="report_saleptl1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย ALL</font></button></a><br />

<?php
}else{
?>

<div id="dt3" style="display:none">

<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
		
<a href="report_saleptl1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></button></a><br />

</div>
<?php
}
if ($objResult["select_type_doc"]=='4'){

?>
	<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
<?php
}else{
	?>
	<div id="dt4" style="display:none">

		
<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
</div>
<?php
}
?>

</div></div><!-- forth quarter -->

<?php } ?>

<?php 

			


if ($objResult["delivery_type"]=='4'){
?>


<div class="w3-quarter"><!-- first third-->
<input type="checkbox" name="" hidden><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >


</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second third-->

สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="2" style="width:100%;resize: none" ><?php echo $objResult["delivery_place"] ; ?></textarea>
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
		
<a href="report_saleptl1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></a><br />

<?php
}else{
?>

<div id="dt3" style="display:none">

<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
		
<a href="report_saleptl1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></a><br />

</div>
<?php
}
if ($objResult["select_type_doc"]=='4'){

?>
	<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
<?php
}else{
	?>
	<div id="dt4" style="display:none">

		
<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
</div>
<?php
}
?>

</div>


<div class="w3-container w3-third">
	<?php if ($objResult["send_cs"]=='2'){ ?>
<input type="checkbox" name="send_cs" checked="checked" value="2">&nbsp;ส่งข้อมูลไประบบลงงาน 
	<?php }else{ ?>
	<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไประบบลงงาน 
	<?php } ?>
	
	</div>
<div class="w3-container w3-third">
	<?php if ($fetch1["mk_research"]=='1'){ ?>
<input type="checkbox" name="mk_research" checked='checked' value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span>  
	<?php }else{ ?>
<input type="checkbox" name="mk_research"  value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span> 	
	<?php } ?>
	</div>
<div class="w3-container w3-third">
.
	</div>
	<div class="w3-container w3-third">
 วันที่ รับ-ส่ง :
      <input name="start_date" type='date' id="start_date" value="<?php echo $fetch1["start_date"]; ?>"  class="w3-input"  />

	</div><div class="w3-container w3-third">

วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="w3-input" value="<?php echo $fetch1["between_date"]; ?>" type='text' id="between_date"  />
 </div><div class="w3-container w3-third">

 เวลา :
<input id="start_time"  name="start_time" value="<?php echo $fetch1["start_time"]; ?>" class="w3-input" type="text" />
ถึง
<input id="end_time" name="end_time"  value="<?php echo $fetch1["end_time"]; ?>" class="w3-input" type="text" />

</div><div class="w3-container w3-third">


สถานะการทำงาน : 

<?php if($fetch1["status"]=='ส่ง'){ ?>

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

<?php }else if($fetch1["status"]=='รับ'){ ?>

<input type='radio'  name='status' id = 'status' value='ส่ง' />ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' checked='checked'/>รับ

<?php } ?>

</div><div class="w3-container w3-third">

สถานะ :
      <input name="status_comment" type='text' id="status_comment" value="<?php echo $fetch1["status_comment"]; ?>" size="20" class="w3-input"/>
</div><div class="w3-container w3-third">

<?php if($fetch1["fix_date"]=='1'){ ?>

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" checked='checked' value="1">นัดวันและเวลาเรียบร้อยแล้ว 
<?php }else { ?>
<input type="checkbox"  name="fix_datetime" id = "fix_datetime"  value="1">นัดวันและเวลาเรียบร้อยแล้ว 

<?php } if($fetch1["no_price"]=='1'){ ?>

<input type="checkbox"  id = "no_money" name="no_money" checked="checked" value="1">ไม่ต้องเก็บเงิน

<?php }else { ?>
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน


<?php } ?>
</div><div class="w3-container w3-third">
<?php if($fetch1["call_customer"]=='1'){ ?>

<input type="checkbox"  id = "call_customer" name="call_customer"  checked="checked" value="1">โทรแจ้งลูกค้าก่อนไป
<?php }else { ?>
<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
	<?php } if($fetch1["call_employee"]=='1'){ ?>
	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" checked="checked" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
<?php }else { ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว


<?php } ?>
</div><div class="w3-container w3-third">
<?php if($fetch1["want_bus"]=='1'){ ?>
<input type="checkbox"   name="want_bus" checked="checked" value="1">ต้องการรถใหญ่
<?php }else{ ?>
	<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่

<?php } ?>
		</div><div class="w3-container w3-third">
	 <?php if($fetch1["cash"]=='1'){ ?>

<input type="checkbox"  name="cash"id = "cash" checked="checked" value="1">เก็บเงินสด
<?php }else { ?>
	<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด


<?php } ?>
		 <input name="unit_cash" type='text' class="w3-input" id="unit_cash" value="<?php echo $fetch1["unit_cash"]; ?>" size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		 </div><div class="w3-container w3-third">

<?php if ($fetch1["check_peper"]=='1'){ ?>

	<input type="checkbox"  name="check_peper" id = "check_peper" checked='checked' value="1">รับเช็ค

	<?php }else{ ?>
	<input type="checkbox"  name="check_peper" id = "check_peper" value="1">รับเช็ค

		<?php } ?>
	<input name="unit_check" type='text' class="w3-input" value="<?php echo $fetch1["unit_check"]; ?>"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/>
		</div><div class="w3-container w3-third">

<?php if ($fetch1["credit"]=='1'){ ?>
<input type="checkbox"  id = "credit_card" name="credit_card" checked="checked" value="1">รูดการ์ด 
<?php }else { ?>
<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด 

<?php } ?>

	<input name="unit_credit" type='text' class="w3-input"  id="unit_credit" value="<?php echo $fetch1["unit_credit"]; ?>" size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	</div><div class="w3-container w3-third">

<?php if ($fetch1["bill"]=='1'){ ?>

<input type="checkbox"  id = "bill" name="bill" checked="checked" value="1">วางบิล

<?php }else{ ?>
<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล

	<?php } ?>
<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" id="unit_bill" value="<?php echo $fetch1["unit_bill"]; ?>" size="20" OnChange="JavaScript:chkNum(this)" />
</div><div class="w3-container w3-third">

<?php if ($fetch1["tran"]=='1'){ ?>

<input type="checkbox"  name="tran"id = "tran" checked="checked" value="1">ลูกค้าโอนเงินหน้างาน
<?php }else { ?>
<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน
	<?php } ?>

		 <input name="unit_tran" type='text' class="w3-input" id="unit_tran" size="20" value="<?php echo $fetch1["unit_tran"]; ?>" style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 
</div><div class="w3-container w3-third">

<?php if ($fetch1["tran"]=='1'){ ?>

<input type="checkbox"  id = "dep" name="dep" checked="checked" value="1">อื่นๆ
<?php }else { ?>
<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ


	<?php } ?>



<input name="dept" type='text' class="w3-input"  id="dept" value="<?php echo $fetch1["dept"]; ?>" size="20"  />
</div><div class="w3-container w3-third">

แผนก - ฝ่าย :

<input name="department_show" type='text' class="w3-input"  id="department_show" value="<?php echo $fetch1["department_show"]; ?>" size="20"  />
<?php /*
<select name="department_show" id="department_show" class="w3-input"   >
<option  value="">**โปรดเลือกแผนก-ฝ่าย**</option>
<option  value="ฝ่ายการตลาด">ฝ่ายการตลาด</option>
<option  value="ฝ่ายขาย">ฝ่ายขาย</option>
<option  value="ฝ่ายสนับสนุนการขาย ธุรการ">ฝ่ายสนับสนุนการขาย ธุรการ</option>

</select>*/ ?>

</div><div class="w3-container w3-third">
       ประเภทลูกค้า :

<input name="customer_typename" type='text' class="w3-input"  id="customer_typename" value="<?php echo $fetch1["type_customer"]; ?>" size="20"  />

<?php /*
<select name="customer_typename" id="customer_typename" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทลูกค้า**</option>
<option  value="ร้านขายยา">ร้านขายยา</option>
<option  value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
<option  value="โรงพยาบาล">โรงพยาบาล</option>

</select>*/ ?>


</div><div class="w3-container w3-third">
       หน่วยงาน :

	<select name="company_name" class="w3-input" id="company_name">
<option value="">**Please Select Item**</option>
<?php
$strSQL6 = "SELECT * FROM tb_company ORDER BY seq ASC";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
while($objResult6 = mysqli_fetch_array($objQuery6))
{
if($fetch1["type_company"] == $objResult6["company_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResult6["company_name"];?>" <?php echo $sel;?>><?php echo $objResult6["company_name"];?></option>

<?php
}
?>
</select>


</div><div class="w3-container w3-third">
       ประเภทงาน :
	   <input name="department_name" type='text' class="w3-input"  id="department_name" value="<?php echo $fetch1["department"]; ?>" size="20"  />
<?php /*
<select name="department_name" id="department_name" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทงาน**</option>
<option  value="Online">Online</option>
<option  value="Sale">Sale</option>

</select>*/ ?>

</div><div class="w3-container w3-third">
ชื่อผู้ติดต่อ  :
<input name="customer_name1"  class="w3-input" type='text' value="<?php echo $fetch1["customer_name"]; ?>" id="customer_name1">

</div><div class="w3-container w3-third">
 ผู้รับสินค้า :
<input name="customer_contact" value="<?php echo $fetch1["customer_contact"]; ?>" class="w3-input" type='text' id="customer_contact">

</div><div class="w3-container w3-third">

 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="w3-input" type='text' value="<?php echo $fetch1["customer_tel"]; ?>" id="customer_tel">

</div><div class="w3-container w3-third">

จังหวัด :
<select name="province_name" id ="province_name" class="w3-input" style="width:90%" >
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

 </div><div class="w3-container w3-third">
 สถานที่ส่งสินค้า :
<input type='text'  class="w3-input" value="<?php echo $fetch1["address_name"]; ?>" name="address_name" >             


 </div>
<div class="w3-container w3-third">	

  ที่อยู่ :
<textarea   class="w3-input" name="address_send" cols="54" rows="1"><?php echo $fetch1["address_send"]; ?></textarea>

</div>
<div class="w3-container w3-third">
เลขที่เอกสาร/เลขที่เครื่อง : 
<textarea name="product_sn"  class="w3-input" id="product_sn" cols="54" rows="1"><?php echo $fetch1["product_sn"]; ?></textarea>

</div>
<div class="w3-container w3-third">
สินค้า/เอกสาร :  
<textarea name="product"  class="w3-input" id="product" cols="54" rows="1"><?php echo $fetch1["product_name"]; ?></textarea>

</div>

<div class="w3-container w3-third">
รายละเอียดเพิ่มเติม : 
     <textarea name="description"  class="w3-input" id="description" cols="54" rows="1"><?php echo $fetch1["description"]; ?></textarea>
</div>

<?php 
				$sql2 = "select * from tb_transaction where ref_id = '".$_GET["ref_id"]."'";
				$query2 = mysqli_query($conn,$sql2);
				$fetch2 = mysqli_fetch_array($query2,MYSQLI_ASSOC); 
				
	?>
		<?php
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

<?php } ?>

</div>
<br><br><center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center><br><br>
</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		


<?php /*if($objResult["send_erpst"]=='0'){*/ ?>
  
<?php //} ?>
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

<script>
document.getElementById('have_order').addEventListener('change', function() {
  const deliveryInput = document.getElementById('delivery_contract');

  if (this.checked && !deliveryInput.value) {
    alert("กรุณาระบุวันที่ 'กำหนดส่งตามสัญญา'");
    deliveryInput.focus();
  }
});

// ป้องกันการ submit form ถ้ามีการติ๊กแต่ไม่กรอกวันที่
document.querySelector('form')?.addEventListener('submit', function(e) {
  const checkbox = document.getElementById('have_order');
  const deliveryInput = document.getElementById('delivery_contract');

  if (checkbox.checked && !deliveryInput.value) {
    e.preventDefault();
    alert("คุณได้เลือก 'มีออร์เดอร์ฝาก' กรุณาระบุวัน 'กำหนดส่งตามสัญญา'");
    deliveryInput.focus();
  }
});
</script>


