<?php
// ค้นรหัสลูกค้า AWL/NBM เดิมตาม customer_id + เลขผู้เสียภาษี ให้การ์ดออกบิล (อ่านอย่างเดียว ดู customer_code_lib.php)
// ใช้ใน billing_info_add.php และ customer_add.php โหมดแก้ไขผ่าน js/billing-customer-codes.js
// ลูกค้าใหม่ (ยังไม่มี customer_id) ไม่เรียก endpoint นี้ ใช้รหัสร่วมกันเฉพาะการ์ดในฟอร์ม
session_start();

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function billingCodesJson($payload, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function billingCodesError($message, $statusCode)
{
    billingCodesJson(array('success' => false, 'status' => 'error', 'codes' => null, 'candidates' => array(), 'message' => $message), $statusCode);
}

if (empty($_SESSION['UserID'])) {
    billingCodesError('กรุณาเข้าสู่ระบบใหม่', 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    billingCodesError('Method not allowed', 405);
}

include('dbconnect.php');
include('customer_code_lib.php');

if (!isset($conn) || !$conn) {
    billingCodesError('เชื่อมต่อฐานข้อมูลไม่สำเร็จ', 500);
}

$customerIdRaw = isset($_POST['customer_id']) ? trim((string)$_POST['customer_id']) : '';
$billingIdRaw = isset($_POST['billing_id']) ? trim((string)$_POST['billing_id']) : '0';
$tax = customer_code_normalize_tax(isset($_POST['tax_id']) ? $_POST['tax_id'] : '');

if (!ctype_digit($customerIdRaw) || (int)$customerIdRaw <= 0 || ($billingIdRaw !== '' && !ctype_digit($billingIdRaw))) {
    billingCodesError('ข้อมูลไม่ถูกต้อง', 400);
}
if (strlen($tax) !== 13) {
    billingCodesError('เลขประจำตัวผู้เสียภาษีต้องมี 13 หลัก', 400);
}
$customerId = (int)$customerIdRaw;
$billingId = (int)$billingIdRaw;

try {
    $customer = customer_code_load_customer($conn, $customerId);
} catch (mysqli_sql_exception $e) {
    billingCodesError('ตรวจสอบรหัสลูกค้าไม่สำเร็จ กรุณาลองใหม่', 500);
}
if (!$customer) {
    billingCodesError('ไม่พบข้อมูลลูกค้า', 404);
}
if ($billingId > 0 && !isset($customer['billings'][$billingId])) {
    billingCodesError('ไม่พบข้อมูลออกบิลนี้ของลูกค้า', 404);
}

// แก้บิลเดิมโดย tax ไม่เปลี่ยน: คงรหัสที่บิลถืออยู่ หาเฉพาะคู่ที่เติมช่องว่างได้ ไม่นับแหล่งของบิลตัวเอง
$base = customer_code_card_base($customer, array('record_id' => $billingId, 'source_key' => '', 'tax' => $tax));
$lookup = customer_code_lookup($customer, $tax, $base['codes'], $base['exclude']);

$messages = array(
    'matched' => 'พบรหัสลูกค้าเดิม',
    'not_found' => 'ไม่พบรหัสลูกค้าเดิมของเลขผู้เสียภาษีนี้',
    'excluded' => 'เลขผู้เสียภาษีนี้ไม่ใช้ค้นรหัสร่วมกัน',
    'conflict' => 'พบรหัสลูกค้าหลายชุด กรุณาเลือก',
);

billingCodesJson(array(
    'success' => true,
    'status' => $lookup['status'],
    'codes' => $lookup['codes'],
    'candidates' => $lookup['candidates'],
    'message' => $messages[$lookup['status']],
));
