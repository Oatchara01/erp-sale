<?php

/**
 * ออกเลขที่เอกสารให้ปุ่ม "Run เอกสาร" (แท็บ Admin ของ register_suphos.php)
 *
 * รูปแบบเลข: PREFIX + ปี พ.ศ. 2 หลัก + เดือน 2 หลัก + running 4 หลัก
 *   AWL (company = 3) : IV69070001
 *   NBM (company = 4) : IV69/070001   <- คั่นระหว่างปีกับเดือน
 *                       ET69-070001   <- ยกเว้น ET ที่ใช้ "-" ตามระบบเดิม
 * running รีเซ็ตเป็น 0001 ทุกเดือน แยกตามบริษัท + ประเภทเอกสาร
 *
 * ไฟล์นี้มีสองโหมดการนับ
 *
 * 1) โหมดตารางตัวนับ ($docRouting) — IV/ET/IC/IE
 *    ใช้ "ตารางเดียวกับระบบเดิม" (register_adminhos_edit1.php:243-399)
 *    เพราะรูปแบบเลขเหมือนกันเป๊ะ ถ้านับแยกตารางสองหน้าจอจะออกเลขซ้ำกันจริง
 *    เลขถูกจองทันทีที่กดปุ่ม (INSERT เลย) ไม่ใช่แค่ preview เพื่อให้เลขไม่ซ้ำ
 *    แลกกับการที่ถ้ากด Run แล้วไม่บันทึกฟอร์ม เลขนั้นจะหายไปเป็นช่องว่าง
 *
 * 2) โหมดนับจากตารางเอกสารจริง ($docSourceTable) — BRSC
 *    BRSC69080001 -> BRSC6908001   <- ซีรีส์เดียวทั้ง AWL/NBM ไม่มีตัวคั่น running 3 หลัก
 *    ไม่มี INSERT จองเลข อ่าน MAX จากคอลัมน์เลขที่เอกสารในตารางเอกสารโดยตรง
 *    เลขจึงถูกจองจริงตอนกดบันทึกเอกสาร (กันเลขซ้ำอีกชั้นที่ register_supbrcshos1.php
 *    และ register_supbrcshos_edit1.php) และการกด Run ซ้ำก่อนบันทึกจะได้เลขเดิมเสมอ
 */

header('Content-Type: application/json; charset=utf-8');
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function run_doc_no_fail($message, $statusCode = 400)
{
	http_response_code($statusCode);
	echo json_encode([
		'success' => false,
		'message' => $message
	], JSON_UNESCAPED_UNICODE);
	exit;
}

if (empty($_SESSION['UserID'])) {
	run_doc_no_fail('กรุณาเข้าสู่ระบบใหม่', 401);
}

require_once 'dbconnect.php'; // $conn -> allwell_sol_test (ฐานเดียวกับ hos__so และตารางตัวนับ)

set_exception_handler(function ($error) {
	error_log('Run doc no error: ' . $error->getMessage());
	run_doc_no_fail('เกิดข้อผิดพลาดระหว่างออกเลขที่เอกสาร กรุณาลองใหม่อีกครั้ง', 500);
});

// map ฝั่ง server เพื่อไม่ให้ client ส่ง prefix เข้ามาเองได้
// key = value ของ <select id="doc_type_select"> ใน register_suphos.php
$docTypePrefix = [
	'1' => 'IV', // ใบสั่งขาย
	'2' => 'ET', // ใบสั่งขาย E-Tax
	'3' => 'IC', // ใบฝากขาย (IC)
	'4' => 'IE', // ใบกำกับอิเล็กทรอนิกส์ - Admin เท่านั้น
	'5' => 'BRSC', // ใบยืม/หนี้ฝากขาย (register_supbrcshos.php) - เอกสารประเภทเดียวของหน้านั้น
];
$adminOnlyPrefix = ['IE'];

// ตารางตัวนับและตัวคั่นของ NBM แยกตามประเภท
// key ชั้นสอง = value ของ <select id="type_doc_select"> และตรงกับ hos__so.type_doc
// ชื่อตารางมาจาก whitelist นี้เท่านั้น จึงนำไปต่อใน SQL ได้อย่างปลอดภัย
$docRouting = [
	'IV'   => ['3' => ['tb_iv_awl', ''],  '4' => ['tb_iv_nbm', '/']],
	'ET'   => ['3' => ['tb_et_awl', ''],  '4' => ['tb_et_nbm', '-']], // NBM ใช้ "-" ตามระบบเดิม ไม่ใช่ "/"
	'IC'   => ['3' => ['tb_ic_awl', ''],  '4' => ['tb_ic_nbm', '/']],
	'IE'   => ['3' => ['tb_doc_ptl', ''], '4' => ['tb_doc_nbm', '/']],
];

// เอกสารที่นับเลขจาก "คอลัมน์ในตารางเอกสารจริง" แทนตารางตัวนับแยก
// BRSC ไม่เคยมีตารางตัวนับในระบบเดิม (ผู้ใช้พิมพ์เลขเองมาตลอด) เลขจริงทั้งหมดอยู่ใน
// hos__consig.iv_no แล้ว ถ้าไปนับจากตารางตัวนับใหม่ที่ว่างเปล่าจะไม่รู้จักเลขเดิม
// และออกเลขซ้ำกับใบที่พิมพ์เองไว้ได้
// เป็นซีรีส์เดียวทั้ง AWL/NBM ไม่มีตัวคั่น running 3 หลัก ตามรูปแบบเลขเดิมทั้ง 209 ใบ
// ชื่อตาราง/คอลัมน์มาจาก whitelist นี้เท่านั้น จึงนำไปต่อใน SQL ได้อย่างปลอดภัย
$docSourceTable = [
	'BRSC' => [
		'table'     => 'hos__consig',
		'column'    => 'iv_no',
		'companies' => ['3', '4'],
		'separator' => '',
		'pad'       => 3,
	],
];

$company = trim((string)($_POST['company'] ?? ''));
$docType = trim((string)($_POST['doc_type'] ?? ''));
$docDate = trim((string)($_POST['doc_date'] ?? ''));

if (!isset($docTypePrefix[$docType])) {
	run_doc_no_fail('กรุณาเลือกประเภทเอกสารก่อนออกเลขที่เอกสาร');
}
$prefix = $docTypePrefix[$docType];

$sourceConfig = $docSourceTable[$prefix] ?? null;
$isSourceTableMode = ($sourceConfig !== null);

if ($isSourceTableMode) {
	if (!in_array($company, $sourceConfig['companies'], true)) {
		run_doc_no_fail('กรุณาเลือกบริษัทก่อนออกเลขที่เอกสาร');
	}
	$table     = $sourceConfig['table'];
	$column    = $sourceConfig['column'];
	$separator = $sourceConfig['separator'];
	$runPad    = $sourceConfig['pad'];
} else {
	if (!isset($docRouting[$prefix][$company])) {
		run_doc_no_fail('กรุณาเลือกบริษัทก่อนออกเลขที่เอกสาร');
	}
	list($table, $separator) = $docRouting[$prefix][$company];
	$column = 'run_no';
	$runPad = 4;
}

$isAdmin = (($_SESSION['type_login'] ?? '') === 'Admin');
if (in_array($prefix, $adminOnlyPrefix, true) && !$isAdmin) {
	run_doc_no_fail('เอกสารประเภทนี้สงวนสิทธิ์ให้ผู้ใช้ Admin เท่านั้น', 403);
}

$tableCheck = mysqli_query($conn, "SHOW TABLES LIKE '" . mysqli_real_escape_string($conn, $table) . "'");
if (!$tableCheck || mysqli_num_rows($tableCheck) === 0) {
	run_doc_no_fail('ยังไม่ได้ติดตั้งตารางเลขที่เอกสาร (' . $table . ') กรุณาติดต่อผู้ดูแลระบบ', 500);
}

// ปี/เดือนของเลขอิงวันที่ออกเอกสารถ้าผู้ใช้กรอกไว้ ไม่งั้นใช้วันที่ปัจจุบัน
date_default_timezone_set('Asia/Bangkok');
$timestamp = time();
if ($docDate !== '') {
	$parsed = strtotime($docDate);
	if ($parsed !== false) {
		$timestamp = $parsed;
	}
}
$yearNo  = substr((string)((int)date('Y', $timestamp) + 543), -2);
$monthNo = date('m', $timestamp);
$ivDate  = date('Y-m-d', $timestamp);

// กันสองคนกดพร้อมกันด้วย named lock แทนการเพิ่ม unique index ให้ตารางเดิม
// (ตารางเดิมมีไฟล์อื่นเขียนร่วมอีกกว่า 30 ไฟล์ การใส่ unique index จะทำให้ไฟล์เหล่านั้น
//  fatal error แทนที่จะ insert ซ้ำเงียบ ๆ จึงไม่แตะ schema เดิม)
// โหมดตารางเอกสารจริงเป็นซีรีส์เดียวทุกบริษัท ชื่อ lock จึงต้องไม่มี $company
// ไม่งั้น AWL กับ NBM กดพร้อมกันจะไม่บล็อกกันและได้เลขเดียวกัน
$lockName = $isSourceTableMode
	? 'docrun_' . $prefix . '_' . $yearNo . $monthNo
	: 'docrun_' . $company . '_' . $prefix . '_' . $yearNo . $monthNo;
$lockStmt = mysqli_prepare($conn, "SELECT GET_LOCK(?, 5) AS got_lock");
mysqli_stmt_bind_param($lockStmt, 's', $lockName);
mysqli_stmt_execute($lockStmt);
$lockResult = mysqli_stmt_get_result($lockStmt);
$lockRow = $lockResult ? mysqli_fetch_assoc($lockResult) : null;
mysqli_stmt_close($lockStmt);

if ((int)($lockRow['got_lock'] ?? 0) !== 1) {
	run_doc_no_fail('ระบบกำลังออกเลขที่เอกสารให้ผู้ใช้รายอื่น กรุณาลองใหม่อีกครั้ง', 409);
}

// ปล่อย lock ให้ได้ทุกเส้นทางที่จบ request รวมถึงตอน run_doc_no_fail() เรียก exit
register_shutdown_function(function () use ($conn, $lockName) {
	$releaseStmt = @mysqli_prepare($conn, "SELECT RELEASE_LOCK(?)");
	if ($releaseStmt) {
		mysqli_stmt_bind_param($releaseStmt, 's', $lockName);
		@mysqli_stmt_execute($releaseStmt);
		mysqli_stmt_close($releaseStmt);
	}
});

// โหมดนับจากตารางเอกสารจริง: ไม่มีคอลัมน์ year_no/mount_no ให้กรอง จึงกรองด้วย prefix ของ
// เลขที่เอกสารเอง (BRSC6908%) แล้วตัดเฉพาะส่วน running มาหา MAX
if ($isSourceTableMode) {
	$docPrefixText = $prefix . $yearNo . $separator . $monthNo;
	$runOffset = strlen($docPrefixText) + 1; // ตำแหน่งเริ่มของ running ในเลขที่เอกสาร
	$likePattern = $docPrefixText . '%';

	$selectStmt = mysqli_prepare(
		$conn,
		"SELECT MAX(CAST(SUBSTRING(`" . $column . "`, " . $runOffset . ") AS UNSIGNED)) AS max_run"
			. " FROM `" . $table . "` WHERE `" . $column . "` LIKE ?"
	);
	mysqli_stmt_bind_param($selectStmt, 's', $likePattern);
	mysqli_stmt_execute($selectStmt);
	$selectResult = mysqli_stmt_get_result($selectStmt);
	$maxRow = $selectResult ? mysqli_fetch_assoc($selectResult) : null;
	mysqli_stmt_close($selectStmt);

	$runNo = (int)($maxRow['max_run'] ?? 0) + 1;
	$runNoText = substr(str_repeat('0', $runPad) . $runNo, -$runPad);
	$docNo = $docPrefixText . $runNoText;

	echo json_encode([
		'success'  => true,
		'doc_no'   => $docNo,
		'run_no'   => $runNoText,
		'doc_type' => $prefix,
		'company'  => $company,
		'year_no'  => $yearNo,
		'mount_no' => $monthNo
	], JSON_UNESCAPED_UNICODE);
	exit;
}

// CAST เป็นตัวเลขก่อนหา MAX เพราะ run_no เป็น varchar และข้อมูลเดิมมี padding ไม่เท่ากัน
// (register_admin1.php:148 เขียน 3 หลักลง tb_doc_ptl ส่วนที่อื่นเขียน 4 หลัก
//  ถ้าเทียบแบบ string จะได้ '005' > '0012' ซึ่งผิด)
$selectSql = "SELECT MAX(CAST(run_no AS UNSIGNED)) AS max_run FROM `" . $table . "` WHERE mount_no = ? AND year_no = ?";
$insertSql = "INSERT INTO `" . $table . "` (doc_no, year_no, mount_no, run_no, iv_date) VALUES (?, ?, ?, ?, ?)";

$maxAttempts = 5;

for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
	$selectStmt = mysqli_prepare($conn, $selectSql);
	mysqli_stmt_bind_param($selectStmt, 'ss', $monthNo, $yearNo);
	mysqli_stmt_execute($selectStmt);
	$selectResult = mysqli_stmt_get_result($selectStmt);
	$maxRow = $selectResult ? mysqli_fetch_assoc($selectResult) : null;
	mysqli_stmt_close($selectStmt);

	$runNo = (int)($maxRow['max_run'] ?? 0) + 1;
	$runNoText = substr(str_repeat('0', $runPad) . $runNo, -$runPad);
	$docNo = $prefix . $yearNo . $separator . $monthNo . $runNoText;

	try {
		$insertStmt = mysqli_prepare($conn, $insertSql);
		mysqli_stmt_bind_param($insertStmt, 'sssss', $docNo, $yearNo, $monthNo, $runNoText, $ivDate);
		mysqli_stmt_execute($insertStmt);
		mysqli_stmt_close($insertStmt);

		echo json_encode([
			'success'  => true,
			'doc_no'   => $docNo,
			'run_no'   => $runNoText,
			'doc_type' => $prefix,
			'company'  => $company,
			'year_no'  => $yearNo,
			'mount_no' => $monthNo
		], JSON_UNESCAPED_UNICODE);
		exit;
	} catch (mysqli_sql_exception $e) {
		// 1062 เกิดได้เฉพาะตาราง IV ที่มี unique index และมีหน้าจออื่นแทรกเข้ามาพอดี
		if ($e->getCode() == 1062) {
			continue;
		}
		throw $e;
	}
}

run_doc_no_fail('ไม่สามารถออกเลขที่เอกสารได้ (เลขชนกันเกิน ' . $maxAttempts . ' ครั้ง) กรุณาลองใหม่อีกครั้ง', 409);
