<?php
session_start();

include "dbconnect.php";
$sale_code = $_SESSION['code'];
//echo $sale_code;
$strProduct = trim($_POST["product_code"]);
$type_company = (isset($_POST['type_company']) && $_POST['type_company'] === 'NBM') ? 'NBM' : 'AWL';
$strProduct_escaped = mysqli_real_escape_string($conn, $strProduct);

$strSQL = "SELECT * FROM tb_product WHERE access_code = '$strProduct_escaped' AND type_company = '$type_company'";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
$objResult = mysqli_fetch_array($objQuery);

if (isset($_POST['format']) && $_POST['format'] === 'json' && !$objResult) {
    // ไม่พบสินค้า: ตอบ found=false ชัดเจน กันฝั่ง JS เข้าใจผิดว่าเจอสินค้าแบบเงียบๆ (เดิม response ว่างเปล่า)
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['found' => false]);
    exit;
}

if ($objResult) {



    $war_hc = $objResult["war_hc"];
    $unit_hc = $objResult["unit_hc"];
    $vvv = "$war_hc $unit_hc";

    if (isset($_POST['format']) && $_POST['format'] === 'json') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'found'        => true,
            'product_ID'   => $objResult["product_ID"],
            'sol_name'     => $objResult["sol_name"],
            'unit_name'    => $objResult["unit_name"],
            'sol_price'    => $objResult["sol_price"],
            'discount'     => '0',
            'remark_hc'    => $objResult["remark_hc"],
            'product_type' => $objResult["product_type"],
            'war_hc'       => $war_hc,
            'unit_hc'      => $unit_hc,
            'vvv'          => $vvv,
            'store'        => $objResult["store"],
            'store_remark' => $objResult["store_remark"]
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo $objResult["product_ID"] . "|" . $objResult["sol_name"] . "|" . $objResult["unit_name"] . "|" . $objResult["sol_price"] . "|" . '0' . "|" . $vvv . "|" . $objResult["product_type"];
}
