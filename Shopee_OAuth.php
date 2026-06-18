<?php 
/*function getAccessToken($code, $partnerId, $partnerKey, $shopId) {
    $host = "https://partner.shopeemobile.com";
    $path = "/api/v2/auth/token/get";
    $timestamp = time();
    $baseString = sprintf("%s%s%s%s", $partnerId, $code, $shopId, $timestamp);
    $sign = hash_hmac('sha256', $baseString, $partnerKey);

    $postData = json_encode([
        "code" => $code,
        "partner_id" => $partnerId,
        "shop_id" => $shopId,
        "timestamp" => $timestamp
    ]);

    // Add partner_id, timestamp, and sign to the URL query string
    $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $host, $path, $partnerId, $timestamp, $sign);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($postData)
    ));

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

$code = "4b78536776726243794c5a7762694772";
$shopId = 24017696;
$partnerId = 2007594;
$partnerKey = "55545565657347696252734e79556564616842614971476c6b784d6f74494342";

$response = getAccessToken($code, $partnerId, $partnerKey, $shopId);
echo $response;*/

?>


<?php
// ตั้งค่า error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ตรวจสอบ OpenSSL
if (!extension_loaded('openssl')) {
    die("OpenSSL extension is not loaded. Please enable it in your PHP configuration.");
}

// ตั้งค่า timezone เป็น UTC
date_default_timezone_set('UTC');

// ข้อมูลการเชื่อมต่อสำหรับ OAuth
$partner_id = 2007594;
$redirect_url = 'https://sol.allwellcenter.com/api_shopee.php';
$api_key = 'shpk6d4e6b6c4d744162716f4147625073594c645a4377685550774e67457266';

// ใช้เวลา UTC
$timestamp = time();

// แสดงข้อมูล timestamp บนเซิร์ฟเวอร์
echo "Current server UTC time: " . gmdate('Y-m-d H:i:s', $timestamp) . "\n";

// Path สำหรับ OAuth
$path = '/api/v2/shop/auth_partner';

// สร้างข้อมูลสำหรับการคำนวณ signature
$base_string = $partner_id . $path . $timestamp;

// คำนวณ signature ด้วย HMAC-SHA256 และใช้ bin2hex
$sign = bin2hex(hash_hmac('sha256', $base_string, $api_key, true));

// สร้าง URL สำหรับให้ผู้ใช้ยินยอมการเข้าถึง
$auth_url = 'https://partner.shopeemobile.com' . $path . 
    '?partner_id=' . $partner_id . 
    '&timestamp=' . $timestamp .  // ใช้ timestamp ที่ถูกต้อง
    '&sign=' . $sign . 
    '&redirect=' . rawurlencode($redirect_url);

// แสดงข้อมูลสำหรับการตรวจสอบ
//echo "PHP Version: " . PHP_VERSION . "\n";
//echo "OpenSSL Version: " . OPENSSL_VERSION_TEXT . "\n";
//echo "Generated Sign: " . $sign . "\n";
//echo "timestamp: " . $timestamp . "\n";
//echo "Generated URL: " . $auth_url . "\n";

// ส่งผู้ใช้ไปยัง URL ที่สร้าง (ปิดการใช้งานชั่วคราวเพื่อตรวจสอบ)
 header('Location: ' . $auth_url);
// exit();


?>
