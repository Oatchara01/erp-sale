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
//$register_date = "2026-03-22";



//register_date ='".$register_date."' and select_type_doc!='3' and select_type_doc !='4'


$strSQL = "SELECT order_id FROM so__main WHERE sale_channel='12' and register_date ='".$register_date."' and select_type_doc!='3' and select_type_doc !='4' AND email != '' AND tax_id != '' AND doc_no NOT LIKE '%E%' AND doc_no != '' AND cancel_ckk = '0' AND tax_id REGEXP '^[0-9]{13}$' AND tax_id !='0000000000000'";
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





?>