<?php include("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

<!-- Shared .so-* design-system primitives (cards, inputs, labels, buttons, etc.) -->
<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<!-- Page-specific styling for register_credinot.php -->
<link rel="stylesheet" href="css/register-credinot.css?v=<?php echo filemtime(__DIR__ . '/css/register-credinot.css'); ?>">
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
    <?php

    // โหมดของหน้า: แก้ไข (?ref_credit=), สร้างจาก SO (?ref_id=), หรือสร้างแบบไม่มีเอกสารอ้างอิง (ไม่มี param)
    $refCreditParam = isset($_GET['ref_credit']) ? trim($_GET['ref_credit']) : '';
    $ref_id = isset($_GET['ref_id']) ? $_GET['ref_id'] : '';
    $opener = isset($_GET['opener']) ? $_GET['opener'] : '';

    $mode = 'create_blank';
    if ($refCreditParam !== '') {
        $mode = 'edit';
    } elseif ($ref_id !== '') {
        $mode = 'create_so';
    }

    $rs = array();
    $escRefId = '';
    $escRefCredit = '';

    if ($mode === 'edit') {
        $escRefCredit = mysqli_real_escape_string($conn, $refCreditParam);
        $sql = "SELECT * FROM tb_credit_note WHERE ref_credit = '" . $escRefCredit . "'";
        $qry = mysqli_query($conn, $sql) or die(mysqli_error());
        $rs = mysqli_fetch_assoc($qry) ?: array();
        $ref_id = $rs['ref_id'] ?? '';
        $escRefId = mysqli_real_escape_string($conn, $ref_id);
    } elseif ($mode === 'create_so') {
        $escRefId = mysqli_real_escape_string($conn, $ref_id);
        $sql = "SELECT *   FROM hos__so where ref_id = '" . $escRefId . "'";
        $qry = mysqli_query($conn, $sql) or die(mysqli_error());
        $rs = mysqli_fetch_assoc($qry) ?: array();
    }

    // ===== แถบอนุมัติ: หา "ระดับ" ปัจจุบันของเอกสารจากสถานะที่โหลดมา (เฉพาะโหมดแก้ไข) =====
    $creditSendSup = $rs['send_sup'] ?? '0';
    $creditSendDm = $rs['send_dm'] ?? '0';
    $creditStatusDoc = $rs['status_doc'] ?? '';
    $creditIsClosed = in_array($creditStatusDoc, ['Approve', 'Rejected', 'ยกเลิก'], true);
    $creditSendAdmin = $rs['send_admin'] ?? '0';
    // เคย Approve มาก่อนหรือไม่ (send_admin='1' ถูกตั้งตอนอนุมัติระดับสุดท้ายเท่านั้น และไม่มีจุดไหนเซ็ตกลับเป็น '0')
    $creditWasEverApproved = ($creditSendAdmin === '1');
    // Lock ถาวรเฉพาะ: (1) กำลัง Approve อยู่ หรือ (2) ถูกยกเลิกหลังจากเคย Approve ไปแล้ว (มีผลบัญชีไปแล้ว)
    // ส่วนยกเลิกก่อนเคย Approve (เหมือน Rejected) ยังเปิดให้แก้ไขแล้ว resubmit ได้
    $creditItemsLocked = ($creditStatusDoc === 'Approve') || ($creditStatusDoc === 'ยกเลิก' && $creditWasEverApproved);
    $creditBucket = 3;
    if (!$creditIsClosed) {
        if ($creditSendDm === '1' && $creditStatusDoc === 'Request') {
            $creditBucket = 2;
        } elseif ($creditSendSup === '1' && $creditSendDm === '0' && $creditStatusDoc === 'Request') {
            $creditBucket = 1;
        } else {
            $creditBucket = 0;
        }
    }
    $creditCanShowApproveBar = ($mode === 'edit') && !$creditIsClosed;
    // ยกเลิกเอกสารได้ตลอด ไม่ว่าจะอยู่ระดับอนุมัติไหนหรือ Approve ไปแล้วก็ตาม ยกเว้นถูกยกเลิกไปแล้ว
    $creditCanCancel = ($mode === 'edit') && $creditStatusDoc !== 'ยกเลิก';

    $customerNo = '';
    $customerTypeName = '';
    $customerCreditThb = '';
    $customerStatusName = '-';
    $customerIsVip = false;
    if (!empty($rs['bill_id'])) {
        $escBillId = mysqli_real_escape_string($conn, $rs['bill_id']);
        $sqlCustomerNo = "SELECT customer_no, type_customer, credit_thb, status_cus, vip_ckk FROM tb_customer WHERE customer_id = '" . $escBillId . "'";
        $qryCustomerNo = mysqli_query($conn, $sqlCustomerNo) or die(mysqli_error());
        $rsCustomerNo = mysqli_fetch_assoc($qryCustomerNo);
        $customerNo = $rsCustomerNo['customer_no'] ?? '';
        $customerCreditThb = $rsCustomerNo['credit_thb'] ?? '';

        $statusCusVal = trim((string)($rsCustomerNo['status_cus'] ?? ''));
        if ($statusCusVal === '0') {
            $customerStatusName = 'Gold Customer';
        } elseif ($statusCusVal === '1') {
            $customerStatusName = 'Platinum Customer';
        } elseif ($statusCusVal === '2') {
            $customerStatusName = 'Diamond Customer';
        }
        $customerIsVip = (trim((string)($rsCustomerNo['vip_ckk'] ?? '')) === '1');

        if (!empty($rsCustomerNo['type_customer'])) {
            $escTypeCustomer = mysqli_real_escape_string($conn, $rsCustomerNo['type_customer']);
            $sqlTypeCustomer = "SELECT type_name FROM tb_typecustomer WHERE type_id = '" . $escTypeCustomer . "'";
            $qryTypeCustomer = mysqli_query($conn, $sqlTypeCustomer) or die(mysqli_error());
            $rsTypeCustomer = mysqli_fetch_assoc($qryTypeCustomer);
            $customerTypeName = $rsTypeCustomer['type_name'] ?? '';
        }
    }

    // ชื่อ/เบอร์โทร/ที่อยู่ลูกค้า: hos__so เก็บเป็น bill_name/bill_tel/bill_address, tb_credit_note เก็บเป็น customer_name/customer_tel/address_name
    if ($mode === 'edit') {
        $customerNameVal = $rs['customer_name'] ?? '';
        $customerTelVal = $rs['customer_tel'] ?? '';
        $addressVal = $rs['address_name'] ?? '';
    } else {
        $customerNameVal = $rs['bill_name'] ?? '';
        $customerTelVal = $rs['bill_tel'] ?? '';
        $addressVal = $rs['bill_address'] ?? '';
    }
    $billIdVal = $rs['bill_id'] ?? '';
    // ลูกค้าแก้ไข/ค้นหาเองได้เฉพาะโหมดสร้างแบบไม่มีเอกสารอ้างอิง (โหมดอื่นอิงจากเอกสารต้นทางเสมอ)
    $customerFieldsEditable = ($mode === 'create_blank');

    // เลขที่ IV ส่งมาจากหน้า register_suphos.php ได้ (ค่าสดในช่อง 'เลขที่เอกสาร' ที่อาจยังไม่ถูกบันทึกลง hos__so)
    // ถ้าไม่ส่งมา ให้ใช้ค่าจากฐานข้อมูลตามเดิม (โหมดแก้ไขใช้ iv_no_ref ที่เคยบันทึกไว้ใน tb_credit_note)
    $ivNoParam = isset($_GET['iv_no']) ? trim($_GET['iv_no']) : '';
    $ivNoFromRs = ($mode === 'edit') ? ($rs['iv_no_ref'] ?? '') : ($rs['iv_no'] ?? '');
    $ivNoEffective = ($ivNoParam !== '') ? $ivNoParam : $ivNoFromRs;
    $escIvNo = mysqli_real_escape_string($conn, $ivNoEffective);

    // รายการสินค้าตั้งต้น: จาก SO (สร้างจาก SO), จาก tb_subcredit (แก้ไข), หรือไม่มี (สร้างแบบไม่มีเอกสารอ้างอิง)
    if ($mode === 'create_so') {
        $strSQL1 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '" . $escRefId . "' ";
        $objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [" . $strSQL1 . "]");
    } elseif ($mode === 'edit') {
        $strSQL1 = "SELECT * FROM  (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_id=tb_product.product_ID) WHERE ref_creditt = '" . $escRefCredit . "' ";
        $objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [" . $strSQL1 . "]");
    } else {
        $objQuery1 = false;
    }

    // เลขที่อ้างอิงใบลดหนี้: โหมดแก้ไขใช้เลขเดิม ไม่ generate ใหม่
    $so = "SR";
    if ($mode === 'edit') {
        $refCreditFull = $rs['ref_credit'] ?? '';
    } else {
        $yearMonth = substr(date("Y") + 543, -2) . date("m");
        $sql1 = "SELECT MAX(ref_credit) AS MAXID FROM tb_credit_note";
        $qry1 = mysqli_query($conn, $sql1) or die(mysqli_error());
        $rs1 = mysqli_fetch_assoc($qry1);
        $maxId = substr($rs1['MAXID'], -4);
        $maxId3 = substr($rs1['MAXID'], -8);

        $maxId1 = substr($maxId3, 0, -4);

        if ($maxId1 == $yearMonth) {
            $maxId1 = ($maxId + 1);
            $maxId2 = substr("00000" . $maxId1, -4);
            $nextId = $yearMonth . $maxId2;
        } else {
            $maxId1 = "0001";
            $nextId = $yearMonth . $maxId1;
        }

        $refCreditFull = $so . $nextId;
    }


    date_default_timezone_set("Asia/Bangkok");

    $month = date('m');
    $day = date('d');
    $year = date('Y');

    $today = $year . '-' . $month . '-' . $day;

    ?>


    <!--action="register_office1.php"-->
    <form action='register_credinot1.php' method="post" name="frmMain" enctype="multipart/form-data">
        <div class="w3-container register-so-main" style="max-width: 1096px; margin: 0 auto;"><!-- main div -->

            <!-- Header Section -->
            <div class="so-header-container">
                <div class="so-header-left">
                    <h1 class="so-title"><?php echo $mode === 'edit' ? 'แก้ไขใบลดหนี้ (Credit Note Order)' : 'ใบลดหนี้ (Credit Note Order)'; ?></h1>
                    <div class="so-ref-info">
                        <span class="so-ref-label">เลขที่อ้างอิง</span>
                        <span class="so-ref-value"><?php echo htmlspecialchars($refCreditFull, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                </div>
                <div class="so-header-right">
                    <?php if ($creditCanCancel): ?>
                        <button type="button" class="btn-preview-so" style="color:#DC3545; border-color:#F1B0B7;" onclick="openCancelCreditModal();">
                            <i class="far fa-window-close"></i> ยกเลิกใบลดหนี้
                        </button>
                    <?php endif; ?>
                    <button type="button" class="btn-preview-so" onclick="openPrintReport();">
                        <img src="img/icons/preview.png" alt="preview" style="width: 16px; height: 16px;"> Preview
                    </button>
                </div>
            </div>

            <div class="so-tabs-container">
                <button type="button" class="so-tab-btn active">ข้อมูลเอกสาร</button>
            </div>

            <input type="hidden" name="ref_credit" value="<?php echo htmlspecialchars($refCreditFull, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="form_mode" value="<?php echo htmlspecialchars($mode, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="mode_cus" id="mode_cus" value="<?php echo $rs["mode_cus"] ?? ''; ?>">
            <input type="hidden" name="opener" value="<?php echo htmlspecialchars($opener); ?>">

            <!-- ฟิลด์ required ที่ไม่มีตำแหน่งใน Figma ปัจจุบัน (ผู้ขอคืนสินค้า/ผู้แทนขาย) — ซ่อนไว้ก่อนตามที่ตกลง -->
            <input type="hidden" name="send_return_name" id="send_return_name" value="">
            <input type="hidden" name="date_send_return" id="date_send_return" value="">
            <input type="hidden" name="sale_name" id="sale_name" value="">
            <input type="hidden" name="sale_date" id="sale_date" value="">

            <div id="tab-document-info" class="so-tab-content active">

                <div class="so-card">
                    <div class="so-grid-3">
                        <!-- บริษัท -->
                        <div class="so-field-group">
                            <label class="so-label" for="company_type">บริษัท<span style="color:#D32F2F;">*</span></label>
                            <div class="so-select-wrapper">
                                <?php $companyTypeVal = ($rs['company_type'] ?? '') !== '' ? $rs['company_type'] : '3'; ?>
                                <select class="so-select" name="company_type" id="company_type">
                                    <option value="3" <?php echo ($companyTypeVal === '3') ? 'selected' : ''; ?>>AWL</option>
                                    <option value="4" <?php echo ($companyTypeVal === '4') ? 'selected' : ''; ?>>NBM</option>
                                </select>
                            </div>
                        </div>

                        <!-- แผนก/เขตการขาย -->
                        <div class="so-field-group">
                            <label class="so-label" for="sale_code">แผนก/เขตการขาย</label>
                            <div class="so-select-wrapper">
                                <?php
                                $saleCodeQueries = array(
                                    'SS1' => "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC",
                                    'SS2' => "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC",
                                    'SS3' => "SELECT * FROM tb_team_ss3 WHERE ckk_1='0' ORDER BY sale_code ASC",
                                    'SS5' => "SELECT * FROM tb_team_ss3 WHERE sale_code IN ('S31','S32') ORDER BY sale_code ASC",
                                    'SUP_MK' => "SELECT * FROM tb_team_adm WHERE ckk='1' ORDER BY sale_code ASC",
                                    'SUP_EN' => "SELECT * FROM tb_team_en ORDER BY sale_code ASC"
                                );
                                $userSaleCode = isset($_SESSION['code']) ? $_SESSION['code'] : '';
                                $saleCodeSql = isset($saleCodeQueries[$userSaleCode]) ? $saleCodeQueries[$userSaleCode] : "SELECT * FROM tb_team_adm WHERE ckk='0' ORDER BY sale_code ASC";
                                $saleCodeQuery = mysqli_query($com, $saleCodeSql);
                                ?>
                                <select name="sale_code" id="sale_code" class="so-select">
                                    <option value="">เลือกแผนก/เขตการขาย</option>
                                    <?php if ($saleCodeQuery) { ?>
                                        <?php while ($saleCodeRow = mysqli_fetch_array($saleCodeQuery, MYSQLI_ASSOC)) { ?>
                                            <option value="<?php echo htmlspecialchars($saleCodeRow['sale_code'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($saleCodeRow['sale_code'] == ($rs['sale_code'] ?? '')) ? 'selected' : ''; ?>><?php echo htmlspecialchars($saleCodeRow['sale_code'] . ' - ' . $saleCodeRow['sale_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- ประเภทลดหนี้ -->
                        <div class="so-field-group">
                            <label class="so-label" for="ttype_doc">ประเภทการลดหนี้</label>
                            <div class="so-select-wrapper">
                                <?php $ttypeDocVal = ($rs['ttype_doc'] ?? '') !== '' ? $rs['ttype_doc'] : '1'; ?>
                                <select class="so-select" name="ttype_doc" id="ttype_doc">
                                    <option value="1" <?php echo ($ttypeDocVal === '1') ? 'selected' : ''; ?>>คืนสินค้า</option>
                                    <option value="2" <?php echo ($ttypeDocVal === '2') ? 'selected' : ''; ?>>ส่วนลด</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="so-card">
                    <div class="so-section-title-container">
                        <h2 class="so-section-title">ข้อมูลเอกสารอ้างอิง</h2>
                        <hr class="so-divider">
                    </div>

                    <div class="so-customer-top-grid">
                        <div class="so-customer-top-left">
                            <?php if ($mode !== 'create_blank') { ?>
                                <div class="so-doc-pill-wrapper">
                                    <button type="button" class="so-doc-pill" id="docRefPopupTrigger" onclick="openDocRefPopup()">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="so-doc-pill-icon">
                                            <path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="11.5" cy="14.5" r="2.5" stroke="currentColor" stroke-width="2" />
                                            <path d="M13.25 16.25L15.5 18.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        ข้อมูลเอกสาร
                                    </button>
                                </div>

                                <!-- เอกสารอ้างอิง (เลขที่ IV) -->
                                <div class="so-field-group">
                                    <label class="so-label" for="iv_no_ref">เอกสารอ้างอิง<span style="color:#D32F2F;">*</span></label>
                                    <div class="so-input-wrapper">
                                        <input type="text" name="iv_no_ref" id="iv_no_ref" value="<?php echo htmlspecialchars($ivNoEffective, ENT_QUOTES, 'UTF-8'); ?>" class="so-input">
                                        <button type="button" class="so-clear-icon" onclick="document.getElementById('iv_no_ref').value=''"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>

                                <!-- หมายเลขคำสั่งซื้อ (ref_id) -->
                                <div class="so-field-group">
                                    <label class="so-label" for="ref_id">หมายเลขคำสั่งซื้อ<span style="color:#D32F2F;">*</span></label>
                                    <div class="so-input-wrapper">
                                        <input type="text" name="ref_id" id="ref_id" value="<?php echo htmlspecialchars($rs["ref_id"] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="so-input">
                                        <button type="button" class="so-clear-icon" onclick="document.getElementById('ref_id').value=''"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <!-- โหมดสร้างแบบไม่มีเอกสารอ้างอิง: ไม่มี SO/IV ให้ผูก จึงไม่บังคับกรอก -->
                                <input type="hidden" name="iv_no_ref" id="iv_no_ref" value="">
                                <input type="hidden" name="ref_id" id="ref_id" value="">
                                <p class="credinot-no-ref-note">ใบลดหนี้นี้ไม่มีเอกสารอ้างอิง (SO/IV)</p>
                            <?php } ?>
                        </div>

                        <div class="so-customer-top-right">
                            <div class="so-field-group" style="height: 100%;">
                                <div class="credinot-customer-label-row">
                                    <label class="so-label">ข้อมูลลูกค้า</label>
                                    <?php if ($customerFieldsEditable) { ?>
                                        <button type="button" class="btn-run-credit-no" id="customerSearchPopupTrigger" onclick="openCustomerSearchPopup()">
                                            <i class="fas fa-search"></i> ค้นหาลูกค้า
                                        </button>
                                    <?php } ?>
                                </div>
                                <input type="hidden" name="bill_id" id="bill_id" value="<?php echo htmlspecialchars($billIdVal, ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="customer-info-display-card">
                                    <div class="cidc-col">
                                        <div class="cidc-row">
                                            <div class="cidc-label">รหัสสมาชิก</div>
                                            <div class="cidc-value">
                                                <span class="cidc-display-text" id="customer_no_display"><?php echo htmlspecialchars($customerNo, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">เบอร์โทรศัพท์</div>
                                            <div class="cidc-value">
                                                <input type="text" name="customer_tel" id="customer_tel" value="<?php echo htmlspecialchars($customerTelVal, ENT_QUOTES, 'UTF-8'); ?>" class="cidc-value-input" <?php echo $customerFieldsEditable ? '' : 'readonly'; ?>>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">สถานะลูกค้า</div>
                                            <div class="cidc-value">
                                                <img src="img/icons/vip.png" class="cidc-status-icon" id="customer_vip_icon" alt="VIP" style="<?php echo $customerIsVip ? '' : 'display:none;'; ?>">
                                                <span class="cidc-display-text" id="customer_status_display"><?php echo htmlspecialchars($customerStatusName, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cidc-col">
                                        <div class="cidc-row">
                                            <div class="cidc-label">ชื่อลูกค้า</div>
                                            <div class="cidc-value">
                                                <input type="text" name="customer_name" id="customer_name" value="<?php echo htmlspecialchars($customerNameVal, ENT_QUOTES, 'UTF-8'); ?>" class="cidc-value-input" <?php echo $customerFieldsEditable ? '' : 'readonly'; ?>>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">ประเภทลูกค้า</div>
                                            <div class="cidc-value">
                                                <span class="cidc-display-text" id="customer_type_display"><?php echo htmlspecialchars($customerTypeName, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">วงเงินเครดิต</div>
                                            <div class="cidc-value">
                                                <?php
                                                $formattedCredit = (is_numeric($customerCreditThb) && (float)$customerCreditThb > 0)
                                                    ? number_format((float)$customerCreditThb, 2)
                                                    : '0.00';
                                                ?>
                                                <span class="cidc-credit-term" id="customer_credit_display"><?php echo htmlspecialchars($formattedCredit, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ที่อยู่ -->
                            <div class="so-field-group" style="margin-top: 16px;">
                                <label class="so-label" for="address_name">ที่อยู่<span style="color:#D32F2F;">*</span></label>
                                <div class="so-input-wrapper">
                                    <input type="text" name="address_name" id="address_name" value="<?php echo htmlspecialchars($addressVal, ENT_QUOTES, 'UTF-8'); ?>" class="so-input">
                                    <button type="button" class="so-clear-icon" onclick="document.getElementById('address_name').value=''"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- การ์ดแก้ไขใบลดหนี้ E-Tax -->
                <div class="so-card">
                    <div class="so-section-title-container">
                        <h2 class="so-section-title">แก้ไขใบลดหนี้ E-Tax</h2>
                        <hr class="so-divider">
                    </div>

                    <div class="so-grid-3">
                        <!-- ครั้งที่ -->
                        <div class="so-field-group">
                            <label class="so-label" for="etax_count">ครั้งที่</label>
                            <?php $etaxCountVal = (!empty($rs['new_bill']) && $rs['new_bill'] !== '0') ? $rs['new_bill'] : ''; ?>
                            <div class="so-input-wrapper">
                                <input type="text" name="etax_count" id="etax_count" value="<?php echo htmlspecialchars($etaxCountVal, ENT_QUOTES, 'UTF-8'); ?>" placeholder="ใส่เฉพาะตัวเลข" class="so-input">
                            </div>
                        </div>

                        <!-- วันที่เอกสารเดิม -->
                        <div class="so-field-group">
                            <label class="so-label" for="etax_orig_date">วันที่เอกสารเดิม</label>
                            <div class="so-input-wrapper calendar-wrapper">
                                <input type="date" name="etax_orig_date" id="etax_orig_date" value="<?php echo htmlspecialchars($rs['date_oldbill'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="so-input">
                            </div>
                        </div>

                        <!-- หมายเหตุการแก้ไข -->
                        <div class="so-field-group" style="grid-column: 1 / -1;">
                            <label class="so-label" for="etax_edit_note">หมายเหตุการแก้ไข</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="etax_edit_note" id="etax_edit_note" value="<?php echo htmlspecialchars($rs['desnew_bill'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="กรอกหมายเหตุการแก้ไข" class="so-input">
                                <button type="button" class="so-clear-icon" onclick="document.getElementById('etax_edit_note').value=''"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="so-card">
                    <div class="so-section-title-container">
                        <h2 class="so-section-title">ข้อมูลการคืนสินค้า</h2>
                        <hr class="so-divider">
                    </div>

                    <div class="so-grid-3">
                        <!-- สาเหตุการคืน -->
                        <div class="so-field-group">
                            <label class="so-label" for="return_reason">สาเหตุการคืน</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="return_reason" id="return_reason" value="<?php echo htmlspecialchars($rs['return_des'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="กรอกสาเหตุการคืน" class="so-input">
                                <button type="button" class="so-clear-icon" onclick="document.getElementById('return_reason').value=''"><i class="fas fa-times"></i></button>
                            </div>
                        </div>

                        <!-- ผู้รับคืนสินค้า -->
                        <div class="so-field-group">
                            <label class="so-label" for="receive_name">ผู้รับคืนสินค้า<span style="color:#D32F2F;">*</span></label>
                            <div class="so-input-wrapper">
                                <input type="text" name="receive_name" id="receive_name" value="<?php echo htmlspecialchars($rs['receive_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="กรอกชื่อผู้รับคืนสินค้า" class="so-input" required>
                                <button type="button" class="so-clear-icon" onclick="document.getElementById('receive_name').value=''"><i class="fas fa-times"></i></button>
                            </div>
                        </div>

                        <!-- วันที่ -->
                        <div class="so-field-group">
                            <label class="so-label" for="date_receive">วันที่<span style="color:#D32F2F;">*</span></label>
                            <div class="so-input-wrapper calendar-wrapper">
                                <input type="date" name="date_receive" id="date_receive" value="<?php echo htmlspecialchars($rs['date_receive'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="so-input" required>
                            </div>
                        </div>

                        <!-- คำอธิบายเพิ่มเติม -->
                        <div class="so-field-group" style="grid-column: 1 / -1;">
                            <label class="so-label" for="return_des">คำอธิบายเพิ่มเติม</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="return_des" id="return_des" value="<?php echo htmlspecialchars($rs['remark_et'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="กรอกคำอธิบายเพิ่มเติม" class="so-input">
                                <button type="button" class="so-clear-icon" onclick="document.getElementById('return_des').value=''"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="so-card">
                    <div class="so-section-title-container">
                        <h2 class="so-section-title">ข้อมูลการชำระเงินคืน</h2>
                        <hr class="so-divider">
                    </div>

                    <div class="so-grid-3">
                        <!-- วันที่ลดหนี้ -->
                        <div class="so-field-group">
                            <label class="so-label" for="date_credit">วันที่ลดหนี้<span style="color:#D32F2F;">*</span></label>
                            <div class="so-input-wrapper calendar-wrapper">
                                <input type="date" name="date_credit" id="date_credit" value="<?php echo htmlspecialchars(!empty($rs['date_credit']) ? $rs['date_credit'] : $today, ENT_QUOTES, 'UTF-8'); ?>" class="so-input" required>
                            </div>
                        </div>

                        <!-- เลขที่ลดหนี้ + ปุ่ม Run เลขที่ -->
                        <div class="so-field-group">
                            <label class="so-label" for="credit_no">เลขที่ลดหนี้</label>
                            <div class="credit-no-row">
                                <div class="so-input-wrapper">
                                    <input type="text" name="credit_no" id="credit_no" value="<?php echo htmlspecialchars($rs['credit_no'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="No." class="so-input" readonly>
                                </div>
                                <button type="button" class="btn-run-credit-no" onclick="runCreditNo(this)">
                                    <img src="img/icons/doc.png" alt="" style="width: 16px; height: 16px;"> Run เลขที่
                                </button>
                            </div>
                        </div>

                        <!-- วิธีชำระเงินคืน -->
                        <div class="so-field-group">
                            <label class="so-label" for="type_return">วิธีชำระเงินคืน<span style="color:#D32F2F;">*</span></label>
                            <div class="so-select-wrapper">
                                <?php $typeReturnVal = $rs['type_return'] ?? ''; ?>
                                <select class="so-select" name="type_return" id="type_return" required>
                                    <option value="">เลือกวิธีชำระเงินคืน</option>
                                    <option value="1" <?php echo ($typeReturnVal === '1') ? 'selected' : ''; ?>>เงินสด</option>
                                    <option value="2" <?php echo ($typeReturnVal === '2') ? 'selected' : ''; ?>>โอนเงินเข้าบัญชี</option>
                                    <option value="3" <?php echo ($typeReturnVal === '3') ? 'selected' : ''; ?>>ลดหนี้จากยอดลูกหนี้ค้างชำระ</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="so-grid-3">
                        <!-- ธนาคาร -->
                        <div class="so-field-group">
                            <label class="so-label" for="bank_name">ธนาคาร</label>
                            <div class="so-select-wrapper">
                                <?php
                                // รายชื่อธนาคารของลูกค้า (ค่าที่บันทึกคือชื่อธนาคาร เพื่อให้เข้ากันได้กับข้อมูลเดิมที่เก็บเป็นข้อความอิสระ)
                                $bankNames = array(
                                    'ธนาคารกรุงเทพ',
                                    'ธนาคารกสิกรไทย',
                                    'ธนาคารไทยพาณิชย์',
                                    'ธนาคารกรุงไทย',
                                    'ธนาคารกรุงศรีอยุธยา',
                                    'ธนาคารทหารไทยธนชาต (ttb)',
                                    'ธนาคารเกียรตินาคินภัทร',
                                    'ธนาคารซีไอเอ็มบี ไทย',
                                    'ธนาคารยูโอบี',
                                    'ธนาคารออมสิน',
                                    'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร (ธ.ก.ส.)',
                                    'ธนาคารอาคารสงเคราะห์',
                                    'ธนาคารแลนด์ แอนด์ เฮ้าส์',
                                    'ธนาคารไทยเครดิต',
                                    'ธนาคารอิสลามแห่งประเทศไทย'
                                );
                                ?>
                                <?php $bankNameVal = $rs['bank_name'] ?? ''; ?>
                                <select class="so-select" name="bank_name" id="bank_name">
                                    <option value="">เลือกธนาคาร</option>
                                    <?php foreach ($bankNames as $bankName) { ?>
                                        <option value="<?php echo htmlspecialchars($bankName, ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($bankNameVal === $bankName) ? 'selected' : ''; ?>><?php echo htmlspecialchars($bankName, ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- เลขบัญชี -->
                        <div class="so-field-group">
                            <label class="so-label" for="account_no">เลขบัญชี</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="account_no" id="account_no" value="<?php echo htmlspecialchars($rs['account_no'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="ใส่เฉพาะตัวเลข" class="so-input">
                            </div>
                        </div>

                        <!-- ชื่อบัญชี -->
                        <div class="so-field-group">
                            <label class="so-label" for="account_name">ชื่อบัญชี</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="account_name" id="account_name" value="<?php echo htmlspecialchars($rs['account_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="กรอกชื่อบัญชี" class="so-input">
                                <button type="button" class="so-clear-icon" onclick="document.getElementById('account_name').value=''"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="so-grid-3">
                        <!-- แนบไฟล์ Book Bank -->
                        <div class="so-field-group">
                            <label class="so-label" for="book_bank">แนบไฟล์ Book Bank</label>
                            <label class="so-file-picker" for="book_bank">
                                <span class="so-file-picker-text" id="book_bank_text"><?php echo ($mode === 'edit' && !empty($rs['book_bank'])) ? htmlspecialchars($rs['book_bank'], ENT_QUOTES, 'UTF-8') : 'Choose File'; ?></span>
                                <i class="far fa-image so-file-picker-icon"></i>
                                <input type="file" name="book_bank" id="book_bank" class="so-file-picker-input" accept="image/*,application/pdf" onchange="showBookBankName(this)">
                            </label>
                            <!-- คงชื่อไฟล์ Book Bank เดิมไว้ ถ้าไม่ได้อัปโหลดไฟล์ใหม่ตอนแก้ไข -->
                            <input type="hidden" name="book_bank_existing" value="<?php echo htmlspecialchars($rs['book_bank'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                </div>

                <?php
                // เรนเดอร์แถวสินค้าลง buffer ก่อน เพื่อให้รู้จำนวนรายการ/ยอดรวมสำหรับ badge และ stat box ด้านบนตาราง
                ob_start();

                $i = 1;
                $item_count = 0;
                $grand_total_amount = 0;
                $total_qty = 0;

                if ($mode === 'create_so') {
                    while ($objResult1 = mysqli_fetch_array($objQuery1)) {


                        $sql3 = "SELECT sum(count) as count3   FROM  (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) where iv_no_ref = '" . $escIvNo . "' and product_id = '" . $objResult1['product_id'] . "' and status_doc IN ('Approve','Request')";
                        $qry3 = mysqli_query($conn, $sql3) or die(mysqli_error());

                        while ($rs3 = mysqli_fetch_assoc($qry3)) {

                            $count3 =  $rs3["count3"];

                            $count2 = $objResult1["count"] - $count3;


                ?>
                        <?php

                        }

                        ?>
                        <tr class="credinot-row" data-search-text="<?php echo htmlspecialchars(strtolower($objResult1['product_id'] . ' ' . $objResult1['sol_name']), ENT_QUOTES, 'UTF-8'); ?>" draggable="true" ondragstart="handleCreditItemDragStart(event)" ondragend="handleCreditItemDragEnd(event)" ondragover="handleCreditItemDragOver(event)" ondrop="handleCreditItemDrop(event)">
                            <?php
                            if ($count2 == '0') {
                            } else {
                                $sum_amount = ($objResult1["price"] - $objResult1["discount"]) * $count2;
                                $grand_total_amount += $sum_amount;
                                $item_count++;
                                $total_qty += (float)$count2;

                            ?>
                                <td class="credinot-code-col">
                                    <div class="credinot-code-cell-inner">
                                        <div class="credinot-row-controls-inner">
                                            <span class="credinot-drag-handle" title="ลากเพื่อจัดเรียง (ไม่บันทึกลงฐานข้อมูล)" aria-hidden="true"><i class="fas fa-grip-vertical"></i></span>
                                            <span class="credinot-select-dot" aria-hidden="true"></span>
                                            <button type="button" class="credinot-caret" aria-expanded="false" aria-label="ขยายรายละเอียด" onclick="toggleCreditItemDetail(this)">
                                                <i class="fas fa-caret-down"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="id[<?php echo $objResult1["id"]; ?>]" value="<?php echo $objResult1['id']; ?>">
                                        <input type="text" name="product_id[<?php echo $objResult1["id"]; ?>]" class="so-input credinot-code-input" value="<?php echo $objResult1['product_id']; ?>" readonly>
                                        <input type='hidden' name="product_code[<?php echo $objResult1["id"]; ?>]" value="<?php echo $objResult1["access_code"]; ?>" id="product_code[<?php echo $objResult1["id"]; ?>]">
                                    </div>
                                </td>

                                <td>
                                    <textarea name="product_name[<?php echo $objResult1["id"]; ?>]" id="product_name[<?php echo $objResult1["id"]; ?>]" class="so-textarea" readonly><?php echo $objResult1["sol_name"]; ?></textarea>
                                </td>

                                <td>
                                    <div class="credinot-qty-pill">
                                        <input type='text' name="count[<?php echo $objResult1["id"]; ?>]" value="<?php echo $count2; ?>" id="count[<?php echo $objResult1["id"]; ?>]" class="so-input" style="text-align:center" readonly />
                                    </div>
                                </td>

                                <td><input type='text' name="unit_price[<?php echo $objResult1["id"]; ?>]" value="<?php $price = $objResult1["price"];
                                                                                                                    echo number_format($price, 2) . ""; ?>" id="unit_price[<?php echo $objResult1["id"]; ?>]" class="so-input" style="text-align:right" readonly /></td>

                                <td>
                                    <input type='text' name="sum_amount[<?php echo $objResult1["id"]; ?>]" value="<?php echo number_format($sum_amount, 2) . ""; ?>" id="sum_amount[<?php echo $objResult1["id"]; ?>]" class="so-input" style="text-align:right" readonly />
                                    <?php
                                    // ส่วนลด/หน่วย ไม่แสดงในตารางตาม Design ใหม่ แต่ยังต้อง submit ค่าจริงจาก DB ไปด้วย
                                    // เพราะ register_credinot1.php ใช้ discount_unit[] คำนวณ sum_amount/sum_discount ตอนบันทึก
                                    $discount_unit = $objResult1["discount"];
                                    ?>
                                    <input type="hidden" name="discount_unit[<?php echo $objResult1["id"]; ?>]" value="<?php echo number_format($discount_unit, 2) . ""; ?>">
                                </td>

                                <td class="credinot-edit-col">
                                    <button type="button" class="credinot-edit-btn" title="แก้ไขรายการ" onclick="toggleCreditRowEdit(this)">
                                        <img src="img/icons/edit.png" alt="edit" style="width: 16px; height: 16px;">
                                    </button>
                                    <button type="button" class="credinot-delete-btn" title="ลบรายการ" onclick="removeNewCreditRow(this)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>


                        </tr>

                        <?php
                                // แยกเลข SN จากฟิลด์ hos__subso.sn (คั่นด้วย "/" ตามรูปแบบข้อมูลจริง) เพื่อแสดงเป็นแถวๆ ในรายละเอียดที่ขยายได้
                                // หมายเหตุ: Lot No. ใช้ค่าเดียวกันซ้ำทุกแถว เพราะ hos__subso เก็บ lot_no เป็นค่าเดียวต่อรายการ ไม่ได้ผูก 1:1 กับแต่ละ SN
                                // Exp. Date ปล่อยว่างไว้ เพราะไม่มีตารางข้อมูลจริงที่เชื่อมวันหมดอายุกับรายการนี้ได้
                                $snRaw = trim((string)$objResult1["sn"]);
                                $snList = array();
                                if ($snRaw !== '') {
                                    foreach (explode('/', $snRaw) as $snPiece) {
                                        $snPiece = trim($snPiece);
                                        if ($snPiece !== '') {
                                            $snList[] = $snPiece;
                                        }
                                    }
                                }
                                $lotNoDisplay = trim((string)$objResult1["lot_no"]);
                        ?>
                        <tr class="credinot-detail-row">
                            <td colspan="6">
                                <?php if (count($snList) > 0) { ?>
                                    <table class="credinot-sn-table">
                                        <thead>
                                            <tr>
                                                <th>หมายเลข SN</th>
                                                <th>Lot No.</th>
                                                <th>Exp. Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($snList as $snItem) { ?>
                                                <tr>
                                                    <td><i class="fas fa-check-circle" style="color: #612989; margin-right: 8px; font-size: 14px;"></i><?php echo htmlspecialchars($snItem, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($lotNoDisplay, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <div class="credinot-detail-empty">ไม่มีข้อมูลหมายเลข SN</div>
                                <?php } ?>
                            </td>
                        </tr>

                    <?php
                                $i++;
                            }
                        }
                    } elseif ($mode === 'edit') {
                        // โหมดแก้ไข: แสดงรายการจริงจาก tb_subcredit ตรงๆ ไม่คำนวณยอดคงเหลือ, มีปุ่มลบรายการ
                        while ($objResult1 = mysqli_fetch_array($objQuery1)) {
                            $rowId = $objResult1['id'];
                            $count2 = $objResult1['count'];
                            $unitPriceVal = (float)$objResult1['unit_price'];
                            $discountUnitVal = (float)$objResult1['discount_unit'];
                            $sum_amount = (float)$objResult1['sum_amount'];

                            $item_count++;
                            $total_qty += (float)$count2;
                            $grand_total_amount += $sum_amount;
                    ?>
                    <tr class="credinot-row" data-search-text="<?php echo htmlspecialchars(strtolower($objResult1['product_id'] . ' ' . ($objResult1['sol_name'] ?? '')), ENT_QUOTES, 'UTF-8'); ?>" draggable="true" ondragstart="handleCreditItemDragStart(event)" ondragend="handleCreditItemDragEnd(event)" ondragover="handleCreditItemDragOver(event)" ondrop="handleCreditItemDrop(event)">
                        <td class="credinot-code-col">
                            <div class="credinot-code-cell-inner">
                                <div class="credinot-row-controls-inner">
                                    <span class="credinot-drag-handle" title="ลากเพื่อจัดเรียง (ไม่บันทึกลงฐานข้อมูล)" aria-hidden="true"><i class="fas fa-grip-vertical"></i></span>
                                    <span class="credinot-select-dot" aria-hidden="true"></span>
                                </div>
                                <input type="hidden" name="id[<?php echo $rowId; ?>]" value="<?php echo $rowId; ?>">
                                <input type="text" name="product_id[<?php echo $rowId; ?>]" class="so-input credinot-code-input" value="<?php echo htmlspecialchars($objResult1['product_id'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                <input type='hidden' name="product_code[<?php echo $rowId; ?>]" value="<?php echo htmlspecialchars($objResult1['access_code'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </td>

                        <td>
                            <textarea name="product_name[<?php echo $rowId; ?>]" class="so-textarea" readonly><?php echo htmlspecialchars($objResult1['sol_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </td>

                        <td>
                            <div class="credinot-qty-pill">
                                <input type='text' name="count[<?php echo $rowId; ?>]" value="<?php echo htmlspecialchars($count2, ENT_QUOTES, 'UTF-8'); ?>" class="so-input" style="text-align:center" <?php echo $creditItemsLocked ? 'readonly' : ''; ?>>
                            </div>
                        </td>

                        <td><input type='text' name="unit_price[<?php echo $rowId; ?>]" value="<?php echo number_format($unitPriceVal, 2); ?>" class="so-input" style="text-align:right" <?php echo $creditItemsLocked ? 'readonly' : ''; ?>></td>

                        <td>
                            <input type='text' name="sum_amount[<?php echo $rowId; ?>]" value="<?php echo number_format($sum_amount, 2); ?>" class="so-input" style="text-align:right" readonly />
                            <input type="hidden" name="discount_unit[<?php echo $rowId; ?>]" value="<?php echo number_format($discountUnitVal, 2); ?>">
                        </td>

                        <td class="credinot-edit-col">
                            <?php if (!$creditItemsLocked) { ?>
                                <button type="button" class="credinot-delete-btn" title="ลบรายการ" onclick="deleteCreditSubRow(this, <?php echo (int)$rowId; ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            <?php } ?>
                        </td>
                    </tr>
            <?php
                            $i++;
                        }
                    }
                    // โหมดสร้างแบบไม่มีเอกสารอ้างอิง: ไม่มีรายการตั้งต้น ผู้ใช้เพิ่มเองผ่าน modal "เพิ่มสินค้า"
            ?>

            <?php
            $tbodyHtml = ob_get_clean();
            ?>

            <div class="so-card">
                <div class="so-section-title-container credinot-title-row">
                    <h2 class="so-section-title">รายการสินค้า</h2>
                    <span class="credinot-count-badge"><?php echo $item_count; ?> รายการ</span>
                </div>
                <hr class="so-divider">

                <div class="credinot-stat-grid">
                    <div class="credinot-stat-box">
                        <span class="credinot-stat-label">จำนวนรวม(ชิ้น)</span>
                        <span class="credinot-stat-value"><?php echo number_format($total_qty); ?></span>
                    </div>
                    <div class="credinot-stat-box is-highlight">
                        <span class="credinot-stat-label">ยอดรวมสุทธิ</span>
                        <span class="credinot-stat-value"><?php echo number_format($grand_total_amount, 2); ?></span>
                    </div>
                </div>

                <?php if (!$creditItemsLocked) { ?>
                    <div class="so-field-group credinot-search-wrap">
                        <label class="so-label" for="credinot_search">ค้นหารายการสินค้า</label>
                        <div class="customer-popup-search pf-search-bar">
                            <i class="fas fa-search"></i>
                            <input type="text" id="credinot_search" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า" autocomplete="off"
                                oninput="filterCreditNoteRows(this.value); handleCreditSearchSuggestInput(this.value);"
                                onfocus="if (this.value.trim() !== '') handleCreditSearchSuggestInput(this.value);">
                        </div>
                        <div id="credinotSearchSuggest" class="credinot-search-suggest" style="display:none;"></div>
                    </div>
                <?php } ?>

                <div class="credinot-table-wrap">
                    <table class="credinot-table">
                        <thead>
                            <tr>
                                <th>รหัสสินค้า</th>
                                <th>รายการสินค้า</th>
                                <th style="text-align: center;">จำนวน</th>
                                <th style="text-align: right;">ราคา/หน่วย</th>
                                <th style="text-align: right;">ยอดรวม</th>
                                <th class="credinot-edit-col"></th>
                            </tr>
                        </thead>
                        <tbody id="credinotTableBody">
                            <?php echo $tbodyHtml; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            </div><!-- /#tab-document-info -->

        </div>

        <div class="so-sticky-actions">
            <div class="so-sticky-actions-inner">
                <?php if ($creditCanShowApproveBar): ?>
                    <div class="credinot-approve-actions" style="display: flex; gap: 16px; align-items: center; position: relative;">
                        <button type="button" class="credinot-approve-overflow-trigger" id="btn_credinot_approve_overflow" onclick="toggleCreditApproveOverflowMenu()" style="background: white; border: 1px solid #EBEBEB; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #612989;">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div id="creditApproveOverflowMenu" class="credinot-approve-overflow-menu" style="display:none; position: absolute; bottom: 48px; left: 0; background: white; border: 1px solid #EBEBEB; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden; z-index: 10; min-width: 160px;">
                            <?php if ($creditBucket === 1 || $creditBucket === 2): ?>
                                <button type="submit" name="approve_action" value="return" formnovalidate style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; font-family: 'Prompt', sans-serif; font-size: 14px; color: #4A4A4A; cursor: pointer;"><i class="fas fa-reply" style="width:16px;"></i> ส่งกลับ</button>
                                <button type="submit" name="approve_action" value="reject" formnovalidate style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; font-family: 'Prompt', sans-serif; font-size: 14px; color: #DC3545; cursor: pointer;"><i class="fas fa-times-circle" style="width:16px;"></i> ไม่อนุมัติ</button>
                            <?php endif; ?>
                            <button type="submit" name="approve_action" value="cancel" formnovalidate style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; font-family: 'Prompt', sans-serif; font-size: 14px; color: #4A4A4A; cursor: pointer;"><i class="far fa-window-close" style="width:16px;"></i> ยกเลิกเอกสาร</button>
                        </div>
                        <?php if ($creditBucket === 0): ?>
                            <button type="submit" name="approve_action" value="send_sup" style="background-color: #E8F9EE; color: #1E9E4F; border: 1px solid #C7EED4; border-radius: 24px; padding: 10px 28px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; height: 40px;">
                                <i class="far fa-paper-plane"></i> ส่งให้ SUP อนุมัติ
                            </button>
                        <?php else: ?>
                            <button type="submit" name="approve_action" value="approve" style="background-color: #E8F9EE; color: #1E9E4F; border: 1px solid #C7EED4; border-radius: 24px; padding: 10px 28px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; height: 40px;">
                                <i class="far fa-check-circle"></i> อนุมัติ
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if (!$creditItemsLocked) { ?>
                    <button type="submit" name="submit" value="submit" class="btn-so-submit">
                        <i class="far fa-paper-plane"></i> Submit
                    </button>
                <?php } ?>
                <button type="button" class="btn-so-draft" onclick="if (window.opener && typeof window.opener.handleCreditNoteCreated === 'function') { window.close(); } else { window.history.back(); }">
                    ยกเลิก
                </button>
            </div>
        </div>

        <?php if ($creditCanShowApproveBar): ?>
            <script>
                function toggleCreditApproveOverflowMenu() {
                    var menu = document.getElementById('creditApproveOverflowMenu');
                    if (!menu) return;
                    menu.style.display = (menu.style.display === 'none' || !menu.style.display) ? 'block' : 'none';
                }
                document.addEventListener('click', function(e) {
                    var menu = document.getElementById('creditApproveOverflowMenu');
                    var trigger = document.getElementById('btn_credinot_approve_overflow');
                    if (!menu || menu.style.display === 'none') return;
                    if (e.target === trigger || (trigger && trigger.contains(e.target))) return;
                    if (!menu.contains(e.target)) menu.style.display = 'none';
                });
            </script>
        <?php endif; ?>
    </form>

    <!-- Modal เอกสารอ้างอิง: ค้นหา/เลือกใบสั่งขายที่จะใช้เป็นเอกสารอ้างอิงของใบลดหนี้ -->
    <div id="docRefPopupModal" class="customer-popup-modal" aria-hidden="true">
        <div class="customer-popup-box docref-popup-box" role="dialog" aria-modal="true" aria-labelledby="docRefPopupTitle">
            <button type="button" class="customer-popup-close" onclick="closeDocRefPopup()" aria-label="Close">&times;</button>

            <div class="clear-loan-header">
                <h2 id="docRefPopupTitle">เอกสารอ้างอิง</h2>
                <div class="customer-popup-toolbar docref-popup-toolbar" style="margin-top: 18px;">
                    <div class="customer-popup-search-wrap">
                        <label for="docRefPopupSearch">ค้นหาเอกสาร</label>
                        <div class="customer-popup-search">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <input type="text" id="docRefPopupSearch" placeholder="ค้นหาด้วยชื่อ / เบอร์โทร / เลขที่เอกสาร">
                        </div>
                    </div>
                    <div class="docref-type-wrap">
                        <label for="docRefPopupType">ประเภทเอกสาร</label>
                        <div class="so-select-wrapper">
                            <!-- รอบนี้รองรับเฉพาะใบสั่งขาย จึงล็อกไว้ตัวเลือกเดียวตามที่ตกลง -->
                            <select class="so-select" id="docRefPopupType">
                                <option value="so" selected>ใบสั่งขาย (IV/IE/ET/IC/AI/AR)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="customer-popup-table-wrap">
                <table class="customer-popup-table docref-popup-table">
                    <thead>
                        <tr>
                            <th scope="col" aria-label="ขยายรายละเอียด"></th>
                            <th scope="col">เลขที่เอกสาร</th>
                            <th scope="col">หมายเลขคำสั่งซื้อ</th>
                            <th scope="col">ชื่อลูกค้า</th>
                            <th scope="col">ช่องทางการขาย</th>
                            <th scope="col">เขตการขาย</th>
                        </tr>
                    </thead>
                    <tbody id="docRefPopupRows">
                        <tr>
                            <td colspan="6" class="customer-popup-empty">พิมพ์เพื่อค้นหาเอกสาร</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="customer-popup-pagination" id="docRefPopupPagination" style="display:none;">
                <button type="button" class="customer-popup-loadmore" id="docRefPopupLoadMore" onclick="loadMoreDocRefRows()">โหลดเพิ่ม</button>
            </div>

            <div class="customer-popup-actions">
                <button type="button" class="customer-popup-confirm" onclick="confirmDocRefSelection()">ตกลง</button>
                <button type="button" class="customer-popup-cancel docref-cancel" onclick="closeDocRefPopup()">ย้อนกลับ</button>
            </div>
        </div>
    </div>

    <!-- Modal ค้นหาลูกค้า: ใช้เฉพาะโหมดสร้างใบลดหนี้แบบไม่มีเอกสารอ้างอิง -->
    <div id="customerSearchPopupModal" class="customer-popup-modal" aria-hidden="true">
        <div class="customer-popup-box" role="dialog" aria-modal="true" aria-labelledby="customerSearchPopupTitle">
            <button type="button" class="customer-popup-close" onclick="closeCustomerSearchPopup()" aria-label="Close">&times;</button>

            <div class="clear-loan-header">
                <h2 id="customerSearchPopupTitle">ค้นหาลูกค้า</h2>
                <div class="customer-popup-toolbar" style="margin-top: 18px;">
                    <div class="customer-popup-search-wrap">
                        <label for="customerSearchPopupSearch">ค้นหาลูกค้า</label>
                        <div class="customer-popup-search">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <input type="text" id="customerSearchPopupSearch" placeholder="ค้นหาด้วยชื่อ / เบอร์โทร / รหัสสมาชิก">
                        </div>
                    </div>
                </div>
            </div>

            <div class="customer-popup-table-wrap">
                <table class="customer-popup-table">
                    <thead>
                        <tr>
                            <th scope="col">ชื่อลูกค้า</th>
                            <th scope="col">เบอร์โทรศัพท์</th>
                            <th scope="col">ที่อยู่</th>
                        </tr>
                    </thead>
                    <tbody id="customerSearchPopupRows">
                        <tr>
                            <td colspan="3" class="customer-popup-empty">พิมพ์เพื่อค้นหาลูกค้า</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="customer-popup-pagination" id="customerSearchPopupPagination" style="display:none;">
                <button type="button" class="customer-popup-loadmore" id="customerSearchPopupLoadMore" onclick="loadMoreCustomerSearchRows()">โหลดเพิ่ม</button>
            </div>

            <div class="customer-popup-actions">
                <button type="button" class="customer-popup-confirm" onclick="confirmCustomerSearchSelection()">ตกลง</button>
                <button type="button" class="customer-popup-cancel" onclick="closeCustomerSearchPopup()">ย้อนกลับ</button>
            </div>
        </div>
    </div>

    <!-- Modal ค้นหาสินค้า: ใช้เพิ่มรายการสินค้าด้วยตัวเอง (โหมดแก้ไข/สร้างแบบไม่มีเอกสารอ้างอิง) -->
    <div id="productSearchPopupModal" class="customer-popup-modal" aria-hidden="true">
        <div class="customer-popup-box" role="dialog" aria-modal="true" aria-labelledby="productSearchPopupTitle">
            <button type="button" class="customer-popup-close" onclick="closeProductSearchPopup()" aria-label="Close">&times;</button>

            <div class="clear-loan-header">
                <h2 id="productSearchPopupTitle">เพิ่มสินค้า</h2>
                <div class="customer-popup-toolbar" style="margin-top: 18px;">
                    <div class="customer-popup-search-wrap">
                        <label for="productSearchPopupSearch">ค้นหาสินค้า</label>
                        <div class="customer-popup-search">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <input type="text" id="productSearchPopupSearch" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า">
                        </div>
                    </div>
                </div>
            </div>

            <div class="customer-popup-table-wrap">
                <table class="customer-popup-table">
                    <thead>
                        <tr>
                            <th scope="col">รหัสสินค้า</th>
                            <th scope="col">รายการสินค้า</th>
                            <th scope="col">หน่วย</th>
                            <th scope="col" style="text-align:right;">ราคา/หน่วย</th>
                        </tr>
                    </thead>
                    <tbody id="productSearchPopupRows">
                        <tr>
                            <td colspan="4" class="customer-popup-empty">พิมพ์เพื่อค้นหาสินค้า</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="customer-popup-pagination" id="productSearchPopupPagination" style="display:none;">
                <button type="button" class="customer-popup-loadmore" id="productSearchPopupLoadMore" onclick="loadMoreProductSearchRows()">โหลดเพิ่ม</button>
            </div>

            <div class="customer-popup-actions">
                <button type="button" class="customer-popup-cancel" onclick="closeProductSearchPopup()">ปิด</button>
            </div>
        </div>
    </div>



    <script>
        // ดึงเลขที่ลดหนี้ถัดไปจากฐานข้อมูล (รูปแบบเดียวกับเลขที่อ้างอิงหัวเอกสาร)
        function runCreditNo(btn) {
            var creditNoInput = document.getElementById('credit_no');
            var formModeInput = document.querySelector('input[name="form_mode"]');
            var formMode = formModeInput ? formModeInput.value : '';

            // โหมดแก้ไข: ถ้ามีเลขที่ลดหนี้อยู่แล้ว เตือนก่อนทับ กันออกเลขใหม่ทับเลขที่เคยใช้จริงไปแล้วโดยไม่ตั้งใจ
            if (formMode === 'edit' && creditNoInput && String(creditNoInput.value || '').trim() !== '') {
                var confirmMsg = 'ใบลดหนี้นี้มีเลขที่ลดหนี้อยู่แล้ว (' + creditNoInput.value + ')\nต้องการออกเลขที่ใหม่ทับเลขเดิมใช่หรือไม่?';
                if (!confirm(confirmMsg)) return;
            }

            btn.disabled = true;
            fetch('get_next_credit_no.php', {
                    cache: 'no-store'
                })
                .then(function(res) {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                })
                .then(function(data) {
                    if (!data.credit_no) throw new Error('ไม่พบเลขที่ลดหนี้');
                    document.getElementById('credit_no').value = data.credit_no;
                })
                .catch(function() {
                    Swal.fire({
                        title: 'ไม่สามารถดึงเลขที่ลดหนี้ได้',
                        text: 'กรุณาลองใหม่อีกครั้ง',
                        icon: 'error',
                        confirmButtonColor: '#612989',
                        confirmButtonText: 'ตกลง'
                    });
                })
                .finally(function() {
                    btn.disabled = false;
                });
        }

        // แสดงชื่อไฟล์ที่เลือกในกล่องแนบไฟล์ Book Bank (จำกัดขนาดไม่เกิน 2 MB)
        function showBookBankName(input) {
            var label = document.getElementById('book_bank_text');
            if (input.files && input.files.length > 0) {
                var file = input.files[0];
                var maxSize = 2 * 1024 * 1024; // 2 MB
                if (file.size > maxSize) {
                    Swal.fire({
                        title: 'ขนาดไฟล์เกินกำหนด',
                        text: 'ขนาดไฟล์ Book Bank ต้องไม่เกิน 2 MB ครับ',
                        icon: 'warning',
                        confirmButtonColor: '#612989',
                        confirmButtonText: 'ตกลง'
                    });
                    input.value = '';
                    label.textContent = 'Choose File';
                    label.classList.remove('has-file');
                    return;
                }
                label.textContent = file.name;
                label.classList.add('has-file');
            } else {
                label.textContent = 'Choose File';
                label.classList.remove('has-file');
            }
        }

        /* ===== Autocomplete แทรกสินค้าใหม่จากช่องค้นหา #credinot_search (ทำงานควบคู่กับ filterCreditNoteRows ด้านล่าง) ===== */
        var creditSearchSuggestTimer = null;
        var creditSearchSuggestData = [];
        var creditSearchSuggestAbort = null;
        var creditSearchSuggestReqId = 0;
        var creditSearchSuggestKeyword = '';

        function handleCreditSearchSuggestInput(keyword) {
            clearTimeout(creditSearchSuggestTimer);
            if (!keyword || keyword.trim() === '') {
                hideCreditSearchSuggest();
                return;
            }
            creditSearchSuggestTimer = setTimeout(function() {
                fetchCreditSearchSuggest(keyword.trim());
            }, 250);
        }

        function fetchCreditSearchSuggest(keyword) {
            if (creditSearchSuggestAbort) {
                creditSearchSuggestAbort.abort();
            }
            creditSearchSuggestAbort = new AbortController();
            var requestController = creditSearchSuggestAbort;
            var requestId = ++creditSearchSuggestReqId;
            creditSearchSuggestKeyword = keyword;

            showCreditSearchSuggestMessage('กำลังค้นหา...');

            fetch('ajax_credinot_product_search.php?q=' + encodeURIComponent(keyword) + '&limit=8', {
                    credentials: 'same-origin',
                    signal: requestController.signal
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (requestId !== creditSearchSuggestReqId) return;
                    if (!data || !data.success) {
                        renderCreditSearchSuggest([]);
                        return;
                    }
                    renderCreditSearchSuggest(data.products || []);
                })
                .catch(function(error) {
                    if (error && error.name === 'AbortError') return;
                    if (requestId !== creditSearchSuggestReqId) return;
                    showCreditSearchSuggestMessage('ไม่สามารถค้นหาข้อมูลได้');
                });
        }

        function renderCreditSearchSuggest(products) {
            var box = document.getElementById('credinotSearchSuggest');
            if (!box) return;

            creditSearchSuggestData = products || [];

            if (creditSearchSuggestData.length === 0) {
                showCreditSearchSuggestMessage('ไม่พบสินค้า');
                return;
            }

            box.innerHTML = creditSearchSuggestData.map(function(prod, index) {
                var displayName = highlightCreditSearchKeyword(prod.sol_name || '-', creditSearchSuggestKeyword);
                return '<div class="credinot-search-suggest-item" onclick="pickCreditSearchSuggest(' + index + ')">' +
                    displayName +
                    '</div>';
            }).join('');
            box.style.display = '';
        }

        // ทำตัวหนาคำที่ตรงกับคำค้น เลียนแบบ logic ฝั่ง PHP ใน data_pro_notdemoth.php:44-46 (ที่ใช้กับ product_salehos.php)
        function highlightCreditSearchKeyword(text, keyword) {
            var safeText = escapeDocRefHtml(text);
            var trimmedKeyword = (keyword || '').trim();
            if (trimmedKeyword === '') return safeText;

            var safeKeyword = escapeDocRefHtml(trimmedKeyword).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            var re = new RegExp('(' + safeKeyword + ')', 'giu');
            return safeText.replace(re, '<b>$1</b>');
        }

        function showCreditSearchSuggestMessage(message) {
            var box = document.getElementById('credinotSearchSuggest');
            if (!box) return;
            box.innerHTML = '<div class="credinot-search-suggest-empty">' + escapeDocRefHtml(message) + '</div>';
            box.style.display = '';
        }

        function hideCreditSearchSuggest() {
            var box = document.getElementById('credinotSearchSuggest');
            if (!box) return;
            box.style.display = 'none';
        }

        function pickCreditSearchSuggest(index) {
            var prod = (creditSearchSuggestData || [])[index];
            if (!prod) return;

            addProductRowToTable(prod);

            var search = document.getElementById('credinot_search');
            if (search) {
                search.value = '';
                search.focus();
            }
            filterCreditNoteRows('');
            hideCreditSearchSuggest();
        }

        // ค้นหารายการสินค้าในตาราง (กรองด้วยรหัสสินค้า/ชื่อสินค้า)
        function filterCreditNoteRows(keyword) {
            var q = keyword.trim().toLowerCase();
            document.querySelectorAll('.credinot-row').forEach(function(row) {
                var text = row.getAttribute('data-search-text') || '';
                var matches = (q === '' || text.indexOf(q) !== -1);
                row.style.display = matches ? '' : 'none';

                var detailRow = row.nextElementSibling;
                if (!matches && detailRow && detailRow.classList.contains('credinot-detail-row')) {
                    // พับรายละเอียดที่เปิดค้างไว้ก่อนซ่อนแถวหลัก กันสถานะค้าง
                    detailRow.classList.remove('is-open');
                    row.classList.remove('is-open');
                    var caretBtn = row.querySelector('.credinot-caret');
                    if (caretBtn) {
                        caretBtn.setAttribute('aria-expanded', 'false');
                        var icon = caretBtn.querySelector('i');
                        if (icon) icon.className = 'fas fa-caret-down';
                    }
                }
            });
        }

        /* ===== ลากจัดเรียงรายการสินค้า (client-side เท่านั้น ไม่บันทึกลงฐานข้อมูล — reset เมื่อ reload) ===== */
        var creditItemDragRow = null;

        function handleCreditItemDragStart(event) {
            creditItemDragRow = event.currentTarget;
            event.dataTransfer.effectAllowed = 'move';
            // Firefox ต้องเรียก setData ก่อน ไม่งั้น drag จะไม่เริ่ม
            event.dataTransfer.setData('text/plain', '');
            creditItemDragRow.classList.add('is-dragging');
        }

        function handleCreditItemDragEnd(event) {
            event.currentTarget.classList.remove('is-dragging');
            document.querySelectorAll('.credinot-row.is-drop-target').forEach(function(row) {
                row.classList.remove('is-drop-target');
            });
            creditItemDragRow = null;
        }

        function handleCreditItemDragOver(event) {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'move';
            var targetRow = event.currentTarget;
            if (!creditItemDragRow || targetRow === creditItemDragRow) return;

            document.querySelectorAll('.credinot-row.is-drop-target').forEach(function(row) {
                row.classList.remove('is-drop-target');
            });
            targetRow.classList.add('is-drop-target');
        }

        function handleCreditItemDrop(event) {
            event.preventDefault();
            var targetRow = event.currentTarget;
            targetRow.classList.remove('is-drop-target');
            if (!creditItemDragRow || creditItemDragRow === targetRow) return;

            var tbody = targetRow.parentNode;
            if (!tbody) return;

            // ย้ายแถวหลักที่ลาก พร้อมแถวรายละเอียด (ถ้ามี) ไปวางก่อนแถวเป้าหมาย เพื่อให้ทั้งคู่ยังติดกัน
            var dragDetail = creditItemDragRow.nextElementSibling;
            var dragDetailIsPair = dragDetail && dragDetail.classList.contains('credinot-detail-row');

            tbody.insertBefore(creditItemDragRow, targetRow);
            if (dragDetailIsPair) {
                tbody.insertBefore(dragDetail, targetRow);
            }
        }

        // พับ/กางแถวรายละเอียด (หมายเลข SN / Lot No. / Exp. Date) ของรายการสินค้า พร้อมสลับทิศทางลูกศร
        function toggleCreditItemDetail(btn) {
            var mainRow = btn.closest('tr');
            if (!mainRow) return;
            var detailRow = mainRow.nextElementSibling;
            if (!detailRow || !detailRow.classList.contains('credinot-detail-row')) return;

            var willOpen = !detailRow.classList.contains('is-open');
            detailRow.classList.toggle('is-open', willOpen);
            mainRow.classList.toggle('is-open', willOpen);

            btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            var icon = btn.querySelector('i');
            if (icon) {
                icon.className = willOpen ? 'fas fa-caret-up' : 'fas fa-caret-down';
            }
        }

        // สลับสถานะแก้ไข/อ่านอย่างเดียว ของแถวสินค้า (จำนวน, ราคา/หน่วย)
        // หมายเหตุ: ส่วนลด/หน่วย ไม่แสดงในตารางแล้วตาม Design ใหม่ จึงไม่อยู่ในชุดฟิลด์ที่แก้ไขได้นี้อีกต่อไป (ค่ายังถูก submit แบบ hidden ตามเดิม)
        function toggleCreditRowEdit(btn) {
            var row = btn.closest('tr');
            if (!row) return;
            var fields = row.querySelectorAll('input[name^="count"], input[name^="unit_price"]');
            var willEdit = fields.length > 0 && fields[0].hasAttribute('readonly');
            fields.forEach(function(field) {
                if (willEdit) {
                    field.removeAttribute('readonly');
                } else {
                    field.setAttribute('readonly', 'readonly');
                }
            });
            btn.classList.toggle('is-active', willEdit);
            if (willEdit && fields.length) {
                fields[0].focus();
            }
        }

        // ดูตัวอย่างรายงานใบลดหนี้ (Preview)
        // report_credit_adm.php อ่าน ref_credit จาก $_GET เท่านั้น (ดู pattern เดียวกันใน status_credit_admall.php)
        // จึงเปิดลิงก์ตรงแทนการ submit ฟอร์ม เพราะปลายทางไม่อ่านค่าจาก POST body เลย
        var creditPreviewRefCredit = <?php echo json_encode($refCreditFull); ?>;

        function openPrintReport() {
            window.open('report_credit_adm.php?ref_credit=' + encodeURIComponent(creditPreviewRefCredit), '_blank');
        }

        /* ===== Modal เอกสารอ้างอิง (ล้อ pattern เดียวกับ js/customer-popup.js) ===== */
        var docRefSelected = null;
        var docRefTimer = null;
        var docRefData = [];
        var docRefKeyword = '';
        var docRefNextLastId = null;
        var docRefHasMore = false;
        var docRefLoading = false;
        var docRefPageSize = 20;
        var docRefAbortController = null;
        var docRefRequestId = 0;

        function openDocRefPopup() {
            var modal = document.getElementById('docRefPopupModal');
            var search = document.getElementById('docRefPopupSearch');
            if (!modal) return;

            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            docRefSelected = null;
            docRefData = [];
            docRefKeyword = search ? (search.value || '') : '';
            docRefNextLastId = null;
            docRefHasMore = false;
            toggleDocRefLoadMore(false, false);

            loadDocRefRows(docRefKeyword, false);
            setTimeout(function() {
                if (search) {
                    search.focus();
                    search.select();
                }
            }, 50);
        }

        function closeDocRefPopup() {
            var modal = document.getElementById('docRefPopupModal');
            if (!modal) return;

            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        }

        function toggleDocRefLoadMore(visible, loading) {
            var wrap = document.getElementById('docRefPopupPagination');
            var button = document.getElementById('docRefPopupLoadMore');
            if (!wrap || !button) return;

            wrap.style.display = visible ? 'flex' : 'none';
            button.disabled = !!loading;
            button.textContent = loading ? 'กำลังโหลด...' : 'โหลดเพิ่ม';
        }

        function loadDocRefRows(keyword, append) {
            var tbody = document.getElementById('docRefPopupRows');
            if (append && docRefLoading) return;

            // ยกเลิก request ค้างเมื่อเริ่มค้นหาใหม่ เพื่อกันผลลัพธ์เก่ามาทับ
            if (!append && docRefAbortController) {
                docRefAbortController.abort();
            }

            docRefAbortController = new AbortController();
            var requestController = docRefAbortController;
            var requestId = ++docRefRequestId;
            docRefLoading = true;

            if (!append && tbody) {
                tbody.innerHTML = '<tr><td colspan="6" class="customer-popup-empty">กำลังค้นหา...</td></tr>';
            }

            if (!append) {
                docRefSelected = null;
                docRefData = [];
                docRefNextLastId = null;
                docRefHasMore = false;
                docRefKeyword = keyword || '';
            }

            toggleDocRefLoadMore(append || docRefHasMore, append);

            var requestUrl = 'ajax_credinot_doc_search.php?q=' + encodeURIComponent(docRefKeyword || '') +
                '&limit=' + encodeURIComponent(docRefPageSize);

            if (append && docRefNextLastId) {
                requestUrl += '&last_id=' + encodeURIComponent(docRefNextLastId);
            }

            fetch(requestUrl, {
                    credentials: 'same-origin',
                    signal: requestController.signal
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (requestId !== docRefRequestId) return;

                    if (!data || !data.success) {
                        docRefData = [];
                        docRefHasMore = false;
                        docRefNextLastId = null;
                        renderDocRefRows([]);
                        return;
                    }

                    var newDocs = data.docs || [];
                    docRefData = append ? docRefData.concat(newDocs) : newDocs;
                    docRefHasMore = !!(data.pagination && data.pagination.has_more);
                    docRefNextLastId = data.pagination ? data.pagination.next_last_id : null;
                    renderDocRefRows(docRefData);
                })
                .catch(function(error) {
                    if (error && error.name === 'AbortError') return;
                    if (requestId !== docRefRequestId) return;

                    docRefHasMore = false;
                    docRefNextLastId = null;
                    if (tbody) {
                        tbody.innerHTML = '<tr><td colspan="6" class="customer-popup-empty">ไม่สามารถค้นหาข้อมูลได้</td></tr>';
                    }
                    toggleDocRefLoadMore(false, false);
                })
                .finally(function() {
                    if (requestId !== docRefRequestId) return;

                    docRefLoading = false;
                    docRefAbortController = null;
                    if (docRefHasMore) {
                        toggleDocRefLoadMore(true, false);
                    }
                });
        }

        function escapeDocRefHtml(value) {
            return String(value === null || value === undefined ? '' : value).replace(/[&<>"']/g, function(char) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                } [char];
            });
        }

        function renderDocRefRows(docs) {
            var tbody = document.getElementById('docRefPopupRows');
            if (!tbody) return;

            docs = docs || docRefData || [];

            if (!docs || docs.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="customer-popup-empty">ไม่พบข้อมูลเอกสาร</td></tr>';
                toggleDocRefLoadMore(false, false);
                return;
            }

            // แต่ละเอกสารประกอบด้วย 2 แถว: แถวหลัก + แถวรายละเอียด (ที่อยู่/เบอร์โทร) ที่ซ่อนไว้
            tbody.innerHTML = docs.map(function(doc, index) {
                var docNo = doc.iv_no || '-';
                var refId = doc.ref_id || '-';
                var billName = doc.bill_name || '-';
                var channel = doc.sale_channel_name || '-';
                var saleCode = doc.sale_code || '-';
                var address = doc.bill_address || '-';
                var tel = doc.bill_tel || '-';

                return '<tr class="docref-main-row" data-index="' + index + '" onclick="selectDocRefRow(' + index + ')">' +
                    '<td class="docref-caret-col"><button type="button" class="docref-caret" aria-expanded="false" aria-label="ขยายรายละเอียด" onclick="event.stopPropagation(); toggleDocRefDetail(' + index + ');"><i class="fas fa-caret-down"></i></button></td>' +
                    '<td><button type="button" class="docref-doc-no" onclick="event.stopPropagation(); selectDocRefRow(' + index + ');">' + escapeDocRefHtml(docNo) + '</button></td>' +
                    '<td>' + escapeDocRefHtml(refId) + '</td>' +
                    '<td>' + escapeDocRefHtml(billName) + '</td>' +
                    '<td>' + escapeDocRefHtml(channel) + '</td>' +
                    '<td>' + escapeDocRefHtml(saleCode) + '</td>' +
                    '</tr>' +
                    '<tr class="docref-detail-row" data-detail-index="' + index + '">' +
                    '<td colspan="6">' +
                    '<div class="docref-detail-grid">' +
                    '<div class="docref-detail-item"><span class="docref-detail-label">ที่อยู่</span><span class="docref-detail-value">' + escapeDocRefHtml(address) + '</span></div>' +
                    '<div class="docref-detail-item"><span class="docref-detail-label">เบอร์โทร</span><span class="docref-detail-value">' + escapeDocRefHtml(tel) + '</span></div>' +
                    '</div>' +
                    '</td>' +
                    '</tr>';
            }).join('');

            docRefData = docs;

            // คงไฮไลต์แถวที่เลือกไว้หลัง render ใหม่ (กรณีกด "โหลดเพิ่ม")
            if (docRefSelected && docRefSelected.id) {
                var rows = tbody.querySelectorAll('.docref-main-row');
                for (var i = 0; i < docRefData.length; i++) {
                    if (String(docRefData[i].id) === String(docRefSelected.id)) {
                        if (rows[i]) rows[i].classList.add('selected');
                        break;
                    }
                }
            }
        }

        // พับ/กางแถวรายละเอียดของเอกสาร พร้อมสลับทิศทางลูกศร
        function toggleDocRefDetail(index) {
            var tbody = document.getElementById('docRefPopupRows');
            if (!tbody) return;

            var mainRow = tbody.querySelector('.docref-main-row[data-index="' + index + '"]');
            var detailRow = tbody.querySelector('.docref-detail-row[data-detail-index="' + index + '"]');
            if (!mainRow || !detailRow) return;

            var willOpen = !detailRow.classList.contains('is-open');
            detailRow.classList.toggle('is-open', willOpen);
            mainRow.classList.toggle('is-open', willOpen);

            var caret = mainRow.querySelector('.docref-caret');
            if (caret) {
                caret.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                var icon = caret.querySelector('i');
                if (icon) {
                    icon.className = willOpen ? 'fas fa-caret-up' : 'fas fa-caret-down';
                }
            }
        }

        function selectDocRefRow(index) {
            var tbody = document.getElementById('docRefPopupRows');
            var doc = (docRefData || [])[index];
            if (!tbody || !doc) return;

            tbody.querySelectorAll('.docref-main-row').forEach(function(row) {
                row.classList.remove('selected');
            });
            var target = tbody.querySelector('.docref-main-row[data-index="' + index + '"]');
            if (target) target.classList.add('selected');
            docRefSelected = doc;
        }

        function loadMoreDocRefRows() {
            if (!docRefHasMore || !docRefNextLastId) return;
            loadDocRefRows(docRefKeyword, true);
        }

        // ยืนยันการเลือก: reload หน้าใหม่ด้วย ref_id/iv_no ที่เลือก เพื่อให้ข้อมูลลูกค้าและตารางสินค้า (render ฝั่ง PHP) ตรงกับเอกสารใหม่
        // ข้อยกเว้น: โหมดแก้ไข (form_mode=edit) ห้าม reload เพราะจะหลุดโหมดแก้ไข (ref_credit หายไปจาก URL) กลายเป็นเริ่มสร้างใบใหม่ทับของเดิม
        // — รายการสินค้า/ข้อมูลลูกค้าของใบลดหนี้ที่แก้ไขอยู่มาจาก tb_subcredit/tb_credit_note อยู่แล้ว ไม่ได้ผูกกับ SO ที่เลือกใหม่
        // จึงแค่เติมเลขที่เอกสารอ้างอิง/หมายเลขคำสั่งซื้อลงในฟอร์มตรงๆ พอ
        function confirmDocRefSelection() {
            if (!docRefSelected) {
                Swal.fire({
                    title: 'กรุณาเลือกเอกสารก่อน',
                    icon: 'warning',
                    confirmButtonColor: '#612989',
                    confirmButtonText: 'ตกลง'
                });
                return;
            }

            var selectedRefId = String(docRefSelected.ref_id || '').trim();
            if (!selectedRefId) {
                Swal.fire({
                    title: 'เอกสารที่เลือกไม่มีหมายเลขคำสั่งซื้อ',
                    icon: 'warning',
                    confirmButtonColor: '#612989',
                    confirmButtonText: 'ตกลง'
                });
                return;
            }

            var formModeInput = document.querySelector('input[name="form_mode"]');
            var formMode = formModeInput ? formModeInput.value : '';

            if (formMode === 'edit') {
                var ivInputEdit = document.getElementById('iv_no_ref');
                var refIdInputEdit = document.getElementById('ref_id');
                var selectedIvNoEdit = String(docRefSelected.iv_no || '').trim();
                if (ivInputEdit) ivInputEdit.value = selectedIvNoEdit;
                if (refIdInputEdit) refIdInputEdit.value = selectedRefId;
                closeDocRefPopup();
                return;
            }

            var url = 'register_credinot.php?ref_id=' + encodeURIComponent(selectedRefId);

            var selectedIvNo = String(docRefSelected.iv_no || '').trim();
            if (selectedIvNo !== '') {
                url += '&iv_no=' + encodeURIComponent(selectedIvNo);
            }

            var openerInput = document.querySelector('input[name="opener"]');
            var openerValue = openerInput ? String(openerInput.value || '').trim() : '';
            if (openerValue !== '') {
                url += '&opener=' + encodeURIComponent(openerValue);
            }

            window.location.href = url;
        }

        document.addEventListener('DOMContentLoaded', function() {
            var search = document.getElementById('docRefPopupSearch');
            var modal = document.getElementById('docRefPopupModal');

            if (search) {
                search.addEventListener('input', function() {
                    clearTimeout(docRefTimer);
                    docRefTimer = setTimeout(function() {
                        docRefSelected = null;
                        loadDocRefRows(search.value, false);
                    }, 250);
                });
            }

            // คลิกพื้นหลังนอกกล่องเพื่อปิด
            if (modal) {
                modal.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        closeDocRefPopup();
                    }
                });
            }

            document.addEventListener('keydown', function(event) {
                if (event.key !== 'Escape') return;
                if (modal && modal.style.display === 'flex') {
                    closeDocRefPopup();
                }
            });
        });

        /* ===== ลบรายการสินค้าที่บันทึกไว้แล้ว (โหมดแก้ไข) ผ่าน credit_delete.php แบบ AJAX ไม่ reload หน้า ===== */
        // ลบแถวสินค้าที่มีอยู่แล้วจริงใน tb_subcredit — ไม่ลบทันที แค่ซ่อนแถว + จำ id ไว้เป็น "รอลบ"
        // ลบจริงตอน submit ฟอร์มเท่านั้น (ที่ register_credinot1.php) เพื่อให้ปุ่ม "ยกเลิก" ยังกู้คืนได้ก่อนกด Submit
        function deleteCreditSubRow(btn, subId) {
            Swal.fire({
                title: 'ยืนยันการลบรายการ',
                html: 'ต้องการลบรายการสินค้านี้ใช่หรือไม่ (จะลบออกจริงเมื่อกด Submit)',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยันลบ',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true,
                confirmButtonColor: '#DC3545',
                cancelButtonColor: '#612989'
            }).then(function(result) {
                if (!result.isConfirmed) return;

                var row = btn.closest('tr');
                if (!row) {
                    console.error('deleteCreditSubRow: หา <tr> ของแถวที่กดลบไม่เจอ (subId=' + subId + ')');
                    return;
                }
                row.classList.add('is-pending-delete');
                // ซ่อนแถวด้วย inline style ตรงๆ ควบคู่กับ class ไปด้วย กัน CSS ไฟล์ภายนอกโหลดไม่ทัน/ถูก cache ค้าง
                row.style.display = 'none';

                var form = document.forms['frmMain'];
                if (form) {
                    var pendingInput = document.createElement('input');
                    pendingInput.type = 'hidden';
                    pendingInput.name = 'delete_subcredit_id[]';
                    pendingInput.value = subId;
                    form.appendChild(pendingInput);
                }

                var badge = document.querySelector('.credinot-count-badge');
                if (badge) {
                    var currentCount = parseInt(badge.textContent, 10);
                    if (!isNaN(currentCount) && currentCount > 0) {
                        badge.textContent = (currentCount - 1) + ' รายการ';
                    }
                }
            });
        }

        // ลบแถวสินค้าที่เพิ่งเพิ่มเองด้วย modal (ยังไม่ถูกบันทึก) — ลบออกจาก DOM ได้เลยไม่ต้องยิง AJAX
        function removeNewCreditRow(btn) {
            Swal.fire({
                title: 'ยืนยันการลบรายการ',
                html: 'ต้องการลบรายการสินค้านี้ใช่หรือไม่',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยันลบ',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true,
                confirmButtonColor: '#DC3545',
                cancelButtonColor: '#612989'
            }).then(function(result) {
                if (!result.isConfirmed) return;

                var row = btn.closest('tr');
                if (!row || !row.parentNode) {
                    console.error('removeNewCreditRow: หา <tr> ของแถวที่กดลบไม่เจอ');
                    return;
                }
                // แถวจาก SO (mode create_so) มีแถวรายละเอียด SN ตามหลังทันที ต้องลบคู่กัน
                var detailRow = row.nextElementSibling;
                var detailIsPair = detailRow && detailRow.classList.contains('credinot-detail-row');
                row.parentNode.removeChild(row);
                if (detailIsPair && detailRow.parentNode) {
                    detailRow.parentNode.removeChild(detailRow);
                }

                var badge = document.querySelector('.credinot-count-badge');
                if (badge) {
                    var currentCount = parseInt(badge.textContent, 10);
                    if (!isNaN(currentCount) && currentCount > 0) {
                        badge.textContent = (currentCount - 1) + ' รายการ';
                    }
                }
            });
        }

        /* ===== Modal ค้นหาลูกค้า (โหมดสร้างแบบไม่มีเอกสารอ้างอิง) — ล้อ pattern เดียวกับ modal เอกสารอ้างอิง ===== */
        var custSearchSelected = null;
        var custSearchTimer = null;
        var custSearchData = [];
        var custSearchKeyword = '';
        var custSearchNextLastId = null;
        var custSearchHasMore = false;
        var custSearchLoading = false;
        var custSearchPageSize = 20;
        var custSearchAbortController = null;
        var custSearchRequestId = 0;

        function openCustomerSearchPopup() {
            var modal = document.getElementById('customerSearchPopupModal');
            var search = document.getElementById('customerSearchPopupSearch');
            if (!modal) return;

            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            custSearchSelected = null;
            custSearchData = [];
            custSearchKeyword = search ? (search.value || '') : '';
            custSearchNextLastId = null;
            custSearchHasMore = false;
            toggleCustSearchLoadMore(false, false);

            loadCustSearchRows(custSearchKeyword, false);
            setTimeout(function() {
                if (search) {
                    search.focus();
                    search.select();
                }
            }, 50);
        }

        function closeCustomerSearchPopup() {
            var modal = document.getElementById('customerSearchPopupModal');
            if (!modal) return;
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        }

        function toggleCustSearchLoadMore(visible, loading) {
            var wrap = document.getElementById('customerSearchPopupPagination');
            var button = document.getElementById('customerSearchPopupLoadMore');
            if (!wrap || !button) return;
            wrap.style.display = visible ? 'flex' : 'none';
            button.disabled = !!loading;
            button.textContent = loading ? 'กำลังโหลด...' : 'โหลดเพิ่ม';
        }

        function loadCustSearchRows(keyword, append) {
            var tbody = document.getElementById('customerSearchPopupRows');
            if (append && custSearchLoading) return;

            if (!append && custSearchAbortController) {
                custSearchAbortController.abort();
            }

            custSearchAbortController = new AbortController();
            var requestController = custSearchAbortController;
            var requestId = ++custSearchRequestId;
            custSearchLoading = true;

            if (!append && tbody) {
                tbody.innerHTML = '<tr><td colspan="3" class="customer-popup-empty">กำลังค้นหา...</td></tr>';
            }

            if (!append) {
                custSearchSelected = null;
                custSearchData = [];
                custSearchNextLastId = null;
                custSearchHasMore = false;
                custSearchKeyword = keyword || '';
            }

            toggleCustSearchLoadMore(append || custSearchHasMore, append);

            var requestUrl = 'ajax_customer_popup_search.php?q=' + encodeURIComponent(custSearchKeyword || '') +
                '&limit=' + encodeURIComponent(custSearchPageSize);
            if (append && custSearchNextLastId) {
                requestUrl += '&last_id=' + encodeURIComponent(custSearchNextLastId);
            }

            fetch(requestUrl, {
                    credentials: 'same-origin',
                    signal: requestController.signal
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (requestId !== custSearchRequestId) return;

                    if (!data || !data.success) {
                        custSearchData = [];
                        custSearchHasMore = false;
                        custSearchNextLastId = null;
                        renderCustSearchRows([]);
                        return;
                    }

                    var newRows = data.customers || [];
                    custSearchData = append ? custSearchData.concat(newRows) : newRows;
                    custSearchHasMore = !!(data.pagination && data.pagination.has_more);
                    custSearchNextLastId = data.pagination ? data.pagination.next_last_id : null;
                    renderCustSearchRows(custSearchData);
                })
                .catch(function(error) {
                    if (error && error.name === 'AbortError') return;
                    if (requestId !== custSearchRequestId) return;

                    custSearchHasMore = false;
                    custSearchNextLastId = null;
                    if (tbody) {
                        tbody.innerHTML = '<tr><td colspan="3" class="customer-popup-empty">ไม่สามารถค้นหาข้อมูลได้</td></tr>';
                    }
                    toggleCustSearchLoadMore(false, false);
                })
                .finally(function() {
                    if (requestId !== custSearchRequestId) return;
                    custSearchLoading = false;
                    custSearchAbortController = null;
                    if (custSearchHasMore) {
                        toggleCustSearchLoadMore(true, false);
                    }
                });
        }

        function renderCustSearchRows(customers) {
            var tbody = document.getElementById('customerSearchPopupRows');
            if (!tbody) return;

            customers = customers || custSearchData || [];

            if (!customers || customers.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="customer-popup-empty">ไม่พบข้อมูลลูกค้า</td></tr>';
                toggleCustSearchLoadMore(false, false);
                return;
            }

            tbody.innerHTML = customers.map(function(cust, index) {
                return '<tr onclick="selectCustSearchRow(' + index + ')">' +
                    '<td><button type="button" class="customer-popup-name" onclick="event.stopPropagation(); selectCustSearchRow(' + index + ');">' + escapeDocRefHtml(cust.bill_name || cust.customer_name || '-') + '</button></td>' +
                    '<td>' + escapeDocRefHtml(cust.cus_tel || '-') + '</td>' +
                    '<td>' + escapeDocRefHtml(cust.cus_address || '-') + '</td>' +
                    '</tr>';
            }).join('');

            custSearchData = customers;
        }

        function selectCustSearchRow(index) {
            var tbody = document.getElementById('customerSearchPopupRows');
            var cust = (custSearchData || [])[index];
            if (!tbody || !cust) return;

            tbody.querySelectorAll('tr').forEach(function(row) {
                row.classList.remove('selected');
            });
            var rows = tbody.querySelectorAll('tr');
            if (rows[index]) rows[index].classList.add('selected');
            custSearchSelected = cust;
        }

        function loadMoreCustomerSearchRows() {
            if (!custSearchHasMore || !custSearchNextLastId) return;
            loadCustSearchRows(custSearchKeyword, true);
        }

        // สถานะลูกค้าตามรหัส status_cus (ล้อ logic เดียวกับฝั่ง PHP ตอน render ครั้งแรก)
        function custStatusNameFromCode(statusCus) {
            var code = String(statusCus == null ? '' : statusCus).trim();
            if (code === '0') return 'Gold Customer';
            if (code === '1') return 'Platinum Customer';
            if (code === '2') return 'Diamond Customer';
            return '-';
        }

        // ยืนยันการเลือกลูกค้า: เติมข้อมูลลูกค้าลงในฟอร์มหลักทันที ไม่ reload หน้า
        function confirmCustomerSearchSelection() {
            if (!custSearchSelected) {
                Swal.fire({
                    title: 'กรุณาเลือกลูกค้าก่อน',
                    icon: 'warning',
                    confirmButtonColor: '#612989',
                    confirmButtonText: 'ตกลง'
                });
                return;
            }

            var cust = custSearchSelected;
            var billIdInput = document.getElementById('bill_id');
            var nameInput = document.getElementById('customer_name');
            var telInput = document.getElementById('customer_tel');
            var addressInput = document.getElementById('address_name');

            if (billIdInput) billIdInput.value = cust.customer_id || '';
            if (nameInput) nameInput.value = cust.bill_name || cust.customer_name || '';
            if (telInput) telInput.value = cust.cus_tel || '';
            if (addressInput) addressInput.value = cust.cus_address || '';

            var noDisplay = document.getElementById('customer_no_display');
            if (noDisplay) noDisplay.textContent = cust.customer_no || '';

            var typeDisplay = document.getElementById('customer_type_display');
            if (typeDisplay) typeDisplay.textContent = cust.type_name || '';

            var creditDisplay = document.getElementById('customer_credit_display');
            if (creditDisplay) {
                var creditVal = parseFloat(cust.credit_thb);
                creditDisplay.textContent = (!isNaN(creditVal) && creditVal > 0) ? creditVal.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) : '0.00';
            }

            var statusDisplay = document.getElementById('customer_status_display');
            if (statusDisplay) statusDisplay.textContent = custStatusNameFromCode(cust.status_cus);

            var vipIcon = document.getElementById('customer_vip_icon');
            if (vipIcon) vipIcon.style.display = (String(cust.vip_ckk || '').trim() === '1') ? '' : 'none';

            closeCustomerSearchPopup();
        }

        /* ===== Modal ค้นหาสินค้า (โหมดแก้ไข/สร้างแบบไม่มีเอกสารอ้างอิง) — เลือกแล้วเพิ่มลงตารางทันที เลือกได้หลายรายการ ===== */
        var prodSearchTimer = null;
        var prodSearchData = [];
        var prodSearchKeyword = '';
        var prodSearchNextLastId = null;
        var prodSearchHasMore = false;
        var prodSearchLoading = false;
        var prodSearchPageSize = 20;
        var prodSearchAbortController = null;
        var prodSearchRequestId = 0;
        var credinotNewRowSeq = 0;

        function openProductSearchPopup() {
            var modal = document.getElementById('productSearchPopupModal');
            var search = document.getElementById('productSearchPopupSearch');
            if (!modal) return;

            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            prodSearchData = [];
            prodSearchKeyword = search ? (search.value || '') : '';
            prodSearchNextLastId = null;
            prodSearchHasMore = false;
            toggleProdSearchLoadMore(false, false);

            loadProdSearchRows(prodSearchKeyword, false);
            setTimeout(function() {
                if (search) {
                    search.focus();
                    search.select();
                }
            }, 50);
        }

        function closeProductSearchPopup() {
            var modal = document.getElementById('productSearchPopupModal');
            if (!modal) return;
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        }

        function openCancelCreditModal() {
            var refCredit = <?php echo json_encode($refCreditFull); ?>;
            Swal.fire({
                title: 'ยืนยันการยกเลิกใบลดหนี้',
                html: 'คุณต้องการยกเลิกใบลดหนี้เลขที่ <strong>' + escapeDocRefHtml(refCredit) + '</strong> ใช่หรือไม่?<br><span style="color:#DC3545;">การยกเลิกไม่สามารถย้อนกลับได้</span>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยันยกเลิก',
                cancelButtonText: 'ย้อนกลับ',
                confirmButtonColor: '#DC3545',
                cancelButtonColor: '#612989',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    confirmCancelCredit();
                }
            });
        }

        function closeCancelCreditModal() {
            // retain empty function for safety
        }

        function confirmCancelCredit() {
            var form = document.forms['frmMain'];
            if (!form) return;
            var actionField = document.createElement('input');
            actionField.type = 'hidden';
            actionField.name = 'approve_action';
            actionField.value = 'cancel';
            form.appendChild(actionField);
            HTMLFormElement.prototype.submit.call(form);
        }

        function toggleProdSearchLoadMore(visible, loading) {
            var wrap = document.getElementById('productSearchPopupPagination');
            var button = document.getElementById('productSearchPopupLoadMore');
            if (!wrap || !button) return;
            wrap.style.display = visible ? 'flex' : 'none';
            button.disabled = !!loading;
            button.textContent = loading ? 'กำลังโหลด...' : 'โหลดเพิ่ม';
        }

        function loadProdSearchRows(keyword, append) {
            var tbody = document.getElementById('productSearchPopupRows');
            if (append && prodSearchLoading) return;

            if (!append && prodSearchAbortController) {
                prodSearchAbortController.abort();
            }

            prodSearchAbortController = new AbortController();
            var requestController = prodSearchAbortController;
            var requestId = ++prodSearchRequestId;
            prodSearchLoading = true;

            if (!append && tbody) {
                tbody.innerHTML = '<tr><td colspan="4" class="customer-popup-empty">กำลังค้นหา...</td></tr>';
            }

            if (!append) {
                prodSearchData = [];
                prodSearchNextLastId = null;
                prodSearchHasMore = false;
                prodSearchKeyword = keyword || '';
            }

            toggleProdSearchLoadMore(append || prodSearchHasMore, append);

            var requestUrl = 'ajax_credinot_product_search.php?q=' + encodeURIComponent(prodSearchKeyword || '') +
                '&limit=' + encodeURIComponent(prodSearchPageSize);
            if (append && prodSearchNextLastId) {
                requestUrl += '&last_id=' + encodeURIComponent(prodSearchNextLastId);
            }

            fetch(requestUrl, {
                    credentials: 'same-origin',
                    signal: requestController.signal
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (requestId !== prodSearchRequestId) return;

                    if (!data || !data.success) {
                        prodSearchData = [];
                        prodSearchHasMore = false;
                        prodSearchNextLastId = null;
                        renderProdSearchRows([]);
                        return;
                    }

                    var newRows = data.products || [];
                    prodSearchData = append ? prodSearchData.concat(newRows) : newRows;
                    prodSearchHasMore = !!(data.pagination && data.pagination.has_more);
                    prodSearchNextLastId = data.pagination ? data.pagination.next_last_id : null;
                    renderProdSearchRows(prodSearchData);
                })
                .catch(function(error) {
                    if (error && error.name === 'AbortError') return;
                    if (requestId !== prodSearchRequestId) return;

                    prodSearchHasMore = false;
                    prodSearchNextLastId = null;
                    if (tbody) {
                        tbody.innerHTML = '<tr><td colspan="4" class="customer-popup-empty">ไม่สามารถค้นหาข้อมูลได้</td></tr>';
                    }
                    toggleProdSearchLoadMore(false, false);
                })
                .finally(function() {
                    if (requestId !== prodSearchRequestId) return;
                    prodSearchLoading = false;
                    prodSearchAbortController = null;
                    if (prodSearchHasMore) {
                        toggleProdSearchLoadMore(true, false);
                    }
                });
        }

        function renderProdSearchRows(products) {
            var tbody = document.getElementById('productSearchPopupRows');
            if (!tbody) return;

            products = products || prodSearchData || [];

            if (!products || products.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="customer-popup-empty">ไม่พบข้อมูลสินค้า</td></tr>';
                toggleProdSearchLoadMore(false, false);
                return;
            }

            tbody.innerHTML = products.map(function(prod, index) {
                var price = parseFloat(prod.sol_price);
                var priceDisplay = !isNaN(price) ? price.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) : '0.00';
                return '<tr onclick="pickProductSearchRow(' + index + ')" style="cursor:pointer;">' +
                    '<td>' + escapeDocRefHtml(prod.access_code || '-') + '</td>' +
                    '<td>' + escapeDocRefHtml(prod.sol_name || '-') + '</td>' +
                    '<td>' + escapeDocRefHtml(prod.unit_name || '-') + '</td>' +
                    '<td style="text-align:right;">' + priceDisplay + '</td>' +
                    '</tr>';
            }).join('');

            prodSearchData = products;
        }

        function pickProductSearchRow(index) {
            var prod = (prodSearchData || [])[index];
            if (!prod) return;
            addProductRowToTable(prod);
        }

        function loadMoreProductSearchRows() {
            if (!prodSearchHasMore || !prodSearchNextLastId) return;
            loadProdSearchRows(prodSearchKeyword, true);
        }

        // เพิ่มแถวสินค้าใหม่ลงตารางรายการสินค้าด้วย JS (client-side) — key ใช้ prefix "new_" กันชนกับ id จริงจาก DB
        function addProductRowToTable(prod) {
            var tbody = document.getElementById('credinotTableBody');
            if (!tbody) return;

            credinotNewRowSeq++;
            var key = 'new_' + credinotNewRowSeq;
            var price = parseFloat(prod.sol_price) || 0;

            var row = document.createElement('tr');
            row.className = 'credinot-row';
            row.setAttribute('data-search-text', String(prod.access_code + ' ' + prod.sol_name).toLowerCase());
            row.setAttribute('draggable', 'true');
            row.addEventListener('dragstart', handleCreditItemDragStart);
            row.addEventListener('dragend', handleCreditItemDragEnd);
            row.addEventListener('dragover', handleCreditItemDragOver);
            row.addEventListener('drop', handleCreditItemDrop);
            row.innerHTML =
                '<td class="credinot-row-controls">' +
                '<div class="credinot-row-controls-inner">' +
                '<span class="credinot-drag-handle" title="ลากเพื่อจัดเรียง (ไม่บันทึกลงฐานข้อมูล)" aria-hidden="true"><i class="fas fa-grip-vertical"></i></span>' +
                '<span class="credinot-select-dot" aria-hidden="true"></span>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<input type="hidden" name="id[' + key + ']" value="">' +
                '<input type="text" name="product_id[' + key + ']" class="so-input credinot-code-input" value="' + escapeDocRefHtml(prod.product_id) + '" readonly>' +
                '<input type="hidden" name="product_code[' + key + ']" value="' + escapeDocRefHtml(prod.access_code || '') + '">' +
                '</td>' +
                '<td><textarea name="product_name[' + key + ']" class="so-textarea" readonly>' + escapeDocRefHtml(prod.sol_name || '') + '</textarea></td>' +
                '<td><div class="credinot-qty-pill"><input type="text" name="count[' + key + ']" value="1" class="so-input credinot-new-count" style="text-align:center"></div></td>' +
                '<td><input type="text" name="unit_price[' + key + ']" value="' + price.toFixed(2) + '" class="so-input credinot-new-price" style="text-align:right"></td>' +
                '<td>' +
                '<input type="text" name="sum_amount[' + key + ']" value="' + price.toFixed(2) + '" class="so-input credinot-new-sum" style="text-align:right" readonly>' +
                '<input type="hidden" name="discount_unit[' + key + ']" value="0.00">' +
                '</td>' +
                '<td class="credinot-edit-col">' +
                '<button type="button" class="credinot-delete-btn" title="ลบรายการ" onclick="removeNewCreditRow(this)"><i class="fas fa-trash-alt"></i></button>' +
                '</td>';

            tbody.appendChild(row);

            var countInput = row.querySelector('.credinot-new-count');
            var priceInput = row.querySelector('.credinot-new-price');
            var sumInput = row.querySelector('.credinot-new-sum');
            var recalc = function() {
                var c = parseFloat(countInput.value) || 0;
                var p = parseFloat(priceInput.value) || 0;
                sumInput.value = (c * p).toFixed(2);
            };
            countInput.addEventListener('input', recalc);
            priceInput.addEventListener('input', recalc);

            var badge = document.querySelector('.credinot-count-badge');
            if (badge) {
                var currentCount = parseInt(badge.textContent, 10);
                if (!isNaN(currentCount)) {
                    badge.textContent = (currentCount + 1) + ' รายการ';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var custSearch = document.getElementById('customerSearchPopupSearch');
            var custModal = document.getElementById('customerSearchPopupModal');
            if (custSearch) {
                custSearch.addEventListener('input', function() {
                    clearTimeout(custSearchTimer);
                    custSearchTimer = setTimeout(function() {
                        custSearchSelected = null;
                        loadCustSearchRows(custSearch.value, false);
                    }, 250);
                });
            }
            if (custModal) {
                custModal.addEventListener('click', function(event) {
                    if (event.target === custModal) closeCustomerSearchPopup();
                });
            }

            var prodSearch = document.getElementById('productSearchPopupSearch');
            var prodModal = document.getElementById('productSearchPopupModal');
            if (prodSearch) {
                prodSearch.addEventListener('input', function() {
                    clearTimeout(prodSearchTimer);
                    prodSearchTimer = setTimeout(function() {
                        loadProdSearchRows(prodSearch.value, false);
                    }, 250);
                });
            }
            if (prodModal) {
                prodModal.addEventListener('click', function(event) {
                    if (event.target === prodModal) closeProductSearchPopup();
                });
            }

            document.addEventListener('keydown', function(event) {
                if (event.key !== 'Escape') return;
                if (custModal && custModal.style.display === 'flex') closeCustomerSearchPopup();
                if (prodModal && prodModal.style.display === 'flex') closeProductSearchPopup();
                hideCreditSearchSuggest();
            });

            document.addEventListener('click', function(event) {
                var searchWrap = document.querySelector('.credinot-search-wrap');
                if (searchWrap && !searchWrap.contains(event.target)) {
                    hideCreditSearchSuggest();
                }
            });
        });
    </script>

    </div>
    </div>
    <!-- <div id="cr_bar"> <?php include "foot.php"; ?></div> -->
    <!--/div-->