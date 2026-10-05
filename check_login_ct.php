<?php

// =========================================================
// DEBUG ชั่วคราว
// ถ้าระบบกลับมาใช้งานได้แล้ว แนะนำให้ปิด display_errors
// =========================================================
error_reporting(E_ALL);
ini_set('display_errors', '1');


// =========================================================
// SESSION SECURITY
// ต้องอยู่ก่อน session_start()
// =========================================================
ini_set('session.cookie_httponly', '1');
ini_set('session.use_strict_mode', '1');

if (
    isset($_SERVER['HTTPS']) &&
    $_SERVER['HTTPS'] !== '' &&
    $_SERVER['HTTPS'] !== 'off'
) {
    ini_set('session.cookie_secure', '1');
}

session_start();
ob_start();


// =========================================================
// INCLUDE
// =========================================================
require_once('dbconnect.php');


// =========================================================
// ตรวจสอบ Database Connection
// =========================================================
if (!isset($conn)) {
    die('ERROR: ไม่พบตัวแปร $conn จาก dbconnect.php');
}

if (!$conn) {
    die('ERROR DATABASE CONNECTION: ' . mysqli_connect_error());
}


// =========================================================
// FUNCTION DECRYPT TOKEN
// =========================================================
function decryptData($token, $secretKey = 'mySecretKey123456789')
{
    if ($token === null || $token === '') {
        return false;
    }

    $key = hash('sha256', $secretKey, true);

    // ระบบเดิมใช้ IV จาก key
    $iv = substr($key, 0, 16);

    $decoded = base64_decode(
        rawurldecode($token),
        true
    );

    if ($decoded === false) {
        return false;
    }

    $plain = openssl_decrypt(
        $decoded,
        'AES-256-CBC',
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );

    if ($plain === false || trim($plain) === '') {
        return false;
    }

    return trim($plain);
}


// =========================================================
// รับ TOKEN
// =========================================================
$token = isset($_GET['token'])
    ? trim($_GET['token'])
    : '';


// =========================================================
// TOKEN ว่าง
// =========================================================
if ($token === '') {

    require_once('head_first.php');

    ?>
    <div class="w3-container" id="outer">
        <div id="inner" class="w3-center">

            <h3>ไม่พบ Token สำหรับเข้าสู่ระบบ</h3>

            <br>

            <a href="index.php">
                <h5>กลับไปหน้าเข้าสู่ระบบ</h5>
            </a>

        </div>
    </div>
    <?php

    require_once('foot.php');

    ob_end_flush();
    exit;
}


// =========================================================
// DECRYPT TOKEN
// =========================================================
$emId = decryptData($token);


// =========================================================
// FALLBACK
// รองรับกรณีส่ง em_id แบบตรง ๆ
// =========================================================
if ($emId === false) {

    $candidate = trim($token);

    if (
        $candidate !== '' &&
        preg_match('/^[A-Za-z0-9_-]{1,64}$/', $candidate)
    ) {
        $emId = $candidate;
    }
}


// =========================================================
// TOKEN ใช้ไม่ได้
// =========================================================
if ($emId === false || trim($emId) === '') {

    require_once('head_first.php');

    ?>
    <div class="w3-container" id="outer">
        <div id="inner" class="w3-center">

            <h3>ลิงก์ไม่ถูกต้องหรือหมดอายุ</h3>

            <br>

            <a href="index.php">
                <h5>กลับไปหน้าเข้าสู่ระบบ</h5>
            </a>

        </div>
    </div>
    <?php

    require_once('foot.php');

    ob_end_flush();
    exit;
}


// =========================================================
// QUERY USER
// ใช้ Prepared Statement
// =========================================================
$sql = "
    SELECT *
    FROM tb_user
    WHERE em_id = ?
    LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die(
        'PREPARE ERROR: ' .
        htmlspecialchars(
            mysqli_error($conn),
            ENT_QUOTES,
            'UTF-8'
        )
    );
}


mysqli_stmt_bind_param(
    $stmt,
    's',
    $emId
);


if (!mysqli_stmt_execute($stmt)) {

    die(
        'EXECUTE ERROR: ' .
        htmlspecialchars(
            mysqli_stmt_error($stmt),
            ENT_QUOTES,
            'UTF-8'
        )
    );
}


$result = mysqli_stmt_get_result($stmt);


// =========================================================
// ตรวจสอบ User
// =========================================================
if (!$result) {

    die(
        'RESULT ERROR: ' .
        htmlspecialchars(
            mysqli_error($conn),
            ENT_QUOTES,
            'UTF-8'
        )
    );
}


$objResult = mysqli_fetch_assoc($result);


// =========================================================
// ไม่พบ User
// =========================================================
if (!$objResult) {

    require_once('head_first.php');

    ?>
    <div class="w3-container" id="outer">
        <div id="inner" class="w3-center">

            <h3>ไม่พบข้อมูลผู้ใช้งาน</h3>

            <p>
                Employee ID:
                <?php
                echo htmlspecialchars(
                    $emId,
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>
            </p>

            <br>

            <a href="index.php">
                <h5>กลับไปหน้าเข้าสู่ระบบ</h5>
            </a>

        </div>
    </div>
    <?php

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    require_once('foot.php');

    ob_end_flush();
    exit;
}


// =========================================================
// ป้องกัน Session Fixation
// =========================================================
session_regenerate_id(true);


// =========================================================
// SET SESSION
// =========================================================
$_SESSION['emid'] = $objResult['em_id'] ?? '';

$_SESSION['UserID'] = $objResult['user_id'] ?? '';

$_SESSION['name'] = $objResult['name'] ?? '';

$_SESSION['surname'] = $objResult['surname'] ?? '';

$_SESSION['position'] = $objResult['position'] ?? '';

$_SESSION['mail_intra'] = $objResult['mail_intra'] ?? '';

$_SESSION['ext'] = $objResult['ext'] ?? '';

$_SESSION['user_type'] = $objResult['user_type'] ?? '';

$_SESSION['employee_tel'] = $objResult['employee_tel'] ?? '';

$_SESSION['department'] = $objResult['department'] ?? '';

$_SESSION['code'] = $objResult['code'] ?? '';

$_SESSION['type_login'] = $objResult['type_login'] ?? '';


// =========================================================
// เตรียมค่าการ Routing
// =========================================================
$name = trim(
    $objResult['name'] ?? ''
);

$code = trim(
    $objResult['code'] ?? ''
);

$typeLogin = trim(
    $objResult['type_login'] ?? ''
);


// =========================================================
// ปิด Query ก่อน Redirect
// =========================================================
mysqli_stmt_close($stmt);


// =========================================================
// ROUTING
// =========================================================

// ---------------------------------------------------------
// Marketing
// ---------------------------------------------------------
/*if (
    $name === 'ชนิกานต์' ||
    $name === 'ปาลิตา'
) {

    session_write_close();

    header('Location: main_mk.php');
    exit;
}


// ---------------------------------------------------------
// SMD
// ---------------------------------------------------------
if ($code === 'SMD') {

    session_write_close();

    header('Location: main_admin.php');
    exit;
}


// ---------------------------------------------------------
// ADMIN
// ---------------------------------------------------------
if ($typeLogin === 'Admin') {

    session_write_close();

    header('Location: main_admin.php');
    exit;
}


// ---------------------------------------------------------
// TEST
// ---------------------------------------------------------
if ($typeLogin === 'Test') {

    session_write_close();

    header('Location: main_test.php');
    exit;
}


// ---------------------------------------------------------
// ALLWELL
// ---------------------------------------------------------
if ($typeLogin === 'AllWell') {

    session_write_close();

    header('Location: main_allwell.php');
    exit;
}


// ---------------------------------------------------------
// STOCK
// ---------------------------------------------------------
if ($typeLogin === 'Stock') {

    session_write_close();

    ?>
    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <title>Redirect</title>
    </head>

    <body>

    <script>
        alert('กรุณา Login ระบบ ERP Stock');
        window.location.href = 'https://stock.allwellcenter.com';
    </script>

    </body>
    </html>
    <?php

    exit;
}


// ---------------------------------------------------------
// IT
// ---------------------------------------------------------
if ($typeLogin === 'It') {

    session_write_close();

    header('Location: main_admin.php');
    exit;
}


// ---------------------------------------------------------
// RPA
// ---------------------------------------------------------
if ($typeLogin === 'RPA') {

    session_write_close();

    header('Location: main_admins.php');
    exit;
}


// ---------------------------------------------------------
// SALE - INT
// ---------------------------------------------------------
if (
    $typeLogin === 'Sale' &&
    $code === 'INT'
) {

    session_write_close();

    header('Location: main_admin.php');
    exit;
}


// ---------------------------------------------------------
// SALE - HR
// ---------------------------------------------------------
if (
    $typeLogin === 'Sale' &&
    $code === 'HR'
) {

    session_write_close();

    header('Location: main_admin.php');
    exit;
}


// ---------------------------------------------------------
// SALE
// ---------------------------------------------------------
if ($typeLogin === 'Sale') {

    session_write_close();

    header('Location: main_salehos.php');
    exit;
}


// ---------------------------------------------------------
// SUP SALE
// ---------------------------------------------------------
if ($typeLogin === 'Sup_Sale') {

    session_write_close();

    header('Location: main_suphos.php');
    exit;
}


// ---------------------------------------------------------
// SUP ALLWELL
// ---------------------------------------------------------
if ($typeLogin === 'Sup_AllWell') {

    session_write_close();

    header('Location: main_supallwell.php');
    exit;
}


// ---------------------------------------------------------
// ENGINEER
// ---------------------------------------------------------
if ($typeLogin === 'Engineer') {

    session_write_close();

    header('Location: main_engineer.php');
    exit;
}


// ---------------------------------------------------------
// ADMIN HOS
// ---------------------------------------------------------
if ($typeLogin === 'Admin_hos') {

    session_write_close();

    header('Location: main_adminhos.php');
    exit;
}*/
header('Location: main_admin.php');

// =========================================================
// ไม่พบสิทธิ์
// =========================================================
session_write_close();

require_once('head_first.php');

?>

<div class="w3-container" id="outer">

    <div id="inner" class="w3-center">

        <h3>ไม่พบสิทธิ์การใช้งานที่เหมาะสม</h3>

        <p>
            Type Login:
            <strong>
                <?php
                echo htmlspecialchars(
                    $typeLogin,
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>
            </strong>
        </p>

        <p>
            Code:
            <strong>
                <?php
                echo htmlspecialchars(
                    $code,
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>
            </strong>
        </p>

        <br>

        <a href="index.php">
            <h5>กลับไปหน้าเข้าสู่ระบบ</h5>
        </a>

    </div>

</div>

<?php

mysqli_close($conn);

require_once('foot.php');

ob_end_flush();

?>