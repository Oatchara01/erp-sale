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

$sql = "SELECT b.id AS billing_id, b.customer_id, c.first_name, c.last_name, c.customer_name, c.customer_code, c.customer_coden, b.billing_name AS bill_name, c.cus_tel, b.billing_tel AS bill_tel, b.billing_address AS bill_address, b.billing_ampher AS bill_ampher, b.billing_province AS billl_province, b.billing_postcode AS bill_postcode, b.billing_tax_id AS tax_id, b.billing_branch_no, b.billing_branch_type
        FROM tb_customer_billing_address b
        LEFT JOIN tb_customer c ON b.customer_id = c.customer_id
        WHERE 1";
$types = '';
$params = array();

if ($lastId > 0) {
    $sql .= " AND b.id < ?";
    $types .= 'i';
    $params[] = $lastId;
}

if ($keyword !== '') {
    $sql .= " AND (
        c.customer_name LIKE ?
        OR b.billing_name LIKE ?
        OR c.cus_tel LIKE ?
        OR b.billing_tel LIKE ?
        OR b.billing_tax_id LIKE ?
    )";
    $types .= 'sssss';
    $params = array_merge($params, array(
        $keywordLike,
        $keywordLike,
        $keywordLike,
        $keywordLike,
        $keywordLike
    ));
}

$sql .= " ORDER BY b.id DESC LIMIT ?";
$types .= 'i';
$params[] = $limit + 1;

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    responseJson(array('success' => false, 'message' => 'Cannot prepare billing query'), 500);
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

    $branchText = '';
    if (trim((string)$row['billing_branch_no']) !== '') {
        $branchText = 'สาขา ' . trim((string)$row['billing_branch_no']);
    }

    $billAddressParts = array_filter(array(
        $branchText,
        trim((string)$row['bill_address']),
        trim((string)$row['bill_ampher']),
        trim((string)$row['billl_province']),
        trim((string)$row['bill_postcode'])
    ), function ($value) {
        return $value !== '';
    });

    $customerId = (int)$row['customer_id'];
    $billingId = (int)$row['billing_id'];
    $nextLastId = $billingId;

    $customers[] = array(
        'billing_id' => $billingId,
        'customer_id' => $customerId,
        'customer_name' => $displayName,
        'customer_code' => $row['customer_code'],
        'customer_coden' => $row['customer_coden'],
        'bill_name' => $row['bill_name'],
        'cus_tel' => $displayTel,
        'bill_tel' => $row['bill_tel'],
        'bill_address' => implode(' ', $billAddressParts),
        'tax_id' => $row['tax_id']
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
