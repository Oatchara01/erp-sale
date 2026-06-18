<?php 
include('head.php');

 ?>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(bill_id,billing_name,billing_address,billing_tel,tax_id) {
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
document.getElementById(billing_tel).value = myArr[2];
document.getElementById(tax_id).value = myArr[3];

}
}
}
}

    
</script>

<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
    }
}


function fncSum()
{

var payment = document.frmMain.payment.value;
 
document.frmMain.payment1.value  = payment;

}
	




</script>



	<script type="text/javascript">



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





</script>


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
<?php
$sql1 = "select * from so__main order by main_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); ?>
<!-- -->
<form action="register_admin1.php"  method="post" name="frmMain" enctype="multipart/form-data" >
<div class="w3-container w3-padding-large"><!-- main div -->
<div class="w3-panel w3-light-gray"><h4>Register Data : Admin</h4></div>
<div class="w3-third"><!-- first half -->
<div class="w3-bar w3-border w3-margin-bottom">
<div class="w3-button"><input type="radio" name="select_type_doc" onclick="javascript:object();" checked ='checked' value="1" id="object1">&nbsp;ใบยืมสินค้า AWL</div>
<div class="w3-button"><input type="radio" name="select_type_doc" onclick="javascript:object();" value="2" id="object2">&nbsp;ใบยืมสินค้า NBM</div>
<div class="w3-button"><input type="radio" name="select_type_doc" onclick="javascript:object();" value="3" id="object3">&nbsp;ใบสั่งขาย AWL</div>
<div class="w3-button"><input type="radio" name="select_type_doc" onclick="javascript:object();" value="4" id="object4">&nbsp;ใบสั่งขาย NBM</div>




</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
วันที่ : <span class="w3-light-grey"><?php echo datethai(date("Y-m-d")); ?></span> | เลขที่อ้างอิง : <span name="ref_id" class="w3-light-grey"><?php echo $fetch1['ref_id']+1; ?></span><input type="hidden" name="main_id" value="<?php echo $fetch1['main_id']+1; ?>"><input type="hidden" name="ref_id" value="<?php echo $fetch1['ref_id']+1; ?>">
</div>
<div class="w3-padding-small"></div>
ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)" OnChange="resutName(this.value);">
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?><?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>



<div class="w3-padding-small"></div>
การจัดส่ง

<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='hidden' class="w3-input" >


<input type='text' class="w3-input" class="button4" name="delivery" size="95" placeholder="Search การจัดส่ง..."/>            
<input name="h_delivery" type="hidden" id="h_delivery" value="" class="button4" />


<div class="w3-padding-small"></div>
การชำระเงิน:

<input type='text' class="w3-input" class="button4" name="payment" size="95" placeholder="Search การชำระเงิน..."   OnChange="fncSum();"/ >            
<input name="h_payment" type="hidden" id="h_payment" value="" class="button4" />



<div class="w3-padding-small"></div>
หมายเหตุ:
<textarea name="sale_remark"  class="w3-input" id="sale_remark" rows="1"></textarea>
<div class="w3-padding-small"></div>
ชื่อพนักงาน:

<input type='text' class="w3-input" class="button4" name="employee_name" size="95" placeholder="Search ชื่อพนักงาน..."/>            
<input name="h_employee_name" type="hidden" id="h_employee_name" value="" class="button4" />


</div><!-- first half -->

<div class="w3-container w3-twothird"><!-- second half -->
<div class="w3-bar w3-light-grey w3-border w3-margin-bottom">
  <a class="w3-button" onclick="openCity('st')"><font color="#404040"><b>Admin ลงทะเบียน</b></font></a>
  <a class="w3-button" onclick="openCity('so')"><font color="#404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-button" onclick="openCity('mo')"><font color="#404040"><b>เพิ่มเติม</b></font></a>
  <a class="w3-button" onclick="openCity('br')"><font color="#404040"><b>ใบยืมสินค้า</b></font></a>
</div>

<div id="st" class="w3-container city">
<div class="w3-half"><!-- first right half -->
<div class="w3-half w3-bar">
<input type="checkbox" name="run_id" value="1"> &nbsp;Run เลขที่เอกสาร IE,SOL
</div><div class="w3-half w3-bar">	
เลขที่เอกสาร <input name="doc_no" class="w3-input" type="text" style="width:90%;">

</div>
<div class="w3-half w3-bar">

เลขที่ IV รวมบิล <input name="iv_no" class="w3-input" type="text" style="width:90%;">

</div>


<div class="w3-half w3-bar">
เลขที่ลงงาน <input name="job_id" class="w3-input" type="text" style="width:90%;">
</div>
<div class="w3-half w3-bar">
วันที่ออกเอกสาร <input name="doc_release_date" class="w3-input"  type="date" style="width:90%;">
</div>
<div class="w3-half w3-bar">
ฝากสินค้าเลขที่ <input name="deposit_no" class="w3-input"  type="text" style="width:90%;">
</div>

<div class="w3-bar w3-margin-top">

<div id="dt1" style="display:none">
	<input type="checkbox"  checked="checked" value="1">&nbsp;
	<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม PTL</font></a>&nbsp;&nbsp;
</div>

<div id="dt2" style="display:none">
	<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
	<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;
</div>

<div id="dt3" style="display:none">
	<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
	<a href="report_saleptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></button></a><br />
</div>

<div id="dt4" style="display:none">
	<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
	<a href="report_salenbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
</div>
</div>
<div class="w3-margin-top"></div>
<legend>ใบปะหน้ากล่อง :</legend>
<div class="w3-half w3-margin-bottom">
	<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%"><font color="DarkViolet">99std</font></a>
</div>
<div class="w3-half w3-margin-bottom">
	<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%"><font color="DarkViolet">99std+k</font></a>
</div>
<div class="w3-half w3-margin-bottom">
<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%"><font color="Blue">a5ptl</font></a>
</div>
<div class="w3-half w3-margin-bottom">
<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%"><font color="Blue">a5ptl+k</font></a>
</div>
<div class="w3-half w3-margin-bottom">
<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%"><font color="Blue">a4ptl</font></a>
</div>
<div class="w3-half w3-margin-bottom">
<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%"><font color="Blue">a4ptl+k</font></a>
</div>
<div class="w3-half w3-margin-bottom">
<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%"><font color="DeepPink">a5nbm</font></a>
</div>
<div class="w3-half w3-margin-bottom">
<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%"><font color="DeepPink">a5nbm+k</font></a>
</div>
<div class="w3-half">
<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%"><font color="DeepPink">a4nbm</font></a>
</div>
<div class="w3-half">
<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%"><font color="DeepPink">a4nbm+k</font></a>
</div>
</div><!-- first right half -->

<div class="w3-half"><!-- second right half -->
<div class="w3-bar w3-left w3-half">
<a href="report_summary_ptl.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>" target="_blank" class="w3-button w3-grey" style="width:95%;"><font color="Blue">สรุปยืมแบบรวม PTL</font></a>
</div>

<div class="w3-bar w3-right w3-half w3-margin-bottom">
<a href="report_summary_nbm.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>" target="_blank" class="w3-button w3-grey" style="width:95%;"><font color="DeepPink">สรุปยืมแบบรวม NBM</font></a>
</div>
<div class="w3-bar w3-margin-top">
<a href="" target="_blank" class="w3-button w3-grey" style="width:97%;" onClick="window.open('billing_name.php?main_id=<?php echo $fetch1['main_id']; ?>','Billing Description','resizable,height=600,width=720'); return false;"><font color="DarkViolet">รายชื่อที่ต้องการออกบิล</font></a>
</div>
<div class="w3-bar w3-margin-top">
คลิ๊กสมบูรณ์เมื่อออกบิลแล้ว <input type='checkbox' name='admin_commplete' value='1'></p>

Status เอกสาร </p> 
<input type='radio' name='status_doc'  value='1'>&nbsp;รอดำเนินการ  
<input type='radio' name='status_doc' checked="checked" value='2'>&nbsp;สมบูรณ์แล้ว
</p>
แนบไฟล์ </p>
<input name="upload1"  type="file"></p>
<input name="upload2"  type="file"></p>
<input name="upload3"  type="file"></p>
<input name="upload4"  type="file"></p>
<input name="upload5"  type="file"></p>

</div>
</div><!-- second right half -->
</div><!-- close st -->

<div id="so" class="city" style="display:none">
<div class="w3-half w3-container"><!-- first so half -->
	
	รหัสลูกค้า
<input type='text' name = "bill_id"  id = "bill_id"  class="w3-input" placeholder="Search ชื่อลูกค้า..."   OnChange="JavaScript:doCallAjax1('bill_id','billing_name','billing_address','billing_tel','tax_id');"/> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>	
ชื่อที่ออกบิล:
<input name="billing_name" id="billing_name" type='text' class="w3-input" readonly>
ทีอยู่ที่ออกบิล:
<textarea name="billing_address" id="billing_address" class="w3-input" rows="1" readonly></textarea>
<div class="w3-half">
Tel.:
<input type="text" name="billing_tel" id="billing_tel" class="w3-input" readonly>
</div>
<div class="w3-bar w3-half w3-container">
<input type="checkbox" name="bill_vat" value="1"> &nbsp;บิล VAT
	<input type="text" name="tax_id" id="tax_id" class="w3-input" readonly>
</div>
<div class="w3-bar"><?php /*การชำระเงิน
<input name="payment1" type='text' class="w3-input" id="payment1" placeholder="Search การชำระเงิน..."    > 

<select name="payment1" class="w3-select" disabled>
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_payment order by payment_ID";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?> | <?php echo $objResuut5['book_number']; ?> | <?php echo $objResuut5['branch_bank']; ?> | <?php echo $objResuut5['book_type']; ?> | <?php echo $objResuut5['book_name']; ?> | <?php echo $objResuut5['description_payment']; ?></option>
<?php } ?>
</select>*/?>
</div>
การโอนเงิน
<select name="transfer" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$strSQL3 = "SELECT * FROM tb_transfer ORDER BY tranfer_ID ASC";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
while($objResult3 = mysqli_fetch_array($objQuery3))
{

?>
<option value="<?php echo $objResult3["tranfer_name"];?>"><?php echo $objResult3["tranfer_name"];?></option>

<?php
}
?>

</select>
<div class="w3-bar">
ส่งบัญชีตรวจสอบ
<input type="checkbox" name="account_approve" value="1">
</div>
<div class="w3-bar">
วันที่โอน
<input type="date" name="transfer_date" id="transfer_date" class="w3-input">
</div>
<div class="w3-bar">
จำนวนเงินโอน/เก็บปลายทาง
<input type="text" name="amount" class="w3-input">
</div>
</div><!-- close so first half -->

<div class="w3-half w3-container w3-border"><!-- so second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="address1" class="w3-input" type="text">
<input name="address2" class="w3-input" type="text">
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
รหัสไปรษณีย์
<input name="postcode" type="text" class="w3-input">
โทรศัพท์
<input name="tel" type="text" class="w3-input">
</div><!-- close so second half -->
</div><!-- close so -->

<div id="mo" class="w3-container city" style="display:none">
<div class="w3-third"><!--first third -->
ชื่อผู้แนะนำ
<input name="prefer_name"  class="w3-input" >
ใบสั่งซื้อเลขที่
<input name="po_no" class="w3-input" >
กำหนดส่งตามสัญญา:
<input name="delivery_contract" class="w3-input" >
<input type="checkbox" name="clear_book_ckk" value="1">&nbsp; เคลียร์ใบจอง:
<input name="clear_book_no" class="w3-input" placeholder="เลขที่" >
<input type="checkbox" name="clear_brn_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRN:
<input name="clear_brn_no" class="w3-input" placeholder="เลขที่" >
<input type="checkbox" name="clear_brnp_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRNP:
<input name="clear_brnp_no" class="w3-input" placeholder="เลขที่" >
</div><!--first third -->
<div class="w3-container w3-third"><!--second third -->
<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN:
<input name="sn" class="w3-input" >
<input type="checkbox" name="bq_ckk" value="1">&nbsp;BQ เลขที่:
<input name="bq" class="w3-input" >
<input type="checkbox" name="ot_ckk" value="1">&nbsp;OT เลขที่:
<input name="ot" class="w3-input" >


<?php /*
รับประกัน (ปี)
<input name="warranty_h" class="w3-input" >
Cal (ครั้ง/ปี)
<input name="cal" class="w3-input" >
PM (ครั้ง/ปี)
<input name="pm" class="w3-input" >*/
?>
</div><!--second third -->
<div class="w3-third"><!--third third -->
สถานที่ติดตั้งเครื่อง
<input name="install_place" class="w3-input" ><br />
<input name="with_pr" type="checkbox" value="1">แนบใบเสนอราคา
<br />
<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6">พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7">พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5">พิมพ์ตามที่เขียน
<br />
<div id="dt5" style="display:none">

ระบุ:
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"></textarea>
</div>
</div><!--third third -->
</div><!-- close more -->
<div class="w3-padding-small"></div>
<div id="br" class="city" style="display:none">
<div id="txtHint"></div>
</div><!-- close br -->
</div><!-- second half -->


<div class="w3-bar w3-light-grey w3-border">
     <a class="w3-bar-item w3-button" onclick="openCity1('stoc')"><font color="#404040"><b>เอกสารแนบเพิ่มเติม</b></font></a>
<?php /* <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>*/ ?>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('ot')"><font color="#404040"><b>ปิดงาน</b></font></a>

</div>

<div id="stoc" class="w3-container city1" style="display:none">
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม Lazada</b><br />
1. ใบบาร์โค้ด<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม 99 HM</b><br />
1. Slip<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม 11 Street</b><br />
1. ใบบาร์โค้ด<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
</div>
<?php /*<div id="pd" class="w3-container city1">

<?php include ('data_product_code1.1.php')

/*include ('register_barcode.php')*/

/* include ('register_admin_detail.php')*/

/*</div>style="display:none"*/?>

<div id="cs" class="w3-container city1" >
<div class="w3-quarter"><!-- first third-->
<input type="radio" name="delivery_type" checked = 'checked' value="1">&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2">&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">&nbsp;บริษัทจัดส่ง<br />
<br \>
วันที่ส่ง
<input type="date" name="delivery_date"  class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time"  class="w3-input" >


</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second third-->

สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="2" style="width:100%;resize: none" ></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd quarter-->

<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>

วันที่รับคืน
<input type="date" name="return_date"   class="w3-input" >
เวลา
<input type="text" name="return_time"  class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address"  class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact"  class="w3-input" >
</div><!-- 3rd quarter-->



<div class="w3-container w3-third">
<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไประบบลงงาน 
	</div>
<div class="w3-container w3-third">
.
	</div>
	<div class="w3-container w3-third">
.
	</div>
	<div class="w3-container w3-third">
 วันที่ รับ-ส่ง :
      <input name="start_date" type='date' id="start_date"   class="w3-input"  />

	</div><div class="w3-container w3-third">

วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="w3-input"  type='text' id="between_date"  />
 </div><div class="w3-container w3-third">

 เวลา :
<input id="start_time"  name="start_time"  class="w3-input" type="text" />
ถึง
<input id="end_time" name="end_time"   class="w3-input" type="text" />

</div><div class="w3-container w3-third">


สถานะการทำงาน : 


<input type='radio'  name='status' id = 'status' value='ส่ง' />ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ



</div><div class="w3-container w3-third">

สถานะ :
      <input name="status_comment" type='text' id="status_comment"  size="20" class="w3-input"/>
</div><div class="w3-container w3-third">


<input type="checkbox"  name="fix_datetime" id = "fix_datetime"  value="1">นัดวันและเวลาเรียบร้อยแล้ว 


<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน



</div><div class="w3-container w3-third">

<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว


</div><div class="w3-container w3-third">

	<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่


		</div><div class="w3-container w3-third">
	 
	<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด



		 <input name="unit_cash" type='text' class="w3-input" id="unit_cash"  size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		 </div><div class="w3-container w3-third">


	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค

		
	<input name="unit_check" type='text' class="w3-input"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/>
		</div><div class="w3-container w3-third">


<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด 



	<input name="unit_credit" type='text' class="w3-input"  id="unit_credit"  size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	</div><div class="w3-container w3-third">


<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล

	
<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" id="unit_bill"  size="20" OnChange="JavaScript:chkNum(this)" />
</div><div class="w3-container w3-third">


<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน
	
		 <input name="unit_tran" type='text' class="w3-input" id="unit_tran" size="20"  style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 
</div><div class="w3-container w3-third">


<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ


	

<input name="dept" type='text' class="w3-input"  id="dept"  size="20"  />
</div><div class="w3-container w3-third">

แผนก - ฝ่าย :


<select name="department_show" id="department_show" class="w3-input"   >
<option  value="">**โปรดเลือกแผนก-ฝ่าย**</option>
<option  value="ฝ่ายการตลาด">ฝ่ายการตลาด</option>
<option  value="ฝ่ายขาย">ฝ่ายขาย</option>
<option  value="ฝ่ายสนับสนุนการขาย ธุรการ">ฝ่ายสนับสนุนการขาย ธุรการ</option>

</select>

</div><div class="w3-container w3-third">
       ประเภทลูกค้า :


<select name="customer_typename" id="customer_typename" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทลูกค้า**</option>
<option  value="ร้านขายยา">ร้านขายยา</option>
<option  value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
<option  value="โรงพยาบาล">โรงพยาบาล</option>

</select>


</div><div class="w3-container w3-third">
       หน่วยงาน :

	 
<select name="company_name" id="company_name" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="ฟาร์ ทริลเลี่ยน บจก.">ฟาร์ ทริลเลี่ยน บจก.</option>
<option  value="โนเบิล เมด บจก.">โนเบิล เมด บจก.</option>
<option  value="อื่นๆ">อื่นๆ</option>
</select>


</div><div class="w3-container w3-third">
       ประเภทงาน :
	 
<select name="department_name" id="department_name" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทงาน**</option>
<option  value="Online">Online</option>
<option  value="Sale">Sale</option>

</select>

</div><div class="w3-container w3-third">
ชื่อผู้ติดต่อ  :
<input name="customer_name1"  class="w3-input" type='text'  id="customer_name1">

</div><div class="w3-container w3-third">
 ผู้รับสินค้า :
<input name="customer_contact"  class="w3-input" type='text' id="customer_contact">

</div><div class="w3-container w3-third">

 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="w3-input" type='text' id="customer_tel">

</div><div class="w3-container w3-third">
ชื่อโรงพยาบาล :
<input type='text'  class="w3-input"  name="address_name" >             


 </div>
<div class="w3-container w3-third">	

  ที่อยู่ :
<textarea   class="w3-input" name="address_send" cols="54" rows="1"></textarea>

</div>
<div class="w3-container w3-third">
เลขที่เอกสาร/เลขที่เครื่อง : 
<textarea name="product_sn"  class="w3-input" id="product_sn" cols="54" rows="1"></textarea>

</div>
<div class="w3-container w3-third">
สินค้า/เอกสาร :  
<textarea name="product"  class="w3-input" id="product" cols="54" rows="1"></textarea>

</div>

<div class="w3-container w3-third">
รายละเอียดเพิ่มเติม : 
     <textarea name="description"  class="w3-input" id="description" cols="54" rows="1"></textarea>
</div>


</div><!-- cs -->
<br />

<?php require_once('foot.php'); ?>
</div><center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='register_admin1.php'; submit()">
</center>
</form>
</body>
</html>


<?php /*<script type="text/javascript">
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
		return "data_sale_channel.php?sale_channel_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("sale_channel","h_sale_channel");
        </script>*/  ?>


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
$(document).ready(function(){
    $('.search-box input[id="sale_channel"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("data_sale_channel.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[id="sale_channel"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
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
		return "data_bill_name.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 