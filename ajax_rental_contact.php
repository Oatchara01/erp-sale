<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if (empty($_SESSION['UserID'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'กรุณาเข้าสู่ระบบใหม่'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

require_once 'dbconnect.php';
require_once 'datethai.php';

date_default_timezone_set("Asia/Bangkok");

function formatThaiDateTime($dateStr) {
    if (!$dateStr || $dateStr == '0000-00-00 00:00:00' || $dateStr == '0000-00-00') {
        return '-';
    }
    $timePart = '';
    if (strlen($dateStr) > 10) {
        $timePart = ' ' . substr($dateStr, 11, 5) . ' น.';
    }
    return DateThai($dateStr) . $timePart;
}

function formatThaiShortDate($dateStr) {
    if (!$dateStr || $dateStr === '0000-00-00' || $dateStr === '0000-00-00 00:00:00') {
        return '-';
    }
    $time = strtotime($dateStr);
    if (!$time) return '-';
    $day = date('d', $time);
    $month = date('m', $time);
    $yearBE = (int)date('Y', $time) + 543;
    $shortYear = substr((string)$yearBE, -2);
    return "$day/$month/$shortYear";
}

$action = $_REQUEST['action'] ?? 'get';
$ref_id = trim($_REQUEST['ref_id'] ?? '');

if (empty($ref_id)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'ไม่พบเลขที่อ้างอิงเอกสาร (ref_id)'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($action === 'save') {
    $des_con = trim($_POST['des_con'] ?? '');
    if (empty($des_con)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'กรุณากรอกข้อความการติดตาม'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $name = $_SESSION['name'] ?? '';
    $surname = $_SESSION['surname'] ?? '';
    $add_by = trim("$name $surname");
    if (empty($add_by)) {
        $add_by = $_SESSION['UserID'];
    }
    $add_date = date('Y-m-d H:i:s');

    $stmt = mysqli_prepare($conn, "INSERT INTO hos__rental_contact (ref_id, des_con, add_date, add_by) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'เกิดข้อผิดพลาดในการเตรียมคำสั่งบันทึกข้อมูล: ' . mysqli_error($conn)
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'ssss', $ref_id, $des_con, $add_date, $add_by);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$ok) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'ไม่สามารถบันทึกข้อมูลการติดตามได้: ' . mysqli_error($conn)
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

// Fetch document details for header summary
$doc_info = null;
$stmtDoc = mysqli_prepare($conn, "SELECT ref_id, iv_no, promis_no, promis_date, start_promis, end_promis, register_date, iv_date, rental_name FROM hos__rental WHERE ref_id = ? LIMIT 1");
if ($stmtDoc) {
    mysqli_stmt_bind_param($stmtDoc, 's', $ref_id);
    mysqli_stmt_execute($stmtDoc);
    $resDoc = mysqli_stmt_get_result($stmtDoc);
    if ($resDoc && ($rowDoc = mysqli_fetch_assoc($resDoc))) {
        $rawPromisDate = (!empty($rowDoc['promis_date']) && $rowDoc['promis_date'] !== '0000-00-00') 
            ? $rowDoc['promis_date'] 
            : ((!empty($rowDoc['start_promis']) && $rowDoc['start_promis'] !== '0000-00-00') 
                ? $rowDoc['start_promis'] 
                : ((!empty($rowDoc['iv_date']) && $rowDoc['iv_date'] !== '0000-00-00') 
                    ? $rowDoc['iv_date'] 
                    : $rowDoc['register_date']));
        $rawEndPromis = (!empty($rowDoc['end_promis']) && $rowDoc['end_promis'] !== '0000-00-00') ? $rowDoc['end_promis'] : '';

        $pDateTh = (!empty($rawPromisDate) && $rawPromisDate !== '0000-00-00') ? date('d/m/', strtotime($rawPromisDate)) . (date('Y', strtotime($rawPromisDate)) + 543) : '-';
        $eDateTh = (!empty($rawEndPromis) && $rawEndPromis !== '0000-00-00') ? date('d/m/', strtotime($rawEndPromis)) . (date('Y', strtotime($rawEndPromis)) + 543) : '-';

        $doc_info = [
            'ref_id' => $rowDoc['ref_id'],
            'rental_name' => $rowDoc['rental_name'] ?? '',
            'promis_no' => !empty($rowDoc['promis_no']) ? $rowDoc['promis_no'] : (!empty($rowDoc['iv_no']) ? $rowDoc['iv_no'] : '-'),
            'promis_date' => $rawPromisDate,
            'promis_date_th' => $pDateTh,
            'end_promis' => $rawEndPromis,
            'end_promis_th' => $eDateTh
        ];
    }
    mysqli_stmt_close($stmtDoc);
}

// Fetch list of contacts for this ref_id (Ascending order so 1, 2, ... N matches chronological order)
$tracks = [];
$stmt = mysqli_prepare($conn, "SELECT * FROM hos__rental_contact WHERE ref_id = ? ORDER BY add_date ASC, id ASC");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $ref_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tracks[] = [
                'id' => $row['id'] ?? null,
                'ref_id' => $row['ref_id'],
                'des_con' => $row['des_con'],
                'add_date' => $row['add_date'],
                'add_date_short' => formatThaiShortDate($row['add_date']),
                'add_date_th' => formatThaiDateTime($row['add_date']),
                'add_by' => $row['add_by'] ?? '-'
            ];
        }
    }
    mysqli_stmt_close($stmt);
}

echo json_encode([
    'success' => true,
    'message' => ($action === 'save') ? 'บันทึกการติดตามเรียบร้อยแล้ว' : 'ดึงข้อมูลสำเร็จ',
    'ref_id' => $ref_id,
    'doc_info' => $doc_info,
    'data' => $tracks
], JSON_UNESCAPED_UNICODE);
