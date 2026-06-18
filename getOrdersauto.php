<script type="text/javascript" src="//laz-g-cdn.alicdn.com/sj/securesdk/0.0.3/securesdk_lzd_v1.js" id="J_secure_sdk_v2" data-appkey="124441"></script>
<?php
include "databaseHelper.php";
include "LazadaAPI.php";
require_once 'LazopSdk.php';
include "dbconnect.php";
//include "head.php";


if($start_date!=''){
$running = $_GET["running"]; 
$start_date = $_GET["start_date"];
$start_time = $_GET["start_time"];
$end_date = $_GET["end_date"];
$end_time = $_GET["end_time"];
$status = $_GET["status"];
$t = "T";
$zone = "+07:00";
$create_time = "$start_date$t$start_time$zone";	
$createend_time = "$end_date$t$end_time$zone";	

}else{

$start_date = date('Y-m-d', strtotime('7 days'));
$start_time = "00:00:00";
$end_date = date('Y-m-d');
$end_time = date('H:i:s');
$t = "T";
$zone = "+07:00";

$create_time = "$start_date$t$start_time$zone";	
$createend_time = "$end_date$t$end_time$zone";	
$status = "pending";
$running = '1'; 	
	
}

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

if($obj->data->count==100){

   $params2 = [
   [
   "name"   => "offset",
   "value" => 100
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
$obj = getOrders(base64_decode($accessToken), $params2);
            if ($obj->code == "0" && $obj->data->count >= 1) {
                saveOrders($obj, $running);
    /* $x = 0;
   while($x < $obj->data->count) {
         echo "The order_number is: ".$obj->data->orders[$x]->order_number."<br>";
         $x+=1;
   }  */     
       
    
}else{
    echo "no data";
}
}         

  
if($obj->data->count==100){

   $params2 = [
   [
   "name"   => "offset",
   "value" => 200
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
$obj = getOrders(base64_decode($accessToken), $params2);
            if ($obj->code == "0" && $obj->data->count >= 1) {
                saveOrders($obj, $running);
            
       
    
}else{
    echo "no data";
}
}

if($obj->data->count==100){

   $params2 = [
   [
   "name"   => "offset",
   "value" => 300
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
$obj = getOrders(base64_decode($accessToken), $params2);
            if ($obj->code == "0" && $obj->data->count >= 1) {
                saveOrders($obj, $running);
          
      
    
}else{
    echo "no data";
}
}


if($obj->data->count==100){
   $params2 = [
   [
   "name"   => "offset",
   "value" => 400
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
$obj = getOrders(base64_decode($accessToken), $params2);
            if ($obj->code == "0" && $obj->data->count >= 1) {
                saveOrders($obj, $running);
          
     
    
}else{
    echo "no data";
} 
}

if($obj->data->count==100){
   $params2 = [
   [
   "name"   => "offset",
   "value" => 500
    ],
	[
    "name"   => "sort_by",
    "value" => "created_at"
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
$obj = getOrders(base64_decode($accessToken), $params2);
            if ($obj->code == "0" && $obj->data->count >= 1) {
                saveOrders($obj, $running);
          
     
    
}else{
    echo "no data";
} 
}

if($obj->data->count==100){

   $params2 = [
   [
   "name"   => "offset",
   "value" => 600
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
$obj = getOrders(base64_decode($accessToken), $params2);
            if ($obj->code == "0" && $obj->data->count >= 1) {
                saveOrders($obj, $running);
          
       
    
}else{
    echo "no data";
}
}


if($obj->data->count==100){
   $params2 = [
   [
   "name"   => "offset",
   "value" => 700
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
$obj = getOrders(base64_decode($accessToken), $params2);
            if ($obj->code == "0" && $obj->data->count >= 1) {
                saveOrders($obj, $running);
          
      
    
}else{
    echo "no data";
}
}



if($obj->data->count==100){
   $params2 = [
   [
   "name"   => "offset",
   "value" => 800
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
$obj = getOrders(base64_decode($accessToken), $params2);
            if ($obj->code == "0" && $obj->data->count >= 1) {
                saveOrders($obj, $running);
          
       
    
}else{
    echo "no data";
}
}

if($obj->data->count==100){

   $params2 = [
   [
   "name"   => "offset",
   "value" => 900
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
$obj = getOrders(base64_decode($accessToken), $params2);
            if ($obj->code == "0" && $obj->data->count >= 1) {
                saveOrders($obj, $running);    
}else{
    echo "no data";
}
}
     
 

if($obj->data->count==100){

   $params2 = [
   [
   "name"   => "offset",
   "value" => 1000
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
$obj = getOrders(base64_decode($accessToken), $params2);
            if ($obj->code == "0" && $obj->data->count >= 1) {
                saveOrders($obj, $running);
             
}else{
    echo "no data";
}
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
$running = '1'
	
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
	
$strSQL = "Update  so__uppack set ckk_closd='1' Where sale_channel= '".$running."'";
$objQuery = mysqli_query($conn,$strSQL);	
	
	
$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '".$running."' and register_date = '".$add_date."'";
$objQuery = mysqli_query($conn,$strSQL);	

echo "<script>";
echo "window.location='main_admin.php';";
echo "</script>";
	
	
	

	?>



