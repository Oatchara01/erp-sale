<?php
/* =========================================================
   ต่อ แขวง/ตำบล เข้าข้อความที่อยู่ที่ popup / data_* ส่งให้หน้าเอกสาร
   - ตำบลว่าง = ข้อความเดิม
   - ที่อยู่มีชื่อตำบลอยู่แล้ว (เทียบหลังตัดคำนำหน้า ตำบล/แขวง/ต.) = ไม่ต่อซ้ำ
   ค่าตำบลมาจาก customer_add.php (db__sub_districts.name_th พร้อมคำนำหน้า)
========================================================= */

if (!function_exists('address_tumbon_core')) {
    function address_tumbon_core($tumbon)
    {
        $tumbon = trim((string)$tumbon);
        return trim(preg_replace('/^(ตำบล|แขวง|ต\.)\s*/u', '', $tumbon));
    }

    // ต่อตำบลท้ายส่วนที่อยู่ (ผู้เรียกวางผลไว้ก่อนอำเภอ)
    function address_append_tumbon($address, $tumbon)
    {
        $address = trim((string)$address);
        $tumbon = trim((string)$tumbon);
        $core = address_tumbon_core($tumbon);
        if ($core === '') {
            return $address;
        }
        if ($address !== '' && mb_strpos($address, $core) !== false) {
            return $address;
        }
        return $address === '' ? $tumbon : $address . ' ' . $tumbon;
    }

    // ตำบลของแถวหลักใน tb_customer_billing_address / tb_customer_shipping_address
    // แถวหลัก = ลำดับแรก (index น้อยสุด แล้ว id) เหมือนการ์ดใบที่ 1 ใน customer_add.php ไม่อิง is_primary
    // เพราะ billing_info_add.php เคยตั้ง is_primary=1 ให้ทุกแถวที่ถูกแก้
    // ใช้กับ data_* ที่อ่าน bill_*/del_* จาก tb_customer ซึ่งไม่มีคอลัมน์ตำบล
    // คอลัมน์ยังไม่มี (ยังไม่รัน migration) หรือไม่มีแถว = '' ไม่ทำให้ endpoint ล้ม
    function address_primary_tumbon($conn, $customerId, $kind)
    {
        $customerId = (int)$customerId;
        if ($customerId <= 0) {
            return '';
        }
        if ($kind === 'billing') {
            $sql = "SELECT billing_tumbon AS tumbon FROM tb_customer_billing_address
                    WHERE customer_id = ? ORDER BY billing_index ASC, id ASC LIMIT 1";
        } else {
            $sql = "SELECT shipping_tumbon AS tumbon FROM tb_customer_shipping_address
                    WHERE customer_id = ? ORDER BY shipping_index ASC, id ASC LIMIT 1";
        }
        try {
            $stmt = mysqli_prepare($conn, $sql);
        } catch (Throwable $e) {
            return '';
        }
        if (!$stmt) {
            return '';
        }
        mysqli_stmt_bind_param($stmt, 'i', $customerId);
        if (!mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return '';
        }
        $result = mysqli_stmt_get_result($stmt);
        $row = $result ? mysqli_fetch_assoc($result) : null;
        mysqli_stmt_close($stmt);
        return $row ? trim((string)$row['tumbon']) : '';
    }

    // ตำบลของที่อยู่จัดส่งเดิมของลูกค้าที่ ที่อยู่/อำเภอ/จังหวัด ตรงกัน (ค่าดิบ ยังไม่ escape)
    // ใช้กับปุ่ม "เพิ่มลงฐานลูกค้า" ใน BR/BRCS ที่ส่งมาแค่ส่วนประกอบดิบ (มาจาก popup ที่อยู่จัดส่ง หรือ del_* ของลูกค้า) ไม่มีตำบล
    // ไม่พบ / ยังไม่รัน migration = '' (แถวใหม่ไม่มีตำบลเหมือนเดิม)
    function address_lookup_shipping_tumbon($conn, $customerId, $address, $ampher, $province)
    {
        $customerId = (int)$customerId;
        $address = trim((string)$address);
        if ($customerId <= 0 || $address === '') {
            return '';
        }
        $sql = "SELECT shipping_tumbon AS tumbon FROM tb_customer_shipping_address
                WHERE customer_id = ? AND shipping_address = ? AND shipping_ampher = ? AND shipping_province = ?
                    AND shipping_tumbon IS NOT NULL AND shipping_tumbon <> ''
                ORDER BY shipping_index ASC, id ASC LIMIT 1";
        try {
            $stmt = mysqli_prepare($conn, $sql);
        } catch (Throwable $e) {
            return '';
        }
        if (!$stmt) {
            return '';
        }
        $ampher = trim((string)$ampher);
        $province = trim((string)$province);
        mysqli_stmt_bind_param($stmt, 'isss', $customerId, $address, $ampher, $province);
        if (!mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return '';
        }
        $result = mysqli_stmt_get_result($stmt);
        $row = $result ? mysqli_fetch_assoc($result) : null;
        mysqli_stmt_close($stmt);
        return $row ? trim((string)$row['tumbon']) : '';
    }
}
