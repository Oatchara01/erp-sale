<?php
// Endpoint ค้นหาสินค้าสำหรับ modal "เพิ่มสินค้า" ในหน้า register_credinot.php (โหมดแก้ไข/สร้างแบบไม่มี SO อ้างอิง)
// โครงสร้าง response/pagination ล้อตาม ajax_credinot_doc_search.php เพื่อให้ฝั่ง JS ใช้ pattern เดียวกัน
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

$sql = "SELECT product_id, access_code, sol_name, unit_name, sol_price
        FROM tb_product
        WHERE 1";
$types = '';
$params = array();

if ($lastId > 0) {
    $sql .= " AND product_id < ?";
    $types .= 'i';
    $params[] = $lastId;
}

if ($keyword !== '') {
    $sql .= " AND (
        access_code LIKE ?
        OR sol_name LIKE ?
    )";
    $types .= 'ss';
    $params = array_merge($params, array(
        $keywordLike,
        $keywordLike
    ));
}

$sql .= " ORDER BY product_id DESC LIMIT ?";
$types .= 'i';
$params[] = $limit + 1;

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    responseJson(array('success' => false, 'message' => 'Cannot prepare product query'), 500);
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

$products = array();
$nextLastId = null;

foreach ($rows as $row) {
    $productId = (int)$row['product_id'];
    $nextLastId = $productId;

    $products[] = array(
        'product_id' => $row['product_id'],
        'access_code' => $row['access_code'],
        'sol_name' => $row['sol_name'],
        'unit_name' => $row['unit_name'],
        'sol_price' => $row['sol_price']
    );
}

responseJson(array(
    'success' => true,
    'products' => $products,
    'pagination' => array(
        'limit' => $limit,
        'has_more' => $hasMore,
        'next_last_id' => $hasMore ? $nextLastId : null,
        'returned' => count($products)
    )
));
?>
