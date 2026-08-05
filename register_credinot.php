<?php include("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

<!-- Shared .so-* design-system primitives (cards, inputs, labels, buttons, etc.) -->
<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<!-- Page-specific styling for register_credinot.php -->
<link rel="stylesheet" href="css/register-credinot.css?v=<?php echo filemtime(__DIR__ . '/css/register-credinot.css'); ?>">

<body>
    <?php

    $ref_id = $_GET["ref_id"];
    $opener = isset($_GET['opener']) ? $_GET['opener'] : '';

    $escRefId = mysqli_real_escape_string($conn, $ref_id);

    $sql = "SELECT *   FROM hos__so where ref_id = '" . $escRefId . "'";
    $qry = mysqli_query($conn, $sql) or die(mysqli_error());
    $rs = mysqli_fetch_assoc($qry);

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

    // เลขที่ IV ส่งมาจากหน้า register_suphos.php ได้ (ค่าสดในช่อง 'เลขที่เอกสาร' ที่อาจยังไม่ถูกบันทึกลง hos__so)
    // ถ้าไม่ส่งมา ให้ใช้ค่าจากฐานข้อมูลตามเดิม
    $ivNoParam = isset($_GET['iv_no']) ? trim($_GET['iv_no']) : '';
    $ivNoEffective = ($ivNoParam !== '') ? $ivNoParam : ($rs['iv_no'] ?? '');
    $escIvNo = mysqli_real_escape_string($conn, $ivNoEffective);


    $strSQL1 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '" . $escRefId . "' ";
    //echo $strSQL;
    //exit();
    $objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [" . $strSQL1 . "]");
    $Num_Rows1 = mysqli_num_rows($objQuery1);

    $yearMonth = substr(date("Y") + 543, -2) . date("m");
    $sql1 = "SELECT MAX(ref_credit) AS MAXID FROM tb_credit_note";
    $qry1 = mysqli_query($conn, $sql1) or die(mysqli_error());
    $rs1 = mysqli_fetch_assoc($qry1);
    $maxId = substr($rs1['MAXID'], -4);
    $maxId3 = substr($rs1['MAXID'], -8);

    $maxId1 = substr($maxId3, 0, -4);
    $so = "SR";

    if ($maxId1 == $yearMonth) {
        $maxId1 = ($maxId + 1);
        $maxId2 = substr("00000" . $maxId1, -4);
        $nextId = $yearMonth . $maxId2;
    } else {
        $maxId1 = "0001";
        $nextId = $yearMonth . $maxId1;
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
                    <h1 class="so-title">ใบลดหนี้ (Credit Note Order)</h1>
                    <div class="so-ref-info">
                        <span class="so-ref-label">เลขที่อ้างอิง</span>
                        <span class="so-ref-value"><?php echo $so;
                                                    echo $nextId; ?></span>
                    </div>
                </div>
                <div class="so-header-right">
                    <button type="button" class="btn-preview-so" onclick="openPrintReport();">
                        <img src="img/icons/preview.png" alt="preview" style="width: 16px; height: 16px;"> Preview
                    </button>
                </div>
            </div>

            <div class="so-tabs-container">
                <button type="button" class="so-tab-btn active">ข้อมูลเอกสาร</button>
            </div>

            <input type="hidden" name="ref_credit" value="<?php echo $so;
                                                            echo $nextId; ?>">
            <input type="hidden" name="mode_cus" id="mode_cus" value="<?php echo $rs["mode_cus"]; ?>">
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
                                <select class="so-select" name="company_type" id="company_type">
                                    <option value="3" selected>AWL</option>
                                    <option value="4">NBM</option>
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
                                <select class="so-select" name="ttype_doc" id="ttype_doc">
                                    <option value="1" selected>คืนสินค้า</option>
                                    <option value="2">ส่วนลด</option>
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
                        </div>

                        <div class="so-customer-top-right">
                            <div class="so-field-group" style="height: 100%;">
                                <label class="so-label">ข้อมูลลูกค้า</label>
                                <div class="customer-info-display-card">
                                    <div class="cidc-col">
                                        <div class="cidc-row">
                                            <div class="cidc-label">รหัสสมาชิก</div>
                                            <div class="cidc-value">
                                                <span class="cidc-display-text"><?php echo htmlspecialchars($customerNo, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">เบอร์โทรศัพท์</div>
                                            <div class="cidc-value">
                                                <input type="text" name="customer_tel" id="customer_tel" value="<?php echo htmlspecialchars($rs["bill_tel"] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="cidc-value-input" readonly>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">สถานะลูกค้า</div>
                                            <div class="cidc-value">
                                                <img src="img/icons/vip.png" class="cidc-status-icon" alt="VIP" style="<?php echo $customerIsVip ? '' : 'display:none;'; ?>">
                                                <span class="cidc-display-text"><?php echo htmlspecialchars($customerStatusName, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cidc-col">
                                        <div class="cidc-row">
                                            <div class="cidc-label">ชื่อลูกค้า</div>
                                            <div class="cidc-value">
                                                <input type="text" name="customer_name" id="customer_name" value="<?php echo htmlspecialchars($rs["bill_name"] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="cidc-value-input" readonly>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">ประเภทลูกค้า</div>
                                            <div class="cidc-value">
                                                <span class="cidc-display-text"><?php echo htmlspecialchars($customerTypeName, ENT_QUOTES, 'UTF-8'); ?></span>
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
                                                <span class="cidc-credit-term"><?php echo htmlspecialchars($formattedCredit, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ที่อยู่ -->
                            <div class="so-field-group" style="margin-top: 16px;">
                                <label class="so-label" for="address_name">ที่อยู่<span style="color:#D32F2F;">*</span></label>
                                <div class="so-input-wrapper">
                                    <input type="text" name="address_name" id="address_name" value="<?php echo htmlspecialchars($rs["bill_address"] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="so-input">
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
                            <div class="so-input-wrapper">
                                <input type="text" name="etax_count" id="etax_count" placeholder="ใส่เฉพาะตัวเลข" class="so-input">
                            </div>
                        </div>

                        <!-- วันที่เอกสารเดิม -->
                        <div class="so-field-group">
                            <label class="so-label" for="etax_orig_date">วันที่เอกสารเดิม</label>
                            <div class="so-input-wrapper calendar-wrapper">
                                <input type="date" name="etax_orig_date" id="etax_orig_date" class="so-input">
                            </div>
                        </div>

                        <!-- หมายเหตุการแก้ไข -->
                        <div class="so-field-group" style="grid-column: 1 / -1;">
                            <label class="so-label" for="etax_edit_note">หมายเหตุการแก้ไข</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="etax_edit_note" id="etax_edit_note" placeholder="กรอกหมายเหตุการแก้ไข" class="so-input">
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
                                <input type="text" name="return_reason" id="return_reason" placeholder="กรอกสาเหตุการคืน" class="so-input">
                                <button type="button" class="so-clear-icon" onclick="document.getElementById('return_reason').value=''"><i class="fas fa-times"></i></button>
                            </div>
                        </div>

                        <!-- ผู้รับคืนสินค้า -->
                        <div class="so-field-group">
                            <label class="so-label" for="receive_name">ผู้รับคืนสินค้า<span style="color:#D32F2F;">*</span></label>
                            <div class="so-input-wrapper">
                                <input type="text" name="receive_name" id="receive_name" placeholder="กรอกชื่อผู้รับคืนสินค้า" class="so-input" required>
                                <button type="button" class="so-clear-icon" onclick="document.getElementById('receive_name').value=''"><i class="fas fa-times"></i></button>
                            </div>
                        </div>

                        <!-- วันที่ -->
                        <div class="so-field-group">
                            <label class="so-label" for="date_receive">วันที่<span style="color:#D32F2F;">*</span></label>
                            <div class="so-input-wrapper calendar-wrapper">
                                <input type="date" name="date_receive" id="date_receive" class="so-input" required>
                            </div>
                        </div>

                        <!-- คำอธิบายเพิ่มเติม -->
                        <div class="so-field-group" style="grid-column: 1 / -1;">
                            <label class="so-label" for="return_des">คำอธิบายเพิ่มเติม</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="return_des" id="return_des" placeholder="กรอกคำอธิบายเพิ่มเติม" class="so-input">
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
                                <input type="date" name="date_credit" id="date_credit" value="<?php echo $today; ?>" class="so-input" required>
                            </div>
                        </div>

                        <!-- เลขที่ลดหนี้ + ปุ่ม Run เลขที่ -->
                        <div class="so-field-group">
                            <label class="so-label" for="credit_no">เลขที่ลดหนี้</label>
                            <div class="credit-no-row">
                                <div class="so-input-wrapper">
                                    <input type="text" name="credit_no" id="credit_no" placeholder="No." class="so-input" readonly>
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
                                <select class="so-select" name="type_return" id="type_return" required>
                                    <option value="">เลือกวิธีชำระเงินคืน</option>
                                    <option value="1">เงินสด</option>
                                    <option value="2">โอนเงินเข้าบัญชี</option>
                                    <option value="3">ลดหนี้จากยอดลูกหนี้ค้างชำระ</option>
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
                                <select class="so-select" name="bank_name" id="bank_name">
                                    <option value="">เลือกธนาคาร</option>
                                    <?php foreach ($bankNames as $bankName) { ?>
                                        <option value="<?php echo htmlspecialchars($bankName, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($bankName, ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- เลขบัญชี -->
                        <div class="so-field-group">
                            <label class="so-label" for="account_no">เลขบัญชี</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="account_no" id="account_no" placeholder="ใส่เฉพาะตัวเลข" class="so-input">
                            </div>
                        </div>

                        <!-- ชื่อบัญชี -->
                        <div class="so-field-group">
                            <label class="so-label" for="account_name">ชื่อบัญชี</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="account_name" id="account_name" placeholder="กรอกชื่อบัญชี" class="so-input">
                                <button type="button" class="so-clear-icon" onclick="document.getElementById('account_name').value=''"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="so-grid-3">
                        <!-- แนบไฟล์ Book Bank -->
                        <div class="so-field-group">
                            <label class="so-label" for="book_bank">แนบไฟล์ Book Bank</label>
                            <label class="so-file-picker" for="book_bank">
                                <span class="so-file-picker-text" id="book_bank_text">Choose File</span>
                                <i class="far fa-image so-file-picker-icon"></i>
                                <input type="file" name="book_bank" id="book_bank" class="so-file-picker-input" accept="image/*,application/pdf" onchange="showBookBankName(this)">
                            </label>
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
                while ($objResult1 = mysqli_fetch_array($objQuery1)) {


                    $sql3 = "SELECT sum(count) as count3   FROM  (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) where iv_no_ref = '" . $escIvNo . "' and product_id = '" . $objResult1['product_id'] . "' and status_doc ='Approve'";
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
                            <td class="credinot-row-controls">
                                <div class="credinot-row-controls-inner">
                                    <span class="credinot-drag-handle" title="ลากเพื่อจัดเรียง (ไม่บันทึกลงฐานข้อมูล)" aria-hidden="true"><i class="fas fa-grip-vertical"></i></span>
                                    <span class="credinot-select-dot" aria-hidden="true"></span>
                                    <button type="button" class="credinot-caret" aria-expanded="false" aria-label="ขยายรายละเอียด" onclick="toggleCreditItemDetail(this)">
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>
                            </td>

                            <td>

                                <input type="hidden" name="id[<?php echo $objResult1["id"]; ?>]" value="<?php echo $objResult1['id']; ?>">

                                <input type="text" name="product_id[<?php echo $objResult1["id"]; ?>]" class="so-input credinot-code-input" value="<?php echo $objResult1['product_id']; ?>" readonly>

                                <input type='hidden' name="product_code[<?php echo $objResult1["id"]; ?>]" value="<?php echo $objResult1["access_code"]; ?>" id="product_code[<?php echo $objResult1["id"]; ?>]">
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
                        <td colspan="7">
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
                                                <td><?php echo htmlspecialchars($snItem, ENT_QUOTES, 'UTF-8'); ?></td>
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

                <div class="so-field-group credinot-search-wrap">
                    <label class="so-label" for="credinot_search">ค้นหารายการสินค้า</label>
                    <div class="customer-popup-search credinot-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="credinot_search" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า" oninput="filterCreditNoteRows(this.value)">
                    </div>
                </div>

                <div class="credinot-table-wrap">
                    <table class="credinot-table">
                        <thead>
                            <tr>
                                <th scope="col" class="credinot-row-controls" aria-label="จัดเรียง/ขยายรายละเอียด"></th>
                                <th>รหัสสินค้า</th>
                                <th>รายการสินค้า</th>
                                <th style="text-align: center;">จำนวน</th>
                                <th style="text-align: right;">ราคา/หน่วย</th>
                                <th style="text-align: right;">ยอดรวม</th>
                                <th class="credinot-edit-col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $tbodyHtml; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            </div><!-- /#tab-document-info -->

        </div>

        <div class="so-sticky-actions">
            <div class="so-sticky-actions-inner">
                <button type="submit" name="submit" value="submit" class="btn-so-submit">
                    <i class="far fa-paper-plane"></i> Submit
                </button>
                <button type="button" class="btn-so-draft" onclick="window.history.back();">
                    ยกเลิก
                </button>
            </div>
        </div>
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

    <script>
        // ดึงเลขที่ลดหนี้ถัดไปจากฐานข้อมูล (รูปแบบเดียวกับเลขที่อ้างอิงหัวเอกสาร)
        function runCreditNo(btn) {
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
                    alert('ไม่สามารถดึงเลขที่ลดหนี้ได้ กรุณาลองใหม่อีกครั้ง');
                })
                .finally(function() {
                    btn.disabled = false;
                });
        }

        // แสดงชื่อไฟล์ที่เลือกในกล่องแนบไฟล์ Book Bank
        function showBookBankName(input) {
            var label = document.getElementById('book_bank_text');
            var fileName = (input.files && input.files.length) ? input.files[0].name : '';
            label.textContent = fileName || 'Choose File';
            label.classList.toggle('has-file', fileName !== '');
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
        function openPrintReport() {
            var form = document.forms['frmMain'];
            if (!form) return;

            var originalAction = form.action;
            var originalTarget = form.target;

            var flag = document.createElement('input');
            flag.type = 'hidden';
            flag.name = '_report_preview';
            flag.value = '1';
            form.appendChild(flag);

            form.action = 'report_credit_adm.php';
            form.target = '_blank';

            HTMLFormElement.prototype.submit.call(form);

            form.action = originalAction;
            form.target = originalTarget;
            form.removeChild(flag);
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
        function confirmDocRefSelection() {
            if (!docRefSelected) {
                alert('กรุณาเลือกเอกสารก่อน');
                return;
            }

            var selectedRefId = String(docRefSelected.ref_id || '').trim();
            if (!selectedRefId) {
                alert('เอกสารที่เลือกไม่มีหมายเลขคำสั่งซื้อ');
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
    </script>

    </div>
    </div>
    <!-- <div id="cr_bar"> <?php include "foot.php"; ?></div> -->
    <!--/div-->