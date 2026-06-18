<?php


header("Content-type:text/html; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

include "dbconnect.php";
include "dbconnect_sale.php";
// include "head9.php";

session_start();
$em_id      = isset($_SESSION['code']) ? $_SESSION['code'] : '';
$type_login = isset($_SESSION['type_login']) ? $_SESSION['type_login'] : '';
$user_type  = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '';

// รับค่าค้นหา และ escape ป้องกัน SQL injection เล็กน้อย
$product_code_search_raw = isset($_GET["bill_search"]) ? $_GET["bill_search"] : '';
$product_code_search     = urldecode($product_code_search_raw);
$product_code_search_sql = mysqli_real_escape_string($conn, $product_code_search);

$pagesize   = 50;

// ตัวช่วยแสดงผลรายการ (ทำตัวหนาคำค้น + สร้าง <li>)
function echo_list_item($customer_id, $name_to_show, $keyword_for_bold) {
    $safe_keyword = preg_quote($keyword_for_bold, '/');
    $display_name = preg_replace("/(" . $safe_keyword . ")/iu", "<b>$1</b>", $name_to_show);
    // onselect เดิมของคุณ
    echo "<li onselect=\"this.setText('{$customer_id}').setValue('{$customer_id}');\">{$display_name}</li>";
}

if ($user_type === 'Sale') {

    // หา customer_id ของ sale คนนี้จาก tb_selected_sales
    $strSQL71   = "SELECT * FROM tb_selected_sales WHERE sale_code = '" . mysqli_real_escape_string($conn, $em_id) . "'";
    $objQuery71 = mysqli_query($conn, $strSQL71) or die(mysqli_error($conn));

    while ($objResult71 = mysqli_fetch_array($objQuery71)) {
        $customer_id = $objResult71["id_customer"];

        $table_db  = "tb_customer";
        $find_field = "customer_name"; // ฟิลด์ชื่อ

        $sql = "SELECT * 
                FROM $table_db
                WHERE close_ckk = '0'
                  AND customer_id = '" . mysqli_real_escape_string($conn, $customer_id) . "'
                  AND customer_id != '799'
                  AND LOCATE('$product_code_search_sql', $find_field) > 0
                ORDER BY $find_field ASC
                LIMIT $pagesize";

        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($result)) {
            $customer_name = $row["customer_name"];
            $customer_id   = $row["customer_id"];
            echo_list_item($customer_id, $customer_name, $product_code_search);
        }
    }

} else if ($type_login === 'Sup_Sale') {

    // ดึง zone ของ Sup_Sale
    $strSQL77   = "SELECT * FROM tb_user_zone WHERE em_id = '" . mysqli_real_escape_string($com, $em_id) . "'";
    $objQuery77 = mysqli_query($com, $strSQL77) or die(mysqli_error($com));

    while ($objResult77 = mysqli_fetch_array($objQuery77)) {
        $zone_code = $objResult77["code_zone"];

        // หา customer ที่ถูก assign ให้ zone นี้
        $strSQL71   = "SELECT * FROM tb_selected_sales WHERE sale_code = '" . mysqli_real_escape_string($conn, $zone_code) . "'";
        $objQuery71 = mysqli_query($conn, $strSQL71) or die(mysqli_error($conn));

        while ($objResult71 = mysqli_fetch_array($objQuery71)) {
            $customer_id = $objResult71["id_customer"];
            $table_db    = "tb_customer";
            $find_field  = "customer_name";

            $sql = "SELECT *
                    FROM $table_db
                    WHERE close_ckk = '0'
                      AND customer_id = '" . mysqli_real_escape_string($conn, $customer_id) . "'
                      AND LOCATE('$product_code_search_sql', $find_field) > 0
                    ORDER BY $find_field ASC
                    LIMIT $pagesize";

            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            while ($row = mysqli_fetch_array($result)) {
                $customer_name = $row["customer_name"];
                $customer_id   = $row["customer_id"];
                echo_list_item($customer_id, $customer_name, $product_code_search);
            }
        }
    }

} else if ($type_login === 'AllWell' && $em_id !== 'MK') {

    // join เพื่อคัดลูกค้าที่อยู่ในกลุ่ม sale_code มี 'SOL'
    $find_field = "c.customer_name"; // alias ชัดเจน
    $sql = "SELECT c.customer_name, c.bill_name, c.customer_id
            FROM tb_customer c
            LEFT JOIN tb_selected_sales s ON c.customer_id = s.id_customer
            WHERE c.close_ckk = '0'
              AND s.sale_code LIKE '%SOL%'
              AND LOCATE('$product_code_search_sql', $find_field) > 0
            ORDER BY c.customer_name ASC
            LIMIT $pagesize";

    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    while ($row = mysqli_fetch_array($result)) {
        $customer_name = $row["customer_name"];
        $customer_id   = $row["customer_id"];
        echo_list_item($customer_id, $customer_name, $product_code_search);
    }

} else {

    // default: ทุกคน (ยกเว้น customer_id = 799), ยังกรองเฉพาะที่ match คำค้น และเรียงตามชื่อ
    $table_db   = "tb_customer";
    $find_field = "customer_name";

    $sql = "SELECT *
            FROM $table_db
            WHERE close_ckk = '0'
              AND customer_id != '799'
              AND LOCATE('$product_code_search_sql', $find_field) > 0
            ORDER BY $find_field ASC
            LIMIT $pagesize";

    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    while ($row = mysqli_fetch_array($result)) {
        $customer_name = $row["customer_name"];
        $customer_id   = $row["customer_id"];
        echo_list_item($customer_id, $customer_name, $product_code_search);
    }
}

?>





