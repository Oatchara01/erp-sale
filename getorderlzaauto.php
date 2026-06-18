<script type="text/javascript" src="//laz-g-cdn.alicdn.com/sj/securesdk/0.0.3/securesdk_lzd_v1.js" id="J_secure_sdk_v2" data-appkey="124441"></script>
<?php
include "databaseHelper.php";
include "LazadaAPI.php";
require_once 'LazopSdk.php';
include "dbconnect.php";
//include "head.php";


$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '1' and ckk_item='0'";
$objQuery = mysqli_query($conn,$strSQL);	

$strSQL = "Update  so__uppack set ckk_closd='1' Where sale_channel= '1'";
$objQuery = mysqli_query($conn,$strSQL);	



$start_date = date('Y-m-d', strtotime('-7 days'));
$start_time = "00:00:00";
$end_date = date('Y-m-d');
$end_time = date('H:i:s');
$t = "T";
$zone = "+07:00";

$create_time = "$start_date$t$start_time$zone";	
$createend_time = "$end_date$t$end_time$zone";	
$status = "pending";
$running = '1'; 	
	


$refresh_token = getRefreshTokenFromDB($running);
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

$params = [
        [
        "name"   => "offset",
        "value" => 0
    ],
	[
        "name"   => "status",
        "value" => $status
    ],
    [
        "name"   => "sort_by",
        "value" => "created_at"
    ],
  [
        "name"   => "created_after",
        "value" => $create_time
    ],
	[
        "name"   => "created_before",
        "value" => $createend_time
    ]
    
    
];

$obj = getOrders(base64_decode($accessToken), $params);
if ($obj->code == "0" && $obj->data->count >= 1) {
           saveOrders($obj, $running);
}else{
    echo "no data";
	exit();
}



//ดึงสินค้า


$running = '1'; 	
$strSQL = "SELECT order_id FROM so__main  where sale_channel='1'  and ckk_item ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery))
{

$order_id = $objResult["order_id"];
$accessToken = getTokenFromDB($running);

$params = [
    [
        "name"   => "order_id",
        "value" => $order_id
    ]
];

$obj = getOrderItems(base64_decode($accessToken), $params);


if ($obj->code == "0") {
     $x = 0;
     while($x < $obj->data->count) {
		if($running=='1'){
		 
$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$sku."'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($query2);
	if($Num_Rows2 > 0){	
		
	 echo "The order_number is: ".$obj->data->orders[$x]->order_number."<br>"; 
	echo "รายการสินค้า SKU :"  .$obj->data[$x]->sku. "<br>";  
	
	}else{	
			
         echo "The order_number is: ".$obj->data->orders[$x]->order_number."<br>"; 
		 echo "ไม่เจอรายการสินค้า SKU :"  .$obj->data[$x]->sku. "<br>";  
	}
			
		}else if($running=='20'){
$sql2 = "SELECT * FROM tb_product_med where code_lazada='".$sku."'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($query2);		
	if($Num_Rows2 > 0){	}else{	
			
         echo "The order_number is: ".$obj->data->orders[$x]->order_number."<br>"; 
		 echo "ไม่เจอรายการสินค้า SKU :"  .$obj->data[$x]->sku. "<br>";  
	}		
			
			
		}
	$x+=1;	 
       } 
   saveOrderItems($obj, $order_id, $running);
}
}



$strSQL   = "SELECT order_id, order_item_id FROM so__uppack WHERE sale_channel='1' AND ckk_closd='0'";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $orderId     = $objResult['order_id'];
    $orderItemId = $objResult['order_item_id'];

    // เตรียมข้อมูลสำหรับ Pack Order
    $params = [
    [
        "name"  => "packReq",
        "value" => json_encode([
            'pack_order_list' => [
                [
                    'order_id'        => $orderId,
                    'order_item_list' => [$orderItemId]
                ]
            ],
            'delivery_type'          => 'dropship',
            'shipping_allocate_type' => 'TFS'
        ], JSON_UNESCAPED_UNICODE)
    ]
];


    // เรียกใช้งานฟังก์ชันเพื่อ Pack Order
    $packData = setStatusToPackedByMarketplace($accessToken, $params);

    if (isset($packData->code) && $packData->code === '0') {
        echo "คำสั่งซื้อ $orderId ถูก Pack สำเร็จ!<br>";

     
    } else {
        $errorMsg = isset($packData->message) ? $packData->message : 'Unknown error';
        echo "การอัปเดตสถานะ Pack สำหรับคำสั่งซื้อ $orderId ล้มเหลว: $errorMsg<br>";
    }
}

	
	
	
	
$strSQL = "SELECT order_id FROM so__main WHERE sale_channel='1' AND ckk_item='0'";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");

while ($objResult = mysqli_fetch_array($objQuery)) { 
    $orderId = $objResult['order_id'];

    // ตั้งค่าพารามิเตอร์เพื่อดึงข้อมูลจาก Lazada API
    $paramsGet = [
        ["name" => "order_id", "value" => $orderId]
    ];

    // เรียกใช้ฟังก์ชัน getOrderItems เพื่อดึงข้อมูลสินค้าในคำสั่งซื้อ
    $getData = getOrderItems($accessToken, $paramsGet);

    // ตรวจสอบว่ามีข้อมูลที่ได้รับจาก API หรือไม่
    if (isset($getData->data->order_items) && is_array($getData->data->order_items)) {
        foreach ($getData->data->order_items as $item) {
            if (isset($item->tracking_number)) {
                $trackingNumber = $item->tracking_number;
                
                // อัปเดต Tracking Number ลงฐานข้อมูล
                $updateSQL = "UPDATE so__main SET order_refer_code='$trackingNumber' WHERE order_id='$orderId'";
                if (mysqli_query($conn, $updateSQL)) {
                    echo "อัปเดตคำสั่งซื้อ $orderId สำเร็จ! Tracking Number: $trackingNumber<br>";
                } else {
                    echo "Error Updating Order $orderId: " . mysqli_error($conn) . "<br>";
                }
            } else {
                echo "ไม่พบ Tracking Number สำหรับคำสั่งซื้อ $orderId<br>";
            }
        }
    } else {
        echo "ไม่สามารถดึงข้อมูลสินค้าสำหรับคำสั่งซื้อ $orderId ได้ หรือไม่มีสินค้าในคำสั่งซื้อนี้<br>";
    }
}







$add_date = date('Y-m-d');	


	

$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '1'";
$objQuery = mysqli_query($conn,$strSQL);	

$strSQL = "Update  so__uppack set ckk_closd='1' Where sale_channel= '1'";
$objQuery = mysqli_query($conn,$strSQL);	



	

	?>



