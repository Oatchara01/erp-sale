<?php include ("head.php"); ?>
<?php include "dateselect.php"; ?>
<?php include('dbconnect_sale.php'); ?>

<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(bill_id,bill_name,bill_address,bill_tel,tax_id,pre_name,mode_name,email,customer_typename) {
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
document.getElementById(pre_name).value = myArr[10];
document.getElementById(mode_name).value = myArr[20];
document.getElementById(email).value = myArr[21];
document.getElementById(customer_typename).value = myArr[22];		
}
}
}
}

    
</script>



<script>

function ck_1(){
var ck_1 = document.getElementById('ckk_1');
if(ck_1.checked == true){
document.getElementById('frm_txt_1').style.display = "";
}else{
document.getElementById('frm_txt_1').style.display = "none";
}

}



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

$sql23 = "SELECT *   FROM tb_other_bill where ref_id = '".$ref_id."'";
$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_assoc($qry23);

$sql26 = "SELECT *   FROM tb_comment_so where ref_id = '".$ref_id."'";
$qry26 = mysqli_query($conn,$sql26) or die(mysqli_error());
$rs26 = mysqli_fetch_assoc($qry26);
	

$strSQL1 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$sql58 = "SELECT credit_ckk,credit_thb FROM tb_customer where customer_id  = '".$rs["bill_id"]."'";
$qry58 = mysqli_query($conn,$sql58) or die(mysqli_error());
$rs58 = mysqli_fetch_assoc($qry58);
	
$sql59 = "select pay_in from tb_bank where close_ckk='0' and id  = '".$rs58["credit_ckk"]."'";
$qry59 = mysqli_query($code,$sql59) or die(mysqli_error());
$rs59 = mysqli_fetch_assoc($qry59);
	
	
	
	
$billId = $rs["bill_id"] ?? '';
$today  = date('Y-m-d');

$sql = "
  SELECT COALESCE(SUM(GREATEST(r.unit_cash - COALESCE(p.paid,0), 0)),0) AS sumRemain
  FROM tb_register_data r
  LEFT JOIN (
    SELECT ref_id_off, SUM(amount) AS paid
    FROM tb_receipt_cash
    GROUP BY ref_id_off
  ) p ON p.ref_id_off = r.id_off
  WHERE r.IV_number NOT LIKE '%R%'
    AND r.IV_number NOT LIKE '%ธ%'
    AND r.unit_cash <> '0.00'
    AND (r.ref_sub = '' OR r.ref_sub IS NULL)
    AND (
      r.date_bank IS NULL
      OR r.date_bank = '0000-00-00'
      OR r.date_bank > ?
    )
";

$types = "s";
$params = [$today];

if ($billId !== '') {
  $sql .= " AND r.bill_id = ?";
  $types .= "s";
  $params[] = $billId;
}

$stmt = mysqli_prepare($code, $sql);
mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

$sumRemain = (float)($row['sumRemain'] ?? 0);

$credit_sum = $rs58["credit_thb"]-$sumRemain;
$creditRemain = (float)($credit_sum ?? 0);	
$hasCreditCustomer = !empty($rs58["credit_thb"]) && (float)$rs58["credit_thb"] > 0;	

	 ?>


<form action='register_salehos_edit1.php' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
<script language="javascript">
function fncSubmit()
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
		
		if(document.frmMain.province_name.value == ""){
		alert('กรุณาเลือกจังหวัดที่ต้องการจัดส่ง');
		document.frmMain.province_name.focus();
		return false;
		}
		
	
	document.frmMain.submit();
}


</script>
		

<script>
(function () {
  // ====== ค่าเครดิตจาก PHP ======
  var HAS_CREDIT_CUSTOMER = <?= $hasCreditCustomer ? 'true' : 'false' ?>;
  var CREDIT_REMAIN = <?= json_encode((float)$creditRemain) ?>;

  // ====== modal open/close ======
  window.closeCreditAlert = function () {
    var m = document.getElementById('creditAlertModal');
    if (m) m.style.display = 'none';
  };

  function openCreditAlert(total) {
    var m = document.getElementById('creditAlertModal');
    if (!m) return;

    var elTotal = document.getElementById('m_total');
    var elCredit = document.getElementById('m_credit');
    if (elTotal) elTotal.textContent = format2(total);
    if (elCredit) elCredit.textContent = format2(CREDIT_REMAIN);

    m.style.display = 'block';
  }

  // ====== helpers ======
  function parseNum(v) {
    if (v == null) return 0;
    v = String(v).trim().replace(/,/g, '');
    if (v === '') return 0;
    var n = Number(v);
    return isFinite(n) ? n : 0;
  }

  function format2(n) {
    n = (isFinite(n) ? n : 0);
    return n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  // ====== row calc (ระบบใหม่) ======
  function recalcRow(rowId) {
    var qtyEl   = document.querySelector('.js-qty[data-row="' + rowId + '"]');
    var priceEl = document.querySelector('.js-price[data-row="' + rowId + '"]');
    var discEl  = document.querySelector('.js-disc[data-row="' + rowId + '"]');
    var sumEl   = document.querySelector('.js-sum[data-row="' + rowId + '"]');
    if (!qtyEl || !priceEl || !discEl || !sumEl) return;

    var qty   = parseNum(qtyEl.value);
    var price = parseNum(priceEl.value);
    var disc  = parseNum(discEl.value);

    var net = price - disc;
    if (net < 0) net = 0;

    var sum = qty * net;
    sumEl.value = format2(sum);
  }

  // ====== total calc (รวมใหม่ + เดิม) ======
  function calcGrandTotal() {
    var total = 0;

    // 1) รวมจากระบบใหม่ (.js-sum)
    document.querySelectorAll('.js-sum').forEach(function (el) {
      total += parseNum(el.value);
    });

    // 2) รวมจากระบบเดิม (sum_amount6..20)
    for (var i = 6; i <= 20; i++) {
      var el = document.getElementById('sum_amount' + i);
      if (el) total += parseNum(el.value);
    }

    // (ถ้ามีช่อง total ให้ใส่ด้วย)
    var out = document.getElementById('sum_amount_total');
    if (out) out.value = format2(total);

    return total;
  }

  // ====== credit check ======
  var _isModalOpen = false;

  function checkCredit() {
    if (!HAS_CREDIT_CUSTOMER) return;

    var total = calcGrandTotal();

    if (total > CREDIT_REMAIN) {
      if (!_isModalOpen) {
        openCreditAlert(total);
        _isModalOpen = true;
      } else {
        // อัปเดตตัวเลขใน modal ระหว่างพิมพ์
        var elTotal = document.getElementById('m_total');
        if (elTotal) elTotal.textContent = format2(total);
      }
    } else {
      if (_isModalOpen) {
        closeCreditAlert();
        _isModalOpen = false;
      }
    }
  }

  // ====== events (ระบบใหม่) ======
  document.addEventListener('input', function (e) {
    var t = e.target;
    if (!t) return;

    if (t.classList.contains('js-qty') || t.classList.contains('js-price') || t.classList.contains('js-disc')) {
      var rowId = t.getAttribute('data-row');
      if (rowId) recalcRow(rowId);
      checkCredit();
    }

    // ====== events (ระบบเดิม) ======
    // ถ้าเป็นช่องที่เกี่ยวกับแถวเดิมแล้วมีการพิมพ์ ให้เช็คเครดิตด้วย
    if (t.id && (
        /^sum_amount(\d+)$/.test(t.id) ||
        /^sale_count(\d+)$/.test(t.id) ||
        /^product_price(\d+)$/.test(t.id) ||
        /^discount_unit(\d+)$/.test(t.id)
      )) {
      // ไม่ยุ่งคำนวณ sum_amount (เพราะของเดิมมักคำนวณอยู่แล้ว)
      // แค่เช็คเครดิตให้เด้งได้
      checkCredit();
    }
  });

  document.addEventListener('blur', function (e) {
    var t = e.target;
    if (!t) return;

    // จัด format 2 ตำแหน่งเฉพาะระบบใหม่ price/discount
    if (t.classList.contains('js-price') || t.classList.contains('js-disc')) {
      t.value = format2(parseNum(t.value));
      var rowId = t.getAttribute('data-row');
      if (rowId) recalcRow(rowId);
      checkCredit();
    }

    // ระบบเดิม: ถ้า blur ที่ราคา/ส่วนลด/ยอดรวม ก็เช็คเครดิตอีกรอบ
    if (t.id && (
        /^product_price(\d+)$/.test(t.id) ||
        /^discount_unit(\d+)$/.test(t.id) ||
        /^sum_amount(\d+)$/.test(t.id)
      )) {
      checkCredit();
    }
  }, true);

  // ====== initial load ======
  window.addEventListener('load', function () {
    // คำนวณระบบใหม่ก่อน 1 รอบ
    document.querySelectorAll('.js-qty[data-row]').forEach(function (el) {
      var rowId = el.getAttribute('data-row');
      if (rowId) recalcRow(rowId);
    });

    // แล้วเช็คเครดิต
    checkCredit();
  });
})();
</script>

		<div class="w3-white" >  
		<div class="w3-container w3-padding-large"><!-- main div -->


			<div class="w3-container w3-bar w3-light-gray w3-margin-bottom">
		
		<div class="w3-half">
					<h4>EDIT Sale Order</h4>
				</div>
				<div class="w3-half">
		<?php if($rs["send_sup"]=='0'){ ?>			
<a href="sendmail_approveso.php?ref_id=<?php echo $rs["ref_id"];?>&sale_code=<?php echo $_SESSION["code"]; ?>" target="_blank" class="w3-button w3-yellow w3-right"><font color="red">ส่งใบสั่งขายให้ Sup อนุมัติ</font></a>&nbsp;&nbsp;
					
					
					<?php } ?>
		
<a href="report_salehosptl2.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="purple">แบบฟอร์มใบสั่งขาย</font></a><br />

				</div>
			</div>


<div class="w3-bar">

	<?php if($rs["type_doc"]=='3'){ ?>
<input type="radio" checked='checked' name="type_doc" value = "3">&nbsp;ใบสั่งขาย AWL
<input type="radio" name="type_doc"  value="4" >&nbsp;ใบสั่งขาย NBM
<?php }else if($rs["type_doc"]=='4'){ ?>

<input type="radio"  name="type_doc" value = "3">&nbsp;ใบสั่งขาย AWL
<input type="radio" name="type_doc" checked='checked' value="4" >&nbsp;ใบสั่งขาย NBM

			<?php } ?>
	
&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($rs["ic_ckk"]=='1'){ ?>	
<input type="checkbox" name="ic_ckk" checked='checked' id="ic_ckk" value="1" > 
<?php }else{ ?>	
<input type="checkbox" name="ic_ckk" id="ic_ckk" value="1" > 	
<?php } ?>	
	<font color='blue'>ใบฝากขาย</font>	
	
&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($rs["et_ckk"]=='1'){ ?>	
<input type="checkbox" name="et_ckk" checked='cheched' id="et_ckk" value="1" > <font color='blue'>ขอบิล E-Tax</font>
<?php }else{ ?>		
<input type="checkbox" name="et_ckk" id="et_ckk" value="1" > <font color='blue'>ขอบิล E-Tax</font>
<?php } ?>
	
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $rs["ref_id"]; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $rs["ref_id"]; ?>" >
	
	
	
	
	
	</div>

</p>
			
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
   data-bill-id="<?= htmlspecialchars($bill_id, ENT_QUOTES) ?>"
   onclick="openDayModal(this.dataset.billId); return false;">
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

วันที่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name = "date_so" id="date_so" value="<?php echo $rs["date_so"];?>" class = "button4"> 		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		<?php if($rs["have_order"]=='1'){ ?>
				
				<input type="checkbox" name="have_order" checked='checked' value="1" > ออเดอร์ฝาก
				
				<?php }else{ ?>
				
				<input type="checkbox" name="have_order"  value="1" >ออเดอร์ฝาก
				<?php } ?>
		
		
		<?php if($rs["que_ckk"]=='1'){ ?>
				
				<input type="checkbox" name="que_ckk" id="que_ckk" value="1" checked ='checked' ><font color='red' > งานด่วน </font>
				
				<?php }else{ ?>
				
				<input type="checkbox" name="que_ckk" id="que_ckk" value="1" ><font color='red' > งานด่วน </font>
				<?php } ?>
			<?php if($rs["plan_ckk"]=='1'){ ?>
				
				<input type="checkbox" name="plan_ckk" id="plan_ckk" value="1" checked ='checked' > ไม่มีในประมาณการ Sale Report
				
				<?php }else{ ?>
				
				<input type="checkbox" name="plan_ckk" id="plan_ckk" value="1" > ไม่มีในประมาณการ Sale Report
				<?php } ?>
					
				
				</p>





ชื่อผู้แนะนำ/ร.พ./แผนก  : &nbsp;<input type="text" name="suggest" class="button4" value="<?php echo $rs["suggest"];?>" style="width:30%;" required> </p>

รหัสลูกค้า  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='text' name = "bill_id"  id = "bill_id" value = "<?php echo $rs["bill_id"]; ?>" class="button4" placeholder="Search ชื่อลูกค้า..."  style="width:30%;" OnChange="JavaScript:doCallAjax1('bill_id','bill_name','bill_address','bill_tel','tax_id','pre_name','mode_name','email','customer_typename');"/> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>
<input type='hidden' name = "mode_name" value="<?php echo $rs["mode_cus"];?>"  id = "mode_name" style="width:30%;" class="button4" >			
</p>

คำนำหน้าชื่อ  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text' name = "pre_name" value="<?php echo $rs["pre_name"];?>"  id = "pre_name" style="width:30%;" class="button4" >				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
ชื่อที่ต้องการออกบิล :&nbsp; <input type="text" value="<?php echo $rs["bill_name"];?>" name="bill_name" id="bill_name" class="button4" style="width:30%;"  > </p>

ที่อยู่ที่ใช้ในการออกบิล : &nbsp; <textarea rows="2" name="bill_address" id ="bill_address" class="button4" style="width:30%" ><?php echo $rs["bill_address"];?></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
				เบอร์โทรศัพท์ :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="bill_tel" id="bill_tel" class="button4" value="<?php echo $rs["bill_tel"];?>" style="width:30%;" ></p>

<?php if ($rs["full_bill"]=='1'){ ?>

<input type="checkbox" name="full_bill" checked='checked' value="1"> &nbsp;บิล VAT
<?php }else{ ?>
<input type="checkbox" name="full_bill" value="1"> &nbsp;บิล VAT

	<?php } ?>

 &nbsp;&nbsp;
เลขประจำตัวผู้เสียภาษี :&nbsp;&nbsp;&nbsp;<input type="text" name="tax_id" id = 'tax_id' value = "<?php echo $rs["tax_id"]; ?>" class="button4" style="width:22%;" >
&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
E-Mail :  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; 	<input name="email"  id="email" class="button4" value="<?php echo $rs["email"]; ?>" style="width:22%;">

</p>

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
<input name="ref_des" id="ref_des" value="<?php echo $rs23["ref_des"]; ?>" class="button4" style="width:20%">
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
<input type="text" name="payment_des" id="payment_des" value ="<?php echo $rs["payment_des"];?>" class="button4" style="width:30%;"  placeholder="ระบุในการณีเลือกอื่นๆ..."> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
เลขที่ใบงานบริการ &nbsp;:
<input name="cm_no" id="cm_no"  value ="<?php echo $rs["cm_no"];?>" class="button4" style="width:30%"></p>
วันที่โอนเงิน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name = "date_tranfer" id="date_tranfer" value ="<?php echo $rs["date_tranfer"];?>" class = "button4"></p>


ใบสั่งซื้อเลขที่:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="po_no" class="button4" value ="<?php echo $rs["po_no"];?>" style="width:30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
กำหนดส่งตามสัญญา :
<input name="delivery_contract" type='date' value ="<?php echo $rs["delivery_contract"];?>"  class="button4" style="width:30%"  placeholder="กรุณาระบุเป็นวันที่เท่านั้น !!!"> </p>

<?php if($rs["book_clear"]=='1'){ ?>
<input type="checkbox" name="book_clear" checked="checked" value="1">&nbsp; เคลียร์ใบจอง :
<?php }else{ ?>
<input type="checkbox" name="book_clear" value="1">&nbsp; เคลียร์ใบจอง :

	<?php } ?>



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="book_no" value ="<?php echo $rs["book_no"];?>"  class="button4" placeholder="เลขที่" style="width:30%">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php if($rs["brn_clear"]=='1'){ ?>
<input type="checkbox" name="brn_clear" checked='checked' value="1">&nbsp;เคลียร์ใบยืมสินค้า ติดเล่ม  :
<?php }else{ ?>
<input type="checkbox" name="brn_clear" value="1">&nbsp;เคลียร์ใบยืมสินค้า ติดเล่ม  :

<?php } ?>
<input name="brn_no" value ="<?php echo $rs["brn_no"];?>"  class="button4" style="width:27%" placeholder="เลขที่" ></p>

<?php if($rs["brnp_clear"]=='1'){ ?>

<input type="checkbox" name="brnp_clear" checked='checked' value="1">&nbsp;เคลียร์ใบยืมสินค้า กระดาษต่อเนื่อง :&nbsp;

<?php }else{ ?>

<input type="checkbox" name="brnp_clear" value="1">&nbsp;เคลียร์ใบยืมสินค้า กระดาษต่อเนื่อง :&nbsp;

<?php } ?>

<input name="brnp_no" value ="<?php echo $rs["brnp_no"];?>"  class="button4" style="width:23%" placeholder="เลขที่" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

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
<input name="pr_no" class="button4"  value ="<?php echo $rs["pr_no"];?>" style="width:28%" placeholder="เลขที่"></p>


</p>

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
<textarea name="comment_cs"  class="w3-input" style="width:90%" id="comment_cs"  rows="2"><?php echo $rs26["comment_cs"]; ?></textarea>	
	
ช่าง :
<textarea name="comment_en"  class="w3-input" style="width:90%" id="comment_en"  rows="2"><?php echo $rs26["comment_en"]; ?></textarea>	
	
คลังสินค้า :
<textarea name="comment_st"  class="w3-input" style="width:90%" id="comment_st"  rows="2"><?php echo $rs26["comment_st"]; ?></textarea>	
	
Admin :
<textarea name="comment_ad"  class="w3-input" style="width:90%" id="comment_ad"  rows="2"><?php echo $rs26["comment_ad"]; ?></textarea>	

<br></fieldset>	<br>

</p>
แนบไฟล์ </p>
<input type='hidden' name='slip1' id='slip1' value ="<?php echo $rs['slip1']; ?>"  />
<input type='hidden' name='slip2' id='slip2' value ="<?php echo $rs['slip2']; ?>"  />
<input type='hidden' name='slip3' id='slip3' value ="<?php echo $rs['slip3']; ?>"  />
<input type='hidden' name='slip4' id='slip4' value ="<?php echo $rs['slip4']; ?>"  />
<input type='hidden' name='slip5' id='slip5' value ="<?php echo $rs['slip5']; ?>"  />

<input name="slip1"  type="file"><a href="upload/<?php echo $rs['slip1']; ?>" target="_blank"><?php echo $rs['slip1']; ?></a>

</p>

<input name="slip2"  type="file"><a href="upload/<?php echo $rs['slip2']; ?>" target="_blank"><?php echo $rs['slip2']; ?></a>
</p>
<input name="slip3"  type="file"><a href="upload/<?php echo $rs['slip3']; ?>" target="_blank"><?php echo $rs['slip3']; ?></a>
</p>
<input name="slip4"  type="file"><a href="upload/<?php echo $rs['slip4']; ?>" target="_blank"><?php echo $rs['slip4']; ?></a>
</p>
<input name="slip5"  type="file"><a href="upload/<?php echo $rs['slip5']; ?>" target="_blank"><?php echo $rs['slip5']; ?></a>
</p>
<?php
if($_SESSION["department"]=='วิศวกรรม'){
	?>

&nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk_1" id="ckk_1" onClick="ck_1();" value="1"/>ใบปะหน้ากล่อง<br/>
<div id="frm_txt_1" style="display:none;">

			<div class="w3-bar w3-half 1">
				<a href="report_h99std.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5ptl.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5ptl_k.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4ptl.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4ptl_k.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl+k</font></a>
			</div>
		<div class="w3-bar w3-half 4">
				<a href="report_ha5nbm.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_ha5nbm_k.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_ha4nbm.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_ha4nbm_k.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม1)</b></legend>	
<div class="w3-bar w3-half 1">
				<a href="report_h99std1.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k1.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5all1.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5all_k1.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4all1.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4all_k1.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4+k</font></a>
			</div>
			

</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม2)</b></legend>	

<div class="w3-bar w3-half 1">
				<a href="report_h99std2.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k2.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5all2.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5all_k2.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4all2.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4all_k2.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4+k</font></a>
			</div>



</fieldset></p>


</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม3)</b></legend>	


<div class="w3-bar w3-half 1">
				<a href="report_h99std3.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k3.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5all3.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5all_k3.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4all3.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4all_k3.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4+k</font></a>
			</div>


</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม4)</b></legend>	

<div class="w3-bar w3-half 1">
				<a href="report_h99std4.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k4.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5all4.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5all_k4.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4all4.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4all_k4.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4+k</font></a>
			</div>


</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม5)</b></legend>	

<div class="w3-bar w3-half 1">
				<a href="report_h99std5.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k5.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5all5.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5all_k5.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4all5.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4all_k5.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4+k</font></a>
			</div>


</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม6)</b></legend>	

<div class="w3-bar w3-half 1">
				<a href="report_h99std6.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k6.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5all6.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5all_k6.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4all6.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4all_k6.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4+k</font></a>
			</div>


</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม7)</b></legend>	

<div class="w3-bar w3-half 1">
				<a href="report_h99std7.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k7.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5all7.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5all_k7.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4all7.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4all_k7.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4+k</font></a>
			</div>


</fieldset><br>

<br><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม8)</b></legend>	

<div class="w3-bar w3-half 1">
				<a href="report_h99std8.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k8.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5all8.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5all_k8.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4all8.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4all_k8.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4+k</font></a>
			</div>


</fieldset><br>

<br><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม9)</b></legend>	

<div class="w3-bar w3-half 1">
				<a href="report_h99std9.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k9.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5all9.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5all_k9.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4all9.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4all_k9.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4+k</font></a>
			</div>


</fieldset><br>
</div>
<?php } ?>


<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity1('cs1')"><font color="#404040"><b>การจัดส่ง(เพิ่มเติม)</b></font></a>

</div>

<div id="pd" class="w3-container city1" >
<?php
function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function nf($n) { return number_format((float)$n, 2); }

function renderTableHead($isEngineer = false) {
    ?>
    <thead>
        <tr>
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
            <th>เคลียร์ยืม</th>
            <th>เคลียร์จอง</th>
            <?php if ($isEngineer) : ?>
                <th></th>
            <?php endif; ?>
        </tr>
    </thead>
    <?php
}

function renderRow($row, $rs, $isEngineer = false, $deleteUrl = null, $deleteParams = []) {
    $id = $row['id'];

    // ใช้ class เดิมของคุณ: วิศวกรรม = w3-input / อื่น ๆ = button4 บางช่อง
    $codeClass  = $isEngineer ? 'w3-input' : 'button4';
    $nameClass  = $isEngineer ? 'w3-input' : 'button4';
    $moneyClass = $isEngineer ? 'w3-input' : 'button4';

    $warranty = (string)($row['warranty'] ?? '');
    $ggfgf = substr($warranty, 0, 1);
    $warHos = $row['war_hos'] ?? null;

    $warrantyStyle = '';
    if ($warHos !== null && $warHos < $ggfgf) {
        $warrantyStyle = "border:1px #CC0033 solid; color:red; text-align:center";
    }

    $canDelete = ($rs['status_doc'] ?? '') === 'Request' && !empty($deleteUrl);

    ?>
    <tr>
        <td style="width:10%;">
            <input type="hidden" name="id[<?=h($id)?>]" value="<?=h($id)?>" class="w3-input w3-center">
            <input type="hidden" name="product_id[<?=h($id)?>]" value="<?=h($row['product_id'] ?? '')?>" class="w3-input w3-center">

            <input
                type="text"
                name="product_code[<?=h($id)?>]"
                id="product_code[<?=h($id)?>]"
                value="<?=h($row['access_code'] ?? $row['bom_code'] ?? '')?>"
                size="5"
                class="<?=h($codeClass)?>"
            />
        </td>

        <td style="width:15%;">
            <textarea
                name="product_name[<?=h($id)?>]"
                id="product_name[<?=h($id)?>]"
                class="<?=h($nameClass)?>"
                readonly
            ><?=h($row['sol_name'] ?? $row['bom_name'] ?? '')?></textarea>
        </td>

        <td style="width:5%;">
            <input type="text" name="unit_name[<?=h($id)?>]" id="unit_name[<?=h($id)?>]"
                   value="<?=h($row['unit_name'] ?? '')?>" class="w3-input" readonly>
        </td>

        <td style="width:5%;">
           <input type="text"
  name="sale_count[<?=h($id)?>]"
  id="sale_count[<?=h($id)?>]"
  value="<?=h($row['count'] ?? '')?>"
  class="w3-input js-qty"
  data-row="<?=h($id)?>"
  style="color:black;text-align:center">

        </td>

        <td style="width:8%;">
           <input type="text"
  name="product_price[<?=h($id)?>]"
  id="product_price[<?=h($id)?>]"
  value="<?=h(nf($row['price'] ?? 0))?>"
  class="<?=h($moneyClass)?> js-price"
  data-row="<?=h($id)?>"
  style="color:black;text-align:right"
  size="7">

        </td>

        <td style="width:8%;">
           <input type="text"
  name="discount_unit[<?=h($id)?>]"
  id="discount_unit[<?=h($id)?>]"
  value="<?=h(nf($row['discount'] ?? 0))?>"
  class="<?=h($moneyClass)?> js-disc"
  data-row="<?=h($id)?>"
  style="color:black;text-align:right"
  size="5">
        </td>

        <td style="width:8%;">
            <input type="text"
  name="sum_amount[<?=h($id)?>]"
  id="sum_amount[<?=h($id)?>]"
  value="<?=h(nf($row['amount'] ?? 0))?>"
  class="<?=h($moneyClass)?> js-sum"
  data-row="<?=h($id)?>"
  style="color:black;text-align:right"
  size="7"
  readonly>
        </td>

        <td style="width:5%;">
            <input type="text" name="warranty[<?=h($id)?>]" id="warranty[<?=h($id)?>]"
                   value="<?=h($warranty)?>" class="w3-input" style="<?=h($warrantyStyle)?>">

            <?php if (!empty($row['remark_hos'])) : ?>
                <textarea name="des_war[<?=h($id)?>]" id="des_war[<?=h($id)?>]" class="w3-input"><?=h($row['remark_hos'])?></textarea>
            <?php endif; ?>
        </td>

        <td style="width:5%;">
            <input type="text" name="cal[<?=h($id)?>]" id="cal[<?=h($id)?>]"
                   value="<?=h($row['cal'] ?? '')?>" class="w3-input" onkeypress="return chkNumber(this)">
        </td>

        <td style="width:5%;">
            <input type="text" name="pm[<?=h($id)?>]" id="pm[<?=h($id)?>]"
                   value="<?=h($row['pm'] ?? '')?>" class="w3-input" onkeypress="return chkNumber(this)">
        </td>

        <td style="width:10%;">
            <textarea name="sn[<?=h($id)?>]" id="sn[<?=h($id)?>]" class="w3-input"><?=h($row['sn'] ?? '')?></textarea>
        </td>

        <td style="width:10%;">
            <?php if ($isEngineer) : ?>
                <input type="text" name="sale_remarkk[<?=h($id)?>]" id="sale_remarkk[<?=h($id)?>]"
                       value="<?=h($row['sale_remark'] ?? '')?>" class="w3-input">
            <?php else : ?>
                <textarea name="sale_remarkk[<?=h($id)?>]" id="sale_remarkk[<?=h($id)?>]" class="w3-input"><?=h($row['sale_remark'] ?? '')?></textarea>
            <?php endif; ?>
        </td>

        <td style="width:8%;">
            <input type="checkbox" name="clear_br[<?=h($id)?>]" id="clear_br[<?=h($id)?>]"
                   value="1" <?=($row['clear_br'] ?? '')=='1' ? "checked" : ""?>>
            <input type="text" name="clear_ivno[<?=h($id)?>]" id="clear_ivno[<?=h($id)?>]"
                   value="<?=h($row['clear_ivno'] ?? '')?>" placeholder="เลขที่ใบยืม" class="w3-input">
        </td>

        <td style="width:8%;">
            <input type="checkbox" name="jong_ckk[<?=h($id)?>]" id="jong_ckk[<?=h($id)?>]"
                   value="1" <?=($row['jong_ckk'] ?? '')=='1' ? "checked" : ""?>>
            <input type="text" name="jong_no[<?=h($id)?>]" id="jong_no[<?=h($id)?>]"
                   value="<?=h($row['jong_no'] ?? '')?>" placeholder="เลขที่ใบจอง" class="w3-input">
        </td>

        <?php if ($canDelete) : ?>
            <td style="width:2%;">
                <?php
                $qs = http_build_query($deleteParams + ['id' => $id]);
                ?>
                <a href="<?=h($deleteUrl . '?' . $qs)?>">
                    <img src="img/false.png" width="16" height="16" border="0" alt="delete">
                </a>
            </td>
        <?php elseif ($isEngineer) : ?>
            <td style="width:2%;"></td>
        <?php endif; ?>
    </tr>
    <?php
}

// ------------------ MAIN ------------------
$isEngineer = ($_SESSION['department'] ?? '') === 'วิศวกรรม';
?>

<table width="100%" border="0" class="w3-table">
    <?php renderTableHead($isEngineer); ?>
    <tbody>
    <?php
    while ($row = mysqli_fetch_array($objQuery1)) {

        if (!$isEngineer) {
            // research_ckk logic เดิม
            $strSQL2 = "SELECT research_ckk FROM tb_product WHERE product_ID = '".mysqli_real_escape_string($conn, $row['product_id'])."' ";
            $objQuery2 = mysqli_query($conn, $strSQL2);
            $objResult2 = mysqli_fetch_array($objQuery2);

            if (($objResult2['research_ckk'] ?? '') === '1') {
                mysqli_query($conn, "UPDATE hos__so SET reseach_kk='1' WHERE ref_id='".mysqli_real_escape_string($conn, $rs['ref_id'])."' ");
                mysqli_query($conn, "UPDATE tb_register_data SET mk_research='1' WHERE ref_id='".mysqli_real_escape_string($conn, $rs['ref_id'])."' ");
            }

            // แสดงเฉพาะ bom_ckk = 0 (เหมือนเดิม)
            if (($row['bom_ckk'] ?? '') !== '0') {
                continue;
            }
        }

        // delete link (ของเดิม: วิศวกรรมใช้ producthos_delete.php, อื่น ๆ ใช้ producthos_delete.php)
        $deleteUrl = $isEngineer ? 'producthos_delete.php' : 'producthos_delete.php';
        $deleteParams = [
            'ref_id' => $rs['ref_id'],
            'code'   => $_SESSION['type_login'] ?? ''
        ];

        renderRow($row, $rs, $isEngineer, $deleteUrl, $deleteParams);
    }
    ?>
    </tbody>
</table>

<?php
// include ตาม type_doc เหมือนเดิม
if ($isEngineer) {
    if (($rs['type_doc'] ?? '') == '3') include('product_engineer1.php');
    else if (($rs['type_doc'] ?? '') == '4') include('product_engineernb1.php');
} else {
    if (($rs['type_doc'] ?? '') == '3') include('product_salehos1.php');
    else if (($rs['type_doc'] ?? '') == '4') include('product_salehosnb1.php');
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
     
<input name="start_date" type='text' id="start_date" class="button4" style="width:20%"  value="<?php echo $fetch1["start_date"]; ?>" /><a href="javascript:displayDatePicker('start_date')"> <img src="img/formcal.gif" alt="" width="20" height="20" border="0" /></a>
</p>


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


	
</div><!-- cs -->

<div id="cs1" class="w3-container city1" style="display:none">

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม1)</b></legend>	
	
	
<?php
	
	$sql2 = "select * from tb_transaction where ref_id = '".$_GET["ref_id"]."'";
	$query2 = mysqli_query($conn,$sql2);
	$fetch2 = mysqli_fetch_array($query2,MYSQLI_ASSOC); 
	
$strSQL = "SELECT *  FROM tb_delivery_print where ref_id = '".$_GET["ref_id"]."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

	
	?>
	

ชื่อผู้ติดต่อ 1  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name1"  class="button4" type='text' id="customer_name1"  value="<?php echo $objResult["customer_name1"]; ?>" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 1 :
<input name="customer_tel1"  class="button4" type='text' id="customer_tel1" value="<?php echo $objResult["customer_tel1"]; ?>" >
</p>

ที่อยู่ในการส่งสินค้า 1 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name1" id="address_name1" style="width:30%" value="<?php echo $objResult["address_name1"]; ?>" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม2)</b></legend>	

ชื่อผู้ติดต่อ 2  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name2"  class="button4" type='text' id="customer_name2" value="<?php echo $objResult["customer_name2"]; ?>" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 2 :
<input name="customer_tel2"  class="button4" type='text' id="customer_tel2" value="<?php echo $objResult["customer_tel2"]; ?>" >
</p>

ที่อยู่ในการส่งสินค้า 2 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name2" id="address_name2" style="width:30%" value="<?php echo $objResult["address_name2"]; ?>" >  
</p>
</fieldset></p>


</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม3)</b></legend>	

ชื่อผู้ติดต่อ 3  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name3"  class="button4" type='text' id="customer_name3" value="<?php echo $objResult["customer_name3"]; ?>" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 3 :
<input name="customer_tel3"  class="button4" type='text' id="customer_tel3" value="<?php echo $objResult["customer_tel3"]; ?>" >
</p>

ที่อยู่ในการส่งสินค้า 3 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name3" id="address_name3" style="width:30%" value="<?php echo $objResult["address_name3"]; ?>" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม4)</b></legend>	

ชื่อผู้ติดต่อ 4  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name4"  class="button4" type='text' id="customer_name4" value="<?php echo $objResult["customer_name4"]; ?>" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 4 :
<input name="customer_tel4"  class="button4" type='text' id="customer_tel4" value="<?php echo $objResult["customer_tel4"]; ?>" >
</p>

ที่อยู่ในการส่งสินค้า 4 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name4" id="address_name4" style="width:30%" value="<?php echo $objResult["address_name4"]; ?>" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม5)</b></legend>	

ชื่อผู้ติดต่อ 5  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name5"  class="button4" type='text' id="customer_name5" value="<?php echo $objResult["customer_name5"]; ?>" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 5 :
<input name="customer_tel5"  class="button4" type='text' id="customer_tel5" value="<?php echo $objResult["customer_tel5"]; ?>" >
</p>

ที่อยู่ในการส่งสินค้า 5 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name5" id="address_name5" style="width:30%" value="<?php echo $objResult["address_name5"]; ?>" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม6)</b></legend>	

ชื่อผู้ติดต่อ 6  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name6"  class="button4" type='text' id="customer_name6" value="<?php echo $objResult["customer_name6"]; ?>" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 6 :
<input name="customer_tel6"  class="button4" type='text' id="customer_tel6" value="<?php echo $objResult["customer_tel6"]; ?>" >
</p>

ที่อยู่ในการส่งสินค้า 6 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name6" id="address_name6" style="width:30%"  value="<?php echo $objResult["address_name6"]; ?>" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม7)</b></legend>	

ชื่อผู้ติดต่อ 7  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name7"  class="button4" type='text' id="customer_name7" value="<?php echo $objResult["customer_name7"]; ?>" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 7 :
<input name="customer_tel7"  class="button4" type='text' id="customer_tel7" value="<?php echo $objResult["customer_tel7"]; ?>" >
</p>

ที่อยู่ในการส่งสินค้า 7 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name7" id="address_name7" style="width:30%" value="<?php echo $objResult["address_name7"]; ?>" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม8)</b></legend>	

ชื่อผู้ติดต่อ 8  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name8"  class="button4" type='text' id="customer_name8" value="<?php echo $objResult["customer_name8"]; ?>" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 8 :
<input name="customer_tel8"  class="button4" type='text' id="customer_tel8" value="<?php echo $objResult["customer_tel8"]; ?>" >
</p>

ที่อยู่ในการส่งสินค้า 8 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name8" id="address_name8" style="width:30%" value="<?php echo $objResult["address_name8"]; ?>" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม9)</b></legend>	

ชื่อผู้ติดต่อ 9  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name9"  class="button4" type='text' id="customer_name9" value="<?php echo $objResult["customer_name9"]; ?>" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 9 :
<input name="customer_tel9"  class="button4" type='text' id="customer_tel9" value="<?php echo $objResult["customer_tel9"]; ?>" >
</p>

ที่อยู่ในการส่งสินค้า 9 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name9" id="address_name9" style="width:30%"  value="<?php echo $objResult["address_name9"]; ?>" >  
</p>
</fieldset></p>

	
	</div>


</p>
<?php //if($rs["status_doc"]=='Request'){ ?>
<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>

<?php //} ?>
 </div> </div>
</form>

 <div id="creditAlertModal" style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,.5);">
  <div style="position:relative;margin:10vh auto;width:min(680px,92vw);background:#fff;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.25);overflow:hidden;">
    <button type="button" onclick="window.location.href='status_salehos.php';" style="position:absolute;right:14px;top:10px;border:0;background:transparent;font-size:40px;cursor:pointer;">×</button>

    <div style="padding:28px 18px 10px;text-align:center;">
      <!-- icon -->
      <div style="width:74px;margin:0 auto 10px;">
        <svg viewBox="0 0 100 100" width="74" height="74" aria-hidden="true">
          <path d="M50 10 L95 90 H5 Z" fill="#ff3b30"/>
          <rect x="46" y="33" width="8" height="30" rx="4" fill="#fff"/>
          <circle cx="50" cy="73" r="5" fill="#fff"/>
        </svg>
      </div>

      <div style="font-size:28px;font-weight:800;margin-bottom:10px;">กรุณาติดต่อบัญชี</div>
      <div style="font-size:15px;line-height:1.5;color:#333;margin-bottom:10px;">
        เพื่อขอเพิ่มวงเงิน เนื่องจากยอดรวมสินค้าเกินวงเงินคงเหลือ
      </div>

      <div style="font-size:16px;margin:10px 0 4px;">
        ยอดรวมสินค้า : <b id="m_total">0.00</b>
      </div>
      <div style="font-size:16px;margin:0 0 18px;">
        วงเงินคงเหลือ : <b id="m_credit">0.00</b>
      </div>

      <button type="button"
  onclick="window.location.href='status_salehos.php';"
  style="margin:0 auto 18px;display:inline-block;border:0;background:#5a2ca0;color:#fff;border-radius:28px;padding:10px 26px;cursor:pointer;font-size:14px;">
  กลับสู่หน้าหลัก
</button>

    </div>
  </div>
</div>
 


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
document.addEventListener('DOMContentLoaded', () => {
  const more = document.getElementById('more');
  const box  = document.getElementById('more-2');
  if (!more || !box) return;

  const toggle = () => { box.style.display = more.checked ? 'block' : 'none'; };
  more.addEventListener('change', toggle);
  toggle(); // เซ็ตค่าเริ่มต้น
});
</script>
