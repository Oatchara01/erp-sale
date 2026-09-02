<?php
// Router สำหรับปุ่ม "Save Draft"/"Update" ของ register_suprental.php — เลือก include
// register_suprental1.php (สร้างใหม่) หรือ register_suprental_edit1.php (แก้ไขของเดิม)
// ตามว่า ref_id ที่โพสต์มามีแถวอยู่ใน hos__rental แล้วหรือยัง — มิเรอร์ register_supchange_draft1.php ตรงตัว
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include("dbconnect.php");

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

$_POST["is_draft"] = "1";
$_POST["submit"] = "submit";

$refId = trim((string)($_POST["ref_id"] ?? ""));

try {
	if ($refId !== "") {
		$safeRefId = mysqli_real_escape_string($conn, $refId);
		$draftQuery = mysqli_query($conn, "SELECT status_doc FROM hos__rental WHERE ref_id = '" . $safeRefId . "' LIMIT 1");
		if ($draftQuery && ($draftRow = mysqli_fetch_assoc($draftQuery))) {
			// ปุ่ม Save Draft/Update ใช้ได้จนกว่าเอกสารจะจบ (Draft/Request ยังแก้ได้)
			// ปฏิเสธเฉพาะเอกสารที่ปิดแล้วเท่านั้น (ยกเลิก/Approve) — เหมือน register_supchange_draft1.php
			$draftStatus = $draftRow["status_doc"] ?? "";
			if (in_array($draftStatus, array("ยกเลิก", "Approve"), true)) {
				echo json_encode(array(
					'success' => false,
					'message' => 'เอกสารนี้ปิดแล้ว ไม่สามารถแก้ไขได้'
				));
				exit();
			}

			if (file_exists("register_suprental_edit1.php")) {
				include("register_suprental_edit1.php");
			} else {
				include("register_suprental1.php");
			}
			exit();
		}
	}

	include("register_suprental1.php");
} catch (Throwable $e) {
	echo json_encode(array(
		'success' => false,
		'message' => 'Exception: ' . $e->getMessage()
	));
	exit();
}
