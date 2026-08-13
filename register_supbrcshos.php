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
					document.frmMain.customer_name.focus();
					return false;
				}

				if (document.frmMain.customer_tel.value == "") {
					alert('กรุณาใส่เบอร์โทรลูกค้า');
					document.frmMain.customer_tel.focus();
					return false;
				}
				if (document.frmMain.address_1.value == "") {
					alert('กรุณาใส่สถานที่ส่งสินค้า');
					document.frmMain.address_1.focus();
					return false;
				}

				if (document.frmMain.address_name.value == "") {
					alert('กรุณาใส่ที่อยู่ในการส่งสินค้า');
					document.frmMain.address_name.focus();
					return false;
				}

				if (document.frmMain.address_send.value == "") {
					alert('กรุณาใส่สถานที่ติดตั้งเครื่อง');
					document.frmMain.address_send.focus();
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

			<!-- ไม่มีใน Figma (node 627:2697) — ซ่อนไว้ก่อนตามที่แจ้ง ฟิลด์ยังอยู่ใน DOM/submit ได้ปกติ ไม่ได้ลบ logic -->
			<div class="so-field-group" style="margin-top:16px; display:none;">
				<label class="so-label" for="sale_comment">Sale Comment</label>
				<textarea name="sale_comment" id="sale_comment" class="so-textarea" rows="2"></textarea>
			</div>

			<!-- ย้ายมาจากการ์ด "ข้อมูลเอกสาร" — ไม่มีใน register_supbrhos.php's "ข้อมูลลูกค้า" การ์ดนี้เช่นกัน
			     ซ่อนไว้ก่อนตามที่แจ้ง (เหมือน sale_comment) ฟิลด์ยังอยู่ใน DOM/submit ได้ปกติ ไม่ได้ลบ logic -->
			<div class="so-grid-3" style="margin-top:8px; display:none;">
				<div class="so-field-group">
					<label class="so-label" for="sale_code">เขตการขาย</label>
					<div class="so-select-wrapper">
						<?php
						if ($_SESSION['code'] == 'SS1') {
						?>
							<select name="sale_code" id="sale_code" class="so-select" required>
								<option value="">**Please Select**</option>
								<?php

								$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
								//echo $strSQL5;
								//exit();
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
							<select name="sale_code" id="sale_code" class="so-select">
								<option value="">**Please Select**</option>
								<?php

								$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
								//echo $strSQL5;
								//exit();
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
								//echo $strSQL5;
								//exit();
								$objQuery5 = mysqli_query($com, $strSQL5);
								while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
								?>
									<option value="<?php echo $objResuut5["sale_code"]; ?>"><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
								<?php
								}
								?>
							</select>
						<?php
						} else 	if ($_SESSION['code'] == 'SS5') {

						?>
							<select name="sale_code" id="sale_code" class="so-select" required>
								<option value="">**Please Select**</option>
								<?php

								$strSQL5 = "SELECT * FROM tb_team_ss3 where sale_code IN ('S31','S32') ORDER BY sale_code ASC";
								//echo $strSQL5;
								//exit();
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
								//echo $strSQL5;
								//exit();
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
								//echo $strSQL5;
								//exit();
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
								//echo $strSQL5;
								//exit();
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
					<label class="so-label" for="employee_name">ชื่อพนักงาน</label>
					<input name="employee_name" class="so-input" type='text' value="<?php echo $_SESSION['name']; ?>" id="employee_name">
				</div>
				<div class="so-field-group">
					<label class="so-label" for="employee_tel">เบอร์โทรพนักงาน</label>
					<input name="employee_tel" class="so-input" type='text' id="employee_tel">
				</div>
			</div>

			<div class="so-grid-3" style="display:none;">
				<div class="so-field-group">
					<label class="so-label" for="department_show">แผนก - ฝ่าย</label>
					<?php
					if ($_SESSION['department'] == "วิศวกรรม") {
						$department = "ฝ่ายวิศวกรรม";
					} else if ($_SESSION['code'] == "INT") {
						$department = "ฝ่ายต่างประเทศ";
					} else {
						$department = "ฝ่ายขาย";
					}
					?>
					<input name="department_show" value="<?php echo $department; ?>" class="so-input" type='text' id="department_show" readonly>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="department_name">ประเภทงาน</label>
					<?php
					if ($_SESSION['department'] == "วิศวกรรม") {
						$sale = 'วิศวกรรม';
					} else if ($_SESSION['code'] == "INT") {
						$sale = "อื่นๆ";
					} else {
						$sale = 'Sale';
					}

					?>
					<input name="department_name" value="<?php echo $sale; ?>" class="so-input" type='text' id="department_name" readonly>
				</div>
			</div>
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

		<!-- ===================== Card: การจัดส่ง ===================== -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">การจัดส่ง</h2>
				<hr class="so-divider">
			</div>

			<!-- ย้ายมาจากการ์ด "ข้อมูลเอกสาร" (ไม่มีใน Figma แต่เป็นวันที่/วัตถุประสงค์ของการเบิก-จัดส่ง จึงจัดไว้ที่นี่) -->
			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="date_br">วันที่</label>
					<input type="date" name="date_br" id="date_br" value="<?php echo $today; ?>" class="so-input" readonly>
				</div>
				<div class="so-field-group">
					<label class="so-label">วัตถุประสงค์การเบิก</label>
					<div class="so-static-box">
						สินค้าฝากขาย (มีใบรับประกัน)
						<input type="radio" checked='checked' name="objective" value="1" id="objective" required>
					</div>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="objective_des_input">รายละเอียดวัตถุประสงค์</label>
					<input type="text" name="objective_des" id="objective_des_input" class="so-input" placeholder="ใส่รายละเอียด">
				</div>
			</div>

			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="delivery_type">วิธีการจัดส่ง</label>
					<div class="so-select-wrapper">
						<select name="delivery_type" id="delivery_type" class="so-select">
							<option value="1" selected>Sale รับเอง</option>
							<option value="2">ช่างรับเอง</option>
							<option value="3">ลูกค้ารับเอง</option>
							<option value="4">บริษัทจัดส่ง</option>
						</select>
					</div>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="start_date">วันที่ รับ-ส่ง</label>
					<input name="start_date" type='date' id="start_date" class="so-input" />
				</div>
				<div class="so-field-group">
					<label class="so-label" for="between_date">วันที่ต้องการโดยประมาณ</label>
					<input name="between_date" class="so-input" type='text' id="between_date" />
				</div>
			</div>

			<!-- UI-only preview fields (Figma parity) — not yet read by register_supbrcshos1.php, see plan Phase B-UI -->
			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="transport_company">บริษัทขนส่ง</label>
					<div class="so-select-wrapper">
						<select id="transport_company" name="transport_company" class="so-select">
							<option value="">เลือกบริษัทขนส่ง</option>
							<option value="1">Kerry</option>
							<option value="2">Flash</option>
							<option value="3">J&amp;T</option>
							<option value="4">ไปรษณีย์ไทย</option>
						</select>
					</div>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="time_range">เลือกช่วงเวลา</label>
					<div class="so-select-wrapper">
						<select id="time_range" class="so-select">
							<option value="">เลือกช่วงเวลา</option>
							<option value="morning">ช่วงเช้า</option>
							<option value="afternoon">ช่วงบ่าย</option>
							<option value="allday">ทั้งวัน</option>
							<option value="specific">กำหนดเวลา</option>
						</select>
					</div>
				</div>
			</div>

			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="start_time">เวลา (เริ่ม)</label>
					<input id="start_time" name="start_time" class="so-input" type="text" />
				</div>
				<div class="so-field-group">
					<label class="so-label" for="end_time">เวลา (ถึง)</label>
					<input id="end_time" name="end_time" class="so-input" type="text" />
				</div>
				<div class="so-field-group">
					<label class="so-label">สถานะการทำงาน</label>
					<div style="display:flex;gap:24px;align-items:center;height:42px;">
						<label class="so-payment-radio-label"><input type='radio' name='status' id="status" value='ส่ง' checked='checked' />ส่ง</label>
						<label class="so-payment-radio-label"><input type='radio' name='status' id="status" value='รับ' />รับ</label>
					</div>
				</div>
			</div>

			<div class="so-field-group">
				<label class="so-label" for="status_comment">สถานะ</label>
				<input name="status_comment" type='text' id="status_comment" class="so-input" />
			</div>

			<div class="so-toggle-row">
				<label class="so-toggle-pill-outline-custom"><input type="checkbox" name="fix_datetime" id="fix_datetime" value="1"><span>นัดวันและเวลาเรียบร้อยแล้ว</span></label>
				<label class="so-toggle-pill-outline-custom"><input type="checkbox" id="on_time" name="on_time" value="1"><span>งานสำคัญต้องตรงเวลา</span></label>
				<label class="so-toggle-pill-outline-custom"><input type="checkbox" id="call_customer" name="call_customer" value="1"><span>โทรแจ้งลูกค้าก่อนไป</span></label>
				<label class="so-toggle-pill-outline-custom"><input type="checkbox" id="call_back" name="call_back" value="1"><span>ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว</span></label>
				<label class="so-toggle-pill-outline-custom"><input type="checkbox" id="no_money" name="no_money" value="1"><span>ไม่ต้องเก็บเงิน</span></label>
				<label class="so-toggle-pill-outline-custom"><input type="checkbox" name="want_bus" value="1"><span>ต้องการรถใหญ่</span></label>
				<!-- UI-only (Figma parity) — not yet read by register_supbrcshos1.php -->
				<label class="so-toggle-pill-outline-custom"><input type="checkbox" id="send_cs" name="send_cs" value="1"><span>ส่งข้อมูลลงระบบ CS</span></label>
			</div>

			<div class="so-payment-pair-grid">
				<div class="so-input-with-checkbox">
					<label class="so-checkbox-label"><input type="checkbox" name="cash" id="cash" value="1"> เก็บเงินสด</label>
					<input name="unit_cash" type='text' class="so-input" id="unit_cash" style="text-align:right" OnChange="JavaScript:chkNum(this)">
				</div>
				<div class="so-input-with-checkbox">
					<label class="so-checkbox-label"><input type="checkbox" name="check_paper" id="check_paper" value="1"> รับเช็ค</label>
					<input name="unit_check" type='text' class="so-input" id="unit_check" style="text-align:right" OnChange="JavaScript:chkNum(this)" />
				</div>
				<div class="so-input-with-checkbox">
					<label class="so-checkbox-label"><input type="checkbox" id="credit_card" name="credit_card" value="1"> รูดการ์ด</label>
					<input name="unit_credit" type='text' class="so-input" id="unit_credit" style="text-align:right" OnChange="JavaScript:chkNum(this)" />
				</div>
				<div class="so-input-with-checkbox">
					<label class="so-checkbox-label"><input type="checkbox" id="bill" name="bill" value="1"> วางบิล</label>
					<input name="unit_bill" type='text' class="so-input" style="text-align:right" id="unit_bill" OnChange="JavaScript:chkNum(this)" />
				</div>
				<div class="so-input-with-checkbox">
					<label class="so-checkbox-label"><input type="checkbox" name="tran" id="tran" value="1"> ลูกค้าโอนเงินหน้างาน</label>
					<input name="unit_tran" type='text' class="so-input" id="unit_tran" style="text-align:right" OnChange="JavaScript:chkNum(this)">
				</div>
				<div class="so-input-with-checkbox">
					<label class="so-checkbox-label"><input type="checkbox" id="dep" name="dep" value="1"> อื่นๆ</label>
					<input name="dept" type='text' class="so-input" id="dept" />
				</div>
			</div>
		</div>

		<script>
			// "เลือกช่วงเวลา" quick-select — UI convenience only, no name= attribute so it is
			// never submitted; just writes into the existing start_time/end_time inputs.
			(function() {
				var csTimeRangeMap = {
					morning: ['08:00', '12:00'],
					afternoon: ['13:00', '17:00'],
					allday: ['08:00', '17:00']
				};

				function csSyncTimeRange() {
					var timeRange = document.getElementById('time_range');
					var startTime = document.getElementById('start_time');
					var endTime = document.getElementById('end_time');
					if (!timeRange || !startTime || !endTime) return;
					var val = timeRange.value;
					if (csTimeRangeMap[val]) {
						startTime.value = csTimeRangeMap[val][0];
						endTime.value = csTimeRangeMap[val][1];
					} else if (val === '') {
						startTime.value = '';
						endTime.value = '';
					}
				}
				document.addEventListener('DOMContentLoaded', function() {
					var timeRange = document.getElementById('time_range');
					if (timeRange) {
						timeRange.addEventListener('change', csSyncTimeRange);
					}
				});
			})();
		</script>

		<!-- ===================== Card: ที่อยู่ ===================== -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">ที่อยู่</h2>
				<hr class="so-divider">
			</div>

			<!-- UI-only (Figma parity) — popup selection isn't wired to save yet, see plan Phase B-UI -->
			<div class="so-address-actions" style="display: flex; gap: 16px; margin-bottom: 24px;">
				<button type="button" class="so-address-action-btn so-address-action-btn-primary" onclick="csOpenShippingAddressPopup()" style="background-color: #F4E8FF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
					<i class="fas fa-search"></i> ค้นหาที่อยู่
				</button>
				<input type="hidden" name="save_to_customer_db" id="save_to_customer_db" value="0">
				<button type="button" class="so-address-action-btn so-address-action-btn-secondary" onclick="csToggleSaveToCustomerDb(this)" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
					<img src="img/icons/database.png" alt="database" style="width: 16px; height: 16px;"> เพิ่มลงฐานลูกค้า
				</button>
			</div>

			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="customer_name">ชื่อผู้ติดต่อ</label>
					<input name="customer_name" class="so-input" type='text' id="customer_name">
				</div>
				<div class="so-field-group">
					<label class="so-label" for="customer_tel">เบอร์โทรศัพท์</label>
					<input name="customer_tel" class="so-input" type='text' id="customer_tel">
				</div>
				<div class="so-field-group">
					<label class="so-label" for="province_name">จังหวัด</label>
					<div class="so-select-wrapper">
						<select name="province_name" id="province_name" class="so-select">
							<option value="">**Please Select Item**</option>
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

			<div class="so-grid-2">
				<div class="so-field-group">
					<label class="so-label" for="address_1">สถานที่ส่งสินค้า</label>
					<textarea class="so-textarea" name="address_1" id="address_1"></textarea>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="address_name">ที่อยู่ในการส่งสินค้า</label>
					<textarea class="so-textarea" name="address_name" id="address_name"></textarea>
				</div>
			</div>

			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="address_send">สถานที่ติดตั้งเครื่อง</label>
					<textarea class="so-textarea" name="address_send" id="address_send" rows="2"></textarea>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="product_sn">เลขที่เอกสาร/เลขที่เครื่อง</label>
					<textarea name="product_sn" class="so-textarea" id="product_sn" rows="2"></textarea>
				</div>
				<div class="so-field-group">
					<!-- UI-only (Figma parity) — not yet read by register_supbrcshos1.php -->
					<label class="so-label" for="location_link">Location Link</label>
					<div class="so-input-wrapper">
						<input name="location_link" type='text' id="location_link" class="so-input">
						<button type="button" class="fas fa-times so-clear-icon" onclick="var i=this.closest('.so-input-wrapper').querySelector('input'); if(i) i.value='';" aria-label="ล้างค่า"></button>
					</div>
				</div>
			</div>

			<div class="so-grid-2">
				<div class="so-field-group">
					<label class="so-label" for="product">สินค้า/เอกสาร</label>
					<textarea name="product" class="so-textarea" id="product" rows="2"></textarea>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="description">รายละเอียดเพิ่มเติม</label>
					<textarea name="description" class="so-textarea" id="description" rows="2"></textarea>
				</div>
			</div>
			<!-- UI-only (Figma parity), populated by the shipping-address popup — not yet read by register_supbrcshos1.php -->
			<input type="hidden" name="shipping_id" id="shipping_id">
		</div>

		<!-- ===================== Card: ข้อความแจ้งแผนก ===================== -->
		<!-- UI-only (Figma parity) — register_supbrcshos1.php never writes tb_comment_so/tb_comment_so_item
		     for this document type yet, see plan Phase B-UI. Reuses the same shared js/doc-tabs-dept-comment.js
		     that register_suphos.php / register_supbrhos.php use, against the same element ids. -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">ข้อความแจ้งแผนกที่เกี่ยวข้อง</h2>
				<hr class="so-divider">
			</div>

			<div style="display: flex; flex-wrap: wrap; gap: 16px; align-items: center; margin-bottom: 24px;">
				<button type="button" onclick="addDeptComment()" style="background-color: #EFEBFF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
					<img src="img/icons/add_message.png" alt="add_message" style="width: 16px; height: 16px;"> เพิ่มข้อความ
				</button>
				<button type="button" id="technician_required_btn" class="btn-technician-required" onclick="toggleTechnicianRequired(this);">
					ต้องการช่างไปตรวจรับ
				</button>
				<input type="hidden" name="technician_required" id="hidden_technician_required" value="0">
			</div>

			<div id="dept_comment_list"></div>

			<textarea name="comment_cs" id="hidden_comment_cs" style="display:none;"></textarea>
			<textarea name="comment_en" id="hidden_comment_en" style="display:none;"></textarea>
			<textarea name="comment_st" id="hidden_comment_st" style="display:none;"></textarea>
			<textarea name="comment_ad" id="hidden_comment_ad" style="display:none;"></textarea>
			<input type="hidden" name="dept_comment_items" id="hidden_dept_comment_items" value="">

			<!-- ย้ายมาจากการ์ด "ข้อมูลเอกสาร" — Figma จับคู่แท็บ "แนบไฟล์" ไว้กับการ์ด "ข้อความแจ้งแผนก" การ์ดเดียวกันพอดี -->
			<div class="so-section-title-container" style="margin-top:24px;">
				<h3 class="so-section-title" style="font-size:18px;">แนบไฟล์</h3>
				<hr class="so-divider">
			</div>
			<div class="so-field-group">
				<div class="so-file-picker-grid">
					<label class="so-file-picker" for="slip1">
						<span class="so-file-picker-text" id="slip1_text">แนบไฟล์ 1</span>
						<i class="far fa-image so-file-picker-icon"></i>
						<input type="file" name="slip1" id="slip1" class="so-file-picker-input" onchange="document.getElementById('slip1_text').textContent = this.files[0] ? this.files[0].name : 'แนบไฟล์ 1'; document.getElementById('slip1_text').classList.toggle('has-file', !!this.files[0]);">
					</label>
					<label class="so-file-picker" for="slip2">
						<span class="so-file-picker-text" id="slip2_text">แนบไฟล์ 2</span>
						<i class="far fa-image so-file-picker-icon"></i>
						<input type="file" name="slip2" id="slip2" class="so-file-picker-input" onchange="document.getElementById('slip2_text').textContent = this.files[0] ? this.files[0].name : 'แนบไฟล์ 2'; document.getElementById('slip2_text').classList.toggle('has-file', !!this.files[0]);">
					</label>
					<label class="so-file-picker" for="slip3">
						<span class="so-file-picker-text" id="slip3_text">แนบไฟล์ 3</span>
						<i class="far fa-image so-file-picker-icon"></i>
						<input type="file" name="slip3" id="slip3" class="so-file-picker-input" onchange="document.getElementById('slip3_text').textContent = this.files[0] ? this.files[0].name : 'แนบไฟล์ 3'; document.getElementById('slip3_text').classList.toggle('has-file', !!this.files[0]);">
					</label>
					<label class="so-file-picker" for="slip4">
						<span class="so-file-picker-text" id="slip4_text">แนบไฟล์ 4</span>
						<i class="far fa-image so-file-picker-icon"></i>
						<input type="file" name="slip4" id="slip4" class="so-file-picker-input" onchange="document.getElementById('slip4_text').textContent = this.files[0] ? this.files[0].name : 'แนบไฟล์ 4'; document.getElementById('slip4_text').classList.toggle('has-file', !!this.files[0]);">
					</label>
					<label class="so-file-picker" for="slip5">
						<span class="so-file-picker-text" id="slip5_text">แนบไฟล์ 5</span>
						<i class="far fa-image so-file-picker-icon"></i>
						<input type="file" name="slip5" id="slip5" class="so-file-picker-input" onchange="document.getElementById('slip5_text').textContent = this.files[0] ? this.files[0].name : 'แนบไฟล์ 5'; document.getElementById('slip5_text').classList.toggle('has-file', !!this.files[0]);">
					</label>
				</div>
			</div>
		</div>
		<script>
			const savedCommentSoForDept = null;
			const savedCommentSoItemsForDept = [];
		</script>
		<script src="js/doc-tabs-dept-comment.js?v=<?php echo filemtime(__DIR__ . '/js/doc-tabs-dept-comment.js'); ?>"></script>

		<div class="so-sticky-actions">
			<div class="so-sticky-actions-inner">
				<input type="submit" name="submit" class="btn-so-submit" value="บันทึก">
			</div>
		</div>

	</form>

</div><!-- /register-so-main -->

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