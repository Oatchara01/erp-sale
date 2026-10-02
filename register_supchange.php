<?php include('head.php');
include('dbconnect_sale.php');
?>
<?php require_once __DIR__ . '/includes/so_saved_helpers.php'; ?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-supbrcshos.css?v=<?php echo filemtime(__DIR__ . '/css/register-supbrcshos.css'); ?>">
<link rel="stylesheet" href="css/register-supchange.css?v=<?php echo filemtime(__DIR__ . '/css/register-supchange.css'); ?>">
<link rel="stylesheet" href="css/credit-term-modal.css?v=<?php echo filemtime(__DIR__ . '/css/credit-term-modal.css'); ?>">
<script src="js/customer-popup.js?v=<?php echo filemtime(__DIR__ . '/js/customer-popup.js'); ?>"></script>
<script src="js/credit-term-modal.js?v=<?php echo filemtime(__DIR__ . '/js/credit-term-modal.js'); ?>"></script>
<script src="js/doc-tabs-attach.js?v=<?php echo filemtime(__DIR__ . '/js/doc-tabs-attach.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/so-required-fields.js?v=<?php echo filemtime(__DIR__ . '/js/so-required-fields.js'); ?>"></script>

<?php if (isset($_GET["saved"]) && $_GET["saved"] === "1") { ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var cleanUrl = new URL(window.location.href);
			cleanUrl.searchParams.delete('saved');
			window.history.replaceState({}, document.title, cleanUrl);

			if (typeof Swal === 'undefined') {
				alert('บันทึกข้อมูลเรียบร้อยแล้ว');
				return;
			}

			Swal.fire({
				title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
				text: 'ระบบแสดงข้อมูลที่บันทึกไว้ในหน้านี้แล้ว',
				icon: 'success',
				confirmButtonColor: '#612989',
				confirmButtonText: 'ตกลง'
			});
		});
	</script>
<?php } ?>

<!-- ===================== ค้นหา/เลือกลูกค้า — ported จาก register_supbrcshos.php:38-108
     (doCallAjax1 -> data_customerbr1.php ตัวเดียวกับที่ระบบใช้อยู่แล้ว ไม่มีการแก้ backend) ===================== -->
<script language="JavaScript">
	var HttPRequest = false;

	function doCallAjax1(customer_id, customer, address, customer_typename) {
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
		var url = 'data_customerbr1.php';
		var pmeters = "customer_id=" + encodeURI(document.getElementById(customer_id).value);
		HttPRequest.open('POST', url, true);

		HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		HttPRequest.setRequestHeader("Content-length", pmeters.length);
		HttPRequest.setRequestHeader("Connection", "close");
		HttPRequest.send(pmeters);

		HttPRequest.onreadystatechange = function() {
			if (HttPRequest.readyState == 4) {
				var myProduct = HttPRequest.responseText;

				if (myProduct != "") {
					var myArr = myProduct.split("|");

					document.getElementById(customer).value = myArr[0];
					document.getElementById(address).value = myArr[1];
					document.getElementById(customer_typename).value = myArr[2];

					var shipCustomerName = document.getElementById('customer_name');
					if (shipCustomerName) shipCustomerName.value = myArr[9] || '';
					var shipCustomerTel = document.getElementById('customer_tel');
					if (shipCustomerTel) shipCustomerTel.value = myArr[10] || myArr[3] || '';
					var shipProvince = document.getElementById('province_name');
					if (shipProvince) shipProvince.value = myArr[7] || '';
					var shipAddressName = document.getElementById('address_name');
					if (shipAddressName) shipAddressName.value = myArr[11] || '';
					var shipAddressMerged = document.getElementById('address_merged_ui');
					var shipAddress1 = document.getElementById('address_1');
					if (shipAddressMerged) {
						shipAddressMerged.value = myArr[11] || '';
						if (shipAddress1) shipAddress1.value = myArr[11] || '';
					}
				}
			}
		}
	}

	function setElementText(id, value) {
		var el = document.getElementById(id);
		if (el) {
			el.textContent = (value === null || value === undefined) ? '' : value;
		}
	}

	/* ===== เครดิตเทอม — ported จาก register_suphos.php:24-61 (setElementValue's credit_thb
	   formatting branch + syncCreditTermTriggerState) js/credit-term-modal.js อ่านค่าจาก
	   id="bill_id"/id="h_bill_id" ตายตัว จึงต้องมี hidden input คู่นี้ mirror จาก customer_id
	   ไว้เฉพาะสำหรับ modal นี้ (ไม่มี name= จึงไม่ถูก register_supchange1.php อ่าน) ===== */
	function setCreditThbDisplay(value) {
		var el = document.getElementById('display_credit_thb');
		if (!el) return;
		var normalizedValue = value || "";
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
		el.textContent = normalizedValue;
		syncCreditTermTriggerState();
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

	window.customerPopupOnConfirm = function(selectedCustomer) {
		selectedCustomer = selectedCustomer || {};
		var selectedCustId = String(selectedCustomer.customer_id || '').trim();

		var customerIdInput = document.getElementById('customer_id');
		if (customerIdInput) customerIdInput.value = selectedCustId;
		var hCustomer = document.getElementById('h_customer');
		if (hCustomer) hCustomer.value = selectedCustId;

		var billIdInput = document.getElementById('bill_id');
		if (billIdInput) billIdInput.value = selectedCustId;
		var hBillIdInput = document.getElementById('h_bill_id');
		if (hBillIdInput) hBillIdInput.value = selectedCustId;

		doCallAjax1('customer_id', 'customer', 'address', 'customer_typename');

		setElementText('display_bill_id', selectedCustomer.customer_id);
		setElementText('display_bill_tel', selectedCustomer.cus_tel);
		setElementText('display_bill_name', selectedCustomer.customer_name);
		setElementText('display_customer_typename', selectedCustomer.type_name);
		setElementText('display_mode_name', selectedCustomer.status_cus);
		setCreditThbDisplay(selectedCustomer.credit_thb);

		var vipIcon = document.getElementById('display_vip_icon');
		if (vipIcon) vipIcon.style.display = (String(selectedCustomer.vip_ckk) === '1') ? '' : 'none';
	};

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
		clearFieldValue('bill_id');
		clearFieldValue('h_bill_id');

		setElementText('display_bill_id', '');
		setElementText('display_bill_tel', '');
		setElementText('display_mode_name', '');
		setElementText('display_bill_name', '');
		setElementText('display_customer_typename', '');
		setCreditThbDisplay('');

		var vipIcon = document.getElementById('display_vip_icon');
		if (vipIcon) vipIcon.style.display = 'none';
	}
</script>

<!-- ===================== แท็บต่างๆ — ported 1:1 จาก register_supbrcshos.php (switchBrMainTab /
     brOpenDelTab / brOpen3Tab / brOpenAddrTab) เป็น pure UI toggle ล้วน ===================== -->
<script language="JavaScript">
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

	function brOpenAddrTab(tabId, element) {
		var contents = document.getElementsByClassName('so-addr-tab-content');
		for (var i = 0; i < contents.length; i++) contents[i].style.display = 'none';
		var btns = element.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < btns.length; i++) btns[i].classList.remove('active');
		document.getElementById(tabId).style.display = 'block';
		element.classList.add('active');
	}
</script>

<?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


$yearMonth = substr(date("Y") + 543, -2) . date("m");
$sql1 = "SELECT MAX(ref_id) AS MAXID FROM hos__change ";
$qry1 = mysqli_query($conn, $sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$maxId = substr((string)$rs1['MAXID'], -3);
$maxId3 = substr((string)$rs1['MAXID'], -7);

$maxId1 = substr($maxId3, 0, -3);

$so = "CH";

if ($maxId1 == $yearMonth) {
	$maxId1 = ($maxId + 1);
	$maxId2 = substr("000" . $maxId1, -3);
	$nextId = $yearMonth . $maxId2;
} else {
	$maxId1 = "001";
	$nextId = $yearMonth . $maxId1;
}

$chgIsEngDept = (($_SESSION["department"] ?? '') === 'วิศวกรรม');

// ===== โหลดเอกสารเดิม (view/edit mode) เมื่อมี ?ref_id=... =====
// พอร์ตจาก register_supbrcshos.php:470-564 — hos__change ใช้ ref_id เป็นคีย์ (เหมือน hos__consig)
// ทุก query กันด้วย mysqli_num_rows เหมือนต้นแบบ ไม่มีแถวแล้วปล่อยเป็น null/[] เพื่อ fallback เป็นฟอร์มว่าง
$savedChgRefId = isset($_GET["ref_id"]) ? mysqli_real_escape_string($conn, $_GET["ref_id"]) : "";
// คัดลอกใบเดิม: ?copy_from=... โหลดข้อมูลเอกสารเก่ามา prefill แต่ต้องไม่ตั้ง $savedChg
// เพื่อให้ $chgIsEditMode ยังคงเป็น false (สร้างเอกสารใหม่จริง ไม่ใช่ทับเอกสารเดิม) — ดู register_supbrcshos.php:474-478
$copyFromRefId = isset($_GET["copy_from"]) ? mysqli_real_escape_string($conn, $_GET["copy_from"]) : "";
$loadRefId = $savedChgRefId !== "" ? $savedChgRefId : $copyFromRefId;
$savedChg = null;
$copySrcChg = null;
$savedCustomer = null;
$savedProducts = array();
$savedOtherBill = null;
$savedTransaction = null;
$savedShippingRows = array();
$savedDeliveryBillRow = null;
$savedRegister = null;
$chgDocumentLogRows = array();

if ($loadRefId !== "") {
	$savedChgQuery = mysqli_query($conn, "SELECT * FROM hos__change WHERE ref_id = '" . $loadRefId . "' LIMIT 1");
	if ($savedChgQuery && mysqli_num_rows($savedChgQuery) > 0) {
		$loadedChg = mysqli_fetch_assoc($savedChgQuery);
		if ($savedChgRefId !== "") {
			$savedChg = $loadedChg;
		} else {
			$copySrcChg = $loadedChg;
		}

		$savedOtherBillQuery = mysqli_query($conn, "SELECT * FROM tb_other_bill WHERE ref_id = '" . $loadRefId . "' LIMIT 1");
		if ($savedOtherBillQuery) {
			$savedOtherBill = mysqli_fetch_assoc($savedOtherBillQuery);
		}

		$savedTransactionQuery = mysqli_query($conn, "SELECT * FROM tb_transaction WHERE ref_id = '" . $loadRefId . "' LIMIT 1");
		if ($savedTransactionQuery) {
			$savedTransaction = mysqli_fetch_assoc($savedTransactionQuery);
		}

		$savedShippingQuery = mysqli_query($conn, "SELECT * FROM tb_shipping_address WHERE ref_id = '" . $loadRefId . "' ORDER BY id ASC");
		if ($savedShippingQuery) {
			while ($savedShippingRow = mysqli_fetch_assoc($savedShippingQuery)) {
				$savedShippingRows[] = $savedShippingRow;
			}
		}

		$savedDeliveryBillQuery = mysqli_query($conn, "SELECT * FROM tb_delivery_bill WHERE ref_id = '" . $loadRefId . "' LIMIT 1");
		if ($savedDeliveryBillQuery) {
			$savedDeliveryBillRow = mysqli_fetch_assoc($savedDeliveryBillQuery);
		}

		$savedRegisterQuery = mysqli_query($conn, "SELECT * FROM tb_register_data WHERE ref_id = '" . $loadRefId . "' LIMIT 1");
		if ($savedRegisterQuery) {
			$savedRegister = mysqli_fetch_assoc($savedRegisterQuery);
		}

		// LEFT JOIN tb_product จำเป็น เพราะ hos__subchange ไม่มีคอลัมน์ product_name/unit_name/access_code ของตัวเอง
		$savedProductsQuery = mysqli_query($conn, "SELECT hos__subchange.*, tb_product.access_code AS tb_access_code, tb_product.sol_name AS tb_sol_name, tb_product.unit_name AS tb_unit_name FROM hos__subchange LEFT JOIN tb_product ON hos__subchange.product_id = tb_product.product_ID WHERE hos__subchange.ref_idd = '" . $loadRefId . "' ORDER BY hos__subchange.id ASC");
		if ($savedProductsQuery) {
			while ($savedProductRow = mysqli_fetch_assoc($savedProductsQuery)) {
				$savedProducts[] = $savedProductRow;
			}
		}

		// การ์ด "ข้อมูลลูกค้า" (display_bill_id ฯลฯ) เป็นฟิลด์แสดงผลอย่างเดียว ไม่ได้เก็บใน hos__change
		// view/copy mode จึงต้อง query tb_customer เองเพื่อเติมการ์ดนี้ — query เดียวกับ register_supbrcshos.php:558
		if (!empty($loadedChg['customer_id'])) {
			$savedCustomerId = mysqli_real_escape_string($conn, $loadedChg['customer_id']);
			$savedCustomerQuery = mysqli_query($conn, "SELECT c.customer_id, c.first_name, c.last_name, c.customer_name, c.bill_name, c.cus_tel, c.bill_tel, c.status_cus, c.vip_ckk, t.type_name FROM tb_customer c LEFT JOIN tb_typecustomer t ON c.type_customer = t.type_id WHERE c.customer_id = '" . $savedCustomerId . "' LIMIT 1");
			if ($savedCustomerQuery && mysqli_num_rows($savedCustomerQuery) > 0) {
				$savedCustomer = mysqli_fetch_assoc($savedCustomerQuery);
			}
		}

		// ประวัติส่งกลับ/ไม่อนุมัติ/ยกเลิก — เฉพาะ edit mode จริง (copy mode ต้องไม่รับประวัติของใบต้นทางมาด้วย)
		// mirror ของ register_supbrcshos.php:565-577 — เช็คตารางก่อนกัน environment ที่ยังไม่มี tb_document_status_log
		// hos__change เก็บสถานะเป็นไทย ('ส่งกลับ'/'ยกเลิก') แต่ log เขียนเป็นอังกฤษเหมือนเอกสารอื่น จึงต้องรับทั้งสองชุด
		if ($savedChgRefId !== "") {
			$chgDocumentStatusLogTableQuery = mysqli_query($conn, "SHOW TABLES LIKE 'tb_document_status_log'");
			if ($chgDocumentStatusLogTableQuery && mysqli_num_rows($chgDocumentStatusLogTableQuery) > 0) {
				$chgDocumentLogQuery = mysqli_query($conn, "SELECT status_doc, reason, user_name, created_at FROM tb_document_status_log WHERE ref_id = '" . $loadRefId . "' AND status_doc IN ('Returned', 'ส่งกลับ', 'Rejected', 'Cancelled', 'ยกเลิก') ORDER BY created_at DESC, id DESC");
				if ($chgDocumentLogQuery) {
					while ($chgDocumentLogRow = mysqli_fetch_assoc($chgDocumentLogQuery)) {
						$chgDocumentLogRows[] = $chgDocumentLogRow;
					}
				}
			}
		}
	}
}

$chgIsEditMode = ($savedChg !== null);

// ---- แผนที่ค่า prefill สำหรับ view/edit/copy mode ----
// พอร์ตจาก register_supbrcshos.php:618-763 — รวมค่าที่ต้องเติมกลับเข้าฟอร์มไว้ที่เดียว
// แล้วให้ JS ตัวเดียวเป็นคนเติม (ดูบล็อกก่อนปิด </form>) แทนการไล่ so_saved_h() ทีละช่อง
// $chgSrc = ข้อมูลตั้งต้นของฟอร์ม ไม่ว่าจะ edit ($savedChg) หรือ copy ($copySrcChg) —
// แต่ $chgIsEditMode/$savedChg เองต้องไม่แตะ เพื่อให้ฟิลด์ที่ผูกกับสถานะเอกสารเดิม (แท็บ Admin,
// send_sup, slip ฯลฯ) ยังว่างเปล่าเหมือนเอกสารใหม่จริงๆ ตอน copy
$chgPrefill = array();
$chgSrc = $savedChg ?? $copySrcChg;

if ($chgSrc !== null) {
	$chgPrefill = array(
		'company' => $chgSrc['company'],
		'customer' => $chgSrc['customer'],
		'customer_id' => $chgSrc['customer_id'],
		'h_customer' => $chgSrc['customer'],
		'address' => $chgSrc['address'],
		'sale_comment' => $chgSrc['sale_comment'],
		'sn_ckk' => $chgSrc['sn_ckk'],
		'sn' => $chgSrc['sn'],
		'objective' => $chgSrc['objective'],
		'objective_des' => $chgSrc['objective_des'],
		'que_ckk' => $chgSrc['que_ckk'] ?? '',
		'send_cs' => $chgSrc['send_cs'] ?? '',
		'sale_code' => $chgSrc['sale_code'],
		// ฝั่งจัดส่ง: คอลัมน์ delivery_* ถูกเก็บด้วยชื่อฟิลด์คนละชื่อกับในฟอร์ม
		'address_name' => $chgSrc['delivery_name'],
		'address_merged_ui' => $chgSrc['delivery_name'],
		'address_1' => $chgSrc['delivery_name'],
		'address_send' => $chgSrc['delivery_address'],
		'customer_name' => $chgSrc['delivery_contact'],
		'customer_tel' => $chgSrc['delivery_tel'],
		'delivery_type' => $chgSrc['delivery_type'],
		'start_date' => $chgSrc['delivery_date'],
		'between_date' => $chgSrc['date_send_key'],
		// แท็บ Admin — job_no อยู่ในคอลัมน์เสริม เติมด้วย so_saved_h() ตรงจุด include admin_info_tab.php แทน
		// ค่าจัดส่ง (แท็บ 2 ของ delivery_info_tab.php)
		'shipping_date' => $chgSrc['date_ker'],
		'shipping_ref1' => $chgSrc['order_refer_code'],
		'shipping_ref2' => $chgSrc['order_refer_code1'],
		'shipping_cost' => $chgSrc['ker_bath'],
	);

	// delivery_time เก็บรวม "start_time end_time" คั่นด้วยช่องว่างเดียว (ดู register_supchange1.php)
	$savedChgTimeParts = explode(' ', (string)($chgSrc['delivery_time'] ?? ''), 2);
	$chgPrefill['start_time'] = $savedChgTimeParts[0] ?? '';
	$chgPrefill['end_time'] = $savedChgTimeParts[1] ?? '';
	// ช่วงเวลา: โหลดเฉพาะเอกสารที่บันทึกแล้ว ($savedChg) ใบที่คัดลอกต้องเลือกใหม่
	$chgPrefill['time_range'] = $savedChg['time_range'] ?? '';

	if ($savedOtherBill !== null) {
		$chgPrefill['no_money'] = $savedOtherBill['ref_12'] ?? '';
	}

	// tb_transaction ('แท็บ รายละเอียดที่อยู่') — ผูกกลับด้านของ cs_* mapping ใน register_supchange1.php
	if ($savedTransaction !== null) {
		if (($savedTransaction['car_home'] ?? '') === '1') {
			$chgPrefill['park_front'] = '1';
		} elseif (($savedTransaction['car_road'] ?? '') === '1') {
			$chgPrefill['park_front'] = '0';
		}
		$chgPrefill['park_location'] = $savedTransaction['car_park'];
		$chgPrefill['is_high_roof'] = $savedTransaction['height_ltd'];

		if (($savedTransaction['slope'] ?? '') === '1') {
			$chgPrefill['entrance_type'] = '1';
		} elseif (($savedTransaction['bundai'] ?? '') === '1') {
			$chgPrefill['entrance_type'] = '2';
		}
		$chgPrefill['stair_count'] = $savedTransaction['unit_bundai'];
		$chgPrefill['install_floor'] = $savedTransaction['install'];

		$chgPrefill['room_type'] = $savedTransaction['home_type'];
		$chgPrefill['door_width'] = $savedTransaction['room_bigger'];
		$chgPrefill['door_height'] = $savedTransaction['room_longer'];

		$savedChgStairSize = explode(' x ', (string)($savedTransaction['bundai_big'] ?? ''), 2);
		$chgPrefill['stair_width'] = $savedChgStairSize[0] ?? '';
		$chgPrefill['stair_height'] = $savedChgStairSize[1] ?? '';

		$savedChgElevDoorSize = explode(' x ', (string)($savedTransaction['lip_big'] ?? ''), 2);
		$chgPrefill['elev_door_width'] = $savedChgElevDoorSize[0] ?? '';
		$chgPrefill['elev_door_height'] = $savedChgElevDoorSize[1] ?? '';

		$savedChgElevSize = explode(' x ', (string)($savedTransaction['lip_long'] ?? ''), 3);
		$chgPrefill['elev_width'] = $savedChgElevSize[0] ?? '';
		$chgPrefill['elev_height'] = $savedChgElevSize[1] ?? '';
		$chgPrefill['elev_depth'] = $savedChgElevSize[2] ?? '';

		$chgPrefill['elev_capacity'] = $savedTransaction['lip_weight'];

		$chgPrefill['move_furn'] = $savedTransaction['want_employee'];
		$chgPrefill['move_furn_count'] = $savedTransaction['employee_unit'];
		$chgPrefill['move_furn_detail'] = $savedTransaction['ferniger_name'];
		$chgPrefill['addr_note'] = $savedTransaction['description'];
	}

	// tb_register_data — เฉพาะฟิลด์ที่มี input จริงในฟอร์มนี้
	if ($savedRegister !== null) {
		$chgPrefill['province_name'] = $savedRegister['province_name'];
		$chgPrefill['transport_company'] = $savedRegister['transport_company'];
		$chgPrefill['location_link'] = $savedRegister['location_link'];
		$chgPrefill['status_comment'] = $savedRegister['status_comment'];
		$chgPrefill['on_time'] = $savedRegister['on_time'];
		$chgPrefill['call_customer'] = $savedRegister['call_customer'];
	}

	// ที่อยู่เพิ่มเติมสูงสุด 9 แถว (ชุดเดียวกับที่ register_supchange1.php วนบันทึก)
	foreach ($savedShippingRows as $chgShippingIdx => $chgShippingRow) {
		$chgShippingNo = $chgShippingIdx + 1;
		if ($chgShippingNo > 9) {
			break;
		}
		$chgPrefill['extra_contact_name_' . $chgShippingNo] = $chgShippingRow['contact_name'];
		$chgPrefill['extra_contact_tel_' . $chgShippingNo] = $chgShippingRow['telephone'];
		$chgPrefill['extra_contact_province_' . $chgShippingNo] = $chgShippingRow['province'];
		$chgPrefill['extra_shipping_address_' . $chgShippingNo] = $chgShippingRow['address'];
	}

	if ($savedDeliveryBillRow !== null) {
		$chgPrefill['bill_extra_contact_name_2'] = $savedDeliveryBillRow['customer_nameb'];
		$chgPrefill['bill_extra_contact_tel_2'] = $savedDeliveryBillRow['customer_telb'];
		$chgPrefill['bill_extra_contact_province_2'] = $savedDeliveryBillRow['province'];
		$chgPrefill['bill_extra_shipping_address_2'] = $savedDeliveryBillRow['address_nameb'];
	}
}

// ---- แผนที่แสดงผลประวัติส่งกลับ/ไม่อนุมัติ/ยกเลิก — พอร์ตจาก register_supbrcshos.php:799-843 ----
// รับทั้งค่าอังกฤษ (ที่เขียนลง tb_document_status_log) และค่าไทย (ที่ hos__change.status_doc ใช้)
function renderChgDocumentReturnStatus($statusDoc)
{
	$statusMap = array(
		'Returned' => 'ส่งกลับ',
		'ส่งกลับ' => 'ส่งกลับ',
		'Rejected' => 'ไม่อนุมัติ',
		'Cancelled' => 'ยกเลิกเอกสาร',
		'ยกเลิก' => 'ยกเลิกเอกสาร'
	);
	return $statusMap[$statusDoc] ?? $statusDoc;
}

function renderChgDocumentReturnStatusClass($statusDoc)
{
	$statusClassMap = array(
		'Returned' => 'is-returned',
		'ส่งกลับ' => 'is-returned',
		'Rejected' => 'is-rejected',
		'Cancelled' => 'is-cancelled',
		'ยกเลิก' => 'is-cancelled'
	);
	return $statusClassMap[$statusDoc] ?? 'is-cancelled';
}

function formatChgDocumentLogDateTime($createdAt)
{
	$createdAt = trim((string)$createdAt);
	if ($createdAt === '') return '';
	$timestamp = strtotime($createdAt);
	if ($timestamp === false) return '';
	return date('d-m-Y H:i', $timestamp);
}

$chgLatestDocumentReasonTitleMap = array(
	'Returned' => 'เหตุผลในการส่งกลับ',
	'ส่งกลับ' => 'เหตุผลในการส่งกลับ',
	'Rejected' => 'เหตุผลที่ไม่อนุมัติ',
	'Cancelled' => 'เหตุผลในการยกเลิก',
	'ยกเลิก' => 'เหตุผลในการยกเลิก'
);
$chgLatestDocumentReason = $chgDocumentLogRows[0] ?? null;
$chgLatestDocumentReasonStatus = trim((string)($chgLatestDocumentReason['status_doc'] ?? ''));
$chgLatestDocumentReasonText = trim((string)($chgLatestDocumentReason['reason'] ?? ''));
$chgLatestDocumentReasonTitle = $chgLatestDocumentReasonTitleMap[$chgLatestDocumentReasonStatus] ?? '';
$chgLatestDocumentReasonClass = renderChgDocumentReturnStatusClass($chgLatestDocumentReasonStatus);
?>

<form action="<?php echo $chgIsEditMode ? 'register_supchange_edit1.php' : 'register_supchange1.php'; ?>" method="post" name="frmMain" enctype="multipart/form-data" novalidate onSubmit="JavaScript:return fncSubmit();">
	<div class="w3-container" style="max-width:1320px;margin:0 auto;">

		<div class="so-header-container">
			<div class="so-header-left">
				<div class="so-title-row">
					<button type="button" class="so-back-btn" onclick="goMainSupChange();" title="ย้อนกลับ" aria-label="ย้อนกลับ">
						<img src="img/icons/chevron_left.svg" alt="">
					</button>
					<h1 class="so-title">Change Order</h1>
				</div>
				<div class="so-ref-info">
					<span class="so-ref-label">เลขที่อ้างอิง</span>
					<span class="so-ref-value"><?php echo $chgIsEditMode ? so_saved_h($savedChg['ref_id']) : $so . $nextId; ?></span>
				</div>
			</div>
			<div class="so-header-right">
				<button type="button" class="btn-preview-so" onclick="chgOpenPreview();"><img src="img/icons/preview.png" alt="preview" style="width: 16px; height: 16px;"> Preview</button>
			</div>
		</div>

		<?php if ($savedChg !== null && $chgLatestDocumentReasonTitle !== '' && $chgLatestDocumentReasonText !== '') { ?>
			<div class="so-latest-reason-banner <?php echo so_saved_h($chgLatestDocumentReasonClass); ?>" role="status">
				<button type="button" class="so-latest-reason-close" aria-label="ปิด" onclick="this.closest('.so-latest-reason-banner').style.display='none';">&times;</button>
				<div class="so-latest-reason-title"><?php echo so_saved_h($chgLatestDocumentReasonTitle); ?></div>
				<div class="so-latest-reason-text"><?php echo nl2br(so_saved_h($chgLatestDocumentReasonText)); ?></div>
			</div>
		<?php } ?>

		<script language="javascript">
			var chgSubmitting = false; // กันเรียก fncSubmit ซ้ำระหว่างกำลังบันทึก (double-click / กดซ้ำตอนเน็ตช้า)

			// ฟิลด์บังคับ (name/id) ที่ปุ่มอนุมัติตรวจ — ชุดเดียวกับที่ตรวจมาแต่เดิม (ไม่รวม customer, start_date, time_range, delivery_type)
			var CHG_APPROVE_REQUIRED_FIELDS = ['sale_code', 'start_time', 'customer_name', 'customer_tel', 'province_name', 'address_merged_ui', 'address_send', 'transport_company'];

			function fncSubmit() {
				if (chgSubmitting) return false;

				// อนุมัติตรวจเฉพาะชุดฟิลด์ที่เคยตรวจมาแต่เดิม เพื่อให้เอกสารเก่าที่ยังไม่มีลูกค้า/วันจัดส่ง/ช่วงเวลาอนุมัติต่อได้
				var chgApproveActionField = document.getElementById('chg_approve_action');
				var chgIsApproving = !!(chgApproveActionField && chgApproveActionField.value);
				if (!soValidateRequired(document.forms['frmMain'], chgIsApproving ? {
						only: CHG_APPROVE_REQUIRED_FIELDS
					} : null)) {
					return false;
				}

				if (!validateDeliveryDateRange()) {
					return false;
				}

				if (!validateDeliveryTimeRange()) {
					return false;
				}

				var hasProduct = false;
				for (var pi = 1; pi <= 6; pi++) {
					var productIdInput = document.getElementsByName('product_id' + pi)[0];
					if (productIdInput && String(productIdInput.value).trim() !== '') {
						hasProduct = true;
						break;
					}
				}
				if (!hasProduct) {
					alert('กรุณาเลือกสินค้าอย่างน้อย 1 รายการ');
					return false;
				}

				// การแลกเปลี่ยนสินค้า: จำนวนแลกเข้า/แลกออกต่างกันได้ แต่มูลค่ารวมสองฝั่งต้องเท่ากัน
				if (typeof ptcGetValueTotals === 'function') {
					var chgValueTotals = ptcGetValueTotals();
					if (Math.abs(chgValueTotals.in - chgValueTotals.out) > 0.01) {
						alert('มูลค่าสินค้าแลกเข้า (' + chgValueTotals.in.toFixed(2) + ') ต้องเท่ากับมูลค่าแลกออก (' + chgValueTotals.out.toFixed(2) + ')');
						return false;
					}
				}

				// ผ่าน validation ครบแล้ว กำลังจะ submit จริง -> disable ปุ่มกันกดซ้ำ
				// ไม่ต้อง re-enable เพราะหน้าจะ navigate ออกไปอยู่แล้วเมื่อสำเร็จ
				chgSubmitting = true;
				var chgSubmitBtn = document.querySelector('.btn-so-submit');
				if (chgSubmitBtn) {
					chgSubmitBtn.disabled = true;
					chgSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...';
				}

				// ปุ่ม <button type="submit" name="submit"> ทับเมธอด form.submit() (DOM clobbering)
				// จึงต้องเรียกผ่าน prototype โดยตรง และเพราะ .submit() ไม่ส่งค่าปุ่มมาด้วย ต้องสร้าง
				// hidden name="submit" เอง ไม่งั้น register_supchange1.php จะมองว่าไม่ได้กดบันทึก
				// (pattern เดียวกับ register_supbrcshos.php:854-869)
				HTMLFormElement.prototype.submit.call(chgEnsureSubmitMarker());
				return false;
			}

			function chgEnsureSubmitMarker() {
				var chgForm = document.forms['frmMain'];
				var chgSubmitValue = chgForm.querySelector('input[type="hidden"][name="submit"]');
				if (!chgSubmitValue) {
					chgSubmitValue = document.createElement('input');
					chgSubmitValue.type = 'hidden';
					chgSubmitValue.name = 'submit';
					chgForm.appendChild(chgSubmitValue);
				}
				chgSubmitValue.value = 'submit';
				return chgForm;
			}

			// เปิดพรีวิวใบแลกเปลี่ยนสินค้าในแท็บใหม่ โดยยิงค่าปัจจุบันในฟอร์มไปให้ report_changehosptl.php
			// (report มี preview path อ่านจาก POST อยู่ใน report_changehosptl_preview_helper.php)
			// พอร์ตจาก register_supbrcshos.php:112-171
			function chgOpenPreview() {
				var form = document.forms.frmMain;
				var refInput = form ? form.querySelector('input[name="ref_id"]') : null;
				var refId = refInput ? refInput.value.trim() : '';

				if (!form || !refId) {
					Swal.fire('แจ้งเตือน', 'ไม่พบเลขที่อ้างอิง (ref_id)', 'warning');
					return;
				}

				var previewTarget = 'changhos_preview_' + Date.now();
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
				var originalEnctype = form.getAttribute('enctype');

				form.action = 'report_changehosptl.php';
				form.method = 'post';
				form.target = previewTarget;
				// พรีวิวไม่ใช้ไฟล์แนบ จึงไม่ต้องอัปโหลดสลิปซ้ำไปที่หน้ารายงาน
				form.enctype = 'application/x-www-form-urlencoded';
				HTMLFormElement.prototype.submit.call(form);

				if (originalAction === null) form.removeAttribute('action');
				else form.setAttribute('action', originalAction);
				if (originalMethod === null) form.removeAttribute('method');
				else form.setAttribute('method', originalMethod);
				if (originalTarget === null) form.removeAttribute('target');
				else form.setAttribute('target', originalTarget);
				if (originalEnctype === null) form.removeAttribute('enctype');
				else form.setAttribute('enctype', originalEnctype);
				previewFlag.remove();

				// เอกสารใหม่ยังไม่ได้เลขจริง (create handler ออกเลขตอนบันทึก) จึงเตือนว่าเลขในพรีวิวเป็นค่าประมาณการ
				// โหมดแก้ไขจะ action ไป register_supchange_edit1.php ซึ่งแปลว่าเลขที่อ้างอิงเป็นเลขจริงแล้ว
				var chgIsSavedDoc = (originalAction || '').indexOf('register_supchange_edit1.php') !== -1;
				if (!chgIsSavedDoc && typeof Swal !== 'undefined' && typeof Swal.fire === 'function') {
					Swal.fire({
						toast: true,
						position: 'top-end',
						icon: 'info',
						title: 'เลขที่อ้างอิงในพรีวิวเป็นค่าประมาณการ อาจไม่ตรงกับเลขที่บันทึกจริง',
						showConfirmButton: false,
						timer: 3500,
						timerProgressBar: true
					});
				}
			}
		</script>

		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $chgIsEditMode ? so_saved_h($savedChg['ref_id']) : so_saved_h($so . $nextId); ?>">
		<input name="add_by" value="<?php echo so_saved_h(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')); ?>" type='hidden'>

		<div class="chg-layout">

			<div class="chg-content-col">

				<!-- ===================== Tab: ข้อมูลเอกสาร / Admin ===================== -->
				<div id="step-doc">
					<div class="so-tabs-container">
						<button type="button" class="so-tab-btn active" onclick="switchBrMainTab(this, 'tab-document-info')">ข้อมูลเอกสาร</button>
						<button type="button" class="so-tab-btn" onclick="switchBrMainTab(this, 'tab-admin-info')">Admin</button>
					</div>

					<div id="tab-document-info" class="so-tab-content active">
						<div class="so-card">
							<div class="so-doc-info-line">
								<div class="so-field-group" style="margin-bottom:0; flex:1; max-width:328px;">
									<label class="so-label">บริษัท</label>
									<div class="so-select-wrapper">
										<select class="so-select" name="company" id="company_select">
											<option value="1" selected>AWL</option>
											<option value="2">NBM</option>
										</select>
									</div>
								</div>

								<div class="so-field-group" style="margin-bottom:0; flex:1; max-width:328px;">
									<label class="so-label" for="sale_code">แผนก/เขตการขาย <span style="color:red;">*</span></label>
									<div class="so-select-wrapper">
										<?php
										// mirror ของ register_supbrcshos.php:984-999 — ทีมขายตาม $_SESSION['code']
										if ($_SESSION['code'] == 'SS1') {
											$chgSaleTeamSql = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
										} else if ($_SESSION['code'] == 'SS2') {
											$chgSaleTeamSql = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
										} else if ($_SESSION['code'] == 'SS3') {
											$chgSaleTeamSql = "SELECT * FROM tb_team_ss3 ORDER BY sale_code ASC";
										} else if ($_SESSION['code'] == 'SS5') {
											$chgSaleTeamSql = "SELECT * FROM tb_team_ss3 WHERE sale_code IN ('S31','S32') ORDER BY sale_code ASC";
										} else if ($_SESSION['code'] == 'MK2') {
											$chgSaleTeamSql = "SELECT * FROM tb_team_sm1 ORDER BY sale_code ASC";
										} else if ($_SESSION['code'] == 'SUP_EN') {
											$chgSaleTeamSql = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
										} else {
											$chgSaleTeamSql = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
										}
										?>
										<select name="sale_code" id="sale_code" class="so-select">
											<option value="">**Please Select**</option>
											<?php
											$chgSaleTeamQuery = mysqli_query($com, $chgSaleTeamSql);
											if ($chgSaleTeamQuery) {
												while ($chgSaleTeamRow = mysqli_fetch_array($chgSaleTeamQuery)) {
											?>
												<option value="<?php echo so_saved_h($chgSaleTeamRow["sale_code"]); ?>"><?php echo so_saved_h($chgSaleTeamRow["sale_code"]); ?> - <?php echo so_saved_h($chgSaleTeamRow["sale_name"]); ?></option>
											<?php
												}
											}
											?>
										</select>
									</div>
								</div>

								<!-- "งานด่วน" — hos__change.que_ckk เป็นคอลัมน์ใหม่ (sql/supchange_optional_columns.sql)
								     register_supchange1.php เขียนผ่าน cs_update_column_if_exists จึงไม่พังถ้ายังไม่ได้รัน ALTER -->
								<label class="so-toggle-pill so-doc-info-line-toggle">
									<input type="checkbox" name="que_ckk" id="que_ckk" value="1">
									<span>งานด่วน</span>
								</label>
							</div>
						</div>
					</div>

					<?php
					$chgIsCancelChecked = $savedChg !== null && ($savedChg['status_doc'] ?? '') === 'ยกเลิก';
					$adminInfoTab = [
						'tab_id' => 'tab-admin-info',
						'title' => 'ข้อมูลเพิ่มเติม (Admin)',
						'rows' => [
							[
								['type' => 'text', 'name' => 'admin_doc_no', 'label' => 'เลขที่เอกสาร', 'value' => ($savedChg !== null) ? so_saved_h($savedChg['iv_no'] ?? '') : '', 'placeholder' => 'No.'],
								['type' => 'button', 'icon' => 'img/icons/doc.png', 'label' => 'Run เอกสาร', 'id' => 'btn_run_doc_no', 'onclick' => 'chgRunDocumentNo();', 'variant' => 'purple'],
								['type' => 'date_th', 'name' => 'admin_doc_date', 'label' => 'วันที่ออกเอกสาร', 'value' => ($savedChg !== null) ? so_saved_iso_date_input($savedChg['iv_date'] ?? '') : '', 'icon' => 'far fa-calendar-alt'],
								['type' => 'text', 'name' => 'admin_work_no', 'label' => 'เลขที่ลงงาน', 'value' => ($savedChg !== null) ? so_saved_h($savedChg['job_no'] ?? '') : '', 'icon' => 'img/icons/preview.png', 'icon_onclick' => 'chgRunJobNo();', 'icon_id' => 'btn_run_job_no'],
							],
						],
					];
					include __DIR__ . '/partials/admin_info_tab.php';
					unset($adminInfoTab);
					?>
					<!-- ยกเลิกเอกสารทำได้จากเมนู ⋮ ในแถบอนุมัติเท่านั้น — popup เซ็ต cancel_doc=1 และเติมเหตุผลลง admin_cancel_reason (-> remark_cancel) -->
					<input type="hidden" name="cancel_doc" id="cancel_doc" value="<?php echo $chgIsCancelChecked ? '1' : '0'; ?>">
					<input type="hidden" name="admin_cancel_reason" id="admin_cancel_reason" value="<?php echo ($savedChg !== null) ? so_saved_h($savedChg['remark_cancel'] ?? '') : ''; ?>">
					<script>
						// ปุ่ม "Run เอกสาร" ในแท็บ Admin — พอร์ตจาก register_supbrcshos.php:980-1043
						// ajax_run_doc_no.php ใช้ doc_type='6' (EXC) และนับเลขจาก hos__change.iv_no
						// โดยตรง ไม่มีตารางตัวนับ/ไม่มีการจองเลข ปุ่มนี้จึงคืนแค่เลขถัดไปที่แนะนำ
						// company_select ของหน้านี้ใช้ 1=AWL/2=NBM ต้อง map เป็น 3=AWL/4=NBM ก่อนส่ง
						// (AWL ได้ prefix EXC, NBM ได้ EXCN — คนละ series กัน)
						function chgRunDocumentNo() {
							var companySelect = document.getElementById('company_select');
							var docNoInput = document.querySelector('input[name="admin_doc_no"]');
							var docDateInput = document.querySelector('input[name="admin_doc_date"]');
							var refIdInput = document.querySelector('input[name="ref_id"]');
							var runButton = document.getElementById('btn_run_doc_no');

							if (!companySelect || !docNoInput) {
								return;
							}

							if (docNoInput.value.trim() !== '') {
								// เลขถูกจองจริงตอนกดบันทึกเอกสาร (เขียนลง hos__change.iv_no) การกดปุ่มนี้ซ้ำ
								// ก่อนบันทึกจะได้เลขเดิมเสมอ แต่ถ้าเอกสารนี้บันทึกเลขไว้แล้วจะได้เลขถัดไป
								// และเลขเดิมจะถูกทับหาย จึงต้องถามยืนยันก่อน
								if (!confirm('เอกสารนี้มีเลขที่ ' + docNoInput.value.trim() + ' อยู่แล้ว ต้องการออกเลขใหม่ทับหรือไม่?')) {
									return;
								}
							}

							var companyMapToAjax = {
								'1': '3',
								'2': '4'
							};
							var payload = new URLSearchParams();
							payload.append('company', companyMapToAjax[companySelect.value] || companySelect.value);
							payload.append('doc_type', '6');
							payload.append('doc_date', docDateInput ? docDateInput.value : '');
							payload.append('ref_id', refIdInput ? refIdInput.value : '');

							if (runButton) {
								runButton.disabled = true;
							}

							fetch('ajax_run_doc_no.php', {
									method: 'POST',
									credentials: 'same-origin',
									cache: 'no-store',
									headers: {
										'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
									},
									body: payload.toString()
								})
								.then(function(response) {
									return response.json().then(function(data) {
										return {
											ok: response.ok,
											data: data
										};
									});
								})
								.then(function(result) {
									if (!result.ok || !result.data || !result.data.success) {
										alert((result.data && result.data.message) ? result.data.message : 'ไม่สามารถออกเลขที่เอกสารได้');
										return;
									}
									docNoInput.value = result.data.doc_no;
								})
								.catch(function() {
									alert('ไม่สามารถติดต่อเซิร์ฟเวอร์เพื่อออกเลขที่เอกสารได้ กรุณาลองใหม่อีกครั้ง');
								})
								.then(function() {
									if (runButton) {
										runButton.disabled = false;
									}
								});
						}

						// ไอคอนในช่อง 'เลขที่ลงงาน' (แท็บ Admin) — ขอเลขที่ลงงานจาก ajax_run_job_no.php
						// พอร์ตจาก register_suphos.php:5413-5480 เพิ่มเติมคือกด Run แล้วติ๊ก send_cs ให้อัตโนมัติ
						// เพราะการออกเลขที่ลงงานถือว่าเอกสารพร้อมส่งข้อมูลลงระบบ CS แล้ว
						function chgRunJobNo() {
							var jobNoInput = document.querySelector('input[name="admin_work_no"]');
							var refIdInput = document.querySelector('input[name="ref_id"]');
							// วันในการจัดส่งเป็นตัวกำหนดปี/เดือนของเลข ถ้ายังไม่กรอก server จะใช้วันที่ปัจจุบันแทน
							var jobDateInput = document.querySelector('input[name="start_date"]');
							var runIcon = document.getElementById('btn_run_job_no');

							if (!jobNoInput) {
								return;
							}

							// icon ไม่มี disabled attribute แบบปุ่ม ใช้ dataset flag กันคลิกซ้ำระหว่างรอ response แทน
							if (runIcon && runIcon.dataset.loading === '1') {
								return;
							}

							if (jobNoInput.value.trim() !== '') {
								// เลขที่ออกไปแล้วถูกจองในฐานข้อมูลแล้ว การกดซ้ำจะกินเลขเพิ่มโดยเปล่าประโยชน์
								if (!confirm('เอกสารนี้มีเลขที่ลงงาน ' + jobNoInput.value.trim() + ' อยู่แล้ว ต้องการออกเลขใหม่ทับหรือไม่?')) {
									return;
								}
							}

							var payload = new URLSearchParams();
							payload.append('ref_id', refIdInput ? refIdInput.value : '');
							payload.append('job_date', jobDateInput ? jobDateInput.value : '');

							if (runIcon) {
								runIcon.dataset.loading = '1';
								runIcon.style.pointerEvents = 'none';
								runIcon.style.opacity = '0.4';
							}

							fetch('ajax_run_job_no.php', {
									method: 'POST',
									credentials: 'same-origin',
									cache: 'no-store',
									headers: {
										'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
									},
									body: payload.toString()
								})
								.then(function(response) {
									return response.json().then(function(data) {
										return {
											ok: response.ok,
											data: data
										};
									});
								})
								.then(function(result) {
									if (!result.ok || !result.data || !result.data.success) {
										alert((result.data && result.data.message) ? result.data.message : 'ไม่สามารถออกเลขที่ลงงานได้');
										return;
									}
									jobNoInput.value = result.data.job_no;

									// การออกเลขที่ลงงานถือว่าเอกสารพร้อมส่งข้อมูลลงระบบ CS แล้ว ติ๊ก send_cs ให้อัตโนมัติ
									var sendCsInput = document.getElementById('send_cs') || document.querySelector('input[name="send_cs"]');
									if (sendCsInput && !sendCsInput.checked) {
										sendCsInput.checked = true;
										sendCsInput.dispatchEvent(new Event('change', {
											bubbles: true
										}));
									}
								})
								.catch(function() {
									alert('ไม่สามารถติดต่อเซิร์ฟเวอร์เพื่อออกเลขที่ลงงานได้ กรุณาลองใหม่อีกครั้ง');
								})
								.then(function() {
									if (runIcon) {
										runIcon.dataset.loading = '0';
										runIcon.style.pointerEvents = '';
										runIcon.style.opacity = '';
									}
								});
						}
					</script>
				</div>

				<!-- ===================== Card: ข้อมูลลูกค้า ===================== -->
				<div id="step-customer" class="so-card">
					<div class="so-section-title-container">
						<h2 class="so-section-title">ข้อมูลลูกค้า</h2>
						<hr class="so-divider">
					</div>

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
									<input type="text" name="customer" id="customer" class="so-input" readonly placeholder="จะแสดงผลอัตโนมัติเมื่อเลือกเสร็จสิ้น">
									<button type="button" class="fas fa-times so-clear-icon" onclick="clearCustomerSelection();" aria-label="ล้างข้อมูลลูกค้าที่เลือก"></button>
								</div>
								<input type="hidden" name="customer_id" id="customer_id">
								<input type='hidden' name="h_customer" id="h_customer">
								<input type="hidden" name="customer_typename" id="customer_typename">
								<!-- mirror ของ customer_id เฉพาะให้ js/credit-term-modal.js อ่าน (ตัวสคริปต์ตายตัว
								     ที่ id="bill_id"/"h_bill_id") ไม่มี name= จึงไม่ถูก register_supchange1.php อ่าน -->
								<input type="hidden" id="bill_id">
								<input type="hidden" id="h_bill_id">
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
													<img src="img/icons/edit.png" class="credit-term-trigger-icon" alt="แก้ไข">
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="so-customer-address-wrap">
							<div class="so-field-group" style="margin-bottom: 0;">
								<label class="so-label" for="address">ที่อยู่</label>
								<div class="so-input-wrapper">
									<input type="text" name="address" id="address" class="so-input" readonly placeholder="จะแสดงผลอัตโนมัติเมื่อเลือกเสร็จสิ้น">
									<button type="button" class="fas fa-times so-clear-icon" onclick="clearCustomerSelection();" aria-label="ล้างข้อมูลลูกค้าที่เลือก"></button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- ===================== Card: หมายเหตุ ===================== -->
				<div id="step-remark" class="so-card">
					<div class="so-section-title-container">
						<h2 class="so-section-title">หมายเหตุ</h2>
						<hr class="so-divider">
						<button type="button" class="fas fa-times so-clear-icon" style="position:absolute; right:0; top:0;" onclick="document.getElementById('sale_comment').value='';" aria-label="ล้างหมายเหตุ"></button>
					</div>
					<div class="so-field-group" style="margin-bottom:0;">
						<label class="so-label" for="sale_comment">หมายเหตุ</label>
						<input type="text" name="sale_comment" id="sale_comment" class="so-input" placeholder="ระบุหมายเหตุ">
					</div>
				</div>

				<!-- ===================== Card: รายการสินค้า ===================== -->
				<div id="step-products" class="so-card">
					<div class="so-section-title-container">
						<h2 class="so-section-title">รายการสินค้า</h2>
						<span class="so-product-item-count" id="ptc_summary_item_count">0 รายการ</span>
						<hr class="so-divider">
					</div>

					<?php $ptcIsEngDept = $chgIsEngDept;
					include __DIR__ . '/partials/product_table_change.php'; ?>

					<?php if (count($savedProducts) > 0) { ?>
						<script>
							document.addEventListener('DOMContentLoaded', function() {
								var chgSavedProducts = <?php echo json_encode($savedProducts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

								chgSavedProducts.forEach(function(product, index) {
									var rowIndex = index + 1;
									if (rowIndex > 6) return;

									ptcSetRowData(rowIndex, {
										product_codet: product.tb_access_code || '',
										product_id: product.product_id || '',
										product_name: product.tb_sol_name || '',
										product_name_view: product.tb_sol_name || '',
										unit_name: product.tb_unit_name || '',
										count_stock: product.count_stock || '',
										count_sale: product.count_sale || '',
										product_price: product.price || '',
										sum_amount: product.amount || '',
										sn: product.sn || '',
										sale_remarkk: product.sale_remark || ''
									});
								});

								if (typeof ptcSyncRowVisibility === 'function') ptcSyncRowVisibility();
								if (typeof ptcRecalcSummary === 'function') ptcRecalcSummary();
							});
						</script>
					<?php } ?>
				</div>

				<!-- ===================== ข้อมูลการจัดส่ง ===================== -->
				<div id="step-delivery">
					<?php
					$deliveryTab = [
						'open_fn' => 'brOpenDelTab',
						'grid_fields' => [
							['type' => 'select', 'span' => 2, 'name' => 'delivery_type', 'label' => 'วิธีการจัดส่ง', 'required' => true, 'options' => [
								'3' => 'พนักงานรับ/ลูกค้ารับ',
								'5' => 'บริษัทจัดส่ง(AllWell)',
								'4' => 'บริษัทขนส่งภายนอก',
							]],
							['type' => 'select', 'span' => 2, 'name' => 'transport_company', 'label' => 'บริษัทขนส่ง', 'required' => true, 'options' => [
								// ตัวเลือกจริงสร้างด้วย JS ตามวิธีการจัดส่ง (ดู updateTransportCompanyRequirement ใน js/delivery-transport.js)
								'' => 'เลือกบริษัทขนส่ง',
							]],
							// ช่วงเวลาเป็นฟิลด์อิสระ ไม่ผูกกับเวลาจัดส่ง (เก็บลง hos__change.time_range ดู sql/delivery_time_range.sql)
							['type' => 'select', 'span' => 2, 'name' => 'time_range', 'label' => 'เลือกช่วงเวลา', 'required' => true, 'options' => [
								'' => 'เลือกช่วงเวลา',
								'morning' => 'ช่วงเช้า',
								'afternoon' => 'ช่วงบ่าย',
								'allday' => 'ทั้งวัน',
								'specific' => 'กำหนดเวลา',
							]],
							// col 1: ขึ้นแถวใหม่เสมอ แม้บริษัทขนส่งถูกซ่อนแล้วช่วงเวลาเลื่อนมาชิดซ้าย
							['type' => 'date', 'span' => 1, 'col' => 1, 'name' => 'start_date', 'label' => 'จัดส่งวันที่', 'required' => true],
							// ถึงวันที่ใช้ชื่อฟิลด์ between_date เดิม (เก็บลง date_send_key เป็น YYYY-MM-DD) ดู js/delivery-transport.js
							['type' => 'date', 'span' => 1, 'name' => 'between_date', 'label' => 'ถึงวันที่'],
							['type' => 'time', 'span' => 1, 'name' => 'start_time', 'label' => 'จัดส่งตั้งแต่เวลา', 'required' => true],
							// ถึงเวลาใช้กฎเดียวกับถึงวันที่ ดู js/delivery-transport.js
							['type' => 'time', 'span' => 1, 'name' => 'end_time', 'label' => 'ถึงเวลา'],
							['type' => 'text', 'span' => 4, 'name' => 'status_comment', 'label' => 'หมายเหตุสถานะ', 'clearable' => true],
							['type' => 'toggle', 'span' => 2, 'name' => 'call_customer', 'id' => 'call_customer', 'label' => 'ต้องการให้โทรแจ้ง'],
						],
						'toggle_buttons' => [
							['name' => 'no_money', 'id' => 'no_money', 'label' => 'ส่งสินค้าด้วยใบส่งสินค้า (ไม่ระบุราคา)'],
							['name' => 'send_cs', 'id' => 'send_cs', 'label' => 'ส่งข้อมูลลงระบบ CS'],
						],
						'cost_fields' => [
							['type' => 'date', 'name' => 'shipping_date', 'label' => 'วันที่คีย์ค่าส่ง'],
							['type' => 'text', 'name' => 'shipping_ref1', 'label' => 'รหัสอ้างอิง 1'],
							['type' => 'text', 'name' => 'shipping_ref2', 'label' => 'รหัสอ้างอิง 2'],
							['type' => 'text', 'name' => 'shipping_cost', 'label' => 'ค่าจัดส่ง'],
						],
					];
					include __DIR__ . '/partials/delivery_info_tab.php';
					?>
					<script src="js/delivery-transport.js?v=<?php echo filemtime(__DIR__ . '/js/delivery-transport.js'); ?>"></script>
				</div>

				<!-- ===================== ที่อยู่ ===================== -->
				<div id="step-address">
					<div class="so-tabs-container" style="margin-top: 24px;">
						<button type="button" class="so-tab-btn active" onclick="brOpenAddrTab('chg_addr_main', this)">ที่อยู่</button>
						<button type="button" class="so-tab-btn" onclick="brOpenAddrTab('chg_addr_detail', this)">รายละเอียดที่อยู่</button>
						<button type="button" class="so-tab-btn" onclick="brOpenAddrTab('chg_addr_extra', this)">ที่อยู่เพิ่มเติม</button>
					</div>
					<div class="so-card" style="padding: clamp(16px, 3vw, 24px);">

						<div id="chg_addr_main" class="so-addr-tab-content">
							<div class="so-section-title-container">
								<h3 class="so-section-title">ที่อยู่จัดส่ง</h3>
								<hr class="so-divider">
							</div>

							<div class="so-address-actions" style="display: flex; gap: 16px; margin-bottom: 24px;">
								<button type="button" class="so-address-action-btn so-address-action-btn-primary" style="background-color: #F4E8FF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;" onclick="alert('ยังไม่รองรับในตอนนี้');">
									<i class="fas fa-search"></i> ค้นหาที่อยู่
								</button>
								<button type="button" class="so-address-action-btn so-address-action-btn-secondary" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;" onclick="doCallAjax1('customer_id','customer','address','customer_typename');">
									<img src="img/icons/database.png" alt="database" style="width: 16px; height: 16px;"> เพิ่มจากฐานลูกค้า
								</button>
							</div>

							<div class="so-grid-3">
								<div class="so-field-group">
									<label class="so-label" for="customer_name">ชื่อผู้ติดต่อ <span style="color:red;">*</span></label>
									<div class="so-input-wrapper">
										<input name="customer_name" class="so-input" type='text' id="customer_name" placeholder="ชื่อผู้ติดต่อ">
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
								<label class="so-label" for="address_merged_ui">ที่อยู่ในการส่งสินค้า <span style="color:red;">*</span></label>
								<div class="so-input-wrapper">
									<input type="text" class="so-input" name="address_merged_ui" id="address_merged_ui" placeholder="ที่อยู่ส่งสินค้า" oninput="document.getElementById('address_1').value=this.value; document.getElementById('address_name').value=this.value;">
									<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('address_merged_ui').value=''; document.getElementById('address_1').value=''; document.getElementById('address_name').value='';" aria-label="ล้างค่า"></button>
								</div>
								<input type="hidden" name="address_1" id="address_1">
								<input type="hidden" name="address_name" id="address_name">
							</div>

							<div class="so-grid-2" style="margin-top: 16px;">
								<div class="so-field-group">
									<label class="so-label" for="address_send">สถานที่ติดตั้งเครื่อง <span style="color:red;">*</span></label>
									<div class="so-input-wrapper">
										<input type="text" class="so-input" name="address_send" id="address_send" placeholder="สถานที่ติดตั้งเครื่อง">
										<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('address_send').value='';" aria-label="ล้างค่า"></button>
									</div>
								</div>
								<div class="so-field-group">
									<label class="so-label" for="location_link">Location Link</label>
									<div class="so-input-wrapper">
										<input type="text" class="so-input" name="location_link" id="location_link" placeholder="วางลิงก์ Google Maps หรือพิกัด">
										<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('location_link').value='';" aria-label="ล้างค่า"></button>
									</div>
								</div>
							</div>
						</div>

						<div id="chg_addr_detail" class="so-addr-tab-content" style="display:none;">
							<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">รายละเอียดที่อยู่</h3>
							<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

							<?php
							$chgDepartmentShow = $chgIsEngDept ? 'ฝ่ายวิศวกรรม' : 'ฝ่ายขาย';
							$chgDepartmentName = $chgIsEngDept ? 'วิศวกรรม' : 'Sale';
							?>

							<input type="hidden" name="status" value="ส่ง">
							<input type="hidden" name="department_show" value="<?php echo so_saved_h($chgDepartmentShow); ?>">
							<input type="hidden" name="department_name" value="<?php echo so_saved_h($chgDepartmentName); ?>">
							<input type="hidden" name="employee_name" value="<?php echo so_saved_h($_SESSION['name'] ?? ''); ?>">
							<input type="hidden" name="employee_tel" value="">
							<input type="hidden" name="product_sn" value="">
							<input type="hidden" name="product" value="">
							<input type="hidden" name="description" value="">

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
									<label class="so-label" style="color: #612989;">ขนาดประตูห้อง (ซม.)</label>
									<div style="display: flex; gap: 16px;">
										<input name="door_width" type="text" class="so-input" placeholder="กว้าง" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
										<input name="door_height" type="text" class="so-input" placeholder="สูง" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
									</div>
								</div>
								<div class="so-field-group" style="min-width: 0;">
									<label class="so-label" style="color: #612989;">ขนาดบันได (ซม.)</label>
									<div style="display: flex; gap: 16px;">
										<input name="stair_width" type="text" class="so-input" placeholder="กว้าง" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
										<input name="stair_height" type="text" class="so-input" placeholder="สูง" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
									</div>
								</div>
							</div>

							<div class="so-grid-3" style="margin-top: 16px;">
								<div class="so-field-group" style="min-width: 0;">
									<label class="so-label" style="color: #612989;">ประตูลิฟต์ (ซม.)</label>
									<div style="display: flex; gap: 16px;">
										<input name="elev_door_width" type="text" class="so-input" placeholder="กว้าง" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
										<input name="elev_door_height" type="text" class="so-input" placeholder="สูง" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
									</div>
								</div>
								<div class="so-field-group" style="grid-column: span 1; min-width: 0;">
									<label class="so-label" style="color: #612989;">ขนาดห้องลิฟต์ (ซม.)</label>
									<div style="display: flex; gap: 16px;">
										<input name="elev_width" type="text" class="so-input" placeholder="กว้าง" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
										<input name="elev_height" type="text" class="so-input" placeholder="สูง" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
										<input name="elev_depth" type="text" class="so-input" placeholder="ลึก" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
									</div>
								</div>
								<div class="so-field-group" style="min-width: 0;">
									<label class="so-label" style="color: #612989;">ขนาดบรรทุกของลิฟต์ (กก.)</label>
									<input name="elev_capacity" type="text" class="so-input" placeholder="น้ำหนัก" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
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
								<input name="addr_note" type="text" class="so-input" placeholder="ใส่หมายเหตุ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
							</div>
						</div>

						<?php
						$chgPrintCoverRefId = '';
						$chgCoverSheetMainReports = [];
						$chgCoverSheetExtraReports = [];
						$chgBillDeliveryReports = [];
						?>
						<div id="chg_addr_extra" class="so-addr-tab-content" style="display:none;">

							<input type="hidden" name="returns" value="">
							<input type="hidden" name="returns_date" value="">
							<input type="hidden" name="returns_time" value="">
							<input type="hidden" name="returns_name" value="">
							<input type="hidden" name="returns_address" value="">
							<input type="hidden" name="returns_contact" value="">
							<input type="hidden" name="return_date_bet" value="">

							<div id="extra_address_list">
								<div class="extra-addr-row" data-index="1">
									<h3 class="so-section-title extra-addr-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">ที่อยู่เพิ่มเติม 1</h3>
									<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

									<div class="so-grid-3">
										<div class="so-field-group">
											<label class="so-label extra-contact-name-label" style="color: #612989;">ชื่อผู้ติดต่อ (เพิ่มเติม1)</label>
											<div style="position: relative; display: flex; align-items: center;">
												<input name="extra_contact_name_1" type="text" class="so-input" placeholder="ชื่อผู้ติดต่อ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
												<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
											</div>
										</div>
										<div class="so-field-group">
											<label class="so-label extra-contact-tel-label" style="color: #612989;">เบอร์โทร (เพิ่มเติม1)</label>
											<div style="position: relative; display: flex; align-items: center;">
												<input name="extra_contact_tel_1" type="text" class="so-input" placeholder="เบอร์โทร" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
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
													?>
															<option value="<?php echo so_saved_h($objResuut_prov_extra['province_name']); ?>"><?php echo so_saved_h($objResuut_prov_extra['province_name']); ?></option>
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
												<input name="extra_shipping_address_1" type="text" class="so-input" placeholder="ที่อยู่ส่งสินค้า" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
												<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
											</div>
										</div>
										<button type="button" onclick="chgRemoveExtraAddress(this)" style="background-color: #FFFFFF; color: #DC3545; border: 1px solid #EBEBEB; border-radius: 24px; padding: 0 24px; height: 42px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
											<i class="far fa-trash-alt"></i> ลบที่อยู่
										</button>
									</div>
								</div>
							</div>

							<div class="so-address-actions" style="margin-top: 24px; display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
								<button type="button" class="so-address-action-btn" onclick="chgAddExtraAddress()" style="background-color: #F4E8FF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
									<img src="img/icons/add_address.png" alt="add_address" style="width: 16px; height: 16px;"> เพิ่มที่อยู่
								</button>
								<button type="button" class="so-address-action-btn" onclick="chgToggleDeliveryPrintPanel()" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
									<img src="img/icons/print.png" alt="print" style="width: 16px; height: 16px; object-fit: contain;"> พิมพ์ใบปะ
								</button>
							</div>

							<div id="chg_delivery_print_panel" style="display:none; margin-top: 20px; border: 1px solid #EBEBEB; border-radius: 12px; padding: 18px; background-color: #FCFBFD;">
								<div style="display: flex; justify-content: space-between; gap: 12px; align-items: center; flex-wrap: wrap;">
									<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin: 0;">ชุดพิมพ์ใบปะหน้า</h3>
									<span style="font-size: 13px; color: #7A6F85;">
										<?php echo $chgPrintCoverRefId !== '' ? 'เลขที่อ้างอิง: ' . so_saved_h($chgPrintCoverRefId) : 'ยังไม่มี ref_id สำหรับพิมพ์'; ?>
									</span>
								</div>
								<p style="margin: 10px 0 0; font-size: 13px; line-height: 1.6; color: #6C6772;">
									การพิมพ์ใบปะหน้าใช้ข้อมูลจากฐานข้อมูลที่บันทึกแล้ว หากเพิ่งแก้ไขที่อยู่เพิ่มเติมหรือที่อยู่ส่งบิล กรุณากดบันทึกก่อนพิมพ์
								</p>

								<div style="margin-top: 18px;">
									<h4 style="margin: 0 0 12px; font-size: 15px; color: #3B3B3B;">ใบปะหน้ากล่องหลัก</h4>
									<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px;">
										<?php if (!empty($chgCoverSheetMainReports) && is_array($chgCoverSheetMainReports)) { ?>
											<?php foreach ($chgCoverSheetMainReports as $reportConfig) { ?>
												<button type="button" onclick="chgOpenDeliveryPrintReport('<?php echo htmlspecialchars($reportConfig['file'], ENT_QUOTES, 'UTF-8'); ?>')" style="background-color: #FFFFFF; color: #612989; border: 1px solid #E5D8EF; border-radius: 10px; padding: 11px 14px; font-family: 'Prompt', sans-serif; font-size: 14px; font-weight: 500; cursor: pointer; text-align: center;">
													<?php echo htmlspecialchars($reportConfig['label'], ENT_QUOTES, 'UTF-8'); ?>
												</button>
											<?php } ?>
										<?php } ?>
									</div>
								</div>

								<div style="margin-top: 18px;">
									<h4 style="margin: 0 0 12px; font-size: 15px; color: #3B3B3B;">ใบปะหน้าที่อยู่เพิ่มเติม</h4>
									<div id="chg_delivery_print_extra_groups" style="display: flex; flex-direction: column; gap: 14px;"></div>
								</div>
							</div>

							<script>
								const chgDeliveryPrintRefId = <?php echo json_encode($chgPrintCoverRefId, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
								const chgDeliveryPrintCanOpen = <?php echo $chgPrintCoverRefId !== '' ? 'true' : 'false'; ?>;
								const chgDeliveryPrintExtraReports = <?php echo json_encode($chgCoverSheetExtraReports, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

								function chgGetExtraAddressRowCount() {
									return Math.min(document.querySelectorAll('#extra_address_list .extra-addr-row').length, 9);
								}

								function chgToggleDeliveryPrintPanel() {
									const panel = document.getElementById('chg_delivery_print_panel');
									if (!panel) return;
									const shouldShow = panel.style.display === 'none' || panel.style.display === '';
									panel.style.display = shouldShow ? 'block' : 'none';
									if (shouldShow) chgRenderDeliveryPrintExtraGroups();
								}

								function chgOpenDeliveryPrintReport(fileName) {
									if (!chgDeliveryPrintCanOpen || !chgDeliveryPrintRefId) {
										alert('กรุณาบันทึกเอกสารก่อนพิมพ์ใบปะหน้า เพื่อให้ระบบมี ref_id และข้อมูลล่าสุดสำหรับรายงาน');
										return;
									}
									window.open(fileName + '?ref_id=' + encodeURIComponent(chgDeliveryPrintRefId), '_blank');
								}

								function chgRenderDeliveryPrintExtraGroups() {
									const container = document.getElementById('chg_delivery_print_extra_groups');
									if (!container) return;

									const rowCount = chgGetExtraAddressRowCount();
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

										chgDeliveryPrintExtraReports.forEach(function(reportConfig) {
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
												chgOpenDeliveryPrintReport(reportConfig.file_pattern.replace('%s', index));
											};
											buttonWrap.appendChild(button);
										});

										group.appendChild(buttonWrap);
										container.appendChild(group);
									}
								}

								function chgToggleBillDeliveryPrintPanel() {
									const panel = document.getElementById('chg_bill_delivery_print_panel');
									if (!panel) return;
									panel.style.display = (panel.style.display === 'none' || panel.style.display === '') ? 'block' : 'none';
								}

								function chgOpenBillDeliveryPrintReport(fileName) {
									if (!chgDeliveryPrintCanOpen || !chgDeliveryPrintRefId) {
										alert('กรุณาบันทึกเอกสารก่อนพิมพ์ใบปะจัดส่งบิล เพื่อให้ระบบมี ref_id และข้อมูลล่าสุดสำหรับรายงาน');
										return;
									}
									window.open(fileName + '?ref_id=' + encodeURIComponent(chgDeliveryPrintRefId), '_blank');
								}

								function chgAddExtraAddress() {
									const list = document.getElementById('extra_address_list');
									const template = list.querySelector('.extra-addr-row').cloneNode(true);
									template.querySelectorAll('input').forEach(input => input.value = '');
									template.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
									list.appendChild(template);
									chgUpdateExtraAddressIndices();
								}

								function chgRemoveExtraAddress(btn) {
									const list = document.getElementById('extra_address_list');
									if (list.querySelectorAll('.extra-addr-row').length > 1) {
										btn.closest('.extra-addr-row').remove();
										chgUpdateExtraAddressIndices();
									} else {
										alert('ต้องมีที่อยู่เพิ่มเติมอย่างน้อย 1 รายการ หรือถ้าไม่ต้องการใช้ ให้เว้นว่างข้อมูลไว้ครับ');
									}
								}

								function chgUpdateExtraAddressIndices() {
									const rows = document.querySelectorAll('.extra-addr-row');
									rows.forEach((row, index) => {
										const displayIndex = index + 1;
										row.setAttribute('data-index', displayIndex);
										row.querySelector('.extra-addr-title').innerHTML = 'ที่อยู่เพิ่มเติม ' + displayIndex;
										row.querySelector('.extra-contact-name-label').innerHTML = 'ชื่อผู้ติดต่อ (เพิ่มเติม' + displayIndex + ')';
										row.querySelector('.extra-contact-tel-label').innerHTML = 'เบอร์โทร (เพิ่มเติม' + displayIndex + ')';
										row.querySelector('.extra-shipping-address-label').innerHTML = 'ที่อยู่ส่งสินค้า (เพิ่มเติม' + displayIndex + ')';

										const contactName = row.querySelector('input[name^="extra_contact_name"]');
										if (contactName) contactName.name = 'extra_contact_name_' + displayIndex;

										const contactTel = row.querySelector('input[name^="extra_contact_tel"]');
										if (contactTel) contactTel.name = 'extra_contact_tel_' + displayIndex;

										const contactProvince = row.querySelector('select[name^="extra_contact_province"]');
										if (contactProvince) contactProvince.name = 'extra_contact_province_' + displayIndex;

										const shippingAddress = row.querySelector('input[name^="extra_shipping_address"]');
										if (shippingAddress) shippingAddress.name = 'extra_shipping_address_' + displayIndex;
									});

									chgRenderDeliveryPrintExtraGroups();
								}
							</script>

							<div style="margin-top: 28px;">
								<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 12px;">ที่อยู่ส่งบิล</h3>
								<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 18px;">

								<div class="so-grid-3">
									<div class="so-field-group">
										<label class="so-label" style="color: #612989;">ชื่อผู้ติดต่อ</label>
										<div style="position: relative; display: flex; align-items: center;">
											<input name="bill_extra_contact_name_2" type="text" class="so-input" placeholder="ชื่อผู้ติดต่อ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
											<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
										</div>
									</div>
									<div class="so-field-group">
										<label class="so-label" style="color: #612989;">เบอร์โทร</label>
										<div style="position: relative; display: flex; align-items: center;">
											<input name="bill_extra_contact_tel_2" type="text" class="so-input" placeholder="เบอร์โทร" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
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
												?>
														<option value="<?php echo so_saved_h($objResuut_prov_bill_extra['province_name']); ?>"><?php echo so_saved_h($objResuut_prov_bill_extra['province_name']); ?></option>
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
											<input name="bill_extra_shipping_address_2" type="text" class="so-input" placeholder="ที่อยู่ส่งสินค้า" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
											<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
										</div>
									</div>
									<button type="button" class="so-address-action-btn" onclick="chgToggleBillDeliveryPrintPanel()" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; height: 42px; min-width: 146px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
										<img src="img/icons/print.png" alt="print" style="width: 16px; height: 16px; object-fit: contain;"> พิมพ์
									</button>
								</div>

								<div id="chg_bill_delivery_print_panel" style="display:none; margin-top: 18px; border: 1px solid #EBEBEB; border-radius: 12px; padding: 18px; background-color: #FCFBFD;">
									<div style="display: flex; justify-content: space-between; gap: 12px; align-items: center; flex-wrap: wrap;">
										<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin: 0;">ชุดพิมพ์ใบปะจัดส่งบิล</h3>
										<span style="font-size: 13px; color: #7A6F85;">
											<?php echo $chgPrintCoverRefId !== '' ? 'เลขที่อ้างอิง: ' . so_saved_h($chgPrintCoverRefId) : 'ยังไม่มี ref_id สำหรับพิมพ์'; ?>
										</span>
									</div>
									<p style="margin: 10px 0 0; font-size: 13px; line-height: 1.6; color: #6C6772;">
										ใบปะจัดส่งบิลมีรายการเดียว โดยดึงข้อมูลจากเอกสารที่บันทึกแล้ว
									</p>
									<div style="margin-top: 18px; display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px;">
										<?php if (!empty($chgBillDeliveryReports) && is_array($chgBillDeliveryReports)) { ?>
											<?php foreach ($chgBillDeliveryReports as $reportConfig) { ?>
												<button type="button" onclick="chgOpenBillDeliveryPrintReport('<?php echo htmlspecialchars($reportConfig['file'], ENT_QUOTES, 'UTF-8'); ?>')" style="background-color: #FFFFFF; color: #612989; border: 1px solid #E5D8EF; border-radius: 10px; padding: 11px 14px; font-family: 'Prompt', sans-serif; font-size: 14px; font-weight: 500; cursor: pointer; text-align: center;">
													<?php echo htmlspecialchars($reportConfig['label'], ENT_QUOTES, 'UTF-8'); ?>
												</button>
											<?php } ?>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="step-more">
					<?php
					// การ์ด "แนบไฟล์" — ใช้ partial กลางร่วมกับ register_suphos.php/register_supbrhos.php
					// (posts เข้า slip1-slip5 เหมือนเดิม) ต้อง include js/doc-tabs-attach.js ที่หัวไฟล์ไว้ด้วย
					// ไม่งั้นปุ่ม "เพิ่มไฟล์" จะกดไม่ทำงาน (undefined function)
					$chgDocumentLogRowsForTabs = array();
					foreach ($chgDocumentLogRows as $chgDocumentLogRowForTabs) {
						$chgDocumentLogRowsForTabs[] = array(
							'status_label' => renderChgDocumentReturnStatus($chgDocumentLogRowForTabs['status_doc'] ?? ''),
							'status_class' => renderChgDocumentReturnStatusClass($chgDocumentLogRowForTabs['status_doc'] ?? ''),
							'reason' => $chgDocumentLogRowForTabs['reason'] ?? '',
							'user_name' => $chgDocumentLogRowForTabs['user_name'] ?? '',
							'created_at' => formatChgDocumentLogDateTime($chgDocumentLogRowForTabs['created_at'] ?? '')
						);
					}

					// document_return_log ต่อท้ายเสมอ — doc_tabs_card.php เลือกแท็บแรกที่ enabled เป็นแท็บ default
					$docTabsCard = [
						'open_fn' => 'brOpen3Tab',
						'attach_file' => ['enabled' => true],
						'document_return_log' => [
							'enabled' => true,
							'rows' => $chgDocumentLogRowsForTabs,
							'empty_text' => 'ยังไม่มีรายการส่งกลับเอกสาร',
						],
					];
					include __DIR__ . '/partials/doc_tabs_card.php';
					?>

					<input type="hidden" name="slip1" id="hidden_slip_val1" value="<?php echo so_saved_h($savedChg['slip1'] ?? ''); ?>">
					<input type="hidden" name="slip2" id="hidden_slip_val2" value="<?php echo so_saved_h($savedChg['slip2'] ?? ''); ?>">
					<input type="hidden" name="slip3" id="hidden_slip_val3" value="<?php echo so_saved_h($savedChg['slip3'] ?? ''); ?>">
					<input type="hidden" name="slip4" id="hidden_slip_val4" value="<?php echo so_saved_h($savedChg['slip4'] ?? ''); ?>">
					<input type="hidden" name="slip5" id="hidden_slip_val5" value="<?php echo so_saved_h($savedChg['slip5'] ?? ''); ?>">
				</div>

			</div>
		</div>
	</div>

	<?php
	// แถบปุ่มล่าง — Submit หายเมื่อเอกสารถูกส่งให้หัวหน้าไปแล้ว (send_sup='1') หรือปิดแล้ว (ยกเลิก/Approve)
	// ปุ่ม Save Draft/Update ใช้ได้จนกว่าเอกสารจะปิด
	$chgStatusDoc = $savedChg['status_doc'] ?? '';
	$chgSendSup = $savedChg['send_sup'] ?? '0';
	$chgIsClosed = in_array($chgStatusDoc, ['Approve', 'ยกเลิก'], true);
	$chgHideSubmit = $chgIsEditMode && ((string)$chgSendSup === '1' || $chgIsClosed);

	// แถบอนุมัติ — ชั้นเดียว (CH ไม่มี CM/ผู้ตรวจแบบ BR) พอร์ตจาก register_supbrcshos.php:2080-2090
	// แต่ตัดตรรกะหลายชั้นออก เหลือแค่ "ไม่ใช่ Sale + สถานะรออนุมัติ" ก็เห็นแถบนี้ได้
	$chgIsSaleUser = (($_SESSION['type_login'] ?? '') === 'Sale');
	$chgCanShowApproveBar = $chgIsEditMode && !$chgIsSaleUser && ($chgStatusDoc === 'Request');
	// ซ่อนปุ่ม Update ตัวหลักเมื่อแถบอนุมัติโชว์อยู่ เพราะแถบอนุมัติมีปุ่ม Update ของตัวเองแล้ว
	$chgHideUpdate = $chgIsClosed || $chgCanShowApproveBar;
	?>
	<div class="so-sticky-actions">
		<div class="so-sticky-actions-inner">
			<?php if ($chgCanShowApproveBar): ?>
				<!-- ค่าปุ่มอนุมัติต้องมากับ hidden ไม่ใช่ value ของ <button> เพราะทุกเส้นทาง submit ของหน้านี้
				     เป็น form.submit() แบบ programmatic ซึ่งไม่ส่ง name/value ของปุ่มที่กดไปด้วย -->
				<input type="hidden" name="approve_action" id="chg_approve_action" value="">
				<input type="hidden" name="chg_approve_reason" id="chg_approve_reason" value="">
				<div class="so-approve-actions">
					<button type="button" class="so-overflow-menu-trigger" id="btn_chg_approve_overflow" onclick="toggleChgApproveOverflowMenu()">
						<i class="fas fa-ellipsis-v"></i>
					</button>
					<div id="chgApproveOverflowMenu" class="so-overflow-menu">
						<button type="button" onclick="chgRunApproveAction('return', true)" style="color: #FF830F;"><img src="img/icons/send_back.png" alt="" style="width: 20px; height: 20px;"> ส่งกลับ</button>
						<button type="button" class="so-menu-danger" onclick="chgRunApproveAction('reject', true)" style="color: #FF0000;"><img src="img/icons/reject.png" alt="" style="width: 20px; height: 20px;"> ไม่อนุมัติ</button>
						<button type="button" onclick="triggerCancelDocFromChgApproveMenu()"><img src="img/icons/cancel_document.png" alt="" style="width: 20px; height: 20px;"> ยกเลิกเอกสาร</button>
					</div>
					<button type="button" class="btn-so-approve" onclick="chgRunApproveAction('approve', false)"><img src="img/icons/approval_status.png" alt="" style="width: 28px; height: 28px;"> อนุมัติ</button>
					<button type="button" name="save_draft" class="btn-so-draft" onclick="chgSaveDraft();"><img src="img/icons/update_document.png" alt="" style="width: 20px; height: 20px;"> Update</button>
				</div>
			<?php endif; ?>
			<?php if (!$chgHideSubmit): ?>
				<button type="submit" name="submit" id="btn_submit_form" value="submit" class="btn-so-submit"><i class="fas fa-paper-plane"></i> Submit</button>
			<?php endif; ?>
			<?php if (!$chgHideUpdate): ?>
				<button type="button" name="save_draft" class="btn-so-draft" onclick="chgSaveDraft();"><i class="far fa-save"></i> <?php echo $chgIsEditMode ? 'Update' : 'Save Draft'; ?></button>
			<?php endif; ?>
		</div>
	</div>
</form>

<script language="JavaScript">
	function toggleChgApproveOverflowMenu() {
		var menu = document.getElementById('chgApproveOverflowMenu');
		if (!menu) return;
		menu.style.display = (menu.style.display === 'none' || !menu.style.display) ? 'block' : 'none';
	}

	document.addEventListener('click', function(e) {
		var menu = document.getElementById('chgApproveOverflowMenu');
		var trigger = document.getElementById('btn_chg_approve_overflow');
		if (!menu || menu.style.display === 'none' || !menu.style.display) return;
		if (e.target === trigger || (trigger && trigger.contains(e.target))) return;
		if (!menu.contains(e.target)) menu.style.display = 'none';
	});

	// เปิด popup ให้กรอกเหตุผล (ส่งกลับ/ไม่อนุมัติ/ยกเลิก) — ห้าม submit ถ้าเหตุผลว่าง
	// mirror ของ register_supbrcshos.php:2267-2315 (csOpenReasonPopup)
	function chgOpenReasonPopup(opts) {
		var refInput = document.querySelector('input[name="ref_id"]');
		var refId = refInput ? refInput.value.trim() : '';

		if (typeof Swal === 'undefined') {
			var fallbackReason = window.prompt(opts.label || 'ระบุเหตุผล');
			fallbackReason = (fallbackReason || '').trim();
			if (fallbackReason !== '') opts.onConfirm(fallbackReason);
			return;
		}

		Swal.fire({
			title: opts.title,
			html: '<p class="so-reason-subtitle">' + opts.subtitleText + ' "' + refId + '"</p>' +
				'<label class="so-reason-label">' + opts.label + '<span class="so-reason-required">*</span></label>',
			input: 'textarea',
			inputPlaceholder: opts.placeholder || '',
			iconHtml: '<div class="so-reason-icon-circle" style="background:' + opts.iconBg + '"><img src="' + opts.iconSrc + '" alt="" style="width: 36px; height: 36px;"></div>',
			showCancelButton: true,
			showCloseButton: true,
			reverseButtons: false,
			confirmButtonText: 'ตกลง',
			cancelButtonText: 'ยกเลิก',
			buttonsStyling: false,
			customClass: {
				popup: 'figma-delete-popup so-reason-popup',
				title: 'figma-delete-title so-reason-title',
				htmlContainer: 'figma-delete-html so-reason-html',
				confirmButton: 'figma-delete-confirm-btn so-reason-confirm-btn',
				cancelButton: 'figma-delete-cancel-btn so-reason-cancel-btn',
				actions: 'figma-delete-actions so-reason-actions',
				icon: 'figma-delete-icon so-reason-icon',
				input: 'so-reason-textarea',
				closeButton: 'so-reason-close-btn'
			},
			preConfirm: function(value) {
				var trimmed = (value || '').trim();
				if (trimmed === '') {
					Swal.showValidationMessage('กรุณาระบุเหตุผล');
					return false;
				}
				return trimmed;
			}
		}).then(function(result) {
			if (result.isConfirmed) opts.onConfirm(result.value);
		});
	}

	// อนุมัติ / ส่งกลับ / ไม่อนุมัติ — เซ็ต hidden approve_action แล้วส่งฟอร์มไป register_supchange_edit1.php
	// (บันทึกฟอร์มปกติก่อน แล้วบล็อก approve_action จึงเขียนสถานะทับ) — พอร์ตจาก register_supbrcshos.php:2320-2361
	// ส่งกลับ/ไม่อนุมัติ ต้องกรอกเหตุผลก่อนแล้วข้าม validation ได้ ส่วนอนุมัติต้องผ่าน fncSubmit() ตามปกติ
	function chgRunApproveAction(action, skipValidation) {
		var field = document.getElementById('chg_approve_action');

		if (skipValidation) {
			var reasonConfig = {
				return: {
					title: 'ส่งกลับเอกสารนี้ ?',
					subtitleText: 'ส่งกลับเอกสารเลขที่',
					label: 'ระบุเหตุผลการส่งกลับ',
					placeholder: 'ระบุเหตุผลการส่งกลับ',
					iconBg: '#FFF4E5',
					iconSrc: 'img/icons/send_back.png'
				},
				reject: {
					title: 'ไม่อนุมัติเอกสารนี้ ?',
					subtitleText: 'ไม่อนุมัติเอกสารเลขที่',
					label: 'ระบุเหตุผลที่ไม่อนุมัติ',
					placeholder: 'ระบุเหตุผลที่ไม่อนุมัติ',
					iconBg: '#FEECEB',
					iconSrc: 'img/icons/reject.png'
				}
			} [action];
			if (!reasonConfig) return;

			chgOpenReasonPopup(Object.assign({}, reasonConfig, {
				onConfirm: function(reason) {
					if (chgSubmitting) return;
					chgSubmitting = true; // กันกดซ้ำ (เส้นทางนี้ไม่ผ่าน fncSubmit จึงต้องตั้งธงเอง)
					if (field) field.value = action;
					var reasonField = document.getElementById('chg_approve_reason');
					if (reasonField) reasonField.value = reason;
					HTMLFormElement.prototype.submit.call(chgEnsureSubmitMarker());
				}
			}));
			return;
		}

		if (field) field.value = action;
		fncSubmit();
		// fncSubmit() คืนค่า false ทั้งกรณีสำเร็จและ validation ไม่ผ่าน จึงดูจากธง chgSubmitting แทน
		if (!chgSubmitting && field) field.value = '';
	}

	// ยกเลิกเอกสารจากเมนู ⋮ — mirror ของ triggerCancelDocFromApproveMenu() ใน register_supbrcshos.php
	function triggerCancelDocFromChgApproveMenu() {
		chgOpenReasonPopup({
			title: 'ยกเลิกเอกสารนี้ ?',
			subtitleText: 'ต้องการยกเลิกเอกสารเลขที่',
			label: 'ระบุเหตุผลในการยกเลิก',
			placeholder: 'ระบุเหตุผลในการยกเลิก',
			iconBg: '#F4F5F7',
			iconSrc: 'img/icons/cancel_document.png',
			onConfirm: function(reason) {
				var cancelInput = document.getElementById('cancel_doc');
				if (cancelInput) cancelInput.value = '1';

				var reasonInput = document.getElementById('admin_cancel_reason');
				var reasonField = document.getElementById('chg_approve_reason');
				var actionField = document.getElementById('chg_approve_action');
				if (reasonInput) reasonInput.value = reason;
				if (reasonField) reasonField.value = reason;
				if (actionField) actionField.value = '';
				var form = chgEnsureSubmitMarker();
				if (form) HTMLFormElement.prototype.submit.call(form);
			}
		});
	}

	function goMainSupChange() {
		window.location.href = 'status_adminchange.php';
	}

	// พอร์ตจาก brcsSaveDraft() (register_supbrcshos.php:206-283) — AJAX POST is_draft=1 ไปยัง
	// register_supchange_draft1.php แล้ว redirect กลับมาหน้านี้ในโหมด view/edit เมื่อสำเร็จ
	function chgSaveDraft() {
		var form = document.forms['frmMain'];
		if (!form) return;

		if (!soValidateRequired(form)) return;

		var btn = form.querySelector('[name="save_draft"]');
		var defaultHtml = btn ? btn.innerHTML : '';
		var formData = new FormData(form);
		formData.set('is_draft', '1');

		if (btn) {
			btn.disabled = true;
			btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
		}

		fetch('register_supchange_draft1.php', {
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
								window.location.href = 'register_supchange.php?ref_id=' + encodeURIComponent(data.ref_id) + '&saved=1';
							}
						});
					} else {
						alert('บันทึกร่างเรียบร้อยแล้ว (Ref ID: ' + (data.ref_id || '') + ')');
						if (data.ref_id) {
							window.location.href = 'register_supchange.php?ref_id=' + encodeURIComponent(data.ref_id) + '&saved=1';
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
</script>

<?php if (count($chgPrefill) > 0) { ?>
	<!-- เติมค่ากลับเข้าฟอร์มใน edit mode — ตัวเดียวจบทั้งฟอร์ม พอร์ตจาก register_supbrcshos.php:2165-2213
	     รองรับ text/hidden/textarea, select, radio และ checkbox โดยเลือกวิธี set ตามชนิดของ element -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var chgPrefill = <?php echo json_encode($chgPrefill, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
			var chgForm = document.forms['frmMain'];
			if (!chgForm) return;

			// ที่อยู่เพิ่มเติมแถวที่ 2 ขึ้นไปยังไม่มีอยู่ใน DOM จนกว่าจะกด "เพิ่มที่อยู่" (คัดลอกแถวที่ 1)
			// ต้องเพิ่มแถวให้ครบก่อน ไม่งั้น querySelectorAll ด้านล่างจะหา extra_contact_name_2 ฯลฯ ไม่เจอ
			var chgExtraAddrRowsNeeded = <?php echo count($savedShippingRows); ?>;
			if (chgExtraAddrRowsNeeded > 1 && typeof chgAddExtraAddress === 'function') {
				for (var chgI = 1; chgI < chgExtraAddrRowsNeeded; chgI++) {
					chgAddExtraAddress();
				}
			}

			Object.keys(chgPrefill).forEach(function(fieldName) {
				var value = chgPrefill[fieldName];
				if (value === null || value === undefined) return;
				value = String(value);

				var elements = chgForm.querySelectorAll('[name="' + fieldName + '"]');
				if (!elements.length) return;

				elements.forEach(function(el) {
					if (el.type === 'radio') {
						if (el.value === value) el.checked = true;
					} else if (el.type === 'checkbox') {
						el.checked = (value === '1' || value === el.value);
					} else if (el.tagName === 'SELECT') {
						el.value = value;
						if (el.selectedIndex === -1 && value !== '') {
							var opt = document.createElement('option');
							opt.value = value;
							opt.textContent = value;
							opt.selected = true;
							el.appendChild(opt);
						}
					} else {
						el.value = value;
					}
				});
			});

			// ให้ UI ที่ผูกกับ toggle pill/สไตล์ตาม checked อัปเดตตาม (onchange ทำสไตล์ ไม่ใช่ CSS :checked)
			['is_high_roof', 'call_customer', 'no_money', 'send_cs', 'que_ckk'].forEach(function(name) {
				var el = document.querySelector('[name="' + name + '"]');
				if (el) el.dispatchEvent(new Event('change', {
					bubbles: true
				}));
			});

			// ตัวเลือก transport_company สร้างตาม delivery_type -> คืนค่าที่บันทึกไว้หลังตั้ง delivery_type แล้ว
			if (typeof updateTransportCompanyRequirement === 'function') {
				updateTransportCompanyRequirement(String(chgPrefill.transport_company || ''));
			}
		});
	</script>
<?php } ?>

<?php if ($savedCustomer !== null) {
	// เติมการ์ด "ข้อมูลลูกค้า" (display_bill_id ฯลฯ) ใน view/edit mode — พอร์ตจาก
	// register_supbrcshos.php:2215-2242 ตั้งค่าตรง ๆ ทาง PHP แทนการเรียก doCallAjax1() ซ้ำ เพราะ
	// doCallAjax1 จะเขียนทับ customer_name/customer_tel/address_name/province_name (ข้อมูลผู้ติดต่อ
	// จัดส่ง) ด้วยที่อยู่เริ่มต้นของลูกค้า ซึ่งจะลบค่าที่ $chgPrefill เติมไว้แล้วให้หายไป
	$savedCustomerNameParts = trim(($savedCustomer['first_name'] ?? '') . ' ' . ($savedCustomer['last_name'] ?? ''));
	$savedCustomerDisplayName = $savedCustomerNameParts !== '' ? $savedCustomerNameParts : ($savedCustomer['customer_name'] ?? '');
	if ($savedCustomerDisplayName === '') {
		$savedCustomerDisplayName = $savedCustomer['bill_name'] ?? '';
	}
	$savedCustomerDisplayTel = ($savedCustomer['cus_tel'] ?? '') !== '' ? $savedCustomer['cus_tel'] : ($savedCustomer['bill_tel'] ?? '');
?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			setElementText('display_bill_id', <?php echo json_encode($savedCustomer['customer_id'] ?? '', JSON_UNESCAPED_UNICODE); ?>);
			setElementText('display_bill_tel', <?php echo json_encode($savedCustomerDisplayTel, JSON_UNESCAPED_UNICODE); ?>);
			setElementText('display_bill_name', <?php echo json_encode($savedCustomerDisplayName, JSON_UNESCAPED_UNICODE); ?>);
			setElementText('display_customer_typename', <?php echo json_encode($savedCustomer['type_name'] ?? '', JSON_UNESCAPED_UNICODE); ?>);
			setElementText('display_mode_name', <?php echo json_encode($savedCustomer['status_cus'] ?? '', JSON_UNESCAPED_UNICODE); ?>);

			var vipIcon = document.getElementById('display_vip_icon');
			if (vipIcon) vipIcon.style.display = (<?php echo json_encode((string)($savedCustomer['vip_ckk'] ?? '')); ?> === '1') ? '' : 'none';

			if (typeof syncCreditTermTriggerState === 'function') syncCreditTermTriggerState();
		});
	</script>
<?php } ?>

<!-- Modal รายชื่อลูกค้า: ported 1:1 จาก register_supbrcshos.php:2250-2298 (component กลาง
     js/customer-popup.js + ajax_customer_popup_search.php, ไม่มี logic ใหม่ฝั่ง backend) -->
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

<!-- Credit Term Modal — ported จาก register_suphos.php:3470-3523 (js/credit-term-modal.js
     ยิง ajax_credit_term_modal.php?bill_id=... เอง ไม่มี logic ใหม่ฝั่งหน้านี้) -->
<div id="creditTermPopupModal" class="customer-popup-modal" aria-hidden="true">
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