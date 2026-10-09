<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include("dbconnect.php");
require_once __DIR__ . '/includes/so_cs_send.php';

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

$_POST["is_draft"] = "1";
$_POST["submit"] = "submit";

$refId = trim((string)($_POST["ref_id"] ?? ""));

try {
	if ($refId !== "") {
		$safeRefId = mysqli_real_escape_string($conn, $refId);
		$draftQuery = mysqli_query($conn, "SELECT status_doc, send_cm FROM hos__so WHERE ref_id = '" . $safeRefId . "' LIMIT 1");
		if ($draftQuery && ($draftRow = mysqli_fetch_assoc($draftQuery))) {
			$draftStatusDoc = $draftRow["status_doc"] ?? "";
			$isFinalState = in_array($draftStatusDoc, ['Approve', 'ยกเลิก', 'Rejected'], true);

			if (!$isFinalState) {
				include("register_suphos_edit1.php");
				exit();
			}

			$isAdminLimitedUpdate = (($_POST['admin_limited_update'] ?? '') === '1');
			$isAdminUser = (($_SESSION['type_login'] ?? '') === 'Admin');

			if ($isAdminLimitedUpdate && $isAdminUser) {
				// เอกสารจบแล้ว: จำกัดให้ Admin แก้ได้เฉพาะเลขที่/วันที่เอกสาร (และเลขงาน/SR/มัดจำ ถ้ามี)
				// ที่ปุ่ม "Run เอกสาร" เพิ่งออกค้างไว้บนฟอร์ม ไม่ผ่าน register_suphos_edit1.php เพื่อไม่ให้
				// แตะสถานะ/ยอดขาย/ลูกค้า/สินค้าของเอกสารที่ปิดแล้ว
				$adminLimitedFieldMap = array(
					'admin_doc_no' => 'iv_no',
					'admin_work_no' => 'job_no',
					'admin_sr_no' => 'sr_no',
					'admin_deposit_no' => 'order_no',
					'admin_doc_date' => 'iv_date',
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
					$columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM hos__so LIKE '" . $safeColumn . "'");
					if (!$columnCheck || mysqli_num_rows($columnCheck) == 0) {
						continue;
					}
					$safeValue = mysqli_real_escape_string($conn, $value);
					mysqli_query($conn, "UPDATE hos__so SET " . $safeColumn . " = '" . $safeValue . "' WHERE ref_id = '" . $safeRefId . "'");
				}

				// เอกสารที่อนุมัติแล้วส่งเข้าระบบ CS ได้จากปุ่มนี้ (จังหวะเดียวกับหน้า Admin เดิม) ใบงานสร้างจากข้อมูลที่บันทึกไว้
				// ในฐาน ไม่ใช่จากฟอร์ม — เอกสารที่ยกเลิก/ไม่อนุมัติถูกข้ามใน so_cs_send_sales_order() เอง
				$limitedCsResult = null;
				if (so_cs_send_requested($_POST)) {
					$limitedCsResult = so_cs_send_sales_order($conn, $refId, $_SESSION);
				}

				echo json_encode(array_merge(array(
					'success' => true,
					'ref_id' => $refId
				), so_cs_json_fields($limitedCsResult)));
				exit();
			}

			echo json_encode(array(
				'success' => false,
				'message' => 'Closed documents cannot be updated'
			));
			exit();
		}
	}

	include("register_suphos1.php");
} catch (Throwable $e) {
	echo json_encode(array(
		'success' => false,
		'message' => 'Exception: ' . $e->getMessage()
	));
	exit();
}
