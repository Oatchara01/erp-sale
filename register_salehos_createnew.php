<?php include ("head.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



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

$ref_id =$_GET["ref_id"];

$sql = "SELECT *   FROM hos__so where ref_id = '".$ref_id."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$bill_name = $rs["bill_name"];	

$sql23 = "SELECT * FROM tb_other_bill where ref_id = '".$ref_id."'";
$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_assoc($qry23);	

$strSQL1 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$sql58 = "SELECT credit_ckk,credit_thb FROM tb_customer where customer_id  = '".$rs["bill_id"]."'";
$qry58 = mysqli_query($conn,$sql58) or die(mysqli_error());
$rs58 = mysqli_fetch_assoc($qry58);
	
$sql59 = "select pay_in from tb_bank where close_ckk='0' and id  = '".$rs58["credit_ckk"]."'";
$qry59 = mysqli_query($code,$sql59) or die(mysqli_error());
$rs59 = mysqli_fetch_assoc($qry59);
	
	
// ดึงยอดใช้ไป (unit_cash)
$sql60 = "SELECT COALESCE(SUM(unit_cash),0) AS unit_cash
          FROM tb_register_data
          WHERE summary_cash <> 'สมบูรณ์'
            AND IV_number NOT LIKE '%R%'
            AND IV_number NOT LIKE '%ธ%'
            AND unit_cash <> '0.00'
            AND (ref_sub = '' OR ref_sub IS NULL)
            AND bill_id = '".$rs["bill_id"]."'";
$qry60 = mysqli_query($code,$sql60) or die(mysqli_error($code));
$rs60  = mysqli_fetch_assoc($qry60);

// ดึงยอดรับชำระ (amount)
$sql61 = "SELECT COALESCE(SUM(rc.amount),0) AS amount
          FROM tb_receipt_cash rc
          WHERE rc.ref_id_off IN (
              SELECT id_off
              FROM tb_register_data
              WHERE bill_id = '".$rs["bill_id"]."'
          )";
$qry61 = mysqli_query($code,$sql61) or die(mysqli_error($code));
$rs61  = mysqli_fetch_assoc($qry61);

// ✅ คำนวณวงเงินคงเหลือ (credit_t02hb)
$credit_thb  = (float)$rs58["credit_thb"];
$used_cash   = (float)$rs60["unit_cash"];
$paid_amount = (float)$rs61["amount"];

$credit_t02hb = $credit_thb - $used_cash + $paid_amount;
	
	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql1 = "SELECT MAX(ref_id) AS MAXID FROM hos__so";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);
$maxId = substr($rs1['MAXID'], -4);
$maxId3 = substr($rs1['MAXID'],-8);

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

?>
	
<script>
// ถ้าในระบบยังไม่มีฟังก์ชัน numberFormat ให้ประกาศแบบนี้
function numberFormat(n) {
    n = parseFloat(n) || 0;
    return n.toLocaleString('th-TH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}
</script>

<script>
(function() {
    var billName  = "<?php echo addslashes($bill_name); ?>";
    var creditThb = <?php echo (float)$credit_thb; ?>;
    var remain    = <?php echo (float)$credit_t02hb; ?>;

    console.log('JS creditThb =', creditThb, 'remain =', remain, 'billName=', billName);

if (remain < 0 && creditThb !== 0) {
        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 (Swal) ไม่ถูกโหลด');
            return;
        }

        Swal.fire({
            title: "กรุณาติดต่อบัญชี",
            html:
              "<div style='font-size:16px; text-align:left;'>" +
                "<p>เพื่อขอเพิ่มวงเงินของคุณ เนื่องจากวงเงินของคุณไม่เพียงพอ</p>" +
                "<hr>" +
			    "<p><b>" + billName + "</b> </p>" +
                "<p><b>วงเงิน:</b> " + numberFormat(creditThb) + " บาท</p>" +
                "<p><b>ยอดวงเงินคงเหลือ:</b> " +
                  "<span style='color:red; font-weight:bold;'>" +
                    numberFormat(remain) + " บาท" +
                  "</span>" +
                "</p>" +
              "</div>",
            icon: "warning",
            confirmButtonText: "กลับหน้าหลัก",
        }).then(() => {
            window.location.href = "status_salehos.php";
        });
    }
})();
</script>



	<!--action="register_office1.php"-->
	<form action='register_salehos_createnew1.php' method="post" name="frmMain" enctype="multipart/form-data"
		  onSubmit="JavaScript:return fncSubmit();" >
		
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
			<div class="w3-container w3-bar w3-light-gray w3-margin-bottom">

			<div class="w3-half">
					<h4>EDIT Sale Order</h4>
				</div>
				<div class="w3-half">
				</div>
			</div>

<div class="w3-bar">
		

<?php if($rs["type_doc"]=='3'){ ?>
<input type="radio" checked='checked' name="type_doc" value = "3">&nbsp;ใบสั่งขาย AWL
<?php }else if($rs["type_doc"]=='4'){ ?>
<input type="radio" name="type_doc" checked='checked' value="4" >&nbsp;ใบสั่งขาย NBM
<?php } ?>
	
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ic_ckk" id="ic_ckk" value="1" > <font color='blue'>ใบฝากขาย</font>	
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="et_ckk" id="et_ckk" value="1" > <font color='blue'>ขอบิล E-Tax</font>

	
	
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
	</div>

	<br>
<?php
  // ดึงค่ามาให้ชัด
  $bill_id = isset($rs['bill_id']) ? trim((string)$rs['bill_id']) : '';
?>
<?php if ($rs59['pay_in'] !== ''): ?>
  <span class="w3-light-grey w3-right">
    <font color="blue">เครดิต :</font> 
    <?= htmlspecialchars($rs59['pay_in']) ?>
    <a href="#"
       style="color:#1a56db;text-decoration:underline;"
       onclick="openDayModal('<?= htmlspecialchars($bill_id, ENT_QUOTES) ?>'); return false;">
       ยอดหนี้คงค้าง
    </a>
  </span>
<?php endif; ?>

			
			

<div id="aw-day-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.5);">
  <div class="aw-modal-dialog" style="position:relative;margin:5vh auto;width:min(1000px,96vw);background:#fff;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.25);overflow:hidden;">
    <div class="aw-modal-header" style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:#2363d1;color:#fff;">
      <h3 id="aw-day-title" class="aw-modal-title">ยอดหนี้คงค้าง</h3>
      <button class="aw-modal-close" type="button" onclick="closeDayModal()" style="border:0;background:transparent;color:#fff;font-size:24px;cursor:pointer;">&times;</button>
    </div>
    <div class="aw-modal-body">
      <iframe id="aw-day-frame" style="width:100%;height:72vh;border:0;"></iframe>
    </div>
  </div>
</div>
</p>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>


		วันที่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name = "date_so" id="date_so" value="<?php echo $today; ?>" class = "button4"> 
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
				<input type="checkbox" name="have_order" id="have_order"  value="1" > ออเดอร์ฝาก
			  <input type="checkbox" name="plan_ckk" id="plan_ckk" value="1" > ไม่มีในประมาณการ Sale Report
				</p>





ชื่อผู้แนะนำ/ร.พ./แผนก  : &nbsp;<input type="text" name="suggest" class="button4" value="<?php echo $rs["suggest"];?>" style="width:30%;" required></p>

รหัสลูกค้า  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='text' name = "bill_id"  id = "bill_id" value = "<?php echo $rs["bill_id"]; ?>" class="button4" placeholder="Search ชื่อลูกค้า..."  style="width:30%;" OnChange="JavaScript:doCallAjax1('bill_id','bill_name','bill_address','bill_tel','tax_id');"/> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>
				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				
				ชื่อที่ต้องการออกบิล :&nbsp; <input type="text" value="<?php echo $rs["bill_name"];?>" name="bill_name" id="bill_name" class="button4" style="width:30%;"  required> </p>
<input type="hidden" value="<?php echo $rs["mode_cus"];?>" name="mode_cus" id="mode_cus" class="button4" style="width:30%;"  required>
			
					ที่อยู่ที่ใช้ในการออกบิล : &nbsp; <textarea rows="2" name="bill_address" id="bill_address" class="button4" style="width:30%" ><?php echo $rs["bill_address"];?></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
				เบอร์โทรศัพท์ :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="bill_tel"  id="bill_tel" class="button4" value="<?php echo $rs["bill_tel"];?>" style="width:30%;" ></p>

<?php if ($rs["full_bill"]=='1'){ ?>

<input type="checkbox" name="full_bill" checked='checked' value="1"> &nbsp;บิล VAT
<?php }else{ ?>
<input type="checkbox" name="full_bill" value="1"> &nbsp;บิล VAT

	<?php } ?>

 &nbsp;&nbsp;
เลขประจำตัวผู้เสียภาษี :&nbsp;&nbsp;&nbsp;<input type="text" name="tax_id" id="tax_id" value = "<?php echo $rs["tax_id"]; ?>" class="button4" style="width:22%;" >
</p>
</p>
<?php if($rs23["head_1"]=='1'){ ?>
<input type="checkbox" name="head_1" checked='checked' id="head_1" value="1">
<?php }else{ ?>
<input type="checkbox" name="head_1"  id="head_1" value="1">
<?php } ?>
&nbsp;ต้องการเอกสารแนบบิล<br>
<?php if($rs23["ref_1"]=='1'){ ?>
<input type="checkbox" name="ref_1"  checked='checked' id="ref_1" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_1"  id="ref_1" value="1"> 
<?php } ?>
&nbsp;เตรียมเอกสาร N-Health&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php if($rs23["ref_2"]=='1'){ ?>
<input type="checkbox" name="ref_2"  checked='checked' id="ref_2" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_2"  id="ref_2" value="1"> 
<?php } ?>

&nbsp;เตรียมเอกสารตามที่แนบไฟล์&nbsp;&nbsp;&nbsp;

<?php if($rs23["ref_3"]=='1'){ ?>
<input type="checkbox" name="ref_3"  checked='checked' id="ref_3" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_3"  id="ref_3" value="1"> 
<?php } ?>

&nbsp;ใบ อย.&nbsp;&nbsp;&nbsp;<br>

<?php if($rs23["ref_4"]=='1'){ ?>
<input type="checkbox" name="ref_4"  checked='checked' id="ref_4" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_4"  id="ref_4" value="1"> 
<?php } ?>

&nbsp;ใบตัวแทนจำหน่าย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($rs23["ref_5"]=='1'){ ?>
<input type="checkbox" name="ref_5"  checked='checked' id="ref_5" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_5"  id="ref_5" value="1"> 
<?php } ?>
&nbsp;ใบช่างอบรม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($rs23["ref_6"]=='1'){ ?>
<input type="checkbox" name="ref_6"  checked='checked' id="ref_6" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_6"  id="ref_6" value="1"> 
<?php } ?>
&nbsp;ใบนำเข้าสินค้า&nbsp;&nbsp;&nbsp;<br>

<?php if($rs23["ref_7"]=='1'){ ?>
<input type="checkbox" name="ref_7"  checked='checked' id="ref_7" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_7"  id="ref_7" value="1"> 
<?php } ?>

&nbsp;ใบ CER เครื่องมือที่ใช้ทดสอบ&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($rs23["ref_8"]=='1'){ ?>
<input type="checkbox" name="ref_8"  checked='checked' id="ref_8" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_8"  id="ref_8" value="1"> 
<?php } ?>
&nbsp;ใบ PM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($rs23["ref_9"]=='1'){ ?>
<input type="checkbox" name="ref_9"  checked='checked' id="ref_9" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_9"  id="ref_9" value="1"> 
<?php } ?>
&nbsp;ใบ CAL&nbsp;&nbsp;&nbsp;<br>
<?php if($rs23["ref_11"]=='1'){ ?>
<input type="checkbox" name="ref_11"  checked='checked' id="ref_11" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_11"  id="ref_11" value="1"> 
<?php } ?>
&nbsp;ใบประเมินสินค้า&nbsp;&nbsp;&nbsp;

<?php if($rs23["ref_10"]=='1'){ ?>
<input type="checkbox" name="ref_10"  checked='checked' id="ref_10" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_10"  id="ref_10" value="1"> 
<?php } ?>
&nbsp;อื่น ๆ&nbsp;&nbsp;&nbsp;&nbsp;
<input name="ref_des" id="ref_des" value="<?php echo $rs23["ref_des"]; ?>" class="button4" style="width:30%">
<br>
<?php if($rs23["ref_12"]=='1'){ ?>
<input type="checkbox" name="ref_12" checked='checked' id="ref_12" value="1"> &nbsp;ส่งสินค้าด้วยใบรับสินค้า [ไม่ระบุราคา]&nbsp;&nbsp;&nbsp;&nbsp;
<?php }else{ ?>
<input type="checkbox" name="ref_12"  id="ref_12" value="1"> &nbsp;ส่งสินค้าด้วยใบรับสินค้า [ไม่ระบุราคา]&nbsp;&nbsp;&nbsp;&nbsp;

<?php } ?>

<?php if($rs23["ref_13"]=='1'){ ?>
<input type="checkbox" name="ref_13"  checked='checked' id="ref_13" value="1"> &nbsp;ไม่ต้องนำใบกำกับภาษี/ใบเสร็จไปส่งสินค้า
<?php }else{ ?>
<input type="checkbox" name="ref_13"  id="ref_13" value="1"> &nbsp;ไม่ต้องนำใบกำกับภาษี/ใบเสร็จไปส่งสินค้า
<?php } ?>

</p>
<?php
if($rs["type_doc"]=='3'){ 
$erer = '4';	 
}else{
$erer = '3';	
}
?>

การชำระเงิน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<select name="payment" class="button4" style="width:30%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_bank where close_ckk='0' and company !='".$erer."' order by number";
$objQuery5 = mysqli_query($code,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($rs["payment"] == $objResuut5["id"])
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
<?php /*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Sales Comment :&nbsp;
<textarea name="sale_comment"  class="button4" style="width:30%" id="sale_comment"  rows="2"><?php echo $rs["sale_comment"];?></textarea>*/ ?></p>

เพิ่มเติมการชำระเงิน :&nbsp;&nbsp;
<input type="text" name="payment_des" id="payment_des" value ="<?php echo $rs["payment_des"];?>" class="button4" style="width:30%;" placeholder="ระบุในการณีเลือกอื่นๆ..." > </p>
วันที่โอนเงิน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name = "date_tranfer" id="date_tranfer"  class = "button4"></p>


ใบสั่งซื้อเลขที่:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="po_no" class="button4" value ="<?php echo $rs["po_no"];?>" style="width:30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
กำหนดส่งตามสัญญา :
<input name="delivery_contract" id="delivery_contract"  type='date' value ="<?php echo $rs["delivery_contract"];?>"  class="button4" style="width:30%"> </p>

<?php if($rs["book_clear"]=='1'){ ?>
<input type="checkbox" name="book_clear" checked="checked" value="1">&nbsp; เคลียร์ใบจอง :
<?php }else{ ?>
<input type="checkbox" name="book_clear" value="1">&nbsp; เคลียร์ใบจอง :

	<?php } ?>



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="book_no" value ="<?php echo $rs["book_no"];?>"  class="button4" placeholder="เลขที่" style="width:30%">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<input type="checkbox" name="brn_clear" value="1">&nbsp;เคลียร์ใบยืมสินค้า ติดเล่ม  :

<input name="brn_no"   class="button4" style="width:27%" placeholder="เลขที่" ></p>

<input type="checkbox" name="brnp_clear" value="1">&nbsp;เคลียร์ใบยืมสินค้า กระดาษต่อเนื่อง :&nbsp;

<input name="brnp_no"  class="button4" style="width:23%" placeholder="เลขที่" >&nbsp;&nbsp;&nbsp;

<?php if($rs["sn_ckk"]=='1'){ ?>

<input type="checkbox" name="sn_ckk" checked='checked' value="1">&nbsp;ต้องการ SN :

<?php }else{ ?>
<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN :

	<?php } ?>


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="sn_no" value ="<?php echo $rs["sn_no"];?>"  class="button4" style="width:30%" placeholder="เลขที่"> </p>




<?php if($rs["with_pr"]=="1"){ ?>

<input name="with_pr" type="checkbox" checked="checked" value="1"> แนบใบเสนอราคา

<?php }else{ ?>
<input name="with_pr" type="checkbox" value="1"> แนบใบเสนอราคา

	<?php } ?>

เลขที่  : 
<input name="pr_no" class="button4"   style="width:28%" placeholder="เลขที่"></p>

<?php if($rs["type_type"]=="1"){ ?>
<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

<?php }else if($rs["type_type"]=="2"){ ?>

<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" checked="checked" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />


	<?php }else if($rs["type_type"]=="3"){ ?>

<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" checked="checked" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />


		<?php }
		if($rs["type_type"]=="3"){ ?>
		

ระบุ:
<textarea name="type_detail" class="button4" rows="2" style="width:30%"><?php echo $rs["type_detail"]; ?></textarea>

<?php } ?>


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

</p>แนบไฟล์ 
</p>


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
<input type="hidden" name="bom_ckk[]<?php echo $objResult1["bom_ckk"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['bom_ckk']; ?>">
<input type="hidden" name="bom_code[]<?php echo $objResult1["bom_code"];?>" id="bom_code[]<?php echo $objResult1["bom_code"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['bom_code']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" id="product_id[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[]<?php echo $objResult1["id"];?>" id="product_code[]<?php echo $objResult1["id"];?>"  value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"  size="5"  class="button4" OnChange="JavaScript:doCallAjax('product_code[]<?php echo $objResult1["id"];?>','product_id[]<?php echo $objResult1["id"];?>','product_name[]<?php echo $objResult1["id"];?>','unit_name[]<?php echo $objResult1["id"];?>');" /></td>

<td style="width:15%;"><textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="button4" readonly><?php echo $objResult1["access_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:8%;"><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php  $price=$objResult1["price"]; echo number_format( $price,2)."";?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="button4"  style="color:black;text-align:right"  size="7"  /></td>

<td style="width:8%;"><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php  $discount_unit=$objResult1["discount"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>" size="5" class="button4" style="color:black;text-align:right"   /></td>


<td style="width:8%;">
<input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[]<?php echo $objResult1["id"];?>" size="7" class="button4" style="color:black;text-align:right"   />


</td>

<td style="width:5%;"><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["warranty"];?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:5%;"><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:10%;">


<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />

</td>


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
    <th>หมายเหตุ</th>

</thead>
<tbody>
<?php


$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	if($objResult1["bom_ckk"]=='0'){
?>
<tr>
<td style="width:10%;">
<input type="hidden" name="bom_ckk[]<?php echo $objResult1["bom_ckk"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['bom_ckk']; ?>">
<input type="hidden" name="bom_code[]<?php echo $objResult1["bom_code"];?>" id="bom_code[]<?php echo $objResult1["bom_code"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['bom_code']; ?>">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" id="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" id="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"  size="5"  class="button4" OnChange="JavaScript:doCallAjax('product_code[]<?php echo $objResult1["id"];?>','product_id[]<?php echo $objResult1["id"];?>','product_name[]<?php echo $objResult1["id"];?>','unit_name[]<?php echo $objResult1["id"];?>');" /></td>

<td style="width:15%;"><textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="button4" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:8%;"><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php  $price=$objResult1["price"]; echo number_format( $price,2)."";?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="button4"  style="color:black;text-align:right"  size="7"  /></td>

<td style="width:8%;"><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php  $discount_unit=$objResult1["discount"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>" size="5" class="button4" style="color:black;text-align:right"   /></td>


<td style="width:8%;">
<input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[]<?php echo $objResult1["id"];?>" size="7" class="button4" style="color:black;text-align:right"   />


</td>

<td style="width:5%;"><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["war_hos"];?> <?php echo $objResult1["unit_hos"];?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:5%;"><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:10%;">


<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />

</td>


</tr>



<?php
	$i++;
	}
}

$strSQL2 = "SELECT distinct code_bom  FROM hos__subso  WHERE ref_idd = '".$ref_id."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2)){
		
$code_bom	= $objResult2["code_bom"];	
	
$strSQL3 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product_bomhos ON hos__subso.code_bom=tb_product_bomhos.bom_code) WHERE ref_idd = '".$ref_id."' and code_bom = '".$code_bom."'";

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);



while($objResult3 = mysqli_fetch_array($objQuery3))
{
	if($objResult3["code_bom"]!=''){
?>
<tr>
<td style="width:10%;">

<input type="hidden" name="id[]<?php echo $objResult3["id"];?>" id="id[]<?php echo $objResult3["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult3['id']; ?>">
<input type="hidden" name="code_bomsame[]<?php echo $objResult3["code_bomsame"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult3['code_bomsame']; ?>">
<input type="hidden" name="bom_ckk[]<?php echo $objResult3["bom_ckk"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult3['bom_ckk']; ?>">
<input type="hidden" name="bom_code[]<?php echo $objResult3["bom_code"];?>" id="bom_code[]<?php echo $objResult3["bom_code"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult3['bom_code']; ?>">




<input type="hidden" name="product_id[]<?php echo $objResult3["id"];?>" id="product_id[]<?php echo $objResult3["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult3['product_id']; ?>">

<input type='text' name ="product_code[]<?php echo $objResult3["id"];?>" value="<?php echo $objResult3["bom_code"];?>" id ="product_code[]<?php echo $objResult3["id"];?>"  size="5"  class="button4" OnChange="JavaScript:doCallAjax('product_code[]<?php echo $objResult3["id"];?>','product_id[]<?php echo $objResult3["id"];?>','product_name[]<?php echo $objResult3["id"];?>','unit_name[]<?php echo $objResult3["id"];?>');"/></td>

<td style="width:15%;"><textarea name = "product_name[]<?php echo $objResult3["id"];?>"   id = "product_name[]<?php echo $objResult3["id"];?>"  class="button4" readonly><?php echo $objResult3["bom_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult3["id"];?>" value="<?php echo $objResult3["unit_name"];?>" id = "unit_name[]<?php echo $objResult3["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $objResult3["id"];?>" value="<?php echo $objResult3["count"];?>" id = "sale_count[]<?php echo $objResult3["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:8%;"><input type='text' name = "product_price[]<?php echo $objResult3["id"];?>" value="<?php  $price=$objResult3["price"]; echo number_format( $price,2)."";?>" id = "product_price[]<?php echo $objResult3["id"];?>"  class="button4"  style="color:black;text-align:right"  size="7"  /></td>

<td style="width:8%;"><input type='text' name = "discount_unit[]<?php echo $objResult3["id"];?>" value="<?php  $discount_unit=$objResult3["discount"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult3["id"];?>" size="5" class="button4" style="color:black;text-align:right"   /></td>


<td style="width:8%;">
<input type='text' name = "sum_amount[]<?php echo $objResult3["id"];?>" value="<?php  $sum_amount=$objResult3["amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[]<?php echo $objResult3["id"];?>" size="7" class="button4" style="color:black;text-align:right"   />


</td>

<td style="width:5%;"><input type='text' name = "warranty[]<?php echo $objResult3["id"];?>" value="<?php echo $objResult3["warranty"];?>" id = "warranty[]<?php echo $objResult3["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:5%;"><input type='text' name = "cal[]<?php echo $objResult3["id"];?>" value="<?php echo $objResult3["cal"];?>" id = "cal[]<?php echo $objResult3["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:5%;"><input type='text' name = "pm[]<?php echo $objResult3["id"];?>" value="<?php echo $objResult3["pm"];?>" id = "pm[]<?php echo $objResult3["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:10%;">


<input type='text' name = "sale_remarkk[]<?php echo $objResult3["id"];?>"  id = "sale_remarkk[]<?php echo $objResult3["id"];?>" value="<?php echo $objResult3["sale_remark"];?>" class="w3-input" />

</td>


</tr>



<?php
	$i++;
	}
}
}
?>



</tbody>
</table>

<?php 
	if ($rs["type_doc"]=='3'){
	include ('product_salehos1.php');
	}else if ($rs["type_doc"]=='4'){
	include ('product_salehosnb1.php');	
	}
}
	
	?>

</div>

<div id="cs" class="w3-container city1" style="display:none">

<?php if($rs["delivery_type"]=='1') { ?>
<input type="radio" name="delivery_type" value="1" checked='checked' >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  >&nbsp;บริษัทจัดส่ง <br />

</p>

<?php }else if ($rs["delivery_type"]=='2') { ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2" checked='checked' >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  >&nbsp;บริษัทจัดส่ง <br />

<?php }else if ($rs["delivery_type"]=='3') { ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3" checked='checked' >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  >&nbsp;บริษัทจัดส่ง <br />


<?php }else if ($rs["delivery_type"]=='4') { ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4" checked='checked' >&nbsp;บริษัทจัดส่ง <br />


	<?php } ?>

	<?php
		$sql1 = "select * from tb_register_data where ref_id = '".$rs["ref_id"]."'";
				$query1 = mysqli_query($conn,$sql1);
				$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
	?>

 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date"  class="button4" style="width:20%" /></p>


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

<input type="checkbox"  id = "on_time" checked='checked' name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;

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
		
&nbsp;&nbsp;<input type="checkbox"  id = "call_back" checked='checked' name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว&nbsp;&nbsp;
<?php }else{ ?>
&nbsp;&nbsp;<input type="checkbox"  id = "call_back"  name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
&nbsp;&nbsp;

	<?php } ?>

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

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า :
<input name="customer_tel" value="<?php echo $fetch1["customer_tel"]; ?>"  class="button4" type='text' id="customer_tel" >

</p>

 
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
</center><br>

  </div>  </div>

</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		


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
		return "data_bill_name2.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 




<script>
function openDayModal(billId){
  const frame = document.getElementById('aw-day-frame');
  const modal = document.getElementById('aw-day-modal');

  if (!frame || !modal) {
    console.warn('Missing #aw-day-frame or #aw-day-modal element.');
    return;
  }

  const url = 'credit_admin_list.php?popup=1' + (billId ? '&bill_id=' + encodeURIComponent(billId) : '');
  modal.style.display = 'block';
  frame.src = url; // หรือจะสลับลำดับก็ได้
}

function closeDayModal(){
  document.getElementById('aw-day-modal').style.display = 'none';
  document.getElementById('aw-day-frame').src = 'about:blank';
}
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