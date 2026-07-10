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
$dept = isset($_GET['dept']) && $_GET['dept'] === 'eng' ? 'eng' : 'sale';
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;

if ($limit <= 0) {
    $limit = 20;
}
if ($limit > 50) {
    $limit = 50;
}

$deptCondition = $dept === 'eng' ? "engineer_ckk = '1'" : "sale_ckk = '1'";

$sql = "SELECT product_ID, access_code, access_name, sol_name, unit_name
        FROM tb_product
        WHERE $deptCondition
          AND demo_ckk = '0'
          AND type_company = 'AWL'
          AND close_pro = '0'";
$types = '';
$params = array();

if ($keyword !== '') {
    $sql .= " AND (access_code LIKE ? OR access_name LIKE ? OR sol_name LIKE ?)";
    $types .= 'sss';
    $params[] = $keywordLike;
    $params[] = $keywordLike;
    $params[] = $keywordLike;
}

$sql .= " ORDER BY access_code ASC LIMIT ?";
$types .= 'i';
$params[] = $limit;

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    responseJson(array('success' => false, 'message' => 'Cannot prepare product query'), 500);
}

mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $displayName = $row['sol_name'] !== '' && $row['sol_name'] !== null ? $row['sol_name'] : $row['access_name'];
    $products[] = array(
        'product_id' => $row['product_ID'],
        'product_code' => $row['access_code'],
        'product_name' => $displayName,
        'unit_name' => $row['unit_name']
    );
}

responseJson(array(
    'success' => true,
    'products' => $products
));
?>
