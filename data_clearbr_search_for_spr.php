<?php

/**
 * ค้นหาใบยืม (hos__br) ที่อนุมัติแล้วและยังไม่ปิด สำหรับ modal "เคลียร์ยืม" ของ
 * register_engspr.php — คืนเอกสาร + รายการสินค้าที่ยังไม่ถูกเคลียร์ (clear_ckk='0')
 * ของแต่ละใบ เพื่อให้ผู้ใช้เลือกนำเข้าเป็นรายการในใบเบิก SPR
 *
 * สิทธิ์การมองเห็น มิเรอร์ status_clearbr.php เดิม (ช่างเห็นใบยืมของกลุ่ม EN ทั้งหมด,
 * ผู้ใช้อื่นเห็นเฉพาะของ sale_code ตัวเอง) — endpoint นี้อ่านอย่างเดียว ไม่มีการเขียนฐานข้อมูล
 *
 * กรองเฉพาะใบยืมของบริษัทเดียวกับใบ SPR — hos__br.company ใช้ 1=AWL / 2=NBM
 * (3/4 เป็นค่าชุดรันเลขเอกสาร รวมไว้ด้วยแบบเดียวกับ ajax_clear_loan_popup_search.php)
 * ใบยืมเก่าบางใบมีสินค้าต่างบริษัทปนอยู่ จึงส่ง product_company ของแต่ละรายการกลับไป
 * ให้ modal ปิดการเลือกรายการนั้น (spr_validate_item_company() ปฏิเสธซ้ำตอนบันทึก)
 */

session_start();
include "dbconnect.php";

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['code']) || $_SESSION['code'] === '') {
	echo json_encode(array('success' => false, 'message' => 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่'), JSON_UNESCAPED_UNICODE);
	exit();
}

$keyword = isset($_GET['keyword']) ? trim((string)$_GET['keyword']) : '';
$saleCode = (string)$_SESSION['code'];
$userType = isset($_SESSION['user_type']) ? (string)$_SESSION['user_type'] : '';
$typeCompany = (isset($_GET['type_company']) && $_GET['type_company'] === 'NBM') ? 'NBM' : 'AWL';
$companyFilter = ($typeCompany === 'NBM') ? "company IN ('2','4')" : "company IN ('1','3')";

if ($userType === 'Engineer') {
	$where = "sale_code LIKE '%EN%' AND close_br = '0' AND status_doc = 'Approve'";
} else {
	$where = "sale_code = '" . mysqli_real_escape_string($conn, $saleCode) . "' AND close_br = '0' AND status_doc = 'Approve'";
}
$where .= " AND " . $companyFilter;
// ตัดใบที่ไม่มีรายการค้างเคลียร์ตั้งแต่ใน SQL — ถ้าไปตัดทีหลัง LIMIT ใบยืมล่าสุดที่ไม่มี
// รายการจะกิน 30 ช่องจนไม่เหลือใบที่เคลียร์ได้จริง (เงื่อนไขเดียวกับ query รายการด้านล่าง)
$where .= " AND EXISTS (SELECT 1 FROM hos__subbr sub WHERE sub.ref_idd_br = hos__br.ref_id_br AND sub.clear_ckk = '0')";

if ($keyword !== '') {
	$safeKeyword = mysqli_real_escape_string($conn, $keyword);
	$where .= " AND (iv_no LIKE '%" . $safeKeyword . "%' OR customer LIKE '%" . $safeKeyword . "%')";
}

$sql = "SELECT ref_id_br, iv_no, date_br, customer FROM hos__br WHERE " . $where . " ORDER BY id DESC LIMIT 30";
$query = mysqli_query($conn, $sql);
if (!$query) {
	echo json_encode(array('success' => false, 'message' => 'ค้นหาไม่สำเร็จ'), JSON_UNESCAPED_UNICODE);
	exit();
}

$docs = array();
while ($doc = mysqli_fetch_assoc($query)) {
	$itemStmt = mysqli_prepare($conn, "SELECT sub.product_id, sub.count, sub.price, p.access_code, p.sol_name, p.unit_name, p.type_company
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
			'product_company' => trim((string)$item['type_company']),
			'company_match'   => trim((string)$item['type_company']) === $typeCompany,
		);
	}
	mysqli_stmt_close($itemStmt);

	if (count($items) === 0) {
		continue; // ใบที่เคลียร์ครบแล้วไม่ต้องแสดง
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
