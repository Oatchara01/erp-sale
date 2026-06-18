<?php

include "dbconnect.php";

function saveOrderToDatabase($conn, $order) {
    $orderId = $order['order_id'];
    $shopId = $order['shop_id'];
    $status = $order['order_status'];
    $createTime = $order['create_time'];
    $updateTime = isset($order['update_time']) ? $order['update_time'] : $createTime;

    $stmt = $conn->prepare("INSERT INTO orders (order_id, shop_id, status, create_time, update_time) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE status = VALUES(status), update_time = VALUES(update_time)");
    $stmt->bind_param("sissi", $orderId, $shopId, $status, $createTime, $updateTime);
    $stmt->execute();
    $stmt->close();
}

$curl = curl_init();

$strSQL = "SELECT * FROM shopee__tokens WHERE sale_channel='12'";
$objQuery = mysqli_query($conn,$strSQL) or die("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);




$accessToken = $objResult["access_token"]; // ใส่ Access Token ที่คุณได้มา
$partnerId = $objResult["part_id"];//ใส่ Partner ID ของคุณ
$shopId = $objResult["shopId"]; // ใส่ Shop ID ของคุณ
$sign = $objResult["sign"]; // ใส่ Signature ที่ได้มาจากการคำนวณ
$timestamp = time();

$url = "https://partner.shopeemobile.com/api/v2/order/get_order_list?access_token=$accessToken&cursor=%22%22&order_status=READY_TO_SHIP&page_size=20&partner_id=$partnerId&response_optional_fields=order_status&shop_id=$shopId&sign=$sign&time_from=1607235072&time_range_field=create_time&time_to=1608271872&timestamp=$timestamp";

curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);

curl_close($curl);

$orders = json_decode($response, true);

// ตรวจสอบว่ามีคำสั่งซื้อหรือไม่
if (isset($orders['response']['order_list'])) {
    foreach ($orders['response']['order_list'] as $order) {
        // บันทึกคำสั่งซื้อแต่ละอันลงในฐานข้อมูล

echo $orderId;


        saveOrderToDatabase($conn, $order);
    }
} else {
    echo "No orders found or an error occurred.";
}

$conn->close();


?>
