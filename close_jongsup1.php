<?php
include "dbconnect.php";

header('Content-Type: application/json; charset=utf-8');

$ref_id = isset($_GET["ref_id"]) ? mysqli_real_escape_string($conn, $_GET["ref_id"]) : "";

if ($ref_id == "") {
	echo json_encode(array('success' => false, 'message' => 'ไม่พบเลขที่อ้างอิงใบจอง'));
	exit();
}

$qcheck = mysqli_query($conn, "SELECT cancel_ckk FROM hos__jongproduct WHERE ref_id = '" . $ref_id . "'");
$row = $qcheck ? mysqli_fetch_array($qcheck) : null;

if (!$row) {
	echo json_encode(array('success' => false, 'message' => 'ไม่พบใบจองนี้'));
	exit();
}

if ($row["cancel_ckk"] == '1') {
	echo json_encode(array('success' => false, 'message' => 'ใบจองนี้ถูกยกเลิกแล้ว ไม่สามารถปิดได้'));
	exit();
}

$save  = "UPDATE hos__jongproduct SET close_jong = '1' WHERE ref_id = '" . $ref_id . "' AND cancel_ckk = '0'";
$qsave = mysqli_query($conn, $save);

$save1 = "UPDATE hos__subjongpro SET close_ckk = '1' WHERE ref_idd = '" . $ref_id . "'";
mysqli_query($conn, $save1);

if ($qsave) {
	echo json_encode(array('success' => true, 'message' => 'ปิดใบจองเรียบร้อยแล้ว'));
} else {
	echo json_encode(array('success' => false, 'message' => 'ไม่สามารถปิดใบจองได้'));
}
