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
$saleTeams = fetchRows($com, "SELECT sale_code FROM tb_team_all WHERE 1 ORDER BY sale_code");

$prefaceOptions = array(
    'คุณ',
    'มหาวิทยาลัย',
    'บริษัท',
    'หจก.',
    'คลินิก',
    'ร้าน',
    'มูลนิธิ',
    'ร้านขายยา',
    'ร้านค้า',
    'โรงพยาบาล',
    'โรงเรียน',
    'สถาบัน',
    'สำนักงาน',
    'หสน.',
    'หสม.'
);

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
    'preface_name' => '',
    'customer_name' => '',
    'cus_tel' => '',
    'type_customer' => '',
    'mode_name' => '',
    'credit_ckk' => '',
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
);

$selectedSaleCodes = array();
$billingRecords = array();
$shippingRecords = array();

if ($isEditMode) {
    $customerRow = fetchRow($conn, "SELECT * FROM tb_customer WHERE customer_id = {$customerId}");
    if ($customerRow) {
        $customerData = array_merge($customerData, $customerRow);
        $fullCustomerName = trim((string)$customerRow['customer_name']);
        $preface = trim((string)$customerRow['preface_name']);
        if ($preface !== '' && strpos($fullCustomerName, $preface) === 0) {
            $customerData['customer_name'] = trim(substr($fullCustomerName, strlen($preface)));
        } else {
            $customerData['customer_name'] = $fullCustomerName;
        }
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

if (empty($billingRecords)) {
    $billingRecords[] = array(
        'billing_preface_name' => $customerData['preface_name'],
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
        'shipping_preface_name' => $customerData['preface_name'],
        'shipping_name' => $customerData['delivery_name'],
        'shipping_tel' => $customerData['del_tel'],
        'shipping_address' => $customerData['del_address'],
        'shipping_ampher' => $customerData['del_ampher'],
        'shipping_province' => $customerData['del_province'],
        'shipping_postcode' => $customerData['del_postcode'],
    );
}
?>

<style>
    :root {
        --customer-primary: #612989;
        --customer-bg: #f4eff8;
        --customer-border: #e7deef;
        --customer-input: #f5f4f8;
        --customer-text: #38343e;
        --customer-danger: #ef4444;
        --customer-shadow: 0 18px 40px rgba(64, 34, 90, 0.08);
        --customer-font: "Prompt", "Segoe UI", Tahoma, sans-serif;
    }

    body {
        margin: 0;
        background: var(--customer-bg);
        color: var(--customer-text);
        font-family: var(--customer-font);
    }

    .customer-page {
        padding: 24px 16px 48px;
    }

    .customer-shell {
        max-width: 1120px;
        margin: 0 auto;
    }

    .success-popup {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(28, 18, 41, 0.35);
        z-index: 9999;
    }

    .success-popup[hidden] {
        display: none;
    }

    .success-popup-card {
        width: min(100%, 360px);
        padding: 28px 24px 22px;
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 24px 60px rgba(49, 27, 71, 0.2);
        text-align: center;
    }

    .success-popup-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;
        border-radius: 999px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #6fbf73, #3d9e56);
        color: #fff;
        font-size: 30px;
        font-weight: 700;
    }

    .success-popup-title {
        margin: 0 0 8px;
        font-size: 24px;
        font-weight: 600;
        color: #2f7d32;
    }

    .success-popup-message {
        margin: 0;
        font-size: 16px;
        line-height: 1.5;
        color: #4b5563;
    }

    .success-popup-close {
        margin-top: 18px;
        min-width: 120px;
        padding: 10px 18px;
        border: 0;
        border-radius: 999px;
        background: var(--customer-primary);
        color: #fff;
        font: inherit;
        cursor: pointer;
    }

    .confirm-popup {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(20, 16, 31, 0.48);
        backdrop-filter: blur(8px);
        z-index: 10000;
    }

    .confirm-popup[hidden] {
        display: none;
    }

    .confirm-popup-card {
        width: min(100%, 460px);
        padding: 28px 28px 24px;
        border-radius: 28px;
        background:
            radial-gradient(circle at top right, rgba(97, 41, 137, 0.12), transparent 34%),
            linear-gradient(180deg, #ffffff 0%, #fbf8ff 100%);
        box-shadow: 0 28px 70px rgba(31, 19, 44, 0.28);
        border: 1px solid rgba(97, 41, 137, 0.12);
    }

    .confirm-popup-badge {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        margin-bottom: 18px;
        background: linear-gradient(135deg, #612989 0%, #8a4ec0 100%);
        color: #fff;
        box-shadow: 0 16px 30px rgba(97, 41, 137, 0.24);
        font-size: 28px;
        font-weight: 700;
    }

    .confirm-popup-title {
        margin: 0 0 10px;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 600;
        color: #2d1840;
    }

    .confirm-popup-message {
        margin: 0;
        font-size: 15px;
        line-height: 1.7;
        color: #5c5467;
        white-space: pre-line;
    }

    .confirm-popup-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
    }

    .confirm-popup-button {
        min-width: 120px;
        padding: 11px 18px;
        border-radius: 999px;
        border: 0;
        font: inherit;
        font-weight: 500;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
    }

    .confirm-popup-button:hover {
        transform: translateY(-1px);
    }

    .confirm-popup-button.cancel {
        background: #f2edf7;
        color: #5f5470;
    }

    .confirm-popup-button.confirm {
        background: linear-gradient(135deg, #612989 0%, #7d43b0 100%);
        color: #fff;
        box-shadow: 0 14px 26px rgba(97, 41, 137, 0.22);
    }

    .customer-form {
        background: #fff;
        border-radius: 28px;
        box-shadow: var(--customer-shadow);
    }

    .customer-header {
        padding: 22px 28px 12px;
        border-bottom: 1px solid var(--customer-border);
    }

    .customer-header h1 {
        margin: 0;
        font-size: 20px;
        font-weight: 500;
    }

    .customer-body {
        padding: 0 24px 28px;
    }

    .section-block {
        padding: 18px 0 24px;
        border-bottom: 1px solid var(--customer-border);
    }

    .section-block:last-of-type {
        border-bottom: 0;
    }

    .section-title {
        margin: 0 0 18px;
        font-size: 20px;
        font-weight: 500;
    }

    .field-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px 18px;
    }

    .field-grid-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .field {
        min-width: 0;
    }

    .span-2 {
        grid-column: span 2;
    }

    .span-3 {
        grid-column: 1 / -1;
    }

    .field-label {
        display: block;
        margin-bottom: 6px;
        color: var(--customer-primary);
        font-size: 13px;
        font-weight: 500;
    }

    .required-mark {
        color: var(--customer-danger);
    }

    .input-shell,
    .select-shell,
    .multi-select {
        position: relative;
    }

    .form-input,
    .form-select,
    .multi-select-summary {
        width: 100%;
        min-height: 44px;
        border: 1px solid transparent;
        border-radius: 12px;
        background: var(--customer-input);
        padding: 11px 42px 11px 14px;
        box-sizing: border-box;
        font: inherit;
        color: inherit;
        outline: none;
    }

    .form-input:focus,
    .form-select:focus,
    .multi-select-summary:focus,
    .multi-select.is-open .multi-select-summary {
        border-color: rgba(97, 41, 137, 0.25);
        box-shadow: 0 0 0 4px rgba(97, 41, 137, 0.08);
        background: #fbfaff;
    }

    .form-input[readonly],
    .multi-select-summary[readonly] {
        color: #7b7585;
    }

    .form-select {
        appearance: none;
        cursor: pointer;
    }

    .select-shell::after,
    .multi-select::after {
        content: "";
        position: absolute;
        top: 50%;
        right: 16px;
        width: 8px;
        height: 8px;
        margin-top: -6px;
        border-right: 1.8px solid #6d6776;
        border-bottom: 1.8px solid #6d6776;
        transform: rotate(45deg);
        pointer-events: none;
    }

    .field-clear {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: #8d8797;
        font-size: 18px;
        cursor: pointer;
        display: none;
    }

    .input-shell.has-value .field-clear {
        display: inline-block;
    }

    .field-error,
    .field-hint {
        margin-top: 6px;
        font-size: 12px;
    }

    .field-error {
        color: var(--customer-danger);
    }

    .field-hint {
        color: #867f90;
    }

    .pill-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 16px;
    }

    .outline-pill {
        min-width: 264px;
        min-height: 38px;
        border: 1px solid #ddd6e6;
        border-radius: 999px;
        background: #fff;
        color: var(--customer-primary);
        font: inherit;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 8px 18px;
        cursor: pointer;
    }

    .outline-pill:hover {
        background: #f8f1fd;
    }

    .outline-pill:active,
    .outline-pill.is-active {
        border-color: var(--customer-primary);
        background: var(--customer-primary);
        color: #fff;
    }

    .outline-pill:active img,
    .outline-pill.is-active img {
        filter: brightness(0) invert(1);
    }

    .outline-pill img {
        width: 18px;
        height: 18px;
    }

    .primary-button img {
        width: 26.5;
        height: 21.5;
        filter: brightness(0) invert(1);
    }

    .tag-toggle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 10px 18px;
        border-radius: 12px;
        background: var(--customer-input);
        color: #696273;
        cursor: pointer;
    }

    .tag-toggle input {
        display: none;
    }

    .tag-toggle.is-active {
        background: var(--customer-primary);
        color: #fff;
    }

    .card-list {
        display: grid;
        gap: 18px;
    }

    .sub-card {
        border-top: 1px solid var(--customer-border);
        padding-top: 12px;
    }

    .sub-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 10px;
    }

    .sub-card-title {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
        color: #7c7486;
    }

    .danger-button {
        min-width: 116px;
        min-height: 40px;
        border: 1px solid #f0d2d2;
        border-radius: 999px;
        background: #fff;
        color: #ff2d20;
        font: inherit;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
    }

    .danger-button:hover {
        background: #fff6f5;
    }

    .danger-button svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        fill: none;
        stroke-width: 1.8;
    }

    .multi-select-summary {
        cursor: pointer;
    }

    .multi-select-panel {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid var(--customer-border);
        border-radius: 16px;
        box-shadow: 0 16px 28px rgba(31, 18, 43, 0.12);
        padding: 12px;
        max-height: 280px;
        overflow: auto;
        display: none;
        z-index: 20;
    }

    .multi-select.is-open .multi-select-panel {
        display: block;
    }

    .multi-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        border-radius: 10px;
        cursor: pointer;
    }

    .multi-option:hover {
        background: #f7f2fc;
    }

    .multi-option input {
        accent-color: var(--customer-primary);
    }

    .customer-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 16px;
        padding-top: 12px;
    }

    .primary-button,
    .ghost-button {
        min-width: 144px;
        min-height: 44px;
        border-radius: 999px;
        font: inherit;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 10px 24px;
        box-sizing: border-box;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .primary-button {
        border: 0;
        background: var(--customer-primary);
        color: #fff;
    }

    .primary-button:hover {
        background: #7435a2;
        box-shadow: 0 8px 20px rgba(97, 41, 137, 0.3);
        transform: translateY(-2px);
    }

    .primary-button:active {
        transform: translateY(0);
        box-shadow: 0 4px 10px rgba(97, 41, 137, 0.2);
    }

    .ghost-button {
        border: 1px solid #dfdae6;
        background: #fff;
        color: #45414a;
    }

    .ghost-button:hover {
        background: #f3ebfa;
        color: var(--customer-primary);
        border-color: var(--customer-primary);
        box-shadow: 0 8px 20px rgba(97, 41, 137, 0.2);
        transform: translateY(-2px);
    }

    .ghost-button:active {
        transform: translateY(0);
        box-shadow: 0 4px 10px rgba(97, 41, 137, 0.1);
    }

    .hidden-fields {
        display: none;
    }

    #cr_bar {
        padding-top: 18px;
        color: #857d8e;
        font-size: 13px;
        text-align: right;
    }

    @media (max-width: 1080px) {

        .field-grid,
        .field-grid-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 720px) {
        .customer-page {
            padding: 0;
        }

        .customer-form {
            border-radius: 0;
        }

        .customer-header,
        .customer-body {
            padding-left: 14px;
            padding-right: 14px;
        }

        .field-grid,
        .field-grid-4 {
            grid-template-columns: 1fr;
        }

        .span-2,
        .span-3 {
            grid-column: auto;
        }

        .outline-pill,
        .primary-button,
        .ghost-button {
            width: 100%;
            min-width: 0;
        }
    }

    .delete-popup {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(20, 16, 31, 0.48);
        backdrop-filter: blur(8px);
        z-index: 10000;
    }

    .delete-popup[hidden] {
        display: none;
    }

    .delete-popup-card {
        position: relative;
        width: min(100%, 500px);
        padding: 40px 32px 32px;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 28px 70px rgba(31, 19, 44, 0.28);
        text-align: center;
    }

    .delete-popup-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: transparent;
        border: none;
        font-size: 24px;
        color: #666;
        cursor: pointer;
        line-height: 1;
    }

    .delete-popup-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .delete-popup-icon svg {
        width: 100%;
        height: 100%;
    }

    .delete-popup-title {
        margin: 0 0 12px;
        font-size: 22px;
        font-weight: 600;
        color: #333;
    }

    .delete-popup-message {
        margin: 0 0 32px;
        font-size: 16px;
        color: #666;
    }

    .delete-popup-actions {
        display: flex;
        justify-content: center;
        gap: 16px;
    }

    .delete-popup-button {
        min-width: 140px;
        padding: 12px 24px;
        border-radius: 999px;
        font: inherit;
        font-weight: 500;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .delete-popup-button.confirm {
        background: #ff0000;
        color: #fff;
        border: none;
    }

    .delete-popup-button.confirm:hover {
        background: #e60000;
    }

    .delete-popup-button.cancel {
        background: #fff;
        color: #333;
        border: 1px solid #ddd;
    }

    .delete-popup-button.cancel:hover {
        background: #f5f5f5;
    }
</style>

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
                    <path d="M4 6H20V8H4V6Z" fill="#ff0000"/>
                    <path d="M10 2H14V4H10V2Z" fill="#ff0000"/>
                    <path d="M5 9H19V20C19 21.1046 18.1046 22 17 22H7C5.89543 22 5 21.1046 5 20V9Z" fill="#ff0000"/>
                    <rect x="9" y="11" width="2" height="7" rx="1" fill="#ffffff"/>
                    <rect x="13" y="11" width="2" height="7" rx="1" fill="#ffffff"/>
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
                <input type="hidden" name="customer_coden" value="<?php echo h($customerData['customer_coden']); ?>">
                <input type="hidden" name="close_ckk" value="<?php echo h($customerData['close_ckk']); ?>">

                <div class="customer-header">
                    <h1>ข้อมูลลูกค้า</h1>
                </div>

                <div class="customer-body">
                    <section class="section-block">
                        <div class="field-grid">
                            <div class="field">
                                <label class="field-label" for="preface_name">คำนำหน้าชื่อ<span class="required-mark">*</span></label>
                                <div class="select-shell">
                                    <select name="preface_name" id="preface_name" class="form-select" required>
                                        <option value="">เลือกคำนำหน้าชื่อ</option>
                                        <?php foreach ($prefaceOptions as $option) { ?>
                                            <option value="<?php echo h($option); ?>" <?php echo ($customerData['preface_name'] === $option) ? 'selected' : ''; ?>><?php echo h($option); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

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
                                        <option value="">เลือกประเภทลูกค้า</option>
                                        <?php foreach ($typeCustomers as $typeCustomer) { ?>
                                            <option value="<?php echo h($typeCustomer['type_id']); ?>" <?php echo ((string)$customerData['type_customer'] === (string)$typeCustomer['type_id']) ? 'selected' : ''; ?>><?php echo h($typeCustomer['type_name']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label" for="mode_name">กลุ่มลูกค้า<span class="required-mark">*</span></label>
                                <div class="input-shell">
                                    <input type="text" name="mode_name" id="mode_name" class="form-input js-clearable" value="<?php echo h($customerData['mode_name']); ?>" autocomplete="off" placeholder="Customer group" required>
                                    <button type="button" class="field-clear" data-clear-target="mode_name" aria-label="ล้างค่า">&times;</button>
                                </div>
                                <input type="hidden" name="h_mode_name" id="h_mode_name" value="<?php echo h($customerData['mode_name']); ?>">
                            </div>

                            <div class="field">
                                <label class="field-label" for="customer_code_display">รหัสสมาชิก (สถานะ.)</label>
                                <div class="input-shell">
                                    <input type="text" id="customer_code_display" class="form-input" value="<?php echo h($customerData['customer_code'] !== '' ? $customerData['customer_code'] : 'Auto'); ?>" readonly>
                                </div>
                                <input type="hidden" name="customer_code" id="customer_code" value="<?php echo h($customerData['customer_code']); ?>">
                            </div>

                            <div class="field">
                                <label class="field-label" for="credit_ckk">วิธีชำระเงิน</label>
                                <div class="select-shell">
                                    <select name="credit_ckk" id="credit_ckk" class="form-select">
                                        <option value="">เลือกวิธีชำระเงิน</option>                
                                        <?php foreach ($creditBanks as $creditBank) { ?>
                                            <option value="<?php echo h($creditBank['id']); ?>" <?php echo ((string)$customerData['credit_ckk'] === (string)$creditBank['id']) ? 'selected' : ''; ?>><?php echo h($creditBank['pay_in']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <label class="field-label">&nbsp;</label>
                                <label class="tag-toggle<?php echo !empty($customerData['vip_ckk']) ? ' is-active' : ''; ?>" id="vip_toggle">
                                    <input type="checkbox" value="1" id="vip_ckk" name="vip_ckk" <?php echo !empty($customerData['vip_ckk']) ? 'checked' : ''; ?>>
                                    <span>VIP</span>
                                </label>
                            </div>

                            <div class="field span-3">
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
                                        <option value="">เลือกจังหวัด</option>
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
                                <div class="sub-card billing-card" data-billing-index="<?php echo h($index); ?>">
                                    <div class="sub-card-header">
                                        <h3 class="sub-card-title">ที่อยู่ออกบิล <?php echo h($index + 1); ?></h3>
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

                                    <div class="field-grid field-grid-4">
                                        <div class="field">
                                            <label class="field-label">รหัสลูกค้า AWL</label>
                                            <div class="input-shell"><input type="text" class="form-input" value="<?php echo h($customerData['customer_code'] !== '' ? $customerData['customer_code'] : 'Auto'); ?>" readonly></div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">รหัสลูกค้า NBM</label>
                                            <div class="input-shell"><input type="text" class="form-input" value="<?php echo h($customerData['customer_coden'] !== '' ? $customerData['customer_coden'] : 'Auto'); ?>" readonly></div>
                                        </div>

                                        <div class="field">
                                            <label class="field-label">คำนำหน้าชื่อ<span class="required-mark">*</span></label>
                                            <div class="select-shell">
                                                <select class="form-select billing-preface" name="billing_preface_name[]" required>
                                                    <option value="">เลือกคำนำหน้าชื่อ</option>
                                                    <?php foreach ($prefaceOptions as $option) { ?>
                                                        <option value="<?php echo h($option); ?>" <?php echo (($billing['billing_preface_name'] ?? '') === $option) ? 'selected' : ''; ?>><?php echo h($option); ?></option>
                                                    <?php } ?>
                                                </select>
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

                                        <div class="field span-2">
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
                                                    <option value="">เลือกจังหวัด</option>
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
                                                    <option value="">เลือกสาขา</option>
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
                                            <div class="field-hint">ถ้าเป็นสำนักงานใหญ่สามารถใส่ 00000 ได้</div>
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

                                    <div class="field-grid">
                                        <div class="field">
                                            <label class="field-label">คำนำหน้าชื่อ<span class="required-mark">*</span></label>
                                            <div class="select-shell">
                                                <select class="form-select shipping-preface" name="shipping_preface_name[]" required>
                                                    <option value="">เลือกคำนำหน้าชื่อ</option>
                                                    <?php foreach ($prefaceOptions as $option) { ?>
                                                        <option value="<?php echo h($option); ?>" <?php echo (($shipping['shipping_preface_name'] ?? '') === $option) ? 'selected' : ''; ?>><?php echo h($option); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

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
                                                    <option value="">เลือกจังหวัด</option>
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
                        <h2 class="section-title">สิทธิ์การใช้งาน</h2>
                        <div class="field-grid">
                            <div class="field span-3">
                                <label class="field-label">เขตการขาย<span class="required-mark">*</span></label>
                                <div class="multi-select" id="saleCodeSelect">
                                    <input type="text" class="multi-select-summary" id="saleCodeSummary" value="Select" readonly aria-haspopup="listbox">
                                    <div class="multi-select-panel">
                                        <?php foreach ($saleTeams as $saleTeam) { ?>
                                            <label class="multi-option">
                                                <input type="checkbox" name="sale_code[]" value="<?php echo h($saleTeam['sale_code']); ?>" <?php echo in_array($saleTeam['sale_code'], $selectedSaleCodes) ? 'checked' : ''; ?>>
                                                <span><?php echo h($saleTeam['sale_code']); ?></span>
                                            </label>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="field-error" id="saleCodeError"></div>
                            </div>
                        </div>

                        <div class="customer-actions">
                            <button type="submit" class="primary-button">
                                <img src="img/icons/add_user.png" alt="Add User">
                                <span id="submitCustomerButtonText"><?php echo $isEditMode ? 'อัพเดต' : 'บันทึก'; ?></span>
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
                        <input type="hidden" name="rental_address" value="">
                        <input type="hidden" name="rental_ampher" value="">
                        <input type="hidden" name="rental_province" value="">
                        <input type="hidden" name="rental_postcode" value="">
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

            <div id="cr_bar"><?php include 'foot.php'; ?></div>
        </div>
    </div>

    <template id="billingCardTemplate">
        <div class="sub-card billing-card" data-billing-index="__INDEX__">
            <div class="sub-card-header">
                <h3 class="sub-card-title">ที่อยู่ออกบิล __NUMBER__</h3>
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
            <div class="field-grid field-grid-4">
                <div class="field"><label class="field-label">รหัสลูกค้า AWL</label>
                    <div class="input-shell"><input type="text" class="form-input" value="<?php echo h($customerData['customer_code'] !== '' ? $customerData['customer_code'] : 'Auto'); ?>" readonly></div>
                </div>
                <div class="field"><label class="field-label">รหัสลูกค้า NBM</label>
                    <div class="input-shell"><input type="text" class="form-input" value="<?php echo h($customerData['customer_coden'] !== '' ? $customerData['customer_coden'] : 'Auto'); ?>" readonly></div>
                </div>
                <div class="field"><label class="field-label">คำนำหน้าชื่อ<span class="required-mark">*</span></label>
                    <div class="select-shell"><select class="form-select billing-preface" name="billing_preface_name[]" required>
                            <option value="">เลือกคำนำหน้าชื่อ</option><?php foreach ($prefaceOptions as $option) { ?><option value="<?php echo h($option); ?>"><?php echo h($option); ?></option><?php } ?>
                        </select></div>
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
                <div class="field span-2"><label class="field-label">E-mail<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="email" class="form-input js-clearable billing-email" name="billing_email[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field span-3"><label class="field-label">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-clearable billing-address" name="billing_address[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">จังหวัด<span class="required-mark">*</span></label>
                    <div class="select-shell"><select class="form-select billing-province" name="billing_province[]" required>
                            <option value="">เลือกจังหวัด</option><?php foreach ($provinces as $province) { ?><option value="<?php echo h($province['province_name']); ?>"><?php echo h($province['province_name']); ?></option><?php } ?>
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
                            <option value="">เลือกสาขา</option>
                            <option value="1">สำนักงานใหญ่</option>
                            <option value="2">สาขา</option>
                        </select></div>
                </div>
                <div class="field"><label class="field-label">เลขที่สาขา<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-number-only js-clearable billing-branch-no" name="billing_branch_no[]" inputmode="numeric" maxlength="10" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                    <div class="field-hint">ถ้าเป็นสำนักงานใหญ่สามารถใส่ 00000 ได้</div>
                </div>
            </div>
        </div>
    </template>

    <template id="shippingCardTemplate">
        <div class="sub-card shipping-card" data-shipping-index="__INDEX__">
            <div class="sub-card-header">
                <h3 class="sub-card-title">ที่อยู่จัดส่ง __NUMBER__</h3>
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
            <div class="field-grid">
                <div class="field"><label class="field-label">คำนำหน้าชื่อ<span class="required-mark">*</span></label>
                    <div class="select-shell"><select class="form-select shipping-preface" name="shipping_preface_name[]" required>
                            <option value="">เลือกคำนำหน้าชื่อ</option><?php foreach ($prefaceOptions as $option) { ?><option value="<?php echo h($option); ?>"><?php echo h($option); ?></option><?php } ?>
                        </select></div>
                </div>
                <div class="field"><label class="field-label">ชื่อผู้ติดต่อ<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-clearable shipping-name" name="shipping_name[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">เบอร์โทร<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-number-only js-clearable shipping-tel" name="shipping_tel[]" inputmode="numeric" maxlength="15" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field span-3"><label class="field-label">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน<span class="required-mark">*</span></label>
                    <div class="input-shell"><input type="text" class="form-input js-clearable shipping-address" name="shipping_address[]" required><button type="button" class="field-clear" aria-label="ล้างค่า">&times;</button></div>
                </div>
                <div class="field"><label class="field-label">จังหวัด<span class="required-mark">*</span></label>
                    <div class="select-shell"><select class="form-select shipping-province" name="shipping_province[]" required>
                            <option value="">เลือกจังหวัด</option><?php foreach ($provinces as $province) { ?><option value="<?php echo h($province['province_name']); ?>"><?php echo h($province['province_name']); ?></option><?php } ?>
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

    <script>
        function make_autocom(autoObj, showObj) {
            var mkAutoObj = autoObj;
            var mkSerValObj = showObj;
            new Autocomplete(mkAutoObj, function() {
                this.setValue = function(id) {
                    document.getElementById(mkSerValObj).value = id;
                };
                if (this.isModified) {
                    this.setValue("");
                }
                if (this.value.length < 1 && this.isNotClick) {
                    return;
                }
                return "data_mode_cus.php?bill_search=" + encodeURIComponent(this.value);
            });
        }

        make_autocom("mode_name", "h_mode_name");

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
            var modeNameInput = document.getElementById("mode_name");
            var hiddenModeNameInput = document.getElementById("h_mode_name");
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
                    "#cus_tel": "กรอกเบอร์โทร",
                    "#mode_name": "กรอกกลุ่มลูกค้า",
                    "#cus_address": "กรอกรายละเอียดที่อยู่",
                    "#cus_ampher": "กรอกเขต / อำเภอ",
                    "#cus_postcode": "กรอกรหัสไปรษณีย์",
                    ".billing-name": "กรอกชื่อสำหรับออกบิล",
                    ".billing-tax-id": "กรอกเลขประจำตัวผู้เสียภาษี",
                    ".billing-tel": "กรอกเบอร์โทร",
                    ".billing-email": "กรอกอีเมล",
                    ".billing-address": "กรอกรายละเอียดที่อยู่ออกบิล",
                    ".billing-ampher": "กรอกเขต / อำเภอ",
                    ".billing-postcode": "กรอกรหัสไปรษณีย์",
                    ".billing-branch-no": "กรอกเลขที่สาขา",
                    ".shipping-name": "กรอกชื่อผู้ติดต่อ",
                    ".shipping-tel": "กรอกเบอร์โทร",
                    ".shipping-address": "กรอกรายละเอียดที่อยู่จัดส่ง",
                    ".shipping-ampher": "กรอกเขต / อำเภอ",
                    ".shipping-postcode": "กรอกรหัสไปรษณีย์"
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
                    preface: document.getElementById("preface_name").value,
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

            function syncModeNameField() {
                if (modeNameInput && hiddenModeNameInput && hiddenModeNameInput.value.trim() === "") {
                    hiddenModeNameInput.value = modeNameInput.value.trim();
                }
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
                    setSelectValue(card.querySelector(".billing-preface"), data.preface);
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
                    setSelectValue(card.querySelector(".shipping-preface"), data.preface);
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
                    preface: firstBilling.querySelector(".billing-preface").value,
                    name: firstBilling.querySelector(".billing-name").value.trim(),
                    tel: firstBilling.querySelector(".billing-tel").value.trim(),
                    address: firstBilling.querySelector(".billing-address").value.trim(),
                    province: firstBilling.querySelector(".billing-province").value,
                    ampher: firstBilling.querySelector(".billing-ampher").value.trim(),
                    postcode: firstBilling.querySelector(".billing-postcode").value.trim()
                };
                shippingCards.querySelectorAll(".shipping-card").forEach(function(card) {
                    setSelectValue(card.querySelector(".shipping-preface"), billing.preface);
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

            if (modeNameInput && hiddenModeNameInput) {
                modeNameInput.addEventListener("input", syncModeNameField);
                modeNameInput.addEventListener("change", syncModeNameField);
            }

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
                checkCustomerName(async function(isDuplicate) {
                    if (isDuplicate) {
                        var duplicateMessage = "มีชื่อลูกค้าใกล้เคียงในระบบ:\n- " + duplicateNames.join("\n- ") + "\n\nต้องการบันทึกต่อหรือไม่?";
                        var duplicateConfirmed = await openConfirmPopup({
                            title: "พบชื่อลูกค้าคล้ายกัน",
                            message: duplicateMessage,
                            cancelText: "กลับไปตรวจสอบ",
                            confirmText: "บันทึกต่อ"
                        });
                        if (!duplicateConfirmed) return false;
                    }
                    var submitConfirmed = await openConfirmPopup({
                        title: "ยืนยันการบันทึกข้อมูล",
                        message: "ตรวจสอบข้อมูลเรียบร้อยแล้วใช่หรือไม่\nกด \"ยืนยัน\" เพื่อบันทึกข้อมูลลูกค้า",
                        cancelText: "ยกเลิก",
                        confirmText: "<?php echo $isEditMode ? 'ยืนยันการอัปเดต' : 'ยืนยันการบันทึก'; ?>"
                    });
                    if (submitConfirmed) {
                        if (nativeFormSubmit) {
                            nativeFormSubmit.call(form);
                        }
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