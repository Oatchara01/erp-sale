<?php
include('dbconnect.php');

header('Content-Type: application/json; charset=utf-8');

function responseJson($payload, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isset($conn) || !$conn) {
    responseJson(array('success' => false, 'addresses' => array(), 'message' => 'Database connection failed'), 500);
}

$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$keywordLike = '%' . $keyword . '%';
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$lastId = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;
$customerId = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : 0;

if ($limit <= 0) {
    $limit = 20;
}
if ($limit > 100) {
    $limit = 100;
}

if ($customerId <= 0) {
    responseJson(array('success' => false, 'addresses' => array(), 'message' => 'customer_id is required'), 400);
}

$sql = "
    SELECT
        s.id AS row_id,
        s.id AS row_sort_id,
        c.customer_id,
        c.customer_code,
        c.customer_name,
        c.cus_tel AS customer_tel,
        s.shipping_preface_name AS preface_name,
        s.shipping_name,
        s.shipping_tel,
        s.shipping_address,
        s.shipping_ampher,
        s.shipping_province,
        s.shipping_postcode,
        s.install_location
    FROM tb_customer_shipping_address s
    JOIN tb_customer c ON s.customer_id = c.customer_id
    WHERE c.close_ckk='0'
        AND c.customer_id = ?";

$types = 'i';
$params = array($customerId);

if ($keyword !== '') {
    $sql .= "
        AND (
            c.customer_name LIKE ?
            OR c.customer_code LIKE ?
            OR c.cus_tel LIKE ?
            OR s.shipping_preface_name LIKE ?
            OR s.shipping_name LIKE ?
            OR s.shipping_tel LIKE ?
            OR s.shipping_address LIKE ?
            OR s.shipping_ampher LIKE ?
            OR s.shipping_province LIKE ?
            OR s.shipping_postcode LIKE ?
        )";
    $types .= 'ssssssssss';
    $params = array_merge($params, array(
        $keywordLike,
        $keywordLike,
        $keywordLike,
        $keywordLike,
        $keywordLike,
        $keywordLike,
        $keywordLike,
        $keywordLike,
        $keywordLike,
        $keywordLike
    ));
}

if ($lastId > 0) {
    $sql .= "
        AND s.id < ?";
    $types .= 'i';
    $params[] = $lastId;
}

$sql .= "
    ORDER BY s.id DESC
    LIMIT ?";
$types .= 'i';
$params[] = $limit + 1;

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    responseJson(array('success' => false, 'addresses' => array(), 'message' => 'Cannot prepare shipping query'), 500);
}

mysqli_stmt_bind_param($stmt, $types, ...$params);

if (!mysqli_stmt_execute($stmt)) {
    responseJson(array('success' => false, 'addresses' => array(), 'message' => 'Cannot execute shipping query'), 500);
}

$query = mysqli_stmt_get_result($stmt);
$rows = array();
while ($row = mysqli_fetch_assoc($query)) {
    $parts = array();
    if (!empty($row['shipping_address'])) $parts[] = $row['shipping_address'];
    if (!empty($row['shipping_ampher'])) $parts[] = $row['shipping_ampher'];
    if (!empty($row['shipping_province'])) $parts[] = $row['shipping_province'];
    if (!empty($row['shipping_postcode'])) $parts[] = $row['shipping_postcode'];
    $row['shipping_full_address'] = trim(implode(' ', $parts));
    $rows[] = $row;
}

$hasMore = count($rows) > $limit;
if ($hasMore) {
    $rows = array_slice($rows, 0, $limit);
}

$nextLastId = null;
if (!empty($rows)) {
    $lastRow = $rows[count($rows) - 1];
    $nextLastId = isset($lastRow['row_id']) ? $lastRow['row_id'] : null;
}

responseJson(array(
    'success' => true,
    'addresses' => $rows,
    'pagination' => array(
        'limit' => $limit,
        'has_more' => $hasMore,
        'next_last_id' => $hasMore ? $nextLastId : null,
        'returned' => count($rows)
    )
));
