<?php



header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   


$product_code_search = urldecode($_GET["bill_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_customer"; // ตารางที่ต้องการค้นหา
$find_field="bill_name"; // ฟิลที่ต้องการค้นหา 
$sql = "select * from $table_db  where  customer_id !='799' and customer_id !='678' and locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";

$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$bill_name = $row["bill_name"];
	$customer_id = $row["customer_id"];

	$bill_name = str_replace("'", "'", $bill_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $bill_name);
	echo "<li onselect=\"this.setText('$bill_name').setValue('$customer_id');\">$display_name</li>";
}



?>