<?php

/**
 * ค้นหารายการสินค้าที่ยังยืมได้จากใบ PO สำหรับ modal เอกสาร PO ของ register_breng_brgq.php
 * (ใบยืมตรวจเช็คสินค้า BREQ)
 *
 * ต้นทางข้อมูลลอกมาจาก register_breng_brgq.php:298-324 แต่ตัด UPDATE ทั้งหมดออก —
 * endpoint นี้ต้องอ่านอย่างเดียว ห้ามแก้ close_br/ckk_check เพราะถูกเรียกซ้ำได้หลายครั้ง
 * ระหว่างค้นหาในหน้าเดียว (คนละ semantics จากการ render หน้าแบบ GET ที่ปิด PO ทิ้งเงียบ ๆ)
 */

header('Content-Type: application/json; charset=utf-8');
session_start();

function breq_po_items_fail($message, $statusCode = 400)
{
    http_response_code($statusCode);
    echo json_encode(array('success' => false, 'message' => $message), JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_SESSION['UserID']) && empty($_SESSION['name'])) {
    breq_po_items_fail('กรุณาเข้าสู่ระบบใหม่', 401);
}

include 'dbconnect.php';

// dbconnect.php เปิด $new ให้เสมอ (allwell_stock_test) แต่กันไว้เผื่อ environment ที่ยังไม่ได้ตั้งค่า
$stockConn = (isset($new) && $new instanceof mysqli) ? $new : $conn;

foreach (array('in__main', 'in__sbmain') as $requiredTable) {
    $tableName = mysqli_real_escape_string($stockConn, $requiredTable);
    $tableCheck = mysqli_query(
        $stockConn,
        "SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = '" . $tableName . "' LIMIT 1"
    );
    if (!$tableCheck || mysqli_num_rows($tableCheck) === 0) {
        breq_po_items_fail('ไม่พบตารางข้อมูลรับเข้า in__main / in__sbmain', 500);
    }
}

$keyword = isset($_REQUEST['q']) ? trim((string)$_REQUEST['q']) : '';
$company = isset($_REQUEST['company']) ? trim((string)$_REQUEST['company']) : '1';
if (!in_array($company, array('1', '2'), true)) {
    $company = '1';
}

// ===== 1) ดึงแถว "รับเข้า" ทั้งหมดจากฝั่ง stock (in__main + in__sbmain) =====
// ไม่กรองคำค้นในชั้นนี้ เพราะชื่อสินค้า (tb_product.sol_name) อยู่คนละฐานข้อมูล/คนละ connection
// (allwell_sol_test ผ่าน $conn) จึง JOIN ข้ามฐานด้วย SQL เดียวไม่ได้ — กรองรวมทีหลังในขั้นตอนที่ 3
//
// ห้ามเติม im.close_br = '0' ที่นี่ — register_breng_brgq.php เดิม (บรรทัด 298-306 ของเวอร์ชันก่อนแก้)
// ใช้ close_br='0' กรองแค่ตอนสร้าง <select> รายชื่อ po_no เท่านั้น ส่วน query ที่ดึง "รายการสินค้า"
// จริงของ po_no ที่เลือก (บรรทัด 300) กรองด้วย iv_no LIKE '%IO%' อย่างเดียว ไม่เช็ค close_br เลย
// เพราะบั๊กเดิม (ดูหัวข้อความเสี่ยงข้อ 1 ในแผน) เคย UPDATE close_br='1' ทับแถวรับเข้าจริงไปแล้วจำนวนมาก
// ถ้าเติมเงื่อนไขนี้จะกรอง PO ที่มีของเหลืออยู่จริงทิ้งไปเกือบหมด (พบจากการทดสอบกับข้อมูลจริง)
$stockSql = "SELECT im.ref_id AS main_ref_id, im.po_no, im.stock_date,
                    sm.product_id, sm.product_codesame, sm.sale_count, sm.lot_no,
                    sm.product_price, sm.product_nameother
             FROM in__main im
             INNER JOIN in__sbmain sm ON sm.ref_idd = im.ref_id
             WHERE im.iv_no LIKE '%IO%' AND sm.ckk_check = '0'
             ORDER BY im.po_no DESC";
$stockResult = mysqli_query($stockConn, $stockSql);
if (!$stockResult) {
    breq_po_items_fail('ไม่สามารถค้นหารายการรับเข้าได้', 500);
}

$stockRows = array();
while ($row = mysqli_fetch_assoc($stockResult)) {
    $stockRows[] = $row;
}

if (count($stockRows) === 0) {
    echo json_encode(array('success' => true, 'items' => array()), JSON_UNESCAPED_UNICODE);
    exit;
}

// ===== 2) กรองเฉพาะ PO ของบริษัทที่เลือก (allwell_inter.po__main.company) =====
// company ใช้ scheme เดียวกับ in__br.company / register-suphos ทั่วระบบ: 1 = AWL, 2 = NBM
// เช็คทีละ po_no ครั้งเดียว (cache) แทนการ query ซ้ำทุกแถว — แนวเดียวกับหน้าเดิม
$poCompanyCache = array();
function breq_po_belongs_to_company($conn, $poNo, $company, &$cache)
{
    $cacheKey = $company . '|' . $poNo;
    if (array_key_exists($cacheKey, $cache)) {
        return $cache[$cacheKey];
    }
    $belongs = false;
    $stmt = mysqli_prepare($conn, "SELECT 1 FROM allwell_inter.po__main WHERE po_no = ? AND company = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ss', $poNo, $company);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $belongs = mysqli_stmt_num_rows($stmt) > 0;
        mysqli_stmt_close($stmt);
    }
    $cache[$cacheKey] = $belongs;
    return $belongs;
}

// ===== 3) เติมชื่อสินค้า/ยอดยืมไปแล้ว แล้วประกอบเป็นรายการที่ตอบกลับ =====
$productCache = array();
$borrowedCache = array();
$keywordLower = mb_strtolower($keyword, 'UTF-8');
$items = array();

foreach ($stockRows as $row) {
    $poNo = (string)$row['po_no'];
    if (!breq_po_belongs_to_company($conn, $poNo, $company, $poCompanyCache)) {
        continue;
    }

    $productId = (string)$row['product_id'];
    if (!array_key_exists($productId, $productCache)) {
        $product = array('sol_name' => '', 'access_code' => '', 'war_hc' => '', 'unit_name' => '');
        $stmtProduct = mysqli_prepare($conn, "SELECT sol_name, access_code, war_hc, unit_name FROM tb_product WHERE product_ID = ? LIMIT 1");
        if ($stmtProduct) {
            mysqli_stmt_bind_param($stmtProduct, 's', $productId);
            mysqli_stmt_execute($stmtProduct);
            $productResult = mysqli_stmt_get_result($stmtProduct);
            $productRow = $productResult ? mysqli_fetch_assoc($productResult) : null;
            if ($productRow) {
                $product = $productRow;
            }
            mysqli_stmt_close($stmtProduct);
        }
        $productCache[$productId] = $product;
    }
    $product = $productCache[$productId];

    $borrowedKey = $poNo . '|' . $productId;
    if (!array_key_exists($borrowedKey, $borrowedCache)) {
        $sumBorrowed = 0;
        // ไม่นับใบ Rejected (ไม่อนุมัติ/ยกเลิก) — ตรงกับ breq_po_remaining() ใน includes/breq_repo.php
        $stmtSum = mysqli_prepare($conn, "SELECT SUM(s.count) AS sum_count FROM in__subbr s INNER JOIN in__br b ON b.ref_id_br = s.ref_idd_br WHERE s.po_no = ? AND s.product_id = ? AND b.status_doc <> 'Rejected'");
        if ($stmtSum) {
            mysqli_stmt_bind_param($stmtSum, 'ss', $poNo, $productId);
            mysqli_stmt_execute($stmtSum);
            $sumResult = mysqli_stmt_get_result($stmtSum);
            $sumRow = $sumResult ? mysqli_fetch_assoc($sumResult) : null;
            $sumBorrowed = $sumRow && $sumRow['sum_count'] !== null ? (float)$sumRow['sum_count'] : 0;
            mysqli_stmt_close($stmtSum);
        }
        $borrowedCache[$borrowedKey] = $sumBorrowed;
    }
    $sumBorrowed = $borrowedCache[$borrowedKey];

    $saleCount = (float)$row['sale_count'];
    $remaining = $saleCount - $sumBorrowed;
    $productName = (string)($product['sol_name'] ?? '');
    $lotNo = (string)($row['lot_no'] ?? '');

    if ($keyword !== '') {
        $haystack = mb_strtolower($poNo . ' ' . $productName . ' ' . $lotNo, 'UTF-8');
        if (mb_strpos($haystack, $keywordLower) === false) {
            continue;
        }
    }

    $items[] = array(
        'po_no'              => $poNo,
        'product_name'       => $productName,
        'sale_count'         => $saleCount,
        'remaining'          => $remaining,
        'stock_date'         => (string)($row['stock_date'] ?? ''),
        'lot_no'             => $lotNo,
        'product_id'         => $productId,
        'product_codesame'   => (string)($row['product_codesame'] ?? ''),
        'access_code'        => (string)($product['access_code'] ?? ''),
        'product_price'      => (float)$row['product_price'],
        'war_hc'             => (string)($product['war_hc'] ?? ''),
        'unit_name'          => (string)($product['unit_name'] ?? ''),
        'product_nameother'  => (string)($row['product_nameother'] ?? ''),
        'ref_id'             => (string)$row['main_ref_id'],
    );
}

echo json_encode(array('success' => true, 'items' => $items), JSON_UNESCAPED_UNICODE);
