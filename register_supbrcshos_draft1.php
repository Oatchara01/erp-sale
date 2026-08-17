<?php
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
		$draftQuery = mysqli_query($conn, "SELECT status_doc FROM hos__consig WHERE ref_id = '" . $safeRefId . "' LIMIT 1");
		if ($draftQuery && ($draftRow = mysqli_fetch_assoc($draftQuery))) {
			// ปุ่ม Save Draft/Update ใช้ได้จนกว่าเอกสารจะจบ (Draft/Request/Returned ยังแก้ได้)
			// ปฏิเสธเฉพาะเอกสารที่ปิดแล้วเท่านั้น — เหมือน register_suphos_draft1.php
			$draftStatus = $draftRow["status_doc"] ?? "";
			if (in_array($draftStatus, array("Approve", "ยกเลิก", "Rejected"), true)) {
				echo json_encode(array(
					'success' => false,
					'message' => 'เอกสารนี้ปิดแล้ว ไม่สามารถแก้ไขได้'
				));
				exit();
			}

			if (file_exists("register_supbrcshos_edit1.php")) {
				include("register_supbrcshos_edit1.php");
			} else {
				include("register_supbrcshos1.php");
			}
			exit();
		}
	}

	include("register_supbrcshos1.php");
} catch (Throwable $e) {
	echo json_encode(array(
		'success' => false,
		'message' => 'Exception: ' . $e->getMessage()
	));
	exit();
}
