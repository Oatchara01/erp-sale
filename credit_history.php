<?php
header('Content-Type: application/json; charset=utf-8');
include('dbconnect.php');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
mysqli_set_charset($conn, "utf8mb4");

$customer_id = isset($_GET['customer_id']) ? trim($_GET['customer_id']) : '';
if ($customer_id === '') {
  echo json_encode(['ok'=>false,'error'=>'customer_id is required']);
  exit;
}

try {
  // ดึงชื่อจาก tb_customer
  $stmt = mysqli_prepare($conn, "SELECT customer_name FROM tb_customer WHERE customer_id = ? LIMIT 1");
  mysqli_stmt_bind_param($stmt, "s", $customer_id);
  mysqli_stmt_execute($stmt);
  $resName = mysqli_stmt_get_result($stmt);
  $nameRow = mysqli_fetch_assoc($resName);
  mysqli_stmt_close($stmt);

  $customer_name = $nameRow['customer_name'] ?? '';

  // ดึงประวัติจาก tb_customer_credit
  $stmt = mysqli_prepare($conn, "
    SELECT credit_thb, add_by, add_date, status_credit, approve_name, approve_date, note_reject
    FROM tb_customer_credit
    WHERE customer_id = ?
    ORDER BY id_cus DESC
    LIMIT 200
  ");
  mysqli_stmt_bind_param($stmt, "s", $customer_id);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);

  $rows = [];
  while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
  mysqli_stmt_close($stmt);

  echo json_encode(['ok'=>true,'customer_id'=>$customer_id,'customer_name'=>$customer_name,'rows'=>$rows], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
  echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);
}