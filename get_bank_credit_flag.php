<?php
header('Content-Type: application/json; charset=utf-8');

require_once 'dbconnect_acc.php';

$bankId = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($bankId === '') {
    echo json_encode(array(
        'success' => false,
        'message' => 'missing_bank_id'
    ));
    exit;
}

$bankIdEscaped = mysqli_real_escape_string($code, $bankId);
$sql = "SELECT id, credit_ckk FROM tb_bank WHERE id = '{$bankIdEscaped}' LIMIT 1";
$query = mysqli_query($code, $sql);

if (!$query) {
    echo json_encode(array(
        'success' => false,
        'message' => 'query_failed'
    ));
    exit;
}

$row = mysqli_fetch_assoc($query);
if (!$row) {
    echo json_encode(array(
        'success' => false,
        'message' => 'not_found'
    ));
    exit;
}

echo json_encode(array(
    'success' => true,
    'id' => (string)$row['id'],
    'credit_ckk' => (string)$row['credit_ckk']
));
