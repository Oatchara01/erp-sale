<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   

//province name auto complete
$product_code_search = urldecode($_GET["product_code_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_product"; // ตารางที่ต้องการค้นหา
$find_field="sol_name"; // ฟิลที่ต้องการค้นหา

// ตัดเครื่องหมาย " ออกก่อน เพื่อไม่ให้ syntax ของ MATCH...AGAINST phrase search พัง
$term = str_replace('"', '', $product_code_search);

// บริษัทที่ต้องการ filter (whitelist AWL/NBM, default AWL เพื่อให้ผู้เรียกเดิมที่ไม่ส่ง param ทำงานเหมือนเดิม)
$type_company = (isset($_GET['type_company']) && $_GET['type_company'] === 'NBM') ? 'NBM' : 'AWL';

$ngram_min_len = 2; // ต้องตรงกับ ngram_token_size ของ MySQL server

if ($term === '') {
	// ยังไม่พิมพ์คำค้นหา (เช่นคลิกช่องค้นหาเฉยๆ) -> แสดงรายการตามชื่อ ไม่ใช้ MATCH/LOCATE
	$where_sql = "sale_ckk='1' and demo_ckk='0' and type_company = ? and close_pro ='0'";
	$sql = "select * from $table_db where $where_sql order by $find_field limit $pagesize";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, "s", $type_company);
	$count_sql = "select count(*) as total from $table_db where $where_sql";
	$count_stmt = mysqli_prepare($conn, $count_sql);
	mysqli_stmt_bind_param($count_stmt, "s", $type_company);
} elseif (mb_strlen($term, 'UTF-8') < $ngram_min_len) {
	// คำค้นสั้นกว่า ngram token size -> FULLTEXT หาไม่เจอเลย ต้อง fallback ไปใช้ locate() เหมือนเดิม
	$where_sql = "sale_ckk='1' and demo_ckk='0' and type_company = ? and close_pro ='0' and locate(?, $find_field) > 0";
	$sql = "select * from $table_db where $where_sql order by locate(?, $find_field), $find_field limit $pagesize";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, "sss", $type_company, $term, $term);
	$count_sql = "select count(*) as total from $table_db where $where_sql";
	$count_stmt = mysqli_prepare($conn, $count_sql);
	mysqli_stmt_bind_param($count_stmt, "ss", $type_company, $term);
} else {
	// ใช้ FULLTEXT (ngram parser) แทน locate() เพื่อให้ query ใช้ index ได้ รองรับข้อมูลจำนวนมาก
	$phrase = '"' . $term . '"';
	$where_sql = "sale_ckk='1' and demo_ckk='0' and type_company = ? and close_pro ='0' and match($find_field) against(? in boolean mode)";
	$sql = "select * from $table_db where $where_sql order by match($find_field) against(? in boolean mode) desc, $find_field limit $pagesize";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, "sss", $type_company, $phrase, $phrase);
	$count_sql = "select count(*) as total from $table_db where $where_sql";
	$count_stmt = mysqli_prepare($conn, $count_sql);
	mysqli_stmt_bind_param($count_stmt, "ss", $type_company, $phrase);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

mysqli_stmt_execute($count_stmt);
$total_count = mysqli_fetch_assoc(mysqli_stmt_get_result($count_stmt))['total'];

while ($row = mysqli_fetch_array( $result )) {
	$access_name = $row["sol_name"]; // ฟิลที่ต้องการส่งค่ากลับ
	$access_code =$row["access_code"]; // ฟิลที่ต้องการแสดงค่า

	// ป้องกันเครื่องหมาย '
	$access_name = str_replace("'", "\\'", $access_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = $term === '' ? $access_name : preg_replace("/(" . preg_quote($term, "/") . ")/iu", "<b>$1</b>", $access_name);
	echo "<li onselect=\"this.setText('$access_code').setValue('$access_code');\">$display_name</li>";
}

if ($total_count > $pagesize) {
	echo "<li style=\"color:#999;font-style:italic;cursor:default;\">แสดง $pagesize จาก $total_count รายการ พิมพ์คำค้นหาให้เจาะจงขึ้นเพื่อจำกัดผลลัพธ์</li>";
}
?>