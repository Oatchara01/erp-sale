
<style>
/* =========================================================
   FORCE LARGE FONT - DELIVERY MODAL
========================================================= */

.delivery-detail-modal {
    font-size: 14px !important;
}

.delivery-detail-title {
    font-size: 24px !important;
    font-weight: 600 !important;
}

.delivery-info-label {
    font-size: 14px !important;
    font-weight: 500 !important;
}

.delivery-info-value {
    font-size: 14px !important;
    font-weight: 400 !important;
    line-height: 1.8 !important;
}


/* ตาราง */

.delivery-process-table th {
    font-size: 14px !important;
    font-weight: 600 !important;
    padding: 14px 25px !important;
}

.delivery-process-table td {
    font-size: 14px !important;
    font-weight: 400 !important;
    padding: 14px 25px !important;
    line-height: 1.6 !important;
}


/* Badge สถานะ */

.delivery-status {
    font-size: 14px !important;
    font-weight: 500 !important;

    min-width: 110px !important;

    padding: 7px 18px !important;
}


/* Link ประเมิน */

.delivery-research-link {
    font-size: 14px !important;
}


/* ผลการส่งสินค้า / หมายเหตุ */

.delivery-summary-title {
    font-size: 14px !important;
    font-weight: 500 !important;
}

.delivery-summary-value {
    font-size: 14px !important;
    font-weight: 400 !important;
    line-height: 1.8 !important;
}


/* ปุ่ม X */

.delivery-detail-close {
    font-size: 32px !important;

    width: 42px !important;
    height: 42px !important;
}


/* เพิ่ม spacing ให้อ่านง่ายขึ้น */

.delivery-info {
    padding: 18px 40px 28px !important;
}

.delivery-info-grid {
    row-gap: 24px !important;
}

.delivery-summary {
    padding: 22px 40px 30px !important;
}


/* มือถือ */

@media (max-width: 768px) {

    .delivery-detail-title {
        font-size: 15px !important;
    }

    .delivery-info-label {
        font-size: 14px !important;
    }

    .delivery-info-value {
        font-size: 14px !important;
    }

    .delivery-process-table th,
    .delivery-process-table td {
        font-size: 14px !important;
    }

    .delivery-status {
        font-size: 13px !important;
    }

    .delivery-summary-title {
        font-size: 14px !important;
    }

    .delivery-summary-value {
        font-size: 14px !important;
    }
}
</style>	

<?php

/* =========================================================
   AJAX : DELIVERY DETAIL
   ajax_delivery_cs.php?ref_id=xxxx
========================================================= */

session_start();

include "dbconnect.php";
include "dbconnect_sale.php";

/*
 * หน้า delivery_cs เดิมมีการใช้ dbconnect_sol.php
 * ถ้าระบบของคุณมีไฟล์นี้ ให้เปิด include ด้านล่าง
 * เพื่อรองรับ st__main / st__signature ที่อาจอยู่คนละ DB
 */
if (file_exists("dbconnect_sol.php")) {
    include_once "dbconnect_sol.php";
}


/* =========================================================
   RESPONSE
========================================================= */

header('Content-Type: text/html; charset=UTF-8');


/* =========================================================
   FUNCTIONS
========================================================= */

function h($value)
{
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}


function valueOrDash($value)
{
    $value = trim((string)$value);

    return $value !== ''
        ? h($value)
        : '-';
}


/*
 * วันที่แบบ
 *
 * 24/09/68
 * 10:08:45
 */
function formatThaiDateTime($date)
{
    if (
        empty($date) ||
        $date === '0000-00-00' ||
        $date === '0000-00-00 00:00:00'
    ) {
        return '-';
    }


    $timestamp = strtotime($date);

    if (!$timestamp) {
        return h($date);
    }


    $day   = date('d', $timestamp);
    $month = date('m', $timestamp);

    $thaiYear = (int)date('Y', $timestamp) + 543;

    $thaiYearShort = substr(
        (string)$thaiYear,
        -2
    );


    $output =
        $day . '/' .
        $month . '/' .
        $thaiYearShort;


    /*
     * แสดงเวลาเฉพาะกรณีมีเวลา
     */
    if (
        strpos($date, ':') !== false &&
        date('H:i:s', $timestamp) !== '00:00:00'
    ) {

        $output .=
            '<br>' .
            date('H:i:s', $timestamp);
    }


    return $output;
}


/*
 * รวม date + time
 */
function combineDateTime($date, $time = '')
{
    $date = trim((string)$date);
    $time = trim((string)$time);


    if ($date === '') {
        return '';
    }


    /*
     * date มีเวลาอยู่แล้ว
     */
    if (strpos($date, ':') !== false) {
        return $date;
    }


    if ($time !== '') {
        return $date . ' ' . $time;
    }


    return $date;
}


/*
 * Query 1 row
 */
function fetchOne($connection, $sql)
{
    if (!$connection) {
        return array();
    }


    $query = mysqli_query(
        $connection,
        $sql
    );


    if (!$query) {
        return array();
    }


    $row = mysqli_fetch_assoc($query);


    return $row
        ? $row
        : array();
}


/*
 * เช็ก field แบบไม่ Error
 */
function fieldValue($row, $field)
{
    return isset($row[$field])
        ? trim((string)$row[$field])
        : '';
}


/* =========================================================
   REF ID
========================================================= */

$ref_id = isset($_GET['ref_id'])
    ? trim($_GET['ref_id'])
    : '';


if ($ref_id === '') {

    ?>

    <div class="delivery-error-box">
        ไม่พบเลขที่อ้างอิงเอกสาร
    </div>

    <?php

    exit;
}


/* =========================================================
   DATABASE CONNECTION
========================================================= */

/*
 * หน้า Status SO ปัจจุบันใช้ $conn query hos__so
 * ดังนั้นใช้ $conn เป็น DB หลัก
 */

$mainDb = isset($conn)
    ? $conn
    : null;


/*
 * DB ฝั่ง stock
 *
 * หน้าเก่ามีการใช้ทั้ง $sol / $new
 * จึงเลือกตามลำดับนี้
 */
$stockDb = null;


if (isset($new) && $new) {

    $stockDb = $new;

} elseif (isset($sol) && $sol) {

    $stockDb = $sol;

} else {

    $stockDb = $mainDb;
}


if (!$mainDb) {

    ?>

    <div class="delivery-error-box">
        ไม่สามารถเชื่อมต่อฐานข้อมูลได้
    </div>

    <?php

    exit;
}


/* =========================================================
   ESCAPE
========================================================= */

$ref_id_safe = mysqli_real_escape_string(
    $mainDb,
    $ref_id
);


/* =========================================================
   HOS__SO
========================================================= */

$sqlSO = "
    SELECT *
    FROM hos__so
    WHERE ref_id = '" . $ref_id_safe . "'
    LIMIT 1
";


$so = fetchOne(
    $mainDb,
    $sqlSO
);


if (empty($so)) {

    ?>

    <div class="delivery-error-box">

        <div style="
            font-size:16px;
            font-weight:500;
            margin-bottom:6px;
        ">
            ไม่พบข้อมูลเอกสาร
        </div>

        <div>
            REF ID :
            <?php echo h($ref_id); ?>
        </div>

    </div>

    <?php

    exit;
}


/* =========================================================
   DOCUMENT INFORMATION
========================================================= */

$job_no =
    fieldValue($so, 'job_no');


$iv_no =
    fieldValue($so, 'iv_no');


$customer_name =
    fieldValue($so, 'bill_name');


$customer_address =
    fieldValue($so, 'bill_address');


/* =========================================================
   SALE / DOCUMENT CREATOR
========================================================= */

$sale_name =
    fieldValue($so, 'sale');


if ($sale_name === '') {

    $sale_name =
        fieldValue($so, 'add_by');
}


$sale_date =
    fieldValue($so, 'add_date');


/* =========================================================
   APPROVE
========================================================= */

$approve_name =
    fieldValue($so, 'approve');


$approve_date =
    combineDateTime(
        fieldValue($so, 'approve_date'),
        fieldValue($so, 'approve_time')
    );


/* =========================================================
   ADMIN
========================================================= */

$admin_name =
    fieldValue($so, 'admin');


$admin_date =
    fieldValue($so, 'admin_date');


/* =========================================================
   TRACKING
========================================================= */

$tracking1 =
    fieldValue(
        $so,
        'order_refer_code'
    );


$tracking2 =
    fieldValue(
        $so,
        'order_refer_code1'
    );


$tracking =
    $tracking1 !== ''
    ? $tracking1
    : $tracking2;


/* =========================================================
   SHIPPING COMPANY
========================================================= */

$shipping_company = '-';

$tracking_upper =
    strtoupper($tracking);


if ($tracking !== '') {

    /*
     * KEX
     */
    if (
        strpos(
            $tracking_upper,
            'KEX'
        ) !== false
    ) {

        $shipping_company =
            'Kerry Express';

    }

    /*
     * LEX
     */
    elseif (
        strpos(
            $tracking_upper,
            'LEX'
        ) !== false
    ) {

        $shipping_company =
            'Lazada Express';

    }

    /*
     * SPX
     */
    elseif (
        strpos(
            $tracking_upper,
            'SPX'
        ) !== false
    ) {

        $shipping_company =
            'SPX Express';

    }

    /*
     * FLASH
     */
    elseif (
        strpos(
            $tracking_upper,
            'TH'
        ) === 0
    ) {

        $shipping_company =
            'Flash / ขนส่งภายนอก';

    }

    else {

        $shipping_company =
            'บริษัทขนส่งภายนอก';

    }

}


/* =========================================================
   SHIPPING METHOD
========================================================= */

$shipping_method = '-';


if ($tracking !== '') {

    $shipping_method =
        'บริษัทขนส่งภายนอก';
}


/*
 * ถ้าใน hos__so มี field จริง
 * สามารถ override ได้ตรงนี้
 */

$possibleShippingFields = array(

    'shipping_method',

    'delivery_type',

    'transport_type',

    'send_type',

    'delivery_method'

);


foreach (
    $possibleShippingFields
    as $shippingField
) {

    if (
        isset($so[$shippingField]) &&
        trim($so[$shippingField]) !== ''
    ) {

        $shipping_method =
            trim($so[$shippingField]);

        break;
    }

}


/*
 * บริษัทขนส่งจาก field ใน DB ถ้ามี
 */

$possibleCompanyFields = array(

    'shipping_company',

    'transport_name',

    'shipping_name',

    'delivery_company'

);


foreach (
    $possibleCompanyFields
    as $companyField
) {

    if (
        isset($so[$companyField]) &&
        trim($so[$companyField]) !== ''
    ) {

        $shipping_company =
            trim($so[$companyField]);

        break;
    }

}


/* =========================================================
   TB_REGISTER_DATA
========================================================= */

$refConnSafe =
    mysqli_real_escape_string(
        $mainDb,
        $ref_id
    );


$sqlRegister = "
    SELECT *
    FROM tb_register_data
    WHERE ref_id = '" . $refConnSafe . "'
    ORDER BY running DESC
    LIMIT 1
";


$registerData =
    fetchOne(
        $mainDb,
        $sqlRegister
    );


/* =========================================================
   FALLBACK DETAIL
========================================================= */

if (
    $job_no === '' &&
    isset($registerData['running'])
) {

    $job_no =
        trim($registerData['running']);
}


if (
    $iv_no === '' &&
    isset($registerData['product_sn'])
) {

    $iv_no =
        trim($registerData['product_sn']);
}


if (
    $customer_name === '' &&
    isset($registerData['customer_name'])
) {

    $customer_name =
        trim($registerData['customer_name']);
}


if (
    $customer_address === '' &&
    isset($registerData['address_name'])
) {

    $customer_address =
        trim($registerData['address_name']);
}


/* =========================================================
   PRODUCT DETAIL
========================================================= */

$product_detail = '';


if (
    isset($registerData['product_name']) &&
    trim($registerData['product_name']) !== ''
) {

    $product_detail =
        trim($registerData['product_name']);
}


/* =========================================================
   ST__MAIN
   จัดสินค้า
========================================================= */

$stockData = array();


if ($stockDb) {

    $stock_ref_safe =
        mysqli_real_escape_string(
            $stockDb,
            $ref_id
        );


    $sqlStock = "
        SELECT
            add_by,
            add_date
        FROM st__main
        WHERE ref_idsale = '" .
        $stock_ref_safe .
        "'
        ORDER BY add_date DESC
        LIMIT 1
    ";


    $stockData =
        fetchOne(
            $stockDb,
            $sqlStock
        );
}


/* =========================================================
   ST__SIGNATURE
   รับสินค้าจากคลัง
========================================================= */

$signatureData = array();


if ($stockDb) {

    $signature_ref_safe =
        mysqli_real_escape_string(
            $stockDb,
            $ref_id
        );


    $sqlSignature = "
        SELECT
            cs_code,
            cs_name,
            cs_dt
        FROM st__signature
        WHERE ref_id = '" .
        $signature_ref_safe .
        "'
        ORDER BY cs_dt DESC
        LIMIT 1
    ";


    $signatureData =
        fetchOne(
            $stockDb,
            $sqlSignature
        );
}


/* =========================================================
   RECEIVE NAME
========================================================= */

$receive_name =
    fieldValue(
        $signatureData,
        'cs_name'
    );


$cs_code =
    fieldValue(
        $signatureData,
        'cs_code'
    );


/*
 * ถ้า cs_name ไม่มี
 * หาจาก tb_user
 */
if (
    $receive_name === '' &&
    $cs_code !== ''
) {

    $cs_code_safe =
        mysqli_real_escape_string(
            $mainDb,
            $cs_code
        );


    $sqlUser = "
        SELECT
            name,
            surname
        FROM tb_user
        WHERE em_id = '" .
        $cs_code_safe .
        "'
        LIMIT 1
    ";


    $receiveUser =
        fetchOne(
            $mainDb,
            $sqlUser
        );


    if (!empty($receiveUser)) {

        $receive_name =
            trim(
                fieldValue(
                    $receiveUser,
                    'name'
                )
                .
                ' '
                .
                fieldValue(
                    $receiveUser,
                    'surname'
                )
            );
    }

}


/* =========================================================
   RESEARCH
========================================================= */

$researchData = array();


if ($job_no !== '') {

    $job_no_safe =
        mysqli_real_escape_string(
            $mainDb,
            $job_no
        );


    $sqlResearch = "
        SELECT
            running_id,
            research_id,
            add_by,
            add_date
        FROM tb_research
        WHERE running_id = '" .
        $job_no_safe .
        "'
        ORDER BY add_date DESC
        LIMIT 1
    ";


    $researchData =
        fetchOne(
            $mainDb,
            $sqlResearch
        );
}


/* =========================================================
   SUMMARY DELIVERY
========================================================= */

$summary_by =
    fieldValue(
        $registerData,
        'add_bycs'
    );


$summary_date =
    fieldValue(
        $registerData,
        'summary_csdate'
    );


$summary_text =
    fieldValue(
        $registerData,
        'summary_cs'
    );


$summary_remark = '';


/*
 * หน้าเดิมมีทั้ง description_cs
 * และ descript_cs
 */
if (
    isset($registerData['description_cs']) &&
    trim($registerData['description_cs']) !== ''
) {

    $summary_remark =
        trim(
            $registerData['description_cs']
        );

} elseif (
    isset($registerData['descript_cs']) &&
    trim($registerData['descript_cs']) !== ''
) {

    $summary_remark =
        trim(
            $registerData['descript_cs']
        );
}


/* =========================================================
   PROCESS
========================================================= */

$processes = array();


/* ---------- 1 ออกเอกสาร ---------- */

$processes[] = array(

    'name' =>
        'ออกเอกสาร',

    'status' =>
        $sale_name !== ''
        ? 'สมบูรณ์'
        : 'รอดำเนินการ',

    'class' =>
        $sale_name !== ''
        ? 'success'
        : 'pending',

    'user' =>
        $sale_name,

    'date' =>
        $sale_date

);


/* ---------- 2 อนุมัติ ---------- */

$processes[] = array(

    'name' =>
        'อนุมัติเอกสาร',

    'status' =>
        $approve_name !== ''
        ? 'สมบูรณ์'
        : 'รอดำเนินการ',

    'class' =>
        $approve_name !== ''
        ? 'success'
        : 'pending',

    'user' =>
        $approve_name,

    'date' =>
        $approve_date

);


/* ---------- 3 จัดสินค้า ---------- */

$stock_name =
    fieldValue(
        $stockData,
        'add_by'
    );


$stock_date =
    fieldValue(
        $stockData,
        'add_date'
    );


$processes[] = array(

    'name' =>
        'จัดสินค้า',

    'status' =>
        $stock_name !== ''
        ? 'สมบูรณ์'
        : 'รอดำเนินการ',

    'class' =>
        $stock_name !== ''
        ? 'success'
        : 'pending',

    'user' =>
        $stock_name,

    'date' =>
        $stock_date

);


/* ---------- 4 รับสินค้าจากคลัง ---------- */

$receive_date =
    fieldValue(
        $signatureData,
        'cs_dt'
    );


$processes[] = array(

    'name' =>
        'รับสินค้าจากคลัง',

    'status' =>
        $receive_name !== ''
        ? 'สมบูรณ์'
        : 'รอดำเนินการ',

    'class' =>
        $receive_name !== ''
        ? 'success'
        : 'pending',

    'user' =>
        $receive_name,

    'date' =>
        $receive_date

);


/* ---------- 5 แบบประเมิน ---------- */

$research_by =
    fieldValue(
        $researchData,
        'add_by'
    );


$research_date =
    fieldValue(
        $researchData,
        'add_date'
    );


$processes[] = array(

    'name' =>
        'ประเมินการให้บริการโดยลูกค้า',

    /*
     * ตามตัวอย่าง
     * ถ้ายังไม่มีข้อมูลให้ขึ้น "รอประเมิน"
     */
    'status' =>
        $research_by !== ''
        ? 'สมบูรณ์'
        : 'รอประเมิน',

    'class' =>
        $research_by !== ''
        ? 'success'
        : 'warning',

    'user' =>
        $research_by,

    'date' =>
        $research_date,

    'research' =>
        true

);


/* ---------- 6 สรุปการจัดส่ง ---------- */

$processes[] = array(

    'name' =>
        'สรุปการจัดส่ง',

    'status' =>
        $summary_by !== ''
        ? 'สมบูรณ์'
        : 'ไม่สมบูรณ์',

    'class' =>
        $summary_by !== ''
        ? 'success'
        : 'warning',

    'user' =>
        $summary_by,

    'date' =>
        $summary_date

);

?>


<style>

/* =========================================================
   AJAX DELIVERY
========================================================= */

.delivery-detail-modal {

    font-family:
        'Prompt',
        sans-serif;

    color:
        #555;

    background:
        #fff;

    border-radius:
        12px;

    overflow:
        hidden;

}


/* =========================================================
   HEADER
========================================================= */

.delivery-detail-header {

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    padding:
        20px 24px 8px;

}


.delivery-detail-title {

    flex:
        1;

    padding-bottom:
        9px;

    border-bottom:
        1px solid #e4e0e7;

    color:
        #3b3b3b;

    font-size:
        15px;

    font-weight:
        500;

}


.delivery-detail-close {

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    flex-shrink:
        0;

    width:
        34px;

    height:
        34px;

    margin-left:
        12px;

    padding:
        0;

    border:
        0;

    background:
        transparent;

    color:
        #777;

    font-size:
        25px;

    line-height:
        1;

    cursor:
        pointer;

    border-radius:
        50%;

}


.delivery-detail-close:hover {

    background:
        #f5f1f7;

    color:
        #612989;

}


/* =========================================================
   INFORMATION
========================================================= */

.delivery-info {

    padding:
        8px 40px 20px;

}


.delivery-info-grid {

    display:
        grid;

    grid-template-columns:
        repeat(
            3,
            minmax(0, 1fr)
        );

    column-gap:
        55px;

    row-gap:
        18px;

}


.delivery-info-item {

    min-width:
        0;

}


.delivery-info-item.full {

    grid-column:
        1 / -1;

}


.delivery-info-label {

    margin-bottom:
        5px;

    color:
        #612989;

    font-size:
        11px;

    font-weight:
        400;

}


.delivery-info-value {

    color:
        #68656c;

    font-size:
        12px;

    font-weight:
        300;

    line-height:
        1.6;

    word-break:
        break-word;

}


.delivery-required {

    color:
        #e74f70;

}


/* =========================================================
   TABLE
========================================================= */

.delivery-process-wrapper {

    border-top:
        1px solid #9a67bd;

    border-bottom:
        1px solid #9a67bd;

    overflow-x:
        auto;

}


.delivery-process-table {

    width:
        100%;

    min-width:
        700px;

    border-collapse:
        collapse;

    table-layout:
        fixed;

}


.delivery-process-table th {

    padding:
        8px 25px;

    border-bottom:
        1px solid #9a67bd;

    color:
        #612989;

    background:
        #fff;

    font-size:
        11px;

    font-weight:
        400;

    text-align:
        left;

}


.delivery-process-table th:nth-child(1) {

    width:
        38%;

}


.delivery-process-table th:nth-child(2) {

    width:
        20%;

    text-align:
        center;

}


.delivery-process-table th:nth-child(3) {

    width:
        22%;

    text-align:
        center;

}


.delivery-process-table th:nth-child(4) {

    width:
        20%;

    text-align:
        center;

}


.delivery-process-table td {

    padding:
        7px 25px;

    border-bottom:
        1px solid #ededed;

    color:
        #68656c;

    font-size:
        11px;

    font-weight:
        300;

    vertical-align:
        middle;

}


.delivery-process-table tbody tr:last-child td {

    border-bottom:
        0;

}


.delivery-process-table td:nth-child(2),
.delivery-process-table td:nth-child(3),
.delivery-process-table td:nth-child(4) {

    text-align:
        center;

}


/* =========================================================
   STATUS
========================================================= */

.delivery-status {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    min-width:
        86px;

    padding:
        4px 14px;

    border-radius:
        30px;

    font-size:
        10px;

    font-weight:
        400;

    line-height:
        1.2;

}


.delivery-status.success {

    background:
        #daf8df;

    color:
        #169f3c;

}


.delivery-status.warning {

    background:
        #ffe0c2;

    color:
        #ff7600;

}


.delivery-status.pending {

    background:
        #eeeeee;

    color:
        #888;

}


/* =========================================================
   LINK
========================================================= */

.delivery-research-link {

    color:
        #68656c;

    text-decoration:
        none;

}


.delivery-research-link:hover {

    color:
        #612989;

    text-decoration:
        underline;

}


/* =========================================================
   FOOTER SUMMARY
========================================================= */

.delivery-summary {

    padding:
        17px 40px 25px;

}


.delivery-summary-block {

    margin-bottom:
        20px;

}


.delivery-summary-block:last-child {

    margin-bottom:
        0;

}


.delivery-summary-title {

    margin-bottom:
        7px;

    color:
        #612989;

    font-size:
        11px;

    font-weight:
        400;

}


.delivery-summary-value {

    color:
        #68656c;

    font-size:
        12px;

    font-weight:
        300;

    line-height:
        1.7;

    white-space:
        pre-line;

}


/* =========================================================
   ERROR
========================================================= */

.delivery-error-box {

    padding:
        55px 30px;

    color:
        #a33232;

    text-align:
        center;

    font-family:
        'Prompt',
        sans-serif;

}


/* =========================================================
   MOBILE
========================================================= */

@media
(max-width: 800px) {

    .delivery-info {

        padding:
            10px 22px 20px;

    }


    .delivery-info-grid {

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        column-gap:
            25px;

    }


    .delivery-info-item.full {

        grid-column:
            1 / -1;

    }


    .delivery-summary {

        padding:
            18px 22px 25px;

    }

}


@media
(max-width: 520px) {

    .delivery-info-grid {

        grid-template-columns:
            1fr;

    }


    .delivery-info-item.full {

        grid-column:
            auto;

    }

}

</style>


<div class="delivery-detail-modal">


    <!-- ================================================
         HEADER
    ================================================= -->

    <div class="delivery-detail-header">

        <div class="delivery-detail-title">
            รายละเอียด
        </div>


        <button
            type="button"
            class="delivery-detail-close"
            onclick="closeDeliveryModal()"
            aria-label="ปิด"
        >
            &times;
        </button>

    </div>


    <!-- ================================================
         INFORMATION
    ================================================= -->

    <div class="delivery-info">

        <div class="delivery-info-grid">


            <!-- ใบงาน -->

            <div class="delivery-info-item">

                <div class="delivery-info-label">
                    เลขที่ใบงาน
                </div>

                <div class="delivery-info-value">
                    <?php echo valueOrDash($job_no); ?>
                </div>

            </div>


            <!-- เอกสาร -->

            <div class="delivery-info-item">

                <div class="delivery-info-label">
                    เลขที่เอกสาร
                </div>

                <div class="delivery-info-value">
                    <?php echo valueOrDash($iv_no); ?>
                </div>

            </div>


            <!-- ลูกค้า -->

            <div class="delivery-info-item">

                <div class="delivery-info-label">
                    ชื่อลูกค้า
                </div>

                <div class="delivery-info-value">
                    <?php echo valueOrDash($customer_name); ?>
                </div>

            </div>

<?php
/* =========================================================
   SHIPPING METHOD
========================================================= */

$delivery_type = fieldValue($so, 'delivery_type');

$delivery_type_map = array(
    '3' => 'พนักงานรับ/ลูกค้ารับ',
    '5' => 'บริษัทจัดส่ง(AllWell)',
    '4' => 'บริษัทขนส่งภายนอก',
);

$shipping_method = isset($delivery_type_map[$delivery_type])
    ? $delivery_type_map[$delivery_type]
    : '-';			
			
			?>
            <!-- วิธีจัดส่ง -->

           <div class="delivery-info-item">

    <div class="delivery-info-label">
        วิธีการจัดส่ง
    </div>

    <div class="delivery-info-value">
        <?php echo valueOrDash($shipping_method); ?>
    </div>

</div>


            <!-- บริษัท -->

            <div class="delivery-info-item">

                <div class="delivery-info-label">
                    บริษัทขนส่ง
                </div>

                <div class="delivery-info-value">
                    <?php echo valueOrDash($shipping_company); ?>
                </div>

            </div>


            <!-- Tracking -->

            <div class="delivery-info-item">

                <div class="delivery-info-label">
                    เลขพัสดุ
                </div>

                <div class="delivery-info-value">

                    <?php

                    if ($tracking1 !== '') {

                        echo h($tracking1);


                        if (
                            $tracking2 !== '' &&
                            $tracking2 !== $tracking1
                        ) {

                            echo '<br>';

                            echo h($tracking2);
                        }

                    } else {

                        echo '-';

                    }

                    ?>

                </div>

            </div>


            <!-- ที่อยู่ -->

            <div class="delivery-info-item full">

                <div class="delivery-info-label">

                    ที่อยู่จัดส่ง

                    <span class="delivery-required">
                        *
                    </span>

                </div>

                <div class="delivery-info-value">

                    <?php

                    echo $customer_address !== ''
                        ? nl2br(
                            h(
                                $customer_address
                            )
                        )
                        : '-';

                    ?>

                </div>

            </div>


            <?php if ($product_detail !== '') { ?>

                <div class="delivery-info-item full">

                    <div class="delivery-info-label">
                        รายละเอียด
                    </div>

                    <div class="delivery-info-value">

                        <?php
                        echo nl2br(
                            h(
                                $product_detail
                            )
                        );
                        ?>

                    </div>

                </div>

            <?php } ?>


        </div>

    </div>


    <!-- ================================================
         PROCESS
    ================================================= -->

    <div class="delivery-process-wrapper">

        <table class="delivery-process-table">


            <thead>

                <tr>

                    <th>
                        กระบวนการ
                    </th>

                    <th>
                        สถานะ
                    </th>

                    <th>
                        ผู้จัดทำ
                    </th>

                    <th>
                        วันที่/เวลา
                    </th>

                </tr>

            </thead>


            <tbody>


            <?php foreach ($processes as $process) { ?>


                <tr>


                    <!-- PROCESS -->

                    <td>

                        <?php

                        if (
                            !empty($process['research']) &&
                            !empty(
                                $researchData['research_id']
                            )
                        ) {

                            $researchUrl =
                                'report_research.php'
                                .
                                '?running_id='
                                .
                                urlencode(
                                    $researchData[
                                        'running_id'
                                    ]
                                )
                                .
                                '&research_id='
                                .
                                urlencode(
                                    $researchData[
                                        'research_id'
                                    ]
                                );

                            ?>

                            <a
                                href="<?php echo h($researchUrl); ?>"
                                target="_blank"
                                class="delivery-research-link"
                            >
                                <?php
                                echo h(
                                    $process['name']
                                );
                                ?>
                            </a>

                            <?php

                        } else {

                            echo h(
                                $process['name']
                            );

                        }

                        ?>

                    </td>


                    <!-- STATUS -->

                    <td>

                        <span
                            class="
                                delivery-status
                                <?php
                                echo h(
                                    $process['class']
                                );
                                ?>
                            "
                        >
                            <?php
                            echo h(
                                $process['status']
                            );
                            ?>
                        </span>

                    </td>


                    <!-- USER -->

                    <td>

                        <?php

                        echo
                            trim(
                                $process['user']
                            ) !== ''
                            ?
                            h(
                                $process['user']
                            )
                            :
                            '-';

                        ?>

                    </td>


                    <!-- DATE -->

                    <td>

                        <?php

                        echo formatThaiDateTime(
                            $process['date']
                        );

                        ?>

                    </td>


                </tr>


            <?php } ?>


            </tbody>

        </table>

    </div>


    <!-- ================================================
         SUMMARY
    ================================================= -->

    <div class="delivery-summary">


        <div class="delivery-summary-block">

            <div class="delivery-summary-title">
                ผลการส่งสินค้า
            </div>

            <div class="delivery-summary-value">

                <?php

                echo $summary_text !== ''
                    ?
                    nl2br(
                        h(
                            $summary_text
                        )
                    )
                    :
                    '-';

                ?>

            </div>

        </div>


        <div class="delivery-summary-block">

            <div class="delivery-summary-title">
                หมายเหตุ
            </div>

            <div class="delivery-summary-value">

                <?php

                echo $summary_remark !== ''
                    ?
                    nl2br(
                        h(
                            $summary_remark
                        )
                    )
                    :
                    '-';

                ?>

            </div>

        </div>


    </div>


</div>