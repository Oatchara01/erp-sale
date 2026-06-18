<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   

//province name auto complete
$product_code_search = urldecode($_GET["product_code_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_product"; // ตารางที่ต้องการค้นหา
$find_field="access_name"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$sol_name = $row["access_name"]; // ฟิลที่ต้องการส่งค่ากลับ
	$sol_code =$row["sol_code"]; // ฟิลที่ต้องการแสดงค่า	

	// ป้องกันเครื่องหมาย '
	$sol_name = str_replace("'", "'", $sol_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $sol_name);
	echo "<li onselect=\"this.setText('$sol_name').setValue('$sol_name');\">$display_name</li>";
}
?>