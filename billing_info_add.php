<?php
include('head.php');
include('dbconnect.php');

date_default_timezone_set('Asia/Bangkok');

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

function fetchValue($connection, $sql, $default = '')
{
    if (!$connection) {
        return $default;
    }

    $query = mysqli_query($connection, $sql);
    if ($query && ($row = mysqli_fetch_row($query))) {
        return isset($row[0]) ? $row[0] : $default;
    }

    return $default;
}

function ensureCustomerChildTables($connection)
{
    $billingSql = "
        CREATE TABLE IF NOT EXISTS tb_customer_billing_address (
            id INT NOT NULL AUTO_INCREMENT,
            customer_id INT NOT NULL,
            billing_index INT NOT NULL DEFAULT 1,
            billing_preface_name VARCHAR(100) DEFAULT NULL,
            billing_name VARCHAR(255) DEFAULT NULL,
            billing_tax_id VARCHAR(50) DEFAULT NULL,
            billing_tel VARCHAR(50) DEFAULT NULL,
            billing_email VARCHAR(255) DEFAULT NULL,
            billing_address TEXT DEFAULT NULL,
            billing_ampher VARCHAR(255) DEFAULT NULL,
            billing_province VARCHAR(255) DEFAULT NULL,
            billing_postcode VARCHAR(20) DEFAULT NULL,
            billing_branch_type VARCHAR(10) DEFAULT NULL,
            billing_branch_no VARCHAR(50) DEFAULT NULL,
            is_primary TINYINT(1) NOT NULL DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_customer_billing_customer_id (customer_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    return mysqli_query($connection, $billingSql) ? true : false;
}

function esc($connection, $value)
{
    return mysqli_real_escape_string($connection, $value);
}

function h($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function postValue($key, $default = '')
{
    return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

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

$provinces = fetchRows($conn, "SELECT province_name FROM tb_province ORDER BY province_name");
$defaultTypeCustomer = fetchValue($conn, "SELECT type_id FROM tb_typecustomer ORDER BY type_id ASC LIMIT 1", '');
$customerId = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : (isset($_POST['customer_id']) ? (int)$_POST['customer_id'] : 0);
$billingRecordId = isset($_GET['billing_id']) ? (int)$_GET['billing_id'] : (isset($_POST['billing_id']) ? (int)$_POST['billing_id'] : 0);
$isEditMode = $customerId > 0;

$formData = array(
    'customer_id' => $customerId,
    'billing_id' => $billingRecordId,
    'customer_code' => '',
    'customer_coden' => '',
    'preface_name' => '',
    'bill_name' => '',
    'bill_tel' => '',
    'tax_id' => '',
    'email_cus' => '',
    'bill_address' => '',
    'bill_province' => '',
    'bill_ampher' => '',
    'bill_postcode' => '',
    'branch_type' => '1',
    'branch_no' => '00000'
);

$successMessage = '';
$successCustomerId = 0;

if ($isEditMode) {
    $customerRow = fetchRows($conn, "SELECT * FROM tb_customer WHERE customer_id = {$customerId} LIMIT 1");
    $customerRow = !empty($customerRow) ? $customerRow[0] : null;
    if ($customerRow) {
        $primaryBillingRow = null;
        if ($billingRecordId > 0) {
            $billingRows = fetchRows($conn, "SELECT * FROM tb_customer_billing_address WHERE id = {$billingRecordId} AND customer_id = {$customerId} LIMIT 1");
            $primaryBillingRow = !empty($billingRows) ? $billingRows[0] : null;
        }
        if (!$primaryBillingRow) {
            $billingRows = fetchRows($conn, "SELECT * FROM tb_customer_billing_address WHERE customer_id = {$customerId} AND is_primary = 1 ORDER BY id ASC LIMIT 1");
            $primaryBillingRow = !empty($billingRows) ? $billingRows[0] : null;
        }

        $formData['preface_name'] = $customerRow['preface_name'] ?? '';
        $formData['customer_code'] = $customerRow['customer_code'] ?? '';
        $formData['customer_coden'] = $customerRow['customer_coden'] ?? '';
        $formData['bill_name'] = $customerRow['bill_name'] ?? '';
        $formData['bill_tel'] = $customerRow['bill_tel'] ?? '';
        $formData['tax_id'] = $customerRow['tax_id'] ?? '';
        $formData['email_cus'] = $customerRow['email_cus'] ?? '';
        $formData['bill_address'] = $customerRow['bill_address'] ?? '';
        $formData['bill_province'] = $customerRow['billl_province'] ?? '';
        $formData['bill_ampher'] = $customerRow['bill_ampher'] ?? '';
        $formData['bill_postcode'] = $customerRow['bill_postcode'] ?? '';
        $formData['branch_type'] = $customerRow['h_ckk'] !== '' ? $customerRow['h_ckk'] : '1';
        $formData['branch_no'] = $customerRow['brun_no'] !== '' ? $customerRow['brun_no'] : '00000';

        if ($primaryBillingRow) {
            $formData['billing_id'] = (int)($primaryBillingRow['id'] ?? 0);
            $formData['preface_name'] = $primaryBillingRow['billing_preface_name'] ?? $formData['preface_name'];
            $formData['bill_name'] = $primaryBillingRow['billing_name'] ?? $formData['bill_name'];
            $formData['bill_tel'] = $primaryBillingRow['billing_tel'] ?? $formData['bill_tel'];
            $formData['tax_id'] = $primaryBillingRow['billing_tax_id'] ?? $formData['tax_id'];
            $formData['email_cus'] = $primaryBillingRow['billing_email'] ?? $formData['email_cus'];
            $formData['bill_address'] = $primaryBillingRow['billing_address'] ?? $formData['bill_address'];
            $formData['bill_province'] = $primaryBillingRow['billing_province'] ?? $formData['bill_province'];
            $formData['bill_ampher'] = $primaryBillingRow['billing_ampher'] ?? $formData['bill_ampher'];
            $formData['bill_postcode'] = $primaryBillingRow['billing_postcode'] ?? $formData['bill_postcode'];
            $formData['branch_type'] = $primaryBillingRow['billing_branch_type'] !== '' ? $primaryBillingRow['billing_branch_type'] : $formData['branch_type'];
            $formData['branch_no'] = $primaryBillingRow['billing_branch_no'] !== '' ? $primaryBillingRow['billing_branch_no'] : $formData['branch_no'];
        }
    }
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerId = isset($_POST['customer_id']) ? (int)$_POST['customer_id'] : $customerId;
    $billingRecordId = isset($_POST['billing_id']) ? (int)$_POST['billing_id'] : $billingRecordId;
    $isEditMode = $customerId > 0;

    foreach ($formData as $key => $value) {
        $formData[$key] = postValue($key, $value);
    }

    $formData['customer_id'] = $customerId;
    $formData['billing_id'] = $billingRecordId;

    $formData['bill_tel'] = preg_replace('/[^0-9]/', '', $formData['bill_tel']);
    $formData['tax_id'] = preg_replace('/[^0-9]/', '', $formData['tax_id']);
    $formData['bill_postcode'] = preg_replace('/[^0-9]/', '', $formData['bill_postcode']);
    $formData['branch_no'] = preg_replace('/[^0-9]/', '', $formData['branch_no']);

    if ($formData['branch_type'] === '1' && $formData['branch_no'] === '') {
        $formData['branch_no'] = '00000';
    }

    if (
        $formData['preface_name'] === '' ||
        $formData['bill_name'] === '' ||
        $formData['bill_tel'] === '' ||
        $formData['tax_id'] === '' ||
        $formData['email_cus'] === '' ||
        $formData['bill_address'] === '' ||
        $formData['bill_province'] === '' ||
        $formData['bill_ampher'] === '' ||
        $formData['bill_postcode'] === '' ||
        $formData['branch_type'] === '' ||
        $formData['branch_no'] === ''
    ) {
        $errorMessage = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    } elseif (!filter_var($formData['email_cus'], FILTER_VALIDATE_EMAIL)) {
        $errorMessage = 'รูปแบบ E-mail ไม่ถูกต้อง';
    } else {
        $duplicateSql = "SELECT customer_id FROM tb_customer WHERE bill_name='" . esc($conn, $formData['bill_name']) . "' AND tax_id='" . esc($conn, $formData['tax_id']) . "' AND bill_tel='" . esc($conn, $formData['bill_tel']) . "'";
        if ($isEditMode) {
            $duplicateSql .= " AND customer_id <> " . (int)$customerId;
        }
        $duplicateSql .= " LIMIT 1";
        $duplicateQuery = mysqli_query($conn, $duplicateSql);
        if ($duplicateQuery && mysqli_num_rows($duplicateQuery) > 0) {
            $errorMessage = 'ข้อมูลออกบิลนี้มีอยู่ในระบบแล้ว';
        }
    }

    if ($errorMessage === '') {
        mysqli_begin_transaction($conn);
        $allOk = ensureCustomerChildTables($conn);
        $existingCustomerRow = null;
        if ($isEditMode) {
            $existingCustomerRows = fetchRows($conn, "SELECT * FROM tb_customer WHERE customer_id = {$customerId} LIMIT 1");
            $existingCustomerRow = !empty($existingCustomerRows) ? $existingCustomerRows[0] : null;
        }

        $fullName = trim($formData['preface_name'] . ' ' . $formData['bill_name']);
        if ($isEditMode && $existingCustomerRow) {
            $customerSqlData = array(
                "customer_code='" . esc($conn, $existingCustomerRow['customer_code'] ?? '') . "'",
                "customer_name='" . esc($conn, $fullName) . "'",
                "type_customer='" . esc($conn, $existingCustomerRow['type_customer'] ?? $defaultTypeCustomer) . "'",
                "preface_name='" . esc($conn, $formData['preface_name']) . "'",
                "cus_address='" . esc($conn, $existingCustomerRow['cus_address'] ?? '') . "'",
                "cus_ampher='" . esc($conn, $existingCustomerRow['cus_ampher'] ?? '') . "'",
                "cus_province='" . esc($conn, $existingCustomerRow['cus_province'] ?? '') . "'",
                "cus_postcode='" . esc($conn, $existingCustomerRow['cus_postcode'] ?? '') . "'",
                "cus_tel='" . esc($conn, $existingCustomerRow['cus_tel'] ?? $formData['bill_tel']) . "'",
                "cus_fax='" . esc($conn, $existingCustomerRow['cus_fax'] ?? '') . "'",
                "bill_name='" . esc($conn, $formData['bill_name']) . "'",
                "bill_address='" . esc($conn, $formData['bill_address']) . "'",
                "bill_ampher='" . esc($conn, $formData['bill_ampher']) . "'",
                "billl_province='" . esc($conn, $formData['bill_province']) . "'",
                "bill_postcode='" . esc($conn, $formData['bill_postcode']) . "'",
                "bill_tel='" . esc($conn, $formData['bill_tel']) . "'",
                "tax_id='" . esc($conn, $formData['tax_id']) . "'",
                "delivery_name='" . esc($conn, $existingCustomerRow['delivery_name'] ?? '') . "'",
                "del_address='" . esc($conn, $existingCustomerRow['del_address'] ?? '') . "'",
                "del_ampher='" . esc($conn, $existingCustomerRow['del_ampher'] ?? '') . "'",
                "del_province='" . esc($conn, $existingCustomerRow['del_province'] ?? '') . "'",
                "del_postcode='" . esc($conn, $existingCustomerRow['del_postcode'] ?? '') . "'",
                "del_tel='" . esc($conn, $existingCustomerRow['del_tel'] ?? '') . "'",
                "contact_name='" . esc($conn, $existingCustomerRow['contact_name'] ?? '') . "'",
                "warranty='" . esc($conn, $existingCustomerRow['warranty'] ?? '') . "'",
                "brun_no='" . esc($conn, $formData['branch_no']) . "'",
                "h_ckk='" . esc($conn, $formData['branch_type']) . "'",
                "rental_name='" . esc($conn, $existingCustomerRow['rental_name'] ?? '') . "'",
                "rental_emer='" . esc($conn, $existingCustomerRow['rental_emer'] ?? '') . "'",
                "rental_address='" . esc($conn, $existingCustomerRow['rental_address'] ?? '') . "'",
                "rental_ampher='" . esc($conn, $existingCustomerRow['rental_ampher'] ?? '') . "'",
                "rental_province='" . esc($conn, $existingCustomerRow['rental_province'] ?? '') . "'",
                "rental_postcode='" . esc($conn, $existingCustomerRow['rental_postcode'] ?? '') . "'",
                "rental_emertel='" . esc($conn, $existingCustomerRow['rental_emertel'] ?? '') . "'",
                "rental_tel='" . esc($conn, $existingCustomerRow['rental_tel'] ?? '') . "'",
                "patient_name='" . esc($conn, $existingCustomerRow['patient_name'] ?? '') . "'",
                "install_address='" . esc($conn, $existingCustomerRow['install_address'] ?? '') . "'",
                "rental_contact='" . esc($conn, $existingCustomerRow['rental_contact'] ?? '') . "'",
                "rental_contacttel='" . esc($conn, $existingCustomerRow['rental_contacttel'] ?? '') . "'",
                "mode_name='" . esc($conn, $existingCustomerRow['mode_name'] ?? '') . "'",
                "email_cus='" . esc($conn, $formData['email_cus']) . "'",
                "vip_ckk='" . esc($conn, $existingCustomerRow['vip_ckk'] ?? '0') . "'",
                "credit_ckk='" . esc($conn, $existingCustomerRow['credit_ckk'] ?? '') . "'",
                "customer_coden='" . esc($conn, $existingCustomerRow['customer_coden'] ?? '') . "'",
                "close_ckk='" . esc($conn, $existingCustomerRow['close_ckk'] ?? '0') . "'",
                "remark_cus='" . esc($conn, $existingCustomerRow['remark_cus'] ?? '') . "'"
            );
        } else {
            $customerSqlData = array(
                "first_name=''",
                "last_name=''",
                "customer_no=''",
                "customer_coden=''",
                "customer_code=''",
                "customer_name='" . esc($conn, $fullName) . "'",
                "type_customer='" . esc($conn, $defaultTypeCustomer) . "'",
                "preface_name='" . esc($conn, $formData['preface_name']) . "'",
                "cus_address='" . esc($conn, $formData['bill_address']) . "'",
                "cus_ampher='" . esc($conn, $formData['bill_ampher']) . "'",
                "cus_province='" . esc($conn, $formData['bill_province']) . "'",
                "cus_postcode='" . esc($conn, $formData['bill_postcode']) . "'",
                "cus_tel='" . esc($conn, $formData['bill_tel']) . "'",
                "cus_fax=''",
                "bill_name='" . esc($conn, $formData['bill_name']) . "'",
                "bill_address='" . esc($conn, $formData['bill_address']) . "'",
                "bill_ampher='" . esc($conn, $formData['bill_ampher']) . "'",
                "billl_province='" . esc($conn, $formData['bill_province']) . "'",
                "bill_postcode='" . esc($conn, $formData['bill_postcode']) . "'",
                "bill_tel='" . esc($conn, $formData['bill_tel']) . "'",
                "tax_id='" . esc($conn, $formData['tax_id']) . "'",
                "delivery_name=''",
                "del_address=''",
                "del_ampher=''",
                "del_province=''",
                "del_postcode=''",
                "del_tel=''",
                "contact_name=''",
                "warranty=''",
                "brun_no='" . esc($conn, $formData['branch_no']) . "'",
                "h_ckk='" . esc($conn, $formData['branch_type']) . "'",
                "rental_name=''",
                "rental_emer=''",
                "rental_address=''",
                "rental_ampher=''",
                "rental_province=''",
                "rental_postcode=''",
                "rental_emertel=''",
                "rental_tel=''",
                "patient_name=''",
                "install_address=''",
                "rental_contact=''",
                "rental_contacttel=''",
                "mode_name=''",
                "email_cus='" . esc($conn, $formData['email_cus']) . "'",
                "vip_ckk='0'",
                "credit_ckk=''",
                "customer_coden=''",
                "close_ckk='0'",
                "remark_cus=''"
            );
        }

        if ($allOk) {
            if ($isEditMode) {
                $customerUpdateSql = "UPDATE tb_customer SET " . implode(', ', $customerSqlData) . " WHERE customer_id='" . esc($conn, $customerId) . "'";
                $allOk = mysqli_query($conn, $customerUpdateSql) ? true : false;
            } else {
                $customerInsertSql = "INSERT INTO tb_customer SET " . implode(', ', $customerSqlData);
                $allOk = mysqli_query($conn, $customerInsertSql) ? true : false;
                $customerId = $allOk ? mysqli_insert_id($conn) : 0;
            }
        }

        if ($allOk && $customerId > 0) {
            $primaryBillingSql = "INSERT INTO tb_customer_billing_address
                (customer_id, billing_index, billing_preface_name, billing_name, billing_tax_id, billing_tel, billing_email, billing_address, billing_ampher, billing_province, billing_postcode, billing_branch_type, billing_branch_no, is_primary)
                VALUES
                ('" . esc($conn, $customerId) . "', '1', '" . esc($conn, $formData['preface_name']) . "', '" . esc($conn, $formData['bill_name']) . "', '" . esc($conn, $formData['tax_id']) . "', '" . esc($conn, $formData['bill_tel']) . "', '" . esc($conn, $formData['email_cus']) . "', '" . esc($conn, $formData['bill_address']) . "', '" . esc($conn, $formData['bill_ampher']) . "', '" . esc($conn, $formData['bill_province']) . "', '" . esc($conn, $formData['bill_postcode']) . "', '" . esc($conn, $formData['branch_type']) . "', '" . esc($conn, $formData['branch_no']) . "', '1')";

            if ($isEditMode) {
                if ($billingRecordId > 0) {
                    $existingBillingSql = "UPDATE tb_customer_billing_address SET
                        billing_preface_name='" . esc($conn, $formData['preface_name']) . "',
                        billing_name='" . esc($conn, $formData['bill_name']) . "',
                        billing_tax_id='" . esc($conn, $formData['tax_id']) . "',
                        billing_tel='" . esc($conn, $formData['bill_tel']) . "',
                        billing_email='" . esc($conn, $formData['email_cus']) . "',
                        billing_address='" . esc($conn, $formData['bill_address']) . "',
                        billing_ampher='" . esc($conn, $formData['bill_ampher']) . "',
                        billing_province='" . esc($conn, $formData['bill_province']) . "',
                        billing_postcode='" . esc($conn, $formData['bill_postcode']) . "',
                        billing_branch_type='" . esc($conn, $formData['branch_type']) . "',
                        billing_branch_no='" . esc($conn, $formData['branch_no']) . "',
                        is_primary='1'
                        WHERE id='" . esc($conn, $billingRecordId) . "' AND customer_id='" . esc($conn, $customerId) . "'";
                    $allOk = mysqli_query($conn, $existingBillingSql) ? true : false;
                } else {
                    $primaryExists = (int)fetchValue($conn, "SELECT COUNT(*) FROM tb_customer_billing_address WHERE customer_id = " . (int)$customerId . " AND is_primary = 1", 0) > 0;
                    if ($primaryExists) {
                        $existingPrimaryBillingSql = "UPDATE tb_customer_billing_address SET
                        billing_preface_name='" . esc($conn, $formData['preface_name']) . "',
                        billing_name='" . esc($conn, $formData['bill_name']) . "',
                        billing_tax_id='" . esc($conn, $formData['tax_id']) . "',
                        billing_tel='" . esc($conn, $formData['bill_tel']) . "',
                        billing_email='" . esc($conn, $formData['email_cus']) . "',
                        billing_address='" . esc($conn, $formData['bill_address']) . "',
                        billing_ampher='" . esc($conn, $formData['bill_ampher']) . "',
                        billing_province='" . esc($conn, $formData['bill_province']) . "',
                        billing_postcode='" . esc($conn, $formData['bill_postcode']) . "',
                        billing_branch_type='" . esc($conn, $formData['branch_type']) . "',
                        billing_branch_no='" . esc($conn, $formData['branch_no']) . "',
                        is_primary='1'
                        WHERE customer_id='" . esc($conn, $customerId) . "' AND is_primary='1' LIMIT 1";
                        $allOk = mysqli_query($conn, $existingPrimaryBillingSql) ? true : false;
                    } else {
                        $allOk = mysqli_query($conn, $primaryBillingSql) ? true : false;
                    }
                }
            } else {
                $allOk = mysqli_query($conn, $primaryBillingSql) ? true : false;
            }
        }

        if ($allOk) {
            mysqli_commit($conn);
            $successMessage = $isEditMode ? 'อัปเดตข้อมูลสำเร็จ' : 'บันทึกข้อมูลสำเร็จ';
            $successCustomerId = (int)$customerId;
        } else {
            mysqli_rollback($conn);
            $errorMessage = 'ไม่สามารถบันทึกข้อมูลออกบิลได้';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <title>เพิ่มข้อมูลการออกบิล</title>
    <style>
        :root {
            --primary: #612989;
            --primary-soft: #f5eefb;
            --border: #ece7f2;
            --input-bg: #f5f6f8;
            --text: #2f3337;
            --muted: #8b8196;
            --danger: #d92d20;
            --shadow: 0 22px 54px rgba(35, 20, 49, 0.18);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 20px;
            background: #f3edf8;
            color: var(--text);
            font-family: 'Prompt', sans-serif;
        }

        .billing-page {
            max-width: 1120px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .billing-header {
            position: relative;
            padding: 22px 32px 16px;
            border-bottom: 1px solid var(--border);
        }

        .billing-header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
            color: #3b3b3b;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 18px;
            border: 0;
            background: transparent;
            color: #494949;
            font-size: 38px;
            line-height: 1;
            cursor: pointer;
        }

        .billing-form {
            padding: 18px 32px 24px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 18px 22px;
        }

        .field {
            grid-column: span 4;
        }

        .field.span-2 {
            grid-column: span 2;
        }

        .field.span-3 {
            grid-column: span 3;
        }

        .field.span-8 {
            grid-column: span 8;
        }

        .label {
            display: block;
            margin: 0 0 8px;
            color: var(--primary);
            font-size: 14px;
            font-weight: 400;
            white-space: nowrap;
        }

        .required {
            color: #f04438;
        }

        .control,
        .select {
            width: 100%;
            height: 42px;
            border: 0;
            border-radius: 10px;
            background: var(--input-bg);
            color: var(--text);
            font-family: 'Prompt', sans-serif;
            font-size: 16px;
            padding: 0 16px;
            outline: none;
        }

        .control-wrap {
            position: relative;
        }

        .control.has-clear {
            padding-right: 42px;
        }

        .clear {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #6d6d6d;
            font-size: 18px;
            cursor: pointer;
        }

        .readonly {
            color: #4c4c4c;
            font-weight: 500;
        }

        .error-box {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #fef3f2;
            color: var(--danger);
            font-size: 14px;
        }

        .success-modal {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(28, 18, 41, 0.35);
            z-index: 9999;
        }

        .success-modal[hidden] {
            display: none;
        }

        .success-modal-card {
            width: min(100%, 360px);
            padding: 28px 24px 22px;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 24px 60px rgba(49, 27, 71, 0.2);
            text-align: center;
        }

        .success-modal-badge {
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

        .success-modal-title {
            margin: 0 0 18px;
            font-size: 24px;
            font-weight: 600;
            color: #2f7d32;
        }

        .success-modal-actions {
            display: flex;
            justify-content: center;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            padding-top: 24px;
        }

        .btn {
            min-width: 158px;
            height: 42px;
            border-radius: 24px;
            font-family: 'Prompt', sans-serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-primary {
            border: 0;
            background: var(--primary);
            color: #fff;
        }

        .btn-secondary {
            border: 1px solid #dfdfdf;
            background: #fff;
            color: #333;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 900px) {

            .field,
            .field.span-2,
            .field.span-3,
            .field.span-8 {
                grid-column: span 12;
            }

            body {
                padding: 10px;
            }

            .billing-header,
            .billing-form {
                padding-left: 18px;
                padding-right: 18px;
            }

            .actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="billing-page">
        <div class="billing-header">
            <h1><?php echo h($isEditMode ? 'แก้ไขข้อมูลการออกบิล' : 'ข้อมูลการออกบิล'); ?></h1>
        </div>

        <form method="post" class="billing-form" novalidate>
            <input type="hidden" name="customer_id" value="<?php echo h($formData['customer_id']); ?>">
            <input type="hidden" name="billing_id" value="<?php echo h($formData['billing_id']); ?>">
            <?php if ($errorMessage !== '') { ?>
                <div class="error-box"><?php echo h($errorMessage); ?></div>
            <?php } ?>

            <div class="grid">
                <div class="field span-2">
                    <label class="label">รหัสลูกค้า AWL</label>
                    <input type="text" class="control readonly" value="<?php echo h($formData['customer_code'] !== '' ? $formData['customer_code'] : 'Auto'); ?>" readonly>
                </div>

                <div class="field span-2">
                    <label class="label">รหัสลูกค้า NBM</label>
                    <input type="text" class="control readonly" value="<?php echo h($formData['customer_coden'] !== '' ? $formData['customer_coden'] : 'Auto'); ?>" readonly>
                </div>

                <div class="field span-4">
                    <label class="label" for="preface_name">คำนำหน้าชื่อ<span class="required">*</span></label>
                    <select class="select" name="preface_name" id="preface_name" required>
                        <option value="">Select</option>
                        <?php foreach ($prefaceOptions as $option) { ?>
                            <option value="<?php echo h($option); ?>" <?php echo ($formData['preface_name'] === $option) ? 'selected' : ''; ?>><?php echo h($option); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="field span-4">
                    <label class="label" for="bill_name">ชื่อในการออกบิล<span class="required">*</span></label>
                    <div class="control-wrap">
                        <input type="text" class="control has-clear" name="bill_name" id="bill_name" value="<?php echo h($formData['bill_name']); ?>" required>
                        <button type="button" class="clear" data-clear-target="bill_name">&times;</button>
                    </div>
                </div>

                <div class="field span-4">
                    <label class="label" for="bill_tel">เบอร์โทร<span class="required">*</span></label>
                    <input type="text" class="control" name="bill_tel" id="bill_tel" inputmode="numeric" maxlength="15" value="<?php echo h($formData['bill_tel']); ?>" placeholder="ใส่เฉพาะตัวเลข" required>
                </div>

                <div class="field span-4">
                    <label class="label" for="tax_id">เลขประจำตัวผู้เสียภาษี<span class="required">*</span></label>
                    <input type="text" class="control" name="tax_id" id="tax_id" inputmode="numeric" maxlength="20" value="<?php echo h($formData['tax_id']); ?>" placeholder="ใส่เฉพาะตัวเลข" required>
                </div>

                <div class="field span-4">
                    <label class="label" for="email_cus">E-mail<span class="required">*</span></label>
                    <input type="email" class="control" name="email_cus" id="email_cus" value="<?php echo h($formData['email_cus']); ?>" required>
                </div>

                <div class="field span-8">
                    <label class="label" for="bill_address">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน<span class="required">*</span></label>
                    <div class="control-wrap">
                        <input type="text" class="control has-clear" name="bill_address" id="bill_address" value="<?php echo h($formData['bill_address']); ?>" required>
                        <button type="button" class="clear" data-clear-target="bill_address">&times;</button>
                    </div>
                </div>

                <div class="field span-4">
                    <label class="label" for="bill_province">จังหวัด<span class="required">*</span></label>
                    <select class="select" name="bill_province" id="bill_province" required>
                        <option value="">Select</option>
                        <?php foreach ($provinces as $province) { ?>
                            <option value="<?php echo h($province['province_name']); ?>" <?php echo ($formData['bill_province'] === $province['province_name']) ? 'selected' : ''; ?>><?php echo h($province['province_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="field span-4">
                    <label class="label" for="bill_ampher">เขต/อำเภอ<span class="required">*</span></label>
                    <input type="text" class="control" name="bill_ampher" id="bill_ampher" value="<?php echo h($formData['bill_ampher']); ?>" required>
                </div>

                <div class="field span-4">
                    <label class="label" for="bill_postcode">รหัสไปรษณีย์<span class="required">*</span></label>
                    <input type="text" class="control" name="bill_postcode" id="bill_postcode" inputmode="numeric" maxlength="10" value="<?php echo h($formData['bill_postcode']); ?>" required>
                </div>

                <div class="field span-4">
                    <label class="label" for="branch_type">เลือกสาขา<span class="required">*</span></label>
                    <select class="select" name="branch_type" id="branch_type" required>
                        <option value="">Select</option>
                        <option value="1" <?php echo ($formData['branch_type'] === '1') ? 'selected' : ''; ?>>สำนักงานใหญ่</option>
                        <option value="2" <?php echo ($formData['branch_type'] === '2') ? 'selected' : ''; ?>>สาขา</option>
                    </select>
                </div>

                <div class="field span-4">
                    <label class="label" for="branch_no">เลขที่สาขา<span class="required">*</span></label>
                    <input type="text" class="control" name="branch_no" id="branch_no" inputmode="numeric" maxlength="10" value="<?php echo h($formData['branch_no']); ?>" placeholder="ใส่เฉพาะตัวเลข" required>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary"><?php echo h($isEditMode ? 'อัปเดต' : 'เพิ่ม'); ?></button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='register_suphos.php'">ยกเลิก</button>
            </div>
        </form>

        <div id="billingSuccessModal" class="success-modal" <?php echo $successMessage !== '' ? '' : 'hidden'; ?>>
            <div class="success-modal-card">
                <div class="success-modal-badge">✓</div>
                <div class="success-modal-title"><?php echo h($successMessage); ?></div>
                <div class="success-modal-actions">
                    <button type="button" class="btn btn-primary" id="billingSuccessOk">ตกลง</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-clear-target]').forEach(function(button) {
            button.addEventListener('click', function() {
                var target = document.getElementById(button.getAttribute('data-clear-target'));
                if (target) {
                    target.value = '';
                    target.focus();
                }
            });
        });

        ['bill_tel', 'tax_id', 'bill_postcode', 'branch_no'].forEach(function(id) {
            var input = document.getElementById(id);
            if (!input) return;
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });
        });

        var branchType = document.getElementById('branch_type');
        var branchNo = document.getElementById('branch_no');
        if (branchType && branchNo) {
            branchType.addEventListener('change', function() {
                if (this.value === '1' && !branchNo.value.trim()) {
                    branchNo.value = '00000';
                }
            });
        }

        (function() {
            var successModal = document.getElementById('billingSuccessModal');
            var successOk = document.getElementById('billingSuccessOk');
            var successCustomerId = <?php echo (int)$successCustomerId; ?>;
            var successMessage = <?php echo json_encode($successMessage, JSON_UNESCAPED_UNICODE); ?>;

            function hideSuccessModal() {
                if (successModal) {
                    successModal.setAttribute('hidden', '');
                }
            }

            if (successOk) {
                successOk.addEventListener('click', hideSuccessModal);
            }

            if (successMessage) {
                if (window.opener && !window.opener.closed) {
                    if (typeof window.opener.handleBillingInfoCreated === 'function') {
                        window.opener.handleBillingInfoCreated(String(successCustomerId));
                    } else {
                        window.opener.location.reload();
                    }
                }
                if (successModal) {
                    successModal.removeAttribute('hidden');
                }
            }
        })();
    </script>
</body>

</html>