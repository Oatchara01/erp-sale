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
$breqStatus = (string)($breqHeader['status_doc'] ?? '');

// new = ใบใหม่ / draft, request = เจ้าของแก้ได้ / readonly = สถานะอื่นหรือไม่ใช่เจ้าของ
if (!$breqDoc) {
	$breqMode = 'new';
} elseif (breq_can_edit_owner($breqHeader, $_SESSION) && in_array($breqStatus, array('Draft', 'Request'), true)) {
	$breqMode = $breqStatus === 'Draft' ? 'draft' : 'request';
} else {
	$breqMode = 'readonly';
}
$breqReadonly = ($breqMode === 'readonly');

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
			<?php if ($breqMode === 'new' || $breqMode === 'draft') { ?>
				<button type="submit" name="submit" id="btn_submit_form" value="submit" class="btn-so-submit"><i class="fas fa-paper-plane"></i> Submit</button>
				<button type="button" id="btn_breq_save" class="btn-so-draft" onclick="breqSave('draft');"><i class="far fa-save"></i> <?php echo $breqMode === 'draft' ? 'Update' : 'Save Draft'; ?></button>
			<?php } elseif ($breqMode === 'request') { ?>
				<button type="button" id="btn_breq_save" class="btn-so-draft" onclick="breqSave('update');"><i class="far fa-save"></i> Update</button>
			<?php } ?>
			<button type="button" class="btn-so-cancel-nav" onclick="window.location.href='status_brhos_breq.php';">ย้อนกลับ</button>
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

	// โหมดของหน้า (คำนวณฝั่ง PHP): new / draft / request / readonly
	var BREQ_MODE = <?php echo json_encode($breqMode); ?>;
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
	}

	document.addEventListener('DOMContentLoaded', function() {
		if (typeof window.breqHydrateRows === 'function') {
			window.breqHydrateRows(<?php echo json_encode($breqDoc ? $breqDoc['items'] : array(), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>, BREQ_MODE === 'readonly');
		}
		if (BREQ_MODE === 'readonly') breqApplyReadonly();

		var companySelect = document.getElementById('company_select');
		if (companySelect) companySelect.setAttribute('data-prev', companySelect.value);

		// ?saved= มาจาก redirect หลัง Submit / Save Draft / Update — ลบออกจาก URL กัน modal เด้งซ้ำตอน refresh
		var saved = <?php echo json_encode((string)($_GET['saved'] ?? '')); ?>;
		if (['submit', 'draft', 'update'].indexOf(saved) !== -1) {
			var cleanUrl = new URL(window.location.href);
			cleanUrl.searchParams.delete('saved');
			window.history.replaceState({}, document.title, cleanUrl);

			if (typeof Swal !== 'undefined') {
				Swal.fire({
					title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
					text: 'ระบบแสดงข้อมูลที่บันทึกไว้ในหน้านี้แล้ว',
					icon: 'success',
					confirmButtonColor: '#612989',
					confirmButtonText: 'ตกลง'
				});
			}
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
		if (BREQ_MODE !== 'new' && BREQ_MODE !== 'draft') return false; // Enter ในช่องกรอกของโหมดอื่น
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

	function breqPostAction(action, button, loadingText) {
		var form = document.forms.frmMain;
		var formData = new FormData(form);
		formData.set('action', action);

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

		fetch('register_breng_save_breq.php', { method: 'POST', body: formData, credentials: 'same-origin' })
			.then(function(res) { return res.json(); })
			.then(function(data) {
				if (data && data.success) {
					window.location.href = 'register_breng_brgq.php?ref_id_br=' + encodeURIComponent(data.ref_id) + '&saved=' + action;
					return;
				}
				unlock();
				breqNotify('บันทึกไม่สำเร็จ', (data && data.message) ? data.message : 'เกิดข้อผิดพลาดในการบันทึก', 'error');
			})
			.catch(function(err) {
				unlock();
				breqNotify('บันทึกไม่สำเร็จ', String(err), 'error');
			});
	}

	// action = 'draft' (Save Draft / Update ของ Draft — ไม่บังคับมีรายการ)
	//        | 'update' (Update ของเอกสาร Request — ต้องมีรายการเหมือน Submit)
	function breqSave(action) {
		if (breqSubmitting) return;
		if (action === 'update' && !breqHasItems()) return;
		breqPostAction(action, document.getElementById('btn_breq_save'), 'Saving...');
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

		if (BREQ_MODE === 'new' && typeof Swal !== 'undefined' && typeof Swal.fire === 'function') {
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