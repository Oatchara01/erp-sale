<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("dbconnect.php");

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

$_POST["is_draft"] = "1";
$_POST["submit"] = "submit";

$refId = trim((string)($_POST["ref_id_br"] ?? ""));

try {
	if ($refId !== "") {
		$safeRefId = mysqli_real_escape_string($conn, $refId);
		$draftQuery = mysqli_query($conn, "SELECT status_doc FROM hos__br WHERE ref_id_br = '" . $safeRefId . "' LIMIT 1");
		if ($draftQuery && ($draftRow = mysqli_fetch_assoc($draftQuery))) {
			$draftStatusDoc = $draftRow["status_doc"] ?? "";
			$isFinalState = in_array($draftStatusDoc, ['Approve', 'ยกเลิก', 'Rejected'], true);

			if (!$isFinalState) {
				include("register_supbrhos_edit1.php");
				exit();
			}

			$isAdminLimitedUpdate = (($_POST['admin_limited_update'] ?? '') === '1');
			// BR ใช้ role 'It' เป็นตัวเปิดแท็บ Admin (ต่างจาก SO ที่ใช้ 'Admin')
			$isAdminUser = (($_SESSION['type_login'] ?? '') === 'It');

			if ($isAdminLimitedUpdate && $isAdminUser) {
				// เอกสารจบแล้ว: จำกัดให้ Admin แก้ได้เฉพาะเลขที่/วันที่เอกสาร (และเลขงาน/หมายเหตุยกเลิก ถ้ามี)
				// ไม่ผ่าน register_supbrhos_edit1.php เพื่อไม่ให้แตะสถานะ/ข้อมูลอื่นของเอกสารที่ปิดแล้ว
				$adminLimitedFieldMap = array(
					'admin_doc_no' => 'iv_no',
					'admin_work_no' => 'job_no',
					'admin_doc_date' => 'iv_date',
					'admin_cancel_reason' => 'remark_cancel',
				);

				foreach ($adminLimitedFieldMap as $postField => $columnName) {
					if (!isset($_POST[$postField])) {
						continue;
					}
					$value = trim((string)$_POST[$postField]);
					if ($postField === 'admin_doc_date') {
						if ($value === '') {
							continue;
						}
						if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
							$year = (int)$matches[3];
							if ($year > 2400) {
								$year -= 543;
							}
							$value = sprintf('%04d-%02d-%02d', $year, (int)$matches[2], (int)$matches[1]);
						}
					} elseif ($value === '') {
						continue;
					}

					$safeColumn = mysqli_real_escape_string($conn, $columnName);
					$columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM hos__br LIKE '" . $safeColumn . "'");
					if (!$columnCheck || mysqli_num_rows($columnCheck) == 0) {
						continue;
					}
					$safeValue = mysqli_real_escape_string($conn, $value);
					mysqli_query($conn, "UPDATE hos__br SET " . $safeColumn . " = '" . $safeValue . "' WHERE ref_id_br = '" . $safeRefId . "'");
				}

				echo json_encode(array(
					'success' => true,
					'ref_id' => $refId
				));
				exit();
			}

			echo json_encode(array(
				'success' => false,
				'message' => 'Closed documents cannot be updated'
			));
			exit();
		}
	}

	include("register_supbrhos1.php");
} catch (Throwable $e) {
	echo json_encode(array(
		'success' => false,
		'message' => 'Exception: ' . $e->getMessage()
	));
	exit();
}
