<?php

/**
 * ค้นหารายการสินค้าที่ยังยืมได้จากใบ PO สำหรับ modal เอกสาร PO ของ
 * register_breng_brgq.php (ใบยืมตรวจเช็คสินค้า BREQ)
 *
 * Endpoint นี้อ่านอย่างเดียว ห้ามแก้ close_br/ckk_check เพราะถูกเรียกซ้ำ
 * ระหว่างค้นหาได้หลายครั้ง
 */

header('Content-Type: application/json; charset=utf-8');
session_start();

function breq_po_items_fail($message, $statusCode = 400)
{
    http_response_code($statusCode);
    echo json_encode(array('success' => false, 'message' => $message), JSON_UNESCAPED_UNICODE);
    exit;
}

function breq_po_items_success($items)
{
    echo json_encode(array('success' => true, 'items' => $items), JSON_UNESCAPED_UNICODE);
    exit;
}

function breq_po_items_query($connection, $sql)
{
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
        throw new RuntimeException(mysqli_error($connection));
    }
    return $result;
}

function breq_po_items_sql_list($connection, $values)
{
    $quoted = array();
    foreach (array_values(array_unique($values)) as $value) {
        $quoted[] = "'" . mysqli_real_escape_string($connection, (string)$value) . "'";
    }
    return implode(',', $quoted);
}

if (empty($_SESSION['UserID']) && empty($_SESSION['name'])) {
    breq_po_items_fail('กรุณาเข้าสู่ระบบใหม่', 401);
}

$keyword = isset($_REQUEST['q']) ? trim((string)$_REQUEST['q']) : '';
$company = isset($_REQUEST['company']) ? trim((string)$_REQUEST['company']) : '1';
if (!in_array($company, array('1', '2'), true)) {
    $company = '1';
}

$limit = isset($_REQUEST['limit']) ? (int)$_REQUEST['limit'] : 100;
$limit = max(1, min($limit, 200));

require __DIR__ . '/includes/breq_po_items_batch.php';
