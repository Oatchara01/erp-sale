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
 * 2) โหมดนับจากตารางเอกสารจริง ($docSourceTable) — BRSC/JN/EXC
 *    BRSC69080001 -> BRSC6908001   <- ซีรีส์เดียวทั้ง AWL/NBM ไม่มีตัวคั่น running 3 หลัก
 *    EXC6909001 / EXCN6909001      <- แยก prefix ตามบริษัท (AWL=EXC, NBM=EXCN)
 *    ไม่มี INSERT จองเลข อ่าน MAX จากคอลัมน์เลขที่เอกสารในตารางเอกสารโดยตรง
 *    เลขจึงถูกจองจริงตอนกดบันทึกเอกสาร (กันเลขซ้ำอีกชั้นที่ register_supbrcshos1.php
 *    และ register_supbrcshos_edit1.php / register_supchange1.php และ
 *    register_supchange_edit1.php) และการกด Run ซ้ำก่อนบันทึกจะได้เลขเดิมเสมอ
 *
 * 3) โหมดตารางตัวนับกลาง ($docSharedCounterTable) — BRES/BREQ (register_supbrhos.php)
 *    ใช้ตาราง "tb_docbreng" ร่วมกับตัวนับของระบบเดิม เพื่อให้เลขออกเป็น series เดียวกัน
 *    ตารางนี้ถูกใช้ร่วมกับหลายโมดูล จึงต้องกรอง/ล็อกด้วย head_no แทนชื่อตาราง
 *    เลขถูกจองทันทีที่กดปุ่ม (INSERT เลย) เหมือนโหมด 1
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
	'6' => 'EXC', // ใบเปลี่ยนสินค้า (register_supchange.php) - เอกสารประเภทเดียวของหน้านั้น
	'7' => 'JN', // ใบเช่า (register_suprental.php) - เอกสารประเภทเดียวของหน้านั้น
	'8' => 'BRES', // Borrow Order (register_supbrhos.php) type_breng=1
	'9' => 'BREQ', // Borrow Order (register_supbrhos.php) type_breng=2
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
// EXC/EXCN (ใบเปลี่ยนสินค้า) เข้าโหมดนี้ด้วย แต่แยก series ตามบริษัทผ่าน prefixByCompany
// เพราะ AWL ใช้ prefix 'EXC' และ NBM ใช้ 'EXCN' (เลขจริงทั้งหมดอยู่ใน hos__change.iv_no)
// ชื่อตาราง/คอลัมน์/prefix มาจาก whitelist นี้เท่านั้น จึงนำไปต่อใน SQL ได้อย่างปลอดภัย
$docSourceTable = [
	'BRSC' => [
		'table'     => 'hos__consig',
		'column'    => 'iv_no',
		'companies' => ['3', '4'],
		'separator' => '',
		'pad'       => 3,
	],
	'JN' => [
		'table'     => 'hos__rental',
		'column'    => 'iv_no',
		'companies' => ['3', '4'],
		'separator' => '',
		'pad'       => 3,
	],
	// เลิกใช้ตารางตัวนับ tb_docbreng แล้ว — ฝั่ง Admin อนุมัติ (register_adminchange_edit1.php)
	// นับจาก hos__change.iv_no ชุดเดียวกัน เลขจึงเป็น series เดียวกันโดยไม่ต้องจองล่วงหน้า
	'EXC' => [
		'table'           => 'hos__change',
		'column'          => 'iv_no',
		'prefixByCompany' => ['3' => 'EXC', '4' => 'EXCN'],
		'companies'       => ['3', '4'],
		'separator'       => '',
		'pad'             => 3,
	],
];

// เอกสารที่ใช้ตารางตัวนับกลาง "tb_docbreng" ร่วมกับหลายโมดูล (BREG/BRES/BREQ/BRNP/...)
// เลขถูกจองทันทีที่กดปุ่ม เพราะระบบเดิมของโมดูลเหล่านั้นนับจากตารางนี้ ถ้าไม่จองจะชนกัน
// ตารางนี้ใช้คอลัมน์ run_iv (ไม่ใช่ run_no) และมีคอลัมน์ head_no ไว้กรองแยกโมดูล/บริษัท
// แทนที่จะแยกเป็นคนละตาราง — ชื่อตาราง/คอลัมน์มาจาก whitelist นี้เท่านั้น จึงนำไปต่อใน SQL ได้อย่างปลอดภัย
$docSharedCounterTable = [
	'BRES' => [
		'table'            => 'tb_docbreng',
		'column'           => 'run_iv',
		'headNoByCompany'  => ['3' => 'BRES', '4' => 'BRESN'],
		'companies'        => ['3', '4'],
		'separator'        => '',
		'pad'              => 3,
	],
	'BREQ' => [
		'table'            => 'tb_docbreng',
		'column'           => 'run_iv',
		'headNoByCompany'  => ['3' => 'BREQ', '4' => 'BREQN'],
		'companies'        => ['3', '4'],
		'separator'        => '',
		'pad'              => 3,
	],
];

$company = trim((string)($_POST['company'] ?? ''));
$docType = trim((string)($_POST['doc_type'] ?? ''));
$docDate = trim((string)($_POST['doc_date'] ?? ''));
$refId   = trim((string)($_POST['ref_id'] ?? '')); // ใช้เฉพาะโหมดตารางตัวนับกลาง (tb_docbreng.ref_id)

if (!isset($docTypePrefix[$docType])) {
	run_doc_no_fail('กรุณาเลือกประเภทเอกสารก่อนออกเลขที่เอกสาร');
}
$prefix = $docTypePrefix[$docType];

$sourceConfig = $docSourceTable[$prefix] ?? null;
$isSourceTableMode = ($sourceConfig !== null);

$sharedConfig = $docSharedCounterTable[$prefix] ?? null;
$isSharedCounterMode = ($sharedConfig !== null);

$headNo = null;
// prefix ที่ใช้ประกอบเลขที่เอกสารจริง — ปกติเท่ากับ $prefix ยกเว้นโหมดตารางเอกสารจริงที่แยก
// prefix ตามบริษัท (EXC = AWL, EXCN = NBM) ซึ่งเป็นคนละ series กัน
$docPrefix = $prefix;

if ($isSourceTableMode) {
	if (!in_array($company, $sourceConfig['companies'], true)) {
		run_doc_no_fail('กรุณาเลือกบริษัทก่อนออกเลขที่เอกสาร');
	}
	$table     = $sourceConfig['table'];
	$column    = $sourceConfig['column'];
	$separator = $sourceConfig['separator'];
	$runPad    = $sourceConfig['pad'];
	if (isset($sourceConfig['prefixByCompany'])) {
		if (!isset($sourceConfig['prefixByCompany'][$company])) {
			run_doc_no_fail('กรุณาเลือกบริษัทก่อนออกเลขที่เอกสาร');
		}
		$docPrefix = $sourceConfig['prefixByCompany'][$company];
	}
} elseif ($isSharedCounterMode) {
	if (!isset($sharedConfig['headNoByCompany'][$company])) {
		run_doc_no_fail('กรุณาเลือกบริษัทก่อนออกเลขที่เอกสาร');
	}
	$table     = $sharedConfig['table'];
	$column    = $sharedConfig['column'];
	$separator = $sharedConfig['separator'];
	$runPad    = $sharedConfig['pad'];
	$headNo    = $sharedConfig['headNoByCompany'][$company];
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

// วันที่ออกเอกสารต้องกรอกมาก่อนเสมอ (เดิม fallback เป็นวันที่ปัจจุบันถ้าไม่กรอก/parse ไม่ได้
// ทำให้เลขที่ออกไปอิงเดือน/ปีผิดจากที่ผู้ใช้ตั้งใจ) — validate ซ้ำฝั่ง server เพราะ client
// เรียก endpoint นี้ตรง ๆ ได้โดยไม่ผ่านปุ่ม
if ($docDate === '') {
	run_doc_no_fail('กรุณาใส่วันที่ออกเอกสารก่อนออกเลขที่เอกสาร');
}
date_default_timezone_set('Asia/Bangkok');
$timestamp = strtotime($docDate);
if ($timestamp === false) {
	run_doc_no_fail('กรุณาใส่วันที่ออกเอกสารก่อนออกเลขที่เอกสาร');
}
$yearNo  = substr((string)((int)date('Y', $timestamp) + 543), -2);
$monthNo = date('m', $timestamp);
$ivDate  = date('Y-m-d', $timestamp);

// กันสองคนกดพร้อมกันด้วย named lock แทนการเพิ่ม unique index ให้ตารางเดิม
// (ตารางเดิมมีไฟล์อื่นเขียนร่วมอีกกว่า 30 ไฟล์ การใส่ unique index จะทำให้ไฟล์เหล่านั้น
//  fatal error แทนที่จะ insert ซ้ำเงียบ ๆ จึงไม่แตะ schema เดิม)
// โหมดตารางเอกสารจริงล็อกด้วย $docPrefix ไม่ใช่ $company เพราะเลขเป็นซีรีส์ตาม prefix
// BRSC/JN เป็นซีรีส์เดียวทุกบริษัท ($docPrefix เท่ากับ $prefix) ถ้าใส่ $company จะไม่บล็อกกัน
// และได้เลขเดียวกัน ส่วน EXC/EXCN แยก series ตามบริษัทอยู่แล้วผ่าน $docPrefix
// (docrun_EXC_6909 / docrun_EXCN_6909 — register_adminchange_edit1.php ใช้ชื่อเดียวกัน
//  จึงบล็อกกันข้ามหน้าจอระหว่างฝั่งขายกดปุ่ม Run กับฝั่ง Admin อนุมัติ)
// โหมดตารางตัวนับกลาง (tb_docbreng) ใช้ $headNo แทน $prefix เพราะตารางเดียวกันถูกใช้ร่วมกับ
// โมดูลอื่น (BREG/BRES/BREQ/BRNP) — ต้องล็อกแยกตาม head_no ไม่งั้นจะบล็อกกันข้ามโมดูลโดยไม่จำเป็น
if ($isSourceTableMode) {
	$lockName = 'docrun_' . $docPrefix . '_' . $yearNo . $monthNo;
} elseif ($isSharedCounterMode) {
	$lockName = 'docrun_' . $headNo . '_' . $yearNo . $monthNo;
} else {
	$lockName = 'docrun_' . $company . '_' . $prefix . '_' . $yearNo . $monthNo;
}
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
// เลขที่เอกสารเอง (BRSC6908% / EXC6909% / EXCN6909%) แล้วตัดเฉพาะส่วน running มาหา MAX
// EXC กับ EXCN ไม่ชนกันเอง เพราะ 'EXCN6909001' ไม่ match LIKE 'EXC6909%' (ตัวที่ 4 เป็น N ไม่ใช่ 6)
// ค่า iv_no เดิมที่ผู้ใช้พิมพ์เองรูปแบบอื่น (เช่น TEST-DOC-001) จึงไม่ถูกนับเข้ามาด้วย
if ($isSourceTableMode) {
	$docPrefixText = $docPrefix . $yearNo . $separator . $monthNo;
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
		'doc_type' => $docPrefix,
		'company'  => $company,
		'year_no'  => $yearNo,
		'mount_no' => $monthNo
	], JSON_UNESCAPED_UNICODE);
	exit;
}

// โหมดตารางตัวนับกลาง (tb_docbreng): มี year_no/month_no ให้กรองเหมือน docRouting ปกติ
// แต่ต้องกรอง head_no เพิ่ม (ตารางเดียวใช้ร่วมกับ BREG/BRES/BREQ/BRNP ฯลฯ) และ insert คอลัมน์
// ref_id ตาม pattern เดิมของระบบ Borrow Order — เลขถูกจองทันทีที่กดปุ่ม
// เหมือนโหมด IV/ET/IC (ไม่ใช่ preview เฉย ๆ)
if ($isSharedCounterMode) {
	$selectStmt = mysqli_prepare(
		$conn,
		"SELECT MAX(CAST(`" . $column . "` AS UNSIGNED)) AS max_run FROM `" . $table . "` WHERE head_no = ? AND month_no = ? AND year_no = ?"
	);
	mysqli_stmt_bind_param($selectStmt, 'sss', $headNo, $monthNo, $yearNo);
	mysqli_stmt_execute($selectStmt);
	$selectResult = mysqli_stmt_get_result($selectStmt);
	$maxRow = $selectResult ? mysqli_fetch_assoc($selectResult) : null;
	mysqli_stmt_close($selectStmt);

	$runNo = (int)($maxRow['max_run'] ?? 0) + 1;
	$runNoText = substr(str_repeat('0', $runPad) . $runNo, -$runPad);
	$docNo = $headNo . $yearNo . $separator . $monthNo . $runNoText;

	$insertStmt = mysqli_prepare(
		$conn,
		"INSERT INTO `" . $table . "` (head_no, doc_no, year_no, month_no, `" . $column . "`, ref_id) VALUES (?, ?, ?, ?, ?, ?)"
	);
	mysqli_stmt_bind_param($insertStmt, 'ssssss', $headNo, $docNo, $yearNo, $monthNo, $runNoText, $refId);
	mysqli_stmt_execute($insertStmt);
	mysqli_stmt_close($insertStmt);

	echo json_encode([
		'success'  => true,
		'doc_no'   => $docNo,
		'run_no'   => $runNoText,
		'doc_type' => $headNo,
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
