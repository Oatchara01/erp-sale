<?php
require_once __DIR__ . '/includes/so_saved_helpers.php';
require_once __DIR__ . '/includes/po_repo.php';

/* ===================================================================
 * ใบ PO (hos__po) — สร้างใหม่ / เปิดร่างเดิมกลับมาแก้
 *   - ไม่มี ref_id        → ใบใหม่ (เลขบนหัวเป็นเลขคาดการณ์ จองจริงตอน Save Draft / Submit ครั้งแรก)
 *   - ref_id ของใบ Draft  → แก้ร่างเดิม เลขไม่เปลี่ยน
 *   - ref_id ที่ส่งแล้ว    → แก้ต่อได้ด้วยปุ่ม Update (คงสถานะเดิม) ถ้ายังไม่ยกเลิก/ยังไม่ออกใบสั่งขาย
 *   - ใบที่ออกใบสั่งขายแล้ว → อ่านอย่างเดียว + ลิงก์ไปใบ SO
 *   - ใบ Returned (Sale ส่งกลับ) → Admin แก้ + Update คง Returned / Submit ส่ง Sale ใหม่
 *   - ใบยกเลิก            → อ่านอย่างเดียว (banner เหตุผล + แท็บประวัติ)
 *   - ฝั่ง Sale/Engineer   → อ่านอย่างเดียว ส่งกลับได้ (เมนู ⋮) / ไปออกใบสั่งขาย
 * บันทึกทุกปุ่มผ่าน register_posave1.php (po_action) → includes/po_repo.php
 * =================================================================== */
$poRequestedRefId = isset($_GET['ref_id']) && !is_array($_GET['ref_id']) ? trim((string)$_GET['ref_id']) : '';
// คัดลอกใบเดิม (?copy_from=) — ใช้เฉพาะตอนสร้างใบใหม่ (ไม่มี ref_id)
$poCopyFromRefId = ($poRequestedRefId === '' && isset($_GET['copy_from']) && !is_array($_GET['copy_from'])) ? trim((string)$_GET['copy_from']) : '';
?>
<?php include("head.php"); ?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-poawl.css?v=<?php echo filemtime(__DIR__ . '/css/register-poawl.css'); ?>">
<script src="js/customer-popup.js?v=<?php echo filemtime(__DIR__ . '/js/customer-popup.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/so-required-fields.js?v=<?php echo filemtime(__DIR__ . '/js/so-required-fields.js'); ?>"></script>

<?php
date_default_timezone_set("Asia/Bangkok");

$poStopPage = function ($message, array $links = array()) {
	echo '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red" style="max-width:1096px;margin:24px auto;box-sizing:border-box;">'
		. '<p>' . so_saved_h($message) . '</p>';
	foreach ($links as $label => $href) {
		echo '<p><a href="' . so_saved_h($href) . '">' . so_saved_h($label) . '</a></p>';
	}
	echo '</div>';
	exit();
};

if (!po_has_status_column($conn)) {
	$poStopPage('ฐานข้อมูลยังไม่รองรับสถานะเอกสาร PO กรุณาแจ้งผู้ดูแลระบบให้รัน sql/po_status_doc.sql');
}

/* ฝั่ง Sale (Sale/Engineer) เปิดจาก status_po_sale.php แบบอ่านอย่างเดียว — ทำได้แค่ส่งกลับ / ไปออกใบสั่งขาย */
$poIsSaleUser = po_is_sale_side_user($_SESSION);
$poBackUrl = $poIsSaleUser ? 'status_po_sale.php' : 'status_adminpo.php';
$poBackLabel = $poIsSaleUser ? 'กลับหน้า PO รอเปิดใบสั่งขาย' : 'กลับหน้าสถานะเอกสาร PO';
if ($poIsSaleUser && $poRequestedRefId === '') {
	$poStopPage('ฝั่ง Sale ไม่สามารถสร้างใบ PO ได้', array($poBackLabel => $poBackUrl));
}

$savedPo = null;
$poSavedItemsForForm = array();
$poIsCancelled = false;
$poIsOpenedSo = false;
$poOpenedSoRef = '';
if ($poRequestedRefId !== '') {
	$savedPo = po_load_document($conn, $poRequestedRefId);
	if ($savedPo === null) {
		$poStopPage('ไม่พบเอกสารเลขที่ ' . $poRequestedRefId, array($poBackLabel => $poBackUrl));
	}
	$poIsCancelled = ((string)($savedPo['cancel_ckk'] ?? '0') === '1');
	// ออกใบสั่งขายแล้ว (ตรงกับ po_edit_block_reason) → เปิดดูแบบอ่านอย่างเดียว + ลิงก์ไปใบ SO
	$poOpenedSoRef = trim((string)($savedPo['ref_so'] ?? ''));
	$poIsOpenedSo = !po_is_draft($savedPo) && ((string)($savedPo['open_so'] ?? '0') === '1' || $poOpenedSoRef !== '');
	if ($poIsSaleUser && (!po_sale_can_access($savedPo, $_SESSION) || po_is_draft($savedPo) || po_is_returned($savedPo) || $poIsCancelled)) {
		$poStopPage('ไม่สามารถเปิดใบ PO เลขที่ ' . $poRequestedRefId . ' ได้ (ไม่ใช่ใบของเขตการขายคุณ หรือยังไม่ได้ส่งให้ Sale)', array($poBackLabel => $poBackUrl));
	}
	$poSavedItemsForForm = po_items_for_form(po_load_items($conn, $savedPo['ref_id']));
}

/* คัดลอกใบเดิม: prefill หัวเอกสาร + รายการสินค้าเป็นใบใหม่ ($savedPo ยังเป็น null → เลขใหม่ / วันนี้ / สถานะใบใหม่)
 * ไม่คัดลอกเลข PO ลูกค้า, ไฟล์แนบ และ flag สถานะ */
$poCopySource = null;
if ($poCopyFromRefId !== '') {
	$poCopySource = po_load_document($conn, $poCopyFromRefId);
	if ($poCopySource === null) {
		$poStopPage('ไม่พบเอกสารเลขที่ ' . $poCopyFromRefId . ' สำหรับคัดลอก', array($poBackLabel => $poBackUrl));
	}
	$poSavedItemsForForm = po_items_for_form(po_load_items($conn, $poCopySource['ref_id']));
}
$poCopySkipKeys = array('ref_id', 'po_no', 'date_po', 'status_doc', 'cancel_ckk', 'remark_cancel', 'ref_so');

/* new = ใบใหม่ | draft = ร่าง | cancelled = ยกเลิกแล้ว | opened = ออกใบสั่งขายแล้ว | returned = Sale ส่งกลับ
 * pending_send = ใบจริงที่ยังไม่ส่ง Sale (ใบเก่า) | submitted = ส่ง Sale แล้ว
 * cancelled / opened = อ่านอย่างเดียว (ลำดับเดียวกับ po_status_info) */
if ($savedPo === null) {
	$poMode = 'new';
} else if (po_is_draft($savedPo)) {
	$poMode = 'draft';
} else if ($poIsCancelled) {
	$poMode = 'cancelled';
} else if ($poIsOpenedSo) {
	$poMode = 'opened';
} else if (po_is_returned($savedPo)) {
	$poMode = 'returned';
} else if ((string)$savedPo['send_sale'] === '1') {
	$poMode = 'submitted';
} else {
	$poMode = 'pending_send';
}
$poIsExisting = ($savedPo !== null);
$poReadOnly = $poIsSaleUser || $poMode === 'cancelled' || $poMode === 'opened';
// ส่งกลับ: Sale ของเขตนี้ + ใบรอ Sale เปิดใบสั่งขาย (guard ด้านบนกรองสิทธิ์/สถานะอื่นไว้แล้ว)
$poCanReturn = $poIsSaleUser && $poMode === 'submitted';
// ยกเลิก: Admin + ใบจริงที่ยังไม่ยกเลิก/ยังไม่ออก SO
$poCanCancel = !$poIsSaleUser && in_array($poMode, array('submitted', 'pending_send', 'returned'), true);

/* ประวัติส่งกลับ/ยกเลิก (tb_document_status_log) — row แรก = banner เหตุผลล่าสุด */
$poStatusLogRows = $poIsExisting ? po_load_status_log($conn, (string)$savedPo['ref_id']) : array();
$poLatestLog = null;
if (count($poStatusLogRows) > 0 && trim((string)$poStatusLogRows[0]['reason']) !== '') {
	$poLatestLog = $poStatusLogRows[0] + po_status_log_display($poStatusLogRows[0]['status_doc']);
}
// ใบยกเลิกจาก register_poclose.php เดิมไม่มี log — ใช้ remark_cancel แทน
if ($poLatestLog === null && $poMode === 'cancelled' && trim((string)($savedPo['remark_cancel'] ?? '')) !== '') {
	$poLatestLog = array('reason' => (string)$savedPo['remark_cancel']) + po_status_log_display('Cancelled');
}
$poDisplayRefId = $poIsExisting ? (string)$savedPo['ref_id'] : po_peek_next_ref_id($conn);
$poValue = function ($key, $default = '') use ($savedPo, $poCopySource, $poCopySkipKeys) {
	if ($savedPo !== null) {
		return isset($savedPo[$key]) ? (string)$savedPo[$key] : $default;
	}
	if ($poCopySource !== null && isset($poCopySource[$key]) && !in_array($key, $poCopySkipKeys, true)
		&& strpos($key, 'img_po') !== 0 && strpos($key, 'send_sale') !== 0 && strpos($key, 'open_so') !== 0) {
		return (string)$poCopySource[$key];
	}
	return $default;
};

$poTypeDoc = $poValue('type_doc', '3');
if (!array_key_exists($poTypeDoc, po_company_options())) {
	$poTypeDoc = '3';
}
$poDate = $poIsExisting ? so_saved_iso_date_input($savedPo['date_po']) : date('Y-m-d');

/* แผนก/เขตการขาย — ชุดเดียวกับหน้า PO เดิม (tb_team_adm ทั้งหมด ฐาน sale ผ่าน $com) */
$poSaleCodeOptions = array();
$poSaleCodeQuery = mysqli_query($com, "SELECT sale_code, sale_name FROM tb_team_adm ORDER BY sale_code ASC");
while ($poSaleCodeQuery && ($poSaleCodeRow = mysqli_fetch_assoc($poSaleCodeQuery))) {
	$poSaleCodeOptions[] = $poSaleCodeRow;
}
$poSelectedSaleCode = $poValue('sale_code');

/* ไฟล์แนบเดิมของร่าง (img_po1..5) */
$poExistingFiles = array();
for ($slot = 1; $slot <= PO_MAX_ATTACHMENTS; $slot++) {
	$poExistingFiles[$slot] = $poValue('img_po' . $slot);
}
?>

<?php
/* ผลบันทึกจาก register_posave1.php (?saved / ?submitted / ?updated) — แสดงครั้งเดียวแล้วลบ param ออกจาก URL */
$poSuccessTitles = array(
	'saved'     => 'บันทึกร่างเรียบร้อยแล้ว',
	'submitted' => 'ส่งใบ PO ให้ Sale เรียบร้อยแล้ว',
	'updated'   => 'อัปเดตใบ PO เรียบร้อยแล้ว',
	'cancelled' => 'ยกเลิกใบ PO เรียบร้อยแล้ว',
);
$poSuccessParam = '';
foreach ($poSuccessTitles as $poParam => $poTitle) {
	if (isset($_GET[$poParam]) && $_GET[$poParam] === '1') {
		$poSuccessParam = $poParam;
		break;
	}
}
?>
<?php if ($poSuccessParam !== '') { ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var cleanUrl = new URL(window.location.href);
			cleanUrl.searchParams.delete(<?php echo json_encode($poSuccessParam); ?>);
			window.history.replaceState({}, document.title, cleanUrl);
			Swal.fire({
				title: <?php echo json_encode($poSuccessTitles[$poSuccessParam], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>,
				text: <?php echo json_encode('เลขที่อ้างอิง: ' . $poDisplayRefId, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>,
				icon: 'success',
				confirmButtonColor: '#612989',
				confirmButtonText: 'ตกลง'
			});
		});
	</script>
<?php } ?>

<form action="register_posave1.php" method="post" name="frmMain" id="frmMain" enctype="multipart/form-data" class="po-page<?php echo $poReadOnly ? ' is-readonly' : ''; ?>" onsubmit="return false;" novalidate>
	<!-- ใบใหม่ส่ง ref_id ว่าง = ให้ตัวบันทึกจองเลขใหม่ -->
	<input type="hidden" name="ref_id" id="ref_id" value="<?php echo $poIsExisting ? so_saved_h($savedPo['ref_id']) : ''; ?>">

	<div class="w3-container po-layout">

		<div class="so-header-container">
			<div class="so-header-left">
				<div class="so-title-row">
					<button type="button" class="so-back-btn" onclick="window.location.href=<?php echo so_saved_h(json_encode($poBackUrl)); ?>;" title="ย้อนกลับ" aria-label="ย้อนกลับ">
						<img src="img/icons/chevron_left.svg" alt="">
					</button>
					<h1 class="so-title po-title">ใบสั่งซื้อ (PO)</h1>
				</div>
				<div class="so-ref-info">
					<span class="so-ref-label">เลขที่อ้างอิง</span>
					<span class="so-ref-value"><?php echo so_saved_h($poDisplayRefId); ?></span>
					<?php if ($poMode === 'draft') { ?>
						<span class="po-status-pill is-draft">Draft</span>
					<?php } else if ($poMode === 'returned') { ?>
						<span class="po-status-pill is-returned">Returned</span>
					<?php } else if ($poMode === 'cancelled') { ?>
						<span class="po-status-pill is-cancelled">ยกเลิก</span>
					<?php } else if ($poMode === 'opened') { ?>
						<span class="po-status-pill is-opened">เปิดใบสั่งขายแล้ว</span>
					<?php } ?>
				</div>
			</div>
			<div class="so-header-right">
				<?php if ($poMode === 'opened') { ?>
					<?php if ($poOpenedSoRef !== '') { ?>
						<!-- register_suphos.php ค้น hos__so ก่อน → เปิดใบสั่งขายที่ออกจาก PO นี้ -->
						<a class="btn-so-draft po-link-btn" href="register_suphos.php?ref_id=<?php echo rawurlencode($poOpenedSoRef); ?>"><img src="img/icons/payment.png" alt=""> ดูใบสั่งขาย <?php echo so_saved_h($poOpenedSoRef); ?></a>
					<?php } ?>
				<?php } else if ($poIsSaleUser) { ?>
					<!-- ฝั่ง Sale ไม่บันทึกทับ PO — ไปหน้าออกใบสั่งขายตรง ๆ -->
					<a class="btn-so-draft po-action-btn po-link-btn" href="register_suphos.php?ref_id=<?php echo rawurlencode((string)$savedPo['ref_id']); ?>"><img src="img/icons/payment.png" alt=""> ออกใบสั่งขาย</a>
				<?php } else if (!$poReadOnly) { ?>
					<button type="button" class="btn-so-draft po-action-btn" data-po-action="create_so" onclick="poSave('create_so', this);"><img src="img/icons/payment.png" alt=""> ออกใบสั่งขาย</button>
				<?php } ?>
			</div>
		</div>

		<?php if ($poLatestLog !== null) { ?>
			<div class="so-latest-reason-banner <?php echo so_saved_h($poLatestLog['class']); ?>" role="status">
				<button type="button" class="so-latest-reason-close" aria-label="ปิด" onclick="this.closest('.so-latest-reason-banner').style.display='none';">&times;</button>
				<div class="so-latest-reason-title"><?php echo so_saved_h($poLatestLog['title']); ?></div>
				<div class="so-latest-reason-text"><?php echo nl2br(so_saved_h($poLatestLog['reason'])); ?></div>
			</div>
		<?php } ?>

		<?php if ($poReadOnly) { ?>
			<!-- อ่านอย่างเดียว: fieldset disabled ปิดทุก input/select/button ในการ์ด (ไม่ส่งค่าไปไหนอยู่แล้ว) -->
			<fieldset class="po-readonly-fieldset" disabled>
		<?php } ?>

		<!-- ===================== การ์ด 1: ข้อมูลเอกสาร ===================== -->
		<section class="so-card po-card" aria-labelledby="po_doc_title">
			<div class="po-doc-grid">
				<div class="so-field-group">
					<label class="so-label" for="type_doc_select">บริษัท <span class="po-required">*</span></label>
					<div class="so-select-wrapper">
						<select class="so-select" name="type_doc" id="type_doc_select">
							<?php foreach (po_company_options() as $poCompanyValue => $poCompanyLabel) { ?>
								<option value="<?php echo so_saved_h($poCompanyValue); ?>" <?php echo (string)$poCompanyValue === $poTypeDoc ? 'selected' : ''; ?>><?php echo so_saved_h($poCompanyLabel); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="sale_code">แผนก/เขตการขาย <span class="po-required">*</span></label>
					<div class="so-select-wrapper">
						<select name="sale_code" id="sale_code" class="so-select">
							<option value="">Select</option>
							<?php
							$poSaleCodeFound = false;
							foreach ($poSaleCodeOptions as $poOption) {
								$poIsSelected = ((string)$poOption['sale_code'] === $poSelectedSaleCode);
								$poSaleCodeFound = $poSaleCodeFound || $poIsSelected;
							?>
								<option value="<?php echo so_saved_h($poOption['sale_code']); ?>" <?php echo $poIsSelected ? 'selected' : ''; ?>><?php echo so_saved_h($poOption['sale_code'] . ' - ' . $poOption['sale_name']); ?></option>
							<?php } ?>
							<?php if ($poSelectedSaleCode !== '' && !$poSaleCodeFound) { ?>
								<!-- รหัสที่บันทึกไว้แต่ไม่อยู่ในข้อมูลหลักแล้ว ต้องไม่หายตอนบันทึกซ้ำ -->
								<option value="<?php echo so_saved_h($poSelectedSaleCode); ?>" selected><?php echo so_saved_h($poSelectedSaleCode); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="date_po">วันที่ <span class="po-required">*</span></label>
					<input type="date" name="date_po" id="date_po" class="so-input" value="<?php echo so_saved_h($poDate); ?>">
				</div>
			</div>

			<div class="so-section-title-container po-section-head po-doc-subhead">
				<h2 class="so-section-title" id="po_doc_title">ข้อมูลเอกสาร</h2>
				<hr class="so-divider">
			</div>

			<div class="po-doc-grid">
				<div class="so-field-group">
					<label class="so-label" for="po_no">เลขที่ PO <span class="po-required">*</span></label>
					<input type="text" name="po_no" id="po_no" class="so-input" maxlength="100" autocomplete="off" placeholder="ระบุเลขที่ PO" value="<?php echo so_saved_h($poValue('po_no')); ?>">
				</div>
			</div>
		</section>

		<!-- ===================== การ์ด 2: ข้อมูลลูกค้า (รูปแบบเดียวกับ register_bregawl.php) ===================== -->
		<section class="so-card po-card" aria-labelledby="po_customer_title">
			<div class="so-section-title-container po-section-head">
				<h2 class="so-section-title" id="po_customer_title">ข้อมูลลูกค้า</h2>
				<hr class="so-divider">
			</div>

			<div class="so-customer-top-grid">
				<div class="so-customer-top-left">
					<div class="so-customer-pills-row">
						<button type="button" class="btn-add-customer-pill" id="btn_open_customer" onclick="openCustomerPopup();">
							<img src="img/icons/add_user.png" alt="" style="width:23px;"> ข้อมูลลูกค้า <span class="po-required">*</span>
						</button>
					</div>
					<!-- bill_id = tb_customer.customer_id ตามที่ hos__po.bill_id เก็บอยู่เดิม -->
					<input type="hidden" name="bill_id" id="bill_id" value="<?php echo so_saved_h($poValue('bill_id')); ?>">
					<input type="hidden" name="h_bill_id" id="h_bill_id" value="<?php echo so_saved_h($poValue('bill_id')); ?>">
				</div>

				<div class="so-customer-top-right">
					<div class="so-field-group" style="height:100%;margin-bottom:0;">
						<span class="so-label">ข้อมูลลูกค้า</span>
						<div class="customer-info-display-card" aria-live="polite">
							<div class="cidc-col">
								<div class="cidc-row">
									<div class="cidc-label">รหัสลูกค้า</div>
									<div class="cidc-value"><span id="display_bill_id" class="cidc-display-text">-</span></div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">เบอร์โทรศัพท์</div>
									<div class="cidc-value"><span id="display_bill_tel" class="cidc-display-text">-</span></div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">สถานะลูกค้า</div>
									<div class="cidc-value">
										<img src="img/icons/vip.png" class="cidc-status-icon" id="display_vip_icon" alt="VIP" style="display:none;">
										<span id="display_customer_status" class="cidc-display-text">-</span>
									</div>
								</div>
							</div>
							<div class="cidc-col">
								<div class="cidc-row">
									<div class="cidc-label">ชื่อลูกค้า</div>
									<div class="cidc-value"><span id="display_bill_name" class="cidc-display-text">-</span></div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">ประเภทลูกค้า</div>
									<div class="cidc-value"><span id="display_customer_typename" class="cidc-display-text">-</span></div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">เครดิตเทอม</div>
									<div class="cidc-value">
										<button type="button" class="credit-term-trigger is-empty" id="display_credit_thb_trigger" aria-haspopup="dialog" aria-controls="poCreditTermModal" aria-disabled="true" disabled>
											<span id="display_credit_thb" class="credit-term-trigger-text">-</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="so-field-group po-bill-name">
				<label class="so-label" for="bill_name">ชื่อออกบิล <span class="po-required">*</span></label>
				<input type="text" name="bill_name" id="bill_name" class="so-input" maxlength="300" placeholder="เลือกลูกค้าเพื่อเติมอัตโนมัติ หรือแก้ไขเอง" value="<?php echo so_saved_h($poValue('bill_name')); ?>">
			</div>
		</section>

		<!-- ===================== การ์ด 3: รายการสินค้า (ตารางชุดเดียวกับใบสั่งขาย) ===================== -->
		<section class="so-card po-card po-items-card" aria-label="รายการสินค้า">
			<?php
			$productTableContext = 'po';
			include __DIR__ . '/product_salehos.php';
			?>
		</section>

		<!-- ===================== การ์ด 4: หมายเหตุ ===================== -->
		<section class="so-card po-card" aria-labelledby="po_remark_title">
			<div class="so-section-title-container po-section-head">
				<h2 class="so-section-title" id="po_remark_title">หมายเหตุ</h2>
				<hr class="so-divider">
			</div>
			<div class="so-field-group">
				<label class="so-label" for="remark">หมายเหตุ</label>
				<input type="text" name="remark" id="remark" class="so-input" placeholder="ระบุหมายเหตุ" value="<?php echo so_saved_h($poValue('remark')); ?>">
			</div>

			<div class="so-field-group po-description-field">
				<label class="so-label" for="description">การดำเนินการ</label>
				<input type="text" name="description" id="description" class="so-input" placeholder="ระบุการดำเนินการ" value="<?php echo so_saved_h($poValue('description')); ?>">
			</div>
		</section>

		<?php if ($poReadOnly) { ?>
			</fieldset>
		<?php } ?>

		<!-- ===================== การ์ด 5: แนบไฟล์เพิ่มเติม (พฤติกรรมจาก js/doc-tabs-attach.js) + ประวัติการส่งกลับ ===================== -->
		<!-- ใช้หน้าตา .so-tab-btn จาก register-suphos.css — เส้นม่วง (.active) ขึ้นที่แท็บที่เลือก -->
		<div class="so-tabs-container po-attach-tabs" role="tablist">
			<button type="button" class="so-tab-btn active" role="tab" aria-selected="true" aria-controls="po_tab_attach" data-po-tab="po_tab_attach" onclick="poSwitchTab(this);"><span class="po-tab-dot" aria-hidden="true">●</span>แนบไฟล์</button>
			<?php if ($poIsExisting) { ?>
				<button type="button" class="so-tab-btn" role="tab" aria-selected="false" aria-controls="po_tab_return_log" data-po-tab="po_tab_return_log" onclick="poSwitchTab(this);"><span class="po-tab-dot" aria-hidden="true">●</span>การส่งกลับเอกสาร</button>
			<?php } ?>
		</div>
		<?php if ($poReadOnly) { ?>
			<fieldset class="po-readonly-fieldset" disabled>
		<?php } ?>
		<section class="so-card po-card po-tab-panel" id="po_tab_attach" role="tabpanel" aria-labelledby="po_attach_title">
			<div class="so-section-title-container po-section-head">
				<h2 class="so-section-title" id="po_attach_title">แนบไฟล์เพิ่มเติม</h2>
				<hr class="so-divider">
			</div>

			<button type="button" class="po-attach-btn" onclick="triggerAttachFile()">
				<img src="img/icons/import_file.png" alt="" style="width:16px;height:16px;"> เพิ่มไฟล์
			</button>
			<p class="po-attach-hint" id="po_attach_hint">รองรับไฟล์ PDF, JPG, PNG ขนาดไม่เกิน 1 MB ต่อไฟล์ สูงสุด <?php echo PO_MAX_ATTACHMENTS; ?> ไฟล์</p>

			<div id="attach_file_list" class="po-attach-list" aria-describedby="po_attach_hint"
				data-first-slot="1"
				data-last-slot="<?php echo PO_MAX_ATTACHMENTS; ?>"
				data-base-url="upload/"
				data-max-bytes="<?php echo PO_MAX_ATTACHMENT_BYTES; ?>"
				data-allowed-ext="pdf,jpg,jpeg,png"
				data-allowed-mime="application/pdf,image/jpeg,image/pjpeg,image/png"></div>

			<?php for ($slot = 1; $slot <= PO_MAX_ATTACHMENTS; $slot++) { ?>
				<input type="file" name="img_po<?php echo $slot; ?>" id="hidden_slip<?php echo $slot; ?>" style="display:none;" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png" onchange="handleFileSelect(this, <?php echo $slot; ?>)">
				<!-- ไฟล์เดิมของร่าง: ชื่อไว้แสดง (ไม่ถูกส่ง) + ธงลบที่ server อ่าน -->
				<input type="hidden" id="hidden_slip_val<?php echo $slot; ?>" value="<?php echo so_saved_h($poExistingFiles[$slot]); ?>">
				<input type="hidden" name="img_po_remove<?php echo $slot; ?>" id="hidden_remove_val<?php echo $slot; ?>" value="0">
			<?php } ?>
		</section>
		<?php if ($poReadOnly) { ?>
			</fieldset>
		<?php } ?>

		<?php if ($poIsExisting) { ?>
			<section class="so-card po-card po-tab-panel" id="po_tab_return_log" role="tabpanel" aria-labelledby="po_return_log_title" hidden>
				<div class="so-section-title-container po-section-head">
					<h2 class="so-section-title" id="po_return_log_title">การส่งกลับเอกสาร</h2>
					<hr class="so-divider">
				</div>
				<div class="po-return-log-wrap">
					<table class="so-document-status-table">
						<thead>
							<tr>
								<th scope="col">สถานะ</th>
								<th scope="col">เหตุผล</th>
								<th scope="col">ผู้ดำเนินการ</th>
							</tr>
						</thead>
						<tbody>
							<?php if (count($poStatusLogRows) > 0) { ?>
								<?php foreach ($poStatusLogRows as $poLogRow) {
									$poLogDisplay = po_status_log_display($poLogRow['status_doc']);
									$poLogTime = strtotime((string)$poLogRow['created_at']);
								?>
									<tr>
										<td class="so-document-log-status-cell">
											<span class="so-document-status-pill <?php echo so_saved_h($poLogDisplay['class']); ?>"><?php echo so_saved_h($poLogDisplay['label']); ?></span>
										</td>
										<td class="so-document-log-reason-cell"><?php echo nl2br(so_saved_h($poLogRow['reason'])); ?></td>
										<td class="so-document-log-user-cell">
											<div><?php echo so_saved_h(trim((string)$poLogRow['user_name']) !== '' ? $poLogRow['user_name'] : '-'); ?></div>
											<?php if ($poLogTime) { ?>
												<div class="so-document-log-time"><?php echo so_saved_h(date('d-m-Y H:i', $poLogTime)); ?></div>
											<?php } ?>
										</td>
									</tr>
								<?php } ?>
							<?php } else { ?>
								<tr class="so-document-status-empty">
									<td colspan="3">ยังไม่มีประวัติการส่งกลับเอกสาร</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</section>
		<?php } ?>
	</div>

	<div class="so-sticky-actions po-sticky-actions">
		<div class="so-sticky-actions-inner po-sticky-actions-inner">
			<div class="po-actions-main">
				<?php if ($poCanReturn || $poCanCancel) { ?>
					<!-- เมนู ⋮ รูปแบบเดียวกับแถบอนุมัติของ register_suphos.php — ทุกปุ่มเปิด popup เหตุผลก่อนส่ง -->
					<div class="po-overflow-wrap">
						<button type="button" class="so-overflow-menu-trigger po-overflow-trigger" id="btn_po_overflow" aria-haspopup="true" aria-expanded="false" aria-controls="poOverflowMenu" aria-label="เมนูเพิ่มเติม" onclick="poToggleOverflowMenu();">
							<i class="fas fa-ellipsis-v" aria-hidden="true"></i>
						</button>
						<div id="poOverflowMenu" class="so-overflow-menu po-overflow-menu" role="menu" hidden>
							<?php if ($poCanReturn) { ?>
								<button type="button" role="menuitem" class="po-overflow-item po-action-btn" data-po-action="return" onclick="poReturnDocument(this);"><img src="img/icons/send_back.png" alt=""> ส่งกลับ</button>
							<?php } ?>
							<?php if ($poCanCancel) { ?>
								<button type="button" role="menuitem" class="po-overflow-item po-action-btn" data-po-action="cancel" onclick="poCancelDocument(this);"><img src="img/icons/cancel_document.png" alt=""> ยกเลิกเอกสาร</button>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<?php if (!$poReadOnly) { ?>
					<?php if ($poMode !== 'submitted') { ?>
						<button type="button" class="btn-so-submit po-action-btn" data-po-action="submit" onclick="poSave('submit', this);"><i class="fas fa-paper-plane" aria-hidden="true"></i> Submit</button>
					<?php } ?>
					<?php if ($poMode === 'new' || $poMode === 'draft') { ?>
						<button type="button" class="btn-so-draft po-action-btn" data-po-action="draft" onclick="poSave('draft', this);"><i class="far fa-save" aria-hidden="true"></i> <?php echo $poMode === 'draft' ? 'Update Draft' : 'Save Draft'; ?></button>
					<?php } else { ?>
						<!-- ใบจริง: บันทึกทับโดยคงสถานะเดิม (ห้ามถอยกลับเป็นร่าง, ใบ Returned คง Returned) -->
						<button type="button" class="btn-so-draft po-action-btn" data-po-action="update" onclick="poSave('update', this);"><i class="far fa-save" aria-hidden="true"></i> Update</button>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
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

<!-- ===================== Popup เครดิตเทอม (อ่านอย่างเดียว — ajax_credit_term_modal.php) ===================== -->
<div id="poCreditTermModal" class="customer-popup-modal" aria-hidden="true" style="display:none;">
	<div class="customer-popup-box po-credit-term-popup-box" role="dialog" aria-modal="true" aria-labelledby="poCreditTermTitle">
		<button type="button" class="customer-popup-close" onclick="poCloseCreditTermModal()" aria-label="Close">&times;</button>
		<div class="clear-loan-header">
			<h2 id="poCreditTermTitle">เครดิตเทอม</h2>
		</div>
		<div class="credit-term-popup-content">
			<div class="credit-term-summary">
				<div class="credit-term-summary-item">
					<p class="credit-term-summary-label">เครดิต (วัน)</p>
					<p class="credit-term-summary-value" id="poCreditSummaryDay">-</p>
				</div>
				<div class="credit-term-summary-item">
					<p class="credit-term-summary-label">เครดิต (ยอดเงิน)</p>
					<p class="credit-term-summary-value" id="poCreditSummaryAmount">0.00</p>
				</div>
				<div class="credit-term-summary-item">
					<p class="credit-term-summary-label">ยอดรวมหนี้คงค้าง</p>
					<p class="credit-term-summary-value" id="poCreditSummaryOutstanding">0.00</p>
				</div>
				<div class="credit-term-summary-item is-highlight">
					<p class="credit-term-summary-label">ยอดเครดิตคงเหลือ</p>
					<p class="credit-term-summary-value" id="poCreditSummaryRemaining">0.00</p>
				</div>
			</div>
			<div class="po-credit-term-table-wrap">
				<table class="po-credit-term-table">
					<thead>
						<tr>
							<th scope="col">เลขที่ใบสั่งขาย</th>
							<th scope="col">ยอดที่ต้องชำระ</th>
							<th scope="col">ยอดชำระแล้ว</th>
							<th scope="col">ยอดหนี้คงค้าง</th>
						</tr>
					</thead>
					<tbody id="poCreditTermTableBody">
						<tr class="credit-term-empty-row">
							<td colspan="4">เลือกลูกค้าแล้วกดเปิดเครดิตเทอมเพื่อดูข้อมูล</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	window.poPageConfig = {
		mode: <?php echo json_encode($poMode); ?>,
		refId: <?php echo json_encode($poIsExisting ? (string)$savedPo['ref_id'] : '', JSON_UNESCAPED_UNICODE); ?>,
		savedItems: <?php echo json_encode($poSavedItemsForForm, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>,
		maxItems: <?php echo PO_MAX_ITEMS; ?>,
		readOnly: <?php echo $poReadOnly ? 'true' : 'false'; ?>,
		isSale: <?php echo $poIsSaleUser ? 'true' : 'false'; ?>
	};
</script>
<script src="js/doc-tabs-attach.js?v=<?php echo filemtime(__DIR__ . '/js/doc-tabs-attach.js'); ?>"></script>
<script src="js/register-poawl.js?v=<?php echo filemtime(__DIR__ . '/js/register-poawl.js'); ?>"></script>
</body>
</html>
