<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['code'])) {
	http_response_code(401);
	echo json_encode(array(
		'success' => false,
		'message' => 'กรุณาเข้าสู่ระบบ'
	), JSON_UNESCAPED_UNICODE);
	exit;
}

include 'dbconnect.php';
include 'dbconnect_sale.php';

function formatDateThaiLocal($dateStr)
{
	if (empty($dateStr) || $dateStr === '0000-00-00' || $dateStr === '0000-00-00 00:00:00') {
		return '-';
	}
	$ts = strtotime($dateStr);
	if ($ts === false) return $dateStr;
	$beYear = (int)date('Y', $ts) + 543;
	return date('d/m/', $ts) . $beYear;
}

$ref_id_br  = isset($_GET['ref_id_br']) ? trim($_GET['ref_id_br']) : '';
$product_id = isset($_GET['product_id']) ? trim($_GET['product_id']) : '';

if ($ref_id_br === '' || $product_id === '') {
	echo json_encode(array(
		'success' => false,
		'message' => 'ระบุพารามิเตอร์ไม่ครบถ้วน'
	), JSON_UNESCAPED_UNICODE);
	exit;
}

$safe_ref  = mysqli_real_escape_string($conn, $ref_id_br);
$safe_prod = mysqli_real_escape_string($conn, $product_id);

// Fetch iv_no (เลขที่เอกสารใบยืม) จาก hos__br เพื่อใช้ผูกกับรายการเคลียร์
$sqlBr = "SELECT iv_no FROM hos__br WHERE ref_id_br = '{$safe_ref}' LIMIT 1";
$resBr = mysqli_query($conn, $sqlBr);
if (!$resBr || mysqli_num_rows($resBr) === 0) {
	echo json_encode(array(
		'success' => false,
		'message' => 'ไม่พบข้อมูลเอกสารยืม'
	), JSON_UNESCAPED_UNICODE);
	exit;
}
$br = mysqli_fetch_assoc($resBr);
$ivNoEsc = mysqli_real_escape_string($conn, isset($br['iv_no']) ? $br['iv_no'] : '');

$items = array();

$pushRow = function ($dateRaw, $docNo, $customer, $qty, $price, $amount, $sn) use (&$items) {
	$items[] = array(
		'doc_date'    => formatDateThaiLocal($dateRaw),
		'doc_no'      => ($docNo !== null && $docNo !== '') ? $docNo : '-',
		'customer'    => ($customer !== null && $customer !== '') ? $customer : '-',
		'cleared_qty' => (int)$qty,
		'price'       => (float)$price,
		'amount'      => (float)$amount,
		'sn'          => ($sn !== null && $sn !== '') ? $sn : '-'
	);
};

// 1) SO (ระบบ hos): hos__subso × hos__so
$sql1 = "SELECT sub.count AS qty, sub.price AS price, sub.amount AS amount, sub.sn AS sn,
                head.iv_date AS doc_date, head.iv_no AS doc_no, head.bill_name AS customer
         FROM hos__subso sub
         INNER JOIN hos__so head ON head.ref_id = sub.ref_idd
         WHERE sub.clear_br = '1' AND sub.status_so = 'Approve'
           AND sub.product_id = '{$safe_prod}' AND sub.clear_ivno = '{$ivNoEsc}'
           AND head.status_doc = 'Approve'";
$r1 = mysqli_query($conn, $sql1);
if ($r1) {
	while ($row = mysqli_fetch_assoc($r1)) {
		$pushRow($row['doc_date'], $row['doc_no'], $row['customer'], $row['qty'], $row['price'], $row['amount'], $row['sn']);
	}
}

// 2) SO (ระบบ so__main): so__submain × so__main
$sql2 = "SELECT sub.sale_count AS qty, sub.price_per_unit AS price, sub.sum_amount AS amount, sub.sn_number AS sn,
                head.doc_release_date AS doc_date, head.doc_no AS doc_no, head.billing_name AS customer
         FROM so__submain sub
         INNER JOIN so__main head ON head.ref_id = sub.ref_idd
         WHERE sub.clear_br = '1' AND sub.status_sol = 'Approve'
           AND sub.product_id = '{$safe_prod}' AND sub.clear_ivno = '{$ivNoEsc}'
           AND head.approve_complete = 'Approve' AND head.cancel_ckk = '0'";
$r2 = mysqli_query($conn, $sql2);
if ($r2) {
	while ($row = mysqli_fetch_assoc($r2)) {
		$pushRow($row['doc_date'], $row['doc_no'], $row['customer'], $row['qty'], $row['price'], $row['amount'], $row['sn']);
	}
}

// 3) SMP (ตัวอย่างสินค้า): hos__subsmp × hos__smp
$sql3 = "SELECT sub.sale_count AS qty, sub.unit_price AS price, sub.sum_amount AS amount, sub.sn AS sn,
                head.smp_date AS doc_date, head.smp_no AS doc_no, head.customer_name AS customer
         FROM hos__subsmp sub
         INNER JOIN hos__smp head ON head.ref_idsmp = sub.reff_idsmp
         WHERE sub.clear_br = '1' AND sub.status_smp = 'Approve'
           AND sub.product_id = '{$safe_prod}' AND sub.br_no = '{$ivNoEsc}'
           AND head.status_sup = 'Approve'";
$r3 = mysqli_query($conn, $sql3);
if ($r3) {
	while ($row = mysqli_fetch_assoc($r3)) {
		$pushRow($row['doc_date'], $row['doc_no'], $row['customer'], $row['qty'], $row['price'], $row['amount'], $row['sn']);
	}
}

// 4) SPR: hos__subspr × hos__spr
$sql4 = "SELECT sub.sale_count AS qty, sub.unit_price AS price, sub.sum_amount AS amount, sub.sn AS sn,
                head.spr_date AS doc_date, head.spr_no AS doc_no, head.customer AS customer
         FROM hos__subspr sub
         INNER JOIN hos__spr head ON head.ref_id = sub.ref_idd
         WHERE sub.clear_br = '1' AND sub.status_spr = 'Approve'
           AND sub.product_id = '{$safe_prod}' AND sub.clear_ivno = '{$ivNoEsc}'
           AND head.status_doc = 'Approve'";
$r4 = mysqli_query($conn, $sql4);
if ($r4) {
	while ($row = mysqli_fetch_assoc($r4)) {
		$pushRow($row['doc_date'], $row['doc_no'], $row['customer'], $row['qty'], $row['price'], $row['amount'], $row['sn']);
	}
}

// 5) รับคืนสินค้า: hos__subreceive × hos__receive (ไม่มีราคา → 0.00, hos__receive ไม่มีคอลัมน์วันที่)
$sql5 = "SELECT sub.count AS qty, sub.sn AS sn, head.customer_name AS customer
         FROM hos__subreceive sub
         INNER JOIN hos__receive head ON head.ref_id = sub.ref_idd
         WHERE head.iv_no = '{$ivNoEsc}' AND sub.product_id = '{$safe_prod}'";
$r5 = mysqli_query($conn, $sql5);
if ($r5) {
	while ($row = mysqli_fetch_assoc($r5)) {
		$pushRow('', 'รับคืนสินค้า', $row['customer'], $row['qty'], 0, 0, $row['sn']);
	}
}

echo json_encode(array(
	'success' => true,
	'data' => array(
		'items' => $items
	)
), JSON_UNESCAPED_UNICODE);
