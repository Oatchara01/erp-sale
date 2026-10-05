<?php

session_start();

include "dbconnect.php";

$sale_code = $_SESSION['code'] ?? '';

$strProduct = isset($_POST["product_code"])
    ? trim($_POST["product_code"])
    : '';

$type_company = (
    isset($_POST['type_company']) &&
    $_POST['type_company'] === 'NBM'
)
    ? 'NBM'
    : 'AWL';

$strProduct_escaped = mysqli_real_escape_string(
    $conn,
    $strProduct
);

$typeCompanyEscaped = mysqli_real_escape_string(
    $conn,
    $type_company
);


$strSQL = "
    SELECT *
    FROM tb_product
    WHERE access_code = '$strProduct_escaped'
      AND type_company = '$typeCompanyEscaped'
      AND group1 NOT IN (8002, 8001)
    LIMIT 1
";


$objQuery = mysqli_query(
    $conn,
    $strSQL
) or die(
    "Error Query [" . $strSQL . "]"
);


$objResult = mysqli_fetch_array(
    $objQuery,
    MYSQLI_ASSOC
);


/* =========================================================
   JSON MODE : NOT FOUND
========================================================= */

if (
    isset($_POST['format']) &&
    $_POST['format'] === 'json' &&
    !$objResult
) {

    header(
        'Content-Type: application/json; charset=utf-8'
    );

    echo json_encode(
        [
            'found' => false
        ],
        JSON_UNESCAPED_UNICODE
    );

    exit;
}


/* =========================================================
   PRODUCT FOUND
========================================================= */

if ($objResult) {

    $war_hc = isset($objResult["war_hc"])
        ? $objResult["war_hc"]
        : '';

    $unit_hc = isset($objResult["unit_hc"])
        ? $objResult["unit_hc"]
        : '';

    $vvv = trim(
        $war_hc . ' ' . $unit_hc
    );


    /* =====================================================
       JSON MODE
    ===================================================== */

    if (
        isset($_POST['format']) &&
        $_POST['format'] === 'json'
    ) {

        header(
            'Content-Type: application/json; charset=utf-8'
        );


        echo json_encode(
            [
                'found' => true,

                'product_ID' =>
                    $objResult["product_ID"] ?? '',

                'sol_name' =>
                    $objResult["sol_name"] ?? '',

                'unit_name' =>
                    $objResult["unit_name"] ?? '',

                'sol_price' =>
                    $objResult["sol_price"] ?? '0',

                'discount' =>
                    '0',

                'remark_hc' =>
                    $objResult["remark_hc"] ?? '',

                'product_type' =>
                    $objResult["product_type"] ?? '',

                'war_hc' =>
                    $war_hc,

                'unit_hc' =>
                    $unit_hc,

                'vvv' =>
                    $vvv,


                /* =========================================
                   ใช้ตรวจแจ้งเตือนปีรับประกัน
                ========================================= */

                'sn_ckk' =>
                    isset($objResult["sn_ckk"])
                        ? (string)$objResult["sn_ckk"]
                        : '0',


                'store' =>
                    $objResult["store"] ?? '',

                'store_remark' =>
                    $objResult["store_remark"] ?? ''
            ],
            JSON_UNESCAPED_UNICODE
        );

        exit;
    }


    /* =====================================================
       LEGACY MODE
    ===================================================== */

    echo
        ($objResult["product_ID"] ?? '')
        . "|"
        . ($objResult["sol_name"] ?? '')
        . "|"
        . ($objResult["unit_name"] ?? '')
        . "|"
        . ($objResult["sol_price"] ?? '')
        . "|"
        . "0"
        . "|"
        . $vvv
        . "|"
        . ($objResult["product_type"] ?? '');
}

?>