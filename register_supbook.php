<?php include('head.php');
include('dbconnect.php');
include('dbconnect_sale.php');
require_once __DIR__ . '/includes/so_saved_helpers.php';

function renderSoDocumentReturnStatus($statusDoc)
{
	$statusMap = array(
		'Returned' => 'ส่งกลับ',
		'Rejected' => 'ไม่อนุมัติ',
		'Cancelled' => 'ยกเลิกเอกสาร',
		'ยกเลิก' => 'ยกเลิกเอกสาร'
	);

	return $statusMap[$statusDoc] ?? $statusDoc;
}

function renderSoDocumentReturnStatusClass($statusDoc)
{
	$statusClassMap = array(
		'Returned' => 'is-returned',
		'Rejected' => 'is-rejected',
		'Cancelled' => 'is-cancelled',
		'ยกเลิก' => 'is-cancelled'
	);

	return $statusClassMap[$statusDoc] ?? 'is-cancelled';
}

function formatSoDocumentLogDateTime($createdAt)
{
	$createdAt = trim((string)$createdAt);
	if ($createdAt === '') return '';

	$timestamp = strtotime($createdAt);
	if ($timestamp === false) return '';

	return date('d-m-Y H:i', $timestamp);
}

$savedRefId = isset($_GET["ref_id"]) ? mysqli_real_escape_string($conn, $_GET["ref_id"]) : "";
$isCopy = isset($_GET["copy"]) && $_GET["copy"] == "1";
$savedJong = null;
$savedProducts = [];
$soDocumentLogRows = [];

if ($savedRefId !== "") {
	$savedJongQuery = mysqli_query($conn, "SELECT * FROM hos__jongproduct WHERE ref_id = '" . $savedRefId . "' LIMIT 1");
	if ($savedJongQuery) {
		$savedJong = mysqli_fetch_assoc($savedJongQuery);
	}
	// Load products
	$savedProductsQuery = mysqli_query($conn, "SELECT sj.*, p.access_code, p.access_name, p.sol_name, p.unit_name FROM hos__subjongpro sj LEFT JOIN tb_product p ON sj.product_id = p.product_ID WHERE sj.ref_idd = '" . $savedRefId . "'");
	if ($savedProductsQuery) {
		while ($row = mysqli_fetch_assoc($savedProductsQuery)) {
			$displayName = (!empty($row['sol_name'])) ? $row['sol_name'] : ($row['access_name'] ?? $row['product_code']);
			$savedProducts[] = [
				'product_id' => $row['product_id'],
				'product_code' => $row['access_code'] ?? $row['product_code'],
				'product_name' => $displayName,
				'unit_name' => $row['unit_name'] ?? '',
				'count' => (float)$row['count'],
				'remark' => $row['sale_remark'],
				'showRemark' => !empty($row['sale_remark']),
				'id' => $row['id']
			];
		}
	}

	$documentStatusLogTableQuery = mysqli_query($conn, "SHOW TABLES LIKE 'tb_document_status_log'");
	if ($documentStatusLogTableQuery && mysqli_num_rows($documentStatusLogTableQuery) > 0) {
		$soDocumentLogQuery = mysqli_query($conn, "SELECT status_doc, reason, user_name, created_at FROM tb_document_status_log WHERE ref_id = '" . $savedRefId . "' AND status_doc IN ('Returned', 'Rejected', 'Cancelled') ORDER BY created_at DESC, id DESC");
		if ($soDocumentLogQuery) {
			while ($soDocumentLogRow = mysqli_fetch_assoc($soDocumentLogQuery)) {
				$soDocumentLogRows[] = $soDocumentLogRow;
			}
		}
	}
}
?>
<link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
<script src="sweetalert2/dist/sweetalert2.min.js"></script>

<link rel="stylesheet" href="css/credit-term-modal.css?v=20260704">

<link rel="stylesheet" href="css/autocomplete.css" type="text/css" />
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/customer-popup.js"></script>
<script type="text/javascript" src="js/row-drag.js?v=<?php echo filemtime(__DIR__ . '/js/row-drag.js'); ?>"></script>

<!-- Shared .so-* design-system primitives (cards, inputs, labels, buttons, credit-term modal, etc.) -->
<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<!-- Page-specific styling for register_supbook.php -->
<link rel="stylesheet" href="css/register-supbook.css?v=<?php echo filemtime(__DIR__ . '/css/register-supbook.css'); ?>">

<div class="w3-container register-so-main" style="max-width: 1200px; margin: 0 auto;">
	<?php
	$yearMonth = substr(date("Y") + 543, -2) . date("m");
	$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__jongproduct";
	$qry = mysqli_query($conn, $sql) or die(mysqli_error());
	$rs = mysqli_fetch_assoc($qry);
	$maxId = substr($rs['MAXID'], -4);
	$maxId3 = substr($rs['MAXID'], -8);

	$maxId1 = substr($maxId3, 0, -4);
	$so = "PD";

	if ($maxId1 == $yearMonth) {
		$maxId1 = ($maxId + 1);
		$maxId2 = substr("00000" . $maxId1, -4);
		$nextId = $yearMonth . $maxId2;
	} else {
		$maxId1 = "0001";
		$nextId = $yearMonth . $maxId1;
	}

	date_default_timezone_set("Asia/Bangkok");

	$month = date('m');
	$day = date('d');
	$year = date('Y');

	$today = $year . '-' . $month . '-' . $day;
	?>

	<!-- Header Section -->
	<div class="so-header-container">
		<div class="so-header-left">
			<div class="so-title-row">
				<button type="button" class="so-back-btn" onclick="goMainSupbook();" title="ย้อนกลับ" aria-label="ย้อนกลับ">
					<img src="img/icons/chevron_left.svg" alt="">
				</button>
				<h1 class="so-title">Product Booking</h1>
			</div>
			<div class="so-ref-info">
				<span class="so-ref-label">เลขที่จอง</span>
				<span class="so-ref-value"><?php echo ($savedJong !== null && !$isCopy) ? $savedJong['ref_id'] : ($so . $nextId); ?></span>
			</div>
		</div>
		<div class="so-header-right">
			<button type="button" class="btn-preview-so" onclick="previewBooking();">
				<img src="img\icons\preview.png" alt=""> Preview
			</button>
		</div>
	</div>

	<?php
	$latestSoDocumentReason = $soDocumentLogRows[0] ?? null;
	$latestSoDocumentReasonTitleMap = array(
		'Returned' => 'เหตุผลในการส่งกลับ',
		'Rejected' => 'เหตุผลที่ไม่อนุมัติ'
	);
	$latestSoDocumentReasonClassMap = array(
		'Returned' => 'is-returned',
		'Rejected' => 'is-rejected'
	);
	$latestSoDocumentReasonStatus = trim((string)($latestSoDocumentReason['status_doc'] ?? ''));
	$latestSoDocumentReasonText = trim((string)($latestSoDocumentReason['reason'] ?? ''));
	$latestSoDocumentReasonTitle = $latestSoDocumentReasonTitleMap[$latestSoDocumentReasonStatus] ?? '';
	$latestSoDocumentReasonClass = $latestSoDocumentReasonClassMap[$latestSoDocumentReasonStatus] ?? '';
	?>
	<?php if ($savedJong !== null && !$isCopy && $latestSoDocumentReasonTitle !== '' && $latestSoDocumentReasonText !== '') { ?>
		<div class="so-latest-reason-banner <?php echo so_saved_h($latestSoDocumentReasonClass); ?>" role="status">
			<button type="button" class="so-latest-reason-close" aria-label="ปิด" onclick="this.closest('.so-latest-reason-banner').style.display='none';">&times;</button>
			<div class="so-latest-reason-title"><?php echo so_saved_h($latestSoDocumentReasonTitle); ?></div>
			<div class="so-latest-reason-text"><?php echo nl2br(so_saved_h($latestSoDocumentReasonText)); ?></div>
		</div>
	<?php } ?>

	<form action="<?php echo ($savedJong !== null && !$isCopy) ? 'register_supbook_edit1.php' : 'register_supbook1.php'; ?>" method="post" name="frmMain" enctype="multipart/form-data" onsubmit="return lockSubmitForm(this);">
		<?php if ($savedJong !== null && !$isCopy) { ?>
			<input type="hidden" name="ref_id" value="<?php echo htmlspecialchars($savedJong['ref_id'], ENT_QUOTES, 'UTF-8'); ?>">
		<?php } else { ?>
			<input type="hidden" name="ref_idsmp" value="<?php echo $so;
															echo $nextId; ?>">
		<?php } ?>


		<!-- กล่อง: ข้อมูลเอกสาร -->
		<div class="so-card">
			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label">บริษัท <span style="color:red;">*</span></label>
					<div class="so-select-wrapper">
						<select class="so-select" name="company" id="company_select">
							<option value="1" <?php echo ($savedJong !== null && $savedJong['company'] == '1') ? 'selected' : ''; ?>>AWL</option>
							<option value="2" <?php echo ($savedJong !== null && $savedJong['company'] == '2') ? 'selected' : ''; ?>>NBM</option>
						</select>
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label">ประเภท <span style="color:red;">*</span></label>
					<div class="so-select-wrapper">
						<select name="type_jong" id="type_jong" class="so-select" required>
							<option value="">**Please Select**</option>
							<option value="1" <?php echo ($savedJong !== null && $savedJong['type_jong'] == '1') ? 'selected' : ''; ?>>จองมีสัญญา</option>
							<option value="2" <?php echo ($savedJong !== null && $savedJong['type_jong'] == '2') ? 'selected' : ''; ?>>จองตามการประมาณการ</option>
							<option value="3" <?php echo ($savedJong !== null && $savedJong['type_jong'] == '3') ? 'selected' : ''; ?>>จองสินค้าสาธิต</option>
						</select>
					</div>
				</div>

				<div class="so-field-group">
					<label class="so-label" for="sale_code">แผนก/เขตการขาย <span style="color:red;">*</span></label>
					<div class="so-select-wrapper">
					<?php
					$selected_sale_code = ($savedJong !== null) ? $savedJong['sale_code'] : ($_GET['sale_code'] ?? '');

					if ($_SESSION['code'] == 'SS1') {
					?>
						<select name="sale_code" id="sale_code" class="so-select" required>
							<option value="">**Please Select**</option>
							<?php
							$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
							$objQuery5 = mysqli_query($com, $strSQL5);
							while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
								$sel = ($selected_sale_code == $objResuut5["sale_code"]) ? "selected" : "";
							?>
								<option value="<?php echo so_saved_h($objResuut5["sale_code"]); ?>" <?php echo $sel; ?>><?php echo so_saved_h($objResuut5["sale_code"]); ?> - <?php echo so_saved_h($objResuut5["sale_name"]); ?></option>
							<?php
							}
							?>
						</select>
					<?php
					} else if ($_SESSION['code'] == 'SS2') {
					?>
						<select name="sale_code" id="sale_code" class="so-select" required>
							<option value="">**Please Select**</option>
							<?php
							$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
							$objQuery5 = mysqli_query($com, $strSQL5);
							while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
								$sel = ($selected_sale_code == $objResuut5["sale_code"]) ? "selected" : "";
							?>
								<option value="<?php echo so_saved_h($objResuut5["sale_code"]); ?>" <?php echo $sel; ?>><?php echo so_saved_h($objResuut5["sale_code"]); ?> - <?php echo so_saved_h($objResuut5["sale_name"]); ?></option>
							<?php
							}
							?>
						</select>
					<?php
					} else if ($_SESSION['code'] == 'SS5') {
					?>
						<select name="sale_code" id="sale_code" class="so-select" required>
							<option value="">**Please Select**</option>
							<?php
							$strSQL5 = "SELECT * FROM tb_team_ss3 where sale_code IN ('S31','S32') ORDER BY sale_code ASC";
							$objQuery5 = mysqli_query($com, $strSQL5);
							while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
								$sel = ($selected_sale_code == $objResuut5["sale_code"]) ? "selected" : "";
							?>
								<option value="<?php echo so_saved_h($objResuut5["sale_code"]); ?>" <?php echo $sel; ?>><?php echo so_saved_h($objResuut5["sale_code"]); ?> - <?php echo so_saved_h($objResuut5["sale_name"]); ?></option>
							<?php
							}
							?>
						</select>
					<?php
					} else if ($_SESSION['code'] == 'SUP_EN') {
					?>
						<select name="sale_code" id="sale_code" class="so-select" required>
							<option value="">**Please Select**</option>
							<?php
							$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
							$objQuery5 = mysqli_query($com, $strSQL5);
							while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
								$sel = ($selected_sale_code == $objResuut5["sale_code"]) ? "selected" : "";
							?>
								<option value="<?php echo so_saved_h($objResuut5["sale_code"]); ?>" <?php echo $sel; ?>><?php echo so_saved_h($objResuut5["sale_code"]); ?> - <?php echo so_saved_h($objResuut5["sale_name"]); ?></option>
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
							$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
							$objQuery5 = mysqli_query($com, $strSQL5);
							while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
								$sel = ($selected_sale_code == $objResuut5["sale_code"]) ? "selected" : "";
							?>
								<option value="<?php echo so_saved_h($objResuut5["sale_code"]); ?>" <?php echo $sel; ?>><?php echo so_saved_h($objResuut5["sale_code"]); ?> - <?php echo so_saved_h($objResuut5["sale_name"]); ?></option>
							<?php
							}
							?>
						</select>
					<?php
					}
					?>
					</div>
				</div>
			</div>

			<div class="so-subsection-title-container">
				<h3 class="so-subsection-title">ข้อมูลเอกสาร</h3>
			</div>

			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="date_jong">วันที่แจ้ง</label>
					<input type="date" name="date_jong" id="date_jong" value="<?php echo ($savedJong !== null && !$isCopy) ? $savedJong['date_jong'] : $today; ?>" class="so-input">
				</div>
				<div class="so-field-group">
					<label class="so-label" for="date_receive">วันที่ต้องการสินค้า <span style="color:red;">*</span></label>
					<input type="date" name="date_receive" id="date_receive" class="so-input" value="<?php echo ($savedJong !== null && !$isCopy) ? $savedJong['date_receive'] : ''; ?>" required>
				</div>
				<?php $adminDocNo = ($savedJong !== null && !$isCopy) ? trim((string)$savedJong['iv_no']) : ''; ?>
				<?php if ($adminDocNo !== '') { ?>
				<div class="so-field-group">
					<label class="so-label" for="admin_doc_no">เลขที่เอกสาร</label>
					<input type="text" name="admin_doc_no" id="admin_doc_no" class="so-input" value="<?php echo htmlspecialchars($adminDocNo, ENT_QUOTES, 'UTF-8'); ?>" readonly>
				</div>
				<?php } ?>
			</div>

		</div>

		<!-- กล่อง: ข้อมูลลูกค้า -->
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
						<label class="so-label" for="customer">ชื่อลูกค้า</label>
						<div class="so-input-wrapper">
							<input type="text" name="customer" id="customer" class="so-input" readonly placeholder="จะแสดงผลอัตโนมัติเมื่อเลือกเสร็จสิ้น" value="<?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['customer'], ENT_QUOTES, 'UTF-8') : ''; ?>">
							<i class="fas fa-times so-clear-icon" onclick="clearCustomerSelection();" role="button" tabindex="0" aria-label="ล้างข้อมูลลูกค้าที่เลือก"></i>
						</div>
					</div>
				</div>

				<div class="so-customer-top-right">
					<div class="so-field-group" style="height: 100%; margin-bottom: 0;">
						<label class="so-label">ข้อมูลลูกค้า</label>
						<div class="customer-info-display-card">
							<div class="cidc-col">
								<div class="cidc-row">
									<div class="cidc-label">รหัสลูกค้า</div>
									<div class="cidc-value">
										<span id="display_bill_id" class="cidc-display-text"><?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['customer_id'], ENT_QUOTES, 'UTF-8') : ''; ?></span>
										<input type="hidden" name="bill_id" id="bill_id" value="<?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['customer_id'], ENT_QUOTES, 'UTF-8') : ''; ?>">
										<input type="hidden" name="h_bill_id" id="h_bill_id" readonly value="<?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['customer_id'], ENT_QUOTES, 'UTF-8') : ''; ?>">
									</div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">เบอร์โทร</div>
									<div class="cidc-value">
										<input type="text" id="display_bill_tel" class="cidc-value-input" readonly>
									</div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">สถานะลูกค้า</div>
									<div class="cidc-value">
										<img src="img/icons/vip.png" class="cidc-status-icon" id="display_vip_icon" alt="VIP" style="display: none;">
										<input type="text" id="display_mode_name" class="cidc-value-input" readonly>
									</div>
								</div>
							</div>
							<div class="cidc-col">
								<div class="cidc-row">
									<div class="cidc-label">ชื่อลูกค้า</div>
									<div class="cidc-value">
										<input type="text" id="display_bill_name" class="cidc-value-input" readonly>
									</div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">ประเภทลูกค้า</div>
									<div class="cidc-value">
										<input type="text" id="display_customer_typename" class="cidc-value-input" readonly>
									</div>
								</div>
								<div class="cidc-row">
									<div class="cidc-label">เครดิตยอดขาย</div>
									<div class="cidc-value">
										<button type="button" class="credit-term-trigger is-empty" id="display_credit_thb_trigger" aria-haspopup="dialog" aria-controls="creditTermPopupModal" aria-disabled="true" disabled>
											<span id="display_credit_thb" class="credit-term-trigger-text"></span>
											<img src="img/icons/edit.png?v=20260610" class="credit-term-trigger-icon" alt="แก้ไข">
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="so-customer-address-wrap">
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" for="address_send">ที่อยู่ลูกค้า <span style="color:red;">*</span></label>
						<div class="so-input-wrapper">
							<input type="text" name="address_send" id="address_send" class="so-input" placeholder="ระบุสถานที่ส่งสินค้า..." style="padding-right: 36px;" value="<?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['address_send'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
							<i class="fas fa-times so-clear-icon" onclick="clearFieldValue('address_send');" role="button" tabindex="0" aria-label="ล้างที่อยู่ลูกค้า"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- กล่อง: หมายเหตุ -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">หมายเหตุ</h2>
				<hr class="so-divider">
			</div>
			<div class="so-field-group" style="margin-bottom: 0;">
				<label class="so-label" for="drescription">หมายเหตุ</label>
				<textarea name="drescription" id="drescription" class="so-textarea" placeholder="ระบุรายละเอียดเพิ่มเติม..." style="margin-bottom: 0;"><?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['drescription'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
			</div>
		</div>


		<!-- กล่อง: รายการสินค้า -->
		<div class="so-card">
			<div class="so-section-title-container so-product-section-header">
				<h2 class="so-section-title">รายการสินค้า</h2>
				<span class="so-product-count" id="productItemCount">0 รายการ</span>
			</div>
			<hr class="so-divider" style="margin: -12px 0 24px 0;">

			<div class="so-product-search-wrap">
				<i class="fas fa-search"></i>
				<input type="text" id="productSearchInput" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า" autocomplete="off">
				<div id="productSearchResults" class="product-search-dropdown"></div>
			</div>

			<div class="so-product-table-wrap">
				<table class="so-product-dyn-table">
					<thead>
						<tr>
							<th class="col-handle"></th>
							<th>รหัสสินค้า</th>
							<th>รายการสินค้า</th>
							<th class="col-qty">จำนวน</th>
							<th class="col-actions"></th>
						</tr>
					</thead>
					<tbody id="productTableBody">
						<tr id="productEmptyRow">
							<td colspan="5" class="product-empty">ยังไม่มีรายการสินค้า ค้นหาด้านบนเพื่อเพิ่มรายการ</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div id="productHiddenInputs"></div>
		</div>

		<!-- NEW DOCUMENT TABS CARD -->
		<?php
		$soDocumentLogRowsForTabs = array();
		foreach ($soDocumentLogRows as $soDocumentLogRow) {
			$soDocumentLogRowsForTabs[] = array(
				'status_label' => renderSoDocumentReturnStatus($soDocumentLogRow['status_doc'] ?? ''),
				'status_class' => renderSoDocumentReturnStatusClass($soDocumentLogRow['status_doc'] ?? ''),
				'reason' => $soDocumentLogRow['reason'] ?? '',
				'user_name' => $soDocumentLogRow['user_name'] ?? '',
				'created_at' => formatSoDocumentLogDateTime($soDocumentLogRow['created_at'] ?? '')
			);
		}
		?>
		<?php if (!empty($soDocumentLogRowsForTabs)) { ?>
		<div class="so-tabs-container so-document-return-tabs-container" style="margin-top: 24px;">
			<button type="button" class="so-tab-btn so-document-return-tab-btn active">การส่งเอกสารกลับ</button>
		</div>
		<div class="so-card so-document-return-card" style="padding: 24px;">
			<div style="overflow-x:auto;">
				<table class="so-document-status-table">
					<thead>
						<tr>
							<th>สถานะ</th>
							<th>เหตุผลการส่งกลับ</th>
							<th>ผู้ส่งกลับ</th>
						</tr>
					</thead>
					<tbody>
							<?php foreach ($soDocumentLogRowsForTabs as $documentReturnLogRow) { ?>
								<tr>
									<td class="so-document-log-status-cell">
										<span class="so-document-status-pill <?php echo so_saved_h($documentReturnLogRow['status_class'] ?? 'is-cancelled'); ?>">
											<?php echo so_saved_h($documentReturnLogRow['status_label'] ?? ''); ?>
										</span>
									</td>
									<td class="so-document-log-reason-cell"><?php echo so_saved_h($documentReturnLogRow['reason'] ?? ''); ?></td>
									<td class="so-document-log-user-cell">
										<div><?php echo so_saved_h(($documentReturnLogRow['user_name'] ?? '') !== '' ? $documentReturnLogRow['user_name'] : '-'); ?></div>
										<?php if (!empty($documentReturnLogRow['created_at'])) { ?>
											<div class="so-document-log-time"><?php echo so_saved_h($documentReturnLogRow['created_at']); ?></div>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php } ?>
</div>

<?php
$soIsEditMode = ($savedJong !== null && !$isCopy);
$soStatusDoc = $savedJong['status_doc'] ?? '';
$soIsSupApprover = (($_SESSION['type_login'] ?? '') !== 'Sale');
$soIsApproved = $soIsEditMode && ($soStatusDoc === 'Approve');
// ใบจองที่ถูกยกเลิกแล้ว (cancel_ckk แบบ legacy) เหลือแค่ปุ่มกลับหน้าหลัก
$soIsCancelled = $soIsEditMode && ((string)($savedJong['cancel_ckk'] ?? '0') === '1');
$soCanShowApproveBar = $soIsEditMode && $soIsSupApprover && ($soStatusDoc === 'Request') && !$soIsCancelled;
// Sale หลัง Approve: ปิดทุกปุ่ม
$soHideAllActions = $soIsApproved && !$soIsSupApprover;
// Submit หายเมื่อส่งรออนุมัติแล้ว (Request) หรือเอกสารอนุมัติแล้ว
$soHideSubmit = $soIsEditMode && (($soStatusDoc === 'Request') || $soIsApproved || $soIsCancelled);
// ปุ่ม Update หลักซ้ำกับปุ่ม Update ที่อยู่ในแถบอนุมัติแล้ว
$soHideUpdate = $soCanShowApproveBar || $soIsApproved || $soIsCancelled;
?>
<?php if (!$soHideAllActions): ?>
	<div class="so-sticky-actions" style="width: 100%; background-color: white; padding: 16px 24px; display: flex; gap: 16px; justify-content: flex-end; box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.05); align-items: center; border-top: 1px solid #EBEBEB; margin-top: 24px; box-sizing: border-box;">
		<div class="so-sticky-actions-inner" style="max-width: 1200px; width: 100%; display: flex; gap: 16px; justify-content: flex-end; margin: 0 auto; padding-right: 24px; align-items: center;">
			<?php if ($soCanShowApproveBar): ?>
				<input type="hidden" name="approve_action" id="so_approve_action" value="">
				<input type="hidden" name="so_approve_reason" id="so_approve_reason" value="">
				<div class="so-approve-actions" style="display: flex; gap: 16px; align-items: center; position: relative;">
					<button type="button" class="so-overflow-menu-trigger" id="btn_approve_overflow" onclick="toggleApproveOverflowMenu()" style="background: white; border: 1px solid #EBEBEB; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #612989;">
						<i class="fas fa-ellipsis-v"></i>
					</button>
					<div id="approveOverflowMenu" class="so-overflow-menu" style="display:none; position: absolute; bottom: 48px; left: 0; background: white; border: 1px solid #EBEBEB; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden; z-index: 10; min-width: 160px;">
						<button type="button" name="approve_action" value="return" onclick="soRunApproveAction('return', true);" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; font-family: 'Prompt', sans-serif; font-size: 14px; color: #FF830F; cursor: pointer;"><img src="img/icons/send_back.png" alt="" style="width: 20px; height: 20px;"> ส่งกลับ</button>
						<button type="button" name="approve_action" value="reject" class="so-menu-danger" onclick="soRunApproveAction('reject', true);" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; font-family: 'Prompt', sans-serif; font-size: 14px; color: #DC3545; cursor: pointer;"><img src="img/icons/reject.png" alt="" style="width: 20px; height: 20px;"> ไม่อนุมัติ</button>
						<button type="button" name="approve_action" value="cancel" onclick="soRunApproveAction('cancel', true);" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; font-family: 'Prompt', sans-serif; font-size: 14px; color: #4A4A4A; cursor: pointer;"><img src="img/icons/cancel_document.png" alt="" style="width: 20px; height: 20px;"> ยกเลิกเอกสาร</button>
					</div>
					<button type="button" name="approve_action" value="approve" onclick="soRunApproveAction('approve', false);" style="background-color: #E8F9EE; color: #1E9E4F; border: 1px solid #C7EED4; border-radius: 24px; padding: 10px 28px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; height: 40px;">
						<img src="img/icons/approval_status.png" alt="" style="width: 28px; height: 28px;"> อนุมัติ
					</button>
					<button type="button" name="save_draft" onclick="saveDraft()" style="background-color: white; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 28px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; height: 40px;">
						<img src="img/icons/update_document.png" alt="" style="width: 20px; height: 20px;"> Update
					</button>
				</div>
			<?php endif; ?>
			<?php if (!$soHideSubmit): ?>
				<button type="submit" name="submit" id="btn_submit_form" value="submit" style="background-color: #612989; color: #fff; border: 1px solid #612989; border-radius: 24px; padding: 10px 28px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08); height: 40px;">
					<i class="far fa-paper-plane"></i> Submit
				</button>
			<?php endif; ?>
			<?php if (!$soHideUpdate): ?>
				<button type="button" name="save_draft" onclick="saveDraft()" style="background-color: white; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 12px 32px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
					<i class="far fa-save"></i> <?php echo $soIsEditMode ? 'Update' : 'Save Draft'; ?>
				</button>
			<?php endif; ?>
		</div>
	</div>
	<script>
		function soEnsureSubmitMarker() {
			var form = document.forms['frmMain'];
			if (!form) return null;

			var submitValue = form.querySelector('input[type="hidden"][name="submit"]');
			if (!submitValue) {
				submitValue = document.createElement('input');
				submitValue.type = 'hidden';
				submitValue.name = 'submit';
				form.appendChild(submitValue);
			}
			submitValue.value = 'submit';

			return form;
		}

		function soClearApproveAction() {
			window.soPendingApproveAction = '';
			var actionField = document.getElementById('so_approve_action');
			var reasonField = document.getElementById('so_approve_reason');
			if (actionField) actionField.value = '';
			if (reasonField) reasonField.value = '';
		}

		function soApplyPendingApproveAction() {
			var actionField = document.getElementById('so_approve_action');
			if (actionField && window.soPendingApproveAction) {
				actionField.value = window.soPendingApproveAction;
			}
		}

		function soOpenReasonPopup(opts) {
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
					confirmButton: 'figma-delete-confirm-btn so-reason-confirm-btn ' + (opts.confirmBtnClass || ''),
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

		function soRunApproveAction(action, skipValidation) {
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
					},
					cancel: {
						title: 'ยกเลิกเอกสารนี้ ?',
						subtitleText: 'ต้องการยกเลิกเอกสารเลขที่',
						label: 'ระบุเหตุผลในการยกเลิก',
						placeholder: 'ระบุเหตุผลในการยกเลิก',
						iconBg: '#F4F5F7',
						iconSrc: 'img/icons/cancel_document.png'
					}
				} [action];
				if (!reasonConfig) return;

				soOpenReasonPopup(Object.assign({}, reasonConfig, {
					onConfirm: function(reason) {
						var actionField = document.getElementById('so_approve_action');
						var reasonField = document.getElementById('so_approve_reason');
						if (actionField) actionField.value = action;
						if (reasonField) reasonField.value = reason;
						window.soSkipValidation = true;
						var form = soEnsureSubmitMarker();
						if (form) HTMLFormElement.prototype.submit.call(form);
					}
				}));
				return;
			}

			window.soPendingApproveAction = action;
			var form = soEnsureSubmitMarker();
			if (!form) return;
			if (fncSubmit(form)) {
				soApplyPendingApproveAction();
				HTMLFormElement.prototype.submit.call(form);
			}
		}

		function toggleApproveOverflowMenu() {
			var menu = document.getElementById('approveOverflowMenu');
			if (!menu) return;
			menu.style.display = (menu.style.display === 'none' || !menu.style.display) ? 'block' : 'none';
		}
		document.addEventListener('click', function(e) {
			var menu = document.getElementById('approveOverflowMenu');
			var trigger = document.getElementById('btn_approve_overflow');
			if (!menu || menu.style.display === 'none') return;
			if (e.target === trigger || (trigger && trigger.contains(e.target))) return;
			if (!menu.contains(e.target)) menu.style.display = 'none';
		});
	</script>
<?php endif; ?>
</form>

<!-- HTML โครงสร้างป๊อปอัปค้นหาลูกค้า (ตามสไตล์ของ register_suphos.php) -->
<div id="customerPopupModal" class="customer-popup-modal" aria-hidden="true">
	<div class="customer-popup-box" role="dialog" aria-modal="true" aria-labelledby="customerPopupTitle">
		<button type="button" class="customer-popup-close" onclick="closeCustomerPopup()" aria-label="Close">&times;</button>

		<div class="clear-loan-header">
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
						<th>ชื่อลูกค้า</th>
						<th>เบอร์โทร</th>
						<th>ที่อยู่</th>
						<th></th>
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

<!-- ป๊อปอัปเครดิตเทอม/หนี้คงค้าง (ใช้ระบบร่วมกับ register_suphos.php ผ่าน js/credit-term-modal.js) -->
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
								<th></th>
								<th>เลขที่ใบสั่งขาย</th>
								<th>รายการสินค้า</th>
								<th>ยอดที่ต้องชำระ</th>
								<th>ยอดชำระแล้ว</th>
								<th>ยอดหนี้คงค้าง</th>
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

<!-- ป๊อปอัปหมายเหตุสินค้า (แก้ไขหมายเหตุรายการสินค้าในตาราง) -->
<div id="productRemarkModal" class="customer-popup-modal" aria-hidden="true">
	<div class="customer-popup-box product-remark-popup-box" role="dialog" aria-modal="true" aria-labelledby="productRemarkModalTitle">
		<button type="button" class="customer-popup-close" onclick="closeProductRemarkModal()" aria-label="Close">&times;</button>
		<div class="customer-popup-header">
			<h2 id="productRemarkModalTitle">ข้อมูลรายการสินค้าเพิ่มเติม</h2>
		</div>
		<div class="product-remark-popup-body">
			<div class="so-field-group" style="margin-bottom:0;">
				<label class="so-label" for="productRemarkModalInput">หมายเหตุสินค้า</label>
				<div class="so-input-wrapper">
					<input type="text" id="productRemarkModalInput" class="so-input" placeholder="ระบุหมายเหตุสินค้า...">
					<i class="fas fa-times so-clear-icon" onclick="clearFieldValue('productRemarkModalInput')" role="button" tabindex="0" aria-label="ล้างหมายเหตุสินค้า"></i>
				</div>
			</div>
		</div>
		<div class="customer-popup-actions">
			<button type="button" class="customer-popup-confirm" onclick="confirmProductRemarkModal()">อัพเดท</button>
			<button type="button" class="customer-popup-cancel" onclick="closeProductRemarkModal()">ยกเลิก</button>
		</div>
	</div>
</div>

<script>
	var PRODUCT_SEARCH_DEPT = '<?php echo (isset($_SESSION['department']) && $_SESSION['department'] == "วิศวกรรม") ? "eng" : "sale"; ?>';

	function clearFieldValue(id) {
		var el = document.getElementById(id);
		if (el) el.value = '';
	}

	function clearCustomerSelection() {
		clearFieldValue('bill_id');
		clearFieldValue('h_bill_id');
		clearFieldValue('customer');
		clearFieldValue('address_send');

		var displayBillId = document.getElementById('display_bill_id');
		if (displayBillId) displayBillId.textContent = '';
		clearFieldValue('display_bill_tel');
		clearFieldValue('display_mode_name');
		clearFieldValue('display_bill_name');
		clearFieldValue('display_customer_typename');
		clearFieldValue('display_credit_thb');

		var vipIcon = document.getElementById('display_vip_icon');
		if (vipIcon) vipIcon.style.display = 'none';

		syncCreditTermTriggerState();
	}

	// ตั้งค่าฟิลด์แสดงผล พร้อม format ตัวเลขให้ display_credit_thb และ sync สถานะปุ่มเครดิตเทอม
	function setElementValue(id, value) {
		var element = document.getElementById(id);
		if (element) {
			var normalizedValue = value || "";
			if (id === 'display_credit_thb') {
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
			}
			if ('value' in element) {
				element.value = normalizedValue;
			} else {
				element.textContent = normalizedValue;
			}
			if (id === 'display_credit_thb') {
				syncCreditTermTriggerState();
			}
		}
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

	function invokeCreditTermPopupOpen() {
		if (typeof window.openCreditTermPopup === 'function') {
			window.openCreditTermPopup();
			return;
		}
		var modal = document.getElementById('creditTermPopupModal');
		var trigger = document.getElementById('display_credit_thb_trigger');
		if (!modal || !trigger || trigger.disabled) return;
		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');
	}

	function invokeCreditTermPopupClose() {
		if (typeof window.closeCreditTermPopup === 'function') {
			window.closeCreditTermPopup();
			return;
		}
		var modal = document.getElementById('creditTermPopupModal');
		if (!modal) return;
		modal.style.display = 'none';
		modal.setAttribute('aria-hidden', 'true');
	}

	// ฟังก์ชัน AJAX หลักในการเชื่อมต่อข้อมูลออกบิลลูกค้า
	var HttPRequest = false;

	function doCallAjax1(bill_id, customer, address_send) {
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

		var url = 'data_bill_name1.php';
		var billIdVal = document.getElementById(bill_id).value;
		var pmeters = "bill_id=" + encodeURIComponent(billIdVal);
		HttPRequest.open('POST', url, true);
		HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		HttPRequest.setRequestHeader("Content-length", pmeters.length);
		HttPRequest.setRequestHeader("Connection", "close");
		HttPRequest.send(pmeters);

		HttPRequest.onreadystatechange = function() {
			if (HttPRequest.readyState == 4) {
				if (HttPRequest.status === 200) {
					var myProduct = HttPRequest.responseText;
					if (myProduct != "") {
						var myArr = myProduct.split("|");
						document.getElementById(customer).value = myArr[0];
						// ดึงเฉพาะที่อยู่ออกบิลรวม (myArr[1]) ตามความต้องการของลูกค้า: "ดึงเฉพาะที่อยู่ของ 'ลูกค้า'"
						if (address_send && document.getElementById(address_send)) {
							document.getElementById(address_send).value = myArr[1];
						}

						// เติมข้อมูลลงกล่องแสดงผลข้อมูลลูกค้า (customer-info-display-card)
						setElementValue('display_bill_name', myArr[0]);
						setElementValue('display_bill_tel', myArr[2]);
						setElementValue('display_mode_name', myArr[20]);
						setElementValue('display_customer_typename', myArr[22]);
						setElementValue('display_credit_thb', myArr[24]);

						var vipCkk = (myArr[25] || '').trim();
						var vipIcon = document.getElementById('display_vip_icon');
						if (vipIcon) {
							vipIcon.style.display = (vipCkk === "1") ? "" : "none";
						}

						var billIdVal2 = document.getElementById(bill_id).value;
						var displayBillId = document.getElementById('display_bill_id');
						if (displayBillId) displayBillId.textContent = billIdVal2;
					}
				}
			}
		}
	}

	// Hook เรียกโดย js/customer-popup.js เมื่อผู้ใช้กด "ตกลง" เลือกลูกค้าในป๊อปอัป
	window.customerPopupOnConfirm = function(selectedCustomer) {
		var selectedCustId = String((selectedCustomer && selectedCustomer.customer_id) || '').trim();

		var billId = document.getElementById('bill_id');
		if (billId) {
			billId.value = selectedCustId;
		}
		var hiddenBillId = document.getElementById('h_bill_id');
		if (hiddenBillId) {
			hiddenBillId.value = selectedCustId;
		}

		// เรียกดึงข้อมูลบิลลูกค้าและกรอกลงที่อยู่และชื่อฟิลด์จริง
		doCallAjax1('bill_id', 'customer', 'address_send');
	};

	// ===== รายการสินค้าแบบไดนามิก =====
	var productRows = <?php echo count($savedProducts) > 0 ? json_encode($savedProducts, JSON_UNESCAPED_UNICODE) : '[]'; ?>;
	var productSearchTimer = null;

	function escapeProductHtml(value) {
		return String(value == null ? '' : value).replace(/[&<>"']/g, function(char) {
			return {
				'&': '&amp;',
				'<': '&lt;',
				'>': '&gt;',
				'"': '&quot;',
				"'": '&#039;'
			} [char];
		});
	}

	function renderProductTable() {
		var tbody = document.getElementById('productTableBody');
		var hiddenWrap = document.getElementById('productHiddenInputs');
		if (!tbody) return;

		document.getElementById('productItemCount').textContent = productRows.length + ' รายการ';

		if (productRows.length === 0) {
			tbody.innerHTML = '<tr id="productEmptyRow"><td colspan="5" class="product-empty">ยังไม่มีรายการสินค้า ค้นหาด้านบนเพื่อเพิ่มรายการ</td></tr>';
			hiddenWrap.innerHTML = '';
			return;
		}

		tbody.innerHTML = productRows.map(function(row, idx) {
			var remarkBlock = row.remark ?
				('<div class="product-row-remark-text">' + escapeProductHtml(row.remark) + '</div>') : '';

			return '<tr class="product-row" data-idx="' + idx + '">' +
				'<td class="col-handle rd-handle"><i class="fas fa-grip-vertical"></i></td>' +
				'<td>' + escapeProductHtml(row.product_code) + '</td>' +
				'<td>' + escapeProductHtml(row.product_name) + remarkBlock + '</td>' +
				'<td class="col-qty"><input type="number" min="1" class="so-input product-qty-input" value="' + row.count + '" oninput="updateProductCount(' + idx + ',this.value)"></td>' +
				'<td class="col-actions">' +
				'<button type="button" class="product-row-icon-btn" onclick="openProductRemarkModal(' + idx + ')" title="แก้ไขหมายเหตุ" aria-label="แก้ไขหมายเหตุ"><i class="fas fa-pen"></i></button>' +
				'<button type="button" class="product-row-icon-btn" onclick="askDeleteProductRow(' + idx + ')" title="ลบ" aria-label="ลบรายการสินค้า"><i class="fas fa-trash"></i></button>' +
				'</td>' +
				'</tr>';
		}).join('');

		var isEditMode = <?php echo ($savedJong !== null && !$isCopy) ? 'true' : 'false'; ?>;
		hiddenWrap.innerHTML = productRows.map(function(row) {
			if (isEditMode) {
				return '<input type="hidden" name="id[]" value="' + escapeProductHtml(row.id || '') + '">' +
					'<input type="hidden" name="product_id[]" value="' + escapeProductHtml(row.product_id) + '">' +
					'<input type="hidden" name="count[]" value="' + escapeProductHtml(row.count) + '">' +
					'<input type="hidden" name="sale_remarkk[]" value="' + escapeProductHtml(row.remark || '') + '">';
			} else {
				return '<input type="hidden" name="product_id[]" value="' + escapeProductHtml(row.product_id) + '">' +
					'<input type="hidden" name="product_code[]" value="' + escapeProductHtml(row.product_code) + '">' +
					'<input type="hidden" name="sale_count[]" value="' + escapeProductHtml(row.count) + '">' +
					'<input type="hidden" name="sale_remark[]" value="' + escapeProductHtml(row.remark || '') + '">';
			}
		}).join('');
	}

	function addProductRow(product) {
		var existing = productRows.find(function(r) {
			return String(r.product_id) === String(product.product_id);
		});
		if (existing) {
			existing.count = (parseFloat(existing.count) || 0) + 1;
			renderProductTable();
			return;
		}
		productRows.push({
			product_id: product.product_id,
			product_code: product.product_code,
			product_name: product.product_name,
			unit_name: product.unit_name,
			count: 1,
			remark: ''
		});
		renderProductTable();
	}

	function removeProductRow(idx) {
		productRows.splice(idx, 1);
		renderProductTable();
	}

	function askDeleteProductRow(idx) {
		var product = productRows[idx];
		if (!product) return;

		Swal.fire({
			title: 'ลบรายการสินค้า ?',
			html: 'คุณต้องการลบ "' + escapeProductHtml(product.product_name) + '" ในรายการสินค้านี้',
			showCancelButton: true,
			confirmButtonText: 'ตกลง',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true,
			iconHtml: `
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
					<path d="M4 6H20V8H4V6Z" fill="#EF5350"/>
					<path d="M10 2H14V4H10V2Z" fill="#EF5350"/>
					<path d="M5 9H19V20C19 21.1046 18.1046 22 17 22H7C5.89543 22 5 21.1046 5 20V9Z" fill="#EF5350"/>
					<rect x="9" y="11" width="2" height="7" rx="1" fill="#ffffff"/>
					<rect x="13" y="11" width="2" height="7" rx="1" fill="#ffffff"/>
				</svg>
			`,
			customClass: {
				popup: 'figma-delete-popup',
				title: 'figma-delete-title',
				htmlContainer: 'figma-delete-html',
				confirmButton: 'figma-delete-confirm-btn',
				cancelButton: 'figma-delete-cancel-btn',
				actions: 'figma-delete-actions',
				icon: 'figma-delete-icon'
			},
			buttonsStyling: false
		}).then(function(result) {
			if (result.isConfirmed) {
				removeProductRow(idx);
			}
		});
	}

	function updateProductCount(idx, val) {
		productRows[idx].count = val;
		var hiddenWrap = document.getElementById('productHiddenInputs');
		var countInputName = <?php echo ($savedJong !== null && !$isCopy) ? "'count[]'" : "'sale_count[]'"; ?>;
		if (hiddenWrap) {
			var inputs = hiddenWrap.querySelectorAll('input[name="' + countInputName + '"]');
			if (inputs[idx]) inputs[idx].value = val;
		}
	}

	function updateProductRemark(idx, val) {
		productRows[idx].remark = val;
		var hiddenWrap = document.getElementById('productHiddenInputs');
		var remarkInputName = <?php echo ($savedJong !== null && !$isCopy) ? "'sale_remarkk[]'" : "'sale_remark[]'"; ?>;
		if (hiddenWrap) {
			var inputs = hiddenWrap.querySelectorAll('input[name="' + remarkInputName + '"]');
			if (inputs[idx]) inputs[idx].value = val;
		}
	}

	var productRemarkEditIndex = null;

	function openProductRemarkModal(idx) {
		productRemarkEditIndex = idx;
		var input = document.getElementById('productRemarkModalInput');
		if (input) input.value = productRows[idx].remark || '';

		var modal = document.getElementById('productRemarkModal');
		if (modal) {
			modal.style.display = 'flex';
			modal.setAttribute('aria-hidden', 'false');
		}
	}

	function closeProductRemarkModal() {
		var modal = document.getElementById('productRemarkModal');
		if (modal) {
			modal.style.display = 'none';
			modal.setAttribute('aria-hidden', 'true');
		}
		productRemarkEditIndex = null;
	}

	function confirmProductRemarkModal() {
		if (productRemarkEditIndex === null) return;
		var input = document.getElementById('productRemarkModalInput');
		var value = input ? input.value : '';
		updateProductRemark(productRemarkEditIndex, value);
		renderProductTable();
		closeProductRemarkModal();
	}

	// ลากสลับแถว (js/row-drag.js — ลากได้ทั้งเมาส์และนิ้ว)
	RowDrag.register({
		within: '#productTableBody',
		row: 'tr.product-row',
		onDrop: function(fromRow, toRow) {
			var moved = productRows.splice(parseInt(fromRow.getAttribute('data-idx'), 10), 1)[0];
			productRows.splice(parseInt(toRow.getAttribute('data-idx'), 10), 0, moved);
			renderProductTable();
		}
	});

	// ควบคุมเหตุการณ์หลังโหลดเอกสารเสร็จสิ้น
	document.addEventListener('DOMContentLoaded', function() {
		syncCreditTermTriggerState();

		var creditTermTrigger = document.getElementById('display_credit_thb_trigger');
		var creditTermModal = document.getElementById('creditTermPopupModal');

		if (creditTermTrigger) {
			creditTermTrigger.addEventListener('click', invokeCreditTermPopupOpen);
			creditTermTrigger.addEventListener('keydown', function(event) {
				if (event.key === 'Enter' || event.key === ' ') {
					event.preventDefault();
					invokeCreditTermPopupOpen();
				}
			});
		}

		if (creditTermModal) {
			creditTermModal.addEventListener('click', function(event) {
				if (event.target === creditTermModal) {
					invokeCreditTermPopupClose();
				}
			});
		}

		document.addEventListener('keydown', function(event) {
			if (event.key !== 'Escape') return;
			if (creditTermModal && creditTermModal.style.display === 'flex') {
				invokeCreditTermPopupClose();
			}
		});

		var productInput = document.getElementById('productSearchInput');
		var productResults = document.getElementById('productSearchResults');

		var companySelectEl = document.getElementById('company_select');
		if (companySelectEl) {
			companySelectEl.addEventListener('change', function() {
				productRows = [];
				renderProductTable();
				if (productInput) {
					productInput.value = '';
				}
				if (productResults) {
					productResults.style.display = 'none';
					productResults.innerHTML = '';
				}
			});
		}

		if (productInput && productResults) {
			productInput.addEventListener('input', function() {
				clearTimeout(productSearchTimer);
				var keyword = productInput.value.trim();
				if (keyword.length < 1) {
					productResults.style.display = 'none';
					productResults.innerHTML = '';
					return;
				}
				productSearchTimer = setTimeout(function() {
					var companySelect = document.getElementById('company_select');
					var companyValue = companySelect ? companySelect.value : '';
					fetch('ajax_product_popup_search.php?dept=' + PRODUCT_SEARCH_DEPT + '&company=' + encodeURIComponent(companyValue) + '&q=' + encodeURIComponent(keyword))
						.then(function(res) {
							return res.json();
						})
						.then(function(data) {
							if (!data || !data.success || !data.products.length) {
								productResults.innerHTML = '<div class="product-search-empty">ไม่พบสินค้า</div>';
								productResults.style.display = 'block';
								return;
							}
							productResults.innerHTML = data.products.map(function(p, i) {
								return '<div class="product-search-item" data-i="' + i + '">' +
									'<b>' + escapeProductHtml(p.product_code) + '</b> - ' + escapeProductHtml(p.product_name) +
									'</div>';
							}).join('');
							productResults.style.display = 'block';
							productResults.querySelectorAll('.product-search-item').forEach(function(el) {
								el.addEventListener('click', function() {
									var i = parseInt(el.getAttribute('data-i'), 10);
									addProductRow(data.products[i]);
									productInput.value = '';
									productResults.style.display = 'none';
									productResults.innerHTML = '';
								});
							});
						})
						.catch(function() {
							productResults.innerHTML = '<div class="product-search-empty">ค้นหาไม่สำเร็จ</div>';
							productResults.style.display = 'block';
						});
				}, 250);
			});

			document.addEventListener('click', function(e) {
				if (!productResults.contains(e.target) && e.target !== productInput) {
					productResults.style.display = 'none';
				}
			});
		}

		renderProductTable();

		<?php if ($savedJong !== null) { ?>
			// Load customer info (passing null for address to not overwrite saved shipping address)
			doCallAjax1('bill_id', 'customer', null);

			// Restore the custom saved shipping address
			var addrInput = document.getElementById('address_send');
			if (addrInput) {
				addrInput.value = <?php echo json_encode($savedJong['address_send'], JSON_UNESCAPED_UNICODE); ?>;
			}
		<?php } ?>
	});

	function fncSubmit(form) {
		if (window.soSkipValidation) {
			window.soSkipValidation = false;
			return true;
		}
		var requiredFields = [{
				id: 'type_jong',
				label: 'ประเภท'
			},
			{
				id: 'sale_code',
				label: 'แผนก/เขตการขาย'
			},
			{
				id: 'date_receive',
				label: 'วันที่ต้องการสินค้า'
			},
			{
				id: 'address_send',
				label: 'ที่อยู่ลูกค้า'
			}
		];

		for (var i = 0; i < requiredFields.length; i++) {
			var field = document.getElementById(requiredFields[i].id);
			if (field && field.hasAttribute('required') && !field.value.trim()) {
				Swal.fire('แจ้งเตือน', 'กรุณากรอก "' + requiredFields[i].label + '" ให้ครบถ้วน', 'warning');
				return false;
			}
		}

		if (!productRows.length) {
			Swal.fire('แจ้งเตือน', 'กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ', 'warning');
			return false;
		}

		return true;
	}

	var __formSubmitting = false;

	function lockSubmitForm(form) {
		if (!fncSubmit(form)) return false;
		if (__formSubmitting) return false;
		__formSubmitting = true;
		var btn = document.getElementById('btn_submit_form');
		if (btn) {
			// ต้อง disable แบบ deferred (setTimeout 0) เพราะถ้า disable ทันทีใน onsubmit
			// เบราว์เซอร์จะไม่ส่งค่า name="submit" ของปุ่มนี้ไปกับฟอร์ม (input ที่ disabled จะไม่ถูก serialize)
			// ทำให้ $_POST["submit"] หายไปฝั่ง PHP
			btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...';
			setTimeout(function() {
				btn.disabled = true;
			}, 0);
		}
		return true;
	}

	function goMainSupbook() {
		window.location.href = 'status_supjong.php';
	}

	function previewBooking() {
		var form = document.forms['frmMain'];
		if (!form) return;

		var flag = document.createElement('input');
		flag.type = 'hidden';
		flag.name = 'preview_mode';
		flag.value = '1';
		form.appendChild(flag);

		var originalAction = form.action;
		var originalTarget = form.target;
		form.action = 'report_jongpro.php';
		form.target = '_blank';

		HTMLFormElement.prototype.submit.call(form);

		form.action = originalAction;
		form.target = originalTarget;
		form.removeChild(flag);
	}

	function saveDraft() {
		var form = document.forms['frmMain'];
		if (!form) return;

		var btn = form.querySelector('[name="save_draft"]');
		var defaultHtml = btn ? btn.innerHTML : '';
		var formData = new FormData(form);
		formData.set('is_draft', '1');

		if (btn) {
			btn.disabled = true;
			btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
		}

		fetch('register_supbook_draft1.php', {
				method: 'POST',
				body: formData
			})
			.then(function(res) {
				return res.json();
			})
			.then(function(data) {
				if (data && data.success) {
					return Swal.fire({
						title: 'Save Draft success',
						text: 'Ref ID: ' + data.ref_id,
						icon: 'success',
						confirmButtonColor: '#612989'
					}).then(function() {
						window.location.href = 'register_supbook.php?ref_id=' + encodeURIComponent(data.ref_id) + '&saved=1';
					});
				}

				var message = data && data.message ? data.message : 'Unable to save draft';
				return Swal.fire('Error', message, 'error');
			})
			.catch(function() {
				return Swal.fire('Error', 'Unable to save draft', 'error');
			})
			.finally(function() {
				if (btn) {
					btn.disabled = false;
					btn.innerHTML = defaultHtml;
				}
			});
	}

	<?php if (isset($_GET["saved"]) && $_GET["saved"] === "1") { ?>
		document.addEventListener('DOMContentLoaded', function() {
			var cleanUrl = new URL(window.location.href);
			cleanUrl.searchParams.delete('saved');
			window.history.replaceState({}, document.title, cleanUrl);

			Swal.fire({
				title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
				text: 'ระบบแสดงข้อมูลที่บันทึกไว้ในหน้านี้แล้ว',
				icon: 'success',
				confirmButtonColor: '#612989',
				confirmButtonText: 'ตกลง'
			});
		});
	<?php } ?>
</script>
<script src="js/credit-term-modal.js?v=<?php echo filemtime(__DIR__ . '/js/credit-term-modal.js'); ?>"></script>