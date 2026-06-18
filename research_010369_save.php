<?php
// research_010369_save.php
include "head.php";
include "dbconnect.php";
include "dbconnect_cs.php";
date_default_timezone_set("Asia/Bangkok");

/* =========================
  Helpers
========================= */
function clean_text($v){
  return trim((string)$v);
}
function clean_int_1_5($v){
  if ($v === '' || $v === null) return null;
  $v = (int)$v;
  if ($v < 1 || $v > 5) return null;
  return $v;
}

/* =========================
  Validate required main key
========================= */
$ref_id = $_POST['ref_id'] ?? '';
$ref_id = trim($ref_id);
if (!preg_match('/^[A-Za-z0-9_-]+$/', $ref_id)) {
  die('Invalid ref_id');
}

$now_date = date('Y-m-d');         // ใช้สำหรับฟิลด์วันที่ปัจจุบัน
$add_date = date('Y-m-d H:i:s');   // เก็บเวลาบันทึก
$surname  = $_SESSION['surname'] ?? '';
$name     = $_SESSION['name'] ?? '';
$add_by   = trim("$name $surname");
$type_login = $_SESSION['type_login'] ?? '';
/* =========================
  Collect base fields
  (อันไหนส่งมา -> ค่อยบันทึก)
========================= */
$incoming = [];

/* ===== ฟิลด์หลัก ===== */
if (isset($_POST['customer_name']) && clean_text($_POST['customer_name']) !== '') {
  $incoming['customer_name'] = clean_text($_POST['customer_name']);
}
if (isset($_POST['customer_tel']) && clean_text($_POST['customer_tel']) !== '') {
  $incoming['customer_tel'] = clean_text($_POST['customer_tel']);
}
if (isset($_POST['team_send']) && clean_text($_POST['team_send']) !== '') {
  $incoming['team_send'] = clean_text($_POST['team_send']);
}

/* ===== เพิ่มบันทึก: iv_number, iv_date, product_name, sale_code ===== */
if (isset($_POST['iv_number']) && clean_text($_POST['iv_number']) !== '') {
  $incoming['iv_number'] = clean_text($_POST['iv_number']);
}
if (isset($_POST['iv_date']) && clean_text($_POST['iv_date']) !== '') {
  $incoming['iv_date'] = clean_text($_POST['iv_date']); // YYYY-MM-DD
}
if (isset($_POST['product_name']) && clean_text($_POST['product_name']) !== '') {
  $incoming['product_name'] = clean_text($_POST['product_name']);
}
if (isset($_POST['sale_code']) && clean_text($_POST['sale_code']) !== '') {
  $incoming['sale_code'] = clean_text($_POST['sale_code']);
}

/* ===== วันที่จากฟอร์ม (ถ้าส่งมา) ===== */
if (isset($_POST['date_sale']) && clean_text($_POST['date_sale']) !== '') {
  $incoming['date_sale'] = clean_text($_POST['date_sale']); // YYYY-MM-DD (จะถูก override ถ้ามี sale_neat)
}
if (isset($_POST['date_research']) && clean_text($_POST['date_research']) !== '') {
  $incoming['date_research'] = clean_text($_POST['date_research']); // YYYY-MM-DD
}

/* ===== เกรด ===== */
$form_grade = '';
if (isset($_POST['grade']) && clean_text($_POST['grade']) !== '') {
  $form_grade = clean_text($_POST['grade']);
  $incoming['grade'] = $form_grade;
}

/* =========================
  Flags: ใช้กำหนดวันที่/ฟิลด์พิเศษตามเงื่อนไข
========================= */
$has_sale_neat    = false;
$has_product_good = false;
$has_cus_1        = false;

/* ===== ส่วนที่ 1: พนักงานขาย ===== */
if (isset($_POST['sale_neat'])) {
  $v = clean_int_1_5($_POST['sale_neat']);
  if ($v !== null) { $incoming['sale_neat'] = $v; $has_sale_neat = true; }
}
if (isset($_POST['sale_data'])) {
  $v = clean_int_1_5($_POST['sale_data']);
  if ($v !== null) $incoming['sale_data'] = $v;
}
if (isset($_POST['sale_3'])) {
  $v = clean_int_1_5($_POST['sale_3']);
  if ($v !== null) $incoming['sale_3'] = $v;
}
if (isset($_POST['suggest']) && clean_text($_POST['suggest']) !== '') {
  $incoming['suggest'] = clean_text($_POST['suggest']);
}

/* ===== ส่วนที่ 2: สินค้า ===== */
if (isset($_POST['product_good'])) {
  $v = clean_int_1_5($_POST['product_good']);
  if ($v !== null) { $incoming['product_good'] = $v; $has_product_good = true; }
}
if (isset($_POST['product_link'])) {
  $v = clean_int_1_5($_POST['product_link']);
  if ($v !== null) $incoming['product_link'] = $v;
}
if (isset($_POST['suggest_1']) && clean_text($_POST['suggest_1']) !== '') {
  $incoming['suggest_1'] = clean_text($_POST['suggest_1']);
}

/* ===== ส่วนที่ 3: จัดส่ง ===== */
if (isset($_POST['cs_neat'])) {
  $v = clean_int_1_5($_POST['cs_neat']);
  if ($v !== null) $incoming['cs_neat'] = $v;
}
if (isset($_POST['cs_explain'])) {
  $v = clean_int_1_5($_POST['cs_explain']);
  if ($v !== null) $incoming['cs_explain'] = $v;
}
if (isset($_POST['cs_3'])) {
  $v = clean_int_1_5($_POST['cs_3']);
  if ($v !== null) $incoming['cs_3'] = $v;
}
if (isset($_POST['suggest_2']) && clean_text($_POST['suggest_2']) !== '') {
  $incoming['suggest_2'] = clean_text($_POST['suggest_2']);
}

/* ===== ส่วนที่ 4: NPS ===== */
if (isset($_POST['cus_1'])) {
  $v = clean_int_1_5($_POST['cus_1']);
  if ($v !== null) { $incoming['cus_1'] = $v; $has_cus_1 = true; }
}
if (isset($_POST['suggest_cus']) && clean_text($_POST['suggest_cus']) !== '') {
  $incoming['suggest_cus'] = clean_text($_POST['suggest_cus']);
}

/* =========================
  เงื่อนไขอัพเดตวันที่อัตโนมัติ
========================= */
if ($has_sale_neat) {
  $incoming['date_sale'] = $now_date;
}
if ($has_product_good) {
  $incoming['product_date'] = $now_date;
}
if ($has_cus_1) {
  $incoming['cust_date'] = $now_date;
}

/* ถ้าไม่มีอะไรส่งมาเลย (นอกจาก ref_id) */
if (count($incoming) === 0) {
  echo "<script>alert('ไม่มีข้อมูลใหม่สำหรับบันทึก');history.back();</script>";
  exit;
}

/* =========================
  Target table: tb_research (บน $com1)
  key: red_id = $ref_id
========================= */
$red_id = $ref_id;

/* เช็คมี record อยู่แล้วไหม */
$exists = false;
$chk = mysqli_prepare($com1, "SELECT red_id FROM tb_research WHERE red_id = ? LIMIT 1");
mysqli_stmt_bind_param($chk, "s", $red_id);
mysqli_stmt_execute($chk);
mysqli_stmt_store_result($chk);
$exists = (mysqli_stmt_num_rows($chk) > 0);
mysqli_stmt_close($chk);

mysqli_begin_transaction($com1);

try {

  if ($exists) {
    /* ========= UPDATE ========= */
    $incoming['add_by1']   = $add_by;
    $incoming['add_date1'] = $add_date;

    $setParts = [];
    $types = "";
    $params = [];

    foreach ($incoming as $col => $val) {
      $setParts[] = "`$col` = ?";
      $types .= (is_int($val) ? "i" : "s");
      $params[] = $val;
    }

    $sql = "UPDATE tb_research SET ".implode(", ", $setParts)." WHERE red_id = ?";
    $types .= "s";
    $params[] = $red_id;

    $stmt = mysqli_prepare($com1, $sql);
    if (!$stmt) throw new Exception(mysqli_error($com1));

    mysqli_stmt_bind_param($stmt, $types, ...$params);
    if (!mysqli_stmt_execute($stmt)) throw new Exception(mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);

  } else {
    /* ========= INSERT ========= */
    $incoming['add_by']    = $add_by;
    $incoming['add_date']  = $add_date;
    $incoming['add_by1']   = $add_by;
    $incoming['add_date1'] = $add_date;

    $cols = ["red_id"];
    $placeholders = ["?"];
    $types = "s";
    $params = [$red_id];

    foreach ($incoming as $col => $val) {
      $cols[] = "`$col`";
      $placeholders[] = "?";
      $types .= (is_int($val) ? "i" : "s");
      $params[] = $val;
    }

    $sql = "INSERT INTO tb_research (".implode(",", $cols).") VALUES (".implode(",", $placeholders).")";
    $stmt = mysqli_prepare($com1, $sql);
    if (!$stmt) throw new Exception(mysqli_error($com1));

    mysqli_stmt_bind_param($stmt, $types, ...$params);
    if (!mysqli_stmt_execute($stmt)) throw new Exception(mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
  }

  mysqli_commit($com1);

  /* =========================
     Redirect Logic
  ========================= */
  //$target = "research_010369.php?ref_id=".htmlspecialchars($ref_id, ENT_QUOTES, 'UTF-8');

  if ($form_grade === 'B') {
    // ตามที่ขอ: เด้งไปหน้า status_researchk_sol
$target = "status_researchk_sol.php";
	  
  } else {
	  
$save2="Update  hos__so set  close_reseach='1'  where ref_id='".$ref_id."'";
$qsave2=mysqli_query($conn,$save2);	  
	  
    if ($type_login === 'Sale') {
      $target = "status_saleresearch.php";
    } else if ($type_login === 'Sup_Sale') {
      $target = "status_supresearch.php";
    }
  }

  echo "<script language=\"JavaScript\">";
  echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='".$target."';";
  echo "</script>";
  exit;

} catch (Exception $e) {
  mysqli_rollback($com1);
  echo "<script>alert('บันทึกไม่สำเร็จ: ".htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')."');history.back();</script>";
  exit;
}
?>