<?php
require_once __DIR__ . '/includes/so_saved_helpers.php';
include('head.php');
include('dbconnect.php');
?>
<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-supbrcshos.css?v=<?php echo filemtime(__DIR__ . '/css/register-supbrcshos.css'); ?>">
<link rel="stylesheet" href="css/register-breng-brgq.css?v=<?php echo filemtime(__DIR__ . '/css/register-breng-brgq.css'); ?>">
<link rel="stylesheet" href="css/breq-po-modal.css?v=<?php echo filemtime(__DIR__ . '/css/breq-po-modal.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/breq-po-modal.js?v=<?php echo filemtime(__DIR__ . '/js/breq-po-modal.js'); ?>"></script>
<script src="js/breq-item-table.js?v=<?php echo filemtime(__DIR__ . '/js/breq-item-table.js'); ?>"></script>

<?php
require_once __DIR__ . '/includes/breq_repo.php';

$today = date('Y-m-d');
$breqStockConn = (isset($new) && $new instanceof mysqli) ? $new : $conn;

// ?ref_id_br= เปิดเอกสารที่บันทึกไว้ (Draft / Request / อื่น ๆ) — ไม่มี = สร้างใบใหม่
$breqRefParam = trim((string)($_GET['ref_id_br'] ?? ''));
$breqDoc = null;
if ($breqRefParam !== '') {
	$breqDoc = breq_load_document($conn, $breqStockConn, $breqRefParam);
	if ($breqDoc === null) {
		echo "<script>alert(" . json_encode('ไม่พบเอกสาร ' . $breqRefParam, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) . ");window.location='status_brhos_breq.php';</script>";
		exit;
	}
}
$breqHeader = $breqDoc ? $breqDoc['header'] : array();
$breqItems = $breqDoc ? $breqDoc['items'] : array();

// ?copy_from= คัดลอกใบเดิมเป็นใบใหม่ (เฉพาะตอนไม่มี ref_id_br) — ยกหัวเอกสาร + รายการพร้อมจำนวน
// ไม่ยกเลขที่/วันที่เอกสารของ Admin และสถานะ ผู้สร้างใบใหม่คือคนที่ login อยู่
// คัดลอกได้ทุกสถานะที่มองเห็นใน status_brhos_breq.php — Draft ของคนอื่นมองไม่เห็นจึงปฏิเสธเหมือนไม่พบ
$breqCopyNotice = '';
$breqCopyFromRefId = $breqDoc === null ? trim((string)($_GET['copy_from'] ?? '')) : '';
if ($breqCopyFromRefId !== '') {
	$breqCopySource = breq_load_document($conn, $breqStockConn, $breqCopyFromRefId, '');
	$breqCopyHidden = $breqCopySource !== null
		&& (string)$breqCopySource['header']['status_doc'] === 'Draft'
		&& (string)$breqCopySource['header']['sale_code'] !== (string)($_SESSION['code'] ?? '');
	if ($breqCopySource === null || $breqCopyHidden) {
		$breqCopyNotice = 'ไม่พบเอกสารต้นทาง ' . $breqCopyFromRefId . ' — เปิดเป็นใบใหม่แทน';
	} else {
		$breqHeader = array_intersect_key($breqCopySource['header'], array_flip(array(
			'company', 'po_no', 'ref_id_stock', 'customer_id', 'address', 'sale_comment',
		)));
		$breqItems = $breqCopySource['items'];
	}
}
$breqStatus = (string)($breqHeader['status_doc'] ?? '');

// ปุ่ม/การล็อกฟอร์มคำนวณจากฟังก์ชันชุดเดียวกับฝั่ง server (includes/breq_repo.php) — ซ่อนปุ่มเป็นแค่ UX
// ทุก action ตรวจสิทธิ์ + สถานะซ้ำที่ register_breng_save_breq.php / register_breng1_breq.php / register_breng_action_breq.php
$breqHasDoc = ($breqDoc !== null);
$breqCanEdit = !$breqHasDoc || breq_user_can_edit_document($breqHeader, $_SESSION);
$breqCanSubmit = $breqCanEdit && (!$breqHasDoc || breq_is_owner_stage($breqHeader));
$breqCanAct = $breqHasDoc && breq_user_can_act_as_sup($breqHeader, $_SESSION);
$breqAdminEdit = $breqHasDoc && breq_user_can_admin_edit($breqHeader, $_SESSION);
$breqReadonly = !$breqCanEdit;
// Save Draft ใช้กับใบใหม่/Draft (ไม่บังคับครบ) — Returned / Request ใช้ update (ตรวจครบ คงสถานะ)
$breqSaveAction = (!$breqHasDoc || $breqStatus === 'Draft') ? 'draft' : 'update';
$breqSubmitLabel = ($breqStatus === 'Request') ? 'ส่ง Sup' : 'Submit';
$breqBackUrl = $breqCanAct ? 'status_approvebrsup_breq.php' : 'status_brhos_breq.php';

// ประวัติส่งกลับ/ไม่อนุมัติ/ยกเลิก (tb_document_status_log) — แบนเนอร์เหตุผลล่าสุด + ตารางประวัติ
// BREQ เขียนแค่ค่าอังกฤษ แต่ map ค่าไทย (ส่งกลับ / ยกเลิก) ไว้ด้วยตาม pattern กลางของ log
$breqLogLabels = array('Returned' => 'ส่งกลับ', 'ส่งกลับ' => 'ส่งกลับ', 'Rejected' => 'ไม่อนุมัติ', 'Cancelled' => 'ยกเลิกเอกสาร', 'ยกเลิก' => 'ยกเลิกเอกสาร');
$breqLogClasses = array('Returned' => 'is-returned', 'ส่งกลับ' => 'is-returned', 'Rejected' => 'is-rejected', 'Cancelled' => 'is-cancelled', 'ยกเลิก' => 'is-cancelled');
$breqLogTitles = array('Returned' => 'เหตุผลในการส่งกลับ', 'ส่งกลับ' => 'เหตุผลในการส่งกลับ', 'Rejected' => 'เหตุผลที่ไม่อนุมัติ', 'Cancelled' => 'เหตุผลในการยกเลิก', 'ยกเลิก' => 'เหตุผลในการยกเลิก');
$breqLogRows = array();
if ($breqHasDoc) {
	$breqLogStmt = mysqli_prepare($conn, "SELECT status_doc, reason, user_name, created_at FROM tb_document_status_log
		WHERE ref_id = ? AND status_doc IN ('Returned','ส่งกลับ','Rejected','Cancelled','ยกเลิก') ORDER BY created_at DESC, id DESC");
	if ($breqLogStmt) {
		mysqli_stmt_bind_param($breqLogStmt, 's', $breqHeader['ref_id_br']);
		mysqli_stmt_execute($breqLogStmt);
		$breqLogResult = mysqli_stmt_get_result($breqLogStmt);
		while ($breqLogRow = mysqli_fetch_assoc($breqLogResult)) {
			$breqLogRows[] = $breqLogRow;
		}
		mysqli_stmt_close($breqLogStmt);
	}
}
$breqLatestLog = $breqLogRows[0] ?? null;

// ใบใหม่แสดงเลขโดยประมาณ (เลขจริงจองตอน Save Draft / Submit ใน breq_reserve_ref_id)
$breqDisplayRefId = $breqDoc ? (string)$breqHeader['ref_id_br'] : breq_next_ref_id($conn);
$breqCompany = (string)($breqHeader['company'] ?? '1');
$breqPoNo = (string)($breqHeader['po_no'] ?? '');
$breqEmployeeName = $breqDoc
	? (string)$breqHeader['customer']
	: trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? ''));
$breqIvDate = (string)($breqHeader['iv_date'] ?? '');
if ($breqIvDate === '0000-00-00') {
	$breqIvDate = '';
}

// ฟิลด์เดิมที่ Figma ตัดออกจากหน้าจอ (Q2=ข) — ยังส่งเป็น hidden ค่าว่าง เพราะ breq_insert_submit_side_tables()
// (includes/breq_repo.php) อ่านคีย์เหล่านี้ไปเขียน tb_register_data / tb_other_bill ตอน Submit
$breqCompatHiddenFields = array(
	'address_1', 'address_name', 'address_send', 'province_name',
	'start_date', 'between_date', 'start_time', 'end_time',
	'status', 'status_comment', 'fix_datetime', 'on_time', 'no_money',
	'call_customer', 'call_back', 'credit_card', 'cash', 'check_paper', 'bill',
	'tran', 'dep', 'dept', 'want_bus', 'more', 'have_map',
	'unit_cash', 'unit_check', 'unit_credit', 'unit_bill', 'unit_tran',
	'department_name', 'department_show', 'customer_typename',
	'customer_name', 'customer_tel', 'customer_contact',
	'employee_name', 'employee_tel', 'product_sn', 'add_by', 'que_ckk',
	'returns', 'returns_date', 'returns_time', 'returns_name', 'returns_address', 'returns_contact', 'return_date_bet',
	'objective', 'objective_des1', 'objective_des2', 'objective_des4', 'objective_des5',
	'sn_ckk', 'sn', 'cm_no',
	'ref_1', 'ref_2', 'ref_3', 'ref_4', 'ref_5', 'ref_6', 'ref_7', 'ref_8', 'ref_9', 'ref_10', 'ref_11', 'ref_des',
	'head_1', 'amphur_name',
);
?>

<!-- form ครอบ container (แบบ register_bregawl.php) เพื่อให้แถบปุ่มด้านล่างอยู่นอกกรอบ 1096px และกว้างเต็มพื้นที่เนื้อหา -->
<form action="register_breng1_breq.php" method="post" name="frmMain" class="breq-page-form" enctype="multipart/form-data" onsubmit="return breqValidateSubmit();">
<div class="w3-container register-so-main" style="max-width:1096px;margin:0 auto;">

	<div class="so-header-container">
		<div class="so-header-left">
			<h1 class="so-title">ใบยืมตรวจเช็คสินค้า (BREQ)</h1>
			<div class="so-ref-info">
				<span class="so-ref-label">เลขที่อ้างอิง</span>
				<span class="so-ref-value"><?php echo so_saved_h($breqDisplayRefId); ?></span>
			</div>
		</div>
		<div class="so-header-right">
			<button type="button" class="btn-preview-so" onclick="breqOpenPreview();">
				<img src="img/icons/preview.png" alt="preview" style="width: 16px; height: 16px;"> Preview
			</button>
		</div>
	</div>

		<?php if ($breqLatestLog !== null && trim((string)$breqLatestLog['reason']) !== '') { ?>
			<div class="so-latest-reason-banner <?php echo so_saved_h($breqLogClasses[$breqLatestLog['status_doc']] ?? 'is-cancelled'); ?>" role="status">
				<button type="button" class="so-latest-reason-close" aria-label="ปิด" onclick="this.closest('.so-latest-reason-banner').style.display='none';">&times;</button>
				<div class="so-latest-reason-title"><?php echo so_saved_h($breqLogTitles[$breqLatestLog['status_doc']] ?? ''); ?></div>
				<div class="so-latest-reason-text"><?php echo nl2br(so_saved_h($breqLatestLog['reason'])); ?></div>
			</div>
		<?php } ?>

		<!-- ref_id_br ว่าง = ใบใหม่ (จองเลขตอนบันทึก) / มีค่า = บันทึกทับเอกสารนี้ — พรีวิวใช้ ref_id_preview แทนเมื่อว่าง -->
		<input type="hidden" name="ref_id_br" id="ref_id_br" value="<?php echo $breqDoc ? so_saved_h($breqDisplayRefId) : ''; ?>">
		<input type="hidden" name="ref_id_preview" value="<?php echo so_saved_h($breqDisplayRefId); ?>">
		<input type="hidden" name="type_breng" value="2">
		<input type="hidden" name="date_br" value="<?php echo so_saved_h($breqDoc ? (string)$breqHeader['date_br'] : $today); ?>">
		<input type="hidden" name="po_no" id="po_no" value="<?php echo so_saved_h($breqPoNo); ?>">
		<input type="hidden" name="ref_id_stock" id="ref_id_stock" value="<?php echo so_saved_h($breqHeader['ref_id_stock'] ?? ''); ?>">
		<input type="hidden" name="customer_id" id="customer_id" value="<?php echo so_saved_h($breqHeader['customer_id'] ?? ''); ?>">
		<input type="hidden" name="h_customer" id="h_customer" value="">
		<input type="hidden" name="address" id="address" value="<?php echo so_saved_h($breqHeader['address'] ?? ''); ?>">

		<!-- Compatibility layer: ฟิลด์เดิมที่ Figma ตัดออก แต่ register_breng1_breq.php ยังอ่านคีย์เหล่านี้อยู่
		     (เขียนลง tb_register_data / in__br) ส่งค่าว่างไปกันแค่ PHP notice ไม่ได้ลบทิ้งจริง (มติ Q2=ข) -->
		<?php foreach ($breqCompatHiddenFields as $breqCompatField) { ?>
			<input type="hidden" name="<?php echo so_saved_h($breqCompatField); ?>" value="">
		<?php } ?>

		<div class="so-tabs-container">
			<button type="button" class="so-tab-btn active" onclick="switchBrMainTab(this, 'tab-document-info')">ข้อมูลเอกสาร</button>
			<button type="button" class="so-tab-btn" onclick="switchBrMainTab(this, 'tab-admin-info')">Admin</button>
		</div>

		<div id="tab-document-info" class="so-tab-content active">

			<!-- ===================== การ์ด: ข้อมูลเอกสาร ===================== -->
			<div class="so-card">
				<div class="so-section-title-container">
					<h2 class="so-section-title">ข้อมูลเอกสาร</h2>
					<hr class="so-divider">
				</div>

				<div class="so-grid-3 breq-doc-row">
					<div class="so-field-group">
						<label class="so-label" for="company_select">บริษัท <span style="color:red;">*</span></label>
						<div class="so-select-wrapper">
							<select name="company" id="company_select" class="so-select" required onchange="breqHandleCompanyChange(this);">
								<option value="1"<?php echo $breqCompany !== '2' ? ' selected' : ''; ?>>AWL</option>
								<option value="2"<?php echo $breqCompany === '2' ? ' selected' : ''; ?>>NBM</option>
							</select>
						</div>
					</div>
					<div class="so-field-group">
						<label class="so-label" for="customer">พนักงาน</label>
						<input type="text" name="customer" id="customer" class="so-input" readonly
							value="<?php echo so_saved_h($breqEmployeeName); ?>">
					</div>
					<div class="so-field-group breq-po-field-cell" id="breq_po_field">
						<button type="button" class="btn-add-customer-pill" onclick="breqOpenPoModal();">
							<img src="img\icons\preview.png" alt="search" style="width: 20px;">
							<span id="breq_po_display" class="breq-po-display"><?php echo $breqPoNo !== '' ? so_saved_h($breqPoNo) : 'ค้นหาเอกสาร PO'; ?></span>
						</button>
					</div>
				</div>

				<div class="so-field-group" style="margin-bottom: 0;">
					<label class="so-label" for="sale_comment">หมายเหตุ</label>
					<div class="so-input-wrapper">
						<input type="text" name="sale_comment" id="sale_comment" class="so-input" placeholder="ระบุหมายเหตุ" value="<?php echo so_saved_h($breqHeader['sale_comment'] ?? ''); ?>">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('sale_comment').value='';" aria-label="ล้างค่า"></button>
					</div>
				</div>
			</div>

			<!-- ===================== การ์ด: รายการสินค้า ===================== -->
			<div class="so-card">
				<div class="so-section-title-container">
					<h2 class="so-section-title">รายการสินค้า</h2>
					<span class="breq-item-count" id="breq_item_count">0 รายการ</span>
					<hr class="so-divider">
				</div>

				<div class="so-product-table-wrap">
					<table class="so-product-table breq-item-table">
						<thead>
							<tr>
								<th>รหัสสินค้า</th>
								<th>รายการสินค้า</th>
								<th>จำนวนยืม</th>
								<th>จำนวนคงเหลือให้ยืม</th>
								<th>ระยะเวลายืม(วัน)</th>
								<th aria-label="แก้ไข / ลบ"></th>
							</tr>
						</thead>
						<tbody id="breq_item_tbody"></tbody>
					</table>
				</div>
				<div class="breq-empty-state" id="breq_item_empty">ยังไม่มีรายการ — กด "ค้นหาเอกสาร PO" เพื่อเลือกสินค้า</div>
			</div>

			<?php
			// แท็บ "การส่งกลับเอกสาร" (partials/doc_tabs_card.php) — แสดงทุกกรณี ใบใหม่ได้ empty_text
			$breqLogRowsForTabs = array();
			foreach ($breqLogRows as $breqLogRow) {
				$breqLogTime = strtotime((string)$breqLogRow['created_at']);
				$breqLogRowsForTabs[] = array(
					'status_label' => $breqLogLabels[$breqLogRow['status_doc']] ?? $breqLogRow['status_doc'],
					'status_class' => $breqLogClasses[$breqLogRow['status_doc']] ?? 'is-cancelled',
					'reason'       => $breqLogRow['reason'],
					'user_name'    => $breqLogRow['user_name'],
					'created_at'   => $breqLogTime !== false ? date('d-m-Y H:i', $breqLogTime) : '',
				);
			}
			$docTabsCard = array(
				'open_fn' => 'breqOpen3Tab',
				'document_return_log' => array(
					'enabled' => true,
					'rows' => $breqLogRowsForTabs,
					'empty_text' => 'ยังไม่มีรายการส่งกลับเอกสาร',
				),
			);
			include __DIR__ . '/partials/doc_tabs_card.php';
			unset($docTabsCard);
			?>
		</div>

		<?php
		$adminInfoTab = array(
			'tab_id' => 'tab-admin-info',
			'title'  => 'ข้อมูลเพิ่มเติม (Admin)',
			'rows'   => array(array(
				array('type' => 'text', 'name' => 'admin_doc_no', 'label' => 'เลขที่เอกสาร', 'placeholder' => 'No.', 'value' => (string)($breqHeader['iv_no'] ?? '')),
				array('type' => 'button', 'icon' => 'img/icons/doc.png', 'label' => 'Run เอกสาร', 'id' => 'btn_run_doc_no', 'onclick' => 'runDocumentNo();', 'variant' => 'purple'),
				array('type' => 'date_th', 'name' => 'admin_doc_date', 'label' => 'วันที่ออกเอกสาร', 'value' => $breqIvDate, 'icon' => 'far fa-calendar-alt'),
			)),
		);
		include __DIR__ . '/partials/admin_info_tab.php';
		unset($adminInfoTab);
		?>

	</div>

	<div class="so-sticky-actions breq-sticky-actions">
		<div class="so-sticky-actions-inner">
			<?php if ($breqCanAct) { ?>
				<!-- แถบอนุมัติของ Sup — ส่งไป register_breng_action_breq.php (ตรวจสิทธิ์/สถานะซ้ำที่ server) -->
				<div class="so-approve-actions">
					<button type="button" class="so-overflow-menu-trigger" id="breq_btn_approve_overflow" onclick="breqToggleApproveMenu();" aria-label="เมนูเพิ่มเติม"><i class="fas fa-ellipsis-v"></i></button>
					<div id="breqApproveOverflowMenu" class="so-overflow-menu">
						<button type="button" onclick="breqRunReasonAction('return');" style="color: #FF830F;"><img src="img/icons/send_back.png" alt="" style="width: 20px; height: 20px;"> ส่งกลับ</button>
						<button type="button" class="so-menu-danger" onclick="breqRunReasonAction('reject');" style="color: #FF0000;"><img src="img/icons/reject.png" alt="" style="width: 20px; height: 20px;"> ไม่อนุมัติ</button>
						<button type="button" onclick="breqRunReasonAction('cancel');" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; font-family: 'Prompt', sans-serif; font-size: 14px; color: #4A4A4A; cursor: pointer;"><img src="img/icons/cancel_document.png" alt="" style="width: 20px; height: 20px;"> ยกเลิกเอกสาร</button>
					</div>
					<button type="button" class="btn-so-approve" id="btn_breq_approve" onclick="breqApprove();"><i class="far fa-check-circle"></i> อนุมัติ</button>
				</div>
			<?php } ?>
			<?php if ($breqCanSubmit) { ?>
				<button type="submit" name="submit" id="btn_submit_form" value="submit" class="btn-so-submit"><i class="fas fa-paper-plane"></i> <?php echo so_saved_h($breqSubmitLabel); ?></button>
			<?php } ?>
			<?php if ($breqCanEdit) { ?>
				<button type="button" id="btn_breq_save" class="btn-so-draft" onclick="breqSave(<?php echo so_saved_h(json_encode($breqSaveAction)); ?>);"><i class="far fa-save"></i> <?php echo $breqHasDoc ? 'Update' : 'Save Draft'; ?></button>
			<?php } ?>
			<?php if ($breqAdminEdit) { ?>
				<button type="button" id="btn_breq_admin_save" class="btn-so-draft" onclick="breqAdminSave();"><i class="far fa-save"></i> บันทึกเลขที่เอกสาร</button>
			<?php } ?>
			<button type="button" class="btn-so-cancel-nav" onclick="window.location.href=<?php echo so_saved_h(json_encode($breqBackUrl)); ?>;">ย้อนกลับ</button>
		</div>
	</div>
</form>

<!-- ===================== Modal: ค้นหาเอกสาร PO (js/breq-po-modal.js) ===================== -->
<div id="breqPoModal" class="customer-popup-modal" aria-hidden="true" style="display:none;">
	<div class="customer-popup-box breq-po-box" role="dialog" aria-modal="true" aria-labelledby="breqPoModalTitle">
		<button type="button" class="customer-popup-close" onclick="breqClosePoModal()" aria-label="Close">&times;</button>

		<div class="customer-popup-header">
			<h2 id="breqPoModalTitle">ค้นหาเอกสาร PO</h2>
			<div class="customer-popup-toolbar" style="margin-top:18px;">
				<div class="customer-popup-search-wrap">
					<label for="breqPoModalSearch">ค้นหาด้วยเลขที่ PO / ชื่อสินค้า / Lot</label>
					<div class="customer-popup-search">
						<i class="fas fa-search" aria-hidden="true"></i>
						<input type="text" id="breqPoModalSearch" placeholder="พิมพ์คำค้นหา...">
					</div>
				</div>
			</div>
			<p class="breq-po-lock-note" id="breqPoLockNote" style="display:none;"></p>
		</div>

		<div class="customer-popup-table-wrap">
			<table class="customer-popup-table breq-po-table">
				<thead>
					<tr>
						<th scope="col">เลขที่ PO</th>
						<th scope="col">รายการสินค้า</th>
						<th scope="col">ยอดรับเข้า</th>
						<th scope="col">คงเหลือ</th>
						<th scope="col">วันที่รับเข้า</th>
						<th scope="col">Lot</th>
					</tr>
				</thead>
				<tbody id="breqPoModalRows">
					<tr>
						<td colspan="6" class="customer-popup-empty">พิมพ์คำค้นหาหรือกดค้นหาเพื่อแสดงรายการ</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="customer-popup-actions">
			<button type="button" class="customer-popup-confirm" onclick="breqConfirmPoModal();">ตกลง</button>
			<button type="button" class="customer-popup-cancel" onclick="breqClosePoModal();">ย้อนกลับ</button>
		</div>
	</div>
</div>

<!-- ===================== Modal: รายการสินค้าเพิ่มเติม (Figma 1011:4913) ===================== -->
<div id="breq_edit_modal" class="cs-modal-overlay" style="display:none;">
	<div class="cs-modal-card breq-remark-modal-card">
		<div class="cs-modal-header">
			<h3 class="cs-modal-title">ข้อมูลรายการสินค้าเพิ่มเติม</h3>
			<button type="button" class="cs-modal-close-btn" onclick="breqCloseEditModal();" aria-label="ปิด">&times;</button>
		</div>
		<div class="cs-modal-body breq-modal-body">
			<div class="breq-modal-fields">
				<div class="so-field-group">
					<label class="so-label" for="breq_modal_remark">หมายเหตุสินค้า</label>
					<div class="so-input-wrapper">
						<input type="text" id="breq_modal_remark" class="so-input" placeholder="ระบุหมายเหตุสินค้า" autocomplete="off"
							onkeydown="if (event.key === 'Enter') { event.preventDefault(); }">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('breq_modal_remark').value='';" aria-label="ล้างค่าหมายเหตุสินค้า"></button>
					</div>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="breq_modal_nameother">ชื่อที่แสดงในใบส่งสินค้า</label>
					<div class="so-input-wrapper">
						<input type="text" id="breq_modal_nameother" class="so-input" placeholder="ระบุชื่อที่แสดงในใบส่งสินค้า" autocomplete="off"
							onkeydown="if (event.key === 'Enter') { event.preventDefault(); }">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('breq_modal_nameother').value='';" aria-label="ล้างค่าชื่อที่แสดงในใบส่งสินค้า"></button>
					</div>
				</div>
			</div>
		</div>
		<div class="cs-modal-footer">
			<button type="button" class="cs-modal-btn-update" onclick="breqSaveEditModal();">อัพเดท</button>
			<button type="button" class="cs-modal-btn-cancel" onclick="breqCloseEditModal();">ยกเลิก</button>
		</div>
	</div>
</div>

<script>
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

	/* สลับแท็บของ partials/doc_tabs_card.php — pattern เดียวกับ bregOpen3Tab ของ register_bregawl.php */
	function breqOpen3Tab(tabId, element) {
		var contents = document.getElementsByClassName('so-3tab-content');
		for (var i = 0; i < contents.length; i++) contents[i].style.display = 'none';
		var btns = element.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < btns.length; i++) btns[i].classList.remove('active');
		document.getElementById(tabId).style.display = 'block';
		element.classList.add('active');
	}

	// Run เอกสาร — ported จาก register_supbrcshos.php:1096-1159 เปลี่ยน doc_type เป็น 9 (prefix BREQ)
	function runDocumentNo() {
		var companySelect = document.getElementById('company_select');
		var docNoInput = document.querySelector('input[name="admin_doc_no"]');
		var docDateInput = document.querySelector('input[name="admin_doc_date"]');
		var runButton = document.getElementById('btn_run_doc_no');

		if (!companySelect || !docNoInput) {
			return;
		}

		if (docNoInput.value.trim() !== '') {
			if (!confirm('เอกสารนี้มีเลขที่ ' + docNoInput.value.trim() + ' อยู่แล้ว ต้องการออกเลขใหม่ทับหรือไม่?')) {
				return;
			}
		}

		// ajax_run_doc_no.php ใช้เลข AWL=3/NBM=4 คนละชุดกับ in__br.company ที่เป็น 1/2
		var companyMapToAjax = { '1': '3', '2': '4' };
		var payload = new URLSearchParams();
		payload.append('company', companyMapToAjax[companySelect.value] || companySelect.value);
		payload.append('doc_type', '9');
		payload.append('doc_date', docDateInput ? docDateInput.value : '');

		if (runButton) {
			runButton.disabled = true;
		}

		fetch('ajax_run_doc_no.php', {
				method: 'POST',
				credentials: 'same-origin',
				cache: 'no-store',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
				body: payload.toString()
			})
			.then(function(response) {
				return response.json().then(function(data) {
					return { ok: response.ok, data: data };
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

	// เปลี่ยนบริษัท (AWL/NBM) — ถ้ามีรายการสินค้าอยู่แล้วต้องล้างทิ้งก่อน เพราะ PO ที่ล็อกไว้
	// (po_no/ref_id_stock) ผูกกับบริษัทเดิม สลับบริษัทแล้วเลขที่ PO เดิมจะใช้ไม่ได้อีกต่อไป
	// ported pattern จาก register_suphos.php:2109-2114 (handleCompanyChange)
	function breqHandleCompanyChange(sel) {
		var hasItems = document.querySelectorAll('#breq_item_tbody tr.breq-item-row').length > 0;
		if (hasItems) {
			if (!confirm('การเปลี่ยนบริษัทจะล้างรายการสินค้าและเอกสาร PO ที่เลือกไว้ทั้งหมด ต้องการดำเนินการต่อหรือไม่?')) {
				sel.value = sel.getAttribute('data-prev');
				return;
			}
			if (typeof window.breqClearAllItems === 'function') window.breqClearAllItems();
		}
		// ล้าง PO ที่ล็อกไว้เสมอ แม้ตารางว่าง (ไม่มีอะไรให้เสีย จึงไม่ต้องถาม) — ถ้าปล่อยค้าง
		// modal จะแสดง PO ของบริษัทใหม่แต่ทุกแถวถูก disable เพราะไม่ตรงกับ po_no เดิม
		if (typeof window.breqResetPoLock === 'function') window.breqResetPoLock();
		sel.setAttribute('data-prev', sel.value);
	}

	// สิทธิ์ของผู้ใช้กับใบนี้ (คำนวณฝั่ง PHP ด้วยฟังก์ชันชุดเดียวกับ server — ซ่อน/แสดงเป็นแค่ UX)
	var BREQ_STATE = <?php echo json_encode(array(
		'isNew'     => !$breqHasDoc,
		'readonly'  => $breqReadonly,
		'canSubmit' => $breqCanSubmit,
		'adminEdit' => $breqAdminEdit,
	)); ?>;
	var breqSubmitting = false;

	function breqNotify(title, text, icon) {
		if (typeof Swal !== 'undefined') {
			Swal.fire({ title: title, text: text, icon: icon, confirmButtonColor: '#612989' });
		} else {
			alert(title + (text ? '\n' + text : ''));
		}
	}

	// อ่านอย่างเดียว: ล็อกทุกช่องในฟอร์ม ซ่อนปุ่มเลือก PO / ล้างค่า / Run เอกสาร
	// (พรีวิวปลดล็อกชั่วคราวตอนส่ง — ดู breqWithDisabledFieldsEnabled)
	function breqApplyReadonly() {
		var form = document.forms.frmMain;
		if (!form) return;
		form.querySelectorAll('input:not([type="hidden"]), select, textarea').forEach(function(el) {
			el.disabled = true;
		});
		form.querySelectorAll('.so-clear-icon, #breq_po_field button, #btn_run_doc_no').forEach(function(el) {
			el.style.display = 'none';
		});
		// Admin ของใบที่อนุมัติแล้ว: เปิดเฉพาะเลขที่/วันที่เอกสาร + ปุ่ม Run เอกสาร
		if (BREQ_STATE.adminEdit) {
			form.querySelectorAll('input[name="admin_doc_no"], input[name="admin_doc_date"]').forEach(function(el) {
				el.disabled = false;
			});
			var runButton = document.getElementById('btn_run_doc_no');
			if (runButton) runButton.style.display = '';
		}
	}

	// ข้อความหลัง redirect กลับมาหน้านี้ (?saved= จากการบันทึก / ?done= จาก action อนุมัติ)
	var BREQ_DONE_MESSAGES = {
		approved: 'อนุมัติเอกสารเรียบร้อยแล้ว',
		returned: 'ส่งกลับเอกสารเรียบร้อยแล้ว',
		rejected: 'ไม่อนุมัติเอกสารเรียบร้อยแล้ว',
		cancelled: 'ยกเลิกเอกสารเรียบร้อยแล้ว',
		admin_saved: 'บันทึกเลขที่เอกสารเรียบร้อยแล้ว'
	};

	document.addEventListener('DOMContentLoaded', function() {
		if (typeof window.breqHydrateRows === 'function') {
			window.breqHydrateRows(<?php echo json_encode($breqItems, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>, BREQ_STATE.readonly);
		}
		if (BREQ_STATE.readonly) breqApplyReadonly();

		var companySelect = document.getElementById('company_select');
		if (companySelect) companySelect.setAttribute('data-prev', companySelect.value);

		// ลบ ?saved= / ?done= ออกจาก URL กัน modal เด้งซ้ำตอน refresh
		var saved = <?php echo json_encode((string)($_GET['saved'] ?? '')); ?>;
		var done = <?php echo json_encode((string)($_GET['done'] ?? '')); ?>;
		var title = '';
		var text = '';
		if (['submit', 'draft', 'update'].indexOf(saved) !== -1) {
			title = 'บันทึกข้อมูลเรียบร้อยแล้ว';
			text = 'ระบบแสดงข้อมูลที่บันทึกไว้ในหน้านี้แล้ว';
		} else if (Object.prototype.hasOwnProperty.call(BREQ_DONE_MESSAGES, done)) {
			title = BREQ_DONE_MESSAGES[done];
			text = 'เลขที่อ้างอิง: ' + document.getElementById('ref_id_br').value;
		}
		if (title !== '') {
			var cleanUrl = new URL(window.location.href);
			cleanUrl.searchParams.delete('saved');
			cleanUrl.searchParams.delete('done');
			window.history.replaceState({}, document.title, cleanUrl);

			if (typeof Swal !== 'undefined') {
				Swal.fire({
					title: title,
					text: text,
					icon: 'success',
					confirmButtonColor: '#612989',
					confirmButtonText: 'ตกลง'
				});
			}
		}

		var copyNotice = <?php echo json_encode($breqCopyNotice, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
		if (copyNotice !== '') {
			breqNotify('คัดลอกใบเดิมไม่สำเร็จ', copyNotice, 'warning');
		}
	});

	function breqHasItems() {
		if (document.querySelectorAll('#breq_item_tbody tr.breq-item-row').length > 0) return true;
		breqNotify('แจ้งเตือน', 'กรุณาเลือกสินค้าจากเอกสาร PO อย่างน้อย 1 รายการ', 'warning');
		return false;
	}

	// ก่อน submit จริง ต้องมีรายการสินค้าอย่างน้อย 1 รายการ (ซึ่งหมายความว่า po_no ถูกล็อกแล้วด้วย)
	// Submit = ส่งให้ Sup อนุมัติด้วย จึงถามยืนยันก่อน แล้วค่อยส่งฟอร์มเองใน breqDoSubmit()
	function breqValidateSubmit() {
		if (!BREQ_STATE.canSubmit) return false; // Enter ในช่องกรอกของใบที่ Submit ไม่ได้ (เช่น Sup กำลังตรวจ)
		if (breqSubmitting) return false;
		if (!breqHasItems()) return false;

		var message = 'ต้องการส่งเอกสารนี้ให้ Sup อนุมัติใช่หรือไม่ ?';
		if (typeof Swal === 'undefined') {
			if (confirm(message)) breqDoSubmit();
			return false;
		}
		// หน้าตาเดียวกับ popup ยืนยันบันทึกของ register_suphos.php
		Swal.fire({
			title: 'ยืนยันการบันทึกข้อมูล',
			text: 'ตรวจสอบข้อมูลเรียบร้อยแล้ว ต้องการบันทึกข้อมูลนี้ใช่หรือไม่?',
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#612989',
			cancelButtonColor: '#8a8a8a',
			confirmButtonText: 'ยืนยันบันทึก',
			cancelButtonText: 'ยกเลิก'
		}).then(function(result) {
			if (result.isConfirmed) breqDoSubmit();
		});
		return false;
	}

	// ส่งฟอร์มแบบ programmatic ไม่มี submitter — เติม submit=submit ที่ register_breng1_breq.php ตรวจเอง
	// แล้วล็อกปุ่มกันกดซ้ำ (กดซ้ำระหว่างรอจะได้เอกสาร BQ สองใบ)
	function breqDoSubmit() {
		if (breqSubmitting) return;
		breqSubmitting = true;

		var form = document.forms.frmMain;
		var submitFlag = document.createElement('input');
		submitFlag.type = 'hidden';
		submitFlag.name = 'submit';
		submitFlag.value = 'submit';
		form.appendChild(submitFlag);

		var button = document.getElementById('btn_submit_form');
		if (button) {
			button.disabled = true;
			button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
		}
		// ปุ่ม name="submit" บัง form.submit() — เรียกผ่าน prototype แทน
		HTMLFormElement.prototype.submit.call(form);
	}

	// POST ฟอร์มแบบ AJAX แล้ว reload หน้านี้ของเลขที่ที่ได้กลับมา (ปลายทางตอบ {success, ref_id, message, ...})
	function breqPostForm(url, fields, button, loadingText, buildQuery) {
		var form = document.forms.frmMain;
		var formData = new FormData(form);
		Object.keys(fields).forEach(function(key) {
			formData.set(key, fields[key]);
		});

		var defaultHtml = button ? button.innerHTML : '';
		breqSubmitting = true;
		if (button) {
			button.disabled = true;
			button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + loadingText;
		}

		function unlock() {
			breqSubmitting = false;
			if (button) {
				button.disabled = false;
				button.innerHTML = defaultHtml;
			}
		}

		fetch(url, { method: 'POST', body: formData, credentials: 'same-origin' })
			.then(function(res) { return res.json(); })
			.then(function(data) {
				if (data && data.success) {
					window.location.href = 'register_breng_brgq.php?ref_id_br=' + encodeURIComponent(data.ref_id) + '&' + buildQuery(data);
					return;
				}
				unlock();
				breqNotify('ดำเนินการไม่สำเร็จ', (data && data.message) ? data.message : 'เกิดข้อผิดพลาดในการบันทึก', 'error');
			})
			.catch(function(err) {
				unlock();
				breqNotify('ดำเนินการไม่สำเร็จ', String(err), 'error');
			});
	}

	// action = 'draft' (Save Draft / Update ของ Draft — ไม่บังคับมีรายการ)
	//        | 'update' (Update ของ Returned / Request — ต้องมีรายการเหมือน Submit)
	function breqSave(action) {
		if (breqSubmitting) return;
		if (action === 'update' && !breqHasItems()) return;
		breqPostForm('register_breng_save_breq.php', { action: action }, document.getElementById('btn_breq_save'), 'Saving...', function() {
			return 'saved=' + action;
		});
	}

	/* ===================== แถบอนุมัติ (Sup) / ยกเลิก / Admin — ไป register_breng_action_breq.php ===================== */

	function breqRunDocAction(action, reason, button, loadingText) {
		breqPostForm('register_breng_action_breq.php', { breq_action: action, breq_reason: reason }, button, loadingText, function(data) {
			return 'done=' + encodeURIComponent(data.outcome);
		});
	}

	function breqToggleApproveMenu() {
		var menu = document.getElementById('breqApproveOverflowMenu');
		if (menu) menu.style.display = (menu.style.display === 'none' || !menu.style.display) ? 'block' : 'none';
	}

	document.addEventListener('click', function(e) {
		var menu = document.getElementById('breqApproveOverflowMenu');
		var trigger = document.getElementById('breq_btn_approve_overflow');
		if (!menu || !menu.style.display || menu.style.display === 'none') return;
		if (trigger && (e.target === trigger || trigger.contains(e.target))) return;
		if (!menu.contains(e.target)) menu.style.display = 'none';
	});

	function breqEscapeHtml(value) {
		var div = document.createElement('div');
		div.textContent = value == null ? '' : String(value);
		return div.innerHTML;
	}

	// popup กรอกเหตุผล — หน้าตาเดียวกับ openReasonPopup ของ js/register-supsmp.js (class จาก so-core.css)
	var BREQ_REASON_CONFIG = {
		'return': { title: 'ส่งกลับเอกสารนี้ ?', subtitle: 'ส่งกลับเอกสารเลขที่', label: 'ระบุเหตุผลการส่งกลับ', iconBg: '#FFF4E5', iconSrc: 'img/icons/send_back.png' },
		'reject': { title: 'ไม่อนุมัติเอกสารนี้ ?', subtitle: 'ไม่อนุมัติเอกสารเลขที่', label: 'ระบุเหตุผลที่ไม่อนุมัติ', iconBg: '#FEECEB', iconSrc: 'img/icons/reject.png' },
		'cancel': { title: 'ยกเลิกเอกสารนี้ ?', subtitle: 'ต้องการยกเลิกเอกสารเลขที่', label: 'ระบุเหตุผลในการยกเลิก', iconBg: '#F4F5F7', iconSrc: 'img/icons/cancel_document.png' }
	};

	function breqRunReasonAction(action) {
		var config = BREQ_REASON_CONFIG[action];
		if (breqSubmitting || !config) return;
		var menu = document.getElementById('breqApproveOverflowMenu');
		if (menu) menu.style.display = 'none';

		var refId = document.getElementById('ref_id_br').value;
		var button = document.getElementById('btn_breq_approve');
		var run = function(reason) {
			if (!breqSubmitting) breqRunDocAction(action, reason, button, 'กำลังดำเนินการ...');
		};
		if (typeof Swal === 'undefined') {
			var fallback = (window.prompt(config.label) || '').trim();
			if (fallback !== '') run(fallback);
			return;
		}
		Swal.fire({
			title: config.title,
			html: '<p class="so-reason-subtitle">' + breqEscapeHtml(config.subtitle) + ' "' + breqEscapeHtml(refId) + '"</p>' +
				'<label class="so-reason-label">' + breqEscapeHtml(config.label) + '<span class="so-reason-required">*</span></label>',
			input: 'textarea',
			inputPlaceholder: config.label,
			iconHtml: '<div class="so-reason-icon-circle" style="background:' + config.iconBg + '"><img src="' + config.iconSrc + '" alt="" style="width: 36px; height: 36px;"></div>',
			showCancelButton: true, showCloseButton: true, reverseButtons: false,
			confirmButtonText: 'ตกลง', cancelButtonText: 'ยกเลิก', buttonsStyling: false,
			customClass: {
				popup: 'figma-delete-popup so-reason-popup', title: 'figma-delete-title so-reason-title',
				htmlContainer: 'figma-delete-html so-reason-html', confirmButton: 'figma-delete-confirm-btn so-reason-confirm-btn',
				cancelButton: 'figma-delete-cancel-btn so-reason-cancel-btn', actions: 'figma-delete-actions so-reason-actions',
				icon: 'figma-delete-icon so-reason-icon', input: 'so-reason-textarea', closeButton: 'so-reason-close-btn'
			},
			preConfirm: function(value) {
				var trimmed = (value || '').trim();
				if (trimmed === '') { Swal.showValidationMessage('กรุณาระบุเหตุผล'); return false; }
				return trimmed;
			}
		}).then(function(result) {
			if (result.isConfirmed) run(result.value);
		});
	}

	// อนุมัติ — ส่งค่าฟอร์มปัจจุบันไปด้วย server บันทึกก่อน (ตรวจครบเหมือน Submit) แล้วอนุมัติในทรานแซกชันเดียวกัน
	function breqApprove() {
		if (breqSubmitting || !breqHasItems()) return;
		var refId = document.getElementById('ref_id_br').value;
		var approve = function() {
			breqRunDocAction('approve', '', document.getElementById('btn_breq_approve'), 'กำลังอนุมัติ...');
		};
		var message = 'ต้องการอนุมัติเอกสารเลขที่ "' + refId + '" ใช่หรือไม่? (ข้อมูลที่แก้ไขในหน้านี้จะถูกบันทึกด้วย)';
		if (typeof Swal === 'undefined') {
			if (confirm(message)) approve();
			return;
		}
		Swal.fire({
			icon: 'question',
			title: 'ยืนยันการอนุมัติเอกสาร',
			text: message,
			showCancelButton: true,
			confirmButtonText: 'ยืนยันอนุมัติ',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true,
			confirmButtonColor: '#612989',
			cancelButtonColor: '#6c757d'
		}).then(function(result) {
			if (result.isConfirmed) approve();
		});
	}

	// Admin บันทึกเลขที่/วันที่เอกสารของใบที่อนุมัติแล้ว
	function breqAdminSave() {
		if (breqSubmitting) return;
		var docNoInput = document.querySelector('input[name="admin_doc_no"]');
		if (!docNoInput || docNoInput.value.trim() === '') {
			breqNotify('แจ้งเตือน', 'กรุณาระบุเลขที่เอกสาร หรือกด Run เอกสารในแท็บ Admin', 'warning');
			return;
		}
		breqRunDocAction('admin_save', '', document.getElementById('btn_breq_admin_save'), 'Saving...');
	}

	// ช่องที่ disabled (โหมดอ่านอย่างเดียว) ไม่ถูกส่งไปกับฟอร์ม — ปลดชั่วคราวระหว่างส่งพรีวิว
	function breqWithDisabledFieldsEnabled(callback) {
		var form = document.forms.frmMain;
		var locked = Array.prototype.filter.call(form.querySelectorAll('[name]'), function(el) { return el.disabled; });
		locked.forEach(function(el) { el.disabled = false; });
		try {
			callback();
		} finally {
			locked.forEach(function(el) { el.disabled = true; });
		}
	}

	// เปิดพรีวิวใบพิมพ์ในแท็บใหม่ โดยยิงค่าปัจจุบันในฟอร์มไปให้ report_loanhosptl1_breq.php
	// (report มี preview path อ่านจาก POST อยู่ใน report_loanhosptl_breq_preview_helper.php)
	function breqOpenPreview() {
		var form = document.forms.frmMain;
		if (!form) return;

		var previewTarget = 'breq_preview_' + Date.now();
		var previewWindow = window.open('', previewTarget);
		if (!previewWindow) {
			if (typeof Swal !== 'undefined') {
				Swal.fire('เปิด Preview ไม่ได้', 'เบราว์เซอร์บล็อกหน้าต่างใหม่ กรุณาอนุญาต Pop-up แล้วลองอีกครั้ง', 'warning');
			} else {
				alert('เบราว์เซอร์บล็อกหน้าต่างใหม่ กรุณาอนุญาต Pop-up แล้วลองอีกครั้ง');
			}
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

		form.action = 'report_loanhosptl1_breq.php';
		form.method = 'post';
		form.target = previewTarget;
		form.enctype = 'application/x-www-form-urlencoded';
		breqWithDisabledFieldsEnabled(function() {
			HTMLFormElement.prototype.submit.call(form);
		});

		if (originalAction === null) form.removeAttribute('action');
		else form.setAttribute('action', originalAction);
		if (originalMethod === null) form.removeAttribute('method');
		else form.setAttribute('method', originalMethod);
		if (originalTarget === null) form.removeAttribute('target');
		else form.setAttribute('target', originalTarget);
		if (originalEnctype === null) form.removeAttribute('enctype');
		else form.setAttribute('enctype', originalEnctype);
		previewFlag.remove();

		if (BREQ_STATE.isNew && typeof Swal !== 'undefined' && typeof Swal.fire === 'function') {
			Swal.fire({
				toast: true,
				position: 'top-end',
				icon: 'info',
				title: 'เลขที่อ้างอิงในพรีวิวเป็นค่าประมาณการ อาจไม่ตรงกับเลขที่บันทึกจริง',
				showConfirmButton: false,
				timer: 3500,
				timerProgressBar: true
			});
		}
	}
</script>