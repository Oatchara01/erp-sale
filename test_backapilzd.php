<?php

include("head.php");
include("dbconnect.php");
include "databaseHelper.php";
include "LazadaAPI.php";


// Lazada API URLs
$apiUrlPack = 'https://api.lazada.co.th/rest/order/fulfill/pack';
$refreshUrl = 'https://api.lazada.co.th/rest/auth/token/refresh';
$apiUrlGet = 'https://api.lazada.co.th/rest/order/get';

// Lazada App Configuration
$appKey = '124441';
$appSecret = '4C6pyxTSw42nWe9NdsofLjjOLntDQbWb';
$running = '1';


$strSQL = "SELECT order_id, order_item_id FROM so__main WHERE ref_id ='355849'";
$objQuery = $conn->query($strSQL);

if ($objQuery->num_rows > 0) {
    while ($objResult = $objQuery->fetch_assoc()) {
        $order_id = $objResult['order_id'];
        $order_item_id = $objResult['order_item_id'];

        $app_key = "124441";
        $app_secret = "4C6pyxTSw42nWe9NdsofLjjOLntDQbWb";
        $timestamp = round(microtime(true) * 1000);
        $sign_method = "sha256";

        // Retrieve access_token (ensure it's valid and updated)
        $access_token = getTokenFromDB($running);
        if (!$access_token) {
            die("Access token is missing or expired. Please refresh the token.");
        }

        // Prepare the pack_order_list payload
        $payload = [
            "pack_order_list" => [
                [
                    "order_item_ids" => [$order_item_id], // Corrected parameter name
                    "order_id" => $order_id
                ]
            ],
            "delivery_type" => "dropship", // Required field
            "shipping_provider" => "TFS" // Corrected parameter name
        ];

        // Encode the payload as JSON
        $payload_json = json_encode($payload);

        // Combine parameters for signing
        $all_params = [
            'app_key' => $app_key,
            'timestamp' => $timestamp,
            'sign_method' => $sign_method,
            'access_token' => $access_token
        ];

        // Generate the signature
        ksort($all_params);
        $query_string = urldecode(http_build_query($all_params));
        $signature = strtoupper(hash_hmac('sha256', $query_string, $app_secret));

        // Add signature to the query string
        $all_params['sign'] = $signature;

        // Build the full API URL
        $api_url = "https://api.lazada.co.th/rest/order/pack?" . http_build_query($all_params);

        // Initialize CURL for POST request
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $api_url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $payload_json, // Send JSON payload
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json", // Ensure the payload is JSON
            ],
        ]);

        // Execute the request and capture the response
        $response = curl_exec($curl);

        // Handle cURL errors
        if ($response === false) {
            echo "cURL Error: " . curl_error($curl);
            curl_close($curl);
            exit;
        }

        // Decode and process the response
        $response_data = json_decode($response, true);
        curl_close($curl);

        if (isset($response_data['code']) && $response_data['code'] == '0') {
            echo "Order ID: $order_id successfully updated to PACKED.<br>";
        } else {
            echo "Error updating Order ID: $order_id.<br>";
            echo "Response: " . $response . "<br>";
        }
    }
} else {
    echo "No orders found with the specified ref_id.";
}

/*$refresh_token = getRefreshTokenFromDB($running);
if ($refresh_token) {
    $obj = getRefreshToken(base64_decode($refresh_token));
    if (updateShopToken($obj, $running)) {
        //echo "New record created successfully";
    } else {
        echo "Save error";
    }
} else {
    echo "No shop running id " . $running;
}

$accessToken = getTokenFromDB($running);


$strSQL = "SELECT order_id, order_item_id FROM so__main WHERE ref_id ='355832'";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . mysqli_error($conn) . "]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderId = $objResult['order_id'];
    $orderItemId = $objResult['order_item_id'];

    $packRequest = [
        'pack_order_list' => [
            [
                'order_id' => $orderId,
                'order_item_list' => [$orderItemId]
            ]
        ],
        'delivery_type' => 'dropship',
        'shipment_provider_code' => 'FM50',
        'shipping_allocate_type' => 'NTFS'
    ];

    $timestamp = round(microtime(true) * 1000);
    $params = [
        'app_key' => $appKey,
        'sign_method' => 'sha256',
        'access_token' => $accessToken,
        'timestamp' => $timestamp
    ];

    // คำนวณ Signature
    ksort($params);
    $queryString = http_build_query($params);
    $signatureString = $appSecret . urldecode($queryString);
    $signature = hash_hmac('sha256', $signatureString, $appSecret);

    // ส่งคำขอ POST ไปยัง API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrlPack . '?' . $queryString . '&sign=' . $signature);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($packRequest));
    $packResponse = curl_exec($ch);
    curl_close($ch);

    $packData = json_decode($packResponse, true);

    if ($packData['code'] === '0') {
        // ดึง Tracking Number
        $paramsGet = [
            'app_key' => $appKey,
            'sign_method' => 'sha256',
            'access_token' => $accessToken,
            'timestamp' => round(microtime(true) * 1000),
            'order_id' => $orderId
        ];

        ksort($paramsGet);
        $queryStringGet = http_build_query($paramsGet);
        $signatureStringGet = $appSecret . urldecode($queryStringGet);
        $signatureGet = hash_hmac('sha256', $signatureStringGet, $appSecret);

        $chGet = curl_init();
        curl_setopt($chGet, CURLOPT_URL, $apiUrlGet . '?' . $queryStringGet . '&sign=' . $signatureGet);
        curl_setopt($chGet, CURLOPT_RETURNTRANSFER, true);
        $getResponse = curl_exec($chGet);
        curl_close($chGet);

        $getData = json_decode($getResponse, true);
        if (isset($getData['data']['delivery_info']['tracking_number'])) {
            $trackingNumber = $getData['data']['delivery_info']['tracking_number'];

            // อัปเดต Tracking Number
            $updateSQL = "UPDATE so__main SET order_refer_code='$trackingNumber' WHERE order_id='$orderId'";
            if (mysqli_query($conn, $updateSQL)) {
                echo "อัปเดตคำสั่งซื้อ $orderId สำเร็จ! Tracking Number: $trackingNumber<br>";
            } else {
                echo "Error Updating Order $orderId: " . mysqli_error($conn) . "<br>";
            }
        } else {
            echo "ไม่พบ Tracking Number สำหรับคำสั่งซื้อ $orderId<br>";
        }
    } else {
        echo "การอัปเดตสถานะ Pack สำหรับคำสั่งซื้อ $orderId ล้มเหลว: " . $packData['message'] . "<br>";
    }
}



/*$apiUrl = 'https://api.lazada.co.th/rest';
	
	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM so__printecom1";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "WB";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$so = "WB";
$ref_id ="$so$nextId";
	
	
$strSQL = "SELECT order_id,order_item_id   FROM so__main  where sale_channel='1' and ref_id >='354178' and ref_id <='354192'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery))
{
	
$orderId = $objResult['order_id'];
    $orderItemId = $objResult['order_item_id'];

    // สร้างคำขอไปยัง Lazada API
    $c = new LazopClient($apiUrl, $appKey, $appSecret);
    $request = new LazopRequest('/order/package/document/get');

    // สร้าง JSON สำหรับ parameter `getDocumentReq`
    $getDocumentReq = [
        "doc_type" => "PDF",
        "print_item_list" => false,
        "packages" => [
            ["package_id" => $orderItemId] // ใช้ order_item_id เป็น package_id
        ]
    ];

    $request->addApiParam('getDocumentReq', json_encode($getDocumentReq));
    $response = $c->execute($request, $accessToken);
    $responseData = json_decode($response, true);

    // ตรวจสอบผลลัพธ์จาก API
    if ($responseData['code'] === '0' && $responseData['result']['success'] === "true") {
        $pdfUrl = $responseData['result']['data']['pdf_url'];

        // ดาวน์โหลดไฟล์ PDF และบันทึก
        $pdfContent = file_get_contents($pdfUrl);
		$navk_ev = '' . $orderId . '_package_document.pdf';
        $savePath = 'downloads/' . $orderId . '_package_document.pdf';
        file_put_contents($savePath, $pdfContent);

        echo "ดาวน์โหลดใบปะหน้า $orderId สำเร็จ: $savePath<br>";

        // อัปเดตสถานะในฐานข้อมูล
		$add_date = date('Y-m-d H:i:s');

$updateSQL = "insert into so__printecom1 (order_id,register_date,ref_id,sale_channel,img_wb) 
values('".$orderId."','".$add_date."','".$ref_id."','".$running."','".$navk_ev."')'";
        mysqli_query($conn, $updateSQL);
    } else {
        echo "เกิดข้อผิดพลาดกับคำสั่งซื้อ $orderId: " . $responseData['result']['error_msg'] . "<br>";
    }	
	
	
}*/





?>