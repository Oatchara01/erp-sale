<?php
// ✅ ตั้งค่าความปลอดภัยของ Session ต้องทำก่อน session_start()
ini_set('session.cookie_httponly', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}
ini_set('session.use_strict_mode', 1);

session_start();
ob_start();

require_once('dbconnect.php');
require_once('head_first.php');

/**
 * ถอดรหัส token เป็น em_id
 */
function decryptData($token, $secretKey = 'mySecretKey123456789') {
    if ($token === null || $token === '') return false;

    // หมายเหตุ: ยังใช้ IV จาก key เดิมเพื่อให้เข้ากันได้ (ไม่ปลอดภัยนักแต่คงไว้ตามระบบเดิม)
    $key = hash('sha256', $secretKey, true); // 32 bytes
    $iv  = substr($key, 0, 16);              // 16 bytes IV

    $decoded = base64_decode(rawurldecode($token), true);
    if ($decoded === false) return false;

    $plain = openssl_decrypt($decoded, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    if ($plain === false || $plain === '') return false;

    return $plain; // ควรได้ em_id
}

// ----- รับ token จาก URL -----
$token = isset($_GET['token']) ? $_GET['token'] : '';

// พยายามถอดรหัส token -> em_id
$emId = decryptData($token);

// fallback: กรณีมีคนส่ง em_id แบบ plain มาตรง ๆ
if ($emId === false) {
    $candidate = trim($token);
    if ($candidate !== '' && preg_match('/^[A-Za-z0-9_-]{1,64}$/', $candidate)) {
        $emId = $candidate;
    }
}

// ถ้ายังไม่ได้ em_id ที่ใช้ได้ -> แจ้งเตือนและจบ
if ($emId === false) {
    echo '<div class="w3-container" id="outer"><div id="inner" class="w3-center">';
    echo "<h3>ลิงก์ไม่ถูกต้องหรือหมดอายุ</h3><br /><a href='index.php'><h5>กลับไปหน้าเข้าสู่ระบบ</h5></a>";
    echo '</div></div>';
    require_once('foot.php');
    ob_end_flush();
    exit;
}

// ------- ดึงข้อมูลผู้ใช้จากฐานข้อมูล -------
$emIdEscaped = mysqli_real_escape_string($conn, $emId);
$strSQL = "SELECT * FROM tb_user WHERE em_id = '".$emIdEscaped."'";
$objQuery  = mysqli_query($conn, $strSQL);
if (!$objQuery) {
    // ถ้า query error ให้ debug ง่าย ๆ
    echo '<div class="w3-container" id="outer"><div id="inner" class="w3-center">';
    echo "<h3>เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล</h3>";
    echo "<p>".htmlspecialchars(mysqli_error($conn), ENT_QUOTES, 'UTF-8')."</p>";
    echo "<a href='index.php'><h5>กลับไปหน้าเข้าสู่ระบบ</h5></a>";
    echo '</div></div>';
    require_once('foot.php');
    ob_end_flush();
    exit;
}

$objResult = mysqli_fetch_array($objQuery);
$rows      = mysqli_num_rows($objQuery);

?>

<div class="w3-container" id="outer">
<div id="inner" class="w3-center">

<?php
if ($rows == 1 && $objResult) {

    // เซ็ต Session
    $_SESSION["emid"]         = $objResult["em_id"];
    $_SESSION["UserID"]       = $objResult["user_id"];
    $_SESSION["name"]         = $objResult["name"];
    $_SESSION["surname"]      = $objResult["surname"];
    $_SESSION["position"]     = $objResult["position"];
    $_SESSION["mail_intra"]   = $objResult["mail_intra"];
    $_SESSION["ext"]          = $objResult["ext"];
    $_SESSION["user_type"]    = $objResult["user_type"];
    $_SESSION["employee_tel"] = $objResult["employee_tel"];
    $_SESSION["department"]   = $objResult["department"];
    $_SESSION["code"]         = $objResult["code"];
    $_SESSION["type_login"]   = $objResult["type_login"];

    // ---------------- Routing ตามสิทธิ์ ----------------
    if ($objResult["name"] == "ชนิกานต์" || $objResult["name"] == "ปาลิตา") {
        header("Location: main_mk.php");
        exit;
		} else if ($objResult["code"] == "SMD") {
        header("Location: main_admin.php");
        exit;
	} else if ($objResult["type_login"] == "Admin") {
        header("Location: main_admin.php");
        exit;
    } else if ($objResult["type_login"] == "Test") {
        header("Location: main_test.php");
        exit;
    } else if ($objResult["type_login"] == "AllWell") {
        header("Location: main_allwell.php");
        exit;
    } else if ($objResult["type_login"] == "Stock") {
        // แก้ JavaScript ให้ถูกต้อง
        echo "<script language=\"JavaScript\">";
        echo "alert('กรุณา Login ระบบ ERP Stock');";
        echo "window.location='https://stock.allwellcenter.com';";
        echo "</script>";
        session_write_close();
        ob_end_flush();
        exit;
    } else if ($objResult["type_login"] == "It") {
        header("Location: main_admin.php");
        exit;
    } else if ($objResult["type_login"] == "RPA") {
        header("Location: main_admins.php");
        exit;
    } else if ($objResult["type_login"] == "Sale" && $_SESSION["code"] == 'INT') {
        header("Location: main_admin.php");
        exit;
    } else if ($objResult["type_login"] == "Sale" && $_SESSION["code"] == 'HR') {
        header("Location: main_admin.php");
        exit;
    } else if ($objResult["type_login"] == "Sale") {
        header("Location: main_salehos.php");
        exit;
    } else if ($objResult["type_login"] == "Sup_Sale") {
        header("Location: main_suphos.php");
        exit;
    } else if ($objResult["type_login"] == "Sup_AllWell") {
        header("Location: main_supallwell.php");
        exit;
    } else if ($objResult["type_login"] == "Engineer") {
        header("Location: main_engineer.php");
        exit;
    } else if ($objResult["type_login"] == "Admin_hos") {
        header("Location: main_adminhos.php");
        exit;
    } else {
        // ถ้า type_login ไม่ตรงอะไรเลย
        echo "<h3>ไม่พบสิทธิ์การใช้งานที่เหมาะสม</h3><br /><a href='index.php'><h5>กลับไปหน้าเข้าสู่ระบบ</h5></a>";
    }

    session_write_close();

} else {

    echo "<h3>ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง!</h3><br /><a href='index.php'><h5>Go Back To Login Again</h5></a>";

}

mysqli_close($conn);
require_once('foot.php');
?>
</div>
</div>
<?php
ob_end_flush();
?>
