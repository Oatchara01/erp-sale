<?php include('head.php'); ?>
<?php include('dbconnect_sale.php'); ?>
<?php include('dbconnect.php'); ?>
<?php require_once __DIR__ . '/includes/so_saved_helpers.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-supbrhos.css?v=<?php echo filemtime(__DIR__ . '/css/register-supbrhos.css'); ?>">
<script type="text/javascript" src="js/customer-popup.js"></script>

<script language="JavaScript">
	var HttPRequest = false;

	function doCallAjax1(bill_id, customer, address_send) {
		HttPRequest = false;
		if (window.XMLHttpRequest) {
			HttPRequest = new XMLHttpRequest();
			if (HttPRequest.overrideMimeType) {
				HttPRequest.overrideMimeType('text/html');
			}
		} else if (window.ActiveXObject) {
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
		var billIdVal = document.getElementById(bill_id).value;
		var pmeters = "bill_id=" + encodeURIComponent(billIdVal);
		HttPRequest.open('POST', url, true);
		HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		HttPRequest.setRequestHeader("Content-length", pmeters.length);
		HttPRequest.setRequestHeader("Connection", "close");
		HttPRequest.send(pmeters);

		HttPRequest.onreadystatechange = function() {
			if (HttPRequest.readyState == 4) {
				if (HttPRequest.status === 200) {
					var myProduct = HttPRequest.responseText;
					if (myProduct != "") {
						var myArr = myProduct.split("|");
						document.getElementById(customer).value = myArr[0];
						if (address_send && document.getElementById(address_send)) {
							document.getElementById(address_send).value = myArr[1];
						}

						// เติมข้อมูลลงกล่องแสดงผลข้อมูลลูกค้า (customer-info-display-card)
						setElementValue('display_bill_name', myArr[0]);
						setElementValue('display_bill_tel', myArr[2]);
						setElementValue('display_mode_name', myArr[20]);
						setElementValue('display_customer_typename', myArr[22]);
						setElementValue('customer_typename', myArr[22]);
						setElementValue('display_credit_thb', myArr[24]);

						var vipCkk = (myArr[25] || '').trim();
						var vipIcon = document.getElementById('display_vip_icon');
						if (vipIcon) {
							vipIcon.style.display = (vipCkk === "1") ? "" : "none";
						}

						var billIdVal2 = document.getElementById(bill_id).value;
						var displayBillId = document.getElementById('display_bill_id');
						if (displayBillId) displayBillId.textContent = billIdVal2;
					}
				}
			}
		}
	}

	function clearFieldValue(id) {
		var el = document.getElementById(id);
		if (el) el.value = '';
	}

	function clearCustomerSelection() {
		clearFieldValue('customer_id');
		clearFieldValue('bill_id');
		clearFieldValue('h_bill_id');
		clearFieldValue('h_customer');
		clearFieldValue('customer');
		clearFieldValue('address');
		clearFieldValue('customer_typename');

		var displayBillId = document.getElementById('display_bill_id');
		if (displayBillId) displayBillId.textContent = '';
		clearFieldValue('display_bill_tel');
		clearFieldValue('display_mode_name');
		clearFieldValue('display_bill_name');
		clearFieldValue('display_customer_typename');
		clearFieldValue('display_credit_thb');

		var vipIcon = document.getElementById('display_vip_icon');
		if (vipIcon) vipIcon.style.display = 'none';

		syncCreditTermTriggerState();
	}

	function setElementValue(id, value) {
		var element = document.getElementById(id);
		if (element) {
			var normalizedValue = value || "";
			if (id === 'display_credit_thb') {
				var trimmed = String(normalizedValue).trim();
				if (trimmed !== "") {
					var number = Number(trimmed.replace(/,/g, ''));
					if (!isNaN(number)) {
						normalizedValue = number.toLocaleString('en-US', {
							minimumFractionDigits: 2,
							maximumFractionDigits: 2
						});
					}
				}
			}
			if ('value' in element) {
				element.value = normalizedValue;
			} else {
				element.textContent = normalizedValue;
			}
			if (id === 'display_credit_thb') {
				syncCreditTermTriggerState();
			}
		}
	}

	function syncCreditTermTriggerState() {
		var trigger = document.getElementById('display_credit_thb_trigger');
		var valueElement = document.getElementById('display_credit_thb');
		if (!trigger || !valueElement) return;

		var creditTermValue = (valueElement.textContent || valueElement.value || '').trim();
		var hasCreditTerm = creditTermValue !== '';
		trigger.classList.toggle('is-empty', !hasCreditTerm);
		trigger.disabled = !hasCreditTerm;
		trigger.setAttribute('aria-disabled', hasCreditTerm ? 'false' : 'true');
	}

	// Hook เรียกโดย js/customer-popup.js เมื่อผู้ใช้กด "ตกลง" เลือกลูกค้าในป๊อปอัป
	window.customerPopupOnConfirm = function(selectedCustomer) {
		var selectedCustId = String((selectedCustomer && selectedCustomer.customer_id) || '').trim();

		var customerIdInput = document.getElementById('customer_id');
		if (customerIdInput) {
			customerIdInput.value = selectedCustId;
		}
		var billId = document.getElementById('bill_id');
		if (billId) {
			billId.value = selectedCustId;
		}
		var hiddenBillId = document.getElementById('h_bill_id');
		if (hiddenBillId) {
			hiddenBillId.value = selectedCustId;
		}
		var hCustomer = document.getElementById('h_customer');
		if (hCustomer) {
			hCustomer.value = selectedCustId;
		}

		doCallAjax1('bill_id', 'customer', 'address');
	};
</script>




<script>
	function object() {
		if (document.getElementById('object1').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		} else if (document.getElementById('object2').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		} else if (document.getElementById('object3').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		} else if (document.getElementById('object4').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'block';
			document.getElementById('dt5').style.display = 'none';
		} else if (document.getElementById('object5').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'block';

		} else if (document.getElementById('object6').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
	}

	// วัตถุประสงค์: select เดียว + ช่อง "ข้อความ" เดียว แทน radio 6 ปุ่ม + 4 ช่องแยก
	// ค่า POST เดิม (objective, objective_des1/2/4/5) ยังคงเหมือนเดิมทุกประการ
	// need_des/des_label มาจาก tb_objective (data attribute บน <option>) แทนการ hardcode
	function brSyncObjectiveDes() {
		var objectiveEl = document.getElementById('objective');
		var selectedOption = objectiveEl.options[objectiveEl.selectedIndex];
		var shared = document.getElementById('objective_des_shared');
		var group = document.getElementById('objective_des_group');
		var label = document.getElementById('objective_des_label');
		var showText = !!(selectedOption && selectedOption.dataset.needDes === '1');

		if (group) {
			group.style.display = showText ? '' : 'none';
		} else if (shared) {
			shared.style.display = showText ? '' : 'none';
		}

		if (shared) {
			if (!showText) {
				shared.value = '';
			} else {
				var desLabel = selectedOption.dataset.label || 'ข้อความ';
				if (desLabel === 'ข้อความ') {
					shared.placeholder = 'ใส่รายละเอียดเพิ่มเติม (ถ้ามี)';
					if (label) label.innerHTML = 'ข้อความ';
				} else {
					shared.placeholder = 'ระบุ' + desLabel;
					if (label) label.innerHTML = desLabel + ' <span style="color:red;">*</span>';
				}
			}
		}

		brWriteObjectiveDesHidden();
	}

	function brWriteObjectiveDesHidden() {
		var valEl = document.getElementById('objective');
		var val = valEl ? valEl.value : '';
		var sharedEl = document.getElementById('objective_des_shared');
		var shared = sharedEl ? sharedEl.value : '';
		['1', '2', '4', '5'].forEach(function(v) {
			var hiddenEl = document.getElementById('objective_des' + v);
			if (hiddenEl) {
				hiddenEl.value = (v === val) ? shared : '';
			}
		});
	}

	// การ์ดแท็บภายใน (ข้อมูลการจัดส่ง/ที่อยู่/เอกสารเพิ่มเติม) — เหมือน openDelTab/openAddrTab/open3Tab ของ register_suphos.php
	function brOpenDelTab(tabId, element) {
		var contents = document.getElementsByClassName('so-del-tab-content');
		for (var i = 0; i < contents.length; i++) contents[i].style.display = 'none';
		var btns = element.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < btns.length; i++) btns[i].classList.remove('active');
		document.getElementById(tabId).style.display = 'block';
		element.classList.add('active');
	}

	function brOpenAddrTab(tabId, element) {
		var contents = document.getElementsByClassName('so-addr-tab-content');
		for (var i = 0; i < contents.length; i++) contents[i].style.display = 'none';
		var btns = element.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < btns.length; i++) btns[i].classList.remove('active');
		document.getElementById(tabId).style.display = 'block';
		element.classList.add('active');
	}

	function brOpen3Tab(tabId, element) {
		var contents = document.getElementsByClassName('so-3tab-content');
		for (var i = 0; i < contents.length; i++) contents[i].style.display = 'none';
		var btns = element.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < btns.length; i++) btns[i].classList.remove('active');
		document.getElementById(tabId).style.display = 'block';
		element.classList.add('active');
	}

	// แท็บ ข้อมูลเอกสาร / Admin — scoped ต่อกลุ่มปุ่มตัวเอง
	function switchBrMainTab(el, tabId) {
		var contents = document.getElementsByClassName('so-tab-content');
		for (var i = 0; i < contents.length; i++) {
			contents[i].classList.remove('active');
		}
		document.getElementById(tabId).classList.add('active');

		var tabs = el.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < tabs.length; i++) {
			tabs[i].classList.remove('active');
		}
		el.classList.add('active');
	}

	function brUpdateBorrowDays() {
		var startEl = document.getElementById('date_br');
		var endEl = document.getElementById('returns_date');
		var out = document.getElementById('br_borrow_days_display');
		if (!startEl || !endEl || !out) return;
		if (!startEl.value || !endEl.value) {
			out.value = '';
			return;
		}
		var start = new Date(startEl.value);
		var end = new Date(endEl.value);
		var diffDays = Math.round((end - start) / (1000 * 60 * 60 * 24));
		out.value = (diffDays >= 0) ? diffDays : '';
	}

	function brOpenPreview() {
		brWriteObjectiveDesHidden();
		var form = document.forms.frmMain;
		var refInput = form ? form.querySelector('input[name="ref_id_br"]') : null;
		var refId = refInput ? refInput.value.trim() : '';

		if (!form || !refId) {
			Swal.fire('แจ้งเตือน', 'ไม่พบเลขที่อ้างอิง (ref_id_br)', 'warning');
			return;
		}

		var reportUrl = 'report_loanhosptl1.php';

		if (typeof brUpdateRowTotal === 'function') {
			var brPreviewRowCount = (typeof BR_ROW_COUNT !== 'undefined') ? BR_ROW_COUNT : 0;
			for (var rowIndex = 1; rowIndex <= brPreviewRowCount; rowIndex++) {
				brUpdateRowTotal(rowIndex);
			}
		}

		var previewTarget = 'loanhos_preview_' + Date.now();
		var previewWindow = window.open('', previewTarget);
		if (!previewWindow) {
			Swal.fire('แจ้งเตือน', 'เบราว์เซอร์บล็อกหน้าต่าง Preview กรุณาอนุญาต Pop-up แล้วลองใหม่', 'warning');
			return;
		}

		var previewFlag = document.createElement('input');
		previewFlag.type = 'hidden';
		previewFlag.name = '_report_preview';
		previewFlag.value = '1';
		form.appendChild(previewFlag);

		var originalAction = form.getAttribute('action');
		var originalMethod = form.getAttribute('method');
		var originalTarget = form.getAttribute('target');

		form.action = reportUrl;
		form.method = 'post';
		form.target = previewTarget;
		HTMLFormElement.prototype.submit.call(form);

		if (originalAction === null) form.removeAttribute('action');
		else form.setAttribute('action', originalAction);
		if (originalMethod === null) form.removeAttribute('method');
		else form.setAttribute('method', originalMethod);
		if (originalTarget === null) form.removeAttribute('target');
		else form.setAttribute('target', originalTarget);
		previewFlag.remove();
	}

	function brSaveDraft() {
		Swal.fire({
			icon: 'info',
			title: 'Save Draft',
			text: 'ฟังก์ชัน Save Draft ยังไม่พร้อมใช้งานในขณะนี้',
			confirmButtonColor: '#612989'
		});
	}
</script>

<?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


$yearMonth = substr(date("Y") + 543, -2) . date("m");
$sql = "SELECT MAX(ref_id_br) AS MAXID FROM hos__br ";
$qry = mysqli_query($conn, $sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = substr($rs['MAXID'], -5);
$maxId3 = substr($rs['MAXID'], -9);

$maxId1 = substr($maxId3, 0, -5);

$so = "BR";

if ($maxId1 == $yearMonth) {
	$maxId1 = ($maxId + 1);
	$maxId2 = substr("00000" . $maxId1, -5);
	$nextId = $yearMonth . $maxId2;
} else {
	$maxId1 = "00001";
	$nextId = $yearMonth . $maxId1;
}

// ตัวแปรรองรับแท็บ 'ที่อยู่เพิ่มเติม' ที่ port มาจาก register_suphos.php
// หน้านี้เป็น create-only (ยังไม่มีเอกสารที่บันทึกแล้ว) ค่าที่ saved ทั้งหมดจึงเป็นค่าว่าง
// และ $printCoverRefId = '' ทำให้ปุ่มพิมพ์ใบปะขึ้น Swal "ยังพิมพ์ไม่ได้" เสมอ
$printCoverRefId = '';
$savedFirstExtraAddress = ['contact_name' => '', 'telephone' => '', 'province' => '', 'address' => ''];
$savedDeliveryBillAddress = ['contact_name' => '', 'telephone' => '', 'province' => '', 'address' => ''];
$savedExtraAddressRows = [];

// NOTE: รายงานชุดนี้คัดลอกจาก register_suphos.php ซึ่งเป็นรายงานฝั่ง SO (report_h*.php)
// ยังพิมพ์ไม่ได้อยู่แล้วเพราะ $printCoverRefId ว่าง — ถ้าจะเปิดใช้จริงต้องเปลี่ยนเป็นรายงานฝั่ง BR ก่อน
$coverSheetMainReports = array(
	array('label' => '99std', 'file' => 'report_h99std.php'),
	array('label' => '99std+k', 'file' => 'report_h99std_k.php'),
	array('label' => 'a5ptl', 'file' => 'report_ha5ptl.php'),
	array('label' => 'a5ptl+k', 'file' => 'report_ha5ptl_k.php'),
	array('label' => 'a4ptl', 'file' => 'report_ha4ptl.php'),
	array('label' => 'a4ptl+k', 'file' => 'report_ha4ptl_k.php'),
	array('label' => 'a5nbm', 'file' => 'report_ha5nbm.php'),
	array('label' => 'a5nbm+k', 'file' => 'report_ha5nbm_k.php'),
	array('label' => 'a4nbm', 'file' => 'report_ha4nbm.php'),
	array('label' => 'a4nbm+k', 'file' => 'report_ha4nbm_k.php')
);
$coverSheetExtraReports = array(
	array('label' => '99std', 'file_pattern' => 'report_h99std%s.php'),
	array('label' => '99std+k', 'file_pattern' => 'report_h99std_k%s.php'),
	array('label' => 'a5', 'file_pattern' => 'report_ha5all%s.php'),
	array('label' => 'a5+k', 'file_pattern' => 'report_ha5all_k%s.php'),
	array('label' => 'a4', 'file_pattern' => 'report_ha4all%s.php'),
	array('label' => 'a4+k', 'file_pattern' => 'report_ha4all_k%s.php')
);
$billDeliveryReports = array(
	array('label' => '99std', 'file' => 'reportb_h99std.php'),
	array('label' => 'a5ptl', 'file' => 'reportb_ha5ptl.php'),
	array('label' => 'a4ptl', 'file' => 'reportb_ha4ptl.php'),
	array('label' => 'a5nbm', 'file' => 'reportb_ha5nbm.php'),
	array('label' => 'a4nbm', 'file' => 'reportb_ha4nbm.php')
);

// ข้อมูล Admin tab (partials/admin_info_tab.php) — reuse ของ Admin ที่มีอยู่แล้ว
// Layout อ้างอิงจาก register_suphos.php บรรทัด ~1750 (Admin tab เดียวกัน)
// หน้านี้เป็น create-only จึงยังไม่มีค่า saved ให้ผูก (ทุก value ว่าง)
$adminInfoTab = [
	'tab_id' => 'tab-admin-info',
	'title' => 'ข้อมูลเพิ่มเติม (Admin)',
	'rows' => [
		[
			['type' => 'text', 'name' => 'admin_doc_no', 'label' => 'เลขที่เอกสาร', 'value' => '', 'placeholder' => 'No.'],
			['type' => 'button', 'icon' => 'img/icons/doc.png', 'label' => 'Run เอกสาร'],
			['type' => 'date_th', 'name' => 'admin_doc_date', 'label' => 'วันที่ออกเอกสาร', 'value' => '', 'icon' => 'far fa-calendar-alt'],
			['type' => 'text', 'name' => 'admin_work_no', 'label' => 'เลขที่ลงงาน', 'value' => '', 'icon' => 'fas fa-search'],
		],
		[
			['type' => 'text', 'name' => 'admin_deposit_no', 'label' => 'เลขที่ใบฝาก', 'value' => '', 'icon' => 'fas fa-search'],
		],
		[
			['type' => 'button', 'icon' => 'img/icons/circle_x.png', 'label' => 'ยกเลิกเอกสาร'],
			['type' => 'text', 'name' => 'admin_cancel_reason', 'label' => 'หมายเหตุการยกเลิก', 'value' => '', 'icon' => 'fas fa-times', 'clearable' => true, 'span' => 3],
		],
	],
];

?>

<form action="register_supbrhos1.php" method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">
	<div class="w3-container register-so-main" style="max-width: 1200px; margin: 0 auto;">

		<div class="so-header-container">
			<div class="so-header-left">
				<h1 class="so-title">Borrow Order</h1>
				<div class="so-ref-info">
					<span class="so-ref-label">เลขที่อ้างอิง</span>
					<span class="so-ref-value"><?php echo $so;
												echo $nextId; ?></span>
				</div>
			</div>
			<div class="so-header-right">
				<button type="button" class="btn-preview-so" onclick="brOpenPreview();"><img src="img/icons/preview.png" alt="preview" style="width: 16px; height: 16px;"> Preview</button>
			</div>
		</div>

		<script language="javascript">
			function fncSubmit() //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
			{
				brWriteObjectiveDesHidden();

				var objVal = document.getElementById('objective') ? document.getElementById('objective').value : '';
				var objDesShared = document.getElementById('objective_des_shared') ? document.getElementById('objective_des_shared').value.trim() : '';

				if (objVal === '4' && objDesShared === '') {
					alert('กรุณาระบุเลขที่ใบงานบริการ');
					document.getElementById('objective_des_shared').focus();
					return false;
				}
				if (objVal === '5' && objDesShared === '') {
					alert('กรุณาระบุรายละเอียดอื่น ๆ');
					document.getElementById('objective_des_shared').focus();
					return false;
				}

				if (document.frmMain.start_time.value == "") {

					alert('กรุณาใส่เวลาส่ง');
					document.frmMain.start_time.focus();
					return false;
				}

				if (document.frmMain.customer_name.value == "") {
					alert('กรุณาใส่ชื่อลูกค้า');
					document.frmMain.customer_name.focus();
					return false;
				}

				if (document.frmMain.customer_tel.value == "") {
					alert('กรุณาใส่เบอร์โทรลูกค้า');
					document.frmMain.customer_tel.focus();
					return false;
				}
				if (document.frmMain.address_name.value == "") {
					alert('กรุณาใส่ที่อยู่ในการส่งสินค้า');
					document.frmMain.address_name.focus();
					return false;
				}

				// address_1 ถูกถอดออกจาก UI แล้ว (เหลือเป็น hidden) แต่ register_supbrhos1.php
				// ยังอ่านค่านี้ลงคอลัมน์ tb_register_data.address_1 แบบไม่มี isset guard
				// จึง mirror ค่าจาก address_name ซึ่งมีความหมายซ้อนกัน เพื่อไม่ให้คอลัมน์ว่างถาวร
				if (document.frmMain.address_1) {
					document.frmMain.address_1.value = document.frmMain.address_name.value;
				}

				if (document.frmMain.address_send.value == "") {
					alert('กรุณาใส่สถานที่ติดตั้งเครื่อง');
					document.frmMain.address_send.focus();
					return false;
				}
				if (document.frmMain.returns_date.value == "") {
					alert('กรุณาใส่วันที่รับคืนสินค้า');
					document.frmMain.returns_date.focus();
					return false;
				}
				if (document.frmMain.returns_time.value == "") {
					alert('กรุณาใส่เวลารับคืนสินค้า');
					document.frmMain.returns_time.focus();
					return false;
				}
				if (document.frmMain.returns_name.value == "") {
					alert('กรุณาใส่ชื่อผู้ติดต่อในการรับคืนสินค้า');
					document.frmMain.returns_name.focus();
					return false;
				}
				if (document.frmMain.returns_contact.value == "") {
					alert('กรุณาใส่เบอร์โทรศัพท์ติดต่อในการรับคืนสินค้า');
					document.frmMain.returns_contact.focus();
					return false;
				}
				if (document.frmMain.returns_address.value == "") {
					alert('กรุณาใส่รายละเอียดสถานที่รับคืนสินค้า');
					document.frmMain.returns_address.focus();
					return false;
				}

				if (document.frmMain.province_name.value == "") {
					alert('กรุณาเลือกจังหวัดที่ต้องการจัดส่ง');
					document.frmMain.province_name.focus();
					return false;
				}

				document.frmMain.submit();
			}
		</script>

		<input type="radio" name="company" value="1" checked='checked' required style="display:none;">
		<input type="hidden" name="ref_id_br" class="w3-input" value="<?php echo $so;
																		echo $nextId; ?>">

		<!-- แท็บ ข้อมูลเอกสาร / Admin (แท็บ Admin แสดงเฉพาะ type_login == 'It' เหมือนเดิม) -->
		<div class="so-tabs-container">
			<button type="button" class="so-tab-btn active" onclick="switchBrMainTab(this, 'tab-document-info')">ข้อมูลเอกสาร</button>
			<?php if ($_SESSION['type_login'] == 'It') { ?> <!-- ค่าเดิมเป็น it -->
				<button type="button" class="so-tab-btn" onclick="switchBrMainTab(this, 'tab-admin-info')">Admin</button>
			<?php } ?>
		</div>

		<div id="tab-document-info" class="so-tab-content active">

			<!-- กล่อง: ข้อมูลเอกสาร -->
			<div class="so-card">
				<div class="so-grid-3">
					<div class="so-field-group">
						<label class="so-label">บริษัท <span style="color:red;">*</span></label>
						<div class="so-select-wrapper">
							<select class="so-select" disabled>
								<option value="1" selected>AWL</option>
							</select>
						</div>
					</div>
					<div class="so-field-group">
						<label class="so-label" for="type_breng">ประเภท <span style="color:red;">*</span></label>
						<div class="so-select-wrapper">
							<select name="type_breng" id="type_breng" class="so-select" required>
								<option value="1" selected>ใบยืมลูกค้า (BRNP)</option>
								<option value="2">ใบยืมช่าง (BRES)</option>
							</select>
						</div>
					</div>
					<div class="so-field-group">
						<label class="so-label" for="sale_code">แผนก/เขตการขาย <span style="color:red;">*</span></label>
						<div class="so-select-wrapper">
							<?php
							if ($_SESSION['code'] == 'SS1') {
							?>
								<select name="sale_code" id="sale_code" class="so-select" required>
									<option value="">**Please Select**</option>
									<?php
									$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
									$objQuery5 = mysqli_query($com, $strSQL5);
									while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									?>
										<option value="<?php echo $objResuut5["sale_code"]; ?>"><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
									<?php
									}
									?>
								</select>
							<?php
							} else if ($_SESSION['code'] == 'SS2') {
							?>
								<select name="sale_code" id="sale_code" class="so-select" required>
									<option value="">**Please Select**</option>
									<?php
									$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
									$objQuery5 = mysqli_query($com, $strSQL5);
									while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									?>
										<option value="<?php echo $objResuut5["sale_code"]; ?>"><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
									<?php
									}
									?>
								</select>
							<?php
							} else if ($_SESSION['code'] == 'SS3') {
							?>
								<select name="sale_code" id="sale_code" class="so-select" required>
									<option value="">**Please Select**</option>
									<?php
									$strSQL5 = "SELECT * FROM  tb_team_ss3  ORDER BY sale_code ASC";
									$objQuery5 = mysqli_query($com, $strSQL5);
									while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									?>
										<option value="<?php echo $objResuut5["sale_code"]; ?>"><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
									<?php
									}
									?>
								</select>
							<?php
							} else if ($_SESSION['code'] == 'SS5') {
							?>
								<select name="sale_code" id="sale_code" class="so-select" required>
									<option value="">**Please Select**</option>
									<?php
									$strSQL5 = "SELECT * FROM  tb_team_ss3 where sale_code IN ('S31','S32') ORDER BY sale_code ASC";
									$objQuery5 = mysqli_query($com, $strSQL5);
									while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									?>
										<option value="<?php echo $objResuut5["sale_code"]; ?>"><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
									<?php
									}
									?>
								</select>
							<?php
							} else if ($_SESSION['code'] == 'MK2') {
							?>
								<select name="sale_code" id="sale_code" class="so-select" required>
									<option value="">**Please Select**</option>
									<?php
									$strSQL5 = "SELECT * FROM tb_team_sm1 ORDER BY sale_code ASC";
									$objQuery5 = mysqli_query($com, $strSQL5);
									while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									?>
										<option value="<?php echo $objResuut5["sale_code"]; ?>"><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
									<?php
									}
									?>
								</select>
							<?php
							} else if ($_SESSION['code'] == 'SUP_EN') {
							?>
								<select name="sale_code" id="sale_code" class="so-select" required>
									<option value="">**Please Select**</option>
									<?php
									$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
									$objQuery5 = mysqli_query($com, $strSQL5);
									while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									?>
										<option value="<?php echo $objResuut5["sale_code"]; ?>"><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
									<?php
									}
									?>
								</select>
							<?php
							} else {
							?>
								<select name="sale_code" id="sale_code" class="so-select" required>
									<option value="">**Please Select**</option>
									<?php
									$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
									$objQuery5 = mysqli_query($com, $strSQL5);
									while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									?>
										<option value="<?php echo $objResuut5["sale_code"]; ?>"><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
									<?php
									}
									?>
								</select>
							<?php
							}
							?>
						</div>
					</div>
				</div>

				<div class="so-section-title-container" style="margin-top: 8px;">
					<h3 class="so-section-title" style="font-size: 16px;">ข้อมูลเอกสาร</h3>
				</div>

				<div class="so-grid-3">
					<div class="so-field-group">
						<label class="so-label">จำนวนวันที่ยืม</label>
						<input type="text" id="br_borrow_days_display" class="so-input" readonly placeholder="ใส่เฉพาะตัวเลข">
					</div>
					<div class="so-field-group">
						<label class="so-label" for="date_br">วันที่เริ่มยืม <span style="color:red;">*</span></label>
						<div class="calendar-wrapper">
							<input type="date" name="date_br" id="date_br" value="<?php echo $today; ?>" class="so-input" required onchange="brUpdateBorrowDays();">
						</div>
					</div>
					<div class="so-field-group">
						<label class="so-label" for="returns_date">วันที่คืน</label>
						<div class="calendar-wrapper">
							<input type="date" name="returns_date" id="returns_date" class="so-input" onchange="brUpdateBorrowDays();">
						</div>
					</div>
				</div>

				<div class="so-grid-3">
					<!-- <div class="so-field-group">
						<label class="so-label" for="sn">ต้องการ SN</label>
						<div class="so-input-with-checkbox">
							<label class="so-checkbox-label">
								<input type="checkbox" name="sn_ckk" value="1">
							</label>
							<input name="sn" id="sn" class="so-input">
						</div>
					</div>
					<div class="so-field-group">
						<label class="so-label" for="cm_no">เลขที่ CM</label>
						<input type="text" name="cm_no" id="cm_no" class="so-input">
					</div> -->
					<div class="so-field-group">
						<label class="so-label">&nbsp;</label>
						<div>
							<label class="so-toggle-pill" id="lbl-que_ckk">
								<input type="checkbox" name="que_ckk" id="que_ckk" value="1">
								<span>งานด่วน</span>
							</label>
						</div>
					</div>
				</div>
			</div>

		</div><!-- /tab-document-info -->

		<input type="hidden" name="add_by" value="<?php echo so_saved_h(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')); ?>">

		<?php if ($_SESSION['type_login'] == 'It') { ?>
			<?php include __DIR__ . '/partials/admin_info_tab.php'; ?>
		<?php } ?>

		<!-- กล่อง: ข้อมูลลูกค้า -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">ข้อมูลลูกค้า</h2>
				<hr class="so-divider">
			</div>

			<div class="so-customer-top-grid">
				<!-- ฝั่งซ้าย: ปุ่มค้นหาลูกค้า และฟิลด์กรอกข้อมูลลูกค้า -->
				<div class="so-customer-top-left">
					<div class="so-customer-pills-row">
						<button type="button" class="btn-add-customer-pill" onclick="openCustomerPopup();">
							<img src="img/icons/add_user.png" alt="add_user" style="width: 23px;"> ข้อมูลลูกค้า
						</button>
					</div>

					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" for="customer">ชื่อลูกค้า <span style="color:red;">*</span></label>
						<div class="so-input-wrapper">
							<input type="text" name="customer" id="customer" class="so-input" readonly placeholder="จะแสดงผลอัตโนมัติเมื่อเลือกเสร็จสิ้น" required>
							<button type="button" class="fas fa-times so-clear-icon" onclick="clearCustomerSelection();" aria-label="ล้างข้อมูลลูกค้าที่เลือก"></button>
						</div>
					</div>
				</div>

				<!-- ฝั่งขวา: การ์ดแสดงผลข้อมูลรายละเอียดลูกค้า -->
				<div class="so-customer-top-right">
					<div class="so-field-group" style="height: 100%; margin-bottom: 0;">
						<label class="so-label">ข้อมูลลูกค้า</label>
						<div class="customer-info-display-card">
							<div class="cidc-col">
								<div class="cidc-row">
									<div class="cidc-label">รหัสลูกค้า</div>
									<div class="cidc-value">
										<span id="display_bill_id" class="cidc-display-text"></span>
										<input type="hidden" name="customer_id" id="customer_id">
										<input type="hidden" name="bill_id" id="bill_id">
										<input type="hidden" name="h_bill_id" id="h_bill_id" readonly>
										<input type='hidden' name="h_customer" id="h_customer">
									</div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">เบอร์โทรศัพท์</div>
									<div class="cidc-value">
										<input type="text" id="display_bill_tel" class="cidc-value-input" readonly>
									</div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">สถานะลูกค้า</div>
									<div class="cidc-value">
										<img src="img/icons/vip.png" class="cidc-status-icon" id="display_vip_icon" alt="VIP" style="display: none;">
										<input type="text" id="display_mode_name" class="cidc-value-input" readonly>
									</div>
								</div>
							</div>
							<div class="cidc-col">
								<div class="cidc-row">
									<div class="cidc-label">ชื่อลูกค้า</div>
									<div class="cidc-value">
										<input type="text" id="display_bill_name" class="cidc-value-input" readonly>
									</div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">ประเภทลูกค้า</div>
									<div class="cidc-value">
										<input type="text" id="display_customer_typename" class="cidc-value-input" readonly>
									</div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">เครดิตเทอม</div>
									<div class="cidc-value">
										<button type="button" class="credit-term-trigger is-empty" id="display_credit_thb_trigger" aria-haspopup="dialog" aria-controls="creditTermPopupModal" aria-disabled="true" disabled>
											<span id="display_credit_thb" class="credit-term-trigger-text"></span>
											<img src="img/icons/edit.png?v=20260610" class="credit-term-trigger-icon" alt="แก้ไข">
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="so-customer-address-wrap">
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" for="address">ที่อยู่ลูกค้า <span style="color:red;">*</span></label>
						<div class="so-input-wrapper">
							<input type="text" name="address" id="address" class="so-input" readonly placeholder="จะแสดงผลอัตโนมัติเมื่อเลือกเสร็จสิ้น" required>
							<button type="button" class="fas fa-times so-clear-icon" onclick="clearCustomerSelection();" aria-label="ล้างข้อมูลลูกค้าที่เลือก"></button>
						</div>
					</div>
				</div>
			</div>

			<!-- <div class="so-field-group" style="margin-top: 16px;">
					<label class="so-label" for="sale_comment">Sale Comment</label>
					<textarea name="sale_comment" id="sale_comment" class="so-textarea" rows="2"></textarea>
				</div> -->

			<input type="hidden" name="customer_typename" id="customer_typename">
		</div>

		<!-- กล่อง: วัตถุประสงค์การเบิก -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">วัตถุประสงค์การเบิก</h2>
				<hr class="so-divider">
			</div>

			<div class="objective-grid">
				<div class="so-field-group">
					<label class="so-label" for="objective">วัตถุประสงค์ในการยืม <span style="color:red;">*</span></label>
					<div class="so-select-wrapper">
						<select name="objective" id="objective" class="so-select" required onchange="brSyncObjectiveDes();">
							<option value="">เลือกวัตถุประสงค์</option>
							<?php
							$strSQLObjective = "SELECT objective_id, objective_name, need_des, des_label FROM tb_objective WHERE close_ckk = '0' ORDER BY number ASC";
							$objQueryObjective = mysqli_query($conn, $strSQLObjective);
							while ($rsObjective = mysqli_fetch_array($objQueryObjective)) {
							?>
								<option value="<?php echo $rsObjective["objective_id"]; ?>" data-need-des="<?php echo $rsObjective["need_des"]; ?>" data-label="<?php echo htmlspecialchars($rsObjective["des_label"], ENT_QUOTES); ?>"><?php echo $rsObjective["objective_name"]; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="so-field-group" id="objective_des_group" style="display: none;">
					<label class="so-label" for="objective_des_shared" id="objective_des_label">ข้อความ</label>
					<input type="text" id="objective_des_shared" class="so-input" placeholder="ใส่รายละเอียดเพิ่มเติม" oninput="brWriteObjectiveDesHidden();">
				</div>
			</div>

			<input type="hidden" name="objective_des1" id="objective_des1">
			<input type="hidden" name="objective_des2" id="objective_des2">
			<input type="hidden" name="objective_des4" id="objective_des4">
			<input type="hidden" name="objective_des5" id="objective_des5">
		</div>

		<!-- กล่อง: รายการสินค้า -->
		<div id="pd" class="w3-container so-card">
			<div class="so-section-title-container">
				<div style="display: flex; justify-content: space-between; align-items: baseline;">
					<h2 class="so-section-title" style="margin-bottom: 0; font-size: 20px; font-weight: 600;">รายการสินค้า</h2>
					<span id="br_summary_item_count_title" style="font-size: 18px; color: #8E8B94; font-weight: 600; font-family: 'Prompt', sans-serif;">0 รายการ</span>
				</div>
				<hr class="so-divider" style="margin-top: 10px;">
			</div>

			<?php
			if ($_SESSION["department"] == 'วิศวกรรม') {
				include('detail_breng_so.php');
			} else {
				include('detail_brhos_so.php');
			}
			?>
		</div>

		<!-- การ์ดแท็บ: ข้อมูลการจัดส่ง / ค่าจัดส่ง -->
		<?php
		$deliveryTab = [
			'open_fn' => 'brOpenDelTab',
			'grid_fields' => [
				['type' => 'select', 'span' => 2, 'name' => 'delivery_type', 'label' => 'วิธีการจัดส่ง', 'required' => true, 'options' => [
					'1' => 'Sale รับเอง',
					'2' => 'ช่างรับเอง',
					'3' => 'ลูกค้ารับเอง',
					'4' => 'บริษัทจัดส่ง',
				]],
				['type' => 'select', 'span' => 2, 'name' => 'transport_company', 'label' => 'บริษัทขนส่ง', 'required' => true, 'options' => [
					'' => 'เลือกบริษัทขนส่ง',
					'1' => 'Kerry',
					'2' => 'Flash',
					'3' => 'J&T',
					'4' => 'ไปรษณีย์ไทย',
				]],
				['type' => 'date', 'span' => 2, 'name' => 'start_date', 'label' => 'วันในการจัดส่ง', 'required' => true],
				['type' => 'select', 'span' => 1, 'name' => 'time_range', 'label' => 'เลือกช่วงเวลา', 'options' => [
					'' => 'เลือกช่วงเวลา',
					'morning' => 'ช่วงเช้า',
					'afternoon' => 'ช่วงบ่าย',
					'allday' => 'ทั้งวัน',
					'specific' => 'กำหนดเวลา',
				]],
				['type' => 'time', 'span' => 1, 'name' => 'start_time', 'label' => 'เวลาในการจัดส่ง', 'required' => true],
				['type' => 'text', 'span' => 4, 'name' => 'between_date', 'label' => 'ช่วงวันที่โดยประมาณ', 'clearable' => true],
				['type' => 'text', 'span' => 6, 'name' => 'status_comment', 'label' => 'หมายเหตุสถานะเพิ่มเติม', 'clearable' => true],
			],
			'toggle_buttons' => [
				['name' => 'call_customer', 'id' => 'call_customer', 'label' => 'ต้องการให้โทรแจ้ง'],
				['name' => 'ref_12', 'id' => 'ref_12', 'label' => 'ส่งสินค้าด้วยใบรับสินค้า (ไม่ระบุราคา)'],
				['name' => 'send_cs', 'id' => 'send_cs', 'label' => 'ส่งข้อมูลลงระบบ CS'],
			],
			'cost_fields' => [
				['type' => 'date', 'name' => 'shipping_date', 'label' => 'วันที่คีย์ค่าส่ง'],
				['type' => 'text', 'name' => 'shipping_ref1', 'label' => 'รหัสอ้างอิง 1'],
				['type' => 'text', 'name' => 'shipping_ref2', 'label' => 'รหัสอ้างอิง 2'],
				['type' => 'text', 'name' => 'shipping_cost', 'label' => 'ค่าจัดส่ง', 'value' => '0.00'],
			],
		];
		include __DIR__ . '/partials/delivery_info_tab.php';
		?>

		<!-- การ์ดแท็บ: ที่อยู่ / รายละเอียดที่อยู่ / ที่อยู่เพิ่มเติม / ที่อยู่การคืน -->
		<div class="so-tabs-container" style="margin-top: 24px;">
			<button type="button" class="so-tab-btn active" onclick="brOpenAddrTab('br_addr_main', this)">ที่อยู่</button>
			<button type="button" class="so-tab-btn" onclick="brOpenAddrTab('br_addr_detail', this)">รายละเอียดที่อยู่</button>
			<button type="button" class="so-tab-btn" onclick="brOpenAddrTab('br_addr_extra', this)">ที่อยู่เพิ่มเติม</button>
			<button type="button" class="so-tab-btn" onclick="brOpenAddrTab('br_addr_return', this)">ที่อยู่การคืน</button>
		</div>
		<div class="so-card" style="padding: 24px;">

			<div id="br_addr_main" class="so-addr-tab-content">
				<div class="so-section-title-container">
					<h3 class="so-section-title">ที่อยู่จัดส่ง</h3>
					<hr class="so-divider">
				</div>

				<div class="so-address-actions" style="display: flex; gap: 16px; margin-bottom: 24px;">
					<button type="button" class="so-address-action-btn so-address-action-btn-primary" style="background-color: #F4E8FF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
						<i class="fas fa-search"></i> ค้นหาที่อยู่
					</button>
					<button type="button" class="so-address-action-btn so-address-action-btn-secondary" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
						<img src="img/icons/database.png" alt="database" style="width: 16px; height: 16px;"> เพิ่มลงฐานลูกค้า
					</button>
				</div>

				<div class="so-grid-3">
					<div class="so-field-group">
						<label class="so-label" for="customer_name">ชื่อผู้ติดต่อ <span style="color:red;">*</span></label>
						<div class="so-input-wrapper">
							<input name="customer_name" class="so-input" type='text' id="customer_name">
							<button type="button" class="fas fa-times so-clear-icon" onclick="var i=this.closest('.so-input-wrapper').querySelector('input'); if(i) i.value='';" aria-label="ล้างค่า"></button>
						</div>
					</div>
					<div class="so-field-group">
						<label class="so-label" for="customer_tel">เบอร์โทรศัพท์ <span style="color:red;">*</span></label>
						<input name="customer_tel" class="so-input" type='text' id="customer_tel" placeholder="ใส่เฉพาะตัวเลข">
					</div>
					<div class="so-field-group">
						<label class="so-label" for="province_name">จังหวัด <span style="color:red;">*</span></label>
						<div class="so-select-wrapper">
							<select name="province_name" id="province_name" class="so-select">
								<option value="">เลือกจังหวัด</option>
								<?php
								$strSQL5 = "select * from tb_province order by province_ID ";
								$objQuery5 = mysqli_query($conn, $strSQL5);
								if (!$objQuery5) {
									echo "Failed to fetch to MySQL: " . mysqli_error();
								}
								while ($objResuut5 = mysqli_fetch_array($objQuery5, MYSQLI_ASSOC)) {
								?>
									<option value="<?php echo $objResuut5['province_name']; ?>"><?php echo $objResuut5['province_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="so-field-group" style="margin-top: 16px;">
					<label class="so-label" for="address_name">ที่อยู่ในการส่งสินค้า <span style="color:red;">*</span></label>
					<div class="so-input-wrapper">
						<input class="so-input" type="text" name="address_name" id="address_name">
						<button type="button" class="fas fa-times so-clear-icon" onclick="var i=this.closest('.so-input-wrapper').querySelector('input'); if(i) i.value='';" aria-label="ล้างค่า"></button>
					</div>
				</div>

				<div class="so-grid-2" style="margin-top: 16px;">
					<div class="so-field-group">
						<label class="so-label" for="address_send">สถานที่ติดตั้งเครื่อง <span style="color:red;">*</span></label>
						<div class="so-input-wrapper">
							<input class="so-input" type="text" name="address_send" id="address_send">
							<button type="button" class="fas fa-times so-clear-icon" onclick="var i=this.closest('.so-input-wrapper').querySelector('input'); if(i) i.value='';" aria-label="ล้างค่า"></button>
						</div>
					</div>
					<div class="so-field-group">
						<label class="so-label" for="location_link">Location Link</label>
						<div class="so-input-wrapper">
							<input name="location_link" type='text' id="location_link" class="so-input">
							<button type="button" class="fas fa-times so-clear-icon" onclick="var i=this.closest('.so-input-wrapper').querySelector('input'); if(i) i.value='';" aria-label="ล้างค่า"></button>
						</div>
					</div>
				</div>
			</div>

			<div id="br_addr_detail" class="so-addr-tab-content" style="display:none;">
				<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">รายละเอียดที่อยู่</h3>
				<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

				<?php
				// ฟิลด์เดิมของแท็บนี้ถูกถอดออกจาก UI แล้ว แต่ register_supbrhos1.php ยังอ่านค่าเหล่านี้
				// แบบ $_POST["x"] ตรง ๆ (ไม่มี isset guard) และเขียนลง tb_register_data
				// จึงคงไว้เป็น hidden พร้อมค่า default เดิม เพื่อไม่ให้เกิด PHP warning และคอลัมน์ไม่ถูกล้าง
				// (checkbox เดิม เช่น cash/bill/tran ไม่ต้องทำ hidden — ตอนไม่ติ๊กก็ไม่ POST อยู่แล้ว backend degrade เป็น '0')
				?>
				<input type="hidden" name="status" value="ส่ง">
				<input type="hidden" name="department_show" value="ฝ่ายขาย">
				<input type="hidden" name="department_name" value="Sale">
				<input type="hidden" name="employee_name" value="<?php echo so_saved_h($_SESSION['name'] ?? ''); ?>">
				<input type="hidden" name="employee_tel" value="">
				<input type="hidden" name="address_1" id="address_1" value="">
				<input type="hidden" name="product_sn" value="">
				<input type="hidden" name="unit_cash" value="">
				<input type="hidden" name="unit_check" value="">
				<input type="hidden" name="unit_credit" value="">
				<input type="hidden" name="unit_bill" value="">
				<input type="hidden" name="unit_tran" value="">
				<input type="hidden" name="dept" value="">
				<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='hidden'>

				<div class="so-grid-3" style="align-items: end;">
					<div class="so-field-group">
						<label class="so-label" style="color: #612989;">จอดรถหน้าบ้าน</label>
						<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
							<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
								<input type="radio" name="park_front" value="1" checked style="accent-color: #612989; width: 18px; height: 18px;"> ได้
							</label>
							<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
								<input type="radio" name="park_front" value="0" style="accent-color: #612989; width: 18px; height: 18px;"> ไม่ได้
							</label>
						</div>
					</div>
					<div class="so-field-group">
						<label class="so-label" style="color: #612989;">สถานที่จอดรถ</label>
						<input name="park_location" type="text" class="so-input" placeholder="สถานที่จอดรถ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
					</div>
					<div class="so-field-group">
						<label style="cursor: pointer; display: block;">
							<input type="checkbox" name="is_high_roof" value="1" style="display: none;" onchange="this.nextElementSibling.style.backgroundColor = this.checked ? '#612989' : '#F4F3F7'; this.nextElementSibling.style.color = this.checked ? 'white' : '#6e6e6e';">
							<div style="background-color: #F4F3F7; border-radius: 8px; padding: 10px; display: flex; align-items: center; justify-content: center; color: #6e6e6e; font-size: 14px; font-family: 'Prompt', sans-serif; height: 42px; transition: all 0.2s; user-select: none;">รถหลังคาสูงเข้าได้</div>
						</label>
					</div>
				</div>

				<div class="so-grid-3" style="margin-top: 16px;">
					<div class="so-field-group">
						<label class="so-label" style="color: #612989;">ทางเข้าบ้าน</label>
						<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
							<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
								<input type="radio" name="entrance_type" value="1" checked style="accent-color: #612989; width: 18px; height: 18px;"> ทางราบ
							</label>
							<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
								<input type="radio" name="entrance_type" value="2" style="accent-color: #612989; width: 18px; height: 18px;"> บันไดก่อนเข้าบ้าน
							</label>
						</div>
					</div>
					<div class="so-field-group">
						<label class="so-label" style="color: #612989;">จำนวนขั้นบันได</label>
						<input name="stair_count" type="text" class="so-input" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
					</div>
					<div class="so-field-group">
						<label class="so-label" style="color: #612989;">ชั้นที่ติดตั้ง</label>
						<input name="install_floor" type="text" class="so-input" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
					</div>
				</div>

				<div class="so-grid-3" style="margin-top: 16px;">
					<div class="so-field-group" style="min-width: 0;">
						<label class="so-label" style="color: #612989;">ห้องที่ติดตั้ง</label>
						<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
							<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
								<input type="radio" name="room_type" value="1" checked style="accent-color: #612989; width: 18px; height: 18px;"> ห้องโถง
							</label>
							<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
								<input type="radio" name="room_type" value="2" style="accent-color: #612989; width: 18px; height: 18px;"> ห้องนอน
							</label>
						</div>
					</div>
					<div class="so-field-group" style="min-width: 0;">
						<label class="so-label" style="color: #612989;">ขนาดประตูห้อง</label>
						<div style="display: flex; gap: 16px;">
							<input name="door_width" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
							<input name="door_height" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
						</div>
					</div>
					<div class="so-field-group" style="min-width: 0;">
						<label class="so-label" style="color: #612989;">ขนาดบันได</label>
						<div style="display: flex; gap: 16px;">
							<input name="stair_width" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
							<input name="stair_height" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
						</div>
					</div>
				</div>

				<div class="so-grid-3" style="margin-top: 16px;">
					<div class="so-field-group" style="min-width: 0;">
						<label class="so-label" style="color: #612989;">ประตูลิฟต์</label>
						<div style="display: flex; gap: 16px;">
							<input name="elev_door_width" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
							<input name="elev_door_height" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
						</div>
					</div>
					<div class="so-field-group" style="grid-column: span 1; min-width: 0;">
						<label class="so-label" style="color: #612989;">ขนาดห้องลิฟต์</label>
						<div style="display: flex; gap: 16px;">
							<input name="elev_width" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
							<input name="elev_height" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
							<input name="elev_depth" type="text" class="so-input" placeholder="ความลึก (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
						</div>
					</div>
					<div class="so-field-group" style="min-width: 0;">
						<label class="so-label" style="color: #612989;">ขนาดบรรทุกของลิฟต์</label>
						<input name="elev_capacity" type="text" class="so-input" placeholder="น้ำหนัก (กก.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
					</div>
				</div>

				<div class="so-grid-3" style="margin-top: 16px;">
					<div class="so-field-group">
						<label class="so-label" style="color: #612989;">การย้ายเฟอร์นิเจอร์</label>
						<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
							<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
								<input type="radio" name="move_furn" value="0" checked style="accent-color: #612989; width: 18px; height: 18px;"> ไม่
							</label>
							<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
								<input type="radio" name="move_furn" value="1" style="accent-color: #612989; width: 18px; height: 18px;"> ย้าย
							</label>
						</div>
					</div>
					<div class="so-field-group">
						<label class="so-label" style="color: #612989;">จำนวนชิ้นที่ย้าย</label>
						<input name="move_furn_count" type="text" class="so-input" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
					</div>
					<div class="so-field-group" style="grid-column: span 1;">
						<label class="so-label" style="color: #612989;">รายละเอียดเฟอร์นิเจอร์</label>
						<input name="move_furn_detail" type="text" class="so-input" placeholder="รายละเอียดเฟอร์นิเจอร์" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
					</div>
				</div>

				<div class="so-field-group" style="margin-top: 16px;">
					<label class="so-label" style="color: #612989;">หมายเหตุเพิ่มเติม</label>
					<input name="addr_note" type="text" class="so-input" placeholder="lorem ipsum" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
				</div>
			</div>

			<div id="br_addr_extra" class="so-addr-tab-content" style="display:none;">
				<div id="extra_address_list">
					<div class="extra-addr-row" data-index="1">
						<h3 class="so-section-title extra-addr-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">ที่อยู่เพิ่มเติม 1</h3>
						<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

						<div class="so-grid-3">
							<div class="so-field-group">
								<label class="so-label extra-contact-name-label" style="color: #612989;">ชื่อผู้ติดต่อ (เพิ่มเติม1)</label>
								<div style="position: relative; display: flex; align-items: center;">
									<input name="extra_contact_name_1" type="text" class="so-input" value="<?php echo so_saved_h($savedFirstExtraAddress['contact_name']); ?>" placeholder="ชื่อผู้ติดต่อ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
								</div>
							</div>
							<div class="so-field-group">
								<label class="so-label extra-contact-tel-label" style="color: #612989;">เบอร์โทร (เพิ่มเติม1)</label>
								<div style="position: relative; display: flex; align-items: center;">
									<input name="extra_contact_tel_1" type="text" class="so-input" value="<?php echo so_saved_h($savedFirstExtraAddress['telephone']); ?>" placeholder="เบอร์โทร" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
								</div>
							</div>
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">จังหวัด</label>
								<div class="so-select-wrapper">
									<select name="extra_contact_province_1" class="so-select" style="background-color: #F4F3F7; border:none; border-radius: 8px;">
										<option value="">เลือกจังหวัด</option>
										<?php
										$strSQL_prov_extra = "select * from tb_province order by province_ID ";
										$objQuery_prov_extra = mysqli_query($conn, $strSQL_prov_extra);
										if ($objQuery_prov_extra) {
											while ($objResuut_prov_extra = mysqli_fetch_array($objQuery_prov_extra, MYSQLI_ASSOC)) {
												$extraProvinceName = (string)$objResuut_prov_extra['province_name'];
												$extraProvinceSelected = $extraProvinceName === (string)$savedFirstExtraAddress['province'] ? ' selected' : '';
										?>
												<option value="<?php echo so_saved_h($extraProvinceName); ?>" <?php echo $extraProvinceSelected; ?>><?php echo so_saved_h($extraProvinceName); ?></option>
										<?php
											}
										}
										?>
									</select>
								</div>
							</div>
						</div>

						<div style="display: flex; gap: 16px; margin-top: 16px; align-items: flex-end; margin-bottom: 42px;">
							<div class="so-field-group" style="flex: 1; margin-bottom: 0;">
								<label class="so-label extra-shipping-address-label" style="color: #612989;">ที่อยู่ส่งสินค้า (เพิ่มเติม1)</label>
								<div style="position: relative; display: flex; align-items: center;">
									<input name="extra_shipping_address_1" type="text" class="so-input" value="<?php echo so_saved_h($savedFirstExtraAddress['address']); ?>" placeholder="ที่อยู่ส่งสินค้า" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
								</div>
							</div>
							<button type="button" onclick="removeExtraAddress(this)" style="background-color: #FFFFFF; color: #DC3545; border: 1px solid #EBEBEB; border-radius: 24px; padding: 0 24px; height: 42px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
								<i class="far fa-trash-alt"></i> ลบที่อยู่
							</button>
						</div>
					</div>
				</div>

				<div style="margin-top: 24px; display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
					<button type="button" onclick="addExtraAddress()" style="background-color: #F4E8FF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
						<img src="img/icons/add_address.png" alt="add_address" style="width: 16px; height: 16px;"> เพิ่มที่อยู่
					</button>
					<button type="button" onclick="toggleDeliveryPrintPanel()" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
						<img src="img/icons/print.png" alt="print" style="width: 16px; height: 16px; object-fit: contain;"> พิมพ์ใบปะ
					</button>
				</div>

				<div id="delivery_print_panel" style="display:none; margin-top: 20px; border: 1px solid #EBEBEB; border-radius: 12px; padding: 18px; background-color: #FCFBFD;">
					<div style="display: flex; justify-content: space-between; gap: 12px; align-items: center; flex-wrap: wrap;">
						<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin: 0;">ชุดพิมพ์ใบปะหน้า</h3>
						<span style="font-size: 13px; color: #7A6F85;">
							<?php echo $printCoverRefId !== '' ? 'เลขที่อ้างอิง: ' . so_saved_h($printCoverRefId) : 'ยังไม่มี ref_id สำหรับพิมพ์'; ?>
						</span>
					</div>
					<p style="margin: 10px 0 0; font-size: 13px; line-height: 1.6; color: #6C6772;">
						การพิมพ์ใบปะหน้าใช้ข้อมูลจากฐานข้อมูลที่บันทึกแล้ว หากเพิ่งแก้ไขที่อยู่เพิ่มเติมหรือที่อยู่ส่งบิล กรุณากดบันทึกก่อนพิมพ์
					</p>

					<div style="margin-top: 18px;">
						<h4 style="margin: 0 0 12px; font-size: 15px; color: #3B3B3B;">ใบปะหน้ากล่องหลัก</h4>
						<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px;">
							<?php foreach ($coverSheetMainReports as $reportConfig) { ?>
								<button type="button" onclick="openDeliveryPrintReport('<?php echo htmlspecialchars($reportConfig['file'], ENT_QUOTES, 'UTF-8'); ?>')" style="background-color: #FFFFFF; color: #612989; border: 1px solid #E5D8EF; border-radius: 10px; padding: 11px 14px; font-family: 'Prompt', sans-serif; font-size: 14px; font-weight: 500; cursor: pointer; text-align: center;">
									<?php echo htmlspecialchars($reportConfig['label'], ENT_QUOTES, 'UTF-8'); ?>
								</button>
							<?php } ?>
						</div>
					</div>

					<div style="margin-top: 18px;">
						<h4 style="margin: 0 0 12px; font-size: 15px; color: #3B3B3B;">ใบปะหน้าที่อยู่เพิ่มเติม</h4>
						<div id="delivery_print_extra_groups" style="display: flex; flex-direction: column; gap: 14px;"></div>
					</div>
				</div>

				<div style="margin-top: 28px;">
					<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 12px;">ที่อยู่ส่งบิล</h3>
					<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 18px;">

					<div class="so-grid-3">
						<div class="so-field-group">
							<label class="so-label" style="color: #612989;">ชื่อผู้ติดต่อ</label>
							<div style="position: relative; display: flex; align-items: center;">
								<input name="bill_extra_contact_name_2" type="text" class="so-input" placeholder="ชื่อผู้ติดต่อ" value="<?php echo so_saved_h($savedDeliveryBillAddress['contact_name']); ?>" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
								<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
							</div>
						</div>
						<div class="so-field-group">
							<label class="so-label" style="color: #612989;">เบอร์โทร</label>
							<div style="position: relative; display: flex; align-items: center;">
								<input name="bill_extra_contact_tel_2" type="text" class="so-input" placeholder="เบอร์โทร" value="<?php echo so_saved_h($savedDeliveryBillAddress['telephone']); ?>" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
								<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
							</div>
						</div>
						<div class="so-field-group">
							<label class="so-label" style="color: #612989;">จังหวัด</label>
							<div class="so-select-wrapper">
								<select name="bill_extra_contact_province_2" class="so-select" style="background-color: #F4F3F7; border:none; border-radius: 8px;">
									<option value="">เลือกจังหวัด</option>
									<?php
									$strSQL_prov_bill_extra = "select * from tb_province order by province_ID ";
									$objQuery_prov_bill_extra = mysqli_query($conn, $strSQL_prov_bill_extra);
									if ($objQuery_prov_bill_extra) {
										while ($objResuut_prov_bill_extra = mysqli_fetch_array($objQuery_prov_bill_extra, MYSQLI_ASSOC)) {
											$billExtraProvinceName = (string)$objResuut_prov_bill_extra['province_name'];
											$billExtraProvinceSelected = $billExtraProvinceName === $savedDeliveryBillAddress['province'] ? ' selected' : '';
									?>
											<option value="<?php echo so_saved_h($billExtraProvinceName); ?>" <?php echo $billExtraProvinceSelected; ?>><?php echo so_saved_h($billExtraProvinceName); ?></option>
									<?php
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>

					<div style="display: flex; gap: 20px; margin-top: 16px; align-items: flex-end; margin-bottom: 18px;">
						<div class="so-field-group" style="flex: 1; margin-bottom: 0;">
							<label class="so-label" style="color: #612989;">ที่อยู่ส่งสินค้า</label>
							<div style="position: relative; display: flex; align-items: center;">
								<input name="bill_extra_shipping_address_2" type="text" class="so-input" placeholder="ที่อยู่ส่งสินค้า" value="<?php echo so_saved_h($savedDeliveryBillAddress['address']); ?>" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
								<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
							</div>
						</div>
						<button type="button" onclick="toggleBillDeliveryPrintPanel()" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; height: 42px; min-width: 146px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
							<img src="img/icons/print.png" alt="print" style="width: 16px; height: 16px; object-fit: contain;"> พิมพ์
						</button>
					</div>

					<div id="bill_delivery_print_panel" style="display:none; margin-top: 18px; border: 1px solid #EBEBEB; border-radius: 12px; padding: 18px; background-color: #FCFBFD;">
						<div style="display: flex; justify-content: space-between; gap: 12px; align-items: center; flex-wrap: wrap;">
							<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin: 0;">ชุดพิมพ์ใบปะจัดส่งบิล</h3>
							<span style="font-size: 13px; color: #7A6F85;">
								<?php echo $printCoverRefId !== '' ? 'เลขที่อ้างอิง: ' . so_saved_h($printCoverRefId) : 'ยังไม่มี ref_id สำหรับพิมพ์'; ?>
							</span>
						</div>
						<p style="margin: 10px 0 0; font-size: 13px; line-height: 1.6; color: #6C6772;">
							ใบปะจัดส่งบิลมีรายการเดียว โดยดึงข้อมูลจากเอกสารที่บันทึกแล้ว
						</p>
						<div style="margin-top: 18px; display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px;">
							<?php foreach ($billDeliveryReports as $reportConfig) { ?>
								<button type="button" onclick="openBillDeliveryPrintReport('<?php echo htmlspecialchars($reportConfig['file'], ENT_QUOTES, 'UTF-8'); ?>')" style="background-color: #FFFFFF; color: #612989; border: 1px solid #E5D8EF; border-radius: 10px; padding: 11px 14px; font-family: 'Prompt', sans-serif; font-size: 14px; font-weight: 500; cursor: pointer; text-align: center;">
									<?php echo htmlspecialchars($reportConfig['label'], ENT_QUOTES, 'UTF-8'); ?>
								</button>
							<?php } ?>
						</div>
					</div>
				</div>

				<script>
					const deliveryPrintRefId = <?php echo json_encode($printCoverRefId, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
					const deliveryPrintCanOpen = <?php echo $printCoverRefId !== '' ? 'true' : 'false'; ?>;
					const deliveryPrintExtraReports = <?php echo json_encode($coverSheetExtraReports, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

					function getExtraAddressRowCount() {
						return Math.min(document.querySelectorAll('#extra_address_list .extra-addr-row').length, 9);
					}

					function toggleDeliveryPrintPanel() {
						const panel = document.getElementById('delivery_print_panel');
						if (!panel) {
							return;
						}

						const shouldShow = panel.style.display === 'none' || panel.style.display === '';
						panel.style.display = shouldShow ? 'block' : 'none';
						if (shouldShow) {
							renderDeliveryPrintExtraGroups();
						}
					}

					function openDeliveryPrintReport(fileName) {
						if (!deliveryPrintCanOpen || !deliveryPrintRefId) {
							const message = 'กรุณาบันทึกใบยืมก่อนพิมพ์ใบปะหน้า เพื่อให้ระบบมี ref_id และข้อมูลล่าสุดสำหรับรายงาน';
							if (typeof Swal !== 'undefined') {
								Swal.fire({
									icon: 'info',
									title: 'ยังพิมพ์ไม่ได้',
									text: message,
									confirmButtonColor: '#612989'
								});
							} else {
								alert(message);
							}
							return;
						}

						window.open(fileName + '?ref_id=' + encodeURIComponent(deliveryPrintRefId), '_blank');
					}

					function renderDeliveryPrintExtraGroups() {
						const container = document.getElementById('delivery_print_extra_groups');
						if (!container) {
							return;
						}

						const rowCount = getExtraAddressRowCount();
						container.innerHTML = '';

						if (rowCount === 0) {
							container.innerHTML = '<div style="font-size: 13px; color: #7A6F85;">ยังไม่มีรายการที่อยู่เพิ่มเติม</div>';
							return;
						}

						for (let index = 1; index <= rowCount; index++) {
							const group = document.createElement('div');
							group.style.border = '1px solid #EFE7F5';
							group.style.borderRadius = '10px';
							group.style.padding = '14px';
							group.style.backgroundColor = '#FFFFFF';

							const title = document.createElement('div');
							title.textContent = 'ที่อยู่เพิ่มเติม ' + index;
							title.style.fontSize = '14px';
							title.style.fontWeight = '600';
							title.style.color = '#3B3B3B';
							title.style.marginBottom = '10px';
							group.appendChild(title);

							const buttonWrap = document.createElement('div');
							buttonWrap.style.display = 'grid';
							buttonWrap.style.gridTemplateColumns = 'repeat(auto-fit, minmax(120px, 1fr))';
							buttonWrap.style.gap = '10px';

							deliveryPrintExtraReports.forEach(function(reportConfig) {
								const button = document.createElement('button');
								button.type = 'button';
								button.textContent = reportConfig.label;
								button.style.backgroundColor = '#FFFFFF';
								button.style.color = '#612989';
								button.style.border = '1px solid #E5D8EF';
								button.style.borderRadius = '10px';
								button.style.padding = '11px 14px';
								button.style.fontFamily = "'Prompt', sans-serif";
								button.style.fontSize = '14px';
								button.style.fontWeight = '500';
								button.style.cursor = 'pointer';
								button.onclick = function() {
									openDeliveryPrintReport(reportConfig.file_pattern.replace('%s', index));
								};
								buttonWrap.appendChild(button);
							});

							group.appendChild(buttonWrap);
							container.appendChild(group);
						}
					}

					function toggleBillDeliveryPrintPanel() {
						const panel = document.getElementById('bill_delivery_print_panel');
						if (!panel) {
							return;
						}

						panel.style.display = (panel.style.display === 'none' || panel.style.display === '') ? 'block' : 'none';
					}

					function openBillDeliveryPrintReport(fileName) {
						if (!deliveryPrintCanOpen || !deliveryPrintRefId) {
							const message = 'กรุณาบันทึกใบยืมก่อนพิมพ์ใบปะจัดส่งบิล เพื่อให้ระบบมี ref_id และข้อมูลล่าสุดสำหรับรายงาน';
							if (typeof Swal !== 'undefined') {
								Swal.fire({
									icon: 'info',
									title: 'ยังพิมพ์ไม่ได้',
									text: message,
									confirmButtonColor: '#612989'
								});
							} else {
								alert(message);
							}
							return;
						}

						window.open(fileName + '?ref_id=' + encodeURIComponent(deliveryPrintRefId), '_blank');
					}

					function addExtraAddress() {
						const list = document.getElementById('extra_address_list');
						const template = list.querySelector('.extra-addr-row').cloneNode(true);

						// Clear inputs in cloned node
						template.querySelectorAll('input').forEach(input => input.value = '');
						template.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

						list.appendChild(template);
						updateExtraAddressIndices();
					}

					function removeExtraAddress(btn) {
						const list = document.getElementById('extra_address_list');
						if (list.querySelectorAll('.extra-addr-row').length > 1) {
							btn.closest('.extra-addr-row').remove();
							updateExtraAddressIndices();
						} else {
							alert('ต้องมีที่อยู่เพิ่มเติมอย่างน้อย 1 รายการ หรือถ้าไม่ต้องการใช้ ให้เว้นว่างข้อมูลไว้ครับ');
						}
					}

					function updateExtraAddressIndices() {
						const rows = document.querySelectorAll('.extra-addr-row');
						rows.forEach((row, index) => {
							const displayIndex = index + 1;
							row.setAttribute('data-index', displayIndex);
							row.querySelector('.extra-addr-title').innerHTML = 'ที่อยู่เพิ่มเติม ' + displayIndex;
							row.querySelector('.extra-contact-name-label').innerHTML = 'ชื่อผู้ติดต่อ (เพิ่มเติม' + displayIndex + ')';
							row.querySelector('.extra-contact-tel-label').innerHTML = 'เบอร์โทร (เพิ่มเติม' + displayIndex + ')';
							row.querySelector('.extra-shipping-address-label').innerHTML = 'ที่อยู่ส่งสินค้า (เพิ่มเติม' + displayIndex + ')';

							// Update input names dynamically
							const contactName = row.querySelector('input[name^="extra_contact_name"]');
							if (contactName) contactName.name = 'extra_contact_name_' + displayIndex;

							const contactTel = row.querySelector('input[name^="extra_contact_tel"]');
							if (contactTel) contactTel.name = 'extra_contact_tel_' + displayIndex;

							const contactProvince = row.querySelector('select[name^="extra_contact_province"]');
							if (contactProvince) contactProvince.name = 'extra_contact_province_' + displayIndex;

							const shippingAddress = row.querySelector('input[name^="extra_shipping_address"]');
							if (shippingAddress) shippingAddress.name = 'extra_shipping_address_' + displayIndex;
						});

						renderDeliveryPrintExtraGroups();
					}

					(function restoreRenderedExtraAddresses() {
						const savedExtraAddressRows = <?php echo json_encode($savedExtraAddressRows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
						if (!Array.isArray(savedExtraAddressRows) || savedExtraAddressRows.length === 0) {
							return;
						}

						const list = document.getElementById('extra_address_list');
						if (!list) {
							return;
						}

						while (list.querySelectorAll('.extra-addr-row').length < savedExtraAddressRows.length) {
							addExtraAddress();
						}

						savedExtraAddressRows.forEach((item, index) => {
							const displayIndex = index + 1;
							const nameInput = document.querySelector('input[name="extra_contact_name_' + displayIndex + '"]');
							const telInput = document.querySelector('input[name="extra_contact_tel_' + displayIndex + '"]');
							const provinceInput = document.querySelector('select[name="extra_contact_province_' + displayIndex + '"]');
							const addressInput = document.querySelector('input[name="extra_shipping_address_' + displayIndex + '"]');

							if (nameInput) nameInput.value = item.contact_name || '';
							if (telInput) telInput.value = item.telephone || '';
							if (provinceInput) provinceInput.value = item.province || '';
							if (addressInput) addressInput.value = item.address || '';
						});

						renderDeliveryPrintExtraGroups();
					})();
				</script>
			</div>

			<div id="br_addr_return" class="so-addr-tab-content" style="display:none;">
				<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">ที่อยู่การคืน</h3>
				<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

				<!-- Hidden field to preserve backend returns=1 behavior -->
				<input type="hidden" name="returns" value="1">

				<!-- Row 1: 4 columns -->
				<div class="br-returns-row-grid">
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" style="color: #612989;">วันที่รับคืน <span style="color:red;">*</span></label>
						<div class="calendar-wrapper" style="width: 100%; display: flex;">
							<input name="returns_date" type="date" id="returns_date" class="so-input" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 40px;" />
						</div>
					</div>
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" style="color: #612989;">เวลาในการรับคืน</label>
						<div class="so-select-wrapper">
							<select name="return_time_range" id="return_time_range" class="so-select" style="background-color: #F4F3F7; border:none; border-radius: 8px;">
								<option value="">Select</option>
								<option value="morning">ช่วงเช้า</option>
								<option value="afternoon">ช่วงบ่าย</option>
								<option value="allday">ทั้งวัน</option>
								<option value="specific">กำหนดเวลา</option>
							</select>
						</div>
					</div>
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" style="color: #612989;">เวลา</label>
						<div class="time-wrapper" style="width: 100%; display: flex;">
							<input id="returns_time" name="returns_time" class="so-input" type="time" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 40px;" />
						</div>
					</div>
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" style="color: #612989;">ช่วงเวลาโดยประมาณ</label>
						<div style="position: relative; display: flex; align-items: center; width: 100%;">
							<input name="return_date_bet" class="so-input" type="text" id="return_date_bet" placeholder="กรอกช่วงเวลา" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 36px !important;" />
							<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('return_date_bet').value=''" aria-label="ล้างค่า"></button>
						</div>
					</div>
				</div>

				<!-- Row 2: 3 columns -->
				<div class="so-grid-3" style="margin-top: 16px; align-items: end;">
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" style="color: #612989;">ชื่อผู้ติดต่อ <span style="color:red;">*</span></label>
						<div style="position: relative; display: flex; align-items: center; width: 100%;">
							<input name="returns_name" class="so-input" type="text" id="returns_name" placeholder="กรอกชื่อผู้ติดต่อ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 36px !important;" />
							<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('returns_name').value=''" aria-label="ล้างค่า"></button>
						</div>
					</div>
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" style="color: #612989;">เบอร์โทรศัพท์ <span style="color:red;">*</span></label>
						<input name="returns_contact" class="so-input" type="text" id="returns_contact" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
					</div>
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" style="color: #612989;">เลขที่ลงงาน</label>
						<input name="cm_no" class="so-input" type="text" id="cm_no" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
					</div>
				</div>

				<!-- Row 3: Full width -->
				<div class="so-field-group" style="margin-top: 16px;">
					<label class="so-label" for="returns_address" style="color: #612989;">รายละเอียดสถานที่รับคืน</label>
					<div style="position: relative; display: flex; align-items: center; width: 100%;">
						<input name="returns_address" class="so-input" type="text" id="returns_address" placeholder="กรอกสถานที่รับคืน" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 36px !important;" />
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('returns_address').value=''" aria-label="ล้างค่า"></button>
					</div>
				</div>

				<script>
					$(document).ready(function() {
						$('#return_time_range').on('change', function() {
							const val = $(this).val();
							const timeInput = $('#returns_time');
							if (val === 'morning') {
								timeInput.val('08:00');
							} else if (val === 'afternoon') {
								timeInput.val('13:00');
							} else if (val === 'allday') {
								timeInput.val('08:00');
							} else {
								timeInput.val('');
							}
						});
					});
				</script>
			</div>
		</div>

		<!-- การ์ดแท็บ: เอกสารเพิ่มเติม / ข้อความแจ้งแผนก / แนบไฟล์ / เอกสารที่เกี่ยวข้อง -->
		<?php
		$docTabsCard = [
			'open_fn' => 'brOpen3Tab',
			'doc_extra' => [
				'pills' => [
					['name' => 'ref_3', 'label' => 'ใบ อย.', 'checked' => false],
					['name' => 'ref_6', 'label' => 'ใบนำเข้าสินค้า', 'checked' => false],
					['name' => 'ref_8', 'label' => 'ใบ PM', 'checked' => false],
					['name' => 'ref_9', 'label' => 'ใบ CAL', 'checked' => false],
					['name' => 'ref_11', 'label' => 'ใบประเมินสินค้า', 'checked' => false],
					['name' => 'ref_5', 'label' => 'ใบช่างอบรม', 'checked' => false],
					['name' => 'ref_2', 'label' => 'เอกสารตามสเปคใบเสนอราคา', 'checked' => false, 'span' => 2],
					['name' => 'ref_1', 'label' => 'เอกสาร N-Health', 'checked' => false, 'span' => 2],
					['name' => 'ref_4', 'label' => 'ใบตัวแทนจำหน่าย', 'checked' => false, 'span' => 2],
					['name' => 'ref_7', 'label' => 'ใบ CER เครื่องมือที่ใช้ทดสอบ', 'checked' => false, 'span' => 2],
				],
				'other_field' => [
					'text_name' => 'ref_des',
					'text_value' => '',
					'checkbox_name' => 'ref_10',
					'checkbox_id' => 'ref_10_hidden',
					'checkbox_checked' => false,
				],
			],
			'dept_comment' => ['enabled' => true, 'technician_required_checked' => false],
			'attach_file' => ['enabled' => true],
			'related_docs' => ['enabled' => true],
		];
		include __DIR__ . '/partials/doc_tabs_card.php';
		?>
		<script>
			const savedCommentSoForDept = null;
			const savedCommentSoItemsForDept = [];
		</script>
		<script src="js/doc-tabs-dept-comment.js?v=<?php echo filemtime(__DIR__ . '/js/doc-tabs-dept-comment.js'); ?>"></script>
		<script src="js/doc-tabs-attach.js?v=<?php echo filemtime(__DIR__ . '/js/doc-tabs-attach.js'); ?>"></script>

	</div>

	<div class="so-sticky-actions">
		<div class="so-sticky-actions-inner">
			<button type="submit" name="submit" value="submit" class="btn-so-submit"><i class="fas fa-paper-plane"></i> Submit</button>
			<button type="button" class="btn-so-draft" onclick="brSaveDraft();"><i class="far fa-save"></i> Save Draft</button>
		</div>
	</div>
</form>
<!-- <div id="cr_bar"> <?php include "foot.php"; ?></div> -->

<!-- Modal รายชื่อลูกค้า: ใช้ค้นหา/เลือก customer เพื่อนำข้อมูลไปเติมในฟอร์มหลัก -->
<div id="customerPopupModal" class="customer-popup-modal" aria-hidden="true" style="display: none;">
	<div class="customer-popup-box" role="dialog" aria-modal="true" aria-labelledby="customerPopupTitle">
		<button type="button" class="customer-popup-close" onclick="closeCustomerPopup()" aria-label="Close">&times;</button>

		<div class="customer-popup-header">
			<h2 id="customerPopupTitle">ข้อมูลลูกค้า</h2>
			<div class="customer-popup-toolbar" style="margin-top: 18px;">
				<div class="customer-popup-search-wrap">
					<label for="customerPopupSearch">ค้นหาลูกค้า</label>
					<div class="customer-popup-search">
						<i class="fas fa-search" aria-hidden="true"></i>
						<input type="text" id="customerPopupSearch" placeholder="ค้นหาด้วยชื่อ / เบอร์โทร">
					</div>
				</div>
				<button type="button" class="customer-popup-add" onclick="window.open('customer_add.php', '_blank');">
					<i class="fas fa-sliders-h" aria-hidden="true"></i>
					เพิ่มข้อมูลลูกค้า
				</button>
			</div>
		</div>

		<div class="customer-popup-table-wrap">
			<table class="customer-popup-table">
				<thead>
					<tr>
						<th scope="col">ชื่อลูกค้า</th>
						<th scope="col">เบอร์โทร</th>
						<th scope="col">ที่อยู่</th>
						<th scope="col" aria-label="เลือก"></th>
					</tr>
				</thead>
				<tbody id="customerPopupRows">
					<tr>
						<td colspan="4" class="customer-popup-empty">พิมพ์ชื่อหรือเบอร์โทรเพื่อค้นหา</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="customer-popup-pagination" id="customerPopupPagination" style="display:none;">
			<button type="button" class="customer-popup-loadmore" id="customerPopupLoadMore" onclick="loadMoreCustomerPopupRows()">โหลดเพิ่ม</button>
		</div>

		<div class="customer-popup-actions">
			<button type="button" class="customer-popup-confirm" onclick="confirmCustomerPopupSelection()">ตกลง</button>
			<button type="button" class="customer-popup-cancel" onclick="closeCustomerPopup()">ยกเลิก</button>
		</div>
	</div>
</div>

<script>
	$('#more').click(function() {
		if ($(this).is(":checked")) {
			$("#more-2").show();
		} else {
			$("#more-2").hide();
		}
	});
</script>