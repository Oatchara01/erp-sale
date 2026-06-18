<script type="text/javascript" src="//laz-g-cdn.alicdn.com/sj/securesdk/0.0.3/securesdk_lzd_v1.js" id="J_secure_sdk_v2" data-appkey="124441"></script>
<?php
include "databaseHelper.php";
include "LazadaAPI.php";
include "dbconnect.php";
include "dbconnect_acc.php";	
include "head.php";
require_once 'LazopSdk.php';



// GetOrders document
// https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.6eb26bbee13fB7#/api?cid=8&path=/orders/get

//getOrderItems.php?running=3&order_id=343625041925813
?>
<form name="frmSearch" method="GET" >
<?php
$running = $_GET["running"]; //running number in database and statuses = 'pending'
	
	
//$strSQL = "SELECT order_id,ref_id   FROM shopOrders  where shop_running ='".$running."' and ckk_item='0'";
$strSQL = "SELECT order_id   FROM so__main  where sale_channel='".$running."'  and ckk_item ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery))
{

$order_id = $objResult["order_id"];
$accessToken = getTokenFromDB($running);

//echo $accessToken;

//params options filter orders
$params = [
    [
        "name"   => "order_id",
        "value" => $order_id
    ]
];

$obj = getOrderItems(base64_decode($accessToken), $params);

//echo $obj;

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
	

	
	
	
/*$accessToken = base64_decode(getTokenFromDB($running));	
	
$strSQL   = "SELECT order_id, order_item_id FROM so__uppack WHERE sale_channel='$running' AND ckk_closd='0'";
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
	*/
	
	
	
	
/*$strSQL = "SELECT order_id, order_item_id FROM so__main WHERE sale_channel='$running' AND ckk_item='0'";
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
	*/
	
	
	

/*$apiUrl = 'https://api.lazada.co.th/rest';
	
	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM so__printecom1";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "WB";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$so = "WB";
$ref_id ="$so$nextId";
	
	
$strSQL = "SELECT order_id,order_item_id   FROM so__main  where sale_channel='".$running."'  and ckk_item ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery))
{
	
$orderId = $objResult['order_id'];
    $orderItemId = $objResult['order_item_id'];

    // สร้างคำขอไปยัง Lazada API
    $c = new LazopClient($apiUrl, $appKey, $appSecret);
    $request = new LazopRequest('/order/package/document/get');

    // สร้าง JSON สำหรับ parameter `getDocumentReq`
    $getDocumentReq = [
        "doc_type" => "PDF",
        "print_item_list" => false,
        "packages" => [
            ["package_id" => $orderItemId] // ใช้ order_item_id เป็น package_id
        ]
    ];

    $request->addApiParam('getDocumentReq', json_encode($getDocumentReq));
    $response = $c->execute($request, $accessToken);
    $responseData = json_decode($response, true);

    // ตรวจสอบผลลัพธ์จาก API
    if ($responseData['code'] === '0' && $responseData['result']['success'] === "true") {
        $pdfUrl = $responseData['result']['data']['pdf_url'];

        // ดาวน์โหลดไฟล์ PDF และบันทึก
        $pdfContent = file_get_contents($pdfUrl);
		$navk_ev = '' . $orderId . '_package_document.pdf';
        $savePath = 'downloads/' . $orderId . '_package_document.pdf';
        file_put_contents($savePath, $pdfContent);

        echo "ดาวน์โหลดใบปะหน้า $orderId สำเร็จ: $savePath<br>";

        // อัปเดตสถานะในฐานข้อมูล
		$add_date = date('Y-m-d H:i:s');

$updateSQL = "insert into so__printecom1 (order_id,register_date,ref_id,sale_channel,img_wb) 
values('".$orderId."','".$add_date."','".$ref_id."','".$running."','".$navk_ev."')'";
        mysqli_query($conn, $updateSQL);
    } else {
        echo "เกิดข้อผิดพลาดกับคำสั่งซื้อ $orderId: " . $responseData['result']['error_msg'] . "<br>";
    }	
	
	
}
*/
	
	
?>
</p></p></p></p>
<center>
<?php
$add_date = date('Y-m-d');	

	
$sql02 = "SELECT ref_id FROM so__main WHERE sale_channel = '".$running."' and register_date = '" .$add_date. "' and ckk_item='0' and cs_remark LIKE '%LEX%'";
$result02 = mysqli_query($conn, $sql02);
$Num_Rows021 = mysqli_num_rows($result02);
	
$sql01 = "SELECT ref_id FROM so__main WHERE sale_channel = '".$running."' and register_date = '" .$add_date. "' and ckk_item='0' and cs_remark LIKE '%Kerry%'";
$result01 = mysqli_query($conn, $sql01);
$Num_Rows011 = mysqli_num_rows($result01);	

$sql04 = "SELECT ref_id FROM so__main WHERE sale_channel = '".$running."' and register_date = '" .$add_date. "' and ckk_item='0' and cs_remark = ''";
$result04 = mysqli_query($conn, $sql04);
$Num_Rows041 = mysqli_num_rows($result04);	

$sql051 = "SELECT ref_id FROM so__main WHERE sale_channel = '".$running."' and register_date = '" .$add_date. "' and ckk_item='0' and cs_remark LIKE '%Flash%'";
$result051 = mysqli_query($conn, $sql051);
$Num_Rows051 = mysqli_num_rows($result051);	
	
	
	
	
$sql03 = "SELECT order_id FROM so__main WHERE sale_channel = '".$running."' and register_date = '" .$add_date. "' and ckk_item='0' and doc_no LIKE '%E%'";
$result03 = mysqli_query($conn, $sql03);
$Num_Rows013 = mysqli_num_rows($result03);	
$output = "";
while($objResult8 = mysqli_fetch_array($result03))
{
$output .=  "คำสั่งซื้อเลขที่ : " .$objResult8["order_id"]. "  "; 	
}	
	
if($Num_Rows013 > 0){
$bii = "$Num_Rows013 บิล";		
}else{
$bii = "ไม่มีบิล";	
}
$hab = $output;	
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

$sToken = "1B99f7Q2x3upAqGpl8ASgCufsAd4U32URULp8W8yNTJ";
$sMessage = "
Lazada  นำเข้าเรียบร้อยค่ะ
LEX : $Num_Rows021 
Kerry : $Num_Rows011
Flash express : $Num_Rows051
ก่อนนำเข้ายังไม่ระบุขนส่ง : $Num_Rows041
			
$bii
$hab
			 
";
$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt( $chOne, CURLOPT_POST, 1);
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
if(curl_error($chOne))
{
echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
//echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne );  		
	
	
	
$sql04 = "SELECT DISTINCT order_id FROM so__main WHERE sale_channel = '1' and register_date = '" . $add_date . "'  and ckk_item='0' and price_ckk='1'";
$result04 = mysqli_query($conn, $sql04);
$Num_Rows014 = mysqli_num_rows($result04);	
$output1 = "";
while($objResult10 = mysqli_fetch_array($result04))
{

$sql09 = "SELECT order_id FROM so__main WHERE order_id ='".$objResult10["order_id"]."'";
$result09 = mysqli_query($conn, $sql09);
$objResult9 = mysqli_fetch_array($result09);	
$output1 .=  "คำสั่งซื้อเลขที่ : " .$objResult9["order_id"]. "  "; 
	
}

$hab1 = $output1;
//echo $output;

if($Num_Rows014  > 0){
$bii1 = "$Num_Rows014  ออเดอร์";		
	
//Admin

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

$sToken = "1B99f7Q2x3upAqGpl8ASgCufsAd4U32URULp8W8yNTJ"; 
$sMessage = "
LAZADA รายการออเดอร์สินค้าราคาต่ำกว่ากำหนด
			
$bii1
$hab1
			 
";
$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt( $chOne, CURLOPT_POST, 1);
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
if(curl_error($chOne))
{
echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
//echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne );  	



//พี่เปิ้ล



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

$sToken = "gCe7s6XlzcHFCtuVNBF2D2g6xbZZS7PrmPz5vpQBc6G"; 
$sMessage = "

รบกวนตรวจสอบรายการออเดอร์สินค้าราคาต่ำกว่ากำหนด ร้านค้า LAZADA
			
$bii1
$hab1
	
สามารถดำเนินการอนุมัติออเดอร์ได้ที่ https://sol.allwellcenter.com/status_adminprice.php	
			 
";
$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt( $chOne, CURLOPT_POST, 1);
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
if(curl_error($chOne))
{
echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
//echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne );  		 


}
	
	
	
$strSQL5 = "SELECT *  FROM so__main  WHERE sale_channel = '".$running."' and register_date = '" .$add_date. "' and ckk_item='0' and doc_no LIKE '%E%'";
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
values ('".$doc_no."','".$delivery_date."','".$com."','".$billing_name."','".$amount_1."','36','".$add_by."','".$ref_id."','1','LAZADA','".$bill_id."','".$sale_channel."','สมบูรณ์','สมบูรณ์','1','".$order_id."')";
		
$objQuery29 = mysqli_query($code,$strSQL29);	
	
	 
 }
	 
}
 		

	
$sql2 = "SELECT ref_id FROM so__main WHERE sale_channel = '".$running."' and register_date = '" .$add_date. "' and ckk_item='0'";
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
values ('".$objResult12["ref_id"]."','".$count_free."','".$count_free."','0.00','0.00','0.00','0.00','5795','5795','','Approve','แถมพิเศษ หน้ากากอนมัยคละสี 1 ซอง')";
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
values ('".$objResult12["ref_id"]."','".$count_free."','".$count_free."','0.00','0.00','0.00','0.00','5795','5795','','Approve','แถมพิเศษ หน้ากากอนมัยคละสี 1 ซอง')";
$objQuery19 = mysqli_query($conn,$strSQL19);
	
	
} else {
    $count_free = 0; // ค่าเริ่มต้นในกรณีที่ไม่อยู่ในช่วงที่กำหนด
}


}
		
	
	
	
}
	
$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '".$running."' and register_date = '".$add_date."'";
$objQuery = mysqli_query($conn,$strSQL);	

echo "<script language=\"JavaScript\">";
echo "alert('ดึงข้อมูลรายการสินค้าจำนวน $Num_Rows21 ออเดอร์ครบเรียบร้อยแล้วค่ะ');window.location='search_apilazada.php';";
echo "</script>";

	
	
	

	?>
	</p></p>
	<input type="button" name ="Submit" value="กลับสู่หน้าหลัก" class = "button button4" onClick="this.form.action='search_apilazada.php'; submit()">
</center>

</form>