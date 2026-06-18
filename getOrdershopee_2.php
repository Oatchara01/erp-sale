
<?php

include "databaseshopee.php";
include "shopeeAPI.php";
include "dbconnect.php";
include "dbconnect_acc.php";


$add_date = date('Y-m-d H:i:s');
$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '12'";
$objQuery = mysqli_query($conn,$strSQL);

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


$strSQL = "SELECT order_id, cs_remark, stock_remark,sale_remark FROM so__main WHERE sale_channel = '12' AND order_refer_code='' and register_date = '" . $register_date . "' and cs_remark NOT LIKE '%Instant%' and doc_no !='' and pre_ckk='0'";

$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];
    $stock_remark = $objResult["stock_remark"];
    $cs_remark = $objResult["cs_remark"];	
	  $sale_remark = $objResult["sale_remark"];	

    if (empty($orderSn)) {
		
$updateSQL = "UPDATE so__main SET cancel_ckk='1', cancel_des='ลูกค้ายกเลิกในระบบ Shopee' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);		
		
        echo "❌ ไม่พบ order_id ค่ะ\n";
        continue;
    }
//Express Delivery - ส่งด่วน
	
if ($sale_remark == 'Express Delivery - ส่งด่วน') {	
	
processShopeeOrderPickupToday1PM($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);

$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);
	
/*}else if ($stock_remark == 'pickup') {
       processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);

$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);*/


   } else {
       //processShopeeShipOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
 	processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
	
    $updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id!=''";
    mysqli_query($conn, $updateSQL);	

    }
}




$strSQL = "SELECT order_id, cs_remark, stock_remark,sale_remark FROM so__main WHERE sale_channel = '12' AND order_refer_code='' and register_date > '2026-01-01' and cs_remark NOT LIKE '%Instant%' and doc_no !='' and pre_ckk='1'";

$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];
    $stock_remark = $objResult["stock_remark"];
    $cs_remark = $objResult["cs_remark"];	
	  $sale_remark = $objResult["sale_remark"];	

    if (empty($orderSn)) {
		
$updateSQL = "UPDATE so__main SET cancel_ckk='1', cancel_des='ลูกค้ายกเลิกในระบบ Shopee' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);		
		
        echo "❌ ไม่พบ order_id ค่ะ\n";
        continue;
    }
//Express Delivery - ส่งด่วน
	
if ($sale_remark == 'Express Delivery - ส่งด่วน') {	
	
processShopeeOrderPickupToday1PM($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);

$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);
	
/*}else if ($stock_remark == 'pickup') {
       processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);

$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);*/


   } else {
       //processShopeeShipOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
 	processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
	
    $updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id!=''";
    mysqli_query($conn, $updateSQL);	

    }
}





$strSQL = "SELECT order_id, cs_remark FROM so__main WHERE sale_channel ='12' AND order_refer_code='' and register_date = '" . $register_date . "' ";
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


$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '12'";
$objQuery = mysqli_query($conn,$strSQL);	


?>





