
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





/*$page_size = 100;
$cursor = '';
$max_pages = 50;
$page_count = 0;

do {
    $params = [
        'time_from' => strtotime('-7 days'),
        'time_to' => time(),
        'order_status' => 'READY_TO_SHIP',
        'page_size' => $page_size
    ];

    // เพิ่ม cursor ถ้ามี
    if (!empty($cursor)) {
        $params['cursor'] = $cursor;
    }

    $response = getOrders($accessToken, $params);
    $obj = json_decode($response);

    echo "<h4>➡️ PAGE: " . ($page_count + 1) . "</h4>";
    echo "<pre>🧪 Shopee Response:\n" . print_r($obj->response, true) . "</pre>";

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





//sale_channel='12' AND ckk_item = '0'
$strSQL = "SELECT order_id, ref_id FROM so__main WHERE sale_channel='12' AND ckk_item = '0'"; 
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
			
  	
}*/

$strSQL = "SELECT order_id, cs_remark
FROM so__main
WHERE sale_channel = '12'
  AND register_date = '".$register_date."'
  AND (
        cs_remark LIKE '%ด่วน%' 
        OR cs_remark LIKE '%(SHP Food)%'
      )
  AND cs_remark NOT LIKE '%Instant%'  and doc_no !='' and pre_ckk='0'
ORDER BY stock_remark DESC, create_order ASC
LIMIT 30";
$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];

 processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);	
	
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);	
	
}



$strSQL = "SELECT order_id,cs_remark FROM so__main WHERE sale_channel='12'  AND register_date ='".$register_date."' and sale_remark NOT LIKE '%ด่วน%'  and cs_remark NOT LIKE '%Instant%' order by stock_remark DESC,create_order ASC ";
$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderSn = $objResult["order_id"];

 processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);	
	
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);	
	
}






$yesterday = date('Y-m-d', strtotime('-1 day'));
//sale_channel='12' AND register_date = '".$yesterday."' and cs_remark LIKE '%ด่วน%'
$strSQL = "SELECT order_id FROM so__main WHERE sale_channel='12' AND register_date = '".$yesterday."' and order_refer_code=''  and cs_remark NOT LIKE '%Instant%' and doc_no !='' and pre_ckk='0'";

$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");
while ($objResult = mysqli_fetch_array($objQuery)) {
	
$orderSn = $objResult["order_id"];
processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);	
	
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);	
	
	
}

$strSQL = "SELECT order_id FROM so__main WHERE sale_channel='12' AND register_date > '2026-01-01' and order_refer_code=''  and cs_remark NOT LIKE '%Instant%' and doc_no !='' and pre_ckk='1'";

$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");
while ($objResult = mysqli_fetch_array($objQuery)) {
	
$orderSn = $objResult["order_id"];
processShopeeOrder($orderSn, $conn, $partnerId, $partnerKey, $shopId, $accessToken);	
	
$updateSQL = "UPDATE so__main SET printst_ckk='1', ckk_item='1',update_time ='".$add_date."' WHERE order_id='" . $orderSn . "' and order_id!=''";
mysqli_query($conn, $updateSQL);	
	
	
}


$strSQL = "SELECT order_id, cs_remark FROM so__main WHERE order_refer_code ='' ";
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


?>





