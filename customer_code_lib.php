<?php
// รหัสลูกค้ารันต่อที่อยู่ออกบิล มี 2 ชุดเลขแยกกัน รูปแบบ prefix + ปี พ.ศ. 2 หลัก + เดือน 2 หลัก + เลขรัน 4 หลัก (เริ่มใหม่ทุกเดือน)
//   awl: PC..., บิล 1 = tb_customer.customer_code,  บิล 2+ = tb_customer_billing_address.billing_code
//   nbm: NC..., บิล 1 = tb_customer.customer_coden, บิล 2+ = tb_customer_billing_address.billing_coden
// ใช้ร่วมกันระหว่าง ajax_customer_run_code.php, add_customer1.php, edit_customer1.php และ create_cusno*.php

// ชื่อคอลัมน์มาจากตารางนี้เท่านั้น ต่อเข้า SQL ตรง ๆ ได้
function customer_code_config($type)
{
    static $types = array(
        'awl' => array(
            'prefix' => 'PC',
            'customer_column' => 'customer_code',
            'billing_column' => 'billing_code',
            'billing_after' => 'billing_index',
            'lock' => 'tb_customer_awl_code',
            'post_field' => 'billing_code',
            // ฟอร์มเก่าที่ไม่มี billing_code[] ส่ง customer_code มาเป็นรหัสบิล 1
            'legacy_post_field' => 'customer_code',
        ),
        'nbm' => array(
            'prefix' => 'NC',
            'customer_column' => 'customer_coden',
            'billing_column' => 'billing_coden',
            'billing_after' => 'billing_code',
            'lock' => 'tb_customer_nbm_code',
            'post_field' => 'billing_coden',
            // ฟอร์มเก่าไม่เคยส่ง NBM มา ใช้รหัสเดิมในฐานแทน
            'legacy_post_field' => null,
        ),
    );

    if (!isset($types[$type])) {
        trigger_error('Unknown customer code type: ' . $type, E_USER_ERROR);
    }
    return $types[$type];
}

function customer_code_prefix($type, $date = null)
{
    $config = customer_code_config($type);
    $now = new DateTime($date === null ? 'now' : $date, new DateTimeZone('Asia/Bangkok'));
    return $config['prefix'] . substr((string)((int)$now->format('Y') + 543), -2) . $now->format('m');
}

// เพิ่มคอลัมน์รหัสบิล 2+ ให้ฐานที่ยังไม่ได้รัน sql/customer_billing_code.sql
function customer_code_ensure_billing_column($conn, $type)
{
    static $ready = array();
    if (isset($ready[$type])) {
        return $ready[$type];
    }

    $config = customer_code_config($type);
    $table = mysqli_query($conn, "SHOW TABLES LIKE 'tb_customer_billing_address'");
    if (!$table || mysqli_num_rows($table) === 0) {
        return $ready[$type] = false;
    }

    $column = mysqli_query($conn, "SHOW COLUMNS FROM tb_customer_billing_address LIKE '" . $config['billing_column'] . "'");
    if ($column && mysqli_num_rows($column) > 0) {
        return $ready[$type] = true;
    }

    // billing_coden วางต่อจาก billing_code ต้องมีคอลัมน์นั้นก่อน
    if ($config['billing_after'] === 'billing_code' && !customer_code_ensure_billing_column($conn, 'awl')) {
        return $ready[$type] = false;
    }

    return $ready[$type] = (bool)mysqli_query($conn, "ALTER TABLE tb_customer_billing_address ADD COLUMN " . $config['billing_column'] . " VARCHAR(100) DEFAULT NULL AFTER " . $config['billing_after'] . ", ADD KEY idx_customer_" . $config['billing_column'] . " (" . $config['billing_column'] . ")");
}

// ล็อกกันสองคนรันพร้อมกันแล้วได้เลขเดียวกัน แยกล็อกต่อชุดเลข คืน lock ตอน shutdown เพราะหน้าที่ใช้มัก exit กลางทาง
function customer_code_acquire_lock($conn, $type)
{
    $config = customer_code_config($type);
    $row = mysqli_fetch_row(mysqli_query($conn, "SELECT GET_LOCK('" . $config['lock'] . "', 10)"));
    if (!$row || (int)$row[0] !== 1) {
        return false;
    }
    register_shutdown_function(function () use ($conn, $config) {
        @mysqli_query($conn, "SELECT RELEASE_LOCK('" . $config['lock'] . "')");
    });
    return true;
}

function customer_code_is_used($conn, $type, $code)
{
    $config = customer_code_config($type);
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM tb_customer WHERE TRIM(" . $config['customer_column'] . ") = ?");
    mysqli_stmt_bind_param($stmt, 's', $code);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $usedCount);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    if ((int)$usedCount > 0) {
        return true;
    }

    if (!customer_code_ensure_billing_column($conn, $type)) {
        return false;
    }
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM tb_customer_billing_address WHERE TRIM(" . $config['billing_column'] . ") = ?");
    mysqli_stmt_bind_param($stmt, 's', $code);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $usedCount);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return (int)$usedCount > 0;
}

function customer_code_max_running($conn, $sql, $prefix)
{
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $prefix);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $maxCode);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return ($maxCode !== null && $maxCode !== '') ? (int)substr($maxCode, -4) : 0;
}

// $exclude = รหัสที่ถูกจองไว้แล้วแต่ยังไม่ลงฐาน (เช่นการ์ดอื่นในฟอร์มเดียวกัน)
// ตอนบันทึกต้องถือ lock ก่อนเรียก คืน '' ถ้าเลขรันของเดือนเต็ม
function customer_code_next($conn, $type, $exclude = array(), $prefix = null)
{
    $config = customer_code_config($type);
    if ($prefix === null) {
        $prefix = customer_code_prefix($type);
    }

    // นับเฉพาะรหัสรูปแบบปัจจุบัน (ยาว 10 ตัว) กันรหัสเก่าเลขรัน 3 หลัก / มีช่องว่างต่อท้าย
    $column = $config['customer_column'];
    $running = customer_code_max_running($conn, "SELECT MAX(TRIM($column)) FROM tb_customer WHERE TRIM($column) LIKE CONCAT(?, '%') AND CHAR_LENGTH(TRIM($column)) = 10", $prefix);
    if (customer_code_ensure_billing_column($conn, $type)) {
        $column = $config['billing_column'];
        $running = max($running, customer_code_max_running($conn, "SELECT MAX(TRIM($column)) FROM tb_customer_billing_address WHERE TRIM($column) LIKE CONCAT(?, '%') AND CHAR_LENGTH(TRIM($column)) = 10", $prefix));
    }

    for ($running++; $running <= 9999; $running++) {
        $code = $prefix . str_pad((string)$running, 4, '0', STR_PAD_LEFT);
        if (!in_array($code, $exclude, true) && !customer_code_is_used($conn, $type, $code)) {
            return $code;
        }
    }
    return '';
}

// รหัสที่ลูกค้าคนนี้ถืออยู่ในฐาน เรียงตามลำดับบิล ([0] = บิล 1 จาก tb_customer, [n] = billing_index n+1)
function customer_code_saved_by_index($conn, $type, $customerId)
{
    $saved = array();
    if ($customerId <= 0) {
        return $saved;
    }

    $config = customer_code_config($type);
    $stmt = mysqli_prepare($conn, "SELECT TRIM(" . $config['customer_column'] . ") FROM tb_customer WHERE customer_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $customerId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $code);
    if (mysqli_stmt_fetch($stmt)) {
        $saved[0] = (string)$code;
    }
    mysqli_stmt_close($stmt);

    if (customer_code_ensure_billing_column($conn, $type)) {
        $stmt = mysqli_prepare($conn, "SELECT billing_index, TRIM(" . $config['billing_column'] . ") FROM tb_customer_billing_address WHERE customer_id = ? AND billing_index > 1");
        mysqli_stmt_bind_param($stmt, 'i', $customerId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $billingIndex, $code);
        while (mysqli_stmt_fetch($stmt)) {
            $saved[(int)$billingIndex - 1] = (string)$code;
        }
        mysqli_stmt_close($stmt);
    }

    return $saved;
}

// รหัสที่ลูกค้าคนนี้ถืออยู่แล้วในฐาน ใช้ต่อได้แม้เป็นเดือนเก่า/รูปแบบเก่า
function customer_code_owned_by_customer($conn, $type, $customerId)
{
    return array_values(array_filter(customer_code_saved_by_index($conn, $type, $customerId), function ($code) {
        return $code !== '';
    }));
}

// ตรวจรหัสที่ส่งมาจากฟอร์ม (ตำแหน่งเดียวกับ billing_*[]) ต้องถือ lock ก่อนเรียก
// เก็บไว้ถ้าเป็นของลูกค้าคนนี้อยู่แล้ว หรือเป็นเดือนปัจจุบันและยังไม่มีใครใช้ ไม่งั้นรันเลขใหม่ ช่องว่างคงว่างไว้
function customer_code_resolve_codes($conn, $type, $codes, $customerId)
{
    $owned = customer_code_owned_by_customer($conn, $type, $customerId);
    $pattern = '/^' . customer_code_prefix($type) . '\d{4}$/';
    $assigned = array();
    $resolved = array();

    foreach ($codes as $index => $code) {
        $code = trim((string)$code);
        if ($code !== '' && !in_array($code, $assigned, true)) {
            $keep = in_array($code, $owned, true)
                || (preg_match($pattern, $code) === 1 && !customer_code_is_used($conn, $type, $code));
            if (!$keep) {
                $code = customer_code_next($conn, $type, $assigned);
            }
        } elseif ($code !== '') {
            $code = customer_code_next($conn, $type, $assigned);
        }

        if ($code !== '') {
            $assigned[] = $code;
        }
        $resolved[$index] = $code;
    }

    return $resolved;
}

// อ่าน billing_code[] / billing_coden[] จากฟอร์ม customer_add.php แล้วตรวจ/จองเลข ใช้ใน add_customer1.php และ edit_customer1.php
// เรียกก่อน mysqli_begin_transaction (ALTER คอลัมน์ commit ทรานแซกชันเอง) คืน false ถ้าไม่ได้ lock
function customer_code_resolve_posted_codes($conn, $type, $customerId)
{
    $config = customer_code_config($type);
    customer_code_ensure_billing_column($conn, $type);

    if (isset($_POST[$config['post_field']]) && is_array($_POST[$config['post_field']])) {
        $codes = array_values($_POST[$config['post_field']]);
    } elseif ($config['legacy_post_field'] !== null) {
        $codes = array(isset($_POST[$config['legacy_post_field']]) ? $_POST[$config['legacy_post_field']] : '');
    } else {
        // ฟอร์มเก่าไม่รู้จักชุดเลขนี้ คงรหัสเดิมในฐานไว้ตามลำดับบิล
        return customer_code_saved_by_index($conn, $type, $customerId);
    }

    $hasCode = false;
    foreach ($codes as $code) {
        if (trim((string)$code) !== '') {
            $hasCode = true;
            break;
        }
    }
    if (!$hasCode) {
        return array_map(function () {
            return '';
        }, $codes);
    }

    // ถือ lock จนจบ request ให้ครอบถึงตอน INSERT/UPDATE
    if (!customer_code_acquire_lock($conn, $type)) {
        return false;
    }
    return customer_code_resolve_codes($conn, $type, $codes, $customerId);
}
