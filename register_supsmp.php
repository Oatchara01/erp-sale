<?php
require_once __DIR__ . '/includes/so_saved_helpers.php';
require_once __DIR__ . '/includes/smp_repo.php';

/* ด่านตัดสินใจก่อน head.php (head.php พ่น HTML ทันที header() จึงใช้หลังจากนั้นไม่ได้)
   หน้านี้เป็นศูนย์กลางของใบ: สร้างใหม่ + Draft + Request (ด่าน sup/DM) + Returned + ที่จบแล้ว (Approve/Rejected = ดูอย่างเดียว)
   ส่งไปหน้าแก้ไขเดิมเฉพาะ (ก) สถานะที่หน้านี้ไม่รู้จัก เช่น Pending review หรือ (ข) ใบที่จบแล้วแต่ไม่มีแถว tb_register_data
   (ใบที่สร้างจากฟอร์มเก่าอื่น) ซึ่งหน้านี้แสดงข้อมูลจัดส่งให้ไม่ครบ */
$smpRequestedRef = trim((string)($_GET['ref_idsmp'] ?? ''));
if ($smpRequestedRef !== '') {
	include __DIR__ . '/dbconnect.php';
	$smpPreloaded = smp_load_document($conn, $smpRequestedRef);
	if ($smpPreloaded !== null) {
		$smpPreStatus = (string)$smpPreloaded['status_sup'];
		$smpOpenHere = in_array($smpPreStatus, array('Draft', 'Request', 'Returned'), true)
			|| (smp_is_terminal_status($smpPreStatus) && smp_load_row($conn, 'tb_register_data', 'ref_id', $smpRequestedRef) !== null);
		if (!$smpOpenHere) {
			header('Location: register_supsmp_edit.php?ref_idsmp=' . rawurlencode($smpRequestedRef));
			exit();
		}
	}
}
?>
<?php include('head.php'); ?>
<?php
include('dbconnect_sale.php');
include('dbconnect.php');
date_default_timezone_set('Asia/Bangkok');

/* Duplicate (?copy_from=) — เปิดเป็นใบใหม่ (ออกเลขใหม่ ยังไม่บันทึก) โดยเติมข้อมูลจากใบต้นฉบับ; ?ref_idsmp= มาก่อนเสมอ */
$smpCopyFromRef = $smpRequestedRef === '' ? trim((string)($_GET['copy_from'] ?? '')) : '';
$smpSourceRef = $smpRequestedRef !== '' ? $smpRequestedRef : $smpCopyFromRef;
$smpIsCopy = ($smpCopyFromRef !== '');

$smpDoc = null;
$smpSource = null;
$smpRegister = null;
$smpTransaction = null;
$smpItems = array();
$smpCustomer = null;
if ($smpSourceRef !== '') {
	$smpSource = smp_load_document($conn, $smpSourceRef);
	if ($smpSource === null) {
		echo '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red" style="max-width:1096px;margin:24px auto;"><p>ไม่พบเอกสารเลขที่ ' . so_saved_h($smpSourceRef) . '</p></div>';
		include 'foot.php';
		exit();
	}
	$smpRegister = smp_load_row($conn, 'tb_register_data', 'ref_id', $smpSource['ref_idsmp']);
	$smpTransaction = smp_load_row($conn, 'tb_transaction', 'ref_id', $smpSource['ref_idsmp']);
	$smpItems = smp_load_items($conn, $smpSource['ref_idsmp']);
	if (trim((string)$smpSource['bill_id']) !== '') {
		$custStmt = mysqli_prepare($conn, 'SELECT c.customer_id, c.customer_name, c.bill_name, c.cus_tel, c.bill_tel, c.credit_thb, c.credit_ckk, c.status_cus, c.vip_ckk, t.type_name
			FROM tb_customer c LEFT JOIN tb_typecustomer t ON c.type_customer = t.type_id WHERE c.customer_id = ? LIMIT 1');
		mysqli_stmt_bind_param($custStmt, 's', $smpSource['bill_id']);
		mysqli_stmt_execute($custStmt);
		$smpCustomer = mysqli_fetch_assoc(mysqli_stmt_get_result($custStmt)) ?: null;
		mysqli_stmt_close($custStmt);
	}
	if (!$smpIsCopy) {
		$smpDoc = $smpSource;
	}
}
$smpHasDocument = ($smpDoc !== null);
$smpIsDraft = $smpHasDocument && (string)$smpDoc['status_sup'] === 'Draft';
$smpIsRequest = $smpHasDocument && (string)$smpDoc['status_sup'] === 'Request';
$smpIsReturned = $smpHasDocument && (string)$smpDoc['status_sup'] === 'Returned';
/* แถบอนุมัติ (ส่งกลับ/ไม่อนุมัติ/ยกเลิก/อนุมัติ) — คำนวณจากแถวเอกสาร + ผู้ใช้ด้วยฟังก์ชันชุดเดียวกับฝั่ง server (includes/smp_repo.php)
   การซ่อน/แสดงเป็นแค่ UX ไม่ใช่ authorization — register_supsmp_action1.php ตรวจสิทธิ์ซ้ำทุก action เสมอ */
$smpStage = $smpHasDocument ? smp_stage_of($smpDoc) : null;
$smpCanAct = $smpHasDocument && smp_user_can_act_on_stage($smpDoc, $_SESSION);
$smpIsTerminal = $smpHasDocument && smp_is_terminal_status($smpDoc['status_sup']);
/* แก้ไขได้: ใบใหม่ / Draft-Returned ของเจ้าของ / Request ของผู้อนุมัติด่านปัจจุบัน — นอกนั้นเปิดดูอย่างเดียว (server ตรวจซ้ำที่ smp_persist_from_post) */
$smpReadOnly = $smpHasDocument && !smp_user_can_edit_document($smpDoc, $_SESSION);
/* ปุ่มย้อนกลับ: ผู้อนุมัติกลับคิวของด่านที่ตัวเองทำ นอกนั้นกลับรายการของฝ่ายสนับสนุนเหมือนเดิม */
$smpBackUrl = $smpCanAct ? ($smpStage === 'dm' ? 'status_smpapprove.php' : 'status_sample_approve.php') : 'status_samplesup.php';
/* ปุ่มยกเลิกของเจ้าของใบ Draft/Returned (ใบที่อยู่ในคิวอนุมัติให้ผู้อนุมัติยกเลิกจาก overflow) */
$smpCanCancelOwn = $smpHasDocument && ($smpIsDraft || $smpIsReturned) && smp_user_can_cancel($smpDoc, $_SESSION);

/* ประวัติส่งกลับ/ไม่อนุมัติ/ยกเลิก (tb_document_status_log) — ใช้แสดงแบนเนอร์เหตุผลล่าสุดและแท็บประวัติ */
$smpLogLabels = array('Returned' => 'ส่งกลับ', 'ส่งกลับ' => 'ส่งกลับ', 'Rejected' => 'ไม่อนุมัติ', 'Cancelled' => 'ยกเลิกเอกสาร', 'ยกเลิก' => 'ยกเลิกเอกสาร');
$smpLogClasses = array('Returned' => 'is-returned', 'ส่งกลับ' => 'is-returned', 'Rejected' => 'is-rejected', 'Cancelled' => 'is-cancelled', 'ยกเลิก' => 'is-cancelled');
$smpLogTitles = array('Returned' => 'เหตุผลในการส่งกลับ', 'ส่งกลับ' => 'เหตุผลในการส่งกลับ', 'Rejected' => 'เหตุผลที่ไม่อนุมัติ', 'Cancelled' => 'เหตุผลในการยกเลิก', 'ยกเลิก' => 'เหตุผลในการยกเลิก');
$smpLogRows = array();
if ($smpHasDocument) {
	$logTableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'tb_document_status_log'");
	if ($logTableCheck && mysqli_num_rows($logTableCheck) > 0) {
		$logStmt = mysqli_prepare($conn, "SELECT status_doc, reason, user_name, created_at FROM tb_document_status_log
			WHERE ref_id = ? AND status_doc IN ('Returned','ส่งกลับ','Rejected','Cancelled','ยกเลิก') ORDER BY created_at DESC, id DESC");
		mysqli_stmt_bind_param($logStmt, 's', $smpDoc['ref_idsmp']);
		mysqli_stmt_execute($logStmt);
		$logResult = mysqli_stmt_get_result($logStmt);
		while ($logRow = mysqli_fetch_assoc($logResult)) {
			$smpLogRows[] = $logRow;
		}
		mysqli_stmt_close($logStmt);
	}
}
$smpLatestLog = $smpLogRows[0] ?? null;
$smpLatestLogStatus = trim((string)($smpLatestLog['status_doc'] ?? ''));
$smpLatestLogReason = trim((string)($smpLatestLog['reason'] ?? ''));
$smpLatestLogTitle = $smpLogTitles[$smpLatestLogStatus] ?? '';
$smpLogRowsForTabs = array();
foreach ($smpLogRows as $logRow) {
	$logTime = strtotime((string)$logRow['created_at']);
	$smpLogRowsForTabs[] = array(
		'status_label' => $smpLogLabels[$logRow['status_doc']] ?? $logRow['status_doc'],
		'status_class' => $smpLogClasses[$logRow['status_doc']] ?? 'is-cancelled',
		'reason'       => $logRow['reason'],
		'user_name'    => $logRow['user_name'],
		'created_at'   => $logTime === false ? '' : date('d-m-Y H:i', $logTime),
	);
}

/* ใบสั่งขายอ้างอิง (หมายเลขคำสั่งซื้อ): Draft ใช้ค่าที่บันทึกไว้ก่อนเสมอ; เอกสารใหม่ค่อย lookup จาก ?ref_id=; เปิดตรงไม่มี ref_id = ว่าง */
$smpSaleRef = '';
$smpOrderId = '';
if ($smpSource !== null) {
	$smpSaleRef = trim((string)$smpSource['ref_idsale']);
	$smpOrderId = trim((string)$smpSource['order_id']);
} elseif (trim((string)($_GET['ref_id'] ?? '')) !== '') {
	$smpRequestedSale = trim((string)$_GET['ref_id']);
	$smpSaleOrder = smp_lookup_sale_order($conn, $smpRequestedSale);
	if ($smpSaleOrder === null) {
		echo '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red" style="max-width:1096px;margin:24px auto;"><p>ไม่พบใบสั่งขายเลขที่อ้างอิง ' . so_saved_h($smpRequestedSale) . ' — กรุณาตรวจสอบลิงก์ หรือเปิดหน้านี้โดยไม่ระบุใบสั่งขาย</p></div>';
		include 'foot.php';
		exit();
	}
	$smpSaleRef = $smpSaleOrder['ref_idsale'];
	$smpOrderId = $smpSaleOrder['order_id'];
}
$referenceId = $smpHasDocument ? $smpDoc['ref_idsmp'] : smp_next_ref_id($conn);

/* ค่าที่เติมกลับเข้าฟอร์มตอนเปิด Draft — key = name ของ input (JS เติมให้ทั้ง text/select/radio/checkbox) */
$blankDate = function ($v) {
	$v = trim((string)$v);
	return ($v === '' || strpos($v, '0000-00-00') === 0) ? '' : substr($v, 0, 10);
};
/* ช่องเวลาเป็น type=time รับเฉพาะ HH:MM — Draft เก่าเก็บเป็น text อิสระ (เช่น "9.30") จึงแปลงถ้าอ่านได้ ไม่งั้นเว้นว่าง */
$smpTimeOf = function ($v) {
	return preg_match('/(?<!\d)([01]?\d|2[0-3])[:.]([0-5]\d)(?!\d)/', (string)$v, $m) ? sprintf('%02d:%s', $m[1], $m[2]) : '';
};
$smpPrefill = array();
if ($smpSource !== null) {
	$smpPrefill = array(
		'type_company'  => (string)$smpSource['type_company'],
		'sale_code'     => (string)$smpSource['sale_code'],
		'smp_date'      => $blankDate($smpSource['smp_date']) ?: date('Y-m-d'), /* ช่องซ่อนอยู่ — ห้ามว่าง ไม่งั้น validate ผ่านไม่ได้ */
		'comment_sale'  => (string)$smpSource['comment_sale'],
		'comment_sup'   => (string)$smpSource['comment_sup'],
		'brnp_ckk'      => (string)$smpSource['brnp_ckk'],
		'brnp_no'       => (string)$smpSource['brnp_no'],
		'crm_ckk'       => (string)$smpSource['crm_ckk'] === '1' ? '1' : '0',
		'crm_ref'       => (string)$smpSource['crm_ref'],
		'customer_id'   => (string)$smpSource['bill_id'],
		'customer_name' => (string)$smpSource['customer_name'],
		'cus_tel'       => (string)$smpSource['customer_tel'],
		'address_name'  => (string)$smpSource['address_name'],
		'cus_province'  => (string)($smpSource['customer_province'] ?? ''),
		'cus_ampher'    => (string)($smpSource['customer_ampher'] ?? ''),
		'cus_postcode'  => (string)($smpSource['customer_postcode'] ?? ''),
		'delivery_type' => (string)$smpSource['delivery_type'],
		'start_date'    => $blankDate($smpSource['delivery_date']),
		'between_date'  => (string)$smpSource['date_send_key'],
		'shipping_date' => $blankDate($smpSource['date_ker']),
		'shipping_cost' => ((float)$smpSource['ker_bath'] > 0) ? (string)$smpSource['ker_bath'] : '',
		'shipping_ref1' => (string)$smpSource['ref_no'],
		'shipping_ref2' => (string)$smpSource['ref_no1'],
	);
	if ($smpIsCopy) {
		/* ใบใหม่: วันที่เป็นวันนี้ และไม่พาความเห็นหัวหน้า/ข้อมูลการส่งของใบเดิมมาด้วย (เหมือน register_supsmp_createnew.php เดิม) */
		$smpPrefill['smp_date'] = date('Y-m-d');
		$smpPrefill['comment_sup'] = '';
		$smpPrefill['shipping_date'] = '';
		$smpPrefill['shipping_cost'] = '';
		$smpPrefill['shipping_ref1'] = '';
		$smpPrefill['shipping_ref2'] = '';
	}
}
if ($smpRegister !== null) {
	$smpPrefill += array(
		'start_time'        => $smpTimeOf($smpRegister['start_time']),
		'end_time'          => $smpTimeOf($smpRegister['end_time']),
		'status'            => (string)$smpRegister['status'],
		'fix_datetime'      => (string)$smpRegister['fix_date'],
		'on_time'           => (string)$smpRegister['on_time'],
		'call_customer'     => (string)$smpRegister['call_customer'],
		'call_back'         => (string)$smpRegister['call_employee'],
		'no_money'          => (string)$smpRegister['no_price'],
		'want_bus'          => (string)$smpRegister['want_bus'],
		'status_comment'    => (string)$smpRegister['status_comment'],
		'customer_name1'    => (string)$smpRegister['customer_name'],
		'customer_tel'      => (string)$smpRegister['customer_tel'],
		/* ช่องที่อยู่ส่งสินค้ามีช่องเดียว (hidden address_1/address_name1 ถูก JS copy ให้) — Draft เก่าที่สองค่าไม่ตรงกันใช้ address_name ก่อน ไม่งั้นถอยไป address_1 */
		'address_merged_ui' => trim((string)$smpRegister['address_name']) !== '' ? (string)$smpRegister['address_name'] : (string)$smpRegister['address_1'],
		'address_send'      => (string)$smpRegister['address_send'],
		'province_name'     => (string)$smpRegister['province_name'],
		'location_link'     => (string)$smpRegister['location_link'],
		'transport_company' => (string)$smpRegister['transport_company'],
		'customer_typename' => (string)$smpRegister['type_customer'],
		'employee_tel'      => (string)$smpRegister['employee_tel'],
	);
}
if ($smpTransaction !== null) {
	$split = function ($v) {
		$parts = array_map('trim', explode(' x ', (string)$v));
		return array_pad($parts, 3, '');
	};
	$stairs = $split($smpTransaction['bundai_big']);
	$elevDoor = $split($smpTransaction['lip_big']);
	$elevRoom = $split($smpTransaction['lip_long']);
	$smpPrefill += array(
		'park_front'       => (string)$smpTransaction['car_home'] === '1' ? '1' : '0',
		'park_location'    => (string)$smpTransaction['car_park'],
		'is_high_roof'     => (string)$smpTransaction['height_ltd'],
		'entrance_type'    => (string)$smpTransaction['bundai'] === '1' ? '2' : '1',
		'stair_count'      => (string)$smpTransaction['unit_bundai'],
		'install_floor'    => (string)$smpTransaction['install'],
		'room_type'        => (string)$smpTransaction['install_room'] !== '' ? (string)$smpTransaction['install_room'] : '1',
		'door_width'       => (string)$smpTransaction['room_bigger'],
		'door_height'      => (string)$smpTransaction['room_longer'],
		'stair_width'      => $stairs[0],
		'stair_height'     => $stairs[1],
		'elev_door_width'  => $elevDoor[0],
		'elev_door_height' => $elevDoor[1],
		'elev_width'       => $elevRoom[0],
		'elev_height'      => $elevRoom[1],
		'elev_depth'       => $elevRoom[2],
		'elev_capacity'    => (string)$smpTransaction['lip_weight'],
		'move_furn'        => (string)$smpTransaction['want_employee'] === '1' ? '1' : '0',
		'move_furn_count'  => (string)$smpTransaction['employee_unit'],
		'move_furn_detail' => (string)$smpTransaction['ferniger_name'],
		'addr_note'        => (string)$smpTransaction['description'],
	);
}

$smpSavedItems = array();
foreach ($smpItems as $row) {
	$smpSavedItems[] = array(
		'product_id'   => (string)$row['product_id'],
		'access_code'  => (string)$row['access_code'],
		'product_name' => (string)$row['sol_name'],
		'unit_name'    => (string)$row['unit_name'],
		'sale_count'   => (string)(float)$row['sale_count'],
		'unit_price'   => (string)$row['unit_price'],
		'waranty'      => (string)$row['waranty'],
		'sn'           => (string)$row['sn'],
		'sale_remark'  => (string)$row['sale_remark'],
		/* ใบที่ duplicate ไม่พาการเคลียร์ยืมเดิมมา — BR เดิมถูกเคลียร์ด้วยใบต้นฉบับไปแล้ว */
		'br_no'        => $smpIsCopy ? '' : (string)$row['br_no'],
		'clear_br'     => $smpIsCopy ? '0' : (string)$row['clear_br'],
	);
}
$smpSavedFiles = array();
if ($smpDoc !== null) {
	for ($i = 1; $i <= 3; $i++) {
		$smpSavedFiles[$i] = trim((string)$smpDoc['up_img' . $i]);
	}
}

$teamTable = 'tb_team_adm';
$teamWhere = '';
switch ($_SESSION['code'] ?? '') {
	case 'SS1': $teamTable = 'tb_team_ss1'; break;
	case 'SS2': $teamTable = 'tb_team_ss2'; break;
	case 'SS3': $teamTable = 'tb_team_ss3'; break;
	case 'SS5': $teamTable = 'tb_team_ss3'; $teamWhere = " WHERE sale_code IN ('S31','S32')"; break;
	case 'SUP_MK': $teamTable = 'tb_team_allwell'; break;
	case 'SUP_EN': $teamTable = 'tb_team_en'; break;
}
$saleOptions = array();
if (($_SESSION['code'] ?? '') === 'HR') {
	$saleOptions[] = array('sale_code' => 'HR', 'sale_name' => 'HR');
} else {
	$q = mysqli_query($com, "SELECT sale_code, sale_name FROM {$teamTable}{$teamWhere} ORDER BY sale_code ASC");
	if ($q) while ($row = mysqli_fetch_assoc($q)) $saleOptions[] = $row;
}
$provinces = array();
$q = mysqli_query($conn, 'SELECT province_name FROM tb_province ORDER BY province_ID');
if ($q) while ($row = mysqli_fetch_assoc($q)) $provinces[] = $row['province_name'];

$isEngineer = ($_SESSION['department'] ?? '') === 'วิศวกรรม';
$department = $isEngineer ? 'ฝ่ายวิศวกรรม' : 'ฝ่ายขาย';
$workType = $isEngineer ? 'วิศวกรรม' : 'Sale';
$assetVersion = function ($path) { return filemtime(__DIR__ . '/' . $path); };
?>

<link rel="stylesheet" href="css/so-core.css?v=<?php echo $assetVersion('css/so-core.css'); ?>">
<link rel="stylesheet" href="css/register-suphos.css?v=<?php echo $assetVersion('css/register-suphos.css'); ?>">
<link rel="stylesheet" href="css/register-supbrcshos.css?v=<?php echo $assetVersion('css/register-supbrcshos.css'); ?>">
<link rel="stylesheet" href="css/credit-term-modal.css?v=<?php echo $assetVersion('css/credit-term-modal.css'); ?>">
<link rel="stylesheet" href="css/register-supsmp.css?v=<?php echo $assetVersion('css/register-supsmp.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/customer-popup.js?v=<?php echo $assetVersion('js/customer-popup.js'); ?>"></script>
<script src="js/credit-term-modal.js?v=<?php echo $assetVersion('js/credit-term-modal.js'); ?>"></script>

<?php if (($_GET['saved'] ?? '') === '1' || ($_GET['submitted'] ?? '') === '1' || ($_GET['updated'] ?? '') === '1') { ?>
	<script>document.addEventListener('DOMContentLoaded', function () { window.history.replaceState({}, document.title, 'register_supsmp.php?ref_idsmp=<?php echo rawurlencode($referenceId); ?>'); });</script>
<?php } ?>

<form action="<?php echo $smpIsRequest ? 'register_supsmp_update1.php' : 'register_supsmp1.php'; ?>" method="post" name="frmMain" id="smp-form" enctype="multipart/form-data" novalidate>
	<input type="hidden" name="ref_idsmp" id="ref_idsmp" value="<?php echo $smpHasDocument ? so_saved_h($referenceId) : ''; ?>">
	<input type="hidden" name="ref_idsmp_preview" value="<?php echo so_saved_h($referenceId); ?>">
	<input type="hidden" name="add_by" value="<?php echo so_saved_h(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')); ?>">
	<input type="hidden" name="brnp_ckk" id="brnp_ckk" value="0">
	<input type="hidden" name="department_show" value="<?php echo so_saved_h($department); ?>">
	<input type="hidden" name="department_name" value="<?php echo so_saved_h($workType); ?>">

	<div class="smp-layout">
		<div class="so-header-container">
			<div class="so-header-left">
				<div class="so-title-row">
					<button type="button" class="so-back-btn" onclick="goMainSupSmp();" title="ย้อนกลับ" aria-label="ย้อนกลับ">
						<img src="img/icons/chevron_left.svg" alt="">
					</button>
					<h1 class="so-title">สร้างใบเบิกสินค้าเพื่อสนับสนุนการขาย (SMP)</h1>
				</div>
				<div class="so-ref-info">
					<span class="so-ref-label">เลขที่อ้างอิง</span>
					<span class="so-ref-value"><?php echo so_saved_h($referenceId); ?></span>
				</div>
			</div>
			<div class="so-header-right">
				<button type="button" class="btn-so-secondary" onclick="smpOpenClearLoanModal();">เคลียร์ยืม</button>
				<button type="button" class="btn-preview-so" onclick="smpOpenPreview();"><i class="far fa-file-alt"></i> Preview</button>
			</div>
		</div>

		<?php if ($smpHasDocument && $smpLatestLogTitle !== '' && $smpLatestLogReason !== '') { ?>
			<div class="so-latest-reason-banner <?php echo so_saved_h($smpLogClasses[$smpLatestLogStatus] ?? 'is-cancelled'); ?>" role="status">
				<button type="button" class="so-latest-reason-close" aria-label="ปิด" onclick="this.closest('.so-latest-reason-banner').style.display='none';">&times;</button>
				<div class="so-latest-reason-title"><?php echo so_saved_h($smpLatestLogTitle); ?></div>
				<div class="so-latest-reason-text"><?php echo nl2br(so_saved_h($smpLatestLogReason)); ?></div>
			</div>
		<?php } ?>

		<!-- ===================== ข้อมูลเอกสาร ===================== -->
		<div class="so-card smp-doc-card">
			<div class="so-grid-3 smp-doc-top">
				<div class="so-field-group"><label class="so-label" for="type_company">บริษัท<span class="required">*</span></label><div class="so-select-wrapper"><select class="so-select" name="type_company" id="type_company"><option value="1">AWL</option><option value="2">NBM</option></select></div></div>
				<div class="so-field-group"><label class="so-label" for="sale_code">แผนก/เขตการขาย<span class="required">*</span></label><div class="so-select-wrapper"><select class="so-select" name="sale_code" id="sale_code"><option value="">Select</option><?php foreach ($saleOptions as $opt) { ?><option value="<?php echo so_saved_h($opt['sale_code']); ?>"><?php echo so_saved_h($opt['sale_code'] . ' - ' . $opt['sale_name']); ?></option><?php } ?></select></div></div>
			</div>
			<div class="so-section-title-container"><h2 class="so-section-title">ข้อมูลเอกสาร</h2><hr class="so-divider"></div>
			<div class="so-grid-3 smp-align-end">
				<div class="so-field-group"><label class="so-label" for="order_id">หมายเลขคำสั่งซื้อ</label><input class="so-input" type="text" id="order_id" value="<?php echo so_saved_h($smpOrderId); ?>" readonly tabindex="-1" placeholder="-"><input type="hidden" name="ref_idsale" id="ref_idsale" value="<?php echo so_saved_h($smpSaleRef); ?>"></div>
				<div class="so-field-group"><label class="smp-pill-toggle"><input type="checkbox" name="crm_ckk" id="crm_ckk" value="1" aria-controls="crm_ref"><span>แลกสินค้า CRM</span></label></div>
				<div class="so-field-group"><label class="so-label" for="crm_ref">เลขที่อ้างอิง (CRM)<span class="required" id="crm_ref_required" hidden>*</span></label><input class="so-input" type="text" name="crm_ref" id="crm_ref" maxlength="300" placeholder="เลขที่อ้างอิง" autocomplete="off" disabled></div>
			</div>
			<!-- ฟิลด์เดิมที่ไม่แสดงใน UI แต่ยังทำงาน: วันที่เอกสาร (ตรวจเดือนปิดเอกสาร), ความเห็นฝ่ายสนับสนุน, เลขที่ใบยืม (flow เคลียร์ยืม) -->
			<input type="hidden" name="smp_date" id="smp_date" value="<?php echo date('Y-m-d'); ?>">
			<input type="hidden" name="comment_sup" id="comment_sup" value="">
			<input type="hidden" name="brnp_no" id="brnp_no" value="">
		</div>

		<!-- ===================== หมายเหตุ ===================== -->
		<div class="so-card smp-note-card">
			<div class="so-section-title-container"><h2 class="so-section-title">หมายเหตุ</h2><hr class="so-divider"></div>
			<div class="so-field-group"><label class="so-label" for="comment_sale">หมายเหตุ</label><input class="so-input" type="text" name="comment_sale" id="comment_sale" placeholder="ใส่รายละเอียดเพิ่มเติม" autocomplete="off"></div>
		</div>

		<!-- ===================== ข้อมูลลูกค้า ===================== -->
		<div class="so-card">
			<div class="so-section-title-container"><h2 class="so-section-title">ข้อมูลลูกค้า</h2><hr class="so-divider"></div>
			<input type="hidden" name="customer_id" id="customer_id" value="">
			<input type="hidden" name="customer_typename" id="customer_typename" value="">
			<!-- ไม่แสดงช่องเบอร์เจ้าหน้าที่แล้ว แต่คงค่าเดิมของ Draft ไว้ (หน้า edit/approve ยังใช้ tb_register_data.employee_tel) -->
			<input type="hidden" name="employee_tel" id="employee_tel" value="">
			<input type="hidden" id="bill_id" value=""><input type="hidden" id="h_bill_id" value=""><input type="hidden" id="credit_thb" value="">
			<div class="so-customer-top-grid">
				<div class="so-customer-top-left">
					<div class="so-customer-pills-row">
						<button type="button" class="btn-add-customer-pill" onclick="smpOpenCustomerPopup('customer');"><img src="img/icons/add_user.png" alt="add_user" style="width: 23px;"> ข้อมูลลูกค้า</button>
					</div>
					<div class="so-field-group" style="margin-bottom: 0;">
						<label class="so-label" for="customer_name">ชื่อลูกค้า<span class="required">*</span></label>
						<div class="so-input-wrapper"><input type="text" name="customer_name" id="customer_name" class="so-input" placeholder="ระบุชื่อลูกค้า"><button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('customer_name').value='';" aria-label="ล้างค่า"></button></div>
					</div>
				</div>
				<div class="so-customer-top-right">
					<div class="so-field-group" style="height: 100%; margin-bottom: 0;">
						<label class="so-label">ข้อมูลลูกค้า</label>
						<div class="customer-info-display-card">
							<div class="cidc-col">
								<div class="cidc-row"><div class="cidc-label">รหัสลูกค้า</div><div class="cidc-value"><span id="display_customer_id" class="cidc-display-text"></span></div></div>
								<div class="cidc-row"><div class="cidc-label">เบอร์โทรศัพท์</div><div class="cidc-value"><span id="display_customer_tel" class="cidc-display-text"></span></div></div>
								<div class="cidc-row"><div class="cidc-label">สถานะลูกค้า</div><div class="cidc-value"><img src="img/icons/vip.png" class="cidc-status-icon" id="display_vip_icon" alt="VIP" style="display: none;"><span id="display_mode_name" class="cidc-display-text"></span></div></div>
							</div>
							<div class="cidc-col">
								<div class="cidc-row"><div class="cidc-label">ชื่อลูกค้า</div><div class="cidc-value"><span id="display_customer_name" class="cidc-display-text"></span></div></div>
								<div class="cidc-row"><div class="cidc-label">ประเภทลูกค้า</div><div class="cidc-value"><span id="display_customer_typename" class="cidc-display-text"></span></div></div>
								<div class="cidc-row"><div class="cidc-label">เครดิตเทอม</div><div class="cidc-value">
									<button type="button" class="credit-term-trigger is-empty" id="display_credit_thb_trigger" aria-haspopup="dialog" aria-controls="creditTermPopupModal" aria-disabled="true" disabled onclick="if (typeof window.openCreditTermPopup === 'function') window.openCreditTermPopup();">
										<span id="display_credit_thb" class="credit-term-trigger-text"></span><img src="img/icons/edit.png" class="credit-term-trigger-icon" alt="แก้ไข">
									</button>
								</div></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="so-grid-3-custom smp-cust-block">
				<div class="so-field-group"><label class="so-label" for="cus_tel">เบอร์โทรศัพท์<span class="required">*</span></label><div class="so-input-wrapper"><input type="text" name="cus_tel" id="cus_tel" class="so-input" inputmode="tel" placeholder="ใส่เฉพาะตัวเลข"><button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('cus_tel').value='';" aria-label="ล้างค่า"></button></div></div>
				<div class="so-field-group"><label class="so-label" for="address_name">ที่อยู่ลูกค้า<span class="required">*</span></label><div class="so-input-wrapper"><input type="text" name="address_name" id="address_name" class="so-input" placeholder="กรอกที่อยู่ลูกค้า"><button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('address_name').value='';" aria-label="ล้างค่า"></button></div></div>
			</div>
			<div class="so-grid-3 smp-cust-block">
				<div class="so-field-group"><label class="so-label" for="cus_province">จังหวัด<span class="required">*</span></label><div class="so-select-wrapper"><select class="so-select" name="cus_province" id="cus_province"><option value="">Select</option><?php foreach ($provinces as $province) { ?><option value="<?php echo so_saved_h($province); ?>"><?php echo so_saved_h($province); ?></option><?php } ?></select></div></div>
				<div class="so-field-group"><label class="so-label" for="cus_ampher">เขต/อำเภอ<span class="required">*</span></label><div class="so-input-wrapper"><input type="text" name="cus_ampher" id="cus_ampher" class="so-input" maxlength="150" placeholder="ระบุเขต/อำเภอ" autocomplete="off"><button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('cus_ampher').value='';" aria-label="ล้างค่า"></button></div></div>
				<div class="so-field-group"><label class="so-label" for="cus_postcode">รหัสไปรษณีย์<span class="required">*</span></label><div class="so-input-wrapper"><input type="text" name="cus_postcode" id="cus_postcode" class="so-input" inputmode="numeric" maxlength="5" placeholder="รหัสไปรษณีย์ 5 หลัก" autocomplete="off"><button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('cus_postcode').value='';" aria-label="ล้างค่า"></button></div></div>
			</div>
		</div>

		<!-- ===================== รายการสินค้า ===================== -->
		<div class="so-card smp-items-card">
			<div class="so-section-title-container smp-items-title-row"><h2 class="so-section-title">รายการสินค้า</h2><span class="smp-items-count" id="smp_item_count">0 รายการ</span><hr class="so-divider"></div>
			<div class="smp-summary-panel" aria-label="สรุปรายการสินค้า">
				<div class="smp-summary-item"><span class="smp-summary-label">จำนวนรวม(ชิ้น)</span><strong class="smp-summary-value" id="smp_qty_total">0</strong></div>
				<div class="smp-summary-divider" aria-hidden="true"></div>
				<div class="smp-summary-item"><span class="smp-summary-label">ยอดรวม</span><strong class="smp-summary-value" id="smp_grand_total">0.00</strong></div>
			</div>
			<div class="cs-product-toolbar-row">
				<div class="so-field-group cs-product-search-wrap smp-product-search">
					<label class="so-label" for="smp_product_search">ค้นหารายการสินค้า</label>
					<div class="cs-product-search-bar"><i class="fas fa-search" aria-hidden="true"></i><input type="text" id="smp_product_search" placeholder="ค้นหาด้วยรหัส / ชื่อสินค้า" autocomplete="off"></div>
				</div>
				<div class="cs-product-header-row">
					<button type="button" class="cs-delete-selected-btn" id="smp_delete_selected_btn" onclick="smpDeleteSelectedRows();"><i class="far fa-trash-alt"></i> ลบรายการที่เลือก</button>
				</div>
			</div>
			<div class="so-product-table-wrap">
				<table class="so-product-table smp-product-table" id="smp_table">
					<thead><tr><th class="smp-drag-cell" aria-label="จัดเรียงลำดับ"></th><th class="smp-select-cell"><label class="so-row-checkbox-wrap" aria-label="เลือกทุกรายการ"><input type="checkbox" id="smp_select_all" class="so-row-checkbox" onchange="smpToggleAllRows(this);"><span class="so-row-checkbox-dot" aria-hidden="true"></span></label></th><th>รหัสสินค้า</th><th>รายการสินค้า</th><th>จำนวน</th><th>ราคา/หน่วย</th><th>ยอดรวม</th><th>หมายเลข SN</th><th aria-label="จัดการรายการ"></th></tr></thead>
					<tbody id="smp_tbody"></tbody>
				</table>
			</div>
			<div class="breg-empty-state" id="smp_empty_state">ยังไม่มีรายการสินค้า — ค้นหาสินค้าจากช่องด้านบน หรือกด "เคลียร์ยืม" เพื่อนำเข้ารายการจากใบยืม</div>
		</div>

		<!-- ===================== ข้อมูลการจัดส่ง / ค่าจัดส่ง ===================== -->
		<?php
		$deliveryTab = array(
			'open_fn' => 'openDelTab',
			'grid_fields' => array(
				array('type' => 'select', 'span' => 2, 'name' => 'delivery_type', 'label' => 'วิธีการจัดส่ง', 'required' => true, 'options' => smp_delivery_type_options()),
				array('type' => 'select', 'span' => 2, 'name' => 'transport_company', 'label' => 'บริษัทขนส่ง', 'required' => true, 'options' => array(
					// ตัวเลือกจริงสร้างด้วย JS ตามวิธีการจัดส่ง (ดู updateTransportCompanyRequirement ใน js/delivery-transport.js)
					'' => 'เลือกบริษัทขนส่ง',
				)),
				array('type' => 'date', 'span' => 2, 'name' => 'start_date', 'label' => 'วันในการจัดส่ง', 'required' => true),
				array('type' => 'select', 'span' => 1, 'name' => 'time_range_ui', 'label' => 'เลือกช่วงเวลา', 'options' => array('' => 'เลือกช่วงเวลา', 'morning' => 'ช่วงเช้า', 'afternoon' => 'ช่วงบ่าย', 'allday' => 'ทั้งวัน', 'specific' => 'กำหนดเวลา')),
				array('type' => 'time', 'span' => 1, 'name' => 'start_time', 'label' => 'เวลาในการจัดส่ง', 'required' => true),
				array('type' => 'text', 'span' => 4, 'name' => 'between_date', 'label' => 'วันที่ต้องการโดยประมาณ', 'clearable' => true),
				array('type' => 'text', 'span' => 6, 'name' => 'status_comment', 'label' => 'หมายเหตุสถานะเพิ่มเติม', 'clearable' => true),
			),
			'toggle_buttons' => array(
				array('name' => 'call_customer', 'id' => 'call_customer', 'label' => 'ต้องการให้โทรแจ้ง'),
				array('name' => 'no_money', 'id' => 'no_money', 'label' => 'ส่งสินค้าด้วยใบรับสินค้า (ไม่ระบุราคา)'),
			),
			'cost_fields' => array(
				array('type' => 'date', 'name' => 'shipping_date', 'label' => 'วันที่คีย์ค่าส่ง'),
				array('type' => 'text', 'name' => 'shipping_ref1', 'label' => 'รหัสอ้างอิง 1'),
				array('type' => 'text', 'name' => 'shipping_ref2', 'label' => 'รหัสอ้างอิง 2'),
				array('type' => 'text', 'name' => 'shipping_cost', 'label' => 'ค่าจัดส่ง'),
			),
		);
		include __DIR__ . '/partials/delivery_info_tab.php';
		?>
		<!-- ไม่แสดงใน UI แล้ว (หน้าตาตาม Change Order) แต่ต้องยังถูก POST: smp_register_data_from_post() และ Preview (report_sample.php) อ่านค่าเหล่านี้,
		     Draft เดิมที่เคยติ๊กไว้ต้องไม่ถูกรีเซ็ตตอน Save ซ้ำ, และหน้า edit/approve เดิมยังให้ติ๊กต่อได้ — end_time ถูกเติมโดย dropdown เลือกช่วงเวลา -->
		<input type="hidden" name="end_time" id="end_time" value="">
		<input type="hidden" name="status" id="status" value="ส่ง">
		<input type="hidden" name="fix_datetime" id="fix_datetime" value="0">
		<input type="hidden" name="on_time" id="on_time" value="0">
		<input type="hidden" name="call_back" id="call_back" value="0">
		<input type="hidden" name="want_bus" id="want_bus" value="0">

		<!-- ===================== ที่อยู่ / รายละเอียดที่อยู่ ===================== -->
		<div class="so-tabs-container" style="margin-top: 24px;">
			<button type="button" class="so-tab-btn active" onclick="smpOpenAddrTab('smp_addr_main', this)">ที่อยู่</button>
			<button type="button" class="so-tab-btn" onclick="smpOpenAddrTab('smp_addr_detail', this)">รายละเอียดที่อยู่</button>
		</div>
		<div class="so-card" style="padding: clamp(16px, 3vw, 24px);">
			<div id="smp_addr_main" class="smp-addr-tab">
				<div class="so-section-title-container"><h3 class="so-section-title">ที่อยู่จัดส่ง</h3><hr class="so-divider"></div>
				<div class="so-address-actions"><button type="button" class="smp-pill-btn smp-pill-btn--outline" onclick="smpOpenCustomerPopup('address');"><img src="img/icons/database.png" alt="database"> เพิ่มจากฐานลูกค้า</button></div>
				<div class="so-grid-3">
					<div class="so-field-group"><label class="so-label" for="customer_name1">ชื่อผู้ติดต่อ <span class="required">*</span></label><div class="so-input-wrapper"><input class="so-input" name="customer_name1" id="customer_name1" placeholder="ชื่อผู้ติดต่อ"><button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('customer_name1').value='';" aria-label="ล้างค่า"></button></div></div>
					<div class="so-field-group"><label class="so-label" for="customer_tel">เบอร์โทรศัพท์ <span class="required">*</span></label><input class="so-input" name="customer_tel" id="customer_tel" inputmode="tel" placeholder="ใส่เฉพาะตัวเลข"></div>
					<div class="so-field-group"><label class="so-label" for="province_name">จังหวัด <span class="required">*</span></label><div class="so-select-wrapper"><select class="so-select" name="province_name" id="province_name"><option value="">เลือกจังหวัด</option><?php foreach ($provinces as $province) { ?><option value="<?php echo so_saved_h($province); ?>"><?php echo so_saved_h($province); ?></option><?php } ?></select></div></div>
				</div>
				<!-- ช่องที่อยู่ส่งสินค้ามีช่องเดียว (เหมือน Change Order) — hidden address_1 / address_name1 ถูก JS (syncDeliveryAddress) copy ค่าให้ เพราะ backend และหน้า edit ยังอ่านทั้งสองค่า -->
				<div class="so-field-group smp-addr-gap"><label class="so-label" for="address_merged_ui">ที่อยู่ในการส่งสินค้า <span class="required">*</span></label><div class="so-input-wrapper"><input class="so-input" name="address_merged_ui" id="address_merged_ui" placeholder="ที่อยู่ส่งสินค้า" autocomplete="off"><button type="button" class="fas fa-times so-clear-icon" onclick="var i=document.getElementById('address_merged_ui'); i.value=''; i.dispatchEvent(new Event('input', {bubbles: true}));" aria-label="ล้างค่า"></button></div><input type="hidden" name="address_1" id="address_1"><input type="hidden" name="address_name1" id="address_name1"></div>
				<div class="so-grid-2 smp-addr-gap">
					<div class="so-field-group"><label class="so-label" for="address_send">สถานที่ติดตั้งเครื่อง <span class="required">*</span></label><div class="so-input-wrapper"><input class="so-input" name="address_send" id="address_send" placeholder="สถานที่ติดตั้งเครื่อง"><button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('address_send').value='';" aria-label="ล้างค่า"></button></div></div>
					<div class="so-field-group"><label class="so-label" for="location_link">Location Link</label><div class="so-input-wrapper"><input class="so-input" name="location_link" id="location_link" placeholder="วางลิงก์ Google Maps หรือพิกัด"><button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('location_link').value='';" aria-label="ล้างค่า"></button></div></div>
				</div>
			</div>

			<div id="smp_addr_detail" class="smp-addr-tab" style="display:none;">
				<div class="so-section-title-container"><h3 class="so-section-title">รายละเอียดที่อยู่</h3><hr class="so-divider"></div>
				<div class="so-grid-3 smp-align-end">
					<div class="so-field-group"><label class="so-label">จอดรถหน้าบ้าน</label><div class="smp-radio-row"><label><input type="radio" name="park_front" value="1" checked> ได้</label><label><input type="radio" name="park_front" value="0"> ไม่ได้</label></div></div>
					<div class="so-field-group"><label class="so-label" for="park_location">สถานที่จอดรถ</label><input class="so-input" name="park_location" id="park_location" placeholder="สถานที่จอดรถ"></div>
					<div class="so-field-group"><label class="smp-pill-toggle"><input type="checkbox" name="is_high_roof" value="1"><span>รถหลังคาสูงเข้าได้</span></label></div>
				</div>
				<div class="so-grid-3 smp-addr-gap">
					<div class="so-field-group"><label class="so-label">ทางเข้าบ้าน</label><div class="smp-radio-row"><label><input type="radio" name="entrance_type" value="1" checked> ทางราบ</label><label><input type="radio" name="entrance_type" value="2"> บันไดก่อนเข้าบ้าน</label></div></div>
					<div class="so-field-group"><label class="so-label" for="stair_count">จำนวนขั้นบันได</label><input class="so-input" name="stair_count" id="stair_count" inputmode="numeric" placeholder="ใส่เฉพาะตัวเลข"></div>
					<div class="so-field-group"><label class="so-label" for="install_floor">ชั้นที่ติดตั้ง</label><input class="so-input" name="install_floor" id="install_floor" inputmode="numeric" placeholder="ใส่เฉพาะตัวเลข"></div>
				</div>
				<div class="so-grid-3 smp-addr-gap">
					<div class="so-field-group"><label class="so-label">ห้องที่ติดตั้ง</label><div class="smp-radio-row"><label><input type="radio" name="room_type" value="1" checked> ห้องโถง</label><label><input type="radio" name="room_type" value="2"> ห้องนอน</label></div></div>
					<div class="so-field-group"><label class="so-label">ขนาดประตูห้อง</label><div class="smp-pair"><input class="so-input" name="door_width" placeholder="ความกว้าง (ซม.)"><input class="so-input" name="door_height" placeholder="ความสูง (ซม.)"></div></div>
					<div class="so-field-group"><label class="so-label">ขนาดบันได</label><div class="smp-pair"><input class="so-input" name="stair_width" placeholder="ความกว้าง (ซม.)"><input class="so-input" name="stair_height" placeholder="ความสูง (ซม.)"></div></div>
				</div>
				<div class="so-grid-3 smp-addr-gap">
					<div class="so-field-group"><label class="so-label">ประตูลิฟต์</label><div class="smp-pair"><input class="so-input" name="elev_door_width" placeholder="ความกว้าง (ซม.)"><input class="so-input" name="elev_door_height" placeholder="ความสูง (ซม.)"></div></div>
					<div class="so-field-group"><label class="so-label">ขนาดห้องลิฟต์</label><div class="smp-pair"><input class="so-input" name="elev_width" placeholder="ความกว้าง (ซม.)"><input class="so-input" name="elev_height" placeholder="ความสูง (ซม.)"><input class="so-input" name="elev_depth" placeholder="ความลึก (ซม.)"></div></div>
					<div class="so-field-group"><label class="so-label" for="elev_capacity">ขนาดบรรทุกของลิฟต์</label><input class="so-input" name="elev_capacity" id="elev_capacity" placeholder="น้ำหนัก (กก.)"></div>
				</div>
				<div class="so-grid-3 smp-addr-gap">
					<div class="so-field-group"><label class="so-label">การย้ายเฟอร์นิเจอร์</label><div class="smp-radio-row"><label><input type="radio" name="move_furn" value="0" checked> ไม่</label><label><input type="radio" name="move_furn" value="1"> ย้าย</label></div></div>
					<div class="so-field-group"><label class="so-label" for="move_furn_count">จำนวนชิ้นที่ย้าย</label><input class="so-input" name="move_furn_count" id="move_furn_count" inputmode="numeric" placeholder="ใส่เฉพาะตัวเลข"></div>
					<div class="so-field-group"><label class="so-label" for="move_furn_detail">รายละเอียดเฟอร์นิเจอร์</label><input class="so-input" name="move_furn_detail" id="move_furn_detail" placeholder="รายละเอียดเฟอร์นิเจอร์"></div>
				</div>
				<div class="so-field-group smp-addr-gap"><label class="so-label" for="addr_note">หมายเหตุเพิ่มเติม</label><input class="so-input" name="addr_note" id="addr_note" placeholder="รายละเอียดเพิ่มเติม"></div>
			</div>
		</div>

		<!-- ===================== แนบไฟล์ (partial กลางเดียวกับ Change Order — posts เข้า up_img1-3 เดิม) ===================== -->
		<?php
		$docTabsCard = array(
			'open_fn' => 'smpOpenAttachTab',
			'attach_file' => array(
				'enabled' => true,
				'file_prefix' => 'up_img',
				'slots' => 3,
				'first_slot' => 1,
				'base_url' => 'smp_up/',
				'max_bytes' => 1048576,
				'allowed_ext' => 'jpg,jpeg,png,pdf',
				'accept' => '.jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf',
			),
			'document_return_log' => array(
				'enabled' => true,
				'rows' => $smpLogRowsForTabs,
				'empty_text' => 'ยังไม่มีรายการส่งกลับเอกสาร',
			),
		);
		include __DIR__ . '/partials/doc_tabs_card.php';
		?>
		<!-- ไฟล์เดิมของ Draft (ไม่มี name — ให้ JS แสดง "ไฟล์เดิม"); ถังขยะตั้ง remove_up_img{i}=1 ให้ smp_plan_uploads() ลบไฟล์ -->
		<?php for ($i = 1; $i <= 3; $i++) { ?>
			<input type="hidden" id="hidden_slip_val<?php echo $i; ?>" value="<?php echo so_saved_h($smpSavedFiles[$i] ?? ''); ?>">
			<input type="hidden" name="remove_up_img<?php echo $i; ?>" id="hidden_remove_val<?php echo $i; ?>" value="0">
		<?php } ?>
	</div>

	<div class="so-sticky-actions" style="width: 100%; background-color: white; padding: 16px 24px; display: flex; gap: 16px; justify-content: flex-end; box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.05); align-items: center; border-top: 1px solid #EBEBEB; margin-top: 24px; box-sizing: border-box;">
		<div class="so-sticky-actions-inner" style="max-width: 1200px; width: 100%; display: flex; gap: 16px; justify-content: flex-end; margin: 0 auto; padding-right: 24px; align-items: center;">
			<?php if ($smpCanAct || $smpCanCancelOwn) { ?>
			<!-- ค่า action มากับ hidden เพราะ submit เป็น form.submit() แบบ programmatic (ไม่ส่ง name/value ของปุ่ม) -->
			<input type="hidden" name="approve_action" id="smp_approve_action" value="">
			<input type="hidden" name="smp_approve_reason" id="smp_approve_reason" value="">
			<input type="hidden" name="smp_cancel_doc" id="smp_cancel_doc" value="">
			<?php } ?>
			<?php if ($smpCanAct) { ?>
			<div class="so-approve-actions">
				<button type="button" class="so-overflow-menu-trigger" id="smp_btn_approve_overflow" onclick="smpToggleApproveOverflowMenu();" aria-label="เมนูเพิ่มเติม"><i class="fas fa-ellipsis-v"></i></button>
				<div id="smpApproveOverflowMenu" class="so-overflow-menu">
					<button type="button" onclick="smpRunApproveAction('return');" style="color: #FF830F;"><img src="img/icons/send_back.png" alt="" style="width: 20px; height: 20px;"> ส่งกลับ</button>
					<button type="button" class="so-menu-danger" onclick="smpRunApproveAction('reject');" style="color: #FF0000;"><img src="img/icons/reject.png" alt="" style="width: 20px; height: 20px;"> ไม่อนุมัติ</button>
					<button type="button" onclick="smpTriggerCancelDoc();"><img src="img/icons/cancel_document.png" alt="" style="width: 20px; height: 20px;"> ยกเลิกเอกสาร</button>
				</div>
				<button type="button" class="btn-so-approve" id="smp_btn_approve" onclick="smpApproveDocument();"><i class="far fa-check-circle"></i> อนุมัติ</button>
			</div>
			<?php } ?>
			<?php if (!$smpIsRequest && !$smpReadOnly) { ?>
			<button type="submit" name="submit" id="smp_btn_submit" value="submit" style="background-color: #612989; color: #fff; border: 1px solid #612989; border-radius: 24px; padding: 10px 28px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08); height: 40px;">
				<i class="far fa-paper-plane"></i> Submit
			</button>
			<?php } ?>
			<?php if (!$smpReadOnly) { ?>
			<button type="<?php echo $smpIsRequest ? 'submit' : 'button'; ?>" name="save_draft" id="smp_btn_draft" <?php echo $smpIsRequest ? '' : ($smpIsReturned ? 'onclick="smpUpdateReturned();"' : 'onclick="smpSaveDraft();"'); ?> style="background-color: white; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 12px 32px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
				<i class="far fa-save"></i> <?php echo $smpHasDocument ? 'Update' : 'Save Draft'; ?>
			</button>
			<?php } ?>
			<?php if ($smpCanCancelOwn) { ?>
			<button type="button" id="smp_btn_cancel_doc" onclick="smpTriggerCancelDoc();" style="background-color: white; color: #FF0000; border: 1px solid #EBEBEB; border-radius: 24px; padding: 12px 32px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; height: 40px; display: flex; align-items: center; gap: 8px;">
				<img src="img/icons/cancel_document.png" alt="" style="width: 20px; height: 20px;"> ยกเลิกเอกสาร
			</button>
			<?php } ?>
		</div>
	</div>
</form>

<!-- ===================== Modal: ข้อมูลรายการสินค้าเพิ่มเติม ===================== -->
<div id="smp_edit_modal" class="cs-modal-overlay" style="display:none;">
	<div class="cs-modal-card smp-remark-modal-card" role="dialog" aria-modal="true" aria-labelledby="smp_edit_modal_title">
		<div class="cs-modal-header"><h3 class="cs-modal-title" id="smp_edit_modal_title">ข้อมูลรายการสินค้าเพิ่มเติม</h3><button type="button" class="cs-modal-close-btn" onclick="smpCloseEditModal();" aria-label="ปิด">&times;</button></div>
		<div class="cs-modal-body smp-modal-body">
			<div class="smp-modal-fields">
				<div class="so-field-group"><label class="so-label" for="smp_modal_waranty">รับประกัน(ปี)<span class="required">*</span></label><input type="text" id="smp_modal_waranty" class="so-input" placeholder="ใส่จำนวนปีรับประกัน" inputmode="numeric" autocomplete="off"></div>
				<div class="so-field-group"><label class="so-label" for="smp_modal_br_no">เลขที่ใบยืม</label><div class="so-input-wrapper"><input type="text" id="smp_modal_br_no" class="so-input" placeholder="กรอกเลขที่ใบยืม" autocomplete="off"><button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('smp_modal_br_no').value='';" aria-label="ล้างเลขที่ใบยืม"></button></div></div>
				<div class="so-field-group"><label class="so-label" for="smp_modal_remark">หมายเหตุสินค้า</label><div class="so-input-wrapper"><input type="text" id="smp_modal_remark" class="so-input" placeholder="กรอกหมายเหตุสินค้า" autocomplete="off"><button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('smp_modal_remark').value='';" aria-label="ล้างหมายเหตุสินค้า"></button></div></div>
			</div>
		</div>
		<div class="cs-modal-footer"><button type="button" class="cs-modal-btn-update" onclick="smpSaveEditModal();">อัพเดท</button><button type="button" class="cs-modal-btn-cancel" onclick="smpCloseEditModal();">ยกเลิก</button></div>
	</div>
</div>

<!-- ===================== Popup: เคลียร์ยืม (reuse .clear-loan-* ของ register-suphos.css) ===================== -->
<div id="smpClearLoanModal" class="customer-popup-modal" aria-hidden="true" style="display:none;">
	<div class="customer-popup-box clear-loan-popup-box" role="dialog" aria-modal="true" aria-labelledby="smpClearLoanTitle">
		<button type="button" class="customer-popup-close" onclick="smpCloseClearLoanModal()" aria-label="Close">&times;</button>
		<div class="clear-loan-header"><h2 id="smpClearLoanTitle" class="clear-loan-title">เคลียร์ยืม — ค้นหาใบยืมที่ต้องการเคลียร์</h2></div>
		<div class="clear-loan-top-controls"><div class="clear-loan-search-wrap">
			<label class="clear-loan-search-label" for="smpClearLoanSearch">ค้นหาด้วยเลขที่ใบยืม / ชื่อลูกค้า</label>
			<div class="clear-loan-search"><i class="fas fa-search" aria-hidden="true"></i><input type="text" id="smpClearLoanSearch" placeholder="ระบุเลขที่ใบยืมหรือชื่อลูกค้า" autocomplete="off"></div>
		</div></div>
		<div class="clear-loan-table-wrap"><div class="clear-loan-table-container">
			<table class="clear-loan-table">
				<thead><tr><th aria-label="ขยาย"></th><th aria-label="เลือก"></th><th>เลขที่ใบยืม</th><th>วันที่</th><th>ชื่อลูกค้า</th><th>จำนวนรายการ</th></tr></thead>
				<tbody id="smpClearLoanRows"><tr class="clear-loan-state-row"><td colspan="6">พิมพ์คำค้นหาหรือรอผลค้นหาอัตโนมัติ</td></tr></tbody>
			</table>
		</div></div>
		<div class="clear-loan-actions"><div class="clear-loan-action-container">
			<button type="button" class="clear-loan-btn clear-loan-btn-secondary" onclick="smpCloseClearLoanModal()">ยกเลิก</button>
			<button type="button" class="clear-loan-btn clear-loan-btn-primary" id="smpClearLoanImportBtn" disabled onclick="smpImportClearLoanSelection()">นำเข้ารายการที่เลือก</button>
		</div></div>
	</div>
</div>

<!-- ===================== Popup: ข้อมูลลูกค้า / เครดิตเทอม (ใช้ร่วมกับ js/customer-popup.js, js/credit-term-modal.js) ===================== -->
<div id="customerPopupModal" class="customer-popup-modal" aria-hidden="true" style="display: none;">
	<div class="customer-popup-box" role="dialog" aria-modal="true" aria-labelledby="customerPopupTitle">
		<button type="button" class="customer-popup-close" onclick="closeCustomerPopup()" aria-label="Close">&times;</button>
		<div class="customer-popup-header">
			<h2 id="customerPopupTitle">ข้อมูลลูกค้า</h2>
			<div class="customer-popup-toolbar" style="margin-top: 18px;">
				<div class="customer-popup-search-wrap"><label for="customerPopupSearch">ค้นหาลูกค้า</label><div class="customer-popup-search"><i class="fas fa-search" aria-hidden="true"></i><input type="text" id="customerPopupSearch" placeholder="ค้นหาด้วยชื่อ / เบอร์โทร"></div></div>
				<button type="button" class="customer-popup-add" onclick="window.open('customer_add.php', '_blank');"><i class="fas fa-sliders-h" aria-hidden="true"></i> เพิ่มข้อมูลลูกค้า</button>
			</div>
		</div>
		<div class="customer-popup-table-wrap"><table class="customer-popup-table">
			<thead><tr><th scope="col">ชื่อลูกค้า</th><th scope="col">เบอร์โทร</th><th scope="col">ที่อยู่</th><th scope="col" aria-label="เลือก"></th></tr></thead>
			<tbody id="customerPopupRows"><tr><td colspan="4" class="customer-popup-empty">พิมพ์ชื่อหรือเบอร์โทรเพื่อค้นหา</td></tr></tbody>
		</table></div>
		<div class="customer-popup-pagination" id="customerPopupPagination" style="display:none;"><button type="button" class="customer-popup-loadmore" id="customerPopupLoadMore" onclick="loadMoreCustomerPopupRows()">โหลดเพิ่ม</button></div>
		<div class="customer-popup-actions"><button type="button" class="customer-popup-confirm" onclick="confirmCustomerPopupSelection()">ตกลง</button><button type="button" class="customer-popup-cancel" onclick="closeCustomerPopup()">ยกเลิก</button></div>
	</div>
</div>

<div id="creditTermPopupModal" class="customer-popup-modal" aria-hidden="true">
	<div class="customer-popup-box credit-term-popup-box" role="dialog" aria-modal="true" aria-labelledby="creditTermPopupTitle">
		<button type="button" class="customer-popup-close" onclick="closeCreditTermPopup()" aria-label="Close">&times;</button>
		<div class="clear-loan-header"><h2 id="creditTermPopupTitle">เครดิตเทอม</h2></div>
		<div class="credit-term-popup-content">
			<div class="credit-term-summary">
				<div class="credit-term-summary-item"><p class="credit-term-summary-label">เครดิต (วัน)</p><p class="credit-term-summary-value" id="creditTermSummaryDay">-</p></div>
				<div class="credit-term-summary-item"><p class="credit-term-summary-label">เครดิต (ยอดเงิน)</p><p class="credit-term-summary-value" id="creditTermSummaryAmount">0.00</p></div>
				<div class="credit-term-summary-item"><p class="credit-term-summary-label">ยอดรวมหนี้คงค้าง</p><p class="credit-term-summary-value" id="creditTermSummaryOutstanding">0.00</p></div>
				<div class="credit-term-summary-item is-highlight"><p class="credit-term-summary-label">ยอดเครดิตคงเหลือ</p><p class="credit-term-summary-value" id="creditTermSummaryRemaining">0.00</p></div>
			</div>
			<div class="credit-term-table-panel"><div class="credit-term-table-wrap"><table class="credit-term-table">
				<thead><tr><th scope="col" aria-label="เลือก"></th><th scope="col">เลขที่ใบสั่งขาย</th><th scope="col">รายการสินค้า</th><th scope="col">ยอดที่ต้องชำระ</th><th scope="col">ยอดชำระแล้ว</th><th scope="col">ยอดหนี้คงค้าง</th></tr></thead>
				<tbody id="creditTermTableBody"><tr class="credit-term-empty-row"><td><span class="credit-term-caret" aria-hidden="true"></span></td><td colspan="5">เลือกลูกค้าแล้วกดเปิดเครดิตเทอมเพื่อดูข้อมูล</td></tr></tbody>
			</table></div></div>
		</div>
	</div>
</div>

<script>
	window.SMP_PREFILL = <?php echo json_encode($smpPrefill, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP); ?>;
	window.SMP_SAVED_ITEMS = <?php echo json_encode($smpSavedItems, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP); ?>;
	window.SMP_SAVED_CUSTOMER = <?php echo json_encode($smpCustomer, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP); ?>;
	window.SMP_IS_DRAFT = <?php echo $smpIsDraft ? 'true' : 'false'; ?>;
	window.SMP_IS_REQUEST = <?php echo $smpIsRequest ? 'true' : 'false'; ?>;
	window.SMP_IS_RETURNED = <?php echo $smpIsReturned ? 'true' : 'false'; ?>;
	window.SMP_READ_ONLY = <?php echo $smpReadOnly ? 'true' : 'false'; ?>;
</script>
<script src="js/doc-tabs-attach.js?v=<?php echo $assetVersion('js/doc-tabs-attach.js'); ?>"></script>
<script src="js/delivery-transport.js?v=<?php echo $assetVersion('js/delivery-transport.js'); ?>"></script>
<script src="js/register-supsmp.js?v=<?php echo $assetVersion('js/register-supsmp.js'); ?>"></script>
<?php if ($smpReadOnly) { ?>
	<script>
		/* ใบที่จบแล้ว / ไม่ใช่ของผู้ใช้ที่จะแก้ได้ → เปิดดูอย่างเดียว (ล็อกทุกช่อง; ต้องรันหลัง register-supsmp.js สร้างแถวรายการเสร็จ) */
		(function () {
			var form = document.getElementById('smp-form');
			if (!form) return;
			var keepClasses = ['btn-preview-so', 'so-tab-btn', 'so-latest-reason-close', 'so-back-btn'];
			Array.prototype.forEach.call(form.querySelectorAll('input, select, textarea, button'), function (el) {
				if (el.type === 'hidden' || el.name === 'cancel_edit') return;
				for (var i = 0; i < keepClasses.length; i++) { if (el.classList.contains(keepClasses[i])) return; }
				el.disabled = true;
			});
		})();
	</script>
<?php } ?>
<?php
/* ผลของ action จาก register_supsmp_action1.php (PRG) — แสดงครั้งเดียวแล้วล้าง */
if (!empty($_SESSION['smp_flash']) && is_array($_SESSION['smp_flash'])) {
	$smpFlash = $_SESSION['smp_flash'];
	unset($_SESSION['smp_flash']);
	?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			var flash = <?php echo json_encode($smpFlash, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP); ?>;
			if (typeof Swal === 'undefined') { alert(flash.title + '\n' + flash.text); return; }
			var body = document.createElement('div');
			body.style.whiteSpace = 'pre-line';
			body.textContent = flash.text || '';
			Swal.fire({ icon: flash.icon || 'info', title: flash.title || '', html: body, confirmButtonColor: '#612989', confirmButtonText: 'ตกลง' });
		});
	</script>
<?php } ?>
