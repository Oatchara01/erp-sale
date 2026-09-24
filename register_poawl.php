<?php
require_once __DIR__ . '/includes/so_saved_helpers.php';
require_once __DIR__ . '/includes/po_repo.php';

/* ===================================================================
 * ใบ PO (hos__po) — สร้างใหม่ / เปิดร่างเดิมกลับมาแก้
 *   - ไม่มี ref_id        → ใบใหม่ (เลขบนหัวเป็นเลขคาดการณ์ จองจริงตอน Save Draft / Submit ครั้งแรก)
 *   - ref_id ของใบ Draft  → แก้ร่างเดิม เลขไม่เปลี่ยน
 *   - ref_id ที่ส่งแล้ว    → ไม่ให้แก้ในหน้านี้ (หน้าแก้ไข PO เดิมยังเป็นช่องทางแก้ใบจริง)
 * บันทึกทุกปุ่มผ่าน register_posave1.php (po_action) → includes/po_repo.php
 * =================================================================== */
$poRequestedRefId = isset($_GET['ref_id']) && !is_array($_GET['ref_id']) ? trim((string)$_GET['ref_id']) : '';
?>
<?php include("head.php"); ?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-poawl.css?v=<?php echo filemtime(__DIR__ . '/css/register-poawl.css'); ?>">
<script src="js/customer-popup.js?v=<?php echo filemtime(__DIR__ . '/js/customer-popup.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
date_default_timezone_set("Asia/Bangkok");

$poStopPage = function ($message, array $links = array()) {
	echo '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red" style="max-width:1096px;margin:24px auto;box-sizing:border-box;">'
		. '<p>' . so_saved_h($message) . '</p>';
	foreach ($links as $label => $href) {
		echo '<p><a href="' . so_saved_h($href) . '">' . so_saved_h($label) . '</a></p>';
	}
	echo '</div>';
	include 'foot.php';
	exit();
};

if (!po_has_status_column($conn)) {
	$poStopPage('ฐานข้อมูลยังไม่รองรับสถานะเอกสาร PO กรุณาแจ้งผู้ดูแลระบบให้รัน sql/po_status_doc.sql');
}

$savedPo = null;
$poSavedItemsForForm = array();
if ($poRequestedRefId !== '') {
	$savedPo = po_load_document($conn, $poRequestedRefId);
	if ($savedPo === null) {
		$poStopPage('ไม่พบเอกสารเลขที่ ' . $poRequestedRefId, array('กลับหน้าสถานะเอกสาร PO' => 'status_adminpo.php'));
	}
	if (!po_is_draft($savedPo)) {
		$poStopPage('เอกสารเลขที่ ' . $poRequestedRefId . ' ถูกส่งไปแล้ว จึงแก้ไขในหน้านี้ไม่ได้', array(
			'ดูเอกสาร' => 'report_po.php?ref_id=' . rawurlencode($poRequestedRefId),
			'กลับหน้าสถานะเอกสาร PO' => 'status_adminpo.php',
		));
	}
	$poSavedItemsForForm = po_items_for_form(po_load_items($conn, $savedPo['ref_id']));
}

$poIsDraftMode = ($savedPo !== null);
$poDisplayRefId = $poIsDraftMode ? (string)$savedPo['ref_id'] : po_peek_next_ref_id($conn);
$poValue = function ($key, $default = '') use ($savedPo) {
	return $savedPo !== null && isset($savedPo[$key]) ? (string)$savedPo[$key] : $default;
};

$poTypeDoc = $poValue('type_doc', '3');
if (!array_key_exists($poTypeDoc, po_company_options())) {
	$poTypeDoc = '3';
}
$poDate = $poIsDraftMode ? so_saved_iso_date_input($savedPo['date_po']) : date('Y-m-d');

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

<?php if (isset($_GET['saved']) && $_GET['saved'] === '1') { ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var cleanUrl = new URL(window.location.href);
			cleanUrl.searchParams.delete('saved');
			window.history.replaceState({}, document.title, cleanUrl);
			Swal.fire({
				title: 'บันทึกร่างเรียบร้อยแล้ว',
				text: 'เลขที่อ้างอิง: <?php echo so_saved_h($poDisplayRefId); ?>',
				icon: 'success',
				confirmButtonColor: '#612989',
				confirmButtonText: 'ตกลง'
			});
		});
	</script>
<?php } ?>

<form action="register_posave1.php" method="post" name="frmMain" id="frmMain" enctype="multipart/form-data" class="po-page" onsubmit="return false;" novalidate>
	<!-- ใบใหม่ส่ง ref_id ว่าง = ให้ตัวบันทึกจองเลขใหม่ ; ref_id_preview ใช้แสดงบน Preview เท่านั้น -->
	<input type="hidden" name="ref_id" id="ref_id" value="<?php echo $poIsDraftMode ? so_saved_h($savedPo['ref_id']) : ''; ?>">
	<input type="hidden" name="ref_id_preview" id="ref_id_preview" value="<?php echo so_saved_h($poDisplayRefId); ?>">

	<div class="w3-container po-layout">

		<div class="so-header-container">
			<div class="so-header-left">
				<h1 class="so-title po-title">ใบสั่งซื้อ (PO)</h1>
				<div class="so-ref-info">
					<span class="so-ref-label">เลขที่อ้างอิง</span>
					<span class="so-ref-value"><?php echo so_saved_h($poDisplayRefId); ?></span>
					<?php if ($poIsDraftMode) { ?>
						<span class="po-status-pill is-draft">Draft</span>
					<?php } ?>
				</div>
			</div>
			<div class="so-header-right">
				<button type="button" class="btn-so-draft po-action-btn" data-po-action="create_so" onclick="poSave('create_so', this);"><i class="fas fa-file-invoice" aria-hidden="true"></i> ออกใบสั่งขาย</button>
				<button type="button" class="btn-preview-so" onclick="poOpenPreview();">
					<img src="img/icons/preview.png" alt="" style="width:16px;height:16px;"> Preview
				</button>
			</div>
		</div>

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

		<!-- ===================== การ์ด 5: แนบไฟล์เพิ่มเติม (พฤติกรรมจาก js/doc-tabs-attach.js) ===================== -->
		<section class="so-card po-card" aria-labelledby="po_attach_title">
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
	</div>

	<div class="so-sticky-actions po-sticky-actions">
		<div class="so-sticky-actions-inner po-sticky-actions-inner">
			<div class="po-actions-main">
				<button type="button" class="btn-so-submit po-action-btn" data-po-action="submit" onclick="poSave('submit', this);"><i class="fas fa-paper-plane" aria-hidden="true"></i> Submit</button>
				<button type="button" class="btn-so-draft po-action-btn" data-po-action="draft" onclick="poSave('draft', this);"><i class="far fa-save" aria-hidden="true"></i> <?php echo $poIsDraftMode ? 'Update Draft' : 'Save Draft'; ?></button>
				<button type="button" class="btn-so-cancel-nav po-btn-back" onclick="window.location.href='status_adminpo.php';">ย้อนกลับ</button>
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
		isDraft: <?php echo $poIsDraftMode ? 'true' : 'false'; ?>,
		refId: <?php echo json_encode($poIsDraftMode ? (string)$savedPo['ref_id'] : '', JSON_UNESCAPED_UNICODE); ?>,
		savedItems: <?php echo json_encode($poSavedItemsForForm, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>,
		maxItems: <?php echo PO_MAX_ITEMS; ?>
	};
</script>
<script src="js/doc-tabs-attach.js?v=<?php echo filemtime(__DIR__ . '/js/doc-tabs-attach.js'); ?>"></script>
<script src="js/register-poawl.js?v=<?php echo filemtime(__DIR__ . '/js/register-poawl.js'); ?>"></script>
</body>
</html>
