<?php
include_once('shopeeAPI.php');
include_once('databaseshopee.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$code    = $_GET["code"] ?? null;
$shop_id = $_GET["shop_id"] ?? null;

if (!$code || !$shop_id) {
    echo json_encode([
        "error" => "Missing code or shop_id"
    ]);
    exit;
}

$obj = getAccessToken($code);

if ($obj && saveShopToken($obj)) {
    echo "New record created successfully<br><br>";
} else {
    echo "Save error<br><br>";
}

echo "<pre>";
var_dump($obj);
echo "</pre>";
exit;
?>