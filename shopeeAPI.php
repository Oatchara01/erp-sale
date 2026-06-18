<?php

include_once('global.php');
include_once('signature.php');
include_once('postrequest.php');
include_once('dbconnect.php');



use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//$partnerKey = "55545565657347696252734e79556564616842614971476c6b784d6f74494342";
//$partner_key = '55545565657347696252734e79556564616842614971476c6b784d6f74494342';

$shop_id = '24017696';
$shopId = '24017696';

$partner_id = '2007594';
$partnerId = '2007594';

$partnerKey = "shpk6d4e6b6c4d744162716f4147625073594c645a4377685550774e67457266";
$partner_key = "shpk6d4e6b6c4d744162716f4147625073594c645a4377685550774e67457266";

$host = 'https://partner.shopeemobile.com';
$timestamp = time();
$contentType = 'Content-Type: application/json';


function getAccessToken($code)
{
    global $partner_key, $partner_id, $host, $timestamp, $shop_id;

    $path = '/api/v2/auth/token/get';

    try {
        $signGenerator = new SignGenerator();
        $sign = $signGenerator->generateSignAuth($partner_key, $partner_id, $path, $timestamp);

        $endpoint = sprintf("%s%s?partner_id=%s&timestamp=%d&sign=%s", $host, $path, $partner_id, $timestamp, $sign);

        // สร้าง Payload ข้อมูลที่ต้องส่งไป (แก้ไขส่วนนี้)
        $data = json_encode([
            "code" => $code,
            "partner_id" => (int)$partner_id,
            "shop_id" => (int)$shop_id   // เปลี่ยนจากข้อความให้เป็นตัวเลข (integer)
        ]);

        $postRequest = new PostRequest();
        $contentType = "application/json";
        
        $response = $postRequest->Post($endpoint, $data, $contentType, 'POST');
        
        $obj = json_decode($response, true);
        
        if (isset($obj['access_token'])) {
            return $obj; // ส่งคืนค่า $obj ถ้ามี access_token
        } else {
            throw new Exception("Failed to retrieve access token. Response: " . $response);
        }

    } catch (Exception $e) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => $e->getMessage()]);
        return null;
    }
}
	


function getAccessTokenShopLevel($partnerId, $partnerKey, $shopId, $refreshToken)
{
   global $host;

    $path = "/api/v2/auth/access_token/get";
    $timest = time();
    $baseString = sprintf("%s%s%d", $partnerId, $path, $timest);
    $sign = hash_hmac('sha256', $baseString, $partnerKey);

    $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $host, $path, $partnerId, $timest, $sign);

    // ตรวจสอบ URL และ Payload ที่ส่งไปยัง Shopee API
    //echo "Generated URL: " . $url . "<br>";

    $body = array(
        "partner_id" => (int)$partnerId,
        "shop_id" => (int)$shopId,
        "refresh_token" => $refreshToken
    );

    //echo "Payload Data: " . json_encode($body) . "<br>";

    $c = curl_init($url);
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($c);
    if (curl_errno($c)) {
        echo "Curl Error: " . curl_error($c) . "<br>";
        return null;
    }
    curl_close($c);

    $ret = json_decode($result, true);

    if (isset($ret["access_token"])) {
        //echo "New Access Token: " . $ret["access_token"] . "<br>";
        //echo "New Refresh Token: " . $ret["refresh_token"] . "<br>";
        return $ret;
    } else {
        echo "Error: Failed to refresh token. Response: " . $result . "<br>";
        return null;
    }
}




function getOrders($accessToken, $params)
{
    global $partner_key, $partner_id, $host, $timestamp, $shop_id, $page_size;

    $path = '/api/v2/order/get_order_list';

    try {
        $signGenerator = new SignGenerator();
        $sign = $signGenerator->generateSign($partner_key, $partner_id, $path, $timestamp, $accessToken, $shop_id);

        $time_range_field = $params['time_range_field'] ?? 'create_time';
        $time_from = $params['time_from'] ?? strtotime('-7 days');
        $time_to = $params['time_to'] ?? time();

        $request_para_option = '';

        if (isset($params['order_status']) && !empty($params['order_status'])) {
            $request_para_option .= '&order_status=' . $params['order_status'];
        }

        if (isset($params['cursor']) && !empty($params['cursor'])) {
            $request_para_option .= '&cursor=' . $params['cursor'];
        }

        if (isset($params['offset'])) {
            $request_para_option .= '&offset=' . $params['offset'];
        }

        $endpoint = sprintf(
            "%s%s?partner_id=%s&timestamp=%d&access_token=%s&shop_id=%s&sign=%s&time_range_field=%s&time_from=%d&time_to=%d&page_size=%d%s",
            $host,
            $path,
            $partner_id,
            $timestamp,
            $accessToken,
            $shop_id,
            $sign,
            $time_range_field,
            $time_from,
            $time_to,
            $page_size,
            $request_para_option
        );

        $postRequest = new PostRequest();
        $contentType = "application/json";
        $response = $postRequest->Post($endpoint, '', $contentType, 'GET');

        return $response;

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// ---------------------------------------------------------------------------
// Function: getOrderItems
function getOrderItems($accessToken, $params)
{
    global $partner_key, $partner_id, $host, $timestamp, $shop_id;

    $path = '/api/v2/order/get_order_detail';
    $option_field = 'recipient_address,item_list,package_list,invoice_data,total_amount,payment_method,estimated_shipping_fee,actual_shipping_fee,actual_shipping_fee_confirmed,checkout_shipping_carrier,reverse_shipping_fee';

    try {
        $signGenerator = new SignGenerator();
        $sign = $signGenerator->generateSign($partner_key, $partner_id, $path, $timestamp, $accessToken, $shop_id);

        if (!isset($params['order_sn_list']) || empty($params['order_sn_list'])) {
            throw new Exception("order_sn_list is required.");
        }

        $order_sn_list = implode(',', $params['order_sn_list']);

        $endpoint = sprintf(
            "%s%s?order_sn_list=%s&response_optional_fields=%s&partner_id=%s&timestamp=%d&access_token=%s&shop_id=%s&sign=%s",
            $host,
            $path,
            $order_sn_list,
            $option_field,
            $partner_id,
            $timestamp,
            $accessToken,
            $shop_id,
            $sign
        );

        $postRequest = new PostRequest();
        $contentType = "application/json";
        $response = $postRequest->Post($endpoint, '', $contentType, 'GET');

        // 👇 แปลงเป็น array เพื่อดึง request_id มาแสดง
        $data = json_decode($response, true);
        if (isset($data['request_id'])) {
            echo "📎 request_id: " . $data['request_id'] . "\n";
        }

        return $response;

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(["error" => $e->getMessage()]);
    }
}


function searchPackageList($accessToken, $filters = [], $pagination = [], $sort = [])
{
    global $partner_key, $partner_id, $host, $shop_id;

    $path = '/api/v2/order/search_package_list';
    $timestamp = time();

    try {
        $signGenerator = new SignGenerator();
        $sign = $signGenerator->generateSign(
            $partner_key,
            $partner_id,
            $path,
            $timestamp,
            $accessToken,
            $shop_id
        );

        $endpoint = sprintf(
            "%s%s?access_token=%s&partner_id=%s&shop_id=%s&sign=%s&timestamp=%d",
            $host,
            $path,
            $accessToken,
            $partner_id,
            $shop_id,
            $sign,
            $timestamp
        );

        $body = [
            'filter' => $filters,
            'pagination' => [
                'cursor' => $pagination['cursor'] ?? "",
                'page_size' => $pagination['page_size'] ?? 20
            ],
            'sort' => [
                'ascending' => $sort['ascending'] ?? false,
                'sort_type' => $sort['sort_type'] ?? 1
            ]
        ];

        $postRequest = new PostRequest();
        $contentType = "application/json";
        $response = $postRequest->Post(
            $endpoint,
            json_encode($body, JSON_UNESCAPED_UNICODE),
            $contentType,
            'POST'
        );

        return $response;

    } catch (Exception $e) {
        http_response_code(400);
        return json_encode([
            "error" => $e->getMessage()
        ]);
    }
}



function getBuyerInvoiceInfo($partnerId, $partnerKey, $shopId, $accessToken, $orderSn, $useUAT = false) {
    $path = '/api/v2/order/get_buyer_invoice_info';
    $timestamp = time();

    // ===== สร้าง Sign =====
    $base_string = $partnerId . $path . $timestamp . $accessToken . $shopId;
    $sign = hash_hmac('sha256', $base_string, $partnerKey);

    // ===== URL =====
    $baseURL = $useUAT 
        ? 'https://partner.uat.shopeemobile.com' 
        : 'https://partner.shopeemobile.com';

    $url = "{$baseURL}{$path}?access_token={$accessToken}&partner_id={$partnerId}&shop_id={$shopId}&sign={$sign}&timestamp={$timestamp}";

    // ===== Prepare CURL =====
    $curl = curl_init();

    $postData = array(
        "queries" => array(
            array("order_sn" => $orderSn)
        )
    );

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($postData),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        return array(
            'success' => false,
            'http_code' => $httpCode,
            'error' => $error,
            'response' => null
        );
    }

    $responseData = json_decode($response, true);

    return array(
        'success' => $httpCode === 200 && empty($responseData['error']),
        'http_code' => $httpCode,
        'error' => $responseData['error'] ?? null,
        'message' => $responseData['message'] ?? null,
        'data' => $responseData['invoice_info_list'] ?? null,
		'request_id' => $responseData['request_id'] ?? null
    );
}




function getEscrowDetail($accessToken, $order_sn)
{
    global $partner_key, $partner_id, $host, $shop_id;

    $path = '/api/v2/payment/get_escrow_detail';
    $timestamp = time();

    try {
        if (empty($order_sn)) {
            throw new Exception("Missing required parameter: order_sn.");
        }

        $signGenerator = new SignGenerator();
        $sign = $signGenerator->generateSign(
            $partner_key,
            $partner_id,
            $path,
            $timestamp,
            $accessToken,
            $shop_id
        );

        $queryParams = http_build_query([
            'access_token' => $accessToken,
            'order_sn' => $order_sn,
            'partner_id' => $partner_id,
            'shop_id' => $shop_id,
            'sign' => $sign,
            'timestamp' => $timestamp
        ]);

        $endpoint = $host . $path . '?' . $queryParams;
        $postRequest = new PostRequest();
        return $postRequest->Post($endpoint, '', 'application/json', 'GET');

    } catch (Exception $e) {
        http_response_code(400);
        return json_encode(["error" => $e->getMessage()]);
    }
}




// ======== Shopee Signature Function ========
function generateShopeeSign($partnerKey, $partnerId, $path, $timestamp, $accessToken, $shopId) {
    $base_string = $partnerId . $path . $timestamp . $accessToken . $shopId;
    return hash_hmac('sha256', $base_string, $partnerKey);
}

// ======== API CALL FUNCTION (GET/POST) ========
function callShopeeAPI($method, $path, $params, $body, $partnerId, $partnerKey, $accessToken, $shopId) {
    $timestamp = time();
    $sign = generateShopeeSign($partnerKey, $partnerId, $path, $timestamp, $accessToken, $shopId);

    $params['partner_id'] = $partnerId;
    $params['shop_id'] = $shopId;
    $params['timestamp'] = $timestamp;
    $params['sign'] = $sign;

    $url = "https://partner.shopeemobile.com$path?" . http_build_query($params);

    $curl = curl_init();
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    ];

    if ($method === 'POST') {
        $options[CURLOPT_CUSTOMREQUEST] = 'POST';
        if ($body) {
            $options[CURLOPT_POSTFIELDS] = json_encode($body);
        }
    }

    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

// ======== Process Order Function ========
function processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken) {
    echo "\n======= Processing Order: $orderSn =======\n";

    // Step 1: get_shipping_parameter
    $path = '/api/v2/logistics/get_shipping_parameter';
    $params = [
        'access_token' => $accessToken,
        'order_sn' => $orderSn
    ];
    $shippingData = callShopeeAPI('GET', $path, $params, null, $partnerId, $partnerKey, $accessToken, $shopId);

    if (!isset($shippingData['response']['pickup']['address_list'][0])) {
        echo "❌ ไม่เจอ pickup address สำหรับ $orderSn\n";
        return;
    }

    // address_id & pickup_time_id
    $address = $shippingData['response']['pickup']['address_list'][0];
    $addressId = $address['address_id'];
    $pickupTimeId = '';
    foreach ($address['time_slot_list'] as $slot) {
        if (in_array('recommended', $slot['flags'])) {
            $pickupTimeId = $slot['pickup_time_id'];
            break;
        }
    }
    if (!$pickupTimeId) {
        $pickupTimeId = $address['time_slot_list'][0]['pickup_time_id'];
    }

    echo "✅ Pickup Address ID: $addressId | Pickup Time: $pickupTimeId\n";

    // Step 2: ship_order
    $path = '/api/v2/logistics/ship_order';
    $params = ['access_token' => $accessToken];
    $body = [
        'order_sn' => $orderSn,
        'package_number' => '',
        'pickup' => [
            'address_id' => $addressId,
            'pickup_time_id' => $pickupTimeId,
            'tracking_number' => ''
        ]
    ];
    $shipData = callShopeeAPI('POST', $path, $params, $body, $partnerId, $partnerKey, $accessToken, $shopId);

    if (isset($shipData['error']) && $shipData['error'] != '') {
        echo "⚠️ Ship Order Failed: " . $shipData['message'] . "\n";
        return;
    }

    echo "✅ Ship Order Success\n";


}




function processShopeeShipOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken) {
    echo "\n======= Ship Order (Dropoff) : $orderSn =======\n";

    // STEP 1: get_shipping_parameter
    $path = '/api/v2/logistics/get_shipping_parameter';
    $params = [
        'access_token' => $accessToken,
        'order_sn' => $orderSn
    ];
    $shippingData = callShopeeAPI('GET', $path, $params, null, $partnerId, $partnerKey, $accessToken, $shopId);

    $usedShippingMethod = 'none';

    // STEP 2: Prepare dropoff ตามรูปแบบ Shopee
    $dropoff = null;

    if (
        isset($shippingData['response']['dropoff']) &&
        isset($shippingData['response']['dropoff']['branch_list']) &&
        count($shippingData['response']['dropoff']['branch_list']) > 0
    ) {
        $branchId = $shippingData['response']['dropoff']['branch_list'][0]['branch_id'];
        $dropoff = [
            'branch_id' => $branchId,
            'sender_real_name' => 'บริษัท ออลล์เวล ไลฟ์ จำกัด',
            'tracking_no' => ''
        ];
        $usedShippingMethod = 'dropoff_branch';
        echo "✅ ใช้ Dropoff แบบ branch_id: $branchId\n";
    } elseif (
        isset($shippingData['response']['dropoff']) &&
        (
            empty($shippingData['response']['dropoff']) ||
            is_null($shippingData['response']['dropoff'])
        )
    ) {
        $dropoff = new stdClass(); // ส่งเป็น {} ตามแนวทาง Shopee
        $usedShippingMethod = 'dropoff_empty';
        echo "✅ ใช้ Dropoff แบบ object ว่าง {}\n";
    } elseif (
        isset($shippingData['response']['dropoff']['sender_real_name'])
    ) {
        $dropoff = [
            'sender_real_name' => 'บริษัท ออลล์เวล ไลฟ์ จำกัด'
        ];
        $usedShippingMethod = 'dropoff_sender_name';
        echo "✅ ใช้ Dropoff แบบ sender_real_name\n";
    } else {
        echo "⚠️ dropoff = null → ใช้ Dropoff แบบ object ว่าง {} ตามคำแนะนำ Shopee\n";
    $dropoff = new stdClass();  // ใช้ {} แน่นอน
    $usedShippingMethod = 'dropoff_forced_empty';
    }

    // STEP 3: Prepare request body
    $body = [
        'order_sn' => $orderSn,
        'dropoff' => $dropoff
    ];

    $jsonBody = json_encode($body, JSON_UNESCAPED_UNICODE);

    // STEP 4: Sign
    $timestamp = time();
    $apiPath = '/api/v2/logistics/ship_order';
    $sign = generateShopeeSign($partnerKey, $partnerId, $apiPath, $timestamp, $accessToken, $shopId);

    $url = 'https://partner.shopeemobile.com' . $apiPath . '?' . http_build_query([
        'access_token' => $accessToken,
        'partner_id' => $partnerId,
        'shop_id' => $shopId,
        'timestamp' => $timestamp,
        'sign' => $sign
    ]);

    // ✅ แสดง log สำคัญ
    //echo "🌐 URL: $url\n";
    //echo "🧾 JSON:\n$jsonBody\n";

    // STEP 5: CURL ส่ง
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonBody,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    ]);
    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo "❌ CURL Error: " . curl_error($curl) . "\n";
    } else {
        echo "✅ [$usedShippingMethod] Ship Order Response:\n$response\n";

        $responseData = json_decode($response, true);
        if (isset($responseData['request_id'])) {
            echo "📎 request_id: " . $responseData['request_id'] . "\n";
        }
        echo "⏱️ timestamp: $timestamp\n";
    }

    curl_close($curl);
}




function processShopeeOrderPickupTomorrow($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken) {
    echo "\n======= Processing Pickup (Next Day) Order: $orderSn =======\n";

    // STEP 1: get_shipping_parameter
    $path = '/api/v2/logistics/get_shipping_parameter';
    $params = [
        'access_token' => $accessToken,
        'order_sn' => $orderSn
    ];
    $shippingData = callShopeeAPI('GET', $path, $params, null, $partnerId, $partnerKey, $accessToken, $shopId);

    if (!isset($shippingData['response']['pickup']['address_list'][0])) {
        echo "❌ ไม่เจอ pickup address สำหรับ $orderSn\n";
        return;
    }

    $address = $shippingData['response']['pickup']['address_list'][0];
    $addressId = $address['address_id'];

    // หา pickup_time_id ที่เป็น "วันถัดไป"
    $tomorrowDate = strtotime('tomorrow');
    $pickupTimeId = '';
    foreach ($address['time_slot_list'] as $slot) {
        if (date('Y-m-d', $slot['date']) == date('Y-m-d', $tomorrowDate)) {
            $pickupTimeId = $slot['pickup_time_id'];
            break;
        }
    }

    if (!$pickupTimeId) {
        echo "❌ ไม่พบ pickup time สำหรับวันถัดไป\n";
        return;
    }

    echo "✅ Pickup Tomorrow | Address ID: $addressId | Pickup Time ID: $pickupTimeId\n";

    // STEP 2: ship_order (pickup)
    $path = '/api/v2/logistics/ship_order';
    $params = ['access_token' => $accessToken];
    $body = [
        'order_sn' => $orderSn,
        'package_number' => '',
        'pickup' => [
            'address_id' => $addressId,
            'pickup_time_id' => $pickupTimeId,
            'tracking_number' => ''
        ]
    ];
    $shipData = callShopeeAPI('POST', $path, $params, $body, $partnerId, $partnerKey, $accessToken, $shopId);

    if (isset($shipData['error']) && $shipData['error'] != '') {
        echo "⚠️ Ship Order Failed: " . $shipData['message'] . "\n";
        return;
    }

    echo "✅ Ship Order Scheduled for Tomorrow\n";

}


function confirmShopeePickupAt1PM($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken) {
    echo "\n======= Processing Order (Pickup at 13:00): $orderSn =======\n";

    // Step 1: get_shipping_parameter
    $path = '/api/v2/logistics/get_shipping_parameter';
    $params = [
        'access_token' => $accessToken,
        'order_sn' => $orderSn
    ];
    $shippingData = callShopeeAPI('GET', $path, $params, null, $partnerId, $partnerKey, $accessToken, $shopId);

    if (!isset($shippingData['response']['pickup']['address_list'][0])) {
        echo "❌ ไม่เจอ pickup address สำหรับ $orderSn\n";
        return;
    }

    $address = $shippingData['response']['pickup']['address_list'][0];
    $addressId = $address['address_id'];
    $pickupTimeId = '';

    // วนหา slot ที่เริ่มเวลา 13:00
    foreach ($address['time_slot_list'] as $slot) {
        // แปลงเวลาเริ่มต้นจาก text เช่น "13:00-15:00"
        if (preg_match('/^13:00/', $slot['time_text'])) {
            $pickupTimeId = $slot['pickup_time_id'];
            break;
        }
    }

    if (!$pickupTimeId) {
        echo "❌ ไม่มี slot ที่เริ่มเวลา 13:00 สำหรับ $orderSn\n";
        return;
    }

    echo "✅ Pickup Address ID: $addressId | Pickup Time (13:00): $pickupTimeId\n";

    // Step 2: ship_order
    $path = '/api/v2/logistics/ship_order';
    $params = ['access_token' => $accessToken];
    $body = [
        'order_sn' => $orderSn,
        'package_number' => '',
        'pickup' => [
            'address_id' => $addressId,
            'pickup_time_id' => $pickupTimeId,
            'tracking_number' => ''
        ]
    ];
    $shipData = callShopeeAPI('POST', $path, $params, $body, $partnerId, $partnerKey, $accessToken, $shopId);

    if (isset($shipData['error']) && $shipData['error'] != '') {
        echo "⚠️ Ship Order Failed: " . $shipData['message'] . "\n";
        return;
    }

    echo "✅ Ship Order Success (13:00)\n";
}





function processShopeeOrderPickupIn2Days($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken) {
    echo "\n======= Processing Pickup (+2 Days) Order: $orderSn =======\n";

    // STEP 1: get_shipping_parameter
    $path = '/api/v2/logistics/get_shipping_parameter';
    $params = [
        'access_token' => $accessToken,
        'order_sn' => $orderSn
    ];
    $shippingData = callShopeeAPI('GET', $path, $params, null, $partnerId, $partnerKey, $accessToken, $shopId);

    if (!isset($shippingData['response']['pickup']['address_list'][0])) {
        echo "❌ ไม่เจอ pickup address สำหรับ $orderSn\n";
        return;
    }

    $address = $shippingData['response']['pickup']['address_list'][0];
    $addressId = $address['address_id'];

    // STEP 2: หาวันที่อีก 2 วันข้างหน้า
    $pickupDate = strtotime("+2 days");
    $pickupDateFormatted = date('Y-m-d', $pickupDate);
    $pickupTimeId = '';

    foreach ($address['time_slot_list'] as $slot) {
        if (date('Y-m-d', $slot['date']) == $pickupDateFormatted) {
            $pickupTimeId = $slot['pickup_time_id'];
            break;
        }
    }

    if (!$pickupTimeId) {
        echo "❌ ไม่พบ pickup time สำหรับวันที่ $pickupDateFormatted\n";
        return;
    }

    echo "✅ Pickup Scheduled | Date: $pickupDateFormatted | Address ID: $addressId | Pickup Time ID: $pickupTimeId\n";

    // STEP 3: ship_order (pickup)
    $path = '/api/v2/logistics/ship_order';
    $params = ['access_token' => $accessToken];
    $body = [
        'order_sn' => $orderSn,
        'package_number' => '',
        'pickup' => [
            'address_id' => $addressId,
            'pickup_time_id' => $pickupTimeId,
            'tracking_number' => ''
        ]
    ];
    $shipData = callShopeeAPI('POST', $path, $params, $body, $partnerId, $partnerKey, $accessToken, $shopId);

    if (isset($shipData['error']) && $shipData['error'] != '') {
        echo "⚠️ Ship Order Failed: " . $shipData['message'] . "\n";
        return;
    }

    echo "✅ Ship Order Scheduled for $pickupDateFormatted\n";
}



function getShopeeTrackingNumberOnly($orderSn, $partnerId, $partnerKey, $shopId, $accessToken) {
    //echo "\n======= Getting Tracking Number for: $orderSn =======\n";

    $path = '/api/v2/logistics/get_tracking_number';
    $timestamp = time();
    $sign = generateShopeeSign($partnerKey, $partnerId, $path, $timestamp, $accessToken, $shopId);

    $url = "https://partner.shopeemobile.com$path";
    $url .= "?access_token=$accessToken";
    $url .= "&order_sn=$orderSn";
    $url .= "&package_number=-";
    $url .= "&partner_id=$partnerId";
    $url .= "&response_optional_fields=first_mile_tracking_number";
    $url .= "&shop_id=$shopId";
    $url .= "&sign=$sign";
    $url .= "&timestamp=$timestamp";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);
    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    if (isset($data['response']['tracking_number'])) {
        $trackingNumber = $data['response']['tracking_number'];
        echo "✅ Tracking Number: $trackingNumber\n";
        return $trackingNumber;
    } else {
        //echo "❌ ไม่พบ Tracking Number สำหรับ order_sn: $orderSn\n";
        return null;
    }
}


function findPickupTimeIdAtHourToday(array $address, int $targetHour = 13, string $timezone = 'Asia/Bangkok') {
    if (!isset($address['time_slot_list']) || !is_array($address['time_slot_list'])) {
        return [null, 'ไม่พบ time_slot_list'];
    }

    $tz = new DateTimeZone($timezone);
    $today = new DateTime('today', $tz); // 00:00 วันนี้
    $target = new DateTime('today', $tz);
    $target->setTime($targetHour, 0, 0);

    $slots = $address['time_slot_list'];

    // ตัวช่วย: แปลงค่าเวลาให้เป็นวินาทีจากเที่ยงคืน
    $toSec = function($v) {
        if (is_int($v)) return $v;                 // สมมติเป็นวินาทีอยู่แล้ว
        if (is_string($v)) {
            // รองรับ "HH:MM" หรือ "HH:MM:SS"
            if (preg_match('/^(\d{1,2}):(\d{2})(?::(\d{2}))?$/', $v, $m)) {
                $h = (int)$m[1]; $i = (int)$m[2]; $s = isset($m[3]) ? (int)$m[3] : 0;
                return $h*3600 + $i*60 + $s;
            }
            // บางกรณีอาจเป็น string วินาที
            if (ctype_digit($v)) return (int)$v;
        }
        return null; // ไม่รู้รูปแบบ
    };

    // ลองหา slot ที่ครอบคลุม 13:00 วันนี้แบบโครงสร้างชัดเจน (มี date + start_time + end_time)
    foreach ($slots as $slot) {
        if (!isset($slot['pickup_time_id'])) continue;

        // เช็ควันที่ ถ้าไม่มี date ให้ข้าม logic นี้ ไปลองแบบ time_text
        if (!isset($slot['date'])) continue;

        $slotDate = DateTime::createFromFormat('Y-m-d', $slot['date'], $tz);
        if (!$slotDate) continue;

        // ต้องเป็น "วันนี้" เท่านั้น
        if ($slotDate->format('Y-m-d') !== $today->format('Y-m-d')) continue;

        $startSec = isset($slot['start_time']) ? $toSec($slot['start_time']) : null;
        $endSec   = isset($slot['end_time'])   ? $toSec($slot['end_time'])   : null;

        if ($startSec !== null && $endSec !== null) {
            $slotStart = (clone $slotDate)->setTime(0,0,0)->modify("+{$startSec} seconds");
            $slotEnd   = (clone $slotDate)->setTime(0,0,0)->modify("+{$endSec} seconds");

            if ($target >= $slotStart && $target < $slotEnd) {
                return [$slot['pickup_time_id'], "พบช่องเวลาวันนี้ {$slot['date']} ที่ครอบคลุม {$targetHour}:00"];
            }
        }
    }

    // ถ้าไม่มีโครงสร้าง start/end ให้ลอง parse จาก time_text เช่น "13:00-16:00"
    foreach ($slots as $slot) {
        if (!isset($slot['pickup_time_id'])) continue;

        // ต้องเป็น "วันนี้" ถ้ามี date กรองก่อน
        if (isset($slot['date'])) {
            $slotDate = DateTime::createFromFormat('Y-m-d', $slot['date'], $tz);
            if (!$slotDate || $slotDate->format('Y-m-d') !== $today->format('Y-m-d')) continue;
        }

        if (isset($slot['time_text']) && is_string($slot['time_text'])) {
            if (preg_match('/(\d{1,2}):(\d{2})\s*-\s*(\d{1,2}):(\d{2})/', $slot['time_text'], $m)) {
                $h1=(int)$m[1]; $i1=(int)$m[2]; $h2=(int)$m[3]; $i2=(int)$m[4];
                $slotStart = (clone $today)->setTime($h1, $i1, 0);
                $slotEnd   = (clone $today)->setTime($h2, $i2, 0);
                if ($target >= $slotStart && $target < $slotEnd) {
                    return [$slot['pickup_time_id'], "พบ time_text วันนี้ที่ครอบคลุม {$targetHour}:00 ({$slot['time_text']})"];
                }
            }
        }
    }

    // Fallback: หา recommended วันนี้ก่อน
    foreach ($slots as $slot) {
        if (isset($slot['flags']) && is_array($slot['flags']) && in_array('recommended', $slot['flags'], true)) {
            // ถ้ามีวันที่และเป็นวันนี้ ใช้เลย
            if (isset($slot['date'])) {
                $slotDate = DateTime::createFromFormat('Y-m-d', $slot['date'], $tz);
                if ($slotDate && $slotDate->format('Y-m-d') === $today->format('Y-m-d')) {
                    return [$slot['pickup_time_id'], "ไม่พบ 13:00 ที่ตรงเป๊ะ เลือก recommended ของวันนี้แทน"];
                }
            }
        }
    }

    // Fallback สุดท้าย: ช่องแรกของวันนี้ ถ้ามี
    foreach ($slots as $slot) {
        if (isset($slot['date'])) {
            $slotDate = DateTime::createFromFormat('Y-m-d', $slot['date'], $tz);
            if ($slotDate && $slotDate->format('Y-m-d') === $today->format('Y-m-d')) {
                return [$slot['pickup_time_id'], "ไม่พบ 13:00 เลือกช่องแรกของวันนี้แทน"];
            }
        }
    }

    // ถ้ายังไม่เจออะไรเลย ให้คืน recommended ใด ๆ เป็นที่สุดท้าย
    foreach ($slots as $slot) {
        if (isset($slot['flags']) && is_array($slot['flags']) && in_array('recommended', $slot['flags'], true)) {
            return [$slot['pickup_time_id'], "ไม่พบช่องของวันนี้ เลือก recommended ล่าสุดแทน"];
        }
    }

    // สุดจริง ๆ: ช่องแรกในลิสต์
    if (!empty($slots[0]['pickup_time_id'])) {
        return [$slots[0]['pickup_time_id'], "ไม่พบช่องของวันนี้ เลือกช่องแรกในระบบแทน"];
    }

    return [null, 'ไม่พบ pickup_time_id ที่ใช้ได้'];
}





function findPickupTimeIdTodayAround1PM(array $address, int $targetHour = 13, string $timezone = 'Asia/Bangkok') {
    if (empty($address['time_slot_list']) || !is_array($address['time_slot_list'])) {
        return [null, 'ไม่พบ time_slot_list', null];
    }

    $tz     = new DateTimeZone($timezone);
    $today  = new DateTime('today', $tz);
    $target = (clone $today)->setTime($targetHour, 0, 0);

    $looksLikeEpoch = function($v) {
        // epoch ปกติ > 10^9; ใช้ threshold เผื่อ
        return is_int($v) && $v > 200000000;
    };

    $parseDateField = function($slot) use ($tz, $today, $looksLikeEpoch) {
        // date อาจเป็น 'Y-m-d' หรือ epoch หรือไม่มี
        if (!empty($slot['date'])) {
            if (is_string($slot['date'])) {
                $d = DateTime::createFromFormat('Y-m-d', $slot['date'], $tz);
                if ($d) return $d;
                // เผื่อมีรูปแบบอื่น ข้ามไป fallback
            } elseif ($looksLikeEpoch($slot['date'])) {
                $d = (new DateTime('@'.$slot['date']))->setTimezone($tz);
                return (new DateTime($d->format('Y-m-d'), $tz)); // normalize เป็น 00:00 ของวันนั้น
            }
        }

        // เดาช่วงวันที่จาก pickup_time_id ที่ขึ้นต้น epoch เช่น "1757322000_2"
        if (!empty($slot['pickup_time_id']) && preg_match('/^(\d{10})_/', (string)$slot['pickup_time_id'], $m)) {
            $d = (new DateTime('@'.$m[1]))->setTimezone($tz);
            return (new DateTime($d->format('Y-m-d'), $tz));
        }

        // ถ้าไม่มีอะไรเลย สมมติเป็นวันนี้ (กรณี API คืนมาเฉพาะของวันนี้)
        return clone $today;
    };

    $parseHMSorEpochToDT = function($baseDate /*DateTime*/, $val) use ($tz, $looksLikeEpoch) {
        if ($val === null) return null;

        // 1) epoch
        if ($looksLikeEpoch($val)) {
            return (new DateTime('@'.$val))->setTimezone($tz);
        }

        // 2) string "HH:MM[:SS]"
        if (is_string($val)) {
            if (ctype_digit($val)) {
                // เป็น "วินาที" จากเที่ยงคืนแบบ string
                $d = (clone $baseDate)->setTime(0,0,0)->modify("+{$val} seconds");
                return $d;
            }
            if (preg_match('/^(\d{1,2}):(\d{2})(?::(\d{2}))?$/', $val, $m)) {
                return (clone $baseDate)->setTime((int)$m[1], (int)$m[2], isset($m[3])?(int)$m[3]:0);
            }
        }

        // 3) int วินาทีจากเที่ยงคืน
        if (is_int($val)) {
            return (clone $baseDate)->setTime(0,0,0)->modify("+{$val} seconds");
        }

        return null;
    };

    $toTimes = function(array $slot) use ($parseDateField, $parseHMSorEpochToDT) {
        $date  = $parseDateField($slot);               // 00:00 ของวันนั้น
        if (!$date) return [null, null];

        $start = null; $end = null;

        // มี start_time/end_time?
        if (isset($slot['start_time']) || isset($slot['end_time'])) {
            $start = $parseHMSorEpochToDT($date, $slot['start_time'] ?? null);
            $end   = $parseHMSorEpochToDT($date, $slot['end_time']   ?? null);
        }

        // ถ้ายัง parse ไม่ได้ ลอง time_text: "13:00 - 17:00"
        if ((!$start || !$end) && !empty($slot['time_text']) &&
            preg_match('/(\d{1,2}):(\d{2})\s*-\s*(\d{1,2}):(\d{2})/', $slot['time_text'], $m)) {
            $start = (clone $date)->setTime((int)$m[1], (int)$m[2], 0);
            $end   = (clone $date)->setTime((int)$m[3], (int)$m[4], 0);
        }

        return [$start, $end];
    };

    // กรองเฉพาะ slot ของ "วันนี้"
    $slotsToday = [];
    foreach ($address['time_slot_list'] as $slot) {
        [$start, $end] = $toTimes($slot);
        if (!$start || !$end) continue;
        if ($start->format('Y-m-d') !== $today->format('Y-m-d')) continue;

        $slotsToday[] = ['slot'=>$slot, 'start'=>$start, 'end'=>$end];
    }
    if (empty($slotsToday)) return [null, 'ไม่มีช่วงรับของ "วันนี้"', null];

    // 0) พยายาม match 13:00-17:00 ตามหน้าเว็บก่อน (ถ้า provider ให้มา)
    foreach ($slotsToday as $s) {
        if (!empty($s['slot']['time_text']) && preg_match('/13:00\s*-\s*17:00/', $s['slot']['time_text'])) {
            $range = $s['start']->format('H:i').'-'.$s['end']->format('H:i');
            return [$s['slot']['pickup_time_id'], "match time_text 13:00-17:00 ($range)", $range];
        }
    }

    // 1) ครอบคลุม 13:00
    foreach ($slotsToday as $s) {
        if ($target >= $s['start'] && $target < $s['end']) {
            $range = $s['start']->format('H:i').'-'.$s['end']->format('H:i');
            return [$s['slot']['pickup_time_id'], "ครอบคลุม {$targetHour}:00 ($range)", $range];
        }
    }

    // 2) เลือกช่วงที่เริ่มหลัง 13:00 ที่ใกล้ที่สุด
    $afternoon = array_values(array_filter($slotsToday, fn($s)=> $s['start'] >= $target));
    if (!empty($afternoon)) {
        usort($afternoon, fn($a,$b)=> $a['start'] <=> $b['start']);
        $best = $afternoon[0];
        $range = $best['start']->format('H:i').'-'.$best['end']->format('H:i');
        return [$best['slot']['pickup_time_id'], "ไม่ครอบคลุม 13:00 เลือกบ่ายที่ใกล้ที่สุด ($range)", $range];
    }

    // 3) ไม่มีบ่ายเลย
    return [null, 'วันนี้ไม่มีช่วงบ่าย/>=13:00 ให้เลือก', null];
}


function processShopeeOrderPickupToday1PM($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken, $timezone = 'Asia/Bangkok') {
    echo "\n======= Processing Order (Pickup วันนี้ 13:00): $orderSn =======\n";

    // Step 1: get_shipping_parameter
    $path = '/api/v2/logistics/get_shipping_parameter';
    $params = ['access_token' => $accessToken, 'order_sn' => $orderSn];
    $shippingData = callShopeeAPI('GET', $path, $params, null, $partnerId, $partnerKey, $accessToken, $shopId);

    if (empty($shippingData['response']['pickup']['address_list'][0])) {
        echo "❌ ไม่เจอ pickup address สำหรับ $orderSn\n";
        return;
    }

    $address   = $shippingData['response']['pickup']['address_list'][0];
    $addressId = $address['address_id'] ?? null;
    if (!$addressId) { echo "❌ address_id ว่างสำหรับ $orderSn\n"; return; }

    // ✅ เลือกเฉพาะช่วงบ่ายของวันนี้เท่านั้น
    [$pickupTimeId, $why, $pickedRange] = findPickupTimeIdTodayAround1PM($address, 13, $timezone);
    if (!$pickupTimeId) {
        echo "⚠️ ยกเลิกการ ship: $why\n";
        return;
    }

    echo "✅ Address ID: $addressId | Pickup Time ID: $pickupTimeId ($why)\n";

    // Step 2: ship_order
    $path = '/api/v2/logistics/ship_order';
    $params = ['access_token' => $accessToken];
    $body = [
        'order_sn' => $orderSn,
        'package_number' => '',
        'pickup' => [
            'address_id'      => $addressId,
            'pickup_time_id'  => $pickupTimeId,
            'tracking_number' => ''
        ]
    ];
    $shipData = callShopeeAPI('POST', $path, $params, $body, $partnerId, $partnerKey, $accessToken, $shopId);

    if (!empty($shipData['error'])) {
        echo "⚠️ Ship Order Failed: " . ($shipData['message'] ?? 'Unknown error') . "\n";
        return;
    }

    echo "🎉 Ship Order Success (ช่วงที่จองจริง: ".($pickedRange ?: 'ไม่ทราบ').")\n";
}

//ยกเลิกออเดอร์


function getCancelledOrders($accessToken, $params = [])
{
    global $partner_key, $partner_id, $host, $shop_id;

    $path = '/api/v2/order/get_order_list';
    $timestamp = time();

    $sign = (new SignGenerator())->generateSign(
        $partner_key,
        $partner_id,
        $path,
        $timestamp,
        $accessToken,
        $shop_id
    );

    $time_from = $params['time_from'] ?? strtotime('-7 days');
    $time_to   = $params['time_to'] ?? time();
    $cursor    = $params['cursor'] ?? '';
    $pageSize  = $params['page_size'] ?? 50;

    $query = [
        'partner_id' => $partner_id,
        'timestamp' => $timestamp,
        'access_token' => $accessToken,
        'shop_id' => $shop_id,
        'sign' => $sign,
        'time_range_field' => 'update_time',
        'time_from' => $time_from,
        'time_to' => $time_to,
        'page_size' => $pageSize,
        'order_status' => 'CANCELLED',
        'response_optional_fields' => 'order_status',
    ];

    if ($cursor !== '') {
        $query['cursor'] = $cursor;
    }

    $endpoint = $host . $path . '?' . http_build_query($query);

    $response = (new PostRequest())->Post(
        $endpoint,
        '',
        'application/json',
        'GET'
    );

    return $response; // JSON string
}

/**
 * ดึงออเดอร์ยกเลิก "ทุกหน้า" (Auto-Paginate)
 * @param string $accessToken
 * @param array  $params [
 *   'time_from' => int, 'time_to' => int, 'time_range_field' => 'update_time'|'create_time',
 *   'page_size' => int, 'max_pages' => int, 'sleep_ms' => int (พักกัน rate limit)
 * ]
 * @return array [
 *   'orders'      => array (รวมทุกหน้า),
 *   'pages'       => int   (จำนวนหน้าที่ดึงได้),
 *   'last_cursor' => string|NULL,
 *   'errors'      => array (ถ้ามี),
 *   'raw_pages'   => array (optional สำหรับ debug)
 * ]
 */
function getAllCancelledOrders($accessToken, $params = [])
{
    $maxPages = $params['max_pages'] ?? 100;   // กันลูปยาวเกิน
    $sleepMs  = $params['sleep_ms']  ?? 0;     // เวลาพักระหว่างหน้า (ป้องกัน rate limit)
    $cursor   = '';
    $pages    = 0;

    $all      = [];
    $errors   = [];
    $rawPages = [];

    do {
        $pageParams = $params;
        $pageParams['cursor'] = $cursor;

        $raw = getCancelledOrders($accessToken, $pageParams);
        $rawPages[] = $raw;

        $data = json_decode($raw, true);
        if (!is_array($data)) {
            $errors[] = 'Invalid JSON from API';
            break;
        }
        if (!empty($data['error'])) {
            // ถ้า API มี error ให้เก็บแล้วหยุด (หรือจะ continue ก็ได้)
            $errors[] = ($data['message'] ?? 'API error') . ' (' . $data['error'] . ')';
            break;
        }

        $list   = $data['response']['order_list'] ?? [];
        $more   = (bool)($data['response']['more'] ?? false);
        $cursor = $data['response']['next_cursor'] ?? null;

        // รวมผล
        if (!empty($list)) {
            // ป้องกันซ้ำกรณี cursor กลับมาหน้าเดิม
            foreach ($list as $o) {
                $all[$o['order_sn']] = $o;
            }
        }

        $pages++;

        // หน่วงเวลาตามต้องการ
        if ($sleepMs > 0 && $more && $cursor) {
            usleep($sleepMs * 1000);
        }

    } while ($more && $cursor && $pages < $maxPages);

    // แปลง associative -> indexed
    $orders = array_values($all);

    return [
        'orders'      => $orders,
        'pages'       => $pages,
        'last_cursor' => $cursor,
        'errors'      => $errors,
        // comment ออกถ้าไม่อยากได้ payload ดิบ
        'raw_pages'   => $rawPages,
    ];
}


//ตรวจสอบสถานะการปริ้น

/*function getShippingDocumentResult($accessToken, $order_sn_list)
{
    global $partner_key, $partner_id, $host, $timestamp, $shop_id;

    $path = '/api/v2/logistics/get_shipping_document_result';

    $sign = (new SignGenerator())->generateSign(
        $partner_key, $partner_id, $path, $timestamp, $accessToken, $shop_id
    );

    $endpoint = sprintf(
        "%s%s?partner_id=%s&timestamp=%d&access_token=%s&shop_id=%s&sign=%s",
        $host, $path, $partner_id, $timestamp, $accessToken, $shop_id, $sign
    );

    $body = [
        "order_list" => array_map(fn($sn) => ["order_sn" => $sn], (array)$order_sn_list)
    ];

    $postRequest = new PostRequest();
    $response = $postRequest->Post($endpoint, json_encode($body), 'application/json', 'POST');

    return $response; // JSON จาก Shopee
}*/


function getShippingDocStatuses($accessToken, $orderSnList)
{
    global $partner_key, $partner_id, $host, $shop_id;

    $path = '/api/v2/logistics/get_shipping_document_result';
    $timestamp = time();
    $sign = (new SignGenerator())->generateSign($partner_key, $partner_id, $path, $timestamp, $accessToken, $shop_id);

    $endpoint = sprintf(
        "%s%s?partner_id=%s&timestamp=%d&access_token=%s&shop_id=%s&sign=%s",
        $host, $path, $partner_id, $timestamp, $accessToken, $shop_id, $sign
    );

    $result = []; // order_sn => ['status','url','fail_reason']

    $post = new PostRequest();
    foreach (array_chunk($orderSnList, 50) as $chunk) {
        $body = ['order_sn_list' => array_values($chunk)];
        $raw  = $post->Post($endpoint, json_encode($body, JSON_UNESCAPED_UNICODE), 'application/json', 'POST');
        $data = json_decode($raw, true);

        if (!is_array($data) || !empty($data['error'])) {
            continue; // จะใส่ error_log ไว้ก็ได้
        }

        foreach ($data['response']['result_list'] ?? [] as $doc) {
            $sn = $doc['order_sn'] ?? null; if (!$sn) continue;
            $result[$sn] = [
                'status'      => $doc['document_status'] ?? 'N/A', // READY|PROCESSING|FAILED|COMPLETED
                'url'         => $doc['document_url']    ?? null,
                'fail_reason' => $doc['fail_reason']     ?? null,
            ];
        }
        foreach ($data['response']['fail_list'] ?? [] as $doc) {
            $sn = $doc['order_sn'] ?? null; if (!$sn) continue;
            $result[$sn] = [
                'status'      => 'FAILED',
                'url'         => null,
                'fail_reason' => $doc['fail_reason'] ?? 'Unknown',
            ];
        }
    }

    return $result;
}



//ฟังก์ชั่นเช็ครับเงิน
/*
if (!function_exists('shopeeSign')) {
    function shopeeSign($partner_id, $path, $timestamp, $access_token, $shop_id, $partner_key) {
        $base_string = $partner_id . $path . $timestamp . $access_token . $shop_id;
        return hash_hmac('sha256', $base_string, $partner_key);
    }
}

if (!function_exists('shopeeGet')) {
    function shopeeGet($host, $path, $params) {
        $url = $host . $path . "?" . http_build_query($params);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return [
                "success" => false,
                "message" => $error
            ];
        }

        return json_decode($response, true);
    }
}

if (!function_exists('getEscrowListByDate')) {
    function getEscrowListByDate($date) {
        global $host, $partner_id, $partner_key, $shop_id, $access_token;

        $path = "/api/v2/payment/get_escrow_list";
        $timestamp = time();

        $sign = shopeeSign(
            $partner_id,
            $path,
            $timestamp,
            $access_token,
            $shop_id,
            $partner_key
        );

        $params = [
            "partner_id" => $partner_id,
            "timestamp" => $timestamp,
            "access_token" => $access_token,
            "shop_id" => $shop_id,
            "sign" => $sign,
            "release_time_from" => strtotime($date . " 00:00:00"),
            "release_time_to" => strtotime($date . " 23:59:59"),
            "page_size" => 100,
            "page_no" => 1
        ];

        return shopeeGet($host, $path, $params);
    }
}

if (!function_exists('getEscrowDetail')) {
    function getEscrowDetail($order_sn) {
        global $host, $partner_id, $partner_key, $shop_id, $access_token;

        $path = "/api/v2/payment/get_escrow_detail";
        $timestamp = time();

        $sign = shopeeSign(
            $partner_id,
            $path,
            $timestamp,
            $access_token,
            $shop_id,
            $partner_key
        );

        $params = [
            "partner_id" => $partner_id,
            "timestamp" => $timestamp,
            "access_token" => $access_token,
            "shop_id" => $shop_id,
            "sign" => $sign,
            "order_sn" => $order_sn
        ];

        return shopeeGet($host, $path, $params);
    }
}
*/



?>