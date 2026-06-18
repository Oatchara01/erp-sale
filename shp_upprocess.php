<?php
include "databaseshopee.php";
include "shopeeAPI.php";
include "dbconnect.php";


$add_date = date('Y-m-d H:i:s');
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
$running = '12'; 

?>
<form name="frmSearch" method="GET" >
<div class="w3-white">
<div class="w3-container w3-padding-large">	
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>กดรับ Shopee</h4>
					</div>		
<?php
	

	
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if (isset($_POST['order_ckk']) && isset($_POST['order_id'])) {
 $order_id = $_POST['order_id'];
 $order_ckk = $_POST['order_ckk'];	
	
foreach ($order_id as $orderSn ) {
 if (isset($order_ckk[$orderSn]) && $order_ckk[$orderSn] == 1) {	
	 
processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
if($orderSn!=''){	 
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id !=''";
mysqli_query($conn, $updateSQL);	
}	
}
}
}

if (isset($_POST['drop_ckk']) && isset($_POST['order_id'])) {
 $order_id = $_POST['order_id'];
$drop_ckk = $_POST['drop_ckk'];		
	
foreach ($order_id as $orderSn ) {
if (isset($drop_ckk[$orderSn]) && $drop_ckk[$orderSn] == 1) {	

processShopeeShipOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
if($orderSn!=''){	 	
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id !=''";
mysqli_query($conn, $updateSQL);	
}
}
}
}



if (isset($_POST['pickupto_ckk']) && isset($_POST['order_id'])) {
 $order_id = $_POST['order_id'];
$pickupto_ckk = $_POST['pickupto_ckk'];		
	
foreach ($order_id as $orderSn ) {
if (isset($pickupto_ckk[$orderSn]) && $pickupto_ckk[$orderSn] == 1) {	
	
        
processShopeeOrderPickupTomorrow($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);	
if($orderSn!=''){	 	
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id !=''";
mysqli_query($conn, $updateSQL);	
}
}
}

 }

}

$register_date = date('Y-m-d');

/*$strSQL = "SELECT order_id, cs_remark FROM so__main 
           WHERE sale_channel = '12' 
           AND order_refer_code = '' 
           AND register_date = '$register_date'";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");

$updated = 0;

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];
    $trackingNumber = getShopeeTrackingNumberOnly($orderSn, $partnerId, $partnerKey, $shopId, $accessToken);

    if ($trackingNumber) {
        $updateSQL = "UPDATE so__main 
                      SET order_refer_code = '$trackingNumber', ckk_item = '1' 
                      WHERE order_id = '$orderSn'";
        mysqli_query($conn, $updateSQL);
        $updated++;
    }
}*/



?>
	
	
</p></p></p></p>
<center>
<?php
$add_date = date('Y-m-d');	


?>
	
	
	
	</div></div>
	</p></p>
	
</center>

</form>