<html>

<head>
    <link rel="stylesheet" href="css/autocomplete.css" type="text/css" />
    <script type="text/javascript" src="js/autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>


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
        var pmeters = "product_code=" + encodeURI(document.getElementById(product_code).value);
        HttPRequest.open('POST', url, true);

        HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        HttPRequest.setRequestHeader("Content-length", pmeters.length);
        HttPRequest.setRequestHeader("Connection", "close");
        HttPRequest.send(pmeters);

        HttPRequest.onreadystatechange = function() {
            if (HttPRequest.readyState == 4) // Return Request
            {
                var myProduct = HttPRequest.responseText;

                if (myProduct != "") {

                    var myArr = myProduct.split("|");

                    document.getElementById(product_id).value = myArr[0];
                    // Set hidden input and label span for product_name
                    document.getElementById(product_name).value = myArr[1];
                    var labelEl = document.getElementById(product_name.replace('product_name', 'product_name_label'));
                    if (labelEl) labelEl.textContent = myArr[1];
                    document.getElementById(unit_name).value = myArr[2];
                    document.getElementById(product_price).value = myArr[3];
                    document.getElementById(discount_unit).value = myArr[4];
                    document.getElementById(warranty).value = myArr[5];

                    // Extract row index from the product_price element ID (e.g. "product_price3" -> 3)
                    var rowIdx = parseInt(product_price.replace('product_price', ''));
                    if (!isNaN(rowIdx) && typeof updateRowTotal === 'function') {
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
                }
            }
        }
    }


    function chkNumber(ele)

    {

        var vchar = String.fromCharCode(event.keyCode);
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

        .so-product-search-bar {
            display: flex;
            align-items: center;
            background-color: #F4F3F7;
            border-radius: 8px;
            padding: 0 16px;
            margin-bottom: 16px;
            width: 680px;
            height: 42px;
            max-width: 100%;
        }

        .so-product-search-bar input {
            border: none;
            background: transparent;
            width: 100%;
            outline: none;
            margin-left: 8px;
            font-size: 14px;
            font-family: 'Prompt', sans-serif;
        }

        .so-product-row.dragging {
            opacity: 0.4;
        }

        .so-product-row.drag-over {
            border-top: 2px solid #612989;
        }

        .so-product-table {
            width: 100%;
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
        }

        .action-icon {
            cursor: pointer;
            color: #8E8B94;
            font-size: 16px;
            margin-left: 8px;
        }

        .action-icon:hover {
            color: #612989;
        }

        /* Modal Styling */
        .so-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .so-modal-content {
            background: #FFF;
            border-radius: 12px;
            padding: 24px;
            width: 600px;
            max-width: 90%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .so-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .so-modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #612989;
            margin: 0;
        }

        .so-modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #8E8B94;
        }

        /* Flex Grid for Modal */
        .so-modal-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .so-modal-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .so-modal-field label {
            display: block;
            font-size: 13px;
            color: #4A4A4A;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .so-modal-field input[type="text"],
        .so-modal-field textarea {
            width: 100%;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #D9D9D9;
            background: #FFF;
            font-size: 13px;
            font-family: 'Prompt', sans-serif;
            outline: none;
            box-sizing: border-box;
        }

        .so-btn-primary {
            background: #612989;
            color: #FFF;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            font-family: 'Prompt';
        }

        .so-btn-outline {
            background: #FFF;
            color: #612989;
            border: 1px solid #612989;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            font-family: 'Prompt';
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

    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 16px;">
        <div style="flex: 1;">
            <div class="so-summary-label" style="color: #612989; margin-bottom: 4px; font-size: 14px; font-weight: 400;">ค้นหารายการสินค้า</div>
            <div class="so-product-search-bar" style="margin-bottom: 0;">
                <i class="fas fa-search" style="color: #333;"></i>
                <input type="text" id="global_product_search" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า">
            </div>
        </div>
        <div style="margin-left: 16px;">
            <button type="button" class="so-btn-danger" id="btn_delete_selected" onclick="deleteSelectedRows()" style="display: none; height: 42px; padding: 0 16px; border-radius: 8px; border: none; background-color: #dc3545; color: white; cursor: pointer; align-items: center; gap: 8px; font-family: 'Kanit', sans-serif;">
                <i class="far fa-trash-alt"></i> ลบรายการที่เลือก
            </button>
        </div>
    </div>

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
                <th style="width: 10%;"></th>
            </tr>
        </thead>
        <tbody>

            <?php for ($i = 1; $i <= 30; $i++): ?>
                <tr class="so-product-row" id="product_row_<?php echo $i; ?>" <?php if ($i > 3) echo 'style="display:none;"'; ?>
                    ondragstart="handleDragStart(event, <?php echo $i; ?>)"
                    ondragover="handleDragOver(event)"
                    ondragenter="handleDragEnter(event)"
                    ondragleave="handleDragLeave(event)"
                    ondrop="handleDrop(event, <?php echo $i; ?>)"
                    ondragend="handleDragEnd(event)">
                    <td style="text-align: center;">
                        <!-- ไอคอนลากสลับตำแหน่ง และ Checkbox สำหรับไฮไลท์แถว -->
                        <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-grip-vertical drag-handle" style="margin: 0; cursor: grab;" onmousedown="document.getElementById('product_row_<?php echo $i; ?>').setAttribute('draggable', true)" onmouseup="document.getElementById('product_row_<?php echo $i; ?>').removeAttribute('draggable')" onmouseleave="document.getElementById('product_row_<?php echo $i; ?>').removeAttribute('draggable')"></i>
                            <input type="checkbox" class="so-row-checkbox" onchange="toggleRowHighlight(this, <?php echo $i; ?>)">
                        </div>

                        <!-- ค่า Hidden เบื้องหลัง: เก็บข้อมูลรหัส, ID สินค้า และหน่วยสินค้า เพื่อส่งเข้าระบบตอนบันทึก -->
                        <input type="hidden" name="h_product_codet<?php echo $i; ?>" id="h_product_codet<?php echo $i; ?>">
                        <input type="hidden" name="h_product_code<?php echo $i; ?>" id="h_product_code<?php echo $i; ?>">
                        <input type="hidden" name="h_product_c<?php echo $i; ?>" id="h_product_c<?php echo $i; ?>">
                        <input type="hidden" name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>">
                        <input type="hidden" name="unit_name<?php echo $i; ?>" id="unit_name<?php echo $i; ?>">

                        <!-- ค่า Hidden ข้อมูลเพิ่มเติม: เก็บข้อมูลที่กรอกใน Modal (เช่น ประกัน, รอบ PM, หมายเหตุ) -->
                        <input type="hidden" name="warranty<?php echo $i; ?>" id="warranty<?php echo $i; ?>">
                        <input type="hidden" name="cal<?php echo $i; ?>" id="cal<?php echo $i; ?>">
                        <input type="hidden" name="pm<?php echo $i; ?>" id="pm<?php echo $i; ?>">
                        <input type="hidden" name="sale_remarkk<?php echo $i; ?>" id="sale_remarkk<?php echo $i; ?>">
                        <input type="hidden" name="clear_br<?php echo $i; ?>" id="clear_br<?php echo $i; ?>" value="1">
                        <input type="hidden" name="clear_ivno<?php echo $i; ?>" id="clear_ivno<?php echo $i; ?>">
                        <input type="hidden" name="jong_ckk<?php echo $i; ?>" id="jong_ckk<?php echo $i; ?>" value="1">
                        <input type="hidden" name="jong_no<?php echo $i; ?>" id="jong_no<?php echo $i; ?>">
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
                    <td style="text-align: right; padding-right: 16px;">
                        <!-- ปุ่ม Action: เปิด Modal ข้อมูลเพิ่มเติม (ไอคอนดินสอ) และ ปุ่มเคลียร์ข้อมูลแถวนี้ (ถังขยะ) -->
                        <i class="far fa-edit action-icon" onclick="openEditModal(<?php echo $i; ?>)"></i>
                        <i class="far fa-trash-alt action-icon" onclick="clearRow(<?php echo $i; ?>)"></i>
                    </td>
                </tr>
            <?php endfor; ?>

        </tbody>
    </table>

    <!-- Edit Modal -->
    <div class="so-modal-overlay" id="productEditModal">
        <div class="so-modal-content">
            <div class="so-modal-header">
                <h3 class="so-modal-title">ข้อมูลเพิ่มเติม (แถวที่ <span id="modal_row_number"></span>)</h3>
                <button type="button" class="so-modal-close" onclick="closeEditModal()">&times;</button>
            </div>

            <input type="hidden" id="current_editing_row">

            <div class="so-modal-grid-3">
                <div class="so-modal-field">
                    <label>รับประกัน (ปี)</label>
                    <input type="text" id="m_warranty">
                </div>
                <div class="so-modal-field">
                    <label>Cal(ครั้ง/ปี)</label>
                    <input type="text" id="m_cal" onkeypress="return chkNumber(this)">
                </div>
                <div class="so-modal-field">
                    <label>PM (ครั้ง/ปี)</label>
                    <input type="text" id="m_pm" onkeypress="return chkNumber(this)">
                </div>
            </div>

            <div class="so-modal-field" style="margin-bottom:16px;">
                <label>หมายเหตุ</label>
                <textarea id="m_sale_remarkk" rows="2"></textarea>
            </div>

            <div class="so-modal-grid-2">
                <div class="so-modal-field">
                    <label>เคลียร์ยืม (ใบแจ้ง/รหัส)</label>
                    <input type="text" id="m_clear_ivno">
                </div>
                <div class="so-modal-field">
                    <label>เคลียร์จอง (ใบจอง/รหัส)</label>
                    <input type="text" id="m_jong_no">
                </div>
            </div>

            <div style="text-align: right; margin-top: 24px;">
                <button type="button" class="so-btn-outline" onclick="closeEditModal()">ยกเลิก</button>
                <button type="button" class="so-btn-primary" onclick="saveEditModal()" style="margin-left: 8px;">บันทึกข้อมูล</button>
            </div>
        </div>
    </div>

    <script>
        // --- Drag and Drop Row Reordering ---
        let dragSourceIndex = null;
        const rowFields = [
            'h_product_codet', 'h_product_code', 'h_product_c', 'product_id', 'unit_name',
            'warranty', 'cal', 'pm', 'sale_remarkk', 'clear_br', 'clear_ivno', 'jong_ckk', 'jong_no',
            'product_codet', 'product_name', 'sale_count', 'product_price', 'discount_unit', 'sum_amount'
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

        // Prevent browser default drop on the document
        document.addEventListener('dragover', function(e) {
            e.preventDefault();
        }, false);
        document.addEventListener('drop', function(e) {
            e.preventDefault();
        }, false);

        function handleDragStart(e, index) {
            dragSourceIndex = index;
            e.dataTransfer.effectAllowed = 'move';
            e.currentTarget.classList.add('dragging');
        }

        function handleDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            return false;
        }

        function handleDragEnter(e) {
            if (e.currentTarget.id !== 'product_row_' + dragSourceIndex) {
                e.currentTarget.classList.add('drag-over');
            }
        }

        function handleDragLeave(e) {
            e.currentTarget.classList.remove('drag-over');
        }

        function handleDrop(e, targetIndex) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.remove('drag-over');

            if (dragSourceIndex !== null && dragSourceIndex !== targetIndex) {
                shiftRows(dragSourceIndex, targetIndex);
            }
            dragSourceIndex = null;
            return false;
        }

        function handleDragEnd(e) {
            e.currentTarget.classList.remove('dragging');
            document.querySelectorAll('.so-product-row').forEach(row => {
                row.classList.remove('drag-over');
                row.removeAttribute('draggable');
            });
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
                        clearRow(i + 1);
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

        function clearRow(rowIndex) {
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

        function openEditModal(rowIndex) {
            document.getElementById('current_editing_row').value = rowIndex;
            document.getElementById('modal_row_number').innerText = rowIndex;

            // Load data from hidden inputs
            document.getElementById('m_warranty').value = document.getElementById('warranty' + rowIndex).value;
            document.getElementById('m_cal').value = document.getElementById('cal' + rowIndex).value;
            document.getElementById('m_pm').value = document.getElementById('pm' + rowIndex).value;
            document.getElementById('m_sale_remarkk').value = document.getElementById('sale_remarkk' + rowIndex).value;
            document.getElementById('m_clear_ivno').value = document.getElementById('clear_ivno' + rowIndex).value;
            document.getElementById('m_jong_no').value = document.getElementById('jong_no' + rowIndex).value;

            document.getElementById('productEditModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('productEditModal').style.display = 'none';
        }

        function saveEditModal() {
            var rowIndex = document.getElementById('current_editing_row').value;

            // Save data back to hidden inputs
            document.getElementById('warranty' + rowIndex).value = document.getElementById('m_warranty').value;
            document.getElementById('cal' + rowIndex).value = document.getElementById('m_cal').value;
            document.getElementById('pm' + rowIndex).value = document.getElementById('m_pm').value;
            document.getElementById('sale_remarkk' + rowIndex).value = document.getElementById('m_sale_remarkk').value;
            document.getElementById('clear_ivno' + rowIndex).value = document.getElementById('m_clear_ivno').value;
            document.getElementById('jong_no' + rowIndex).value = document.getElementById('m_jong_no').value;

            closeEditModal();
        }

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

        // Global Product Search -> Auto Add to Table
        new Autocomplete("global_product_search", function() {
            this.setValue = function(id) {
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

                    codeInput.value = id;
                    if (hiddenCodeInput) hiddenCodeInput.value = id;

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

            if (this.isModified) this.setValue("");
            if (this.value.length < 1 && this.isNotClick) return;
            return "data_pro_notdemoth.php?product_code_search=" + encodeURIComponent(this.value);
        });

        // Run initial calc
        window.onload = function() {
            calculateSummary();
        };
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
                    return "data_pro_notdemoth.php?product_code_search=" + encodeURIComponent(this.value);
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