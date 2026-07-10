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
		$draftQuery = mysqli_query($conn, "SELECT status_doc FROM hos__jongproduct WHERE ref_id = '" . $safeRefId . "' LIMIT 1");
		if ($draftQuery && ($draftRow = mysqli_fetch_assoc($draftQuery))) {
			if (($draftRow["status_doc"] ?? "") === "Draft") {
				include("register_supbook_edit1.php");
				exit();
			}

			echo json_encode(array(
				'success' => false,
				'message' => 'Only Draft documents can be updated with Save Draft'
			));
			exit();
		}
	}

	include("register_supbook1.php");
} catch (Throwable $e) {
	echo json_encode(array(
		'success' => false,
		'message' => 'Exception: ' . $e->getMessage()
	));
	exit();
}
