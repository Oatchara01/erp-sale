<?php
// Endpoint ค้นหาเอกสารอ้างอิง (ใบสั่งขาย) สำหรับ modal "เอกสารอ้างอิง" ในหน้า register_credinot.php
// โครงสร้าง response/pagination ล้อตาม ajax_customer_popup_search.php เพื่อให้ฝั่ง JS ใช้ pattern เดียวกัน
header('Content-Type: application/json; charset=utf-8');

include "dbconnect.php";

function responseJson($payload, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$keywordLike = '%' . $keyword . '%';
$lastId = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;

if ($limit <= 0) {
    $limit = 20;
}
if ($limit > 50) {
    $limit = 50;
}

// เอาเฉพาะเอกสารที่ออกเลขที่ใบสั่งขายแล้ว (iv_no ไม่ว่าง) เพราะใบลดหนี้ต้องอ้างอิงเลขที่เอกสารเสมอ
$sql = "SELECT s.id, s.iv_no, s.ref_id, s.po_no, s.bill_name, s.bill_address, s.bill_tel, s.sale_code,
               c.salechannel_nameshort
        FROM hos__so s
        LEFT JOIN tb_salechannel c ON s.sale_channel = c.salechannel_ID
        WHERE s.iv_no <> ''";
$types = '';
$params = array();

// keyset pagination: เลื่อนหน้าด้วย id ที่น้อยกว่าแถวสุดท้ายของหน้าก่อน (เรียง DESC)
if ($lastId > 0) {
    $sql .= " AND s.id < ?";
    $types .= 'i';
    $params[] = $lastId;
}

if ($keyword !== '') {
    $sql .= " AND (
        s.iv_no LIKE ?
        OR s.ref_id LIKE ?
        OR s.bill_name LIKE ?
        OR s.bill_tel LIKE ?
    )";
    $types .= 'ssss';
    $params = array_merge($params, array(
        $keywordLike,
        $keywordLike,
        $keywordLike,
        $keywordLike
    ));
}

// ดึงเกินมา 1 แถวเพื่อใช้ตรวจว่ายังมีหน้าถัดไปหรือไม่
$sql .= " ORDER BY s.id DESC LIMIT ?";
$types .= 'i';
$params[] = $limit + 1;

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    responseJson(array('success' => false, 'message' => 'Cannot prepare document query'), 500);
}

mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$rows = array();
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

$hasMore = count($rows) > $limit;
if ($hasMore) {
    array_pop($rows);
}

$docs = array();
$nextLastId = null;

foreach ($rows as $row) {
    $docId = (int)$row['id'];
    $nextLastId = $docId;

    $docs[] = array(
        'id' => $docId,
        'iv_no' => $row['iv_no'],
        'ref_id' => $row['ref_id'],
        'po_no' => $row['po_no'],
        'bill_name' => $row['bill_name'],
        'bill_address' => $row['bill_address'],
        'bill_tel' => $row['bill_tel'],
        'sale_code' => $row['sale_code'],
        'sale_channel_name' => $row['salechannel_nameshort']
    );
}

responseJson(array(
    'success' => true,
    'docs' => $docs,
    'pagination' => array(
        'limit' => $limit,
        'has_more' => $hasMore,
        'next_last_id' => $hasMore ? $nextLastId : null,
        'returned' => count($docs)
    )
));
?>
