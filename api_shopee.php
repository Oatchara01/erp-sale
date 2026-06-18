<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('UTC');

$partner_id   = 2007594;
$partner_key  = 'shpk6d4e6b6c4d744162716f4147625073594c645a4377685550774e67457266';
$redirect_url = 'https://sol.allwellcenter.com/shopeeShopVerify.php';

$host = 'https://partner.shopeemobile.com';
$path = '/api/v2/shop/auth_partner';
$timestamp = time();

$base_string = $partner_id . $path . $timestamp;
$sign = hash_hmac('sha256', $base_string, $partner_key);

$auth_url = $host . $path
    . '?partner_id=' . $partner_id
    . '&timestamp=' . $timestamp
    . '&sign=' . $sign
    . '&redirect=' . urlencode($redirect_url);

header('Location: ' . $auth_url);
exit;
?>