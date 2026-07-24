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

$ref_id_br = isset($_GET['ref_id_br']) ? trim($_GET['ref_id_br']) : '';
if (empty($ref_id_br)) {
	echo json_encode(array(
		'success' => false,
		'message' => 'ระบุเลขที่อ้างอิงไม่ถูกต้อง'
	), JSON_UNESCAPED_UNICODE);
	exit;
}

$safe_ref = mysqli_real_escape_string($conn, $ref_id_br);

// 1. Fetch hos__br document info
$sqlBr = "SELECT * FROM hos__br WHERE ref_id_br = '{$safe_ref}' LIMIT 1";
$resBr = mysqli_query($conn, $sqlBr);
if (!$resBr || mysqli_num_rows($resBr) === 0) {
	echo json_encode(array(
		'success' => false,
		'message' => 'ไม่พบข้อมูลเอกสารยืม'
	), JSON_UNESCAPED_UNICODE);
	exit;
}

$br = mysqli_fetch_assoc($resBr);
$ivNoEsc = mysqli_real_escape_string($conn, $br['iv_no']);

// Fetch iv_no strictly from hos__so
$soIvNoList = array();
$sqlSoIv = "SELECT DISTINCT s.iv_no 
            FROM hos__so s 
            LEFT JOIN hos__subso ss ON s.ref_id = ss.ref_idd 
            WHERE (s.ref_ren = '{$safe_ref}' OR (ss.clear_ivno = '{$ivNoEsc}' AND ss.clear_ivno != '')) 
              AND s.status_doc = 'Approve' 
              AND s.iv_no IS NOT NULL AND s.iv_no != ''";
$resSoIv = mysqli_query($conn, $sqlSoIv);
if ($resSoIv) {
	while ($rowSo = mysqli_fetch_assoc($resSoIv)) {
		if (!empty($rowSo['iv_no'])) {
			$soIvNoList[] = $rowSo['iv_no'];
		}
	}
}
$soIvNoText = !empty($soIvNoList) ? implode(', ', array_unique($soIvNoList)) : '-';

// Build clear documents list text
$clearDocs = array();
if (!empty($br['clear_book_no'])) $clearDocs[] = 'SO: ' . $br['clear_book_no'];
if (!empty($br['clear_brn_no'])) $clearDocs[] = 'BRN: ' . $br['clear_brn_no'];
if (!empty($br['clear_brnp_no'])) $clearDocs[] = 'BRNP: ' . $br['clear_brnp_no'];
if (!empty($soIvNoList)) $clearDocs = array_merge($clearDocs, $soIvNoList);

$clearDocsText = !empty($clearDocs) ? implode(', ', array_unique($clearDocs)) : '-';

// Determine overall BR status
$isClosed = ((isset($br['close_br']) && $br['close_br'] == '1') || (isset($br['status_br']) && $br['status_br'] == 'closed'));
$brStatusText = $isClosed ? 'เคลียร์ครบแล้ว' : 'ใบยืมคงค้าง';
$brStatusClass = $isClosed ? 'approve' : 'pending-mgr';

// 2. Fetch hos__subbr items
$sqlItems = "SELECT hos__subbr.*, tb_product.sol_name AS prod_sol_name, tb_product.access_code
             FROM hos__subbr 
             LEFT JOIN tb_product ON hos__subbr.product_ID = tb_product.product_id 
             WHERE ref_idd_br = '{$safe_ref}'";
$resItems = mysqli_query($conn, $sqlItems);

$items = array();
if ($resItems) {
	while ($row = mysqli_fetch_assoc($resItems)) {
		$prodName = !empty($row['prod_sol_name']) ? $row['prod_sol_name'] : (isset($row['sol_name']) ? $row['sol_name'] : '-');
		$borrowQty = isset($row['count']) ? (int)$row['count'] : (isset($row['num']) ? (int)$row['num'] : 1);
		$productId = isset($row['product_id']) ? (string)$row['product_id'] : (isset($row['product_ID']) ? (string)$row['product_ID'] : '');

		// Calculate cleared quantity from clearing queries if available
		$clearedQty = 0;
		if (isset($row['clear_ckk']) && $row['clear_ckk'] == '1') {
			$clearedQty = $borrowQty;
		} else if ($productId !== '') {
			// Query cleared count from subso/subspr/subreceive/subsmp, scoped to this BR's iv_no
			$prodIdEsc = mysqli_real_escape_string($conn, $productId);

			$q1 = mysqli_query($conn, "SELECT SUM(count) AS cnt FROM hos__subso WHERE clear_br = '1' AND product_id = '{$prodIdEsc}' AND clear_ivno = '{$ivNoEsc}' AND status_so = 'Approve'");
			if ($q1 && $r1 = mysqli_fetch_assoc($q1)) $clearedQty += (int)$r1['cnt'];

			$q2 = mysqli_query($conn, "SELECT SUM(sale_count) AS cnt FROM hos__subspr WHERE clear_br = '1' AND product_id = '{$prodIdEsc}' AND clear_ivno = '{$ivNoEsc}' AND status_spr = 'Approve'");
			if ($q2 && $r2 = mysqli_fetch_assoc($q2)) $clearedQty += (int)$r2['cnt'];

			$q3 = mysqli_query($conn, "SELECT SUM(sale_count) AS cnt FROM hos__subsmp WHERE clear_br = '1' AND product_id = '{$prodIdEsc}' AND br_no = '{$ivNoEsc}' AND status_smp = 'Approve'");
			if ($q3 && $r3 = mysqli_fetch_assoc($q3)) $clearedQty += (int)$r3['cnt'];

			$q41 = mysqli_query($conn, "SELECT ref_id FROM hos__receive WHERE iv_no = '{$ivNoEsc}'");
			if ($q41 && $r41 = mysqli_fetch_assoc($q41)) {
				$receiveRefEsc = mysqli_real_escape_string($conn, $r41['ref_id']);
				$q4 = mysqli_query($conn, "SELECT SUM(count) AS cnt FROM hos__subreceive WHERE ref_idd = '{$receiveRefEsc}' AND product_id = '{$prodIdEsc}'");
				if ($q4 && $r4 = mysqli_fetch_assoc($q4)) $clearedQty += (int)$r4['cnt'];
			}
		}

		if ($clearedQty > $borrowQty) $clearedQty = $borrowQty;
		$remainingQty = $borrowQty - $clearedQty;
		if ($remainingQty < 0) $remainingQty = 0;

		$itemCleared = ($remainingQty == 0 || (isset($row['clear_ckk']) && $row['clear_ckk'] == '1'));

		$items[] = array(
			'product_id' => $productId,
			'product_code' => isset($row['access_code']) ? $row['access_code'] : (isset($row['product_code']) ? $row['product_code'] : ''),
			'product_name' => $prodName,
			'borrow_qty' => $borrowQty,
			'cleared_qty' => $clearedQty,
			'remaining_qty' => $remainingQty,
			'sn' => isset($row['sn']) ? $row['sn'] : '',
			'status_text' => $itemCleared ? 'เคลียร์ครบแล้ว' : 'ค้างเคลียร์',
			'status_class' => $itemCleared ? 'approve' : 'pending-mgr'
		);
	}
}

echo json_encode(array(
	'success' => true,
	'data' => array(
		'ref_id_br' => $br['ref_id_br'],
		'iv_no' => $soIvNoText,
		'date_br' => formatDateThaiLocal($br['date_br']),
		'iv_date' => formatDateThaiLocal($br['iv_date']),
		'customer' => $br['customer'],
		'sale_code' => $br['sale_code'],
		'status_doc' => $br['status_doc'],
		'status_br_text' => $brStatusText,
		'status_br_class' => $brStatusClass,
		'clear_docs_text' => $clearDocsText,
		'items' => $items
	)
), JSON_UNESCAPED_UNICODE);
