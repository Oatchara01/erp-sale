<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   

//province name auto complete
$customer_code_search = urldecode($_GET["customer_code_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_customer"; // ตารางที่ต้องการค้นหา
$find_field="customer_name"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where locate('$customer_code_search', $find_field) > 0 order by locate('$customer_code_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$customer_name = $row["customer_name"]; // ฟิลที่ต้องการส่งค่ากลับ
	$customer_id =$row["customer_id"];
	// ป้องกันเครื่องหมาย '
	$customer_name = str_replace("'", "'", $customer_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $customer_code_search . ")/iu", "<b>$1</b>", $customer_name);
	echo "<li onselect=\"this.setText('$customer_id').setValue('$customer_id');\">$display_name</li>";
}
?>