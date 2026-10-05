<?php

/** @var mysqli $conn */
/** @var mysqli $code */
/** @var mysqli $com */

include('head.php');
include('dbconnect_sale.php');

function fetchRows($connection, $sql)
{
    $rows = array();
    if (!$connection) {
        return $rows;
    }

    $query = mysqli_query($connection, $sql);
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $rows[] = $row;
        }
    }

    return $rows;
}

function fetchRow($connection, $sql)
{
    if (!$connection) {
        return null;
    }

    $query = mysqli_query($connection, $sql);
    if ($query) {
        return mysqli_fetch_assoc($query);
    }

    return null;
}

function tableExists($connection, $tableName)
{
    if (!$connection) {
        return false;
    }

    $tableName = mysqli_real_escape_string($connection, $tableName);
    $query = mysqli_query($connection, "SHOW TABLES LIKE '{$tableName}'");
    return $query && mysqli_num_rows($query) > 0;
}

function h($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$typeCustomers = fetchRows($conn, "SELECT type_id, type_name FROM tb_typecustomer ORDER BY type_id");
$creditBanks = fetchRows($code, "SELECT id, pay_in FROM tb_bank WHERE close_ckk = '0' ORDER BY id");
$provinces = fetchRows($conn, "SELECT province_name FROM tb_province ORDER BY province_name");
/* =========================================================
   สิทธิ์การมองเห็นเขตการขาย
========================================================= */

$userSaleCode = isset($_SESSION['code'])
    ? trim($_SESSION['code'])
    : '';

$typeLogin = isset($_SESSION['type_login'])
    ? trim($_SESSION['type_login'])
    : '';

$typeLoginLower = strtolower($typeLogin);

$saleTeams = array();


/* =========================================================
   Admin / IT / Owner
   เห็นเขตทั้งหมด
========================================================= */

if (in_array($typeLoginLower, ['admin', 'it', 'owner'], true)) {

    $saleTeams = fetchRows(
        $com,
        "
        SELECT sale_code
        FROM tb_team_adm
        WHERE ckk = '0'
        ORDER BY sale_code ASC
        "
    );


/* =========================================================
   Sale
   เห็นเฉพาะเขตของตัวเอง
========================================================= */

} elseif ($typeLoginLower === 'sale') {

    $userSaleCodeSafe = mysqli_real_escape_string(
        $com,
        $userSaleCode
    );

    $saleTeams = fetchRows(
        $com,
        "
        SELECT sale_code
        FROM tb_team_adm
        WHERE sale_code = '{$userSaleCodeSafe}'
        ORDER BY sale_code ASC
        "
    );


/* =========================================================
   Engineer / SUP_EN
   เห็นเฉพาะเขต EN
========================================================= */

} elseif (
    $typeLoginLower === 'engineer'
    || $typeLoginLower === 'sup_en'
    || $userSaleCode === 'SUP_EN'
) {

    $saleTeams = fetchRows(
        $com,
        "
        SELECT sale_code
        FROM tb_team_adm
        WHERE sale_code LIKE '%EN%'
        ORDER BY sale_code ASC
        "
    );


/* =========================================================
   SOL
========================================================= */

} elseif ($typeLoginLower === 'sol') {

    $saleTeams = fetchRows(
        $com,
        "
        SELECT sale_code
        FROM tb_team_adm
        WHERE sale_code IN (
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
        )
        ORDER BY sale_code ASC
        "
    );


/* =========================================================
   Supervisor / User อื่น ๆ
   ดูจาก user_sale_permission
========================================================= */

} else {

    $userSaleCodeSafe = mysqli_real_escape_string(
        $com,
        $userSaleCode
    );

    $saleTeams = fetchRows(
        $com,
        "
        SELECT DISTINCT
            t.sale_code

        FROM tb_team_adm t

        INNER JOIN user_sale_permission p
            ON p.sale_code COLLATE utf8mb3_general_ci
             = t.sale_code COLLATE utf8mb3_general_ci

        WHERE p.em_id COLLATE utf8mb3_general_ci
            = '{$userSaleCodeSafe}' COLLATE utf8mb3_general_ci

        ORDER BY t.sale_code ASC
        "
    );
}
// กรองกลุ่มลูกค้าตาม session แบบเดียวกับ data_mode_cus.php
$modeSaleFilter = (($_SESSION['name'] ?? '') === 'มาลินี' || ($_SESSION['code'] ?? '') === 'S31') ? "WHERE sale_code = 'S31' OR sale_code = 'S32'" : '';
$modeCustomers = fetchRows($conn, "SELECT id_mode, mode_name FROM tb_mode_customer {$modeSaleFilter} ORDER BY mode_name");

$customerId = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : 0;
$isEditMode = $customerId > 0;
$formAction = $isEditMode ? 'edit_customer1.php' : 'add_customer1.php';
$successStatus = isset($_GET['success']) ? trim($_GET['success']) : '';
$successMessage = '';

if ($successStatus === 'created') {
    $successMessage = 'บันทึกข้อมูลสำเร็จ';
} elseif ($successStatus === 'updated') {
    $successMessage = 'อัปเดตข้อมูลสำเร็จ';
}

$customerData = array(
    'customer_id' => $customerId,
    'customer_code' => '',
    'customer_coden' => '',
    'customer_no' => '',
    'customer_name' => '',
    'cus_tel' => '',
    'type_customer' => '',
    'mode_name' => '',
    'credit_ckk' => '',
	'credit_thb' => '',
    'vip_ckk' => '0',
    'cus_address' => '',
    'cus_province' => '',
    'cus_ampher' => '',
    'cus_postcode' => '',
    'bill_name' => '',
    'bill_address' => '',
    'bill_ampher' => '',
    'billl_province' => '',
    'bill_postcode' => '',
    'bill_tel' => '',
    'tax_id' => '',
    'email_cus' => '',
    'h_ckk' => '',
    'brun_no' => '',
    'delivery_name' => '',
    'del_address' => '',
    'del_ampher' => '',
    'del_province' => '',
    'del_postcode' => '',
    'del_tel' => '',
    'contact_name' => '',
    'close_ckk' => '',
    'cus_fax' => '',
    'rental_address' => '',
    'rental_ampher' => '',
    'rental_province' => '',
    'rental_postcode' => '',
);

$selectedSaleCodes = array();
$billingRecords = array();
$shippingRecords = array();

if ($isEditMode) {
    $customerRow = fetchRow($conn, "SELECT * FROM tb_customer WHERE customer_id = {$customerId}");
    if ($customerRow) {
        $customerData = array_merge($customerData, $customerRow);
        $customerData['customer_name'] = trim((string)$customerRow['customer_name']);
    }

    $selectedRows = fetchRows($conn, "SELECT sale_code FROM tb_selected_sales WHERE id_customer = {$customerId}");
    foreach ($selectedRows as $row) {
        $selectedSaleCodes[] = $row['sale_code'];
    }

    if (tableExists($conn, 'tb_customer_billing_address')) {
        $billingRecords = fetchRows($conn, "SELECT * FROM tb_customer_billing_address WHERE customer_id = {$customerId} ORDER BY billing_index ASC, id ASC");
    }

    if (tableExists($conn, 'tb_customer_shipping_address')) {
        $shippingRecords = fetchRows($conn, "SELECT * FROM tb_customer_shipping_address WHERE customer_id = {$customerId} ORDER BY shipping_index ASC, id ASC");
    }
}

$currentMode = trim((string)$customerData['mode_name']);
if ($currentMode === '0') {
    $currentMode = '';
}
$currentModeFound = $currentMode === '';
foreach ($modeCustomers as $modeCustomer) {
    if ((string)$modeCustomer['id_mode'] === $currentMode) {
        $currentModeFound = true;
        break;
    }
}

if (empty($billingRecords)) {
    $billingRecords[] = array(
        'billing_name' => $customerData['bill_name'],
        'billing_tax_id' => $customerData['tax_id'],
        'billing_tel' => $customerData['bill_tel'],
        'billing_email' => $customerData['email_cus'],
        'billing_address' => $customerData['bill_address'],
        'billing_ampher' => $customerData['bill_ampher'],
        'billing_province' => $customerData['billl_province'],
        'billing_postcode' => $customerData['bill_postcode'],
        'billing_branch_type' => $customerData['h_ckk'],
        'billing_branch_no' => $customerData['brun_no'],
    );
}

if (empty($shippingRecords)) {
    $shippingRecords[] = array(
        'shipping_name' => $customerData['delivery_name'],
        'shipping_tel' => $customerData['del_tel'],
        'shipping_address' => $customerData['del_address'],
        'shipping_ampher' => $customerData['del_ampher'],
        'shipping_province' => $customerData['del_province'],
        'shipping_postcode' => $customerData['del_postcode'],
    );
}
?>

<link rel="stylesheet" href="css/credit-term-modal.css?v=<?php echo filemtime(__DIR__ . '/css/credit-term-modal.css'); ?>">
<link rel="stylesheet" href="css/customer-add.css?v=<?php echo filemtime(__DIR__ . '/css/customer-add.css'); ?>">

<body>
    <div id="successPopup" class="success-popup" <?php echo $successMessage === '' ? 'hidden' : ''; ?>>
        <div class="success-popup-card" role="alertdialog" aria-modal="true" aria-labelledby="successPopupTitle" aria-describedby="successPopupMessage">
            <div class="success-popup-icon">✓</div>
            <h2 id="successPopupTitle" class="success-popup-title">สำเร็จ</h2>
            <p id="successPopupMessage" class="success-popup-message"><?php echo h($successMessage); ?></p>
            <button type="button" class="success-popup-close" id="successPopupClose">ตกลง</button>
        </div>
    </div>

    <div id="confirmPopup" class="confirm-popup" hidden>
        <div class="confirm-popup-card" role="dialog" aria-modal="true" aria-labelledby="confirmPopupTitle" aria-describedby="confirmPopupMessage">
            <div class="confirm-popup-badge">?</div>
            <h2 id="confirmPopupTitle" class="confirm-popup-title">ยืนยันการทำรายการ</h2>
            <p id="confirmPopupMessage" class="confirm-popup-message"></p>
            <div class="confirm-popup-actions">
                <button type="button" class="confirm-popup-button cancel" id="confirmPopupCancel">ยกเลิก</button>
                <button type="button" class="confirm-popup-button confirm" id="confirmPopupConfirm">ยืนยัน</button>
            </div>
        </div>
    </div>

    <div id="deleteConfirmPopup" class="delete-popup" hidden>
        <div class="delete-popup-card" role="dialog" aria-modal="true" aria-labelledby="deletePopupTitle" aria-describedby="deletePopupMessage">
            <button type="button" class="delete-popup-close" id="deletePopupCloseIcon">&times;</button>
            <div class="delete-popup-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20V8H4V6Z" fill="#ff0000" />
                    <path d="M10 2H14V4H10V2Z" fill="#ff0000" />
                    <path d="M5 9H19V20C19 21.1046 18.1046 22 17 22H7C5.89543 22 5 21.1046 5 20V9Z" fill="#ff0000" />
                    <rect x="9" y="11" width="2" height="7" rx="1" fill="#ffffff" />
                    <rect x="13" y="11" width="2" height="7" rx="1" fill="#ffffff" />
                </svg>
            </div>
            <h2 id="deletePopupTitle" class="delete-popup-title">ลบข้อมูล ?</h2>
            <p id="deletePopupMessage" class="delete-popup-message"></p>
            <div class="delete-popup-actions">
                <button type="button" class="delete-popup-button confirm" id="deletePopupConfirm">ตกลง</button>
                <button type="button" class="delete-popup-button cancel" id="deletePopupCancel">ยกเลิก</button>
            </div>
        </div>
    </div>

    <div class="customer-page">
        <div class="customer-shell">
            <form method="POST" name="frmMain" id="customerForm" action="<?php echo h($formAction); ?>" enctype="multipart/form-data" class="customer-form" novalidate>
                <input type="hidden" name="submit" value="submit">
                <input type="hidden" name="customer_id" value="<?php echo h($customerData['customer_id']); ?>">
                <input type="hidden" name="customer_no" value="<?php echo h($customerData['customer_no']); ?>">
                <input type="hidden" name="close_ckk" value="<?php echo h($customerData['close_ckk']); ?>">
				<input type="hidden" name="credit_ckk" value="<?php echo h($customerData['credit_ckk']); ?>">
                <input type="hidden" name="credit_thb" value="<?php echo h($customerData['credit_thb']); ?>">

                <div class="customer-header">
                    <h1>ข้อมูลลูกค้า</h1>
                </div>

                <div class="customer-body">
                    <section class="section-block">
                        <div class="field-grid">
                            <div class="field">
                                <label class="field-label" for="customer_name">ชื่อลูกค้า<span class="required-mark">*</span></label>
                                <div class="input-shell">
                                    <input type="text" name="customer_name" id="customer_name" class="form-input js-clearable" value="<?php echo h($customerData['customer_name']); ?>" autocomplete="off" placeholder="Customer name" required>
                                    <button type="button" class="field-clear" data-clear-target="customer_name" aria-label="ล้างค่า">&times;</button>
                                </div>
                                <input type="hidden" name="customer_name_dup" id="customer_name_dup" value="0">
                                <div id="customer_name_msg" class="field-error"></div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="cus_tel">เบอร์โทร<span class="required-mark">*</span></label>
                                <div class="input-shell">
                                    <input type="text" name="cus_tel" id="cus_tel" class="form-input js-number-only js-clearable" value="<?php echo h($customerData['cus_tel']); ?>" inputmode="numeric" maxlength="15" placeholder="ใส่เฉพาะตัวเลข" required>
                                    <button type="button" class="field-clear" data-clear-target="cus_tel" aria-label="ล้างค่า">&times;</button>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="type_customer">ประเภทลูกค้า<span class="required-mark">*</span></label>
                                <div class="select-shell">
                                    <select name="type_customer" id="type_customer" class="form-select" required>
                                        <option value="">Select</option>
                                        <?php foreach ($typeCustomers as $typeCustomer) { ?>
                                            <option value="<?php echo h($typeCustomer['type_id']); ?>" <?php echo ((string)$customerData['type_customer'] === (string)$typeCustomer['type_id']) ? 'selected' : ''; ?>><?php echo h($typeCustomer['type_name']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="h_mode_name">กลุ่มลูกค้า<span class="required-mark">*</span></label>
                                <div class="select-shell">
                                    <select name="h_mode_name" id="h_mode_name" class="form-select" required>
                                        <option value="">Select</option>
                                        <?php if (!$currentModeFound) { ?>
                                            <option value="<?php echo h($currentMode); ?>" selected><?php echo h($currentMode); ?> (ไม่พบในรายการ)</option>
                                        <?php } ?>
                                        <?php foreach ($modeCustomers as $modeCustomer) { ?>
                                            <option value="<?php echo h($modeCustomer['id_mode']); ?>" <?php echo ((string)$modeCustomer['id_mode'] === $currentMode) ? 'selected' : ''; ?>><?php echo h($modeCustomer['mode_name']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="customer_code_display">รหัสสมาชิก (สถานะ)</label>
                                <div class="input-shell">
                                    <input type="text" id="customer_code_display" class="form-input" value="<?php echo h($customerData['customer_code'] !== '' ? $customerData['customer_code'] : 'Auto'); ?>" readonly>
                                </div>
                                <input type="hidden" name="customer_code" id="customer_code" value="<?php echo h($customerData['customer_code']); ?>">
                            </div>

                            <div class="field">
                                <label class="field-label">&nbsp;</label>
                                <div class="tag-pair">
                                    <label class="tag-toggle<?php echo !empty($customerData['vip_ckk']) ? ' is-active' : ''; ?>" id="vip_toggle">
                                        <input type="checkbox" value="1" id="vip_ckk" name="vip_ckk" <?php echo !empty($customerData['vip_ckk']) ? 'checked' : ''; ?>>
                                        <span>VIP</span>
                                    </label>
                                    <!-- id display_credit_thb_trigger / h_bill_id ตายตัวตาม js/credit-term-modal.js -->
                                    <button type="button" class="credit-term-button" id="display_credit_thb_trigger" onclick="openCreditTermPopup()" <?php echo $isEditMode ? '' : 'disabled title="บันทึกข้อมูลลูกค้าก่อน จึงจะดูเครดิตเทอมได้"'; ?>>
                                        <img src="img/icons/credit_term.svg" alt="" aria-hidden="true">
                                        <span>เครดิตเทอม</span>
                                    </button>
                                    <input type="hidden" id="h_bill_id" value="<?php echo $isEditMode ? h($customerData['customer_id']) : ''; ?>">
                                </div>
                            </div>

                            <div class="field span-2">
                                <label class="field-label" for="cus_address">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน<span class="required-mark">*</span></label>
                                <div class="input-shell">
                                    <input type="text" name="cus_address" id="cus_address" class="form-input js-clearable" value="<?php echo h($customerData['cus_address']); ?>" placeholder="ใส่รายละเอียดที่อยู่" required>
                                    <button type="button" class="field-clear" data-clear-target="cus_address" aria-label="ล้างค่า">&times;</button>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="cus_province">จังหวัด<span class="required-mark">*</span></label>
                                <div class="select-shell">
                                    <select name="cus_province" id="cus_province" class="form-select" required>
                                        <option value="">Select</option>
                                        <?php foreach ($provinces as $province) { ?>
                                            <option value="<?php echo h($province['province_name']); ?>" <?php echo ($customerData['cus_province'] === $province['province_name']) ? 'selected' : ''; ?>><?php echo h($province['province_name']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="cus_ampher">เขต/อำเภอ<span class="required-mark">*</span></label>
                                <div class="input-shell">
                                    <input type="text" name="cus_ampher" id="cus_ampher" class="form-input js-clearable" value="<?php echo h($customerData['cus_ampher']); ?>" placeholder="District / Amphur" required>
                                    <button type="button" class="field-clear" data-clear-target="cus_ampher" aria-label="ล้างค่า">&times;</button>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="cus_postcode">รหัสไปรษณีย์<span class="required-mark">*</span></label>
                                <div class="input-shell">
                                    <input type="text" name="cus_postcode" id="cus_postcode" class="form-input js-number-only js-clearable" value="<?php echo h($customerData['cus_postcode']); ?>" inputmode="numeric" maxlength="10" placeholder="Postcode" required>
                                    <button type="button" class="field-clear" data-clear-target="cus_postcode" aria-label="ล้างค่า">&times;</button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="section-block">
                        <h2 class="section-title">ข้อมูลการออกบิล</h2>
                        <div class="pill-actions">
                            <button type="button" class="outline-pill" id="copyCustomerToBilling"><img src="img/icons/home.png" alt="">ใช้ข้อมูลเดียวกับข้อมูลลูกค้า</button>
                            <button type="button" class="outline-pill" id="addBillingCard"><img src="img/icons/add_message.png" alt="">เพิ่มข้อมูลการออกบิล</button>
                        </div>

                        <div id="billingCards" class="card-list">
                            <?php foreach ($billingRecords as $index => $billing) { ?>
                                <?php
                                // บิล 1 ใช้รหัสลูกค้าหลัก บิล 2+ ใช้รหัสของแถวนั้นเอง
                                $billingCode = $index === 0 ? trim((string)$customerData['customer_code']) : trim((string)($billing['billing_code'] ?? ''));
                                $billingCoden = $index === 0 ? trim((string)$customerData['customer_coden']) : trim((string)($billing['billing_coden'] ?? ''));
                                ?>
                                <div class="sub-card billing-card" data-billing-index="<?php echo h($index); ?>">
                                    <div class="sub-card-header">
                                        <h3 class="sub-card-title">ที่อยู่ออกบิล <?php echo h($index + 1); ?></h3>
                                    </div>

                                    <div class="field-grid">
                                        <div class="field">
                                            <label class="field-label">รหัสลูกค้า AWL</label>
                                            <div class="code-run-row js-code-row" data-code-type="awl">
                                                <div class="input-shell"><input type="text" class="form-input js-code-display" value="<?php echo h($billingCode !== '' ? $billingCode : 'Auto'); ?>" readonly></div>
                                                <input type="hidden" class="js-code-value" name="billing_code[]" value="<?php echo h($billingCode); ?>" data-saved-code="<?php echo h($billingCode); ?>">
                                                <button type="button" class="code-run-button js-code-run">
                                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                                        <rect x="2.5" y="4.5" width="19" height="15" rx="3.5"></rect>
                                                        <circle cx="8.5" cy="10.5" r="2"></circle>
                                                        <path d="M5.5 16c.6-1.6 1.7-2.4 3-2.4s2.4.8 3 2.4"></path>
                                                        <path d="M14.5 10h4"></path>
                                                        <path d="M14.5 14h4"></path>
                                                    </svg>
                                                    Run รหัสลูกค้า
                                                </button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">รหัสลูกค้า NBM</label>
                                            <div class="code-run-row js-code-row" data-code-type="nbm">
                                                <div class="input-shell"><input type="text" class="form-input js-code-display" value="<?php echo h($billingCoden !== '' ? $billingCoden : 'Auto'); ?>" readonly></div>
                                                <input type="hidden" class="js-code-value" name="billing_coden[]" value="<?php echo h($billingCoden); ?>" data-saved-code="<?php echo h($billingCoden); ?>">
                                                <button type="button" class="code-run-button js-code-run">
                                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                                        <rect x="2.5" y="4.5" width="19" height="15" rx="3.5"></rect>
                                                        <circle cx="8.5" cy="10.5" r="2"></circle>
                                                        <path d="M5.5 16c.6-1.6 1.7-2.4 3-2.4s2.4.8 3 2.4"></path>
                                                        <path d="M14.5 10h4"></path>
                                                        <path d="M14.5 14h4"></path>
                                                    </svg>
                                                    Run รหัสลูกค้า
                                                </button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">ชื่อในการออกบิล<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-clearable billing-name" name="billing_name[]" value="<?php echo h($billing['billing_name'] ?? ''); ?>" placeholder="Billing name" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">เลขประจำตัวผู้เสียภาษี<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-number-only js-clearable billing-tax-id" name="billing_tax_id[]" value="<?php echo h($billing['billing_tax_id'] ?? ''); ?>" inputmode="numeric" maxlength="20" placeholder="Tax ID" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">เบอร์โทร<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-number-only js-clearable billing-tel" name="billing_tel[]" value="<?php echo h($billing['billing_tel'] ?? ''); ?>" inputmode="numeric" maxlength="15" placeholder="Phone number" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">E-mail<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="email" class="form-input js-clearable billing-email" name="billing_email[]" value="<?php echo h($billing['billing_email'] ?? ''); ?>" placeholder="email@example.com" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>

                                        <div class="field span-3">
                                            <label class="field-label">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-clearable billing-address" name="billing_address[]" value="<?php echo h($billing['billing_address'] ?? ''); ?>" placeholder="Billing address" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">จังหวัด<span class="required-mark">*</span></label>
                                            <div class="select-shell">
                                                <select class="form-select billing-province" name="billing_province[]" required>
                                                    <option value="">Select</option>
                                                    <?php foreach ($provinces as $province) { ?>
                                                        <option value="<?php echo h($province['province_name']); ?>" <?php echo (($billing['billing_province'] ?? '') === $province['province_name']) ? 'selected' : ''; ?>><?php echo h($province['province_name']); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">เขต/อำเภอ<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-clearable billing-ampher" name="billing_ampher[]" value="<?php echo h($billing['billing_ampher'] ?? ''); ?>" placeholder="District / Amphur" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">รหัสไปรษณีย์<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-number-only js-clearable billing-postcode" name="billing_postcode[]" value="<?php echo h($billing['billing_postcode'] ?? ''); ?>" inputmode="numeric" maxlength="10" placeholder="Postcode" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">เลือกสาขา<span class="required-mark">*</span></label>
                                            <div class="select-shell">
                                                <select class="form-select billing-branch-type" name="billing_branch_type[]" required>
                                                    <option value="">Select</option>
                                                    <option value="1" <?php echo (($billing['billing_branch_type'] ?? '') === '1') ? 'selected' : ''; ?>>สำนักงานใหญ่</option>
                                                    <option value="2" <?php echo (($billing['billing_branch_type'] ?? '') === '2') ? 'selected' : ''; ?>>สาขา</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">เลขที่สาขา<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-number-only js-clearable billing-branch-no" name="billing_branch_no[]" value="<?php echo h($billing['billing_branch_no'] ?? ''); ?>" inputmode="numeric" maxlength="10" placeholder="Branch number" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>
                                        <div class="field field-action">
                                            <button type="button" class="danger-button remove-billing-card" <?php echo $index === 0 ? 'hidden' : ''; ?>>
                                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M3 6h18"></path>
                                                    <path d="M8 6V4h8v2"></path>
                                                    <path d="M8 10v6"></path>
                                                    <path d="M12 10v6"></path>
                                                    <path d="M16 10v6"></path>
                                                    <path d="M6 6l1 14h10l1-14"></path>
                                                </svg>
                                                ลบข้อมูล
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </section>

                    <section class="section-block">
                        <h2 class="section-title">ข้อมูลการจัดส่ง</h2>
                        <div class="pill-actions">
                            <button type="button" class="outline-pill" id="copyCustomerToShipping"><img src="img/icons/home.png" alt="">ใช้ข้อมูลเดียวกับข้อมูลลูกค้า</button>
                            <button type="button" class="outline-pill" id="copyBillingToShipping"><img src="img/icons/home.png" alt="">ใช้ข้อมูลเดียวกับการออกบิล</button>
                            <button type="button" class="outline-pill" id="addShippingCard"><img src="img/icons/add_message.png" alt="">เพิ่มข้อมูลการจัดส่ง</button>
                        </div>

                        <div id="shippingCards" class="card-list">
                            <?php foreach ($shippingRecords as $index => $shipping) { ?>
                                <div class="sub-card shipping-card" data-shipping-index="<?php echo h($index); ?>">
                                    <div class="sub-card-header">
                                        <h3 class="sub-card-title">ที่อยู่จัดส่ง <?php echo h($index + 1); ?></h3>
                                    </div>

                                    <div class="field-grid">
                                        <div class="field">
                                            <label class="field-label">ชื่อผู้ติดต่อ<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-clearable shipping-name" name="shipping_name[]" value="<?php echo h($shipping['shipping_name'] ?? ''); ?>" placeholder="Contact name" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">เบอร์โทร<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-number-only js-clearable shipping-tel" name="shipping_tel[]" value="<?php echo h($shipping['shipping_tel'] ?? ''); ?>" inputmode="numeric" maxlength="15" placeholder="Phone number" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>
                                        <div class="field field-action">
                                            <button type="button" class="danger-button remove-shipping-card" <?php echo $index === 0 ? 'hidden' : ''; ?>>
                                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M3 6h18"></path>
                                                    <path d="M8 6V4h8v2"></path>
                                                    <path d="M8 10v6"></path>
                                                    <path d="M12 10v6"></path>
                                                    <path d="M16 10v6"></path>
                                                    <path d="M6 6l1 14h10l1-14"></path>
                                                </svg>
                                                ลบข้อมูล
                                            </button>
                                        </div>

                                        <div class="field span-3">
                                            <label class="field-label">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-clearable shipping-address" name="shipping_address[]" value="<?php echo h($shipping['shipping_address'] ?? ''); ?>" placeholder="Shipping address" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">จังหวัด<span class="required-mark">*</span></label>
                                            <div class="select-shell">
                                                <select class="form-select shipping-province" name="shipping_province[]" required>
                                                    <option value="">Select</option>
                                                    <?php foreach ($provinces as $province) { ?>
                                                        <option value="<?php echo h($province['province_name']); ?>" <?php echo (($shipping['shipping_province'] ?? '') === $province['province_name']) ? 'selected' : ''; ?>><?php echo h($province['province_name']); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">เขต/อำเภอ<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-clearable shipping-ampher" name="shipping_ampher[]" value="<?php echo h($shipping['shipping_ampher'] ?? ''); ?>" placeholder="District / Amphur" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">รหัสไปรษณีย์<span class="required-mark">*</span></label>
                                            <div class="input-shell">
                                                <input type="text" class="form-input js-number-only js-clearable shipping-postcode" name="shipping_postcode[]" value="<?php echo h($shipping['shipping_postcode'] ?? ''); ?>" inputmode="numeric" maxlength="10" placeholder="Postcode" required>
                                                <button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </section>

                    <section class="section-block">
                        <h2 class="section-title">ที่อยู่ผู้เช่า</h2>
                        <div class="field-grid">
                            <div class="field span-3">
                                <label class="field-label" for="rental_address">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน</label>
                                <div class="input-shell">
                                    <input type="text" name="rental_address" id="rental_address" class="form-input js-clearable" value="<?php echo h($customerData['rental_address']); ?>" placeholder="ใส่รายละเอียดที่อยู่ผู้เช่า">
                                    <button type="button" class="field-clear" data-clear-target="rental_address" aria-label="ล้างค่า">&times;</button>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="rental_province">จังหวัด</label>
                                <div class="select-shell">
                                    <select name="rental_province" id="rental_province" class="form-select">
                                        <option value="">Select</option>
                                        <?php foreach ($provinces as $province) { ?>
                                            <option value="<?php echo h($province['province_name']); ?>" <?php echo ($customerData['rental_province'] === $province['province_name']) ? 'selected' : ''; ?>><?php echo h($province['province_name']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="rental_ampher">เขต/อำเภอ</label>
                                <div class="input-shell">
                                    <input type="text" name="rental_ampher" id="rental_ampher" class="form-input js-clearable" value="<?php echo h($customerData['rental_ampher']); ?>" placeholder="กรอกเขต / อำเภอ">
                                    <button type="button" class="field-clear" data-clear-target="rental_ampher" aria-label="ล้างค่า">&times;</button>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="rental_postcode">รหัสไปรษณีย์</label>
                                <div class="input-shell">
                                    <input type="text" name="rental_postcode" id="rental_postcode" class="form-input js-number-only js-clearable" value="<?php echo h($customerData['rental_postcode']); ?>" inputmode="numeric" maxlength="10" placeholder="ใส่เฉพาะตัวเลข">
                                    <button type="button" class="field-clear" data-clear-target="rental_postcode" aria-label="ล้างค่า">&times;</button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="section-block">
    <h2 class="section-title">สิทธิ์การใช้งาน</h2>

    <div class="field-grid">
        <div class="field span-3">

            <label class="field-label">
                เขตการขาย<span class="required-mark">*</span>
            </label>

            <?php if ($typeLoginLower === 'sale') { ?>

                <!-- Sale: ล็อกเขตเป็นของตัวเอง -->
                <input
                    type="hidden"
                    name="sale_code[]"
                    value="<?php echo h($userSaleCode); ?>"
                >

                <div class="input-shell">
                    <input
                        type="text"
                        class="form-input is-locked"
                        value="<?php echo h($userSaleCode); ?>"
                        readonly
                    >
                </div>

            <?php } else { ?>

                <!-- User อื่น: เลือกได้ตามสิทธิ์ -->
                <div class="multi-select" id="saleCodeSelect">

                    <input
                        type="text"
                        class="multi-select-summary"
                        id="saleCodeSummary"
                        value="Select"
                        readonly
                        aria-haspopup="listbox"
                    >

                    <div class="multi-select-panel">

                        <?php foreach ($saleTeams as $saleTeam) { ?>

                            <label class="multi-option">

                                <input
                                    type="checkbox"
                                    name="sale_code[]"
                                    value="<?php echo h($saleTeam['sale_code']); ?>"
                                    <?php
                                    echo in_array(
                                        $saleTeam['sale_code'],
                                        $selectedSaleCodes,
                                        true
                                    ) ? 'checked' : '';
                                    ?>
                                >

                                <span>
                                    <?php echo h($saleTeam['sale_code']); ?>
                                </span>

                            </label>

                        <?php } ?>

                    </div>

                </div>

            <?php } ?>

            <div class="field-error" id="saleCodeError"></div>

        </div>
    </div>

    <div class="customer-actions">
        <button type="submit" class="primary-button">
            <?php if (!$isEditMode) { ?><img src="img/icons/add_user.png" alt="Add User"><?php } ?>
            <span id="submitCustomerButtonText"><?php echo $isEditMode ? 'อัพเดต' : 'เพิ่มลูกค้า'; ?></span>
        </button>
        <a href="register_suphos.php" class="ghost-button">ยกเลิก</a>
    </div>
</section>

                    <div class="hidden-fields">
                        <input type="hidden" name="bill_name" id="legacy_bill_name" value="<?php echo h($customerData['bill_name']); ?>">
                        <input type="hidden" name="bill_address" id="legacy_bill_address" value="<?php echo h($customerData['bill_address']); ?>">
                        <input type="hidden" name="bill_ampher" id="legacy_bill_ampher" value="<?php echo h($customerData['bill_ampher']); ?>">
                        <input type="hidden" name="billl_province" id="legacy_bill_province" value="<?php echo h($customerData['billl_province']); ?>">
                        <input type="hidden" name="bill_postcode" id="legacy_bill_postcode" value="<?php echo h($customerData['bill_postcode']); ?>">
                        <input type="hidden" name="bill_tel" id="legacy_bill_tel" value="<?php echo h($customerData['bill_tel']); ?>">
                        <input type="hidden" name="tax_id" id="legacy_tax_id" value="<?php echo h($customerData['tax_id']); ?>">
                        <input type="hidden" name="email_cus" id="legacy_email_cus" value="<?php echo h($customerData['email_cus']); ?>">
                        <input type="hidden" name="h_ckk" id="legacy_h_ckk" value="<?php echo h($customerData['h_ckk']); ?>">
                        <input type="hidden" name="brun_no" id="legacy_brun_no" value="<?php echo h($customerData['brun_no']); ?>">
                        <input type="hidden" name="delivery_name" id="legacy_delivery_name" value="<?php echo h($customerData['delivery_name']); ?>">
                        <input type="hidden" name="del_address" id="legacy_del_address" value="<?php echo h($customerData['del_address']); ?>">
                        <input type="hidden" name="del_ampher" id="legacy_del_ampher" value="<?php echo h($customerData['del_ampher']); ?>">
                        <input type="hidden" name="del_province" id="legacy_del_province" value="<?php echo h($customerData['del_province']); ?>">
                        <input type="hidden" name="del_postcode" id="legacy_del_postcode" value="<?php echo h($customerData['del_postcode']); ?>">
                        <input type="hidden" name="del_tel" id="legacy_del_tel" value="<?php echo h($customerData['del_tel']); ?>">
                        <input type="hidden" name="contact_name" id="legacy_contact_name" value="<?php echo h($customerData['contact_name']); ?>">
                        <input type="hidden" name="ckk_1" id="legacy_ckk_1" value="0">
                        <input type="hidden" name="ckk_2" id="legacy_ckk_2" value="0">
                        <input type="hidden" name="ckk_3" value="0">
                        <input type="hidden" name="warranty" value="">
                        <input type="hidden" name="cus_fax" value="<?php echo h($customerData['cus_fax']); ?>">
                        <input type="hidden" name="rental_name" value="">
                        <input type="hidden" name="rental_tel" value="">
                        <input type="hidden" name="rental_emer" value="">
                        <input type="hidden" name="rental_emertel" value="">
                        <input type="hidden" name="rental_contact" value="">
                        <input type="hidden" name="rental_contacttel" value="">
                        <input type="hidden" name="patient_name" value="">
                        <input type="hidden" name="install_address" value="">
                    </div>
                </div>
            </form>

        </div>
    </div>

    <template id="billingCardTemplate">
        <div class="sub-card billing-card" data-billing-index="__INDEX__">
            <div class="sub-card-header">
                <h3 class="sub-card-title">ที่อยู่ออกบิล __NUMBER__</h3>
            </div>
            <div class="field-grid">
                <div class="field"><label class="field-label">รหัสลูกค้า AWL</label>
                    <div class="code-run-row js-code-row" data-code-type="awl">
                        <div class="input-shell"><input type="text" class="form-input js-code-display" value="Auto" readonly></div>
                        <input type="hidden" class="js-code-value" name="billing_code[]" value="" data-saved-code="">
                        <button type="button" class="code-run-button js-code-run">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="2.5" y="4.5" width="19" height="15" rx="3.5"></rect>
                                <circle cx="8.5" cy="10.5" r="2"></circle>
                                <path d="M5.5 16c.6-1.6 1.7-2.4 3-2.4s2.4.8 3 2.4"></path>
                                <path d="M14.5 10h4"></path>
                                <path d="M14.5 14h4"></path>
                            </svg>
                            Run รหัสลูกค้า
                        </button>
                    </div>
                </div>
                <div class="field"><label class="field-label">รหัสลูกค้า NBM</label>
                    <div class="code-run-row js-code-row" data-code-type="nbm">
                        <div class="input-shell"><input type="text" class="form-input js-code-display" value="Auto" readonly></div>
                        <input type="hidden" class="js-code-value" name="billing_coden[]" value="" data-saved-code="">
                        <button type="button" class="code-run-button js-code-run">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="2.5" y="4.5" width="19" height="15" rx="3.5"></rect>
                                <circle cx="8.5" cy="10.5" r="2"></circle>
                                <path d="M5.5 16c.6-1.6 1.7-2.4 3-2.4s2.4.8 3 2.4"></path>
                                <path d="M14.5 10h4"></path>
                                <path d="M14.5 14h4"></path>
                            </svg>
                            Run รหัสลูกค้า
                        </button>
                    </div>
                </div>
                <div class="field"><label class="field-label">ชื่อในการออกบิล<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-clearable billing-name" name="billing_name[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">เลขประจำตัวผู้เสียภาษี<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-number-only js-clearable billing-tax-id" name="billing_tax_id[]" inputmode="numeric" maxlength="20" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">เบอร์โทร<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-number-only js-clearable billing-tel" name="billing_tel[]" inputmode="numeric" maxlength="15" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">E-mail<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="email" class="form-input js-clearable billing-email" name="billing_email[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field span-3"><label class="field-label">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-clearable billing-address" name="billing_address[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">จังหวัด<span class="required-mark">*</span></label>
                    <div class="select-shell"><select class="form-select billing-province" name="billing_province[]" required>
                            <option value="">Select</option><?php foreach ($provinces as $province) { ?><option value="<?php echo h($province['province_name']); ?>"><?php echo h($province['province_name']); ?></option><?php } ?>
                        </select></div>
                </div>
                <div class="field"><label class="field-label">เขต/อำเภอ<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-clearable billing-ampher" name="billing_ampher[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">รหัสไปรษณีย์<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-number-only js-clearable billing-postcode" name="billing_postcode[]" inputmode="numeric" maxlength="10" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">เลือกสาขา<span class="required-mark">*</span></label>
                    <div class="select-shell"><select class="form-select billing-branch-type" name="billing_branch_type[]" required>
                            <option value="">Select</option>
                            <option value="1">สำนักงานใหญ่</option>
                            <option value="2">สาขา</option>
                        </select></div>
                </div>
                <div class="field"><label class="field-label">เลขที่สาขา<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-number-only js-clearable billing-branch-no" name="billing_branch_no[]" inputmode="numeric" maxlength="10" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field field-action">
                    <button type="button" class="danger-button remove-billing-card">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 6h18"></path>
                            <path d="M8 6V4h8v2"></path>
                            <path d="M8 10v6"></path>
                            <path d="M12 10v6"></path>
                            <path d="M16 10v6"></path>
                            <path d="M6 6l1 14h10l1-14"></path>
                        </svg>
                        ลบข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </template>

    <template id="shippingCardTemplate">
        <div class="sub-card shipping-card" data-shipping-index="__INDEX__">
            <div class="sub-card-header">
                <h3 class="sub-card-title">ที่อยู่จัดส่ง __NUMBER__</h3>
            </div>
            <div class="field-grid">
                <div class="field"><label class="field-label">ชื่อผู้ติดต่อ<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-clearable shipping-name" name="shipping_name[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">เบอร์โทร<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-number-only js-clearable shipping-tel" name="shipping_tel[]" inputmode="numeric" maxlength="15" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field field-action">
                    <button type="button" class="danger-button remove-shipping-card">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 6h18"></path>
                            <path d="M8 6V4h8v2"></path>
                            <path d="M8 10v6"></path>
                            <path d="M12 10v6"></path>
                            <path d="M16 10v6"></path>
                            <path d="M6 6l1 14h10l1-14"></path>
                        </svg>
                        ลบข้อมูล
                    </button>
                </div>
                <div class="field span-3"><label class="field-label">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-clearable shipping-address" name="shipping_address[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">จังหวัด<span class="required-mark">*</span></label>
                    <div class="select-shell"><select class="form-select shipping-province" name="shipping_province[]" required>
                            <option value="">Select</option><?php foreach ($provinces as $province) { ?><option value="<?php echo h($province['province_name']); ?>"><?php echo h($province['province_name']); ?></option><?php } ?>
                        </select></div>
                </div>
                <div class="field"><label class="field-label">เขต/อำเภอ<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-clearable shipping-ampher" name="shipping_ampher[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">รหัสไปรษณีย์<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-number-only js-clearable shipping-postcode" name="shipping_postcode[]" inputmode="numeric" maxlength="10" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
            </div>
        </div>
    </template>

    <!-- Popup เครดิตเทอม (ใช้ระบบร่วมกับ register_suphos.php ผ่าน js/credit-term-modal.js) — อยู่นอก form เพื่อไม่ให้ Enter ในช่องติดตามไป submit ฟอร์มลูกค้า -->
    <div id="creditTermPopupModal" aria-hidden="true">
        <div class="credit-term-popup-box" role="dialog" aria-modal="true" aria-labelledby="creditTermPopupTitle">
            <button type="button" class="customer-popup-close" onclick="closeCreditTermPopup()" aria-label="Close">&times;</button>
            <div class="clear-loan-header">
                <h2 id="creditTermPopupTitle">เครดิตเทอม</h2>
            </div>
            <div class="credit-term-popup-content">
                <div class="credit-term-summary">
                    <div class="credit-term-summary-item">
                        <p class="credit-term-summary-label">เครดิต (วัน)</p>
                        <p class="credit-term-summary-value" id="creditTermSummaryDay">-</p>
                    </div>
                    <div class="credit-term-summary-item">
                        <p class="credit-term-summary-label">เครดิต (ยอดเงิน)</p>
                        <p class="credit-term-summary-value" id="creditTermSummaryAmount">0.00</p>
                    </div>
                    <div class="credit-term-summary-item">
                        <p class="credit-term-summary-label">ยอดรวมหนี้คงค้าง</p>
                        <p class="credit-term-summary-value" id="creditTermSummaryOutstanding">0.00</p>
                    </div>
                    <div class="credit-term-summary-item is-highlight">
                        <p class="credit-term-summary-label">ยอดเครดิตคงเหลือ</p>
                        <p class="credit-term-summary-value" id="creditTermSummaryRemaining">0.00</p>
                    </div>
                </div>
                <div class="credit-term-table-panel">
                    <div class="credit-term-table-wrap">
                        <table class="credit-term-table">
                            <thead>
                                <tr>
                                    <th scope="col" aria-label="เลือก"></th>
                                    <th scope="col">เลขที่ใบสั่งขาย</th>
                                    <th scope="col">รายการสินค้า</th>
                                    <th scope="col">ยอดที่ต้องชำระ</th>
                                    <th scope="col">ยอดชำระแล้ว</th>
                                    <th scope="col">ยอดหนี้คงค้าง</th>
                                </tr>
                            </thead>
                            <tbody id="creditTermTableBody">
                                <tr class="credit-term-empty-row">
                                    <td><span class="credit-term-caret" aria-hidden="true"></span></td>
                                    <td colspan="5">เลือกลูกค้าแล้วกดเปิดเครดิตเทอมเพื่อดูข้อมูล</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/credit-term-modal.js?v=<?php echo filemtime(__DIR__ . '/js/credit-term-modal.js'); ?>"></script>
    <script>
        (function() {
            var creditTermModal = document.getElementById("creditTermPopupModal");
            creditTermModal.addEventListener("click", function(event) {
                if (event.target === creditTermModal) closeCreditTermPopup();
            });
            document.addEventListener("keydown", function(event) {
                if (event.key === "Escape" && creditTermModal.style.display === "flex") closeCreditTermPopup();
            });
        })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function() {
            // การ์ดที่อยู่ออกบิลแต่ละใบรันรหัส AWL (billing_code[]) และ NBM (billing_coden[]) ของตัวเอง ชุดเลขแยกกัน
            // บิล 1 = รหัสลูกค้าหลัก บันทึกจริง + เช็คซ้ำตอนกดบันทึกฟอร์ม ผูก event แบบ delegation ให้ครอบคลุมการ์ดที่เพิ่มทีหลัง
            var codeLabels = {
                awl: "รหัสลูกค้า AWL",
                nbm: "รหัสลูกค้า NBM"
            };

            function cardCodeInputs(row) {
                return {
                    display: row.querySelector(".js-code-display"),
                    value: row.querySelector(".js-code-value")
                };
            }

            function setCardCode(row, code) {
                var inputs = cardCodeInputs(row);
                inputs.value.value = code;
                inputs.display.value = code !== "" ? code : "Auto";

                // บิล 1 ของ AWL คือ tb_customer.customer_code ให้ช่องรหัสด้านบนตรงกัน
                if (row.dataset.codeType === "awl" && row.closest(".billing-card") === document.querySelector("#billingCards .billing-card")) {
                    document.getElementById("customer_code").value = code;
                    document.getElementById("customer_code_display").value = code !== "" ? code : "Auto";
                }
            }

            function runCode(row, button) {
                var type = row.dataset.codeType;
                var body = new URLSearchParams();
                body.append("type", type);
                document.querySelectorAll('#billingCards .js-code-row[data-code-type="' + type + '"] .js-code-value').forEach(function(input) {
                    if (input.closest(".js-code-row") !== row && input.value.trim() !== "") {
                        body.append("exclude[]", input.value.trim());
                    }
                });

                button.disabled = true;
                fetch("ajax_customer_run_code.php", {
                        method: "POST",
                        body: body
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(result) {
                        if (!result.success) {
                            throw new Error(result.message || "รันรหัสลูกค้าไม่สำเร็จ");
                        }
                        setCardCode(row, result.code);
                        Swal.fire({
                            icon: "success",
                            title: "รันรหัสลูกค้าแล้ว",
                            text: codeLabels[type] + ": " + result.code + " (บันทึกจริงตอนกดบันทึก หากเลขนี้ถูกใช้ไปก่อน ระบบจะรันเลขใหม่ให้อัตโนมัติ)"
                        });
                    })
                    .catch(function(error) {
                        Swal.fire({
                            icon: "error",
                            title: "เกิดข้อผิดพลาด",
                            text: error.message || "รันรหัสลูกค้าไม่สำเร็จ"
                        });
                    })
                    .finally(function() {
                        button.disabled = false;
                    });
            }

            document.addEventListener("click", function(event) {
                var button = event.target.closest(".js-code-run");
                if (!button) {
                    return;
                }

                var row = button.closest(".js-code-row");
                var codeInput = cardCodeInputs(row).value;
                var savedCode = codeInput.dataset.savedCode || "";

                // ถามเฉพาะตอนจะทับรหัสที่บันทึกในฐานแล้ว เลขที่เพิ่งรันในหน้านี้กดซ้ำได้เลย
                if (savedCode === "" || codeInput.value.trim() !== savedCode) {
                    runCode(row, button);
                    return;
                }

                Swal.fire({
                    icon: "warning",
                    title: "รัน" + codeLabels[row.dataset.codeType] + "ใหม่?",
                    html: "รหัสเดิม <b>" + savedCode.replace(/[&<>"']/g, "") + "</b> จะถูกแทนที่เมื่อกดบันทึก<br>เอกสารเดิมที่อ้างรหัสนี้จะไม่ถูกแก้ไข",
                    showCancelButton: true,
                    confirmButtonText: "รันรหัสใหม่",
                    cancelButtonText: "ยกเลิก",
                    confirmButtonColor: "#612989"
                }).then(function(choice) {
                    if (choice.isConfirmed) {
                        runCode(row, button);
                    }
                });
            });
        })();

        (function() {
            var form = document.getElementById("customerForm");
            var successPopup = document.getElementById("successPopup");
            var successPopupClose = document.getElementById("successPopupClose");
            var confirmPopup = document.getElementById("confirmPopup");
            var confirmPopupTitle = document.getElementById("confirmPopupTitle");
            var confirmPopupMessage = document.getElementById("confirmPopupMessage");
            var confirmPopupCancel = document.getElementById("confirmPopupCancel");
            var confirmPopupConfirm = document.getElementById("confirmPopupConfirm");
            var billingCards = document.getElementById("billingCards");
            var shippingCards = document.getElementById("shippingCards");
            var billingTemplate = document.getElementById("billingCardTemplate").innerHTML;
            var shippingTemplate = document.getElementById("shippingCardTemplate").innerHTML;
            var saleCodeSelect = document.getElementById("saleCodeSelect");
            var saleCodeSummary = document.getElementById("saleCodeSummary");
            var saleCodeError = document.getElementById("saleCodeError");
            var nativeFormSubmit = window.HTMLFormElement && window.HTMLFormElement.prototype ? window.HTMLFormElement.prototype.submit : null;
            var customerNameInput = document.getElementById("customer_name");
            var customerDupInput = document.getElementById("customer_name_dup");
            var customerMsg = document.getElementById("customer_name_msg");
            var customerIdInput = form.querySelector("input[name='customer_id']");
            var duplicateNames = [];
            var lastCheckedName = "";
            var duplicateAlertShown = false;
            var confirmPopupResolver = null;
            var deleteConfirmPopup = document.getElementById("deleteConfirmPopup");
            var deleteConfirmPopupResolver = null;

            function bindClearables(scope) {
                scope.querySelectorAll(".field-clear").forEach(function(button) {
                    if (button.dataset.bound === "1") return;
                    button.dataset.bound = "1";
                    var targetId = button.getAttribute("data-clear-target");
                    var target = targetId ? document.getElementById(targetId) : button.parentElement.querySelector("input, textarea");
                    if (!target) return;
                    var wrapper = target.parentElement;

                    function sync() {
                        wrapper.classList.toggle("has-value", !!target.value);
                    }
                    target.addEventListener("input", sync);
                    target.addEventListener("change", sync);
                    button.addEventListener("click", function() {
                        target.value = "";
                        target.dispatchEvent(new Event("input", {
                            bubbles: true
                        }));
                        target.focus();
                    });
                    sync();
                });
            }

            function bindNumberOnly(scope) {
                scope.querySelectorAll(".js-number-only").forEach(function(input) {
                    if (input.dataset.bound === "1") return;
                    input.dataset.bound = "1";
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^0-9]/g, "");
                    });
                });
            }

            function applyPlaceholders(scope) {
                var placeholders = {
                    "#customer_name": "กรอกชื่อลูกค้า",
                    "#cus_tel": "ใส่เฉพาะตัวเลข",
                    "#cus_address": "กรอกรายละเอียดที่อยู่",
                    "#cus_ampher": "กรอกเขต / อำเภอ",
                    "#cus_postcode": "ใส่เฉพาะตัวเลข",
                    ".billing-name": "กรอกชื่อสำหรับออกบิล",
                    ".billing-tax-id": "ใส่เฉพาะตัวเลข",
                    ".billing-tel": "ใส่เฉพาะตัวเลข",
                    ".billing-email": "กรอกอีเมล",
                    ".billing-address": "กรอกรายละเอียดที่อยู่ออกบิล",
                    ".billing-ampher": "กรอกเขต / อำเภอ",
                    ".billing-postcode": "ใส่เฉพาะตัวเลข",
                    ".billing-branch-no": "ใส่เฉพาะตัวเลข",
                    ".shipping-name": "กรอกชื่อผู้ติดต่อ",
                    ".shipping-tel": "ใส่เฉพาะตัวเลข",
                    ".shipping-address": "กรอกรายละเอียดที่อยู่จัดส่ง",
                    ".shipping-ampher": "กรอกเขต / อำเภอ",
                    ".shipping-postcode": "ใส่เฉพาะตัวเลข"
                };

                Object.keys(placeholders).forEach(function(selector) {
                    scope.querySelectorAll(selector).forEach(function(element) {
                        element.setAttribute("placeholder", placeholders[selector]);
                    });
                });
            }

            function setSelectValue(select, value) {
                if (!select) return;
                var found = Array.prototype.some.call(select.options, function(option) {
                    return option.value === value;
                });
                select.value = found ? value : "";
            }

            function getCustomerSnapshot() {
                return {
                    name: document.getElementById("customer_name").value.trim(),
                    tel: document.getElementById("cus_tel").value.trim(),
                    address: document.getElementById("cus_address").value.trim(),
                    province: document.getElementById("cus_province").value,
                    ampher: document.getElementById("cus_ampher").value.trim(),
                    postcode: document.getElementById("cus_postcode").value.trim()
                };
            }

            function updateVipState() {
                document.getElementById("vip_toggle").classList.toggle("is-active", document.getElementById("vip_ckk").checked);
            }

            function updateTitles() {
                billingCards.querySelectorAll(".billing-card").forEach(function(card, index) {
                    card.querySelector(".sub-card-title").textContent = "ที่อยู่ออกบิล " + (index + 1);
                    var removeButton = card.querySelector(".remove-billing-card");
                    if (removeButton) removeButton.hidden = index === 0;
                });
                shippingCards.querySelectorAll(".shipping-card").forEach(function(card, index) {
                    card.querySelector(".sub-card-title").textContent = "ที่อยู่จัดส่ง " + (index + 1);
                    var removeButton = card.querySelector(".remove-shipping-card");
                    if (removeButton) removeButton.hidden = index === 0;
                });
            }

            function updateSaleCodeSummary() {
                var checked = saleCodeSelect.querySelectorAll("input[type='checkbox']:checked");
                var values = Array.prototype.map.call(checked, function(input) {
                    return input.value;
                });
                saleCodeSummary.value = values.length ? values.join(", ") : "Select";
                saleCodeError.textContent = "";
            }

            function setActivePill(button, groupSelector) {
                var shouldActivate = button ? !button.classList.contains("is-active") : false;
                document.querySelectorAll(groupSelector).forEach(function(item) {
                    item.classList.remove("is-active");
                });
                if (button && shouldActivate) {
                    button.classList.add("is-active");
                }
            }

            function clearActivePills(groupSelector) {
                document.querySelectorAll(groupSelector).forEach(function(item) {
                    item.classList.remove("is-active");
                });
            }

            function showDuplicateNames(names) {
                customerMsg.textContent = "";
                if (!names.length) return;

                var title = document.createElement("div");
                title.textContent = "มีชื่อลูกค้าใกล้เคียงในระบบ:";
                customerMsg.appendChild(title);

                names.forEach(function(name) {
                    var item = document.createElement("div");
                    item.textContent = "- " + name;
                    customerMsg.appendChild(item);
                });
            }

            function appendBillingCard() {
                var count = billingCards.querySelectorAll(".billing-card").length;
                clearActivePills("#copyCustomerToBilling");
                billingCards.insertAdjacentHTML("beforeend", billingTemplate.replace(/__INDEX__/g, count).replace(/__NUMBER__/g, count + 1));
                bindDynamic(billingCards.lastElementChild);
                updateTitles();
            }

            function appendShippingCard() {
                var count = shippingCards.querySelectorAll(".shipping-card").length;
                clearActivePills("#copyCustomerToShipping, #copyBillingToShipping");
                shippingCards.insertAdjacentHTML("beforeend", shippingTemplate.replace(/__INDEX__/g, count).replace(/__NUMBER__/g, count + 1));
                bindDynamic(shippingCards.lastElementChild);
                updateTitles();
            }

            function copyCustomerToBilling() {
                var data = getCustomerSnapshot();
                billingCards.querySelectorAll(".billing-card").forEach(function(card) {
                    card.querySelector(".billing-name").value = data.name;
                    card.querySelector(".billing-tel").value = data.tel;
                    card.querySelector(".billing-address").value = data.address;
                    setSelectValue(card.querySelector(".billing-province"), data.province);
                    card.querySelector(".billing-ampher").value = data.ampher;
                    card.querySelector(".billing-postcode").value = data.postcode;
                    setSelectValue(card.querySelector(".billing-branch-type"), "1");
                    if (!card.querySelector(".billing-branch-no").value.trim()) {
                        card.querySelector(".billing-branch-no").value = "00000";
                    }
                });
                document.getElementById("legacy_ckk_1").value = "1";
                syncClearStates(document);
            }

            function copyCustomerToShipping() {
                var data = getCustomerSnapshot();
                shippingCards.querySelectorAll(".shipping-card").forEach(function(card) {
                    card.querySelector(".shipping-name").value = data.name;
                    card.querySelector(".shipping-tel").value = data.tel;
                    card.querySelector(".shipping-address").value = data.address;
                    setSelectValue(card.querySelector(".shipping-province"), data.province);
                    card.querySelector(".shipping-ampher").value = data.ampher;
                    card.querySelector(".shipping-postcode").value = data.postcode;
                });
                document.getElementById("legacy_ckk_2").value = "1";
                syncClearStates(document);
            }

            function copyBillingToShipping() {
                var firstBilling = billingCards.querySelector(".billing-card");
                if (!firstBilling) return;
                var billing = {
                    name: firstBilling.querySelector(".billing-name").value.trim(),
                    tel: firstBilling.querySelector(".billing-tel").value.trim(),
                    address: firstBilling.querySelector(".billing-address").value.trim(),
                    province: firstBilling.querySelector(".billing-province").value,
                    ampher: firstBilling.querySelector(".billing-ampher").value.trim(),
                    postcode: firstBilling.querySelector(".billing-postcode").value.trim()
                };
                shippingCards.querySelectorAll(".shipping-card").forEach(function(card) {
                    card.querySelector(".shipping-name").value = billing.name;
                    card.querySelector(".shipping-tel").value = billing.tel;
                    card.querySelector(".shipping-address").value = billing.address;
                    setSelectValue(card.querySelector(".shipping-province"), billing.province);
                    card.querySelector(".shipping-ampher").value = billing.ampher;
                    card.querySelector(".shipping-postcode").value = billing.postcode;
                });
                document.getElementById("legacy_ckk_2").value = "0";
                syncClearStates(document);
            }

            function syncLegacyFields() {
                var firstBilling = billingCards.querySelector(".billing-card");
                var firstShipping = shippingCards.querySelector(".shipping-card");
                if (firstBilling) {
                    document.getElementById("legacy_bill_name").value = firstBilling.querySelector(".billing-name").value.trim();
                    document.getElementById("legacy_bill_address").value = firstBilling.querySelector(".billing-address").value.trim();
                    document.getElementById("legacy_bill_ampher").value = firstBilling.querySelector(".billing-ampher").value.trim();
                    document.getElementById("legacy_bill_province").value = firstBilling.querySelector(".billing-province").value;
                    document.getElementById("legacy_bill_postcode").value = firstBilling.querySelector(".billing-postcode").value.trim();
                    document.getElementById("legacy_bill_tel").value = firstBilling.querySelector(".billing-tel").value.trim();
                    document.getElementById("legacy_tax_id").value = firstBilling.querySelector(".billing-tax-id").value.trim();
                    document.getElementById("legacy_email_cus").value = firstBilling.querySelector(".billing-email").value.trim();
                    document.getElementById("legacy_h_ckk").value = firstBilling.querySelector(".billing-branch-type").value;
                    document.getElementById("legacy_brun_no").value = firstBilling.querySelector(".billing-branch-no").value.trim();
                }
                if (firstShipping) {
                    document.getElementById("legacy_delivery_name").value = firstShipping.querySelector(".shipping-name").value.trim();
                    document.getElementById("legacy_del_address").value = firstShipping.querySelector(".shipping-address").value.trim();
                    document.getElementById("legacy_del_ampher").value = firstShipping.querySelector(".shipping-ampher").value.trim();
                    document.getElementById("legacy_del_province").value = firstShipping.querySelector(".shipping-province").value;
                    document.getElementById("legacy_del_postcode").value = firstShipping.querySelector(".shipping-postcode").value.trim();
                    document.getElementById("legacy_del_tel").value = firstShipping.querySelector(".shipping-tel").value.trim();
                    document.getElementById("legacy_contact_name").value = firstShipping.querySelector(".shipping-name").value.trim();
                }
            }

            function validateSaleCodes() {
                var checked = saleCodeSelect.querySelectorAll("input[type='checkbox']:checked");
                if (!checked.length) {
                    saleCodeError.textContent = "กรุณาเลือกเขตการขายอย่างน้อย 1 รายการ";
                    return false;
                }
                saleCodeError.textContent = "";
                return true;
            }

            function validateBranchNumbers() {
                var valid = true;
                billingCards.querySelectorAll(".billing-card").forEach(function(card) {
                    var branchType = card.querySelector(".billing-branch-type").value;
                    var branchNo = card.querySelector(".billing-branch-no");
                    if (branchType === "1" && !branchNo.value.trim()) branchNo.value = "00000";
                    if (branchType === "2" && !branchNo.value.trim()) valid = false;
                });
                return valid;
            }

            function checkCustomerName(callback) {
                var name = customerNameInput.value.trim();
                if (name === "") {
                    customerDupInput.value = "0";
                    customerMsg.textContent = "";
                    duplicateNames = [];
                    lastCheckedName = "";
                    duplicateAlertShown = false;
                    callback(false);
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "check_customer_name.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            var res = JSON.parse(xhr.responseText);
                            if (res.exists) {
                                customerDupInput.value = "1";
                                duplicateNames = (res.names || []).map(function(item) {
                                    return String(item).replace(/[&<>"']/g, function(char) {
                                        return {
                                            "&": "&amp;",
                                            "<": "&lt;",
                                            ">": "&gt;",
                                            "\"": "&quot;",
                                            "'": "&#039;"
                                        } [char];
                                    });
                                });
                                customerMsg.innerHTML = "มีชื่อลูกค้าใกล้เคียงในระบบ:<br>- " + duplicateNames.join("<br>- ");
                                showDuplicateNames(duplicateNames);
                                if (lastCheckedName !== name || duplicateAlertShown === false) {
                                    alert("มีชื่อลูกค้าอยู่แล้ว เช่น:\n- " + duplicateNames.join("\n- "));
                                    duplicateAlertShown = true;
                                }
                            } else {
                                customerDupInput.value = "0";
                                customerMsg.textContent = "";
                                duplicateNames = [];
                                duplicateAlertShown = false;
                            }
                            lastCheckedName = name;
                            callback(!!res.exists);
                        } catch (e) {
                            customerDupInput.value = "0";
                            customerMsg.textContent = "";
                            duplicateNames = [];
                            callback(false);
                        }
                    }
                };
                xhr.send("customer_name=" + encodeURIComponent(name) + "&customer_id=" + encodeURIComponent(customerIdInput ? customerIdInput.value : "0"));
            }

            function bindDynamic(scope) {
                applyPlaceholders(scope);
                bindClearables(scope);
                bindNumberOnly(scope);
                syncClearStates(scope);
            }

            function syncClearStates(scope) {
                scope.querySelectorAll(".input-shell").forEach(function(wrapper) {
                    var field = wrapper.querySelector("input");
                    if (field) wrapper.classList.toggle("has-value", !!field.value);
                });
                updateVipState();
            }

            function closeSuccessPopup() {
                if (!successPopup || successPopup.hidden) return;
                successPopup.hidden = true;

                if (window.history && window.history.replaceState) {
                    var url = new URL(window.location.href);
                    url.searchParams.delete("success");
                    window.history.replaceState({}, document.title, url.pathname + url.search + url.hash);
                }
            }

            function closeConfirmPopup(result) {
                if (!confirmPopup || confirmPopup.hidden) return;
                confirmPopup.hidden = true;

                if (confirmPopupResolver) {
                    var resolver = confirmPopupResolver;
                    confirmPopupResolver = null;
                    resolver(result);
                }
            }

            function closeDeleteConfirmPopup(result) {
                if (!deleteConfirmPopup || deleteConfirmPopup.hidden) return;
                deleteConfirmPopup.hidden = true;
                if (deleteConfirmPopupResolver) {
                    var resolver = deleteConfirmPopupResolver;
                    deleteConfirmPopupResolver = null;
                    resolver(result);
                }
            }

            function openDeleteConfirmPopup(message) {
                if (!deleteConfirmPopup) {
                    return Promise.resolve(window.confirm(message));
                }
                document.getElementById("deletePopupMessage").textContent = message;
                deleteConfirmPopup.hidden = false;
                return new Promise(function(resolve) {
                    deleteConfirmPopupResolver = resolve;
                    document.getElementById("deletePopupConfirm").focus();
                });
            }

            function openConfirmPopup(options) {
                if (!confirmPopup) {
                    return Promise.resolve(window.confirm(options && options.message ? options.message : ""));
                }

                var settings = options || {};
                confirmPopupTitle.textContent = settings.title || "ยืนยันการทำรายการ";
                confirmPopupMessage.textContent = settings.message || "";
                confirmPopupCancel.textContent = settings.cancelText || "ยกเลิก";
                confirmPopupConfirm.textContent = settings.confirmText || "ยืนยัน";
                confirmPopup.hidden = false;

                return new Promise(function(resolve) {
                    confirmPopupResolver = resolve;
                    confirmPopupConfirm.focus();
                });
            }

            if (successPopup && !successPopup.hidden) {
                if (successPopupClose) {
                    successPopupClose.addEventListener("click", closeSuccessPopup);
                }

                successPopup.addEventListener("click", function(event) {
                    if (event.target === successPopup) {
                        closeSuccessPopup();
                    }
                });
            }

            if (confirmPopup) {
                confirmPopupCancel.addEventListener("click", function() {
                    closeConfirmPopup(false);
                });

                confirmPopupConfirm.addEventListener("click", function() {
                    closeConfirmPopup(true);
                });

                confirmPopup.addEventListener("click", function(event) {
                    if (event.target === confirmPopup) {
                        closeConfirmPopup(false);
                    }
                });

                document.addEventListener("keydown", function(event) {
                    if (!confirmPopup.hidden && event.key === "Escape") {
                        closeConfirmPopup(false);
                    }
                });
            }

            if (deleteConfirmPopup) {
                document.getElementById("deletePopupCancel").addEventListener("click", function() {
                    closeDeleteConfirmPopup(false);
                });
                document.getElementById("deletePopupCloseIcon").addEventListener("click", function() {
                    closeDeleteConfirmPopup(false);
                });
                document.getElementById("deletePopupConfirm").addEventListener("click", function() {
                    closeDeleteConfirmPopup(true);
                });
                deleteConfirmPopup.addEventListener("click", function(event) {
                    if (event.target === deleteConfirmPopup) {
                        closeDeleteConfirmPopup(false);
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (!deleteConfirmPopup.hidden && event.key === "Escape") {
                        closeDeleteConfirmPopup(false);
                    }
                });
            }

            document.getElementById("copyCustomerToBilling").addEventListener("click", function() {
                setActivePill(this, "#copyCustomerToBilling");
                copyCustomerToBilling();
            });
            document.getElementById("copyCustomerToShipping").addEventListener("click", function() {
                setActivePill(this, "#copyCustomerToShipping, #copyBillingToShipping");
                copyCustomerToShipping();
            });
            document.getElementById("copyBillingToShipping").addEventListener("click", function() {
                setActivePill(this, "#copyCustomerToShipping, #copyBillingToShipping");
                copyBillingToShipping();
            });
            document.getElementById("addBillingCard").addEventListener("click", function() {
                clearActivePills("#copyCustomerToBilling");
                appendBillingCard();
            });
            document.getElementById("addShippingCard").addEventListener("click", appendShippingCard);

            billingCards.addEventListener("input", function() {
                clearActivePills("#copyCustomerToBilling, #copyBillingToShipping");
            });

            billingCards.addEventListener("change", function() {
                clearActivePills("#copyCustomerToBilling, #copyBillingToShipping");
            });

            shippingCards.addEventListener("input", function() {
                clearActivePills("#copyCustomerToShipping, #copyBillingToShipping");
            });

            shippingCards.addEventListener("change", function() {
                clearActivePills("#copyCustomerToShipping, #copyBillingToShipping");
            });

            billingCards.addEventListener("click", async function(event) {
                if (event.target.closest(".remove-billing-card")) {
                    var card = event.target.closest(".billing-card");
                    if (card && billingCards.querySelectorAll(".billing-card").length > 1) {
                        var titleElem = card.querySelector(".sub-card-title");
                        var titleName = titleElem ? titleElem.textContent.trim() : "ข้อมูลนี้";
                        var confirmed = await openDeleteConfirmPopup('คุณต้องการลบ " ' + titleName + ' " ใช่ไหม ?');
                        if (confirmed) {
                            card.remove();
                            updateTitles();
                        }
                    }
                }
            });

            shippingCards.addEventListener("click", async function(event) {
                if (event.target.closest(".remove-shipping-card")) {
                    var card = event.target.closest(".shipping-card");
                    if (card && shippingCards.querySelectorAll(".shipping-card").length > 1) {
                        var titleElem = card.querySelector(".sub-card-title");
                        var titleName = titleElem ? titleElem.textContent.trim() : "ข้อมูลนี้";
                        var confirmed = await openDeleteConfirmPopup('คุณต้องการลบ " ' + titleName + ' " ใช่ไหม ?');
                        if (confirmed) {
                            card.remove();
                            updateTitles();
                        }
                    }
                }
            });

            saleCodeSummary.addEventListener("click", function() {
                saleCodeSelect.classList.toggle("is-open");
            });

            document.addEventListener("click", function(event) {
                if (!saleCodeSelect.contains(event.target)) {
                    saleCodeSelect.classList.remove("is-open");
                }
            });

            saleCodeSelect.querySelectorAll("input[type='checkbox']").forEach(function(checkbox) {
                checkbox.addEventListener("change", updateSaleCodeSummary);
            });

            document.getElementById("vip_ckk").addEventListener("change", updateVipState);

            customerNameInput.addEventListener("blur", function() {
                duplicateAlertShown = false;
                checkCustomerName(function() {});
            });

            customerNameInput.addEventListener("keyup", function() {
                duplicateAlertShown = false;
            });

            form.addEventListener("submit", function(event) {
                event.preventDefault();
                syncModeNameField();
                syncLegacyFields();
                if (!validateSaleCodes()) return false;
                if (!validateBranchNumbers()) {
                    alert("กรุณาระบุเลขที่สาขาให้ครบถ้วน");
                    return false;
                }
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return false;
                }
                openConfirmPopup({
                    title: "ยืนยันการบันทึกข้อมูล",
                    message: "ตรวจสอบข้อมูลเรียบร้อยแล้วใช่หรือไม่\nกด \"ยืนยัน\" เพื่อบันทึกข้อมูลลูกค้า",
                    cancelText: "ยกเลิก",
                    confirmText: "<?php echo $isEditMode ? 'ยืนยันการอัปเดต' : 'ยืนยันการบันทึก'; ?>"
                }).then(function(submitConfirmed) {
                    if (submitConfirmed && nativeFormSubmit) {
                        nativeFormSubmit.call(form);
                    }
                });
            });

            bindDynamic(document);
            updateTitles();
            updateSaleCodeSummary();
            updateVipState();
        })();
    </script>
</body>

</html>