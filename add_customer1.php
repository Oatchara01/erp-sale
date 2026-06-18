<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");

function normalizeThaiName($text)
{
    $text = trim($text);
    $text = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
    $text = preg_replace('/[\p{Z}\s]+/u', ' ', $text);
    return trim($text);
}

function postValue($key, $default = '')
{
    return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

function postArray($key)
{
    if (!isset($_POST[$key]) || !is_array($_POST[$key])) {
        return array();
    }

    return array_values($_POST[$key]);
}

function esc($connection, $value)
{
    return mysqli_real_escape_string($connection, $value);
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

    $shippingSql = "
        CREATE TABLE IF NOT EXISTS tb_customer_shipping_address (
            id INT NOT NULL AUTO_INCREMENT,
            customer_id INT NOT NULL,
            shipping_index INT NOT NULL DEFAULT 1,
            shipping_preface_name VARCHAR(100) DEFAULT NULL,
            shipping_name VARCHAR(255) DEFAULT NULL,
            shipping_tel VARCHAR(50) DEFAULT NULL,
            shipping_address TEXT DEFAULT NULL,
            shipping_ampher VARCHAR(255) DEFAULT NULL,
            shipping_province VARCHAR(255) DEFAULT NULL,
            shipping_postcode VARCHAR(20) DEFAULT NULL,
            is_primary TINYINT(1) NOT NULL DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_customer_shipping_customer_id (customer_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    if (!mysqli_query($connection, $billingSql)) {
        return false;
    }

    if (!mysqli_query($connection, $shippingSql)) {
        return false;
    }

    return true;
}

if (isset($_POST["submit"])) {
    $preface_name = postValue("preface_name");
    $customer_code = postValue("customer_code");
    $customer_name1 = normalizeThaiName(postValue("customer_name"));
    $customer_name = trim($preface_name . " " . $customer_name1);
    $type_customer = postValue("type_customer");
    $credit_ckk = postValue("credit_ckk");
    $cus_address = postValue("cus_address");
    $cus_ampher = postValue("cus_ampher");
    $cus_province = postValue("cus_province");
    $cus_postcode = postValue("cus_postcode");
    $cus_tel = preg_replace('/[^0-9]/', '', postValue("cus_tel"));
    $cus_fax = postValue("cus_fax");
    $mode_name = postValue("h_mode_name");
    $vip_ckk = isset($_POST["vip_ckk"]) ? "1" : "0";

    $billingPrefaces = postArray("billing_preface_name");
    $billingNames = postArray("billing_name");
    $billingTaxIds = postArray("billing_tax_id");
    $billingTels = postArray("billing_tel");
    $billingEmails = postArray("billing_email");
    $billingAddresses = postArray("billing_address");
    $billingAmphers = postArray("billing_ampher");
    $billingProvinces = postArray("billing_province");
    $billingPostcodes = postArray("billing_postcode");
    $billingBranchTypes = postArray("billing_branch_type");
    $billingBranchNos = postArray("billing_branch_no");

    $shippingPrefaces = postArray("shipping_preface_name");
    $shippingNames = postArray("shipping_name");
    $shippingTels = postArray("shipping_tel");
    $shippingAddresses = postArray("shipping_address");
    $shippingAmphers = postArray("shipping_ampher");
    $shippingProvinces = postArray("shipping_province");
    $shippingPostcodes = postArray("shipping_postcode");

    $primaryBillName = normalizeThaiName(postValue("bill_name"));
    $primaryBillAddress = postValue("bill_address");
    $primaryBillAmpher = postValue("bill_ampher");
    $primaryBillProvince = postValue("billl_province");
    $primaryBillPostcode = postValue("bill_postcode");
    $primaryBillTel = preg_replace('/[^0-9]/', '', postValue("bill_tel"));
    $tax_id = preg_replace('/[^0-9]/', '', postValue("tax_id"));
    $h_ckk = postValue("h_ckk");
    $brun_no = preg_replace('/[^0-9]/', '', postValue("brun_no"));
    $email_cus = postValue("email_cus");

    $delivery_name = normalizeThaiName(postValue("delivery_name"));
    $del_address = postValue("del_address");
    $del_ampher = postValue("del_ampher");
    $del_province = postValue("del_province");
    $del_postcode = postValue("del_postcode");
    $del_tel = preg_replace('/[^0-9]/', '', postValue("del_tel"));
    $contact_name = normalizeThaiName(postValue("contact_name"));

    $warranty = postValue("warranty");

    $rental_name = postValue("rental_name");
    $rental_address = postValue("rental_address");
    $rental_ampher = postValue("rental_ampher");
    $rental_province = postValue("rental_province");
    $rental_postcode = postValue("rental_postcode");
    $rental_tel = postValue("rental_tel");
    $rental_emer = postValue("rental_emer");
    $rental_emertel = postValue("rental_emertel");
    $patient_name = postValue("patient_name");
    $install_address = postValue("install_address");
    $rental_contact = postValue("rental_contact");
    $rental_contacttel = postValue("rental_contacttel");

    $sale_codes = isset($_POST["sale_code"]) && is_array($_POST["sale_code"]) ? $_POST["sale_code"] : array();

    $sql1 = "SELECT cus_tel FROM tb_customer WHERE cus_tel = '" . esc($conn, $cus_tel) . "'";
    $qry1 = mysqli_query($conn, $sql1);
    $numRows1 = $qry1 ? mysqli_num_rows($qry1) : 0;

    if ($numRows1 > 0) {
        echo "<script>alert('ได้มีการบันทึกลูกค้าด้วยเบอร์โทรนี้ไปแล้วค่ะ');history.back();</script>";
        exit();
    }

    mysqli_begin_transaction($conn);
    $allOk = true;

    if (!ensureCustomerChildTables($conn)) {
        $allOk = false;
    }

    if ($allOk) {
        $save = "INSERT INTO tb_customer
        (customer_code,customer_name,type_customer,preface_name,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,cus_fax,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,warranty,brun_no,h_ckk,rental_name,rental_emer,rental_address,rental_ampher,rental_province,rental_postcode,rental_emertel,rental_tel,patient_name,install_address,rental_contact,rental_contacttel,mode_name,email_cus,vip_ckk,credit_ckk)
        VALUES
        ('" . esc($conn, $customer_code) . "','" . esc($conn, $customer_name) . "','" . esc($conn, $type_customer) . "','" . esc($conn, $preface_name) . "','" . esc($conn, $cus_address) . "','" . esc($conn, $cus_ampher) . "','" . esc($conn, $cus_province) . "','" . esc($conn, $cus_postcode) . "','" . esc($conn, $cus_tel) . "','" . esc($conn, $cus_fax) . "','" . esc($conn, $primaryBillName) . "','" . esc($conn, $primaryBillAddress) . "','" . esc($conn, $primaryBillAmpher) . "','" . esc($conn, $primaryBillProvince) . "','" . esc($conn, $primaryBillPostcode) . "','" . esc($conn, $primaryBillTel) . "','" . esc($conn, $tax_id) . "','" . esc($conn, $delivery_name) . "','" . esc($conn, $del_address) . "','" . esc($conn, $del_ampher) . "','" . esc($conn, $del_province) . "','" . esc($conn, $del_postcode) . "','" . esc($conn, $del_tel) . "','" . esc($conn, $contact_name) . "','" . esc($conn, $warranty) . "','" . esc($conn, $brun_no) . "','" . esc($conn, $h_ckk) . "','" . esc($conn, $rental_name) . "','" . esc($conn, $rental_emer) . "','" . esc($conn, $rental_address) . "','" . esc($conn, $rental_ampher) . "','" . esc($conn, $rental_province) . "','" . esc($conn, $rental_postcode) . "','" . esc($conn, $rental_emertel) . "','" . esc($conn, $rental_tel) . "','" . esc($conn, $patient_name) . "','" . esc($conn, $install_address) . "','" . esc($conn, $rental_contact) . "','" . esc($conn, $rental_contacttel) . "','" . esc($conn, $mode_name) . "','" . esc($conn, $email_cus) . "','" . esc($conn, $vip_ckk) . "','" . esc($conn, $credit_ckk) . "')";

        $allOk = mysqli_query($conn, $save) ? true : false;
    }

    $customer_id = $allOk ? mysqli_insert_id($conn) : 0;

    if ($allOk && $customer_id > 0) {
        foreach ($sale_codes as $sale_code) {
            $sale_code = trim($sale_code);
            if ($sale_code === '') {
                continue;
            }

            $sql = "INSERT INTO tb_selected_sales (sale_code, id_customer, customer_name) VALUES ('" . esc($conn, $sale_code) . "', '" . esc($conn, $customer_id) . "', '" . esc($conn, $primaryBillName) . "')";
            if (!mysqli_query($conn, $sql)) {
                $allOk = false;
                break;
            }
        }
    }

    if ($allOk && $customer_id > 0) {
        $billingCount = max(
            count($billingNames),
            count($billingAddresses),
            count($billingProvinces),
            count($billingTaxIds),
            count($billingTels),
            count($billingEmails),
            count($billingBranchTypes),
            count($billingBranchNos)
        );

        for ($i = 0; $i < $billingCount; $i++) {
            $billingName = isset($billingNames[$i]) ? normalizeThaiName($billingNames[$i]) : '';
            $billingAddress = isset($billingAddresses[$i]) ? trim($billingAddresses[$i]) : '';
            $billingProvince = isset($billingProvinces[$i]) ? trim($billingProvinces[$i]) : '';

            if ($billingName === '' && $billingAddress === '' && $billingProvince === '') {
                continue;
            }

            $billingPreface = isset($billingPrefaces[$i]) ? trim($billingPrefaces[$i]) : '';
            $billingTaxId = isset($billingTaxIds[$i]) ? preg_replace('/[^0-9]/', '', $billingTaxIds[$i]) : '';
            $billingTel = isset($billingTels[$i]) ? preg_replace('/[^0-9]/', '', $billingTels[$i]) : '';
            $billingEmail = isset($billingEmails[$i]) ? trim($billingEmails[$i]) : '';
            $billingAmpher = isset($billingAmphers[$i]) ? trim($billingAmphers[$i]) : '';
            $billingPostcode = isset($billingPostcodes[$i]) ? preg_replace('/[^0-9]/', '', $billingPostcodes[$i]) : '';
            $billingBranchType = isset($billingBranchTypes[$i]) ? trim($billingBranchTypes[$i]) : '';
            $billingBranchNo = isset($billingBranchNos[$i]) ? preg_replace('/[^0-9]/', '', $billingBranchNos[$i]) : '';
            if ($billingBranchType === '1' && $billingBranchNo === '') {
                $billingBranchNo = '00000';
            }
            $isPrimary = ($i === 0) ? 1 : 0;
            $billingIndex = $i + 1;

            $billingInsert = "INSERT INTO tb_customer_billing_address
            (customer_id, billing_index, billing_preface_name, billing_name, billing_tax_id, billing_tel, billing_email, billing_address, billing_ampher, billing_province, billing_postcode, billing_branch_type, billing_branch_no, is_primary)
            VALUES
            ('" . esc($conn, $customer_id) . "', '" . esc($conn, $billingIndex) . "', '" . esc($conn, $billingPreface) . "', '" . esc($conn, $billingName) . "', '" . esc($conn, $billingTaxId) . "', '" . esc($conn, $billingTel) . "', '" . esc($conn, $billingEmail) . "', '" . esc($conn, $billingAddress) . "', '" . esc($conn, $billingAmpher) . "', '" . esc($conn, $billingProvince) . "', '" . esc($conn, $billingPostcode) . "', '" . esc($conn, $billingBranchType) . "', '" . esc($conn, $billingBranchNo) . "', '" . esc($conn, $isPrimary) . "')";

            if (!mysqli_query($conn, $billingInsert)) {
                $allOk = false;
                break;
            }
        }
    }

    if ($allOk && $customer_id > 0) {
        $shippingCount = max(
            count($shippingNames),
            count($shippingAddresses),
            count($shippingProvinces),
            count($shippingTels)
        );

        for ($i = 0; $i < $shippingCount; $i++) {
            $shippingName = isset($shippingNames[$i]) ? normalizeThaiName($shippingNames[$i]) : '';
            $shippingAddress = isset($shippingAddresses[$i]) ? trim($shippingAddresses[$i]) : '';
            $shippingProvince = isset($shippingProvinces[$i]) ? trim($shippingProvinces[$i]) : '';

            if ($shippingName === '' && $shippingAddress === '' && $shippingProvince === '') {
                continue;
            }

            $shippingPreface = isset($shippingPrefaces[$i]) ? trim($shippingPrefaces[$i]) : '';
            $shippingTel = isset($shippingTels[$i]) ? preg_replace('/[^0-9]/', '', $shippingTels[$i]) : '';
            $shippingAmpher = isset($shippingAmphers[$i]) ? trim($shippingAmphers[$i]) : '';
            $shippingPostcode = isset($shippingPostcodes[$i]) ? preg_replace('/[^0-9]/', '', $shippingPostcodes[$i]) : '';
            $isPrimary = ($i === 0) ? 1 : 0;
            $shippingIndex = $i + 1;

            $shippingInsert = "INSERT INTO tb_customer_shipping_address
            (customer_id, shipping_index, shipping_preface_name, shipping_name, shipping_tel, shipping_address, shipping_ampher, shipping_province, shipping_postcode, is_primary)
            VALUES
            ('" . esc($conn, $customer_id) . "', '" . esc($conn, $shippingIndex) . "', '" . esc($conn, $shippingPreface) . "', '" . esc($conn, $shippingName) . "', '" . esc($conn, $shippingTel) . "', '" . esc($conn, $shippingAddress) . "', '" . esc($conn, $shippingAmpher) . "', '" . esc($conn, $shippingProvince) . "', '" . esc($conn, $shippingPostcode) . "', '" . esc($conn, $isPrimary) . "')";

            if (!mysqli_query($conn, $shippingInsert)) {
                $allOk = false;
                break;
            }
        }
    }

    if ($allOk) {
        mysqli_commit($conn);
        echo "<script language=\"JavaScript\">";
        echo "window.location='customer_add.php?success=created'";
        echo "</script>";
        exit();
        echo "<script language=\"JavaScript\">";
        echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_customer.php'";
        echo "</script>";
    } else {
        mysqli_rollback($conn);
        $errorMessage = mysqli_error($conn);
        echo "<script language=\"JavaScript\">";
        echo "alert('ไม่สามารถบันทึกข้อมูลได้: " . addslashes($errorMessage) . "');history.back();";
        echo "</script>";
    }
}
?>
