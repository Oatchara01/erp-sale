<?php
/* =========================================================
   dropdown ที่อยู่แบบผูกกัน จังหวัด → เขต/อำเภอ → แขวง/ตำบล → รหัสไปรษณีย์
   (db__provinces / db__districts / db__sub_districts เก็บ name_th พร้อมคำนำหน้า)
   ใช้ใน billing_info_add.php / shipping_info_add.php คู่กับ js/address-cascade.js
   ชุดของค่าที่บันทึกไว้โหลดตอนเปิดหน้า ชั้นที่เปลี่ยนภายหลังโหลดผ่าน ajax_address_options.php
   ค่าเก่าที่ไม่ตรง master แสดงเป็น "(ไม่พบในรายการ)" ให้บันทึกต่อได้โดยข้อมูลไม่หาย
   (customer_add.php มีชุดเดียวกันของตัวเองอยู่ในไฟล์ ยังไม่ได้ย้ายมาใช้ไฟล์นี้)
========================================================= */

if (!function_exists('address_cascade_data')) {
    function address_cascade_h($value)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }

    function address_cascade_rows($connection, $sql, $types, $params)
    {
        $rows = array();
        $stmt = mysqli_prepare($connection, $sql);
        if (!$stmt) {
            return $rows;
        }
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }
        mysqli_stmt_close($stmt);
        return $rows;
    }

    function address_cascade_data($connection, $province, $ampher, $tumbon, $postcode)
    {
        $province = trim((string)$province);
        $data = array(
            'ampher' => trim((string)$ampher),
            'tumbon' => trim((string)$tumbon),
            'postcode' => trim((string)$postcode),
            'districts' => array(),
            'districtId' => 0,
            'subDistricts' => array(),
            'zip' => '',
        );

        if ($province !== '') {
            $data['districts'] = address_cascade_rows(
                $connection,
                "SELECT d.id, d.name_th
                 FROM db__districts d
                 INNER JOIN db__provinces p ON p.id = d.province_id
                 WHERE p.name_th = ? AND d.deleted_at IS NULL
                 ORDER BY d.name_th",
                's',
                array($province)
            );
            foreach ($data['districts'] as $district) {
                if ($district['name_th'] === $data['ampher']) {
                    $data['districtId'] = (int)$district['id'];
                    break;
                }
            }
        }

        if ($data['districtId'] > 0) {
            $data['subDistricts'] = address_cascade_rows(
                $connection,
                "SELECT id, name_th, zip_code
                 FROM db__sub_districts
                 WHERE district_id = ? AND deleted_at IS NULL
                 ORDER BY name_th",
                'i',
                array($data['districtId'])
            );
        }

        // รหัสไปรษณีย์มีตัวเลือกเดียวคือรหัสของตำบลที่เลือก (ตำบลยังไม่เลือก = ไม่มีตัวเลือก)
        foreach ($data['subDistricts'] as $subDistrict) {
            if ($subDistrict['name_th'] === $data['tumbon']) {
                $data['zip'] = (string)$subDistrict['zip_code'];
                break;
            }
        }

        return $data;
    }

    function address_cascade_legacy_option($value)
    {
        return '<option value="' . address_cascade_h($value) . '" selected>' . address_cascade_h($value) . ' (ไม่พบในรายการ)</option>';
    }

    function address_cascade_district_options($data)
    {
        $html = '<option value="">Select</option>';
        if ($data['ampher'] !== '' && $data['districtId'] === 0) {
            $html .= address_cascade_legacy_option($data['ampher']);
        }
        foreach ($data['districts'] as $district) {
            $selected = (int)$district['id'] === $data['districtId'] ? ' selected' : '';
            $html .= '<option value="' . address_cascade_h($district['name_th']) . '" data-id="' . address_cascade_h($district['id']) . '"' . $selected . '>' . address_cascade_h($district['name_th']) . '</option>';
        }
        return $html;
    }

    function address_cascade_sub_district_options($data)
    {
        $html = '<option value="">Select</option>';
        $found = false;
        $options = '';
        foreach ($data['subDistricts'] as $subDistrict) {
            $selected = '';
            if ($subDistrict['name_th'] === $data['tumbon']) {
                $selected = ' selected';
                $found = true;
            }
            $options .= '<option value="' . address_cascade_h($subDistrict['name_th']) . '" data-zip="' . address_cascade_h($subDistrict['zip_code']) . '"' . $selected . '>' . address_cascade_h($subDistrict['name_th']) . '</option>';
        }
        if ($data['tumbon'] !== '' && !$found) {
            $html .= address_cascade_legacy_option($data['tumbon']);
        }
        return $html . $options;
    }

    function address_cascade_postcode_options($data)
    {
        $html = '<option value="">Select</option>';
        if ($data['postcode'] !== '' && $data['postcode'] !== $data['zip']) {
            $html .= address_cascade_legacy_option($data['postcode']);
        }
        if ($data['zip'] !== '') {
            $selected = $data['zip'] === $data['postcode'] ? ' selected' : '';
            $html .= '<option value="' . address_cascade_h($data['zip']) . '"' . $selected . '>' . address_cascade_h($data['zip']) . '</option>';
        }
        return $html;
    }
}
