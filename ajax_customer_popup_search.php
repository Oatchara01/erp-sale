<?php
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

$sql = "SELECT c.customer_id, c.first_name, c.last_name, c.customer_name, c.bill_name, c.cus_tel, c.bill_tel, c.cus_address,
               c.cus_ampher, c.cus_province, c.cus_postcode, c.customer_no, c.type_customer, c.credit_thb, c.credit_ckk, c.status_cus, c.vip_ckk, t.type_name
        FROM tb_customer c
        LEFT JOIN tb_typecustomer t ON c.type_customer = t.type_id
        WHERE 1";
$types = '';
$params = array();

if ($lastId > 0) {
    $sql .= " AND c.customer_id < ?";
    $types .= 'i';
    $params[] = $lastId;
}

if ($keyword !== '') {
    $sql .= " AND (
        c.customer_name LIKE ?
        OR c.cus_tel LIKE ?
        OR c.customer_no LIKE ?
    )";
    $types .= 'sss';
    $params = array_merge($params, array(
        $keywordLike,
        $keywordLike,
        $keywordLike
    ));
}

$sql .= " ORDER BY c.customer_id DESC LIMIT ?";
$types .= 'i';
$params[] = $limit + 1;

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    responseJson(array('success' => false, 'message' => 'Cannot prepare customer query'), 500);
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

$customers = array();
$nextLastId = null;

foreach ($rows as $row) {
    $nameParts = trim($row['first_name'] . ' ' . $row['last_name']);
    $displayName = $nameParts !== '' ? $nameParts : $row['customer_name'];
    if ($displayName === '' || $displayName === null) {
        $displayName = $row['bill_name'];
    }

    $displayTel = $row['cus_tel'];
    if ($displayTel === '' || $displayTel === null) {
        $displayTel = $row['bill_tel'];
    }

    $customerId = (int)$row['customer_id'];
    $nextLastId = $customerId;

    $customers[] = array(
        'customer_id' => $customerId,
        'customer_name' => $displayName,
        'bill_name' => $row['bill_name'],
        'cus_tel' => $displayTel,
        'cus_address' => $row['cus_address'],
        'cus_ampher' => $row['cus_ampher'],
        'cus_province' => $row['cus_province'],
        'cus_postcode' => $row['cus_postcode'],
        'customer_no' => $row['customer_no'],
        'type_customer' => $row['type_customer'],
        'type_name' => $row['type_name'],
        'credit_thb' => $row['credit_thb'],
        'credit_ckk' => $row['credit_ckk'],
        'status_cus' => $row['status_cus'],
        'vip_ckk' => $row['vip_ckk']
    );
}

responseJson(array(
    'success' => true,
    'customers' => $customers,
    'pagination' => array(
        'limit' => $limit,
        'has_more' => $hasMore,
        'next_last_id' => $hasMore ? $nextLastId : null,
        'returned' => count($customers)
    )
));
?>
