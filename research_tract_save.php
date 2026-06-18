<?php
session_start();
include "dbconnect_cs.php";   // tb_research -> $com1
include "dbconnect.php";      // (ถ้าต้องใช้ $conn ที่อื่น) ไม่ใช้ก็ได้

date_default_timezone_set("Asia/Bangkok");

$surname = $_SESSION['surname'] ?? '';
$name    = $_SESSION['name'] ?? '';
$add_by  = trim($name . " " . $surname);

$ref_id      = isset($_POST['ref_id']) ? trim($_POST['ref_id']) : '';
$out_ckk     = isset($_POST['out_ckk']) ? 1 : 0;
$delivery_id = isset($_POST['delivery_id']) ? trim($_POST['delivery_id']) : '';

if($ref_id === ''){
  die("no ref_id");
}

// ✅ escape ด้วย connection ที่ถูกต้อง (tb_research อยู่ $com1)
$ref_id_esc = mysqli_real_escape_string($com1, $ref_id);
$add_by_esc = mysqli_real_escape_string($com1, $add_by);

// delivery_id อนุญาตให้ว่างได้ ถ้าไม่ติ๊ก out_ckk
$delivery_id_esc = mysqli_real_escape_string($com1, $delivery_id);

// ถ้าไม่ติ๊ก out_ckk ให้เคลียร์ delivery_id
if($out_ckk != 1){
  $delivery_id_esc = '';
}

// 1) เช็คว่ามี record อยู่แล้วไหม
$chkSql = "SELECT red_id FROM tb_research WHERE red_id = '{$ref_id_esc}' LIMIT 1";
$chkQry = mysqli_query($com1, $chkSql) or die(mysqli_error($com1));

if(mysqli_num_rows($chkQry) > 0){
  // 2) UPDATE
  $sql = "
    UPDATE tb_research
    SET out_ckk = '{$out_ckk}',
        delivery_id = '{$delivery_id_esc}',
        ship_out_dt = NOW(),
        ship_name = '{$add_by_esc}'
    WHERE red_id = '{$ref_id_esc}'
  ";
  mysqli_query($com1, $sql) or die(mysqli_error($com1));
} else {
  // 3) INSERT (กรณียังไม่เคยมี record)
  $sql = "
    INSERT INTO tb_research (red_id, out_ckk, delivery_id, ship_out_dt, ship_name)
    VALUES ('{$ref_id_esc}', '{$out_ckk}', '{$delivery_id_esc}', NOW(), '{$add_by_esc}')
  ";
  mysqli_query($com1, $sql) or die(mysqli_error($com1));
}

header("Location: ".$_SERVER['HTTP_REFERER']);
exit;