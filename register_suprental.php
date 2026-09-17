<?php include("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>
<?php require_once __DIR__ . '/includes/so_saved_helpers.php'; // so_saved_h() ใช้โดย partials/admin_info_tab.php 
?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-supbrcshos.css?v=<?php echo filemtime(__DIR__ . '/css/register-supbrcshos.css'); ?>">
<link rel="stylesheet" href="css/register-suprental.css?v=<?php echo filemtime(__DIR__ . '/css/register-suprental.css'); ?>">
<link rel="stylesheet" href="css/credit-term-modal.css?v=<?php echo filemtime(__DIR__ . '/css/credit-term-modal.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/customer-popup.js?v=<?php echo filemtime(__DIR__ . '/js/customer-popup.js'); ?>"></script>
<script src="js/credit-term-modal.js?v=<?php echo filemtime(__DIR__ . '/js/credit-term-modal.js'); ?>"></script>

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

<script language="JavaScript">
	function selectByValueOrText(selectEl, raw) {
		const norm = s => (s ?? '').toString().trim();
		const target = norm(raw);
		if (!selectEl) return;

		// ลองเทียบกับ value ตรง ๆ
		for (const opt of selectEl.options) {
			if (norm(opt.value) === target) {
				selectEl.value = opt.value;
				return;
			}
		}
		// ไม่เจอ: ลองเทียบกับ text
		for (const opt of selectEl.options) {
			if (norm(opt.text) === target) {
				selectEl.value = opt.value;
				return;
			}
		}
		// เผื่อบางเคส: เพิ่ม option ชั่วคราวแล้วเลือกให้
		const o = new Option(target, target, true, true);
		selectEl.add(o);
	}



	var HttPRequest = false;

	function doCallAjax1(rental_id, rental_name, rental_tel, emergency_name, emergency_tel, rental_address, install_address, bill_name, bill_address, bill_tel, tax_no, connect_name, connect_tel, patient_name, install_address, address_1, address_name, address_send, customer_name, customer_tel, province_name, rental_addr_detail, rental_district, rental_province_sel, rental_zipcode) {
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
		var pmeters = "rental_id=" + encodeURI(document.getElementById(rental_id).value);
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

					setElementValue(rental_id, myArr[0]);
					setElementValue(rental_name, myArr[1]);
					setElementValue(rental_tel, myArr[2]);
					setElementValue(emergency_name, myArr[3]);
					setElementValue(emergency_tel, myArr[4]);
					setElementValue(rental_address, myArr[5]);
					setElementValue(install_address, myArr[6]);
					setElementValue(bill_name, myArr[7]);
					setElementValue(bill_address, myArr[8]);
					setElementValue(bill_tel, myArr[9]);
					setElementValue(tax_no, myArr[10]);
					setElementValue(connect_name, myArr[11]);
					setElementValue(connect_tel, myArr[12]);
					setElementValue(patient_name, myArr[13]);
					setElementValue(address_1, myArr[14]);
					setElementValue(address_name, myArr[14]);
					setElementValue('address_merged_ui', myArr[14]);
					setElementValue(customer_name, myArr[11]);
					setElementValue(customer_tel, myArr[12]);
					selectByValueOrText(document.getElementById(province_name), myArr[15]);

					setElementValue(rental_addr_detail, myArr[16]);
					setElementValue(rental_district, myArr[17]);
					selectByValueOrText(document.getElementById(rental_province_sel), myArr[18]);
					setElementValue(rental_zipcode, myArr[19]);

					if (typeof setElementText === 'function') {
						setElementText('display_rental_name', myArr[1]);
						setElementText('display_rental_tel', myArr[2]);
					}


				}
			}
		}
	}

	function setElementValue(id, value) {
		if (!id) return;
		var el = document.getElementById(id);
		if (el) el.value = (value === null || value === undefined) ? '' : value;
	}

	function setElementText(id, value) {
		var el = document.getElementById(id);
		if (el) {
			el.textContent = (value === null || value === undefined) ? '' : value;
		}
	}

	function setCreditThbDisplay(value) {
		var el = document.getElementById('display_credit_thb');
		var hCreditThb = document.getElementById('credit_thb');
		if (hCreditThb) hCreditThb.value = String(value || '').trim().replace(/,/g, '');
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
		if (typeof updateCreditDisplay === 'function') updateCreditDisplay();
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

	// ===== toggle "เพิ่มลงฐานลูกค้า" — ported จาก register_supbrcshos.php:316-352 =====
	function getCurrentRentalCustomerId() {
		var rentalIdInput = document.getElementById('rental_id');
		var hRentalId = document.getElementById('h_rental_id');
		var billId = document.getElementById('bill_id');
		var hBillId = document.getElementById('h_bill_id');
		return String(
			(rentalIdInput && rentalIdInput.value) ||
			(hRentalId && hRentalId.value) ||
			(billId && billId.value) ||
			(hBillId && hBillId.value) ||
			''
		).trim();
	}

	function toggleSaveToCustomerDb(btn) {
		var customerId = getCurrentRentalCustomerId();
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

	window.customerPopupOnConfirm = function(selectedCustomer) {
		selectedCustomer = selectedCustomer || {};
		var selectedCustId = String(selectedCustomer.customer_id || '').trim();

		var rentalIdInput = document.getElementById('rental_id');
		if (rentalIdInput) rentalIdInput.value = selectedCustId;
		var hRentalId = document.getElementById('h_rental_id');
		if (hRentalId) hRentalId.value = selectedCustId;
		var billIdInput = document.getElementById('bill_id');
		if (billIdInput) billIdInput.value = selectedCustId;
		var hBillIdInput = document.getElementById('h_bill_id');
		if (hBillIdInput) hBillIdInput.value = selectedCustId;

		doCallAjax1('rental_id', 'rental_name', 'rental_tel', 'emergency_name', 'emergency_tel',
			'rental_address', 'install_address', 'bill_name', 'bill_address', 'bill_tel',
			'tax_no', 'connect_name', 'connect_tel', 'patient_name', 'install_address',
			'address_1', 'address_name', 'address_send', 'customer_name', 'customer_tel',
			'province_name', 'rental_addr_detail', 'rental_district', 'rental_province', 'rental_zipcode');

		setElementText('display_rental_name', selectedCustomer.customer_name || selectedCustomer.bill_name);
		setElementText('display_rental_tel', selectedCustomer.cus_tel || selectedCustomer.bill_tel);
		setElementText('display_customer_typename', selectedCustomer.type_name);
		setElementText('display_mode_name', selectedCustomer.status_cus);
		setCreditThbDisplay(selectedCustomer.credit_thb);

		var vipIcon = document.getElementById('display_vip_icon');
		if (vipIcon) vipIcon.style.display = (String(selectedCustomer.vip_ckk) === '1') ? '' : 'none';

		// เก็บ bank id ของลูกค้าไว้ใน hidden เพื่อ restore dropdown ภายหลัง
		var cusCkk = String(selectedCustomer.credit_ckk || '').trim();
		var hCreditCkk = document.getElementById('h_credit_ckk_value');
		if (hCreditCkk) hCreditCkk.value = cusCkk;

		resolveBankPaymentMode(cusCkk, function(resolvedMode) {
			var customerPaymentModeInput = document.getElementById('h_customer_payment_mode');
			if (customerPaymentModeInput) {
				customerPaymentModeInput.value = resolvedMode;
			}
			switchPaymentMode(resolvedMode);
		});
	};

	function hasSelectedCustomerForPaymentMode() {
		var hBillId = document.getElementById('h_bill_id');
		return !!(hBillId && String(hBillId.value || '').trim() !== '');
	}

	function getResolvedCustomerPaymentMode() {
		var modeInput = document.getElementById('h_customer_payment_mode');
		return modeInput ? String(modeInput.value || '').trim() : '';
	}

	function resolveBankPaymentMode(bankId, onComplete) {
		var normalizedBankId = String(bankId === undefined || bankId === null ? '' : bankId).trim();
		if (normalizedBankId === '') {
			if (typeof onComplete === 'function') {
				onComplete('cash', '');
			}
			return;
		}

		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'get_bank_credit_flag.php?id=' + encodeURIComponent(normalizedBankId), true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState !== 4) {
				return;
			}

			var resolvedMode = 'cash';
			var resolvedFlag = '';
			if (xhr.status === 200) {
				try {
					var response = JSON.parse(xhr.responseText || '{}');
					resolvedFlag = String(response.credit_ckk || '').trim();
					if (response.success && resolvedFlag === '1') {
						resolvedMode = 'credit';
					}
				} catch (error) {
					console.error('resolveBankPaymentMode parse error', error);
				}
			}

			if (typeof onComplete === 'function') {
				onComplete(resolvedMode, resolvedFlag);
			}
		};
		xhr.send();
	}

	function loadTypeBankOptions(callback) {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'typebank_options.php', true);

		xhr.onreadystatechange = function() {
			if (xhr.readyState !== 4) {
				return;
			}

			var paymentMethodSelect = document.getElementById('payment_method');
			if (!paymentMethodSelect) {
				if (typeof callback === 'function') {
					callback();
				}
				return;
			}

			if (xhr.status === 200) {
				paymentMethodSelect.innerHTML = '<option value="0">เลือกวิธีชำระเงิน</option>' + (xhr.responseText || '');
				var savedValue = paymentMethodSelect.getAttribute('data-saved-value') || paymentMethodSelect.value || '0';
				if (savedValue && Array.prototype.some.call(paymentMethodSelect.options, function(option) {
						return option.value === savedValue;
					})) {
					paymentMethodSelect.value = savedValue;
				}
			} else {
				console.error('โหลดรายการวิธีชำระเงินไม่สำเร็จ');
				paymentMethodSelect.innerHTML = '<option value="0">เลือกวิธีชำระเงิน</option>';
			}

			if (typeof callback === 'function') {
				callback();
			}
		};
		xhr.send();
	}

	// โหลด options ช่องทางชำระเงิน
	function loadBankOptions(creditOnly, typeBank, callback) {
		if (typeof typeBank === 'function') {
			callback = typeBank;
			typeBank = undefined;
		}

		if (typeBank === undefined || typeBank === null || typeBank === '') {
			var pmSelect = document.getElementById('payment_method');
			if (pmSelect) {
				typeBank = pmSelect.value || '';
			}
		}

		var url = 'bank_options_awl.php?credit_only=' + (creditOnly ? '1' : '0');
		if (typeBank && typeBank !== '0') {
			url += '&type_bank=' + encodeURIComponent(typeBank);
		}

		var xhr = new XMLHttpRequest();
		xhr.open('GET', url, true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				if (xhr.status === 200) {
					var sel = document.getElementById('payment');
					var prev = sel.value; // เก็บค่าเดิมไว้ (กันเด้ง reset กรณีโหลดใหม่)
					sel.innerHTML = '<option value="">เลือกวิธีชำระเงิน</option>' + xhr.responseText;
					// พยายาม restore ค่าเดิม ถ้ายังอยู่ใน options ใหม่
					if ([...sel.options].some(o => o.value === prev)) sel.value = prev;

					// ซิงค์ค่าไปยัง dropdown ฝั่ง cash
					var cashSel = document.getElementById('payment_cash_select');
					if (cashSel) {
						cashSel.innerHTML = sel.innerHTML;
						cashSel.value = sel.value;
					}

				} else {
					console.error('โหลดช่องทางชำระเงินไม่สำเร็จ');
				}

				if (typeof callback === 'function') {
					callback();
				}
			}
		};
		xhr.send();
	}

	// สลับโหมดการชำระเงิน (เครดิต / เงินสด)
	function switchPaymentMode(mode, onComplete) {
		var isCredit = (mode === 'credit');

		var radCredit = document.getElementById('pay_mode_credit');
		var radCash = document.getElementById('pay_mode_cash');
		var creditLabel = document.getElementById('lbl-pay_mode_credit');
		var creditDaysInput = document.getElementById('display_credit_days');

		if (isCredit) {
			if (radCredit) radCredit.disabled = false;
			if (creditDaysInput) creditDaysInput.disabled = false;
			if (creditLabel) creditLabel.classList.remove('is-disabled');
			if (radCredit) radCredit.checked = true;
			document.getElementById('lbl-pay_mode_credit')?.classList.add('active');
			document.getElementById('lbl-pay_mode_cash')?.classList.remove('active');

			document.getElementById('row-credit-fields').style.display = 'grid';
			document.getElementById('row-cash-fields').style.display = 'none';

			loadBankOptions(false, function() {
				var savedCusCkk = document.getElementById('h_credit_ckk_value').value || '';
				var sel = document.getElementById('payment');
				if (savedCusCkk && savedCusCkk !== '0') {
					sel.value = savedCusCkk;
				} else {
					sel.value = '';
				}
				var cashSel = document.getElementById('payment_cash_select');
				if (cashSel) cashSel.value = sel.value;
				updateCreditDisplay();
				if (typeof onComplete === 'function') onComplete();
			});
		} else {
			var shouldDisableCredit = hasSelectedCustomerForPaymentMode() && getResolvedCustomerPaymentMode() === 'cash';
			if (radCredit) radCredit.disabled = shouldDisableCredit;
			if (creditDaysInput) creditDaysInput.disabled = true;
			if (creditLabel) creditLabel.classList.toggle('is-disabled', shouldDisableCredit);
			if (radCash) radCash.checked = true;
			document.getElementById('lbl-pay_mode_cash')?.classList.add('active');
			document.getElementById('lbl-pay_mode_credit')?.classList.remove('active');

			document.getElementById('row-cash-fields').style.display = 'grid';
			document.getElementById('row-credit-fields').style.display = 'none';

			loadBankOptions(true, function() {
				var sel = document.getElementById('payment');
				var savedCusCkk = document.getElementById('h_credit_ckk_value').value || '';
				if (savedCusCkk && [...sel.options].some(function(option) {
						return option.value === savedCusCkk;
					})) {
					sel.value = savedCusCkk;
				} else if (savedCusCkk === '0' || !savedCusCkk) {
					sel.value = '';
				} else {
					sel.value = '';
				}
				var cashSel = document.getElementById('payment_cash_select');
				if (cashSel) cashSel.value = sel.value;
				if (typeof onComplete === 'function') onComplete();
			});
		}
	}

	// อัปเดตข้อมูลการแสดงผลเครดิต
	function updateCreditDisplay() {
		var sel = document.getElementById('payment');
		var selectedText = sel.options[sel.selectedIndex]?.text || '';
		var creditDays = selectedText.match(/\d+/) ? selectedText.match(/\d+/)[0] : '';

		var displayDays = document.getElementById('display_credit_days');
		if (displayDays) displayDays.value = creditDays || '30';

		var creditLimit = document.getElementById('credit_thb').value || '0';
		var formattedLimit = parseFloat(creditLimit.replace(/,/g, '')) || 0;
		var displayLimit = document.getElementById('display_credit_limit');
		if (displayLimit) displayLimit.value = formattedLimit.toLocaleString('en-US');
	}

	function syncSlipUploadToSlip1(input) {
		var fileNameDisplay = document.getElementById('file_name_display');
		if (fileNameDisplay) {
			fileNameDisplay.textContent = (input.files && input.files[0]) ? input.files[0].name : 'Choose File';
		}
	}

	document.addEventListener('DOMContentLoaded', function() {
		rtBeginDocumentInitialization();
		loadTypeBankOptions(function() {
			var pmSelect = document.getElementById('payment_method');
			if (pmSelect && pmSelect.value !== '0' && pmSelect.value !== '') {
				loadBankOptions(true, pmSelect.value, rtEndDocumentInitialization);
			} else {
				rtEndDocumentInitialization();
			}
		});
		rtBeginDocumentInitialization();
		switchPaymentMode('credit', rtEndDocumentInitialization);

		var pmSelectElem = document.getElementById('payment_method');
		if (pmSelectElem) {
			pmSelectElem.addEventListener('change', function() {
				var selectedTypeBank = this.value;
				loadBankOptions(true, selectedTypeBank, function() {
					var sel = document.getElementById('payment');
					var cashSel = document.getElementById('payment_cash_select');
					if (cashSel) cashSel.value = sel.value;
				});
			});
		}

		var hCreditThbInput = document.getElementById('credit_thb');
		if (hCreditThbInput) {
			hCreditThbInput.addEventListener('input', function() {
				updateCreditDisplay();
			});
		}
	});

	function rtOpenMainTab(cityName, el) {
		if (typeof openCity1 === 'function') {
			openCity1(cityName);
		}
		if (!el) return;
		var tabs = el.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < tabs.length; i++) {
			tabs[i].classList.remove('active');
		}
		el.classList.add('active');
	}

	function rtOpenFinTab(tabId, el) {
		var contents = document.getElementsByClassName('rt-fin-tab-content');
		for (var i = 0; i < contents.length; i++) contents[i].classList.remove('active');
		var target = document.getElementById(tabId);
		if (target) target.classList.add('active');
		if (!el) return;
		var tabs = el.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < tabs.length; i++) tabs[i].classList.remove('active');
		el.classList.add('active');
	}

	function rtOpenDocTab(tabId, el) {
		var contents = document.getElementsByClassName('so-tab-content');
		for (var i = 0; i < contents.length; i++) contents[i].classList.remove('active');
		var target = document.getElementById(tabId);
		if (target) target.classList.add('active');
		if (!el) return;
		var tabs = el.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < tabs.length; i++) tabs[i].classList.remove('active');
		el.classList.add('active');
	}
</script>

<body>
	<?php

	$yearMonth = substr(date("Y") + 543, -2) . date("m");
	$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__rental";
	$qry = mysqli_query($conn, $sql) or die(mysqli_error());
	$rs = mysqli_fetch_assoc($qry);
	$maxId = substr($rs['MAXID'] ?? '', -4);
	$maxId3 = substr($rs['MAXID'] ?? '', -8);

	$maxId1 = substr($maxId3, 0, -4);
	$so = "RT";

	if ($maxId1 == $yearMonth) {
		$maxId1 = ($maxId + 1);
		$maxId2 = substr("00000" . $maxId1, -4);
		$nextId = $yearMonth . $maxId2;
	} else {
		$maxId1 = "0001";
		$nextId = $yearMonth . $maxId1;
	}

	// ===== โหลดเอกสารเดิม (view/edit mode) เมื่อมี ?ref_id=... =====
	// mirror register_supchange.php:285-358 — ทุก query กันด้วย mysqli_num_rows/query truthiness
	// ไม่มีแถวก็ปล่อยเป็น null เพื่อ fallback เป็นฟอร์มว่างเหมือนสร้างใหม่
	$savedRentalRefId = isset($_GET["ref_id"]) ? mysqli_real_escape_string($conn, $_GET["ref_id"]) : "";
	// คัดลอกใบเดิม: ?copy_from=... โหลดข้อมูลเอกสารเก่ามา prefill แต่ต้องไม่ตั้ง $savedRental
	// เพื่อให้ $rentalIsEditMode ยังคงเป็น false (สร้างเอกสารใหม่จริง ไม่ใช่ทับเอกสารเดิม) — ดู register_supchange.php:289-292
	$copyFromRefId = isset($_GET["copy_from"]) ? mysqli_real_escape_string($conn, $_GET["copy_from"]) : "";
	$loadRentalRefId = $savedRentalRefId !== "" ? $savedRentalRefId : $copyFromRefId;
	$savedRental = null;
	$copySrcRental = null;
	$savedRegister = null;
	$savedTransaction = null;
	$savedRentalProducts = array();
	$savedRentalCustomerDisplay = null;
	$latestRentalDocumentReason = null;

	if ($loadRentalRefId !== "") {
		$savedRentalQuery = mysqli_query($conn, "SELECT * FROM hos__rental WHERE ref_id = '" . $loadRentalRefId . "' LIMIT 1");
		if ($savedRentalQuery && mysqli_num_rows($savedRentalQuery) > 0) {
			$loadedRental = mysqli_fetch_assoc($savedRentalQuery);
			if ($savedRentalRefId !== "") {
				$savedRental = $loadedRental;
			} else {
				$copySrcRental = $loadedRental;
			}

			if (!empty($loadedRental['rental_id'])) {
				$savedRentalCustIdEsc = mysqli_real_escape_string($conn, $loadedRental['rental_id']);
				$savedRentalCustomerQuery = mysqli_query($conn, "SELECT c.customer_id, c.customer_name, c.bill_name, c.cus_tel, c.bill_tel,
					c.credit_thb, c.credit_ckk, c.status_cus, c.vip_ckk, t.type_name
					FROM tb_customer c LEFT JOIN tb_typecustomer t ON c.type_customer = t.type_id
					WHERE c.customer_id = '" . $savedRentalCustIdEsc . "' LIMIT 1");
				if ($savedRentalCustomerQuery && mysqli_num_rows($savedRentalCustomerQuery) > 0) {
					$savedRentalCustomerDisplay = mysqli_fetch_assoc($savedRentalCustomerQuery);
				}
			}

			$savedRegisterQuery = mysqli_query($conn, "SELECT * FROM tb_register_data WHERE ref_id = '" . $loadRentalRefId . "' LIMIT 1");
			if ($savedRegisterQuery) {
				$savedRegister = mysqli_fetch_assoc($savedRegisterQuery);
			}

			$savedTransactionQuery = mysqli_query($conn, "SELECT * FROM tb_transaction WHERE ref_id = '" . $loadRentalRefId . "' LIMIT 1");
			if ($savedTransactionQuery) {
				$savedTransaction = mysqli_fetch_assoc($savedTransactionQuery);
			}

			if ($savedRentalRefId !== "") {
				$latestRentalDocumentReasonQuery = mysqli_query($conn, "SELECT status_doc, reason
					FROM tb_document_status_log
					WHERE ref_id = '" . $loadRentalRefId . "'
						AND status_doc IN ('ส่งกลับ', 'Rejected', 'Cancelled')
					ORDER BY created_at DESC, id DESC
					LIMIT 1");
				if ($latestRentalDocumentReasonQuery && mysqli_num_rows($latestRentalDocumentReasonQuery) > 0) {
					$latestRentalDocumentReason = mysqli_fetch_assoc($latestRentalDocumentReasonQuery);
				}
			}
			// LEFT JOIN tb_product เพราะ hos__subrental ไม่มีคอลัมน์ product_name/unit_name ของตัวเอง
			$savedRentalProductsQuery = mysqli_query($conn, "SELECT hos__subrental.*, tb_product.sol_name AS tb_sol_name, tb_product.unit_name AS tb_unit_name FROM hos__subrental LEFT JOIN tb_product ON hos__subrental.product_id = tb_product.product_ID WHERE hos__subrental.ref_idd = '" . $loadRentalRefId . "' ORDER BY hos__subrental.id_sub ASC");
			if ($savedRentalProductsQuery) {
				while ($savedRentalProductRow = mysqli_fetch_assoc($savedRentalProductsQuery)) {
					$savedRentalProducts[] = $savedRentalProductRow;
				}
			}
		}
	}

	$rentalIsEditMode = ($savedRental !== null);
	$rentalIsCancelChecked = $rentalIsEditMode && (($savedRental['cancel_flag'] ?? '0') == '1');
	$rentalSrc = $savedRental ?? $copySrcRental;

	// ---- แผนที่ค่า prefill สำหรับ edit mode / คัดลอกใบเดิม (copy_from) ----
	// พอร์ต pattern เดียวกับ register_supchange.php:362-483 — เติมค่าที่เดียว แล้วให้ JS ตัวเดียว
	// เติมกลับเข้าฟอร์ม (ดู script ก่อนปิด </form>) — ใช้ $rentalSrc (edit หรือ copy) ไม่ใช่ $savedRental ตรงๆ
	// เพราะฟิลด์ที่ผูกกับสถานะเอกสารเดิม (ref_id, promis_no, bank_img) ยังต้องอ้าง $savedRental/$rentalIsEditMode ตรงๆ ต่อไป
	$rentalPrefill = array();
	if ($rentalSrc !== null) {
		$rentalTypeProductMap = array('1' => 'สินค้าเตียง', '2' => 'สินค้าที่นอน', '3' => 'สินค้าอื่นๆ');
		$rentalPrefill = array(
			'type_doc' => $rentalSrc['type_doc'],
			'sale_code' => $rentalSrc['sale_code'],
			'product_type_rental' => $rentalTypeProductMap[$rentalSrc['type_product'] ?? ''] ?? '',
			'start_promis' => so_saved_iso_date_input($rentalSrc['start_promis'] ?? ''),
			'count_m' => $rentalSrc['count_m'],
			'rental_item_name' => $rentalSrc['des_productunit'],
			'register_date' => so_saved_iso_date_input($rentalSrc['register_date'] ?? ''),
			'rental_address' => $rentalSrc['rental_address'],
			'rental_name' => $rentalSrc['rental_name'],
			'rental_id' => $rentalSrc['rental_id'],
			'h_rental_id' => $rentalSrc['rental_id'],
			'rental_tel' => $rentalSrc['rental_tel'],
			'rental_addr_detail' => $rentalSrc['rental_addr_detail'],
			'rental_province' => $rentalSrc['rental_province'],
			'rental_district' => $rentalSrc['rental_district'],
			'rental_zipcode' => $rentalSrc['rental_zipcode'],
			'payment' => $rentalSrc['payment'],
			'des_sale' => $rentalSrc['des_sale'],
			'delivery_type' => $rentalSrc['delivery_type'],
			'start_date' => so_saved_iso_date_input($rentalSrc['delivery_date'] ?? ''),
			'between_date' => $rentalSrc['delivery_key'],
			'shipping_date' => so_saved_iso_date_input($rentalSrc['date_ker'] ?? ''),
			'shipping_ref1' => $rentalSrc['order_refer_code'],
			'shipping_ref2' => $rentalSrc['order_refer_code1'],
			'shipping_cost' => $rentalSrc['ker_bath'],
			'bank_name' => $rentalSrc['bank_name'],
			'bank_no' => $rentalSrc['bank_no'],
			'accbank_name' => $rentalSrc['accbank_name'],
			'send_cs' => (($rentalSrc['send_cs'] ?? '') === '2') ? '1' : '0',
		);

		// คัดลอกใบเดิม (copy_from): เอกสารใหม่ต้องใช้วันที่ลงทะเบียนปัจจุบัน ($today ที่ hidden input
		// register_date default ไว้อยู่แล้ว) ไม่ใช่วันที่ของเอกสารต้นฉบับ
		if ($savedRental === null && $copySrcRental !== null) {
			unset($rentalPrefill['register_date']);
		}

		if ($savedRegister !== null) {
			$rentalSavedStartTime = substr((string)($savedRegister['start_time'] ?? ''), 0, 5);
			$rentalSavedEndTime = substr((string)($savedRegister['end_time'] ?? ''), 0, 5);
			$rentalSavedTimeRange = '';
			if ($rentalSavedStartTime === '08:00' && $rentalSavedEndTime === '12:00') {
				$rentalSavedTimeRange = 'morning';
			} else if ($rentalSavedStartTime === '13:00' && $rentalSavedEndTime === '17:00') {
				$rentalSavedTimeRange = 'afternoon';
			} else if ($rentalSavedStartTime === '08:00' && $rentalSavedEndTime === '17:00') {
				$rentalSavedTimeRange = 'allday';
			} else if ($rentalSavedStartTime !== '') {
				$rentalSavedTimeRange = 'specific';
			}
			$rentalAddress1OrName = ($savedRegister['address_1'] ?? '') !== '' ? $savedRegister['address_1'] : ($savedRegister['address_name'] ?? '');
			$rentalPrefill['customer_name'] = $savedRegister['customer_name'];
			$rentalPrefill['customer_tel'] = $savedRegister['customer_tel'];
			$rentalPrefill['province_name'] = $savedRegister['province_name'];
			$rentalPrefill['address_1'] = $rentalAddress1OrName;
			$rentalPrefill['address_name'] = $rentalAddress1OrName;
			$rentalPrefill['address_merged_ui'] = $rentalAddress1OrName;
			$rentalPrefill['address_send'] = $savedRegister['address_send'];
			$rentalPrefill['location_link'] = $savedRegister['location_link'];
			$rentalPrefill['transport_company'] = $savedRegister['transport_company'];
			$rentalPrefill['status_comment'] = $savedRegister['status_comment'];
			$rentalPrefill['call_customer'] = $savedRegister['call_customer'];
			$rentalPrefill['no_money'] = $savedRegister['no_price'];
			$rentalPrefill['start_time'] = $rentalSavedStartTime;
			$rentalPrefill['end_time'] = $rentalSavedEndTime;
			$rentalPrefill['time_range_ui'] = $rentalSavedTimeRange;
		}

		// tb_transaction ('แท็บ รายละเอียดที่อยู่') — ผูกกลับด้านของ mapping ใน register_suprental1.php
		if ($savedTransaction !== null) {
			$rentalPrefill['park_front'] = (($savedTransaction['car_home'] ?? '') === '1') ? '1' : '0';
			$rentalPrefill['park_location'] = $savedTransaction['car_park'];
			$rentalPrefill['is_high_roof'] = $savedTransaction['height_ltd'];
			$rentalPrefill['entrance_type'] = (($savedTransaction['bundai'] ?? '') === '1') ? '2' : '1';
			$rentalPrefill['stair_count'] = $savedTransaction['unit_bundai'];
			$rentalPrefill['install_floor'] = $savedTransaction['install'];
			$rentalPrefill['room_type'] = $savedTransaction['install_room'];
			$rentalPrefill['door_width'] = $savedTransaction['room_bigger'];
			$rentalPrefill['door_height'] = $savedTransaction['room_longer'];

			$savedRentalStairSize = explode(' x ', (string)($savedTransaction['bundai_big'] ?? ''), 2);
			$rentalPrefill['stair_width'] = $savedRentalStairSize[0] ?? '';
			$rentalPrefill['stair_height'] = $savedRentalStairSize[1] ?? '';

			$savedRentalElevDoorSize = explode(' x ', (string)($savedTransaction['lip_big'] ?? ''), 2);
			$rentalPrefill['elev_door_width'] = $savedRentalElevDoorSize[0] ?? '';
			$rentalPrefill['elev_door_height'] = $savedRentalElevDoorSize[1] ?? '';

			$savedRentalElevSize = explode(' x ', (string)($savedTransaction['lip_long'] ?? ''), 3);
			$rentalPrefill['elev_width'] = $savedRentalElevSize[0] ?? '';
			$rentalPrefill['elev_height'] = $savedRentalElevSize[1] ?? '';
			$rentalPrefill['elev_depth'] = $savedRentalElevSize[2] ?? '';

			$rentalPrefill['elev_capacity'] = $savedTransaction['lip_weight'];
			$rentalPrefill['move_furn'] = $savedTransaction['want_employee'];
			$rentalPrefill['move_furn_count'] = $savedTransaction['employee_unit'];
			$rentalPrefill['move_furn_detail'] = $savedTransaction['ferniger_name'];
			$rentalPrefill['addr_note'] = $savedTransaction['description'];
		}
	}

	?>

	<!--action="register_office1.php"-->
	<form action="<?php echo $rentalIsEditMode ? 'register_suprental_edit1.php' : 'register_suprental1.php'; ?>" method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">

		<script language="javascript">
			var rtSubmitting = false; // กันเรียก fncSubmit ซ้ำระหว่างกำลังบันทึก (double-click / กดซ้ำตอนเน็ตช้า)
			var rtIsEditMode = <?php echo $rentalIsEditMode ? 'true' : 'false'; ?>; // มาจากฝั่งเซิร์ฟเวอร์ ห้ามใช้แค่ ref_id เพราะ create mode ก็มี ref_id ที่ generate ไว้ล่วงหน้า
			var rtDocBaseline = null; // snapshot ฟอร์มหลัง prefill เสร็จ ใช้เทียบก่อนเปิดเอกสารเดิม (register_suprental.php)
			var rtDocInitializationPending = 0;
			var rtDocDomReady = false;

			// สลับแท็บที่ field ซ่อนอยู่ให้ขึ้นมาก่อน focus (รองรับทั้ง 3 ระบบแท็บของหน้านี้:
			// so-tab-content/rtOpenDocTab, so-addr-tab-content/rtOpenAddrTab, rt-fin-tab-content/rtOpenFinTab)
			function rtFocusField(field) {
				if (!field) return;
				var hiddenParent = field.closest('.so-tab-content:not(.active)') ||
					field.closest('.so-addr-tab-content[style*="display:none"], .so-addr-tab-content[style*="display: none"]') ||
					field.closest('.rt-fin-tab-content:not(.active)');
				if (hiddenParent && hiddenParent.id) {
					var tabBtn = document.querySelector(".so-tab-btn[onclick*=\"'" + hiddenParent.id + "'\"]");
					if (tabBtn) tabBtn.click();
				}
				field.focus();
			}

			// form.submit() แบบ programmatic ไม่ส่งค่าปุ่ม <button name="submit"> มาด้วย (ต่างจากคลิกปุ่มจริง)
			// จึงต้องสร้าง hidden input name="submit" เอง ไม่งั้น register_suprental1.php จะไม่เห็นว่ากดบันทึก
			// (pattern เดียวกับ register_supchange.php: chgEnsureSubmitMarker)
			function rtEnsureSubmitMarker() {
				var rtForm = document.forms['frmMain'];
				var rtSubmitValue = rtForm.querySelector('input[type="hidden"][name="submit"]');
				if (!rtSubmitValue) {
					rtSubmitValue = document.createElement('input');
					rtSubmitValue.type = 'hidden';
					rtSubmitValue.name = 'submit';
					rtForm.appendChild(rtSubmitValue);
				}
				rtSubmitValue.value = 'submit';
				return rtForm;
			}

			function fncSubmit() //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
			{
				if (rtSubmitting) return false;

				var rtRequiredFields = [
					['start_promis', 'กรุณาระบุวันเริ่มสัญญา'],
					['count_m', 'กรุณาระบุระยะเวลาเช่า'],
					['rental_name', 'กรุณาใส่ชื่อผู้เช่า'],
					['rental_tel', 'กรุณาใส่เบอร์โทรศัพท์ผู้เช่า'],
					['rental_addr_detail', 'กรุณาใส่ที่อยู่ผู้เช่า'],
					['rental_province', 'กรุณาเลือกจังหวัดผู้เช่า'],
					['rental_district', 'กรุณาเลือกเขต/อำเภอผู้เช่า'],
					['rental_zipcode', 'กรุณาใส่รหัสไปรษณีย์ผู้เช่า'],
					['customer_name', 'กรุณาใส่ชื่อผู้ติดต่อ'],
					['customer_tel', 'กรุณาใส่เบอร์โทรศัพท์ผู้ติดต่อ'],
					['province_name', 'กรุณาเลือกจังหวัดที่ต้องการจัดส่ง'],
					['address_send', 'กรุณาใส่สถานที่ติดตั้งเครื่อง'],
					['bank_name', 'กรุณาเลือกวิธีชำระเงินคืน'],
					['bank_no', 'กรุณาใส่เบอร์โทรศัพท์/เลขที่บัญชี'],
					['accbank_name', 'กรุณาใส่ชื่อบัญชี']
				];

				for (var i = 0; i < rtRequiredFields.length; i++) {
					var fieldName = rtRequiredFields[i][0];
					var field = document.frmMain[fieldName];
					if (field && String(field.value).trim() === '') {
						alert(rtRequiredFields[i][1]);
						rtFocusField(field);
						return false;
					}
				}

				var addressMergedInput = document.getElementById('address_merged_ui');
				if (addressMergedInput && addressMergedInput.value.trim() === '') {
					alert('กรุณาใส่ที่อยู่ในการส่งสินค้า');
					rtFocusField(addressMergedInput);
					return false;
				}

				var bankImgInput = document.frmMain['bank_img'];
				var bankImgExistingInput = document.frmMain['bank_img_existing'];
				var bankImgHasExisting = bankImgExistingInput && bankImgExistingInput.value.trim() !== '';
				if (bankImgInput && !bankImgHasExisting && (!bankImgInput.files || bankImgInput.files.length === 0)) {
					alert('กรุณาแนบไฟล์รูป Book Bank');
					rtFocusField(bankImgInput);
					return false;
				}

				// ผ่าน validation ครบแล้ว กำลังจะ submit จริง -> disable ปุ่มกันกดซ้ำ
				// ไม่ต้อง re-enable เพราะหน้าจะ navigate ออกไปอยู่แล้วเมื่อสำเร็จ
				rtSubmitting = true;
				var rtSubmitBtn = document.getElementById('btn_submit_form');
				if (rtSubmitBtn) {
					rtSubmitBtn.disabled = true;
					rtSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...';
				}

				// ปุ่ม <button type="submit" name="submit"> ทับเมธอด form.submit() (DOM clobbering)
				// จึงต้องเรียกผ่าน prototype โดยตรง (pattern เดียวกับ register_supchange.php)
				HTMLFormElement.prototype.submit.call(rtEnsureSubmitMarker());
				return false;
			}

			// บันทึกร่าง: AJAX POST is_draft=1 ไปยัง register_suprental_draft1.php แล้ว redirect
			// กลับมาหน้านี้ในโหมด view/edit เมื่อสำเร็จ — พอร์ตจาก register_supchange.php: chgSaveDraft
			function rtSaveDraft() {
				var form = document.forms['frmMain'];
				if (!form) return;

				var btn = form.querySelector('[name="save_draft"]');
				var defaultHtml = btn ? btn.innerHTML : '';
				var formData = new FormData(form);
				formData.set('is_draft', '1');

				if (btn) {
					btn.disabled = true;
					btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...';
				}

				fetch('register_suprental_draft1.php', {
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
										window.location.href = 'register_suprental.php?ref_id=' + encodeURIComponent(data.ref_id) + '&saved=1';
									}
								});
							} else {
								alert('บันทึกร่างเรียบร้อยแล้ว (Ref ID: ' + (data.ref_id || '') + ')');
								if (data.ref_id) {
									window.location.href = 'register_suprental.php?ref_id=' + encodeURIComponent(data.ref_id) + '&saved=1';
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

			// เปิดพรีวิวใบสั่งเช่าในแท็บใหม่ โดยยิงค่าปัจจุบันในฟอร์มไปให้ from_rental.php
			// (from_rental.php มี preview path อ่านจาก POST อยู่ใน from_rental_preview_helper.php)
			// พอร์ตจาก register_supchange.php:605-650 (chgOpenPreview)
			function rtOpenPreview() {
				var form = document.forms.frmMain;
				var refInput = form ? form.querySelector('input[name="ref_id"]') : null;
				var refId = refInput ? refInput.value.trim() : '';

				if (!form || !refId) {
					Swal.fire('แจ้งเตือน', 'ไม่พบเลขที่อ้างอิง (ref_id)', 'warning');
					return;
				}

				var previewTarget = 'rental_preview_' + Date.now();
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

				form.action = 'from_rental.php';
				form.method = 'post';
				form.target = previewTarget;
				// พรีวิวไม่ใช้ไฟล์แนบ จึงไม่ต้องอัปโหลด Book Bank ซ้ำไปที่หน้ารายงาน
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

				form.removeChild(previewFlag);
			}

			// snapshot ค่าฟอร์มปัจจุบัน (ไม่รวม field ชั่วคราวที่เกิดจาก action flow เช่นตอน submit/preview)
			// ใช้เทียบกับ rtDocBaseline เพื่อรู้ว่าฟอร์มถูกแก้หลัง prefill ไปแล้วหรือยัง
			function rtCaptureFormSnapshot() {
				var form = document.forms['frmMain'];
				if (!form) return '';

				var rtSnapshotExcludeNames = ['submit', '_report_preview', 'is_draft'];
				var parts = [];

				Array.prototype.forEach.call(form.elements, function(el) {
					if (!el.name || rtSnapshotExcludeNames.indexOf(el.name) !== -1) return;
					if (el.disabled) return;

					if (el.type === 'file') {
						var fileList = el.files ? Array.prototype.map.call(el.files, function(f) {
							return f.name + ':' + f.size;
						}).join(',') : '';
						parts.push(el.name + '=' + fileList);
					} else if (el.type === 'checkbox' || el.type === 'radio') {
						parts.push(el.name + ':' + el.value + '=' + (el.checked ? '1' : '0'));
					} else {
						parts.push(el.name + '=' + el.value);
					}
				});

				return parts.join('|');
			}

			function rtBeginDocumentInitialization() {
				rtDocInitializationPending++;
			}

			function rtEndDocumentInitialization() {
				if (rtDocInitializationPending > 0) rtDocInitializationPending--;
				rtCaptureDocumentBaselineWhenReady();
			}

			function rtCaptureDocumentBaselineWhenReady() {
				if (!rtDocDomReady || rtDocInitializationPending !== 0) return;
				rtDocBaseline = rtCaptureFormSnapshot();
			}

			// เปิดเอกสารเดิม (หนังสือสัญญา/ใบรับส่งสินค้า/ใบรับส่งสินค้า Preview) ที่อ่านข้อมูลจาก DB ตรงๆ
			// ต้องเป็นข้อมูลที่บันทึกแล้วเท่านั้น จึงเช็ค edit mode + ต้องไม่มีการแก้ไขค้างที่ยังไม่ Update
			function rtOpenSavedRentalDocument(reportFile) {
				if (!rtIsEditMode) {
					Swal.fire('แจ้งเตือน', 'กรุณาบันทึกเอกสารก่อน จึงจะสามารถเปิดรายงานนี้ได้', 'warning');
					return;
				}

				if (rtDocBaseline === null) {
					Swal.fire('แจ้งเตือน', 'ระบบกำลังเตรียมข้อมูลเอกสาร กรุณารอสักครู่แล้วลองอีกครั้ง', 'warning');
					return;
				}

				if (rtCaptureFormSnapshot() !== rtDocBaseline) {
					Swal.fire('แจ้งเตือน', 'มีการแก้ไขข้อมูลในฟอร์ม กรุณากด Update เพื่อบันทึกก่อน จึงจะสามารถเปิดรายงานนี้ได้', 'warning');
					return;
				}

				var form = document.forms['frmMain'];
				var refInput = form ? form.querySelector('input[name="ref_id"]') : null;
				var refId = refInput ? refInput.value.trim() : '';

				if (!refId) {
					Swal.fire('แจ้งเตือน', 'ไม่พบเลขที่อ้างอิง (ref_id)', 'warning');
					return;
				}

				window.open(reportFile + '?ref_id=' + encodeURIComponent(refId), '_blank');
			}
		</script>

		<div class="rt-layout">
			<div class="rt-content-col">

				<div class="so-header-container">
					<div class="so-header-left">
						<h1 class="so-title">ใบสั่งเช่า (Rental Order)</h1>
						<div class="so-ref-info">
							<span class="so-ref-label">เลขที่อ้างอิง</span>
							<span class="so-ref-value"><?php echo $rentalIsEditMode ? so_saved_h($savedRental['ref_id']) : so_saved_h($so . $nextId); ?></span>
						</div>
					</div>
					<div class="so-header-right">
						<button type="button" class="btn-preview-so" onclick="rtOpenPreview();"><i class="fas fa-file-alt" aria-hidden="true"></i> Preview</button>
					</div>
				</div>
				<?php
				$latestRentalDocumentReasonTitleMap = array(
					'ส่งกลับ' => 'เหตุผลในการส่งกลับ',
					'Rejected' => 'เหตุผลที่ไม่อนุมัติ',
					'Cancelled' => 'เหตุผลในการยกเลิก'
				);
				$latestRentalDocumentReasonClassMap = array(
					'ส่งกลับ' => 'is-returned',
					'Rejected' => 'is-rejected',
					'Cancelled' => 'is-cancelled'
				);
				$latestRentalDocumentReasonStatus = trim((string)($latestRentalDocumentReason['status_doc'] ?? ''));
				$latestRentalDocumentReasonText = trim((string)($latestRentalDocumentReason['reason'] ?? ''));
				$latestRentalDocumentReasonTitle = $latestRentalDocumentReasonTitleMap[$latestRentalDocumentReasonStatus] ?? '';
				$latestRentalDocumentReasonClass = $latestRentalDocumentReasonClassMap[$latestRentalDocumentReasonStatus] ?? '';
				?>
				<?php if ($rentalIsEditMode && $latestRentalDocumentReasonTitle !== '' && $latestRentalDocumentReasonText !== '') { ?>
					<div class="rt-latest-reason-banner <?php echo so_saved_h($latestRentalDocumentReasonClass); ?>" role="status">
						<button type="button" class="rt-latest-reason-close" aria-label="ปิด" onclick="this.closest('.rt-latest-reason-banner').style.display='none';">&times;</button>
						<div class="rt-latest-reason-title"><?php echo so_saved_h($latestRentalDocumentReasonTitle); ?></div>
						<div class="rt-latest-reason-text"><?php echo nl2br(so_saved_h($latestRentalDocumentReasonText)); ?></div>
					</div>
				<?php } ?>
				<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $rentalIsEditMode ? so_saved_h($savedRental['ref_id']) : so_saved_h($so . $nextId); ?>">

				<?php
				date_default_timezone_set("Asia/Bangkok");

				$month = date('m');
				$day = date('d');
				$year = date('Y');

				$today = $year . '-' . $month . '-' . $day;


				?>

				<div class="so-tabs-container">
					<button type="button" class="so-tab-btn active" onclick="rtOpenDocTab('rt-doc-tab-1', this)">ข้อมูลเอกสาร</button>
					<button type="button" class="so-tab-btn" onclick="rtOpenDocTab('rt-doc-tab-2', this)">Admin</button>
				</div>

				<div id="rt-doc-tab-1" class="so-tab-content active">

					<!-- ===================== บริษัท / แผนก-เขตการขาย / ประเภทสินค้าเช่า ===================== -->
					<div class="so-card">
						<div class="so-grid-3">
							<div class="so-field-group">
								<label class="so-label">บริษัท<span style="color: #dc3545;">*</span></label>
								<div class="so-select-wrapper">
									<select name="type_doc" id="rt_type_doc_select" class="so-select">
										<option value="3" <?php echo (($savedRental['type_doc'] ?? '3') != '4') ? 'selected' : ''; ?>>AWL</option>
										<option value="4" <?php echo (($savedRental['type_doc'] ?? '3') == '4') ? 'selected' : ''; ?>>NBM</option>
									</select>
								</div>
							</div>

							<div class="so-field-group">
								<label class="so-label">แผนก/เขตการขาย</label>
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
									} else 	if ($_SESSION['code'] == 'SS2') {

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
									} else 	if ($_SESSION['code'] == 'SS3') {

									?>
										<select name="sale_code" id="sale_code" class="so-select" required>
											<option value="">**Please Select**</option>
											<?php

											$strSQL5 = "SELECT * FROM tb_team_ss3 where ckk_1='0' ORDER BY sale_code ASC";
											$objQuery5 = mysqli_query($com, $strSQL5);
											while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
											?>
												<option value="<?php echo $objResuut5["sale_code"]; ?>"><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
											<?php
											}
											?>
										</select>
									<?php
									} else 	if ($_SESSION['code'] == 'MK2') {

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
									} else 	if ($_SESSION['code'] == 'SUP_EN') {

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

											$strSQL5 = "SELECT * FROM tb_team_adm where ckk = '0' ORDER BY sale_code ASC";
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

							<div class="so-field-group">
								<label class="so-label">ประเภทสินค้าเช่า</label>
								<div class="so-select-wrapper">
									<select name="product_type_rental" class="so-select">
										<option value="">Select</option>
										<option value="สินค้าเตียง">สินค้าเตียง</option>
										<option value="สินค้าที่นอน">สินค้าที่นอน</option>
										<option value="สินค้าอื่นๆ">สินค้าอื่นๆ</option>
									</select>
								</div>
							</div>
						</div>

						<div class="so-field-group" style="flex-direction:row; gap:16px; margin-top:4px;">
							<?php if ($rentalIsEditMode && !empty($savedRental['ref_id'])) { ?>
								<a href="register_suphos.php?from_rental=<?php echo urlencode($savedRental['ref_id']); ?>&type=IV" class="so-toggle-pill-outline-custom"><span><img src="img/icons/money.png" alt="" style="width:16px;height:16px;object-fit:contain;"> ออกใบสั่งขาย</span></a>
								<a href="register_suphos.php?from_rental=<?php echo urlencode($savedRental['ref_id']); ?>&type=AI" class="so-toggle-pill-outline-custom"><span><img src="img/icons/check_border.png" alt="" style="width:16px;height:16px;object-fit:contain;"> เงินประกันสินค้า</span></a>
							<?php } else { ?>
								<button type="button" class="so-toggle-pill-outline-custom" onclick="alert('กรุณาบันทึกเอกสารก่อน จึงจะออกใบสั่งขายได้ (ฟังก์ชันนี้อยู่ในหน้าแก้ไขเอกสารหลังบันทึก)');"><span><img src="img/icons/money.png" alt="" style="width:16px;height:16px;object-fit:contain;"> ออกใบสั่งขาย</span></button>
								<button type="button" class="so-toggle-pill-outline-custom" onclick="alert('กรุณาบันทึกเอกสารก่อน จึงจะออกใบเงินประกันสินค้าได้ (ฟังก์ชันนี้อยู่ในหน้าแก้ไขเอกสารหลังบันทึก)');"><span><img src="img/icons/check_border.png" alt="" style="width:16px;height:16px;object-fit:contain;"> เงินประกันสินค้า</span></button>
							<?php } ?>
						</div>

						<div class="so-section-title-container" style="margin-top:20px;">
							<h2 class="so-section-title">ข้อมูลเอกสาร</h2>
							<hr class="so-divider">
						</div>

						<div class="so-grid-3">
							<div class="so-field-group">
								<label class="so-label" for="start_promis">วันเริ่มสัญญา<span style="color: #dc3545;">*</span></label>
								<input type="date" name="start_promis" id="start_promis" class="so-input">
							</div>
							<div class="so-field-group">
								<label class="so-label" for="count_m">ระยะเวลาเช่า (เดือน)<span style="color: #dc3545;">*</span></label>
								<input type="text" name="count_m" id="count_m" placeholder="ใส่เฉพาะตัวเลข" class="so-input">
							</div>
							<script>
								document.getElementById('count_m').addEventListener('input', function() {
									var months = parseFloat(this.value.replace(/,/g, ''));
									if (!isNaN(months) && months >= 3) {
										var deliveryInput = document.getElementById('rt_header_delivery');
										if (deliveryInput) deliveryInput.value = '0';
									}
								});
							</script>

							<div class="so-field-group">
								<label class="so-label">เลขที่สัญญา</label>
								<input type="text" id="promis_no" class="so-input"
									value="<?php echo $rentalIsEditMode ? so_saved_h($savedRental['promis_no'] ?? '') : ''; ?>"
									placeholder="<?php echo $rentalIsEditMode ? '' : 'ออกอัตโนมัติหลังบันทึก'; ?>"
									readonly disabled>
								<!-- input ด้านบนมี disabled จึงไม่ถูกส่งไปกับ POST เลย มิเรอร์ค่าไว้ที่ hidden
								     input นี้เพื่อให้พรีวิว (from_rental.php) อ่านเลขที่สัญญาได้ในโหมดแก้ไข -->
								<input type="hidden" name="promis_no" value="<?php echo $rentalIsEditMode ? so_saved_h($savedRental['promis_no'] ?? '') : ''; ?>">
							</div>
						</div>

						<div class="so-field-group">
							<label class="so-label">ทรัพย์ที่เช่า (ชื่อสินค้า)</label>
							<div class="so-input-wrapper">
								<input type="text" name="rental_item_name" id="rental_item_name" class="so-input" placeholder="ระบุชื่อทรัพย์ที่เช่า">
								<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('rental_item_name').value='';" aria-label="ล้างค่า"></button>
							</div>
						</div>

					</div>
				</div>

				<?php
				$adminInfoTab = [
					'tab_id' => 'rt-doc-tab-2',
					'title' => 'ข้อมูลเพิ่มเติม (Admin)',
					'rows' => [
						[
							['type' => 'inline_group', 'fields' => [
								['type' => 'text', 'name' => 'rt_admin_doc_no', 'label' => 'เลขที่เอกสาร', 'placeholder' => 'No.', 'value' => ($savedRental !== null) ? ($savedRental['iv_no'] ?? '') : ''],
								['type' => 'button', 'icon' => 'img/icons/doc.png', 'label' => 'Run เอกสาร', 'id' => 'btn_rt_run_doc_no', 'onclick' => 'rtRunDocumentNo();', 'variant' => 'purple'],
							]],
							['type' => 'date_th', 'name' => 'rt_admin_doc_date', 'label' => 'วันที่ออกเอกสาร', 'value' => ($savedRental !== null) ? so_saved_iso_date_input($savedRental['iv_date'] ?? '') : ''],
							['type' => 'text', 'name' => 'rt_admin_work_no', 'label' => 'เลขที่ลงงาน', 'icon' => 'img/icons/preview.png', 'icon_onclick' => 'rtRunJobNo();', 'icon_id' => 'btn_rt_run_job_no', 'value' => ($savedRental !== null) ? ($savedRental['job_no'] ?? '') : ''],
						],
						[
							['type' => 'button_field', 'button' => ['type' => 'button', 'label' => 'หนังสือสัญญา', 'id' => 'btn_rt_contract', 'onclick' => "rtOpenSavedRentalDocument('promis_from.php');"]],
							['type' => 'button_field', 'button' => ['type' => 'button', 'label' => 'ใบรับส่งสินค้า', 'id' => 'btn_rt_delivery', 'onclick' => "rtOpenSavedRentalDocument('delivery_from.php');"]],
							['type' => 'button_field', 'button' => ['type' => 'button', 'label' => 'ใบรับส่งสินค้า Preview', 'id' => 'btn_rt_delivery_preview', 'onclick' => "rtOpenSavedRentalDocument('delivery_from_pw.php');"]],
						],
						[
							['type' => 'button_field', 'button' => [
								'type' => 'button',
								'icon' => 'img/icons/circle_x.png',
								'label' => 'ยกเลิกเอกสาร',
								'id' => 'btn_rt_cancel_doc',
								'onclick' => 'rtToggleCancelDoc();',
								'variant' => 'danger',
								'active' => $rentalIsCancelChecked,
							]],
							['type' => 'text', 'name' => 'rt_admin_cancel_reason', 'id' => 'rt_admin_cancel_reason', 'label' => 'หมายเหตุการยกเลิก', 'placeholder' => 'ระบุเหตุผลการยกเลิก', 'icon' => 'fas fa-times', 'clearable' => true, 'span' => 2, 'disabled' => !$rentalIsCancelChecked, 'value' => ($savedRental !== null) ? ($savedRental['remark_cancel'] ?? '') : ''],
						],
					],
				];
				include __DIR__ . '/partials/admin_info_tab.php';
				unset($adminInfoTab);
				?>
				<input type="hidden" name="rt_admin_cancel_doc" id="rt_admin_cancel_doc" value="<?php echo $rentalIsCancelChecked ? '1' : '0'; ?>">
				<script>
					function rtToggleCancelDoc() {
						var cancelInput = document.getElementById('rt_admin_cancel_doc');
						var cancelBtn = document.getElementById('btn_rt_cancel_doc');
						var reasonInput = document.getElementById('rt_admin_cancel_reason');
						if (!cancelInput || !cancelBtn) return;

						var newActive = !(cancelBtn.classList.contains('active') || cancelInput.value === '1');

						cancelInput.value = newActive ? '1' : '0';
						cancelBtn.classList.toggle('active', newActive);

						if (reasonInput) {
							reasonInput.disabled = !newActive;
							if (newActive) {
								reasonInput.focus();
							} else {
								reasonInput.value = '';
							}
						}
					}

					function rtRunDocumentNo() {
						var companySelect = document.getElementById('rt_type_doc_select');
						var docNoInput = document.querySelector('input[name="rt_admin_doc_no"]');
						var docDateInput = document.querySelector('input[name="rt_admin_doc_date"]');
						var runButton = document.getElementById('btn_rt_run_doc_no');

						if (!companySelect || !docNoInput) {
							return;
						}

						if (docNoInput.value.trim() !== '') {
							if (!confirm('เอกสารนี้มีเลขที่ ' + docNoInput.value.trim() + ' อยู่แล้ว ต้องการออกเลขใหม่ทับหรือไม่?')) {
								return;
							}
						}

						var payload = new URLSearchParams();
						payload.append('company', companySelect.value);
						payload.append('doc_type', '7');
						payload.append('doc_date', docDateInput ? docDateInput.value : '');

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

					function rtRunJobNo() {
						var jobNoInput = document.querySelector('input[name="rt_admin_work_no"]');
						var refIdInput = document.querySelector('input[name="ref_id"]');
						var startPromisInput = document.querySelector('input[name="start_promis"]');
						var runIcon = document.getElementById('btn_rt_run_job_no');

						if (!jobNoInput) {
							return;
						}

						if (runIcon && runIcon.dataset.loading === '1') {
							return;
						}

						if (jobNoInput.value.trim() !== '') {
							if (!confirm('เอกสารนี้มีเลขที่ลงงาน ' + jobNoInput.value.trim() + ' อยู่แล้ว ต้องการออกเลขใหม่ทับหรือไม่?')) {
								return;
							}
						}

						var payload = new URLSearchParams();
						payload.append('ref_id', refIdInput ? refIdInput.value : '');
						payload.append('job_date', startPromisInput ? startPromisInput.value : '');

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

				<div class="so-card">
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
								<label class="so-label" for="rental_name">ชื่อผู้เช่า<span style="color: #dc3545;">*</span></label>
								<div class="so-input-wrapper">
									<input type='text' name="rental_name" id="rental_name" class="so-input" placeholder="ระบุชื่อผู้เช่า" style="padding-right: 32px;">
									<i class="fas fa-times so-clear-icon" onclick="document.getElementById('rental_name').value='';" aria-label="ล้างชื่อผู้เช่า"></i>
								</div>
							</div>
							<input type="hidden" name="register_date" id="register_date" value="<?php echo $today; ?>">
							<input type="hidden" name="rental_address" id="rental_address" value="">
						</div>

						<div class="so-customer-top-right">
							<div class="so-field-group" style="height: 100%; margin-bottom: 0;">
								<label class="so-label">ข้อมูลลูกค้า</label>
								<div class="customer-info-display-card">
									<div class="cidc-col">
										<div class="cidc-row">
											<div class="cidc-label">รหัสลูกค้า</div>
											<div class="cidc-value">
												<input type='text' name="rental_id" id="rental_id" class="cidc-value-input" readonly>
												<input type='hidden' name="h_rental_id" id="h_rental_id" readonly>
												<input type="hidden" id="bill_id">
												<input type="hidden" id="h_bill_id">
												<input type="hidden" id="h_credit_ckk_value" value="">
												<input type="hidden" id="h_customer_payment_mode" value="">
												<input type="hidden" id="credit_thb" value="">
											</div>
										</div>
										<div class="cidc-row">
											<div class="cidc-label">เบอร์โทรศัพท์</div>
											<div class="cidc-value">
												<span id="display_rental_tel" class="cidc-display-text"></span>
											</div>
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
											<div class="cidc-value">
												<span id="display_rental_name" class="cidc-display-text"></span>
											</div>
										</div>
										<div class="cidc-row">
											<div class="cidc-label">ประเภทลูกค้า</div>
											<div class="cidc-value">
												<span id="display_customer_typename" class="cidc-display-text"></span>
											</div>
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
					</div>

					<div class="so-grid-3-custom" style="margin-top: 18px; margin-bottom: 0;">
						<div class="so-field-group" style="margin-bottom: 0;">
							<label class="so-label" for="rental_tel">เบอร์โทรศัพท์<span style="color: #dc3545;">*</span></label>
							<div class="so-input-wrapper">
								<input type='text' name="rental_tel" id="rental_tel" class="so-input" placeholder="ระบุเบอร์โทรศัพท์" style="padding-right: 32px;">
								<i class="fas fa-times so-clear-icon" onclick="document.getElementById('rental_tel').value='';" aria-label="ล้างเบอร์โทรศัพท์"></i>
							</div>
						</div>
						<div class="so-field-group" style="margin-bottom: 0;">
							<label class="so-label" for="rental_addr_detail">ที่อยู่ผู้เช่า<span style="color: #dc3545;">*</span></label>
							<div class="so-input-wrapper">
								<input type="text" name="rental_addr_detail" id="rental_addr_detail" class="so-input" placeholder="ระบุที่อยู่ผู้เช่า" style="padding-right: 32px;">
								<i class="fas fa-times so-clear-icon" onclick="document.getElementById('rental_addr_detail').value='';" aria-label="ล้างที่อยู่ผู้เช่า"></i>
							</div>
						</div>
					</div>

					<div class="so-grid-3" style="margin-top: 18px;">
						<div class="so-field-group" style="margin-bottom: 0;">
							<label class="so-label" for="rental_province">จังหวัด<span style="color: #dc3545;">*</span></label>
							<div class="so-select-wrapper">
								<select name="rental_province" id="rental_province" class="so-select">
									<option value="">Select</option>
									<?php
									$strSQLRentalProvince = "select * from tb_province order by province_ID";
									$objQueryRentalProvince = mysqli_query($conn, $strSQLRentalProvince);
									if (!$objQueryRentalProvince) {
										echo "Failed to fetch to MySQL: " . mysqli_error($conn);
									}
									while ($objResultRentalProvince = mysqli_fetch_array($objQueryRentalProvince, MYSQLI_ASSOC)) {
									?>
										<option value="<?php echo $objResultRentalProvince['province_name']; ?>"><?php echo $objResultRentalProvince['province_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="so-field-group" style="margin-bottom: 0;">
							<label class="so-label" for="rental_district">เขต/อำเภอ<span style="color: #dc3545;">*</span></label>
							<div class="so-input-wrapper">
								<input type="text" name="rental_district" id="rental_district" class="so-input" placeholder="ระบุเขต/อำเภอ" style="padding-right: 32px;">
								<i class="fas fa-times so-clear-icon" onclick="document.getElementById('rental_district').value='';" aria-label="ล้างเขต/อำเภอ"></i>
							</div>
						</div>
						<div class="so-field-group" style="margin-bottom: 0;">
							<label class="so-label" for="rental_zipcode">รหัสไปรษณีย์<span style="color: #dc3545;">*</span></label>
							<div class="so-input-wrapper">
								<input type="text" name="rental_zipcode" id="rental_zipcode" class="so-input" placeholder="รหัสไปรษณีย์ 5 หลัก" maxlength="5" style="padding-right: 32px;">
								<i class="fas fa-times so-clear-icon" onclick="document.getElementById('rental_zipcode').value='';" aria-label="ล้างรหัสไปรษณีย์"></i>
							</div>
						</div>
					</div>

				</div>

				<!-- ===================== การชำระเงิน (payment/des_sale — sale_code/start_promis/count_m ย้าย
				     ไปการ์ด "ข้อมูลเอกสาร" ในแท็บด้านบนแล้ว) ===================== -->
				<div class="so-card" style="display: none;">
					<div class="so-section-title-container">
						<h2 class="so-section-title">การชำระเงิน</h2>
						<hr class="so-divider">
					</div>

					<!-- Radio Buttons Toggle for Credit vs Cash -->
					<div class="so-payment-modes">
						<label class="so-payment-radio-label" id="lbl-pay_mode_credit">
							<input type="radio" name="pay_mode" id="pay_mode_credit" value="credit" onclick="switchPaymentMode('credit')">
							<span>เครดิต</span>
						</label>
						<label class="so-payment-radio-label" id="lbl-pay_mode_cash">
							<input type="radio" name="pay_mode" id="pay_mode_cash" value="cash" onclick="switchPaymentMode('cash')">
							<span>ชำระเงินสด</span>
						</label>
					</div>

					<!-- Hidden actual select dropdown which is required by the form -->
					<select name="payment" id="payment" style="display:none;">
						<option value="">**Please Select Item**</option>
					</select>

					<!-- Row: Credit Fields (Only shown in Credit mode) -->
					<div class="so-grid-2" id="row-credit-fields" style="display: none;">
						<!-- จำนวนเครดิต (วัน) -->
						<div class="so-field-group">
							<label class="so-label" for="display_credit_days">จำนวนเครดิต (วัน)</label>
							<input type="text" id="display_credit_days" class="so-input" readonly placeholder="30">
						</div>

						<!-- ยอดเงินเครดิต -->
						<div class="so-field-group">
							<label class="so-label" for="display_credit_limit">ยอดเงินเครดิต</label>
							<input type="text" id="display_credit_limit" class="so-input" readonly placeholder="0.00">
						</div>
					</div>

					<!-- Row: Cash Fields (Only shown in Cash mode) -->
					<div class="so-grid-3" id="row-cash-fields" style="display: none; margin-bottom: 24px;">
						<!-- วิธีชำระเงิน -->
						<div class="so-field-group">
							<label class="so-label" for="payment_method">วิธีชำระเงิน</label>
							<div class="so-select-wrapper">
								<select id="payment_method" name="payment_method" class="so-select">
									<option value="0">เลือกวิธีชำระเงิน</option>
								</select>
							</div>
						</div>

						<!-- ช่องทางการชำระ -->
						<div class="so-field-group">
							<label class="so-label" for="payment_cash_select">ช่องทางการชำระ</label>
							<div class="so-select-wrapper">
								<select id="payment_cash_select" class="so-select" onchange="document.getElementById('payment').value = this.value;">
									<option value="">Select</option>
								</select>
							</div>
						</div>

						<!-- หลักฐานการโอนเงิน -->
						<div class="so-field-group">
							<label class="so-label" for="slip_upload">หลักฐานการโอนเงิน</label>
							<div class="so-file-upload">
								<label for="slip_upload" class="so-input" style="display: flex; justify-content: space-between; align-items: center; cursor: pointer; color: #333333;">
									<span id="file_name_display">Choose File</span>
									<i class="far fa-image" style="color: #333333; font-size: 18px;"></i>
								</label>
								<input type="file" id="slip_upload" style="display: none;" onchange="syncSlipUploadToSlip1(this)">
							</div>
						</div>
					</div>

					<!-- รายละเอียดการชำระเงิน -->
					<div class="so-field-group" style="margin-bottom: 24px;">
						<label class="so-label" for="des_sale">รายละเอียดการชำระเงิน</label>
						<div class="so-input-wrapper">
							<input type="text" name="des_sale" id="des_sale" class="so-input" placeholder="ระบุรายละเอียดเพิ่มเติม..." style="width: 100%; padding-right: 32px;">
							<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('des_sale').value=''"></i>
						</div>
					</div>
				</div>

				<!-- ===================== รายการสินค้า ===================== -->
				<div id="pd" class="city1">
					<div class="so-card">
						<div class="so-section-title-container">
							<h2 class="so-section-title">รายการสินค้า</h2>
							<hr class="so-divider">
						</div>

						<?php include('product_rentalawl.php'); ?>
					</div>
				</div>

				<!-- ===================== ข้อมูลการจัดส่ง / ค่าจัดส่ง ===================== -->
				<?php
				$deliveryTab = [
					'open_fn' => 'rtOpenDelTab',
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
						['type' => 'select', 'span' => 1, 'name' => 'time_range_ui', 'label' => 'เลือกช่วงเวลา', 'options' => [
							'' => 'เลือกช่วงเวลา',
							'morning' => 'ช่วงเช้า',
							'afternoon' => 'ช่วงบ่าย',
							'allday' => 'ทั้งวัน',
							'specific' => 'กำหนดเวลา',
						]],
						['type' => 'time', 'span' => 1, 'name' => 'start_time', 'label' => 'เวลาในการจัดส่ง', 'required' => true],
						['type' => 'text', 'span' => 4, 'name' => 'between_date', 'label' => 'วันที่ต้องการโดยประมาณ', 'clearable' => true],
						['type' => 'text', 'span' => 6, 'name' => 'status_comment', 'label' => 'หมายเหตุสถานะเพิ่มเติม', 'clearable' => true],
					],
					'toggle_buttons' => [
						['name' => 'call_customer', 'id' => 'call_customer', 'label' => 'ต้องการให้โทรแจ้ง'],
						['name' => 'no_money', 'id' => 'no_money', 'label' => 'ส่งสินค้าด้วยใบรับสินค้า (ไม่ระบุราคา)'],
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
				<input type="hidden" name="end_time" id="end_time" value="">
				<script>
					function rtOpenDelTab(tabId, element) {
						var contents = document.getElementsByClassName('so-del-tab-content');
						for (var i = 0; i < contents.length; i++) {
							contents[i].style.display = 'none';
						}
						var container = element.parentElement;
						var btns = container.getElementsByClassName('so-tab-btn');
						for (var i = 0; i < btns.length; i++) {
							btns[i].classList.remove('active');
						}
						var target = document.getElementById(tabId);
						if (target) target.style.display = 'block';
						element.classList.add('active');
					}

					function syncRentalDeliveryTimeRange() {
						var timeRange = document.getElementById('time_range_ui');
						var startTime = document.querySelector('input[name="start_time"]');
						var endTime = document.querySelector('input[name="end_time"]');
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
						}
					}

					document.addEventListener('DOMContentLoaded', function() {
						var timeRange = document.getElementById('time_range_ui');
						if (timeRange) {
							timeRange.addEventListener('change', syncRentalDeliveryTimeRange);
						}
					});
				</script>

				<!-- ===================== ที่อยู่ ===================== -->
				<div id="step-address">
					<div class="so-tabs-container" style="margin-top: 24px;">
						<button type="button" class="so-tab-btn active" onclick="rtOpenAddrTab('rt_addr_main', this)">ที่อยู่</button>
						<button type="button" class="so-tab-btn" onclick="rtOpenAddrTab('rt_addr_detail', this)">รายละเอียดที่อยู่</button>
					</div>
					<div class="so-card" style="padding: clamp(16px, 3vw, 24px);">

						<!-- TAB 1: ที่อยู่จัดส่ง -->
						<div id="rt_addr_main" class="so-addr-tab-content">
							<div class="so-section-title-container">
								<h3 class="so-section-title">ที่อยู่จัดส่ง</h3>
								<hr class="so-divider">
							</div>

							<div class="so-address-actions" style="display: flex; gap: 16px; margin-bottom: 24px;">
								<button type="button" class="so-address-action-btn so-address-action-btn-primary" style="background-color: #F4E8FF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;" onclick="openCustomerPopup();">
									<i class="fas fa-search"></i> ค้นหาที่อยู่
								</button>
								<button type="button" class="so-address-action-btn so-address-action-btn-secondary" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;" onclick="toggleSaveToCustomerDb(this)">
									<img src="img/icons/database.png" alt="database" style="width: 16px; height: 16px;"> เพิ่มลงฐานลูกค้า
								</button>
								<input type="hidden" name="save_to_customer_db" id="save_to_customer_db" value="0">
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
									<input type="text" class="so-input" id="address_merged_ui" placeholder="ที่อยู่ส่งสินค้า" required oninput="document.getElementById('address_1').value=this.value; document.getElementById('address_name').value=this.value;">
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

						<!-- TAB 2: รายละเอียดที่อยู่ -->
						<div id="rt_addr_detail" class="so-addr-tab-content" style="display:none;">
							<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">รายละเอียดที่อยู่</h3>
							<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

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
								<input name="addr_note" type="text" class="so-input" placeholder="รายละเอียดเพิ่มเติม" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
							</div>
						</div>

					</div>
				</div>
				<script>
					function rtOpenAddrTab(tabId, element) {
						var contents = document.getElementsByClassName('so-addr-tab-content');
						for (var i = 0; i < contents.length; i++) {
							contents[i].style.display = 'none';
						}
						var container = element.parentElement;
						var btns = container.getElementsByClassName('so-tab-btn');
						for (var i = 0; i < btns.length; i++) {
							btns[i].classList.remove('active');
						}
						var target = document.getElementById(tabId);
						if (target) target.style.display = 'block';
						element.classList.add('active');
					}
				</script>

				<!-- ===================== แท็บข้อมูลการเงิน & ประวัติงาน ===================== -->
				<div class="so-tabs-container" style="margin-top: 24px;">
					<button type="button" class="so-tab-btn active" onclick="rtOpenFinTab('rt-fin-1', this)">ข้อมูลการคืนเงิน</button>
					<button type="button" class="so-tab-btn" onclick="rtOpenFinTab('rt-fin-2', this)">รายละเอียดการชำระเงิน</button>
					<button type="button" class="so-tab-btn" onclick="rtOpenFinTab('rt-fin-3', this)">ข้อมูลการรับส่งสินค้า</button>
					<button type="button" class="so-tab-btn rt-return-doc-tab-btn" onclick="rtOpenFinTab('rt-fin-4', this)">การส่งกลับเอกสาร</button>
				</div>

				<div id="rt-fin-1" class="rt-fin-tab-content active">
					<div class="so-card">
						<div class="so-section-title-container">
							<h2 class="so-section-title">ข้อมูลการคืนเงิน</h2>
							<hr class="so-divider">
						</div>

						<div class="so-grid-3">
							<!-- 1. วิธีชำระเงินคืน -->
							<div class="so-field-group">
								<label class="so-label" for="bank_name">วิธีชำระเงินคืน <span style="color:red;">*</span></label>
								<div class="so-select-wrapper">
									<?php
									$rentalBankNames = [
										'ธนาคารกรุงเทพ',
										'ธนาคารกสิกรไทย',
										'ธนาคารไทยพาณิชย์',
										'ธนาคารกรุงไทย',
										'ธนาคารกรุงศรีอยุธยา',
										'ธนาคารทหารไทยธนชาต (ttb)',
										'ธนาคารเกียรตินาคินภัทร',
										'ธนาคารซีไอเอ็มบี ไทย',
										'ธนาคารยูโอบี',
										'ธนาคารออมสิน',
										'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร (ธ.ก.ส.)',
										'ธนาคารอาคารสงเคราะห์',
										'ธนาคารแลนด์ แอนด์ เฮ้าส์',
										'ธนาคารไทยเครดิต',
										'ธนาคารอิสลามแห่งประเทศไทย'
									];
									?>
									<select name="bank_name" id="bank_name" class="so-select" required>
										<option value="">เลือกวิธีชำระเงินคืน / ธนาคาร</option>
										<?php foreach ($rentalBankNames as $bName) { ?>
											<option value="<?php echo htmlspecialchars($bName, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($bName, ENT_QUOTES, 'UTF-8'); ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<!-- 2. เบอร์โทรศัพท์ / เลขที่บัญชี -->
							<div class="so-field-group">
								<label class="so-label" for="bank_no">เบอร์โทรศัพท์ / เลขที่บัญชี <span style="color:red;">*</span></label>
								<div class="so-input-wrapper">
									<input type="text" name="bank_no" id="bank_no" class="so-input" placeholder="ใส่เฉพาะตัวเลข" required>
									<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('bank_no').value='';" aria-label="ล้างเลขที่บัญชี"></button>
								</div>
							</div>

							<!-- 3. ชื่อบัญชี -->
							<div class="so-field-group">
								<label class="so-label" for="accbank_name">ชื่อบัญชี <span style="color:red;">*</span></label>
								<div class="so-input-wrapper">
									<input type="text" name="accbank_name" id="accbank_name" class="so-input" placeholder="กรอกชื่อบัญชี" required>
									<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('accbank_name').value='';" aria-label="ล้างชื่อบัญชี"></button>
								</div>
							</div>
						</div>

						<!-- แถวที่ 2: แนบไฟล์ Book Bank -->
						<div class="so-grid-3" style="margin-top: 16px;">
							<div class="so-field-group">
								<label class="so-label" for="bank_img">แนบไฟล์รูป Book Bank <span style="color:red;">*</span></label>
								<label class="so-file-picker" for="bank_img">
									<span class="so-file-picker-text" id="bank_img_text"><?php echo ($rentalIsEditMode && !empty($savedRental['bank_img'])) ? 'ไฟล์ที่แนบไว้: ' . so_saved_h($savedRental['bank_img']) : 'Choose File'; ?></span>
									<i class="far fa-image so-file-picker-icon"></i>
									<input type="file" name="bank_img" id="bank_img" class="so-file-picker-input" accept="image/*,application/pdf" <?php echo $rentalIsEditMode ? '' : 'required'; ?> onchange="showRentalBankImgName(this)">
								</label>
								<?php if ($rentalIsEditMode && !empty($savedRental['bank_img'])) {
									$rtBankImgFile = basename((string)$savedRental['bank_img']);
									$rtBankImgUrl = 'credit_no/' . rawurlencode($rtBankImgFile);
									?>
									<a class="rt-bank-img-view-link" href="<?php echo so_saved_h($rtBankImgUrl); ?>" target="_blank" rel="noopener">
										<i class="far fa-eye" aria-hidden="true"></i>
										<span>เปิดดูไฟล์</span>
									</a>
								<?php } ?>
								<!-- edit mode: ไม่อัปโหลดไฟล์ใหม่ = คงไฟล์เดิม (register_suprental_edit1.php อ่านค่านี้เมื่อ $_FILES['bank_img'] ว่าง) -->
								<input type="hidden" name="bank_img_existing" value="<?php echo ($savedRental !== null) ? so_saved_h($savedRental['bank_img'] ?? '') : ''; ?>">
							</div>
						</div>
					</div>
				</div>

				<script>
					function showRentalBankImgName(input) {
						var textEl = document.getElementById('bank_img_text');
						if (!textEl) return;
						if (input.files && input.files[0]) {
							textEl.textContent = input.files[0].name;
							textEl.classList.add('has-file');
						} else {
							textEl.textContent = 'Choose File';
							textEl.classList.remove('has-file');
						}
					}
				</script>

				<div id="rt-fin-2" class="rt-fin-tab-content">
					<div class="so-card">
						<div class="so-section-title-container">
							<h2 class="so-section-title">รายละเอียดการชำระเงิน</h2>
							<hr class="so-divider">
						</div>
						<div style="overflow-x:auto;">
							<table class="rt-status-table">
								<thead>
									<tr>
										<th>จำนวนครั้ง</th>
										<th>วันที่เริ่ม</th>
										<th>วันที่สิ้นสุด</th>
										<th>เลขที่ใบสั่งขาย</th>
										<th>ยอดรวม</th>
										<th>สถานะการชำระเงิน</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (!function_exists('renderRentalPaymentStatusIcon')) {
										function renderRentalPaymentStatusIcon($summaryCash)
										{
											$status = trim((string)$summaryCash);
											if ($status === 'สมบูรณ์') {
												return '<img src="img/icons/checkmark.png" alt="สมบูรณ์" title="สมบูรณ์" style="width:20px;height:20px;">';
											}
											if ($status === '') {
												return '<img src="img/icons/clock_delay.png" alt="รอดำเนินการ" title="รอดำเนินการ" style="width:20px;height:20px;">';
											}
											return so_saved_h($status);
										}
									}

									$rtFinRowsRendered = false;

									if ($savedRental !== null) {
										// แถว "0.เงินประกัน" — mirrors register_adminrental_edit.php:377-422
										$rtFinDepositRefAi = substr($savedRental['ref_ai'], 0, 2);
										if ($rtFinDepositRefAi === 'SO') {
											$rtFinDepositDocQuery = mysqli_query($conn, "SELECT iv_no FROM hos__so WHERE ref_id = '" . mysqli_real_escape_string($conn, $savedRental['ref_ai']) . "'");
											$rtFinDepositDocRow = $rtFinDepositDocQuery ? mysqli_fetch_assoc($rtFinDepositDocQuery) : null;
											$rtFinDepositDocNo = $rtFinDepositDocRow['iv_no'] ?? '';

											$rtFinDepositAmtQuery = mysqli_query($conn, "SELECT SUM(amount) AS amount FROM hos__subso WHERE ref_idd = '" . mysqli_real_escape_string($conn, $savedRental['ref_ai']) . "'");
											$rtFinDepositAmtRow = $rtFinDepositAmtQuery ? mysqli_fetch_assoc($rtFinDepositAmtQuery) : null;
											$rtFinDepositAmount = $rtFinDepositAmtRow['amount'] ?? 0;
										} else {
											$rtFinDepositDocQuery = mysqli_query($conn, "SELECT doc_no FROM so__main WHERE ref_id = '" . mysqli_real_escape_string($conn, $savedRental['ref_ai']) . "'");
											$rtFinDepositDocRow = $rtFinDepositDocQuery ? mysqli_fetch_assoc($rtFinDepositDocQuery) : null;
											$rtFinDepositDocNo = $rtFinDepositDocRow['doc_no'] ?? '';

											$rtFinDepositAmtQuery = mysqli_query($conn, "SELECT SUM(sum_amount) AS amount FROM so__submain WHERE ref_idd = '" . mysqli_real_escape_string($conn, $savedRental['ref_ai']) . "'");
											$rtFinDepositAmtRow = $rtFinDepositAmtQuery ? mysqli_fetch_assoc($rtFinDepositAmtQuery) : null;
											$rtFinDepositAmount = $rtFinDepositAmtRow['amount'] ?? 0;
										}

										$rtFinDepositRegisterQuery = mysqli_query($code, "SELECT summary_cash FROM tb_register_data WHERE ref_id = '" . mysqli_real_escape_string($conn, $savedRental['ref_ai']) . "' ORDER BY id_off DESC LIMIT 1");
										$rtFinDepositRegisterRow = $rtFinDepositRegisterQuery ? mysqli_fetch_assoc($rtFinDepositRegisterQuery) : null;

										$rtFinDepositCreditQuery = mysqli_query($conn, "SELECT date_tran FROM tb_credit_note WHERE iv_no_ref LIKE '" . mysqli_real_escape_string($conn, $rtFinDepositDocNo) . "' AND status_doc = 'Approve'");
										$rtFinDepositCreditRows = $rtFinDepositCreditQuery ? mysqli_num_rows($rtFinDepositCreditQuery) : 0;
										$rtFinDepositCreditRow = $rtFinDepositCreditRows > 0 ? mysqli_fetch_assoc($rtFinDepositCreditQuery) : null;

										$rtFinRowsRendered = true;
									?>
										<tr>
											<td>0.เงินประกัน</td>
											<td></td>
											<td></td>
											<td><?php echo so_saved_h($rtFinDepositDocNo); ?></td>
											<td><?php echo number_format((float)$rtFinDepositAmount, 2); ?></td>
											<td><?php
												if ($rtFinDepositCreditRows > 0 && $rtFinDepositCreditRow['date_tran'] !== '0000-00-00') {
													echo 'คืนเงินค้ำประกันเรียบร้อย วันที่ ' . so_saved_h(DateThai($rtFinDepositCreditRow['date_tran']));
												} else {
													echo renderRentalPaymentStatusIcon($rtFinDepositRegisterRow['summary_cash'] ?? '');
												}
												?></td>
										</tr>
										<?php

										// แถว "0.ลดหนี้" — mirrors register_adminrental_edit.php:424-460
										$rtFinRefAiTrimmed = str_replace(' ', '', $savedRental['ref_ai']);
										if ($rtFinRefAiTrimmed !== '') {
											$rtFinCreditNoteQuery = mysqli_query($conn, "SELECT * FROM tb_credit_note WHERE ref_id = '" . mysqli_real_escape_string($conn, $rtFinRefAiTrimmed) . "'");
											$rtFinCreditNoteRows = $rtFinCreditNoteQuery ? mysqli_num_rows($rtFinCreditNoteQuery) : 0;
											$rtFinCreditNoteRow = $rtFinCreditNoteRows > 0 ? mysqli_fetch_assoc($rtFinCreditNoteQuery) : null;

											if ($rtFinCreditNoteRows > 0) {
												$rtFinSubCreditQuery = mysqli_query($conn, "SELECT SUM(sum_amount) AS sum_amount FROM tb_subcredit WHERE ref_creditt = '" . mysqli_real_escape_string($conn, $rtFinCreditNoteRow['ref_credit']) . "'");
												$rtFinSubCreditRow = $rtFinSubCreditQuery ? mysqli_fetch_assoc($rtFinSubCreditQuery) : null;
												$rtFinSubCreditAmount = $rtFinSubCreditRow['sum_amount'] ?? 0;
										?>
												<tr>
													<td>0.ลดหนี้</td>
													<td><?php echo so_saved_h(DateThai($rtFinCreditNoteRow['date_credit'])); ?></td>
													<td></td>
													<td>
														<a href="register_credit_adm.php?ref_credit=<?php echo urlencode($rtFinCreditNoteRow['ref_credit']); ?>" target="_blank"><?php echo so_saved_h($rtFinCreditNoteRow['credit_no']); ?></a>
													</td>
													<td><?php echo number_format((float)$rtFinSubCreditAmount, 2); ?></td>
													<td><?php
														if ($rtFinDepositCreditRows > 0 && $rtFinDepositCreditRow['date_tran'] !== '0000-00-00') {
															echo 'คืนเงินค้ำประกันเรียบร้อย วันที่ ' . so_saved_h(DateThai($rtFinDepositCreditRow['date_tran']));
														}
														?></td>
												</tr>
											<?php
											}
										}

										// รายการชำระตามรอบ — mirrors register_adminrental_edit.php:462-530
										$rtFinInstallmentQuery = mysqli_query($conn, "SELECT * FROM hos__rental_runiv WHERE ref_idren = '" . mysqli_real_escape_string($conn, $savedRental['ref_id']) . "' AND ref_idiv != '' ORDER BY date_runiv DESC");
										$rtFinInstallmentCount = $rtFinInstallmentQuery ? mysqli_num_rows($rtFinInstallmentQuery) : 0;
										$rtFinInstallmentNo = $rtFinInstallmentCount + 1;

										if ($rtFinInstallmentQuery) {
											while ($rtFinInstallmentRow = mysqli_fetch_assoc($rtFinInstallmentQuery)) {
												$rtFinInstallmentRefIv = substr($rtFinInstallmentRow['ref_idiv'], 0, 2);
												if ($rtFinInstallmentRefIv === 'SO') {
													$rtFinInstDocQuery = mysqli_query($conn, "SELECT iv_no FROM hos__so WHERE ref_id = '" . mysqli_real_escape_string($conn, $rtFinInstallmentRow['ref_idiv']) . "'");
													$rtFinInstDocRow = $rtFinInstDocQuery ? mysqli_fetch_assoc($rtFinInstDocQuery) : null;
													$rtFinInstDocNo = $rtFinInstDocRow['iv_no'] ?? '';

													$rtFinInstAmtQuery = mysqli_query($conn, "SELECT SUM(amount) AS amount FROM hos__subso WHERE ref_idd = '" . mysqli_real_escape_string($conn, $rtFinInstallmentRow['ref_idiv']) . "'");
													$rtFinInstAmtRow = $rtFinInstAmtQuery ? mysqli_fetch_assoc($rtFinInstAmtQuery) : null;
													$rtFinInstAmount = $rtFinInstAmtRow['amount'] ?? 0;

													$rtFinInstLink = 'register_adminhos_edit.php?ref_id=' . urlencode($rtFinInstallmentRow['ref_idiv']);
												} else {
													$rtFinInstDocQuery = mysqli_query($conn, "SELECT doc_no FROM so__main WHERE ref_id = '" . mysqli_real_escape_string($conn, $rtFinInstallmentRow['ref_idiv']) . "'");
													$rtFinInstDocRow = $rtFinInstDocQuery ? mysqli_fetch_assoc($rtFinInstDocQuery) : null;
													$rtFinInstDocNo = $rtFinInstDocRow['doc_no'] ?? '';

													$rtFinInstAmtQuery = mysqli_query($conn, "SELECT SUM(sum_amount) AS amount FROM so__submain WHERE ref_idd = '" . mysqli_real_escape_string($conn, $rtFinInstallmentRow['ref_idiv']) . "'");
													$rtFinInstAmtRow = $rtFinInstAmtQuery ? mysqli_fetch_assoc($rtFinInstAmtQuery) : null;
													$rtFinInstAmount = $rtFinInstAmtRow['amount'] ?? 0;

													$rtFinInstLink = 'register_admin_edit.php?ref_id=' . urlencode($rtFinInstallmentRow['ref_idiv']);
												}

												$rtFinInstRegisterQuery = mysqli_query($code, "SELECT summary_cash FROM tb_register_data WHERE ref_id = '" . mysqli_real_escape_string($conn, $rtFinInstallmentRow['ref_idiv']) . "' ORDER BY id_off DESC LIMIT 1");
												$rtFinInstRegisterRow = $rtFinInstRegisterQuery ? mysqli_fetch_assoc($rtFinInstRegisterQuery) : null;
											?>
												<tr>
													<td>ชำระครั้งที่ <?php echo (int)$rtFinInstallmentNo; ?></td>
													<td><?php echo so_saved_h(DateThai($rtFinInstallmentRow['date_runiv'])); ?></td>
													<td><?php echo so_saved_h(DateThai($rtFinInstallmentRow['end_date'])); ?></td>
													<td><a href="<?php echo $rtFinInstLink; ?>" target="_blank"><?php echo so_saved_h($rtFinInstDocNo); ?></a></td>
													<td><?php echo number_format((float)$rtFinInstAmount, 2); ?></td>
													<td><?php echo renderRentalPaymentStatusIcon($rtFinInstRegisterRow['summary_cash'] ?? ''); ?></td>
												</tr>
										<?php
												$rtFinInstallmentNo--;
											}
										}

										// แถว "ชำระครั้งที่ 1" จาก ref_iv/start_promis/end_promis ของสัญญาหลัก — mirrors register_adminrental_edit.php:532-586
										$rtFinFinalRefIv = substr($savedRental['ref_iv'], 0, 2);
										if ($rtFinFinalRefIv === 'SO') {
											$rtFinFinalDocQuery = mysqli_query($conn, "SELECT iv_no FROM hos__so WHERE ref_id = '" . mysqli_real_escape_string($conn, $savedRental['ref_iv']) . "'");
											$rtFinFinalDocRow = $rtFinFinalDocQuery ? mysqli_fetch_assoc($rtFinFinalDocQuery) : null;
											$rtFinFinalDocNo = $rtFinFinalDocRow['iv_no'] ?? '';

											$rtFinFinalAmtQuery = mysqli_query($conn, "SELECT SUM(amount) AS amount FROM hos__subso WHERE ref_idd = '" . mysqli_real_escape_string($conn, $savedRental['ref_iv']) . "'");
											$rtFinFinalAmtRow = $rtFinFinalAmtQuery ? mysqli_fetch_assoc($rtFinFinalAmtQuery) : null;
											$rtFinFinalAmount = $rtFinFinalAmtRow['amount'] ?? 0;

											$rtFinFinalLink = 'register_adminhos_edit.php?ref_id=' . urlencode($savedRental['ref_iv']);
										} else {
											$rtFinFinalDocQuery = mysqli_query($conn, "SELECT doc_no FROM so__main WHERE ref_id = '" . mysqli_real_escape_string($conn, $savedRental['ref_iv']) . "'");
											$rtFinFinalDocRow = $rtFinFinalDocQuery ? mysqli_fetch_assoc($rtFinFinalDocQuery) : null;
											$rtFinFinalDocNo = $rtFinFinalDocRow['doc_no'] ?? '';

											$rtFinFinalAmtQuery = mysqli_query($conn, "SELECT SUM(sum_amount) AS amount FROM so__submain WHERE ref_idd = '" . mysqli_real_escape_string($conn, $savedRental['ref_iv']) . "'");
											$rtFinFinalAmtRow = $rtFinFinalAmtQuery ? mysqli_fetch_assoc($rtFinFinalAmtQuery) : null;
											$rtFinFinalAmount = $rtFinFinalAmtRow['amount'] ?? 0;

											$rtFinFinalLink = 'register_admin_edit.php?ref_id=' . urlencode($savedRental['ref_iv']);
										}

										$rtFinFinalRegisterQuery = mysqli_query($code, "SELECT summary_cash FROM tb_register_data WHERE ref_id = '" . mysqli_real_escape_string($conn, $savedRental['ref_iv']) . "' ORDER BY id_off DESC LIMIT 1");
										$rtFinFinalRegisterRow = $rtFinFinalRegisterQuery ? mysqli_fetch_assoc($rtFinFinalRegisterQuery) : null;
										?>
										<tr>
											<td>ชำระครั้งที่ 1</td>
											<td><?php echo so_saved_h(DateThai($savedRental['start_promis'])); ?></td>
											<td><?php echo so_saved_h(DateThai($savedRental['end_promis'])); ?></td>
											<td><a href="<?php echo $rtFinFinalLink; ?>" target="_blank"><?php echo so_saved_h($rtFinFinalDocNo); ?></a></td>
											<td><?php echo number_format((float)$rtFinFinalAmount, 2); ?></td>
											<td><?php echo renderRentalPaymentStatusIcon($rtFinFinalRegisterRow['summary_cash'] ?? ''); ?></td>
										</tr>
									<?php
									}

									if (!$rtFinRowsRendered) {
									?>
										<tr class="rt-status-empty">
											<td colspan="6">ยังไม่มีรายการชำระเงิน</td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php
				if (!function_exists('renderJobSummaryStatusPill')) {
					function renderJobSummaryStatusPill($statusText)
					{
						$status = trim((string)$statusText);
						if ($status === '') return '-';

						$icon = '';
						$class = 'is-muted';

						if (preg_match('/(ไม่สมบูรณ์|ไม่สำเร็จ|ยกเลิก|ตีกลับ|ปฏิเสธ|มีปัญหา|ผิดพลาด)/u', $status)) {
							$class = 'is-danger';
							$icon = '<i class="fas fa-times-circle" style="font-size: 11px; margin-right: 4px;"></i>';
						} elseif (preg_match('/(สมบูรณ์|สำเร็จ|เรียบร้อย|ผ่าน)/u', $status)) {
							$class = 'is-success';
							$icon = '<i class="fas fa-check-circle" style="font-size: 11px; margin-right: 4px;"></i>';
						} elseif (preg_match('/(รอ|รอช่าง|รอดำเนินการ|รอชำระ|รอนัดหมาย)/u', $status)) {
							$class = 'is-pending';
							$icon = '<i class="fas fa-clock" style="font-size: 11px; margin-right: 4px;"></i>';
						} elseif (preg_match('/(กำลัง|ระหว่าง|ดำเนินงาน|กำลังส่ง|จัดส่ง)/u', $status)) {
							$class = 'is-info';
							$icon = '<i class="fas fa-spinner fa-spin" style="font-size: 11px; margin-right: 4px;"></i>';
						}

						return '<span class="so-status-pill ' . $class . '">' . $icon . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . '</span>';
					}
				}
				?>

				<div id="rt-fin-3" class="rt-fin-tab-content">
					<div class="so-card">
						<div class="so-section-title-container">
							<h2 class="so-section-title">ข้อมูลการรับส่งสินค้า</h2>
							<hr class="so-divider">
						</div>
						<div style="overflow-x:auto;">
							<table class="rt-status-table">
								<thead>
									<tr>
										<th>เลขที่ลงงาน</th>
										<th>สถานะ</th>
										<th>วันที่เริ่ม</th>
										<th>ผู้ดำเนินงาน</th>
										<th>สรุปงาน</th>
										<th>หมายเหตุ</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (!function_exists('renderRentalStockCompleteText')) {
										function renderRentalStockCompleteText($stockComplete)
										{
											$status = trim((string)$stockComplete);
											if ($status === '1') return 'สมบูรณ์';
											if ($status === '2') return 'ไม่สมบูรณ์';
											return 'รอสต็อกตรวจสอบ';
										}
									}

									$rtShipRowsRendered = false;

									if ($savedRental !== null) {
										if (!empty($savedRental['job_no'])) {
											$rtShipQuery = mysqli_query($com1, "SELECT * FROM tb_register_data WHERE running = '" . mysqli_real_escape_string($conn, $savedRental['job_no']) . "'");
											$rtShipRow = $rtShipQuery ? mysqli_fetch_assoc($rtShipQuery) : null;
											if ($rtShipRow) {
												$rtShipRowsRendered = true;
									?>
												<tr>
													<td><a href="https://cs.allwellcenter.com/7112018.php?running=<?php echo urlencode($rtShipRow['running']); ?>" target="_blank"><?php echo so_saved_h($rtShipRow['running']); ?></a></td>
													<td>ส่งสินค้า</td>
													<td><?php echo so_saved_h(DateThai($rtShipRow['start_date'])); ?></td>
													<td><?php echo so_saved_h($rtShipRow['employee_send']); ?></td>
													<td><?php echo renderJobSummaryStatusPill($rtShipRow['summary_cs']); ?></td>
													<td><?php echo so_saved_h($rtShipRow['description_cs']); ?></td>
												</tr>
											<?php
											}
										}

										if (!empty($savedRental['job_idreturn'])) {
											$rtReceiveQuery = mysqli_query($com1, "SELECT * FROM tb_register_data WHERE running = '" . mysqli_real_escape_string($conn, $savedRental['job_idreturn']) . "'");
											$rtReceiveRow = $rtReceiveQuery ? mysqli_fetch_assoc($rtReceiveQuery) : null;
											if ($rtReceiveRow) {
												$rtShipRowsRendered = true;
											?>
												<tr>
													<td><a href="https://cs.allwellcenter.com/7112018.php?running=<?php echo urlencode($rtReceiveRow['running']); ?>" target="_blank"><?php echo so_saved_h($rtReceiveRow['running']); ?></a></td>
													<td>รับสินค้า</td>
													<td><?php echo so_saved_h(DateThai($rtReceiveRow['start_date'])); ?></td>
													<td><?php echo so_saved_h($rtReceiveRow['employee_send']); ?></td>
													<td><?php echo renderJobSummaryStatusPill($rtReceiveRow['summary_cs']); ?></td>
													<td><?php echo so_saved_h($rtReceiveRow['description_cs']); ?></td>
												</tr>
											<?php
											}
										}

										if (!empty($savedRental['ref_rt'])) {
											$rtReturnQuery = mysqli_query($conn, "SELECT * FROM hos__receive WHERE ref_id = '" . mysqli_real_escape_string($conn, $savedRental['ref_rt']) . "'");
											$rtReturnRow = $rtReturnQuery ? mysqli_fetch_assoc($rtReturnQuery) : null;
											if ($rtReturnRow) {
												$rtShipRowsRendered = true;
											?>
												<tr>
													<td><a href="rister_clearbrpn_stedit.php?ref_id=<?php echo urlencode($rtReturnRow['ref_id']); ?>" target="_blank"><?php echo so_saved_h($rtReturnRow['ref_id']); ?></a></td>
													<td>คืนสินค้า</td>
													<td><?php echo so_saved_h(DateThai($rtReturnRow['stock_date'])); ?></td>
													<td><?php echo so_saved_h($rtReturnRow['stock_name']); ?></td>
													<td><?php echo renderJobSummaryStatusPill(renderRentalStockCompleteText($rtReturnRow['stock_complete'])); ?></td>
													<td><?php echo so_saved_h($rtReturnRow['edit_des']); ?></td>
												</tr>
										<?php
											}
										}
									}

									if (!$rtShipRowsRendered) {
										?>
										<tr class="rt-status-empty">
											<td colspan="6">ยังไม่มีรายการรับส่งสินค้า</td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>


				<?php
				if (!function_exists('renderRentalDocumentReturnStatus')) {
					function renderRentalDocumentReturnStatus($statusDoc)
					{
						$statusMap = [
							'ส่งกลับ' => 'ส่งกลับ',
							'Rejected' => 'ไม่อนุมัติ',
							'Cancelled' => 'ยกเลิกเอกสาร',
						];

						return $statusMap[$statusDoc] ?? $statusDoc;
					}
				}

				if (!function_exists('renderRentalDocumentReturnStatusClass')) {
					function renderRentalDocumentReturnStatusClass($statusDoc)
					{
						$statusClassMap = [
							'ส่งกลับ' => 'is-returned',
							'Rejected' => 'is-rejected',
							'Cancelled' => 'is-cancelled',
						];

						return $statusClassMap[$statusDoc] ?? 'is-cancelled';
					}
				}

				if (!function_exists('formatRentalDocumentLogDateTime')) {
					function formatRentalDocumentLogDateTime($createdAt)
					{
						$createdAt = trim((string)$createdAt);
						if ($createdAt === '') return '';

						$timestamp = strtotime($createdAt);
						if ($timestamp === false) return '';

						return date('d-m-Y H:i', $timestamp);
					}
				}
				?>

				<div id="rt-fin-4" class="rt-fin-tab-content">
					<div class="so-card">
						<div style="overflow-x:auto;">
							<table class="rt-status-table rt-document-log-table">
								<thead>
									<tr>
										<th>สถานะ</th>
										<th>เหตุผลการส่งกลับ</th>
										<th>ผู้ส่งกลับ</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$rtDocumentLogRowsRendered = false;

									if ($rentalIsEditMode && !empty($savedRental['ref_id'])) {
										$rtDocumentLogRefId = mysqli_real_escape_string($conn, $savedRental['ref_id']);
										$rtDocumentLogQuery = mysqli_query($conn, "SELECT status_doc, reason, user_name, created_at
											FROM tb_document_status_log
											WHERE ref_id = '" . $rtDocumentLogRefId . "'
												AND status_doc IN ('ส่งกลับ', 'Rejected', 'Cancelled')
											ORDER BY created_at DESC, id DESC");

										if ($rtDocumentLogQuery) {
											while ($rtDocumentLogRow = mysqli_fetch_assoc($rtDocumentLogQuery)) {
												$rtDocumentLogRowsRendered = true;
												$rtDocumentLogUserName = trim((string)($rtDocumentLogRow['user_name'] ?? ''));
												$rtDocumentLogDateTime = formatRentalDocumentLogDateTime($rtDocumentLogRow['created_at'] ?? '');
									?>
												<tr>
													<td class="rt-document-log-status-cell">
														<span class="rt-document-status-pill <?php echo so_saved_h(renderRentalDocumentReturnStatusClass($rtDocumentLogRow['status_doc'] ?? '')); ?>">
															<?php echo so_saved_h(renderRentalDocumentReturnStatus($rtDocumentLogRow['status_doc'] ?? '')); ?>
														</span>
													</td>
													<td class="rt-document-log-reason-cell"><?php echo so_saved_h($rtDocumentLogRow['reason'] ?? ''); ?></td>
													<td class="rt-document-log-user-cell">
														<div><?php echo so_saved_h($rtDocumentLogUserName !== '' ? $rtDocumentLogUserName : '-'); ?></div>
														<?php if ($rtDocumentLogDateTime !== '') { ?>
															<div class="rt-document-log-time"><?php echo so_saved_h($rtDocumentLogDateTime); ?></div>
														<?php } ?>
													</td>
												</tr>
										<?php
											}
										}
									}

									if (!$rtDocumentLogRowsRendered) {
										?>
										<tr class="rt-status-empty">
											<td colspan="3">ยังไม่มีรายการส่งกลับเอกสาร</td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>


			</div>
		</div>

		<?php
		$rtStatusDoc = $savedRental['status_doc'] ?? '';
		$rtSendSup = $savedRental['send_sup'] ?? '0';
		$rtIsClosed = in_array($rtStatusDoc, ['Approve', 'ยกเลิก', 'Rejected'], true);
		$rtHideSubmit = $rentalIsEditMode && ((string)$rtSendSup === '1' || $rtIsClosed);
		$rtIsSaleUser = (($_SESSION['type_login'] ?? '') === 'Sale');
		$rtCanShowApproveBar = $rentalIsEditMode && !$rtIsSaleUser && ($rtStatusDoc === 'Request');
		$rtHideUpdate = $rtIsClosed || $rtCanShowApproveBar;
		?>
		<div class="so-sticky-actions">
			<div class="so-sticky-actions-inner">
				<?php if ($rtCanShowApproveBar): ?>
					<input type="hidden" name="approve_action" id="rt_approve_action" value="">
					<input type="hidden" name="rt_approve_reason" id="rt_approve_reason" value="">
					<div class="so-approve-actions">
						<button type="button" class="so-overflow-menu-trigger" id="btn_rt_approve_overflow" onclick="toggleRtApproveOverflowMenu()">
							<i class="fas fa-ellipsis-v"></i>
						</button>
						<div id="rtApproveOverflowMenu" class="so-overflow-menu">
							<button type="button" onclick="rtRunApproveAction('return', true)"><img src="img/icons/send_back.png" alt="" style="width: 20px; height: 20px;"> ส่งกลับ</button>
							<button type="button" class="so-menu-danger" onclick="rtRunApproveAction('reject', true)"><img src="img/icons/reject.png" alt="" style="width: 20px; height: 20px;"> ไม่อนุมัติ</button>
							<button type="button" onclick="triggerCancelDocFromRtApproveMenu()"><img src="img/icons/cancel_document.png" alt="" style="width: 20px; height: 20px;"> ยกเลิกเอกสาร</button>
						</div>
						<button type="button" class="btn-so-approve" onclick="rtRunApproveAction('approve', false)"><img src="img/icons/approval_status.png" alt="" style="width: 28px; height: 28px;"> อนุมัติ</button>
						<button type="button" name="save_draft" class="btn-so-draft" onclick="rtSaveDraft();"><img src="img/icons/update_document.png" alt="" style="width: 20px; height: 20px;"> Update</button>
					</div>
				<?php endif; ?>
				<?php if (!$rtHideSubmit): ?>
					<button type="submit" name="submit" id="btn_submit_form" value="submit" class="btn-so-submit"><i class="fas fa-paper-plane"></i> Submit</button>
				<?php endif; ?>
				<?php if (!$rtHideUpdate): ?>
					<button type="button" name="save_draft" id="btn_save_draft" class="btn-so-draft" onclick="rtSaveDraft();"><i class="far fa-save"></i> <?php echo $rentalIsEditMode ? 'Update' : 'Save Draft'; ?></button>
				<?php endif; ?>
				<button type="button" name="cancel_edit" class="btn-so-cancel-nav" onclick="goMainSupRental();">ย้อนกลับ</button>
			</div>
		</div>
	</form>

	<script>
		function toggleRtApproveOverflowMenu() {
			var menu = document.getElementById('rtApproveOverflowMenu');
			if (!menu) return;
			menu.style.display = (menu.style.display === 'none' || !menu.style.display) ? 'block' : 'none';
		}

		document.addEventListener('click', function(e) {
			var menu = document.getElementById('rtApproveOverflowMenu');
			var trigger = document.getElementById('btn_rt_approve_overflow');
			if (!menu || menu.style.display === 'none' || !menu.style.display) return;
			if (e.target === trigger || (trigger && trigger.contains(e.target))) return;
			if (!menu.contains(e.target)) menu.style.display = 'none';
		});

		function rtOpenReasonPopup(opts) {
			var refInput = document.querySelector('input[name="ref_id"]');
			var refId = refInput ? refInput.value.trim() : '';

			Swal.fire({
				title: opts.title,
				html: '<p class="rt-reason-subtitle">' + opts.subtitleText + ' "' + refId + '"</p>' +
					'<label class="rt-reason-label">' + opts.label + '<span class="rt-reason-required">*</span></label>',
				input: 'textarea',
				inputPlaceholder: opts.placeholder || '',
				iconHtml: '<div class="rt-reason-icon-circle" style="background:' + opts.iconBg + '"><img src="' + opts.iconSrc + '" alt="" style="width: 36px; height: 36px;"></div>',
				showCancelButton: true,
				showCloseButton: true,
				reverseButtons: false,
				confirmButtonText: 'ตกลง',
				cancelButtonText: 'ยกเลิก',
				buttonsStyling: false,
				customClass: {
					popup: 'figma-delete-popup rt-reason-popup',
					title: 'figma-delete-title rt-reason-title',
					htmlContainer: 'figma-delete-html rt-reason-html',
					confirmButton: 'figma-delete-confirm-btn rt-reason-confirm-btn ' + (opts.confirmBtnClass || ''),
					cancelButton: 'figma-delete-cancel-btn rt-reason-cancel-btn',
					actions: 'figma-delete-actions rt-reason-actions',
					icon: 'figma-delete-icon rt-reason-icon',
					input: 'rt-reason-textarea',
					closeButton: 'rt-reason-close-btn'
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

		function rtRunApproveAction(action, skipValidation) {
			var field = document.getElementById('rt_approve_action');
			if (field) field.value = action;

			if (skipValidation) {
				if (rtSubmitting) return;

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

				rtOpenReasonPopup(Object.assign({}, reasonConfig, {
					onConfirm: function(reason) {
						var reasonField = document.getElementById('rt_approve_reason');
						if (reasonField) reasonField.value = reason;
						rtSubmitting = true; // กันกดซ้ำ (เส้นทางนี้ไม่ผ่าน fncSubmit จึงต้องตั้งธงเอง)
						HTMLFormElement.prototype.submit.call(rtEnsureSubmitMarker());
					}
				}));
				return;
			}

			fncSubmit();
			// fncSubmit() คืนค่า false ทั้งกรณีสำเร็จและ validation ไม่ผ่าน จึงดูจากธง rtSubmitting แทน
			if (!rtSubmitting && field) field.value = '';
		}

		function triggerCancelDocFromRtApproveMenu() {
			if (rtSubmitting) return;

			rtOpenReasonPopup({
				title: 'ยกเลิกเอกสารนี้ ?',
				subtitleText: 'ต้องการยกเลิกเอกสารเลขที่',
				label: 'ระบุเหตุผลในการยกเลิก',
				placeholder: 'ระบุเหตุผลในการยกเลิก',
				iconBg: '#F4F5F7',
				iconSrc: 'img/icons/cancel_document.png',
				onConfirm: function(reason) {
					var cancelInput = document.getElementById('rt_admin_cancel_doc');
					var cancelBtn = document.getElementById('btn_rt_cancel_doc');
					if (cancelInput && !(cancelBtn && cancelBtn.classList.contains('active')) && cancelInput.value !== '1') {
						rtToggleCancelDoc();
					}

					var reasonInput = document.getElementById('rt_admin_cancel_reason');
					if (reasonInput) reasonInput.value = reason; // sync ค่าเข้าแท็บ admin ให้ตรงกับ popup

					var reasonField = document.getElementById('rt_approve_reason');
					if (reasonField) reasonField.value = reason;

					rtSubmitting = true;
					HTMLFormElement.prototype.submit.call(rtEnsureSubmitMarker());
				}
			});
		}
	</script>

	<?php if (count($rentalPrefill) > 0) { ?>
		<!-- เติมค่ากลับเข้าฟอร์มใน edit mode — ตัวเดียวจบทั้งฟอร์ม (pattern เดียวกับ register_supchange.php) -->
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var rentalPrefill = <?php echo json_encode($rentalPrefill, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
				var rentalForm = document.forms['frmMain'];
				if (!rentalForm) return;

				Object.keys(rentalPrefill).forEach(function(fieldName) {
					var value = rentalPrefill[fieldName];
					if (value === null || value === undefined) return;
					value = String(value);

					var elements = rentalForm.querySelectorAll('[name="' + fieldName + '"]');
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

				// address_merged_ui ไม่มี name= (id-only, JS-mirror ไปยัง address_1/address_name) จึง generic loop ข้างบนไม่จับ
				var addressMergedEl = document.getElementById('address_merged_ui');
				if (addressMergedEl && rentalPrefill.address_merged_ui !== undefined) {
					addressMergedEl.value = rentalPrefill.address_merged_ui || '';
				}

				// ให้ UI ที่ผูกกับ toggle pill/สไตล์ตาม checked อัปเดตตาม (onchange ทำสไตล์ ไม่ใช่ CSS :checked)
				['is_high_roof', 'call_customer', 'no_money', 'send_cs'].forEach(function(name) {
					var el = document.querySelector('[name="' + name + '"]');
					if (el) el.dispatchEvent(new Event('change', {
						bubbles: true
					}));
				});
			});
		</script>
	<?php } ?>

	<?php if ($savedRentalCustomerDisplay !== null) { ?>
		<!-- restore customer-info-display-card (name/tel/type/status/credit/VIP) หลัง submit/reload — tb_customer ไม่ได้อยู่ใน $rentalPrefill loop -->
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var savedCustomerDisplay = <?php echo json_encode($savedRentalCustomerDisplay, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

				var billIdInput = document.getElementById('bill_id');
				if (billIdInput) billIdInput.value = savedCustomerDisplay.customer_id || '';
				var hBillIdInput = document.getElementById('h_bill_id');
				if (hBillIdInput) hBillIdInput.value = savedCustomerDisplay.customer_id || '';

				setElementText('display_rental_name', savedCustomerDisplay.customer_name || savedCustomerDisplay.bill_name);
				setElementText('display_rental_tel', savedCustomerDisplay.cus_tel || savedCustomerDisplay.bill_tel);
				setElementText('display_customer_typename', savedCustomerDisplay.type_name);
				setElementText('display_mode_name', savedCustomerDisplay.status_cus);
				setCreditThbDisplay(savedCustomerDisplay.credit_thb);

				var vipIcon = document.getElementById('display_vip_icon');
				if (vipIcon) vipIcon.style.display = (String(savedCustomerDisplay.vip_ckk) === '1') ? '' : 'none';

				var cusCkk = String(savedCustomerDisplay.credit_ckk || '').trim();
				var hCreditCkk = document.getElementById('h_credit_ckk_value');
				if (hCreditCkk) hCreditCkk.value = cusCkk;

				if (typeof resolveBankPaymentMode === 'function') {
					rtBeginDocumentInitialization();
					resolveBankPaymentMode(cusCkk, function(resolvedMode) {
						var customerPaymentModeInput = document.getElementById('h_customer_payment_mode');
						if (customerPaymentModeInput) customerPaymentModeInput.value = resolvedMode;
						if (typeof switchPaymentMode === 'function') {
							switchPaymentMode(resolvedMode, rtEndDocumentInitialization);
						} else {
							rtEndDocumentInitialization();
						}
					});
				}
			});
		</script>
	<?php } ?>

	<?php if (count($savedRentalProducts) > 0) { ?>
		<!-- เติมแถวสินค้าใน edit mode — พอร์ต pattern เดียวกับ register_supchange.php:940-968 -->
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var rtSavedProducts = <?php echo json_encode($savedRentalProducts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

				rtSavedProducts.forEach(function(product, index) {
					var rowIndex = index + 1;
					if (rowIndex > 10) return;

					rtSetRowData(rowIndex, {
						product_id: product.product_id || '',
						product_name: product.tb_sol_name || '',
						unit_name: product.tb_unit_name || '',
						sale_count: product.count || '',
						product_price: product.price || '',
						sum_amount: product.amount || '',
						sn_number: product.sn_number || '',
						warranty: product.warranty || '',
						sale_remarkk: product.remark_sale || '',
						free_count: product.free_count || '',
						delivery_cost: product.delivery_cost || '',
						display_name: product.display_name || '',
						product_name_label: product.tb_sol_name || '',
						product_codet: product.product_code || '',
						display: ''
					});
				});

				if (typeof rtCalculateSummary === 'function') rtCalculateSummary();
			});
		</script>
	<?php } ?>

	<script language="JavaScript">
		function goMainSupRental() {
			window.location.href = 'status_suprental.php';
		}
	</script>

	<!-- แจ้งว่า DOM prefill เสร็จแล้ว; baseline จะถูก capture เมื่อ XHR initialization ของข้อมูลชำระเงินเสร็จครบด้วย -->
	<!-- ใช้เทียบก่อนเปิดปุ่มเอกสารเดิม (rtOpenSavedRentalDocument) ว่าฟอร์มถูกแก้หลังโหลดข้อมูลครบแล้วหรือยัง -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			rtDocDomReady = true;
			rtCaptureDocumentBaselineWhenReady();
		});
	</script>

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
</body>



<script>
	$('#more').click(function() {
		if ($(this).is(":checked")) {
			$("#more-2").show();
		} else {
			$("#more-2").hide();
		}
	});
</script>
