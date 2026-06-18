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
$strSQL = "SELECT order_id FROM so__main  where sale_channel='".$running."'  and ckk_item ='0'";
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



$add_date = date('Y-m-d');	

$sql2 = "SELECT ref_id FROM so__main WHERE sale_channel = '1' and register_date = '" .$add_date. "' and ckk_item='0'";
$result2 = mysqli_query($conn, $sql2);
$Num_Rows21 = mysqli_num_rows($result2);
while($objResult12 = mysqli_fetch_array($result2))
{
	
	
	
// 1 	
	 
$sql22 = "SELECT SUM(sale_count) AS sale_count FROM so__submain where ref_idd='".$objResult12["ref_id"]."' and ckk_free='1'";
$query22 = mysqli_query($conn,$sql22) or die(mysqli_error());
$Num_Rows22 = mysqli_num_rows($query22);
$fetch22 = mysqli_fetch_array($query22);
	
if($Num_Rows22 > 0){	
	
if ($fetch22["sale_count"] >= 1 && $fetch22["sale_count"] <= 100) {
    $count_free = $fetch22["sale_count"];
	
	
$strSQL19 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$objResult12["ref_id"]."','".$count_free."','".$count_free."','0.00','0.00','0.00','0.00','5796','5796','','Approve','แถมพิเศษ หน้ากากอนมัยคละสี 1 ซอง')";
$objQuery19 = mysqli_query($conn,$strSQL19);	
	
	
	
} else {
    $count_free = '0'; // ค่าเริ่มต้น ถ้าเกินขอบเขต
}
}
	

//2
	
	
	
$sql23 = "SELECT SUM(sale_count) AS sale_count FROM so__submain where ref_idd='".$objResult12["ref_id"]."' and ckk_free='2'";
$query23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$Num_Rows23 = mysqli_num_rows($query23);
$fetch23 = mysqli_fetch_array($query23);
	
if($fetch23["sale_count"]>='2'){

if($fetch23["sale_count"] >= 2 && $fetch23["sale_count"] <= 100){
    $count_free = floor($fetch23["sale_count"] / 2); // คำนวณหารค่า free ตามที่กำหนด
	

$strSQL19 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$objResult12["ref_id"]."','".$count_free."','".$count_free."','0.00','0.00','0.00','0.00','5796','5796','','Approve','แถมพิเศษ หน้ากากอนมัยคละสี 1 ซอง')";
$objQuery19 = mysqli_query($conn,$strSQL19);
	
	
} else {
    $count_free = 0; // ค่าเริ่มต้นในกรณีที่ไม่อยู่ในช่วงที่กำหนด
}


}
		
}	

	

$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '".$running."'";
$objQuery = mysqli_query($conn,$strSQL);	




	

	?>



