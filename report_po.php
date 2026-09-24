<?php

/**
 * ใบ PO แบบพิมพ์/Preview
 *   GET  ?ref_id=PO...           → แสดงใบที่บันทึกแล้ว (Draft หรือ Submitted)
 *   POST _report_preview=1       → Preview จากค่าฟอร์มสดของ register_poawl.php
 *
 * หน้านี้อ่านอย่างเดียวเสมอ: ไม่จองเลข ไม่ INSERT/UPDATE ไม่ย้ายไฟล์ที่อัปโหลดมากับฟอร์ม
 * (ไฟล์ temp ของ PHP ถูกลบเองเมื่อจบคำขอ)
 */

require_once __DIR__ . '/includes/so_saved_helpers.php';
require_once __DIR__ . '/includes/po_repo.php';

session_start();
date_default_timezone_set("Asia/Bangkok");

if (!isset($_SESSION['UserID']) || $_SESSION['UserID'] === '') {
	header('Location: index.php');
	exit();
}

include __DIR__ . '/dbconnect.php';
include __DIR__ . '/dbconnect_sale.php';

$isPreview = (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && po_post_value($_POST, '_report_preview') === '1');
$previewError = '';

if ($isPreview) {
	$post = $_POST;
	$typeDoc = po_post_value($post, 'type_doc', '3');
	if (!array_key_exists($typeDoc, po_company_options())) {
		$typeDoc = '3';
	}
	$doc = array(
		'ref_id'      => po_post_value($post, 'ref_id') !== '' ? po_post_value($post, 'ref_id') : po_post_value($post, 'ref_id_preview'),
		'status_doc'  => po_post_value($post, 'ref_id') !== '' ? PO_STATUS_DRAFT : '',
		'type_doc'    => $typeDoc,
		'date_po'     => po_post_value($post, 'date_po'),
		'po_no'       => po_post_value($post, 'po_no'),
		'sale_code'   => po_post_value($post, 'sale_code'),
		'bill_id'     => po_post_value($post, 'bill_id'),
		'bill_name'   => po_post_value($post, 'bill_name'),
		'remark'      => po_post_value($post, 'remark'),
		'description' => po_post_value($post, 'description'),
		'add_by'      => trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')),
		'add_date'    => date('Y-m-d H:i:s'),
	);

	$rows = po_normalize_items(po_collect_items_from_post($post, 'pm_year'), false);
	$items = po_report_attach_products($conn, $rows);

	// ไฟล์: ของเดิมที่ยังไม่ถูกลบ + ชื่อไฟล์ใหม่ที่เลือกไว้ (ยังไม่ถูกบันทึก)
	$existing = array();
	if (po_post_value($post, 'ref_id') !== '') {
		$existing = po_load_document($conn, po_post_value($post, 'ref_id')) ?: array();
	}
	$attachments = array();
	for ($slot = 1; $slot <= PO_MAX_ATTACHMENTS; $slot++) {
		$file = $_FILES['img_po' . $slot] ?? null;
		if ($file && !is_array($file['error']) && (int)$file['error'] === UPLOAD_ERR_OK) {
			$attachments[] = array('name' => basename(str_replace('\\', '/', (string)$file['name'])), 'href' => '', 'is_new' => true);
		} else if (po_post_value($post, 'img_po_remove' . $slot) !== '1' && trim((string)($existing['img_po' . $slot] ?? '')) !== '') {
			$attachments[] = array('name' => (string)$existing['img_po' . $slot], 'href' => 'upload/' . rawurlencode((string)$existing['img_po' . $slot]), 'is_new' => false);
		}
	}
} else {
	$refId = isset($_GET['ref_id']) && !is_array($_GET['ref_id']) ? trim((string)$_GET['ref_id']) : '';
	$doc = $refId !== '' ? po_load_document($conn, $refId) : null;
	if ($doc === null) {
		http_response_code(404);
		echo '<!DOCTYPE html><html lang="th"><meta charset="utf-8"><body style="font-family:sans-serif;padding:24px;">ไม่พบเอกสารเลขที่ ' . so_saved_h($refId) . '</body></html>';
		exit();
	}
	$doc['status_doc'] = po_document_status($doc);
	$items = po_load_items($conn, $doc['ref_id']);
	$attachments = array();
	for ($slot = 1; $slot <= PO_MAX_ATTACHMENTS; $slot++) {
		$name = trim((string)$doc['img_po' . $slot]);
		if ($name !== '') {
			$attachments[] = array('name' => $name, 'href' => 'upload/' . rawurlencode($name), 'is_new' => false);
		}
	}
}

/** เติมรหัส/ชื่อ/หน่วยสินค้าให้แถวของ Preview — ไม่ throw แม้สินค้าไม่ตรงบริษัท (Preview ต้องเปิดได้เสมอ) */
function po_report_attach_products($conn, array $rows)
{
	if (count($rows) === 0) {
		return $rows;
	}
	$ids = array_values(array_unique(array_map(function ($row) {
		return (int)$row['product_id'];
	}, $rows)));
	$stmt = mysqli_prepare($conn, "SELECT product_ID, access_code, sol_name, unit_name FROM tb_product WHERE product_ID IN (" . implode(',', array_fill(0, count($ids), '?')) . ")");
	mysqli_stmt_bind_param($stmt, str_repeat('i', count($ids)), ...$ids);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$products = array();
	while ($result && ($product = mysqli_fetch_assoc($result))) {
		$products[(int)$product['product_ID']] = $product;
	}
	mysqli_stmt_close($stmt);

	foreach ($rows as $index => $row) {
		$product = $products[(int)$row['product_id']] ?? array();
		$rows[$index]['access_code'] = (string)($product['access_code'] ?? '');
		$rows[$index]['sol_name'] = (string)($product['sol_name'] ?? '');
		$rows[$index]['unit_name'] = (string)($product['unit_name'] ?? '');
	}
	return $rows;
}

/* ชื่อแผนก/เขต และรายละเอียดลูกค้า (อ่านอย่างเดียว) */
$saleName = '';
if ($doc['sale_code'] !== '') {
	$stmt = mysqli_prepare($com, "SELECT sale_name FROM tb_team_adm WHERE sale_code = ? LIMIT 1");
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, 's', $doc['sale_code']);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = $result ? mysqli_fetch_assoc($result) : null;
		$saleName = $row ? (string)$row['sale_name'] : '';
		mysqli_stmt_close($stmt);
	}
}

$customer = null;
if ((string)$doc['bill_id'] !== '') {
	$stmt = mysqli_prepare($conn, "SELECT bill_name, bill_address, bill_ampher, billl_province, bill_postcode, bill_tel, tax_id FROM tb_customer WHERE customer_id = ? LIMIT 1");
	if ($stmt) {
		$billId = (string)$doc['bill_id'];
		mysqli_stmt_bind_param($stmt, 's', $billId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$customer = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
	}
}
$customerAddress = $customer ? trim(implode(' ', array_filter(array(
	trim((string)$customer['bill_address']),
	trim((string)$customer['bill_ampher']),
	trim((string)$customer['billl_province']),
	trim((string)$customer['bill_postcode']),
)))) : '';

$companies = po_company_options();
$companyLabel = $companies[(string)$doc['type_doc']] ?? '';
$isDraftDoc = ($doc['status_doc'] === PO_STATUS_DRAFT);
$watermark = $isPreview ? 'PREVIEW' : ($isDraftDoc ? 'DRAFT' : '');

$totalQty = 0;
$totalAmount = 0;
$totalDiscount = 0;
foreach ($items as $item) {
	$totalQty += (float)$item['count'];
	$totalAmount += (float)$item['count'] * (float)$item['price'];
	$totalDiscount += (float)$item['count'] * (float)$item['discount'];
}

$fmtDate = function ($value) {
	$iso = so_saved_iso_date_input($value);
	return $iso === '' ? '-' : so_saved_buddhist_date_input($iso);
};
$h = function ($value) {
	$value = trim((string)$value);
	return $value === '' ? '-' : so_saved_h($value);
};
$money = function ($value) {
	return number_format((float)$value, 2);
};
?>
<!DOCTYPE html>
<html lang="th">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ใบ PO <?php echo so_saved_h($doc['ref_id']); ?></title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap">
	<style>
		* { box-sizing: border-box; }
		body { margin: 0; background: #F4EFF8; font-family: 'Prompt', sans-serif; color: #3B3B3B; font-size: 13px; }
		.toolbar { max-width: 210mm; margin: 16px auto 0; display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 0 12px; flex-wrap: wrap; }
		.toolbar-note { color: #8E8B94; font-size: 13px; }
		.btn-print { background: #612989; color: #fff; border: 0; border-radius: 22px; min-height: 40px; padding: 0 24px; font-family: inherit; font-size: 14px; cursor: pointer; }
		.btn-print:focus-visible { outline: 2px solid rgba(97, 41, 137, 0.45); outline-offset: 2px; }
		.page { position: relative; width: 210mm; max-width: 100%; min-height: 297mm; margin: 12px auto 24px; padding: 14mm 12mm; background: #fff; box-shadow: 0 4px 20px rgba(97, 41, 137, 0.06); overflow: hidden; }
		.watermark { position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%) rotate(-24deg); font-size: 96px; font-weight: 600; color: rgba(97, 41, 137, 0.07); pointer-events: none; letter-spacing: 8px; }
		.head { display: flex; justify-content: space-between; gap: 16px; border-bottom: 2px solid #612989; padding-bottom: 10px; margin-bottom: 14px; }
		.head h1 { margin: 0; font-size: 22px; color: #612989; font-weight: 600; }
		.head .company { font-size: 14px; color: #8E8B94; }
		.meta { text-align: right; font-size: 13px; line-height: 1.7; }
		.meta b { color: #612989; }
		.grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px 24px; margin-bottom: 14px; }
		.field { display: flex; gap: 8px; line-height: 1.6; }
		.field .label { color: #8E8B94; min-width: 110px; }
		.field.full { grid-column: span 2; }
		table { width: 100%; border-collapse: collapse; margin-top: 6px; }
		th { background: #F4EFF8; color: #612989; font-weight: 500; text-align: left; padding: 7px 6px; border-bottom: 1px solid #612989; font-size: 12px; }
		td { padding: 7px 6px; border-bottom: 1px solid #EDE9F0; vertical-align: top; font-size: 12px; }
		.num { text-align: right; white-space: nowrap; }
		.center { text-align: center; }
		.sub { color: #8E8B94; font-size: 11px; margin-top: 2px; }
		.totals { margin-left: auto; width: 60%; margin-top: 10px; }
		.totals td { border: 0; padding: 4px 6px; font-size: 13px; }
		.totals tr.net td { font-weight: 600; color: #612989; border-top: 1px solid #612989; }
		.section-title { font-weight: 500; color: #612989; margin: 16px 0 6px; }
		.box { border: 1px solid #EDE9F0; border-radius: 8px; padding: 8px 10px; min-height: 40px; white-space: pre-line; }
		.files a { color: #612989; }
		.empty { color: #8E8B94; text-align: center; padding: 16px; }
		@media print {
			body { background: #fff; }
			.toolbar { display: none; }
			.page { margin: 0; box-shadow: none; width: auto; min-height: auto; }
			@page { size: A4; margin: 10mm; }
		}
		@media (max-width: 640px) {
			.page { padding: 16px 12px; min-height: 0; }
			.grid { grid-template-columns: 1fr; }
			.field.full { grid-column: auto; }
			.head { flex-direction: column; }
			.meta { text-align: left; }
			.table-wrap { overflow-x: auto; }
			.totals { width: 100%; }
		}
	</style>
</head>

<body>
	<div class="toolbar">
		<span class="toolbar-note">
			<?php if ($isPreview) { ?>ตัวอย่างจากข้อมูลในฟอร์ม — ยังไม่ได้บันทึก<?php } else if ($isDraftDoc) { ?>เอกสารร่าง (Draft)<?php } else { ?>เอกสารที่บันทึกแล้ว<?php } ?>
		</span>
		<button type="button" class="btn-print" onclick="window.print();">พิมพ์</button>
	</div>

	<div class="page">
		<?php if ($watermark !== '') { ?><div class="watermark" aria-hidden="true"><?php echo $watermark; ?></div><?php } ?>

		<div class="head">
			<div>
				<h1>ใบสั่งซื้อ (PO)</h1>
				<div class="company">บริษัท <?php echo $h($companyLabel); ?></div>
			</div>
			<div class="meta">
				<div>เลขที่อ้างอิง <b><?php echo $h($doc['ref_id']); ?></b></div>
				<div>เลขที่ PO <b><?php echo $h($doc['po_no']); ?></b></div>
				<div>วันที่ <?php echo $fmtDate($doc['date_po']); ?></div>
			</div>
		</div>

		<div class="grid">
			<div class="field"><span class="label">รหัสลูกค้า</span><span><?php echo $h($doc['bill_id']); ?></span></div>
			<div class="field"><span class="label">แผนก/เขตการขาย</span><span><?php echo $h(trim($doc['sale_code'] . ($saleName !== '' ? ' - ' . $saleName : ''))); ?></span></div>
			<div class="field"><span class="label">ชื่อลูกค้า</span><span><?php echo $h($customer['bill_name'] ?? ''); ?></span></div>
			<div class="field"><span class="label">เบอร์โทรศัพท์</span><span><?php echo $h($customer['bill_tel'] ?? ''); ?></span></div>
			<div class="field full"><span class="label">ชื่อออกบิล</span><span><?php echo $h($doc['bill_name']); ?></span></div>
			<div class="field full"><span class="label">ที่อยู่</span><span><?php echo $h($customerAddress); ?></span></div>
			<div class="field full"><span class="label">การดำเนินการ</span><span><?php echo $h($doc['description']); ?></span></div>
		</div>

		<div class="table-wrap">
			<table>
				<thead>
					<tr>
						<th class="center" style="width:32px;">#</th>
						<th style="width:15%;">รหัสสินค้า</th>
						<th>รายการสินค้า</th>
						<th class="num" style="width:9%;">จำนวน</th>
						<th class="num" style="width:13%;">ราคา/หน่วย</th>
						<th class="num" style="width:12%;">ส่วนลด/หน่วย</th>
						<th class="num" style="width:14%;">ยอดรวม</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($items) === 0) { ?>
						<tr><td colspan="7" class="empty">ยังไม่มีรายการสินค้า</td></tr>
					<?php } ?>
					<?php foreach ($items as $index => $item) {
						$extras = array();
						if (trim((string)$item['warranty']) !== '') $extras[] = 'รับประกัน ' . $item['warranty'] . ' ปี';
						if (trim((string)$item['cal']) !== '') $extras[] = 'CAL ' . $item['cal'] . '/ปี';
						if (trim((string)$item['pm']) !== '') $extras[] = 'PM ' . $item['pm'] . ' ปี';
						if (trim((string)$item['sale_remark']) !== '') $extras[] = 'หมายเหตุ: ' . $item['sale_remark'];
					?>
						<tr>
							<td class="center"><?php echo $index + 1; ?></td>
							<td><?php echo $h($item['access_code'] ?? ''); ?></td>
							<td>
								<?php echo $h($item['sol_name'] ?? ''); ?>
								<?php if (count($extras) > 0) { ?><div class="sub"><?php echo so_saved_h(implode(' · ', $extras)); ?></div><?php } ?>
							</td>
							<td class="num"><?php echo so_saved_h(po_trim_number(number_format((float)$item['count'], 2, '.', ''))) . ' ' . so_saved_h($item['unit_name'] ?? ''); ?></td>
							<td class="num"><?php echo $money($item['price']); ?></td>
							<td class="num"><?php echo $money($item['discount']); ?></td>
							<td class="num"><?php echo $money($item['amount']); ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

		<table class="totals">
			<tr><td>จำนวนรวม (ชิ้น)</td><td class="num"><?php echo so_saved_h(po_trim_number(number_format($totalQty, 2, '.', ''))); ?></td></tr>
			<tr><td>ยอดรวม</td><td class="num"><?php echo $money($totalAmount); ?></td></tr>
			<tr><td>ส่วนลดทั้งหมด</td><td class="num"><?php echo $money($totalDiscount); ?></td></tr>
			<tr class="net"><td>ยอดรวมสุทธิ</td><td class="num"><?php echo $money($totalAmount - $totalDiscount); ?></td></tr>
		</table>

		<div class="section-title">หมายเหตุ</div>
		<div class="box"><?php echo $h($doc['remark']); ?></div>

		<div class="section-title">ไฟล์แนบ</div>
		<div class="box files">
			<?php if (count($attachments) === 0) { ?>-<?php } ?>
			<?php foreach ($attachments as $attachment) { ?>
				<div>
					<?php if ($attachment['href'] !== '') { ?>
						<a href="<?php echo so_saved_h($attachment['href']); ?>" target="_blank" rel="noopener"><?php echo so_saved_h($attachment['name']); ?></a>
					<?php } else { ?>
						<?php echo so_saved_h($attachment['name']); ?> <span class="sub">(ไฟล์ใหม่ ยังไม่บันทึก)</span>
					<?php } ?>
				</div>
			<?php } ?>
		</div>

		<p class="sub" style="margin-top:18px;">บันทึกโดย <?php echo $h($doc['add_by']); ?> · <?php echo $h($doc['add_date']); ?></p>
	</div>
</body>

</html>
