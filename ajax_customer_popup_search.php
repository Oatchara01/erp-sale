<?php

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "dbconnect.php";


/* =========================================================
   JSON RESPONSE
========================================================= */

function responseJson($payload, $statusCode = 200)
{
    http_response_code($statusCode);

    echo json_encode(
        $payload,
        JSON_UNESCAPED_UNICODE
    );

    exit;
}


/* =========================================================
   USER SESSION
========================================================= */

$userSaleCode = isset($_SESSION['code'])
    ? trim($_SESSION['code'])
    : '';

$typeLogin = isset($_SESSION['type_login'])
    ? trim($_SESSION['type_login'])
    : '';

$typeLoginLower = strtolower($typeLogin);


/* =========================================================
   REQUEST
========================================================= */

$keyword = isset($_GET['q'])
    ? trim($_GET['q'])
    : '';

$keywordLike = '%' . $keyword . '%';

$lastId = isset($_GET['last_id'])
    ? (int)$_GET['last_id']
    : 0;

$limit = isset($_GET['limit'])
    ? (int)$_GET['limit']
    : 20;


if ($limit <= 0) {
    $limit = 20;
}

if ($limit > 50) {
    $limit = 50;
}


/* =========================================================
   PERMISSION
========================================================= */

/*
|--------------------------------------------------------------------------
| หลักการ
|--------------------------------------------------------------------------
|
| Admin / IT / Owner
|   -> เห็นลูกค้าทั้งหมด
|
| Sale
|   -> เห็นลูกค้าที่ tb_selected_sales.sale_code
|      ตรงกับ $_SESSION['code'] ของตัวเอง
|
| Engineer / SUP_EN
|   -> เห็นลูกค้าที่ sale_code เป็นกลุ่ม EN
|
| SOL
|   -> เห็นลูกค้าที่อยู่ในกลุ่ม SOL
|
| User / Supervisor อื่น
|   -> อ่าน sale_code ที่มีสิทธิ์จาก user_sale_permission
|
*/

$canSeeAllCustomers = in_array(
    $typeLoginLower,
    array('admin', 'it', 'owner','engineer','mk1','mk2','sup_mk1','sup_mk2'),
    true
);

$allowedSaleCodes = array();


/* =========================================================
   SALE
========================================================= */

if (!$canSeeAllCustomers && $typeLoginLower === 'sale') {

    if ($userSaleCode !== '') {
        $allowedSaleCodes[] = $userSaleCode;
    }



/* =========================================================
   SOL
========================================================= */

} elseif (
    !$canSeeAllCustomers &&
    $typeLoginLower === 'sol'
) {

    /*
     * ใช้ชุดเดียวกับหน้า register_suphos.php
     */

    $allowedSaleCodes = array(
        'SOL1',
        'SOL2',
        'SOL3',
        'SOL4',
        'SOL5',
        'SOL6',
        'SOL7',
        'SOL8',
        'SOL9',
        'SOL0',
        'SM1'
    );


/* =========================================================
   SUPERVISOR / USER อื่น ๆ
========================================================= */

} elseif (!$canSeeAllCustomers) {

    if ($userSaleCode !== '') {

        $sqlPermission = "
            SELECT DISTINCT sale_code
            FROM user_sale_permission
            WHERE em_id = ?
        ";

        $stmtPermission = mysqli_prepare(
            $conn,
            $sqlPermission
        );

        if ($stmtPermission) {

            mysqli_stmt_bind_param(
                $stmtPermission,
                's',
                $userSaleCode
            );

            mysqli_stmt_execute(
                $stmtPermission
            );

            $resultPermission =
                mysqli_stmt_get_result(
                    $stmtPermission
                );

            while (
                $permissionRow =
                mysqli_fetch_assoc(
                    $resultPermission
                )
            ) {

                $code = trim(
                    (string)$permissionRow['sale_code']
                );

                if ($code !== '') {
                    $allowedSaleCodes[] = $code;
                }
            }

            mysqli_stmt_close(
                $stmtPermission
            );
        }
    }
}


/*
 * ป้องกัน code ซ้ำ
 */

$allowedSaleCodes = array_values(
    array_unique(
        array_filter(
            $allowedSaleCodes
        )
    )
);


/* =========================================================
   ถ้าไม่มีสิทธิ์เลย
========================================================= */

if (
    !$canSeeAllCustomers &&
    count($allowedSaleCodes) === 0
) {

    responseJson(array(
        'success' => true,
        'customers' => array(),
        'pagination' => array(
            'limit' => $limit,
            'has_more' => false,
            'next_last_id' => null,
            'returned' => 0
        )
    ));
}


/* =========================================================
   CUSTOMER QUERY
========================================================= */

$sql = "
    SELECT
        c.customer_id,
        c.first_name,
        c.last_name,
        c.customer_name,
        c.bill_name,
        c.cus_tel,
        c.bill_tel,
        c.cus_address,
        c.cus_ampher,
        c.cus_province,
        c.cus_postcode,
        c.customer_no,
        c.type_customer,
        c.credit_thb,
        c.credit_ckk,
        c.status_cus,
        c.vip_ckk,
        t.type_name

    FROM tb_customer c

    LEFT JOIN tb_typecustomer t
        ON c.type_customer = t.type_id

    WHERE 1
";


$types = '';

$params = array();


/* =========================================================
   FILTER CUSTOMER BY SALE PERMISSION
========================================================= */

if (!$canSeeAllCustomers) {

    /*
     * ใช้ EXISTS แทน JOIN
     *
     * เพราะลูกค้า 1 คนอาจอยู่ได้หลาย sale_code
     * ถ้า JOIN ตรง ๆ อาจทำให้ customer ซ้ำหลายแถว
     */

    $salePlaceholders = implode(
        ',',
        array_fill(
            0,
            count($allowedSaleCodes),
            '?'
        )
    );

    $sql .= "
        AND EXISTS (
            SELECT 1
            FROM tb_selected_sales ss
            WHERE ss.id_customer = c.customer_id
              AND ss.sale_code IN ($salePlaceholders)
        )
    ";

    foreach ($allowedSaleCodes as $saleCode) {

        $types .= 's';

        $params[] = $saleCode;
    }
}


/* =========================================================
   PAGINATION
========================================================= */

if ($lastId > 0) {

    $sql .= "
        AND c.customer_id < ?
    ";

    $types .= 'i';

    $params[] = $lastId;
}


/* =========================================================
   SEARCH
========================================================= */

if ($keyword !== '') {

    $sql .= "
        AND (
            c.customer_name LIKE ?
            OR c.bill_name LIKE ?
            OR c.first_name LIKE ?
            OR c.last_name LIKE ?
            OR c.cus_tel LIKE ?
            OR c.bill_tel LIKE ?
            OR c.customer_no LIKE ?
        )
    ";

    $types .= 'sssssss';

    $params[] = $keywordLike;
    $params[] = $keywordLike;
    $params[] = $keywordLike;
    $params[] = $keywordLike;
    $params[] = $keywordLike;
    $params[] = $keywordLike;
    $params[] = $keywordLike;
}


/* =========================================================
   ORDER + LIMIT
========================================================= */

$sql .= "
    ORDER BY c.customer_id DESC
    LIMIT ?
";

$types .= 'i';

$params[] = $limit + 1;


/* =========================================================
   PREPARE
========================================================= */

$stmt = mysqli_prepare(
    $conn,
    $sql
);

if (!$stmt) {

    responseJson(
        array(
            'success' => false,
            'message' => 'Cannot prepare customer query'
        ),
        500
    );
}


/* =========================================================
   BIND PARAM
========================================================= */

mysqli_stmt_bind_param(
    $stmt,
    $types,
    ...$params
);


/* =========================================================
   EXECUTE
========================================================= */

if (!mysqli_stmt_execute($stmt)) {

    responseJson(
        array(
            'success' => false,
            'message' => 'Cannot execute customer query'
        ),
        500
    );
}


$result = mysqli_stmt_get_result(
    $stmt
);


/* =========================================================
   RESULT
========================================================= */

$rows = array();

while (
    $row = mysqli_fetch_assoc(
        $result
    )
) {

    $rows[] = $row;
}


mysqli_stmt_close(
    $stmt
);


/* =========================================================
   PAGINATION CHECK
========================================================= */

$hasMore = count($rows) > $limit;

if ($hasMore) {
    array_pop($rows);
}


/* =========================================================
   FORMAT CUSTOMER
========================================================= */

$customers = array();

$nextLastId = null;


foreach ($rows as $row) {

    /* -------------------------
       Customer Name
    ------------------------- */

    $nameParts = trim(
        $row['first_name']
        . ' '
        . $row['last_name']
    );


    $displayName = $nameParts !== ''
        ? $nameParts
        : $row['customer_name'];


    if (
        $displayName === '' ||
        $displayName === null
    ) {

        $displayName =
            $row['bill_name'];
    }


    /* -------------------------
       Telephone
    ------------------------- */

    $displayTel =
        $row['cus_tel'];


    if (
        $displayTel === '' ||
        $displayTel === null
    ) {

        $displayTel =
            $row['bill_tel'];
    }


    /* -------------------------
       Customer ID
    ------------------------- */

    $customerId =
        (int)$row['customer_id'];


    $nextLastId =
        $customerId;


    /* -------------------------
       Response
    ------------------------- */

    $customers[] = array(

        'customer_id' =>
            $customerId,

        'customer_name' =>
            $displayName,

        'bill_name' =>
            $row['bill_name'],

        'cus_tel' =>
            $displayTel,

        'cus_address' =>
            $row['cus_address'],

        'cus_ampher' =>
            $row['cus_ampher'],

        'cus_province' =>
            $row['cus_province'],

        'cus_postcode' =>
            $row['cus_postcode'],

        'customer_no' =>
            $row['customer_no'],

        'type_customer' =>
            $row['type_customer'],

        'type_name' =>
            $row['type_name'],

        'credit_thb' =>
            $row['credit_thb'],

        'credit_ckk' =>
            $row['credit_ckk'],

        'status_cus' =>
            $row['status_cus'],

        'vip_ckk' =>
            $row['vip_ckk']
    );
}


/* =========================================================
   RESPONSE
========================================================= */

responseJson(array(

    'success' => true,

    'customers' => $customers,

    'pagination' => array(

        'limit' =>
            $limit,

        'has_more' =>
            $hasMore,

        'next_last_id' =>
            $hasMore
                ? $nextLastId
                : null,

        'returned' =>
            count($customers)
    )
));

?>