<?php

include"dbconnect.php";
//include"dbconnect_sale.php";
include "databaseshopee.php";
include "shopeeAPI.php";

$running = 12;
$shop_id = '24017696';
$shopId = '24017696';
$partner_id = '2007594';
$partner_key = 'shpk6d4e6b6c4d744162716f4147625073594c645a4377685550774e67457266';
$partnerId = '2007594';
$partnerKey = "shpk6d4e6b6c4d744162716f4147625073594c645a4377685550774e67457266";


// ===== FUNCTION: ดึง Access Token (ตามของคุณ) =====

$refreshToken = getRefreshTokenFromDB($running);

if ($refreshToken) {
    $shopId = 24017696; 
    $ret = getAccessTokenShopLevel($partnerId, $partnerKey, $shopId, $refreshToken);

    if ($ret) {
       updateShopToken($ret, $running);
    }
} else {
    echo "Error: ไม่พบ Refresh Token ในฐานข้อมูลสำหรับ running ID: " . $running;
}

$accessToken1 = getTokenFromDB($running);
$accessToken = base64_decode($accessToken1);




//$orderSn = "25090929MBFDS2";
//processShopeeOrderPickupToday1PM($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);


/*function getShippingDocumentParameter($accessToken, $partnerId, $shopId, $partnerKey, $orderList) {
    $timestamp = time();
    $path = "/api/v2/logistics/get_shipping_document_parameter";

    $sign = generateShopeeSign($partnerKey, $partnerId, $path, $timestamp, $accessToken, $shopId);

    $url = "https://partner.shopeemobile.com$path"
         . "?access_token={$accessToken}"
         . "&partner_id={$partnerId}"
         . "&shop_id={$shopId}"
         . "&sign={$sign}"
         . "&timestamp={$timestamp}";

    $payload = json_encode(['order_list' => $orderList]);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $error = curl_error($curl);
        curl_close($curl);
        return ['error' => true, 'message' => $error];
    }

    curl_close($curl);
    return json_decode($response, true);
}




function createShippingDocument($accessToken, $partnerId, $shopId, $partnerKey, $orderList) {
    $timestamp = time();
    $path = "/api/v2/logistics/create_shipping_document";
    $sign = generateShopeeSign($partnerKey, $partnerId, $path, $timestamp, $accessToken, $shopId);

    $url = "https://partner.shopeemobile.com$path"
         . "?access_token=$accessToken"
         . "&partner_id=$partnerId"
         . "&shop_id=$shopId"
         . "&sign=$sign"
         . "&timestamp=$timestamp";

    $payload = json_encode(['order_list' => $orderList]);

    echo "<pre>🔍 Payload ที่ส่งไป:\n";
    print_r($payload);
    echo "</pre>";

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}



function getShippingDocumentResult($accessToken, $partnerId, $shopId, $partnerKey, $orderList) {
    $timestamp = time();
    $path = "/api/v2/logistics/get_shipping_document_result";

    $sign = generateShopeeSign($partnerKey, $partnerId, $path, $timestamp, $accessToken, $shopId);

    $url = "https://partner.shopeemobile.com$path"
         . "?access_token=$accessToken"
         . "&partner_id=$partnerId"
         . "&shop_id=$shopId"
         . "&sign=$sign"
         . "&timestamp=$timestamp";

    $payload = json_encode(["order_list" => $orderList]);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo "cURL Error: " . curl_error($curl);
        curl_close($curl);
        return null;
    }

    curl_close($curl);

    return json_decode($response, true);
}


function downloadShippingDocument($accessToken, $partnerId, $shopId, $partnerKey, $orderList) {
    $timestamp = time();
    $path = "/api/v2/logistics/download_shipping_document";

    $sign = generateShopeeSign($partnerKey, $partnerId, $path, $timestamp, $accessToken, $shopId);

    $url = "https://partner.shopeemobile.com$path"
         . "?access_token=$accessToken"
         . "&partner_id=$partnerId"
         . "&shop_id=$shopId"
         . "&sign=$sign"
         . "&timestamp=$timestamp";

    $payload = json_encode([
        "order_list" => $orderList,
        "shipping_document_type" => "NORMAL_AIR_WAYBILL" // ใส่ตรงนี้สำคัญ
    ]);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}



function waitForDownloadUrl($accessToken, $partnerId, $shopId, $partnerKey, $orderList, $maxRetry = 5) {
    $attempt = 0;
    $url = null;

    while ($attempt < $maxRetry) {
        $response = downloadShippingDocument($accessToken, $partnerId, $shopId, $partnerKey, $orderList);

        echo "<pre>📥 Attempt " . ($attempt + 1) . ":\n";
        print_r($response);
        echo "</pre>";

        if (!empty($response['response']['file_url'])) {
            $url = $response['response']['file_url'];
            break;
        }

        $attempt++;
        sleep(2); // รอ 2 วินาทีแล้วค่อยลองใหม่
    }

    return $url;
}






$strSQL = "SELECT order_id, order_item_id, order_refer_code FROM so__main WHERE order_id='250617RBTMVY5P'";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");

$orderList = [];

while ($row = mysqli_fetch_assoc($objQuery)) {
    $orderItem = [
        "order_sn" => $row["order_id"],
        "package_number" => $row["order_item_id"]
    ];

    // ✅ ลบช่องว่างหลัง key
    if (!empty($row["order_refer_code"])) {
        $orderItem["tracking_number"] = $row["order_refer_code"];
    }

    $orderList[] = $orderItem;
}

// STEP 1: เรียก parameter
$paramResponse = getShippingDocumentParameter($accessToken, $partnerId, $shopId, $partnerKey, $orderList);

echo "<pre>Shipping Document Parameter:\n";
print_r($paramResponse);
echo "</pre>";

// STEP 2: สร้าง orderList ที่มี shipping_document_type
$orderListWithType = [];

foreach ($paramResponse['response']['result_list'] as $item) {
    // ค้นหา tracking_number เดิมจาก $orderList
    $tracking = null;
    foreach ($orderList as $o) {
        if ($o['order_sn'] == $item['order_sn']) {
            $tracking = $o['tracking_number'] ?? null;
            break;
        }
    }

    $order = [
        "order_sn" => $item["order_sn"],
        "package_number" => $item["package_number"],
        "shipping_document_type" => $item["suggest_shipping_document_type"]
    ];

    if ($tracking) {
        $order["tracking_number"] = $tracking;
    }

    $orderListWithType[] = $order;
}

// STEP 3: เรียก API สร้างใบปะหน้า
$response = createShippingDocument($accessToken, $partnerId, $shopId, $partnerKey, $orderListWithType);

/*echo "<pre>📦 ผลลัพธ์จาก Shopee:\n";
print_r($response);
echo "</pre>";*/


//$response = getShippingDocumentResult($accessToken, $partnerId, $shopId, $partnerKey, $orderList);

/*echo "<pre>📄 Shipping Document Result:\n";
print_r($response);
echo "</pre>";*/

/*sleep(2);

$fileUrl = waitForDownloadUrl($accessToken, $partnerId, $shopId, $partnerKey, $orderList);

if ($fileUrl) {
    echo "<p>✅ ใบปะหน้าพร้อมดาวน์โหลดแล้ว: <a href=\"$fileUrl\" target=\"_blank\">คลิกที่นี่เพื่อดาวน์โหลด PDF</a></p>";
} else {
    echo "<p>❌ Shopee ยังไม่ส่งลิงก์ใบปะหน้ากลับมา กรุณาลองใหม่ภายหลัง</p>";
}*/

?>