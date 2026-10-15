<?php
// ตัวเลือก dropdown ที่อยู่แบบผูกกัน จังหวัด → เขต/อำเภอ → แขวง/ตำบล (+ รหัสไปรษณีย์) จาก db__provinces / db__districts / db__sub_districts
// ใช้ใน customer_add.php ค่าที่บันทึกเป็นชื่อภาษาไทยพร้อมคำนำหน้าตาม master (name_th) ส่วน id ใช้แค่โหลดชั้นถัดไป
session_start();
include('dbconnect.php');

header('Content-Type: application/json; charset=utf-8');

function responseJson($payload, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_SESSION['UserID'])) {
    responseJson(array('success' => false, 'message' => 'กรุณาเข้าสู่ระบบใหม่'), 401);
}

if (!isset($conn) || !$conn) {
    responseJson(array('success' => false, 'message' => 'Database connection failed'), 500);
}

function fetchStmtRows($connection, $sql, $types, $params)
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

$level = isset($_GET['level']) ? (string)$_GET['level'] : '';

if ($level === 'district') {
    // จังหวัดในฟอร์มเก็บเป็นชื่อ (tb_province.province_name ตรงกับ db__provinces.name_th)
    $province = isset($_GET['province']) ? trim((string)$_GET['province']) : '';
    if ($province === '') {
        responseJson(array('success' => true, 'items' => array()));
    }
    $items = fetchStmtRows(
        $conn,
        "SELECT d.id, d.name_th
         FROM db__districts d
         INNER JOIN db__provinces p ON p.id = d.province_id
         WHERE p.name_th = ? AND d.deleted_at IS NULL
         ORDER BY d.name_th",
        's',
        array($province)
    );
    responseJson(array('success' => true, 'items' => $items));
}

if ($level === 'sub_district') {
    $districtId = isset($_GET['district_id']) ? (int)$_GET['district_id'] : 0;
    if ($districtId <= 0) {
        responseJson(array('success' => true, 'items' => array()));
    }
    $items = fetchStmtRows(
        $conn,
        "SELECT id, name_th, zip_code
         FROM db__sub_districts
         WHERE district_id = ? AND deleted_at IS NULL
         ORDER BY name_th",
        'i',
        array($districtId)
    );
    responseJson(array('success' => true, 'items' => $items));
}

responseJson(array('success' => false, 'message' => 'level ไม่ถูกต้อง'), 400);
