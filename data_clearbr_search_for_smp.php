<?php

/**
 * ค้นหาใบยืม (hos__br) ที่อนุมัติแล้วและยังไม่ปิด สำหรับ modal "เคลียร์ยืม" ของ register_supsmp.php
 * คืนเอกสาร + รายการสินค้าที่ยังไม่ถูกเคลียร์ (clear_ckk='0') — อ่านอย่างเดียว ไม่มีการเขียนฐานข้อมูล
 *
 * ต่างจาก data_clearbr_search_for_spr.php ตรงที่กรองตามเขตการขาย (sale_code) ที่เลือกในฟอร์ม SMP
 * เพราะผู้สร้างใบ SMP อาจเป็นหัวหน้าที่สร้างแทนทีม (session code เป็น SUP_* ไม่ตรงกับ sale_code ของใบยืม)
 * ถ้าไม่ส่ง sale_code จะใช้ session code เดิม
 */

session_start();
include 'dbconnect.php';

header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['UserID'])) {
	echo json_encode(array('success' => false, 'message' => 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่'), JSON_UNESCAPED_UNICODE);
	exit();
}

$keyword = isset($_GET['keyword']) ? trim((string)$_GET['keyword']) : '';
$saleCode = isset($_GET['sale_code']) ? trim((string)$_GET['sale_code']) : '';
if ($saleCode === '') {
	$saleCode = (string)($_SESSION['code'] ?? '');
}
if ($saleCode === '') {
	echo json_encode(array('success' => true, 'docs' => array()), JSON_UNESCAPED_UNICODE);
	exit();
}

/* บริษัทของใบ SMP: 2 = NBM (ใบยืม company 2,4 / สินค้า NBM), นอกนั้น = AWL (ใบยืม company 1,3 / สินค้า AWL) */
$isNbm = (isset($_GET['type_company']) && trim((string)$_GET['type_company']) === '2');
$loanCompanies = $isNbm ? "'2','4'" : "'1','3'";
$productCompany = $isNbm ? 'NBM' : 'AWL';

$where = "sale_code = '" . mysqli_real_escape_string($conn, $saleCode) . "' AND close_br = '0' AND status_doc = 'Approve' AND company IN (" . $loanCompanies . ")";
$where .= " AND EXISTS (SELECT 1 FROM hos__subbr sub WHERE sub.ref_idd_br = hos__br.ref_id_br AND sub.clear_ckk = '0')";

if ($keyword !== '') {
	$safeKeyword = mysqli_real_escape_string($conn, $keyword);
	$where .= " AND (iv_no LIKE '%" . $safeKeyword . "%' OR customer LIKE '%" . $safeKeyword . "%')";
}

$query = mysqli_query($conn, "SELECT ref_id_br, iv_no, date_br, customer FROM hos__br WHERE " . $where . " ORDER BY id DESC LIMIT 30");
if (!$query) {
	echo json_encode(array('success' => false, 'message' => 'ค้นหาไม่สำเร็จ'), JSON_UNESCAPED_UNICODE);
	exit();
}

$docs = array();
while ($doc = mysqli_fetch_assoc($query)) {
	$itemStmt = mysqli_prepare($conn, "SELECT sub.product_id, sub.count, sub.price, sub.sn, p.access_code, p.sol_name, p.unit_name, p.type_company, p.war_hc, p.unit_hc
		FROM hos__subbr sub LEFT JOIN tb_product p ON p.product_ID = sub.product_id
		WHERE sub.ref_idd_br = ? AND sub.clear_ckk = '0'");
	mysqli_stmt_bind_param($itemStmt, 's', $doc['ref_id_br']);
	mysqli_stmt_execute($itemStmt);
	$itemResult = mysqli_stmt_get_result($itemStmt);
	$items = array();
	while ($item = mysqli_fetch_assoc($itemResult)) {
		$items[] = array(
			'product_id'   => (string)$item['product_id'],
			'access_code'  => (string)$item['access_code'],
			'product_name' => (string)$item['sol_name'],
			'unit_name'    => (string)$item['unit_name'],
			'count'        => (string)$item['count'],
			'unit_price'   => (string)$item['price'],
			/* SN ของเครื่องที่ยืมไป — ฝั่ง JS เอาไปเติมช่อง SN ให้อัตโนมัติตอนนำเข้ารายการ */
			'sn'           => (string)$item['sn'],
			'waranty'      => (trim((string)$item['unit_hc']) === 'ปี' && ctype_digit(trim((string)$item['war_hc']))) ? trim((string)$item['war_hc']) : '0',
			'company_match' => trim((string)$item['type_company']) === $productCompany,
			'product_company' => trim((string)$item['type_company']),
		);
	}
	mysqli_stmt_close($itemStmt);

	if (count($items) === 0) {
		continue;
	}

	$docs[] = array(
		'ref_id_br' => (string)$doc['ref_id_br'],
		'iv_no'     => (string)$doc['iv_no'],
		'date_br'   => (string)$doc['date_br'],
		'customer'  => (string)$doc['customer'],
		'items'     => $items,
	);
}

echo json_encode(array('success' => true, 'docs' => $docs), JSON_UNESCAPED_UNICODE);
