<?php include ("head.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
var HttPRequest = false;

function doCallAjax1(bill_id,bill_name,bill_address,bill_tel,tax_id,pre_name,mode_name,email,customer_typename,payment,credit_thb) {
  HttPRequest = false;
  if (window.XMLHttpRequest) {
    HttPRequest = new XMLHttpRequest();
    if (HttPRequest.overrideMimeType) HttPRequest.overrideMimeType('text/html');
  } else if (window.ActiveXObject) {
    try { HttPRequest = new ActiveXObject("Msxml2.XMLHTTP"); }
    catch (e) { try { HttPRequest = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {} }
  }
  if (!HttPRequest) { alert('Cannot create XMLHTTP instance'); return false; }

  var url = 'data_bill_name1.php';
  var pmeters = "bill_id=" + encodeURIComponent(document.getElementById(bill_id).value);
  HttPRequest.open('POST', url, true);
  HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  HttPRequest.setRequestHeader("Content-length", pmeters.length);
  HttPRequest.setRequestHeader("Connection", "close");
  HttPRequest.send(pmeters);

  HttPRequest.onreadystatechange = function() {
    if (HttPRequest.readyState === 4) {
      // 200 เท่านั้นถึงจะประมวลผล (กัน error เงียบๆ)
      if (HttPRequest.status !== 200) { console.error('XHR error', HttPRequest.status); return; }

      var myProduct = HttPRequest.responseText || '';
      if (myProduct !== "") {
        var myArr = myProduct.split("|");

        document.getElementById(bill_name).value          = myArr[0]  || "";
        document.getElementById(bill_address).value       = myArr[1]  || "";
        document.getElementById(bill_tel).value           = myArr[2]  || "";
        document.getElementById(tax_id).value             = myArr[3]  || "";
        document.getElementById(pre_name).value           = myArr[10] || "";
        document.getElementById(mode_name).value          = myArr[20] || "";
        document.getElementById(email).value              = myArr[21] || "";
        document.getElementById(customer_typename).value  = myArr[22] || "";
        document.getElementById(payment).value            = myArr[23] || "";
        document.getElementById(credit_thb).value         = myArr[24] || "";

        // เก็บ bill_id ที่ค้นหาได้ไว้ใน hidden
        document.getElementById('h_bill_id').value = document.getElementById(bill_id).value;

        // โหลดตัวเลือกช่องทางชำระเงิน:
        // ถ้า payment == '0' ให้กรองเฉพาะ credit (credit_ckk='1') | ถ้าไม่ใช่ โหลดปกติ
        loadBankOptions(((myArr[23] || "") === '0'));

        // ประเมินการแสดง/ซ่อนตารางหนี้ตามเงื่อนไขใหม่
        evaluateDebtPanel();
      }
    }
  };
}

// ----- เงื่อนไขการแสดงตารางหนี้: payment != '0' และมีวงเงิน > 0 -----
function shouldShowDebtPanel() {
  var payVal = (document.getElementById('payment').value || '').trim();
  var creditRaw = (document.getElementById('credit_thb').value || '0').replace(/,/g,'');
  var creditNum = parseFloat(creditRaw) || 0;
  return (payVal !== '0' && creditNum > 0);
}

function evaluateDebtPanel() {
  if (shouldShowDebtPanel()) {
    var cusId = (document.getElementById('h_bill_id').value || '').trim();
    if (cusId) {
      showDebts(cusId);
    } else {
      // ไม่มีลูกค้า -> ซ่อน
      hideDebts();
    }
  } else {
    hideDebts();
  }
}

// โหลด options ช่องทางชำระเงิน
function loadBankOptions(creditOnly) {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'bank_options_nbm.php?credit_only=' + (creditOnly ? '1' : '0'), true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var sel = document.getElementById('payment');
        var prev = sel.value; // เก็บค่าเดิมไว้ (กันเด้ง reset กรณีโหลดใหม่)
        sel.innerHTML = '<option value="">**Please Select Item**</option>' + xhr.responseText;
        // พยายาม restore ค่าเดิม ถ้ายังอยู่ใน options ใหม่
        if ([...sel.options].some(o => o.value === prev)) sel.value = prev;
      } else {
        console.error('โหลดช่องทางชำระเงินไม่สำเร็จ');
      }
    }
  };
  xhr.send();
}

// แสดงตารางหนี้คงค้าง
function showDebts(cusId) {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_debts.php?cus_id=' + encodeURIComponent(cusId), true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        try {
          var res = JSON.parse(xhr.responseText || '{}');

          // ดึงวงเงิน
          var creditInput = document.getElementById('credit_thb').value || '0';
          var credit = parseFloat(String(creditInput).replace(/,/g, '').trim()) || 0;

          // ยอดหนี้
          var rawOutstanding = res.total_outstanding || 0;
          var outstanding = parseFloat(String(rawOutstanding).replace(/,/g, '').trim()) || 0;

          // วงเงินคงเหลือ
          var remain = credit - outstanding;
		  document.getElementById('sum_ca').value = remain;

          // Debug
          console.log('credit =', credit, 
                      'outstanding =', outstanding, 
                      'remain =', remain);

        var billName = document.getElementById('bill_name').value || '-';

if (remain < 0) {
    Swal.fire({
        title: "กรุณาติดต่อบัญชี",
        html:
          "<div style='font-size:16px; text-align:left;'>" +
           
            "<p>เพื่อขอเพิ่มวงเงินของคุณ เนื่องจากวงเงินของคุณไม่เพียงพอ</p>" +
            "<hr>" +
		 "<p><b> " + billName + "</b></p>" +
            "<p><b>วงเงิน: " + numberFormat(credit) + " บาท</b></p>" +
            "<p><b>ยอดวงเงินคงเหลือ:</b> " +
              "<span style='color:red; font-weight:bold;'>" +
                numberFormat(remain) + " บาท" +
              "</span>" +
            "</p>" +
          "</div>",
        icon: "warning",
        confirmButtonText: "กลับหน้าหลัก",
    }).then(() => {
        window.location.href = "main_salehos_so.php";
    });

    return;
}

          // Summary
          var summaryHtml = `
            <div style="margin-bottom:16px; font-weight:bold;">
              วงเงิน: ${numberFormat(credit)} |
              ยอดวงเงินคงเหลือ:
              <span style="color:${remain < 0 ? 'red' : 'green'};">
                ${numberFormat(remain)}
              </span>
            </div>
          `;

          // แสดงผล
          document.getElementById('debt_table_wrap').innerHTML =
            summaryHtml + (res.html || '');
          document.getElementById('debt_panel').style.display = 'block';

        } catch (e) {
          console.error('Parse JSON error', e);
          hideDebts();
        }
      } else {
        console.error('โหลดยอดหนี้คงค้างไม่สำเร็จ');
        hideDebts();
      }
    }
  };
  xhr.send();
}



function hideDebts() {
  document.getElementById('debt_panel').style.display = 'none';
  document.getElementById('debt_table_wrap').innerHTML = '';
  document.getElementById('credit_summary').innerHTML = '';
}

// utility แปลงตัวเลขให้อ่านง่าย
function numberFormat(n) {
  return (Number(n) || 0).toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2});
}

// กรณีผู้ใช้แก้ไขค่า payment เองภายหลัง
document.addEventListener('DOMContentLoaded', function(){
  // เริ่มต้นโหลด options ปกติ
  loadBankOptions(false);

  document.getElementById('payment').addEventListener('change', function() {
    // ถ้าเลือก '0' → โหลดเฉพาะ credit, ถ้าไม่ใช่ → โหลดปกติ
    loadBankOptions(this.value === '0');
    // ประเมินการแสดง/ซ่อนตารางตามเงื่อนไขใหม่
    evaluateDebtPanel();
  });

  // ผู้ใช้แก้ไขวงเงิน -> ประเมินใหม่ (ถ้าวงเงินเป็น 0 จะซ่อน)
  document.getElementById('credit_thb').addEventListener('input', function(){
    evaluateDebtPanel();
  });
});
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



	 ?>


	<!--action="register_office1.php"-->
	<form action='register_salehos1.php' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
		
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
	
	if(document.frmMain.province_name.value == ""){
		alert('กรุณาเลือกจังหวัดที่ต้องการจัดส่ง');
		document.frmMain.province_name.focus();
		return false;
		}
		
	
	document.frmMain.submit();
}


</script>
		<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>Register Sale Order</h4></div>

<div class="w3-bar">
		

<input type="radio" name="type_doc" checked='checked' value="4" >&nbsp;ใบสั่งขาย NBM
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ic_ckk" id="ic_ckk" value="1" > <font color='blue'>ใบฝากขาย</font>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="et_ckk" id="et_ckk" value="1" > <font color='blue'>ขอบิล E-Tax</font>

		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
	</div>

</p>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>


		วันที่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name = "date_so" id="date_so" value="<?php echo $today;?>" class = "button4"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="have_order" id="have_order" value="1" > ออเดอร์ฝาก
	
<input type="checkbox" name="que_ckk" id="que_ckk" value="1" ><font color='red' > งานด่วน </font>
<input type="checkbox" name="plan_ckk" id="plan_ckk" value="1" > ไม่มีในประมาณการ Sale Report
		</p>


ชื่อผู้แนะนำ/ร.พ./แผนก  : &nbsp;<input type="text" name="suggest" class="button4" style="width:30%;" required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				
 </p>
รหัสลูกค้า  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='text' name = "bill_id"  id = "bill_id" class="button4" placeholder="Search ชื่อลูกค้า..."  style="width:30%;" OnChange="JavaScript:doCallAjax1('bill_id','bill_name','bill_address','bill_tel','tax_id','pre_name','mode_name','email','customer_typename','payment','credit_thb');"/> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>
<input type='hidden' name = "mode_name"  id = "mode_name"  class="button4" readonly>

</p>

คำนำหน้าชื่อ  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text' name = "pre_name"  id = "pre_name" style="width:30%;" class="button4" >

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ชื่อที่ต้องการออกบิล :&nbsp; 
				
<input type='text' name = "bill_name"  id = "bill_name" style="width:30%;" class="button4" >
				</p>
			
					ที่อยู่ที่ใช้ในการออกบิล : &nbsp;
					
					<textarea  name = "bill_address"  id = "bill_address" style="width:30%;" rows="2" class="button4" readonly></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
				เบอร์โทรศัพท์ :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input type='text' name = "bill_tel"  id = "bill_tel" style="width:30%;" class="button4" readonly></p>


<input type="checkbox" name="full_bill" value="1"> &nbsp;บิล VAT
 &nbsp;&nbsp;
เลขประจำตัวผู้เสียภาษี :&nbsp;&nbsp;&nbsp;<input type="text" name="tax_id"  id = 'tax_id' class="button4" style="width:22%;" readonly>

&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
E-Mail :  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; 	<input name="email" id="email" class="button4"  style="width:22%;">




</p>


&nbsp;ต้องการเอกสารแนบบิล<br>

<input type="checkbox" name="ref_1"  id="ref_1" value="1"> &nbsp;เตรียมเอกสาร N-Health&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_2"  id="ref_2" value="1"> &nbsp;เตรียมเอกสารตามที่แนบไฟล์&nbsp;&nbsp;&nbsp;
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
<br>

<input type="checkbox" name="ref_12"  id="ref_12" value="1"> &nbsp;ส่งสินค้าด้วยใบรับสินค้า [ไม่ระบุราคา]&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_13"  id="ref_13" value="1"> &nbsp;ไม่ต้องนำใบกำกับภาษี/ใบเสร็จไปส่งสินค้า
</p>
<!-- การชำระเงิน -->
<label>การชำระเงิน :</label>
<select name="payment" id="payment" class="button4" style="width:30%" required>
  <option value="">**Please Select Item**</option>
  <!-- จะถูกเติมด้วย JS จาก bank_options.php -->
</select>

<!-- วงเงิน -->
<!--label>วงเงิน :</label-->
<input type="hidden" name="credit_thb" id="credit_thb" class="button4" style="width:30%;">
<input type="hidden" name="sum_ca" id="sum_ca" class="button4" style="width:30%;">
<input type="hidden" name="sum_amount_total" id="sum_amount_total" value="0">


<!-- พื้นที่ตารางหนี้คงค้าง -->
<div id="debt_panel" style="margin-top:16px; display:none;">
  <h4>ยอดหนี้คงค้าง</h4>
  <div id="debt_table_wrap"></div>
  <div id="credit_summary" style="margin-top:8px; font-weight:600;"></div>
</div>

<?php /*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Sales Comment :&nbsp;
<textarea name="sale_comment"  class="button4" style="width:30%" id="sale_comment"  rows="2"></textarea>*/ ?></p>


เพิ่มเติมการชำระเงิน :&nbsp;&nbsp;
<input type="text" name="payment_des" id="payment_des" class="button4" style="width:30%;"  placeholder="ระบุในการณีเลือกอื่นๆ..."> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
เลขที่ใบงานบริการ &nbsp;:
<input name="cm_no" id="cm_no"   class="button4" style="width:30%"></p>

วันที่โอนเงิน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name = "date_tranfer" id="date_tranfer"  class = "button4"></p>

ใบสั่งซื้อเลขที่:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="po_no" class="button4" style="width:30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
กำหนดส่งตามสัญญา :
<input name="delivery_contract" id="delivery_contract"  type='date' class="button4" style="width:30%" placeholder="กรุณาระบุเป็นวันที่เท่านั้น !!!"  > </p>
<input type="checkbox" name="book_clear" value="1">&nbsp; เคลียร์ใบจอง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="book_no" class="button4" placeholder="เลขที่" style="width:30%">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="brn_clear" value="1">&nbsp;เคลียร์ใบยืมสินค้า ติดเล่ม  :
<input name="brn_no" class="button4" style="width:27%" placeholder="เลขที่" ></p>
<input type="checkbox" name="brnp_clear" value="1">&nbsp;เคลียร์ใบยืมสินค้า กระดาษต่อเนื่อง :&nbsp;
<input name="brnp_no" class="button4" style="width:23%" placeholder="เลขที่" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="sn_no" class="button4" style="width:30%" placeholder="เลขที่"> </p>




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
<a class="w3-bar-item w3-button" onclick="openCity1('cs1')"><font color="#404040"><b>การจัดส่ง(เพิ่มเติม)</b></font></a>

</div>

<div id="pd" class="w3-container city1" >


<?php
	if($_SESSION["department"]=='วิศวกรรม'){
		include ('product_engineernb.php');
	}else{	
	include ('product_salehosnb.php');
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
<input name="customer_typename"  class="button4" type='text' id="customer_typename" >	</p>


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


	<fieldset><legend><input type="checkbox" name="more" id="more" value="1"> <b>รายละเอียดการจัดส่ง</b></legend>
	<div id="more-2" style="display:none;">
		<div class="w3-third 112">
			<div class="w3-bar 1">
				<input type="checkbox" name="runway"id = "runway" value="1"> ติดถนนรันเวย์
			</div>
			<div class="w3-bar 2">
				<input type="checkbox" name="road"id = "road" value="1"> ติดถนนวิ่งสวนกัน
			</div>
			<div class="w3-bar 3">
				<input type="checkbox" name="soy"id = "soy" value="1"> เข้าซอย
			</div>
			<div class="w3-bar 4">
				ทางเข้ากว้าง
				<input name="soy_big" class="w3-input" type='text' id="soy_big" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 5">
				<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง
			</div>
			<div class="w3-bar 6">
				<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได้
			</div>
			<div class="w3-bar 7">
				<input type="checkbox" name="no_car_road"id = "no_car_road" value="1"> รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				การจอดรถ
			</div>
			<div class="w3-bar 9">
				<input type="checkbox" name="car_road" id = "car_road" value="1"> จอดรถข้างถนน
			</div>
			<div class="w3-bar 10">
				<input type="checkbox" name="car_home"id = "car_home" value="1"> จอดรถหน้าบ้านได้
			</div>
			<div class="w3-bar 11">
				ประตูหน้าบ้านสูง
				<input name="door_long" class="w3-input" type='text' id="door_long" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 12">
				<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
			</div>
			<div class="w3-bar 13">
				<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน
			</div>
			<div class="w3-bar 14">
				<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" style="width:90%;" placeholder="จำนวน (ขั้น)" />
			</div>
			<div class="w3-bar 15">
				ประตูบ้านกว้าง
				<input name="door_bigger" class="w3-input" type='text' id="door_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 16">
				ประตูสูง 
				<input name="door_longer" class="w3-input" type='text' id="door_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 17">
				ประตูห้องกว้าง 
				<input name="room_bigger" class="w3-input" type='text' id="room_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 18">
				ประตูห้องสูง 
				<input name="room_longer" class="w3-input" type='text' id="room_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
		</div>
		<div class="w3-third 212">
			<div class="w3-bar 1">
				ประตูบ้านเป็นแบบ
				<input name="type_door" class="w3-input" type='text' id="type_door" style="width:90%;" />
			</div>
			<div class="w3-bar 2">
				พื้นบ้านเป็นแบบ
				<input name="home_type" class="w3-input" type='text' id="home_type" style="width:90%;" />
			</div>
			<div class="w3-bar 3">
				ติดตั้งที่ชั้น
				<input name="install" class="w3-input" type='text' id="install" style="width:90%;" />
			</div>
			<div class="w3-bar 4">
				<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง
			</div>
			<div class="w3-bar 5">
				<input name="bundai_big" class="w3-input" type='text' id="bundai_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 6">
				หักมุมบันได
				<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" style="width:90%;" />
			</div>
			<div class="w3-bar 7">
				ชนิดของบันได
				<input name="type_bundai" class="w3-input" type='text' id="type_bundai" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง
			</div>
			<div class="w3-bar 9">
				<input name="lip_big" class="w3-input" type='text' id="lip_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 10">
				สูง
				<input name="lip_long" class="w3-input" type='text' id="lip_long" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 11">
				รับน้ำหนักได้ 
				<input name="lip_weight" class="w3-input" type='text' id="lip_weight" style="width:90%;" />
			</div>
			
		</div>
		<div class="w3-third 312">
			<div class="w3-bar 12">
				<input type="checkbox" name="up"id ="up" value="1"> ขึ้นลิฟท์ได้
			</div>
			<div class="w3-bar 13">
				<input type="checkbox" name="no_up"id ="no_up" value="1"> ขึ้นลิฟท์ไม่ได้
			</div>
			<div class="w3-bar 14">
				<input type="checkbox" name="head_bad"id ="head_bad" value="1"> ต้องถอดหัวเตียง-ท้ายเตียง
			</div>
			<div class="w3-bar 15">
				<input type="checkbox" name="want_employee"id ="want_employee" value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
			</div>
			<div class="w3-bar 16">
				จำนวนคนที่ใช้ 
				<input name="employee_unit" class="w3-input" type='text' id="employee_unit" style="width:90%;" />
			</div>
			<div class="w3-bar 17">
				ย้ายเฟอร์นิเจอร์ 
				<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" style="width:90%;" />
			</div>
			<div class="w3-bar 18">
				ย้ายไปที่ 
				<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" style="width:90%;" />
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_ex"id = "want_ex" value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_credit"id = "want_credit" value="1"> ต้องเตรียมเครื่องรูดบัตร
			</div>
			<div class="w3-bar">
				ธนาคาร 
				<input name="bank" class="w3-input" type='text' id="bank" style="width:90%;" />
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
			</div>
			<div class="w3-bar">
				รายละเอียดเพิ่มเติม
				<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"></textarea>
			</div>
		</div>
	</div>
	</fieldset>
	
</div><!-- cs -->

<div id="cs1" class="w3-container city1" style="display:none">

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม1)</b></legend>	

ชื่อผู้ติดต่อ 1  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name1"  class="button4" type='text' id="customer_name1" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 1 :
<input name="customer_tel1"  class="button4" type='text' id="customer_tel1" >
</p>

ที่อยู่ในการส่งสินค้า 1 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name1" id="address_name1" style="width:30%" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม2)</b></legend>	

ชื่อผู้ติดต่อ 2  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name2"  class="button4" type='text' id="customer_name2" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 2 :
<input name="customer_tel2"  class="button4" type='text' id="customer_tel2" >
</p>

ที่อยู่ในการส่งสินค้า 2 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name2" id="address_name2" style="width:30%" >  
</p>
</fieldset></p>


</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม3)</b></legend>	

ชื่อผู้ติดต่อ 3  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name3"  class="button4" type='text' id="customer_name3" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 3 :
<input name="customer_tel3"  class="button4" type='text' id="customer_tel3" >
</p>

ที่อยู่ในการส่งสินค้า 3 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name3" id="address_name3" style="width:30%" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม4)</b></legend>	

ชื่อผู้ติดต่อ 4  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name4"  class="button4" type='text' id="customer_name4" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 4 :
<input name="customer_tel4"  class="button4" type='text' id="customer_tel4" >
</p>

ที่อยู่ในการส่งสินค้า 4 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name4" id="address_name4" style="width:30%" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม5)</b></legend>	

ชื่อผู้ติดต่อ 5  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name5"  class="button4" type='text' id="customer_name5" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 5 :
<input name="customer_tel5"  class="button4" type='text' id="customer_tel5" >
</p>

ที่อยู่ในการส่งสินค้า 5 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name5" id="address_name5" style="width:30%" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม6)</b></legend>	

ชื่อผู้ติดต่อ 6  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name6"  class="button4" type='text' id="customer_name6" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 6 :
<input name="customer_tel6"  class="button4" type='text' id="customer_tel6" >
</p>

ที่อยู่ในการส่งสินค้า 6 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name6" id="address_name6" style="width:30%" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม7)</b></legend>	

ชื่อผู้ติดต่อ 7  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name7"  class="button4" type='text' id="customer_name7" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 7 :
<input name="customer_tel7"  class="button4" type='text' id="customer_tel7" >
</p>

ที่อยู่ในการส่งสินค้า 7 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name7" id="address_name7" style="width:30%" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม8)</b></legend>	

ชื่อผู้ติดต่อ 8  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name8"  class="button4" type='text' id="customer_name8" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 8 :
<input name="customer_tel8"  class="button4" type='text' id="customer_tel8" >
</p>

ที่อยู่ในการส่งสินค้า 8 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name8" id="address_name8" style="width:30%" >  
</p>
</fieldset></p>

</p><fieldset><legend><b>รายละเอียดการจัดส่ง (เพิ่มเติม9)</b></legend>	

ชื่อผู้ติดต่อ 9  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name9"  class="button4" type='text' id="customer_name9" >


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า 9 :
<input name="customer_tel9"  class="button4" type='text' id="customer_tel9" >
</p>

ที่อยู่ในการส่งสินค้า 9 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text'  class="button4" name="address_name9" id="address_name9" style="width:30%" >  
</p>
</fieldset></p>

	
	</div>

</p>
<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>
<br>
</div></div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

  
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
let lastOkValues = {}; // เก็บค่าก่อนหน้า เพื่อย้อนกลับได้

function num(v){
  return parseFloat(String(v||"").replace(/,/g,'')) || 0;
}

function calcTotal(){
  let total = 0;
  for(let i=1;i<=20;i++){
    const el = document.getElementById('sum_amount'+i);
    if(el) total += num(el.value);
  }
  document.getElementById('sum_amount_total').value = total.toFixed(2);
  return total;
}

function checkOverLimit(changedId){
  setTimeout(() => {
    const total = calcTotal();
    const limit = num(document.getElementById('sum_ca')?.value);

    if(limit > 0 && total > limit){

      // โชว์ Popup แทน alert
      showOverLimitPopup(total, limit);

      // (เลือกได้) จะย้อนค่าเดิมหรือไม่ก็ได้
      const el = document.getElementById(changedId);
      if(el && lastOkValues[changedId] !== undefined){
        el.value = lastOkValues[changedId];
      }
      calcTotal();
      if(el){ el.focus(); el.select?.(); }

    }else{
      const el = document.getElementById(changedId);
      if(el) lastOkValues[changedId] = el.value;
    }
  }, 30);
}
	
	
function bindRow(i){
  const ids = ['sale_count','product_price','discount_unit'].map(x=> x+i);
  ids.forEach(id=>{
    const el = document.getElementById(id);
    if(!el) return;

    // เก็บค่าเริ่มต้นไว้ก่อน
    lastOkValues[id] = el.value;

    el.addEventListener('focus', ()=> lastOkValues[id] = el.value);
    el.addEventListener('input', ()=> checkOverLimit(id));
    el.addEventListener('change', ()=> checkOverLimit(id));
  });
}

document.addEventListener('DOMContentLoaded', ()=>{
  for(let i=1;i<=20;i++) bindRow(i);
  calcTotal();
});
</script>

<script>
let modalLock = false;

function fmt2(n){
  return (Number(n)||0).toLocaleString('th-TH', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
}


function showOverLimitPopup(total, limit){
  if(modalLock) return;
  modalLock = true;

  document.getElementById('ol_total').textContent = fmt2(total);
  document.getElementById('ol_limit').textContent = fmt2(limit);

  document.getElementById('overLimitModal').style.display = 'block';
}

function goMainSuphos(){
  window.location.href = 'main_salehos_so.php';
}
</script>

<style>
/* Overlay */
#overLimitModal{
  display:none;
  position:fixed;
  z-index:99999;
  left:0; top:0;
  width:100%; height:100%;
  background:rgba(0,0,0,.45);
}

/* Modal box */
#overLimitModal .box{
  width:min(520px, 92vw);
  background:#fff;
  border-radius:14px;
  margin:7vh auto;
  padding:26px 22px 22px;
  position:relative;
  text-align:center;
  box-shadow:0 8px 30px rgba(0,0,0,.25);
  font-family:Arial, sans-serif;
}

#overLimitModal .closeX{
  position:absolute;
  right:14px; top:10px;
  font-size:28px;
  cursor:pointer;
  color:#333;
  line-height:1;
}

#overLimitModal .icon{
  width:86px; height:86px;
  margin:6px auto 10px;
}

#overLimitModal .title{
  font-size:28px;
  margin:10px 0 18px;
}

#overLimitModal .row{
  font-size:18px;
  margin:10px 0;
}

#overLimitModal .btnBack{
  margin-top:18px;
  padding:12px 26px;
  border:none;
  border-radius:22px;
  background:#612989;
  color:#fff;
  font-size:16px;
  cursor:pointer;
}
#overLimitModal .btnBack:hover{ opacity:.92; }
	
 /* ถ้าอยากให้ทั้งหน้าเป็น Prompt */
  body{ font-family: 'Prompt', sans-serif; }

  /* หรือกำหนดเฉพาะ popup */
  .overlimitModal, .overlimitModal *{
    font-family: 'Prompt', sans-serif !important;
  }

  /* ปุ่มกลับ */
  .btnBack{
    font-family: 'Prompt', sans-serif !important;
    font-weight: 500;
  }	
</style>

<div id="overLimitModal">
  <div class="box">
    <div class="closeX" onclick="goMainSuphos()">×</div>

    <!-- icon (SVG) -->
    <svg class="icon" viewBox="0 0 64 64" aria-hidden="true">
      <path d="M32 6 L60 58 H4 Z" fill="#ff3b30"/>
      <rect x="29" y="22" width="6" height="18" rx="3" fill="#fff"/>
      <circle cx="32" cy="46" r="3.2" fill="#fff"/>
    </svg>
	  
    <div class="title">กรุณาติดต่อบัญชี</div>
	 <div class="row">เพื่อขอเพิ่มวงเงิน เนื่องจากยอดรวมสินค้าเกินวงเงินคงเหลือ</div> 
	  
	  
    <div class="row">ยอดรวมสินค้า : <b id="ol_total">0</b></div>
    <div class="row">วงเงินคงเหลือ : <b id="ol_limit">0</b></div>

    <button type="button" class="btnBack" onclick="goMainSuphos()">กลับสู่หน้าหลัก</button>
  </div>
</div>


