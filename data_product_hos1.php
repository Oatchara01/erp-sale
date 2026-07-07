<?php
session_start();

include "dbconnect.php";
$sale_code = $_SESSION['code'];
//echo $sale_code;
$strProduct = trim($_POST["product_code"]);

$strSQL = "SELECT * FROM tb_product WHERE access_code = '" . $strProduct . "' ";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
$objResult = mysqli_fetch_array($objQuery);
if ($objResult) {



    $war_hc = $objResult["war_hc"];
    $unit_hc = $objResult["unit_hc"];
    $vvv = "$war_hc $unit_hc";

    if (isset($_POST['format']) && $_POST['format'] === 'json') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'product_ID'   => $objResult["product_ID"],
            'sol_name'     => $objResult["sol_name"],
            'unit_name'    => $objResult["unit_name"],
            'sol_price'    => $objResult["sol_price"],
            'discount'     => '0',
            'remark_hc'    => $objResult["remark_hc"],
            'product_type' => $objResult["product_type"],
            'war_hc'       => $war_hc,
            'unit_hc'      => $unit_hc,
            'vvv'          => $vvv
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo $objResult["product_ID"] . "|" . $objResult["sol_name"] . "|" . $objResult["unit_name"] . "|" . $objResult["sol_price"] . "|" . '0' . "|" . $vvv . "|" . $objResult["product_type"];
}
