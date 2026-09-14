<?php
require_once __DIR__ . '/includes/so_saved_helpers.php';
require_once __DIR__ . '/includes/breg_repo.php';

/* ===================================================================
 * ด่านตัดสินใจก่อน head.php
 *
 * เอกสารที่พ้นขั้นร่างไปแล้วต้องแก้ที่หน้าแก้ไขเดิม — ต้อง redirect ตรงนี้
 * เพราะ head.php เริ่มพ่น HTML ทันทีที่ include ทำให้ header() ใช้ไม่ได้อีก
 * ($conn ที่ include ตรงนี้จะถูก head.php include ทับด้วยตัวใหม่อีกที
 *  ตาม convention เดียวกับ register_breg_edit.php)
 * =================================================================== */
$bregRequestedRefId = isset($_GET['ref_id']) ? trim((string)$_GET['ref_id']) : '';
if ($bregRequestedRefId !== '') {
	include __DIR__ . '/dbconnect.php';
	$bregPreloaded = breg_load_document($conn, $bregRequestedRefId);
	// เฉพาะ NBM เท่านั้นที่ยัง redirect ไปหน้าแก้ไขเดิม — AWL (type_doc=1) รวม lifecycle
	// ทั้งหมด (Draft/Request/terminal) ไว้ในหน้านี้แล้ว ไม่ว่าจะอยู่สถานะไหน
	if ($bregPreloaded !== null && (string)$bregPreloaded['type_doc'] !== '1') {
		header('Location: register_breg_edit.php?ref_id=' . urlencode($bregPreloaded['ref_id']));
		exit();
	}
	$bregDocumentMissing = ($bregPreloaded === null);
}
?>
<?php include("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-supbrcshos.css?v=<?php echo filemtime(__DIR__ . '/css/register-supbrcshos.css'); ?>">
<link rel="stylesheet" href="css/register-bregawl.css?v=<?php echo filemtime(__DIR__ . '/css/register-bregawl.css'); ?>">
<script src="js/customer-popup.js?v=<?php echo filemtime(__DIR__ . '/js/customer-popup.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
date_default_timezone_set("Asia/Bangkok");

/* ===================================================================
 * โหมดของหน้า
 *   - ไม่มี ref_id            → สร้างใบใหม่ (เลขที่แสดงเป็นเลขคาดการณ์ จองจริงตอนบันทึก)
 *   - ref_id ของใบ Draft      → เปิดร่างเดิมกลับมาแก้ เลขไม่เปลี่ยน
 *   - ref_id ของใบที่ไม่ใช่ Draft → ถูก redirect ไปหน้าแก้ไขเดิมตั้งแต่ก่อน head.php แล้ว
 *
 * โหลดซ้ำด้วย $conn ตัวที่ head.php เพิ่ง include มา (ตัวก่อนหน้าถูกทิ้งไปแล้ว)
 * =================================================================== */
$savedBreg = null;
$bregSavedItems1 = array();
$bregSavedItems2 = array();
$bregDocumentLogRows = array();

if ($bregRequestedRefId !== '') {
	if (!empty($bregDocumentMissing)) {
		echo '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red" style="max-width:1096px;margin:24px auto;">'
			. '<p>ไม่พบเอกสารเลขที่ ' . so_saved_h($bregRequestedRefId) . '</p></div>';
		include 'foot.php';
		exit();
	}

	$savedBreg = breg_load_document($conn, $bregRequestedRefId);

	// กันกรณีมีคน Submit/ส่งอนุมัติแซงระหว่างที่หน้ากำลังโหลด (race กับ head.php ที่ include $conn ใหม่)
	if ($savedBreg === null) {
		echo '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red" style="max-width:1096px;margin:24px auto;">'
			. '<p>ไม่พบเอกสารเลขที่ ' . so_saved_h($bregRequestedRefId) . '</p></div>';
		include 'foot.php';
		exit();
	}
	if ((string)$savedBreg['type_doc'] !== '1') {
		header('Location: register_breg_edit.php?ref_id=' . urlencode($savedBreg['ref_id']));
		exit();
	}

	$bregSavedItems1 = breg_load_items($conn, $savedBreg['ref_id'], 1);
	$bregSavedItems2 = breg_load_items($conn, $savedBreg['ref_id'], 2);
	$bregDocumentLogRows = breg_load_status_log($conn, $savedBreg['ref_id']);
}

$bregIsDraftMode = ($savedBreg !== null);
$bregDisplayRefId = $bregIsDraftMode ? $savedBreg['ref_id'] : breg_peek_next_ref_id($conn);

/* ===================================================================
 * สถานะ lifecycle ของเอกสาร — คำนวณจาก (status_doc, send_sup, send_dm) ล้วน ๆ
 * ไม่มี state พิเศษอื่นแอบแฝง (Pending Sup ครั้งแรก กับ DM ส่งกลับ ใช้ flags ชุดเดียวกัน
 * โดยตั้งใจ — แยกกันได้จาก audit log เท่านั้น ไม่กระทบพฤติกรรม/สิทธิ์ของหน้านี้)
 * ใช้ตัดสินว่าจะโชว์ปุ่มไหน — ฝั่ง server (register_bregawl_edit1.php/breg_repo.php)
 * ตรวจซ้ำทุก action เสมอ ไม่พึ่งการซ่อนปุ่มพวกนี้เป็น authorization
 * =================================================================== */
$bregStatusDoc = $bregIsDraftMode ? (string)$savedBreg['status_doc'] : 'Draft';
$bregSendSup = $bregIsDraftMode ? (string)$savedBreg['send_sup'] : '0';
$bregSendDm = $bregIsDraftMode ? (string)$savedBreg['send_dm'] : '0';
$bregIsTerminal = breg_is_terminal_status($bregStatusDoc);
$bregUserType = $_SESSION['type_login'] ?? '';
$bregIsSupStage = ($bregStatusDoc === 'Request' && $bregSendSup === '1' && $bregSendDm === '0');
$bregIsDmStage = ($bregStatusDoc === 'Request' && $bregSendSup === '1' && $bregSendDm === '1');
$bregCanShowSupBar = $bregIsDraftMode && $bregIsSupStage && $bregUserType === 'Sup_Sale';
$bregCanShowDmBar = $bregIsDraftMode && $bregIsDmStage && $bregUserType === 'AllWell';
// Submit ใช้ได้กับใบใหม่, Draft, และใบที่ Sup ส่งกลับ (Request/0/0) เท่านั้น
$bregCanSubmit = !$bregIsTerminal && !$bregIsSupStage && !$bregIsDmStage;
$bregCanUpdate = !$bregIsTerminal;
$bregCanCancelDoc = $bregIsDraftMode && !$bregIsTerminal;

$bregTypeProductOptions = breg_type_product_options($conn);

/* ช่างประกอบ — ชื่อจาก tb_team_en.sale_name (ฐาน `sale` ผ่าน $com) เก็บลง hos__breg.name_eng
   เป็น "ชื่อ" ไม่ใช่รหัส เพราะคอลัมน์เดิมและใบพิมพ์ (from_breg.php) แสดงชื่อโดยตรง */
$bregEngineerNames = array();
$bregEngineerQuery = @mysqli_query($com, "SELECT sale_code, sale_name FROM tb_team_en ORDER BY sale_code ASC");
if ($bregEngineerQuery) {
	while ($bregEngineerRow = mysqli_fetch_assoc($bregEngineerQuery)) {
		$name = trim((string)$bregEngineerRow['sale_name']);
		if ($name !== '' && !in_array($name, $bregEngineerNames, true)) {
			$bregEngineerNames[] = $name;
		}
	}
}

/* แผนก/เขตการขาย — ตัวเลือกตาม $_SESSION['code'] ชุดเดียวกับ register_suphos.php:2004-2013 */
$bregSaleCodeQueries = array(
	'SS1'    => "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC",
	'SS2'    => "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC",
	'SS3'    => "SELECT * FROM tb_team_ss3 WHERE ckk_1='0' ORDER BY sale_code ASC",
	'SS5'    => "SELECT * FROM tb_team_ss3 WHERE sale_code IN ('S31','S32') ORDER BY sale_code ASC",
	'SUP_MK' => "SELECT * FROM tb_team_adm WHERE ckk='1' ORDER BY sale_code ASC",
	'SUP_EN' => "SELECT * FROM tb_team_en ORDER BY sale_code ASC",
);
$bregUserSaleCode = isset($_SESSION['code']) ? $_SESSION['code'] : '';
$bregSaleCodeSql = isset($bregSaleCodeQueries[$bregUserSaleCode])
	? $bregSaleCodeQueries[$bregUserSaleCode]
	: "SELECT * FROM tb_team_adm WHERE ckk='0' ORDER BY sale_code ASC";
$bregSaleCodeQuery = mysqli_query($com, $bregSaleCodeSql);
$bregSaleCodeOptions = array();
if ($bregSaleCodeQuery) {
	while ($bregSaleCodeRow = mysqli_fetch_assoc($bregSaleCodeQuery)) {
		$bregSaleCodeOptions[] = $bregSaleCodeRow;
	}
}
$bregSelectedSaleCode = $bregIsDraftMode ? (string)$savedBreg['sale_code'] : $bregUserSaleCode;

/* ค่าตั้งต้นของส่วนช่าง */
$bregProCome = $bregIsDraftMode ? ((string)$savedBreg['pro_come'] === '1') : false;
$bregProComeDate = $bregIsDraftMode ? so_saved_iso_date_input($savedBreg['pro_comedate']) : '';
$bregBrdocEng = $bregIsDraftMode ? ((string)$savedBreg['brdoc_eng'] === '1') : false;
$bregNameEng = $bregIsDraftMode ? (string)$savedBreg['name_eng'] : '';
$bregDateBrdoc = $bregIsDraftMode ? so_saved_iso_date_input($savedBreg['date_brdoc']) : '';
?>

<?php if (isset($_GET['saved']) && $_GET['saved'] === '1') { ?>
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

<!-- ===================== ดึงรายละเอียดลูกค้าจากรหัสที่เลือก =====================
     ใช้ data_bill_name1.php ตัวเดิมของหน้านี้ (ตอบกลับเป็น pipe-delimited 29 ช่อง)
     ไม่มีการแก้ backend — เพิ่มแค่การอ่านช่องที่ endpoint ส่งมาอยู่แล้วแต่ UI เดิมทิ้ง -->
<script language="JavaScript">
	function bregSetText(id, value) {
		var el = document.getElementById(id);
		if (el) el.textContent = (value === null || value === undefined || String(value).trim() === '') ? '-' : String(value);
	}

	function bregSetValue(id, value) {
		var el = document.getElementById(id);
		if (el) el.value = (value === null || value === undefined) ? '' : String(value);
	}

	/* สถานะลูกค้า = "รหัสสมาชิก - เกรด" — status_cus: 0=Gold, 1=Platinum, 2=Diamond
	   ค่า status_cus ที่ไม่ครบ/ไม่รู้จักถือว่าไม่มีสถานะ แสดง "-" ทั้งช่อง */
	function bregFormatCustomerStatus(customerNo, statusCus) {
		var statusLabels = { '0': 'Gold', '1': 'Platinum', '2': 'Diamond' };
		var label = statusLabels[String(statusCus === undefined || statusCus === null ? '' : statusCus).trim()];
		if (!label) return '-';
		var no = String(customerNo === undefined || customerNo === null ? '' : customerNo).trim();
		return (no !== '' ? no : '-') + ' - ' + label;
	}

	function bregFormatMoney(value) {
		var number = Number(value || 0);
		if (!isFinite(number)) number = 0;
		return number.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	}

	/* ปุ่มเครดิตเทอมยังต้องมองเห็นเสมอ (ต่างจาก .is-empty ของหน้า SO ที่ซ่อนทั้งปุ่ม) —
	   ไม่มีข้อมูลเครดิตต้องยังเห็น "-" และกดไม่ได้ ตาม handoff */
	function bregUpdateCreditTermTrigger(creditThb) {
		var raw = String(creditThb === undefined || creditThb === null ? '' : creditThb).trim();
		var amount = raw === '' ? NaN : Number(raw.replace(/,/g, ''));
		var hasCreditTerm = raw !== '' && !isNaN(amount);

		bregSetText('display_credit_thb', hasCreditTerm ? bregFormatMoney(amount) : '');

		var trigger = document.getElementById('display_credit_thb_trigger');
		if (trigger) {
			trigger.classList.toggle('is-empty', !hasCreditTerm);
			trigger.disabled = !hasCreditTerm;
			trigger.setAttribute('aria-disabled', hasCreditTerm ? 'false' : 'true');
		}
	}

	function bregResetCreditTermTrigger() {
		bregUpdateCreditTermTrigger('');
	}

	var bregCustomerRequestToken = 0;

	function bregLoadCustomerDetail(customerId) {
		customerId = String(customerId || '').trim();
		if (customerId === '') return;

		var requestToken = ++bregCustomerRequestToken;
 
		var request = new XMLHttpRequest();
		request.open('POST', 'data_bill_name1.php', true);
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.onreadystatechange = function() {
			if (request.readyState !== 4) return;
			// ผู้ใช้เปลี่ยนลูกค้าไปแล้วระหว่างรอ response ของคำขอนี้ — ทิ้งผลลัพธ์เก่า
			if (requestToken !== bregCustomerRequestToken) return;

			if (request.status !== 200 || request.responseText.trim() === '') {
				bregNotify('ไม่พบข้อมูลลูกค้า', 'ไม่พบรายละเอียดของรหัสลูกค้า ' + customerId, 'warning');
				bregResetCreditTermTrigger();
				return;
			}

			var f = request.responseText.split('|');
			// ลำดับช่องตาม data_bill_name1.php: 0 bill_name, 4 customer_no, 5 cus_tel,
			// 22 ประเภทลูกค้า, 24 credit_thb, 25 vip_ckk, 26 customer_code (รหัส AWL), 28 status_cus
			bregSetValue('customer_name', f[0] || '');
			bregSetText('display_bill_id', f[26] || '');
			bregSetText('display_bill_tel', f[5] || '');
			bregSetText('display_customer_status', bregFormatCustomerStatus(f[4], f[28]));
			bregSetText('display_bill_name', f[0] || '');
			bregSetText('display_customer_typename', f[22] || '');
			bregUpdateCreditTermTrigger(f[24] || '');

			var vipIcon = document.getElementById('display_vip_icon');
			if (vipIcon) vipIcon.style.display = (String(f[25]).trim() === '1') ? '' : 'none';
		};
		request.send('bill_id=' + encodeURIComponent(customerId));
	}

	/* popup ลูกค้า (js/customer-popup.js + ajax_customer_popup_search.php) เป็นตัวกลางเดียวกับ
	   ที่หน้า SO/CS/CH ใช้ — หน้านี้แค่ผูก callback ให้เขียนค่าลง bill_id ของ BREG */
	window.customerPopupOnConfirm = function(selectedCustomer) {
		selectedCustomer = selectedCustomer || {};
		var customerId = String(selectedCustomer.customer_id || '').trim();
		if (customerId === '') return;

		bregSetValue('bill_id', customerId);
		bregSetValue('h_bill_id', customerId);
		bregLoadCustomerDetail(customerId);
	};

</script>

<form action="<?php echo $bregIsDraftMode ? 'register_bregawl_edit1.php' : 'register_breg1.php'; ?>" method="post" name="frmMain" id="frmMain" onSubmit="JavaScript:return fncSubmit();">
	<!-- ธงบอก register_breg1.php ให้ใช้เส้นทางบันทึกแบบใหม่ (dynamic rows + transaction) — ใช้เฉพาะตอนสร้างใบใหม่
	     (เอกสารที่มีอยู่แล้วส่งไป register_bregawl_edit1.php ทั้งหมด) ฟอร์มเดิม (register_bregnbm.php)
	     ไม่มีธงนี้ จึงยังวิ่งเส้นทาง legacy เหมือนเดิม -->
	<input type="hidden" name="breg_mode" value="v2">
	<!-- native form.submit() ไม่ส่ง name/value ของปุ่ม submit จึงต้องเก็บ action แยกไว้ -->
	<input type="hidden" name="submit" id="breg_submit_action" value="">
	<?php if ($bregIsDraftMode) { ?>
		<input type="hidden" name="ref_id" id="ref_id" value="<?php echo so_saved_h($savedBreg['ref_id']); ?>">
	<?php } else { ?>
		<!-- ใบใหม่ยังไม่มีเลขจริง — เลขถูกจองตอนกดบันทึกครั้งแรกเท่านั้น
		     ส่งค่าว่างไปเพื่อให้ตัวบันทึกรู้ว่าเป็นการสร้างใหม่ และให้ Preview มีเลขไว้แสดง -->
		<input type="hidden" name="ref_id" id="ref_id" value="">
		<input type="hidden" name="ref_id_preview" id="ref_id_preview" value="<?php echo so_saved_h($bregDisplayRefId); ?>">
	<?php } ?>

	<div class="w3-container breg-layout">

		<div class="so-header-container">
			<div class="so-header-left">
				<h1 class="so-title breg-title">ใบขอเบิกอะไหล่จากสินค้าขาย (BREG)</h1>
				<div class="so-ref-info">
					<span class="so-ref-label">เลขที่อ้างอิง</span>
					<span class="so-ref-value"><?php echo so_saved_h($bregDisplayRefId); ?></span>
				</div>
			</div>
			<div class="so-header-right">
				<button type="button" class="btn-preview-so" onclick="bregOpenPreview();">
					<img src="img/icons/preview.png" alt="preview" style="width:16px;height:16px;"> Preview
				</button>
			</div>
		</div>

		<?php
		$bregLatestReasonTitleMap = array(
			'Sup Returned' => 'เหตุผลในการส่งกลับ',
			'DM Returned'  => 'เหตุผลในการส่งกลับ',
			'Sup Rejected' => 'เหตุผลที่ไม่อนุมัติ',
			'DM Rejected'  => 'เหตุผลที่ไม่อนุมัติ',
			'Cancelled'    => 'เหตุผลในการยกเลิก',
		);
		$bregLatestReason = $bregDocumentLogRows[0] ?? null;
		$bregLatestReasonStatus = trim((string)($bregLatestReason['status_doc'] ?? ''));
		$bregLatestReasonText = trim((string)($bregLatestReason['reason'] ?? ''));
		$bregLatestReasonTitle = $bregLatestReasonTitleMap[$bregLatestReasonStatus] ?? '';
		$bregLatestReasonClass = breg_document_return_status_class($bregLatestReasonStatus);
		?>
		<?php if ($bregIsDraftMode && $bregLatestReasonTitle !== '' && $bregLatestReasonText !== '') { ?>
			<div class="so-latest-reason-banner <?php echo so_saved_h($bregLatestReasonClass); ?>" role="status" style="margin-bottom:16px;">
				<button type="button" class="so-latest-reason-close" aria-label="ปิด" onclick="this.closest('.so-latest-reason-banner').style.display='none';">&times;</button>
				<div class="so-latest-reason-title"><?php echo so_saved_h($bregLatestReasonTitle); ?></div>
				<div class="so-latest-reason-text"><?php echo nl2br(so_saved_h($bregLatestReasonText)); ?></div>
			</div>
		<?php } ?>

		<!-- ===================== การ์ด: ข้อมูลเอกสาร ===================== -->
		<div class="so-card breg-document-card">
			<div class="breg-document-grid breg-document-company-row">
				<div class="so-field-group">
					<label class="so-label" for="type_doc_select">บริษัท<span style="color:red;">*</span></label>
					<div class="so-select-wrapper">
						<select class="so-select" name="type_doc" id="type_doc_select">
							<option value="1" <?php echo !$bregIsDraftMode || (int)$savedBreg['type_doc'] === 1 ? 'selected' : ''; ?>>AWL</option>
							<option value="2" <?php echo $bregIsDraftMode && (int)$savedBreg['type_doc'] === 2 ? 'selected' : ''; ?>>NBM</option>
						</select>
					</div>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="sale_code">แผนก/เขตการขาย</label>
					<div class="so-select-wrapper">
						<select name="sale_code" id="sale_code" class="so-select">
							<option value="">Select</option>
							<?php foreach ($bregSaleCodeOptions as $bregOption) { ?>
								<option value="<?php echo so_saved_h($bregOption['sale_code']); ?>" <?php echo (string)$bregOption['sale_code'] === (string)$bregSelectedSaleCode ? 'selected' : ''; ?>><?php echo so_saved_h($bregOption['sale_code'] . ' - ' . $bregOption['sale_name']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="so-section-title-container">
				<h2 class="so-section-title">ข้อมูลเอกสาร</h2>
				<hr class="so-divider">
			</div>

			<div class="breg-document-grid">
				<div class="so-field-group">
					<label class="so-label" for="cm_no">เลขที่ใบงานบริการ <span style="color:red;">*</span></label>
					<div class="so-input-wrapper">
						<input type="text" name="cm_no" id="cm_no" class="so-input" placeholder="เลขที่อ้างอิง"
							value="<?php echo $bregIsDraftMode ? so_saved_h($savedBreg['cm_no']) : ''; ?>">
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="per_no">เลขที่ PER <span style="color:red;">*</span></label>
					<div class="so-input-wrapper">
						<input type="text" name="per_no" id="per_no" class="so-input" placeholder="ระบุเลขที่ PER"
							value="<?php echo $bregIsDraftMode ? so_saved_h($savedBreg['per_no']) : ''; ?>">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('per_no').value='';" aria-label="ล้างค่า"></button>
					</div>
				</div>
			</div>

		</div>

		<!-- ===================== การ์ด: ข้อมูลลูกค้า ===================== -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">ข้อมูลลูกค้า</h2>
				<hr class="so-divider">
			</div>

			<div class="so-customer-top-grid">
				<div class="so-customer-top-left">
					<div class="so-customer-pills-row">
						<button type="button" class="btn-add-customer-pill" onclick="openCustomerPopup();">
							<img src="img/icons/add_user.png" alt="add_user" style="width:23px;"> ข้อมูลลูกค้า
						</button>
					</div>

					<!-- เก็บข้อมูลลูกค้าที่เลือกไว้สำหรับบันทึก โดยไม่แสดงเป็นฟิลด์ซ้ำกับการ์ดข้อมูลลูกค้า -->
					<input type="hidden" name="customer_name" id="customer_name"
						value="<?php echo $bregIsDraftMode ? so_saved_h($savedBreg['customer_name']) : ''; ?>">
					<!-- bill_id = tb_customer.customer_id ตรงกับที่ hos__breg.bill_id เก็บอยู่เดิม -->
					<input type="hidden" name="bill_id" id="bill_id" value="<?php echo $bregIsDraftMode ? so_saved_h($savedBreg['bill_id']) : ''; ?>">
					<input type="hidden" name="h_bill_id" id="h_bill_id" value="<?php echo $bregIsDraftMode ? so_saved_h($savedBreg['bill_id']) : ''; ?>">
				</div>

				<div class="so-customer-top-right">
					<div class="so-field-group" style="height:100%;margin-bottom:0;">
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
										<img src="img/icons/vip.png" class="cidc-status-icon" id="display_vip_icon" alt="VIP" style="display:none;">
										<span id="display_customer_status" class="cidc-display-text"></span>
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
										<button type="button" class="credit-term-trigger is-empty" id="display_credit_thb_trigger" aria-haspopup="dialog" aria-controls="bregCreditTermModal" aria-disabled="true" disabled>
											<span id="display_credit_thb" class="credit-term-trigger-text">-</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<!-- ===================== การ์ด: วัตถุประสงค์การเบิก ===================== -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">วัตถุประสงค์การเบิก</h2>
				<hr class="so-divider">
			</div>
			<div class="so-field-group" style="margin-bottom:0;">
				<label class="so-label" for="description">วัตถุประสงค์การเบิก <span style="color:red;">*</span></label>
				<input type="text" name="description" id="description" class="so-input" placeholder="ระบุวัตถุประสงค์การเบิก" value="<?php echo $bregIsDraftMode ? so_saved_h($savedBreg['description']) : ''; ?>">
			</div>
		</div>

		<!-- ===================== การ์ด: รายการอะไหล่ ===================== -->
		<div class="so-card breg-items-card">
			<div class="so-section-title-container breg-items-header">
				<h2 class="so-section-title" id="breg_group_title">รายการอะไหล่</h2>
				<span class="breg-group-count" id="breg_count_g1">0 รายการ</span>
				<span class="breg-group-count" id="breg_count_g2" style="display:none;">0 รายการ</span>
			</div>
			<hr class="so-divider">

			<div class="breg-qty-box" id="breg_qty_box_g1">
				<span class="breg-qty-label">จำนวนรวม(ชิ้น)</span>
				<span class="breg-qty-value" id="breg_qty_g1">0</span>
			</div>
			<div class="breg-qty-box" id="breg_qty_box_g2" style="display:none;">
				<span class="breg-qty-label">จำนวนรวม(ชิ้น)</span>
				<span class="breg-qty-value" id="breg_qty_g2">0</span>
			</div>

			<?php include __DIR__ . '/partials/breg_item_tables.php'; ?>
		</div>

		<!-- ===================== การ์ด: สำหรับช่าง ===================== -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">สำหรับช่าง</h2>
				<hr class="so-divider">
			</div>

			<div class="breg-eng-grid">
				<label class="breg-eng-check<?php echo $bregProCome ? ' is-active' : ''; ?>" id="breg_pro_come_label">
					<input type="checkbox" name="pro_come" id="pro_come" value="1" <?php echo $bregProCome ? 'checked' : ''; ?> onchange="bregSyncEngineerSection();">
					<span>รับเข้าอะไหล่</span>
				</label>
				<div class="so-field-group breg-eng-field">
					<label class="so-label" for="pro_comedate">วันที่รับเข้า</label>
					<input type="date" name="pro_comedate" id="pro_comedate" class="so-input" value="<?php echo so_saved_h($bregProComeDate); ?>" onchange="bregSyncEngineerSection();">
				</div>
				<div class="breg-eng-spacer" aria-hidden="true"></div>

				<label class="breg-eng-check<?php echo $bregBrdocEng ? ' is-active' : ''; ?>" id="breg_brdoc_eng_label">
					<input type="checkbox" name="brdoc_eng" id="brdoc_eng" value="1" <?php echo $bregBrdocEng ? 'checked' : ''; ?> onchange="bregSyncEngineerSection();">
					<span>ประกอบเรียบร้อย</span>
				</label>
				<div class="so-field-group breg-eng-field">
					<label class="so-label" for="date_brdoc">วันที่ประกอบ</label>
					<input type="date" name="date_brdoc" id="date_brdoc" class="so-input" value="<?php echo so_saved_h($bregDateBrdoc); ?>" onchange="bregSyncEngineerSection();">
				</div>
				<div class="so-field-group breg-eng-field">
					<label class="so-label" for="name_eng">ช่าง</label>
					<div class="so-select-wrapper">
						<select name="name_eng" id="name_eng" class="so-select">
							<option value="">Select</option>
							<?php
							$bregEngineerListForRender = $bregEngineerNames;
							// ชื่อช่างที่บันทึกไว้แต่ไม่อยู่ในข้อมูลหลักแล้ว ยังต้องแสดงอยู่ ไม่ให้ค่าหายตอนบันทึกซ้ำ
							if ($bregNameEng !== '' && !in_array($bregNameEng, $bregEngineerListForRender, true)) {
								array_unshift($bregEngineerListForRender, $bregNameEng);
							}
							foreach ($bregEngineerListForRender as $bregEngineerName) {
							?>
								<option value="<?php echo so_saved_h($bregEngineerName); ?>" <?php echo ($bregEngineerName === $bregNameEng) ? 'selected' : ''; ?>>
									<?php echo so_saved_h($bregEngineerName); ?>
								</option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<?php
		$bregDocumentLogRowsForTabs = array();
		foreach ($bregDocumentLogRows as $bregDocumentLogRow) {
			$bregDocumentLogRowsForTabs[] = array(
				'status_label' => breg_document_return_status_label($bregDocumentLogRow['status_doc'] ?? ''),
				'status_class' => breg_document_return_status_class($bregDocumentLogRow['status_doc'] ?? ''),
				'reason'       => $bregDocumentLogRow['reason'] ?? '',
				'user_name'    => $bregDocumentLogRow['user_name'] ?? '',
				'created_at'   => breg_format_document_log_datetime($bregDocumentLogRow['created_at'] ?? ''),
			);
		}

		$docTabsCard = array(
			'open_fn' => 'bregOpen3Tab',
			'document_return_log' => array(
				'enabled' => true,
				'rows' => $bregDocumentLogRowsForTabs,
				'empty_text' => 'ยังไม่มีรายการส่งกลับเอกสาร',
			),
		);
		include __DIR__ . '/partials/doc_tabs_card.php';
		?>
	</div>

	<div class="so-sticky-actions">
		<div class="so-sticky-actions-inner">
			<?php if ($bregCanShowSupBar || $bregCanShowDmBar) { ?>
				<!-- ค่าปุ่มอนุมัติต้องมากับ hidden ไม่ใช่ value ของ <button> เพราะ return/reject/cancel
				     ส่ง form.submit() แบบ programmatic ซึ่งไม่ส่ง name/value ของปุ่มที่กดไปด้วย -->
				<input type="hidden" name="approve_action" id="breg_approve_action" value="">
				<input type="hidden" name="breg_approve_reason" id="breg_approve_reason" value="">
				<input type="hidden" name="cancel_doc" id="breg_cancel_doc" value="">
				<div class="so-approve-actions">
					<button type="button" class="so-overflow-menu-trigger" id="btn_breg_approve_overflow" onclick="bregToggleApproveOverflowMenu()">
						<i class="fas fa-ellipsis-v"></i>
					</button>
					<div id="bregApproveOverflowMenu" class="so-overflow-menu">
						<button type="button" onclick="bregRunApproveAction('return', true)" style="color:#FF830F;"><img src="img/icons/send_back.png" alt="" style="width:20px;height:20px;"> ส่งกลับ</button>
						<button type="button" class="so-menu-danger" onclick="bregRunApproveAction('reject', true)" style="color:#FF0000;"><img src="img/icons/reject.png" alt="" style="width:20px;height:20px;"> ไม่อนุมัติ</button>
						<button type="button" onclick="bregTriggerCancelDoc()"><img src="img/icons/cancel_document.png" alt="" style="width:20px;height:20px;"> ยกเลิกเอกสาร</button>
					</div>
					<button type="button" class="btn-so-approve" onclick="bregRunApproveAction('approve', false)"><i class="far fa-check-circle"></i> อนุมัติ</button>
					<button type="button" name="save_draft" class="btn-so-draft" onclick="bregSaveDraft();"><i class="far fa-save"></i> Update</button>
				</div>
			<?php } else { ?>
				<input type="hidden" name="breg_approve_reason" id="breg_approve_reason" value="">
				<input type="hidden" name="cancel_doc" id="breg_cancel_doc" value="">
				<?php if ($bregCanSubmit) { ?>
					<button type="submit" name="submit" id="btn_submit_form" value="submit" class="btn-so-submit"><i class="fas fa-paper-plane"></i> Submit</button>
				<?php } ?>
				<?php if ($bregCanUpdate) { ?>
					<button type="button" name="save_draft" class="btn-so-draft" onclick="bregSaveDraft();"><i class="far fa-save"></i> <?php echo $bregIsDraftMode ? 'Update' : 'Save Draft'; ?></button>
				<?php } ?>
			<?php } ?>
			<button type="button" class="btn-so-cancel-nav" onclick="window.location.href='status_engbreg.php';">ย้อนกลับ</button>
		</div>
	</div>
	<?php if ($bregIsTerminal) { ?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var form = document.forms.frmMain;
				if (!form) return;
				Array.prototype.forEach.call(form.querySelectorAll('input, select, textarea, button'), function(el) {
					if (el.type === 'hidden') return;
					if (el.classList.contains('btn-so-cancel-nav')) return;
					el.disabled = true;
				});
			});
		</script>
	<?php } ?>
</form>

<!-- ===================== Popup รายชื่อลูกค้า (js/customer-popup.js) ===================== -->
<div id="customerPopupModal" class="customer-popup-modal" aria-hidden="true" style="display:none;">
	<div class="customer-popup-box" role="dialog" aria-modal="true" aria-labelledby="customerPopupTitle">
		<button type="button" class="customer-popup-close" onclick="closeCustomerPopup()" aria-label="Close">&times;</button>

		<div class="customer-popup-header">
			<h2 id="customerPopupTitle">ข้อมูลลูกค้า</h2>
			<div class="customer-popup-toolbar" style="margin-top:18px;">
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

<!-- ===================== Popup เครดิตเทอม (อ่านอย่างเดียว) =====================
     ต่างจาก js/credit-term-modal.js ที่ใช้ในหน้า SO/CS/CH ตรงที่หน้านี้ไม่มี workflow
     บันทึกประวัติติดตาม — ดึงข้อมูลจาก ajax_credit_term_modal.php ตัวเดิม (อ่านอย่างเดียว) -->
<div id="bregCreditTermModal" class="customer-popup-modal" aria-hidden="true" style="display:none;">
	<div class="customer-popup-box breg-credit-term-popup-box" role="dialog" aria-modal="true" aria-labelledby="bregCreditTermTitle">
		<button type="button" class="customer-popup-close" onclick="bregCloseCreditTermModal()" aria-label="Close">&times;</button>

		<div class="clear-loan-header">
			<h2 id="bregCreditTermTitle">เครดิตเทอม</h2>
		</div>

		<div class="credit-term-popup-content">
			<div class="credit-term-summary">
				<div class="credit-term-summary-item">
					<p class="credit-term-summary-label">เครดิต (วัน)</p>
					<p class="credit-term-summary-value" id="bregCreditSummaryDay">-</p>
				</div>
				<div class="credit-term-summary-item">
					<p class="credit-term-summary-label">เครดิต (ยอดเงิน)</p>
					<p class="credit-term-summary-value" id="bregCreditSummaryAmount">0.00</p>
				</div>
				<div class="credit-term-summary-item">
					<p class="credit-term-summary-label">ยอดรวมหนี้คงค้าง</p>
					<p class="credit-term-summary-value" id="bregCreditSummaryOutstanding">0.00</p>
				</div>
				<div class="credit-term-summary-item is-highlight">
					<p class="credit-term-summary-label">ยอดเครดิตคงเหลือ</p>
					<p class="credit-term-summary-value" id="bregCreditSummaryRemaining">0.00</p>
				</div>
			</div>

			<div class="credit-term-table-panel">
				<div class="credit-term-table-wrap">
					<table class="breg-credit-term-table">
						<thead>
							<tr>
								<th scope="col">เลขที่ใบสั่งขาย</th>
								<th scope="col">ยอดที่ต้องชำระ</th>
								<th scope="col">ยอดชำระแล้ว</th>
								<th scope="col">ยอดหนี้คงค้าง</th>
							</tr>
						</thead>
						<tbody id="bregCreditTermTableBody">
							<tr class="credit-term-empty-row">
								<td colspan="4">เลือกลูกค้าแล้วกดเปิดเครดิตเทอมเพื่อดูข้อมูล</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script language="JavaScript">
	var bregSubmitting = false; // กันกดซ้ำระหว่างรอบันทึก

	/* ===================== แถบอนุมัติ Sup/DM (ported จาก register_supchange.php:2007-2145) ===================== */
	function bregToggleApproveOverflowMenu() {
		var menu = document.getElementById('bregApproveOverflowMenu');
		if (!menu) return;
		menu.style.display = (menu.style.display === 'none' || !menu.style.display) ? 'block' : 'none';
	}

	document.addEventListener('click', function(e) {
		var menu = document.getElementById('bregApproveOverflowMenu');
		var trigger = document.getElementById('btn_breg_approve_overflow');
		if (!menu || menu.style.display === 'none' || !menu.style.display) return;
		if (e.target === trigger || (trigger && trigger.contains(e.target))) return;
		if (!menu.contains(e.target)) menu.style.display = 'none';
	});

	// เปิด popup ให้กรอกเหตุผล (ส่งกลับ/ไม่อนุมัติ/ยกเลิก) — ห้าม submit ถ้าเหตุผลว่าง
	function bregOpenReasonPopup(opts) {
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

	// อนุมัติ / ส่งกลับ / ไม่อนุมัติ — เซ็ต hidden approve_action แล้วส่งฟอร์มไป register_bregawl_edit1.php
	// ส่งกลับ/ไม่อนุมัติ ข้าม validation ได้ (บังคับเหตุผลแทน) ส่วนอนุมัติต้องผ่าน fncSubmit() ตามปกติ
	function bregRunApproveAction(action, skipValidation) {
		var field = document.getElementById('breg_approve_action');

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
			}[action];
			if (!reasonConfig) return;

			bregOpenReasonPopup(Object.assign({}, reasonConfig, {
				onConfirm: function(reason) {
					if (bregSubmitting) return;
					bregSubmitting = true; // เส้นทางนี้ไม่ผ่าน fncSubmit จึงต้องตั้งธงเอง
					if (field) field.value = action;
					var reasonField = document.getElementById('breg_approve_reason');
					if (reasonField) reasonField.value = reason;
					bregWithEngineerFieldsEnabled(function() {
						HTMLFormElement.prototype.submit.call(document.forms.frmMain);
					});
				}
			}));
			return;
		}

		if (field) field.value = action;
		fncSubmit();
		// fncSubmit() คืนค่า false ทั้งกรณีสำเร็จและ validation ไม่ผ่าน จึงดูจากธง bregSubmitting แทน
		if (!bregSubmitting && field) field.value = '';
	}

	// ยกเลิกเอกสาร — ทุกบทบาทที่เปิดเอกสารได้ทำได้ (ปุ่มในแถบอนุมัติ หรือปุ่มแยกเมื่อไม่มีแถบอนุมัติ)
	function bregTriggerCancelDoc() {
		bregOpenReasonPopup({
			title: 'ยกเลิกเอกสารนี้ ?',
			subtitleText: 'ต้องการยกเลิกเอกสารเลขที่',
			label: 'ระบุเหตุผลในการยกเลิก',
			placeholder: 'ระบุเหตุผลในการยกเลิก',
			iconBg: '#F4F5F7',
			iconSrc: 'img/icons/cancel_document.png',
			onConfirm: function(reason) {
				if (bregSubmitting) return;
				bregSubmitting = true;
				var cancelInput = document.getElementById('breg_cancel_doc');
				var reasonField = document.getElementById('breg_approve_reason');
				var actionField = document.getElementById('breg_approve_action');
				if (cancelInput) cancelInput.value = '1';
				if (reasonField) reasonField.value = reason;
				if (actionField) actionField.value = '';
				bregWithEngineerFieldsEnabled(function() {
					HTMLFormElement.prototype.submit.call(document.forms.frmMain);
				});
			}
		});
	}

	function bregSyncGroupSwitchUi() {
		document.querySelectorAll('#breg_group_switch .so-radio-label').forEach(function(label) {
			var input = label.querySelector('input[type="radio"]');
			label.classList.toggle('is-active', !!(input && input.checked));
		});
	}

	/* สลับแท็บของ partials/doc_tabs_card.php — pattern เดียวกับ brOpen3Tab ของ register_supbrcshos.php */
	function bregOpen3Tab(tabId, element) {
		var contents = document.getElementsByClassName('so-3tab-content');
		for (var i = 0; i < contents.length; i++) contents[i].style.display = 'none';
		var btns = element.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < btns.length; i++) btns[i].classList.remove('active');
		document.getElementById(tabId).style.display = 'block';
		element.classList.add('active');
	}

	/* ส่วนช่าง — เปิด/ปิดช่องตามเงื่อนไข และย้ำสถานะ active ของ checkbox pill
	   กติกาเดียวกับ breg_validate_engineer_section() ฝั่ง server */
	function bregSyncEngineerSection() {
		var proCome = document.getElementById('pro_come');
		var proComeDate = document.getElementById('pro_comedate');
		var brdocEng = document.getElementById('brdoc_eng');
		var nameEng = document.getElementById('name_eng');
		var dateBrdoc = document.getElementById('date_brdoc');

		proComeDate.disabled = !proCome.checked;
		if (!proCome.checked) proComeDate.value = '';

		nameEng.disabled = !brdocEng.checked;
		dateBrdoc.disabled = !brdocEng.checked;
		if (!brdocEng.checked) {
			nameEng.value = '';
			dateBrdoc.value = '';
		}

		// วันที่ประกอบต้องไม่ก่อนวันที่รับเข้า
		dateBrdoc.min = proComeDate.value || '';
		if (proComeDate.value && dateBrdoc.value && dateBrdoc.value < proComeDate.value) {
			dateBrdoc.value = proComeDate.value;
		}

		document.getElementById('breg_pro_come_label').classList.toggle('is-active', proCome.checked);
		document.getElementById('breg_brdoc_eng_label').classList.toggle('is-active', brdocEng.checked);
	}

	/* field ที่ถูก disabled จะไม่ถูก POST — ปลด disabled ชั่วคราวก่อนส่งทุกเส้นทาง
	   (Submit / Save Draft / Preview) แล้วคืนสถานะเดิมทันที */
	function bregWithEngineerFieldsEnabled(callback) {
		var ids = ['pro_comedate', 'brdoc_eng', 'name_eng', 'date_brdoc'];
		var previous = {};
		ids.forEach(function(id) {
			var el = document.getElementById(id);
			if (!el) return;
			previous[id] = el.disabled;
			el.disabled = false;
		});
		try {
			return callback();
		} finally {
			ids.forEach(function(id) {
				var el = document.getElementById(id);
				if (el && previous.hasOwnProperty(id)) el.disabled = previous[id];
			});
		}
	}

	function bregFocusField(field) {
		if (!field) return;
		if (typeof field.focus === 'function') field.focus();
		if (typeof field.scrollIntoView === 'function') field.scrollIntoView({ behavior: 'smooth', block: 'center' });
	}

	function bregValidationFail(message, field) {
		bregNotify('ข้อมูลไม่ครบถ้วน', message, 'warning');
		bregFocusField(field);
		return false;
	}

	function fncSubmit() {
		if (bregSubmitting) return false;

		var form = document.forms.frmMain;

		if (form.cm_no.value.trim() === '') return bregValidationFail('กรุณากรอกเลขที่ใบงานบริการ', form.cm_no);
		if (form.per_no.value.trim() === '') return bregValidationFail('กรุณากรอกเลขที่ PER', form.per_no);
		if (form.bill_id.value.trim() === '' || form.customer_name.value.trim() === '') {
			return bregValidationFail('กรุณาเลือกลูกค้า', document.querySelector('.btn-add-customer-pill'));
		}
		if (form.description.value.trim() === '') return bregValidationFail('กรุณากรอกวัตถุประสงค์การเบิก', form.description);
		if (bregTotalRowCount() === 0) {
			return bregValidationFail('กรุณาเพิ่มรายการอย่างน้อย 1 รายการ', document.getElementById('breg_product_search'));
		}

		var proCome = document.getElementById('pro_come');
		var proComeDate = document.getElementById('pro_comedate');
		var brdocEng = document.getElementById('brdoc_eng');
		var nameEng = document.getElementById('name_eng');
		var dateBrdoc = document.getElementById('date_brdoc');

		if (proCome.checked && proComeDate.value === '') return bregValidationFail('กรุณาระบุวันที่รับเข้าอะไหล่', proComeDate);
		if (brdocEng.checked) {
			if (nameEng.value === '') return bregValidationFail('กรุณาเลือกช่างประกอบ', nameEng);
			if (dateBrdoc.value === '') return bregValidationFail('กรุณาระบุวันที่ประกอบ', dateBrdoc);
			if (proComeDate.value !== '' && dateBrdoc.value < proComeDate.value) {
				return bregValidationFail('วันที่ประกอบต้องไม่ก่อนวันที่รับเข้าอะไหล่', dateBrdoc);
			}
		}

		var approveAction = document.getElementById('breg_approve_action');
		var submitAction = document.getElementById('breg_submit_action');
		if (submitAction && (!approveAction || approveAction.value === '')) {
			submitAction.value = 'submit';
		}

		bregSubmitting = true;
		var submitBtn = document.getElementById('btn_submit_form');
		if (submitBtn) {
			submitBtn.disabled = true;
			submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...';
		}

		bregWithEngineerFieldsEnabled(function() {
			HTMLFormElement.prototype.submit.call(document.forms.frmMain);
		});
		return false;
	}

	/* Save Draft — บันทึกได้แม้ข้อมูลยังไม่ครบ ยกเว้นส่วนช่างที่ถ้ากรอกแล้วต้องครบชุด
	   (server ตรวจซ้ำด้วย breg_validate_engineer_section) */
	function bregSaveDraft() {
		if (bregSubmitting) return;

		var form = document.forms['frmMain'];
		if (!form) return;

		var button = form.querySelector('[name="save_draft"]');
		var defaultHtml = button ? button.innerHTML : '';

		var formData = bregWithEngineerFieldsEnabled(function() {
			return new FormData(form);
		});
		formData.set('is_draft', '1');

		bregSubmitting = true;
		if (button) {
			button.disabled = true;
			button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
		}

		fetch('register_bregawl_draft1.php', { method: 'POST', body: formData })
			.then(function(res) { return res.json(); })
			.then(function(data) {
				if (data && data.success) {
					var target = 'register_bregawl.php?ref_id=' + encodeURIComponent(data.ref_id) + '&saved=1';
					if (typeof Swal === 'undefined') {
						alert('บันทึกร่างเรียบร้อยแล้ว (เลขที่ ' + data.ref_id + ')');
						window.location.href = target;
						return;
					}
					Swal.fire({
						title: 'บันทึกร่างเรียบร้อยแล้ว',
						text: 'เลขที่อ้างอิง: ' + (data.ref_id || ''),
						icon: 'success',
						confirmButtonColor: '#612989'
					}).then(function() { window.location.href = target; });
					return;
				}

				bregSubmitting = false;
				bregNotify('บันทึกร่างไม่สำเร็จ', (data && data.message) ? data.message : 'เกิดข้อผิดพลาดในการบันทึกร่าง', 'error');
			})
			.catch(function(err) {
				bregSubmitting = false;
				bregNotify('บันทึกร่างไม่สำเร็จ', String(err), 'error');
			})
			.finally(function() {
				if (button) {
					button.disabled = false;
					button.innerHTML = defaultHtml;
				}
			});
	}

	/* Preview — POST ค่าปัจจุบันทั้งฟอร์มไป from_breg.php แบบ _report_preview=1
	   ไม่แตะฐานข้อมูลและไม่จองเลข (pattern เดียวกับ openPrintReport ของ register_suphos.php) */
	function bregOpenPreview() {
		var form = document.forms.frmMain;
		if (!form) return;

		var previewTarget = 'breg_preview_' + Date.now();
		var previewWindow = window.open('', previewTarget);
		if (!previewWindow) {
			bregNotify('เปิด Preview ไม่ได้', 'เบราว์เซอร์บล็อกหน้าต่างใหม่ กรุณาอนุญาต Pop-up แล้วลองอีกครั้ง', 'warning');
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

		form.action = 'from_breg.php';
		form.method = 'post';
		form.target = previewTarget;

		bregWithEngineerFieldsEnabled(function() {
			HTMLFormElement.prototype.submit.call(form);
		});

		if (originalAction === null) form.removeAttribute('action');
		else form.setAttribute('action', originalAction);
		if (originalMethod === null) form.removeAttribute('method');
		else form.setAttribute('method', originalMethod);
		if (originalTarget === null) form.removeAttribute('target');
		else form.setAttribute('target', originalTarget);
		previewFlag.remove();
	}

	/* ===================== Popup เครดิตเทอม (อ่านอย่างเดียว) ===================== */
	function bregEscapeHtml(value) {
		return String(value === undefined || value === null ? '' : value)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#39;');
	}

	function bregGetCurrentBillId() {
		var hidden = document.getElementById('h_bill_id');
		var visible = document.getElementById('bill_id');
		return String((hidden && hidden.value) || (visible && visible.value) || '').trim();
	}

	function bregRenderCreditTermDebts(debts, message) {
		var tableBody = document.getElementById('bregCreditTermTableBody');
		if (!tableBody) return;

		if (message) {
			tableBody.innerHTML = '<tr class="credit-term-empty-row"><td colspan="4">' + bregEscapeHtml(message) + '</td></tr>';
			return;
		}

		if (!debts || debts.length === 0) {
			tableBody.innerHTML = '<tr class="credit-term-empty-row"><td colspan="4">ไม่พบรายการหนี้คงค้าง</td></tr>';
			return;
		}

		var html = '';
		for (var i = 0; i < debts.length; i++) {
			var debt = debts[i] || {};
			html += '<tr>'
				+ '<td>' + bregEscapeHtml(debt.IV_number || '-') + '</td>'
				+ '<td>' + bregFormatMoney(debt.amount_due) + '</td>'
				+ '<td>' + bregFormatMoney(debt.paid_amount) + '</td>'
				+ '<td>' + bregFormatMoney(debt.outstanding_amount) + '</td>'
				+ '</tr>';
		}
		tableBody.innerHTML = html;
	}

	var bregCreditTermRequestToken = 0;

	function bregLoadCreditTermModalData(billId) {
		var requestToken = ++bregCreditTermRequestToken;

		bregSetText('bregCreditSummaryDay', '-');
		bregSetText('bregCreditSummaryAmount', '0.00');
		bregSetText('bregCreditSummaryOutstanding', '0.00');
		bregSetText('bregCreditSummaryRemaining', '0.00');
		bregRenderCreditTermDebts(null, 'กำลังโหลดข้อมูลเครดิตเทอม...');

		fetch('ajax_credit_term_modal.php?bill_id=' + encodeURIComponent(billId), {
			credentials: 'same-origin',
			cache: 'no-store'
		})
			.then(function(response) {
				if (!response.ok) throw new Error('ไม่สามารถโหลดข้อมูลเครดิตเทอมได้');
				return response.json();
			})
			.then(function(data) {
				if (requestToken !== bregCreditTermRequestToken) return;
				if (!data || !data.success) {
					throw new Error((data && data.message) ? data.message : 'ไม่สามารถโหลดข้อมูลเครดิตเทอมได้');
				}

				var summary = data.summary || {};
				bregSetText('bregCreditSummaryDay', String(summary.credit_day || '').trim() !== '' ? summary.credit_day : '-');
				bregSetText('bregCreditSummaryAmount', bregFormatMoney(summary.credit_amount));
				bregSetText('bregCreditSummaryOutstanding', bregFormatMoney(summary.total_outstanding));
				bregSetText('bregCreditSummaryRemaining', bregFormatMoney(summary.remaining_credit));

				bregRenderCreditTermDebts(Array.isArray(data.debts) ? data.debts : []);
			})
			.catch(function(error) {
				if (requestToken !== bregCreditTermRequestToken) return;
				bregRenderCreditTermDebts(null, error && error.message ? error.message : 'ไม่สามารถโหลดข้อมูลเครดิตเทอมได้');
			});
	}

	function bregOpenCreditTermModal() {
		var trigger = document.getElementById('display_credit_thb_trigger');
		var modal = document.getElementById('bregCreditTermModal');
		if (!trigger || trigger.disabled || !modal) return;

		var billId = bregGetCurrentBillId();
		if (billId === '') return;

		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');
		bregLoadCreditTermModalData(billId);
	}

	function bregCloseCreditTermModal() {
		var modal = document.getElementById('bregCreditTermModal');
		if (!modal) return;
		modal.style.display = 'none';
		modal.setAttribute('aria-hidden', 'true');
	}

	document.addEventListener('DOMContentLoaded', function() {
		bregSyncGroupSwitchUi();
		bregSyncEngineerSection();

		// โหมดเปิดร่างเดิม — เติมการ์ดข้อมูลลูกค้าจากรหัสที่บันทึกไว้
		var billId = document.getElementById('bill_id');
		if (billId && billId.value.trim() !== '') {
			bregLoadCustomerDetail(billId.value);
		}

		var creditTermTrigger = document.getElementById('display_credit_thb_trigger');
		if (creditTermTrigger) {
			creditTermTrigger.addEventListener('click', bregOpenCreditTermModal);
			creditTermTrigger.addEventListener('keydown', function(event) {
				if (event.key === 'Enter' || event.key === ' ') {
					event.preventDefault();
					bregOpenCreditTermModal();
				}
			});
		}

		var creditTermModal = document.getElementById('bregCreditTermModal');
		if (creditTermModal) {
			creditTermModal.addEventListener('click', function(event) {
				if (event.target === creditTermModal) {
					bregCloseCreditTermModal();
				}
			});
		}

		document.addEventListener('keydown', function(event) {
			if (event.key !== 'Escape') return;
			if (creditTermModal && creditTermModal.style.display === 'flex') {
				bregCloseCreditTermModal();
			}
		});
	});
</script>
</body>
</html>
