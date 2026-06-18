<?php

include_once('global.php');
include_once('signature.php');
include_once('postrequest.php');

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    // กำหนดค่าให้ตัวแปรที่จำเป็น
    $code = '6e63557971614277725544586a554974';
    $partner_id = '2007594';
    $shop_id = '24017696';
    $partner_key = '55545565657347696252734e79556564616842614971476c6b784d6f74494342';
    $host = 'https://partner.shopeemobile.com';
    $timestamp = time();
	$redirectUrl = "https://sol.allwellcenter.com/";

    $path = '/api/v2/auth/token/get';

    // สร้าง Sign สำหรับการเรียก API
    $signGenerator = new SignGenerator();
    $sign = $signGenerator->generateSignAuth($partner_key, $partner_id, $path, $timestamp);

    // กำหนดค่า URL Endpoint
    $endpoint = sprintf("%s%s?partner_id=%s&timestamp=%d&sign=%s&redirect=%s", $host, $path, $partner_id, $timestamp, $sign, $redirectUrl);
	echo $endpoint;

    // ข้อมูลที่จะส่งในรูปแบบ JSON
    $data = json_encode([
        "code" => $code,
        "partner_id" => (int)$partner_id,
        "shop_id" => (int)$shop_id
    ]);

    $postRequest = new PostRequest();
    $contentType = "application/json";

    // ส่งคำขอไปยัง API
    $response = $postRequest->Post($endpoint, $data, $contentType, 'POST');

    // แสดงผลลัพธ์ที่ได้จาก API
    echo $response;

} catch (Exception $e) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => $e->getMessage()]);
}


