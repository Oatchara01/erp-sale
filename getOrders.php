<script type="text/javascript" src="//laz-g-cdn.alicdn.com/sj/securesdk/0.0.3/securesdk_lzd_v1.js" id="J_secure_sdk_v2" data-appkey="124441"></script>
<?php
include "databaseHelper.php";
include "LazadaAPI.php";
include "head.php";

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
        /* $x = 0;
   while($x < $obj->data->count) {
         echo "The order_number is: ".$obj->data->orders[$x]->order_number."<br>";
	      echo "Tracking Code: ".$obj->data->orders[$x]->tracking_number."<br>";
	        $x+=1;
	   exit();
   }   */
}else{
    echo "no data";
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

?>
<form name="frmSearch" method="GET" action="getOrderItems.php">
<input name="running" type="hidden" id="running" class="w3-input w3-light-gray" value="<?php echo $_GET["running"];?>">
	</p></p></p>
	<center>
	  <input type="submit" value="ดึงรายการสินค้า" class="w3-button w3-teal">
</center>
	
	</form>




