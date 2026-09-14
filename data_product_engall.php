<?php
/**
 * Autocomplete สินค้าสำหรับช่องค้นหาช่องเดียวของฟอร์ม BREG ใหม่ (register_bregawl.php)
 *
 * รวมความสามารถของ 3 endpoint เดิมที่หน้า BREG เคยใช้ช่องละตัว —
 *   data_product_engi.php  (รหัสสินค้า / access_code)
 *   data_product_eng.php   (ชื่ออังกฤษ / access_name)
 *   data_product_ength.php (ชื่อไทย / sol_name)
 * ทั้งสามใช้เงื่อนไข eligibility ชุดเดียวกันอยู่แล้ว
 * (engineer_ckk = '1' AND type_company AND close_pro = '0') จึงรวมเป็นช่องเดียวได้
 * โดยไม่เปลี่ยนขอบเขตสินค้าที่ผู้ใช้เคยค้นเจอ
 *
 * แยกไฟล์ใหม่แทนการแก้ 3 ไฟล์เดิม เพราะหน้าอื่นอีกหลายสิบหน้ายังผูกกับ endpoint เดิมอยู่
 */

header("Content-type:text/html; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
include "dbconnect.php";

$product_code_search = urldecode(isset($_GET["product_code_search"]) ? $_GET["product_code_search"] : '');
$search_escaped = mysqli_real_escape_string($conn, $product_code_search);
$type_company = (isset($_GET['type_company']) && $_GET['type_company'] === 'NBM') ? 'NBM' : 'AWL';

if (trim($product_code_search) === '') {
	exit;
}

$pagesize = 50;
$sql = "SELECT access_code, access_name, sol_name, unit_name
		FROM tb_product
		WHERE engineer_ckk = '1'
		  AND type_company = '$type_company'
		  AND close_pro = '0'
		  AND (LOCATE('$search_escaped', access_code) > 0
			   OR LOCATE('$search_escaped', access_name) > 0
			   OR LOCATE('$search_escaped', sol_name) > 0)
		ORDER BY LOCATE('$search_escaped', access_code) = 1 DESC,
				 LOCATE('$search_escaped', access_code) > 0 DESC,
				 access_code ASC
		LIMIT $pagesize";

$result = mysqli_query($conn, $sql);
if (!$result) {
	exit;
}

while ($row = mysqli_fetch_array($result)) {
	$access_code = (string)$row["access_code"];
	// ชื่อที่แสดงในผลลัพธ์ใช้ชื่อไทย (sol_name) ตัวเดียวกับที่ตารางรายการแสดงหลังเลือก
	// ถ้าไม่มีค่อย fallback ไปชื่ออังกฤษ
	$display_source = trim((string)$row["sol_name"]) !== '' ? $row["sol_name"] : $row["access_name"];

	$label = htmlspecialchars($access_code . ' — ' . $display_source, ENT_QUOTES, 'UTF-8');
	$display_name = preg_replace(
		"/(" . preg_quote(htmlspecialchars($product_code_search, ENT_QUOTES, 'UTF-8'), "/") . ")/iu",
		"<b>$1</b>",
		$label
	);

	// setText/setValue คืน access_code เสมอ — ฝั่งหน้าเว็บเอาไปยิง data_product_hos1.php ต่อ
	// escape 2 ชั้น: ชั้นใน = JS string literal, ชั้นนอก = ค่าใน HTML attribute
	$js_code = str_replace(array('\\', "'"), array('\\\\', "\\'"), $access_code);
	$safe_code = htmlspecialchars($js_code, ENT_QUOTES, 'UTF-8');
	echo "<li onselect=\"this.setText('$safe_code').setValue('$safe_code');\">$display_name</li>";
}
