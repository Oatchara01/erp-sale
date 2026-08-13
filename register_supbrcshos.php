<?php include('head.php');
include('dbconnect_sale.php'); ?>
<?php require_once __DIR__ . '/includes/so_saved_helpers.php'; ?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-supbrcshos.css?v=<?php echo filemtime(__DIR__ . '/css/register-supbrcshos.css'); ?>">
<link rel="stylesheet" href="css/credit-term-modal.css?v=<?php echo filemtime(__DIR__ . '/css/credit-term-modal.css'); ?>">
<script src="js/customer-popup.js?v=<?php echo filemtime(__DIR__ . '/js/customer-popup.js'); ?>"></script>
<script src="js/credit-term-modal.js?v=<?php echo filemtime(__DIR__ . '/js/credit-term-modal.js'); ?>"></script>

<script language="JavaScript">
	var HttPRequest = false;

	function doCallAjax1(customer_id, customer, address, customer_typename) {
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
		var url = 'data_customerbr1.php';
		var pmeters = "customer_id=" + encodeURI(document.getElementById(customer_id).value);
		HttPRequest.open('POST', url, true);

		HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		HttPRequest.setRequestHeader("Content-length", pmeters.length);
		HttPRequest.setRequestHeader("Connection", "close");
		HttPRequest.send(pmeters);

		HttPRequest.onreadystatechange = function() {
			if (HttPRequest.readyState == 4) // Return Request
			{
				var myProduct = HttPRequest.responseText;

				if (myProduct != "") {

					var myArr = myProduct.split("|");

					document.getElementById(customer).value = myArr[0];
					document.getElementById(address).value = myArr[1];
					document.getElementById(customer_typename).value = myArr[2];

					// เติมแท็บ "ที่อยู่จัดส่ง" อัตโนมัติจากข้อมูล del_* ของลูกค้า
					// ported จาก applyShippingSelection() ใน register_supbrhos.php:556-567
					var shipCustomerName = document.getElementById('customer_name');
					if (shipCustomerName) shipCustomerName.value = myArr[9] || '';
					var shipCustomerTel = document.getElementById('customer_tel');
					if (shipCustomerTel) shipCustomerTel.value = myArr[10] || myArr[3] || '';
					var shipProvince = document.getElementById('province_name');
					if (shipProvince) shipProvince.value = myArr[7] || '';
					var shipAddressName = document.getElementById('address_name');
					if (shipAddressName) shipAddressName.value = myArr[11] || '';
					var shipAddressRaw = document.getElementById('shipping_address_raw');
					if (shipAddressRaw) shipAddressRaw.value = myArr[5] || '';
					var shipAmpher = document.getElementById('shipping_ampher');
					if (shipAmpher) shipAmpher.value = myArr[6] || '';
					var shipPostcode = document.getElementById('shipping_postcode');
					if (shipPostcode) shipPostcode.value = myArr[8] || '';
					var shipId = document.getElementById('shipping_id');
					if (shipId) shipId.value = '';

				}
			}
		}
	}

	function csPreviewNotice() {
		alert('กรุณาบันทึกเอกสารก่อน จึงจะสามารถ Preview ได้');
	}

	// แท็บ ข้อมูลเอกสาร / Admin — pure UI toggle, ported verbatim from register_supbrhos.php:780-792
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

	function brOpenDelTab(tabId, element) {
		var contents = document.getElementsByClassName('so-del-tab-content');
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

	function brcsSaveDraft() {
		if (typeof syncDeptComments === 'function') {
			syncDeptComments();
		}
		if (typeof syncReturnTimeRangeFromTime === 'function') {
			syncReturnTimeRangeFromTime();
		}

		var form = document.forms['frmMain'];
		if (!form) return;

		var btn = form.querySelector('[name="save_draft"]');
		var defaultHtml = btn ? btn.innerHTML : '';
		var formData = new FormData(form);
		formData.set('is_draft', '1');

		if (btn) {
			btn.disabled = true;
			btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
		}

		fetch('register_supbrcshos_draft1.php', {
				method: 'POST',
				body: formData
			})
			.then(function(res) {
				return res.json();
			})
			.then(function(data) {
				if (data && data.success) {
					if (typeof Swal !== 'undefined') {
						Swal.fire({
							title: 'Save Draft success',
							text: 'Ref ID: ' + (data.ref_id || ''),
							icon: 'success',
							confirmButtonColor: '#612989'
						}).then(function() {
							if (data.ref_id) {
								window.location.href = 'register_supbrcshos_edit.php?ref_id=' + encodeURIComponent(data.ref_id);
							}
						});
					} else {
						alert('บันทึกร่างเรียบร้อยแล้ว (Ref ID: ' + (data.ref_id || '') + ')');
						if (data.ref_id) {
							window.location.href = 'register_supbrcshos_edit.php?ref_id=' + encodeURIComponent(data.ref_id);
						}
					}
				} else {
					var msg = (data && data.message) ? data.message : 'เกิดข้อผิดพลาดในการบันทึกร่าง';
					if (typeof Swal !== 'undefined') {
						Swal.fire({
							title: 'Save Draft error',
							text: msg,
							icon: 'error',
							confirmButtonColor: '#612989'
						});
					} else {
						alert(msg);
					}
				}
			})
			.catch(function(err) {
				if (typeof Swal !== 'undefined') {
					Swal.fire({
						title: 'Save Draft error',
						text: String(err),
						icon: 'error',
						confirmButtonColor: '#612989'
					});
				} else {
					alert('Save Draft error: ' + String(err));
				}
			})
			.finally(function() {
				if (btn) {
					btn.disabled = false;
					btn.innerHTML = defaultHtml;
				}
			});
	}


	function brOpenAddrTab(tabId, element) {
		var contents = document.getElementsByClassName('so-addr-tab-content');
		for (var i = 0; i < contents.length; i++) contents[i].style.display = 'none';
		var btns = element.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < btns.length; i++) btns[i].classList.remove('active');
		document.getElementById(tabId).style.display = 'block';
		element.classList.add('active');
	}

	function brFocusField(field) {
		if (!field) return;
		var parentTab = field.closest('.so-addr-tab-content');
		if (parentTab && parentTab.id) {
			var tabBtn = document.querySelector(".so-tab-btn[onclick*='" + parentTab.id + "']");
			if (tabBtn) brOpenAddrTab(parentTab.id, tabBtn);
		}
		field.focus();
	}

	function clearShippingAddressParts() {
		var raw = document.getElementById('shipping_address_raw');
		var ampher = document.getElementById('shipping_ampher');
		var postcode = document.getElementById('shipping_postcode');
		if (raw) raw.value = '';
		if (ampher) ampher.value = '';
		if (postcode) postcode.value = '';
	}

	function getCurrentShippingPopupCustomerId() {
		var customerIdInput = document.getElementById('customer_id');
		var billId = document.getElementById('bill_id');
		var hiddenBillId = document.getElementById('h_bill_id');
		var displayBillId = document.getElementById('display_bill_id');
		return String(
			(customerIdInput && customerIdInput.value) ||
			(billId && billId.value) ||
			(hiddenBillId && hiddenBillId.value) ||
			(displayBillId && displayBillId.textContent) ||
			''
		).trim();
	}

	function toggleSaveToCustomerDb(btn) {
		var customerId = getCurrentShippingPopupCustomerId();
		if (!customerId) {
			alert('เลือกลูกค้าก่อน');
			return;
		}
		var hiddenInput = document.getElementById('save_to_customer_db');
		if (!hiddenInput) return;

		if (hiddenInput.value === '1') {
			hiddenInput.value = '0';
			btn.style.backgroundColor = '#FFFFFF';
			btn.style.color = '#612989';
			btn.style.borderColor = '#EBEBEB';
			btn.innerHTML = '<img src="img/icons/database.png" alt="database" style="width: 16px; height: 16px;"> เพิ่มลงฐานลูกค้า';
		} else {
			hiddenInput.value = '1';
			btn.style.backgroundColor = '#612989';
			btn.style.color = '#FFFFFF';
			btn.style.borderColor = '#612989';
			btn.innerHTML = '<i class="fas fa-check"></i> เพิ่มลงฐานลูกค้า (เลือกแล้ว)';
		}
	}

	function openShippingAddressPopup() {
		var customerId = getCurrentShippingPopupCustomerId();
		if (!customerId) {
			alert('กรุณาเลือกลูกค้าก่อนค้นหาที่อยู่จัดส่ง');
			return;
		}

		var modal = document.getElementById('shippingAddressPopupModal');
		var search = document.getElementById('shippingAddressPopupSearch');
		var tbody = document.getElementById('shippingAddressPopupRows');
		if (!modal || !tbody) return;

		if (!window.originalShippingData) {
			var contactName = document.querySelector('input[name="customer_name"]');
			var contactTel = document.querySelector('input[name="customer_tel"]');
			var contactProvince = document.querySelector('select[name="province_name"]');
			var shippingAddress = document.querySelector('input[name="address_name"]');
			var installLocation = document.querySelector('input[name="address_send"]');

			window.originalShippingData = {
				customer_name: contactName ? contactName.value : '',
				customer_tel: contactTel ? contactTel.value : '',
				shipping_name: contactName ? contactName.value : '',
				shipping_province: contactProvince ? contactProvince.value : '',
				shipping_full_address: shippingAddress ? shippingAddress.value : '',
				install_location: installLocation ? installLocation.value : ''
			};
		}

		if (typeof shippingAddressPopupCustomerId !== 'undefined') shippingAddressPopupCustomerId = customerId;
		if (typeof shippingAddressPopupSelected !== 'undefined') shippingAddressPopupSelected = null;
		if (typeof shippingAddressPopupData !== 'undefined') shippingAddressPopupData = [];
		if (typeof toggleShippingAddressPopupLoadMore === 'function') toggleShippingAddressPopupLoadMore(false, false);
		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');

		if (typeof loadShippingAddressPopupRows === 'function') {
			loadShippingAddressPopupRows(search ? (search.value || '') : '', false);
		}
	}

	// ===== Popup ค้นหาลูกค้า (js/customer-popup.js, component กลาง) — ported จาก
	//       register_supbrhos.php:125-146,188-209. doCallAjax1()/data_customerbr1.php
	//       เดิมของ cshos ไม่ถูกแก้ไข แค่เรียกจากจุดใหม่นี้แทน onchange เดิม =====
	function setElementText(id, value) {
		var el = document.getElementById(id);
		if (el) {
			el.textContent = (value === null || value === undefined) ? '' : value;
		}
	}

	// Hook เรียกโดย js/customer-popup.js เมื่อผู้ใช้กด "ตกลง" เลือกลูกค้าในป๊อปอัป
	window.customerPopupOnConfirm = function(selectedCustomer) {
		selectedCustomer = selectedCustomer || {};
		var selectedCustId = String(selectedCustomer.customer_id || '').trim();

		var customerIdInput = document.getElementById('customer_id');
		if (customerIdInput) customerIdInput.value = selectedCustId;
		var hCustomer = document.getElementById('h_customer');
		if (hCustomer) hCustomer.value = selectedCustId;

		// ใช้ endpoint/ฟังก์ชันเดิมของ cshos ทุกจุด เติม customer/address/customer_typename ที่ submit จริง
		doCallAjax1('customer_id', 'customer', 'address', 'customer_typename');

		// ส่วนแสดงผล VIP/ประเภทลูกค้า/เครดิตเทอม — มาจาก response ของ popup โดยตรง (ajax_customer_popup_search.php
		// ดึงจาก tb_customer ตารางเดียวกับที่ data_customerbr1.php ใช้), ไม่ใช่ query ใหม่ ไม่กระทบข้อมูลที่ submit
		setElementText('display_bill_id', selectedCustomer.customer_id);
		setElementText('display_bill_tel', selectedCustomer.cus_tel);
		setElementText('display_bill_name', selectedCustomer.customer_name);
		setElementText('display_customer_typename', selectedCustomer.type_name);
		setElementText('display_credit_thb', 'ใบยืมฝากขาย/ยอดหนี้คงค้าง');
		setElementText('display_mode_name', selectedCustomer.status_cus);

		var vipIcon = document.getElementById('display_vip_icon');
		if (vipIcon) vipIcon.style.display = (String(selectedCustomer.vip_ckk) === '1') ? '' : 'none';

		syncCreditTermTriggerState();
	};

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

	function clearFieldValue(id) {
		var el = document.getElementById(id);
		if (el) el.value = '';
	}

	function clearCustomerSelection() {
		clearFieldValue('customer_id');
		clearFieldValue('h_customer');
		clearFieldValue('customer');
		clearFieldValue('address');
		clearFieldValue('customer_typename');

		clearFieldValue('customer_name');
		clearFieldValue('customer_tel');
		clearFieldValue('province_name');
		clearFieldValue('address_name');
		clearFieldValue('shipping_address_raw');
		clearFieldValue('shipping_ampher');
		clearFieldValue('shipping_postcode');
		clearFieldValue('shipping_id');

		setElementText('display_bill_id', '');
		setElementText('display_bill_tel', '');
		setElementText('display_mode_name', '');
		setElementText('display_bill_name', '');
		setElementText('display_customer_typename', '');
		setElementText('display_credit_thb', '');

		var vipIcon = document.getElementById('display_vip_icon');
		if (vipIcon) vipIcon.style.display = 'none';

		syncCreditTermTriggerState();
	}
</script>


<?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


$yearMonth = substr(date("Y") + 543, -2) . date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__consig ";
$qry = mysqli_query($conn, $sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = substr($rs['MAXID'], -5);
$maxId3 = substr($rs['MAXID'], -9);

$maxId1 = substr($maxId3, 0, -5);

$so = "BS";

if ($maxId1 == $yearMonth) {
	$maxId1 = ($maxId + 1);
	$maxId2 = substr("00000" . $maxId1, -5);
	$nextId = $yearMonth . $maxId2;
} else {
	$maxId1 = "00001";
	$nextId = $yearMonth . $maxId1;
}

// ตัวแปรรองรับแท็บ 'ที่อยู่เพิ่มเติม' ที่ port มาจาก register_supbrhos.php
$printCoverRefId = (isset($savedBr) && $savedBr !== null) ? $savedBr['ref_id_br'] : '';
$savedFirstExtraAddress = ['contact_name' => '', 'telephone' => '', 'province' => '', 'address' => ''];
$savedDeliveryBillAddress = ['contact_name' => '', 'telephone' => '', 'province' => '', 'address' => ''];
$savedExtraAddressRows = isset($savedShippingRows) ? $savedShippingRows : [];

if (isset($savedShippingRows) && is_array($savedShippingRows) && count($savedShippingRows) > 0) {
	$savedFirstExtraAddress = array(
		'contact_name' => $savedShippingRows[0]['contact_name'] ?? '',
		'telephone' => $savedShippingRows[0]['telephone'] ?? '',
		'province' => $savedShippingRows[0]['province'] ?? '',
		'address' => $savedShippingRows[0]['address'] ?? '',
	);
}

if (isset($savedDeliveryBillRow) && $savedDeliveryBillRow !== null) {
	$savedDeliveryBillAddress = array(
		'contact_name' => $savedDeliveryBillRow['customer_nameb'] ?? '',
		'telephone' => $savedDeliveryBillRow['customer_telb'] ?? '',
		'province' => $savedDeliveryBillRow['province'] ?? '',
		'address' => $savedDeliveryBillRow['address_nameb'] ?? '',
	);
}

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

?>

<div class="w3-container register-so-main" style="max-width:1096px;margin:0 auto;">

	<div class="so-header-container">
		<div class="so-header-left">
			<h1 class="so-title">ใบยืมฝากขาย</h1>
			<div class="so-ref-info">
				<span class="so-ref-label">เลขที่อ้างอิง</span>
				<span class="so-ref-value"><?php echo $so;
											echo $nextId; ?></span>
			</div>
		</div>
		<div class="so-header-right">
			<button type="button" class="btn-preview-so" onclick="csPreviewNotice();"><i class="far fa-eye"></i> Preview</button>
		</div>
	</div>

	<form action="register_supbrcshos1.php" method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">

		<script language="javascript">
			function fncSubmit() //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
			{

				if (document.frmMain.start_time.value == "") {

					alert('กรุณาใส่เวลาส่ง');
					document.frmMain.start_time.focus();
					return false;
				}

				if (document.frmMain.customer_name.value == "") {
					alert('กรุณาใส่ชื่อลูกค้า');
					brFocusField(document.frmMain.customer_name);
					return false;
				}

				if (document.frmMain.customer_tel.value == "") {
					alert('กรุณาใส่เบอร์โทรลูกค้า');
					brFocusField(document.frmMain.customer_tel);
					return false;
				}

				if (document.frmMain.address_name.value == "") {
					alert('กรุณาใส่ที่อยู่ในการส่งสินค้า');
					brFocusField(document.frmMain.address_name);
					return false;
				}

				if (document.frmMain.address_send.value == "") {
					alert('กรุณาใส่สถานที่ติดตั้งเครื่อง');
					brFocusField(document.frmMain.address_send);
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

		<input type="hidden" name="ref_id_br" class="w3-input" value="<?php echo $so;
																		echo $nextId; ?>">

		<!-- ===================== Tab: ข้อมูลเอกสาร / Admin =====================
		     Pattern ported from register_supbrhos.php:1580-1586 (switchBrMainTab) — UI only,
		     see plan "Add tab UI (ข้อมูลเอกสาร / Admin) using register_supbrhos.php as reference". -->
		<div class="so-tabs-container">
			<button type="button" class="so-tab-btn active" onclick="switchBrMainTab(this, 'tab-document-info')">ข้อมูลเอกสาร</button>
			<button type="button" class="so-tab-btn" onclick="switchBrMainTab(this, 'tab-admin-info')">Admin</button>
		</div>

		<div id="tab-document-info" class="so-tab-content active">
			<!-- Figma node 627:2681 (แท็บ "ข้อมูลเอกสาร") shows only these 2 elements — every other
			     field this document type actually needs (วันที่, เขตการขาย, แนบไฟล์, วัตถุประสงค์,
			     พนักงาน, แผนก) has been relocated to the cards below. -->
			<div class="so-card">
				<div class="so-doc-info-line">
					<div class="so-field-group" style="margin-bottom:0; flex:1; max-width:328px;">
						<label class="so-label">บริษัท</label>
						<div class="so-select-wrapper">
							<select class="so-select" name="company" id="company_select" required>
								<option value="1" selected>AWL</option>
								<option value="2">NBM</option>
							</select>
						</div>
					</div>

					<label class="so-toggle-pill so-doc-info-line-toggle">
						<input type="checkbox" name="que_ckk" id="que_ckk" value="1">
						<span>งานด่วน</span>
					</label>
				</div>

				<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='hidden'>
			</div>
		</div>

		<?php
		// Admin tab (UI only) — reuses the shared partials/admin_info_tab.php component already
		// used by register_suphos.php / register_supbrhos.php. register_supbrcshos.php is create-mode
		// only (no saved-document lookup), so every value below is intentionally blank; none of these
		// name= fields are read by register_supbrcshos1.php yet (see plan for the Phase-B backend pass).
		// "Run เอกสาร" / เลขที่ลงงาน-icon / "ยกเลิกเอกสาร" deliberately have no onclick — matches the
		// reference's own buttons (register_supbrhos.php:1336,1341 also have no onclick) and the
		// explicit "no new logic for these buttons" instruction.
		$adminInfoTab = [
			'tab_id' => 'tab-admin-info',
			'title' => 'ข้อมูลเพิ่มเติม (Admin)',
			'rows' => [
				[
					['type' => 'text', 'name' => 'admin_doc_no', 'label' => 'เลขที่เอกสาร', 'value' => '', 'placeholder' => 'No.'],
					['type' => 'button', 'icon' => 'img/icons/doc.png', 'label' => 'Run เอกสาร'],
					['type' => 'date_th', 'name' => 'admin_doc_date', 'label' => 'วันที่ออกเอกสาร', 'value' => '', 'icon' => 'far fa-calendar-alt'],
					['type' => 'text', 'name' => 'admin_work_no', 'label' => 'เลขที่ลงงาน', 'value' => '', 'icon' => 'img/icons/preview.png'],
				],
				[
					['type' => 'button', 'icon' => 'img/icons/circle_x.png', 'label' => 'ยกเลิกเอกสาร', 'variant' => 'danger'],
					['type' => 'text', 'name' => 'admin_cancel_reason', 'label' => 'หมายเหตุการยกเลิก', 'value' => '', 'icon' => 'fas fa-times', 'clearable' => true, 'span' => 3],
				],
			],
		];
		include __DIR__ . '/partials/admin_info_tab.php';
		?>

		<!-- ===================== Card: ข้อมูลลูกค้า ===================== -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">ข้อมูลลูกค้า</h2>
				<hr class="so-divider">
			</div>

			<!-- ปรับตาม register_supbrhos.php:1758-1856 — ปุ่ม popup ค้นหาลูกค้า + การ์ดแสดงข้อมูลลูกค้า
			     js/customer-popup.js เป็น component กลาง ใช้ร่วมกับ register_suphos.php/register_supbrhos.php
			     doCallAjax1()/data_customerbr1.php ของ cshos เองไม่ถูกแก้ไข แค่เปลี่ยนจุด trigger จาก
			     onchange ของช่องข้อความ มาเป็น customerPopupOnConfirm() หลังเลือกลูกค้าจาก popup แทน -->
			<div class="so-customer-top-grid">
				<div class="so-customer-top-left">
					<div class="so-customer-pills-row">
						<button type="button" class="btn-add-customer-pill" onclick="openCustomerPopup();">
							<img src="img/icons/add_user.png" alt="add_user" style="width: 23px;"> ข้อมูลลูกค้า
						</button>
					</div>

					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" for="customer">ชื่อลูกค้า/รพ. <span style="color:red;">*</span></label>
						<div class="so-input-wrapper">
							<input type="text" name="customer" id="customer" class="so-input" readonly placeholder="จะแสดงผลอัตโนมัติเมื่อเลือกเสร็จสิ้น" required>
							<button type="button" class="fas fa-times so-clear-icon" onclick="clearCustomerSelection();" aria-label="ล้างข้อมูลลูกค้าที่เลือก"></button>
						</div>
						<input type="hidden" name="customer_id" id="customer_id">
						<input type='hidden' name="h_customer" id="h_customer">
						<input type="hidden" name="customer_typename" id="customer_typename">
					</div>
				</div>

				<div class="so-customer-top-right">
					<div class="so-field-group" style="height: 100%; margin-bottom: 0;">
						<label class="so-label">ข้อมูลลูกค้า</label>
						<div class="customer-info-display-card">
							<div class="cidc-col">
								<div class="cidc-row">
									<div class="cidc-label">รหัสลูกค้า</div>
									<div class="cidc-value"><span id="display_bill_id" class="cidc-display-text"></span></div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">เบอร์โทรศัพท์</div>
									<div class="cidc-value"><span id="display_bill_tel" class="cidc-display-text"></span></div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">สถานะลูกค้า</div>
									<div class="cidc-value">
										<img src="img/icons/vip.png" class="cidc-status-icon" id="display_vip_icon" alt="VIP" style="display: none;">
										<span id="display_mode_name" class="cidc-display-text"></span>
									</div>
								</div>
							</div>
							<div class="cidc-col">
								<div class="cidc-row">
									<div class="cidc-label">ชื่อลูกค้า</div>
									<div class="cidc-value"><span id="display_bill_name" class="cidc-display-text"></span></div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">ประเภทลูกค้า</div>
									<div class="cidc-value"><span id="display_customer_typename" class="cidc-display-text"></span></div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">เครดิตเทอม</div>
									<div class="cidc-value">
										<button type="button" class="credit-term-trigger is-empty" id="display_credit_thb_trigger" aria-haspopup="dialog" aria-controls="creditTermPopupModal" aria-disabled="true" disabled onclick="if (typeof window.openCreditTermPopup === 'function') window.openCreditTermPopup();">
											<span id="display_credit_thb" class="credit-term-trigger-text"></span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="so-customer-address-wrap">
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" for="address">ที่อยู่ <span style="color:red;">*</span></label>
						<div class="so-input-wrapper">
							<input type="text" name="address" id="address" class="so-input" readonly placeholder="จะแสดงผลอัตโนมัติเมื่อเลือกเสร็จสิ้น" required>
							<button type="button" class="fas fa-times so-clear-icon" onclick="clearCustomerSelection();" aria-label="ล้างข้อมูลลูกค้าที่เลือก"></button>
						</div>
					</div>
				</div>
			</div>

			<input type="hidden" name="sale_comment" id="sale_comment" value="">
			<input type="hidden" name="sale_code" id="sale_code" value="">

		</div>

		<!-- ===================== Card: รายการสินค้า ===================== -->
		<div id="pd" class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">รายการสินค้า</h2>
				<span class="so-product-item-count" id="cs_summary_item_count">0 รายการ</span>
				<hr class="so-divider">
			</div>

			<?php include('detail_brschos_so.php');	?>

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
				['type' => 'date', 'name' => 'shipping_date', 'label' => 'วันที่คีย์ค่าส่ง', 'value' => so_saved_h($savedBr['date_ker'] ?? '')],
				['type' => 'text', 'name' => 'shipping_ref1', 'label' => 'รหัสอ้างอิง 1', 'value' => so_saved_h($savedBr['order_refer_code'] ?? '')],
				['type' => 'text', 'name' => 'shipping_ref2', 'label' => 'รหัสอ้างอิง 2', 'value' => so_saved_h($savedBr['order_refer_code1'] ?? '')],
				['type' => 'text', 'name' => 'shipping_cost', 'label' => 'ค่าจัดส่ง', 'value' => so_saved_h((($savedBr['ker_bath'] ?? '') !== '') ? $savedBr['ker_bath'] : '0.00')],
			],
		];
		include __DIR__ . '/partials/delivery_info_tab.php';
		?>
		<input type="hidden" name="end_time" id="end_time" value="<?php echo so_saved_h($savedEndTime ?? ''); ?>">
		<script>
			function syncDeliveryTimeRange() {
				var timeRange = document.getElementById('time_range');
				var startTime = document.querySelector('input[name="start_time"]');
				var endTime = document.getElementById('end_time') || document.querySelector('input[name="end_time"]');
				if (!timeRange || !startTime) return;

				var timeRangeMap = {
					morning: ['08:00', '12:00'],
					afternoon: ['13:00', '17:00'],
					allday: ['08:00', '17:00']
				};

				var val = timeRange.value;
				if (timeRangeMap[val]) {
					startTime.value = timeRangeMap[val][0];
					if (endTime) endTime.value = timeRangeMap[val][1];
				} else if (val === 'specific') {
					var normStart = (startTime.value || '').trim().substring(0, 5);
					var normEnd = endTime ? (endTime.value || '').trim().substring(0, 5) : '';
					if ((normStart === '08:00' && (normEnd === '12:00' || normEnd === '17:00')) ||
						(normStart === '13:00' && normEnd === '17:00')) {
						startTime.value = '';
						if (endTime) endTime.value = '';
					}
					startTime.focus();
				} else if (val === '') {
					startTime.value = '';
					if (endTime) endTime.value = '';
				}
			}

			function syncDeliveryTimeRangeFromInputs() {
				var timeRange = document.getElementById('time_range');
				var startTime = document.querySelector('input[name="start_time"]');
				var endTime = document.getElementById('end_time') || document.querySelector('input[name="end_time"]');
				if (!timeRange || !startTime) return;

				var startVal = (startTime.value || '').trim().substring(0, 5);
				var endVal = endTime ? (endTime.value || '').trim().substring(0, 5) : '';
				var currentRange = timeRange.value;

				if (!startVal && !endVal) {
					timeRange.value = '';
					return;
				}

				if (startVal === '08:00' && endVal === '12:00') {
					timeRange.value = 'morning';
				} else if (startVal === '13:00' && endVal === '17:00') {
					timeRange.value = 'afternoon';
				} else if (startVal === '08:00' && endVal === '17:00') {
					timeRange.value = 'allday';
				} else if (startVal === '08:00' && !endVal) {
					if (currentRange !== 'allday' && currentRange !== 'morning') {
						timeRange.value = 'morning';
					}
				} else if (startVal === '13:00' && !endVal) {
					timeRange.value = 'afternoon';
				} else {
					timeRange.value = 'specific';
				}
			}

			$(document).ready(function() {
				var timeRange = document.getElementById('time_range');
				var startTime = document.querySelector('input[name="start_time"]');
				if (timeRange) {
					$(timeRange).on('change', syncDeliveryTimeRange);
				}
				if (startTime) {
					$(startTime).on('input change', syncDeliveryTimeRangeFromInputs);
				}
			});
		</script>


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
					<button type="button" class="so-address-action-btn so-address-action-btn-primary" onclick="openShippingAddressPopup()" style="background-color: #F4E8FF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
						<i class="fas fa-search"></i> ค้นหาที่อยู่
					</button>
					<input type="hidden" name="save_to_customer_db" id="save_to_customer_db" value="0">
					<button type="button" class="so-address-action-btn so-address-action-btn-secondary" onclick="toggleSaveToCustomerDb(this)" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
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
						<button type="button" class="fas fa-times so-clear-icon" onclick="var i=this.closest('.so-input-wrapper').querySelector('input'); if(i) i.value=''; clearShippingAddressParts();" aria-label="ล้างค่า"></button>
					</div>
					<input type="hidden" name="shipping_address_raw" id="shipping_address_raw">
					<input type="hidden" name="shipping_ampher" id="shipping_ampher">
					<input type="hidden" name="shipping_postcode" id="shipping_postcode">
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
				<input type="hidden" name="shipping_id" id="shipping_id">
			</div>

			<div id="br_addr_detail" class="so-addr-tab-content" style="display:none;">
				<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">รายละเอียดที่อยู่</h3>
				<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

				<input type="hidden" name="status" value="ส่ง">
				<input type="hidden" name="department_show" value="ฝ่ายขาย">
				<input type="hidden" name="department_name" value="Sale">
				<input type="hidden" name="employee_name" value="<?php echo so_saved_h($_SESSION['name'] ?? ''); ?>">
				<input type="hidden" name="employee_tel" value="">
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
					function syncReturnTimeRangeFromTime() {
						const timeVal = ($('#returns_time').val() || '').trim();
						const rangeSelect = $('#return_time_range');
						const currentRange = rangeSelect.val();

						if (!timeVal) {
							rangeSelect.val('');
							return;
						}

						const normalizedTime = timeVal.substring(0, 5);
						if (normalizedTime === '08:00') {
							if (currentRange !== 'allday' && currentRange !== 'morning') {
								rangeSelect.val('morning');
							}
						} else if (normalizedTime === '13:00') {
							rangeSelect.val('afternoon');
						} else {
							rangeSelect.val('specific');
						}
					}

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
							} else if (val === 'specific') {
								const currentVal = (timeInput.val() || '').trim().substring(0, 5);
								if (currentVal === '08:00' || currentVal === '13:00') {
									timeInput.val('');
								}
								timeInput.focus();
							} else {
								timeInput.val('');
							}
						});

						$('#returns_time').on('input change', function() {
							syncReturnTimeRangeFromTime();
						});

						syncReturnTimeRangeFromTime();
					});
				</script>
			</div>
		</div>

		<!-- การ์ดแท็บ: ข้อความแจ้งแผนก / แนบไฟล์ -->
		<?php
		$docTabsCard = [
			'open_fn' => 'brOpen3Tab',
			'dept_comment' => ['enabled' => true, 'technician_required_checked' => false],
			'attach_file' => ['enabled' => true],
		];
		include __DIR__ . '/partials/doc_tabs_card.php';
		?>
		<script>
			const savedCommentSoForDept = null;
			const savedCommentSoItemsForDept = [];
		</script>
		<script src="js/doc-tabs-dept-comment.js?v=<?php echo filemtime(__DIR__ . '/js/doc-tabs-dept-comment.js'); ?>"></script>
		<script src="js/doc-tabs-attach.js?v=<?php echo filemtime(__DIR__ . '/js/doc-tabs-attach.js'); ?>"></script>

		<input type="hidden" name="slip1" id="hidden_slip_val1" value="">
		<input type="hidden" name="slip2" id="hidden_slip_val2" value="">
		<input type="hidden" name="slip3" id="hidden_slip_val3" value="">
		<input type="hidden" name="slip4" id="hidden_slip_val4" value="">
		<input type="hidden" name="slip5" id="hidden_slip_val5" value="">

	</div><!-- /register-so-main -->

	<div class="so-sticky-actions">
		<div class="so-sticky-actions-inner">
			<button type="submit" name="submit" value="submit" class="btn-so-submit"><i class="fas fa-paper-plane"></i> Submit</button>
			<button type="button" name="save_draft" class="btn-so-draft" onclick="brcsSaveDraft();"><i class="far fa-save"></i> Save Draft</button>
		</div>
	</div>

	</form>

<!-- Modal รายชื่อลูกค้า: ported 1:1 from register_supbrhos.php:2957-3004 (shared, doc-type-agnostic
     component — js/customer-popup.js + ajax_customer_popup_search.php). ตกลง -> window.customerPopupOnConfirm()
     ด้านบน ซึ่งเรียก doCallAjax1() เดิมของ cshos ต่อ ไม่มี logic ใหม่ในฝั่ง backend. -->
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

<!-- Credit Term Modal -->
<div id="creditTermPopupModal" class="customer-popup-modal" aria-hidden="true" style="display: none;">
	<div class="customer-popup-box credit-term-popup-box" role="dialog" aria-modal="true" aria-labelledby="creditTermPopupTitle">
		<button type="button" class="customer-popup-close" onclick="closeCreditTermPopup()" aria-label="Close">&times;</button>

		<div class="clear-loan-header">
			<h2 id="creditTermPopupTitle">เครดิตเทอม</h2>
		</div>

		<div class="credit-term-popup-content">
			<div class="credit-term-summary">
				<div class="credit-term-summary-item">
					<p class="credit-term-summary-label">เครดิต (วัน)</p>
					<p class="credit-term-summary-value" id="creditTermSummaryDay">-</p>
				</div>
				<div class="credit-term-summary-item">
					<p class="credit-term-summary-label">เครดิต (ยอดเงิน)</p>
					<p class="credit-term-summary-value" id="creditTermSummaryAmount">0.00</p>
				</div>
				<div class="credit-term-summary-item">
					<p class="credit-term-summary-label">ยอดรวมหนี้คงค้าง</p>
					<p class="credit-term-summary-value" id="creditTermSummaryOutstanding">0.00</p>
				</div>
				<div class="credit-term-summary-item is-highlight">
					<p class="credit-term-summary-label">ยอดเครดิตคงเหลือ</p>
					<p class="credit-term-summary-value" id="creditTermSummaryRemaining">0.00</p>
				</div>
			</div>

			<div class="credit-term-table-panel">
				<div class="credit-term-table-wrap">
					<table class="credit-term-table">
						<thead>
							<tr>
								<th scope="col" aria-label="เลือก"></th>
								<th scope="col">เลขที่ใบสั่งขาย</th>
								<th scope="col">รายการสินค้า</th>
								<th scope="col">ยอดที่ต้องชำระ</th>
								<th scope="col">ยอดชำระแล้ว</th>
								<th scope="col">ยอดหนี้คงค้าง</th>
							</tr>
						</thead>
						<tbody id="creditTermTableBody">
							<tr class="credit-term-empty-row">
								<td><span class="credit-term-caret" aria-hidden="true"></span></td>
								<td colspan="5">เลือกลูกค้าแล้วกดเปิดเครดิตเทอมเพื่อดูข้อมูล</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal ที่อยู่จัดส่ง (UI-only, Figma parity) — reuses the shared ajax_shipping_address_popup_search.php
     endpoint and tb_shipping_address table as-is; selection currently only fills the visible form fields,
     register_supbrcshos1.php doesn't persist it to tb_shipping_address yet, see plan Phase B-UI. -->
<div id="shippingAddressPopupModal" class="customer-popup-modal shipping-popup-modal" aria-hidden="true">
	<div class="customer-popup-box shipping-popup-box" role="dialog" aria-modal="true" aria-labelledby="csShippingAddressPopupTitle">
		<button type="button" class="customer-popup-close" onclick="csCloseShippingAddressPopup()" aria-label="Close">&times;</button>

		<div class="clear-loan-header">
			<h2 id="csShippingAddressPopupTitle">ที่อยู่จัดส่ง</h2>
			<div class="customer-popup-toolbar shipping-popup-toolbar" style="margin-top: 18px;">
				<div class="customer-popup-search-wrap">
					<label for="csShippingAddressPopupSearch">ค้นหาที่อยู่จัดส่ง</label>
					<div class="customer-popup-search">
						<i class="fas fa-search"></i>
						<input type="text" id="csShippingAddressPopupSearch" placeholder="ค้นหาด้วยชื่อ / เบอร์โทร">
					</div>
				</div>
			</div>
		</div>

		<div class="customer-popup-table-wrap">
			<table class="customer-popup-table shipping-popup-table">
				<thead>
					<tr>
						<th scope="col" aria-label="เลือก"></th>
						<th scope="col">รหัสลูกค้า</th>
						<th scope="col">ชื่อลูกค้า</th>
						<th scope="col">เบอร์โทร</th>
						<th scope="col">ชื่อผู้รับสินค้า</th>
						<th scope="col">ที่อยู่จัดส่ง</th>
					</tr>
				</thead>
				<tbody id="csShippingAddressPopupRows">
					<tr>
						<td colspan="6" class="customer-popup-empty">เลือกลูกค้าก่อนค้นหาที่อยู่จัดส่ง</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="customer-popup-pagination" id="csShippingAddressPopupPagination" style="display:none;">
			<button type="button" class="customer-popup-loadmore" id="csShippingAddressPopupLoadMore" onclick="csLoadMoreShippingAddressPopupRows()">โหลดเพิ่ม</button>
		</div>

		<div class="customer-popup-actions">
			<button type="button" class="customer-popup-confirm" onclick="csConfirmShippingAddressPopupSelection()">ตกลง</button>
			<button type="button" class="customer-popup-cancel" onclick="csCloseShippingAddressPopup()">ย้อนกลับ</button>
		</div>
	</div>
</div>

<script>
	// ===== ที่อยู่จัดส่ง: ค้นหา / เลือก / เพิ่มลงฐานลูกค้า (UI-only, cs-prefixed to avoid colliding
	//       with any future shared script) — ported from register_supbrhos.php =====
	var csShippingAddressPopupSelected = null;
	var csShippingAddressPopupTimer = null;
	var csShippingAddressPopupData = [];
	var csShippingAddressPopupKeyword = '';
	var csShippingAddressPopupNextLastId = null;
	var csShippingAddressPopupHasMore = false;
	var csShippingAddressPopupLoading = false;
	var csShippingAddressPopupPageSize = 20;
	var csShippingAddressPopupCustomerId = '';

	function csGetCurrentShippingPopupCustomerId() {
		var customerIdInput = document.getElementById('customer_id');
		var hCustomer = document.getElementById('h_customer');
		return String((customerIdInput && customerIdInput.value) || (hCustomer && hCustomer.value) || '').trim();
	}

	function csToggleSaveToCustomerDb(btn) {
		var customerId = csGetCurrentShippingPopupCustomerId();
		if (!customerId) {
			alert('เลือกลูกค้าก่อน');
			return;
		}
		var hiddenInput = document.getElementById('save_to_customer_db');
		if (!hiddenInput) return;

		if (hiddenInput.value === '1') {
			hiddenInput.value = '0';
			btn.style.backgroundColor = '#FFFFFF';
			btn.style.color = '#612989';
			btn.style.borderColor = '#EBEBEB';
			btn.innerHTML = '<img src="img/icons/database.png" alt="database" style="width: 16px; height: 16px;"> เพิ่มลงฐานลูกค้า';
		} else {
			hiddenInput.value = '1';
			btn.style.backgroundColor = '#612989';
			btn.style.color = '#FFFFFF';
			btn.style.borderColor = '#612989';
			btn.innerHTML = '<i class="fas fa-check"></i> เพิ่มลงฐานลูกค้า (เลือกแล้ว)';
		}
	}

	function csOpenShippingAddressPopup() {
		var customerId = csGetCurrentShippingPopupCustomerId();
		if (!customerId) {
			alert('กรุณาเลือกลูกค้าก่อนค้นหาที่อยู่จัดส่ง');
			return;
		}

		var modal = document.getElementById('shippingAddressPopupModal');
		var search = document.getElementById('csShippingAddressPopupSearch');
		var tbody = document.getElementById('csShippingAddressPopupRows');
		if (!modal || !tbody) return;

		csShippingAddressPopupCustomerId = customerId;
		csShippingAddressPopupSelected = null;
		csShippingAddressPopupData = [];
		csShippingAddressPopupNextLastId = null;
		csShippingAddressPopupHasMore = false;
		csShippingAddressPopupKeyword = search ? (search.value || '') : '';
		csToggleShippingAddressPopupLoadMore(false, false);
		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');

		csLoadShippingAddressPopupRows(csShippingAddressPopupKeyword, false);
		setTimeout(function() {
			if (search) {
				search.focus();
				search.select();
			}
		}, 50);
	}

	function csCloseShippingAddressPopup() {
		var modal = document.getElementById('shippingAddressPopupModal');
		if (!modal) return;
		modal.style.display = 'none';
		modal.setAttribute('aria-hidden', 'true');
	}

	function csEscapeShippingPopupHtml(value) {
		return String(value || '').replace(/[&<>"']/g, function(char) {
			return {
				'&': '&amp;',
				'<': '&lt;',
				'>': '&gt;',
				'"': '&quot;',
				"'": '&#039;'
			} [char];
		});
	}

	function csToggleShippingAddressPopupLoadMore(visible, loading) {
		var wrap = document.getElementById('csShippingAddressPopupPagination');
		var button = document.getElementById('csShippingAddressPopupLoadMore');
		if (!wrap || !button) return;
		wrap.style.display = visible ? 'flex' : 'none';
		button.disabled = !!loading;
		button.textContent = loading ? 'กำลังโหลด...' : 'โหลดเพิ่ม';
	}

	function csRenderShippingAddressPopupRows(addresses, emptyMessage) {
		var tbody = document.getElementById('csShippingAddressPopupRows');
		if (!tbody) return;

		addresses = addresses || csShippingAddressPopupData || [];
		if (!addresses.length) {
			var message = emptyMessage || 'ไม่พบข้อมูลที่อยู่จัดส่ง';
			tbody.innerHTML = '<tr><td colspan="6" class="customer-popup-empty">' + csEscapeShippingPopupHtml(message) + '</td></tr>';
			csShippingAddressPopupSelected = null;
			csToggleShippingAddressPopupLoadMore(false, false);
			return;
		}

		var selectedKey = csShippingAddressPopupSelected ? String(csShippingAddressPopupSelected.__selectionKey || csShippingAddressPopupSelected.row_id) : '';
		var rowsHtml = addresses.map(function(address, index) {
			address.__selectionKey = address.row_id ? ('row-' + address.row_id) : ('customer-' + (address.customer_id || '0') + '-' + index);
			var customerCode = address.customer_code || '-';
			var customerName = address.customer_name || '-';
			var phone = address.shipping_tel || address.customer_tel || '-';
			var shippingName = address.shipping_name || customerName;
			var fullAddress = address.shipping_full_address || address.shipping_address || '-';
			var rowClass = selectedKey === address.__selectionKey ? 'selected' : '';
			var isChecked = selectedKey === address.__selectionKey ? 'checked' : '';

			return '<tr class="' + rowClass + '" data-index="' + index + '" onclick="csSelectShippingAddressPopupRow(' + index + ')">' +
				'<td class="shipping-popup-select-cell" style="text-align: center;">' +
				'<label class="shipping-custom-radio" onclick="event.stopPropagation();">' +
				'<input type="radio" class="shipping-popup-radio-input" name="cs_shipping_popup_choice" ' + isChecked + ' onclick="csSelectShippingAddressPopupRow(' + index + ')">' +
				'<span class="checkmark"></span>' +
				'</label>' +
				'</td>' +
				'<td>' + csEscapeShippingPopupHtml(customerCode) + '</td>' +
				'<td>' + csEscapeShippingPopupHtml(customerName) + '</td>' +
				'<td>' + csEscapeShippingPopupHtml(phone) + '</td>' +
				'<td>' + csEscapeShippingPopupHtml(shippingName) + '</td>' +
				'<td>' + csEscapeShippingPopupHtml(fullAddress) + '</td>' +
				'</tr>';
		});

		tbody.innerHTML = rowsHtml.join('');
		csShippingAddressPopupData = addresses;
		if (!csShippingAddressPopupSelected && addresses.length > 0) {
			csSelectShippingAddressPopupRow(0);
		}
		csToggleShippingAddressPopupLoadMore(csShippingAddressPopupHasMore, false);
	}

	function csLoadShippingAddressPopupRows(keyword, append) {
		var tbody = document.getElementById('csShippingAddressPopupRows');
		if (csShippingAddressPopupLoading) return;
		csShippingAddressPopupLoading = true;

		if (!append && tbody) {
			tbody.innerHTML = '<tr><td colspan="6" class="customer-popup-empty">กำลังค้นหา...</td></tr>';
		}
		if (!append) {
			csShippingAddressPopupSelected = null;
			csShippingAddressPopupData = [];
			csShippingAddressPopupNextLastId = null;
			csShippingAddressPopupHasMore = false;
			csShippingAddressPopupKeyword = keyword || '';
		}
		csToggleShippingAddressPopupLoadMore(append || csShippingAddressPopupHasMore, append);

		var requestUrl = 'ajax_shipping_address_popup_search.php?customer_id=' + encodeURIComponent(csShippingAddressPopupCustomerId) +
			'&q=' + encodeURIComponent(csShippingAddressPopupKeyword || '') +
			'&limit=' + encodeURIComponent(csShippingAddressPopupPageSize);
		if (append && csShippingAddressPopupNextLastId) {
			requestUrl += '&last_id=' + encodeURIComponent(csShippingAddressPopupNextLastId);
		}

		fetch(requestUrl, {
				credentials: 'same-origin',
				cache: 'no-store'
			})
			.then(function(response) {
				return response.json();
			})
			.then(function(data) {
				if (!data || !data.success) {
					csShippingAddressPopupData = [];
					csShippingAddressPopupHasMore = false;
					csShippingAddressPopupNextLastId = null;
					csRenderShippingAddressPopupRows([], (data && data.message) ? data.message : 'ไม่สามารถโหลดข้อมูลที่อยู่จัดส่งได้');
					return;
				}
				var newAddresses = data.addresses || [];
				csShippingAddressPopupData = append ? csShippingAddressPopupData.concat(newAddresses) : newAddresses;
				csShippingAddressPopupHasMore = !!(data.pagination && data.pagination.has_more);
				csShippingAddressPopupNextLastId = data.pagination ? data.pagination.next_last_id : null;
				csRenderShippingAddressPopupRows(csShippingAddressPopupData);
			})
			.catch(function() {
				csShippingAddressPopupHasMore = false;
				csShippingAddressPopupNextLastId = null;
				if (tbody) {
					tbody.innerHTML = '<tr><td colspan="6" class="customer-popup-empty">ไม่สามารถค้นหาข้อมูลได้</td></tr>';
				}
				csToggleShippingAddressPopupLoadMore(false, false);
			})
			.finally(function() {
				csShippingAddressPopupLoading = false;
				if (csShippingAddressPopupHasMore) {
					csToggleShippingAddressPopupLoadMore(true, false);
				}
			});
	}

	function csLoadMoreShippingAddressPopupRows() {
		if (!csShippingAddressPopupHasMore || !csShippingAddressPopupNextLastId) return;
		csLoadShippingAddressPopupRows(csShippingAddressPopupKeyword, true);
	}

	function csSelectShippingAddressPopupRow(index) {
		var rows = document.querySelectorAll('#csShippingAddressPopupRows tr');
		var address = (csShippingAddressPopupData || [])[index];
		if (!address) return;
		rows.forEach(function(row) {
			row.classList.remove('selected');
		});
		if (rows[index]) rows[index].classList.add('selected');
		var radios = document.querySelectorAll('input[name="cs_shipping_popup_choice"]');
		radios.forEach(function(radio, radioIndex) {
			radio.checked = radioIndex === index;
		});
		csShippingAddressPopupSelected = address;
	}

	function csConfirmShippingAddressPopupSelection() {
		if (!csShippingAddressPopupSelected) {
			alert('กรุณาเลือกที่อยู่จัดส่งก่อน');
			return;
		}
		csApplyShippingSelection(csShippingAddressPopupSelected);
		csCloseShippingAddressPopup();
	}

	function csSetShippingFieldValueBySelector(selector, value) {
		var element = document.querySelector(selector);
		if (element) {
			element.value = value || '';
		}
	}

	// เติมค่าลงฟิลด์จริงของฟอร์ม cshos
	function csApplyShippingSelection(data) {
		data = data || {};
		var fullAddress = String(data.shipping_full_address || '').trim();
		csSetShippingFieldValueBySelector('input[name="customer_name"]', data.shipping_name || data.customer_name || '');
		csSetShippingFieldValueBySelector('input[name="customer_tel"]', data.shipping_tel || data.customer_tel || '');
		csSetShippingFieldValueBySelector('select[name="province_name"]', data.shipping_province || '');
		csSetShippingFieldValueBySelector('textarea[name="address_name"]', fullAddress);
		csSetShippingFieldValueBySelector('textarea[name="address_send"]', data.install_location || '');
		if (data.location_link) {
			csSetShippingFieldValueBySelector('input[name="location_link"]', data.location_link);
		}
		csSetShippingFieldValueBySelector('input[name="shipping_id"]', data.row_id || '');
	}

	document.addEventListener('DOMContentLoaded', function() {
		var search = document.getElementById('csShippingAddressPopupSearch');
		if (search) {
			search.addEventListener('input', function() {
				clearTimeout(csShippingAddressPopupTimer);
				csShippingAddressPopupTimer = setTimeout(function() {
					csShippingAddressPopupSelected = null;
					csLoadShippingAddressPopupRows(search.value, false);
				}, 250);
			});
		}
	});
</script>

<script type="text/javascript">
	function make_autocom(autoObj, showObj) {
		var mkAutoObj = autoObj;
		var mkSerValObj = showObj;
		new Autocomplete(mkAutoObj, function() {
			this.setValue = function(id) {
				document.getElementById(mkSerValObj).value = id;
			}
			if (this.isModified)
				this.setValue("");
			if (this.value.length < 1 && this.isNotClick)
				return;
			return "data_bill_name2.php?bill_search=" + encodeURIComponent(this.value);
		});
	}

	// การใช้งาน
	// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
	make_autocom("customer_id", "h_customer");
</script>




<script>
	$('#more').click(function() {
		if ($(this).is(":checked")) {
			$("#more-2").show();
		} else {
			$("#more-2").hide();
		}
	});
</script>