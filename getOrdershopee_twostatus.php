
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



$page_size = 100;
$cursor = '';
$max_pages = 50;
$page_count = 0;

do {

    /*$params = [
        'time_from' => strtotime('2026-03-07 13:45:00'),
        'time_to' => strtotime('2026-03-07 13:46:00'),
        'order_status' => 'READY_TO_SHIP',
        'page_size' => $page_size
    ];*/

    
    $params = [
        'time_from' => strtotime('-7 days'),
        'time_to' => time(),
        'order_status' => 'READY_TO_SHIP',
        'page_size' => $page_size
    ];
    

    if (!empty($cursor)) {
        $params['cursor'] = $cursor;
    }

    $response = getOrders($accessToken, $params);
    $obj = json_decode($response);

    echo "<h4>➡️ PAGE: " . ($page_count + 1) . "</h4>";
    echo "<pre>🧪 Shopee Response:\n" . print_r($obj->response ?? [], true) . "</pre>";

    if (isset($obj->response->order_list) && count($obj->response->order_list) > 0) {
        foreach ($obj->response->order_list as $order) {
            $order_sn_list = [$order->order_sn];

            $params_order_items = ['order_sn_list' => $order_sn_list];
            $order_items_response = getOrderItems($accessToken, $params_order_items);
            $order_items_obj = json_decode($order_items_response);

            if (isset($order_items_obj->response->order_list)) {
                saveOrders($order_items_obj, $running);
            }
        }

        $has_more = isset($obj->response->more) && $obj->response->more === true;
        $cursor = $obj->response->next_cursor ?? '';

    } else {
        echo "🚫 No more orders found.<br>";
        $has_more = false;
    }

    $page_count++;
    if ($page_count >= $max_pages) {
        echo "⚠️ Stopped loop after reaching max page limit ($max_pages).<br>";
        break;
    }

} while ($has_more);

// ===========================
// STEP 2: ดึง package pre-order จาก search_package_list
// แล้วอัปเดต so__main.is_pre_order = 1
// ===========================
echo "<h3>📦 ตรวจสอบ Pre-Order จาก search_package_list</h3>";

$preCursor = "";
$prePageSize = 100;
$preHasMore = true;
$prePage = 1;
$preMaxPages = 50;

do {
    $filters = [
        'is_pre_order' => 1
    ];

    $pagination = [
        'cursor' => $preCursor,
        'page_size' => $prePageSize
    ];

    $sort = [
        'ascending' => false,
        'sort_type' => 1
    ];

    $preResponse = searchPackageList($accessToken, $filters, $pagination, $sort);
    $preObj = json_decode($preResponse, true);

    echo "<pre>📄 PREORDER PAGE {$prePage}\n";
    print_r($preObj);
    echo "</pre>";

    if (!empty($preObj['response']['packages_list'])) {
        foreach ($preObj['response']['packages_list'] as $package) {
            $orderSn = $package['order_sn'] ?? '';
            $packageNumber = $package['package_number'] ?? '';

            if (!empty($orderSn)) {
                $orderSnEsc = mysqli_real_escape_string($conn, $orderSn);

                $updatePreSql = "
                    UPDATE so__main 
                    SET pre_ckk='1'
                    WHERE order_id='{$orderSnEsc}'
                      AND sale_channel='12'
                ";

                if (mysqli_query($conn, $updatePreSql)) {
                    echo "✅ PRE-ORDER UPDATED | order_sn: {$orderSn} | package_number: {$packageNumber}<br>";
                } else {
                    echo "❌ UPDATE FAIL | order_sn: {$orderSn} | error: " . mysqli_error($conn) . "<br>";
                }
            }
        }
    } else {
        echo "❌ ไม่พบ package pre-order ใน PAGE {$prePage}<br>";
    }

    $preHasMore = $preObj['response']['pagination']['more'] ?? false;
    $preCursor  = $preObj['response']['pagination']['next_cursor'] ?? '';
    $prePage++;

    if ($prePage > $preMaxPages) {
        echo "⚠️ หยุด loop pre-order เพราะเกิน max page limit ({$preMaxPages})<br>";
        break;
    }

} while ($preHasMore);


//AND ckk_item = '0'





$strSQL = "SELECT order_id, ref_id FROM so__main WHERE sale_channel='12' AND ckk_item = '0' "; 
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");

while ($row = mysqli_fetch_assoc($objQuery)) {
    $order_sn = $row['order_id'];

	    // เรียก Shopee API
    $escrow_json = getEscrowDetail($accessToken, $order_sn);
    $escrow_obj = json_decode($escrow_json);

    if (isset($escrow_obj->response)) {
        // ส่งไปบันทึก
        saveOrderItemWithEscrowFromDetail($escrow_obj->response, $order_sn);
    } else {
        echo "❌ ไม่พบข้อมูล Shopee สำหรับ $order_sn<br>";
    }
	    sleep(1); // ป้องกัน rate limit จาก Shopee
}





$strSQL = "SELECT order_id FROM so__main WHERE sale_channel='12' AND ckk_item = '0'";
$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];
    $invoiceInfo = getBuyerInvoiceInfo($partnerId, $partnerKey, $shopId, $accessToken, $orderSn, false);

    if ($invoiceInfo['success']) {
        // เช็คว่ามีใบกำกับจริงไหม (is_requested = true)
        if (isset($invoiceInfo['data'][0]['is_requested']) && $invoiceInfo['data'][0]['is_requested']) {
            updateOrders($invoiceInfo, $orderSn);
        } else {
            echo "❌ ไม่มีใบกำกับภาษีสำหรับ order_sn: $orderSn<br>";
        }
    } else {
        echo "Error: {$invoiceInfo['error']} \n";
        echo "HTTP Code: {$invoiceInfo['http_code']} \n";
        print_r($invoiceInfo['data']);
    }
			
  	
}


$strSQL = "SELECT order_id, cs_remark, stock_remark,sale_remark FROM so__main WHERE sale_channel = '12' AND order_refer_code='' and register_date = '" . $register_date . "' and cs_remark NOT LIKE '%Instant%' and pre_ckk='0' and doc_no !=''";

$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];
    $stock_remark = $objResult["stock_remark"];
	$cs_remark = $objResult["cs_remark"]; 

if (empty($orderSn)) {
		
$updateSQL = "UPDATE so__main SET cancel_ckk='1', cancel_des='ลูกค้ายกเลิกในระบบ Shopee' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);
	
		
        echo "❌ ไม่พบ order_id ค่ะ\n";
        continue;
}

//if ($stock_remark == 'pickup') {

if($sale_remark=='Express Delivery - ส่งด่วน'){	
	
processShopeeOrderPickupToday1PM($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);	

$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);
	
/*}else if($cs_remark == 'SPX Express'){	
	
processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1' WHERE order_id='" . $orderSn . "' ";
mysqli_query($conn, $updateSQL);	
	
}else{
	
processShopeeShipOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1' WHERE order_id='" . $orderSn . "' ";
mysqli_query($conn, $updateSQL);	
		
	}	*/
	
    } else {
	
 processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);	
//processShopeeShipOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1' WHERE order_id='" . $orderSn . "' ";
mysqli_query($conn, $updateSQL);	
	
    }
}



$strSQL = "SELECT order_id, cs_remark, stock_remark,sale_remark FROM so__main WHERE sale_channel = '12' AND order_refer_code='' and register_date > '2026-01-01' and cs_remark NOT LIKE '%Instant%' and pre_ckk='1' and doc_no !=''";

$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];
    $stock_remark = $objResult["stock_remark"];
	$cs_remark = $objResult["cs_remark"]; 

if (empty($orderSn)) {
		
$updateSQL = "UPDATE so__main SET cancel_ckk='1', cancel_des='ลูกค้ายกเลิกในระบบ Shopee' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);
	
		
        echo "❌ ไม่พบ order_id ค่ะ\n";
        continue;
}

//if ($stock_remark == 'pickup') {

if($sale_remark=='Express Delivery - ส่งด่วน'){	
	
processShopeeOrderPickupToday1PM($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);	

$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);
	
/*}else if($cs_remark == 'SPX Express'){	
	
processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1' WHERE order_id='" . $orderSn . "' ";
mysqli_query($conn, $updateSQL);	
	
}else{
	
processShopeeShipOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1' WHERE order_id='" . $orderSn . "' ";
mysqli_query($conn, $updateSQL);	
		
	}	*/
	
    } else {
	
 processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);	
//processShopeeShipOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1' WHERE order_id='" . $orderSn . "' ";
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




$strSQL5 = "SELECT *  FROM so__main  WHERE sale_channel = '12' and register_date = '" . $register_date . "'  and ckk_item='0' and doc_no LIKE '%E%'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die(mysqli_error());
while($objResuut5 = mysqli_fetch_array($objQuery5)){
	
if ($objResuut5["select_type_doc"]=='3'){
$com ="ออลล์เวล ไลฟ์ บจก.";
}else if ($objResuut5["select_type_doc"]=='4'){
$com="โนเบิล เมด บจก.";	
}	
	
if($objResuut5["delivery_date"]!='0000-00-00'){		
$delivery_date = $objResuut5["delivery_date"];
}else{
$delivery_date = $objResuut5["doc_release_date"];	
}	
		
$billing_name = $objResuut5["billing_name"];
$ref_id = $objResuut5["ref_id"];
$bill_id = $objResuut5["bill_id"];	
$sale_channel = $objResuut5["sale_channel"];	
$doc_no	= $objResuut5["doc_no"];
$order_id	= $objResuut5["order_id"];	
	
$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$objResuut5["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);	
	
$amount_1 = $objResult15["amount_1"];	

$strSQL2 = "SELECT ref_id FROM tb_register_data  WHERE ref_id = '".$objResuut5["ref_id"]."' ";
$objQuery2 = mysqli_query($code,$strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);

if($Num_Rows2 > 0){ }else{

$strSQL29="insert into   tb_register_data (IV_number,date_inv,company,customer_name,unit_cash,cash,employee_name,ref_id,credit,description,bill_id,sale_channel,summary,summary_work,summary_ckk,order_id) 
values ('".$doc_no."','".$delivery_date."','".$com."','".$billing_name."','".$amount_1."','36','".$add_by."','".$ref_id."','1','Shopee','".$bill_id."','".$sale_channel."','สมบูรณ์','สมบูรณ์','1','".$order_id."')";
		
$objQuery29 = mysqli_query($code,$strSQL29);	
	
	 
 }
	 
}
 	 


$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '12'";
$objQuery = mysqli_query($conn,$strSQL);	


echo "<script language=\"JavaScript\">";
echo "alert('ดึงออเดอร์เรียบร้อยแล้วนะคะ');window.location='upload_shopee.php';";
echo "</script>";



?>





