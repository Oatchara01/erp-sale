<?php
include('head.php');
include "dbconnect.php";

date_default_timezone_set("Asia/Bangkok");

// =========================================================
// GET PARAMS
// =========================================================
$sale_channel = isset($_GET['sale_channel']) ? trim($_GET['sale_channel']) : '';
$Keyword      = isset($_GET['Keyword']) ? trim($_GET['Keyword']) : '';
$Keyword1     = isset($_GET['Keyword1']) ? trim($_GET['Keyword1']) : '';
$Keyword2     = isset($_GET['Keyword2']) ? trim($_GET['Keyword2']) : '';
$start_date   = isset($_GET['start_date']) ? trim($_GET['start_date']) : '';
$end_date     = isset($_GET['end_date']) ? trim($_GET['end_date']) : '';

$to_day = date('Y-m-d');

// =========================================================
// BUILD FILTER CONDITIONS
// =========================================================
$whereSQL = " WHERE 1 ";

if ($start_date !== '') {
    $start_date_safe = mysqli_real_escape_string($conn, $start_date);
    $whereSQL .= " AND m.register_date >= '$start_date_safe'";
} elseif ($Keyword2 === '') {
    $whereSQL .= " AND m.register_date >= '$to_day'";
}

if ($end_date !== '') {
    $end_date_safe = mysqli_real_escape_string($conn, $end_date);
    $whereSQL .= " AND m.register_date <= '$end_date_safe'";
} elseif ($Keyword2 === '') {
    $whereSQL .= " AND m.register_date <= '$to_day'";
}

if ($Keyword !== '') {
    $Keyword_safe = mysqli_real_escape_string($conn, $Keyword);
    $whereSQL .= " AND (
        m.delivery_contact LIKE '%$Keyword_safe%'
        OR m.ref_id = '$Keyword_safe'
        OR m.customer_name LIKE '%$Keyword_safe%'
        OR m.iv_no LIKE '%$Keyword_safe%'
        OR m.doc_no LIKE '%$Keyword_safe%'
        OR m.billing_name LIKE '%$Keyword_safe%'
    )";
}

if ($Keyword2 !== '') {
    $Keyword2_safe = mysqli_real_escape_string($conn, $Keyword2);
    $whereSQL .= " AND m.order_id LIKE '%$Keyword2_safe%'";
}

if ($Keyword1 !== '') {
    $Keyword1_safe = mysqli_real_escape_string($conn, $Keyword1);
    $whereSQL .= " AND (
        m.order_refer_code LIKE '%$Keyword1_safe%'
        OR m.order_refer_code1 LIKE '%$Keyword1_safe%'
    )";
}

if ($sale_channel !== '') {
    $sale_channel_safe = mysqli_real_escape_string($conn, $sale_channel);
    $whereSQL .= " AND m.sale_channel = '$sale_channel_safe'";
}

// =========================================================
// PAGINATION COUNT - COUNT(*) only, do not load all rows
// =========================================================
$countSQL = "SELECT COUNT(*) AS total FROM so__main m" . $whereSQL;
$countQuery = mysqli_query($conn, $countSQL) or die("Error Query [" . $countSQL . "]");
$countRow = mysqli_fetch_assoc($countQuery);
$Num_Rows = (int)($countRow['total'] ?? 0);

$Per_Page = 20;
$Page = max(1, (int)($_GET['Page'] ?? 1));
$Prev_Page = $Page - 1;
$Next_Page = $Page + 1;
$Page_Start = (($Per_Page * $Page) - $Per_Page);
$Num_Pages = max(1, (int)ceil($Num_Rows / $Per_Page));

// =========================================================
// MAIN QUERY - preload related data with JOINs
// =========================================================
$strSQL = "
    SELECT
        m.ref_id,
        m.select_type_doc,
        m.register_date,
        m.sr_no,
        m.doc_no,
        m.doc_release_date,
        m.delivery_contact,
        m.approve_complete,
        m.ckk_h,
        m.bill_vat,
        m.status_vat,
        m.print_vat,
        m.print_doc,
        m.close_mount,
        m.cancel_ckk,
        m.order_id,
        m.billing_name,
        m.approve_date,
        m.pre_name,
        m.cus_sb,
        m.que_ckk,
        m.bill_id,
        m.smp_ckk,
        m.sale_channel,
        m.sale_remark,
        c.status_cus,
        c.customer_no,
        c.vip_ckk,
        sc.salechannel_nameshort,
        cn.ref_credit,
        hs.ref_idsmp,
        hs.status_sup
    FROM so__main m
    LEFT JOIN tb_customer c
        ON c.customer_id = m.bill_id
    LEFT JOIN tb_salechannel sc
        ON sc.salechannel_ID = m.sale_channel
    LEFT JOIN (
        SELECT ref_id, MAX(ref_credit) AS ref_credit
        FROM tb_credit_note
        GROUP BY ref_id
    ) cn ON cn.ref_id = m.ref_id
    LEFT JOIN (
        SELECT ref_idsale, MAX(ref_idsmp) AS ref_idsmp, MAX(status_sup) AS status_sup
        FROM hos__smp
        GROUP BY ref_idsale
    ) hs ON hs.ref_idsale = m.ref_id
" . $whereSQL . "
    ORDER BY m.ref_id DESC
    LIMIT $Page_Start, $Per_Page
";

$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");

// Fetch current page once so product rows can also be loaded in one query.
$pageRows = [];
$refIds = [];
while ($row = mysqli_fetch_assoc($objQuery)) {
    $pageRows[] = $row;
    $refIds[] = $row['ref_id'];
}
$Page_Num_Rows = count($pageRows);

// =========================================================
// PRODUCT PREFETCH - one query for all 20 orders
// =========================================================
$productsByRef = [];
if (!empty($refIds)) {
    $escapedRefs = array_map(function ($ref) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $ref) . "'";
    }, $refIds);

    $productSQL = "
        SELECT
            s.ref_idd,
            s.*,
            p.sol_name
        FROM so__submain s
        LEFT JOIN tb_product p
            ON s.product_ID = p.product_id
        WHERE s.ref_idd IN (" . implode(',', $escapedRefs) . ")
        ORDER BY s.ref_idd
    ";

    $productQuery = mysqli_query($conn, $productSQL);
    if ($productQuery) {
        while ($productRow = mysqli_fetch_assoc($productQuery)) {
            $productsByRef[$productRow['ref_idd']][] = $productRow;
        }
    }
}
?>

<link rel="stylesheet" href="css/so-status-ui.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<body>
<script>
(function() {
    var collapsed = localStorage.getItem("sidebar_collapsed") === "1";
    document.body.classList.add("has-sidebar");
    if (collapsed) {
        document.body.classList.add("sidebar-collapsed");
        var sidebar = document.getElementById("sidebar");
        if (sidebar) sidebar.classList.add("sidebar-collapsed");
    }
})();
</script>

<div class="status-so-page">
    <div class="so-card">

        <!-- =====================================================
             HEADER
        ====================================================== -->
        <div class="w3-container w3-bar w3-margin-bottom" style="padding-left:0;padding-right:0;">
            <h4 style="margin:0;">ออเดอร์ E-Commerce</h4>
        </div>

        <!-- =====================================================
             SEARCH + FILTER
        ====================================================== -->
        <form name="frmSearch" method="GET" action="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8'); ?>" id="mainSearchForm">

            <div class="so-input-group" style="align-items:flex-end; margin-bottom:20px;">

                <div style="flex:1; max-width:680px; min-width:250px; display:flex; flex-direction:column; gap:6px;">
                    <label for="Keyword" style="font-size:14px; color:#612989; font-weight:500;">
                        ค้นหาด้วยเลขที่อ้างอิง / เลขที่เอกสาร / ชื่อลูกค้า
                    </label>

                    <div class="so-search-wrapper" style="width:100%;">
                        <i class="fas fa-search so-search-icon"></i>
                        <input
                            name="Keyword"
                            id="Keyword"
                            class="so-input"
                            type="text"
                            placeholder="ค้นหา..."
                            value="<?php echo htmlspecialchars($Keyword, ENT_QUOTES, 'UTF-8'); ?>"
                        >
                    </div>
                </div>

                <button type="button" class="btn-so-secondary" onclick="openFilterModal()">
                    <i class="fas fa-filter"></i> Filters
                </button>

            </div>

            <!-- FILTER MODAL -->
            <div id="filterModal" class="w3-modal" style="display:none; z-index:9999;">
                <div class="w3-modal-content w3-card-4" role="dialog" aria-modal="true" aria-labelledby="filterModalTitle" style="border-radius:16px; max-width:640px;">
                    <div class="w3-container" style="padding:32px;">

                        <div class="so-modal-header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 24px;">
                            <h5 id="filterModalTitle" style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px; font-family: 'Prompt', sans-serif !important;">Filters</h5>
                            <button
                                type="button"
                                onclick="closeFilterModal()"
                                aria-label="ปิด"
                                style="background:none; border:none; font-size:28px; cursor:pointer; color:#8E8B94; line-height:1; padding:0;"
                            >&times;</button>
                        </div>

                        <div class="so-form-row">
                            <div>
                                <label class="so-label" for="start_date">ตั้งแต่วันที่</label>
                                <input
                                    type="date"
                                    name="start_date"
                                    id="start_date"
                                    class="so-select so-modal-input"
                                    value="<?php echo htmlspecialchars($start_date, ENT_QUOTES, 'UTF-8'); ?>"
                                >
                            </div>

                            <div>
                                <label class="so-label" for="end_date">ถึงวันที่</label>
                                <input
                                    type="date"
                                    name="end_date"
                                    id="end_date"
                                    class="so-select so-modal-input"
                                    value="<?php echo htmlspecialchars($end_date, ENT_QUOTES, 'UTF-8'); ?>"
                                >
                            </div>
                        </div>

                        <div class="so-form-row">
                            <div>
                                <label class="so-label" for="Keyword2">หมายเลขคำสั่งซื้อ</label>
                                <input
                                    type="text"
                                    name="Keyword2"
                                    id="Keyword2"
                                    class="so-select so-modal-input"
                                    placeholder="Order ID"
                                    value="<?php echo htmlspecialchars($Keyword2, ENT_QUOTES, 'UTF-8'); ?>"
                                >
                            </div>

                            <div>
                                <label class="so-label" for="Keyword1">เลขพัสดุ</label>
                                <input
                                    type="text"
                                    name="Keyword1"
                                    id="Keyword1"
                                    class="so-select so-modal-input"
                                    placeholder="Tracking No."
                                    value="<?php echo htmlspecialchars($Keyword1, ENT_QUOTES, 'UTF-8'); ?>"
                                >
                            </div>
                        </div>

                        <div class="so-form-row">
                            <div>
                                <label class="so-label" for="sale_channel">ช่องทางการขาย</label>
                                <select name="sale_channel" id="sale_channel" class="so-select">
                                    <option value="">-- ทั้งหมด --</option>
                                    <?php
                                    $sqlchannel = "SELECT * FROM tb_salechannel ORDER BY salechannel_ID";
                                    $querychannel = mysqli_query($conn, $sqlchannel);
                                    while ($fetchchannel = mysqli_fetch_array($querychannel, MYSQLI_ASSOC)) {
                                        $selected = ($sale_channel == $fetchchannel['salechannel_ID']) ? 'selected' : '';
                                    ?>
                                        <option
                                            value="<?php echo htmlspecialchars($fetchchannel['salechannel_ID'], ENT_QUOTES, 'UTF-8'); ?>"
                                            <?php echo $selected; ?>
                                        >
                                            <?php echo htmlspecialchars($fetchchannel['salechannel_nameshort'], ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div></div>
                        </div>

                        <div class="so-modal-footer">
                            <button type="submit" class="btn-filter-submit">ตกลง</button>
                            <button type="button" class="btn-filter-reset" onclick="resetFilters()">
                                <i class="fas fa-sync-alt" style="margin-right:6px;"></i> รีเซ็ต
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </form>

        <!-- =====================================================
             MAIN TABLE
        ====================================================== -->
        <div class="so-table-wrapper">
            <table class="so-table">
                <thead>
                    <tr>
                        <th width="3%"></th>
                        <th style="white-space:nowrap;">เลขที่อ้างอิง</th>
                        <th style="white-space:nowrap;">วันที่ลงทะเบียน</th>
                        <th style="white-space:nowrap;">เลขที่เอกสาร</th>
                        <th style="white-space:nowrap;">วันที่ออกเอกสาร</th>
                        <th style="white-space:nowrap;">เลขที่ SR</th>
                        <th style="white-space:nowrap;">หมายเลขคำสั่งซื้อ</th>
                        <th style="white-space:nowrap;">ชื่อลูกค้า</th>
                        <th style="white-space:nowrap;">ช่องทางการขาย</th>
                        <th style="white-space:nowrap; width:11%; text-align:center;">สถานะการอนุมัติ</th>
                        <th width="4%" style="text-align:center;"></th>
                    </tr>
                </thead>

                <tbody>

                <?php if ($Page_Num_Rows === 0) { ?>
                    <tr>
                        <td colspan="11" style="text-align:center; padding:40px 16px; color:#6B6875;">
                            <?php echo ($Num_Rows > 0)
                                ? 'ไม่พบข้อมูลในหน้านี้ — ลองกลับไปหน้าแรก'
                                : 'ไม่พบข้อมูลที่ตรงกับเงื่อนไข ลองล้างตัวกรองหรือเปลี่ยนคำค้น'; ?>
                        </td>
                    </tr>
                <?php } ?>

                <?php
                foreach ($pageRows as $objResult) {

                    $ref_id = $objResult['ref_id'];
                    $ref_id_safe = mysqli_real_escape_string($conn, $ref_id);

                    $row_id = 'row-' . $ref_id;
                    $dropdown_id = 'dropdown-' . $ref_id;

                    $row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
                    $dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');

                    // Related data are already loaded by the main JOIN query.
                    $rs = [
                        'status_cus' => $objResult['status_cus'] ?? null,
                        'customer_no' => $objResult['customer_no'] ?? null,
                        'vip_ckk' => $objResult['vip_ckk'] ?? null,
                    ];
                    $rs12 = [
                        'ref_idsmp' => $objResult['ref_idsmp'] ?? null,
                        'status_sup' => $objResult['status_sup'] ?? null,
                    ];
                    $rs5 = [
                        'ref_credit' => $objResult['ref_credit'] ?? null,
                    ];
                    $sale_channel_name = !empty($objResult['salechannel_nameshort'])
                        ? $objResult['salechannel_nameshort']
                        : '-';

                    // Customer status
                    $customer_status = '-';
                    $customer_status_class = 'draft';
                    if (!empty($rs['customer_no'])) {
                        if ((string)$rs['status_cus'] === '0') {
                            $customer_status = 'Gold Customer';
                            $customer_status_class = 'pending-mgr';
                        } elseif ((string)$rs['status_cus'] === '1') {
                            $customer_status = 'Platinum Customer';
                            $customer_status_class = 'approve';
                        } elseif ((string)$rs['status_cus'] === '2') {
                            $customer_status = 'Diamond Customer';
                            $customer_status_class = 'closed';
                        }
                    }

                    // Main approval status
                    $status_text = $objResult['approve_complete'];
                    $status_class = 'draft';

                    if ($objResult['cancel_ckk'] == '1') {
                        $status_text = 'ยกเลิก';
                        $status_class = 'cancel';
                    } elseif ($objResult['approve_complete'] === 'Rejected') {
                        $status_text = 'Rejected';
                        $status_class = 'rejected';
                    } elseif ($objResult['approve_complete'] === 'Approve') {
                        $status_text = 'Approve';
                        $status_class = 'approve';
                    } elseif ($objResult['approve_complete'] === 'Request') {
                        $status_text = 'รออนุมัติ';
                        $status_class = 'pending-mgr';
                    }

                    if ($status_text === '' || $status_text === null) {
                        $status_text = '-';
                    }
                ?>

                    <!-- MAIN ROW -->
                    <tr class="so-row" role="button" tabindex="0" aria-expanded="false" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">

                        <td style="text-align:center;">
                            <img
                                src="img/icons/arrow_down.png"
                                class="caret-icon"
                                style="width:12px; height:12px;"
                                alt=""
                            >
                        </td>

                        <td>
                            <a class="ref-link" href="register_admin_edit.php?ref_id=<?php echo urlencode($objResult['ref_id']); ?>" onclick="event.stopPropagation();">
                                <?php echo htmlspecialchars($objResult['ref_id'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>

                            <?php /*if ($objResult['ckk_h'] == '0' && $objResult['doc_no'] != 'ยกเลิก') { ?>
                                <div style="margin-top:5px;">
                                    <span class="badge-status rejected">รอดำเนินการ</span>
                                </div>
                            <?php }*/ ?>
                        </td>

                        <td style="white-space:nowrap;">
                            <?php echo DateThai($objResult['register_date']); ?>
                        </td>

                        <td>
                            <?php if ($objResult['que_ckk'] == '1') { ?>
                                <span class="badge-status rejected">
                                    <?php echo htmlspecialchars($objResult['doc_no'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            <?php } else { ?>
                                <?php echo htmlspecialchars($objResult['doc_no'], ENT_QUOTES, 'UTF-8'); ?>
                            <?php } ?>

                            <?php /*if ($objResult['print_doc'] == '0') { ?>
                                <div style="margin-top:5px; color:#9C4FA0; font-size:inherit;">ยังไม่พิมพ์เอกสาร</div>
                            <?php }*/ ?>
                        </td>

                        <td style="white-space:nowrap;">
                            <?php
                            echo ($objResult['doc_release_date'] == '0000-00-00' || $objResult['doc_release_date'] == '')
                                ? '-'
                                : DateThai($objResult['doc_release_date']);
                            ?>
                        </td>

                        <td style="white-space:nowrap;">
                            <?php echo htmlspecialchars($objResult['sr_no'] ?: '-', ENT_QUOTES, 'UTF-8'); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($objResult['order_id'], ENT_QUOTES, 'UTF-8'); ?>

                            <?php if (
                                $_SESSION['name'] == 'อัจฉรา' ||
                                $_SESSION['name'] == 'นงลักษณ์' ||
                                $_SESSION['name'] == 'สุดารัตน์'
                            ) { ?>
                                <?php if ($objResult['sale_channel'] == '35' && $objResult['sale_remark'] !== '') { ?>
                                    <div style="color:#d32f2f; font-size:inherit; margin-top:4px;">
                                        <?php echo htmlspecialchars($objResult['sale_remark'], ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </td>

                        <td>
                            <div align="left">
                                <?php echo htmlspecialchars($objResult['pre_name'] . $objResult['billing_name'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($sale_channel_name, ENT_QUOTES, 'UTF-8'); ?>
                        </td>

                        <td>
                            <span class="badge-status <?php echo htmlspecialchars($status_class, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($status_text, ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </td>

                        <td style="text-align:center; position:relative;">
                            <div class="so-dropdown">
                                <button
                                    type="button"
                                    class="so-dropdown-trigger"
                                    aria-label="ตัวเลือกเพิ่มเติม"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)"
                                >
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>

                                <div id="<?php echo htmlspecialchars($dropdown_id, ENT_QUOTES, 'UTF-8'); ?>" class="so-dropdown-menu">

                                    <?php if ($objResult['approve_complete'] === 'Approve') { ?>
                                        <a href="register_admin_edit.php?ref_id=<?php echo $ref_id_url; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
												<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
											</a>


                                    <?php } ?>

                                 

                                        <a href="register_admin_edit.php?copy_from=<?php echo $ref_id_url; ?>" onclick="return confirmNav(event, this, 'ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')" class="so-dropdown-item">
												<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
											</a>

                                        <?php if (!empty($rs5['ref_credit'])) { ?>
                                            <a
                                                href="report_credit_adm.php?ref_credit=<?php echo urlencode($rs5['ref_credit']); ?>"
                                                class="so-dropdown-item"
                                            >
                                                <i class="fas fa-print" style="width:16px;"></i> พิมพ์ใบลดหนี้
                                            </a>
                                        <?php } else { ?>
                                            <a
                                                href="javascript:void(0);"
                                                class="so-dropdown-item"
                                                onclick="event.stopPropagation(); confirmGo('ต้องการสร้างใบสั่งลดหนี้ใช่หรือไม่', 'register_creditsol.php?ref_id=<?php echo urlencode($objResult['ref_id']); ?>')"
                                            >
                                                <i class="fas fa-file-invoice-dollar" style="width:16px;"></i> สร้างใบลดหนี้
                                            </a>
                                        <?php } ?>

                                        <?php
                                        if ($objResult['bill_vat'] == '1' && $objResult['status_vat'] === 'Approve') {
                                            if ($objResult['select_type_doc'] == '1' || $objResult['select_type_doc'] == '3') {
                                        ?>
                                                <a
                                                    href="report_vat.php?ref_id=<?php echo urlencode($objResult['ref_id']); ?>&code=<?php echo urlencode($_SESSION['code']); ?>"
                                                    class="so-dropdown-item"
                                                >
                                                    <i class="fas fa-file-invoice-dollar" style="width:16px;"></i> ใบกำกับภาษี ET/IE
                                                    
                                                </a>
                                        <?php
                                            } elseif ($objResult['select_type_doc'] == '2' || $objResult['select_type_doc'] == '4') {
                                        ?>
                                                <a
                                                    href="report_vatnbm1.php?ref_id=<?php echo urlencode($objResult['ref_id']); ?>&code=<?php echo urlencode($_SESSION['code']); ?>"
                                                    class="so-dropdown-item"
                                                >
                                                    <i class="fas fa-file-invoice-dollar" style="width:16px;"></i> ใบกำกับภาษี ET/IE
                                                   
                                                </a>
                                        <?php
                                            }
                                        }
                                        ?>

                                        <a href="register_receivepro_so.php?ref_id=<?php echo urlencode($objResult['ref_id']); ?>" onclick="return confirmNav(event, this, 'ต้องการสร้างใบส่งสินค้าใช่หรือไม่')" class="so-dropdown-item">
													<i class="fas fa-truck" style="width:16px;"></i> สร้างใบส่งสินค้า
												</a>

                                        <a
                                            href="javascript:void(0);"
                                            class="so-dropdown-item"
                                            onclick="event.stopPropagation(); confirmGo('ต้องการคืนสินค้าใช่หรือไม่', 'register_clear_ecom.php?ref_id=<?php echo urlencode($objResult['ref_id']); ?>')"
                                        >
                                            <i class="fas fa-rotate-left" style="width:16px;"></i> สร้างใบคืนสินค้า
                                        </a>

                                        <?php if ($objResult['smp_ckk'] == '0') { ?>
                                            <a
                                                href="javascript:void(0);"
                                                class="so-dropdown-item"
                                                onclick="event.stopPropagation(); confirmGo('ต้องการเปิดเอกสาร SMP รีวิวสินค้าใช่หรือไม่', 'main_admin_smp.php?ref_id=<?php echo urlencode($objResult['ref_id']); ?>')"
                                            >
                                                <i class="fas fa-star" style="width:16px;"></i> SMP รีวิวสินค้า
                                            </a>
                                        <?php } elseif ($objResult['smp_ckk'] == '1' && !empty($rs12['ref_idsmp'])) { ?>
                                            <a
                                                href="report_sample_ad.php?ref_idsmp=<?php echo urlencode($rs12['ref_idsmp']); ?>"
                                                class="so-dropdown-item"
                                            >
                                                <i class="fas fa-print" style="width:16px;"></i>SMP รีวิวสินค้า
                                            </a>
                                        <?php } ?>

                                   

                                </div>
                            </div>
                        </td>

                    </tr>

                    <!-- =================================================
                         EXPANDED ROW
                    ================================================== -->
                    <tr
                        id="<?php echo htmlspecialchars($row_id, ENT_QUOTES, 'UTF-8'); ?>"
                        class="expanded-row"
                        style="display:none;"
                    >
                        <td colspan="11">
                            <div class="expanded-container" style="display:block;">

                                <!-- PRODUCT TABLE -->
                                <div class="expanded-products-card">
                                    <table class="sub-table">
                                        <thead>
                                            <tr>
                                                <th width="52%" style="text-align:left !important;">รายการสินค้า</th>
                                                <th width="9%" style="text-align:center !important;">จำนวน</th>
                                                <th width="13%" style="text-align:right !important;">ราคา/หน่วย</th>
                                                <th width="13%" style="text-align:right !important;">ส่วนลด/หน่วย</th>
                                                <th width="13%" style="text-align:right !important;">ยอดรวม/สินค้า</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        $productRows = $productsByRef[$ref_id] ?? [];
                                        $subRowsCount = count($productRows);

                                        if ($subRowsCount > 0) {
                                            $grand_total = 0;

                                            foreach ($productRows as $subResult) {
                                                    $item_name = !empty($subResult['sol_name']) ? $subResult['sol_name'] : '-';

                                                    // รองรับชื่อ field ที่พบใน so__submain หลายเวอร์ชัน
                                                   $qty = isset($subResult['sale_count'])
    ? (float)$subResult['sale_count']
    : 0;

$price = isset($subResult['price_per_unit'])
    ? (float)$subResult['price_per_unit']
    : 0;

$discount = isset($subResult['discount_unit'])
    ? (float)$subResult['discount_unit']
    : 0;

$sum_amount = isset($subResult['sum_amount'])
    ? (float)$subResult['sum_amount']
    : 0;

$grand_total += $sum_amount;
                                        ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($item_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td style="text-align:center;">
                                                            <?php echo number_format($qty, ($qty == floor($qty) ? 0 : 2)); ?>
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <?php echo number_format($price, 2); ?>
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <?php echo number_format($discount, 2); ?>
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <?php echo number_format($sum_amount, 2); ?>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                        ?>
                                                <tr class="total-row">
                                                    <td colspan="4" style="text-align:right;">ยอดรวม</td>
                                                    <td class="total-amount" style="text-align:right;">
                                                        <?php echo number_format($grand_total, 2); ?>
                                                    </td>
                                                </tr>
                                        <?php
                                        } else {
                                        ?>
                                                <tr>
                                                    <td colspan="5" style="text-align:center; color:#8E8B94; padding:20px;">
                                                        ไม่มีข้อมูลรายการสินค้า
                                                    </td>
                                                </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </td>
                    </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>

        <!-- =====================================================
             PAGINATION
        ====================================================== -->
        <div class="pagination-wrapper">

            <div>
                แสดง
                <?php echo ($Num_Rows > 0 ? $Page_Start + 1 : 0); ?>
                ถึง
                <?php echo min($Page_Start + $Per_Page, $Num_Rows); ?>
                จาก
                <?php echo $Num_Rows; ?>
                รายการ
            </div>

            <div class="pagination-links">
                <?php
                $pagParams =
                    "&Keyword=" . urlencode($Keyword) .
                    "&start_date=" . urlencode($start_date) .
                    "&end_date=" . urlencode($end_date) .
                    "&Keyword1=" . urlencode($Keyword1) .
                    "&Keyword2=" . urlencode($Keyword2) .
                    "&sale_channel=" . urlencode($sale_channel);

                if ($Prev_Page >= 1) {
                    echo "<a class='pagination-btn' href='" . htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8') . "?Page=$Prev_Page$pagParams'><i class='fas fa-chevron-left'></i></a>";
                }

                $start_p = max(1, $Page - 3);
                $end_p = min($Num_Pages, $Page + 3);

                if ($start_p > 1) {
                    echo "<a class='pagination-btn' href='" . htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8') . "?Page=1$pagParams'>1</a>";
                    if ($start_p > 2) {
                        echo "<span style='padding:4px;'>...</span>";
                    }
                }

                for ($p = $start_p; $p <= $end_p; $p++) {
                    $activeClass = ($p == $Page) ? 'active' : '';
                    echo "<a class='pagination-btn $activeClass' href='" . htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8') . "?Page=$p$pagParams'>$p</a>";
                }

                if ($end_p < $Num_Pages) {
                    if ($end_p < $Num_Pages - 1) {
                        echo "<span style='padding:4px;'>...</span>";
                    }
                    echo "<a class='pagination-btn' href='" . htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8') . "?Page=$Num_Pages$pagParams'>$Num_Pages</a>";
                }

                if ($Page < $Num_Pages) {
                    echo "<a class='pagination-btn' href='" . htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8') . "?Page=$Next_Page$pagParams'><i class='fas fa-chevron-right'></i></a>";
                }
                ?>
            </div>

        </div>

    </div>
</div>

<div id="cr_bar">
    <?php include "foot.php"; ?>
</div>

<script>
function toggleRow(rowId, triggerEl) {
    const row = document.getElementById(rowId);
    if (!row) return;

    const isVisible = row.style.display !== 'none';

    document.querySelectorAll('.expanded-row').forEach(function(r) {
        if (r.id !== rowId) {
            r.style.display = 'none';
        }
    });

    document.querySelectorAll('.so-row').forEach(function(r) {
        if (r !== triggerEl) {
            r.classList.remove('is-expanded');
            r.setAttribute('aria-expanded', 'false');
        }
    });

    if (isVisible) {
        row.style.display = 'none';
        triggerEl.classList.remove('is-expanded');
        triggerEl.setAttribute('aria-expanded', 'false');
    } else {
        row.style.display = 'table-row';
        triggerEl.classList.add('is-expanded');
        triggerEl.setAttribute('aria-expanded', 'true');
    }
}

document.addEventListener('keydown', function(event) {
    if ((event.key === 'Enter' || event.key === ' ') && event.target.classList && event.target.classList.contains('so-row')) {
        event.preventDefault();
        event.target.click();
    }
});

function toggleDropdown(event, dropdownId) {
    event.stopPropagation();

    const trigger = event.currentTarget;
    const menu = document.getElementById(dropdownId);
    if (!menu) return;

    const isCurrentlyOpen = menu.classList.contains('show');

    document.querySelectorAll('.so-dropdown-menu').forEach(function(m) {
        m.classList.remove('show');
    });
    document.querySelectorAll('.so-dropdown-trigger').forEach(function(t) {
        t.setAttribute('aria-expanded', 'false');
    });

    if (!isCurrentlyOpen) {
        menu.classList.add('show');
        trigger.setAttribute('aria-expanded', 'true');

        const rect = trigger.getBoundingClientRect();
        menu.style.display = 'block';
        const menuWidth = menu.offsetWidth || 186;
        const menuHeight = menu.offsetHeight || 280;
        menu.style.display = '';

        const spaceBelow = window.innerHeight - rect.bottom;
        menu.style.position = 'fixed';
        menu.style.zIndex = '99999';

        let left = rect.right - menuWidth;
        if (left < 10) left = 10;
        if (left + menuWidth > window.innerWidth - 10) {
            left = window.innerWidth - menuWidth - 10;
        }
        menu.style.left = left + 'px';

        if (spaceBelow < menuHeight + 10 && rect.top > menuHeight) {
            menu.style.top = (rect.top - menuHeight - 4) + 'px';
        } else {
            menu.style.top = (rect.bottom + 4) + 'px';
        }
    }
}

function confirmGo(message, url) {
    document.querySelectorAll('.so-dropdown-menu').forEach(function(m) {
        m.classList.remove('show');
    });
    document.querySelectorAll('.so-dropdown-trigger').forEach(function(t) {
        t.setAttribute('aria-expanded', 'false');
    });

    Swal.fire({
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#612989',
        cancelButtonColor: '#8a8a8a',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then(function(result) {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

document.addEventListener('click', function(event) {
    if (!event.target.closest('.so-dropdown')) {
        document.querySelectorAll('.so-dropdown-menu').forEach(function(m) {
            m.classList.remove('show');
        });
        document.querySelectorAll('.so-dropdown-trigger').forEach(function(t) {
            t.setAttribute('aria-expanded', 'false');
        });
    }
});

window.addEventListener('scroll', function() {
    document.querySelectorAll('.so-dropdown-menu.show').forEach(function(m) {
        m.classList.remove('show');
    });
    document.querySelectorAll('.so-dropdown-trigger').forEach(function(t) {
        t.setAttribute('aria-expanded', 'false');
    });
}, true);

function openFilterModal() {
    document.getElementById('filterModal').style.display = 'block';
    const first = document.getElementById('start_date');
    if (first) first.focus();
}

function closeFilterModal() {
    document.getElementById('filterModal').style.display = 'none';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && document.getElementById('filterModal').style.display === 'block') {
        closeFilterModal();
    }
});

function resetFilters() {
    ['start_date', 'end_date', 'Keyword1', 'Keyword2', 'sale_channel'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    const keyword = document.getElementById('Keyword');
    if (keyword) keyword.value = '';
    document.forms['frmSearch'].submit();
}

window.addEventListener('click', function(event) {
    const modal = document.getElementById('filterModal');
    if (event.target === modal) {
        closeFilterModal();
    }
});
</script>

</body>
</html>
