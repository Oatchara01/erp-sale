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
    $customer_id = (int)postValue("customer_id", 0);
    $customer_code = postValue("customer_code");
    $customer_coden = postValue("customer_coden");
    $preface_name = postValue("preface_name");
    $customer_name1 = normalizeThaiName(postValue("customer_name"));
    $customer_name = trim($preface_name . " " . $customer_name1);
    $type_customer = postValue("type_customer");
    $cus_address = postValue("cus_address");
    $cus_ampher = postValue("cus_ampher");
    $cus_province = postValue("cus_province");
    $cus_postcode = postValue("cus_postcode");
    $cus_tel = preg_replace('/[^0-9]/', '', postValue("cus_tel"));
    $cus_fax = postValue("cus_fax");
    $mode_name = postValue("h_mode_name");
    $contact_name = normalizeThaiName(postValue("contact_name"));
    $warranty = postValue("warranty");
    $h_ckk = postValue("h_ckk");
    $brun_no = preg_replace('/[^0-9]/', '', postValue("brun_no"));
    $close_ckk = postValue("close_ckk");
    $remark_cus = postValue("remark_cus");
    $email_cus = postValue("email_cus");
    $vip_ckk = isset($_POST["vip_ckk"]) ? "1" : "0";
    $credit_ckk = postValue("credit_ckk");
    $credit_thb = str_replace(',', '', postValue("credit_thb"));

    $rental_name = postValue("rental_name");
    $rental_tel = postValue("rental_tel");
    $rental_address = postValue("rental_address");
    $rental_ampher = postValue("rental_ampher");
    $rental_province = postValue("rental_province");
    $rental_postcode = postValue("rental_postcode");
    $rental_emer = postValue("rental_emer");
    $rental_emertel = postValue("rental_emertel");
    $patient_name = postValue("patient_name");
    $install_address = postValue("install_address");
    $rental_contacttel = postValue("rental_contacttel");
    $rental_contact = postValue("rental_contact");

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

    $delivery_name = normalizeThaiName(postValue("delivery_name"));
    $del_address = postValue("del_address");
    $del_ampher = postValue("del_ampher");
    $del_province = postValue("del_province");
    $del_postcode = postValue("del_postcode");
    $del_tel = preg_replace('/[^0-9]/', '', postValue("del_tel"));

    $selected_sales = isset($_POST["sale_code"]) && is_array($_POST["sale_code"]) ? $_POST["sale_code"] : array();

    if ($customer_id <= 0) {
        echo "<script language=\"JavaScript\">";
        echo "alert('ไม่พบรหัสลูกค้า');history.back();";
        echo "</script>";
        exit();
    }

    $edit_date = date('Y-m-d H:i:s');
    $name = isset($_SESSION["name"]) ? $_SESSION["name"] : '';
    $surname = isset($_SESSION["surname"]) ? $_SESSION["surname"] : '';
    $edit_name = trim($name . " " . $surname);

    mysqli_begin_transaction($conn);
    $allOk = ensureCustomerChildTables($conn);

    if ($allOk) {
        $save = "UPDATE tb_customer SET
            customer_code='" . esc($conn, $customer_code) . "',
            customer_name='" . esc($conn, $customer_name) . "',
            type_customer='" . esc($conn, $type_customer) . "',
            preface_name='" . esc($conn, $preface_name) . "',
            cus_address='" . esc($conn, $cus_address) . "',
            cus_ampher='" . esc($conn, $cus_ampher) . "',
            cus_province='" . esc($conn, $cus_province) . "',
            cus_postcode='" . esc($conn, $cus_postcode) . "',
            cus_tel='" . esc($conn, $cus_tel) . "',
            cus_fax='" . esc($conn, $cus_fax) . "',
            bill_name='" . esc($conn, $primaryBillName) . "',
            bill_address='" . esc($conn, $primaryBillAddress) . "',
            bill_ampher='" . esc($conn, $primaryBillAmpher) . "',
            billl_province='" . esc($conn, $primaryBillProvince) . "',
            bill_postcode='" . esc($conn, $primaryBillPostcode) . "',
            bill_tel='" . esc($conn, $primaryBillTel) . "',
            tax_id='" . esc($conn, $tax_id) . "',
            delivery_name='" . esc($conn, $delivery_name) . "',
            del_address='" . esc($conn, $del_address) . "',
            del_ampher='" . esc($conn, $del_ampher) . "',
            del_province='" . esc($conn, $del_province) . "',
            del_postcode='" . esc($conn, $del_postcode) . "',
            del_tel='" . esc($conn, $del_tel) . "',
            contact_name='" . esc($conn, $contact_name) . "',
            customer_coden='" . esc($conn, $customer_coden) . "',
            warranty='" . esc($conn, $warranty) . "',
            brun_no='" . esc($conn, $brun_no) . "',
            h_ckk='" . esc($conn, $h_ckk) . "',
            close_ckk='" . esc($conn, $close_ckk) . "',
            remark_cus='" . esc($conn, $remark_cus) . "',
            rental_name='" . esc($conn, $rental_name) . "',
            rental_address='" . esc($conn, $rental_address) . "',
            rental_ampher='" . esc($conn, $rental_ampher) . "',
            rental_province='" . esc($conn, $rental_province) . "',
            rental_postcode='" . esc($conn, $rental_postcode) . "',
            rental_emer='" . esc($conn, $rental_emer) . "',
            rental_emertel='" . esc($conn, $rental_emertel) . "',
            patient_name='" . esc($conn, $patient_name) . "',
            install_address='" . esc($conn, $install_address) . "',
            rental_tel='" . esc($conn, $rental_tel) . "',
            rental_contacttel='" . esc($conn, $rental_contacttel) . "',
            rental_contact='" . esc($conn, $rental_contact) . "',
            mode_name='" . esc($conn, $mode_name) . "',
            edit_date='" . esc($conn, $edit_date) . "',
            edit_name='" . esc($conn, $edit_name) . "',
            email_cus='" . esc($conn, $email_cus) . "',
            vip_ckk='" . esc($conn, $vip_ckk) . "'
            WHERE customer_id='" . esc($conn, $customer_id) . "'";

        $allOk = mysqli_query($conn, $save) ? true : false;
    }

    if ($allOk && in_array($name, array('นงลักษณ์', 'อัจฉรา', 'สุดารัตน์', 'รุจิรา', 'พัชร์ชนัญ'))) {
        $saveCredit = "UPDATE tb_customer SET
            credit_ckk='" . esc($conn, $credit_ckk) . "',
            credit_thb='" . esc($conn, $credit_thb) . "'
            WHERE customer_id='" . esc($conn, $customer_id) . "'";
        $allOk = mysqli_query($conn, $saveCredit) ? true : false;
    }

    if ($allOk) {
        $deleteSales = "DELETE FROM tb_selected_sales WHERE id_customer='" . esc($conn, $customer_id) . "'";
        $allOk = mysqli_query($conn, $deleteSales) ? true : false;
    }

    if ($allOk) {
        foreach ($selected_sales as $sale_code) {
            $sale_code = trim($sale_code);
            if ($sale_code === '') {
                continue;
            }

            $insertSale = "INSERT INTO tb_selected_sales (id_customer, sale_code, customer_name)
                VALUES ('" . esc($conn, $customer_id) . "', '" . esc($conn, $sale_code) . "', '" . esc($conn, $primaryBillName) . "')";
            if (!mysqli_query($conn, $insertSale)) {
                $allOk = false;
                break;
            }
        }
    }

    if ($allOk) {
        $allOk = mysqli_query($conn, "DELETE FROM tb_customer_billing_address WHERE customer_id='" . esc($conn, $customer_id) . "'") ? true : false;
    }

    if ($allOk) {
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

    if ($allOk) {
        $allOk = mysqli_query($conn, "DELETE FROM tb_customer_shipping_address WHERE customer_id='" . esc($conn, $customer_id) . "'") ? true : false;
    }

    if ($allOk) {
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
        $save2 = "UPDATE tb__buypro SET mode_cus='" . esc($conn, $mode_name) . "' WHERE bill_id='" . esc($conn, $customer_id) . "'";
        $save3 = "UPDATE tb__discash SET mode_cus='" . esc($conn, $mode_name) . "' WHERE bill_id='" . esc($conn, $customer_id) . "'";
        $save4 = "UPDATE hos__so SET mode_cus='" . esc($conn, $mode_name) . "' WHERE bill_id='" . esc($conn, $customer_id) . "'";
        $save5 = "UPDATE tb_credit_note SET mode_cus='" . esc($conn, $mode_name) . "' WHERE bill_id='" . esc($conn, $customer_id) . "'";

        $allOk = mysqli_query($conn, $save2) ? true : false;
        if ($allOk) {
            $allOk = mysqli_query($conn, $save3) ? true : false;
        }
        if ($allOk) {
            $allOk = mysqli_query($conn, $save4) ? true : false;
        }
        if ($allOk) {
            $allOk = mysqli_query($conn, $save5) ? true : false;
        }
    }

    if ($allOk) {
        mysqli_commit($conn);
        echo "<script language=\"JavaScript\">";
        echo "window.location='customer_add.php?customer_id=" . (int)$customer_id . "&success=updated'";
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
