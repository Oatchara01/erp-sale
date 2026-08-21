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

	function chgFocusField(field) {
		if (!field) return;
		var parentAddrTab = field.closest('.so-addr-tab-content');
		if (parentAddrTab && parentAddrTab.id) {
			var tabBtn = document.querySelector(".so-tab-btn[onclick*='" + parentAddrTab.id + "']");
			if (tabBtn) brOpenAddrTab(parentAddrTab.id, tabBtn);
		}
		field.focus();
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
?>

<form action="register_supchange1.php" method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">
	<div class="w3-container" style="max-width:1320px;margin:0 auto;">

		<div class="so-header-container">
			<div class="so-header-left">
				<h1 class="so-title">Change Order</h1>
				<div class="so-ref-info">
					<span class="so-ref-label">เลขที่อ้างอิง</span>
					<span class="so-ref-value"><?php echo $so . $nextId; ?></span>
				</div>
			</div>
		</div>


		<script language="javascript">
			function fncSubmit() {
				if (document.frmMain.start_time.value == "") {
					alert('กรุณาใส่เวลาส่ง');
					chgFocusField(document.frmMain.start_time);
					return false;
				}

				if (document.frmMain.customer_name.value == "") {
					alert('กรุณาใส่ชื่อลูกค้า');
					chgFocusField(document.frmMain.customer_name);
					return false;
				}

				if (document.frmMain.customer_tel.value == "") {
					alert('กรุณาใส่เบอร์โทรลูกค้า');
					chgFocusField(document.frmMain.customer_tel);
					return false;
				}
				if (document.frmMain.address_1.value == "") {
					alert('กรุณาใส่สถานที่ส่งสินค้า');
					chgFocusField(document.frmMain.address_1);
					return false;
				}

				if (document.frmMain.address_name.value == "") {
					alert('กรุณาใส่ที่อยู่ในการส่งสินค้า');
					chgFocusField(document.frmMain.address_name);
					return false;
				}

				if (document.frmMain.address_send.value == "") {
					alert('กรุณาใส่สถานที่ติดตั้งเครื่อง');
					chgFocusField(document.frmMain.address_send);
					return false;
				}

				if (document.frmMain.province_name.value == "") {
					alert('กรุณาเลือกจังหวัดที่ต้องการจัดส่ง');
					chgFocusField(document.frmMain.province_name);
					return false;
				}

				document.frmMain.submit();
			}
		</script>

		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo so_saved_h($so . $nextId); ?>">
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
										<select class="so-select" name="company" id="company_select" required>
											<option value="1" selected>AWL</option>
										</select>
									</div>
								</div>

								<!-- <div class="so-field-group" style="margin-bottom:0; flex:1; max-width:220px;">
									<label class="so-label" for="date_change">วันที่</label>
									<div class="calendar-wrapper" style="width:100%;">
										<input type="date" name="date_change" id="date_change" class="so-input" value="<?php echo so_saved_h($today); ?>" required>
									</div>
								</div> -->

								<!-- คอสเมติกล้วน: hos__change ยังไม่มีคอลัมน์รองรับ "งานด่วน" สำหรับเอกสาร Change Order
								     (ต่างจาก que_ckk ของ hos__consig ที่ register_supbrcshos1.php เขียนจริง) จึงตั้งชื่อ
								     field ให้ไม่ชนกับ que_ckk เพื่อไม่ให้ backend รับค่าที่ไม่มีคอลัมน์รองรับไปเงียบๆ -->
								<label class="so-toggle-pill so-doc-info-line-toggle">
									<input type="checkbox" name="que_ckk_ui" id="que_ckk_ui" value="1">
									<span>งานด่วน</span>
								</label>
							</div>
						</div>
					</div>

					<?php
					// Admin tab — placeholder visual scaffold เท่านั้น (ตามสโคปที่ยืนยันแล้วว่า
					// register_supchange1.php ไม่เขียน iv_no/iv_date/job_no1/cancel ของเอกสารประเภทนี้ —
					// ฟิลด์ในนี้จึงตั้งชื่อไม่ชนกับคอลัมน์จริงใดๆ และปุ่มไม่มี onclick ที่ทำงานจริง)
					$adminInfoTab = [
						'tab_id' => 'tab-admin-info',
						'title' => 'ข้อมูลเพิ่มเติม (Admin)',
						'rows' => [
							[
								['type' => 'text', 'name' => 'admin_doc_no_ui', 'label' => 'เลขที่เอกสาร', 'value' => '', 'placeholder' => 'No.'],
								['type' => 'button', 'icon' => 'img/icons/doc.png', 'label' => 'Run เอกสาร', 'id' => 'btn_run_doc_no_ui', 'variant' => 'purple', 'disabled' => true],
								['type' => 'date_th', 'name' => 'admin_doc_date_ui', 'label' => 'วันที่ออกเอกสาร', 'value' => '', 'icon' => 'far fa-calendar-alt'],
								['type' => 'text', 'name' => 'admin_work_no_ui', 'label' => 'เลขที่ลงงาน', 'value' => '', 'icon' => 'img/icons/preview.png'],
							],
							[
								['type' => 'button_field', 'button' => [
									'type' => 'button',
									'icon' => 'img/icons/circle_x.png',
									'label' => 'ยกเลิกเอกสาร',
									'variant' => 'danger',
									'disabled' => true,
									'id' => 'btn_cancel_doc_ui',
								]],
								['type' => 'text', 'name' => 'admin_cancel_reason_ui', 'id' => 'admin_cancel_reason_ui', 'label' => 'หมายเหตุการยกเลิก', 'value' => '', 'placeholder' => 'ระบุเหตุผลการยกเลิก', 'icon' => 'fas fa-times', 'span' => 3, 'disabled' => true],
							],
						],
					];
					include __DIR__ . '/partials/admin_info_tab.php';
					unset($adminInfoTab);
					?>
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
									<input type="text" name="customer" id="customer" class="so-input" readonly placeholder="จะแสดงผลอัตโนมัติเมื่อเลือกเสร็จสิ้น" required>
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
				</div>

				<!-- ===================== ข้อมูลการจัดส่ง ===================== -->
				<div id="step-delivery">
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
							['type' => 'select', 'span' => 2, 'name' => 'transport_company_ui', 'label' => 'บริษัทขนส่ง', 'required' => true, 'options' => [
								'' => 'เลือกบริษัทขนส่ง',
								'1' => 'Kerry',
								'2' => 'Flash',
								'3' => 'J&T',
								'4' => 'ไปรษณีย์ไทย',
							]],
							['type' => 'date', 'span' => 2, 'name' => 'start_date', 'label' => 'วันที่รับ-ส่ง', 'required' => true],
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
							['name' => 'send_cs_ui', 'id' => 'send_cs_ui', 'label' => 'ส่งข้อมูลลงระบบ CS'],
						],
						'cost_fields' => [
							['type' => 'date', 'name' => 'shipping_date_ui', 'label' => 'วันที่คีย์ค่าส่ง'],
							['type' => 'text', 'name' => 'shipping_ref1_ui', 'label' => 'รหัสอ้างอิง 1'],
							['type' => 'text', 'name' => 'shipping_ref2_ui', 'label' => 'รหัสอ้างอิง 2'],
							['type' => 'text', 'name' => 'shipping_cost_ui', 'label' => 'ค่าจัดส่ง'],
						],
					];
					include __DIR__ . '/partials/delivery_info_tab.php';
					?>
					<input type="hidden" name="end_time" id="end_time" value="">
					<script>
						function syncChgDeliveryTimeRange() {
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
								startTime.focus();
							} else if (val === '') {
								startTime.value = '';
								if (endTime) endTime.value = '';
							}
						}

						function syncChgDeliveryTimeRangeFromInputs() {
							var timeRange = document.getElementById('time_range_ui');
							var startTime = document.querySelector('input[name="start_time"]');
							var endTime = document.querySelector('input[name="end_time"]');
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

						(function() {
							var timeRange = document.getElementById('time_range_ui');
							var startTime = document.querySelector('input[name="start_time"]');
							if (timeRange) {
								timeRange.addEventListener('change', syncChgDeliveryTimeRange);
							}
							if (startTime) {
								startTime.addEventListener('input', syncChgDeliveryTimeRangeFromInputs);
								startTime.addEventListener('change', syncChgDeliveryTimeRangeFromInputs);
							}
							var endTimeEl = document.querySelector('input[name="end_time"]');
							if (endTimeEl) {
								endTimeEl.addEventListener('input', syncChgDeliveryTimeRangeFromInputs);
								endTimeEl.addEventListener('change', syncChgDeliveryTimeRangeFromInputs);
							}
						})();
					</script>

					<!-- <div class="so-card" style="margin-top: 24px;">
						<div class="so-section-title-container">
							<h3 class="so-section-title">เงื่อนไขการจัดส่ง / การรับเงิน</h3>
							<hr class="so-divider">
						</div>
						<div class="so-checkbox-grid" style="margin-bottom: 16px;">
							<label class="so-checkbox-pill">
								<input type="checkbox" name="fix_datetime" id="fix_datetime" value="1"> <span>นัดวันและเวลาเรียบร้อยแล้ว</span>
							</label>
							<label class="so-checkbox-pill">
								<input type="checkbox" name="on_time" id="on_time" value="1"> <span>งานสำคัญต้องตรงเวลา</span>
							</label>
							<label class="so-checkbox-pill">
								<input type="checkbox" name="call_back" id="call_back" value="1"> <span>ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว</span>
							</label>
							<label class="so-checkbox-pill">
								<input type="checkbox" name="want_bus" id="want_bus" value="1"> <span>ต้องการรถใหญ่</span>
							</label>
						</div>

						<div class="so-field-group" style="margin-bottom: 16px;">
							<label class="so-label">สถานะการทำงาน</label>
							<div style="display:flex; gap:16px; align-items:center; height:42px;">
								<label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-family:'Prompt',sans-serif; font-size:14px; color:#333; font-weight:500;">
									<input type="radio" name="status" value="ส่ง" checked style="accent-color:#612989; width:18px; height:18px;"> ส่ง
								</label>
								<label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-family:'Prompt',sans-serif; font-size:14px; color:#333; font-weight:500;">
									<input type="radio" name="status" value="รับ" style="accent-color:#612989; width:18px; height:18px;"> รับ
								</label>
							</div>
						</div>

						<div class="so-grid-2" style="margin-bottom: 16px;">
							<div class="so-input-with-checkbox">
								<label class="so-checkbox-label"><input type="checkbox" name="sn_ckk" id="sn_ckk" value="1"> ต้องการ SN</label>
								<input name="sn" id="sn" class="so-input" placeholder="ระบุหมายเลข SN">
							</div>
						</div>

						<div class="so-grid-2">
							<div class="so-input-with-checkbox">
								<label class="so-checkbox-label"><input type="checkbox" name="cash" id="cash" value="1"> เก็บเงินสด</label>
								<input name="unit_cash" id="unit_cash" class="so-input" style="text-align:right;" placeholder="จำนวนเงิน">
							</div>
							<div class="so-input-with-checkbox">
								<label class="so-checkbox-label"><input type="checkbox" name="check_paper" id="check_paper" value="1"> รับเช็ค</label>
								<input name="unit_check" id="unit_check" class="so-input" style="text-align:right;" placeholder="จำนวนเงิน">
							</div>
							<div class="so-input-with-checkbox">
								<label class="so-checkbox-label"><input type="checkbox" name="credit_card" id="credit_card" value="1"> รูดการ์ด</label>
								<input name="unit_credit" id="unit_credit" class="so-input" style="text-align:right;" placeholder="จำนวนเงิน">
							</div>
							<div class="so-input-with-checkbox">
								<label class="so-checkbox-label"><input type="checkbox" name="bill" id="bill" value="1"> วางบิล</label>
								<input name="unit_bill" id="unit_bill" class="so-input" style="text-align:right;" placeholder="จำนวนเงิน">
							</div>
							<div class="so-input-with-checkbox">
								<label class="so-checkbox-label"><input type="checkbox" name="tran" id="tran" value="1"> ลูกค้าโอนเงินหน้างาน</label>
								<input name="unit_tran" id="unit_tran" class="so-input" style="text-align:right;" placeholder="จำนวนเงิน">
							</div>
							<div class="so-input-with-checkbox">
								<label class="so-checkbox-label"><input type="checkbox" name="dep" id="dep" value="1"> อื่นๆ</label>
								<input name="dept" id="dept" class="so-input" placeholder="ระบุ">
							</div>
						</div>
					</div> -->
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
									<label class="so-label" for="location_link_ui">Location Link</label>
									<div class="so-input-wrapper">
										<input type="text" class="so-input" name="location_link_ui" id="location_link_ui" placeholder="วางลิงก์ Google Maps หรือพิกัด">
										<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('location_link_ui').value='';" aria-label="ล้างค่า"></button>
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
											<input type="radio" name="park_front_ui" value="1" checked style="accent-color: #612989; width: 18px; height: 18px;"> ได้
										</label>
										<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
											<input type="radio" name="park_front_ui" value="0" style="accent-color: #612989; width: 18px; height: 18px;"> ไม่ได้
										</label>
									</div>
								</div>
								<div class="so-field-group">
									<label class="so-label" style="color: #612989;">สถานที่จอดรถ</label>
									<input name="park_location_ui" type="text" class="so-input" placeholder="สถานที่จอดรถ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
								</div>
								<div class="so-field-group">
									<label style="cursor: pointer; display: block;">
										<input type="checkbox" name="is_high_roof_ui" value="1" style="display: none;" onchange="this.nextElementSibling.style.backgroundColor = this.checked ? '#612989' : '#F4F3F7'; this.nextElementSibling.style.color = this.checked ? 'white' : '#6e6e6e';">
										<div style="background-color: #F4F3F7; border-radius: 8px; padding: 10px; display: flex; align-items: center; justify-content: center; color: #6e6e6e; font-size: 14px; font-family: 'Prompt', sans-serif; height: 42px; transition: all 0.2s; user-select: none;">รถหลังคาสูงเข้าได้</div>
									</label>
								</div>
							</div>

							<div class="so-grid-3" style="margin-top: 16px;">
								<div class="so-field-group">
									<label class="so-label" style="color: #612989;">ทางเข้าบ้าน</label>
									<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
										<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
											<input type="radio" name="entrance_type_ui" value="1" checked style="accent-color: #612989; width: 18px; height: 18px;"> ทางราบ
										</label>
										<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
											<input type="radio" name="entrance_type_ui" value="2" style="accent-color: #612989; width: 18px; height: 18px;"> บันไดก่อนเข้าบ้าน
										</label>
									</div>
								</div>
								<div class="so-field-group">
									<label class="so-label" style="color: #612989;">จำนวนขั้นบันได</label>
									<input name="stair_count_ui" type="text" class="so-input" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
								</div>
								<div class="so-field-group">
									<label class="so-label" style="color: #612989;">ชั้นที่ติดตั้ง</label>
									<input name="install_floor_ui" type="text" class="so-input" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
								</div>
							</div>

							<div class="so-grid-3" style="margin-top: 16px;">
								<div class="so-field-group" style="min-width: 0;">
									<label class="so-label" style="color: #612989;">ห้องที่ติดตั้ง</label>
									<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
										<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
											<input type="radio" name="room_type_ui" value="1" checked style="accent-color: #612989; width: 18px; height: 18px;"> ห้องโถง
										</label>
										<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
											<input type="radio" name="room_type_ui" value="2" style="accent-color: #612989; width: 18px; height: 18px;"> ห้องนอน
										</label>
									</div>
								</div>
								<div class="so-field-group" style="min-width: 0;">
									<label class="so-label" style="color: #612989;">ขนาดประตูห้อง</label>
									<div style="display: flex; gap: 16px;">
										<input name="door_width_ui" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
										<input name="door_height_ui" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
									</div>
								</div>
								<div class="so-field-group" style="min-width: 0;">
									<label class="so-label" style="color: #612989;">ขนาดบันได</label>
									<div style="display: flex; gap: 16px;">
										<input name="stair_width_ui" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
										<input name="stair_height_ui" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
									</div>
								</div>
							</div>

							<div class="so-grid-3" style="margin-top: 16px;">
								<div class="so-field-group" style="min-width: 0;">
									<label class="so-label" style="color: #612989;">ประตูลิฟต์</label>
									<div style="display: flex; gap: 16px;">
										<input name="elev_door_width_ui" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
										<input name="elev_door_height_ui" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
									</div>
								</div>
								<div class="so-field-group" style="grid-column: span 1; min-width: 0;">
									<label class="so-label" style="color: #612989;">ขนาดห้องลิฟต์</label>
									<div style="display: flex; gap: 16px;">
										<input name="elev_width_ui" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
										<input name="elev_height_ui" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
										<input name="elev_depth_ui" type="text" class="so-input" placeholder="ความลึก (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
									</div>
								</div>
								<div class="so-field-group" style="min-width: 0;">
									<label class="so-label" style="color: #612989;">ขนาดบรรทุกของลิฟต์</label>
									<input name="elev_capacity_ui" type="text" class="so-input" placeholder="น้ำหนัก (กก.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
								</div>
							</div>

							<div class="so-grid-3" style="margin-top: 16px;">
								<div class="so-field-group">
									<label class="so-label" style="color: #612989;">การย้ายเฟอร์นิเจอร์</label>
									<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
										<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
											<input type="radio" name="move_furn_ui" value="0" checked style="accent-color: #612989; width: 18px; height: 18px;"> ไม่
										</label>
										<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
											<input type="radio" name="move_furn_ui" value="1" style="accent-color: #612989; width: 18px; height: 18px;"> ย้าย
										</label>
									</div>
								</div>
								<div class="so-field-group">
									<label class="so-label" style="color: #612989;">จำนวนชิ้นที่ย้าย</label>
									<input name="move_furn_count_ui" type="text" class="so-input" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
								</div>
								<div class="so-field-group" style="grid-column: span 1;">
									<label class="so-label" style="color: #612989;">รายละเอียดเฟอร์นิเจอร์</label>
									<input name="move_furn_detail_ui" type="text" class="so-input" placeholder="รายละเอียดเฟอร์นิเจอร์" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
								</div>
							</div>

							<div class="so-field-group" style="margin-top: 16px;">
								<label class="so-label" style="color: #612989;">หมายเหตุเพิ่มเติม</label>
								<input name="addr_note_ui" type="text" class="so-input" placeholder="รายละเอียดเพิ่มเติม" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
							</div>
						</div>

						<?php
						// Full mirror จาก register_supbrcshos.php: ตัวแปรของฟีเจอร์พิมพ์ใบปะหน้าที่ต้นแบบใช้
						// ($printCoverRefId/$coverSheetMainReports/$coverSheetExtraReports/$billDeliveryReports)
						// ไม่มีอยู่จริงสำหรับเอกสาร Change Order — ตั้งเป็นค่าว่าง/array ว่างไว้ เพื่อให้ panel
						// แสดงผลอย่างสุจริต (ข้อความ "ยังไม่มี ref_id" ตลอด) แทนที่จะอ้างอิงรายงานที่ไม่มีจริง
						$chgPrintCoverRefId = '';
						$chgCoverSheetMainReports = [];
						$chgCoverSheetExtraReports = [];
						$chgBillDeliveryReports = [];
						?>
						<div id="chg_addr_extra" class="so-addr-tab-content" style="display:none;">
							<!-- Full mirror จาก register_supbrcshos.php's br_addr_extra (ไม่รวม br_addr_return
							     ตามคำขอ) returns/returns_*/return_date_bet เป็นฟิลด์จริงที่ register_supchange1.php
							     อ่านแบบไม่มี isset() guard จึงต้อง mirror เป็น hidden ค่าว่างไว้เพื่อไม่ให้ backend error -->
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
												<input name="extra_contact_name_1_ui" type="text" class="so-input" placeholder="ชื่อผู้ติดต่อ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
												<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
											</div>
										</div>
										<div class="so-field-group">
											<label class="so-label extra-contact-tel-label" style="color: #612989;">เบอร์โทร (เพิ่มเติม1)</label>
											<div style="position: relative; display: flex; align-items: center;">
												<input name="extra_contact_tel_1_ui" type="text" class="so-input" placeholder="เบอร์โทร" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
												<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
											</div>
										</div>
										<div class="so-field-group">
											<label class="so-label" style="color: #612989;">จังหวัด</label>
											<div class="so-select-wrapper">
												<select name="extra_contact_province_1_ui" class="so-select" style="background-color: #F4F3F7; border:none; border-radius: 8px;">
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
												<input name="extra_shipping_address_1_ui" type="text" class="so-input" placeholder="ที่อยู่ส่งสินค้า" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
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
										if (contactName) contactName.name = 'extra_contact_name_' + displayIndex + '_ui';

										const contactTel = row.querySelector('input[name^="extra_contact_tel"]');
										if (contactTel) contactTel.name = 'extra_contact_tel_' + displayIndex + '_ui';

										const contactProvince = row.querySelector('select[name^="extra_contact_province"]');
										if (contactProvince) contactProvince.name = 'extra_contact_province_' + displayIndex + '_ui';

										const shippingAddress = row.querySelector('input[name^="extra_shipping_address"]');
										if (shippingAddress) shippingAddress.name = 'extra_shipping_address_' + displayIndex + '_ui';
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
											<input name="bill_extra_contact_name_2_ui" type="text" class="so-input" placeholder="ชื่อผู้ติดต่อ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
											<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
										</div>
									</div>
									<div class="so-field-group">
										<label class="so-label" style="color: #612989;">เบอร์โทร</label>
										<div style="position: relative; display: flex; align-items: center;">
											<input name="bill_extra_contact_tel_2_ui" type="text" class="so-input" placeholder="เบอร์โทร" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
											<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
										</div>
									</div>
									<div class="so-field-group">
										<label class="so-label" style="color: #612989;">จังหวัด</label>
										<div class="so-select-wrapper">
											<select name="bill_extra_contact_province_2_ui" class="so-select" style="background-color: #F4F3F7; border:none; border-radius: 8px;">
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
											<input name="bill_extra_shipping_address_2_ui" type="text" class="so-input" placeholder="ที่อยู่ส่งสินค้า" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
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
					$docTabsCard = [
						'open_fn' => 'brOpen3Tab',
						'attach_file' => ['enabled' => true],
					];
					include __DIR__ . '/partials/doc_tabs_card.php';
					?>
				</div>

			</div>
		</div>
	</div>

	<div class="so-sticky-actions">
		<div class="so-sticky-actions-inner">
			<button type="submit" name="submit" id="btn_submit_form" value="submit" class="btn-so-submit"><i class="fas fa-paper-plane"></i> Submit</button>
			<button type="button" name="cancel_edit" class="btn-so-cancel-nav" onclick="goMainSupChange();">ยกเลิก</button>
		</div>
	</div>
</form>

<script language="JavaScript">
	function goMainSupChange() {
		window.location.href = 'status_adminchange.php';
	}
</script>

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