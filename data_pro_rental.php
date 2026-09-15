<?php
header("Content-type:text/html; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

include "dbconnect.php";

$raw_search = isset($_GET['product_code_search']) ? $_GET['product_code_search'] : '';
$product_code_search = urldecode($raw_search);
$search_escaped = mysqli_real_escape_string($conn, trim($product_code_search));
$pagesize = 50;

$type_company = isset($_GET['type_company']) ? trim($_GET['type_company']) : '';
if ($type_company !== 'NBM') {
	$type_company = 'AWL';
}
$type_company_escaped = mysqli_real_escape_string($conn, $type_company);

$where = "group1 = '8001' AND type_company = '$type_company_escaped' AND close_pro = '0'";

if ($search_escaped === '') {
	$sql = "SELECT access_code, sol_name FROM tb_product WHERE $where ORDER BY sol_name LIMIT $pagesize";
	$count_sql = "SELECT COUNT(*) AS total FROM tb_product WHERE $where";
} else {
	$search_condition = "(LOCATE('$search_escaped', sol_name) > 0 OR LOCATE('$search_escaped', access_code) > 0)";
	$sql = "SELECT access_code, sol_name FROM tb_product WHERE $where AND $search_condition ORDER BY LOCATE('$search_escaped', sol_name), sol_name LIMIT $pagesize";
	$count_sql = "SELECT COUNT(*) AS total FROM tb_product WHERE $where AND $search_condition";
}

$result = mysqli_query($conn, $sql);
$count_result = mysqli_query($conn, $count_sql);
$total_count = ($count_result && $count_row = mysqli_fetch_assoc($count_result)) ? (int) $count_row['total'] : 0;

if ($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$access_code = $row['access_code'];
		$safe_access_code = htmlspecialchars(addslashes($access_code), ENT_QUOTES, 'UTF-8');
		$safe_product_name = htmlspecialchars($row['sol_name'], ENT_QUOTES, 'UTF-8');

		$display_name = ($product_code_search === '')
			? $safe_product_name
			: preg_replace(
				"/(" . preg_quote(htmlspecialchars($product_code_search, ENT_QUOTES, 'UTF-8'), "/") . ")/iu",
				"<b>$1</b>",
				$safe_product_name
			);

		echo "<li onselect=\"this.setText('$safe_access_code').setValue('$safe_access_code');\">$display_name</li>";
	}
}

if ($total_count > $pagesize) {
	echo "<li style=\"color:#999;font-style:italic;cursor:default;\">แสดง $pagesize จาก $total_count รายการ พิมพ์คำค้นหาให้เจาะจงขึ้นเพื่อจำกัดผลลัพธ์</li>";
}
?>
