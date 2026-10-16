<?php
include('head.php');
include('dbconnect.php');
include('customer_code_lib.php');
include_once __DIR__ . '/includes/address_cascade.php';

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

$provinces = fetchRows($conn, "SELECT province_name FROM tb_province ORDER BY province_name");
$defaultTypeCustomer = fetchValue($conn, "SELECT type_id FROM tb_typecustomer ORDER BY type_id ASC LIMIT 1", '');
$customerId = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : (isset($_POST['customer_id']) ? (int)$_POST['customer_id'] : 0);
$billingRecordId = isset($_GET['billing_id']) ? (int)$_GET['billing_id'] : (isset($_POST['billing_id']) ? (int)$_POST['billing_id'] : 0);

// ข้อมูลการออกบิลต้องอยู่ภายใต้ลูกค้าเสมอ หน้านี้ไม่สร้างลูกค้าใหม่ (สร้างที่ customer_add.php)
// มี billing_id = แก้ไขบิลเดิม / ไม่มี billing_id = เพิ่มบิลใหม่ต่อท้ายใต้ลูกค้านั้น
$blockMessage = '';
$customerRow = null;
if ($customerId > 0) {
    $customerRows = fetchRows($conn, "SELECT * FROM tb_customer WHERE customer_id = " . (int)$customerId . " LIMIT 1");
    $customerRow = !empty($customerRows) ? $customerRows[0] : null;
}
if (!$customerRow) {
    $blockMessage = 'กรุณาเลือกลูกค้าก่อนเพิ่มข้อมูลออกบิล';
}

// ต้องมีตารางและคอลัมน์รหัสบิล 2+ ก่อนอ่าน/เขียน (ALTER commit ทรานแซกชันเอง จึงทำก่อน begin_transaction)
ensureCustomerChildTables($conn);
customer_code_ensure_billing_column($conn, 'awl');
customer_code_ensure_billing_column($conn, 'nbm');

// ใบหลัก = แถวบิลลำดับแรกของลูกค้า (ลำดับเดียวกับการ์ดใบที่ 1 ใน customer_add.php) ไม่อิง is_primary เพราะหน้านี้เคยตั้ง 1 ให้ทุกแถวที่ถูกแก้
$primaryBillingId = $customerRow ? (int)fetchValue($conn, "SELECT id FROM tb_customer_billing_address WHERE customer_id = " . (int)$customerId . " ORDER BY billing_index ASC, id ASC LIMIT 1", 0) : 0;

$billingRow = null;
if ($customerRow && $billingRecordId > 0) {
    $billingRows = fetchRows($conn, "SELECT * FROM tb_customer_billing_address WHERE id = " . (int)$billingRecordId . " AND customer_id = " . (int)$customerId . " LIMIT 1");
    $billingRow = !empty($billingRows) ? $billingRows[0] : null;
    if (!$billingRow) {
        $blockMessage = 'ไม่พบข้อมูลออกบิลนี้ของลูกค้า';
    }
}
$isEditMode = $billingRow !== null;

// คำนำหน้าชื่อไม่มีในฟอร์มแล้ว ค่าเดิมในฐานข้อมูลคงไว้ตามที่โหลดมา (เพิ่มใหม่ = ว่าง)
$formData = array(
    'customer_id' => $customerId,
    'billing_id' => $billingRecordId,
    'code_awl' => '',
    'code_nbm' => '',
    'code_source_key' => '',
    'preface_name' => '',
    'bill_name' => '',
    'bill_tel' => '',
    'tax_id' => '',
    'email_cus' => '',
    'bill_address' => '',
    'bill_province' => '',
    'bill_ampher' => '',
    'bill_tumbon' => '',
    'bill_postcode' => '',
    'branch_type' => '1',
    'branch_no' => '00000'
);

$successMessage = '';
$successCustomerId = 0;

if ($billingRow) {
    $formData['billing_id'] = (int)$billingRow['id'];
    $formData['preface_name'] = $billingRow['billing_preface_name'] ?? '';
    $formData['bill_name'] = $billingRow['billing_name'] ?? '';
    $formData['bill_tel'] = $billingRow['billing_tel'] ?? '';
    $formData['tax_id'] = $billingRow['billing_tax_id'] ?? '';
    $formData['email_cus'] = $billingRow['billing_email'] ?? '';
    $formData['bill_address'] = $billingRow['billing_address'] ?? '';
    $formData['bill_province'] = $billingRow['billing_province'] ?? '';
    $formData['bill_ampher'] = $billingRow['billing_ampher'] ?? '';
    $formData['bill_tumbon'] = $billingRow['billing_tumbon'] ?? '';
    $formData['bill_postcode'] = $billingRow['billing_postcode'] ?? '';
    // สาขาไม่บังคับ แถวที่บันทึกไว้ว่างต้องแสดงว่างตามจริง ไม่เติมค่าเริ่มต้นทับ
    $formData['branch_type'] = (string)($billingRow['billing_branch_type'] ?? '');
    $formData['branch_no'] = (string)($billingRow['billing_branch_no'] ?? '');
}

// รหัส AWL/NBM ตัดสินด้วย customer_id + เลขผู้เสียภาษี ทั้งตอนแสดงหน้าและตอนบันทึก (customer_code_lib.php)
// รหัสบิล 1 อยู่ใน tb_customer ส่วนบิล 2+ อยู่ในแถวบิลเอง
// ลูกค้าที่ยังไม่มีแถวบิล บิลที่เพิ่มคือใบหลัก ใช้รหัสเดิมบน tb_customer ต่อได้เมื่อ tax ตรงกับของลูกค้า (แหล่ง customer:<id>)
$codeCustomer = $customerRow ? customer_code_load_customer($conn, $customerId) : null;
$parentSourceKey = ($codeCustomer && !$billingRow && empty($codeCustomer['billings'])) ? 'customer:' . $customerId : '';

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $formData['code_awl'] = preg_replace('/\s+/', '', $formData['code_awl']);
    $formData['code_nbm'] = preg_replace('/\s+/', '', $formData['code_nbm']);
    // แหล่งรหัสที่เลือกจาก browser เป็นแค่คำขอ ตัวบันทึกตรวจกับฐานใหม่เสมอ
    $formData['code_source_key'] = trim($formData['code_source_key']);

    if ($blockMessage !== '') {
        $errorMessage = $blockMessage;
    } elseif (
        $formData['bill_name'] === '' ||
        $formData['bill_tel'] === '' ||
        $formData['tax_id'] === '' ||
        $formData['email_cus'] === '' ||
        $formData['bill_address'] === '' ||
        $formData['bill_province'] === '' ||
        $formData['bill_ampher'] === '' ||
        $formData['bill_tumbon'] === '' ||
        $formData['bill_postcode'] === ''
    ) {
        $errorMessage = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    } elseif (!filter_var($formData['email_cus'], FILTER_VALIDATE_EMAIL)) {
        $errorMessage = 'รูปแบบ E-mail ไม่ถูกต้อง';
    } else {
        // เช็คซ้ำเฉพาะบิลของลูกค้าคนเดียวกัน (ลูกค้าคนละคนมีข้อมูลบิลเหมือนกันได้)
        $duplicateSql = "SELECT id FROM tb_customer_billing_address WHERE customer_id = " . (int)$customerId . " AND billing_name='" . esc($conn, $formData['bill_name']) . "' AND billing_tax_id='" . esc($conn, $formData['tax_id']) . "' AND billing_tel='" . esc($conn, $formData['bill_tel']) . "' AND id <> " . (int)$billingRecordId . " LIMIT 1";
        $duplicateQuery = mysqli_query($conn, $duplicateSql);
        if ($duplicateQuery && mysqli_num_rows($duplicateQuery) > 0) {
            $errorMessage = 'ข้อมูลออกบิลนี้มีอยู่ในระบบแล้ว';
        }
    }

    // ถือ lock AWL ก่อน NBM ก่อนเริ่มทรานแซกชัน ให้ครอบตั้งแต่อ่านแหล่งรหัสจนเขียนเสร็จ (คอลัมน์รหัสเตรียมไว้ด้านบนแล้ว)
    if ($errorMessage === '' && !customer_code_acquire_locks($conn)) {
        $errorMessage = 'ระบบกำลังรันรหัสลูกค้าให้ผู้ใช้อื่น กรุณากดบันทึกอีกครั้ง';
    }

    if ($errorMessage === '') {
        $allOk = true;
        $targetBillingId = $billingRecordId;
        $lockedCustomer = null;
        $resolvedCodes = customer_code_pair();
        mysqli_begin_transaction($conn);

        // อ่านลูกค้า + บิลใหม่ภายใต้ lock แล้วตัดสินรหัสจากข้อมูลล่าสุด: รหัสเดิมของ customer_id + tax ใช้ต่อแม้เป็นเดือนเก่า
        // preview ที่กด Run มา รันใหม่ถ้าไม่ใช่เลขเดือนนี้หรือมีคนใช้ไปก่อนแล้ว
        try {
            $lockedCustomer = customer_code_load_customer($conn, $customerId, true);
            if (!$lockedCustomer || ($billingRecordId > 0 && !isset($lockedCustomer['billings'][$billingRecordId]))) {
                $allOk = false;
                $errorMessage = 'ไม่พบข้อมูลออกบิลนี้ของลูกค้า';
            } else {
                $resolution = customer_code_resolve_billing_cards($conn, $lockedCustomer, array(array(
                    'key' => 'single',
                    'number' => 1,
                    'record_id' => $billingRecordId,
                    'source_key' => $formData['code_source_key'],
                    'tax' => $formData['tax_id'],
                    'awl' => $formData['code_awl'],
                    'nbm' => $formData['code_nbm'],
                )));
                if ($resolution['ok']) {
                    $resolvedCodes = $resolution['codes'][0];
                } else {
                    $allOk = false;
                    $errorMessage = $resolution['message'];
                }
            }
        } catch (mysqli_sql_exception $e) {
            $allOk = false;
            $errorMessage = 'ตรวจสอบรหัสลูกค้าไม่สำเร็จ กรุณากดบันทึกอีกครั้ง';
        }

        $existingCustomerRow = $allOk ? $lockedCustomer['row'] : $customerRow;
        // ใบหลัก = แถวบิลลำดับแรกของลูกค้า ติ๊ก "ใช้เป็นข้อมูลหลัก" บนบิลใบอื่นจะสลับบิลนั้นขึ้นเป็นใบแรกพร้อมรหัส (เหมือนการ์ดใน customer_add.php)
        // แก้บิลใบอื่นโดยไม่ติ๊กต้องไม่เขียนทับค่าเริ่มต้นของลูกค้าใน tb_customer
        // ลูกค้าที่ยังไม่มีแถวบิลเลย บิลที่เพิ่มคือใบแรก = ใบหลัก
        $lockedBillingIds = $allOk ? array_keys($lockedCustomer['billings']) : array();
        $primaryBillingId = $lockedBillingIds ? (int)$lockedBillingIds[0] : 0;
        $isPrimaryBillingRow = $primaryBillingId === 0 || $billingRecordId === $primaryBillingId;
        $becomesPrimary = !$isPrimaryBillingRow && isset($_POST['is_primary']);

        $fullName = trim($formData['preface_name'] . ' ' . $formData['bill_name']);
        $customerSqlData = array(
            "customer_code='" . esc($conn, $resolvedCodes['awl']) . "'",
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
            "customer_coden='" . esc($conn, $resolvedCodes['nbm']) . "'",
            "close_ckk='" . esc($conn, $existingCustomerRow['close_ckk'] ?? '0') . "'",
            "remark_cus='" . esc($conn, $existingCustomerRow['remark_cus'] ?? '') . "'"
        );

        // บิลที่เพิ่มเป็นใบแรก / ติ๊กเป็นใบหลัก = เขียนค่าลง tb_customer ส่วนบิลใบอื่นที่ไม่ติ๊กต้องไม่เขียนทับค่าเริ่มต้นของลูกค้า
        if ($allOk && ($isPrimaryBillingRow || $becomesPrimary)) {
            $customerUpdateSql = "UPDATE tb_customer SET " . implode(', ', $customerSqlData) . " WHERE customer_id='" . esc($conn, $customerId) . "'";
            $allOk = mysqli_query($conn, $customerUpdateSql) ? true : false;
        }

        if ($allOk) {
            // บิล 1 เก็บรหัสไว้ใน tb_customer ด้วย แถวบิลทุกแถวเก็บรหัสของตัวเอง (เหมือน edit_customer1.php)
            $codeAwlSql = $resolvedCodes['awl'] === '' ? 'NULL' : "'" . esc($conn, $resolvedCodes['awl']) . "'";
            $codeNbmSql = $resolvedCodes['nbm'] === '' ? 'NULL' : "'" . esc($conn, $resolvedCodes['nbm']) . "'";
            $targetBillingId = $billingRecordId;

            if ($targetBillingId === 0) {
                // เพิ่มบิลใหม่ต่อท้ายใต้ลูกค้านี้ (ลูกค้าที่ยังไม่มีบิลเลย บิลนี้คือลำดับ 1)
                $nextBillingIndex = (int)fetchValue($conn, "SELECT MAX(billing_index) FROM tb_customer_billing_address WHERE customer_id = " . (int)$customerId, 0) + 1;
                $billingInsertSql = "INSERT INTO tb_customer_billing_address
                    (customer_id, billing_index, billing_code, billing_coden, billing_preface_name, billing_name, billing_tax_id, billing_tel, billing_email, billing_address, billing_ampher, billing_tumbon, billing_province, billing_postcode, billing_branch_type, billing_branch_no, is_primary)
                    VALUES
                    ('" . esc($conn, $customerId) . "', '" . $nextBillingIndex . "', " . $codeAwlSql . ", " . $codeNbmSql . ", '" . esc($conn, $formData['preface_name']) . "', '" . esc($conn, $formData['bill_name']) . "', '" . esc($conn, $formData['tax_id']) . "', '" . esc($conn, $formData['bill_tel']) . "', '" . esc($conn, $formData['email_cus']) . "', '" . esc($conn, $formData['bill_address']) . "', '" . esc($conn, $formData['bill_ampher']) . "', '" . esc($conn, $formData['bill_tumbon']) . "', '" . esc($conn, $formData['bill_province']) . "', '" . esc($conn, $formData['bill_postcode']) . "', '" . esc($conn, $formData['branch_type']) . "', '" . esc($conn, $formData['branch_no']) . "', '" . ($nextBillingIndex === 1 ? 1 : 0) . "')";
                $allOk = mysqli_query($conn, $billingInsertSql) ? true : false;
                $targetBillingId = $allOk ? (int)mysqli_insert_id($conn) : 0;
            } else {
                // คำนำหน้าชื่อไม่มีในฟอร์ม จึงไม่แตะ billing_preface_name ของแถวที่แก้
                $existingBillingSql = "UPDATE tb_customer_billing_address SET
                    billing_code=" . $codeAwlSql . ",
                    billing_coden=" . $codeNbmSql . ",
                    billing_name='" . esc($conn, $formData['bill_name']) . "',
                    billing_tax_id='" . esc($conn, $formData['tax_id']) . "',
                    billing_tel='" . esc($conn, $formData['bill_tel']) . "',
                    billing_email='" . esc($conn, $formData['email_cus']) . "',
                    billing_address='" . esc($conn, $formData['bill_address']) . "',
                    billing_ampher='" . esc($conn, $formData['bill_ampher']) . "',
                    billing_tumbon='" . esc($conn, $formData['bill_tumbon']) . "',
                    billing_province='" . esc($conn, $formData['bill_province']) . "',
                    billing_postcode='" . esc($conn, $formData['bill_postcode']) . "',
                    billing_branch_type='" . esc($conn, $formData['branch_type']) . "',
                    billing_branch_no='" . esc($conn, $formData['branch_no']) . "'
                    WHERE id='" . esc($conn, $targetBillingId) . "' AND customer_id='" . esc($conn, $customerId) . "'";
                $allOk = mysqli_query($conn, $existingBillingSql) ? true : false;
            }

            if ($allOk && $becomesPrimary) {
                // ย้ายบิลนี้ขึ้นเป็นลำดับ 1 ที่เหลือเรียงต่อตามเดิม ใบหลักเดิมส่งรหัสใน tb_customer ลงแถวของตัวเอง
                $orderedIds = array($targetBillingId);
                foreach (fetchRows($conn, "SELECT id FROM tb_customer_billing_address WHERE customer_id = " . (int)$customerId . " ORDER BY billing_index ASC, id ASC") as $orderRow) {
                    if ((int)$orderRow['id'] !== $targetBillingId) {
                        $orderedIds[] = (int)$orderRow['id'];
                    }
                }
                foreach ($orderedIds as $position => $orderedId) {
                    $reorderSet = "billing_index=" . ($position + 1) . ", is_primary=" . ($position === 0 ? 1 : 0);
                    if ($orderedId === $primaryBillingId) {
                        $oldAwl = trim((string)($existingCustomerRow['customer_code'] ?? ''));
                        $oldNbm = trim((string)($existingCustomerRow['customer_coden'] ?? ''));
                        $reorderSet .= ", billing_code=" . ($oldAwl === '' ? 'NULL' : "'" . esc($conn, $oldAwl) . "'") . ", billing_coden=" . ($oldNbm === '' ? 'NULL' : "'" . esc($conn, $oldNbm) . "'");
                    }
                    $allOk = mysqli_query($conn, "UPDATE tb_customer_billing_address SET " . $reorderSet . " WHERE id=" . $orderedId . " AND customer_id=" . (int)$customerId) ? true : false;
                    if (!$allOk) {
                        break;
                    }
                }
            }
        }

        if ($allOk) {
            mysqli_commit($conn);
            $successMessage = $isEditMode ? 'อัปเดตข้อมูลสำเร็จ' : 'บันทึกข้อมูลสำเร็จ';
            $successCustomerId = (int)$customerId;
            // เพิ่มสำเร็จแล้วหน้านี้กลายเป็นการแก้บิลใบที่เพิ่งสร้าง กดซ้ำจะไม่เพิ่มบิลซ้ำ
            $billingRecordId = $targetBillingId;
            $formData['billing_id'] = $targetBillingId;
            $formData['code_awl'] = $resolvedCodes['awl'];
            $formData['code_nbm'] = $resolvedCodes['nbm'];
        } else {
            mysqli_rollback($conn);
            if ($errorMessage === '') {
                $errorMessage = 'ไม่สามารถบันทึกข้อมูลออกบิลได้';
            }
        }
        customer_code_release_locks($conn);
    }
}

// สถานะรหัสของการ์ด: บันทึกสำเร็จอ่านจากค่าที่บันทึกจริง / บันทึกไม่ผ่านใช้ค่าที่ POST มาแต่ตรวจกับฐานใหม่
$codeView = null;
if ($customerRow && $blockMessage === '' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $codeCustomer = customer_code_load_customer($conn, $customerId);
}
if ($customerRow && $codeCustomer && $blockMessage === '') {
    $showPosted = $_SERVER['REQUEST_METHOD'] === 'POST' && $successMessage === '';
    $codeCard = array(
        'key' => 'single',
        'number' => 1,
        'record_id' => (int)$formData['billing_id'],
        // ลูกค้าที่ยังไม่มีแถวบิลอ้าง customer:<id> เสมอ (ให้ JS คืนรหัสเดิมเมื่อกรอก tax ตรงกับของลูกค้า)
        // บิลที่เพิ่งบันทึกมีแถวแล้ว ไม่อ้างรหัสบน tb_customer แทนแถวบิล
        'source_key' => $successMessage !== '' ? '' : ($parentSourceKey !== '' ? $parentSourceKey : ($showPosted ? $formData['code_source_key'] : '')),
        'tax' => customer_code_normalize_tax($formData['tax_id']),
        'awl' => $showPosted ? $formData['code_awl'] : '',
        'nbm' => $showPosted ? $formData['code_nbm'] : '',
    );
    $codeView = customer_code_card_view($codeCustomer, $codeCard);
    $formData['code_awl'] = $codeView['codes']['awl'];
    $formData['code_nbm'] = $codeView['codes']['nbm'];
}

// บิลที่เปิดอยู่เป็นใบหลักหรือไม่ (หลังบันทึกแล้วอ่านใหม่ เพราะการติ๊กอาจสลับลำดับ) ใบหลักติ๊กค้างเอาออกไม่ได้ บิลที่กำลังเพิ่มติ๊กเองได้
$displayBillingId = (int)$formData['billing_id'];
$displayPrimaryId = $customerRow ? (int)fetchValue($conn, "SELECT id FROM tb_customer_billing_address WHERE customer_id = " . (int)$customerId . " ORDER BY billing_index ASC, id ASC LIMIT 1", 0) : 0;
$isPrimaryLocked = $displayBillingId > 0 ? $displayBillingId === $displayPrimaryId : $displayPrimaryId === 0;
$isPrimaryChecked = $isPrimaryLocked || isset($_POST['is_primary']);
$isFormBlocked = $blockMessage !== '';
if ($isFormBlocked && $errorMessage === '') {
    $errorMessage = $blockMessage;
}

// ชุดตัวเลือก อำเภอ/ตำบล/ไปรษณีย์ ของค่าที่แสดงอยู่ (ค่าที่บันทึกไว้ หรือค่าที่ POST มาตอนบันทึกไม่ผ่าน)
$billAddressData = address_cascade_data($conn, $formData['bill_province'], $formData['bill_ampher'], $formData['bill_tumbon'], $formData['bill_postcode']);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มข้อมูลการออกบิล</title>
    <style>
        :root {
            --primary: #612989;
            --primary-soft: #f1e1ff;
            --border: #ede9f0;
            --input-bg: #f5f6f8;
            --text: #3b3b3b;
            --placeholder: #696969;
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
            max-width: 1096px;
            margin: 0 auto;
            padding: 25px 32px;
            background: #fff;
            border-radius: 10px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .billing-header {
            padding: 0 10px 2px;
            border-bottom: 2px solid var(--border);
            margin: 0 0 15px;
        }

        .billing-header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 500;
            line-height: 30px;
            color: var(--text);
        }

        .form-fieldset {
            min-width: 0;
            margin: 0;
            padding: 0;
            border: 0;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .field {
            min-width: 0;
        }

        .field.span-full {
            grid-column: 1 / -1;
        }

        .field.span-2 {
            grid-column: span 2;
        }

        .label {
            display: block;
            margin: 0 0 0 10px;
            color: var(--primary);
            font-size: 13px;
            font-weight: 400;
            line-height: 21px;
            white-space: nowrap;
        }

        .required {
            color: red;
        }

        .control,
        .select {
            display: block;
            width: 100%;
            height: 42px;
            border: 0;
            border-radius: 10px;
            background: var(--input-bg);
            color: var(--text);
            font-family: 'Prompt', sans-serif;
            font-size: 14px;
            padding: 0 16px;
            outline: none;
        }

        .control:focus,
        .select:focus {
            box-shadow: 0 0 0 2px rgba(97, 41, 137, 0.25);
        }

        /* ฟิลด์บังคับที่ว่าง/ผิดรูปแบบ ใส่ class โดย js/so-required-fields.js สีเดียวกับ .so-field-invalid ใน css/so-core.css */
        .control.so-field-invalid,
        .select.so-field-invalid {
            border: 1px solid #DC3545;
            background-color: #FEECEB;
        }

        .control.so-field-invalid:focus,
        .select.so-field-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
        }

        .control::placeholder {
            color: var(--placeholder);
        }

        .select {
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
        }

        .control-wrap {
            position: relative;
        }

        .control-wrap.has-clear .control {
            padding-right: 48px;
        }

        .control-wrap.has-chevron .control,
        .control-wrap.has-chevron .select {
            padding-right: 48px;
        }

        .clear {
            position: absolute;
            top: 9px;
            right: 16px;
            width: 24px;
            height: 24px;
            display: grid;
            place-items: center;
            border: 0;
            padding: 0;
            background: transparent;
            cursor: pointer;
        }

        .clear img {
            width: 12px;
            height: 12px;
        }

        .chevron {
            position: absolute;
            top: 9px;
            right: 16px;
            width: 24px;
            height: 24px;
            pointer-events: none;
        }

        .code-field {
            display: flex;
            align-items: flex-end;
            gap: 24px;
        }

        .code-group {
            flex: 1 1 0;
            max-width: 152px;
            min-width: 0;
        }

        .control.readonly {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        .run-button {
            flex: none;
            width: 152px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            border: 0;
            border-radius: 21px;
            background: var(--primary-soft);
            box-shadow: 0 0 2px rgba(97, 41, 137, 0.25);
            color: var(--primary);
            font-family: 'Prompt', sans-serif;
            font-size: 13px;
            font-weight: 500;
            padding: 9px 8px 9px 13px;
            white-space: nowrap;
            cursor: pointer;
        }

        .run-button .run-icon {
            width: 24px;
            height: 24px;
            display: grid;
            place-items: center;
            flex: none;
        }

        .run-button .run-icon img {
            width: 21.5px;
            height: 17.5px;
        }

        .run-button:hover {
            background: #e8cffb;
        }

        .run-button:disabled {
            opacity: 0.6;
            cursor: wait;
        }

        /* รหัสที่ใช้ของเดิม/บันทึกแล้วซ่อน Run ไม่ให้เหลือพื้นที่หรือโฟกัสได้ */
        .run-button[hidden],
        .code-status[hidden] {
            display: none;
        }

        .code-status {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px 16px;
            margin-top: -12px;
            padding: 0 10px;
            color: var(--primary);
            font-size: 13px;
            line-height: 21px;
        }

        .code-status[data-tone="error"] {
            color: var(--danger);
        }

        .code-status-action {
            border: 0;
            border-radius: 15px;
            background: var(--primary-soft);
            color: var(--primary);
            font-family: 'Prompt', sans-serif;
            font-size: 13px;
            font-weight: 500;
            padding: 4px 14px;
            cursor: pointer;
        }

        .primary-field {
            display: flex;
            align-items: flex-end;
        }

        .primary-toggle {
            width: 152px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-radius: 10px;
            background: var(--input-bg);
            color: var(--placeholder);
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
        }

        .primary-toggle input {
            display: none;
        }

        .primary-toggle img {
            width: 24px;
            height: 24px;
            filter: brightness(0) opacity(0.35);
        }

        .primary-toggle.is-active {
            background: var(--primary);
            color: #fff;
        }

        .primary-toggle.is-active img {
            filter: none;
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
            gap: 24px;
            padding-top: 28px;
        }

        .btn {
            width: 157px;
            height: 40px;
            border-radius: 25px;
            font-family: 'Prompt', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
        }

        .btn-primary {
            border: 0;
            background: var(--primary);
            color: #fff;
        }

        .btn-secondary {
            border: 0;
            background: #fff;
            color: var(--text);
        }

        @media (max-width: 900px) {
            body {
                padding: 10px;
            }

            .billing-page {
                padding: 20px 18px;
            }

            .grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .field.span-full,
            .field.span-2 {
                grid-column: auto;
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

            <fieldset class="form-fieldset" <?php echo $isFormBlocked ? 'disabled' : ''; ?>>
            <!-- จังหวัด → เขต/อำเภอ → แขวง/ตำบล → รหัสไปรษณีย์ ผูกกันด้วย data-address-level ภายใน data-address-scope (js/address-cascade.js) -->
            <!-- รหัส AWL/NBM ควบคุมโดย js/billing-customer-codes.js (data-code-view = customer_code_card_view) -->
            <!-- ฟิลด์บังคับ = .so-label ที่มี <span>*</span> ใน .so-field-group ตรวจด้วย soValidateRequired() (js/so-required-fields.js) -->
            <div class="grid js-billing-code-card" data-address-scope data-client-key="single" data-record-id="<?php echo h((int)$formData['billing_id']); ?>"<?php echo $codeView !== null ? ' data-code-view="' . customer_code_view_attr($codeView) . '"' : ''; ?>>
                <input type="hidden" class="js-code-source" name="code_source_key" value="<?php echo h($formData['code_source_key']); ?>">
                <div class="field code-field js-code-row" data-code-type="awl">
                    <div class="code-group">
                        <label class="label">รหัสลูกค้า AWL</label>
                        <input type="text" class="control readonly js-code-display" value="<?php echo h($formData['code_awl'] !== '' ? $formData['code_awl'] : 'Auto'); ?>" readonly>
                        <input type="hidden" class="js-code-value" name="code_awl" value="<?php echo h($formData['code_awl']); ?>">
                    </div>
                    <button type="button" class="run-button js-code-run">
                        <span class="run-icon"><img src="img/icons/figma_user_id.svg" alt=""></span>
                        <span>Run รหัสลูกค้า</span>
                    </button>
                </div>

                <div class="field code-field js-code-row" data-code-type="nbm">
                    <div class="code-group">
                        <label class="label">รหัสลูกค้า NBM</label>
                        <input type="text" class="control readonly js-code-display" value="<?php echo h($formData['code_nbm'] !== '' ? $formData['code_nbm'] : 'Auto'); ?>" readonly>
                        <input type="hidden" class="js-code-value" name="code_nbm" value="<?php echo h($formData['code_nbm']); ?>">
                    </div>
                    <button type="button" class="run-button js-code-run">
                        <span class="run-icon"><img src="img/icons/figma_user_id.svg" alt=""></span>
                        <span>Run รหัสลูกค้า</span>
                    </button>
                </div>

                <div class="field span-full code-status js-code-status" role="status" hidden></div>

                <div class="field so-field-group">
                    <label class="label so-label" for="bill_name">ชื่อในการออกบิล<span class="required">*</span></label>
                    <div class="control-wrap has-clear">
                        <input type="text" class="control" name="bill_name" id="bill_name" value="<?php echo h($formData['bill_name']); ?>" placeholder="ใส่ชื่อในการออกบิล" required>
                        <button type="button" class="clear" data-clear-target="bill_name" aria-label="ล้างข้อมูล"><img src="img/icons/figma_cancel.svg" alt=""></button>
                    </div>
                </div>

                <div class="field so-field-group">
                    <label class="label so-label" for="tax_id">เลขประจำตัวผู้เสียภาษี<span class="required">*</span></label>
                    <input type="text" class="control" name="tax_id" id="tax_id" inputmode="numeric" maxlength="20" value="<?php echo h($formData['tax_id']); ?>" placeholder="ถ้าไม่มีข้อมูลใส่ศูนย์ 13 ตัว" required>
                </div>

                <div class="field so-field-group">
                    <label class="label so-label" for="bill_tel">เบอร์โทร<span class="required">*</span></label>
                    <input type="text" class="control" name="bill_tel" id="bill_tel" inputmode="numeric" maxlength="15" value="<?php echo h($formData['bill_tel']); ?>" placeholder="ใส่เฉพาะตัวเลข" required>
                </div>

                <div class="field so-field-group">
                    <label class="label so-label" for="email_cus">E-mail<span class="required">*</span></label>
                    <input type="email" class="control" name="email_cus" id="email_cus" value="<?php echo h($formData['email_cus']); ?>" placeholder="ใส่ที่อยู่อีเมล" required>
                </div>

                <div class="field span-2 so-field-group">
                    <label class="label so-label" for="bill_address">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน<span class="required">*</span></label>
                    <div class="control-wrap has-clear">
                        <input type="text" class="control" name="bill_address" id="bill_address" value="<?php echo h($formData['bill_address']); ?>" placeholder="ใส่เลขที่ ตรอก ซอย ถนน" required>
                        <button type="button" class="clear" data-clear-target="bill_address" aria-label="ล้างข้อมูล"><img src="img/icons/figma_cancel.svg" alt=""></button>
                    </div>
                </div>

                <div class="field so-field-group">
                    <label class="label so-label" for="bill_province">จังหวัด<span class="required">*</span></label>
                    <div class="control-wrap has-chevron">
                        <select class="select" name="bill_province" id="bill_province" data-address-level="province" required>
                            <option value="">Select</option>
                            <?php foreach ($provinces as $province) { ?>
                                <option value="<?php echo h($province['province_name']); ?>" <?php echo ($formData['bill_province'] === $province['province_name']) ? 'selected' : ''; ?>><?php echo h($province['province_name']); ?></option>
                            <?php } ?>
                        </select>
                        <img class="chevron" src="img/icons/figma_nav_arrow_down.svg" alt="">
                    </div>
                </div>

                <div class="field so-field-group">
                    <label class="label so-label" for="bill_ampher">เขต/อำเภอ<span class="required">*</span></label>
                    <div class="control-wrap has-chevron">
                        <select class="select" name="bill_ampher" id="bill_ampher" data-address-level="district" required><?php echo address_cascade_district_options($billAddressData); ?></select>
                        <img class="chevron" src="img/icons/figma_nav_arrow_down.svg" alt="">
                    </div>
                </div>

                <div class="field so-field-group">
                    <label class="label so-label" for="bill_tumbon">แขวง/ตำบล<span class="required">*</span></label>
                    <div class="control-wrap has-chevron">
                        <select class="select" name="bill_tumbon" id="bill_tumbon" data-address-level="sub_district" required><?php echo address_cascade_sub_district_options($billAddressData); ?></select>
                        <img class="chevron" src="img/icons/figma_nav_arrow_down.svg" alt="">
                    </div>
                </div>

                <div class="field so-field-group">
                    <label class="label so-label" for="bill_postcode">รหัสไปรษณีย์<span class="required">*</span></label>
                    <div class="control-wrap has-chevron">
                        <select class="select" name="bill_postcode" id="bill_postcode" data-address-level="postcode" required><?php echo address_cascade_postcode_options($billAddressData); ?></select>
                        <img class="chevron" src="img/icons/figma_nav_arrow_down.svg" alt="">
                    </div>
                </div>

                <div class="field so-field-group">
                    <label class="label so-label" for="branch_type">เลือกสาขา</label>
                    <div class="control-wrap has-chevron">
                        <select class="select" name="branch_type" id="branch_type">
                            <option value="">Select</option>
                            <option value="1" <?php echo ($formData['branch_type'] === '1') ? 'selected' : ''; ?>>สำนักงานใหญ่</option>
                            <option value="2" <?php echo ($formData['branch_type'] === '2') ? 'selected' : ''; ?>>สาขา</option>
                        </select>
                        <img class="chevron" src="img/icons/figma_nav_arrow_down.svg" alt="">
                    </div>
                </div>

                <div class="field so-field-group">
                    <label class="label so-label" for="branch_no">เลขที่สาขา</label>
                    <input type="text" class="control" name="branch_no" id="branch_no" inputmode="numeric" maxlength="10" value="<?php echo h($formData['branch_no']); ?>" placeholder="ใส่เฉพาะตัวเลข">
                </div>

                <div class="field primary-field">
                    <label class="primary-toggle<?php echo $isPrimaryChecked ? ' is-active' : ''; ?>" id="primaryToggle">
                        <input type="checkbox" name="is_primary" id="is_primary" value="1" <?php echo $isPrimaryChecked ? 'checked' : ''; ?> data-locked="<?php echo $isPrimaryLocked ? '1' : '0'; ?>">
                        <img src="img/icons/dropdown-arrow-down.svg" alt="" aria-hidden="true">
                        <span>ใช้เป็นข้อมูลหลัก</span>
                    </label>
                </div>
            </div>
            </fieldset>

            <div class="actions">
                <button type="submit" class="btn btn-primary" <?php echo $isFormBlocked ? 'disabled' : ''; ?>><?php echo h($isEditMode ? 'อัปเดต' : 'เพิ่ม'); ?></button>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/address-cascade.js"></script>
    <script src="js/so-required-fields.js?v=<?php echo filemtime(__DIR__ . '/js/so-required-fields.js'); ?>"></script>
    <script src="js/billing-customer-codes.js?v=<?php echo filemtime(__DIR__ . '/js/billing-customer-codes.js'); ?>"></script>
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

        ['bill_tel', 'tax_id', 'branch_no'].forEach(function(id) {
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

        // ใบหลักและลูกค้าใหม่ติ๊กค้างเอาออกไม่ได้ (ลูกค้าต้องมีใบหลักหนึ่งใบเสมอ) บิลใบอื่นติ๊กเพื่อสลับขึ้นเป็นใบหลักตอนกดบันทึก
        (function() {
            var toggle = document.getElementById('primaryToggle');
            var checkbox = document.getElementById('is_primary');
            if (!toggle || !checkbox) return;

            checkbox.addEventListener('change', function() {
                if (checkbox.getAttribute('data-locked') === '1') {
                    checkbox.checked = true;
                }
                toggle.classList.toggle('is-active', checkbox.checked);
            });
        })();

        // E-mail ที่กรอกแล้วแต่ผิดรูปแบบ: กรอบแดงค้างจนกว่าจะแก้ค่า (กรณีว่างถูก soValidateRequired() จับไปก่อนแล้ว)
        function validateBillingEmail() {
            var emailInput = document.getElementById('email_cus');
            if (!emailInput) return true;
            emailInput.value = emailInput.value.trim();
            if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) return true;
            soMarkFieldInvalid(emailInput);
            Swal.fire('แจ้งเตือน', 'รูปแบบ E-mail ไม่ถูกต้อง', 'warning').then(function() {
                emailInput.focus();
            });
            return false;
        }

        // รหัสลูกค้า AWL/NBM: ใช้รหัสเดิมของ customer_id + เลขผู้เสียภาษีอัตโนมัติ ไม่มีจึง Run (ดู js/billing-customer-codes.js)
        // ปิดปุ่มบันทึกระหว่างตรวจ/Run และเมื่อตรวจไม่สำเร็จหรือยังไม่ได้เลือกรหัส
        (function() {
            var form = document.querySelector('.billing-form');
            var card = form ? form.querySelector('.js-billing-code-card') : null;
            var submitButton = form ? form.querySelector('button[type="submit"]') : null;
            if (!submitButton || submitButton.disabled) return;

            var billingCodes = (card && window.BillingCustomerCodes) ? window.BillingCustomerCodes.create({
                root: form,
                cardSelector: '.js-billing-code-card',
                taxSelector: '#tax_id',
                customerId: <?php echo (int)$customerId; ?>,
                multi: false,
                onBlockedChange: function(blocked) {
                    submitButton.disabled = blocked;
                }
            }) : null;

            // ลำดับเดียวกับ customer_add.php: ฟิลด์บังคับ (กรอบแดงทุกช่องที่ว่าง) → รูปแบบ E-mail → รอตรวจรหัสลูกค้า
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                if (!soValidateRequired(form)) return;
                if (!validateBillingEmail()) return;
                var codesReady = billingCodes ? billingCodes.prepareSubmit() : Promise.resolve(true);
                codesReady.then(function(ready) {
                    if (ready) {
                        HTMLFormElement.prototype.submit.call(form);
                    }
                });
            });
        })();

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
