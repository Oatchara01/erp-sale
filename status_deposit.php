<?php
include('head.php');
include "dbconnect.php";

date_default_timezone_set("Asia/Bangkok");

// =========================================================
// รับค่าค้นหา
// =========================================================

$Keyword = isset($_GET['Keyword'])
    ? trim($_GET['Keyword'])
    : '';

$start_date = isset($_GET['start_date'])
    ? trim($_GET['start_date'])
    : '';

$end_date = isset($_GET['end_date'])
    ? trim($_GET['end_date'])
    : '';


// =========================================================
// Escape
// =========================================================

$Keyword_safe = mysqli_real_escape_string(
    $conn,
    $Keyword
);

$start_date_safe = mysqli_real_escape_string(
    $conn,
    $start_date
);

$end_date_safe = mysqli_real_escape_string(
    $conn,
    $end_date
);


// =========================================================
// Query หลัก
// =========================================================

$strSQL = "
    SELECT *
    FROM tb_deposit
    WHERE 1
";


// ---------------------------------------------------------
// วันที่เริ่มต้น
// ---------------------------------------------------------

if ($start_date != '') {

    $strSQL .= "
        AND bill_date >= '$start_date_safe'
    ";
}


// ---------------------------------------------------------
// วันที่สิ้นสุด
// ---------------------------------------------------------

if ($end_date != '') {

    $strSQL .= "
        AND bill_date <= '$end_date_safe'
    ";
}


// ---------------------------------------------------------
// ค้นหา
// ---------------------------------------------------------

if ($Keyword != '') {

    $strSQL .= "
        AND (
            deposit_code LIKE '%$Keyword_safe%'
            OR iv_no LIKE '%$Keyword_safe%'
            OR bill_name LIKE '%$Keyword_safe%'
            OR bill_tel LIKE '%$Keyword_safe%'
            OR delivery_name LIKE '%$Keyword_safe%'
            OR customer_contact LIKE '%$Keyword_safe%'
            OR product_name1 LIKE '%$Keyword_safe%'
            OR product_name2 LIKE '%$Keyword_safe%'
            OR product_name3 LIKE '%$Keyword_safe%'
            OR product_name4 LIKE '%$Keyword_safe%'
            OR product_name5 LIKE '%$Keyword_safe%'
        )
    ";
}


// =========================================================
// นับจำนวนทั้งหมด
// =========================================================

$objQueryCount = mysqli_query(
    $conn,
    $strSQL
) or die(
    "Error Query [" .
    htmlspecialchars(mysqli_error($conn)) .
    "]"
);

$Num_Rows = mysqli_num_rows(
    $objQueryCount
);


// =========================================================
// Pagination
// =========================================================

$Per_Page = 30;

$Page = isset($_GET['Page'])
    ? max(1, (int)$_GET['Page'])
    : 1;

$Prev_Page = $Page - 1;
$Next_Page = $Page + 1;

$Page_Start =
    ($Per_Page * $Page) - $Per_Page;


if ($Num_Rows <= $Per_Page) {

    $Num_Pages = 1;

} elseif (($Num_Rows % $Per_Page) == 0) {

    $Num_Pages =
        (int)($Num_Rows / $Per_Page);

} else {

    $Num_Pages =
        (int)ceil(
            $Num_Rows / $Per_Page
        );
}


// ป้องกันกรณี Page มากกว่าจำนวนหน้าจริง
if (
    $Page > $Num_Pages &&
    $Num_Rows > 0
) {

    $Page = $Num_Pages;

    $Page_Start =
        ($Per_Page * $Page)
        - $Per_Page;

    $Prev_Page =
        $Page - 1;

    $Next_Page =
        $Page + 1;
}


// =========================================================
// Query ข้อมูลจริง
// =========================================================

$strSQL .= "
    ORDER BY deposit_code DESC
    LIMIT $Page_Start, $Per_Page
";

$objQuery =
    mysqli_query(
        $conn,
        $strSQL
    );

if (!$objQuery) {

    die(
        "Error Query [" .
        htmlspecialchars(
            mysqli_error($conn)
        ) .
        "]"
    );
}

$Page_Num_Rows =
    mysqli_num_rows(
        $objQuery
    );

?>

<link
    rel="stylesheet"
    href="css/so-status-ui.css"
>

<body>

<script>

(function() {

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


<div class="status-so-page">

    <div class="so-card">


        <!-- =====================================================
             HEADER
        ====================================================== -->

        <div
            class="w3-container w3-bar w3-margin-bottom"
            style="
                padding-left:0;
                padding-right:0;
            "
        >

            <h4 style="margin:0;">

                รายการใบเงินมัดจำ

            </h4>

        </div>


        <!-- =====================================================
             SEARCH / FILTER
        ====================================================== -->

        <form
            name="frmSearch"
            method="GET"
            action="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>"
        >

            <div
                class="so-input-group"
                style="
                    align-items:flex-end;
                    margin-bottom:20px;
                "
            >

                <div
                    style="
                        flex:1;
                        max-width:680px;
                        min-width:250px;
                        display:flex;
                        flex-direction:column;
                        gap:6px;
                    "
                >

                    <label
                        for="Keyword"
                        style="
                            font-size:14px;
                            color:#612989;
                            font-weight:500;
                        "
                    >

                        ค้นหาเลขที่เอกสาร /
                        ชื่อลูกค้า /
                        เบอร์โทร

                    </label>


                    <div
                        style="
                            display:flex;
                            gap:12px;
                            align-items:center;
                        "
                    >

                        <div
                            class="so-search-wrapper"
                            style="
                                flex:1;
                                width:auto;
                            "
                        >

                            <i
                                class="fas fa-search so-search-icon"
                            ></i>

                            <input
                                name="Keyword"
                                id="Keyword"
                                class="so-input"
                                type="text"
                                placeholder="ค้นหา..."
                                value="<?php
                                    echo htmlspecialchars(
                                        $Keyword,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                ?>"
                            >

                        </div>
<a href="register_deposit.php" class="btn-so-outline" style="flex-shrink: 0; font-weight: 500;">
								<img src="img/icons/add_message.png" alt=""> เพิ่มใบรับเงินมัดจำ
							</a>
                    </div>

                </div>


                <button
                    type="button"
                    class="btn-so-secondary"
                    id="filterBtn"
                    onclick="openFilterModal()"
                >

                    <i class="fas fa-filter"></i>

                    Filters

                    <span
                        id="filterBadge"
                        style="
                            display:none;
                            background:#612989;
                            color:#fff;
                            border-radius:50%;
                            width:20px;
                            height:20px;
                            font-size:11px;
                            line-height:20px;
                            text-align:center;
                            margin-left:6px;
                            font-weight:700;
                            vertical-align:middle;
                        "
                    ></span>

                </button>

            </div>



            <!-- =================================================
                 FILTER MODAL
            ================================================== -->

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
                    style="
                        border-radius:16px;
                        max-width:680px;
                    "
                >

                    <div
                        class="w3-container"
                        style="padding:32px;"
                    >

                        <div
                            class="so-modal-header"
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
                                aria-label="ปิด"
                                style="
                                    background:none;
                                    border:none;
                                    font-size:28px;
                                    cursor:pointer;
                                    color:#8E8B94;
                                    line-height:1;
                                    padding:0;
                                "
                            >

                                &times;

                            </button>

                        </div>



                        <!-- วันที่ -->

                        <div
                            class="so-form-row"
                        >

                            <div>

                                <label
                                    class="so-label"
                                    for="start_date"
                                >

                                    ตั้งแต่วันที่

                                </label>

                                <input
                                    type="date"
                                    name="start_date"
                                    id="start_date"
                                    class="so-select so-modal-input"
                                    value="<?php
                                        echo htmlspecialchars(
                                            $start_date,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
                                >

                            </div>


                            <div>

                                <label
                                    class="so-label"
                                    for="end_date"
                                >

                                    ถึงวันที่

                                </label>

                                <input
                                    type="date"
                                    name="end_date"
                                    id="end_date"
                                    class="so-select so-modal-input"
                                    value="<?php
                                        echo htmlspecialchars(
                                            $end_date,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
                                >

                            </div>

                        </div>



                        <div
                            class="so-modal-footer"
                        >

                            <button
                                type="submit"
                                class="btn-filter-submit"
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
                                    style="
                                        margin-right:6px;
                                    "
                                ></i>

                                รีเซ็ต

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </form>



        <!-- =====================================================
             TABLE
        ====================================================== -->

        <div class="so-table-wrapper so-table-wrapper--fit">

            <table class="so-table so-table-fit">

                <thead>

                    <tr>

                        <th width="3%"></th>

                        <th
                            style="
                                white-space:nowrap;
                            "
                        >
                            เลขที่อ้างอิง
                        </th>

                        <th
                            style="
                                white-space:nowrap;
                            "
                        >
                            วันที่
                        </th>

                        <th
                            style="
                                white-space:nowrap;
                            "
                        >
                            เลขที่
                        </th>

                        <th
                            style="
                                white-space:nowrap;
                            "
                        >
                            ชื่อลูกค้า
                        </th>

                        <th
                            style="
                                white-space:nowrap;
                            "
                        >
                            เบอร์โทร
                        </th>

                        <th
                            style="
                                white-space:nowrap;
                            "
                        >
                            ผู้ติดต่อ
                        </th>

                        <th
                            style="
                                white-space:nowrap;
                                width:10%;
                            "
                        >
                            สถานะ
                        </th>

                        <th
                            width="5%"
                            style="
                                text-align:center;
                            "
                        ></th>

                    </tr>

                </thead>


                <tbody>


                <?php if ($Page_Num_Rows == 0) { ?>

                    <tr>

                        <td
                            colspan="9"
                            style="
                                text-align:center;
                                padding:40px 16px;
                                color:#6B6875;
                            "
                        >

                            <?php

                            echo (
                                $Num_Rows > 0
                            )
                                ? 'ไม่พบข้อมูลในหน้านี้ — ลองกลับไปหน้าแรก'
                                : 'ไม่พบใบเงินมัดจำที่ตรงกับเงื่อนไข ลองล้างตัวกรองหรือเปลี่ยนคำค้น';

                            ?>

                        </td>

                    </tr>

                <?php } ?>



                <?php

                while (
                    $objResult =
                    mysqli_fetch_assoc(
                        $objQuery
                    )
                ) {


                    $deposit_code =
                        $objResult[
                            'deposit_code'
                        ];


                    $row_id =
                        "row-" .
                        preg_replace(
                            '/[^a-zA-Z0-9_-]/',
                            '-',
                            $deposit_code
                        );


                    $dropdown_id =
                        "dropdown-" .
                        preg_replace(
                            '/[^a-zA-Z0-9_-]/',
                            '-',
                            $deposit_code
                        );


                    $row_id_js =
                        htmlspecialchars(
                            json_encode(
                                $row_id
                            ),
                            ENT_QUOTES,
                            'UTF-8'
                        );


                    $dropdown_id_js =
                        htmlspecialchars(
                            json_encode(
                                $dropdown_id
                            ),
                            ENT_QUOTES,
                            'UTF-8'
                        );


                    // =============================================
                    // รวมรายการสินค้า
                    // =============================================

                    $products = [];


                    for ($p = 1; $p <= 5; $p++) {

                        $field =
                            "product_name" .
                            $p;

                        if (
                            !empty(
                                trim(
                                    $objResult[
                                        $field
                                    ] ?? ''
                                )
                            )
                        ) {

                            $products[] =
                                trim(
                                    $objResult[
                                        $field
                                    ]
                                );

                        }

                    }

                ?>


                    <!-- =========================================
                         MAIN ROW
                    ========================================== -->

                    <tr
                        class="so-row"
                        onclick="toggleRow(
                            <?php echo $row_id_js; ?>,
                            this
                        )"
                    >

                        <td
                            style="
                                text-align:center;
                            "
                        >

                            <img
                                src="img/icons/arrow_down.png"
                                class="caret-icon"
                                style="
                                    width:12px;
                                    height:12px;
                                "
                                alt=""
                            >

                        </td>


                        <td>

                            <a
                                href="register_deposit.php?deposit_code=<?php echo urlencode($deposit_code); ?>"
                                style="
                                    color:#612989;
                                    text-decoration:underline;
                                    font-weight:500;
                                "
                                onclick="event.stopPropagation();"
                            >

                                <?php

                                echo htmlspecialchars(
                                    $deposit_code
                                );

                                ?>

                            </a>

                        </td>


                        <td>

                            <?php

                            echo !empty(
                                $objResult[
                                    'bill_date'
                                ]
                            )
                                ? DateThai(
                                    $objResult[
                                        'bill_date'
                                    ]
                                )
                                : '-';

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $objResult[
                                    'iv_no'
                                ] ?? '-'
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $objResult[
                                    'bill_name'
                                ] ?? '-'
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $objResult[
                                    'bill_tel'
                                ] ?? '-'
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $objResult[
                                    'customer_contact'
                                ] ?? '-'
                            );

                            ?>

                        </td>


                        <td>

                            <span
                                class="badge-status pending-mgr"
                            >

                                กำลังดำเนินการ

                            </span>

                        </td>



                        <!-- =====================================
                             DROPDOWN
                        ====================================== -->

                        <td
                            style="
                                text-align:center;
                                position:relative;
                            "
                        >

                            <div
                                class="so-dropdown"
                            >

                                <button
                                    type="button"
                                    class="so-dropdown-trigger"
                                    aria-label="ตัวเลือกเพิ่มเติม"
                                    onclick="
                                        toggleDropdown(
                                            event,
                                            <?php echo $dropdown_id_js; ?>
                                        )
                                    "
                                >

                                    <i
                                        class="fas fa-ellipsis-v"
                                    ></i>

                                </button>


                                <div
                                    id="<?php
                                        echo htmlspecialchars(
                                            $dropdown_id
                                        );
                                    ?>"
                                    class="so-dropdown-menu"
                                >


                                    <?php
                                    if (
                                        $deposit_code != '1'
                                    ) {
                                    ?>


                                        <a
                                            href="register_deposit.php?deposit_code=<?php echo urlencode($deposit_code); ?>"
                                            class="so-dropdown-item"
                                        >

                                            <i
                                                class="fas fa-edit"
                                                style="
                                                    width:16px;
                                                "
                                            ></i>

                                            แก้ไข

                                        </a>


                                        <!--a
                                            href="register_so_allwell.php?deposit_code=<?php echo urlencode($deposit_code); ?>"
                                            class="so-dropdown-item"
                                        >

                                            <i
                                                class="fas fa-file-invoice"
                                                style="
                                                    width:16px;
                                                "
                                            ></i>

                                            สร้างใบสั่งขาย

                                        </a-->


                                    <?php } ?>


                                    <a
                                        href="report_deposit.php?deposit_code=<?php echo urlencode($deposit_code); ?>"
                                        class="so-dropdown-item"
                                        target="_blank"
                                    >

                                        <i
                                            class="fas fa-print"
                                            style="
                                                width:16px;
                                            "
                                        ></i>

                                        พิมพ์รายงาน

                                    </a>


                                </div>

                            </div>

                        </td>

                    </tr>



                    <!-- =========================================
                         EXPANDED ROW
                    ========================================== -->

                    <tr
                        id="<?php
                            echo htmlspecialchars(
                                $row_id
                            );
                        ?>"
                        class="expanded-row"
                        style="display:none;"
                    >

                        <td colspan="9">

                            <div
                                class="expanded-container"
                            >


                                <div
                                    class="expanded-products-card"
                                >

                                    <table
                                        class="sub-table"
                                    >

                                        <thead>

                                            <tr>

                                                <th>
                                                    รายการสินค้า
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>


                                        <?php

                                        if (
                                            count(
                                                $products
                                            ) > 0
                                        ) {

                                            foreach (
                                                $products
                                                as $product
                                            ) {

                                        ?>

                                            <tr>

                                                <td>

                                                    <?php

                                                    echo htmlspecialchars(
                                                        $product
                                                    );

                                                    ?>

                                                </td>

                                            </tr>

                                        <?php

                                            }

                                        } else {

                                        ?>

                                            <tr>

                                                <td
                                                    style="
                                                        text-align:center;
                                                        color:#8E8B94;
                                                        padding:20px;
                                                    "
                                                >

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

                <?php

                echo (
                    $Num_Rows > 0
                )
                    ? $Page_Start + 1
                    : 0;

                ?>

                ถึง

                <?php

                echo min(
                    $Page_Start +
                    $Per_Page,
                    $Num_Rows
                );

                ?>

                จาก

                <?php
                echo $Num_Rows;
                ?>

                รายการ

            </div>


            <div
                class="pagination-links"
            >

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
                    );


                // ---------------------------------------------
                // Previous
                // ---------------------------------------------

                if ($Prev_Page >= 1) {

                    echo "
                        <a
                            class='pagination-btn'
                            href='" .
                            htmlspecialchars(
                                $_SERVER[
                                    'SCRIPT_NAME'
                                ]
                            ) .
                            "?Page=" .
                            $Prev_Page .
                            $pagParams .
                            "'
                        >
                            <i class='fas fa-chevron-left'></i>
                        </a>
                    ";

                }


                // ---------------------------------------------
                // จำกัดจำนวนเลขหน้า
                // ---------------------------------------------

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


                if ($start_p > 1) {

                    echo "
                        <a
                            class='pagination-btn'
                            href='" .
                            htmlspecialchars(
                                $_SERVER[
                                    'SCRIPT_NAME'
                                ]
                            ) .
                            "?Page=1" .
                            $pagParams .
                            "'
                        >
                            1
                        </a>
                    ";


                    if (
                        $start_p > 2
                    ) {

                        echo "
                            <span
                                style='padding:4px;'
                            >
                                ...
                            </span>
                        ";

                    }

                }


                for (
                    $p = $start_p;
                    $p <= $end_p;
                    $p++
                ) {

                    $activeClass =
                        (
                            $p == $Page
                        )
                        ? 'active'
                        : '';


                    echo "
                        <a
                            class='pagination-btn " .
                            $activeClass .
                            "'
                            href='" .
                            htmlspecialchars(
                                $_SERVER[
                                    'SCRIPT_NAME'
                                ]
                            ) .
                            "?Page=" .
                            $p .
                            $pagParams .
                            "'
                        >
                            " .
                            $p .
                            "
                        </a>
                    ";

                }


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
                            href='" .
                            htmlspecialchars(
                                $_SERVER[
                                    'SCRIPT_NAME'
                                ]
                            ) .
                            "?Page=" .
                            $Num_Pages .
                            $pagParams .
                            "'
                        >
                            " .
                            $Num_Pages .
                            "
                        </a>
                    ";

                }


                // ---------------------------------------------
                // Next
                // ---------------------------------------------

                if (
                    $Page <
                    $Num_Pages
                ) {

                    echo "
                        <a
                            class='pagination-btn'
                            href='" .
                            htmlspecialchars(
                                $_SERVER[
                                    'SCRIPT_NAME'
                                ]
                            ) .
                            "?Page=" .
                            $Next_Page .
                            $pagParams .
                            "'
                        >
                            <i class='fas fa-chevron-right'></i>
                        </a>
                    ";

                }

                ?>

            </div>

        </div>


    </div>

</div>



<!-- =========================================================
     JAVASCRIPT
========================================================== -->

<script>


// =========================================================
// EXPAND ROW
// =========================================================

function toggleRow(
    rowKey,
    triggerEl
) {

    const row =
        document.getElementById(
            rowKey
        );

    if (!row) {

        console.error(
            'ไม่พบ expanded row:',
            rowKey
        );

        return;

    }


    const isVisible =
        row.style.display ===
        'table-row';


    // ปิดแถวอื่น
    document
        .querySelectorAll(
            '.expanded-row'
        )
        .forEach(
            function(r) {

                if (
                    r !== row
                ) {

                    r.style.display =
                        'none';

                }

            }
        );


    // เอา expanded ของแถวอื่นออก
    document
        .querySelectorAll(
            '.so-row'
        )
        .forEach(
            function(r) {

                if (
                    r !== triggerEl
                ) {

                    r.classList.remove(
                        'is-expanded'
                    );

                }

            }
        );


    // เปิด / ปิด
    if (isVisible) {

        row.style.display =
            'none';

        triggerEl
            .classList
            .remove(
                'is-expanded'
            );

    } else {

        row.style.display =
            'table-row';

        triggerEl
            .classList
            .add(
                'is-expanded'
            );

    }

}



// =========================================================
// DROPDOWN
// =========================================================

function toggleDropdown(
    event,
    dropdownId
) {

    event.stopPropagation();


    const menu =
        document.getElementById(
            dropdownId
        );


    document
        .querySelectorAll(
            '.so-dropdown-menu'
        )
        .forEach(
            function(m) {

                if (
                    m !== menu
                ) {

                    m.classList.remove(
                        'show'
                    );

                }

            }
        );


    if (!menu) {
        return;
    }


    const isShowing =
        menu.classList.contains(
            'show'
        );


    if (!isShowing) {

        const trigger =
            event.currentTarget;

        const rect =
            trigger
                .getBoundingClientRect();


        menu.style.position =
            'fixed';


        menu.style.display =
            'block';


        const menuWidth =
            menu.offsetWidth ||
            186;


        menu.style.display =
            '';


        const top =
            rect.bottom;


        let left =
            rect.right -
            menuWidth;


        if (left < 10) {

            left = 10;

        }


        if (
            left +
            menuWidth >
            window.innerWidth - 10
        ) {

            left =
                window.innerWidth -
                menuWidth -
                10;

        }


        menu.style.top =
            top + 'px';

        menu.style.left =
            left + 'px';

    }


    menu.classList.toggle(
        'show'
    );

}



// =========================================================
// CLICK OUTSIDE DROPDOWN
// =========================================================

document.addEventListener(
    'click',
    function(event) {

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
                    function(m) {

                        m.classList.remove(
                            'show'
                        );

                    }
                );

        }

    }
);



// =========================================================
// SCROLL
// =========================================================

window.addEventListener(
    'scroll',
    function() {

        document
            .querySelectorAll(
                '.so-dropdown-menu'
            )
            .forEach(
                function(m) {

                    m.classList.remove(
                        'show'
                    );

                }
            );

    },
    true
);



// =========================================================
// FILTER MODAL
// =========================================================

function openFilterModal() {

    document
        .getElementById(
            'filterModal'
        )
        .style
        .display =
        'block';

}


function closeFilterModal() {

    document
        .getElementById(
            'filterModal'
        )
        .style
        .display =
        'none';

}



// =========================================================
// RESET FILTER
// =========================================================

function resetFilters() {

    const startDate =
        document.getElementById(
            'start_date'
        );

    const endDate =
        document.getElementById(
            'end_date'
        );

    const keyword =
        document.getElementById(
            'Keyword'
        );


    if (startDate) {

        startDate.value = '';

    }


    if (endDate) {

        endDate.value = '';

    }


    if (keyword) {

        keyword.value = '';

    }


    document
        .forms[
            'frmSearch'
        ]
        .submit();

}



// =========================================================
// FILTER BADGE
// =========================================================

function updateFilterBadge() {

    const fields = [
        'start_date',
        'end_date'
    ];


    const count =
        fields.filter(
            function(id) {

                const el =
                    document.getElementById(
                        id
                    );

                return (
                    el &&
                    el.value !== ''
                );

            }
        ).length;


    const badge =
        document.getElementById(
            'filterBadge'
        );


    if (!badge) {
        return;
    }


    if (count > 0) {

        badge.textContent =
            count;

        badge.style.display =
            'inline-block';

    } else {

        badge.style.display =
            'none';

    }

}



// =========================================================
// ENTER SEARCH
// =========================================================

document
    .getElementById(
        'Keyword'
    )
    ?.addEventListener(
        'keydown',
        function(e) {

            if (
                e.key === 'Enter'
            ) {

                document
                    .forms[
                        'frmSearch'
                    ]
                    .submit();

            }

        }
    );



// =========================================================
// CLICK OUTSIDE FILTER
// =========================================================

window.addEventListener(
    'click',
    function(event) {

        const modal =
            document.getElementById(
                'filterModal'
            );

        if (
            event.target === modal
        ) {

            closeFilterModal();

        }

    }
);



// =========================================================
// INIT
// =========================================================

document.addEventListener(
    'DOMContentLoaded',
    function() {

        updateFilterBadge();

    }
);

</script>


<?php
include('foot.php');
?>

</body>

</html>