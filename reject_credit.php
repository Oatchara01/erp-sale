<?php
include("dbconnect.php");
include("head.php");

$id_cus = isset($_GET['id_cus']) ? (int)$_GET['id_cus'] : 0;
$note   = isset($_GET['note']) ? trim($_GET['note']) : '';

if ($id_cus <= 0) {
  die("Invalid id_cus");
}
if ($note === '') {
  die("Note is required");
}

$add_date = date('Y-m-d H:i:s');
$name     = $_SESSION["name"] ?? '';
$surname  = $_SESSION["surname"] ?? '';
$add_by   = trim($name . ' ' . $surname);

mysqli_begin_transaction($conn);

try {
  // 1) ดึงข้อมูลจาก tb_customer_credit
  $stmt = mysqli_prepare($conn, "SELECT credit_thb, customer_id FROM tb_customer_credit WHERE id_cus = ?");
  mysqli_stmt_bind_param($stmt, "i", $id_cus);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $rs21 = mysqli_fetch_assoc($res);
  mysqli_stmt_close($stmt);

  if (!$rs21) {
    throw new Exception("Not found id_cus");
  }

  $credit_thb   = $rs21["credit_thb"];
  $customer_id  = $rs21["customer_id"];

  // 2) Update tb_customer
  $stmt = mysqli_prepare($conn, "UPDATE tb_customer SET credit_thb = ? WHERE customer_id = ?");
  mysqli_stmt_bind_param($stmt, "ds", $credit_thb, $customer_id); // d=double/decimal, s=string
  mysqli_stmt_execute($stmt);
  if (mysqli_stmt_affected_rows($stmt) < 0) {
    throw new Exception("Update tb_customer failed");
  }
  mysqli_stmt_close($stmt);

  // 3) Update tb_customer_credit (Rejected + note)
  $status = "Rejected";
  $stmt = mysqli_prepare($conn, "UPDATE tb_customer_credit 
      SET approve_name = ?, approve_date = ?, status_credit = ?, note_reject = ?
      WHERE id_cus = ?");
  mysqli_stmt_bind_param($stmt, "ssssi", $add_by, $add_date, $status, $note, $id_cus);
  mysqli_stmt_execute($stmt);
  if (mysqli_stmt_affected_rows($stmt) < 0) {
    throw new Exception("Update tb_customer_credit failed");
  }
  mysqli_stmt_close($stmt);

  mysqli_commit($conn);

  echo "<script>
          alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');
          window.location='status_app_credit.php';
        </script>";
  exit;

} catch (Exception $e) {
  mysqli_rollback($conn);
  echo "Cannot: " . htmlspecialchars($e->getMessage());
}
?>