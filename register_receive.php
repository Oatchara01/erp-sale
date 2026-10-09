<?php
require_once __DIR__ . '/includes/so_saved_helpers.php';
require_once __DIR__ . '/includes/receive_repo.php';

$rcRequestedRef = isset($_GET['receive_ref']) && !is_array($_GET['receive_ref']) ? trim((string)$_GET['receive_ref']) : '';
$rcRequestedType = isset($_GET['source_type']) && !is_array($_GET['source_type']) ? trim((string)$_GET['source_type']) : '';
$rcRequestedSource = isset($_GET['source_ref']) && !is_array($_GET['source_ref']) ? trim((string)$_GET['source_ref']) : '';
?>
<?php include("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>
<?php include('dbconnect.php'); ?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-receivepro.css?v=<?php echo filemtime(__DIR__ . '/css/register-receivepro.css'); ?>">
<link rel="stylesheet" href="css/register-receive.css?v=<?php echo filemtime(__DIR__ . '/css/register-receive.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/so-required-fields.js?v=<?php echo filemtime(__DIR__ . '/js/so-required-fields.js'); ?>"></script>

<?php
date_default_timezone_set("Asia/Bangkok");

$rcStopPage = function ($message, $backUrl = 'index.php', $backLabel = 'กลับหน้าหลัก') {
	echo '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red" style="max-width:1096px;margin:24px auto;box-sizing:border-box;">'
		. '<p>' . so_saved_h($message) . '</p>'
		. '<p><a href="' . so_saved_h($backUrl) . '">' . so_saved_h($backLabel) . '</a></p>'
		. '</div>';
	exit();
};

if (!rc_has_source_columns($conn)) {
	$rcStopPage('ฐานข้อมูลยังไม่รองรับใบคืนสินค้าแบบรวม กรุณาแจ้งผู้ดูแลระบบให้รัน sql/receive_source.sql');
}

/* ---------- โหลดใบคืน (แก้ไข/ดู) หรือเอกสารต้นทาง (ใบใหม่) ---------- */
$rcReceipt = null;
$rcIsLegacy = false;
if ($rcRequestedRef !== '') {
	$rcReceipt = rc_load_receipt($conn, $rcRequestedRef);
	if ($rcReceipt === null) {
		$rcStopPage('ไม่พบใบคืนเลขที่ ' . $rcRequestedRef);
	}
	// ใบคืนจากฟอร์มเดิมไม่มีต้นทางผูกไว้ — เปิดดูได้อย่างเดียวจากข้อมูลของใบคืนเอง
	$rcIsLegacy = !rc_is_unified($rcReceipt);
	$rcSourceType = (string)$rcReceipt['source_type'];
	$rcSourceRef = (string)$rcReceipt['source_ref'];
} else {
	$rcSourceType = $rcRequestedType;
	$rcSourceRef = $rcRequestedSource;
}

if ($rcIsLegacy) {
	$rcSource = rc_legacy_source($rcReceipt);
} else {
	$rcSource = rc_load_source($conn, $rcSourceType, $rcSourceRef);
	$rcPages = rc_source_pages($rcSourceType);
	if ($rcSource === null || $rcPages === null) {
		$rcStopPage('ไม่พบเอกสารต้นทาง');
	}
	$rcBackUrl = $rcPages['list'];
	if (!$rcSource['approved']) {
		$rcStopPage('เอกสารต้นทางยังไม่อนุมัติ จึงคืนสินค้าไม่ได้', $rcBackUrl, 'กลับหน้ารายการ');
	}
	if ($rcSource['needs_doc_no']) {
		$rcStopPage($rcSource['label'] . ' เลขที่ ' . $rcSource['ref'] . ' ยังไม่มีเลขที่เอกสาร จึงคืนสินค้าไม่ได้', $rcBackUrl, 'กลับหน้ารายการ');
	}
}

$rcIsExisting = ($rcReceipt !== null);
$rcIsSubmitted = $rcIsExisting && rc_is_submitted($rcReceipt);
$rcMode = !$rcIsExisting ? 'new' : ($rcIsLegacy ? 'legacy' : ($rcIsSubmitted ? 'submitted' : 'draft'));
$rcReceiveRef = $rcIsExisting ? (string)$rcReceipt['ref_id'] : '';
$rcDisplayRef = $rcIsExisting ? $rcReceiveRef : rc_peek_next_ref_id($conn);

if ($rcIsLegacy) {
	/* ---------- ใบคืนจากฟอร์มเดิม: รายการตามที่บันทึก ไม่มียอดค้าง/ราคา ---------- */
	$rcLegacy = rc_legacy_lines($conn, $rcReceiveRef);
	$rcLines = $rcLegacy['lines'];
	$rcSelection = $rcLegacy['selection'];
} else {
	/* ---------- ยอดค้าง → รายการที่แสดง (ไม่นับใบที่กำลังเปิดเป็นยอดคืน) ---------- */
	$rcState = rc_compute($conn, $rcSource, $rcReceiveRef);
	$rcSelection = array();
	if ($rcIsExisting) {
		$rcSelection = rc_selection_for_receipt($rcState['lines'], rc_load_receipt_lines($conn, $rcReceiveRef));
	}
	$rcLines = $rcState['lines'];
	if ($rcIsSubmitted) {
		// ใบที่ส่งให้ Stock แล้วแสดงเฉพาะที่คืนจริง
		$rcLines = array_values(array_filter($rcLines, function ($line) use ($rcSelection) {
			return isset($rcSelection[$line['key']]);
		}));
	}
}
if ($rcMode === 'new' && count($rcLines) === 0) {
	$rcStopPage('เอกสารนี้คืนสินค้าครบแล้ว ไม่มีรายการค้างให้คืน', $rcBackUrl, 'กลับหน้ารายการ');
}

/* กลุ่มรายการตามแถวของเอกสารต้นทาง — แถวที่มี S/N แตกเป็นรายเครื่อง ส่วนแถวไม่มี S/N คืนเป็นจำนวน */
$rcGroups = array();
foreach ($rcLines as $rcLine) {
	$rcGroups[$rcLine['item_id']]['info'] = $rcLine;
	$rcGroups[$rcLine['item_id']]['lines'][] = $rcLine;
}
/* เปิดฉบับร่างกลับมา: กลุ่มที่เคยบันทึกเรียงตามลำดับที่ผู้ใช้ลากไว้ (id ของ hos__subreceive) แถวที่เหลือต่อท้ายตามเอกสารต้นทาง */
if (count($rcSelection) > 0) {
	$rcOrderedGroups = array();
	foreach (array_keys($rcSelection) as $rcSelectedKey) {
		$rcSelectedItem = (int)explode(':', (string)$rcSelectedKey)[0];
		if (isset($rcGroups[$rcSelectedItem]) && !isset($rcOrderedGroups[$rcSelectedItem])) {
			$rcOrderedGroups[$rcSelectedItem] = $rcGroups[$rcSelectedItem];
		}
	}
	foreach ($rcGroups as $rcGroupId => $rcGroupData) {
		if (!isset($rcOrderedGroups[$rcGroupId])) {
			$rcOrderedGroups[$rcGroupId] = $rcGroupData;
		}
	}
	$rcGroups = $rcOrderedGroups;
}
/* วันหมดอายุของแถวย่อย S/N จากฐาน Stock (อ่านอย่างเดียว) — ไม่พบ/ใช้ฐานไม่ได้ = ว่าง */
$rcExpiry = $rcIsLegacy ? array() : rc_expiry_for_lines(isset($new) ? $new : null, $rcLines);

/* ---------- ค่าในฟอร์ม ---------- */
$rcValue = function ($key, $default = '') use ($rcReceipt) {
	return ($rcReceipt !== null && isset($rcReceipt[$key])) ? (string)$rcReceipt[$key] : $default;
};
$rcDateReceive = $rcIsExisting ? substr($rcValue('date_receive'), 0, 10) : date('Y-m-d');
if (!rc_valid_iso_date($rcDateReceive)) {
	$rcDateReceive = '';
}
$rcReceiveCkk = $rcValue('receive_ckk', '1') === '2' ? '2' : '1';
/* เวลาในการจัดส่ง: ช่อง type="time" ต้องการ HH:MM — ค่าที่เคยบันทึกเป็นข้อความใช้เวลาแรกที่พบ */
$rcTimeBetween = preg_match('/([01]\d|2[0-3]):[0-5]\d/', $rcValue('time_between'), $rcTimeMatch) ? $rcTimeMatch[0] : '';
$rcAddress = $rcIsExisting ? $rcValue('customer_address') : $rcSource['address'];
$rcOrderId = $rcIsExisting ? $rcValue('order_id') : $rcSource['order_id'];
$rcSelectedSaleCode = $rcIsExisting ? $rcValue('sale_code') : $rcSource['sale_code'];
/* บริษัทของใบคืน: เริ่มจากบริษัทของเอกสารต้นทาง (ใบเดิมใช้ค่าที่บันทึก) ผู้ใช้เลือก AWL / NBM เองได้ */
$rcTypeCompany = $rcIsExisting && array_key_exists($rcValue('type_company'), rc_company_options()) ? $rcValue('type_company') : $rcSource['type_company'];
$rcCompanyOptions = rc_company_options();
$rcCustomerCard = $rcIsLegacy ? null : rc_customer_card($conn, $rcSource);
$rcReadOnly = $rcIsSubmitted || $rcIsLegacy;

/* หมายเหตุรวมของ Stock — เฉพาะใบที่บันทึกแล้ว */
$rcStockDes = trim($rcValue('stock_des'));

$rcSaleCodeOptions = array();
$rcSaleCodeQuery = mysqli_query($com, "SELECT sale_code, sale_name FROM tb_team_adm ORDER BY sale_code ASC");
while ($rcSaleCodeQuery && ($rcSaleCodeRow = mysqli_fetch_assoc($rcSaleCodeQuery))) {
	$rcSaleCodeOptions[] = $rcSaleCodeRow;
}

/* ผลบันทึกจาก register_receive1.php — แสดงครั้งเดียวแล้วลบ param ออกจาก URL
   ข้อความ popup เดียวกับ register_suphos.php (ทั้ง Save Draft และ Submit) */
$rcSuccessTitles = array(
	'saved'     => 'บันทึกข้อมูลเรียบร้อยแล้ว',
	'submitted' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
);
$rcSuccessText = 'ระบบแสดงข้อมูลที่บันทึกไว้ในหน้านี้แล้ว';
$rcSuccessParam = '';
foreach ($rcSuccessTitles as $rcParam => $rcTitle) {
	if (isset($_GET[$rcParam]) && $_GET[$rcParam] === '1') {
		$rcSuccessParam = $rcParam;
		break;
	}
}
?>
<?php if ($rcSuccessParam !== '') { ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var cleanUrl = new URL(window.location.href);
			cleanUrl.searchParams.delete(<?php echo json_encode($rcSuccessParam); ?>);
			window.history.replaceState({}, document.title, cleanUrl);
			Swal.fire({
				title: <?php echo json_encode($rcSuccessTitles[$rcSuccessParam], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>,
				text: <?php echo json_encode($rcSuccessText, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>,
				icon: 'success',
				confirmButtonColor: '#612989',
				confirmButtonText: 'ตกลง'
			});
		});
	</script>
<?php } ?>

<form action="register_receive1.php" method="post" name="frmMain" id="frmMain" enctype="multipart/form-data" class="rp-page rc-page<?php echo $rcReadOnly ? ' is-readonly' : ''; ?>" onsubmit="return false;" novalidate>
	<!-- ใบใหม่: ส่งต้นทางให้ตัวบันทึกจองเลขใหม่ | ใบเดิม: ส่ง receive_ref (ตัวบันทึกอ่านต้นทางจากใบเอง) -->
	<input type="hidden" name="receive_ref" id="receive_ref" value="<?php echo so_saved_h($rcReceiveRef); ?>">
	<input type="hidden" name="source_type" value="<?php echo so_saved_h($rcSource['type']); ?>">
	<input type="hidden" name="source_ref" value="<?php echo so_saved_h($rcSource['ref']); ?>">

	<div class="rp-content">
		<div class="so-header-container">
			<div class="so-header-left">
				<div class="so-title-row">
					<button type="button" class="so-back-btn" onclick="window.location.href='status_receive_suppro.php';" title="ย้อนกลับ" aria-label="ย้อนกลับ">
						<img src="img/icons/chevron_left.svg" alt="">
					</button>
					<h1 class="so-title rp-title">ใบคืนสินค้า</h1>
				</div>
				<div class="so-ref-info">
					<span class="so-ref-label">เลขที่อ้างอิง</span>
					<span class="so-ref-value"><?php echo so_saved_h($rcDisplayRef); ?></span>
				</div>
			</div>
		</div>

		<?php if ($rcStockDes !== '') { ?>
			<div class="rc-head-note"><span class="rc-head-note-label">หมายเหตุจาก Stock:</span> <?php echo nl2br(so_saved_h($rcStockDes)); ?></div>
		<?php } ?>

		<?php if ($rcReadOnly) { ?>
			<!-- ส่งให้ Stock แล้ว: อ่านอย่างเดียว fieldset disabled ปิดทุก input/select/button ในการ์ด -->
			<fieldset class="rp-readonly-fieldset" disabled>
		<?php } ?>

		<!-- ===================== การ์ด 1: ข้อมูลเอกสาร ===================== -->
		<!-- แท็บ "ข้อมูลเอกสาร" (แท็บ Admin ยังไม่ทำในรอบนี้ ตามแผน Q26) -->
		<div class="so-tabs-container rc-card-tabs">
			<button type="button" class="so-tab-btn active" tabindex="-1">ข้อมูลเอกสาร</button>
		</div>
		<section class="so-card rp-card" id="rc_card_doc" aria-label="ข้อมูลเอกสาร">
			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="type_company">บริษัท<span class="required">*</span></label>
					<div class="so-select-wrapper">
						<select name="type_company" id="type_company" class="so-select">
							<?php if ($rcTypeCompany === '') { ?>
								<!-- ใบคืนจากฟอร์มเดิมที่ไม่ได้บันทึกบริษัท -->
								<option value="" selected>-</option>
							<?php } ?>
							<?php foreach ($rcCompanyOptions as $rcCompanyValue => $rcCompanyLabel) { ?>
								<option value="<?php echo so_saved_h($rcCompanyValue); ?>" <?php echo (string)$rcCompanyValue === $rcTypeCompany ? 'selected' : ''; ?>><?php echo so_saved_h($rcCompanyLabel); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="sale_code">แผนก/เขตการขาย</label>
					<div class="so-select-wrapper">
						<select name="sale_code" id="sale_code" class="so-select">
							<option value="">Select</option>
							<?php
							$rcSaleCodeFound = false;
							foreach ($rcSaleCodeOptions as $rcOption) {
								$rcIsSelected = ((string)$rcOption['sale_code'] === $rcSelectedSaleCode);
								$rcSaleCodeFound = $rcSaleCodeFound || $rcIsSelected;
							?>
								<option value="<?php echo so_saved_h($rcOption['sale_code']); ?>" <?php echo $rcIsSelected ? 'selected' : ''; ?>><?php echo so_saved_h($rcOption['sale_code'] . ' - ' . $rcOption['sale_name']); ?></option>
							<?php } ?>
							<?php if ($rcSelectedSaleCode !== '' && !$rcSaleCodeFound) { ?>
								<!-- รหัสที่ไม่อยู่ในข้อมูลหลักแล้ว ต้องไม่หายตอนบันทึกซ้ำ -->
								<option value="<?php echo so_saved_h($rcSelectedSaleCode); ?>" selected><?php echo so_saved_h($rcSelectedSaleCode); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</section>

		<!-- ===================== การ์ด 2: ข้อมูลเอกสารอ้างอิงและลูกค้า ===================== -->
		<section class="so-card rp-card" id="rc_card_customer" aria-labelledby="rc_customer_title">
			<div class="so-section-title-container rp-section-head">
				<h2 class="so-section-title" id="rc_customer_title">ข้อมูลเอกสารอ้างอิง</h2>
				<hr class="so-divider">
			</div>

			<div class="so-customer-top-grid">
				<div class="so-customer-top-left">
					<?php if (!$rcIsLegacy) { ?>
						<div class="rc-doc-pill-wrap">
							<a class="rc-doc-pill" href="<?php echo so_saved_h(rc_source_view_url($rcSource['type'], $rcSource['ref'])); ?>" target="_blank" rel="noopener">
								<i class="far fa-file-alt" aria-hidden="true"></i> ข้อมูลเอกสาร
							</a>
						</div>
					<?php } ?>

					<div class="so-field-group">
						<label class="so-label" for="doc_ref_view"><?php echo so_saved_h($rcSource['label']); ?> (เอกสารอ้างอิง)</label>
						<div class="so-input-wrapper">
							<input type="text" id="doc_ref_view" class="so-input" value="<?php echo so_saved_h($rcSource['doc_no'] !== '' ? $rcSource['doc_no'] : $rcSource['ref']); ?>" readonly>
						</div>
					</div>

					<div class="so-field-group">
						<label class="so-label" for="order_id">หมายเลขคำสั่งซื้อ</label>
						<div class="so-input-wrapper">
							<input type="text" name="order_id" id="order_id" class="so-input" maxlength="100" autocomplete="off" value="<?php echo so_saved_h($rcOrderId); ?>">
							<button type="button" class="so-input-clear" data-rp-clear="order_id" aria-label="ล้างหมายเลขคำสั่งซื้อ">&times;</button>
						</div>
					</div>
				</div>

				<div class="so-customer-top-right">
					<div class="so-field-group">
						<label class="so-label">ข้อมูลลูกค้า</label>
						<div class="customer-info-display-card">
							<div class="cidc-col">
								<?php if ($rcCustomerCard !== null) { ?>
									<div class="cidc-row">
										<div class="cidc-label">รหัสสมาชิก</div>
										<div class="cidc-value"><span class="cidc-display-text"><?php echo so_saved_h($rcCustomerCard['customer_no']); ?></span></div>
									</div>
								<?php } ?>
								<div class="cidc-row">
									<div class="cidc-label">เบอร์โทรศัพท์</div>
									<div class="cidc-value"><span class="cidc-display-text"><?php echo so_saved_h($rcSource['customer_tel'] !== '' ? $rcSource['customer_tel'] : '-'); ?></span></div>
								</div>
								<?php if ($rcCustomerCard !== null) { ?>
									<div class="cidc-row">
										<div class="cidc-label">สถานะลูกค้า</div>
										<div class="cidc-value">
											<?php if ($rcCustomerCard['is_vip']) { ?><img src="img/icons/vip.png" class="cidc-status-icon" alt="VIP"><?php } ?>
											<span class="cidc-display-text"><?php echo so_saved_h($rcCustomerCard['status_name']); ?></span>
										</div>
									</div>
								<?php } ?>
							</div>
							<div class="cidc-col">
								<div class="cidc-row">
									<div class="cidc-label">ชื่อลูกค้า</div>
									<div class="cidc-value"><span class="cidc-display-text"><?php echo so_saved_h($rcSource['customer_name']); ?></span></div>
								</div>
								<?php if ($rcCustomerCard !== null) { ?>
									<div class="cidc-row">
										<div class="cidc-label">ประเภทลูกค้า</div>
										<div class="cidc-value"><span class="cidc-display-text"><?php echo so_saved_h($rcCustomerCard['type_name'] !== '' ? $rcCustomerCard['type_name'] : '-'); ?></span></div>
									</div>
									<div class="cidc-row">
										<div class="cidc-label">วงเงินเครดิต</div>
										<div class="cidc-value"><span class="cidc-display-text"><?php echo so_saved_h($rcCustomerCard['credit']); ?></span></div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="so-field-group rc-gap-top">
						<label class="so-label" for="customer_address">ที่อยู่<span class="required">*</span></label>
						<div class="so-input-wrapper">
							<input type="text" name="customer_address" id="customer_address" class="so-input" maxlength="1000" autocomplete="off" placeholder="ระบุที่อยู่" value="<?php echo so_saved_h($rcAddress); ?>">
							<button type="button" class="so-input-clear" data-rp-clear="customer_address" aria-label="ล้างที่อยู่">&times;</button>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- ===================== การ์ด 3: ข้อมูลการคืนสินค้า ===================== -->
		<section class="so-card rp-card" id="rc_card_return" aria-labelledby="rc_return_title">
			<div class="so-section-title-container rp-section-head">
				<h2 class="so-section-title" id="rc_return_title">ข้อมูลการคืนสินค้า</h2>
				<hr class="so-divider">
			</div>

			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="receive_ckk">วิธีคืนสินค้า<span class="required">*</span></label>
					<div class="so-select-wrapper">
						<select name="receive_ckk" id="receive_ckk" class="so-select">
							<option value="1" <?php echo $rcReceiveCkk === '1' ? 'selected' : ''; ?>>คืนสินค้าด้วยตัวเอง</option>
							<option value="2" <?php echo $rcReceiveCkk === '2' ? 'selected' : ''; ?>>ฝากบุคคลอื่นคืน</option>
						</select>
					</div>
				</div>

				<!-- ตามภาพ: ช่องกรอกพร้อมปุ่ม × ไม่มีดอกจัน (ไม่บังคับกรอก) — ตัวบันทึกล้างค่าให้เมื่อเลือกคืนด้วยตัวเอง -->
				<div class="so-field-group" id="rc_receive_name_group">
					<label class="so-label" for="receive_name">ชื่อบุคคลที่ฝากคืน</label>
					<div class="so-input-wrapper">
						<input type="text" name="receive_name" id="receive_name" class="so-input" maxlength="100" autocomplete="off" placeholder="ระบุชื่อบุคคลที่ฝากคืน" value="<?php echo so_saved_h($rcValue('receive_name')); ?>">
						<button type="button" class="so-input-clear" data-rp-clear="receive_name" aria-label="ล้างชื่อบุคคลที่ฝากคืน">&times;</button>
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="date_receive">วันที่ฝากคืน<span class="required">*</span></label>
					<div class="so-input-wrapper calendar-wrapper<?php echo $rcReadOnly ? ' is-locked' : ''; ?>">
						<input type="date" name="date_receive" id="date_receive" class="so-input" value="<?php echo so_saved_h($rcDateReceive); ?>">
					</div>
				</div>

				<!-- แถวที่ 2: ช่วงเวลา + เวลาในการจัดส่ง แบ่งครึ่งคอลัมน์แรก, คำอธิบายเพิ่มเติมกินสองคอลัมน์ที่เหลือ -->
				<div class="rc-split">
					<div class="so-field-group">
						<label class="so-label" for="time_range">เลือกช่วงเวลา</label>
						<div class="so-select-wrapper">
							<select name="time_range" id="time_range" class="so-select">
								<option value="">Select</option>
								<?php foreach (rc_time_range_options() as $rcRangeValue => $rcRangeLabel) { ?>
									<option value="<?php echo so_saved_h($rcRangeValue); ?>" <?php echo $rcValue('time_range') === (string)$rcRangeValue ? 'selected' : ''; ?>><?php echo so_saved_h($rcRangeLabel); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="so-field-group">
						<label class="so-label" for="time_between">เวลาในการจัดส่ง<span class="required">*</span></label>
						<div class="time-wrapper">
							<input type="time" name="time_between" id="time_between" class="so-input" value="<?php echo so_saved_h($rcTimeBetween); ?>" style="padding-right: 40px;">
						</div>
					</div>
				</div>

				<div class="so-field-group rc-span-2">
					<label class="so-label" for="remark_st">คำอธิบายเพิ่มเติม</label>
					<div class="so-input-wrapper">
						<input type="text" name="remark_st" id="remark_st" class="so-input" maxlength="2000" autocomplete="off" placeholder="กรอกคำอธิบายเพิ่มเติม" value="<?php echo so_saved_h($rcValue('remark_st')); ?>">
						<button type="button" class="so-input-clear" data-rp-clear="remark_st" aria-label="ล้างคำอธิบายเพิ่มเติม">&times;</button>
					</div>
				</div>
			</div>
		</section>

		<!-- ===================== การ์ด 4: รายการสินค้า ===================== -->
		<section class="so-card rp-card rp-items-card" id="rc_card_items" aria-labelledby="rc_items_title">
			<div class="so-section-title-container rp-section-head">
				<div class="rp-items-head">
					<h2 class="so-section-title" id="rc_items_title">รายการสินค้า</h2>
					<span class="rp-items-count" id="rc_items_count" aria-live="polite">0 รายการ</span>
				</div>
				<hr class="so-divider">
			</div>

			<div class="rp-summary-bar">
				<div class="rp-summary-col">
					<div class="rp-summary-label">จำนวนรวม(ชิ้น)</div>
					<div class="rp-summary-value" id="rc_total_qty">0</div>
				</div>
				<div class="rp-summary-col">
					<div class="rp-summary-label">ยอดรวมสุทธิ</div>
					<div class="rp-summary-value" id="rc_total_amount"><?php echo $rcIsLegacy ? '-' : '0.00'; ?></div>
				</div>
			</div>

			<div class="rp-items-toolbar">
				<div class="so-field-group rp-search-group">
					<label class="so-label" for="rc_product_search">ค้นหารายการสินค้า</label>
					<div class="rp-search-box">
						<i class="fas fa-search rp-search-icon" aria-hidden="true"></i>
						<input type="text" id="rc_product_search" class="so-input rp-search-input" autocomplete="off" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า">
					</div>
				</div>
			</div>

			<div class="rp-table-wrap">
				<table class="rp-items-table rc-items-table">
					<thead>
						<tr>
							<th class="rp-col-drag" scope="col"><span class="rp-sr-only">เรียงลำดับ</span></th>
							<th class="rp-col-check" scope="col">
								<label class="rp-check">
									<input type="checkbox" id="rc_check_all" aria-label="เลือกทุกรายการ">
									<span class="rp-check-mark" aria-hidden="true"></span>
								</label>
							</th>
							<th class="rc-col-caret" scope="col"><span class="rp-sr-only">ขยาย S/N</span></th>
							<th class="rp-col-code" scope="col">รหัสสินค้า</th>
							<th class="rp-col-name" scope="col">รายการสินค้า</th>
							<th class="rp-col-qty" scope="col">จำนวน</th>
							<th class="rc-col-price" scope="col">ราคา/หน่วย</th>
							<th class="rc-col-price" scope="col">ยอดรวม</th>
							<th class="rp-col-actions" scope="col"><span class="rp-sr-only">ลบ</span></th>
						</tr>
					</thead>
					<tbody id="rc_items_body">
						<?php foreach ($rcGroups as $rcItemId => $rcGroup) {
							$rcInfo = $rcGroup['info'];
							$rcGroupLines = $rcGroup['lines'];
							$rcSearchText = mb_strtolower(trim($rcInfo['access_code'] . ' ' . $rcInfo['sol_name']), 'UTF-8');
							$rcHasSn = $rcInfo['has_sn'];
							$rcDefaultPick = !$rcIsExisting; // ใบใหม่ติ๊กทุกรายการเป็นค่าเริ่มต้น (เหมือนฟอร์มเดิม)
							$rcCodeLabel = so_saved_h($rcInfo['access_code']);
						?>
							<?php if (!$rcHasSn) {
								$rcLine = $rcGroupLines[0];
								$rcKey = $rcLine['key'];
								$rcPicked = $rcDefaultPick || isset($rcSelection[$rcKey]);
								$rcQty = isset($rcSelection[$rcKey]) ? $rcSelection[$rcKey]['qty'] : $rcLine['qty_max'];
								$rcRemark = isset($rcSelection[$rcKey]) ? $rcSelection[$rcKey]['remark'] : $rcLine['remark'];
							?>
								<tr class="rc-row<?php echo !empty($rcInfo['serials']) ? ' is-open' : ''; ?>" data-search="<?php echo so_saved_h($rcSearchText); ?>" data-price="<?php echo so_saved_h(number_format($rcInfo['price'], 2, '.', '')); ?>">
									<td class="rp-col-drag">
										<button type="button" class="rp-drag-handle" title="ลากเพื่อเรียงลำดับ" aria-label="เรียงลำดับ <?php echo $rcCodeLabel; ?> — ลาก หรือกดลูกศรขึ้น/ลง"><i class="fas fa-grip-vertical" aria-hidden="true"></i></button>
									</td>
									<td class="rp-col-check">
										<label class="rp-check">
											<input type="checkbox" class="rc-pick" name="pick[<?php echo so_saved_h($rcKey); ?>]" value="1" <?php echo $rcPicked ? 'checked' : ''; ?> aria-label="เลือก <?php echo $rcCodeLabel; ?>">
											<span class="rp-check-mark" aria-hidden="true"></span>
										</label>
									</td>
									<td class="rc-col-caret">
										<?php if (!empty($rcInfo['serials'])) { ?>
											<!-- ใบคืนจากฟอร์มเดิม: แถวรายละเอียด S/N เปิดไว้ตั้งแต่แรก เพราะปุ่มใน fieldset ที่ disabled กดไม่ได้ -->
											<button type="button" class="rc-caret" aria-expanded="true" aria-label="แสดงหมายเลข S/N"><i class="fas fa-caret-down" aria-hidden="true"></i></button>
										<?php } ?>
									</td>
									<td class="rp-col-code"><?php echo $rcCodeLabel; ?></td>
									<td class="rp-col-name">
										<div class="rp-item-name"><?php echo so_saved_h($rcInfo['sol_name']); ?></div>
									</td>
									<td class="rp-col-qty">
										<div class="rc-qty-pill">
											<input type="text" inputmode="numeric" class="so-input rc-qty" name="qty[<?php echo so_saved_h($rcKey); ?>]" value="<?php echo so_saved_h(rc_trim_number($rcQty)); ?>" data-max="<?php echo so_saved_h(rc_trim_number($rcLine['qty_max'])); ?>" autocomplete="off" aria-label="จำนวนที่คืน">
										</div>
										<input type="hidden" name="remark[<?php echo so_saved_h($rcKey); ?>]" value="<?php echo so_saved_h($rcRemark); ?>">
									</td>
									<td class="rc-col-price rc-unit-price"><?php echo $rcIsLegacy ? '-' : number_format($rcInfo['price'], 2); ?></td>
									<td class="rc-col-price rc-line-total"><?php echo $rcIsLegacy ? '-' : '0.00'; ?></td>
									<td class="rp-col-actions">
										<span class="rp-row-actions"><button type="button" class="rp-row-btn" data-rc-row-action="delete" title="ลบรายการ" aria-label="ลบ <?php echo $rcCodeLabel; ?>"><img src="img/icons/trash.svg" alt=""></button></span>
									</td>
								</tr>
								<?php if (!empty($rcInfo['serials'])) { ?>
									<tr class="rc-detail-row">
										<td colspan="9">
											<table class="rc-sn-table">
												<thead>
													<tr><th class="rp-col-check"></th><th>หมายเลข SN</th><th>Lot No.</th><th>Exp. Date</th></tr>
												</thead>
												<tbody>
													<?php foreach ($rcInfo['serials'] as $rcLegacySerial) { ?>
														<tr>
															<td class="rp-col-check"></td>
															<td><?php echo so_saved_h($rcLegacySerial); ?></td>
															<td>-</td>
															<td>-</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</td>
									</tr>
								<?php } ?>
							<?php } else {
								$rcPickedCount = 0;
								foreach ($rcGroupLines as $rcSnLine) {
									if ($rcDefaultPick || isset($rcSelection[$rcSnLine['key']])) {
										$rcPickedCount++;
									}
								}
							?>
								<tr class="rc-row rc-row-sn" data-search="<?php echo so_saved_h($rcSearchText); ?>" data-price="<?php echo so_saved_h(number_format($rcInfo['price'], 2, '.', '')); ?>">
									<td class="rp-col-drag">
										<button type="button" class="rp-drag-handle" title="ลากเพื่อเรียงลำดับ" aria-label="เรียงลำดับ <?php echo $rcCodeLabel; ?> — ลาก หรือกดลูกศรขึ้น/ลง"><i class="fas fa-grip-vertical" aria-hidden="true"></i></button>
									</td>
									<td class="rp-col-check">
										<label class="rp-check">
											<input type="checkbox" class="rc-pick-group" <?php echo $rcPickedCount === count($rcGroupLines) ? 'checked' : ''; ?> aria-label="เลือกทุกเครื่องของ <?php echo $rcCodeLabel; ?>">
											<span class="rp-check-mark" aria-hidden="true"></span>
										</label>
									</td>
									<td class="rc-col-caret">
										<button type="button" class="rc-caret" aria-expanded="false" aria-label="แสดงหมายเลข S/N"><i class="fas fa-caret-down" aria-hidden="true"></i></button>
									</td>
									<td class="rp-col-code"><?php echo $rcCodeLabel; ?></td>
									<td class="rp-col-name">
										<div class="rp-item-name"><?php echo so_saved_h($rcInfo['sol_name']); ?></div>
									</td>
									<td class="rp-col-qty"><div class="rc-qty-pill is-static"><span class="rc-sn-count">0</span></div></td>
									<td class="rc-col-price rc-unit-price"><?php echo number_format($rcInfo['price'], 2); ?></td>
									<td class="rc-col-price rc-line-total">0.00</td>
									<td class="rp-col-actions">
										<span class="rp-row-actions"><button type="button" class="rp-row-btn" data-rc-row-action="delete" title="ลบรายการ" aria-label="ลบ <?php echo $rcCodeLabel; ?>"><img src="img/icons/trash.svg" alt=""></button></span>
									</td>
								</tr>
								<tr class="rc-detail-row" hidden>
									<td colspan="9">
										<table class="rc-sn-table">
											<thead>
												<tr><th class="rp-col-check"></th><th>หมายเลข SN</th><th>Lot No.</th><th>Exp. Date</th></tr>
											</thead>
											<tbody>
												<?php foreach ($rcGroupLines as $rcSnLine) {
													$rcKey = $rcSnLine['key'];
													$rcPicked = $rcDefaultPick || isset($rcSelection[$rcKey]);
													$rcRemark = isset($rcSelection[$rcKey]) ? $rcSelection[$rcKey]['remark'] : $rcSnLine['remark'];
												?>
													<tr>
														<td class="rp-col-check">
															<label class="rp-check">
																<input type="checkbox" class="rc-pick rc-pick-sn" name="pick[<?php echo so_saved_h($rcKey); ?>]" value="1" <?php echo $rcPicked ? 'checked' : ''; ?> aria-label="เลือก S/N <?php echo so_saved_h($rcSnLine['sn']); ?>">
																<span class="rp-check-mark" aria-hidden="true"></span>
															</label>
														</td>
														<td>
															<?php echo so_saved_h($rcSnLine['sn']); ?>
															<input type="hidden" name="remark[<?php echo so_saved_h($rcKey); ?>]" value="<?php echo so_saved_h($rcRemark); ?>">
														</td>
														<td><?php echo so_saved_h($rcSnLine['lot']); ?></td>
														<td><?php echo so_saved_h(rc_format_expiry($rcExpiry[$rcKey] ?? '')); ?></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
				<div class="rp-items-empty" id="rc_items_empty" hidden>ไม่พบรายการ</div>
			</div>
		</section>

		<?php
		// แท็บแนบไฟล์ (partials/doc_tabs_card.php) — 3 ไฟล์ตามคอลัมน์ img_re1..3 เก็บใน up_return/
		$docTabsCard = array(
			'open_fn' => 'rcOpen3Tab',
			'attach_file' => array(
				'enabled' => true,
				'file_prefix' => 'img_re',
				'slots' => 3,
				'first_slot' => 1,
				'base_url' => RC_UPLOAD_DIR,
				'max_bytes' => RC_UPLOAD_MAX_BYTES,
				'allowed_ext' => implode(',', rc_upload_extensions()),
				'accept' => '.' . implode(',.', rc_upload_extensions()),
				'hint' => 'แนบได้สูงสุด 3 ไฟล์ ไฟล์ละไม่เกิน 1 MB',
			),
		);
		include __DIR__ . '/partials/doc_tabs_card.php';
		for ($rcSlot = 1; $rcSlot <= 3; $rcSlot++) {
			$rcExistingFile = $rcValue('img_re' . $rcSlot);
		?>
			<!-- ไฟล์เดิม: js/doc-tabs-attach.js อ่านจาก hidden_slip_val{n} / ตั้ง del_img[n] = 1 เมื่อผู้ใช้ลบ -->
			<input type="hidden" id="hidden_slip_val<?php echo $rcSlot; ?>" value="<?php echo so_saved_h($rcExistingFile); ?>">
			<input type="hidden" id="hidden_remove_val<?php echo $rcSlot; ?>" name="del_img[<?php echo $rcSlot; ?>]" value="0">
		<?php } ?>

		<?php if ($rcReadOnly) { ?>
			</fieldset>
		<?php } ?>
	</div>

	<div class="so-sticky-actions rp-sticky-actions">
		<div class="so-sticky-actions-inner">
			<?php if (!$rcReadOnly) { ?>
				<button type="button" class="btn-so-submit rc-action-btn" data-rc-action="submit" onclick="rcSave('submit', this);"><i class="far fa-paper-plane" aria-hidden="true"></i> Submit</button>
				<button type="button" class="btn-so-draft rc-action-btn" data-rc-action="draft" onclick="rcSave('draft', this);"><i class="far fa-save" aria-hidden="true"></i> <?php echo $rcMode === 'draft' ? 'Update' : 'Save Draft'; ?></button>
			<?php } ?>
			<?php if ($rcMode === 'draft') { ?>
				<button type="button" class="btn-so-draft rc-action-btn rc-cancel-btn" data-rc-action="cancel" onclick="rcCancel(this);"><i class="far fa-trash-alt" aria-hidden="true"></i> ยกเลิกใบคืน</button>
			<?php } ?>
			<?php if ($rcIsExisting) { ?>
				<a class="btn-so-draft rc-print-link" id="rc_print_link" href="report_receive.php?ref_id=<?php echo rawurlencode($rcReceiveRef); ?>" target="_blank" rel="noopener">
					<img src="img/icons/print.svg" alt=""> พิมพ์ใบคืนสินค้า
				</a>
			<?php } ?>
		</div>
	</div>
</form>

<script>
	window.rcPageConfig = {
		mode: <?php echo json_encode($rcMode); ?>,
		receiveRef: <?php echo json_encode($rcReceiveRef, JSON_UNESCAPED_UNICODE); ?>,
		readOnly: <?php echo $rcReadOnly ? 'true' : 'false'; ?>,
		noPrice: <?php echo $rcIsLegacy ? 'true' : 'false'; ?>
	};
</script>
<script src="js/register-receive.js?v=<?php echo filemtime(__DIR__ . '/js/register-receive.js'); ?>"></script>
<script src="js/doc-tabs-attach.js?v=<?php echo filemtime(__DIR__ . '/js/doc-tabs-attach.js'); ?>"></script>
</body>
</html>
