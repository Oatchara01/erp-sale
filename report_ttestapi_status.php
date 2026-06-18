<?php

include"dbconnect.php";
include "databaseshopee.php";
include "shopeeAPI.php";

$running = 12;
$partnerId = '2007594';
$partnerKey = '55545565657347696252734e79556564616842614971476c6b784d6f74494342';
$shopId = '24017696';

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


$register_date = date('Y-m-d');





$strSQL = "SELECT order_id FROM so__main WHERE sale_channel='12' and register_date ='".$register_date."' and select_type_doc!='3' and select_type_doc !='4' ";
$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];
    $invoiceInfo = getBuyerInvoiceInfo($partnerId, $partnerKey, $shopId, $accessToken, $orderSn, false);

    if ($invoiceInfo['success']) {
        // เช็คว่ามีใบกำกับจริงไหม (is_requested = true)
        if (isset($invoiceInfo['data'][0]['is_requested']) && $invoiceInfo['data'][0]['is_requested']) {
            updateOrders($invoiceInfo, $orderSn);
			//echo "มีใบกำกับ";
        } else {
            echo "❌ ไม่มีใบกำกับภาษีสำหรับ order_sn: $orderSn<br>";
        }
    } else {
        echo "Error: {$invoiceInfo['error']} \n";
        echo "HTTP Code: {$invoiceInfo['http_code']} \n";
        print_r($invoiceInfo['data']);
    }
			
  	
}



/*$strSQL = "SELECT order_id, cs_remark FROM so__main WHERE sale_channel ='12'  AND order_refer_code = '' and register_date = '".$register_date."'";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];

    $trackingNumber = getShopeeTrackingNumberOnly($orderSn, $partnerId, $partnerKey, $shopId, $accessToken);

    // อัปเดต DB ถ้าได้ tracking
    if ($trackingNumber) {
        $updateSQL = "UPDATE so__main SET order_refer_code='" . $trackingNumber . "', ckk_item='1' WHERE order_id='" . $orderSn . "'";
        mysqli_query($conn, $updateSQL);
       // echo "✅ อัปเดต DB เรียบร้อย: $trackingNumber\n";
    } else {
       // echo "❌ ยังไม่ได้ tracking number สำหรับ $orderSn\n";
    }
}





/*function processShopeeOrderDropOnly($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken) {
    echo "\n======= Processing Dropoff Order: $orderSn =======\n";

    // STEP 1: Get Shipping Parameter
    $path = '/api/v2/logistics/get_shipping_parameter';
    $timestamp = time();
    $sign = generateShopeeSign($partnerKey, $partnerId, $path, $timestamp, $accessToken, $shopId);

    $url = "https://partner.shopeemobile.com$path";
    $url .= "?access_token=$accessToken&order_sn=$orderSn&partner_id=$partnerId&shop_id=$shopId&sign=$sign&timestamp=$timestamp";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);
    $responseShipping = curl_exec($curl);
    curl_close($curl);

    $dataShipping = json_decode($responseShipping, true);

    if (!isset($dataShipping['response']['dropoff']['branch_list'][0]['branch_id'])) {
        echo "❌ ไม่พบ dropoff branch สำหรับ $orderSn\n";
        return;
    }

    $branchId = $dataShipping['response']['dropoff']['branch_list'][0]['branch_id'];
    echo "✅ Dropoff Branch ID: $branchId\n";

    // STEP 2: Ship Order (Dropoff)
    $path = '/api/v2/logistics/ship_order';
    $timestamp = time();
    $sign = generateShopeeSign($partnerKey, $partnerId, $path, $timestamp, $accessToken, $shopId);

    $url = "https://partner.shopeemobile.com$path";
    $url .= "?access_token=$accessToken&partner_id=$partnerId&shop_id=$shopId&sign=$sign&timestamp=$timestamp";

    $body = [
        'order_sn' => $orderSn,
        'package_number' => '',
        'dropoff' => [
            'branch_id' => $branchId,
            'tracking_number' => ''
        ]
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);
    $responseShip = curl_exec($curl);
    curl_close($curl);

    $dataShip = json_decode($responseShip, true);

    if (isset($dataShip['error']) && $dataShip['error'] !== '') {
        echo "❌ Ship Order Failed: " . $dataShip['message'] . "\n";
        return;
    }

    echo "✅ Ship Order Success (Dropoff)\n";

    // STEP 3: Get Tracking Number
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
    $responseTrack = curl_exec($curl);
    curl_close($curl);

    $dataTrack = json_decode($responseTrack, true);

    if (isset($dataTrack['response']['tracking_number'])) {
        $trackingNumber = $dataTrack['response']['tracking_number'];
        echo "✅ Tracking Number: $trackingNumber\n";

        // อัปเดต DB
        $updateSQL = "UPDATE so__main SET order_refer_code='$trackingNumber', ckk_item='1' WHERE order_id='$orderSn'";
        mysqli_query($conn, $updateSQL);
        echo "✅ อัปเดตฐานข้อมูลเรียบร้อยแล้ว\n";
    } else {
        echo "❌ ไม่พบ Tracking Number สำหรับ $orderSn\n";
    }
}*/


	
 // เปลี่ยนเป็นออเดอร์ที่ต้องการ
//processShopeeOrderDropOnly($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
	
/*$orderSn = '25051625HC18XT';
function getOrderLogistics($orderSn, $partnerId, $partnerKey, $accessToken, $shopId) {
    $path = '/api/v2/logistics/get_order_logistics';
    $timestamp = time();
    $sign = generateShopeeSign($partnerKey, $partnerId, $path, $timestamp, $accessToken, $shopId);

    $url = "https://partner.shopeemobile.com$path?access_token=$accessToken&order_sn=$orderSn&partner_id=$partnerId&shop_id=$shopId&timestamp=$timestamp&sign=$sign";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);
    $response = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response, true);
    print_r($result);
}


getOrderLogistics($orderSn, $partnerId, $partnerKey, $accessToken, $shopId);*/


?>