<?php
// ตารางสินค้าชุดเดียวใช้ได้หลายเอกสาร — หน้าที่ include ตั้ง $productTableContext ก่อน include
//   'so' (ค่าเริ่มต้น) = ใบสั่งขาย: popup ครบทุกช่อง (PM ครั้ง/ปี, ใบจอง, ใบยืม, SN)
//   'po' = ใบ PO (register_poawl.php): popup เฉพาะ รับประกัน / CAL / PM(ปี) / หมายเหตุสินค้า ไม่บังคับกรอก
$productTableContext = (isset($productTableContext) && $productTableContext === 'po') ? 'po' : 'so';
$productTableIsPo = ($productTableContext === 'po');
// $productTableWarrantyBySn = true (register_suphos.php): บังคับรับประกันเฉพาะแถวที่มีเลขที่ SN และต้องเป็นตัวเลขมากกว่า 0
//   ไม่ตั้ง = พฤติกรรมเดิมของใบสั่งขาย: บังคับกรอกรับประกันทุกแถว
$productTableWarrantyBySn = !$productTableIsPo && !empty($productTableWarrantyBySn);
?>
<html>

<head>
    <link rel="stylesheet" href="css/autocomplete.css" type="text/css" />
    <script type="text/javascript" src="js/autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript">
        if (typeof Swal === 'undefined') {
            var script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
            document.head.appendChild(script);
        }
    </script>
    <style>
        /* Custom SweetAlert2 Delete Popup (Figma style 648x319) */
        .figma-delete-popup {
            width: min(525px, 94vw) !important;
            min-height: 319px !important;
            padding: 40px 32px 32px !important;
            border-radius: 24px !important;
            font-family: 'Prompt', 'Inter', sans-serif !important;
            box-sizing: border-box !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .figma-delete-icon {
            border: none !important;
            margin: 0 auto 20px !important;
            width: 80px !important;
            height: 80px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .figma-delete-title {
            font-size: 22px !important;
            font-weight: 600 !important;
            color: #1C1B1F !important;
            margin: 0 0 10px 0 !important;
            padding: 0 !important;
        }

        .figma-delete-html {
            font-size: 15px !important;
            color: #8E8B94 !important;
            line-height: 1.5 !important;
        }

        .figma-delete-actions {
            display: flex !important;
            gap: 16px !important;
            justify-content: center !important;
            width: 100% !important;
            max-width: 320px !important;
            margin: 0 auto !important;
        }

        .figma-delete-confirm-btn {
            flex: 1 !important;
            height: 44px !important;
            border-radius: 22px !important;
            border: none !important;
            background-color: #EF5350 !important;
            /* Figma Red */
            color: #ffffff !important;
            font-family: 'Prompt', 'Inter', sans-serif !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            box-shadow: 0 4px 10px rgba(239, 83, 80, 0.2) !important;
            transition: background-color 0.2s, transform 0.1s !important;
        }

        .figma-delete-confirm-btn:hover {
            background-color: #e53935 !important;
        }

        .figma-delete-confirm-btn:active {
            transform: scale(0.98) !important;
        }

        .figma-delete-cancel-btn {
            flex: 1 !important;
            height: 44px !important;
            border-radius: 22px !important;
            border: 1px solid #EDE9F0 !important;
            background-color: #F5F6F8 !important;
            color: #3b3b3b !important;
            font-family: 'Prompt', 'Inter', sans-serif !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            transition: background-color 0.2s, transform 0.1s !important;
        }

        .figma-delete-cancel-btn:hover {
            background-color: #e8e9eb !important;
            color: #1c1b1f !important;
        }

        .figma-delete-cancel-btn:active {
            transform: scale(0.98) !important;
        }
    </style>
</head>

<script type="text/javascript">
    function ck_frm() {
        var ck = document.getElementById('ckk');
        if (ck.checked == true) {
            document.getElementById('frm_txt').style.display = "";
        } else {
            document.getElementById('frm_txt').style.display = "none";
        }

    }


    function ck_frm1() {
        var ck = document.getElementById('ckk1');
        if (ck.checked == true) {
            document.getElementById('frm_txt1').style.display = "";
        } else {
            document.getElementById('frm_txt1').style.display = "none";
        }

    }

    function ck_frm2() {
        var ck = document.getElementById('ckk2');
        if (ck.checked == true) {
            document.getElementById('frm_txt2').style.display = "";
        } else {
            document.getElementById('frm_txt2').style.display = "none";
        }

    }

    function ck_frm3() {
        var ck = document.getElementById('ckk3');
        if (ck.checked == true) {
            document.getElementById('frm_txt3').style.display = "";
        } else {
            document.getElementById('frm_txt3').style.display = "none";
        }

    }

    function ck_frm4() {
        var ck = document.getElementById('ckk4');
        if (ck.checked == true) {
            document.getElementById('frm_txt4').style.display = "";
        } else {
            document.getElementById('frm_txt4').style.display = "none";
        }

    }
</script>



<script language="JavaScript">
    var HttPRequest = false;

    function doCallAjax(product_code, product_id, product_name, unit_name, product_price, discount_unit, warranty) {
        HttPRequest = false;
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            HttPRequest = new XMLHttpRequest();

            if (HttPRequest.overrideMimeType) {
                HttPRequest.overrideMimeType('text/html');
            }
        } else if (window.ActiveXObject) { // IE
            try {
                HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!HttPRequest) {
            alert('Cannot create XMLHTTP instance');
            return false;
        }
        var url = 'data_product_hos1.php';
        var pmeters = "product_code=" + encodeURIComponent(document.getElementById(product_code).value) +
            "&type_company=" + encodeURIComponent(getSelectedTypeCompany()) +
            "&format=json";
        HttPRequest.open('POST', url, true);

        HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        HttPRequest.setRequestHeader("Content-length", pmeters.length);
        HttPRequest.setRequestHeader("Connection", "close");
        HttPRequest.send(pmeters);

        HttPRequest.onreadystatechange = function() {
            if (HttPRequest.readyState == 4) // Return Request
            {
                var myProduct = HttPRequest.responseText;

                if (myProduct.trim() != "") {
                    try {
                        var product = JSON.parse(myProduct);

                        if (product.found === false) {
                            alert('ไม่พบรหัสสินค้า "' + document.getElementById(product_code).value + '" ในระบบ กรุณาตรวจสอบรหัสสินค้าอีกครั้ง');
                            document.getElementById(product_code).value = '';
                            document.getElementById(product_id).value = '';
                            return;
                        }

                        document.getElementById(product_id).value = product.product_ID;

                        // แจ้งเตือนทันทีเมื่อสินค้านี้กำหนดให้ใช้ SN
                        // เงื่อนไขมาจาก tb_product.sn_ckk ที่ส่งกลับจาก data_product_hos1.php
                        if (String(product.sn_ckk || '0').trim() === '1') {
                            var warrantyNotice = 'สินค้ารายการนี้ต้องใส่ข้อมูลปีรับประกัน';

                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'กรุณาตรวจสอบ และใส่ข้อมูลปีรับประกันสินค้า',
                                    text: warrantyNotice,
                                    confirmButtonColor: '#612989',
                                    confirmButtonText: 'ตกลง'
                                });
                            } else {
                                alert(warrantyNotice);
                            }
                        }

                        // Set hidden input and label span for product_name
                        document.getElementById(product_name).value = product.sol_name;
                        var labelEl = document.getElementById(product_name.replace('product_name', 'product_name_label'));
                        if (labelEl) labelEl.textContent = product.sol_name;
                        document.getElementById(unit_name).value = product.unit_name;
                        document.getElementById(product_price).value = product.sol_price;
                        document.getElementById(discount_unit).value = product.discount;
                        document.getElementById(warranty).value = product.war_hc;

                        // Extract row index and set warranty unit
                        var rowIdx = parseInt(product_price.replace('product_price', ''));
                        var remarkInput = document.getElementById('remark_hc' + rowIdx);
                        if (remarkInput) {
                            remarkInput.value = product.remark_hc || '';
                        }
                        var unit = 'ปี';
                        if (product.vvv) {
                            var cleanVvv = product.vvv.trim();
                            var parts = cleanVvv.split(/\s+/);
                            if (parts.length > 1) {
                                unit = parts[parts.length - 1];
                            } else if (parts.length === 1 && isNaN(cleanVvv)) {
                                unit = cleanVvv;
                            }
                        }
                        var unitInput = document.getElementById('warranty_unit' + rowIdx);
                        if (unitInput) {
                            unitInput.value = unit;
                        }
                        if (!isNaN(rowIdx) && typeof updateRowTotal === 'function') {
                            var rowDeletedEl = document.getElementById('row_deleted' + rowIdx);
                            if (rowDeletedEl) rowDeletedEl.value = '0';
                            // หมายเหตุ: ไม่ล้าง deleted_subso_db_id/deleted_product_code ที่นี่
                            // เพราะแถวนี้อาจถูก reuse หลังลบสินค้าเดิมแล้วเลือกสินค้าใหม่ทันที
                            // ถ้าล้างทิ้ง คำสั่งลบของเดิมจะหายไป (ของเดิมค้างใน DB ไม่ถูกลบ)
                            // Format the price and discount fields
                            var priceEl = document.getElementById(product_price);
                            var discEl = document.getElementById(discount_unit);
                            if (typeof formatNumberInput === 'function') {
                                if (priceEl) formatNumberInput(priceEl);
                                if (discEl) formatNumberInput(discEl);
                            }
                            updateRowTotal(rowIdx);
                        }
                        if (typeof calculateSummary === 'function') {
                            calculateSummary();
                        }
                    } catch (e) {
                        console.error("Failed to parse JSON response:", e, myProduct);
                    }
                }
            }
        }
    }


    function chkNumber(ele, evt)

    {

        var keyCode = evt && (evt.which || evt.keyCode);
        if (!keyCode) return true;
        var vchar = String.fromCharCode(keyCode);
        if ((vchar < '0' || vchar > '9') && (vchar != '.')) return false;
        ele.onKeyPress = vchar;
    }
</script>
<script src="dist/jautocalc.js"></script>
</head>

<body>

    <style>
        /* New styles for the modern product list */
        .so-product-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .so-product-title-text {
            font-size: 20px;
            font-weight: 500;
            color: #3B3B3B;
        }

        .so-product-count {
            font-size: 14px;
            color: #8E8B94;
        }

        .so-product-summary {
            display: flex;
            justify-content: space-between;
            background-color: #F4F3F7;
            border-radius: 12px;
            padding: 16px 24px;
            margin-bottom: 24px;
            text-align: center;
        }

        .so-product-summary-col {
            flex: 1;
            border-right: 1px solid #D9D9D9;
        }

        .so-product-summary-col:last-child {
            border-right: none;
        }

        .so-product-table-wrap {
            max-width: 100%;
            overflow-x: auto;
        }

        /* กล่องแจ้งตอนยังไม่มีรายการสินค้า (สไตล์เดียวกับ .breg-empty-state ของ register_supsmp) */
        .so-product-empty-state {
            padding: 28px 16px;
            text-align: center;
            font-size: 14px;
            color: #8E8B94;
            background: #FAF9FC;
            border: 1px dashed #E3DCEA;
            border-radius: 10px;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .so-product-summary {
                flex-wrap: wrap;
                text-align: left;
                gap: 12px 0;
            }

            .so-product-summary-col {
                flex: 1 1 50%;
                border-right: none;
            }
        }

        @media (max-width: 480px) {
            .so-product-summary-col {
                flex: 1 1 100%;
                border-bottom: 1px solid #E5DFEC;
                padding-bottom: 10px;
            }

            .so-product-summary-col:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }
        }

        .so-summary-label {
            font-size: 16px;
            color: #8E8B94;
            margin-bottom: 8px;
        }

        .so-summary-value {
            font-size: 24px;
            font-weight: 400;
            color: #333333;
        }

        .so-summary-value-net {
            font-size: 28px;
            font-weight: 400;
            color: #612989;
        }

        .pf-search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #ffffff;
            border: 1px solid #EBEBEB;
            border-radius: 24px;
            height: 44px;
            padding: 0 16px;
            box-sizing: border-box;
            margin-bottom: 16px;
            width: 100%;
            max-width: 680px;
        }

        .pf-search-bar i {
            color: #A098AE;
            font-size: 16px;
        }

        .pf-search-bar input {
            border: none !important;
            outline: none !important;
            background: transparent !important;
            font-family: 'Prompt', sans-serif;
            font-size: 14px;
            color: #2D2533;
            width: 100%;
        }

        .so-product-row.dragging {
            opacity: 0.4;
        }

        .so-product-row.drag-over {
            border-top: 2px solid #612989;
        }

        .so-product-row.drag-over-after {
            border-bottom: 2px solid #612989;
        }

        body.row-dragging,
        body.row-dragging * {
            cursor: grabbing !important;
            user-select: none;
            -webkit-user-select: none;
        }

        .so-product-table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        .so-product-table th {
            color: #612989;
            font-weight: 600;
            font-size: 14px;
            text-align: left;
            padding: 12px 8px;
            border-top: 1px solid #612989;
            border-bottom: 1px solid #612989;
        }

        .so-product-table td {
            padding: 8px 4px;
            border-bottom: 1px solid #F0F0F0;
            vertical-align: middle;
        }

        .so-product-row {
            background-color: #FFFFFF;
        }

        .so-product-row.checked-row {
            background-color: #F4EFFF;
        }

        .so-pill-input {
            background-color: #F4F3F7;
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 16px;
            font-weight: 400;
            color: #333333;
            width: 100%;
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
            outline: none;
        }

        .so-transparent-input {
            background-color: transparent !important;
            border: none !important;
            font-size: 16px;
            font-weight: 300;
            color: #3B3B3B;
            width: 100%;
            outline: none;
            font-family: 'Prompt', sans-serif;
        }

        /* .so-transparent-input.product-code-input {
            color: #612989;
        } */

        .so-product-name-label {
            display: block;
            font-size: 16px;
            font-weight: 300;
            color: #3B3B3B;
            font-family: 'Prompt', sans-serif;
            line-height: 1.4;
            padding: 4px 0;
            word-break: break-word;
        }

        .so-transparent-input.calc-total {
            color: #333333;
            font-size: 16px;
            font-weight: 400;
        }

        .so-pill-input[readonly] {
            background-color: transparent;
        }

        .so-row-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #F4F3F7;
            outline: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .so-row-checkbox:checked {
            background-color: #612989;
        }

        .so-row-checkbox:checked::after {
            content: "\f00c";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: white;
            font-size: 10px;
        }

        .drag-handle {
            cursor: grab;
            color: #8E8B94;
            margin-right: 8px;
            padding: 6px 4px;
            /* ไม่ให้นิ้วที่ลากไอคอนไปเลื่อนหน้าจอ / เลือกข้อความ / เด้งเมนู callout ของ iOS */
            touch-action: none;
            user-select: none;
            -webkit-user-select: none;
            -webkit-touch-callout: none;
        }

        /* จอสัมผัส: ขยายพื้นที่กดให้ใช้นิ้วได้ง่าย */
        @media (pointer: coarse) {
            .drag-handle {
                padding: 12px 8px;
                font-size: 18px;
            }
        }

        /* ปุ่มไอคอนพื้นขาวมุมมน 34x34px (content-box: ขนาดไอคอน + padding = 34px) */
        .action-icon {
            box-sizing: content-box;
            padding: 9px;
            border-radius: 8px;
            background: #FFFFFF;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            margin-left: 8px;
            vertical-align: middle;
            transition: box-shadow 0.2s ease;
        }

        /* trash.svg สูง 18px — ลด padding แนวตั้งให้กล่องยังสูง 34px เท่า edit */
        .action-icon[src$="trash.svg"] {
            padding: 8px 9px;
        }

        .action-icon:hover {
            box-shadow: 0 2px 10px rgba(97, 41, 137, 0.28);
        }

        /* Modal Styling */
        .so-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(34, 23, 49, 0.18);
            z-index: 9999;
            display: none;
            align-items: flex-start;
            justify-content: center;
            padding: 32px 20px;
            box-sizing: border-box;
        }

        .so-modal-content {
            background: #FFF;
            border-radius: 16px;
            padding: 26px 32px 24px;
            width: 1100px;
            max-width: 100%;
            box-shadow: 0 12px 40px rgba(62, 26, 91, 0.12);
            border: 1px solid #F1EAF7;
        }

        .so-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid #E8E1F0;
        }

        .so-modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #3D3A42;
            margin: 0;
        }

        .so-modal-close {
            background: none;
            border: none;
            font-size: 30px;
            line-height: 1;
            cursor: pointer;
            color: #6E6678;
            padding: 0;
        }

        .so-modal-grid-6 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1.15fr 1.3fr 1.3fr;
            gap: 16px 24px;
            margin-bottom: 18px;
        }

        .so-modal-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 24px;
            margin-bottom: 10px;
        }

        /* popup ของใบ PO มีแค่ 3 ช่องตัวเลข + หมายเหตุเต็มแถว */
        .so-modal-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px 24px;
            margin-bottom: 18px;
        }

        .so-modal-grid-1 {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            margin-bottom: 10px;
        }

        .action-icon:focus-visible {
            outline: 2px solid rgba(97, 41, 137, 0.45);
            outline-offset: 2px;
            border-radius: 4px;
        }

        .so-modal-field label {
            display: block;
            font-size: 14px;
            color: #6A2E96;
            margin-bottom: 8px;
            font-weight: 400;
        }

        .so-modal-required {
            color: #E24B7A;
        }

        /* สไตล์กล่อง Tooltip สำหรับความเห็นประกอบ/ประกันสินค้า */
        .so-tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        /* ข้อความ Tooltip (ซ่อนเป็นค่าเริ่มต้น) */
        .so-tooltip .so-tooltiptext {
            display: none;
            visibility: hidden;
            width: 220px;
            max-width: 280px;
            background-color: #333333;
            color: #ffffff;
            text-align: left;
            border-radius: 8px;
            padding: 10px 12px;
            position: absolute;
            z-index: 1000;
            bottom: 125%;
            /* แสดงเหนือไอคอน */
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
            font-size: 12px;
            font-weight: normal;
            line-height: 1.4;
            pointer-events: none;
            /* เพื่อไม่ให้ขวางทิศทางเมาส์ */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            white-space: normal;
            /* รองรับการตัดคำยาวๆ */
        }

        /* ลูกศรชี้ลงของ Tooltip */
        .so-tooltip .so-tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -6px;
            border-width: 6px;
            border-style: solid;
            border-color: #333333 transparent transparent transparent;
        }

        /* แสดงผลเฉพาะเมื่อมีคลาส active */
        .so-tooltip.active .so-tooltiptext {
            display: block;
            visibility: visible;
            opacity: 1;
        }

        /* ปรับแต่งเพื่อรองรับการแสดงผลบนหน้าจอมือถือ (Responsive) */
        @media screen and (max-width: 768px) {
            .so-tooltip .so-tooltiptext {
                width: 180px;
                max-width: 70vw;
                /* จำกัดความกว้างไม่ให้ล้นหน้าจอมือถือ */
                font-size: 11px;
                padding: 8px 10px;
                bottom: 130%;
                /* ยกสูงขึ้นเล็กน้อยเพื่อหลบขอบ */
            }
        }

        .so-modal-input-wrap {
            position: relative;
        }

        .so-modal-field input[type="text"],
        .so-modal-field textarea {
            width: 100%;
            height: 42px;
            padding: 0 44px 0 16px;
            border-radius: 12px;
            border: 1px solid #EFEAF4;
            background: #F4F5F8;
            font-size: 13px;
            color: #4A4453;
            font-family: 'Prompt', sans-serif;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .so-modal-field textarea {
            resize: vertical;
            min-height: 42px;
            padding-top: 9px;
            padding-bottom: 9px;
        }

        .so-modal-field input[type="text"]::placeholder,
        .so-modal-field textarea::placeholder {
            color: #9C96A5;
        }

        .so-modal-field input[type="text"]:focus,
        .so-modal-field textarea:focus {
            border-color: #CBA8E1;
            box-shadow: 0 0 0 3px rgba(106, 46, 150, 0.08);
            background: #F8F7FB;
        }

        /* ฟิลด์บังคับใน popup ที่ยังไม่กรอก (saveEditModal) — สีเดียวกับ .so-field-invalid ใน css/so-core.css */
        .so-modal-field input[type="text"].so-field-invalid,
        .so-modal-field input[type="text"].so-field-invalid:focus {
            border-color: #DC3545;
            box-shadow: none;
            background: #FEECEB;
        }

        .so-modal-clear {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: none;
            background: transparent;
            color: #726C7B;
            font-size: 24px;
            line-height: 18px;
            cursor: pointer;
            padding: 0;
            display: none;
        }

        .so-modal-clear.is-visible {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .so-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-top: 44px;
        }

        .so-btn-primary {
            background: #612989;
            color: #FFF;
            border: none;
            padding: 0 34px;
            min-width: 174px;
            height: 42px;
            border-radius: 999px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Prompt';
            box-shadow: 0 6px 16px rgba(97, 41, 137, 0.22);
        }

        .so-btn-outline {
            background: #FFF;
            color: #4D4954;
            border: 1px solid #DED8E6;
            padding: 0 34px;
            min-width: 174px;
            height: 42px;
            border-radius: 999px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Prompt';
            box-shadow: 0 2px 8px rgba(51, 40, 69, 0.08);
        }

        .so-btn-primary:hover,
        .so-btn-outline:hover {
            opacity: 0.96;
        }

        @media (max-width: 1100px) {
            .so-modal-content {
                padding: 22px 20px;
            }

            .so-modal-grid-6 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .so-modal-overlay {
                padding: 14px;
            }

            .so-modal-grid-6,
            .so-modal-grid-3,
            .so-modal-grid-2 {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .so-modal-actions {
                flex-direction: column-reverse;
                gap: 12px;
                margin-top: 28px;
            }

            .so-btn-primary,
            .so-btn-outline {
                width: 100%;
            }
        }

        .so-btn-add-row {
            background: #F4F3F7;
            color: #612989;
            border: 1px dashed #612989;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Prompt';
            width: 100%;
            margin-top: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }
    </style>

    <div class="so-product-header-row">
        <div class="so-product-title-text">รายการสินค้า</div>
        <?php if ($productTableIsPo) { ?>
            <div class="so-product-count"><span id="total_items_count">0</span>/30 รายการ</div>
        <?php } ?>
        <!-- <div class="so-product-count"><span id="total_items_count">0</span> รายการ</div> -->
    </div>
    <hr style="border: 0; border: 2px solid #EDE9F0; margin-bottom: 24px;">

    <div class="so-product-summary">
        <div class="so-product-summary-col">
            <div class="so-summary-label">จำนวนรวม(ชิ้น)</div>
            <div class="so-summary-value" id="summary_total_qty">0</div>
        </div>
        <div class="so-product-summary-col">
            <div class="so-summary-label">ยอดรวม</div>
            <div class="so-summary-value" id="summary_total_amount">0.00</div>
        </div>
        <div class="so-product-summary-col">
            <div class="so-summary-label">ส่วนลดทั้งหมด</div>
            <div class="so-summary-value" id="summary_total_discount">0.00</div>
        </div>
        <div class="so-product-summary-col">
            <div class="so-summary-label">ยอดรวมสุทธิ</div>
            <div class="so-summary-value-net" id="summary_net_total">0.00</div>
        </div>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 12px; margin-bottom: 16px;">
        <div class="so-product-search-col" style="flex: 1; min-width: 260px;">
            <label for="global_product_search" class="so-summary-label" style="display: block; color: #612989; margin-bottom: 4px; font-size: 14px; font-weight: 400;">ค้นหารายการสินค้า</label>
            <div class="pf-search-bar" style="margin-bottom: 0;">
                <i class="fas fa-search"></i>
                <input type="text" id="global_product_search" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า">
            </div>
        </div>
        <div style="align-self: flex-end;">
            <button type="button" class="so-btn-danger" id="btn_delete_selected" onclick="deleteSelectedRows()" style="display: none; height: 42px; padding: 0 16px; border-radius: 8px; border: none; background-color: #dc3545; color: white; cursor: pointer; align-items: center; gap: 8px; font-family: 'Kanit', sans-serif;">
                <i class="far fa-trash-alt"></i> ลบรายการที่เลือก
            </button>
        </div>
    </div>

    <div class="so-product-table-wrap">
        <table class="so-product-table" id="product_table">
            <thead>
                <tr>
                    <th style="width: 70px; text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-grip-vertical" style="opacity: 0; margin: 0; pointer-events: none;"></i>
                            <input type="checkbox" id="select_all_rows" class="so-row-checkbox" onclick="toggleSelectAllRows(this)">
                        </div>
                    </th>
                    <th style="width: 15%; text-align: left;">รหัสสินค้า</th>
                    <th style="width: 25%; text-align: left;">รายการสินค้า</th>
                    <th style="width: 8%; text-align: center;">จำนวน</th>
                    <th style="width: 15%; text-align: center;">ราคา/หน่วย</th>
                    <th style="width: 12%; text-align: center;">ส่วนลด/หน่วย</th>
                    <th style="width: 15%; text-align: center;">ยอดรวม</th>
                    <th style="width: 10%; text-align: center;"></th>
                </tr>
            </thead>
            <tbody>

                <?php for ($i = 1; $i <= 30; $i++): ?>
                    <tr class="so-product-row" id="product_row_<?php echo $i; ?>" style="display:none;">
                        <td style="text-align: center;">
                            <!-- ไอคอนลากสลับตำแหน่ง (Pointer Events: รองรับเมาส์ + ทัชบน mobile/iPad) และ Checkbox สำหรับไฮไลท์แถว -->
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-grip-vertical drag-handle" style="margin: 0;" onpointerdown="handleRowPointerDown(event, <?php echo $i; ?>)"></i>
                                <input type="checkbox" class="so-row-checkbox" onchange="toggleRowHighlight(this, <?php echo $i; ?>)">
                            </div>

                            <!-- ค่า Hidden เบื้องหลัง: เก็บข้อมูลรหัส, ID สินค้า และหน่วยสินค้า เพื่อส่งเข้าระบบตอนบันทึก -->
                            <input type="hidden" name="h_product_codet<?php echo $i; ?>" id="h_product_codet<?php echo $i; ?>">
                            <input type="hidden" name="h_product_code<?php echo $i; ?>" id="h_product_code<?php echo $i; ?>">
                            <input type="hidden" name="h_product_c<?php echo $i; ?>" id="h_product_c<?php echo $i; ?>">
                            <input type="hidden" name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>">
                            <input type="hidden" name="unit_name<?php echo $i; ?>" id="unit_name<?php echo $i; ?>">
                            <input type="hidden" name="subso_db_id<?php echo $i; ?>" id="subso_db_id<?php echo $i; ?>">
                            <input type="hidden" name="row_deleted<?php echo $i; ?>" id="row_deleted<?php echo $i; ?>" value="0">
                            <input type="hidden" name="deleted_subso_db_id<?php echo $i; ?>" id="deleted_subso_db_id<?php echo $i; ?>">
                            <input type="hidden" name="deleted_product_code<?php echo $i; ?>" id="deleted_product_code<?php echo $i; ?>">

                            <!-- ค่า Hidden ข้อมูลเพิ่มเติม: เก็บข้อมูลที่กรอกใน Modal (เช่น ประกัน, รอบ PM, หมายเหตุ) -->
                            <input type="hidden" name="warranty<?php echo $i; ?>" id="warranty<?php echo $i; ?>">
                            <input type="hidden" name="warranty_unit<?php echo $i; ?>" id="warranty_unit<?php echo $i; ?>" value="ปี">
                            <input type="hidden" name="remark_hc<?php echo $i; ?>" id="remark_hc<?php echo $i; ?>">
                            <input type="hidden" name="cal<?php echo $i; ?>" id="cal<?php echo $i; ?>">
                            <input type="hidden" name="pm_year<?php echo $i; ?>" id="pm_year<?php echo $i; ?>">
                            <input type="hidden" name="pm<?php echo $i; ?>" id="pm<?php echo $i; ?>">
                            <input type="hidden" name="sale_remarkk<?php echo $i; ?>" id="sale_remarkk<?php echo $i; ?>">
                            <!-- ค่าเริ่มต้นต้องเป็นค่าว่าง ไม่ใช่ "1" มิฉะนั้นรายการขายปกติทุกแถวจะถูก
                        report_clearbr.php นับเป็นรายการเคลียร์ยืม/จอง (ดู WHERE clear_br='1') -->
                            <input type="hidden" name="clear_br<?php echo $i; ?>" id="clear_br<?php echo $i; ?>" value="">
                            <input type="hidden" name="clear_ivno<?php echo $i; ?>" id="clear_ivno<?php echo $i; ?>">
                            <input type="hidden" name="jong_ckk<?php echo $i; ?>" id="jong_ckk<?php echo $i; ?>" value="">
                            <input type="hidden" name="jong_no<?php echo $i; ?>" id="jong_no<?php echo $i; ?>">
                            <input type="hidden" name="display_name<?php echo $i; ?>" id="display_name<?php echo $i; ?>">
                            <input type="hidden" name="product_sn<?php echo $i; ?>" id="product_sn<?php echo $i; ?>">
                        </td>
                        <td>
                            <!-- รหัสสินค้า: แสดงผลอย่างเดียว (readonly) ข้อมูลถูกดึงมาใส่เมื่อเลือกสินค้าจากช่องค้นหาด้านบน -->
                            <input type='text' name="product_codet<?php echo $i; ?>" id="product_codet<?php echo $i; ?>" class="so-transparent-input product-code-input" placeholder="" readonly OnChange="JavaScript:doCallAjax('product_codet<?php echo $i; ?>','product_id<?php echo $i; ?>','product_name<?php echo $i; ?>','unit_name<?php echo $i; ?>','product_price<?php echo $i; ?>','discount_unit<?php echo $i; ?>','warranty<?php echo $i; ?>'); calculateSummary();" />
                        </td>
                        <td>
                            <!-- ชื่อรายการสินค้า: แสดงเป็น label ข้อมูลถูกดึงมาใส่เมื่อเลือกสินค้าจากช่องค้นหา -->
                            <input type="hidden" name="product_name<?php echo $i; ?>" id="product_name<?php echo $i; ?>">
                            <span id="product_name_label<?php echo $i; ?>" class="so-product-name-label"></span>
                        </td>
                        <td>
                            <!-- จำนวน: ใส่จำนวนชิ้นที่ต้องการขาย เมื่อแก้ไขจะคำนวณยอดใหม่ทันที -->
                            <input type='text' name="sale_count<?php echo $i; ?>" id="sale_count<?php echo $i; ?>" class="so-pill-input calc-qty" style="text-align:center" oninput="updateRowTotal(<?php echo $i; ?>); calculateSummary();" onchange="updateRowTotal(<?php echo $i; ?>); calculateSummary();" />
                        </td>
                        <td>
                            <!-- ราคา/หน่วย: ราคาขายต่อ 1 ชิ้น สามารถแก้ไขได้ -->
                            <input type='text' name="product_price<?php echo $i; ?>" id="product_price<?php echo $i; ?>" class="so-pill-input calc-price" style="text-align:right" oninput="updateRowTotal(<?php echo $i; ?>); calculateSummary();" onchange="updateRowTotal(<?php echo $i; ?>); calculateSummary();" onblur="formatNumberInput(this);" />
                        </td>
                        <td>
                            <!-- ส่วนลด/หน่วย: หากมีส่วนลด ให้กรอกที่ช่องนี้ (หักออกจากราคาต่อชิ้น) -->
                            <input type='text' name="discount_unit<?php echo $i; ?>" id="discount_unit<?php echo $i; ?>" class="so-pill-input calc-discount" style="text-align:right" oninput="updateRowTotal(<?php echo $i; ?>); calculateSummary();" onchange="updateRowTotal(<?php echo $i; ?>); calculateSummary();" onblur="formatNumberInput(this);" />
                        </td>
                        <td>
                            <!-- ยอดรวมสุทธิของแถวนี้: คำนวณอัตโนมัติ (จำนวน * ราคา) - (ส่วนลด * จำนวน) -->
                            <input type='text' name="sum_amount<?php echo $i; ?>" id="sum_amount<?php echo $i; ?>" class="so-transparent-input calc-total" style="text-align:right;" readonly />
                        </td>
                        <td style="text-align: right; padding-right: 16px; white-space: nowrap;">
                            <!-- ปุ่ม Action: เปิด Modal ข้อมูลเพิ่มเติม (ไอคอนดินสอ) และ ปุ่มเคลียร์ข้อมูลแถวนี้ (ถังขยะ) -->
                            <img src="img/icons/edit.svg" alt="" width="16" height="16" class="action-icon" role="button" tabindex="0" aria-label="ข้อมูลเพิ่มเติมรายการที่ <?php echo $i; ?>" onclick="openEditModal(<?php echo $i; ?>)">
                            <img src="img/icons/trash.svg" alt="" width="16" height="18" class="action-icon" role="button" tabindex="0" aria-label="ลบรายการที่ <?php echo $i; ?>" onclick="clearRow(<?php echo $i; ?>)">
                        </td>
                    </tr>
                <?php endfor; ?>

            </tbody>
        </table>
    </div>
    <div class="so-product-empty-state" id="product_empty_state">ยังไม่มีรายการสินค้า — ค้นหาสินค้าจากช่องด้านบน</div>

    <!-- Edit Modal -->
    <div class="so-modal-overlay" id="productEditModal">
        <div class="so-modal-content" role="dialog" aria-modal="true" aria-labelledby="productEditModalTitle">
            <div class="so-modal-header">
                <h3 class="so-modal-title" id="productEditModalTitle">ข้อมูลรายการสินค้าเพิ่มเติม</h3>
                <button type="button" class="so-modal-close" onclick="closeEditModal()" aria-label="ปิด">&times;</button>
            </div>

            <input type="hidden" id="current_editing_row">
            <input type="hidden" id="modal_row_number">

            <?php if ($productTableIsPo) { ?>
                <!-- ใบ PO: 4 ช่อง ไม่บังคับกรอก → hos__subpo.warranty / cal / pm / sale_remark
                 ช่องเฉพาะ SO ยังต้องมี element (openEditModal/saveEditModal อ้างถึง) จึงเก็บเป็น hidden -->
                <div class="so-modal-grid-3">
                    <div class="so-modal-field">
                        <label for="m_warranty" id="modal_warranty_label">รับประกัน(ปี)</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_warranty" placeholder="ใส่เฉพาะตัวเลข" onkeypress="return chkNumber(this, event)" data-clearable="true">
                            <button type="button" class="so-modal-clear" data-target="m_warranty" aria-label="ล้างข้อมูล">&times;</button>
                        </div>
                    </div>
                    <div class="so-modal-field">
                        <label for="m_cal">CAL/ปี</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_cal" placeholder="ใส่เฉพาะตัวเลข" onkeypress="return chkNumber(this, event)" data-clearable="true">
                            <button type="button" class="so-modal-clear" data-target="m_cal" aria-label="ล้างข้อมูล">&times;</button>
                        </div>
                    </div>
                    <div class="so-modal-field">
                        <label for="m_pm_year">PM(ปี)</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_pm_year" placeholder="ใส่เฉพาะตัวเลข" onkeypress="return chkNumber(this, event)" data-clearable="true">
                            <button type="button" class="so-modal-clear" data-target="m_pm_year" aria-label="ล้างข้อมูล">&times;</button>
                        </div>
                    </div>
                </div>
                <div class="so-modal-grid-1">
                    <div class="so-modal-field">
                        <label for="m_sale_remarkk">หมายเหตุสินค้า</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_sale_remarkk" placeholder="กรอกข้อมูล" data-clearable="true">
                            <button type="button" class="so-modal-clear" data-target="m_sale_remarkk" aria-label="ล้างข้อมูล">&times;</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="m_pm">
                <input type="hidden" id="m_jong_no">
                <input type="hidden" id="m_clear_ivno">
                <input type="hidden" id="m_product_sn">
            <?php } else { ?>
                <div class="so-modal-grid-6">
                    <div class="so-modal-field">
                        <label id="modal_warranty_label">รับประกัน(ปี)<span class="so-modal-required">*</span></label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_warranty" placeholder="ใส่เฉพาะตัวเลข" data-clearable="true">
                            <button type="button" class="so-modal-clear" data-target="m_warranty" aria-label="ล้างข้อมูล">&times;</button>
                        </div>
                    </div>
                    <div class="so-modal-field">
                        <label>CAL/ปี</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_cal" placeholder="ใส่เฉพาะตัวเลข" onkeypress="return chkNumber(this, event)" data-clearable="true">
                            <button type="button" class="so-modal-clear" data-target="m_cal" aria-label="ล้างข้อมูล">&times;</button>
                        </div>
                    </div>
                    <div class="so-modal-field">
                        <label>PM(ปี)</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_pm_year" placeholder="ใส่เฉพาะตัวเลข" onkeypress="return chkNumber(this, event)" data-clearable="true">
                            <button type="button" class="so-modal-clear" data-target="m_pm_year" aria-label="ล้างข้อมูล">&times;</button>
                        </div>
                    </div>
                    <div class="so-modal-field">
                        <label>PM (จำนวนครั้ง/ปี)</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_pm" placeholder="ใส่เฉพาะตัวเลข" onkeypress="return chkNumber(this, event)" data-clearable="true">
                            <button type="button" class="so-modal-clear" data-target="m_pm" aria-label="ล้างข้อมูล">&times;</button>
                        </div>
                    </div>
                    <div class="so-modal-field">
                        <label>เลขที่ใบจอง</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_jong_no" data-clearable="true" readonly>
                        </div>
                    </div>
                    <div class="so-modal-field">
                        <label>เลขที่ใบยืม</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_clear_ivno" data-clearable="true" readonly>
                        </div>
                    </div>
                </div>

                <div class="so-modal-grid-2">
                    <div class="so-modal-field">
                        <label>เลขที่ SN</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_product_sn" data-clearable="true" readonly>
                        </div>
                    </div>
                    <div class="so-modal-field">
                        <label>หมายเหตุสินค้า</label>
                        <div class="so-modal-input-wrap">
                            <input type="text" id="m_sale_remarkk" placeholder="กรอกข้อมูล" data-clearable="true">
                            <button type="button" class="so-modal-clear" data-target="m_sale_remarkk" aria-label="ล้างข้อมูล">&times;</button>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="so-modal-actions">
                <button type="button" class="so-btn-outline" onclick="closeEditModal()">ยกเลิก</button>
                <button type="button" class="so-btn-primary" onclick="saveEditModal()">อัพเดท</button>
            </div>
        </div>
    </div>

    <script>
        // --- Drag and Drop Row Reordering ---
        const rowFields = [
            'h_product_codet', 'h_product_code', 'h_product_c', 'product_id', 'unit_name', 'subso_db_id', 'row_deleted', 'deleted_subso_db_id', 'deleted_product_code',
            'warranty', 'cal', 'pm_year', 'pm', 'sale_remarkk', 'clear_br', 'clear_ivno', 'jong_ckk', 'jong_no', 'display_name', 'product_sn',
            'product_codet', 'product_name', 'sale_count', 'product_price', 'discount_unit', 'sum_amount', 'remark_hc'
        ];

        function getRowData(index) {
            let data = {};
            rowFields.forEach(field => {
                let el = document.getElementById(field + index);
                if (el) data[field] = el.value;
            });
            // product_name label (span)
            let nameLabel = document.getElementById('product_name_label' + index);
            if (nameLabel) data['product_name_label'] = nameLabel.textContent;
            let rowEl = document.getElementById('product_row_' + index);
            data['display'] = rowEl.style.display;
            let cb = rowEl.querySelector('.so-row-checkbox');
            data['checked'] = cb ? cb.checked : false;
            return data;
        }

        function setRowData(index, data) {
            rowFields.forEach(field => {
                let el = document.getElementById(field + index);
                if (el && data[field] !== undefined) el.value = data[field];
            });
            // Sync the product_name_label span
            let nameLabel = document.getElementById('product_name_label' + index);
            if (nameLabel && data['product_name_label'] !== undefined) {
                nameLabel.textContent = data['product_name_label'];
            }
            let rowEl = document.getElementById('product_row_' + index);
            if (data['display'] !== undefined) {
                rowEl.style.display = data['display'];
            }
            let cb = rowEl.querySelector('.so-row-checkbox');
            if (cb) cb.checked = data['checked'] || false;
            if (data['checked']) {
                rowEl.classList.add('checked-row');
            } else {
                rowEl.classList.remove('checked-row');
            }
        }

        // ใช้ Pointer Events แทน HTML5 drag & drop เพื่อให้ลากได้ทั้งเมาส์และนิ้ว (mobile / tablet / iPad)
        let rowDrag = null; // { from, target, pointerId, handle, x, y, raf }

        function handleRowPointerDown(e, index) {
            if (e.pointerType === 'mouse' && e.button !== 0) return;
            e.preventDefault();

            const handle = e.currentTarget;
            const rect = handle.getBoundingClientRect();
            handle.setPointerCapture(e.pointerId);

            rowDrag = {
                from: index,
                target: null,
                pointerId: e.pointerId,
                handle: handle,
                // หาแถวปลายทางจากแนวคอลัมน์ไอคอนลาก นิ้วเลื่อนออกด้านข้างก็ยังหาแถวเจอ
                x: rect.left + rect.width / 2,
                y: e.clientY,
                raf: null
            };

            document.getElementById('product_row_' + index).classList.add('dragging');
            document.body.classList.add('row-dragging');
            handle.addEventListener('pointermove', handleRowPointerMove);
            handle.addEventListener('pointerup', handleRowPointerEnd);
            handle.addEventListener('pointercancel', handleRowPointerEnd);
            rowDrag.raf = requestAnimationFrame(rowDragAutoScroll);
        }

        function handleRowPointerMove(e) {
            if (!rowDrag || e.pointerId !== rowDrag.pointerId) return;
            e.preventDefault();
            rowDrag.y = e.clientY;
            updateRowDragTarget();
        }

        function updateRowDragTarget() {
            const el = document.elementFromPoint(rowDrag.x, rowDrag.y);
            const row = el ? el.closest('.so-product-row') : null;
            let target = null;
            if (row && row.style.display !== 'none') {
                target = parseInt(row.id.replace('product_row_', ''), 10);
                if (target === rowDrag.from) target = null;
            }
            if (target === rowDrag.target) return;

            if (rowDrag.target !== null) {
                document.getElementById('product_row_' + rowDrag.target).classList.remove('drag-over', 'drag-over-after');
            }
            if (target !== null) {
                // ลากลง = วางใต้แถวปลายทาง, ลากขึ้น = วางเหนือแถวปลายทาง (ตรงกับผลของ shiftRows)
                row.classList.add(target > rowDrag.from ? 'drag-over-after' : 'drag-over');
            }
            rowDrag.target = target;
        }

        // เลื่อนหน้าจออัตโนมัติเมื่อลากไปใกล้ขอบบน/ล่าง (รายการยาวบนมือถือ)
        function rowDragAutoScroll() {
            if (!rowDrag) return;
            const edge = 60;
            const h = window.innerHeight;
            let dy = 0;
            if (rowDrag.y < edge) {
                dy = -Math.ceil((edge - rowDrag.y) / 4);
            } else if (rowDrag.y > h - edge) {
                dy = Math.ceil((rowDrag.y - (h - edge)) / 4);
            }
            if (dy !== 0) {
                window.scrollBy(0, dy);
                updateRowDragTarget();
            }
            rowDrag.raf = requestAnimationFrame(rowDragAutoScroll);
        }

        function handleRowPointerEnd(e) {
            if (!rowDrag || e.pointerId !== rowDrag.pointerId) return;
            const drag = rowDrag;
            rowDrag = null;

            cancelAnimationFrame(drag.raf);
            drag.handle.removeEventListener('pointermove', handleRowPointerMove);
            drag.handle.removeEventListener('pointerup', handleRowPointerEnd);
            drag.handle.removeEventListener('pointercancel', handleRowPointerEnd);
            document.body.classList.remove('row-dragging');
            document.querySelectorAll('.so-product-row').forEach(row => {
                row.classList.remove('dragging', 'drag-over', 'drag-over-after');
            });

            if (e.type === 'pointerup' && drag.target !== null) {
                shiftRows(drag.from, drag.target);
            }
        }

        function shiftRows(fromIndex, toIndex) {
            let allData = [];
            for (let i = 1; i <= 30; i++) {
                allData.push(getRowData(i));
            }

            let fromData = allData.splice(fromIndex - 1, 1)[0];
            allData.splice(toIndex - 1, 0, fromData);

            for (let i = 1; i <= 30; i++) {
                setRowData(i, allData[i - 1]);
            }

            calculateSummary();
            if (typeof updateDeleteButtonVisibility === 'function') {
                updateDeleteButtonVisibility();
            }
        }
        // ------------------------------------

        function updateDeleteButtonVisibility() {
            var checkboxes = document.querySelectorAll('.so-row-checkbox:not(#select_all_rows)');
            var hasChecked = false;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    hasChecked = true;
                    break;
                }
            }
            var btn = document.getElementById('btn_delete_selected');
            if (btn) {
                btn.style.display = hasChecked ? 'flex' : 'none';
            }
        }

        function deleteSelectedRows() {
            if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการที่เลือกทั้งหมด?')) {
                var checkboxes = document.querySelectorAll('.so-row-checkbox:not(#select_all_rows)');
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                        clearRow(i + 1, true);
                        checkboxes[i].checked = false;
                        var row = document.getElementById('product_row_' + (i + 1));
                        if (row) {
                            row.classList.remove('checked-row');
                        }
                    }
                }
                var master = document.getElementById('select_all_rows');
                if (master) master.checked = false;
                updateDeleteButtonVisibility();
            }
        }

        function toggleRowHighlight(checkbox, rowIndex) {
            var row = document.getElementById('product_row_' + rowIndex);
            if (row) {
                if (checkbox.checked) {
                    row.classList.add('checked-row');
                } else {
                    row.classList.remove('checked-row');
                }
            }

            // Update master checkbox state based on all row checkboxes
            var allCheckboxes = document.querySelectorAll('.so-row-checkbox:not(#select_all_rows)');
            var master = document.getElementById('select_all_rows');
            if (master) {
                var allChecked = true;
                for (var i = 0; i < allCheckboxes.length; i++) {
                    if (!allCheckboxes[i].checked) {
                        allChecked = false;
                        break;
                    }
                }
                master.checked = allChecked;
            }
            updateDeleteButtonVisibility();
        }

        function toggleSelectAllRows(master) {
            var checkboxes = document.querySelectorAll('.so-row-checkbox:not(#select_all_rows)');
            for (var i = 0; i < checkboxes.length; i++) {
                var cb = checkboxes[i];
                cb.checked = master.checked;

                var row = document.getElementById('product_row_' + (i + 1));
                if (row) {
                    if (master.checked) {
                        row.classList.add('checked-row');
                    } else {
                        row.classList.remove('checked-row');
                    }
                }
            }
            updateDeleteButtonVisibility();
        }

        function executeClearRow(rowIndex) {
            var currentSubsoId = document.getElementById('subso_db_id' + rowIndex).value;
            var currentProductCode = document.getElementById('h_product_codet' + rowIndex).value || document.getElementById('product_codet' + rowIndex).value || '';

            if (currentSubsoId !== '') {
                document.getElementById('deleted_subso_db_id' + rowIndex).value = currentSubsoId;
                document.getElementById('deleted_product_code' + rowIndex).value = currentProductCode;
            }
            // ถ้า currentSubsoId ว่างแต่มี deleted_subso_db_id ค้างอยู่แล้ว (เพิ่มสินค้าใหม่ทับแถวที่เพิ่งลบ แล้วกดลบซ้ำ)
            // ให้คงคำสั่งลบของเดิมไว้ ไม่ล้างทิ้ง มิฉะนั้นของเดิมจะไม่ถูกลบออกจาก DB

            // ตั้ง row_deleted = '1' เสมอเมื่อแถวถูกล้าง แม้ยังไม่รู้ subso_db_id (เช่น id หายไปจากฟอร์ม)
            // เพื่อไม่ให้ฝั่ง server เข้าใจผิดว่าแถวนี้เป็นแถวว่างเปล่าที่ไม่เคยมีข้อมูล
            document.getElementById('row_deleted' + rowIndex).value = '1';

            document.getElementById('subso_db_id' + rowIndex).value = '';
            document.getElementById('h_product_codet' + rowIndex).value = '';
            document.getElementById('h_product_code' + rowIndex).value = '';
            document.getElementById('h_product_c' + rowIndex).value = '';
            document.getElementById('product_codet' + rowIndex).value = '';
            document.getElementById('product_name' + rowIndex).value = '';
            var nameLabel = document.getElementById('product_name_label' + rowIndex);
            if (nameLabel) nameLabel.textContent = '';
            document.getElementById('unit_name' + rowIndex).value = '';
            document.getElementById('product_price' + rowIndex).value = '';
            document.getElementById('sale_count' + rowIndex).value = '';
            document.getElementById('sum_amount' + rowIndex).value = '';
            document.getElementById('discount_unit' + rowIndex).value = '';
            document.getElementById('product_id' + rowIndex).value = '';
            document.getElementById('product_sn' + rowIndex).value = '';
            document.getElementById('remark_hc' + rowIndex).value = '';

            // ล้างข้อมูลจาก modal (ประกัน/PM/หมายเหตุ/เลขที่ยืม-จอง) กันไม่ให้ค่าของสินค้าเดิมติดไปกับสินค้าใหม่ที่จะถูกเลือกเข้าแถวนี้ต่อ
            document.getElementById('warranty' + rowIndex).value = '';
            document.getElementById('cal' + rowIndex).value = '';
            document.getElementById('pm_year' + rowIndex).value = '';
            document.getElementById('pm' + rowIndex).value = '';
            document.getElementById('sale_remarkk' + rowIndex).value = '';
            document.getElementById('clear_ivno' + rowIndex).value = '';
            document.getElementById('jong_no' + rowIndex).value = '';
            document.getElementById('display_name' + rowIndex).value = '';
            // ลบสินค้าออกจากแถว ไม่ใช่การเคลียร์ยืม/จอง จึงต้องล้างเป็นค่าว่าง
            // (เดิมตั้งเป็น '1' ทำให้แถวว่างถูกนับเป็นรายการเคลียร์ยืมใน report_clearbr.php)
            document.getElementById('clear_br' + rowIndex).value = '';
            document.getElementById('jong_ckk' + rowIndex).value = '';

            document.getElementById('product_row_' + rowIndex).style.display = 'none';

            var cb = document.querySelector('#product_row_' + rowIndex + ' .so-row-checkbox');
            if (cb) {
                cb.checked = false;
                document.getElementById('product_row_' + rowIndex).classList.remove('checked-row');
            }
            if (typeof updateDeleteButtonVisibility === 'function') {
                updateDeleteButtonVisibility();
            }

            calculateSummary();
        }

        function clearRow(rowIndex, skipConfirm) {
            var currentSubsoId = document.getElementById('subso_db_id' + rowIndex).value;
            var currentProductCode = document.getElementById('h_product_codet' + rowIndex).value || document.getElementById('product_codet' + rowIndex).value || '';
            var currentProductId = document.getElementById('product_id' + rowIndex).value || '';

            var hasData = (currentSubsoId !== '' || currentProductCode !== '' || currentProductId !== '');

            if (hasData && !skipConfirm) {
                var productName = document.getElementById('product_name' + rowIndex).value || '';
                if (!productName) {
                    var nameLabel = document.getElementById('product_name_label' + rowIndex);
                    if (nameLabel) productName = nameLabel.textContent || '';
                }

                var displayMsg = 'คุณต้องการลบรายการนี้ ใช่หรือไม่ ?';
                if (productName) {
                    displayMsg = 'คุณต้องการลบรายการ "' + productName + '" ใช่หรือไม่ ?';
                }

                Swal.fire({
                    title: 'ยืนยันการลบรายการ',
                    html: displayMsg,
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยันลบ',
                    cancelButtonText: 'ยกเลิก',
                    reverseButtons: true,
                    iconHtml: `
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
                            <path d="M4 6H20V8H4V6Z" fill="#EF5350"/>
                            <path d="M10 2H14V4H10V2Z" fill="#EF5350"/>
                            <path d="M5 9H19V20C19 21.1046 18.1046 22 17 22H7C5.89543 22 5 21.1046 5 20V9Z" fill="#EF5350"/>
                            <rect x="9" y="11" width="2" height="7" rx="1" fill="#ffffff"/>
                            <rect x="13" y="11" width="2" height="7" rx="1" fill="#ffffff"/>
                        </svg>
                    `,
                    customClass: {
                        popup: 'figma-delete-popup',
                        title: 'figma-delete-title',
                        htmlContainer: 'figma-delete-html',
                        confirmButton: 'figma-delete-confirm-btn',
                        cancelButton: 'figma-delete-cancel-btn',
                        actions: 'figma-delete-actions',
                        icon: 'figma-delete-icon'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.isConfirmed) {
                        executeClearRow(rowIndex);
                    }
                });
            } else {
                executeClearRow(rowIndex);
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function toggleWarrantyTooltip(event, element) {
            event.stopPropagation();
            var isActive = element.classList.contains('active');
            var activeTooltips = document.querySelectorAll('.so-tooltip.active');
            activeTooltips.forEach(function(el) {
                el.classList.remove('active');
            });
            if (!isActive) {
                element.classList.add('active');
            }
        }

        document.addEventListener('click', function(event) {
            var activeTooltip = document.querySelector('.so-tooltip.active');
            if (activeTooltip && !activeTooltip.contains(event.target)) {
                activeTooltip.classList.remove('active');
            }
        });

        function openEditModal(rowIndex) {
            document.getElementById('current_editing_row').value = rowIndex;
            document.getElementById('modal_row_number').value = rowIndex;

            // Load data from hidden inputs
            document.getElementById('m_warranty').value = document.getElementById('warranty' + rowIndex).value;

            // Set dynamic warranty unit label
            var unitInput = document.getElementById('warranty_unit' + rowIndex);
            var unit = (unitInput && unitInput.value) ? unitInput.value : 'ปี';
            var warrantyLabel = document.getElementById('modal_warranty_label');
            if (warrantyLabel) {
                var remarkHcVal = document.getElementById('remark_hc' + rowIndex) ? document.getElementById('remark_hc' + rowIndex).value : '';
                var iconHtml = '';
                if (remarkHcVal && remarkHcVal.trim() !== '') {
                    iconHtml = ' <span class="so-tooltip" onclick="toggleWarrantyTooltip(event, this)">' +
                        '<img src="img/icons/question.png" alt="help" style="width: 14px; height: 14px; cursor: pointer; vertical-align: middle; margin-left: 4px;">' +
                        '<span class="so-tooltiptext">' + escapeHtml(remarkHcVal) + '</span>' +
                        '</span>';
                }
                // แสดงเครื่องหมาย * เฉพาะแถวที่บังคับกรอกรับประกัน (ดู productTableWarrantyRequired)
                var requiredMark = productTableWarrantyRequired(document.getElementById('product_sn' + rowIndex).value) ? '<span class="so-modal-required">*</span>' : '';
                warrantyLabel.innerHTML = 'รับประกัน(' + unit + ')' + requiredMark + iconHtml;
            }

            document.getElementById('m_cal').value = document.getElementById('cal' + rowIndex).value;
            document.getElementById('m_pm_year').value = document.getElementById('pm_year' + rowIndex).value;
            document.getElementById('m_pm').value = document.getElementById('pm' + rowIndex).value;
            document.getElementById('m_sale_remarkk').value = document.getElementById('sale_remarkk' + rowIndex).value;
            document.getElementById('m_jong_no').value = document.getElementById('jong_no' + rowIndex).value;
            document.getElementById('m_clear_ivno').value = document.getElementById('clear_ivno' + rowIndex).value;
            document.getElementById('m_product_sn').value = document.getElementById('product_sn' + rowIndex).value;

            document.getElementById('m_warranty').classList.remove('so-field-invalid');
            syncModalClearButtons();
            productEditModalReturnFocus = document.activeElement;
            document.getElementById('productEditModal').style.display = 'flex';
            var firstField = document.getElementById('m_warranty');
            if (firstField) firstField.focus();
        }

        // ปุ่มที่เปิด popup — คืนโฟกัสให้ตอนปิด ผู้ใช้คีย์บอร์ดจะได้ไม่หลุดไปต้นหน้า
        var productEditModalReturnFocus = null;

        function closeEditModal() {
            document.getElementById('productEditModal').style.display = 'none';
            if (productEditModalReturnFocus && typeof productEditModalReturnFocus.focus === 'function') {
                productEditModalReturnFocus.focus();
            }
            productEditModalReturnFocus = null;
        }

        document.addEventListener('keydown', function(event) {
            var modal = document.getElementById('productEditModal');
            if (event.key === 'Escape' && modal && modal.style.display === 'flex') {
                closeEditModal();
                return;
            }
            // ไอคอนแก้ไข/ลบเป็น <i role="button"> — ให้ Enter/Space ทำงานเหมือนคลิก
            var target = event.target;
            if ((event.key === 'Enter' || event.key === ' ') && target && target.classList && target.classList.contains('action-icon')) {
                event.preventDefault();
                target.click();
            }
        });

        function saveEditModal() {
            var rowIndex = document.getElementById('current_editing_row').value;

            // รับประกันบังคับกรอก (ดอกจันที่ label) ตามกฎของ productTableWarrantyValid — ไม่ผ่านแล้วขึ้นกรอบแดงและไม่ปิด popup
            var warrantyField = document.getElementById('m_warranty');
            if (!productTableWarrantyValid(warrantyField.value, document.getElementById('m_product_sn').value)) {
                warrantyField.classList.add('so-field-invalid');
                warrantyField.focus();
                return;
            }

            // Save data back to hidden inputs
            document.getElementById('warranty' + rowIndex).value = document.getElementById('m_warranty').value;
            document.getElementById('cal' + rowIndex).value = document.getElementById('m_cal').value;
            document.getElementById('pm_year' + rowIndex).value = document.getElementById('m_pm_year').value;
            document.getElementById('pm' + rowIndex).value = document.getElementById('m_pm').value;
            document.getElementById('sale_remarkk' + rowIndex).value = document.getElementById('m_sale_remarkk').value;
            document.getElementById('jong_no' + rowIndex).value = document.getElementById('m_jong_no').value;
            document.getElementById('clear_ivno' + rowIndex).value = document.getElementById('m_clear_ivno').value;
            document.getElementById('product_sn' + rowIndex).value = document.getElementById('m_product_sn').value;

            closeEditModal();
        }

        function syncModalClearButtons() {
            document.querySelectorAll('.so-modal-clear').forEach(function(btn) {
                var target = document.getElementById(btn.getAttribute('data-target'));
                if (!target) return;
                btn.classList.toggle('is-visible', target.value !== '');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-clearable="true"]').forEach(function(input) {
                input.addEventListener('input', syncModalClearButtons);
            });

            document.getElementById('m_warranty').addEventListener('input', function() {
                if (productTableWarrantyValid(this.value, document.getElementById('m_product_sn').value)) this.classList.remove('so-field-invalid');
            });

            document.querySelectorAll('.so-modal-clear').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var target = document.getElementById(btn.getAttribute('data-target'));
                    if (!target) return;
                    target.value = '';
                    target.focus();
                    syncModalClearButtons();
                });
            });
        });

        function formatNumberInput(el) {
            let raw = parseFloat(el.value.replace(/,/g, '')) || 0;
            if (raw !== 0) {
                el.value = raw.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        }

        function updateRowTotal(rowIndex) {
            let qtyStr = document.getElementById('sale_count' + rowIndex).value;
            let priceStr = document.getElementById('product_price' + rowIndex).value;
            let discStr = document.getElementById('discount_unit' + rowIndex).value;

            let qty = parseFloat(qtyStr.replace(/,/g, '')) || 0;
            let price = parseFloat(priceStr.replace(/,/g, '')) || 0;
            let disc = parseFloat(discStr.replace(/,/g, '')) || 0;

            let rowTotal = (qty * price) - (disc * qty);

            let sumEl = document.getElementById('sum_amount' + rowIndex);
            if (sumEl) {
                sumEl.value = rowTotal.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        }

        function calculateSummary() {
            setTimeout(function() {
                let totalQty = 0;
                let totalAmount = 0;
                let totalDiscount = 0;
                let itemsCount = 0;

                for (let i = 1; i <= 30; i++) {
                    let row = document.getElementById('product_row_' + i);
                    if (row.style.display !== 'none') {
                        let code = document.getElementById('product_codet' + i).value;
                        if (code && code.trim() !== '') itemsCount++;
                    }

                    let qtyStr = document.getElementById('sale_count' + i).value;
                    let priceStr = document.getElementById('product_price' + i).value;
                    let discStr = document.getElementById('discount_unit' + i).value;

                    let qty = parseFloat(qtyStr.replace(/,/g, '')) || 0;
                    let price = parseFloat(priceStr.replace(/,/g, '')) || 0;
                    let disc = parseFloat(discStr.replace(/,/g, '')) || 0;

                    totalQty += qty;
                    totalAmount += (qty * price);
                    totalDiscount += (disc * qty);
                }

                let netTotal = totalAmount - totalDiscount;

                var itemsCountEl = document.getElementById('total_items_count');
                if (itemsCountEl) itemsCountEl.innerText = itemsCount;

                document.getElementById('summary_total_qty').innerText = totalQty.toLocaleString(undefined, {
                    minimumFractionDigits: 0
                });
                document.getElementById('summary_total_amount').innerText = totalAmount.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                document.getElementById('summary_total_discount').innerText = totalDiscount.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                document.getElementById('summary_net_total').innerText = netTotal.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }, 200); // Slight delay to let jAutoCalc run first
        }

        // Global Product Search: show suggestions first, add only after the user selects one.
        new Autocomplete("global_product_search", function() {
            this.setValue = function(id) {
                if (!id) {
                    return;
                }

                // Find the first empty row
                let emptyRowIndex = -1;
                for (let i = 1; i <= 30; i++) {
                    let codeInput = document.getElementById('product_codet' + i);
                    if (codeInput && codeInput.value.trim() === '') {
                        emptyRowIndex = i;
                        break;
                    }
                }

                if (emptyRowIndex !== -1) {
                    let codeInput = document.getElementById('product_codet' + emptyRowIndex);
                    let hiddenCodeInput = document.getElementById('h_product_codet' + emptyRowIndex);
                    let rowDeletedInput = document.getElementById('row_deleted' + emptyRowIndex);
                    let subsoDbIdInput = document.getElementById('subso_db_id' + emptyRowIndex);

                    codeInput.value = id;
                    if (hiddenCodeInput) hiddenCodeInput.value = id;
                    if (rowDeletedInput) rowDeletedInput.value = '0';
                    if (subsoDbIdInput) subsoDbIdInput.value = '';
                    // หมายเหตุ: ไม่ล้าง deleted_subso_db_id/deleted_product_code ที่นี่
                    // เพราะแถวนี้อาจเป็นแถวที่เพิ่งลบสินค้าเดิมไป แล้วเลือกสินค้าใหม่ทันที
                    // ถ้าล้างทิ้ง คำสั่งลบของเดิมจะหายไป (ของเดิมค้างใน DB ไม่ถูกลบ)

                    // กันค่า clear_br/clear_ivno/jong_ckk/jong_no ของสินค้าเดิม (จากการเคลียร์ยืม/จอง)
                    // ติดค้างมากับแถวที่เพิ่งเลือกสินค้าใหม่เข้ามาทับ
                    var clearBrInput = document.getElementById('clear_br' + emptyRowIndex);
                    var clearIvnoInput = document.getElementById('clear_ivno' + emptyRowIndex);
                    var jongCkkInput = document.getElementById('jong_ckk' + emptyRowIndex);
                    var jongNoInput = document.getElementById('jong_no' + emptyRowIndex);
                    if (clearBrInput) clearBrInput.value = '';
                    if (clearIvnoInput) clearIvnoInput.value = '';
                    if (jongCkkInput) jongCkkInput.value = '';
                    if (jongNoInput) jongNoInput.value = '';

                    // Trigger the ajax call to populate the row
                    doCallAjax('product_codet' + emptyRowIndex, 'product_id' + emptyRowIndex, 'product_name' + emptyRowIndex, 'unit_name' + emptyRowIndex, 'product_price' + emptyRowIndex, 'discount_unit' + emptyRowIndex, 'warranty' + emptyRowIndex);

                    // Ensure the row is visible
                    document.getElementById('product_row_' + emptyRowIndex).style.display = '';

                    // Focus on the quantity field
                    setTimeout(function() {
                        let qtyInput = document.getElementById('sale_count' + emptyRowIndex);
                        if (qtyInput) {
                            qtyInput.value = "1"; // Default quantity
                            // Trigger change for jAutoCalc
                            qtyInput.dispatchEvent(new Event('change'));
                            qtyInput.focus();
                            qtyInput.select();
                        }
                        calculateSummary();
                    }, 300);
                } else {
                    alert("ไม่สามารถเพิ่มสินค้าได้ (ตารางเต็ม 30 รายการแล้ว)");
                }

                // Clear the global search box
                document.getElementById('global_product_search').value = '';
            };

            if (this.value.length < 1 && this.isNotClick) return;
            return "data_pro_notdemoth.php?product_code_search=" + encodeURIComponent(this.value) + "&type_company=" + getSelectedTypeCompany();
        }, {
            select_first: 0
        });

        // ปุ่ม autocomplete เดิม (js/autocomplete.js) ฟังแค่ event keydown/keypress เท่านั้น
        // การวางข้อความ (คลิกขวา > วาง หรือบางเบราว์เซอร์กับ Ctrl+V) ไม่ทำให้เกิด keypress
        // จึงไม่มีการค้นหาเกิดขึ้นเลย ต้องดักจับ event "paste" แล้วสั่งค้นหาซ้ำเอง
        (function() {
            var searchInput = document.getElementById('global_product_search');
            var acInstance = Autocomplete.inst[Autocomplete.inst.length - 1];
            // ซ่อนไอคอนสถานะเล็กๆ ทางขวาของช่องค้นหา (autocomplete.js สร้างให้อัตโนมัติ) เพราะไม่ได้ใช้
            acInstance.image.e.style.display = 'none';
            searchInput.addEventListener('paste', function() {
                setTimeout(function() {
                    acInstance.isModified = 1;
                    acInstance.isNotClick = 1;
                    acInstance.isON = 1; // request() ยิง AJAX ก็ต่อเมื่อ isON=1 เท่านั้น (ปกติถูกตั้งค่าตอน keydown)
                    acInstance.request();
                }, 0);
            });
        })();

        // อ่านบริษัทที่เลือกจาก dropdown (type_doc: 3=AWL, 4=NBM) เพื่อส่งไป filter สินค้าตอนค้นหา
        // default AWL ถ้าไม่มี dropdown (กรณีหน้าอื่นที่ include ไฟล์นี้โดยไม่มีตัวเลือกบริษัท)
        function getSelectedTypeCompany() {
            var td = document.getElementById('type_doc_select');
            return (td && td.value === '4') ? 'NBM' : 'AWL';
        }

        var productTableContext = <?php echo json_encode($productTableContext); ?>;
		var productTableWarrantyBySn = <?php echo json_encode($productTableWarrantyBySn); ?>;

        // ใบ PO ไม่บังคับรับประกัน; หน้าที่เปิด productTableWarrantyBySn บังคับเฉพาะแถวที่มีเลขที่ SN; หน้าอื่นบังคับทุกแถว
        function productTableWarrantyRequired(sn) {
            if (productTableContext === 'po') return false;
            if (productTableWarrantyBySn) return String(sn || '').trim() !== '';
            return true;
        }

        // แถวที่มี SN (productTableWarrantyBySn) ต้องเป็นตัวเลขมากกว่า 0 ทศนิยมได้; กรณีบังคับแบบเดิมแค่ไม่ว่างก็ผ่าน
        function productTableWarrantyValid(warranty, sn) {
            if (!productTableWarrantyRequired(sn)) return true;
            var value = String(warranty || '').trim();
            if (productTableWarrantyBySn) return /^\d*\.?\d+$/.test(value) && parseFloat(value) > 0;
            return value !== '';
        }

        // ตรวจรับประกันทุกแถวตอนบันทึกเอกสาร — แถวที่ไม่เคยเปิด popup ไม่ผ่าน saveEditModal จึงต้องตรวจซ้ำที่นี่
        // ไม่ผ่าน: เปิด popup ของแถวแรกที่ไม่ผ่านพร้อมกรอบแดง คืน false
        function productTableValidateWarrantyRows() {
            for (var i = 1; i <= 30; i++) {
                var row = document.getElementById('product_row_' + i);
                if (!row || row.style.display === 'none') continue;
                var productId = document.getElementById('product_id' + i);
                if (!productId || productId.value.trim() === '') continue;
                var warranty = document.getElementById('warranty' + i);
                var sn = document.getElementById('product_sn' + i);
                if (productTableWarrantyValid(warranty ? warranty.value : '', sn ? sn.value : '')) continue;

                openEditModal(i);
                document.getElementById('m_warranty').classList.add('so-field-invalid');
                return false;
            }
            return true;
        }

        function productTableHasItems() {
            for (var i = 1; i <= 30; i++) {
                var c = document.getElementById('product_codet' + i);
                if (c && c.value.trim() !== '') return true;
            }
            return false;
        }

        function productTableClearAll() {
            for (var j = 1; j <= 30; j++) {
                executeClearRow(j);
            }
        }

        // เติมแถวจากข้อมูลที่บันทึกไว้ (คีย์เดียวกับ savedProductsForForm ของ register_suphos.php)
        function productTableFillRows(products) {
            (products || []).slice(0, 30).forEach(function(product, index) {
                var rowIndex = index + 1;
                var row = document.getElementById('product_row_' + rowIndex);
                if (!row) return;
                row.style.display = '';

                ['product_id', 'product_sn', 'unit_name', 'sale_count', 'product_price', 'discount_unit', 'sum_amount',
                    'warranty', 'cal', 'pm_year', 'pm', 'sale_remarkk', 'clear_br', 'clear_ivno', 'jong_ckk', 'jong_no',
                    'display_name', 'subso_db_id', 'remark_hc', 'product_name'
                ].forEach(function(field) {
                    var el = document.getElementById(field + rowIndex);
                    if (el) el.value = product[field] || '';
                });
                var codeEl = document.getElementById('product_codet' + rowIndex);
                if (codeEl) codeEl.value = product.product_code || '';
                var hiddenCodeEl = document.getElementById('h_product_codet' + rowIndex);
                if (hiddenCodeEl) hiddenCodeEl.value = product.product_code || '';
                var nameLabel = document.getElementById('product_name_label' + rowIndex);
                if (nameLabel) nameLabel.textContent = product.product_name || product.product_code || '';

                ['product_price', 'discount_unit'].forEach(function(field) {
                    var el = document.getElementById(field + rowIndex);
                    if (el && el.value !== '') formatNumberInput(el);
                });
                updateRowTotal(rowIndex);
            });
            calculateSummary();
        }

        // เปลี่ยนบริษัท -> ล้างรายการสินค้าที่เลือกไว้ทั้งหมด (เตือนก่อน) กันสินค้า AWL/NBM ปนกันในใบเดียว
        function handleCompanyChange(sel) {
            if (productTableHasItems()) {
                if (!confirm('การเปลี่ยนบริษัทจะล้างรายการสินค้าที่เลือกไว้ทั้งหมด ต้องการดำเนินการต่อหรือไม่?')) {
                    sel.value = sel.getAttribute('data-prev'); // ยกเลิก -> คืนค่าบริษัทเดิม
                    return;
                }
                productTableClearAll();
            }
            // sync hidden input[name=type_doc] (พฤติกรรมเดิมของ onchange ที่ถูกแทนที่)
            var r = document.querySelector('input[name=type_doc]');
            if (r) r.value = sel.value;
            sel.setAttribute('data-prev', sel.value);
        }

        // เก็บค่าบริษัทก่อนหน้าไว้ เพื่อ revert เมื่อผู้ใช้กดยกเลิกใน confirm
        document.addEventListener('DOMContentLoaded', function() {
            var td = document.getElementById('type_doc_select');
            if (td) {
                td.setAttribute('data-prev', td.value);
                td.addEventListener('focus', function() {
                    this.setAttribute('data-prev', this.value);
                });
            }
        });

        // Run initial calc
        window.addEventListener('load', function() {
            calculateSummary();
        });

        // Listen to product inputs change to check credit limit
        document.addEventListener('DOMContentLoaded', function() {
            var productTable = document.getElementById('product_table');
            if (productTable) {
                productTable.addEventListener('change', function(event) {
                    var target = event.target;
                    if (target && (target.classList.contains('calc-qty') || target.classList.contains('calc-price') || target.classList.contains('calc-discount'))) {
                        if (typeof window.checkCreditLimitOnChange === 'function') {
                            setTimeout(window.checkCreditLimitOnChange, 250);
                        }
                    }
                });
            }
        });

        // แสดงกล่อง "ยังไม่มีรายการสินค้า" เมื่อไม่มีแถวไหนแสดงอยู่ — เฝ้าการเปลี่ยน style ของแถวแทนการแก้ฟังก์ชันเดิม
        // (ค้นหา/เติมข้อมูล/เคลียร์ยืม สั่ง display='' ส่วน clearRow สั่ง display='none' อยู่แล้ว)
        (function() {
            function syncProductEmptyState() {
                var emptyState = document.getElementById('product_empty_state');
                if (!emptyState) return;
                var rows = document.querySelectorAll('#product_table tr.so-product-row');
                var hasVisibleRow = false;
                for (var i = 0; i < rows.length; i++) {
                    if (rows[i].style.display !== 'none') {
                        hasVisibleRow = true;
                        break;
                    }
                }
                emptyState.style.display = hasVisibleRow ? 'none' : '';
            }

            document.addEventListener('DOMContentLoaded', function() {
                var tbody = document.querySelector('#product_table tbody');
                if (!tbody) return;
                syncProductEmptyState();
                new MutationObserver(syncProductEmptyState).observe(tbody, {
                    attributes: true,
                    attributeFilter: ['style'],
                    subtree: true
                });
            });
        })();
    </script>

    <?php for ($i = 1; $i <= 30; $i++): ?>
        <script type="text/javascript">
            function make_autocom_<?php echo $i; ?>(autoObj, showObj) {
                var mkAutoObj = autoObj;
                var mkSerValObj = showObj;
                new Autocomplete(mkAutoObj, function() {
                    this.setValue = function(id) {
                        document.getElementById(mkSerValObj).value = id;
                    }
                    if (this.isModified)
                        this.setValue("");
                    if (this.value.length < 1 && this.isNotClick)
                        return;
                    return "data_pro_notdemoth.php?product_code_search=" + encodeURIComponent(this.value) + "&type_company=" + getSelectedTypeCompany();
                });
            }
            // Autocomplete for product_codet removed since it's now display-only
            if (document.getElementById("product_c<?php echo $i; ?>")) {
                make_autocom_<?php echo $i; ?>("product_c<?php echo $i; ?>", "h_product_c<?php echo $i; ?>");
            }
        </script>
    <?php endfor; ?>

</body>

</html>