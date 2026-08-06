<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include "dbconnect.php";   

// ป้องกัน TypeError บน PHP 8+ เมื่อไม่มี $_GET['product_code_search']
$raw_search = isset($_GET["product_code_search"]) ? $_GET["product_code_search"] : '';
$product_code_search = urldecode($raw_search);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db = "tb_product"; // ตารางที่ต้องการค้นหา
$find_field = "sol_name"; // ฟิลที่ต้องการค้นหา

// ตัดเครื่องหมาย " ออกก่อน เพื่อไม่ให้ syntax ของ MATCH...AGAINST phrase search พัง
$term = str_replace('"', '', $product_code_search);

// บริษัทที่ต้องการ filter (whitelist AWL/NBM, default AWL เพื่อให้ผู้เรียกเดิมที่ไม่ส่ง param ทำงานเหมือนเดิม)
$type_company = (isset($_GET['type_company']) && $_GET['type_company'] === 'NBM') ? 'NBM' : 'AWL';

$ngram_min_len = 2; // ต้องตรงกับ ngram_token_size ของ MySQL server

// ฟังก์ชัน helper สำหรับเตรียม statement แบบมี fallback เพื่อป้องกัน HTTP 500
function getPreparedSearchStatements($conn, $table_db, $find_field, $term, $type_company, $pagesize, $ngram_min_len) {
	if ($term === '') {
		$where_sql = "sale_ckk='1' and demo_ckk='0' and type_company = ? and close_pro ='0'";
		$sql = "select * from $table_db where $where_sql order by $find_field limit $pagesize";
		$stmt = mysqli_prepare($conn, $sql);
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, "s", $type_company);
			$count_sql = "select count(*) as total from $table_db where $where_sql";
			$count_stmt = mysqli_prepare($conn, $count_sql);
			if ($count_stmt) {
				mysqli_stmt_bind_param($count_stmt, "s", $type_company);
				return array($stmt, $count_stmt);
			}
		}
	} elseif (mb_strlen($term, 'UTF-8') >= $ngram_min_len) {
		// ลองใช้ FULLTEXT ค้นหา
		$phrase = '"' . $term . '"';
		$where_sql = "sale_ckk='1' and demo_ckk='0' and type_company = ? and close_pro ='0' and match($find_field) against(? in boolean mode)";
		$sql = "select * from $table_db where $where_sql order by match($find_field) against(? in boolean mode) desc, $find_field limit $pagesize";
		$stmt = mysqli_prepare($conn, $sql);
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, "sss", $type_company, $phrase, $phrase);
			$count_sql = "select count(*) as total from $table_db where $where_sql";
			$count_stmt = mysqli_prepare($conn, $count_sql);
			if ($count_stmt) {
				mysqli_stmt_bind_param($count_stmt, "ss", $type_company, $phrase);
				return array($stmt, $count_stmt);
			}
		}
	}

	// Fallback: ใช้ locate() หาก FULLTEXT ล้มเหลว (เช่นไม่มี index) หรือคำค้นสั้นกว่า $ngram_min_len
	$where_sql = "sale_ckk='1' and demo_ckk='0' and type_company = ? and close_pro ='0' and locate(?, $find_field) > 0";
	$sql = "select * from $table_db where $where_sql order by locate(?, $find_field), $find_field limit $pagesize";
	$stmt = mysqli_prepare($conn, $sql);
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, "sss", $type_company, $term, $term);
	}
	$count_sql = "select count(*) as total from $table_db where $where_sql";
	$count_stmt = mysqli_prepare($conn, $count_sql);
	if ($count_stmt) {
		mysqli_stmt_bind_param($count_stmt, "ss", $type_company, $term);
	}

	return array($stmt, $count_stmt);
}

list($stmt, $count_stmt) = getPreparedSearchStatements($conn, $table_db, $find_field, $term, $type_company, $pagesize, $ngram_min_len);

if (!$stmt || !$count_stmt) {
	// ป้องกันการล่มเมื่อ Database เกิดข้อผิดพลาดในการ prepare
	exit();
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

mysqli_stmt_execute($count_stmt);
$count_res = mysqli_stmt_get_result($count_stmt);
$total_count = ($count_res && $row_count = mysqli_fetch_assoc($count_res)) ? $row_count['total'] : 0;

while ($row = mysqli_fetch_array($result)) {
	$access_name = $row["sol_name"]; // ฟิลที่ต้องการส่งค่ากลับ
	$access_code = $row["access_code"]; // ฟิลที่ต้องการแสดงค่า

	// Escape สำหรับใส่ใน JS และ HTML attributes ป้องกัน XSS / Syntax พัง
	$js_access_code = addslashes($access_code);

	// Escape ชื่อสำหรับการแสดงผล HTML
	$safe_access_name = htmlspecialchars($access_name, ENT_QUOTES, 'UTF-8');

	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = ($term === '') 
		? $safe_access_name 
		: preg_replace("/(" . preg_quote(htmlspecialchars($term, ENT_QUOTES, 'UTF-8'), "/") . ")/iu", "<b>$1</b>", $safe_access_name);

	echo "<li onselect=\"this.setText('" . htmlspecialchars($js_access_code, ENT_QUOTES, 'UTF-8') . "').setValue('" . htmlspecialchars($js_access_code, ENT_QUOTES, 'UTF-8') . "');\">$display_name</li>";
}

if ($total_count > $pagesize) {
	echo "<li style=\"color:#999;font-style:italic;cursor:default;\">แสดง $pagesize จาก $total_count รายการ พิมพ์คำค้นหาให้เจาะจงขึ้นเพื่อจำกัดผลลัพธ์</li>";
}
?>