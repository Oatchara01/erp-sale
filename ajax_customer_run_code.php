<?php
// คำนวณรหัสลูกค้า AWL/NBM ถัดไปให้การ์ดที่อยู่ออกบิลใน customer_add.php (ไม่บันทึก ดู customer_code_lib.php)
session_start();
include('dbconnect.php');
include('customer_code_lib.php');

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function responseJson($payload, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_SESSION['UserID'])) {
    responseJson(array('success' => false, 'message' => 'กรุณาเข้าสู่ระบบใหม่'), 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responseJson(array('success' => false, 'message' => 'Method not allowed'), 405);
}

if (!isset($conn) || !$conn) {
    responseJson(array('success' => false, 'message' => 'Database connection failed'), 500);
}

$type = isset($_POST['type']) ? (string)$_POST['type'] : '';
if (!in_array($type, array('awl', 'nbm'), true)) {
    responseJson(array('success' => false, 'message' => 'ประเภทรหัสไม่ถูกต้อง'), 400);
}

// รหัสที่การ์ดอื่นในฟอร์มถืออยู่แต่ยังไม่ลงฐาน ต้องข้ามไม่งั้นบิล 2 กับบิล 3 ได้เลขเดียวกัน
$exclude = array();
if (isset($_POST['exclude']) && is_array($_POST['exclude'])) {
    foreach ($_POST['exclude'] as $code) {
        $code = trim((string)$code);
        if ($code !== '') {
            $exclude[] = $code;
        }
    }
}

// แค่คำนวณเลขให้ดู ไปบันทึกจริง (lock + เช็คซ้ำอีกรอบ) ตอน add_customer1.php / edit_customer1.php
$newCode = customer_code_next($conn, $type, $exclude);
if ($newCode === '') {
    responseJson(array('success' => false, 'message' => 'เลขรันของเดือนนี้เต็มแล้ว'), 409);
}

responseJson(array('success' => true, 'code' => $newCode));
