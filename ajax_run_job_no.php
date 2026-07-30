<?php

/**
 * ออกเลขที่ลงงานให้ปุ่ม "Run ลงงาน" (แท็บ Admin ของ register_suphos.php)
 *
 * รูปแบบเลข: ปี พ.ศ. 2 หลัก + เดือน 2 หลัก + running 4 หลัก  เช่น 69070001
 * running รีเซ็ตเป็น 0001 ทุกเดือน ตรงกับรูปแบบเดิมของ register_adminhos_edit1.php:2557-2593
 * และตรงกับข้อมูลจริงใน hos__so.job_no (ยาว 8 หลักทั้งหมด)
 *
 * ตัวนับคือ tb_register_data.running ตารางเดียวกับระบบเดิม เพื่อไม่ให้สองหน้าจอออกเลขซ้ำกัน
 *
 * หมายเหตุ connection: ระบบเดิมยิง query ตัวนับผ่าน $com1 (dbconnect_cs.php -> invoice_receipt)
 * แต่ invoice_receipt.tb_register_data ไม่มีคอลัมน์ running (มีเฉพาะใน allwell_sol_test)
 * โค้ดเดิมจึงตายที่ or die() ทุกครั้ง ไฟล์นี้ใช้ $conn (allwell_sol_test) ซึ่งเป็นที่อยู่จริงของคอลัมน์
 *
 * เลขถูกจองทันทีที่กดปุ่ม (INSERT แถวเปล่าที่มี running) ไม่ใช่แค่ preview เพื่อให้เลขไม่ซ้ำ
 * แลกกับการที่ถ้ากด Run แล้วไม่บันทึกฟอร์ม เลขนั้นจะหายไปเป็นช่องว่าง — เหมือน ajax_run_doc_no.php
 * แถวที่จองไว้จะถูกเติมข้อมูลจริงภายหลังโดย register_adminhos_edit1.php:2522 (UPDATE ... WHERE running = job_no)
 */

header('Content-Type: application/json; charset=utf-8');
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function run_job_no_fail($message, $statusCode = 400)
{
	http_response_code($statusCode);
	echo json_encode([
		'success' => false,
		'message' => $message
	], JSON_UNESCAPED_UNICODE);
	exit;
}

if (empty($_SESSION['UserID'])) {
	run_job_no_fail('กรุณาเข้าสู่ระบบใหม่', 401);
}

require_once 'dbconnect.php'; // $conn -> allwell_sol_test (ฐานเดียวกับ hos__so และ tb_register_data.running)

set_exception_handler(function ($error) {
	error_log('Run job no error: ' . $error->getMessage());
	run_job_no_fail('เกิดข้อผิดพลาดระหว่างออกเลขที่ลงงาน กรุณาลองใหม่อีกครั้ง', 500);
});

$refId = trim((string)($_POST['ref_id'] ?? ''));
if ($refId !== '' && !preg_match('/^[A-Za-z0-9\-\/]{1,20}$/', $refId)) {
	run_job_no_fail('รหัสอ้างอิงเอกสารไม่ถูกต้อง');
}

// ปี/เดือนของเลขอิงวันที่ลงงานถ้าผู้ใช้กรอกไว้ ไม่งั้นใช้วันที่ปัจจุบัน
date_default_timezone_set('Asia/Bangkok');
$timestamp = time();
$jobDate = trim((string)($_POST['job_date'] ?? ''));
if ($jobDate !== '') {
	$parsed = strtotime($jobDate);
	if ($parsed !== false) {
		$timestamp = $parsed;
	}
}
$yearNo    = substr((string)((int)date('Y', $timestamp) + 543), -2);
$monthNo   = date('m', $timestamp);
$yearMonth = $yearNo . $monthNo;
$addDate   = date('Y-m-d H:i:s');
$addBy     = (string)($_SESSION['name'] ?? '');
$addCode   = (string)($_SESSION['code'] ?? '');

// กันสองคนกดพร้อมกันด้วย named lock แทนการเพิ่ม unique index ให้ tb_register_data
// (ตารางเดิมมีไฟล์อื่นเขียนร่วมอีกหลายสิบไฟล์ การใส่ unique index จะทำให้ไฟล์เหล่านั้น
//  fatal error แทนที่จะ insert ซ้ำเงียบ ๆ จึงไม่แตะ schema เดิม)
$lockName = 'jobrun_' . $yearMonth;
$lockStmt = mysqli_prepare($conn, "SELECT GET_LOCK(?, 5) AS got_lock");
mysqli_stmt_bind_param($lockStmt, 's', $lockName);
mysqli_stmt_execute($lockStmt);
$lockResult = mysqli_stmt_get_result($lockStmt);
$lockRow = $lockResult ? mysqli_fetch_assoc($lockResult) : null;
mysqli_stmt_close($lockStmt);

if ((int)($lockRow['got_lock'] ?? 0) !== 1) {
	run_job_no_fail('ระบบกำลังออกเลขที่ลงงานให้ผู้ใช้รายอื่น กรุณาลองใหม่อีกครั้ง', 409);
}

// ปล่อย lock ให้ได้ทุกเส้นทางที่จบ request รวมถึงตอน run_job_no_fail() เรียก exit
register_shutdown_function(function () use ($conn, $lockName) {
	$releaseStmt = @mysqli_prepare($conn, "SELECT RELEASE_LOCK(?)");
	if ($releaseStmt) {
		mysqli_stmt_bind_param($releaseStmt, 's', $lockName);
		@mysqli_stmt_execute($releaseStmt);
		mysqli_stmt_close($releaseStmt);
	}
});

// นับเฉพาะเลขที่อยู่ในรูปแบบ 8 หลักของเดือนนี้ แล้ว CAST ท้าย 4 หลักเป็นตัวเลข
// ระบบเดิมใช้ MAX(running) ทั้งตารางแบบ string ซึ่งจะเพี้ยนถ้ามีค่าขยะความยาวอื่นปน
// (hos__so.job_no ปัจจุบันมีค่ายาว 9-10 หลักหลุดอยู่จริง 36 แถว)
$selectSql = "SELECT MAX(CAST(SUBSTRING(running, 5, 4) AS UNSIGNED)) AS max_run
              FROM tb_register_data
              WHERE running REGEXP '^[0-9]{8}$' AND LEFT(running, 4) = ?";

// เติมทุกคอลัมน์ที่เป็น NOT NULL และไม่มี DEFAULT เพื่อให้ INSERT ผ่านแม้เปิด strict mode
$insertSql = "INSERT INTO tb_register_data
              (running, ref_id, add_by, add_code, add_date, address_1, bus_inter, cb_send,
               count_box, edit_by, edit_name, edit_date, mk_research, on_time)
              VALUES (?, ?, ?, ?, ?, '', 0, 0, 0, '', '', ?, 0, 0)";

$maxAttempts = 5;

for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
	$selectStmt = mysqli_prepare($conn, $selectSql);
	mysqli_stmt_bind_param($selectStmt, 's', $yearMonth);
	mysqli_stmt_execute($selectStmt);
	$selectResult = mysqli_stmt_get_result($selectStmt);
	$maxRow = $selectResult ? mysqli_fetch_assoc($selectResult) : null;
	mysqli_stmt_close($selectStmt);

	$runNo = (int)($maxRow['max_run'] ?? 0) + 1;
	if ($runNo > 9999) {
		run_job_no_fail('เลขที่ลงงานของเดือนนี้เต็มแล้ว (เกิน 9999) กรุณาติดต่อผู้ดูแลระบบ', 409);
	}
	$runNoText = substr('0000' . $runNo, -4);
	$jobNo = $yearMonth . $runNoText;

	try {
		$insertStmt = mysqli_prepare($conn, $insertSql);
		mysqli_stmt_bind_param($insertStmt, 'ssssss', $jobNo, $refId, $addBy, $addCode, $addDate, $addDate);
		mysqli_stmt_execute($insertStmt);
		mysqli_stmt_close($insertStmt);

		echo json_encode([
			'success'  => true,
			'job_no'   => $jobNo,
			'run_no'   => $runNoText,
			'year_no'  => $yearNo,
			'mount_no' => $monthNo
		], JSON_UNESCAPED_UNICODE);
		exit;
	} catch (mysqli_sql_exception $e) {
		if ($e->getCode() == 1062) {
			continue; // เลขชนกัน ลองรอบถัดไปด้วยเลขใหม่
		}
		throw $e;
	}
}

run_job_no_fail('ไม่สามารถออกเลขที่ลงงานได้ (เลขชนกันเกิน ' . $maxAttempts . ' ครั้ง) กรุณาลองใหม่อีกครั้ง', 409);
