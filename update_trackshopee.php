<?php
include "dbconnect.php";
include "databaseshopee.php";
include "shopeeAPI.php";

$running = 12;
$partnerId = '2007594';
$partnerKey = 'shpk6d4e6b6c4d744162716f4147625073594c645a4377685550774e67457266';
$shopId = '24017696';

$accessToken1 = getTokenFromDB($running);
$accessToken = base64_decode($accessToken1);


$register_date = date('Y-m');
//$register_date = "2026";

//           AND register_date = '$register_date'";
$strSQL = "SELECT order_id, cs_remark FROM so__main 
           WHERE sale_channel = '12' 
           AND order_refer_code = '' AND cancel_ckk='0'
           AND register_date LIKE '%$register_date%'";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");

$updated = 0;

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];
    $trackingNumber = getShopeeTrackingNumberOnly($orderSn, $partnerId, $partnerKey, $shopId, $accessToken);

    if ($trackingNumber) {
        $updateSQL = "UPDATE so__main 
                      SET order_refer_code = '$trackingNumber'  WHERE order_id = '$orderSn'";
        mysqli_query($conn, $updateSQL);
        $updated++;
    }
}

echo "<script language=\"JavaScript\">";
echo "alert('อัพเดตเลขขนส่งเรียบร้อยแล้วนะคะ');window.location='upload_shopee.php';";
echo "</script>";

?>

