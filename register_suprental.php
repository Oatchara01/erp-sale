<?php include("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>
<?php require_once __DIR__ . '/includes/so_saved_helpers.php'; // so_saved_h() ใช้โดย partials/admin_info_tab.php 
?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-supbrcshos.css?v=<?php echo filemtime(__DIR__ . '/css/register-supbrcshos.css'); ?>">
<link rel="stylesheet" href="css/register-suprental.css?v=<?php echo filemtime(__DIR__ . '/css/register-suprental.css'); ?>">
<link rel="stylesheet" href="css/credit-term-modal.css?v=<?php echo filemtime(__DIR__ . '/css/credit-term-modal.css'); ?>">
<script src="js/customer-popup.js?v=<?php echo filemtime(__DIR__ . '/js/customer-popup.js'); ?>"></script>
<script src="js/credit-term-modal.js?v=<?php echo filemtime(__DIR__ . '/js/credit-term-modal.js'); ?>"></script>

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
					setElementValue(address_send, myArr[14]);
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

	function clearFieldValue(id) {
		var el = document.getElementById(id);
		if (el) el.value = '';
	}

	function clearCustomerSelection() {
		['rental_id', 'h_rental_id', 'rental_name', 'rental_tel', 'rental_address',
			'bill_id', 'h_bill_id', 'bill_name', 'bill_address', 'bill_tel', 'tax_no',
			'connect_name', 'connect_tel', 'patient_name', 'emergency_name', 'emergency_tel',
			'install_address', 'rental_addr_detail', 'rental_district', 'rental_zipcode'
		].forEach(clearFieldValue);
		clearFieldValue('rental_province');

		setElementText('display_rental_name', '');
		setElementText('display_rental_tel', '');
		setElementText('display_mode_name', '');
		setElementText('display_customer_typename', '');
		setCreditThbDisplay('');
		clearFieldValue('h_credit_ckk_value');
		clearFieldValue('h_customer_payment_mode');
		switchPaymentMode('credit');

		var vipIcon = document.getElementById('display_vip_icon');
		if (vipIcon) vipIcon.style.display = 'none';
	}

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

					if (typeof callback === 'function') {
						callback();
					}
				} else {
					console.error('โหลดช่องทางชำระเงินไม่สำเร็จ');
				}
			}
		};
		xhr.send();
	}

	// สลับโหมดการชำระเงิน (เครดิต / เงินสด)
	function switchPaymentMode(mode) {
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
		loadTypeBankOptions(function() {
			var pmSelect = document.getElementById('payment_method');
			if (pmSelect && pmSelect.value !== '0' && pmSelect.value !== '') {
				loadBankOptions(true, pmSelect.value);
			}
		});
		switchPaymentMode('credit');

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

	?>

	<!--action="register_office1.php"-->
	<form action='register_suprental1.php' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">

		<script language="javascript">
			function fncSubmit() //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
			{


				document.frmMain.submit();
			}
		</script>

		<div class="rt-layout">
			<div class="rt-content-col">

				<div class="so-header-container">
					<div class="so-header-left">
						<h1 class="so-title">ใบสั่งเช่า (Rental Order)</h1>
						<div class="so-ref-info">
							<span class="so-ref-label">เลขที่อ้างอิง</span>
							<span class="so-ref-value"><?php echo $so;
														echo $nextId; ?></span>
						</div>
					</div>
					<div class="so-header-right">
						<button type="button" class="btn-preview-so" onclick="alert('กรุณาบันทึกเอกสารก่อน ฟังก์ชัน Preview ใช้งานได้หลังบันทึกใบสั่งเช่าแล้ว');"><i class="fas fa-file-alt" aria-hidden="true"></i> Preview</button>
					</div>
				</div>
				<input type="hidden" name="ref_id" class="w3-input" value="1">

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
									<select name="type_doc" class="so-select">
										<option value="3" selected>AWL</option>
										<option value="4">NBM</option>
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
							<button type="button" class="so-toggle-pill-outline-custom" onclick="alert('กรุณาบันทึกเอกสารก่อน จึงจะออกใบสั่งขายได้ (ฟังก์ชันนี้อยู่ในหน้าแก้ไขเอกสารหลังบันทึก)');"><span><img src="img/icons/money.png" alt="" style="width:16px;height:16px;object-fit:contain;"> ออกใบสั่งขาย</span></button>
							<button type="button" class="so-toggle-pill-outline-custom" onclick="alert('กรุณาบันทึกเอกสารก่อน จึงจะออกใบเงินประกันสินค้าได้ (ฟังก์ชันนี้อยู่ในหน้าแก้ไขเอกสารหลังบันทึก)');"><span><img src="img/icons/check_border.png" alt="" style="width:16px;height:16px;object-fit:contain;"> เงินประกันสินค้า</span></button>
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

							<div class="so-field-group">
								<label class="so-label">เลขที่สัญญา</label>
								<input type="text" class="so-input" readonly placeholder="จะออกให้อัตโนมัติหลังบันทึกเอกสาร">
							</div>
						</div>

						<div class="so-field-group">
							<label class="so-label">ทรัพย์ที่เช่า (ชื่อสินค้า)</label>
							<div class="so-input-wrapper">
								<input type="text" name="rental_item_name" id="rental_item_name" class="so-input" placeholder="ระบุชื่อทรัพย์ที่เช่า">
								<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('rental_item_name').value='';" aria-label="ล้างค่า"></button>
							</div>
						</div>

						<label class="so-toggle-pill" style="margin-top:12px;">
							<input type="checkbox" name="have_order" value="1">
							<span>ออเดอร์ฝาก</span>
						</label>
					</div>
				</div>

				<?php
				$adminInfoTab = [
					'tab_id' => 'rt-doc-tab-2',
					'title' => 'ข้อมูลเพิ่มเติม (Admin)',
					'rows' => [
						[
							['type' => 'inline_group', 'fields' => [
								['type' => 'text', 'name' => 'rt_admin_doc_no', 'label' => 'เลขที่เอกสาร', 'placeholder' => 'No.'],
								['type' => 'button', 'icon' => 'img/icons/doc.png', 'label' => 'Run เอกสาร', 'id' => 'btn_rt_run_doc_no', 'onclick' => "alert('กรุณาบันทึกเอกสารก่อน จึงจะออกเลขที่เอกสารได้');", 'variant' => 'purple'],
							]],
							['type' => 'date_th', 'name' => 'rt_admin_doc_date', 'label' => 'วันที่ออกเอกสาร'],
							['type' => 'text', 'name' => 'rt_admin_work_no', 'label' => 'เลขที่ลงงาน', 'icon' => 'img/icons/search.png'],
						],
						[
							['type' => 'text', 'name' => 'rt_admin_sr_no', 'label' => 'เลขที่ SR ลดหนี้', 'icon' => 'img/icons/search.png'],
							['type' => 'text', 'name' => 'rt_admin_deposit_no', 'label' => 'เลขที่ใบฝาก', 'icon' => 'img/icons/search.png'],
							['type' => 'sub_grid', 'fields' => [
								['type' => 'text', 'name' => 'rt_admin_box_count', 'label' => 'จำนวนกล่อง', 'placeholder' => 'เฉพาะตัวเลข'],
								['type' => 'text', 'name' => 'rt_admin_edit_count', 'label' => 'จำนวนครั้งที่แก้ไขบิล', 'placeholder' => 'ใส่เฉพาะตัวเลข'],
							]],
						],
						[
							['type' => 'date_th', 'name' => 'rt_admin_doc_date_old', 'label' => 'วันที่ออกเอกสาร (เดิม)'],
							['type' => 'text', 'name' => 'rt_admin_edit_reason', 'label' => 'สาเหตุการแก้ไขบิล', 'placeholder' => 'ระบุสาเหตุการแก้ไขบิล', 'icon' => 'fas fa-times', 'clearable' => true, 'span' => 2],
						],
						[
							['type' => 'button_field', 'button' => [
								'type' => 'button',
								'icon' => 'img/icons/circle_x.png',
								'label' => 'ยกเลิกเอกสาร',
								'id' => 'btn_rt_cancel_doc',
								'onclick' => 'rtToggleCancelDoc();',
							]],
							['type' => 'text', 'name' => 'rt_admin_cancel_reason', 'id' => 'rt_admin_cancel_reason', 'label' => 'หมายเหตุการยกเลิก', 'placeholder' => 'ระบุเหตุผลการยกเลิก', 'icon' => 'fas fa-times', 'clearable' => true, 'span' => 2, 'disabled' => true],
						],
					],
				];
				include __DIR__ . '/partials/admin_info_tab.php';
				unset($adminInfoTab);
				?>
				<input type="hidden" name="rt_admin_cancel_doc" id="rt_admin_cancel_doc" value="0">
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
												<i class="fas fa-times so-clear-icon" onclick="clearCustomerSelection();" aria-label="ล้างการเลือกลูกค้า"></i>
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

					<div class="so-grid-3" style="margin-top: 18px;">
						<div class="so-field-group" style="margin-bottom: 0;">
							<label class="so-label" for="rental_referrer">ผู้แนะนำ</label>
							<div class="so-input-wrapper">
								<input type="text" name="rental_referrer" id="rental_referrer" class="so-input" placeholder="ระบุชื่อผู้แนะนำ" style="padding-right: 32px;">
								<i class="fas fa-times so-clear-icon" onclick="document.getElementById('rental_referrer').value='';" aria-label="ล้างผู้แนะนำ"></i>
							</div>
						</div>
						<div class="so-field-group" style="margin-bottom: 0; justify-content: flex-end;">
							<div style="display: flex; align-items: center; height: 42px;">
								<label class="so-toggle-pill" id="lbl-rental_repeat_cus">
									<input type="checkbox" name="rental_repeat_cus" id="rental_repeat_cus" value="1">
									<span>ลูกค้าซื้อซ้ำ</span>
								</label>
							</div>
						</div>
						<div></div>
					</div>
				</div>

				<!-- ===================== การชำระเงิน (payment/des_sale — sale_code/start_promis/count_m ย้าย
				     ไปการ์ด "ข้อมูลเอกสาร" ในแท็บด้านบนแล้ว) ===================== -->
				<div class="so-card">
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
								<button type="button" class="so-address-action-btn so-address-action-btn-secondary" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;" onclick="doCallAjax1('rental_id', 'rental_name', 'rental_tel', 'emergency_name', 'emergency_tel', 'rental_address', 'install_address', 'bill_name', 'bill_address', 'bill_tel', 'tax_no', 'connect_name', 'connect_tel', 'patient_name', 'install_address', 'address_1', 'address_name', 'address_send', 'customer_name', 'customer_tel', 'province_name', 'rental_addr_detail', 'rental_district', 'rental_province', 'rental_zipcode');">
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
									<span class="so-file-picker-text" id="bank_img_text">Choose File</span>
									<i class="far fa-image so-file-picker-icon"></i>
									<input type="file" name="bank_img" id="bank_img" class="so-file-picker-input" accept="image/*,application/pdf" required onchange="showRentalBankImgName(this)">
								</label>
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
									<tr class="rt-status-empty">
										<td colspan="6">ยังไม่มีรายการชำระเงิน</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php
				/**
				 * ฟังก์ชัน Helper สำหรับแสดงสถานะของคอลัมน์ "สรุปงาน" (ตามแบบ Figma node 683:3549)
				 * รองรับทุกสถานะ: สมบูรณ์ (เขียว), รอช่าง/รอการส่งมอบ (ส้ม/เหลือง), กำลังดำเนินงาน (ฟ้า), ไม่สำเร็จ/ยกเลิก (แดง)
				 */
				if (!function_exists('renderJobSummaryStatusPill')) {
					function renderJobSummaryStatusPill($statusText)
					{
						$status = trim((string)$statusText);
						if ($status === '') return '-';

						$icon = '';
						$class = 'is-muted';

						if (preg_match('/(สมบูรณ์|สำเร็จ|เรียบร้อย|ผ่าน)/u', $status)) {
							$class = 'is-success';
							$icon = '<i class="fas fa-check-circle" style="font-size: 11px; margin-right: 4px;"></i>';
						} elseif (preg_match('/(รอ|รอช่าง|รอดำเนินการ|รอชำระ|รอนัดหมาย)/u', $status)) {
							$class = 'is-pending';
							$icon = '<i class="fas fa-clock" style="font-size: 11px; margin-right: 4px;"></i>';
						} elseif (preg_match('/(กำลัง|ระหว่าง|ดำเนินงาน|กำลังส่ง|จัดส่ง)/u', $status)) {
							$class = 'is-info';
							$icon = '<i class="fas fa-spinner fa-spin" style="font-size: 11px; margin-right: 4px;"></i>';
						} elseif (preg_match('/(ไม่สำเร็จ|ยกเลิก|ตีกลับ|ปฏิเสธ|มีปัญหา)/u', $status)) {
							$class = 'is-danger';
							$icon = '<i class="fas fa-times-circle" style="font-size: 11px; margin-right: 4px;"></i>';
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
									<tr class="rt-status-empty">
										<td colspan="6">ยังไม่มีรายการรับส่งสินค้า</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>



			</div>
		</div>

		<div class="so-sticky-actions">
			<div class="so-sticky-actions-inner">
				<button type="submit" name="submit" id="btn_submit_form" value="submit" class="btn-so-submit"><i class="fas fa-paper-plane"></i> Submit</button>
				<button type="button" name="save_draft" id="btn_save_draft" class="btn-so-draft"><i class="far fa-save"></i> Save Draft</button>
				<button type="button" name="cancel_edit" class="btn-so-cancel-nav" onclick="goMainSupRental();">ยกเลิก</button>
			</div>
		</div>
	</form>

	<script language="JavaScript">
		function goMainSupRental() {
			window.location.href = 'status_suprental.php';
		}
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