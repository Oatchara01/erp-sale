<?php
include('dbconnect.php');

header('Content-Type: application/json; charset=utf-8');

function normalizeThaiName($text) {
    $text = trim($text);

    // ลบ zero-width และอักขระแฝงที่พบบ่อย
    $text = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);

    // แปลงช่องว่างทุกชนิดให้เป็น space ปกติ
    $text = preg_replace('/[\p{Z}\s]+/u', ' ', $text);

    // trim อีกรอบ
    $text = trim($text);

    return $text;
}

$name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';
$name = normalizeThaiName($name);
$customerId = isset($_POST['customer_id']) ? (int)$_POST['customer_id'] : 0;

// เอาช่องว่างออกทั้งหมดเพื่อใช้เทียบ
$compareName = preg_replace('/\s+/u', '', $name);

$response = [
    'exists' => false,
    'count' => 0,
    'names' => []
];

if ($compareName !== '') {
    $safeCompare = mysqli_real_escape_string($conn, $compareName);
    $customerFilter = $customerId > 0 ? " AND customer_id != {$customerId}" : "";
    $sql = "SELECT customer_id, customer_name
            FROM tb_customer
            WHERE REPLACE(REPLACE(REPLACE(customer_name, ' ', ''), '\r', ''), '\n', '') LIKE '%{$safeCompare}%'
            {$customerFilter}
            ORDER BY customer_name ASC
            LIMIT 10";

    $result = mysqli_query($conn, $sql);

    $names = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $names[] = $row['customer_name'];
        }
    }

    $response['count'] = count($names);
    $response['exists'] = count($names) > 0;
    $response['names'] = $names;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
