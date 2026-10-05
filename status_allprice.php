<?php
include('head.php');
include "dbconnect.php";

date_default_timezone_set("Asia/Bangkok");


/* =========================================================
   HELPER
========================================================= */

function h($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}


function displayDateThaiSafe($date)
{
    if (
        empty($date) ||
        $date === '0000-00-00' ||
        $date === '0000-00-00 00:00:00'
    ) {
        return '-';
    }

    return DateThai($date);
}


/* =========================================================
   สิทธิ์อนุมัติ
========================================================= */

$canApprovePrice = false;

if (isset($_SESSION['name'])) {

    if (
        $_SESSION['name'] === 'อัจฉรา' ||
        $_SESSION['name'] === 'ชลชินี' ||
        $_SESSION['name'] === 'รุจิรา'
    ) {
        $canApprovePrice = true;
    }
}


/* =========================================================
   รับค่า FILTER
========================================================= */

$Keyword = isset($_GET['Keyword'])
    ? trim($_GET['Keyword'])
    : '';

$Keyword1 = isset($_GET['Keyword1'])
    ? trim($_GET['Keyword1'])
    : '';

$Keyword2 = isset($_GET['Keyword2'])
    ? trim($_GET['Keyword2'])
    : '';

$start_date = isset($_GET['start_date'])
    ? trim($_GET['start_date'])
    : '';

$end_date = isset($_GET['end_date'])
    ? trim($_GET['end_date'])
    : '';

$sale_channel = isset($_GET['sale_channel'])
    ? trim($_GET['sale_channel'])
    : '';

$scriptName = h($_SERVER['SCRIPT_NAME']);


/* =========================================================
   QUERY MAIN
========================================================= */

$strSQL = "
    SELECT
        ref_id,
        select_type_doc,
        register_date,
        sr_no,
        doc_no,
        doc_release_date,
        delivery_contact,
        approve_complete,
        ckk_h,
        bill_vat,
        status_vat,
        print_vat,
        print_doc,
        close_mount,
        cancel_ckk,
        order_id,
        billing_name,
        approve_date,
        pre_name,
        cus_sb,
        que_ckk,
        bill_id,
        smp_ckk,
        sale_channel,
        sale_remark
    FROM so__main
    WHERE price_ckk = '1'
";


/* =========================================================
   FILTER DATE
========================================================= */

if ($start_date !== '') {

    $safe = mysqli_real_escape_string(
        $conn,
        $start_date
    );

    $strSQL .= "
        AND register_date >= '{$safe}'
    ";
}


if ($end_date !== '') {

    $safe = mysqli_real_escape_string(
        $conn,
        $end_date
    );

    $strSQL .= "
        AND register_date <= '{$safe}'
    ";
}


/* =========================================================
   FILTER KEYWORD
========================================================= */

if ($Keyword !== '') {

    $safe = mysqli_real_escape_string(
        $conn,
        $Keyword
    );

    $strSQL .= "
        AND (
            delivery_contact LIKE '%{$safe}%'
            OR ref_id LIKE '%{$safe}%'
            OR customer_name LIKE '%{$safe}%'
            OR iv_no LIKE '%{$safe}%'
            OR doc_no LIKE '%{$safe}%'
            OR billing_name LIKE '%{$safe}%'
        )
    ";
}


/* =========================================================
   FILTER ORDER ID
========================================================= */

if ($Keyword2 !== '') {

    $safe = mysqli_real_escape_string(
        $conn,
        $Keyword2
    );

    $strSQL .= "
        AND order_id LIKE '%{$safe}%'
    ";
}


/* =========================================================
   FILTER TRACKING
========================================================= */

if ($Keyword1 !== '') {

    $safe = mysqli_real_escape_string(
        $conn,
        $Keyword1
    );

    $strSQL .= "
        AND (
            order_refer_code LIKE '%{$safe}%'
            OR order_refer_code1 LIKE '%{$safe}%'
        )
    ";
}


/* =========================================================
   FILTER SALE CHANNEL
========================================================= */

if ($sale_channel !== '') {

    $safe = mysqli_real_escape_string(
        $conn,
        $sale_channel
    );

    $strSQL .= "
        AND sale_channel = '{$safe}'
    ";
}


/* =========================================================
   COUNT
========================================================= */

$countSQL = "
    SELECT COUNT(*) AS cnt
    FROM (
        {$strSQL}
    ) AS count_table
";

$countQuery = mysqli_query(
    $conn,
    $countSQL
);

if (!$countQuery) {

    die(
        "Error Count Query [" .
        mysqli_error($conn) .
        "]"
    );
}

$countRow = mysqli_fetch_assoc(
    $countQuery
);

$Num_Rows = isset($countRow['cnt'])
    ? (int)$countRow['cnt']
    : 0;


/* =========================================================
   PAGINATION
========================================================= */

$Per_Page = 20;

$Page = isset($_GET['Page'])
    ? (int)$_GET['Page']
    : 1;

if ($Page < 1) {
    $Page = 1;
}

$Num_Pages = $Num_Rows > 0
    ? (int)ceil($Num_Rows / $Per_Page)
    : 1;

if ($Page > $Num_Pages) {
    $Page = $Num_Pages;
}

$Prev_Page = $Page - 1;
$Next_Page = $Page + 1;

$Page_Start =
    ($Page - 1) * $Per_Page;


/* =========================================================
   QUERY DATA
========================================================= */

$strSQL .= "
    ORDER BY ref_id DESC
    LIMIT {$Page_Start}, {$Per_Page}
";

$objQuery = mysqli_query(
    $conn,
    $strSQL
);

if (!$objQuery) {

    die(
        "Error Query [" .
        mysqli_error($conn) .
        "]"
    );
}


/* =========================================================
   จำนวน FILTER ที่ใช้งาน
========================================================= */

$filterCount = 0;

foreach (
    [
        $start_date,
        $end_date,
        $Keyword1,
        $Keyword2,
        $sale_channel
    ]
    as $filterValue
) {

    if ($filterValue !== '') {
        $filterCount++;
    }
}

?>


<link
    rel="stylesheet"
    href="css/so-status-ui.css"
>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>

/* =========================================================
   PAGE
========================================================= */

.price-status-page .so-card {
    min-height: 500px;
}

.price-status-page .page-title-row {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 16px;

    margin-bottom: 20px;
}

.price-status-page .page-title {
    margin: 0;
}

.price-status-page .page-subtitle {
    margin-top: 4px;

    font-size: 13px;
    color: #8E8B94;
}


/* =========================================================
   SEARCH
========================================================= */

.price-status-page .search-area {
    display: flex;
    align-items: flex-end;

    gap: 12px;

    margin-bottom: 20px;
}

.price-status-page .search-main {
    flex: 1;

    max-width: 680px;
    min-width: 250px;
}

.price-status-page .search-label {
    display: block;

    margin-bottom: 6px;

    font-family: 'Prompt', sans-serif !important;

    font-size: 14px;
    font-weight: 500;

    color: #612989;
}


/* =========================================================
   FILTER COUNT
========================================================= */

.filter-button-wrap {
    position: relative;
}

.filter-count {
    position: absolute;

    top: -7px;
    right: -7px;

    min-width: 20px;
    height: 20px;

    padding: 0 5px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #612989;
    color: #FFFFFF;

    border-radius: 20px;

    font-size: 11px;
    font-weight: 600;

    pointer-events: none;
}


/* =========================================================
   TABLE
========================================================= */

.price-status-page .so-table {
    min-width: 1450px;
}

.price-status-page .so-table th {
    vertical-align: middle;

    white-space: nowrap;
}

.price-status-page .so-table td {
    vertical-align: top;
}

.price-status-page .so-row {
    cursor: default;
}


/* =========================================================
   REF
========================================================= */

.ref-link {
    color: #612989;

    text-decoration: underline;

    font-weight: 500;

    white-space: nowrap;
}

.ref-date {
    margin-top: 4px;

    color: #8E8B94;

    font-size: 11px;

    white-space: nowrap;
}

.urgent-line {
    margin-top: 5px;

    color: #FA8C16;

    font-size: 11px;

    font-weight: 500;
}

.urgent-line i {
    margin-right: 3px;
}


/* =========================================================
   CUSTOMER
========================================================= */

.customer-name {
    color: #3B3B3B;

    font-size: 13px;
    font-weight: 500;

    text-align: left;
}

.customer-order {
    margin-top: 4px;

    color: #8E8B94;

    font-size: 11px;

    word-break: break-all;
}

.sale-remark {
    margin-top: 4px;

    color: #D4380D;

    font-size: 11px;
}


/* =========================================================
   PRODUCT
========================================================= */

.main-product-cell {
    min-width: 300px;

    padding-top: 8px !important;
    padding-bottom: 8px !important;

    text-align: left !important;
}

.main-product-row {
    min-height: 48px;

    padding: 7px 0;

    display: flex;
    align-items: center;

    gap: 7px;

    border-bottom: 1px solid #F1EDF3;
}

.main-product-row:last-child {
    border-bottom: none;
}

.main-product-name {
    flex: 1;

    color: #3B3B3B;

    font-size: 12px;
    font-weight: 500;
    line-height: 1.45;
}

.product-code {
    display: block;

    margin-top: 2px;

    color: #A3A0A6;

    font-size: 10px;
    font-weight: 400;
}

.product-qty {
    flex-shrink: 0;

    padding: 2px 7px;

    border-radius: 10px;

    background: #F4EEF8;

    color: #612989;

    font-size: 10px;
    font-weight: 500;

    white-space: nowrap;
}


/* =========================================================
   PRICE
========================================================= */

.price-column {
    min-width: 115px;

    padding-top: 8px !important;
    padding-bottom: 8px !important;

    text-align: right !important;

    font-variant-numeric: tabular-nums;
}

.product-price-row {
    min-height: 48px;

    padding: 7px 0;

    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: center;

    border-bottom: 1px solid #F1EDF3;

    color: #3B3B3B;

    font-size: 12px;
    font-weight: 500;
}

.product-price-row:last-child {
    border-bottom: none;
}


/* =========================================================
   SALE PRICE WARNING
========================================================= */

.product-sale-price.below-price {
    color: #CF1322;

    font-size: 13px;
    font-weight: 600;
}

.product-sale-price.normal-price {
    color: #3B3B3B;

    font-size: 13px;
    font-weight: 500;
}


/* =========================================================
   MINIMUM PRICE
========================================================= */

.minimum-price-column {
    background: #FFFDF7;
}

.minimum-price-value {
    color: #D46B08;

    font-size: 13px;
    font-weight: 600;
}


/* =========================================================
   DIFFERENCE
========================================================= */

.difference-column {
    background: #FFF9F9;
}

.price-difference {
    color: #CF1322;

    font-size: 12px;
    font-weight: 600;
}

.price-difference-label {
    margin-top: 2px;

    color: #BFBFBF;

    font-size: 9px;
    font-weight: 400;
}

.price-ok {
    color: #389E0D;

    font-size: 11px;
}


/* =========================================================
   APPROVAL
========================================================= */

.approval-header {
    text-align: center !important;

    padding-left: 4px !important;
    padding-right: 4px !important;
}

.approval-header-title {
    font-size: 11px;
    font-weight: 600;

    white-space: nowrap;
}

.approval-header-title.approve {
    color: #389E0D;
}

.approval-header-title.cancel {
    color: #CF1322;
}

.approval-master-label {
    display: flex;
    align-items: center;
    justify-content: center;

    gap: 3px;

    margin-top: 5px;

    cursor: pointer;

    color: #8E8B94;

    font-size: 9px;

    white-space: nowrap;
}

.approval-master-label input {
    width: 15px;
    height: 15px;

    cursor: pointer;

    accent-color: #612989;
}


/* =========================================================
   ROW APPROVE BUTTON
========================================================= */

.approval-cell {
    text-align: center !important;
    vertical-align: middle !important;

    padding-left: 5px !important;
    padding-right: 5px !important;
}

.approve-cell {
    background: #FBFFF8;
}

.cancel-cell {
    background: #FFF9F9;
}

.approval-checkbox {
    position: relative;

    display: inline-flex;

    cursor: pointer;
}

.approval-checkbox input {
    position: absolute;

    opacity: 0;

    pointer-events: none;
}

.approval-checkbox .checkmark {
    width: 29px;
    height: 29px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    background: #FFFFFF;

    border: 1px solid #D9D9D9;

    border-radius: 7px;

    font-size: 12px;

    transition: all .15s ease;
}

.approve-checkbox .checkmark {
    color: #389E0D;
}

.cancel-checkbox .checkmark {
    color: #CF1322;
}

.approve-checkbox:hover .checkmark {
    background: #F6FFED;

    border-color: #52C41A;
}

.cancel-checkbox:hover .checkmark {
    background: #FFF1F0;

    border-color: #FF4D4F;
}

.approve-checkbox input:checked + .checkmark {
    background: #52C41A;

    border-color: #52C41A;

    color: #FFFFFF;
}

.cancel-checkbox input:checked + .checkmark {
    background: #FF4D4F;

    border-color: #FF4D4F;

    color: #FFFFFF;
}

.approval-disabled {
    color: #BFBFBF;
}


/* =========================================================
   BADGE
========================================================= */

.custom-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 5px 9px;

    border-radius: 20px;

    font-size: 11px;
    font-weight: 500;

    white-space: nowrap;
}

.custom-badge.approve {
    color: #237804;

    background: #F6FFED;
}

.custom-badge.rejected {
    color: #CF1322;

    background: #FFF1F0;
}

.custom-badge.cancel {
    color: #CF1322;

    background: #FFF1F0;
}

.custom-badge.pending {
    color: #AD6800;

    background: #FFF7E6;
}

.custom-badge.gold {
    color: #AD6800;

    background: #FFFBE6;
}

.custom-badge.platinum {
    color: #595959;

    background: #F5F5F5;
}

.custom-badge.diamond {
    color: #08979C;

    background: #E6FFFB;
}


/* =========================================================
   SALE CHANNEL
========================================================= */

.channel-name {
    color: #3B3B3B;

    font-size: 12px;
    font-weight: 500;
}


/* =========================================================
   SAVE BAR
========================================================= */

.approval-action-bar {
    position: sticky;

    bottom: 10px;

    z-index: 30;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    margin-top: 16px;

    padding: 14px 18px;

    background: rgba(250, 248, 252, .98);

    border: 1px solid #E5DCEC;
    border-radius: 12px;

    box-shadow:
        0 4px 20px
        rgba(97, 41, 137, .08);
}

.approval-summary {
    display: flex;
    align-items: center;

    gap: 12px;

    color: #595959;

    font-size: 13px;
}

.approval-summary strong {
    color: #612989;

    font-size: 16px;
}

.approval-summary-divider {
    width: 1px;
    height: 18px;

    background: #D9D9D9;
}

.btn-save-approval {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    padding: 10px 20px;

    background: #612989;

    color: #FFFFFF;

    border: none;
    border-radius: 8px;

    font-family: 'Prompt', sans-serif !important;

    font-size: 13px;
    font-weight: 500;

    cursor: pointer;

    transition: .15s ease;
}

.btn-save-approval:hover {
    background: #4E2170;
}


/* =========================================================
   EMPTY
========================================================= */

.empty-table {
    padding: 45px !important;

    text-align: center !important;

    color: #8E8B94 !important;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .price-status-page .search-area {
        flex-wrap: wrap;
    }

    .price-status-page .search-main {
        width: 100%;

        max-width: none;
    }

    .approval-action-bar {
        flex-direction: column;

        align-items: stretch;
    }

    .approval-summary {
        justify-content: center;
    }

    .btn-save-approval {
        width: 100%;
    }
}

</style>


<body>


<script>

(function()
{
    var collapsed =
        localStorage.getItem(
            "sidebar_collapsed"
        ) === "1";


    document.body.classList.add(
        "has-sidebar"
    );


    if (collapsed) {

        document.body.classList.add(
            "sidebar-collapsed"
        );


        var sidebar =
            document.getElementById(
                "sidebar"
            );


        if (sidebar) {

            sidebar.classList.add(
                "sidebar-collapsed"
            );
        }
    }

})();

</script>



<div class="status-so-page price-status-page">

<div class="so-card">


<!-- =====================================================
     TITLE
====================================================== -->

<div class="page-title-row">

    <div>

        <h4 class="page-title">

            <?php if ($canApprovePrice) { ?>

                อนุมัติออเดอร์สินค้าราคาต่ำกว่ากำหนด

            <?php } else { ?>

                Status ออเดอร์สินค้าราคาต่ำกว่ากำหนด

            <?php } ?>

        </h4>


        <div class="page-subtitle">

            แสดงรายการสินค้า ราคาขาย และราคาต่ำสุด
            เพื่อช่วยตรวจสอบก่อนอนุมัติ

        </div>

    </div>

</div>



<!-- =====================================================
     SEARCH
====================================================== -->

<form
    method="GET"
    action="<?php echo $scriptName; ?>"
    id="mainSearchForm"
>


<input
    type="hidden"
    name="start_date"
    value="<?php echo h($start_date); ?>"
>

<input
    type="hidden"
    name="end_date"
    value="<?php echo h($end_date); ?>"
>

<input
    type="hidden"
    name="Keyword1"
    value="<?php echo h($Keyword1); ?>"
>

<input
    type="hidden"
    name="Keyword2"
    value="<?php echo h($Keyword2); ?>"
>

<input
    type="hidden"
    name="sale_channel"
    value="<?php echo h($sale_channel); ?>"
>


<div class="search-area">


    <div class="search-main">


        <label class="search-label">

            ค้นหาเลขที่อ้างอิง /
            เลขที่เอกสาร /
            ชื่อลูกค้า

        </label>


        <div class="so-search-wrapper">

            <i
                class="fas fa-search so-search-icon"
            ></i>


            <input
                name="Keyword"
                class="so-input"
                type="text"
                id="Keyword"
                placeholder="Search"
                value="<?php echo h($Keyword); ?>"
            >

        </div>

    </div>



    <button
        type="submit"
        class="btn-so-outline"
    >

        <i class="fas fa-search"></i>

        ค้นหา

    </button>



    <div class="filter-button-wrap">

        <button
            type="button"
            class="btn-so-secondary"
            onclick="openFilterModal()"
        >

            <i class="fas fa-filter"></i>

            Filters

        </button>


        <?php if ($filterCount > 0) { ?>

            <span class="filter-count">

                <?php echo $filterCount; ?>

            </span>

        <?php } ?>

    </div>



    <?php
    if (
        $Keyword !== '' ||
        $filterCount > 0
    ) {
    ?>

        <a
            href="<?php echo $scriptName; ?>"
            class="btn-so-outline"
            style="text-decoration:none;"
        >

            <i class="fas fa-sync-alt"></i>

            รีเซ็ต

        </a>

    <?php } ?>


</div>

</form>



<!-- =====================================================
     FILTER MODAL
====================================================== -->

<div
    id="filterModal"
    class="w3-modal"
    style="
        display:none;
        z-index:9999;
    "
>


<div
    class="w3-modal-content w3-card-4"
    role="dialog"
    aria-modal="true"
    style="
        border-radius:16px;
        max-width:680px;
    "
>


<div
    class="w3-container"
    style="padding:32px;"
>


<form
    method="GET"
    action="<?php echo $scriptName; ?>"
    id="modalFilterForm"
>


<input
    type="hidden"
    name="Keyword"
    id="modalKeyword"
    value="<?php echo h($Keyword); ?>"
>


<div
    class="so-modal-header"
    style="
        border-bottom:none;
        padding-bottom:0;
        margin-bottom:24px;
    "
>

    <h5
        style="
            margin:0;
            font-weight:600;
            color:#3B3B3B;
            font-size:20px;
        "
    >
        Filters
    </h5>


    <button
        type="button"
        onclick="closeFilterModal()"
        style="
            background:none;
            border:none;
            padding:0;
            font-size:28px;
            cursor:pointer;
            color:#8E8B94;
        "
    >
        &times;
    </button>

</div>



<!-- DATE -->

<div class="so-form-row">

    <div>

        <label class="so-label">
            ตั้งแต่วันที่
        </label>

        <input
            type="date"
            name="start_date"
            id="modal_start_date"
            class="so-select so-modal-input"
            value="<?php echo h($start_date); ?>"
        >

    </div>


    <div>

        <label class="so-label">
            ถึงวันที่
        </label>

        <input
            type="date"
            name="end_date"
            class="so-select so-modal-input"
            value="<?php echo h($end_date); ?>"
        >

    </div>

</div>



<!-- ORDER / TRACKING -->

<div class="so-form-row">

    <div>

        <label class="so-label">

            หมายเลขคำสั่งซื้อ

        </label>


        <input
            type="text"
            name="Keyword2"
            class="so-select so-modal-input"
            placeholder="Order ID"
            value="<?php echo h($Keyword2); ?>"
        >

    </div>


    <div>

        <label class="so-label">

            เลขพัสดุ

        </label>


        <input
            type="text"
            name="Keyword1"
            class="so-select so-modal-input"
            placeholder="Tracking Number"
            value="<?php echo h($Keyword1); ?>"
        >

    </div>

</div>



<!-- CHANNEL -->

<div style="margin-bottom:22px;">

    <label class="so-label">

        ช่องทางการขาย

    </label>


    <select
        name="sale_channel"
        class="so-select"
    >

        <option value="">

            ทุกช่องทางการขาย

        </option>


        <?php

        $sqlchannel = "
            SELECT
                salechannel_ID,
                salechannel_nameshort
            FROM tb_salechannel
            ORDER BY salechannel_ID
        ";

        $querychannel =
            mysqli_query(
                $conn,
                $sqlchannel
            );


        while (
            $fetchchannel =
            mysqli_fetch_array(
                $querychannel,
                MYSQLI_ASSOC
            )
        ) {

            $selected =
                (
                    (string)$sale_channel ===
                    (string)$fetchchannel[
                        'salechannel_ID'
                    ]
                )
                ? 'selected'
                : '';

        ?>

            <option
                value="<?php
                    echo h(
                        $fetchchannel[
                            'salechannel_ID'
                        ]
                    );
                ?>"
                <?php echo $selected; ?>
            >

                <?php
                echo h(
                    $fetchchannel[
                        'salechannel_nameshort'
                    ]
                );
                ?>

            </option>

        <?php } ?>

    </select>

</div>



<!-- FILTER BUTTON -->

<div class="so-modal-footer">

    <button
        type="submit"
        class="btn-filter-submit"
        onclick="syncKeyword()"
    >
        ตกลง
    </button>


    <button
        type="button"
        class="btn-filter-reset"
        onclick="resetFilters()"
    >

        <i
            class="fas fa-sync-alt"
            style="margin-right:6px;"
        ></i>

        รีเซ็ต

    </button>

</div>


</form>

</div>
</div>
</div>



<!-- =====================================================
     APPROVE FORM
====================================================== -->

<?php if ($canApprovePrice) { ?>

<form
    name="approvePriceForm"
    id="approvePriceForm"
    method="POST"
    action="status_price_save.php"
    onsubmit="return confirmApproveSave();"
>

<?php } ?>



<!-- =====================================================
     TABLE
====================================================== -->

<div class="so-table-wrapper">


<table
    class="so-table"
    id="soTable"
>


<thead>

<tr>


<?php if ($canApprovePrice) { ?>


    <th
        width="4%"
        class="approval-header"
    >

        <div
            class="
                approval-header-title
                approve
            "
        >
            อนุมัติ
        </div>


        <label class="approval-master-label">

            <input
                type="checkbox"
                id="check_all_approve"
                onclick="checkAllApprove(this)"
            >

            ทั้งหมด

        </label>

    </th>



    <th
        width="4%"
        class="approval-header"
    >

        <div
            class="
                approval-header-title
                cancel
            "
        >
            ยกเลิก
        </div>


        <label class="approval-master-label">

            <input
                type="checkbox"
                id="check_all_cancel"
                onclick="checkAllCancel(this)"
            >

            ทั้งหมด

        </label>

    </th>


<?php } ?>


    <th width="8%">
        เลขที่อ้างอิง
    </th>


    <th width="13%">
        ลูกค้า / Order
    </th>


    <th width="24%">
        รายการสินค้า
    </th>


    <th
        width="10%"
        style="text-align:right !important;"
    >
        ราคาสินค้า
    </th>


    <th
        width="10%"
        style="text-align:right !important;"
    >
        ราคาต่ำสุด
    </th>


    <th
        width="9%"
        style="text-align:right !important;"
    >
        ส่วนต่าง
    </th>


    <th width="10%">
        ช่องทางขาย
    </th>


    <th width="9%">
        สถานะ
    </th>


    <th width="3%"></th>


</tr>

</thead>



<tbody>


<?php

$hasData = false;


while (
    $objResult =
    mysqli_fetch_array(
        $objQuery,
        MYSQLI_ASSOC
    )
) {

    $hasData = true;


    /* =====================================================
       REF
    ====================================================== */

    $ref_id =
        $objResult['ref_id'];


    $ref_id_safe =
        mysqli_real_escape_string(
            $conn,
            $ref_id
        );


    $ref_id_url =
        urlencode(
            $ref_id
        );


    /* =====================================================
       DROPDOWN
    ====================================================== */

    $safeDomRef =
        preg_replace(
            '/[^a-zA-Z0-9_-]/',
            '-',
            $ref_id
        );


    $dropdown_id =
        'dropdown-' .
        $safeDomRef;


    $dropdown_id_js =
        htmlspecialchars(
            json_encode(
                $dropdown_id
            ),
            ENT_QUOTES,
            'UTF-8'
        );


    /* =====================================================
       CUSTOMER STATUS
    ====================================================== */

    $status_cus = '';
    $customer_no = '';


    $billIdSafe =
        mysqli_real_escape_string(
            $conn,
            $objResult[
                'bill_id'
            ]
        );


    $sqlCustomer = "
        SELECT
            status_cus,
            customer_no
        FROM tb_customer
        WHERE customer_id =
              '{$billIdSafe}'
        LIMIT 1
    ";


    $qryCustomer =
        mysqli_query(
            $conn,
            $sqlCustomer
        );


    if ($qryCustomer) {

        $rsCustomer =
            mysqli_fetch_assoc(
                $qryCustomer
            );


        if ($rsCustomer) {

            $status_cus =
                $rsCustomer[
                    'status_cus'
                ];


            $customer_no =
                $rsCustomer[
                    'customer_no'
                ];
        }
    }


    /* =====================================================
       CUSTOMER BADGE
    ====================================================== */

    $customerStatusText = '';
    $customerStatusClass = '';


    if ($customer_no !== '') {


        if ($status_cus == '0') {

            $customerStatusText =
                'Gold';

            $customerStatusClass =
                'gold';


        } elseif (
            $status_cus == '1'
        ) {

            $customerStatusText =
                'Platinum';

            $customerStatusClass =
                'platinum';


        } elseif (
            $status_cus == '2'
        ) {

            $customerStatusText =
                'Diamond';

            $customerStatusClass =
                'diamond';
        }
    }


    /* =====================================================
       SALE CHANNEL
    ====================================================== */

    $channelName = '-';


    $channelSafe =
        mysqli_real_escape_string(
            $conn,
            $objResult[
                'sale_channel'
            ]
        );


    $sqlChannel = "
        SELECT
            salechannel_nameshort
        FROM tb_salechannel
        WHERE salechannel_ID =
              '{$channelSafe}'
        LIMIT 1
    ";


    $qryChannel =
        mysqli_query(
            $conn,
            $sqlChannel
        );


    if ($qryChannel) {

        $rsChannel =
            mysqli_fetch_assoc(
                $qryChannel
            );


        if ($rsChannel) {

            $channelName =
                $rsChannel[
                    'salechannel_nameshort'
                ];
        }
    }


    /* =====================================================
       PRODUCTS

       sale_channel = 34
       ใช้ tb_product_tiktok
       sku_code = code_jd

       ช่องทางอื่น
       ใช้ tb_product_lzd
       sku_code = code_lazada
    ====================================================== */

    $products = [];


    if (
        (string)$objResult[
            'sale_channel'
        ] === '34'
    ) {


        $sqlProducts = "
            SELECT
                s.product_ID,
                s.product_code,
                s.sku_code,
                s.sale_count,
                s.price_per_unit,
                s.price_per_unitref,
                s.discount_unit,
                s.sum_amount,

                p.sol_name,

                tp.percen_price
                    AS minimum_price

            FROM so__submain s

            LEFT JOIN tb_product p
                ON s.product_ID =
                   p.product_id

            LEFT JOIN tb_product_tiktok tp
                ON s.sku_code =
                   tp.code_jd

            WHERE s.ref_idd =
                  '{$ref_id_safe}'

            ORDER BY s.id ASC
        ";


    } else {


        $sqlProducts = "
            SELECT
                s.product_ID,
                s.product_code,
                s.sku_code,
                s.sale_count,
                s.price_per_unit,
                s.price_per_unitref,
                s.discount_unit,
                s.sum_amount,

                p.sol_name,

                lp.percen_price
                    AS minimum_price

            FROM so__submain s

            LEFT JOIN tb_product p
                ON s.product_ID =
                   p.product_id

            LEFT JOIN tb_product_lzd lp
                ON s.sku_code =
                   lp.code_lazada

            WHERE s.ref_idd =
                  '{$ref_id_safe}'

            ORDER BY s.id ASC
        ";

    }


    $qryProducts =
        mysqli_query(
            $conn,
            $sqlProducts
        );


    if (!$qryProducts) {

        die(
            "Error Product Query [" .
            mysqli_error($conn) .
            "]"
        );
    }


    while (
        $product =
        mysqli_fetch_array(
            $qryProducts,
            MYSQLI_ASSOC
        )
    ) {

        /*
         * ป้องกันกรณี Join mapping
         * ได้ราคาว่าง
         */
        $minimum_price = null;


        if (
            isset(
                $product[
                    'minimum_price'
                ]
            ) &&
            $product[
                'minimum_price'
            ] !== '' &&
            $product[
                'minimum_price'
            ] !== null &&
            (float)$product[
                'minimum_price'
            ] != 0
        ) {

            $minimum_price =
                (float)$product[
                    'minimum_price'
                ];
        }


        /*
         * หน้าเดิมใช้ sum_amount
         * เป็นราคาที่นำมาแสดง
         */
        $sale_price =
            isset(
                $product[
                    'sum_amount'
                ]
            )
            ? (float)$product[
                'sum_amount'
            ]
            : 0;


        $product[
            'display_sale_price'
        ] =
            $sale_price;


        $product[
            'display_minimum_price'
        ] =
            $minimum_price;


        $products[] =
            $product;
    }


    /* =====================================================
       APPROVE STATUS
    ====================================================== */

    $approveText = '-';
    $approveClass = 'pending';


    if (
        (string)$objResult[
            'cancel_ckk'
        ] === '1'
    ) {

        $approveText =
            'ยกเลิก';

        $approveClass =
            'cancel';


    } elseif (
        $objResult[
            'approve_complete'
        ] === 'Rejected'
    ) {

        $approveText =
            'ไม่อนุมัติ';

        $approveClass =
            'rejected';


    } elseif (
        $objResult[
            'approve_complete'
        ] === 'Approve'
    ) {

        $approveText =
            'อนุมัติแล้ว';

        $approveClass =
            'approve';


    } elseif (
        $objResult[
            'approve_complete'
        ] === 'Request'
    ) {

        $approveText =
            'รออนุมัติ';

        $approveClass =
            'pending';


    } elseif (
        !empty(
            $objResult[
                'approve_complete'
            ]
        )
    ) {

        $approveText =
            $objResult[
                'approve_complete'
            ];
    }


    /* =====================================================
       CAN APPROVE ROW
    ====================================================== */

    $canSelectRow = (

        $objResult[
            'approve_complete'
        ] === 'Request'

        &&

        (string)$objResult[
            'cancel_ckk'
        ] !== '1'

    );

?>


<tr class="so-row">


<!-- =====================================================
     APPROVE
====================================================== -->

<?php if ($canApprovePrice) { ?>


<td
    class="
        approval-cell
        approve-cell
    "
>

    <?php if ($canSelectRow) { ?>

        <label
            class="
                approval-checkbox
                approve-checkbox
            "
            title="อนุมัติรายการนี้"
        >

            <input
                type="checkbox"
                name="order_ckk[<?php
                    echo h(
                        $ref_id
                    );
                ?>]"
                value="1"
            >


            <span class="checkmark">

                <i class="fas fa-check"></i>

            </span>

        </label>

    <?php } else { ?>

        <span class="approval-disabled">
            -
        </span>

    <?php } ?>

</td>



<!-- =====================================================
     CANCEL
====================================================== -->

<td
    class="
        approval-cell
        cancel-cell
    "
>

    <?php if ($canSelectRow) { ?>

        <label
            class="
                approval-checkbox
                cancel-checkbox
            "
            title="ยกเลิกรายการนี้"
        >

            <input
                type="checkbox"
                name="canncel_ckk[<?php
                    echo h(
                        $ref_id
                    );
                ?>]"
                value="1"
            >


            <span class="checkmark">

                <i class="fas fa-times"></i>

            </span>

        </label>

    <?php } else { ?>

        <span class="approval-disabled">
            -
        </span>

    <?php } ?>


    <input
        type="hidden"
        name="ref_id[<?php
            echo h(
                $ref_id
            );
        ?>]"
        value="<?php
            echo h(
                $ref_id
            );
        ?>"
    >

</td>


<?php } ?>



<!-- =====================================================
     REF ID
====================================================== -->

<td>


    <a
        href="register_admin_edit.php?ref_id=<?php echo $ref_id_url; ?>"
        class="ref-link"
    >

        <?php
        echo h(
            $ref_id
        );
        ?>

    </a>


    <div class="ref-date">

        <?php

        echo displayDateThaiSafe(
            $objResult[
                'register_date'
            ]
        );

        ?>

    </div>


    <?php
    if (
        $objResult[
            'que_ckk'
        ] == '1'
    ) {
    ?>

        <div class="urgent-line">

            <i class="fas fa-bolt"></i>

            ด่วน

        </div>

    <?php } ?>


</td>



<!-- =====================================================
     CUSTOMER / ORDER
====================================================== -->

<td>


    <div class="customer-name">

        <?php

        echo h(
            $objResult[
                'pre_name'
            ] .
            $objResult[
                'billing_name'
            ]
        );

        ?>

    </div>



    <?php
    if (
        $customerStatusText !== ''
    ) {
    ?>

        <div
            style="
                margin-top:5px;
            "
        >

            <span
                class="
                    custom-badge
                    <?php
                    echo
                    $customerStatusClass;
                    ?>
                "
            >

                <?php
                echo
                $customerStatusText;
                ?>

            </span>

        </div>

    <?php } ?>



    <?php
    if (
        !empty(
            $objResult[
                'order_id'
            ]
        )
    ) {
    ?>

        <div class="customer-order">

            Order:

            <?php

            echo h(
                $objResult[
                    'order_id'
                ]
            );

            ?>

        </div>

    <?php } ?>



    <?php

    if (
        isset(
            $_SESSION[
                'name'
            ]
        ) &&

        in_array(
            $_SESSION[
                'name'
            ],
            [
                'อัจฉรา',
                'นงลักษณ์',
                'ธิติพร'
            ],
            true
        ) &&

        $objResult[
            'sale_channel'
        ] == '35' &&

        !empty(
            $objResult[
                'sale_remark'
            ]
        )
    ) {

    ?>

        <div class="sale-remark">

            <?php

            echo h(
                $objResult[
                    'sale_remark'
                ]
            );

            ?>

        </div>

    <?php } ?>


</td>



<!-- =====================================================
     PRODUCT NAME
====================================================== -->

<td class="main-product-cell">


<?php if (count($products) > 0) { ?>


    <?php foreach ($products as $product) { ?>


        <div class="main-product-row">


            <div class="main-product-name">


                <?php

                echo h(
                    !empty(
                        $product[
                            'sol_name'
                        ]
                    )
                    ? $product[
                        'sol_name'
                    ]
                    : '-'
                );

                ?>


                <?php
                if (
                    !empty(
                        $product[
                            'sku_code'
                        ]
                    )
                ) {
                ?>

                    <span class="product-code">

                        SKU:

                        <?php

                        echo h(
                            $product[
                                'sku_code'
                            ]
                        );

                        ?>

                    </span>

                <?php } ?>


            </div>



            <?php
            if (
                isset(
                    $product[
                        'sale_count'
                    ]
                ) &&
                (float)$product[
                    'sale_count'
                ] > 0
            ) {
            ?>

                <span class="product-qty">

                    x

                    <?php

                    echo h(
                        $product[
                            'sale_count'
                        ]
                    );

                    ?>

                </span>

            <?php } ?>


        </div>


    <?php } ?>


<?php } else { ?>


    <div
        style="
            color:#BFBFBF;
            padding:8px 0;
        "
    >
        -
    </div>


<?php } ?>


</td>



<!-- =====================================================
     SALE PRICE
====================================================== -->

<td class="price-column">


<?php if (count($products) > 0) { ?>


    <?php foreach ($products as $product) { ?>


        <?php

        $salePrice =
            (float)$product[
                'display_sale_price'
            ];


        $minPrice =
            $product[
                'display_minimum_price'
            ];


        $isBelow = (
            $minPrice !== null &&
            $salePrice < $minPrice
        );

        ?>


        <div class="product-price-row">


            <span
                class="
                    product-sale-price
                    <?php
                    echo
                    $isBelow
                    ? 'below-price'
                    : 'normal-price';
                    ?>
                "
            >

                <?php

                echo number_format(
                    $salePrice,
                    2
                );

                ?>

            </span>


        </div>


    <?php } ?>


<?php } else { ?>


    -


<?php } ?>


</td>



<!-- =====================================================
     MINIMUM PRICE
====================================================== -->

<td
    class="
        price-column
        minimum-price-column
    "
>


<?php if (count($products) > 0) { ?>


    <?php foreach ($products as $product) { ?>


        <?php

        $minPrice =
            $product[
                'display_minimum_price'
            ];

        ?>


        <div class="product-price-row">


            <?php
            if (
                $minPrice !== null
            ) {
            ?>

                <span class="minimum-price-value">

                    <?php

                    echo number_format(
                        $minPrice,
                        2
                    );

                    ?>

                </span>


            <?php } else { ?>


                <span
                    style="
                        color:#BFBFBF;
                    "
                >
                    -
                </span>


            <?php } ?>


        </div>


    <?php } ?>


<?php } else { ?>


    -


<?php } ?>


</td>



<!-- =====================================================
     DIFFERENCE
====================================================== -->

<td
    class="
        price-column
        difference-column
    "
>


<?php if (count($products) > 0) { ?>


    <?php foreach ($products as $product) { ?>


        <?php

        $salePrice =
            (float)$product[
                'display_sale_price'
            ];


        $minPrice =
            $product[
                'display_minimum_price'
            ];

        ?>


        <div class="product-price-row">


            <?php
            if (
                $minPrice !== null
            ) {


                $difference =
                    $minPrice -
                    $salePrice;


                if (
                    $difference > 0
                ) {
            ?>


                    <span class="price-difference">

                        -<?php

                        echo number_format(
                            $difference,
                            2
                        );

                        ?>

                    </span>


                    <span class="price-difference-label">

                        ต่ำกว่ากำหนด

                    </span>


                <?php
                } else {
                ?>


                    <span class="price-ok">

                        -

                    </span>


                <?php
                }

            } else {
            ?>


                <span
                    style="
                        color:#BFBFBF;
                    "
                >
                    -
                </span>


            <?php } ?>


        </div>


    <?php } ?>


<?php } else { ?>


    -


<?php } ?>


</td>



<!-- =====================================================
     CHANNEL
====================================================== -->

<td>


    <span class="channel-name">

        <?php
        echo h(
            $channelName
        );
        ?>

    </span>


</td>



<!-- =====================================================
     STATUS
====================================================== -->

<td>


    <span
        class="
            custom-badge
            <?php
            echo
            $approveClass;
            ?>
        "
    >

        <?php

        echo h(
            $approveText
        );

        ?>

    </span>


</td>



<!-- =====================================================
     MENU
====================================================== -->

<td
    style="
        text-align:center;
        vertical-align:middle;
        position:relative;
    "
>


<div class="so-dropdown">


<button
    type="button"
    class="so-dropdown-trigger"
    aria-label="ตัวเลือกเพิ่มเติม"
    aria-haspopup="true"
    aria-expanded="false"
    onclick="
        toggleDropdown(
            event,
            <?php
            echo
            $dropdown_id_js;
            ?>
        )
    "
>

    <i class="fas fa-ellipsis-v"></i>

</button>



<div
    id="<?php
        echo h(
            $dropdown_id
        );
    ?>"
    class="so-dropdown-menu"
>


    <a
        href="register_admin_edit.php?ref_id=<?php echo $ref_id_url; ?>"
        class="so-dropdown-item"
    >

        <i
            class="fas fa-eye"
            style="width:16px;"
        ></i>

        ดูรายละเอียด

    </a>



    <?php
    if (
        $objResult[
            'approve_complete'
        ] === 'Approve'
    ) {
    ?>

        <a
            href="register_admin_edit.php?ref_id=<?php echo $ref_id_url; ?>"
            class="so-dropdown-item"
        >

            <i
                class="fas fa-edit"
                style="width:16px;"
            ></i>

            แก้ไข

        </a>

    <?php } ?>


</div>

</div>


</td>


</tr>


<?php
}
?>



<?php if (!$hasData) { ?>


<tr>

    <td
        colspan="<?php
            echo
            $canApprovePrice
            ? '11'
            : '9';
        ?>"
        class="empty-table"
    >

        <i
            class="fas fa-inbox"
            style="
                font-size:26px;
                margin-bottom:8px;
                display:block;
            "
        ></i>

        ไม่พบข้อมูล

    </td>

</tr>


<?php } ?>


</tbody>

</table>


</div>



<!-- =====================================================
     APPROVAL SAVE BAR
====================================================== -->

<?php if ($canApprovePrice) { ?>


<div class="approval-action-bar">


    <div class="approval-summary">


        <span>

            อนุมัติ

            <strong
                id="approveSelectedCount"
            >
                0
            </strong>

            รายการ

        </span>


        <span
            class="
                approval-summary-divider
            "
        ></span>


        <span>

            ยกเลิก

            <strong
                id="cancelSelectedCount"
            >
                0
            </strong>

            รายการ

        </span>


    </div>



    <button
        type="submit"
        class="btn-save-approval"
    >

        <i class="fas fa-save"></i>

        บันทึกผลการอนุมัติ

    </button>


</div>


</form>


<?php } ?>



<!-- =====================================================
     PAGINATION
====================================================== -->

<div class="pagination-wrapper">


<div>

    พบทั้งหมด

    <strong>
        <?php echo $Num_Rows; ?>
    </strong>

    รายการ

    (หน้าที่

    <?php echo $Page; ?>

    จาก

    <?php echo $Num_Pages; ?>

    หน้า)

</div>



<div class="pagination-links">


<?php


$pagParams =
    "&Keyword=" .
    urlencode(
        $Keyword
    ) .

    "&start_date=" .
    urlencode(
        $start_date
    ) .

    "&end_date=" .
    urlencode(
        $end_date
    ) .

    "&Keyword1=" .
    urlencode(
        $Keyword1
    ) .

    "&Keyword2=" .
    urlencode(
        $Keyword2
    ) .

    "&sale_channel=" .
    urlencode(
        $sale_channel
    );



/* PREVIOUS */

if (
    $Prev_Page >= 1
) {

    echo "
        <a
            class='pagination-btn'
            aria-label='หน้าก่อนหน้า'
            href='{$scriptName}?Page={$Prev_Page}{$pagParams}'
        >

            <i
                class='fas fa-chevron-left'
            ></i>

        </a>
    ";
}



/* PAGE RANGE */

$start_p =
    max(
        1,
        $Page - 3
    );


$end_p =
    min(
        $Num_Pages,
        $Page + 3
    );



/* FIRST */

if ($start_p > 1) {

    echo "
        <a
            class='pagination-btn'
            href='{$scriptName}?Page=1{$pagParams}'
        >
            1
        </a>
    ";


    if ($start_p > 2) {

        echo "
            <span
                style='padding:4px;'
            >
                ...
            </span>
        ";
    }
}



/* PAGE NUMBERS */

for (
    $p = $start_p;
    $p <= $end_p;
    $p++
) {

    $activeClass =
        ($p == $Page)
        ? 'active'
        : '';


    echo "
        <a
            class='pagination-btn {$activeClass}'
            href='{$scriptName}?Page={$p}{$pagParams}'
        >
            {$p}
        </a>
    ";
}



/* LAST */

if (
    $end_p <
    $Num_Pages
) {

    if (
        $end_p <
        $Num_Pages - 1
    ) {

        echo "
            <span
                style='padding:4px;'
            >
                ...
            </span>
        ";
    }


    echo "
        <a
            class='pagination-btn'
            href='{$scriptName}?Page={$Num_Pages}{$pagParams}'
        >
            {$Num_Pages}
        </a>
    ";
}



/* NEXT */

if (
    $Page <
    $Num_Pages
) {

    echo "
        <a
            class='pagination-btn'
            aria-label='หน้าถัดไป'
            href='{$scriptName}?Page={$Next_Page}{$pagParams}'
        >

            <i
                class='fas fa-chevron-right'
            ></i>

        </a>
    ";
}


?>


</div>

</div>


</div>
</div>



<script>

/* =========================================================
   FILTER
========================================================= */

function openFilterModal()
{
    var modal =
        document.getElementById(
            'filterModal'
        );


    if (!modal) {
        return;
    }


    modal.style.display =
        'block';


    var first =
        document.getElementById(
            'modal_start_date'
        );


    if (first) {
        first.focus();
    }
}



function closeFilterModal()
{
    var modal =
        document.getElementById(
            'filterModal'
        );


    if (modal) {

        modal.style.display =
            'none';
    }
}



function syncKeyword()
{
    var source =
        document.getElementById(
            'Keyword'
        );


    var target =
        document.getElementById(
            'modalKeyword'
        );


    if (
        source &&
        target
    ) {

        target.value =
            source.value;
    }
}



function resetFilters()
{
    window.location.href =
        <?php
        echo json_encode(
            $_SERVER[
                'SCRIPT_NAME'
            ]
        );
        ?>;
}



document.addEventListener(
    'keydown',
    function(event)
    {

        if (
            event.key ===
            'Escape'
        ) {

            closeFilterModal();
        }
    }
);



/* =========================================================
   DROPDOWN
========================================================= */

function toggleDropdown(
    event,
    dropdownId
)
{
    event.preventDefault();
    event.stopPropagation();


    var trigger =
        event.currentTarget;


    var menu =
        document.getElementById(
            dropdownId
        );


    if (!menu) {
        return;
    }


    var isOpen =
        menu.classList.contains(
            'show'
        );


    document
        .querySelectorAll(
            '.so-dropdown-menu'
        )
        .forEach(
            function(m)
            {
                m.classList.remove(
                    'show'
                );
            }
        );


    document
        .querySelectorAll(
            '.so-dropdown-trigger'
        )
        .forEach(
            function(t)
            {
                t.setAttribute(
                    'aria-expanded',
                    'false'
                );
            }
        );


    if (isOpen) {
        return;
    }


    menu.classList.add(
        'show'
    );


    trigger.setAttribute(
        'aria-expanded',
        'true'
    );


    var rect =
        trigger
        .getBoundingClientRect();


    menu.style.display =
        'block';


    var menuWidth =
        menu.offsetWidth ||
        190;


    var menuHeight =
        menu.offsetHeight ||
        120;


    menu.style.display = '';


    var left =
        rect.right -
        menuWidth;


    if (left < 10) {
        left = 10;
    }


    if (
        left +
        menuWidth >
        window.innerWidth -
        10
    ) {

        left =
            window.innerWidth -
            menuWidth -
            10;
    }


    menu.style.position =
        'fixed';

    menu.style.zIndex =
        '99999';

    menu.style.left =
        left + 'px';


    var spaceBelow =
        window.innerHeight -
        rect.bottom;


    if (
        spaceBelow <
        menuHeight + 10 &&
        rect.top >
        menuHeight
    ) {

        menu.style.top =
            (
                rect.top -
                menuHeight -
                4
            ) +
            'px';

    } else {

        menu.style.top =
            (
                rect.bottom +
                4
            ) +
            'px';
    }
}



document.addEventListener(
    'click',
    function(event)
    {

        if (
            !event.target.closest(
                '.so-dropdown'
            )
        ) {

            document
                .querySelectorAll(
                    '.so-dropdown-menu'
                )
                .forEach(
                    function(m)
                    {
                        m.classList.remove(
                            'show'
                        );
                    }
                );


            document
                .querySelectorAll(
                    '.so-dropdown-trigger'
                )
                .forEach(
                    function(t)
                    {
                        t.setAttribute(
                            'aria-expanded',
                            'false'
                        );
                    }
                );
        }
    }
);



window.addEventListener(
    'scroll',
    function()
    {

        document
            .querySelectorAll(
                '.so-dropdown-menu.show'
            )
            .forEach(
                function(m)
                {

                    m.classList.remove(
                        'show'
                    );
                }
            );

    },
    true
);



/* =========================================================
   APPROVE ALL
========================================================= */

function checkAllApprove(master)
{
    var approveCheckboxes =
        document.querySelectorAll(
            'input[type="checkbox"][name^="order_ckk["]'
        );


    approveCheckboxes.forEach(
        function(cb)
        {
            cb.checked =
                master.checked;
        }
    );


    /*
     * เลือก Approve ทั้งหมด
     * เอา Cancel ออกทั้งหมด
     */
    if (
        master.checked
    ) {

        var cancelMaster =
            document.getElementById(
                'check_all_cancel'
            );


        if (
            cancelMaster
        ) {

            cancelMaster.checked =
                false;
        }


        var cancelCheckboxes =
            document.querySelectorAll(
                'input[type="checkbox"][name^="canncel_ckk["]'
            );


        cancelCheckboxes.forEach(
            function(cb)
            {
                cb.checked =
                    false;
            }
        );
    }


    updateCheckAllStatus();

    updateApprovalCount();
}



/* =========================================================
   CANCEL ALL
========================================================= */

function checkAllCancel(master)
{
    var cancelCheckboxes =
        document.querySelectorAll(
            'input[type="checkbox"][name^="canncel_ckk["]'
        );


    cancelCheckboxes.forEach(
        function(cb)
        {
            cb.checked =
                master.checked;
        }
    );


    /*
     * เลือก Cancel ทั้งหมด
     * เอา Approve ออกทั้งหมด
     */
    if (
        master.checked
    ) {

        var approveMaster =
            document.getElementById(
                'check_all_approve'
            );


        if (
            approveMaster
        ) {

            approveMaster.checked =
                false;
        }


        var approveCheckboxes =
            document.querySelectorAll(
                'input[type="checkbox"][name^="order_ckk["]'
            );


        approveCheckboxes.forEach(
            function(cb)
            {
                cb.checked =
                    false;
            }
        );
    }


    updateCheckAllStatus();

    updateApprovalCount();
}



/* =========================================================
   SINGLE CHECKBOX
========================================================= */

document.addEventListener(
    'change',
    function(e)
    {

        /*
         * APPROVE
         */
        if (
            e.target.matches(
                'input[name^="order_ckk["]'
            )
        ) {

            if (
                e.target.checked
            ) {

                var refId =
                    e.target.name.match(
                        /\[(.*?)\]/
                    );


                if (
                    refId
                ) {

                    var cancelCheckbox =
                        document.querySelector(
                            'input[name="canncel_ckk[' +
                            refId[1] +
                            ']"]'
                        );


                    if (
                        cancelCheckbox
                    ) {

                        cancelCheckbox.checked =
                            false;
                    }
                }
            }


            updateCheckAllStatus();

            updateApprovalCount();
        }



        /*
         * CANCEL
         */
        if (
            e.target.matches(
                'input[name^="canncel_ckk["]'
            )
        ) {

            if (
                e.target.checked
            ) {

                var refId =
                    e.target.name.match(
                        /\[(.*?)\]/
                    );


                if (
                    refId
                ) {

                    var approveCheckbox =
                        document.querySelector(
                            'input[name="order_ckk[' +
                            refId[1] +
                            ']"]'
                        );


                    if (
                        approveCheckbox
                    ) {

                        approveCheckbox.checked =
                            false;
                    }
                }
            }


            updateCheckAllStatus();

            updateApprovalCount();
        }

    }
);



/* =========================================================
   MASTER STATUS
========================================================= */

function updateCheckAllStatus()
{
    var approveCheckboxes =
        document.querySelectorAll(
            'input[type="checkbox"][name^="order_ckk["]'
        );


    var approveChecked =
        document.querySelectorAll(
            'input[type="checkbox"][name^="order_ckk["]:checked'
        );


    var cancelCheckboxes =
        document.querySelectorAll(
            'input[type="checkbox"][name^="canncel_ckk["]'
        );


    var cancelChecked =
        document.querySelectorAll(
            'input[type="checkbox"][name^="canncel_ckk["]:checked'
        );


    var approveMaster =
        document.getElementById(
            'check_all_approve'
        );


    var cancelMaster =
        document.getElementById(
            'check_all_cancel'
        );


    if (
        approveMaster
    ) {

        approveMaster.checked =
            (
                approveCheckboxes.length > 0 &&
                approveCheckboxes.length ===
                approveChecked.length
            );
    }


    if (
        cancelMaster
    ) {

        cancelMaster.checked =
            (
                cancelCheckboxes.length > 0 &&
                cancelCheckboxes.length ===
                cancelChecked.length
            );
    }
}



/* =========================================================
   COUNT
========================================================= */

function updateApprovalCount()
{
    var approveCount =
        document.querySelectorAll(
            'input[name^="order_ckk["]:checked'
        ).length;


    var cancelCount =
        document.querySelectorAll(
            'input[name^="canncel_ckk["]:checked'
        ).length;


    var approveEl =
        document.getElementById(
            'approveSelectedCount'
        );


    var cancelEl =
        document.getElementById(
            'cancelSelectedCount'
        );


    if (
        approveEl
    ) {

        approveEl.textContent =
            approveCount;
    }


    if (
        cancelEl
    ) {

        cancelEl.textContent =
            cancelCount;
    }
}



/* =========================================================
   SAVE CONFIRM
========================================================= */

function confirmApproveSave()
{
    var approveCount =
        document.querySelectorAll(
            'input[name^="order_ckk["]:checked'
        ).length;


    var cancelCount =
        document.querySelectorAll(
            'input[name^="canncel_ckk["]:checked'
        ).length;


    /*
     * ไม่ได้เลือกอะไร
     */
    if (
        approveCount === 0 &&
        cancelCount === 0
    ) {

        Swal.fire({

            icon:
                'warning',

            text:
                'กรุณาเลือกรายการที่ต้องการอนุมัติหรือยกเลิก',

            confirmButtonColor:
                '#612989',

            confirmButtonText:
                'ตกลง'

        });


        return false;
    }



    Swal.fire({

        title:
            'ยืนยันการบันทึก',

        html:
            'อนุมัติ <b>' +
            approveCount +
            '</b> รายการ<br>' +

            'ยกเลิก <b>' +
            cancelCount +
            '</b> รายการ',

        icon:
            'question',

        showCancelButton:
            true,

        confirmButtonColor:
            '#612989',

        cancelButtonColor:
            '#8E8B94',

        confirmButtonText:
            'ยืนยัน',

        cancelButtonText:
            'ยกเลิก'


    }).then(
        function(result)
        {

            if (
                result.isConfirmed
            ) {

                var form =
                    document.getElementById(
                        'approvePriceForm'
                    );


                /*
                 * ปิด confirm รอบถัดไป
                 */
                form.onsubmit =
                    null;


                form.submit();
            }

        }
    );


    return false;
}



/* =========================================================
   INIT
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function()
    {

        updateCheckAllStatus();

        updateApprovalCount();

    }
);

</script>



<div id="cr_bar">

    <?php include "foot.php"; ?>

</div>


</body>
</html>