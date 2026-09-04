<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include "dbconnect.php";   

// ป้องกัน TypeError บน PHP 8+ เมื่อไม่มี $_GET['product_code_search']
$raw_search = isset($_GET["product_code_search"]) ? $_GET["product_code_search"] : '';
$product_code_search = urldecode($raw_search);

// บริษัทที่ต้องการ filter (whitelist AWL/NBM, default AWL)
$type_company = (isset($_GET['type_company']) && $_GET['type_company'] === 'NBM') ? 'NBM' : 'AWL';

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง

// Escape เพื่อป้องกัน SQL Injection
$search_escaped = mysqli_real_escape_string($conn, trim($product_code_search));
$type_company_escaped = mysqli_real_escape_string($conn, $type_company);

if ($search_escaped === '') {
	$sql = "SELECT access_code, sol_name FROM tb_product WHERE sale_ckk='1' AND demo_ckk='0' AND type_company = '$type_company_escaped' AND close_pro ='0' AND group1 NOT IN (8002,8001) ORDER BY sol_name LIMIT $pagesize";
	$count_sql = "SELECT COUNT(*) as total FROM tb_product WHERE sale_ckk='1' AND demo_ckk='0' AND type_company = '$type_company_escaped' AND close_pro ='0' AND group1 NOT IN (8002,8001)";
} else {
	$sql = "SELECT access_code, sol_name FROM tb_product WHERE sale_ckk='1' AND demo_ckk='0' AND type_company = '$type_company_escaped' AND close_pro ='0' AND group1 NOT IN (8002,8001) AND (LOCATE('$search_escaped', sol_name) > 0 OR LOCATE('$search_escaped', access_code) > 0) ORDER BY LOCATE('$search_escaped', sol_name), sol_name LIMIT $pagesize";
	$count_sql = "SELECT COUNT(*) as total FROM tb_product WHERE sale_ckk='1' AND demo_ckk='0' AND type_company = '$type_company_escaped' AND close_pro ='0' AND group1 NOT IN (8002,8001) AND (LOCATE('$search_escaped', sol_name) > 0 OR LOCATE('$search_escaped', access_code) > 0)";
}

$result = mysqli_query($conn, $sql);
$count_res = mysqli_query($conn, $count_sql);
$total_count = ($count_res && $row_count = mysqli_fetch_assoc($count_res)) ? (int)$row_count['total'] : 0;

if ($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$access_name = $row["sol_name"]; // ฟิลที่ต้องการส่งค่ากลับ
		$access_code = $row["access_code"]; // ฟิลที่ต้องการแสดงค่า

		// Escape สำหรับใส่ใน JS และ HTML attributes ป้องกัน XSS / Syntax พัง
		$js_access_code = addslashes($access_code);

		// Escape ชื่อสำหรับการแสดงผล HTML
		$safe_access_name = htmlspecialchars($access_name, ENT_QUOTES, 'UTF-8');

		// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
		$display_name = ($product_code_search === '') 
			? $safe_access_name 
			: preg_replace("/(" . preg_quote(htmlspecialchars($product_code_search, ENT_QUOTES, 'UTF-8'), "/") . ")/iu", "<b>$1</b>", $safe_access_name);

		echo "<li onselect=\"this.setText('" . htmlspecialchars($js_access_code, ENT_QUOTES, 'UTF-8') . "').setValue('" . htmlspecialchars($js_access_code, ENT_QUOTES, 'UTF-8') . "');\">$display_name</li>";
	}
}

if ($total_count > $pagesize) {
	echo "<li style=\"color:#999;font-style:italic;cursor:default;\">แสดง $pagesize จาก $total_count รายการ พิมพ์คำค้นหาให้เจาะจงขึ้นเพื่อจำกัดผลลัพธ์</li>";
}
?>