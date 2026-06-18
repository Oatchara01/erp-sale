<?php
include "dbconnect_cs.php"; // หรือ dbconnect.php ตามที่ tb_research อยู่จริง
header('Content-Type: application/json; charset=utf-8');

$ref_id = isset($_GET['ref_id']) ? trim($_GET['ref_id']) : '';
if($ref_id === ''){
  echo json_encode(['ok'=>0,'msg'=>'no ref_id']);
  exit;
}

$ref_id_esc = mysqli_real_escape_string($com1, $ref_id);

// tb_research ของคุณใช้ red_id เป็น ref id (คุณเคยบอกไว้) ให้ใช้ red_id
$sql = "SELECT out_ckk, delivery_id FROM tb_research WHERE red_id = '{$ref_id_esc}' LIMIT 1";
$q = mysqli_query($com1, $sql);

if($q && ($row = mysqli_fetch_assoc($q))){
  echo json_encode([
    'ok' => 1,
    'out_ckk' => (int)($row['out_ckk'] ?? 0),
    'delivery_id' => (string)($row['delivery_id'] ?? '')
  ]);
} else {
  // ไม่มีแถว = ยังไม่เคยบันทึก
  echo json_encode(['ok'=>1,'out_ckk'=>0,'delivery_id'=>'']);
}