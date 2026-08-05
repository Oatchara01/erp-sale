<?php
// คืนค่าเลขที่ลดหนี้ถัดไป (SR + ปีพ.ศ.2หลัก + เดือน + running 4 หลัก)
// ใช้อัลกอริทึมเดียวกับที่ register_credinot.php / register_credinot1.php ใช้สร้าง ref_credit
include('dbconnect.php');

header('Content-Type: application/json; charset=utf-8');

date_default_timezone_set("Asia/Bangkok");

$yearMonth = substr(date("Y") + 543, -2) . date("m");

$sql = "SELECT MAX(ref_credit) AS MAXID FROM tb_credit_note";
$qry = mysqli_query($conn, $sql);
if (!$qry) {
    http_response_code(500);
    echo json_encode(array('error' => 'query failed'));
    exit;
}
$rs = mysqli_fetch_assoc($qry);

$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'], -8);
$maxId1 = substr($maxId3, 0, -4);

if ($maxId1 == $yearMonth) {
    $maxId1 = ($maxId + 1);
    $maxId2 = substr("00000" . $maxId1, -4);
    $nextId = $yearMonth . $maxId2;
} else {
    $nextId = $yearMonth . "0001";
}

echo json_encode(array('credit_no' => 'SR' . $nextId));
