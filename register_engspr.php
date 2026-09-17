<?php
require_once __DIR__ . '/includes/so_saved_helpers.php';
require_once __DIR__ . '/includes/spr_repo.php';

/* ===================================================================
 * ด่านตัดสินใจก่อน head.php
 * head.php เริ่มพ่น HTML ทันทีที่ include ทำให้ header() ใช้ไม่ได้อีก
 * ($conn ที่ include ตรงนี้จะถูก head.php include ทับด้วยตัวใหม่อีกที)
 * =================================================================== */
$sprRequestedRefId = isset($_GET['ref_id']) ? trim((string)$_GET['ref_id']) : '';
if ($sprRequestedRefId !== '') {
	include __DIR__ . '/dbconnect.php';
	$sprPreloaded = spr_load_document($conn, $sprRequestedRefId);
	$sprDocumentMissing = ($sprPreloaded === null);
}
?>
<?php include("head.php"); ?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo filemtime(__DIR__ . '/css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-supbrcshos.css?v=<?php echo filemtime(__DIR__ . '/css/register-supbrcshos.css'); ?>">
<link rel="stylesheet" href="css/register-engspr.css?v=<?php echo filemtime(__DIR__ . '/css/register-engspr.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
date_default_timezone_set("Asia/Bangkok");

/* ===================================================================
 * โหมดของหน้า
 *   - ไม่มี ref_id            → สร้างใบใหม่ (เลขที่แสดงเป็นเลขคาดการณ์ จองจริงตอนบันทึก)
 *   - ref_id ของใบที่ไม่ terminal → เปิดกลับมาแก้ เลขไม่เปลี่ยน
 *   - ref_id ของใบ Approve/ยกเลิก → เปิดดูอย่างเดียว (ล็อกทุกช่อง)
 * =================================================================== */
$sprSavedItems = array();
$sprDocumentLogRows = array();

if ($sprRequestedRefId !== '') {
	if (!empty($sprDocumentMissing)) {
		echo '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red" style="max-width:1096px;margin:24px auto;">'
			. '<p>ไม่พบเอกสารเลขที่ ' . so_saved_h($sprRequestedRefId) . '</p></div>';
		include 'foot.php';
		exit();
	}

	$savedSpr = spr_load_document($conn, $sprRequestedRefId);
	if ($savedSpr === null) {
		echo '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red" style="max-width:1096px;margin:24px auto;">'
			. '<p>ไม่พบเอกสารเลขที่ ' . so_saved_h($sprRequestedRefId) . '</p></div>';
		include 'foot.php';
		exit();
	}
	$sprSavedItems = spr_load_items($conn, $savedSpr['ref_id']);
	$sprDocumentLogRows = spr_load_status_log($conn, $savedSpr['ref_id']);
} else {
	$savedSpr = null;
}

$sprIsEditMode = ($savedSpr !== null);
$sprDisplayRefId = $sprIsEditMode ? $savedSpr['ref_id'] : spr_peek_next_ref_id($conn);
$sprDisplaySprNo = $sprIsEditMode ? $savedSpr['spr_no'] : '(ยังไม่ออกเลข)';

$sprStatusDoc = $sprIsEditMode ? (string)$savedSpr['status_doc'] : 'Draft';
$sprIsTerminal = spr_is_terminal_status($sprStatusDoc);

/* ===================================================================
 * ด่านอนุมัติ — คำนวณจากแถวเอกสารล้วน ๆ ด้วยฟังก์ชันชุดเดียวกับฝั่ง server
 * (includes/spr_repo.php) การซ่อน/แสดงแถบนี้เป็นแค่ UX ไม่ใช่ authorization —
 * register_engspr_action1.php ตรวจสิทธิ์ซ้ำทุก action เสมอ
 * =================================================================== */
$sprStage = $sprIsEditMode ? spr_stage_of($savedSpr) : null;
$sprCanShowApproveBar = $sprIsEditMode && spr_user_can_act_on_stage($sprStage, $_SESSION);

/* ยกเลิกเอกสารได้ทุกใบที่ยังไม่ปิด ไม่ใช่เฉพาะใบที่อยู่ในคิวอนุมัติ — ใบ Draft/Returned/
   Rejected ต้องมีทางปิดด้วย ไม่งั้นค้างในระบบตลอดไป (server ตรวจซ้ำที่ spr_user_can_cancel) */
$sprCanCancelDoc = $sprIsEditMode && !$sprIsTerminal && spr_user_can_cancel($savedSpr, $sprStage, $_SESSION);

// เอกสารที่รออนุมัติอยู่ ผู้ยื่นไม่ควร Submit ซ้ำเข้าคิวใหม่ระหว่างที่ยังรออยู่
$sprCanSubmit = !$sprIsTerminal && $sprStage === null;
$sprCanUpdate = !$sprIsTerminal;

$sprTypeCompanyDefault = $sprIsEditMode ? (string)$savedSpr['type_company'] : ((isset($_GET['company']) && $_GET['company'] === '2') ? '2' : '1');

$sprPrefill = $sprIsEditMode ? $savedSpr : null;
$sprField = function ($key, $default = '') use ($sprPrefill) {
	if ($sprPrefill === null) {
		return $default;
	}
	return (string)($sprPrefill[$key] ?? $default);
};

$sprHasPerReturnNo = spr_column_exists($conn, 'hos__spr', 'per_return_no');
$sprHasDamageDetail = spr_column_exists($conn, 'hos__spr', 'damage_detail');
$sprHasNote = spr_column_exists($conn, 'hos__spr', 'note');
$sprHasWarehouseAction = spr_column_exists($conn, 'hos__spr', 'warehouse_action');
$sprHasWarehouseNote = spr_column_exists($conn, 'hos__spr', 'warehouse_note');
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

<form action="register_engspr1.php" method="post" name="frmMain" id="frmMain" onSubmit="JavaScript:return fncSubmit();">
	<!-- ธงบอก register_engspr1.php ให้ใช้เส้นทางบันทึกแบบใหม่ (dynamic rows + transaction) -->
	<input type="hidden" name="spr_mode" value="v2">
	<input type="hidden" name="submit" id="spr_submit_action" value="">
	<input type="hidden" name="ref_id" id="ref_id" value="<?php echo $sprIsEditMode ? so_saved_h($savedSpr['ref_id']) : ''; ?>">
	<?php if (!$sprIsEditMode) { ?>
		<input type="hidden" name="ref_id_preview" id="ref_id_preview" value="<?php echo so_saved_h($sprDisplayRefId); ?>">
	<?php } ?>

	<div class="w3-container spr-layout">

		<div class="so-header-container">
			<div class="so-header-left">
				<h1 class="so-title spr-title">ใบเบิกเครื่องและอะไหล่ (SPR)</h1>
				<div class="so-ref-info">
					<span class="so-ref-label">เลขที่อ้างอิง</span>
					<span class="so-ref-value"><?php echo so_saved_h($sprDisplayRefId); ?></span>
					<span class="so-ref-label">SPR</span>
					<span class="so-ref-value"><?php echo so_saved_h($sprDisplaySprNo); ?></span>
				</div>
			</div>
			<div class="so-header-right">
				<button type="button" class="btn-so-secondary" onclick="sprOpenClearLoanModal();">
					<i class="fas fa-link" aria-hidden="true"></i> เคลียร์ยืม
				</button>
				<button type="button" class="btn-preview-so" onclick="sprOpenPreview();">
					<img src="img/icons/preview.png" alt="preview" style="width:16px;height:16px;"> Preview
				</button>
			</div>
		</div>

		<?php
		/* เหตุผลล่าสุดจาก tb_document_status_log (แถวแรก = ใหม่สุด) — ถ้ายังไม่มี log
		   ให้ fallback ไปที่ reject_remark ของใบที่ถูกไม่อนุมัติจากหน้าเก่า */
		$sprLatestReason = $sprDocumentLogRows[0] ?? null;
		$sprLatestReasonStatus = trim((string)($sprLatestReason['status_doc'] ?? ''));
		$sprLatestReasonText = trim((string)($sprLatestReason['reason'] ?? ''));
		if ($sprLatestReasonText === '' && $sprIsEditMode && $sprStatusDoc === 'Rejected') {
			$sprLatestReasonStatus = 'Rejected';
			$sprLatestReasonText = trim((string)$savedSpr['reject_remark']);
		}
		$sprLatestReasonTitle = spr_document_return_reason_title($sprLatestReasonStatus);
		$sprLatestReasonClass = spr_document_return_status_class($sprLatestReasonStatus);
		?>
		<?php if ($sprLatestReasonTitle !== '' && $sprLatestReasonText !== '') { ?>
			<div class="so-latest-reason-banner <?php echo so_saved_h($sprLatestReasonClass); ?>" role="status" style="margin-bottom:16px;">
				<button type="button" class="so-latest-reason-close" aria-label="ปิด" onclick="this.closest('.so-latest-reason-banner').style.display='none';">&times;</button>
				<div class="so-latest-reason-title"><?php echo so_saved_h($sprLatestReasonTitle); ?></div>
				<div class="so-latest-reason-text"><?php echo nl2br(so_saved_h($sprLatestReasonText)); ?></div>
			</div>
		<?php } ?>

		<!-- ===================== การ์ด: ข้อมูลเอกสาร ===================== -->
		<div class="so-card spr-document-card">
			<div class="spr-company-select-row">
				<div class="so-field-group">
					<label class="so-label" for="type_company_select">บริษัท <span class="required">*</span></label>
					<div class="so-select-wrapper">
						<select name="type_company" id="type_company_select" class="so-select" <?php echo $sprIsTerminal ? 'disabled' : ''; ?>>
							<option value="1" <?php echo $sprTypeCompanyDefault === '1' ? 'selected' : ''; ?>>AWL</option>
							<option value="2" <?php echo $sprTypeCompanyDefault === '2' ? 'selected' : ''; ?>>NBM</option>
						</select>
					</div>
				</div>
			</div>

			<div class="so-section-title-container">
				<h2 class="so-section-title">ข้อมูลเอกสาร</h2>
				<hr class="so-divider">
			</div>

			<div class="spr-document-grid">
				<div class="so-field-group">
					<label class="so-label" for="wo_no">เลขที่ใบงานบริการ <span class="required">*</span></label>
					<input type="text" name="wo_no" id="wo_no" class="so-input" value="<?php echo so_saved_h($sprField('wo_no')); ?>" placeholder="กรอกเลขที่ใบงานบริการ">
				</div>
				<div class="so-field-group">
					<label class="so-label" for="customer">ชื่อในการรับประกัน <span class="required">*</span></label>
					<div class="so-input-wrapper">
						<input type="text" name="customer" id="customer" class="so-input" value="<?php echo so_saved_h($sprField('customer')); ?>" placeholder="กรอกชื่อในการรับประกัน">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('customer').value='';" aria-label="ล้างค่า"></button>
					</div>
				</div>
				<div class="so-field-group spr-document-address">
					<label class="so-label" for="address">ที่อยู่</label>
					<div class="so-input-wrapper">
						<input type="text" name="address" id="address" class="so-input" value="<?php echo so_saved_h($sprField('address')); ?>" placeholder="กรอกที่อยู่">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('address').value='';" aria-label="ล้างค่า"></button>
					</div>
				</div>
			</div>
			<input type="hidden" name="spr_date" id="spr_date" value="<?php echo so_saved_h($sprIsEditMode ? so_saved_iso_date_input($sprField('spr_date')) : date('Y-m-d')); ?>">
			<input type="hidden" name="engineer" id="engineer" value="<?php echo so_saved_h($sprField('engineer', trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')))); ?>">
			<input type="hidden" name="sale_code" id="sale_code" value="<?php echo so_saved_h($sprIsEditMode ? $sprField('sale_code') : ($_SESSION['code'] ?? '')); ?>">
		</div>

		<!-- ===================== การ์ด: ข้อมูลสินค้า ===================== -->
		<div class="so-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">ข้อมูลสินค้า</h2>
				<hr class="so-divider">
			</div>

			<div class="so-grid-2">
				<div class="so-field-group">
					<label class="so-label" for="equipment">ชื่อสินค้า</label>
					<div class="so-input-wrapper">
						<input type="text" name="equipment" id="equipment" class="so-input" value="<?php echo so_saved_h($sprField('equipment')); ?>" placeholder="กรอกชื่อสินค้า">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('equipment').value='';" aria-label="ล้างค่า"></button>
					</div>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="sn_num">หมายเลข SN</label>
					<div class="so-input-wrapper">
						<input type="text" name="sn_num" id="sn_num" class="so-input" value="<?php echo so_saved_h($sprField('sn_num')); ?>" placeholder="กรอกหมายเลข SN">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('sn_num').value='';" aria-label="ล้างค่า"></button>
					</div>
				</div>
			</div>
			<input type="hidden" name="sn_ckk" id="sn_ckk" value="<?php echo $sprField('sn_ckk') === '1' ? '1' : '0'; ?>">

			<div class="so-grid-3">
				<div class="so-field-group">
					<label class="so-label" for="date_receive">วันที่ของเข้า <span class="required">*</span></label>
					<input type="date" name="date_receive" id="date_receive" class="so-input" value="<?php echo so_saved_h(so_saved_iso_date_input($sprField('date_receive'))); ?>" required>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="date_imstall">วันที่ติดตั้ง <span class="required">*</span></label>
					<input type="date" name="date_imstall" id="date_imstall" class="so-input" value="<?php echo so_saved_h(so_saved_iso_date_input($sprField('date_imstall'))); ?>">
				</div>
				<div class="so-field-group">
					<label class="so-label" for="date_exp">วันที่หมดประกัน <span class="required">*</span></label>
					<input type="date" name="date_exp" id="date_exp" class="so-input" value="<?php echo so_saved_h(so_saved_iso_date_input($sprField('date_exp'))); ?>">
				</div>
			</div>

			<div class="spr-return-grid">
				<div class="so-field-group">
					<label class="so-label" for="pro_ckk_select">คืนอะไหล่ <span class="required">*</span></label>
					<div class="so-select-wrapper">
						<select name="pro_ckk" id="pro_ckk_select" class="so-select">
							<option value="3" <?php echo $sprField('pro_ckk', '3') === '3' ? 'selected' : ''; ?>>ไม่มีอะไหล่คืน</option>
							<option value="1" <?php echo $sprField('pro_ckk') === '1' ? 'selected' : ''; ?>>อะไหล่คืนใช้งานไม่ได้</option>
							<option value="2" <?php echo $sprField('pro_ckk') === '2' ? 'selected' : ''; ?>>อะไหล่คืนใช้งานได้ แต่สภาพไม่สมบูรณ์ (โปรดกรอกรายละเอียด)</option>
						</select>
					</div>
				</div>
				<?php if (!$sprIsEditMode || $sprHasDamageDetail) { ?>
				<div class="so-field-group">
					<label class="so-label" for="damage_detail">รายละเอียดอะไหล่คืน</label>
					<div class="so-input-wrapper">
						<input type="text" name="damage_detail" id="damage_detail" class="so-input" value="<?php echo so_saved_h($sprHasDamageDetail ? $sprField('damage_detail') : ''); ?>" placeholder="กรอกรายละเอียดอะไหล่คืน">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('damage_detail').value='';" aria-label="ล้างค่า"></button>
					</div>
				</div>
				<?php } ?>
			</div>

			<div class="so-field-group">
				<label class="so-label" for="pro_des">รายละเอียดการซ่อม</label>
				<div class="so-input-wrapper">
					<input type="text" name="pro_des" id="pro_des" class="so-input" value="<?php echo so_saved_h($sprField('pro_des')); ?>" placeholder="กรอกรายละเอียดการซ่อม">
					<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('pro_des').value='';" aria-label="ล้างค่า"></button>
				</div>
			</div>

			<div class="spr-linked-documents">
				<div class="so-field-group">
					<label class="so-label" for="per_no">ใบแจ้งผลิตภัณฑ์ชำรุดต่างประเทศ (PER)</label>
					<div class="spr-linked-document-control">
						<input type="text" name="per_no" id="per_no" class="so-input spr-linked-document-input" value="<?php echo so_saved_h($sprField('per_no')); ?>" placeholder="เลขที่ PER จะแสดงอัตโนมัติ" readonly onclick="sprOpenLinkedDocument('per_no', 'ใบแจ้งผลิตภัณฑ์ชำรุดต่างประเทศ (PER)');">
						<button type="button" class="spr-linked-document-button" onclick="sprOpenLinkedDocument('per_no', 'ใบแจ้งผลิตภัณฑ์ชำรุดต่างประเทศ (PER)');" aria-label="ดูใบ PER"><i class="far fa-file-alt" aria-hidden="true"></i><i class="fas fa-search" aria-hidden="true"></i></button>
					</div>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="epe_no">ใบส่งออกผลิตภัณฑ์ชำรุดต่างประเทศ (EPE)</label>
					<div class="spr-linked-document-control">
						<input type="text" name="epe_no" id="epe_no" class="so-input spr-linked-document-input" value="<?php echo so_saved_h($sprField('epe_no')); ?>" placeholder="เลขที่ EPE จะแสดงอัตโนมัติ" readonly onclick="sprOpenLinkedDocument('epe_no', 'ใบส่งออกผลิตภัณฑ์ชำรุดต่างประเทศ (EPE)');">
						<button type="button" class="spr-linked-document-button" onclick="sprOpenLinkedDocument('epe_no', 'ใบส่งออกผลิตภัณฑ์ชำรุดต่างประเทศ (EPE)');" aria-label="ดูใบ EPE"><i class="far fa-file-alt" aria-hidden="true"></i><i class="fas fa-search" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
			<?php if (!$sprIsEditMode || $sprHasPerReturnNo) { ?>
				<input type="hidden" name="per_return_no" id="per_return_no" value="<?php echo so_saved_h($sprHasPerReturnNo ? $sprField('per_return_no') : ''); ?>">
			<?php } ?>
		</div>

		<!-- ===================== การ์ด: หมายเหตุ ===================== -->
		<div class="so-card spr-note-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">หมายเหตุ</h2>
				<hr class="so-divider">
			</div>

			<div class="so-field-group spr-note-field">
				<label class="so-label" for="spr_note">หมายเหตุ</label>
				<input type="text" name="note" id="spr_note" class="so-input" value="<?php echo so_saved_h($sprHasNote ? $sprField('note') : ''); ?>" placeholder="ใส่รายละเอียดเพิ่มเติม">
			</div>
			<input type="hidden" name="clear_brn" value="<?php echo $sprField('clear_brn') === '1' ? '1' : '0'; ?>">
			<input type="hidden" name="brn_no" value="<?php echo so_saved_h($sprField('brn_no')); ?>">
			<input type="hidden" name="clear_brnp" value="<?php echo $sprField('clear_brnp') === '1' ? '1' : '0'; ?>">
			<input type="hidden" name="brnp_no" value="<?php echo so_saved_h($sprField('brnp_no')); ?>">
			<input type="hidden" name="clear_epe" value="<?php echo $sprField('clear_epe') === '1' ? '1' : '0'; ?>">
		</div>

		<!-- ===================== การ์ด: รายการสินค้า ===================== -->
		<div class="so-card spr-items-card">
			<div class="so-section-title-container spr-items-title-row">
				<h2 class="so-section-title">รายการสินค้า</h2>
				<span class="spr-items-title-count" id="spr_item_count">0 รายการ</span>
				<hr class="so-divider">
			</div>

			<?php include __DIR__ . '/partials/spr_item_table.php'; ?>
		</div>

		<!-- ===================== การ์ด: สำหรับคลังสินค้า ===================== -->
		<div class="so-card spr-warehouse-card">
			<div class="so-section-title-container">
				<h2 class="so-section-title">สำหรับคลังสินค้า</h2>
				<hr class="so-divider">
			</div>

			<div class="spr-warehouse-grid">
				<div class="so-field-group">
					<label class="so-label" for="warehouse_action">สาเหตุการชำรุด <span class="required">*</span></label>
					<div class="so-select-wrapper">
						<select name="warehouse_action" id="warehouse_action" class="so-select">
							<option value="1" <?php echo ($sprHasWarehouseAction ? $sprField('warehouse_action') : '') === '1' ? 'selected' : ''; ?>>เบิกจากคลังสินค้าชำรุด</option>
							<option value="2" <?php echo ($sprHasWarehouseAction ? $sprField('warehouse_action') : '') === '2' ? 'selected' : ''; ?>>เข้า Stock สินค้าชำรุด</option>
							<option value="3" <?php echo ($sprHasWarehouseAction ? $sprField('warehouse_action') : '') === '3' ? 'selected' : ''; ?>>ทำลาย</option>
						</select>
					</div>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="warehouse_note">หมายเหตุ</label>
					<input type="text" name="warehouse_note" id="warehouse_note" class="so-input" value="<?php echo so_saved_h($sprHasWarehouseNote ? $sprField('warehouse_note') : ''); ?>" placeholder="ใส่รายละเอียดเพิ่มเติม">
				</div>
			</div>
		</div>

		<?php
		$sprDocumentLogRowsForTabs = array();
		foreach ($sprDocumentLogRows as $sprDocumentLogRow) {
			$sprDocumentLogRowsForTabs[] = array(
				'status_label' => spr_document_return_status_label($sprDocumentLogRow['status_doc'] ?? ''),
				'status_class' => spr_document_return_status_class($sprDocumentLogRow['status_doc'] ?? ''),
				'reason'       => $sprDocumentLogRow['reason'] ?? '',
				'user_name'    => $sprDocumentLogRow['user_name'] ?? '',
				'created_at'   => spr_format_document_log_datetime($sprDocumentLogRow['created_at'] ?? ''),
			);
		}

		$docTabsCard = array(
			'open_fn' => 'sprOpen3Tab',
			'document_return_log' => array(
				'enabled' => true,
				'rows' => $sprDocumentLogRowsForTabs,
				'empty_text' => 'ยังไม่มีรายการส่งกลับเอกสาร',
			),
		);
		include __DIR__ . '/partials/doc_tabs_card.php';
		?>
	</div>

	<div class="so-sticky-actions">
		<div class="so-sticky-actions-inner">
			<?php if ($sprCanShowApproveBar) { ?>
				<!-- ค่าปุ่มอนุมัติต้องมากับ hidden ไม่ใช่ value ของ <button> เพราะ return/reject/cancel
				     ส่ง form.submit() แบบ programmatic ซึ่งไม่ส่ง name/value ของปุ่มที่กดไปด้วย -->
				<input type="hidden" name="approve_action" id="spr_approve_action" value="">
				<input type="hidden" name="spr_approve_reason" id="spr_approve_reason" value="">
				<input type="hidden" name="cancel_doc" id="spr_cancel_doc" value="">
				<div class="so-approve-actions">
					<button type="button" class="so-overflow-menu-trigger" id="btn_spr_approve_overflow" onclick="sprToggleApproveOverflowMenu()">
						<i class="fas fa-ellipsis-v"></i>
					</button>
					<div id="sprApproveOverflowMenu" class="so-overflow-menu">
						<button type="button" onclick="sprRunApproveAction('return')" style="color:#FF830F;"><img src="img/icons/send_back.png" alt="" style="width:20px;height:20px;"> ส่งกลับ</button>
						<button type="button" class="so-menu-danger" onclick="sprRunApproveAction('reject')" style="color:#FF0000;"><img src="img/icons/reject.png" alt="" style="width:20px;height:20px;"> ไม่อนุมัติ</button>
						<button type="button" onclick="sprTriggerCancelDoc()"><img src="img/icons/cancel_document.png" alt="" style="width:20px;height:20px;"> ยกเลิกเอกสาร</button>
					</div>
					<button type="button" class="btn-so-approve" onclick="sprApproveDocument()"><i class="far fa-check-circle"></i> อนุมัติ</button>
					<button type="button" name="save_draft" class="btn-so-draft" onclick="sprSaveDraft();"><i class="far fa-save"></i> Update</button>
				</div>
			<?php } else { ?>
				<input type="hidden" name="approve_action" id="spr_approve_action" value="">
				<input type="hidden" name="spr_approve_reason" id="spr_approve_reason" value="">
				<input type="hidden" name="cancel_doc" id="spr_cancel_doc" value="">
				<?php if ($sprCanSubmit) { ?>
					<button type="submit" name="submit" id="btn_submit_form" value="submit" class="btn-so-submit"><i class="fas fa-paper-plane"></i> Submit</button>
				<?php } ?>
				<?php if ($sprCanUpdate) { ?>
					<button type="button" name="save_draft" class="btn-so-draft" onclick="sprSaveDraft();"><i class="far fa-save"></i> <?php echo $sprIsEditMode ? 'Update' : 'Save Draft'; ?></button>
				<?php } ?>
				<?php if ($sprCanCancelDoc) { ?>
					<button type="button" class="btn-so-cancel-doc" onclick="sprTriggerCancelDoc();"><img src="img/icons/cancel_document.png" alt="" style="width:18px;height:18px;"> ยกเลิกเอกสาร</button>
				<?php } ?>
			<?php } ?>
			<button type="button" class="btn-so-cancel-nav" onclick="window.location.href='status_spr.php';">ย้อนกลับ</button>
		</div>
	</div>
	<?php if ($sprIsTerminal) { ?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var form = document.forms.frmMain;
				if (!form) return;
				Array.prototype.forEach.call(form.querySelectorAll('input, select, textarea, button'), function(el) {
					if (el.type === 'hidden') return;
					if (el.classList.contains('btn-so-cancel-nav')) return;
					if (el.classList.contains('btn-preview-so')) return;
					if (el.classList.contains('spr-linked-document-input')) return;
					if (el.classList.contains('spr-linked-document-button')) return;
					el.disabled = true;
				});
			});
		</script>
	<?php } ?>
</form>

<?php include __DIR__ . '/partials/spr_clear_loan_modal.php'; ?>

<script language="JavaScript">
	var sprSubmitting = false; // กันกดซ้ำระหว่างรอบันทึก
	var sprIsTerminal = <?php echo $sprIsTerminal ? 'true' : 'false'; ?>;
	var sprSavedRefId = <?php echo json_encode($sprIsEditMode ? (string)$savedSpr['ref_id'] : '', JSON_UNESCAPED_UNICODE); ?>;

	function sprFocusField(field) {
		if (!field) return;
		if (typeof field.focus === 'function') field.focus();
		if (typeof field.scrollIntoView === 'function') field.scrollIntoView({ behavior: 'smooth', block: 'center' });
	}

	function sprValidationFail(message, field) {
		sprNotify('ข้อมูลไม่ครบถ้วน', message, 'warning');
		sprFocusField(field);
		return false;
	}

	/* ===================== แถบอนุมัติ Sup/CM ===================== */
	function sprToggleApproveOverflowMenu() {
		var menu = document.getElementById('sprApproveOverflowMenu');
		if (!menu) return;
		menu.style.display = (menu.style.display === 'none' || !menu.style.display) ? 'block' : 'none';
	}

	document.addEventListener('click', function(e) {
		var menu = document.getElementById('sprApproveOverflowMenu');
		var trigger = document.getElementById('btn_spr_approve_overflow');
		if (!menu || menu.style.display === 'none' || !menu.style.display) return;
		if (e.target === trigger || (trigger && trigger.contains(e.target))) return;
		if (!menu.contains(e.target)) menu.style.display = 'none';
	});

	/* ส่งฟอร์มไป register_engspr_action1.php แทน register_engspr1.php ตามปกติ
	   endpoint นั้นอ่านแค่ ref_id/approve_action/spr_approve_reason/cancel_doc
	   ไม่บันทึกค่าฟอร์มใด ๆ จึงไม่ต้องผ่าน validation ของฟอร์ม */
	function sprSubmitApproveAction() {
		var form = document.forms.frmMain;
		if (!form) return;
		form.action = 'register_engspr_action1.php';
		HTMLFormElement.prototype.submit.call(form);
	}

	// เปิด popup ให้กรอกเหตุผล (ส่งกลับ/ไม่อนุมัติ/ยกเลิก) — ห้าม submit ถ้าเหตุผลว่าง
	function sprOpenReasonPopup(opts) {
		var refInput = document.getElementById('ref_id');
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

	/* ส่งกลับ / ไม่อนุมัติ — บังคับกรอกเหตุผล แล้วข้าม validation ของฟอร์มไปเลย */
	function sprRunApproveAction(action) {
		var reasonConfig = {
			'return': {
				title: 'ส่งกลับเอกสารนี้ ?',
				subtitleText: 'ส่งกลับเอกสารเลขที่',
				label: 'ระบุเหตุผลการส่งกลับ',
				placeholder: 'ระบุเหตุผลการส่งกลับ',
				iconBg: '#FFF4E5',
				iconSrc: 'img/icons/send_back.png'
			},
			'reject': {
				title: 'ไม่อนุมัติเอกสารนี้ ?',
				subtitleText: 'ไม่อนุมัติเอกสารเลขที่',
				label: 'ระบุเหตุผลที่ไม่อนุมัติ',
				placeholder: 'ระบุเหตุผลที่ไม่อนุมัติ',
				iconBg: '#FEECEB',
				iconSrc: 'img/icons/reject.png'
			}
		}[action];
		if (!reasonConfig) return;

		sprOpenReasonPopup(Object.assign({}, reasonConfig, {
			onConfirm: function(reason) {
				if (sprSubmitting) return;
				sprSubmitting = true;
				document.getElementById('spr_approve_action').value = action;
				document.getElementById('spr_approve_reason').value = reason;
				document.getElementById('spr_cancel_doc').value = '';
				sprSubmitApproveAction();
			}
		}));
	}

	// ยกเลิกเอกสาร — ผู้อนุมัติของด่านปัจจุบันเท่านั้น (server ตรวจซ้ำ)
	function sprTriggerCancelDoc() {
		sprOpenReasonPopup({
			title: 'ยกเลิกเอกสารนี้ ?',
			subtitleText: 'ต้องการยกเลิกเอกสารเลขที่',
			label: 'ระบุเหตุผลในการยกเลิก',
			placeholder: 'ระบุเหตุผลในการยกเลิก',
			iconBg: '#F4F5F7',
			iconSrc: 'img/icons/cancel_document.png',
			onConfirm: function(reason) {
				if (sprSubmitting) return;
				sprSubmitting = true;
				document.getElementById('spr_cancel_doc').value = '1';
				document.getElementById('spr_approve_reason').value = reason;
				document.getElementById('spr_approve_action').value = '';
				sprSubmitApproveAction();
			}
		});
	}

	/* อนุมัติ — ต่างจากอีก 3 action ตรงที่ต้องผ่าน validation ฟอร์มตามปกติ
	   (ข้อกำหนดของ handoff: approve ยังต้อง validate, return/reject/cancel ข้ามได้) */
	function sprApproveDocument() {
		if (sprSubmitting) return;
		if (!sprValidateForm()) return;

		sprSubmitting = true;
		document.getElementById('spr_approve_action').value = 'approve';
		document.getElementById('spr_approve_reason').value = '';
		document.getElementById('spr_cancel_doc').value = '';
		sprSubmitApproveAction();
	}

	/* สลับแท็บของ partials/doc_tabs_card.php */
	function sprOpen3Tab(tabId, element) {
		var contents = document.getElementsByClassName('so-3tab-content');
		for (var i = 0; i < contents.length; i++) contents[i].style.display = 'none';
		var btns = element.parentElement.getElementsByClassName('so-tab-btn');
		for (var i = 0; i < btns.length; i++) btns[i].classList.remove('active');
		document.getElementById(tabId).style.display = 'block';
		element.classList.add('active');
	}

	function sprOpenLinkedDocument(fieldId, title) {
		var field = document.getElementById(fieldId);
		var documentNo = field ? field.value.trim() : '';

		if (!documentNo) {
			sprNotify('ยังไม่มีเลขที่เอกสาร', 'ระบบจะแสดงเลขที่อัตโนมัติเมื่อออกเอกสารแล้ว', 'info');
			return;
		}

		if (typeof Swal === 'undefined') {
			alert(title + '\n' + documentNo);
			return;
		}

		Swal.fire({
			title: title,
			text: documentNo,
			icon: 'info',
			confirmButtonColor: '#612989',
			confirmButtonText: 'ปิด'
		});
	}

	/* ต้องตรงกับ spr_validate() ฝั่ง server (includes/spr_repo.php) — Save Draft ก็ผ่าน
	   ด่านเดียวกันนี้ทุกจุด (ข้อกำหนดข้อ 11 ของ handoff) */
	function sprValidateForm() {
		var form = document.forms.frmMain;
		if (form.wo_no.value.trim() === '') return sprValidationFail('กรุณากรอกเลขที่ใบงานบริการ (W/O No.)', form.wo_no);
		if (form.customer.value.trim() === '') return sprValidationFail('กรุณากรอกชื่อลูกค้า', form.customer);
		if (form.address.value.trim() === '') return sprValidationFail('กรุณากรอกที่อยู่', form.address);
		if (form.equipment.value.trim() === '') return sprValidationFail('กรุณากรอก Equipment', form.equipment);
		if (form.engineer.value.trim() === '') return sprValidationFail('กรุณากรอกชื่อ Engineer', form.engineer);
		if (form.sn_num.value.trim() === '') return sprValidationFail('กรุณากรอก S/N', form.sn_num);
		if (form.date_imstall.value === '') return sprValidationFail('กรุณาระบุวันที่ติดตั้ง', form.date_imstall);
		if (form.date_exp.value === '') return sprValidationFail('กรุณาระบุวันที่หมดประกัน', form.date_exp);
		if (sprTotalRowCount() === 0) return sprValidationFail('กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ', document.getElementById('spr_product_search'));
		return true;
	}

	function fncSubmit() {
		if (sprSubmitting) return false;
		if (!sprValidateForm()) return false;

		sprSubmitting = true;
		var submitBtn = document.getElementById('btn_submit_form');
		if (submitBtn) {
			submitBtn.disabled = true;
			submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...';
		}
		/* ส่งฟอร์มเองแล้วคืน false เสมอ — ปุ่ม Submit มี name="submit" ซ้ำกับ hidden
		   spr_submit_action ถ้าปล่อยให้ browser ส่งเองจะได้ค่า submit มาสองตัว
		   เส้นทางนี้ค่า action มาจาก hidden ตัวเดียวแน่นอน (pattern เดียวกับ register_bregawl.php) */
		document.getElementById('spr_submit_action').value = 'submit';
		HTMLFormElement.prototype.submit.call(document.forms.frmMain);
		return false;
	}

	/* Save Draft / Update — validate เท่ากับ Submit ทุกจุด (ข้อกำหนดข้อ 11) */
	function sprSaveDraft() {
		if (sprSubmitting) return;
		if (!sprValidateForm()) return;

		var form = document.forms['frmMain'];
		if (!form) return;

		var button = form.querySelector('[name="save_draft"]');
		var defaultHtml = button ? button.innerHTML : '';
		var formData = new FormData(form);

		sprSubmitting = true;
		if (button) {
			button.disabled = true;
			button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
		}

		fetch('register_engspr_draft1.php', { method: 'POST', body: formData })
			.then(function(res) { return res.json(); })
			.then(function(data) {
				if (data && data.success) {
					var target = 'register_engspr.php?ref_id=' + encodeURIComponent(data.ref_id) + '&saved=1';
					if (typeof Swal === 'undefined') {
						alert('บันทึกข้อมูลเรียบร้อยแล้ว (เลขที่ ' + data.ref_id + ')');
						window.location.href = target;
						return;
					}
					Swal.fire({
						title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
						text: 'เลขที่อ้างอิง: ' + (data.ref_id || ''),
						icon: 'success',
						confirmButtonColor: '#612989'
					}).then(function() { window.location.href = target; });
					return;
				}

				sprSubmitting = false;
				sprNotify('บันทึกไม่สำเร็จ', (data && data.message) ? data.message : 'เกิดข้อผิดพลาดในการบันทึก', 'error');
			})
			.catch(function(err) {
				sprSubmitting = false;
				sprNotify('บันทึกไม่สำเร็จ', String(err), 'error');
			})
			.finally(function() {
				if (button) {
					button.disabled = false;
					button.innerHTML = defaultHtml;
				}
			});
	}

	/* Preview — POST ค่าปัจจุบันทั้งฟอร์มไป report_spr.php แบบ _report_preview=1
	   ไม่แตะฐานข้อมูลและไม่จองเลข */
	function sprOpenPreview() {
		if (sprIsTerminal) {
			if (!sprSavedRefId) return;
			window.open('report_spr.php?ref_id=' + encodeURIComponent(sprSavedRefId), '_blank', 'noopener,noreferrer');
			return;
		}

		var form = document.forms.frmMain;
		if (!form) return;

		var previewTarget = 'spr_preview_' + Date.now();
		var previewWindow = window.open('', previewTarget);
		if (!previewWindow) {
			sprNotify('เปิด Preview ไม่ได้', 'เบราว์เซอร์บล็อกหน้าต่างใหม่ กรุณาอนุญาต Pop-up แล้วลองอีกครั้ง', 'warning');
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

		form.action = 'report_spr.php';
		form.method = 'post';
		form.target = previewTarget;

		HTMLFormElement.prototype.submit.call(form);

		if (originalAction === null) form.removeAttribute('action');
		else form.setAttribute('action', originalAction);
		if (originalMethod === null) form.removeAttribute('method');
		else form.setAttribute('method', originalMethod);
		if (originalTarget === null) form.removeAttribute('target');
		else form.setAttribute('target', originalTarget);
		previewFlag.remove();
	}
</script>
