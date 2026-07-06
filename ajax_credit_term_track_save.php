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

require_once 'dbconnect_acc.php';

function credit_term_track_error($message, $statusCode = 400)
{
    http_response_code($statusCode);
    echo json_encode([
        'success' => false,
        'message' => $message
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

set_exception_handler(function ($error) {
    error_log('Credit term tracking error: ' . $error->getMessage());
    credit_term_track_error('เกิดข้อผิดพลาดระหว่างบันทึกการติดตาม กรุณาลองใหม่อีกครั้ง', 500);
});

function credit_term_fetch_tracks(mysqli $code, $refIdOff)
{
    $sql = "
        SELECT add_date, des_track, add_by
        FROM tb_track
        WHERE ref_id_off = ?
        ORDER BY add_date DESC, id_track DESC
    ";

    $stmt = mysqli_prepare($code, $sql);
    if (!$stmt) {
        credit_term_track_error('ไม่สามารถเตรียมข้อมูลการติดตามได้', 500);
    }

    mysqli_stmt_bind_param($stmt, 's', $refIdOff);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $tracks = array();
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tracks[] = array(
                'add_date' => (string)$row['add_date'],
                'des_track' => (string)$row['des_track'],
                'add_by' => (string)$row['add_by']
            );
        }
    }

    mysqli_stmt_close($stmt);

    return $tracks;
}

$refIdOff = trim($_POST['ref_id_off'] ?? '');
$desTrack = trim($_POST['des_track'] ?? '');

if ($refIdOff === '') {
    credit_term_track_error('ไม่พบรายการหนี้ที่ต้องการบันทึก');
}

if ($desTrack === '') {
    credit_term_track_error('กรุณากรอกข้อมูลการติดตาม');
}

$checkSql = "SELECT id_off FROM tb_register_data WHERE id_off = ? LIMIT 1";
$checkStmt = mysqli_prepare($code, $checkSql);
if (!$checkStmt) {
    credit_term_track_error('ไม่สามารถตรวจสอบรายการหนี้ได้', 500);
}

mysqli_stmt_bind_param($checkStmt, 's', $refIdOff);
mysqli_stmt_execute($checkStmt);
$checkResult = mysqli_stmt_get_result($checkStmt);
$debtRow = $checkResult ? mysqli_fetch_assoc($checkResult) : null;
mysqli_stmt_close($checkStmt);

if (!$debtRow) {
    credit_term_track_error('ไม่พบรายการหนี้ที่เลือก');
}

$userId = trim((string)$_SESSION['UserID']);
$userSql = "SELECT em_id FROM tb_user WHERE user_id = ? LIMIT 1";
$userStmt = mysqli_prepare($code, $userSql);
if (!$userStmt) {
    credit_term_track_error('ไม่สามารถตรวจสอบข้อมูลผู้บันทึกได้', 500);
}

mysqli_stmt_bind_param($userStmt, 's', $userId);
mysqli_stmt_execute($userStmt);
$userResult = mysqli_stmt_get_result($userStmt);
$userRow = $userResult ? mysqli_fetch_assoc($userResult) : null;
mysqli_stmt_close($userStmt);

$employeeNo = trim((string)($userRow['em_id'] ?? ''));
if ($employeeNo === '') {
    credit_term_track_error('ไม่พบรหัสพนักงานของผู้ใช้งาน กรุณาติดต่อผู้ดูแลระบบ');
}

$userName = trim((string)($_SESSION['name'] ?? ''));
$userSurname = trim((string)($_SESSION['surname'] ?? ''));
$addBy = trim($userName . ' ' . $userSurname);
if ($addBy === '') {
    $addBy = $userName !== '' ? $userName : 'System';
}

$addDate = date('Y-m-d H:i:s');
$datePlan = '0000-00-00';
$planName = '';
$planEmployeeId = '';
$addPlan = '0000-00-00 00:00:00';
$planChecked = 0;

// This legacy table uses zero dates to represent an unset follow-up plan.
$sqlModeResult = mysqli_query($code, "SELECT @@SESSION.sql_mode AS sql_mode");
$sqlModeRow = $sqlModeResult ? mysqli_fetch_assoc($sqlModeResult) : null;
$sqlModes = explode(",", (string)($sqlModeRow["sql_mode"] ?? ""));
$sqlModes = array_filter($sqlModes, function ($mode) {
    return $mode !== "NO_ZERO_DATE" && $mode !== "NO_ZERO_IN_DATE";
});
$legacySqlMode = mysqli_real_escape_string($code, implode(",", $sqlModes));
mysqli_query($code, "SET SESSION sql_mode = '" . $legacySqlMode . "'");

$insertSql = "
    INSERT INTO tb_track (
        ref_id_off, des_track, add_date, add_by, emp_no,
        date_plan, plan_name, plan_emid, add_plan, planckk
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
";
$insertStmt = mysqli_prepare($code, $insertSql);
if (!$insertStmt) {
    credit_term_track_error('ไม่สามารถเตรียมการบันทึกได้', 500);
}

mysqli_stmt_bind_param(
    $insertStmt,
    'sssssssssi',
    $refIdOff,
    $desTrack,
    $addDate,
    $addBy,
    $employeeNo,
    $datePlan,
    $planName,
    $planEmployeeId,
    $addPlan,
    $planChecked
);
$saved = mysqli_stmt_execute($insertStmt);
mysqli_stmt_close($insertStmt);

if (!$saved) {
    credit_term_track_error('บันทึกการติดตามไม่สำเร็จ', 500);
}

$tracks = credit_term_fetch_tracks($code, $refIdOff);

echo json_encode(array(
    'success' => true,
    'message' => 'บันทึกการติดตามเรียบร้อยแล้ว',
    'track_count' => count($tracks),
    'tracks' => $tracks,
    'saved' => array(
        'ref_id_off' => $refIdOff,
        'des_track' => $desTrack,
        'add_date' => $addDate,
        'add_by' => $addBy
    )
), JSON_UNESCAPED_UNICODE);
