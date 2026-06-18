<?php
include("head.php");
include("dbconnect.php");


date_default_timezone_set('Asia/Bangkok');
$REF_ID = isset($_GET['ref_id']) ? trim((string)$_GET['ref_id']) : '';
if ($REF_ID === '') {
    http_response_code(400);
    exit('Missing ref_id');
}

$kind = substr($REF_ID, 0, 2);

$add_date = date('Y-m-d H:i:s');
$name     = $_SESSION['name']    ?? '';
$surname  = $_SESSION['surname'] ?? '';

$sm_namtm = trim($name . ' ' . $surname) . ' | ' . $add_date;

$sql = ($kind === 'BR')
    ? "UPDATE hos__subbr SET sm_care='1', sm_namtm=? WHERE ref_idd_br=?"
    : (($kind === 'RS')
        ? "UPDATE hos__subsmp SET sm_care='1', sm_namtm=? WHERE reff_idsmp=?"
        : "UPDATE hos__subso SET sm_care='1', sm_namtm=? WHERE ref_idd=?");

if (!($conn instanceof mysqli)) {
    http_response_code(500);
    exit('DB connection invalid');
}

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    exit('SQL prepare error: ' . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8'));
}

$stmt->bind_param('ss', $sm_namtm, $REF_ID);
$ok  = $stmt->execute();
$err = $stmt->error;
$stmt->close();

if ($ok) {
    echo '<script>alert("บันทึกข้อมูลเรียบร้อยแล้ว");window.location="status_glucosemkhos.php";</script>';
    exit;
} else {
    http_response_code(500);
    echo 'ไม่สามารถบันทึกได้: ' . htmlspecialchars($err, ENT_QUOTES, 'UTF-8');
}
?>