<script type="text/javascript" src="//laz-g-cdn.alicdn.com/sj/securesdk/0.0.3/securesdk_lzd_v1.js" id="J_secure_sdk_v2" data-appkey="124441"></script>
<?php
include "LazopSdk.php";

$appKey = '124441';
$appSecret = '4C6pyxTSw42nWe9NdsofLjjOLntDQbWb';
$authorClient = 'https://auth.lazada.com/rest';
$url = 'https://api.lazada.co.th/rest';
$datamoatUrl = 'https://api.lazada.com/rest';

function getAccessToken($code)
{
    global $appKey, $appSecret, $authorClient;

    $c = new LazopClient($authorClient, $appKey, $appSecret);
    $request = new LazopRequest('/auth/token/create');
    $request->addApiParam('code', $code);

    $json = $c->execute($request);
    $obj = json_decode($json);

    return $obj;
	

	
}

function getRefreshToken($refresh_token)
{
    global $appKey, $appSecret, $authorClient;

    $c = new LazopClient($authorClient, $appKey, $appSecret);
    $request = new LazopRequest('/auth/token/refresh');
    $request->addApiParam('refresh_token', $refresh_token);

    $json = $c->execute($request);
    $obj = json_decode($json);

    return $obj;
}


// $accessToken mush base64_decode($str) before send to this function
function getOrders($accessToken, $params)
{
    global $appKey, $appSecret, $url;
    $c = new LazopClient($url, $appKey, $appSecret);
    $request = new LazopRequest('/orders/get', 'GET');

    foreach ($params as $key => $value) {
        //echo $value["name"]." ".$value["value"]."<br>";
        $request->addApiParam($value["name"], $value["value"]);
    }

    //var_dump($c->execute($request, $accessToken));

    $json = $c->execute($request, $accessToken);
    $obj = json_decode($json);

    return $obj;
}

// $accessToken mush base64_decode($str) before send to this function
function getOrderItems($accessToken, $params)
{
    global $appKey, $appSecret, $url;
    $c = new LazopClient($url, $appKey, $appSecret);
    $request = new LazopRequest('/order/items/get', 'GET');
	
    foreach ($params as $key => $value) {
        //echo $value["name"]." ".$value["value"]."<br>";
        $request->addApiParam($value["name"], $value["value"]);
    }

    //var_dump($c->execute($request, $accessToken));

    $json = $c->execute($request, $accessToken);
    $obj = json_decode($json);

    return $obj;
}

function getShipmentProviders($accessToken){
    global $appKey, $appSecret, $url;
    $c = new LazopClient($url, $appKey, $appSecret);
    $request = new LazopRequest('/shipment/providers/get','GET');

    $json = $c->execute($request, $accessToken);
    $obj = json_decode($json);

    return $obj;
}

function setStatusToPackedByMarketplace($accessToken, $params){
    global $appKey, $appSecret, $url;
    $c = new LazopClient($url, $appKey, $appSecret);
    $request = new LazopRequest('/order/fulfill/pack');

    foreach ($params as $key => $value) {
        $request->addApiParam($value["name"], $value["value"]);
    }

    $json = $c->execute($request, $accessToken);
    $obj = json_decode($json);

    return $obj;
}


function setprintlabel($accessToken, $params){
    global $appKey, $appSecret, $url;
    $c = new LazopClient($url, $appKey, $appSecret);
    $request = new LazopRequest('/order/package/document/get');

    foreach ($params as $value) {
        $request->addApiParam($value["name"], $value["value"]);
    }

    $json = $c->execute($request, $accessToken);
    return json_decode($json);
}


function setStatusToReadyToShip($accessToken, $readyToShipJson){
    global $appKey, $appSecret, $url;
    $c = new LazopClient($url, $appKey, $appSecret);
    $request = new LazopRequest('/order/package/rts', 'POST');

    // ส่งพารามิเตอร์ที่ถูกต้อง
    $request->addApiParam('readyToShipReq', $readyToShipJson);

    $json = $c->execute($request, $accessToken);
    return json_decode($json);
}

function datamoatLogin($params)
{
    global $appKey, $appSecret, $datamoatUrl;
    $c = new LazopClient($datamoatUrl, $appKey, $appSecret);
	//$c = new LazopClient('https://api.lazada.com/rest', '124441', '4C6pyxTSw42nWe9NdsofLjjOLntDQbWb');
    $request = new LazopRequest('/datamoat/login');

    foreach ($params as $key => $value) {
        $request->addApiParam($value["name"], $value["value"]);
    }

    $json = $c->execute($request);
    $obj = json_decode($json);

    return $obj;
}

function datamoatComputeRisk($params)
{
    global $appKey, $appSecret, $datamoatUrl;
   $c = new LazopClient($datamoatUrl, $appKey, $appSecret);
	//$c = new LazopClient('https://api.lazada.com/rest', '124441', '4C6pyxTSw42nWe9NdsofLjjOLntDQbWb');
    $request = new LazopRequest('/datamoat/compute_risk');

    foreach ($params as $key => $value) {
        $request->addApiParam($value["name"], $value["value"]);
    }

    $json = $c->execute($request);
    $obj = json_decode($json);

    return $obj;
}















