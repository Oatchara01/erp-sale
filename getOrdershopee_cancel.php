<?php

include "databaseshopee.php";
include "shopeeAPI.php";
include "dbconnect.php";
include "dbconnect_acc.php";



$running = 12; 
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



// GET order
$accessToken1 = getTokenFromDB($running);
$accessToken = base64_decode($accessToken1);
$register_date = date('Y-m-d');


$cursor = '';
$more = true;
$add_date = date('Y-m-d H:i:s');

do {
    $response = getCancelledOrders($accessToken, [
        'cursor' => $cursor,
        'page_size' => 50,
        'time_from' => strtotime('-7 days'),
        'time_to' => time(),
    ]);

    $data = json_decode($response, true);

    $orders = $data['response']['order_list'] ?? [];

    foreach ($orders as $order) {

        $orderSn = $order['order_sn'] ?? '';

        if ($orderSn == '') {
            continue;
        }

        $orderSn = mysqli_real_escape_string($conn, $orderSn);

        $updateSQL = "
            UPDATE so__main
            SET 
                cancel_ckk = '2',
                cancel_des = 'ลูกค้ายกเลิกในระบบ Shopee',
                cancel_date = '$add_date'
            WHERE order_id = '$orderSn'
            AND sale_channel = '12'
            AND cancel_ckk = '0'
            AND order_id != ''
			AND iv_no = ''
        ";

        mysqli_query($conn, $updateSQL);
    }

    $cursor = $data['response']['next_cursor'] ?? '';
    $more   = $data['response']['more'] ?? false;

} while ($more === true && $cursor !== '');



echo "<script language=\"JavaScript\">";
echo "alert('ดึงออเดอร์เรียบร้อยแล้วนะคะ');window.location='upload_shopee.php';";
echo "</script>";



?>





