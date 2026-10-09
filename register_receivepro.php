<?php
require_once __DIR__ . '/includes/so_saved_helpers.php';
require_once __DIR__ . '/includes/receivepro_repo.php';

$rpRequestedNo = isset($_GET['rp_no']) && !is_array($_GET['rp_no']) ? trim((string)$_GET['rp_no']) : '';
$rpRequestedCompany = isset($_GET['company']) && !is_array($_GET['company']) ? trim((string)$_GET['company']) : '';
// คัดลอกใบเดิม (?copy_from=) — ใช้เฉพาะตอนสร้างใบใหม่ (ไม่มี rp_no)
$rpCopyFromNo = ($rpRequestedNo === '' && isset($_GET['copy_from']) && !is_array($_GET['copy_from'])) ? trim((string)$_GET['copy_from']) : '';
?>
<?php include("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>
<?php include('dbconnect.php'); ?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-receivepro.css?v=<?php echo filemtime(__DIR__ . '/css/register-receivepro.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/so-required-fields.js?v=<?php echo filemtime(__DIR__ . '/js/so-required-fields.js'); ?>"></script>

<?php
date_default_timezone_set("Asia/Bangkok");

$rpBackUrl = 'status_receivepro_adm.php';
$rpStopPage = function ($message) use ($rpBackUrl) {
	echo '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red" style="max-width:1096px;margin:24px auto;box-sizing:border-box;">'
		. '<p>' . so_saved_h($message) . '</p>'
		. '<p><a href="' . so_saved_h($rpBackUrl) . '">กลับหน้ารายการใบรับสินค้า</a></p>'
		. '</div>';
	exit();
};

if (!rp_has_status_column($conn)) {
	$rpStopPage('ฐานข้อมูลยังไม่รองรับสถานะเอกสารของใบส่งสินค้า กรุณาแจ้งผู้ดูแลระบบให้รัน sql/receivepro_status_doc.sql');
}

$rpDocument = null;
$rpSavedItems = array();
if ($rpRequestedNo !== '') {
	$rpDocument = rp_load_document($conn, $rpRequestedNo);
	if ($rpDocument === null) {
		$rpStopPage('ไม่พบเอกสารเลขที่ ' . $rpRequestedNo);
	}
	$rpSavedItems = rp_items_for_form(rp_load_items($conn, $rpDocument['rp_no']));
}

/* คัดลอกใบเดิม: prefill หัวเอกสาร + รายการสินค้าเป็นใบใหม่ ($rpDocument ยังเป็น null → เลขใหม่ / วันนี้ / สถานะใบใหม่)
 * ไม่คัดลอกเลขที่เอกสาร (iv_noref), วันที่ และ flag สถานะ */
$rpCopySource = null;
if ($rpCopyFromNo !== '') {
	$rpCopySource = rp_load_document($conn, $rpCopyFromNo);
	if ($rpCopySource === null) {
		$rpStopPage('ไม่พบเอกสารเลขที่ ' . $rpCopyFromNo . ' สำหรับคัดลอก');
	}
	$rpSavedItems = rp_items_for_form(rp_load_items($conn, $rpCopySource['rp_no']));
	// id ของแถวต้นฉบับต้องไม่ติดไปกับใบใหม่
	foreach ($rpSavedItems as $rpItemIndex => $rpSavedItem) {
		$rpSavedItems[$rpItemIndex]['id'] = '';
	}
}
$rpCopySkipKeys = array('rp_no', 'iv_noref', 'iv_date', 'delivery_date', 'status_doc', 'cancel_ckk', 'remark_cancel', 'send_receive');

$rpMode = rp_mode($rpDocument);
$rpIsExisting = ($rpDocument !== null);
$rpReadOnly = ($rpMode === 'cancelled');
// หัวเอกสาร (บริษัท/เลขที่/วันที่/เขตการขาย) และการเพิ่มแถวสินค้า แก้ได้เฉพาะใบใหม่กับร่าง
$rpHeaderLocked = ($rpMode === 'submitted' || $rpMode === 'cancelled');
$rpIsSentReceive = $rpIsExisting && rp_is_sent_receive($rpDocument);
$rpDisplayNo = $rpIsExisting ? (string)$rpDocument['rp_no'] : rp_peek_next_rp_no($conn);

$rpValue = function ($key, $default = '') use ($rpDocument, $rpCopySource, $rpCopySkipKeys) {
	if ($rpDocument !== null) {
		return isset($rpDocument[$key]) ? (string)$rpDocument[$key] : $default;
	}
	if ($rpCopySource !== null && isset($rpCopySource[$key]) && !in_array($key, $rpCopySkipKeys, true)) {
		return (string)$rpCopySource[$key];
	}
	return $default;
};

// ใบที่คัดลอกมาใช้บริษัทของต้นฉบับ — รายการสินค้าที่ติดมาผูกกับบริษัทนั้น
$rpTypeCompany = ($rpIsExisting || $rpCopySource !== null) ? $rpValue('type_company', '1') : $rpRequestedCompany;
if (!array_key_exists($rpTypeCompany, rp_company_options())) {
	$rpTypeCompany = '1';
}
$rpIvDate = $rpIsExisting ? rp_iso_date_input($rpValue('iv_date')) : date('Y-m-d');
$rpDeliveryDate = $rpIsExisting ? rp_iso_date_input($rpValue('delivery_date')) : date('Y-m-d');
$rpShowName = $rpValue('show_name', '1') === '2' ? '2' : '1';
$rpCancelReason = ($rpMode === 'cancelled') ? trim($rpValue('remark_cancel')) : '';

/* แผนก/เขตการขาย — ชุดเดียวกับหน้าเดิม (tb_team_adm ทั้งหมด ฐาน sale ผ่าน $com) */
$rpSaleCodeOptions = array();
$rpSaleCodeQuery = mysqli_query($com, "SELECT sale_code, sale_name FROM tb_team_adm ORDER BY sale_code ASC");
while ($rpSaleCodeQuery && ($rpSaleCodeRow = mysqli_fetch_assoc($rpSaleCodeQuery))) {
	$rpSaleCodeOptions[] = $rpSaleCodeRow;
}
$rpSelectedSaleCode = $rpValue('sale_code');

/* ผลบันทึกจาก register_receivepro1.php — แสดงครั้งเดียวแล้วลบ param ออกจาก URL */
$rpSuccessTitles = array(
	'saved'     => 'บันทึกข้อมูลเรียบร้อยแล้ว',
	'submitted' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
	'updated'   => 'บันทึกข้อมูลเรียบร้อยแล้ว',
	'sent'      => 'ส่งข้อมูลไปรับจ่ายเรียบร้อยแล้ว',
	'cancelled' => 'ยกเลิกใบส่งสินค้าเรียบร้อยแล้ว',
);
$rpSuccessParam = '';
foreach ($rpSuccessTitles as $rpParam => $rpTitle) {
	if (isset($_GET[$rpParam]) && $_GET[$rpParam] === '1') {
		$rpSuccessParam = $rpParam;
		break;
	}
}
// การบันทึก (ร่าง/Submit/Update) ใช้ข้อความเดียวกับ register_suphos.php — ส่งรับจ่าย/ยกเลิก ยังบอกเลขที่อ้างอิง
$rpSuccessText = in_array($rpSuccessParam, array('saved', 'submitted', 'updated'), true)
	? 'ระบบแสดงข้อมูลที่บันทึกไว้ในหน้านี้แล้ว'
	: 'เลขที่อ้างอิง: ' . $rpDisplayNo;
$rpLockedAttr = $rpHeaderLocked ? ' disabled' : '';
?>
<?php if ($rpSuccessParam !== '') { ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var cleanUrl = new URL(window.location.href);
			cleanUrl.searchParams.delete(<?php echo json_encode($rpSuccessParam); ?>);
			window.history.replaceState({}, document.title, cleanUrl);
			Swal.fire({
				title: <?php echo json_encode($rpSuccessTitles[$rpSuccessParam], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>,
				text: <?php echo json_encode($rpSuccessText, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>,
				icon: 'success',
				confirmButtonColor: '#612989',
				confirmButtonText: 'ตกลง'
			});
		});
	</script>
<?php } ?>

<form action="register_receivepro1.php" method="post" name="frmMain" id="frmMain" class="rp-page<?php echo $rpReadOnly ? ' is-readonly' : ''; ?>" onsubmit="return false;" novalidate>
	<!-- ใบใหม่ส่ง rp_no ว่าง = ให้ตัวบันทึกจองเลขใหม่ -->
	<input type="hidden" name="rp_no" id="rp_no" value="<?php echo $rpIsExisting ? so_saved_h($rpDocument['rp_no']) : ''; ?>">

	<div class="rp-content">
		<div class="so-header-container">
			<div class="so-header-left">
				<div class="so-title-row">
					<button type="button" class="so-back-btn" onclick="window.location.href=<?php echo so_saved_h(json_encode($rpBackUrl)); ?>;" title="ย้อนกลับ" aria-label="ย้อนกลับ">
						<img src="img/icons/chevron_left.svg" alt="">
					</button>
					<h1 class="so-title rp-title">ใบส่งสินค้า (Delivery Note)</h1>
				</div>
				<div class="so-ref-info">
					<span class="so-ref-label">เลขที่อ้างอิง</span>
					<span class="so-ref-value"><?php echo so_saved_h($rpDisplayNo); ?></span>
					<?php if ($rpMode === 'cancelled') { ?>
						<span class="rp-status-pill is-cancelled">ยกเลิก</span>
					<?php } ?>
				</div>
			</div>
		</div>

		<?php if ($rpCancelReason !== '') { ?>
			<div class="so-latest-reason-banner is-cancelled" role="status">
				<button type="button" class="so-latest-reason-close" aria-label="ปิด" onclick="this.closest('.so-latest-reason-banner').style.display='none';">&times;</button>
				<div class="so-latest-reason-title">เหตุผลในการยกเลิก</div>
				<div class="so-latest-reason-text"><?php echo nl2br(so_saved_h($rpCancelReason)); ?></div>
			</div>
		<?php } ?>

		<?php if ($rpReadOnly) { ?>
			<!-- อ่านอย่างเดียว: fieldset disabled ปิดทุก input/select/button ในการ์ด -->
			<fieldset class="rp-readonly-fieldset" disabled>
		<?php } ?>

		<!-- ===================== การ์ด 1: ข้อมูลเอกสาร ===================== -->
		<section class="so-card rp-card" id="rp_card_doc" aria-label="ข้อมูลเอกสาร">
			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="type_company_select">บริษัท<span class="required">*</span></label>
					<div class="so-select-wrapper">
						<?php if ($rpHeaderLocked) { ?>
							<!-- select ที่ disabled ไม่ถูกส่ง — ตัวบันทึกยังต้องรู้บริษัทของเอกสาร -->
							<input type="hidden" name="type_company" value="<?php echo so_saved_h($rpTypeCompany); ?>">
						<?php } ?>
						<select class="so-select" id="type_company_select"<?php echo $rpHeaderLocked ? ' disabled' : ' name="type_company"'; ?>>
							<?php foreach (rp_company_options() as $rpCompanyValue => $rpCompanyLabel) { ?>
								<option value="<?php echo so_saved_h($rpCompanyValue); ?>" <?php echo (string)$rpCompanyValue === $rpTypeCompany ? 'selected' : ''; ?>><?php echo so_saved_h($rpCompanyLabel); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="iv_noref">เลขที่เอกสาร</label>
					<input type="text" name="iv_noref" id="iv_noref" class="so-input" maxlength="50" autocomplete="off" placeholder="No." value="<?php echo so_saved_h($rpValue('iv_noref')); ?>"<?php echo $rpLockedAttr; ?>>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="iv_date">วันที่ออกเอกสาร</label>
					<div class="so-input-wrapper calendar-wrapper<?php echo $rpHeaderLocked ? ' is-locked' : ''; ?>">
						<input type="date" name="iv_date" id="iv_date" class="so-input" value="<?php echo so_saved_h($rpIvDate); ?>"<?php echo $rpLockedAttr; ?>>
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="delivery_date">วันที่ส่งของ</label>
					<div class="so-input-wrapper calendar-wrapper<?php echo $rpHeaderLocked ? ' is-locked' : ''; ?>">
						<input type="date" name="delivery_date" id="delivery_date" class="so-input" value="<?php echo so_saved_h($rpDeliveryDate); ?>"<?php echo $rpLockedAttr; ?>>
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="sale_code">แผนก/เขตการขาย</label>
					<div class="so-select-wrapper">
						<select name="sale_code" id="sale_code" class="so-select"<?php echo $rpLockedAttr; ?>>
							<option value="">Select</option>
							<?php
							$rpSaleCodeFound = false;
							foreach ($rpSaleCodeOptions as $rpOption) {
								$rpIsSelected = ((string)$rpOption['sale_code'] === $rpSelectedSaleCode);
								$rpSaleCodeFound = $rpSaleCodeFound || $rpIsSelected;
							?>
								<option value="<?php echo so_saved_h($rpOption['sale_code']); ?>" <?php echo $rpIsSelected ? 'selected' : ''; ?>><?php echo so_saved_h($rpOption['sale_code'] . ' - ' . $rpOption['sale_name']); ?></option>
							<?php } ?>
							<?php if ($rpSelectedSaleCode !== '' && !$rpSaleCodeFound) { ?>
								<!-- รหัสที่บันทึกไว้แต่ไม่อยู่ในข้อมูลหลักแล้ว ต้องไม่หายตอนบันทึกซ้ำ -->
								<option value="<?php echo so_saved_h($rpSelectedSaleCode); ?>" selected><?php echo so_saved_h($rpSelectedSaleCode); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="show_name">การแสดงชื่อในแบบฟอร์ม</label>
					<div class="so-select-wrapper">
						<select name="show_name" id="show_name" class="so-select">
							<option value="1" <?php echo $rpShowName === '1' ? 'selected' : ''; ?>>แสดงชื่อลูกค้า</option>
							<option value="2" <?php echo $rpShowName === '2' ? 'selected' : ''; ?>>แสดงชื่อออกบิล</option>
						</select>
					</div>
				</div>
			</div>

			<!-- ทำทันทีหลังยืนยัน (ไม่รอปุ่ม Update) — ใช้ได้เฉพาะเอกสารที่ Submit แล้ว -->
			<div class="so-grid-3 rp-doc-actions">
				<button type="button" class="rp-doc-action-btn rp-action-btn" id="btn_send_receive" data-rp-action="send_receive" onclick="rpSendReceive(this);"
					<?php echo ($rpMode !== 'submitted' || $rpIsSentReceive) ? 'disabled' : ''; ?>
					<?php echo ($rpMode !== 'submitted') ? 'title="ใช้ได้หลัง Submit เอกสาร"' : ''; ?>>
					<?php echo $rpIsSentReceive ? '<i class="fas fa-check" aria-hidden="true"></i> ส่งข้อมูลไปรับจ่ายแล้ว' : 'ส่งข้อมูลไปรับจ่าย'; ?>
				</button>
				<button type="button" class="rp-doc-action-btn rp-action-btn" id="btn_cancel_doc" data-rp-action="cancel" onclick="rpCancelDocument(this);"
					<?php echo ($rpMode !== 'submitted') ? 'disabled' : ''; ?>
					<?php echo ($rpMode === 'new' || $rpMode === 'draft') ? 'title="ใช้ได้หลัง Submit เอกสาร"' : ''; ?>>
					<?php echo $rpMode === 'cancelled' ? 'ยกเลิกใบส่งสินค้าแล้ว' : 'ยกเลิกใบส่งสินค้า'; ?>
				</button>
			</div>
		</section>

		<!-- ===================== การ์ด 2: ข้อมูลลูกค้า ===================== -->
		<section class="so-card rp-card" id="rp_card_customer" aria-labelledby="rp_customer_title">
			<div class="so-section-title-container rp-section-head">
				<h2 class="so-section-title" id="rp_customer_title">ข้อมูลลูกค้า</h2>
				<hr class="so-divider">
			</div>

			<div class="so-field-group rp-field-third">
				<label class="so-label" for="customer">ชื่อลูกค้า<span class="required">*</span></label>
				<div class="so-input-wrapper">
					<input type="text" name="customer" id="customer" class="so-input" maxlength="300" autocomplete="off" placeholder="ระบุชื่อลูกค้า" value="<?php echo so_saved_h($rpValue('customer')); ?>">
					<button type="button" class="so-input-clear" data-rp-clear="customer" aria-label="ล้างชื่อลูกค้า">&times;</button>
				</div>
			</div>

			<div class="so-field-group">
				<label class="so-label" for="address">ที่อยู่</label>
				<div class="so-input-wrapper">
					<input type="text" name="address" id="address" class="so-input" maxlength="300" autocomplete="off" placeholder="ระบุที่อยู่" value="<?php echo so_saved_h($rpValue('address')); ?>">
					<button type="button" class="so-input-clear" data-rp-clear="address" aria-label="ล้างที่อยู่">&times;</button>
				</div>
			</div>

			<div class="so-field-group rp-field-third">
				<label class="so-label" for="bill_name">ชื่อออกบิล<span class="required">*</span></label>
				<div class="so-input-wrapper">
					<input type="text" name="bill_name" id="bill_name" class="so-input" maxlength="300" autocomplete="off" placeholder="ระบุชื่อออกบิล" value="<?php echo so_saved_h($rpValue('bill_name')); ?>">
					<button type="button" class="so-input-clear" data-rp-clear="bill_name" aria-label="ล้างชื่อออกบิล">&times;</button>
				</div>
			</div>

			<div class="so-field-group rp-field-last">
				<label class="so-label" for="bill_address">ที่อยู่ออกบิล<span class="required">*</span></label>
				<div class="so-input-wrapper">
					<input type="text" name="bill_address" id="bill_address" class="so-input" maxlength="300" autocomplete="off" placeholder="ระบุที่อยู่ออกบิล" value="<?php echo so_saved_h($rpValue('bill_address')); ?>">
					<button type="button" class="so-input-clear" data-rp-clear="bill_address" aria-label="ล้างที่อยู่ออกบิล">&times;</button>
				</div>
			</div>
		</section>

		<!-- ===================== การ์ด 3: รายการสินค้า (แถวสร้างโดย js/register-receivepro.js) ===================== -->
		<section class="so-card rp-card rp-items-card" id="rp_card_items" aria-labelledby="rp_items_title">
			<div class="so-section-title-container rp-section-head">
				<div class="rp-items-head">
					<h2 class="so-section-title" id="rp_items_title">รายการสินค้า</h2>
					<span class="rp-items-count" id="rp_items_count" aria-live="polite">0 รายการ</span>
				</div>
				<hr class="so-divider">
			</div>

			<div class="rp-summary-bar">
				<div class="rp-summary-col">
					<div class="rp-summary-label">จำนวนรวม(ชิ้น)</div>
					<div class="rp-summary-value" id="rp_total_qty">0</div>
				</div>
			</div>

			<div class="rp-items-toolbar">
				<?php if (!$rpHeaderLocked) { ?>
					<div class="so-field-group rp-search-group">
						<label class="so-label" for="rp_product_search">ค้นหารายการสินค้า</label>
						<div class="rp-search-box">
							<i class="fas fa-search rp-search-icon" aria-hidden="true"></i>
							<input type="text" id="rp_product_search" class="so-input rp-search-input" autocomplete="off" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า"
								role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="rp_product_results">
							<ul class="rp-search-results" id="rp_product_results" role="listbox" hidden></ul>
						</div>
					</div>
				<?php } ?>
				<button type="button" class="rp-bulk-delete-btn" id="rp_bulk_delete" hidden>
					<img src="img/icons/trash.svg" alt=""> ลบรายการที่เลือก (<span id="rp_bulk_count">0</span>)
				</button>
			</div>

			<div class="rp-table-wrap">
				<table class="rp-items-table">
					<thead>
						<tr>
							<th class="rp-col-drag" scope="col"><span class="rp-sr-only">เรียงลำดับ</span></th>
							<th class="rp-col-check" scope="col">
								<label class="rp-check">
									<input type="checkbox" id="rp_check_all" aria-label="เลือกทุกรายการ">
									<span class="rp-check-mark" aria-hidden="true"></span>
								</label>
							</th>
							<th class="rp-col-code" scope="col">รหัสสินค้า</th>
							<th class="rp-col-name" scope="col">รายการสินค้า</th>
							<th class="rp-col-qty" scope="col">จำนวน</th>
							<th class="rp-col-actions" scope="col">เพิ่มเติม</th>
						</tr>
					</thead>
					<tbody id="rp_items_body"></tbody>
				</table>
				<div class="rp-items-empty" id="rp_items_empty">
					<?php echo $rpHeaderLocked ? 'ไม่มีรายการสินค้า' : 'ยังไม่มีรายการสินค้า — ค้นหาด้วยรหัสหรือชื่อสินค้าเพื่อเพิ่มรายการ'; ?>
				</div>
			</div>
		</section>

		<?php if ($rpReadOnly) { ?>
			</fieldset>
		<?php } ?>
	</div>

	<?php if (!$rpReadOnly) { ?>
		<div class="so-sticky-actions rp-sticky-actions">
			<div class="so-sticky-actions-inner">
				<?php if ($rpMode === 'submitted') { ?>
					<button type="button" class="btn-so-submit rp-action-btn" data-rp-action="update" onclick="rpSave('update', this);"><i class="far fa-save" aria-hidden="true"></i> Update</button>
					<!-- แบบฟอร์มพิมพ์อ่านจากข้อมูลที่บันทึกแล้ว — พิมพ์ได้เฉพาะเอกสารที่ Submit แล้ว -->
					<div class="rp-print-wrap">
						<button type="button" class="btn-so-draft rp-print-trigger" id="btn_rp_print" aria-haspopup="true" aria-expanded="false" aria-controls="rpPrintMenu" onclick="rpTogglePrintMenu();">
							<img src="img/icons/print.svg" alt=""> พิมพ์ใบส่งสินค้า
						</button>
						<div id="rpPrintMenu" class="so-overflow-menu rp-print-menu" role="menu" hidden>
							<?php foreach (rp_print_forms() as $rpFormFile => $rpFormLabel) { ?>
								<a role="menuitem" class="rp-print-item" target="_blank" rel="noopener" href="<?php echo so_saved_h($rpFormFile . '?rp_no=' . rawurlencode((string)$rpDocument['rp_no'])); ?>"><?php echo so_saved_h($rpFormLabel); ?></a>
							<?php } ?>
						</div>
					</div>
				<?php } else { ?>
					<button type="button" class="btn-so-submit rp-action-btn" data-rp-action="submit" onclick="rpSave('submit', this);"><i class="far fa-paper-plane" aria-hidden="true"></i> Submit</button>
					<button type="button" class="btn-so-draft rp-action-btn" data-rp-action="draft" onclick="rpSave('draft', this);"><i class="far fa-save" aria-hidden="true"></i> <?php echo $rpMode === 'draft' ? 'Update' : 'Save Draft'; ?></button>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</form>

<!-- ===================== Popup ข้อมูลรายการสินค้าเพิ่มเติม (ปุ่มดินสอของแถว) ===================== -->
<div id="rpItemModal" class="rp-modal" aria-hidden="true" hidden>
	<div class="rp-modal-box" role="dialog" aria-modal="true" aria-labelledby="rpItemModalTitle">
		<button type="button" class="rp-modal-close" onclick="rpCloseItemModal();" aria-label="ปิด">&times;</button>
		<h2 class="rp-modal-title" id="rpItemModalTitle">ข้อมูลรายการสินค้าเพิ่มเติม</h2>
		<hr class="so-divider">
		<div class="rp-modal-grid">
			<div class="so-field-group">
				<label class="so-label" for="rp_modal_remark">หมายเหตุสินค้า</label>
				<div class="so-input-wrapper">
					<input type="text" id="rp_modal_remark" class="so-input" maxlength="300" autocomplete="off" placeholder="ระบุหมายเหตุสินค้า">
					<button type="button" class="so-input-clear" data-rp-clear="rp_modal_remark" aria-label="ล้างหมายเหตุสินค้า">&times;</button>
				</div>
			</div>
			<div class="so-field-group">
				<label class="so-label" for="rp_modal_proname">ชื่อที่แสดงในใบส่งสินค้า</label>
				<div class="so-input-wrapper">
					<input type="text" id="rp_modal_proname" class="so-input" maxlength="500" autocomplete="off" placeholder="ระบุชื่อที่แสดงในใบส่งสินค้า">
					<button type="button" class="so-input-clear" data-rp-clear="rp_modal_proname" aria-label="ล้างชื่อที่แสดงในใบส่งสินค้า">&times;</button>
				</div>
			</div>
		</div>
		<div class="rp-modal-actions">
			<button type="button" class="btn-so-submit" onclick="rpConfirmItemModal();">อัพเดท</button>
			<button type="button" class="btn-so-draft rp-modal-cancel" onclick="rpCloseItemModal();">ยกเลิก</button>
		</div>
	</div>
</div>

<script>
	window.rpPageConfig = {
		mode: <?php echo json_encode($rpMode); ?>,
		rpNo: <?php echo json_encode($rpIsExisting ? (string)$rpDocument['rp_no'] : '', JSON_UNESCAPED_UNICODE); ?>,
		savedItems: <?php echo json_encode($rpSavedItems, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG); ?>,
		maxItems: <?php echo RP_MAX_ITEMS; ?>,
		canAddRows: <?php echo $rpHeaderLocked ? 'false' : 'true'; ?>,
		readOnly: <?php echo $rpReadOnly ? 'true' : 'false'; ?>,
		sentReceive: <?php echo $rpIsSentReceive ? 'true' : 'false'; ?>
	};
</script>
<script src="js/register-receivepro.js?v=<?php echo filemtime(__DIR__ . '/js/register-receivepro.js'); ?>"></script>
</body>
</html>
