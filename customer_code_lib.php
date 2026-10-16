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

/* =========================================================
   ใช้รหัสเดิมตาม customer_id + เลขผู้เสียภาษี
   ใช้ใน billing_info_add.php, customer_add.php, add_customer1.php, edit_customer1.php, ajax_customer_billing_codes.php
   - หาเฉพาะในลูกค้ารายเดียว ไม่ค้นข้ามลูกค้าแม้ tax ตรงกัน
   - tax ต้องเป็นตัวเลข 13 หลักที่ไม่ใช่ศูนย์ 13 ตัว (ศูนย์ 13 ตัว = ไม่มีข้อมูล ไม่ใช้ร่วมกับบิลอื่น)
   - บิลหลัก (แถวแรกตาม billing_index, id) ถือรหัสใน tb_customer บิลรองถือรหัสในแถวบิล
   - AWL/NBM เป็นคู่จากแหล่งเดียวกันเสมอ ไม่ประกอบ AWL แถวหนึ่งกับ NBM อีกแถว
   - การ์ดที่ยังไม่บันทึกและใช้ tax เดียวกันในฟอร์มเดียวกัน ได้รหัสชุดเดียวกัน (resolve หนึ่งครั้งต่อกลุ่ม)
========================================================= */

function customer_code_normalize_tax($tax)
{
    return preg_replace('/\D+/', '', (string)$tax);
}

function customer_code_tax_reusable($tax)
{
    $tax = customer_code_normalize_tax($tax);
    return strlen($tax) === 13 && $tax !== '0000000000000';
}

function customer_code_pair($awl = '', $nbm = '')
{
    return array('awl' => trim((string)$awl), 'nbm' => trim((string)$nbm));
}

function customer_code_pair_empty($pair)
{
    return $pair['awl'] === '' && $pair['nbm'] === '';
}

function customer_code_pair_full($pair)
{
    return $pair['awl'] !== '' && $pair['nbm'] !== '';
}

function customer_code_pair_key($pair)
{
    return $pair['awl'] . '|' . $pair['nbm'];
}

// ล็อกทั้งสองชุดเลขตามลำดับ AWL ก่อน NBM ทุก path ที่บันทึกบิล กัน deadlock ระหว่างคำขอ
function customer_code_acquire_locks($conn)
{
    if (!customer_code_acquire_lock($conn, 'awl')) {
        return false;
    }
    if (!customer_code_acquire_lock($conn, 'nbm')) {
        customer_code_release_locks($conn);
        return false;
    }
    return true;
}

// ปล่อยหลัง commit/rollback ทันที (shutdown ของ customer_code_acquire_lock เป็นแค่ตัวกันพลาด)
function customer_code_release_locks($conn)
{
    foreach (array('nbm', 'awl') as $type) {
        $config = customer_code_config($type);
        try {
            mysqli_query($conn, "SELECT RELEASE_LOCK('" . $config['lock'] . "')");
        } catch (mysqli_sql_exception $e) {
        }
    }
}

function customer_code_empty_customer()
{
    return array(
        'customer_id' => 0,
        'row' => null,
        'tax' => '',
        'codes' => customer_code_pair(),
        'billings' => array(),
        'sources' => array(),
    );
}

function customer_code_join_address($parts)
{
    $parts = array_filter(array_map(function ($part) {
        return trim((string)$part);
    }, $parts), function ($part) {
        return $part !== '';
    });
    return implode(' ', $parts);
}

// อ่านลูกค้า + แถวบิลของลูกค้ารายเดียว (อ่านอย่างเดียว ไม่ ALTER/CREATE)
// $forUpdate ใช้ในทรานแซกชันตอนบันทึก ล็อกแถว parent และแถวบิลจนกว่าจะ commit
// คืน null ถ้าไม่พบลูกค้า query ผิดพลาดโยน mysqli_sql_exception
function customer_code_load_customer($conn, $customerId, $forUpdate = false)
{
    $customerId = (int)$customerId;
    if ($customerId <= 0) {
        return null;
    }
    $lockSql = $forUpdate ? ' FOR UPDATE' : '';

    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_customer WHERE customer_id = ?" . $lockSql);
    mysqli_stmt_bind_param($stmt, 'i', $customerId);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    if (!$row) {
        return null;
    }

    $customer = customer_code_empty_customer();
    $customer['customer_id'] = $customerId;
    $customer['row'] = $row;
    $customer['tax'] = customer_code_normalize_tax($row['tax_id'] ?? '');
    $customer['codes'] = customer_code_pair($row['customer_code'] ?? '', $row['customer_coden'] ?? '');

    $table = mysqli_query($conn, "SHOW TABLES LIKE 'tb_customer_billing_address'");
    if ($table && mysqli_num_rows($table) > 0) {
        $stmt = mysqli_prepare($conn, "SELECT * FROM tb_customer_billing_address WHERE customer_id = ? ORDER BY billing_index ASC, id ASC" . $lockSql);
        mysqli_stmt_bind_param($stmt, 'i', $customerId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $position = 0;
        while ($billing = mysqli_fetch_assoc($result)) {
            $billingId = (int)$billing['id'];
            $isPrimary = $position === 0;
            $codes = $isPrimary ? $customer['codes'] : customer_code_pair($billing['billing_code'] ?? '', $billing['billing_coden'] ?? '');
            $customer['billings'][$billingId] = array(
                'id' => $billingId,
                'is_primary' => $isPrimary,
                'tax' => customer_code_normalize_tax($billing['billing_tax_id'] ?? ''),
                'codes' => $codes,
                'row' => $billing,
            );
            $customer['sources'][] = array(
                'source_key' => 'billing:' . $billingId,
                'billing_id' => $billingId,
                'tax' => customer_code_normalize_tax($billing['billing_tax_id'] ?? ''),
                'codes' => $codes,
                'billing_name' => trim((string)($billing['billing_name'] ?? '')),
                'branch_no' => trim((string)($billing['billing_branch_no'] ?? '')),
                'address' => customer_code_join_address(array($billing['billing_address'] ?? '', $billing['billing_tumbon'] ?? '', $billing['billing_ampher'] ?? '', $billing['billing_province'] ?? '', $billing['billing_postcode'] ?? '')),
            );
            $position++;
        }
        mysqli_stmt_close($stmt);
    }

    // ยังไม่มีแถวบิล: ข้อมูลออกบิลบน tb_customer เป็นแหล่งเดียว
    if (empty($customer['billings'])) {
        $customer['sources'][] = array(
            'source_key' => 'customer:' . $customerId,
            'billing_id' => 0,
            'tax' => $customer['tax'],
            'codes' => $customer['codes'],
            'billing_name' => trim((string)($row['bill_name'] ?? '')),
            'branch_no' => trim((string)($row['brun_no'] ?? '')),
            'address' => customer_code_join_address(array($row['bill_address'] ?? '', $row['bill_ampher'] ?? '', $row['billl_province'] ?? '', $row['bill_postcode'] ?? '')),
        );
    }

    return $customer;
}

function customer_code_candidate_view($source)
{
    return array(
        'source_key' => $source['source_key'],
        'billing_id' => (int)$source['billing_id'],
        'billing_name' => $source['billing_name'],
        'branch_no' => $source['branch_no'],
        'address' => $source['address'],
        'awl' => $source['codes']['awl'],
        'nbm' => $source['codes']['nbm'],
    );
}

// หาคู่รหัสเดิมของ customer + tax ที่ใช้ได้
// $base = รหัสที่บิลถืออยู่แล้ว (แก้บิลเดิมโดย tax ไม่เปลี่ยน) แหล่งต้องตรงทุกช่องที่ base มี และต้องเติมช่องว่างได้อย่างน้อยหนึ่งช่อง
// $excludeKeys = แหล่งของบิลตัวเอง
// matches = ทุกแหล่งที่ใช้ได้ (ใช้ตรวจ source_key ที่ส่งมา), candidates = คู่รหัสไม่ซ้ำสำหรับแสดงให้เลือก
function customer_code_lookup($customer, $tax, $base = null, $excludeKeys = array())
{
    $tax = customer_code_normalize_tax($tax);
    $base = $base === null ? customer_code_pair() : $base;
    $result = array('status' => 'not_found', 'codes' => null, 'candidates' => array(), 'matches' => array());
    if (!customer_code_tax_reusable($tax)) {
        $result['status'] = 'excluded';
        return $result;
    }

    $usable = array();
    foreach ($customer['sources'] as $source) {
        if ($source['tax'] !== $tax || in_array($source['source_key'], $excludeKeys, true) || customer_code_pair_empty($source['codes'])) {
            continue;
        }
        $compatible = true;
        $addsCode = false;
        foreach (array('awl', 'nbm') as $type) {
            if ($base[$type] !== '') {
                $compatible = $compatible && $source['codes'][$type] === $base[$type];
            } elseif ($source['codes'][$type] !== '') {
                $addsCode = true;
            }
        }
        if ($compatible && $addsCode) {
            $usable[] = $source;
        }
    }

    // คู่ที่ขาดบางช่องแต่ช่องที่มีตรงกับคู่ที่ครบกว่า (เช่น AWL อย่างเดียว กับ AWL+NBM ที่ Run เพิ่มทีหลัง) ไม่นับเป็นอีกชุด
    // ใช้คู่ที่ครบกว่าจากแถวเดียว ไม่ประกอบช่องข้ามแถว
    $seenPairs = array();
    foreach ($usable as $source) {
        foreach ($usable as $other) {
            $dominated = customer_code_pair_key($other['codes']) !== customer_code_pair_key($source['codes']);
            foreach (array('awl', 'nbm') as $type) {
                $dominated = $dominated && ($source['codes'][$type] === '' || $source['codes'][$type] === $other['codes'][$type]);
            }
            if ($dominated) {
                continue 2;
            }
        }
        $result['matches'][$source['source_key']] = $source;
        $pairKey = customer_code_pair_key($source['codes']);
        if (!isset($seenPairs[$pairKey])) {
            $seenPairs[$pairKey] = true;
            $result['candidates'][] = customer_code_candidate_view($source);
        }
    }

    if (count($result['candidates']) === 1) {
        $result['status'] = 'matched';
        $result['codes'] = customer_code_pair($result['candidates'][0]['awl'], $result['candidates'][0]['nbm']);
    } elseif (count($result['candidates']) > 1) {
        $result['status'] = 'conflict';
    }
    return $result;
}

// รหัสที่การ์ดถืออยู่แล้วในฐาน: แถวบิลเดิมที่ tax ไม่เปลี่ยน
// หรือรหัสบน tb_customer ของลูกค้าที่ยังไม่มีแถวบิล เมื่อการ์ดอ้าง customer:<id> และ tax ตรงกับ tax_id ของลูกค้า
// $card ต้องมี record_id, source_key, tax (normalize แล้ว)
function customer_code_card_base($customer, $card)
{
    $result = array('codes' => customer_code_pair(), 'exclude' => array(), 'claims_customer' => false, 'saved_tax' => null, 'saved' => customer_code_pair(), 'saved_source' => '');
    $customerId = (int)$customer['customer_id'];

    if ((int)$card['record_id'] > 0) {
        $billing = $customer['billings'][(int)$card['record_id']] ?? null;
        if ($billing) {
            $result['saved_tax'] = $billing['tax'];
            $result['saved'] = $billing['codes'];
            $result['exclude'][] = 'billing:' . $billing['id'];
            if ($billing['tax'] === $card['tax']) {
                $result['codes'] = $billing['codes'];
            }
        }
    } elseif ($customerId > 0 && empty($customer['billings']) && $card['source_key'] === 'customer:' . $customerId) {
        $result['saved_tax'] = $customer['tax'];
        $result['saved'] = $customer['codes'];
        $result['saved_source'] = $card['source_key'];
        if ($customer['tax'] === $card['tax']) {
            $result['codes'] = $customer['codes'];
            $result['exclude'][] = $card['source_key'];
            $result['claims_customer'] = true;
        }
    }

    return $result;
}

// จัดกลุ่มการ์ดที่จะบันทึก (ไม่แตะฐาน) แล้วบอกว่าแต่ละกลุ่มใช้คู่รหัสเดิมคู่ไหน และรหัส preview ที่ต้อง resolve
// $cards = array of array(key, number, record_id, source_key, tax, awl, nbm) ตามลำดับที่จะบันทึก (กรองการ์ดว่างแล้ว)
//   source_key: billing:<id> / customer:<id> = เลือกคู่รหัสเดิม, form:<key> = ใช้รหัสร่วมกับการ์ดนั้นในฟอร์ม, '' = ไม่ได้เลือก
// กลุ่ม: db:<tax>:<awl|nbm> = คู่รหัสเดิมเดียวกัน, pv:<tax> = tax เดียวกันที่ยังไม่มีรหัสในฐาน, card:<key> = tax ที่ไม่ใช้ร่วมกัน (ศูนย์/ไม่ครบ)
function customer_code_plan_billing_cards($customer, $cards)
{
    $customerId = (int)$customer['customer_id'];
    $fail = function ($card, $message) use ($cards) {
        $prefix = count($cards) > 1 ? 'ที่อยู่ออกบิล ' . (int)$card['number'] . ': ' : '';
        return array('ok' => false, 'message' => $prefix . $message);
    };
    $staleMessage = 'รหัสลูกค้าที่แสดงไม่ตรงกับข้อมูลล่าสุด กรุณาตรวจสอบรหัสลูกค้าอีกครั้งก่อนบันทึก';

    $keyIndex = array();
    $usedRecords = array();
    foreach ($cards as $index => $card) {
        if (preg_match('/^[A-Za-z0-9_-]{1,64}$/', $card['key']) !== 1 || isset($keyIndex[$card['key']])) {
            return $fail($card, 'ข้อมูลการ์ดออกบิลไม่ถูกต้อง กรุณาโหลดหน้าใหม่');
        }
        $keyIndex[$card['key']] = $index;
        $recordId = (int)$card['record_id'];
        if ($recordId !== 0 && ($recordId < 0 || !isset($customer['billings'][$recordId]) || isset($usedRecords[$recordId]))) {
            return $fail($card, 'ข้อมูลออกบิลไม่ตรงกับลูกค้านี้ กรุณาโหลดหน้าใหม่');
        }
        $usedRecords[$recordId] = true;
    }

    $plan = array('ok' => true, 'cards' => array(), 'subs' => array());
    $formRefs = array();
    $customerClaimed = false;

    foreach ($cards as $index => $card) {
        $base = customer_code_card_base($customer, $card);
        $source = $card['source_key'];
        $posted = customer_code_pair($card['awl'], $card['nbm']);
        if ($base['claims_customer']) {
            // tax ที่ไม่ใช้ร่วมกันให้การ์ดเดียวถือรหัสเดิมบน tb_customer
            if ($customerClaimed && !customer_code_tax_reusable($card['tax'])) {
                return $fail($card, 'ข้อมูลการ์ดออกบิลไม่ถูกต้อง กรุณาโหลดหน้าใหม่');
            }
            $customerClaimed = true;
            $source = '';
        }

        if (!customer_code_tax_reusable($card['tax'])) {
            if ($source !== '') {
                return $fail($card, $staleMessage);
            }
            // ศูนย์ 13 ตัว/ไม่ครบ: ไม่ใช้ร่วมกับบิลอื่น รหัสเดิมของบิลนี้คงไว้ เว้นแต่ผู้ใช้ Run ทับ (พฤติกรรมเดิม)
            $fixed = customer_code_pair();
            $previews = customer_code_pair();
            foreach (array('awl', 'nbm') as $type) {
                if ($base['codes'][$type] !== '' && ($posted[$type] === '' || $posted[$type] === $base['codes'][$type])) {
                    $fixed[$type] = $base['codes'][$type];
                } else {
                    $previews[$type] = $posted[$type];
                }
            }
            $sub = 'card:' . $card['key'];
            $plan['subs'][$sub] = array('fixed' => $fixed, 'previews' => $previews, 'members' => array($index));
            $plan['cards'][$index] = $sub;
            continue;
        }

        if (strpos($source, 'form:') === 0) {
            $formRefs[$index] = substr($source, 5);
            continue;
        }

        $lookup = customer_code_lookup($customer, $card['tax'], $base['codes'], $base['exclude']);
        $pair = $base['codes'];
        if (customer_code_pair_full($base['codes'])) {
            // ถือรหัสครบแล้ว ไม่ต้องเลือกแหล่ง
        } elseif ($source !== '') {
            if (!isset($lookup['matches'][$source])) {
                return $fail($card, $staleMessage);
            }
            $pair = $lookup['matches'][$source]['codes'];
            foreach (array('awl', 'nbm') as $type) {
                if ($base['codes'][$type] === '' && $pair[$type] !== '' && $posted[$type] !== $pair[$type]) {
                    return $fail($card, $staleMessage);
                }
            }
        } elseif ($lookup['status'] === 'matched') {
            // ไม่มีแหล่งที่เลือกแต่ตอนนี้มีคู่เดิมคู่เดียว (เช่นคำขออื่นเพิ่งบันทึก) ใช้คู่เดิมแทน preview
            $pair = $lookup['codes'];
        } elseif ($lookup['status'] === 'conflict') {
            return $fail($card, 'พบรหัสลูกค้าหลายชุดของเลขผู้เสียภาษีนี้ กรุณาเลือกรหัสลูกค้าก่อนบันทึก');
        }

        $sub = customer_code_pair_empty($pair) ? 'pv:' . $card['tax'] : 'db:' . $card['tax'] . ':' . customer_code_pair_key($pair);
        if (!isset($plan['subs'][$sub])) {
            $plan['subs'][$sub] = array('fixed' => $pair, 'previews' => null, 'members' => array());
        }
        $plan['subs'][$sub]['members'][] = $index;
        $plan['cards'][$index] = $sub;
    }

    // form:<key> ต้องชี้การ์ดที่มีอยู่จริง tax เดียวกัน แล้วเข้ากลุ่มเดียวกับการ์ดนั้น
    foreach ($formRefs as $index => $targetKey) {
        $card = $cards[$index];
        $visited = array($index => true);
        $target = isset($keyIndex[$targetKey]) ? $keyIndex[$targetKey] : null;
        while ($target !== null && isset($formRefs[$target]) && !isset($visited[$target])) {
            $visited[$target] = true;
            $target = isset($keyIndex[$formRefs[$target]]) ? $keyIndex[$formRefs[$target]] : null;
        }
        if ($target === null || isset($visited[$target]) || $cards[$target]['tax'] !== $card['tax'] || !isset($plan['cards'][$target]) || strpos($plan['cards'][$target], 'card:') === 0) {
            return $fail($card, 'แหล่งรหัสลูกค้าในฟอร์มไม่ถูกต้อง กรุณาตรวจสอบรหัสลูกค้าอีกครั้ง');
        }
        $sub = $plan['cards'][$target];
        $base = customer_code_card_base($customer, $card);
        $posted = customer_code_pair($card['awl'], $card['nbm']);
        foreach (array('awl', 'nbm') as $type) {
            $fixed = $plan['subs'][$sub]['fixed'][$type];
            if ($base['codes'][$type] !== '' && $base['codes'][$type] !== $fixed) {
                return $fail($card, 'แหล่งรหัสลูกค้าในฟอร์มไม่ถูกต้อง กรุณาตรวจสอบรหัสลูกค้าอีกครั้ง');
            }
            if ($base['codes'][$type] === '' && $fixed !== '' && $posted[$type] !== $fixed) {
                return $fail($card, $staleMessage);
            }
        }
        $plan['subs'][$sub]['members'][] = $index;
        $plan['cards'][$index] = $sub;
    }

    // ช่องที่กลุ่มยังไม่มีรหัสเดิม: ทุกการ์ดในกลุ่มต้องส่ง preview เดียวกัน (หรือว่าง) แล้ว resolve ครั้งเดียว
    foreach ($plan['subs'] as $sub => $group) {
        if ($group['previews'] !== null) {
            continue;
        }
        $previews = customer_code_pair();
        foreach (array('awl', 'nbm') as $type) {
            if ($group['fixed'][$type] !== '') {
                continue;
            }
            $values = array();
            foreach ($group['members'] as $index) {
                $value = trim((string)$cards[$index][$type]);
                if ($value !== '') {
                    $values[$value] = true;
                }
            }
            if (count($values) > 1) {
                sort($group['members']);
                return $fail($cards[$group['members'][0]], 'การ์ดที่ใช้เลขผู้เสียภาษีเดียวกันมีรหัสลูกค้า ' . strtoupper($type) . ' ไม่ตรงกัน กรุณาตรวจสอบรหัสลูกค้าอีกครั้ง');
            }
            $previews[$type] = count($values) === 1 ? (string)key($values) : '';
        }
        $plan['subs'][$sub]['previews'] = $previews;
    }

    ksort($plan['cards']);
    return $plan;
}

// preview ที่ Run ไว้ในหน้า: ใช้ต่อถ้าเป็นเลขเดือนนี้และยังไม่มีใครใช้ ไม่งั้นรันใหม่ ต้องถือ lock ก่อนเรียก
function customer_code_resolve_preview($conn, $type, $code, $exclude)
{
    if (preg_match('/^' . customer_code_prefix($type) . '\d{4}$/', $code) === 1 && !in_array($code, $exclude, true) && !customer_code_is_used($conn, $type, $code)) {
        return $code;
    }
    return customer_code_next($conn, $type, $exclude);
}

// ตัดสินรหัส AWL/NBM ของการ์ดที่จะบันทึกทั้งชุด คืน array('ok' => true, 'codes' => array(ลำดับการ์ด => pair))
// ต้องเตรียมคอลัมน์ (customer_code_ensure_billing_column) ก่อนเริ่มทรานแซกชัน, ถือ customer_code_acquire_locks
// และอ่าน $customer ด้วย customer_code_load_customer(..., true) ในทรานแซกชันเดียวกับการเขียน (โหมดสร้าง = customer_code_empty_customer())
function customer_code_resolve_billing_cards($conn, $customer, $cards)
{
    $plan = customer_code_plan_billing_cards($customer, $cards);
    if (!$plan['ok']) {
        return $plan;
    }

    $assigned = array('awl' => array(), 'nbm' => array());
    foreach ($plan['subs'] as $group) {
        foreach (array('awl', 'nbm') as $type) {
            if ($group['fixed'][$type] !== '') {
                $assigned[$type][] = $group['fixed'][$type];
            }
        }
    }

    $final = array();
    foreach ($plan['subs'] as $sub => $group) {
        $final[$sub] = customer_code_pair();
        foreach (array('awl', 'nbm') as $type) {
            if ($group['fixed'][$type] !== '') {
                $final[$sub][$type] = $group['fixed'][$type];
            } elseif ($group['previews'][$type] !== '') {
                $code = customer_code_resolve_preview($conn, $type, $group['previews'][$type], $assigned[$type]);
                if ($code === '') {
                    return array('ok' => false, 'message' => 'เลขรันรหัสลูกค้าของเดือนนี้เต็มแล้ว');
                }
                $assigned[$type][] = $code;
                $final[$sub][$type] = $code;
            }
        }
    }

    $codes = array();
    foreach ($plan['cards'] as $index => $sub) {
        $codes[$index] = $final[$sub];
    }
    return array('ok' => true, 'codes' => $codes);
}

// การ์ดออกบิลจาก customer_add.php ที่จะบันทึกจริง ข้ามการ์ดที่ชื่อ/ที่อยู่/จังหวัดว่างทั้งหมด (กติกาเดียวกับ loop insert)
// has_meta = false: ฟอร์มรุ่นก่อนไม่ส่ง billing_client_key[] ใช้ customer_code_resolve_posted_codes ตามเดิม
function customer_code_posted_billing_cards()
{
    $field = function ($name) {
        return isset($_POST[$name]) && is_array($_POST[$name]) ? array_values($_POST[$name]) : array();
    };
    $names = $field('billing_name');
    $addresses = $field('billing_address');
    $provinces = $field('billing_province');
    $taxes = $field('billing_tax_id');
    $awls = $field('billing_code');
    $nbms = $field('billing_coden');
    $keys = $field('billing_client_key');
    $records = $field('billing_record_id');
    $sources = $field('billing_source_key');
    $hasMeta = isset($_POST['billing_client_key']) && is_array($_POST['billing_client_key']);

    $count = max(count($names), count($addresses), count($provinces), count($taxes), count($field('billing_tel')), count($field('billing_email')), count($field('billing_branch_type')), count($field('billing_branch_no')));
    $cards = array();
    for ($i = 0; $i < $count; $i++) {
        $name = isset($names[$i]) ? trim((string)$names[$i]) : '';
        $address = isset($addresses[$i]) ? trim((string)$addresses[$i]) : '';
        $province = isset($provinces[$i]) ? trim((string)$provinces[$i]) : '';
        if ($name === '' && $address === '' && $province === '') {
            continue;
        }
        $cards[] = array(
            'index' => $i,
            'number' => $i + 1,
            'key' => $hasMeta ? trim((string)($keys[$i] ?? '')) : 'p' . $i,
            'record_id' => $hasMeta ? (int)($records[$i] ?? 0) : 0,
            'source_key' => $hasMeta ? trim((string)($sources[$i] ?? '')) : '',
            'tax' => customer_code_normalize_tax($taxes[$i] ?? ''),
            'awl' => trim((string)($awls[$i] ?? '')),
            'nbm' => trim((string)($nbms[$i] ?? '')),
        );
    }
    return array('has_meta' => $hasMeta, 'cards' => $cards);
}

// สถานะเริ่มต้นของการ์ดตอนแสดงหน้า (กติกาเดียวกับตอนบันทึก) ส่งให้ js/billing-customer-codes.js ผ่าน data-code-view
// $card เหมือน customer_code_plan_billing_cards; awl/nbm = ค่าที่ POST กลับมาตอนบันทึกไม่ผ่าน (GET = ว่าง)
// $lookupEnabled = false สำหรับลูกค้าใหม่ (ไม่ค้นในฐาน ใช้ร่วมกันเฉพาะการ์ดในฟอร์ม)
function customer_code_card_view($customer, $card, $lookupEnabled = true)
{
    $base = customer_code_card_base($customer, $card);
    $view = array(
        'saved_tax' => $base['saved_tax'],
        'saved' => $base['saved'],
        'saved_source' => $base['saved_source'],
        'tax' => $card['tax'],
        'db' => array('status' => 'excluded', 'codes' => null, 'candidates' => array()),
        'source_key' => '',
        'previews' => customer_code_pair(),
    );

    $posted = customer_code_pair($card['awl'], $card['nbm']);
    $pair = $base['codes'];
    $reusable = customer_code_tax_reusable($card['tax']);
    if ($reusable) {
        if (customer_code_pair_full($base['codes'])) {
            $view['db']['status'] = 'skip';
        } elseif (!$lookupEnabled) {
            $view['db']['status'] = 'not_found';
        } else {
            $lookup = customer_code_lookup($customer, $card['tax'], $base['codes'], $base['exclude']);
            $view['db'] = array('status' => $lookup['status'], 'codes' => $lookup['codes'], 'candidates' => $lookup['candidates']);
            $source = $card['source_key'];
            if ($source !== '' && isset($lookup['matches'][$source])) {
                $view['source_key'] = $source;
                $pair = $lookup['matches'][$source]['codes'];
            } elseif ($lookup['status'] === 'matched') {
                $pair = $lookup['codes'];
            }
        }
    }
    // codes = ค่าที่แสดงตอนโหลดหน้า (JS คำนวณซ้ำด้วยกติกาเดียวกัน)
    $view['codes'] = customer_code_pair();
    foreach (array('awl', 'nbm') as $type) {
        if ($pair[$type] === '' && $posted[$type] !== '') {
            $view['previews'][$type] = $posted[$type];
        } elseif (!$reusable && $posted[$type] !== '' && $posted[$type] !== $pair[$type]) {
            // tax ที่ไม่ใช้ร่วมกัน: ผู้ใช้ Run ทับรหัสเดิมไว้
            $view['previews'][$type] = $posted[$type];
        }
        $view['codes'][$type] = $view['previews'][$type] !== '' ? $view['previews'][$type] : $pair[$type];
    }
    return $view;
}

function customer_code_view_attr($view)
{
    return htmlspecialchars(json_encode($view, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
}
