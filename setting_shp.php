<?php
include "dbconnect.php";

$partner_id = '2007594';
$partner_key = '676f4c4d6355616247747459527473416542656464545052756253415061725a';
$shop_id = '24017696'; // ใส่ Shop ID ของคุณ
$authorization_code = '4871586f50516a7067626d484473637a'; // ใส่ Authorization Code ที่ได้รับจากการทำ OAuth

$timestamp = time();
$base_string = $partner_id . $shop_id . $authorization_code . $timestamp; // ประกอบ base string
$sign = hash_hmac('sha256', $base_string, $partner_key);

$data = [
    'partner_id' => $partner_id,
    'shop_id' => $shop_id,
    'code' => $authorization_code,
    'sign' => $sign,
    'timestamp' => $timestamp,
];

// แปลงพารามิเตอร์เป็น URL-encoded query string
$query_string = http_build_query($data);

echo "Base String: " . $base_string . "\n";
echo "Sign: " . $sign . "\n";
echo "Request URL: " . "https://partner.shopeemobile.com/api/v2/auth/token/get?$query_string\n";

$ch = curl_init("https://partner.shopeemobile.com/api/v2/auth/token/get?$query_string");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);

$result = curl_exec($ch);
if ($result === false) {
    die('Error fetching tokens: ' . curl_error($ch));
}
$response = json_decode($result, true);

curl_close($ch);

if (isset($response['access_token']) && isset($response['refresh_token'])) {
    $access_token = $response['access_token'];
    $refresh_token = $response['refresh_token'];

    echo "Access Token: $access_token\n";
    echo "Refresh Token: $refresh_token\n";

    // บันทึก Access Token และ Refresh Token ลงในฐานข้อมูล
    $add_date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO shopToken (access_token, refresh_token, updateTime) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $bind = $stmt->bind_param("sss", $access_token, $refresh_token, $add_date);
    if ($bind === false) {
        die('Bind failed: ' . htmlspecialchars($stmt->error));
    }

    $exec = $stmt->execute();
    if ($exec) {
        echo "<script language=\"JavaScript\">";
        echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='main_admin.php'";
        echo "</script>";
    } else {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
} else {
    echo "Error fetching tokens: " . htmlspecialchars(json_encode($response));
}

$conn->close();
?>
