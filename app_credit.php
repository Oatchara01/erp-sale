<?php
include("dbconnect.php");
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
mysqli_set_charset($conn, "utf8mb4");

$id_cus = isset($_GET["id_cus"]) ? (int)$_GET["id_cus"] : 0;
if ($id_cus <= 0) {
    die("Invalid id_cus");
}

$add_date = date('Y-m-d H:i:s');
$name     = $_SESSION["name"] ?? '';
$surname  = $_SESSION["surname"] ?? '';
$add_by   = trim($name . ' ' . $surname);

// รับจำนวนเงินจาก modal
$credit_amount = isset($_GET["credit_amount"]) ? trim($_GET["credit_amount"]) : '';

mysqli_begin_transaction($conn);

try {
    // 1) ดึงข้อมูลเครดิตเดิม
    $stmt = mysqli_prepare($conn, "SELECT credit_thb, customer_id FROM tb_customer_credit WHERE id_cus = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_cus);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $rs21 = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);

    if (!$rs21) {
        throw new Exception("Not found id_cus");
    }

    $customer_id = $rs21["customer_id"];

    // 2) เลือกจำนวนเงินที่จะอนุมัติ
    if ($credit_amount !== '') {
        $credit_thb = (float)str_replace(',', '', $credit_amount);
    } else {
        $credit_thb = (float)str_replace(',', '', $rs21["credit_thb"]);
    }

    if ($credit_thb < 0) {
        throw new Exception("Invalid credit amount");
    }

    // 3) Update tb_customer
    $stmt = mysqli_prepare($conn, "UPDATE tb_customer SET credit_thb = ? WHERE customer_id = ?");
    mysqli_stmt_bind_param($stmt, "ds", $credit_thb, $customer_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // 4) Update tb_customer_credit -> Approve
    $status = "Approve";
    $stmt = mysqli_prepare($conn, "UPDATE tb_customer_credit 
        SET approve_name = ?, approve_date = ?, status_credit = ?
        WHERE id_cus = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $add_by, $add_date, $status, $id_cus);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) === 0) {
        throw new Exception("Update tb_customer_credit failed (id_cus not match)");
    }
    mysqli_stmt_close($stmt);

    mysqli_commit($conn);

    echo "<script>
            alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');
            window.location='status_app_credit.php';
          </script>";
    exit;

} catch (Throwable $e) {
    mysqli_rollback($conn);
    echo "Cannot: " . htmlspecialchars($e->getMessage());
}
?>