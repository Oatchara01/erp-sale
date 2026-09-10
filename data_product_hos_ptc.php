<?php
header("Content-type:text/html; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
include "dbconnect.php";

/* Autocomplete เฉพาะช่องค้นหาสินค้าใน partials/product_table_change.php (แผนกไม่ใช่วิศวกรรม)
   ต่างจาก data_product_hos.php เดิมที่ใช้ endpoint นี้ร่วมกับหน้าอื่นอีก 100+ หน้า:
   ค้นจาก sol_name แทน access_name, บังคับ close_pro='0' และตัด group1 8001/8002 ออก
   ให้ตรง rule เดียวกับ data_product_hos1_ptc.php (detail lookup ตอนเลือกสินค้า) */
$product_code_search = urldecode($_GET["product_code_search"]);
$search_escaped = mysqli_real_escape_string($conn, $product_code_search);
$type_company = (isset($_GET['type_company']) && $_GET['type_company'] === 'NBM') ? 'NBM' : 'AWL';

$pagesize = 50;
$sql = "SELECT access_code, sol_name FROM tb_product
	WHERE sale_ckk = '1'
		AND type_company = '$type_company'
		AND close_pro = '0'
		AND group1 NOT IN (8001,8002)
		AND (LOCATE('$search_escaped', access_code) > 0 OR LOCATE('$search_escaped', sol_name) > 0)
	ORDER BY
		CASE
			WHEN access_code = '$search_escaped' THEN 0
			WHEN LOCATE('$search_escaped', access_code) = 1 THEN 1
			WHEN LOCATE('$search_escaped', access_code) > 0 THEN 2
			WHEN LOCATE('$search_escaped', sol_name) = 1 THEN 3
			ELSE 4
		END,
		sol_name
	LIMIT $pagesize";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
	$access_code = $row["access_code"];
	$sol_name = $row["sol_name"];

	$sol_name_esc = htmlspecialchars($sol_name, ENT_QUOTES, 'UTF-8');
	$search_esc = htmlspecialchars($product_code_search, ENT_QUOTES, 'UTF-8');
	$display_name = ($search_esc !== '')
		? preg_replace("/(" . preg_quote($search_esc, "/") . ")/iu", "<b>$1</b>", $sol_name_esc)
		: $sol_name_esc;

	$access_code_js = json_encode($access_code, JSON_UNESCAPED_UNICODE);
	$onselect = htmlspecialchars("this.setText({$access_code_js}).setValue({$access_code_js});", ENT_QUOTES, 'UTF-8');
	echo "<li onselect=\"$onselect\">$display_name</li>";
}
